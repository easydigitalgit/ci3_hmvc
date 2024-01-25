<div class="row d-flex justify-content-center">
	<div class="card col-8">
		<div class=" card-header">
			<div class="card-title">
				<p class="font-weight-bold">UBAH PASSWORD</p>
			</div>
		</div>
		<div class=" card-body">
			<div class="">
				<form method="post" action="#" name="form_user_password" id="form_user_password">
					<input type="hidden" name="id" id="id">

                 <div class="row clearfix">
                    <div class="col-md-2 form-control-label">
                    <label for="old_password">Password Lama</label>
                    </div>
                    <div class="col-md-10">
                        <div class="form-group">
                            <div class="form-line">
                              <input type="password" class="form-control" id="old_password" name="old_password">
                                <span class="help-block"></span>
                                 
                            </div>
                        </div>
                    </div>
                </div>

                 <div class="row clearfix">
                    <div class="col-md-2 form-control-label">
                    <label for="new_password">Password Baru</label>
                    </div>
                    <div class="col-md-10">
                        <div class="form-group">
                            <div class="form-line">
                              <input type="password" class="form-control" id="new_password" name="new_password">
                                <span class="help-block"></span>
                                 
                            </div>
                        </div>
                    </div>
                </div>
				</form>
			</div>	
		</div>
		<div class="card-footer ">
			
                <button type="button" class="btn btn-primary SaveBtn float-right" data-label="user_password" id="btnSave">Save changes</button>
		</div>
	</div>
</div>