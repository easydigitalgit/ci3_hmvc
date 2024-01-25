<div class="card">
	<div class="card-header">
		<div class="card-title"> 
			<h4> Tabel Daftar Unit Sekolah </h4>
			
		</div>
	</div>
	<div class="card-body">
		<div class="table-responsive">
			<div class="py-2"> 
		      <?php echo isset($head_unit_sekolah) ? $head_unit_sekolah : ''; ?>
		              
		    </div>
			<table width="100%" class="table table-hover" id="table_unit_sekolah" data-source="table_unit_sekolah">
                <thead>
                    <tr>
                    	<th style="width: 3%"><input type="checkbox" id="check-all"></th>
                        <th width="5%">No.</th>
                        <th width="25%">Kode Unit</th>
                        <th width="25%">Nama Unit</th>
                       
                        
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
<div class="modal  fade" id="modal_tahun_pelajaran">
    <div class="modal-dialog  modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-title" name="modal-title">Form Data Tahun Pelajaran</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <i class="anticon anticon-close"></i>
                </button>
            </div>
            <div class="modal-body">
            
                <form action="#" method="post" id="form_tahun_pelajaran" name="form_tahun_pelajaran" accept-charset="utf-8">
                	<input type="hidden" name="id" id="id" value="">
               

                 <div class="row">
                  	 <div class="col-md-6">
                  	 	<div class="form-line">
		                  	<label for="kode_thn_ajaran">Kode Tahun Pelajaran </label>
		                  	<input class="form-control" id="kode_thn_ajaran" name="kode_thn_ajaran" placeholder="cth: 2021_2022">
		                  	<span class="help-block"></span>
				         </div>
                  	 </div>
                  	 <div class="col-md-6">
                  	 	<div class="form-line">
		                  	<label for="nama_thn_ajaran">Nama Tahun Ajaran </label>
		                  	<input class="form-control" id="nama_thn_ajaran" name="nama_thn_ajaran" placeholder="cth: 2021-2022">
		                  	<span class="help-block"></span>
		                 </div>
                  	 </div>
                 </div>
                
                 
                 <div class="row">
                  	 <div class="col-md-6">
                  	 	  <div class="form-line">
		                  	<label for="thn_ajaran_mulai">Mulai Tahun Ajaran</label>
		                  	<input class="form-control" type="date" id="thn_ajaran_mulai" name="thn_ajaran_mulai">
		                  	<span class="help-block"></span>
				          </div>
                  	 </div>
					 <div class="col-md-6">
						 <div class="form-line">
		                  	<label for="thn_ajaran_mulai">Akhir Tahun Ajaran</label>
		                  	<input class="form-control" type="date" id="thn_ajaran_akhir" name="thn_ajaran_akhir">
		                  	<span class="help-block"></span>
				         </div>
                  	 </div>
                 </div>

              	<div class="form-line">
		          	<label for="thn_ajaran_aktif">Aktif </label>
		          	<select name="thn_ajaran_aktif" class="form-control" id="thn_ajaran_aktif">
		          		<option value="">--PILIH--</option>
		          		<option value="1">Aktif</option>
		          		<option value="0">Non-Aktif</option>
		          	</select>
		          	<span class="help-block"></span>
               </div>

            </form>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary SaveBtn" data-label="tahun_pelajaran" id="btnSave">Simpan</button>
            </div>
        </div>
    </div>
</div>