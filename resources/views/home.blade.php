<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Sinar Laundry</title>
        <link rel="icon" type="image/x-icon" href="assets/washing_machine.ico" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />
    </head>
    <body id="page-top">
        <!-- Navigation-->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
            <div class="container px-4">
                <a class="navbar-brand" href="#page-top">Sinar Laundry</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item"><a class="nav-link" href="#layanan">Layanan dan Harga</a></li>
                        <li class="nav-item"><a class="nav-link" href="#pengumuman">Pengumuman</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- Header-->
        <header class="bg-primary bg-gradient text-white">
            <div class="container px-4 text-center">
                <h1 class="fw-bolder">Selamat Datang ke Sinar Laundry</h1>
                <p class="lead">Bersih, Rapi, Wangi!</p>
                <a class="btn btn-lg btn-light" href="/login">Login</a>
            </div>
        </header>
        <!-- layanan section-->
        <section id="layanan">
            <div class="container px-4">
                <div class="row gx-4 justify-content-center">
                    <div class="col-lg-8">
                        <h2>Layanan dan Harga</h2>
                        <div class="row">
                            @foreach ($layanan as $item)
                            <div class="col-sm-4 mb-2 mt-2 mb-sm">
                                <div class="card border-primary">
                                  <h5 class="card-header">{{ $item->nama }}</h5>
                                <div class="card-body ">
                                  <p class="card-text fs-5 fw-medium">Harga = Rp.{{ $item->harga }} / {{ $item->satuan }}</p>
                                  <p class="card-text fs-5 fw-medium">Durasi = {{ $item->durasi }} Hari</p>
                                </div>
                              </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- pengumuman section-->
        <section class="bg-light" id="pengumuman">
            <div class="container px-4">
                <div class="row gx-4 justify-content-center">
                    <div class="col-lg-8">
                        <h2>Pengumuman</h2>
                        <div class="row">
                            @foreach ($pengumuman as $item)
                            <div class="col-sm-4 mb-2 mt-2 mb-sm">
                                <div class="card border-primary">
                                  <h5 class="card-header">{{ $item->judul }} {{ $item->diskon }}%</h5>
                                <div class="card-body">
                                  <p class="card-text fs-6">{{ $item->deskripsi }}</p>
                                </div>
                              </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Footer-->
        <footer class="py-5 bg-dark">
            <div class="container px-4">
                <div class="row">
                    <div class="col">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d63284.27881741987!2d110.7782726!3d-7.5457884!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7a17e99009a0b5%3A0xb72a272f3aec20d8!2sSinar%20Laundry!5e0!3m2!1sen!2sid!4v1696671228792!5m2!1sen!2sid" width="500" height="300" style="border:0;" allowfullscreen="true" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                    <div class="col">
                        <p class="fw-medium text-start text-white fs-4" >Lokasi</p>
                        <p class="fw-medium text-start text-white fs-5" >Jl. Batam Raya Jl. Grogolan No.9 Ketelan Kec, Kec. Banjarsari, Kota Surakarta, Jawa Tengah 57132</p>
                    </div>
                </div>
            </div>
        </footer>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
    </body>
</html>
