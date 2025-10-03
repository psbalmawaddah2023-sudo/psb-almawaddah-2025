<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pengaturan;

class PengaturanSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['key' => 'site_title', 'value' => 'Portal Pendaftaran'],
            ['key' => 'site_logo', 'value' => 'image/logo.png'],
            ['key' => 'video_url', 'value' => 'https://www.youtube.com/embed/NW5QPPdaFno'],
            ['key' => 'faq1_question', 'value' => 'Apa itu Program Persiapan Calon Pelajar?'],
            ['key' => 'faq1_answer', 'value' => 'Program khusus untuk persiapan Ujian Masuk MBI...'],
            ['key' => 'faq2_question', 'value' => 'Bagaimana Kurikulumnya?'],
            ['key' => 'faq2_answer', 'value' => 'MBI adalah KMI plus negara'],
            ['key' => 'footer_text', 'value' => 'Panitia Ujian Masuk Calon Pelajar Pesantren Putri Al Mawaddah'],
            ['key' => 'whatsapp_link', 'value' => 'https://wa.me/6282312565949'],
            ['key' => 'info_link', 'value' => 'https://www.pesantrenputrialmawaddah.sch.id/psbonline-almawaddah/'],
            ['key' => 'brosur_file', 'value' => 'files/brosur.pdf'],
            ['key' => 'video_tutorial', 'value' => 'https://www.youtube.com/embed/NW5QPPdaFno'],
        ];
    

        foreach ($data as $item) {
            Pengaturan::updateOrCreate(['key' => $item['key']], ['value' => $item['value']]);
        }
    }
}
