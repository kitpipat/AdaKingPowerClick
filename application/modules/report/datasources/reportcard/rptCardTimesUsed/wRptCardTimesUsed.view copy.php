<?php
    date_default_timezone_set("Asia/Bangkok");
    use \koolreport\widgets\koolphp\Table;
    $tBaseUrl       = $this->params['tBaseUrl'];
    $tCallView      = $this->params['tCallView'];
    $aDataTextRef   = $this->params['aDataTextRef'];
    $tLabelTax      = $aDataTextRef['tRPCTaxNo'].' : '.$this->params['tBchTaxNo'];
    $tLabeDataPrint = $aDataTextRef['tRPCDatePrint'].' : '.date('Y-m-d');
    $tLabeTimePrint = $aDataTextRef['tRPCTimePrint'].' : '.date('H:i:s');
    $tBtnPrint      = $aDataTextRef['tRPCPrintHtml'];
    $tCompAndBranch = $this->params['tCompName'].' ( '.$this->params['tBchName'].' )';
    $tAddressLine   = $this->params['tAddressLine1'].' '.$this->params['tAddressLine2'];
    $aFilterReport  = $this->params['aFilterReport'];
    @$aDataReport = $this->params['aDataReport'];
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <title><?php echo $aDataTextRef['tTitleReport']?></title>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0,maximum-scale=1.0, user-scalable=0">
    <?php if($tCallView == 'html') : ?>
        <link rel="stylesheet" href="<?php echo $tBaseUrl.'application/assets/css/localcss/ada.layout.css'?>">
        <link rel="stylesheet" href="<?php echo $tBaseUrl.'application/assets/css/localcss/ada.menu.css'?>">
        <link rel="stylesheet" href="<?php echo $tBaseUrl.'application/assets/css/localcss/ada.fonts.css'?>">
        <link rel="stylesheet" href="<?php echo $tBaseUrl.'application/assets/css/localcss/ada.component.css'?>">
        <link rel="apple-touch-icon" sizes="76x76" href="<?php echo $tBaseUrl; ?>application/assets/img/apple-icon.png">
        <link rel="icon" type="image/png" sizes="96x96" href="<?php echo $tBaseUrl; ?>application/assets/img/favicon.png">	
    <?php endif; ?>
