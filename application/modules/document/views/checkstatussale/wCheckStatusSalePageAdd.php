<?php
     /* HD INFO */
     $tXshDocNo         = (empty($aDataDocHD['FTXshDocNo']) ? '-' : $aDataDocHD['FTXshDocNo']);
     $tAppName          = (empty($aDataDocHD['FTAppName']) ? '-' : $aDataDocHD['FTAppName']);
     $nStaDocAct        = $aDataDocHD['FNXshStaDocAct'];
     $dXshDocDate       = (empty($aDataDocHD['FDXshDocDate']) ? '-' : $aDataDocHD['FDXshDocDate']);
     $tXshDocTime       = (empty($aDataDocHD['FTXshDocTime']) ? '-' : $aDataDocHD['FTXshDocTime']);
     $tXshStaApv        = $aDataDocHD['FTXshStaApv'];
     $tCreateBy         = (empty($aDataDocHD['FTCreateBy']) ? '-' : $aDataDocHD['FTCreateBy']);
     $tApvName          = (empty($aDataDocHD['FTApvName']) ? '-' : $aDataDocHD['FTApvName']);
     $tBchCode          = (empty($aDataDocHD['FTBchCode']) ? '-' : $aDataDocHD['FTBchCode']);
     $tBchName          = (empty($aDataDocHD['FTBchName']) ? '-' : $aDataDocHD['FTBchName']);
     $tAgnCode          = (empty($aDataDocHD['FTAgnCode']) ? '-' : $aDataDocHD['FTAgnCode']);
     $tAgnName          = (empty($aDataDocHD['FTAgnName']) ? '-' : $aDataDocHD['FTAgnName']);
     $tDocVatFull       = (empty($aDataDocHD['FTXshDocVatFull']) ? '' : $aDataDocHD['FTXshDocVatFull']);
     $tXshVATInOrEx     = (empty($aDataDocHD['FTXshVATInOrEx']) ? '' : $aDataDocHD['FTXshVATInOrEx']);
     $tXshStaPrcDoc     = $aDataDocHD['FTXshStaPrcDoc'];
     $tChnName          = (empty($aDataDocHD['FTChnName']) ? '-' : $aDataDocHD['FTChnName']);
     $tXshETaxStatus    = $aDataDocHD['FTXshETaxStatus'];
     $tUsrCreateName    = (empty($aDataDocHD['FTUsrCreateName']) ? '' : $aDataDocHD['FTUsrCreateName']);
     $nXshDocType       = $aDataDocHD['FNXshDocType'];
     $tXshStaDelMQ      = $aDataDocHD['FTXshStaDelMQ'];

     /* CST INFO */
     $tCstCode          = (empty($aDataDocHD['FTCstCode']) ? '-' : $aDataDocHD['FTCstCode']);
     $tCstName          = (empty($aDataDocHD['FTCstName']) ? '-' : $aDataDocHD['FTCstName']);
    //  $tCstTaxNo         = (empty($aDataDocHD['FTCstTaxNo']) ? '-' : $aDataDocHD['FTCstTaxNo']);
     $tCstTel           = (empty($aDataDocHD['FTCstTel']) ? '-' : $aDataDocHD['FTCstTel']);
     $tCstEmail         = (empty($aDataDocHD['FTCstEmail']) ? '-' : $aDataDocHD['FTCstEmail']);

    // $tFTAddVersion      = $aDataDocHD['FTAddVersion'];
    // $tFTAddV1No         = $aDataDocHD['FTAddV1No'];
    // $tFTAddV1Village    = $aDataDocHD['FTAddV1Village'];
    // $tFTAddV1Road       = $aDataDocHD['FTAddV1Road'];
    // $tFTAddV1Soi        = $aDataDocHD['FTAddV1Soi'];

    // $tFTSudName         = $aDataDocHD['FTSudName'];
    // $tFTDstName         = $aDataDocHD['FTDstName'];
    // $tFTPvnCode         = $aDataDocHD['FTPvnCode'];
    // $tFTPvnName         = $aDataDocHD['FTPvnName'];

    // $tFTAddV1PostCode   = $aDataDocHD['FTAddV1PostCode'];
    
    // $tFTAddV2Desc1      = $aDataDocHD['FTAddV2Desc1'];
    // $tFTAddV2Desc2      = $aDataDocHD['FTAddV2Desc2'];

     /* DOC REF INFO */
     $tXshRefInt        = (empty($aDataDocHD['FTXshRefInt']) ? '-' : $aDataDocHD['FTXshRefInt']);
     $tXshRefIntDate    = (empty($aDataDocHD['FDXshRefIntDate']) ? '-' : $aDataDocHD['FDXshRefIntDate']);
     $tXshRefExt        = (empty($aDataDocHD['FTXshRefExt']) ? '-' : $aDataDocHD['FTXshRefExt']);
     $tXshRefExtDate    = (empty($aDataDocHD['FDXshRefExtDate']) ? '-' : $aDataDocHD['FDXshRefExtDate']);

     /* ANOTHER INFO */
     $tXshRmk           = (empty($aDataDocHD['FTXshRmk']) ? '-' : $aDataDocHD['FTXshRmk']);

     $tWahStaAlwPLFrmSale = $aDataDocHD['FTWahStaAlwPLFrmSale'];
     $tChnStaUseDO        = $aDataDocHD['FTChnStaUseDO'];

    if( $nXshDocType == '1' ){
        $tXshDocType = '';
    }else{
        $tXshDocType = 'CN';
    }
