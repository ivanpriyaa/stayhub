<?php

namespace App\Http\Controllers;

use App\Models\Villa;
use Illuminate\Http\Request;

class VillaController extends Controller
{
    public function villa(Request $request)
    {
        $search = $request->search;

        $villa = Villa::when($search, function ($query, $search) {
            return $query->where('nama_villa', 'like', "%$search%")
                ->orWhere('alamat_villa', 'like', "%$search%");
        })
            ->paginate(10);

        return view('villa', compact('villa'));
    }
    public function tambah_villa()
    {
        return view('tambah_villa');
    }

    public function store(Request $request)
    {
        $villa = Villa::latest()->first();

        if (!$villa) {
            $kode = 'VLL0001';
        } else {

            $ambil = substr($villa->idvilla, 3);
            $nomor = (int) $ambil + 1;

            $kode = 'VLL' . str_pad($nomor, 4, "0", STR_PAD_LEFT);
        }

        Villa::create([
            'idvilla' => $kode,
            'nama_villa' => $request->nama_villa,
            'harga_villa' => $request->harga_villa,
            'alamat_villa' => $request->alamat_villa
        ]);

        return redirect('/villa');
    }

    public function edit_villa($id)
    {
        $villa = Villa::find($id);
        return view('edit_villa', compact('villa'));
    }

    public function update_villa(Request $request, $id)
    {
        $villa = Villa::find($id);

        $villa->update([
            'nama_villa' => $request->nama_villa,
            'harga_villa' => $request->harga_villa,
            'alamat_villa' => $request->alamat_villa
        ]);

        return redirect('/villa');
    }

    public function destroy_villa($id)
    {
        $villa = Villa::find($id);
        $villa->delete();

        return redirect('/villa');
    }
}
