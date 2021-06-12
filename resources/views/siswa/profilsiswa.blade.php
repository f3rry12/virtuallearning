@extends('layout.siswa')
@section('title','Profil siswa')
@section('content')

<!--untuk menunjukkan kesalahan / error -->
@if(count($errors)>0)
    <ul class="jumbotron">
      @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
  @endif
  <div class="mb-2"></div>
<a href="{{ url('/siswa') }}" > <button class="btn btn-primary"><img src="{{asset('img/assets/button/back.png')}}" alt="back" title="back" height="36"> Kembali</button> </a>
  <div class="container-fluid m-3 p-3 bg-light">
<form action="{{ url('siswa/editsiswaput/') }}" method="post" enctype="multipart/form-data">
<div class="row">
    <div class="col-4 mr-3">
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
    <div class="col-7">
        <div class="form-group row">
            <label class="">NIS:</label>
            <input type="text" class="form-control" value="{{ $siswa->NIS }}" maxlength="16" disabled>
        </div>
        <div class="form-group row">
            <label class="">Nama Siswa:</label>
            <input type="text" class="form-control" name="namasiswa" value="{{ $siswa->nama_siswa }}" maxlength="99" disabled>
        </div>
        <div class="form-group row">
            <label class="">Password:</label>
            <input type="password" class="form-control" name="password" value="{{ $siswa->password }}" maxlength="16">
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