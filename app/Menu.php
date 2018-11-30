<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Menu extends Model
{
    use SoftDeletes;
    protected $table = 'menu';
    protected $fillable = [
        'nama_menu', 'ikon_menu', 'url_menu', 'parent_menu'
    ];
    protected $dates = ['deleted_at'];

    public function menu_parent(){
        return $this->hasOne('App\Menu', 'id', 'parent_menu');
    }
}
