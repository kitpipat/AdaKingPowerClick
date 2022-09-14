<?php
    $tSalemachineAddrRefCode    = $tSalemachineAddrPosCode;

    // Set Sta Call View Route
    if(isset($nStaCallView) && $nStaCallView == 1){
        $tSalemachineAddrRoute  = "salemachineAddressAddEvent";
    }else{
        $tSalemachineAddrRoute  = "salemachineAddressEditEvent";
    }

    // Check Data Address
    if(isset($aDataAddress) && !empty($aDataAddress)){
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
        $nFNAddSeqNo        = "";
        $tFTAddVersion      = "";
        $tFTAddName         = "";
        $tFTAddGrpType      = "6";
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
    if(isset($aSalemachineDataVersion) && !empty($aSalemachineDataVersion)){
        if(isset($aSalemachineDataVersion['FTSysStaUsrValue']) && !empty($aSalemachineDataVersion['FTSysStaUsrValue'])){
            $nStaVersionAddress = $aSalemachineDataVersion['FTSysStaUsrValue']; // ใช้ที่อยู่แบบที่ User กำหนด
        }else{
            $nStaVersionAddress = $aSalemachineDataVersion['FTSysStaDefValue']; // ใช้ที่อยู่แบบที่ Systems กำหนด
        }
    }else{
        $nStaVersionAddress = 1;
    }
?>
<form id="ofmSalemachineAddressForm" class="validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data">
    <button class="xCNHide" id="obtAddEditSalemachineAddress"  type="submit" onclick="JSoAddEditSalemachineAddress()"></button>    
    <!-- From Input Hidden Address Salemachine -->
    <input type="hidden" id="ohdSalemachineAddressRoute"   name="ohdSalemachineAddressRoute"      value="<?php echo @$tSalemachineAddrRoute;?>">
    <input type="hidden" id="ohdSalemachineAddressRefCode" name="ohdSalemachineAddressRefCode"    value="<?php echo @$tSalemachineAddrRefCode;?>">
    <input type="hidden" id="ohdSalemachineAddressVersion" name="ohdSalemachineAddressVersion"    value="<?php echo @$nStaVersionAddress;?>">
    <input type="hidden" id="ohdSalemachineAddressGrpType" name="ohdSalemachineAddressGrpType"    value="<?php echo @$tFTAddGrpType;?>">
    <input type="hidden" id="ohdSalemachineAddressSeqNo"   name="ohdSalemachineAddressSeqNo"      value="<?php echo @$nFNAddSeqNo;?>">
    <input type="hidden" id="ohdSalemachineAddressMapLong" name="ohdSalemachineAddressMapLong"    value="<?php echo @$tFTAddLongitude;?>">
    <input type="hidden" id="ohdSalemachineAddressMapLat"  name="ohdSalemachineAddressMapLat"     value="<?php echo @$tFTAddLatitude;?>">
    <?php if(isset($nStaVersionAddress) && $nStaVersionAddress == 2):?>
        <div class="panel-body" style="padding:0;">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <div  class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('courier/courier/courier','tCRYAddressName');?></label>
                            <input 
                                type="text"
                                class="form-control"
                                maxlength="200"
                                id="oetSalemachineAddressName"
                                name="oetSalemachineAddressName" 
                                autocomplete="off"
                                value="<?php echo @$tFTAddName;?>"
                            >
                        </div>
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('courier/courier/courier','tCRYAddTaxNo');?></label>
                            <input
                                type="text"
                                class="form-control"
                                maxlength="20"
                                id="oetSalemachineAddressTaxNo"
                                name="oetSalemachineAddressTaxNo"
                                autocomplete="off"
                                value="<?php echo @$tFTAddTaxNo;?>"
                            >
                        </div>
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('courier/courier/courier','tCRYAddV2Desc1');?></label>
                            <textarea class="form-control" rows="2" maxlength="100" id="oetSalemachineAddressV2Desc1" name="oetSalemachineAddressV2Desc1"><?php echo @$tFTAddV2Desc1;?></textarea>
                        </div>
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('courier/courier/courier','tCRYAddV2Desc2');?></label>
                            <textarea class="form-control" rows="2" maxlength="100" id="oetSalemachineAddressV2Desc2" name="oetSalemachineAddressV2Desc2"><?php echo @$tFTAddV2Desc2;?></textarea>
                        </div>
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('courier/courier/courier','tCRYAddWebsite')?></label>
                            <input 
                                type="text"
                                class="form-control"
                                maxlength="200"
                                id="oetSalemachineAddressWebSite"
                                name="oetSalemachineAddressWebSite" 
                                value="<?php echo @$tFTAddWebsite;?>"
                            >
                        </div>
                        <div  class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('courier/courier/courier','tCRYAddRmk')?></label>
                            <textarea class="form-control" rows="4" maxlength="100" id="oetSalemachineAddressRmk" name="oetSalemachineAddressRmk"><?php echo @$tFTAddRmk;?></textarea>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 p-t-25">
                        <div class="form-group">
                            <div id="odvSalemachineAddressMapView" class="xCNMapShow"></div>
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
                            <label class="xCNLabelFrm"><?php echo language('courier/courier/courier','tCRYAddressName');?></label>
                            <div class="form-group">
                                <input
                                    type="text"
                                    class="form-control"
                                    maxlength="200"
                                    id="oetSalemachineAddressName"
                                    name="oetSalemachineAddressName" 
                                    value="<?php echo @$tFTAddName;?>"
                                >
                            </div>
                            <div  class="form-group">
                                <label class="xCNLabelFrm"><?php echo language('courier/courier/courier','tCRYAddTaxNo')?></label>
                                <input
                                    type="text"
                                    class="form-control"
                                    maxlength="20"
                                    id="oetSalemachineAddressTaxNo"
                                    name="oetSalemachineAddressTaxNo" 
                                    value="<?php echo @$tFTAddTaxNo;?>"
                                >
                            </div>
                            <div  class="form-group">
                                <label class="xCNLabelFrm"><?php echo language('courier/courier/courier','tCRYAddWebsite')?></label>
                                <input
                                    type="text"
                                    class="form-control"
                                    maxlength="200"
                                    id="oetSalemachineAddressWeb"
                                    name="oetSalemachineAddressWeb" 
                                    value="<?php echo @$tFTAddWebsite;?>"
                                >
                            </div>
                            <div class="form-group">
                                <label class="xCNLabelFrm"><?php echo language('courier/courier/courier','tCRYAddV1No');?></label>
                                <input 
                                    type="text"
                                    class="form-control"
                                    maxlength="30"
                                    id="oetSalemachineAddressNo"
                                    name="oetSalemachineAddressNo"
                                    value="<?php echo @$tFTAddV1No;?>"
                                >
                            </div>
                            <div class="form-group">
                                <label class="xCNLabelFrm"><?php echo language('courier/courier/courier','tCRYAddV1Village')?></label>
                                <input
                                    type="text"
                                    class="form-control"
                                    maxlength="70"
                                    id="oetSalemachineAddressVillage"
                                    name="oetSalemachineAddressVillage"
                                    value="<?php echo @$tFTAddV1Village;?>"
                                >
                            </div>
                            <div  class="form-group">
                                <label class="xCNLabelFrm"><?php echo language('courier/courier/courier','tCRYAddV1Road')?></label>
                                <input
                                    type="text"
                                    class="form-control"
                                    maxlength="30"
                                    id="oetSalemachineAddressRoad"
                                    name="oetSalemachineAddressRoad"
                                    value="<?php echo @$tFTAddV1Road;?>"
                                >
                            </div>
                            <div  class="form-group">
                                <label class="xCNLabelFrm"><?php echo language('courier/courier/courier','tCRYAddV1Soi')?></label>
                                <input
                                    type="text"
                                    class="form-control"
                                    maxlength="30"
                                    id="oetSalemachineAddressSoi"
                                    name="oetSalemachineAddressSoi"
                                    value="<?php echo @$tFTAddV1Soi;?>"
                                >
                            </div>
                            <div class="form-group">
                                <label class="xCNLabelFrm"><?php echo  language('courier/courier/courier','tCRYAddV1PvnCode')?></label>
                                <div class="input-group">
                                    <input 
                                        type="text"
                                        class="form-control xCNHide"
                                        id="oetSalemachineAddressPvnCode"
                                        name="oetSalemachineAddressPvnCode"
                                        maxlength="5"
                                        value="<?php echo @$tFTAddV1PvnCode;?>"
                                    >
                                    <input 
                                        type="text"
                                        class="form-control xWPointerEventNone"
                                        id="oetSalemachineAddressPvnName" name="oetSalemachineAddressPvnName"
                                        value="<?php echo @$tFTPvnName;?>"
                                        readonly
                                    >
                                    <span class="input-group-btn">
                                        <button id="obtSalemachineAddressBrowseProvince" type="button" class="btn xCNBtnBrowseAddOn">
                                            <img src="<?php echo  base_url().'application/modules/common/assets/images/icons/find-24.png'?>">
                                        </button>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="xCNLabelFrm"><?php echo  language('courier/courier/courier','tCRYAddV1DstCode')?></label>
                                <div class="input-group">
                                    <input
                                        type="text"
                                        class="form-control xCNHide"
                                        id="oetSalemachineAddressDstCode"
                                        name="oetSalemachineAddressDstCode"
                                        maxlength="5"
                                        value="<?php echo @$tFTAddV1DstCode;?>"
                                    >
                                    <input
                                        type="text"
                                        class="form-control xWPointerEventNone"
                                        id="oetSalemachineAddressDstName"
                                        name="oetSalemachineAddressDstName"
                                        value="<?php echo @$tFTDstName ?>"
                                        readonly
                                    >
                                    <span class="input-group-btn xCNStartDisabled">
                                        <button id="obtSalemachineAddressBrowseDistrict" type="button" class="btn xCNBtnBrowseAddOn">
                                            <img src="<?php echo  base_url().'application/modules/common/assets/images/icons/find-24.png'?>">
                                        </button>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="xCNLabelFrm"><?php echo  language('courier/courier/courier','tCRYAddV1SubDist')?></label>
                                <div class="input-group">
                                    <input
                                        type="text"
                                        class="form-control xCNHide"
                                        id="oetSalemachineAddressSubDstCode"
                                        name="oetSalemachineAddressSubDstCode"
                                        maxlength="5"
                                        value="<?php echo @$tFTAddV1SubDist;?>"
                                    >
                                    <input
                                        type="text"
                                        class="form-control xWPointerEventNone"
                                        id="oetSalemachineAddressSubDstName"
                                        name="oetSalemachineAddressSubDstName"
                                        value="<?php echo @$tFTSudName;?>"
                                        readonly
                                    >
                                    <span class="input-group-btn xCNStartDisabled">
                                        <button id="obtSalemachineAddressBrowseSubDistrict" type="button" class="btn xCNBtnBrowseAddOn">
                                            <img src="<?php echo  base_url().'application/modules/common/assets/images/icons/find-24.png'?>">
                                        </button>
                                    </span>
                                </div>
                            </div>
                            <div  class="form-group">
                                <label class="xCNLabelFrm"><?php echo language('courier/courier/courier','tCRYAddV1PostCode')?></label>
                                <input
                                    type="text"
                                    class="form-control"
                                    maxlength="5"
                                    id="oetSalemachineAddressPostCode"
                                    name="oetSalemachineAddressPostCode"
                                    value="<?php echo @$tFTAddV1PostCode;?>"
                                >
                            </div>
                            <div  class="form-group">
                                <label class="xCNLabelFrm"><?php echo language('courier/courier/courier','tCRYAddRmk');?></label>
                                <textarea class="form-control" rows="4" maxlength="100" id="oetSalemachineAddressRmk" name="oetSalemachineAddressRmk"><?php echo @$tFTAddRmk;?></textarea>
                            </div>   
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 p-t-25">
                        <div class="form-group">
                            <div id="odvSalemachineAddressMapView" class="xCNMapShow"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif;?>
</form>
<script src="<?php echo base_url('application/modules/common/assets/js/jquery.mask.js')?>"></script>
<script src="<?php echo base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>
<?php include "script/jSalemachineAddressForm.php";?>