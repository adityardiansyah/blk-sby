<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;

class PermissionHelper
{
    function cekAkses($user_id, $menu, $aksi)
    {
        $cekAkses = DB::table('users')
            ->join('users_group', 'users.id', '=', 'users_group.user_id')
            ->join('groups', 'users_group.group_id', '=', 'groups.id')
            ->join('action_groups', 'groups.id', '=', 'action_groups.group_id')
            ->join('actions', 'action_groups.action_id', '=', 'actions.id')
            ->select('actions.id')
            ->where([
                'users.id' => $user_id,
                'actions.name' => $menu,
                'actions.action' => $aksi,
            ])
            ->first();

        if ($cekAkses != null) {
            return true;
        }
    }

    function checked($action_id, $group_id)
    {
        $checked = DB::table('action_groups')
            ->where([
                'action_id' => $action_id,
                'group_id' => $group_id,
            ])
            ->first();

        if ($checked != null) {
            return "checked='checked'";
        }
    }

    public static function create_checked($group_id, $name_menu, $aksi)
    {
        $result = DB::table('groups')
            ->join('action_groups', 'groups.id', '=', 'action_groups.group_id')
            ->join('actions', 'action_groups.action_id', '=', 'actions.id')
            ->select('actions.id')
            ->where([
                'groups.id' => $group_id,
                'actions.name' => $name_menu,
                'actions.action' => $aksi,
            ])
            ->first();

        if ($result != null) {
            return true;
        }
    }
}
