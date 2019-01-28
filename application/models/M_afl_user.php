<?php

class M_afl_user extends CI_Model{	

    //Function Datatables
	var $table = 'tb_afl';
    var $column_order = array(null, 'tb_login.uniq_id','tb_login.name','tb_login.jabatan','tb_afl.uniq_id','tb_afl.leave_required','tb_afl.leave_from','tb_afl.leave_to','tb_afl.back_work','tb_afl.total_days','tb_afl.reason','tb_afl.entitlement','tb_afl.leave_app','tb_afl.as_At','tb_afl.balance','tb_afl.date_create','tb_afl.sts','tb_afl.check_sts'); //set column field database for datatable orderable
    var $column_search = array('tb_login.uniq_id','tb_login.name','tb_login.jabatan','tb_afl.uniq_id','tb_afl.leave_required','tb_afl.leave_from','tb_afl.leave_to','tb_afl.back_work','tb_afl.total_days','tb_afl.reason','tb_afl.entitlement','tb_afl.leave_app','tb_afl.as_At','tb_afl.balance','tb_afl.date_create','tb_afl.sts','tb_afl.check_sts'); //set column field database for datatable searchable 
    var $order = array('tb_afl.id_afl' => 'asc'); // default order
 
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    
    //for datatables userss
    private function _get_datatables_query($sts)
    {
        $uri = $this->uri->segment(3, 0); 
        $role = $this->session->userdata('role');   
        if ($role == 'employee') {
            $this->db->from($this->table);
            $this->db->order_by("tb_afl.date_create", "desc");
            $this->db->join('tb_login','tb_afl.uniq_id = tb_login.uniq_id','inner');
            $this->db->where('tb_afl.uniq_id', $this->session->userdata('uniq_id'));
        }else if($role == 'admin' || $role == 'bod' ){
            $this->db->from($this->table);
            $this->db->order_by("tb_afl.date_create", "desc");
            $this->db->join('tb_login','tb_afl.uniq_id = tb_login.uniq_id','inner');
            if($sts!=null){
               $this->db->where('tb_afl.sts', $sts); 
            }

            if ($uri == 3) {
                 $this->db->where('tb_afl.uniq_id', $this->session->userdata('uniq_id'));
            }
        }

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
 
    function get_datatables($sts)
    {
        $this->_get_datatables_query($sts);
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
 
    function count_filtered($sts)
    {
        $this->_get_datatables_query($sts);
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all($sts)
    {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }
    //End Of Function Datatables

    function getPostsApp(){
        $query = $this->db->get('tb_history_app');
        return $query->result();
    }

    function getListApp($applist){ 
        //Join 2 table tb login and afl       
        // SELECT tb_login.uniq_id,tb_login.name,tb_login.r_leave, tb_afl.total_days, tb_afl.date_create, tb_afl.name_app, tb_afl.date_app, tb_afl.name_cek, tb_afl.date_knownby, tb_afl.history_year FROM tb_login INNER JOIN tb_afl ON tb_login.uniq_id=tb_afl.uniq_id;
        $this->db->select('tb_login.uniq_id,tb_login.name,tb_login.r_leave, tb_afl.total_days, tb_afl.date_create, tb_afl.name_app, tb_afl.date_app, tb_afl.name_cek, tb_afl.date_knownby, tb_afl.history_year'); 
        $this->db->from('tb_login');
        $this->db->join('tb_history_app','tb_login.uniq_id = tb_afl.uniq_id','inner');
        $this->db->where('tb_login',$applist);
        $query=$this->db->get();
        return $query;
    }

	function insert_afl($table,$data){        
        return $this->db->insert($table,$data);
    }

    function showdata_afl($table,$where){        
        return $this->db->get_where($table,$where);
    }

    function joinShowdata($listafl_user){
        $this->db->select('tb_login.uniq_id,tb_login.name,tb_login.jabatan,tb_login.no_karyawan,tb_login.doh,tb_afl.id_afl, tb_afl.uniq_id, tb_afl.leave_required, tb_afl.leave_from, tb_afl.leave_to, tb_afl.back_work, tb_afl.total_days, tb_afl.reason, tb_afl.entitlement, tb_afl.leave_app, tb_afl.as_at, tb_afl.balance, tb_afl.date_create, tb_afl.sts, tb_afl.name_app, tb_afl.date_app, tb_afl.check_sts, tb_afl.name_cek, tb_afl.date_knownby, tb_afl.history_year'); 
        $this->db->from('tb_afl');
        $this->db->join('tb_login','tb_afl.uniq_id = tb_login.uniq_id','inner');
        $this->db->where('tb_afl.id_afl',$listafl_user);
        $query=$this->db->get();
        return $query;
    }
    function cekafl($table,$where_year){        
        return $this->db->get_where($table,$where_year);
    }

    function show_as_at_afl($table,$uniq_id){ 
        $this->db->select_min('date_app');     
        $this->db->from($table);
        $this->db->where('uniq_id',$uniq_id);
        $this->db->where('sts','1');
        $this->db->order_by("date_app", "desc"); 
        $this->db->limit(1);
        $query=$this->db->get();
        $get_data= $query->row();
        return $get_data->date_app;
    }

    function showdata_afl_user($table,$id_afl,$uniq_id){        
        $this->db->from($table);
        $this->db->where('id_afl',$id_afl);
        $this->db->where('uniq_id',$uniq_id);
        $query=$this->db->get();
        return $query;
    }


    function edit_afl($tb_afl,$tb_login,$data,$id_listafl_user,$where_id,$total_days,$uniq_id){
        $edit = $this->db->update($tb_afl, $data, "id_afl = ".$id_listafl_user); //kita updte status form cuti jadi 1
        $show = $this->db->get_where($tb_login,$where_id); //get data r_leave(jml cuti user)
        $row = $show->row();
        $r_leave = $row->r_leave; //get data r_leave(jml cuti user)
        $tot_days = $r_leave - $total_days; //kurangi hml cuti yg ada dengan yg diambil(total_days)
        //array update data ke r_leave user
        $data_edit = $data = array(
                'r_leave' => $tot_days
            );
        return $this->db->update($tb_login, $data_edit, "uniq_id = ".$uniq_id); //update dengan data yang sudah dikurangi
    }

    function edit_diss_afl($table,$data,$id_listafl_user){
        return $this->db->update($table, $data, "id_afl = ".$id_listafl_user);
    }

    function edit_cekafl($table,$data,$id_cekafl_user){
        return $this->db->update($table, $data, "id_afl = ".$id_cekafl_user);
    }

    function edit_user_afl($table,$data,$id_listafl_user){
        return $this->db->update($table, $data, "id_afl = ".$id_listafl_user);
    }

    function edit_user_login($table,$data_e,$uniq){
        return $this->db->update($table, $data_e, "uniq_id = ".$uniq);
    } 
    function delete_afl($table,$where){        
        return $this->db->delete($table,$where);
    }
}
?>