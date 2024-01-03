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
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Edit Pengumuman</li>
                        </ol>
                        @include('template.validate')
                        <div class="card shadow-lg border-0 rounded-lg ">
                            <form method="POST" action=" {{ url('owner/pengumuman/'. $pengumuman->id_pengumuman.'/update') }}">
                                {{ csrf_field() }} 

                                <label for="judul" class="fw-semibold form-label mx-3 mt-2 mb-0">Judul</label>
                                <div class="row mx-3 g-3 align-items-center">
                                    <div class="col-3">
                                        <input type="text" id="judul" class="form-control" name="judul" value="{{ $pengumuman->judul }}" />
                                    </div>
                                </div>

                                <label for="deskripsi" class="fw-semibold form-label mx-3 mt-2 mb-0">Deskripsi</label>
                                <div class="row mx-3 g-3 align-items-center">
                                    <div class="col-3">
                                        <textarea  class="form-control" name="deskripsi" id="deskripsi" >{{ $pengumuman->deskripsi }}</textarea>
                                    </div>
                                </div>

                                <label for="diskon" class="fw-semibold form-label mx-3 mt-2 mb-0">Diskon</label>
                                <div class="row mx-3 g-3 align-items-center">
                                    <div class="col-3">
                                        <input type="number" id="diskon" class="form-control" name="diskon" aria-describedby="diskon" value="{{ $pengumuman->diskon }}"/>
                                    </div>
                                    <div class="col-auto">
                                        <label for="diskon" class="col-form-label">%</label>
                                    </div>
                                </div>

                                <label for="status" class="fw-semibold form-label mx-3 mt-2 mb-0">Status</label>
                                    <div class="row mx-3 g-3 align-items-center">
                                        <div class="col-3">
                                            <select class="form-select" name="status" aria-label="Default select example" value="{{ Session::get('status') }}">
                                                <option value="{{ $pengumuman->status }}">{{ $pengumuman->status }}</option>
                                                <option value="aktif">Aktif</option>
                                                <option value="tidak aktif">Tidak Aktif</option>
                                            </select>
                                        </div>
                                    </div>

                                <div class="row mx-3 g-3 mb-1 mt-1 align-items-center">
                                    <div class="col-auto">
                                    <a class="btn btn-danger" href="{{ url('owner/pengumuman') }}" role="button">Kembali</a>
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
