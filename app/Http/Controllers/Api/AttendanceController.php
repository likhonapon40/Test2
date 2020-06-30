<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Attendance;
use Validator;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $validator = Validator::make($request->all(), [ 
            'company_id' => 'required',
            'employee_id' => 'required',
            'attending_time' => 'required',
        ]);   
        if ($validator->fails()) {          
            return response()->json(['error'=>$validator->errors()], 403);
        } 
        
        try{
            
        $input = Attendance::create($request->all());
            return response()->json(['success'=>'Attendance Successfully.'], 201);
        }catch(\Exception $e){
            return response()->json(['error'=>$e->errorInfo[2]], 500);
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
        $validator = Validator::make($request->all(), [ 
            'leaving_time' => 'required',
            'leaving_latitude' => "required",
            'leaving_longitude' => 'required',
        ]);   
        if ($validator->fails()) {          
            return response()->json(['error'=>$validator->errors()], 403);
        }    
        $input = $request->all();  
        
        try{
            $attendance = Attendance::findOrFail($id);
            $attendance->update($input);
            return response()->json(['success'=>'Attendance Successfully.'], 201); 
        }catch(\Exception $e){
            $bug=$e->errorInfo[1];
            if($bug==1062){
                return response()->json('Data Not Found .. ', 303);  
            }else{
                return response($e->errorInfo[2],500);
            }
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
