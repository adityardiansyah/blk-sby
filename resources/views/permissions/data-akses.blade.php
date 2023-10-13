@extends('layouts.master')

@section('content')
    <div class="page-heading">
        <h3>Data Akses {{ $groups->name }}</h3>
    </div>
    <div class="page-content">
        <section class="section">
            <div class="card">
                <div class="card-body table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Menu</th>
                                <th>Akses</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($menus as $menu)
                            @csrf
                                <tr>
                                    <input type="hidden" value="{{ $groups->id }}" class="group_id">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $menu->name_menu }}</td>
                                    <td>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox"
                                                data-menu="{{ $menu->name_menu }}" data-aksi="lihat"
                                                {{ NavHelper::create_checked($groups->id, $menu->name_menu, 'lihat') ? 'checked' : 'null' }}>
                                            <label class="form-check-label" for="read">Lihat</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox"
                                                data-menu="{{ $menu->name_menu }}" data-aksi="tambah"
                                                {{ NavHelper::create_checked($groups->id, $menu->name_menu, 'tambah') ? 'checked' : 'null' }}>
                                            <label class="form-check-label" for="create">Tambah</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox"
                                                data-menu="{{ $menu->name_menu }}" data-aksi="ubah"
                                                {{ NavHelper::create_checked($groups->id, $menu->name_menu, 'ubah') ? 'checked' : 'null' }}>
                                            <label class="form-check-label" for="ubah">Ubah</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox"
                                                data-menu="{{ $menu->name_menu }}" data-aksi="hapus"
                                                {{ NavHelper::create_checked($groups->id, $menu->name_menu, 'hapus') ? 'checked' : 'null' }}>
                                            <label class="form-check-label" for="hapus">Hapus</label>
                                        </div>
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
        $(".form-check-input").on('click', function() {
            const checkbox = $(this);
            const data = checkbox.data();
            const menu = data.menu;
            const aksi = data.aksi;
            const group_id = checkbox.closest('tr').find('.group_id').val();

            $.ajax({
                method: "post",
                url: "{{ route('permission.edit-akses') }}",
                headers: {
                    "X-CSRF-TOKEN": $('input[name="_token"]').val(),
                },
                data: {
                    menu,
                    aksi,
                    group_id
                },
                success: async function(data) {
                        if (data.status) {
                            message(data.message, data.success);
                        }
                    }
            });
        })
    </script>
@endpush
