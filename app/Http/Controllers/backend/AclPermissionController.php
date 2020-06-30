<?php

namespace App\Http\Controllers\backend;

use App\Model\DashboardTheme;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Acl\Models\Permission;
use Validator;
use DB;
use Artisan;

class AclPermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $permissions=Permission::orderby('id','desc')->get();
        return view('backend.pages.acl-permission.permission',compact('permissions'));
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
        $validator = Validator::make($request->all(),[
            'name' => 'required|unique:permissions,name'

        ]);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }
        try {
            if($request->type==0){
                Permission::createResource($request->name,1);
            }else{
                Permission::create([
                    'name'=>$request->name,
                    'slug'=>\MyHelper::slugify($request->name),
                    'resource'=>'',
                    'system'=>1,

                ]);
            }


            $bug = 0;

        } catch (\Exception $e) {
            $bug = $e->errorInfo[1];
            $bug1 = $e->errorInfo[2];
        }

        if($bug == 0){
            return redirect()->back()->with('success','Created Successfully.');
        }else{
            return redirect()->back()->with('error','Something Error Found !, Please try again.'.$bug1);
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
        $normalPermission = Permission::where(['system'=>1,'resource'=>''])->get();
        $permissionRole=\DB::table('permission_role')->where('role_id',$id)->get()->keyBy('permission_id');
        $role=\DB::table('roles')->where('id',$id)->first();

        return view('backend.pages.acl-permission.show',compact('permissionRole','role','normalPermission'));
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
        $data = Permission::findOrFail($id);

        try {
            $data->delete();

            $bug = 0;

        } catch (\Exception $e) {
            $bug = $e->errorInfo[1];
            $bug1 = $e->errorInfo[2];
        }

        if($bug == 0){
            return redirect()->back()->with('success','Deleted Successfully.');
        }else{
            return redirect()->back()->with('error','Something Error Found !, Please try again.'.$bug1);
        }
    }


    public function storeRole(Request $request)
    {
        $input=$request->except('_token');
        $validator = Validator::make($request->all(),[
            'role_id' => 'required',
            'permission_id' => 'required',

        ]);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }
        DB::beginTransaction();
        DB::table('permission_role')->where('role_id',$input['role_id'])->delete();
        for ($i=0; $i <sizeof($input['permission_id']) ; $i++) {
            $permissionId=$input['permission_id'][$i];
            \DB::table('permission_role')->insert([
                'role_id'=>$input['role_id'],
                'permission_id'=>$permissionId
            ]);
        }
        Artisan::call('cache:clear');
        DB::commit();
        $bug = 0;
        try {


        } catch (\Exception $e) {
            DB::rollback();
            $bug = $e->errorInfo[1];
            $bug1 = $e->errorInfo[2];
        }

        if($bug == 0){
            return redirect()->back()->with('success','Created Successfully.');
        }else{
            return redirect()->back()->with('error','Something Error Found !, Please try again.');
        }
    }


}
