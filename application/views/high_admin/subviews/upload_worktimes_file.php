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



?>

<div class="row">
	<form action="<?=base_url("high_admin/dashboard/upload_worktimes_file")?>" method="POST" enctype="multipart/form-data">
		
		<h1>Upload Worktimes File</h1>

		<div class="form-grouop">
			<label for="">Upload File (.csv):</label>
			<input type="file" class="form-control" name="worktimes_file[]" required>
		</div>


		<input type="hidden" name="<?=$this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>">
		<input type="submit" name="submit" value="Upload" class="col-md-4 col-md-offset-4 btn btn-primary btn-lg">
	</form>
</div>


	
	