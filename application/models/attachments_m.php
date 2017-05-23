<?php 

class attachments_m extends MY_Model{
    
    protected $table_name="attachments";
    protected $primary_key="id";
    protected $primary_filter="intval";
    protected $order_by="id";
    public    $rulse="";
    protected $timestamps=false;
    
    
}