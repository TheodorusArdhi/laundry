<!DOCTYPE html>
<html lang="en">
    <head>
        @include('template.head')
        <title>Pengguna - Sinar Laundry</title>
    </head>
    <body class="sb-nav-fixed">
        @include('template.topNav')
        <div id="layoutSidenav">
            @include('template.sideNav')
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Pengguna</h1>
                        <ol class="breadcrumb mb-2">
                            <li class="breadcrumb-item active">Edit Pengguna</li>
                        </ol>
                        @include('template.validate')
                        <div class="card shadow-lg border-0 rounded-lg ">
                            <form method="POST" action="{{ url('admin/user/'. $user->id_user.'/update') }}">
                                {{ csrf_field() }} 

                                <label for="nama" class="fw-semibold form-label mx-3 mt-2 mb-0">Nama</label>
                                <div class="row mx-3 g-3 align-items-center">
                                    <div class="col-3">
                                        <input type="text" id="nama" class="form-control" name="nama" value="{{ $user->nama }}" />
                                    </div>
                                </div>

                                <label for="email" class="fw-semibold form-label mx-3 mt-2 mb-0">Email</label>
                                <div class="row mx-3 g-3 align-items-center">
                                    <div class="col-3">
                                        <input type="email" id="email" class="form-control" name="email" value="{{ $user->email }}" />
                                    </div>
                                </div>

                                <label for="no_telp" class="fw-semibold form-label mx-3 mt-2 mb-0">Nomor Telepon</label>
                                <div class="row mx-3 g-3 align-items-center">
                                    <div class="col-3">
                                        <input type="text" id="no_telp" class="form-control" name="no_telp" value="{{ $user->no_telp }}" />
                                        <div id="no_telp" class="form-text">
                                            Masukkan nomor tanpa spasi
                                        </div>
                                    </div>
                                </div>

                                <label for="poin" class="fw-semibold form-label mx-3 mt-2 mb-0">Poin</label>
                                <div class="row mx-3 g-3 align-items-center">
                                    <div class="col-3">
                                        <input type="text" id="poin" class="form-control" name="poin" value="{{ $user->poin }}" />
                                    </div>
                                </div>

                                <label for="password" class="fw-semibold form-label mx-3 mt-2 mb-0">Password</label>
                                <div class="row mx-3 g-3 align-items-center">
                                    <div class=" form-check form-switch">
                                        <input class="form-check-input" value="on" name="password" type="checkbox" role="switch" id="password">
                                        <label class="form-check-label" for="password">Atur Ulang Password</label>
                                    </div>
                                </div>

                                <div class="row mx-3 mb-2 g-3 mt-1 align-items-center">
                                    <div class="col-auto">
                                    <a class="btn btn-danger" href="{{ url('admin/user') }}" role="button">Kembali</a>
                                    </div>
                                    <div class="col-auto"><button type="submit" class="btn btn-primary btn-block" >Simpan</button></div>
                                </div>
                            </form>
                        </div>
                    </div>
                </main>
                @include('sweetalert::alert')
            </div>
        </div>
        @include('template.foot')
    </body>
</html>
