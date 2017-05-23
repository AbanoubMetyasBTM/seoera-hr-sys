<?php
	//dump($all_general_holidays);
?>


<table id="cat_table" class="table table-striped table-responsive table-hover table-bordered task_table" cellspacing="0" width="100%">
	<thead>
		<tr>
			<td>#</td>
			<td>Holiday Title</td>
			<td>Holiday Date</td>
			<td>Edit</td>
            <td>Remove</td>
		</tr>
	</thead>

	<tfoot>
		<tr>
			<td>#</td>
			<td>Holiday Title</td>
			<td>Holiday Date</td>
			<td>Edit</td>
            <td>Remove</td>
		</tr>
	</tfoot>
	
	<tbody>
		<?php foreach ($all_general_holidays as $key => $day): ?>
            <tr id="row<?=$day->id?>">
            	<td><?=$key+1?></td>
				<td><?=$day->holiday_title?></td>
				<td><?=$day->holiday_date?></td>
                <td><a href="<?=base_url("high_admin/demands/save_general_holiday/$day->id")?>">Edit</a></td>
                <td><a href='#' class="remove_item" data-deleteurl="<?=base_url("high_admin/demands/remove_general_holiday")?>" data-itemid="<?=$day->id?>">Remove</a></td>
			</tr>
		<?php endforeach ?>
	</tbody>

</table>
    	