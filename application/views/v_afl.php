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

<!-- Menu Print -->
<div class="row">
<div class="col-sm-4"></div>
<div class="col-sm-4"></div>
<div class="col-sm-4">
    
    <select class="select" id="selectStatus" onchange="select_status()">
      <option value="null">All</option>
      <option value="0" >Disagree</option>
      <option value="1" >Approve</option>
      <option value="2">Waiting</option>
    </select> 


    <button type="button" class="btn btn-primary" style="padding: 10px; background: #16a085; border: none; margin-bottom: 10px; float: right"><i class="mdi mdi-file-excel">Export Excel</i></button>  
</div>
</div>
<!-- End of Menu Print -->

<!-- Menu Container AFL Admin -->
<div class="row">
<div class="col-12 grid-margin">
    <div class="table-responsive" id="table_afl">  
        
    </div>
</div>
</div>
<!-- End of Menu Container AFL Admin -->

<!-- Modal Approve-->
<div class="modal fade" id="myModalApp" role="dialog">
  <div class="modal-dialog">
        <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"></button>
        <h4 class="modal-title">Are you sure want approve this application for leave?</h4>
        <input type="hidden" id="read_app">
      </div>

      <div id="data_app"></div>

      <div class="modal-footer">
        <button type="button" id="btn_setuju" class="btn btn-success" onclick="btn_app()" style="padding:10px">Approve!</button>
        <button type="button" id="btn_setuju" class="btn btn-danger" onclick="btn_dis()" style="padding:10px">Disagree!</button>
        <button type="button" class="btn btn-warning" data-dismiss="modal" style="padding:10px">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- End of Modal Approve-->

<!-- Modal checklist-->
<div class="modal fade" id="myModalcek" role="dialog">
  <div class="modal-dialog">
        <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"></button>
        <h4 class="modal-title">Are you sure this application for leave has been approved?</h4>
        <input type="hidden" id="read_cek" name="read_cek">
      </div>

      <div id="data_cek"></div>

      <div class="modal-footer">
        <button type="button" id="btn_setuju" class="btn btn-success" onclick="btn_cek()" style="padding:10px">Yes!</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal" style="padding:10px">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- End of Modal checklist-->

<!-- Modal checklist-->
<div class="modal fade" id="myModaldel" role="dialog">
  <div class="modal-dialog">
        <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Are you sure want delete this application for leave user?</h4>
        <input type="hidden" id="read_del" name="read_del">
      </div>

      <div id="data_del"></div>

      <div class="modal-footer">
        <button type="button" id="btn_del_afl" class="btn btn-success" onclick="btn_del_afl()" style="padding:10px">Yes!</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal" style="padding:10px">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- End of Modal checklist-->

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

<script type="text/javascript">
  window.onload = function() {
        table_afl_show('null');
  };
  //Function Approve AFL user
  function app_afl(x){
    document.getElementById("read_app").value = x;
      $("#myModalApp").modal();
  }

  function btn_app(){
    var val1 = $('#read_app').val();
    
        $.ajax({
          type: 'POST',
          url: '<?php echo site_url('list_afl/app_afl_user')?>',
          data: { read_app: val1},
          success: function(response) {
              window.location.reload();
          }
      });
  }

  function btn_dis(){
    var val1 = $('#read_app').val();
    
        $.ajax({
          type: 'POST',
          url: '<?php echo site_url('list_afl/dis_afl_user')?>',
          data: { read_app: val1},
          success: function(response) {
              window.location.reload();
          }
      });
  }//End of Function Approve AFL user

  //Function Check AFL user
  function cek_afl(x){
    document.getElementById("read_cek").value = x;
      $("#myModalcek").modal();
  }

  function btn_cek(){
    var val1 = $('#read_cek').val();

        $.ajax({
          type: 'POST',
          url: '<?php echo site_url('list_afl/cek_afl_user')?>',
          data: { read_cek: val1},
          success: function(response) {
              window.location.reload();
          }
    });
  }//End of Function Check AFL user

  //Function Read Users
  function showdata_afl(x){
    $("#myModalRead").modal();
    document.getElementById("listafl_user").value = x;
    var val1 = x;
      
        $.ajax({
        type: 'POST',
        url: '<?php echo site_url('list_afl/data_listafl_user')?>',
        data: { listafl_user: val1},
        success: function(response) {
            $('#data_read').html(response);
            $("#myModalRead").modal();
        }
    });
  }//End Of Function Read Users

  //Function Delete AFL user
  function delete_afl(x){
    document.getElementById("read_del").value = x;
      $("#myModaldel").modal();
  }

  function btn_del_afl(){
    var val1 = $('#read_del').val();
    
      $.ajax({
          type: 'POST',
          url: '<?php echo site_url('list_afl/delete_afluser')?>',
          data: { read_del: val1 },
          success: function(response) {
              window.location.reload();
          }
      });
  }//End of Function Delete AFL user

function select_status(){
  var sts = $('#selectStatus').val();
  table_afl_show(sts);
}

function all(){
  var dt_afl;
    dt_afl = $('#dt_afl').DataTable({ 
   
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.

        // Load data for the table's content from an Ajax source
        "ajax": {
          "url": "<?php echo site_url('list_afl/ajax_list')?>",
          "type": "POST"
        },

        //Set column definition initialisation properties.
        "columnDefs": [
        { 
          "targets": [ 0,1,2,3,4,5,6,7], //first column / numbering column
          "orderable": false, //set not orderable
        },
        ]
      });
}

function diss(){
  var dt_afll;
    dt_afll = $('#dt_afl').DataTable({ 
   
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.

        // Load data for the table's content from an Ajax source
        "ajax": {
          "url": "<?php echo site_url('list_afl/ajax_list/0')?>",
          "type": "POST"
        },

        //Set column definition initialisation properties.
        "columnDefs": [
        { 
          "targets": [ 0,1,2,3,4,5,6,7], //first column / numbering column
          "orderable": false, //set not orderable
        },
        ]
      });
}

function approve(){
  var dt_afll;
    dt_afll = $('#dt_afl').DataTable({ 
   
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.

        // Load data for the table's content from an Ajax source
        "ajax": {
          "url": "<?php echo site_url('list_afl/ajax_list/1')?>",
          "type": "POST"
        },

        //Set column definition initialisation properties.
        "columnDefs": [
        { 
          "targets": [ 0,1,2,3,4,5,6,7], //first column / numbering column
          "orderable": false, //set not orderable
        },
        ]
      });
}

function wait(){
  var dt_afll;
    dt_afll = $('#dt_afl').DataTable({ 
   
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.

        // Load data for the table's content from an Ajax source
        "ajax": {
          "url": "<?php echo site_url('list_afl/ajax_list/2')?>",
          "type": "POST"
        },

        //Set column definition initialisation properties.
        "columnDefs": [
        { 
          "targets": [ 0,1,2,3,4,5,6,7], //first column / numbering column
          "orderable": false, //set not orderable
        },
        ]
      });
}

function table_afl_show(x){
    var sts  = x;
    $.ajax({
          type: 'POST',
          url: '<?php echo site_url('list_afl/list_afl_table')?>',
          success: function(response) {
              $('#table_afl').html(response)
                if(sts=="null"){
                  all();
                }else if(sts==0){
                  diss();
                }else if(sts==1){
                  approve();
                }else if(sts==2){
                  wait();
                }
          }
      });
}
</script>

