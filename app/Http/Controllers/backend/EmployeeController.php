<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Designation;
use App\Model\Employee;
use Auth;
use MyHelper;
use Validator;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //  $employee=Employee::where('company_id',Auth::user()->id)->orderby('id','DESC')->get();
        //for total Executives
        $employee = Employee::orderby('id', 'DESC')->where('status',1);
        if (Auth::user()->role_id != 5) {
            $employee = $employee->where('company_id', Auth::user()->id);
        }
        $employee = $employee->get();
        return view('backend.pages.employee.index',compact('employee'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $designation = Designation::orderby('id', 'DESC')->where('status',1);
        // if (Auth::user()->role_id != 5) {
        //     $designation = $designation->where('company_id', Auth::user()->id);
        // }
        // $designation = $designation->pluck('designation_name','id');

        $designation=Designation::where('status' , 1)->pluck('designation_name','id');
        return view('backend.pages.employee.create',compact('designation'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $input['created_by']=Auth::user()->id;
        $input['company_id']=Auth::user()->id;
        $validator = Validator::make($input, [
            'employee_password' => 'required|max:4|min:4',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        if ($request->hasFile('image')){
            $input['image']=MyHelper::photoUpload($request->file('image'),'images/employee/',120,100);
        }
        
      
        try{
            Employee::create($input);
            $bug=0; 
        }catch(\Exception $e){
            $bug=$e->errorInfo[1];
        }
        if($bug==0){
            return redirect()->back()->with('success','Data Successfully Inserted');
        }elseif($bug==1062){
            return redirect()->back()->with('error','The Email has already been taken.');
        }else{
            return redirect()->back()->with('error','Something Error Found ! ');
        }
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
        
        $data=Employee::findorfail($id);
        $designation=Designation::where('status' , 1)->pluck('designation_name','id');
        return view('backend.pages.employee.edit',compact('data','designation'));
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
        $input = $request->all();
        $data=Employee::findOrFail($id);
        $input['company_id']=Auth::user()->id;
        $validator = Validator::make($input, [
            'employee_password' => 'required|max:4|min:4',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        if ($request->hasFile('image')){
            $input['image']=MyHelper::photoUpload($request->file('image'),'images/employee/',120,100);
            if (file_exists($data->image)){
                unlink($data->image);
            }
        }
        $data->update($input);
            $bug=0;
        try{
            
        }catch(\Exception $e){
            $bug=$e->errorInfo[1];
        }
        if($bug==0){
            return redirect()->back()->with('success','Successfully Update');
        }else{
            return redirect()->back()->with('error','Something Error Found ! ');
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

    public function employeeLeave(Request $request,$id){
        $input = $request->all();
        $data=Employee::findOrFail($id);
        $data->update($input);
            $bug=0;
        try{
            
        }catch(\Exception $e){
            $bug=$e->errorInfo[1];
        }
        if($bug==0){
            return redirect()->back()->with('success','Successfully Update');
        }else{
            return redirect()->back()->with('error','Something Error Found ! ');
        }
    }


}
