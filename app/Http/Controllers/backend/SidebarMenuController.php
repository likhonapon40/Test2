<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\SidebarMenu;
use Yajra\Acl\Models\Permission;
use Validator;

class SidebarMenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sidebarmenu=SidebarMenu::orderby('serial_num','asc')->get();
        return view('backend.pages.sidebarmenu.menu',compact('sidebarmenu'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $max_serial=SidebarMenu::max('serial_num');
        $permissions=Permission::where('system',1)->pluck('name','slug');
        return view('backend.pages.sidebarmenu.create',compact('max_serial','permissions'));
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

        $validator = Validator::make($input, [
            'name'          => 'required',
            'url'    => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        /*$input['slug']=str_slug($request->permission);*/
        $input['slug']=json_encode($request->slug);
        
        try{
            SidebarMenu::create($input);
            $bug=0;
        }catch(\Exception $e){
            $bug=$e->errorInfo[1];
        }
        if($bug==0){
            return redirect()->back()->with('success','Successfully Create!');
        }elseif($bug==1451){
            return redirect()->back()->with('error','This Data is Used anywhere ! ');

        }
        elseif($bug>0){
            return redirect()->back()->with('error','Something Error Found !');

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
        $data=SidebarMenu::findorfail($id);
        $max_serial=SidebarMenu::max('serial_num');
        $permissions=Permission::where('system',1)->pluck('name','slug');
        return view('backend.pages.sidebarmenu.edit',compact('data','max_serial','permissions'));
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
        $data=SidebarMenu::findOrFail($id);
        $validator = Validator::make($input, [
            'name'    => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $input['slug']=json_encode($request->slug);
        try{
            $data->update($input);
            $bug=0;
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
        $data=SidebarMenu::findOrFail($id);
        try{
            $data->delete();
            $bug=0;
            $error=0;
        }catch(\Exception $e){
            $bug=$e->errorInfo[1];
            $error=$e->errorInfo[2];
        }
        if($bug==0){
            return redirect()->back()->with('success','Successfully Deleted!');
        }elseif($bug==1451){
            return redirect()->back()->with('error','This Data is Used Anywhere ! ');

        }
        elseif($bug>0){
            return redirect()->back()->with('error','Something Error Found !');

        }
    }
}
