<style type="text/css">
    #map {
        width: 100%;
        height: 30vh;
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

    .image-preview {
        display: flex;
        flex-wrap: wrap;
    }

    .image-preview img {
        width: 100px;
        height: 100px;
        object-fit: cover;
        margin: 5px;
    }

    .btn-delete {
        margin-top: 10px;
    }
</style>


<div class="card">
    <div class="card-header">
        <div class="card-title">
            <h4> Tabel Data Agenda Kegiatan Caleg </h4>

        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <div class="py-2">
                <?php echo isset($headTableAgenda) ? $headTableAgenda : ''; ?>

            </div>
            <table width="100%" class="table table-hover" id="table_data_agenda" data-source="table_data_agenda">
                <thead>
                    <tr>
                        <th style="width: 3%"><input type="checkbox" id="check-all"></th>
                        <th width="5%">#</th>

                        <th width="10%">Nama Agenda</th>
                        <th width="15%">Deskripsi</th>
                        <th width="15%">Tanggal </th>
                        <th width="15%">Tempat</th>
                        <th width="15%">Status</th>


                        <th width="15%">Aksi</th>

                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>

</div>


<!-- Modal -->
<div class="modal  fade" id="modal_data_agenda">
    <div class="modal-dialog  modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-title" name="modal-title">Form Data Agenda Kegiatan CALEG </h5>
                <div class="btn close fs-3" data-bs-dismiss="modal">
                    <i class="bx bxs-x-circle"></i>
                </div>
            </div>
            <div class="modal-body">

                <form action="#" id="form_data_agenda" name="form_data_agenda" method="post" accept-charset="utf-8">
                    <input type="hidden" name="id" id="id">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3 row">
                                <label for="caleg_akun_id" class="col-md-4 col-form-label">Nama Caleg</label>
                                <div class="col-md-8 ">
                                    <select class="form-control" name="caleg_akun_id" id="caleg_akun_id">
                                        <option value=""></option>

                                    </select>

                                    <span class="help-block"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3 row">
                                <label for="jenis_agenda_id" class="col-md-4 col-form-label">Jenis Agenda </label>
                                <div class="col-md-8 ">

                                    <select class="form-control" name="jenis_agenda_id" id="jenis_agenda_id">
                                        <option value=""></option>

                                    </select>

                                    <span class="help-block"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="nama_agenda" class="col-md-2 col-form-label">Nama Agenda</label>
                        <div class="col-md-10">
                            <input class="form-control" type="text" value="" id="nama_agenda" name="nama_agenda" placeholder="cth; Operasi Pasar Murah">
                            <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="deskripsi" class="col-md-2 col-form-label">Deskripsi</label>
                        <div class="col-md-10">
                            <textarea class="form-control" type="text" value="" id="deskripsi" name="deskripsi" placeholder="cth; Operasi Pasar sembako murah untuk 150 paket di desa Tambak Rejo "></textarea>
                            <span class="help-block"></span>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3 row">
                                <label for="waktu" class="col-md-4 col-form-label">Waktu</label>
                                <div class="col-md-8">
                                    <input class="form-control dateTimePicker" type="text" value="" id="waktu" name="waktu">
                                    <span class="help-block"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3 row">
                                <label for="jumlah_tps" class="col-md-4 col-form-label">Tempat</label>
                                <div class="col-md-8">
                                    <input class="form-control" type="text" value="" id="tempat" name="tempat">
                                    <span class="help-block"></span>
                                </div>
                            </div>
                        </div>
                    </div>





                    <hr>
                    <p class="alert alert-secondary fw-bold">Detail Lokasi</p>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3 row">
                                <label for="prop_kode" class="col-md-4 col-form-label">Propinsi</label>
                                <div class="col-md-8 ">
                                    <select class="form-control" name="prop_kode" id="prop_kode">
                                        <option value=""></option>

                                    </select>

                                    <span class="help-block"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3 row">
                                <label for="kab_kode" class="col-md-4 col-form-label">Kabupaten / Kota</label>
                                <div class="col-md-8 ">

                                    <select class="form-control SelectKabDapil" name="kab_kode" id="kab_kode">
                                        <option value=""></option>

                                    </select>

                                    <span class="help-block"></span>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3 row kecamatanAgenda">
                                <label for="Kecamatan" class="col-md-4 col-form-label">Kecamatan</label>
                                <div class="col-md-8 KecDapil">
                                    <select class="form-control SelectKabDapil" name="kec_kode" id="kec_kode">
                                        <option value=""></option>

                                    </select>


                                    <span class="help-block"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3 row kecamatanAgenda">
                                <label for="Kecamatan" class="col-md-4 col-form-label">Kelurahan / Desa</label>
                                <div class="col-md-8 KecDapil">
                                    <select class="form-control SelectKabDapil" name="desa_kode" id="desa_kode">
                                        <option value=""></option>

                                    </select>


                                    <span class="help-block"></span>
                                </div>
                            </div>
                        </div>


                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="lokasiDevice">
                                <div class="btn btn-primary getLokasi"> <i class='bx bx-map'></i> gunakan lokasi device saat ini

                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <textarea class="mapResult form-control" rows="3" readonly="" name="pin_description"></textarea>
                            <input type="text" class="d-none" name="pin_lat" id="pin_lat">
                            <input type="text" class="d-none" name="pin_long" id="pin_long">
                        </div>

                    </div>

                    <hr>
                    <div class="text-center"> atau pilih pada peta

                    </div>
                    <div class="col-10" id="map">

                    </div>
                </form>
            </div> <!-- modal body -->

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary SaveBtn" data-label="data_agenda" id="btnSave">Simpan</button>
            </div>


        </div> <!-- modal content -->
    </div>
