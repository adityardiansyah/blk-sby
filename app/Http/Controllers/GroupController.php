<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Repository\GroupRepository;
use App\Models\Group;
use App\Models\UserGroup;

class GroupController extends Controller
{
    protected $group;

    public function __construct(GroupRepository $group)
    {
        $this->group = $group;

        $this->middleware(function ($request, $next) {
            Session::put('menu_active', '/group');
            return $next($request);
        });
    }

    public function index()
    {
        $data = $this->group->group();
        return view('permissions.group', compact('data'));
    }

    public function show($id)
    {
        $data = $this->group->detail_group($id);
        return response()->json([
            'success' => true,
            'message' => 'Detail Data group',
            'data'    => $data
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
            'description' => 'required',
        ]);

        $data = $this->group->update($request, $id);

        return response()->json([
            'success' => true,
            'message' => 'Data Group berhasil diperbarui.',
            'data' => $data,
        ]);
    }

    public function destroy($id)
    {
        $data = Group::findOrFail($id);

        if (UserGroup::where('group_id', $data->id)->exists()) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak dapat dihapus'
            ]);
        } else {
            $data->delete();
            return response()->json([
                'status' => true,
                'message' => 'Data Group berhasil dihapus'
            ]);
        }
    }
}
