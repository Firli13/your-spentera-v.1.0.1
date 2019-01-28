<?php
	class List_afl_user extends CI_Controller{
	 
		function __construct(){
			parent::__construct();		
			$this->load->model('m_afl_user', 'list_afl');
      		$this->load->helper('url');

      		if($this->session->userdata('status') != "login" || $this->session->userdata('role') != "employee" && $this->session->userdata('role') != "admin"){
		       	redirect(base_url("login"));
			}
		}

		function index(){
			$data['title']='List Application for Leave';
			$data['active_afl_user']='active';
			$data['active_list_afl_user']='active';
			$data['page']='v_list_afl_user';
			$this->load->view('template',$data);
		}

		function vprint_afl(){
			$data['title']='Print AFL User';
			$data['active_list_afl_user']='active';
			$data['page']='v_print_af_user';
			$id_afl = $this->uri->segment(3, 0);
			$uniq_id = $this->session->userdata("uniq_id");

			// Untuk memanggil data yang ada di table login
		    $where = array(
		    'uniq_id' => $this->session->userdata("uniq_id")
		    );

		    $data['data_users'] = $this->list_afl->showdata_afl("tb_login",$where);

		    $data_afl = $this->list_afl->showdata_afl_user("tb_afl",$id_afl,$uniq_id);
		  	$get_afl = $data_afl->row();
		  	if ($get_afl !=NULL) {
		  		$data['get_afl'] = $get_afl;
		  		$this->load->view('v_print_af_user',$data);
		  	}else{
		  		redirect(base_url("login"));
		  	}
		    // End of logic get data login

			// Get output html
	        $html = $this->output->get_output();
	        
	        // Load pdf library
	        $this->load->library('pdf');
	        
	        // Load HTML content
	        $this->dompdf->loadHtml($html);
	        
	        // (Optional) Setup the paper size and orientation
	        $this->dompdf->setPaper('A4', 'portrait');
	        
	        // Render the HTML as PDF
	        $this->dompdf->render();
	        
	        // Output the generated PDF (1 = download and 0 = preview)
	        $this->dompdf->stream("print_afl.pdf", array("Attachment"=>0));
		}

		public function ajax_list(){
			$sts = '';
	        $list = $this->list_afl->get_datatables($sts);
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

	            // Untuk menampilkan action edit afl jika status masih menunggu
	            if($stss == 2 && $check_stss == 2){
	            		$edit = '<button type="button" class="btn btn-success btn-fw" title="Edit" style="margin-left: 3px" onclick="edit_afl('.$afl->id_afl.')"><i class="mdi mdi-table-edit"></i></button>';
	            } else {
	            		$edit = '<button type="button" class="btn btn-danger btn-fw" title="Edit" style="cursor: not-allowed; margin-left: 3px"><i class="mdi mdi-table-edit"></i></button>';
	            }

	            // Untuk menampilkan action print jika disetujui dan belum di setujui
	            if($stss == 1 && $check_stss == 1){
	            		$print = '<a type="button" class="btn btn-success btn-fw" style="margin-left: 3px" title="Print" href="'.site_url('list_afl_user/vprint_afl/'.$afl->id_afl).'" target="_blank"><i class="mdi mdi-printer"></i></a>';
	            } else {
	            		$print = '<button type="button" class="btn btn-danger btn-fw" style="cursor: not-allowed; margin-left: 3px" title="No Print"><i class="mdi mdi-printer"></i></button>';
	            }

	            $row = array();
	            $row[] = $no;
	            $row[] = $afl->date_create;
	            $row[] = $afl->leave_required;
	            $row[] = $afl->reason; 
	            $row[] = $status;
	            $row[] = $check_status;
	            $row[] = '<div style="text-align: center">
	                        <button type="button" class="btn btn-success btn-fw" title="Showdata" onclick="read_listafl('.$afl->id_afl.')"><i class="mdi mdi-eye"></i></button>'.$edit.$print.'
	                      </div>';
	            $data[] = $row;
	        }
	 
	        $output = array(
	                  "draw" => $_POST['draw'],
	                  "recordsTotal" => $this->list_afl->count_all($sts),
	                  "recordsFiltered" => $this->list_afl->count_filtered($sts),
	                  "data" => $data,
	                );
	        //output to json format
	        echo json_encode($output);
        }

	    function data_listafl_user(){
		    $listafl_user = $this->input->post('listafl_user');

		    $where = array(
		      'id_afl' => $listafl_user
		    );

		    $query = $this->list_afl->showdata_afl("tb_afl",$where);
		    $row = $query->row();
		    

		    echo '<div class="row">
		          <div class="col-sm-1"></div>
		          <div class="col-sm-5">
		            <div class="modal-body">
		              <label><B>Applicants Name (Nama Pemohon)</B></label>
		              <p>'.$this->session->userdata('name').'</p>
		            </div>
		            <div class="modal-body">
		              <label><B>Position (Jabatan)</B></label>
		              <p>'.$this->session->userdata('jabatan').'</p>
		            </div>
		            <div class="modal-body">
		              <label><B>Division/Directorate (Divisi/Direktorat)</B></label>
		              <p>'.$this->session->userdata('jabatan').'</p>
		            </div>
		          </div>
		          <div class="col-sm-5">
		            <div class="modal-body">
		              <label><B>ID NO</B></label>
		              <p>'.$this->session->userdata('no_karyawan').'</p>
		            </div>
		            <div class="modal-body">
		              <label><B>DOH</B></label>
		              <p>'.tglindo($this->session->userdata('doh')).'</p>
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

	  	function showdata_listafl_user(){
		    $id_listafl_user = $this->input->post('id_listafl_user');

		    $where = array(
		      'id_afl' => $id_listafl_user
		    );

		    $query = $this->list_afl->showdata_afl("tb_afl",$where);
		    $row = $query->row();

		    echo '<div class="row">
		          <div class="col-sm-1"></div>
		          <div class="col-sm-5">
		            <div class="modal-body">
		              <label><B>Applicants Name (Nama Pemohon)</B></label>
		              <p>'.$this->session->userdata('name').'</p>
		            </div>
		            <div class="modal-body">
		              <label><B>Position (Jabatan)</B></label>
		              <p>'.$this->session->userdata('jabatan').'</p>
		            </div>
		            <div class="modal-body">
		              <label><B>Division/Directorate (Divisi/Direktorat)</B></label>
		              <p>'.$this->session->userdata('jabatan').'</p>
		            </div>
		          </div>
		          <div class="col-sm-5">
		            <div class="modal-body">
		              <label><B>ID NO</B></label>
		              <p>'.$this->session->userdata('no_karyawan').'</p>
		            </div>
		            <div class="modal-body">
		              <label><B>DOH</B></label>
		              <p>'.tglindo($this->session->userdata('doh')).'</p>
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
	                    <select class="form-control" id="leave_required_edit" name="leave_required_edit" style="color: #495057;">
	                      <option>'.$row->leave_required.'</option>
	                      <option value="Annual">Annual</option>
	                      <option value="Sick">Sick</option>
	                      <option value="Long Service">Long Service</option>
	                      <option value="Leave Without Pay">Leave Without Pay</option>
	                      <option value="Other">Other</option>
	                    </select>
		            </div>
		            <div class="modal-body">
		              <label><B>Leave From</B></label>
		              <input class="form-control" id="leave_from_edit" name="leave_from_edit" value="'.$row->leave_from.'">
		            </div>
		            <div class="modal-body">
		              <label><B>Back to Work</B></label>
		              <input class="form-control" id="back_work_edit" name="back_work_edit" value="'.$row->back_work.'">
		            </div>
		          </div>
		          <div class="col-sm-5">
		          	<div class="modal-body">
		              <label><B>Reason</B></label>
		              <input type="text" class="form-control" id="reason_edit" name="reason_edit" value="'.$row->reason.'">
		            </div>
		            <div class="modal-body">
		              <label><B>To</B></label>
		              <input class="form-control" id="leave_to_edit" name="leave_to_edit" value="'.$row->leave_to.'">
		            </div>
		            <div class="modal-body">
		              <label><B>Total Days Leave Applied for</B></label>
		              <input type="text" class="form-control" id="total_days_edit" name="total_days_edit" value="'.$row->total_days.'">
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

		  function edit_afl(){
		    $id_listafl_user = $this->input->post('id_listafl_user');

		    $leave_required_edit = $this->input->post('leave_required_edit');
		    $leave_from_edit = $this->input->post('leave_from_edit');
		    $back_work_edit = $this->input->post('back_work_edit');
		    $reason_edit = $this->input->post('reason_edit');
		    $leave_to_edit = $this->input->post('leave_to_edit');
		    $total_days_edit = $this->input->post('total_days_edit');

		    $data = array(
		      'leave_required' => $leave_required_edit,
		      'leave_from' => $leave_from_edit,
		      'back_work' => $back_work_edit,
		      'reason' => $reason_edit,
		      'leave_to' => $leave_to_edit,
		      'total_days' => $total_days_edit
		    );

		    // Solve XSS Attack
    		$data = $this->security->xss_clean($data);

		    try {

		      $this->list_afl->edit_user_afl("tb_afl",$data, $id_listafl_user);
		      $this->session->set_flashdata('success', '<div class="alert alert-success"><strong>Edit data afl users is Success!</strong></div>');
		      
		    }catch(Exception $e) {
		      echo 'Message: ' .$e->getMessage();
		    }
		  }
}
?>