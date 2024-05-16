@extends('layouts.base', ['title' => '- Galeri Kami'])

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
        <h1>Galeri Kami</h1>
    </div>
</section>
<div class="clearfix"></div>
<!-- Title Header End -->

<!-- Top Candidate -->
<section>
    <div class="container">
        
        <!-- search filter -->
        <div class="row extra-mrg">
            <div class="wrap-search-filter">
                <form method="GET" action="{{ url('gallery') }}">
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
        
        <!-- Freelancers Start -->
        <div class="row">
            @forelse($data as $key => $item)
            <!-- Single Freelancer -->
            <div class="col-md-4 col-sm-6">
                <div class="top-candidate-wrap">
                    <div class="top-candidate-box">
                        {{-- <span class="tpc-status">Available</span> --}}
                        {{-- <h4 class="flc-rate">$17/hr</h4> --}}
                        <img src="{{ asset('storage/'.$item->fotoGaleri[0]->foto) }}" class="img-responsive" alt="" />
                        <div class="tp-candidate-inner-box">
                            <div class="top-candidate-box-detail">
                                <h4>{{ $item->judul }}</h4>
                                <span class="desination">{{ date('d M Y', strtotime($item->created_at)) }}</span>
                            </div>
                        </div>
                        <div class="top-candidate-box-extra">
                            <p>{{ $item->deskripsi }}</p>
                        </div>
                    </div>
                    <a href="{{ url('detail-gallery/'.$item->id) }}" class="btn btn-freelance bt-1">Lihat Detail</a>
                </div>
            </div>
            @empty
            <p class="text-center">Data tidak ditemukan!</p>
            @endforelse
            
        </div>
            
    </div>
</section>
<!-- Top Candidate End -->
@endsection