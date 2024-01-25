<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <h5>Daftar Peserta Tes</h5>
                    <div>
                        
                    </div>
                </div>
                <div class="m-t-30">
                      <div class="py-2"> 
                       <?php echo isset($headTableNilai) ? $headTableNilai : '';?>
                       
                    </div>
                    <div class="table-responsive">
                        <table width="100%" class="table table-hover" id="table_peserta_tes" data-source="table_peserta_tes">
                            <thead>
                                <tr>
                                    <th style="width: 3%"><input type="checkbox" id="check-all"></th>
                                    <th width="15%">No. Pendaftaran</th>
                                    <th width="25%">Nama  </th>
                                    <th width="15%">Unit/Kelas</th>
                                    <th width="15%">Tanggal Ujian</th>
                                    <th width="10%">Status</th>
                                    
                                   
                                  
                                                                     
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
		
	

<div class="modal  fade" id="modal_hasil_tes">
    <div class="modal-dialog  modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-title" name="modal-title">Form Hasil TES PSB</h5>
                <button type="button" class="close" data-bs-dismiss="modal">
                    <i class="anticon anticon-close"></i>
                </button>
            </div>
            <div class="modal-body">
             <form action="#" id="form_hasil_tes" name="form_hasil_tes" method="post" accept-charset="utf-8">
                <input type="hidden" name="id" id="id"> 
               <div  id="fieldTes">
                   
               </div>

                

                
            </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary SaveBtn" data-label="hasil_tes" id="btnSave">Simpan</button>
            </div>
        </div>
    </div>
</div>

