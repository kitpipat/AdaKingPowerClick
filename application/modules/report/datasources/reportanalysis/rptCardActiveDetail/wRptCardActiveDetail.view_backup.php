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
    
    $rtTotalTxnValue = number_format($this->params['aDataReport'][0]['rtTotalTxnValue'],2);
    // echo "<pre>";
    // print_r($aFilterReport);
    // echo "</pre>";
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <title><?php echo $aDataTextRef['tTitleReport']?></title>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0,maximum-scale=1.0, user-scalable=0">
    <!-- CSS BootStrap -->
    <link rel="stylesheet" type="text/css" href="<?php echo $tBaseUrl.'application/assets/vendor/bootstrap/css/bootstrap.min.css'?>"> 
    <link rel="stylesheet" type="text/css" href="<?php echo $tBaseUrl.'application/assets/vendor/bootstrap/css/bootstrap.custom.css'?>">
    <!-- CSS Custom -->
    <link rel="stylesheet" href="<?php echo $tBaseUrl.'application/assets/css/localcss/ada.layout.css'?>">
	<link rel="stylesheet" href="<?php echo $tBaseUrl.'application/assets/css/localcss/ada.menu.css'?>">
	<link rel="stylesheet" href="<?php echo $tBaseUrl.'application/assets/css/localcss/ada.fonts.css'?>">
    <link rel="stylesheet" href="<?php echo $tBaseUrl.'application/assets/css/localcss/ada.component.css'?>">
    <!-- Script JS -->
    <script src="<?php echo $tBaseUrl.'application/assets/vendor/jquery/jquery.js'?>"></script>
    <script src="<?php echo $tBaseUrl.'application/assets/vendor/bootstrap/js/bootstrap.min.js'?>"></script>
</head>
<body>
    <section id="ostReportCardActiveDetail">
        <div class="container-fluid xCNLayOutRptHtml">
            <?php if(false) : ?>
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
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div id="odvFilterReport" class="row">
                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                    </div>
                    <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                        <!-- Filter Branch -->
                        <?php if(!empty($aFilterReport['tBchCodeFrom']) && !empty($aFilterReport['tBchCodeTo'])):?>
                            <div class="text-left">
                                <label class="xCNRptLabel">
                                    <?php echo $aDataTextRef['tRPABchFrom'].' : '.$aFilterReport['tBchNameFrom'].' '.$aDataTextRef['tRPABchTo'].' : '.$aFilterReport['tBchNameTo'];?>
                                </label>
                            </div>
                        <?php endif;?>
                        <!-- Filter CardCode -->
                        <?php if(!empty($aFilterReport['tCrdCodeFrom']) && !empty($aFilterReport['tCrdCodeTo'])):?>
                            <div class="text-left">
                                <label class="xCNRptLabel">
                                    <?php echo $aDataTextRef['tRPACardCodeFrom'].' : '.$aFilterReport['tCrdNameFrom'].' '.$aDataTextRef['tRPACardCodeTo'].' : '.$aFilterReport['tCrdNameTo'];?>
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
            <?php endif; ?>
            <div class="xCNContentReport">
                <div id="odvTableKoolReport" class="table-responsive">
                   <?php 
                        Table::create(array(
                            "dataSource"            => $this->dataStore("RptCardActiveDetail"),
                            "showFooter"=>true,
                            "columns"               => array(
                                'rtBchCode'         => array(
                                    "label"         => $aDataTextRef['tRPA4TBBarchCode'],
                                ),
                                'rtBchName'         => array(
                                    "label"         => $aDataTextRef['tRPA4TBBarchName'],
                                ),
                                'rtCrdCode'         => array(
                                    "label"         => $aDataTextRef['tRPA4TBCardCode'],
                                ),
                                'rtCrdName'         => array(
                                    "label"         => $aDataTextRef['tRPA4TBCardName'],
                                ),
                                'rtTxnDocDate'      => array(
                                    "label"         => $aDataTextRef['tRPA4TBDocDate'],
                                ),
                                'rtTxnDocTime'      => array(
                                    "label"         => $aDataTextRef['tRPA4TBDocTime'],
                                ),
                                'rtTxnDocTypeName'  => array(
                                    "label"         => $aDataTextRef['tRPA4TBDocType'],
                                    "formatValue"   => function($tValue, $aRow){
                                        $aExplodeDocTypeName = explode(";",$tValue);
                                        if($aRow['rnLngID'] == 1){
                                            return $aExplodeDocTypeName[0];
                                        }else{
                                            return $aExplodeDocTypeName[1];
                                        }
                                    }
                                ),
                                'rtCrdHolderID'     => array(
                                    "label"         => $aDataTextRef['tRPA4TBCrdHoderID'],
                                ),
                                'rtTxnPosCode'     => array(
                                    "label"         => $aDataTextRef['tRPA4TBPosCode'],
                                    "footerText"=> $aDataTextRef['tRPA4TBTotalAll']
                                ),
                                'rtTxnValue'     => array(
                                    "label"         => $aDataTextRef['tRPA4TBTxtCrdValue'],
                                    "type"          => "number",
                                    "decimals"      => 2,
                                    // "footer"=>"sum",
                                    // "footerText"=>"@value",
                                    "footerText"=>"$rtTotalTxnValue",
                                    "cssStyle"      => "text-align:right",
                                )
                            ),
                            "cssClass"=>array(
                                // "table" => "table-bordered",
                            ),
                            "removeDuplicate"   => array("rtBchCode","rtBchName","rtCrdCode")
                        ));
                   ?>
                </div>
            </div>
        </div>
    </section>
    <script type="text/javascript">
        $('#obtPrintViewHtml').click(function(){
            $(this).hide();
            window.print();
            $(this).show();
        });
    </script>
</body>
</html>












