<div class="card">
	<div class="card-header">
		<div class="card-title">

		</div>

	</div>
	<div class=" card-body">
		<p class="h3">Laporan sebaran anggota berdasar kelurahan </p>
		<div class="py-2">
			<div class="card mb-3">
				<div class="card-header">
					<div class="fw-bold"> <span class="btn btn-primary" data-bs-toggle="collapse" href="#collapseFilter" aria-expanded="true" aria-controls="collapseFilter">Filter Data</span>

					</div>
				</div>
				<div class="card-body collapse" id="collapseFilter">
					<form action="#" method="post" id="form_filter_map" accept-charset="utf-8">
						<div class="row">
							<div class="col-md-4">
								<div class="mb-0 ">
									<label for="filter_caleg_id" class="col-md-6 col-form-label">CALEG</label>
									<div class="col-md-8">
										<select class="form-control" name="filter_caleg_id" id="filter_caleg_id">
											<option value="">--</option>

										</select>

										<span class="help-block"></span>
									</div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="mb-0 ">
									<label for="filter_dapil_id" class="col-md-6 col-form-label">KorDapil</label>
									<div class="col-md-8">
										<select class="form-control" name="filter_dapil_id" id="filter_dapil_id">
											<option value="">--</option>

										</select>

										<span class="help-block"></span>
									</div>
								</div>
							</div>

							<div class="col-md-4">
								<div class="mb-0 ">
									<label for="filter_propinsi" class="col-md-6 col-form-label">Propinsi</label>
									<div class="col-md-8">
										<select class="form-control" name="filter_propinsi" id="filter_propinsi">
											<option value="">--</option>

										</select>

										<span class="help-block"></span>
									</div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="mb-0 ">
									<label for="filter_kabupaten" class="col-md-6 col-form-label">Kabupaten/Kota</label>
									<div class="col-md-8">
										<select class="form-control" name="filter_kabupaten" id="filter_kabupaten">
											<option value="">--</option>

										</select>

										<span class="help-block"></span>
									</div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="mb-0 ">
									<label for="filter_kecamatan_id" class="col-md-6 col-form-label">Kecamatan</label>
									<div class="col-md-8">
										<select class="form-control" name="filter_kecamatan" id="filter_kecamatan">
											<option value="">--</option>

										</select>

										<span class="help-block"></span>
									</div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="mb-0 ">
									<label for="filter_kelurahan_id" class="col-md-6 col-form-label">Kelurahan</label>
									<div class="col-md-8">
										<select class="form-control" name="filter_kelurahan" id="filter_kelurahan">
											<option value="">--</option>

										</select>

										<span class="help-block"></span>
									</div>
								</div>
							</div>

						</div>
					</form>
				</div>

				<div class="card-footer">
					<div class="btn btn-sm btn-primary  float-end refreshMap"> <i class="fas fa-search-location px-1"> </i>Terapkan Filter </div>
					<div class="btn btn-sm btn-danger  float-end resetMap mx-2"> <i class="fas fa-sync px-1"> </i>Reset Filter </div>
					<div class="btn btn-sm btn-success  float-end refreshMap"> <i class="fas fa-file-excel px-1"> </i>Export Excel </div>

				</div>

			</div>

		</div>
		<div class="table-responsive">
			<div class="py-2">
				<?php echo isset($headLaporanByKelurahan) ? $headLaporanByKelurahan : ''; ?>

			</div>
			<table width="100%" class="table table-hover" id="table_laporan_kelurahan" data-source="table_laporan_kelurahan">
				<thead>
					<tr>
						<th style="width: 3%"><input type="checkbox" id="check-all"></th>
						<th width="5%">No.</th>
						<th width="15%">Kelurahan</th>
						<th width="15%">Pria</th>
						<th width="15%">Wanita</th>
						<th width="15%">Jumlah</th>



					</tr>
				</thead>
				<tbody>
				</tbody>
			</table>
		</div>

	</div>

