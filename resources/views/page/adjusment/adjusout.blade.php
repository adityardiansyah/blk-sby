@extends('layouts.master')

@section('content')
    <div class="page-heading">
        <h3>Adjusment Out</h3>
    </div>
    <div class="page-content">
        <section class="section">
            <div class="card">
                <div class="card-body">
                    {!! NavHelper::action('header') !!}
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <table class="table table-striped" id="table1">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Barang</th>
                                <th>Qty</th>
                                <th>Notes</th>
                                <th>Status</th>
                                <th>Tgl. dibuat</th>
                                <th>
                                    @if (Auth::user()->id == 1)
                                        Action
                                </th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @if ($data)
                                @foreach ($data as $key => $item)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $item->sku }}</td>
                                        <td>{{ $item->qty }}</td>
                                        <td>{{ $item->notes }}</td>
                                        <td>{{ $item->status }}</td>
                                        <td>{{ date('Y-m-d', strtotime($item->created_at)) }}</td>
                                        <td>
                                            <form onsubmit="return confirm(Hapus Data?)" class='d-inline'
                                                action=" {{ url('/adjusment/delete/' . $item->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')

                                                @if (Auth::user()->id == 1)
                                                    <button type="submit" name="submit"
                                                        class="btn btn-danger btn-sm">Delete</button>
                                                    {!! NavHelper::action('tabel', $item->id) !!}
                                                    @if ($item->status != 'confirmed')
                                                        <button type="button" class="btn btn-success btn-sm"
                                                            onclick="konfirmasi({{ $item->id }}, {{ $item->conversion_id }}, {{ $item->qty }})">Confirm</button>
                                                    @endif
                                                @endif
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>

    <div class="modal fade text-left" id="modal_add" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">Tambah Data </h4>
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
                <form action="" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <label>Type</label>
                        <div class="form-group">
                            <input type="text" placeholder="Tipe" class="form-control" name="type" required
                                value="OUT" readonly>
                        </div>
                        <div class="form-group">
                            <label for="">Toko</label>
                            <select name="shop_id" id="shop" class="form-control select2" required
                                value="{{ old('shop_id') }}">
                                <option value="">-- Pilih Nama Toko --</option>
                                @foreach ($shop as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Barang</label>
                            <select name="conversion_id" id="conversion_id" class="form-control select2" required>
                                <option value="">-- Pilih Nama Conversion --</option>

                            </select>
                        </div>
                        <label>Qty</label>
                        <div class="form-group">
                            <input type="number" placeholder="Kuantitas" class="form-control" name="qty" required
                                value="{{ old('qty') }}">
                        </div>
                        <label>Notes</label>
                        <div class="form-group">
                            <input type="text" placeholder="Catatan" class="form-control" name="notes" required
                                value="{{ old('notes') }}" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
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

    <div class="modal fade text-left" id="modal_edit" role="dialog" aria-labelledby="myModalLabel34" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel34">Edit Data </h4>
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
                <form action="" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <label>Type</label>
                        <div class="form-group">
                            <input type="text" placeholder="Tipe" class="form-control" name="type-edit" required
                                value="OUT" readonly>
                        </div>
                        <div class="form-group">
                            <label for="">Toko</label>
                            <select name="shop_id-edit" id="shop-edit" class="form-control select2" required
                                value="{{ old('shop_id') }}">
                                <option value="">-- Pilih Nama Toko --</option>

                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Barang</label>
                            <select name="conversion_id-edit" id="conversion_id-edit" class="form-control select2"
                                required>
                                <option value="">-- Pilih Nama Conversion --</option>

                            </select>
                        </div>
                        <label>Qty</label>
                        <div class="form-group">
                            <input type="number" placeholder="Kuantitas" class="form-control" name="qty-edit"
                                id="qty-edit" required value="{{ old('qty') }}">
                        </div>
                        <label>Notes</label>
                        <div class="form-group">
                            <input type="text" placeholder="Catatan" class="form-control" name="notes-edit"
                                id="notes-edit" required value="{{ old('notes') }}">
                        </div>
                        <label>Status</label>
                        <div class="form-group">
                            <input class="form-check-input" type="radio" name="status" id="status-open"
                                value="open">
                            <label class="form-check-label" for="status-open">
                                Open
                            </label>
                            <input class="form-check-input" type="radio" name="status" id="status-confirm"
                                value="confirmed">
                            <label class="form-check-label" for="status-confirm">
                                Confirm
                            </label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                            <i class="bx bx-x d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Tutup</span>
                        </button>
                        <button type="button" class="btn btn-primary ml-1 btn-update">
                            <i class="bx bx-check d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Simpan</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal Confirm --}}
    <div class="modal" id="modal-confirm">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Yakin akan merubah status <b id="title-confirm"></b> pada toko <b
                            id="toko-confirm"></b> menjadi confirm?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Klik save changes jika anda yakin dengan perubahan</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary btn-confirm">Save changes</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $("#shop").change(() => {
            let selectedShopId = $("#shop").val();

            $.ajax({
                type: 'GET',
                url: "{{ url('conversion/api') }}/" + selectedShopId,
                data: {
                    shop_id: selectedShopId
                },
                success: (data) => {
                    $('#conversion_id').empty();
                    $.each(data.data, function(index, product) {
                        let id = product.id
                        let sku = product.sku;
                        let color = product.color;
                        let size = product.size;

                        let label = sku;
                        if (color !== null) {
                            label += ' - ' + color;
                        }
                        if (size !== null) {
                            label += ' - ' + size;
                        }

                        $('#conversion_id').append('<option value="' + id + '">' + label +
                            '</option>');
                    });
                }
            })

        })

        $("#shop-edit").change(() => {
            let selectedShopId = $("#shop-edit").val();

            $.ajax({
                type: 'GET',
                url: "{{ url('conversion/api') }}/" + selectedShopId,
                data: {
                    shop_id: selectedShopId
                },
                success: (data) => {
                    $('#conversion_id-edit').empty();
                    $.each(data.data, function(index, product) {
                        let id = product.id
                        let sku = product.sku;
                        let color = product.color;
                        let size = product.size;

                        let label = sku;
                        if (color !== null) {
                            label += ' - ' + color;
                        }
                        if (size !== null) {
                            label += ' - ' + size;
                        }

                        $('#conversion_id-edit').append('<option value="' + id + '">' + label +
                            '</option>');
                    });
                }
            })

            $("#conversion_id-edit").select2({
                dropdownParent: $("#modal_edit")
            })
        })

        async function detail(id) {
            $('#modal_edit').modal('show');

            const adjusment = async () => {
                const response = await $.ajax({
                    type: 'GET',
                    url: `/adjusment/detail/${id}`
                })
                return response
            }
            const adjusmentData = await adjusment()
            const shopId = adjusmentData.data.shop_id
            const conversionId = adjusmentData.data.conversion_id

            const shop = async () => {
                const response = await $.ajax({
                    type: 'GET',
                    url: `/shop/api`
                })

                return response
            }

            const shopData = await shop()

            shopData.data.map(item => {
                let id = item.id
                let label = item.name
                let selected = (shopId == id) ? 'selected' : ''

                $('#shop-edit').append('<option ' + selected + ' value="' + id + '">' + label + '</option>')
            })

            $("#shop-edit").select2({
                dropdownParent: $("#modal_edit")
            })

            // Fetch conversion
            const conversion = async () => {
                const response = await $.ajax({
                    type: 'GET',
                    url: `/conversion/api/${shopId}`
                })

                return response
            }
            const conversionData = await conversion()
            conversionData.data.map(item => {
                let id = item.id
                let sku = item.sku
                let color = item.color
                let size = item.size
                let selected = (conversionId == id) ? 'selected' : ''
                let label = sku;
                if (color !== null) label += ' - ' + color;
                if (size !== null) label += ' - ' + size;

                $('#conversion_id-edit').append('<option ' + selected + ' value="' + id + '">' + label +
                    '</option>')
            })

            $("#conversion_id-edit").select2({
                dropdownParent: $("#modal_edit")
            })

            $('#qty-edit').val(adjusmentData.data.qty)
            $('#notes-edit').val(adjusmentData.data.notes)

            // Checked untuk radio button
            if (adjusmentData.data.status === 'open') {
                $('#status-open').prop('checked', true);
            } else if (adjusmentData.data.status === 'confirmed') {
                $('#status-confirm').prop('checked', true);
            }

            $(".btn-update").click(function(e) {

                e.preventDefault();

                let token = $('input[name="_token"]').val();
                var conversion_id = $("select[name=conversion_id-edit] option").filter(':selected').val();
                var shop_id_edit = $("select[name=shop_id-edit] option").filter(':selected').val();
                var type = $("input[name=type-edit]").val();
                var qty = $("input[name=qty-edit]").val();
                var notes = $("input[name=notes-edit]").val();
                var status = $("input[name=status]").val();

                let fd = new FormData();
                fd.append('_token', token);
                fd.append('conversion_id-edit', conversion_id);
                fd.append('type-edit', type);
                fd.append('qty-edit', qty);
                fd.append('notes-edit', notes);
                fd.append('shop_id-edit', shop_id_edit)
                fd.append('status', status);

                // auto refresh
                setTimeout(() => {
                    window.location = window.location;
                }, 1200);

                $.ajax({
                    type: 'POST',
                    url: "{{ url('adjusment/update') }}/" + id,
                    headers: {
                        'X-CSRF-TOKEN': token
                    },
                    data: fd,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    beforeSend: function() {
                        $('.btn-update').prop('disabled', true);
                        $('.btn-update').html('')
                        $('.btn-update').append(
                            '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>Loading...'
                            )
                    },
                    success: async function(data) {
                        message(data.message, data.success);
                        // get_data();
                    },
                    complete: function() {
                        $('.btn-update').prop('disabled', false);
                        $('.btn-update').html('')
                        $('.btn-update').append('Simpan');
                        $("input[name=color]").val("");
                    },
                    error: function(params) {
                        let txt = params.responseJSON;
                        $.each(txt.errors, function(k, v) {
                            message(v, false);
                        });
                    }
                });
            })
        }


        $(".btn-simpan").click(function(e) {

            e.preventDefault();

            let token = $('input[name="_token"]').val();
            var conversion_id = $("select[name=conversion_id] option").filter(':selected').val();
            var shop_id = parseInt($("select[name=shop_id] option").filter(':selected').val());
            var type = $("input[name=type]").val();
            var qty = $("input[name=qty]").val();
            var notes = $("input[name=notes]").val();

            let fd = new FormData();
            fd.append('_token', token);
            fd.append('conversion_id', conversion_id);
            fd.append('shop_id', shop_id)
            fd.append('type', type);
            fd.append('qty', qty);
            fd.append('notes', notes);

            // auto refresh
            setTimeout(() => {
                window.location = window.location;
            }, 1200);

            $.ajax({
                type: 'POST',
                url: "{{ route('adjusment.store') }}",
                headers: {
                    'X-CSRF-TOKEN': token
                },
                data: fd,
                contentType: false,
                processData: false,
                dataType: 'json',
                beforeSend: function() {
                    $('.btn-simpan').prop('disabled', true);
                    $('.btn-simpan').html('')
                    $('.btn-simpan').append(
                        '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>Loading...'
                        )
                },
                success: async function(data) {
                    message(data.message, data.success);
                    // get_data();
                },
                complete: function() {
                    $('.btn-simpan').prop('disabled', false);
                    $('.btn-simpan').html('')
                    $('.btn-simpan').append('Simpan');
                    $("input[name=color]").val("");
                },
                error: function(params) {
                    let txt = params.responseJSON;
                    $.each(txt.errors, function(k, v) {
                        message(v, false);
                    });
                }
            });

        });

        function konfirmasi(id, conversion, qty) {
            $("#modal-confirm").modal('show');

            $.ajax({
                type: 'GET',
                url: "{{ url('adjusment/detail') }}/" + id,
                data: {},
                success: (data) => {
                    $('#title-confirm').text(data.data.sku)
                    $('#toko-confirm').text(data.data.name)
                }
            })

            const token = $('input[name="_token"]').val();
            const formData = new FormData()
            formData.append('_token', token)
            formData.append('conversion_id', conversion)
            formData.append('qty', qty)
            formData.append('type', 'OUT')

            $(".btn-confirm").click(function(e) {
                $.ajax({
                    type: 'POST',
                    url: "{{ url('adjusment/confirm') }}/" + id,
                    headers: {
                        'X-CSRF-TOKEN': token
                    },
                    data: {
                        formData
                    },
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    beforeSend: function() {
                        $('.btn-confirm').prop('disabled', true);
                        $('.btn-confirm').html('');
                        $('.btn-confirm').append(
                            '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>Loading...'
                            )
                    },
                    success: (data) => {
                        if (data.success) {
                            setTimeout(() => {
                                window.location = window.location;
                            }, 1200);
                            message(data.message, data.success);
                        }
                    },
                    complete: function() {
                        $('.btn-update').prop('disabled', false);
                        $('.btn-update').html('');
                        $('.btn-update').append('Simpan');
                        $("input[name=color]").val("");
                    },
                    error: function(params) {
                        let txt = params.responseJSON;
                        $.each(txt.errors, function(k, v) {
                            message(v, false);
                        });
                    }
                })
            })
        }
    </script>
@endpush
