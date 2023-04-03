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
                                <td>*******</td>
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
            <form action="{{ route('users.show', ['id' => $item->id]) }}" method="POST" enctype="multipart/form-data">
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
                            <select name="status" id="" class="form-control choices" required value="{{ old('status') }}">
                                <option value="">-- Pilih Status --</option>
                                <option value="active"></option>
                                <option value="nonactive"></option>
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

    $('body').on('click', '#button-save', function () {
    let users_id = $('#id').val();
    let token   = "{{ csrf_token() }}"
    
        Swal.fire({
            title: 'Apakah Kamu Yakin',
            text: "mengubah data user?",
            icon: 'question',
            showCancelButton: true,
            cancelButtonText: 'TIDAK',
            confirmButtonText: 'YA, UBAH!'
        }).then((result) => {
            if (result.isConfirmed) {

                //fetch to delete data
                $.ajax({

                    url: `/users/${users_id}/confirm`,
                    type: "POST",
                    cache: false,
                    data: {
                        "_token": token,
                        "type": ""
                    },
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
    }

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $("#button-save").click(function(e){

        e.preventDefault();

        let password = $("input[name=password]").val();
        let repassword = $("input[name=repassword]").val();
        let status = $("input[name=status]").val();
        let token = $('input[name="_token"]').val();

        if(password !== repassword){
            message('Password tidak sama!', false);
            return;
        }
        let fd = new FormData();
        fd.append('_token', token);
        fd.append('password', password);
        fd.append('repassword', repassword);
        fd.append('status', status);

        $.ajax({
            type:'POST',
            url:"{{ route('users.store') }}",
            headers: {
                'X-CSRF-TOKEN' : token
            },
            data:fd,
            contentType: false,
            processData: false,
            dataType: 'json',
            success:async function(data){
                message(data.message);
                $('#modal_update').modal('hide');
                await new Promise(r => setTimeout(r, 1000));
                location.reload();
            },
            error:function(params) {
                let txt = params.responseJSON;
                $.each(txt.errors,function (k,v) {
                    message(v, false);
                });
            }
        });

    });
</script>
@endpush
