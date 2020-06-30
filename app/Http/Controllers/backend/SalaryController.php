<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Employee;
use App\Model\Salary;
use App\Model\Designation;
use Auth;

class SalaryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $employee=Employee::JOIN('designations','employees.employee_designation_id','designations.id')->select('employees.*',
        // 'designations.designation_name as e_d_name')->orderby('employees.id','DESC')->where('employees.status',1)->get();
        // $employee = Employee::orderby('id','DESC')->where('status',1)->get();
        // $employee=Employee::LEFTJOIN('salaries','salaries.émployee_id','salaries.id')->select('employees.*',
        // 'salaries.salary_update','salaries.updated_at as e_u_at')->orderby('employees.id','DESC')->where('employees.status',1)->get();
        $employee = Employee::orderby('id','DESC')->where('status',1);
        if(Auth::user()->role_id != 5){
            $employee =$employee->where('company_id',Auth::user()->id );
        }
        $employee = $employee->get();
        return view('backend.pages.salary.index',compact('employee'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
        $data=Employee::findOrFail($id);
        $designation=Designation::where('status' , 1)->pluck('designation_name','id');
        $employee=Employee::LEFTJOIN('salaries','salaries.émployee_id','salaries.id')->select('employees.*',
        'salaries.salary_update','salaries.updated_at as e_u_at')->orderby('employees.id','DESC')->
        where('employees.status',1)->get($id);
        return view('backend.pages.salary.edit',compact('data','employee','designation'));
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
        $employeeData = Employee::findOrFail($id);

        $input['salary_update'] = $request->salary_update;

        try{
            $bug = 0;
                
            $employeeData->update($input);
            
        }catch(Exception $e){
            $bug = $e->getMessage();
       }
       
       if($bug===0){
            $salaryInc = array();
            $salaryInc['employee_id'] = $id;
            $salaryInc['company_id'] = Auth::User()->id;
            $salaryInc['salary_update'] = $request->salary_update;
            Salary::create($salaryInc);
            return redirect()->back()->with('success','Salary Successfully Updated');

       }else{
            return redirect()->back()->with('error',$bug);
       }
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
