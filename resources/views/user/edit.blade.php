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
                        <div class="card shadow-lg border-0 rounded-lg fs-5">
                            <form method="POST" action="{{ url('admin/user/'. $user->id_user.'/update') }}">
                                {{ csrf_field() }} 
                                <div class="row mx-3 g-3 align-items-center">
                                    <div class="col-6">
                                        <label for="nama" class="fw-semibold form-label mt-2 mb-0">Nama</label>
                                        <input type="text" id="nama" class="form-control form-control-lg" name="nama" placeholder="Nama Pengguna" disabled value="{{ $user->nama }}" />
                                    </div>
                                    <div class="col-6">
                                        <label for="no_telp" class="fw-semibold form-label mt-2 mb-0">Nomor Telepon</label>
                                        <input type="text" id="no_telp" class="form-control form-control-lg" name="no_telp" placeholder="Nomor Telepon Pengguna" disabled value="{{ str_pad(substr($user->no_telp, -4), strlen($user->no_telp), '*', STR_PAD_LEFT) }}" />
                                    </div>
                                </div>

                                <div class="row mx-3 g-3 align-items-center">
                                    <div class="col-6">
                                        <label for="email" class="fw-semibold form-label mt-2 mb-0">Email</label>
                                        <input type="email" id="email" class="form-control form-control-lg" placeholder="Email Pengguna" name="email" disabled value="{{ $user->email }}" />
                                    </div>
                                    @if($user->id_cabang != null)
                                        <div class="col-6">
                                            <label for="cabang" class="fw-semibold form-label mt-2 mb-0">Cabang</label>
                                            <select class="form-select form-select-lg" name="cabang" aria-label="Default select example" value="{{ Session::get('cabang') }}">
                                                <option value="{{ $user->id_cabang }}">{{ $user->cabang->nama }}</option>
                                                @foreach ($cabang as $item)
                                                    <option value="{{ $item->id_cabang }}">{{ $item->nama }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    @endif
                                </div>

                                {{--  <label for="password" class="fw-semibold form-label mx-3 mt-2 mb-0">Password</label>
                                <div class="row mx-3 g-3 align-items-center">
                                    <div class=" form-check form-switch">
                                        <input class="form-check-input" value="on" name="password" type="checkbox" role="switch" id="password">
                                        <label class="form-check-label" for="password">Atur Ulang Password</label>
                                    </div>
                                </div>  --}}

                                <input type="hidden" name="level" value="{{ $user->level }}">
                                <div class="row mx-3 mb-2 g-3 mt-1 align-items-center">
                                    @if (Auth::user()->level == "pemilik")
                                    <div class="col-auto">
                                        <a class="btn btn-danger fw-semibold" style="font-size: 1.12rem;" href="{{ url('pemilik/user') }}" role="button">Kembali</a>
                                    </div>
                                    @if ($user->level == "admin")
                                        <div class="col-auto"><button type="submit" class="btn btn-laundry btn-block fw-semibold" style="font-size: 1.12rem;" data-toggle="tooltip" data-placement="top" title="Simpan Pengguna">Simpan</button></div>
                                    @endif
                                    @else
                                    <div class="col-auto">
                                        <a class="btn btn-danger fw-semibold" style="font-size: 1.12rem;" href="{{ url('admin/user') }}" role="button">Kembali</a>
                                    </div>
                                    @endif
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
