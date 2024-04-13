@extends('layouts.master')

@section('content')
    <div class="page-heading">
        <h3>Kejuruan</h3>
    </div>
    <div class="page-content">
        <section class="section">
            <div class="card">
                <div class="card-header">
                    <button type="button" class="btn float-end" onclick="addData(0)"><i class="bi bi-plus"></i> Tambah</button>
                    {{-- {!! NavHelper::action('header') !!} --}}
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-striped" id="table1">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Kejuruan</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $key => $item)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $item->nama_kejuruan }}</td>
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
                        <h4 class="modal-title" id="myModalLabel33"> Edit User </h4>
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
                    <form action="" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="id" id="id_edit">
                        <div class="modal-body">
                            <div class="row">
                                <label>Nama Kejuruan</label>
                                <div class="form-group">
                                    <input type="text" placeholder="Nama Kejuruan" class="form-control" name="nama_kejuruan_edit"
                                        id="nama_kejuruan_edit" required value="{{ old('nama_kejuruan_edit') }}">
                                </div>
                                <label>Status</label>
                                <div class="form-group">
                                    <select class="form-control" name="status" id="status" class="form-control choices"
                                        required value="{{ old('status') }}">
                                        <option value="aktif">active</option>
                                        <option value="nonaktif">nonactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary ml-1 btn-simpan-edit">
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
                <form action="{{ route('kejuruan.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <label>Nama Kejuruan</label>
                            <div class="form-group">
                                <input type="text" placeholder="Nama Kejuruan" class="form-control" name="nama_kejuruan"
                                    id="nama_kejuruan" required value="{{ old('nama_kejuruan') }}">
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

        function deleteData(id){
            let token = $('input[name="_token"]').val();

            $.ajax({
                type: 'DELETE',
                url: "/kejuruan/"+id,
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
                        window.location.href = '{{ route('kejuruan.index') }}';
                    }, 1220);
                },
                error: function(params) {
                    let txt = params.responseJSON;
                    $.each(txt.errors, function(k, v) {
                        message(v, false);
                    });
                }
            });
        }

        function addData(id) {
            $('#modal_add').modal('show')
        }

        $(".btn-simpan").click(function(e) {

            e.preventDefault();

            var nama_kejuruan = $("input[name=nama_kejuruan]").val();
            let token = $('input[name="_token"]').val();

            let fd = new FormData();
            fd.append('_token', token);
            fd.append('nama_kejuruan', nama_kejuruan);

            $.ajax({
                type: 'POST',
                url: "{{ route('kejuruan.store') }}",
                headers: {
                    'X-CSRF-TOKEN': token
                },
                data: fd,
                contentType: false,
                processData: false,
                dataType: 'json',
                beforeSend: function() {
                    $('.btn-simpan').prop('disabled', true);
                    $('.btn-simpan').html('')
                    $('.btn-simpan').append(
                        '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>Loading...'
                    )
                },
                success: async function(data) {
                    message(data.message, data.success);
                },
                complete: function() {
                    $('.btn-simpan').prop('disabled', false);
                    $('.btn-simpan').html('')
                    $('.btn-simpan').append('Simpan');
                    setTimeout(function() {
                        window.location.href = '{{ route('kejuruan.index') }}';
                    }, 1220);
                },
                error: function(params) {
                    let txt = params.responseJSON;
                    $.each(txt.errors, function(k, v) {
                        message(v, false);
                    });
                }
            });
        });

        function editData(id) {
            $('#modal_update').modal('show')

            $.ajax({
                type: 'get',
                data: {},
                url: "{{ url('kejuruan') }}/" + id,
                success: function(data) {
                    console.log(data);
                    $('#id_edit').val(data.data.id);
                    $('#nama_kejuruan_edit').val(data.data.nama_kejuruan);
                },
                complete: function() {}
            })
        }

        $('body').on('click', '.btn-simpan-edit', function() {
            var id = $('#id_edit').val();
            var nama_kejuruan = $('#nama_kejuruan_edit').val();
            var status = $('#status').val();
            var token = $('input[name="_token"]').val();

            Swal.fire({
                title: 'Apakah Kamu Yakin',
                text: "mengubah data ?",
                icon: 'question',
                showCancelButton: true,
                cancelButtonText: 'TIDAK',
                confirmButtonText: 'YA, UBAH!'
            }).then((result) => {
                if (result.isConfirmed) {
                    var fd = new FormData();
                    fd.append('_token', token);
                    fd.append('nama_kejuruan', nama_kejuruan);
                    fd.append('status', status);
                    
                    $.ajax({
                        url: `/kejuruan/${id}`,
                        type: "PUT",
                        data: {
                            'nama_kejuruan': nama_kejuruan,
                            'status': status,
                            '_token': token
                        },
                        success: function(response) {
                            setTimeout(function() {
                                window.location = window.location;
                            }, 1220);
                            //show success message
                            Swal.fire({
                                type: 'success',
                                icon: 'success',
                                title: `${response.message}`,
                                showConfirmButton: false,
                                timer: 3000
                            });
                        }
                    });
                }
            })
        });

    </script>
@endpush
