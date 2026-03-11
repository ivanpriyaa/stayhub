<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function user(Request $request)
    {
        $search = $request->search;

        $user = User::when($search, function ($query, $search) {
            return $query->where('nama_user', 'like', "%$search%")
                ->orWhere('username', 'like', "%$search%");
        })
            ->paginate(10);

        return view('user', compact('user'));
    }

    public function tambah_user()
    {
        return view('tambah_user');
    }

    public function store(Request $request)
    {
        $user = User::latest()->first();

        // if (!$user) {
        //     $kode = 'CUS0001';
        // } else {

        //     $ambil = substr($user->iduser, 3);
        //     $nomor = (int) $ambil + 1;

        //     $kode = 'CUS' . str_pad($nomor, 4, "0", STR_PAD_LEFT);
        // }

        User::create([
            // 'iduser' => $kode,
            'nama_user' => $request->nama_user,
            'username' => $request->username,
            'password' => Hash::make($request->password)
        ]);

        return redirect('/user');
    }

    public function edit_user($id)
    {
        $user = User::find($id);
        return view('edit_user', compact('user'));
    }

    public function update_user(Request $request, $id)
    {
        $user = User::find($id);

        $user->update([
            'nama_user' => $request->nama_user,
            'username' => $request->username,
            // 'password' => $request->password
        ]);

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->save();


        return redirect('/user');
    }

    public function destroy_user($id)
    {
        $user = User::find($id);
        $user->delete();

        return redirect('/user');
    }
}
