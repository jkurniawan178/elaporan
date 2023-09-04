<!-- page content -->
<div class="right_col" role="main">
	<div class="">
		<div class="page-title">
			<div class="title_left">
				<h2>Laporan Perkara (LIPA)</h2>
			</div>
		</div>
		<div class="clearfix"></div>
		<div class="row">
			<div class="col-md-12 col-sm-12 ">
				<div class="x_panel">
					<div class="x_title">
						<h2>Cetak Laporan <small>Pilih Jenis, Periode dan Tanggal Laporan</small></h2>
						<div class="clearfix"></div>
					</div>
					<div class="x_content">
						<br />
						<form id="form-laporan" data-parsley-validate class="form-horizontal form-label-left">
							<div class="form-group row">
								<label class="col-form-label col-md-3 col-sm-3 d-flex justify-content-md-end" for="jenis_laporan">Jenis Laporan <span class="required text-danger">*</span></label>
								<div class="col-md-8 col-sm-8">
									<select class="form-control" id="jenis_laporan">
										<option value="-" disabled selected>====== Silahkan Pilih Jenis Laporan ======</option>
										<option value="lipa_1">LAPORAN KEADAAN PERKARA (LIPA.1) </option>
										<option value="lipa_2">LAPORAN PERKARA YANG DIMOHONKAN BANDING (LIPA.2) </option>
										<option value="lipa_3">LAPORAN YANG DIMOHONKAN KASASI (LIPA.3) </option>
										<option value="lipa_4">LAPORAN PERKARA YANG DIMOHONKAN PENINJAUAN KEMBALI (LIPA.4) </option>
										<option value="lipa_5">LAPORAN PERKARA YANG DIMOHONKAN EKSEKUSI (LIPA.5) </option>
										<option value="lipa_6">LAPORAN KEGIATAN HAKIM (LIPA.6) </option>
										<option value="lipa_7a">LAPORAN KEUANGAN PERKARA (LIPA.7.A) </option>
										<option value="lipa_7b">LAPORAN KEUANGAN PERKARA EKSEKUSI (LIPA.7.B) </option>
										<!-- <option value="lipa_7c">LAPORAN KEUANGAN PERKARA KONSIGNASI(LIPA.7.C) </option> -->
										<option value="lipa_8">LAPORAN PERKARA DITERIMA, DICABUT DAN DIPUTUS MENURUT JENIS PERKARA (LIPA.8) </option>
										<option value="lipa_9">LAPORAN PERKARA KHUSUS PP. NO.10 TAHUN 1983 JO. PP. NO.45 TAHUN 1990 (LIPA.9) </option>
										<option value="lipa_10">LAPORAN PENYEBAB TERJADINYA PERCERAIAN (LIPA.10) </option>
										<!-- <option value="lipa_11">LAPORAN PERTANGGUNGJAWABAN UANG IWADL (LIPA.11) </option> -->
										<option value="lipa_12">LAPORAN MEDIASI (LIPA.12) </option>
										<option value="lipa_13">LAPORAN PENERBITAN AKTA CERAI (LIPA.13)</option>
										<option value="lipa_14">LAPORAN SIDANG DILUAR GEDUNG (LIPA.14)</option>
										<option value="lipa_15">LAPORAN PELAKSANAAN PEMBEBASAN BIAYA PERKARA (LIPA.15)</option>
										<option value="lipa_16">LAPORAN PELAKSANAAN POSBAKUM (LIPA.16)</option>
										<option value="lipa_17">LAPORAN PENERIMAAN HAK-HAK KEPANITERAAN (HHK) (LIPA.17) </option>
										<option value="lipa_18">LAPORAN PENERIMAAN HAK-HAK KEPANITERAAN LAINNYA (HHKL) (LIPA.18) </option>
										<option value="lipa_19">LAPORAN MINUTASI PERKARA (LIPA.19)</option>
										<option value="lipa_20">LAPORAN TINGKAT PENYELESAIAN PERKARA (LIPA.20)</option>
										<option value="lipa_21">LAPORAN VERZET TERHADAP PUTUSAN VERSTEK (LIPA.21)</option>
										<option value="lipa_22">LAPORAN PENANGANAN BANTUAN PANGGILAN ATAU PEMBERITAHUAN (LIPA.22)</option>
										<option value="lipa_23">LAPORAN PERKARA E-COURT (LIPA.23)</option>
										<option value="lipa_24">LAPORAN PERSIDANGAN ELEKTRONIK (LIPA.24)</option>
									</select>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-form-label col-md-3 col-sm-3 d-flex justify-content-md-end" for="bulan">Periode <span class="required text-danger">*</span>
								</label>
								<div class="col-md-8 col-sm-8">
									<div class="row">
										<div class="col-md-3 col-sm-4 mb-2 mb-md-0">
											<select class="form-control" name="bulan" id="bulan" style="padding:8px 0;">
												<?php for ($i = 1; $i <= 12; $i++) { ?>
													<option value="<?php if (strlen($i) == 2) {
																		echo $i;
																	} else {
																		echo '0' . $i;
																	} ?>" <?php if (@$bulan == $i) {
																				echo "selected";
																			} ?>><?php echo $nm_bulan[$i]; ?></option><?php	} ?>

											</select>
										</div>
										<div class="col-md-3 col-sm-3">
											<select class="form-control" name="tahun" id="tahun" style="padding:8px 0;">
												<?php $thn1 = date("Y");
												$thn2 = 2015;
												for ($i = $thn1; $i >= $thn2; $i = $i - 1) {  ?>
													<option value="<?php echo $i; ?>" <?php if (@$tahun == $i) {
																							echo "selected";
																						} ?>><?php echo $i; ?></option>';
												<?php }
												?>
											</select>
										</div>
									</div>
								</div>
							</div>
							<div class="form-group row">
								<label for="date_lapor" class="col-form-label col-md-3 col-sm-3 d-flex justify-content-md-end">Tanggal Laporan<span class="required text-danger">*</span></label>
								<fieldset class="col-md-5 col-sm-5">
									<div class="control-group">
										<div class="controls">
											<div class="xdisplay_inputx form-group row has-feedback">
												<input type="text" class="form-control has-feedback-left" id="date_lapor" placeholder="Tanggal laporan" aria-describedby="inputSuccess2Status2">
												<span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
												<span id="inputSuccess2Status2" class="sr-only">(success)</span>
											</div>
										</div>
									</div>
								</fieldset>
							</div>
							<div class="ln_solid"></div>
							<div class="item form-group">
								<div class="col-md-6 col-sm-6 offset-md-3">
									<button id="btn_generate" type="button" class="btn btn-success">Generate Laporan</button>
								</div>
							</div>
						</form>
					</div>
				</div>
				<div class="d-flex justify-content-center">
					<div class="spinner-border text-info" id="spinner" style="width: 5rem; height: 5rem; display:none;" role="status">
						<span class="sr-only">Loading...</span>
					</div>
				</div>
				<div class="x_panel" id="panel-verifikasi" style="display: none;">
					<div class=" x_title">
						<h2 id="preview_laporan">Preview Laporan <small>Periksa Laporan Terlebih Dahulu Sebelum anda verifikasi</small></h2>
						<ul class="nav navbar-right panel_toolbox">
							<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
							</li>
						</ul>
						<div class="clearfix"></div>
					</div>
					<div class="x_content">
						<form id="form-verifikasi" data-parsley-validate class="form-horizontal form-label-left">
							<div class="item form-group">
								<a href="#" id="btn-download-laporan" class="btn btn-primary pull-right btn-sm"><i class="fa fa-download"></i> Download Laporan</a>
								<!-- <button type="button" class="btn btn-info btn-sm" style="display: none;">Verifikasi Laporan</button> -->
							</div>
						</form>
						<div class="ln_solid my-1"></div>

						<h2 class="text-center" id="judul_laporan"></h2>
						<h2 class="text-center" id="nama_pengadilan"></h2>
						<h2 class="text-center" id="periode_laporan"></h2>
						<h4 class="text-right" id="kode_lipa"></h4>

						<div id="table-content"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
