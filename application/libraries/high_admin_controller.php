<?php

class high_admin_controller extends dashboard_controller{
    
    
    public function __construct() {
        parent::__construct();
    
        if ($this->users_m->loggedin()==true&&$this->data["user_type"]!="high_admin")
        {
            redirect(base_url());
        }
        
    }
    
    
    
    
}
