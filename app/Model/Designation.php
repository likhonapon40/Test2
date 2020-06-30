<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Designation extends Model
{
    protected $table = 'designations';
    protected $fillable =['designation_name','status','company_id'];

    // public function employeeDesignation(){
    //     return $this->hasMany(Employee::class,'employee_designation_id','id');
    // }
    // public function designation_id(){
    //     return $this->hasMany('App\Model\Employee');
    // }
}
