@guest

  <div class="d-flex flex-column flex-shrink-0 p-3 text-white bg-dark shadow-top" style="width: 280px; min-height: calc(100vh - 70.24px);">
    <ul class="nav nav-pills flex-column mb-auto">
      <li class="nav-item">
        <a href="{{ route('home') }}" class="nav-link text-white {{ Request::is('/') ? 'active' : '' }}" aria-current="page">
          <svg class="bi me-2" width="16" height="16"></svg>
          <i class="fa-solid fa-house"></i> Home
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ route('projects') }}" class="nav-link text-white {{ Request::is('projects') ? 'active' : '' }}" aria-current="page">
          <svg class="bi me-2" width="16" height="16"></svg>
          <i class="fa-solid fa-list-ul"></i> Projects
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ route('contacts') }}" class="nav-link text-white {{ Request::is('contacts') ? 'active' : '' }}" aria-current="page">
          <svg class="bi me-2" width="16" height="16"></svg>
          <i class="fa-solid fa-address-card"></i> Contacts
        </a>
      </li>
    </ul>
  </div>

@endguest
