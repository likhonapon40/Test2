<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class SidebarMenu extends Model
{
    protected $table='sidebar_menus';
    protected $fillable=['name','slug','menu_bangla_name','url','icon','serial_num','status'];

    public function sidebarSubmenu(){
        return $this->hasMany(SidebarsubMenu::class , 'sidebar_menu_id','id');
    }
}
