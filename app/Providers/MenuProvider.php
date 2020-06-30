<?php

namespace App\Providers;

use App\Model\SidebarMenu;
use App\Model\SidebarsubMenu;
use Illuminate\Support\ServiceProvider;
use App\Model\PrimaryInfo;
use App\Model\SocialIcon;
use App\Model\WebsiteMenu;
use Auth;

class MenuProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer([
            'backend.pertial.sidebar',
            'backend.layout.master'
        ],function($view){
            $menus =[];
            /*$subMenu =[];*/
           /* $subMenu = SidebarsubMenu::where(['status'=>0])->get();*/
           $menus=SidebarMenu::orderby('serial_num','ASC')->where('status',1)->get();
           $info=PrimaryInfo::where('company_id', Auth::user()->id)->first();
            //$menus = SidebarMenu::where('status',1)->get();
            $view->with(['menus'=>$menus,'info'=>$info]);
        });
    }
}