?>

<form id="ofmTransferreceiptFormAdd" class="validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data">
    <input type="hidden" id="ohdCSSXshDocVatFull" name="ohdCSSXshDocVatFull" value="<?=$tDocVatFull?>">
    <input type="hidden" id="ohdCSSStaFirstEnter" name="ohdCSSStaFirstEnter" value="1">

    <input type="hidden" id="ohdCSSXshStaApv" name="ohdCSSXshStaApv" value="<?=$tXshStaApv?>">
    <input type="hidden" id="ohdCSSBchCode" name="ohdCSSBchCode" value="<?=$tBchCode?>">
    <input type="hidden" id="ohdCSSUsrLogin" name="ohdCSSUsrLogin" value="<?=$this->session->userdata("tSesUserCode")?>">
    <input type="hidden" id="ohdCSSXshStaPrcDoc" name="ohdCSSXshStaPrcDoc" value="<?=$tXshStaPrcDoc?>">
    <input type="hidden" id="ohdCSSWahStaAlwPLFrmSale" name="ohdCSSWahStaAlwPLFrmSale" value="<?=$tWahStaAlwPLFrmSale?>">
    <input type="hidden" id="ohdCSSChnStaUseDO" name="ohdCSSChnStaUseDO" value="<?=$tChnStaUseDO?>">
    <input type="hidden" id="oetCSSChnMapSeqNo" name="oetCSSChnMapSeqNo" value="<?=$tChnMapSeqNo?>">
    
    

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
            
            <!-- Panel ข้อมูลเอกสาร -->
            <div class="panel panel-default" style="margin-bottom: 25px;">
                <div id="odvHeadStatus" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
                    <label class="xCNTextDetail1"><?=language('document/checkstatussale/checkstatussale', 'tCSSDocInfoTitle');?></label>
                    <a class="xCNMenuplus" role="button" data-toggle="collapse" href="#odvCSSDocumentInfo" aria-expanded="true">
                        <i class="fa fa-plus xCNPlus"></i>
                    </a>
                </div>
                <div id="odvCSSDocumentInfo" class="panel-collapse collapse in" role="tabpanel">
                    <div class="panel-body">

                        <div class="mb-3 row">
                            <label  class="col-md-4 col-form-label"><strong><?=language('document/checkstatussale/checkstatussale', 'tCSSDocNo');?></strong></label>
                            <div id="odvCSSDocNo" class="col-md-8"><?=$tXshDocNo?></div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-md-4 col-form-label"><strong><?=language('document/checkstatussale/checkstatussale', 'tCSSApp');?></strong></label>
                            <div class="col-md-8"><?=$tAppName?></div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-md-4 col-form-label"><strong><?=language('document/checkstatussale/checkstatussale', 'tCSSChannel');?></strong></label>
                            <div class="col-md-8"><?=$tChnName?></div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-md-4 col-form-label"><strong><?=language('document/checkstatussale/checkstatussale', 'tCSSDocDate');?></strong></label>
                            <div class="col-md-8"><?=date_format(date_create($dXshDocDate),'d/m/Y')?></div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-md-4 col-form-label"><strong><?=language('document/checkstatussale/checkstatussale', 'tCSSDocTime');?></strong></label>
                            <div class="col-md-8"><?=$tXshDocTime?></div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-md-4 col-form-label"><strong><?=language('document/checkstatussale/checkstatussale', 'tCSSStaApv');?></strong></label>
                            <div class="col-md-8">
                                <?php 
                                    switch($tXshStaPrcDoc){
                                        case '7':
                                            $tDivClass  = "xWCSSYellowBG";
                                            $tSpanClass = "xWCSSYellowColor";
                                            $tLabel     = "รอสร้างใบส่ง";
                                            break;
                                        case '6':
                                            $tDivClass  = "xWCSSRedBG";
                                            $tSpanClass = "xWCSSRedColor";
                                            $tLabel     = "ลูกค้าแจ้งยกเลิก";
                                            break;
                                        case '5':
                                            $tDivClass  = "xWCSSGreenBG";
                                            $tSpanClass = "xWCSSGreenColor";
                                            $tLabel     = "ยืนยันจัดส่ง";
                                            break;
                                        case '4':
                                            $tDivClass  = "xWCSSYellowBG";
                                            $tSpanClass = "xWCSSYellowColor";
                                            $tLabel     = "รอลูกค้ามารับ";
                                            break;
                                        case '3':
                                            $tDivClass  = "xWCSSYellowBG";
                                            $tSpanClass = "xWCSSYellowColor";
                                            $tLabel     = "รอจัดส่ง";
                                            break;
                                        case '2':
                                            $tDivClass  = "xWCSSYellowBG";
                                            $tSpanClass = "xWCSSYellowColor";
                                            $tLabel     = "รอจัดสินค้า";
                                            break;
                                        default:
                                            $tDivClass  = "xWCSSGrayBG";
                                            $tSpanClass = "xWCSSGrayColor";
                                            $tLabel     = "รอสร้างใบจัด";
                                    }
                                    echo '<div class="xWCSSDotStatus '.$tDivClass.'"></div> <span class="xWSCCStatusColor '.$tSpanClass.'">'.$tLabel.'</span>';
                                ?>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-md-4 col-form-label"><strong><?=language('document/checkstatussale/checkstatussale', 'tCSSTaxType');?></strong></label>
                            <div class="col-md-8"><?=language('document/checkstatussale/checkstatussale', 'tCSSVATInOrEx'.$tXshVATInOrEx);?></div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-md-4 col-form-label"><strong><?=language('document/checkstatussale/checkstatussale', 'tCSSUsrCreate');?></strong></label>
                            <div class="col-md-8"><?=$tUsrCreateName?></div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-md-4 col-form-label"><strong><?=language('document/checkstatussale/checkstatussale', 'tCSSUsrApv');?></strong></label>
                            <div class="col-md-8"><?=$tApvName?></div>
                        </div>

                        <hr style='margin: 5px;'>

                        <div class="mb-3 row <?php if( !FCNbGetIsAgnEnabled()) : echo 'xCNHide';  endif;?>">
                            <label class="col-md-4 col-form-label"><strong><?=language('document/checkstatussale/checkstatussale', 'tCSSBrowseAgnTitle');?></strong></label>
                            <div class="col-md-8">(<?=$tAgnCode?>) <?=$tAgnName?></div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-md-4 col-form-label"><strong><?=language('document/checkstatussale/checkstatussale', 'tCSSBrowseBchTitle');?></strong></label>
                            <div class="col-md-8">(<?=$tBchCode?>) <?=$tBchName?></div>
                        </div>

                    </div>
                </div>
            </div>
            <!-- End Panel ข้อมูลเอกสาร -->

            <!-- Panel ข้อมูลลูกค้า -->
            <div class="panel panel-default" style="margin-bottom: 25px;">
                <div id="odvHeadStatus" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
                    <label class="xCNTextDetail1"><?=language('document/checkstatussale/checkstatussale', 'tCSSCustomerTitle');?></label>
                    <a class="xCNMenuplus" role="button" data-toggle="collapse" href="#odvCSSCustomerInfo" aria-expanded="true">
                        <i class="fa fa-plus xCNPlus"></i>
                    </a>
                </div>
                <div id="odvCSSCustomerInfo" class="panel-collapse collapse in" role="tabpanel">
                    <div class="panel-body">

                        <div class="mb-3 row">
                            <label class="col-md-4 col-form-label"><strong><?=language('document/checkstatussale/checkstatussale', 'tCSSCstCode');?></strong></label>
                            <div class="col-md-8"><?=$tCstCode?></div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-md-4 col-form-label"><strong><?=language('document/checkstatussale/checkstatussale', 'tCSSCstName');?></strong></label>
                            <div class="col-md-8"><?=$tCstName?></div>
                        </div>

                        <!-- <div class="mb-3 row">
                            <label class="col-md-12 col-form-label"><strong><?=language('document/checkstatussale/checkstatussale', 'tCSSCstAddr');?></strong></label>
                            <div class="col-md-12" style='padding-left:25px;padding-right:25px;'>
                            <?php
                                $aDataAddr = [
                                    'tAddVersion'       => $tFTAddVersion,
                                    'tAddV1No'          => $tFTAddV1No,
                                    'tAddV1Village'     => $tFTAddV1Village,
                                    'tAddV1Road'        => $tFTAddV1Road,
                                    'tAddV1Soi'         => $tFTAddV1Soi,
                                    'tSudName'          => $tFTSudName,
                                    'tDstName'          => $tFTDstName,
                                    'tPvnCode'          => $tFTPvnCode,
                                    'tPvnName'          => $tFTPvnName,
                                    'tAddV1PostCode'    => $tFTAddV1PostCode,
                                    'tAddV2Desc1'       => $tFTAddV2Desc1,
                                    'tAddV2Desc2'       => $tFTAddV2Desc2
                                ];
                                echo FCNtHAddConvertFormat($aDataAddr);
                            ?>
                            </div>
                        </div> -->

                        <!-- <div class="mb-3 row">
                            <label class="col-md-12 col-form-label"><strong><?=language('document/checkstatussale/checkstatussale', 'tCSSCstTax');?></strong></label>
                            <div class="col-md-12" style='padding-left:25px;padding-right:25px;'><?=$tCstTaxNo?></div>
                        </div> -->

                        <div class="mb-3 row">
                            <label class="col-md-4 col-form-label"><strong><?=language('document/checkstatussale/checkstatussale', 'tCSSCstTel');?></strong></label>
                            <div class="col-md-8"><?=$tCstTel?></div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-md-4 col-form-label"><strong><?=language('document/checkstatussale/checkstatussale', 'tCSSCstEmail');?></strong></label>
                            <div class="col-md-8"><?=$tCstEmail?></div>
                        </div>

                    </div>
                </div>
            </div>
            <!-- End Panel ข้อมูลลูกค้า -->

            <!-- Panel อ้างอิงเอกสาร -->
            <div class="panel panel-default" style="margin-bottom: 25px;">
                <div id="odvHeadStatus" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
                    <label class="xCNTextDetail1"><?=language('document/checkstatussale/checkstatussale', 'tCSSDocRefTitle');?></label>
                    <a class="xCNMenuplus collapsed" role="button" data-toggle="collapse" href="#odvCSSDocRefInfo" aria-expanded="true">
                        <i class="fa fa-plus xCNPlus"></i>
                    </a>
                </div>
                <div id="odvCSSDocRefInfo" class="panel-collapse collapse" role="tabpanel">
                    <div class="panel-body">

                        <div class="mb-3 row">
                            <label class="col-md-12 col-form-label" style="margin-bottom: 0px;"><strong><?=language('document/checkstatussale/checkstatussale', 'tCSSDocRefIn');?></strong></label>
                            <div class="col-md-12" style='padding-left:25px;padding-right:25px;'><?=$tXshRefInt?></div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-md-12 col-form-label" style="margin-bottom: 0px;"><strong><?=language('document/checkstatussale/checkstatussale', 'tCSSDocDateRefIn');?></strong></label>
                            <div class="col-md-12" style='padding-left:25px;padding-right:25px;'><?=$tXshRefIntDate?></div>
                        </div>

                        <hr style='margin: 5px;'>

                        <div class="mb-3 row">
                            <label class="col-md-12 col-form-label" style="margin-bottom: 0px;"><strong><?=language('document/checkstatussale/checkstatussale', 'tCSSDocRefOut');?></strong></label>
                            <div class="col-md-12" style='padding-left:25px;padding-right:25px;'><?=$tXshRefExt?></div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-md-12 col-form-label" style="margin-bottom: 0px;"><strong><?=language('document/checkstatussale/checkstatussale', 'tCSSDocDateRefOut');?></strong></label>
                            <div class="col-md-12" style='padding-left:25px;padding-right:25px;'><?=$tXshRefExtDate?></div>
                        </div>

                    </div>
                </div>
            </div>
            <!-- End Panel อ้างอิงเอกสาร -->

            <!-- Panel อื่นๆ -->
            <div class="panel panel-default" style="margin-bottom: 25px;">
                <div id="odvHeadStatus" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
                    <label class="xCNTextDetail1"><?=language('document/checkstatussale/checkstatussale', 'tCSSAnotherTitle');?></label>
                    <a class="xCNMenuplus collapsed" role="button" data-toggle="collapse" href="#odvCSSAnotherInfo" aria-expanded="true">
                        <i class="fa fa-plus xCNPlus"></i>
                    </a>
                </div>
                <div id="odvCSSAnotherInfo" class="panel-collapse collapse" role="tabpanel">
                    <div class="panel-body">

                        <div class="mb-3 row">
                            <label class="col-md-12 col-form-label" style="margin-bottom: 0px;"><strong><?=language('document/checkstatussale/checkstatussale', 'tCSSRemark');?></strong></label>
                            <div class="col-md-12" style='padding-left:25px;padding-right:25px;'><?=$tXshRmk?></div>
                        </div>

                    </div>
                </div>
            </div>
            <!-- End Panel อื่นๆ -->

        </div>

            

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-9">
            <div class="row">
                <!-- ตารางสินค้า -->
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="panel panel-default" style="margin-bottom:25px;position:relative;min-height:200px;">
                        <div class="panel-collapse collapse in" role="tabpanel" data-grpname="Condition">
                            <div class="panel-body">
                                <div style="margin-top: 10px;">

                                    <!-- ค้นหา -->
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">

                                            <div class="form-group">
                                                <label class="xCNLabelFrm"><?=language('common/main/main','tSearchNew');?></label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control xCNInputWithoutSingleQuote" id="oetCSSFilterPdt" name="oetCSSFilterPdt" onkeyup="Javascript:if(event.keyCode==13) JSxCSSPageProductDataTable()" autocomplete="off" placeholder="<?=language('document/document/document','tDocSearchPlaceHolder');?>">
                                                    <span class="input-group-btn">
                                                        <button class="btn xCNBtnSearch" type="button" onclick="JSxCSSPageProductDataTable()" >
                                                            <img class="xCNIconAddOn" src="<?php echo base_url().'/application/modules/common/assets/images/icons/search-24.png'?>">
                                                        </button>
                                                    </span>
                                                </div>
                                            </div>
                                            
                                        </div>
                                        <!-- End ค้นหา -->

                                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-right">
                                            <button id="obtCSSChkPdtSN" class="btn xCNBTNPrimery xWCSSHideObj" style="margin-top: 26px;" type="button"><?=language('document/checkstatussale/checkstatussale','tCSSBtnChkPdtSN')?></button>
                                        </div>
                                    </div>

                                    <!-- แสดงรายการสินค้า -->
                                    <div class="row p-t-10" id="odvCSSProductDataTableContent"></div>
                                    <!-- END แสดงรายการสินค้า -->

                                    <?php include('wCheckStatusSaleEndOfBill.php'); ?>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- จบตารางสินค้า -->

            </div>
        </div>

    </div>

