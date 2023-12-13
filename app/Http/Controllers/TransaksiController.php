<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\TransaksiDetail;
use App\Models\User;
use App\Models\Pengumuman;
use App\Models\Layanan;
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
        $transaksi = Transaksi::with('pengumuman', 'user', 'admin', 'statusPembayaran', 'statusTransaksi')->orderBy('id_transaksi', 'desc')->get();
        return view('transaksi.index', compact('transaksi'));
    }

    public function data(){        
        if ( Transaksi::where('tgl_masuk', date('Y-m-d'))->count() == 0 ){
            $noTransaksiBaru = "SL".date('ymd').'-001';
        } else {
            $noTransaksi = explode('-', Transaksi::latest()->first()->no_transaksi);
            $noTransaksiBaru = "SL".date('ymd').'-'. sprintf("%03s",$noTransaksi[1]+1);
        }

        $transaksi = new Transaksi([
            'id_admin' => Auth::user()->id_user,
            'no_transaksi' => $noTransaksiBaru,
            'tgl_masuk' => date('Y-m-d'),
            'total_harga' => 0,
            'total_tagihan' => 0,
            'diterima' => 0,
            'komplain' => '-',
        ]);
        $transaksi->save();
        session(['id_transaksi' => $transaksi->id_transaksi]);
        return redirect('admin/transaksi/create');        
    }

    public function create(){  
        $del = 'Yakin Hapus Layanan?';
        confirmDelete($del);
        $id_transaksi = session('id_transaksi');
        $pengguna = User::where("level", "pengguna")->get();
        $pengumuman = Pengumuman::where("status", "aktif")->get();
        $layanan = Layanan::where("status", "aktif")->get();
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
        return view('transaksi.create', compact('pengguna', 'pengumuman', 'layanan', 'transaksi', 'detail'));
    }

    public function editAdmin($id){  
        $del = 'Yakin Hapus Layanan?';
        confirmDelete($del);
        $transaksiDetail = TransaksiDetail::with('layanan')->where('id_transaksi', $id)->get();
        $pengguna = User::where("level", "pengguna")->get();
        $pengumuman = Pengumuman::where("status", "aktif")->get();
        $layanan = Layanan::where("status", "aktif")->get();

        $totalHarga = TransaksiDetail::where('id_transaksi', $id)->sum('subtotal');
        $diskon = Transaksi::where('id_transaksi', $id)->first()->diskon;
        $poinKeluar = Transaksi::where('id_transaksi', $id)->first()->poin_keluar;
        $totalTagihan = $totalHarga - $poinKeluar - ($diskon/100 * $totalHarga);
        Transaksi::where('id_transaksi', $id)->update([ 
            'total_harga' => $totalHarga,
            'total_tagihan' => $totalTagihan
        ]);

        $transaksi = Transaksi::with('user')->find($id);
        return view('transaksi.edit', compact('transaksi', 'transaksiDetail', 'pengguna', 'pengumuman', 'layanan'));
    }

    public function editUser($id){  
        $transaksi = Transaksi::with('pengumuman', 'user', 'admin')->find($id);
        $transaksiDetail = TransaksiDetail::with( 'layanan')->where('id_transaksi', $id)->get();
        return view('transaksi.edit', compact('transaksi', 'transaksiDetail'));
    }

    public function store(Request $request){ 
        $id = Transaksi::where('no_transaksi', $request->no_transaksi)->first()->id_transaksi;
        Session::flash('diterima', $request->diterima);
        if(TransaksiDetail::where('id_transaksi', $id)->count() == 0 && Transaksi::where('id_transaksi', $id)->count('id_user') == 0){
            return redirect('admin/transaksi/create')->with('error', 'Layanan dan Pengguna Wajib Ditambah');          
        }elseif(TransaksiDetail::where('id_transaksi', $id)->count() == 0){
            return redirect('admin/transaksi/create')->with('error', 'Layanan Wajib Ditambah');          
        }elseif(Transaksi::where('id_transaksi', $id)->count('id_user') == 0){
            return redirect('admin/transaksi/create')->with('error', 'Pengguna Wajib Ditambah');          
        }

        if($request->diterima < $request->total_tagihan){
            $status = 2;
            $diterima = 0;
        }else{
            $status = 1;
            $diterima = $request->diterima;
        }

        if($request->total_tagihan == 0){
            $status = 1;
            $poinKeluar = $request->total_tagihan_ori;
        }else{
            $poinKeluar = $request->poin;
        }
        $poinMasuk = ($request->total_tagihan / 100) + 100;

        $details = TransaksiDetail::where('id_transaksi', $id)->select('id_layanan')->get();
        foreach ($details as $g => $f) {
            $layanan[$g] = Layanan::where('id_layanan', $f->id_layanan)->first('durasi');
        }
        $tgl_masuk = Transaksi::where('id_transaksi', $id)->first('tgl_masuk');
        $max = max($layanan);

        $update = [
            'id_status_pembayaran' => $status,
            'id_status_transaksi' => 3,
            'tgl_selesai' => date('Y-m-d', strtotime($tgl_masuk->tgl_masuk. ' + '.$max->durasi.' days')),
            'tgl_ambil' => null,
            'tgl_tenggat' => date('Y-m-d', strtotime($tgl_masuk->tgl_masuk. ' + '.$max->durasi + 30 .' days')),
            'total_harga' => $request->total_harga,
            'total_tagihan' => $request->total_tagihan,
            'diterima' => $diterima,
            'poin_masuk' => $poinMasuk,
            'poin_keluar' => $poinKeluar,
            'komplain' => '-',
        ];
        
        Transaksi::where('id_transaksi', $id)->update($update);
        $WA = new WAController;
        $WA->transaksi($id);
        return redirect('admin/transaksi')->with('success', 'Tambah Transaksi Sukses');
    }

    public function update(Request $request, $id){ 
        if(TransaksiDetail::where('id_transaksi', $id)->count() == 0 && Transaksi::where('id_transaksi', $id)->count('id_user') == 0){
            return redirect('admin/transaksi/create')->with('error', 'Layanan dan Pengguna Wajib Ditambah');          
        }elseif(TransaksiDetail::where('id_transaksi', $id)->count() == 0){
            return redirect('admin/transaksi/create')->with('error', 'Layanan Wajib Ditambah');          
        }elseif(Transaksi::where('id_transaksi', $id)->count('id_user') == 0){
            return redirect('admin/transaksi/create')->with('error', 'Pengguna Wajib Ditambah');          
        }

        if($request->diterima < $request->total_tagihan){
            $status = 2;
            $diterima = 0;
        }else{
            $status = 1;
            $diterima = $request->diterima;
        }

        if($request->poin > $request->total_tagihan){
            $status = 1;
            $poinKeluar = $request->total_tagihan_ori;
        }else{
            $poinKeluar = $request->poin;
        }
        $poinMasuk = ($request->total_tagihan / 100) + 100;

        $details = TransaksiDetail::where('id_transaksi', $id)->select('id_layanan')->get();
        foreach ($details as $g => $f) {
            $layanan[$g] = Layanan::where('id_layanan', $f->id_layanan)->first('durasi');
        }
        $tgl_masuk = Transaksi::where('id_transaksi', $id)->first('tgl_masuk');
        $max = max($layanan);

        $update = [
            'id_status_pembayaran' => $status,
            'tgl_selesai' => date('Y-m-d', strtotime($tgl_masuk->tgl_masuk. ' + '.$max->durasi.' days')),
            'tgl_ambil' => null,
            'tgl_tenggat' => date('Y-m-d', strtotime($tgl_masuk->tgl_masuk. ' + '.$max->durasi + 30 .' days')),
            'total_harga' => $request->total_harga,
            'total_tagihan' => $request->total_tagihan,
            'diterima' => $diterima,
            'poin_masuk' => $poinMasuk,
            'poin_keluar' => $poinKeluar,
            'komplain' => '-',
        ];
        Transaksi::where('id_transaksi', $id)->update($update);
        return redirect('admin/transaksi')->with('success', 'Edit Transaksi Sukses');
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
        $request->validate([
            'nama'=>'required',
        ], [
            'nama.required' => 'Nama Belum Terisi',
        ]);
        Transaksi::findOrFail($request->id_transaksi)->update([ 'id_user' => $request->nama]);
        return redirect('admin/transaksi/create')->with('success', 'Tambah Pengguna Sukses');
    }

    public function poinEdit(Request $request, $id){ 
        $request->validate([
            'nama'=>'required',
        ], [
            'nama.required' => 'Nama Belum Terisi',
        ]);
        Transaksi::findOrFail($request->id_transaksi)->update([ 'id_user' => $request->nama]);
        return redirect()->route('editAdmin', $id)->with('success', 'Tambah Pengguna Sukses');
    }

    public function delete($id){  
        TransaksiDetail::where('id_transaksi', $id)->delete();
        Transaksi::find($id)->delete();
        return redirect('admin/transaksi')->with('success', 'Hapus Transaksi Sukses');
    }

    public function lunas($id){
        $totalTagihan = Transaksi::where('id_transaksi', $id)->first()->total_tagihan;
        Transaksi::where('id_transaksi', $id)->update([
            'id_status_pembayaran' => 1,
            'diterima' => $totalTagihan,
        ]);
        return redirect('admin/transaksi')->with('success', 'Edit Status Sukses');
    }

    public function ambil($id){
        Transaksi::where('id_transaksi', $id)->update([
            'id_status_transaksi' => 7,
            'tgl_ambil' => now(),
        ]);
        $id_user = Transaksi::where('id_transaksi', $id)->first()->id_user;
        $poinKeluar = Transaksi::where('id_transaksi', $id)->first()->poin_keluar;
        $poinMasuk = Transaksi::where('id_transaksi', $id)->first()->poin_masuk;
        $user = User::where('id_user', $id_user);
        $user->update([ 'poin' => $user->first()->poin - $poinKeluar + $poinMasuk]);
        return redirect('admin/transaksi')->with('success', 'Edit Status Sukses');
    }

    function invoice($id){
        $transaksi = Transaksi::find($id);
        $transaksiDetail = TransaksiDetail::where('id_transaksi', $id)->get();
        $data = ['transaksi' => $transaksi,
         'transaksiDetail' => $transaksiDetail];
        $pdf = Pdf::loadView('transaksi.invoice', $data);

        $noTransaksi = Transaksi::where('id_transaksi', $id)->first()->no_transaksi;

        return $pdf->download($noTransaksi.'.pdf');
    }

    function transaksiNota($id){
        $transaksi = Transaksi::find($id);
        $transaksiDetail = TransaksiDetail::where('id_transaksi', $id)->get();
        return view('transaksi.invoice', compact('transaksi', 'transaksiDetail'));
    }
}
