<div class="main">
	
	<div class="main-inner">

	    <div class="container">
	
	      <div class="row">
	      	
	      	<div class="span8">      		
	      		
	      		<div class="widget ">
	      			
	      			<div class="widget-header">
	      				<i class="icon-list-alt"></i>
	      				<h3>Form Permohonan Pemeriksaan Sarana Bangunan</h3>
	  				</div> <!-- /widget-header -->
					
					<div class="widget-content">

						<div>
						
						<br>
						
							<div>
								<div id="formcontrols">
								<form class="form-horizontal" action="pages/komoditi/pangan/action/add_psb.php" id="formpsb" method="post">
									<fieldset>
										
										<div class="control-group">											
											<label class="control-label" for="tglmohon">Tanggal Permohonan</label>
											<div class="controls">
												<input type="text" class="span2" id="tglmohon" name="tglmohon" value="<?php echo date('d-m-Y'); ?>" readonly>
												<!-- <p class="help-block">Your username is for logging in and cannot be changed.</p> -->
											</div> <!-- /controls -->				
										</div> <!-- /control-group -->
										
										
										<div class="control-group">											
											<label class="control-label">Perihal Permohonan</label>
                                            
                                            <div class="controls">
                                            <label class="radio inline">
                                              <input type="radio" name="perihal" value="produksi" required> Pemeriksaan Sarana Produksi
                                            </label>
                                            
                                            <label class="radio inline">
                                              <input type="radio" name="perihal" value="distribusi" required> Pemeriksaan Sarana Distribusi
                                            </label>
                                          </div>	<!-- /controls -->			
										</div> <!-- /control-group -->
										<br><br>
										
										<div class="control-group">											
											<label class="control-label" for="namapemohon">Nama Pemohon</label>
											<div class="controls">
												<input type="text" class="span4" id="namapemohon" name="namapemohon" value="<?php echo $det['nama_detail'] ?>" readonly>
												<input type="hidden" class="span4" id="idpemohon" name="idpemohon" value="<?php echo $det['id_detail'] ?>">
											</div> <!-- /controls -->				
										</div> <!-- /control-group -->
										
										<div class="control-group">											
											<label class="control-label" for="alamatpemohon">Alamat Pemohon</label>
											<div class="controls">
												<input type="text" class="span4" id="alamatpemohon" name="alamatpemohon" value="<?php echo $det['alamat_detail']; ?>" readonly>
											</div> <!-- /controls -->				
										</div> <!-- /control-group -->
										<br><br>

										<div class="control-group">											
											<label class="control-label" for="namaperusahaan">Nama Perusahaan</label>
											<div class="controls">
												<input type="text" class="span4" id="namaperusahaan" name="namaperusahaan" value="<?php echo $det['nama_perusahaan'] ?>" readonly>
											</div> <!-- /controls -->				
										</div> <!-- /control-group -->
										
										<div class="control-group">											
											<label class="control-label" for="alamatperusahaan">Alamat Perusahaan</label>
											<div class="controls">
												<input type="text" class="span4" id="alamatperusahaan" name="alamatperusahaan" value="<?php echo $det['alamat_perusahaan']; ?>" readonly>
											</div> <!-- /controls -->				
										</div> <!-- /control-group -->

										<div class="control-group">											
											<label class="control-label" for="notelpperusahaan">Nomor Telepon/HP</label>
											<div class="controls">
												<input type="text" class="span4" id="notelpperusahaan" name="notelpperusahaan" value="<?php echo $det['notelp_perusahaan']; ?>" readonly>
											</div> <!-- /controls -->				
										</div> <!-- /control-group -->
										<br><br>

										<div class="control-group">											
											<label class="control-label" for="namagudang">Nama Gudang</label>
											<div class="controls">
												<input type="text" class="span4" id="namagudang" name="namagudang" value="<?php echo $det['nama_gudang'] ?>" readonly>
											</div> <!-- /controls -->				
										</div> <!-- /control-group -->
										
										<div class="control-group">											
											<label class="control-label" for="alamatgudang">Alamat Pabrik/Gudang</label>
											<div class="controls">
												<input type="text" class="span4" id="alamatgudang" name="alamatgudang" value="<?php echo $det['alamat_gudang']; ?>" readonly>
											</div> <!-- /controls -->				
										</div> <!-- /control-group -->

										<div class="control-group">											
											<label class="control-label" for="notelpgudang">Nomor Telepon/HP</label>
											<div class="controls">
												<input type="text" class="span4" id="notelpgudang" name="notelpgudang" value="<?php echo $det['notelp_gudang']; ?>" readonly>
												<input type="hidden" class="span4" id="idkomoditi" name="idkomoditi" value="<?php echo $det['id_komoditi']; ?>">
											</div> <!-- /controls -->				
										</div> <!-- /control-group -->
										<br><br>

										<div class="control-group">											
											<label class="control-label" for="notelpgudang">Jenis Pangan (Kemasan)</label>
											<div class="controls">
												<textarea class="span4" id="jenispangan" name="jenispangan" value=""></textarea>
												<br><span class="badge badge-warning">Jika lebih dari satu, pisahkan dengan tanda , (koma)</span>
												<br>
											</div> <!-- /controls -->				
										</div> <!-- /control-group -->
										<br><br>

										<div class="control-group">											
											<label class="control-label" for="namacp">Nama Contact Person</label>
											<div class="controls">
												<input type="text" class="span4" id="namacp" name="namacp" value="" required>
											</div> <!-- /controls -->				
										</div> <!-- /control-group -->

										<div class="control-group">											
											<label class="control-label" for="notelpcp">Nomor Telepon/HP</label>
											<div class="controls">
												<input type="number" class="span4" id="notelpcp" name="notelpcp" value="" required>
											</div> <!-- /controls -->				
										</div> <!-- /control-group -->
                                        
										
											
										 <br />
										
											
										<div class="form-actions">
											<button type="submit" class="btn btn-primary">Kirim Pengajuan <i class="icon-chevron-right"></i></button> 
											<a href="./index.php?page=2121" class="btn btn-danger">Cancel</a>
										</div> <!-- /form-actions -->
									</fieldset>
								</form>
								</div>
								
							</div>
						  
						  
						</div>
						
						
						
						
						
					</div> <!-- /widget-content -->
						
				</div> <!-- /widget -->
	      		
		    </div> <!-- /span8 -->
	      	
	      	
	      </div> <!-- /row -->
	
	    </div> <!-- /container -->
	    
	</div> <!-- /main-inner -->
    
</div> <!-- /main -->