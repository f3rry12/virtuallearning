@extends('layout.siswa')
@section('title','Konfirmasi')
@section('content')

<div class="text-center" style="margin-top:25vh">
<h3>Anda akan masuk ke kelas {{$kelas->nama_kelas}}</h3>
<h3>dengan pengajar {{$namaguru}}</span></h3>
<p>Apakah ini kelas yang tepat?</p>
<div class="row">
    <div class="col m-3 border-0">
    <a href="{{ url('/siswa') }}"><button class="btn btn-primary mr-3">Kembali ke beranda</button></a>
    <a href="{{ url($NIS.'/masukkelasPost'.$kelas->kode_kelas) }}"><button class="btn btn-primary">Masuk ke kelas</button></a>
    </div>
</div>
</div>

@endsection