<?php

use App\Http\Controllers\SectionController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Blade;

class NavHelper{
    public static function list_menu($group)
    {
        $data = DB::table('menus')
                    ->select('name_menu', 'url', 'section_id', 'icons', 'order')
                    ->where('status', 'active')
                    ->where('group_id', $group)
                    ->orderBy('order', 'ASC')
                    ->get();

        $datax = DB::table('menus')
                    ->select('menu.name_menu', 'menu.url', 'menu.section_id', 'menu.icons', 'menu.order')
                    ->join('actions', 'actions.menu_id', '=', 'menu.id')
                    ->join('master_actions', 'master_actions.name', '=', 'actions.action')
                    ->join('action_groups', 'action_groups.action_id', '=', 'actions.id')
                    ->where('master_actions', 'lihat')
                    ->where('action_groups.group_id', $group)
                    ->get();

        $result = [];

        foreach ($data as $value) {
            $hasSection = DB::table('menu_sections')->where('id', $value->section_id)->first();

            if ($hasSection) {
                $sectionData = [
                    'section_id' => $value->section_id,
                    'section' => $hasSection->name_section,
                    'icons' => $hasSection->icons,
                    'active' => [],
                    'order' => $hasSection->order,
                    'menu' => [
                        [
                            'url' => $value->url,
                            'menu' => $value->name_menu,
                            'order' => $value->order
                        ]
                    ]
                ];

                // Check if the section_id already exists in $result
                $sectionIdExists = false;
                foreach ($result as &$existingSection) {
                    if ($existingSection['section_id'] === $value->section_id) {
                        $existingSection['menu'][] = [
                            'url' => $value->url,
                            'menu' => $value->name_menu,
                            'order' => $value->order
                        ];

                        $urlSegments = explode('/', $value->url);
                        foreach ($urlSegments as $segment) {
                            if ($segment !== '') { // Exclude empty segments
                                $existingSection['active'][] = $segment;
                            }
                        }

                        $sectionIdExists = true;
                        break;
                    }
                }

                if (!$sectionIdExists) {
                    $result[] = $sectionData;
                }

                foreach ($result as &$section) {
                    $aktif = [];
                    foreach ($section['menu'] as $menu) {
                        $aktif[] = $menu['url'];
                    }
                    $section['aktif'] = $aktif;
                }
            } else {
                // Menu tanpa section
                $result[] = [
                    'section_id' => $value->section_id,
                    'section' => $value->name_menu,
                    'icons' => $value->icons,
                    'order' => $value->order,
                    'url' => $value->url
                ];
            }
        }

        // Menggunakan usort() untuk mengurutkan $result berdasarkan "order"
        usort($result, function ($a, $b) {
            return $a['order'] <=> $b['order'];
        });

        return $result;
    }

    public static function create_checked($group_id, $name_menu, $aksi)
    {
        $result = DB::table('groups')
            ->join('action_groups', 'groups.id', '=', 'action_groups.group_id')
            ->join('actions', 'action_groups.action_id', '=', 'actions.id')
            ->select('actions.id')
            ->where([
                'groups.id' => $group_id,
                'actions.action' => $aksi,
            ])
            ->first();

        if ($result != null) {
            return true;
        }
    }

    public static function cekAkses($user_id, $menu, $aksi)
    {
        $cekAkses = DB::table('users')
            ->join('user_groups', 'users.id', '=', 'user_groups.user_id')
            ->join('groups', 'user_groups.group_id', '=', 'groups.id')
            ->join('action_groups', 'groups.id', '=', 'action_groups.group_id')
            ->join('actions', 'action_groups.action_id', '=', 'actions.id')
            ->select('actions.id')
            ->where([
                'users.id' => $user_id,
                'actions.action' => $aksi,
            ])
            ->first();

        if ($cekAkses != null) {
            return true;
        }
    }

    public static function addButton($nama)
    {
        return Blade::render("<x-add nama='$nama' />");
    }

    public static function editButton($nama, $id, $endpoint)
    {
        return Blade::render("<x-edit nama='$nama' id='$id' endpoint='$endpoint' />");
    }

    public static function simpan($nama)
    {
        return Blade::render("<x-simpan nama='$nama'/>");
    }

    public static function action($position, $id = 0)
    {
        $menu = DB::table('menus')
            ->where('url', Session::get('menu_active'))
            ->first();

        if (empty($menu)) {
            return [];
        }else{
            $cekAkses = DB::table('action_groups')
                ->join('actions', 'action_groups.action_id', '=', 'actions.id')
                ->select('actions.id', 'actions.action')
                ->where([
                    'action_groups.group_id' => Auth::user()->user_group[0]->group_id,
                    'actions.menu_id' => $menu->id,
                ])
                ->get();
            $arr = "";
            foreach ($cekAkses as $key => $value) {
                $button = DB::table('button')->where('position', $position)->where('name', $value->action)->first();
                if ($button) {
                    $x = str_replace('[id]', $id, $button->code);
                    $arr .= Blade::render($x);
                }
            }
            return $arr;
        }
        
    }
}