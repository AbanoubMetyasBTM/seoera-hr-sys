<?php

class dashboard extends high_admin_controller{
    
    public function __construct() {
        parent::__construct();
        
        $this->load->model("work_times_m");
        
        $this->load->model("notifications_m");
        $this->data["notifications"]=$this->notifications_m->get_by(array(
            "userid"=>$this->userid
        ));
        
    }
    
    public function logout()
    {
        $this->users_m->logout();
        redirect(base_url());
    }
    
    public function index() {
        $this->load->model("tasks_m");
        
        $year_selected=date("Y",strtotime(datetime_now()));
        $month_selected=date("n",strtotime(datetime_now()));
        if ($month_selected==1) {
            $year_selected=$year_selected-1;
            $month_selected=12;
        }
        else{
            $month_selected--;
        }
        
        
        $this->data["team_members"]=$this->users_m->get_by(array(
            "user_type"=>"team_member"
        ));
        
        $this->data["customers"]=$this->users_m->get_by(array(
            "user_type"=>"customer"
        ));
        
        
        $this->data["un_done_tasks"]=$this->tasks_m->get_tasks("*" ," where MONTH(task_start_date)=$month_selected AND YEAR(task_start_date)=$year_selected AND task_statues!='done' " ,"result" , " order by  task_priority asc " , $join = "" , $limit = "");
        $this->data["done_tasks"]=$this->tasks_m->get_tasks("*" ," where MONTH(task_start_date)=$month_selected AND YEAR(task_start_date)=$year_selected AND task_statues='done' " ,"result" , " order by task_priority asc " , $join = "" , $limit = "");

        
        $this->data["user_un_done_tasks"] = $this->tasks_m->get_tasks("*"," where userid = $this->userid and task_statues != 'done' " , "result" ," order by task_start_date  desc , task_priority asc " , "" , "");

        $this->data["most_5_gain_overtime"]=$this->work_times_m->get_cond_inner_join_users("wt.*,u.*,(select max(over_time) from work_times where userid=u.userid) as 'max_over_time'" ," group by u.userid  having MONTH(day)=$month_selected AND YEAR(day)=$year_selected ", "result" ,"order by over_time desc",/*LIMIT 5*/"");
        
        $this->data["most_5_gain_latetime"]=$this->work_times_m->get_cond_inner_join_users("wt.*,u.*,(select max(late_time) from work_times where userid=u.userid) as 'max_late_time'" ," group by u.userid  having MONTH(day)=$month_selected AND YEAR(day)=$year_selected ", "result" ,"order by late_time desc",/*LIMIT 5*/"");
        
        $this->data["most_5_done_tasks"]=  $this->tasks_m->get_tasks($cols="t.*,count(t.task_id) as 'max_done_tasks' ",$where= " as t group by userid having task_statues = 'done' AND YEAR(task_end_date)=$year_selected " , "result" ,$ordered="order by max_done_tasks desc" , $join = "" , /*LIMIT 5*/$limit = "");
        
        
        // get user tasks's status count 
            $this->data["task_count"]=array();
            // 1- Count Done tasks
            $temp_task = $this->tasks_m->get_tasks("count(*) as done"," where userid = ".$this->userid." and task_statues = 'done' " , "row" , 
                "" , "" , "");

            if (isset($temp_task) && count($temp_task) && !empty($temp_task) ) {

                array_push($this->data["task_count"], $temp_task);

            }

            // 2- Count Waiting tasks
            $temp_task = $this->tasks_m->get_tasks("count(*) as waiting"," where userid = ".$this->userid." and task_statues = 'waiting' " , "row" , 
                "" , "" , "");

            if (isset($temp_task) && count($temp_task) && !empty($temp_task) ) {

                array_push($this->data["task_count"], $temp_task);

            }

            // 3- Count In Process tasks
            $temp_task = $this->tasks_m->get_tasks("count(*) as in_process"," where userid = ".$this->userid." and task_statues = 'in_process' " , "row" , 
                "" , "" , "");

            if (isset($temp_task) && count($temp_task) && !empty($temp_task) ) {

                array_push($this->data["task_count"], $temp_task);

            }


            // 4- Count Testing tasks
            $temp_task = $this->tasks_m->get_tasks("count(*) as testing"," where userid = ".$this->userid." and task_statues = 'testing' " , "row" , 
                "" , "" , "");

            if (isset($temp_task) && count($temp_task) && !empty($temp_task) ) {

                array_push($this->data["task_count"], $temp_task);

            }

        // ./get user tasks's status count
            
            
        //$this->user notification
        $this->load->model("notifications_m");
        $this->data["notifications"] = "";
        
        // Get all Notifications 
            
            $temp_notifications = $this->notifications_m->get_notifications($cols="*" ,  $where=" where userid = $this->userid" , $method="result" , $ordered=" order by note_date desc " , $join = "" , $limit = "");
            
            if (is_array($temp_notifications) && isset($temp_notifications) && count($temp_notifications) && !empty($temp_notifications) ) {
                
                $this->data["notifications"] = $temp_notifications;
                
            }
            //dump($this->data["notifications"]);
            
        // ./Get all Notifications 
        
        //END $this->user notification
            
            
        
        
        $this->data["subview"]=$this->load->view("high_admin/subviews/index",$this->data,true);
        $this->load->view("high_admin/main_layout",$this->data);
    }
    
