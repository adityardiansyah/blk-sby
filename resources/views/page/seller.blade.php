@extends('layouts.master')

@section('content')
<div class="page-heading">
    <h3>Seller</h3>
</div>
<div class="page-content">
    <section class="section">
        <div class="card">
            <div class="card-header">
                <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#modal_add"><i class="bi bi-plus"></i> Tambah</button>
            </div>
            <div class="card-body">
                <table class="table table-striped" id="table1">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>No. Reg</th>
                            <th>Nama</th>
                            <th>Phone</th>
                            <th>Tgl. Dibuat</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $key => $item)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $item->no_seller }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->phone }}</td>
                                <td>{{ date('Y-m-d', strtotime($item->created_at)) }}</td>
                                <td>
                                    <span class="">{{ Str::ucfirst($item->status) }}</span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </section>
</div>

<div class="modal fade text-left" id="modal_add" tabindex="-1" role="dialog"
    aria-labelledby="myModalLabel33" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
        role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel33">Tambah Data </h4>
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
            <form action="{{ route('seller.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <label>Nama Lengkap</label>
                    <div class="form-group">
                        <input type="text" placeholder="Nama Lengkap"
                            class="form-control" name="name" required value="{{ old('name') }}">
                    </div>
                    <label>Email</label>
                    <div class="form-group">
                        <input type="email" placeholder="Email"
                            class="form-control" name="email" required value="{{ old('email') }}">
                    </div>
                    <label>No. Telepon</label>
                    <div class="form-group">
                        <input type="text" placeholder="No. Telepon"
                            class="form-control" name="phone" required value="{{ old('phone') }}">
                    </div>
                    <label>Cabang Toko</label>
                    <div class="form-group">
                        <select name="shop_id" id="" class="form-control" required value="{{ old('shop_id') }}">
                            <option value="">-- Pilih Toko --</option>
                            @foreach ($shop as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <label>Foto</label>
                    <div class="form-group">
                        <input type="file" placeholder="Foto"
                            class="form-control" name="photo">
                    </div>
                    <hr>
                    <label><b>Akun Login</b></label>
                    <br>
                    <label>Username</label>
                    <div class="form-group">
                        <input type="text" placeholder="Username"
                            class="form-control" name="username" required value="{{ old('username') }}">
                    </div>
                    <label>Password: </label>
                    <div class="form-group">
                        <input type="password" placeholder="Password"
                            class="form-control" name="password" required value="{{ old('password') }}">
                    </div>
                    <label>Ulangi Password: </label>
                    <div class="form-group">
                        <input type="password" placeholder="Ulangi Password"
                            class="form-control" name="repassword" required value="{{ old('repassword') }}">
                    </div>
                    <label>Hak Akses</label>
                    <div class="form-group">
                        <select name="group_id" id="" class="form-control" required value="{{ old('group_id') }}">
                            <option value="">-- Pilih Hak Akses --</option>
                            @foreach ($role as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-secondary"
                        data-bs-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Tutup</span>
                    </button>
                    <button type="button" class="btn btn-primary ml-1 btn-simpan">
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
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(".btn-simpan").click(function(e){
  
        e.preventDefault();

        let name = $("input[name=name]").val();
        let username = $("input[name=username]").val();
        let password = $("input[name=password]").val();
        let repassword = $("input[name=repassword]").val();
        let email = $("input[name=email]").val();
        let phone = $("input[name=phone]").val();
        let photo = $("input[name=photo]")[0].files[0];
        let shop_id = $('select[name=shop_id] option').filter(':selected').val();
        let group_id = $('select[name=group_id] option').filter(':selected').val();
        let token = $('input[name="_token"]').val();

        if(password !== repassword){
            message('Password tidak sama!', false);
            return;
        }
        let fd = new FormData();
        fd.append('_token', token);
        fd.append('name', name);
        fd.append('password', password);
        fd.append('username', username);
        fd.append('phone', phone);
        fd.append('shop_id', shop_id);
        fd.append('repassword', repassword);
        fd.append('img', photo);
        fd.append('email', email);
        fd.append('group_id', group_id);

        $.ajax({
            type:'POST',
            url:"{{ route('seller.store') }}",
            headers: {
                'X-CSRF-TOKEN' : token
            },
            data:fd,
            contentType: false,
            processData: false,
            dataType: 'json',
            success:async function(data){
                message(data.message);
                $('#modal_all').modal('hide');
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