</div> <!-- modal -->



<!-- Modal Laporan -->
<div class="modal  fade" id="modal_data_laporan_agenda">
    <div class="modal-dialog  modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-title" name="modal-title">Form Data Laporan Agenda Kegiatan CALEG </h5>
                <div class="btn close fs-3" data-bs-dismiss="modal">
                    <i class="bx bxs-x-circle"></i>
                </div>
            </div>
            <div class="modal-body">

                <form action="#" id="form_data_laporan_agenda" name="form_data_laporan_agenda" method="post" accept-charset="utf-8">
                    <input type="hidden" name="id" value="">
                    <div class="mb-3 ">
                        <label for="nama_caleg" class="col-md-4 col-form-label">Nama Caleg</label>
                        <div class="col-md-8 ">
                            <input type="text" class="form-control" name="nama_caleg" id="nama_caleg">

                            <span class="help-block"></span>
                        </div>
                    </div>
                    <div class="row">

                        <div class="col-md-12">
                            <div class="mb-3 ">
                                <label for="ringkasan_agenda" class="col-md-2 col-form-label">Ringkasan Agenda </label>
                                <div class="col-md-12 ">
                                    <textarea class="form-control" name="ringkasan_agenda" id="ringkasan_agenda"></textarea>



                                    <span class="help-block"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>
                    <p class="alert alert-secondary fw-bold">Hasil Kegiatan</p>
                    <div class="mb-3 col-md-6">
                        <label for="status_agenda" class="col-md-6 col-form-label">Status Pelaksanaan</label>
                        <select class="form-control col-md-6" name="status_agenda" id="status_agenda">
                            <option value="">--Pilih--</option>
                            <option value="terlaksana">Terlaksana</option>
                            <option value="dibatalkan">Dibatalkan</option>
                        </select>

                    </div>
                    <div clas="mb-3">
                        <label for="catatan_hasil_kegiatan" class="col-md-2 col-form-label">Catatan Hasil Kegiatan </label>
                        <textarea class="form-control" id="catatan_kegiatan" name="catatan_kegiatan"> </textarea>
                    </div>

                    <div class="mb-3 col-md-6">
                        <label for="lampiran" class="col-md-2 col-form-label">Lampiran Foto </label>
                        <div id="inputFile">
                            <input type="file" class="form-control" name="lampiran" id="lampiran" accept="image/*">

                        </div>


                    </div>

                    <div class="container">
                        <ul class="row list-unstyled imgUpload" style="height: 150px;">

                        </ul>
                    </div>




                </form>
            </div> <!-- modal body -->

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary SaveBtn" data-label="data_laporan_agenda" id="btnSave">Simpan</button>
            </div>


        </div> <!-- modal content -->
    </div>
</div> <!-- modal -->