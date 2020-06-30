<?php

namespace App\Http\Controllers\backend;

use App\Model\DashboardTheme;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Acl\Models\Permission;
use App\Model\SidebarsubMenu;
use App\Model\SidebarMenu;
use Validator;

class SidebarsubMenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

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
        $input = $request->all();
        $validator = Validator::make($input, [
            'name'          => 'required',
            /*'url'    => 'required',*/
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $input['slug']=json_encode($request->slug);
        /*$input['slug']=str_slug($request->name);*/
        try{
            SidebarsubMenu::create($input);
            $bug=0;
        }catch(\Exception $e){
            $bug=$e->errorInfo[1];
        }
        if($bug==0){
            return redirect()->back()->with('success','Successfully Inserted');
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
        $alldata=SidebarsubMenu::leftJoin('sidebar_menus','sidebarsub_menus.sidebar_menu_id','=','sidebar_menus.id')
            ->select('sidebarsub_menus.*','sidebar_menus.name as sidebar_menus_name')->where('sidebar_menu_id',$id)
            ->orderby('serial_num','ASC')->paginate(15);
        $menu=SidebarMenu::findOrFail($id);
        $permissions=Permission::where('system',1)->pluck('name','slug');
        $max_serial=SidebarsubMenu::where('sidebar_menu_id',$id)->max('serial_num');
        return view('backend.pages.sidebarmenu.sidebarsubmenu.submenu',compact('alldata','menu',
            'permissions','max_serial'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data=SidebarsubMenu::findOrFail($id);
        $max_serial=SidebarsubMenu::where('sidebar_menu_id',$id)->max('serial_num');
        $permissions=Permission::where('system',1)->pluck('name','slug');
        return view('backend.pages.sidebarmenu.sidebarsubmenu.edit',compact('data','max_serial','permissions'));
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
        $data=SidebarsubMenu::findOrFail($id);

        $validator = Validator::make($input, [
            'name'    => 'required',
            'url'          => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $input['slug']=json_encode($request->slug);
        /*$input['slug']=str_slug($request->name);*/
        try{
            $data->update($input);

            $bug=0;
        }catch(\Exception $e){
            $bug=$e->errorInfo[1];
        }
        if($bug==0){
            return redirect()->back()->with('success','Successfully Inserted');
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
        $data=SidebarsubMenu::findOrFail($id);
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
