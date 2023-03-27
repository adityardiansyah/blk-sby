@extends('layouts.master')

@section('content')
<div class="page-heading">
    {{-- {{ Session::get('menu_active') }} --}}
    <h3> TOKO </h3>
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
                            <th>Nama</th>
                            <th>Lokasi</th>
                            <th>Alamat</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $key => $item)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->location }}</td>
                            <td>{{ $item->address }}</td>
                            <td>
                                <span class="">{{ Str::ucfirst($item->status) }}</span>
                            </td>
                            {{-- <td><a href="{{ url('/shop'.$item->name.'/shop') }}" class="btn btn-warning btn-sm">Edit</a></td> --}}
                            <td>
                            {{-- <button class="btn btn-warning btn-sm edit-btn" data-id="{{ $item->id }}" data-bs-toggle="modal" data-bs-target="#modaledit">Edit</button> --}}
                                <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modal_edit" onclick="edit_data({{ $item->id }})">Edit</button>
                                {{-- <button type="button" class="btn btn-warning btn-sm" onclick="edit_data({{ $item->id }})"><i class="bi bi-pencil"></i></button> --}}
                            </td>
                        </tr> 
                        @endforeach
                    </tbody>
                </table>
            </div>
            </div>
        </div>
    </section>

<div class="modal fade text-left" id="modal_add" tabindex="-1" role="dialog"
    aria-labelledby="myModalLabel33" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered"
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
                    <label>Nama Toko</label>
                    <div class="form-group">
                        <input type="text" placeholder="nama toko"
                            class="form-control" name="name" required value="{{ old('name') }}">
                    </div>
                    <label>Lokasi</label>
                    <div class="form-group">
                        <input type="text" placeholder="Lokasi"
                            class="form-control" name="location" required value="{{ old('location') }}">
                    </div>
                    <label>Alamat</label>
                    <div class="form-group">
                        <input type="text" placeholder="Alamat"
                            class="form-control" name="address" required value="{{ old('address') }}">
                    </div>
                    <label>Latitude</label>
                    <div class="form-group">
                        <input type="text" placeholder="latitude"
                            class="form-control" name="latitude" required value="{{ old('latitude') }}">
                    </div>
                    <label>Longitude</label>
                    <div class="form-group">
                        <input type="text" placeholder="longitude"
                            class="form-control" name="longitude" required value="{{ old('longitude') }}">
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
</div>

<div class="modal fade text-left" id="modal_edit" tabindex="-1" role="dialog"
    aria-labelledby="myModalLabel33" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered"
        role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel33">Edit Data </h4>
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
            <form action="{{ route('master.shop.update', ['id'=> $item->id]) }}" method="POST"  class="edit-form" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" name="id" id="id">
                <div class="modal-body">
                    <label>Nama Toko</label>
                    <div class="form-group">
                        <input type="text" placeholder="nama toko"
                            class="form-control" name="name" id="shop_name" required value="{{ old('name') }}">
                    </div>
                    <label>Lokasi</label>
                    <div class="form-group">
                        <input type="text" placeholder="Lokasi"
                            class="form-control" name="location" id="shop_location" required value="{{ old('location') }}">
                    </div>
                    <label>Alamat</label>
                    <div class="form-group">
                        <input type="text" placeholder="Alamat"
                            class="form-control" name="address" id="shop_address" required value="{{ old('address') }}">
                    </div>
                    <label>Latitude</label>
                    <div class="form-group">
                        <input type="text" placeholder="latitude"
                            class="form-control" name="latitude" id="shop_latitude" required value="{{ old('latitude') }}">
                    </div>
                    <label>Longitude</label>
                    <div class="form-group">
                        <input type="text" placeholder="longitude"
                            class="form-control" name="longitude" id="shop_longitute" required value="{{ old('longitude') }}">
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

//tambah
    function get_data(){
        $.ajax({
            type : 'get',
            data: {},
            url : "{{ url('/shop') }}",
            success:function(data){ 
                $('#shop').html(data.html);
            },
            complete:function() {
                $("#table-view").DataTable();
            }
        });
    }
    get_data();

    $(".btn-simpan").click(function(e){

        e.preventDefault();

        var name = $("input[name=name]").val();
        var location = $("input[name=location]").val();
        var address = $("input[name=address]").val();
        var address = $("input[name=address]").val();
        var latitude = $("input[name=latitude]").val();
        var longitude = $("input[name=longitude]").val();
        let token = $('input[name="_token"]').val();

        let fd = new FormData();
        fd.append('_token', token);
        fd.append('name', name);
        fd.append('address', address);
        fd.append('location', location);
        fd.append('latitude', latitude);
        fd.append('longitude', longitude);

        setTimeout(() => {
            window.location=window.location;
        }, 1200);

        $.ajax({
            type:'POST',
            url:"{{ route('master.shop.store') }}",
            headers: {
                'X-CSRF-TOKEN' : token
            },
            data:fd,
            contentType: false,
            processData: false,
            dataType: 'json',
            beforeSend: function () {
                $('.btn-simpan').prop('disabled',true);
                $('.btn-simpan').html('')
                $('.btn-simpan').append('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>Loading...')
            },
            success:async function(data){
                message(data.message, data.success);
                get_data();
            },
            complete: function () {
                $('.btn-simpan').prop('disabled',false);
                $('.btn-simpan').html('')
                $('.btn-simpan').append('Simpan');
                $("input[name=size]").val("");
            },
            error:function(params) {
                let txt = params.responseJSON;
                $.each(txt.errors,function (k,v) {
                    message(v, false);
                });
            }
        });

    });

