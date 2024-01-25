<div class="card">
	<div class="card-header">
		<div class="card-title"> 
			<h4> Tabel Data Jenjang Kelas </h4>
			
		</div>
	</div>
	<div class="card-body">
		<div class="table-responsive">
			<div class="py-2"> 
		      <?php echo isset($head_jenjang_kelas) ? $head_jenjang_kelas : ''; ?>
		              
		    </div>
			<table width="100%" class="table table-hover" id="table_jenjang_kelas" data-source="table_jenjang_kelas">
                <thead>
                    <tr>
                    	<th style="width: 3%"><input type="checkbox" id="check-all"></th>
                        <th width="5%">No.</th>
                        <th width="25%">Unit Sekolah</th>
                        <th width="25%">Jenjang Kelas</th>
                       
                        
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
<div class="modal  fade" id="modal_jenjang_kelas">
    <div class="modal-dialog  modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-title" name="modal-title">Form Data Jenjang Kelas</h5>
                <button type="button" class="close" data-bs-dismiss="modal">
                    <i class="anticon anticon-close"></i>
                </button>
            </div>
            <div class="modal-body">
            
                <form action="#" method="post" id="form_jenjang_kelas" name="form_jenjang_kelas" accept-charset="utf-8">
                	<input type="hidden" name="id" id="id" value="">
               

                 <div class="row">
                  	 <div class="col-md-6">
                  	 	<div class="form-line">
		                  	<label for="unit_sekolah_id">Unit Sekolah</label>
		                  	<select name="unit_sekolah_id" id="unit_sekolah_id" class="form-control" >
		                  		<option value="">--Pilih--</option>
		                  		<option value="1">TK</option> 
		                  		<option value="2">SD</option> 
		                  		<option value="3">SMP</option> 
		                  		<option value="4">SMA</option> 
		                  	</select>
		                  	
		                  	<span class="help-block"></span>
				         </div>
                  	 </div>
                  	 <div class="col-md-6">
                  	 	<div class="form-line">
		                  	<label for="nama_jenjang_kelas">Nama Jenjang </label>
		                  	<input class="form-control" id="nama_jenjang_kelas" name="nama_jenjang_kelas" placeholder="cth: A, B, 1, 2, 3 ... 11, 12 ">
		                  	<span class="help-block"></span>
		                 </div>
                  	 </div>
                 </div>
                
                 
                

            </form>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary SaveBtn" data-label="jenjang_kelas" id="btnSave">Simpan</button>
            </div>
        </div>
    </div>
</div>