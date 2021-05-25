@extends('layout.admin')
@section('title','Beranda Admin')
@section('content')
<div class="m-2 gap-2">
<h2>Tabel Guru</h2>
  <a href="{{ url('/admin/tambahguru') }}"> <button type="button" class="btn btn-primary">Buat akun guru </button><img src="img/assets/button/add-48.png" alt="add" title="add" height="32"></a>
  <table class="table table-condensed table-hover table-bordered mt-2">
    <thead>
      <tr>
        <th>No.</th>
        <th>Nama guru</th>
        <th>Link gambar Profil</th>
        <th>kode guru</th>
        <th>Edit profil</th>
        <th>Hapus akun</th>
      </tr>
    </thead>
    <tbody>
      @php
        $i=1;
      @endphp
  @foreach ($gurus as $guru)
    <tr>
      <td>{{$i}}</td>
      <td><a href="{{ url('/admin/profilguru/'.$guru->kode_guru) }}">{{ $guru->nama_guru }}</a></td>
      <td> {{ $guru->foto_path}}</td>
      <td>{{ $guru->kode_guru }}</td>
      <td>
        <form class="" action="{{ url('/admin/profilguru/'.$guru->kode_guru) }} ">
              <input type="image" src="img/assets/button/edit-64.png" alt="edit" title="edit" height="32" name="submit">
              </form>
      </td>
      <td>
        <form class="" action="{{ url('/admin/hapusguru/'.$guru->kode_guru) }} " method="post">
              <input type="image" src="img/assets/button/delete-48.png" alt="delete" title="delete" height="32" name="submit" value="delete">
               {{ csrf_field() }}
               <input type="hidden" name="_method" value="DELETE">
              </form>
      </td>
      </tr>
      @php
        $i++;
      @endphp
  @endforeach
  </tbody>
  </table>

  <h2>Tabel siswa</h2>
  <a href="{{ url('/admin/tambahsiswa') }}"> <button type="button" class="btn btn-primary">Buat akun siswa </button><img src="img/assets/button/add-48.png" alt="add" title="add" height="32"></a>
  <table class="table table-condensed table-hover table-bordered mt-2">
    <thead>
      <tr>
        <th>No.</th>
        <th>Nama siswa</th>
        <th>Link gambar Profil</th>
        <th>NIS</th>
        <th>Edit profil</th>
        <th>Hapus akun</th>
      </tr>
    </thead>
    <tbody>
      @php
        $i=1;
      @endphp
  @foreach ($siswas as $siswa)
    <tr>
      <td>{{$i}}</td>
      <td><a href="{{ url('/admin/profilsiswa/'.$siswa->NIS) }}">{{ $siswa->nama_siswa }}</a></td>
      <td> {{ $siswa->foto_path}}</td>
      <td>{{ $siswa->NIS }}</td>
      <td>
        <form class="" action="{{ url('/admin/profilsiswa/'.$siswa->NIS) }} ">
              <input type="image" src="img/assets/button/edit-64.png" alt="edit" title="edit" height="32" name="submit">
              </form>
      </td>
      <td>
        <form class="" action="{{ url('/admin/hapussiswa/'.$siswa->NIS) }} " method="post">
              <input type="image" src="img/assets/button/delete-48.png" alt="delete" title="delete" height="32" name="submit" value="delete">
               {{ csrf_field() }}
               <input type="hidden" name="_method" value="DELETE">
              </form>
      </td>
      </tr>
      @php
        $i++;
      @endphp
  @endforeach
  </tbody>
  </table>

  </div>

@endsection