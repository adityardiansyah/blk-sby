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
        <h1>Riwayat Pelatihan</h1>
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
                <form method="GET" action="{{ url('riwayat-pelatihan') }}">
                    <div class="col-md-6 col-sm-6">
                        <input type="text" class="form-control" name="search" placeholder="Cari disini...">
                    </div>
                    <div class="col-md-3 col-sm-3">
                        <select class="form-control" id="j-category" name="sort">
                            <option value="">-- Urutkan --</option>
                            <option value="desc">Terbaru</option>
                            <option value="asc">Terlama</option>
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
                                    <label for="" class="badge">Sub Kejuruan : {{ $item->nama_kejuruan }}</label>
                                    <h4>{{ $item->nama_pelatihan }} <span class="cmp-tagline">(</h4>
                                    <span class="cmp-time">Pendaftaran tgl {{ date('d M Y', strtotime($item->tanggal_awal)) }} sampai {{ date('d M Y', strtotime($item->tanggal_akhir)) }}</span>
                                    <br>
                                    <i>
                                        <small class="cmp-time">anda mendaftar pada tanggal {{ date('d M Y H:i', strtotime($item->created_at)) }}</small>
                                    </i>
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
                                <a href="{{ url('informasi-seleksi/'.$item->slug) }}" class="btn btn-primary">Lihat Detail</a>
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