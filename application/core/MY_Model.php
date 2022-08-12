<?php


defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        //Do your magic here
        $this->load->library('Datatables', 'datatables');
        
    }

    public function add_data($table, $data){
        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }

    public function delete_data($table, $where){
        $this->db->where($where);
        $this->db->delete($table);
        return $this->db->affected_rows();
    }

    public function edit_data($table, $where, $data){
        $this->db->where($where);
        $this->db->update($table, $data);
        return $this->db->affected_rows();
    }

    public function get_one($table, $where = "", $order = "", $by = "ASC"){
        $this->db->from($table);
        if($where)
            $this->db->where($where);
        if($order)
            $this->db->order_by($order, $by);
        return $this->db->get()->row_array();
    }

    public function get_all($table, $where = "", $order = "", $by = "ASC"){
        $this->db->from($table);
        if($where)
            $this->db->where($where);
        if($order)
            $this->db->order_by($order, $by);
        return $this->db->get()->result_array();
    }
    
    public function get_all_limit($table, $where = "", $order = "", $by = "ASC", $rowno, $rowperpage){
        $this->db->from($table);
        if($where)
            $this->db->where($where);
        if($order)
            $this->db->order_by($order, $by);

        $this->db->limit($rowperpage, $rowno);  
        
        return $this->db->get()->result_array();
    }

    public function get_all_limit_like($table, $col, $like, $where = "", $order = "", $by = "ASC", $rowno, $rowperpage){
        $this->db->from($table);
        $this->db->like($col, $like);
        if($where)
            $this->db->where($where);
        if($order)
            $this->db->order_by($order, $by);

        $this->db->limit($rowperpage, $rowno);  
        
        return $this->db->get()->result_array();
    }

    public function get_all_group_by($table, $where = "", $group = ""){
        $this->db->from($table);
        if($where)
            $this->db->where($where);
        if($group)
            $this->db->group_by($group);
        return $this->db->get()->result_array();
    }

    public function get_all_join_table($table1, $table2, $key, $where, $join="right"){
        $this->db->from($table1);
        $this->db->join($table2, "$table1.$key = $table2.$key", $join);
        if($where)
            $this->db->where($where);
        return $this->db->get()->result_array();
    }

    public function get_all_join_table_group($table1, $table2, $key, $where, $group, $join="right"){
        $this->db->from($table1);
        $this->db->join($table2, "$table1.$key = $table2.$key", $join);
        if($where)
            $this->db->where($where);
        if($group)
            $this->db->group_by($group);
        return $this->db->get()->result_array();
    }

    public function select_get_all_join_table_group($select, $table1, $table2, $key, $where, $group, $join="right"){
        if($select)
            $this->db->select($select);
        $this->db->from($table1);
        $this->db->join($table2, "$table1.$key = $table2.$key", $join);
        if($where)
            $this->db->where($where);
        if($group)
            $this->db->group_by($group);
        return $this->db->get()->result_array();
    }

    public function get_all_like($table, $col, $like, $where, $orderby = "", $urut = "ASC"){
        $this->db->from($table);
        $this->db->like($col, $like);
        if($where) $this->db->where($where);
        if($orderby) $this->db->order_by($orderby, $urut);
        return $this->db->get()->result_array();
    }

    public function select($select){
        $this->db->select($select);
        return $this;
    }

    public function from($table){
        $this->db->from($table);
        return $this;
    }

    public function where($where){
        $this->db->where($where);
        return $this;
    }

    public function getOne(){
        return $this->db->get()->row_array();
    }

    public function getAll(){
        return $this->db->get()->result_array();
    }

    public $column_order = [];
    public $column_search = [];
    public $order = [];
    
    public $select = [];
    public $table = [];
    public $where = [];
    public $join = [];
    public $join_condition = [];

    // data table for desktop view
    private function _get_datatables_query(){
        if(!empty($this->select)) $this->db->select($this->select);
        $this->db->from($this->table);
        if(!empty($this->join)) $this->db->where($this->join, $this->join_condition);
        if(!empty($this->where)) $this->db->where($this->where);

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
 
    function get_datatables(){
        $this->_get_datatables_query();
        if($_POST['length'] -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
 
    function count_filtered(){
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all(){
        if(!empty($this->select)) $this->db->select($this->select);
        $this->db->from($this->table);
        if(!empty($this->join)) $this->db->where($this->join, $this->join_condition);
        if(!empty($this->where)) $this->db->where($this->where);
        return $this->db->count_all_results();
    }
    // data table for desktop view

    public $rowperpage = 6;
    public $search_row = "";
    public $order_by = "";
    public $url = "";
    public $total_rows = "";
    public $rowno = "";

    // mobile view
        public function data_mobile($result_record){
            // Pagination Configuration
            $config['base_url'] = $this->url;
            $config['use_page_numbers'] = TRUE;
            $config['total_rows'] = $this->total_rows;
            $config['per_page'] = $this->rowperpage;

            // Membuat Style pagination untuk BootStrap v4
            $config['first_link']       = "First";
            $config['last_link']        = "Last";
            $config['next_link']        = '<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><polyline points="9 6 15 12 9 18" /></svg>';
            $config['prev_link']        = '<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><polyline points="15 6 9 12 15 18" /></svg>';
            $config['full_tag_open']    = '<nav><ul class="pagination pagination-md justify-content-center">';
            $config['full_tag_close']   = '</ul></nav>';
            $config['num_tag_open']     = '<li class="page-item"><span class="page-link">';
            $config['num_tag_close']    = '</span></li>';
            $config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
            $config['cur_tag_close']    = '<span class="sr-only"></span></span></li>';
            $config['next_tag_open']    = '<li class="page-item"><span class="page-link">';
            $config['next_tagl_close']  = '<span aria-hidden="true">&raquo;</span></span></li>';
            $config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
            $config['prev_tagl_close']  = '</span>Next</li>';
            $config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
            $config['first_tagl_close'] = '</span></li>';
            $config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
            $config['last_tagl_close']  = '</span></li>';

            // Initialize
            $this->pagination->initialize($config);
        
            // Initialize $data Array
            $data['pagination'] = $this->pagination->create_links();
            $data['result'] = $result_record;
            $data['row'] = $this->rowno;
            $data['total_rows'] = $this->total_rows;
            $data['total_rows_perpage'] = COUNT($result_record);
        
            return $data;
        }
    // mobile view

    // custom 
        public function get_langganan(){
            $sewa = $this->get_all("sewa", ["hapus" => 0, "status" => "Aktif"], "jualan", "ASC");
            
            $data = [];
            foreach ($sewa as $i => $sewa) {
                $pelanggan = $this->get_one("pelanggan", ["id_pelanggan" => $sewa['id_pelanggan']]);
                $data[$i] = $sewa;
                $data[$i]['nama_pelanggan'] = $pelanggan['nama_pelanggan'];
            }
            return $data;
        }
    // custom 
}

/* End of file MY_Model.php */
