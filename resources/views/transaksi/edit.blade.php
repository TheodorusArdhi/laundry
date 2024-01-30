<!DOCTYPE html>
<html lang="en">
    <head>
        @include('template.head')
        <title>Transaksi - Sinar Laundry</title>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

    </head>
    <body class="sb-nav-fixed">
        @include('template.topNav')
        <div id="layoutSidenav">
            @include('template.sideNav')
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Transaksi</h1>
                        <div class="d-flex justify-content-between">
                            <ol class="breadcrumb align-self-center">
                                <li class="breadcrumb-item active">Edit Transaksi</li>
                            </ol>
                            <div class="mb-2 mt-0 d-grid gap-2 d-md-flex justify-content-md-end">
                                @if (Auth::user()->level == "admin" || Auth::user()->level == "pemilik")
                                    {{--  @if ($transaksi->id_status_pembayaran == "2")
                                        <a class="btn btn-success fw-semibold" href={{ url('admin/transaksi/'. $transaksi->id_transaksi.'/lunas') }} role="button" data-toggle="tooltip" data-placement="top" title="Lunaskan Transaksi">Lunas <i class="fa-solid fa-dollar-sign"></i></a>  --}}
                                    @if ($transaksi->id_status_pembayaran == "1" && ($transaksi->id_status_transaksi == "4" || $transaksi->id_status_transaksi == "5" || $transaksi->id_status_transaksi == "6"))
                                        <a class="btn btn-info fw-semibold" href={{ url('admin/transaksi/'. $transaksi->id_transaksi.'/ambil') }} role="button" data-toggle="tooltip" data-placement="top" title="Ambil Laundry">Ambil <i class="fa-solid fa-dolly"></i></a>
                                    @elseif($transaksi -> id_status_transaksi == "3")
                                        <a class="btn btn-danger fw-semibold" href={{ url('admin/transaksi/'. $transaksi->id_transaksi.'/batal') }} role="button" data-toggle="tooltip" data-placement="top" title="Batalkan Laundry">Batal <i class="fa-solid fa-xmark"></i></i></a>
                                    @endif
                                @endif
                                <a class="btn btn-laundry fw-semibold" href={{ url('transaksi/'.$transaksi->id_transaksi.'/invoice') }} role="button" data-toggle="tooltip" data-placement="top" title="Unduh Nota">Nota <i class="fa-solid fa-download"></i></a>
                            </div>
                        </div>
                        
                        @include('template.validate')
                        <div class="card shadow-lg border-0 rounded-lg mb-4 fs-5">
                            @php
                                $poin = App\Models\Poin::where('id_user', $transaksi->id_user)->where('status', 'aktif')->sum('jumlah');
                                $poinTransaksi = $transaksi->poin_keluar;
                                $level = App\Models\User::where('id_user', $transaksi->id_user)->first()->level;
                                $selesai = date('d/m/Y', strtotime($transaksi->tgl_selesai));
                            @endphp
                            
                            @if ((Auth::user()->level == "admin" || Auth::user()->level == "pemilik") && $transaksi -> id_status_transaksi != "7")
                                <div class="d-flex justify-content-between mx-4 mt-2 ">
                                    <p class="text-start"><span class="fw-semibold">Admin</span> : {{ $transaksi->admin->nama }}</p>
                                    <p class="text-end"><span class="fw-semibold">Tanggal Masuk</span> : {{ $transaksi->tgl_masuk -> translatedFormat('l, d F Y')}}</p>
                                </div>
                                <div class="d-flex justify-content-between mx-4 mt-0">
                                    <p class="text-start "><span class="fw-semibold">Nomor Transaksi</span> : {{ $transaksi->no_transaksi }}</p>
                                    @if (Auth::user()->level != "pemilik")
                                    <p class="text-end"><span class="fw-semibold">Cabang</span> : {{ $transaksi->cabang->nama}}</p>
                                    @endif                                
                                </div>

                                <form method="POST" action="{{ url('admin/transaksi/'. $transaksi->id_transaksi.'/edit/poin') }}">
                                    {{ csrf_field() }} 
                                    <input type="hidden" name="id_transaksi" value="{{ $transaksi->id_transaksi }}">
                                    <div class="row mx-3 g-3 align-items-center">
                                        <div class="col-6">
                                            <label for="nama" class="fw-semibold form-label mt-2 mb-0">Nama</label>
                                            <select class="form-select form-select-lg select2" name="nama" id="nama" aria-label="Default select example" value="{{ Session::get('nama') }}" {{ (($transaksi->id_status_transaksi == "7") ? 'disabled' : '') }}>
                                                <option value="{{ $transaksi->id_user }}">{{ $transaksi->user->nama }}
                                                    <span id="nama" class="form-text">
                                                        @if ($level == "anggota" && $poin != null)
                                                        Poin: {{ $poin }}
                                                        @elseif ($level == "anggota")
                                                        Poin: 0
                                                        @else
            
                                                        @endif
                                                    </span>
                                                </option>
                                                @foreach ($pengguna as $item)
                                                <option value="{{ $item->id_user }}">{{ $item->nama }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        @if (Auth::user()->level == "pemilik")
                                            <div class="col-5">
                                                <label for="cabang" class="fw-semibold form-label mt-2 mb-0">Cabang</label>
                                                <select class="form-select form-select-lg " name="cabang" aria-label="Default select example" value="{{ Session::get('cabang') }}">
                                                    <option value="{{ $transaksi->id_cabang }}">{{ $transaksi->cabang->nama }}</option>
                                                    @foreach ($cabang as $item)
                                                    <option value="{{ $item->id_cabang }}">{{ $item->nama }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        @endif

                                        <div class="col-auto align-self-end mb-1">
                                            <div class="col-auto "><button type="submit" class="btn btn-secondary fw-semibold btn-block" role="button" data-toggle="tooltip" data-placement="top" title="Cek Pengguna">Cek</button></div>
                                        </div> 
                                    </div>
                                </form>

                                <form method="POST" action="{{ url('admin/transaksi/'. $transaksi->id_transaksi.'/edit/tanggal') }}">
                                    {{ csrf_field() }} 
                                    <div class="row mx-3 g-3 align-items-center">
                                        <div class="col-6">
                                            <label for="tanggal" class="fw-semibold form-label mt-2 mb-0">Tanggal Selesai</label>
                                            <div class="input-group date">
                                                <input type="text" class="form-control fs-5" name="tanggal" value="{{ $selesai }}"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                                            </div>
                                        </div>
                                        <div class="col-auto align-self-end mb-1">
                                            <div class="col-auto"><button type="submit" class="btn btn-secondary fw-semibold btn-block" role="button" data-toggle="tooltip" data-placement="top" title="Ubah Tanggal Selesai">Ubah</button></div>
                                        </div> 
                                    </div>
                                </form>
                                @include('template.datePicker')

                                <form method="POST" action="{{ url('admin/transaksi/detail/'. $transaksi->id_transaksi.'/edit/store') }} ">
                                    {{ csrf_field() }}                                   
                                    <div class="row mx-3 g-3 align-items-center" style="margin-top: 0.05rem !important;">
                                        <div class="col-6 ">
                                            <label for="layanan" class="fw-semibold form-label mt-2 mb-0">Layanan</label>
                                            <select class="form-select form-select-lg" name="layanan" aria-label="Default select example" value="{{ Session::get('layanan') }}">
                                                <option selected disabled>Pilih Layanan</option>
                                                @foreach ($layanan as $item)
                                                <option value="{{ $item->id_layanan }}">{{ $item->nama }}</option>
                                                @endforeach
                                            </select>
                                        </div>
    
                                        <div class="col-5">
                                            <label for="jumlah" class="fw-semibold form-label mt-2 mb-0">Jumlah</label>
                                            <input type="number" id="jumlah" class="form-control form-control-lg" name="jumlah" placeholder="Jumlah Layanan" value="{{ Session::get('jumlah') }}"/>
                                        </div>
    
                                        <div class="col-auto align-self-end mb-1">
                                            <button type="submit" class="btn btn-secondary fw-semibold btn-block" role="button" data-toggle="tooltip" data-placement="top" title="Tambah Layanan">Tambah</button>
                                        </div>
                                    </div>
                                </form>
                            @else
                                <div class="d-flex justify-content-between mx-4 mt-2 ">
                                    <p class="text-start"><span class="fw-semibold">Admin</span> : {{ $transaksi->admin->nama }}</p>
                                    <p class="text-end"><span class="fw-semibold">Tanggal Masuk</span> : {{ $transaksi->tgl_masuk -> translatedFormat('l, d F Y')}}</p>
                                </div>
                                <div class="d-flex justify-content-between mx-4 mt-0">
                                    <p class="text-start"><span class="fw-semibold">Nomor Transaksi</span> : {{ $transaksi->no_transaksi }}</p>
                                    <p class="text-end"><span class="fw-semibold">Tanggal Selesai</span> : {{ $transaksi->tgl_selesai -> translatedFormat('l, d F Y')}}</p>
                                </div>
                                @if ($transaksi -> tgl_ambil == null)
                                    <div class="d-flex justify-content-between mx-4 mt-0">
                                        <p class="text-start"><span class="fw-semibold">Nama</span> : {{ $transaksi->user->nama}}</p>
                                        <p class="text-end"><span class="fw-semibold">Cabang</span> : {{ $transaksi->cabang->nama}}</p>
                                    </div>
                                @else
                                    <div class="d-flex justify-content-between mx-4 mt-0">
                                        <p class="text-start"><span class="fw-semibold">Nama</span> : {{ $transaksi->user->nama}}</p>
                                        <p class="text-end"><span class="fw-semibold">Tanggal Ambil</span> : {{ $transaksi->tgl_ambil -> translatedFormat('l, d F Y')}}</p>
                                    </div>
                                    <p class="text-start mx-4 mt-0"><span class="fw-semibold">Cabang</span> : {{ $transaksi->cabang->nama}}</p>
                                @endif
                            @endif

                            @include('sweetalert::alert')
                            @if ((Auth::user()->level == "admin" || Auth::user()->level == "pemilik") && ($transaksi->id_status_transaksi != "7"))
                                <div class="card mb-1 mt-2 mx-4">                            
                                    <div class="card-header">
                                        <i class="fas fa-table me-1"></i>
                                        <a> <b class="fw-semibold">Detil Layanan</b></a>
                                    </div>                              
                                    <div class="card-body table-responsive ">
                                        @include('transaksi.detilAksiEdit', $detail)
                                    </div>
                                </div>
                            @else
                                <div class="card mb-1 mt-2 mx-4">                            
                                    <div class="card-header">
                                        <i class="fas fa-table me-1"></i>
                                        <a> <b class="fw-semibold">Detil Layanan</b></a>
                                    </div>                              
                                    <div class="card-body table-responsive ">
                                        @include('transaksi.detil', $detail)
                                    </div>
                                </div>
                            @endif

                            @if ((Auth::user()->level == "admin" || Auth::user()->level == "pemilik") && $transaksi -> id_status_transaksi != "7")
                                <form method="POST" action="{{  url('admin/transaksi/'. $transaksi->id_transaksi.'/edit/diskon')  }}">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="id_transaksi" value="{{ $transaksi->id_transaksi }}">
                                    <div class="row mx-3 g-3 align-items-center" style="margin-top: 0.05rem !important;">
                                        <div class="col-6">
                                            <label for="total_harga" class="fw-semibold form-label mt-2 mb-0">Total Harga</label>
                                            <input type="text" id="total_harga_show" disabled class="form-control form-control-lg" name="total_harga_show"  value="Rp{{ number_format($transaksi->total_harga, 0, ".", ".")}}"/>
                                        </div>

                                        <div class="col-5">
                                            <label for="diskon" class="fw-semibold form-label mt-2 mb-0">Diskon</label>
                                            <select class="form-select form-select-lg " name="diskon" aria-label="Default select example" aria-describedby="diskon" value="{{$transaksi->id_pengumuman}} " {{ (($transaksi->id_status_transaksi == "7") ? 'disabled' : '') }}>
                                                @if ($transaksi->id_pengumuman == null )
                                                    <option selected value="" >Pilih Diskon</option>
                                                    @foreach ($pengumuman as $item)     
                                                    <option value="{{ $item->id_pengumuman }}" > {{ $item->judul }} {{ $item->diskon }}% </option>
                                                    @endforeach                              
                                                @else
                                                    <option value="{{ $transaksi->id_pengumuman }}" > {{ $transaksi->pengumuman->judul }} {{ $transaksi->pengumuman->diskon }}% </option>
                                                    @foreach ($pengumuman as $item)     
                                                    <option value="{{ $item->id_pengumuman }}" > {{ $item->judul }} {{ $item->diskon }}% </option>
                                                    @endforeach  
                                                    <option value="" >Hapus Diskon</option>
                                                @endif
                                            </select>
                                        </div>

                                        <div class="col-auto align-self-end mb-1">
                                            <div class="col-auto"><button type="submit" class="btn btn-secondary fw-semibold btn-block" role="button" data-toggle="tooltip" data-placement="top" title="Cek Diskon">Cek</button></div>
                                        </div>    
                                    </div>     
                                </form>
                                
                                <form method="POST" action="{{ url('admin/transaksi/'. $transaksi->id_transaksi.'/update') }}">
                                    {{ csrf_field() }} 
                                    <input type="hidden" name="user" value="{{ $transaksi->id_user }}">
                                    
                                    <div class="row mx-3 g-3 align-items-center">
                                        <div class="col-6">
                                            <label for="total_tagihan" class="fw-semibold form-label mt-2 mb-0">Total Tagihan</label>
                                            <input type="hidden" id="total_tagihan_ori"  class="form-control" name="total_tagihan_ori" value="{{ $transaksi->total_tagihan + $transaksi->poin_keluar }}"/>                                           
                                            <input type="text" id="totTag" disabled class="form-control form-control-lg fw-semibold" name="totTag" value="Rp{{ number_format($transaksi->total_tagihan, 0, ".", ".")}}"/> 
                                            <input type="hidden" id="total_tagihan"  class="form-control" name="total_tagihan" value="{{ $transaksi->total_tagihan }}"/>                                                                                       
                                        </div>

                                        @if ($poin >= 1000 || $transaksi->poin_keluar > 0)
                                            <div class="col-6">
                                                <label for="poin" class="fw-semibold form-label mt-2 mb-0">Poin</label>
                                                <select class="form-select form-select-lg" name="poin" aria-label="Default select example" value="{{ Session::get('poin') }}" {{  (($transaksi->id_status_transaksi == "7")  ? 'disabled' : '') }}>
                                                    @if($transaksi->poin_keluar > 0)
                                                        <option value="{{ $transaksi->poin_keluar }}" > {{ $transaksi->poin_keluar }} (Rp{{ number_format($transaksi->poin_keluar, 0, ".", ".")}})</option>
                                                        <option value="0">Hapus Poin</option>
                                                        @for ($i = 1000; $i <= $poin + $poinTransaksi; $i = $i+1000)
                                                            <option value="{{ $i }}" > {{ $i }} (Rp{{ number_format($i, 0, ".", ".")}})</option>
                                                        @endfor
                                                    @else
                                                        <option selected value="0">Gunakan Poin</option>
                                                        @for ($i = 1000; $i <= $poin; $i = $i+1000)
                                                            <option value="{{ $i }}" > {{ $i }} (Rp{{ number_format($i, 0, ".", ".")}})</option>
                                                        @endfor
                                                    @endif
                                                </select>
                                            </div>
                                        @else
                                            <input type="hidden" id="poin" class="form-control" name="poin"  value="0"/>
                                        @endif
                                    </div>
                                    <input type="hidden" id="total_harga" class="form-control" name="total_harga"  value="{{ $transaksi->total_harga }}"/>

                                    <div class="row mx-3 g-3 align-items-center">
                                        <div class="col-6">
                                            <label for="diterima" class="fw-semibold form-label mt-2 mb-0">Diterima</label>
                                            <input type="number" id="diterima" class="form-control form-control-lg" name="diterima" value="{{ $transaksi->diterima }}"/>
                                            {{--  <input type="hidden" id="diterima" class="form-control" name="diterima" value="{{ $transaksi->diterima }}"/>  --}}
                                        </div>
                                        <div class="col-6">
                                            <label for="kembali" class="fw-semibold form-label mt-2 mb-0">Kembali</label>
                                            <input type="text" id="kembali" disabled class="form-control form-control-lg fw-semibold" name="kembali" value=""/>
                                        </div>
                                    </div>

                                    <div class="row mx-3 mb-2 g-3 mt-1 align-items-center">
                                        <div class="col-auto"><a class="btn btn-danger fw-semibold" style="font-size: 1.12rem;" href="{{ url('admin/transaksi') }}" role="button">Kembali</a></div>
                                        <div class="col-auto"><button type="submit" class="btn btn-laundry btn-block fw-semibold" style="font-size: 1.12rem;" data-toggle="tooltip" data-placement="top" title="Simpan Transaksi" >Simpan</button></div>
                                    </div>
                                </form>
                            @else
                                <div class="row justify-content-start mx-2 ">
                                    <div class="col-2">
                                        <p class="text-start"><span class="fw-semibold">Total Harga</span></p>
                                    </div>
                                    <div class="col-2">
                                        <p class="text-start">: Rp{{ number_format($transaksi->total_harga, 0, ".", ".")}}</p>
                                    </div>
                                </div>
                                @if ($transaksi->id_pengumuman != null)
                                    <div class="row justify-content-start mx-2 ">
                                        <div class="col-2">
                                            <p class="text-start"><span class="fw-semibold">Diskon</span></p>
                                        </div>
                                        <div class="col-2">
                                            <p class="text-start">: {{ $transaksi->pengumuman->judul }} {{ $transaksi->pengumuman->diskon }}%</p>
                                        </div>
                                    </div>
                                @endif
                                @if ($transaksi->poin_keluar != null)
                                    <div class="row justify-content-start mx-2 ">
                                        <div class="col-2">
                                            <p class="text-start"><span class="fw-semibold">Poin</span></p>
                                        </div>
                                        <div class="col-2">
                                            <p class="text-start">: {{ $transaksi->poin_keluar }} (Rp{{ number_format($transaksi->poin_keluar, 0, ".", ".")}})</p>
                                        </div>
                                    </div>
                                @endif
                                <div class="row justify-content-start mx-2 fs-3">
                                    <div class="col-2">
                                        <p class="text-start"><span class="fw-semibold">Total Tagihan</span></p>
                                    </div>
                                    <div class="col-2">
                                        <p class="text-start fw-semibold">: Rp{{ number_format($transaksi->total_tagihan, 0, ".", ".")}}</p>
                                    </div>
                                </div>
                                <div class="row justify-content-start mx-2">
                                    <div class="col-2">
                                        <p class="text-start"><span class="fw-semibold">Diterima</span></p>
                                    </div>
                                    <div class="col-2">
                                        <p class="text-start">: Rp{{ number_format($transaksi->diterima, 0, ".", ".")}}</p>
                                    </div>
                                </div>
                                <div class="row justify-content-start mx-2 fs-3">
                                    <div class="col-2">
                                        <p class="text-start"><span class="fw-semibold">Kembali</span></p>
                                    </div>
                                    <div class="col-2">
                                        <p class="text-start fw-semibold">: Rp{{ number_format($transaksi->diterima - $transaksi->total_tagihan, 0, ".", ".")}}</p>
                                    </div>
                                </div>
                                <div class="row mx-3 mb-2 g-3 align-items-center">
                                    <div class="col-auto">
                                        @if (Auth::user()->level == "pemilik" || Auth::user()->level == "admin")
                                        <a class="btn btn-danger fw-semibold" style="font-size: 1.12rem;" href="{{ url('admin/transaksi') }}" role="button">Kembali</a>
                                        @elseif (Auth::user()->level == "pelanggan" || Auth::user()->level == "anggota")
                                        <a class="btn btn-danger fw-semibold" style="font-size: 1.12rem;" href="{{ url('user/transaksi') }}" role="button">Kembali</a>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </main>
                @include('template.footer')
                {{--  <input type="hidden" id="tagOri" class="form-control" name="tagOri" value="{{ $transaksi->poin_keluar + $transaksi->total_tagihan }}"/>  --}}
            </div>
        </div>
        @include('sweetalert::alert')
        @include('template.foot')
        <script>
            $(document).ready(function() {
                function currencyFormat(x) {
                    return ('Rp'+x).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                }

                let poin = $('[name="poin"]');
                let total_harga = $('[name="total_harga"]');
                let total_tagihan = $('[name="total_tagihan"]');
                let total_tagihan_ori = $('[name="total_tagihan_ori"]');
                let totTag = $('[name="totTag"]');
                let diterima = $('[name="diterima"]');
                let kembali = $('[name="kembali"]');
                let tagOri = $('[name="tagOri"]');
                total_tagihan_ori = total_tagihan_ori.val();

                poin.on('input', function() {
                    tagihanValue = total_tagihan_ori - poin.val();
                    if (tagihanValue < 0) {
                        total_tagihan.val(0)
                        totTag.val(currencyFormat(0))
                    } else {
                        total_tagihan.val(tagihanValue);   
                        totTag.val(currencyFormat(tagihanValue));   
                    }

                    kembaliValue = diterima.val() - tagihanValue;
                    if (kembaliValue <= 0) {
                        kembali.val(currencyFormat(0))
                    } else {
                        kembali.val(currencyFormat(kembaliValue));   
                    }
                });
                
                diterima.on('input', function() {
                    kembaliValue = diterima.val() - total_tagihan.val();
                    if (kembaliValue <= 0) {
                        kembali.val(currencyFormat(0))
                    } else {
                        kembali.val(currencyFormat(kembaliValue));   
                    }
                });

                kembaliValue = diterima.val() - total_tagihan.val();
                if (kembaliValue <= 0) {
                    kembali.val(currencyFormat(0))
                } else {
                    kembali.val(currencyFormat(kembaliValue));   
                }
            });
        </script>
    </body>
</html>