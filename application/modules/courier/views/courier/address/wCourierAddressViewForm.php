<?php
    $tCourierAddrRefCode   = $tCourierAddrCryCode;

    // Set Sta Call View Route
    if(isset($nStaCallView) && $nStaCallView == 1){
        $tCourierAddrRoute  = "courierAddressAddEvent";
    }else{
        $tCourierAddrRoute  = "courierAddressEditEvent";
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
        $tFTAddGrpType      = "8";
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
    if(isset($aCourierDataVersion) && !empty($aCourierDataVersion)){
        if(isset($aCourierDataVersion['FTSysStaUsrValue']) && !empty($aCourierDataVersion['FTSysStaUsrValue'])){
            $nStaVersionAddress = $aCourierDataVersion['FTSysStaUsrValue']; // ใช้ที่อยู่แบบที่ User กำหนด
        }else{
            $nStaVersionAddress = $aCourierDataVersion['FTSysStaDefValue']; // ใช้ที่อยู่แบบที่ Systems กำหนด
        }
    }else{
        $nStaVersionAddress = 1;
    }
?>
<form id="ofmCourierAddressForm" class="validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data">
    <button class="xCNHide" id="obtAddEditCourierAddress"  type="submit" onclick="JSoAddEditCourierAddress()"></button>    
    <!-- From Input Hidden Address Courier -->
    <input type="hidden" id="ohdCourierAddressRoute"   name="ohdCourierAddressRoute"      value="<?php echo @$tCourierAddrRoute;?>">
    <input type="hidden" id="ohdCourierAddressRefCode" name="ohdCourierAddressRefCode"    value="<?php echo @$tCourierAddrRefCode;?>">
    <input type="hidden" id="ohdCourierAddressVersion" name="ohdCourierAddressVersion"    value="<?php echo @$nStaVersionAddress;?>">
    <input type="hidden" id="ohdCourierAddressGrpType" name="ohdCourierAddressGrpType"    value="<?php echo @$tFTAddGrpType;?>">
    <input type="hidden" id="ohdCourierAddressSeqNo"   name="ohdCourierAddressSeqNo"      value="<?php echo @$nFNAddSeqNo;?>">
    <input type="hidden" id="ohdCourierAddressMapLong" name="ohdCourierAddressMapLong"    value="<?php echo @$tFTAddLongitude;?>">
    <input type="hidden" id="ohdCourierAddressMapLat"  name="ohdCourierAddressMapLat"     value="<?php echo @$tFTAddLatitude;?>">
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
                                id="oetCourierAddressName"
                                name="oetCourierAddressName" 
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
                                id="oetCourierAddressTaxNo"
                                name="oetCourierAddressTaxNo"
                                autocomplete="off"
                                value="<?php echo @$tFTAddTaxNo;?>"
                            >
                        </div>
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('courier/courier/courier','tCRYAddV2Desc1');?></label>
                            <textarea class="form-control" rows="2" maxlength="100" id="oetCourierAddressV2Desc1" name="oetCourierAddressV2Desc1"><?php echo @$tFTAddV2Desc1;?></textarea>
                        </div>
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('courier/courier/courier','tCRYAddV2Desc2');?></label>
                            <textarea class="form-control" rows="2" maxlength="100" id="oetCourierAddressV2Desc2" name="oetCourierAddressV2Desc2"><?php echo @$tFTAddV2Desc2;?></textarea>
                        </div>
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('courier/courier/courier','tCRYAddWebsite')?></label>
                            <input 
                                type="text"
                                class="form-control"
                                maxlength="200"
                                id="oetCourierAddressWebSite"
                                name="oetCourierAddressWebSite" 
                                value="<?php echo @$tFTAddWebsite;?>"
                            >
                        </div>
                        <div  class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('courier/courier/courier','tCRYAddRmk')?></label>
                            <textarea class="form-control" rows="4" maxlength="100" id="oetCourierAddressRmk" name="oetCourierAddressRmk"><?php echo @$tFTAddRmk;?></textarea>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 p-t-25">
                        <div class="form-group">
                            <div id="odvCourierAddressMapView" class="xCNMapShow"></div>
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
                                    id="oetCourierAddressName"
                                    name="oetCourierAddressName" 
                                    value="<?php echo @$tFTAddName;?>"
                                >
                            </div>
                            <div  class="form-group">
                                <label class="xCNLabelFrm"><?php echo language('courier/courier/courier','tCRYAddTaxNo')?></label>
                                <input
                                    type="text"
                                    class="form-control"
                                    maxlength="20"
                                    id="oetCourierAddressTaxNo"
                                    name="oetCourierAddressTaxNo" 
                                    value="<?php echo @$tFTAddTaxNo;?>"
                                >
                            </div>
                            <div  class="form-group">
                                <label class="xCNLabelFrm"><?php echo language('courier/courier/courier','tCRYAddWebsite')?></label>
                                <input
                                    type="text"
                                    class="form-control"
                                    maxlength="200"
                                    id="oetCourierAddressWeb"
                                    name="oetCourierAddressWeb" 
                                    value="<?php echo @$tFTAddWebsite;?>"
                                >
                            </div>
                            <div class="form-group">
                                <label class="xCNLabelFrm"><?php echo language('courier/courier/courier','tCRYAddV1No');?></label>
                                <input 
                                    type="text"
                                    class="form-control"
                                    maxlength="30"
                                    id="oetCourierAddressNo"
                                    name="oetCourierAddressNo"
                                    value="<?php echo @$tFTAddV1No;?>"
                                >
                            </div>
                            <div class="form-group">
                                <label class="xCNLabelFrm"><?php echo language('courier/courier/courier','tCRYAddV1Village')?></label>
                                <input
                                    type="text"
                                    class="form-control"
                                    maxlength="70"
                                    id="oetCourierAddressVillage"
                                    name="oetCourierAddressVillage"
                                    value="<?php echo @$tFTAddV1Village;?>"
                                >
                            </div>
                            <div  class="form-group">
                                <label class="xCNLabelFrm"><?php echo language('courier/courier/courier','tCRYAddV1Road')?></label>
                                <input
                                    type="text"
                                    class="form-control"
                                    maxlength="30"
                                    id="oetCourierAddressRoad"
                                    name="oetCourierAddressRoad"
                                    value="<?php echo @$tFTAddV1Road;?>"
                                >
                            </div>
                            <div  class="form-group">
                                <label class="xCNLabelFrm"><?php echo language('courier/courier/courier','tCRYAddV1Soi')?></label>
                                <input
                                    type="text"
                                    class="form-control"
                                    maxlength="30"
                                    id="oetCourierAddressSoi"
                                    name="oetCourierAddressSoi"
                                    value="<?php echo @$tFTAddV1Soi;?>"
                                >
                            </div>
                            <div class="form-group">
                                <label class="xCNLabelFrm"><?php echo  language('courier/courier/courier','tCRYAddV1PvnCode')?></label>
                                <div class="input-group">
                                    <input 
                                        type="text"
                                        class="form-control xCNHide"
                                        id="oetCourierAddressPvnCode"
                                        name="oetCourierAddressPvnCode"
                                        maxlength="5"
                                        value="<?php echo @$tFTAddV1PvnCode;?>"
                                    >
                                    <input 
                                        type="text"
                                        class="form-control xWPointerEventNone"
                                        id="oetCourierAddressPvnName" name="oetCourierAddressPvnName"
                                        value="<?php echo @$tFTPvnName;?>"
                                        readonly
                                    >
                                    <span class="input-group-btn">
                                        <button id="obtCourierAddressBrowseProvince" type="button" class="btn xCNBtnBrowseAddOn">
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
                                        id="oetCourierAddressDstCode"
                                        name="oetCourierAddressDstCode"
                                        maxlength="5"
                                        value="<?php echo @$tFTAddV1DstCode;?>"
                                    >
                                    <input
                                        type="text"
                                        class="form-control xWPointerEventNone"
                                        id="oetCourierAddressDstName"
                                        name="oetCourierAddressDstName"
                                        value="<?php echo @$tFTDstName ?>"
                                        readonly
                                    >
                                    <span class="input-group-btn xCNStartDisabled">
                                        <button id="obtCourierAddressBrowseDistrict" type="button" class="btn xCNBtnBrowseAddOn">
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
                                        id="oetCourierAddressSubDstCode"
                                        name="oetCourierAddressSubDstCode"
                                        maxlength="5"
                                        value="<?php echo @$tFTAddV1SubDist;?>"
                                    >
                                    <input
                                        type="text"
                                        class="form-control xWPointerEventNone"
                                        id="oetCourierAddressSubDstName"
                                        name="oetCourierAddressSubDstName"
                                        value="<?php echo @$tFTSudName;?>"
                                        readonly
                                    >
                                    <span class="input-group-btn xCNStartDisabled">
                                        <button id="obtCourierAddressBrowseSubDistrict" type="button" class="btn xCNBtnBrowseAddOn">
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
                                    id="oetCourierAddressPostCode"
                                    name="oetCourierAddressPostCode"
                                    value="<?php echo @$tFTAddV1PostCode;?>"
                                >
                            </div>
                            <div  class="form-group">
                                <label class="xCNLabelFrm"><?php echo language('courier/courier/courier','tCRYAddRmk');?></label>
                                <textarea class="form-control" rows="4" maxlength="100" id="oetCourierAddressRmk" name="oetCourierAddressRmk"><?php echo @$tFTAddRmk;?></textarea>
                            </div>   
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 p-t-25">
                        <div class="form-group">
                            <div id="odvCourierAddressMapView" class="xCNMapShow"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif;?>
</form>
<script src="<?php echo base_url('application/modules/common/assets/js/jquery.mask.js')?>"></script>
<script src="<?php echo base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>
<?php include "script/jCourierAddressForm.php";?>