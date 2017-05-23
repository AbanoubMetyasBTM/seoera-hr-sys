<style>
    
    .holiday_table > tbody > tr > td{
        
        text-align: center;
        
    }
    
    .holiday_table > thead  > tr > th{
        
        text-align: center;
        
    }
    
    .holiday_table > tfoot  > tr > th{
        
        text-align: center;
        
    }
    
    .tips > p{
        
        margin-left: 36px;
    }
    
</style>


<!-- FIRST ROW OF BLOCKS -->     
<div class="row">
    
    <!-- Working CHART BLOCK -->
<!--    <div class="col-md-9">
        <div class="col-md-12 dash-unit" >
            <dtitle>Holidays Chart</dtitle>
            <hr>
            <?php if (!empty($user)): ?>
                
                <input type="hidden" class = "start_work_time" name="start_work_time" value="<?= $user->start_work_time ?>">
                <input type="hidden" class = "end_work_time" name="end_work_time" value="<?= $user->end_work_time ?>">
            
            <?php endif ?>
            
            <div style="display: none" class="mywork_data" data-mywork="<?= htmlentities(json_encode($work), ENT_QUOTES , 'UTF-8')  ?>">
                    
            </div>
            <div id="worktime_chart" style="width:100%;height: 375px"></div>
        </div>
    </div>
    -->
    
    
    
    
    
</div>


<!-- Second ROW OF BLOCKS --> 
<!-- Page Heading -->
<div class="row" style="background-color: #ccc">
    <div class="col-md-12">
        <h1 class="page-header">
            All Your Holidays 
        </h1>
        <ol class="breadcrumb">
            <li>
                <i class="fa fa-dashboard"></i>  <a href="<?=base_url('team_member/dashboard')?>"> Homepage </a>
            </li>
            <li class="active">
                <i class="fa fa-holidays"> Your Holidays Demands </i> 
            </li>
        </ol>
    </div>
</div>
<!-- /.row -->


<div class="row" style="background-color: #eee;">
    <div class="col-md-12" style="margin-top: 15px;margin-bottom: 15px">

        <table id="holidays" class="table table-striped table-responsive table-hover table-bordered holiday_table" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Holiday Day</th>
                    <th>Demand Date</th>
                    <th>Demand Status</th>
                    
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>#</th>
                    <th>Holiday Day</th>
                    <th>Demand Date</th>
                    <th>Demand Status</th>
                    
                </tr>
            </tfoot>
            <tbody>

                <?php if (!empty($holidays)): ?>

                    <?php foreach ($holidays as $key => $value): ?>
                        
                        <tr>
                            <td><?= $key + 1; ?> </td>
                            <td><?= $value->holiday_when; ?></td>
                            <td><?= $value->created; ?></td>
                            
                            <?php if ($value->demand_accepted == 0): ?>
                                <td><div class="badge">Not Accepted</div></td>
                            <?php endif ?>
                            
                            <?php if ($value->demand_accepted == 1): ?>
                                <td><div class="badge">Accepted</div></td>
                            <?php endif ?>
                            

                            
                        </tr>

                    <?php endforeach ?>

                <?php endif ?>


                <?php if (empty($holidays)): ?>

                    <div class="alert alert-info"> There isn't holidays you requested from Admin...  </div>
                    
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
            <p>- You have limit one to apply holiday per day.</p>
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
                    Demand Holiday To you :(
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
            
                <a href="<?=base_url('team_member/holidays/demand_holiday')?>" class="btn btn-default btn-lg btn-block">
                    Demand Holiday
                </a>
	
            <?php endif ?>
            
            
            
        </div>
        <!-- /end well div -->
    </div>
    
</div>
<!-- /.row -->


