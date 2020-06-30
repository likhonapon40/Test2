<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Salary extends Model
{
    protected $table = 'salaries';
    protected $fillable=['company_id','employee_id','salary_update',];

    
}
