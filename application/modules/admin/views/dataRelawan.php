<div class="card">
    <div class="card-header">
        <div class="card-title">
            <h4> Tabel Data Relawan </h4>

        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <div class="py-2">
                <?php echo isset($headDataRelawan) ? $headDataRelawan : ''; ?>

            </div>
            <table width="100%" class="table table-hover" id="table_relawan" data-source="table_relawan">
                <thead>
                    <tr>
                        <th style="width: 3%"><input type="checkbox" id="check-all"></th>
                        <th width="5%">#</th>
                        <th width="10%">NIK</th>
                        <th width="10%">NAMA</th>
                        <th width="10%">TEMPAT, TGL. LAHIR / GENDER</th>

                        <th width="15%">ALAMAT</th>
                        <th width="10%">NO WA</th>

                        <th width="10%">LAMPIRAN</th>


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
<div class="modal  fade" id="modal_relawan">
    <div class="modal-dialog  modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-title" name="modal-title">Form Data Kord. Relawan </h5>
                <div class="btn close fs-3" data-bs-dismiss="modal">
                    <i class="bx bxs-x-circle"></i>
                </div>
            </div>
            <div class="modal-body">

                <form action="#" id="form_relawan" name="form_relawan" method="post" accept-charset="utf-8">
                    <input type="hidden" name="id" id="id">
                    <div class="mb-3 row">
                        <label for="akun_id" class="col-md-2 col-form-label">UserAkun Admin Entry</label>
                        <div class="col-md-10">
                            <select class="form-control selectAkunID" id="koord_akun_id" name="koord_akun_id">
                                <option value="--PILIH--"></option>

                            </select>
                            <span class="help-block"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3 row">
                                <label for="nama_relawan" class="col-md-4 col-form-label">Nama Kord. Relawan</label>
                                <div class="col-md-8">
                                    <input class="form-control" type="text" value="" id="nama_relawan" name="nama_relawan" placeholder="Nama Relawan Sesuai KTP">
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
                                            <input type="radio" checked="checked" id="gender_M" name="gender" value="M">
                                            Laki-laki
                                            <span class="checkmark"></span>
                                        </label>
                                        <label class="radio-container mx-2" style="font-size: inherit;">
                                            <input type="radio" name="gender" id="gender_F" value="F">
                                            Perempuan
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
                                <label for="propinsi" class="col-md-4 col-form-label">Propinsi</label>
                                <div class="col-md-8">
                                    <select name="propinsi" id="propinsi" class="form-control">
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
                                    <select name="kota" id="kota" class="form-control">
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
                                    <select name="kec" id="kec" class="form-control">
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
                                    <select name="desa" id="desa" class="form-control">
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

                            <div class="imgScanKTP text-center"> </div>
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
                </form>
            </div> <!-- modal body -->

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary SaveBtn" data-label="relawan" id="btnSave">Simpan</button>
            </div>


        </div> <!-- modal content -->
    </div>
</div> <!-- modal -->



<div class="modal  fade" id="modal_transfer_relawan">
    <div class="modal-dialog  modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-title" name="modal-title">Transfer anggota antar Koord. Relawan</h5>
                <div class="btn close fs-3" data-bs-dismiss="modal">
                    <i class="bx bxs-x-circle"></i>
                </div>
            </div>
            <div class="modal-body">

                <form action="#" id="form_transfer_relawan" name="form_transfer_relawan" method="post" accept-charset="utf-8">
                    <input type="hidden" name="id" id="id">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3 row">
                                <label for="nama_relawan" class="col-md-4 col-form-label">Koord. Asal</label>
                                <div class="col-md-8">

                                    <select id="from_koord" name="from_koord" class="form-control">
                                        <option value=""></option>

                                    </select>

                                    <span class="help-block"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3 row">
                                <label for="to_koord" class="col-md-4 col-form-label">Koord. Tujuan</label>
                                <div class="col-md-8">
                                    <select class="form-control" type="text" id="to_koord" name="to_koord">
                                        <option value=""></option>

                                    </select>

                                    <span class="help-block"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="anggota_id" id="anggota_id" val="">
                    <div id="boxAnggota">

                    </div>

                </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary transferBtn" data-label="relawan" id="transferBtn">Transfer</button>
            </div>
        </div>
    </div>
</div>


<div class="modal  fade" id="modal_detail_relawan">
    <div class="modal-dialog  modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-title" name="modal-title">Detail Koordinator Relawan <span></span></h5>
                <div class="btn close fs-3" data-bs-dismiss="modal">
                    <i class="bx bxs-x-circle"></i>
                </div>
            </div>
            <div class="modal-body">
                <div class="my-2 py-2">

                    <form action="#" id="" name="" method="post" accept-charset="utf-8">
                        <input type="hidden" name="id" id="id">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3 row">
                                    <label for="" class="col-md-4 col-form-label">Admin Entry</label>
                                    <div class="col-md-8">
                                        <input type="" class="form-control" name="adminEntry" id="adminEntry" readonly="true">


                                        <span class="help-block"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3 row">
                                    <label for="to_koord" class="col-md-4 col-form-label">Total Anggota </label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" name="totalAnggota" id="totalAnggota" readonly="true">

                                        <span class="help-block"></span>
                                    </div>
                                </div>
                            </div>
                        </div>



                    </form>



                </div>
                <hr>
                <div class="mb-2">
                    <p class="h4"> Tabel Data Anggota </p>
                </div>
                <table width="100%" class="table table-hover" id="table_detail_relawan" data-source="table_detail_relawan">
                    <thead>
                        <tr>
                            <th style="width: 3%"><input type="checkbox" id="check-all"></th>
                            <th width="5%">#</th>
                            <th width="10%">NIK / NAMA</th>

                            <th width="10%">TEMPAT, TGL. LAHIR / GENDER</th>

                            <th width="15%">ALAMAT</th>
                            <th width="10%">NO WA</th>

                            <th width="10%">LAMPIRAN</th>

                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>

            </div>
            <div class="modal-footer">

            </div>
        </div>
    </div>
</div>