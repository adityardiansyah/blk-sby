@extends('layouts.base', ['title' => '- Informasi Pelatihan'])

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
        <h1>Informasi Seleksi</h1>
    </div>
</section>
<div class="clearfix"></div>
<!-- Title Header End -->
<div class="detail-desc section">
    <div class="container">
        <div class="ur-detail-wrap create-kit padd-bot-0" style="margin-top:32px;">
            <div class="row bottom-mrg padd-top-30">
                <div class="embed-responsive embed-responsive-16by9">
                    @if(!empty($pelatihan->berkas_seleksi))
                        <iframe class="embed-responsive-item" src="{{ asset('storage/'.$pelatihan->berkas_seleksi) }}" allowfullscreen></iframe>
                    @else
                        <p class="text-center">Belum ada informasi.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="text-center">
        <a href="{{ url('riwayat-pelatihan') }}" class="btn btn-primary text-center mrg-bot-30">Lihat Riwayat Pelatihan</a>
    </div>
</div>
@endsection
