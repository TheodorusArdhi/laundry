<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                @if(auth()->user()->level=="admin")
                <a class="nav-link " href="{{ url('dashboard') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Dashboard
                </a>
                <div class="sb-sidenav-menu-heading">Halaman Utama</div>
                <a class="nav-link " href="{{ url('admin/layanan') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                    Layanan
                </a>
                <a class="nav-link" href="{{ url('admin/pengumuman') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                    Pengumuman
                </a>
                <div class="sb-sidenav-menu-heading">Owner</div>
                <a class="nav-link" href="{{ url('admin/cabang') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                    Cabang
                </a>
                <div class="sb-sidenav-menu-heading">Admin</div>
                <a class="nav-link" href="{{ url('admin/transaksi') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                    Transaksi
                </a>
                <a class="nav-link" href="{{ url('admin/user') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                    Pengguna
                </a>
                <a class="nav-link" href="{{ url('admin/poin') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                    Poin
                </a>
                <a class="nav-link" href="{{ url('admin/penyimpanan') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                    Penyimpanan
                </a>
                @endif

                @if(auth()->user()->level=="pengguna")
                <a class="nav-link" href="{{ url('dashboard') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Dashboard
                </a>
                <a class="nav-link" href="{{ url('user/transaksi') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                    Transaksi
                </a>
                <a class="nav-link" href="{{ url('user/poin') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                    Poin
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