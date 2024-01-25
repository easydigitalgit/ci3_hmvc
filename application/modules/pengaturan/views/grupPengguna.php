<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <h5>Data Grup Pengguna</h5>
                    <div>
                        
                    </div>
                </div>
                <div class="m-t-30">
		              <div class="py-2"> 
		               <?php echo isset($head_grup_pengguna) ? $head_grup_pengguna : ''; 
		              ;?>
		               
		            </div>
                    <div class="table-responsive">
                        <table width="100%" class="table table-hover" id="table_grup_pengguna" data-source="table_grup_pengguna">
                            <thead>
                                <tr>
                                    <th style="width: 3%"><input type="checkbox" id="check-all"></th>
                                    <th width="5%">No.</th>
                                    <th width="15%">Kode Grup </th>
                                    <th width="15%">Nama Grup</th>
                                    <th width="15%">Struktural</th>
                                    <th>Level</th>
                                    <th width="25%">Deskripsi</th>
                                   
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
<div class="modal  fade" id="modal_grup_pengguna">
    <div class="modal-dialog  modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-title" name="modal-title">Form Data Grup Pengguna</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <i class="anticon anticon-close"></i>
                </button>
            </div>
            <div class="modal-body">
            
                <form action="#" method="post" id="form_grup_pengguna" name="form_grup_pengguna" accept-charset="utf-8">
                    <input type="hidden" name="id" id="id" value="">
                  <div class="form-line">
                  	<label for="username">Kode Grup </label>
                  	<input class="form-control" id="kode_grup" name="kode_grup">
                    <span class="help-block"></span>
                  </div>
                  <div class="form-line">
                  	<label for="username">Nama Grup </label>
                  	<input class="form-control" id="nama_grup" name="nama_grup">
                    <span class="help-block"></span>
                  </div>
                    <div class="form-line">
                        <label for="kategori_peringatan">Struktural</label>
                        <select class="form-control" name="struktural_id" id="struktural_id">
                        </select>
                        <span class="help-block"></span>
                    </div>

                     <div class="form-line">
                        <label for="kategori_peringatan">Level Pengguna</label>
                        <select class="form-control userLevel" name="user_level" id="user_level">
                        </select>
                        <span class="help-block"></span>
                    </div>

                <div class="form-line">
                    <label for="username">Deskripsi </label>
                    <input class="form-control" id="deskripsi_grup" name="deskripsi_grup">
                    <span class="help-block"></span>
                  </div>
                    
                </form>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary SaveBtn" data-label="grup_pengguna" id="btnSave">Save changes</button>
            </div>
        </div>
    </div>
</div>