<?php

class tasks extends customer_controller{
    
    public function __construct() {
        parent::__construct();
        
        $this->load->model("tasks_m");
        
    }
    
    
    public function index() 
    {

        // Initialize Data
        
            // load models
            


            $this->data["tasks"] = "";

        // ./Initialize Data
            
            
        // get user tasks ordered in priority and start date
            
            $temp_task = $this->tasks_m->get_tasks("*"," where tasks.client_id = $this->userid " , "result" , 
                " order by tasks.task_priority asc " , " inner join users on tasks.userid = users.userid ");
            
            if (is_array($temp_task) && isset($temp_task) && count($temp_task) && !empty($temp_task) ) {
                
                $this->data["tasks"] = $temp_task;
                
            }
            
        // ./get user tasks ordered in priority and start date
            
        
        // load view of tasks

        $this->data['subview'] = $this->load->view('customer/subviews/tasks/tasks', $this->data, true);
        $this->load->view('customer/main_layout', $this->data);

        // ./load view of tasks
    
        
    }
    
    public function _load_task_note_status($task_id) 
    {

        if ($task_id == null) {
            redirect(base_url("team_member/tasks"));
        }
                    
        // get user task ordered in priority and start date
            
            $temp_task = $this->tasks_m->get_tasks("*"," where task_id = $task_id and client_id = $this->userid " , "row" , 
                " order by task_start_date  desc , task_priority asc " , "" , "");
            
            if (isset($temp_task) && count($temp_task) && !empty($temp_task) ) {
                
                $this->data["task"] = $temp_task;
                
            }
            else{
                
                redirect(base_url("customer/tasks"));
                
            }
            
        // ./get user task ordered in priority and start date
            
        // Get All high_admin
            
            $temp_admin = $this->users_m->get_users("*" , " where user_type = 'high_admin' " , "result" , "");

            if (is_array($temp_admin) && isset($temp_admin) &&!empty($temp_admin) && count($temp_admin)) {

                $this->data["high_admins"] = $temp_admin;
                
            }
            
        // ./Get All high_admin
          //dump($this->data["high_admins"]);
    
        
    }
    
    public function edit_note_status($task_id = null) 
    {


        // Initialize Data
        
            // load models
            $this->load->model("tasks_m");
            $this->load->model("notifications_m");
            $this->load->library("form_validation");


            $this->data["task"] = "";
            $this->data["high_admins"] = "";

        // ./Initialize Data
            
        
        echo $this->_load_task_note_status($task_id);
        
        
        
        
        // validation rules
        
            $task_validation_rules = validation_array_generator(
                            
                array("task_statues" , "task_note_by_client" ),
                "",  
                array("task_statues" , "task_note_by_client"),
                array("Task Status","Task Note By Client")

            );
            
            
            $this->form_validation->set_rules($task_validation_rules);
            //dump($_POST);
            if ($this->form_validation->run())
            {
                //dump($_POST);
                $post_data = $_POST;
                
                unset($post_data['submit']);
                
                //dump($post_data);
                
                if ($task_id != null) {
                    // edit task
                    
                    
                    //dump($post_data);
                    $this->tasks_m->save($post_data , $task_id);
                    
                    echo $this->_load_task_note_status($task_id);
                    
                    $this->data["validation_errors"] = "Your Note to this Task has been edited Successfully...";
                    
                    if (isset($post_data["task_note_by_client"]) && !empty($post_data["task_note_by_client"])) {
                        
                        $user_data = $this->users_m->get($this->userid);
                        $employee_data = $this->users_m->get($this->data["task"]->userid);
                        //dump($user_data);
                        
                        foreach ($this->data["high_admins"] as $key => $value) {
                            
                            $notify = array(
                            
                                "userid" => $value->userid,
                                "note_header" => "Note from Client to Member",
                                "note_body" => "Client '".$user_data->username."' has send note to member '".$employee_data->username."' "
                                . "and its body is '".$this->data["task"]->task_note_by_client."' ",
                                "note_date" => datetime_now()

                            );
                        
                            $this->notifications_m->save($notify);
                            
                        }
                        
                    }
                    
                }
                else{
                    redirect(base_url("customer/tasks"));
                }
                
                
            }
            
            else{
                
                $this->data["validation_errors"] = validation_errors();
                
            }
        // ./validation rules   
        
        // load view of edit_note_status

        $this->data['subview'] = $this->load->view('customer/subviews/tasks/edit_note_status', $this->data, true);
        $this->load->view('customer/main_layout', $this->data);

        // ./load view of edit_note_status
    
        
    }
    
    
    public function tasks_activities()
    {
        
        // Initialize Data
        
            // load models

            $this->data["users_tasks"] = "";
            $this->data["selected_user"] = "";
            $this->data["task_count"] = array();

        // ./Initialize Data
            
        if (isset($_POST['userid'])) {
            
            $this->data["selected_user"] = $_POST['userid'];
            
            
            // get user tasks's status count 
            
                // 1- Count Done tasks
                $temp_task = $this->tasks_m->get_tasks("count(*) as done"," where userid = ".$_POST['userid']." and client_id = $this->userid and task_statues = 'done' " , "row" , 
                    "" , "" , "");

                if (isset($temp_task) && count($temp_task) && !empty($temp_task) ) {

                    array_push($this->data["task_count"], $temp_task);

                }

                // 2- Count Waiting tasks
                $temp_task = $this->tasks_m->get_tasks("count(*) as waiting"," where userid = ".$_POST['userid']." and client_id = $this->userid and task_statues = 'waiting' " , "row" , 
                    "" , "" , "");

                if (isset($temp_task) && count($temp_task) && !empty($temp_task) ) {

                    array_push($this->data["task_count"], $temp_task);

                }

                // 3- Count In Process tasks
                $temp_task = $this->tasks_m->get_tasks("count(*) as in_process"," where userid = ".$_POST['userid']." and client_id = $this->userid and task_statues = 'in_process' " , "row" , 
                    "" , "" , "");

                if (isset($temp_task) && count($temp_task) && !empty($temp_task) ) {

                    array_push($this->data["task_count"], $temp_task);

                }


                // 4- Count Testing tasks
                $temp_task = $this->tasks_m->get_tasks("count(*) as testing"," where userid = ".$_POST['userid']." and client_id = $this->userid and task_statues = 'testing' " , "row" , 
                    "" , "" , "");

                if (isset($temp_task) && count($temp_task) && !empty($temp_task) ) {

                    array_push($this->data["task_count"], $temp_task);

                }
            
            // ./get user tasks's status count 
            
            
        }
        //dump($this->data["selected_user"]);
        
        // get all user for all tasks to this client
            
            $temp_task = $this->tasks_m->get_tasks("*"," where tasks.client_id = $this->userid " , "result" , 
                "" , " inner join users on tasks.userid = users.userid ");
            
            if (is_array($temp_task) && isset($temp_task) && count($temp_task) && !empty($temp_task) ) {
                
                $this->data["users_tasks"] = $temp_task;
                
            }
            
        // ./get all user for all tasks to this client
        
        //dump($this->data["users_tasks"]);
            
            
        // load view of tasks activities

        $this->data['subview'] = $this->load->view('customer/subviews/tasks/tasks_activities', $this->data, true);
        $this->load->view('customer/main_layout', $this->data);

        // ./load view of tasks activities
        
    }
    
}
