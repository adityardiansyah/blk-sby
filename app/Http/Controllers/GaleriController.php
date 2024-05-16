<?php

namespace App\Http\Controllers;

use App\Models\FotoGaleri;
use App\Models\Galeri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class GaleriController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            Session::put('menu_active', '/galeri');
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
        $galeri = Galeri::with('foto_galeri')->get();
        return view('page.galeri', compact('galeri'));
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
        try {
            DB::beginTransaction();
            $this->validate($request, [
                'judul' => 'required',
                'deskripsi' => 'required',
                'gambar' => 'required',
            ]);
            
            $galeri = Galeri::create([
                'judul' => $request->judul,
                'deskripsi' => $request->deskripsi,
                'status' => 'Aktif'
            ]);
            if(!empty($galeri)){
                if($request->hasFile('gambar')) {
                    foreach ($request->file('gambar') as $file) {
                        $path = $file->store('galeri', 'public');
                        FotoGaleri::create([
                            'galeri_id' => $galeri->id,
                            'foto' => $path
                        ]);
                    }
                }
            }
            DB::commit();
            
            return back()->with([
                'message' => [
                    'content' => 'Berhasil tambah data!',
                    'type' => 'success'
                ]
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with([
                'message' => [
                    'content' => 'Gagal tambah data!'. $e->getMessage(),
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
        try {
            $data = Galeri::where('id', $id)->first();

            return response()->json([
                'success' => true,
                'data' => $data,
                'message' => 'Berhasil ditampilkan!'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal ditampilkan!'.$th->getMessage()
            ]);
        }
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
        try {
            
            DB::beginTransaction();
            $id = $request->id;
            
            $galeri = Galeri::findOrFail($id);
            if(!empty($galeri)){
                if($request->hasFile('gambar_edit')) {
                    foreach ($request->file('gambar_edit') as $file) {
                        $path = $file->store('galeri', 'public');
                        FotoGaleri::create([
                            'galeri_id' => $galeri->id,
                            'foto' => $path
                        ]);
                    }
                }
            }
            $galeri->update([
                'judul' => $request->judul_edit,
                'deskripsi' => $request->deskripsi_edit,
                'status' => $request->status_edit
            ]);
            DB::commit();
            return back()->with([
                'message' => [
                    'content' => 'Berhasil tambah data!',
                    'type' => 'success'
                ]
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with([
                'message' => [
                    'content' => 'Gagal tambah data!'. $e->getMessage(),
                    'type' => 'error'
                ]
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            FotoGaleri::where('galeri_id', $id)->delete();
            Galeri::find($id)->delete();
            return response()->json([
                'success' => true,
                'message' => 'Berhasil dihapus!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal dihapus!'.$e->getMessage()
            ]);
        }
    }

    /**
     * Remove the specified photo from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        try {
            FotoGaleri::find($id)->delete();
            return response()->json([
                'success' => true,
                'message' => 'Foto berhasil dihapus!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus foto!'.$e->getMessage()
            ]);
        }
    }
}
