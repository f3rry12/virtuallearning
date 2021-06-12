@extends('layout.guru')
@section('title',$kelas->nama_kelas)
@section('content')
<div class="d-flex flex-row mx-5 mt-2">
<h1 class="mb-0 pb-0 align-self-end p-0">{{strtoupper($kelas->nama_kelas)}} </h1>
<a href="{{ url('/guru/member/'.$kelas->kode_kelas) }}" class="badge badge-secondary align-self-end mb-1 mr-auto">Jumlah anggota kelas: {{$jumlah}}</a>
<a href="{{ url('/guru/editkelas/'.$kelas->kode_kelas) }}" class="align-self-end"><button class="btn btn-primary" style="height: 40px;width: 40px"><i class="far fa-edit"></i></button></a>
</div>
<hr size="8" width="90%">  

<div class="bg-light border rounded p-3 mb-3">
<div class="d-flex flex-row">
<p class="h3 mr-auto">Bagikan agenda baru di kelas</p>
<a href="{{ url('/guru/bagimateri/'.$kelas->kode_kelas) }}"><button type="button" class="btn btn-primary mr-2">Materi</button></a>
<a href="{{ url('/guru/bagitugas/'.$kelas->kode_kelas) }}"><button type="button" class="btn btn-primary mr-2">Tugas</button></a>
<button type="button" class="btn btn-primary">Ujian</button>
</div>
</div>
@if (count($agendas) < 1)
            <div class="text-center">
            <h3>Tidak ada agenda apapun</h3>
            </div>
        @else
<div class="d-flex flex-column">
    @foreach ($agendas as $agenda)
    @if (substr($agenda->id,0,3)=='MAT')
    <a href="{{ url('/guru/editmateri/'.$agenda->id) }}" class="text-dark mb-3">
      <div class="card">
      <div class="card-body">
        <h5 class="card-title"><span class="badge badge-primary">Materi</span>{{$agenda->judul}}</h5>
        <p class="card-text">{{$agenda->penjelasan}}</p>
        <p class="card-text">kelas {{$agenda->nama_kelas}}</p>
        <p class="card-text">Pengajar {{$agenda->nama_guru}}</p>
      </div>
    </div>
    </a>
    @elseif (substr($agenda->id,0,3)=='TGS')
    @php
        $now = new Datetime(date('Y/m/d h:i:s a', time()));
        $datetime2 = new DateTime($agenda->deadline);
        $interval = $now->diff($datetime2);
        $sisa = $interval->format('%d')." Hari ".$interval->format('%h')." Jam ".$interval->format('%i')." Menit";
    @endphp
    <a href="{{ url('/guru/edittugas/'.$agenda->id) }}" class="text-dark mb-3">
      <div class="card">
      <div class="card-body">
        <h5 class="card-title"><span class="badge badge-danger">Tugas</span>{{$agenda->judul}}</h5>
        <p class="card-text">{{$agenda->penjelasan}}</p>
        <p class="card-text">kelas {{$agenda->nama_kelas}}</p>
        <p class="card-text">Pengajar {{$agenda->nama_guru}}</p>
        <p class="card-text">{{$sisa}}</p>
      </div>
    </div>
    </a>
    @endif
    @endforeach
    </div>
    @endif





@endsection