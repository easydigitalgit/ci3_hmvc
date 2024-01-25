<div class="card">
    <div class="card-header">
        <div class="card-title">
            <h4> Tabel Data Anggota </h4>

        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <div class="py-2">
                <?php echo isset($headDataAnggota) ? $headDataAnggota : ''; ?>
                <span class="btn btn-sm btn-success" data-bs-toggle="collapse" href="#collapseFilter" aria-expanded="true" aria-controls="collapseFilter">Filter Data Anggota</span>

                <div class="card mb-3">
                    <div class="card-body collapse" id="collapseFilter">
                        <form action="#" method="post" id="form_filter_table" name="form_filter_table" enctype="multipart/form-data" accept-charset="utf-8">
                            <div class="row">
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
                                        <label for="filter_kecamatan" class="col-md-6 col-form-label">Kecamatan</label>
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
                                        <label for="filter_kelurahan" class="col-md-6 col-form-label">Kelurahan</label>
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

                        <div class="alert ">
                            <div class="btn btn-sm btn-success  float-end appliedFilter"> <i class="fas fa-search-location px-1"> </i>Terapkan Filter </div>
                            <div class="btn btn-sm btn-danger  float-end resetFilter mx-2"> <i class="fas fa-sync px-1"> </i>Reset Filter </div>

                        </div>

                    </div>
                </div>


            </div>
            <table width="100%" class="table table-hover" id="table_anggota" data-source="table_anggota">
                <thead>
                    <tr>
                        <th style="width: 3%"><input type="checkbox" id="check-all"></th>
                        <th width="5%">#</th>
                        <th width="">NIK</th>
                        <th width="">NAMA</th>
                        <th width="">GENDER / TEMPAT, TGL. LAHIR</th>
                        <th width="">KOORD. RELAWAN</th>
                        <th>ALAMAT</th>
                        <th>NO WA</th>

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
<div class="modal  fade" id="modal_anggota">
    <div class="modal-dialog  modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-title" name="modal-title">Form Data Anggota</h5>
                <div class="btn close fs-3" data-bs-dismiss="modal">
                    <i class="bx bxs-x-circle"></i>
                </div>
            </div>
            <div class="modal-body">

                <form action="#" id="form_anggota" name="form_anggota" method="post" accept-charset="utf-8">
                    <input type="hidden" name="id" id="id">
                    <div class="alertNikCheck mb-3"> </div>

                    <div class="mb-3 row">
                        <label for="relawan_id" class="col-md-2 col-form-label">ID Relawan</label>
                        <div class="col-md-10 ">

                            <select class="form-control" type="text" value="" id="relawan_id" name="relawan_id">
                            </select>
                            <span class="help-block"></span>

                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3 row">
                                <label for="NIK" class="col-md-4 col-form-label">NIK</label>
                                <div class="col-md-8 ">

                                    <input class="form-control" type="text" value="" id="nik" name="nik" placeholder="16 digit NIK Sesuai KTP">

                                    <span class="help-block"></span>

                                </div>
                            </div>

                        </div>
                        <div class="col-md-6">
                            <div class="mb-3 row">
                                <label for="nama_lengkap" class="col-md-4 col-form-label">Nama Lengkap</label>
                                <div class="col-md-8">
                                    <input class="form-control text-uppercase" type="text" value="" id="nama" name="nama" placeholder="Nama Sesuai KTP">
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
                                    <input class="form-control text-uppercase" type="text" value="" id="pob" name="pob">
                                    <span class="help-block"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3 row">
                                <label for="dob" class="col-md-4 col-form-label">Tanggal Lahir</label>
                                <div class="col-md-8">
                                    <input class="form-control dateTimePicker" type="text" value="" id="dob" name="dob">
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
                                            Laki-laki
                                            <span class="checkmark"></span>
                                        </label>
                                        <label class="radio-container mx-2" style="font-size: inherit;">
                                            <input type="radio" name="gender" id="gender_wanita" value="wanita">
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
                                    <input class="form-control" type="text" placeholder="cth;62812345678910" id="no_wa" name="no_wa">
                                    <span class="help-block"></span>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="mb-3 row">
                        <label for="alamat_rumah" class="col-md-2 col-form-label">Alamat KTP</label>
                        <div class="col-md-10">
                            <textarea class="form-control text-uppercase" type="text" placeholder="Alamat Sesuai KTP" id="alamat" name="alamat"></textarea>
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
                                    <div class="imgScanKTP text-center"> </div>
                                    <input type="hidden" name="imgktp" id="imgktp">
                                </div>
                            </div>


                        </div>
                        <div class=" col-md-6">
                            <div class="mb-3 row">
                                <label for="email" class="col-md-4 col-form-label">Foto</label>
                                <div class="col-md-8">
                                    <input class="form-control" type="file" id="foto" name="foto">
                                    <span class="help-block"></span>
                                    <div class="imgFoto text-center"> </div>
                                    <input type="hidden" name="imgfoto" id="imgfoto">
                                </div>

                            </div>

                        </div>
                    </div>

                    <div class="row">
                        <div class=" col-md-6">
                            <div class="mb-3 row">
                                <label for="no_tps" class="col-md-4 col-form-label">Nomor TPS</label>
                                <div class="col-md-8">
                                    <input type="text" name="no_tps" id="no_tps" class="form-control">
                                    <span class="help-block"></span>

                                </div>
                            </div>


                        </div>
                        <div class=" col-md-6">
                            <div class="mb-3 row">
                                <label for="kelurahan_tps" class="col-md-4 col-form-label">Kelurahan</label>
                                <div class="col-md-8">
                                    <input class="form-control" type="text" id="kelurahan_tps" name="kelurahan_tps" readonly="true">
                                    <span class="help-block">Jika Terdapat ketidaksesuaian dengan data KPU klik <span class="ubahKelurahanTPS"> ubah data </span> </span>
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
                    <button type="button" class="btn btn-primary SaveBtn" data-label="anggota" id="btnSave">Simpan</button>
                </div>
            </div>
        </div>
    </div>