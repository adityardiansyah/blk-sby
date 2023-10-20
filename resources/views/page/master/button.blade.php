@extends('layouts.master')

@section('content')
    <div class="page-heading">
        <h3>Master Tombol</h3>
    </div>
    <div class="page-content">
        <section class="section">
            <div class="card">
                <div class="card-header">

                    {!! NavHelper::action('header') !!}
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-striped" id="table1">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Kode</th>
                                <th>Posisi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <form action="{{ route('button.update') }}" method="post" id="update-form">
                                @csrf
                                @foreach ($data as $key => $item)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td><input type="text" placeholder="Nama" class="form-control" name="name"
                                                id="name-{{ $item->id }}" required value="{{ $item->name }}"></td>
                                        <td>
                                            <textarea class="form-control" cols="100" rows="4" id="code-{{ $item->id }}">{{ $item->code }}</textarea>
                                        </td>
                                        <td><input type="text" placeholder="Position" class="form-control"
                                                name="position" required id="position-{{ $item->id }}"
                                                value="{{ $item->position }}" disabled></td>
                                        <td>
                                            <input type="hidden" name="id" value="{{ $item->id }}">
                                            <button onclick="save({{ $item->id }})" type="submit" class="btn btn-primary ml-1 btn-simpan">
                                                <i class="bx bx-check d-block d-sm-none"></i>
                                                <span class="d-none d-sm-block">Simpan</span>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </form>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>

    <div class="modal fade text-left" id="modal_add" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">Tambah button Baru</h4>
                    <button type="button" class="close btn-tutup" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form action="" id="buttonForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <label>Nama</label>
                            <div class="form-button">
                                <input type="text" placeholder="Nama" class="form-control" name="name" id="name"
                                    required value="{{ old('name') }}">
                            </div>
                            <label>Kode</label>
                            <div class="form-button">
                                <textarea class="form-control" id="code" placeholder="Text code" rows="3">{{ old('code') }}</textarea>
                            </div>
                            <label>Posisi</label>
                            <div class="form-button">
                                <input type="text" placeholder="Position" class="form-control" name="description"
                                    id="position" required value="{{ old('position') }}">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-secondary btn-tutup" data-bs-dismiss="modal">
                            <i class="bx bx-x d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Tutup</span>
                        </button>
                        <button type="submit" class="btn btn-primary ml-1 btn-simpan">
                            <i class="bx bx-check d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Simpan</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        function save(id) {
            let token = $('input[name="_token"]').val()
            let name = $(`#name-${id}`).val()
            let code = $(`#code-${id}`).val()
            let position = $(`#position-${id}`).val()
            
            const formData = new FormData()
            formData.append('_token', token)
            formData.append('id', id)
            formData.append('name', name)
            formData.append('code', code)
            formData.append('position', position)

            $.ajax({
                url: '{{ route('button.update') }}',
                type: 'post',
                headers: {
                    "X-CSRF-TOKEN": token,
                },
                data: formData,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: async function(data) {
                    if (data.status) {
                        message(data.message, data.success);
                    }
                },
            });
        }
    </script>
@endpush
