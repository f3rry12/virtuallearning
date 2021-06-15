@extends('layout.siswa')
@section('title', 'Tugas')
@section('content')
<div class="d-flex flex-row mx-5 mt-2">
<h1 class="mb-0 pb-0 align-self-end p-0">Daftar Tugas </h1>
</div>
<hr size="8" width="90%">  

@if (count($tugass) < 1)
            <div class="text-center">
            <h3>Tidak ada agenda apapun</h3>
            </div>
        @else
<div class="d-flex flex-column">
    @foreach ($tugass as $tugas)
    @php
        $now = new Datetime(date('Y/m/d h:i:s a', time()));
        $datetime2 = new DateTime($tugas->deadline);
        $interval = $now->diff($datetime2);
        $sisa = $interval->format('%d')." Hari ".$interval->format('%h')." Jam ".$interval->format('%i')." Menit";
    @endphp
    <a href="{{ url('/siswa/tugas/'.$tugas->id) }}" class="text-dark mb-3">
      <div class="card">
      <div class="card-body">
        <h5 class="card-title"><span class="badge badge-danger">Tugas</span>{{$tugas->judul}}</h5>
        <p class="card-text">{{$tugas->penjelasan}}</p>
        <p class="card-text">kelas {{$tugas->nama_kelas}}</p>
        <p class="card-text">Pengajar {{$tugas->nama_guru}}</p>
        <p class="card-text">{{$sisa}}</p>
      </div>
    </div>
    </a>
    @endforeach
    </div>
    @endif





@endsection