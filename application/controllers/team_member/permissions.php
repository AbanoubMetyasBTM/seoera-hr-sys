<?php

class permissions extends team_member_controller{
    
    public function __construct() {
        parent::__construct();
        
        // load models
        $this->load->model("holiday_demand_m");
        $this->load->model("users_m");
        $this->load->model("general_holiday_days_m");
        $this->load->model("delay_demand_m");
            
    }
    
    
    public function _check_valid_demand()
    {
        
        // Initialze Data
        
            $this->data["user"] = "";
            $this->data["high_admins"] = "";
            
            $this->data["general_holiday_days"] = "";
            
            $current_day_date = date("Y-m-d");
            $current_day = date("D",  strtotime(datetime_now()));
            
            $current_day_time = date("H:i:s");
            
            $this->data["work_time_cond"] = "";
            $this->data["holiday_cond"] = "";
            $this->data["general_holiday_cond"] = "";
            
        // ./Initialze Data
        
        // Get all General Holidays
            
            $temp_general_holidays = $this->general_holiday_days_m->get_general_holidays("*" , "" , "" , "result");
            
            if (is_array($temp_general_holidays) && isset($temp_general_holidays) && !empty($temp_general_holidays) && count($temp_general_holidays)) {

                $this->data["general_holiday_days"] = $temp_general_holidays;
                
                //dump($temp_general_holidays);
                $flag = false;
                foreach ($temp_general_holidays as $key => $value) {
                    
                    if ($value->holiday_date == $current_day_date) {
                        
                        $flag = true;
                        $this->data["general_holiday_cond"] = "Your Demand not valid in Official Holiday";
                        break;
                        
                    }
                    
                }
                if ($flag == false) {
                    $this->data["general_holiday_cond"] = "yes";
                }

            }
            else{
                
                $this->data["general_holiday_cond"] = "yes";
                
            }
            
        // ./Get all General Holidays
            
        //dump($current_day);
        //$current_day_time = "17:00:01";
        //$current_day = "Sat";
          
        // Get Current User Data
            
            $temp_user = $this->users_m->get_users("*" , " where userid = $this->userid " , "row" , "");

            if (isset($temp_user) &&!empty($temp_user) && count($temp_user)) {

                $this->data["user"] = $temp_user;
                
                // Check if this day in available working time for this user
                
                    if ($current_day_time >= $temp_user->start_work_time && $current_day_time <= $temp_user->end_work_time) {

                        $this->data["work_time_cond"] = "yes";

                    }
                    else{

                        $this->data["work_time_cond"] = "Please Demand in Working Time <br>";

                    }
                    
                // Check if this day in available working time for this user
            }
            
        // ./Get Current User Data  
            
        // Get All high_admin
            
            $temp_admin = $this->users_m->get_users("*" , " where user_type = 'high_admin' " , "result" , "");

            if (is_array($temp_admin) && isset($temp_admin) &&!empty($temp_admin) && count($temp_admin)) {

                $this->data["high_admins"] = $temp_admin;
                
            }
            
        // ./Get All high_admin
          //dump($this->data["high_admins"]);
            
        // Check if this day is holiday (fri | sat) or not
            
            if (($current_day != "Fri" && $current_day != "Sat")) {
                
                   $this->data["holiday_cond"] = "yes";

               }
               else{

                   $this->data["holiday_cond"] = "Your Demand not valid in Weekend Holiday <br>";

               }
            
        // ./Check if this day is holiday (fri | sat) or not
        
//            dump($this->data["work_time_cond"]);
//            dump($this->data["holiday_cond"]);
//            dump($this->data["general_holiday_cond"]);
        
    }

    public function index() 
    {


        // Initialize Data
        
            $this->data["permissions"] = "";
            
            

        // ./Initialize Data
        
            
        // Get all Holidays to this user
            
            $temp_permissions = $this->delay_demand_m->get_permissions("*" , "", " where userid = $this->userid " , " order by created desc " , "result");

            if (is_array($temp_permissions) && isset($temp_permissions) &&!empty($temp_permissions) && count($temp_permissions)) {

                $this->data["permissions"] = $temp_permissions;
                
                
            }
            
        // ./Get all Holidays to this user
            
        echo $this->_check_valid_demand();
        
            
        //dump($current_day_date);
        
        // load view of Holidays

        $this->data['subview'] = $this->load->view('team_member/subviews/permissions/permissions', $this->data, true);
        $this->load->view('team_member/main_layout', $this->data);

        // ./load view of Dashboard
    
        
    }
    
