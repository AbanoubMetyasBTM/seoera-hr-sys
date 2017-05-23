	
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

	$dep_id="";
	$dep_name="";
	$header="Add New Department";

	if ($dep_data!="") {

		$dep_id=$dep_data->dep_id;
		$dep_name=$dep_data->dep_name;
		$header="Edit ".$dep_name;
	}

?>

<div class="row">
	<form action="<?=base_url("high_admin/department/save_department/$dep_id")?>" method="POST" enctype="multipart/form-data">
		
		<h1><?=$header?></h1>
		<!-- generate_inputs_html(labels_name , fields_name , required , type , values , class) -->
		<?=generate_inputs_html(array("Department Name") ,array("dep_name") , array("required") , array("text") , array($dep_name) , array(""));?>

		<input type="hidden" name="<?=$this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>">
		<input type="submit" value="Save" class="col-md-4 col-md-offset-4 btn btn-primary btn-lg">
	</form>
</div>


	
