<div class="card">
	<div class="card-header">
		<div class="card-title"> 
			<h4> Tabel Data Program Kerja </h4>
			
		</div>
	</div>
	<div class="card-body">
		<div class="table-responsive">
			<div class="py-2"> 
		      <?php echo isset($head_data_program) ? $head_data_program : ''; ?>
		              
		    </div>
			<table width="100%" class="table table-hover" name="table_data_program" id="table_data_program" data-source="table_data_program">
                <thead>
                    <tr>
                    	<th style="width: 3%"><input type="checkbox" id="check-all"></th>
                        <th width="5%">No.</th>
                        <th width="10%">Jenis </th>
                        <th width="15%">Struktural</th>
                        <th width="20%">Nama Program</th>
                        <th width="15%">Waktu</th>
                        <th width="15%">Tempat</th>
                        <th width="15%">Deskripsi</th>
                        
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
<div class="modal  fade" id="modal_data_program">
    <div class="modal-dialog  modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-title" name="modal-title">Form Data Program Kerja</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <i class="anticon anticon-close"></i>
                </button>
            </div>
            <div class="modal-body">
            
                <form action="#" method="post" id="form_data_program" name="form_data_program" accept-charset="utf-8">
                  <input type="hidden" class="form-control" id="id" name="id">
                  
                  <div class="row">
                      <div class="col-md-6">
                        <div class="form-line">
                            <label for="dpc">Struktural </label>
                            <select class="form-control" id="struktural_id" name="struktural_id">
                                <option value=""></option>
                                
                            </select>
                           
                            <span class="help-block"></span>
                       </div>
                      </div>
                       <div class="col-md-6">
                          <div class="form-line">
                            <label for="user">Diinput Oleh </label>
                            <input type="text" class="form-control" id="user" name="user" value="<?= $this->session->userdata('user_name') ;?>" readonly="true">
                            <span class="help-block"></span>
                         </div>
                      </div>
                  </div>

                  <div class="row">
                      <div class="col-6">
                          <div class="form-line">
                            <label for="kode_event">Kode </label>
                            <input type="text" class="form-control" id="kode_event" name="kode_event">
                            <span class="help-block"></span>
                          </div>
                      </div>
                      <div class="col-6">
                          <div class="form-line">
                            <label for="id_jenis_event">Jenis </label>
                            <select class="form-control" id="id_jenis_event" name="id_jenis_event">
                                <option value=""></option>
                                
                            </select>
                            <span class="help-block"></span>
                          </div>
                      </div>
                  </div>

                  
                  <div class="form-line">
                  	<label for="nama_event">Nama </label>
                  	<input type="text" class="form-control" id="nama_event" name="nama_event">
                  	<span class="help-block"></span>
                  </div>

                  <div class="row">
                      <div class="col-6">
                          <div class="form-line">
                            <label for="start_event">Waktu Mulai </label>
                            <input type="text" class="form-control date-time" id="start_event" name="start_event">
                            <span class="help-block"></span>
                          </div>
                      </div>
                       <div class="col-6">
                          <div class="form-line">
                            <label for="end_event">Waktu Selesai </label>
                            <input type="text" class="form-control date-time" id="end_event" name="end_event">
                            <span class="help-block"></span>
                          </div>
                      </div>
                  </div>
                  
                   <div class="form-line">
                  	<label for="alamat_event">Tempat </label>
                  	<input type="text" class="form-control" id="alamat_event" name="alamat_event">
                  	<span class="help-block"></span>
                  </div>

                 <div class="form-line">
                    <label for="deskripsi_event">Deskripsi </label>
                    <textarea class="form-control" id="deskripsi_event" name="deskripsi_event" ></textarea>
                    <span class="help-block"></span>
                </div>
                    
                    
                </form>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary SaveBtn" data-label="data_program" id="btnSave">Save changes</button>
            </div>
        </div>
    </div>
</div>