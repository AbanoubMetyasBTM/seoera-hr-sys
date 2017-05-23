<?php
	//dump($all_holidays);
?>

<div class="col-md-6 col-md-offset-3">
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
		<button class="btn btn-info" id="get_holiday_demands_btn">Show This User Demands</button>
	</div>
</div>



<table id="cat_table" class="table table-striped table-bordered" cellspacing="0" width="100%">
	<thead>
		<tr>
			<td>#</td>
			<td>Username</td>
			<td>Holiday When</td>
			<td>Request Holiday When</td>
			<td>Operation</td>
            <td>Remove</td>
		</tr>
	</thead>

	<tfoot>
		<tr>
			<td>#</td>
			<td>Username</td>
			<td>Holiday When</td>
			<td>Request Holiday When</td>
			<td>Operation</td>
            <td>Remove</td>
		</tr>
	</tfoot>
	
	<tbody>
		<?php foreach ($all_holidays as $key => $holiday): ?>
            <tr id="row<?=$holiday->id?>">
				<?php  
					$operation_text='<i class="fa fa-thumbs-up"></i>';
					$operation_class="accept_holiday_Demand";
					if ($holiday->demand_accepted==1) {
						$operation_text='<i class="fa fa-thumbs-down"></i>';
						$operation_class="refuse_holiday_Demand";
					}
				?>
				<td><?=$key+1?></td>
				<td><?=$holiday->username?></td>
				<td><?=$holiday->holiday_when?></td>
				<td><?=$holiday->created?></td>
				<td><a href="#" data-demandid="<?=$holiday->id?>" class="<?=$operation_class?>"><?=$operation_text?></a></td>
                <td><a href='#' class="remove_item" data-deleteurl="<?=base_url("high_admin/demands/remove_holiday_demand")?>" data-itemid="<?=$holiday->id?>">Remove</a></td>
			</tr>
		<?php endforeach ?>
	</tbody>

</table>
    	