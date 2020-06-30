<?php

namespace App\Http\Controllers\backend;

use App\Model\DashboardTheme;
use App\Model\PrimaryInfo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use MyHelper;
use Auth;

class PrimaryInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data=PrimaryInfo::where('company_id',Auth::user()->id)->first();
        if($data==''){
            return redirect()->back()->with('error','You have no company info');
        }
        return view('backend.pages.primary-info.primaryinfo',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.pages.primary-info.create');
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

        if ($request->hasFile('logo')){
            $input['image']=MyHelper::photoUpload($request->file('image'),'images/company/',120,100);

        }
        if ($request->hasFile('favicon')){
            $input['image']=MyHelper::photoUpload($request->file('image'),'images/company/',120,100);

        }

        PrimaryInfo::create($input);
            $bug=0;
        try{
            
        }catch(\Exception $e){
            $bug=$e->errorInfo[1];
        }
        if($bug==0){
            return redirect()->route('/')->with('success','Successfully Inserted');
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
        $input = $request->all();
        $data=PrimaryInfo::findOrFail($id);
        $input['company_id']=Auth::user()->id;

        if ($request->hasFile('logo')) {
            $photo=$request->file('logo');
            $path=base_path().'/images/logo';
            if (!is_dir($path)) {
                mkdir("$path",0777,true);
            }
            $img=\Image::make($photo);
            $img->resize(180, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $img->save('images/logo/logo.png');
            $input['logo']='images/logo/logo.png';
        }
        if ($request->hasFile('favicon')) {
            $photo=$request->file('favicon');
            $path=base_path().'/images/logo';
            if (!is_dir($path)) {
                mkdir("$path",0777,true);
            }
            $img=\Image::make($photo)->resize(50,50);
            $img->save('images/logo/favicon.png');
            $input['favicon']='images/logo/favicon.png';
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
}
