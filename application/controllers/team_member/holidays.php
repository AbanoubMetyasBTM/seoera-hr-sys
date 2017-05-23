<?php

class holidays extends team_member_controller{
    
    public function __construct() {
        parent::__construct();
        
        // load models
        $this->load->model("holiday_demand_m");
        $this->load->model("users_m");
        $this->load->model("general_holiday_days_m");
            
    }
    
    
    public function _check_valid_demand()
    {
        
        // Initialze Data
        
            $this->data["user"] = "";
            
            $this->data["general_holiday_days"] = "";
            
            $current_day_date = date("Y-m-d");
            $current_day = date("D",  strtotime(datetime_now()));
            
            $current_day_time = date("H:i:s");
            
            $this->data["work_time_cond"] = "";
            $this->data["holiday_cond"] = "";
            $this->data["general_holiday_cond"] = "";
            
            $this->data["high_admins"] = "";
            
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
        //$current_day_time = "17:00:00";
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
        
            $this->data["holidays"] = "";
            
            

        // ./Initialize Data
        
            
        // Get all Holidays to this user
            
            $temp_holidays = $this->holiday_demand_m->get_holidays("*" , "", " where userid = $this->userid " , " order by created desc " , "result");

            if (is_array($temp_holidays) && isset($temp_holidays) &&!empty($temp_holidays) && count($temp_holidays)) {

                $this->data["holidays"] = $temp_holidays;
                
                
            }
            
        // ./Get all Holidays to this user
            
        echo $this->_check_valid_demand();
        
            
        //dump($current_day_date);
        
        // load view of Holidays

        $this->data['subview'] = $this->load->view('team_member/subviews/holidays/holidays', $this->data, true);
        $this->load->view('team_member/main_layout', $this->data);

        // ./load view of Dashboard
    
        
    }
    
    public function demand_holiday() 
    {

        // Initialize Data

            $this->load->model("notifications_m");

        // ./Initialize Data
        
        
        echo $this->_check_valid_demand();
        
        if ($this->data["work_time_cond"] != "yes") {
            redirect(base_url("team_member/holidays"));
        }
        
        else if ($this->data["holiday_cond"] != "yes") {
            redirect(base_url("team_member/holidays"));
        }
        
        else if ($this->data["general_holiday_cond"] != "yes") {
            redirect(base_url("team_member/holidays"));
        }
        
        
        $target_date = $this->input->post('holiday_when');
        
        
        // Check if this user demand holiday in this day before or not
            
            
            if ($target_date != false ) {
                
                
                // Check that this user allowed to demand one only daily
                $my_temp_date = date("Y-m-d");
                $temp_check_valid = $this->holiday_demand_m->get_holidays("count(*) as num_row" , "", " where userid = $this->userid and date(created) = '$my_temp_date' " , "" , "row");
                
                
                if (intval($temp_check_valid->num_row) >= 1) {
                    $this->data["validation_errors"] = "You didn't have permission to demand holiday more than one in same day !!!!";
                }
                else{
                    
                    $temp_holidays = $this->holiday_demand_m->get_holidays("count(*) as num_row" , "", " where userid = $this->userid and holiday_when = '$target_date' " , "" , "row");

                    if (isset($temp_holidays) &&!empty($temp_holidays) && count($temp_holidays)) {

                        $this->data["holidays"] = $temp_holidays;

                    }

                    if ($this->data["holidays"]->num_row == "1") {
                        $this->data["validation_errors"] = "You have demand on this day before !!!";
                    }
                    else if ($target_date <= date("Y-m-d")) {
                        $this->data["validation_errors"] = "There isn't allowed to apply demand on current day or before !!";
                    }                
                    else{

                        // insert into holiday_demand

                        $this->holiday_demand_m->save(
                          array("userid"=>$this->userid,
                                "holiday_when"=>$target_date,
                                "created"=>  datetime_now(),
                                "demand_accepted"=>0
                                )
                        );
                        
                        foreach ($this->data["high_admins"] as $key => $value) {
                                
                            $notify = array(

                                "userid" => $value->userid,
                                "note_header" => "Holiday Demand",
                                "note_body" => "Member '".$this->data["user"]->username."' has demand a holiday on day '".$target_date."' ",
                                "note_date" => datetime_now()

                            );


                            $this->notifications_m->save($notify);

                        }

                        $this->data["validation_errors"] = "Your Demand submitted successfully wait response from admin ...";

                    }
                    
                }
                
                
                
            }
            
        
        // ./Check if this user demand holiday in this day before or not
        
        
        // load view of 

        $this->data['subview'] = $this->load->view('team_member/subviews/holidays/demand_holiday', $this->data, true);
        $this->load->view('team_member/main_layout', $this->data);

        // ./load view of 
    
        
    }
    
    
    public function holidays_chart()
    {
        
        // Initialize Data
        
            // load models

            $this->data["holidays"] = "";
            $this->data["holidays_accepted"] = 0;
            $this->data["holidays_not_accepted"] = 0;
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
            
            $temp_holidays = $this->holiday_demand_m->get_holidays("*", "" ," where MONTH(`holiday_when`) = $current_month and YEAR(`holiday_when`) =  $current_year and `userid` = $this->userid ", "" , "result" );
            
            if (is_array($temp_holidays) && isset($temp_holidays) && count($temp_holidays) && !empty($temp_holidays) ) {
                
                $this->data["holidays"] = $temp_holidays;
                
                foreach ($this->data["holidays"] as $key => $value) {
                    
                    if ($value->demand_accepted == 0) {
                        $this->data["holidays_not_accepted"] ++;
                    }
                    else if ($value->demand_accepted == 1) {
                        $this->data["holidays_accepted"] ++;
                    }
                    
                }
                
            
            }
            
//            dump(count($this->data["holidays"]));
//            dump($this->data["holidays_not_accepted"]);
//            dump($this->data["holidays_accepted"]);
            
            //dump($this->data["work"]);
            
            
        // ./get user data join with attachments
        
        
        
        // load view of worktime

        $this->data['subview'] = $this->load->view('team_member/subviews/holidays/holidays_chart', $this->data, true);
        $this->load->view('team_member/main_layout', $this->data);

        // ./load view of worktime
        
    }
    
}
