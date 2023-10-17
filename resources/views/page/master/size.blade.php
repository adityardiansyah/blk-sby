@extends('layouts.master')

@section('content')
<div class="page-heading">
    <h3>Ukuran</h3>
</div>
<div class="page-content">
    <section class="section">
        <div class="card">
            <div class="card-header">
                {!! NavHelper::section('header') !!}
                {{-- <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#modal_add"><i class="bi bi-plus"></i> Tambah</button> --}}
            </div>

            <div class="card-body">
                <table class="table table-striped" id="table1">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Ukuran</th>
                            <th>Tgl. dibuat</th>
                            <th>
                            @if (Auth::user()->id == 1) 
                            Action</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $key => $item)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ date('Y-m-d', strtotime($item->created_at)) }}</td>
                                {{-- <td>
                                    <span class="">{{ Str::ucfirst($item->status) }}</span>
                                </td> --}}
                                <td>
                                <form onsubmit="return confirm(Hapus Data?)" class='d-inline' action=" {{ url ('/size/' .$item->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                @if (Auth::user()->id == 1) 
                                <button type="submit" name="submit" class="btn btn-danger btn-sm" > Delete</button>
                                @endif
                                </form>
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
                    <label>Ukuran</label>
                    <div class="form-group">
                        <input type="text" placeholder="Ukuran"
                            class="form-control" name="name" required value="{{ old('name') }}">
                    </div>
                    {{-- <label>Ukuran</label>
                    <div class="form-group">
                        <select name="shop_id" id="" class="form-control" required value="{{ old('shop_id') }}"> --}}
                            {{-- <option value="">Pilih Ukuran</option> --}}
                            {{-- @foreach ($data as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach --}}
                        {{-- </select>
                    </div> --}}
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
    function get_data(){
        $.ajax({
            type : 'get',
            data: {},
            url : "{{ url('list-size') }}",
            success:function(data){ 
                $('.list-size').html(data.html);
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
        let token = $('input[name="_token"]').val();

        let fd = new FormData();
        fd.append('_token', token);
        fd.append('name', name);

        setTimeout(() => {
            window.location=window.location;
        }, 1200);

        $.ajax({
            type:'POST',
            url:"{{ route('master.size.store') }}",
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
