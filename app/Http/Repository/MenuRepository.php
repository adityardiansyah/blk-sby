<?php
namespace App\Http\Repository;

use App\Models\Menu;
use Illuminate\Support\Facades\Auth;
use DB;

class MenuRepository{
    protected $menu;

    public function __construct(Menu $menu)
    {
        $this->menu = $menu;
    }

    public function get_all_menu()
    {
        return DB::table('menus')
                ->select('id', 'name_menu', 'url', 'section_id', 'icons', 'order')
                ->where('status', '1')
                ->orderBy('order', 'ASC')
                ->get();
    }

    public function get_menu($id)
    {
        return DB::table('menus')->where('id', $id)->first();
    }

    public function get_menu_by_section($section)
    {
        return DB::table('menus')->where('section_id', $section)->get();
    }

    public function store($request)
    {
        return DB::table('menu_sections')
                ->insert([
                    'group_id' => $request,
                    'section_id' => $request,
                    'name_menu' => $request,
                    'url' => $request,
                    'icons' => $request,
                    'order' => $request
                ]);
    }

    public function update($request, $id)
    {
        return DB::table('menus')->where('id', $id)->update($request);
    }
}