<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Admin;
use App\Guru;

class AdminController extends Controller
{
    /* Autentikasi */
//Menuju halaman login
  public function login(){
    return view('admin/loginadmin');
}

//Contoller logika untuk login
public function loginPost(Request $request){
    $username = $request->username;
    $password = $request->password;
    $data = Admin::where('username',$username)->first();
      //  if($data->count() > 0){
      try { //try
      if($data->count() > 0){ //apakah username tersebut ada atau tidak
          if($password==$data->password){
            Session::put('username',$data->username);
            Session::put('loginadmin',TRUE);
            return redirect('admin');
          }
          else{
              return redirect('loginadmin')->with('alert','Username atau password tidak sesuai');
          }
      }
      else{
          return redirect('loginadmin')->with('alert','Username atau password tidak sesuai');
      }
    } catch (\Throwable $ex) { //catch
return redirect('loginadmin')->with('alert','Username atau password tidak sesuai'); //catch
} //catch
}

//Contoller logika untuk logout
public function logout(){
    Session::flush();
    return redirect(url('/'));
}


//Menuju beranda admin
public function index(){
    if(!Session::get('loginadmin')){
        return redirect('loginadmin')->with('alert','Kamu harus login dulu');
    }
    else{
      $gurus = Guru::all();
      $name = Session::get('username');
      return view('admin/berandaadmin',['gurus'=>$gurus,'name'=>$name ]);
    }
}
}
