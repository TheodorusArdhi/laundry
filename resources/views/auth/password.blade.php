<!DOCTYPE html>
<html lang="en">
    <head>
        @include('template.head')
        <title>Ubah Password - SB Admin</title>
    </head>
    <body class="bg-primary">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Ubah Password</h3></div>
                                    <div class="card-body">
                                        @if(session('msg'))
                                        <p class="alert alert-danger">{{ session('msg') }}</p>
                                        @endif
                                        @if(session('success'))
                                        <p class="alert alert-success">{{ session('success') }}</p>
                                        @endif
                                        @if($errors->any())
                                        @foreach($errors->all() as $err)
                                        <p class="alert alert-danger">{{ $err }}</p>
                                        @endforeach
                                        @endif
                                        <form method="POST" action="{{ url('password/update') }}">
                                            {{ csrf_field() }}
                                            <div class="form-floating mb-3">
                                                <input class="form-control"  name="oldPassword" type="password" placeholder="Password Lama" />
                                                <label for="password">Password Lama</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input class="form-control"  name="newPassword" type="password" placeholder="Password Baru" />
                                                <label for="password">Password Baru</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input class="form-control"  name="newPasswordConfirm" type="password" placeholder="Konfirmasi Password Baru" />
                                                <label for="password">Konfirmasi Password Baru</label>
                                            </div>

                                            <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                                <a class="btn btn-danger fw-semibold" style="font-size: 1.12rem;" href="{{ url('profil') }}">Kembali</a>
                                                <button type="submit" class="btn btn-primary fw-semibold" style="font-size: 1.12rem;" >Ubah Password</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
                @include('sweetalert::alert')
            </div>
            <div id="layoutAuthentication_footer">
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Your Website 2023</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        @include('template.foot')
    </body>
</html>
