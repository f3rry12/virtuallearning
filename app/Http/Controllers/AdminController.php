<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Admin;
use App\Guru;
use App\Siswa;

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
                Session::put('isloginadmin',TRUE);
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
        if(!Session::get('isloginadmin')){
            return redirect('loginadmin')->with('alert','Kamu harus login dulu');
        }
        else{
        $gurus = Guru::all();
        $siswas = Siswa::all();
        $name = Session::get('username');
        return view('admin/berandaadmin',['name'=>$name,'gurus'=>$gurus,'siswas'=>$siswas ]);
        }
    }

  //Menuju halaman tambah guru
  public function tambahguru(){
    if(!Session::get('isloginadmin')){
        return redirect('loginadmin')->with('alert','Kamu harus login dulu');
    }
    else{
    $name = Session::get('username');    
    return view('admin/tambahguru',['name'=>$name]);
    }
  }
//proses logika untuk menambah akun guru ke database
  public function tambahguruPost(Request $request){
    $request->validate([
        'kodeguru' => 'required|unique:guru,kode_guru|max:16',
        'namaguru' => 'required|max:255',
        'username' => 'required|unique:guru,username|max:16',
        'password' => 'required|max:16',
        'fotoprofil' => 'mimes:jpeg,bmp,png,svg,webp,jpg|max:1024',
    ]);

       $imgName =null;
       if($request->fotoprofil){
        $imgName = $request->fotoprofil->getClientOriginalName().'-'.time().'.'.$request->fotoprofil->extension();
        $request->fotoprofil->move(public_path('img/guru'),$imgName); 
       }

    // $guru = new Guru();
    // $guru->kode_guru = $request->kodeguru;
    // $guru->nama_guru = $request->namaguru;
    // $guru->username = $request->username;
    // $guru->password = $request->password;
    // $guru->foto_path = $imgName;
    // $guru->save();
        Guru::create([
            'kode_guru' => $request->kodeguru,
            'nama_guru' => $request->namaguru,
            'username' => $request->username,
            'password' => $request->password,
            'foto_path' => $imgName

        ]);
    return redirect('admin');
  }
  
  //Menuju halaman edit akun guru
    public function editguru($kodeguru){
        if(!Session::get('isloginadmin')){
            return redirect('loginadmin')->with('alert','Kamu harus login dulu');
        }
        else{
            $name = Session::get('username');
            $guru = Guru::where('kode_guru',$kodeguru)->first();
            return view('admin/profilguru',['name'=>$name, 'guru'=>$guru]);
          }
    }
  //proses logika untuk edit guru ke database
    public function editguruPut(Request $request,$kodeguru,$username){
      if ($request->kodeguru!=$kodeguru) {
        $request->validate([
          'kodeguru' => 'required|unique:guru,kode_guru|max:16'
      ]);
      }
      if ($request->username!=$username) {
        $request->validate([
          'username' => 'required|unique:guru,username|max:16'
      ]);
      }
        $request->validate([
            'kodeguru' => 'required|max:16',
            'namaguru' => 'required|max:255',
            'username' => 'required|max:16',
            'password' => 'required|max:16',
            'fotoprofil' => 'mimes:jpeg,bmp,png,svg,webp,jpg|max:1024',
        ]);
        if($request->fotoprofil){
         $imgName = $request->fotoprofil->getClientOriginalName().'-'.time().'.'.$request->fotoprofil->extension();
         $request->fotoprofil->move(public_path('img/guru'),$imgName); 
         Guru::find($kodeguru)->update(['foto_path' => $imgName]);
        }
      Guru::find($kodeguru)->update([
        'kode_guru' => $request->kodeguru,
        'nama_guru' => $request->namaguru,
        'username' => $request->username,
        'password' => $request->password,
      ]);
      return redirect('admin/profilguru/'.$request->kodeguru);
    }
//Hapus guru 
  public function hapusguru($kodeguru){
    Guru::find($kodeguru)->delete();
    return redirect('admin');
  }

    //Menuju halaman tambah siswa
  public function tambahsiswa(){
    if(!Session::get('isloginadmin')){
        return redirect('loginadmin')->with('alert','Kamu harus login dulu');
    }
    else{
    $name = Session::get('username');    
    return view('admin/tambahsiswa',['name'=>$name]);
    }
  }
//proses logika untuk menambah akun siswa ke database
  public function tambahsiswaPost(Request $request){
    $request->validate([
        'kodesiswa' => 'required|unique:siswa,NIS|max:24',
        'namasiswa' => 'required|max:255',
        'password' => 'required|max:16',
        'fotoprofil' => 'mimes:jpeg,bmp,png,svg,webp,jpg|max:1024',
    ]);

       $imgName =null;
       if($request->fotoprofil){
        $imgName = $request->fotoprofil->getClientOriginalName().'-'.time().'.'.$request->fotoprofil->extension();
        $request->fotoprofil->move(public_path('img/siswa'),$imgName); 
       }

        Siswa::create([
            'NIS' => $request->kodesiswa,
            'nama_siswa' => $request->namasiswa,
            'password' => $request->password,
            'foto_path' => $imgName

        ]);
    return redirect('admin');
  }
  
  //Menuju halaman edit akun siswa
    public function editsiswa($kodesiswa){
        if(!Session::get('isloginadmin')){
            return redirect('loginadmin')->with('alert','Kamu harus login dulu');
        }
        else{
            $name = Session::get('username');
            $siswa = Siswa::where('NIS',$kodesiswa)->first();
            return view('admin/profilsiswa',['name'=>$name, 'siswa'=>$siswa]);
          }
    }
  //proses logika untuk edit siswa ke database
    public function editsiswaPut(Request $request,$kodesiswa){
      if ($request->kodesiswa!=$kodesiswa) {
        $request->validate([
          'kodesiswa' => 'required|unique:siswa,NIS|max:24',
      ]);
      }
        $request->validate([
            'kodesiswa' => 'required|max:24',
            'namasiswa' => 'required|max:255',
            'password' => 'required|max:16',
            'fotoprofil' => 'mimes:jpeg,bmp,png,svg,webp,jpg|max:1024',
        ]);
        if($request->fotoprofil){
         $imgName = $request->fotoprofil->getClientOriginalName().'-'.time().'.'.$request->fotoprofil->extension();
         $request->fotoprofil->move(public_path('img/siswa'),$imgName); 
         Siswa::find($kodesiswa)->update(['foto_path' => $imgName]);
        }
      Siswa::find($kodesiswa)->update([
        'NIS' => $request->kodesiswa,
        'nama_siswa' => $request->namasiswa,
        'password' => $request->password,
      ]);
      return redirect('admin/profilsiswa/'.$request->kodesiswa);
    }
//Hapus siswa
  public function hapussiswa($kodesiswa){
    Siswa::find($kodesiswa)->delete();
    return redirect('admin');
  }


}
