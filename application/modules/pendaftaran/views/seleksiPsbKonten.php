<div class="card">
	<div class="card-header">
		<div class="card-title"> 
			<h4> Tabel Data Seleksi PSB </h4>
			
		</div>
	</div>
	<div class="card-body">
		<div class="table-responsive">
			<div class="py-2"> 
		      <?php echo isset($headSeleksiPsb) ? $headSeleksiPsb : ''; ?>
		              
		    </div>
			<table width="100%" class="table table-hover" id="table_seleksi_psb" data-source="table_seleksi_psb">
                <thead>
                    <tr>
                    	<th style="width: 3%"><input type="checkbox" id="check-all"></th>
                        <th width="5%">#</th>
                        <th width="">No.Reg</th>
                        <th width="">Unit/Kelas</th>
                        <th width="">Calon Siswa</th>
                        <th width="">Jadwal Tes</th>
                        <th width="">Status Tes</th>
                        <th>Nilai Tes</th>
                        

                       
                        
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



<div class="modal  fade" id="modal_absensi_tes">
    <div class="modal-dialog  modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-title" name="modal-title">Form Absensi TES PSB</h5>
                <button type="button" class="close" data-bs-dismiss="modal">
                    <i class="anticon anticon-close"></i>
                </button>
            </div>
            <div class="modal-body">
             <form action="#" id="form_absensi_tes" name="form_absensi_tes" method="post" accept-charset="utf-8">
                <input type="hidden" name="id" id="id"> 
               
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3 row">
                            <label for="tahun_ajaran_id" class="col-md-4 col-form-label">Cari No.Pendaftaran </label>
                            <div class="col-md-8">
                                <select class=" form-control selectNoPendaftaran " id="pendaftaran_id" name="pendaftaran_id">
                                    <option value="">--Pilih--</option>
                                                                                
                                </select>
                                <span class="help-block"></span>
                            </div>
                        </div> 
                    </div>
                    <div class="col-md-6">
                       <div class="mb-3 row">
                            <label for="tingkat" class="col-md-4 col-form-label">Tanggal Tes </label>
                            <div class="col-md-8">
                                <input class="form-control dateTimePicker" name="tanggal_tes" id="tanggal_tes">
                                <span class="help-block"></span>
                            </div>
                        </div>
                    </div>
                </div> 

                <div class="mb-3 row">
                    <label for="tingkat" class="col-md-2 col-form-label">Catatan </label>
                    <div class="col-md-10">
                        <textarea class="form-control" name="catatan" id="catatan">Catatan Reschedule</textarea>
                        
                        <span class="help-block"></span>
                    </div>
                </div> 
            </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary SaveBtn" data-label="absensi_tes" id="btnSave">Simpan</button>
            </div>
        </div>
    </div>
</div>

<div class="modal  fade" id="modal_nilai_tes">
    <div class="modal-dialog  modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-title" name="modal-title">Form Nilai TES PSB</h5>
                <button type="button" class="close" data-bs-dismiss="modal">
                    <i class="anticon anticon-close"></i>
                </button>
            </div>
            <div class="modal-body">
             <form action="#" id="form_nilai_tes" name="form_nilai_tes" method="post" accept-charset="utf-8">
                <input type="hidden" name="id" id="id"> 
               
                    <div class="mb-3 row px-3">
                        <label for="tahun_ajaran_id" class="col-md-4 col-form-label">Cari No.Pendaftaran </label>
                        <div class="col-md-8">
                            <select class=" form-control selectNoPendaftaran " id="pendaftaran_id" name="pendaftaran_id">
                                <option value="">--Pilih--</option>
                                                                            
                            </select>
                            <span class="help-block"></span>
                        </div>
                    </div> 


                   <div class="mb-3 row px-3">
                        <label for="tingkat" class="col-md-4 col-form-label">Tanggal Tes </label>
                        <div class="col-md-6">
                            <input class="form-control dateTimePicker" name="tanggal_tes" id="tanggal_tes" readonly="true">
                            <span class="help-block"></span>
                        </div>
                  </div>

                <div class="mb-3  formNilai px-3">  </div> 

            </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary SaveBtn" data-label="nilai_tes" id="btnSave">Simpan</button>
            </div>
        </div>
    </div>
</div>