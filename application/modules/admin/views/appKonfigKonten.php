<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">Dashboard</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboards</a></li>
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </div>

        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class=" formkonfig">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        <p class="alert alert-secondary">Form Pengaturan Aplikasi</p>
                    </div>
                </div>
                <div class="card-body">
                    <form action="#" id="form_konfigurasi_apps" name="form_konfigurasi_apps" method="post" accept-charset="utf-8">
                        <input type="hidden" name="id" id="id">
                        <div class="mb-3 row">
                            <label for="akun_id" class="col-md-2 col-form-label">Judul Tab Aplikasi</label>
                            <div class="col-md-10">
                                <input type="text" class="form-control" id="judul_tab" name="judul_tab" placeholder="cth; Aplikasi Ecaleg Partai XYZ">

                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3 row">
                                    <label for="login_logo" class="col-md-4 col-form-label">Logo Halaman Login</label>
                                    <div class="col-md-8">
                                        <input class="form-control imgUpload" type="file" value="" id="loginLogo" name="loginLogo">
                                        <input type="hidden" name="login_logo" id="login_logo">
                                        <img class="loginLogo" id="imglogin_logo" src="" width="100px">
                                        <span class="help-block"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3 row">
                                    <label for="previewLogin" class="col-md-5 col-form-label">Klik tombol preview untuk melihat hasil penerapan</label>
                                    <div class="col-md-7">
                                        <div class="previewLogin btn btn-primary">Preview</div>
                                        <span class="help-block"></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3 row">
                                    <label for="default_long_menu_logo" class="col-md-4 col-form-label">Logo standar menu panjang</label>
                                    <div class="col-md-8">
                                        <input class="form-control imgUpload" type="file" value="" id="defaultLongMenuLogo" name="defaultLongMenuLogo" data-label="default_long_menu_logo">
                                        <input type="hidden" name="default_long_menu_logo" id="default_long_menu_logo">
                                        <img class="defaultLongMenuLogo" id="imgdefault_long_menu_logo" src="" width="100px">
                                        <span class="help-block"></span>
                                    </div>
                                </div>

                            </div>
                            <div class="col-md-6">
                                <div class="mb-3 row">
                                    <label for="default_small_menu_logo" class="col-md-4 col-form-label">Logo standar menu kecil </label>
                                    <div class="col-md-8">
                                        <input class="form-control imgUpload" type="file" value="" id="defaultSmallMenuLogo" name="defaultSmallMenuLogo" data-label="default_small_menu_logo">
                                        <input type="hidden" name="default_small_menu_logo" id="default_small_menu_logo">
                                        <img class="defaultSmallMenuLogo" id="imgdefault_small_menu_logo" src="" width="100px">
                                        <span class="help-block"></span>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3 row">
                                    <label for="login_logo" class="col-md-4 col-form-label">Foto Admin Standar</label>
                                    <div class="col-md-8">
                                        <input class="form-control imgUpload" type="file" value="" id="defaultAdminLogo" name="defaultAdminLogo" data-label="default_admin_logo">
                                        <input type="hidden" name="default_admin_logo" id="default_admin_logo">
                                        <img class="defaultAdminLogo" id="imgdefault_admin_logo" src="" width="100px">
                                        <span class="help-block"></span>
                                    </div>
                                </div>

                            </div>
                            <div class="col-md-6">


                            </div>
                        </div>

                    </form>
                </div>
                <div class="card-footer">

                    <button type="button" class="btn btn-primary SaveBtn" data-label="konfigurasi_apps" id="saveBtn">Simpan</button>
                </div>
            </div>


        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal  fade" id="modal_preview_login">
    <div class="modal-dialog  modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-title" name="modal-title">Preview</h5>
                <div class="btn close fs-3" data-bs-dismiss="modal">
                    <i class="bx bxs-x-circle"></i>
                </div>
            </div>
            <div class="modal-body">
                <div class="account-pages my-5 pt-sm-5">
                    <div class="container">'
                        <div class="row justify-content-center">
                            <div class="col-md-10 col-lg-10 col-xl-10">
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
                                                <img id="imgPreviewLoginLogo" src="" alt="" class="img-fluid">
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
                                                    <div class="btn btn-primary waves-effect waves-light" id="btnLogin">Log In</div>
                                                </div>



                                                <div class="mt-4 text-center">
                                                    <a href="#" class="text-muted"><i class="mdi mdi-lock me-1"></i> Forgot your password?</a>
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
            </div>
        </div>
    </div>
</div>