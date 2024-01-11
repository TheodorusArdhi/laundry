<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengumuman;
use RealRashid\SweetAlert\Facades\Alert;
use Session;
use App\Models\User;
use Carbon\Carbon;
use App\Models\Poin;

class PengumumanController extends Controller
{
    public function index(){  
        $pengumuman = Pengumuman::all();
        $title = 'Yakin Hapus Pengumuman ?';
        confirmDelete($title);

        
        return view('pengumuman.index', compact('pengumuman'));
    }

    public function create(){  
        return view('pengumuman.create');
    }

    public function store(Request $request){

        Session::flash('judul', $request->judul);
        Session::flash('deskripsi', $request->deskripsi);
        Session::flash('diskon', $request->diskon);

        $request->validate([
            'judul'=>'required|unique:pengumuman',
            'deskripsi'=>'required',
            'diskon'=>'required',
        ], [
            'judul.required' => 'judul Wajib Diisi',
            'judul.unique' => 'judul Sudah Terpakai',
            'deskripsi.required' => 'deskripsi Wajib Diisi',
            'diskon.required' => 'diskon Wajib Diisi',
        ]);

        $pengumuman = new Pengumuman([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'diskon' => $request->diskon,
            'status' => "aktif"
        ]);
        $pengumuman->save();
        return redirect('owner/pengumuman')->with('success', 'Tambah Pengumuman Sukses');
    }

    public function edit($id){  
        $pengumuman = Pengumuman::findorfail($id);
        return view('pengumuman.edit', compact('pengumuman'));
    }

    public function update(Request $request, $id){  
        $pengumuman = Pengumuman::findorfail($id);

        $request->validate([
            'judul'=>'required',
            'deskripsi'=>'required',
            'diskon'=>'required',
        ], [
            'judul.required' => 'judul Wajib Diisi',
            'deskripsi.required' => 'deskripsi Wajib Diisi',
            'diskon.required' => 'diskon Wajib Diisi',
        ]);

        $pengumuman->update($request->all());
        return redirect('owner/pengumuman')->with('success', 'Edit Pengumuman Sukses');
    }

    public function delete($id){  
        Pengumuman::find($id)->delete();
        return redirect('owner/pengumuman')->with('success', 'Hapus Pengumuman Sukses');
    }

    public function indexSiaran(){  
        return view('pengumuman.siaran');
    }

    public function siaran(Request $request){ 
        $request->validate([
            'pesan'=>'required',
        ], [
            'pesan.required' => 'Pesan Wajib Diisi',
        ]);
        // $telp = User::select('no_telp')->get();
        // foreach($telp as $key => $value){
        //     $temp[$key] = $value->no_telp;
        // }
        // $no_telp = implode(',', $temp);
        $user = User::where('level', 'pengguna')->select('id_user')->get();
        foreach($user as $value){
            $WA = new WAController;
            $WA->broadcast($value->id_user, $request->pesan);
        }
        return redirect('owner/pengumuman')->with('success', 'Siaran Pengumuman Sukses');
    }
}
