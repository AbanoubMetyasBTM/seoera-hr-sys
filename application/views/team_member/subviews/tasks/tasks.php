<style>
    
    .task_table > tbody > tr > td{
        
        text-align: center;
        
    }
    
    .task_header{
        
        text-align: center;
        
    }
    
    
</style>

<!-- Page Heading -->
<div class="row" style="background-color: #ccc">
    <div class="col-md-12">
        <h1 class="page-header">
            All Your Tasks 
        </h1>
        <ol class="breadcrumb">
            <li>
                <i class="fa fa-dashboard"></i>  <a href="<?=base_url('team_member/dashboard')?>"> Homepage </a>
            </li>
            <li class="active">
                <i class="fa fa-tasks"> Your Tasks </i> 
            </li>
        </ol>
    </div>
</div>
<!-- /.row -->

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


<div class="row" style="background-color: #eee;">
    <div class="col-md-12" style="margin-top: 15px;margin-bottom: 15px">

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
                    <th>Edit Note / Status</th>
                    <th>Full Details</th>
                    
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
                    <th>Edit Note / Status</th>
                    <th>Full Details</th>
                    
                </tr>
            </tfoot>
            <tbody>

                <?php if (!empty($tasks)): ?>

                    <?php foreach ($tasks as $key => $task): ?>
                        
                        <tr>
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
                                <a href="<?=base_url('team_member/tasks/edit_note_status/'.$task->task_id.'')?>" title="Edit Task Note <?= $task->task_title ?>"  id ="<?= $task->task_id ?>">
                                    <i class="fa fa-edit fa-fw"></i>
                                </a>
                            </td>
                            
                            <td>
                                
                                
                                <a title="Show Task <?= $task->task_title ?>" class="show_task_modal" style="cursor:pointer" data-cols = "<?= htmlentities(json_encode($task), ENT_QUOTES , 'UTF-8') ?>" data-toggle="modal" data-target=".task_detail_md" id ="<?= $task->task_id ?>">
                                    <i class="fa fa-send fa-fw"></i>
                                </a>
                                
                            </td>

                            
                        </tr>

                    <?php endforeach ?>

                <?php endif ?>


                <?php if (empty($tasks)): ?>

                    <div class="alert alert-info"> There isn't tasks assigned to you until now keep following...  </div>
                    
                <?php endif ?>
              
            </tbody>
        </table>

    </div>
</div>
<!-- /.row -->
