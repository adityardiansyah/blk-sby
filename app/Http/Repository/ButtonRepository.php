<?php
namespace App\Http\Repository;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ButtonRepository{
    public function button()
    {
        return DB::table('button')->get();
    }

    public function detail_button($id)
    {   
        return DB::table('button')->where('id', $id)->first();
    }

    public function store($request)
    {
        return DB::table('button')
                ->insert([
                    'name' => $request->name,
                    'code' => $request->code,
                    'position' => $request->position,
                    'created_at' => date('Y-m-d H:i:s')
                ]);
    }

    public function update($request)
    {
        return DB::table('button')->where('id', $request->id)->update([
            'name' => $request->name,
            'code' => $request->code,
            'position' => $request->position,
            'updated_at' => date('Y-m-d H:i:s')
        ]); 
    }
}