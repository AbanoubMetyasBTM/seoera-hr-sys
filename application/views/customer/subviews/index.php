<style>
    
    .profile > h3{
        
        text-align: left;
        
    }
    
</style>



<!-- FIRST ROW OF BLOCKS -->     
<div class="row">

    <!-- USER PROFILE BLOCK -->
    <div class="col-md-3">
        <div class="dash-unit profile" style="height: 331px">
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
                <h3><span aria-hidden="true" class="li_tag fs1"></span> Join at <?= $user->hire_date ?></h3>
            <?php endif ?>
                
            <?php if (!empty($user->dep_name)): ?>
                <h3><span aria-hidden="true" class="li_data fs1"></span> Department of "<?= $user->dep_name ?>"</h3>
            <?php endif ?>
            
            <h3><a href="<?= base_url('customer/dashboard/logout') ?>"><span aria-hidden="true" class="li_lock fs1"></span> Log Out</a></h3>
            
            <br>
        </div>
    </div>
    
    <!-- Tasks CHART BLOCK -->
    <div class="col-md-5">
        <div class="col-md-12 dash-unit" style="height: 331px" >
            <dtitle>Tasks Chart</dtitle>
            <hr>
            <input type="hidden" class="done" value="<?= intval($task_count[0]->done) ?>">
            <input type="hidden" class="waiting" value="<?= intval($task_count[1]->waiting) ?>">
            <input type="hidden" class="in_process" value="<?= intval($task_count[2]->in_process) ?>">
            <input type="hidden" class="testing" value="<?= intval($task_count[3]->testing) ?>">
            <div id="tasks_chart" style="width:100%;height: 233px"></div>
            <br>
            <div class="text-right">
                <a href="<?= base_url('customer/tasks') ?>">View Tasks Details <i class="fa fa-arrow-circle-right"></i></a>
            </div>
            
        </div>
    </div>
    
    
    <!-- Last 5 Tasks BLOCK -->
    <div class="col-md-4">
        <div class="col-md-12 dash-unit" style="height: 331px" >
            <dtitle>TOP 5 Tasks</dtitle>
            <hr>

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="fa fa-clock-o fa-fw"></i> Tasks Panel</h3>
                </div>
                <div class="panel-body" style="overflow-y: scroll;height: 184px">
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
                <a href="<?= base_url('customer/tasks') ?>">View All Tasks <i class="fa fa-arrow-circle-right"></i></a>
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
            </div>

      </div>
    </div>
</div>
<!-- ./Load Modal for Task Details -->


<div class="row">
    
    <!-- Last 5 Tasks BLOCK -->
    <div class="col-md-offset-2 col-md-7">
        <div class="col-md-12 dash-unit" style="height: 356px" >
            <dtitle>Notifications</dtitle>
            <hr>

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="fa fa-bell fa-fw"></i> Notifications Panel</h3>
                </div>
                <div class="panel-body" style="overflow-y: scroll;height: 250px">
                    <div class="list-group">
                        
                        <?php if (!empty($notifications)): ?>
                            
                            <?php foreach ($notifications as $key => $value): ?>
                        
                                <a data-target="#notification_<?= $value->id ?>" aria-expanded="false" aria-controls="notification_<?= $value->id ?>" data-toggle="collapse" title="Show Notification '<?= $value->note_header ?>'" class="list-group-item" style="cursor:pointer" id="<?= $value->id ?>">
                                    <span class="badge"><?= get_time($value->note_date) ?></span>
                                    <i class="fa fa-fw fa-plus"></i> <?= $value->note_header ?>
                                </a>
                        
                                <div id="notification_<?= $value->id ?>" class="collapse">
                                    <div class="well" style="color: #000;">
                                        <?= $value->note_body ?>
                                    </div>
                                </div>
                                
                            <?php endforeach ?>
                        
                        <?php endif ?>
                        
                        <?php if (empty($notifications)): ?>
                            <div class="alert alert-info"> There Isn't Notifications to you until now keep following... </div>
                        <?php endif ?>
                        
                        
                    </div>
                    
                </div>
            </div>

        </div>
    </div>
    
</div>


