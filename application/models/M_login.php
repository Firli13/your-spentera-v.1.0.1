<?php

	class M_login extends CI_Model{	
		function check_login($table,$where){		
			return $this->db->get_where($table,$where);
		}	

		function getUser($where){
	        $query = $this->db->get_where('tb_login',$where);
	        return $query->row();
	    }

	    function update_data($table,$data,$uniq_user){ 
	     	return $this->db->update($table, $data, array('uniq_id' => $uniq_user));  
	    }
	}

?>
