<div class="card">
    <div class="card-header">
        <div class="card-title">
            <h4> Tabel Data Koordinator Relawan </h4>

        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <div class="py-2">
                <?php echo isset($headDataRelawan) ? $headDataRelawan : ''; ?>

            </div>
            <table width="100%" class="table table-hover" id="table_koord_relawan" data-source="table_koord_relawan">
                <thead>
                    <tr>
                        <th style="width: 3%"><input type="checkbox" id="check-all"></th>
                        <th width="5%">#</th>
                        <th width="">NIK</th>
                        <th width="">NAMA</th>
                        <th width="">TEMPAT, TGL. LAHIR</th>
                        <th width="">GENDER</th>

                        <th>NO WA</th>
                        <th>NAMA CALEG</th>
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
<div class="modal  fade" id="modal_koord_relawan">
    <div class="modal-dialog  modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-title" name="modal-title">Form Data Admin Entry </h5>
                <div class="btn close fs-3" data-bs-dismiss="modal">
                    <i class="bx bxs-x-circle"></i>
                </div>
            </div>
            <div class="modal-body">

                <form action="#" id="form_koord_relawan" name="form_koord_relawan" method="post" accept-charset="utf-8">
                    <input type="hidden" name="id" id="id">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3 row">
                                <label for="caleg_akun_id" class="col-md-4 col-form-label">Nama CALEG</label>
                                <div class="col-md-8">
                                    <select class="form-control selectCaleg" id="caleg_akun_id" name="caleg_akun_id">
                                        <option value="">--PILIH--</option>

                                    </select>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3 row">
                                <label for="akun_id" class="col-md-4 col-form-label">UserAkun Admin Entry</label>
                                <div class="col-md-8">
                                    <select class="form-control selectAkunID" id="akun_id" name="akun_id">
                                        <option value=""> --PILIH-- </option>

                                    </select>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3 row">
                                <label for="NIK" class="col-md-2 col-form-label">NIK</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="text" value="" id="nik" name="nik" placeholder="16 digit NIK Sesuai KTP">
                                    <span class="help-block"></span>
                                </div>
                            </div>
                        </div>
                    </div>



                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3 row">
                                <label for="dob" class="col-md-4 col-form-label">Tempat Lahir</label>
                                <div class="col-md-8">
                                    <input class="form-control" type="text" value="" id="pob" name="pob">
                                    <span class="help-block"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3 row">
                                <label for="dob" class="col-md-4 col-form-label">Tanggal Lahir</label>
                                <div class="col-md-8">
                                    <input class="form-control" type="date" value="" id="dob" name="dob">
                                    <span class="help-block"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3 row">
                                <label for="gender" class="col-md-4 col-form-label">Jenis Kelamin</label>
                                <div class="mt-2 col-md-8">
                                    <div class="p-t-10">
                                        <label class="radio-container mx-2 " style="font-size: inherit;">
                                            <input type="radio" checked="checked" id="gender_pria" name="gender" value="pria">
                                            Pria
                                            <span class="checkmark"></span>
                                        </label>
                                        <label class="radio-container mx-2" style="font-size: inherit;">
                                            <input type="radio" name="gender" id="gender_wanita" value="wanita">
                                            Wanita
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
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


                    <div class="mb-3 row">
                        <label for="alamat_rumah" class="col-md-2 col-form-label">Alamat KTP</label>
                        <div class="col-md-10">
                            <textarea class="form-control" type="text" placeholder="Alamat Sesuai KTP" id="alamat" name="alamat"></textarea>
                            <span class="help-block"></span>

                        </div>
                    </div>


                    <div class="row">
                        <div class=" col-md-6">
                            <div class="mb-3 row">
                                <label for="prop_id" class="col-md-4 col-form-label">Propinsi</label>
                                <div class="col-md-8">
                                    <select name="prop_id" id="prop_id" class="form-control">
                                        <option value="">--PILIH--</option>
                                    </select>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                        </div>
                        <div class=" col-md-6">
                            <div class="mb-3 row">
                                <label for="kota" class="col-md-4 col-form-label">Kabupaten/Kota</label>
                                <div class="col-md-8">
                                    <select name="kota_id" id="kota_id" class="form-control">
                                        <option value="">--PILIH--</option>
                                    </select>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class=" col-md-6">
                            <div class="mb-3 row">
                                <label for="kec" class="col-md-4 col-form-label">Kecamatan</label>
                                <div class="col-md-8">
                                    <select name="kec_id" id="kec_id" class="form-control">
                                        <option value="">--PILIH--</option>
                                    </select>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                        </div>
                        <div class=" col-md-6">
                            <div class="mb-3 row">
                                <label for="desa" class="col-md-4 col-form-label">Kelurahan/Desa</label>
                                <div class="col-md-8">
                                    <select name="desa_id" id="desa_id" class="form-control">
                                        <option value="">--PILIH--</option>
                                    </select>
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
                    <button type="button" class="btn btn-primary SaveBtn" data-label="koord_relawan" id="btnSave">Simpan</button>
                </div>
            </div>
        </div>
    </div>