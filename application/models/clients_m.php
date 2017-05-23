<?php 

class clients_m extends MY_Model{
    
    protected $table_name="clients";
    protected $primary_key="client_id";
    protected $primary_filter="intval";
    protected $order_by="client_id";
    public    $rulse="";
    protected $timestamps=false;
    
    
}