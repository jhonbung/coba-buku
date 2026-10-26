<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Quote;
use App\Models\Review;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Database\Seeder;

class BookstoreSeeder extends Seeder
{
    public function run(): void
    {
        // 0. Official Store Administrator
        \App\Models\User::updateOrCreate(
            ['email' => 'admin@biancaveana.com'],
            [
                'name' => 'Bianca Veana Admin',
                'username' => 'bianca_admin',
                'password' => \Illuminate\Support\Facades\Hash::make('Notonegoro@2026!Royal'),
                'is_admin' => true,
            ]
        );

        // 1. The Seven Notonegoro Series
        Product::create([
            'title' => 'Mantra',
            'slug' => 'mantra-the-seven-notonegoro-series-i',
            'subtitle' => 'The Seven Notonegoro Series I',
            'series_name' => 'The Seven Notonegoro Series I',
            'category' => 'novel',
            'subcategory' => 'notonegoro',
            'author' => 'Bianca Veana',
            'price' => 129000,
            'original_price' => 149000,
            'stock' => 85,
            'cover_image' => '/images/mantra.svg',
            'synopsis' => 'Kisah pertemuan penuh takdir antara Raden Mas Sadewa Atma Notonegoro dan Natasha Kahiyang Raharjasa. Di balik kemegahan trah Notonegoro yang sarat tradisi dan keagungan, tersembunyi intrik keluarga dan janji yang diikat dengan keikhlasan pengorbanan jiwa.',
            'genre' => 'Royal Romance, Drama, Family Dynasty',
            'pages' => 456,
            'weight_grams' => 400,
            'dimensions' => '14 x 20.5 cm',
            'publisher' => 'Bianca Veana Publishing',
            'isbn' => '978-623-99101-0-4',
            'collectors_items' => ['Special Dust Jacket with Gold Foil', 'Exclusive Photocard Sadewa & Natasha', 'Gold Embossed Bookmark', 'Official Author Note'],
            'is_featured' => true,
            'is_preorder' => false,
            'order_index' => 1,
        ]);

        Product::create([
            'title' => 'Hierarchy',
            'slug' => 'hierarchy-the-seven-notonegoro-series-ii',
            'subtitle' => 'The Seven Notonegoro Series II',
            'series_name' => 'The Seven Notonegoro Series II',
            'category' => 'novel',
            'subcategory' => 'notonegoro',
            'author' => 'Bianca Veana',
            'price' => 135000,
            'original_price' => 155000,
            'stock' => 60,
            'cover_image' => '/images/hierarchy.svg',
            'synopsis' => 'Konflik hierarki darah biru memuncak saat tuntutan pewaris tahta menghimpit pernikahan Renata Dewandari dan Raden Mas Samudra Angkara Notonegoro. Antara kewajiban meneruskan garis keturunan dan kesetiaan cinta tanpa syarat, siapa yang sanggup bertahan?',
            'genre' => 'Dynasty Drama, Anguish, Romance',
            'pages' => 488,
            'weight_grams' => 420,
            'dimensions' => '14 x 20.5 cm',
            'publisher' => 'Bianca Veana Publishing',
            'isbn' => '978-623-99101-1-1',
            'collectors_items' => ['Royal Blue Book Jacket', 'Renata & Samudra Couple Photocard', 'Palace Seal Bookmark'],
            'is_featured' => true,
            'is_preorder' => false,
            'order_index' => 2,
        ]);

        Product::create([
            'title' => 'Fate',
            'slug' => 'fate-the-seven-notonegoro-series-iii',
            'subtitle' => 'The Seven Notonegoro Series III (Pre-Order)',
            'series_name' => 'The Seven Notonegoro Series III',
            'category' => 'novel',
            'subcategory' => 'notonegoro',
            'author' => 'Bianca Veana',
            'price' => 139000,
            'original_price' => 160000,
            'stock' => 150,
            'cover_image' => '/images/fate.svg',
            'synopsis' => 'FATE mengajak pembaca memasuki dunia ketika cinta, pilihan, dan takdir saling terhubung. Raden Mas Raka Satya Notonegoro bersumpah melindungi Amandra Nola Putri dari bayang-bayang kelam masa lalu yang mengancam eksistensinya.',
            'genre' => 'Romantic Suspense, Royal Fantasy, Drama',
            'pages' => 472,
            'weight_grams' => 410,
            'dimensions' => '14 x 20.5 cm',
            'publisher' => 'Bianca Veana Publishing',
            'isbn' => '978-623-99101-2-8',
            'collectors_items' => ['Pre-Order Special Hardbox', 'Signed Bookplate Bianca Veana', '2 Special Hologram Photocards', 'Royal Swan Metal Bookmark'],
            'is_featured' => true,
            'is_preorder' => true,
            'order_index' => 3,
        ]);

        Product::create([
            'title' => 'Serenity',
            'slug' => 'serenity-the-seven-notonegoro-series-iv',
            'subtitle' => 'The Seven Notonegoro Series IV',
            'series_name' => 'The Seven Notonegoro Series IV',
            'category' => 'novel',
            'subcategory' => 'notonegoro',
            'author' => 'Bianca Veana',
            'price' => 135000,
            'original_price' => 155000,
            'stock' => 45,
            'cover_image' => '/images/serenity.svg',
            'synopsis' => 'Kedamaian semu yang harus dibayar mahal. Mengisahkan pencarian jati diri seorang putri bangsawan yang ingin bebas dari belenggu ekspektasi istana dan menemukan keheningan sejati dalam cinta yang bersahaja.',
            'genre' => 'Emotional Romance, Healing, Royal',
            'pages' => 440,
            'weight_grams' => 390,
            'dimensions' => '14 x 20.5 cm',
            'publisher' => 'Bianca Veana Publishing',
            'isbn' => '978-623-99101-3-5',
            'collectors_items' => ['Pastel Ivory Book Sleeve', 'Serenity Quote Cards (Set of 4)', 'Foil Bookmark'],
            'is_featured' => true,
            'is_preorder' => false,
            'order_index' => 4,
        ]);

        // 2. Standalone Novel
        Product::create([
            'title' => 'Beauty in Madness',
            'slug' => 'beauty-in-madness',
            'subtitle' => 'A Standalone Dark Romance Masterpiece',
            'series_name' => 'Standalone Novel',
            'category' => 'novel',
            'subcategory' => 'standalone',
            'author' => 'Bianca Veana',
            'price' => 119000,
            'original_price' => 139000,
            'stock' => 70,
            'cover_image' => '/images/beauty_in_madness.svg',
            'synopsis' => 'Sebuah karya standalone yang intens, puitis, dan menggugah batasan antara cinta mendalam dan obsesi. Ketika kegelapan jiwa bertemu dengan kelembutan yang tak terduga, keduanya terperangkap dalam lingkaran takdir yang memabukkan.',
            'genre' => 'Psychological Romance, Gothic, Drama',
            'pages' => 392,
            'weight_grams' => 360,
            'dimensions' => '14 x 20 cm',
            'publisher' => 'Bianca Veana Publishing',
            'isbn' => '978-623-99101-4-2',
            'collectors_items' => ['Black & Crimson Ribbon Bookmark', 'Exclusive Artwork Artprint'],
            'is_featured' => true,
            'is_preorder' => false,
            'order_index' => 5,
        ]);

        // 3. Limited Editions
        Product::create([
            'title' => 'Mantra — Royal Collector’s Edition Boxset',
            'slug' => 'mantra-royal-collectors-edition-boxset',
            'subtitle' => 'Exclusive Luxury Hardcover & Keepsake Box',
            'series_name' => 'Limited Editions',
            'category' => 'novel',
            'subcategory' => 'limited',
            'author' => 'Bianca Veana',
            'price' => 265000,
            'original_price' => 320000,
            'stock' => 25,
            'cover_image' => '/images/mantra_boxset.svg',
            'synopsis' => 'Edisi istimewa yang dihadirkan khusus untuk para kolektor setia Bianca Veana Universe. Dicetak dengan sampul hardcover bersepuh foil emas champagne, tepian buku berwarna emas (gilded edges), dan dilengkapi dengan kotak penyimpanan beludru eksklusif.',
            'genre' => 'Royal Romance, Collector Special',
            'pages' => 480,
            'weight_grams' => 950,
            'dimensions' => '16 x 23 cm',
            'publisher' => 'Bianca Veana Publishing',
            'isbn' => '978-623-99101-5-9',
            'collectors_items' => ['Velvet Hardcover with Gilded Edge', 'Numbered Certificate of Authenticity', 'Handwritten Letter from Bianca Veana', 'Enamel Wax Seal Kit'],
            'is_featured' => false,
            'is_preorder' => false,
            'order_index' => 6,
        ]);

        // 4. E-Books
        Product::create([
            'title' => 'E-Book Mantra (Full Novel Complete Edition)',
            'slug' => 'ebook-mantra-full',
            'subtitle' => 'Digital Edition (PDF & Google Drive Instant Access)',
            'series_name' => 'The Seven Notonegoro Series I',
            'category' => 'ebook',
            'subcategory' => 'ebook',
            'author' => 'Bianca Veana',
            'price' => 65000,
            'original_price' => 85000,
            'stock' => 9999,
            'cover_image' => '/images/ebook_mantra.svg',
            'synopsis' => 'Akses instan novel Mantra lengkap langsung ke email dan akun Anda. Dapatkan file PDF beresolusi tinggi yang nyaman dibaca di tablet, smartphone, maupun e-reader, serta link Google Drive permanen.',
            'genre' => 'E-Book, Royal Romance',
            'digital_file_type' => 'pdf',
            'digital_file_url' => 'https://drive.google.com/file/d/demo-biancaveana-mantra-full/view',
            'is_featured' => true,
            'order_index' => 10,
        ]);

        Product::create([
            'title' => 'E-Book Mantra — Bab 1 s/d 5 (Early Chapters)',
            'slug' => 'ebook-mantra-bab-1-5',
            'subtitle' => 'Mantra — Serial Bab Digital',
            'series_name' => 'The Seven Notonegoro Series I',
            'category' => 'ebook',
            'subcategory' => 'chapter',
            'author' => 'Bianca Veana',
            'price' => 15000,
            'stock' => 9999,
            'cover_image' => '/images/ebook_chapter1.svg',
            'synopsis' => 'Akses digital bab permulaan novel Mantra untuk memulai petualangan Anda dalam semesta Notonegoro.',
            'genre' => 'E-Book Serial',
            'digital_file_type' => 'gdrive',
            'digital_file_url' => 'https://drive.google.com/file/d/demo-mantra-bab-1-5/view',
            'order_index' => 11,
        ]);

        Product::create([
            'title' => 'E-Book Hierarchy (Full Novel Complete Edition)',
            'slug' => 'ebook-hierarchy-full',
            'subtitle' => 'Digital Edition (PDF & Google Drive Instant Access)',
            'series_name' => 'The Seven Notonegoro Series II',
            'category' => 'ebook',
            'subcategory' => 'ebook',
            'author' => 'Bianca Veana',
            'price' => 65000,
            'original_price' => 85000,
            'stock' => 9999,
            'cover_image' => '/images/ebook_hierarchy.svg',
            'synopsis' => 'Versi digital lengkap Hierarchy. Baca kisah penuh drama Renata dan Samudra di mana saja dan kapan saja.',
            'genre' => 'E-Book, Dynasty Romance',
            'digital_file_type' => 'pdf',
            'digital_file_url' => 'https://drive.google.com/file/d/demo-biancaveana-hierarchy-full/view',
            'is_featured' => true,
            'order_index' => 12,
        ]);

        Product::create([
            'title' => 'E-Book Fate (Digital Pre-Order)',
            'slug' => 'ebook-fate-preorder',
            'subtitle' => 'Digital Early Access Edition',
            'series_name' => 'The Seven Notonegoro Series III',
            'category' => 'ebook',
            'subcategory' => 'ebook',
            'author' => 'Bianca Veana',
            'price' => 59000,
            'original_price' => 75000,
            'stock' => 9999,
            'cover_image' => '/images/ebook_fate.svg',
            'synopsis' => 'Amankan edisi digital novel FATE sebelum tanggal rilis resmi. File akan otomatis dikirimkan ke email Anda begitu bab pertama diluncurkan.',
            'genre' => 'E-Book Pre-Order',
            'digital_file_type' => 'pdf',
            'digital_file_url' => 'https://drive.google.com/file/d/demo-biancaveana-fate-po/view',
            'is_preorder' => true,
            'order_index' => 13,
        ]);

        // 5. Merchandise
        Product::create([
            'title' => 'Merchandise Mantra — Palace Gold Metal Bookmark & Wax Seal',
            'slug' => 'merchandise-mantra-bookmark-wax-seal',
            'subtitle' => 'Official Universe Keepsake',
            'series_name' => 'Merchandise Mantra',
            'category' => 'merchandise',
            'subcategory' => 'merch',
            'author' => 'Bianca Veana',
            'price' => 59000,
            'stock' => 50,
            'cover_image' => '/images/merch_bookmark.svg',
            'synopsis' => 'Pembatas buku logam berlapis emas champagne dengan ukiran ornamen bunga teratai Notonegoro dan satu stempel lilin elegan.',
            'genre' => 'Collectibles',
            'weight_grams' => 120,
            'is_featured' => true,
            'order_index' => 20,
        ]);

        Product::create([
            'title' => 'Merchandise Hierarchy — Royal Scented Candle (Amber & Sandalwood)',
            'slug' => 'merchandise-hierarchy-scented-candle',
            'subtitle' => 'Luxury Aromatherapy Candle 180gr',
            'series_name' => 'Merchandise Hierarchy',
            'category' => 'merchandise',
            'subcategory' => 'merch',
            'author' => 'Bianca Veana',
            'price' => 85000,
            'stock' => 40,
            'cover_image' => '/images/merch_candle.svg',
            'synopsis' => 'Lilin aromaterapi beraroma bangsawan dengan perpaduan kayu cendana istana, amber manis, dan sentuhan bergamot segar.',
            'genre' => 'Lifestyle & Home',
            'weight_grams' => 380,
            'is_featured' => true,
            'order_index' => 21,
        ]);

        Product::create([
            'title' => 'Merchandise Fate — Exclusive Royal Swan Canvas Tote Bag',
            'slug' => 'merchandise-fate-swan-tote-bag',
            'subtitle' => 'Embroidered Premium Navy Canvas',
            'series_name' => 'Merchandise Fate',
            'category' => 'merchandise',
            'subcategory' => 'merch',
            'author' => 'Bianca Veana',
            'price' => 110000,
            'stock' => 65,
            'cover_image' => '/images/merch_totebag.svg',
            'synopsis' => 'Tas kanvas tebal berwarna ocean navy dengan bordir benang emas bermotif angsa dan kutipan resmi Bianca Veana Universe.',
            'genre' => 'Fashion & Accessories',
            'weight_grams' => 250,
            'is_featured' => true,
            'order_index' => 22,
        ]);

        // 6. Brand Quotes
        Quote::create([
            'quote' => 'Ikal rambutmu boleh kusut, hidupmu boleh berantakan, tapi biarlah saya yang merapikannya. Jika dalam hidup ini ada seseorang yang ingin kamu manfaatkan... jadikanlah itu saya.',
            'character_name' => 'Raden Mas Sadewa Atma Notonegoro',
            'book_title' => 'Mantra',
            'order_index' => 1,
        ]);

        Quote::create([
            'quote' => 'Permintaan aku hanya meminta anak, Mas? Untuk penerusmu di Notonegoro? Itu! Bukan meminta suamiku membagi cintanya!',
            'character_name' => 'Renata Dewandari',
            'book_title' => 'Hierarchy',
            'order_index' => 2,
        ]);

        Quote::create([
            'quote' => 'Saya nggak jadi Notonegoro, saya nggak apa-apa! Saya nggak punya anak, saya nggak apa-apa. Berhenti tatap saya begitu! Saya bukan penjahat!',
            'character_name' => 'Raden Mas Samudra Angkara Notonegoro',
            'book_title' => 'Hierarchy',
            'order_index' => 3,
        ]);

        Quote::create([
            'quote' => 'Saya mau semua orang yang pernah menyentuhnya hilang. Terserah hilang ke mana. Yang pasti, siapa pun yang pernah melukai perempuan saya, jangan lagi hidup satu bumi dengannya.',
            'character_name' => 'Raden Mas Raka Satya Notonegoro',
            'book_title' => 'Fate',
            'order_index' => 4,
        ]);

        Quote::create([
            'quote' => 'Bagaimana bisa aku hidup di dunia yang tak mencintaiku?',
            'character_name' => 'Natasha Kahiyang Raharjasa',
            'book_title' => 'Mantra',
            'order_index' => 5,
        ]);

        Quote::create([
            'quote' => 'Nggak ada Tuan Putri kayak aku. Bahkan aku aja nggak punya istana. Nggak ada yang bisa aku banggakan.',
            'character_name' => 'Amandra Nola Putri',
            'book_title' => 'Fate',
            'order_index' => 6,
        ]);

        // 7. Reviews
        Review::create([
            'reviewer_name' => 'Alika Prasetya',
            'book_title' => 'Mantra',
            'rating' => 5,
            'comment' => 'Novel Mantra luar biasa menguras emosi! Sadewa benar-benar standar pria fiksi tertinggi di semesta literatur Indonesia.',
        ]);

        Review::create([
            'reviewer_name' => 'Dinda Rarasati',
            'book_title' => 'Hierarchy',
            'rating' => 5,
            'comment' => 'Hierarchy bikin nggak bisa tidur semalaman. Dialog Renata dan Samudra nusuk banget sampai ke hati nurani.',
        ]);

        Review::create([
            'reviewer_name' => 'Vania Salsabila',
            'book_title' => 'Mantra Boxset',
            'rating' => 5,
            'comment' => 'Packaging sangat mewah, aman berlipat bubble wrap tebal, dan book jacket gold-nya benar-benar berkualitas butik.',
        ]);

        Review::create([
            'reviewer_name' => 'Nadia Kusumawardhani',
            'book_title' => 'E-Book Hierarchy',
            'rating' => 5,
            'comment' => 'E-book otomatis langsung masuk email dan Google Drive bisa diakses tanpa kendala. Sistemnya cepat dan memuaskan!',
        ]);

        // 8. Sample Demonstration Order (For Admin & Cetak Resi showcase)
        $order = Order::create([
            'order_number' => 'BV-20261026-8812',
            'customer_name' => 'Clara Maharani',
            'customer_email' => 'clara.maharani@example.com',
            'customer_phone' => '081234567890',
            'shipping_address' => 'Jl. Senopati Raya No. 42, Kebayoran Baru',
            'city' => 'Jakarta Selatan',
            'postal_code' => '12190',
            'courier' => 'JNE Regular (1-2 Hari)',
            'shipping_cost' => 18000,
            'subtotal' => 264000,
            'total_amount' => 282000,
            'payment_method' => 'Midtrans QRIS / Instant Pay',
            'payment_status' => 'paid',
            'order_status' => 'processing',
            'tracking_number' => 'JNE-BV98177529',
            'digital_delivered' => true,
            'notes' => 'Tolong sertakan bubble wrap ekstra untuk novel Mantra.',
        ]);

        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => 1,
            'product_title' => 'Mantra — The Seven Notonegoro Series I',
            'price' => 129000,
            'quantity' => 1,
            'subtotal' => 129000,
        ]);

        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => 2,
            'product_title' => 'Hierarchy — The Seven Notonegoro Series II',
            'price' => 135000,
            'quantity' => 1,
            'subtotal' => 135000,
        ]);
    }
}
