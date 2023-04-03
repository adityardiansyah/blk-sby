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
                                    <button type="button" class="btn btn-warning btn-sm" onclick="lihat({{ $item->id }})">Edit</button>
                                    <button type="button" class="btn btn-primary btn-sm" onclick="detail({{ $item->id }})">Detail</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </section>
</div>

<div class="modal fade text-left" id="modal_show" tabindex="-1" role="dialog"
    aria-labelledby="myModalLabel33" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered"
        role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel33"> Edit Password </h4>
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
            <form action="{{ route('stockopname.show', ['id' => $item->id]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" name="id" id="id">
                <div class="modal-body">
                    <div class="row">
                        <label>Password</label>
                        <div class="form-group">
                            <input type="text" placeholder="password"
                                class="form-control" name="password" required value="{{ old('password') }}">
                        </div>
                    </div>
                </div>
                @if (Auth::user()->id == 1 && 2)
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary ml-1" id="button-open">
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

<div class="modal fade text-left" id="modal_update" tabindex="-1" role="dialog"
    aria-labelledby="myModalLabel33" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered"
        role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel33"> Detail User </h4>
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
            <form action="{{ route('stockopname.show', ['id' => $item->id]) }}" method="POST" enctype="multipart/form-data">
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
                            <input readonly type="text" placeholder="Password"
                                class="form-control" name="password" id="password" required value="{{ old('password') }}">
                        </div>
                        <label>Status</label>
                        <div class="form-group">
                            <input readonly type="text" placeholder="Status"
                                class="form-control" name="status" id="status" required value="{{ old('status') }}">
                        </div>
                    </div>
                </div>
                @if (Auth::user()->id == 1 && 2)
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary ml-1" id="button-open">
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
    function lihat(id){
        $('#modal_show').modal('show');

        $.ajax({
            type : 'get',
            data: {},
            url : "{{ url('users') }}/"+id,
            success:function(data){
                $( "#detail_so" ).html('');
                console.log(data);
                $('#shop').val(data.data.shop.name);
                $('#seller').val(data.data.seller.name);
                $('#trans_no').val(data.data.trans_no);
                $('#trans_date').val(data.data.trans_date);
                $('#notes').val(data.data.notes);
                $('#id').val(data.data.id);
                let detail = data.data.detail
                $.each( detail, function( i, item ) {
                    console.log(item);
                    var newListItem = "<tr> <td> "+item.item_name+" </td> <td> "+item.sku+" </td> <td> "+item.qty+" </td>" + item + "</tr>";
                    $( "#detail_so" ).append( newListItem );
                });
                if(data.data.status == 'open'){
                    $('#button-open').hide();
                }else{
                    $('#button-open').show();
                }
            },
            complete:function() {

            }
        });

        $('body').on('click', '#button-open', function () {
    let stockopname_id = $('#id').val();
    let token   = "{{ csrf_token() }}"
    
        Swal.fire({
            title: 'Apakah Kamu Yakin',
            text: "mengubah status menjadi open?",
            icon: 'question',
            showCancelButton: true,
            cancelButtonText: 'TIDAK',
            confirmButtonText: 'YA, UBAH!'
        }).then((result) => {
            if (result.isConfirmed) {

                //fetch to delete data
                $.ajax({

                    url: `/stockopname/${stockopname_id}/confirm`,
                    type: "POST",
                    cache: false,
                    data: {
                        "_token": token,
                        "type": "open"
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

    function detail(id){
        $('#modal_update').modal('show');

        $.ajax({
            type : 'get',
            data: {},
            url : "{{ url('users') }}/"+id,
            success:function(data){
                $( "#detail_so" ).html('');
                console.log(data);
                $('#name').val(data.data.name);
                $('#username').val(data.data.username);
                $('#password').val(data.data.trans_no);
                $('#status').val(data.data.trans_date);
                $('#id').val(data.data.id);
                let detail = data.data.detail
                $.each( detail, function( i, item ) {
                    console.log(item);
                    var newListItem = "<tr> <td> "+item.item_name+" </td> <td> "+item.sku+" </td> <td> "+item.qty+" </td>" + item + "</tr>";
                    $( "#detail_so" ).append( newListItem );
                });
                if(data.data.status == 'open'){
                    $('#button-open').hide();
                }else{
                    $('#button-open').show();
                }
            },
            complete:function() {

            }
        });

        $('body').on('click', '#button-open', function () {
    let stockopname_id = $('#id').val();
    let token   = "{{ csrf_token() }}"
    
        Swal.fire({
            title: 'Apakah Kamu Yakin',
            text: "mengubah status menjadi open?",
            icon: 'question',
            showCancelButton: true,
            cancelButtonText: 'TIDAK',
            confirmButtonText: 'YA, UBAH!'
        }).then((result) => {
            if (result.isConfirmed) {

                //fetch to delete data
                $.ajax({

                    url: `/stockopname/${stockopname_id}/confirm`,
                    type: "POST",
                    cache: false,
                    data: {
                        "_token": token,
                        "type": "open"
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
</script>
@endpush
