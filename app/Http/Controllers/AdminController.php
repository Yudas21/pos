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
use App\Level;
use App\Menu;
use App\Supplier;
use App\Customer;

class AdminController extends Controller
{
    public function __construct(){
    	$this->middleware('auth');
    }

    public function index(){
    	return $this->dasboard();
    }

    public function dasboard(){
    	return view('template.admin.dashboard');
    }

    public function profile(){
        $profile = User::where('id', session('userid'))->first();
        return view('template.admin.profile', compact('profile'));
    }

    public function settings(){
        $settings = User::where('id', session('userid'))->get();
        return view('template.admin.settings', compact('settings'));
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

        return redirect('admin/profile')->with('message', 'Update profil berhasil!');
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

        return redirect('admin/profile')->with('message', 'Password berhasil diubah!');
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

        return redirect('admin/profile')->with('message', 'Foto berhasil diganti!');
    }

    public function menu(){
        return view('template.admin.menu');
    }

    public function data_menu(Request $request)
    {
        $menu = Menu::with('menu_parent')->paginate(10);
        $response = [
            'pagination' => [
                'total' => $menu->total(),
                'per_page' => $menu->perPage(),
                'current_page' => $menu->currentPage(),
                'last_page' => $menu->lastPage(),
                'from' => $menu->firstItem(),
                'to' => $menu->lastItem()
            ],
            'data' => $menu
        ];

        return response()->json($response);
    }

    public function menu_parent()
    {
        $menu = Menu::select('id as value', 'nama_menu as text')->get();
        $response = [
            'data' => $menu
        ];

        return response()->json($response);
    }

    public function menu_search(Request $request)
    {
        $menu = Menu::with('menu_parent')->where('nama_menu', 'like', '%'.$request->q.'%')->paginate(10);
        $response = [
            'pagination' => [
                'total' => $menu->total(),
                'per_page' => $menu->perPage(),
                'current_page' => $menu->currentPage(),
                'last_page' => $menu->lastPage(),
                'from' => $menu->firstItem(),
                'to' => $menu->lastItem()
            ],
            'data' => $menu
        ];

        return response()->json($response);
    }

    public function menu_store(Request $request){
        $this->validate($request, [
            'nama_menu' => 'required|string'
        ]);

        $create = Menu::create([
            'nama_menu' => $request->nama_menu,
            'url_menu' => $request->url_menu,
            'parent_menu' => $request->parent['value']
        ]);
        
        return response()->json($create);
    }

    public function menu_update($id, Request $request){
        $this->validate($request, [
            'nama_menu' => 'required|string'
        ]);

        $update = Menu::findOrFail($id)->update([
            'nama_menu' => $request->nama_menu,
            'url_menu' => $request->url_menu,
            'parent_menu' => $request->parent['value']
        ]);

        return response()->json($update);
    }

    public function menu_destroy($id){
        $delete = Menu::findOrFail($id)->delete();
        return response()->json($delete);
    }

    public function level(){
        return view('template.admin.level');
    }

    public function data_level(Request $request)
    {
        $level = Level::orderBy('id')->paginate(10);
        $response = [
            'pagination' => [
                'total' => $level->total(),
                'per_page' => $level->perPage(),
                'current_page' => $level->currentPage(),
                'last_page' => $level->lastPage(),
                'from' => $level->firstItem(),
                'to' => $level->lastItem()
            ],
            'data' => $level
        ];

        return response()->json($response);
    }

    public function level_search(Request $request)
    {
        $level = Level::orderBy('id')->where('nama_level', 'like', $request->q.'%')->paginate(10);
        $response = [
            'pagination' => [
                'total' => $level->total(),
                'per_page' => $level->perPage(),
                'current_page' => $level->currentPage(),
                'last_page' => $level->lastPage(),
                'from' => $level->firstItem(),
                'to' => $level->lastItem()
            ],
            'data' => $level
        ];

        return response()->json($response);
    }

    public function level_store(Request $request){
        $this->validate($request, [
            'nama_level' => 'required|unique:level,nama_level'
        ]);

        $create = Level::insert([
                  'nama_level' => $request->nama_level
                ]);
        
        return response()->json($create);
    }

    public function level_update($id, Request $request){
        
        $this->validate($request, [
            'nama_level' => $request->nama_level == $request->nama_level_old ? 'required' : 'required|unique:level,nama_level' 
        ]);

        $update = Level::find($id)->update([
            'nama_level' => $request->nama_level
        ]);

        return response()->json($update);
    }

    public function level_destroy($id){
        $delete = Level::find($id)->delete();
        return response()->json($delete);
    }

    public function level_access($id){
        $access = DB::table('akses')->where('id_level', $id)->get();
        return view('template.admin.level_access', compact('access','id'));
    }

