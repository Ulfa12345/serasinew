<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

    <!-- Tombol Sidebar Mobile -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>

    <ul class="navbar-nav ml-auto">

        <!-- Divider -->
        <div class="topbar-divider d-none d-sm-block"></div>

        <!-- User Info -->
        <li class="nav-item dropdown no-arrow d-flex align-items-center">

            <!-- Role Display -->
            <div class="mr-3 d-none d-lg-flex align-items-center" style="font-size: 0.85rem;">
                <i class="fas fa-user-lock text-primary mr-2"></i>
                <span class="text-gray-600 mr-2">Akses saat ini:</span>
                <span class="badge badge-success px-2 py-1">
                    <?= isset($admin['role']) ? $admin['role'] : 'Admin'; ?>
                </span>
            </div>

            <!-- Dropdown Toggle -->
            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown"
               role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                <span class="mr-3 d-none d-lg-inline text-gray-800 font-weight-bold small">
                    <?= isset($admin['nama']) ? $admin['nama'] : 'Admin'; ?>
                </span>

                <img class="img-profile rounded-circle border"
                     src="../../assets/img/author2.jpg"
                     width="32" height="32">
            </a>

            <!-- Dropdown Menu -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="#">
                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                    Profil
                </a>

                <div class="dropdown-divider"></div>

                <a class="dropdown-item" href="../auth/logout.php">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-danger"></i>
                    Logout
                </a>
            </div>

        </li>
    </ul>

</nav>
