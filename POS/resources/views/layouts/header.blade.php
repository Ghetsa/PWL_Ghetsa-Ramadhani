<nav class="main-header navbar navbar-expand navbar-white navbar-light">
  <!-- Left navbar links -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
      <a href="../public" class="nav-link">Home</a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
      <a href="{{ url('/contact') }}" class="nav-link">Contact</a>
    </li>
  </ul>

  <!-- Right navbar links -->
  <ul class="navbar-nav ml-auto">
    <!-- User Profile Dropdown -->
    <li class="nav-item dropdown">
      <a class="nav-link d-flex align-items-center" data-toggle="dropdown" href="#" aria-expanded="false">
        <img
          src="{{ Auth::user()->foto ? asset('storage/foto_profil/' . Auth::user()->foto) : asset('adminlte/dist/img/user1.jpg') }}"
          class="img-circle" alt="User Image" style="width: 32px; height: 32px; object-fit: cover; margin-right: 8px;">
        <span class="d-none d-md-inline text-dark" style="font-size: 14px;">{{ Auth::user()->nama ?? 'User' }}</span>
      </a>

      <div class="dropdown-menu dropdown-menu-right shadow rounded border-0 p-0" style="min-width: 230px;">
        <!-- Header -->
        <div class="d-flex align-items-center bg-light px-3 py-3 border-bottom">
          <img
            src="{{ Auth::user()->foto ? asset('storage/foto_profil/' . Auth::user()->foto) : asset('adminlte/dist/img/user1.jpg') }}"
            class="rounded-circle" style="width: 50px; height: 50px; object-fit: cover;" alt="User Image">

          <div class="ml-3">
            <h6 class="mb-0 font-weight-bold">{{ Auth::user()->nama ?? 'Nama Pengguna' }}</h6>
            <small class="text-muted">{{ Auth::user()->level->level_nama ?? 'Level' }}</small>
          </div>
        </div>

        <!-- Menu -->
        <a href="{{ url('/profile') }}" class="dropdown-item d-flex align-items-center">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person mr-2"
            viewBox="0 0 16 16">
            <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 
        1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 
        1.332c-.678.678-.83 1.418-.832 1.664z" />
          </svg>
          <span>Profile</span>
        </a>

        <a href="#" class="dropdown-item d-flex align-items-center"
          onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
            class="bi bi-box-arrow-right mr-2" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 
        1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 
        1.5-1.5v-2a.5.5 0 0 0-1 0z" />
            <path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 
        0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708z" />
          </svg>
          <span>Logout</span>
        </a>

        <form id="logout-form" action="{{ url('/logout') }}" method="GET" style="display: none;">
          @csrf
        </form>
      </div>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-widget="fullscreen" href="#" role="button">
        <i class="fas fa-expand-arrows-alt"></i>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
        <i class="fas fa-th-large"></i>
      </a>
    </li>
  </ul>
</nav>