//edit
        function edit_data(id){
        $('#modal_edit').modal('show');

        $.ajax({
            type : 'get',
            data: {},
            url : "{{ url('shop/edit') }}/"+id,
            success:function(data){
                console.log(data);
                $('#shop_name').val(data.data.name);
                $('#shop_address').val(data.data.address);
                $('#shop_location').val(data.data.location);
                $('#shop_latitude').val(data.data.latitude);
                $('#shop_longitude').val(data.data.longitude);
            },
            complete:function() {
            }
            });
        }
            edit_data();
            $(".btn-simpan").click(function(e){

            e.preventDefault();

            var name = $("input[name=name]").val(data.data.name);
            var location = $("input[name=location]").val(data.data.location);
            var address = $("input[name=address]").val(data.data.address);
            var latitude = $("input[name=latitude]").val(data.data.latitude);
            var longitude = $("input[name=longitude]").val(data.data.longitude);
            let token = $('input[name="_token"]').val(data.data.token);

            let fd = new FormData();
            fd.append('_token', token);
            fd.append('name', name);
            fd.append('address', address);
            fd.append('location', location);
            fd.append('latitude', latitude);
            fd.append('longitude', longitude);

            // setTimeout(() => {
            //     window.location=window.location;
            // }, 1200);

            $.ajax({
                type:'POST',
                url:"{{ route('master.shop.update') }}",
                headers: {
                    'X-CSRF-TOKEN' : token
                },
                data:fd,
                contentType: false,
                processData: false,
                dataType: 'json',
                beforeSend: function () {
                    $('.btn-simpan').prop('disabled',true);
                    $('.btn-simpan').html('')
                    $('.btn-simpan').append('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>Loading...')
                },
                success:async function(data){
                    message(data.message, data.success);
                    get_data();
                },
                complete: function () {
                    $('.btn-simpan').prop('disabled',false);
                    $('.btn-simpan').html('')
                    $('.btn-simpan').append('Simpan');
                    $("input[name=size]").val("");
                },
                error:function(params) {
                    let txt = params.responseJSON;
                    $.each(txt.errors,function (k,v) {
                        message(v, false);
                    });
                }
            });

        });

    //update
        function update_data(id){
            $.ajax({
            type: 'PUT',
            url: "{{ url('shop/update') }}",
            data: {
                $('#shop_name').val(data.data.name);
                $('#shop_address').val(data.data.address);
                $('#shop_location').val(data.data.location);
                $('#shop_latitude').val(data.data.latitude);
                $('#shop_longitude').val(data.data.longitude);
            _token: '{{ csrf_token() }}'
        },
            success :function(data){
                console.log(data);
            $('#shop_name').val(data.data.name),
            $('#shop_address').val(data.data.address),
            $('#shop_location').val(data.data.location),
            $('#shop_latitude').val(data.data.latitude),
            $('#shop_longitudee').val(data.data.longitude)
            '{{ csrf_token() }}'
        },
        complete:function() {
            }
            });
        }  
            update_data();
            $(".btn-simpan").click(function(e){

            e.preventDefault();

            var name = $("input[name=name]").val();
            var location = $("input[name=location]").val();
            var address = $("input[name=address]").val();
            var address = $("input[name=address]").val();
            var latitude = $("input[name=latitude]").val();
            var longitude = $("input[name=longitude]").val();
            let token = $('input[name="_token"]').val();

            let fd = new FormData();
            fd.append('_token', token);
            fd.append('name', name);
            fd.append('address', address);
            fd.append('location', location);
            fd.append('latitude', latitude);
            fd.append('longitude', longitude);

            // setTimeout(() => {
            //     window.location=window.location;
            // }, 1200);

            $.ajax({
                type:'POST',
                url:"{{ route('master.shop.update') }}",
                headers: {
                    'X-CSRF-TOKEN' : token  
                },
                data:fd,
                contentType: false,
                processData: false,
                dataType: 'json',
                beforeSend: function () {
                    $('.btn-simpan').prop('disabled',true);
                    $('.btn-simpan').html('')
                    $('.btn-simpan').append('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>Loading...')
                },
                success:async function(data){
                    message(data.message, data.success);
                    get_data();
                },
                complete: function () {
                    $('.btn-simpan').prop('disabled',false);
                    $('.btn-simpan').html('')
                    $('.btn-simpan').append('Simpan');
                    $("input[name=size]").val("");
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




