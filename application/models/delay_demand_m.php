<?php 

class delay_demand_m extends MY_Model{
    
    protected $table_name="delay_demand";
    protected $primary_key="id";
    protected $primary_filter="intval";
    protected $order_by="id";
    public    $rulse="";
    protected $timestamps=false;
    
    
    // Function that get permissions demands
    public function get_permissions($col="*" , $join="" , $where="" , $ordered = "" , $method="result") 
    {
        
        return $this->db->query("select $col from $this->table_name $join $where $ordered ")->$method();
        
    }
    
}