@extends('layout.rangka')

@section('title', 'User - StayHub')

@section('content')
    <h1>Edit User</h1>

    <div class="row mt-4">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="/user/update_user/{{ $user->iduser }}">
                        @csrf

                        <div class="mb-3">
                            <label>Nama user</label>
                            <input type="text" name="nama_user" class="form-control" value="{{ $user->nama_user }}">
                        </div>

                        <div class="mb-3">
                            <label>Username</label>
                            <input type="text" name="username" class="form-control" value="{{ $user->username }}">
                        </div>

                        <div class="mb-3">
                            <label>Password </label>
                            <input type="password" name="password" class="form-control" value="">
                        </div>

                        <button class="btn btn-ae">Simpan</button>
                        <a href="/user" class="btn btn-secondary">Kembali</a>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
