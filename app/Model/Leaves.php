<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Leaves extends Model
{
    protected $table = 'leaves';
    protected $fillable = ['company_id','employee_id','sick_leaves','casual_leaves','forwarded_leaves','earned_leaves'];

    // public function employeede(){
    //     return $this->hasOne()
    // }
}
