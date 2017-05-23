<?php 

class notifications_m extends MY_Model{
    
    protected $table_name="notifications";
    protected $primary_key="id";
    protected $primary_filter="intval";
    protected $order_by="id";
    public    $rulse="";
    protected $timestamps=false;
    
    
    public function get_notifications($cols="*" ,  $where="" , $method="result" , $ordered="" , $join = "" , $limit = "") 
    {
        
        return $this->db->query("select $cols from $this->table_name $join $where $ordered $limit ")->$method();
        
    }
    
}