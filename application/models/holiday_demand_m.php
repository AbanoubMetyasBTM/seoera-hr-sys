<?php 

class holiday_demand_m extends MY_Model{
    
    protected $table_name="holiday_demand";
    protected $primary_key="id";
    protected $primary_filter="intval";
    protected $order_by="id";
    public    $rulse="";
    protected $timestamps=false;
    
    
    // Function that get holidays demands
    public function get_holidays($col , $join="" , $where="" , $ordered = "" , $method="result") 
    {
        
        return $this->db->query("select $col from $this->table_name $join $where $ordered ")->$method();
        
    }
    
    
}