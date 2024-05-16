<?php

namespace App\Http\Controllers;

use App\Models\Galeri;
use App\Models\HubungiKami;
use App\Models\Kejuruan;
use App\Models\Pelatihan;
use App\Models\Pendaftaran;
use App\Models\Profil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\RiwayatPelatihan;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void 
     */
    public function __construct()
    {
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('index');
    }

    public function profil()
    {
        return view('front.about-us');
    }

    public function hubungi_kami(){
        $data = HubungiKami::where('status','aktif')->get();
        return view('front.call-us', compact('data'));
    }

    public function gallery(Request $request) {
        $data = Galeri::with(['fotoGaleri'])
                      ->where('status', 'Aktif')
                      ->when(!empty($request->search), function ($query) use ($request){
                        $query->where('judul','like','%'.$request->search.'%');
                      })
                      ->when(!empty($request->sort), function ($query) use ($request){
                        $query->orderBy('created_at', $request->sort);
                      })
                      ->get();

        return view('front.gallery', compact('data'));
    }

    public function detail_gallery($id) {
        $data = Galeri::with(['fotoGaleri'])->where('id', $id)->first();

        return view('front.detail-gallery', compact('data'));
    }

    public function profile_company() {
        $data = Profil::where('id', 1)->first();

        return view('front.profile-company', compact('data'));
    }

    public function program_pelatihan(Request $request) {
        $sub_kejuruan = Kejuruan::where('status','aktif')->get();
        
        $data = Pelatihan::where('status','Aktif')
                ->when(!empty($request->kejuruan), function ($query) use ($request){
                    $query->where('sub_kejuruan', $request->kejuruan);
                })->when(!empty($request->search), function ($query) use ($request){
                    $query->where('nama_pelatihan','like','%'.$request->search.'%');
                })->when(!empty($request->sort), function ($query) use ($request){
                    $query->orderBy('created_at', $request->sort);
                })->orderBy('id','desc')->get();

        return view('front.program-pelatihan', compact('data','sub_kejuruan','request'));
    }

    public function detail_program_pelatihan($slug) {
        $data = Pelatihan::where('slug',$slug)->first();
        $pelatihan = Pelatihan::where('status','Aktif')->orderBy('id','desc')->take(3)->get();

        return view('front.detail-program-pelatihan', compact('data','pelatihan'));
    }

    public function daftar_pelatihan($slug) {
        $data = Pelatihan::where('slug',$slug)->first();
        $kejuruan = Kejuruan::where('status','aktif')->get();

        return view('front.pendaftaran-pelatihan', compact('data','kejuruan'));
    }

    public function daftar_pelatihan_simpan(Request $request, $slug) {
        try {
            DB::beginTransaction();
            $data = Pelatihan::where('slug',$slug)->first();
            $check = Pendaftaran::where('user_id',Auth::user()->id)->where('pelatihan_id',$data->id)->first();
            if(empty($check)) {
                $foto = "";
                $foto_ktp = "";
                if($request->hasFile('foto')){
                    $foto = $request->file('foto')->store('public/foto');
                }
                if($request->hasFile('foto_ktp')){
                    $foto_ktp = $request->file('foto_ktp')->store('public/foto_ktp');
                }
        
                $save = Pendaftaran::create(array(
                    'user_id' => Auth::user()->id,
                    'pelatihan_id' => $data->id,
                    'alamat' => $request->alamat,
                    'no_hp' => $request->no_hp,
                    'pendidikan' => $request->pendidikan,
                    'usia' => $request->usia,
                    'sub_kejuruan' => $data->sub_kejuruan,
                    'tanggal_pendaftaran' => date('Y-m-d'),
                    'foto' => $foto,
                    'foto_ktp' => $foto_ktp
                ));
                RiwayatPelatihan::insert(['pelatihan_id' => $data->id, 'user_id' => Auth::user()->id]);
                
                DB::commit();
                return redirect('/informasi-seleksi/'.$data->slug)->with('success', 'Berhasil mendaftar pelatihan');;
            }else{
                return redirect()->back()
                ->with('errors', 'Gagal, anda sudah mendaftar!');
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()
                ->with('errors', 'Gagal! '. $th->getMessage());
        }
    }

    public function informasi_pelatihan($slug) {
        $pelatihan = Pelatihan::where('slug',$slug)->first();
        return view('front.informasi-pelatihan',compact('pelatihan'));
    }

    public function riwayat_pelatihan(Request $request) {
        $data = RiwayatPelatihan::join('pelatihan','pelatihan.id','riwayat_pelatihan.pelatihan_id')
                ->join('kejuruan','kejuruan.id', 'pelatihan.sub_kejuruan')
                ->where('user_id',Auth::user()->id)
                ->when(!empty($request->search), function ($query) use ($request){
                    $query->where('nama_pelatihan','like','%'.$request->search.'%');
                })->when(!empty($request->sort), function ($query) use ($request){
                    $query->orderBy('riwayat_pelatihan.created_at', $request->sort);
                })->orderBy('riwayat_pelatihan.id','desc')
                ->get();
        
        return view('front.riwayat-pelatihan', compact('data'));
    }
}
