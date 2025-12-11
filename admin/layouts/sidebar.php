 <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

     <!-- Sidebar - Brand -->
     <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
         <div class="sidebar-brand-icon rotate-n-15">
             <i class="fas fa-laugh-wink"></i>
         </div>
         <div class="sidebar-brand-text mx-3">SB Admin <sup>2</sup></div>
     </a>

     <!-- Divider -->
     <hr class="sidebar-divider my-0">

     <!-- Nav Item - Dashboard -->
     <li class="nav-item active">
         <a class="nav-link" href="dashboard.php">
             <i class="fas fa-fw fa-tachometer-alt"></i>
             <span>Dashboard</span></a>
     </li>

     <!-- Divider -->
     <hr class="sidebar-divider">

     <!-- Heading -->
     <div class="sidebar-heading">
         PERUSAHAAN
     </div>

     <!-- Nav Item - Pages Collapse Menu -->
     <li class="nav-item">
         <a class="nav-link collapsed" href="data_perusahaan.php" data-toggle="collapse" data-target="#collapseTwo"
             aria-expanded="true" aria-controls="collapseTwo">
             <i class="fas fa-fw fa-cog"></i>
             <span>Perusahaan</span>
         </a>
         <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
             <div class="bg-white py-2 collapse-inner rounded">
                 <a class="collapse-item" href="data_perusahaan.php">Data Perusahaan</a>
             </div>
         </div>
     </li>

     <!-- Nav Item - Utilities Collapse Menu -->
     <li class="nav-item">
         <a class="nav-link collapsed" href="data_pengajuan.php" data-toggle="collapse" data-target="#collapseUtilities"
             aria-expanded="true" aria-controls="collapseUtilities">
             <i class="fas fa-fw fa-map"></i>
             <span>Pengajuan Denah</span>
         </a>
         <?php
            if (isset($admin['role']) && $admin['role'] === 'petugas'):
            ?>
             <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
                 data-parent="#accordionSidebar">
                 <div class="bg-white py-2 collapse-inner rounded">
                     <a class="collapse-item" href="data_disopsisi.php">Data Pengajuan</a>
                 </div>
             </div>
         <?php
            else:
            ?>
             <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
                 data-parent="#accordionSidebar">
                 <div class="bg-white py-2 collapse-inner rounded">
                     <a class="collapse-item" href="data_pengajuan.php">Data Pengajuan</a>
                 </div>
             </div>
         <?php
            endif;
            ?>

     </li>

     <!-- Divider -->
     <hr class="sidebar-divider">

     <?php
        if (isset($admin['role']) && $admin['role'] === 'superadmin'):
        ?>
         <!-- Heading -->
         <div class="sidebar-heading">
             Setting
         </div>

         <!-- Nav Item - Pages Collapse Menu -->

         <li class="nav-item">
             <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
                 aria-expanded="true" aria-controls="collapsePages">
                 <i class="fas fa-fw fa-folder"></i>
                 <span>Pengguna</span>
             </a>
             <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                 <div class="bg-white py-2 collapse-inner rounded">
                     <h6 class="collapse-header">Setting Pengguna</h6>
                     <!-- <a class="collapse-item" href="login.html">Login</a> -->
                     <a class="collapse-item" href="data_pengguna.php">Data Pengguna</a>

                 </div>
             </div>
         </li>
     <?php
        endif;
        ?>
 </ul>