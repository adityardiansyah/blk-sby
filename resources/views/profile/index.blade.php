@extends('layouts.master')

@section('content')
    <div class="page-heading">
        <h3>Profile</h3>
    </div>
    <div class="page-content">
        <section class="section">
            <div class="row">
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-center align-items-center flex-column">
                                <div class="avatar">
                                    <img src="{{ asset('assets/images/faces/3.jpg') }}" style="height: 150px; width: 150px"
                                        alt="Avatar">
                                </div>
                                <h3 class="mt-3">{{ $user->name }}</h3>
                                <p class="text-small">{{ $user->username }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('users.update-password', ['id' => $user->id]) }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="name" class="form-label">Nama</label>
                                    <input type="text" name="name" id="name" class="form-control"
                                        value="{{ $user->name }}">
                                </div>
                                <div class="form-group">
                                    <label for="username" class="form-label">Username</label>
                                    <input type="text" name="username" id="username" class="form-control"
                                        value="{{ $user->username }}">
                                </div>
                                <div class="form-group">
                                    <label for="password" class="form-label">Password Sekarang</label>
                                    <input type="password" name="current_password" id="current_password"
                                        class="form-control" placeholder="Password sekarang" autocomplete="off">
                                </div>
                                <div class="form-group">
                                    <label for="password" class="form-label">Password Baru</label>
                                    <input type="password" name="new_password" id="new_password" class="form-control"
                                        placeholder="Password baru" minlength="8" autocomplete="off">
                                </div>
                                <div class="form-group">
                                    <label for="password" class="form-label">Konfirmasi Password Baru</label>
                                    <input type="password" name="new_password_confirmation" id="new_password_confirmation"
                                        class="form-control" placeholder="Konfirmasi password baru" minlength="8"
                                        autocomplete="off">
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('js')
@endpush
