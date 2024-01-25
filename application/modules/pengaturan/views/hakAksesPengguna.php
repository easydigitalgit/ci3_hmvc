
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="header">
                        <h2> Pengaturan Hak Akses Pengguna </h2>
                    </div>
                    <div class="body"> 
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#home_with_icon_title"> <i class="material-icons">home</i> Modul Aplikasi </a></li>
                            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#profile_with_icon_title"><i class="material-icons">person</i> Hak Akses </a></li>
                            
                        </ul>
                        
                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane in active" id="home_with_icon_title"> <b>Data Modul Aplikasi</b>
                                <p> data Modul   </p>

                                <div class="m-t-30">
                                  <div class="py-2"> 
                                   <?php echo isset($head_data_modul) ? $head_data_modul : ''; 
                                  ;?>
                                   
                                </div>
                                <div class="table-responsive">
                                    <table width="100%" class="table table-hover" id="table_data_modul" data-source="table_data_modul">
                                        <thead>
                                            <tr>
                                                <th style="width: 3%"><input type="checkbox" id="check-all"></th>
                                                <th width="5%">No.</th>
                                                <th width="25%">Menu Title</th>
                                                <th width="25%">Url</th>
                                                <th width="15%">Module</th>
                                                <th width="15%">Parent</th>

                                                
                                               
                                                <th width="20%">Aksi</th>
                                                                                 
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                              </div>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="profile_with_icon_title"> <b>Data Hak Akses</b>
                                <p> data hak akses  </p>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        




<!-- Modal -->
<div class="modal  fade" id="modal_data_modul">
    <div class="modal-dialog  modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-title" name="modal-title">Form Modul Aplikasi</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <i class="anticon anticon-close"></i>
                </button>
            </div>
            <div class="modal-body">
            
                <form action="#" method="post" id="form_data_modul" name="form_data_modul" accept-charset="utf-8">
                  <div class="form-line">
                    <label for="username">Menu Title </label>
                    <input class="form-control" id="menu_title" name="menu_title">
                  </div>
                  <div class="form-line">
                    <label for="username">URL </label>
                    <input class="form-control" id="menu_url" name="menu_url">
                  </div>
                   <div class="form-line">
                    <label for="username">Modul </label>
                    <textarea class="form-control" id="modul_name" name="modul_name" ></textarea>
                    
                  </div>
                    <div class="form-line">
                    <label for="username">Parent </label>
                    <textarea class="form-control" id="parent" name="parent" ></textarea>
                    
                  </div>
                    
                </form>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary SaveBtn" data-label="data_modul" id="btnSave">Save changes</button>
            </div>
        </div>
    </div>
</div>