<!DOCTYPE html>
<html lang="th">
<head>
    <title><?php echo $s;?></title>
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

    <!-- JS Script -->
    <script src="<?php echo base_url(); ?>application/modules/common/assets/vendor/jquery/jquery.js"></script>
    <script src="<?php echo base_url(); ?>application/modules/common/assets/vendor/bootstrap/js/bootstrap.min.js"></script>
    <!-- JS Custom AdaSoft -->
    <script src="<?php echo base_url(); ?>application/modules/common/assets/src/jCommon.js"></script>
    <script src="<?php echo base_url(); ?>application/modules/common/assets/src/jPageControll.js"></script>
    <script src="<?php echo base_url(); ?>application/modules/common/assets/src/jBrowseModal_New.js"></script>
    <script src="<?php echo base_url(); ?>application/modules/common/assets/src/jAjaxErrorHandle.js"></script>
    <script src="<?php echo base_url(); ?>application/modules/common/assets/src/jTempImage.js"></script>
    <style>
  /* body{
      padding:20px 5%;
  } */
  th{
      border-bottom:1px solid;
      border-top:1px solid;
  }
  th,td{
      padding: 5px 0px 5px 0px;
      /* font-size:17px; */
  }
  .number{
      text-align:right;
  }
  table{
      width:100%;
  }
  .sum-footer{
      text-align:left;
  }
  .pagination{
      font-size:12px;
      padding: 7px 0px;
      /* border:1px solid #333; */
  }
