@extends('layout.admin')
@section('title','Beranda Admin')
@section('content')
<h2>Tabel Guru</h2>
  <a href="{{ url('/admin/tambhguru') }}"> Buat akun guru <img src="img/add-48.png" alt="add" title="add" height="32"></a>
  <table class="table table-condensed table-hover table-bordered">
    <thead>
      <tr>
        <th>No.</th>
        <th>Nama guru</th>
        <th>Link gambar Profil</th>
        <th>kode guru</th>
        <th></th>
        <th></th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      @php
        $i=1;
      @endphp
  @foreach ($gurus as $guru)
    <tr>
      <td>{{$i}}</td>
      <td><a href="{{ url('/admin/detailpanorama/'.$tempat->namaTempat) }}">{{ $tempat->namaTempat }}</a></td>
      <td> <a href="{{ $tempat->linkGambarPanorama }}" target="_blank">{{ $tempat->linkGambarPanorama }}</a></td>
      <td><a href="{{ $tempat->linkGambarPreview }}" target="_blank">{{ $tempat->linkGambarPreview }}</a></td>
      <td>
        <form class="" action="{{ url('/panorama/'.$tempat->namaTempat) }} " target="_blank">
              <input type="image" src="img/view-512.webp" alt="view" title="view" height="32" name="submit">
              </form>
      </td>
      <td>
        <form class="" action="{{ url('/admin/editpanorama/'.$tempat->namaTempat) }} ">
              <input type="image" src="img/edit-64.png" alt="edit" title="edit" height="32" name="submit">
              </form>
      </td>
      <td>
        <form class="" action="{{ url('/admin/hapuspnrm/'.$tempat->namaTempat) }} " method="post">
              <input type="image" src="img/delete-48.png" alt="delete" title="delete" height="32" name="submit" value="delete">
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
@endsection