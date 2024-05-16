@guest
@if (request()->segment(1) != 'kewirausahaan')
    
<div class="modal fade" id="daftar" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content padd-bot-0">
      <div class="modal-body">

        <div class="new-logwrap">
          <div class="text-center mrg-bot-30">
            <img src="{{ asset('public/assets/img/logo_v2_black.png') }}" class="width-300" alt="">
          </div>
          @include('components.form-register')

          <div class="text-center mrg-top-10">
            Sudah punya akun? <a class="theme-cl" href="{{ route('login') }}">Masuk</a>
          </div>

        </div>

      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="registerAlumni" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content padd-bot-0">
      <h5 class="modal-header">Registrasi Akun</h5>
      <div class="modal-body">
        <div class="new-logwrap" style="padding: 0px 70px 50px 70px!important;">
          <div class="text-center mrg-bot-30">
            <img src="{{ asset('public/assets/img/logo_v2_black.png') }}" class="width-300" alt="">
          </div>
          <form action="{{ url('register') }}" method="POST">
            @csrf
            @if ($errors->any())
            <div class="alert alert-danger">
              <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
            @endif
            <div class="form-group">
              <label>Email Login</label>
              <div class="input-with-icon">
                <input id="email" type="email" class="form-control " name="email" required
                  placeholder="Enter Your Email" value="{{ old('email') }}">
                <i class="theme-cl ti-email"></i>
              </div>
            </div>

            <div class="form-group">
              <label>Password</label>
              <div class="input-with-icon">
                <input id="password" type="password" class="form-control" name="password" required
                  placeholder="Enter Your Password">
                <i class="theme-cl ti-lock"></i>
              </div>
            </div>

            <div class="form-group">
              <label>Konfirmasi Password</label>
              <div class="input-with-icon">
                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required
                  placeholder="Enter Your Password Confirm">
                <i class="theme-cl ti-lock"></i>
              </div>
            </div>

            <div class="form-group">
              <ul>
                <li>Password minimal 8 Karakter</li>
              </ul>
            </div>


            <div class="form-groups">
              <button type="submit" class="btn btn-primary theme-bg full-width">Register</button>
            </div>
          </form>
        </div>

      </div>
    </div>
  </div>
</div>
@endif

@endguest
@auth
    <!-- Logout Modal -->
    <div class="modal fade" id="logoutModal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-sm">
        <div class="modal-content" style="padding: 0px 0px 0px 0px;">
          <div class="modal-header" style="background: #e63c3c">
            <h5 class="modal-title" id="exampleModalLabel" style="color: white">Keluar Website?</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">Klik Logout untuk keluar dari website.</div>
          <form action="{{ route('logout') }}" method="POST">
            @csrf
            <div class="modal-footer">
              <button type="submit" class="btn btn-danger btn-small">Logout</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <!-- Logout Modal -->
    @if(request()->segment(2) == 'work-experience')
    <!-- addWork Form Code -->
    {{-- <div class="modal fade addWork" id="addWork" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          @include('components.form-experience', [
          'modalTitle' => 'Tambah Pengalaman',
          'route' => route('alumnus.store', ['tab' => 'work-experience']),
          'buttonSubmit' => 'Simpan',
          ])
        </div>
      </div>
    </div>
    <!-- End addWork Form --> --}}
    
    <!-- Apply change Form Code -->
    {{-- <div class="modal fade" id="editWork" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          @include('components.form-experience', [
          'modalTitle' => 'Ubah Pengalaman',
          'route' => route('alumnus.update', ['tab' => 'work-experience', 'id' => ' ']),
          'method' => '<input name="_method" type="hidden" value="PUT" />',
          'buttonSubmit' => 'Ubah',
          ])
        </div>
      </div>
    </div> --}}
    <!-- End Apply change Form -->
    @endif
    
    <!-- addWork Form Code -->
    {{-- <div class="modal fade addOrganization" id="addOrganization" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          @include('components.form-organization', [
          'modalTitle' => 'Tambah Pengalaman Organisasi',
          'route' => route('alumnus.store', ['tab' => 'organization']),
          'buttonSubmit' => 'Simpan',
          ])
        </div>
      </div>
    </div> --}}
    <!-- End addWork Form -->
    
    <!-- Apply change Form Code -->
    {{-- <div class="modal fade editOrganization" id="editOrganization" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          @include('components.form-organization', [
          'modalTitle' => 'Ubah Pengalaman Organisasi',
          'route' => route('alumnus.update', ['tab' => 'organization', 'id' => ' ']),
          'method' => '<input name="_method" type="hidden" value="PUT" />',
          'buttonSubmit' => 'Ubah',
          ])
        </div>
      </div>
    </div> --}}
    <!-- End Apply change Form -->
    <!-- Skill Form Code -->
    <div class="modal fade" id="addSkill" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Tambah Keterampilan</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form action="" class="post-form">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Keterampilan</label>
                    <input type="text" class="form-control">
                  </div>
                </div>
                <div class="col-md-5">
                  <div class="form-group">
                    <label>Tingkat</label>
                    <select class="form-control" name="tingkat">
                      <option>Tingkat Lanjutan</option>
                      <option>Menengah</option>
                      <option>Pemula</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-1">
                  <a href="javascript:;"><i class="fa fa-trash mrg-top-40"></i></a>
                </div>
              </div>
              <a href="javascript:;" id="btn-add-skill"><span class="fa fa-plus"></span> Tambah Keterampilan</a>
              <div class="text-right">
                <button type="submit" class="btn btn-primary theme-bg">Simpan</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <!-- End Apply Form -->
    
    <!-- Language Form Code -->
    <div class="modal fade" id="addLanguage" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Tambah Bahasa</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <p>Tingkat Kemahiran: 0 - Jelek, 10 - Baik Sekali</p>
            {{-- <form action="{{ route('alumnus.store', ['tab' => 'language']) }}" class="post-form" method="POST">
              <input type="number" name="index" id="indexLanguage" hidden value="0">
              @csrf
              <div class="div" id="contentLanguage">
                @include('components.form-language')
              </div>
              <a href="javascript:;" id="btn-add-language"><span class="fa fa-plus"></span> Tambah Keterampilan</a>
              <div class="text-right">
                <button type="submit" class="btn btn-primary theme-bg">Simpan</button>
              </div>
            </form> --}}
          </div>
        </div>
      </div>
    </div>
    

    <div class="modal fade" id="modalDelete" role="dialog" aria-labelledby="modalDeleteLabel" aria-hidden="true">
      <div class="modal-dialog modal-sm">
        <div class="modal-content" style="padding: 0px">
          <div class="modal-header">Hapus Data</div>
          <form id="formDelete" action="" method="post">
            <div class="modal-body">
              @method('delete')
              @csrf
              Anda yakin ingin menghapus ?
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-danger btn-small">Hapus</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <!-- End Apply Form -->
    
    
    <!-- viewResume Form Code -->
    <div class="modal fade" id="viewResume" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-body p-30" id="modal-resume">

          </div>
        </div>
      </div>
    </div>
    <!-- End viewResume Form -->
@endauth