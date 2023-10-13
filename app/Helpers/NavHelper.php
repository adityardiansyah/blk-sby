<?php

use App\Http\Controllers\SectionController;
use Illuminate\Support\Facades\DB;

class NavHelper{
    public static function list_menu()
    {
        $data = DB::table('menus')
                    ->select('name_menu', 'url', 'section_id', 'icons', 'order')
                    ->where('status', '1')
                    ->orderBy('order', 'ASC')
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
                'actions.name' => $name_menu,
                'actions.action' => $aksi,
            ])
            ->first();

        if ($result != null) {
            return true;
        }
    }
}