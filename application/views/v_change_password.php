<div class="row">
	<div class="col-sm-2"></div>
	<div class="col-sm-8 form-control">
	  <form method="POST" action="<?php echo base_url('login/editpass'); ?>">
		  <center><h3>Change Password</h3></center>
		  	<?php
		     if($this->session->flashdata('success')){
		        echo $this->session->flashdata('success');
		      }else if($this->session->flashdata('error')){
		        echo $this->session->flashdata('error');
		      }
			?>
		    <label><B>Username</B></label>
		    <input type="text" class="form-control" name="username" id="username1" value="<?php echo $getuser->username; ?>" required>

		  <br>

		  	<label><B>Current Password</B></label>
		    <input type="password" class="form-control" name="c_password" id="c_password1" required>

		  <br>

		    <label><B>New Password</B></label>
		    <input type="password" class="form-control" name="new_password" id="new_password1" required>

		  <br>

		    <label><B>Confirm Password</B></label>
		    <input type="password" class="form-control" name="con_password" id="con_password1" onChange="checkPasswordMatch();" required>

		    <div class="registrationFormAlert" id="divCheckPasswordMatch" style="margin-top: 10px;">
			</div>
		  <br>
		  <button type="submit" class="btn btn-info btn-fw form-control" style="padding: 10px; font-size: 20px; font-family: Poppins, sans-serif;" onclick="changepass()">Yes, Submit!</button>
	  </form>
	</div>
	<div class="col-sm-2"></div>
</div>

<!-- <script type="text/javascript">
    // var password = $("#new_password1").val();
    // var confirmPassword = $("#con_password1").val();

	function checkPasswordMatch() {
	    if (password != confirmPassword)
	        $("#divCheckPasswordMatch").html("<span class='label label-danger'>Passwords do not match!</span>");
	    else
	        $("#divCheckPasswordMatch").html("<span class='label label-primary'>Passwords match.</span>");
	}

	$(document).ready(function () {
	   $("#con_password1").keyup(checkPasswordMatch);
	});
</script> -->

<script type="text/javascript">
	var password = document.getElementById("new_password1");
	var confirm_password = document.getElementById("con_password1");

	function validatePassword(){
		  if(password.value != confirm_password.value) {
		    confirm_password.setCustomValidity("Passwords Don't Match");
		  } else {
		    confirm_password.setCustomValidity('');
		  }
	}

	password.onchange = validatePassword;
	confirm_password.onkeyup = validatePassword;
</script>