</div>

<div class="clearfix"> </div>

<div class="card">
	<div class="card-header">
		<div class="card-title">

		</div>

	</div>
	<div class=" card-body">
		<p class="h3">Laporan Sebaran Anggota Berdasarkan Korrdinator</p>
		<div class="py-2">
			<div class="card mb-3">
				<div class="card-header">
					<div class="fw-bold"> <span class="btn btn-primary" data-bs-toggle="collapse" href="#collapseFilter2" aria-expanded="true" aria-controls="collapseFilter2">Filter Data</span>

					</div>
				</div>
				<div class="card-body collapse" id="collapseFilter2">
					<form action="#" method="post" id="form_filter_map" accept-charset="utf-8">
						<div class="row">
							<div class="col-md-4">
								<div class="mb-0 ">
									<label for="filter_caleg_id" class="col-md-6 col-form-label">CALEG</label>
									<div class="col-md-8">
										<select class="form-control" name="filter_caleg_id" id="filter_caleg_id">
											<option value="">--</option>

										</select>

										<span class="help-block"></span>
									</div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="mb-0 ">
									<label for="filter_dapil_id" class="col-md-6 col-form-label">KorDapil</label>
									<div class="col-md-8">
										<select class="form-control" name="filter_dapil_id" id="filter_dapil_id">
											<option value="">--</option>

										</select>

										<span class="help-block"></span>
									</div>
								</div>
							</div>

							<div class="col-md-4">
								<div class="mb-0 ">
									<label for="filter_propinsi" class="col-md-6 col-form-label">Propinsi</label>
									<div class="col-md-8">
										<select class="form-control" name="filter_propinsi" id="filter_propinsi">
											<option value="">--</option>

										</select>

										<span class="help-block"></span>
									</div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="mb-0 ">
									<label for="filter_kabupaten" class="col-md-6 col-form-label">Kabupaten/Kota</label>
									<div class="col-md-8">
										<select class="form-control" name="filter_kabupaten" id="filter_kabupaten">
											<option value="">--</option>

										</select>

										<span class="help-block"></span>
									</div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="mb-0 ">
									<label for="filter_kecamatan_id" class="col-md-6 col-form-label">Kecamatan</label>
									<div class="col-md-8">
										<select class="form-control" name="filter_kecamatan" id="filter_kecamatan">
											<option value="">--</option>

										</select>

										<span class="help-block"></span>
									</div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="mb-0 ">
									<label for="filter_kelurahan_id" class="col-md-6 col-form-label">Kelurahan</label>
									<div class="col-md-8">
										<select class="form-control" name="filter_kelurahan" id="filter_kelurahan">
											<option value="">--</option>

										</select>

										<span class="help-block"></span>
									</div>
								</div>
							</div>

						</div>
					</form>
				</div>

				<div class="card-footer">
					<div class="btn btn-sm btn-primary  float-end refreshMap"> <i class="fas fa-search-location px-1"> </i>Terapkan Filter </div>
					<div class="btn btn-sm btn-danger  float-end resetMap mx-2"> <i class="fas fa-sync px-1"> </i>Reset Filter </div>
					<div class="btn btn-sm btn-success  float-end refreshMap"> <i class="fas fa-file-excel px-1"> </i>Export Excel </div>

				</div>

			</div>

		</div>
		<div class="table-responsive">
			<div class="py-2">


			</div>
			<table width="100%" class="table table-hover" id="table_laporan_relawan" data-source="table_laporan_relawan">
				<thead>
					<tr>
						<th style="width: 3%"><input type="checkbox" id="check-all"></th>
						<th width="5%">No.</th>
						<th width="10%">Foto</th>
						<th width="25%">Relawan</th>
						<th width="15%">Pria</th>
						<th width="15%">Wanita</th>
						<th width="15%">Jumlah</th>
					</tr>
				</thead>
				<tbody>
				</tbody>
			</table>
		</div>

	</div>

</div>