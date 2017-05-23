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

	$holiday_id="";
	$holiday_title="";
	$holiday_date="";

	if ($holiday_data!="") {
		$holiday_id=$holiday_data->id;
		$holiday_title=$holiday_data->holiday_title;
		$holiday_date=$holiday_data->holiday_date;
	}

?>

<div class="row">
	<form action="<?=base_url("high_admin/demands/save_general_holiday/$holiday_id")?>" method="POST" enctype="multipart/form-data">
		
		<h1>General Holiday</h1>

		<?=generate_inputs_html(
			$labels_name=array("Holiday Title","Holiday Date") ,
			$fields_name=array("holiday_title","holiday_date") , 
			$required=array("required","required") , 
			$type=array("text","date") , 
			$values=array($holiday_title,$holiday_date) , 
			$class=array("","")
		)?>

		<input type="hidden" name="<?=$this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>">
		<input type="submit" value="Save" class="col-md-4 col-md-offset-4 btn btn-primary btn-lg">
	</form>
</div>


	
