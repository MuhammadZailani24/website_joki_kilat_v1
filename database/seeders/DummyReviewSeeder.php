<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Order;
use App\Models\Review;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DummyReviewSeeder extends Seeder
{
    public function run()
    {
        // Kumpulan data dummy organik (bintang 5 dan 4)
        $reviewsData = [
            ['nama' => 'Budi Santoso', 'rating' => 5, 'komen' => 'Gila sih, cepat banget selesainya! Web aplikasinya berjalan lancar tanpa bug. Recommended banget buat tugas akhir.'],
            ['nama' => 'Siti Aisyah', 'rating' => 5, 'komen' => 'Pelayanannya ramah, adminnya fast respon. Makalah saya dikerjakan dengan sangat rapi dan sesuai format kampus.'],
            ['nama' => 'Andi Pratama', 'rating' => 4, 'komen' => 'Hasil codingannya rapi dan mudah dimengerti. Ada sedikit revisi di awal tapi langsung dikerjakan hari itu juga. Keren!'],
            ['nama' => 'Rina Amelia', 'rating' => 5, 'komen' => 'Awalnya ragu, tapi setelah coba pesan presentasi PPT, ternyata 3 jam udah jadi dan desainnya elegan banget! Dosen sampai muji.'],
            ['nama' => 'Faisal Rahman', 'rating' => 4, 'komen' => 'Sistem pemesanannya gampang, harganya transparan di awal. Analisis data SPSS saya valid semua. Mantap Joki Kilat!'],
            ['nama' => 'Dwi Lestari', 'rating' => 5, 'komen' => 'Beneran penyelamat deadline! Nggak nyangka tugas essay 2000 kata bisa beres semalaman. Bahasanya natural banget dan lolos Turnitin.'],
        ];

        foreach ($reviewsData as $data) {
            // 1. Buat User Dummy (Sekarang dilengkapi WhatsApp!)
            $user = User::create([
                'name' => $data['nama'],
                'email' => strtolower(str_replace(' ', '', $data['nama'])) . rand(10, 99) . '@gmail.com',
                'password' => Hash::make('password123'),
                'role' => 'user',
                'whatsapp' => '0812' . rand(10000000, 99999999), // Menambahkan WA acak
            ]);

            // 2. Buat Order Dummy (Sebagai syarat review)
            $order = Order::create([
                'user_id' => $user->id,
                'kategori_layanan' => 'Layanan Dummy',
                'jenjang' => 'KULIAH',
                'deadline' => Carbon::now(),
                'total_harga' => rand(100000, 500000),
                'status' => 'Selesai',
                'judul_tugas' => 'Tugas ' . $data['nama'],
                'deskripsi_tugas' => 'Deskripsi dummy untuk keperluan review.',
            ]);

            // 3. Masukkan Review (Langsung status Tampil / Approved)
            Review::create([
                'user_id' => $user->id,
                'order_id' => $order->id,
                'rating' => $data['rating'],
                'komentar' => $data['komen'],
                'is_approved' => true,
            ]);
        }
    }
}