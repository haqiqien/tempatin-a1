<?php

namespace Database\Seeders;

use App\Models\Place;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        $reviewers = $this->ensureReviewers();

        $reviews = [
            'Kafe Ruang Kerja Jogja' => [
                [
                    'user' => 'Rina Kartika',
                    'rating_overall' => 5, 'rating_wifi' => 5, 'rating_comfort' => 4, 'rating_socket' => 5,
                    'comment' => 'Tempat favorit buat kerja! WiFi-nya ngebut banget, stop kontak ada di mana-mana, dan suasananya tenang. Kopi susu-nya juga enak. Cocok buat work from cafe seharian.',
                ],
                [
                    'user' => 'Dimas Pratama',
                    'rating_overall' => 4, 'rating_wifi' => 4, 'rating_comfort' => 5, 'rating_socket' => 4,
                    'comment' => 'Kursinya nyaman dan lighting-nya pas banget buat mata. Sudah beberapa kali balik ke sini. Parkiran juga luas.',
                ],
                [
                    'user' => 'Sari Indah',
                    'rating_overall' => 4, 'rating_wifi' => 3, 'rating_comfort' => 4, 'rating_socket' => 5,
                    'comment' => 'Stop kontak ada di hampir setiap meja, sangat membantu buat yang bawa laptop. WiFi kadang agak lambat kalau siang ramai.',
                ],
                [
                    'user' => 'Bima Arya',
                    'rating_overall' => 5, 'rating_wifi' => 5, 'rating_comfort' => 5, 'rating_socket' => 4,
                    'comment' => 'Suasana sangat nyaman dan kondusif. AC-nya pas tidak terlalu dingin. Recommended banget!',
                ],
            ],

            'Coworking Space Malioboro' => [
                [
                    'user' => 'Putri Wulandari',
                    'rating_overall' => 5, 'rating_wifi' => 5, 'rating_comfort' => 5, 'rating_socket' => 5,
                    'comment' => 'Profesional banget! Lokasinya strategis di Malioboro, fasilitas lengkap. Ada loker untuk simpan barang dan printer yang bisa dipakai. Pelayanannya juga ramah.',
                ],
                [
                    'user' => 'Rizky Firmansyah',
                    'rating_overall' => 4, 'rating_wifi' => 5, 'rating_comfort' => 4, 'rating_socket' => 5,
                    'comment' => 'WiFi sangat stabil cocok buat meeting online. Bisa sewa per jam atau harian. Harga sepadan dengan fasilitas yang didapat.',
                ],
                [
                    'user' => 'Mega Lestari',
                    'rating_overall' => 5, 'rating_wifi' => 4, 'rating_comfort' => 5, 'rating_socket' => 5,
                    'comment' => 'Paling suka bagian ruang privat-nya, sangat kondusif buat kerja deep focus. Interior modern dan bersih. Akan terus balik lagi.',
                ],
                [
                    'user' => 'Andi Setiawan',
                    'rating_overall' => 4, 'rating_wifi' => 4, 'rating_comfort' => 4, 'rating_socket' => 4,
                    'comment' => 'Tempatnya oke, fasilitas lengkap. Sedikit ramai di jam makan siang tapi masih oke. Lokasinya mudah dijangkau transportasi umum.',
                ],
            ],

            'Perpustakaan Kota Yogyakarta' => [
                [
                    'user' => 'Hana Safitri',
                    'rating_overall' => 5, 'rating_wifi' => 4, 'rating_comfort' => 5, 'rating_socket' => 3,
                    'comment' => 'Perpustakaan yang sangat nyaman dan tenang. Koleksi bukunya lengkap. Tempat baca yang ideal untuk belajar. Suasananya kondusif banget.',
                ],
                [
                    'user' => 'Gilang Nugraha',
                    'rating_overall' => 4, 'rating_wifi' => 4, 'rating_comfort' => 5, 'rating_socket' => 3,
                    'comment' => 'Gratis dan nyaman! WiFi cukup kencang untuk browsing dan referensi online. AC-nya adem. Satu-satunya kekurangan stop kontak masih kurang banyak.',
                ],
                [
                    'user' => 'Tari Kusuma',
                    'rating_overall' => 5, 'rating_wifi' => 3, 'rating_comfort' => 5, 'rating_socket' => 3,
                    'comment' => 'Tempat paling tenang di Jogja untuk belajar. Bisa betah seharian di sini. Kursinya nyaman dan meja-mejanya lebar.',
                ],
            ],

            'Warung Kopi Produktif' => [
                [
                    'user' => 'Dinda Rahmawati',
                    'rating_overall' => 4, 'rating_wifi' => 4, 'rating_comfort' => 3, 'rating_socket' => 5,
                    'comment' => 'Warung kopi paling ramah kantong di Seturan! Harganya terjangkau banget untuk mahasiswa. Stop kontak banyak, WiFi lancar. Tempat duduk sederhana tapi fungsional.',
                ],
                [
                    'user' => 'Fajar Santoso',
                    'rating_overall' => 4, 'rating_wifi' => 3, 'rating_comfort' => 3, 'rating_socket' => 4,
                    'comment' => 'Buka sampai tengah malam, penyelamat banget waktu ngerjain tugas! Kopinya enak dan murah. WiFi kadang lemot di jam ramai.',
                ],
                [
                    'user' => 'Nadia Permata',
                    'rating_overall' => 5, 'rating_wifi' => 4, 'rating_comfort' => 4, 'rating_socket' => 5,
                    'comment' => 'Langganan saya kalau ngerjain skripsi. Pesanlah kopi susu gula aren-nya, enak banget! Tempat bersih dan stop kontaknya banyak.',
                ],
                [
                    'user' => 'Rina Kartika',
                    'rating_overall' => 3, 'rating_wifi' => 3, 'rating_comfort' => 3, 'rating_socket' => 4,
                    'comment' => 'Cocok untuk kerja sebentar atau ngobrol santai. Untuk kerja panjang agak kurang nyaman karena kadang berisik. Tapi harganya oke.',
                ],
            ],

            'The Study Hub Bandung' => [
                [
                    'user' => 'Aditya Nugraha',
                    'rating_overall' => 5, 'rating_wifi' => 5, 'rating_comfort' => 5, 'rating_socket' => 5,
                    'comment' => 'Coworking terbaik di Bandung menurut saya. Pemandangan dari lantai atas keren banget. WiFi super cepat, ada ruang meeting privat, dan loker aman. Worth every rupiah!',
                ],
                [
                    'user' => 'Cindy Oktaviani',
                    'rating_overall' => 5, 'rating_wifi' => 5, 'rating_comfort' => 5, 'rating_socket' => 4,
                    'comment' => 'Saya kerja remote dan ini jadi basecamp favorit. Suasana produktif banget, komunitas freelancer-nya solid. Juga ada printer yang selalu siap.',
                ],
                [
                    'user' => 'Dimas Pratama',
                    'rating_overall' => 4, 'rating_wifi' => 5, 'rating_comfort' => 4, 'rating_socket' => 5,
                    'comment' => 'Fasilitas lengkap dan profesional. Lokasinya di Dago yang strategis. Harga sedikit premium tapi sebanding dengan kualitasnya.',
                ],
                [
                    'user' => 'Rizky Firmansyah',
                    'rating_overall' => 5, 'rating_wifi' => 4, 'rating_comfort' => 5, 'rating_socket' => 5,
                    'comment' => 'Paling suka suasana paginya, enak banget mulai kerja di sini. Ada musholla yang bersih dan loker yang aman. Sangat recommended!',
                ],
            ],

            'Kopi Teduh Gejayan' => [
                [
                    'user' => 'Laras Wijaya',
                    'rating_overall' => 5, 'rating_wifi' => 4, 'rating_comfort' => 5, 'rating_socket' => 5,
                    'comment' => 'Nama tempatnya sesuai dengan atmosfernya — teduh dan adem. Meja panjangnya enak buat kerja bareng teman. Stop kontak ada di sepanjang meja, tidak perlu rebutan!',
                ],
                [
                    'user' => 'Bima Arya',
                    'rating_overall' => 4, 'rating_wifi' => 4, 'rating_comfort' => 5, 'rating_socket' => 4,
                    'comment' => 'Suasana kafe yang benar-benar tenang. Cocok untuk kerja serius. Kopinya enak dan harganya masuk akal. Parkiran motornya luas.',
                ],
                [
                    'user' => 'Sari Indah',
                    'rating_overall' => 5, 'rating_wifi' => 5, 'rating_comfort' => 5, 'rating_socket' => 5,
                    'comment' => 'Sudah jadi tempat kerja favorit saya! Tidak terlalu ramai, WiFi lancar, dan pelayannya ramah. Interior-nya juga aesthetic banget.',
                ],
            ],

            'Ruang Fokus Seturan' => [
                [
                    'user' => 'Kevin Hermawan',
                    'rating_overall' => 5, 'rating_wifi' => 5, 'rating_comfort' => 5, 'rating_socket' => 5,
                    'comment' => 'Pilihan terbaik kalau butuh fokus kerja tanpa gangguan. Ada ruang privat untuk meeting, printer, dan musholla. Sangat terorganisir dan profesional untuk ukuran harganya.',
                ],
                [
                    'user' => 'Mega Lestari',
                    'rating_overall' => 5, 'rating_wifi' => 5, 'rating_comfort' => 4, 'rating_socket' => 5,
                    'comment' => 'Coworking yang paling kondusif di Seturan. WiFi stabil banget, cocok buat meeting online atau kerja yang butuh koneksi kencang. Printer-nya juga selalu berfungsi.',
                ],
                [
                    'user' => 'Putri Wulandari',
                    'rating_overall' => 4, 'rating_wifi' => 4, 'rating_comfort' => 5, 'rating_socket' => 4,
                    'comment' => 'Nyaman dan bersih. AC-nya pas, tidak bikin kedinginan. Musholla-nya bersih dan tersedia. Saya sering booking ruang privatnya untuk interview online.',
                ],
                [
                    'user' => 'Gilang Nugraha',
                    'rating_overall' => 4, 'rating_wifi' => 5, 'rating_comfort' => 4, 'rating_socket' => 4,
                    'comment' => 'Sangat membantu buat kerja freelance harian. Harga transparan dan sesuai ekspektasi. Sekali datang pasti balik lagi.',
                ],
            ],

            'Nasi Sela Produktif' => [
                [
                    'user' => 'Hana Safitri',
                    'rating_overall' => 4, 'rating_wifi' => 3, 'rating_comfort' => 4, 'rating_socket' => 3,
                    'comment' => 'Makanannya enak dan porsinya gede! Suasananya ramai tapi asyik buat diskusi kelompok. Tempatnya luas dan ada musholla yang bersih.',
                ],
                [
                    'user' => 'Fajar Santoso',
                    'rating_overall' => 4, 'rating_wifi' => 4, 'rating_comfort' => 3, 'rating_socket' => 3,
                    'comment' => 'Cocok banget buat makan siang sambil rapat tim. Harganya sangat terjangkau dan pilihan menunya banyak. WiFi ada tapi agak lambat.',
                ],
                [
                    'user' => 'Nadia Permata',
                    'rating_overall' => 5, 'rating_wifi' => 3, 'rating_comfort' => 4, 'rating_socket' => 3,
                    'comment' => 'Nasi ayamnya juara! Tempat ini jadi andalan makan siang saya pas di Babarsari. Tukang parkirnya membantu dan ramah. Rekomendasi!',
                ],
            ],

            'Perpus Mini Condongcatur' => [
                [
                    'user' => 'Tari Kusuma',
                    'rating_overall' => 4, 'rating_wifi' => 4, 'rating_comfort' => 5, 'rating_socket' => 3,
                    'comment' => 'Perpus kecil yang nyaman dan sepi. Cocok banget buat belajar serius. Selalu berhasil fokus di sini karena suasananya kondusif.',
                ],
                [
                    'user' => 'Laras Wijaya',
                    'rating_overall' => 4, 'rating_wifi' => 3, 'rating_comfort' => 5, 'rating_socket' => 2,
                    'comment' => 'Tempatnya sunyi dan AC-nya adem. Cocok buat baca buku atau ngerjain tugas. Memang stop kontak sangat terbatas, lebih baik bawa power bank.',
                ],
                [
                    'user' => 'Dinda Rahmawati',
                    'rating_overall' => 5, 'rating_wifi' => 4, 'rating_comfort' => 5, 'rating_socket' => 3,
                    'comment' => 'Permata tersembunyi di Condongcatur! Sangat sepi dan nyaman. WiFi-nya lumayan untuk kebutuhan belajar. Gratis pula!',
                ],
            ],

            'Kedai Transit Jakal' => [
                [
                    'user' => 'Kevin Hermawan',
                    'rating_overall' => 4, 'rating_wifi' => 4, 'rating_comfort' => 3, 'rating_socket' => 4,
                    'comment' => 'Penyelamat buat yang sering kerja malam! Buka sampai subuh, minuman terjangkau, dan stop kontak tersedia. Tempatnya semi-outdoor jadi ada angin malam yang segar.',
                ],
                [
                    'user' => 'Aditya Nugraha',
                    'rating_overall' => 3, 'rating_wifi' => 3, 'rating_comfort' => 3, 'rating_socket' => 4,
                    'comment' => 'Bagus untuk nongkrong atau kerja sambil santai. Harga terjangkau sekali. WiFi agak sering putus tapi bisa buat WhatsApp-an dan browsing biasa.',
                ],
                [
                    'user' => 'Cindy Oktaviani',
                    'rating_overall' => 4, 'rating_wifi' => 4, 'rating_comfort' => 3, 'rating_socket' => 5,
                    'comment' => 'Suka datang ke sini sambil deadline tengah malam. Stop kontak banyak dan kopi teh-nya murah meriah. Parkir aman ada tukang parkirnya.',
                ],
            ],

            'Workpod Cihampelas' => [
                [
                    'user' => 'Andi Setiawan',
                    'rating_overall' => 5, 'rating_wifi' => 5, 'rating_comfort' => 5, 'rating_socket' => 5,
                    'comment' => 'Coworking modern terbaik di Cihampelas. Fasilitas sangat lengkap: loker, printer, musholla, dan parkir mobil. Harga memang lebih tinggi tapi wajar dengan fasilitasnya.',
                ],
                [
                    'user' => 'Sari Indah',
                    'rating_overall' => 5, 'rating_wifi' => 5, 'rating_comfort' => 4, 'rating_socket' => 5,
                    'comment' => 'Tempat kerja yang ideal untuk profesional. WiFi blazing fast dan koneksinya stabil sepanjang hari. Interior modern dan bersih sekali.',
                ],
                [
                    'user' => 'Bima Arya',
                    'rating_overall' => 4, 'rating_wifi' => 4, 'rating_comfort' => 5, 'rating_socket' => 5,
                    'comment' => 'AC-nya sejuk dan kursinya ergonomis. Saya sering pesan tempat di sini untuk kerja full day. Mushollanya bersih dan mudah ditemukan.',
                ],
                [
                    'user' => 'Hana Safitri',
                    'rating_overall' => 4, 'rating_wifi' => 5, 'rating_comfort' => 4, 'rating_socket' => 4,
                    'comment' => 'Nyaman dan profesional. Loker sangat membantu buat yang bawa barang banyak. Rekomendasi untuk kerja remote jangka panjang.',
                ],
            ],

            'Kopi Braga Tenang' => [
                [
                    'user' => 'Mega Lestari',
                    'rating_overall' => 5, 'rating_wifi' => 4, 'rating_comfort' => 5, 'rating_socket' => 3,
                    'comment' => 'Vibes heritage Braga sangat terasa di sini! Interior klasik tapi WiFi modern. Cocok untuk kerja singkat 2-3 jam sambil menikmati kopi berkualitas.',
                ],
                [
                    'user' => 'Kevin Hermawan',
                    'rating_overall' => 4, 'rating_wifi' => 3, 'rating_comfort' => 5, 'rating_socket' => 3,
                    'comment' => 'Suasananya unik dan nyaman banget. Kopinya enak dan ada pilihan kue-kue lokal. Untuk working session panjang kurang ideal karena stop kontak terbatas.',
                ],
                [
                    'user' => 'Laras Wijaya',
                    'rating_overall' => 5, 'rating_wifi' => 4, 'rating_comfort' => 5, 'rating_socket' => 4,
                    'comment' => 'Kafe terfavorit saya di Bandung. Desain interiornya Instagramable banget tapi tetap nyaman untuk kerja. AC sejuk dan tidak terlalu bising.',
                ],
            ],

            'Ruang Baca Taman Suropati' => [
                [
                    'user' => 'Rizky Firmansyah',
                    'rating_overall' => 4, 'rating_wifi' => 4, 'rating_comfort' => 5, 'rating_socket' => 2,
                    'comment' => 'Oasis tenang di tengah Jakarta yang sibuk! Lokasinya di dekat taman Suropati bikin suasana segar. Cocok buat baca atau belajar. WiFi lumayan dan toilet bersih.',
                ],
                [
                    'user' => 'Tari Kusuma',
                    'rating_overall' => 5, 'rating_wifi' => 3, 'rating_comfort' => 5, 'rating_socket' => 2,
                    'comment' => 'Gratis dan tenang. Tempatnya bersih dan terawat. Sambil baca buku bisa dengerin suara alam dari taman. Stop kontak memang sangat sedikit.',
                ],
                [
                    'user' => 'Dinda Rahmawati',
                    'rating_overall' => 4, 'rating_wifi' => 4, 'rating_comfort' => 4, 'rating_socket' => 3,
                    'comment' => 'Sering ke sini kalau sedang di Menteng. Suasananya enak dan tidak sesumuk perpustakaan biasa. Ada musholla yang bersih juga.',
                ],
            ],

            'Dapur Kerja Tebet' => [
                [
                    'user' => 'Gilang Nugraha',
                    'rating_overall' => 5, 'rating_wifi' => 5, 'rating_comfort' => 5, 'rating_socket' => 5,
                    'comment' => 'Perfect spot buat informal meeting! WiFi kencang dan stabil, ada stop kontak di meja, AC nyaman. Makanannya juga enak dan porsi cukup. Highly recommended.',
                ],
                [
                    'user' => 'Fajar Santoso',
                    'rating_overall' => 4, 'rating_wifi' => 4, 'rating_comfort' => 4, 'rating_socket' => 4,
                    'comment' => 'Tempat yang tepat untuk kerja sambil makan. Menu variatif dan harga reasonable untuk Jakarta Selatan. WiFi stabil, stop kontak tersedia.',
                ],
                [
                    'user' => 'Nadia Permata',
                    'rating_overall' => 5, 'rating_wifi' => 4, 'rating_comfort' => 5, 'rating_socket' => 4,
                    'comment' => 'Sering rapat tim di sini. Suasana tidak terlalu formal, makanan enak, dan WiFi bisa diandalkan. Parkir mobil tersedia. Lokasi Tebet gampang dijangkau.',
                ],
            ],

            'Creative Corner Surabaya' => [
                [
                    'user' => 'Putri Wulandari',
                    'rating_overall' => 4, 'rating_wifi' => 4, 'rating_comfort' => 3, 'rating_socket' => 4,
                    'comment' => 'Ruang komunitas yang vibes-nya asyik! Ramai tapi justru bikin semangat. Ada banyak event dan workshop menarik. WiFi oke dan stop kontak tersebar merata.',
                ],
                [
                    'user' => 'Aditya Nugraha',
                    'rating_overall' => 4, 'rating_wifi' => 3, 'rating_comfort' => 3, 'rating_socket' => 4,
                    'comment' => 'Tempat yang unik untuk co-creation dan kolaborasi. Bisa ketemu banyak orang kreatif di sini. Agak ramai memang, tapi cocok kalau butuh inspirasi.',
                ],
                [
                    'user' => 'Cindy Oktaviani',
                    'rating_overall' => 5, 'rating_wifi' => 4, 'rating_comfort' => 4, 'rating_socket' => 5,
                    'comment' => 'Komunitas kreatornya aktif banget. Ada loker aman, musholla bersih, dan stop kontak banyak. Lebih dari sekedar tempat kerja, ini adalah ekosistem kreatif.',
                ],
            ],
        ];

        foreach ($reviews as $placeName => $placeReviews) {
            $place = Place::where('place_name', $placeName)->first();
            if (! $place) {
                continue;
            }

            foreach ($placeReviews as $reviewData) {
                $user = $reviewers[$reviewData['user']] ?? null;
                if (! $user) {
                    continue;
                }

                Review::updateOrCreate(
                    ['user_id' => $user->user_id, 'place_id' => $place->place_id],
                    [
                        'rating_wifi' => $reviewData['rating_wifi'],
                        'rating_comfort' => $reviewData['rating_comfort'],
                        'rating_socket' => $reviewData['rating_socket'],
                        'rating_overall' => $reviewData['rating_overall'],
                        'comment' => $reviewData['comment'],
                        'is_verified' => true,
                    ]
                );
            }
        }
    }

    private function ensureReviewers(): array
    {
        $names = [
            'Rina Kartika'      => 'rina.kartika@example.com',
            'Dimas Pratama'     => 'dimas.pratama@example.com',
            'Sari Indah'        => 'sari.indah@example.com',
            'Bima Arya'         => 'bima.arya@example.com',
            'Putri Wulandari'   => 'putri.wulandari@example.com',
            'Rizky Firmansyah'  => 'rizky.firmansyah@example.com',
            'Mega Lestari'      => 'mega.lestari@example.com',
            'Andi Setiawan'     => 'andi.setiawan@example.com',
            'Hana Safitri'      => 'hana.safitri@example.com',
            'Gilang Nugraha'    => 'gilang.nugraha@example.com',
            'Tari Kusuma'       => 'tari.kusuma@example.com',
            'Dinda Rahmawati'   => 'dinda.rahmawati@example.com',
            'Fajar Santoso'     => 'fajar.santoso@example.com',
            'Nadia Permata'     => 'nadia.permata@example.com',
            'Laras Wijaya'      => 'laras.wijaya@example.com',
            'Kevin Hermawan'    => 'kevin.hermawan@example.com',
            'Aditya Nugraha'    => 'aditya.nugraha@example.com',
            'Cindy Oktaviani'   => 'cindy.oktaviani@example.com',
        ];

        $users = [];
        foreach ($names as $fullName => $email) {
            $users[$fullName] = User::updateOrCreate(
                ['email' => $email],
                [
                    'full_name' => $fullName,
                    'password'  => Hash::make('password'),
                    'role'      => 'user',
                    'status'    => 'active',
                ]
            );
        }

        return $users;
    }
}
