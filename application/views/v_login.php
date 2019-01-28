<?php
  defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Your Spentera | Login</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->  
  <link rel="shortcut icon" href="<?= base_url(); ?>assets/images/icons/lg-yspen.png">
<!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/Login_v13/vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/Login_v13/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/Login_v13/fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
<!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/Login_v13/fonts/iconic/css/material-design-iconic-font.min.css">
<!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/Login_v13/vendor/animate/animate.css">
<!--===============================================================================================-->  
  <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/Login_v13/vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/Login_v13/vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/Login_v13/vendor/select2/select2.min.css">
<!--===============================================================================================-->  
  <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/Login_v13/vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/Login_v13/css/util.css">
  <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/Login_v13/css/main.css">
<!--===============================================================================================-->
</head>
<body style="background-color: #999999;">
  
  <div class="limiter">
    <div class="container-login100">
      <div class="login100-more" style="background-image: url('<?= base_url(); ?>assets/images/bg-login.jpg');"></div>

      <div class="wrap-login100 p-l-50 p-r-50 p-t-72 p-b-50">
        <form class="login100-form validate-form" action="<?php echo base_url('login/verify_login');?>" method="post" autocomplete="off">
          <span class="login100-form-title p-b-59">
            <img src="<?= base_url(); ?>assets/images/ic-log.png" style="width: 100%;">
          </span>

          <div class="wrap-input100 validate-input" data-validate = "Valid email is required">
            <span class="label-input100">Email</span>
            <input class="input100" type="text" name="email" id="user" placeholder="Email address..." autofocus="">
            <span class="focus-input100"></span>
          </div>

          <div class="wrap-input100 validate-input" data-validate = "Password is required">
            <span class="label-input100">Password</span>
            <input class="input100" type="password" name="password" id="passwd" placeholder="*************" value="">
            <span class="focus-input100"></span>
          </div>

          <div class="wrap-login100-form-btn" style="width: 100%;">
            <div class="login100-form-bgbtn"></div>
            <button class="login100-form-btn text-center">
              Sign Up
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
  
<!--===============================================================================================-->
  <script src="<?= base_url(); ?>assets/Login_v13/vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
  <script src="<?= base_url(); ?>assets/Login_v13/vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
  <script src="<?= base_url(); ?>assets/Login_v13/vendor/bootstrap/js/popper.js"></script>
  <script src="<?= base_url(); ?>assets/Login_v13/vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
  <script src="<?= base_url(); ?>assets/Login_v13/vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
  <script src="<?= base_url(); ?>assets/Login_v13/vendor/daterangepicker/moment.min.js"></script>
  <script src="<?= base_url(); ?>assets/Login_v13/vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
  <script src="<?= base_url(); ?>assets/Login_v13/vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
  <script src="<?= base_url(); ?>assets/Login_v13/js/main.js"></script>
  <script type="text/javascript" src="<?= base_url(); ?>assets/js/jsencrypt.js"></script>
  <script type="text/javascript">
    $(document).ready(function() {
      $("form").submit(function(event) {
              var d = new Date();
              var n = d.getMinutes();

              var crypt = new JSEncrypt();
              var pub = "-----BEGIN PUBLIC KEY-----\
                        MIIBITANBgkqhkiG9w0BAQEFAAOCAQ4AMIIBCQKCAQBWDfHY9XNm3RnnNiL7oU2R\
                        2KbWDv1giYb25kz2ERd7eSc2zVwAN7MqB+Chc5IjpgIXZlTR50sA48O3ALsaPNhC\
                        9K8yKKep8rJWwqGtK70PQV4hRsO7avwTA/YevbN6qbiyysnKK3XWxD601HI17+My\
                        bbMhDeCYxiSAM9qgi6SHwYopXljAmAW1RhgKZpji/YtpjMnSUqbjbJvcCJ0KnENH\
                        rIUqJ7jmvDsX8EuzlnWJjwE+loEHuMgIMVL2UDbnrTvrXt+5oLCS+wpBy1uLysP+\
                        kZWiVJAZIr4JT4AWysnHD1yfqeHiVWEEKYHvj0xanUeZnY5rVOIMwpp7t0sb+8MN\
                        AgMBAAE=\
                        -----END PUBLIC KEY-----";

              crypt.setPublicKey(pub);
              var input = $('#passwd').val()+":"+n+":";
              var en = crypt.encrypt(input);
              var user = $('#user').val();
              $.ajax({
                          type: 'POST',
                          url: '<?php echo site_url('login/verify_login')?>',
                          data: { username: user,password: en,n:n},
                          success: function(response) {
                            if(response == 1){
                              window.location.href = '<?= base_url(); ?>home';
                              
                            }else{
                              window.location.href = '<?= base_url(); ?>login';
                            }

                          }

                      });
              event.preventDefault();

      });
    });
    </script>
</body>
</html>
