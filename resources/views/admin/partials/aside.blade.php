@auth
  <aside>

  <div class="d-flex flex-column flex-shrink-0 p-3 text-white bg-dark shadow-top" style="width: 280px; min-height: calc(100vh - 70.24px);">
    <ul class="nav nav-pills flex-column mb-auto">
      <li class="nav-item">
        <a href="{{ url('admin') }}" class="nav-link text-white {{ Request::is('admin') ? 'active' : '' }}" aria-current="page">
          <svg class="bi me-2" width="16" height="16"></svg>
          <i class="fa-solid fa-house"></i> Home
        </a>
      </li>
      <li>
          <a href="#" class="nav-link text-white {{ Request::is('admin/dashboard') ? 'active' : '' }}">
          <svg class="bi me-2" width="16" height="16"></svg>
          <i class="fa-solid fa-chart-line"></i> Dashboard
        </a>
      </li>
      <li>
        <a href="{{ route('adminprojects.index') }}" class="nav-link text-white {{ Request::is('admin/projects') ? 'active' : '' }}">
          <svg class="bi me-2" width="16" height="16"></svg>
          <i class="fa-solid fa-list-ul"></i> Project list
        </a>
      </li>
      <li>
        <a href="{{ route('adminprojects.create') }}" class="nav-link text-white {{ Request::is('admin/projects/create') ? 'active' : '' }}">
          <svg class="bi me-2" width="16" height="16"></svg>
          <i class="fa-solid fa-plus"></i> New Project
        </a>
      </li>
    </ul>
  <hr>
    <div class="dropdown d-flex flex-column justify-content-end">
      <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="fa-regular fa-user rounded-circle me-2 bg-grey p-2"></i>
        <strong class="me-1">{{ Auth::user()->name }}</strong>
      </a>
      <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
        {{-- <li><a class="dropdown-item" href="#">New project...</a></li> --}}
        {{-- <li><a class="dropdown-item" href="#">Settings</a></li> --}}
        {{-- <li><a class="dropdown-item" href="#">Profile</a></li> --}}
        {{-- <li><hr class="dropdown-divider"></li> --}}
        {{-- <li><a class="dropdown-item" href="#">Sign out</a></li> --}}
        <form id="logout-form" action="{{ route('logout') }}" method="POST">
          {{-- token di sicurezza --}}
            @csrf
            <button class="dropdown-item" type="submit" >Sign out</button>
        </form>
      </ul>
    </div>
  </div>



</aside>
  @endauth
