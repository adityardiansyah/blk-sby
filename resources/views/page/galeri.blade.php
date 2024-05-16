@extends('layouts.master')

@section('content')
    <div class="page-heading">
        <h3>Galeri</h3>
    </div>
    <div class="page-content">
        <section class="section">
            <div class="card">
                <div class="card-header">
                    <button type="button" class="btn float-end" onclick="addData(0)"><i class="bi bi-plus"></i> Tambah</button>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-striped" id="table1">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Judul</th>
                                <th>Deskripsi</th>
                                <th>Gambar</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($galeri as $key => $item)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $item->judul }}</td>
                                    <td>{{ $item->deskripsi }}</td>
                                    <td>
                                        <ul>
                                            @foreach ($item->foto_galeri as $ke => $value)
                                            <li><a href="{{ asset('storage/'.$value->foto) }}" target="_blank">Foto {{ $ke+1 }}</a></li>
                                            @endforeach
                                        </ul>
                                    </td>
                                    <td>{{ $item->status }}</td>
                                    <td>
                                        <button type="button" class="btn" onclick="editData({{ $item->id }})"><i class="bi bi-pencil"></i></button>
                                        <button type="button" class="btn" onclick="deleteData({{ $item->id }})"><i class="bi bi-trash"></i></button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

        <div class="modal fade text-left" id="modal_update" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel33"> Edit Galeri </h4>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
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
                    <form action="{{ route('galeri.update', 'id') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="id" id="id_edit">
                        <div class="modal-body">
                            <div class="row">
                                <label>Judul Galeri</label>
                                <div class="form-group">
                                    <input type="text" placeholder="Judul Galeri" class="form-control" name="judul_edit"
                                        id="judul_edit" required value="{{ old('judul_edit') }}">
                                </div>
                                <label>Deskripsi Galeri</label>
                                <div class="form-group">
                                    <textarea class="form-control" name="deskripsi_edit" id="deskripsi_edit" rows="3" required>{{ old('deskripsi_edit') }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label>Gambar Tersimpan</label>
                                    <div>
                                        @if(isset($item->foto_galeri) && !empty($item->foto_galeri))
                                            @foreach($item->foto_galeri as $foto)
                                                <div style="display: inline-block; position: relative;">
                                                    <img src="{{ asset('storage/'.$foto->foto) }}" alt="gambar-galeri" style="width: 100px;">
                                                    <button type="button" class="btn btn-danger" style="position: absolute; top: 0; right: 0;" onclick="hapusFoto({{ $foto->id }})"><i class="bi bi-trash"></i></button>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="gambar_edit">Upload Gambar Baru</label>
                                    <input type="file" class="form-control" name="gambar_edit[]" id="gambar_edit" multiple>
                                </div>
                                <label>Status</label>
                                <div class="form-group">
                                    <select class="form-control" name="status_edit" id="status_edit" required>
                                        <option value="Aktif">Aktif</option>
                                        <option value="Nonaktif">Nonaktif</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary ml-1 btn-simpan-edit">
                                <i class="bx bx-check "></i>
                                <span class="">Simpan</span>
                            </button>
                            <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                                <i class="bx bx-x "></i>
                                <span class="">Tutup</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>

    <div class="modal fade text-left" id="modal_add" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">Tambah Data </h4>
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
                <form action="{{ route('galeri.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <label>Judul</label>
                                <div class="form-group">
                                    <input type="text" placeholder="Judul" class="form-control" name="judul"
                                        id="judul" required value="{{ old('judul') }}">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label>Deskripsi</label>
                                <div class="form-group">
                                    <textarea placeholder="Deskripsi" class="form-control" name="deskripsi"
                                        id="deskripsi" required>{{ old('deskripsi') }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label>Gambar</label>
                            <div class="form-group">
                                <input type="file" class="form-control" name="gambar[]" id="gambar" multiple required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-secondary btn-tutup" data-bs-dismiss="modal">
                            <i class="bx bx-x "></i>
                            <span class="">Tutup</span>
                        </button>
                        <button type="submit" class="btn btn-primary ml-1 btn-simpan">
                            <i class="bx bx-check "></i>
                            <span class="">Simpan</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        function hapusFoto(idFoto) {
            let token = $('input[name="_token"]').val();

            Swal.fire({
                title: 'Apakah Anda Yakin?',
                text: "Foto ini akan dihapus secara permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'DELETE',
                        url: "/galeri/foto/"+idFoto,
                        headers: {
                            'X-CSRF-TOKEN': token
                        },
                        data: idFoto,
                        contentType: false,
                        processData: false,
                        dataType: 'json',
                        beforeSend: function() {
                            
                        },
                        success: async function(data) {
                            message(data.message, data.success);
                        },
                        complete: function() {
                            setTimeout(function() {
                                window.location.href = '{{ route('galeri.index') }}';
                            }, 1220);
                        },
                        error: function(params) {
                            let txt = params.responseJSON;
                            message(txt.message, false);
                        }
                    });
                }
            });
        }

        function deleteData(id){
            let token = $('input[name="_token"]').val();

            Swal.fire({
                title: 'Apakah Anda Yakin?',
                text: "Data ini akan dihapus secara permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'DELETE',
                        url: "/galeri/"+id,
                        headers: {
                            'X-CSRF-TOKEN': token
                        },
                        data: id,
                        contentType: false,
                        processData: false,
                        dataType: 'json',
                        beforeSend: function() {
                            
                        },
                        success: async function(data) {
                            message(data.message, data.success);
                        },
                        complete: function() {
                            $('.btn-simpan').prop('disabled', false);
                            $('.btn-simpan').html('')
                            $('.btn-simpan').append('Simpan');
                            setTimeout(function() {
                                window.location.href = '{{ route('galeri.index') }}';
                            }, 1220);
                        },
                        error: function(params) {
                            let txt = params.responseJSON;
                            message(txt.message, false);
                        }
                    });
                }
            });
        }

        function addData(id) {
            $('#modal_add').modal('show')
        }

        function editData(id) {
            $('#modal_update').modal('show')

            $.ajax({
                type: 'get',
                data: {},
                url: "{{ url('galeri') }}/" + id,
                success: function(data) {
                    console.log(data);
                    $('#id_edit').val(data.data.id);
                    $('#judul_edit').val(data.data.judul);
                    $('#deskripsi_edit').val(data.data.deskripsi);
                    $('#status_edit').val(data.data.status);
                },
                complete: function() {}
            })
        }

    </script>
@endpush
