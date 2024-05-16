@extends('layouts.base', ['title' => '- Program Pelatihan'])

@section('navbar')
    @include('layouts.navbar')
@endsection

@push('css')
<style>
.row.row-eq-height {
  display: -webkit-box;
  display: -webkit-flex;
  display: -ms-flexbox;
  display: flex;
  flex-wrap: wrap;
}
.tp-candidate-inner-box{
    padding: 16px 20px 10px;
}

.top-candidate-box{
    padding: 20px 20px 15px;
}

</style>
@endpush

@section('body')
<!-- Title Header Start -->
<section class="inner-header-title" style="background-image:url(assets/images/samples/architecture1.jpg);">
    <div class="container">
        <h1>Program Pelatihan</h1>
    </div>
</section>
<div class="clearfix"></div>
<!-- Title Header End -->
  <!-- Manage Company List Start -->
  <section class="manage-company gray">
    <div class="container">
        
        <!-- search filter -->
        <div class="row">
            <div class="">
                <form method="GET" action="{{ url('program-pelatihan') }}">
                    <div class="col-md-3 col-sm-3">
                        <select class="form-control" name="kejuruan">
                            <option value="">-- Pilih Sub Kejuruan --</option>
                            @foreach ($sub_kejuruan as $item)
                                <option value="{{ $item->id }}" {{ $request['kejuruan'] == $item->id? 'selected' : '' }}>{{ $item->nama_kejuruan }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 col-sm-3">
                        <input type="text" class="form-control" name="search" placeholder="Cari disini..." value="{{ $request['search'] }}">
                    </div>
                    <div class="col-md-3 col-sm-3">
                        <select class="form-control"  name="sort">
                            <option value="">-- Urutkan --</option>
                            <option value="desc" {{ $request['sort'] == 'desc'? 'selected' : '' }}>Terbaru</option>
                            <option value="asc" {{ $request['sort'] == 'asc'? 'selected' : '' }}>Terlama</option>
                        </select>
                    </div>
                    <div class="col-md-3 col-sm-3">
                        <button type="submit" class="btn btn-primary full-width">Filter</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- search filter End -->
    </div>
    <div class="container">
        
        <div class="row">
            <div class="col-md-12">
                @forelse ($data as $item)
                <article>
                    <div class="mng-company">
                        <div class="col-md-7 col-sm-7">
                            <div class="item-fl-box">
                                <div class="mng-company-pic">
                                    <img src="{{ asset('assets/images/logo_robot.png') }}" class="img-responsive p-2" alt="" />
                                </div>
                                <div class="mng-company-name">
                                    <h4>{{ $item->nama_pelatihan }} </h4>
                                    <span class="cmp-time">Pendaftaran tgl {{ date('d M Y', strtotime($item->tanggal_awal)) }} sampai {{ date('d M Y', strtotime($item->tanggal_akhir)) }}</span>
                                    <br>
                                    <label for="" class="badge">Sub Kejuruan : {{ $item->kejuruan->nama_kejuruan }}</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-3">
                            <div class="mng-company-location">
                                {{-- <p><i class="fa fa-map-marker"></i> Street #210, Make New London</p> --}}
                            </div>
                        </div>
                        <div class="col-md-2 col-sm-2">
                            <div class="mng-company-action">
                                <a href="{{ url('program-pelatihan/'.$item->slug) }}" class="btn btn-primary">Lihat Detail</a>
                            </div>
                        </div>
                    </div>
                </article>
                @empty
                    <p class="text-center">Data tidak ditemukan!</p>
                @endforelse
                
            </div>
        </div>
        
    </div>
</section>
<!-- Manage Company List End -->
@endsection