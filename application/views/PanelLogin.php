<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <title>Login | <?= isset($ptitle) ? $ptitle : ''; ?> </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Bangkit Bersama Menuju Kemenangan 2024" name="description" />
    <meta content="EasyDigital" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="<?= base_url(''); ?>vendor/assets/images/favicon.ico">

    <!-- Bootstrap Css -->
    <link href="<?= base_url(''); ?>vendor/assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="<?= base_url(''); ?>vendor/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="<?= base_url(''); ?>vendor/assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url('vendor/plugin/sweetalert/sweetalert2.min.css'); ?>" rel="stylesheet">
    <?php echo isset($pcss) ? $pcss : ''; ?>
    <?php echo isset($libcss) ? $libcss : ''; ?>
    <script src="<?= base_url(''); ?>vendor/assets/libs/jquery/jquery.min.js"></script>
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

<body>
    <div class="account-pages my-5 pt-sm-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card overflow-hidden">
                        <div class="bg-white">
                            <div class="row">
                                <div class="col-7">
                                    <div class="text-primary p-4">
                                        <h5 class="text-primary">Admin Login</h5>
                                        <p>Sign in to continue.</p>
                                    </div>
                                </div>
                                <div class="col-5 align-self-end">
                                    <img src="<?= base_url('vendor/assets/images/') . $login_logo; ?>" alt="" class="img-fluid">
                                </div>
                            </div>
                        </div>
                        <div class="card-body pt-0">

                            <div class="p-2">
                                <form class="form-horizontal" action="#" method="post" id="formLogin" name="formLogin">

                                    <div class="mb-3">
                                        <label for="username" class="form-label">Username</label>
                                        <input type="text" class="form-control" id="username" name="username" placeholder="Enter username">
                                        <div class="help-block"></div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Password</label>
                                        <div class="input-group auth-pass-inputgroup">
                                            <input type="password" class="form-control" placeholder="Enter password" aria-label="Password" id="password" name="password" aria-describedby="password-addon">
                                            <button class="btn btn-light " type="button" id="password-addon"><i class="mdi mdi-eye-outline"></i></button>
                                        </div>
                                        <div class="help-block"></div>
                                    </div>
                                    <div id="loginAlert" class="form-label">

                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="remember-check">
                                        <label class="form-check-label" for="remember-check">
                                            Remember me
                                        </label>
                                    </div>

                                    <div class="mt-3 d-grid">
                                        <button class="btn btn-primary waves-effect waves-light" id="btnLogin">Log In</button>
                                    </div>



                                    <div class="mt-4 text-center">
                                        <a href="<?= base_url('auth/forgot_password'); ?>" class="text-muted"><i class="mdi mdi-lock me-1"></i> Forgot your password?</a>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                    <div class="mt-5 text-center">

                        <div>

                            <p>© <script>
                                    document.write(new Date().getFullYear())
                                </script> Aplikasi Ecaleg. Crafted with <i class="mdi mdi-heart text-danger"></i> by EasyDigital</p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- end account-pages -->

    <!-- JAVASCRIPT -->

    <script src="<?= base_url(''); ?>vendor/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url(''); ?>vendor/assets/libs/metismenu/metisMenu.min.js"></script>
    <script src="<?= base_url(''); ?>vendor/assets/libs/simplebar/simplebar.min.js"></script>
    <script src="<?= base_url(''); ?>vendor/assets/libs/node-waves/waves.min.js"></script>

    <!-- App js -->
    <script src="<?= base_url(''); ?>vendor/assets/js/app.js"></script>
    <script src="<?= base_url('vendor/plugin/sweetalert/sweetalert2.min.js'); ?>"></script>

    <?php echo isset($pjs) ? $pjs : ''; ?>

    <?php echo isset($libjs) ? $libjs : ''; ?>
</body>

</html>
