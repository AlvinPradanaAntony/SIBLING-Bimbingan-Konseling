<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AssessmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $assessments = [
            // Pribadi
            ['question' => 'Kualitas ibadah saya pada Tuhan YME masih belum baik', 'field' => 'Pribadi'],
            ['question' => 'Saya kadang lupa bersyukur atas nikmat dan karunia dari Tuhan YME', 'field' => 'Pribadi'],
            ['question' => 'Saya merasa masih sulit untuk selalu berfikir positif', 'field' => 'Pribadi'],
            ['question' => 'Saya kadang-kadang masih suka menyontek pada waktu tes /ujian', 'field' => 'Pribadi'],
            ['question' => 'Saya belum tahu cara mengendalikan emosi dengan baik', 'field' => 'Pribadi'],
            ['question' => 'Saya belum paham tentang mekanisme pertahanan diri', 'field' => 'Pribadi'],
            ['question' => 'Saya belum tahu cara mengatur waktu yang baik', 'field' => 'Pribadi'],
            ['question' => 'Saya merasa masih sedikit pemahaman tentang kesehatan reproduksi remaja', 'field' => 'Pribadi'],
            ['question' => 'Saya belum mengetahui banyak tentang jenis obat-obat terlarang serta dampaknya', 'field' => 'Pribadi'],
            ['question' => 'Saya merasa masih sedikit pengetahuan tentang ilmu kepemimpinan', 'field' => 'Pribadi'],
            ['question' => 'Saya belum paham tentang mental disorder dan permasalahannya', 'field' => 'Pribadi'],
            ['question' => 'Saya jenuh dan enggan masuk sekolah', 'field' => 'Pribadi'],
            ['question' => 'Saya merasa sulit menghilangkan kebiasaan keluar malam (bermain, begadang)', 'field' => 'Pribadi'],
            ['question' => 'Saya kadang lupa membuang sampah sembarangan', 'field' => 'Pribadi'],
            ['question' => 'Saya tidak suka kalau disuruh antri, sementara yang lain tidak mau tertib untuk antri', 'field' => 'Pribadi'],
            ['question' => 'Saya sedang memiliki masalah dengan teman dekat (pacar)', 'field' => 'Pribadi'],
            
            // Sosial
            ['question' => 'Saya belum bisa memiliki kepekaan diri dan sosial', 'field' => 'Sosial'],
            ['question' => 'Saya belum tahu cara berkomunikasi yang efektif', 'field' => 'Sosial'],
            ['question' => 'Saya belum paham yang harus dilakuan dengan adanya pemanasan global', 'field' => 'Sosial'],
            ['question' => 'Saya belum memahami etika dan budaya tertib berlalu lintas', 'field' => 'Sosial'],
            ['question' => 'Saya merasa sulit mematuhi tata tertib sekolah', 'field' => 'Sosial'],
            ['question' => 'Saya kadang masih lupa mengucapkan kata maaf, tolong dan terimakasih dalam pergaulan', 'field' => 'Sosial'],
            ['question' => 'Saya merasa sulit mengendalikan ketergantungan pada medsos (fb, wa, dll)', 'field' => 'Sosial'],
            ['question' => 'Saya belum memahami etika dalam bergaul', 'field' => 'Sosial'],
            ['question' => 'Saya belum tahu cara menjaga persahabatan agar tetap langgeng', 'field' => 'Sosial'],
            ['question' => 'Saya merasa saat ini belum banyak memiliki teman', 'field' => 'Sosial'],
            ['question' => 'Saya masih sering terbawa arus pergaulan yang kurang baik', 'field' => 'Sosial'],
            ['question' => 'Saya belum tahu tentang bentuk-bentuk kenakalan remaja saat ini dan cara mensikapinya', 'field' => 'Sosial'],
            ['question' => 'Saya belum memahami tawuran pelajar dan akibatnya', 'field' => 'Sosial'],
            ['question' => 'Saya belum memahami peran sosial pria dan wanita dengan norma yang ada di masyarakat', 'field' => 'Sosial'],
            ['question' => 'Saya belum paham tentang dampak Seks Bebas, LGBT dan HIV/AIDS', 'field' => 'Sosial'],
            
            // Belajar
            ['question' => 'Saya merasa belum menemukan cara belajar yang efektif', 'field' => 'Belajar'],
            ['question' => 'Saya belum bisa membuat peta pikiran (mind mapping)', 'field' => 'Belajar'],
            ['question' => 'Saya belum paham cara kerja otak kiri dan otak kanan', 'field' => 'Belajar'],
            ['question' => 'Saya belum tahu cara untuk membangkitkan semangat belajar', 'field' => 'Belajar'],
            ['question' => 'Saya masih suka menunda-nunda tugas sekolah/pekerjaan rumah (PR)', 'field' => 'Belajar'],
            ['question' => 'Saya merasa kesulitan dalam memahami pelajaran tertentu', 'field' => 'Belajar'],
            ['question' => 'Saya semangat belajar, kalau ada tes atau ujian saja', 'field' => 'Belajar'],
            ['question' => 'Saya merasa sulit untuk belajar kelompok', 'field' => 'Belajar'],
            ['question' => 'Saya belum paham cara memilih lembaga bimbingan belajar yang baik', 'field' => 'Belajar'],
            ['question' => 'Saya belum dapat memanfaatkan teknologi informasi untuk belajar', 'field' => 'Belajar'],
            ['question' => 'Saya masih belum bisa belajar secara rutin', 'field' => 'Belajar'],
            ['question' => 'Saya merasa takut bertanya atau menjawab di kelas', 'field' => 'Belajar'],
            ['question' => 'Saya jarang sekali mengunjungi perpustakaan untuk membaca', 'field' => 'Belajar'],
            
            // Karir
            ['question' => 'Saya terpaksa harus bekerja untuk mencukupi kebutuhan hidup', 'field' => 'Karir'],
            ['question' => 'Saya merasa belum banyak tahu tentang jenis-jenis profesi/pekerjaan di masyarakat', 'field' => 'Karir'],
            ['question' => 'Saya belum mengetahui tentang dunia usaha / dunia industri', 'field' => 'Karir'],
            ['question' => 'Saya belum paham hubungan antara bakat, minat, pendidikan dan pekerjaan', 'field' => 'Karir'],
            ['question' => 'Saya masih memiliki keraguan dengan pilihan cita-cita/karir masa depan', 'field' => 'Karir'],
            ['question' => 'Saya belum memahami tentang program prakerin di SMK', 'field' => 'Karir'],
        ];

        DB::table('assessments')->insert($assessments);
    }
}
