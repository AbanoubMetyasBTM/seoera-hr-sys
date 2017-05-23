	
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


	$userid=""; 
	$user_type=$user_type; 
	$username=""; 
	$email=""; 
	$password=""; 
	$user_img_id=""; 
	$sallery=""; 
	$tel=""; 
	$hire_date=""; 
	$notes=""; 
	$website=""; 
	$country=""; 
	$fingerprint_id="";
	$department_id=""; 
	$start_work_time=""; 
	$end_work_time=""; 
	$overtime_hour_ratio=""; 
	$decrease_salary_time=""; 
	$decrease_salary_value=""; 
	$normal_holiday_days=""; 
	$abnormal_holiday_days="";

	$img_path="";
	$img_alt="";
	$img_title="";
	$disabled="";

	if ($user_data!="") {
		$userid=$user_data->userid; 
		$user_type=$user_type;
		$username=$user_data->username;
		$email=$user_data->email;
		$password="";
		$user_img_id=$user_data->user_img_id;
		$sallery=$user_data->sallery;
		$tel=$user_data->tel;
		$hire_date=$user_data->hire_date;
		$notes=$user_data->notes;
		$website=$user_data->website;
		$country=$user_data->country;
		$fingerprint_id=$user_data->fingerprint_id;
		$department_id=$user_data->department_id;
		$start_work_time=$user_data->start_work_time;
		$end_work_time=$user_data->end_work_time;
		$overtime_hour_ratio=$user_data->overtime_hour_ratio;
		$decrease_salary_time=$user_data->decrease_salary_time;
		$decrease_salary_value=$user_data->decrease_salary_value;
		$normal_holiday_days=$user_data->normal_holiday_days;
		$abnormal_holiday_days=$user_data->abnormal_holiday_days;

		$img_path=base_url($user_data->path);
		$img_alt=$user_data->alt;
		$img_title=$user_data->title;
		$disabled="disabled";
	}

?>

<div class="row">
	<form action="<?=base_url("high_admin/users/save_user/$user_type/$userid")?>" method="POST" enctype="multipart/form-data">
		

		<?=
			generate_img_tags_for_form(
					"user_img_file[]","user_img_file","required",
					"user_img_checkbox","yes","",
					$img_path,$img_title,$img_alt,
					/*recomended_size*/"",$disabled,"50","Upload User Image" 
			); 
		?>
		<hr>
		<?=generate_select_tags("department_id","Select Department",$all_departments_text,$all_departments_val,array($department_id),"form-control")?>

		<hr>
		<?php  
			

			if ($user_type=="high_admin") {
				unset($cols[4]);
			}

			if ($user_type=="team_member") {
				unset($cols[10]);
			}

			if ($user_type=="customer") {
				unset($cols[7]);
			}
			$new_cols=array();
			foreach ($cols as $key => $value) {
				$new_cols[]=$value;
			}

			$reuqired=array();
			$values=array();
			$classes=array();

			foreach ($new_cols as $key => $value) {
				$reuqired[$key]="";
				if ($value!="password"||$value!="notes") {
					$reuqired[$key]="reuqired";
				}
				
				$values[$key]="";
				if ($user_data!=""&&$value!="password") {
					$values[$key]=$user_data->$value;
				}
				$classes[]="";
			}

			
		?>
		<?=generate_inputs_html($new_cols , $new_cols , $reuqired , $col_types , $values , $classes)?>
		


		<input type="hidden" name="<?=$this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>">
		<input type="submit" value="Save" class="col-md-4 col-md-offset-4 btn btn-primary btn-lg">
	</form>
</div>


	
