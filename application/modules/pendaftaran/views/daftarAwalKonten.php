<div class="card">
	<div class="card-header">
		<div class="card-title"> 
			<h4> Tabel Data Pendaftar Awal </h4>
			
		</div>
	</div>
	<div class="card-body">
		<div class="table-responsive">
			<div class="py-2"> 
		      <?php echo isset($head_daftar_awal) ? $head_daftar_awal : ''; ?>
		              
		    </div>
			<table width="100%" class="table table-hover" id="table_daftar_awal" data-source="table_daftar_awal">
                <thead>
                    <tr>
                    	<th style="width: 3%"><input type="checkbox" id="check-all"></th>
                        <th width="5%">#</th>
                        <th width="">No.Reg</th>
                        <th width="">TP</th>
                        <th width="">Jenis Pendaftar</th>
                        <th width="">Kelas</th>
                        <th>Calon Siswa</th>
                        <th>Orangtua</th>
                        
                        <th>Lampiran</th>
                        <th>Pembayaran</th>
                        <th>Verifikasi</th>

                       
                        
                        <th width="">Aksi</th>
                                                         
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
		</div>
	</div>
	
</div>


<!-- Modal -->
<div class="modal  fade" id="modal_daftar_awal">
    <div class="modal-dialog  modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-title" name="modal-title">Form Pendaftaran Awal PSB</h5>
                <button type="button" class="close" data-bs-dismiss="modal">
                    <i class="anticon anticon-close"></i>
                </button>
            </div>
            <div class="modal-body">
            
                <form action="#" id="form_daftar_awal" name="form_daftar_awal" method="post" accept-charset="utf-8">
                            <input type="hidden" name="id" id="id"> 
                           
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3 row">
                                        <label for="tahun_ajaran_id" class="col-md-4 col-form-label">Tahun Pelajaran </label>
                                        <div class="col-md-8">
                                            <select class="form-select form-control selectTahunAjaran" id="tahun_ajaran_id" name="tahun_ajaran_id">
                                                <option value=""></option>
                                                
                                                <option value="1">2021-2022</option>
                                                <option value="2">2022-2023</option>
                                                                                            
                                            </select>
                                            <span class="help-block"></span>
                                        </div>
                                    </div> 
                                </div>
                                <div class="col-md-6">
                                   <div class="mb-3 row">
                                        <label for="tingkat" class="col-md-4 col-form-label">Tingkat </label>
                                        <div class="col-md-8">
                                            <select class="form-select form-control selectTingkat" id="tingkat_id" name="tingkat_id">
                                                <option value=""></option>
                                                <option value="1">PG</option>
                                                <option value="2">TK</option>
                                                <option value="3">SD</option>
                                                <option value="4">SMP</option>
                                                <option value="5">SMA</option>
                                                
                                            </select>
                                            <span class="help-block"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>  
                             
                            <div class="row">
                              <div class="col-md-6">
                                  <div class="row mb-3">
                                        <label for="jenis_pendaftaran" class="col-md-4 col-form-label">Jenis Pendaftaran </label>
                                        <div class="col-md-8">
                                            <select class="form-select form-control" id="jenis_pendaftaran_id" name="jenis_pendaftaran_id">
                                                <option value="">--Pilih--</option>
                                                
                                                <option value="1">Siswa Baru</option>
                                                <option value="2">Pindahan</option>
                                       
                                        
                                            </select>
                                            <span class="help-block"></span>
                                        </div>
                                    </div>  
                              </div>

                              <div class=" col-md-6">
                                   <div class="mb-3 row">
                                        <label for="jenjang_kelas_id" class="col-md-4 col-form-label">Jenjang Kelas </label>
                                        <div class="col-md-8">
                                            <select class="form-select form-control selectJenjangKelas" id="jenjang_kelas_id" name="jenjang_kelas_id">
                                                <option value="">--Pilih--</option>
                                               
                                                
                                            </select>
                                            <span class="help-block"></span>
                                        </div>
                                    </div>  
                              </div>   
                            </div>
                            

                            <div class=" row">
                                <div class=" col-md-6">
                                   <div class="row mb-3">
                                     <label for="jenis_pendaftaran" class="col-md-4 col-form-label">Program </label>
                                     <div class="mt-2 col-md-8">
                                           <div class="p-t-10">
                                                <label class="radio-container mx-2 " style="font-size: inherit;">
                                                    <input type="radio" checked="checked" name="program" id="program_cambridge" value="1">
                                                    Cambridge
                                                    <span class="checkmark"></span>
                                                </label>
                                                <label class="radio-container mx-2" style="font-size: inherit;">
                                                    <input type="radio" name="program" id="program_reguler" value="2">
                                                    Reguler
                                                    <span class="checkmark"></span>
                                                </label>
                                                <label class="radio-container mx-2" style="font-size: inherit;">
                                                    <input type="radio" name="program" id= "program_tahfiz" value="3">
                                                    Tahfidz
                                                    <span class="checkmark"></span>
                                                </label>
                                            </div>
                                            <span class="help-block"></span>
                                        </div>
                                        
                                    </div> 
                                </div>
                                <div class="col-md-6">
                                    
                                </div>
                                
                            </div>

                            <div class="mb-3 row">
                                <label for="nama_lengkap" class="col-md-2 col-form-label">Nama Lengkap</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="text" value=""  id="nama_lengkap" name="nama_lengkap" placeholder="Nama Sesuai Akte Kelahiran">
                                     <span class="help-block"></span>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                     <div class="mb-3 row">
                                        <label for="dob" class="col-md-4 col-form-label">Tanggal Lahir</label>
                                        <div class="col-md-8">
                                            <input class="form-control" type="date" value=""  id="dob" name="dob">
                                            <span class="help-block"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3 row">
                                        <label for="gender" class="col-md-4 col-form-label">Jenis Kelamin</label>
                                        <div class="mt-2 col-md-8">
                                           <div class="p-t-10">
                                                <label class="radio-container mx-2 " style="font-size: inherit;">
                                                    <input type="radio" checked="checked" id="gender_M" name="gender" value="M">
                                                    Laki-laki
                                                    <span class="checkmark"></span>
                                                </label>
                                                <label class="radio-container mx-2" style="font-size: inherit;">
                                                    <input type="radio" name="gender" id="gender_F" value="F">
                                                    Perempuan
                                                    <span class="checkmark"></span>
                                                </label>
                                            </div>
                                            <span class="help-block"></span>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                           
                            


                            <div class="mb-3 row">
                                <label for="asal_sekolah" class="col-md-2 col-form-label">Asal Sekolah</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="text"   placeholder="Isikan angka 0 (nol) jika belum pernah bersekolah"   id="asal_sekolah" name="asal_sekolah">
                                    <span class="help-block"></span>
                                </div>
                            </div>

                            <div class="row">
                                <div class=" col-md-6">
                                    <div class="mb-3 row">
                                        <label for="nama_ortu" class="col-md-4 col-form-label">Nama Orangtua/Wali</label>
                                        <div class="col-md-8">
                                            <input class="form-control" type="text" name="nama_ortu" id="nama_ortu" placeholder="nama sesuai KTP / Passport">
                                            <span class="help-block"></span>
                                        </div>
                                    </div> 
                                </div>
                                <div class=" col-md-6">
                                    <div class="mb-3 row">
                                        <label for="no_wa" class="col-md-4 col-form-label">No. Whatsapp</label>
                                        <div class="col-md-8">
                                            <input class="form-control" type="text"  placeholder="cth;0812345678910" id="no_wa" name="no_wa">
                                            <span class="help-block"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class=" col-md-6">
                                    <div class="mb-3 row">
                                        <label for="alamat_rumah" class="col-md-4 col-form-label">Alamat Rumah</label>
                                        <div class="col-md-8">
                                            <textarea class="form-control" type="text"  placeholder="cth: Jl. Karya Bersama No.34 Medan" id="alamat_rumah" name="alamat_rumah"></textarea>
                                            <span class="help-block"></span>
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class=" col-md-6">
                                    <div class="mb-3 row">
                                        <label for="email" class="col-md-4 col-form-label">email</label>
                                        <div class="col-md-8">
                                            <input class="form-control" type="email"  id="email" name="email">
                                            <span class="help-block"></span>
                                        </div>
                                    </div>

                                </div>
                            </div>


                             <div class="row">
                                <div class=" col-md-6">
                                    <div class="mb-3 row">
                                        <label for="alamat_rumah" class="col-md-4 col-form-label">Scan Akte Kelahiran</label>
                                        <div class="col-md-8">
                                            <input type="file" name="scan_akte" id="scan_akte" class="form-control">
                                            <span class="help-block"></span>
                                            
                                        </div>
                                    </div>

                                    <div class="imgScanAkte text-center">
                                    	
                                    </div>
                                </div>
                                <div class=" col-md-6">
                                    <div class="mb-3 row">
                                        <label for="email" class="col-md-4 col-form-label">Bukti Bayar</label>
                                        <div class="col-md-8">
                                            <input class="form-control" type="file"  id="scan_payment" name="scan_payment">
                                            <span class="help-block"></span>
                                        </div>
                                        <div class="imgScanPayment text-center">
                                        	
                                        </div>
                                    </div>

                                </div>
                            </div>


                            
                            <div class="row">
                                          
                                <div class=" col-md-6">
                                    <div class="mb-3 row">
                                        <label for="status_payment" class="col-md-4 col-form-label">Status Pembayaran</label>
                                        <div class="col-md-8">
                                            <select class="form-control" name="status_payment" id="status_payment">
                                                <option value="">--pilih-- </option>
                                                <option value="paid">paid</option>
                                                <option value="unpaid">unpaid</option>
                                            </select>
                                           
                                            <span class="help-block"></span>
                                        </div>
                                    </div> 
                                </div>
                                <div class=" col-md-6">
                                    <div class="mb-3 row">
                                        <label for="no_wa" class="col-md-4 col-form-label">Status Pendaftaran</label>
                                        <div class="col-md-8">
                                            <select class="form-control" name="status_verifikasi" id="status_verifikasi">
                                                <option value="1">Unverified</option>
                                                <option value="2">Verified</option>
                                                <option value="3">Cancel</option>
                                                
                                               
                                            </select>
                                            <span class="help-block"></span>
                                        </div>
                                    </div>
                                </div>


                            </div>

                            <div class=" row">
                                    <div class="mb-3 row">
                                        <label for="payment_status" class="col-md-2 col-form-label">Tanggal Seleksi</label>
                                        <div class="col-md-10">
                                            <input class="form-control dateTimePicker" type="text" name="tanggal_tes" id="tanggal_tes" value="">
                                            
                                           
                                            <span class="help-block"></span>
                                        </div>
                                    </div> 
                            </div>
                            



                        </div>
                        <div class="card-footer">
                            <div class="row">
                                
                         </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary SaveBtn" data-label="daftar_awal" id="btnSave">Simpan</button>
            </div>
        </div>
    </div>
</div>



