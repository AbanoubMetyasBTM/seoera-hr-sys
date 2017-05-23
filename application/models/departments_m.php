<?php 

class departments_m extends MY_Model{
    
    protected $table_name="departments";
    protected $primary_key="dep_id";
    protected $primary_filter="intval";
    protected $order_by="dep_id";
    public    $rulse="";
    protected $timestamps=false;
    
    
}