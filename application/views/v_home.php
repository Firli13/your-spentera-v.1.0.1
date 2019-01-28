<div class="page-header">
  <h3 class="page-title">
    <span class="page-title-icon bg-gradient-primary text-white mr-2">
      <i class="mdi mdi-home"></i>                 
    </span>
      <?php      
        $data_role = $this->session->userdata('role');
          if ($data_role=='bod'){
            echo 'Dashboard BOD';
          } elseif ($data_role=='admin') {
            echo 'Dashboard Admin';
          } elseif ($data_role=='employee') {
            echo 'Dashboard User';
          } else {
            redirect(base_url("login"));
          }
       ?>
  </h3>
  <nav aria-label="breadcrumb">
    <ul class="breadcrumb">
      <li class="breadcrumb-item active" aria-current="page">
        <span></span>Overview
        <i class="mdi mdi-alert-circle-outline icon-sm text-primary align-middle"></i>
      </li>
    </ul>
  </nav>
</div>
<?php
  $get_data = $data_user->row();
  $get_afl = $data_afl->num_rows();
  $get_listuser = $data_listuser->num_rows();

?>
<div class="row">
  <div class="col-md-4 stretch-card grid-margin">
    <div class="card bg-gradient-danger card-img-holder text-white">
      <div class="card-body">
        <img src="<?= base_url(); ?>assets/template/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image"/>
        <h4 class="font-weight-normal mb-3">Jumlah Cuti Tersisa
          <i class="mdi mdi-chart-line mdi-24px float-right"></i>
        </h4>
        <h2 class="mb-5"><?php echo $get_data->r_leave;?></h2>
        <h6 class="card-text">Anda butuh istirahat!</h6>
      </div>
    </div>
  </div>
  <div class="col-md-4 stretch-card grid-margin">
    <div class="card bg-gradient-info card-img-holder text-white">
      <div class="card-body">
        <img src="<?= base_url(); ?>assets/template/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image"/>                  
        <h4 class="font-weight-normal mb-3">List Application for Leave
          <i class="mdi mdi-bookmark-outline mdi-24px float-right"></i>
        </h4>
        <h2 class="mb-5"><?php echo $get_afl;?></h2>
        <h6 class="card-text">Your List Application for Leave</h6>
      </div>
    </div>
  </div>
  <?php $role = $this->session->userdata("role");?>
  <?php if($role=='admin'){?>
    <div class="col-md-4 stretch-card grid-margin">
      <div class="card bg-gradient-success card-img-holder text-white">
        <div class="card-body">
          <img src="<?= base_url(); ?>assets/template/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image"/>                                    
          <h4 class="font-weight-normal mb-3">List Users
            <i class="mdi mdi-diamond mdi-24px float-right"></i>
          </h4>
          <h2 class="mb-5"><?php echo $get_listuser;?></h2>
          <h6 class="card-text">We have <?php echo $get_listuser;?> users.</h6>
        </div>
      </div>
    </div>
  <?php }else{
          echo "";
        }
  ?>
</div>