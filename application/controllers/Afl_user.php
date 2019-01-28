<?php
	class Afl_user extends CI_Controller{
	 
		function __construct(){
			parent::__construct();		
			$this->load->model('m_afl_user', 'afl');
      $this->load->helper('url');

      if($this->session->userdata('status') != "login" || $this->session->userdata('role') != "employee" && $this->session->userdata('role') != "admin"){
      redirect(base_url("login"));
    }
		}

		function index(){
			$data['title']='Application for Leave';
			$data['active_afl_user']='active';
    	$data['page']='v_afl_user';
      $uniq_id = $this->session->userdata("uniq_id");
      // Untuk memanggil data yang ada di table login
      $where = array(
      'uniq_id' => $this->session->userdata("uniq_id")
      );
      $data['data_user'] = $this->afl->showdata_afl("tb_login",$where);   
      $data['as_at'] = $this->afl->show_as_at_afl("tb_afl",$uniq_id);

      // End of logic get data login
    	$this->load->view('template',$data);

		}

	 
  function create_afl(){
    $uniqid =  $this->session->userdata("uniq_id");
    $leave_required = $this->input->post('leave_required');
    $leave_from = $this->time_input($this->input->post('leave_from'));
    $leave_to = $this->time_input($this->input->post('leave_to'));
    $back_work = $this->time_input($this->input->post('back_work'));
    $total_days = filter_var($this->input->post('total_days'), FILTER_SANITIZE_NUMBER_INT);
    $reason = $this->input->post('reason');
    $entitlement = $this->input->post('entitlement');
    $leave_app = $this->input->post('leave_app');
    $as_at = $this->input->post('as_at');
    $balance = $this->input->post('balance');


    $data = array(
      'uniq_id' => $uniqid,
      'leave_required' => $leave_required,
      'leave_from' => $leave_from,
      'leave_to' => $leave_to,
      'back_work' => $back_work,
      'total_days' => $total_days,
      'reason' => $reason,
      'entitlement' => $entitlement,
      'leave_app' => $leave_app,
      'as_at' => $as_at,
      'balance' => $balance,
      'check_sts' =>'2',
      'sts' => '2'
    );

    // Solve XSS Attack
    $data = $this->security->xss_clean($data);

    echo $leave_from;
     try {

      $where = array(
      'uniq_id' => $this->session->userdata("uniq_id")
      );
      $data_user = $this->afl->showdata_afl("tb_login",$where);
      $row = $data_user->row();
      $r_leave = $row->r_leave;
      $jm = $r_leave-$total_days;
      if($total_days == 0){
           $this->session->set_flashdata('success', '<div class="alert alert-warning" entitlement="alert">
                                                      Create Application for Leave unsuccess!!
                                                    </div>');
          redirect(base_url("afl_user"));
      }else if($total_days < 0){
           $this->session->set_flashdata('success', '<div class="alert alert-warning" entitlement="alert">
                                                      Create Application for Leave unsuccess!!
                                                    </div>');
          redirect(base_url("afl_user"));
      }else{
          if ($jm >= 0) {
          $this->db->set('date_create', 'NOW()', FALSE);
          $this->db->set('history_year', date('Y'), FALSE);
          $this->afl->insert_afl("tb_afl",$data);
          $this->session->set_flashdata('success', '<div class="alert alert-success" entitlement="alert">
                                                      Create Application for Leave success
                                                    </div>');
          redirect(base_url("afl_user"));

          }else{
          $this->session->set_flashdata('success', '<div class="alert alert-warning" entitlement="alert">
                                                      Create Application for Leave unsuccess!!
                                                    </div>');
          redirect(base_url("afl_user"));
          }
      }
    }catch(Exception $e) {
      echo 'Message: ' .$e->getMessage();
    }
  
  }

  public function time_input($tgl){
    $time_d = new DateTime();
    $time_date = $time_d->format('H:i:s');
    $date = new DateTime($tgl);
    return $date->format('Y-m-d').' '.$time_date;
  }
}
?>