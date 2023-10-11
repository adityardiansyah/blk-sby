<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Repository\GroupRepository;

class GroupController extends Controller
{
    protected $group;

    public function __construct(GroupRepository $group) {
        $this->group = $group;
        $this->middleware(function ($request, $next){
            Session::put('menu_active','/group');
            return $next($request);
        });
    }

    public function index()
    {
        $data = $this->group->group();
        return view('page.group', compact('data'));
    }

    public function api($id)
    {
        $data = $this->group->detail_group($id);
        return response()->json([
            'payload' => $data
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required'
        ]);

        $this->group->store($request);

        return response()->json([
            'success' => TRUE,
            'message' => 'Berhasil menambah data!'
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required'
        ]);

        $this->group->update($request, $id);

        return response()->json([
            'success' => TRUE,
            'message' => 'Berhasil mengupdate data!'
        ]);
    }

    public function delete($id)
    {
        return $this->group->delete($id);
    }
}
