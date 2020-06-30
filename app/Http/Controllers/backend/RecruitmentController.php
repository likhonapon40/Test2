<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Employee;
use Carbon\Carbon;
use Auth;
class RecruitmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $t_employee= Employee::where(['status'=>1,'company_id'=>Auth::user()->id])->count();
        // $getSixMonthEmployee = Employee::where('created_at', ">", Carbon::now()->subMonths(6))->where(['status'=>1,'company_id'=>Auth::user()->id])->count();
        // $t_managers = Employee::where(['employee_designation_id'=>2,'company_id'=>Auth::user()->id])->count();


        //for total employee
        $t_employee = Employee::orderby('id', 'DESC')->where(['status' => 1]);
        if (Auth::user()->role_id != 5) {
            $t_employee = $t_employee->where('company_id', Auth::user()->id);
        }
        $t_employee = $t_employee->count();

        //for 6 month joining details
        $getSixMonthEmployee = Employee::where('created_at', ">", Carbon::now()->subMonths(6))->where(['status' => 1]);
        if (Auth::user()->role_id != 5) {
            $getSixMonthEmployee = $getSixMonthEmployee->where('company_id', Auth::user()->id);
        }
        $getSixMonthEmployee = $getSixMonthEmployee->count();
        //for 6 month leave details
        $leftSixMonthEmployee = Employee::where('created_at', ">", Carbon::now()->subMonths(6))->where(['status' => 0]);
        if (Auth::user()->role_id != 5) {
            $leftSixMonthEmployee = $leftSixMonthEmployee->where('company_id', Auth::user()->id);
        }
        $leftSixMonthEmployee = $leftSixMonthEmployee->count();

        //for total managers
        $t_managers = Employee::orderby('id', 'DESC')->where(['employee_designation_id' => 2])->where('status',1);
        if (Auth::user()->role_id != 5) {
            $t_managers = $t_managers->where('company_id', Auth::user()->id);
        }
        $t_managers = $t_managers->count();
        //for total O.Assistants
        $t_assistants = Employee::orderby('id', 'DESC')->where(['employee_designation_id' => 1])->where('status',1);

        if (Auth::user()->role_id != 5) {
            $t_assistants = $t_assistants->where('company_id', Auth::user()->id);
        }
        $t_assistants = $t_assistants->count();
        //for total SR.EXECS
        $srExecs = Employee::orderby('id', 'DESC')->where(['employee_designation_id' => 3])->where('status',1);

        if (Auth::user()->role_id != 5) {
            $srExecs = $srExecs->where('company_id', Auth::user()->id);
        }
        $srExecs = $srExecs->count();
        //for total Executives
        $executives = Employee::orderby('id', 'DESC')->where(['employee_designation_id' => 3])->where('status',1);
        if (Auth::user()->role_id != 5) {
            $executives = $executives->where('company_id', Auth::user()->id);
        }
        $executives = $executives->count();
        
        
        if($t_employee > 0){
            $totalManagerPersenties= ($t_managers * 100)/$t_employee;
            $totalAssistantsPercentiles= ($t_assistants * 100)/$t_employee;
            $totalExecutivesPercentiles= ($executives * 100)/$t_employee;
            $totalSrExecsPercentiles= ($srExecs * 100)/$t_employee;
        }else{
            $totalManagerPersenties= 0;
            $totalAssistantsPercentiles= 0;
            $totalExecutivesPercentiles= 0;
            $totalSrExecsPercentiles= 0;
        }

        


        return view('backend.pages.recruitment.index',compact('t_employee', 'getSixMonthEmployee', 'totalManagerPersenties',
    'leftSixMonthEmployee','t_managers','t_assistants','srExecs','executives','totalAssistantsPercentiles',
        'totalExecutivesPercentiles','totalSrExecsPercentiles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
