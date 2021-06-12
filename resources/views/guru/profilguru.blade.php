@extends('layout.guru')
@section('title','Profil guru')
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
<a href="{{ url('/guru') }}" > <button class="btn btn-primary"><img src="{{asset('img/assets/button/back.png')}}" alt="back" title="back" height="36"> Kembali</button> </a>
  <div class="container-fluid m-3 p-3 bg-light">
<form action="{{ url('guru/editguruput/'.$guru->username) }}" method="post" enctype="multipart/form-data">
<div class="row">
    <div class="col-4 mr-3">
    <div class="form-group">
        @if (is_null($guru->foto_path))
            <img src="{{asset('img/assets/blank-profile.webp')}}" alt="foto profil guru" height="360" style="border-style: solid">
        @else
            <img src="{{asset('img/guru/'.$guru->foto_path)}}" alt="foto profil guru" height="360" style="border-style: solid">
        @endif
        <br> 
        <label>Upload foto profil:</label>
        <input type="file" class="form-file form-control" name="fotoprofil" value="">
  </div>
    </div>
    <div class="col-7">
        <div class="form-group row">
            <label class="">Kode guru:</label>
            <input type="text" class="form-control" value="{{ $guru->kode_guru }}" required maxlength="16" disabled>
        </div>
        <div class="form-group row">
            <label class="">Nama Guru:</label>
            <input type="text" class="form-control" name="namaguru" value="{{ $guru->nama_guru }}" required maxlength="99">
        </div>
        <div class="form-group row">
            <label class="">Username:</label>
            <input type="textarea" class="form-control" name="username" value="{{ $guru->username }}" maxlength="16">
        </div>
        <div class="form-group row">
            <label class="">Password:</label>
            <input type="password" class="form-control" name="password" value="{{ $guru->password }}" maxlength="16">
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