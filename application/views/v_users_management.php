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
<div class="row">
<div class="col-12 grid-margin">
  <div class="card">
    <div class="card-body">
      <p>
        <button type="button" class="btn btn-success btn-fw" title="Add User" data-toggle="modal" data-target="#exampleModal">
          <i class="mdi mdi-plus" style="font-size: 35px;"></i>
        </button>
      </p>
      <div class="table-responsive">
        <table id="dt_users" class="table table-striped table-bordered">
          <thead>
            <tr style="text-align: center">
              <th style="width: 10px;">No</th>
              <th>Username</th>
              <th>Name</th>
              <th>Date Create</th>
              <th>Position</th>
              <th>Role</th>
              <th style="width: 65px;">Action</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalLabel">Create Users</h4>
      </div>
      <div class="modal-body">
        <form action="<?php echo base_url('users_management/create_users'); ?>" method="post" enctype="multipart/form-data">
          <div class="form-group">
            <label  class="control-label">ID NO</label>
            <input type="text" class="form-control" name="no_kar" id="no_kar" required>
          </div>
          <div class="form-group">
            <label  class="control-label">DOH (Date of Hire)</label>
            <input class="form-control" name="doh" id="doh" required>
          </div>
          <div class="form-group">
            <label  class="control-label">Fullname</label>
            <input type="text" class="form-control" name="fullname" id="fullname" required>
          </div>
          <div class="form-group">
            <label  class="control-label">Position</label>
            <select class="form-control" name="position" id="position" required="">
              <option selected="">-- Select --</option>
              <option value="BOD">BOD</option>
              <option value="Engineer">Engineer</option>
              <option value="GA & Finance">GA & Finance</option>
              <option value="Account Manager">Account Manager</option>
              <option value="Developer">Developer</option>
              <option value="Content Writer">Content Writer</option>
            </select>
          </div>
          <div class="form-group">
            <label  class="control-label">Born Place</label>
            <input type="text" class="form-control" name="b_place" id="b_place" required>
          </div>
          <div class="form-group">
            <label  class="control-label">Birthday Date</label>
            <input class="form-control" name="b_date" id="b_date" required>
          </div>
          <div class="form-group">
            <label  class="control-label">Gender</label>
            <select class="form-control" name="gender" id="gender" required>
              <option selected="">-- Select --</option>
              <option value="male">Male</option>
              <option value="female">Female</option>
            </select>
          </div>
          <div class="form-group">
            <label  class="control-label">Address</label>
            <input type="text" class="form-control" name="address" id="address" required>
          </div>
          <div class="form-group">
            <label class="control-label">Username</label>
            <input type="email" class="form-control" name="user_name" id="user_name" required>
          </div>
          <div class="form-group">
            <label  class="control-label">Password</label>
            <input type="password" class="form-control" name="pass" id="pass" required>
          </div>
          <div class="form-group">
            <label  class="control-label">Confrim Password</label>
            <input type="password" class="form-control" name="c_pass" id="c_pass" required>
          </div>
          <div class="form-group">
            <label  class="control-label">Role</label>
            <select class="form-control" name="role" id="role" required>
              <option selected="">-- Select --</option>
              <option value="bod">BOD</option>
              <option value="admin">Admin</option>
              <option value="employee">Employee</option>
            </select>
          </div>
       </div>
       <div class="modal-footer">
         <button type="button" class="btn btn-default" style="width: 100px; padding: 10px" data-dismiss="modal">Close</button>
         <input type="submit" class="btn btn-primary"  style="width: 100px; padding: 10px" value="Save">
       </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Showdata-->
<div class="modal fade" id="myModalRead" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">List Application for Leave</h4>
        <input type="hidden" id="uniq_id_aflusers">
      </div>

      <div id="data_read"></div>

      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal" style="padding:10px">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- End of Modal Showdata -->

<!-- Modal Edit-->
<div class="modal fade" id="modelEditUser" role="dialog">
<div class="modal-dialog">
  <!-- Modal content-->
  <div class="modal-content">
    <div class="modal-header">
      <h4 class="modal-title">Edit User</h4>
      <input type="hidden" id="id_lab_edit_user">
    </div>

    <div id="data_edit"></div>

    <div class="modal-footer">
      <button type="button" id="btn_edit" class="btn btn-success" onclick="btn_edit()" style="padding:10px">Save</button>
      <button type="button" class="btn btn-danger" data-dismiss="modal" style="padding:10px">Close</button>
    </div>
  </div>
</div>
</div>
<!-- /Modal Edit-->

<!-- Modal Delete-->
<div class="modal fade" id="myModalDel" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <center>
          <h4 class="modal-title">Are You Sure Want Delete This User?</h4>
        </center>
        <input type="hidden" id="id_del_users">
      </div>

      <div class="modal-footer">
        <button type="button" id="btn_del" class="btn btn-success" onclick="btn_del()" style="padding:10px">Yes</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal" style="padding:10px">No!</button>
      </div>
    </div>
  </div>
</div>
<!-- /Modal Delete-->

<script type="text/javascript">
  //Function Read Users
  function read_users(x){
    document.getElementById("uniq_id_aflusers").value = x;
    var val1 = x;
      
        $.ajax({
        type: 'POST',
        url: '<?php echo site_url('users_management/data_users')?>',
        data: { uniq_id_aflusers: val1},
        success: function(response) {
            $('#data_read').html(response);
            $("#myModalRead").modal();
        }
    });
  }//End Of Function Read Users

  //Function Edit Users
  function id_edit_user(x){
    document.getElementById("id_lab_edit_user").value = x;
    var val1 = x;
      
        $.ajax({
        type: 'POST',
        url: '<?php echo site_url('users_management/showdata_edit_users')?>',
        data: { id_lab_edit_user: val1},
        success: function(response) {
            $('#data_edit').html(response);
            $("#modelEditUser").modal();
        }
    });
  }

  function btn_edit(){
    var val1 = $('#id_lab_edit_user').val();
    var val2 = $('#no_karyawan_edit').val();
    var val3 = $('#doh_edit').val();
    var val4 = $('#name_edit').val();
    var val5 = $('#position_edit').val();
    var val6 = $('#born_place_edit').val();
    var val7 = $('#birthday_date_edit').val();
    var val8 = $('#gender_edit').val();
    var val9 = $('#address_edit').val();
    var val10 = $('#username_edit').val();
    var val11 = $('#role_edit').val();
    var val12 = $('#r_leave_edit').val();

      $.ajax({
          type: 'POST',
          url: '<?php echo site_url('users_management/edit_users')?>',
          data: { id_lab_edit_user: val1, no_karyawan_edit: val2, doh_edit: val3, name_edit: val4, position_edit: val5, born_place_edit: val6, birthday_date_edit: val7, gender_edit: val8, address_edit: val9, username_edit: val10, role_edit: val11, r_leave_edit: val12 },
          success: function(response) {
              window.location.reload();
          }
      });
  }//End Of Function Edit Users

  //Function Delete Users
  function del_users(x){
    document.getElementById("id_del_users").value = x;
    $("#myModalDel").modal();
  }

  function btn_del(){
    var val1 = $('#id_del_users').val();
    
      $.ajax({
          type: 'POST',
          url: '<?php echo site_url('users_management/delete_users')?>',
          data: { id_del_users: val1 },
          success: function(response) {
              window.location.reload();
          }
      });
  }//End Of Function Delete Users
</script>

<script>
  $('#doh').datepicker({
      uiLibrary: 'bootstrap4'
  });
  $('#b_date').datepicker({
      uiLibrary: 'bootstrap4'
  });
</script>