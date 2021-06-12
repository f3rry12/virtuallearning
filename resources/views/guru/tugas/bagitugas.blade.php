@extends('layout.guru')
@section('title','Bagikan Tugas')
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
<a href="{{ url('/guru/kelas/'.$kodekelas) }}" > <button class="btn btn-primary"><img src="{{asset('img/assets/button/back.png')}}" alt="back" title="back" height="36"> Kembali</button> </a>

<div class="container-liquid m-3 bg-light">
<form action="{{ url('/guru/bagitugaspost/'.$kodekelas) }}" method="post" enctype="multipart/form-data">
  <div class="form-group">
    <label>Foto penjelas:</label>
    <input type="file" class="form-file form-control" name="fototugas" value="{{ old('fototugas') }}">
</div>
  <div class="form-group">
      <label>Judul:</label>
      <input type="text" class="form-control" name="judul" value="{{ old('judul') }}" required maxlength="99">
  </div>
  <div class="form-group">
      <label>Penjelasan:</label>
      <textarea rows="3" type="textarea" class="form-control" name="penjelasan" maxlength="255">{{ old('penjelasan') }}</textarea>
  </div>
  <div class="form-group">
    <label>Tanggal deadline:</label>
    <input type="date" class="form-control" name="tanggal">
    <label>Jam deadline:</label>
    <input type="time" class="form-control" value="23:59" name="jam">
</div>

  <div class="form-group">
      <label>Upload Materi:</label>
      <input type="file" class="form-file form-control" name="filetugas" value="{{ old('filetugas') }}">
  </div>
  <div class="form-group">
      <button type="submit" class="btn btn-md btn-primary">Submit</button>
      <button type="reset" class="btn btn-md btn-danger">Cancel</button>
  </div>
  {{csrf_field()}}
</form>
</div>

@endsection