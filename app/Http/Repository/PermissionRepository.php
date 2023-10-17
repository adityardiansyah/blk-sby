<?php

namespace App\Http\Repository;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Actions;
use App\Models\ActionGroups;

class PermissionRepository
{
    public function actionId($request, Actions $actions, ActionGroups $actionGroups)
    {
        $menu_id = $request->menu_id;
        $aksi = $request->aksi;
        $group_id = $request->group_id;

        $cek = DB::table('action_groups AS AG')
            ->join('actions AS A', 'A.id', '=', 'AG.action_id')
            ->select('A.id')
            ->where([
                'A.menu_id' => $menu_id,
                'A.master_action_id' => $aksi,
                'AG.group_id' => $group_id,
            ])
            ->first();

        if ($cek == null) {

            $actions->menu_id = $menu_id;
            $actions->master_action_id = $aksi;
            $actions->save();
            $last_id = $actions->id;

            $actionGroups->action_id = $last_id;
            $actionGroups->group_id = $group_id;
            $actionGroups->save();
        } else {
            DB::table('action_groups')->where([
                'action_id' => $cek->id,
                'group_id' => $group_id,
            ])->delete();
            DB::table('actions')->where([
                'id' => $cek->id,
            ])->delete();
        }
    }
}
