    @extends('layouts.master')

    @section('content')
        <div class="page-heading">
            <h3>Edit Section and Menu</h3>
        </div>
        <div class="page-content">
            <section class="section">
                <div class="card">
                    <div class="card-header">
                        <h4>Section {{ $data->name_section }}</h4>
                    </div>
                    <div class="card-body">
                        <form action="/section/update/{{ $data->id }}" method="post">
                            @csrf
                            <label>Nama Section</label>
                            <div class="form-group">
                                <input type="text" placeholder="Nama Section" class="form-control" name="name_section" required value="{{ $data->name_section }}">
                            </div>
                            <div id="form-icon"></div>
                            <div class="form-group">
                                <i id="selected-icon" class="bi bi-{{ $data->icons }}"></i>
                                <a href="#" onclick="modalIcon()" class="btn btn-secondary btn-sm ms-2">Pilih Icon</a>
                            </div>
                            <button type="submit" class="btn btn-primary mb-4">Simpan</button>
                        </form>

                        <table class="table table-striped" id="table1">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nama Section</th>
                                    <th>Urutan</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($menu as $key => $m)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $m->name_menu }}</td>
                                        <td>{{ $m->order }}</td>
                                        <td>
                                            <button class="btn btn-warning btn-sm" onclick="editModal({{ $m->id }})">Edit</button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
        </div>

        {{-- Modal Icon --}}
        <div class="modal fade text-left modal-lg" id="modal-icon" role="dialog" aria-labelledby="myModalLabel33"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel33">Pilih Icon</h4>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <i data-feather="x"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        @foreach ($icons as $icon)
                            <a href="#" onclick="modalIcon('{{ substr($icon->getFilename(), 0, -4) }}')">
                                <i class="bi bi-{{ substr($icon->getFilename(), 0, -4) }}"></i>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        {{-- Modal Edit --}}
        <div class="modal fade text-left modal-lg" id="modal-edit" role="dialog" aria-labelledby="myModalLabel33"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel33">Edit Menu</h4>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <i data-feather="x"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="" method="post">
                            @csrf
                            <div class="row">
                                <div class="col">
                                    <label>Nama Menu</label>
                                    <div class="form-group">
                                        <input type="text" placeholder="Nama Menu" class="form-control" id="name_menu" name="name_menu" required>
                                    </div>
                                    <label>Url</label>
                                    <div class="form-group">
                                        <input type="text" placeholder="URL" class="form-control" id="url" name="url" required>
                                    </div>
                                    <label for="">Section</label>
                                    <select class="form-select" name="" id="">
                                        @foreach ($data as $item)
                                            <option value="">{{ $item->name_section }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                            <i class="bx bx-x d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Tutup</span>
                        </button>
                        <button type="submit" class="btn btn-primary ml-1">
                            <i class="bx bx-check d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Simpan</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endsection

    @push('js')
        <script>
            const modalIcon = (icon) => {
                if (icon != undefined) {
                    $('#modal-icon').modal('toggle')
                    $('#selected-icon').attr('class', `bi bi-${icon}`)
                    $('#form-icon').html(`<input type="hidden" name="icons" value="${icon}">`)
                }else{
                    $('#modal-icon').modal('show')
                }
            }

            const editModal = async (id) => {
                $('#modal-edit').modal('show')
                const response = await fetch(`/menu/${id}`)
                const data = await response.json()

                const token = $('input[name="_token"]').val()
                const name_menu = $('input[name="name_menu"]')
                const url = $('input[name="url"]')

                name_menu.val(data.payload.name_menu)
                url.val(data.payload.url)
            }
        </script>
    @endpush