<!-- ============================ Footer Start ================================== -->
<footer class="dark-footer skin-dark-footer">
    <div>
        <div class="container">
            <div class="row">

                <div class="col-lg-5 col-md-5">
                    <div class="footer-widget">
                        <img src="{{ asset('public/assets/img/logo_v2.png') }}" class="img-footer" alt="" />
                        <div class="footer-add">
                            <p>Jl. Dukuh Menanggal III No.29, Dukuh Menanggal, Kec. Gayungan, Surabaya, Jawa Timur 60234</p>
                            <p><strong>Email:</strong> <br>uptpelatihankerjasurabaya@yahoo.co.id</p>
                            <p><strong>Call:</strong> <br>0882-0027-60027</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3">
                    <div class="footer-widget">
                        <h4 class="widget-title">Tentang Kami</h4>
                        <ul class="footer-menu">
                            <li><a href="{{ url('profile-company') }}">Tentang Kami</a></li>
                            <li><a href="{{ url('call-us') }}">Hubungi Kami</a></li>
                            <li><a href="{{ url('gallery') }}">Galeri Kami</a></li>
                            {{-- <li><a href="">Kirim Saran</a></li> --}}
                        </ul>
                    </div>
                </div>

                <div class="col-lg-3 col-md-3">
                    <div class="footer-widget">
                        <h4 class="widget-title">Pelatihan Kerja</h4>
                        <ul class="footer-menu">
                            <li><a href="{{ url('program-pelatihan') }}">Pelatihan Berdasarkan spesialisasi</a></li>
                            <li><a href="{{ url('program-pelatihan') }}">Pelatihan Berdasarkan minat</a></li>
                            <li><a href="{{ url('riwayat-pelatihan') }}">Riwayat Pelatihan</a></li>
                            {{-- <li><a href="">Panduan mencari kerja secara aman</a></li> --}}
                            {{-- <li><a href="">Testimoni</a></li>
                            <li><a href="">Blog</a></li> --}}
                            {{-- <li><a href="">FAQ</a></li> --}}
                        </ul>
                    </div>
                </div>

                {{-- <div class="col-lg-2 col-md-2">
                    <div class="footer-widget">
                        <h4 class="widget-title">Perusahaan</h4>
                        <ul class="footer-menu">
                            <li><a href="">Profil Perusahaan</a></li>
                            <li><a href="">Kerjasama</a></li>
                        </ul>
                    </div>
                </div> --}}

                <div class="col-lg-2 col-md-2">
                    <div class="footer-widget">
                        {{-- <h4 class="widget-title">Wirausaha</h4> --}}
                        {{-- <ul class="footer-menu"> --}}
                            {{-- <li><a href="{{ route('enterpreneur.register') }}">Daftar Wirausaha</a></li>
                            <li><a href="{{ route('enterpreneur.index') }}">Login Wirausaha</a></li> --}}
                        {{-- </ul> --}}
                    </div>
                </div>

                {{-- <div class="col-lg-3 col-md-3">
          <div class="footer-widget">
            <h4 class="widget-title">Download Apps</h4>
            <a href="#" class="other-store-link">
              <div class="other-store-app">
                <div class="os-app-icon">
                  <i class="ti-android theme-cl"></i>
                </div>
                <div class="os-app-caps">
                  Google Play
                  <span>Get It Now</span>
                </div>
              </div>
            </a>
            <a href="#" class="other-store-link">
              <div class="other-store-app">
                <div class="os-app-icon">
                  <i class="ti-apple theme-cl"></i>
                </div>
                <div class="os-app-caps">
                  App Store
                  <span>Now it Available</span>
                </div>
              </div>
            </a>
          </div>
        </div> --}}

            </div>
        </div>
    </div>

    <div class="footer-bottom">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-6">
                        <p class="mb-0">© {{ date('Y') }} BLK Surabaya.</p>
                    </div>

                    <div class="col-lg-6 col-md-6 text-right">
                        <ul class="footer-bottom-social">
                            <li><a href="#" class="btn btn-small"><i class="ti-facebook"></i></a></li>
                            <li><a href="#" class="btn btn-small"><i class="ti-twitter"></i></a></li>
                            <li><a href="#" class="btn btn-small"><i class="ti-instagram"></i></a></li>
                            <li><a href="#" class="btn btn-small"><i class="ti-youtube"></i></a></li>
                        </ul>
                    </div>

            </div>
        </div>
    </div>
</footer>
<!-- ============================ Footer End ================================== -->