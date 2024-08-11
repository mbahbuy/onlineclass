<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
            <img src="/template/adminLTE/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
            <a href="javascript:void(0)" class="d-block">{{ Auth::user()->name }}</a>
        </div>
    </div>

    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-item">
                <a href="javascript:void(0)" class="nav-link">
                    <p>
                        Theme
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="javascript:void(0)" id="moon" class="nav-link active" onclick="darkMode()">
                            <i class="far fa-moon nav-icon active"></i>
                            <p>Dark mode</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="javascript:void(0)" id="sun" class="nav-link" onclick="lightMode()">
                            <i class="far fa-sun nav-icon"></i>
                            <p>Light mode</p>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item">
                <a href="<?= route('logout') ?>" class="nav-link">
                    <p>
                        Log out
                        <i class="right fas fa-right-from-bracket"></i>
                    </p>
                </a>
            </li>
        </ul>
    </nav>
</aside>
<!-- /.control-sidebar -->