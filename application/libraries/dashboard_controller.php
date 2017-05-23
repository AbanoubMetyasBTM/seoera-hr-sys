<?php

class dashboard_controller extends MY_Controller{
    
    function __construct() {
        parent::__construct();
        
        //to make sure that any one can not access to any link without login
        if ($this->users_m->loggedin()==FALSE)
        {
            redirect(base_url());
        }
        
        $this->userid=$this->session->userdata('userid');
        $user=$this->users_m->get($this->userid);
        
        $this->data["username"]=$user->email;
        $this->data["userid"]= $this->userid;
        $this->data["user_type"]= $user->user_type;

    }
    
}

