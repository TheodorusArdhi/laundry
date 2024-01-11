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

                                    <div class="mb-3 mt-3 form-check form-switch">
                                        <input class="form-check-input" value="on" name="notifikasi" type="checkbox" role="switch" id="notifikasi" {{  ($user->notifikasi == "on" ? ' checked' : '') }}>
                                        <label class="form-check-label" for="notifikasi">Notifikasi WhatsApp</label>
                                    </div>

                                    <div class="mt-4 mb-0">
                                        <a type="submit" class="btn btn-secondary btn-block fw-semibold" style="font-size: 1.12rem;" data-toggle="tooltip" data-placement="top" title="v" href="{{ url('password') }}" >Ubah Password</a>
                                        <button type="submit" class="btn btn-laundry btn-block fw-semibold" style="font-size: 1.12rem;" data-toggle="tooltip" data-placement="top" title="Simpan Profil">Simpan</button>
                                    </div>
                                </form>
                                @include('sweetalert::alert')
                            </div>
                        </div>
                    </div>
                </main>
                @include('sweetalert::alert')
            </div>
        </div>
        @include('template.foot')
    </body>
</html>
