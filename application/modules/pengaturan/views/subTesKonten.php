<div class="card">
	<div class="card-header">
		<div class="card-title">
			<h4> Tabel Data Sub Tes </h4>

		</div>
	</div>
	<div class="card-body">
		<div class="table-responsive">
			<div class="py-2">
				<?php echo isset($headSubTes) ? $headSubTes : ''; ?>

			</div>
			<table width="100%" class="table table-hover" id="table_sub_tes" data-source="table_sub_tes">
				<thead>
					<tr>
						<th style="width: 3%"><input type="checkbox" id="check-all"></th>
						<th width="5%">No.</th>

						<th>Kode Jenis Tes</th>
						<th>Nama sub Tes</th>
						<th>Keterangan</th>


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
<div class="modal  fade" id="modal_sub_tes">
	<div class="modal-dialog  modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modal-title" name="modal-title">Form Sub Tes PSB</h5>
				<button type="button" class="close" data-bs-dismiss="modal">
					<i class="anticon anticon-close"></i>
				</button>
			</div>
			<div class="modal-body">

				<form action="#" method="post" id="form_sub_tes" name="form_sub_tes" accept-charset="utf-8">
					<input type="hidden" name="id" id="id" value="">

					<div class="col-md-12">
						<div class="form-line">
							<label for="jenis_tes_id">Kode Jenis Tes </label>
							<select class="form-control selectJenisTes" name="jenis_tes_id" id="jenis_tes_id">
								<option value="">--Pilih--</option>


							</select>

							<span class="help-block"></span>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="form-line">
								<label for="nama_sub_tes">Nama Sub Tes </label>
								<input class="form-control" id="nama_sub_tes" name="nama_sub_tes" placeholder="cth: Pengenalan Huruf Hijaiyyah">
							</div>

						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="form-line">
								<label for="keterangan_jenis_tes">Keterangan </label>
								<input class="form-control" id="keterangan_jenis_tes" name="keterangan_jenis_tes" placeholder="cth: Tes Agama kelas 1 SD , tes dilakukan secara offline">
							</div>

						</div>
					</div>





				</form>


			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary SaveBtn" data-label="sub_tes" id="btnSave">Simpan</button>
			</div>
		</div>
	</div>
</div>