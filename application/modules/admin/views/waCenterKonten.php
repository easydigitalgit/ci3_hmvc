<div class="card">
    <div class="card-header">
        <div class="card-title">
            <h4> Tabel Konfigurasi Whatsapp Center </h4>

        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <div class="py-2">
                <?php echo isset($headWaCenter) ? $headWaCenter : ''; ?>

            </div>
            <table width="100%" class="table table-hover" id="table_data_wa_sender" data-source="table_data_wa_sender">
                <thead>
                    <tr>
                        <th style="width: 3%"><input type="checkbox" id="check-all"></th>
                        <th width="5%">#</th>
                        <th width="15%">NO WA</th>
                        <th width="10%">API SENDER</th>
                        <th width="10%">DESKRIPSI</th>
                     
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
<div class="modal  fade" id="modal_data_wa_sender">
    <div class="modal-dialog  modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-title" name="modal-title">Form Data WHATSAPP </h5>
                <div  class="btn close fs-3" data-bs-dismiss="modal">
                    <i class="bx bxs-x-circle"></i>
                </div>
            </div>
            <div class="modal-body">

                <form action="#" id="form_data_wa_sender" name="form_data_wa_sender" method="post" accept-charset="utf-8">
                    <input type="hidden" name="id" id="id">
                    

                    <div class="mb-3 row">
                        <label for="no_wa" class="col-md-2 col-form-label">Nomor WHATSAPP</label>
                        <div class="col-md-10">
                            <input class="form-control" type="text" value="" id="no_wa" name="no_wa" placeholder="cth; 081261112345">
                            <span class="help-block"></span>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3 row">
                                <label for="apikey" class="col-md-4 col-form-label">API Sender</label>
                                <div class="col-md-8">
                                    <input class="form-control" type="text" value="" id="apikey" name="apikey">
                                    <span class="help-block"></span>
                                </div>
                            </div>
                        </div>
                       
                    </div>

                    <div class="mb-3 row">
                        <label for="deskripsi" class="col-md-2 col-form-label">Deskripsi</label>
                        <div class="col-md-10">
                            <textarea class="form-control"  id="deskripsi" name="deskripsi" placeholder="">  </textarea>
                            <span class="help-block"></span>
                        </div>
                    </div>      
                  
                 </form>    
            </div> <!-- modal body -->
           
            <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary SaveBtn save_data_wa_sender" data-label="data_wa_sender" id="btnSave">Simpan</button>
            </div>
        

        </div> <!-- modal content -->        
    </div>
</div> <!-- modal -->

<!-- Modal -->
<div class="modal  fade" id="modal_test_pesan">
    <div class="modal-dialog  modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-title" name="modal-title">Tes Pengiriman Pesan </h5>
                <div  class="btn close fs-3" data-bs-dismiss="modal">
                    <i class="bx bxs-x-circle"></i>
                </div>
            </div>
            <div class="modal-body">

                <form action="#" id="form_test_pesan" name="form_test_pesan" method="post" accept-charset="utf-8">
                    <input type="hidden" name="id_center" id="id_center">
                     
                    <div class="mb-3 row">
                        <label for="no_wa" class="col-md-2 col-form-label">Nomor Tujuan</label>
                        <div class="col-md-10">
                            <input class="form-control" type="text" value="" id="test_number" name="test_number" placeholder="cth; 081261112345">
                            <span class="help-block"></span>
                        </div>
                    </div>
                  
                 </form>    
            </div> <!-- modal body -->
           
            <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary SaveBtn save_test_pesan" data-label="test_pesan" id="btnSave">Kirim</button>
            </div>
        

        </div> <!-- modal content -->        
    </div>
</div> <!-- modal -->
    


