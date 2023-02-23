@extends('layouts.master')

@section('content')
<div class="page-heading">
    <h3>SKU</h3>
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
                            <th>Nama Pilang</th>
                            <th>SKU</th>
                        </tr>
                    </thead>
                    <tbody class="list-sku">
                        
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
                <button type="button" class="close btn-tutup" data-bs-dismiss="modal"
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
            <form action="{{ route('master.sku.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <label>Nama Pilang</label>
                    <div class="form-group">
                        <select name="product_master_id" id="" class="form-control choices" required value="{{ old('shop_id') }}">
                            <option value="">-- Pilih Nama Pilang --</option>
                            @foreach ($master as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <label>SKU</label>
                    <div class="form-group">
                        <input type="text" placeholder="SKU"
                            class="form-control" name="sku" required value="{{ old('sku') }}">
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-secondary btn-tutup"
                        data-bs-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Tutup</span>
                    </button>
                    <button type="button" class="btn btn-primary ml-1 btn-simpan">
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Simpan & Buat Lagi</span>
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
            url : "{{ url('list-sku') }}",
            success:function(data){
                $('.list-sku').html(data);
            }
        });
    }
    get_data();

    $(".btn-simpan").click(function(e){
  
        e.preventDefault();

        var sku = $("input[name=sku]").val();
        var product_master_id = $('select[name=product_master_id] option').filter(':selected').val();
        let token = $('input[name="_token"]').val();

        let fd = new FormData();
        fd.append('_token', token);
        fd.append('sku', sku);
        fd.append('product_master_id', product_master_id);

        $.ajax({
            type:'POST',
            url:"{{ route('master.sku.store') }}",
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
                message(data.message);
                get_data();
            },
            complete: function () {
                $('.btn-simpan').prop('disabled',false);
                $('.btn-simpan').html('')
                $('.btn-simpan').append('Simpan & Buat Lagi')
                $("input[name=sku]").val("");
                $('select[name=product_master_id] option').filter(':selected').val("");
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