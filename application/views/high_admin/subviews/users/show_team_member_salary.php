<style>
	.fireworks_tr{
		background: url("<?=base_url("public_html/img/fireworks.jpg")?>");
		background-size: 32px 37px;
		font-weight: bold;
	}

	.fireworks_tr td{
		background: rgba(0,0,0,.7);
    	color: #FFF;
	}


	.bed_tr{
		background: url("<?=base_url("public_html/img/bed.jpg")?>");
		background-size: 32px 37px;
		font-weight: bold;
	}

	.bed_tr td{
		background: rgba(0,0,0,.7);
    	color: #FFF;
	}

	.overtime_days{
	    background-color: #287FCA;
    	border: 3px solid #263E52;
	}

	hr{
		width: 100%;
		margin-top: 20px;
		margin-bottom: 20px;
	}

</style>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>


<div class="row style_blocks">
	
	<div class="form-group col-md-10 col-md-offset-1">
		<div class="col-md-12">
			<h1>Please select Year-Month-User to show Charts</h1>
		</div>
		<div class="col-md-12">
			<div class="col-md-3">
				<div class="form-group">
	                    <?php
	                        $already_selected_value = intval($year_selected);
	                        $earliest_year = 2000;
	                        echo generate_select_years($already_selected_value, $earliest_year , 'select_year select_year_class' , 'select_year');
	                    ?>
	            </div>
			</div>

			<div class="col-md-3">
				<div class="form-group">
                    <select class="form-control select_month select_month_class" style="cursor: pointer" name="select_month">

                        <?php if ($month_selected == 1): ?>
                            <option selected value="1">January</option>
                        <?php endif ?>

                        <?php if ($month_selected != 1): ?>
                            <option value="1">January</option>
                        <?php endif ?>

                        <?php if ($month_selected == 2): ?>
                            <option selected value="2">February</option>
                        <?php endif ?>

                        <?php if ($month_selected != 2): ?>
                            <option value="2">February</option>
                        <?php endif ?>

                        <?php if ($month_selected == 3): ?>
                            <option selected value="3">March</option>
                        <?php endif ?>

                        <?php if ($month_selected != 3): ?>
                            <option value="3">March</option>
                        <?php endif ?>

                        <?php if ($month_selected == 4): ?>
                            <option selected value="4">April</option>
                        <?php endif ?>

                        <?php if ($month_selected != 4): ?>
                            <option value="4">April</option>
                        <?php endif ?>

                        <?php if ($month_selected == 5): ?>
                            <option selected value="5">May</option>
                        <?php endif ?>

                        <?php if ($month_selected != 5): ?>
                            <option value="5">May</option>
                        <?php endif ?>

                        <?php if ($month_selected == 6): ?>
                            <option selected value="6">June</option>
                        <?php endif ?>

                        <?php if ($month_selected != 6): ?>
                            <option value="6">June</option>
                        <?php endif ?>  

                        <?php if ($month_selected == 7): ?>
                            <option selected value="7">July</option>
                        <?php endif ?>

                        <?php if ($month_selected != 7): ?>
                            <option value="7">July</option>
                        <?php endif ?> 


                        <?php if ($month_selected == 8): ?>
                            <option selected value="8">August</option>
                        <?php endif ?>

                        <?php if ($month_selected != 8): ?>
                            <option value="8">August</option>
                        <?php endif ?> 

                        <?php if ($month_selected == 9): ?>
                            <option selected value="9">September</option>
                        <?php endif ?>

                        <?php if ($month_selected != 9): ?>
                            <option value="9">September</option>
                        <?php endif ?>

                        <?php if ($month_selected == 10): ?>
                            <option selected value="10">October</option>
                        <?php endif ?>

                        <?php if ($month_selected != 10): ?>
                            <option value="10">October</option>
                        <?php endif ?>

                        <?php if ($month_selected == 11): ?>
                            <option selected value="11">November</option>
                        <?php endif ?>

                        <?php if ($month_selected != 11): ?>
                            <option value="11">November</option>
                        <?php endif ?>

                        <?php if ($month_selected == 12): ?>
                            <option selected value="12">December</option>
                        <?php endif ?>

                        <?php if ($month_selected != 12): ?>
                            <option value="12">December</option>
                        <?php endif ?>

                    </select>
                </div>
			</div>

			<div class="col-md-3">
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
			<div class="col-md-3">
				<button class="btn btn-info" id="get_statistics_btn">Get Statistics</button>
			</div>
                
                
		</div>
	</div>

	<?php if (!isset($user_salary_data)): ?>
	
	<!-- Working Statistics Chart -->
	<div class="col-md-12 style_blocks">
		<!-- First Chart -->
		<input type="hidden" class="max_work_time" value="<?= intval($working_activites[0]) ?>">
		<input type="hidden" class="max_late_time" value="<?= intval($working_activites[1]) ?>">
		<input type="hidden" class="max_over_time" value="<?= intval($working_activites[2]) ?>">
		<input type="hidden" class="min_check_in_time" value="<?= intval($working_activites[3]) ?>">

		<h1>Working Statistics Chart</h1>
		<div id="working_chart" class="col-md-12" style="height: 450px;">
			
		</div>

		<!-- END First Chart -->
	</div>
	
	<hr>

	<!-- Work Time Table Chart -->
	<div class="col-md-12 style_blocks">
		
		<!-- For second chart -->
		<?php if (!empty($user_data)): ?>
		                
		    <input type="hidden" class = "start_work_time" name="start_work_time" value="<?= $user_data->start_work_time ?>">
		    <input type="hidden" class = "end_work_time" name="end_work_time" value="<?= $user_data->end_work_time ?>">

		<?php endif ?>
		<div style="display: none" class="mywork_data" data-mywork="<?= htmlentities(json_encode($work), ENT_QUOTES , 'UTF-8')  ?>">
		</div>

		<!-- END second chart -->
		<h1>Work Time Table Chart</h1>
		<div id="worktime_chart" class="col-md-12" style="height: 450px;">
		</div>
	</div>

	<hr>

	<!-- User Taks -->
	<div class="col-md-12 style_blocks">
		<dtitle>Tasks Status Chart</dtitle>
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
	
	<hr>

	<!-- Work Time Table -->
	<?php
		$total_worked_times=0;
		$total_late_time=0;
		$total_over_time=0;
		

		$total_worked_days=0;
		$total_overtime_days=0;
		$total_abesnt_days=0;
		$demanded_holiday_days_taken=0;

		$all_days=cal_days_in_month(CAL_GREGORIAN,$month_selected, $year_selected);
        $this_month_days=array();
        
        if ($month_selected<10) {
        	$month_selected="0$month_selected";
        }

        for($i=1;$i<=$all_days;$i++){
            $typed_i=$i;
            if ($i<10) {
                $typed_i="0$i";
            }
            $this_month_days[]="$year_selected-$month_selected-$typed_i";
        }

        $new_work_table=array();
        foreach ($work_table as $key => $day) {
        	$new_work_table[$day->day]=$day;
        }


        $new_general_holiday_days=array();
        foreach ($general_holidays as $key => $day) {
        	$new_general_holiday_days[$day->holiday_date]=$day;
        }

        $new_demand_holidays=array();
        foreach ($demand_holidays as $key => $day) {
        	$new_demand_holidays[$day->holiday_when]=$day;
        }

        $new_absence=array();
        foreach ($absence as $key => $day) {
        	$new_absence[$day]=$day;
        }

        $new_delay_demand=array();
        foreach ($delay_demands as $key => $day) {
        	$new_delay_demand[$day->delay_demand_date][$day->delay_when]=$day;
        }

	?>
	<div class="col-md-12">
		<table class="table table-striped table-hover table-bordered">
			<tr class="success">
				<td>Day</td>
				<td>Day Name</td>
				<td>Official Start Work</td>
				<td>Check In</td>
				<td>Official End Work</td>
				<td>Check Out</td>
				<td>Work Time</td>
				<td>Late Time</td>
				<td>Over Time</td>
				<td style="font-size:8px;">Forget to check in</td>
				<td style="font-size:8px;">Forget to check out</td>
			</tr>


			<?php foreach ($this_month_days as $key => $month_day): ?>
				<?php if (isset($new_work_table[$month_day])): ?>
					<?php 
						$work_table_row= $new_work_table[$month_day];

						$warning_forget_check_in_cell="";
						$warning_forget_check_out_cell="";
						if ($work_table_row->forget_check_in=="1") {
							$work_table_row->forget_check_in="yes";
							$warning_forget_check_in_cell="danger";
						}

						if ($work_table_row->forget_check_out=="1") {
							$work_table_row->forget_check_out="yes";
							$warning_forget_check_out_cell="danger";
						}

						$tr_class="";
						if (isset($new_general_holiday_days[$month_day])) {
							$tr_class="fireworks_tr";
						}


						
						//calc overtime&latetime
						$total_late_time_temp=$work_table_row->late_time;
						$total_late_time_temp=explode(":", $total_late_time_temp);
						$total_late_time+=($total_late_time_temp[0]*60*60)+($total_late_time_temp[1]*60);

						$total_over_time_temp=$work_table_row->over_time;
						$total_over_time_temp=explode(":", $total_over_time_temp);
						$total_over_time+=($total_over_time_temp[0]*60*60)+($total_over_time_temp[1]*60);

						//END calc overtime&latetime
						//calcs
						// $total_worked_times_temp=$work_table_row->late_time;
						// $total_late_time_temp=explode(":", $total_late_time_temp);
						// $total_late_time+=($total_late_time_temp[0]*60*60)+($total_late_time_temp*60);

						// $total_worked_times

						$total_worked_days++;

						//END calcs

						if (date("D",strtotime($month_day))=="Sat"||date("D",strtotime($month_day))=="Fri"||isset($new_general_holiday_days[$month_day])) {
							$total_overtime_days++;
							$tr_class="overtime_days";
						}

						$delay_demand_day="";
						$delay_demand_day_title="";
						$delay_demand_night="";
						$delay_demand_night_title="";

						if (isset($new_delay_demand[$month_day]["day"])) {
							$delay_demand_day="style='background-color:green;color:#FFF;'";
							$delay_demand_day_title="title='".$new_delay_demand[$month_day]["day"]->delay_value." Min'";
						}

						if (isset($new_delay_demand[$month_day]["night"])) {
							$delay_demand_night="style='background-color:green;color:#FFF;'";
							$delay_demand_night_title="title='".$new_delay_demand[$month_day]["night"]->delay_value." Min'";
						}

					?>

					<tr class="<?=$tr_class?>">
						<td><?=$work_table_row->day?></td>
						<td><?=date("D",strtotime($work_table_row->day))?></td>
						<td><?=$user_data->start_work_time?></td>
						<td <?=$delay_demand_day?> <?=$delay_demand_day_title?> ><?=$work_table_row->check_in?></td>
						<td><?=$user_data->end_work_time?></td>
						<td <?=$delay_demand_night?> <?=$delay_demand_night_title?> ><?=$work_table_row->check_out?></td>
						<td><?=$work_table_row->work_time?></td>
						<td><?=$work_table_row->late_time?></td>
						<td><?=$work_table_row->over_time?></td>
						<td class="<?=$warning_forget_check_in_cell?>"><?=$work_table_row->forget_check_in?></td>
						<td class="<?=$warning_forget_check_out_cell?>"><?=$work_table_row->forget_check_out?></td>
					</tr>

				<?php else: ?>
					<?php
						$class_color="danger";
						$style="style=' border: 3px solid #DE7474;'";
						if (date("D",strtotime($month_day))=="Sat"||date("D",strtotime($month_day))=="Fri") {
							$class_color="info";
							$style="";
						}
						
						if(isset($new_absence[$month_day])){
							$total_abesnt_days++;
						}

						if (isset($new_general_holiday_days[$month_day])) {
							$class_color="fireworks_tr";
							$style="";
						}

						if (isset($new_demand_holidays[$month_day])) {
							$class_color="bed_tr";
							$style="";
						}

					?>
					<tr class="<?=$class_color?>" <?=$style?>>
						<td><?=$month_day?></td>
						<td><?=date("D",strtotime($month_day))?></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
				<?php endif ?>
				


			<?php endforeach ?>
		</table>

		<div class="col-md-12">
			<!-- info -->
			<?php 
				$main_earn=0;
				$overtime=0;
				$late_discount=0;
				$absence_discount=0;
			?>

			<!-- normal_holiday_days -->
			<div class="alert alert-info">
			  	<strong>Holidays!</strong> Normal: <?=$user_data->normal_holiday_days?> , Abnormal: <?=$user_data->abnormal_holiday_days?>
			  	<?php if (isset($demand_holidays)&&is_array($demand_holidays)&&count($demand_holidays)): ?>
			  		
			  		<?php foreach ($demand_holidays as $key => $holiday): ?>
			  			<?php if (!isset($new_work_table[$holiday->holiday_when])): ?>
			  				<p>You have demanded a holiday in date <?=$holiday->holiday_when?> And you took it</p>
			  				<?php $demanded_holiday_days_taken++; ?>
		  				<?php else: ?>
		  					<p>You have demanded a holiday in date <?=$holiday->holiday_when?> And you did not take it</p/>
			  			<?php endif ?>
			  			
			  		<?php endforeach ?>
			  		

			  	<?php endif ?>
			</div>
		
			<!-- Remain of normal holiday days -->
			<div class="alert alert-warning">
				<strong>Abnormal Holidays Taken Num: </strong><?=count($new_absence)?>
				<br>
				<strong>Normal Holidays Taken Num: </strong><?=$demanded_holiday_days_taken?>
				<br>
			  	<strong>Remain of Normal Holidays!</strong> <?=$user_data->normal_holiday_days-$demanded_holiday_days_taken?>
			  	<br>
			  	<strong>Remain of Abnormal Holidays!</strong> <?=$user_data->abnormal_holiday_days-count($new_absence)?>
			</div>

			<!-- salary -->
			<div class="alert alert-success">
				<?php  
					$main_earn=$user_data->sallery;
				?>
			  	<strong>Salary!</strong> <?=$user_data->sallery?>
			</div>

			<!-- Salary Calc -->
			<!-- overtime Calc -->
			<div class="alert alert-success">
				<?php  
					$overtime_hour_val=$user_data->sallery/(30*8);
					$overtime_hour_val=$overtime_hour_val*$user_data->overtime_hour_ratio;
					$overtime_hours_val=floatval($total_over_time/3600);
					$overtime=$overtime_hour_val*$overtime_hours_val;
				?>
			  	<strong>Overtime Hours= </strong> <?=$overtime_hours_val?>
			  	<br>
			  	<strong>Overtime Hour Ratio= </strong> <?=$user_data->overtime_hour_ratio?>
		  		<br>
		  		<strong>Hour=(salary/(30*8))= </strong><?=$overtime_hour_val?>
		  		<br>
		  		<strong>You Earn= </strong><?=$overtime?>
			</div>

			<!-- decrease_salary_time -->
			<div class="alert alert-danger">
				<?php  
					$latetime_hours_val=floatval($total_late_time/60);
					$late_discount=($latetime_hours_val/$user_data->decrease_salary_time)*$user_data->decrease_salary_value;

				?>
			  	<strong>Decrease Salary Time= </strong> Every <?=$user_data->decrease_salary_time?> M discount <?=$user_data->decrease_salary_value?>
				<br>
				<strong>Total Late Time= </strong><?=$latetime_hours_val?> M
				<br>
				<strong>You Lose= </strong><?=$late_discount?>
				<?php  
					$absence_more_than_Abnormal=count($new_absence)-$user_data->abnormal_holiday_days;
				?>
				<?php if ($absence_more_than_Abnormal>0): ?>
				<hr>
				<strong>You Have Absent more that your Abnormal Holidays by </strong>:<?=$absence_more_than_Abnormal?> day(s)
				<br>
				<?php  
					$absence_discount=$absence_more_than_Abnormal*$overtime_hour_val*8;
				?>
				so you will lose <?=$absence_discount?>
				<?php endif ?>
			</div>
		
			<!-- total -->
			<div class="alert alert-success" style="font-size:22px;font-weight:bold;">
				<?php  
					$overtime_days_profit=$total_overtime_days*$overtime_hour_val*8;
				?>
				<strong>Main Salary: </strong><?=round($main_earn)?>
				<br>
				<strong>Overtime Profit: </strong><?=round($overtime)?>
				<br>
				<strong>Overtime Days Num: </strong><?=$total_overtime_days?> <strong>Profit: </strong><?=$overtime_days_profit?>
				<br>
				<strong>Latetime Loss: </strong><?=round($late_discount)?>
				<br>
				<strong>Absence Loss: </strong><?=round($absence_discount)?>
				<br>
				<strong>Total :</strong><?=round(($main_earn+$overtime+$overtime_days_profit)-($late_discount+$absence_discount))?>
			</div>

			<div class="alert alert-info">
				<strong>Num Of Worked Days: </strong><?=count($new_work_table)?>
			</div>

		</div>
	

	</div>


	<div class="col-md-12">
		<div class="form-group col-md-6">
			<label for="">Remain Of Normal Holidays</label>
			<input type="number" class="form-control" name="remain_of_normal_holidays" id="remain_of_normal_holidays_id"  value="<?=$user_data->normal_holiday_days-$demanded_holiday_days_taken?>">
		</div>
		<div class="form-group col-md-6">
			<label for="">Ramain Of Abnormal Holidays</label>
			<?php  
				$new_abnormal=$user_data->abnormal_holiday_days-count($new_absence);
				if ($new_abnormal<0) {
					$new_abnormal=0;
				}
			?>
			<input type="number" class="form-control" name="remain_of_abnormal_holidays" id="remain_of_abnormal_holidays_id"  value="<?=$new_abnormal?>">
		</div>
		
		<div class="col-md-6 col-md-offset-3">
			<button class="btn btn-primary btn-block update_this_user_holidays">Update Holidays Number for this user</button>
		</div>
	</div>
	

	<?php endif ?>
	<!-- END if (!isset($user_salary_data)) -->
	
	


</div>