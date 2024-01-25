<div class="card">
	<div class="card-header">
		<div class="card-title"> 
			<h4> Tabel Template Pesan Whatsapp </h4>
			
		</div>
	</div>
	<div class="card-body">
		<div class="table-responsive">
			<div class="py-2"> 
		      <?php echo isset($head_wa_template) ? $head_wa_template : ''; ?>
		       <button  class="SendBtn btn btn-info " data-label="direct_msg"><i class="mdi mdi-send"> </i> Kirim Pesan</button>      
		    </div>
			<table width="100%" class="table table-hover" id="table_wa_template" data-source="table_wa_template">
                <thead>
                    <tr>
                    	<th style="width: 3%"><input type="checkbox" id="check-all"></th>
                        <th width="5%">No.</th>
                        <th width="15%">Kode Template</th>
                        <th width="20%">Tema Template</th>
                        <th width="25%">Teks Pesan</th>
                        <th width="10%">Status</th>
                        
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
<div class="modal  fade" id="modal_wa_template">
    <div class="modal-dialog  modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-title" name="modal-title">Form Template Pesan Whatsapp</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <i class="anticon anticon-close"></i>
                </button>
            </div>
            <div class="modal-body">
            
                <form action="#" method="post" id="form_wa_template" name="form_wa_template" accept-charset="utf-8">
                	<input type="hidden" name="id" id="id" value="">
                <div class="row">
	                <div class="col-md-6">
	                  	<div class="form-line">
		                  	<label for="kode">kode </label>
		                  	<input class="form-control" id="kode" name="kode">
		                  	<span class="help-block"></span>
		                  </div>
	                 </div>
	                 <div class="col-md-6">
	                  	<div class="form-line">
		                  	<label for="tema">Tema </label>
		                  	<input class="form-control" id="tema" name="tema">
		                  	<span class="help-block"></span>
		                 </div>
	                  </div>
                  
                </div>	
                 <div class="form-line">
                  	<label for="status">Status </label>
                  	<select  class="form-control" id="status" name="status">
                  		<option value=""></option>
                  		<option value="1">Aktif</option>
                  		<option value="2">Non-Aktif</option>

                  		
                  	</select>
                  
                  	<span class="help-block"></span>
		          </div>
		          <div class="form-line">
                  	<label for="teks_pesan">Teks Pesan </label>
                  	<textarea class="form-control" id="teks_pesan" name="teks_pesan"></textarea>
                  	
                  	<span class="help-block"></span>
                  </div>

                  <div class="form-line">
                  	NOTE: <br>
                  	<p>Gunakan tanda { } untuk memasukkan variable, cth: {nama} </p>
                  	<p>Untuk pengiriman massal, data akan dikirim dengan interval 1 - 5 menit setiap pesan</p>
                  </div>
                 
            </form>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary SaveBtn" data-label="wa_template" id="btnSave">Save changes</button>
            </div>
        </div>
    </div>
</div>




<!-- Modal -->
<div class="modal  fade" id="modal_direct_msg">
    <div class="modal-dialog  modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-title" name="modal-title">Pesan Whatsapp</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <i class="anticon anticon-close"></i>
                </button>
            </div>
            <div class="modal-body">
            
                <form action="#" method="post" id="form_direct_msg" name="form_direct_msg" accept-charset="utf-8">
                	<input type="hidden" name="id" id="id" value="">
                <div class="row">
	                <div class="col-md-12">
	                  	<div class="form-line">
		                  	<label for="no_hp">No HP </label>
		                  	<input class="form-control" id="no_hp" name="no_hp">
		                  	<span class="help-block"></span>
		                  </div>
	                 </div>
	                 <div class="col-md-12">
	                  	<div class="form-line">
		                  	<label for="pesan">Pesan </label>
		                  	<textarea class="form-control" id="pesan" name="pesan"></textarea>
		                  	
		                  	<span class="help-block"></span>
		                 </div>
	                  </div>
                  	<div class="col-md-12">
	                  	<div class="form-line">
		                  	<label for="pesan">Status </label>
		                  	<textarea class="form-control" id="status" name="status" readonly="true"></textarea>
		                  	
		                  	<span class="help-block"></span>
		                 </div>
	                </div>
                </div>	
                
            </form>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary SendNow" data-label="direct_msg" id="sendNow">Send Now</button>
            </div>
        </div>
    </div>
</div>