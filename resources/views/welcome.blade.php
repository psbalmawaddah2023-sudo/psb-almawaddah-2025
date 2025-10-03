<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Judul -->
    <title>{{ $pengaturan['site_title'] ?? 'Portal Pendaftaran' }}</title>
    <link rel="stylesheet" href="{{ asset('css/welcome.css') }}">
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('storage/' . ($pengaturan['site_logo'] ?? 'image/logo.png')) }}">
</head>

<body>

    <!-- NAVBAR -->
    <header class="navbar">
        <div class="nav-left">
            <!-- Image Navbar -->
            <img src="{{ asset('storage/' . ($pengaturan['site_logo'] ?? 'image/logo.png')) }}" alt="Logo">
            <span class="site-title">{{ $pengaturan['site_title'] ?? 'Pendaftaran Capel' }}</span>
            <button class="nav-toggle" id="navToggle">&#9776;</button> <!-- Hamburger icon -->
        </div>
                <nav class="nav-links" id="navLinks">
            <a href="#">Beranda</a>
            <a href="{{ route('tutorial.website') }}">Tutorial</a>
        </nav>
        <div class="nav-right">
            <a href="{{ route('register') }}" class="btn">Buat Akun</a>
            <a href="{{ route('login') }}" class="btn btn-primary">Login</a>
        </div>
    </header>


    <!-- HERO -->
    <section class="hero">
        <h3>{{ $pengaturan['hero_heading'] ?? 'PENDAFTARAN CALON PELAJAR' }}</h3>
        <h1>{{ $pengaturan['hero_title'] ?? "Ma'hadul Mawaddah Al-Islamy Lil Banat" }}</h1>
        <p>{!! $pengaturan['hero_subtitle'] ?? 'Pesantren Putri Al Mawaddah<br>Coper - Jetis - Ponorogo' !!}</p>
    </section>

    <!-- CARDS -->
    <section class="cards">
        <div class="card">
            <img src="{{ asset($pengaturan['card_pendaftaran_img'] ?? 'image/pendaftaraan.png') }}" alt="Pendaftaran">
            <h4>{{ $pengaturan['card_pendaftaran_title'] ?? 'Pendaftaran' }}</h4>
            <p>{{ $pengaturan['card_pendaftaran_text'] ?? 'Login untuk mendaftarkan dan mengatur calon pelajar.' }}</p>
            <a href="{{ route('login') }}" class="btn btn-primary">Login</a>
        </div>
        <div class="card">
            <img src="{{ asset($pengaturan['card_tutorial_img'] ?? 'image/tutorial.png') }}" alt="Tutorial">
            <h4>{{ $pengaturan['card_tutorial_title'] ?? 'Tutorial' }}</h4>
            <p>{{ $pengaturan['card_tutorial_text'] ?? 'Silahkan membaca petunjuk untuk memahami aplikasi.' }}</p>
            <a href="{{ route('tutorial.website') }}" class="btn btn-primary">Selengkapnya</a>
        </div>
        <div class="card">
            <img src="{{ asset($pengaturan['card_info_img'] ?? 'image/info.png') }}" alt="Informasi">
            <h4>{{ $pengaturan['card_info_title'] ?? 'Informasi' }}</h4>
            <p>{{ $pengaturan['card_info_text'] ?? 'Baca informasi pendaftaran, syarat, dan ketentuan.' }}</p>
            <a href="{{ $pengaturan['info_link'] ?? 'https://www.pesantrenputrialmawaddah.sch.id' }}"
                class="btn btn-primary" target="_blank">Selengkapnya</a>
        </div>
        <div class="card">
            <img src="{{ asset($pengaturan['card_help_img'] ?? 'image/help.png') }}" alt="Bantuan">
            <h4>{{ $pengaturan['card_help_title'] ?? 'Bantuan' }}</h4>
            <p>{{ $pengaturan['card_help_text'] ?? 'Butuh bantuan? hubungi kami di sini.' }}</p>
            <br>
            <a href="{{ $pengaturan['whatsapp_link'] ?? 'https://wa.me/6282312565949' }}" class="btn btn-primary"
                target="_blank" rel="noopener noreferrer">Bantuan</a>
        </div>
    </section>

    <!-- VIDEO -->
    <section class="video-section" id="video-section">
        <h3>{{ $pengaturan['video_heading'] ?? 'Video' }}</h3>
        <h2>{{ $pengaturan['video_title'] ?? 'Video Profil Pesantren Putri Al Mawaddah' }}</h2>
        <p>{{ $pengaturan['video_subtitle'] ?? 'Pesantren Putri Al Mawaddah' }}</p>
        <div class="video-container">
            <iframe src="{{ $pengaturan['video_url'] ?? 'https://www.youtube.com/embed/NW5QPPdaFno' }}"
                allowfullscreen></iframe>
        </div>
    </section>

    <!-- FAQ -->
    <section class="faq">
        <h2>{{ $pengaturan['faq_heading'] ?? 'Pertanyaan Seputar Pendaftaran Calon Pelajar' }}</h2>
        <p>{{ $pengaturan['faq_subtitle'] ?? 'Hal-hal yang sering ditanyakan seputar pendaftaran Calon Pelajar maupun ujian masuk.' }}
        </p>
        <br>
        <div class="faq-actions">
            <a href="{{ $pengaturan['brosur_file'] ? asset('storage/' . $pengaturan['brosur_file']) : asset('files/browsur.pdf') }}"
                class="btn btn-primary" target="_blank" rel="noopener noreferrer" style="margin-right: 10px;">
                Browsur Online
            </a>

            <a href="{{ route('tutorial.website') }}" class="btn btn-secondary" target="_blank"
                rel="noopener noreferrer">
                Baca Tutorial Website
            </a>
        </div>
        <div class="faq-grid">
            <div>
                <h4>{{ $pengaturan['faq1_question'] ?? 'Apa itu Program Persiapan Calon Pelajar?' }}</h4>
                <p>{{ $pengaturan['faq1_answer'] ?? 'Program khusus untuk persiapan Ujian Masuk MBI yang diselenggarakan dalam 2 gelombang blablabla' }}
                </p>
            </div>
            <div>
                <h4>{{ $pengaturan['faq2_question'] ?? 'Bagaimana Kurikulumnya?' }}</h4>
                <p>{{ $pengaturan['faq2_answer'] ?? 'Kegiatan belajar mengajar mengikuti kurikulum MBI.' }}</p>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer>
        <p>{{ $pengaturan['footer_text'] ?? 'Panitia Ujian Masuk Calon Pelajar Pesantren Putri Al Mawaddah' }}
            <br>
            &copy; {{ date('Y') }}
        </p>
    </footer>
    <script>
        const navToggle = document.getElementById('navToggle');
        const navLinks = document.getElementById('navLinks');

        navToggle.addEventListener('click', () => {
            navLinks.classList.toggle('active');
        });
    </script>
</body>

</html>
