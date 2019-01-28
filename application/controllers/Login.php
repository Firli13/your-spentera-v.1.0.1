<?php

	class Login extends CI_Controller{
	 
		function __construct(){
			parent::__construct();		
			$this->load->model('m_login', 'loginin');
			
		}

		function index(){
			if($this->session->userdata('status') == "login"){
				redirect(base_url("home"));
			}
			$this->load->view('v_login');
		}

		// function verify_login(){
		
		// 	$username = $this->input->post('email');
		// 	$password = $this->input->post('pass');

		// 	$where = array(
		// 		'username' => $username
		// 		);
			
		// 	$query = $this->loginin->check_login("tb_login",$where);
		// 	$check_users = $query->num_rows();
		// 	$row = $query->row();
		// 	if($check_users > 0){
		// 		 $hash = $row->password;
		// 		 if (password_verify($password, $hash)){
		// 				session_regenerate_id();
		//                 $data_session = array(
		// 				'uniq_id' => $row->uniq_id,
		// 				'username' => $row->username,
		// 				'name' => $row->name,
		// 				'jabatan' => $row->jabatan,
		// 				'no_karyawan' => $row->no_karyawan,
		// 				'doh' => $row->doh,
		// 				'role' => $row->role,
		// 				'status' => "login"
		// 			);
	 
		// 			$this->session->set_userdata($data_session);
		// 			redirect(base_url("home"));    
		
	 //            }else{
	 //            	redirect(base_url("login?fail"));
	 //        }

		// 	}else{
		// 		redirect(base_url("login?fail"));
		// 	}
		// }

		function verify_login(){
			
			$pass = $this->input->post('password');
			$priv_key= '-----BEGIN RSA PRIVATE KEY-----
MIIEoQIBAAKCAQBWDfHY9XNm3RnnNiL7oU2R2KbWDv1giYb25kz2ERd7eSc2zVwA
N7MqB+Chc5IjpgIXZlTR50sA48O3ALsaPNhC9K8yKKep8rJWwqGtK70PQV4hRsO7
avwTA/YevbN6qbiyysnKK3XWxD601HI17+MybbMhDeCYxiSAM9qgi6SHwYopXljA
mAW1RhgKZpji/YtpjMnSUqbjbJvcCJ0KnENHrIUqJ7jmvDsX8EuzlnWJjwE+loEH
uMgIMVL2UDbnrTvrXt+5oLCS+wpBy1uLysP+kZWiVJAZIr4JT4AWysnHD1yfqeHi
VWEEKYHvj0xanUeZnY5rVOIMwpp7t0sb+8MNAgMBAAECggEAPzQCuvybg6NEkSKb
0wCHvmTHNFTSGAMqU1CWmeu3uYIkIQX3WlmOh4I9o5cEcJZO1uzbw0cDOWYPquso
gH7Lv3GC824UpqeQAFT29f833mp+PiaBP7e16ClyrOVbWu4or3hteMUuyUxdWebm
82J7FeCoPdC5crukt1xeaKfncaUC/hC346ECdKnFKRRZ9mf9tSYSqY624SX+6ZYW
fdBECE228PQaHxL5ZBe3Rf2NWhwRdy1eXpNRjUo8lajJmSm3jNAqNDsUdO97sMP7
Srtq2C6doiJY5ry1QMYmc+n0l3d12PC20w2WYyEK68sVS+HAff/ggmFPSryhkAhD
A9akgQKBgQClySjgqZHAfoRXEY/ic6NZcCCDQ9bpaP+DW1OLtRqGoqNvV+VPYdxC
sWXlVUUTaBGmpnl04lwCGHnDuJ34j6Mqh5PCieZl1F3H3yn3GXv6839ZgNcDUuK0
IYeBJVvXJh3dSzBNemSQYsyKVIhS0t/Airls3Bb2gTEn+RYwNqft0QKBgQCE4co8
75alQcEYYdQGzcxZwCIlxoA/dnbsiCBnrMIBnJzDKGnRArGcpqeG+6JjKhZhLrfJ
L77owjPabHWw8mgdwf72vghtcTsLedTX1SSJm0Ic5Y0bNVWJO5Jjv9S9q5c249u6
ce/vYMSSMDCBnVEy23LjHoBnJYR39qiI5GdkfQKBgDTf8X+l1WyVbVPvr/pDc2fF
ETmMW3DaIhQc/opiWnFyUbnjSKmGxp8mwR7hkURdPrPuCHK09y9b6wn3SbrK5Pld
gEzdenQjxT1H+bRrllU1b/p10x2mQ9O7leIkriPybjf0ERXE4WoDeMTtrQTtaJua
IwWLNG+uSKU9FkyOQgThAoGAZ9Y4vt1KDuEPDwqDML3ojcnB5Vr0JKNh0vuctucc
wz2qkiYmahl8yTjBeI1yG6Nr0Y08OI6C1EfNVUWjwh3qljZeEln1I/Bzf0g4tl/s
KUuVohcO6NAIgzB1+FSS3ZQUmeP8c/lM0PYBJWtavC4+oUsyv5+6HuAGX+fzUuWI
ldECgYBJ1MxqCHwM4AmTmEAV7y58lMLVMco+8JF8h34b15UKuvEPzQgNDXnRX+4b
OglJ3lEa2sWolSbZN0o5nHGTg7+qpz78aG9fKxPwFo1BP0nPvfrS7HmEoC1asLN2
FMROuxNcd91m195NV7/20NoKyrNt0ijqq3c1PIirBbxiDBZfGQ==
-----END RSA PRIVATE KEY-----';

			$res = openssl_get_privatekey($priv_key);
			$tau = base64_decode($pass);
			openssl_private_decrypt($tau,$newsource,$res);
			$password = filter_var($newsource, FILTER_SANITIZE_STRING);
			$username = $this->input->post('username');

			$where = array(
			'username' => $username
			);
			
			$n = $this->input->post('n');
			$n_now = date("i");
			if($n!=$n_now){
				echo '0';
			}else{

			$pass = str_replace(":".$n.":","",$password);
			$query = $this->loginin->check_login("tb_login",$where);
			$check_users = $query->num_rows();
			$row = $query->row();

			if($check_users > 0){
	 			 $hash = $row->password;
	 			 if (password_verify($pass, $hash)){
	 						$this->session->sess_regenerate([$destroy = FALSE]);
		                    $data_session = array(
							'uniq_id' => $row->uniq_id,
							'username' => $row->username,
							'name' => $row->name,
							'jabatan' => $row->jabatan,
							'no_karyawan' => $row->no_karyawan,
							'doh' => $row->doh,
							'role' => $row->role,
							'status' => "login"
							);

							$this->session->set_userdata($data_session);
							return 1;
						
		                }else{
		                	$this->session->set_flashdata('error','<div class="alert bg-danger" role="alert"><em class="fa fa-lg fa-warning">&nbsp;</em> Username and Password wrong! <a href="#" class="pull-right"><em class="fa fa-lg fa-close"></em></a></div>');
		                	return FALSE;
		                }				
			}else{
				$this->session->set_flashdata('error','<div class="alert bg-danger" role="alert"><em class="fa fa-lg fa-warning">&nbsp;</em> Username and Password wrong! <a href="#" class="pull-right"><em class="fa fa-lg fa-close"></em></a></div>');
				return FALSE;	
				
			}
		}
	}

	function changepass(){
		$data['title']='Change Password';
		$data['active_change_password']='active';
	    $data['page']='v_change_password';
	    $where = array(
	      'uniq_id' => $this->session->userdata("uniq_id")
	    );
	    $data['getuser']= $this->loginin->getUser($where);
	    $this->load->view('template',$data);
	}

	function editpass(){
        	$uniq_user =  $this->session->userdata('uniq_id'); 
        	$check_current = $this->input->post('c_password');
        	$new_pass = $this->input->post('con_password');


        	$where = array(
				'uniq_id' => $uniq_user
			);
			$check= $this->loginin->getUser($where);
			$old_pass = $check->password;
			$hash = $old_pass;
 				
 				if (password_verify($check_current, $hash)){
						echo "1"; 
						$hash = $new_pass;
						$options = [ 'cost' => 12 ];
						$password = password_hash($hash, PASSWORD_BCRYPT, $options);

						$data = array(
							'password' => $password
						);
						$this->loginin->update_data("tb_login",$data, $uniq_user);
						$this->session->set_flashdata('success', '<div class="alert bg-info col-md-10 form-control" role="alert"><em class="fa fa-lg fa-check-circle">&nbsp;</em> Success create new password <a href="#" class="pull-right"><em class="fa fa-lg fa-close"></em></a></div>');
						 // $this->session->sess_destroy();
						 redirect(base_url("login/changepass"));

					}else{
						 $this->session->set_flashdata('error', '<div class="alert bg-danger col-md-10 form-control" role="alert"><em class="fa fa-lg fa-warning">&nbsp;</em> Current password wrong <a href="#" class="pull-right"><em class="fa fa-lg fa-close"></em></a></div>');
						 // $this->session->sess_destroy();
						 redirect(base_url("login/changepass"));
					}	
	}
 
	function logout(){
		$this->session->sess_destroy();
		redirect(base_url('login'));
	}
 
}
?>