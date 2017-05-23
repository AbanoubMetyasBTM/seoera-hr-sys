<style>
	hr{
		width: 100%;
		height:1px;
	}
</style>
<?php  
	if (isset($dump)&&!empty($dump)) {
		echo $dump;
	}

	if (isset($success)&&!empty($success)) {
		echo $success;
	}

	$header="Add Task";

	$task_id="";
	$client_id="";
	$userid="";
	$task_title="";
	$task_desc="";
	$task_statues="";
	$task_start_date="";
	
	if ($task_data!="") {
		$header="Edit ".$task_data->task_title;

		$task_id=$task_data->task_id;
		$client_id=$task_data->client_id;
		$userid=$task_data->userid;
		$task_title=$task_data->task_title;
		$task_desc=$task_data->task_desc;
		$task_statues=$task_data->task_statues;
		$task_start_date=$task_data->task_start_date;
	}


?>

<div class="row">
	<form action="<?=base_url("high_admin/tasks/save_task/$task_id")?>" method="POST" enctype="multipart/form-data">
		
		<h1><?=$header?></h1>
		

		<?=generate_select_tags(
			"userid",
			"Who will make this task",
			$team_members_emails,
			$team_members_ids,
			array($userid),
			"form-control",
			""
		);?>


		<hr>

		<?=generate_select_tags(
			"client_id",
			"Client",
			$customers_emails,
			$customers_ids,
			array($client_id),
			"form-control",
			""
		);?>

		<hr>

		<?=generate_select_tags(
			"task_statues",
			"Task Status",
			array("Waiting" , "In Process" , "Done" , "Testing"),
			array("waiting" , "in_process" , "done" , "testing"),
			array($task_statues),
			"form-control",
			""
		);?>

		<hr>

		<?=generate_inputs_html(
			/*labels*/array("task_title","task_desc","task_start_date") ,
		 	/*fields*/array("task_title","task_desc","task_start_date") ,
		 	/*required*/array("required","required","required") ,
		 	/*type*/array("text","textarea","date") ,
		 	/*values*/array($task_title,$task_desc,$task_start_date) ,
		 	/*class*/array("","","")
	 	)?>
	
		<!-- generate_select_tags(field_name,label_name,text,values,selected_value,class="",multiple="") -->
		
		<input type="hidden" name="<?=$this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>">
		<input type="submit" value="Save" class="col-md-4 col-md-offset-4 btn btn-primary btn-lg">
	</form>
</div>


	
