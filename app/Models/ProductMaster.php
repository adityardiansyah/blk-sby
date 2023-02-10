<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ProductMaster extends Model
{
    use HasFactory;

    protected $fillable = ['code','name','name_warehouse','group','brand','variant','motive'];

    public function syncProductMasterERP()
    {
        $get_data = DB::connection('pgsql')->select("
            select 
            b.prd_code as code,
            concat(b.prd_desc  ,' ', c.size_desc ) AS name,
            concat(b.prd_desc  ,' ', c.size_desc ) AS name_warehouse, 
            g.group_desc as group,
            d.brand_desc brand,
            f.variant_desc variant,
            e.motive_name motive
            from 
            im_prd_master_detail a 
            join im_prd_master b on a.prd_id = b.id 
            join im_prd_size c on c.id = a.size_id
            join im_prd_brand d on d.id = b.brand_id 
            join im_prd_motive e on e.id = b.motive_id 
            join im_prd_variant f on f.id = b.variant_id
            join im_prd_group g on g.id = b.group_id 
            where b.prd_type_id IN  (37,39,40,41,42 ) 
            and b.prd_code is not null
        ");
        return $get_data;
    }
}
