<?php

namespace App\Http\Controllers\Api;

use App\Models\Kategori;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\KategoriResource;
use Illuminate\Support\Facades\Storage;

class KategoriController extends Controller
{
    public function index()
    {
        $kategori = Kategori::latest()->paginate(5);

        return new KategoriResource(true, 'List Data Posts', $kategori);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'deskripsi'  => 'required',
            'kategori'     => 'required|in:M,A,BHP,BTHP',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                             ->withErrors($validator)
                             ->withInput();
        }

        $kategori = Kategori::create([
            'deskripsi' => $request->deskripsi,
            'kategori' => $request->kategori,
        ]);

        return new KategoriResource(true, 'Data Kategori Berhasil Ditambahkan!', $kategori);
    }
    
    public function show($id)
    {
        $kategori = Kategori::findOrFail($id);

        return new KategoriResource(true, 'Detail Data Kategori!', $kategori);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'deskripsi'  => 'required',
            'kategori'     => 'required|in:M,A,BHP,BTHP',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        
        $rsetKategori = Kategori::findOrFail($id);
        
        $rsetKategori->update([
            'deskripsi'  => $request->kategori,
            'kategori'     => $request->kategori,
        ]);

        return new KategoriResource(true, 'Data Kategori Berhasil Diubah!', $rsetKategori);
    }

    public function destroy($id)
    {
        $kategori = Kategori::find($id);
        $kategori->delete();

        return new KategoriResource(true, 'Data Kategori Berhasil Dihapus!', null);
    }
}