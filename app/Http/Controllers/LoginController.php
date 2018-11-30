<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Pos;

class LoginController extends Controller
{
      public function index(){
        return view('template.login');
      }
  
      public function checkLogin(Request $request){
        $this->validate($request, [
             'username' => 'required',
             'password' => 'required'
        ]);
  
        $credentials = $this->getCredentials($request);

        if(Auth::attempt($credentials)){
            $data_users = Pos::get_account($request->username);
            $data = array(
                'userid' => $data_users->id,
                'nama' => $data_users->nama,
                'username' => $request->username,
                'password' => $request->password,
                'id_level' => $data_users->id_level 
              );
            session($data);
            if($data_users->active == 1){
                $akses = strtolower(Pos::get_level_name(session('id_level')));
                if($akses == 'admin'){
                  return redirect('admin/dashboard');
                }
                if($akses == 'owner'){
                  return redirect('owner/dashboard');
                }
                if($akses == 'kasir'){
                  return redirect('kasir/dashboard');
                }
                if($akses == 'gudang'){
                  return redirect('gudang/dashboard');
                }
                
            } else {
                return redirect('')->with('message','Akun anda tidak aktif, silakan hubungi admin!');
            }
        } else {
           return redirect('')->with('message','Username atau Password salah!');
        }
      }
  
      public function forgotPassword(){
        return view('template.forgot');
      }
  
      public function pForgotPassword(Request $request){
        $this->validate($request, [
              'username' => 'required'
          ]);
        if(Pos::check_account($request->username) == 0){
          return redirect('login/forgotpassword')->with('message', 'Data anda belum ada, silakan untuk menghubungi Administrator!');
        } else {
        //   Notifikasi::insert([
        //             'to' => 9999,
        //             'notif' => 'User dengan Username : <strong>'.$request->username.'</strong> lupa password, silakan untuk mereset password user tersebut',
        //             'read' => '0',
        //             'created_at' => new DateTime(),
        //             'updated_at' => new DateTime()
        //           ]);
          return redirect('login/forgotpassword')->with('message', 'Data sedang diproses, Administrator akan segera menghubungi anda!');
        }
        
      }
  
      protected function getCredentials(Request $request)
      {
        return $request->only('username', 'password');
      }
}
