@extends('layouts.master')

@section('content')
<div class="page-heading">
    <h3>Seller</h3>
</div>
<div class="page-content">
    <section class="section">
        <div class="card">
            <div class="card-header">
                
            </div>
            <div class="card-body">
                <table class="table table-striped" id="table1">
                    <thead>
                        <tr>
                            <th>No. Reg</th>
                            <th>Nama</th>
                            <th>Phone</th>
                            <th>Tgl. Dibuat</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                            {{-- <tr>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->username }}</td>
                                <td>*******</td>
                                <td>{{ date('Y-m-d', strtotime($item->created_at)) }}</td>
                                <td>
                                    <span class="">{{ Str::ucfirst($item->status) }}</span>
                                </td>
                            </tr> --}}
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </section>
</div>
@endsection
