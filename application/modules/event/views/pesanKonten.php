<div class="alert alert-info">
    <ul>
        <li>Proses penjadwalan pesan ke Whatsapp Gateway dilakukan setiap satu jam sekali.</li>
        <li>Pesan yang sudah terjadwalkan ke Whatsapp Gateway tidak dapat dibatalkan.</li>
        <li>Proses penjadwalan terakhir telah dilakukan pada : <?php echo isset($lastCronWaTerjadwal) ? $lastCronWaTerjadwal : '00-00-000 00:00:00'; ?> </li>
    </ul>


</div>
<div class=" mt-2">
    <div class="card ">
        <div class="border border-info">
            <div class="card-header  ">
                <div class="card-title">
                    <p class="font-weight-bold text-dark">Tabel data pesan Whatsapp terjadwal

                    </p>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <div class="py-2">
                        <?php echo isset($headDataPesanJadwal) ? $headDataPesanJadwal : ''; ?>
                        <button class="bulkSend btn btn-info  btn-sm"><i class="mdi mdi-send"></i> Kirim Pesan</button>

                    </div>
                    <table width="100%" class="table table-hover" id="table_whatsapp_terjadwal" data-source="table_whatsapp_terjadwal">
                        <thead>
                            <tr>
                                <th style="width: 3%"><input type="checkbox" id="check-all"></th>
                                <th width="5%">No.</th>
                                <th width="10%">Nama Event </th>
                                <th width="25%">Preview Pesan </th>
                                <th width="15%">Jadwal Kirim </th>
                                <th width="10%">Jumlah Penerima </th>

                                <th width="15%">Status</th>

                                <th width="10%">Aksi</th>

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


