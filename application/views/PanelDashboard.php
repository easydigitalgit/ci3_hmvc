<!doctype html>
<html lang="en">

<head>
    <base href="<?= base_url(''); ?>">
    <meta charset="utf-8" />
    <title>Dashboard |BANGKIT BERSAMA UNTUK MENANG </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Relawan" name="description" />
    <meta content="EasyDigital" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="<?= base_url(''); ?>">

    <!-- Bootstrap Css -->
    <link href="vendor/assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="vendor/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="vendor/assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
    <link href="vendor/plugin/sweetalert/sweetalert2.min.css" rel="stylesheet" type="text/css" />
   
    <script src="vendor/assets/libs/jquery/jquery.min.js"></script>
    <?php echo isset($pcss) ? $pcss : ''; ?>
    <?php echo isset($libcss) ? $libcss : ''; ?>

    <script type="text/javascript">
        var base_url = '<?php echo base_url(); ?>';
        var site_url = '<?php echo site_url(); ?>';
        var class_url = '<?php echo currentClass(); ?>';
        var methodUrl = '<?php echo currentMethod(); ?>';
        var currentClass = site_url + class_url + '/';

        $.fn.exists = function(callback) {
            if (this.length) {
                var args = [].slice.call(arguments, 1);
                callback.call(this, args);
            }
            return this;
        };
    </script>
</head>

<body data-sidebar="dark">

    <!-- <body data-layout="horizontal" data-topbar="dark"> -->

    <!-- Begin page -->
    <div id="layout-wrapper">


        <header id="page-topbar">
            <div class="navbar-header">
                <div class="d-flex">
                    <!-- LOGO -->
                    <div class="navbar-brand-box">
                        <a href="javascript:void(0)" class="logo logo-dark">
                            <span class="logo-sm">
                                <img src="vendor/assets/images/edy-sirait-logo.png" alt="" height="45">
                            </span>
                            <span class="logo-lg">
                                <img src="vendor/assets/images/edy-sirait-logo.png" alt="" height="50">
                            </span>
                        </a>

                        <a href="javascript:void(0)" class="logo logo-light">
                            <span class="logo-sm">

                                <img src="<?= isset($small_logo) ? $small_logo : '' ;?>" alt="" height="45">
                            </span>
                            <span class="logo-lg">

                                <img src="<?= isset($full_logo) ? $full_logo : '' ;?>" alt="" height="50">
                            </span>
                        </a>
                    </div>

                    <button type="button" class="btn btn-sm px-3 font-size-16 header-item waves-effect" id="vertical-menu-btn">
                        <i class="fa fa-fw fa-bars"></i>
                    </button>
                </div>

                 <div class="d-flex">

                    <div class="dropdown d-inline-block d-lg-none ms-2">
                        <button type="button" class="btn header-item noti-icon waves-effect" id="page-header-search-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="mdi mdi-magnify"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0" aria-labelledby="page-header-search-dropdown">

                            <form class="p-3">
                                <div class="form-group m-0">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Search ..." aria-label="Recipient's username">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="submit"><i class="mdi mdi-magnify"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="dropdown d-none d-lg-inline-block ms-1">
                        <button type="button" class="btn header-item noti-icon waves-effect" data-bs-toggle="fullscreen">
                            <i class="bx bx-fullscreen"></i>
                        </button>
                    </div>

                    <div class="dropdown d-inline-block">
                        <button type="button" class="btn header-item noti-icon waves-effect" id="page-header-notifications-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="bx bx-bell bx-tada"></i>
                            <span class="badge bg-danger rounded-pill"></span>
                        </button>


                    <div class="dropdown d-inline-block">
                        <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img class="rounded-circle header-profile-user" src="vendor/assets/images/user-admin.png" alt="Header Avatar">
                            <span class="d-none d-xl-inline-block ms-1" key="t-henry"><?php echo
                                                                                        $this->session->userdata('username'); ?></span>
                            <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end">
                            <!-- item-->
                            <a class="dropdown-item" href="#"><i class="bx bx-user font-size-16 align-middle me-1"></i> <span key="t-profile">Profile</span></a>
      
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item text-danger" href="<?= site_url('auth/Login/logout'); ?>" class="waves-effect"><i class="bx bx-power-off font-size-16 align-middle me-1 text-danger"></i> <span key="t-logout">Logout</span></a>
                        </div>
                    </div>

                    <div class="dropdown d-inline-block">
                        <button type="button" class="btn header-item noti-icon right-bar-toggle waves-effect">
                            <i class="bx bx-cog bx-spin"></i>
                        </button>
                    </div>

                </div>
            </div>
        </header>
        
        <!-- ========== Left Sidebar Start ========== -->
        <?php isset($menu) ? $this->load->view($menu) : ''; ?>

        <!-- Left Sidebar End -->



        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">

            <div class="page-content">
                <div class="container-fluid">
                    <?php isset($konten) ? $this->load->view($konten) : ''; ?>
                </div>


            </div>
        </div>
        <!-- End Page-content -->

        <!-- Transaction Modal -->

        <!-- end modal -->

        <!-- subscribeModal -->

        <!-- end modal -->

        <footer class="footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <script>
                            document.write(new Date().getFullYear())
                        </script> © Aplikasi E-Caleg.
                    </div>
                    <div class="col-sm-6">
                        <div class="text-sm-end d-none d-sm-block">
                            Design & Develop by <a href="https://easydigital.id" title=""> EasyDigital </a>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>
    <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->

    <!-- Right Sidebar -->

    <!-- /Right-bar -->

    <!-- Right bar overlay-->

    <!-- JAVASCRIPT -->

    <script src="vendor/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/assets/libs/metismenu/metisMenu.min.js"></script>
    <script src="vendor/assets/libs/simplebar/simplebar.min.js"></script>
    <script src="vendor/assets/libs/node-waves/waves.min.js"></script>
    <script src="vendor/plugin/sweetalert/sweetalert2.all.min.js"></script>
    <!-- App js -->
    <script src="vendor/assets/js/app.js"></script>
    

    <?php echo isset($pjs) ? $pjs : ''; ?>
    <?php echo isset($libjs) ? $libjs : ''; ?>
</body>

</html>
