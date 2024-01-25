
<div class="card">
    <div class="card-header">
        <div class="card-title">
            <h4> Tabel Data CALEG </h4>

        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <div class="py-2">
                <?php echo isset($headDataCaleg) ? $headDataCaleg : ''; ?>

            </div>
            <table width="100%" class="table table-hover" id="table_data_caleg" data-source="table_data_caleg">
                <thead>
                    <tr>
                        <th style="width: 3%"><input type="checkbox" id="check-all"></th>
                        <th width="5%">#</th>
                        <th width="15%">NAMA CALEG</th>
                        <th width="10%">TINGKAT / NO. URUT</th>
                        <th width="15%">PARTAI</th>
                        <th width="10%">JUMLAH DPT / TPS</th>
                                         
                        <th width="10%">WA CENTER</th>

                        <th width="10%" style="">LOGO</th>
                        <th width="10%">Aksi</th>

                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>

</div>


<div class="modal  fade" id="modal_data_caleg">
    <div class="modal-dialog  modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-title" name="modal-title">Form Data Caleg </h5>
                <div  class="btn close fs-3" data-bs-dismiss="modal">
                    <i class="bx bxs-x-circle"></i>
                </div>
            </div>
            <div class="modal-body">

                <div class=" card">
                	
                	<div class="card-body">
                			 <form action="#" id="form_data_caleg" name="form_data_caleg" method="post" accept-charset="utf-8">
                                    <input type="hidden" name="id" id="id">
                                    <p class="alert alert-secondary fw-bold">IDENTITAS CALEG</p>
                                     <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3 row">
                                                <label for="id_akun_caleg" class="col-md-4 col-form-label">Nama Caleg</label>
                                                <div class="col-md-8 ">
                                                     <select class="form-control" name="id_akun_caleg" id="id_akun_caleg" >
                                                        <option value="">--</option>
                                                     
                                                    </select>
                                                    
                                                    <span class="help-block"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3 row">
                                                <label for="kordapil_akun_id" class="col-md-4 col-form-label">Koordinator DAPIL</label>
                                                <div class="col-md-8 ">
                                                    <select class="form-control" name="kordapil_akun_id" id="kordapil_akun_id" >
                                                        <option value="">--</option>  
                                                    </select>
                                                   
                                                    <span class="help-block"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                     
                                    <div class="row">
                                        <div class="col-md-6">
                                             <div class="mb-3 row">
                                                <label for="nomor_urut" class="col-md-4 col-form-label">NO. Urut Caleg</label>
                                                <div class="col-md-8 ">
                                                    <input class="form-control" type="text" value="" id="nomor_urut" name="nomor_urut" >
                                                    <span class="help-block"></span>
                                                </div>
                                             </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3 row">
                                                <label for="wa_caleg" class="col-md-4 col-form-label">NO. Whatsapp Caleg</label>
                                                <div class="col-md-8 ">
                                                    <input class="form-control" type="text" value="" id="wa_caleg" name="wa_caleg" >
                                                    <span class="help-block"></span>
                                                </div>
                                             </div>
                                        </div>
                                    </div>
                                   

                                    
                                    <hr>
                                    <p class="alert alert-secondary fw-bold">Daerah Pemilihan (DAPIL)</p>
                                        
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3 row">
                                                <label for="tingkat_pemilihan_id" class="col-md-4 col-form-label">Tingkat Pemilihan</label>
                                                    <div class="col-md-8 ">
                                                        <select class="form-control" name="tingkat_pemilihan_id" id="tingkat_pemilihan_id" >
                                                            <option value="">--</option>
                                                            <option value="1">DPR RI</option>
                                                            <option value="2">DPRD PROPINSI</option>
                                                            <option value="3">DPRD KOTA / KABUPATEN</option>   
                                                        </select>
                                                       
                                                        <span class="help-block"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                 <div class="mb-3 row">
                                                    <label for="id_partai" class="col-md-4 col-form-label">Nama Partai</label>
                                                    <div class="col-md-8 ">
                                                        <select name="id_partai" id="id_partai" class="form-control">
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
                                                    <label for="dapil_id" class="col-md-4 col-form-label">DAERAH PEMILIHAN (DAPIL)</label>
                                                    <div class="col-md-8 ">
                                                        <select class="form-control" name="dapil_id" id="dapil_id">
                                                            <option value=""></option>
                                                            
                                                        </select>
                                                        
                                                        <span class="help-block"></span>
                                                    </div>
                                                 </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3 row">
                                                    <label for="target_anggota" class="col-md-4 col-form-label">Target Anggota</label>
                                                    <div class="col-md-8 ">
                                                        <input class="form-control" type="text" value="" id="target_anggota" name="target_anggota" >
                                                        <span class="help-block"></span>
                                                    </div>
                                                 </div>
                                            </div>
                                            
                                        </div>
                                        

                                           
                                        <div class="row">
                                            <div class="col-md-6">
                                                 <div class="mb-3 row">
                                                    <label for="jumlah_dpt" class="col-md-4 col-form-label">Jumlah DPT</label>
                                                    <div class="col-md-8 ">
                                                        <input class="form-control" type="text" value="" id="jumlah_dpt" name="jumlah_dpt" readonly="true">
                                                        <span class="help-block"></span>
                                                    </div>
                                                 </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3 row">
                                                    <label for="jumlah_tps" class="col-md-4 col-form-label">Jumlah TPS</label>
                                                    <div class="col-md-8 ">
                                                        <input class="form-control" type="text" value="" id="jumlah_tps" name="jumlah_tps" readonly="true" >
                                                        <span class="help-block"></span>
                                                    </div>
                                                 </div>
                                            </div>
                                        </div>

                                         


                                    <hr>


                                    <p class="alert alert-secondary fw-bold">PENGATURAN APLIKASI</p>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3 row">
                                                <label for="wa_center_id" class="col-md-4 col-form-label">No. WA Center</label>
                                                <div class="col-md-8 ">
                                                      
                                                        <select name="wa_center_id" id="wa_center_id" class="form-control">
                                                            <option value=""></option>
                                                            
                                                        </select>
                                                        <span class="help-block"></span>  
                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-md-6">
                                           
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="scan_ktp" class="col-md-2 col-form-label">Template Whatsapp</label>
                                        <div class="col-md-10">
                                        	<textarea name="wa_template" id="wa_template" class="form-control" placeholder="Template pesan whatsapp pendaftaran anggota" rows="5"> </textarea>
                                            <span class="help-block"></span>

                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3 row">
                                                <label for="dob" class="col-md-4 col-form-label">Logo Caleg (icon) </label>
                                                <div class="col-md-8">
                                                    <input class="form-control text-uppercase" type="file" value="" id="small_logo" name="small_logo">
                                                    <span class="help-block"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3 row">
                                                <label for="dob" class="col-md-4 col-form-label">Logo Caleg (banner)</label>
                                                <div class="col-md-8">
                                                    <input class="form-control " type="file" value="" id="full_logo" name="full_logo">
                                                    <span class="help-block"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <hr>


                                    <p class="alert alert-secondary fw-bold">AddOn</p>
                                    <div class="mb-3 row">
                                        <label class="col-md-2 col-form-label" > Ucapan Selamat Ultah </label>
                                        <div class="col-md-10 form-check form-switch d-flex align-items-center fs-4 " style="padding-left:3em;">
                                            <input type="checkbox" name="ultah_enable" id="ultah_enable" class="form-check-input">
                                        </div>
                                    </div>


                                    <div class="mb-3 row">
                                        <label for="template_ultah" class="col-md-2 col-form-label">Template Ucapan Ulang Tahun Anggota</label>
                                        <div class="col-md-10">
                                            <textarea name="template_ultah" id="template_ultah" class="form-control" placeholder="Selamat ulang tahun kepada Bapak/Ibu {nama} yang ke {usia}, Semoga sukses." rows="5"> </textarea>
                                            <span class="help-block">Gunakan variable {nama} untuk menyebutkan Nama dan {usia} untuk menyebutkan angka usia pada pesan</span>
                                        </div>

                                    </div>
                                    </form>
                            </div>
                           
                    </div>	<!-- ./card konfigurasi -->
            </div> <!-- ./modal body -->
             <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary SaveBtn" data-label="data_caleg" id="btnSave">Simpan</button>
            </div>
        </div> <!-- ./modal content -->
    </div> <!-- ./modal dialog -->
</div> <!-- ./modal  -->
