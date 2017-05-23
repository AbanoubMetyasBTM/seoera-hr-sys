
    <!-- Page Heading -->
    <div class="row" style="background-color: #ccc;">
        <div class="col-lg-12">
            
            
                <h1 class="page-header">
                    
                    Demand Permission 
                    
                </h1>
	

            <ol class="breadcrumb">
                <li>
                    <i class="fa fa-dashboard"></i>  <a href="<?=base_url('team_member/dashboard')?>">Homepage</a>
                </li>
                <li>
                    <i class="fa fa-permissions"></i>  <a href="<?=base_url('team_member/permissions')?>"> All Permissions </a>
                </li>
                <li class="active">
                    
                    Demand Permission
                    
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

                        $labels = array("Delay Value in Minutes","Day of Permission Demand");
                        $fields = array("delay_value","delay_demand_date");
                        $required = array("required","required");
                        $user_type = array("number","date");
                        $values = array("0","");
                        $class = array("form-control","form-control");



                    ?>

                    <form method="POST" action="<?=base_url('team_member/permissions/demand_permission')?>" name="permission_form" class="permission_form" enctype="multipart/form-data">

                        <div class="form-group form-group-md">

                            <div class="panel panel-primary">

                                <div class="panel-heading">Day of Permission Demand</div>
                                <div class="panel-body">
                                    
                                    
                                    <?php
                                        
                                        echo generate_select_tags("delay_when","Delay on Day OR Night",array("Day","Night"),array("day","night"),array("day"),"form-control","");
                                        
                                        echo generate_inputs_html($labels , $fields , $required , $user_type , $values , $class);

                                    ?>

                                </div>

                            </div>
                            
                        </div>
                        <br><br>
                        
                        

                        <input type="hidden" class="csrf_input_class" name="<?=$this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>">

                        <br>
                        <a href="<?=base_url('team_member/permissions')?>" type="button" class="btn btn-default" data-dismiss="modal"> Back <i class="glyphicon glyphicon-backward"></i></a>
                        <button type="submit" name="submit" class="btn btn-primary"> Save <i class="glyphicon glyphicon-save"></i></button>


                    </form>

                </div>

            </div>
            
        </div>
    </div>

    


    



