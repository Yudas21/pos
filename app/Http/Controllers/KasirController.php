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
use App\Customer;

class KasirController extends Controller
{
    public function __construct(){
    	$this->middleware('auth');
    }

    public function index(){
    	return $this->dasboard();
    }

    public function dasboard(){
    	return view('template.kasir.dashboard');
    }

    public function profile(){
        $profile = User::where('id', session('userid'))->first();
        return view('template.kasir.profile', compact('profile'));
    }

    public function settings(){
        $settings = User::where('id', session('userid'))->get();
        return view('template.kasir.settings', compact('settings'));
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

        return redirect('kasir/profile')->with('message', 'Update profil berhasil!');
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

        return redirect('kasir/profile')->with('message', 'Password berhasil diubah!');
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

        return redirect('kasir/profile')->with('message', 'Foto berhasil diganti!');
    }

    public function customer(){
        return view('template.kasir.customer');
    }

    public function data_customer(Request $request)
    {
        $customer = Customer::paginate(10);
        $response = [
            'pagination' => [
                'total' => $customer->total(),
                'per_page' => $customer->perPage(),
                'current_page' => $customer->currentPage(),
                'last_page' => $customer->lastPage(),
                'from' => $customer->firstItem(),
                'to' => $customer->lastItem()
            ],
            'data' => $customer
        ];

        return response()->json($response);
    }

    public function customer_search(Request $request)
    {
        $customer = Customer::where('nama_customer', 'like', '%'.$request->q.'%')->paginate(10);
        $response = [
            'pagination' => [
                'total' => $customer->total(),
                'per_page' => $customer->perPage(),
                'current_page' => $customer->currentPage(),
                'last_page' => $customer->lastPage(),
                'from' => $customer->firstItem(),
                'to' => $customer->lastItem()
            ],
            'data' => $customer
        ];

        return response()->json($response);
    }

    public function customer_store(Request $request){
        $this->validate($request, [
            'nama_customer' => 'required|string',
            'nomor_kartu' => 'required|unique:customer,nomor_kartu'
            // 'tgl_lahir_customer' => 'date'
        ]);

        $create = Customer::create([
            'nomor_kartu' => $request->nomor_kartu,
            'nama_customer' => $request->nama_customer,
            'tgl_lahir_customer' => $request->tgl_lahir_customer,
            'kontak_customer' => $request->kontak_customer
        ]);
        
        return response()->json($create);
    }

    public function customer_update($id, Request $request){
        $this->validate($request, [
            'nama_customer' => 'required|string',
            'nomor_kartu' => $request->nomor_kartu != $request->nomor_kartu_old ? 'required|unique:customer,nomor_kartu' : 'required' 
            // 'tgl_lahir_customer' => 'date' 
        ]);

        $update = Customer::findOrFail($id)->update([
            'nama_customer' => $request->nama_customer,
            'tgl_lahir_customer' => $request->tgl_lahir_customer,
            'kontak_customer' => $request->kontak_customer
        ]);

        return response()->json($update);
    }

    public function customer_destroy($id){
        $delete = Customer::findOrFail($id)->delete();
        return response()->json($delete);
    }

    public function logout(){
    	Auth::logout();
    	return redirect('/');
    }
}
