@extends('layouts.base', ['title' => '- Detail Program Pelatihan'])

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
<section class="inner-header-title" style="background-image:url(/assets/images/samples/architecture1.jpg);">
    <div class="container">
        {{-- <h1>Program Pelatihan</h1> --}}
    </div>
</section>
<div class="clearfix"></div>
<!-- Title Header End -->

<!-- Candidate Detail Start -->
<section class="detail-desc">
    <div class="container">
    
        <div class="ur-detail-wrap top-lay">
            
            <div class="ur-detail-box">
                
                <div class="ur-thumb">
                    <img src="{{ asset('assets/images/logo_robot.png') }}" class="img-responsive" alt="" />
                </div>
                <div class="ur-caption">
                    <label for="" class="badge">Sub Kejuruan : {{ $data->kejuruan->nama_kejuruan }}</label>
                    <h3 class="ur-title">{{ $data->nama_pelatihan }}</h3>
                    <p class="ur-location"><i class="ti-location-pin mrg-r-5"></i>UPT Balai Latihan Kerja Surabaya</p>
                </div>
                
            </div>
            
            <div class="ur-detail-btn">
                {{-- <a href="#" class="btn btn-warning mrg-bot-10 full-width"><i class="ti-thumb-up mrg-r-5"></i>Apply Job Now</a><br> --}}
                <a href="{{ url('daftar-pelatihan/'.$data->slug) }}" class="btn btn-info full-width"><i class="ti-thumb-up mrg-r-5"></i>Daftar Pelatihan</a>
            </div>
            
        </div>
        
    </div>
</section>
<!-- Candidate Detail End -->

<!-- Candidate full detail Start -->
<section class="full-detail-description full-detail">
    <div class="container">
        <div class="row">
            
            <div class="col-lg-8 col-md-8">
                
                <div class="row-bottom">
                    <h2 class="detail-title">Deskripsi</h2>
                    <p>{!! $data->deskripsi !!}</p>
                </div>
                
            </div>
            
            <div class="col-lg-4 col-md-4">
                <div class="full-sidebar-wrap">
                    
                    {{-- <a href="javascript:void(0)" data-toggle="modal" data-target="#apply-job" class="btn btn-info mrg-bot-15 full-width"><i class="ti-star mrg-r-5"></i>Apply This Job</a> --}}
                    
                    <!-- Candidate overview -->
                    <div class="sidebar-widgets">
                    
                        <div class="ur-detail-wrap">
                            <div class="ur-detail-wrap-header">
                                <h4>Pelatihan Overview</h4>
                            </div>
                            <div class="ur-detail-wrap-body">
                                <ul class="ove-detail-list">
                                
                                    <li>
                                        <i class="ti-wallet"></i>
                                        <h5>Tanggal Pelaksanaan</h5>
                                        <span>{{ date('d M Y', strtotime($data->tanggal_pelaksanaan)) }}</span>
                                    </li>
                                    
                                    <li>
                                        <i class="ti-user"></i>
                                        <h5>Tanggal Pendaftaran</h5>
                                        <span>{{ date('d M Y', strtotime($data->tanggal_awal)) }} - {{ date('d M Y', strtotime($data->tanggal_akhir)) }}</span>
                                    </li>
                                    
                                    <li>
                                        <i class="ti-ink-pen"></i>
                                        <h5>Kuota Peserta</h5>
                                        <span>{{ $data->kuota }}</span>
                                    </li>
                                    
                                </ul>
                            </div>
                        </div>
                        
                    </div>
                    <!-- /Candidate overview -->
                    
                </div>
            </div>
        
        </div>
    </div>
</section>
<!-- company full detail End -->

<div class="container">
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <h3>Pelatihan Lainnya</h3>
        </div>
    </div>
    <div class="row padd-top-20">
        <div class="col-md-12">
            @forelse ($pelatihan as $item)
            <article>
                <div class="mng-company">
                    <div class="col-md-7 col-sm-7">
                        <div class="item-fl-box">
                            <div class="mng-company-pic">
                                <img src="{{ asset('assets/images/logo_robot.png') }}" class="img-responsive p-2" alt="" />
                            </div>
                            <div class="mng-company-name">
                                <h4>{{ $item->nama_pelatihan }} <span class="cmp-tagline">(Kuota : {{ $item->kuota }} Orang)</span></h4>
                                <span class="cmp-time">Pendaftaran tgl {{ date('d M Y', strtotime($item->tanggal_awal)) }} sampai {{ date('d M Y', strtotime($item->tanggal_akhir)) }}</span>
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
@endsection