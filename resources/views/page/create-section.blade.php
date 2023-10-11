@extends('layouts.master')

@section('content')
    <div class="page-heading">
        <h3>Create Section and Menu</h3>
    </div>
    <div class="page-content">
        <section class="section">
            <div class="card">
                <div class="card-body">
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
                            @foreach ($data as $key => $item)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $item->name_section }}</td>
                                    <td>{{ $item->order }}</td>
                                    <td>
                                        <a href="/section/edit/{{ $item->id }}" type="button" class="btn btn-warning btn-sm" >Edit</a>
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