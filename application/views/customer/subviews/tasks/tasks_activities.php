<!-- FIRST ROW OF BLOCKS -->     
<div class="row">
    
    
    <!-- Working CHART BLOCK -->
    <div class="col-md-9">
        <div class="col-md-12 dash-unit" style="height: 435px" >
            <dtitle>Tasks Status Chart for Selected Employee </dtitle>
            <hr>
            
            <?php if (!empty($task_count)): ?>
            
                <input type="hidden" class="done" value="<?= intval($task_count[0]->done) ?>">
                <input type="hidden" class="waiting" value="<?= intval($task_count[1]->waiting) ?>">
                <input type="hidden" class="in_process" value="<?= intval($task_count[2]->in_process) ?>">
                <input type="hidden" class="testing" value="<?= intval($task_count[3]->testing) ?>">
                
                <div id="users_tasks_chart" style="width:100%;height: 375px"></div>
	       
            <?php endif ?>
            
            <?php if (empty($task_count)): ?>
            
                <div class="alert alert-info">Please Select Specific Employee if you have Tasks assigned before to him to show charts for his work with you ...</div>
	
            <?php endif ?>
            
            
        </div>
    
    </div>
    
    <!-- Dropdown Employees BLOCK -->
    <div class="col-md-3">
        <div class="dash-unit">
            <dtitle>Select Employee</dtitle>
            <hr>
            
            <?php if (!empty($users_tasks)): ?>
            
                <form action="<?= base_url('customer/tasks/tasks_activities') ?>" method="POST" style="text-align: center;">

                    <div class="form-group">

                        <?php
                            
                            $user_text = array();
                            $user_value = array();
                            $selected_id = array();
                            
                            foreach ($users_tasks as $key => $value) {
                                
                                if (!in_array($value->username, $user_text)) {
                                    array_push($user_text, $value->username);
                                }
                                
                                if (!in_array($value->userid, $user_value)) {
                                    array_push($user_value, $value->userid);
                                }
                                
                            }
                            
                            if (!empty($selected_user)) {
                                
                                array_push($selected_id, intval($selected_user));
                                
                            }
                            
                            
                            
                            echo generate_select_tags("userid","Select Employee Name : ",$user_text,$user_value,$selected_id,"form-control","");
                        ?>

                    </div>

                    <input type="hidden" class="csrf_input_class" name="<?=$this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>">

                    <br>

                    <button type="submit" name="submit" class="btn btn-primary"> Show Chart <i class="fa fa-dashboard"></i> </button>


                </form>
	
            <?php endif ?>
            
            
            <?php if (empty($users_tasks)): ?>
                <div class="alert alert-info"> There isn't tasks Found To you until now...  </div>
            <?php endif ?>
            
            
        </div>
    </div>
    
    
</div>