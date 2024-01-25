<style type="text/css">
    #map {
        width: 100%;
        height: 100vh
    }

    .leaflet-container {
        background: transparent;
    }

    .list-covid {
        height: 100vh;
        overflow-x: hidden;
    }

    .list-group-item:hover {
        cursor: pointer;
    }

    .info {
        padding: 6px 8px;
        font: 14px/16px Arial, Helvetica, sans-serif;
        background: white;
        background: rgba(255, 255, 255, 0.8);
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
        border-radius: 5px;
    }

    .info h4 {
        margin: 0 0 5px;
        color: #777;
    }

    .legend {
        text-align: left;
        line-height: 20px;
        color: #555;
    }

    .legend i {
        width: 18px;
        height: 18px;
        float: left;
        margin-right: 8px;
        opacity: 0.7;
    }


    .gps_ring {
        border: 3px solid #fb002e;
        -webkit-border-radius: 30px;
        height: 18px;
        width: 18px;
        -webkit-animation: pulsate 1s ease-out;
        -webkit-animation-iteration-count: infinite;
        /*opacity: 0.0*/
    }

    @-webkit-keyframes pulsate {
        0% {
            -webkit-transform: scale(0.1, 0.1);
            opacity: 0.0;
        }

        50% {
            opacity: 1.0;
        }

        100% {
            -webkit-transform: scale(1.2, 1.2);
            opacity: 0.0;
        }
    }

    .pulse {
        display: block;
        border-radius: 50%;
        cursor: pointer;
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0% {
            box-shadow: 0 0 0 0;
        }

        70% {
            box-shadow: 0 0 0 10px rgba(0, 0, 0, 0);
        }

        100% {
            box-shadow: 0 0 0 0 rgba(0, 0, 0, 0);
        }
    }

    .dataTables_info,
    .dataTables_paginate {
        display: none;
    }

    .marker-cluster-small {
        background-color: rgba(181, 226, 140, 0.6);
    }

    .marker-cluster-small div {
        background-color: rgba(110, 204, 57, 0.6);
    }

    .marker-cluster-medium {
        background-color: rgba(241, 211, 87, 0.6);
    }

    .marker-cluster-medium div {
        background-color: rgba(240, 194, 12, 0.6);
    }

    .marker-cluster-large {
        background-color: rgba(253, 156, 115, 0.6);
    }

    .marker-cluster-large div {
        background-color: rgba(241, 128, 23, 0.6);
    }

    /* IE 6-8 fallback colors */
    .leaflet-oldie .marker-cluster-small {
        background-color: rgb(181, 226, 140);
    }

    .leaflet-oldie .marker-cluster-small div {
        background-color: rgb(110, 204, 57);
    }

    .leaflet-oldie .marker-cluster-medium {
        background-color: rgb(241, 211, 87);
    }

    .leaflet-oldie .marker-cluster-medium div {
        background-color: rgb(240, 194, 12);
    }

    .leaflet-oldie .marker-cluster-large {
        background-color: rgb(253, 156, 115);
    }

    .leaflet-oldie .marker-cluster-large div {
        background-color: rgb(241, 128, 23);
    }

    .marker-cluster {
        background-clip: padding-box;
        border-radius: 25px;
    }

    .marker-cluster div {
        width: 40px;
        height: 40px;
        margin-left: 1px;
        margin-top: 1px;

        text-align: center;
        vertical-align: middle;
        border-radius: 25px;
        font: 12px "Helvetica Neue", Arial, Helvetica, sans-serif;
    }

    .marker-cluster span {
        line-height: 40px;
    }
</style>

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
        <div class="card h-100 overflow-hidden">
            <div class="bg-primary bg-soft">
                <div class="row">
                    <div class="col-7">
                        <div class="text-primary p-3">
                            <h5 class="text-primary">Welcome Back !</h5>
                            <p class="font-weight-bold"><?= $this->session->userdata('nama'); ?></p>
                        </div>
                    </div>
                    <div class="col-5 align-self-end">
                        <img src="<?= isset($small_logo) ? $small_logo : ''; ?>" alt="" class="img-fluid">
                    </div>
                </div>
            </div>
            <div class="card-body ">
                <div class="">
                    <h4 class="alert alert-info mt-2 p-2"> Tabel Capaian CALEG </h4>
                    <div class="">

                        <table width="90%" class="table table-hovern p-2" id="table_caleg_rank" data-source="table_caleg_rank">
                            <thead>
                                <tr>

                                    <th width="5%">#</th>
                                    <th width="50%">Nama CALEG</th>
                                    <th width="40%">Jumlah Anggota</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>



    </div>
    <div class="col-xl-8">
        <div class="row">
            <div id="countDown" class="alert alert-info ">
                <span class="fw-bold" id="cdDay"> 0 </span> hari <span class="fw-bold" id="cdHour"> 0 </span> Jam <span class="fw-bold" id="cdMinute"> 0 </span> Menit <span class="fw-bold" id="cdSecond"> 0 </span> detik Menuju <span class="fw-bold"> PEMILIHAN UMUM </span>
            </div>
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
                                        <i class="bx bx-male font-size-24"></i>
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
                                        <i class="bx bx-female font-size-24"></i>
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
                                        <i class="bx bx-user-circle font-size-24"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->

        <div class="card h-100 ">
            <div class="card-body">

                <div class="">
                    <h4 class="card-title mb-2">#TOP-10 Capaian Caleg </h4> <span> Per tanggal: <span id="lastUpdate"> 00-00-0000 </span> </span>
                    <div class="ms-auto mt-3">
                        <canvas class="" id="chart"></canvas>
                    </div>
                </div>
            </div>
        </div>

    </div>


