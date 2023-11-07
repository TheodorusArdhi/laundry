<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Layanan;
use App\Models\User;
use App\Models\Pengumuman;
use App\Models\Transaksi;
use App\Models\TransaksiDetail;
use App\Models\Status;
use Session;
Use Illuminate\Support\Facades\Hash;
use Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Str;
use Form;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function pengumuman(){  
        $pengumuman = Pengumuman::all();
        $title = 'Yakin Hapus Pengumuman ?';
        confirmDelete($title);
        return view('pengumuman.tampilPengumuman', compact('pengumuman'));
    }

    public function tambahPengumuman(){  
        return view('pengumuman.inputPengumuman');
    }

    public function postPengumuman(Request $request){

        Session::flash('judul', $request->judul);
        Session::flash('deskripsi', $request->deskripsi);
        Session::flash('diskon', $request->diskon);

        $request->validate([
            'judul'=>'required|unique:pengumuman',
            'deskripsi'=>'required',
            'diskon'=>'required',
        ], [
            'judul.required' => 'judul wajib diisi',
            'judul.unique' => 'judul sudah terpakai',
            'deskripsi.required' => 'deskripsi wajib diisi',
            'diskon.required' => 'diskon wajib diisi',
        ]);

        $pengumuman = new Pengumuman([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'diskon' => $request->diskon,
        ]);
        $pengumuman->save();
        return redirect('pengumuman')->with('success', 'Tambah Pengumuman Sukses');
    }

    public function editPengumuman($id){  
        $temp = Pengumuman::findorfail($id);
        return view('pengumuman.editPengumuman', compact('temp'));
    }

    public function updatePengumuman(Request $request, $id){  
        $temp = Pengumuman::findorfail($id);

        Session::flash('judul', $request->judul);
        Session::flash('deskripsi', $request->deskripsi);
        Session::flash('diskon', $request->diskon);

        $request->validate([
            'judul'=>'required|unique:pengumuman',
            'deskripsi'=>'required',
            'diskon'=>'required',
        ], [
            'judul.required' => 'judul wajib diisi',
            'judul.unique' => 'judul sudah terpakai',
            'deskripsi.required' => 'deskripsi wajib diisi',
            'diskon.required' => 'diskon wajib diisi',
        ]);

        $temp->update($request->all());
        return redirect('pengumuman')->with('success', 'Edit Pengumuman Sukses');
    }

    public function hapusPengumuman( $id){  
        $temp = Pengumuman::findorfail($id);
        $temp->delete();
        return redirect('pengumuman')->with('success', 'Hapus Pengumuman Sukses');
    }

