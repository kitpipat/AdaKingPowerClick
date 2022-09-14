<style>
    .xWDSHSALHeadPanel {
        border-bottom: 1px solid #cfcbcb8a !important;
        padding-bottom: 0px !important;
    }

    .xWDSHSALTextNumber {
        font-size: 25px !important;
        font-weight: bold;
    }

    .xWDSHSALPanelMainRight {
        padding-bottom: 0px;
        min-height: 300px;
        overflow-x: auto;
    }

    .xWDSHSALFilter {
        cursor: pointer;
    }

    .xWOverlayLodingChart {
        position: absolute;
        min-width: 100%;
        min-height: 100%;
        width: 100%;
        background: #FFFFFF;
        z-index: 2500;
        display: none;
        top: 0%;
        margin-left: 0px;
        left: 0%;
    }

    .xCNTextDetailDB {
        font-size: 20px !important;
        font-weight: bold;
        color: black;
    }
</style>


<?php
$tValueCookie   = $this->input->cookie("Cookie_SKC" . $this->session->userdata("tSesUserCode"), true);
$tValCheck      = json_decode($tValueCookie);
?>

<?php
$tDivByDivRight = '';
$tDivByDivLeft  = '';
if (empty($tValueCookie)) {
    $tDivLeft           = 'col-xs-12 col-sm-6 col-md-6 col-lg-6';
    $tDivRight          = 'col-xs-12 col-sm-6 col-md-6 col-lg-6';
} else {
    if ($tValCheck[0] == 0 && $tValCheck[1] == 0 && $tValCheck[2] == 0 && $tValCheck[6] == 0) {
        $tDivRight      = 'col-xs-12 col-sm-12 col-md-12 col-lg-12';
        $tDivLeft       = '';
        $tDivByDivRight = 'col-xs-12 col-sm-6 col-md-6 col-lg-6';
    } else if ($tValCheck[3] == 0 && $tValCheck[4] == 0 && $tValCheck[5] == 0) {
        $tDivLeft       = 'col-xs-12 col-sm-12 col-md-12 col-lg-12';
        $tDivRight      = '';
        $tDivByDivLeft  = 'col-xs-12 col-sm-6 col-md-6 col-lg-6';
    } else if ($tValCheck[3] == 0 && $tValCheck[4] == 0 && $tValCheck[5] == 0 && $tValCheck[2]) {
        $tDivLeft       = 'col-xs-12 col-sm-12 col-md-12 col-lg-12';
        $tDivRight      = '';
        $tDivByDivLeft  = 'col-xs-12 col-sm-6 col-md-6 col-lg-6';
    } else {
        $tDivLeft       = 'col-xs-12 col-sm-6 col-md-6 col-lg-6';
        $tDivRight      = 'col-xs-12 col-sm-6 col-md-6 col-lg-6';
        $tDivByDivRight = 'col-xs-12 col-sm-12 col-md-12 col-lg-12';
        $tDivByDivLeft  = 'col-xs-12 col-sm-12 col-md-12 col-lg-12';
    }
}
?>
<div class="row">

    <div class="<?php echo  $tDivLeft; ?>">
        <div class="row">
            <div class="<?php echo $tDivByDivLeft ?>">
                <!-- Panel จำนวนบิลขาย และ ยอดขายรวม -->
                <?php
                $aIsAlwFuncInRoleParams = ["tUfrGrpRef" => "053", "tUfrRef" => "DSB01", "tGhdApp" => "SB"];
                $bChkRolePanelLeft1 = FCNbIsAlwFuncInRole($aIsAlwFuncInRoleParams);
                ?>
                <?php if ($bChkRolePanelLeft1) { ?>
                    <?php if (isset($tValCheck[0]) ? $tValCheck[0] != 0 : 1) { ?>
                        <div id="odvDSHSALPanelLeft1" class="panel panel-default">
                            <div class="panel-collapse collapse in" role="tabpanel">
                                <div class="panel-body" style="padding-bottom:0px;">
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                            <div class="panel-body" style="padding-bottom:0px;">
                                                <div class="row xWDSHSALHeadPanel">
                                                    <div class="col-xs-10 col-sm-6 col-md-6 col-lg-6 p-l-0 text-left">
                                                        <label class="xCNTextDetailDB"><?php echo @$aTextLang['tDSHSALBillQty']; ?></label>
                                                    </div>
                                                    <div class="col-xs-2 col-sm-6 col-md-6 col-lg-6 p-r-0 text-right">
                                                        <i class="fa fa-filter xWDSHSALFilter" aria-hidden="true" data-keyfilter="FBA" data-keygrp="BCH,MER,SHP,POS,PDT,APT,SCT,SRC"></i>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                        <div class="row">
                                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 p-l-0">
                                                                <label class="xWDSHSALTextNumber"><?php echo @$aTextLang['tDSHSALSaleBill']; ?></label>
                                                            </div>
                                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 p-r-0 text-right">
                                                                <label id="olbDSHSALTotalSaleBill" class="xWDSHSALTextNumber"><?php echo @$tCountSalAll; ?></label>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 p-l-0">
                                                                <label class="xWDSHSALTextNumber"><?php echo @$aTextLang['tDSHSALRefundBill']; ?></label>
                                                            </div>
                                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 p-r-0 text-right">
                                                                <label id="olbDSHSALTotalRefundBill" class="xWDSHSALTextNumber"><?php echo @$tCountRefundAll; ?></label>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 p-l-0">
                                                                <label class="xWDSHSALTextNumber"><?php echo @$aTextLang['tDSHSALTotalBill']; ?></label>
                                                            </div>
                                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 p-r-0 text-right">
                                                                <label id="olbDSHSALTotalAllBill" class="xWDSHSALTextNumber"><?php echo @$tCountAllData; ?></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                            <div class="panel-body" style="padding-bottom:0px;">
                                                <div class="row xWDSHSALHeadPanel">
                                                    <div class="col-xs-10 col-sm-6 col-md-6 col-lg-6 p-l-0">
                                                        <label class="xCNTextDetailDB"><?php echo @$aTextLang['tDSHSALBillTotalAll']; ?></label>
                                                    </div>
                                                    <div class="col-xs-2 col-sm-6 col-md-6 col-lg-6 p-r-0 text-right">
                                                        <i class="fa fa-filter xWDSHSALFilter" aria-hidden="true" data-keyfilter="FTS" data-keygrp="BCH,MER,SHP,POS,PDT,APT,SCT,SRC"></i>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                        <div class="row">
                                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 p-l-0">
                                                                <label class="xWDSHSALTextNumber"><?php echo @$aTextLang['tDSHSALTotalSale']; ?></label>
                                                            </div>
                                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 p-r-0 text-right">
                                                                <label id="olbDSHSALTotalSaleAll" class="xWDSHSALTextNumber"><?php echo @$cTotalSaleAll; ?></label>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 p-l-0">
                                                                <label class="xWDSHSALTextNumber"><?php echo @$aTextLang['tDSHSALTotalRefund']; ?></label>
                                                            </div>
                                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 p-r-0 text-right">
                                                                <label id="olbDSHSALTotalRefundAll" class="xWDSHSALTextNumber"><?php echo @$cTotalRefundAll; ?></label>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 p-l-0">
                                                                <label class="xWDSHSALTextNumber"><?php echo @$aTextLang['tDSHSALTotalGrand']; ?></label>
                                                            </div>
                                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 p-r-0 text-right">
                                                                <label id="olbDSHSALTotalAll" class="xWDSHSALTextNumber"><?php echo @$cTotalAll; ?></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- </div> -->
                    <?php } ?>
                <?php } ?>

                <!-- Panel 10 รายการสินค้าใหม่ -->
                <?php
                $aIsAlwFuncInRoleParams = ["tUfrGrpRef" => "053", "tUfrRef" => "DSB03", "tGhdApp" => "SB"];
                $bChkRolePanelLeft3 = FCNbIsAlwFuncInRole($aIsAlwFuncInRoleParams);
                ?>
                <?php if ($bChkRolePanelLeft3) { ?>
                    <?php if (isset($tValCheck[2]) ? $tValCheck[2] != 0 : 1) { ?>
                        <div id="odvDSHSALPanelLeft4" class="panel panel-default">
                            <div class="panel-collapse collapse in" role="tabpanel">
                                <div class="panel-body" style="padding-bottom:0px;">
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                            <div class="panel-body" style="padding-bottom:0px;">
                                                <div class="row xWDSHSALHeadPanel">
                                                    <div class="col-xs-10 col-sm-6 col-md-6 col-lg-6 p-l-0">
                                                        <label class="xCNTextDetailDB"><?php echo @$aTextLang['tDSHSALNewProductTopTen']; ?></label>
                                                    </div>
                                                    <div class="col-xs-2 col-sm-6 col-md-6 col-lg-6 p-r-0 text-right">
                                                        <i class="fa fa-filter xWDSHSALFilter" aria-hidden="true" data-keyfilter="FNP" data-keygrp="BCH,MER,SHP"></i>
                                                    </div>
                                                </div>
                                                <div class="row xWDSHSALDataPanel">
                                                </div>
                                                <div class="xWOverlayLodingChart" data-keyfilter="FNP">
                                                    <img src="<?php echo base_url(); ?>application/modules/common/assets/images/ada.loading.gif" class="xWImgLoading">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                <?php } ?>
            </div>

            <div class="<?php echo $tDivByDivLeft ?>">

                <!-- Panel ยอดขายตามการชำระเงิน -->
                <?php
                $aIsAlwFuncInRoleParams = ["tUfrGrpRef" => "053", "tUfrRef" => "DSB02", "tGhdApp" => "SB"];
                $bChkRolePanelLeft2 = FCNbIsAlwFuncInRole($aIsAlwFuncInRoleParams);
                ?>
                <?php if (isset($tValCheck[1]) ? $tValCheck[1] != 0 : 1) { ?>
                    <?php if ($bChkRolePanelLeft2) { ?>
                        <!-- <div class="<?php echo $tDivByDivLeft ?>"> -->
                        <div id="odvDSHSALPanelLeft2" class="panel panel-default">
                            <div class="panel-collapse collapse in" role="tabpanel">
                                <div class="panel-body" style="padding-bottom:0px;">
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                            <div class="panel-body" style="padding-bottom:0px;">
                                                <div class="row xWDSHSALHeadPanel">
                                                    <div class="col-xs-10 col-sm-6 col-md-6 col-lg-6 p-l-0">
                                                        <label class="xCNTextDetailDB"><?php echo @$aTextLang['tDSHSALTotalSaleByPayment']; ?></label>
                                                    </div>
                                                    <div class="col-xs-2 col-sm-6 col-md-6 col-lg-6 p-r-0 text-right">
                                                        <i class="fa fa-filter xWDSHSALFilter" aria-hidden="true" data-keyfilter="FSR" data-keygrp="BCH,MER,SHP,POS,RCV,APT"></i>
                                                    </div>
                                                </div>
                                                <div class="row xWDSHSALDataPanel">
                                                </div>
                                                <div class="xWOverlayLodingChart" data-keyfilter="FSR">
                                                    <img src="<?php echo base_url(); ?>application/modules/common/assets/images/ada.loading.gif" class="xWImgLoading">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- </div> -->
                    <?php } ?>
                <?php } ?>



                <?php if (($tValCheck[3] == 1 && $tValCheck[4] == 1 && $tValCheck[5] == 1) || ($tValCheck[3] == 0 && $tValCheck[4] == 0 && $tValCheck[5] == 0)) { ?>
                    <!-- Panel 10 อันดับขายดีตามมูลค่า -->
                    <?php
                    $aIsAlwFuncInRoleParams = ["tUfrGrpRef" => "053", "tUfrRef" => "DSB08", "tGhdApp" => "SB"];
                    $bChkRolePanelRight3 = FCNbIsAlwFuncInRole($aIsAlwFuncInRoleParams);
                    ?>

                    <?php if (isset($tValCheck[6]) ? $tValCheck[6] != 0 : 1) { ?>
                        <?php if ($bChkRolePanelRight3) { ?>
                            <!-- <div class="<?php// echo $tDivByDivRight ?>"> -->
                            <div id="odvDSHSALPanelLeft6" class="panel panel-default">
                                <div class="panel-collapse collapse in" role="tabpanel">
                                    <div class="panel-body xWDSHSALPanelMainRight">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                <div class="panel-body" style="padding-bottom:0px;">
                                                    <div class="row xWDSHSALHeadPanel">
                                                        <div class="col-xs-10 col-sm-6 col-md-6 col-lg-6 p-l-0">
                                                            <label class="xCNTextDetailDB"><?php echo @$aTextLang['tDSHSALBestSaleProductTopTenByValue']; ?></label>
                                                        </div>
                                                        <div class="col-xs-2 col-sm-6 col-md-6 col-lg-6 p-r-0 text-right">
                                                            <i class="fa fa-filter xWDSHSALFilter" aria-hidden="true" data-keyfilter="FTV" data-keygrp="BCH,MER,SHP,POS,PDT,APT,SCT,SRC"></i>
                                                        </div>
                                                    </div>
                                                    <div class="row xWDSHSALDataPanel">
                                                    </div>
                                                    <div class="xWOverlayLodingChart" data-keyfilter="FTV">
                                                        <img src="<?php echo base_url(); ?>application/modules/common/assets/images/ada.loading.gif" class="xWImgLoading">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- </div> -->
                        <?php } ?>
                    <?php  } ?>
                <?php  } ?>



            </div>
        </div>
    </div>

    <div class="<?php echo  $tDivRight; ?>">
        <div class="row">
            <!-- Panel ยอดขายตามกลุ่มสินค้า -->
            <?php
            $aIsAlwFuncInRoleParams = ["tUfrGrpRef" => "053", "tUfrRef" => "DSB04", "tGhdApp" => "SB"];
            $bChkRolePanelRight1 = FCNbIsAlwFuncInRole($aIsAlwFuncInRoleParams);
            ?>
            <?php if ($bChkRolePanelRight1) { ?>
                <?php if (isset($tValCheck[3]) ? $tValCheck[3] != 0 : 1) { ?>
                    <div class="<?php echo $tDivByDivRight ?>">
                        <div id="odvDSHSALPanelRight1" class="panel panel-default">
                            <div class="panel-collapse collapse in" role="tabpanel">
                                <div class="panel-body xWDSHSALPanelMainRight">
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                            <div class="panel-body" style="padding-bottom:0px;">
                                                <div class="row xWDSHSALHeadPanel">
                                                    <div class="col-xs-10 col-sm-6 col-md-6 col-lg-6 p-l-0">
                                                        <label class="xCNTextDetailDB"><?php echo @$aTextLang['tDSHSALTotalSaleByPdtGrp']; ?></label>
                                                    </div>
                                                    <div class="col-xs-2 col-sm-6 col-md-6 col-lg-6 p-r-0 text-right">
                                                        <i class="fa fa-filter xWDSHSALFilter" aria-hidden="true" data-keyfilter="FPG" data-keygrp="BCH,MER,SHP,POS,PGP,APT,SCT,SRC"></i>
                                                    </div>
                                                </div>
                                                <div class="row xWDSHSALDataPanel">
                                                </div>
                                                <div class="xWOverlayLodingChart" data-keyfilter="FPG">
                                                    <img src="<?php echo base_url(); ?>application/modules/common/assets/images/ada.loading.gif" class="xWImgLoading">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                <?php } ?>
            <?php } ?>

            <!-- Panel ยอดขายตามประเภทสินค้า -->
            <?php
            $aIsAlwFuncInRoleParams = ["tUfrGrpRef" => "053", "tUfrRef" => "DSB05", "tGhdApp" => "SB"];
            $bChkRolePanelRight2 = FCNbIsAlwFuncInRole($aIsAlwFuncInRoleParams);
            ?>
            <?php if ($bChkRolePanelRight2) { ?>
                <?php if (isset($tValCheck[4]) ? $tValCheck[4] != 0 : 1) { ?>

                    <div class="<?php echo $tDivByDivRight ?>">
                        <div id="odvDSHSALPanelRight2" class="panel panel-default">
                            <div class="panel-collapse collapse in" role="tabpanel">
                                <div class="panel-body xWDSHSALPanelMainRight">
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                            <div class="panel-body" style="padding-bottom:0px;">
                                                <div class="row xWDSHSALHeadPanel">
                                                    <div class="col-xs-10 col-sm-6 col-md-6 col-lg-6 p-l-0">
                                                        <label class="xCNTextDetailDB"><?php echo @$aTextLang['tDSHSALTotalSaleByPdtType']; ?></label>
                                                    </div>
                                                    <div class="col-xs-2 col-sm-6 col-md-6 col-lg-6 p-r-0 text-right">
                                                        <i class="fa fa-filter xWDSHSALFilter" aria-hidden="true" data-keyfilter="FPT" data-keygrp="BCH,MER,SHP,POS,PTY,APT,SCT,SRC"></i>
                                                    </div>
                                                </div>
                                                <div class="row xWDSHSALDataPanel">
                                                </div>
                                                <div class="xWOverlayLodingChart" data-keyfilter="FPT">
                                                    <img src="<?php echo base_url(); ?>application/modules/common/assets/images/ada.loading.gif" class="xWImgLoading">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                <?php } ?>
            <?php } ?>

            <!-- Panel 10 อันดับสินค้าขายดีตามจำนวน -->
            <?php
            $aIsAlwFuncInRoleParams = ["tUfrGrpRef" => "053", "tUfrRef" => "DSB06", "tGhdApp" => "SB"];
            $bChkRolePanelRight3 = FCNbIsAlwFuncInRole($aIsAlwFuncInRoleParams);
            ?>

            <?php if ($bChkRolePanelRight3) { ?>
                <?php if (isset($tValCheck[5]) ? $tValCheck[5] != 0 : 1) { ?>

                    <div class="<?php echo $tDivByDivRight ?>">
                        <div id="odvDSHSALPanelRight3" class="panel panel-default">
                            <div class="panel-collapse collapse in" role="tabpanel">
                                <div class="panel-body xWDSHSALPanelMainRight">
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                            <div class="panel-body" style="padding-bottom:0px;">
                                                <div class="row xWDSHSALHeadPanel">
                                                    <div class="col-xs-10 col-sm-6 col-md-6 col-lg-6 p-l-0">
                                                        <label class="xCNTextDetailDB"><?php echo @$aTextLang['tDSHSALBestSaleProductTopTen']; ?></label>
                                                    </div>
                                                    <div class="col-xs-2 col-sm-6 col-md-6 col-lg-6 p-r-0 text-right">
                                                        <i class="fa fa-filter xWDSHSALFilter" aria-hidden="true" data-keyfilter="FTB" data-keygrp="BCH,MER,SHP,POS,PDT,APT,SCT,SRC"></i>
                                                    </div>
                                                </div>
                                                <div class="row xWDSHSALDataPanel">
                                                </div>
                                                <div class="xWOverlayLodingChart" data-keyfilter="FTB">
                                                    <img src="<?php echo base_url(); ?>application/modules/common/assets/images/ada.loading.gif" class="xWImgLoading">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                <?php  } ?>
            <?php  } ?>

            <?php if ($tValCheck[3] == 0 || $tValCheck[4] == 0 || $tValCheck[5] == 0) { ?>


                <!-- Panel 10 อันดับขายดีตามมูลค่า -->
                <?php
                $aIsAlwFuncInRoleParams = ["tUfrGrpRef" => "053", "tUfrRef" => "DSB08", "tGhdApp" => "SB"];
                $bChkRolePanelRight3 = FCNbIsAlwFuncInRole($aIsAlwFuncInRoleParams);
                ?>

                <?php if ($bChkRolePanelRight3) { ?>
                    <?php if (isset($tValCheck[6]) ? $tValCheck[6] != 0 : 1) { ?>

                        <div class="<?php echo $tDivByDivRight ?>" id='tCheck' name="tCheck">
                            <div id="odvDSHSALPanelLeft6" class="panel panel-default">
                                <div class="panel-collapse collapse in" role="tabpanel">
                                    <div class="panel-body xWDSHSALPanelMainRight">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                <div class="panel-body" style="padding-bottom:0px;">
                                                    <div class="row xWDSHSALHeadPanel">
                                                        <div class="col-xs-10 col-sm-6 col-md-6 col-lg-6 p-l-0">
                                                            <label class="xCNTextDetailDB"><?php echo @$aTextLang['tDSHSALBestSaleProductTopTenByValue']; ?></label>
                                                        </div>
                                                        <div class="col-xs-2 col-sm-6 col-md-6 col-lg-6 p-r-0 text-right">
                                                            <i class="fa fa-filter xWDSHSALFilter" aria-hidden="true" data-keyfilter="FTV" data-keygrp="BCH,MER,SHP,POS,PDT,APT"></i>
                                                        </div>
                                                    </div>
                                                    <div class="row xWDSHSALDataPanel">
                                                    </div>
                                                    <div class="xWOverlayLodingChart" data-keyfilter="FTV">
                                                        <img src="<?php echo base_url(); ?>application/modules/common/assets/images/ada.loading.gif" class="xWImgLoading">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    <?php } ?>
                <?php  } ?>

            <?php } ?>
        </div>
    </div>

    <?php
        $nTypeGroupReport   = $aDataWhere['tFilterGroupReport'];
        $tTitle             = '';
    ?>
    <div class="clearfix"></div>


    <div class="row">

        <?php
        $aIsAlwFuncInRoleParams = ["tUfrGrpRef" => "053", "tUfrRef" => "DSB09", "tGhdApp" => "SB"];
        $bChkRolePanelReport = FCNbIsAlwFuncInRole($aIsAlwFuncInRoleParams);
        ?>

        <?php if ($bChkRolePanelReport) { ?>
            <?php if (isset($tValCheck[7]) ? $tValCheck[7] != 0 : 1) { ?>
                <!-- กราฟเปรียบเทียบยอดขายตาม สาขา/ตัวแทนขาย/ร้านค้า/ประเภทสินค้า/กลุ่มสินค้า/ยี่ห้อ/รุ่น/ผู้จำหน่าย-->
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div id="odvDSHSALPanelReportComPareSaleByPdtType" class="panel panel-default">
                            <div class="panel-collapse collapse in" role="tabpanel">
                                <div class="panel-body xWDSHSALPanelMainLeft">
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                            <div class="panel-body" style="padding-bottom:0px;">
                                                <div class="row xWDSHSALHeadPanel">
                                                    <div class="col-xs-10 col-sm-6 col-md-6 col-lg-6 p-l-0">
                                                        <!-- <label class="xCNTextDetailDB"><?php echo @$aTextLang['tRptPdtTypegraph'] . '' . $tTitle . ' YTD ';
                                                                                            ?> (Amont)</label> -->
                                                        <label class="xCNTextDetailDB"><?php echo @$aTextLang['tDSHSALSaleComparebyAmountY']; ?></label>

                                                    </div>
                                                    <div class="col-xs-2 col-sm-6 col-md-6 col-lg-6 p-r-0 text-right">
                                                        <i class="fa fa-filter xWDSHSALFilter" aria-hidden="true" data-keyfilter="RCSPBT" data-keygrp="GRP,AGN,BCH,MER,SHP,POS,BRD,MOD,PRDFT,TPRDFT,GPRDFT"></i>
                                                    </div>
                                                </div>
                                               
                                                <div style="padding-top: 50px;"></div>
                                                <div class="row xWDSHSALDataPanel">
                                                </div>
                                                
                                                <div class="xWOverlayLodingChart" data-keyfilter="RCSPBT">
                                                    <img src="<?php echo base_url(); ?>application/modules/common/assets/images/ada.loading.gif" class="xWImgLoading">
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>




                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div id="odvDSHSALPanelReportComPareSaleByPdtTypeQTY" class="panel panel-default">
                            <div class="panel-collapse collapse in" role="tabpanel">
                                <div class="panel-body xWDSHSALPanelMainLeft">
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                            <div class="panel-body" style="padding-bottom:0px;">
                                                <div class="row xWDSHSALHeadPanel">
                                                    <div class="col-xs-10 col-sm-6 col-md-6 col-lg-6 p-l-0">
                                                        <!-- <label class="xCNTextDetailDB"><?php echo @$aTextLang['tRptPdtTypegraph'] . '' . $tTitle . ' YTD ';
                                                                                            ?> (QTY)</label> -->
                                                        <label class="xCNTextDetailDB"><?php echo @$aTextLang['tDSHSALSaleComparebyQTYY']; ?></label>
                                                    </div>
                                                    <div class="col-xs-2 col-sm-6 col-md-6 col-lg-6 p-r-0 text-right">
                                                        <i class="fa fa-filter xWDSHSALFilter" aria-hidden="true" data-keyfilter="RCSPBT2" data-keygrp="GRP,AGN,BCH,MER,SHP,POS,BRD,MOD,PRDFT,TPRDFT,GPRDFT"></i>
                                                    </div>
                                                </div>
                                                <div style="padding-top: 50px;"></div>
                                                <div class="row xWDSHSALDataPanel">
                                                </div>
                                                <div class="xWOverlayLodingChart" data-keyfilter="RCSPBT2">
                                                    <img src="<?php echo base_url(); ?>application/modules/common/assets/images/ada.loading.gif" class="xWImgLoading">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>



            <?php  } ?>
        <?php  } ?>

        <!-- กราฟเปรียบเทียบยอดขายตามสินค้า (Amont) -->
        <?php
        $tMTDAmt = '';
        $tMTDQty = '';

        $tMTDAmt = "MTD (Amont)";
        $tMTDQty = "MTD (QTY)";
        ?>


        <?php
        $aIsAlwFuncInRoleParams = ["tUfrGrpRef" => "053", "tUfrRef" => "DSB10", "tGhdApp" => "SB"];
        $bChkRolePanelReport = FCNbIsAlwFuncInRole($aIsAlwFuncInRoleParams);
        ?>

        <?php if ($bChkRolePanelReport) { ?>
            <?php if (isset($tValCheck[8]) ? $tValCheck[8] != 0 : 1) { ?>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div id="odvDSHSALPanelLeft9" class="panel panel-default">
                            <div class="panel-collapse collapse in" role="tabpanel">
                                <div class="panel-body xWDSHSALPanelMainLeft">
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                            <div class="panel-body" style="padding-bottom:0px;">
                                                <div class="row xWDSHSALHeadPanel">
                                                    <div class="col-xs-10 col-sm-8 col-md-8 col-lg-8 p-l-0">
                                                        <!-- <label class="xCNTextDetailDB"><?php echo @$aTextLang['tDSHRptCompareSaleByPdtAmt'] . '' . $tTitle . ' ' . $tMTDAmt; ?></label> -->
                                                        <label class="xCNTextDetailDB"><?php echo @$aTextLang['tDSHSALSaleComparebyAmountM']; ?></label>
                                                    </div>
                                                    <div class="col-xs-2 col-sm-4 col-md-4 col-lg-4 p-r-0 text-right">
                                                        <i class="fa fa-filter xWDSHSALFilter" aria-hidden="true" data-keyfilter="RPTComSalePdt" data-keygrp="GRP,AGN,BCH,MER,SHP,POS,BRD,MOD,PRDFT,TPRDFT,GPRDFT"></i>
                                                    </div>
                                                </div>
                                                <div style="padding-top: 50px;"></div>
                                                <div class="row xWDSHSALDataPanel"></div>
                                                <div class="xWOverlayLodingChart" data-keyfilter="RPTComSalePdt">
                                                    <img src="<?php echo base_url(); ?>application/modules/common/assets/images/ada.loading.gif" class="xWImgLoading">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- กราฟเปรียบเทียบยอดขายตามสินค้า (จำนวน) -->
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div id="odvDSHSALPanelLeft8" class="panel panel-default">
                            <div class="panel-collapse collapse in" role="tabpanel">
                                <div class="panel-body xWDSHSALPanelMainLeft">
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                            <div class="panel-body" style="padding-bottom:0px;">
                                                <div class="row xWDSHSALHeadPanel">
                                                    <div class="col-xs-10 col-sm-8 col-md-8 col-lg-8 p-l-0">
                                                        <!-- <label class="xCNTextDetailDB"><?php echo @$aTextLang['tDSHRptCompareSaleByPdt'] . '' . $tTitle . ' ' . $tMTDQty; ?></label> -->
                                                        <label class="xCNTextDetailDB"><?php echo @$aTextLang['tDSHSALSaleComparebyQTYM']; ?></label>
                                                    </div>
                                                    <div class="col-xs-2 col-sm-4 col-md-4 col-lg-4 p-r-0 text-right">
                                                        <i class="fa fa-filter xWDSHSALFilter" aria-hidden="true" data-keyfilter="RPTComSalePdt2" data-keygrp="GRP,AGN,BCH,MER,SHP,POS,BRD,MOD,PRDFT,TPRDFT,GPRDFT"></i>
                                                    </div>
                                                </div>
                                                <div style="padding-top: 50px;"></div>
                                                <div class="row xWDSHSALDataPanelLeft"></div>
                                                <div class="xWOverlayLodingChart" data-keyfilter="RPTComSalePdt2">
                                                    <img src="<?php echo base_url(); ?>application/modules/common/assets/images/ada.loading.gif" class="xWImgLoading">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php  } ?>
        <?php  } ?>



    </div>

    <!-- input ค่า sort กับ ฟิวช์ ที่ส่งไป query ของ Total By Branch -->
    <input type="hidden" id="oetDSHSALSort" name="oetDSHSALSort" value="">
    <input type="hidden" id="oetDSHSALFild" name="oetDSHSALFild" value="FTBchName,FTPosCode">
    <input type="hidden" id="oetDSHSALUserCode" name="oetDSHSALUserCode" value="<?php echo $this->session->userdata("tSesUserCode"); ?>">


    <input type="hidden" id="oetDSHSALValCheck" name="oetDSHSALValCheck" value="<?php echo $tValCheck[0]; ?>">
    <input type="hidden" id="oetDSHSALValCheck1" name="oetDSHSALValCheck1" value="<?php echo $tValCheck[1]; ?>">
    <input type="hidden" id="oetDSHSALValCheck2" name="oetDSHSALValCheck2" value="<?php echo $tValCheck[2]; ?>">
    <input type="hidden" id="oetDSHSALValCheck3" name="oetDSHSALValCheck3" value="<?php echo $tValCheck[3]; ?>">
    <input type="hidden" id="oetDSHSALValCheck4" name="oetDSHSALValCheck4" value="<?php echo $tValCheck[4]; ?>">
    <input type="hidden" id="oetDSHSALValCheck5" name="oetDSHSALValCheck5" value="<?php echo $tValCheck[5]; ?>">
    <input type="hidden" id="oetDSHSALValCheck6" name="oetDSHSALValCheck6" value="<?php echo $tValCheck[6]; ?>">
    <input type="hidden" id="oetDSHSALValCheck7" name="oetDSHSALValCheck7" value="<?php echo $tValCheck[7]; ?>">
    <input type="hidden" id="oetDSHSALValCheck8" name="oetDSHSALValCheck8" value="<?php echo $tValCheck[8]; ?>">
    <!-- <input type="hidden" id="oetDSHSALValCheck9" name="oetDSHSALValCheck9" value="<?php echo $tValCheck[9]; ?>"> -->

</div>
<div id="odvDSHSALModalFilterHTML"></div>
<script type="text/javascript">
    $(document).ready(function() {
        let tValCheck3 = $('#oetDSHSALValCheck3').val();
        let tValCheck4 = $('#oetDSHSALValCheck4').val();
        let tValCheck5 = $('#oetDSHSALValCheck5').val();

        if (tValCheck3 == 0 && tValCheck4 == 0 && tValCheck5 == 0) {
            $("#tCheck").hide();
        }


        $('.xWDSHSALFilter').unbind().click(function() {
            let nStaSession = JCNxFuncChkSessionExpired();
            if (typeof(nStaSession) !== "undefined" && nStaSession == 1) {
                let tFilterDataKey = $(this).data('keyfilter');
                let tFilterDataGrp = $(this).data('keygrp');
                JSvDSHSALCallModalFilterDashBoard(tFilterDataKey, tFilterDataGrp);
            } else {
                JCNxShowMsgSessionExpired();
            }
        });
    });
</script>