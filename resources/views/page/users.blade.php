@extends('layouts.master')

@section('content')
<div class="page-heading">
    <h3>User</h3>
</div>
<div class="page-content">
    <section class="section">
        <div class="card">
            <div class="card-header">
                
            </div>
            <div class="card-body">
                <table class="table table-striped" id="table1">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Username</th>
                            <th>Password</th>
                            <th>Tgl. Dibuat</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                            <tr>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->username }}</td>
                                <td>{{ $item->password }}</td>
                                <td>{{ date('Y-m-d', strtotime($item->created_at)) }}</td>
                                <td>
                                    <span class="">{{ Str::ucfirst($item->status) }}</span>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-warning btn-sm" onclick="detail({{ $item->id }})">Edit</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </section>
</div>

<div class="modal fade text-left" id="modal_update" tabindex="-1" role="dialog"
    aria-labelledby="myModalLabel33" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered"
        role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel33"> Edit User </h4>
                <button type="button" class="close" data-bs-dismiss="modal"
                    aria-label="Close">
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
            <form action="{{ route('users.update', ['id' => $item->id]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" name="id" id="id">
                <div class="modal-body">
                    <div class="row">
                        <label>Nama</label>
                        <div class="form-group">
                            <input readonly type="text" placeholder="Nama"
                                class="form-control" name="name" id="name" required value="{{ old('name') }}">
                        </div>
                        <label>Username</label>
                        <div class="form-group">
                            <input readonly type="text" placeholder="Username"
                                class="form-control" name="username" id="username" required value="{{ old('username') }}">
                        </div>
                        <label>Password</label>
                        <div class="form-group">
                            <input type="text" placeholder="password"
                                class="form-control" name="password" id="password" required value="{{ old('password') }}">
                        </div>
                        <label>Confirm Password</label>
                        <div class="form-group">
                            <input type="text" placeholder="password"
                                class="form-control" name="repassword" id="repassword" required value="{{ old('repassword') }}">
                        </div>
                        <label>Status</label>
                        <div class="form-group">
                            <select class="form-control" name="status" id="status" class="form-control choices" required value="{{ old('status') }}">
                            <option value="active">active</option>
                            <option value="nonactive">nonactive</option>
                        </select>
                        </div>
                    </div>
                </div>
                @if (Auth::user()->id == 1 && 2)
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary ml-1" id="button-save">
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Simpan</span>
                    </button>
                @endif
                    <button type="button" class="btn btn-light-secondary"
                        data-bs-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Tutup</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
    function detail(id){
        $('#modal_update').modal('show');

        $.ajax({
            type : 'get',
            data: {},
            url : "{{ url('users') }}/"+id,
            success:function(data){
                console.log(data);
                $('#name').val(data.data.name);
                $('#username').val(data.data.username);
                $('#password').val(data.data.password);
                $('#status').val(data.data.status);
                $('#id').val(data.data.id);
                let detail = data.data.detail
                $.each( detail, function( i, item ) {
                    console.log(item);
                });
            },
            complete:function() {

            }
        });
    }


    function edit_data(id){
        $('#modal_update').modal('show');

        $.ajax({
            type : 'get',
            data: {},
            url : "{{ url('users/edit') }}/"+id,
            success:function(data){
                console.log(data);
                $('#password').val(data.data.password);
                $('#status').val(data.data.status);
                $('#id').val(data.data.id);
            },
            complete:function() {

            }
        });
    }

    $('body').on('click', '#button-save', function () {
        var users_id = $('#id').val();
        var name = $('#name').val();
        var username = $('#username').val();
        var password = $('#password').val();
        var repassword = $('#repassword').val();
        var status = $('#status').val();
        var token   = "{{ csrf_token() }}"

        if(password !== repassword){
                message('Password tidak sama!', false);
                return;
        }
    
        Swal.fire({
            title: 'Apakah Kamu Yakin',
            text: "mengubah data user?",
            icon: 'question',
            showCancelButton: true,
            cancelButtonText: 'TIDAK',
            confirmButtonText: 'YA, UBAH!'
        }).then((result) => {
            if (result.isConfirmed) {
                var fd = new FormData();
                fd.append('_token', token);
                fd.append('name', name);
                fd.append('username', username);
                fd.append('password', password);
                fd.append('status', status);

                $.ajax({
                    url: `/users/update/${users_id}`,
                    type: "POST",
                    cache: false,
                    processData: false,
                    contentType: false,
                    data: fd,
                    success:function(response){ 
                        setTimeout(function(){
                            window.location=window.location;
                        },1220);
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

    // $(document).ready(function() {
    //     // Mendapatkan nilai status saat ini
    //     var currentStatus = $('select[name=status]').val();

    //     // Menonaktifkan opsi yang tidak sesuai
    //     $('select[name=status] option').each(function() {
    //         if ($(this).val() == currentStatus) {
    //         $(this).prop('disabled', true);
    //         }
    //     });
    // });

        $(document).ready(function() {
    // Mendapatkan nilai status saat ini
    var currentStatus = $('select[name=status]').val();

    // Menonaktifkan opsi yang tidak sesuai
    $('select[name=status] option').each(function() {
        if ($(this).val() == currentStatus) {
        $(this).prop('disabled', true);
        }
    });

    // Menangani perubahan nilai pada dropdown
    $('select[name=status]').on('change', function() {
        // Mendapatkan nilai status saat ini
        var currentStatus = $(this).val();

        // Menonaktifkan opsi yang tidak sesuai
        $('select[name=status] option').each(function() {
        if ($(this).val() == currentStatus) {
            $(this).prop('disabled', true);
        } else {
            $(this).prop('disabled', false);
        }
        });
    });
    
    // Memastikan bahwa opsi yang tidak sesuai selalu dinonaktifkan
    $('select[name=status]').on('click', function() {
        // Mendapatkan nilai status saat ini
        var currentStatus = $(this).val();

        // Menonaktifkan opsi yang tidak sesuai
        $('select[name=status] option').each(function() {
        if ($(this).val() == currentStatus) {
            $(this).prop('disabled', true);
        } else {
            $(this).prop('disabled', false);
        }
        });
    });
    });

</script>
@endpush
