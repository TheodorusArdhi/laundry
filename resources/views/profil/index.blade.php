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
                        <div class="card shadow-lg border-0 rounded-lg ">
                            <div class="card-body">
                                @include('template.validate')
                                <form method="POST" action="{{ url('profil/update') }}">
                                    {{ csrf_field() }} 
                                    <div class="form-floating mb-3">
                                        <input class="form-control" name="nama" type="text" value="{{ $user->nama }}" />
                                        <label for="nama">Nama</label>
                                    </div>

                                    <div class="form-floating mb-3">
                                        <input class="form-control" name="email" type="email" value="{{ $user->email }}" />
                                        <label for="email">Email</label>
                                    </div>

                                    <div class="form-floating mb-3">
                                        <input class="form-control" name="no_telp" type="text" value="{{ $user->no_telp }}" />
                                        <label for="noTelp">Nomor Telepon</label>
                                    </div>

                                    <div class="mb-3 form-check form-switch">
                                        <input class="form-check-input" value="on" name="notifikasi" type="checkbox" role="switch" id="notifikasi" {{  ($user->notifikasi == "on" ? ' checked' : '') }}>
                                        <label class="form-check-label" for="notifikasi">Notifikasi WhatsApp</label>
                                    </div>

                                    <div class="mt-4 mb-0">
                                        <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                            <a type="submit" class="btn btn-success btn-block" href="{{ url('password') }}" >Ubah Password</a>
                                            <button type="submit" class="btn btn-primary btn-block" >Simpan</button>
                                        </div>
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
