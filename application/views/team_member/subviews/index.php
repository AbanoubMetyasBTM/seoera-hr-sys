<style>
    
    .profile > h3{
        
        text-align: left;
        
    }
    
</style>



<!-- FIRST ROW OF BLOCKS -->     
<div class="row">

    <!-- USER PROFILE BLOCK -->
    <div class="col-md-3">
        <div class="dash-unit profile" style="height: 360px">
            <dtitle>Team Member Profile</dtitle>
            <hr>
            <div class="thumbnail">
                <img src="<?= base_url($user->path) ?>" width="80px" height="80px" title="<?= $user->title ?>" alt="<?= $user->alt ?>" class="img-circle">
            </div><!-- /thumbnail -->
            <h1><?= $user->username ?></h1>
            
            <?php if (!empty($user->country)): ?>
                <h3><span aria-hidden="true" class="li_location fs1"></span> <?= $user->country ?></h3>
            <?php endif ?>
                
            <?php if (!empty($user->hire_date)): ?>
                <h3><span aria-hidden="true" class="li_tag fs1"></span> Start Work at <?= $user->hire_date ?></h3>
            <?php endif ?>
                
            <?php if (!empty($user->dep_name)): ?>
                <h3><span aria-hidden="true" class="li_data fs1"></span> Department of "<?= $user->dep_name ?>"</h3>
            <?php endif ?>
                
            <h3><a href="<?= base_url('team_member/dashboard/logout') ?>"> <span aria-hidden="true" class="li_lock fs1"></span> Log Out</a></h3>
            
            <br>
<!--            <div class="info-user">
                <span aria-hidden="true" class="li_user fs1"></span>
                <span aria-hidden="true" class="li_settings fs1"></span>
                <span aria-hidden="true" class="li_mail fs1"></span>
                <span aria-hidden="true" class="li_key fs1"></span>
            </div>-->
        </div>
    </div>

    <!-- Tasks CHART BLOCK -->
    <div class="col-md-5">
        <div class="col-md-12 dash-unit" style="height: 360px" >
            <dtitle>Tasks Chart</dtitle>
            <hr>
            <input type="hidden" class="done" value="<?= intval($task_count[0]->done) ?>">
            <input type="hidden" class="waiting" value="<?= intval($task_count[1]->waiting) ?>">
            <input type="hidden" class="in_process" value="<?= intval($task_count[2]->in_process) ?>">
            <input type="hidden" class="testing" value="<?= intval($task_count[3]->testing) ?>">
            <div id="tasks_chart" style="width:100%;height: 263px"></div>
            <br>
            <div class="text-right">
                <a href="<?= base_url('team_member/tasks') ?>">View Tasks Details <i class="fa fa-arrow-circle-right"></i></a>
            </div>
            
        </div>
    </div>


    <div class="col-md-4">

        
        <!-- All General Holidays BLOCK -->
        <div class="dash-unit" style="height: 360px" >
            <dtitle>Your Work Start From <span style="color:#b2c831;font-weight: bold;font-size: 18px;border-style: dashed;"><?= $user->start_work_time ?></span>  To <span style="color:#b2c831;font-weight: bold;font-size: 18px;border-style: dashed;"><?= $user->end_work_time ?></span> </dtitle>
            <hr>

            <div class="panel panel-default" style="margin-bottom: 0px;">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="fa fa-clock-o fa-fw"></i> Official Holidays </h3>
                </div>
                <div class="panel-body" style="overflow-y: scroll;height: 264px">
                    <div class="list-group">
                        
                        <?php if (!empty($general_holiday_days)): ?>
                            
                            <?php foreach ($general_holiday_days as $key => $value): ?>
                        
                                <a title="Show Task <?= $value->holiday_title ?>" class="list-group-item" style="cursor:pointer" >
                                    <span class="badge"><?= ($value->holiday_date)  ?></span>
                                    <i class="fa fa-fw fa-holidays"></i>
                                    <?= $value->holiday_title ?>
                                </a>
                        
                            <?php endforeach ?>
                        
                        <?php endif ?>
                        
                        <?php if (empty($general_holiday_days)): ?>
                            <div class="alert alert-info"> There Isn't General Holidays until now keep following... </div>
                        <?php endif ?>
                        
                        
                    </div>
                </div>
            </div>

        </div>
        
        

    </div>


