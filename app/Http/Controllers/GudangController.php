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
use App\Supplier;

class GudangController extends Controller
{
    public function __construct(){
    	$this->middleware('auth');
    }

    public function index(){
    	return $this->dasboard();
    }

    public function dasboard(){
    	return view('template.gudang.dashboard');
    }

    public function profile(){
        $profile = User::where('id', session('userid'))->first();
        return view('template.gudang.profile', compact('profile'));
    }

    public function settings(){
        $settings = User::where('id', session('userid'))->get();
        return view('template.gudang.settings', compact('settings'));
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

        return redirect('gudang/profile')->with('message', 'Update profil berhasil!');
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

        return redirect('gudang/profile')->with('message', 'Password berhasil diubah!');
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

        return redirect('gudang/profile')->with('message', 'Foto berhasil diganti!');
    }

    public function supplier(){
        return view('template.gudang.supplier');
    }

    public function data_supplier(Request $request)
    {
        $supplier = Supplier::paginate(10);
        $response = [
            'pagination' => [
                'total' => $supplier->total(),
                'per_page' => $supplier->perPage(),
                'current_page' => $supplier->currentPage(),
                'last_page' => $supplier->lastPage(),
                'from' => $supplier->firstItem(),
                'to' => $supplier->lastItem()
            ],
            'data' => $supplier
        ];

        return response()->json($response);
    }

    public function supplier_search(Request $request)
    {
        $supplier = Supplier::where('nama_supplier', 'like', '%'.$request->q.'%')->paginate(10);
        $response = [
            'pagination' => [
                'total' => $supplier->total(),
                'per_page' => $supplier->perPage(),
                'current_page' => $supplier->currentPage(),
                'last_page' => $supplier->lastPage(),
                'from' => $supplier->firstItem(),
                'to' => $supplier->lastItem()
            ],
            'data' => $supplier
        ];

        return response()->json($response);
    }

    public function supplier_store(Request $request){
        $this->validate($request, [
            'nama_supplier' => 'required|string|unique:supplier'
        ]);

        $create = Supplier::create([
            'nama_supplier' => $request->nama_supplier,
            'alamat_supplier' => $request->alamat_supplier,
            'kontak_supplier' => $request->kontak_supplier
        ]);
        
        return response()->json($create);
    }

    public function supplier_update($id, Request $request){
        $this->validate($request, [
            'nama_supplier' => $request->nama_supplier == $request->nama_supplier_old ? 'required|string' : 'required|string|unique:supplier,nama_supplier' 
        ]);

        $update = Supplier::findOrFail($id)->update([
            'nama_supplier' => $request->nama_supplier,
            'alamat_supplier' => $request->alamat_supplier,
            'kontak_supplier' => $request->kontak_supplier
        ]);

        return response()->json($update);
    }

    public function supplier_destroy($id){
        $delete = Supplier::findOrFail($id)->delete();
        return response()->json($delete);
    }

    public function logout(){
    	Auth::logout();
    	return redirect('/');
    }
}
