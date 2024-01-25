<div class="row">
	<div class="col-md-4 ">
		<div class="card">
			<div class="card-body">
				<div class="d-flex">
					<div class="flex-grow-1">
						<p class="text-muted card-title ">Peserta Pria</p>
						<h4 class="mb-0">1,235</h4>
					</div>
					<div class="mini-stat-icon avatar-sm rounded-circle bg-primary align-self-center">
						<span class="avatar-title">
							<i class="bx bx-male font-size-24"></i>
						</span>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-4 ">
		<div class="card">
			<div class="card-body">
				<div class="d-flex">
					<div class="flex-grow-1">
						<p class="text-muted card-title">Peserta Wanita</p>
						<h4 class="mb-0">1,235</h4>
					</div>
					<div class="mini-stat-icon avatar-sm rounded-circle bg-primary align-self-center">
						<span class="avatar-title">
							<i class="bx bx-female font-size-24"></i>
						</span>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-4 ">
		<div class="card">
			<div class="card-body">
				<div class="d-flex">
					<div class="flex-grow-1">
						<p class="text-muted  card-title">Total Peserta</p>
						<h4 class="mb-0">1,235</h4>
					</div>
					<div class="mini-stat-icon avatar-sm rounded-circle bg-primary align-self-center">
						<span class="avatar-title">
							<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: rgba(255, 255, 255, 1);transform: ;msFilter:;">
								<circle cx="6" cy="4" r="2"></circle>
								<path d="M9 7H3a1 1 0 0 0-1 1v7h2v7h4v-7h2V8a1 1 0 0 0-1-1z"></path>
								<circle cx="17" cy="4" r="2"></circle>
								<path d="M20.21 7.73a1 1 0 0 0-1-.73h-4.5a1 1 0 0 0-1 .73L12 14h2l-1 4h2v4h4v-4h2l-1-4h2z"></path>
							</svg>
						</span>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


<div class="card ">
	<div class="row">
		<div class="col-xl-12">
			<div class="card">
				<div class="card-body">

					<h4 class="card-title">Data Master</h4>
					<!-- Nav tabs -->
					<ul class="nav nav-pills nav-justified" role="tablist">
						<li class="nav-item waves-effect waves-light">
							<a class="nav-link active" data-bs-toggle="tab" href="#dataWilayah" role="tab" aria-selected="true">
								<span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
								<span class="d-none d-sm-block">Data Wilayah</span>
							</a>
						</li>
						<li class="nav-item waves-effect waves-light">
							<a class="nav-link" data-bs-toggle="tab" href="#dataDpd" role="tab" aria-selected="false">
								<span class="d-block d-sm-none"><i class="far fa-user"></i></span>
								<span class="d-none d-sm-block">Hash tag</span>
							</a>
						</li>
						<li class="nav-item waves-effect waves-light">
							<a class="nav-link" data-bs-toggle="tab" href="#dataDpc" role="tab" aria-selected="false">
								<span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
								<span class="d-none d-sm-block">Data DPC</span>
							</a>
						</li>

					</ul>

					<!-- Tab panes -->
					<div class="tab-content p-3 text-muted">
						<div class="tab-pane active" id="dataWilayah" role="tabpanel">
							<div class="py-2 ">

							</div>
							<div class="table-responsive">
								<table width="100%" class="table table-hover" id="table_data_wilayah" data-source="table_data_wilayah">
									<thead>
										<tr>

											<th width="5%">#</th>
											<th width="15%">kode</th>
											<th width="15%">Propinsi</th>
											<th width="20%">Kabupaten</th>
											<th width="20%">Kecamatan</th>
											<th width="20%">Desa / Kelurahan</th>

										</tr>
									</thead>
									<tbody>
									</tbody>
								</table>
							</div>
						</div>
						<div class="tab-pane" id="dataDpd" role="tabpanel">
							<div class="table-responsive">
								<div class="py-2">
									<?php echo isset($headDataTag) ? $headDataTag : ''; ?>
								</div>
								<table width="100%" class="table table-hover" id="table_data_tag" data-source="table_data_tag">
									<thead>
										<tr>
											<th width="5%">#</th>
											<th width="25%">Kode Hashtag</th>
											<th width="30%">Deskripsi</th>
											<th width="20%">Aksi</th>
										</tr>
									</thead>
									<tbody>
									</tbody>
								</table>
							</div>
						</div>
						<div class="tab-pane" id="dataDpc" role="tabpanel">
							<div class="table-responsive">
								<div class="py-2">
									<?php echo isset($headDataDPC) ? $headDataDPC : ''; ?>

								</div>
								<table width="100%" class="table table-hover" id="table_data_dpc" data-source="table_data_dpc">
									<thead>
										<tr>

											<th width="5%">#</th>
											<th width="25%">DPD</th>
											<th width="20%">Nama DPC</th>
											<th width="25%">Alamat / No. Hp</th>
											<th width="20%">Aksi</th>

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
	</div>
</div>

<!-- Modal -->
<div class="modal  fade" id="modal_data_tag">
	<div class="modal-dialog  modal-xl">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modal-title" name="modal-title">Form Data Tag</h5>
				<div class="close btn " data-bs-dismiss="modal">
					<i class="h4 bx bxs-x-circle"></i>
				</div>
			</div>
			<div class="modal-body">
				<form action="#" method="post" id="form_data_tag" name="form_data_tag" accept-charset="utf-8">
					<input type="hidden" name="id" id="id" value="">

					<div class="form-line">
						<label for="kode_tag">Kode Tag </label>
						<input class="form-control" id="kode_tag" name="kode_tag" placeholder=" cth; #GenZ">
						<span class="help-block"></span>
					</div>
					<div class="form-line">
						<label for="deskripsi_tag">Deskripsi </label>
						<input class="form-control" id="deskripsi_tag" name="deskripsi_tag" placeholder="cth; Generasi Z ">
						<span class="help-block"></span>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary SaveBtn" data-label="data_tag" id="btnSave">Save changes</button>
			</div>
		</div>
	</div>
</div>