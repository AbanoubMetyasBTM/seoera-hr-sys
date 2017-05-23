<?php 

class general_holiday_days_m extends MY_Model{
    
    protected $table_name="general_holiday_days";
    protected $primary_key="id";
    protected $primary_filter="intval";
    protected $order_by="id";
    public    $rulse="";
    protected $timestamps=false;
    
    
    // Function that get holidays demands
    public function get_general_holidays($col , $where , $ordered = "" , $method) 
    {
        
        return $this->db->query("select $col from $this->table_name $where $ordered ")->$method();
        
    }
    
}