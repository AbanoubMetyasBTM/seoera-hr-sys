<?php

class dashboard extends team_member_controller{
    
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


            $this->data["user"] = "";
            $this->data["tasks"] = "";
            $this->data["working_activites"] = array();
            $this->data["task_count"] = array();
            
            $this->data["general_holiday_days"] = "";


        // ./Initialize Data
            
            
        // Get all general holidays
            
            $temp_general_holidays = $this->general_holiday_days_m->get_general_holidays("*" , "" , "" , "result");
            
            if (is_array($temp_general_holidays) && isset($temp_general_holidays) && !empty($temp_general_holidays) && count($temp_general_holidays)) {

                $this->data["general_holiday_days"] = $temp_general_holidays;
            }
            
        // ./Get all general holidays
        
        
        // get user data join with attachments , Department
            
            $temp_user = $this->users_m->get_users("*"," where user_obj.userid = $this->userid " , "row" ,"");
            
            if (isset($temp_user) && count($temp_user) && !empty($temp_user) ) {
                
                $this->data["user"] = $temp_user;
                
            }
            
            
        // ./get user data join with attachments , Department
            
            
        // get user last 10 tasks ordered in priority and start date
            
            $temp_task = $this->tasks_m->get_tasks("*"," where userid = $this->userid and task_statues != 'done' " , "result" ," order by task_start_date  desc , task_priority asc " , "" , " LIMIT 10 ");
            
            if (is_array($temp_task) && isset($temp_task) && count($temp_task) && !empty($temp_task) ) {
                
                $this->data["tasks"] = $temp_task;
                
            }
            //dump($this->data["tasks"]);
            
        // ./get user last 10 tasks ordered in priority and start date
            
            
        // get user working activies
            
            $work_temp = $this->work_times_m->get_cond("max(work_time) as max_work_time" , "where userid = $this->userid ", "row");
            if (isset($work_temp->max_work_time)) {
                
                $work_temp = explode(":", $work_temp->max_work_time);
                $work_temp = $work_temp[0]*60 + $work_temp[1];
                array_push($this->data["working_activites"], $work_temp);
                
            }
            else{
                
                array_push($this->data["working_activites"], "");
                
            }
            
            
            $late_temp = $this->work_times_m->get_cond("max(late_time) as max_late_time" , "where userid = $this->userid ", "row");
            if (isset($late_temp->max_late_time)) {
                
                $late_temp = explode(":", $late_temp->max_late_time);
                $late_temp = $late_temp[0]*60 + $late_temp[1];
                array_push($this->data["working_activites"], $late_temp);
                
            }
            else{
                
                array_push($this->data["working_activites"], "");
                
            }
            
            
            $over_temp = $this->work_times_m->get_cond("max(over_time) as max_over_time" , "where userid = $this->userid ", "row");
            if (isset($over_temp->max_over_time)) {
                
                $over_temp = explode(":", $over_temp->max_over_time);
                $over_temp = $over_temp[0]*60 + $over_temp[1];
                array_push($this->data["working_activites"], $over_temp);
                
            }
            else{
                
                array_push($this->data["working_activites"], "");
                
            }
            
            
            $min_check_temp = $this->work_times_m->get_cond("min(check_in) as min_check_in_time" , "where userid = $this->userid ", "row");
            if (isset($min_check_temp->min_check_in_time)) {
                
                $min_check_temp = explode(":", $min_check_temp->min_check_in_time);
                $min_check_temp = $min_check_temp[0]*60 + $min_check_temp[1];
                array_push($this->data["working_activites"], $min_check_temp);
                
            }
            else{
                
                array_push($this->data["working_activites"], "");
                
            }
            
            
        // ./get user working activies  
            
            
        // get user tasks's status count 
            
            // 1- Count Done tasks
            $temp_task = $this->tasks_m->get_tasks("count(*) as done"," where userid = $this->userid and task_statues = 'done' " , "row" , 
                "" , "" , "");
            
            if (isset($temp_task) && count($temp_task) && !empty($temp_task) ) {
                
                array_push($this->data["task_count"], $temp_task);
                
            }
            
            // 2- Count Waiting tasks
            $temp_task = $this->tasks_m->get_tasks("count(*) as waiting"," where userid = $this->userid and task_statues = 'waiting' " , "row" , 
                "" , "" , "");
            
            if (isset($temp_task) && count($temp_task) && !empty($temp_task) ) {
                
                array_push($this->data["task_count"], $temp_task);
                
            }
            
            // 3- Count In Process tasks
            $temp_task = $this->tasks_m->get_tasks("count(*) as in_process"," where userid = $this->userid and task_statues = 'in_process' " , "row" , 
                "" , "" , "");
            
            if (isset($temp_task) && count($temp_task) && !empty($temp_task) ) {
                
                array_push($this->data["task_count"], $temp_task);
                
            }
            
            
            // 3- Count Testing tasks
            $temp_task = $this->tasks_m->get_tasks("count(*) as testing"," where userid = $this->userid and task_statues = 'testing' " , "row" , 
                "" , "" , "");
            
            if (isset($temp_task) && count($temp_task) && !empty($temp_task) ) {
                
                array_push($this->data["task_count"], $temp_task);
                
            }
            
        // ./get user tasks's status count 
        
            //dump($this->data["task_count"][3]->testing);
        
        // load view of Dashboard

        $this->data['subview'] = $this->load->view('team_member/subviews/index', $this->data, true);
        $this->load->view('team_member/main_layout', $this->data);

        // ./load view of Dashboard
    
        
    }
    
    
    
    public function worktime() 
    {

        // Initialize Data
        
            // load models
            $this->load->model("work_times_m");


            $this->data["user"] = "";
            $this->data["work"] = "";
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
            
            $temp_work = $this->work_times_m->get_cond("*"," where MONTH(`day`) = $current_month and YEAR(`day`) =  $current_year and `userid` = $this->userid " , "result" ," order by day asc " );
            
            if (is_array($temp_work) && isset($temp_work) && count($temp_work) && !empty($temp_work) ) {
                
                $this->data["work"] = $temp_work;
                
            }
            
            
            //dump($this->data["work"]);
            
            
        // ./get user data join with attachments
        
            
        // get user data join with attachments
            
            
            $temp_user = $this->users_m->get_users("*"," where user_obj.userid = $this->userid " , "row" ,"");
            
            if (isset($temp_user) && count($temp_user) && !empty($temp_user) ) {
                
                $this->data["user"] = $temp_user;
                
            }
            
            
        // ./get user data join with attachments
            
        
        
        // load view of worktime

        $this->data['subview'] = $this->load->view('team_member/subviews/worktime', $this->data, true);
        $this->load->view('team_member/main_layout', $this->data);

        // ./load view of worktime
    
        
    }
    
}
