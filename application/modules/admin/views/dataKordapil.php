<div class="card">
    <div class="card-header">
        <div class="card-title">
            <h4> Tabel Data Kordapil </h4>

        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <div class="py-2">
                <?php echo isset($headDataKordapil) ? $headDataKordapil : ''; ?>

            </div>
            <table width="100%" class="table table-hover" id="table_kordapil" data-source="table_kordapil">
                <thead>
                    <tr>
                        <th style="width: 3%"><input type="checkbox" id="check-all"></th>
                        <th width="5%">#</th>
                        <th width="">NIK</th>
                        <th width="">NAMA</th>
                       
                        
                        <th>DAPIL</th>
                      
                        <th>SCAN KTP</th>
                        <th>FOTO</th>

                        <th width="">Aksi</th>

                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>

</div>


<!-- Modal -->
<div class="modal  fade" id="modal_kordapil">
    <div class="modal-dialog  modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-title" name="modal-title">Form Data Kordapil </h5>
                <div  class="btn close fs-3" data-bs-dismiss="modal">
                    <i class="bx bxs-x-circle"></i>
                </div>
            </div>
            <div class="modal-body">

                <form action="#" id="form_kordapil" name="form_kordapil" method="post" accept-charset="utf-8">
                    <input type="hidden" name="id" id="id">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3 row">
                                <label for="caleg_akun_id" class="col-md-4 col-form-label">Nama Kordapil</label>
                                <div class="col-md-8">
                                    <select class="form-control selectKordapil"  id="kordapil_akun_id" name="kordapil_akun_id" > 
                                        <option value="">--PILIH--</option>

                                    </select> 
                                    <span class="help-block"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3 row">
                                <label for="dapil_id" class="col-md-4 col-form-label">DAERAH PEMILIHAN (DAPIL)</label>
                                <div class="col-md-8 ">
                                    <select class="form-control" name="dapil_id" id="dapil_id">
                                        <option value=""></option>
                                        
                                    </select>
                                    
                                    <span class="help-block"></span>
                                </div>
                             </div>
                        </div>
                    </div>

                     <div class="row">
                        
                        <div class="col-md-6">
                            <div class="mb-3 row">
                                <label for="NIK" class="col-md-4 col-form-label">NIK</label>
                                <div class="col-md-8">
                                    <input class="form-control" type="text" value="" id="nik" name="nik" placeholder="16 digit NIK Sesuai KTP">
                                    <span class="help-block"></span>
                                </div>
                            </div>
                        </div>
                        <div class=" col-md-6">
                            <div class="mb-3 row">
                                <label for="no_wa" class="col-md-4 col-form-label">No. Whatsapp</label>
                                <div class="col-md-8">
                                    <input class="form-control" type="text" placeholder="cth;0812345678910" id="no_wa" name="no_wa">
                                    <span class="help-block"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class=" col-md-6">
                            <div class="mb-3 row">
                                <label for="scan_ktp" class="col-md-4 col-form-label">Scan KTP</label>
                                <div class="col-md-8">
                                    <input type="file" name="scan_ktp" id="scan_ktp" class="form-control">
                                    <span class="help-block"></span>

                                </div>
                            </div>

                            <div class="imgScanKTP text-center">

                            </div>
                        </div>
                        <div class=" col-md-6">
                            <div class="mb-3 row">
                                <label for="email" class="col-md-4 col-form-label">Foto</label>
                                <div class="col-md-8">
                                    <input class="form-control" type="file" id="foto" name="foto">
                                    <span class="help-block"></span>
                                </div>
                                <div class="imgFoto text-center">

                                </div>
                            </div>

                        </div>
                    </div>

            </div>
            <div class="card-footer">
                <div class="row">

                    </form>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary SaveBtn" data-label="kordapil" id="btnSave">Simpan</button>
                </div>
            </div>
        </div>
    </div>
