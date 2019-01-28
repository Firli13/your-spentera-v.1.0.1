<?php
	class Users_management extends CI_Controller{
	 
	function __construct(){
		parent::__construct();		
		$this->load->model('m_users_management', 'users_management');

    if($this->session->userdata('status') != "login" || $this->session->userdata('role') != "admin"){
      redirect(base_url("login"));
    }
		
	}

	function index(){
		$data['title']='Users Management';
		$data['active_users_management']='active';
    $data['page']='v_users_management';
    $this->load->view('template',$data);
	}

	public function ajax_list(){
    $list = $this->users_management->get_datatables();
    $data = array();
    $no = $_POST['start'];
    
    foreach ($list as $users_management) {
        $no++;
        $row = array();
        $row[] = $no;
        $row[] = $users_management->username;
        $row[] = $users_management->name;
        $row[] = $users_management->date_create;
        $row[] = $users_management->jabatan;
        $row[] = $users_management->role;
        $row[] = '<div style="text-align: center">
                    <button type="button" class="btn btn-success btn-fw" title="Showdata" onclick="read_users('.$users_management->uniq_id.')"><i class="mdi mdi-eye"></i></button>
                    <button type="button" class="btn btn-success btn-fw" title="Edit" onclick="id_edit_user('.$users_management->uniq_id.')"><i class="mdi mdi-table-edit"></i></button>
                    <button type="button" class="btn btn-success btn-fw" title="Delete" onclick="del_users('.$users_management->uniq_id.')"><i class="mdi mdi-delete"></i></button>
                  </div>'; 

        $data[] = $row;
    }

    $output = array(
              "draw" => $_POST['draw'],
              "recordsTotal" => $this->users_management->count_all(),
              "recordsFiltered" => $this->users_management->count_filtered(),
              "data" => $data,
            );
    //output to json format
    echo json_encode($output);
    }

  function create_users(){
    $uniqid = abs(crc32(uniqid()));
    $no_kar = $this->input->post('no_kar');
    $doh = $this->input->post('doh');
    $fullname = $this->input->post('fullname');
    $position = $this->input->post('position');
    $b_place = $this->input->post('b_place');
    $b_date = $this->input->post('b_date');
    $gender = $this->input->post('gender');
    $address = $this->input->post('address');
    $user_name = $this->input->post('user_name');
    
    //Password Hash
    $hash = $this->input->post('c_pass');
    $options = [ 'cost' => 12 ];
    $password = password_hash($hash, PASSWORD_BCRYPT, $options);
    //End of Password Hash

    $role = $this->input->post('role');
    if ($role == 'bod'){
            $r_leave = "0";
        } else { 
            $r_leave = "12";
        }

    $data = array(
      'uniq_id' => $uniqid,
      'no_karyawan' => $no_kar,
      'doh' => $doh,
      'name' => $fullname,
      'jabatan' => $position,
      'born_place' => $b_place,
      'birthday_date' => $b_date,
      'gender' => $gender,
      'address' => $address,
      'username' => $user_name,
      'password' => $password,
      'role' => $role,
      'r_leave' => $r_leave,
      'status' => "0"

    );

    // Solve XSS Attack
    $data = $this->security->xss_clean($data);

    try {

      $this->db->set('date_create', 'NOW()', FALSE);
      $this->users_management->insert_users("tb_login",$data);
      $this->session->set_flashdata('success', '<div class="alert alert-success" role="alert">
                                                  Create user success
                                                </div>');
      redirect(base_url("users_management"));

    }catch(Exception $e) {
      echo 'Message: ' .$e->getMessage();
    }      
  }

  function data_users(){
    $uniq_id_aflusers = $this->input->post('uniq_id_aflusers');

    $where = array(
      'uniq_id' => $uniq_id_aflusers
    );

    $query = $this->users_management->showdata_users("tb_login",$where);
    $row = $query->row();
    

    echo '<div class="row">
          <div class="col-sm-1"></div>
          <div class="col-sm-5">
            <div class="modal-body">
              <label><B>ID Karyawan</B></label>
              <p>'.$row->no_karyawan.'</p>
            </div>
            <div class="modal-body">
              <label><B>Date of Hire</B></label>
              <p>'.$row->doh.'</p>
            </div>
            <div class="modal-body">
              <label><B>Fullname</B></label>
              <p>'.$row->name.'</p>
            </div>
            <div class="modal-body">
              <label><B>Position</B></label>
              <p>'.$row->jabatan.'</p>
            </div>
            <div class="modal-body">
              <label><B>Born Place</B></label>
              <p>'.$row->born_place.'</p>
            </div>
            <div class="modal-body">
              <label><B>Birthday Date</B></label>
              <p>'.$row->birthday_date.'</p>
            </div>
          </div>
          <div class="col-sm-5">
            <div class="modal-body">
              <label><B>Gender</B></label>
              <p>'.$row->gender.'</p>
            </div>
            <div class="modal-body">
              <label><B>Address</B></label>
              <p>'.$row->address.'</p>
            </div>
            <div class="modal-body">
              <label><B>Username</B></label>
              <p>'.$row->username.'</p>
            </div>
            <div class="modal-body">
              <label><B>Role</B></label>
              <p>'.$row->role.'</p>
            </div>
            <div class="modal-body">
              <label><B>Sisa Cuti</B></label>
              <p>'.$row->r_leave.'</p>
            </div>
          </div>
          <div class="col-sm-1"></div>
          </div';
  }

  function showdata_edit_users(){
    $id_lab_edit_user = $this->input->post('id_lab_edit_user');

    $where = array(
      'uniq_id' => $id_lab_edit_user
    );

    $query = $this->users_management->showdata_users("tb_login",$where);
    $row = $query->row();

    echo '<div class="row">
          <div class="col-sm-1"></div>
          <div class="col-sm-5">
            <div class="modal-body">
              <label><B>ID Karyawan</B></label>
              <input type="text" class="form-control" name="no_karyawan_edit" id="no_karyawan_edit" value="'.$row->no_karyawan.'">
            </div>
            <div class="modal-body">
              <label><B>Date of Hire</B></label>
              <input type="text" class="form-control" name="doh_edit" id="doh_edit" value="'.$row->doh.'">
            </div>
            <div class="modal-body">
              <label><B>Fullname</B></label>
              <input type="text" class="form-control" name="name_edit" id="name_edit" value="'.$row->name.'">
            </div>
            <div class="modal-body">
              <label><B>Position</B></label>
              <div class="form">
                <select class="form-control" name="position_edit" id="position_edit" style="color: #495057;">
                  <option >'.$row->jabatan.'</option>
                  <option value="Engineer">Engineer</option>
                  <option value="GA & Finance">GA & Finance</option>
                  <option value="Account Manager">Account Manager</option>
                  <option value="Developer">Developer</option>
                  <option value="Content Writer">Content Writer</option>
                </select>
              </div>
            </div>
            <div class="modal-body">
              <label><B>Born Place</B></label>
              <input type="text" class="form-control" name="born_place_edit" id="born_place_edit" value="'.$row->born_place.'">
            </div>
          </div>
          <div class="col-sm-5">
            <div class="modal-body">
              <label><B>Gender</B></label>
              <div class="form">
                <select class="form-control madol" name="gender_edit" id="gender_edit" style="color: #495057;">
                  <option >'.$row->gender.'</option>
                  <option value="male">Male</option>
                  <option value="female">Female</option>
                </select>
              </div>
            </div>
            <div class="modal-body">
              <label><B>Address</B></label>
              <input type="text" class="form-control" name="address_edit" id="address_edit" value="'.$row->address.'">
            </div>
            <div class="modal-body">
              <label><B>Username</B></label>
              <input type="text" class="form-control" name="username_edit" id="username_edit" value="'.$row->username.'">
            </div>
            <div class="modal-body">
              <label  class="control-label"><b>Role</b></label>
              <div class="form">
                <select class="form-control" name="role_edit" id="role_edit" style="color: #495057;">
                  <option >'.$row->role.'</option>
                  <option value="admin">Admin</option>
                  <option value="employee">Employee</option>
                </select>
              </div>
            </div>
            <div class="modal-body">
              <label><B>Birthday Date</B></label>
              <input type="text" class="form-control" name="birthday_date_edit" id="birthday_date_edit" value="'.$row->birthday_date.'">
            </div>
          </div>
          <div class="col-sm-1"></div>
          </div';
  }

  function edit_users(){
    $id_lab_edit_user = $this->input->post('id_lab_edit_user');

    $no_karyawan = $this->input->post('no_karyawan_edit');
    $doh = $this->input->post('doh_edit');
    $name = $this->input->post('name_edit');
    $jabatan = $this->input->post('position_edit');
    $born_place = $this->input->post('born_place_edit');
    $birthday_date = $this->input->post('birthday_date_edit');
    $gender = $this->input->post('gender_edit');
    $address = $this->input->post('address_edit');
    $username = $this->input->post('username_edit');
    $role = $this->input->post('role_edit');
    $r_leave = $this->input->post('r_leave_edit');

    $data = array(
      'no_karyawan' => $no_karyawan,
      'doh' => $doh,
      'name' => $name,
      'jabatan' => $jabatan,
      'born_place' => $born_place,
      'birthday_date' => $birthday_date,
      'gender' => $gender,
      'address' => $address,
      'username' => $username,
      'role' => $role,
      'r_leave' => $r_leave
    );

    // Solve XSS Attack
    $data = $this->security->xss_clean($data);

    try {

      $this->users_management->edit_users("tb_login",$data, $id_lab_edit_user);
      $this->session->set_flashdata('success', '<div class="alert alert-success"><strong>Edit data users is Success!</strong></div>');
      
    }catch(Exception $e) {
      echo 'Message: ' .$e->getMessage();
    }
  }

  function delete_users(){
    $id_del_users = $this->input->post('id_del_users');
    $where = array(
    'uniq_id' => $id_del_users
    );

    try {
        $this->users_management->delete_users("tb_login",$where);
        $this->session->set_flashdata('success', '<div class="alert alert-success"><strong>Delete data users is Success!</strong></div>');

    }catch(Exception $e) {
      echo 'Message: ' .$e->getMessage();
    }
  }
}
?>