    public function level_access_update($id, Request $request){
      
      $id_level = $request->id_level;
      $id_menu = $request->id_menu != '' ? $request->id_menu : array();
      $insert = array();
      $daftar_menu = array();
      $menus = DB::table('akses')->select('id_menu')->where('id_level', $id_level)->get();
      $isi_menu = array();
      foreach ($menus as $value) {
         $isi_menu[] = $value->id_menu;
      }

      for($s=0;$s<count($id_menu);$s++){
        $hitung = DB::table('akses')->where(['id_menu' => $id_menu[$s], 'id_level' => $id_level])->count();
        if($hitung > 0){
             //     
        } else {
            $data = array(
                      'id_menu' => $id_menu[$s],
                      'id_level' => $id_level
            );
            $insert[] = $data;
        }
      }

      if(count($insert) > 0){
        DB::table('akses')->insert($insert);
      }
      // } else {
      // //   Akses::where('id_level', $id_level)->delete();
      // // }

      for($s=0;$s<count($id_menu);$s++){
         if (($key = array_search($id_menu[$s], $isi_menu)) !== FALSE) {
              unset($isi_menu[$key]);
         }
      }

      array_unique($isi_menu);
      $isi_menu_delete = array();
      foreach ($isi_menu as $key => $value) {
          $isi_menu_delete[] = $value;
      }

      // echo '<pre>';
      // print_r($isi_menu_delete);
      // echo '</pre>';
      // exit();
      if(count($isi_menu_delete) > 0){
        for($s=0;$s<count($isi_menu_delete);$s++){ 
            DB::table('akses')->where('id_level', $id_level)->where('id_menu', $isi_menu_delete[$s])->delete();
        }
      }

      // echo '<pre>';
      // print_r($isi_menu);
      // echo '</pre>';
      // exit(); 
      return redirect('admin/access_level/'.$id)->with('message', 'Akses berhasil diubah!');
        
    }

    public function users(){
        return view('template.admin.users');
    }

    public function data_users(Request $request)
    {
        $users = DB::table('users as a')->select('a.id','a.username','a.nama','a.tempat_lahir','a.tgl_lahir','a.alamat','a.no_handphone','a.id_level','a.active', 'b.nama_level')->leftJoin('level as b','b.id','=','a.id_level')->where('a.deleted_at','=', NULL)->paginate(10);

        $response = [
            'pagination' => [
                'total' => $users->total(),
                'per_page' => $users->perPage(),
                'current_page' => $users->currentPage(),
                'last_page' => $users->lastPage(),
                'from' => $users->firstItem(),
                'to' => $users->lastItem()
            ],
            'data' => $users
        ];

        return response()->json($response);
    }

    public function users_search(Request $request)
    {
        $users = DB::table('users as a')->select('a.id','a.username','a.nama','a.tempat_lahir','a.tgl_lahir','a.alamat','a.no_handphone','a.id_level','a.active', 'b.nama_level')->leftJoin('level as b','b.id','=','a.id_level')->where('a.deleted_at','=', NULL)->where('a.nama', 'like', $request->q.'%')->paginate(10);

        $response = [
            'pagination' => [
                'total' => $users->total(),
                'per_page' => $users->perPage(),
                'current_page' => $users->currentPage(),
                'last_page' => $users->lastPage(),
                'from' => $users->firstItem(),
                'to' => $users->lastItem()
            ],
            'data' => $users
        ];

        return response()->json($response);
    }

    public function users_store(Request $request){
        $this->validate($request, [
            'nama' => 'required',
            'username' => 'required|unique:users,username',
            'password' => 'required|string|min:5',
            'password_confirm' => 'required|string|same:password|min:5',
            'id_level' => 'required'
        ]);

        $create = User::create([
            'username' => $request->username,
            'nama' => $request->nama,
            'tgl_lahir' => $request->tgl_lahir,
            'tempat_lahir' => $request->tempat_lahir,
            'alamat' => $request->alamat,
            'no_handphone' => $request->no_handphone,
            'password' => Hash::make($request->password),
            'id_level' => $request->id_level,
            'active' => '1'
        ]);
        return response()->json($create);
    }

    public function users_update($id, Request $request){
        $this->validate($request, [
            'nama' => 'required',
            'username' => $request->username == $request->username_old ? 'required' : 'required|unique:users,username',
            'id_level' => 'required',
            'active' => 'required'
        ]);

      $edit = User::find($id)->update([
            'username' => $request->username,
            'nama' => $request->nama,
            'tgl_lahir' => $request->tgl_lahir,
            'tempat_lahir' => $request->tempat_lahir,
            'alamat' => $request->alamat,
            'no_handphone' => $request->no_handphone,
            'id_level' => $request->id_level['value'],
            'active' => $request->active['value']
        ]);

        return response()->json($edit);
    }

    public function users_update_password($id, Request $request){
        
        $this->validate($request, [
            'password' => 'required|string|min:5',
            'password_confirm' => 'required|string|same:password|min:5'
        ]);

        $edit = User::find($id)->update([
            'password' => Hash::make($request->password)
        ]);

        return response()->json($edit);
    }

    public function users_delete($id){
        $delete = User::find($id)->delete();
        return response()->json($delete);
    }

    public function data_users_level(Request $request)
    {
        $level = Level::select('id as value', 'nama_level as text')->get();
        $response = [
                'data' => $level
        ];

        return response()->json($response);
     
    }

    public function supplier(){
        return view('template.admin.supplier');
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

    public function customer(){
        return view('template.admin.customer');
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
