<div class="card">
	<div class="card-header">
		<div class="card-title">
			<p class="font-weight-bold text-dark">Form Ganti Password</p>
		</div>
	</div>
	<div class="card-body">
		<form action="#" class="" name="form_update_password" id="form_update_password" accept-charset="utf-8" method="post">
			  	<div class="form-line">
                  	<label for="tnkb">Nama </label>
                  	<input class="form-control" id="nama" name="nama" value="<?= $this->session->userdata('nama'); ?>" readonly>
                  	<span class="help-block"></span>
		         </div>
                 <div class="form-line">
                  	<label for="email">Email / Username </label>
                  	<input class="form-control" id="email" name="email" value="<?= $this->session->userdata('username'); ?>" readonly>
                  	<span class="help-block"></span>
                 </div>
                 <div class="form-line">
                  	<label for="password">Password Lama </label>
                  	<input class="form-control" id="password" name="password">
                  	<span class="help-block"></span>
		          </div>
		          <div class="form-line">
                  	<label for="password">Password Baru </label>
                  	<input class="form-control" id="new_password" name="new_password">
                  	<span class="help-block"></span>
		          </div>
		</form>
	</div>
	<div class="card-footer">
		<button type="button" class="btn btn-primary SaveBtn" data-label="update_password" id="btnSave">Save changes</button>
	</div>
</div>