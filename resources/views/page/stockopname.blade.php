@extends('layouts.master')

@section('content')
<div class="page-heading">
    <h3>Stok Fisik</h3>
</div>
<div class="page-content">
    <section class="section">
        <div class="card">
            <div class="card-header">
                {{-- <button type="button" class="btn btn-warning float-end" data-bs-toggle="modal" data-bs-target="#modal_add"><i class="bi bi-eye"></i></button> --}}
            </div>
            <div class="card-body">
                <table class="table table-striped" id="table1">
                    <thead>
                        <tr>
                            <th>No. Transaksi</th>
                            <th>Tanggal Transaksi</th>
                            <th>Nama Seller</th>
                            <th>Nama Toko</th>
                            <th>Notes</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $key => $item)
                            <tr>
                                <td>{{ $item->trans_no }}</td>
                                <td>{{ date('Y-m-d', strtotime($item->trans_date)) }}</td>
                                <td>{{ $item->seller->name }}</td>
                                <td>{{ $item->shop->name }}</td>
                                <td>{{ $item->notes }}</td>
                                <td>
                                    <span class="">{{ Str::ucfirst($item->status) }}</span>
                                </td>
                                    <td>
                                        {{-- <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#modal_show">Detail</button> --}}
                                        <button type="button" class="btn btn-primary btn-sm" onclick="lihat({{ $item->id }})">Detail</button>
                                    </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>

    </section>
</div>

<div class="modal fade text-left modal-xl" id="modal_show" tabindex="-1" role="dialog"
    aria-labelledby="myModalLabel33" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered"
        role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel33"> Detail Stok Fisik </h4>
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
                        <div class="col-md-6">
                            <label>No. Transaksi</label>
                            <div class="form-group">
                                <input readonly type="text" placeholder="No. Transaksi"
                                    class="form-control" name="notrans" id="trans_no" required value="{{ old('trans_no') }}">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label>Tgl. Transaksi</label>
                            <div class="form-group">
                                <input readonly type="date" placeholder="Tgl. Transaksi"
                                    class="form-control" name="tgltrans" id="trans_date" required value="{{ old('trans_date') }}">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <label>Nama Seller</label>
                            <div class="form-group">
                                <input readonly type="text" placeholder="Nama Seller"
                                    class="form-control" name="name" id="seller" required value="{{ old('name') }}">
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <label>Nama Toko</label>
                            <div class="form-group">
                                <input readonly type="text" placeholder="Tgl Pengiriman"
                                    class="form-control" name="name" id="shop" required value="{{ old('name') }}">
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <label>Notes</label>
                            <div class="form-group">
                                <input readonly type="text" placeholder="Notes"
                                    class="form-control" name="notes" id="notes" required value="{{ old('notes') }}">
                            </div>
                        </div>
                    </div>
                    
                    <hr>
                    <h6>Detail</h6>
                    <div class="card">
                        <div class="card-body">
                            <table class="table table-striped table-bordered" id="table1">
                                <thead>
                                    <tr>
                                        <th>Nama Barang</th>
                                        <th>SKU</th>
                                        <th>Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody id="detail_so"></tbody>
                            </table>
                        </div>
                    </div>

                </div>
                @if (Auth::user()->id == 1 && 2)
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary ml-1" id="button-open">
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Open</span>
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

    function lihat(id){
        $('#modal_show').modal('show');

        $.ajax({
            type : 'get',
            data: {},
            url : "{{ url('stockopname') }}/"+id,
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
</script>
@endpush