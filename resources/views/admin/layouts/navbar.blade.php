<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
<button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
    <i class="fa fa-bars"></i>
</button>

<ul class="navbar-nav ml-auto">

    <li class="nav-item dropdown no-arrow">
        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown">
            <span class="mr-2 d-none d-lg-inline text-gray-600 small">Admin</span>
            <img class="img-profile rounded-circle" src="https://ui-avatars.com/api/?name=Admin">
        </a>

        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in">
            <a class="dropdown-item" href="#">
                <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                Profil
            </a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                Keluar
            </a>
            <form id="logout-form" action="#" method="POST" class="d-none">
                @csrf
            </form>
        </div>
    </li>

</ul>

</nav>
