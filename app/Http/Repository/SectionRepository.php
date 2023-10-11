<?php
namespace App\Http\Repository;

use App\Models\Section;
use Illuminate\Support\Facades\Auth;
use DB;

class SectionRepository{
    protected $section;

    public function __construct(Section $sctn)
    {
        $this->section = $sctn;
    }

    public function get_all_section()
    {
        return $this->section->orderBy('order', 'ASC')->get();
    }

    public function get_section($id)
    {
        return DB::table('menu_sections')->where('id', $id)->first();
    }

    public function update($request, $id)
    {
        return DB::table('menu_sections')->where('id', $id)->update([
            'name_section' => $request->name_section,
            'icons' => $request->icons,
        ]);
    }
}