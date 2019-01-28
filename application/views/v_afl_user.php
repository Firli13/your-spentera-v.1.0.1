<div class="submen">
  <a class="btn btn-primary btn-lg" role="button" aria-pressed="true" href="<?= base_url(); ?>afl_user">Form AFL</a>
  <a class="btn btn-primary btn-lg" role="button" aria-pressed="true" href="<?= base_url(); ?>list_afl_user">List AFL</a>
</div>

<!-- Alert -->
<div class="row">
  <div class="col-lg-12">
    <?php
      if($this->session->flashdata('success')){
        echo $this->session->flashdata('success');
      }else if($this->session->flashdata('error')){
        echo '<div class="alert bg-danger" role="alert"><em class="fa fa-lg fa-warning">&nbsp;</em> Somthing worng. Error!! <a href="#" class="pull-right"><em class="fa fa-lg fa-close"></em></a></div>';
      }
    ?>
  </div>
</div>
<!-- End of Alert -->

<div id="accordion">
  <div class="card">
    <div class="card-header" id="headingOne">
      <h5 class="mb-0">
        <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne" style="color: #ffffff; font-size: 1rem;">
          <?= $title; ?>
        </button>
      </h5>
    </div>

    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
      <div class="card-body">
        <form action="<?= base_url('afl_user/create_afl'); ?>" method="post" enctype="multipart/form-data">
          <div class="form-row">
            <?php
              $get_data = $data_user->row();
            ?>
            <div class="form-group col-md-6">
              <label>Applicant's Name (Nama Pemohon)</label>
              <input type="text" class="form-control" value="<?php echo $get_data->name; ?>" readonly>
            </div>
            <div class="form-group col-md-6">
              <label>ID NO</label>
              <input type="text" class="form-control" value="<?php echo $get_data->no_karyawan; ?>" readonly>
            </div>
            <div class="form-group col-md-6">
              <label >Position (Jabatan)</label>
              <input type="text" class="form-control" value="<?php echo $get_data->jabatan; ?>" readonly>
            </div>
            <div class="form-group col-md-6">
              <label>DOH</label>
              <?php
                $doh = $get_data->doh;
              ?>
              <input type="text" class="form-control" value="<?php echo tglindo($doh); ?>" readonly>
            </div>
            <div class="form-group col-md-6">
              <label >Division/Directorate (Divisi/Direktorat)</label>
              <input type="text" class="form-control" value="<?php echo $get_data->jabatan; ?>" readonly>
            </div>
          </div>
          <div class="card">
            <div class="card-header">
              <h4 style="padding: 0px; margin: 0px">Period of Leave (Periode Cuti)</h4>
            </div>
            <div class="card-body">
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label><b>Please Specify the Type of Leave required</b><br><p style="margin: 0px; font-style:italic">(Mohon dirinci jelas cuti yang diperlukan)</p></label>
                    <select class="form-control afluser" id="leave_required" name="leave_required">
                      <option disabled>-- Select --</option>
                      <option value="Annual">Annual</option>
                      <option value="Sick">Sick</option>
                      <option value="Long Service">Long Service</option>
                      <option value="Leave Without Pay">Leave Without Pay</option>
                      <option value="Other">Other</option>
                    </select>
                </div>
                <div class="form-group col-md-6">
                  <label ><b>Reason</b><p style="margin: 0px; font-style:italic">(Berikan Alasan)</p></label>
                  <textarea class="form-control" id="reason" name="reason" placeholder="Input text here"></textarea>
                </div>
                <div class="form-group col-md-6">
                  <label><b>Leave From</b><p style="margin: 0px; font-style:italic">(Dari)</p></label>
                  <input class="form-control" id="leave_from" name="leave_from" >
                </div>
                <div class="form-group col-md-6">
                  <label><b>To</b><p style="margin: 0px; font-style:italic">(Sampai)</p></label>
                  <input class="form-control" id="leave_to" name="leave_to" >
                </div>
                <div class="form-group col-md-6">
                  <label ><b>Back to Work</b><p style="margin: 0px; font-style:italic">(Kembali Kerja)</p></label>
                  <input class="form-control" id="back_work" name="back_work" >
                </div>
                <div class="form-group col-md-6">
                  <label ><b>Total  Days Leave Applied for</b><p style="margin: 0px; font-style:italic">(Jumlah hari cuti yang diminta)</p></label>
                  <input type="number" min="1" max="30" class="form-control" id="total_days" name="total_days" placeholder="Input text here">
                </div>
              </div>
            </div>
          </div>
          <div class="card">
            <div class="card-header">
              <h4 style="padding: 0px; margin: 0px">Admin/HRD/Paymasters Use Only</h4>
            </div>
            <div class="card-body">
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label><b>Entitlement (Days)</b></label>
                  <input type="text" class="form-control" id="entitlement" name="entitlement" value="<?php echo $get_data->r_leave; ?>" readonly>
                </div>
                <div class="form-group col-md-6">
                  <label><b>This Leave Approved (Days)</b></label>
                  <input type="text" class="form-control" id="leave_app" name="leave_app" readonly>
                </div>
                <div class="form-group col-md-6">
                  <label><b>As At</b></label>
                  <input type="text" class="form-control" id="as_at" name="as_at" value="<?php echo $as_at;?>" readonly>
                </div>
                <div class="form-group col-md-6">
                  <label><b>Balance (Days)</b></label>
                  <input type="text" class="form-control" id="balance" name="balance" value="<?php echo $get_data->r_leave; ?>" readonly>
                </div>
              </div>
            </div>
          </div>
          <button type="submit" class="btn btn-info btn-fw form-control" style="padding: 10px; font-size: 20px; font-family: Poppins, sans-serif;">Yes, I Want Holidays</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script>

    $('#leave_from').datepicker({
        uiLibrary: 'bootstrap4'
    });
    $('#leave_to').datepicker({
        uiLibrary: 'bootstrap4'
    });
    $('#back_work').datepicker({
        uiLibrary: 'bootstrap4'
    });
</script>

<script type="text/javascript">
  function print_afl(){
      $.ajax({
        type: 'POST',
        url: '<?php echo site_url('list_afl_user/vprint_afl')?>',
    });
  }
</script>