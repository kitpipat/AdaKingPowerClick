<?php
    $tShopAddrRefCode   = $tShpAddrShopCode;
    // Set Sta Call View Route
    if(isset($nStaCallView) && $nStaCallView == 1){
        $tShopAddrRoute ="shopAddressAddEvent";
    }else{
        $tShopAddrRoute ="shopAddressEditEvent";
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
        $tFTAddGrpType      = "4";
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
    if(isset($aShopDataVersion) && !empty($aShopDataVersion)){
        if(isset($aShopDataVersion['FTSysStaUsrValue']) && !empty($aShopDataVersion['FTSysStaUsrValue'])){
            $nStaVersionAddress = $aShopDataVersion['FTSysStaUsrValue']; // ใช้ที่อยู่แบบที่ User กำหนด
        }else{
            $nStaVersionAddress = $aShopDataVersion['FTSysStaDefValue']; // ใช้ที่อยู่แบบที่ Systems กำหนด
        }
    }else{
        $nStaVersionAddress = 1;
    }
?>
<form id="ofmShopAddressForm" class="validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data">
    <button class="xCNHide" id="obtAddEditShopAddress"  type="submit" onclick="JSoAddEditShopAddress()"></button>
    <!-- From Input Hidden Address Shop -->
    <input type="hidden" id="ohdShopAddressRoute"   name="ohdShopAddressRoute"      value="<?php echo @$tShopAddrRoute;?>">
    <input type="hidden" id="ohdShopAddressRefCode" name="ohdShopAddressRefCode"    value="<?php echo @$tShopAddrRefCode;?>">
    <input type="hidden" id="ohdShopAddressVersion" name="ohdShopAddressVersion"    value="<?php echo @$nStaVersionAddress;?>">
    <input type="hidden" id="ohdShopAddressGrpType" name="ohdShopAddressGrpType"    value="<?php echo @$tFTAddGrpType;?>">
    <input type="hidden" id="ohdShopAddressSeqNo"   name="ohdShopAddressSeqNo"      value="<?php echo @$nFNAddSeqNo;?>">
    <input type="hidden" id="ohdShopAddressMapLong" name="ohdShopAddressMapLong"    value="<?php echo @$tFTAddLongitude;?>">
    <input type="hidden" id="ohdShopAddressMapLat"  name="ohdShopAddressMapLat"     value="<?php echo @$tFTAddLatitude;?>">

    <?php if(isset($nStaVersionAddress) && $nStaVersionAddress == 2):?>
        <div class="panel-body" style="padding:0;">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <div  class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('company/shop/shop','tSHPAddressName');?></label>
                            <input 
                                type="text"
                                class="form-control"
                                maxlength="200"
                                id="oetShopAddressName"
                                name="oetShopAddressName" 
                                autocomplete="off"
                                value="<?php echo @$tFTAddName;?>"
                            >
                        </div>
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('company/shop/shop','tSHPAddTaxNo');?></label>
                            <input
                                type="text"
                                class="form-control"
                                maxlength="20"
                                id="oetShopAddressTaxNo"
                                name="oetShopAddressTaxNo"
                                autocomplete="off"
                                value="<?php echo @$tFTAddTaxNo;?>"
                            >
                        </div>
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('company/shop/shop','tSHPAddV2Desc1');?></label>
                            <textarea class="form-control" rows="2" maxlength="100" id="oetShopAddressV2Desc1" name="oetShopAddressV2Desc1"><?php echo @$tFTAddV2Desc1;?></textarea>
                        </div>
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('company/shop/shop','tSHPAddV2Desc2');?></label>
                            <textarea class="form-control" rows="2" maxlength="100" id="oetShopAddressV2Desc2" name="oetShopAddressV2Desc2"><?php echo @$tFTAddV2Desc2;?></textarea>
                        </div>
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('company/shop/shop','tSHPAddWebsite')?></label>
                            <input 
                                type="text"
                                class="form-control"
                                maxlength="200"
                                id="oetShopAddressWebSite"
                                name="oetShopAddressWebSite" 
                                value="<?php echo @$tFTAddWebsite;?>"
                            >
                        </div>
                        <div  class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('company/shop/shop','tSHPAddRmk')?></label>
                            <textarea class="form-control" rows="4" maxlength="100" id="oetShopAddressRmk" name="oetShopAddressRmk"><?php echo @$tFTAddRmk;?></textarea>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 p-t-25">
                        <div class="form-group">
                            <div id="odvShopAddressMapView" class="xCNMapShow"></div>
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
                            <label class="xCNLabelFrm"><?php echo language('company/shop/shop','tSHPAddressName');?></label>
                            <div class="form-group">
                                <input
                                    type="text"
                                    class="form-control"
                                    maxlength="200"
                                    id="oetShopAddressName"
                                    name="oetShopAddressName" 
                                    value="<?php echo @$tFTAddName;?>"
                                >
                            </div>
                            <div  class="form-group">
                                <label class="xCNLabelFrm"><?php echo language('company/shop/shop','tSHPAddTaxNo')?></label>
                                <input
                                    type="text"
                                    class="form-control"
                                    maxlength="20"
                                    id="oetShopAddressTaxNo"
                                    name="oetShopAddressTaxNo" 
                                    value="<?php echo @$tFTAddTaxNo;?>"
                                >
                            </div>
                            <div  class="form-group">
                                <label class="xCNLabelFrm"><?php echo language('company/shop/shop','tSHPAddWebsite')?></label>
                                <input
                                    type="text"
                                    class="form-control"
                                    maxlength="200"
                                    id="oetShopAddressWeb"
                                    name="oetShopAddressWeb" 
                                    value="<?php echo @$tFTAddWebsite;?>"
                                >
                            </div>
                            <div class="form-group">
                                <label class="xCNLabelFrm"><?php echo language('company/shop/shop','tSHPAddV1No');?></label>
                                <input 
                                    type="text"
                                    class="form-control"
                                    maxlength="30"
                                    id="oetShopAddressNo"
                                    name="oetShopAddressNo"
                                    value="<?php echo @$tFTAddV1No;?>"
                                >
                            </div>
                            <div class="form-group">
                                <label class="xCNLabelFrm"><?php echo language('company/shop/shop','tSHPAddV1Village')?></label>
                                <input
                                    type="text"
                                    class="form-control"
                                    maxlength="70"
                                    id="oetShopAddressVillage"
                                    name="oetShopAddressVillage"
                                    value="<?php echo @$tFTAddV1Village;?>"
                                >
                            </div>
                            <div  class="form-group">
                                <label class="xCNLabelFrm"><?php echo language('company/shop/shop','tSHPAddV1Road')?></label>
                                <input
                                    type="text"
                                    class="form-control"
                                    maxlength="30"
                                    id="oetShopAddressRoad"
                                    name="oetShopAddressRoad"
                                    value="<?php echo @$tFTAddV1Road;?>"
                                >
                            </div>
                            <div  class="form-group">
                                <label class="xCNLabelFrm"><?php echo language('company/shop/shop','tSHPAddV1Soi')?></label>
                                <input
                                    type="text"
                                    class="form-control"
                                    maxlength="30"
                                    id="oetShopAddressSoi"
                                    name="oetShopAddressSoi"
                                    value="<?php echo @$tFTAddV1Soi;?>"
                                >
                            </div>
                            <div class="form-group">
                                <label class="xCNLabelFrm"><?php echo  language('company/shop/shop','tSHPAddV1PvnCode')?></label>
                                <div class="input-group">
                                    <input 
                                        type="text"
                                        class="form-control xCNHide"
                                        id="oetShopAddressPvnCode"
                                        name="oetShopAddressPvnCode"
                                        maxlength="5"
                                        value="<?php echo @$tFTAddV1PvnCode;?>"
                                    >
                                    <input 
                                        type="text"
                                        class="form-control xWPointerEventNone"
                                        id="oetShopAddressPvnName" name="oetShopAddressPvnName"
                                        value="<?php echo @$tFTPvnName;?>"
                                        readonly
                                    >
                                    <span class="input-group-btn">
                                        <button id="obtShopAddressBrowseProvince" type="button" class="btn xCNBtnBrowseAddOn">
                                            <img src="<?php echo  base_url().'application/modules/common/assets/images/icons/find-24.png'?>">
                                        </button>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="xCNLabelFrm"><?php echo  language('company/shop/shop','tSHPAddV1DstCode')?></label>
                                <div class="input-group">
                                    <input
                                        type="text"
                                        class="form-control xCNHide"
                                        id="oetShopAddressDstCode"
                                        name="oetShopAddressDstCode"
                                        maxlength="5"
                                        value="<?php echo @$tFTAddV1DstCode;?>"
                                    >
                                    <input
                                        type="text"
                                        class="form-control xWPointerEventNone"
                                        id="oetShopAddressDstName"
                                        name="oetShopAddressDstName"
                                        value="<?php echo @$tFTDstName ?>"
                                        readonly
                                    >
                                    <span class="input-group-btn xCNStartDisabled">
                                        <button id="obtShopAddressBrowseDistrict" type="button" class="btn xCNBtnBrowseAddOn">
                                            <img src="<?php echo  base_url().'application/modules/common/assets/images/icons/find-24.png'?>">
                                        </button>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="xCNLabelFrm"><?php echo  language('company/shop/shop','tSHPAddV1SubDist')?></label>
                                <div class="input-group">
                                    <input
                                        type="text"
                                        class="form-control xCNHide"
                                        id="oetShopAddressSubDstCode"
                                        name="oetShopAddressSubDstCode"
                                        maxlength="5"
                                        value="<?php echo @$tFTAddV1SubDist;?>"
                                    >
                                    <input
                                        type="text"
                                        class="form-control xWPointerEventNone"
                                        id="oetShopAddressSubDstName"
                                        name="oetShopAddressSubDstName"
                                        value="<?php echo @$tFTSudName;?>"
                                        readonly
                                    >
                                    <span class="input-group-btn xCNStartDisabled">
                                        <button id="obtShopAddressBrowseSubDistrict" type="button" class="btn xCNBtnBrowseAddOn">
                                            <img src="<?php echo  base_url().'application/modules/common/assets/images/icons/find-24.png'?>">
                                        </button>
                                    </span>
                                </div>
                            </div>
                            <div  class="form-group">
                                <label class="xCNLabelFrm"><?php echo language('company/shop/shop','tSHPAddV1PostCode')?></label>
                                <input
                                    type="text"
                                    class="form-control"
                                    maxlength="5"
                                    id="oetShopAddressPostCode"
                                    name="oetShopAddressPostCode"
                                    value="<?php echo @$tFTAddV1PostCode;?>"
                                >
                            </div>
                            <div  class="form-group">
                                <label class="xCNLabelFrm"><?php echo language('company/shop/shop','tSHPAddRmk');?></label>
                                <textarea class="form-control" rows="4" maxlength="100" id="oetShopAddressRmk" name="oetShopAddressRmk"><?php echo @$tFTAddRmk;?></textarea>
                            </div>   
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 p-t-25">
                        <div class="form-group">
                            <div id="odvShopAddressMapView" class="xCNMapShow"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif;?>
</form>
<script src="<?php echo base_url('application/modules/common/assets/js/jquery.mask.js')?>"></script>
<script src="<?php echo base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>
<?php include "script/jShopAddressForm.php";?>