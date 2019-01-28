<?php

class M_users_management extends CI_Model{	

	var $table = 'tb_login';
    var $column_order = array(null, 'uniq_id','username','password','role','status','date_create','no_karyawan','doh','name','jabatan','born_place','birthday_date','gender','address'); //set column field database for datatable orderable
    var $column_search = array('uniq_id','username','password','role','status','date_create','no_karyawan','doh','name','jabatan','born_place','birthday_date','gender','address'); //set column field database for datatable searchable 
    var $order = array('id_user' => 'asc'); // default order 
 
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    
    //for datatables userss
    private function _get_datatables_query()
    {
         
        $this->db->from($this->table);
        $this->db->order_by("date_create", "desc");
        
        $i = 0;
     
        foreach ($this->column_search as $item) // loop column 
        {
            if($_POST['search']['value']) // if datatable send POST for search
            {
                 
                if($i===0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                }
                else
                {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
 
                if(count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }
         
        if(isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } 
        else if(isset($this->order))
        {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
 
    function get_datatables()
    {
        $this->_get_datatables_query();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
 
    function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all()
    {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    function showdata_users($table,$where){        
        return $this->db->get_where($table,$where);
    }

    function showdata_listuser($table){        
        return $this->db->get_where($table);
    }

    function insert_users($table,$data){        
        return $this->db->insert($table,$data);
    }

    function edit_users($table,$data,$id_lab_edit_user){
        return $this->db->update($table, $data, "uniq_id = ".$id_lab_edit_user);
    }

    function delete_users($table,$where){        
        return $this->db->delete($table,$where);
    }
}

?>