<!-- Modal -->
<div class="modal  fade" id="modal_whatsapp_terjadwal">
    <div class="modal-dialog  modal-xl">
        <div class="modal-content">
            <div class="modal-header" style="padding: 0.5rem;">
                <h5 class="modal-title" id="modal-title" name="modal-title">Form Data Pesan Terjadwal</h5>
                <div class="btn close fs-3" data-bs-dismiss="modal">
                    <i class="bx bxs-x-circle"></i>
                </div>
            </div>
            <div class="modal-body">

                <form action="#" method="post" id="form_whatsapp_terjadwal" name="form_whatsapp_terjadwal" accept-charset="utf-8">
                    <input type="hidden" class="form-control" id="id" name="id">


                    <div class="row">
                        <div class="col-6">
                            <div class="form-line">
                                <label for="kode_jenis_event">Nama Event </label>
                                <select class="form-control" id="id_event" name="id_event">
                                    <option value=""></option>

                                </select>

                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-line">
                                <label for="nama_jenis_event">Jadwal Kirim </label>
                                <input class="form-control dateTimePicker" id="jadwal_kirim" name="jadwal_kirim">

                                <span class="help-block"></span>
                            </div>
                        </div>
                    </div>

                    <div class="form-line">
                        <label for="body_text">No. Whatsapp Center</label>
                        <select class="form-control selectWaCenter wacenterid" name="wa_center_id" id="wa_center_id">
                            <option value=""></option>

                        </select>

                        <span class="help-block"></span>
                    </div>

                    <div class="form-line">
                        <label for="deskripsi_event">Preview Template </label>
                        <textarea class="form-control" id="wa_template" name="wa_template" readonly="true"></textarea>
                        <span class="help-block"></span>
                    </div>


                    <hr>
                    <div class="fw-bold py-2">
                        Penerima Pesan
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <div class="form-line">
                                <label for="id_koord_relawan">Admin Entry
                                    <span class="mx-2">

                                        <input class="form-check-input " id="check_koord" type="checkbox" name="check_koord">
                                        <label class="form-check-label " for="check_koord">Pilih Semua</label>
                                    </span>
                                </label>

                                <select class="form-control idKoordRelawan " id="id_koord_relawan" name="id_koord_relawan[]" style="width: 100%;" multiple="multiple">
                                    <option value=""></option>

                                </select>

                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-line">
                                <label for="id_relawan">Koordinator Relawan
                                    <span class="mx-2">

                                        <input class="form-check-input " id="check_relawan" type="checkbox" name="check_relawan">
                                        <label class="form-check-label " for="container">Pilih Semua</label>
                                    </span>
                                </label>
                                <select class="form-control idRelawan " id="id_relawan" name="id_relawan[]" style="width: 100%;" multiple="multiple">

                                </select>
                                <span class="help-block"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row my-2">
                        <div class="col-12">
                            <div class="form-line mt-2">
                                <label for="check_anggota">Anggota
                                    <span class="mx-2">
                                        <input class="form-check-input " id="check_anggota" type="checkbox" name="check_anggota">
                                        <label class="form-check-label " for="container">Pilih Semua</label>
                                    </span>

                                </label>
                                <span class="alert alert-secondary p-2"> <strong> Filter By </strong>

                                    <label class="form-check-label" for="filter_relawan">
                                        <input class="form-check-input" id="filter_relawan" type="radio" name="filterBy" value="1">
                                        Koord. Relawan</label>
                                    <label class="form-check-label" for="filter_kecamatan">
                                        <input class="form-check-input" id="filter_kecamatan" type="radio" name="filterBy" value="2">
                                        Kecamatan</label>
                                    <label class="form-check-label" for="filter_kabupaten">
                                        <input class="form-check-input" id="filter_kabupaten" type="radio" name="filterBy" value="3">
                                        Kabupaten</label>
                                </span>


                                <span class="help-block"></span>
                            </div>
                        </div>
                        <input type="hidden" name="anggota_id[]" id="anggota_id">
                        <div id="boxAnggota">

                        </div>



                    </div>
                    <div class="row">
                        <div class="SelectAnggota">

                        </div>
                    </div>

                </form>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary SaveBtn" data-label="whatsapp_terjadwal" id="btnSave">Save changes</button>
            </div>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal  fade" id="modal_pesan_langsung">
    <div class="modal-dialog  modal-xl">
        <div class="modal-content">
            <div class="modal-header" style="padding: 0.5rem;">
                <h5 class="modal-title" id="modal-title" name="modal-title">Form Pesan WhatsApp Langsung</h5>
                <div class="btn close fs-3" data-bs-dismiss="modal">
                    <i class="bx bxs-x-circle"></i>
                </div>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <ul>
                        <li>Pastikan anda mengisi form ini dengan benar.</li>
                        <li>Dengan mengklik tombol "Kirim Pesan" proses pengiriman pesan akan dimulai dan tidak dapat dibatalkan </li>
                    </ul>
                </div>
                <form action="#" method="post" id="form_pesan_langsung" name="form_pesan_langsung" accept-charset="utf-8">
                    <input type="hidden" class="form-control" id="id" name="id">
                    <div class="form-line">
                        <label for="body_text">No. Whatsapp Center</label>
                        <select class="form-control selectWaCenter dmwacenterid" name="wa_center_id" id="wa_center_id">
                            <option value=""></option>

                        </select>

                        <span class="help-block"></span>
                    </div>
                    <div class="form-line">
                        <label for="body_text">Teks Pesan </label>
                        <textarea class="form-control" id="body_text" name="body_text"></textarea>
                        <span class="help-block"></span>
                    </div>

                    <div class="form-line mt-2">
                        <label for="media_pesan">File (docx, xlsx, pdf, jpg, png, mp4) </label>
                        <input class="form-control" type="file" name="media_pesan" id="media_pesan">

                        <span class="help-block"></span>
                    </div>


                    <hr>
                    <div class="fw-bold py-2">
                        Penerima Pesan
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <div class="form-line">
                                <label for="id_koord_relawan">Admin Entry
                                    <span class="mx-2">

                                        <input class="form-check-input " id="checkkoord" type="checkbox" name="checkkoord">
                                        <label class="form-check-label " for="check_koord">Pilih Semua</label>
                                    </span>
                                </label>

                                <select class="form-control idKoordRelawan idKoordRelawanDM" id="dm_id_koord_relawan" name="dm_id_koord_relawan[]" style="width: 100%;" multiple="multiple">
                                    <option value=""></option>

                                </select>

                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-line">
                                <label for="id_relawan">Koordinator Relawan
                                    <span class="mx-2">

                                        <input class="form-check-input" id="checkrelawan" type="checkbox" name="checkrelawan">
                                        <label class="form-check-label " for="container">Pilih Semua</label>
                                    </span>
                                </label>
                                <select class="form-control idRelawan idRelawanDM " id="dm_id_relawan" name="dm_id_relawan[]" style="width: 100%;" multiple="multiple">

                                </select>
                                <span class="help-block"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row my-2">
                        <div class="col-12">
                            <div class="form-line mt-2">
                                <label for="check_anggota">Anggota
                                    <span class="mx-2">
                                        <input class="form-check-input " id="dm_check_anggota" type="checkbox" name="dm_check_anggota">
                                        <label class="form-check-label " for="container">Pilih Semua</label>
                                    </span>

                                </label>
                                <span class="alert alert-secondary p-2"> <strong> Filter By </strong>

                                    <label class="form-check-label" for="filter_relawan">
                                        <input class="form-check-input" id="filter_relawan" type="radio" name="DMfilterBy" value="1">
                                        Koord. Relawan</label>
                                    <label class="form-check-label" for="filter_kecamatan">
                                        <input class="form-check-input" id="filter_kecamatan" type="radio" name="DMfilterBy" value="2">
                                        Kecamatan</label>
                                    <label class="form-check-label" for="filter_kabupaten">
                                        <input class="form-check-input" id="filter_kabupaten" type="radio" name="DMfilterBy" value="3">
                                        Kabupaten</label>
                                </span>


                                <span class="help-block"></span>
                            </div>
                        </div>
                        <input type="hidden" name="dm_anggota_id[]" id="dm_anggota_id">
                        <div id="DMboxAnggota">

                        </div>



                    </div>
                    <div class="row">
                        <div class="SelectAnggota">

                        </div>
                    </div>

                </form>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary SaveBtn" data-label="pesan_langsung" id="btnSend">Kirim Pesan</button>
            </div>
        </div>
    </div>
</div>