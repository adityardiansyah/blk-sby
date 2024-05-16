@extends('layouts.base', ['title' => '- Profil Perusahaan'])

@section('navbar')
    @include('layouts.navbar')
@endsection

@push('css')
<style>

</style>
@endpush

@section('body')
    <!-- Title Header Start -->
    <section class="inner-header-title" style="background-image:url(/images/{{ $data->foto_gedung }});">
        <div class="container">
        </div>
    </section>
    <div class="clearfix"></div>
    <!-- Title Header End -->
    <!-- Company Detail Start -->
    <section class="detail-desc">
        <div class="container">
        
            <div class="ur-detail-wrap top-lay">
                
                <div class="ur-detail-box">
                    
                    <div class="ur-thumb">
                        <img src="assets/img/com-2.jpg" class="img-responsive" alt="" />
                    </div>
                    <div class="ur-caption">
                        <h4 class="ur-title">UPT Balai Latihan Kerja Surabaya</h4>
                        <p class="ur-location"><i class="ti-location-pin mrg-r-5"></i>Jl. Dukuh Menanggal III No.29, Dukuh Menanggal, Kec. Gayungan, Surabaya, Jawa Timur 60234</p>
                    </div>
                    
                </div>
                
                <div class="ur-detail-btn">
                    {{-- <a href="#" class="btn btn-warning mrg-bot-10 full-width">Follow Now</a><br>
                    <a href="#" class="btn btn-primary full-width">Get in Touch</a> --}}
                </div>
                
            </div>
            
        </div>
    </section>
    <!-- Company Detail End -->
    
    <!-- company full detail Start -->
    <section class="full-detail-description full-detail">
        <div class="container">
            <div class="row">
                
                <div class="col-lg-8 col-md-8">
                    
                    <div class="row-bottom">
                        <h2 class="detail-title">Sejarah</h2>
                        <p>
                            {{ $data->sejarah }}
                        </p>
                    </div>
                    <div class="row-bottom">
                        <h2 class="detail-title">Visi Kami</h2>
                        <p>
                            {{ $data->visi }}
                        </p>
                    </div>
                    <div class="row-bottom">
                        <h2 class="detail-title">Misi Kami</h2>
                        <p>
                            {{ $data->misi }}
                        </p>
                    </div>
                    
                    
                </div>
                
                <div class="col-lg-4 col-md-4">
                    <div class="full-sidebar-wrap">
                        
                        <!-- Company overview -->
                        <div class="sidebar-widgets">
                        
                            <div class="ur-detail-wrap">
                                <div class="ur-detail-wrap-header">
                                    <h4>Company Overview</h4>
                                </div>
                                <div class="ur-detail-wrap-body">
                                    <ul class="ove-detail-list">
                                    
                                        <li>
                                            <i class="ti-ruler-pencil"></i>
                                            <h5>Established</h5>
                                            <span>July 10 2019</span>
                                        </li>
                                        
                                        <li>
                                            <i class="ti-user"></i>
                                            <h5>Employees</h5>
                                            <span>500 - 600</span>
                                        </li>
                                        
                                        <li>
                                            <i class="ti-face-smile"></i>
                                            <h5>Owner Name</h5>
                                            <span>July 10 2019</span>
                                        </li>
                                        
                                        <li>
                                            <i class="ti-email"></i>
                                            <h5>Email</h5>
                                            <span>yourcompany@gmail.com</span>
                                        </li>
                                        
                                        <li>
                                            <i class="ti-mobile"></i>
                                            <h5>Call</h5>
                                            <span>+91 254 548 4578</span>
                                        </li>
                                        
                                    </ul>
                                </div>
                            </div>
                            
                        </div>
                        <!-- /Company overview -->
                        
                    </div>
                </div>
            
            </div>
        </div>
    </section>
    <!-- company full detail End -->
@endsection