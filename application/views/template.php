<?php
  defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <!-- plugins:css -->
  <link rel="stylesheet" href="<?= base_url(); ?>assets/template/vendors/iconfonts/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="<?= base_url(); ?>assets/template/vendors/css/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- inject:css -->
  <link rel="stylesheet" href="<?= base_url(); ?>assets/template/css/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="<?= base_url(); ?>assets/images/icons/lg-yspen.png" />
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap4.min.css">
  <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/gijgo@1.9.10/js/gijgo.min.js" type="text/javascript"></script>
  <link href="https://cdn.jsdelivr.net/npm/gijgo@1.9.10/css/gijgo.min.css" rel="stylesheet" type="text/css" />
</head>

<body>
  <div class="container-scroller">
    <nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
      <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
        <a class="navbar-brand brand-logo" href=""><img src="<?= base_url(); ?>assets/images/ic-log.png" alt="logo"/></a>
      </div>
      <div class="navbar-menu-wrapper d-flex align-items-stretch">
        <ul class="navbar-nav navbar-nav-right">
          <li class="nav-item nav-profile dropdown">
            <a class="nav-link dropdown-toggle" id="profileDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
              <i class="mdi mdi-account"></i>   
              <div class="nav-profile-text">
                <p class="mb-1 text-black"><?php echo "Hello, " . $_SESSION["name"]; ?></p>
              </div>
            </a>
            <div class="dropdown-menu navbar-dropdown" aria-labelledby="profileDropdown">
              <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="<?= base_url(); ?>login/changepass">
                  <i class="mdi mdi-account-key mr-2 text-primary"></i>
                  Change Password
                </a>
                <a class="dropdown-item" href="<?= base_url(); ?>login/logout">
                  <i class="mdi mdi-logout mr-2 text-primary"></i>
                  Signout
                </a>
            </div>
          </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
          <span class="mdi mdi-menu"></span>
        </button>
      </div>
    </nav>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <!-- partial:partials/_sidebar.html -->
      <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav" style="">
          <?php
            if (isset($active_home)) {
              # code...
              $active_home=$active_home;
            }else{
              $active_home='';
            }
            if (isset($active_users_management)) {
              # code...
              $active_users_management=$active_users_management;
            }else{
              $active_users_management='';
            }
            if (isset($active_afl_user)) {
              # code...
              $active_afl_user=$active_afl_user;
            }else{
              $active_afl_user='';
            }
            if (isset($active_afl)) {
              # code...
              $active_afl=$active_afl;
            }else{
              $active_afl='';
            }
          ?>
          <style type="text/css">
            .size-profile{
              font-size: 200%;
            }
            .nav-item a{
              font-size:100%;
            }
          
    
           
         

         

          @media (max-width: 991px){
            .navbar .navbar-brand-wrapper .navbar-brand.brand-logo {
                display: unset; 
              }

              .navbar.default-layout-navbar .navbar-brand-wrapper {
                  width: 170px;
              }
          }
          
          @media only screen and (max-width: 768px) {
              .content-wrapper {
                  padding: 0.5rem 2.25rem;
              }

             
          }
           @media only screen and (max-width: 425px) {
              .content-wrapper {
                  padding:unset;
              }

              .card .card-body {
                   padding: 0.5rem;
                }
          }
          
          </style>
          <li class="nav-item nav-profile">
            <a href="#" class="nav-link">
              <i class="mdi mdi-account size-profile"></i>
              <div class="nav-profile-text d-flex flex-column">
                <span class="font-weight-bold mb-2"><?php echo $_SESSION["name"]; ?></span>
                <span class="text-secondary text-small"><?php echo jabatan($this->session->userdata('uniq_id'));?></span>
              </div>
            </a>
          </li>
          <li class="<?php echo $active_home; ?> nav-item">
            <a class="nav-link" href="<?= base_url(); ?>home">
              <span class="menu-title">Dashboard</span>
              <i class="mdi mdi-home menu-icon"></i>
            </a>
          </li>
            <?php $role = $this->session->userdata("role");?>
              <?php if($role=='admin'){?>

                  <li class="<?php echo $active_users_management; ?> nav-item">
                    <a class="nav-link" href="<?= base_url(); ?>users_management">
                      <span class="menu-title">Users Management</span>
                      
                    </a>
                  </li>
                  <li class="<?php echo $active_afl_user; ?> nav-item">
                    <a class="nav-link" href="<?= base_url(); ?>afl_user">
                      <span class="menu-title">Application for Leave</span>
                     
                    </a>
                  </li>
                  <li class="<?php echo $active_afl; ?> nav-item">
                    <a class="nav-link"  href="<?= base_url(); ?>list_afl">
                      <span class="menu-title" >List Application for Leave</span>
                      
                    </a>
                  </li>
                <?php }else if ($role=='employee'){?>
                  <li class="<?php echo $active_afl; ?> nav-item">
                    <a class="nav-link" href="<?= base_url(); ?>afl_user">
                      <span class="menu-title">Application for Leave</span>
                    </a>
                  </li>
                <?php }else if($role=='bod'){
                   echo '<li class="'.$active_afl.' nav-item">
                      <a class="nav-link" href="'.base_url().'list_afl">
                        <span class="menu-title" style="margin-right: 9px;">List Application for Leave</span>
                        <i class="mdi mdi-format-list-bulleted menu-icon"></i>
                      </a>
                    </li>';
                }else{
                    redirect(base_url("login"));
                  }
                ?>
        </ul>
      </nav>
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
          <?php $this->load->view($page); ?>
        </div>
        <!-- content-wrapper ends -->
        <footer class="footer"><center>
          <div class="d-sm-flex justify-content-center justify-content-sm-between">
            
              <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © 2018 version v.1.0.1</span>
            
          </div></center>
        </footer>
        <!-- partial -->
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->

  <!-- plugins:js -->
  <script src="<?= base_url(); ?>assets/template/vendors/js/vendor.bundle.base.js"></script>
  <script src="<?= base_url(); ?>assets/template/vendors/js/vendor.bundle.addons.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page-->
  <!-- End plugin js for this page-->
  <!-- inject:js -->
  <script src="<?= base_url(); ?>assets/template/js/off-canvas.js"></script>
  <script src="<?= base_url(); ?>assets/template/js/misc.js"></script>
  <!-- endinject -->
  <!-- Custom js for this page-->
  <script src="<?= base_url(); ?>assets/template/js/dashboard.js"></script>
  <!-- End custom js for this page-->
  
  <script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap4.min.js"></script>

</body>

</html>

<script type="text/javascript">
  var dt_users;
  $(document).ready(function() {
    dt_users = $('#dt_users').DataTable({ 
 
      "processing": true, //Feature control the processing indicator.
      "serverSide": true, //Feature control DataTables' server-side processing mode.
      "order": [], //Initial no order.

      // Load data for the table's content from an Ajax source
      "ajax": {
        "url": "<?php echo site_url('users_management/ajax_list')?>",
        "type": "POST"
      },

      //Set column definition initialisation properties.
      "columnDefs": [
      { 
        "targets": [ 0,1,2,3,4,5,6], //first column / numbering column
        "orderable": false, //set not orderable
      },
      ]
    });     
  });

</script>

