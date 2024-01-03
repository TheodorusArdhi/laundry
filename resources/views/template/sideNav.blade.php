<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav fs-5">
                @if(auth()->user()->level=="owner")
                <a class="nav-link " href="{{ url('dashboard') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Dashboard
                </a>
                <div class="sb-sidenav-menu-heading">Owner</div>
                <a class="nav-link " href="{{ url('owner/layanan') }}">
                    <div class="sb-nav-link-icon"><i class="fa-solid fa-shirt"></i></i></div>
                    Layanan
                </a>
                <a class="nav-link" href="{{ url('owner/pengumuman') }}">
                    <div class="sb-nav-link-icon"><i class="fa-solid fa-tags"></i></div>
                    Pengumuman
                </a>
                <a class="nav-link" href="{{ url('owner/cabang') }}">
                    <div class="sb-nav-link-icon"><i class="fa-solid fa-code-branch"></i></div>
                    Cabang
                </a>
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLaporan" aria-expanded="false" aria-controls="collapseLaporan">
                    <div class="sb-nav-link-icon"><i class="fa-solid fa-chart-simple"></i></div>
                    Laporan
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseLaporan" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="{{ url('owner/laporan/penjualan') }}">Penjualan</a>
                        <a class="nav-link" href="{{ url('owner/laporan/layanan') }}">Layanan</a>
                    </nav>
                </div>
                <div class="sb-sidenav-menu-heading">Admin</div>
                <a class="nav-link" href="{{ url('admin/transaksi') }}">
                    <div class="sb-nav-link-icon"><i class="fa-solid fa-receipt ms-1"></i></div>
                    Transaksi
                </a>
                <a class="nav-link" href="{{ url('admin/user') }}">
                    <div class="sb-nav-link-icon"><i class="fa-solid fa-users"></i></div>
                    Pengguna
                </a>
                <a class="nav-link" href="{{ url('admin/poin') }}">
                    <div class="sb-nav-link-icon"><i class="fa-solid fa-coins"></i></div>
                    Poin
                </a>
                <a class="nav-link" href="{{ url('admin/penyimpanan') }}">
                    <div class="sb-nav-link-icon"><i class="fa-solid fa-warehouse"></i></div>
                    Penyimpanan
                </a>
                @elseif (auth()->user()->level=="admin")
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
                @elseif(auth()->user()->level=="pengguna")
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