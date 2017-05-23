<?php
	//dump($all_users);
?>

<div id="user_info_modal" class="modal fade" role="dialog">
  	<div class="modal-dialog">

	    <!-- Modal content-->
	    <div class="modal-content">
	      	<div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal">&times;</button>
		        <h4 class="modal-title">User Info</h4>
	      	</div>
	      	<div class="modal-body row" style="font-weight: bold;">
	        	
	      	</div>
	      	<div class="modal-footer">
	        	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	      	</div>
	    </div>

  	</div>
</div>

<table id="cat_table" class="table table-striped table-bordered" cellspacing="0" width="100%">
	<thead>
		<tr>
			<td>User Image</td>
			<td>Username</td>
			<td>Email</td>
			<td>Show Other Data</td>
			<?php if ($user_type=="team_member"): ?>
				<td>Show His Statistics</td>
			<?php endif ?>
			<td>Edit</td>
            <td>Remove</td>
		</tr>
	</thead>
	
	<tbody>
		<?php foreach ($all_users as $key => $user): ?>
            <tr id="row<?=$user->userid?>">
				<td><img src="<?=base_url($user->path)?>" width="50"></td>
				<td><?=$user->username?></td>
				<td><?=$user->email?></td>
				<td><a href="#" class="show_user_other_data" data-showncols="<?= htmlentities(json_encode((object)$displayed_cols), ENT_QUOTES, 'UTF-8');  ?>" data-otherdata="<?=htmlentities(json_encode($user), ENT_QUOTES, 'UTF-8');?>">Show</a></td>
                <?php if ($user_type=="team_member"): ?>
                <td><a href="<?=base_url("high_admin/users/show_user_statistics/$user->userid")?>">Show</a></td>
                <?php endif ?>
                <td><a href="<?=base_url("high_admin/users/save_user/$user->user_type/$user->userid")?>">Edit</a></td>
                <td><a href='#' class="remove_item" data-deleteurl="<?=base_url("high_admin/users/remove_user")?>" data-itemid="<?=$user->userid?>">Remove</a></td>
			</tr>
		<?php endforeach ?>
	</tbody>

</table>
    	
