<div class="card">
    <div class="card-header">
        <div class="card-title">
            <h4> Tabel Data Jenis Agenda </h4>

        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <div class="py-2">
                <?php echo isset($headTableJenisAgenda) ? $headTableJenisAgenda : ''; ?>

            </div>
            <table width="100%" class="table table-hover" id="table_data_jenis_agenda" data-source="table_data_jenis_agenda">
                <thead>
                    <tr>
                        <th style="width: 3%"><input type="checkbox" id="check-all"></th>
                        <th width="5%">#</th>
                        <th width="10%">Kode Jenis Agenda</th>
                        <th width="10%">Nama Jenis Agenda</th>
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
<div class="modal  fade" id="modal_data_jenis_agenda">
    <div class="modal-dialog  modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-title" name="modal-title">Form Jenis Agenda Kegiatan CALEG </h5>
                <div  class="btn close fs-3" data-bs-dismiss="modal">
                    <i class="bx bxs-x-circle"></i>
                </div>
            </div>
            <div class="modal-body">

                <form action="#" id="form_data_jenis_agenda" name="form_data_jenis_agenda" method="post" accept-charset="utf-8">
                    <input type="hidden" name="id" id="id">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3 ">
                                <label for="kode_jenis_agenda" class="col-md-4 col-form-label">Kode Jenis Agenda</label>
                                <div class="col-md-12 ">
                                   <input type="text" class="form-control" name="kode_jenis_agenda" id="kode_jenis_agenda">
                                    
                                    <span class="help-block"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3 ">
                                <label for="nama_jenis_agenda" class="col-md-4 col-form-label">Nama Jenis Agenda</label>
                                <div class="col-md-12 ">
                                   <input type="text" class="form-control" name="nama_jenis_agenda" id="nama_jenis_agenda">
                                    
                                    <span class="help-block"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                       
                     <div class="mb-3 ">
                        <label for="deskripsi_agenda" class="col-md-4 col-form-label">Deskripsi </label>
                        <div class="col-md-12 ">
                           
                            <textarea  class="form-control" name="deskripsi_agenda" id="deskripsi_agenda"></textarea>
                            
                            <span class="help-block"></span>
                        </div>
                     </div> 
                       
                         
                   
              
                 </form>    
            </div> <!-- modal body -->
           
            <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary SaveBtn" data-label="data_jenis_agenda" id="btnSave">Simpan</button>
            </div>
        

        </div> <!-- modal content -->        
    </div>
</div> <!-- modal -->