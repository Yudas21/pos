<?php
namespace App\Helpers;
 
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
 
class Pos {
    
    public static function get_account($username) {
        $data = DB::table('users')->where('username', $username)->first();
        return $data;
    }

    public static function data_user_photo($id) {
        $name = '';
        $levels = DB::table('users')->select('foto')->where('id', $id)->get();
        if(DB::table('users')->where('id', $id)->count() > 0){
            foreach ($levels as $value) {
                $name = $value->foto;
            }
        }
        return $name;
    }

    public static function check_account($username) {
        $data = DB::table('users')->where('username', $username)->count();
        return $data;
    }

    public static function count_active_account() {
        $data = DB::table('users')->where('active', 1)->count();
        return $data;
    }

    public static function count_nactive_account() {
        $data = DB::table('users')->where('active', 0)->count();
        return $data;
    }

    public static function count_account() {
        $data = DB::table('users')->count();
        return $data;
    }

    // public static function count_kadaluarsa() {
    //     $data = DB::table('barang')->where('')->count();
    //     return $data;
    // }

    public static function count_customer() {
        $data = DB::table('customer')->count();
        return $data;
    }

    public static function count_supplier() {
        $data = DB::table('supplier')->count();
        return $data;
    }

    public static function count_barang() {
        $data = DB::table('kategori_barang')->count();
        return $data;
    }

    public static function get_parent() {
        $menus = DB::table('menu')->where('parent_menu', 0)->get();
        return $menus;
    }

    public static function get_my_menu($id_level)
    {
        $data_menu = array();
        $menus = DB::table('akses')->select('id_menu')
                ->where('id_level', $id_level)
                ->get();
        foreach ($menus as $key) {
            if($key->id_menu){
                array_push($data_menu, $key->id_menu);
            }
        }
        return $data_menu;
    }

    public static function get_count_child($id) {
        $menus = DB::table('menu')->where('parent_menu', $id)
                ->count();
        return $menus;
    }

    public static function get_child($id) {
        $menus = DB::table('menu')->where('parent_menu', $id)
                ->get();
        return $menus;
    }

    public static function get_level_name($id) {
        $name = '';
        $levels = DB::table('level')->select('nama_level')->where('id', $id)->get();
        if(DB::table('level')->where('id', $id)->count() > 0){
            foreach ($levels as $value) {
                $name = $value->nama_level;
            }
        }
        return $name;
    }

    public static function generate_no_katu(){
        $today = 'C'.date('Ym');
        $data = DB::table('customer')->where('nomor_kartu', 'like', $today.'%')->orderBy('nomor_kartu', 'desc')->count()+1;
        if($data <= 1){
            $no_kartu = $today.'1';
        } else {
            $no_kartu = $today.$data;
        }
        return $no_kartu;
    }

}