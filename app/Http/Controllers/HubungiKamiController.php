<?php

namespace App\Http\Controllers;

use App\Models\HubungiKami;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class HubungiKamiController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            Session::put('menu_active', '/hubungi-kami');
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
        $hubungi_kami = HubungiKami::all();
        return view('page.hubungi-kami', compact('hubungi_kami'));
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
            foreach ($request->nama as $key => $value) {
                HubungiKami::updateOrCreate(
                    [
                        'id' => $request->id[$key]?? null,
                        'judul' => $request->nama[$key],
                        'isi' => $request->nomor[$key]
                    ],
                    [
                        'judul' => $request->nama[$key],
                        'isi' => $request->nomor[$key]
                    ]
                );
            }
            return back()->with([
                'message' => [
                    'content' => 'Berhasil tambah data!',
                    'type' => 'success'
                ]
            ]);
        } catch (\Exception $e) {
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
        try {
            HubungiKami::find($id)->delete();
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
}
