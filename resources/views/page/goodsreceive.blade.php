@extends('layouts.master')

@section('content')
<div class="page-heading">
    <h3>Penerimaan Barang</h3>
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
                            <th>No.</th>
                            <th>Nama Toko</th>
                            <th>Nama Seller</th>
                            <th>No SJ Pengiriman</th>
                            <th>Tgl. Pengiriman</th>
                            <th>No SJ Penerimaan</th>
                            <th>Tgl. Penerimaan</th>
                            <th>Notes</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $key => $item)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $item->shop->name }}</td>
                                <td>{{ $item->seller->name }}</td>
                                <td>{{ $item->no_sj_from }}</td>
                                <td>{{ date('Y-m-d', strtotime($item->send_date)) }}</td>
                                <td>{{ $item->no_sj_receive }}</td>
                                <td>{{ date('Y-m-d', strtotime($item->receive_date)) }}</td>
                                <td>{{ $item->notes }}</td>
                                <td>
                                    <span class="">{{ Str::ucfirst($item->status) }}</span>
                                </td>
                                    <td>
                                        {{-- <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#modal_show">Detail</button> --}}
                                        <button type="button" class="btn btn-primary btn-sm" onclick="show({{ $item->id }})">Detail</button>
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
                <h4 class="modal-title" id="myModalLabel33"> Detail Penerimaan Barang </h4>
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
            <form action="{{ route('goodsreceive.show', ['id' => $item->id]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" name="id" id="id">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                    <label>Nama Toko</label>
                    <div class="form-group">
                        <input readonly type="text" placeholder="Nama Toko"
                            class="form-control" name="name" id="shop" required value="{{ old('name') }}">
                    </div>
                    <label>Nama Seller</label>
                    <div class="form-group">
                        <input readonly type="email" placeholder="Nama Seller"
                            class="form-control" name="name" id="name" required value="{{ old('name') }}">
                    </div>
                    <label>No. SJ Pengiriman</label>
                    <div class="form-group">
                        <input readonly type="text" placeholder="No. SJ Pengiriman"
                            class="form-control" name="no_sj_from" id="no_sj_from" required value="{{ old('no_sj_from') }}">
                    </div>
                    <label>Tgl Pengiriman</label>
                    <div class="form-group">
                        <input readonly type="text" placeholder="Tgl Pengiriman"
                            class="form-control" name="sent_date" id="sent_date" required value="{{ old('sent_date') }}">
                    </div>
                        </div>

                    <div class="col-md-6">
                    <label>No. SJ Penerimaan</label>
                    <div class="form-group">
                        <input readonly type="text" placeholder="No. SJ Penerimaan"
                            class="form-control" name="no_sj_receive" id="no_sj_receive" required value="{{ old('no_sj_receive') }}">
                    </div>
                    <label>Tgl Penerimaan</label>
                    <div class="form-group">
                        <input readonly type="text" placeholder="Tgl Penerimaan"
                            class="form-control" name="receive_date" id="receive_date" required value="{{ old('receive_date') }}">
                    </div>
                    <label>Notes</label>
                    <div class="form-group">
                        <input readonly type="text" placeholder="Notes"
                            class="form-control" name="notes" id="notes" required value="{{ old('notes') }}">
                    </div>
                    </div>
                    </div>
                    <hr>
                    <div class="card">
                        <div class="card-body">
                            <table class="table table-striped table-bordered" id="table1">
                                <thead>
                                    <tr>
                                        <th>Nama</th>
                                        <th>SKU</th>
                                        <th>Jumlah</th>
                                        <th>Harga Beli</th>
                                    </tr>
                                </thead>
                                <tbody id="detail_gr"></tbody>
                            </table>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary ml-1">
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Buka</span>
                    </button>
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

    function show(id){
        $('#modal_show').modal('show');

        $.ajax({
            type : 'get',
            data: {},
            url : "{{ url('goodsreceive') }}/"+id,
            success:function(data){
                // console.log(data);
                $('#shop').val(data.data.shop.name);
                $('#name').val(data.data.seller.name);
                $('#no_sj_from').val(data.data.no_sj_from);
                $('#sent_date').val(data.data.sent_date);
                $('#no_sj_receive').val(data.data.no_sj_receive);
                $('#receive_date').val(data.data.receive_date);
                $('#notes').val(data.data.notes);
                $('#id').val(data.data.id);
                let detail = data.data.detail
                $.each( detail, function( i, item ) {
                    console.log(item);
                    var newListItem = "<tr> <td> "+item.item_name+" </td> <td> "+item.sku+" </td> <td> "+item.qty+" </td> <td> "+item.purchase_price+" </td>" + item + "</tr>";
                    $( "#detail_gr" ).append( newListItem );
                });
            },
            complete:function() {

            }
        });
    }
</script>
@endpush