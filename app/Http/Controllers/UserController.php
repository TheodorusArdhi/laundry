<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Layanan;
use App\Models\Pengumuman;
use App\Models\Transaksi;
use App\Models\TransaksiDetail;
use Auth;
use Session;
use Barryvdh\DomPDF\Facade\Pdf;

class UserController extends Controller
{
    public function dashboard(){   
        $transaksi = Transaksi::count();
        $proses = Transaksi::where('id_status_transaksi', 3)->count();
        $diambil = Transaksi::where('id_status_transaksi', 7)->count();
        $batasWaktu = Transaksi::where('id_status_transaksi', 6)->count();
        return view('dashboard', compact('transaksi', 'proses', 'diambil', 'batasWaktu'));
    }

    public function home(){ 
        $layanan = Layanan::all();
        $pengumuman = Pengumuman::all();

        return view('home', compact('layanan', 'pengumuman'));
    }

    public function profile(){  
        $user = User::find(Auth::id());
        return view('profile', compact('user'));
    }

    public function editProfile(Request $request){  
        //dd($request);
        $request->validate([
            'nama'=>'required',
            'email'=>'required',
            'no_telp'=>'required',
        ], [
            'nama.required' => 'nama wajib diisi',
            'email.required' => 'email wajib diisi',
            'no_telp.required' => 'nomor telepon wajib diisi'
        ]);

        $user = User::find(Auth::id());
        $user->nama = $request->nama;
        $user->email = $request->email;
        $user->no_telp = $request->no_telp;
        $user->notifikasi = $request->notifikasi;
        $user->save();
        return redirect('profile')->with('success', 'Ubah Profil Sukses');
    }

    public function transaksiPengguna(){  
        $title = 'Pengguna';
        $transaksi = Transaksi::with('pengumuman', 'user', 'admin', 'statusPembayaran', 'statusTransaksi')->where('id_user', Auth::user()->id_user)->get();
        return view('transaksi.tampilTransaksi', compact('transaksi', 'title'));
    }

    public function lihatTransaksiPengguna($id){  
        $transaksi = Transaksi::find($id);
        $transaksiDetail = TransaksiDetail::with('layanan')->where('id_transaksi', $id)->get();
        return view('transaksi.editTransaksi', compact('transaksi', 'transaksiDetail'));
    }

    function transaksiNota($id){
        $transaksi = Transaksi::find($id);
        $transaksiDetail = TransaksiDetail::where('id_transaksi', $id)->get();
        return view('transaksi.nota', compact('transaksi', 'transaksiDetail'));
    }

    function transaksiUnduh($id){
        $transaksi = Transaksi::find($id);
        $transaksiDetail = TransaksiDetail::where('id_transaksi', $id)->get();
        $data = ['transaksi' => $transaksi,
         'transaksiDetail' => $transaksiDetail];
        $pdf = Pdf::loadView('transaksi.nota', $data);
        $noTransaksi = Transaksi::where('id_transaksi', $id)->first()->no_transaksi;
        return $pdf->download($noTransaksi.'.pdf');
    }
}
