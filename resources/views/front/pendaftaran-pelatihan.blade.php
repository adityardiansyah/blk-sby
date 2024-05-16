@extends('layouts.base', ['title' => '- Pendaftaran Pelatihan'])

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

<!-- General Detail Start -->
<div class="detail-desc section">
    <div class="container">
        <div class="ur-detail-wrap top-lay">
                
            <div class="ur-detail-box">
                
                <div class="ur-thumb">
                    <img src="{{ asset('assets/images/logo_robot.png') }}" class="img-responsive" alt="" />
                </div>
                <div class="ur-caption">
                    <h3>Pendaftaran Pelatihan</h3>
                    <h4 class="ur-title">{{ $data->nama_pelatihan }}</h4>
                    <p class="ur-location"><i class="ti-check mrg-r-5"></i>Pendaftaran dibuka {{ date('d M Y',  strtotime($data->tanggal_awal)) }} - {{ date('d M Y',  strtotime($data->tanggal_akhir)) }}</p>
                    <label for="" class="badge">Sub Kejuruan : {{ $data->kejuruan->nama_kejuruan }}</label>
                </div>
                
            </div>
        </div>
        <div class="ur-detail-wrap create-kit padd-bot-0" style="margin-top:32px;">
            <div class="row bottom-mrg padd-top-30">
                <form id="form-daftar" class="add-feild" action="{{ url('daftar-pelatihan/'.$data->slug) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="col-md-6 col-sm-6">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Nama Lengkap" name="nama_lengkap" readonly value="{{ Auth::user()->name }}">
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-6">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Email" name="email" readonly value="{{ Auth::user()->email }}">
                        </div>
                    </div>

                    <div class="col-md-4 col-sm-4">
                        <div class="input-group">
                            <input type="text" class="form-control" id="no_hp" placeholder="Nomor Telepon" name="no_hp" required>
                        </div>
                    </div>
                    
                    <div class="col-md-4 col-sm-4">
                        <div class="input-group">
                            <input type="text" class="form-control" id="usia" placeholder="Usia / umur (ex : 20 Tahun)" name="usia" required>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <div class="input-group">
                            <select class="form-control input-lg" name="pendidikan" required>
                                <option>-- Pendidikan --</option>
                                <option value="SD">SD</option>
                                <option value="SMP">SMP</option>
                                <option value="SMA/SMK">SMA/SMK</option>
                                <option value="D1">D1</option>
                                <option value="D2">D2</option>
                                <option value="D3">D3</option>
                                <option value="S1/D4">S1/D4</option>
                                <option value="S2">S2</option>
                                <option value="S3">S3</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-12 col-sm-12">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Alamat" id="alamat" name="alamat" required>
                        </div>
                    </div>
                    
                    
                    
                    <div class="col-md-6 col-sm-6">
                        <div class="input-group">
                            <label for="">Foto Pribadi</label>
                            <input type="file" class="form-control" placeholder="Foto Pribadi" id="foto" name="foto" required>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <div class="input-group">
                            <label for="">Foto KTP</label>
                            <input type="file" class="form-control" placeholder="Foto KTP" id="foto_ktp" name="foto_ktp" required>
                        </div>
                    </div>
                    <div class="text-center">
                        <a href="{{ url('program-pelatihan') }}" class="btn btn-light">Batal</a>
                        <button type="button" class="btn btn-primary text-center" id="btn-daftar">Daftar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- General Detail End -->

@endsection

@push('js')
    <script>
        $('#btn-daftar').click(function(){
            let foto = $('#foto').val();
            let no_hp = $('#no_hp').val();
            let usia = $('#usia').val();
            let alamat = $('#alamat').val();
            let foto_ktp = $('#foto_ktp').val();
            
            if(foto == '' || no_hp == '' || usia == '' || alamat == '' || foto_ktp == ''){
                alert('Mohon melengkapi formulir pendaftaran!');
                return false;
            }

            Swal.fire({
                title: 'Apakah Anda Yakin?',
                text: "Pastikan anda tidak mendaftar dipelatihan lain dalam waktu yang sama!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, daftar!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                $('#form-daftar').submit();
            });

        })
    </script>
@endpush