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
        $menu       = $request->menu;
        $aksi       = $request->aksi;
        $group_id   = $request->group_id;

        $cek = DB::table('action_groups AS A')
            ->join('actions AS B', 'B.id', '=', 'A.action_id')
            ->select('B.id')
            ->where([
                'B.name' => $menu,
                'B.action' => $aksi,
                'A.group_id' => $group_id
            ])
            ->first();

        if ($cek == null) {
            $actions->name       = $menu;
            $actions->action       = $aksi;
            $actions->save();
            $last_id = $actions->id;

            $actionGroups->action_id    = $last_id;
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
