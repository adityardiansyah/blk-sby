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
                                <th colspan="2">Akses</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($menus as $menu)
                                @csrf
                                <tr>
                                    <input type="hidden" value="{{ $groups->id }}" class="group_id" id="group_id">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $menu->name_menu }}</td>
                                    <td>
                                        <div class="form-check form-check-inline">
                                            <input 
                                                id="allCheck-{{ $menu->name_menu }}"
                                                onclick="checkAll('{{ $menu->name_menu }}')"
                                                class="form-check-input semua-checkbox" 
                                                type="checkbox"
                                                data-menu="{{ $menu->name_menu }}" 
                                                data-aksi="{{ $master_action[0]->id }}"
                                                {{ NavHelper::create_checked($groups->id, $menu->id, $master_action[1]->id) ? 'checked' : '' }}
                                                
                                            />
                                            <label class="form-check-label" for="semua">semua</label>
                                        </div>
                                    </td>
                                    <td>
                                        @foreach ($master_action as $item)
                                            <div class="form-check form-check-inline">
                                                <input 
                                                    onclick="checkManual('{{ $menu->name_menu }}')"
                                                    class="form-check-input checkbox-{{ $menu->name_menu }}" 
                                                    type="checkbox"
                                                    data-menu_id="{{ $menu->id }}" 
                                                    data-aksi="{{ $item->id }}"
                                                    {{ NavHelper::create_checked($groups->id, $menu->id, $item->id) ? 'checked' : '' }}
                                                />
                                                <label class="form-check-label" for="read">{{ $item->name }}</label>
                                            </div>
                                        @endforeach
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
        const checkAll = async (name) => {
            const checkAll = document.getElementById(`allCheck-${name}`)
            const baris = document.getElementsByClassName(`checkbox-${name}`)
            
            if (checkAll.checked) {
                for (let i=0; i < baris.length; i++) {
                    if (!baris[i].checked) baris[i].checked = true
                }
            }else{
                for (let i=0; i < baris.length; i++) {
                    if (baris[i].checked) baris[i].checked = false
                }
            }

            // Insert data
        }

        const checkManual = async (name) => {
            const checkAll = document.getElementById(`allCheck-${name}`)
            const baris = document.getElementsByClassName(`checkbox-${name}`)

            for (let i=0; i < baris.length; i++) {
                if (!baris[i].checked) {
                    checkAll.checked = false
                }else{
                    checkAll.checked = true
                }
            }
        }

        $(".form-check-input").on('click', function() {
            let data = $(this).data();
            const menu_id = data.menu_id;
            const aksi = data.aksi;
            const group_id = $("#group_id").val();

            $.ajax({
                method: "post",
                url: "{{ route('permission.edit-akses') }}",
                headers: {
                    "X-CSRF-TOKEN": $('input[name="_token"]').val(),
                },
                data: {
                    menu_id,
                    aksi,
                    group_id
                },
                success: async function(data) {
                    if (data.status) {
                        message(data.message, data.success);
                    }
                }
            });
        });
    </script>
@endpush
