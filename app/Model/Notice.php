<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Notice extends Model
{
    protected $table='notices';
    protected $fillable=['company_id','employee_id','notice_title','notice_description','status'];

    // public function employeeDetails(){
    //     return $this->hasMany(Employee::class, 'id', 'employee_id');
    //  }
    public function employeeDetails(){
        return $this->hasOne(Employee::class, 'id', 'employee_id');
     }
}
