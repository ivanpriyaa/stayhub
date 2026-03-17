<?php

namespace App\Http\Controllers;

use App\Models\Pic;
use Illuminate\Http\Request;

class PicController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->search;

        $pic = Pic::when($search, function ($query, $search) {
            return $query->where('nama_userpic', 'like', "%$search%")
                ->orWhere('nama_agen', 'like', "%$search%");
        })->orderBy('idpic', 'desc')
            ->paginate(10);

        return view('pic', compact('pic'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function tambah_pic()
    {
        return view('tambah_pic');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $pic = Pic::latest()->first();

        if (!$pic) {
            $kode = 'PIC0001';
        } else {

            $ambil = substr($pic->idpic, 3);
            $nomor = (int) $ambil + 1;

            $kode = 'PIC' . str_pad($nomor, 4, "0", STR_PAD_LEFT);
        }

        Pic::create([
            'idpic' => $kode,
            'pic' => $request->pic,
            'nama_agen' => $request->nama_agen,
        ]);

        return redirect('/PIC');
    }

    /**
     * Display the specified resource.
     */
    public function edit_pic($id)
    {
        $pic = Pic::find($id);
        return view('edit_pic', compact('pic'));
    }

    public function update_pic(Request $request, $id)
    {
        $pic = Pic::find($id);

        $pic->update([
            'pic' => $request->pic,
            'nama_agen' => $request->nama_agen,
        ]);

        return redirect('/PIC');
    }

    public function destroy_pic($id)
    {
        $pic = Pic::find($id);
        $pic->delete();

        return redirect('/PIC');
    }
}
