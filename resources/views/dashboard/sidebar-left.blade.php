  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?= $title == 'dashboard' ? 'javascript:void(0)' : route('dashboard') ?>" class="brand-link">
      <x-application-logo class="brand-image img-fluid elevation-3" />
      <span class="brand-text font-weight-light">Logo</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar os-host os-theme-light os-host-resize-disabled os-host-transition os-host-overflow os-host-overflow-y os-host-overflow-x">

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column nav-collapse-hide-child" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="<?= $hal == 'dashboard/index' ? 'javascript:void(0)' : route('dashboard') ?>" class="nav-link <?= $hal == 'dashboard/index' ? 'active' : '' ?>">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>

          @if(Auth::user()->is_admin)
            <li class="nav-item">
              <a href="<?= $hal == 'class/index' ? 'javascript:void(0)' : route('class') ?>" class="nav-link <?= $hal == 'class/index' ? 'active' : '' ?>">
                <i class="nav-icon fas fa-chalkboard"></i>
                <p>
                  Kelas
                </p>
              </a>
            </li>

            <li class="nav-item">
              <a href="<?= $hal == 'users/index' ? 'javascript:void(0)' : route('users') ?>" class="nav-link <?= $hal == 'users/index' ? 'active' : '' ?>">
                <i class="nav-icon fas fa-users"></i>
                <p>
                  Pengguna
                </p>
              </a>
            </li>

            <li class="nav-item">
              <a href="<?= $hal == 'siswa/index' ? 'javascript:void(0)' : route('siswa') ?>" class="nav-link <?= $hal == 'siswa/index' ? 'active' : '' ?>">
                <i class="nav-icon fas fa-school"></i>
                <p>
                  Siswa
                </p>
              </a>
            </li>

            <li class="nav-item">
              <a href="<?= $hal == 'pembelian/list' ? 'javascript:void(0)' : route('pembelian') ?>" class="nav-link <?= $hal == 'pembelian/list' ? 'active' : '' ?>">
                <i class="nav-icon fas fa-history"></i>
                <p>
                  Histori Pembelian
                </p>
              </a>
            </li>

          @endif

          @if (Auth::user()->is_siswa)
          <li class="nav-item">
            <a href="<?= $hal == 'kelas/index' ? 'javascript:void(0)' : route('kelas') ?>" class="nav-link <?= $hal == 'kelas/index' ? 'active' : '' ?>">
              <i class="nav-icon fas fa-chalkboard"></i>
              <p>
                Kelas
              </p>
            </a>
          </li>
          @endif

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>