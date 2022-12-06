<!-- Last Update : Napat(Jame) 25/11/2022 เพิ่มการเรียกใช้งาน jquery.cookie.js -->

<!doctype html>
<html lang="th" class="fullscreen-bg">
    <head>
        <title><?php echo BASE_TITLE; ?></title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">

        <!-- ICONS -->
        <link rel="apple-touch-icon" sizes="76x76" href="<?php echo base_url(); ?>application/modules/common/assets/images/AdaLogo-ico.ico?v=1">
        <link rel="icon" type="image/png" sizes="96x96" href="<?php echo base_url(); ?>application/modules/common/assets/images/AdaLogo-ico.ico?v=1">

        <!-- VENDER CSS -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>application/modules/common/assets/vendor/bootstrap/css/bootstrap.min.css"> 
        <link rel="stylesheet" href="<?php echo base_url(); ?>application/modules/common/assets/vendor/bootstrap/css/bootstrap.custom.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>application/modules/common/assets/vendor/font-awesome/css/font-awesome.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>application/modules/common/assets/vendor/linearicons/style.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>application/modules/common/assets/vendor/chartist/css/chartist-custom.css">

        <link rel="stylesheet" href="<?php echo base_url(); ?>application/modules/common/assets/css/bootstrap.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>application/modules/common/assets/css/bootstrap-datepicker.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>application/modules/common/assets/css/cropper.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>application/modules/common/assets/css/bootstrap-colorpicker.min.css">

        <!-- Bootstrap-Select --> 
        <!-- <link rel="stylesheet" href="<?php echo base_url(); ?>application/modules/common/assets/vendor/bootstrap-select-1.13.2/dist/css/bootstrap-select.min.css"> -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>application/modules/common/assets/vendor/bootstrap-select-1.13.14/dist/css/bootstrap-select.min.css">

        <!-- WOW Style CSS -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>application/modules/common/assets/vendor/wow-master/animate.css">
        
        <!-- Loading Bar Style CSS -->
	    <link rel="stylesheet" href="<?php echo base_url('application/modules/common/assets/vendor/loading-bar/loading-bar.css'); ?>">
        
        <!-- Input Form CSS (ContactFrom) -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>application/modules/common/assets/css/globalcss/ContactFrom/util.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>application/modules/common/assets/css/globalcss/ContactFrom/main.css">
        <!-- Map OpenLayer Css -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>application/modules/common/assets/vendor/openlayers/ol.css">

        <!-- WaterFall -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>application/modules/common/assets/css/globalcss/Waterfall/demo.css">

        <link rel="stylesheet" href="<?php echo base_url(); ?>application/modules/common/assets/css/multiple-select.css">        
        <link rel="stylesheet" href="<?php echo base_url(); ?>application/modules/common/assets/css/daterangepicker.css">
        

        <!-- MAIN CSS -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>application/modules/common/assets/css/main.css?v1.0.1">
        <!-- FOR DEMO PURPOSES ONLY. You should remove this in your project -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>application/modules/common/assets/css/demo.css">

        <!-- Print JS -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>application/modules/common/assets/js/global/PrintJS/print.min.css">

        <!-- Ada CSS CUSTOM -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>application/modules/common/assets/css/localcss/ada.layout.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>application/modules/common/assets/css/localcss/ada.menu.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>application/modules/common/assets/css/localcss/ada.fonts.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>application/modules/common/assets/css/localcss/ada.component.css?v=1.0.1">
        
        <link rel="stylesheet" href="<?php echo base_url(); ?>application/modules/common/assets/css/globalcss/input.css">

        <!-- jQuery UI -->
        <link rel="stylesheet" href="<?php echo base_url('application/modules/common/assets/vendor/jquery-ui/jquery-ui.css'); ?>">
        

        <!-- Javascript -->
        <input type="hidden" id="ohdBaseURL" name="ohdBaseURL" value="<?php echo base_url(); ?>">
        <script src="<?php echo base_url(); ?>application/modules/common/assets/js/global/Datatables/jquery3.5.1.js"></script>
        <script src="<?php echo base_url(); ?>application/modules/common/assets/js/global/Datatables/jquery.dataTables.min.js"></script>
        <script src="<?php echo base_url(); ?>application/modules/common/assets/js/global/Datatables/dataTables.scroller.min.js"></script>
        <link rel="stylesheet" href="<?php echo base_url(); ?>application/modules/common/assets/js/global/Datatables/jquery.dataTables.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>application/modules/common/assets/js/global/Datatables/scroller.dataTables.min.css">
        <script> var $oNewJqueryVersion = jQuery.noConflict(); </script>


        <script src="<?php echo base_url(); ?>application/modules/common/assets/vendor/jquery/jquery.js"></script>
        <script src="<?php echo base_url(); ?>application/modules/common/assets/vendor/bootstrap/js/bootstrap.min.js"></script>
        <script src="<?php echo base_url(); ?>application/modules/common/assets/js/bootbox.min.js"></script>
        <script src="<?php echo base_url(); ?>application/modules/common/assets/js/jquery.validate.min.js"></script>
        <script src="<?php echo base_url(); ?>application/modules/common/assets/vendor/jquery-slimscroll/jquery.slimscroll.min.js"></script>
        <script src="<?php echo base_url(); ?>application/modules/common/assets/vendor/jquery.easy-pie-chart/jquery.easypiechart.min.js"></script>
        <script src="<?php echo base_url(); ?>application/modules/common/assets/vendor/chartist/js/chartist.min.js"></script>
        <script src="<?php echo base_url(); ?>application/modules/common/assets/vendor/jquery-ui/jquery-ui.js"></script>

        <script src="<?php echo base_url(); ?>application/modules/common/assets/scripts/klorofil-common.js"></script>
        <script src="<?php echo base_url(); ?>application/modules/common/assets/js/cropper.min.js"></script>
        <script src="<?php echo base_url(); ?>application/modules/common/assets/js/moment.js"></script>
        <script src="<?php echo base_url(); ?>application/modules/common/assets/vendor/bootstrap/js/bootstrap-datepicker.js"></script>
        <script src="<?php echo base_url(); ?>application/modules/common/assets/vendor/bootstrap/js/bootstrap-datetimepicker.js"></script>
        <script src="<?php echo base_url(); ?>application/modules/common/assets/vendor/bootstrap/js/bootstrap-timepicker.min.js"></script>
        <script src="<?php echo base_url(); ?>application/modules/common/assets/vendor/textinputeffect/classie.js"></script>
        <script src="<?php echo base_url(); ?>application/modules/common/assets/js/xlsx.full.min.js"></script>
        <script src="<?php echo base_url(); ?>application/modules/common/assets/js/jquery.cookie.js"></script>
        
        
        <style type="text/css">
            .ldBar-label {
                color: #21bd35;
                font-family: tahoma;
                font-size: 2.1em;
                font-weight: 900
            }
            #odvModalInfoMessage, #odvModalWanning, #odvModalError {
                z-index: 10000 !important;
            }
        </style>
    </head>
    <body class="xCNBody layout-fullwidth">




