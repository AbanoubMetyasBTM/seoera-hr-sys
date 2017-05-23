<?php 

class work_times_m extends MY_Model{
    
    protected $table_name="work_times";
    protected $primary_key="id";
    protected $primary_filter="intval";
    protected $order_by="id";
    public    $rulse="";
    protected $timestamps=false;
    
    


    // Team_Member Panel >>> Ahmed Bakr

    public function get_cond($col , $where , $method , $order = "",$limit="") 
    {
        return $this->db->query("select $col from $this->table_name $where $order $limit")->$method();
    }
        
    
    public function get_cond_inner_join_users($col , $where , $method , $order = "",$limit="") 
    {
        return $this->db->query("select $col from $this->table_name as wt
                inner join users as u on wt.userid=u.userid
                $where $order $limit")->$method();
    }


    // ./Team_Member Panel >>> Ahmed Bakr
    
    
    
}
    
    

