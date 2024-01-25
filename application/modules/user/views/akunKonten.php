<div class="card">
    <div class="card-header">
        <div class="card-title">
            <h4> Tabel Daftar Akun Pengguna </h4>

        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <div class="py-2">
                <?php echo isset($head_data_akun) ? $head_data_akun : ''; ?>

            </div>
            <table width="100%" class="table table-hover" id="table_data_akun" data-source="table_data_akun">
                <thead>
                    <tr>
                        <th style="width: 3%"><input type="checkbox" id="check-all"></th>
                        <th width="5%">No.</th>
                        <th width="25%">Nama</th>
                        <th width="25%">Username</th>
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


<!-- Modal -->
<div class="modal  fade" id="modal_data_akun">
    <div class="modal-dialog  modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-title" name="modal-title">Form Data Akun Pengguna</h5>
                <div  class="btn close fs-3" data-bs-dismiss="modal">
                    <i class="bx bxs-x-circle"></i>
                </div>
            </div>
            <div class="modal-body">

                <form action="#" method="post" id="form_data_akun" name="form_data_akun" accept-charset="utf-8">
                    <input type="hidden" name="id" id="id" value="">



                    <div class="form-line">
                        <label for="tnkb">Nama </label>
                        <input class="form-control" id="nama" name="nama">
                        <span class="help-block"></span>
                    </div>
                     <div class="row">
                        <div class="col-md-6">
                            <div class="form-line">
                                <label for="username">Username </label>
                                <input class="form-control" id="username" name="username">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-line">
                                <label for="password">Password </label>
                                <input class="form-control" id="password" name="password">
                                <span class="help-block"></span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-line">
                                <label for="level">Level</label>
                                <select name="level_user_id" class="form-control" id="level_user_id">
                                    <option value="">--PILIH--</option>
                                   

                                </select>

                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-line">
                                <label for="status_aktif">Aktif </label>
                                <select name="status_aktif" class="form-control" id="status_aktif">
                                    <option value="">--PILIH--</option>
                                    <option value="1">Aktif</option>
                                    <option value="2">Non-Aktif</option>
                                </select>
                                <span class="help-block"></span>
                            </div>
                        </div>
                    </div>

                   
                </form>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary SaveBtn" data-label="data_akun" id="btnSave">Save changes</button>
            </div>
        </div>
    </div>
</div>
