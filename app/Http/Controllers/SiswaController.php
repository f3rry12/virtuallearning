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
use App\AnggotaKelas;

class SiswaController extends Controller
{
    
        //Menuju beranda siswa
        public function index(){
            if(!Session::get('isloginsiswa')){
                return $this->redirectsiswa();
            }
            else{
            $name = Session::get('name');
            $NIS = Session::get('NIS');
            $members = DB::table('anggotakelas')
                            ->where('NISsiswa',$NIS)
                            ->leftJoin('kelas', 'anggotakelas.kelaskode', '=', 'kelas.kode_kelas')
                            ->get();             
            return view('siswa/berandasiswa',['name'=>$name ,'NIS'=>$NIS,'members'=>$members]);
            }
        }

        public function redirectsiswa(){
            if(Session::get('isloginguru')){
                return redirect('guru');
            }
            else {
                return redirect('login')->with('alert','Kamu harus login dulu');
            }
        }

        public function confirmkelas(Request $request,$NIS){
            $request->validate([
                'kelaskode' => 'required|exists:kelas,kode_kelas|max:6'
            ]);
            $name = Session::get('name');
            $NIS = Session::get('NIS');
            $kelas = Kelas::where('kode_kelas',$request->kelaskode)->first();
            $guru = Guru::where('kode_guru',$kelas->pengajar)->value('nama_guru');
            return view('siswa/confirmkelas',['name'=>$name ,'NIS'=>$NIS,'kelas'=>$kelas,'namaguru'=>$guru]);
        }

        public function masukkelasPost($NIS,$kelaskode){
            AnggotaKelas::create([
                'kelaskode' => $request->kelaskode,
                'NISsiswa' => $NIS
            ]);
            $kelas = Kelas::where('kode_kelas',$request->kelaskode)->first();

            $name = Session::get('name');
            $NIS = Session::get('NIS');            
            return view('siswa/kelassiswa',['name'=>$name ,'NIS'=>$NIS,'kelas'=>$kelas]);
        }

        public function indexkelas($kodekelas){
            if(!Session::get('isloginsiswa')){
                return $this->redirectsiswa();
            }
            else{
            $kelas = Kelas::where('kode_kelas',$kodekelas)->first();

            $name = Session::get('name');
            $NIS = Session::get('NIS');            
            return view('siswa/kelassiswa',['name'=>$name ,'NIS'=>$NIS,'kelas'=>$kelas]);
            }
        }
}
