<?php
    $tMerchantCode  = $tMerchantcode;
    
    // Set Sta Call View Route
    if(isset($nStaCallView) && $nStaCallView == 1){
        $tMerchantAddrRoute ="merchantEventAddAddress";
    }else{
        $tMerchantAddrRoute ="merchantEventEditAddress";
    }

    // Check Data Address
    if(isset($aDataAddress) && !empty($aDataAddress)){
        $FTAddRefCode       = $aDataAddress['FTAddRefCode'];
        $nFNAddSeqNo        = $aDataAddress['FNAddSeqNo'];
        $tFTAddVersion      = $aDataAddress['FTAddVersion'];
        $tFTAddName         = $aDataAddress['FTAddName'];
        $tFTAddGrpType      = $aDataAddress['FTAddGrpType'];
        $tFTAddRefNo        = $aDataAddress['FTAddRefNo'];
        $tFTAddTaxNo        = $aDataAddress['FTAddTaxNo'];
        $tFTAddV2Desc1      = $aDataAddress['FTAddV2Desc1'];
        $tFTAddV2Desc2      = $aDataAddress['FTAddV2Desc2'];
        $tFTAddWebsite      = $aDataAddress['FTAddWebsite'];
        $tFTAddRmk          = $aDataAddress['FTAddRmk'];
        $tFTAddLongitude    = $aDataAddress['FTAddLongitude'];
        $tFTAddLatitude     = $aDataAddress['FTAddLatitude'];
        //จบฟอร์มสัน
        $tFTAddCountry      = $aDataAddress['FTAddCountry'];
        $tFTAddV1No         = $aDataAddress['FTAddV1No'];
        $tFTAddV1Village    = $aDataAddress['FTAddV1Village'];
        $tFTAddV1Road       = $aDataAddress['FTAddV1Road'];
        $tFTAddV1Soi        = $aDataAddress['FTAddV1Soi'];
        $tFTAddV1PostCode   = $aDataAddress['FTAddV1PostCode'];
        $tFTAddV1PvnCode    = $aDataAddress['FTPvnCode'];
        $tFTPvnName         = $aDataAddress['FTPvnName'];
        $tFTAddV1DstCode    = $aDataAddress['FTDstCode'];
        $tFTDstName         = $aDataAddress['FTDstName'];
        $tFTAddV1SubDist    = $aDataAddress['FTSudCode'];
        $tFTSudName         = $aDataAddress['FTSudName'];
    }else{
        $FTAddRefCode       = "";
        $nFNAddSeqNo        = "";
        $tFTAddVersion      = "";
        $tFTAddName         = "";
        $tFTAddGrpType      = "";
        $tFTAddRefNo        = "";
        $tFTAddTaxNo        = "";
        $tFTAddV2Desc1      = "";
        $tFTAddV2Desc2      = "";
        $tFTAddWebsite      = "";
        $tFTAddRmk          = "";
        $tFTAddLongitude    = "";
        $tFTAddLatitude     = "";
        //จบฟอร์มสัน
        $tFTAddCountry      = "";
        $tFTAddV1No         = "";
        $tFTAddV1Village    = "";
        $tFTAddV1Road       = "";
        $tFTAddV1Soi        = "";
        $tFTAddV1PostCode   = "";
        $tFTAddV1PvnCode    = "";
        $tFTPvnName         = "";
        $tFTAddV1DstCode    = "";
        $tFTDstName         = "";
        $tFTAddV1SubDist    = "";
        $tFTSudName         = "";
    }

    // Config Version Address (ใช้ที่อยู่แบบแยก หรือ แบบรวม)
    if(isset($aDataAddressConfig) && !empty($aDataAddressConfig)){
        if(isset($aDataAddressConfig['FTSysStaUsrValue']) && !empty($aDataAddressConfig['FTSysStaUsrValue'])){
            $nStaVertionAddress = $aDataAddressConfig['FTSysStaUsrValue']; // ใช้ที่อยู่แบบที่ User กำหนด
        }else{
            $nStaVertionAddress = $aDataAddressConfig['FTSysStaDefValue']; // ใช้ที่อยู่แบบที่ Systems กำหนด
        }
    }else{
        $nStaVertionAddress = 1;
    }
