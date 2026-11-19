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
        // 1. ROLE
        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id_role');
            $table->string('nama_role', 50);
            $table->string('deskripsi', 255)->nullable();
            $table->timestamps();
        });

        // 2. PERMISSION
        Schema::create('permissions', function (Blueprint $table) {
            $table->increments('id_permission');
            $table->string('nama_permission', 100);
            $table->string('deskripsi', 255)->nullable();
            $table->timestamps();
        });

        // 3. ROLE_PERMISSION
        Schema::create('role_permissions', function (Blueprint $table) {
            $table->increments('id_role_permission');
            $table->unsignedInteger('id_role');
            $table->unsignedInteger('id_permission');
            $table->timestamps();

            $table->foreign('id_role')->references('id_role')->on('roles')->cascadeOnDelete();
            $table->foreign('id_permission')->references('id_permission')->on('permissions')->cascadeOnDelete();
        });

        // Drop default users table and recreate per ERD
        Schema::dropIfExists('users');
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id_user');
            $table->unsignedInteger('id_role')->nullable();
            $table->string('nama', 100);
            $table->string('email', 100)->unique();
            $table->string('password');
            $table->string('status', 20)->default('Aktif'); // Aktif, Nonaktif
            $table->string('no_hp', 20)->nullable();
            $table->string('instansi', 100)->nullable();
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('id_role')->references('id_role')->on('roles')->nullOnDelete();
        });

        // 5. LOG_AKTIVITAS
        Schema::create('log_aktivitas', function (Blueprint $table) {
            $table->increments('id_log');
            $table->unsignedInteger('id_user')->nullable();
            $table->string('aktivitas', 150);
            $table->dateTime('waktu');
            $table->text('keterangan')->nullable();
            $table->string('perangkat', 100)->nullable();
            $table->string('ip_address', 50)->nullable();
            $table->string('status', 50)->default('Berhasil');
            $table->timestamps();

            $table->foreign('id_user')->references('id_user')->on('users')->nullOnDelete();
        });

        // 6. PENGATURAN
        Schema::create('pengaturan', function (Blueprint $table) {
            $table->increments('id_pengaturan');
            $table->unsignedInteger('id_user')->nullable();
            $table->string('nama_pengaturan', 100);
            $table->text('nilai_pengaturan')->nullable();
            $table->timestamps();

            $table->foreign('id_user')->references('id_user')->on('users')->nullOnDelete();
        });

        // 7. KATEGORI_INFORMASI
        Schema::create('kategori_informasi', function (Blueprint $table) {
            $table->increments('id_kategori');
            $table->string('nama_kategori', 50);
            $table->string('slug', 50)->nullable();
            $table->timestamps();
        });

        // 8. INFORMASI
        Schema::create('informasi', function (Blueprint $table) {
            $table->increments('id_informasi');
            $table->unsignedInteger('id_kategori');
            $table->unsignedInteger('id_user')->nullable();
            $table->string('judul', 255);
            $table->string('slug', 255)->nullable();
            $table->text('ringkasan')->nullable();
            $table->longText('isi');
            $table->string('gambar', 255)->nullable();
            $table->dateTime('tanggal_publikasi');
            $table->string('penulis', 100)->nullable()->default('Humas BAPENDA Karawang');
            $table->string('status', 20)->default('Publik'); // Publik, Draft
            $table->timestamps();

            $table->foreign('id_kategori')->references('id_kategori')->on('kategori_informasi')->cascadeOnDelete();
            $table->foreign('id_user')->references('id_user')->on('users')->nullOnDelete();
        });

        // 9. KECAMATAN
        Schema::create('kecamatan', function (Blueprint $table) {
            $table->increments('id_kecamatan');
            $table->string('nama_kecamatan', 100)->unique();
            $table->string('kode_kecamatan', 10)->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->decimal('luas_wilayah', 10, 2)->nullable(); // in km2
            $table->integer('jumlah_penduduk')->nullable();
            $table->json('geojson')->nullable();
            $table->timestamps();
        });

        // 10. DESA
        Schema::create('desa', function (Blueprint $table) {
            $table->increments('id_desa');
            $table->unsignedInteger('id_kecamatan');
            $table->string('nama_desa', 100);
            $table->string('kode_desa', 15)->nullable();
            $table->string('jenis', 20)->default('Desa'); // Desa, Kelurahan
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->json('geojson')->nullable();
            $table->timestamps();

            $table->foreign('id_kecamatan')->references('id_kecamatan')->on('kecamatan')->cascadeOnDelete();
        });

        // 11. TAHUN_ANGGARAN
        Schema::create('tahun_anggaran', function (Blueprint $table) {
            $table->increments('id_tahun');
            $table->integer('tahun')->unique();
            $table->string('status', 20)->default('Aktif'); // Aktif, Ditutup
            $table->timestamps();
        });

        // 12. TARGET_PAJAK
        Schema::create('target_pajak', function (Blueprint $table) {
            $table->increments('id_target');
            $table->unsignedInteger('id_desa');
            $table->unsignedInteger('id_tahun');
            $table->decimal('target_pajak', 15, 2)->default(0);
            $table->timestamps();

            $table->foreign('id_desa')->references('id_desa')->on('desa')->cascadeOnDelete();
            $table->foreign('id_tahun')->references('id_tahun')->on('tahun_anggaran')->cascadeOnDelete();
            $table->unique(['id_desa', 'id_tahun']);
        });

        // 13. REALISASI_PAJAK
        Schema::create('realisasi_pajak', function (Blueprint $table) {
            $table->increments('id_realisasi');
            $table->unsignedInteger('id_desa');
            $table->unsignedInteger('id_tahun');
            $table->decimal('jumlah_realisasi', 15, 2)->default(0);
            $table->decimal('persentase', 5, 2)->default(0);
            $table->timestamps();

            $table->foreign('id_desa')->references('id_desa')->on('desa')->cascadeOnDelete();
            $table->foreign('id_tahun')->references('id_tahun')->on('tahun_anggaran')->cascadeOnDelete();
            $table->unique(['id_desa', 'id_tahun']);
        });

        // 14. PENGGUNAAN_PAJAK
        Schema::create('penggunaan_pajak', function (Blueprint $table) {
            $table->increments('id_penggunaan');
            $table->unsignedInteger('id_tahun');
            $table->string('nama_program', 200);
            $table->string('bidang_penggunaan', 100); // Pembangunan Infrastruktur, Pelayanan Publik, Pemberdayaan Masyarakat, Administrasi Pemerintah, Lainnya
            $table->decimal('jumlah_anggaran', 15, 2)->default(0);
            $table->decimal('jumlah_realisasi', 15, 2)->default(0);
            $table->string('bulan', 20)->nullable();
            $table->string('keterangan', 255)->nullable();
            $table->timestamps();

            $table->foreign('id_tahun')->references('id_tahun')->on('tahun_anggaran')->cascadeOnDelete();
        });

        // 15. WAJIB_PAJAK
        Schema::create('wajib_pajak', function (Blueprint $table) {
            $table->increments('id_wajib_pajak');
            $table->unsignedInteger('id_desa');
            $table->string('nama_wajib_pajak', 150);
            $table->string('nik_npwp', 30)->nullable();
            $table->string('alamat', 255)->nullable();
            $table->string('no_telepon', 25)->nullable();
            $table->timestamps();

            $table->foreign('id_desa')->references('id_desa')->on('desa')->cascadeOnDelete();
        });

        // 16. JENIS_PAJAK
        Schema::create('jenis_pajak', function (Blueprint $table) {
            $table->increments('id_jenis_pajak');
            $table->string('nama_jenis_pajak', 100);
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });

        // 17. OBJEK_PAJAK
        Schema::create('objek_pajak', function (Blueprint $table) {
            $table->increments('id_objek_pajak');
            $table->unsignedInteger('id_wajib_pajak');
            $table->unsignedInteger('id_jenis_pajak');
            $table->unsignedInteger('id_desa')->nullable();
            $table->string('nop', 25)->unique(); // Nomor Objek Pajak (18 digit standard)
            $table->string('alamat_objek', 255);
            $table->decimal('luas_bumi', 10, 2)->default(0);
            $table->decimal('luas_bangunan', 10, 2)->default(0);
            $table->decimal('nilai_pajak', 15, 2)->default(0);
            $table->string('status_pembayaran', 30)->default('Belum Lunas'); // Lunas, Belum Lunas
            $table->timestamps();

            $table->foreign('id_wajib_pajak')->references('id_wajib_pajak')->on('wajib_pajak')->cascadeOnDelete();
            $table->foreign('id_jenis_pajak')->references('id_jenis_pajak')->on('jenis_pajak')->cascadeOnDelete();
            $table->foreign('id_desa')->references('id_desa')->on('desa')->nullOnDelete();
        });

        // 18. PEMBAYARAN_PAJAK
        Schema::create('pembayaran_pajak', function (Blueprint $table) {
            $table->increments('id_pembayaran');
            $table->unsignedInteger('id_objek_pajak');
            $table->date('tanggal_bayar');
            $table->integer('tahun_pajak');
            $table->decimal('jumlah_bayar', 15, 2)->default(0);
            $table->string('status_pembayaran', 30)->default('Lunas'); // Lunas, Menunggu Verifikasi, Dibatalkan
            $table->string('metode_pembayaran', 50)->nullable()->default('Bank BJB');
            $table->string('nomor_transaksi', 50)->nullable();
            $table->timestamps();

            $table->foreign('id_objek_pajak')->references('id_objek_pajak')->on('objek_pajak')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayaran_pajak');
        Schema::dropIfExists('objek_pajak');
        Schema::dropIfExists('jenis_pajak');
        Schema::dropIfExists('wajib_pajak');
        Schema::dropIfExists('penggunaan_pajak');
        Schema::dropIfExists('realisasi_pajak');
        Schema::dropIfExists('target_pajak');
        Schema::dropIfExists('tahun_anggaran');
        Schema::dropIfExists('desa');
        Schema::dropIfExists('kecamatan');
        Schema::dropIfExists('informasi');
        Schema::dropIfExists('kategori_informasi');
        Schema::dropIfExists('pengaturan');
        Schema::dropIfExists('log_aktivitas');
        Schema::dropIfExists('users');
        Schema::dropIfExists('role_permissions');
        Schema::dropIfExists('permissions');
        Schema::dropIfExists('roles');
    }
};
