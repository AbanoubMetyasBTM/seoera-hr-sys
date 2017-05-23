
    <!-- Page Heading -->
    <div class="row" style="background-color: #ccc;">
        <div class="col-lg-12">
            
            <?php if (!empty($task)): ?>
            
                <h1 class="page-header">
                    
                    Edit Task "<?= $task->task_title ?>"
                    
                </h1>
	
            <?php endif ?>

            <ol class="breadcrumb">
                <li>
                    <i class="fa fa-dashboard"></i>  <a href="<?=base_url('customer/dashboard')?>">Homepage</a>
                </li>
                <li>
                    <i class="fa fa-tasks"></i>  <a href="<?=base_url('customer/tasks')?>"> All Tasks </a>
                </li>
                <li class="active">
                    <?php if (!empty($task)): ?>
                    
                        <i class="fa fa-leaf"> Edit Task "<?= $task->task_title ?></i>"

                    <?php endif ?>
                    
                </li>
            </ol>

        </div>
    </div>
    <!-- /.row -->
    
    


    <div class="row" >
        <div class="col-lg-12">
            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                
                <?php if (!empty($validation_errors)): ?>
                    <label class="alert alert-warning"><?= $validation_errors;  ?></label>
                <?php endif ?>

                <div class="panel panel-default" style="padding: 10px">

                    <br><br>

                    <?php

                        $mytask_id = "";
                        $task_id = "";
                        $task_statues = "";
                        $task_note_by_user = "";


                        //dump($task);
                        if (!empty($task)) {

                            $mytask_id = $task->task_id;
                            $task_id = "/".$task->task_id;
                            $task_statues = $task->task_statues;
                            $task_note_by_user = $task->task_note_by_client;


                        }


                        $labels = array("Task Note By Client");
                        $fields = array("task_note_by_client");
                        $required = array("");
                        $user_type = array("textarea");
                        $values = array("$task_note_by_user");
                        $class = array("form-control");



                    ?>

                    <form method="POST" action="<?=base_url('customer/tasks/edit_note_status'.$task_id)?>" name="task_form" class="task_form" enctype="multipart/form-data">

                        <div class="form-group form-group-md">

                            <div class="panel panel-primary">

                                <div class="panel-heading">Task Status and Note By Client</div>
                                <div class="panel-body">
                                    
                                    
                                    <?php
                                    
                                        $option_text = array("Waiting" , "In Process" , "Done" , "Testing");
                                        
                                        $option_value = array("waiting" , "in_process" , "done" , "testing");
                                        
                                        $task_statues = array($task_statues);
                                    
                                        echo generate_select_tags("task_statues","Task Status",$option_text,$option_value,$task_statues,$class="form-control","");

                                        echo generate_inputs_html($labels , $fields , $required , $user_type , $values , $class);

                                    ?>

                                </div>

                            </div>

                        </div>
                        <br><br>

                        <input type="hidden" class="csrf_input_class" name="<?=$this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>">

                        <br>
                        <a href="<?=base_url('customer/tasks')?>" type="button" class="btn btn-default" data-dismiss="modal"> Back <i class="glyphicon glyphicon-backward"></i></a>
                        <button type="submit" name="submit" class="btn btn-primary faq_data_submit"> Save <i class="glyphicon glyphicon-save"></i></button>


                    </form>

                </div>

            </div>
            
        </div>
    </div>

    


    


