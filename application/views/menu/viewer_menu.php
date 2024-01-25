<div class="vertical-menu">

                <div data-simplebar class="h-100">

                    <!--- Sidemenu -->
                    <div id="sidebar-menu">
                        <!-- Left Menu Start -->
                        <ul class="metismenu list-unstyled" id="side-menu">
                            <li class="menu-title" key="t-menu">Menu</li>

                              <li>
                                <a href="<?= site_url('admin/Dashboard/index');?>" class="waves-effect">
                                    <i class="bx bx-home-circle"></i>
                                    <span key="t-dashboards">Dashboard</span>
                                </a>
                            </li>

                           



                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="bx bx-task"></i>
                                    <span key="t-tasks">Laporan</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li><a href="<?= site_url('');?>" key="t-task-list">Laporan Pendaftar</a></li>
                                    <li><a href="<?= site_url('');?>" key="t-task-list">Laporan Hasil Tes</a></li>
                                    <li><a href="<?= site_url('');?>" key="t-kanban-board">Laporan Penerimaan</a></li>
                                   
                                </ul>
                            </li>

                            
                            
                            <li>
                                <a href="<?= site_url('auth/Login/logout');?>" class="waves-effect">
                                    <i class="bx bx-log-out"></i>
                                    <span key="t-dashboards">Logout</span>
                                </a>
                            </li>

                        </ul>
                    </div>
                    <!-- Sidebar -->
                </div>
            </div>