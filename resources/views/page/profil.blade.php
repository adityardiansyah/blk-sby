@extends('layouts.master')

@section('content')
    <div class="page-heading">
        <h3>Profil</h3>
    </div>
    <div class="page-content">
        <section class="section">
            <div class="row">
                <div class="col-lg-9">
                    <div class="card">
                        <div class="card-body">
                        <form action="{{ route('profil.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="foto">Foto</label>
                                <input type="file" class="form-control" id="foto_gedung" name="foto_gedung">
                            </div>
                            <div class="form-group">
                                <label for="judul">Judul</label>
                                <input type="text" class="form-control" id="judul" name="judul" placeholder="Masukkan Judul" value="{{ $profil->judul }}">
                            </div>
                            <div class="form-group">
                                <label for="sejarah">Sejarah</label>
                                <textarea class="form-control" id="sejarah" name="sejarah" rows="4" placeholder="Masukkan Sejarah">{{ $profil->sejarah }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="visi">Visi</label>
                                <textarea class="form-control" id="visi" name="visi" rows="4" placeholder="Masukkan Visi">{{ $profil->visi }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="misi">Misi</label>
                                <textarea class="form-control" id="misi" name="misi" rows="4" placeholder="Masukkan Misi">{{ $profil->misi }}</textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="card">
                        <div class="card-body">
                            <img src="{{ asset('images/'.$profil->foto_gedung) }}" alt="Foto Gedung" class="img-fluid mb-3">
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('js')
@endpush