    public function show_user_salary($userid=null,$month="",$year="") {
        
        $this->data["working_activites"]=array();
        $this->data["uesrs_data"]=$this->users_m->get_users($cols="*" ,  $where="" , $method="result" , $ordered="");

        if ($userid==null||$month==""||$year=="") {
            $this->data["year_selected"]=date("Y",strtotime(datetime_now()));
            $this->data["month_selected"]=date("n",strtotime(datetime_now()));
            
            $this->data["user_salary_data"]="";
            $this->data["work"] = "";
            
        }
        else
        {
            
            $this->data["year_selected"]=$year;
            $this->data["month_selected"]=$month;
            
            $this->data["user_data"]=$this->users_m->get_users($cols="*" ,  $where=" where user_obj.userid=$userid" , $method="row" , $ordered="");
            
            $general_check_of_work_temp=" AND MONTH(`day`) = $month AND YEAR(`day`) =  $year";
            
            
            $work_temp = $this->work_times_m->get_cond("max(work_time) as max_work_time" , "where userid = $userid $general_check_of_work_temp ", "row");
            if (isset($work_temp->max_work_time)) {
                $work_temp = explode(":", $work_temp->max_work_time);
                $work_temp = $work_temp[0]*60 + $work_temp[1];
                array_push($this->data["working_activites"], $work_temp);
            }
            else{
                array_push($this->data["working_activites"], "");
            }
            
            
            $late_temp = $this->work_times_m->get_cond("max(late_time) as max_late_time" , "where userid = $userid $general_check_of_work_temp ", "row");
            if (isset($late_temp->max_late_time)) {
                $late_temp = explode(":", $late_temp->max_late_time);
                $late_temp = $late_temp[0]*60 + $late_temp[1];
                array_push($this->data["working_activites"], $late_temp);
            }
            else{
                array_push($this->data["working_activites"], "");
            }
            
            $over_temp = $this->work_times_m->get_cond("max(over_time) as max_over_time" , "where userid = $userid $general_check_of_work_temp ", "row");
            if (isset($over_temp->max_over_time)) {
                $over_temp = explode(":", $over_temp->max_over_time);
                $over_temp = $over_temp[0]*60 + $over_temp[1];
                array_push($this->data["working_activites"], $over_temp);
            }
            else{
                array_push($this->data["working_activites"], "");
            }
            
            $min_check_temp = $this->work_times_m->get_cond("min(check_in) as min_check_in_time" , "where userid = $userid $general_check_of_work_temp ", "row");
            if (isset($min_check_temp->min_check_in_time)) {
                $min_check_temp = explode(":", $min_check_temp->min_check_in_time);
                $min_check_temp = $min_check_temp[0]*60 + $min_check_temp[1];
                array_push($this->data["working_activites"], $min_check_temp);
            }
            else{
                array_push($this->data["working_activites"], "");
            }
            
            
            
            
            
            
            
            $temp_work = $this->work_times_m->get_cond("*"," where MONTH(`day`) = $month and YEAR(`day`) =  $year and `userid` = $userid" , "result" ," order by day asc " );
            if (is_array($temp_work) && isset($temp_work) && count($temp_work) && !empty($temp_work) ) {
                $this->data["work"] = $temp_work;
            }
            else{
                $this->data["work"]=array();
            }
            
            
            
            $user_salary_data=$this->salary_calc($userid,$month,$year);
            $this->data["work_table"]=$user_salary_data[0];
            $this->data["absence"]=$user_salary_data[1];
            $this->data["overtime_days"]=$user_salary_data[2];
            $this->data["general_holidays"]=$user_salary_data[3];
            $this->data["demand_holidays"]=$user_salary_data[4];
            $this->data["delay_demands"]=$user_salary_data[5];
            
            // get user tasks's status count 
                $this->load->model("tasks_m");
                $this->data["task_count"]=array();
                // 1- Count Done tasks
                $temp_task = $this->tasks_m->get_tasks("count(*) as done"," where userid = ".$userid." and client_id = $this->userid and task_statues = 'done' " , "row" , 
                    "" , "" , "");

                if (isset($temp_task) && count($temp_task) && !empty($temp_task) ) {

                    array_push($this->data["task_count"], $temp_task);

                }

                // 2- Count Waiting tasks
                $temp_task = $this->tasks_m->get_tasks("count(*) as waiting"," where userid = ".$userid." and task_statues = 'waiting' " , "row" , 
                    "" , "" , "");

                if (isset($temp_task) && count($temp_task) && !empty($temp_task) ) {

                    array_push($this->data["task_count"], $temp_task);

                }

                // 3- Count In Process tasks
                $temp_task = $this->tasks_m->get_tasks("count(*) as in_process"," where userid = ".$userid." and task_statues = 'in_process' " , "row" , 
                    "" , "" , "");

                if (isset($temp_task) && count($temp_task) && !empty($temp_task) ) {

                    array_push($this->data["task_count"], $temp_task);

                }


                // 4- Count Testing tasks
                $temp_task = $this->tasks_m->get_tasks("count(*) as testing"," where userid = ".$userid." and task_statues = 'testing' " , "row" , 
                    "" , "" , "");

                if (isset($temp_task) && count($temp_task) && !empty($temp_task) ) {

                    array_push($this->data["task_count"], $temp_task);

                }
            
            // ./get user tasks's status count
            
            
            
            
        }
        
        
        $this->data["subview"]=$this->load->view("high_admin/subviews/users/show_team_member_salary",$this->data,true);
        $this->load->view("high_admin/main_layout",$this->data);
    }
    
