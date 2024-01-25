<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <h5>Data Akun Pengguna</h5>
                    <div>
                        
                    </div>
                </div>
                <div class="m-t-30">
		              <div class="py-2"> 
		               <?php echo isset($head_data_akun_pengguna) ? $head_data_akun_pengguna : ''; 
		              ;?>
		               
		            </div>
                    <div class="table-responsive">
                        <table width="100%" class="table table-hover" id="table_data_akun_pengguna" data-source="table_data_akun_pengguna">
                            <thead>
                                <tr>
                                    <th style="width: 3%"><input type="checkbox" id="check-all"></th>
                                    <th width="5%">No.</th>
                                    <th width="20%">Username </th>
                                    <th width="20%">Email</th>
                                    <th width="12%">Grup</th>
                                    <th width="10%">Level</th>
                                    <th width="10%">Aktif</th>
                                    <th width="20%">Aksi</th>
                                                                     
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
</div>




<!-- Modal -->
<div class="modal  fade" id="modal_data_akun_pengguna">
    <div class="modal-dialog  modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-title" name="modal-title">Form Data Pengguna</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <i class="anticon anticon-close"></i>
                </button>
            </div>
            <div class="modal-body">
            
                <form action="#" method="post" id="form_data_akun_pengguna" name="form_data_akun_pengguna" accept-charset="utf-8">
                  <div class="form-group">
                  	<label for="username">Username </label>
                  	<input class="form-control" id="username" name="username">
                  </div>
                  <div class="form-group">
                  	<label for="username">Email </label>
                  	<input class="form-control" id="email" name="email">
                  </div>
                    <div class="form-group">
                        <label for="kategori_peringatan">Grup</label>
                        <select class="form-control" name="grup_id" id="grup_id">
                        </select>
                        <span class="help-block"></span>
                    </div>
                    <div class="form-group">
                        <label for="deskripsi">Aktif</label>
                        <select class="form-control" name="aktif" id="aktif">
                        	<option value="0">Non-Aktif</option>
                        	<option value="1">Aktif</option>
                        </select>
                        <span class="help-block"></span>
                    </div>
                    
                </form>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary SaveBtn" data-label="data_akun_pengguna" id="btnSave">Save changes</button>
            </div>
        </div>
    </div>
</div>