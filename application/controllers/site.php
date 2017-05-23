<?php

class site extends MY_Controller{
    
    public function __construct() {
        parent::__construct();
            
        if ($this->users_m->loggedin()==true)
        {
            $this->userid=$this->session->userdata('userid');
            $user=$this->users_m->get($this->userid);

            $this->data["username"]=$user->username;
            $this->data["userid"]= $this->userid;
            $this->data["user_type"]= $user->user_type;
            
            if($user->user_type=="high_admin"){
                redirect(base_url("high_admin/dashboard"));
            }
            else if($user->user_type=="team_member"){
                redirect(base_url("team_member/dashboard"));
            }
            else if($user->user_type=="customer"){
                redirect(base_url("customer/dashboard"));
            }
            else{
                redirect(base_url());
            }
        }
        
    }
    
    
    
    public function index() {
        $this->load->view("main/login",$this->data);
    }
    
    public function ajax_login()
    {
        $username=$this->input->post("email");
        $password=$this->input->post("password");

        $validation_rules=(array(
            "email"=>array(
                "field"=>"email",
                "label"=>"email",
                "rules"=>"xss_clean|trim|required"
            ),
            "password"=>array(
                "field"=>"password",
                "label"=>"password",
                "rules"=>"xss_clean|trim|required"
            )
        ));
        
        $this->load->library("form_validation");
        $this->form_validation->set_rules($validation_rules);
        
        $output=array();
        $output["success"]="";
        $output["url"]="";
        $output["error"]="";

        
        if ($this->form_validation->run()) {
            $userid=$this->users_m->login($username,$password);
            
            if ($userid>0) {
                $output["success"]="success";
                $user=$this->users_m->get($userid);
                
                if ($user->user_type=="site_admin") {
                    $output["url"]=base_url("site/admin_panel");
                }
                else if($user->user_type=="high_admin"){
                    $output["url"]=base_url("site/high_admin");
                }
                else if($user->user_type=="team_member"){
                    $output["url"]=base_url("site/team_member");
                }
                else if($user->user_type=="customer"){
                    $output["url"]=base_url("site/customer");
                }
                else{
                    $output["url"]=base_url();
                }
                
            }
            else{
                $output["error"]="Invalid username or password";
            }
        }
        else
        {
            $output["error"]=  validation_errors();
        }
        
        echo json_encode($output);
    }
    
    
}

