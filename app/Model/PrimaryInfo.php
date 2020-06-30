<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PrimaryInfo extends Model
{
    protected $table='primary_infos';
    protected $fillable=['company_name','company_name_ban','email','logo','logo_ban','favicon','mobile_num','mobile_no_ban','office_start_time','office_end_time',
        'address','address_ban','default_language','description','meta_tag','description_ban','meta_description','map_embed','total_leaves','casual_leaves','sick_leaves','company_id'];
}
