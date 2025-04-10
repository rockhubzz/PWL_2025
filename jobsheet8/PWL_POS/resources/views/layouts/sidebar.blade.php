<div class="sidebar">
  {{-- <div class="user-panel d-flex flex-column align-items-center text-center ms-4"> --}}
    <div class="user-panel d-flex align-items-center ms-3" style="padding: 10px">
      <div class="image position-relative">
        <img src="{{ asset('pfp/' . (Auth::user()->foto_profil ?? 'default-profile.png')) }}"
          class="img-circle elevation-2"
          alt="User Image"
          style="width: 50px; height: 50px; object-fit: cover; border: 2px solid white;">
        </div>
        <a href="{{url('/profile')}}" class="mb-0 ms-2" style="color:white; margin-left: 20px;">{{ Auth::user()->nama }}</a>
    </div>

  <!-- SidebarSearch Form -->
  <div class="form-inline mt-2">
  <div class="input-group" data-widget="sidebar-search">
  <input class="form-control form-control-sidebar" type="search" placeholder="Search" 
  aria-label="Search">
  <div class="input-group-append">
  <button class="btn btn-sidebar">
  <i class="fas fa-search fa-fw"></i>
</button>
  </div>
</div>
</div>
<!-- Sidebar Menu -->
<nav class="mt-2">
  <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" 
  data-accordion="false">
  <li class="nav-item">
    <a href="{{ url('/') }}" class="nav-link {{ ($activeMenu == 'dashboard')? 'active' : '' }} ">
      <i class="nav-icon fas fa-tachometer-alt"></i>
  <p>Dashboard</p>
  </a>
</li>
<li class="nav-header">Data Pengguna</li>
<li class="nav-item">
  <a href="{{ url('/level') }}" class="nav-link {{ ($activeMenu == 'level')? 'active' : '' }} ">
    <i class="nav-icon fas fa-layer-group"></i>
    <p>Level User</p>
  </a>
</li>
<li class="nav-item">
<a href="{{ url('/user') }}" class="nav-link {{ ($activeMenu == 'user')? 'active' : '' }}">
<i class="nav-icon far fa-user"></i>
<p>Data User</p>
</a>
</li>
<li class="nav-header">Data Barang</li>
<li class="nav-item">
<a href="{{ url('/kategori') }}" class="nav-link {{ ($activeMenu == 'kategori')? 'active' : '' }} 
">
<i class="nav-icon far fa-bookmark"></i>
<p>Kategori Barang</p>
</a>
</li>
<li class="nav-item">
<a href="{{ url('/barang') }}" class="nav-link {{ ($activeMenu == 'barang')? 'active' : '' }} ">
<i class="nav-icon far fa-list-alt"></i>
<p>Data Barang</p>
</a>
</li>
<li class="nav-header">Data Supplier</li>
<li class="nav-item">
  <a href="{{ url('/supplier') }}" class="nav-link {{ ($activeMenu == 'supplier')? 'active' : '' }} ">
    <i class="nav-icon fas fa-truck"></i>
    <p>Data Supplier</p>
  </a>
</li>
<li class="nav-item">
  <a href="{{ url('/stok') }}" class="nav-link {{ $activeMenu == 'stok' ? 'active' : '' }} ">
      <i class="nav-icon fas fa-cubes"></i>
      <p>Stok Barang</p>
  </a>
</li>
<li class="nav-item">
  <form id="logout-form" action="{{ url('logout') }}" method="POST" style="display: none;">
      @csrf
  </form>
  <li class="nav-header">Akun</li>
  <a href="{{ url('/profile') }}" class="nav-link {{ $activeMenu == 'profile' ? 'active' : '' }} ">
    <i class="nav-icon fas fa-user"></i>
    <p>Ubah Profile</p>
</a>
  <a href="#" class="nav-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
      <i class="nav-icon fas fa-sign-out-alt"></i>
      <p>Log Out</p>
  </a>
</li>
</ul>
</nav>
</div>
