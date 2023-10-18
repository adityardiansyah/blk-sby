<?php
namespace App\Http\Repository;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ButtonRepository{
    public function button()
    {
        return DB::table('master_actions')->get();
    }

    public function detail_button($id)
    {   
        return DB::table('master_actions')->where('id', $id)->first();
    }

    public function store($request)
    {
        return DB::table('master_actions')
                ->insert([
                    'name' => $request->name,
                    'description' => $request->description,
                    'created_at' => date('Y-m-d H:i:s')
                ]);
    }

    public function update($request, $id)
    {
        return DB::table('master_actions')->where('id', $id)->update([
            'name' => $request->name,
            'description' => $request->description,
            'updated_at' => date('Y-m-d H:i:s')
        ]); 
    }
}