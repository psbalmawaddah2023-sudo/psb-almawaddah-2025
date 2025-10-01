<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Capel</title>
    <link rel="stylesheet" href="{{ asset('css/welcome.css') }}">
    <link rel="icon" type="image/png" href="{{ asset('storage/' . ($pengaturan['site_logo'] ?? 'image/logo.png')) }}">
</head>

<body>
    <!-- POPUP -->
    <div id="popup" class="popup-overlay">
        <div class="popup-content">
            <h2>Info Pendaftaran</h2>
            <p>Saat ini sudah ada <strong>{{ $total }}</strong> calon pelajar yang mendaftar.</p>
            <button onclick="closePopup()" class="btn btn-primary">Tutup</button>
        </div>
    </div>

    <style>
        .popup-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .popup-content {
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            text-align: center;
            width: 300px;
            animation: fadeIn 0.3s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: scale(0.8);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }
    </style>

    <script>
        window.onload = function() {
            document.getElementById("popup").style.display = "flex";
        };

        function closePopup() {
            document.getElementById("popup").style.display = "none";
        }
    </script>
    
    
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



    <!-- HERO -->
    <section class="hero">
        <h3>Dashboard Calon Pelajar</h3>
        <h1>Halo, {{ $user->name }}</h1>
        <p>Kelola seluruh aktivitas pendaftaran Anda di sini.</p>

        @if ($pendaftaran)
            <a href="{{ route('capel.pendaftaran.all', $pendaftaran->id) }}" class="btn btn-primary">
                Lihat Data Pendaftaran
            </a>
        @else
            <a href="{{ route('capel.pendaftaran.step1') }}" class="btn btn-primary">Isi Formulir Pendaftaran</a>
        @endif
    </section>

    <!-- FITUR CAPEL -->
    <section class="cards">
        <div class="card">
            <img src="{{ asset('image/pendaftaraan.png') }}" alt="Pendaftaran">
            <h4>Pendaftaran</h4>
            @if ($pendaftaran)
                <p>Status:
                    @if ($pendaftaran->status_pendaftaran === 'pending')
                        <span class="badge bg-warning">Menunggu Verifikasi Admin</span>
                    @elseif($pendaftaran->status_pendaftaran === 'revisi')
                        <span class="badge bg-info">Perlu Revisi</span>
                    @elseif($pendaftaran->status_pendaftaran === 'diterima')
                        <span class="badge bg-success">Diterima</span>
                    @elseif($pendaftaran->status_pendaftaran === 'ditolak')
                        <span class="badge bg-danger">Ditolak</span>
                    @else
                        <span class="badge bg-secondary">Tidak Diketahui</span>
                    @endif
                </p>
                <br>
                <a href="{{ route('capel.pendaftaran.all') }}" class="btn btn-primary">Lihat Data Pendaftaran</a>
                </a>
            @else
                <p>Anda belum mengisi formulir pendaftaran.</p>
                <a href="{{ route('capel.pendaftaran.step1') }}" class="btn btn-primary">Daftar</a>
            @endif

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

    <!-- FAQ -->
    <section class="faq">
        <h2>{{ $pengaturan['faq_heading'] ?? 'Pertanyaan Seputar Pendaftaran Calon Pelajar' }}</h2>
        <p>{{ $pengaturan['faq_subtitle'] ?? 'Hal-hal yang sering ditanyakan seputar pendaftaran Calon Pelajar maupun ujian masuk.' }}
        </p>
        <br>
        <div class="faq-actions">
            <a href="{{ !empty($pengaturan['brosur_file'])
                ? asset('storage/' . $pengaturan['brosur_file'])
                : asset('files/browsur.pdf') }}"
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
                <p>{{ $pengaturan['faq1_answer'] ?? 'Program khusus untuk persiapan Ujian Masuk MBI yang diselenggarakan dalam 2 gelombang.' }}
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
