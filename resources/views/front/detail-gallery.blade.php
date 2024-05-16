@extends('layouts.base', ['title' => '- Detail Galeri'])

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
        <h1>{{ $data->judul }}</h1>
    </div>
</section>
<div class="clearfix"></div>
<!-- Title Header End -->

<!-- Top Candidate -->
<section>
    <div class="container">
        
        <!-- Freelancers Start -->
        <div class="row">
            @forelse($data->fotoGaleri as $key => $item)
            <!-- Single Freelancer -->
            <div class="col-md-4 col-sm-6">
                <div class="top-candidate-wrap">
                    <div class="top-candidate-box">
                        <a target="_blank" href="{{ asset('storage/'.$item->foto) }}">
                            <img src="{{ asset('storage/'.$item->foto) }}" class="img-responsive" alt="" />
                        </a>
                    </div>
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