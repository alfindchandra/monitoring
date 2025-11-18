<?php
// database/seeders/DatabaseSeeder.php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Ormawa;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create BEM
        $bem = Ormawa::create([
            'name' => 'BEM IKIP PGRI Bojonegoro',
            'slug' => 'bem-ikip-pgri-bojonegoro',
            'type' => 'bem',
            'description' => 'Badan Eksekutif Mahasiswa IKIP PGRI Bojonegoro adalah organisasi intra kampus yang merupakan lembaga eksekutif di tingkat perguruan tinggi.',
            'vision' => 'Menjadi organisasi mahasiswa yang amanah, profesional, dan berdedikasi tinggi dalam mengabdi kepada mahasiswa dan almamater.',
            'mission' => 'Mewujudkan BEM sebagai wadah aspirasi mahasiswa, Meningkatkan kualitas mahasiswa, Menjalin kerjasama yang baik',
            'email' => 'bem@ikippgribojonegoro.ac.id',
            'phone' => '081234567890',
            'instagram' => '@bem_ikippgri_bjn',
            'established_year' => 2010,
            'is_active' => true,
        ]);

        // Create UKM List
        $ukms = [
            [
                'name' => 'HIMMAT',
                'description' => 'Himpunan Mahasiswa Matematika',
                'vision' => 'Menjadi wadah pengembangan akademik dan non-akademik mahasiswa matematika',
            ],
            [
                'name' => 'HMPTI',
                'description' => 'Himpunan Mahasiswa Pendidikan Teknologi Informasi',
                'vision' => 'Mengembangkan kompetensi mahasiswa di bidang teknologi informasi',
            ],
            [
                'name' => 'HMP PBSI',
                'description' => 'Himpunan Mahasiswa Pendidikan Bahasa dan Sastra Indonesia',
                'vision' => 'Melestarikan dan mengembangkan bahasa Indonesia',
            ],
            [
                'name' => 'UEC',
                'description' => 'University English Club - Wadah pengembangan bahasa Inggris',
                'vision' => 'Meningkatkan kemampuan berbahasa Inggris mahasiswa',
            ],
            [
                'name' => 'HMP PPKN',
                'description' => 'Himpunan Mahasiswa Pendidikan Pancasila dan Kewarganegaraan',
                'vision' => 'Membentuk karakter mahasiswa yang berjiwa Pancasila',
            ],
            [
                'name' => 'HIMAPENKO',
                'description' => 'Himpunan Mahasiswa Pendidikan Ekonomi',
                'vision' => 'Mengembangkan wawasan ekonomi dan kewirausahaan',
            ],
            [
                'name' => 'UKM Musik S.A.F',
                'description' => 'Unit Kegiatan Mahasiswa Musik Sahid Art Family',
                'vision' => 'Mengembangkan bakat seni musik mahasiswa',
            ],
            [
                'name' => 'UKM KOMI',
                'description' => 'Unit Kegiatan Mahasiswa Komunikasi',
                'vision' => 'Meningkatkan kemampuan komunikasi dan public speaking',
            ],
            [
                'name' => 'UKM Kesenian Gaganeswara',
                'description' => 'Unit Kegiatan Mahasiswa Seni dan Budaya',
                'vision' => 'Melestarikan seni dan budaya tradisional',
            ],
            [
                'name' => 'UKM Pramuka dan Pecinta Alam',
                'description' => 'Unit Kegiatan Mahasiswa Kepramukaan dan Lingkungan',
                'vision' => 'Membentuk karakter kepemimpinan dan cinta alam',
            ],
            [
                'name' => 'UKM KSR',
                'description' => 'Korps Sukarela - Palang Merah Remaja',
                'vision' => 'Memberikan pelayanan kemanusiaan dan kesehatan',
            ],
            [
                'name' => 'UKM Taekwondo',
                'description' => 'Unit Kegiatan Mahasiswa Bela Diri Taekwondo',
                'vision' => 'Mengembangkan mental dan fisik melalui seni bela diri',
            ],
            [
                'name' => 'UKM UKKI',
                'description' => 'Unit Kegiatan Kerohanian Islam',
                'vision' => 'Meningkatkan kualitas spiritual mahasiswa muslim',
            ],
            [
                'name' => 'UKM Penalaran dan Riset',
                'description' => 'Unit Kegiatan Mahasiswa Penelitian dan Karya Ilmiah',
                'vision' => 'Mengembangkan budaya riset dan inovasi',
            ],
            [
                'name' => 'UKM Multimedia',
                'description' => 'Unit Kegiatan Mahasiswa Multimedia dan Desain',
                'vision' => 'Mengembangkan kreativitas di bidang multimedia',
            ],
            [
                'name' => 'LPM Sinergi dan Kepenyiaran',
                'description' => 'Lembaga Pers Mahasiswa Sinergi dan Broadcasting',
                'vision' => 'Menjadi media informasi kampus yang kredibel',
            ],
        ];

        foreach ($ukms as $index => $ukmData) {
            Ormawa::create([
                'name' => $ukmData['name'],
                'slug' => \Illuminate\Support\Str::slug($ukmData['name']),
                'type' => 'ukm',
                'description' => $ukmData['description'],
                'vision' => $ukmData['vision'],
                'mission' => 'Melaksanakan program kerja yang inovatif dan bermanfaat bagi mahasiswa',
                'email' => strtolower(str_replace(' ', '', $ukmData['name'])) . '@ikippgribojonegoro.ac.id',
                'phone' => '0812345678' . str_pad($index + 1, 2, '0', STR_PAD_LEFT),
                'instagram' => '@' . strtolower(str_replace(' ', '_', $ukmData['name'])),
                'established_year' => rand(2010, 2020),
                'is_active' => true,
            ]);
        }

        // Create Admin User
        User::create([
            'name' => 'Admin Kampus',
            'email' => 'admin@ikippgribojonegoro.ac.id',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'phone' => '081234567890',
            'is_active' => true,
        ]);

        // Create Ketua BEM User
        User::create([
            'name' => 'Ketua BEM',
            'email' => 'ketuabem@ikippgribojonegoro.ac.id',
            'password' => Hash::make('password'),
            'role' => 'ketua_bem',
            'ormawa_id' => $bem->id,
            'phone' => '081234567891',
            'is_active' => true,
        ]);

        // Create Ketua UKM Users (sample for first 5 UKMs)
        $allOrmawas = Ormawa::where('type', 'ukm')->get();
        foreach ($allOrmawas->take(5) as $index => $ukm) {
            User::create([
                'name' => 'Ketua ' . $ukm->name,
                'email' => strtolower(str_replace(' ', '', $ukm->name)) . '@ikippgribojonegoro.ac.id',
                'password' => Hash::make('password'),
                'role' => 'ketua_ukm',
                'ormawa_id' => $ukm->id,
                'phone' => '0812345679' . str_pad($index + 1, 2, '0', STR_PAD_LEFT),
                'is_active' => true,
            ]);
        }

        $this->command->info('Database seeded successfully!');
        $this->command->info('Default credentials:');
        $this->command->info('Admin: admin@ikippgribojonegoro.ac.id / password');
        $this->command->info('Ketua BEM: ketuabem@ikippgribojonegoro.ac.id / password');
        $this->command->info('Ketua UKM: (check database for emails) / password');
    }
}