<?php

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
        $bem = Ormawa::create(
            [
            'name' => 'BEM IKIP PGRI Bojonegoro',
            'slug' => 'bem-ikip-pgri-bojonegoro',
            'type' => 'bem',
            'description' => '"Badan Eksekutif Mahasiswa (BEM) IKIP PGRI Bojonegoro merupakan
lembaga eksekutif tertinggi di tingkat institut yang berperan sebagai wadah
aspirasi, penggerak kegiatan kemahasiswaan, serta pelaksana berbagai program
yang mendukung pengembangan potensi mahasiswa. BEM menjadi jembatan
antara mahasiswa dengan pihak kampus dalam mewujudkan kehidupan
akademik yang aktif, kreatif, dan berintegritas.
Sebagai organisasi yang berasaskan kekeluargaan dan profesionalisme,
BEM IKIP PGRI Bojonegoro memiliki visi untuk menciptakan mahasiswa
yang inovatif, kritis, dan berjiwa kepemimpinan tinggi, serta mampu
berkontribusi nyata bagi masyarakat. Melalui berbagai kegiatan — seperti
seminar, pelatihan, pengabdian masyarakat, hingga kegiatan sosial dan budaya
— BEM berkomitmen membangun lingkungan kampus yang dinamis dan
berdaya saing.
Dalam menjalankan tugasnya, BEM bekerja sama dengan berbagai
Himpunan Mahasiswa Program Studi (HMPS), Unit Kegiatan Mahasiswa
(UKM), serta organisasi internal lainnya. Kolaborasi tersebut bertujuan untuk
memperkuat solidaritas antar-mahasiswa dan menciptakan iklim organisasi
yang produktif serta berorientasi pada kemajuan lembaga."
',
            'vision' => '1. Berperan aktif dalam pencapaian tujuan Pedidikan Nasional.
2. Menjunjung tinggi Tri Dharma Perguruan Tinggi.
3. Memberikan kontribusi untuk memajukan lembaga kampus
4. Mempertinggi rasa peduli mahasiswa terhadap lingkungan
',
            'mission' => '1. Membangun dan meningkatkan solidaritas mahasiswa.
2. Menjalin komunikasi antar mahasiswa.
3. Menjalin komunikasi antar mahasiswa dengan dosen serta lembaga
kampus.
4. Menjalin komunikasi antar mahasiswa dengan alumni.
5. Menjalin komunikasi antar mahasiswa masyarakat.
6. Menghimpun dan menyalurkan potensi mahasiswa',
            'email' => 'bem@ikippgribojonegoro.ac.id',
            'phone' => '081234567890',
            'instagram' => '@bem_ikippgri_bjn',
            'established_year' => 2010,
            'is_active' => true,
        ]);

        // Create UKM List
        $ukms = [
           
            [
                'name' => 'HMPTI',
                'description' => 'Program Studi Pendidikan Teknologi Informasi (PTI) merupakan prodi yang mempelajari tentang pemanfaatan teknologi pada kehidupan sehari - hari khususnya pada pendidikan. Prodi ini mempunyai prospek lulusan yang dapat mencakup kebutuhan industri dalam maupun luar negeri seperti tenaga teknis di bidang informatika, peneliti, tenaga pendidikan dan lain - lain',
                'vision' => 'Menyiapkan lulusan yang inovatif dalam menciptakan dan mengelola teknologi informasi di bidang pendidikan.',
                'mission' => 'Menyiapkan lulusan yang memiliki kecakapan mengkaji teori dan praktik berbasis informasi teknologi.
                                Menyiapkan lulusan yang mampu menciptakan dan mengembangkan teknologi di bidang Pendidikan.
                                Menyiapkan lulusan yang mampu menerapkan hasil pengembangan teknologi di bidang pendidikan untuk pengelolaan pendidikan & pembelajaran.',
            ],
            [
                'name' => 'HMP PBSI',
                'description' => '"Himpunan Mahasiswa Program Studi Pendidikan Bahasa dan Sastra Indonesia (HMP PBSI) merupakan organisasi kemahasiswaan tingkat program studi yang menjadi wadah bagi mahasiswa PBSI untuk berkreasi, berorganisasi, dan mengembangkan potensi diri. Himpunan ini berperan sebagai jembatan antara mahasiswa, dosen, dan pihak jurusan dalam berbagai kegiatan akademik maupun nonakademik.

Secara umum, HMP PBSI memiliki tujuan untuk membentuk mahasiswa yang aktif, kritis, kreatif, serta memiliki rasa tanggung jawab sosial melalui kegiatan yang berorientasi pada pengembangan keilmuan bahasa, sastra, dan pendidikan. Program-program yang dijalankan biasanya meliputi seminar kebahasaan, pelatihan kepenulisan, lomba cipta puisi, festival teater, hingga kegiatan pengabdian masyarakat berbasis literasi.

Selain itu, HMP PBSI juga menjadi ruang solidaritas dan kekeluargaan antar-mahasiswa. Di sini, mahasiswa tidak hanya belajar teori bahasa dan sastra, tetapi juga belajar bagaimana berorganisasi, memimpin, bekerja sama, dan berkontribusi nyata untuk kampus maupun masyarakat. Dengan semangat “Berkarya melalui Bahasa dan Sastra,” HMP PBSI terus berupaya mencetak mahasiswa yang intelektual, berbudaya, dan peka terhadap isu kebahasaan di masyarakat."
',
                'vision' => 'Menjadikan HMP PBSI yang bersatu, profesional, dan berkualitas demi tercapainya HMP PBSI (Responsif, Progresif, Inovatif, dan Peduli Anggota).',
                'mission' => 'Menjaga keharmonisan dan sinergitas kepada seluruh elemen jurusan PBSI dan lembaga lain.
•	Mewadahi, memproses, dan melaksanakan aspirasi mahasiswa PBSI.
•	Menumbuhkan semangat juang Himpunan Mahasiswa PBSI serta meningkatkan skill kebahasaan bagi mahasiswa Prodi PBSI.',
            ],
            
           
            [
                'name' => 'UKM ALAM',
                'description' => '"
Organisasi ini bersama “ IKATAN PECINTA ALAM MAHASISWA (IPAMA)” IKIP PGRI BOJONEGORO, disingkat dengan UKM IPAMA. UNIT KEGIATAN MAHASISWA IKATAN PECINTA ALAM MAHASISWA (UKM
IPAMA) didirikan pada tanggal 21 Juni 2002, dan diresmikan pada tanggal 21 Juni 2002.
Organisasi ini berkedudukan sebagai organisasi di bawah naungan IKIP PGRI Bojonegoro."
',
                'vision' => 'Melestarikan dan mengembangkan eksistensi budaya alam dan sekitarnya.',
                'mission' => 'Melatih dan mengembangkan bakat dan minat mahasiswa di bidang alam.',
            ],
            
            [
                'name' => 'UKM Pramuka dan Pecinta Alam',
                'description' => 'Organisasi ini bernama Dewan Racana LETTU SOEJITNO - FATMAWATI yang berada di bawah naungan Gugus Depan Pramuka di Perguruan Tinggi IKIP PGRI Bojonegoro yang merupakan internal dari gerakan pramuka nasional yang selanjutnya disebut Dewan Racana LETTU SOEJITNO - FATMAWATI IKIP PGRI Bojonegoro Gugus Depan 01.201-01.202 Pangkalan IKIP PGRI Bojonegoro.
deskripsi
',
                'vision' => 'Memiliki kepribadian dan kepemimpinan yang berjiwa Pancasila.',
                'mission' => '1. Disiplin, yaitu berfikir, bersikap dan berperilaku tertib.
2. Sehat dan kuat mental, moral, dan fisiknya.
3. Memiliki jiwa patriot yang berwawasan luas dan dijiwai nilai-nilai kejuangan yang diwariskan oleh para pejuang bangsa.
4. Berkemampuan untuk berkarya dengan semangat kemandirian, berfikir kreatif dan dapat dipercaya, berani dan mampu menghadapi tugas-tugas yang diembannya',
            ],
            [
                'name' => 'UKM KSR',
                'description' => 'Unit Kegiatan Mahasiswa Korps Sukarela (KSR) unit IKIP PGRI Bojonegoro merupakan organisasi kemahasiswaan yang bergerak di bidang kepalangmerahan, kemanusiaan, dan sosial. UKM ini berada di bawah naungan IKIP PGRI Bojonegoro dan berafiliasi langsung dengan Palang Merah Indonesia (PMI) Kabupaten Bojonegoro.
KSR IKIP PGRI Bojonegoro menjadi wadah bagi mahasiswa yang memiliki kepedulian terhadap sesama, berjiwa sosial tinggi, serta siap mengabdi dalam kegiatan kemanusiaan baik di dalam maupun di luar kampus. Anggota KSR dilatih untuk memiliki kemampuan dasar kepalangmerahan, pertolongan pertama, tanggap darurat bencana, donor darah, serta kegiatan sosial lainnya.
',
                'vision' => 'Menjadi organisasi kemanusiaan yang profesional, tanggap, dan berintegritas tinggi dalam mewujudkan jiwa kepalangmerahan di lingkungan kampus dan masyarakat.
',
                'mission' => '1. Meningkatkan kapasitas anggota di bidang kepalangmerahan dan pertolongan pertama.  
2. Menumbuhkan semangat kemanusiaan dan sikap peduli sosial di kalangan mahasiswa.  
3. Menyelenggarakan kegiatan sosial dan kemanusiaan seperti donor darah, pelatihan, serta tanggap bencana.  
4. Menjalin kerja sama dengan PMI, lembaga pemerintah, dan organisasi kemanusiaan lainnya.  
5. Menegakkan nilai‑nilai dasar Palang Merah seperti kemanusiaan, netralitas, kemandirian, kesukarelaan, dan kesatuan.',   ],
                       
[
                'name' => 'UKM Taekwondo',
                'description' => 'Unit Kegiatan Mahasiswa (UKM) Taekwondo IKIP PGRI Bojonegoro merupakan organisasi kemahasiswaan yang secara resmi didirikan di lingkungan kampus IKIP PGRI Bojonegoro pada tanggal 9 September 2012. Sebagai sebuah Unit Kegiatan Mahasiswa, UKM Taekwondo berkedudukan di IKIP PGRI Bojonegoro dan memegang tanggung jawab penuh terhadap seluruh anggotanya, yang diwujudkan melalui mekanisme Rapat Anggota. Dalam menjalankan seluruh aktivitas dan program kerjanya, organisasi ini menjunjung tinggi dan berpegangan teguh pada nilai-nilai Pancasila dan Undang-Undang Dasar 1945. Prinsip dasar yang dianut oleh UKM Taekwondo adalah kekeluargaan, semangat gotong royong, dan menjunjung tinggi sportifitas. UKM Taekwondo memiliki tujuan mulia sebagai lembaga kampus, yaitu berupaya secara konsisten untuk membentuk mahasiswa yang tidak hanya bertaqwa kepada Tuhan Yang Maha Esa dan memiliki wawasan yang luas, tetapi juga berupaya menjadi profesional di bidang olahraga Taekwondo. Selain penguasaan teknis, UKM ini juga menekankan pembentukan karakter yang sportif, dinamis, serta memiliki kepedulian sosial yang tinggi terhadap lingkungan sekitar. Seluruh semangat dan filosofi organisasi ini diabadikan dalam semboyan yang kuat, yaitu “Taekwondo Jiwaku, Sportifitas Dalam Darahku”.
',
                'vision' => 'Mengembangkan Beladiri Taekwondo Khususnya di Lingkungan IKIP PGRI BOJONEGORO dengan Menjunjung Tinggi Sportivitas, Melatih Kepribadian. Karakter Disiplin, dan Meningkatkan Prestasi
',
                'mission' => '1. Membangun Sikap Disiplin dari Seluruh Anggota Taekwondo.

2. Melaksanakan Latihan Secara Teratur dan Semangat.

3. Membentuk Fisik dan Mental Secara Utuh.

4. Mencari Atlet - Atlet Berpotensi

5. Menghasilkan Atlet - Atlet yang Profesional dan Menjadi Kebanggaan IKIP PGRI Bojonegoro',
            ],
            
        ];

        foreach ($ukms as $index => $ukmData) {
            Ormawa::create([
                'name' => $ukmData['name'],
                'slug' => \Illuminate\Support\Str::slug($ukmData['name']),
                'type' => 'ukm',
                'description' => $ukmData['description'],
                'vision' => $ukmData['vision'],
                'mission' => $ukmData['mission'],
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


    }
}