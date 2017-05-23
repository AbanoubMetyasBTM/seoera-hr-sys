<?php
	//dump($all_deps);
?>

<table id="cat_table" class="table table-striped table-bordered" cellspacing="0" width="100%">
	<thead>
		<tr>
			<td>Department Name</td>
			<td>Edit</td>
            <td>Remove</td>
		</tr>
	</thead>
	
	<tbody>
		<?php foreach ($all_deps as $key => $dep): ?>
            <tr id="row<?=$dep->dep_id?>">
				<td><?=$dep->dep_name?></td>
                <td><a href="<?=base_url("high_admin/department/save_department/$dep->dep_id")?>">Edit</a></td>
                <td><a href='#' class="remove_item" data-deleteurl="<?=base_url("high_admin/department/remove_department")?>" data-itemid="<?=$dep->dep_id?>">Remove</a></td>
			</tr>
		<?php endforeach ?>
	</tbody>

</table>
    	