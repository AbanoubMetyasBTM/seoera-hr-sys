<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Seoera System</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Seoera System">
        <meta name="author" content="Seoera Company">

        <link rel="stylesheet" type="text/css" href="<?= base_url("public_html/customer_assests/bootstrap/css/bootstrap.min.css") ?>" />

        <link href="<?= base_url("public_html/customer_assests/css/main.css") ?>" rel="stylesheet">
        <link href="<?= base_url("public_html/customer_assests/css/font-style.css") ?>" rel="stylesheet">
        <link href="<?= base_url("public_html/customer_assests/font-awesome/css/font-awesome.css") ?>" rel="stylesheet">
        <link href="<?= base_url("public_html/customer_assests/css/flexslider.css") ?>" rel="stylesheet">
        <link href="<?= base_url("public_html/customer_assests/css/register.css") ?>" rel="stylesheet">
        
        <!--datatable css-->
<!--        <link href="<?=base_url('public_html/high_admin_assests/css/jquery.dataTables.min.css')?>" rel="stylesheet" type="text/css">
        <link href="<?=base_url('public_html/high_admin_assests/css/dataTables.bootstrap.min.css')?>" rel="stylesheet" type="text/css"> 
        -->
        <!--<script type="text/javascript" src="<?= base_url("public_html/customer_assests/js/jquery.js") ?>"></script>-->    
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>

        <script type="text/javascript" src="<?= base_url("public_html/customer_assests/bootstrap/js/bootstrap.min.js") ?>"></script>

        <!-- NOTY JAVASCRIPT -->
        <script type="text/javascript" src="<?= base_url("public_html/customer_assests/js/noty/jquery.noty.js") ?>"></script>
        <script type="text/javascript" src="<?= base_url("public_html/customer_assests/js/noty/layouts/top.js") ?>"></script>
        <script type="text/javascript" src="<?= base_url("public_html/customer_assests/js/noty/layouts/topLeft.js") ?>"></script>
        <script type="text/javascript" src="<?= base_url("public_html/customer_assests/js/noty/layouts/topRight.js") ?>"></script>
        <script type="text/javascript" src="<?= base_url("public_html/customer_assests/js/noty/layouts/topCenter.js") ?>"></script>
        
        <!--datatable js-->    
        <!--<script type="text/javascript" src="https://cdn.datatables.net/s/ju-1.11.4/dt-1.10.10/datatables.min.js"></script>-->

        <!-- You can add more layouts if you want -->
        <script type="text/javascript" src="<?= base_url("public_html/customer_assests/js/noty/themes/default.js") ?>"></script>
        <!-- <script type="text/javascript" src="assets/js/dash-noty.js"></script> This is a Noty bubble when you init the theme-->
        
        <script src="<?= base_url("public_html/customer_assests/js/jquery.flexslider.js") ?>" type="text/javascript"></script>

        <script type="text/javascript" src="<?= base_url("public_html/customer_assests/js/admin.js") ?>"></script>
        
        <!-- Loader Google Chart JS -->
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        
        
        <!-- My Datatable libraries -->
        <!-- DataTables CSS -->
        <link href="<?= base_url('public_html/high_admin_assests/css/plugins/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css'); ?>" rel="stylesheet">

        <!-- DataTables Responsive CSS -->
        <link href="<?= base_url('public_html/high_admin_assests/css/plugins/datatables-responsive/css/dataTables.responsive.css'); ?>" rel="stylesheet">
        
        <!-- DataTables JavaScript -->
        <script src="<?php echo base_url('public_html/high_admin_assests/css/plugins/DataTables/media/js/jquery.dataTables.min.js'); ?>"></script>
        <script src="<?php echo base_url('public_html/high_admin_assests/css/plugins/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js'); ?>"></script>
        <!-- ./My Datatable libraries -->
        
        <!-- MY JS -->
        <script type="text/javascript" src="<?= base_url("public_html/jscode/customer_js/customer.js") ?>"></script>
        
        <style type="text/css">
            body {
                padding-top: 60px;
            }
        </style>

        <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
          <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->


        <!-- Google Fonts call. Font Used Open Sans & Raleway -->
        <link href="http://fonts.googleapis.com/css?family=Raleway:400,300" rel="stylesheet" type="text/css">
        <link href="http://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet" type="text/css">

        <script type="text/javascript">
            $(document).ready(function () {

                $("#btn-blog-next").click(function () {
                    $('#blogCarousel').carousel('next')
                });
                $("#btn-blog-prev").click(function () {
                    $('#blogCarousel').carousel('prev')
                });

                $("#btn-client-next").click(function () {
                    $('#clientCarousel').carousel('next')
                });
                $("#btn-client-prev").click(function () {
                    $('#clientCarousel').carousel('prev')
                });

            });

            $(window).load(function () {

                $('.flexslider').flexslider({
                    animation: "slide",
                    slideshow: true,
                    start: function (slider) {
                        $('body').removeClass('loading');
                    }
                });
            });

        </script>    
    </head>
    <body>
        
        <!-- hidden csrf -->
        <input type="hidden" class="csrf_input_class" name="<?=$this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>">
        <!-- /hidden csrf -->
        <!-- hidden base url -->
        <input type="hidden" class="base_url_class" value="<?=base_url()?>">
        <!-- /hidden base url -->

        <!-- NAVIGATION MENU -->

        <div class="navbar-nav navbar-inverse navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="<?= base_url() ?>"><img src="<?= base_url("public_html/img/logo.png") ?>" alt="Seoera" title="Seoera Company"></a>
                </div> 
                <div class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">
                        
                        <li class="active"><a href="<?= base_url('customer/dashboard') ?>"><i class="icon-home icon-white"></i> Home </a></li>      
                        <li><a href="<?= base_url('customer/tasks') ?>"><i class="icon-lock icon-white"></i> Tasks </a></li>
                        <li><a href="<?= base_url('customer/tasks/tasks_activities') ?>"><i class="icon-lock icon-white"></i> Tasks Activities </a></li>
                        
                    </ul>
                </div><!--/.nav-collapse -->
            </div>
        </div>


        <div class="container" style="margin-top: 34px;">
            
            <?= $subview ?>

        </div>

        <div id="footerwrap">
            <footer class="clearfix"></footer>
            <div class="container">
                <div class="row">
                    <div class="col-sm-12 col-lg-12">
                        <p><img src="<?= base_url("public_html/img/logo.png") ?>" alt="Seoera" title="Seoera Company"></p>
                        <p>Seoera &copy; Copyright 2016</p>
                    </div>

                </div><!-- /row -->
            </div><!-- /container -->		
        </div><!-- /footerwrap -->

    </body></html>