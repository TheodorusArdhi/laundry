<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                @if(auth()->user()->level=="admin")
                <a class="nav-link " href="/dashboard">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Dashboard
                </a>
                <div class="sb-sidenav-menu-heading">Halaman Utama</div>
                <a class="nav-link " href="/layanan">
                    <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                    Layanan dan Harga
                </a>
                <a class="nav-link" href="/pengumuman">
                    <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                    Pengumuman
                </a>
                <div class="sb-sidenav-menu-heading">Admin</div>
                <a class="nav-link" href="/transaksiAdmin">
                    <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                    Transaksi
                </a>
                <a class="nav-link" href="/pengguna">
                    <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                    Pengguna
                </a>
                <a class="nav-link" href="#">
                    <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                    Poin
                </a>
                @endif

                @if(auth()->user()->level=="pengguna")
                <a class="nav-link" href="/dashboard">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Dashboard
                </a>
                <a class="nav-link" href="/transaksiPengguna">
                    <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                    Transaksi
                </a>
                @endif
            </div>
        </div>
        <div class="sb-sidenav-footer">
            <div class="small"></div>
            <h5> Selamat datang {{ Auth::user()->nama }}</h5>
        </div>
    </nav>
</div>