</head>
<body>
    <?php if($tCallView == 'pdf') :
        $tResponsive = "";
    ?>
        <style>
            table tr td, table thead tr th{
                border: 1px solid #cccccc !important;   
                background-color: #ffffff;    
            }
            #ostReportUseCard, table tr td, table thead tr th{
                font-family: "Garuda";
                font-size: 8pt;
                padding: 10px;
            }
        </style>
    <?php else: 
        $tResponsive = "table-responsive";
    ?>
    <?php endif; ?>
    <section id="ostReportCardTimesUsed">
        <div class="container-fluid xCNLayOutRptHtml">
            <div class="xCNHeaderReport">
                <div class="row">
                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                        <div class="text-left">
                            <label class="xCNRptLabel"><?php echo $tCompAndBranch; ?></label>
                        </div>
                        <div class="text-left">
                            <label class="xCNRptLabel"><?php echo $tAddressLine; ?></label>
                        </div>
                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                        <div class="text-center">
                            <label class="xCNRptTitle"><?php echo $aDataTextRef['tTitleReport'];?></label>
                        </div>
                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                        <div class="text-right">
                            <?php if($tCallView == 'html'):?> 
                                <button type="button" id="obtPrintViewHtml" class="btn btn-primary" stype="font-size: 17px;width: 100%;"><?php echo $tBtnPrint ?></button>
                                <script type="text/javascript">
                                    $('#obtPrintViewHtml').click(function(){
                                        $(this).hide();
                                        window.print();
                                        $(this).show();
                                    });
                                </script>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div id="odvFilterReport" class="row">
                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                        <!-- Filter Card Type Code -->
                        <?php if(!empty($aFilterReport['tCardTypeCodeFrom']) && !empty($aFilterReport['tCardTypeCodeTo'])):?>
                            <div class="text-left">
                                <label class="xCNRptLabel">
                                    <?php echo $aDataTextRef['tRPCCrdTypeFrom'].' : '.$aFilterReport['tCardTypeNameFrom'].' '.$aDataTextRef['tRPCCrdTypeTo'].' : '.$aFilterReport['tCardTypeNameTo'];?>
                                </label>
                            </div>
                        <?php endif;?>
                        
                        <!-- Filter Card Code -->
                        <?php if(!empty($aFilterReport['tCardCodeFrom']) && !empty($aFilterReport['tCardCodeTo'])):?>
                            <div class="text-left">
                                <label class="xCNRptLabel">
                                    <?php echo $aDataTextRef['tRPCCrdFrom'].' : '.$aFilterReport['tCardCodeFrom'].' '.$aDataTextRef['tRPCCrdTo'].' : '.$aFilterReport['tCardCodeTo'];?>
                                </label>
                            </div>
                        <?php endif;?>
                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                        <div class="text-right">
                            <label class="xCNRptLabel"><?php echo $tLabelTax.' '.$tLabeDataPrint.' '.$tLabeTimePrint ?></label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="xCNContentReport">
                <div class="<?php echo $tResponsive ?>">
                    <?php
                        Table::create(array(
                            "dataSource"    => $this->dataStore("RptCardTimesUsed"),
                            "cssClass"      => array(
                                "table"     => "table table-bordered",
                                "th"        => "xCNReportTBHeard",
                                "td"        => "xCNReportTBData"
                            ),
                            "columns"       => array(
                                'rtRowID'       => array(
                                    "label"     => $aDataTextRef['tRPC7TBRowNuber'],
                                    "cssStyle"  => "text-align:center"
                                ),
                                'TimesUsage'    => array(
                                    "label"     => $aDataTextRef['tRPC7TBTimesUsage'],
                                    "cssStyle"  => "text-align:center"
                                ),
                                'FTCrdCode'     => array(
                                    "label"     => $aDataTextRef['tRPC7TBCardCode'],
                                ),
                                'FTCtyName'     => array(
                                    "label"     => $aDataTextRef['tRPC7TBCardType'],
                                ),
                                'FTCrdName'     => array(
                                    "label"     => $aDataTextRef['tRPC7TBCardName'],
                                ),
                                'FTCrdHolderID' => array(
                                    "label"     => $aDataTextRef['tRPC7TBCardHolderID'],
                                ),
                                'FTDptName'     => array(
                                    "label"     => $aDataTextRef['tRPC7TBDepartName'],
                                ),
                                'FTCrdRemark'   => array(
                                    "label"     => $aDataTextRef['tRPC7TBRemark'],
                                ),
                            ),
                        ));
                    ?>
                </div>
            </div>
            <?php if($tCallView == 'html') : ?>
            <div class="xCNFooterReport">
                <div class="row">
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                        <p><?= language('common/main','tResultTotalRecord')?> <?=$aDataReport['rnAllRow']?> <?= language('common/main','tRecord')?> <?= language('common/main','tCurrentPage')?> <?=$aDataReport['rnCurrentPage']?> / <?=$aDataReport['rnAllPage']?></p>
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                        <div class="xWPageCard btn-toolbar pull-right">
                            <?php if($aDataReport['rnCurrentPage'] == 1){ $tDisabledLeft = 'disabled'; }else{ $tDisabledLeft = '-';} ?>
                            <button onclick="JSvClickPageCardActiveSummary('first')" class="btn btn-white btn-sm" <?php echo $tDisabledLeft ?> style="padding: 2px 10px;">
                                <span style="font-size: 15px !important; color: black; font-weight: bold;">First</span>
                            </button>
                            <button onclick="JSvClickPageCardActiveSummary('previous')" class="btn btn-white btn-sm" <?php echo $tDisabledLeft ?> style="padding: 2px 10px;">
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
                                <button onclick="JSvClickPageCardActiveSummary('<?php echo $i?>')" type="button" class="btn xCNBTNNumPagenation <?php echo $tActive ?>" <?php echo $tDisPageNumber ?>><?php echo $i?></button>
                            <?php } ?>
                            <?php if($aDataReport['rnCurrentPage'] >= $aDataReport['rnAllPage']){  $tDisabledRight = 'disabled'; }else{  $tDisabledRight = '-';  } ?>
                            <button onclick="JSvClickPageCardActiveSummary('next')" class="btn btn-white btn-sm" <?php echo $tDisabledRight ?> style="padding: 2px 10px;">
                                <span style="font-size: 15px !important; color: black; font-weight: bold;">></span>
                            </button>
                            <button onclick="JSvClickPageCardActiveSummary('last')" class="btn btn-white btn-sm" <?php echo $tDisabledRight ?> style="padding: 2px 10px;">
                                <span style="font-size: 15px !important; color: black; font-weight: bold;">Last</span>
                            </button>    
                        </div>
                    </div>
                </div>             
            </div>
            <script>
                //Next page by report
                function JSvClickPageCardActiveSummary(ptPage){
                    var nAllPage = '<?=$aDataReport['rnAllPage']?>';
                    var nPageCurrent = '';
                    switch (ptPage) {
                        case 'next': //กดปุ่ม Next
                            $('.xWBtnNext').addClass('disabled');
                            nPageOld = $('.xWPageCard .active').text(); // Get เลขก่อนหน้า
                            nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
                            nPageCurrent = nPageNew;
                            break;
                        case 'previous': //กดปุ่ม Previous
                            nPageOld = $('.xWPageCard .active').text(); // Get เลขก่อนหน้า
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

                    var urlParams = new URLSearchParams(window.location.search);
                        urlParams.set('nPage', nPageCurrent);
                    var tURL        = urlParams.toString();
                    
                    var tFullUrl    = window.location.href;
                    var tFullUrl    = tFullUrl.split("?");
                    window.location.href = tFullUrl[0] + '?' + tURL;
                }
            </script>
            <?php endif; ?>
        </div>    
    </section>
    
</body>
</html>
