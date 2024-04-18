<?php

namespace App\Http\Controllers;

use App\Models\Profil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ProfilController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            Session::put('menu_active', '/profil');
            return $next($request);
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $profil = Profil::find(1);
        return view('page.profil', compact('profil'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            $this->validate($request, [
                'judul' => 'required|string|max:255',
                'sejarah' => 'required|string',
                'visi' => 'required|string',
                'misi' => 'required|string',
                'foto_gedung' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            $foto = $request->file('foto_gedung');
            $nama_foto = time().'.'.$foto->getClientOriginalExtension();
            $foto->move(public_path('images'), $nama_foto);

            Profil::updateOrCreate(
                ['id' => 1],
                [
                    'judul' => $request->judul,
                    'sejarah' => $request->sejarah,
                    'visi' => $request->visi,
                    'misi' => $request->misi,
                    'foto_gedung' => $nama_foto,
                ]
            );
            return back()->with([
                'message' => [
                    'content' => 'Berhasil ubah profil!',
                    'type' => 'success'
                ]
            ]);
        } catch (\Exception $e) {
            return back()->with([
                'message' => [
                    'content' => 'Gagal ubah profil!',
                    'type' => 'error'
                ]
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
