@extends('layouts.master')

@section('content')
<div class="page-heading">
    <h3>Warna</h3>
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
                            <th>No.</th>
                            <th>Warna</th>
                            <th>Tgl. dibuat</th>
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
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </section>
</div>
@endsection