<!-- /page content -->

<!-- jQuery -->
<script src="<?php echo base_url() ?>resources/jquery/dist/jquery.min.js"></script>
<script src="<?php echo base_url() ?>resources/js/helper.js"></script>

<script type="text/javascript">
	$(document).ready(function() {
		const formatDate = 'DD/MM/YYYY'
		$("#date_lapor").daterangepicker({
				singleDatePicker: true,
				singleClasses: "picker_1",
				locale: {
					format: formatDate,
				}
			},
			function(start, end, label) {
				// console.log(start.toISOString(), end.toISOString());
			}
		);
		$('#btn_generate').on('click', function() {
			const jenis_laporan = $('#jenis_laporan').val();
			const bulan = $('#bulan').val();
			const tahun = $('#tahun').val();
			const tanggal_laporan = $('#date_lapor').val();
			const jenis_text = $('#jenis_laporan option:selected').text();
			const nama_PA = $('#nama_PA').text();
			$('#btn-download-laporan').attr("href", '')
			$('#panel-verifikasi').hide();


			$.ajax({
				type: "POST",
				url: "<?php echo base_url('index.php/laporan_perkara/get_lipa') ?>",
				dataType: "JSON",
				data: {
					jenis_laporan: jenis_laporan,
					bulan: bulan,
					tahun: tahun,
					tanggal_laporan: tanggal_laporan
				},
				beforeSend: function() {
					$('#spinner').show();
				},
				success: function(response) {
					if (response.kode == "200") {
						var jenis = jenis_laporan.replace("_", " ").toUpperCase();
						$('#panel-verifikasi').show();
						$('#btn-download-laporan').attr("href", response.link)
						$('#preview_laporan').html('Preview Laporan ' + jenis + ' Periode ' + pilihBulan(bulan) + ' ' + tahun + '<small>Periksa Laporan Terlebih Dahulu Sebelum anda verifikasi</small>');

						//table view
						$('#judul_laporan').text(jenis_text);
						$('#nama_pengadilan').text(`PADA ${nama_PA.toUpperCase()}`);
						$('#periode_laporan').text(`PERIODE ${pilihBulan(bulan).toUpperCase()} ${tahun}`);
						$('#kode_lipa').text(jenis_laporan);
						$('#table-content').html(response.table);
						generateTableRows(response.data);
					} else if (response.kode == "201" || response.kode == '202') {
						iziToast.error({
							title: 'Error!',
							message: response.data,
							position: 'topCenter'
						});
					}
				},
				error: function(xhr, status, error) {
					//do something here
				},
				complete: function(xhr, status) {
					$('#spinner').hide();
				}
			});
			return false;
		});
	})
</script>