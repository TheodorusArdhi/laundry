<!DOCTYPE html>
<html lang="en">
    <head>
        @include('template.head')
        <title>Pengumuman - Sinar Laundry</title>
    </head>
    <body class="sb-nav-fixed">
        @include('template.topNav')
        <div id="layoutSidenav">
            @include('template.sideNav')
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Pengumuman</h1>
                        <ol class="breadcrumb mb-2">
                            <li class="breadcrumb-item active">Tambah Pengumuman</li>
                        </ol>
                        @include('template.validate')
                        <div class="card shadow-lg border-0 rounded-lg fs-5">
                            <form method="POST" action="{{ url('pemilik/pengumuman/store') }}">
                                {{ csrf_field() }} 

                                <label for="judul" class="fw-semibold form-label mx-3 mt-2 mb-0">Judul</label>
                                <div class="row mx-3 g-3 align-items-center">
                                    <div class="col-3">
                                        <input type="text" id="judul" class="form-control form-control-lg" name="judul" placeholder="Judul Pengumuman" value="{{ Session::get('judul') }}" />
                                    </div>
                                </div>

                                <label for="deskripsi" class="fw-semibold form-label mx-3 mt-2 mb-0">Deskripsi</label>
                                <div class="row mx-3 g-3 align-items-center">
                                    <div class="col-3">
                                        <textarea  class="form-control form-control-lg" name="deskripsi" id="deskripsi" placeholder="Deskripsi Pengumuman" >{{ Session::get('deskripsi') }}</textarea>
                                    </div>
                                </div>

                                <label for="diskon" class="fw-semibold form-label mx-3 mt-2 mb-0">Diskon</label>
                                <div class="row mx-3 g-3 align-items-center">
                                    <div class="col-3">
                                        <input type="number" id="diskon" class="form-control form-control-lg" name="diskon" placeholder="Jumlah Diskon" aria-describedby="diskon" value="{{ Session::get('diskon') }}"/>
                                    </div>
                                    <div class="col-auto">
                                        <label for="diskon" class="col-form-label">%</label>
                                    </div>
                                </div>

                                <div class="row mx-3 mb-2 g-3 mt-1 align-items-center">
                                    <div class="col-auto">
                                    <a class="btn btn-danger fw-semibold" style="font-size: 1.12rem;" href="{{ url('pemilik/pengumuman') }}" role="button">Kembali</a>
                                    </div>
                                    <div class="col-auto"><button type="submit" class="btn btn-laundry btn-block fw-semibold" style="font-size: 1.12rem;" data-toggle="tooltip" data-placement="top" title="Simpan Pengumuman">Simpan</button></div>
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
