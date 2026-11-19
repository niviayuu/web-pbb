<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Kecamatan;
use App\Models\Desa;
use App\Models\ObjekPajak;

class PbbP2PagesTest extends TestCase
{
    public function test_dashboard_page_loads_successfully(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('Peta Capaian PBB-P2');
        $response->assertSee('Total Realisasi');
        $response->assertSee('banner-beranda-karawang.jpg');
    }

    public function test_peta_page_loads_with_30_kecamatan(): void
    {
        $response = $this->get('/peta');
        $response->assertStatus(200);
        $response->assertSee('Peta Capaian PBB-P2');
        $response->assertSee('Total Kecamatan');
        $response->assertSee('Total Desa/Kelurahan');
        $response->assertSee('Cilebar');
        $response->assertSee('Karawang Barat');
    }

    public function test_kecamatan_detail_page_loads_with_desas(): void
    {
        $kecamatan = Kecamatan::where('nama_kecamatan', 'Cilebar')->first() ?? Kecamatan::first();
        $response = $this->get('/peta/kecamatan/' . $kecamatan->id_kecamatan);
        $response->assertStatus(200);
        $response->assertSee('Kecamatan ' . $kecamatan->nama_kecamatan);
        $response->assertSee('Peta Desa/Kelurahan');
        $response->assertSee('Rincian Pajak Desa/Kelurahan');
    }

    public function test_realisasi_target_page_loads(): void
    {
        $response = $this->get('/realisasi');
        $response->assertStatus(200);
        $response->assertSee('Realisasi & Target PBB-P2');
    }

    public function test_penggunaan_pajak_page_loads(): void
    {
        $response = $this->get('/penggunaan');
        $response->assertStatus(200);
        $response->assertSee('Penggunaan Pajak');
        $response->assertSee('Pembangunan Infrastruktur');
    }

    public function test_informasi_page_loads(): void
    {
        $response = $this->get('/informasi');
        $response->assertStatus(200);
        $response->assertSee('Informasi');
        $response->assertSee('Berita Terbaru');
        $response->assertSee('FAQ');
    }

    public function test_cek_pbb_online_lookup(): void
    {
        $op = ObjekPajak::first();
        $response = $this->get('/cek-pbb?nop=' . urlencode($op->nop) . '&tahun=2026');
        $response->assertStatus(200);
        $response->assertSee($op->nop);
        $response->assertSee($op->wajibPajak->nama_wajib_pajak);
    }

    public function test_manajemen_pengguna_and_keamanan_pages_load(): void
    {
        $resUsers = $this->get('/pengaturan/users');
        $resUsers->assertStatus(200);
        $resUsers->assertSee('Manajemen Pengguna');

        $resKeamanan = $this->get('/pengaturan/keamanan');
        $resKeamanan->assertStatus(200);
        $resKeamanan->assertSee('Keamanan Sistem');
    }

    public function test_login_and_register_pages_load(): void
    {
        $resLogin = $this->get('/login');
        $resLogin->assertStatus(200);
        $resLogin->assertSee('Login');

        $resRegister = $this->get('/register');
        $resRegister->assertStatus(200);
        $resRegister->assertSee('Daftar Akun');

        $resAuthPhp = $this->get('/auth.php');
        $resAuthPhp->assertRedirect(route('login'));
    }

    public function test_user_can_login_with_correct_credentials(): void
    {
        // 1. Login with full email
        $response = $this->post('/login', [
            'email' => 'admin@karawangkab.go.id',
            'password' => 'password',
        ]);
        $response->assertRedirect(route('dashboard'));
        $this->assertAuthenticated();

        // Logout
        $this->post('/logout');
        $this->assertGuest();

        // 2. Login with username 'admin' and password 'admin123'
        $response2 = $this->post('/login', [
            'email' => 'admin',
            'password' => 'admin123',
        ]);
        $response2->assertRedirect(route('dashboard'));
        $this->assertAuthenticated();
    }

    public function test_date_range_filter_works_across_pages(): void
    {
        // 1. Dashboard with Q1 2026 filter
        $resDashboard = $this->get('/?start_date=2026-01-01&end_date=2026-03-31');
        $resDashboard->assertStatus(200);
        $resDashboard->assertSee('1 Jan - 31 Mar 2026');

        // 2. Peta page with Year 2025 filter
        $resPeta = $this->get('/peta?start_date=2025-01-01&end_date=2025-12-31');
        $resPeta->assertStatus(200);
        $resPeta->assertSee('1 Jan 2025 - 31 Des 2025');

        // 3. Realisasi page with Semester 1 filter
        $resRealisasi = $this->get('/realisasi?start_date=2026-01-01&end_date=2026-06-30');
        $resRealisasi->assertStatus(200);
        $resRealisasi->assertSee('1 Jan - 30 Jun 2026');

        // 4. Penggunaan page with Year 2024 filter
        $resPenggunaan = $this->get('/penggunaan?start_date=2024-01-01&end_date=2024-12-31');
        $resPenggunaan->assertStatus(200);
        $resPenggunaan->assertSee('1 Jan 2024 - 31 Des 2024');

        // 5. Informasi page with date filter
        $resInfo = $this->get('/informasi?start_date=2026-10-01&end_date=2026-10-31');
        $resInfo->assertStatus(200);
        $resInfo->assertSee('1 Okt - 31 Okt 2026');
    }
}
