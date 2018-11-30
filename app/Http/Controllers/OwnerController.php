<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Form;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Pos;
use App\User;

class OwnerController extends Controller
{
    public function __construct(){
    	$this->middleware('auth');
    }

    public function index(){
        
    	return $this->dasboard();
    }

    public function dasboard(){
        
    	return view('template.owner.dashboard');
    }

    public function profile(){
        $profile = User::where('id', session('userid'))->first();
        return view('template.owner.profile', compact('profile'));
    }

    public function settings(){
        $settings = User::where('id', session('userid'))->get();
        return view('template.owner.settings', compact('settings'));
    }

    public function profile_update($id, Request $request){
        $this->validate($request, [
            'nama' => 'required|string',
            'tgl_lahir' => 'date'
        ]);

        User::find($id)->update([
            'nama' => $request->nama,
            'tgl_lahir' => $request->tgl_lahir,
            'tempat_lahir' => $request->tempat_lahir,
            'no_handphone' => $request->mobile,
            'alamat' => $request->alamat
        ]);

        session(['nama' => $request->nama]);

        return redirect('owner/profile')->with('message', 'Update profil berhasil!');
    }

    public function password_update($id, Request $request){
        $this->validate($request, [
            'current_password' => 'required',
            'password' => 'required|string|min:5',
            'confirm_password' => 'required|same:password'
        ]);

        if($request->current_password != session('password')) {
           return redirect()->back()->with('error','Password sekarang salah. Silakan coba lagi!');
        }

       if($request->password == $request->current_password) {
           return redirect()->back()->with('error','Password baru sama seperti password sekarang. Silakan coba lagi dengan password yang berbeda.');
        } 

        User::find($id)->update([
                'password' => Hash::make($request->password)
        ]);

        session(['password' => $request->password]);

        return redirect('owner/profile')->with('message', 'Password berhasil diubah!');
    }

    public function change_photo(Request $request){
        $id = session('userid');
        $this->validate($request, [
            'foto' => 'required|file|max:2000'
        ]);

        $uploadedFile = $request->file('foto'); 
        $path = $uploadedFile->store('public/photo');
        $pecah = explode('/', $path);

        if($request->fotolama != '' || $request->fotolama != NULL){
            unlink(storage_path('app/public/photo/'.$request->fotolama));
        }
        
        User::find($id)->update([
            'foto' => trim($pecah[2])
        ]);

        return redirect('owner/profile')->with('message', 'Foto berhasil diganti!');
    }

    public function logout(){
    	Auth::logout();
    	return redirect('/');
    }
}
