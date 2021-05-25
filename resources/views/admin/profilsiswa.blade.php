@extends('layout.admin')
@section('title','Profil guru')
@section('content')

<!--untuk menunjukkan kesalahan / error -->
@if(count($errors)>0)
    <ul>
      @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
  @endif
  <a href="{{ url('/admin') }}" class="m-3 text-dark"> <img src="{{asset('img/assets/button/back.png')}}" alt="back" title="back" height="36"> Kembali</a>
  <div class="container-fluid m-3 p-3 bg-light">
<form action="{{ url('/editsiswaput/'.$siswa->NIS) }}" method="post" enctype="multipart/form-data">
<div class="row">
    <div class="col-4">
    <div class="form-group">
        @if (is_null($siswa->foto_path))
            <img src="{{asset('img/assets/blank-profile.webp')}}" alt="foto profil siswa" height="360" style="border-style: solid">
        @else
            <img src="{{asset('img/siswa/'.$siswa->foto_path)}}" alt="foto profil siswa" height="360" style="border-style: solid">
        @endif
        <br> 
        <label>Upload foto profil:</label>
        <input type="file" class="form-file form-control" name="fotoprofil" value="">
  </div>
    </div>
    <div class="col-8">
        <div class="form-group row">
            <label class="">NIS:</label>
            <input type="text" class="form-control" name="kodesiswa" value="{{ $siswa->NIS }}" required maxlength="16">
        </div>
        <div class="form-group row">
            <label class="">Nama Siswa:</label>
            <input type="text" class="form-control" name="namasiswa" value="{{ $siswa->nama_siswa }}" required maxlength="99">
        </div>
        <div class="form-group row">
            <label class="">Password:</label>
            <input type="textarea" class="form-control" name="password" value="{{ $siswa->password }}" maxlength="16">
        </div>
    </div>
    
  
  </div>
  <div class="form-group">
      <button type="submit" class="btn btn-md btn-primary">Save</button>
      <button type="reset" class="btn btn-md btn-danger">Cancel</button>
  </div>
  {{csrf_field()}}
  <input type="hidden" name="_method" value="PUT">
</div>  
</form>
</div>
@endsection