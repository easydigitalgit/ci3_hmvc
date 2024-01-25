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
     <div class="col-xl-4">
         <div class="card overflow-hidden">
             <div class="bg-primary bg-soft">
                 <div class="row">
                     <div class="col-7">
                         <div class="text-primary p-3">
                             <h5 class="text-primary">Welcome Back !</h5>
                             <p class="font-weight-bold"><?= $this->session->userdata('nama'); ?></p>
                         </div>
                     </div>
                     <div class="col-5 align-self-end">
                        <img src="<?= isset($small_logo) ? $small_logo : '' ;?>" alt="" class="img-fluid">
                     </div>
                 </div>
             </div>
             <div class="card-body pt-0">

             </div>
         </div>
         
     </div>
     <div class="col-xl-8">
         <div class="row">
             <div class="col-md-4">
                 <div class="card mini-stats-wid">
                     <div class="card-body">
                         <div class="d-flex">
                             <div class="flex-grow-1">
                                 <p class="text-muted fw-medium">Anggota Pria</p>
                                 <h4 class="mb-0 anggotaPria">0</h4>
                             </div>

                             <div class="flex-shrink-0 align-self-center">
                                 <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                                     <span class="avatar-title">
                                         <i class="bx bx-copy-alt font-size-24"></i>
                                     </span>
                                 </div>
                             </div>
                         </div>
                     </div>
                 </div>
             </div>
             <div class="col-md-4">
                 <div class="card mini-stats-wid">
                     <div class="card-body">
                         <div class="d-flex">
                             <div class="flex-grow-1">
                                 <p class="text-muted fw-medium">Anggota Wanita</p>
                                 <h4 class="mb-0 anggotaWanita">0</h4>
                             </div>

                             <div class="flex-shrink-0 align-self-center ">
                                 <div class="avatar-sm rounded-circle bg-primary mini-stat-icon">
                                     <span class="avatar-title rounded-circle bg-primary">
                                         <i class="bx bx-archive-in font-size-24"></i>
                                     </span>
                                 </div>
                             </div>
                         </div>
                     </div>
                 </div>
             </div>
             <div class="col-md-4">
                 <div class="card mini-stats-wid">
                     <div class="card-body">
                         <div class="d-flex">
                             <div class="flex-grow-1">
                                 <p class="text-muted fw-medium">Total Anggota</p>
                                 <h4 class="mb-0 totalAnggota">0</h4>
                             </div>

                             <div class="flex-shrink-0 align-self-center">
                                 <div class="avatar-sm rounded-circle bg-primary mini-stat-icon">
                                     <span class="avatar-title rounded-circle bg-primary">
                                         <i class="bx bx-purchase-tag-alt font-size-24"></i>
                                     </span>
                                 </div>
                             </div>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
         <!-- end row -->

         <div class="card">
             <div class="card-body">
                 <div class="d-sm-flex flex-wrap">
                     <h4 class="card-title mb-4">Pendaftaran Anggota</h4>
                     <div class="ms-auto">
                         <ul class="nav nav-pills">
                             <li class="nav-item">
                                 <a class="nav-link" href="#">Week</a>
                             </li>
                             <li class="nav-item">
                                 <a class="nav-link" href="#">Month</a>
                             </li>
                             <li class="nav-item">
                                 <a class="nav-link active" href="#">Year</a>
                             </li>
                         </ul>
                     </div>
                 </div>

                 <div id="stacked-column-chart" class="apex-charts" dir="ltr"></div>
             </div>
         </div>
     </div>
 </div>
