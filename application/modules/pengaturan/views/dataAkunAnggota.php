<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <h5>Data Akun Anggota</h5>
                    <div>
                        
                    </div>
                </div>
                <div class="m-t-30">
		              <div class="py-2"> 
		               <?php echo isset($head_akun_anggota) ? $head_akun_anggota : ''; 
		              ;?>
		               
		            </div>
                    <div class="table-responsive">
                        <table width="100%" class="table table-hover" id="table_akun_anggota" data-source="table_akun_anggota">
                            <thead>
                                <tr>
                                    <th style="width: 3%"><input type="checkbox" id="check-all"></th>
                                    <th width="5%">No.</th>
                                    <th width="25%">Nama Anggota </th>
                                    <th width="25%">Email</th>
                                   	<th width="20%">DPD/DPC</th>
                                    <th width="10%">Aktif</th>
                                    
                                   
                                    <th width="15%">Aksi</th>
                                                                     
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
<div class="modal  fade" id="modal_akun_anggota">
    <div class="modal-dialog  modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-title" name="modal-title">Form Data Akun Anggota</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <i class="anticon anticon-close"></i>
                </button>
            </div>
            <div class="modal-body">
            
                <form action="#" method="post" id="form_akun_anggota" name="form_akun_anggota" accept-charset="utf-8">
                    <input type="hidden" name="id" id="id" value="">

                  <div class="form-line">
                  	<label for="nama">Nama Lengkap </label>
                  	<input class="form-control" id="nama_lengkap" name="nama_lengkap">
                    <span class="help-block"></span>
                  </div>

                  <div class="form-line">
                  	<label for="nik">NIK </label>
                  	<input class="form-control" id="nik" name="nik">
                    <span class="help-block"></span>
                  </div>

                   <div class="form-line">
                  	<label for="email">Email </label>
                  	<input class="form-control" id="email" name="email">
                    <span class="help-block"></span>
                  </div>

                   <div class="form-line">
                  	<label for="password">Password </label>
                  	<input class="form-control" id="password" name="password">
                    <span class="help-block"></span>
                  </div>

                  

                    <div class="form-line">
                    <label for="username">Aktif </label>
                    <select class="form-control" name="aktif" id="aktif">
                    	<option value="">--Pilih--</option>
                    	
                    	<option value="1">Non-Aktif</option>
                    	<option value="2">Aktif</option>
                    	<option value="3">Blokir</option>
                    	
                    </select>
                   
                    <span class="help-block"></span>
                  </div>

                  <div class="form-line">
                    <label for="struktural_id">Struktural </label>
                    <select class="form-control" name="struktural_id" id="struktural_id">
                        <option value="">--Pilih--</option>
                        
                    </select>
                   
                    <span class="help-block"></span>
                  </div>

                  

                    
                </form>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary SaveBtn" data-label="akun_anggota" id="btnSave">Save changes</button>
            </div>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="modal_import_akun_anggota" tabindex="-1" role="dialog" aria-labelledby="modalimport" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalimport">Impor Data</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div id="upload_result"></div>
            <div id="processing" class="d-none" style="border:1px solid #000; padding:10px; width:100%; height:250px; overflow:auto; background:#000; color:#fff; font-family: Courier New , Courier, monospace;" ></div>
        <form class="form-horizontal" method="post" id="form_import_akun_anggota" action="#" enctype="multipart/form-data" >
            <input type="hidden" name="id" id="id" value="" aria-hidden />
            <div class="form-group row">
              <label class="col-md-3 col-form-label" for="berkas">Pilih Berkas</label>
              <div class="col-md-9">
                <input class="form-control" id="berkas" type="file" name="berkas" placeholder="pilih berkas .xlsx" />
                <span class="help-block"></span>
              </div>
            </div>
           
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        <button type="button" id="btnUpload" data-label="akun_anggota"  class="btn btn-primary">Upload</button>
      </div>
    </div>
  </div>
</div>