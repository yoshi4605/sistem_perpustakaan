<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('penerbits', function (Blueprint $table) {
            $table->string('logo')->nullable()->after('nama_penerbit');
        });
    }

    public function down(): void
    {
        Schema::table('penerbits', function (Blueprint $table) {
            $table->dropColumn('logo');
        });
    }
};
