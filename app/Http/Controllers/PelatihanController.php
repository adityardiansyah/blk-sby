<?php

namespace App\Http\Controllers;

use App\Models\Pelatihan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str; 


class PelatihanController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            Session::put('menu_active', '/pelatihan');
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
        $data = Pelatihan::all();
        return view('page.pelatihan', compact('data'));
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
            $validate = Validator::make($request->all(), [
                'nama_pelatihan' => 'unique:pelatihan,nama_pelatihan|required',
                'slug' => 'unique:pelatihan,slug',
                'tanggal_awal' => 'required',
                'tanggal_akhir' => 'required',
                'kuota' => 'required',
                'deskripsi' => 'required',
                'status' => 'required',
            ], [
                'nama_pelatihan.unique' => 'Nama Pelatihan Sudah Ada',
                'slug.unique' => 'Slug Sudah Ada',
                'tanggal_awal.required' => 'Tanggal Awal Tidak Boleh Kosong',
                'tanggal_akhir.required' => 'Tanggal Akhir Tidak Boleh Kosong',
                'kuota.required' => 'Kuota Tidak Boleh Kosong',
                'deskripsi.required' => 'Deskripsi Tidak Boleh Kosong',
                'status.required' => 'Status Tidak Boleh Kosong',
            ]);
            if ($validate->fails()) {
                return response()->json($validate->errors(), 422);
            }

            $slug = Str::slug($request->input('nama_pelatihan'));
            $data = Pelatihan::create($request->all() + ['slug' => $slug]);
            return response()->json([
                'success' => true,
                'message' => 'Berhasil ditambahkan!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal ditambahkan!'.$e->getMessage()
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
            $data = Pelatihan::where('id', $id)->first();

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
            Pelatihan::where('id', $id)->update([
                'nama_pelatihan' => $request->nama_pelatihan,
                'tanggal_pelaksanaan' => $request->tanggal_pelaksanaan,
                'tanggal_awal' => $request->tanggal_awal,
                'tanggal_akhir' => $request->tanggal_akhir,
                'kuota' => $request->kuota,
                'deskripsi' => $request->deskripsi,
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
            Pelatihan::where('id', $id)->delete();

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
