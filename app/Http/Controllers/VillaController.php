<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Villa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\VillaImage;

class VillaController extends Controller
{
    public function villa(Request $request)
    {
        $search = $request->search;

        $villa = Villa::when($search, function ($query, $search) {
            return $query->where('nama_villa', 'like', "%$search%")
                ->orWhere('alamat_villa', 'like', "%$search%");
        })->orderBy('idvilla', 'desc')
            ->paginate(10);

        return view('villa', compact('villa'));
    }
    public function tambah_villa()
    {
        return view('tambah_villa');
    }

    public function store(Request $request)
    {
        // validasi
        $request->validate([
            'nama_villa' => 'required',
            'harga_villa' => 'required|numeric',
            'alamat_villa' => 'required',
            'jumlah_kamar_tidur' => 'required|numeric',
            'deskripsi_villa' => 'nullable|string',
            'gambar_villa.*' => 'image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $villa = Villa::latest()->first();

        if (!$villa) {
            $kode = 'VLL0001';
        } else {

            $ambil = substr($villa->idvilla, 3);
            $nomor = (int) $ambil + 1;

            $kode = 'VLL' . str_pad($nomor, 4, "0", STR_PAD_LEFT);
        }
        $defaultImage = 'villa/default.jpg';
        $dataVilla = Villa::create([
            'idvilla' => $kode,
            'nama_villa' => $request->nama_villa,
            'harga_villa' => $request->harga_villa,
            'alamat_villa' => $request->alamat_villa,
            'jumlah_kamar_tidur' => $request->jumlah_kamar_tidur,
            'deskripsi_villa' => $request->deskripsi_villa ?? '',
            'gambar_villa' => $defaultImage
        ]);

        if ($request->hasFile('gambar_villa')) {
            foreach ($request->file('gambar_villa') as $index => $file) {
                try {
                    $path = $file->store('villa', 'public');

                    // Simpan ke tabel villa_images
                    VillaImage::create([
                        'villa_id' => $dataVilla->idvilla,
                        'gambar' => $path
                    ]);

                    // Set gambar pertama jadi thumbnail
                    if ($index == 0) {
                        $dataVilla->update(['gambar_villa' => $path]);
                    }
                } catch (\Exception $e) {
                    Log::error('Upload gagal: ' . $e->getMessage());
                }
            }
        }

        return redirect('/villa');
    }

    public function edit_villa($id)
    {
        $villa = Villa::with('images')->findOrFail($id);
        return view('edit_villa', compact('villa'));
    }

    public function update_villa(Request $request, $id)
    {
        $request->validate([
            'nama_villa' => 'required',
            'harga_villa' => 'required|numeric',
            'alamat_villa' => 'required',
            'gambar_villa.*' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $villa = Villa::findOrFail($id);

        // $villa = Villa::find($id);

        $villa->update([
            'nama_villa' => $request->nama_villa,
            'harga_villa' => $request->harga_villa,
            'alamat_villa' => $request->alamat_villa
        ]);

        if ($request->hasFile('gambar_villa')) {
            $files = $request->file('gambar_villa');

            if (!is_array($files)) {
                $files = [$files];
            }

            $isDefaultThumbnail = !$villa->gambar_villa || $villa->gambar_villa === 'villa/default.jpg';

            foreach ($files as $index => $file) {
                $path = $file->store('villa', 'public');

                if ($isDefaultThumbnail && $index === 0) {
                    $villa->update([
                        'gambar_villa' => $path
                    ]);
                }

                VillaImage::create([
                    'villa_id' => $villa->idvilla,
                    'gambar' => $path
                ]);
            }
        }

        return redirect('/villa');
    }

    public function destroy_villa($id)
    {
        DB::beginTransaction();
        try {
            $villa = Villa::findOrFail($id);

            // Hapus semua gambar villa dari storage dan DB
            foreach ($villa->images as $img) {
                if (Storage::disk('public')->exists($img->gambar)) {
                    Storage::disk('public')->delete($img->gambar);
                }
                $img->delete();
            }

            // Hapus villa
            $villa->delete();

            DB::commit();
            return redirect('/villa')->with('success', 'Villa dan semua gambarnya berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect('/villa')->with('error', 'Gagal menghapus villa: ' . $e->getMessage());
        }
    }

    public function delete_image($id)
    {
        $image = VillaImage::findOrFail($id);
        $villa = Villa::findOrFail($image->villa_id);

        $gambarDihapus = $image->gambar;

        // Hapus file dari storage
        if (Storage::disk('public')->exists($gambarDihapus)) {
            Storage::disk('public')->delete($gambarDihapus);
        }

        // Hapus dari database
        $image->delete();

        // Ambil sisa gambar
        $sisaGambar = VillaImage::where('villa_id', $villa->idvilla)->get();

        if ($sisaGambar->isEmpty()) {
            // 🔥 Kalau sudah tidak ada gambar sama sekali
            $villa->update([
                'gambar_villa' => 'villa/default.jpg'
            ]);
        } else {
            // Kalau yang dihapus adalah thumbnail
            if ($villa->gambar_villa == $gambarDihapus) {
                $villa->update([
                    'gambar_villa' => $sisaGambar->first()->gambar
                ]);
            }
        }

        return back()->with('success', 'Gambar berhasil dihapus');
    }

    public function available()
    {
        $booking = Booking::with(['villa', 'customer'])->get();

        $events = [];

        foreach ($booking as $b) {
            $events[] = [
                'title' => $b->villa->nama_villa . ' - ' . $b->customer->nama_customer,
                'start' => $b->tglcekin,
                'end'   => $b->tglcekout,
            ];
        }

        return view('villa_available', compact('events', 'booking'));
    }
    public function ambil_data()
    {
        $villa = Villa::all();
        return view('booking.create', compact('villa'));
    }

    public function set_thumbnail($id)
    {
        $image = VillaImage::findOrFail($id);
        $villa = Villa::findOrFail($image->villa_id);

        $villa->update([
            'gambar_villa' => $image->gambar
        ]);

        return back()->with('success', 'Thumbnail berhasil diubah');
    }
}
