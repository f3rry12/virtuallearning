@extends('layout.siswa')
@section('title','{{$kelas->nama_kelas}}')
@section('content')

<h1>{{$kelas->nama_kelas}}</h1>
<div class="d-flex flex-row">
<button type="button" class="btn btn-primary ml-5 mt-3">Materi</button>
<button type="button" class="btn btn-primary ml-5 mt-3">Kelas</button>
<button type="button" class="btn btn-primary ml-5 mt-3">Ujian</button>

</div>
<hr size="8" width="90%">  




@endsection