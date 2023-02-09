@extends('layouts.master')

@section('content')
<div class="page-heading">
    <h3>Laporan</h3>
</div>
<div class="page-content">
    <section class="section">
        <div class="card">
            <div class="card-header">
                <div class="col-md-6 d-flex">
                    <div>
                        <small for="">Tanggal Awal</small>
                        <input type="date" name="date_start" id="date_start" class="form-control" placeholder="Tanggal Awal">
                    </div>
                    <div class="ms-2">
                        <small for="">Tanggal Akhir</small>
                        <input type="date" name="date_end" id="date_end" class="form-control">
                    </div>
                    <div class="ms-2">
                        <small for="">Cabang Toko</small>
                        <select name="shop_id" class="form-control" id="shop">
                            <option value="">Pilih Cabang</option>
                            @foreach ($shop as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-striped" id="table1">
                    <thead>
                        <tr>
                            <th width="100px">No.</th>
                            <th>Nama Laporan</th>
                            <th width="400px">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Laporan Stok</td>
                            <td>
                                <button class="btn btn-success" onclick="export_excel('laporan_stock')"><i class="bi bi-download"></i> Download Excel</button>
                                <button class="btn btn-danger" onclick="export_pdf('laporan_stock')"><i class="bi bi-download"></i> Download PDF</button>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Laporan Penjualan</td>
                            <td>
                                <button class="btn btn-success" onclick="export_pdf('laporan_sales')"><i class="bi bi-download"></i> Download Excel</button>
                                <button class="btn btn-danger" onclick="export_pdf('laporan_sales')"><i class="bi bi-download"></i> Download PDF</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </section>
</div>

<div class="modal fade text-left" id="modal_laporan" tabindex="-1" role="dialog"
    aria-labelledby="myModalLabel33" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-full"
        role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel33">Tambah Data </h4>
                <button type="button" class="close" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body" id="body-laporan">
                <iframe id='attachment' width='100%' height='700' frameborder='0' allowfullscreen></iframe>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
    <script>
        function export_pdf(params) {
            var date_start = $('#date_start').val();
            var date_end = $('#date_end').val();
            var shop_id = $('select[name=shop_id] option').filter(':selected').val();
            if(date_start == null || date_start == ""){
                message("Tanggal awal belum diisi!", false);
                return;
            }
            if(date_end == null || date_end == ""){
                message("Tanggal akhir belum diisi!", false);
                return;
            }
            if(shop_id == null || shop_id == ""){
                message("Cabang Toko belum pilih!", false);
                return;
            }

            let url;
            if(params === 'laporan_stock'){
                url = "{{ route('laporan.stock', [':date_start',':date_end',':shop_id']) }}";
                url = url.replace(':date_start', date_start);
                url = url.replace(':date_end', date_end);
                url = url.replace(':shop_id', shop_id);
            }

            $('#modal_laporan').modal('show');
            $("#attachment").attr('src', url);
        }

        function export_excel(params) {
            var date_start = $('#date_start').val();
            var date_end = $('#date_end').val();
            var shop_id = $('select[name=shop_id] option').filter(':selected').val();
            if(date_start == null || date_start == ""){
                message("Tanggal awal belum diisi!", false);
                return;
            }
            if(date_end == null || date_end == ""){
                message("Tanggal akhir belum diisi!", false);
                return;
            }
            if(shop_id == null || shop_id == ""){
                message("Cabang Toko belum pilih!", false);
                return;
            }

            let url;
            if(params === 'laporan_stock'){
                url = "{{ route('laporan.excel.stock', [':date_start',':date_end',':shop_id']) }}";
                url = url.replace(':date_start', date_start);
                url = url.replace(':date_end', date_end);
                url = url.replace(':shop_id', shop_id);
            }
            console.log(url);
            window.open(url);
        }
    </script>
@endpush