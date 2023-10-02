@extends('layouts.master')

@section('content')
    <div class="page-heading">
        <h3>Seller</h3>
    </div>
    <div class="page-content">
        <section class="section">
            <div class="card">
                <div class="card-header">
                    <a href="{{ route('sales.index') }}"><button class="btn btn-secondary float-end ms-2">Reset</button></a>
                    <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal"
                        data-bs-target="#modal_filter"><i class="bi bi-funnel"></i> Filter</button>
                </div>
                <div class="card-body">
                    <table class="table table-striped" id="table1">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Invoice</th>
                                <th>Tgl Transaksi</th>
                                <th>Nama Toko</th>
                                <th>Nama Seller</th>
                                <th>Total Harga</th>
                                <th>Notes</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $key => $item)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $item->invoice }}</td>
                                    <td>{{ $item->trans_date }}</td>
                                    <td>{{ $item->shop->name }}</td>
                                    <td>{{ $item->seller->name }}</td>
                                    <td>Rp.{{ number_format($item->total_tax, 2, '.', ',') }}</td>
                                    <td>{{ $item->notes }}</td>
                                    <td>{{ $item->status }}</td>
                                    <td>
                                        <button type="button" class="btn btn-primary btn-sm"
                                            onclick="show({{ $item->id }})">Detail</button>
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
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">Detail Penjualan </h4>
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
                @if (count($data) > 0)
                    <form action="{{ route('sales.show', ['id' => $item->id]) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="id" id="id">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Invoice</label>
                                    <div class="form-group">
                                        <input type="text" readonly placeholder="Invoice" class="form-control"
                                            name="invoice" id="invoice" required value="{{ old('invoice') }}">
                                    </div>
                                    <label>Tanggal Transaksi</label>
                                    <div class="form-group">
                                        <input type="text" readonly placeholder="tanggal transaksi" class="form-control"
                                            name="trans_date" id="trans_date" required value="{{ old('trans_date') }}">
                                    </div>
                                    <label>Nama Toko</label>
                                    <div class="form-group">
                                        <input type="text" readonly placeholder="nama toko" class="form-control"
                                            name="shop" id="shop" required value="{{ old('shop') }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label>Nama Seller</label>
                                    <div class="form-group">
                                        <input type="text" readonly placeholder="name penjual" class="form-control"
                                            name="seller" id="seller" required value="{{ old('seller') }}">
                                    </div>
                                    <label>Total Harga</label>
                                    <div class="form-group">
                                        <input type="text" readonly placeholder="total harga" class="form-control"
                                            name="total_tax" id="total_tax" required value="{{ old('total_tax') }}">
                                    </div>
                                    <label>Notes</label>
                                    <div class="form-group">
                                        <input type="text" readonly placeholder="notes" class="form-control"
                                            name="notes" id="notes" required value="{{ old('notes') }}">
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
                                                <th>Nama Item</th>
                                                <th>SKU</th>
                                                <th>Jumlah</th>
                                                <th>Unit</th>
                                                <th>Harga Unit</th>
                                                <th>Harga Kotor</th>
                                                <th>Diskon</th>
                                                <th>Total</th>
                                                <th>Notes</th>
                                            </tr>
                                        </thead>
                                        <tbody id="detail">
                                    </table>
                                </div>
                            </div>
                            <div class="modal-footer">
                                @if (Auth::user()->id == 1 && 2)
                                    <button id="btn-open" type="button" class="btn btn-primary ml-1">
                                        <i class="bx bx-check d-block d-sm-none"></i>
                                        <span class="d-none d-sm-block">Open</span>
                                    </button>
                                @endif
                                <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                                    <i class="bx bx-x d-block d-sm-none"></i>
                                    <span class="d-none d-sm-block">Tutup</span>
                                </button>
                            </div>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>

    <div class="modal fade text-left" id="modal_filter" role="dialog" aria-labelledby="myModalLabel33"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">Filter</h4>
                    <button type="button" class="close btn-tutup" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('sales.index') }}" method="get">
                        <div class="col-md-12" id="filter">
                            <div>
                                <small for="">Tanggal Awal</small>
                                <input type="date" name="date_start" id="date_start" class="form-control"
                                    value="{{ request('date_start') }}">
                            </div>
                            <div class="">
                                <small for="">Tanggal Akhir</small>
                                <input type="date" name="date_end" id="date_end" class="form-control"
                                    value="{{ request('date_end') }}">
                            </div>
                            <div class="">
                                <small for="">Cabang Toko</small>
                                <select name="shop_id" class="form-control" id="shop_id">
                                    <option value="">Pilih Cabang</option>
                                    @foreach ($shop as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="">
                                <small for="">Nama Seller</small>
                                <select name="seller_id" class="form-control" id="seller_id">
                                    <option value="">Pilih Seller</option>
                                    @foreach ($seller as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-secondary btn-tutup" data-bs-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Tutup</span>
                    </button>
                    <input type="submit" class="btn btn-primary" value="Terapkan">
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

        // $(".btn-simpan").click(function(e){

        //     e.preventDefault();

        //     let name = $("input[name=invoice]").val();
        //     let username = $("input[name=trans_date]").val();
        //     let password = $("input[name=name]").val();
        //     let repassword = $("input[name=repassword]").val();
        //     let email = $("input[name=email]").val();
        //     let phone = $("input[name=phone]").val();
        //     let photo = $("input[name=photo]")[0].files[0];
        //     let shop_id = $('select[name=shop_id] option').filter(':selected').val();
        //     let group_id = $('select[name=group_id] option').filter(':selected').val();
        //     let token = $('input[name="_token"]').val();

        //     if(password !== repassword){
        //         message('Password tidak sama!', false);
        //         return;
        //     }
        //     let fd = new FormData();
        //     fd.append('_token', token);
        //     fd.append('name', name);
        //     fd.append('password', password);
        //     fd.append('username', username);
        //     fd.append('phone', phone);
        //     fd.append('shop_id', shop_id);
        //     fd.append('repassword', repassword);
        //     fd.append('img', photo);
        //     fd.append('email', email);
        //     fd.append('group_id', group_id);


        $('body').on('click', '#btn-open', function() {
            let sales_id = $('#id').val();
            let token = "{{ csrf_token() }}";

            Swal.fire({
                title: 'Apakah Kamu Yakin',
                text: "ingin merubah status ini?",
                icon: 'question',
                showCancelButton: true,
                cancelButtonText: 'TIDAK',
                confirmButtonText: 'YA, TERIMA'
            }).then((result) => {
                console.log(sales_id);
                if (result.isConfirmed) {
                    //fetch to delete data
                    $.ajax({

                        url: `/sales/${sales_id}/update`,
                        type: "POST",
                        cache: false,
                        data: {
                            "_token": token,
                            "type": "open"
                        },
                        success: function(response) {

                            //show success message
                            Swal.fire({
                                type: 'success',
                                icon: 'success',
                                title: `${response.message}`,
                                showConfirmButton: false,
                                timer: 3000
                            });
                            setTimeout(() => {
                                window.location = window.location;
                            }, 1200);
                        }
                    });


                }
            })

        });

        function show(id) {
            $('#modal_show').modal('show');

            $.ajax({
                type: 'get',
                data: {},
                url: "{{ url('sales') }}/" + id,
                success: function(data) {
                    $("#detail").html('');
                    console.log(data);
                    $('#invoice').val(data.data.invoice);
                    $('#trans_date').val(data.data.trans_date);
                    $('#shop').val(data.data.shop.name);
                    $('#seller').val(data.data.seller.name);
                    $('#total_tax').val(data.data.total_tax);
                    $('#notes').val(data.data.notes);
                    $('#id').val(data.data.id);
                    let detail = data.data.detail
                    $.each(detail, function(i, item) {
                        console.log(item);
                        var newListItem = "<tr> <td>" + item.item_name + "</td> <td>" + item.sku +
                            "</td><td>" + item.qty + "</td><td>" + item.unit + "</td><td>" + item
                            .unit_price + "</td><td>" + item.bruto_price + "</td><td>" + item.discount +
                            "</td><td>" + item.nett_total + "</td><td>" + item.notes + "</td>" + item +
                            "</tr>";
                        $("#detail").append(newListItem);
                    });
                    if (data.data.status == 'open') {
                        $('#btn-open').hide();
                    } else {
                        $('#btn-open').show();
                    }
                },
                complete: function() {}
            });

        }
    </script>
@endpush
