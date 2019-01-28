<?php
	class Home extends CI_Controller{
	 
		function __construct(){
			parent::__construct();		
			$this->load->model('m_afl_user', 'afl');
			$this->load->model('m_users_management', 'users_management');

		}

		function index(){
            $data['title']= 'Dashboard'; 
			$data['active_home']='active';
            $data['page']='v_home';
            $yearnow = date("Y");
            $where_year = array(
		      'history_year' => $yearnow
		      );
            $cekyear = $this->afl->cekafl("tb_afl",$where_year);
            	if ($cekyear->num_rows()>0) {
            			  $where = array(
				      		'uniq_id' => $this->session->userdata("uniq_id")
				      		);
				    		$data['data_user'] = $this->afl->showdata_afl("tb_login",$where);
				    		$data['data_afl'] = $this->afl->showdata_afl("tb_afl",$where);
				    		$data['data_listuser'] = $this->users_management->showdata_listuser("tb_login");
		            		$this->load->view('template',$data);
            	}else{
            			$uniq = $this->session->userdata("uniq_id");
            			$data_e = array('r_leave' => '12');
            			$this->afl->edit_user_login("tb_login",$data_e,$uniq);

            			$where = array(
		      				'uniq_id' => $this->session->userdata("uniq_id")
		    				);
		    			$data['data_user'] = $this->afl->showdata_afl("tb_login",$where);
		    	  		$data['data_afl'] = $this->afl->showdata_afl("tb_afl",$where);
			    		$data['data_listuser'] = $this->users_management->showdata_listuser("tb_login");
	            		$this->load->view('template',$data);
            	}


          
		}


 
}
?>