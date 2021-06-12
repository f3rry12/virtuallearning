<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Guru;
use App\Siswa;


class HomeController extends Controller
{

    public function index() {
        if(Session::get('isloginguru')){
            return redirect('guru');
        }elseif(Session::get('isloginsiswa')){
            return redirect('siswa');
        }
        else {
            return view('login');
        }
    }

    public function loginPost(Request $request){
        $role = $request->role;
        $username = $request->username;
        $password = $request->password;
        if ($role=='Guru'){
            return $this->loginguruPost($password,$username);
        } elseif($role=='Siswa'){
            return $this->loginsiswaPost($password,$username);
        } else {
            return redirect('login')->with('alert','Username atau password tidak sesuai');
        }
        
    }

    public function loginguruPost($password,$username){
        $data = Guru::where('username',$username)->first();
        try { //try
        if($data->count() > 0){ //apakah username tersebut ada atau tidak
            if($password==$data->password){
                Session::put('name',$data->nama_guru);
                Session::put('kodeguru',$data->kode_guru);
                Session::put('isloginguru',TRUE);
                return redirect('guru');
            }
            else{
                return redirect('login')->with('alert','Username atau password tidak sesuai');
            }
        }
        else{
            return redirect('login')->with('alert','Username atau password tidak sesuai');
        }
        } catch (\Throwable $ex) { //catch
    return redirect('login')->with('alert','Username atau password tidak sesuai'); //catch
        } //catch
    }

    public function loginsiswaPost($password,$username){
        $data = Siswa::where('NIS',$username)->first();
        try { //try
        if($data->count() > 0){ //apakah username tersebut ada atau tidak
            if($password==$data->password){
                Session::put('name',$data->nama_siswa);
                Session::put('NIS',$username);
                Session::put('isloginsiswa',TRUE);
                return redirect('siswa');
            }
            else{
                return redirect('login')->with('alert','Username atau password tidak sesuai');
            }
        }
        else{
            return redirect('login')->with('alert','Username atau password tidak sesuai');
        }
        } catch (\Throwable $ex) { //catch
    return redirect('login')->with('alert','Username atau password tidak sesuai'); //catch
        } //catch
    }
    
        //Contoller logika untuk logout
        public function logout(){
            Session::flush();
            return redirect(url('/'));
        }

        //untuk zoom foto
        public function zoomfoto($loc, $foto){
            return view('foto',['loc'=>$loc ,'foto'=>$foto]);
        }

        //untuk download file
        public function download($loc, $path){
            $file = public_path('/file/'.$loc.'/'.$path);
            return Storage::disk('public')->download($file,$path);
           // return Storage::download('file/'.$loc.'/'.$path);
        }
}
