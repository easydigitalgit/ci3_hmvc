<section class="section bg-white" id="home">
            <div class="bg-primary"></div>
            <div class="container">
                <div class="row align-items-center">
                    
                   <div class="card">
                        <div class="card-body">

                            <div class="row my-5">
								<h3 class="card-title text-center">Formulir Pendaftaran Calon Siswa Yayasan Pendidikan Shafiyyatul Amaliyyah</h3>
							</div>
                            <form action="#" id="form_front_registrasi" name="form_front_registrasi" method="post" accept-charset="utf-8">
                            <input type="hidden" name="id" id="id"> 
                           
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
                            </div>  
                             
                            <div class="row">

                                <div class="col-md-6">
                                   <div class="mb-3 row">
                                        <label for="tingkat" class="col-md-4 col-form-label">Tingkat </label>
                                        <div class="col-md-8">
                                            <select class="form-select form-control selectTingkat" id="tingkat_id" name="tingkat_id">
                                                <option value="">--Pilih--</option>
                                                
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
                                                    <input type="radio" checked="checked" name="program" value="1">
                                                    Cambridge
                                                    <span class="checkmark"></span>
                                                </label>
                                                <label class="radio-container mx-2" style="font-size: inherit;">
                                                    <input type="radio" name="program" value="2">
                                                    Reguler
                                                    <span class="checkmark"></span>
                                                </label>
                                                <label class="radio-container mx-2" style="font-size: inherit;">
                                                    <input type="radio" name="program" value="3">
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
                                    <input class="form-control text-uppercase" type="text" value=""  id="nama_lengkap" name="nama_lengkap" placeholder="Nama Sesuai Akte Kelahiran">
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
                                                    <input type="radio" checked="checked" name="gender" value="M">
                                                    Laki-laki
                                                    <span class="checkmark"></span>
                                                </label>
                                                <label class="radio-container mx-2" style="font-size: inherit;">
                                                    <input type="radio" name="gender" value="F">
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
                                <label for="asal_sekolah" class="col-md-2 col-form-label">Riwayat Sekolah Asal</label>
                                <div class="col-md-10">
                                    <select class="form-select form-control riwayatSekolah" id="riwayat_sekolah" name="riwayat_sekolah">
                                        <option value="">--pilih--</option>
                                        <option value="1">Belum Pernah Bersekolah</option>
                                        <option value="2">Alumni YPSA </option>
                                        <option value="3">Sekolah Asal Dalam Negeri</option>
                                        <option value="4">Sekolah Asal Luar Negeri</option>
                                    </select>
                                   
                                    <span class="help-block"></span>
                                </div> 
                            </div>
                            <div class="mb-3 row d-none unitAsal">
                                <label for="unit_asal_id" class="col-md-2 col-form-label">Unit </label>
                                <div class="col-md-10">
                                   <select class="form-control form-select" id="unit_asal_id" name="unit_asal_id">
                                        <option value="">--Pilih--</option>
                                        <option value="1">PG YPSA</option>
                                        <option value="2">TK YPSA</option>
                                        <option value="3">SD YPSA</option>
                                        <option value="4">SMP YPSA</option>
                                       
                                   </select>
                                    <span class="help-block"></span>
                                </div>
                            </div>

                            <div class="mb-3 row d-none asalSekolah">
                                <label for="asal_sekolah" class="col-md-2 col-form-label">Nama Sekolah Asal </label>
                                <div class="col-md-10">
                                    <input class="form-control text-uppercase" type="text" placeholder="contoh: SMP NEGERI 1 MEDAN" id="asal_sekolah" name="asal_sekolah">
                                    <span class="help-block"></span>
                                </div>
                            </div>

                            <div class="mb-3 row d-none propinsiKota">
                                <div class="col-md-6">
                                    <div class="mb-3 row">
                                        <label for="propinsi" class="col-md-4 col-form-label">Propinsi</label>
                                        <div class="col-md-8">
                                           <select class="form-control" id="propinsi_id" name="propinsi_id">
                                               <option value="">--Pilih--</option>
                                           </select>
                                            <span class="help-block"></span>
                                        </div>
                                    </div>
                                </div>
                                 <div class="col-md-6">
                                    <div class="mb-3 row">
                                        <label for="kota" class="col-md-4 col-form-label">Kabupaten/Kota</label>
                                        <div class="col-md-8">
                                           <select class="form-control" id="kota_id" name="kota_id">
                                               <option value="">--Pilih--</option>
                                           </select>
                                            <span class="help-block"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3 row d-none luarNegeri">
                                <div class="col-md-6">
                                    <div class="mb-3 row">
                                        <label for="negara_id" class="col-md-4 col-form-label">Negara Sekolah Asal</label>
                                        <div class="col-md-8">
                                           <select class="form-control" name="negara_id" id="negara_id">
                                               <option value="">--Pilih--</option>
                                           </select>
                                            <span class="help-block"></span>
                                        </div>
                                    </div>
                                </div>
                                 <div class="col-md-6">
                                    
                                </div>
                            </div>

                            <div class="row">
                                <div class=" col-md-6">
                                    <div class="mb-3 row">
                                        <label for="nama_ortu" class="col-md-4 col-form-label">Nama Orangtua/Wali</label>
                                        <div class="col-md-8">
                                            <input class="form-control text-uppercase" type="text" name="nama_ortu" id="nama_ortu" placeholder="Nama sesuai KTP/Paspor">
                                            <span class="help-block"></span>
                                        </div>
                                    </div> 
                                </div>
                                <div class=" col-md-6">
                                    <div class="mb-3 row">
                                        <label for="no_wa" class="col-md-4 col-form-label">No. Whatsapp</label>
                                        <div class="col-md-8">
                                            <input class="form-control" type="text" placeholder="cth: 0812345678910" id="no_wa" name="no_wa">
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
                                            <textarea class="form-control text-uppercase" type="text" placeholder="cth: Jl. Karya Bersama No.34 Medan" id="alamat_rumah" name="alamat_rumah"></textarea>
                                            <span class="help-block"></span>                                            
                                        </div>
                                    </div>
                                </div>
                                <div class=" col-md-6">
                                    <div class="mb-3 row">
                                        <label for="email" class="col-md-4 col-form-label">Email</label>
                                        <div class="col-md-8">
                                            <input class="form-control text-lowercase" type="email"  id="email" name="email">
                                            <span class="help-block"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                             <div class="mb-3 row  sumberInformasi">
                                <label for="sumber_informasi" class="col-md-2 col-form-label">Darimana Anda mengenal YPSA ? </label>
                                <div class="col-md-10">
                                    <select name="sumber_informasi" id="sumber_informasi" class="form-select form-control">
                                        <option value="">--Pilih--</option>
                                     
                                    </select>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="mb-3 row d-none  sumberInformasiLain">
                                <label for="sumber_informasi" class="col-md-2 col-form-label">Saya mengenal YPSA dari </label>
                                <div class="col-md-10">
                                    <input name="sumber_lain" id="sumber_lain" class="form-control">
                    
                                    <span class="help-block"></span>
                                </div>
                            </div>

                             <div class="row">
                                <div class=" col-md-6">
                                    <div class="mb-3 row">
                                        <label for="alamat_rumah" class="col-md-4 col-form-label">Scan Akte Kelahiran</label>
                                        <div class="col-md-8">
                                            <input type="file" name="scan_akte" id="scan_akte" class="form-control">
                                            <span class="help-block"></span>
											<span> file harus berekstensi .jpg atau .png dengan resolusi maks. 2000px x 2000px dan ukuran file tidak lebih dari 2MB </span>                                            
                                        </div>
                                    </div>
                                </div>
                                <div class=" col-md-6">
                                    <div class="mb-3 row">
                                        <label for="email" class="col-md-4 col-form-label">Bukti Bayar</label>
                                        <div class="col-md-8">
                                            <input class="form-control" type="file"  id="scan_payment" name="scan_payment">
                                            <span class="help-block"></span>
											<span> file harus berekstensi .jpg atau .png dengan resolusi maks. 2000px x 2000px dan ukuran file tidak lebih dari 2MB </span>
                                        </div>
                                    </div>
                                </div>
                            </div>



                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3 row ">
                                        <div class="col-md-6 row" >
                                            <div class="">
                                                 <span id="captImg" class="captcha-img col-6 mx-2"> <?php echo $captchaImg; ?> </span> <span class="col-6"> <a href="javascript:void(0)" class="reload-captcha refreshCaptcha btn btn-info btn-sm " style="font-size: 1.5em;" ><i class="fas fa-sync"></i></a> </span>  
                                            </div>
                                            
                                        </div>
                                        
                                        <div class="col-md-6">
                                            
                                                <input type="text" class="form-control" name="captcha" id="captcha" placeholder="Captcha" style="margin-bottom: 5px"/>
                                                <span class="help-block"></span>
                                               
                                          
                                        </div>
                                    </div>    
                                </div>
                         </form>
                                <div class="col-md-6 ">
                                   <div class="float-end "> <button class="btn btn-success SaveBtn " id="btnSave" name="btnSave" data-label="front_registrasi"> Daftar <i class="fas fa-save"></i> </button>  </div>         
                                </div>        
                            </div>    
                        </div>
                        
                    </div>



                   
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </section>