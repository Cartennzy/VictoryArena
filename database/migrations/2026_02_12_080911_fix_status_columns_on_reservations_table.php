<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1️⃣ Cek dan tambahkan kolom jika belum ada, atau ubah (MODIFY) jika sudah ada
        if (!Schema::hasColumn('reservations', 'payment_status')) {
            Schema::table('reservations', function (Blueprint $table) {
                $table->string('payment_status', 50)->nullable();
            });
        } else {
            DB::statement("
                ALTER TABLE reservations 
                MODIFY payment_status VARCHAR(50)
            ");
        }

        if (!Schema::hasColumn('reservations', 'status')) {
            Schema::table('reservations', function (Blueprint $table) {
                $table->string('status', 50)->nullable();
            });
        } else {
            DB::statement("
                ALTER TABLE reservations 
                MODIFY status VARCHAR(50)
            ");
        }

        // 2️⃣ Bersihkan data lama (Data default yang kosong akan diset ke 'pending')
        DB::statement("
            UPDATE reservations 
            SET payment_status = 'pending'
            WHERE payment_status IS NULL 
               OR payment_status NOT IN ('pending','paid','failed')
        ");

        DB::statement("
            UPDATE reservations 
            SET status = 'pending'
            WHERE status IS NULL 
               OR status NOT IN ('pending','approved','expired')
        ");

        // 3️⃣ Baru ubah ke ENUM dengan aman
        DB::statement("
            ALTER TABLE reservations 
            MODIFY payment_status 
            ENUM('pending','paid','failed') 
            NOT NULL DEFAULT 'pending'
        ");

        DB::statement("
            ALTER TABLE reservations 
            MODIFY status 
            ENUM('pending','approved','expired') 
            NOT NULL DEFAULT 'pending'
        ");
    }

    public function down(): void
    {
        // Kembalikan ke VARCHAR jika dilakukan rollback
        DB::statement("
            ALTER TABLE reservations 
            MODIFY payment_status VARCHAR(50)
        ");

        DB::statement("
            ALTER TABLE reservations 
            MODIFY status VARCHAR(50)
        ");
    }
};