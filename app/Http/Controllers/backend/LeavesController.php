<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Employee;
use App\Model\Leaves;
use App\Model\Designation;
use App\Model\PrimaryInfo;
use Auth;
use Illuminate\Support\Facades\Redirect;

class LeavesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $employee = Employee::orderby('id', 'DESC')->where(['status' => 1]);

        // if (Auth::user()->role_id != 5) {
        //     $employee = $employee->where('company_id', Auth::user()->id);
        // }

        // $employee = $employee->get();
        $employee=Employee::orderby('id','DESC')->where(['status'=>1,'company_id'=>Auth::user()->id])->get();
        return view('backend.pages.leaves.index',compact('employee'));
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
        $data=Employee::findorfail($id);
        $info=PrimaryInfo::first();
        $leaves = Leaves::where('id',$id)->get();
        return view('backend.pages.leaves.show',compact('data','info','leaves'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
        

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
        


         try{
                $data=Employee::findOrFail($id);
             $bug = 0;
         }catch(\Exception $e){
             $bug =$e->errorInfo[1];
         }



         if($bug == 0){
            $leaves = array();
            $bug = 0;
            $leaves['employee_id'] =$id;
            $leaves['company_id'] = Auth::user()->id;
            $leaves['forwarded_leaves'] = $request->forwarded_leaves;
            $leaves['earned_leaves'] = $request->earned_leaves;
            Leaves::create($leaves);
            return redirect()->back()->with('success','Update SuccessFull');
         }else{
             return Redirect()->back()->with('error','Something Error Found...');
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