// LAYANAN ||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
    public function layanan(){  
        $layanan = Layanan::all();
        $title = 'Yakin Hapus Layanan?';
        confirmDelete($title);
        return view('layanan.tampilLayanan', compact('layanan'));
    }

    public function tambahLayanan(){  
        return view('layanan.inputLayanan');
    }

    public function postLayanan(Request $request){

        Session::flash('nama', $request->nama);
        Session::flash('harga', $request->harga);
        Session::flash('durasi', $request->durasi);
        Session::flash('satuan', $request->satuan);

        $request->validate([
            'nama'=>'required',
            'harga'=>'required',
            'durasi'=>'required',
            'satuan'=>'required',
        ], [
            'nama.required' => 'nama wajib diisi',
            'harga.required' => 'harga wajib diisi',
            'durasi.required' => 'durasi wajib diisi',
            'satuan.required' => 'satuan wajib diisi',
        ]);

        $layanan = new Layanan([
            'nama' => $request->nama,
            'harga' => $request->harga,
            'durasi' => $request->durasi,
            'satuan' => $request->satuan
        ]);
        $layanan->save();
        return redirect('layanan')->with('success', 'Tambah Layanan Sukses');
    }

    public function editLayanan($id){  
        $temp = Layanan::findorfail($id);
        return view('layanan.editLayanan', compact('temp'));
    }

    public function updateLayanan(Request $request, $id){  
        $temp = Layanan::findorfail($id);

        Session::flash('nama', $request->nama);
        Session::flash('harga', $request->harga);
        Session::flash('durasi', $request->durasi);
        Session::flash('satuan', $request->satuan);

        $request->validate([
            'nama'=>'required',
            'harga'=>'required',
            'durasi'=>'required',
            'satuan'=>'required',
        ], [
            'nama.required' => 'nama wajib diisi',
            'harga.required' => 'harga wajib diisi',
            'durasi.required' => 'durasi wajib diisi',
            'satuan.required' => 'satuan wajib diisi',
        ]);

        $temp->update($request->all());
        return redirect('layanan')->with('success', 'Edit Layanan Sukses');
    }

    public function hapusLayanan( $id){  
        $temp = Layanan::findorfail($id);
        $temp->delete();
        return redirect('layanan')->with('success', 'Hapus Layanan Sukses');
    }

    // PENGGUNA ||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
    
    public function pengguna(){  
        $pengguna = User::all();
        $title = 'Yakin Hapus Pengguna?';
        confirmDelete($title);
        return view('pengguna.tampilPengguna', compact('pengguna'));
    }
    
    public function tambahPengguna(){  
        return view('pengguna.inputPengguna');
    }

    public function postPengguna(Request $request){

        Session::flash('nama', $request->nama);
        Session::flash('email', $request->email);
        Session::flash('no_telp', $request->no_telp);
        Session::flash('level', $request->level);

        $request->validate([
            'nama'=>'required',
            'email'=>'required|unique:users',
            'no_telp'=>'required',
            'level'=>'required',
        ], [
            'nama.required' => 'nama wajib diisi',
            'email.required' => 'email wajib diisi',
            'email.unique' => 'email sudah terpakai',
            'no_telp.required' => 'nomor telepon wajib diisi',
            'level.required' => 'level wajib diisi',
        ]);

        $user = new User([
            'nama' => $request->nama,
            'email' => $request->email,
            'no_telp' => $request->no_telp,
            'password' => Hash::make($request->email),
            'remember_token' => Str::random(60),
            'level' => $request->level,
        ]);
        $user->save();
        return redirect('pengguna')->with('success', 'Tambah Pengguna Sukses');
    }

    public function hapusPengguna($id){  
        $temp = User::findorfail($id);
        $temp->delete();
        return redirect('pengguna')->with('success', 'Hapus Pengguna Sukses');
    }

