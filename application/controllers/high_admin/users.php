<?php

class users extends high_admin_controller{
    
    public function __construct() {
        parent::__construct();
            
        $this->load->model("departments_m");
    }
    
    
    public function show_users($type="high_admin") {
        //get_users($cols ,  $where , $method , $ordered)
        $this->data["all_users"] = $this->users_m->get_users("*","where user_type='$type'","result","");
        
        if ($type=="high_admin") {
            $this->data["user_type"]="high_admin";
            $this->data["displayed_cols"] =array("email","username","tel","notes","dep_name");
        }
        if ($type=="team_member") {
            $this->data["user_type"]="team_member";
            $this->data["displayed_cols"] =array("email","username",
            "sallery", "tel", "hire_date", "notes",
            "fingerprint_id", "dep_name", "start_work_time", "end_work_time",
            "overtime_hour_ratio", "decrease_salary_time", "decrease_salary_value",
            "normal_holiday_days", "abnormal_holiday_days");
        }
        if ($type=="customer") {
            $this->data["user_type"]="customer";
            $this->data["displayed_cols"] =array("email","username","tel","notes","dep_name");
        }

        $this->data["subview"] = $this->load->view("high_admin/subviews/users/show", $this->data, true);
        $this->load->view("high_admin/main_layout", $this->data);
    }
    
    public function save_user($type="high_admin",$userid=null) {
        $this->data["user_type"]=$type;
        $this->data["user_data"] = "";
        
        $all_department=$this->departments_m->get();
        $this->data["all_departments_text"]=  convert_inside_obj_to_arr($all_department, "dep_name");
        $this->data["all_departments_val"]=  convert_inside_obj_to_arr($all_department, "dep_id");
        
        
        
        $old_user_img_id = 0;

        if ($userid != null) {
            $this->data["user_data"] = $this->users_m->get_users("*","where userid=$userid","row","");
            $old_user_img_id = $this->data["user_data"]->user_img_id;
        }
        
        $without_required=array("notes");
        
        if ($type=="high_admin") {
            $cols=array(
                "username","email", "password",
                "notes","department_id"
            );
            $cols_types=array(
                "text","email", "password",
                "textarea"
            );
        }
        
        if ($type=="team_member") {
            $cols=array(
                "username","email", "password",
                "sallery", "tel", "hire_date", "notes",
                "website", "country", "fingerprint_id",
                "department_id", "start_work_time", 
                "end_work_time", "overtime_hour_ratio",
                "decrease_salary_time", "decrease_salary_value",
                "normal_holiday_days", "abnormal_holiday_days"
            );
            $cols_types=array(
                "text","email", "password",
                "number", "text", "date", "textare",
                "text", "text", "text",
                "time", 
                "time", "number",
                "number", "number",
                "number", "number"
            );
            
            $without_required[]="tel";
            $without_required[]="hire_date";
            $without_required[]="website";
            $without_required[]="country";
        }
        if ($type=="customer") {
            $cols=array(
                "username","email", "password",
                "tel", "notes","website", 
                "country","department_id"
            );
            $cols_types=array(
                "text","email", "password",
                "text", "textarea","text", 
                "text"
            );
            
            $without_required[]="tel";
            $without_required[]="website";
            $without_required[]="country";
        }
        
        $this->data["cols"]=$cols;
        $this->data["col_types"]=$cols_types;

        
        
        if ($userid!=null) {
            $without_required[]="password";
        }
        $validation_rules = validation_array_generator($cols,array(""),$without_required);


        $this->load->library("form_validation");
        $this->form_validation->set_rules($validation_rules);


        if ($this->form_validation->run()) {
            $cols[]="user_img_filetitle";
            $cols[]="user_img_filealt";
            $cols[]="user_img_checkbox";
            
            $inputs_arr = $this->users_m->array_from_post($cols);


            //cat_img_id 
            $inputs_arr["user_img_id"] = $this->general_save_img(
                    $userid, "user_img_file", $inputs_arr["user_img_filetitle"]
                    , $inputs_arr["user_img_filealt"], $inputs_arr["user_img_checkbox"]
                    , "users", 0, 0, $old_user_img_id, $inputs_arr["user_img_filetitle"]
                    , $inputs_arr["user_img_filealt"]);

            $inputs_arr["user_type"]=$type;
            
            unset($inputs_arr["user_img_filetitle"]);
            unset($inputs_arr["user_img_filealt"]);
            unset($inputs_arr["user_img_checkbox"]);
            
            if ($inputs_arr["password"]!="") {
                $inputs_arr["password"]=$this->users_m->hash($inputs_arr["password"]);
            }else{
                unset($inputs_arr["password"]);
            }
            
            

            if ($userid == null) {
                $returned_user_id = $this->users_m->save($inputs_arr);
            }             else {
                $returned_user_id = $this->users_m->save($inputs_arr, $userid);
            }


            if ($returned_user_id > 0) {
                $this->data["success"] = '<div class="alert alert-success">
                <strong>Done!</strong>. 
                </div>';
                $this->data["user_data"] = $this->users_m->get_users("*","where userid=$returned_user_id","row","");
                $old_user_img_id = $this->data["user_data"]->user_img_id;
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


        $this->data["subview"] = $this->load->view("high_admin/subviews/users/save", $this->data, true);
        $this->load->view("high_admin/main_layout", $this->data);

    }


    public function show_user_statistics($userid=null) {
        if ($userid==null) {
            return;
        }
    }
    
    
    public function remove_user() {
        $output = array();
        $item_id = xss_clean($this->input->post("item_id"));

        if ($item_id > 0) {
            $this->users_m->delete($item_id);
            $output = array();
            if (count($this->users_m->get($item_id)) == 0) {
                $output["deleted"] = "yes";
            }
        }

        echo json_encode($output);
    }
    
    
}