</form>

<!-- ============================================ Modal Enter S/N ============================================ -->
<div id="odvCSSModalChkPdtSN" class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" style="z-index: 7000;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header xCNModalHead">
                    <label class="xCNTextModalHeard"><?= language('document/checkstatussale/checkstatussale', 'tCSSSerialTitle') ?></label>
                </div>
                <div class="modal-body">

                    <div class="row">

                        <div id="odvModalChkPdtSNScanBarCode" class="col-xs-12 col-md-12 col-lg-12">
                            <div class="form-group">
                                <label class="xCNLabelFrm"><?= language('document/checkstatussale/checkstatussale','tCSSScanBarCode')?></label>
                                <div class="input-group">
                                    <input type="text" class="form-control xCNInputWithoutSingleQuote" id="oetCSSScanBarCode" name="oetCSSScanBarCode" onkeyup="Javascript:if(event.keyCode==13) JSxCSSEventScanPdtSN()" autocomplete="off" placeholder="<?php echo language('document/checkstatussale/checkstatussale','tCSSScanBarCode'); ?>">
                                    <span class="input-group-btn">
                                        <button class="btn xCNBtnSearch" type="button" onclick="JSxCSSEventScanPdtSN()" >
                                            <img class="xCNIconAddOn" src="<?php echo base_url().'/application/modules/common/assets/images/icons/search-24.png'?>">
                                        </button>
                                    </span>
                                </div>
                            </div>

                            <hr>

                        </div>

                        <div class="col-xs-12 col-md-12 col-lg-12">
                            <div id="odvCSSPdtSNList"></div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <div class="row">
                        <div class="col-md-7">
                            <div id="odvCSSCountPdtSN" class="text-left"></div>
                        </div>
                        <div class="col-md-5">
                            <button id="obtCSSConfirmChkPdtSN" type="button"  class="btn xCNBTNPrimery"><?php echo language('common/main/main', 'tModalConfirm');?></button>
                            <button id="obtCSSCancelChkPdtSN" type="button" class="btn xCNBTNDefult" data-dismiss="modal"><?php echo language('common/main/main', 'tCancel');?></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!-- ================================================================================================================================= -->

