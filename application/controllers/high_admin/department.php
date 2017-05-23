<?php

class department extends high_admin_controller{
    
    public function __construct() {
        parent::__construct();
    
        $this->load->model("departments_m");
    }
    
    public function show_all_departments() {
        $this->data["all_deps"] = $this->departments_m->get();


        $this->data["subview"] = $this->load->view("high_admin/subviews/departments/show", $this->data, true);
        $this->load->view("high_admin/main_layout", $this->data);
    }
    
    public function save_department($dep_id=null) {
        $this->data["dep_data"]="";

        if ($dep_id!=null) {
            $this->data["dep_data"]=$this->departments_m->get($dep_id);
        }

        $validation_rules=  validation_array_generator(array(
            "dep_name"
        ));

        $this->load->library("form_validation");
        $this->form_validation->set_rules($validation_rules);

        if ($this->form_validation->run()) {
            $inputs_arr=$this->departments_m->array_from_post(array("dep_name"));

            if ($dep_id==null) {
                $returned_dep_id=$this->departments_m->save($inputs_arr);
            }
            else{
                $returned_dep_id=$this->departments_m->save($inputs_arr,$dep_id);
            }


            if ($returned_dep_id>0) {
                $this->data["success"]='<div class="alert alert-success">
                <strong>Done!</strong>. 
                </div>';
            }


        }else{
            $validation_errors=validation_errors();
            if (!empty($validation_errors)) {
                $this->data["dump"]=  '<div class="alert alert-danger">
                <strong>You have Break some rules!</strong>.
                '.validation_errors().'
                </div>'; 
            }
        }

        

        
        $this->data["subview"]=$this->load->view("high_admin/subviews/departments/save",$this->data,true);
        $this->load->view("high_admin/main_layout",$this->data); 
    }
    
    public function remove_department() {
        $output=array();
        $item_id=xss_clean($this->input->post("item_id"));

        if ($item_id>0) {
            $this->departments_m->delete($item_id);
            $output=array();
            if (count($this->departments_m->get($item_id))==0) {
                $output["deleted"]="yes";
            }
        }
        
        echo json_encode($output);
    }
    
}

