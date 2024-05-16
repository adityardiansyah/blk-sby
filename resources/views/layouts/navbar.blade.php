<nav class="navbar navbar-default navbar-fixed navbar-transparent white bootsnav">

    <div class="container">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-menu">
            <i class="fa fa-bars"></i>
        </button>
        <!-- Start Header Navigation -->
        <div class="navbar-header">
            <a class="navbar-brand" href="{{ route('home.index') }}">
                <img src="{{ asset('assets/images/logo.png') }}" class="logo logo-display" alt="">
            </a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="navbar-menu">
            @guest
                <ul class="nav navbar-nav navbar-right" data-in="fadeInDown" data-out="fadeOutUp">
                    <li><a href="#" data-toggle="modal" data-target="#daftar">
                            <i class="fa fa-sign-in"></i>Mendaftar</a></li>
                    <li><a href="{{ route('login') }}" class="signin"></i>Masuk</a></li>
                    {{-- <li class="left-br"><a href="javascript:void(0)" data-toggle="modal" data-target="#signup"
                      class="signin">Masuk</a></li> --}}
                </ul>
            @endguest
            @auth
                <ul class="nav navbar-nav navbar-right" data-in="fadeInDown" data-out="fadeOutUp">
                    <li>
                        <a href="{{ url('riwayat-pelatihan') }}">Riwayat Pelatihan</a>
                    </li>
                    <li><a href="#" data-toggle="modal" data-target="#logoutModal">
                            <i class="fa fa-sign-in"></i>Logout</a></li>
                </ul>
                
            @endauth
            <ul class="nav navbar-nav navbar-right" data-in="fadeInDown" data-out="fadeOutUp">
                <li>
                    <a href="{{ url('program-pelatihan') }}">Program Pelatihan</a>
                </li>
                <li>
                    <a href="{{ url('profile-company') }}">Profil</a>
                </li>
                <li>
                    <a href="{{ url('gallery') }}">Galeri</a>
                </li>
                <li>
                    <a href="{{ url('call-us') }}">Hubungi Kami</a>
                </li>
                @if(!empty(Auth::user()->user_group[0]))
                @if(Auth::user()->user_group[0]->group_id == 1)
                <li>
                    <a href="{{ url('profile') }}">Halaman Admin</a>
                </li>
                @endif
                @endif
            </ul>
        </div><!-- /.navbar-collapse -->
    </div>
</nav>