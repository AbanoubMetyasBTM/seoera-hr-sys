<?php

class tasks extends team_member_controller{
    
    public function __construct() {
        parent::__construct();
            
    }
    
    
    public function index() 
    {

        // Initialize Data
        
            // load models
            $this->load->model("tasks_m");
            

            $this->data["tasks"] = "";
            
        // ./Initialize Data
            
            
        // get user tasks ordered in priority and start date
            
            $temp_task = $this->tasks_m->get_tasks("*"," where tasks.userid = $this->userid " , "result" , 
                " order by tasks.task_priority asc " , " inner join users on tasks.client_id = users.userid ");
            
            if (is_array($temp_task) && isset($temp_task) && count($temp_task) && !empty($temp_task) ) {
                
                $this->data["tasks"] = $temp_task;
                
            }
            
        // ./get user tasks ordered in priority and start date
            
             
        
        // load view of tasks

        $this->data['subview'] = $this->load->view('team_member/subviews/tasks/tasks', $this->data, true);
        $this->load->view('team_member/main_layout', $this->data);

        // ./load view of tasks
    
        
    }
    
    public function _load_task_note_status($task_id) 
    {

        if ($task_id == null) {
            redirect(base_url("team_member/tasks"));
        }
                    
        // get user task ordered in priority and start date
            
            $temp_task = $this->tasks_m->get_tasks("*"," where task_id = $task_id and userid = $this->userid " , "row" , 
                " order by task_start_date  desc , task_priority asc " , "" , "");
            
            if (isset($temp_task) && count($temp_task) && !empty($temp_task) ) {
                
                $this->data["task"] = $temp_task;
                
            }
            else{
                
                redirect(base_url("team_member/tasks"));
                
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
                            
                array("task_statues" , "task_note_by_user" ),
                "",  
                array("task_statues" , "task_note_by_user"),
                array("Task Status","Task Note By User")

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
                    
                    $this->data["validation_errors"] = "The Task has been edited Successfully...";
                    
                    if (isset($post_data["task_note_by_user"]) && !empty($post_data["task_note_by_user"])) {
                        
                        $user_data = $this->users_m->get($this->userid);
                        $client_data = $this->users_m->get($this->data["task"]->client_id);
                        //dump($user_data);
                        
                        $flag = false;
                        
                        // Send Notification to all admins
                        foreach ($this->data["high_admins"] as $key => $value) {
                            
                            $notify = array(
                            
                                "userid" => $value->userid,
                                "note_header" => "Note from Member to Client",
                                "note_body" => "Member '".$user_data->username."' has send note to client '".$client_data->username."' "
                                . "and its body is '".$this->data["task"]->task_note_by_user."' ",
                                "note_date" => datetime_now()

                            );
                        
                            $this->notifications_m->save($notify);
                            
                            if ($value->userid == $this->data["task"]->client_id) {
                                $flag = true;
                            }
                            
                            
                        }
                        
                        
                        if ($flag == false) {
                            
                            // Send Notification to Client
                            $notify = array(

                                "userid" => $this->data["task"]->client_id,
                                "note_header" => "Note from Member to Client",
                                "note_body" => "Member '".$user_data->username."' has send note to client '".$client_data->username."' "
                                . "and its body is '".$this->data["task"]->task_note_by_user."' ",
                                "note_date" => datetime_now()

                            );

                            $this->notifications_m->save($notify);
                            
                        }
                        
                        
                        
                    }
                    
                }
                else{
                    redirect(base_url("team_member/tasks"));
                }
                
                
            }
            
            else{
                
                $this->data["validation_errors"] = validation_errors();
                
            }
        // ./validation rules   
        
        // load view of edit_note_status

        $this->data['subview'] = $this->load->view('team_member/subviews/tasks/edit_note_status', $this->data, true);
        $this->load->view('team_member/main_layout', $this->data);

        // ./load view of edit_note_status
    
        
    }
    
    
}
