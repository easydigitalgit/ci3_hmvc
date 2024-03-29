<div class="card">
	<div class="card-header">
		<div class="card-title"> 
			<h4> Tabel Data Laporan Anggota </h4>
			
		</div>
	</div>
	<div class="card-body">
		<div class="table-responsive">
			<div class="py-2"> 
		      <?php echo isset($head_data_report_anggota) ? $head_data_report_anggota : ''; ?>
		              
		    </div>
			<table width="100%" class="table table-hover" name="table_data_report_anggota" id="table_data_report_anggota" data-source="table_data_report_anggota">
                <thead>
                    <tr>
                    	
                        <th width="5%">No.</th>
                        <th width="20%">Nama </th>
                        <th width="5%">Gender</th>
                        <th width="25%">Tempat, Tgl.Lahir</th>
                        <th width="15%">Keanggotaan</th>
                        <th width="15%">DPD/DPC</th>
                                              
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
		</div>
	</div>
	
</div>


<!-- Modal -->
<div class="modal  fade" id="modal_data_sosper">
    <div class="modal-dialog  modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-title" name="modal-title">Form Kegiatan Sosper</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <i class="anticon anticon-close"></i>
                </button>
            </div>
            <div class="modal-body">
            
                <form action="#" method="post" id="form_data_sosper" name="form_data_sosper" accept-charset="utf-8">
                		<input type="hidden" class="form-control" id="id" name="id">
                  <div class="form-line">
                  	<label for="username">Kode </label>
                  	<input type="text" class="form-control" id="kode" name="kode">
                  	<span class="help-block"></span>
                  </div>
                  <div class="form-line">
                  	<label for="username">Nama </label>
                  	<input type="text" class="form-control" id="nama" name="nama">
                  	<span class="help-block"></span>
                  </div>
                  <div class="form-line">
                  	<label for="username">Waktu </label>
                  	<input type="text" class="form-control date-time" id="waktu" name="waktu">
                  	<span class="help-block"></span>
                  </div>
                   <div class="form-line">
                  	<label for="username">Tempat </label>
                  	<input type="text" class="form-control" id="tempat" name="tempat">
                  	<span class="help-block"></span>
                  </div>
                   <div class="form-line">
                  	<label for="username">Aleg </label>
                  	<input type="text" class="form-control" id="aleg" name="aleg">
                  	<span class="help-block"></span>
                  </div>
                   <div class="form-line">
                    <label for="username">Deskripsi </label>
                    <textarea class="form-control" id="deskripsi" name="deskripsi" ></textarea>
                    <span class="help-block"></span>
                    
                  </div>
                    
                    
                </form>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary SaveBtn" data-label="data_sosper" id="btnSave">Save changes</button>
            </div>
        </div>
    </div>
</div>