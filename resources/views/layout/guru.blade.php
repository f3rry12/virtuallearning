<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title','Halaman Guru')</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{asset('css/guru.css')}}">
    <link rel="stylesheet" href="{{asset('css/gurulayout.css')}}">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    
    <script src="https://kit.fontawesome.com/c1452f204d.js" crossorigin="anonymous"></script>

   
</head>
<body>
<nav class="navbar navbar-dark bg-primary">
  <a class="navbar-brand" href="#">
    <img src="{{asset('img/assets/logo_sekolah.png')}}" height="40" class="d-inline-block align-top" alt="">
  </a>
  <div class="text-white ms-auto">
  Anda login sebagai
  <a href="{{ url('/guru/profilguru/') }}" class="text-white">  {{Session::get('name')}}</a>
  <a href="{{ url('/logout') }}"><button type="button" class="btn btn-danger mb-1 ml-1">Logout</button></a>
  </div>
  </nav>

  <!-- Bootstrap row -->
<div class="row" id="body-row">
    <!-- Sidebar -->
    <div id="sidebar-container" class="sidebar-expanded d-none d-md-block">
        <!-- d-* hiddens the Sidebar in smaller devices. Its itens can be kept on the Navbar 'Menu' -->
        <!-- Bootstrap List Group -->
        <ul class="list-group">
        <a href="#" data-toggle="sidebar-colapse" class="bg-dark list-group-item list-group-item-action d-flex align-items-center">
                <div class="d-flex w-100 justify-content-start align-items-center">
                    <span id="collapse-icon" class="fa fa-2x mr-3"></span>
                    <span id="collapse-text" class="menu-collapsed">Sembunyikan</span>
                </div>
            </a>
            <!-- Separator with title -->
            <li class="list-group-item sidebar-separator-title text-muted d-flex align-items-center menu-collapsed">
                <small>MAIN MENU</small>
            </li>
            <!-- /END Separator -->
            <a href="{{url('/guru')}}" class="bg-dark list-group-item list-group-item-action">
                <div class="d-flex w-100 justify-content-start align-items-center">
                    <span class="fa fa-chalkboard-teacher fa-fw mr-3"></span>
                    <span class="menu-collapsed">Kelas</span>
                </div>
            </a>
            <a href="{{url('/guru/listtugas')}}" class="bg-dark list-group-item list-group-item-action">
                <div class="d-flex w-100 justify-content-start align-items-center">
                    <span class="fa fa-tasks fa-fw mr-3"></span>
                    <span class="menu-collapsed">Tugas <span class="badge badge-pill badge-primary ml-2">5</span></span>
                </div>
            </a>
            <a href="#" class="bg-dark list-group-item list-group-item-action">
                <div class="d-flex w-100 justify-content-start align-items-center">
                    <span class="fa fa-pen fa-fw mr-3"></span>
                    <span class="menu-collapsed">Ujian</span>
                </div>
            </a>
            <!-- Separator without title -->
            <li class="list-group-item sidebar-separator menu-collapsed"></li>
            <!-- /END Separator -->
            <a href="#" class="bg-dark list-group-item list-group-item-action">
                <div class="d-flex w-100 justify-content-start align-items-center">
                    <span class="fa fa-calendar-alt fa-fw mr-3"></span>
                    <span class="menu-collapsed">Agenda</span>
                </div>
            </a>
            <!-- Separator with title -->
            <li class="list-group-item sidebar-separator-title text-muted d-flex align-items-center menu-collapsed">
                <small>PROFIL</small>
            </li>
            <!-- /END Separator -->
            <a href="{{ url('/guru/profilguru/') }}" class="bg-dark list-group-item list-group-item-action">
                <div class="d-flex w-100 justify-content-start align-items-center">
                    <span class="fa fa-user fa-fw mr-3"></span>
                    <span class="menu-collapsed">Edit Profil</span>
                </div>
            </a>
            <a href="{{ url('/logout') }}" class="bg-dark list-group-item list-group-item-action">
                <div class="d-flex w-100 justify-content-start align-items-center">
                    <span class="fa fa-sign-out-alt fa-fw mr-3"></span>
                    <span class="menu-collapsed">Logout</span>
                </div>
            </a>
            

        </ul><!-- List Group END-->
    </div><!-- sidebar-container END -->

    <div class="col"><!-- agar row dari sidebar tidak mengganggu posisi content -->
    @yield('content')
    </div><!-- col END -->
</div><!-- Bootstrap row END -->
    <script src="{{asset('js/gurulayout.js')}}"></script> 
</body>
</html>