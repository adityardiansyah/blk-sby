@extends('layouts.base', ['title' => '- Hubungi Kami'])

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

</style>
@endpush

@section('body')
    <!-- Title Header Start -->
    <section class="inner-header-title" style="background-image:url(assets/images/samples/architecture1.jpg);">
        <div class="container">
            <h1>Profil Perusahaan</h1>
        </div>
    </section>
    <div class="clearfix"></div>
    <!-- Title Header End -->
    
    <!-- Contact Page Section Start -->
    <section class="contact-page">
        <div class="container">
            <table class="table" style="width: 50%; margin:auto;">
                {{-- @foreach ($data as $item)
                <tr>
                    <td>{{ $item->judul }}</td>
                    <td>:</td>
                    <td>{{ $item->isi }}</td>
                </tr>
                @endforeach --}}
                
            </table>
        <ol style="font-size: 14pt;">
        </ol>
            
        </div>
    </section>
    <!-- contact section End -->
@endsection

@push('js')
<script>
   
</script>

@endpush
