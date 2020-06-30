<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Model\Employee;
use Illuminate\Support\Facades\Auth;
use Validator;
use DB;

class AuthController extends Controller
{
    public $successStatus = 200;

    public function login(Request $request){

            $employee_phone= $request->input('employee_phone');
            $employee_password = $request->input('employee_password');

            $data = Employee::where('employee_phone', $employee_phone)->where('employee_password', $employee_password)->first();

            if(!empty($data)){
                return response()->json(['success'=>'Login Successful' , 'employee_id'=>$data->id,'company_id'=>$data->company_id,'token' =>$data->_token], 200);
            }else{
                return response()->json(['error'=>'Mobile Number or Password Not Match..?'], 401);
            }

            
        }






    }

