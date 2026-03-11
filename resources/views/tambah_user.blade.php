@extends('layout.rangka')

@section('title', 'User - StayHub')

@section('content')
    <h1>Tambah User</h1>

    <div class="row mt-4">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="/user/store">
                        @csrf

                        <div class="mb-3">
                            <label>Nama user</label>
                            <input type="text" name="nama_user" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label>Username</label>
                            <input type="text" name="username" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control">
                        </div>

                        <button class="btn btn-primary">Simpan</button>

                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
