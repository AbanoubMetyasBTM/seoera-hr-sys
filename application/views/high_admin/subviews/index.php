<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>


<!-- Page Heading -->
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            Dashboard <small>Statistics Overview</small>
        </h1>
        <ol class="breadcrumb">
            <li class="active">
                <i class="fa fa-dashboard"></i> Dashboard
            </li>
        </ol>
    </div>
</div>
<!-- /.row -->


<div class="row">
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-users fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge"><?=count($team_members)?></div>
                        <div>Team Members!</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-green">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-users fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge"><?=count($customers)?></div>
                        <div>Customers!</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-red">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-tasks fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge"><?=count($un_done_tasks)?></div>
                        <div>Un Done Tasks!</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="panel panel-yellow">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-check fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge"><?=count($done_tasks)?></div>
                        <div>Done Tasks!</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- /.row -->

<!-- show user tasks -->
<div class="row">
    <!-- modal for tasks body -->
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
    <!-- Last 10 Tasks BLOCK -->
    <div class="col-md-6">
        <div class="col-md-12" >
            <h2>TOP 10 Tasks</h2>
            <hr>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="fa fa-clock-o fa-fw"></i> Tasks Panel</h3>
                </div>
                <div class="panel-body" style="height: 425px;overflow-y: scroll;">
                    <div class="list-group">
                        
                        <?php if (isset($user_un_done_tasks)&&is_array($user_un_done_tasks)&&count($user_un_done_tasks)): ?>
                            
                            <?php foreach ($user_un_done_tasks as $key => $value): ?>
                        
                                <a title="Show Task <?= $value->task_title ?>" class="list-group-item show_task_modal" style="cursor:pointer" data-cols = "<?= htmlentities(json_encode($value), ENT_QUOTES , 'UTF-8') ?>" data-toggle="modal" data-target=".task_detail_md" id ="<?= $value->task_id ?>">
                                    <span class="badge"><?= get_time($value->task_start_date)  ?></span>
                                    <i class="fa fa-fw fa-tasks"></i> <?= $value->task_title ?>
                                </a>
                        
                            <?php endforeach ?>
                        
                        <?php else: ?>`
                            <div class="alert alert-info"> There isn't tasks assigned to you until now keep following... </div>
                        <?php endif ?>
                        
                        
                    </div>
                    <div class="text-right">
                        <a href="<?= base_url('high_admin/tasks') ?>">View All Tasks <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                    
                </div>

            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="col-md-12">
            <h2>Tasks Chart</h2>
            <hr>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="fa fa-clock-o fa-fw"></i> Tasks Panel</h3>
                </div>
                <div class="panel-body">
                    <div class="list-group">
                        <?php if (!empty($task_count)): ?>
            
                            <input type="hidden" class="done" value="<?= intval($task_count[0]->done) ?>">
                            <input type="hidden" class="waiting" value="<?= intval($task_count[1]->waiting) ?>">
                            <input type="hidden" class="in_process" value="<?= intval($task_count[2]->in_process) ?>">
                            <input type="hidden" class="testing" value="<?= intval($task_count[3]->testing) ?>">
                            
                            <div id="users_tasks_chart_in_dashboard" style="width:100%;height: 375px"></div>
                       
                        <?php endif ?>
                        
                        <?php if (empty($task_count)): ?>
                            <div class="alert alert-info">Please Select Specific Employee if you have Tasks assigned before to him to show charts for his work with you ...</div>
                        <?php endif ?>
                    </div>
                </div>

            </div>
        </div>
    </div>    

</div>
<!-- END ROW show user tasks -->

<!-- Most Users overtime&latetime -->
<div class="row">
    <div class="col-md-12">
        <div class="col-md-12">
            <h2>Top 5 Users Gained Overtime</h2>
            <hr>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="fa fa-plus"></i> Overtime Chart</h3>
                </div>
                <div class="panel-body">
                    <div class="list-group">
                        <?php if (isset($most_5_gain_overtime)&&is_array($most_5_gain_overtime)&&count($most_5_gain_overtime)): ?>
                            <input type="hidden" class="top_5_gained_overtime_data" value="<?= htmlentities(json_encode($most_5_gain_overtime), ENT_QUOTES, 'UTF-8');  ?>">
                            <div id="top_5_gained_overtime_chart_id" style="width:100%;height: 375px"></div>
                        <?php else: ?>
                            <div class="alert alert-info">No Data.</div>
                        <?php endif ?>
                    </div>
                </div>
            </div>
        </div>
    </div>    

    
    <div class="col-md-12">
        <div class="col-md-12">
            <h2>Top 5 Users Make Latetime</h2>
            <hr>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="fa fa-minus"></i> Latetime Chart</h3>
                </div>
                <div class="panel-body">
                    <div class="list-group">
                        <?php if (isset($most_5_gain_latetime)&&is_array($most_5_gain_latetime)&&count($most_5_gain_latetime)): ?>
                            <input type="hidden" class="top_5_gained_latetime_data" value="<?= htmlentities(json_encode($most_5_gain_latetime), ENT_QUOTES, 'UTF-8');  ?>">
                            <div id="top_5_gained_latetime_chart_id" style="width:100%;height: 375px"></div>
                        <?php else: ?>
                            <div class="alert alert-info">No Data.</div>
                        <?php endif ?>
                    </div>
                </div>
            </div>
        </div>
    </div>   

</div>

<!-- END Most Users overtime&latetime -->

<!-- Users who made most tasks -->
<div class="row">
    <div class="col-md-12">
        <div class="col-md-12">
            <h2>Top 5 Users Who did Tasks</h2>
            <hr>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="fa fa-tasks"></i> Tasks Done Chart</h3>
                </div>
                <div class="panel-body">
                    <div class="list-group">
                        <?php if (isset($most_5_done_tasks)&&is_array($most_5_done_tasks)&&count($most_5_done_tasks)): ?>
                            <input type="hidden" class="most_5_done_tasks_data" value="<?= htmlentities(json_encode($most_5_done_tasks), ENT_QUOTES, 'UTF-8');  ?>">
                            <div id="most_5_done_tasks_id" style="width:100%;height: 375px"></div>
                        <?php else: ?>
                            <div class="alert alert-info">No Data.</div>
                        <?php endif ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- END Users who made most tasks -->


<!-- Notification -->
<div class="row">
    <div class="col-md-6 col-md-offset-3">
        
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
<!-- END Notification -->