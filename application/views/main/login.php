<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title><?=$meta_title?></title>
	<meta name="keywords" content="<?=$meta_keyword?>">
	<meta name="description" content="<?=$meta_desc?>">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"></meta>
	<link href=" " type="image/x-icon" rel="shortcut icon">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha256-KXn5puMvxCw+dAYznun+drMdG1IFl3agK0p/pqT9KAo= sha512-2e8qq0ETcfWRI4HJBzQiA3UoyFk6tbNyG+qSaIBZLyW9Xf3sWZHN/lxe9fTh1U45DpPf07yj94KsUHHWe4Yk1A==" crossorigin="anonymous"></script>
    
    <script src="<?=base_url("public_html/jscode/homepage.js")?>"></script>
	
	<style>

		body{
			background: url(<?=base_url("public_html/img/logo.png")?>) ;
		}
		.form_div{
			background-color: rgba(0,0,0,.7);
			border-radius: 10px;
			padding: 10px;
			margin-top: 20%;
			color: #FFF;
		}

	</style>
	


</head>
<body>
	<!-- hidden csrf -->
    <input type="hidden" class="csrf_input_class" name="<?=$this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>">
    <!-- /hidden csrf -->
    <!-- hidden base url -->
    <input type="hidden" class="base_url_class" value="<?=base_url()?>">
    <!-- /hidden base url -->

	<section class="container">
		<div class="row">
			<div class="col-md-6 col-md-offset-3  form_div">
				<div class="form-group">
					<label for="">Email:</label>
					<input type="text" class="form-control admin_username">					
				</div>
				<div class="form-group">
					<label for="">Password:</label>
					<input type="password" class="form-control admin_password">					
				</div>
				<div class="col-md-12 show_errors"></div>
				<button class="btn btn-primary admin_login_ajax">Login</button>
			</div>		
		</div>
	</section>
</body>
</html>