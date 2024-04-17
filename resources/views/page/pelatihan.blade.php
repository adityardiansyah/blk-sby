@extends('layouts.master')

@section('content')
    <div class="page-heading">
        <h3>Pelatihan</h3>
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
                                <th>Nama Pelatihan</th>
                                <th>Tanggal Pelaksanaan</th>
                                <th>Tanggal Mulai</th>
                                <th>Tanggal Selesai</th>
                                <th>Kuota</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $key => $item)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $item->nama_pelatihan }}</td>
                                    <td>{{ $item->tanggal_pelaksanaan }}</td>
                                    <td>{{ $item->tanggal_awal }}</td>
                                    <td>{{ $item->tanggal_akhir }}</td>
                                    <td>{{ $item->kuota }}</td>
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
                        <h4 class="modal-title" id="myModalLabel33"> Edit Pelatihan </h4>
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
                            <label>Nama Pelatihan</label>
                            <div class="form-group">
                                <input type="text" placeholder="Nama Pelatihan" class="form-control" name="nama_pelatihan" id="nama_pelatihan_edit" required>
                            </div>
                            <label>Tanggal Pelaksanaan</label>
                            <div class="form-group">
                                <input type="date" class="form-control" name="tanggal_pelaksanaan" id="tanggal_pelaksanaan_edit" required>
                            </div>
                            <label>Tanggal Mulai Promosi</label>
                            <div class="form-group">
                                <input type="date" class="form-control" name="tanggal_awal" id="tanggal_awal_edit" required>
                            </div>
                            <label>Tanggal Akhir Promosi</label>
                            <div class="form-group">
                                <input type="date" class="form-control" name="tanggal_akhir" id="tanggal_akhir_edit" required>
                            </div>
                            <label>Kuota</label>
                            <div class="form-group">
                                <input type="number" placeholder="Kuota" class="form-control" name="kuota" id="kuota_edit" required>
                            </div>
                            <label>Status</label>
                            <div class="form-group">
                                <select class="form-control" name="status" id="status_edit" required>
                                    <option value="Aktif">Aktif</option>
                                    <option value="Tidak Aktif">Tidak Aktif</option>
                                </select>
                            </div>
                            <label>Deskripsi</label>
                            <div class="form-group">
                                <textarea class="form-control" name="deskripsi" id="deskripsi_edit" rows="3" required></textarea>
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
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
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
                <form action="{{ route('pelatihan.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <label>Nama Pelatihan</label>
                            <div class="form-group">
                                <input type="text" placeholder="Nama Pelatihan" class="form-control" name="nama_pelatihan" id="nama_pelatihan" required value="{{ old('nama_pelatihan') }}">
                            </div>
                            <label>Tanggal Pelaksanaan</label>
                            <div class="form-group">
                                <input type="date" class="form-control" name="tanggal_pelaksanaan" id="tanggal_pelaksanaan" required value="{{ old('tanggal_pelaksanaan') }}">
                            </div>
                            <label>Tanggal Mulai Promosi</label>
                            <div class="form-group">
                                <input type="date" class="form-control" name="tanggal_awal" id="tanggal_awal" required value="{{ old('tanggal_awal') }}">
                            </div>
                            <label>Tanggal Selesai Promosi</label>
                            <div class="form-group">
                                <input type="date" class="form-control" name="tanggal_akhir" id="tanggal_akhir" required value="{{ old('tanggal_akhir') }}">
                            </div>
                            <label>Kuota</label>
                            <div class="form-group">
                                <input type="number" placeholder="Kuota" class="form-control" name="kuota" id="kuota" required value="{{ old('kuota') }}">
                            </div>
                            <label>Deskripsi</label>
                            <div class="form-group">
                                <textarea name="deskripsi" id="deskripsi" class="form-control" rows="3" placeholder="Deskripsi" required>{{ old('deskripsi') }}</textarea>
                            </div>
                            <label>Status</label>
                            <div class="form-group">
                                <select class="form-control" name="status" id="status" required value="{{ old('status') }}">
                                    <option value="Aktif">Aktif</option>
                                    <option value="Non-Aktif">Nonaktif</option>
                                </select>
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
                url: "/pelatihan/"+id,
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
                        window.location.href = '{{ route('pelatihan.index') }}';
                    }, 1220);
                },
                error: function(xhr, status, error) {
                    // xhr.responseJSON berisi detail error validasi
                    if(xhr.status === 422) {
                        // Tangani error validasi
                        console.log(xhr.responseJSON);
                        $.each(xhr.responseJSON, function(k, v) {
                            message(v, false);
                        });
                    }
                }
            });
        }

        function addData(id) {
            $('#modal_add').modal('show')
        }

        $(".btn-simpan").click(function(e) {

            e.preventDefault();

            var nama_pelatihan = $("input[name=nama_pelatihan]").val();
            var tanggal_pelaksanaan = $("input[name=tanggal_pelaksanaan]").val();
            var tanggal_awal = $("input[name=tanggal_awal]").val();
            var tanggal_akhir = $("input[name=tanggal_akhir]").val();
            var kuota = $("input[name=kuota]").val();
            var deskripsi = $("textarea[name=deskripsi]").val();
            var status = $("select[name=status]").val();
            let token = $('input[name="_token"]').val();

            let fd = new FormData();
            fd.append('_token', token);
            fd.append('nama_pelatihan', nama_pelatihan);
            fd.append('tanggal_pelaksanaan', tanggal_pelaksanaan);
            fd.append('tanggal_awal', tanggal_awal);
            fd.append('tanggal_akhir', tanggal_akhir);
            fd.append('kuota', kuota);
            fd.append('deskripsi', deskripsi);
            fd.append('status', status);

            $.ajax({
                type: 'POST',
                url: "{{ route('pelatihan.store') }}",
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
                complete: function(data) {
                    console.log(data);
                    $('.btn-simpan').prop('disabled', false);
                    $('.btn-simpan').html('')
                    $('.btn-simpan').append('Simpan');
                    if(data.status == 200){
                        setTimeout(function() {
                            window.location.href = '{{ route('pelatihan.index') }}';
                        }, 1220);
                    }
                },
                error: function(xhr, status, error) {
                    if(xhr.status === 422) {
                        // Tangani error validasi
                        console.log(xhr.responseJSON);
                        $.each(xhr.responseJSON, function(k, v) {
                            message(v, false);
                        });
                    }
                }
            });
        });

        function editData(id) {
            $('#modal_update').modal('show')

            $.ajax({
                type: 'get',
                data: {},
                url: "{{ url('pelatihan') }}/" + id,
                success: function(data) {
                    console.log(data);
                    $('#id_edit').val(data.data.id);
                    $('#nama_pelatihan_edit').val(data.data.nama_pelatihan);    
                    $('#tanggal_pelaksanaan_edit').val(data.data.tanggal_pelaksanaan);
                    $('#tanggal_awal_edit').val(data.data.tanggal_awal);
                    $('#tanggal_akhir_edit').val(data.data.tanggal_akhir);
                    $('#kuota_edit').val(data.data.kuota);
                    $('#status_edit').val(data.data.status).trigger('change');
                    $('#deskripsi_edit').val(data.data.deskripsi);
                },
                complete: function() {}
            })
        }

        $('body').on('click', '.btn-simpan-edit', function() {
            var id = $('#id_edit').val();
            var nama_pelatihan = $('#nama_pelatihan_edit').val();
            var tanggal_pelaksanaan = $('#tanggal_pelaksanaan_edit').val();
            var tanggal_awal = $('#tanggal_awal_edit').val();
            var tanggal_akhir = $('#tanggal_akhir_edit').val();
            var kuota = $('#kuota_edit').val();
            var status = $('#status_edit').val();
            var deskripsi = $('#deskripsi_edit').val();
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
                    
                    $.ajax({
                        url: `/pelatihan/${id}`,
                        type: "PUT",
                        data: {
                            'nama_pelatihan': nama_pelatihan,
                            'tanggal_pelaksanaan': tanggal_pelaksanaan,
                            'tanggal_awal': tanggal_awal,
                            'tanggal_akhir': tanggal_akhir,
                            'kuota': kuota,
                            'deskripsi': deskripsi,
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
