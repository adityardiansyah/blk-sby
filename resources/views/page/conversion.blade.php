@extends('layouts.master')

@section('content')
<div class="page-heading">
    <h3>Daftar Produk</h3>
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
                            <th>No.</th>
                            <th>Nama Toko</th>
                            <th>Nama Barang</th>
                            <th>Nama SKU</th>
                            <th>Qty</th>
                            <th>Harga Satuan</th>
                            <th>Warna</th>
                            <th>Ukuran</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $key => $item)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $item->shop->name }}</td>
                                <td>{{ $item->name_item }}</td>
                                <td>{{ $item->sku }}</td>
                                <td>{{ $item->qty_final }}</td>
                                <td>{{ $item->price }}</td>
                                <td>{{ $item->color }}</td>
                                <td>{{ $item->size }}</td>
                                <td>
                                    
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </section>
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