<div class="card">
    <div class="card-header">
        <div class="card-title">
            <h4> Tabel Data Daerah Pemilihan (DAPIL) </h4>

        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <div class="py-2">
                <?php echo isset($headDataDapil) ? $headDataDapil : ''; ?>

            </div>
            <table width="100%" class="table table-hover" id="table_data_dapil" data-source="table_data_dapil">
                <thead>
                    <tr>
                        <th style="width: 3%"><input type="checkbox" id="check-all"></th>
                        <th width="5%">#</th>

                        <th width="10%">TINGKAT</th>
                        <th width="15%">NAMA DAPIL</th>
                        <th width="10%">JUMLAH DPT / TPS</th>

                        <th width="15%">KETERANGAN</th>


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
<div class="modal  fade" id="modal_data_dapil">
    <div class="modal-dialog  modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-title" name="modal-title">Form Data DAPIL </h5>
                <div class="btn close fs-3" data-bs-dismiss="modal">
                    <i class="bx bxs-x-circle"></i>
                </div>
            </div>
            <div class="modal-body">

                <form action="#" id="form_data_dapil" name="form_data_dapil" method="post" accept-charset="utf-8">
                    <input type="hidden" name="id" id="id">
                    <div class="mb-3 row">
                        <label for="tingkat_pemilihan_id" class="col-md-2 col-form-label">Tingkat Pemilihan</label>
                        <div class="col-md-10">
                            <select class="form-control selectAkunID" id="tingkat_pemilihan_id" name="tingkat_pemilihan_id">
                                <option value="--PILIH--"></option>
                                <option value="1">DPR RI</option>
                                <option value="2">DPR PROPINSI</option>
                                <option value="3">DPR KABUPATEN/KOTA</option>

                            </select>
                            <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="nama_dapil" class="col-md-2 col-form-label">Nama DAPIL</label>
                        <div class="col-md-10">
                            <input class="form-control" type="text" value="" id="nama_dapil" name="nama_dapil" placeholder="cth; SUMUT1-DPRRI">
                            <span class="help-block"></span>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3 row">
                                <label for="jumlah_dpt" class="col-md-4 col-form-label">Jumlah DPT</label>
                                <div class="col-md-8">
                                    <input class="form-control" type="text" value="" id="jumlah_dpt" name="jumlah_dpt">
                                    <span class="help-block"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3 row">
                                <label for="jumlah_tps" class="col-md-4 col-form-label">Jumlah TPS</label>
                                <div class="col-md-8">
                                    <input class="form-control" type="text" value="" id="jumlah_tps" name="jumlah_tps">
                                    <span class="help-block"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="keterangan" class="col-md-2 col-form-label">Keterangan</label>
                        <div class="col-md-10">
                            <textarea class="form-control" id="keterangan" name="keterangan" placeholder="cth; sesuai data KPU pada pemilu 2019">  </textarea>
                            <span class="help-block"></span>
                        </div>
                    </div>



                    <hr>
                    <p class="alert alert-secondary fw-bold">Daerah Pemilihan (DAPIL)</p>

                    <div class="mb-3 row">
                        <label for="prop_dapil" class="col-md-2 col-form-label">Propinsi</label>
                        <div class="col-md-10 ">
                            <select class="form-control" name="prop_dapil" id="prop_dapil">
                                <option value=""></option>

                            </select>

                            <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="kab_dapil" class="col-md-2 col-form-label">Kabupaten / Kota</label>
                        <div class="col-md-10 ">

                            <select class="form-control SelectKabDapil" name="kab_dapil[]" id="kab_dapil" multiple="multiple">
                                <option value=""></option>

                            </select>

                            <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="mb-3 row kecamatanDapil">
                        <label for="kec_dapil" class="col-md-2 col-form-label">Kecamatan</label>
                        <div class="col-md-10 KecDapil">
                            <input type="hidden" name="kec_dapil[]" id="kec_dapil">
                            <div class="form-control" id="kecamatandapil">

                            </div>

                            <span class="help-block"></span>
                        </div>
                    </div>



                </form>
            </div> <!-- modal body -->

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary SaveBtn" data-label="data_dapil" id="btnSave">Simpan</button>
            </div>


        </div> <!-- modal content -->
    </div>
</div> <!-- modal -->