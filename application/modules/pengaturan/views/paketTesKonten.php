<div class="card">
	<div class="card-header">
		<div class="card-title"> 
			<h4> Tabel Data Paket Tes </h4>
			
		</div>
	</div>
	<div class="card-body">
		<div class="table-responsive">
			<div class="py-2"> 
		      <?php echo isset($headPaketTes) ? $headPaketTes : ''; ?>
		              
		    </div>
			<table width="100%" class="table table-hover" id="table_paket_tes" data-source="table_paket_tes">
                <thead>
                    <tr>
                    	<th style="width: 3%"><input type="checkbox" id="check-all"></th>
                        <th width="5%">No.</th>
                        <th >Kode Paket</th>
                        <th >Unit Sekolah / Jenjang Kelas</th>
                        <th >Program</th>
                        <th >Jenis Tes</th>
                       
                        
                        <th width="20%">Aksi</th>
                                                         
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
		</div>
	</div>
	
</div>


<!-- Modal -->
<div class="modal  fade" id="modal_paket_tes">
    <div class="modal-dialog  modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-title" name="modal-title">Form Paket Tes PSB</h5>
                <button type="button" class="close" data-bs-dismiss="modal">
                    <i class="anticon anticon-close"></i>
                </button>
            </div>
            <div class="modal-body">
            
                <form action="#" method="post" id="form_paket_tes" name="form_paket_tes" accept-charset="utf-8">
                	<input type="hidden" name="id" id="id" value="">
               
            	<div class="col-md-12">
              	 	<div class="form-line">
	                  	<label for="program_id">Program </label>
	                  	<select class="form-control selectProgram" name="program_id" id="program_id">
	                  		<option value="">--Pilih--</option>
	                  		<option value="1">Cambridge</option>
	                  		<option value="2">Reguler</option>
	                  		<option value="3">Tahfidz</option>

	                  	</select>
	                  	
	                  	<span class="help-block"></span>
	                 </div>
              	 </div>
                 <div class="row">
                  	 <div class="col-md-6">
                  	 	<div class="form-line">
		                  	<label for="unit_sekolah_id">Unit Sekolah</label>
		                  	<select name="unit_sekolah_id" id="unit_sekolah_id" class="form-control selectTingkat" >
		                  		<option value="">--Pilih--</option>
		                  		<option value="1">PG</option>
		                  		<option value="2">TK</option> 
		                  		<option value="3">SD</option> 
		                  		<option value="4">SMP</option> 
		                  		<option value="5">SMA</option> 
		                  	</select>
		                  	
		                  	<span class="help-block"></span>
				         </div>
                  	 </div>
                  	 <div class="col-md-6">
                  	 	<div class="form-line">
		                  	<label for="nama_jenjang_kelas">Nama Jenjang </label>
		                  	<select class="form-control selectJenjangKelas" name="jenjang_kelas_id" id="jenjang_kelas_id">
		                  		<option value="">--Pilih--</option>
		                  	</select>
		                  	
		                  	<span class="help-block"></span>
		                 </div>
                  	 </div>
                 </div>


                 <div class="row">
                  	 <div class="col-md-6">
                  	 	<div class="form-line">
                  	 		<label for="kode_paket_tes">Kode Paket </label>
                  	 		<input class="form-control" id="kode_paket_tes" name="kode_paket_tes">
                  	 	</div>

                  	 </div>

                  	 <div class="col-md-6">
                  	 	<div class="form-line">
		                  	<label for="jenis_tes_id">Jenis Tes </label>
		                  	<select class="form-control selectJenisTes" name="jenis_tes_seleksi_id" id="jenis_tes_seleksi_id">
		                  		<option value="">--Pilih--</option>
		                  	</select>
		                  	
		                  	<span class="help-block"></span>
		                 </div>

                  	 </div>
                </div>
                
                 
                

            </form>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary SaveBtn" data-label="paket_tes" id="btnSave">Simpan</button>
            </div>
        </div>
    </div>
</div>