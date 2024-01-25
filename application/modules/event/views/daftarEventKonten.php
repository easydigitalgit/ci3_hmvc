<div class="card">
    <div class="card-header">
        <div class="card-title">
            <h4> Tabel Data Event </h4>

        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <div class="py-2">
                <?php echo isset($headDataEvent) ? $headDataEvent : ''; ?>

            </div>
            <table width="100%" class="table table-hover" name="table_event" id="table_event" data-source="table_event">
                <thead>
                    <tr>
                        <th style="width: 3%"><input type="checkbox" id="check-all"></th>
                        <th width="5%">No.</th>
                        <th width="10%">Jenis </th>

                        <th width="15%">Nama Event</th>
                        <th width="10%">Tanggal</th>
                        <th width="10%">Tempat</th>
                        <th width="15%">Deskripsi</th>
                        <th>Template WA</th>
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
<div class="modal  fade" id="modal_event">
    <div class="modal-dialog  modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-title" name="modal-title">Form Data Event</h5>
                <button type="button" class="close" data-bs-dismiss="modal">
                    <i class="anticon anticon-close"></i>
                </button>
            </div>
            <div class="modal-body">

                <form action="#" method="post" id="form_event" name="form_event" accept-charset="utf-8">
                    <input type="hidden" class="form-control" id="id" name="id">

                    

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-line">
                                <label for="jenis_event_id">Jenis Event </label>
                                <select class="form-control  select2JenisEvent" id="jenis_event_id" name="jenis_event_id" >
                                </select>

                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-line">
                                <label for="user">Nama Event</label>
                                <input type="text" class="form-control" id="nama_event" name="nama_event" value="" >
                                <span class="help-block"></span>
                            </div>
                        </div>
                    </div>


                    <div class=" row">
                        <div class="col-md-6">
                            <div class="form-line">
                                <label for="tgl_event">Tgl. Event </label>
                                <input type="date" class="form-control datetime" id="tgl_event" name="tgl_event">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-line">
                                <label for="tempat_event">Tempat </label>
                                <input type="text" class="form-control" id="tempat_event" name="tempat_event">
                                <span class="help-block"></span>
                            </div>
                     </div>
                        
                    </div>
                    
                    <div class="form-line">
                        <label for="deskripsi_event">Deskripsi </label>
                        <input type="text" class="form-control" id="deskripsi_event" name="deskripsi_event">
                        <span class="help-block"></span>
                    </div>
                   

                    <div class="form-line">
                        <label for="template_wa">Template WA </label>
                        <textarea class="form-control" id="template_wa" name="template_wa"></textarea>
                        <span class="help-block"></span>
                    </div>


                </form>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary SaveBtn" data-label="event" id="btnSave">Save changes</button>
            </div>
        </div>
    </div>
</div>