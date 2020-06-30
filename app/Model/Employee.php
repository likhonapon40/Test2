<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $table = 'employees';
    protected $fillable=['employee_name','employee_email','employee_nid','employee_designation_id','employee_salary','salary_update',
    'joining_date','image','status','employee_phone' ,'employee_password','created_by','company_id','_token'];

     public function employeeDesignation(){
        return $this->hasOne(Designation::class, 'id', 'employee_designation_id');
     }

   //   public function employeeNotice(){
   //     return $this->hasMany(Notice::class, 'employee_id', 'id');
   // }
   // public function employeeDetails(){
   //    return $this->belongsTo(Notice::class, 'employee_id', 'id');
   // }
    
}
