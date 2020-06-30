<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Notice;
use App\Model\Attendance;
use App\Model\Employee;
use Auth;

class DashboardController extends Controller
{
    public function index(){
        //for notice
        $notice = Notice::orderby('id', 'DESC')->where('status',0);
        if (Auth::user()->role_id != 5) {
            $notice = $notice->where('company_id', Auth::user()->id);
        }
        $notice = $notice->limit(3)->get();
       $unapproved_notice=Notice::where(['status'=>0,'company_id'=>Auth::user()->id])->count();
       $approved_notice=Notice::where(['status'=>1,'company_id'=>Auth::user()->id])->count();
        //for attendance
        $attending_employee=Attendance::where(['status'=>1,'company_id'=>Auth::user()->id])->count();
        $absent_today = Attendance::where(['status' => 0,'company_id'=>Auth::user()->id])->count();
        //for attendance %
        $total_employee = Employee::where(['status'=>1,'company_id'=>Auth::user()->id])->count();
        if($total_employee > 0 ){
            $totalPresentToday = ($attending_employee * 100)/$total_employee;
            $totalAbsentToday = ($absent_today * 100)/$total_employee;
        }
        else{
            $totalPresentToday = 0;
            $totalAbsentToday = 0;
        }


        return view('backend.dashboard',compact('notice','attending_employee','absent_today','totalPresentToday',
        'totalAbsentToday','unapproved_notice','approved_notice'));
    }
}
