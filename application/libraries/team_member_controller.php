<?php

class team_member_controller extends dashboard_controller{
    
    public function __construct() {
        parent::__construct();
        
        
        if ($this->users_m->loggedin()==true&&$this->data["user_type"]!="team_member")
        {
            redirect(base_url());
        }
    }
    
}
