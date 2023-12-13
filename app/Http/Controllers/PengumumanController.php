<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengumuman;
use RealRashid\SweetAlert\Facades\Alert;
use Session;

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
            'judul.required' => 'judul wajib diisi',
            'judul.unique' => 'judul sudah terpakai',
            'deskripsi.required' => 'deskripsi wajib diisi',
            'diskon.required' => 'diskon wajib diisi',
        ]);

        $pengumuman = new Pengumuman([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'diskon' => $request->diskon,
            'status' => "aktif"
        ]);
        $pengumuman->save();
        return redirect('admin/pengumuman')->with('success', 'Tambah Pengumuman Sukses');
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
            'judul.required' => 'judul wajib diisi',
            'deskripsi.required' => 'deskripsi wajib diisi',
            'diskon.required' => 'diskon wajib diisi',
        ]);

        $pengumuman->update($request->all());
        return redirect('admin/pengumuman')->with('success', 'Edit Pengumuman Sukses');
    }

    public function delete( $id){  
        $pengumuman = Pengumuman::findorfail($id)->delete();
        return redirect('admin/pengumuman')->with('success', 'Hapus Pengumuman Sukses');
    }
}
