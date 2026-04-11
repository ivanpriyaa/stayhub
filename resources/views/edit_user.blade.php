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

                        {{-- <div class="mb-3">
                            <label>Password </label>
                            <input type="password" name="password" class="form-control" >
                        </div> --}}
                        <div class="mb-3">
                            <label>Password</label>
                            <div class="input-group">
                                <input type="password" name="password" id="password" class="form-control">
                                <button type="button" class="btn btn-outline-secondary" onclick="togglePassword()">
                                    👁️
                                </button>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label>Role</label>
                            <select name="role" class="form-select">
                                <option selected>-- Pilih Role --</option>
                                <option value="Admin" {{ $user->role == 'Admin' ? 'selected' : '' }}>Admin</option>
                                <option value="Agen" {{ $user->role == 'Agen' ? 'selected' : '' }}>Agen</option>
                            </select>
                        </div>

                        <button class="btn btn-ae">Simpan</button>
                        <a href="/user" class="btn btn-secondary">Kembali</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        function togglePassword() {
            var input = document.getElementById("password");
            if (input.type === "password") {
                input.type = "text";
            } else {
                input.type = "password";
            }
        }
    </script>
@endsection
