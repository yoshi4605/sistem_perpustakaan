<?php

namespace App\Http\Controllers;

use App\Models\Pengembalian;
use App\Models\Pemberitahuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class DendaPaymentController extends Controller
{
    public function __construct()
    {
        // Setup konfigurasi Midtrans
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        \Midtrans\Config::$isProduction = config('midtrans.is_production');
        \Midtrans\Config::$isSanitized = config('midtrans.is_sanitized');
        \Midtrans\Config::$is3ds = config('midtrans.is_3ds');
    }

    /**
     * Generate Snap Token Midtrans untuk pembayaran denda
     */
    public function getSnapToken(Request $request, $id)
    {
        $pengembalian = Pengembalian::with(['peminjaman.buku', 'peminjaman.anggota.user'])->findOrFail($id);

        // Validasi kepemilikan denda
        $anggotaId = Auth::user()->Anggota->id ?? null;
        if ($pengembalian->peminjaman->anggota_id !== $anggotaId) {
            return response()->json([
                'status' => 'error',
                'message' => 'Anda tidak memiliki akses ke tagihan denda ini.'
            ], 403);
        }

        // Cek apakah denda sudah lunas
        if ($pengembalian->status_pembayaran === 'lunas') {
            return response()->json([
                'status' => 'error',
                'message' => 'Tagihan denda ini sudah lunas.'
            ], 400);
        }

        $grossAmount = (int) $pengembalian->jumlah_denda;
        if ($grossAmount <= 0) {
            return response()->json([
                'status' => 'error',
                'message' => 'Nominal denda tidak valid.'
            ], 400);
        }

        // Order ID unik: DENDA-{pengembalian_id}-{timestamp}
        $orderId = 'DENDA-' . $pengembalian->id . '-' . time();
        $user = Auth::user();
        $namaLengkap = $pengembalian->peminjaman->anggota->nama_lengkap ?? $user->username;
        $judulBuku = $pengembalian->peminjaman->buku->judul_buku ?? 'Buku Perpustakaan';

        $isDemo = false;
        $snapToken = null;

        // Cek apakah server key adalah placeholder/demo
        $serverKey = config('midtrans.server_key');
        if (empty($serverKey) || str_contains($serverKey, 'test-key-demo')) {
            $isDemo = true;
            $snapToken = 'DEMO-SNAP-' . strtoupper(bin2hex(random_bytes(8)));
        } else {
            try {
                $params = [
                    'transaction_details' => [
                        'order_id' => $orderId,
                        'gross_amount' => $grossAmount,
                    ],
                    'item_details' => [
                        [
                            'id' => 'DENDA-' . $pengembalian->id,
                            'price' => $grossAmount,
                            'quantity' => 1,
                            'name' => 'Denda: ' . mb_strimwidth($judulBuku, 0, 40, '...'),
                        ]
                    ],
                    'customer_details' => [
                        'first_name' => $namaLengkap,
                        'email' => $user->email,
                        'phone' => $user->no_telepon ?? '081234567890',
                    ],
                ];

                $snapToken = \Midtrans\Snap::getSnapToken($params);
            } catch (\Exception $e) {
                Log::warning('Midtrans Snap Exception (Falling back to simulated demo): ' . $e->getMessage());
                $isDemo = true;
                $snapToken = 'DEMO-SNAP-' . strtoupper(bin2hex(random_bytes(8)));
            }
        }

        // Simpan order_id dan snap_token ke database
        $pengembalian->update([
            'order_id' => $orderId,
            'snap_token' => $snapToken,
            'metode_pembayaran' => $isDemo ? 'online_demo' : 'online_midtrans',
        ]);

        return response()->json([
            'status' => 'success',
            'snap_token' => $snapToken,
            'order_id' => $orderId,
            'is_demo' => $isDemo,
            'client_key' => config('midtrans.client_key'),
            'denda_nominal' => $grossAmount,
            'judul_buku' => $judulBuku,
        ]);
    }

    /**
     * Konfirmasi pembayaran sukses (dipanggil frontend Snap onSuccess atau demo simulation)
     */
    public function paymentSuccess(Request $request)
    {
        $orderId = $request->input('order_id');
        $pengembalianId = $request->input('pengembalian_id');

        $pengembalian = null;
        if ($orderId) {
            $pengembalian = Pengembalian::where('order_id', $orderId)->first();
        }
        if (!$pengembalian && $pengembalianId) {
            $pengembalian = Pengembalian::find($pengembalianId);
        }

        if (!$pengembalian) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data tagihan denda tidak ditemukan.'
            ], 404);
        }

        if ($pengembalian->status_pembayaran !== 'lunas') {
            $dendaNominal = $pengembalian->jumlah_denda;
            $paymentType = $request->input('payment_type', 'qris');

            $pengembalian->update([
                'status_pembayaran' => 'lunas',
                'total_bayar' => $dendaNominal,
                'jumlah_bayar' => $dendaNominal,
                'jumlah_kembalian' => 0,
                'metode_pembayaran' => 'online_' . $paymentType,
            ]);

            // Kurangi saldo total denda anggota
            $anggota = $pengembalian->peminjaman->anggota ?? null;
            if ($anggota) {
                $anggota->total_denda = max(0, (int)$anggota->total_denda - $dendaNominal);
                $anggota->save();

                // Terbitkan notifikasi pemberitahuan
                $judulBuku = $pengembalian->peminjaman->buku->judul_buku ?? 'Buku Perpustakaan';
                $pesan = "Pembayaran denda secara online sebesar Rp " . number_format($dendaNominal, 0, ',', '.') . " untuk buku \"{$judulBuku}\" telah BERHASIL diproses.\n\n"
                    . "Rincian Transaksi:\n"
                    . "- No. Transaksi: " . ($pengembalian->order_id ?? ('TRX-' . time())) . "\n"
                    . "- Saluran Bayar: " . strtoupper($paymentType) . " (Online Gateway)\n"
                    . "- Status: Lunas & Terverifikasi Otomatis\n\n"
                    . "Terima kasih atas kepatuhan Anda mengembalikan koleksi perpustakaan.";

                Pemberitahuan::create([
                    'anggota_id' => $anggota->id,
                    'pesan' => $pesan,
                ]);
            }
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Pembayaran denda berhasil dikonfirmasi dan status otomatis lunas!',
        ]);
    }

    /**
     * Webhook HTTP Notification dari Server Midtrans
     */
    public function handleWebhook(Request $request)
    {
        $payload = $request->all();
        $orderId = $payload['order_id'] ?? null;
        $statusCode = $payload['status_code'] ?? null;
        $grossAmount = $payload['gross_amount'] ?? null;
        $signatureKey = $payload['signature_key'] ?? null;
        $transactionStatus = $payload['transaction_status'] ?? null;
        $paymentType = $payload['payment_type'] ?? 'qris';

        if (!$orderId) {
            return response()->json(['message' => 'Invalid order ID'], 400);
        }

        // Verifikasi Signature SHA512 jika bukan demo
        $serverKey = config('midtrans.server_key');
        if (!str_contains($serverKey, 'test-key-demo')) {
            $expectedSignature = hash('sha512', $orderId . $statusCode . $grossAmount . $serverKey);
            if ($signatureKey !== $expectedSignature) {
                return response()->json(['message' => 'Invalid signature'], 403);
            }
        }

        $pengembalian = Pengembalian::where('order_id', $orderId)->first();
        if (!$pengembalian) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        if ($transactionStatus === 'settlement' || $transactionStatus === 'capture') {
            if ($pengembalian->status_pembayaran !== 'lunas') {
                $dendaNominal = $pengembalian->jumlah_denda;

                $pengembalian->update([
                    'status_pembayaran' => 'lunas',
                    'total_bayar' => $dendaNominal,
                    'jumlah_bayar' => $dendaNominal,
                    'jumlah_kembalian' => 0,
                    'metode_pembayaran' => 'online_' . $paymentType,
                ]);

                $anggota = $pengembalian->peminjaman->anggota ?? null;
                if ($anggota) {
                    $anggota->total_denda = max(0, (int)$anggota->total_denda - $dendaNominal);
                    $anggota->save();

                    $judulBuku = $pengembalian->peminjaman->buku->judul_buku ?? 'Buku Perpustakaan';
                    Pemberitahuan::create([
                        'anggota_id' => $anggota->id,
                        'pesan' => "Pembayaran denda secara online sebesar Rp " . number_format($dendaNominal, 0, ',', '.') . " untuk buku \"{$judulBuku}\" telah LUNAS terverifikasi melalui Midtrans Webhook.\n\nNo. Order: {$orderId}\nMetode: " . strtoupper($paymentType),
                    ]);
                }
            }
        }

        return response()->json(['status' => 'OK']);
    }
}

