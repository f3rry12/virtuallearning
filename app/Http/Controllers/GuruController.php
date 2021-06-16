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
            //$kelass = Kelas::where('pengajar',$kodeguru)->get();  
            $kelass = DB::table('kelas')
                        ->where('pengajar',$kodeguru)
                        ->leftJoin('guru', 'kelas.pengajar', '=', 'guru.kode_guru')
                        ->select('kode_kelas','nama_kelas','nama_guru')
                        ->get();      
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

            //Menuju halaman profil guru
        public function profilguru(){
            $name = Session::get('name');
            $kodeguru = Session::get('kodeguru');  
            if(!Session::get('isloginguru')){
                return $this->redirectguru();
            }
            else{
            $guru = Guru::where('kode_guru',$kodeguru)->first();
    
            return view('guru/profilguru',['name'=>$name ,'guru'=>$guru]);
            }
        }

            //proses logika untuk edit guru ke database
        public function editguruPut(Request $request,$username){
            $kodeguru = Session::get('kodeguru'); 

        if ($request->username!=$username) {
            $request->validate([
            'username' => 'required|unique:guru,username|max:16'
        ]);
        }
            $request->validate([
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
                'nama_guru' => $request->namaguru,
                'username' => $request->username,
                'password' => $request->password,
            ]);
        return redirect('guru/profilguru');
        }

        public function buatkelasPost(Request $request,$kodeguru){    
            $kodeguru = Session::get('kodeguru');  
            $request->validate([
                'namakelas' => 'required|max:99'
            ]);
            do {
                $random_string = Str::random(6);
                $lastKelaskode = Kelas::latest()->select('kode_kelas')->first();
            } while ($random_string == $lastKelaskode);

            Kelas::create([
                'kode_kelas' => $random_string,
                'nama_kelas' => $request->namakelas,
                'pengajar' => $kodeguru    
            ]);

            $name = Session::get('name');
   
            return view('guru/tambahkelas',['name'=>$name ,'kodeguru'=>$kodeguru,'kodekelas'=>$random_string,'namakelas' => $request->namakelas]);
        }

        public function indexkelas($kodekelas){
            if(!Session::get('isloginguru')){
                return $this->redirectguru();
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
                                          
               //dd($tugass);
            $name = Session::get('name');
            $kodeguru = Session::get('kodeguru');           
            return view('guru/kelasguru',['name'=>$name ,'kodeguru'=>$kodeguru,'kelas'=>$kelas,'jumlah'=>$jumlah, 'agendas'=>$tugass]);
            }
        }
        
        public function indexMember($kodekelas){
            if(!Session::get('isloginguru')){
                return $this->redirectguru();
            }
            else{
            $kelas = Kelas::where('kode_kelas',$kodekelas)->first();
            $members = DB::table('anggotakelas')
                            ->where('kelasKode',$kodekelas)
                            ->leftJoin('siswa', 'anggotakelas.NISsiswa', '=', 'siswa.NIS')
                            ->get();
            $jumlah = AnggotaKelas::where('kelasKode',$kodekelas)->count();    
            $name = Session::get('name');
            $kodeguru = Session::get('kodeguru');
            $guru = Guru::where('kode_guru',$kodeguru)->first();           
            return view('guru/memberkelas',['name'=>$name ,'kodeguru'=>$kodeguru,'kelas'=>$kelas,'members'=>$members,'guru'=>$guru,'jumlah'=>$jumlah]);
            }
        }

            //Menuju halaman edit kelas
        public function editkelas($kodekelas){  
            if(!Session::get('isloginguru')){
                return $this->redirectguru();
            }
            else{
            $kelas = Kelas::where('kode_kelas',$kodekelas)->first();

            $name = Session::get('name');
            $kodeguru = Session::get('kodeguru'); 
            return view('guru/editkelas',['name'=>$name ,'kelas'=>$kelas]);
            }
        }

            //proses logika untuk edit kelas ke database
        public function editkelasPut(Request $request, $kodekelas){

            $request->validate([
                'namakelas' => 'required|max:255'
            ]);
            Kelas::find($kodekelas)->update([
                'nama_kelas' => $request->namakelas
            ]);
        return redirect('/guru/kelas/'.$kodekelas);
        }

        //Pengumuman
        public function pengumumanPost(Request $request,$kodekelas){    
            $request->validate([
                'keterangan' => 'required|max:255'
            ]);
            
            $lastPostID = Pengumuman::latest()->value('id_pengumuman');
                $lastPostID = (int)substr($lastPostID , 4);
                $idPost = 'PEN-'.$lastPostID+1;
            Pengumuman::create([
                'id_pengumuman' => $idPost,
                'keterangan' => $request->keterangan,
                'kelas' => $kodekelas   
            ]);

            $name = Session::get('name');
            $kodeguru = Session::get('kodeguru');   
            return redirect('/guru/kelas/'.$kodekelas); 
        }

            //proses logika untuk edit pengumuman ke database
            public function pengumumanPut(Request $request){
                $request->validate([
                    'keterangan' => 'required|max:255'
                ]);
                $idpengumuman = $request->pengumumanId;
                Pengumuman::find($idpengumuman)->update([
                    'keterangan' => $request->keterangan
                ]);
                $kodekelas = Pengumuman::find($idpengumuman)->value('kelas');
                return redirect('/guru/kelas/'.$kodekelas); 
            }

            //Menuju halaman bagi materi
        public function bagimateri($kodekelas){  
            if(!Session::get('isloginguru')){
                return $this->redirectguru();
            }
            else{
            $name = Session::get('name');
            $kodeguru = Session::get('kodeguru'); 
            return view('guru/materi/bagimateri',['name'=>$name ,'kodekelas'=>$kodekelas]);
            }
        }
        public function bagimateriPost(Request $request,$kodekelas){       

            $request->validate([
                'judul' => 'required|max:99',
                'penjelasan' => 'required|max:255',
                'filemateri' => 'max:8192'
            ]);
        
               $fileName =null;
               if($request->filemateri){
                $fileName = $request->filemateri->getClientOriginalName().'-'.time().'.'.$request->filemateri->extension();
                // $request->filemateri->move(public_path('file/materi'),$fileName); 
                $request->file('filemateri')->storeAs('materi', $fileName);
               }

                $lastMateriID = Materi::latest()->value('id_materi');
                $lastMateriID = (int)substr($lastMateriID , 4);
                $idmateri = 'MAT-'.$lastMateriID+1;
            Materi::create([
                'id_materi' => $idmateri,
                'judul' => $request->judul,
                'penjelasan' => $request->penjelasan,
                'file_path' => $fileName,
                'kelas' => $kodekelas   
            ]);

            $name = Session::get('name');
            $kodeguru = Session::get('kodeguru');   
            return redirect('/guru/editmateri/'.$idmateri);         
        }

        public function editmateri($idmateri){  
            if(!Session::get('isloginguru')){
                return $this->redirectguru();
            }
            else{
            $materi = Materi::find($idmateri);

            $name = Session::get('name');
            $kodeguru = Session::get('kodeguru'); 
            return view('guru/materi/editmateri',['name'=>$name ,'materi'=>$materi]);
            }
        }

        // public function downloadmateri($namafile){
        //     return Storage::response()->download('file/materi/'.$namafile);
        // }

            //proses logika untuk edit materi ke database
            public function editmateriPut(Request $request,$idmateri){

                $request->validate([
                    'judul' => 'required|max:99',
                    'penjelasan' => 'required|max:255',
                    'filemateri' => 'max:8192'
                ]);
                if($request->filemateri){
                $fileName = $request->filemateri->getClientOriginalName().'-'.time().'.'.$request->filemateri->extension();
                $request->file('filemateri')->storeAs('materi', $fileName);
                Materi::find($idmateri)->update(['file_path' => $fileName]);
                }
                Materi::find($idmateri)->update([
                    'judul' => $request->judul,
                    'penjelasan' => $request->penjelasan
                ]);
                return redirect('/guru/editmateri/'.$idmateri); 
            }

                //Menuju halaman bagi tugas
            public function bagitugas($kodekelas){  
                if(!Session::get('isloginguru')){
                    return $this->redirectguru();
                }
                else{
                $name = Session::get('name');
                $kodeguru = Session::get('kodeguru'); 
                return view('guru/tugas/bagitugas',['name'=>$name ,'kodekelas'=>$kodekelas]);
                }
            }

            public function bagitugasPost(Request $request,$kodekelas){
                $deadline = date($request->tanggal." ".$request->jam);
                $request->validate([
                    'judul' => 'required|max:99',
                    'penjelasan' => 'required|max:255',
                    'fototugas' => 'max:8192',
                    'filetugas' => 'max:8192'
                ]);
            
                $fileName =null;
                if($request->filetugas){
                    $fileName = $request->filetugas->getClientOriginalName().'-'.time().'.'.$request->filetugas->extension();
                    $request->file('filetugas')->storeAs('tugas', $fileName); 
                }

                $fotoName =null;
                if($request->fototugas){
                    $fotoName = $request->fototugas->getClientOriginalName().'-'.time().'.'.$request->fototugas->extension();
                    $request->fototugas->move(public_path('img/tugas'),$fotoName); 
                }

                    $lastTugasID = Tugas::latest()->value('id_tugas');
                    $lastTugasID = (int)substr($lastTugasID , 4);
                    $idtugas = 'TGS-'.$lastTugasID+1;
                Tugas::create([
                    'id_tugas' => $idtugas,
                    'judul' => $request->judul,
                    'penjelasan' => $request->penjelasan,
                    'file_path' => $fileName,
                    'foto_path' => $fotoName,
                    'deadline' => $deadline,
                    'kelas' => $kodekelas   
                ]);
              return redirect('/guru/edittugas/'.$idtugas);   
              //      return redirect('/guru/kelas/'.$kodekelas);        
            }

            //menuju halaman edit tugas
            public function edittugas($idtugas){  
                if(!Session::get('isloginguru')){
                    return $this->redirectguru();
                }
                else{
                $tugas = Tugas::find($idtugas);
    
                $name = Session::get('name');
                $kodeguru = Session::get('kodeguru'); 
                return view('guru/tugas/edittugas',['name'=>$name ,'tugas'=>$tugas]);
                }
            }

            public function edittugasPut(Request $request,$idtugas){

                $deadline = date($request->tanggal." ".$request->jam);
                $request->validate([
                    'judul' => 'required|max:99',
                    'penjelasan' => 'required|max:255',
                    'foto' => 'max:8192',
                    'file' => 'max:8192'
                ]);
                if($request->file){
                $fileName = $request->file->getClientOriginalName().'-'.time().'.'.$request->file->extension();
                $request->file('file')->storeAs('tugas', $fileName); 
                Tugas::find($idtugas)->update(['file_path' => $fileName]);
                }
                if($request->foto){
                    $fotoName = $request->foto->getClientOriginalName().'-'.time().'.'.$request->foto->extension();
                    $request->foto->move(public_path('img/tugas'),$fotoName); 
                    Tugas::find($idtugas)->update(['foto_path' => $fotoName]);
                    }
                Tugas::find($idtugas)->update([
                    'judul' => $request->judul,
                    'deadline' => $deadline,
                    'penjelasan' => $request->penjelasan
                ]);
                return redirect('/guru/edittugas/'.$idtugas); 
            }

            //menuju halaman daftar tugas
            public function listtugas(){
                if(!Session::get('isloginguru')){
                    return $this->redirectguru();
                }
                else{
                $kodeguru = Session::get('kodeguru'); 
                $tugass = DB::table('kelas')
                                    ->where('pengajar',$kodeguru)
                                    ->rightJoin('tugas', 'kelas.kode_kelas', '=', 'tugas.kelas')
                                    ->leftJoin('guru', 'guru.kode_guru', '=', 'kelas.pengajar')
                                    ->select('judul','penjelasan','id_tugas as id','nama_kelas','nama_guru','tugas.created_at', 'deadline')
                                    ->oldest('deadline')
                                    ->get(); 
                                              
               // dd($tugass);
                $name = Session::get('name');          
                return view('guru/penilaian/listtugas',['name'=>$name ,'kodeguru'=>$kodeguru,'tugass'=>$tugass]);
                }
            }

            //menuju halaman daftar nilai
            public function listnilai($idtugas){
                if(!Session::get('isloginguru')){
                    return $this->redirectguru();
                }
                else{
                $kodeguru = Session::get('kodeguru'); 
                $tugas = Tugas::find($idtugas);

                $jawaban = DB::table('jawabantugas')
                                ->where('idtugas',$idtugas);

                $members = DB::table('anggotakelas')
                                ->where('kelasKode',$tugas->kelas)
                                ->leftJoin('siswa', 'anggotakelas.NISsiswa', '=', 'siswa.NIS')
                                ->leftJoinSub($jawaban, 'jawaban', function ($join) {
                                    $join->on('anggotakelas.NISsiswa', '=', 'jawaban.NISsiswa');})
                                ->select('NIS','nama_siswa','jawaban.created_at as submit','id_jawaban','nilai')
                                ->get();

                                              
                //dd($members);
                $name = Session::get('name');          
                return view('guru/penilaian/listnilai',['name'=>$name ,'kodeguru'=>$kodeguru,'members'=>$members,'tugas'=>$tugas]);
                }
            }

            //menuju halaman penilaian
            public function nilai($idjawaban){
                if(!Session::get('isloginguru')){
                    return $this->redirectguru();
                }
                else{
                $jawaban = JawabanTugas::find($idjawaban);
                $tugas = Tugas::find($jawaban->idtugas);
                                    
                $name = Session::get('name');
                $kodeguru = Session::get('kodeguru');          
                return view('guru/penilaian/nilaitugas',['name'=>$name ,'kodeguru'=>$kodeguru,'jawaban'=>$jawaban,'tugas'=>$tugas]);
                }                
            } 

        //proses logika untuk memberi nilai ke database
        public function nilaiPut(Request $request,$idjawaban){

            $request->validate([
                'nilai' => 'required|max:3'
            ]);
            JawabanTugas::find($idjawaban)->update([
                'nilai' => $request->nilai
            ]);
            $idtugas= JawabanTugas::where('id_jawaban',$idjawaban)->value('idtugas');
            return redirect('/guru/daftarnilai/'.$idtugas); 
        }
            
}
