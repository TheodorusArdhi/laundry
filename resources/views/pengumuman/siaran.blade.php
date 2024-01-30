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
                            <li class="breadcrumb-item active">Siaran Pengumuman</li>
                        </ol>
                        @include('template.validate')
                        <div class="card shadow-lg border-0 rounded-lg fs-5">
                            <form method="POST" action="{{ url('pemilik/pengumuman/siaran') }}">
                                {{ csrf_field() }} 
                                <label for="pesan" class="fw-semibold form-label mx-4 mt-2 mb-2">Pesan</label>
                                <p class="ms-4 mb-0">Halo {nama}!</p>
                                <div class="row mx-3 g-3 align-items-center">
                                    <div class="col-12">
                                        <textarea class="form-control form-control-lg" placeholder="Tulis pesan anda disini" id="pesan" name="pesan" style="height: 200px"></textarea>
                                    </div>
                                </div>

                                <div class="row mx-3 mb-2 g-3 mt-1 align-items-center">
                                    <div class="col-auto">
                                        <a class="btn btn-danger fw-semibold" style="font-size: 1.12rem;" href="{{ url('pemilik/pengumuman') }}" role="button">Kembali</a>
                                    </div>
                                    <div class="col-auto"><button type="submit" class="btn btn-laundry btn-block fw-semibold" style="font-size: 1.12rem;" data-toggle="tooltip" data-placement="top" title="Siarkan Pengumuman">Siarkan</button></div>
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
