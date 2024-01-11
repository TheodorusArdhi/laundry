<!DOCTYPE html>
<html lang="en">
    <head>
        @include('template.head')
        <style>
            option:hover {
              background-color: lime;
            }
          </style>
        <title>Layanan - Sinar Laundry</title>
    </head>
    <body class="sb-nav-fixed">
        @include('template.topNav')
        <div id="layoutSidenav">
            @include('template.sideNav')
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Layanan</h1>
                        <ol class="breadcrumb mb-2">
                            <li class="breadcrumb-item active">Tambah Layanan</li>
                        </ol>
                        @include('template.validate')
                        <div class="card shadow-lg border-0 rounded-lg fs-5">
                            <form method="POST" action="{{ url('owner/layanan/store') }}">
                                {{ csrf_field() }} 
                                <label for="nama" class="fw-semibold form-label mx-3 mt-2 mb-0">Nama</label>
                                <div class="row mx-3 g-3 align-items-center">
                                    <div class="col-3">
                                        <input type="text" id="nama" class="form-control form-control-lg" placeholder="Masukkan Nama Layanan" name="nama" value="{{ Session::get('nama') }}" />
                                    </div>
                                </div>

                                <label for="harga" class="fw-semibold form-label mx-3 mt-2 mb-0">Harga</label>
                                <div class="row mx-3 g-3 align-items-center">
                                    <div class="col-3">
                                        <input class="form-control form-control-lg" name="harga" id="harga" type="number" placeholder="Masukkan Harga Layanan" value="{{ Session::get('harga') }}" />
                                    </div>
                                </div>

                                <label for="durasi" class="fw-semibold form-label mx-3 mt-2 mb-0">Durasi</label>
                                <div class="row mx-3 g-3 align-items-center">
                                    <div class="col-3">
                                        <input type="number" id="durasi" class="form-control form-control-lg" name="durasi" placeholder="Masukkan Durasi Layanan" aria-describedby="durasi" value="{{ Session::get('durasi') }}"/>
                                    </div>
                                    <div class="col-auto">
                                        <label for="durasi" class="col-form-label">Hari</label>
                                    </div>
                                </div>

                                <label for="satuan" class="fw-semibold form-label mx-3 mt-2 mb-0">Satuan</label>
                                <div class="row mx-3 g-3 align-items-center">
                                    <div class="col-3">
                                        <select class="form-select form-select-lg" name="satuan" aria-label="Default select example" value="{{ Session::get('satuan') }}">
                                            <option selected disabled>Pilih Satuan</option>
                                            <option value="kg">Kg</option>
                                            <option value="satuan">Satuan</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row mx-3 mb-2 g-3 mt-1 align-items-center">
                                    <div class="col-auto">
                                    <a class="btn btn-danger fw-semibold" style="font-size: 1.12rem;" href="{{ url('owner/layanan') }}" role="button">Kembali</a>
                                    </div>
                                    <div class="col-auto"><button type="submit" class="btn btn-laundry btn-block fw-semibold" style="font-size: 1.12rem;" data-toggle="tooltip" data-placement="top" title="Simpan Layanan">Simpan</button></div>
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
