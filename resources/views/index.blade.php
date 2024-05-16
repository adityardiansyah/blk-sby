@extends('layouts.base', ['title' => '- Beranda'])

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
    <!-- Main Banner Section Start -->
    <div class="banner trans" style="background-image:url({{ asset('/images/bg-kantor.jpeg') }});"
        data-overlay="6">
        <div class="container">
            <div class="banner-caption">
                <div class="col-md-12 col-sm-12 banner-text">
                    <h1>UPT Balai Latihan Kerja Surabaya</h1>
                    <h3 style="color:white;">"Menjadi Lebih Unggul Bersama kami"</h3>
                    {{-- <div class="full-search-2 eclip-search italian-search hero-search-radius">
                        <div class="hero-search-content">
                            <form action="" class="bt-form" method="GET">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-12 small-padd b-r">
                                        <div class="form-group">
                                            <div class="input-with-icon">
                                                <input type="text" name="query" class="form-control"
                                                    placeholder="Keahlian, kata kunci, perusahaan">
                                                <i class="ti-search"></i>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-4 col-sm-12 small-padd">
                                        <div class="form-group">
                                            <div class="input-with-icon">
                                                <select id="choose-category" class="form-control select2"
                                                    name="job_category">
                                                    <option value="all" selected>-- Pilih Kategori Lowongan --</option>
                                                    @foreach ($job_categories as $item)
                                                        <option value="{{ $item->name }}"> {{ $item->name }}</option>
                                                    @endforeach
                                                </select>
                                                <i class="ti-layers"></i>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-2 col-md-2 col-sm-12 small-padd">
                                        <div class="form-group">
                                            <div class="input-with-icon">
                                                <select class="form-control select2" name="provinsi" id="province"
                                                    data-url="{{ url('/') }}">
                                                    <option value="all" selected>Pilih Provinsi</option>
                                                    @foreach ($provinces as $item)
                                                        <option value="{{ $item->id }}">
                                                            {{ $item->name }}</option>
                                                    @endforeach
                                                </select>
                                                <i class="fa fa-map-marker"></i>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-2 col-md-2 col-sm-12 small-padd">
                                        <div class="form-group">
                                            <div class="input-with-icon">
                                                <select name="kabupaten" id="city" class="form-control select2">
                                                    <option value="all">Pilih Kota/Kab</option>
                                                </select>
                                                <i class="ti-layers"></i>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-2 col-md-2 col-sm-12 small-padd">
                                        <div class="form-group">
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-primary search-btn"><i
                                                        class="ti-search"></i></button>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>

    </div>
    <div class="clearfix"></div>
    <!-- Main Banner Section End -->

    <!-- Company Brand Start -->
    <div class="company-brand">
        <div class="container">
            <div id="company-brands">
                {{-- @if ($web_setting != null)
                    @foreach ($web_setting->image_sliders as $item)
                        <div class="brand-img">
                            <img src="{{ asset('public/' . $item->image) }}" class="img-responsive" alt="Logo brand" />
                        </div>
                    @endforeach --}}

                {{-- @endif --}}
            </div>
        </div>
    </div>
    <!-- Company Brand End -->

    <!-- Job List-->
    <section class="how-it-works">
        <div class="container">

            <div class="row" data-aos="fade-up">
                <div class="col-md-12">
                    <div class="main-heading">
                        <p>Tahap - Tahap</p>
                        <h2>Bagaimana Mendaftar Pelatihan di <span>BLK SURABAYA</span></h2>
                    </div>
                </div>
            </div>

            <div class="row">

                <div class="col-md-4 col-sm-4">
                    <div class="working-process">
                        <span class="process-img">
                            <img src="{{ asset('public/assets/img/step-1.png') }}" class="img-responsive" alt="" />
                            <span class="process-num">01</span>
                        </span>
                        <h4>Daftar Akun</h4>
                        <p>Anda harus melakukan pendaftaran akun untuk mencari pelatihan yang diminati.</p>
                    </div>
                </div>

                <div class="col-md-4 col-sm-4">
                    <div class="working-process">
                        <span class="process-img">
                            <img src="{{ asset('public/assets/img/step-2.png') }}" class="img-responsive" alt="" />
                            <span class="process-num">02</span>
                        </span>
                        <h4>Cari Program Pelatihan</h4>
                        <p>Setelah mendaftarkan akun, anda dapat mencari program pelatihan yang anda inginkan.</p>
                    </div>
                </div>

                <div class="col-md-4 col-sm-4">
                    <div class="working-process">
                        <span class="process-img">
                            <img src="{{ asset('public/assets/img/step-3.png') }}" class="img-responsive" alt="" />
                            <span class="process-num">03</span>
                        </span>
                        <h4>Daftar</h4>
                        <p>Apabila sudah menemukan pelatihan yang tepat, anda dapat mendaftar pelatihan tersebut.</p>
                    </div>
                </div>

            </div>

        </div>
    </section>
    <div class="clearfix"></div>
    
    <!-- Latest Job End-->

    <!-- video section Start -->
    <section class="video-sec dark" id="video"
        style="background-image:url({{ asset('public/assets/img/free/bg-4.jpeg') }});">
        <div class="container">
            <div class="row">
                <div class="main-heading">
                    <p>Profile Layanan Kami</p>
                    <h2>Lihat pada <span>video ini</span></h2>
                </div>
            </div>
            <!--/row-->
            <div class="video-part">
                <iframe width="100%" height="600" src="https://www.youtube.com/embed/6vu4zYV3wlw?si=Tf7n7pQKtzeq95qz" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                {{-- <a href="{{ $web_setting->link_video }}" target="_blank" class="video-btn"><i
                        class="fa fa-play"></i></a> --}}
            </div>
        </div>
    </section>
    <div class="clearfix"></div>
    <!-- video section Start -->

    <!-- ====================== How It Work ================= -->
    


    <!-- ============================ Before Footer ================================== -->
    {{-- <div class="before-footer">
        <div class="container">
            <div class="row">

                <div class="col-md-6 col-sm-6">
                    <div class="jb4-form-fields">
                        <div class="input-group">
                            <input type="email" class="form-control" placeholder="Enter your email address">
                            <span class="input-group-btn">
                                <button class="btn theme-bg" type="submit"><span
                                        class="fa fa-paper-plane-o"></span></button>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-sm-6 hill">
                    <ul class="job stock-facts">
                        <li><span>2744</span></br>Jobs Posted</li>
                        <li><span>2365</span></br>Jobs Posted</li>
                        <li><span>2021</span></br>Freelancer</li>
                        <li><span>7542</span></br>Companies</li>
                    </ul>
                </div>

            </div>
        </div>
    </div> --}}
    <!-- ============================ Before Footer ================================== -->
@endsection
@push('js')
    <script>
        $(document).ready(function() {
            $('.select2').select2();

            $('#province').on('change', function() {
                if ($(this).val() != 'all') {
                    let id = $(this).val()
                    let temp_url = $(this).data('url')
                    let url = temp_url + '/get-cities/' + id
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: url,
                        type: 'GET',
                        success: function(responses) {
                            $('#city').empty();
                            // $('#city').append('<option value="0" selected>Pilih Kota/Kabupaten</option>');
                            $('#city').append(
                                '<option value="all">Pilih Kota/Kabupaten</option>');
                            $.each(responses, function(key, value) {
                                $('#city').append('<option value="' + value.id + '">' +
                                    value.name + '</option>');
                            })

                        },
                        error: function(exception) {
                            console.log("error" + exception.responseText)
                        }
                    });
                } else {
                    $('#city').empty().append('<option value="all">Pilih Kota/Kab</option>');
                }
            })
        })
    </script>
@endpush