</style>
</head>
<body class="xCNBody">
    <style>
        .xWRptNavGroup{
            padding: 12px 15px !important
        }

        .xWBTNRptPrintPreview {
            width: 40%;
            font-size: 20px;
        }

        #odvRvwMainMenu{
            margin-top:70px;
        }
    </style>
    <nav class="navbar navbar-default navbar-fixed-top" style="height:70px;">
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
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                    <div class="xWPageReport btn-toolbar pull-right" style="padding:20px 29px;">
                         <!-- <?php if($aDataReport['rnCurrentPage'] == 1){ $tDisabledLeft = 'disabled'; }else{ $tDisabledLeft = '-';} ?>  -->
                        <button onclick="JCNvReportClickPage('previous')" class="btn btn-white btn-sm" <?php echo $tDisabledLeft ?>>
                            <i class="fa fa-chevron-left f-s-14 t-plus-1"></i>
                        </button>
                        
                         <!-- <?php for($i = max($aDataReport['rnCurrentPage']-2, 1); $i<=max(0, min($aDataReport['rnAllPage'],$aDataReport['rnCurrentPage']+2)); $i++):?>
                            <?php 
                                if($aDataReport['rnCurrentPage'] == $i){ 
                                    $tActive = 'active'; 
                                    $tDisPageNumber = 'disabled';
                                }else{ 
                                    $tActive = '';
                                    $tDisPageNumber = '';
                                }
                            ?> 
                            <button onclick="JCNvReportClickPage('<?php echo $i?>')" type="button" class="btn xCNBTNNumPagenation <?php echo $tActive ?>" <?php echo $tDisPageNumber ?>><?php echo $i?></button>
                        <?php endfor; ?> -->

                         <!-- <?php if($aDataReport['rnCurrentPage'] >= $aDataReport['rnAllPage']){  $tDisabledRight = 'disabled'; }else{  $tDisabledRight = '-';  } ?> -->
                        <button onclick="JCNvReportClickPage('next')" class="btn btn-white btn-sm" <?php echo $tDisabledRight ?>>
                            <i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </nav>    
    <div class="odvMainContent main">
        <input type="hidden" class="form-control" id="ohdRptTypeExport" name="ohdRptTypeExport" value="<?php /*echo $tRptTypeExport;*/?>">
        <input type="hidden" class="form-control" id="ohdRptTypeExport" name="ohdRptCode" value="<?php /*echo $tRptCode;*/?>">
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
                            <!-- <?php print_r($aFilterReport)?> -->
                        <table width="100%" border=0>
                            <tr valign="top">
                                    <td width="100%" align=center colspan=2><b style="font-size:25px;">
                                        <?php echo $aDataTextRef['tTitleReport'];?></b><br>
                                    </td>
                            </tr>
                            <tr valign="top">
                                <td width="50%" align=left>
                                    บริษัท: <?php print_r($DataCom['tCompName']) ; ?><br>
                                    <?php print_r($DataCom['tHomeNO']." ".$DataCom['tSoi']." ".$DataCom['tSubName']) ;?><br>
                                    <?php print_r($DataCom['tDstName']." ".$DataCom['tPrvName']." ".$DataCom['tPostCode']);?><br>
                                    Tel.: <?php print_r($DataCom['tTel']) ; ?><br>
                                    Fax.: <?php print_r($DataCom['tFax']) ; ?><br>
                                    Branch : <?php print_r($DataCom['tBchName']) ; ?>
                                </td>
                                <td width="50%" align=left>
                                        <?php 
                                            if(!empty($aFilterReport['tDocDateFrom']) && !empty($aFilterReport['tDocDateTo'])){
                                            echo $aDataTextRef['tRptDateFrom'].' : '.$aFilterReport['tDocDateFrom'].' '.$aDataTextRef['tRptDateTo'].' : '.$aFilterReport['tDocDateTo'];         
                                        }?>  
                                </td>
                            </tr>
                            <tr>
                                    <?php  $tLabeDataPrint = $aDataTextRef['tRptDatePrint'].' : '.date('Y-m-d');
                                            $tLabeTimePrint = $aDataTextRef['tRptTimePrint'].' : '.date('H:i:s');
                                    ?>
                                    <td width="100%" colspan=2 align=right><?php echo $tLabeDataPrint.' '.$tLabeTimePrint ?></td>
                            
                            </tr>
                        </table>
                        <table cellspacing="0">
                        <tr style="background-color:#CFE2F3">
                            <th width="30%">ร้านค้า</th>
                            <th width="40%">ตู้ล็อกเกอร์</th>
                            <th width="15%">ขนาด</th>
                            <th width="15%">จำนวนบิล(ฝาก)</th>
                        </tr>
                        <?php if(!empty($DataSource['aRptData'])){?>
                        <?php
                        $nSumQty = 0;
                        $nSumDis = 0;
                        $nSumNet = 0;
                        $nSumFooterQty = 0;
                        $nSumFooterDis = 0;
                        $nSumFooterNet = 0;
                        foreach ($DataSource['aRptData'] as $key=>$value) { ?>
                            
                                    <?php
                                        // echo '<pre>';
                                        // print_r($value);
                                        // Step 1 เตรียม Parameter สำหรับการ Groupping
                                        $tShpName = $value["FTShpName"];  
                                        $tPosCode = 'POS '.$value["FTPosCode"]; 

                                        $nGroupMember = $value["Qtybill"]; 
                                        $nRowPartID = $value["FNRowPartID"]; 
                                    ?>
                                    <?php
                                        //Step 2 Groupping data
                                        $aGrouppingData = array($tShpName,$tPosCode);
                                        // Parameter
                                        //$nRowPartID = ลำดับตามกลุ่ม
                                        //$aGrouppingData = ข้อมูลสำหรับ Groupping
                                        FCNtHRPTHeadGroupping($nRowPartID,$aGrouppingData);
                                        //   $CI->FCNMtRPTHeadGroupping($nRowPartID,$aGrouppingData);
                                    //    $Sum = $this->$CI->FCNMtRPTSum(5,10);
                                    //    echo '=='.$Sum; exit();
                                    ?>
                                    <!-- Step 2 แสดงข้อมูลใน TD -->
                                    <tr>
                                    
                                        <td></td>
                                        <td><?php echo $value["FTPosCode"];?></td>
                                        <td class="number" style="text-align:center;"><?php echo $value["FTPzeName"];?></td>
                                        <td class="number"><?php echo $value["FTXhdQty"];?></td>
                                    </tr>
                        <?php
                        //Step 3 : เตรียม Parameter สำหรับ Summary SubFooter
                        $nSumQty = $value["Qtybill_All"];
                        $aSumFooter = array('รวม','N','N',$nSumQty);
                        //Step 4 : สั่ง Summary SubFooter
                        //Parameter 
                        //$nGroupMember = จำนวนข้อมูลทั้งหมดในกลุ่ม
                        //$nRowPartID = ลำดับข้อมูลในกลุ่ม
                        //$aSumFooter =  ข้อมูล Summary SubFooter
                        $nStaNewGroup = FCNtHRPTSumSubFooter($nGroupMember,$nRowPartID,$aSumFooter);
                            //Step 5 เตรียม Parameter สำหรับ SumFooter
                        //    $nSumFooterQty = number_format($value["FCSdtQtyFooter"]);
                        //    $nSumFooterDis = number_format($value["FCSdtDisFooter"],2);
                        //    $nSumFooterNet = number_format($value["FCSdtNetFooter"],2);

                        //    $paFooterSumData = array('รวมทั้งสิ้น','N','N','N',$nSumFooterQty,'N',$nSumFooterDis,$nSumFooterNet);
                        ?>
                        <?php } // End for ?>
                        <?php 
                        $nPageNo = $DataSource["aPagination"]["nDisplayPage"];
                        $nTotalPage = $DataSource["aPagination"]["nTotalPage"];
                        //    //Step 6 : สั่ง Summary Footer
                        //    $CI->FCNMtRPTSumFooter($nPageNo,$nTotalPage,$paFooterSumData);
                        ?>
                        </table>
                                <!-- แสดงข้อมูล Footer -->
                                <div class="pagination">
                                    <div class="row">
                                        <div class="col-6">
                                            พบข้อมูล    <?php echo $DataSource["aPagination"]["nTotalRecord"];?> รายการ 
                                            แสดงหน้า    <?php echo $DataSource["aPagination"]["nDisplayPage"];?>  /  
                                                        <?php echo $DataSource["aPagination"]["nTotalPage"];?>
                                        </div>
                                        <div class="col-6">
                                            <?php 
                                                $nCurrentPage = $DataSource["aPagination"]["nDisplayPage"]; 
                                                for($p = 1;$p <= $DataSource["aPagination"]["nTotalPage"];$p++){
                                            ?>
                                            <!-- <?php  $tPage="rptDpsSize"; ?>
                                            <a href="<?=base_url($tPage.'/'.$p)?>"> [<?=$p?>] </a>  -->
                                            <?php } ?>
                                        </div>
                                    </div>

                                </div>
                                <!-- จบแสดงข้อมูล Footer -->
                        <?php } else {
                        // echo "Empty";
                        }
                        ?>
                </div>
            </div>
        </div>
    </div>


    <form id="ofmRptSubmitClickPage" method="post" target="_self">
        <input type="hidden" class="form-control" id="ohdRptRoute" name="ohdRptRoute" value="<?php /*echo $tRptRoute;*/?>">
        <input type="hidden" class="form-control" id="ohdRptCode" name="ohdRptCode" value="<?php /*echo $tRptCode;*/?>">
        <input type="hidden" class="form-control" id="ohdRptTypeExport" name="ohdRptTypeExport" value="<?php /*echo $tRptTypeExport;*/?>">
        <input type="hidden" class="form-control" id="ohdRptDataFilter" name="ohdRptDataFilter" value="<?php /*echo htmlspecialchars(json_encode($aDataFilter));*/?>">
        <input type="hidden" class="form-control" id="ohdRptCurrentPage" name="ohdRptCurrentPage" value="<?php /*echo $aDataReport['rnCurrentPage'];*/?>">
    </form>

    <!-- Overlay Data Viewer -->
    <div class="xCNOverlayLodingData" style="z-index: 7000;">
        <img src="<?php echo base_url();?>application/modules/common/assets/images/ada.loading.gif" class="xWImgLoading">
        <div id="odvOverLayContentForLongTimeLoading" style="display: none;"><?php echo language('common/main/main', 'tLodingDataReport'); ?></div>
    </div>
    

    <script type="text/javascript">
        // Function Click Page
        function JCNvReportClickPage(ptPage){
            var nPageCurrent = '';
            switch (ptPage) {
                case 'next': //กดปุ่ม Next
                    // $('.xWBtnNext').addClass('disabled');
                    nPageOld = $('.xWPageReport .active').text(); // Get เลขก่อนหน้า
                    nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
                    nPageCurrent = nPageNew
                    break;
                case 'previous': //กดปุ่ม Previous
                    nPageOld = $('.xWPageReport .active').text(); // Get เลขก่อนหน้า
                    nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
                    nPageCurrent = nPageNew
                    break;
                default:
                    nPageCurrent = ptPage
            }
            JCNvCallDataReportPageClick(nPageCurrent);
        }

        // Function Call Data Rpt
        function JCNvCallDataReportPageClick(pnPageCurrent){
            JCNxOpenLoadingData();
            var tRptRote = $('#ohdRptRoute').val();
            console.log('tRptRote: ', tRptRote);
            $('#ohdRptCurrentPage').val(pnPageCurrent);
            $('#ofmRptSubmitClickPage').attr('action',tRptRote+'ClickPage');
            $('#ofmRptSubmitClickPage').submit();
            $('#ofmRptSubmitClickPage').attr('action','javascript:void(0)');
            JCNxCloseLoadingData();
        }
    </script>
</body>

</html>