    public function get_work_times_file($file_path="") {
        if ($file_path=="") {
            return;
        }
        
        $this->load->model("work_times_m");
        
        $formated_data=array();
        
//        $users_data=get_csv_content(base_url("public_html/all_data.csv"));
        $users_data=get_csv_content($file_path);
        //foreach for the day entries 
        //dump($users_data);
        
        foreach ($users_data as $user_key => $single_user) {
            //foreach for single employee
            //dump($single_user);
            foreach ($single_user as $day_key => $single_day) {
                $check_in_val="not_entered";
                $check_out_val="not_entered";
                $check_in=@$single_day["C/In"];                
                $check_out=@$single_day["C/Out"];
                
                if (is_array($single_day)&&count($single_day)==2
                        &&isset($check_in)&&  is_array($check_in)&&  count($check_in)==1
                        &&isset($check_out)&&  is_array($check_out)&&  count($check_out)==1
                    ) {
                    

                    if (
                            isset($check_in)&&is_array($check_in)&&count($check_in)==1
                            &&isset($check_out)&&is_array($check_out)&&count($check_out)==1
                        ) {
                        $check_in_val=$check_in[0]["time"];
                        $check_out_val=$check_out[0]["time"];
                    }
                }else if(is_array($single_day)&&count($single_day)){
                    
                    $check_in=@$single_day["C/In"];                
                    $check_out=@$single_day["C/Out"];
                    
//                    if ($day_key=="2016-01-14") {
//                        dump($single_day);
//                        dump($check_out);
//                        
//                        dump("checks");
//                        dump(isset($check_out));
//                        dump(is_array($check_out));
//                        dump((count($check_out)));
//                    }
                    
                    
                    if (isset($check_in)&&  is_array($check_in) &&count($check_in)) {
//                        if ($day_key=="2016-01-14") {
//                            dump("check in enter ".$day_key);
//                        }
                        
                        if (count($check_in)==1) {
                            $check_in_val=$check_in[0]["time"];
                        }
                        else if(count($check_in)>1){
                            usort($check_in, 'cmp_time_arr');
                            $check_in_val=$check_in[0]["time"];
                            
                        }
                    }
                    if (isset($check_out)&&  is_array($check_out) &&count($check_out)) {
//                        if ($day_key=="2016-01-14") {
//                            dump("check out enter ".$day_key);
//                        }
                        if (count($check_out)==1) {
                            $check_out_val=$check_out[0]["time"];
                        }
                        else if(count($check_out)>1){
                            usort($check_out, 'cmp_time_arr');
                            
                            $check_out_val=$check_out[(count($check_out)-1)]["time"];
                        }
                    }
                    
//                    if ($day_key=="2016-01-14") {
//                        dump("check_in_val".$check_in_val);
//                        dump("check_out_val".$check_out_val);
//                    }
                    
                    if (($check_in_val==null||$check_in_val==""||$check_in_val=="not_entered")&&  count($check_out)>1) {
                        //dump("double checkout " .$day_key." user"." $user_key");
                        $check_in_val=$check_out[0]["time"];
                    }
                    
                    if (($check_out_val==null||$check_out_val==""||$check_out_val=="not_entered")&&  count($check_in)>1) {
                        //dump("double checkin " .$day_key." user"." $user_key");
                        $check_out_val=$check_in[(count($check_in)-1)]["time"];
                    }

                    
                }
                
                $formated_row=array(
                    "user_id_in_csv"=>$user_key,
                    "date"=>$day_key,
                    "day_name"=>date("D",  strtotime($day_key)),
                    "check_in_val"=>$check_in_val,
                    "check_out_val"=>$check_out_val
                );
                $formated_data[]=$formated_row;
            }//end foreach 2
            
        }//end foreach 1
        
        //dump($formated_data);
        
        //dump($formated_data);
        foreach ($formated_data as $key => $row) {
            //get user id by user_id_in_csv
            
            
            $user=$this->users_m->get_by(array(
                "fingerprint_id"=>$row["user_id_in_csv"]
            ),true);
            $inserted_userid=0;
            if (isset($user)&&is_object($user)) {
                $inserted_userid=$user->userid;
            }
            else{
                continue;
            }
          
            $forget_check_in=0;
            $forget_check_out=0;

            
            
            
            if ($row["check_in_val"]=="not_entered") {
                //dump("not entered".$row["date"]);
                $row["check_in_val"]=$user->start_work_time;
                $forget_check_in=1;
            }
            
            if ($row["check_out_val"]=="not_entered") {
                //dump("not entered".$row["date"]);
                $row["check_out_val"]=$user->end_work_time;
                $forget_check_out=1;
            }
            
            //dump("user_id_in_csv".$row["user_id_in_csv"]);
            //check if $this day with this user is alredy exsist in db or not
            $work_time_rows=$this->work_times_m->get_by(array(
                "userid"=>$inserted_userid,
                "day"=>$row["date"]
            ));
            
            if (count($work_time_rows)) {
                continue;
            }
            else{
                //insert new row
                $check_in_time=date("H:i",  strtotime($row["check_in_val"]));
                $check_in_time=  explode(":", $check_in_time);
                $check_in_time=($check_in_time[0]*60*60)+($check_in_time[1]*60);

                
                $check_out_time=date("H:i",  strtotime($row["check_out_val"]));
                $check_out_time=  explode(":", $check_out_time);
                $check_out_time=($check_out_time[0]*60*60)+($check_out_time[1]*60);
                
                $all_work_time=$check_out_time-$check_in_time;
                $all_work_time=gmdate("H:i:s", $all_work_time);
                
                
                $user_start_work_time=  explode(":",$user->start_work_time);
                $user_end_work_time=  explode(":",$user->end_work_time);
                
                $user_start_work_time=($user_start_work_time[0]*60*60)+($user_start_work_time[1]*60);
                $user_end_work_time=($user_end_work_time[0]*60*60)+($user_end_work_time[1]*60);

                
                $late=0;
                $late_h=0;
                $late_i=0;
                
                $over=0;
                $over_h=0;
                $over_i=0;
                
                if ($check_in_time>=$user_start_work_time) {
                    $late+=$check_in_time-$user_start_work_time;
                    $late_h=  intval(gmdate("H", $late));
                    $late_i=  intval(gmdate("i", $late));
                    
                    //check if $inserted_userid has demand a request to late in morning
                    $this->load->model("delay_demand_m");
                    
                    $demand_morning_late=$this->delay_demand_m->get_by(array(
                        "userid"=>$inserted_userid,
                        "DAY(delay_demand_date)"=>date("d",  strtotime($row["date"])),
                        "MONTH(delay_demand_date)"=>date("n",  strtotime($row["date"])),
                        "YEAR(delay_demand_date)"=>date("Y",  strtotime($row["date"])),
                        "delay_when"=>"day",
                        "demand_accepted"=>"1"
                    ),true);
                    
                    
                    if (count($demand_morning_late)) {
                        $demand_morning_late_val=$demand_morning_late->delay_value*60;
                        if ($late>=$demand_morning_late_val) {
                            $late=$late-$demand_morning_late_val;
                        }
                        else if($late<$demand_morning_late_val)
                        {
                            $late=0;
                        }
                        
                    }
                    
                    
                }
                else if($check_in_time<$user_start_work_time){
                    
                    $over+=$user_start_work_time-$check_in_time;
                    $over_h=  intval(gmdate("H", $over));
                    $over_i=  intval(gmdate("i", $over));
                    
                    if ($over_i<15&&$over_h==0) {
                        $over=0;
                        $over_i=0;
                    }
                    
                }
                
                if ($check_out_time>=$user_end_work_time) {
                    $over+=$check_out_time-$user_end_work_time;
                    $over_h=  intval(gmdate("H", $over));
                    $over_i=  intval(gmdate("i", $over)); 
                    
                    if ($over_i<15&&$over_h==0) {
                        $over=0;
                    }
                    
                }else if($check_out_time<$user_end_work_time){
                    $late+=$user_end_work_time-$check_out_time;
                    
                    $demand_night_late=$this->delay_demand_m->get_by(array(
                        "userid"=>$inserted_userid,
                        "DAY(delay_demand_date)"=>date("d",  strtotime($row["date"])),
                        "MONTH(delay_demand_date)"=>date("n",  strtotime($row["date"])),
                        "YEAR(delay_demand_date)"=>date("Y",  strtotime($row["date"])),
                        "delay_when"=>"night",
                        "demand_accepted"=>"1"
                    ),true);
                    
                    if (count($demand_night_late)) {
                        $demand_night_late_val=$demand_night_late->delay_value*60;
                        if ($late>=$demand_night_late_val) {
                            $late=$late-$demand_night_late_val;
                        }
                        else if($late<$demand_night_late_val)
                        {
                            $late=0;
                        }
                        
                    }
                    
                }
                
                $over_h=  intval(gmdate("H", $over));
                $over_i=  intval(gmdate("i", $over)); 
                    
                $late_h=  intval(gmdate("H", $late));
                $late_i=  intval(gmdate("i", $late));
                
                $late_time="$late_h:$late_i";
                $over_time="$over_h:$over_i";
                
                $check_in_time=gmdate("H:i:s", $check_in_time);
                $check_out_time=gmdate("H:i:s", $check_out_time);

//                dump(array(
//                    "userid"=>$inserted_userid,
//                    "day"=>$row["date"],
//                    "check_in"=>$check_in_time,
//                    "check_out"=>$check_out_time,
//                    "work_time"=>$all_work_time,
//                    "late_time"=>$late_time,
//                    "over_time"=>$over_time
//                ));
                
                $returned_work_time_row=$this->work_times_m->save(array(
                    "userid"=>$inserted_userid,
                    "day"=>$row["date"],
                    "check_in"=>$check_in_time,
                    "check_out"=>$check_out_time,
                    "work_time"=>$all_work_time,
                    "late_time"=>$late_time,
                    "over_time"=>$over_time,
                    "forget_check_in"=>$forget_check_in,
                    "forget_check_out"=>$forget_check_out
                ));

                if (!($returned_work_time_row>0)) {
                    dump("error happened");
                }

            }//end else
            
        }//end foreach
        
        
        
        
    }//end func
    
