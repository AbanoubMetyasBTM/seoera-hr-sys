<?php

class demands extends high_admin_controller{
    
    public function __construct() {
        parent::__construct();
        
        $this->load->model("delay_demand_m");
        $this->load->model("general_holiday_days_m");
        $this->load->model("holiday_demand_m");
    }
    
    #########################  holiday_demands
    
    public function holiday_demands($userid=null) {
        
        $this->data["uesrs_data"]=$this->users_m->get();
        
        if ($userid==null) {
            $this->data["all_holidays"] = $this->holiday_demand_m->get_holidays($col="*",$join=" as hd inner join users as u on u.userid=hd.userid ",$where="",$order=" order by created ");
        }
        else{
            $this->data["user_data"]=$this->users_m->get($userid);
            
            $this->data["all_holidays"] = $this->holiday_demand_m->get_holidays($col="*" , $join=" as hd inner join users as u on u.userid=hd.userid " , $where=" where u.userid=$userid ",$order=" order by created ");
        }
        

        $this->data["subview"] = $this->load->view("high_admin/subviews/holidays/demand_holiday/show_all_holiday_demands", $this->data, true);
        $this->load->view("high_admin/main_layout", $this->data);
    }      
    
    public function accept_holiday_demand() {
        $demand_holiday_id=  xss_clean($this->input->post("holiday_id"));
        
        if (!($demand_holiday_id>0)) {
            return;
        }
        
        $returned_id=$this->holiday_demand_m->save(array(
            "demand_accepted"=>"1"
        ),$demand_holiday_id);
        
        
        if ($returned_id>0) {
            echo '<a href="#" data-demandid="'.$demand_holiday_id.'" class="refuse_holiday_Demand"><i class="fa fa-thumbs-down"></i></a>';
        }
    }
    
    public function refuse_holiday_demand() {
        $demand_holiday_id=  xss_clean($this->input->post("holiday_id"));
        
        if (!($demand_holiday_id>0)) {
            return;
        }
        
        $returned_id=$this->holiday_demand_m->save(array(
            "demand_accepted"=>"0"
        ),$demand_holiday_id);
                
        
        if ($returned_id>0) {
            echo '<a href="#" data-demandid="'.$demand_holiday_id.'" class="accept_holiday_Demand"><i class="fa fa-thumbs-up"></i></a>';
        }
    }
    
    public function remove_holiday_demand() {
        $output = array();
        $item_id = xss_clean($this->input->post("item_id"));

        if ($item_id > 0) {
            $this->holiday_demand_m->delete($item_id);
            $output = array();
            if (count($this->holiday_demand_m->get($item_id)) == 0) {
                $output["deleted"] = "yes";
            }
        }

        echo json_encode($output);
    }
    
    ########################## END holiday_demands
    
    ######################### general_holidays
    
    public function general_holidays() {
        $this->data["all_general_holidays"] = $this->general_holiday_days_m->get();

        $this->data["subview"] = $this->load->view("high_admin/subviews/holidays/general_holiday/show", $this->data, true);
        $this->load->view("high_admin/main_layout", $this->data);
    }
    
    public function save_general_holiday($holiday_id=null) {
        $this->data["holiday_data"] = "";

        if ($holiday_id != null) {
            $this->data["holiday_data"] = $this->general_holiday_days_m->get($holiday_id);
        }


        $validation_rules = validation_array_generator(array(
            "holiday_title","holiday_date"
        ));


        $this->load->library("form_validation");
        $this->form_validation->set_rules($validation_rules);


        if ($this->form_validation->run()) {
            $inputs_arr = $this->general_holiday_days_m->array_from_post(array(
                "holiday_title","holiday_date"
            ));


            if ($holiday_id == null) {
                $returned_id = $this->general_holiday_days_m->save($inputs_arr);
            }             
            else {
                $returned_id = $this->general_holiday_days_m->save($inputs_arr, $holiday_id);
            }


            if ($returned_id > 0) {
                $this->data["success"] = '<div class="alert alert-success">
                <strong>Done!</strong>. 
                </div>';
                
                $this->data["holiday_data"] = $this->general_holiday_days_m->get($returned_id);
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


        $this->data["subview"] = $this->load->view("high_admin/subviews/holidays/general_holiday/save", $this->data, true);
        $this->load->view("high_admin/main_layout", $this->data);
    }

    public function remove_general_holiday() {
        $output = array();
        $item_id = xss_clean($this->input->post("item_id"));

        if ($item_id > 0) {
            $this->general_holiday_days_m->delete($item_id);
            $output = array();
            if (count($this->general_holiday_days_m->get($item_id)) == 0) {
                $output["deleted"] = "yes";
            }
        }


        echo json_encode($output);
    }
    
    ######################### END general_holidays
    
    ########################### delay_demands
    
    public function delay_demands($userid=null) {
        $this->data["uesrs_data"]=$this->users_m->get();

        if ($userid==null) {
            $this->data["all_delays"] = $this->delay_demand_m->get_permissions($col="*" , $join=" as dd inner join users as u on u.userid=dd.userid " , $where="" , $ordered = " order by created " , $method="result");
        }
        else{
            $this->data["all_delays"] = $this->delay_demand_m->get_permissions($col="*" , $join=" as dd inner join users as u on u.userid=dd.userid " , $where=" where u.userid=$userid " , $ordered = " order by created " , $method="result");
        }


        $this->data["subview"] = $this->load->view("high_admin/subviews/holidays/delays/show", $this->data, true);
        $this->load->view("high_admin/main_layout", $this->data);
    }
    
    public function accept_delay_demand() {
        $demand_delay_id=  xss_clean($this->input->post("delay_id"));
        
        if (!($demand_delay_id>0)) {
            return;
        }
        
        $returned_id=$this->delay_demand_m->save(array(
            "demand_accepted"=>"1"
        ),$demand_delay_id);
        
        if ($returned_id>0) {
            echo '<a href="#" data-demandid="'.$returned_id.'" class="refuse_delay_Demand"><i class="fa fa-thumbs-down"></i></a>';

        }
    }
    
    public function refuse_delay_demand() {
        $demand_delay_id=  xss_clean($this->input->post("delay_id"));
        
        if (!($demand_delay_id>0)) {
            return;
        }
        
        $returned_id=$this->delay_demand_m->save(array(
            "demand_accepted"=>"0"
        ),$demand_delay_id);
        
        if ($returned_id>0) {
            echo '<a href="#" data-demandid="'.$returned_id.'" class="accept_delay_Demand"><i class="fa fa-thumbs-up"></i></a>';
        }
    }
    
    public function remove_delay_demand() {
        $output = array();
        $item_id = xss_clean($this->input->post("item_id"));

        if ($item_id > 0) {
            $this->delay_demand_m->delete($item_id);
            $output = array();
            if (count($this->delay_demand_m->get($item_id)) == 0) {
                $output["deleted"] = "yes";
            }
        }


        echo json_encode($output);
    }
    
    ########################### END delay_demands

}