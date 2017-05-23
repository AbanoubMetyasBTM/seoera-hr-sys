<?php


class dashboard extends customer_controller{
    
    public function __construct() {
        parent::__construct();
    }
    
    public function logout()
    {
        $this->users_m->logout();
        redirect(base_url());
    }
    
    
    public function index() 
    {
        
        // Initialize Data
        
            // load models
            $this->load->model("work_times_m");
            $this->load->model("tasks_m");
            $this->load->model("general_holiday_days_m");
            $this->load->model("notifications_m");


            $this->data["user"] = "";
            $this->data["tasks"] = "";
            $this->data["working_activites"] = array();
            $this->data["task_count"] = array();
            
            $this->data["general_holiday_days"] = "";
            $this->data["notifications"] = "";


        // ./Initialize Data
            
            
        // get user data join with attachments , Department
            
            $temp_user = $this->users_m->get_users("*"," where user_obj.userid = $this->userid " , "row" ,"");
            
            if (isset($temp_user) && count($temp_user) && !empty($temp_user) ) {
                
                $this->data["user"] = $temp_user;
                
            }
            
            
        // ./get user data join with attachments , Department
            
            
        // Get all Notifications 
            
            $temp_notifications = $this->notifications_m->get_notifications($cols="*" ,  $where=" where userid = $this->userid" , $method="result" , $ordered=" order by note_date desc " , $join = "" , $limit = "");
            
            if (is_array($temp_notifications) && isset($temp_notifications) && count($temp_notifications) && !empty($temp_notifications) ) {
                
                $this->data["notifications"] = $temp_notifications;
                
            }
            //dump($this->data["notifications"]);
            
        // ./Get all Notifications 
            
            
        // get user last 5 tasks ordered in priority and start date
            
            $temp_task = $this->tasks_m->get_tasks("*"," where client_id = $this->userid and task_statues != 'done' " , "result" ," order by task_start_date  desc , task_priority asc " , "" , " LIMIT 5 ");
            
            if (is_array($temp_task) && isset($temp_task) && count($temp_task) && !empty($temp_task) ) {
                
                $this->data["tasks"] = $temp_task;
                
            }
            //dump($this->data["tasks"]);
            
        // ./get user last 5 tasks ordered in priority and start date
            
            
        // get user tasks's status count 
            
            // 1- Count Done tasks
            $temp_task = $this->tasks_m->get_tasks("count(*) as done"," where client_id = $this->userid and task_statues = 'done' " , "row" , 
                "" , "" , "");
            
            if (isset($temp_task) && count($temp_task) && !empty($temp_task) ) {
                
                array_push($this->data["task_count"], $temp_task);
                
            }
            
            // 2- Count Waiting tasks
            $temp_task = $this->tasks_m->get_tasks("count(*) as waiting"," where client_id = $this->userid and task_statues = 'waiting' " , "row" , 
                "" , "" , "");
            
            if (isset($temp_task) && count($temp_task) && !empty($temp_task) ) {
                
                array_push($this->data["task_count"], $temp_task);
                
            }
            
            // 3- Count In Process tasks
            $temp_task = $this->tasks_m->get_tasks("count(*) as in_process"," where client_id = $this->userid and task_statues = 'in_process' " , "row" , 
                "" , "" , "");
            
            if (isset($temp_task) && count($temp_task) && !empty($temp_task) ) {
                
                array_push($this->data["task_count"], $temp_task);
                
            }
            
            
            // 4- Count Testing tasks
            $temp_task = $this->tasks_m->get_tasks("count(*) as testing"," where client_id = $this->userid and task_statues = 'testing' " , "row" , 
                "" , "" , "");
            
            if (isset($temp_task) && count($temp_task) && !empty($temp_task) ) {
                
                array_push($this->data["task_count"], $temp_task);
                
            }
            
        // ./get user tasks's status count 
        
        
        //dump("customer");
        
        
        
        // load view of Dashboard

        $this->data['subview'] = $this->load->view('customer/subviews/index', $this->data, true);
        $this->load->view('customer/main_layout', $this->data);

        // ./load view of Dashboard
        
    }
    
}




?>
