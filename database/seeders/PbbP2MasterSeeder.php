<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PbbP2MasterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = now();

        // 1. ROLES
        $roleAdmin = DB::table('roles')->insertGetId([
            'nama_role' => 'Administrator',
            'deskripsi' => 'Akses penuh ke semua modul sistem PBB-P2',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $roleOperator = DB::table('roles')->insertGetId([
            'nama_role' => 'Operator',
            'deskripsi' => 'Pengelolaan data target, realisasi, dan wajib pajak',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $rolePetugas = DB::table('roles')->insertGetId([
            'nama_role' => 'Petugas Pelayanan',
            'deskripsi' => 'Verifikasi pembayaran dan layanan informasi wajib pajak',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $roleViewer = DB::table('roles')->insertGetId([
            'nama_role' => 'Viewers',
            'deskripsi' => 'Hanya dapat melihat peta dan data dashboard capaian',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // 2. PERMISSIONS
        $perms = [
            ['nama_permission' => 'view_dashboard', 'deskripsi' => 'Melihat halaman dashboard'],
            ['nama_permission' => 'view_peta', 'deskripsi' => 'Melihat peta capaian PBB-P2'],
            ['nama_permission' => 'manage_target', 'deskripsi' => 'Mengelola data target pajak'],
            ['nama_permission' => 'manage_realisasi', 'deskripsi' => 'Mengelola data realisasi pajak'],
            ['nama_permission' => 'manage_wajib_pajak', 'deskripsi' => 'Mengelola data wajib pajak dan objek pajak'],
            ['nama_permission' => 'manage_penggunaan', 'deskripsi' => 'Mengelola realisasi penggunaan dana pajak'],
            ['nama_permission' => 'manage_informasi', 'deskripsi' => 'Mengelola berita, pengumuman, dan regulasi'],
            ['nama_permission' => 'manage_users', 'deskripsi' => 'Mengelola akun pengguna dan hak akses'],
            ['nama_permission' => 'manage_pengaturan', 'deskripsi' => 'Mengelola pengaturan sistem'],
        ];

        foreach ($perms as $p) {
            $pId = DB::table('permissions')->insertGetId([
                'nama_permission' => $p['nama_permission'],
                'deskripsi' => $p['deskripsi'],
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            DB::table('role_permissions')->insert([
                'id_role' => $roleAdmin,
                'id_permission' => $pId,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        // 3. USERS (Matching mockup: Pengaturan Sistem -- DONE.png)
        $hashedPw = Hash::make('password');

        $userAdminId = DB::table('users')->insertGetId([
            'id_role' => $roleAdmin,
            'nama' => 'Administrator',
            'email' => 'admin@karawangkab.go.id',
            'password' => $hashedPw,
            'status' => 'Aktif',
            'no_hp' => '081234567890',
            'instansi' => 'BAPENDA Kabupaten Karawang',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        DB::table('users')->insert([
            [
                'id_role' => $roleOperator,
                'nama' => 'Operator Pajak',
                'email' => 'operator@karawangkab.go.id',
                'password' => $hashedPw,
                'status' => 'Aktif',
                'no_hp' => '081234567891',
                'instansi' => 'Bidang PBB dan BPHTB',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id_role' => $rolePetugas,
                'nama' => 'Petugas Pelayanan',
                'email' => 'petugas@karawangkab.go.id',
                'password' => $hashedPw,
                'status' => 'Aktif',
                'no_hp' => '081234567892',
                'instansi' => 'Loket Pelayanan BAPENDA',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id_role' => $roleOperator,
                'nama' => 'Admin Kecamatan',
                'email' => 'kec@karawangkab.go.id',
                'password' => $hashedPw,
                'status' => 'Nonaktif',
                'no_hp' => '081234567893',
                'instansi' => 'Kecamatan Cilebar',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id_role' => $roleViewer,
                'nama' => 'Staff IT',
                'email' => 'it@karawang.go.id',
                'password' => $hashedPw,
                'status' => 'Aktif',
                'no_hp' => '081234567894',
                'instansi' => 'Diskominfo Kab. Karawang',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);

        // 4. LOG_AKTIVITAS (Matching Keamanan Sistem -- DONE.png)
        $logs = [
            ['akt' => 'Login Berhasil', 'waktu' => '2026-11-11 14:30:00', 'ket' => 'Masuk ke dashboard utama', 'perangkat' => 'Chrome-Windows', 'ip' => '192.168.1.10', 'status' => 'Berhasil'],
            ['akt' => 'Login Berhasil', 'waktu' => '2026-11-10 16:20:00', 'ket' => 'Masuk untuk update realisasi', 'perangkat' => 'Chrome-Windows', 'ip' => '192.168.1.11', 'status' => 'Berhasil'],
            ['akt' => 'Login Berhasil', 'waktu' => '2026-11-09 09:15:00', 'ket' => 'Melihat peta capaian', 'perangkat' => 'Edge-Windows', 'ip' => '192.168.1.12', 'status' => 'Berhasil'],
            ['akt' => 'Login Berhasil', 'waktu' => '2026-11-08 11:10:00', 'ket' => 'Pemeriksaan status NOP', 'perangkat' => 'Chrome-Windows', 'ip' => '192.168.1.13', 'status' => 'Berhasil'],
            ['akt' => 'Login Berhasil', 'waktu' => '2026-11-07 13:45:00', 'ket' => 'Unduh laporan realisasi', 'perangkat' => 'Firefox-Windows', 'ip' => '192.168.1.14', 'status' => 'Berhasil'],
        ];

        foreach ($logs as $l) {
            DB::table('log_aktivitas')->insert([
                'id_user' => $userAdminId,
                'aktivitas' => $l['akt'],
                'waktu' => $l['waktu'],
                'keterangan' => $l['ket'],
                'perangkat' => $l['perangkat'],
                'ip_address' => $l['ip'],
                'status' => $l['status'],
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        // 5. PENGATURAN
        $settings = [
            ['nama' => 'nama_instansi', 'nilai' => 'Badan Pendapatan Daerah (BAPENDA) Kabupaten Karawang'],
            ['nama' => 'nama_aplikasi', 'nilai' => 'Sistem Informasi Geografis & Peta Capaian PBB-P2'],
            ['nama' => 'alamat_kantor', 'nilai' => 'Jl. Jend. A. Yani No. 1, Nagasari, Kec. Karawang Barat, Karawang 41312'],
            ['nama' => 'tahun_anggaran_aktif', 'nilai' => '2026'],
            ['nama' => 'email_layanan', 'nilai' => 'layanan-pbb@karawangkab.go.id'],
            ['nama' => 'telepon_layanan', 'nilai' => '(0267) 429800'],
            ['nama' => 'status_proteksi', 'nilai' => 'Aman'],
            ['nama' => 'versi_sistem', 'nilai' => 'v1.0.0'],
        ];

        foreach ($settings as $s) {
            DB::table('pengaturan')->insert([
                'id_user' => $userAdminId,
                'nama_pengaturan' => $s['nama'],
                'nilai_pengaturan' => $s['nilai'],
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        // 6. TAHUN_ANGGARAN
        DB::table('tahun_anggaran')->insert([
            ['id_tahun' => 1, 'tahun' => 2024, 'status' => 'Ditutup', 'created_at' => $now, 'updated_at' => $now],
            ['id_tahun' => 2, 'tahun' => 2025, 'status' => 'Ditutup', 'created_at' => $now, 'updated_at' => $now],
            ['id_tahun' => 3, 'tahun' => 2026, 'status' => 'Aktif', 'created_at' => $now, 'updated_at' => $now],
        ]);

        // 7. KATEGORI_INFORMASI
        $katBerita = DB::table('kategori_informasi')->insertGetId(['nama_kategori' => 'Berita', 'slug' => 'berita', 'created_at' => $now, 'updated_at' => $now]);
        $katPengumuman = DB::table('kategori_informasi')->insertGetId(['nama_kategori' => 'Pengumuman', 'slug' => 'pengumuman', 'created_at' => $now, 'updated_at' => $now]);
        $katRegulasi = DB::table('kategori_informasi')->insertGetId(['nama_kategori' => 'Regulasi', 'slug' => 'regulasi', 'created_at' => $now, 'updated_at' => $now]);
        $katFaq = DB::table('kategori_informasi')->insertGetId(['nama_kategori' => 'FAQ', 'slug' => 'faq', 'created_at' => $now, 'updated_at' => $now]);

        // 8. INFORMASI (Matching Informasi -- DONE.png and sub-pages)
        $beritaList = [
            [
                'id_kategori' => $katBerita,
                'judul' => 'Sosialisasi PBB-P2 di Kecamatan Tirtamulya',
                'slug' => 'sosialisasi-pbb-p2-di-kecamatan-tirtamulya',
                'ringkasan' => 'Bapenda Karawang menggelar sosialisasi terkait tata cara pembayaran dan pengamanan PBB-P2 di Kecamatan Tirtamulya.',
                'isi' => 'Badan Pendapatan Daerah (BAPENDA) Kabupaten Karawang melaksanakan kegiatan sosialisasi optimalisasi penerimaan Pajak Bumi dan Bangunan Perdesaan dan Perkotaan (PBB-P2) di Aula Kantor Kecamatan Tirtamulya pada Jumat, 16 Oktober 2026. Kegiatan ini dihadiri langsung oleh jajaran pejabat BAPENDA, Camat Tirtamulya, serta para Kepala Desa dan kolektor pajak se-Kecamatan Tirtamulya. Materi utama yang disampaikan meliputi tata cara pembayaran digital melalui QRIS dan kanal perbankan mitra, percepatan distribusi SPPT, serta rekonsiliasi data ketetapan dan penerimaan desa.',
                'gambar' => 'berita-1.jpg',
                'tanggal_publikasi' => '2026-10-16 09:00:00',
                'status' => 'Publik',
            ],
            [
                'id_kategori' => $katBerita,
                'judul' => 'Peningkatan Layanan Cek PBB Online',
                'slug' => 'peningkatan-layanan-cek-pbb-online',
                'ringkasan' => 'Kini masyarakat dapat mengecek tagihan PBB-P2 secara lebih mudah dan transparan melalui website resmi BAPENDA Karawang.',
                'isi' => 'Untuk meningkatkan kepuasan wajib pajak, BAPENDA Karawang meluncurkan pembaruan portal PBB-P2 Online. Sistem ini memungkinkan warga mengecek ketetapan pajak hanya dengan memasukkan 18 digit Nomor Objek Pajak (NOP), memantau riwayat pembayaran hingga 5 tahun terakhir, dan mencetak bukti pembayaran digital secara langsung.',
                'gambar' => 'berita-2.jpg',
                'tanggal_publikasi' => '2026-10-10 10:30:00',
                'status' => 'Publik',
            ],
            [
                'id_kategori' => $katBerita,
                'judul' => 'Realisasi PBB-P2 Triwulan III Capai 76,6%',
                'slug' => 'realisasi-pbb-p2-triwulan-iii-capai-76-6',
                'ringkasan' => 'Realisasi penerimaan PBB-P2 hingga Triwulan III tahun 2026 mencapai 76,6% dari target yang ditetapkan.',
                'isi' => 'BAPENDA Kabupaten Karawang mencatatkan capaian positif penerimaan PBB-P2 hingga penutupan Triwulan III 2026 sebesar 76,6%. Peningkatan ini didorong oleh integrasi sistem monitoring berbasis geospasial serta tingginya partisipasi masyarakat dalam program pembebasan denda administratif.',
                'gambar' => 'berita-3.jpg',
                'tanggal_publikasi' => '2026-10-05 14:00:00',
                'status' => 'Publik',
            ],
        ];

        foreach ($beritaList as $b) {
            DB::table('informasi')->insert(array_merge($b, [
                'id_user' => $userAdminId,
                'penulis' => 'Humas BAPENDA Karawang',
                'created_at' => $now,
                'updated_at' => $now,
            ]));
        }

        $pengumumanList = [
            [
                'id_kategori' => $katPengumuman,
                'judul' => 'Jadwal Pembayaran PBB-P2 Tahap IV Tahun 2026',
                'slug' => 'jadwal-pembayaran-pbb-p2-tahap-iv-tahun-2026',
                'ringkasan' => 'Diberitahukan kepada seluruh Wajib Pajak bahwa loket pembayaran dibuka mulai 15 Oktober 2026 hingga 15 Desember 2026.',
                'isi' => 'Diberitahukan kepada seluruh Wajib Pajak PBB-P2 di Kabupaten Karawang bahwa loket layanan pembayaran Pajak Bumi dan Bangunan Tahap IV dibuka mulai tanggal 15 Oktober 2026 hingga 15 Desember 2026. Pembayaran dapat dilakukan melalui loket kantor BAPENDA Karawang, mobil layanan keliling di setiap kantor kecamatan, Bank BJB teller, ATM, mobile banking, serta seluruh minimarket mitra (Indomaret dan Alfamart). Pastikan melakukan pembayaran sebelum jatuh tempo guna menghindari denda keterlambatan administrasi.',
                'gambar' => null,
                'tanggal_publikasi' => '2026-10-14 08:00:00',
                'status' => 'Publik',
            ],
            [
                'id_kategori' => $katPengumuman,
                'judul' => 'Perpanjangan Layanan Cek PBB Online (Info Pemeliharaan)',
                'slug' => 'perpanjangan-layanan-cek-pbb-online-info-pemeliharaan',
                'ringkasan' => 'Pemeliharaan server berkala akan dilakukan pada Sabtu dini hari pukul 00.00 - 04.00 WIB.',
                'isi' => 'Sehubungan dengan optimalisasi infrastruktur cloud BAPENDA Karawang, akan dilaksanakan pemeliharaan server berkala pada hari Sabtu, 17 Oktober 2026 pukul 00:00 hingga 04:00 WIB. Layanan cek PBB online akan sementara waktu tidak dapat diakses selama proses tersebut berlangsung.',
                'gambar' => null,
                'tanggal_publikasi' => '2026-10-08 11:00:00',
                'status' => 'Publik',
            ],
            [
                'id_kategori' => $katPengumuman,
                'judul' => 'Himbauan Pembayaran PBB-P2 Tepat Waktu',
                'slug' => 'himbauan-pembayaran-pbb-p2-tepat-waktu',
                'ringkasan' => 'Mari dukung percepatan pembangunan Kabupaten Karawang dengan taat membayar pajak bumi dan bangunan tepat waktu.',
                'isi' => 'Pajak yang Anda bayarkan dikembalikan dalam bentuk perbaikan infrastruktur jalan, jembatan, fasilitas kesehatan, serta beasiswa pendidikan putra-putri Karawang. Mari sukseskan pembangunan daerah dengan taat membayar pajak!',
                'gambar' => null,
                'tanggal_publikasi' => '2026-10-01 08:30:00',
                'status' => 'Publik',
            ],
        ];

        foreach ($pengumumanList as $p) {
            DB::table('informasi')->insert(array_merge($p, [
                'id_user' => $userAdminId,
                'penulis' => 'Bidang PBB dan BPHTB BAPENDA',
                'created_at' => $now,
                'updated_at' => $now,
            ]));
        }

        $regulasiList = [
            [
                'id_kategori' => $katRegulasi,
                'judul' => 'Perda Kab. Karawang No. 11 Tahun 2021 (Perubahan atas Perda No. 16 Tahun 2016)',
                'slug' => 'perda-kab-karawang-no-11-tahun-2021',
                'ringkasan' => 'Peraturan Daerah tentang Pajak Daerah dan Retribusi Daerah Kabupaten Karawang.',
                'isi' => 'Peraturan Daerah Kabupaten Karawang Nomor 11 Tahun 2021 mengatur tentang perubahan tarif, klasifikasi objek bumi dan bangunan, serta skema insentif pajak daerah bagi perdesaan dan perkotaan di lingkungan Kabupaten Karawang.',
                'gambar' => null,
                'tanggal_publikasi' => '2026-09-01 08:00:00',
                'status' => 'Publik',
            ],
            [
                'id_kategori' => $katRegulasi,
                'judul' => 'Perbup Karawang No. 77 Tahun 2021 tentang Tata Cara Pembayaran PBB-P2',
                'slug' => 'perbup-karawang-no-77-tahun-2021',
                'ringkasan' => 'Petunjuk teknis pemungutan, penagihan, dan pembayaran Pajak Bumi dan Bangunan Perdesaan dan Perkotaan.',
                'isi' => 'Peraturan Bupati Karawang Nomor 77 Tahun 2021 mengatur tentang petunjuk teknis pelaksanaan administrasi pemungutan PBB-P2, hak dan kewajiban kolektor desa, serta mekanisme verifikasi pembayaran elektronik.',
                'gambar' => null,
                'tanggal_publikasi' => '2026-08-15 08:00:00',
                'status' => 'Publik',
            ],
        ];

        foreach ($regulasiList as $r) {
            DB::table('informasi')->insert(array_merge($r, [
                'id_user' => $userAdminId,
                'penulis' => 'Bagian Hukum Setda Karawang',
                'created_at' => $now,
                'updated_at' => $now,
            ]));
        }

        $faqList = [
            [
                'id_kategori' => $katFaq,
                'judul' => 'Bagaimana Cara Cek PBB Online?',
                'slug' => 'bagaimana-cara-cek-pbb-online',
                'ringkasan' => 'Panduan cepat pengecekan status ketetapan dan tunggakan PBB online.',
                'isi' => "Untuk mengecek tagihan PBB-P2 secara online di Kabupaten Karawang:\n1. Kunjungi portal resmi BAPENDA Karawang atau menu Peta PBB-P2 / Cek PBB pada dashboard ini.\n2. Masukkan 18 digit Nomor Objek Pajak (NOP) yang tercantum pada lembar SPPT PBB Anda.\n3. Pilih tahun pajak yang ingin diperiksa (misalnya 2026).\n4. Klik tombol \"Cari\" atau \"Cek Tagihan\" untuk melihat rincian jumlah ketetapan, realisasi pembayaran, dan sisa tagihan secara real-time.",
                'gambar' => null,
                'tanggal_publikasi' => '2026-09-10 10:00:00',
                'status' => 'Publik',
            ],
            [
                'id_kategori' => $katFaq,
                'judul' => 'Bagaimana Cara Melihat Tagihan PBB-P2?',
                'slug' => 'bagaimana-cara-melihat-tagihan-pbb-p2',
                'ringkasan' => 'Kanal resmi melihat rincian ketetapan SPPT PBB.',
                'isi' => "Tagihan PBB-P2 dapat dilihat melalui:\n1. Surat Pemberitahuan Pajak Terhutang (SPPT) fisik yang dibagikan oleh petugas desa/kelurahan atau RT/RW setempat setiap awal tahun pajak.\n2. Fitur Cek Tagihan PBB Online pada portal BAPENDA Kabupaten Karawang.\n3. Aplikasi perbankan digital (Mobile Banking Bank BJB, Mandiri, BCA, BRI, BNI) dengan memasukkan NOP pada menu Pembayaran Pajak Daerah.",
                'gambar' => null,
                'tanggal_publikasi' => '2026-09-12 10:00:00',
                'status' => 'Publik',
            ],
            [
                'id_kategori' => $katFaq,
                'judul' => 'Bagaimana Cara Melakukan Pembayaran?',
                'slug' => 'bagaimana-cara-melakukan-pembayaran',
                'ringkasan' => 'Pilihan metode pembayaran tunai maupun nontunai resmi.',
                'isi' => "Pembayaran PBB-P2 Kabupaten Karawang dapat dilakukan melalui berbagai kanal resmi yang mudah diakses:\n1. Bank BJB (Teller, ATM, BJB Digi, dan QRIS)\n2. Kantor Pos Indonesia di seluruh cabang\n3. Gerai minimarket retail (Indomaret dan Alfamart)\n4. Platform E-Commerce dan Dompet Digital (Tokopedia, Bukalapak, Shopee, Gopay, OVO, Dana)\n5. Petugas Kolektor Pajak resmi di kantor Desa/Kelurahan setempat.",
                'gambar' => null,
                'tanggal_publikasi' => '2026-09-15 10:00:00',
                'status' => 'Publik',
            ],
        ];

        foreach ($faqList as $f) {
            DB::table('informasi')->insert(array_merge($f, [
                'id_user' => $userAdminId,
                'penulis' => 'Pusat Bantuan BAPENDA Karawang',
                'created_at' => $now,
                'updated_at' => $now,
            ]));
        }

        // 9. PENGGUNAAN_PAJAK (Matching Penggunaan Pajak -- DONE.png)
        $penggunaanData = [
            ['nama' => 'Pembangunan Infrastruktur', 'bidang' => 'Pembangunan Infrastruktur', 'anggaran' => 125000000000, 'realisasi' => 104667000000, 'persen' => '42.3%'],
            ['nama' => 'Pelayanan Publik', 'bidang' => 'Pelayanan Publik', 'anggaran' => 85000000000, 'realisasi' => 70864000000, 'persen' => '28.7%'],
            ['nama' => 'Pemberdayaan Masyarakat', 'bidang' => 'Pemberdayaan Masyarakat', 'anggaran' => 45000000000, 'realisasi' => 39594000000, 'persen' => '14.2%'],
            ['nama' => 'Administrasi Pemerintah', 'bidang' => 'Administrasi Pemerintah', 'anggaran' => 25000000000, 'realisasi' => 21992000000, 'persen' => '8.9%'],
            ['nama' => 'Lainnya', 'bidang' => 'Lainnya', 'anggaran' => 12942200000, 'realisasi' => 10633800000, 'persen' => '3.9%'],
        ];

        foreach ($penggunaanData as $p) {
            DB::table('penggunaan_pajak')->insert([
                'id_tahun' => 3, // 2026
                'nama_program' => $p['nama'],
                'bidang_penggunaan' => $p['bidang'],
                'jumlah_anggaran' => $p['anggaran'],
                'jumlah_realisasi' => $p['realisasi'],
                'keterangan' => 'Penyaluran APBD Dana Bagi Hasil PBB-P2 TA 2026',
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        // 10. JENIS_PAJAK
        $jpPBBPerdesaan = DB::table('jenis_pajak')->insertGetId([
            'nama_jenis_pajak' => 'PBB-P2 Perdesaan',
            'keterangan' => 'Pajak Bumi dan Bangunan sektor Perdesaan untuk lahan pertanian, kebun, dan pemukiman warga desa',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $jpPBBPerkotaan = DB::table('jenis_pajak')->insertGetId([
            'nama_jenis_pajak' => 'PBB-P2 Perkotaan',
            'keterangan' => 'Pajak Bumi dan Bangunan sektor Perkotaan untuk perumahan, ruko, dan perkantoran',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $jpPBBIndustri = DB::table('jenis_pajak')->insertGetId([
            'nama_jenis_pajak' => 'PBB-P2 Kawasan Industri & Bisnis',
            'keterangan' => 'Pajak Bumi dan Bangunan sektor Industri, pergudangan, pabrik, dan pusat perbelanjaan',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // 11. Populate TARGET_PAJAK and REALISASI_PAJAK for each desa
        // Specific targets from mockups for key kecamatan:
        // Karawang Barat: Target 42.5B, Real 31.62B (74.4%)
        // Telukjambe Barat: Target 28.3B, Real 20.41B (72.1%)
        // Cikampek: Target 25.7B, Real 19.88B (77.4%)
        // Banyusari: Target 13.9B, Real 13.54B (97.6%)
        // Cilamaya Wetan: Target 15.8B, Real 10.98B (69.5%)
        // Cilebar: Target 5.1B, Real 5.304B (104.0%)
        // Tempuran: Target 9.5B, Real 6.27B (66.0%)
        // Tirtamulya: Target 8.4B, Real 5.124B (61.0%)
        $specialKecTargets = [
            'Karawang Barat' => ['target' => 42500000000, 'real' => 31620450000],
            'Telukjambe Barat' => ['target' => 28300000000, 'real' => 20412360000],
            'Cikampek' => ['target' => 25700000000, 'real' => 19882410000],
            'Banyusari' => ['target' => 13900000000, 'real' => 13542680000],
            'Cilamaya Wetan' => ['target' => 15800000000, 'real' => 10987230000],
            'Cilebar' => ['target' => 5100000000, 'real' => 5304000000],
            'Tempuran' => ['target' => 9500000000, 'real' => 6270000000],
            'Tirtamulya' => ['target' => 8400000000, 'real' => 5124000000],
            'Tegalwaru' => ['target' => 4200000000, 'real' => 4326000000], // 103%
            'Pedes' => ['target' => 8500000000, 'real' => 6970000000], // 82%
            'Klari' => ['target' => 22000000000, 'real' => 16720000000], // 76%
            'Telukjambe Timur' => ['target' => 38000000000, 'real' => 19760000000], // 52%
            'Karawang Timur' => ['target' => 29000000000, 'real' => 18850000000], // 65%
        ];

        $kecamatans = DB::table('kecamatan')->get();
        $sampleWajibPajakNames = [
            'H. Ahmad Syafei', 'Hj. Siti Rohmah', 'Budi Santoso', 'Dr. Hendra Gunawan',
            'Asep Saepudin', 'Dadang Suhendar', 'Nining Suryani', 'Eko Prasetyo',
            'Rahmat Hidayat', 'Dewi Lestari', 'PT. Surya Karawang Abadi', 'PT. Multi Graha Jaya',
            'Iwan Setiawan', 'Eni Sulastri', 'Cecep Hidayat', 'Dedi Supriadi',
            'Kusnadi', 'Yayah Rohayah', 'Wawan Gunawan', 'Agus Susanto'
        ];

        foreach ($kecamatans as $kec) {
            $desas = DB::table('desa')->where('id_kecamatan', $kec->id_kecamatan)->get();
            $numDesa = count($desas);
            if ($numDesa === 0) continue;

            $hasPreset = isset($specialKecTargets[$kec->nama_kecamatan]);
            $kecTarget = $hasPreset ? $specialKecTargets[$kec->nama_kecamatan]['target'] : rand(6000000000, 18000000000);
            $kecReal = $hasPreset ? $specialKecTargets[$kec->nama_kecamatan]['real'] : $kecTarget * (rand(35, 95) / 100);

            $targetPerDesa = round($kecTarget / $numDesa, -6);
            $realPerDesa = round($kecReal / $numDesa, -6);

            foreach ($desas as $dIdx => $desa) {
                // Variations per desa
                $jitterTarget = $targetPerDesa * (0.85 + (0.05 * ($dIdx % 5)));
                $jitterReal = min($jitterTarget * 1.15, $realPerDesa * (0.8 + (0.08 * ($dIdx % 6))));
                $persen = round(($jitterReal / max(1, $jitterTarget)) * 100, 2);

                DB::table('target_pajak')->insert([
                    'id_desa' => $desa->id_desa,
                    'id_tahun' => 3, // 2026
                    'target_pajak' => $jitterTarget,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);

                DB::table('realisasi_pajak')->insert([
                    'id_desa' => $desa->id_desa,
                    'id_tahun' => 3,
                    'jumlah_realisasi' => $jitterReal,
                    'persentase' => $persen,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);

                // Create a few sample Wajib Pajak and Objek Pajak for testing
                if ($dIdx === 0 || $kec->nama_kecamatan === 'Cilebar' || $kec->nama_kecamatan === 'Karawang Barat') {
                    $namaWp = $sampleWajibPajakNames[($kec->id_kecamatan + $dIdx) % count($sampleWajibPajakNames)];
                    $nik = '3215' . str_pad($kec->id_kecamatan, 2, '0', STR_PAD_LEFT) . rand(10000000, 99999999);
                    $wpId = DB::table('wajib_pajak')->insertGetId([
                        'id_desa' => $desa->id_desa,
                        'nama_wajib_pajak' => $namaWp,
                        'nik_npwp' => $nik,
                        'alamat' => 'Kp. Babakan RT 0' . (($dIdx % 4) + 1) . '/RW 0' . (($dIdx % 2) + 1) . ', Desa ' . $desa->nama_desa,
                        'no_telepon' => '08' . rand(111111111, 999999999),
                        'created_at' => $now,
                        'updated_at' => $now,
                    ]);

                    // NOP format 18 digit: 32.15.xxx.xxx.xxx-xxxx.x
                    $kecCodeStr = str_pad($kec->id_kecamatan, 3, '0', STR_PAD_LEFT);
                    $desaCodeStr = str_pad($dIdx + 1, 3, '0', STR_PAD_LEFT);
                    $nop = "32.15.{$kecCodeStr}.{$desaCodeStr}.001-0001.0";
                    $isLunas = ($dIdx % 2 === 0);
                    $nilaiPajak = rand(250000, 3500000);

                    $opId = DB::table('objek_pajak')->insertGetId([
                        'id_wajib_pajak' => $wpId,
                        'id_jenis_pajak' => ($kec->nama_kecamatan === 'Karawang Barat' ? $jpPBBPerkotaan : $jpPBBPerdesaan),
                        'id_desa' => $desa->id_desa,
                        'nop' => $nop,
                        'alamat_objek' => 'Jl. Raya ' . $desa->nama_desa . ' No. ' . rand(10, 99),
                        'luas_bumi' => rand(80, 1500),
                        'luas_bangunan' => rand(45, 600),
                        'nilai_pajak' => $nilaiPajak,
                        'status_pembayaran' => $isLunas ? 'Lunas' : 'Belum Lunas',
                        'created_at' => $now,
                        'updated_at' => $now,
                    ]);

                    if ($isLunas) {
                        DB::table('pembayaran_pajak')->insert([
                            'id_objek_pajak' => $opId,
                            'tanggal_bayar' => '2026-08-' . rand(10, 28),
                            'tahun_pajak' => 2026,
                            'jumlah_bayar' => $nilaiPajak,
                            'status_pembayaran' => 'Lunas',
                            'metode_pembayaran' => 'Bank BJB Digi',
                            'nomor_transaksi' => 'TRX-' . strtoupper(substr(md5($nop), 0, 10)),
                            'created_at' => $now,
                            'updated_at' => $now,
                        ]);
                    }
                }
            }
        }
    }
}
