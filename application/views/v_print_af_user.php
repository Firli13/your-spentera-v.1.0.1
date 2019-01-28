<?php
  defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="shortcut icon" href="<?= base_url(); ?>assets/images/icons/lg-yspen.png" />
  <?php
	   $get_data = $data_users->row();
  ?>
  <title><?php echo $get_data->name.' '.$get_data->date_create; ?></title>
</head>
<style type="text/css">
	* {
		margin: 0;
		padding: 0;
	}
	h4 {
		margin-top: 20px;
		margin-bottom: 15px;
		text-align: center;
	}
	p {
		margin-bottom: 5px;
		margin-left: 90px;
	}
	.pkiri {
		margin-left: 100px;
	}
	.pkanan {
		margin-left: 90px;
	}
	.patas{
		margin-top: 10px;
		margin-bottom: 10px;
	} 
	.p_tengah {
		text-align: center;
	}
</style>
<body>
	<div class="container">
		<table>
			<!-- <div class="Head"> -->
			
				<tr>
					<td colspan="2">
						<h4 style="margin-top: 100px;">APPLICATION FOR LEAVE</h4>
					</td>
				</tr>

				<!-- <div class="headinput"> -->
					<tr>
						<td>
							<p><b>Applicant's Name </b>/ Nama Pemohon</p>
							<p style="margin-bottom: 10px; font-style:italic;"><?php echo $get_data->name; ?></p>
						</td>
						<td>
							<p class="pkiri"><b>ID NO. </b></p>
							<p class="pkiri" style="margin-bottom: 10px; font-style:italic;"><?php echo $get_data->no_karyawan; ?></p>
						</td>
					</tr>
					<tr>
						<td>
							<p><b>Position </b>/ Jabatan </p>
							<p style="margin-bottom: 10px; font-style:italic;"><?php echo $get_data->jabatan; ?></p>
						</td>
						<td>
							<p class="pkiri"><b>DOH </b></p>
							<?php
				            	$doh = $get_data->doh;
				            ?>
							<p class="pkiri" style="margin-bottom: 10px; font-style:italic;"><?php echo tglindo($doh); ?></p>
						</td>
					</tr>
					<tr>
						<td>
							<p><b>Division/Directorate </b>/ Divisi/Direktorat</p>
							<p style="font-style:italic;"><?php echo $get_data->jabatan; ?></p>
						</td>
					</tr>	
				<!-- </div> -->

				<!-- <div class="IsiInput"> -->
					<tr>
						<td colspan="2">
							<h4 class="judul">PERIOD OF LEAVE</h4>
						</td>
					</tr>
					<tr>
						<td>
							<b class="pkanan">Please Specify the Type of Leave required</b><br><p style="font-style:italic;">(Mohon dirinci jelas cuti yang diperlukan)</p>
							<p class="patas"> <?php echo $get_afl->leave_required; ?> </p>
						</td>
						<td>
							<b class="pkiri">Reason</b><br><p style="font-style:italic;" class="pkiri">(Berikan Alasan)</p>
							<p class="pkiri patas"> <?php echo $get_afl->reason; ?></p>
						</td>
					</tr>
					<tr>
						<td>
							<b class="pkanan">Leave From</b><br><p style="font-style:italic;">Dari</p>
							<p class="patas"> <?php echo $get_afl->leave_from; ?></p>
						</td>
						<td>
							<b class="pkiri">To</b><br><p style="font-style:italic;" class="pkiri">Sampai</p>
							<p class="pkiri patas"> <?php echo $get_afl->leave_to; ?></p>
						</td>
					</tr>
					<tr>
						<td>
							<b class="pkanan">Back to Work</b><br><p style="font-style:italic;">(Kembali Kerja)</p>
							<p class="patas"> <?php echo $get_afl->back_work; ?></p>
						</td>
						<td>
							<b class="pkiri">Total  Days Leave Applied for</b><br><p style="font-style:italic;" class="pkiri">(Jumlah hari cuti yang diminta)</p>
							<p class="pkiri patas"> <?php echo $get_afl->total_days; ?></p>
						</td>
					</tr>
				<!-- </div> -->

				<!-- <div class="IsiOutput"> -->
					<tr>
						<td colspan="2">
							<h4>Admin/HRD/Paymasters Use Only</h4>
						</td>
					</tr>
					<tr>
						<td>
							<b class="pkanan">Entitlement (Days)</b>
							<p class="patas"> <?php echo $get_afl->balance; ?></p>
						</td>
						<td>
							<b class="pkiri">This Leave Approved (Days)</b>
							<p class="pkiri patas"> <?php echo $get_afl->leave_app; ?></p>
						</td>
					</tr>
					<tr>
						<td>
							<b class="pkanan">As At</b>
							<p class="patas"><?php echo $get_afl->as_at; ?></p>
						</td>
						<td>
							<b class="pkiri">Balance (Days)</b>
							<p class="pkiri patas"><?php echo $get_afl->balance; ?></p>
						</td>
					</tr>
				<!-- </div> -->

				<!-- <div class="TTD"> -->
					<tr>
						<td>
							<p style="font-style:italic; margin-top: 70px; text-align: center;"><b>Applicant's</b>/ Pemohon,</p>
							<p class="p_tengah"><b><?php echo $get_data->name; ?></b></p>
							<p class="p_tengah">Date : <?php echo $get_afl->date_create; ?></p>
						</td>
						<td>
							<p style="font-style:italic; margin-top: 68px; text-align: center;"><b>Approved By</b>/ Disetujui Oleh,</p>
							<p class="p_tengah"><b><?php echo $get_afl->name_app; ?></b></p>
							<p class="p_tengah">Date: <?php echo $get_afl->date_app; ?></p>
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<p style="font-style:italic; margin-top: 40px; text-align: center;"><b>Acknowledge By</b>/ Diketahui Oleh,</p>
							<p class="p_tengah"><b><?php echo $get_afl->name_cek; ?></b></p>
							<p class="p_tengah"><b>GA & FINANCE</b></p>
							<p class="p_tengah">Date : <?php echo $get_afl->date_knownby; ?></p>
						</td>
					</tr>
				<!-- </div> -->
			<!-- </div> -->
		</table>
	</div>
 </body>
</html>