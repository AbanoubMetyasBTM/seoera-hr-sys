<?php

class customer_controller extends dashboard_controller{
    
    public function __construct() {
        parent::__construct();
        
        if ($this->users_m->loggedin()==true&&$this->data["user_type"]!="customer")
        {
            redirect(base_url());
        }
        
    }
    
}