// TRANSAKSI ||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||

    public function transaksiAdmin(){  
        if(Transaksi::where('id_user', null)->count() != 0){
            $delete = Transaksi::where('id_user', null)->first()->id_transaksi;
            TransaksiDetail::where('id_transaksi', $delete)->delete();
            Transaksi::where('id_transaksi', $delete)->delete();
        }

        $title = "Admin";
        $transaksi = Transaksi::with('pengumuman', 'user', 'admin', 'statusPembayaran', 'statusTransaksi')->get();
        return view('transaksi.tampilTransaksi', compact('title', 'transaksi'));
    }

    public function tambahTransaksi(){
        
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
        return redirect('transaksiDetail');        
    }

    public function transaksiDetail(){  
        $del = 'Yakin Hapus Layanan?';
        confirmDelete($del);
        $id_transaksi = session('id_transaksi');
        $transaksi = Transaksi::with('pengumuman')->find($id_transaksi);
        $pengguna = User::where("level", "pengguna")->get();
        $pengumuman = Pengumuman::all();
        $layanan = Layanan::all();

        $transaksiDetail = TransaksiDetail::with([
            'layanan'
        ])->where('id_transaksi', $id_transaksi);
        $detail = $transaksiDetail->get();
        $total_harga = $transaksiDetail->sum('subtotal');

        return view('transaksi.inputTransaksi', compact('pengguna', 'pengumuman', 'layanan', 'transaksi', 'total_harga', 'detail'));
    }

    public function tambahTransaksiDetail(Request $request){  

        $request->validate([
            'layanan'=>'required',
            'jumlah'=>'required',
        ], [
            'layanan.required' => 'layanan wajib diisi',
            'jumlah.required' => 'jumlah wajib diisi',
        ]);

        $layanan = Layanan::where('id_layanan', $request['layanan'])->get();
        foreach ($layanan as $item){
            $id = $item->id_layanan;
            $nama = $item->name;
            $harga = $item->harga;
        }
        
        $subTotal = $request->jumlah * $harga;
        $no_transaksi = $request->no_transaksi;
        $id_transaksi = Transaksi::where('no_transaksi', $no_transaksi)->first('id_transaksi');

        $detail = TransaksiDetail::where([
            ['id_transaksi', '=', $id_transaksi->id_transaksi],
            ['id_layanan', '=', $id]
        ])->get();
       
        $transaksiDetail = [
            'id_transaksi' => $id_transaksi->id_transaksi, 
            'id_layanan' => $request->layanan, 
            'jumlah' => $request->jumlah, 
            'harga' => $harga, 
            'subtotal' => $subTotal
        ];

        if (!$detail->isEmpty()){
            foreach ($detail as $details){
                if ($details->id_layanan == $id){
                    $update = [
                        'jumlah' => $details->jumlah + $request->jumlah,
                        'subtotal' => $details->subtotal + $subTotal,
                    ];
                    TransaksiDetail::findOrFail($details->id_transaksi_detail)->update($update);
                }else{
                    TransaksiDetail::create($transaksiDetail);
                }
            }
        }else{
            TransaksiDetail::create($transaksiDetail);
        }

        $diskon = Transaksi::where('id_transaksi', $id_transaksi->id_transaksi)->first()->diskon;
        if($diskon != null){
            $totalHarga = TransaksiDetail::where('id_transaksi', $id_transaksi->id_transaksi)->sum('subtotal');
            $diskonValue = $diskon / 100 * $totalHarga;
            $update2 = [
                'total_harga' => $totalHarga,
                'total_tagihan' => $totalHarga - $diskonValue,
            ];
            Transaksi::findOrFail($id_transaksi->id_transaksi)->update($update2);
        }
        return redirect('transaksiDetail')->with('success', 'Tambah Layanan Sukses');   
    }

    public function diskon(Request $request){ 
        if($request->diskon == 0){
                $update = [
                    'id_pengumuman' => null,
                    'diskon' => null,
                    'total_tagihan' => 0,
                ];
                Transaksi::findOrFail($request->id_transaksi)->update($update);
            return redirect('transaksiDetail');
        }
        $diskon = Pengumuman::where('id_pengumuman', $request->diskon)->first('diskon');
        $diskonValue = $diskon->diskon / 100 * $request->total_harga;
        $update = [
            'id_pengumuman' => $request->diskon,
            'diskon' => $diskon->diskon,
            'total_tagihan' => $request->total_harga - $diskonValue,
        ];

        Transaksi::findOrFail($request->id_transaksi)->update($update);
        return redirect('transaksiDetail');
    }

    public function simpanTransaksi(Request $request){ 
        $no_transaksi = $request->no_transaksi;
        $id_transaksi = Transaksi::where('no_transaksi', $no_transaksi)->first('id_transaksi');

        if(TransaksiDetail::where('id_transaksi', $id_transaksi->id_transaksi)->count() == 0){
            return redirect('transaksiDetail')->with('error', 'layanan wajib ditambah');          
        }

        Session::flash('nama', $request->nama);
        $request->validate([
            'nama'=>'required',
        ], [
            'nama.required' => 'nama pengguna wajib diisi',
        ]);

        if($request->diterima == 0){
            $status = 2;
            $diterima = 0;
        }else{
            $status = 1;
            $diterima = $request->diterima;
        }

        $details = TransaksiDetail::where('id_transaksi', $id_transaksi->id_transaksi)->select('id_layanan')->get();
        foreach ($details as $g => $f) {
            $layanan[$g] = Layanan::where('id_layanan', $f->id_layanan)->first('durasi');
        }
        $tgl_masuk = Transaksi::where('no_transaksi', $no_transaksi)->first('tgl_masuk');
        $max = max($layanan);

        $update = [
            'id_user' => $request->nama,
            'id_status_pembayaran' => $status,
            'id_status_transaksi' => 3,
            'tgl_selesai' => date('Y-m-d', strtotime($tgl_masuk->tgl_masuk. ' + '.$max->durasi.' days')),
            'tgl_ambil' => null,
            'tgl_tenggat' => date('Y-m-d', strtotime($tgl_masuk->tgl_masuk. ' + '.$max->durasi + 21 .' days')),
            'total_harga' => $request->total_harga,
            'total_tagihan' => $request->total_tagihan,
            'diterima' => $diterima,
            'komplain' => '-',
        ];

        Transaksi::where('no_transaksi', $no_transaksi)->update($update);
        return redirect('transaksiAdmin')->with('success', 'Tambah Transaksi Sukses');
    }

    public function lihatTransaksi($id){  
        $transaksi = Transaksi::find($id);
        $transaksiDetail = TransaksiDetail::with('layanan')->where('id_transaksi', $id)->get();
        return view('transaksi.editTransaksi', compact('transaksi', 'transaksiDetail'));
    }

    public function updateTransaksiDetail(Request $request, $id){  
        $transaksi = TransaksiDetail::where('id_transaksi_detail', $id)->first()->id_transaksi;
        $diskon = Transaksi::where('id_transaksi', $transaksi)->first()->diskon;
        
        if($request->jumlah == 0){
            TransaksiDetail::findOrFail($id)->delete();
            if($diskon != null){
                $totalHarga = TransaksiDetail::where('id_transaksi', $transaksi)->sum('subtotal');
                $diskonValue = $diskon / 100 * $totalHarga;
                $update2 = [
                    'total_harga' => $totalHarga,
                    'total_tagihan' => $totalHarga - $diskonValue,
                ];
                Transaksi::findOrFail($transaksi)->update($update2);
            }
            return redirect('transaksiDetail')->with('success', 'Edit Layanan Sukses');
        }
        $update1 = [
            'jumlah' => $request->jumlah,
            'subtotal' => $request->jumlah * $request->harga,
        ];
        TransaksiDetail::findOrFail($id)->update($update1);

        if($diskon != null){
            $totalHarga = TransaksiDetail::where('id_transaksi', $transaksi)->sum('subtotal');
            $diskonValue = $diskon / 100 * $totalHarga;
            $update2 = [
                'total_harga' => $totalHarga,
                'total_tagihan' => $totalHarga - $diskonValue,
            ];
            Transaksi::findOrFail($transaksi)->update($update2);
        }
        return redirect('transaksiDetail')->with('success', 'Edit Layanan Sukses');
    }

    public function transaksiLunas($id){
        $totalTagihan = Transaksi::where('id_transaksi', $id)->first('total_tagihan');
        Transaksi::where('id_transaksi', $id)->update([
            'id_status_pembayaran' => 1,
            'diterima' => $totalTagihan->total_tagihan,
        ]);
        return redirect('transaksiAdmin')->with('success', 'Edit Status Sukses');
    }

    public function transaksiDiambil($id){
        Transaksi::where('id_transaksi', $id)->update([
            'id_status_transaksi' => 7,
            'tgl_ambil' => now(),
        ]);
        return redirect('transaksiAdmin')->with('success', 'Edit Status Sukses');
    }

    public function hapusTransaksiDetail($id){  
        $temp = TransaksiDetail::find($id);
        $temp->delete();
        return redirect('transaksiDetail')->with('success', 'Hapus Transaksi Sukses');
    }
}