    public function demand_permission() 
    {

        // Initialize Data

            $this->load->model("notifications_m");
            
            $delay_value = 0;
            
        // ./Initialize Data
        
        
        echo $this->_check_valid_demand();
        
        if ($this->data["work_time_cond"] != "yes") {
            redirect(base_url("team_member/permissions"));
        }
        
        else if ($this->data["holiday_cond"] != "yes") {
            redirect(base_url("team_member/permissions"));
        }
        
        else if ($this->data["general_holiday_cond"] != "yes") {
            redirect(base_url("team_member/permissions"));
        }
        
        
        $target_delay = $this->input->post('delay_when');
        $delay_value = $this->input->post('delay_value');
        $target_date = $this->input->post('delay_demand_date');
        
        
        // Check if this user demand holiday in this day before or not
        
            if ($target_delay != false  && $target_date!= false ) {
                
                if ($delay_value <=0 ) {
                    $this->data["validation_errors"] = "You should apply delay in minutes more than 0 minutes !!!";
                }
                else
                {
                    
                    // Check that this user allowed to demand one only daily
                    $my_temp_date = date("Y-m-d");
                    $temp_check_valid = $this->delay_demand_m->get_permissions("count(*) as num_row" , "", " where userid = $this->userid and date(created) = '$my_temp_date' " , "" , "row");


                    if (intval($temp_check_valid->num_row) >= 1) {
                        $this->data["validation_errors"] = "You didn't have permission to demand permission more than one in same day !!!!";
                    }
                    else{

                        $temp_check_permission = $this->delay_demand_m->get_permissions("count(*) as num_row" , "", " where userid = $this->userid and delay_demand_date = '$target_date' " , "" , "row");

                        if (isset($temp_check_permission) &&!empty($temp_check_permission) && count($temp_check_permission)) {

                            $this->data["permission"] = $temp_check_permission;

                        }

                        if ($this->data["permission"]->num_row == "1") {

                            $this->data["validation_errors"] = "You have demand on this day before !!!";
                        }
                        else if ($target_date <= date("Y-m-d")) {
                            $this->data["validation_errors"] = "There isn't allowed to apply demand on current day or before !!";
                        }                
                        else{

                            // insert into holiday_demand

                            $this->delay_demand_m->save(
                              array("userid"=>$this->userid,
                                    "delay_when"=>$target_delay,
                                    "delay_value"=>$delay_value,
                                    "delay_demand_date"=>$target_date,
                                    "demand_accepted"=>0,
                                    "created"=>  datetime_now()

                                    )
                            );
                            
                            foreach ($this->data["high_admins"] as $key => $value) {
                                
                                $notify = array(

                                    "userid" => $value->userid,
                                    "note_header" => "Permission Demand",
                                    "note_body" => "Member '".$this->data["user"]->username."' has demand a Permission on day '".$target_date."' that request delay $delay_value minutes on $target_delay  ",
                                    "note_date" => datetime_now()

                                );

                                $this->notifications_m->save($notify);
                                
                            }
                            

                            $this->data["validation_errors"] = "Your Demand submitted successfully wait response from admin ...";

                        }

                    }
                    
                }
                
                
            }
            
        
        // ./Check if this user demand holiday in this day before or not
        
        
        // load view of 

        $this->data['subview'] = $this->load->view('team_member/subviews/permissions/demand_permission', $this->data, true);
        $this->load->view('team_member/main_layout', $this->data);

        // ./load view of 
    
        
    }
    
    
    public function permission_chart()
    {
        
        // Initialize Data
        
            // load models

            $this->data["permissions"] = "";
            $this->data["permissions_accepted"] = 0;
            $this->data["permissions_not_accepted"] = 0;
            $this->data["month_selected"] = "";
            $this->data["year_selected"] = "";
            $current_year = date("Y",  strtotime(datetime_now()));
            $current_month = date("n",  strtotime(datetime_now()));

        // ./Initialize Data
                        
            $temp_year = $this->input->post('select_year');
            $temp_month = $this->input->post('select_month');
            
            
        
            if ($temp_month == false) 
            {
                $this->data["month_selected"] = $current_month;
            }
            else{

                $current_month = $temp_month;
                $this->data["month_selected"] = $temp_month;

            }
            
            if ($temp_year == false) 
            {
                $this->data["year_selected"] = $current_year;
            }
            else{

                $current_year = $temp_year;
                $this->data["year_selected"] = $temp_year;

            }
        
            
        
        // get user data join with attachments
            
            $temp_holidays = $this->delay_demand_m->get_permissions("*", "" ," where MONTH(`delay_demand_date`) = $current_month and YEAR(`delay_demand_date`) =  $current_year and `userid` = $this->userid ", "" , "result" );
            
            if (is_array($temp_holidays) && isset($temp_holidays) && count($temp_holidays) && !empty($temp_holidays) ) {
                
                $this->data["permissions"] = $temp_holidays;
                
                foreach ($this->data["permissions"] as $key => $value) {
                    
                    if ($value->demand_accepted == 0) {
                        $this->data["permissions_not_accepted"] ++;
                    }
                    else if ($value->demand_accepted == 1) {
                        $this->data["permissions_accepted"] ++;
                    }
                    
                }
                
            
            }
            
//            dump(count($this->data["permissions"]));
//            dump($this->data["permissions_not_accepted"]);
//            dump($this->data["permissions_accepted"]);
            
            //dump($this->data["work"]);
            
            
        // ./get user data join with attachments
        
        
        
        // load view of worktime

        $this->data['subview'] = $this->load->view('team_member/subviews/permissions/permission_chart', $this->data, true);
        $this->load->view('team_member/main_layout', $this->data);

        // ./load view of worktime
        
    }
    
}