</div>

<div class="col-12">
    <div class="card">
        <div class="card-header">
            <div class="card-title">Peta Sebaran Anggota</div>
        </div>
        <div class="card-body">
            <div class="card mb-3">
                <div class="card-header">
                    <div class="fw-bold"> <span class="btn btn-primary" data-bs-toggle="collapse" href="#collapseFilter" aria-expanded="true" aria-controls="collapseFilter">Filter Data Peta</span>

                    </div>
                </div>
                <div class="card-body collapse" id="collapseFilter">
                    <form action="#" method="post" id="form_filter_map" accept-charset="utf-8">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-0 ">
                                    <label for="filter_caleg_id" class="col-md-6 col-form-label">CALEG</label>
                                    <div class="col-md-8">
                                        <select class="form-control" name="filter_caleg_id" id="filter_caleg_id">
                                            <option value="">--</option>

                                        </select>

                                        <span class="help-block"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-0 ">
                                    <label for="filter_dapil_id" class="col-md-6 col-form-label">DAPIL</label>
                                    <div class="col-md-8">
                                        <select class="form-control" name="filter_dapil_id" id="filter_dapil_id">
                                            <option value="">--</option>

                                        </select>

                                        <span class="help-block"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-0 ">
                                    <label for="filter_propinsi" class="col-md-6 col-form-label">Propinsi</label>
                                    <div class="col-md-8">
                                        <select class="form-control" name="filter_propinsi" id="filter_propinsi">
                                            <option value="">--</option>

                                        </select>

                                        <span class="help-block"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-0 ">
                                    <label for="filter_kabupaten" class="col-md-6 col-form-label">Kabupaten/Kota</label>
                                    <div class="col-md-8">
                                        <select class="form-control" name="filter_kabupaten" id="filter_kabupaten">
                                            <option value="">--</option>

                                        </select>

                                        <span class="help-block"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-0 ">
                                    <label for="filter_kecamatan_id" class="col-md-6 col-form-label">Kecamatan</label>
                                    <div class="col-md-8">
                                        <select class="form-control" name="filter_kecamatan" id="filter_kecamatan">
                                            <option value="">--</option>

                                        </select>

                                        <span class="help-block"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-0 ">
                                    <label for="filter_kelurahan_id" class="col-md-6 col-form-label">Kelurahan</label>
                                    <div class="col-md-8">
                                        <select class="form-control" name="filter_kelurahan" id="filter_kelurahan">
                                            <option value="">--</option>

                                        </select>

                                        <span class="help-block"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-0 ">
                                    <label for="filter_relawan_id" class="col-md-6 col-form-label">Koordinator Relawan</label>
                                    <div class="col-md-8">
                                        <select class="form-control" name="filter_relawan_id" id="filter_relawan_id">
                                            <option value="">--</option>

                                        </select>

                                        <span class="help-block"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-0 ">
                                    <label for="filter_usia_anggota" class="col-md-6 col-form-label">Usia Calon Pemilih</label>
                                    <div class="col-md-8">
                                        <select class="form-control" name="filter_usia_anggota" id="filter_usia_anggota">
                                            <option value="">--</option>
                                            <option value="1720">17 - 20</option>
                                            <option value="2130">21 - 30</option>
                                            <option value="3140">31 - 40</option>
                                            <option value="4150">41 - 50</option>
                                            <option value="5160">51 - 60</option>
                                            <option value="61"> > 61 </option>


                                        </select>

                                        <span class="help-block"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-0 ">
                                    <label for="filter_gender_anggota" class="col-md-6 col-form-label">Gender</label>
                                    <div class="col-md-8">
                                        <select class="form-control" name="filter_gender_anggota" id="filter_gender_anggota">
                                            <option value="">--</option>
                                            <option value="pria">PRIA</option>
                                            <option value="wanita">WANITA</option>
                                        </select>

                                        <span class="help-block"></span>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>

                <div class="card-footer">
                    <div class="btn btn-sm btn-success  float-end refreshMap"> <i class="fas fa-search-location px-1"> </i>Terapkan Filter </div>
                    <div class="btn btn-sm btn-danger  float-end resetMap mx-2"> <i class="fas fa-sync px-1"> </i>Reset Filter </div>

                </div>

            </div>
            <div class="peta map" id="map" width="auto" height="300px"></div>
        </div>

    </div>
</div>