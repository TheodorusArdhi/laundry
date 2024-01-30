<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-light" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav fw-medium fs-5">
                @if(auth()->user()->level=="pemilik")
                    <a class="nav-link " href="{{ url('dashboard') }}">
                        <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                        Dashboard
                    </a>
                    <div class="sb-sidenav-menu-heading">Pemilik</div>
                    <a class="nav-link " href="{{ url('pemilik/layanan') }}">
                        <div class="sb-nav-link-icon"><i class="fa-solid fa-shirt"></i></i></div>
                        Layanan
                    </a>
                    <a class="nav-link" href="{{ url('pemilik/pengumuman') }}">
                        <div class="sb-nav-link-icon"><i class="fa-solid fa-tags"></i></div>
                        Pengumuman
                    </a>
                    <a class="nav-link" href="{{ url('pemilik/cabang') }}">
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
                            <a class="nav-link" href="{{ url('pemilik/laporan/penjualan') }}">Penjualan</a>
                            <a class="nav-link" href="{{ url('pemilik/laporan/layanan') }}">Layanan</a>
                        </nav>
                    </div>
                    <div class="sb-sidenav-menu-heading">Admin</div>
                    <a class="nav-link" href="{{ url('admin/transaksi') }}">
                        <div class="sb-nav-link-icon"><i class="fa-solid fa-receipt ms-1"></i></div>
                        Transaksi
                    </a>
                    <a class="nav-link" href="{{ url('admin/poin') }}">
                        <div class="sb-nav-link-icon"><i class="fa-solid fa-coins"></i></div>
                        Poin
                    </a>
                    <a class="nav-link" href="{{ url('pemilik/user') }}">
                        <div class="sb-nav-link-icon"><i class="fa-solid fa-users"></i></div>
                        Pengguna
                    </a>
                    <a class="nav-link" href="{{ url('admin/penyimpanan') }}">
                        <div class="sb-nav-link-icon"><i class="fa-solid fa-warehouse"></i></div>
                        Penyimpanan
                    </a>
                @elseif (auth()->user()->level=="admin")
                    <a class="nav-link " href="{{ url('dashboard') }}">
                        <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                        Dashboard
                    </a>
                    <div class="sb-sidenav-menu-heading">Admin</div>
                    <a class="nav-link" href="{{ url('admin/transaksi') }}">
                        <div class="sb-nav-link-icon"><i class="fa-solid fa-receipt ms-1"></i></div>
                        Transaksi
                    </a>
                    <a class="nav-link" href="{{ url('admin/poin') }}">
                        <div class="sb-nav-link-icon"><i class="fa-solid fa-coins"></i></div>
                        Poin
                    </a>
                    <a class="nav-link" href="{{ url('admin/user') }}">
                        <div class="sb-nav-link-icon"><i class="fa-solid fa-users"></i></div>
                        Pengguna
                    </a>
                    <a class="nav-link" href="{{ url('admin/penyimpanan') }}">
                        <div class="sb-nav-link-icon"><i class="fa-solid fa-warehouse"></i></div>
                        Penyimpanan
                    </a>    
                @elseif(auth()->user()->level=="anggota")
                    {{--  <a class="nav-link" href="{{ url('dashboard') }}">
                        <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                        Dashboard
                    </a>  --}}
                    <a class="nav-link" href="{{ url('pelanggan/transaksi') }}">
                        <div class="sb-nav-link-icon"><i class="fa-solid fa-receipt ms-1"></i></div>
                        Transaksi
                    </a>
                    <a class="nav-link" href="{{ url('anggota/poin') }}">
                        <div class="sb-nav-link-icon"><i class="fa-solid fa-coins"></i></div>
                        Poin
                    </a>
                @elseif(auth()->user()->level=="pelanggan")
                    {{--  <a class="nav-link" href="{{ url('dashboard') }}">
                        <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                        Dashboard
                    </a>  --}}
                    <a class="nav-link" href="{{ url('pelanggan/transaksi') }}">
                        <div class="sb-nav-link-icon"><i class="fa-solid fa-receipt ms-1"></i></div>
                        Transaksi
                    </a>
                @endif
            </div>
        </div>
        @if(auth()->user()->level!="pelanggan")
        <div class="sb-sidenav-footer fw-bold fs-5">
            @if(auth()->user()->level=="pemilik")
                Pemilik
            @elseif(auth()->user()->level=="admin")
                Admin
            @elseif(auth()->user()->level=="anggota")
                Anggota Loyalty
            @endif
        </div>
        @endif
    </nav>
</div>