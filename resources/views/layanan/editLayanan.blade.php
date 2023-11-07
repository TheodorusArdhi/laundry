<!DOCTYPE html>
<html lang="en">
    <head>
        @include('template.head')
        <title>Layanan dan Harga - Sinar Laundry</title>
    </head>
    <body class="sb-nav-fixed">
        @include('template.topNav')
        <div id="layoutSidenav">
            @include('template.sideNav')
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Layanan dan Harga</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Edit Layanan dan Harga</li>
                        </ol>
                        @include('template.validate')
                        <form method="POST" action=" {{ url('updateLayanan', $temp->id_layanan) }}">
                            {{ csrf_field() }} 

                            <label for="nama" class="fw-semibold form-label mb-0">Nama</label>
                            <div class="row g-3 align-items-center">
                                <div class="col-3">
                                    <input type="text" id="nama" class="form-control" name="nama" value="{{ $temp->nama }}" />
                                </div>
                            </div>

                            <label for="harga" class="fw-semibold form-label mt-2 mb-0">Harga</label>
                            <div class="row g-3 align-items-center">
                                <div class="col-auto">
                                  <label for="harga" class="col-form-label">Rp.</label>
                                </div>
                                <div class="col-3">
                                    <input class="form-control" name="harga" id="harga" type="number" value="{{ $temp->harga }}" />
                                </div>
                            </div>

                            <label for="durasi" class="fw-semibold form-label mt-2 mb-0">Durasi</label>
                            <div class="row g-3 align-items-center">
                                <div class="col-3">
                                    <input type="number" id="durasi" class="form-control" name="durasi" aria-describedby="durasi" value="{{ $temp->durasi }}"/>
                                </div>
                                <div class="col-auto">
                                    <label for="durasi" class="col-form-label">Hari</label>
                                  </div>
                            </div>

                            <label for="satuan" class="fw-semibold form-label mt-2 mb-0">Satuan Layanan</label>
                            <div class="row g-3 align-items-center">
                                <div class="col-3">
                                    <select class="form-select" name="satuan" aria-label="Default select example" value="{{ $temp->satuan }}">
                                        <option value="{{ $temp->satuan }}">{{ $temp->satuan }}</option>
                                        <option value="kg">Kg</option>
                                        <option value="satuan">Satuan</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row g-3 mt-1 align-items-center">
                                <div class="col-auto">
                                <a class="btn btn-danger" href="/layanan" role="button">Kembali</a>
                                </div>
                                <div class="col-auto"><button type="submit" class="btn btn-primary btn-block" >Simpan</button></div>
                            </div>
                        </form>
                    </div>
                </main>
                @include('sweetalert::alert')
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scriptsAdmin.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
        <script src="js/datatables-simple-demo.js"></script>
    </body>
</html>