?>
<form id="ofmMerchantAddAddress" class="contact100-form validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data">
    <button class="xCNHide" id="obtAddEditMerchantAddress" type="submit" onclick="JSoAddEditMerchantAddress()"></button>
    <input type="hidden" id="ohdMerchantAddressRoute" name="ohdMerchantAddressRoute" value="<?php echo @$tMerchantAddrRoute;?>">
    <input type="hidden" id="ohdMerchantCode" name="ohdMerchantCode" value="<?php echo @$tMerchantCode;?>">
    <input type="hidden" id="ohdMerchantAddrGrpType" name="ohdMerchantAddrGrpType" value="7">
    <input type="hidden" id="ohdMerchantVersion" name="ohdMerchantVersion" value="<?php echo @$nStaVertionAddress;?>">
    <input type="hidden" id="ohdMerchantSeqNo" name="ohdMerchantSeqNo" value="<?php echo @$nFNAddSeqNo;?>">
    <input type="hidden" id="oetMerchantMapLong" name="oetMerchantMapLong" value="<?php echo @$tFTAddLongitude;?>">
    <input type="hidden" id="oetMerchantMapLat" name="oetMerchantMapLat" value="<?php echo @$tFTAddLatitude;?>">
    <?php if(isset($nStaVertionAddress) && $nStaVertionAddress == 2):?>
        <div class="panel-body" style="padding:0;">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <div  class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('merchant/merchant/merchant','tAddressName');?></label>
                            <input 
                                type="text"
                                class="form-control"
                                maxlength="200"
                                id="oetMerchantAddrName"
                                name="oetMerchantAddrName" 
                                autocomplete="off"
                                value="<?php echo @$tFTAddName;?>"
                            >
                        </div>
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('merchant/merchant/merchant','tAddTaxNo');?></label>
                            <input
                                type="text"
                                class="form-control"
                                maxlength="20"
                                id="oetMerchantAddrTaxNo"
                                name="oetMerchantAddrTaxNo"
                                autocomplete="off"
                                value="<?php echo @$tFTAddTaxNo;?>"
                            >
                        </div>
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('merchant/merchant/merchant','tAddV2Desc1');?></label>
                            <textarea class="form-control" rows="2" maxlength="100" id="oetMerchantAddrV2Desc1" name="oetMerchantAddrV2Desc1"><?php echo @$tFTAddV2Desc1;?></textarea>
                        </div>
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('merchant/merchant/merchant','tAddV2Desc2');?></label>
                            <textarea class="form-control" rows="2" maxlength="100" id="oetMerchantAddrV2Desc2" name="oetMerchantAddrV2Desc2"><?php echo @$tFTAddV2Desc2;?></textarea>
                        </div>
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('merchant/merchant/merchant','tAddWebsite')?></label>
                            <input 
                                type="text"
                                class="form-control"
                                maxlength="200"
                                id="oetMerchantAddrWebSite"
                                name="oetMerchantAddrWebSite" 
                                value="<?php echo @$tFTAddWebsite;?>"
                            >
                        </div>
                        <div  class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('merchant/merchant/merchant','tAddRmk')?></label>
                            <textarea class="form-control" rows="4" maxlength="100" id="oetMerchantAddrRmk" name="oetMerchantAddrRmk"><?php echo @$tFTAddRmk;?></textarea>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 p-t-25">
                        <div class="form-group">
                            <div id="odvMerchantAddrMapView" class="xCNMapShow"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php else:?>
        <div class="panel-body" style="padding:0;">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <div  class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('merchant/merchant/merchant','tAddressName');?></label>
                            <div class="form-group">
                                <input
                                    type="text"
                                    class="form-control"
                                    maxlength="200"
                                    id="oetMerchantAddrName"
                                    name="oetMerchantAddrName" 
                                    value="<?php echo @$tFTAddName;?>"
                                >
                            </div>
                            <div  class="form-group">
                                <label class="xCNLabelFrm"><?php echo language('merchant/merchant/merchant','tAddTaxNo')?></label>
                                <input
                                    type="text"
                                    class="form-control"
                                    maxlength="20"
                                    id="oetMerchantAddrTaxNo"
                                    name="oetMerchantAddrTaxNo" 
                                    value="<?php echo @$tFTAddTaxNo;?>"
                                >
                            </div>
                            <div  class="form-group">
                                <label class="xCNLabelFrm"><?php echo language('merchant/merchant/merchant','tAddWebsite')?></label>
                                <input
                                    type="text"
                                    class="form-control"
                                    maxlength="200"
                                    id="oetMerchantAddrWeb"
                                    name="oetMerchantAddrWeb" 
                                    value="<?php echo @$tFTAddWebsite;?>"
                                >
                            </div>
                            <div class="form-group">
                                <label class="xCNLabelFrm"><?php echo language('merchant/merchant/merchant','tAddV1No');?></label>
                                <input 
                                    type="text"
                                    class="form-control"
                                    maxlength="30"
                                    id="oetMerchantAddrNo"
                                    name="oetMerchantAddrNo"
                                    value="<?php echo @$tFTAddV1No;?>"
                                >
                            </div>
                            <div class="form-group">
                                <label class="xCNLabelFrm"><?php echo language('merchant/merchant/merchant','tAddV1Village')?></label>
                                <input
                                    type="text"
                                    class="form-control"
                                    maxlength="70"
                                    id="oetMerchantAddrVillage"
                                    name="oetMerchantAddrVillage"
                                    value="<?php echo @$tFTAddV1Village;?>"
                                >
                            </div>
                            <div  class="form-group">
                                <label class="xCNLabelFrm"><?php echo language('merchant/merchant/merchant','tAddV1Road')?></label>
                                <input
                                    type="text"
                                    class="form-control"
                                    maxlength="30"
                                    id="oetMerchantAddrRoad"
                                    name="oetMerchantAddrRoad"
                                    value="<?php echo @$tFTAddV1Road;?>"
                                >
                            </div>
                            <div  class="form-group">
                                <label class="xCNLabelFrm"><?php echo language('merchant/merchant/merchant','tAddV1Soi')?></label>
                                <input
                                    type="text"
                                    class="form-control"
                                    maxlength="30"
                                    id="oetMerchantAddrSoi"
                                    name="oetMerchantAddrSoi"
                                    value="<?php echo @$tFTAddV1Soi;?>"
                                >
                            </div>
                            <div class="form-group">
                                <label class="xCNLabelFrm"><?php echo  language('merchant/merchant/merchant','tAddV1PvnCode')?></label>
                                <div class="input-group">
                                    <input 
                                        type="text"
                                        class="form-control xCNHide"
                                        id="oetMerchantAddrPvnCode"
                                        name="oetMerchantAddrPvnCode"
                                        maxlength="5"
                                        value="<?php echo @$tFTAddV1PvnCode;?>"
                                    >
                                    <input 
                                        type="text"
                                        class="form-control xWPointerEventNone"
                                        id="oetMerchantAddrPvnName" name="oetMerchantAddrPvnName"
                                        value="<?php echo @$tFTPvnName;?>"
                                        readonly
                                    >
                                    <span class="input-group-btn">
                                        <button id="obtMerChantAddrBrowseProvince" type="button" class="btn xCNBtnBrowseAddOn">
                                            <img src="<?php echo  base_url().'application/modules/common/assets/images/icons/find-24.png'?>">
                                        </button>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="xCNLabelFrm"><?php echo  language('merchant/merchant/merchant','tAddV1DstCode')?></label>
                                <div class="input-group">
                                    <input
                                        type="text"
                                        class="form-control xCNHide"
                                        id="oetMerchantAddrDstCode"
                                        name="oetMerchantAddrDstCode"
                                        maxlength="5"
                                        value="<?php echo @$tFTAddV1DstCode;?>"
                                    >
                                    <input
                                        type="text"
                                        class="form-control xWPointerEventNone"
                                        id="oetMerchantAddrDstName"
                                        name="oetMerchantAddrDstName"
                                        value="<?php echo @$tFTDstName ?>"
                                        readonly
                                    >
                                    <span class="input-group-btn xCNStartDisabled">
                                        <button id="obtMerChantAddrBrowseDistrict" type="button" class="btn xCNBtnBrowseAddOn">
                                            <img src="<?php echo  base_url().'application/modules/common/assets/images/icons/find-24.png'?>">
                                        </button>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="xCNLabelFrm"><?php echo  language('merchant/merchant/merchant','tAddV1SubDist')?></label>
                                <div class="input-group">
                                    <input
                                        type="text"
                                        class="form-control xCNHide"
                                        id="oetMerchantAddrSubDstCode"
                                        name="oetMerchantAddrSubDstCode"
                                        maxlength="5"
                                        value="<?php echo @$tFTAddV1SubDist;?>"
                                    >
                                    <input
                                        type="text"
                                        class="form-control xWPointerEventNone"
                                        id="oetMerchantAddrSubDstName"
                                        name="oetMerchantAddrSubDstName"
                                        value="<?php echo @$tFTSudName;?>"
                                        readonly
                                    >
                                    <span class="input-group-btn xCNStartDisabled">
                                        <button id="obtMerChantAddrBrowseSubDistrict" type="button" class="btn xCNBtnBrowseAddOn">
                                            <img src="<?php echo  base_url().'application/modules/common/assets/images/icons/find-24.png'?>">
                                        </button>
                                    </span>
                                </div>
                            </div>
                            <div  class="form-group">
                                <label class="xCNLabelFrm"><?php echo language('merchant/merchant/merchant','tAddV1PostCode')?></label>
                                <input
                                    type="text"
                                    class="form-control"
                                    maxlength="5"
                                    id="oetMerchantAddrPostCode"
                                    name="oetMerchantAddrPostCode"
                                    value="<?php echo @$tFTAddV1PostCode;?>"
                                >
                            </div>
                            <div  class="form-group">
                                <label class="xCNLabelFrm"><?php echo language('merchant/merchant/merchant','tAddRmk');?></label>
                                <textarea class="form-control" rows="4" maxlength="100" id="oetMerchantAddrRmk" name="oetMerchantAddrRmk"><?php echo @$tFTAddRmk;?></textarea>
                            </div>   
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 p-t-25">
                        <div class="form-group">
                            <div id="odvMerchantAddrMapView" class="xCNMapShow"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif;?>
</form>
<script src="<?php echo base_url('application/modules/common/assets/js/jquery.mask.js')?>"></script>
<script src="<?php echo base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>
<?php include "script/jMerchantAddressForm.php";?>

