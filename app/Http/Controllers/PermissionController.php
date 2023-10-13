<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Group;
use App\Models\UserGroup;
use App\Models\Actions;
use App\Models\ActionGroups;
use App\Http\Repository\MenuRepository;
use App\Http\Repository\PermissionRepository;
use Illuminate\Support\Facades\DB;

class PermissionController extends Controller
{
    protected $menu;
    protected $permission;

    public function __construct(MenuRepository $menu, PermissionRepository $permission)
    {
        $this->menu = $menu;
        $this->permission = $permission;
    }

    public function data_akses($id)
    {
        $groups = Group::find($id);
        $menus = $this->menu->get_all_menu();

        return view('permissions.data-akses', compact('groups', 'menus'));
    }


    public function edit_akses(Request $request, Actions $actions, ActionGroups $actionGroups)
    {
        $this->permission->actionId($request, $actions, $actionGroups);

        return response()->json([
            'status'  => 'success',
            'message' => 'Akses berhasil di ubah'
        ]);
    }
}
