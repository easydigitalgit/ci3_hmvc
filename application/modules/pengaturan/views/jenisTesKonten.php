<div class="card">
	<div class="card-header">
		<div class="card-title"> 
			<h4> Tabel Data Jenis Tes </h4>
			
		</div>
	</div>
	<div class="card-body">
		<div class="table-responsive">
			<div class="py-2"> 
		      <?php echo isset($headJenisTes) ? $headJenisTes : ''; ?>
		              
		    </div>
			<table width="100%" class="table table-hover" id="table_jenis_tes" data-source="table_jenis_tes">
                <thead>
                    <tr>
                    	<th style="width: 3%"><input type="checkbox" id="check-all"></th>
                        <th width="5%">No.</th>
                        <th >Kategori Tes</th>
                        <th >Kode Jenis Tes</th>
                        <th >Nama Jenis Tes</th>
                        <th >Keterangan</th>
                       
                        
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
<div class="modal  fade" id="modal_jenis_tes">
    <div class="modal-dialog  modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-title" name="modal-title">Form Jenis Tes PSB</h5>
                <button type="button" class="close" data-bs-dismiss="modal">
                    <i class="anticon anticon-close"></i>
                </button>
            </div>
            <div class="modal-body">
            
                <form action="#" method="post" id="form_jenis_tes" name="form_jenis_tes" accept-charset="utf-8">
                	<input type="hidden" name="id" id="id" value="">
               
            	<div class="col-md-12">
              	 	<div class="form-line">
	                  	<label for="kategori_tes_id">Kategori Tes </label>
	                  	<select class="form-control selectProgram" name="kategori_tes_id" id="kategori_tes_id">
	                  		<option value="">--Pilih--</option>
	                  		<option value="1">Tahfidz</option>
	                  		<option value="2">Agama</option>
	                  		<option value="3">Matematika</option>
	                  		<option value="4">Bahasa Inggris Reguler</option>
	                  		<option value="5">Bahasa Inggris Inter</option>
	                  		<option value="6">Psikologi</option>

	                  	</select>
	                  	
	                  	<span class="help-block"></span>
	                 </div>
              	 </div>
                
              	    <div class="row">
                  	 <div class="col-md-6">
                  	 	<div class="form-line">
                  	 		<label for="kode_jenis_tes">Kode Jenis Tes </label>
                  	 		<input class="form-control" id="kode_jenis_tes" name="kode_jenis_tes" placeholder="cth: agama1sd">
                  	 	</div>

                  	 </div>

                  	 <div class="col-md-6">
                  	 	<div class="form-line">
		                  	<label for="nama_jenis_tes">Nama Jenis Tes </label>
							<input class="form-control" id="nama" name="nama_jenis_tes" placeholder="cth: Agama kelas 1">
		                  	
		                  	<span class="help-block"></span>
		                 </div>

                  	 </div>
                </div>
                <div class="row">
                  	 <div class="col-md-12">
                  	 	<div class="form-line">
                  	 		<label for="keterangan_jenis_tes">Keterangan  </label>
                  	 		<input class="form-control" id="keterangan_jenis_tes" name="keterangan_jenis_tes" placeholder="cth: Tes Agama kelas 1 SD , tes dilakukan secara offline">
                  	 	</div>

                  	 </div>
                </div>
                 
                

            </form>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary SaveBtn" data-label="jenis_tes" id="btnSave">Simpan</button>
            </div>
        </div>
    </div>
</div>