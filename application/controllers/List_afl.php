<?php
	class List_afl extends CI_Controller{
	 
	function __construct(){
		parent::__construct();		
		$this->load->model('m_afl_user', 'afl');
		$this->load->helper('url');
		
		if($this->session->userdata('status') != "login" || $this->session->userdata('role') != "bod" && $this->session->userdata('role') != "admin"){
	       	redirect(base_url("login"));
		}
	}

	function index(){
		$data['title']='List Application for Leave';
		$data['active_afl']='active';
        $data['page']='v_afl';
        $this->load->view('template',$data);
	}

	public function ajax_list(){
		$sts = $this->uri->segment(3, 0);
        $list = $this->afl->get_datatables($sts);
        $data = array();
        $no = $_POST['start'];
        
        foreach ($list as $afl) {
            $no++;
            $stss = $afl->sts;
            $check_stss = $afl->check_sts;

            // Untuk menampilkan label approve by BOD
            if($stss == 0){
            		$status = '<span class="label-danger" alt="disagree">Disagree</span>';
            }else if($stss == 1){
            		$status = '<span class="label-primary">Approved</span>';
            }else if($stss == 2){
            		$status = '<span class="label-warning">Waiting</span>';
            } else {
            	$status = '<span class="label-default">Null</span>';
            }// End of status

            // Untuk menampilkan label status checklist by admin
            if($check_stss == 0){
            		$check_status = '<span class="label-danger" alt="disagree">Disagree</span>';
            }else if($check_stss == 1){
            		$check_status = '<span class="label-primary">Approved</span>';
            }else if($check_stss == 2){
            		$check_status = '<span class="label-warning">Waiting</span>';
            } else {
            	$status = '<span class="label-default">Null</span>';
            }// End of checklist

            $action_role = $this->session->userdata('role');
            if ($action_role=='bod'){
			    $ar = '<button type="button" class="btn btn-success btn-fw" style="margin-left: 3px;" title="Approve" onclick="app_afl('.$afl->id_afl.')"><i class="mdi mdi-comment-alert-outline"></i></button>';
			  }else if($action_role=='admin') {
			    $ar = '<button type="button" class="btn btn-success btn-fw" style="margin-left: 3px;" title="Checklist" onclick="cek_afl('.$afl->id_afl.')"><i class="mdi mdi-checkbox-marked"></i></button>';
			  }else{
			    echo "";
			  }

			if ($action_role=='admin'){
			    $delus = '<button type="button" class="btn btn-success btn-fw" style="margin-left: 3px;" title="Delete" onclick="delete_afl('.$afl->uniq_id.')"><i class="mdi mdi-delete"></i></button>';
			}else{
			    $delus="";
			}

            $row = array();
            $row[] = $no;
            $row[] = $afl->name;
            $row[] = $afl->reason;
            $row[] = $afl->leave_required;
            $row[] = $afl->jabatan;
            $row[] = $status;
            $row[] = $check_status;
            $row[] = '<div style="text-align: center; width: 100px;">
                        <button type="button" class="btn btn-success btn-fw" title="Showdata" onclick="showdata_afl('.$afl->id_afl.')"><i class="mdi mdi-eye"></i></button>'.$ar.$delus.
                      '</div>'; 
            $data[] = $row;
        }
 
        $output = array(
                  "draw" => $_POST['draw'],
                  "recordsTotal" => $this->afl->count_all($sts),
                  "recordsFiltered" => $this->afl->count_filtered($sts),
                  "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }

    function app_afl_user(){
    	$id_listafl_user = $this->input->post('read_app');

    	$where = array(
			'id_afl' => $id_listafl_user
		);

		$query = $this->afl->showdata_afl("tb_afl",$where);
		$row = $query->row();
		$sts = $row->sts;
		$total_days = $row->total_days;
		$uniq_id = $row->uniq_id;
		$name_app = $this->session->userdata("name");
		$where_id = array(
			'uniq_id' => $uniq_id
		);
		
		if($sts == 2){
			$data = array(
				'sts' => '1',
				'name_app' => $name_app
			);

			try {
				  $tb_afl = 'tb_afl';
				  $tb_login = 'tb_login';
				  $this->db->set('date_app', 'NOW()', FALSE);
	    		  
				  $this->afl->edit_afl($tb_afl,$tb_login,$data, $id_listafl_user,$where_id,$total_days,$uniq_id);
				  $this->session->set_flashdata('success', '<div class="alert alert-success" role="alert"><strong>This AFL Approved!</strong></div>');
				  
				}catch(Exception $e) {
				  echo 'Message: ' .$e->getMessage();
				}

		} else {
				$this->session->set_flashdata('success', '<div class="alert alert-danger" role="alert"><strong>Tidak Dapat Diubah kembali!</strong></div>');
		}
    }

    function dis_afl_user(){
    	$id_listafl_user = $this->input->post('read_app');

    	$where = array(
			'id_afl' => $id_listafl_user
		);

		$query = $this->afl->showdata_afl("tb_afl",$where);
		$row = $query->row();
		$sts = $row->sts;
		
		if($sts == 2){
			$data = array(
				'sts' => '0',
				'check_sts' => '0'
			);

			try {
				  $this->db->set('date_app', 'NOW()', FALSE);
				  $this->afl->edit_diss_afl("tb_afl", $data, $id_listafl_user);
				  $this->session->set_flashdata('success', '<div class="alert alert-success" role="alert"><strong>This AFL is Disagree</strong></div>');
				  
				}catch(Exception $e) {
				  echo 'Message: ' .$e->getMessage();
				}

		} else {
				 $this->session->set_flashdata('success', '<div class="alert alert-danger" role="alert"><strong>Tidak Dapat Diubah kembali!</strong></div>');
		}
    }

    function cek_afl_user(){
    	$id_cekafl_user = $this->input->post('read_cek');

    	$where = array(
			'id_afl' => $id_cekafl_user
		);

			try {
			  // Untuk Menampilkan Alert status Jika di cek admin
			  $query = $this->afl->showdata_afl("tb_afl",$where);
			  $row = $query->row();
			  $sts = $row->sts;

	    	  if($sts == 1){
	    	  	 $query = $this->afl->showdata_afl("tb_afl",$where);
				 $row = $query->row();
				 $name = $this->session->userdata("name");
				 $check_sts = $row->check_sts;
					
			    	if($check_sts == 2){
				    		$data = array(
					 		'check_sts' => '1',
					 		'name_cek' => $name
						);

					    try {
							  $this->db->set('date_knownby', 'NOW()', FALSE);
							  $this->afl->edit_cekafl("tb_afl", $data, $id_cekafl_user);
							  $this->session->set_flashdata('success', '<div class="alert alert-success" role="alert"><strong>Ready to Print!</strong></div>');
							  
							}catch(Exception $e) {
							  echo 'Message: ' .$e->getMessage();
							}

						} else {
								 $this->session->set_flashdata('success', '<div class="alert alert-danger" role="alert"><strong>Sudah Diceklist!</strong></div>');
						}
			  } elseif ($sts == 0) {
				  	$this->session->set_flashdata('success', '<div class="alert alert-danger" role="alert"><strong>Cant Print This AFL</strong></div>');
			  } elseif ($sts == 2) {
					$this->session->set_flashdata('success', '<div class="alert alert-warning" role="alert"><strong>Waiting Approved BOD</strong></div>');
			  } else {
					echo "NULL!";
			  }// End Of Untuk Menampilkan Alert status Jika di cek admin
				  
		}catch(Exception $e) {
		  echo 'Message: ' .$e->getMessage();
		}
	}

	function delete_afluser(){
	    $read_del = $this->input->post('read_del');
	    $where = array(
	    'uniq_id' => $read_del
	    );

	    try {
	        $this->afl->delete_afl("tb_afl",$where);
	        $this->session->set_flashdata('success', '<div class="alert alert-success"><strong>Delete data afl user is Success!</strong></div>');

	    }catch(Exception $e) {
	      echo 'Message: ' .$e->getMessage();
	    }
	}

	function list_afl_table(){
		echo '<table id="dt_afl" class="table table-striped table-bordered" style="width: 100%">
	          <thead>
	            <tr style="text-align: center">
	              <th style="width: 10px;">No</th>
	              <th>Applicants Name</th>
	              <th>Reason</th>
	              <th>Type of Leave Required<br>(Cuti yang diperlukan)</th>
	              <th>Position<br>(Jabatan)</th>
	              <th>Status (Approve by BOD)</th>
	              <th>Acknowledge by Admin</th>
	              <th>Action</th>
	            </tr>
	          </thead>
	          <tbody style="text-align: center;">
	          </tbody>
	        </table>';
	}

	function data_listafl_user(){
		    $listafl_user = $this->input->post('listafl_user');
		    $query = $this->afl->joinShowdata($listafl_user);
		    $row = $query->row();
		    echo '<div class="row">
		          <div class="col-sm-1"></div>
		          <div class="col-sm-5">
		            <div class="modal-body">
		              <label><B>Applicants Name (Nama Pemohon)</B></label>
		              <p>'.$row->name.'</p>
		            </div>
		            <div class="modal-body">
		              <label><B>Position (Jabatan)</B></label>
		              <p>'.$row->jabatan.'</p>
		            </div>
		            <div class="modal-body">
		              <label><B>Division/Directorate (Divisi/Direktorat)</B></label>
		              <p>'.$row->jabatan.'</p>
		            </div>
		          </div>
		          <div class="col-sm-5">
		            <div class="modal-body">
		              <label><B>ID NO</B></label>
		              <p>'.$row->no_karyawan.'</p>
		            </div>
		            <div class="modal-body">
		              <label><B>DOH</B></label>
		              <p>'.tglindo($row->doh).'</p>
		            </div>
		          </div>
		          <div class="col-sm-1"></div>
		          </div>
		          <div class="modal-body" style="margin: 0px 0px 0px 50px; padding: 0px;">
		              <label><h5><B>Period of Leave (Periode Cuti)</B></h5></label>
		          </div>
		    	  <div class="row">
		          <div class="col-sm-1"></div>
		          <div class="col-sm-5">
		            <div class="modal-body">
		              <label><B>Type of Leave required</B></label>
		              <p>'.$row->leave_required.'</p>
		            </div>
		            <div class="modal-body">
		              <label><B>Leave From</B></label>
		              <p>'.$row->leave_from.'</p>
		            </div>
		            <div class="modal-body">
		              <label><B>Back to Work</B></label>
		              <p>'.$row->back_work.'</p>
		            </div>
		          </div>
		          <div class="col-sm-5">
		          	<div class="modal-body">
		              <label><B>Reason</B></label>
		              <p>'.$row->reason.'</p>
		            </div>
		            <div class="modal-body">
		              <label><B>To</B></label>
		              <p>'.$row->leave_to.'</p>
		            </div>
		            <div class="modal-body">
		              <label><B>Total Days Leave Applied for</B></label>
		              <p>'.$row->total_days.'</p>
		            </div>
		          </div>
		          <div class="col-sm-1"></div>
		          </div>
		          <div class="modal-body" style="margin: 0px 0px 0px 50px; padding: 0px;">
		              <label><h5><B>Admin/HRD/Paymasters Use Only</B></h5></label>
		          </div>
		          <div class="row">
		          <div class="col-sm-1"></div>
		          <div class="col-sm-5">
		            <div class="modal-body">
		              <label><B>Entitlement (Days)</B></label>
		              <p>'.$row->balance.'</p>
		            </div>
		            <div class="modal-body">
		              <label><B>As At</B></label>
		              <p>'.$row->as_at.'</p>
		            </div>
		          </div>
		          <div class="col-sm-5">
		            <div class="modal-body">
		              <label><B>This Leave Approved (Days)</B></label>
		              <p>'.$row->leave_app.'</p>
		            </div>
		            <div class="modal-body">
		              <label><B>Balance (Days)</B></label>
		              <p>'.$row->balance.'</p>
		            </div>
		          </div>
		          <div class="col-sm-1"></div>
		          </div>';
	  	}
}
?>