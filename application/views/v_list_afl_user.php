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

<!-- Menu Container List AFL User -->
<div class="row">
 <div class="col-12 grid-margin">
  <div class="card">
    <div class="card-body">
      <div class="table-responsive">
        <table id="dt_list_afl_user" class="table table-striped table-bordered" style="">
          <thead>
            <tr style="text-align: center">
              <th style="width: 10px;">No</th>
              <th>Date Create</th>
              <th>Type of Leave Required</th>
              <th>Reason</th>
              <th>Status (Approve by BOD)</th>
              <th>Acknowledge by Admin</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody style="text-align: center;">
          </tbody>
        </table>
      </div>
    </div>
  </div>
 </div>
</div>
<!-- End of Menu Container List AFL User -->

<!-- Container Print -->
<!-- End of Container Print -->

<!-- Modal Showdata-->
<div class="modal fade" id="myModalRead" role="dialog">
  <div class="modal-dialog" style="max-width: 900px;">
    <!-- Modal content-->
    <div class="modal-content" style="margin-left: 150px;">
      <div class="modal-header">
        <h4 class="modal-title">List Application for Leave</h4>
        <input type="hidden" id="listafl_user">
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
<div class="modal fade" id="modelEditAfl" role="dialog">
  <div class="modal-dialog" style="max-width: 900px;">
    <!-- Modal content-->
    <div class="modal-content" style="margin-left: 150px;">
      <div class="modal-header">
        <h4 class="modal-title">Edit Application for Leave</h4>
        <input type="hidden" id="id_listafl_user">
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

<script type="text/javascript">
  //Function Read Users
  function read_listafl(x){
    document.getElementById("listafl_user").value = x;
    var val1 = x;
      
        $.ajax({
        type: 'POST',
        url: '<?php echo site_url('list_afl_user/data_listafl_user')?>',
        data: { listafl_user: val1},
        success: function(response) {
            $('#data_read').html(response);
            $("#myModalRead").modal();
        }
    });
  }//End Of Function Read Users

  //Function Edit Users
  function edit_afl(x){
    document.getElementById("id_listafl_user").value = x;
    var val1 = x;
      
        $.ajax({
        type: 'POST',
        url: '<?php echo site_url('list_afl_user/showdata_listafl_user')?>',
        data: { id_listafl_user: val1},
        success: function(response) {
            $('#data_edit').html(response);
            $("#modelEditAfl").modal();
        }
    });
  }

  function btn_edit(){
    var val1 = $('#id_listafl_user').val();
    var val2 = $('#leave_required_edit').val();
    var val3 = $('#leave_from_edit').val();
    var val4 = $('#back_work_edit').val();
    var val5 = $('#reason_edit').val();
    var val6 = $('#leave_to_edit').val()
    var val7 = $('#total_days_edit').val();

      $.ajax({
          type: 'POST',
          url: '<?php echo site_url('list_afl_user/edit_afl')?>',
          data: { id_listafl_user: val1, leave_required_edit: val2, leave_from_edit: val3, back_work_edit: val4, reason_edit: val5, leave_to_edit: val6, total_days_edit: val7 },
          success: function(response) {
              window.location.reload();
          }
      });
  }//End Of Function Edit Users
</script>

<script>
    $('#lastday_work_edit').datepicker({
        uiLibrary: 'bootstrap4'
    });
    $('#leave_from_edit').datepicker({
        uiLibrary: 'bootstrap4'
    });
    $('#leave_to_edit').datepicker({
        uiLibrary: 'bootstrap4'
    });
    $('#back_work_edit').datepicker({
        uiLibrary: 'bootstrap4'
    });

var dt_list_afl_user;

    $(document).ready(function() {
      dt_list_afl_user = $('#dt_list_afl_user').DataTable({ 
      "bInfo" : false,
      "processing": true, //Feature control the processing indicator.
      "serverSide": true, //Feature control DataTables' server-side processing mode.
      "order": [], //Initial no order.

      // Load data for the table's content from an Ajax source
      "ajax": {
        "url": "<?php echo site_url('list_afl_user/ajax_list/3')?>",
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

