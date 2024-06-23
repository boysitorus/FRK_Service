<?php

namespace Database\Seeders;

use App\Models\DetailPendidikan;
use App\Models\DetailPenelitian;
use App\Models\DetailPengabdian;
use App\Models\DetailPenunjang;
use App\Models\Rencana;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RencanaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //DEFINE ID DOSEN
        $id_dosen = 1435;
        $jumlahPerRencana = 2;
        $sks_terhitung = 2.00;
        // PENDIDIKAN
        // TEORI
        for ($i = 1; $i <= $jumlahPerRencana; $i++) {
            $rencana = Rencana::create([
                'asesor1_frk' => 'setuju',
                'asesor2_frk' => 'setuju',
                'id_tanggal_frk' => 2,
                'id_tanggal_fed' => 1,
                "nama_kegiatan" => "Test Pendidikan A " . $i,
                "jenis_rencana" => "pendidikan",
                "sub_rencana" => "teori",
                "id_dosen" => $id_dosen,
                "sks_terhitung" => $sks_terhitung
            ]);

            DetailPendidikan::create([
                'id_rencana' => $rencana->id_rencana,
                'sks_matakuliah' => 2,
                'jumlah_evaluasi' => 2,
                'jumlah_kelas' => 2
            ]);
        }

        //PRAKTIKUM
        for ($i = 1; $i <= $jumlahPerRencana; $i++) {
            $rencana = Rencana::create([
                'asesor1_frk' => 'setuju',
                'asesor2_frk' => 'setuju',
                'id_tanggal_frk' => 2,
                'id_tanggal_fed' => 1,
                'jenis_rencana' => 'pendidikan',
                'sub_rencana' => 'praktikum',
                'id_dosen' => $id_dosen,
                'nama_kegiatan' => "Test Pendidikan B " . $i,
                'sks_terhitung' => $sks_terhitung
            ]);

            DetailPendidikan::create([
                'id_rencana' => $rencana->id_rencana,
                'jumlah_kelas' => 2,
                'sks_matakuliah' => 2
            ]);
        }

        //BIMBINGAN
        for ($i = 1; $i <= $jumlahPerRencana; $i++) {
            $rencana = Rencana::create([
                'asesor1_frk' => 'setuju',
                'asesor2_frk' => 'setuju',
                'id_tanggal_frk' => 2,
                'id_tanggal_fed' => 1,
                'jenis_rencana' => 'pendidikan',
                'sub_rencana' => 'bimbingan',
                'id_dosen' => $id_dosen,
                'nama_kegiatan' => "Test Pendidikan C " . $i,
                'sks_terhitung' => $sks_terhitung,
            ]);

            DetailPendidikan::create([
                'id_rencana' => $rencana->id_rencana,
                'jumlah_mahasiswa' => 2
            ]);
        }

        //SEMINAR
        for ($i = 1; $i <= $jumlahPerRencana; $i++) {
            $rencana = Rencana::create([
                'asesor1_frk' => 'setuju',
                'asesor2_frk' => 'setuju',
                'id_tanggal_frk' => 2,
                'id_tanggal_fed' => 1,
                'jenis_rencana' => 'pendidikan',
                'sub_rencana' => 'seminar',
                'id_dosen' => $id_dosen,
                'nama_kegiatan' => "Test Pendidikan D " . $i,
                'sks_terhitung' => $sks_terhitung,
            ]);

            DetailPendidikan::create([
                'id_rencana' => $rencana->id_rencana,
                'jumlah_kelompok' => 2
            ]);
        }

        //TUGAS AKHIR
        for ($i = 1; $i <= $jumlahPerRencana; $i++) {
            $rencana = Rencana::create([
                'asesor1_frk' => 'setuju',
                'asesor2_frk' => 'setuju',
                'id_tanggal_frk' => 2,
                'id_tanggal_fed' => 1,
                'jenis_rencana' => 'pendidikan',
                'sub_rencana' => 'tugasAkhir',
                'id_dosen' => $id_dosen,
                'nama_kegiatan' => "Test Pendidikan E " . $i,
                'sks_terhitung' => $sks_terhitung,
            ]);

            DetailPendidikan::create([
                'id_rencana' => $rencana->id_rencana,
                'jumlah_kelompok' => 2
            ]);
        }

        //PROPOSAL
        for ($i = 1; $i <= $jumlahPerRencana; $i++) {
            $rencana = Rencana::create([
                'asesor1_frk' => 'setuju',
                'asesor2_frk' => 'setuju',
                'id_tanggal_frk' => 2,
                'id_tanggal_fed' => 1,
                'jenis_rencana' => 'pendidikan',
                'sub_rencana' => 'proposal',
                'id_dosen' => $id_dosen,
                'nama_kegiatan' => "Test Pendidikan F " . $i,
                'sks_terhitung' => $sks_terhitung,
            ]);

            DetailPendidikan::create([
                'id_rencana' => $rencana->id_rencana,
                'jumlah_mahasiswa' => 2
            ]);
        }

        //RENDAH
        for ($i = 1; $i <= $jumlahPerRencana; $i++) {
            $rencana = Rencana::create([
                'asesor1_frk' => 'setuju',
                'asesor2_frk' => 'setuju',
                'id_tanggal_frk' => 2,
                'id_tanggal_fed' => 1,
                'jenis_rencana' => 'pendidikan',
                'sub_rencana' => 'bimbing_rendah',
                'id_dosen' => $id_dosen,
                'nama_kegiatan' => "Test Pendidikan G " . $i,
                'sks_terhitung' => $sks_terhitung,
            ]);

            DetailPendidikan::create([
                'id_rencana' => $rencana->id_rencana,
                'jumlah_dosen' => 2
            ]);
        }

        //KEMBANG
        for ($i = 1; $i <= $jumlahPerRencana; $i++) {
            $rencana = Rencana::create([
                'asesor1_frk' => 'setuju',
                'asesor2_frk' => 'setuju',
                'id_tanggal_frk' => 2,
                'id_tanggal_fed' => 1,
                'jenis_rencana' => 'pendidikan',
                'sub_rencana' => 'pengembangan',
                'id_dosen' => $id_dosen,
                'nama_kegiatan' => "Test Pendidikan H " . $i,
                'sks_terhitung' => $sks_terhitung,
            ]);

            DetailPendidikan::create([
                'id_rencana' => $rencana->id_rencana,
                'jumlah_sap' => 2
            ]);
        }

        //CANGKOK
        for ($i = 1; $i <= $jumlahPerRencana; $i++) {
            $rencana = Rencana::create([
                'asesor1_frk' => 'setuju',
                'asesor2_frk' => 'setuju',
                'id_tanggal_frk' => 2,
                'id_tanggal_fed' => 1,
                'jenis_rencana' => 'pendidikan',
                'sub_rencana' => 'cangkok',
                'id_dosen' => $id_dosen,
                'nama_kegiatan' => "Test Pendidikan I " . $i,
                'sks_terhitung' => $sks_terhitung,
            ]);

            DetailPendidikan::create([
                'id_rencana' => $rencana->id_rencana,
                'jumlah_dosen' => 2
            ]);
        }

        //KOORDINATOR
        for ($i = 1; $i <= $jumlahPerRencana; $i++) {
            $rencana = Rencana::create([
                'asesor1_frk' => 'setuju',
                'asesor2_frk' => 'setuju',
                'id_tanggal_frk' => 2,
                'id_tanggal_fed' => 1,
                'jenis_rencana' => 'pendidikan',
                'sub_rencana' => 'koordinator',
                'id_dosen' => $id_dosen,
                'nama_kegiatan' => "Test Pendidikan J " . $i,
                'sks_terhitung' => $sks_terhitung,
            ]);

            DetailPendidikan::create([
                'id_rencana' => $rencana->id_rencana
            ]);
        }


        // PENELITIAN
        //A
        for ($i = 1; $i <= $jumlahPerRencana; $i++) {
            $rencana = Rencana::create([
                'asesor1_frk' => 'setuju',
                'asesor2_frk' => 'setuju',
                'id_tanggal_frk' => 2,
                'id_tanggal_fed' => 1,
                'jenis_rencana' => 'penelitian',
                'sub_rencana' => 'penelitian_kelompok',
                'id_dosen' => $id_dosen,
                'nama_kegiatan' => "Test Penelitian A " . $i,
                'sks_terhitung' => round($sks_terhitung, 2),
            ]);

            DetailPenelitian::create([
                'id_rencana' => $rencana->id_rencana,
                'status_tahapan' => "Proposal",
                'posisi' => "Ketua",
                'jumlah_anggota' => 2
            ]);
        }

        //B
        for ($i = 1; $i <= $jumlahPerRencana; $i++) {
            $rencana = Rencana::create([
                'asesor1_frk' => 'setuju',
                'asesor2_frk' => 'setuju',
                'id_tanggal_frk' => 2,
                'id_tanggal_fed' => 1,
                'jenis_rencana' => 'penelitian',
                'sub_rencana' => 'penelitian_mandiri',
                'id_dosen' => $id_dosen,
                'nama_kegiatan' => "Test Penelitian B " . $i,
                'sks_terhitung' => round($sks_terhitung, 2),
            ]);

            DetailPenelitian::create([
                'id_rencana' => $rencana->id_rencana,
                'status_tahapan' => "Proposal"
            ]);
        }

        //C
        for ($i = 1; $i <= $jumlahPerRencana; $i++) {
            $rencana = Rencana::create([
                'asesor1_frk' => 'setuju',
                'asesor2_frk' => 'setuju',
                'id_tanggal_frk' => 2,
                'id_tanggal_fed' => 1,
                'jenis_rencana' => 'penelitian',
                'sub_rencana' => 'buku_terbit',
                'id_dosen' => $id_dosen,
                'nama_kegiatan' => "Test Penelitian C " . $i,
                'sks_terhitung' => round($sks_terhitung, 3)
            ]);

            DetailPenelitian::create([
                'id_rencana' => $rencana->id_rencana,
                'jenis_pengerjaan' => "Mandiri",
                'status_tahapan' => "Pendahuluan",
                'peran' => "Editor"
            ]);
        }

        //D
        for ($i = 1; $i <= $jumlahPerRencana; $i++) {
            $rencana = Rencana::create([
                'asesor1_frk' => 'setuju',
                'asesor2_frk' => 'setuju',
                'id_tanggal_frk' => 2,
                'id_tanggal_fed' => 1,
                'jenis_rencana' => 'penelitian',
                'sub_rencana' => 'buku_internasional',
                'id_dosen' => $id_dosen,
                'nama_kegiatan' => "Test Penelitian D " . $i,
                'sks_terhitung' => round($sks_terhitung, 2)
            ]);

            DetailPenelitian::create([
                'id_rencana' => $rencana->id_rencana,
                'jenis_pengerjaan' => "Mandiri",
                'status_tahapan' => "Pendahuluan",
                'peran' => "Editor"
            ]);
        }

        //E
        for ($i = 1; $i <= $jumlahPerRencana; $i++) {
            $rencana = Rencana::create([
                'asesor1_frk' => 'setuju',
                'asesor2_frk' => 'setuju',
                'id_tanggal_frk' => 2,
                'id_tanggal_fed' => 1,
                'jenis_rencana' => 'penelitian',
                'sub_rencana' => 'menyadur',
                'id_dosen' => $id_dosen,
                'nama_kegiatan' => "Test Penelitian E " . $i,
                'sks_terhitung' => round($sks_terhitung, 2),
            ]);

            DetailPenelitian::create([
                'id_rencana' => $rencana->id_rencana,
                'status_tahapan' => "Pendahuluan",
                'posisi' => "Ketua",
            ]);
        }

        //F
        for ($i = 1; $i <= $jumlahPerRencana; $i++) {
            $rencana = Rencana::create([
                'asesor1_frk' => 'setuju',
                'asesor2_frk' => 'setuju',
                'id_tanggal_frk' => 2,
                'id_tanggal_fed' => 1,
                'jenis_rencana' => 'penelitian',
                'sub_rencana' => 'menyunting',
                'id_dosen' => $id_dosen,
                'nama_kegiatan' => "Test Penelitian F " . $i,
                'sks_terhitung' => round($sks_terhitung, 2),
            ]);

            DetailPenelitian::create([
                'id_rencana' => $rencana->id_rencana,
                'status_tahapan' => "Pendahuluan",
                'posisi' => "Ketua",
            ]);
        }

        //G
        for ($i = 1; $i <= $jumlahPerRencana; $i++) {
            $rencana = Rencana::create([
                'asesor1_frk' => 'setuju',
                'asesor2_frk' => 'setuju',
                'id_tanggal_frk' => 2,
                'id_tanggal_fed' => 1,
                'jenis_rencana' => 'penelitian',
                'sub_rencana' => 'penelitian_modul',
                'id_dosen' => $id_dosen,
                'nama_kegiatan' => "Test Penelitian G " . $i,
                'sks_terhitung' => round($sks_terhitung, 2),
            ]);

            DetailPenelitian::create([
                'id_rencana' => $rencana->id_rencana,
                'status_tahapan' => "Hasil Akhir",
                'jenis_pengerjaan' => "Mandiri",
                'peran' => "Anggota"
            ]);
        }

        //H
        for ($i = 1; $i <= $jumlahPerRencana; $i++) {
            $rencana = Rencana::create([
                'asesor1_frk' => 'setuju',
                'asesor2_frk' => 'setuju',
                'id_tanggal_frk' => 2,
                'id_tanggal_fed' => 1,
                'jenis_rencana' => 'penelitian',
                'sub_rencana' => 'penelitian_pekerti',
                'id_dosen' => $id_dosen,
                'nama_kegiatan' => "Test Penelitian H " . $i,
                'sks_terhitung' => $sks_terhitung,
            ]);

            DetailPenelitian::create([
                'id_rencana' => $rencana->id_rencana,
            ]);
        }

        //I
        for ($i = 1; $i <= $jumlahPerRencana; $i++) {
            $rencana = Rencana::create([
                'asesor1_frk' => 'setuju',
                'asesor2_frk' => 'setuju',
                'id_tanggal_frk' => 2,
                'id_tanggal_fed' => 1,
                'jenis_rencana' => 'penelitian',
                'sub_rencana' => 'penelitian_tridharma',
                'id_dosen' => $id_dosen,
                'nama_kegiatan' => "Test Penelitian I " . $i,
                'sks_terhitung' => round($sks_terhitung, 2),
            ]);

            DetailPenelitian::create([
                'id_rencana' => $rencana->id_rencana,
                'jumlah_bkd' => 2
            ]);
        }

        //J
        for ($i = 1; $i <= $jumlahPerRencana; $i++) {
            $rencana = Rencana::create([
                'asesor1_frk' => 'setuju',
                'asesor2_frk' => 'setuju',
                'id_tanggal_frk' => 2,
                'id_tanggal_fed' => 1,
                'jenis_rencana' => 'penelitian',
                'sub_rencana' => 'jurnal_ilmiah',
                'id_dosen' => $id_dosen,
                'nama_kegiatan' => "Test Penelitian J " . $i,
                'sks_terhitung' => round($sks_terhitung, 2),
            ]);

            DetailPenelitian::create([
                'id_rencana' => $rencana->id_rencana,
                'jenis_pengerjaan' => "Mandiri",
                'lingkup_penerbit' => "Diterbitkan oleh Jurnal terakreditasi",
                'peran' => "Penulis Utama"
            ]);
        }

        //K
        for ($i = 1; $i <= $jumlahPerRencana; $i++) {
            $rencana = Rencana::create([
                'asesor1_frk' => 'setuju',
                'asesor2_frk' => 'setuju',
                'id_tanggal_frk' => 2,
                'id_tanggal_fed' => 1,
                'jenis_rencana' => 'penelitian',
                'sub_rencana' => 'hak_paten',
                'id_dosen' => $id_dosen,
                'nama_kegiatan' => "Test Penelitian K " . $i,
                'sks_terhitung' => round($sks_terhitung, 2),
            ]);

            DetailPenelitian::create([
                'id_rencana' => $rencana->id_rencana,
                'lingkup_wilayah' => "Paten internasional(minimal tiga negara)",
            ]);
        }

        //L
        for ($i = 1; $i <= $jumlahPerRencana; $i++) {
            $rencana = Rencana::create([
                'asesor1_frk' => 'setuju',
                'asesor2_frk' => 'setuju',
                'id_tanggal_frk' => 2,
                'id_tanggal_fed' => 1,
                'jenis_rencana' => 'penelitian',
                'sub_rencana' => 'media_massa',
                'id_dosen' => $id_dosen,
                'nama_kegiatan' => "Test Penelitian L " . $i,
                'sks_terhitung' => round($sks_terhitung, 2),
            ]);

            DetailPenelitian::create([
                'id_rencana' => $rencana->id_rencana,
            ]);
        }

        //M
        for ($i = 1; $i <= $jumlahPerRencana; $i++) {
            $rencana = Rencana::create([
                'asesor1_frk' => 'setuju',
                'asesor2_frk' => 'setuju',
                'id_tanggal_frk' => 2,
                'id_tanggal_fed' => 1,
                'jenis_rencana' => 'penelitian',
                'sub_rencana' => 'pembicara_seminar',
                'id_dosen' => $id_dosen,
                'nama_kegiatan' => "Test Penelitian M " . $i,
                'sks_terhitung' => round($sks_terhitung, 2),
            ]);

            DetailPenelitian::create([
                'id_rencana' => $rencana->id_rencana,
                'lingkup_wilayah' => "Tingkat Regional/minimal fakultas",
            ]);
        }

        //N
        for ($i = 1; $i <= $jumlahPerRencana; $i++) {
            $rencana = Rencana::create([
                'asesor1_frk' => 'setuju',
                'asesor2_frk' => 'setuju',
                'id_tanggal_frk' => 2,
                'id_tanggal_fed' => 1,
                'jenis_rencana' => 'penelitian',
                'sub_rencana' => 'penyajian_makalah',
                'id_dosen' => $id_dosen,
                'nama_kegiatan' => "Test Penelitian N " . $i,
                'sks_terhitung' => round($sks_terhitung, 2),
            ]);

            DetailPenelitian::create([
                'id_rencana' => $rencana->id_rencana,
                'lingkup_wilayah' => "Tingkat regional daerah, institusional(minimum fakultas)",
                'posisi' => "Ketua",
                'jumlah_anggota' => 2,
                'jenis_pengerjaan' => "Individual",
            ]);
        }

        //PENGABDIAN
        //A
        for ($i = 1; $i <= $jumlahPerRencana; $i++) {
            $rencana = Rencana::create([
                'asesor1_frk' => 'setuju',
                'asesor2_frk' => 'setuju',
                'id_tanggal_frk' => 2,
                'id_tanggal_fed' => 1,
                'jenis_rencana' => 'pengabdian',
                'sub_rencana' => 'kegiatan',
                'id_dosen' => $id_dosen,
                'nama_kegiatan' => "Test Pengabdian A " . $i,
                'sks_terhitung' => round($sks_terhitung, 2),
            ]);

            DetailPengabdian::create([
                'id_rencana' => $rencana->id_rencana,
                'jumlah_durasi' => 20
            ]);
        }

        //B
        for ($i = 1; $i <= $jumlahPerRencana; $i++) {
            $rencana = Rencana::create([
                'asesor1_frk' => 'setuju',
                'asesor2_frk' => 'setuju',
                'id_tanggal_frk' => 2,
                'id_tanggal_fed' => 1,
                'jenis_rencana' => 'pengabdian',
                'sub_rencana' => 'penyuluhan',
                'id_dosen' => $id_dosen,
                'nama_kegiatan' => "Test Pengabdian B " . $i,
                'sks_terhitung' => round($sks_terhitung, 2),
            ]);

            DetailPengabdian::create([
                'id_rencana' => $rencana->id_rencana,
                'jumlah_durasi' => 20
            ]);
        }

        //C
        for ($i = 1; $i <= $jumlahPerRencana; $i++) {
            $rencana = Rencana::create([
                'asesor1_frk' => 'setuju',
                'asesor2_frk' => 'setuju',
                'id_tanggal_frk' => 2,
                'id_tanggal_fed' => 1,
                'jenis_rencana' => 'pengabdian',
                'sub_rencana' => 'konsultan',
                'id_dosen' => $id_dosen,
                'nama_kegiatan' => "Test Pengabdian C " . $i,
                'sks_terhitung' => round($sks_terhitung, 2),
            ]);
            DetailPengabdian::create([
                'id_rencana' => $rencana->id_rencana,
                'posisi' => "Ketua",
            ]);
        }

        //D
        for ($i = 1; $i <= $jumlahPerRencana; $i++) {
            $rencana = Rencana::create([
                'asesor1_frk' => 'setuju',
                'asesor2_frk' => 'setuju',
                'id_tanggal_frk' => 2,
                'id_tanggal_fed' => 1,
                'jenis_rencana' => 'pengabdian',
                'sub_rencana' => 'karya',
                'id_dosen' => $id_dosen,
                'nama_kegiatan' => "Test Pengabdian D " . $i,
                'sks_terhitung' => round($sks_terhitung, 2),
            ]);

            DetailPengabdian::create([
                'id_rencana' => $rencana->id_rencana,
                'jenis_terbit' => "Menulis karya pengabdian yang dipakai sebagai Modul Pelatihan oleh seorang Dosen (Tidak diterbitkan, tetapi digunakan oleh siswa mahasiswa)",
                'status_tahapan' => "Pendahuluan",
                'jenis_pengerjaan' => "Mandiri",
                'peran' => "Penulis Utama",
                'jumlah_anggota' => 2
            ]);
        }

        //PENUNJANG
        //A
        for ($i = 1; $i <= $jumlahPerRencana; $i++) {
            $rencana = Rencana::create([
                'asesor1_frk' => 'setuju',
                'asesor2_frk' => 'setuju',
                'id_tanggal_frk' => 2,
                'id_tanggal_fed' => 1,
                'jenis_rencana' => 'penunjang',
                'sub_rencana' => 'akademik',
                'id_dosen' => $id_dosen,
                'nama_kegiatan' => "Test Penunjang A " . $i,
                'sks_terhitung' => $sks_terhitung,
            ]);

            DetailPenunjang::create([
                'id_rencana' => $rencana->id_rencana,
                'jumlah_mahasiswa' => 20
            ]);
        }

        //B
        for ($i = 1; $i <= $jumlahPerRencana; $i++) {
            $rencana = Rencana::create([
                'asesor1_frk' => 'setuju',
                'asesor2_frk' => 'setuju',
                'id_tanggal_frk' => 2,
                'id_tanggal_fed' => 1,
                'jenis_rencana' => 'penunjang',
                'sub_rencana' => 'bimbingan',
                'id_dosen' => $id_dosen,
                'nama_kegiatan' => "Test Penunjang B " . $i,
                'sks_terhitung' => $sks_terhitung,
            ]);

            DetailPenunjang::create([
                'id_rencana' => $rencana->id_rencana,
                'jumlah_mahasiswa' => 20
            ]);
        }

        //C
        for ($i = 1; $i <= $jumlahPerRencana; $i++) {
            $rencana = Rencana::create([
                'asesor1_frk' => 'setuju',
                'asesor2_frk' => 'setuju',
                'id_tanggal_frk' => 2,
                'id_tanggal_fed' => 1,
                'jenis_rencana' => 'penunjang',
                'sub_rencana' => 'ukm',
                'id_dosen' => $id_dosen,
                'nama_kegiatan' => "Test Penunjang C " . $i,
                'sks_terhitung' => round($sks_terhitung, 2),
            ]);

            DetailPenunjang::create([
                'id_rencana' => $rencana->id_rencana,
                'jumlah_kegiatan' => 2,
            ]);
        }

        //D
        for ($i = 1; $i <= $jumlahPerRencana; $i++) {
            $rencana = Rencana::create([
                'asesor1_frk' => 'setuju',
                'asesor2_frk' => 'setuju',
                'id_tanggal_frk' => 2,
                'id_tanggal_fed' => 1,
                'jenis_rencana' => 'penunjang',
                'sub_rencana' => 'sosial',
                'id_dosen' => $id_dosen,
                'nama_kegiatan' => "Test Penunjang D " . $i,
                'sks_terhitung' => round($sks_terhitung, 2),
            ]);

            DetailPenunjang::create([
                'id_rencana' => $rencana->id_rencana,
            ]);
        }

        //E
        for ($i = 1; $i <= $jumlahPerRencana; $i++) {
            $rencana = Rencana::create([
                'asesor1_frk' => 'setuju',
                'asesor2_frk' => 'setuju',
                'id_tanggal_frk' => 2,
                'id_tanggal_fed' => 1,
                'jenis_rencana' => 'penunjang',
                'sub_rencana' => 'struktural',
                'id_dosen' => $id_dosen,
                'nama_kegiatan' => "Test Penunjang E " . $i,
                'sks_terhitung' => round($sks_terhitung, 2),
            ]);

            // Membuat entri baru menggunakan metode create pada model DetailPenunjang
            DetailPenunjang::create([
                'id_rencana' => $rencana->id_rencana,
                'jenis_jabatan_struktural' => 'Koordinator Divisi di bawah WR3',
            ]);
        }

        //F
        for ($i = 1; $i <= $jumlahPerRencana; $i++) {
            $rencana = Rencana::create([
                'asesor1_frk' => 'setuju',
                'asesor2_frk' => 'setuju',
                'id_tanggal_frk' => 2,
                'id_tanggal_fed' => 1,
                'jenis_rencana' => 'penunjang',
                'sub_rencana' => 'nonstruktural',
                'id_dosen' => $id_dosen,
                'nama_kegiatan' => "Test Penunjang F " . $i,
                'sks_terhitung' => round($sks_terhitung, 2),
            ]);

            DetailPenunjang::create([
                'id_rencana' => $rencana->id_rencana,
                'jenis_jabatan_nonstruktural' => 'Ka GJM /GKM',
            ]);
        }

        //G
        for ($i = 1; $i <= $jumlahPerRencana; $i++) {
            $rencana = Rencana::create([
                'asesor1_frk' => 'setuju',
                'asesor2_frk' => 'setuju',
                'id_tanggal_frk' => 2,
                'id_tanggal_fed' => 1,
                'jenis_rencana' => 'penunjang',
                'sub_rencana' => 'redaksi',
                'id_dosen' => $id_dosen,
                'nama_kegiatan' => "Test Penunjang G " . $i,
                'sks_terhitung' => round($sks_terhitung, 2),
            ]);

            DetailPenunjang::create([
                'id_rencana' => $rencana->id_rencana,
                'jabatan' => 'Ketua Redaksi Jurnal ber-ISSN'
            ]);
        }

        //H
        for ($i = 1; $i <= $jumlahPerRencana; $i++) {
            $rencana = Rencana::create([
                'asesor1_frk' => 'setuju',
                'asesor2_frk' => 'setuju',
                'id_tanggal_frk' => 2,
                'id_tanggal_fed' => 1,
                'jenis_rencana' => 'penunjang',
                'sub_rencana' => 'adhoc',
                'id_dosen' => $id_dosen,
                'nama_kegiatan' => "Test Penunjang H " . $i,
                'sks_terhitung' => round($sks_terhitung, 2),
            ]);

            DetailPenunjang::create([
                'id_rencana' => $rencana->id_rencana,
                'jabatan' => 'Ketua Panitia Ad Hoc'
            ]);
        }

        //I
        for ($i = 1; $i <= $jumlahPerRencana; $i++) {
            $rencana = Rencana::create([
                'asesor1_frk' => 'setuju',
                'asesor2_frk' => 'setuju',
                'id_tanggal_frk' => 2,
                'id_tanggal_fed' => 1,
                'jenis_rencana' => 'penunjang',
                'sub_rencana' => 'ketua_panitia',
                'id_dosen' => $id_dosen,
                'nama_kegiatan' => "Test Penunjang I " . $i,
                'sks_terhitung' => $sks_terhitung,
            ]);

            DetailPenunjang::create([
                'id_rencana' => $rencana->id_rencana,
                'jenis_tingkatan' => 2
            ]);
        }

        //J
        for ($i = 1; $i <= $jumlahPerRencana; $i++) {
            $rencana = Rencana::create([
                'asesor1_frk' => 'setuju',
                'asesor2_frk' => 'setuju',
                'id_tanggal_frk' => 2,
                'id_tanggal_fed' => 1,
                'jenis_rencana' => 'penunjang',
                'sub_rencana' => 'anggota_panitia',
                'id_dosen' => $id_dosen,
                'nama_kegiatan' => "Test Penunjang J " . $i,
                'sks_terhitung' => $sks_terhitung,
            ]);

            DetailPenunjang::create([
                'id_rencana' => $rencana->id_rencana,
                'jenis_tingkatan' => 2
            ]);
        }

        //K
        for ($i = 1; $i <= $jumlahPerRencana; $i++) {
            $rencana = Rencana::create([
                'asesor1_frk' => 'setuju',
                'asesor2_frk' => 'setuju',
                'id_tanggal_frk' => 2,
                'id_tanggal_fed' => 1,
                'jenis_rencana' => 'penunjang',
                'sub_rencana' => 'pengurus_yayasan',
                'id_dosen' => $id_dosen,
                'nama_kegiatan' => "Test Penunjang K " . $i,
                'sks_terhitung' => $sks_terhitung,
            ]);

            DetailPenunjang::create([
                'id_rencana' => $rencana->id_rencana,
                'jabatan' => 2
            ]);
        }

        //L
        for ($i = 1; $i <= $jumlahPerRencana; $i++) {
            $rencana = Rencana::create([
                'asesor1_frk' => 'setuju',
                'asesor2_frk' => 'setuju',
                'id_tanggal_frk' => 2,
                'id_tanggal_fed' => 1,
                'jenis_rencana' => 'penunjang',
                'sub_rencana' => 'asosiasi',
                'id_dosen' => $id_dosen,
                'nama_kegiatan' => "Test Penunjang L " . $i,
                'sks_terhitung' => round($sks_terhitung, 2),
            ]);

            DetailPenunjang::create([
                'id_rencana' => $rencana->id_rencana,

                'jenis_tingkatan' => 'Internasional',
                'jabatan' => 'Ketua',
            ]);
        }

        //M
        for ($i = 1; $i <= $jumlahPerRencana; $i++) {
            $rencana = Rencana::create([
                'asesor1_frk' => 'setuju',
                'asesor2_frk' => 'setuju',
                'id_tanggal_frk' => 2,
                'id_tanggal_fed' => 1,
                'jenis_rencana' => 'penunjang',
                'sub_rencana' => 'seminar',
                'id_dosen' => $id_dosen,
                'nama_kegiatan' => "Test Penunjang M " . $i,
                'sks_terhitung' => round($sks_terhitung, 2),
            ]);

            DetailPenunjang::create([
                'id_rencana' => $rencana->id_rencana,
                'jenis_tingkatan' => 'Regional/Nasional', // Menyimpan jenis tingkatan ke dalam detail penunjang
            ]);
        }

        //N
        for ($i = 1; $i <= $jumlahPerRencana; $i++) {
            $rencana = Rencana::create([
                'asesor1_frk' => 'setuju',
                'asesor2_frk' => 'setuju',
                'id_tanggal_frk' => 2,
                'id_tanggal_fed' => 1,
                'jenis_rencana' => 'penunjang',
                'sub_rencana' => 'reviewer',
                'id_dosen' => $id_dosen,
                'nama_kegiatan' => "Test Penunjang N " . $i,
                'sks_terhitung' => $sks_terhitung,
            ]);

            DetailPenunjang::create([
                'id_rencana' => $rencana->id_rencana,
            ]);
        }
    }
}
