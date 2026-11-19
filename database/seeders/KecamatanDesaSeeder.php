<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KecamatanDesaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dataKecamatan = [
            [
                'nama' => 'Karawang Barat',
                'kode' => '32.15.01',
                'lat' => -6.3023,
                'lng' => 107.2965,
                'luas' => 33.68,
                'desa' => [
                    'Karangpawitan', 'Nagasari', 'Karawang Kulon', 'Adiarsa Barat',
                    'Tanjungpura', 'Tanjungmekar', 'Tunggakjati', 'Mekarjati'
                ]
            ],
            [
                'nama' => 'Karawang Timur',
                'kode' => '32.15.02',
                'lat' => -6.3148,
                'lng' => 107.3361,
                'luas' => 28.52,
                'desa' => [
                    'Adiarsa Timur', 'Warungbambu', 'Kondangjaya', 'Margasari',
                    'Karawang Wetan', 'Palumbonsari', 'Palawad', 'Tegalsawah'
                ]
            ],
            [
                'nama' => 'Majalaya',
                'kode' => '32.15.03',
                'lat' => -6.2862,
                'lng' => 107.3884,
                'luas' => 31.95,
                'desa' => [
                    'Pasirjengkol', 'Ciranggon', 'Majalaya', 'Sarijaya',
                    'Bengle', 'Lemahmulya', 'Pasirmulya'
                ]
            ],
            [
                'nama' => 'Klari',
                'kode' => '32.15.04',
                'lat' => -6.3752,
                'lng' => 107.3751,
                'luas' => 61.45,
                'desa' => [
                    'Karanganyar', 'Curug', 'Cimahi', 'Sumurkondang', 'Walahar',
                    'Kiarapayung', 'Gintungkerta', 'Anggadita', 'Klari',
                    'Cibalongsari', 'Duren', 'Pancawati', 'Belendung'
                ]
            ],
            [
                'nama' => 'Ciampel',
                'kode' => '32.15.05',
                'lat' => -6.4412,
                'lng' => 107.3298,
                'luas' => 97.43,
                'desa' => [
                    'Tegalega', 'Mulyasari', 'Mulyasejati', 'Kutanegara',
                    'Kutapohaci', 'Kutamekar', 'Parungmulya'
                ]
            ],
            [
                'nama' => 'Telukjambe Barat',
                'kode' => '32.15.06',
                'lat' => -6.3456,
                'lng' => 107.2412,
                'luas' => 74.52,
                'desa' => [
                    'Wanajaya', 'Wanakerta', 'Wanasari', 'Margamulya',
                    'Margakaya', 'Karangligar', 'Karangmulya', 'Mulyajaya',
                    'Mekarmulya', 'Parungsari'
                ]
            ],
            [
                'nama' => 'Telukjambe Timur',
                'kode' => '32.15.07',
                'lat' => -6.3387,
                'lng' => 107.3021,
                'luas' => 40.12,
                'desa' => [
                    'Sukamakmur', 'Purwadana', 'Wadas', 'Sukaharja',
                    'Sukaluyu', 'Puserjaya', 'Telukjambe', 'Pinayungan', 'Sirnabaya'
                ]
            ],
            [
                'nama' => 'Tegalwaru',
                'kode' => '32.15.08',
                'lat' => -6.5361,
                'lng' => 107.2274,
                'luas' => 110.23,
                'desa' => [
                    'Cipurwasari', 'Cigunungsari', 'Wargaserta', 'Mekarbuana',
                    'Cintalaksana', 'Cintawargi', 'Cintalanggeng', 'Kutamaneuh', 'Kutalanggeng'
                ]
            ],
            [
                'nama' => 'Pangkalan',
                'kode' => '32.15.09',
                'lat' => -6.4678,
                'lng' => 107.2145,
                'luas' => 93.41,
                'desa' => [
                    'Medalsari', 'Kertasari', 'Cintaasih', 'Mulangsari',
                    'Jatilaksana', 'Ciptasari', 'Tamansari', 'Tamanmekar'
                ]
            ],
            [
                'nama' => 'Cikampek',
                'kode' => '32.15.10',
                'lat' => -6.4172,
                'lng' => 107.4589,
                'luas' => 35.82,
                'desa' => [
                    'Kalihurip', 'Kamojing', 'Cikampek Timur', 'Cikampek Pusaka',
                    'Cikampek Selatan', 'Cikampek Kota', 'Cikampek Barat',
                    'Dawuan Timur', 'Dawuan Tengah', 'Dawuan Barat'
                ]
            ],
            [
                'nama' => 'Purwasari',
                'kode' => '32.15.11',
                'lat' => -6.3912,
                'lng' => 107.4124,
                'luas' => 31.64,
                'desa' => [
                    'Mekarjaya', 'Tamelang', 'Purwasari', 'Sukasari',
                    'Tegalsari', 'Karangsari', 'Darawolong', 'Cengkong'
                ]
            ],
            [
                'nama' => 'Tirtamulya',
                'kode' => '32.15.12',
                'lat' => -6.3681,
                'lng' => 107.4812,
                'luas' => 39.81,
                'desa' => [
                    'Karangsinom', 'Karangjaya', 'Parakanmulya', 'Citarik',
                    'Tirtasari', 'Parakan', 'Kamurang', 'Bojongsari',
                    'Cipondoh', 'Kertawaluya'
                ]
            ],
            [
                'nama' => 'Jatisari',
                'kode' => '32.15.13',
                'lat' => -6.3774,
                'lng' => 107.5312,
                'luas' => 52.88,
                'desa' => [
                    'Barungbung', 'Situdam', 'Balonggandu', 'Kalijati',
                    'Mekarsari', 'Jatisari', 'Cirejag', 'Cikalongsari',
                    'Jatiragas', 'Jatiwangi', 'Jatibaru', 'Telarsari', 'Pacing', 'Sukamekar'
                ]
            ],
            [
                'nama' => 'Banyusari',
                'kode' => '32.15.14',
                'lat' => -6.3074,
                'lng' => 107.5521,
                'luas' => 54.32,
                'desa' => [
                    'Pamekaran', 'Cicinde Selatan', 'Cicinde Utara', 'Jayamukti',
                    'Gempol Kolot', 'Gempol', 'Gembongan', 'Mekarasih',
                    'Banyuasih', 'Talunjaya', 'Tanjung', 'Kutaraharja'
                ]
            ],
            [
                'nama' => 'Kotabaru',
                'kode' => '32.15.15',
                'lat' => -6.3948,
                'lng' => 107.4871,
                'luas' => 30.74,
                'desa' => [
                    'Pucung', 'Wancimekar', 'Pangulah Selatan', 'Pangulah Utara',
                    'Pangulah Baru', 'Jomin Timur', 'Jomin Barat', 'Sarimulya', 'Cikampek Utara'
                ]
            ],
            [
                'nama' => 'Cilamaya Wetan',
                'kode' => '32.15.16',
                'lat' => -6.2589,
                'lng' => 107.5678,
                'luas' => 67.21,
                'desa' => [
                    'Cikarang', 'Cikalong', 'Tegalsari', 'Tegalwaru',
                    'Mekarmaya', 'Cilamaya', 'Sukatani', 'Sukakerta',
                    'Rawagempol Kulon', 'Rawagempol Wetan', 'Muarabaru', 'Muara'
                ]
            ],
            [
                'nama' => 'Cilamaya Kulon',
                'kode' => '32.15.17',
                'lat' => -6.2412,
                'lng' => 107.5023,
                'luas' => 61.85,
                'desa' => [
                    'Kiara', 'Langensari', 'Bayurkidul', 'Bayurlor',
                    'Sukamulya', 'Pasirukem', 'Tegalulung', 'Manggungjaya',
                    'Sumurgede', 'Muktijaya', 'Pasirjaya', 'Sukajaya'
                ]
            ],
            [
                'nama' => 'Lemahabang',
                'kode' => '32.15.18',
                'lat' => -6.2815,
                'lng' => 107.4561,
                'luas' => 48.72,
                'desa' => [
                    'Ciwaringin', 'Waringinkarya', 'Pasirtanjung', 'Karangtanjung',
                    'Kedawung', 'Lemahabang', 'Karyamukti', 'Pulojaya',
                    'Pulokalapa', 'Lemahmukti', 'Pulomulya'
                ]
            ],
            [
                'nama' => 'Telagasari',
                'kode' => '32.15.19',
                'lat' => -6.2874,
                'lng' => 107.4115,
                'luas' => 49.32,
                'desa' => [
                    'Pasirtalaga', 'Talagamulya', 'Cariumulya', 'Cilewo',
                    'Linggarsari', 'Pulosari', 'Ciwulan', 'Kalijaya',
                    'Cadaskertajaya', 'Talagasari', 'Kalibuaya', 'Pasirmukti',
                    'Pasirkamuning', 'Kalisari'
                ]
            ],
            [
                'nama' => 'Rawamerta',
                'kode' => '32.15.20',
                'lat' => -6.2312,
                'lng' => 107.3621,
                'luas' => 47.92,
                'desa' => [
                    'Pasirkaliki', 'Kutawargi', 'Cibadak', 'Sukamerta',
                    'Pasirawi', 'Balongsari', 'Purwamekar', 'Mekarjaya',
                    'Sekarwangi', 'Panyingkiran', 'Sukapura', 'Gembongsari', 'Sukaraja'
                ]
            ],
            [
                'nama' => 'Tempuran',
                'kode' => '32.15.21',
                'lat' => -6.1965,
                'lng' => 107.4371,
                'luas' => 70.82,
                'desa' => [
                    'Dayeuhluhur', 'Lemahkarya', 'Lemahduhur', 'Lemahsubur',
                    'Lemahmakmur', 'Pagadungan', 'Purwajaya', 'Jayanagara',
                    'Tempuran', 'Ciparagejaya', 'Cikuntul', 'Sumberjaya',
                    'Pancakarya', 'Tanjungjaya'
                ]
            ],
            [
                'nama' => 'Kutawaluya',
                'kode' => '32.15.22',
                'lat' => -6.1974,
                'lng' => 107.3415,
                'luas' => 51.24,
                'desa' => [
                    'Sindangkarya', 'Sindangmukti', 'Sindangmulya', 'Mulyajaya',
                    'Kutakarya', 'Kutagandok', 'Waluya', 'Sampalan',
                    'Sindangsari', 'Kutaraja', 'Kutamukti', 'Kutajaya'
                ]
            ],
            [
                'nama' => 'Rengasdengklok',
                'kode' => '32.15.23',
                'lat' => -6.1623,
                'lng' => 107.2981,
                'luas' => 31.42,
                'desa' => [
                    'Karangsari / Kalangsari', 'Karangsuria', 'Karyasari', 'Dukuhkarya',
                    'Amansari', 'Rengasdengklok Selatan', 'Rengasdengklok Utara', 'Kertasari', 'Dewisari'
                ]
            ],
            [
                'nama' => 'Jayakerta',
                'kode' => '32.15.24',
                'lat' => -6.1315,
                'lng' => 107.3112,
                'luas' => 38.65,
                'desa' => [
                    'Medangasem', 'Kemiri', 'Makmurjaya', 'Jayamakmur',
                    'Jayakerta', 'Ciptamarga', 'Kertajaya', 'Kampungsawah'
                ]
            ],
            [
                'nama' => 'Pedes',
                'kode' => '32.15.25',
                'lat' => -6.1215,
                'lng' => 107.3912,
                'luas' => 61.42,
                'desa' => [
                    'Jatimulya', 'Kertaraharja', 'Karangjaya', 'Malangsari',
                    'Kertamulya', 'Payungsari', 'Randumulya', 'Labanjaya',
                    'Sungaibuntu', 'Kendaljaya', 'Dongkal', 'Puspasari'
                ]
            ],
            [
                'nama' => 'Cilebar',
                'kode' => '32.15.26',
                'lat' => -6.1512,
                'lng' => 107.4468,
                'luas' => 65.41,
                'desa' => [
                    'Sukaratu', 'Ciptamargi', 'Tanjungsari', 'Mekarpohaci',
                    'Kertamukti', 'Cikande', 'Rawasari', 'Kosambibaru',
                    'Pusakajaya Selatan', 'Pusakajaya Utara'
                ]
            ],
            [
                'nama' => 'Cibuaya',
                'kode' => '32.15.27',
                'lat' => -6.0715,
                'lng' => 107.3712,
                'luas' => 86.23,
                'desa' => [
                    'Sukasari', 'Kertarahayu', 'Cibuaya', 'Pejaten',
                    'Kedungjeruk', 'Kalidungjaya', 'Kedungjaya', 'Jayamulya',
                    'Gebangjaya', 'Cemarajaya', 'Sedari'
                ]
            ],
            [
                'nama' => 'Tirtajaya',
                'kode' => '32.15.28',
                'lat' => -6.0612,
                'lng' => 107.2315,
                'luas' => 93.74,
                'desa' => [
                    'Medankarya', 'Pisangsambo', 'Sabajaya', 'Gempoljaya',
                    'Sarijaya', 'Kutamakmur', 'Bolang', 'Srikamulyan',
                    'Sumurlaban', 'Tambaksumur', 'Tambaksari'
                ]
            ],
            [
                'nama' => 'Batujaya',
                'kode' => '32.15.29',
                'lat' => -6.0823,
                'lng' => 107.1721,
                'luas' => 84.12,
                'desa' => [
                    'Segarjaya', 'Segaran', 'Batujaya', 'Baturaden',
                    'Karyabakti', 'Telukambulu', 'Telukbango', 'Karyamulya',
                    'Karyamakmur', 'Kutaampel'
                ]
            ],
            [
                'nama' => 'Pakisjaya',
                'kode' => '32.15.30',
                'lat' => -6.0215,
                'lng' => 107.1321,
                'luas' => 65.21,
                'desa' => [
                    'Telagajaya', 'Telukbuyung', 'Tanahbaru', 'Solokan',
                    'Tanjungbungin', 'Tanjungmekar', 'Tanjungpakis'
                ]
            ],
        ];

        $now = now();
        $desaCount = 0;

        foreach ($dataKecamatan as $kecIndex => $kec) {
            $idKecamatan = DB::table('kecamatan')->insertGetId([
                'nama_kecamatan' => $kec['nama'],
                'kode_kecamatan' => $kec['kode'],
                'latitude' => $kec['lat'],
                'longitude' => $kec['lng'],
                'luas_wilayah' => $kec['luas'],
                'jumlah_penduduk' => rand(45000, 180000),
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            $totalDesa = count($kec['desa']);
            foreach ($kec['desa'] as $dIndex => $namaDesa) {
                $desaCount++;
                // calculate offset coordinates around kecamatan center
                $angle = ($dIndex / max(1, $totalDesa)) * 2 * M_PI;
                $radius = 0.015 + (0.01 * ($dIndex % 3));
                $dLat = $kec['lat'] + ($radius * sin($angle));
                $dLng = $kec['lng'] + ($radius * cos($angle));
                $jenis = str_contains(strtolower($namaDesa), 'karangpawitan') || 
                         str_contains(strtolower($namaDesa), 'nagasari') || 
                         str_contains(strtolower($namaDesa), 'karawang') ||
                         str_contains(strtolower($namaDesa), 'adiarsa') ? 'Kelurahan' : 'Desa';

                DB::table('desa')->insert([
                    'id_kecamatan' => $idKecamatan,
                    'nama_desa' => $namaDesa,
                    'kode_desa' => $kec['kode'] . '.' . str_pad($dIndex + 1, 4, '2000', STR_PAD_LEFT),
                    'jenis' => $jenis,
                    'latitude' => round($dLat, 6),
                    'longitude' => round($dLng, 6),
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }
        }
    }
}