    public function salary_calc($userid=null,$month="",$year="") {
        
        if ($userid==null) {
            return;
        }
        
        if ($month=="") {
            $month=date("n", strtotime(datetime_now()) );
        }
        
        if ($year=="") {
            $year=date("Y",strtotime(datetime_now()));
        }
        
        //get this $userid work table 
        $this->load->model("work_times_m");
        $work_table_days=$this->work_times_m->get_by(array(
            "userid"=>$userid,
            "MONTH(day)"=>$month,
            "YEAR(day)"=>$year
        ));
        
        //dump($work_table_days);
        $work_days=  convert_inside_obj_to_arr($work_table_days, "day");
        
        
        $all_days=cal_days_in_month(CAL_GREGORIAN,$month, $year);
        $this_month_days=array();
        
        if ($month<10) {
            $month="0$month";
        }
        
        for($i=1;$i<=$all_days;$i++){
            $typed_i=$i;
            if ($i<10) {
                $typed_i="0$i";
            }
            
            $this_month_days[]="$year-$month-$typed_i";
        }
        
        $this->load->model("general_holiday_days_m");
        
        $general_holidays=$this->general_holiday_days_m->get_by(array(
            "MONTH(holiday_date)"=>$month,
            "YEAR(holiday_date)"=>$year
        ));
        $general_holidays_days=  convert_inside_obj_to_arr($general_holidays,"holiday_date");
        
        $this->load->model("holiday_demand_m");
        $demand_holidays=$this->holiday_demand_m->get_by(array(
            "userid"=>$userid,
            "MONTH(holiday_when)"=>$month,
            "YEAR(holiday_when)"=>$year,
            "demand_accepted"=>"1"
        ));
        
        $demand_holidays_days=  convert_inside_obj_to_arr($demand_holidays, "holiday_when");
        
        $absence_days=array();
        //came in sat or fri or general holiday
        $overtime_days=array();
        
        //$days_in_details=array();
        
        foreach ($this_month_days as $day_key => $day_val) {
            $day_name=date("D",  strtotime($day_val));
            
            ///$days_in_details[$key]["day_name"]=$day_name;
            
            if (in_array($day_val, $work_days)&&($day_name=="Fri"||$day_name=="Sat"||in_array($day_val,$general_holidays_days))) {
                $overtime_days[]=$day_val;
                //$days_in_details[$key]["overtime_day"]=$overtime_days[$key];
            }  
            
            if (!in_array($day_val, $work_days)&&$day_name!="Fri"&&$day_name!="Sat"&&!in_array($day_val, $general_holidays_days)&&!in_array($day_val, $demand_holidays_days)) {
                $absence_days[]=$day_val;
                //$days_in_details[$key]["absence_day"]=$absence_days[$key];
            }
            
        }
        
        //dump(array($work_table_days,$absence_days,$overtime_days,$general_holidays,$demand_holidays));
        
        $this->load->model("delay_demand_m");
        $delay_demands=$this->delay_demand_m->get_by(array(
            "userid"=>$userid,
            "MONTH(delay_demand_date)"=>$month,
            "YEAR(delay_demand_date)"=>$year,
            "demand_accepted"=>"1"
        ));
        
        
        return array($work_table_days,$absence_days,$overtime_days,$general_holidays,$demand_holidays,$delay_demands);
    }//end func
    
