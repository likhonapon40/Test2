<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $table= 'attendances';
    protected $fillable = ['company_id','employee_id','attending_time','attending_latitude','attending_longitude',
                            'leaving_time','leaving_latitude','leaving_longitude','status'];
}
