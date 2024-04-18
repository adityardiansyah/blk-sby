@extends('layouts.master')

@section('content')
    <div class="page-heading">
        <h3>Hubungi Kami</h3>
    </div>
    <div class="page-content">
        <section class="section">
            <div class="row">
                <div class="col-lg-9">
                    <div class="card">
                        <div class="card-body">
                        <form id="formKontak" action="{{ route('hubungi-kami.store') }}" method="post">
                            @csrf
                            <label for="">Masukkan Data</label>
                            @if (!empty($hubungi_kami))
                                @foreach ($hubungi_kami as $item)
                                <div id="inputFormRow">
                                    <div class="input-group mb-3">
                                        <input type="hidden" name="id[]" value="{{ $item->id }}">
                                        <input type="text" name="nama[]" class="form-control m-input" placeholder="Masukkan nama" autocomplete="off" value="{{ $item->judul }}">
                                        <input type="text" name="nomor[]" class="form-control m-input" placeholder="Masukkan nomor" autocomplete="off" value="{{ $item->isi }}">
                                        <div class="input-group-append">
                                            <button id="removeRow" value="{{ $item->id }}" type="button" class="btn btn-danger">Hapus</button>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            @endif
                            <div id="inputFormRow">
                                <div class="input-group mb-3">
                                    <input type="hidden" name="id[]">
                                    <input type="text" name="nama[]" class="form-control m-input" placeholder="Masukkan nama" autocomplete="off">
                                    <input type="text" name="nomor[]" class="form-control m-input" placeholder="Masukkan nomor" autocomplete="off">
                                    <div class="input-group-append">
                                        <button id="removeRow" type="button" class="btn btn-danger">Hapus</button>
                                    </div>
                                </div>
                            </div>

                            <div id="newRow"></div>
                            <button id="addRow" type="button" class="btn btn-info">Tambah Kolom</button>
                            <button type="submit" class="btn btn-primary">Simpan Data</button>
                        </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('js')
<script>
    $(document).ready(function () {
        // Ketika tombol Tambah Kolom diklik
        $("#addRow").click(function () {
            // Menambahkan baris baru ke dalam form
            var html = '';
            html += '<div id="inputFormRow">';
            html += '<div class="input-group mb-3">';
            html += '<input type="text" name="nama[]" class="form-control m-input" placeholder="Masukkan nama" autocomplete="off">';
            html += '<input type="text" name="nomor[]" class="form-control m-input" placeholder="Masukkan nomor" autocomplete="off">';
            html += '<div class="input-group-append">';
            html += '<button id="removeRow" type="button" class="btn btn-danger">Hapus</button>';
            html += '</div>';
            html += '</div>';
            html += '</div>';

            $('#newRow').append(html);
        });

        // Menghapus baris pada form
        $(document).on('click', '#removeRow', function () {
            var el = this;
            if(this.value == ''){
                $(this).closest('#inputFormRow').remove();
            }else{
                if(confirm('Apakah Anda yakin ingin menghapus?')) {
                    let token = $('input[name="_token"]').val();
                    let id = this.value; // Menyimpan nilai this.value ke dalam variabel id untuk digunakan dalam success callback
                    $.ajax({
                        type: 'POST', // Mengubah method menjadi POST
                        url: "/hubungi-kami/"+id+"/delete", // Mengubah URL dan menambahkan /delete di akhir
                        headers: {
                            'X-CSRF-TOKEN': token
                        },
                        data: {
                            _method: 'DELETE', // Menambahkan _method DELETE untuk mengatasi masalah method not allowed
                            id: id
                        },
                        success: function(data) {
                            console.log(this);
                            $(el).closest('#inputFormRow').remove();
                            message(data.message, data.success);
                        },
                        error: function(xhr) {
                            // Tangani error validasi
                            console.log(xhr.responseJSON);
                            $.each(xhr.responseJSON, function(k, v) {
                                message(v, false);
                            });
                        }
                    });
                }
            }
        });
    });
</script>

@endpush
