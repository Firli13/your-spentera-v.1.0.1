<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


function jabatan($uniq_id)
{
    
    $ci=& get_instance();
    $ci->load->database();

    //select the required fields from the database
    $ci->db->select('jabatan');

    //tell the db class the criteria
    $ci->db->where('uniq_id',$uniq_id);

    //supply the table name and get the data
    $row = $ci->db->get('tb_login')->row();

    //get the full name by concatinating the first and last names
    $fullName = $row->jabatan;

    // return the full name;
    return $fullName;

  
}    

?>

