<?php

namespace App\Http\Controllers\backend;

use App\Model\DashboardTheme;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Yajra\Acl\Models\Role;
use Validator;
use MyHelper;
use DB;
use Auth;
use Session;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users=User::orderby('id','desc')->where('status',1)->get();
        $roles=Role::where('system',1)->pluck('name','id');
        return view('backend.pages.user.user',compact('users','roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles=Role::where('system',1)->pluck('name','id');
        return view('backend.pages.user.create',compact('roles'));
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
        $input['password']=bcrypt($input['password']);
        $input['slug']=str_slug($request->name);
        $input['created_by']=Auth::user()->id;

        if ($request->hasFile('image')){
            $input['image']=MyHelper::photoUpload($request->file('image'),'images/users/',120,100);

        }

        $insertId= User::create($input)->id;
        $oldRole=DB::table('role_user')->where('user_id',$insertId)->first();
        if($oldRole!=null){
            DB::table('role_user')->where('user_id',$insertId)->update(['role_id'=>$request->role_id]);
        }else{
            DB::table('role_user')->insert(['role_id'=>$request->role_id,'user_id'=>$insertId]);
        }


        DB::commit();
        $bug=0;

        try{

        }catch(\Exception $e){
            DB::rollback();
            $bug=$e->errorInfo[1];
        }
        if($bug==0){
            Session::put('user_id',$insertId);
            return redirect()->route('primary-info.create')->with($insertId);
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
        $user=User::findorfail($id);
        $roles=Role::where('system',1)->pluck('name','id');
        return view('backend.pages.user.edit',compact('user','roles'));

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
        $input=User::findOrFail($id);

        DB::beginTransaction();
        try {

            $input->delete();

            if (file_exists($input->image)){
                unlink($input->image);
            }


            $bug = 0;
            DB::commit();

        } catch (\Exception $e) {
            $bug = $e->errorInfo[1];
            $bug1 = $e->errorInfo[2];
        }

        if ($bug == 0) {
            return redirect()->back()->with('success', ' Data Deleted Successfully.');
        }elseif ($bug==547){
            return redirect()->back()->with('error', 'Sorry this users can not be delete due to used another module');
        }
        else {
            return redirect()->back()->with('error', 'Something Error Found! ');
        }
    }

    public function secretLogin($id)
    {
        $data = User::findOrFail($id);
        Auth::logout();
        Auth::login($data);
        return redirect('/');
    }
}
