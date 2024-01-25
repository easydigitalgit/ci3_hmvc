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
                    <a href="<?= site_url('admin/Caleg/index'); ?>" class="waves-effect">
                        <i class="bx bxs-user-voice"></i>
                        <span key="t-dashboards">Caleg</span>
                    </a>
                </li>
                <li>
                    <a href="<?= site_url('admin/Koordinator/index'); ?>" class="waves-effect">
                        <i class="bx bxs-user-voice"></i>
                        <span key="t-dashboards">Admin Entry</span>
                    </a>
                </li>
                <li>
                    <a href="<?= site_url('admin/Relawan/index'); ?>" class="waves-effect">
                        <i class="bx bx-sitemap"></i>
                        <span key="t-dashboards">Koord. Relawan</span>
                    </a>
                </li>
                <li>
                    <a href="<?= site_url('admin/Anggota/index'); ?>" class="waves-effect">
                        <i class="bx bx-group"></i>
                        <span key="t-dashboards">Data Anggota</span>
                    </a>
                </li>

                <li>
                    <a href="<?= site_url('admin/Relawantps/index'); ?>" class="waves-effect">
                        <i class="bx bx-cube"></i>
                        <span key="t-dashboards">Relawan TPS</span>
                    </a>
                </li>

                <li>
                    <a href="<?= site_url('laporan/Laporan/index'); ?>" class="waves-effect">
                        <i class="bx bx-receipt"></i>
                        <span key="t-dashboards">Laporan</span>
                    </a>
                </li>


                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-calendar"></i>
                        <span key="t-ecommerce">Event</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="<?= site_url('event/Jenis_event/index'); ?>" key="t-products">Jenis Event</a></li>
                        <li><a href="<?= site_url('event/Daftar_event/index'); ?>" key="t-products">Daftar Event</a></li>
                        <li><a href="<?= site_url('event/Pesan/index'); ?>" key="t-products">Kirim Pesan</a></li>
                    </ul>
                </li>



                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-hive"></i>
                        <span key="t-crypto">Akun</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="<?= site_url('user/Akun/index'); ?>" key="t-wallet">Daftar Akun</a></li>
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