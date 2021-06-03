<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use App\Guru;
use App\Siswa;
use App\Kelas;

class GuruController extends Controller
{
    
        //Menuju beranda guru
        public function index(){
            if(!Session::get('isloginguru')){
                return $this->redirectguru();
            }
            else{
            $name = Session::get('name');
            $kodeguru = Session::get('kodeguru');
            $kelass = Kelas::where('pengajar',$kodeguru)->get();    
            return view('guru/berandaguru',['name'=>$name ,'kodeguru'=>$kodeguru,'kelass'=>$kelass]);
            }
        }

        public function redirectguru(){
            if(Session::get('isloginsiswa')){
                return redirect('siswa');
            }
            else {
                return redirect('login')->with('alert','Kamu harus login dulu');
            }
        }

        public function buatkelasPost(Request $request,$kodeguru){
            $random_string = Str::random(6);

            Kelas::create([
                'kode_kelas' => $random_string,
                'nama_kelas' => $request->namakelas,
                'pengajar' => $kodeguru    
            ]);

            $name = Session::get('name');
            $kodeguru = Session::get('kodeguru');            
            return view('guru/tambahkelas',['name'=>$name ,'kodeguru'=>$kodeguru,'kodekelas'=>$random_string,'namakelas' => $request->namakelas]);
        }
        public function indexkelas($kodekelas){
            if(!Session::get('isloginguru')){
                return $this->redirectguru();
            }
            else{
            $kelas = Kelas::where('kode_kelas',$kodekelas)->first();

            $name = Session::get('name');
            $kodeguru = Session::get('kodeguru');           
            return view('guru/kelasguru',['name'=>$name ,'kodeguru'=>$kodeguru,'kelas'=>$kelas]);
            }
        }
}
