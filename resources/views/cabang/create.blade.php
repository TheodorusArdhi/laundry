<!DOCTYPE html>
<html lang="en">
    <head>
        @include('template.head')
        <title>Cabang - Sinar Laundry</title>
    </head>
    <body class="sb-nav-fixed">
        @include('template.topNav')
        <div id="layoutSidenav">
            @include('template.sideNav')
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Cabang</h1>
                        <ol class="breadcrumb mb-2">
                            <li class="breadcrumb-item active">Tambah Cabang</li>
                        </ol>
                        @include('template.validate')
                        <div class="card shadow-lg border-0 rounded-lg fs-5">
                            <form method="POST" action="{{ url('pemilik/cabang/store') }}">
                                {{ csrf_field() }} 
                                <div class="row mx-3 g-3 align-items-center">
                                    <div class="col-6">
                                        <label for="nama" class="fw-semibold form-label mt-2 mb-0">Nama</label>
                                        <input type="text" id="nama" class="form-control form-control-lg" name="nama" placeholder="Nama Cabang" value="{{ Session::get('nama') }}" />
                                    </div>
                                    <div class="col-6">
                                        <label for="alamat" class="fw-semibold form-label mt-2 mb-0">Alamat</label>
                                        <input type="text" id="alamat" class="form-control form-control-lg" name="alamat" placeholder="Alamat Cabang" value="{{ Session::get('alamat') }}" />
                                    </div>
                                </div>

                                <div class="row mx-3 g-3 align-items-center">
                                    <div class="col-6 align-self-start">
                                        <label for="email" class="fw-semibold form-label mt-2 mb-0">Email</label>
                                        <input type="email" id="email" class="form-control form-control-lg" name="email" placeholder="nama@email.com" value="{{ Session::get('email') }}" />
                                    </div>
                                    <div class="col-6">
                                        <label for="no_telp" class="fw-semibold form-label mt-2 mb-0">Nomor Telepon</label>
                                        <input type="text" id="no_telp" class="form-control form-control-lg" name="no_telp" placeholder="Nomor Telepon Cabang" value="{{ Session::get('no_telp') }}" />
                                        <div id="no_telp" class="form-text">
                                            Masukkan nomor tanpa spasi
                                        </div>
                                    </div>
                                </div>

                                <div class="row mx-3 mb-2 g-3 align-items-center">
                                    <div class="col-auto">
                                    <a class="btn btn-danger fw-semibold" style="font-size: 1.12rem;" href="{{ url('pemilik/cabang') }}" role="button">Kembali</a>
                                    </div>
                                    <div class="col-auto"><button type="submit" class="btn btn-laundry btn-block fw-semibold" style="font-size: 1.12rem;" data-toggle="tooltip" data-placement="top" title="Simpan Cabang">Simpan</button></div>
                                </div>
                            </form>
                        </div>
                    </div>
                </main>
                @include('template.footer')
                @include('sweetalert::alert')
            </div>
        </div>
        @include('template.foot')
    </body>
</html>
