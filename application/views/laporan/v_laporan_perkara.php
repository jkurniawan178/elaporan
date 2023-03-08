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
				<!-- Panel Awal Generate Laporan -->
				<div class="x_panel">
					<div class="x_title">
						<h2>Cetak Laporan <small>Silahkan Pilih Jenis, Periode dan Tanggal Laporan</small></h2>
						<div class="clearfix"></div>
					</div>
					<div class="x_content">
						<br />
						<form id="form-laporan" data-parsley-validate class="form-horizontal form-label-left">
							<div class="item form-group">
								<label class="col-form-label col-md-3 col-sm-3 label-align">Jenis Laporan</label>
								<div class="col-md-6 col-sm-6 ">
									<select class="form-control" id="jenis_laporan">
										<option value="-" disabled selected>====== Silahkan Pilih Jenis Laporan ======</option>
										<?php foreach ($jenis_lap as $row) : ?>
											<option value="<?= $row->jenis_laporan ?>"><?= $row->nama_laporan ?></option>
										<?php endforeach; ?>
									</select>
								</div>
							</div>
							<div class="item form-group">
								<label class="col-form-label col-md-3 col-sm-3 label-align" for="last-name">Periode <span class="required">*</span>
								</label>
								<div class="col-md-6 col-sm-6">
									<div class="row">
										<div class="col-md-3 col-sm-3 ">
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
							<div class="item form-group">
								<label for="middle-name" class="col-form-label col-md-3 col-sm-3 label-align">Tanggal Laporan</label>
								<fieldset>
									<div class="control-group">
										<div class="controls">
											<div class="col-md-11 xdisplay_inputx form-group row has-feedback">
												<input type="text" class="form-control has-feedback-left" id="date_lapor" placeholder="First Name" aria-describedby="inputSuccess2Status2">
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
				<!-- Panel Verifikasi Laporan -->
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
						<br />
						<form id="form-verifikasi" data-parsley-validate class="form-horizontal form-label-left">
							<table id="t_laporan" class="table table-bordered text-center">
								<thead>
									<tr>
										<th>No</th>
										<th>Jenis Laporan</th>
										<th>Periode Laporan</th>
										<th>Tanggal Laporan</th>
										<th>Status Verifikasi</th>
										<th>Download</th>
									</tr>
								</thead>
								<tbody>
								</tbody>
							</table>
						</form>
						<div class="ln_solid"></div>

						<!-- Modal -->
						<div class="modal fade" id="modal_verifikasi" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title" id="staticBackdropLabel">Verifikasi Laporan Perkara</h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<div class="modal-body">
										<p>Processing request - Harap jangan menutup jendela sebelum proses selesai</p>
										<p id="proses_verifikasi"></p>
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-success" disabled style="display: none;">Selesai</button>
									</div>
								</div>
							</div>
						</div>
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

<script type="text/javascript">
	function getMonthName(monthNumber) {
		const monthNames = ["Januari", "Februari", "Maret", "April", "Mai", "Juni", "Juli", "Augustus", "September", "Oktober", "November", "Desember"];
		return monthNames[monthNumber - 1];
	}

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

		//Button Generate on click
		$('#btn_generate').on('click', function() {
			var jenis_laporan = $('#jenis_laporan').val();
			var bulan = $('#bulan').val();
			var tahun = $('#tahun').val();
			var tanggal_laporan = $('#date_lapor').val();
			$('#btn-download-laporan').attr("href", '')
			$('#panel-verifikasi').hide();

			//send post to controller laporan_perkara
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
				success: function(data) {
					if (data.kode == "200") {
						var jenis = jenis_laporan.replace("_", " ").toUpperCase();
						$('#panel-verifikasi').show();
						$('#preview_laporan').html('Preview Laporan ' + jenis + '<small>Periksa Laporan Terlebih Dahulu Sebelum anda verifikasi</small>');

						//mengisi tabel
						var row1 = $('<tr>');
						var col1 = $('<td>').text('1');
						var col2 = $('<td>').text(jenis_laporan.replace('_', " ").toUpperCase());
						var col3 = $('<td>').text(getMonthName(bulan) + " " + tahun);
						var col4 = $('<td>').text(tanggal_laporan)
						var col5 = $('<td>').text('status verifikasi')
						var col6 = $('<td>').html('<a href="' + data.data + '" id="btn-download-laporan" class="btn btn-info btn-sm"><i class="fa fa-file-excel-o"></i>  Excel</a>')
						row1.append(col1, col2, col3, col4, col5, col6)

						var row2 = $('<tr>');
						var col7 = $('<td colspan="6" class="text-center">').html(
							`<div class="form-group form-check">
    							<input type="checkbox" class="form-check-input" id="check_pernyataan">
    							<label class="form-check-label" for="check_pernyataan">Saya menyatakan bahwa laporan perkara tersebut sudah diperiksa dan sesuai, serta siap mempertanggungjawabkan jika ditemukan kesalahan</label>
 							 </div>
							<button type="button" disabled id="button-verif" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modal_verifikasi">Verifikasi</button>
							`)
						row2.append(col7);

						$('#t_laporan tbody').empty();
						$('#t_laporan tbody').append(row1).append(row2);

						//Checkbox Pernyataan
						$('#check_pernyataan').change(function() {
							$("#button-verif").prop("disabled", !this.checked);
						})

						//Button Verifikasi on click
						$('#button-verif').on('click', function() {
							//Proses verifikasi data
							//1. send data to controller Verifikasi_lipa
							$.ajax({
								type: "POST",
								url: "<?php echo base_url('index.php/verifikasi_lipa/do_verifikasi') ?>",
								dataType: "JSON",
								data: {
									url: data.data
								},
								beforeSend: function() {
									// $('#spinner').show();
								},
								success: function(data) {},
								error: function(xhr, status, error) {
									//do something here
								},
								complete: function(xhr, status) {
									// $('#spinner').hide();
								}
							})
						})

					} else if (data.kode == "201" || data.kode == '202') {
						//create something here
						alert(data.data)
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