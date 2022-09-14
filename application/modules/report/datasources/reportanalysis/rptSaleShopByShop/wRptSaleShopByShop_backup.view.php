<?php
    date_default_timezone_set("Asia/Bangkok");
    use \koolreport\widgets\koolphp\Table;
    $tBaseUrl       = $this->params['tBaseUrl'];
    $tCallView      = $this->params['tCallView'];
    $aDataTextRef   = $this->params['aDataTextRef'];
    $tLabelTax      = $aDataTextRef['tRPATaxNo'].' : '.$this->params['tBchTaxNo'];
    $tLabeDataPrint = $aDataTextRef['tRPADatePrint'].' : '.date('Y-m-d');
    $tLabeTimePrint = $aDataTextRef['tRPATimePrint'].' : '.date('H:i:s');
    $tBtnPrint      = $aDataTextRef['tRPAPrintHtml'];
    $tCompAndBranch = $this->params['tCompName'].' ( '.$this->params['tBchName'].' )';

    $tAddressLine   = $this->params['tAddressLine1'].' '.$this->params['tAddressLine2'];
    $aFilterReport  = $this->params['aFilterReport'];
    @$aDataReport = $this->params['aDataReport'];
    @$aSumDataReport = $this->params['aSumDataReport'];
?>
<!DOCTYPE html>
<html lang="th">
    <head>
        <title><?php echo $aDataTextRef['tTitleReport']?></title>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width, initial-scale=1.0,maximum-scale=1.0, user-scalable=0">
        <?php if($tCallView == 'html') : ?>
            <!-- CSS Custom -->
            <link rel="stylesheet" href="<?php echo $tBaseUrl.'application/assets/css/localcss/ada.layout.css'?>">
            <link rel="stylesheet" href="<?php echo $tBaseUrl.'application/assets/css/localcss/ada.menu.css'?>">
            <link rel="stylesheet" href="<?php echo $tBaseUrl.'application/assets/css/localcss/ada.fonts.css'?>">
            <link rel="stylesheet" href="<?php echo $tBaseUrl.'application/assets/css/localcss/ada.component.css'?>">
            <link rel="apple-touch-icon" sizes="76x76" href="<?php echo $tBaseUrl; ?>application/assets/img/apple-icon.png">
            <link rel="icon" type="image/png" sizes="96x96" href="<?php echo $tBaseUrl; ?>application/assets/img/favicon.png">	
        <?php endif; ?>

        <style>
        .xCNFooterRpt {
            border-bottom: 7px double #ddd;
        }

        .table>thead:first-child>tr:nth-child(2)>td,
        .table>thead:first-child>tr:nth-child(2)>th,
        .table>thead:first-child>tr:first-child>td,
        .table>thead:first-child>tr:first-child>th {
            border-top: 1px solid black !important;
            border-bottom: 1px solid black !important;
            background-color: #CFE2F3 !important;
        }

        .table>thead:first-child>tr:first-child>th, .table>thead:first-child>tr:nth-child(2)>th {
            border-left: 0px transparent !important;
            border-right: 0px transparent !important;
        }

        .table>thead:first-child>tr:first-child>th:first-child, .table>thead:first-child>tr:nth-child(2)>th:first-child {
            border-left: 0px solid black !important;
        }

        .table>thead:first-child>tr:first-child>th:last-child, .table>thead:first-child>tr:nth-child(2)>th:last-child {
            border-right: 0px solid black !important;
        }

        .table tbody tr, .table>tbody>tr>td {
            border: 0px transparent !important;
            padding-left: 10px !important;
        }

        .table>thead:first-child>tr:first-child>th:nth-child(1), 
        .table>thead:first-child>tr:first-child>th:nth-child(2), 
        .table>thead:first-child>tr:first-child>th:nth-child(3),
        .table>thead:first-child>tr:first-child>th:nth-child(4),
        .table>thead:first-child>tr:first-child>th:nth-child(5) {
            border-bottom: 0px transparent !important;
        }

        .table>thead:first-child>tr:nth-child(2)>th:nth-child(1), 
        .table>thead:first-child>tr:nth-child(2)>th:nth-child(2),
        .table>thead:first-child>tr:nth-child(2)>th:nth-child(3),
        .table>thead:first-child>tr:nth-child(2)>th:nth-child(4),
        .table>thead:first-child>tr:nth-child(2)>th:nth-child(5) {
            border-top: 0px transparent !important;
        }
        </style>

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
        <section id="ostReportSaleShopByShop">
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
                        <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                            <!-- Filter Branch Code -->
                            <?php if(!empty($aFilterReport['tBchCodeFrom']) && !empty($aFilterReport['tBchCodeTo'])):?>
                                <div class="text-left">
                                    <label class="xCNRptLabel">
                                        <?php echo $aDataTextRef['tRPABchFrom'].' : '.$aFilterReport['tBchNameFrom'].' '.$aDataTextRef['tRPABchTo'].' : '.$aFilterReport['tBchNameTo'];?>
                                    </label>
                                </div>
                            <?php endif;?>
                            <!-- Filter Shop Code -->
                            <?php if(!empty($aFilterReport['tShpCodeFrom']) && !empty($aFilterReport['tShpCodeTo'])):?>
                                <div class="text-left">
                                    <label class="xCNRptLabel">
                                        <?php echo $aDataTextRef['tRPAShopFrom'].' : '.$aFilterReport['tShpNameFrom'].' '.$aDataTextRef['tRPAShopTo'].' : '.$aFilterReport['tShpNameTo'];?>
                                    </label>
                                </div>
                            <?php endif;?>
                            <!-- Filter Date -->
                            <?php if(!empty($aFilterReport['tDateFrom']) && !empty($aFilterReport['tDateTo'])):?>
                                <div class="text-left">
                                    <label class="xCNRptLabel">
                                        <?php echo $aDataTextRef['tRPADateFrom'].' : '.$aFilterReport['tDateFrom'].' '.$aDataTextRef['tRPADateTo'].' : '.$aFilterReport['tDateTo'];?>
                                    </label>
                                </div>
                            <?php endif;?>
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

                    <?php 
                        $bShowFooter = false; // odvTableKoolReport
                        if(($aDataReport['rnCurrentPage'] == $aDataReport['rnAllPage']) || $tCallView == 'pdf') {
                            $bShowFooter = true;
                        } 
                    ?>
                    <div id="odvRptTableAdvance" class="<?php echo $tResponsive ?>">
                        <table class="table">
                                <thead>
                                    <tr>
                                        <th nowrap class="text-left" style="width:10%"><?php echo $aDataTextRef['tRPA2TBBarchCode']; ?></th>
                                        <th nowrap class="text-left" style="width:10%"><?php echo $aDataTextRef['tRPA2TBBarchName']; ?></th>
                                        <th nowrap class="text-left" style="width:10%"><?php echo $aDataTextRef['tRPA2TBShopCode']; ?></th>
                                        <th nowrap class="text-left" style="width:10%"><?php echo $aDataTextRef['tRPA2TBShopName']; ?></th>
                                        <th nowrap class="text-left" style="width:10%"><?php echo $aDataTextRef['tRPA2TBDocDate']; ?></th>
                                        <th nowrap class="text-center" colspan="3"><?php echo $aDataTextRef['tRPA2TBAmount']; ?></th>
                                    </tr>
                                    <tr>
                                        <th nowrap class="text-left" style="width:10%"></th>
                                        <th nowrap class="text-left" style="width:10%"></th>
                                        <th nowrap class="text-left" style="width:10%"></th>  
                                        <th nowrap class="text-left" style="width:10%"></th>
                                        <th nowrap class="text-left" style="width:10%"></th>                                      
                                        <th nowrap class="text-right" style="width:10%"><?php echo $aDataTextRef['tRPA2TBSale']; ?></th>
                                        <th nowrap class="text-right" style="width:10%"><?php echo $aDataTextRef['tRPA2TBCancelSale']; ?></th>
                                        <th nowrap class="text-right" style="width:10%"><?php echo $aDataTextRef['tRPA2TBTotalSale']; ?></th>
                                    </tr>
                                </thead>
                                <?php if(true) { ?>
                                <tbody>
                                    <?php if(isset($aDataReport['raItems']) && !empty($aDataReport['raItems'])):?>
                                        <?php
                                            // Set ตัวแปร Sum - SubFooter
                                            $nSumSubXsdQty = 0;
                                            $cSumSubXsdAmtB4DisChg = 0;
                                            $cSumSubXsdDis = 0;
                                            $cSumSubXsdVat = 0;
                                            $cSumSubXsdNetAfHD = 0;
                                            // Set ตัวแปร SumFooter
                                            $nSumFootXsdQty = 0;
                                            $cSumFootXsdAmtB4DisChg = 0;
                                            $cSumFootXsdDis = 0;
                                            $cSumFootXsdVat = 0;
                                            $cSumFootXsdNetAfHD = 0;
                                        ?> 
                                        <?php foreach($aDataReport['raItems'] as $nKey => $aValue) { ?>
                                            <?php
                                                // Step 1 เตรียม Parameter สำหรับการ Groupping
                                                $tBchCode = $aValue["FTBchCode"];
                                                $tBchName = $aValue["FTBchName"];
                                                $tShpCode = $aValue["FTShpCode"];
                                                $tShpName = $aValue['FTShpName'];
                                                $nGroupMember = $aValue["FNRptGroupMember"]; 
                                                $nRowPartID = $aValue["FNRowPartID"]; 
                                            ?>
                                            <?php
                                                // Step 2 Groupping data
                                                $aGrouppingData = array($tBchCode, $tBchName, $tShpCode, $tShpName, "N", "N", "N", "N");
                                                // Parameter
                                                // $nRowPartID      = ลำดับตามกลุ่ม
                                                // $aGrouppingData  = ข้อมูลสำหรับ Groupping
                                                FCNtHRPTHeadGroupping($nRowPartID, $aGrouppingData);
                                            ?>
                                            <!-- Step 2 แสดงข้อมูลใน TD -->
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td><?php echo date("Y-m-d", strtotime($aValue["FDTxnDocDate"])); ?></td>
                                                <td class="text-right"><?php echo number_format($aValue["FCTxnSaleVal"], 2);?></td>
                                                <td class="text-right"><?php echo number_format($aValue["FCTxnCancelSaleVal"], 2);?></td>
                                                <td class="text-right"><?php echo number_format($aValue["FCTxnSaleNet"], 2);?></td>                                                
                                            </tr>

                                            <?php
                                                // Step 3 : เตรียม Parameter สำหรับ Summary Sub Footer
                                                $TxnSaleVal_SubTotal = number_format($aValue["FCTxnSaleVal_SubTotal"], 2);
                                                $TxnCancelSaleVal_SubTotal = number_format($aValue["FCTxnCancelSaleVal_SubTotal"], 2);
                                                $SaleNet_SubTotal = number_format($aValue["FCSaleNet_SubTotal"], 2);

                                                $aSumFooter = array($aDataTextRef["tRPA5TBCrdTotal"],"N", "N", "N", "N", $TxnSaleVal_SubTotal,$TxnCancelSaleVal_SubTotal,$SaleNet_SubTotal);

                                                // Step 4 : สั่ง Summary SubFooter
                                                // Parameter 
                                                // $nGroupMember = จำนวนข้อมูลทั้งหมดในกลุ่ม
                                                // $nRowPartID = ลำดับข้อมูลในกลุ่ม
                                                // $aSumFooter = ข้อมูล Summary SubFooter
                                                FCNtHRPTSumSubFooter($nGroupMember,$nRowPartID,$aSumFooter);

                                                // Step 5 เตรียม Parameter สำหรับ SumFooter
                                                $nSumTxnSaleVal_Footer = number_format($aValue["FCTxnSaleVal_Footer"], 2);
                                                $cSumTxnCancelSaleVal_Footer = number_format($aValue["FCTxnCancelSaleVal_Footer"], 2);
                                                $cSumNetSale_Footer = number_format($aValue["FCNetSale_Footer"], 2);
                                                $paFooterSumData = array($aDataTextRef["tRPA2TBTotalAllSale"],"N", "N", "N", "N",$nSumTxnSaleVal_Footer,$cSumTxnCancelSaleVal_Footer,$cSumNetSale_Footer);
                                            ?>
                                        <?php } ?>
                                        <?php
                                            // Step 6 : สั่ง Summary Footer
                                            $nPageNo = 1;// $aDataReport["aPagination"]["nDisplayPage"];
                                            $nTotalPage = 1;// $aDataReport["aPagination"]["nTotalPage"];
                                            if($bShowFooter) {
                                                FCNtHRPTSumFooter($nPageNo,$nTotalPage,$paFooterSumData);
                                            }
                                        ?>
                                    <?php else:?>
                                        <tr><td class='text-center xCNTextDetail2' colspan='100%'><?php echo @$aDataTextRef['tRptNoData']; ?></td></tr>
                                    <?php endif; ?>
                                </tbody>
                            <?php } ?>
                        </table>
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
                                    <button onclick="JSvClickPageSaleShopByShop('first')" class="btn btn-white btn-sm" <?php echo $tDisabledLeft ?> style="padding: 2px 10px;">
                                        <span style="font-size: 15px !important; color: black; font-weight: bold;">First</span>
                                    </button>
                                    <button onclick="JSvClickPageSaleShopByShop('previous')" class="btn btn-white btn-sm" <?php echo $tDisabledLeft ?> style="padding: 2px 10px;">
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
                                        <button onclick="JSvClickPageSaleShopByShop('<?php echo $i?>')" type="button" class="btn xCNBTNNumPagenation <?php echo $tActive ?>" <?php echo $tDisPageNumber ?>><?php echo $i?></button>
                                    <?php } ?>
                                    <?php if($aDataReport['rnCurrentPage'] >= $aDataReport['rnAllPage']){  $tDisabledRight = 'disabled'; }else{  $tDisabledRight = '-';  } ?>
                                    <button onclick="JSvClickPageSaleShopByShop('next')" class="btn btn-white btn-sm" <?php echo $tDisabledRight ?> style="padding: 2px 10px;">
                                        <span style="font-size: 15px !important; color: black; font-weight: bold;">></span>
                                    </button>
                                    <button onclick="JSvClickPageSaleShopByShop('last')" class="btn btn-white btn-sm" <?php echo $tDisabledRight ?> style="padding: 2px 10px;">
                                        <span style="font-size: 15px !important; color: black; font-weight: bold;">Last</span>
                                    </button>    
                                </div>
                            </div>
                        </div>             
                    </div>
                    <script>
                        // Next page by report
                        function JSvClickPageSaleShopByShop(ptPage){
                            var nAllPage = '<?=$aDataReport['rnAllPage']?>';
                            var nPageCurrent = '';
                            switch (ptPage) {
                                case 'next': // กดปุ่ม Next
                                    $('.xWBtnNext').addClass('disabled');
                                    nPageOld = $('.xWPageCard .active').text(); // Get เลขก่อนหน้า
                                    nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
                                    nPageCurrent = nPageNew;
                                    break;
                                case 'previous': // กดปุ่ม Previous
                                    nPageOld = $('.xWPageCard .active').text(); // Get เลขก่อนหน้า
                                    nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
                                    nPageCurrent = nPageNew;
                                    break;
                                case 'first': // กดปุ่ม First
                                    nPageCurrent = 1;
                                    break;
                                case 'last': // กดปุ่ม Last
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
            
        <?php if($tCallView == 'pdf') : ?>  
        <script>
            $(document).ready(function(){
                var tFoot = $('tfoot').html();
                $('tfoot').remove();
                $('tbody').append(tFoot);
            });
        </script>   
        <?php endif; ?>    
        
    </body>
</html>