</div><!-- /row -->


<!-- SECOND ROW OF BLOCKS -->
<div class="row">
    
    <!-- Count Of General Holidays (Normal , Abnormal) BLOCK -->
    <div class="col-md-offset-3 col-md-5">
        
        <div class="dash-unit" >

            <div class="row" style="padding: 14px;">
                <div class="col-md-6">
                    <span style="font-family: monospace; font-size: 20px;">Normal Rest : </span> 
                    <span style="color:#b2c831;font-weight: bold;font-size: 18px;">
                        <?= $user->normal_holiday_days ?>
                    </span>
                </div>

                <div class="col-md-6">
                    <span style="font-family: monospace; font-size: 20px;">Abnormal Rest : </span> 
                    <span style="color:#b2c831;font-weight: bold;font-size: 18px;">
                        <?= $user->abnormal_holiday_days ?>
                    </span>
                </div>
            </div>

        </div>
        
    </div>
    
</div>
        


<!-- Third ROW OF BLOCKS -->     
<div class="row">

    <!-- Working CHART BLOCK -->
    <div class="col-md-6">
        <div class="col-md-12 dash-unit" style="height: 471px" >
            <dtitle>Working Chart</dtitle>
            <hr>
            <input type="hidden" class="max_work_time" value="<?= intval($working_activites[0]) ?>">
            <input type="hidden" class="max_late_time" value="<?= intval($working_activites[1]) ?>">
            <input type="hidden" class="max_over_time" value="<?= intval($working_activites[2]) ?>">
            <input type="hidden" class="min_check_in_time" value="<?= intval($working_activites[3]) ?>">
            <div id="working_chart" style="width:100%;height: 375px"></div>
            
            <br>
            <div class="text-right">
                <a href="<?= base_url('team_member/dashboard/worktime') ?>">View Working Time Details <i class="fa fa-arrow-circle-right"></i></a>
            </div>
            
        </div>
        
    </div>


    <!-- Last 10 Tasks BLOCK -->
    <div class="col-md-6">
        <div class="col-md-12 dash-unit" style="height: 471px" >
            <dtitle>TOP 10 Tasks</dtitle>
            <hr>

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="fa fa-clock-o fa-fw"></i> Tasks Panel</h3>
                </div>
                <div class="panel-body" style="overflow-y: scroll;height: 326px">
                    <div class="list-group">
                        
                        <?php if (!empty($tasks)): ?>
                            
                            <?php foreach ($tasks as $key => $value): ?>
                        
                                <a title="Show Task <?= $value->task_title ?>" class="list-group-item show_task_modal" style="cursor:pointer" data-cols = "<?= htmlentities(json_encode($value), ENT_QUOTES , 'UTF-8') ?>" data-toggle="modal" data-target=".task_detail_md" id ="<?= $value->task_id ?>">
                                    <span class="badge"><?= get_time($value->task_start_date)  ?></span>
                                    <i class="fa fa-fw fa-tasks"></i> <?= $value->task_title ?>
                                </a>
                        
                            <?php endforeach ?>
                        
                        <?php endif ?>
                        
                        <?php if (empty($tasks)): ?>
                            <div class="alert alert-info"> There isn't tasks assigned to you until now keep following... </div>
                        <?php endif ?>
                        
                        
                    </div>
                    
                </div>
            </div>
            
            <div class="text-right">
                <a href="<?= base_url('team_member/tasks') ?>">View All Tasks <i class="fa fa-arrow-circle-right"></i></a>
            </div>

        </div>
    </div>


</div>

<!-- Load Modal for Task Details -->
<div class="modal fade task_detail_md" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title task_header" id="myModalLabel"></h4>

            </div>
            <div class="modal-body task_body">



            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <!--<button type="button" class="btn btn-primary">Save changes</button>-->
            </div>

      </div>
    </div>
</div>
<!-- ./Load Modal for Task Details -->

