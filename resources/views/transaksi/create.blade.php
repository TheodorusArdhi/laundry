<!DOCTYPE html>
<html lang="en">
    <head>
        @include('template.head')
        <title>Transaksi - Sinar Laundry</title>
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
                            <li class="breadcrumb-item active">Tambah Transaksi</li>
                        </ol>
                        @include('template.validate')
                        <div class="card shadow-lg border-0 rounded-lg mb-4 fs-5">
                            <div class="  d-flex justify-content-between mx-3 mt-2 mb-0">
                                <p class="text-start"><span class="fw-semibold">Admin</span> : {{ $transaksi->admin->nama }}</p>
                                <p class="text-end"><span class="fw-semibold">Tanggal</span> : {{ $transaksi->tgl_masuk -> translatedFormat('l, d F Y')}}</p>
                            </div>
                            <div class="  d-flex justify-content-between mx-3 mt-0">
                                <p class="text-start "><span class="fw-semibold">Nomor Transaksi</span> : {{ $transaksi->no_transaksi }}</p>
                                <p class="text-end"><span class="fw-semibold">Cabang</span> : {{ $transaksi->cabang->nama}}</p>
                            </div>
                            
                            <form method="POST" action="{{ url('admin/transaksi/poin') }}">
                                {{ csrf_field() }} 
                                <input type="hidden" name="id_transaksi" value="{{ $transaksi->id_transaksi }}">
                                <label for="nama" class="fw-semibold form-label mx-3 mt-2 mb-0">Nama Pengguna</label>
                                <div class="row mx-3 g-3 align-items-center ">
                                    <div class="col-3 ">
                                        <select class="form-control form-control-lg select2" name="nama" id="nama" aria-label="Default select example" value="{{ Session::get('nama') }}">
                                            @if ($transaksi->id_user == null)
                                                <option selected disabled>Pilih Pengguna</option>
                                                @foreach ($pengguna as $item)
                                                <option value="{{ $item->id_user }}">{{ $item->nama }}</option>
                                                @endforeach
                                                @php
                                                    $poin = null;
                                                @endphp
                                            @else
                                                <option value="{{ $transaksi->id_user }}">{{ $transaksi->user->nama }}</option>
                                                @foreach ($pengguna as $item)
                                                <option value="{{ $item->id_user }}">{{ $item->nama }}</option>
                                                @endforeach
                                                @php
                                                        $poin = App\Models\Poin::where('id_user', $transaksi->id_user)->where('status', 'aktif')->sum('jumlah');
                                                @endphp
                                            @endif
                                        </select>
                                    </div>
                                    <div class="col-auto">
                                        <span id="nama" class="form-text">
                                            @if ($poin == null)
                                            Poin: 0
                                            @else
                                            Poin: {{ $poin }}
                                            @endif
                                        </span>
                                    </div>
                                    <div class="col-3">
                                        <div class="col-auto"><button type="submit" class="btn btn-secondary fw-semibold btn-block" role="button" data-toggle="tooltip" data-placement="top" title="Cek Pengguna">Cek</button></div>
                                    </div> 
                                </div>
                            </form>

                            <form method="POST" action="{{ url('admin/transaksi/detail/store') }}">
                                {{ csrf_field() }}
                                <div class="row g-3 align-items-center ">
                                    <div class="col-3 mx-3">
                                    <label for="layanan" class="fw-semibold form-label mt-2 mb-0">Layanan</label>
                                        <div class="col ">
                                            <select class="form-control form-control-lg " name="layanan" aria-label="Default select example" value="{{ Session::get('layanan') }}">
                                                <option selected disabled>Pilih Layanan</option>
                                                @foreach ($layanan as $item)
                                                <option value="{{ $item->id_layanan }}">{{ $item->nama }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-3 mx-3">
                                    <label for="jumlah" class="fw-semibold form-label mt-2 mb-0">Jumlah</label>
                                        <div class="col">
                                            <input type="number" step="any" id="jumlah" class="form-control form-control-lg" placeholder="Masukkan Jumlah Layanan" name="jumlah" value="{{ Session::get('jumlah') }}"/>
                                        </div>
                                    </div>

                                    <input type="hidden" name="no_transaksi"  value="{{ $transaksi->no_transaksi }}" />
                                    <div class="col-auto align-self-end mb-1">
                                        <div class="col-auto "><button type="submit" class="btn btn-secondary fw-semibold btn-block" role="button" data-toggle="tooltip" data-placement="top" title="Tambah Layanan">Tambah</button></div>
                                    </div>
                                </div>
                            </form>
                            @include('sweetalert::alert')

                            <div class="card mb-2 mt-3 mx-3">                            
                                <div class="card-header">
                                    <i class="fas fa-table me-1"></i>
                                    <a> <b class="fw-semibold">Detail Transaksi</b></a>
                                </div>                            
                                <div class="card-body">
                                    <table id="datatablesSimple">
                                        <thead >
                                            <tr>
                                                <th>No</th>
                                                <th>Layanan</th>
                                                <th>Harga</th>
                                                <th>Jumlah</th>
                                                <th>Subtotal</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tfoot >
                                            <tr>
                                                <th>No</th>
                                                <th>Layanan</th>
                                                <th>Harga</th>
                                                <th>Jumlah</th>
                                                <th>Subtotal</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </tfoot>
                                        <?php
                                            $i=1;
                                        ?>
                                        <tbody >
                                            @foreach ($detail as $index => $item )
                                            <tr>
                                                <form method="POST" action="{{ url('admin/transaksi/detail/'. $item->id_transaksi_detail.'/update') }}">
                                                    <input type="hidden" name="harga" value="{{ $item -> harga }}">
                                                    {{ csrf_field() }}
                                                    <td>{{ $i++ }}</td>
                                                    <td>{{ $item -> layanan -> nama }}</td>
                                                    <td>{{ rupiah($item -> harga) }}</td>
                                                    <td><input type="number" step="any" id="jumlah" class="form-control" name="jumlah" value="{{ $item -> jumlah }}"</td>
                                                    <td>{{ rupiah($item -> subtotal) }}</td>
                                                    <td>
                                                        <button type="submit" class="btn btn-laundry btn-block" data-toggle="tooltip" data-placement="top" title="Edit Layanan"><i class="fa-solid fa-pen"></i></button>
                                                        <a class="btn btn-danger" href={{ url('admin/transaksi/detail/'. $item->id_transaksi_detail.'/delete') }} data-confirm-delete="true" role="button" data-toggle="tooltip" data-placement="top" title="Hapus Layanan"><i class="fa-solid fa-trash"></i></a>
                                                    </td>
                                                </form>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <label for="total_harga" class="fw-semibold form-label mx-3 mt-2 mb-0">Total Harga</label>
                            <div class="row mx-3 g-3 align-items-center">
                                <div class="col-3">
                                    <input type="text" id="total_harga_show" disabled class="form-control form-control-lg" name="total_harga_show"  value="Rp{{ number_format($transaksi->total_harga, 0, ".", ".")}}"/>
                                </div>
                            </div>

                            <form method="POST" action="{{ url('admin/transaksi/diskon') }}">
                                {{ csrf_field() }}
                                <input type="hidden" name="id_transaksi" value="{{ $transaksi->id_transaksi }}">
                                <label for="diskon" class="fw-semibold form-label mx-3 mt-2 mb-0">Diskon</label>
                                <div class="row mx-3 g-3 align-items-center">
                                    <div class="col-3">
                                        <select class="form-control form-control-lg " name="diskon" aria-label="Default select example" aria-describedby="diskon" value="{{$transaksi->id_pengumuman}}">
                                            @if ($transaksi->id_pengumuman == null)
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
                                    <div class="col-3">
                                        <div class="col-auto"><button type="submit" class="btn btn-secondary fw-semibold btn-block" role="button" data-toggle="tooltip" data-placement="top" title="Cek Diskon">Cek</button></div>
                                    </div>    
                                </div>     
                            </form>
                            
                            <form method="POST" action="{{ url('admin/transaksi/store') }}">
                                {{ csrf_field() }} 
                                <input type="hidden" name="no_transaksi" value="{{ $transaksi->no_transaksi }}">
                                <input type="hidden" name="user" value="{{ $transaksi->id_user }}">
                                <input type="hidden" id="total_tagihan_ori"  class="form-control" name="total_tagihan_ori" value="{{ $transaksi->total_tagihan }}"/>                                           
                                <input type="hidden" id="total_harga" class="form-control" name="total_harga"  value="{{ $transaksi->total_harga }}"/>

                                @if ($transaksi->id_user != null && $poin >= 1000)
                                    <label for="poin" class="fw-semibold form-label mx-3 mt-2 mb-0">Poin</label>
                                    <div class="row mx-3 g-3 align-items-center">
                                        <div class="col-3">
                                            <select class="form-control form-control-lg" name="poin" aria-label="Default select example" value="{{ Session::get('poin') }}" {{  (($transaksi->id_status_transaksi == "7") || (Auth::user()->level == "pengguna")  ? 'disabled' : '') }}>
                                                <option selected value="0">Gunakan Poin</option>
                                                @for ($i = 1000; $i <= $poin; $i = $i+1000)
                                                    <option value="{{ $i }}" > {{ $i }} (Rp{{ number_format($i, 0, ".", ".")}})</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                @else
                                <input type="hidden" id="poin" class="form-control" name="poin"  value="0"/>
                                @endif

                                <label for="total_tagihan" class="fw-semibold form-label mx-3 mt-2 mb-0">Total Tagihan</label>
                                <div class="row mx-3 g-3 align-items-center">
                                    <div class="col-3">                                          
                                        <input type="text" id="totTag" disabled class="form-control form-control-lg fw-semibold" name="totTag" value="Rp{{ number_format($transaksi->total_tagihan, 0, ".", ".")}}"/> 
                                        <input type="hidden" id="total_tagihan"  class="form-control" name="total_tagihan" value="{{ $transaksi->total_tagihan }}"/>                                                                                       
                                    </div>
                                </div>

                                <label for="diterima" class="fw-semibold form-label mx-3 mt-2 mb-0">Diterima</label>
                                <div class="row mx-3 g-3 align-items-center">
                                    <div class="col-3">
                                        <input type="number" id="diterima" class="form-control form-control-lg " name="diterima" value="{{ Session::get('diterima') }}"/>
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
                                    <a class="btn btn-danger fw-semibold" style="font-size: 1.12rem;" href="{{ url('admin/transaksi') }}" role="button">Kembali</a>
                                    </div>
                                    <div class="col-auto"><button type="submit" class="btn btn-laundry btn-block fw-semibold" style="font-size: 1.12rem;" data-toggle="tooltip" data-placement="top" title="Simpan Transaksi">Simpan</button></div>
                                </div>
                            </form>
                        </div>
                    </div>
                </main>
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
                let totTag = $('[name="totTag"]');
                let diterima = $('[name="diterima"]');
                let kembali = $('[name="kembali"]');

                tagihanOri = total_tagihan.val();
                poin.on('input', function() {
                    tagihanValue = tagihanOri - poin.val();
                    if (tagihanValue < 0) {
                        total_tagihan.val(0)
                        totTag.val(currencyFormat(0))
                    } else {
                        total_tagihan.val(tagihanValue);   
                        totTag.val(currencyFormat(tagihanValue));   
                    }

                    kembaliValue = diterima.val() - tagihanValue;
                    if (kembaliValue < 0) {
                        kembali.val(currencyFormat(0))
                    } else {
                        kembali.val(currencyFormat(kembaliValue));   
                    }

                    diterima.on('input', function() {
                        kembaliValue = diterima.val() - tagihanValue;
                        if (kembaliValue < 0) {
                            kembali.val(currencyFormat(0))
                        } else {
                            kembali.val(currencyFormat(kembaliValue));   
                        }
                    });
                });

                diterima.on('input', function() {
                    kembaliValue = diterima.val() - tagihanOri;
                    if (kembaliValue < 0) {
                        kembali.val(currencyFormat(0))
                    } else {
                        kembali.val(currencyFormat(kembaliValue));   
                    }
                });
            });
        </script>
    </body>
</html>
