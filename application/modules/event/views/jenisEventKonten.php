<div class="card">
    <div class="card-header">
        <div class="card-title">
            <h4> Tabel Data Event </h4>

        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <div class="py-2">
                <?php echo isset($headJenisEvent) ? $headJenisEvent : ''; ?>

            </div>
            <table width="100%" class="table table-hover" name="table_jenis_event" id="table_jenis_event" data-source="table_jenis_event">
                <thead>
                    <tr>
                        <th style="width: 3%"><input type="checkbox" id="check-all"></th>
                        <th width="5%">No.</th>
                        <th width="10%">Kode Jenis Event </th>

                        <th width="20%">Nama Jenis Event</th>
                       
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
<div class="modal  fade" id="modal_jenis_event">
    <div class="modal-dialog  modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-title" name="modal-title">Form Data Jenis Event</h5>
                <button type="button" class="close" data-bs-dismiss="modal">
                    <i class="anticon anticon-close"></i>
                </button>
            </div>
            <div class="modal-body">

                <form action="#" method="post" id="form_jenis_event" name="form_jenis_event" accept-charset="utf-8">
                    <input type="hidden" class="form-control" id="id" name="id">

                    
                    <div class="row">
                        <div class="col-6">
                            <div class="form-line">
                                <label for="kode_jenis_event">Kode Jenis Event </label>
                                <input type="text" class="form-control" id="kode_jenis_event" name="kode_jenis_event">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-line">
                                <label for="nama_jenis_event">Nama Jenis Event </label>
                                <input class="form-control" id="nama_jenis_event" name="nama_jenis_event">
                                  
                                <span class="help-block"></span>
                            </div>
                        </div>
                    </div>


                   

                    <div class="form-line">
                        <label for="deskripsi_event">Deskripsi </label>
                        <textarea class="form-control" id="deskripsi" name="deskripsi"></textarea>
                        <span class="help-block"></span>
                    </div>


                </form>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary SaveBtn" data-label="jenis_event" id="btnSave">Save changes</button>
            </div>
        </div>
    </div>
</div>