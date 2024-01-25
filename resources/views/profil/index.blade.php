<!DOCTYPE html>
<html lang="en">
    <head>
        @include('template.head')
        <title>Profil - Sinar Laundry</title>
    </head>
    <body class="sb-nav-fixed">
        @include('template.topNav')
        <div id="layoutSidenav">
            @include('template.sideNav')
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Profil</h1>
                        @include('template.validate')
                        <div class="card shadow-lg border-0 rounded-lg fs-5">
                            <div class="card-body">
                                <form method="POST" action="{{ url('profil/update') }}">
                                    {{ csrf_field() }} 

                                    <label for="nama" class="fw-semibold form-label mb-0">Nama</label>
                                    <div class="row g-3 align-items-center">
                                        <div class="col-3">
                                            <input type="text" id="nama" class="form-control form-control-lg" name="nama" value="{{ $user->nama }}" />
                                        </div>
                                    </div>
    
                                    <label for="email" class="fw-semibold form-label mt-2 mb-0">Email</label>
                                    <div class="row g-3 align-items-center">
                                        <div class="col-3">
                                            <input type="email" id="email" class="form-control form-control-lg" name="email" value="{{ $user->email }}" />
                                        </div>
                                    </div>
    
                                    <label for="no_telp" class="fw-semibold form-label mt-2 mb-0">Nomor Telepon</label>
                                    <div class="row g-3 align-items-center">
                                        <div class="col-3">
                                            <input type="text" id="no_telp" class="form-control form-control-lg" name="no_telp" value="{{ $user->no_telp }}" />
                                            <div id="no_telp" class="form-text">
                                                Masukkan nomor tanpa spasi
                                            </div>
                                        </div>
                                    </div>

                                    @if(auth()->user()->level=="pelanggan" || auth()->user()->level=="anggota")
                                        <div class="mb-3 mt-3 form-check form-switch">
                                            <input class="form-check-input" value="on" name="notifikasi" type="checkbox" role="switch" id="notifikasi" {{  ($user->notifikasi == "on" ? ' checked' : '') }}>
                                            <label class="form-check-label fw-medium" for="notifikasi">Notifikasi WhatsApp</label>
                                        </div>
                                    @endif

                                    <div class="mt-4 mb-0">
                                        <a type="submit" class="btn btn-secondary btn-block fw-semibold" style="font-size: 1.12rem;" data-toggle="tooltip" data-placement="top" title="v" href="{{ url('password') }}" >Ubah Password</a>
                                        <button type="submit" class="btn btn-laundry btn-block fw-semibold" style="font-size: 1.12rem;" data-toggle="tooltip" data-placement="top" title="Simpan Profil">Simpan</button>
                                    </div>
                                </form>
                                @include('sweetalert::alert')
                            </div>
                        </div>

                        @if(auth()->user()->level=="pelanggan" )
                        <div class="card shadow-lg border-0 rounded-lg fs-5 mt-3">
                            <div class="card-body">
                                <div class="row mt-2">
                                    <div class="col-xl-6">
                                        <div class="card mb-2">
                                            <div class="card-header fw-semibold fs-5">
                                                <i class="fa-solid fa-coins"></i>  Loyalty Program
                                            </div>
                                            <div class="card-body">
                                                <h5 class="card-title fs-4">Dapatkan Potongan Harga Pada Setiap Transaksi Anda!</h5>
                                                <p class="card-text fs-55">Bergabunglah menjadi anggota loyalty program dan dapatkan  potongan harga berupa poin pada setiap kunjungan anda mulai hari ini!</p>
                                                <a href=" {{ url('pelanggan/otp') }}" class="btn btn-laundry fw-semibold fs-4">Gabung Sekarang</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif

                    </div>
                </main>
                @include('sweetalert::alert')
            </div>
        </div>
        @include('template.foot')
    </body>
</html>
