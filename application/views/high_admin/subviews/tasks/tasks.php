<style>
    
    .task_table > tbody > tr > td{
        text-align: center;
    
    .task_header{
        text-align: center;
    }
    
    
</style>


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


<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="col-md-6">
            <div class="form-group">
                <?php if (isset($uesrs_data)&&count($uesrs_data)&&is_array($uesrs_data)): ?>
                    <select class="form-control" name="select_user" id="select_user_id">
                        <?php foreach ($uesrs_data as $key => $single_user): ?>
                            <?php 
                                $selected=""; 
                                if (isset($user_data)&&$user_data->userid==$single_user->userid) {
                                    $selected="selected";
                                }
                            ?>
                            <option value="<?=$single_user->userid?>" <?=$selected?> ><?=$single_user->username?></option>
                        <?php endforeach ?>
                    </select>
                <?php else: ?>
                    <p>Please create users</p>
                <?php endif ?>
            </div>
        </div>
        <div class="col-md-6">
            <button class="btn btn-info btn-block" id="get_tasks_btn">Get Tasks</button>
        </div>
    </div>

    <div class="col-md-12" style="margin-top: 15px;margin-bottom: 15px">
        
        <h1>User "<?=$user_data->username?>" Tasks</h1>

        <table id="tasks" class="table table-striped table-responsive table-hover table-bordered task_table" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Client Name</th>
                    <th>Task Title</th>
                    <th>Task Status</th>
                    <th>Task Priority</th>
                    <th>Note by Client</th>
                    <th>Start Date</th>
                    <th>Full Details</th>
                    <th>Edit</th>
                    <th>Remove</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>#</th>
                    <th>Client Name</th>
                    <th>Task Title</th>
                    <th>Task Status</th>
                    <th>Task Priority</th>
                    <th>Note by Client</th>
                    <th>Start Date</th>
                    <th>Full Details</th>
                    <th>Edit</th>
                    <th>Remove</th>
                </tr>
            </tfoot>
            <tbody id="sortable">

                <?php if (isset($tasks)&&is_array($tasks)&&count($tasks)): ?>

                    <?php foreach ($tasks as $key => $task): ?>
                        
                        <tr id="row<?=$task->task_id?>" data-taskid="<?=$task->task_id?>">
                            <td><?= $key + 1; ?> </td>
                            <td><?= $task->username; ?></td>
                            <td><?= $task->task_title; ?></td>
                            <!--<td><?= mb_substr($task->task_desc,0,25, "utf-8"); ?></td>-->
                            <td><div class="badge"><?= $task->task_statues; ?></div></td>
                            <td><?= $task->task_priority; ?></td>
                            <td><?= mb_substr($task->task_note_by_client,0,25, "utf-8"); ?></td>
                            <td><?= $task->task_start_date; ?></td>
                            <!--<td><?= $task->task_end_date; ?></td>-->
                            <td>
                                <a title="Show Task <?= $task->task_title ?>" class="show_task_modal" style="cursor:pointer" data-cols = "<?= htmlentities(json_encode($task), ENT_QUOTES , 'UTF-8') ?>" data-toggle="modal" data-target=".task_detail_md" id ="<?= $task->task_id ?>">
                                    <i class="fa fa-send fa-fw"></i>
                                </a>
                            </td>

                            <td>
                                <a href="<?=base_url('high_admin/tasks/save_task/'.$task->task_id.'')?>" title="Edit Task Note <?= $task->task_title ?>"  id ="<?= $task->task_id ?>">
                                    <i class="fa fa-edit fa-fw"></i>
                                </a>
                            </td>
                            <td>
                                <a href='#' class="remove_item" data-deleteurl="<?=base_url("high_admin/tasks/remove_task")?>" data-itemid="<?=$task->task_id?>"><i class="fa fa-remove fa-fw"></i></a>
                            </td>

                            
                            

                            
                        </tr>

                    <?php endforeach ?>
                <?php else: ?>
                    <div class="alert alert-info"> There isn't tasks assigned to this user until now keep following...  </div>
                <?php endif ?>
              
            </tbody>
        </table>

    </div>
    <!-- END col-md-12 -->
    
    <div class="col-md-6 col-md-offset-3">
        <button class="btn btn-primary btn-block reorder_tasks">Reorder Tasks</button>
    </div>

</div>
<!-- /.row -->
