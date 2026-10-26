<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('pengembalian_buku', function (Blueprint $table) {
            $table->string('metode_pembayaran')->nullable()->default('kasir')->after('status_pembayaran');
            $table->string('order_id')->nullable()->unique()->after('metode_pembayaran');
            $table->string('snap_token')->nullable()->after('order_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengembalian_buku', function (Blueprint $table) {
            $table->dropColumn(['metode_pembayaran', 'order_id', 'snap_token']);
        });
    }
};
