<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class SidebarsubMenu extends Model
{
    protected $table='sidebarsub_menus';
    protected $fillable=['name','slug','submenu_ban_name','url','icon','serial_num','sidebar_menu_id','status'];
}
