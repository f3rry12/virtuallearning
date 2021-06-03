@extends('layout.guru')
@section('title',$kelas->nama_kelas)
@section('content')
<div class="d-flex flex-row mx-5 mt-2">
<h1 class="mb-0 pb-0 align-self-end p-0">{{strtoupper($kelas->nama_kelas)}}</h1>
<a href="#" class="badge badge-secondary align-self-end mb-1 mr-auto">Jumlah anggota kelas: </a>
<button class="btn btn-primary align-self-end" style="height: 40px;width: 40px"><i class="far fa-edit"></i></button>
</div>
<hr size="8" width="90%">  
<div class="d-flex flex-row">
<button type="button" class="btn btn-primary ml-5 mt-3">Materi</button>
<button type="button" class="btn btn-primary ml-5 mt-3">Kelas</button>
<button type="button" class="btn btn-primary ml-5 mt-3">Ujian</button>
</div>
@if (empty($materis))
            <div class="text-center">
            <h3>Tidak ada agenda apapun</h3>
            </div>
        @else
<div class="d-flex flex-column">
    @foreach ($materis as $materikelas)
    <a href="{{ url('/guru/materi/'.$kelasmateri->kode_materi) }}" class="text-dark mb-3">
    <div class="card">
    <div class="card-body">
      <h5 class="card-title">{{$materi->nama_materi}}</h5>
      <p class="card-text">Pengajar </p>
    </div>
  </div>
  </a>
    @endforeach
    </div>
    @endif





@endsection