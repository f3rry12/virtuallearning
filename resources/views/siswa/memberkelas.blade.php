@extends('layout.siswa')
@section('title',$kelas->nama_kelas)
@section('content')
<div class="mb-2"></div>
<a href="{{ url('/siswa/kelas/'.$kelas->kode_kelas) }}" > <button class="btn btn-primary"><img src="{{asset('img/assets/button/back.png')}}" alt="back" title="back" height="36"> Kembali</button> </a>
<div class="d-flex flex-row mx-3 mt-2">
<h1 class="mb-0 pb-0 align-self-end p-0 mr-auto">{{strtoupper($kelas->nama_kelas)}}</h1>
</div>
<hr size="8" width="95%">  
<h2>Pengajar :</h2>
<div class="bg-light border rounded p-3 mb-3">
<div class="d-flex flex-row">
    @if (is_null($guru->foto_path))
    <img src="{{asset('img/assets/blank-profile.webp')}}" alt="foto profil guru" height="120" class="border rounded mr-2">
@else
    <img src="{{asset('img/guru/'.$guru->foto_path)}}" alt="foto profil guru" height="120" class="border rounded mr-2">
@endif
<p class="h3 ">{{$guru->nama_guru}}</p>
</div>
</div>

<h2 class="mt-3">Jumlah siswa {{$jumlah}}</h2>
<hr size="10" width="95%">
@if (count($members) < 1)
            <div class="text-center">
            <h3>Belum ada murid yang masuk kelas</h3>
            </div>
        @else
<div class="row">
    @foreach ($members as $member)
  <div class="col col-lg-5 col-sm-11 col-11 bg-light border rounded p-3 col-lg-offset-2 m-2">
    <div class="d-flex flex-row">
        @if (is_null($member->foto_path))
        <img src="{{asset('img/assets/blank-profile.webp')}}" alt="foto profil siswa" height="120" class="border rounded mr-2">
    @else
        <img src="{{asset('img/siswa/'.$member->foto_path)}}" alt="foto profil siswa" height="120" class="border rounded mr-2">
    @endif
    <p class="h3 ">{{$member->nama_siswa}}</p>
    </div>
    </div>
    @endforeach
</div>
    @endif





@endsection