<style>
    
    .permission_table > tbody > tr > td{
        
        text-align: center;
        
    }
    
    .permission_table > thead  > tr > th{
        
        text-align: center;
        
    }
    
    .permission_table > tfoot  > tr > th{
        
        text-align: center;
        
    }
    
    .tips > p{
        
        margin-left: 36px;
    }
    
</style>




<!-- Second ROW OF BLOCKS --> 
<!-- Page Heading -->
<div class="row" style="background-color: #ccc">
    <div class="col-md-12">
        <h1 class="page-header">
            All Your Permissions 
        </h1>
        <ol class="breadcrumb">
            <li>
                <i class="fa fa-dashboard"></i>  <a href="<?=base_url('team_member/dashboard')?>"> Homepage </a>
            </li>
            <li class="active">
                <i class="fa fa-permissions"> Your Permissions Demands </i> 
            </li>
        </ol>
    </div>
</div>
<!-- /.row -->


<div class="row" style="background-color: #eee;">
    <div class="col-md-12" style="margin-top: 15px;margin-bottom: 15px">

        <table id="permissions" class="table table-striped table-responsive table-hover table-bordered permission_table" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Permission Time</th>
                    <th>Delay Time (minutes)</th>
                    <th>Permission Demand Date</th>
                    <th>Demand Status</th>
                    <th>Request Date</th>
                    
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>#</th>
                    <th>Permission Time</th>
                    <th>Delay Time (minutes)</th>
                    <th>Permission Demand Date</th>
                    <th>Demand Status</th>
                    <th>Request Date</th>
                    
                </tr>
            </tfoot>
            <tbody>

                <?php if (!empty($permissions)): ?>

                    <?php foreach ($permissions as $key => $value): ?>
                        
                        <tr>
                            <td><?= $key + 1; ?> </td>
                            <td><?= $value->delay_when; ?></td>
                            <td><?= $value->delay_value; ?></td>
                            <td><?= $value->delay_demand_date; ?></td>
                            
                            <?php if ($value->demand_accepted == 0): ?>
                                <td><div class="badge">Not Accepted</div></td>
                            <?php endif ?>
                            
                            <?php if ($value->demand_accepted == 1): ?>
                                <td><div class="badge">Accepted</div></td>
                            <?php endif ?>
                            
                            <td><?= $value->created; ?></td>
                            
                        </tr>

                    <?php endforeach ?>

                <?php endif ?>


                <?php if (empty($permissions)): ?>

                    <div class="alert alert-info"> There isn't permissions you requested from Admin...  </div>
                    
                <?php endif ?>
              
            </tbody>
        </table>
        
    </div>
    
    <div class="col-md-5">
        
        <div class="alert alert-info tips" style="font-weight: bold;font-size: 12px">
            <h3 style="font-size: 30px;color:#000;"> ****** Important Tips ****** </h3>
            <h4 style="color:#b2c831">You Should :-</h4>
            <p>- Apply On your Working Time.</p>
            <br>
            <p>- Apply On From Sunday - Thursday.</p>
            <br>
            <p>- You have limit one to apply permission per day.</p>
            <br>
            
            <h4 style="color:#a94442">You Should not :-</h4>
            <p>- Apply on official holidays.</p>
            <br>
            <p>- Apply on Same day twice.</p>
            <br>
            <p>- Apply on current day or before.</p>
            <br>
            
        </div>
        
    </div>
    
    <div class="col-md-6 col-md-offset-1">
        <div class="well">
            <h4>
                <div class="alert alert-info">
                    Demand Permission To you :(
                </div>
            </h4>
            <?php
                $flag = true;
            ?>
            
            <?php if ($work_time_cond != "yes"): ?>
                <div class="alert alert-warning">
                    <?php
                        echo $work_time_cond;
                        $flag = false;
                    ?>
                </div>
            <?php endif ?>
            
            
            <?php if ($holiday_cond != "yes"): ?>
                <div class="alert alert-warning">
                    <?php
                        echo $holiday_cond;
                        $flag = false;
                    ?>
                </div>
            <?php endif ?>
            
            <?php if ($general_holiday_cond != "yes"): ?>
                <div class="alert alert-warning">
                    <?php
                        echo $general_holiday_cond;
                        $flag = false;
                    ?>
                </div>
            <?php endif ?>
            
            <?php if ($flag == true): ?>
            
                <a href="<?=base_url('team_member/permissions/demand_permission')?>" class="btn btn-default btn-lg btn-block">
                    Demand Permission
                </a>
	
            <?php endif ?>
            
            
        </div>
        <!-- /end well div -->
    </div>
    
</div>
<!-- /.row -->


