<?php

namespace App\Http\Controllers;

use App\Models\Kejuruan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class KejuruanController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            Session::put('menu_active', '/kejuruan');
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
        $data = Kejuruan::all();
        return view('page.kejuruan', compact('data'));
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
            Kejuruan::insert([
                'nama_kejuruan' => $request->nama_kejuruan, 
                'status' => 'aktif',
                'created_at' => date('Y-m-d H:i:s')]);

            return response()->json([
                'success' => true,
                'message' => 'Berhasil ditambahkan!'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal ditambahkan!'.$th->getMessage()
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
            $data = Kejuruan::where('id', $id)->first();

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
            Kejuruan::where('id', $id)->update([
                'nama_kejuruan' => $request->nama_kejuruan,
                'status' => $request->status
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Berhasil diubah!'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal diubah!'.$th->getMessage()
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
            Kejuruan::where('id', $id)->delete();

            return response()->json([
                'success' => true,
                'message' => 'Berhasil dihapus!'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal dihapus!'.$th->getMessage()
            ]);
        }
    }
}
