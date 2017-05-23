<?php 

class tasks_m extends MY_Model{
    
    protected $table_name="tasks";
    protected $primary_key="task_id";
    protected $primary_filter="intval";
    protected $order_by="task_id";
    public    $rulse="";
    protected $timestamps=false;
    
    
    public function get_tasks($cols="*" ,  $where="" , $method="result" , $ordered="" , $join = "" , $limit = "") 
    {
        
        return $this->db->query("select $cols from $this->table_name $join $where $ordered $limit ")->$method();
        
    }
    
}