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
                            <form method="POST" action="{{ url('pemilik/layanan/store') }}">
                                {{ csrf_field() }} 
                                <div class="row mx-3 g-3 align-items-center">
                                    <div class="col-6">
                                        <label for="nama" class="fw-semibold form-label mt-2 mb-0">Nama</label>
                                        <input type="text" id="nama" class="form-control form-control-lg" placeholder="Nama Layanan" name="nama" value="{{ Session::get('nama') }}" />
                                    </div>
                                    <div class="col-5">
                                        <label for="durasi" class="fw-semibold form-label mt-2 mb-0">Durasi</label>
                                        <input type="number" id="durasi" class="form-control form-control-lg" name="durasi" placeholder="Durasi Layanan" aria-describedby="durasi" value="{{ Session::get('durasi') }}"/>
                                    </div>
                                    <div class="col-auto align-self-end mb-1">
                                        <label for="durasi" class="col-form-label">Hari</label>
                                    </div>
                                </div>

                                <div class="row mx-3 g-3 align-items-center">
                                    <div class="col-6">
                                        <label for="harga" class="fw-semibold form-label mt-2 mb-0">Harga</label>
                                        <input class="form-control form-control-lg" name="harga" id="harga" type="number" placeholder="Harga Layanan" value="{{ Session::get('harga') }}" />
                                    </div>
                                    <div class="col-6">
                                        <label for="satuan" class="fw-semibold form-label mt-2 mb-0">Satuan</label>
                                        <select class="form-select form-select-lg" name="satuan" aria-label="Default select example" value="{{ Session::get('satuan') }}">
                                            <option selected disabled>Pilih Satuan</option>
                                            <option value="kg">Kg</option>
                                            <option value="satuan">Satuan</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row mx-3 mb-2 g-3 mt-1 align-items-center">
                                    <div class="col-auto">
                                    <a class="btn btn-danger fw-semibold" style="font-size: 1.12rem;" href="{{ url('pemilik/layanan') }}" role="button">Kembali</a>
                                    </div>
                                    <div class="col-auto"><button type="submit" class="btn btn-laundry btn-block fw-semibold" style="font-size: 1.12rem;" data-toggle="tooltip" data-placement="top" title="Simpan Layanan">Simpan</button></div>
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
