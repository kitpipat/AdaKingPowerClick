<!DOCTYPE html>
<html lang="th">
<head>
    <title><?php echo $tTitleReport;?></title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0,maximum-scale=1.0, user-scalable=0"/>

    <!-- ICONS -->
    <link rel="apple-touch-icon" sizes="76x76" href="<?php echo base_url(); ?>application/modules/common/assets/images/AdaLogo.png">
    <link rel="icon" type="image/png" sizes="96x96" href="<?php echo base_url(); ?>application/modules/common/assets/images/AdaLogo.png">
    <!-- CSS -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>application/modules/common/assets/vendor/bootstrap/css/bootstrap.min.css"> 
    <link rel="stylesheet" href="<?php echo base_url(); ?>application/modules/common/assets/vendor/bootstrap/css/bootstrap.custom.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>application/modules/common/assets/vendor/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>application/modules/common/assets/vendor/linearicons/style.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>application/modules/common/assets/vendor/chartist/css/chartist-custom.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>application/modules/common/assets/css/bootstrap.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>application/modules/common/assets/css/bootstrap-datepicker.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>application/modules/common/assets/css/cropper.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>application/modules/common/assets/css/bootstrap-colorpicker.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>application/modules/common/assets/css/globalcss/ContactFrom/main.css">
    <link rel="stylesheet" href="<?php echo base_url('application/modules/common/assets/vendor/loading-bar/loading-bar.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url(); ?>application/modules/common/assets/css/main.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>application/modules/common/assets/css/demo.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>application/modules/common/assets/css/localcss/ada.layout.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>application/modules/common/assets/css/localcss/ada.menu.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>application/modules/common/assets/css/localcss/ada.fonts.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>application/modules/common/assets/css/localcss/ada.component.css">

    <!-- Report CSS LayOut -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>application/modules/report/assets/css/localcss/ada.rptlayout.css">

    <!-- JS Script -->
    <script src="<?php echo base_url(); ?>application/modules/common/assets/vendor/jquery/jquery.js"></script>
    <script src="<?php echo base_url(); ?>application/modules/common/assets/vendor/bootstrap/js/bootstrap.min.js"></script>
    <!-- JS Custom AdaSoft -->
    <script src="<?php echo base_url(); ?>application/modules/common/assets/src/jCommon.js"></script>
    <script src="<?php echo base_url(); ?>application/modules/common/assets/src/jPageControll.js"></script>
    <script src="<?php echo base_url(); ?>application/modules/common/assets/src/jAjaxErrorHandle.js"></script>
    <script src="<?php echo base_url(); ?>application/modules/common/assets/src/jTempImage.js"></script>
</head>
<style>
    .xWBTNRptPrintPreview{
        width       : 20% !important;
        font-size   : 17px;
    }
