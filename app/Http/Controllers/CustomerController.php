<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;

class CustomerController extends Controller
{
    public function customer(Request $request)
    {
        $search = $request->search;

        $customer = Customer::when($search, function ($query, $search) {
            return $query->where('nama_customer', 'like', "%$search%")
                ->orWhere('notelp_customer', 'like', "%$search%");
        })
            ->paginate(10);

        return view('customer', compact('customer'));
        // $customer = Customer::paginate(10);
        // return view('customer', ['customer' => $customer]);
    }

    public function tambah_customer()
    {
        return view('tambah_customer');
    }

    public function store(Request $request)
    {
        $customer = Customer::latest()->first();

        if (!$customer) {
            $kode = 'CUS0001';
        } else {

            $ambil = substr($customer->idcustomer, 3);
            $nomor = (int) $ambil + 1;

            $kode = 'CUS' . str_pad($nomor, 4, "0", STR_PAD_LEFT);
        }

        Customer::create([
            'idcustomer' => $kode,
            'nama_customer' => $request->nama_customer,
            'alamat_customer' => $request->alamat_customer,
            'notelp_customer' => $request->notelp_customer
        ]);

        return redirect('/customer');
    }

    public function edit_customer($id)
    {
        $customer = Customer::find($id);
        return view('edit_customer', compact('customer'));
    }

    public function update_customer(Request $request, $id)
    {
        $customer = Customer::find($id);

        $customer->update([
            'nama_customer' => $request->nama_customer,
            'alamat_customer' => $request->alamat_customer,
            'notelp_customer' => $request->notelp_customer
        ]);

        return redirect('/customer');
    }

    public function destroy_customer($id)
    {
        $customer = Customer::find($id);
        $customer->delete();
        

        return redirect('/customer');
    }
}
