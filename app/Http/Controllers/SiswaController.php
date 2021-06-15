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
use App\Materi;
use App\Tugas; 
use App\JawabanTugas;
use App\Pengumuman;

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
            $kelass = DB::table('anggotakelas')
                            ->where('NISsiswa',$NIS)
                            ->leftJoin('kelas', 'anggotakelas.kelaskode', '=', 'kelas.kode_kelas')
                            ->leftJoin('guru', 'kelas.pengajar', '=', 'guru.kode_guru')
                            ->select('kode_kelas','nama_kelas','nama_guru')
                            ->get();             
            return view('siswa/berandasiswa',['name'=>$name ,'NIS'=>$NIS,'kelass'=>$kelass]);
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

        //Menuju halaman profil siswa
        public function profilsiswa(){
            $name = Session::get('name');
            $NIS = Session::get('NIS');  
            if(!Session::get('isloginsiswa')){
                return $this->redirectsiswa();
            }
            else{
            $siswa = Siswa::where('NIS',$NIS)->first();
    
            return view('siswa/profilsiswa',['name'=>$name ,'siswa'=>$siswa]);
            }
        }

            //proses logika untuk edit siswa ke database
        public function editsiswaPut(Request $request){
            $NIS = Session::get('NIS'); 

            $request->validate([
                'password' => 'required|max:16',
                'fotoprofil' => 'mimes:jpeg,bmp,png,svg,webp,jpg|max:1024',
            ]);
            if($request->fotoprofil){
            $imgName = $request->fotoprofil->getClientOriginalName().'-'.time().'.'.$request->fotoprofil->extension();
            $request->fotoprofil->move(public_path('img/siswa'),$imgName); 
            Siswa::find($NIS)->update(['foto_path' => $imgName]);
            }
            Siswa::find($NIS)->update([
                'password' => $request->password,
            ]);
        return redirect('siswa/profilsiswa');
        }

        public function confirmkelas(Request $request,$NIS){
            $request->validate([
                'kelaskode' => 'required|exists:kelas,kode_kelas|max:6'
            ]);
            $joined = AnggotaKelas::where('NISsiswa',$NIS)->where('kelasKode',$request->kelaskode)->count();
            if ($joined>0) {
                return $this->indexkelas($request->kelaskode);
            }else {
             
            $name = Session::get('name');
            $NIS = Session::get('NIS');
            $kelas = Kelas::where('kode_kelas',$request->kelaskode)->first();
            $guru = Guru::where('kode_guru',$kelas->pengajar)->value('nama_guru');
            return view('siswa/confirmkelas',['name'=>$name ,'NIS'=>$NIS,'kelas'=>$kelas,'namaguru'=>$guru]);
            }  
        }

        public function masukkelasPost($kodekelas){
            $NIS = Session::get('NIS');
            AnggotaKelas::create([
                'kelaskode' => $kodekelas,
                'NISsiswa' => $NIS
            ]);
            
            $kelas = Kelas::where('kode_kelas',$kodekelas)->first();
            $jumlah = AnggotaKelas::where('kelasKode',$kodekelas)->count()+1;

            $name = Session::get('name');
            $NIS = Session::get('NIS');            
            return view('siswa/kelassiswa',['name'=>$name ,'NIS'=>$NIS,'kelas'=>$kelas,'jumlah'=>$jumlah]);
        }

        public function indexkelas($kodekelas){
            if(!Session::get('isloginsiswa')){
                return $this->redirectsiswa();
            }
            else{
            $kelas = Kelas::where('kode_kelas',$kodekelas)->first();
            $jumlah = AnggotaKelas::where('kelasKode',$kodekelas)->count()+1;
            $posts = Pengumuman::where('kelas',$kodekelas)
                                ->latest('pengumuman.created_at')
                                ->leftJoin('kelas', 'kelas.kode_kelas', '=', 'pengumuman.kelas')
                                ->leftJoin('guru', 'guru.kode_guru', '=', 'kelas.pengajar')
                                ->select(DB::raw('null as judul'),'keterangan','id_pengumuman','nama_kelas','nama_guru','pengumuman.created_at', DB::raw('null as deadine'));    

            $materis = Materi::where('kelas',$kodekelas)
                                ->latest('materi.created_at')
                                ->leftJoin('kelas', 'kelas.kode_kelas', '=', 'materi.kelas')
                                ->leftJoin('guru', 'guru.kode_guru', '=', 'kelas.pengajar')
                                ->select('judul','penjelasan','id_materi','nama_kelas','nama_guru','materi.created_at', DB::raw('null as deadine'))
                                ->union($posts);

            $tugass = Tugas::where('kelas',$kodekelas)
                                ->leftJoin('kelas', 'kelas.kode_kelas', '=', 'tugas.kelas')
                                ->leftJoin('guru', 'guru.kode_guru', '=', 'kelas.pengajar')
                                ->select('judul','penjelasan','id_tugas as id','nama_kelas','nama_guru','tugas.created_at', 'deadline')
                                ->union($materis)
                                ->latest('created_at')
                                ->get(); 
                                          
               // dd($tugass);

            $name = Session::get('name');
            $NIS = Session::get('NIS');            
            return view('siswa/kelassiswa',['name'=>$name ,'NIS'=>$NIS,'kelas'=>$kelas,'jumlah'=>$jumlah, 'agendas'=>$tugass]);
            }
        }

        public function indexMember($kodekelas){
            if(!Session::get('isloginsiswa')){
                return $this->redirectsiswa();
            }
            else{
            $kelas = Kelas::where('kode_kelas',$kodekelas)->first();
            $members = DB::table('anggotakelas')
                            ->where('kelasKode',$kodekelas)
                            ->leftJoin('siswa', 'anggotakelas.NISsiswa', '=', 'siswa.NIS')
                            ->get();
            $jumlah = AnggotaKelas::where('kelasKode',$kodekelas)->count();    
            $name = Session::get('name');
            $NIS = Session::get('NIS');
            $guru = Guru::where('kode_guru',$kelas->pengajar)->first();           
            return view('siswa/memberkelas',['name'=>$name ,'NIS'=>$NIS,'kelas'=>$kelas,'members'=>$members,'guru'=>$guru,'jumlah'=>$jumlah]);
            }
        }

        //menuju halaman detail materi
        public function detailmateri($idmateri){  
            if(!Session::get('isloginsiswa')){
                return $this->redirectsiswa();
            }
            else{
            $materi = Materi::find($idmateri);

            $name = Session::get('name');
            $NIS = Session::get('NIS'); 
            return view('siswa/detailmateri',['name'=>$name ,'materi'=>$materi]);
            }
        }

            //menuju halaman detail tugas
        public function detailtugas($idtugas){  
            $NIS = Session::get('NIS'); 
            if(!Session::get('isloginsiswa')){
                return $this->redirectsiswa();
            }
            else{
            $tugas = Tugas::find($idtugas);
            $jawaban = JawabanTugas::where('idtugas', $idtugas)
                                    ->where('NISsiswa', $NIS)
                                    ->first();
            $name = Session::get('name'); 
                if (empty($jawaban)) {
                    return view('siswa/submittugas',['name'=>$name ,'tugas'=>$tugas]);
                }else {
                    return view('siswa/edittugas',['name'=>$name ,'tugas'=>$tugas,'jawaban'=>$jawaban]);
                }          
            }
        }

        //logka submit jawaban
        public function submitjawabanPost(Request $request,$idtugas){
            $NIS = Session::get('NIS');        
            $request->validate([
                'keterangan' => 'required|max:255',
                'filemateri' => 'max:8192'
            ]);
            do {
                $random_string = Str::random(6);
                $lastid = JawabanTugas::latest()->select('id_jawaban')->first();
            } while ($random_string == $lastid);
        
               $fileName =null;
               if($request->filetugas){
                $fileName = $request->filetugas->getClientOriginalName().'-'.time().'.'.$request->filetugas->extension();
                $request->filetugas->move(public_path('file/jawaban'),$fileName); 
               }

            JawabanTugas::create([
                'id_jawaban' => $random_string,
                'keterangan' => $request->keterangan,
                'file_path' => $fileName,
                'idtugas' => $idtugas,
                'NISsiswa' => $NIS
            ]);

            $name = Session::get('name');   
            return redirect('/siswa/tugas/'.$idtugas);         
        }

        //proses logika untuk edit jawaban ke database
        public function editjawabanPut(Request $request,$idjawaban){

            $request->validate([
                'keterangan' => 'required|max:255',
                'file' => 'max:8192'
            ]);
            if($request->file){
            $fileName = $request->file->getClientOriginalName().'-'.time().'.'.$request->file->extension();
            $request->file->move(public_path('file/jawaban'),$fileName); 
            JawabanTugas::find($idjawaban)->update(['file_path' => $fileName]);
            }
            JawabanTugas::find($idjawaban)->update([
                'keterangan' => $request->keterangan
            ]);
            $idtugas= JawabanTugas::find($idjawaban)->value('idtugas');
            return redirect('/siswa/tugas/'.$idtugas); 
        }

            //menuju halaman daftar tugas
            public function listtugas(){
                if(!Session::get('isloginsiswa')){
                    return $this->redirectsiswa();
                }
                else{
                $NIS = Session::get('NIS'); 
                $tugass = DB::table('anggotaKelas')
                                    ->where('NISsiswa',$NIS)
                                    ->rightJoin('tugas', 'anggotaKelas.kelaskode', '=', 'tugas.kelas')
                                    ->leftJoin('kelas', 'anggotaKelas.kelaskode', '=', 'kelas.kode_kelas')
                                    ->leftJoin('guru', 'guru.kode_guru', '=', 'kelas.pengajar')
                                    ->select('judul','penjelasan','id_tugas as id','nama_kelas','nama_guru','tugas.created_at', 'deadline')
                                    ->oldest('deadline')
                                    ->get(); 
                       //dd($tugass);                       
                $name = Session::get('name');          
                return view('siswa/listtugas',['name'=>$name ,'NIS'=>$NIS,'tugass'=>$tugass]);
                }
            }

}
