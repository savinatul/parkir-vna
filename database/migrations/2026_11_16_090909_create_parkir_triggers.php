<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Jalankan migration untuk membuat trigger khusus tb_transaksi.
     */
    public function up(): void
    {
        // Pastikan bersih dari trigger lama sebelum membuat yang baru
        $this->down();

        // 1. Trigger Hitung Durasi Jam & Biaya Total (<= 30 menit = 0.5 jam / setengah tarif)
        DB::unprepared("
            CREATE TRIGGER before_update_transaksi_waktu_keluar
            BEFORE UPDATE ON tb_transaksi
            FOR EACH ROW
            BEGIN
                DECLARE tarif_jam DECIMAL(12,2) DEFAULT 0;
                DECLARE total_menit INT DEFAULT 0;

                IF NEW.waktu_keluar IS NOT NULL 
                   AND (OLD.waktu_keluar IS NULL OR NEW.waktu_keluar <> OLD.waktu_keluar) THEN
                    
                    -- Hitung total durasi dalam menit
                    SET total_menit = TIMESTAMPDIFF(MINUTE, NEW.waktu_masuk, NEW.waktu_keluar);

                    -- Jika <= 30 menit = 0.5 jam (setengah tarif), jika > 30 menit dibulatkan ke atas per jam
                    IF total_menit <= 30 THEN
                        SET NEW.durasi_jam = 0.5;
                    ELSE
                        SET NEW.durasi_jam = CEIL(total_menit / 60);
                    END IF;

                    -- Ambil tarif_perjam dari tabel tb_tarif
                    SELECT tarif_perjam INTO tarif_jam
                    FROM tb_tarif 
                    WHERE id_tarif = NEW.id_tarif
                    LIMIT 1;
                    
                    -- Hitung total biaya
                    SET NEW.biaya_total = NEW.durasi_jam * IFNULL(tarif_jam, 0);
                END IF;
            END
        ");

        // 2. Trigger Tambah Slot Terisi di tb_area_parkir saat kendaraan masuk
        DB::unprepared("
            CREATE TRIGGER after_insert_transaksi_area
            AFTER INSERT ON tb_transaksi
            FOR EACH ROW
            BEGIN
                IF NEW.status = 'masuk' THEN
                    UPDATE tb_area_parkir 
                    SET terisi = terisi + 1 
                    WHERE id_area = NEW.id_area;
                END IF;
            END
        ");

        // 3. Trigger Kurangi Slot Terisi di tb_area_parkir saat kendaraan keluar
        DB::unprepared("
            CREATE TRIGGER after_update_transaksi_area
            AFTER UPDATE ON tb_transaksi
            FOR EACH ROW
            BEGIN
                IF OLD.status = 'masuk' AND NEW.status = 'keluar' THEN
                    UPDATE tb_area_parkir 
                    SET terisi = GREATEST(0, terisi - 1) 
                    WHERE id_area = NEW.id_area;
                END IF;
            END
        ");
    }

    /**
     * Hapus trigger saat rollback migration.
     */
    public function down(): void
    {
        DB::unprepared('DROP TRIGGER IF EXISTS log_aktivitas_insert_kendaraan');
        DB::unprepared('DROP TRIGGER IF EXISTS before_update_transaksi_waktu_keluar');
        DB::unprepared('DROP TRIGGER IF EXISTS after_insert_transaksi_area');
        DB::unprepared('DROP TRIGGER IF EXISTS after_update_transaksi_area');
    }
};