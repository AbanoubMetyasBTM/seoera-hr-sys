<?php

class tasks extends high_admin_controller{
    
    public function __construct() {
        parent::__construct();
        
        $this->load->model("tasks_m");

    }
    
    
    public function index($userid=null) 
    {
        $this->data["uesrs_data"]=$this->users_m->get_users($cols="*" ,"where user_type!='customer' " ,"result" ,"");
        
        if ($userid==null||!($userid>0)) {
            $userid=$this->userid;
        }
        
        $this->data["user_data"]=$this->users_m->get($userid);

            
            
        $this->data["tasks"] = $this->tasks_m->get_tasks("*"," where tasks.userid = $userid " , "result" , 
            " order by  tasks.task_priority asc " , " inner join users on tasks.client_id = users.userid ");

        $this->data["tasks_ids"]=  convert_inside_obj_to_arr($this->data["tasks"], "task_id");
            
            
        
        // load view of tasks

        $this->data['subview'] = $this->load->view('high_admin/subviews/tasks/tasks', $this->data, true);
        $this->load->view('high_admin/main_layout', $this->data);

        // ./load view of tasks
        
    }
    
    
    public function reorder_tasks() {
        
        $tasks_obj=  $this->input->post("tasks_items");
        $output=array();
        
        if (is_array($tasks_obj)&&  count($tasks_obj)) {
            foreach ($tasks_obj as $key => $value) {
                $task_id=$value[0];
                $task_order=$value[1];

                $returned_id=$this->tasks_m->save(array(
                    "task_priority"=>$task_order
                ),$task_id);

                if (!($returned_id>0)) {
                    $output["error"]="error";
                    echo json_encode($output);
                    return;
                }

            }
            $output["success"]="success";
        }
        else{
            $output["error"]="bad array";
        }
        
        
        
        echo json_encode($output);
    }
    
    public function save_task($task_id=null) {
        
        $this->data["task_data"] = "";
        
        $this->data["team_members"]=$this->users_m->get_users($cols="*" ,"where user_type!='customer' " ,"result" ,"");
        
        $this->data["team_members_ids"]=  convert_inside_obj_to_arr($this->data["team_members"], "userid");
        $this->data["team_members_emails"]=  convert_inside_obj_to_arr($this->data["team_members"], "email");
        
        
        $this->data["customers"]=$this->users_m->get_by(array(
            "user_type"=>"customer"
        ));
        
        $this->data["customers_ids"]=  convert_inside_obj_to_arr($this->data["customers"], "userid");
        $this->data["customers_emails"]=  convert_inside_obj_to_arr($this->data["customers"], "email");
       
        
        
        if ($task_id != null) {
            $this->data["task_data"] = $this->tasks_m->get($task_id);
        }

        $validation_rules = validation_array_generator(array(
            "client_id", "userid", "task_title", "task_desc",
            "task_statues","task_start_date"
        ));
        

        $this->load->library("form_validation");
        $this->form_validation->set_rules($validation_rules);

        if ($this->form_validation->run()) {
            $inputs_arr = $this->tasks_m->array_from_post(array(
                "client_id", "userid", "task_title", "task_desc",
                "task_statues","task_start_date"
            ));


            if ($task_id == null) {
                $returned_task_id = $this->tasks_m->save($inputs_arr);
            }             else {
                $returned_task_id = $this->tasks_m->save($inputs_arr, $task_id);
            }


            if ($returned_task_id > 0) {
                $this->data["success"] = '<div class="alert alert-success">
                <strong>Done!</strong>. 
                </div>';
            }
        


        } else {
            $validation_errors = validation_errors();
            if (!empty($validation_errors)) {
                $this->data["dump"] = '<div class="alert alert-danger">
                <strong>You have Break some rules!</strong>.
                ' . validation_errors() . '
                </div>'; 
            }
        }


        $this->data["subview"] = $this->load->view("high_admin/subviews/tasks/save", $this->data, true);
        $this->load->view("high_admin/main_layout", $this->data);
    }

    public function remove_task() {
        $output = array();
        $item_id = xss_clean($this->input->post("item_id"));

        if ($item_id > 0) {
            $this->tasks_m->delete($item_id);
            $output = array();
            if (count($this->tasks_m->get($item_id)) == 0) {
                $output["deleted"] = "yes";
            }
        }

        echo json_encode($output);
    }
    
}


