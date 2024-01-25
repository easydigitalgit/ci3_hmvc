<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title" key="t-menu">Menu</li>

                <li>
                    <a href="<?= site_url('admin/Dashboard/index'); ?>" class="waves-effect">
                        <i class="bx bx-home-circle"></i>
                        <span key="t-dashboards">Dashboard</span>
                    </a>
                </li>


                <li>
                    <a href="<?= site_url('admin/Anggota/index'); ?>" class="waves-effect">
                        <i class="bx bx-group"></i>
                        <span key="t-dashboards">Data Anggota</span>
                    </a>
                </li>

               

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-hive"></i>
                        <span key="t-crypto">Akun</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="<?= site_url('auth/Ganti_password/index'); ?>" key="t-wallet">Ganti Password</a></li>
                    </ul>
                </li>

                <li>
                    <a href="<?= site_url('auth/Login/logout'); ?>" class="waves-effect">
                        <i class="bx bx-log-out"></i>
                        <span key="t-dashboards">Logout</span>
                    </a>
                </li>

            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
