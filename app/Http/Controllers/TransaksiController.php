<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\TransaksiDetail;
use App\Models\User;
use App\Models\Pengumuman;
use App\Models\Layanan;
use App\Models\Cabang;
use App\Models\Poin;
use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Controllers\WAController;
use Auth;
use Session;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class TransaksiController extends Controller
{
    public function indexUser(){  
        $transaksi = Transaksi::with('pengumuman', 'user', 'admin', 'statusPembayaran', 'statusTransaksi')->where('id_user', Auth::user()->id_user)->orderBy('id_transaksi', 'desc')->get();
        return view('transaksi.index', compact('transaksi'));
    }

    public function indexAdmin(){  
        $del = 'Yakin Hapus Transaksi?';
        confirmDelete($del);

        if(Transaksi::where('id_status_pembayaran', null)->count() != 0){
            $delete = Transaksi::where('id_status_pembayaran', null)->first()->id_transaksi;
            TransaksiDetail::where('id_transaksi', $delete)->delete();
            Transaksi::where('id_transaksi', $delete)->delete();
        }

        $currentDate = Carbon::parse(now()->format('Y-m-d'));

        if(Auth::user()->level == 'pemilik'){
            $transaksi = Transaksi::with('pengumuman', 'user', 'admin', 'statusPembayaran', 'statusTransaksi')->orderByRaw('FIELD(id_status_transaksi,4,5,6,3,7,8)')->orderBy('id_transaksi', 'desc')->get();
        }else{
            $transaksi = Transaksi::with('pengumuman', 'user', 'admin', 'statusPembayaran', 'statusTransaksi')->where('id_cabang', Auth::user()->id_cabang)->orderByRaw('FIELD(id_status_transaksi,4,5,6,3,7,8)')->orderBy('id_transaksi', 'desc')->get();
        }
        return view('transaksi.index', compact('transaksi'));
    }

    public function data(){        
        if ( Transaksi::where('tgl_masuk', date('Y-m-d'))->count() == 0 ){
            $noTransaksiBaru = "SL".date('ymd').'-001';
        } else {
            $noTransaksi = explode('-', Transaksi::latest()->first()->no_transaksi);
            $noTransaksiBaru = "SL".date('ymd').'-'. sprintf("%03s",$noTransaksi[1]+1);
        }
        $id_admin = Auth::user()->id_user;
        $id_cabang = User::where('id_user', $id_admin)->first()->id_cabang;

        $transaksi = new Transaksi([
            'id_admin' => $id_admin,
            'no_transaksi' => $noTransaksiBaru,
            'tgl_masuk' => date('Y-m-d'),
            'id_cabang' => $id_cabang,

        ]);
        $transaksi->save();
        session(['id_transaksi' => $transaksi->id_transaksi]);
        return redirect('admin/transaksi/create');        
    }

    public function create(){  
        $del = 'Yakin Hapus Layanan?';
        confirmDelete($del);
        $id_transaksi = session('id_transaksi');
        $pengguna = User::whereIn("level", ["pelanggan", "anggota"])->orderBy('nama')->get();
        $pengumuman = Pengumuman::where("status", "aktif")->orderBy('diskon')->get();
        $layanan = Layanan::where("status", "aktif")->orderBy('harga')->get();
        $cabang = Cabang::where("status", "aktif")->get();
        $detail = TransaksiDetail::with('layanan')->where('id_transaksi', $id_transaksi)->get();

        $totalHarga = TransaksiDetail::where('id_transaksi', $id_transaksi)->sum('subtotal');
        $diskon = Transaksi::where('id_transaksi', $id_transaksi)->first()->diskon;
        $poinKeluar = Transaksi::where('id_transaksi', $id_transaksi)->first()->poin_keluar;
        $totalTagihan = $totalHarga - $poinKeluar - ($diskon/100 * $totalHarga);
        Transaksi::where('id_transaksi', $id_transaksi)->update([ 
            'total_harga' => $totalHarga,
            'total_tagihan' => $totalTagihan
        ]);

        $transaksi = Transaksi::find($id_transaksi);
        return view('transaksi.create', compact('pengguna', 'pengumuman', 'layanan', 'transaksi', 'detail', 'cabang'));
    }

    public function store(Request $request){ 
        $transaksi = Transaksi::where('no_transaksi', $request->no_transaksi);
        $transaksiDetil = TransaksiDetail::where('id_transaksi', $transaksi->first()->id_transaksi);
        Session::flash('diterima', $request->diterima);

        $cek = $this->CekData($request->no_transaksi);
        if($cek != null){
            return $cek;
        }

        $details = $transaksiDetil->pluck('id_layanan');
        $max = Layanan::whereIn('id_layanan', $details)->pluck('durasi')->max();

        if($request->diterima < $request->total_tagihan){
            $status = 2;
            $diterima = 0;
        }else{
            $status = 1;
            $diterima = $request->diterima;
        }

        $id_user = $transaksi->first()->id_user;
        $level = User::where('id_user', $id_user)->first()->level;
        if($level == "anggota"){
            if($request->total_tagihan == 0){
                $status = 1;
                $poinKeluar = $request->total_tagihan_ori;
            }else{
                $poinKeluar = $request->poin;
            }
            $poinMasuk = ($request->total_tagihan / 100) + 100;
        }else{
            $poinKeluar = 0;
            $poinMasuk = 0;
        }
        
        if($request->poin > 0){
            $this->poinUpdate($transaksi->first()->id_user, $request->poin);
        }

        $update = [
            'id_status_pembayaran' => $status,
            'id_status_transaksi' => 3,
            'tgl_selesai' => date('Y-m-d', strtotime($transaksi->first()->tgl_masuk. ' + '.$max.' days')),
            'tgl_ambil' => null,
            'tgl_tenggat' => date('Y-m-d', strtotime($transaksi->first()->tgl_masuk. ' + '.$max + 30 .' days')),
            'total_harga' => $request->total_harga,
            'total_tagihan' => $request->total_tagihan,
            'diterima' => $diterima,
            'poin_masuk' => $poinMasuk,
            'poin_keluar' => $poinKeluar,
        ];
        
        $transaksi->update($update);
        $WA = new WAController;
        if($level == "anggota"){
            $WA->transaksiAnggota($transaksi->first()->id_transaksi);
        }else{
            $WA->transaksi($transaksi->first()->id_transaksi);
        }
        return redirect('admin/transaksi')->with('success', 'Tambah Transaksi Sukses');
    }

    public function editAdmin($id){  
        $del = 'Yakin Hapus Layanan?';
        confirmDelete($del);
        $detail = TransaksiDetail::with('layanan')->where('id_transaksi', $id)->get();
        $pengguna = User::whereIn("level", ["pelanggan", "anggota"])->orderBy('nama')->get();
        $pengumuman = Pengumuman::where("status", "aktif")->orderBy('diskon')->get();
        $layanan = Layanan::where("status", "aktif")->orderBy('harga')->get();
        $cabang = Cabang::where("status", "aktif")->get();

        $totalHarga = TransaksiDetail::where('id_transaksi', $id)->sum('subtotal');
        $diskon = Transaksi::where('id_transaksi', $id)->first()->diskon;
        $poinKeluar = Transaksi::where('id_transaksi', $id)->first()->poin_keluar;
        $totalTagihan = $totalHarga - $poinKeluar - ($diskon/100 * $totalHarga);
        Transaksi::where('id_transaksi', $id)->update([ 
            'total_harga' => $totalHarga,
            'total_tagihan' => $totalTagihan
        ]);

        $transaksi = Transaksi::with('user')->find($id);
        return view('transaksi.edit', compact('transaksi', 'detail', 'pengguna', 'pengumuman', 'layanan', 'cabang'));
    }

    public function editUser($id){  
        $transaksi = Transaksi::with('pengumuman', 'user', 'admin')->find($id);
        $detail = TransaksiDetail::with( 'layanan')->where('id_transaksi', $id)->get();
        return view('transaksi.edit', compact('transaksi', 'detail'));
    }

    function poinUpdate($id_user, $poinValue){
        $poin = Poin::where('id_user', $id_user)->where('status', 'aktif')->orderBy('tgl_tenggat', 'asc')->select('id_poin')->get();
        $temp = $poinValue;
        foreach($poin as $key => $value){
            //1
            $poinSyn = Poin::where('id_poin', $value->id_poin);

            $jumlah[$key] = $poinSyn->first()->jumlah;
            $tanggal[$key] = $poinSyn->first()->tgl_tenggat;
            $id_transaksi[$key] = $poinSyn->first()->id_transaksi;
            $temp = $temp - $jumlah[$key];
            $poinSyn->update([//ngubah status || A pasti ke TA
                'status' => 'tidak aktif'
            ]);
            if($temp == 0){ // tidak ada sisa keluar
                break;
            }
            elseif($temp < 0){ // kalo sisa minus bikin baris baru
                $temp = $temp * -1;
                $tanggalx = $tanggal[$key];
                $id_transaksix = $id_transaksi[$key];
                $poinNew = new Poin([
                    'id_transaksi' =>$id_transaksix,
                    'id_user' => $id_user,
                    'jumlah' => $temp,
                    'tgl_tenggat' => $tanggalx,
                    'status' => "aktif"
                ]);
                $poinNew->save();
                break;
            }
            //kalo sisa plus ngulang ke 1
        }

        $poinTA = Poin::where('id_user', $id_user)->where('status', 'tidak aktif')->where('tgl_tenggat', '>', Carbon::parse(now()->format('Y-m-d')))->select('id_transaksi')->groupBy('id_transaksi')->orderBy('tgl_tenggat', 'desc')->get();
        //dd($poinTA);
        foreach($poinTA as $key => $value){
            $value->poinMax = Poin::where('id_transaksi', $value->id_transaksi)->max('jumlah');
            $value->idPoinTA = Poin::where('id_transaksi', $value->id_transaksi)->where('jumlah', $value->poinMax)->first()->id_poin;

            if (Poin::where('id_transaksi', $value->id_transaksi)->where('status', 'aktif')->get()->isEmpty()){
                if(Poin::where('id_transaksi', $value->id_transaksi)->where('status', 'tidak aktif')->count() > 1){
                    Poin::where('id_transaksi', $value->id_transaksi)->whereNot('jumlah', $value->poinMax)->where('status', 'tidak aktif')->delete();
                }
            }
        }
    }

    function poinUpdateLower($id_user, $poinValue){
        $poinTA = Poin::where('id_user', $id_user)->where('status', 'tidak aktif')->where('tgl_tenggat', '>', Carbon::parse(now()->format('Y-m-d')))->select('id_transaksi')->groupBy('id_transaksi')->orderBy('tgl_tenggat', 'desc')->get();
        $temp = $poinValue;
        
        $string = 'mulai '.$temp.'<br />';
        foreach($poinTA as $key => $value){
            //1 $poinValue = minus
            $value->poinMax = Poin::where('id_transaksi', $value->id_transaksi)->max('jumlah');
            $value->tanggal = Poin::where('id_transaksi', $value->id_transaksi)->first()->tgl_tenggat;
            $value->idPoinTA = Poin::where('id_transaksi', $value->id_transaksi)->where('jumlah', $value->poinMax)->first()->id_poin;

            if(Poin::where('id_transaksi', $value->id_transaksi)->where('status', 'aktif')->get()->isEmpty()){
                $value->idPoinA = null;
            }else{
                $value->idPoinA = Poin::where('id_transaksi', $value->id_transaksi)->where('status', 'aktif')->first()->id_poin;
            }

            if($value->idPoinA != null){
                $value->PoinA = Poin::where('id_transaksi', $value->id_transaksi)->where('status', 'aktif')->first()->jumlah;
                $value->selisih = $value->poinMax - $value->PoinA;
            }else{
                $value->PoinA = null;
                $value->selisih = null;
            }
            if($value->selisih != null){ //kalo ada selisih
                $temp = $temp + $value->selisih;
                if($temp == 0){// tidak sisa MUMETT
                    //BIKIN status TA jadi A, A jadi TA
                    Poin::where('id_poin', $value->idPoinTA)->update([//ngubah status
                        'status' => 'aktif'
                    ]);
                    Poin::where('id_poin', $value->idPoinA)->update([//ngubah status
                        'status' => 'tidak aktif'
                    ]);
                    //hapus yang jadi tidak aktif
                    Poin::where('id_transaksi', $value->id_transaksi)->whereNot('id_poin', $value->idPoinTA)->delete();
                    break;
                }elseif($temp > 0){// sisa plus
                    //Bikin status A jadi TA, bikin baris baru A + $temp
                    Poin::where('id_poin', $value->idPoinA)->update([//ngubah status
                        'status' => 'tidak aktif'
                    ]);
                    $poinNew = new Poin([
                        'id_transaksi' =>$value->id_transaksi,
                        'id_user' => $id_user,
                        'jumlah' => $value->PoinA + $temp,
                        'tgl_tenggat' => $value->tanggal,
                        'status' => "aktif"
                    ]);
                    $poinNew->save();
                    break;
                }elseif($temp < 0){// sisa masih minus
                    //BIKIN status TA jadi A, A jadi TA
                    Poin::where('id_poin', $value->idPoinTA)->update([//ngubah status
                        'status' => 'aktif'
                    ]);
                    Poin::where('id_poin', $value->idPoinA)->update([//ngubah status
                        'status' => 'tidak aktif'
                    ]);
                    //hapus yang jadi tidak aktif
                    Poin::findorfail($value->idPoinA)->delete();
                }
                //ngulang ke 1
            }else{ //kalo engga ada selisih
                $temp = $temp + $value->poinMax;
                if($temp == 0){// tidak sisa
                    //BIKIN status TA jadi A
                    Poin::where('id_poin', $value->idPoinTA)->update([//ngubah status
                        'status' => 'aktif'
                    ]);
                    break;
                }elseif($temp > 0){// sisa positif
                    //Bikin bikin baris baru A jumlah $temp
                    $poinNew = new Poin([
                        'id_transaksi' =>$value->id_transaksi,
                        'id_user' => $id_user,
                        'jumlah' => $value->poinMax - $temp,
                        'tgl_tenggat' => $value->tanggal,
                        'status' => "aktif"
                    ]);
                    $poinNew->save();
                    break;
                }elseif($temp < 0){// sisa masih minus
                    //BIKIN status TA jadi A
                    Poin::where('id_poin', $value->idPoinTA)->update([//ngubah status
                        'status' => 'aktif'
                    ]);
                }
            }
            //kalo minus ngulang ke 1
        }
    }
    
    public function update(Request $request, $id){ 
        $transaksi = Transaksi::where('id_transaksi', $id);
        $transaksiDetil = TransaksiDetail::where('id_transaksi', $id);

        $details = $transaksiDetil->pluck('id_layanan');
        $max = Layanan::whereIn('id_layanan', $details)->pluck('durasi')->max();

        $cek = $this->CekData($transaksi->first()->no_transaksi);
        if($cek != null){
            return $cek;
        }

        if($request->diterima < $request->total_tagihan){
            $status = 2;
            $diterima = 0;
        }else{
            $status = 1;
            $diterima = $request->diterima;
        }

        $id_user = $transaksi->first()->id_user;
        $level = User::where('id_user', $id_user)->first()->level;
        if($level == "anggota"){
            if($request->total_tagihan == 0){
                $status = 1;
                $poinKeluar = $request->total_tagihan_ori;
            }else{
                $poinKeluar = $request->poin;
            }
            $poinMasuk = ($request->total_tagihan / 100) + 100;
        }else{
            $poinKeluar = 0;
            $poinMasuk = 0;
        }

        $poinOld = $transaksi->first()->poin_keluar;
        $poinNew = $request->poin - $poinOld;
        if($poinNew > 0){
            $this->poinUpdate($transaksi->first()->id_user, $poinNew);
        }elseif($poinNew < 0){
            $this->poinUpdateLower($transaksi->first()->id_user, $poinNew);
        }

        //dd($request);
        $update = [
            'id_status_pembayaran' => $status,
            'tgl_selesai' => date('Y-m-d', strtotime($transaksi->first()->tgl_masuk. ' + '.$max.' days')),
            'tgl_ambil' => null,
            'tgl_tenggat' => date('Y-m-d', strtotime($transaksi->first()->tgl_masuk. ' + '.$max + 30 .' days')),
            'total_harga' => $request->total_harga,
            'total_tagihan' => $request->total_tagihan,
            'diterima' => $diterima,
            'poin_masuk' => $poinMasuk,
            'poin_keluar' => $poinKeluar,
        ];
        $transaksi->update($update);
        return redirect('admin/transaksi')->with('success', 'Edit Transaksi Sukses');
    }

    public function tanggal(Request $request, $id){
        $selesaiLama = Transaksi::where('id_transaksi', $id)->first()->tgl_selesai;
        $selesaiBaru = Carbon::createFromFormat('d/m/Y', $request->tanggal)->format('Y-m-d');
        //dd($selesaiLama,Carbon::parse($selesaiBaru));
        if (Carbon::parse(now()->format('Y-m-d'))->diffInDays($selesaiBaru, false) < 1){
            return redirect('admin/transaksi/'.$id.'/edit')->with('error', 'Tanggal harus melebihi hari ini');
        }elseif($selesaiLama->diffInDays($selesaiBaru, false) == 0){
            return redirect('admin/transaksi/'.$id.'/edit')->with('error', 'Tanggal sama dengan tanggal selesai lama');
        }else{
            $update = [
                'id_status_transaksi' => 3,
                'tgl_selesai' => $selesaiBaru,
                'tgl_tenggat' => Carbon::createFromFormat('d/m/Y', $request->tanggal)->addDays(30)->format('Y-m-d'),
            ];
            //dd($update);
            Transaksi::where('id_transaksi', $id)->update($update);
            $WA = new WAController;
            $WA->tanggal($id, $selesaiLama);
        }
        return redirect('admin/transaksi/'.$id.'/edit')->with('success', 'Edit Tanggal Selesai Sukses');
    }

    public function diskon(Request $request){ 
        if($request->diskon != null){
            $id_pengumuman = $request->diskon;
            $diskonValue = Pengumuman::where('id_pengumuman', $request->diskon)->first()->diskon;
        }else{
            $id_pengumuman = null;
            $diskonValue = 0;
        }
        Transaksi::findOrFail($request->id_transaksi)->update([ 
            'id_pengumuman' => $id_pengumuman,
            'diskon' => $diskonValue
        ]);
        return redirect('admin/transaksi/create')->with('success', 'Tambah Diskon Sukses');
    }

    public function diskonEdit(Request $request, $id){ 
        if($request->diskon != null){
            $id_pengumuman = $request->diskon;
            $diskonValue = Pengumuman::where('id_pengumuman', $request->diskon)->first()->diskon;
        }else{
            $id_pengumuman = null;
            $diskonValue = 0;
        }
        Transaksi::findOrFail($request->id_transaksi)->update([ 
            'id_pengumuman' => $id_pengumuman,
            'diskon' => $diskonValue
        ]);
        return redirect()->route('editAdmin', $id)->with('success', 'Tambah Diskon Sukses');
    }

    public function poin(Request $request){ 
        if(Auth::user()->level == "pemilik"){
            $request->validate([
                'cabang'=>'required',
            ], [
                'cabang.required' => 'Cabang Belum Terisi',
            ]);
            Transaksi::findOrFail($request->id_transaksi)->update([ 'id_cabang' => $request->cabang]);
        }
        $request->validate([
            'nama'=>'required',
        ], [
            'nama.required' => 'Nama Belum Terisi',
        ]);
        Transaksi::findOrFail($request->id_transaksi)->update([ 'id_user' => $request->nama]);
        return redirect('admin/transaksi/create')->with('success', 'Tambah Data Sukses');
    }

    public function poinEdit(Request $request, $id){ 
        if(Auth::user()->level == "pemilik"){
            $request->validate([
                'cabang'=>'required',
            ], [
                'cabang.required' => 'Cabang Belum Terisi',
            ]);
            Transaksi::findOrFail($request->id_transaksi)->update([ 'id_cabang' => $request->cabang]);
        }
        $request->validate([
            'nama'=>'required',
        ], [
            'nama.required' => 'Nama Belum Terisi',
        ]);
        Transaksi::findOrFail($request->id_transaksi)->update([ 'id_user' => $request->nama]);
        return redirect()->route('editAdmin', $id)->with('success', 'Edit Pengguna Sukses');
    }

    public function batal($id){  
        Transaksi::where('id_transaksi', $id)->update(['id_status_transaksi' => 8]);
        //TransaksiDetail::where('id_transaksi', $id)->update(['jumlah' => 0, 'subtotal' => 0]);
        return redirect('admin/transaksi')->with('success', 'Edit Status Sukses');
    }

    public function lunas($id){
        $totalTagihan = Transaksi::where('id_transaksi', $id)->first()->total_tagihan;
        Transaksi::where('id_transaksi', $id)->update([
            'id_status_pembayaran' => 1,
            'diterima' => $totalTagihan,
        ]);
        return redirect('admin/transaksi/'.$id.'/edit')->with('success', 'Edit Status Sukses');
    }

    public function ambil($id){
        $transaksi = Transaksi::where('id_transaksi', $id);
        $id_user = $transaksi->first()->id_user;
        $id_transaksi = $transaksi->first()->id_transaksi;
        $level = User::where('id_user', $id_user)->first()->level;
        
        if($level == "anggota"){
            $tgl_masuk = $transaksi->first()->tgl_masuk;
            $total_tagihan = $transaksi->first()->total_tagihan;
            if($transaksi->first()->poin_masuk <= 0){
                $poinMasuk = ($total_tagihan / 100) + 100;
            }else{
                $poinMasuk = $transaksi->first()->poin_masuk;
            }
            $poin = new Poin([
                'id_transaksi' =>$id,
                'id_user' => $id_user,
                'jumlah' => $poinMasuk,
                'tgl_tenggat' => date('Y-m-d', strtotime($tgl_masuk. ' + '. 90 .' days')),
                'status' => "aktif"
            ]);
            $poin->save();
            $transaksi->update([
                'id_status_transaksi' => 7,
                'tgl_ambil' => now(),
            ]);
            $WA = new WAController;
            $WA->ambilAnggota($id_transaksi);
        }else{
            $transaksi->update([
                'id_status_transaksi' => 7,
                'tgl_ambil' => now(),
            ]);
            $WA = new WAController;
            $WA->ambilUser($id_transaksi);
        }
        return redirect('admin/transaksi')->with('success', 'Edit Status Sukses');
    }

    public function invoice($id){
        $transaksi = Transaksi::find($id);
        $transaksiDetail = TransaksiDetail::where('id_transaksi', $id)->get();
        $cabang = Cabang::find($transaksi->id_cabang);
        
        $data = ['transaksi' => $transaksi,
         'transaksiDetail' => $transaksiDetail,
         'cabang' => $cabang];
        $pdf = Pdf::loadView('transaksi.invoice', $data);
        $noTransaksi = Transaksi::where('id_transaksi', $id)->first()->no_transaksi;

        return $pdf->download($noTransaksi.'.pdf');
    }

    function transaksiNota($id){
        $transaksi = Transaksi::find($id);
        $transaksiDetail = TransaksiDetail::where('id_transaksi', $id)->get();
        $cabang = Cabang::find($transaksi->id_cabang);
        return view('transaksi.invoice', compact('transaksi', 'transaksiDetail', 'cabang'));
    }

    public function cekData($no){
        $transaksi = Transaksi::where('no_transaksi', $no);
        //dd($no);
        $transaksiDetil = TransaksiDetail::where('id_transaksi', $transaksi->first()->id_transaksi);
        if($transaksiDetil->count() == 0 && $transaksi->count('id_user') == 0){
            return redirect('admin/transaksi/create')->with('error', 'Layanan dan Pengguna Wajib Ditambah');
        }elseif($transaksiDetil->count() == 0){
            return redirect('admin/transaksi/create')->with('error', 'Layanan Wajib Ditambah');          
        }elseif($transaksi->count('id_user') == 0){
            return redirect('admin/transaksi/create')->with('error', 'Pengguna Wajib Ditambah');          
        }
    }

    public function poinAdmin(){  
        $user = 'Semua';
        $pengguna = User::whereIn("level", ["anggota"])->get();

        $tAktif = Poin::where("status", "tidak aktif")->pluck('id_transaksi');
        $aktif = Poin::where("status", "aktif")->pluck('id_transaksi');
        $cekSama = Poin::where("status", "tidak aktif")->whereIn("id_transaksi", $aktif)->pluck('id_poin');
        $poin = Poin::whereNotIn("id_poin", $cekSama)->orderBy('id_user', 'asc')->orderBy('status', 'asc')->orderBy('tgl_tenggat', 'asc')->get();
        return view('transaksi.poin', compact('poin', 'user', 'pengguna'));
    }

    public function poinUser(){  
        $poin = Poin::where('id_user', Auth::user()->id_user)->orderBy('status', 'asc')->orderBy('tgl_tenggat', 'asc')->get();
        $user = User::find(Auth::user()->id_user);
        return view('transaksi.poin', compact('poin', 'user'));
    }

    public function poinRequest(Request $request){  
        if($request->nama == "Semua"){
            return redirect('admin/poin');          
        }

        $user = User::find($request->nama);
        $pengguna = User::whereIn("level", ["pelanggan", "anggota"])->get();
        $transaksi = Transaksi::orderBy('id_transaksi', 'desc')->where('id_status_transaksi', 7)->where('id_user', $request->nama)->get();
        $poin = Poin::where('id_user', $request->nama)->orderBy('status', 'asc')->orderBy('tgl_tenggat', 'asc')->get();
        $sum = Poin::where('id_user', $request->nama)->where('status', 'aktif')->sum('jumlah');
        return view('transaksi.poin', compact('poin', 'user', 'transaksi', 'pengguna', 'sum'));
    }

    // function poinUpdate($id_user, $poinValue){
    //     //dd("+ ".$poin);

    //     $poin = Poin::where('id_user', $id_user)->where('status', 'aktif')->orderBy('tgl_tenggat', 'asc')->select('id_poin')->get();
    //     $temp = $poinValue;
    //     foreach($poin as $key => $value){
    //         //1
    //         $poinSyn = Poin::where('id_poin', $value->id_poin);

    //         $jumlah[$key] = $poinSyn->first()->jumlah;
    //         $tanggal[$key] = $poinSyn->first()->tgl_tenggat;
    //         $id_transaksi[$key] = $poinSyn->first()->id_transaksi;
    //         $temp = $temp - $jumlah[$key];
    //         $poinSyn->update([//ngubah status || A pasti ke TA
    //             'status' => 'tidak aktif'
    //         ]);
    //         if($temp == 0){ // tidak ada sisa keluar
    //             break;
    //         }
    //         elseif($temp < 0){ // kalo sisa minus bikin baris baru
    //             $temp = $temp * -1;
    //             $tanggalx = $tanggal[$key];
    //             $id_transaksix = $id_transaksi[$key];
    //             $poinNew = new Poin([
    //                 'id_transaksi' =>$id_transaksix,
    //                 'id_user' => $id_user,
    //                 'jumlah' => $temp,
    //                 'tgl_tenggat' => $tanggalx,
    //                 'status' => "aktif"
    //             ]);
    //             $poinNew->save();
    //             $id_poin = Poin::where('id_transaksi', $id_transaksix)->max('id_poin');
    //             Transaksi::where('id_transaksi', $id_transaksix)->update([
    //                 'id_poin' => $id_poin,
    //             ]);
    //             break;
    //         }
    //         //kalo sisa plus ngulang ke 1
    //     }

    //     $poinTA = Poin::where('id_user', $id_user)->where('status', 'tidak aktif')->where('tgl_tenggat', '>', Carbon::parse(now()->format('Y-m-d')))->select('id_transaksi')->groupBy('id_transaksi')->orderBy('tgl_tenggat', 'desc')->get();
    //     //dd($poinTA);
    //     foreach($poinTA as $key => $value){
    //         $value->poinMax = Poin::where('id_transaksi', $value->id_transaksi)->max('jumlah');
    //         $value->idPoinTA = Poin::where('id_transaksi', $value->id_transaksi)->where('jumlah', $value->poinMax)->first()->id_poin;

    //         if (Poin::where('id_transaksi', $value->id_transaksi)->where('status', 'aktif')->get()->isEmpty()){
    //             if(Poin::where('id_transaksi', $value->id_transaksi)->where('status', 'tidak aktif')->count() > 1){
    //                 Transaksi::where('id_transaksi', $value->id_transaksi)->update([//ngubah status
    //                     'id_poin' => $value->idPoinTA
    //                 ]);
    //                 Poin::where('id_transaksi', $value->id_transaksi)->whereNot('jumlah', $value->poinMax)->where('status', 'tidak aktif')->delete();
    //             }
    //         }
    //     }
    // }

    // function poinUpdateLower($id_user, $poinValue){
    //     //dd("- ".$poin);
    //     $poinTA = Poin::where('id_user', $id_user)->where('status', 'tidak aktif')->where('tgl_tenggat', '>', Carbon::parse(now()->format('Y-m-d')))->select('id_transaksi')->groupBy('id_transaksi')->orderBy('tgl_tenggat', 'desc')->get();
    //     //dd($poinTA);
    //     // foreach($poinTA as $key => $value){
            
    //     //     $value->poinMax = Poin::where('id_transaksi', $value->id_transaksi)->max('jumlah');
    //     //     if (Poin::where('id_transaksi', $value->id_transaksi)->where('status', 'aktif')->get()->isEmpty()){
    //     //         Poin::whereNot('jumlah', $value->poinMax)->where('status', 'tidak aktif')->delete();
    //     //     }
    //     // }
    //     //dd($poinTA);
    //     $temp = $poinValue;
        
    //     $string = 'mulai '.$temp.'<br />';
    //     foreach($poinTA as $key => $value){
    //         //1 $poinValue = minus
    //         $value->poinMax = Poin::where('id_transaksi', $value->id_transaksi)->max('jumlah');
    //         $value->tanggal = Poin::where('id_transaksi', $value->id_transaksi)->first()->tgl_tenggat;
    //         $value->idPoinTA = Poin::where('id_transaksi', $value->id_transaksi)->where('jumlah', $value->poinMax)->first()->id_poin;

    //         if(Poin::where('id_transaksi', $value->id_transaksi)->where('status', 'aktif')->get()->isEmpty()){
    //             $value->idPoinA = null;
    //         }else{
    //             $value->idPoinA = Poin::where('id_transaksi', $value->id_transaksi)->where('status', 'aktif')->first()->id_poin;
    //         }

    //         if($value->idPoinA != null){
    //             $value->PoinA = Poin::where('id_transaksi', $value->id_transaksi)->where('status', 'aktif')->first()->jumlah;
    //             $value->selisih = $value->poinMax - $value->PoinA;
    //         }else{
    //             $value->PoinA = null;
    //             $value->selisih = null;
    //         }

    //         if($value->selisih != null){ //kalo ada selisih
    //             $temp = $temp + $value->selisih;
    //             if($temp == 0){// tidak sisa MUMETT
    //                 //BIKIN status TA jadi A, A jadi TA
    //                 Poin::where('id_poin', $value->idPoinTA)->update([//ngubah status
    //                     'status' => 'aktif'
    //                 ]);
    //                 Poin::where('id_poin', $value->idPoinA)->update([//ngubah status
    //                     'status' => 'tidak aktif'
    //                 ]);
    //                 //ganti id poin di tabel transaksi
    //                 Transaksi::where('id_transaksi', $value->id_transaksi)->update([
    //                     'id_poin' => $value->idPoinTA,
    //                 ]);
    //                 //hapus yang jadi tidak aktif
    //                 Poin::where('id_transaksi', $value->id_transaksi)->whereNot('id_poin', $value->idPoinTA)->delete();
    //                 $string = $string.' sel1 ';
    //                 break;
    //             }elseif($temp > 0){// sisa plus
    //                 //Bikin status A jadi TA, bikin baris baru A + $temp
    //                 Poin::where('id_poin', $value->idPoinA)->update([//ngubah status
    //                     'status' => 'tidak aktif'
    //                 ]);
    //                 $poinNew = new Poin([
    //                     'id_transaksi' =>$value->id_transaksi,
    //                     'id_user' => $id_user,
    //                     'jumlah' => $value->PoinA + $temp,
    //                     'tgl_tenggat' => $value->tanggal,
    //                     'status' => "aktif"
    //                 ]);
    //                 $poinNew->save();
    //                 //ganti id poin di tabel transaksi
    //                 $id_poin = Poin::where('id_transaksi', $value->id_transaksi)->max('id_poin');
    //                 Transaksi::where('id_transaksi', $value->id_transaksi)->update([
    //                     'id_poin' => $id_poin,
    //                 ]);
    //                 $string = $string.' sel2 ';
    //                 break;
    //             }elseif($temp < 0){// sisa masih minus
    //                 //BIKIN status TA jadi A, A jadi TA
    //                 Poin::where('id_poin', $value->idPoinTA)->update([//ngubah status
    //                     'status' => 'aktif'
    //                 ]);
    //                 Poin::where('id_poin', $value->idPoinA)->update([//ngubah status
    //                     'status' => 'tidak aktif'
    //                 ]);
    //                 //ganti id poin di tabel transaksi
    //                 Transaksi::where('id_transaksi', $value->id_transaksi)->update([
    //                     'id_poin' => $value->idPoinTA,
    //                 ]);
    //                 //hapus yang jadi tidak aktif
    //                 Poin::findorfail($value->idPoinA)->delete();
    //                 $string = $string.' selMINUS '.$temp.' id'.$value->id_transaksi.'<br />';
    //             }
    //             //ngulang ke 1

    //         }else{ //kalo engga ada selisih
    //             $temp = $temp + $value->poinMax;
    //             if($temp == 0){// tidak sisa
    //                 //BIKIN status TA jadi A
    //                 Poin::where('id_poin', $value->idPoinTA)->update([//ngubah status
    //                     'status' => 'aktif'
    //                 ]);
    //                 //ganti id poin di tabel transaksi
    //                 Transaksi::where('id_transaksi', $value->id_transaksi)->update([
    //                 'id_poin' => $value->idPoinTA,
    //                 ]);
    //                 $string = $string.' 1 ';
    //                 break;
    //             }elseif($temp > 0){// sisa positif
    //                 //Bikin bikin baris baru A jumlah $temp
    //                 $poinNew = new Poin([
    //                     'id_transaksi' =>$value->id_transaksi,
    //                     'id_user' => $id_user,
    //                     'jumlah' => $value->poinMax - $temp,
    //                     'tgl_tenggat' => $value->tanggal,
    //                     'status' => "aktif"
    //                 ]);
    //                 $poinNew->save();
    //                 //ganti id poin di tabel transaksi
    //                 $id_poin = Poin::where('id_transaksi', $value->id_transaksi)->max('id_poin');
    //                 Transaksi::where('id_transaksi', $value->id_transaksi)->update([
    //                 'id_poin' => $id_poin,
    //                 ]);
    //                 $string = $string.' 2 ';
    //                 break;
    //             }elseif($temp < 0){// sisa masih minus
    //                 //BIKIN status TA jadi A
    //                 Poin::where('id_poin', $value->idPoinTA)->update([//ngubah status
    //                     'status' => 'aktif'
    //                 ]);
    //                 //ganti id poin di tabel transaksi
    //                 Transaksi::where('id_transaksi', $value->id_transaksi)->update([
    //                 'id_poin' => $value->idPoinTA,
    //                 ]);
    //                 $string = $string.' MINUS '.$temp.' id'.$value->id_transaksi.'<br />';
    //             }
    //         }
    //         //kalo minus ngulang ke 1
    //     }
    
    //     return [$string,$poinTA];
    //     //dd($poinTA, $temp);
    // }
}
