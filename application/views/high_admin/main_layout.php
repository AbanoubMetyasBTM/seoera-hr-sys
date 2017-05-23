<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?=$meta_title?></title>

    <!-- Bootstrap Core CSS -->
    <link href="<?=base_url('public_html/high_admin_assests/css/bootstrap.min.css')?>" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="<?=base_url('public_html/high_admin_assests/css/sb-admin.css')?>" rel="stylesheet">
    <!-- Custom Fonts -->
    <!-- <link href="<?=base_url('public_html/high_admin_assests/font-awesome/css/font-awesome.min.css')?>" rel="stylesheet" type="text/css"> -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">

    <!--datatable css-->
    <!--<link href="<?=base_url('public_html/high_admin_assests/css/jquery.dataTables.min.css')?>" rel="stylesheet" type="text/css">-->
    <!--<link href="<?=base_url('public_html/high_admin_assests/css/dataTables.bootstrap.min.css')?>" rel="stylesheet" type="text/css">--> 
    <!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/s/ju-1.11.4/dt-1.10.10/datatables.min.css"/> -->
    
    <link href="<?=base_url('public_html/high_admin_assests/css/mycss.css')?>" rel="stylesheet" type="text/css">

    
    
    <!-- jQuery -->
    <script src="<?=base_url('public_html/high_admin_assests/js/jquery.js')?>"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>

    <!--jquery ui-->
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
    
    <!-- Bootstrap Core JavaScript -->
    <script src="<?=base_url('public_html/high_admin_assests/js/bootstrap.min.js')?>"></script>

    
    <!-- My Datatable libraries -->
    <!-- DataTables CSS -->
    <link href="<?= base_url('public_html/high_admin_assests/css/plugins/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css'); ?>" rel="stylesheet">

    <!-- DataTables Responsive CSS -->
    <link href="<?= base_url('public_html/high_admin_assests/css/plugins/datatables-responsive/css/dataTables.responsive.css'); ?>" rel="stylesheet">

    <!-- DataTables JavaScript -->
    <script src="<?php echo base_url('public_html/high_admin_assests/css/plugins/datatables/media/js/jquery.dataTables.min.js'); ?>"></script>
    <script src="<?php echo base_url('public_html/high_admin_assests/css/plugins/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js'); ?>"></script>
    <!-- ./My Datatable libraries -->
    
    <script src="<?=base_url('public_html/jscode/high_admin_js/admin.js')?>"></script>
    <script src="<?=base_url('public_html/jscode/high_admin_js/user_statistics.js')?>"></script>

    
</head>

<body>

    <div id="wrapper">
        <!-- hidden csrf -->
        <input type="hidden" class="csrf_input_class" name="<?=$this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>">
        <!-- /hidden csrf -->
        <!-- hidden base url -->
        <input type="hidden" class="base_url_class" value="<?=base_url()?>">
        <!-- /hidden base url -->
        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?=base_url("high_admin/dashboard")?>">Seoera System Adminpanel</a>
            </div>
            <!-- Top Menu Items -->
            <ul class="nav navbar-right top-nav">
               
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?=$username?> <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href='<?=base_url("high_admin/dashboard/logout")?>'><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                        </li>
                    </ul>
                </li>
            </ul>
            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav">
                    
                    <li class="active">
                        <a href="javascript:;" data-toggle="collapse" data-target="#drop_down_deps"><i class="fa fa-folder"></i> Departments <i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="drop_down_deps" class="collapse">
                            <li>
                                <a href='<?=  base_url("high_admin/department/show_all_departments")?>'>Show All Departments</a>
                            </li>
                            <li>
                                <a href="<?=  base_url('high_admin/department/save_department')?>">Add Department</a>
                            </li>
                        </ul>
                    </li>

                    <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#drop_down_users"><i class="fa fa-users"></i> Users <i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="drop_down_users" class="collapse">
                            <li>
                                <a href='<?=  base_url("high_admin/users/show_users/high_admin")?>'>Show All High Admins</a>
                            </li>
                            <li>
                                <a href='<?=  base_url("high_admin/users/save_user/high_admin")?>'>Add High Admin</a>
                            </li>
                            <li>
                                <a href="<?=  base_url('high_admin/users/show_users/team_member')?>">Show All Team Members</a>
                            </li>
                            <li>
                                <a href="<?=  base_url('high_admin/users/save_user/team_member')?>">Add Team Member</a>
                            </li>
                            <li>
                                <a href="<?=  base_url('high_admin/users/show_users/customer')?>">Show All Customers</a>
                            </li>
                            <li>
                                <a href="<?=  base_url('high_admin/users/save_user/customer')?>">Add Customer</a>
                            </li>
                        </ul>
                    </li>
                    
                    <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#drop_down_salary"><i class="fa fa-usd"></i> Salary <i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="drop_down_salary" class="collapse">
                            <li>
                                <a href='<?=  base_url("high_admin/dashboard/show_user_salary")?>'>Show Users Salaries</a>
                            </li>
                            <li>
                                <a href="<?=  base_url('high_admin/dashboard/upload_worktimes_file')?>">Upload Worktimes File</a>
                            </li>
                        </ul>
                    </li>

                    <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#drop_down_tasks"><i class="fa fa-tasks"></i> Tasks <i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="drop_down_tasks" class="collapse">
                            <li>
                                <a href='<?=  base_url("high_admin/tasks/index")?>'>Show Tasks</a>
                            </li>
                            <li>
                                <a href="<?=  base_url('high_admin/tasks/save_task')?>">Add Task</a>
                            </li>
                        </ul>
                    </li>
                    
                    <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#drop_down_general_holidays"><i class="fa fa-bed"></i> General Holidays <i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="drop_down_general_holidays" class="collapse">
                            <li>
                                <a href='<?=  base_url("high_admin/demands/general_holidays")?>'>Show All General Holidays</a>
                            </li>
                            <li>
                                <a href="<?=  base_url('high_admin/demands/save_general_holiday')?>">Add New Holiday</a>
                            </li>
                        </ul>
                    </li>

                    <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#drop_down_holiday_demands"><i class="fa fa-bed"></i> Holiday Demands <i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="drop_down_holiday_demands" class="collapse">
                            <li>
                                <a href='<?=  base_url("high_admin/demands/holiday_demands")?>'>Show All Holiday Demands</a>
                            </li>
                        </ul>
                    </li>

                    <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#drop_down_delay_demands"><i class="fa fa-clock-o"></i> Delay Demands <i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="drop_down_delay_demands" class="collapse">
                            <li>
                                <a href='<?=  base_url("high_admin/demands/delay_demands")?>'>Show All Delay Demands</a>
                            </li>
                        </ul>
                    </li>






                    
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </nav>

        <div id="page-wrapper">

            <div class="container-fluid">
                <div class="row-fluid main-body">
                    <?=$subview?>
                </div>
            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    

</body>

</html>