<!-- ================================================================= View Modal Appove Document ================================================================= -->
<div id="odvCSSModalAppoveDoc" class="modal fade xCNModalApprove">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="xCNHeardModal modal-title" style="display:inline-block"><?= language('common/main/main', 'tApproveTheDocument'); ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p><?= language('common/main/main', 'tMainApproveStatus'); ?></p>
                <ul>
                    <li><?= language('common/main/main', 'tMainApproveStatus1'); ?></li>
                    <li><?= language('common/main/main', 'tMainApproveStatus2'); ?></li>
                    <li><?= language('common/main/main', 'tMainApproveStatus3'); ?></li>
                    <li><?= language('common/main/main', 'tMainApproveStatus4'); ?></li>
                </ul>
                <p><?= language('common/main/main', 'tMainApproveStatus5'); ?></p>
                <p><strong><?= language('common/main/main', 'tMainApproveStatus6'); ?></strong></p>
            </div>
            <div class="modal-footer">
                <button id="obtCSSConfirmApvDoc" type="button" class="btn xCNBTNPrimery"><?= language('common/main/main', 'tModalConfirm'); ?></button>
                <button type="button" class="btn xCNBTNDefult" data-dismiss="modal"><?= language('common/main/main', 'tModalCancel'); ?></button>
            </div>
        </div>
    </div>
