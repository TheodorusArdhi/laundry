<!DOCTYPE html>
<html lang="en">
    <head>
        @include('template.head')
        <title>Transaksi - Sinar Laundry</title>
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
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

                        <ol class="breadcrumb mb-2">
                            <li class="breadcrumb-item active">Edit Transaksi</li>
                        </ol>
                        <div class="mb-2 d-grid gap-2 d-md-flex justify-content-md-end">
                            <a class="btn btn-warning justify-content-md-end" href={{ url('transaksi/'.$transaksi->id_transaksi.'/invoice') }} role="button">Unduh Nota</a>
                        </div>
                        @include('template.validate')
                        <div class="card shadow-lg border-0 rounded-lg mb-4">
                            <form method="POST" action="{{ url('admin/transaksi/detail/'. $transaksi->id_transaksi.'/edit/store') }} ">
                                {{ csrf_field() }}
                                <label for="namaAdmin" class="fw-semibold form-label mx-3 mt-2 mb-0">Admin</label>
                                <div class="row mx-3 g-3 align-items-center">
                                    <div class="col-3">
                                        <input type="text" id="namaAdmin" disabled class="form-control " name="namaAdmin"  value="{{ $transaksi->admin->nama }}"/>
                                    </div>
                                </div>
    
                                <label for="no_transaksi" class="fw-semibold form-label mx-3 mt-2 mb-0">Nomor Transaksi</label>
                                <div class="row mx-3 g-3 align-items-center">
                                    <div class="col-3">
                                        <input type="text" id="no_transaksi" disabled class="form-control" name="no_transaksi"  value="{{ $transaksi->no_transaksi }}"/>
                                    </div>
                                </div>
    
                                <label for="tanggal" class="fw-semibold form-label mx-3 mt-2 mb-0">Tanggal</label>
                                <div class="row mx-3 g-3 align-items-center">
                                    <div class="col-3">
                                        <input type="text" id="tanggal" disabled class="form-control" name="tanggal"  value="{{ $transaksi->tgl_masuk -> translatedFormat('l, d F Y')}}"/>
                                    </div>
                                </div>

                                @if ((Auth::user()->level == "admin") && ($transaksi->id_status_transaksi != "7"))                                    
                                    <div class="row g-3 align-items-center" >
                                        <div class="col-3 ">
                                        <label for="layanan" class="fw-semibold form-label mx-3 mt-2 mb-0">Layanan</label>
                                            <div class="col mx-3">
                                                <select class="form-control " name="layanan" aria-label="Default select example" value="{{ Session::get('layanan') }}">
                                                    <option selected disabled>Pilih Layanan</option>
                                                    @foreach ($layanan as $item)
                                                    <option value="{{ $item->id_layanan }}">{{ $item->nama }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-3">
                                        <label for="jumlah" class="fw-semibold form-label  mt-2 mb-0">Jumlah</label>
                                            <div class="col mx-3">
                                                <input type="number" id="jumlah" class="form-control" name="jumlah" value="{{ Session::get('jumlah') }}"/>
                                            </div>
                                        </div>

                                        <div class="col-3">
                                            <div class="col-auto"><button type="submit" class="btn btn-primary btn-block" >Tambah</button></div>
                                        </div>
                                    </div>
                                @endif
                            </form>
                            @include('sweetalert::alert')

                            <div class="card mb-2 mt-3 mx-3">                            
                                <div class="card-header">
                                    <i class="fas fa-table me-1"></i>
                                    <a> <b class="fw-semibold"></b></a>
                                </div>                            
                                <div class="card-body">
                                    <table id="datatablesSimple">
                                        <thead >
                                            <tr>
                                                <th>No</th>
                                                <th>Layanan</th>
                                                <th>Harga</th>
                                                <th>Jumlah</th>
                                                <th>Sub Total</th>
                                                @if ((Auth::user()->level == "admin") && ($transaksi->id_status_transaksi != "7"))
                                                <th>Aksi</th>
                                                @endif
                                            </tr>
                                        </thead>
                                        <tfoot >
                                            <tr>
                                                <th>No</th>
                                                <th>Layanan</th>
                                                <th>Harga</th>
                                                <th>Jumlah</th>
                                                <th>Sub Total</th>
                                                @if ((Auth::user()->level == "admin") && ($transaksi->id_status_transaksi != "7"))
                                                <th>Aksi</th>
                                                @endif
                                            </tr>
                                        </tfoot>
                                        <?php
                                            $i=1;
                                        ?>
                                        <tbody >
                                            @foreach ($transaksiDetail as $index => $item )
                                            <tr>
                                                <form method="POST" action="{{ url('admin/transaksi/detail/'. $item->id_transaksi_detail.'/edit/update') }}">
                                                    {{ csrf_field() }}
                                                    <input type="hidden" name="harga" value="{{ $item -> harga }}">
                                                    <td>{{ $i++ }}</td>
                                                    <td>{{ $item -> layanan -> nama }}</td>
                                                    <td>{{ rupiah($item -> harga) }}</td>
                                                    @if ((Auth::user()->level == "admin") && ($transaksi->id_status_transaksi != "7"))
                                                    <td><input type="number" id="jumlah" class="form-control" name="jumlah" value="{{ $item -> jumlah }}"</td>
                                                    @else
                                                    <td>{{ $item -> jumlah }} {{ $item -> layanan -> satuan }}</td>
                                                    @endif
                                                    <td>{{ rupiah($item -> subtotal) }}</td>
                                                    @if ((Auth::user()->level == "admin") && ($transaksi->id_status_transaksi != "7"))
                                                    <td>
                                                        <button type="submit" class="btn btn-warning btn-block" >Edit</button>
                                                        <a class="btn btn-danger" href={{ url('admin/transaksi/detail/'. $item->id_transaksi_detail.'/edit/delete') }} data-confirm-delete="true" role="button">Hapus</a>
                                                    </td>
                                                    @endif
                                                </form>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <form method="POST" action="{{  url('admin/transaksi/'. $transaksi->id_transaksi.'/edit/diskon')  }}">
                                {{ csrf_field() }}
                                <input type="hidden" name="id_transaksi" value="{{ $transaksi->id_transaksi }}">
                                @unless ($transaksi->id_pengumuman == null && $transaksi->id_status_transaksi == "7")
                                <label for="diskon" class="fw-semibold form-label mx-3 mt-2 mb-0">Diskon</label>
                                @endunless
                                <div class="row mx-3 g-3 align-items-center">
                                    @if ( $transaksi->id_status_transaksi != "7")
                                        <div class="col-3">
                                            <select class="form-control " name="diskon" aria-label="Default select example" aria-describedby="diskon" value="{{$transaksi->id_pengumuman}} " {{ (($transaksi->id_status_transaksi == "7") || (Auth::user()->level == "pengguna") ? 'disabled' : '') }}>
                                                @if ($transaksi->id_pengumuman == null )
                                                    <option selected value="" >Pilih Diskon</option>
                                                    @if (Auth::user()->level == "admin")
                                                        @foreach ($pengumuman as $item)     
                                                        <option value="{{ $item->id_pengumuman }}" > {{ $item->judul }} {{ $item->diskon }}% </option>
                                                        @endforeach 
                                                    @endif                                
                                                @else
                                                    <option value="{{ $transaksi->id_pengumuman }}" > {{ $transaksi->pengumuman->judul }} {{ $transaksi->pengumuman->diskon }}% </option>
                                                    @if (Auth::user()->level == "admin")
                                                        @foreach ($pengumuman as $item)     
                                                        <option value="{{ $item->id_pengumuman }}" > {{ $item->judul }} {{ $item->diskon }}% </option>
                                                        @endforeach  
                                                        <option value="" >Hapus Diskon</option>
                                                    @endif
                                                @endif
                                            </select>
                                        </div>
                                    @elseif ($transaksi->id_pengumuman != null && $transaksi->id_status_transaksi == "7")
                                        <div class="col-3">
                                            <select class="form-control " name="diskon" aria-label="Default select example" aria-describedby="diskon" value="{{$transaksi->id_pengumuman}} " {{ (($transaksi->id_status_transaksi == "7") || (Auth::user()->level == "pengguna") ? 'disabled' : '') }}>
                                                    <option value="{{ $transaksi->id_pengumuman }}" > {{ $transaksi->pengumuman->judul }} {{ $transaksi->pengumuman->diskon }}% </option>
                                                    @if (Auth::user()->level == "admin")
                                                        @foreach ($pengumuman as $item)     
                                                        <option value="{{ $item->id_pengumuman }}" > {{ $item->judul }} {{ $item->diskon }}% </option>
                                                        @endforeach  
                                                        <option value="" >Hapus Diskon</option>
                                                    @endif
                                            </select>
                                        </div>
                                    @endif
                                    @if ((Auth::user()->level == "admin") && ($transaksi->id_status_transaksi != "7"))
                                    <div class="col-3">
                                        <div class="col-auto"><button type="submit" class="btn btn-primary btn-block" >Cek</button></div>
                                    </div>    
                                    @endif
                                </div>     
                            </form>
                            <form method="POST" action="{{ url('admin/transaksi/'. $transaksi->id_transaksi.'/edit/poin') }}">
                                {{ csrf_field() }} 
                                <input type="hidden" name="id_transaksi" value="{{ $transaksi->id_transaksi }}">
                                <label for="nama" class="fw-semibold form-label mx-3 mt-2 mb-0">Nama Pengguna</label>
                                <div class="row mx-3 g-3 align-items-center">
                                    <div class="col-3">
                                        <select class="form-control select2" name="nama" id="nama" aria-label="Default select example" value="{{ Session::get('nama') }}" {{ (($transaksi->id_status_transaksi == "7") || (Auth::user()->level == "pengguna") ? 'disabled' : '') }}>
                                            <option value="{{ $transaksi->id_user }}">{{ $transaksi->user->nama }}</option>
                                            @if (Auth::user()->level == "admin")
                                                @foreach ($pengguna as $item)
                                                <option value="{{ $item->id_user }}">{{ $item->nama }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <div class="col-auto">
                                        <span id="nama" class="form-text">
                                            Poin: {{ $transaksi->user->poin }}
                                        </span>
                                    </div>
                                    @if ((Auth::user()->level == "admin") && ($transaksi->id_status_transaksi != "7"))
                                    <div class="col-3">
                                        <div class="col-auto"><button type="submit" class="btn btn-primary btn-block" >Cek</button></div>
                                    </div> 
                                    @endif
                                </div>
                            </form>
                            <form method="POST" action="{{ url('admin/transaksi/'. $transaksi->id_transaksi.'/update') }}">
                                {{ csrf_field() }} 
                                <input type="hidden" name="user" value="{{ $transaksi->id_user }}">
                                <label for="total_harga" class="fw-semibold form-label mx-3 mt-2 mb-0">Total Harga</label>
                                <div class="row mx-3 g-3 align-items-center">
                                    <div class="col-3">
                                        <input type="text" id="total_harga_show" disabled class="form-control" name="total_harga_show"  value="Rp{{ number_format($transaksi->total_harga, 0, ".", ".")}}"/>
                                        <input type="hidden" id="total_harga" class="form-control" name="total_harga"  value="{{ $transaksi->total_harga }}"/>
                                    </div>
                                </div>

                                @if ($transaksi->user->poin > 0 && $transaksi->id_status_transaksi != "7" && $transaksi->user->poin >= 1000)
                                <label for="poin" class="fw-semibold form-label mx-3 mt-2 mb-0">Poin</label>
                                <div class="row mx-3 g-3 align-items-center">
                                    <div class="col-3">
                                        <select class="form-control" name="poin" aria-label="Default select example" value="{{ Session::get('poin') }}" {{  (($transaksi->id_status_transaksi == "7") || (Auth::user()->level == "pengguna")  ? 'disabled' : '') }}>
                                            @if($transaksi->poin_keluar != 0)
                                            <option value="{{ $transaksi->poin_keluar }}" > {{ $transaksi->poin_keluar }} (Rp{{ number_format($transaksi->poin_keluar, 0, ".", ".")}})</option>
                                            <option value="0">Hapus Poin</option>
                                            @for ($i = 1000; $i <= $transaksi->user->poin; $i = $i+1000)
                                                <option value="{{ $i }}" > {{ $i }} (Rp{{ number_format($i, 0, ".", ".")}})</option>
                                            @endfor
                                            @else
                                            <option selected value="0">Gunakan Poin</option>
                                            @for ($i = 1000; $i <= $transaksi->user->poin; $i = $i+1000)
                                                <option value="{{ $i }}" > {{ $i }} (Rp{{ number_format($i, 0, ".", ".")}})</option>
                                            @endfor
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                @elseif ($transaksi->poin_keluar > 0 && $transaksi->id_status_transaksi == "7" && $transaksi->user->poin >= 1000)
                                <label for="poin" class="fw-semibold form-label mx-3 mt-2 mb-0">Poin</label>
                                <div class="row mx-3 g-3 align-items-center">
                                    <div class="col-3">
                                        <select class="form-control" name="poin" aria-label="Default select example" value="{{ Session::get('poin') }}" {{  (($transaksi->id_status_transaksi == "7") || (Auth::user()->level == "pengguna")  ? 'disabled' : '') }}>
                                            <option value="{{ $transaksi->poin_keluar }}" > {{ $transaksi->poin_keluar }} (Rp{{ number_format($transaksi->poin_keluar, 0, ".", ".")}})</option>
                                        </select>
                                    </div>
                                </div>
                                @else
                                <input type="hidden" id="poin" class="form-control" name="poin"  value="0"/>
                                @endif

                                <label for="total_tagihan" class="fw-semibold form-label mx-3 mt-2 mb-0">Total Tagihan</label>
                                <div class="row mx-3 g-3 align-items-center">
                                    <div class="col-3">
                                        <input type="hidden" id="total_tagihan_ori"  class="form-control" name="total_tagihan_ori" value="{{ $transaksi->total_tagihan + $transaksi->poin_keluar }}"/>                                           
                                        <input type="text" id="totTag" disabled class="form-control form-control-lg fw-semibold" name="totTag" value="Rp{{ number_format($transaksi->total_tagihan, 0, ".", ".")}}"/> 
                                        <input type="hidden" id="total_tagihan"  class="form-control" name="total_tagihan" value="{{ $transaksi->total_tagihan }}"/>                                                                                       
                                    </div>
                                </div>

                                <label for="diterima" class="fw-semibold form-label mx-3 mt-2 mb-0">Diterima</label>
                                <div class="row mx-3 g-3 align-items-center">
                                    <div class="col-3">
                                        @if ((Auth::user()->level == "admin") && ($transaksi->id_status_transaksi != "7"))
                                        <input type="number" id="diterima" class="form-control" name="diterima" value="{{ $transaksi->diterima }}"/>
                                        @else
                                        <input type="text" id="ter" class="form-control" disabled name="ter" value="Rp{{ number_format($transaksi->diterima, 0, ".", ".")}}"/>
                                        <input type="hidden" id="diterima" class="form-control" name="diterima" value="{{ $transaksi->diterima }}"/>
                                        @endif
                                    </div>
                                </div>

                                <label for="kembali" class="fw-semibold form-label mx-3 mt-2 mb-0">Kembali</label>
                                <div class="row mx-3 g-3 align-items-center">
                                    <div class="col-3">
                                        <input type="text" id="kembali" disabled class="form-control form-control-lg fw-semibold" name="kembali" value=""/>
                                    </div>
                                </div>

                                <div class="row mx-3 mb-2 g-3 mt-1 align-items-center">
                                    <div class="col-auto">
                                        @if (Auth::user()->level == "admin")
                                        <a class="btn btn-danger" href="{{ url('admin/transaksi') }}" role="button">Kembali</a>
                                        @else
                                        <a class="btn btn-danger" href="{{ url('user/transaksi') }}" role="button">Kembali</a>
                                        @endif
                                    </div>
                                    @if ((Auth::user()->level == "admin") && ($transaksi->id_status_transaksi != "7"))
                                    <div class="col-auto"><button type="submit" class="btn btn-primary btn-block" >Simpan</button></div>
                                    @endif
                                </div>
                            </form>
                        </div>
                    </div>
                </main>
                {{--  <input type="hidden" id="tagOri" class="form-control" name="tagOri" value="{{ $transaksi->poin_keluar + $transaksi->total_tagihan }}"/>  --}}
                @include('sweetalert::alert')
            </div>
        </div>
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