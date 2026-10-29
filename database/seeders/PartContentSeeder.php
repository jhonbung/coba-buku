<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class PartContentSeeder extends Seeder
{
    public function run(): void
    {
        $part = Product::where('slug', 'ebook-mantra-bab-1-5')->first();
        if ($part && empty($part->content)) {
            $part->content = "BAB 1: KELUARGA BESAR NOTONEGORO\n\n"
                . "Malam di kediaman Notonegoro tidak pernah benar-benar sepi. Di balik gerbang besi tempa yang menjulang kokoh di kawasan Menteng itu, selalu ada bisik-bisik yang tersimpan rapat di antara pilar marmer dan lantai kayu jati tua.\n\n"
                . "Larasati berdiri di depan cermin rias bergaya Victorian di kamar utamanya. Jari-jemarinya yang ramping meraba kalung mutiara yang melingkari lehernya—sebuah pusaka yang konon membawa takdir terselubung bagi siapa saja yang mengenakannya tanpa izin keluarga besar Notonegoro.\n\n"
                . "\"Kau masih memikirkan pembacaan wasiat besok malam?\" suara berat itu memecah kesunyian dari ambang pintu.\n\n"
                . "Larasati tidak perlu menoleh untuk mengetahui siapa yang berdiri di sana. Radian Notonegoro. Pewaris utama konglomerasi perbankan keluarga, pria dengan sorot mata sedingin puncak Himalaya dan senyum yang selalu sulit ditebak arahnya.\n\n"
                . "\"Bukan wasiatnya, Radian,\" sahut Larasati pelan, suaranya tenang namun menyimpan getar halus. \"Melainkan rahasia yang tersimpan di balik brankas ayahmu. Kau tahu apa yang terjadi sepuluh tahun lalu di paviliun barat, bukan?\"\n\n"
                . "Radian melangkah mendekat. Suara sol sepatunya beradu pelan dengan karpet Persia tebal. Ia berhenti tepat di belakang Larasati, menatap lekat pantulan mata wanita itu di cermin.\n\n"
                . "\"Sepuluh tahun lalu adalah masa lalu, Laras. Dan di rumah ini... masa lalu lebih baik tetap terkubur bersama mereka yang telah pergi lebih dulu.\"\n\n"
                . "***\n\n"
                . "BAB 2: SURAT YANG TIDAK PERNAH DIKIRIMKAN\n\n"
                . "Kabut tipis menyelimuti pelataran belakang saat fajar mulai merekah. Di lantai tiga perpustakaan pribadi mendiang kakek, sebuah map beludru merah tua terselip rapi di antara deretan buku hukum era kolonial.\n\n"
                . "Ketika sampulnya dibuka, aroma kertas lapuk dan tinta kering menyeruak ke udara. Tangan Larasati bergetar halus saat membaca baris pertama naskah yang menguning itu:\n\n"
                . "'Untuk siapapun yang menemukan lembaran ini: nama Notonegoro bukan sekadar gelar kehormatan, melainkan mantra pengikat yang menuntut komitmen mutlak dari setiap generasi penerusnya...'\n\n"
                . "Sebuah langkah kaki berderit di lantai kayu di ujung lorong luar perpustakaan. Seseorang sedang memperhatikannya.";
            $part->save();
        }

        $part2 = Product::where('slug', 'hierarchy-part-1-bab-1-5')->first();
        if ($part2 && empty($part2->content)) {
            $part2->content = "BAB 1: TANGGA KEKUASAAN\n\n"
                . "Di dunia bisnis elit Jakarta, hierarki bukanlah sekadar bagan organisasi di ruang direksi—melainkan aturan tak tertulis yang menentukan siapa yang berhak duduk di meja makan utama dan siapa yang harus menunggu di ruang tamu.\n\n"
                . "Arka Notonegoro melangkah memasuki aula pertemuan gedung pencakar langit berlantai 45. Sorot lampu kristal memantulkan bayangannya di dinding kaca setinggi enam meter yang menghadap panorama megapolitan di bawah kakinya.\n\n"
                . "\"Semua dewan komisaris sudah berkumpul, Tuan Arka,\" bisik sekretaris pribadinya seraya menyerahkan berkas laporan kuartal terakhir.\n\n"
                . "Arka mengangguk samar tanpa menghentikan langkahnya. \"Bagus. Pastikan pintu ruang rapat terkunci begitu aku masuk. Tidak ada yang boleh keluar sampai keputusan restrukturisasi ditandatangani.\"\n\n"
                . "***\n\n"
                . "BAB 2: PERTARUNGAN DI BALIK MEJA PERUNDINGAN\n\n"
                . "Ketegangan di ruang rapat terasa begitu pekat hingga suara tarikan napas pun terdengar jelas. Di sekeliling meja mahoni bundar itu, para tetua keluarga Notonegoro saling bertukar pandang penuh kecurigaan.\n\n"
                . "\"Kau masih terlalu muda untuk mengubah tradisi yang sudah berjalan empat dekade, Arka,\" seorang pria paruh baya bertubuh tegap angkat bicara dengan nada sinis.\n\n"
                . "Arka tersenyum dingin. \"Tradisi yang membawa perusahaan ini merugi miliaran rupiah bukanlah tradisi yang patut dipertahankan, Paman. Dan di era kepemimpinan saya, kompetensi adalah satu-satunya mata uang yang berlaku.\"";
            $part2->save();
        }
    }
}