</div>
<!-- ============================================================================================================================================================== -->

<!-- =========================================== สร้างใบจัดสินค้า ======================================= -->
<div id="odvCSSGenDocPacking" class="modal fade" tabindex="2" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header xCNModalHead">
                <label class="xCNTextModalHeard"><?=language('document/checkstatussale/checkstatussale','สร้างใบจัดสินค้า')?></label>
            </div>
            <div class="modal-body">
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12 col-xs-12">
						<b>ยืนยันสร้างใบจัดสินค้า</b>
					</div>
				</div>
            </div>
            <div class="modal-footer">
				<button id="obtCSSConfigGenDocPacking" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button" data-dismiss="modal"><?= language('common/main/main', 'กำหนดค่า')?></button>
                <button id="obtCSSConfirmGenDocPacking" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" type="button" data-dismiss="modal"><?= language('common/main/main', 'tModalConfirm')?></button>
                <button class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"  data-dismiss="modal"><?= language('common/main/main', 'tModalCancel')?></button>
            </div>
        </div>
    </div>
</div>

<div id="odvCSSConfigGenDocPacking" class="modal fade" tabindex="2" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header xCNModalHead">
                <label class="xCNTextModalHeard"><?=language('document/checkstatussale/checkstatussale','กำหนดเงื่อนไขการสร้างใบจัดสินค้า')?></label>
            </div>
            <div class="modal-body">
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12 col-xs-12">
						<div class="checkbox">
							<label>
								<input type="checkbox" class="xWCSSSysSeq0" name="ocbCSSCondtionGenPacking" value="0">สร้างใบจัดตามที่เก็บ
							</label>
						</div>
						<div class="checkbox">
							<label>
								<input type="checkbox" class="xWCSSSysSeq1" name="ocbCSSCondtionGenPacking" value="1">สร้างใบจัดตามหมวดสินค้า 1
							</label>
						</div>
						<div class="checkbox">
							<label>
								<input type="checkbox" class="xWCSSSysSeq2" name="ocbCSSCondtionGenPacking" value="2">สร้างใบจัดตามหมวดสินค้า 2
							</label>
						</div>
						<div class="checkbox">
							<label>
								<input type="checkbox" class="xWCSSSysSeq3" name="ocbCSSCondtionGenPacking" value="3">สร้างใบจัดตามหมวดสินค้า 3
							</label>
						</div>
						<div class="checkbox">
							<label>
								<input type="checkbox" class="xWCSSSysSeq4" name="ocbCSSCondtionGenPacking" value="4">สร้างใบจัดตามหมวดสินค้า 4
							</label>
						</div>
						<div class="checkbox">
							<label>
								<input type="checkbox" class="xWCSSSysSeq5" name="ocbCSSCondtionGenPacking" value="5">สร้างใบจัดตามหมวดสินค้า 5
							</label>
						</div>

					</div>
				</div>
            </div>
            <div class="modal-footer">
                <button id="obtCSSConfirmConfigGenDocPacking" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" type="button" data-dismiss="modal"><?= language('common/main/main', 'tModalConfirm')?></button>
                <button id="obtCSSCancelConfigGenDocPacking" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"  data-dismiss="modal"><?= language('common/main/main', 'tModalCancel')?></button>
            </div>
        </div>
    </div>
</div>
<!-- =========================================== สร้างใบจัดสินค้า ======================================= -->

<!-- =========================================== สร้างใบส่งของ ======================================= -->
<div id="odvCSSGenDocDelivery" class="modal fade" tabindex="2" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header xCNModalHead">
                <label class="xCNTextModalHeard"><?=language('document/checkstatussale/checkstatussale','สร้างใบส่งของ')?></label>
            </div>
            <div class="modal-body">
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12 col-xs-12">
						<b>ยืนยันสร้างใบส่งของ</b>
					</div>
				</div>
            </div>
            <div class="modal-footer">
                <button id="obtCSSConfirmGenDocDelivery" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" type="button" data-dismiss="modal"><?= language('common/main/main', 'tModalConfirm')?></button>
                <button class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"  data-dismiss="modal"><?= language('common/main/main', 'tModalCancel')?></button>
            </div>
        </div>
    </div>
</div>
<!-- =========================================== สร้างใบส่งของ ======================================= -->

<?php include('script/jCheckStatusSalePageAdd.php'); ?>