    public function update_user_holidays() {
        $this->load->model("paid_to_member_m");
        
        $userid=  xss_clean($this->input->post("user_id"));
        $month=  xss_clean($this->input->post("month"));
        $year=  xss_clean($this->input->post("year"));
        
        $remain_of_normal_holidays_id=  xss_clean($this->input->post("remain_of_normal_holidays_id"));
        $remain_of_abnormal_holidays_id=  xss_clean($this->input->post("remain_of_abnormal_holidays_id"));
        
        $output=array();
        
        if (!($userid>0)) {
            echo json_encode($output);
            return;
        }
        
        //check if $user is pain in $month,$year
        $rows=$this->paid_to_member_m->get_by(array(
            "userid"=>"$userid",
            "month"=>"$month",
            "year"=>"$year"
        ));
        
        if (count($rows)) {
            $output["error"]="this user is paid before in this month";
            echo json_encode($output);
            return;
        }
        
        $returned_id=$this->users_m->save(array(
            "normal_holiday_days"=>$remain_of_normal_holidays_id,
            "abnormal_holiday_days"=>$remain_of_abnormal_holidays_id
        ),$userid);
        
        if ($returned_id>0) {
            $output["success"]="yes";
            
            $this->paid_to_member_m->save(array(
                "userid"=>"$userid",
                "month"=>"$month",
                "year"=>"$year"
            ));
        }
        
        echo json_encode($output);
    }
    
    public function upload_worktimes_file() {
        
        if (isset($_POST["submit"])&&count($_FILES)) {

            $file_path=cms_upload($this->userid,"worktimes_file","worktimes");
            if (count($file_path)&&  is_array($file_path)) {
                $file_path=$file_path[0];
                $this->get_work_times_file(base_url($file_path));


                $this->data["success"] = '<div class="alert alert-success">
                <strong>Done!</strong>. 
                </div>';
            }
            else{
                echo '<div class="alert alert-danger">
                <strong>You have Break some rules!</strong> PLS Upload File.
                </div>'; 
                return;
            }
            
            

        }

        $this->data["subview"]=$this->load->view("high_admin/subviews/upload_worktimes_file",$this->data,true);
        $this->load->view("high_admin/main_layout",$this->data); 

    }


    
}