</style>
<body class="xCNBody">
    <nav id="odvNavMenuReport" class="navbar navbar-default navbar-fixed-top">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                    <div class="xWRptNavGroup">
                        <button type="button" id="obtPrintViewHtml" class="btn btn-primary xWBTNRptPrintPreview">
                            <?php echo language('report/report/report','tRptPrintHtml');?>
                        </button>
                        <script type="text/javascript">
                            $('#obtPrintViewHtml').click(function(){
                                $(this).hide();
                                window.print();
                                $(this).show();
                            });
                        </script>
                    </div>
                </div>
                <div class="xCNFooterReport">
                    <div class="row">
                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                            <div class="xWPageReport btn-toolbar pull-right" style="padding:20px 29px;">
                                <?php if($aDataReport['rnCurrentPage'] == 1){ $tDisabledLeft = 'disabled'; }else{ $tDisabledLeft = '-';} ?>
                                <button onclick="JSvClickPageReport('first')" class="btn btn-white btn-sm" <?php echo $tDisabledLeft ?> style="padding: 2px 10px;">
                                    <span style="font-size: 15px !important; color: black; font-weight: bold;">First</span>
                                </button>
                                <button onclick="JSvClickPageReport('previous')" class="btn btn-white btn-sm" <?php echo $tDisabledLeft ?> style="padding: 2px 10px;">
                                    <span style="font-size: 15px !important; color: black; font-weight: bold;"><</span>
                                </button>
                                <?php for($i=max($aDataReport['rnCurrentPage']-2, 1); $i<=max(0, min($aDataReport['rnAllPage'],$aDataReport['rnCurrentPage']+2)); $i++){?>
                                    <?php 
                                        if($aDataReport['rnCurrentPage'] == $i){ 
                                            $tActive = 'active'; 
                                            $tDisPageNumber = 'disabled';
                                        }else{ 
                                            $tActive = '';
                                            $tDisPageNumber = '';
                                        }
                                    ?>
                                    <button onclick="JSvClickPageReport('<?php echo $i?>')" type="button" class="btn xCNBTNNumPagenation <?php echo $tActive ?>" <?php echo $tDisPageNumber ?>><?php echo $i?></button>
                                <?php } ?>
                                <?php if($aDataReport['rnCurrentPage'] >= $aDataReport['rnAllPage']){  $tDisabledRight = 'disabled'; }else{  $tDisabledRight = '-';  } ?>
                                <button onclick="JSvClickPageReport('next')" class="btn btn-white btn-sm" <?php echo $tDisabledRight ?> style="padding: 2px 10px;">
                                    <span style="font-size: 15px !important; color: black; font-weight: bold;">></span>
                                </button>
                                <button onclick="JSvClickPageReport('last')" class="btn btn-white btn-sm" <?php echo $tDisabledRight ?> style="padding: 2px 10px;">
                                    <span style="font-size: 15px !important; color: black; font-weight: bold;">Last</span>
                                </button>    
                            </div>
                        </div>
                    </div>             
                </div>
            </div>
        </div>
    </nav>    
    <div class="odvMainContent main">
        <input type="hidden" class="form-control" id="ohdRptTypeExport" name="ohdRptTypeExport" value="<?php echo $tRptTypeExport;?>">
        <input type="hidden" class="form-control" id="ohdRptTypeExport" name="ohdRptCode" value="<?php echo $tRptCode;?>">
        <div id="odvRvwMainMenu" class="main-menu clearfix">
            <div class="xCNMrgNavMenu">
                <div class="row xCNavRow">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <ol id="oliMenuNav" class="breadcrumb xCNBCMenu">
                            <li id="oliRptTitle"><?php echo language('report/report/report','tRptViewer') ?></li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="xCNMenuCump xCNRvwBrowseLine" id="odvMenuCump">
        </div>
        <div class="main-content">
            <div id="odvContentPageRptViewer" class="panel panel-headline"> 
                <div class="panel-body">
                    <?php if(isset($tViewRenderKool) && !empty($tViewRenderKool)):?>
                        <?php echo $tViewRenderKool;?>  
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <form id="ofmRptSubmitClickPage" method="post" target="_self">
        <input type="hidden" class="form-control" id="ohdRptRoute" name="ohdRptRoute" value="<?php echo $tRptRoute;?>">
        <input type="hidden" class="form-control" id="ohdRptCode" name="ohdRptCode" value="<?php echo $tRptCode;?>">
        <input type="hidden" class="form-control" id="ohdRptTypeExport" name="ohdRptTypeExport" value="<?php echo $tRptTypeExport;?>">
        <input type="hidden" class="form-control" id="ohdRptDataFilter" name="ohdRptDataFilter" value="<?php echo htmlspecialchars(json_encode($aDataFilter));?>">
        <input type="hidden" class="form-control" id="ohdRptCurrentPage" name="ohdRptCurrentPage" value="<?php echo $aDataReport['rnCurrentPage'];?>">
    </form>

    <!-- Overlay Data Viewer -->
    <div class="xCNOverlayLodingData" style="z-index: 7000;">
        <img src="<?php echo base_url();?>application/modules/common/assets/images/ada.loading.gif" class="xWImgLoading">
        <div id="odvOverLayContentForLongTimeLoading" style="display: none;"><?php echo language('common/main/main', 'tLodingDataReport'); ?></div>
    </div>
    
    <script>
        //Next page by report
        function JSvClickPageReport(ptPage){
            var nAllPage = '<?=$aDataReport['rnAllPage']?>';
            var nPageCurrent = '';
            switch (ptPage) {
                case 'next': //กดปุ่ม Next
                    $('.xWBtnNext').addClass('disabled');
                    nPageOld = $('.xWPageReport .active').text(); // Get เลขก่อนหน้า
                    nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
                    nPageCurrent = nPageNew;
                    break;
                case 'previous': //กดปุ่ม Previous
                    nPageOld = $('.xWPageReport .active').text(); // Get เลขก่อนหน้า
                    nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
                    nPageCurrent = nPageNew;
                    break;
                case 'first': //กดปุ่ม First
                    nPageCurrent = 1;
                    break;
                case 'last': //กดปุ่ม Last
                    nPageCurrent = nAllPage;
                    break;    
                default:
                    nPageCurrent = ptPage;
            }

            JCNvCallDataReportPageClick(nPageCurrent);
        }
    </script>
            
    <script type="text/javascript">
        // Function Call Data Rpt
        function JCNvCallDataReportPageClick(pnPageCurrent){
            var tRptRote = $('#ohdRptRoute').val();
            $('#ohdRptCurrentPage').val(pnPageCurrent);
            $('#ofmRptSubmitClickPage').attr('action',tRptRote+'ClickPage');
            $('#ofmRptSubmitClickPage').submit();
            $('#ofmRptSubmitClickPage').attr('action','javascript:void(0)');
        }
    </script>
</body>

</html>













