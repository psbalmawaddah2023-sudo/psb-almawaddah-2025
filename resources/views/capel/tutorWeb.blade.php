<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tutorial Website</title>
    <link rel="stylesheet" href="{{ asset('css/welcome.css') }}">
</head>

<body>

    <!-- NAVBAR -->
    <header class="navbar">
        <div class="nav-left">
            <span class="site-title">{{ $pengaturan['site_title'] ?? 'Pendaftaran Capel' }}</span>
            <button class="nav-toggle" id="navToggle">&#9776;</button> <!-- Hamburger icon -->
        </div>

        <nav class="nav-links" id="navLinks">
            <a href="{{ route('capel.dashboard') }}">Beranda</a>
            <a href="{{ route('capel.tutorial.website') }}">Tutorial</a>
        </nav>

        <div class="nav-right">
            @auth
                <span>Hai, {{ Auth::user()->name }}</span>
                <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit" class="btn btn-primary">Logout</button>
                </form>
            @endauth
        </div>
    </header>

    <!-- PAGE TITLE -->
    <section class="page-header">
        <h1>Tutorial Website</h1>
        <p>Panduan lengkap penggunaan portal pendaftaran calon pelajar.</p>
    </section>

    <!-- CONTENT -->
    <section class="tutorial-content">
        <h2>Langkah-langkah Pendaftaran</h2>
        <ol>
            <li>Klik tombol <b>Buat Akun</b> di kanan atas halaman.</li>
            <li>Isi data diri sesuai formulir yang tersedia.</li>
            <li>Login menggunakan email dan password yang sudah didaftarkan.</li>
            <li>Lengkapi data calon pelajar dan unggah berkas yang diminta.</li>
            <li>Ikuti instruksi pembayaran dan konfirmasi pendaftaran.</li>
        </ol>

        <h2>Video Panduan</h2>
        <div class="video-container">
            <iframe src="{{ $pengaturan['video_tutorial'] ?? 'https://www.youtube.com/embed/NW5QPPdaFno' }}"
                allowfullscreen></iframe>
        </div>

        <h2>Tips Menggunakan Website</h2>
        <ul>
            <li>Gunakan browser terbaru (Chrome, Edge, atau Firefox).</li>
            <li>Pastikan koneksi internet stabil.</li>
            <li>
                Jika ada kendala, hubungi admin melalui tombol
                <a href="https://wa.me/6282312565949" style="font-weight: bold; text-decoration: none;" target="_blank">
                    Bantuan
                </a>.
            </li>

        </ul>
    </section>

    <!-- FOOTER -->
    <footer>
        <p>{{ $pengaturan['footer_text'] ?? 'Panitia Ujian Masuk Calon Pelajar Pesantren Putri Al Mawaddah' }}
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
