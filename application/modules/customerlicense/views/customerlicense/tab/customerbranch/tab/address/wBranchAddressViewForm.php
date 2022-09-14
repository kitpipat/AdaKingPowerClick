<?php
    $tBranchAddrRefCode   = $tCbrRefBch;
    // Set Sta Call View Route
    if(isset($nStaCallView) && $nStaCallView == 1){
        $tBranchAddrRoute ="BchAddrEventAdd";
    }else{
        $tBranchAddrRoute ="BchAddrEventEdit";
    }

    // Check Data Address
    if(isset($aDataAddress) && !empty($aDataAddress)){
        $nFNAddSeqNo        = $aDataAddress['FNAddSeqNo'];
        $tFTAddVersion      = $aDataAddress['FTAddVersion'];
        $tFTAddName         = $aDataAddress['FTAddName'];
        $tFTAddGrpType      = $aDataAddress['FTAddGrpType'];
        $tFTAddRefNo        = $aDataAddress['FTAddRefNo'];
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
    if(isset($aBranchDataVersion) && !empty($aBranchDataVersion)){
        if(isset($aBranchDataVersion['FTSysStaUsrValue']) && !empty($aBranchDataVersion['FTSysStaUsrValue'])){
            $nStaVersionAddress = $aBranchDataVersion['FTSysStaUsrValue']; // ใช้ที่อยู่แบบที่ User กำหนด
        }else{
            $nStaVersionAddress = $aBranchDataVersion['FTSysStaDefValue']; // ใช้ที่อยู่แบบที่ Systems กำหนด
        }
    }else{
        $nStaVersionAddress = 1;
    }
?>
<form id="ofmBranchAddressForm" class="validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data">
    <button class="xCNHide" id="obtAddEditBranchAddress"  type="submit" onclick="JSoAddEditBranchAddress()"></button>
    <!-- From Input Hidden Address Branch -->
    <input type="hidden" id="ohdBranchAddressRoute"   name="ohdBranchAddressRoute"      value="<?php echo @$tBranchAddrRoute;?>">
    <input type="hidden" id="ohdBranchAddressRefCode" name="ohdBranchAddressRefCode"    value="<?php echo @$tBranchAddrRefCode;?>">
    <input type="hidden" id="ohdBranchAddressVersion" name="ohdBranchAddressVersion"    value="<?php echo @$nStaVersionAddress;?>">
    <input type="hidden" id="ohdBranchAddressGrpType" name="ohdBranchAddressGrpType"    value="<?php echo @$tFTAddGrpType;?>">
    <input type="hidden" id="ohdBranchAddressSeqNo"   name="ohdBranchAddressSeqNo"      value="<?php echo @$nFNAddSeqNo;?>">
    <input type="hidden" id="ohdBranchAddressMapLong" name="ohdBranchAddressMapLong"    value="<?php echo @$tFTAddLongitude;?>">
    <input type="hidden" id="ohdBranchAddressMapLat"  name="ohdBranchAddressMapLat"     value="<?php echo @$tFTAddLatitude;?>">
    <input type="hidden" id="ohdBranchAddressCstCode"  name="ohdBranchAddressCstCode"     value="<?php echo @$tCstCode;?>">
    <input type="hidden" id="ohdBranchAddressCbrRefBch"  name="ohdBranchAddressCbrRefBch"     value="<?php echo @$tCbrRefBch;?>">   
    
    <?php if(isset($nStaVersionAddress) && $nStaVersionAddress == 2):?>
        <div class="panel-body" style="padding:0;">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <div  class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('company/branch/branch','tBCHAddressName');?></label>
                            <input 
                                type="text"
                                class="form-control"
                                maxlength="200"
                                id="oetBranchAddressName"
                                name="oetBranchAddressName" 
                                autocomplete="off"
                                value="<?php echo @$tFTAddName;?>"
                            >
                        </div>
                        <!-- <div class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('company/branch/branch','tBCHAddTaxNo');?></label>
                            <input
                                type="text"
                                class="form-control"
                                maxlength="20"
                                id="oetBranchAddressTaxNo"
                                name="oetBranchAddressTaxNo"
                                autocomplete="off"
                                value="<?php //echo @$tFTAddTaxNo;?>"
                            >
                        </div> -->
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('company/branch/branch','tBCHAddV2Desc1');?></label>
                            <textarea class="form-control" rows="2" maxlength="250" id="oetBranchAddressV2Desc1" name="oetBranchAddressV2Desc1"><?php echo @$tFTAddV2Desc1;?></textarea>
                        </div>
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('company/branch/branch','tBCHAddV2Desc2');?></label>
                            <textarea class="form-control" rows="2" maxlength="250" id="oetBranchAddressV2Desc2" name="oetBranchAddressV2Desc2"><?php echo @$tFTAddV2Desc2;?></textarea>
                        </div>
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('company/branch/branch','tBCHAddWebsite')?></label>
                            <input 
                                type="text"
                                class="form-control"
                                maxlength="200"
                                id="oetBranchAddressWebSite"
                                name="oetBranchAddressWebSite" 
                                value="<?php echo @$tFTAddWebsite;?>"
                            >
                        </div>
                        <div  class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('company/branch/branch','tBCHAddRmk')?></label>
                            <textarea class="form-control" rows="4" maxlength="100" id="oetBranchAddressRmk" name="oetBranchAddressRmk"><?php echo @$tFTAddRmk;?></textarea>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 p-t-25">
                        <div class="form-group">
                            <div id="odvBranchAddressMapView" class="xCNMapShow"></div>
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
                            <label class="xCNLabelFrm"><?php echo language('company/branch/branch','tBCHAddressName');?></label>
                            <div class="form-group">
                                <input
                                    type="text"
                                    class="form-control"
                                    maxlength="200"
                                    id="oetBranchAddressName"
                                    name="oetBranchAddressName" 
                                    value="<?php echo @$tFTAddName;?>"
                                >
                            </div>
                            <!-- <div  class="form-group">
                                <label class="xCNLabelFrm"><?php echo language('company/branch/branch','tBCHAddTaxNo')?></label>
                                <input
                                    type="text"
                                    class="form-control"
                                    maxlength="20"
                                    id="oetBranchAddressTaxNo"
                                    name="oetBranchAddressTaxNo" 
                                    value="<?php //echo @$tFTAddTaxNo;?>"
                                >
                            </div> -->
                            <div  class="form-group">
                                <label class="xCNLabelFrm"><?php echo language('company/branch/branch','tBCHAddWebsite')?></label>
                                <input
                                    type="text"
                                    class="form-control"
                                    maxlength="200"
                                    id="oetBranchAddressWeb"
                                    name="oetBranchAddressWeb" 
                                    value="<?php echo @$tFTAddWebsite;?>"
                                >
                            </div>
                            <div class="form-group">
                                <label class="xCNLabelFrm"><?php echo language('company/branch/branch','tBCHAddV1No');?></label>
                                <input 
                                    type="text"
                                    class="form-control"
                                    maxlength="30"
                                    id="oetBranchAddressNo"
                                    name="oetBranchAddressNo"
                                    value="<?php echo @$tFTAddV1No;?>"
                                >
                            </div>
                            <div class="form-group">
                                <label class="xCNLabelFrm"><?php echo language('company/branch/branch','tBCHAddV1Village')?></label>
                                <input
                                    type="text"
                                    class="form-control"
                                    maxlength="70"
                                    id="oetBranchAddressVillage"
                                    name="oetBranchAddressVillage"
                                    value="<?php echo @$tFTAddV1Village;?>"
                                >
                            </div>
                            <div  class="form-group">
                                <label class="xCNLabelFrm"><?php echo language('company/branch/branch','tBCHAddV1Road')?></label>
                                <input
                                    type="text"
                                    class="form-control"
                                    maxlength="30"
                                    id="oetBranchAddressRoad"
                                    name="oetBranchAddressRoad"
                                    value="<?php echo @$tFTAddV1Road;?>"
                                >
                            </div>
                            <div  class="form-group">
                                <label class="xCNLabelFrm"><?php echo language('company/branch/branch','tBCHAddV1Soi')?></label>
                                <input
                                    type="text"
                                    class="form-control"
                                    maxlength="30"
                                    id="oetBranchAddressSoi"
                                    name="oetBranchAddressSoi"
                                    value="<?php echo @$tFTAddV1Soi;?>"
                                >
                            </div>
                            <div class="form-group">
                                <label class="xCNLabelFrm"><?php echo  language('company/branch/branch','tBCHAddV1PvnCode')?></label>
                                <div class="input-group">
                                    <input 
                                        type="text"
                                        class="form-control xCNHide"
                                        id="oetBranchAddressPvnCode"
                                        name="oetBranchAddressPvnCode"
                                        maxlength="5"
                                        value="<?php echo @$tFTAddV1PvnCode;?>"
                                    >
                                    <input 
                                        type="text"
                                        class="form-control xWPointerEventNone"
                                        id="oetBranchAddressPvnName" name="oetBranchAddressPvnName"
                                        value="<?php echo @$tFTPvnName;?>"
                                        readonly
                                    >
                                    <span class="input-group-btn">
                                        <button id="obtBranchAddressBrowseProvince" type="button" class="btn xCNBtnBrowseAddOn">
                                            <img src="<?php echo  base_url().'application/modules/common/assets/images/icons/find-24.png'?>">
                                        </button>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="xCNLabelFrm"><?php echo  language('company/branch/branch','tBCHAddV1DstCode')?></label>
                                <div class="input-group">
                                    <input
                                        type="text"
                                        class="form-control xCNHide"
                                        id="oetBranchAddressDstCode"
                                        name="oetBranchAddressDstCode"
                                        maxlength="5"
                                        value="<?php echo @$tFTAddV1DstCode;?>"
                                    >
                                    <input
                                        type="text"
                                        class="form-control xWPointerEventNone"
                                        id="oetBranchAddressDstName"
                                        name="oetBranchAddressDstName"
                                        value="<?php echo @$tFTDstName ?>"
                                        readonly
                                    >
                                    <span class="input-group-btn xCNStartDisabled">
                                        <button id="obtBranchAddressBrowseDistrict" type="button" class="btn xCNBtnBrowseAddOn">
                                            <img src="<?php echo  base_url().'application/modules/common/assets/images/icons/find-24.png'?>">
                                        </button>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="xCNLabelFrm"><?php echo  language('company/branch/branch','tBCHAddV1SubDist')?></label>
                                <div class="input-group">
                                    <input
                                        type="text"
                                        class="form-control xCNHide"
                                        id="oetBranchAddressSubDstCode"
                                        name="oetBranchAddressSubDstCode"
                                        maxlength="5"
                                        value="<?php echo @$tFTAddV1SubDist;?>"
                                    >
                                    <input
                                        type="text"
                                        class="form-control xWPointerEventNone"
                                        id="oetBranchAddressSubDstName"
                                        name="oetBranchAddressSubDstName"
                                        value="<?php echo @$tFTSudName;?>"
                                        readonly
                                    >
                                    <span class="input-group-btn xCNStartDisabled">
                                        <button id="obtBranchAddressBrowseSubDistrict" type="button" class="btn xCNBtnBrowseAddOn">
                                            <img src="<?php echo  base_url().'application/modules/common/assets/images/icons/find-24.png'?>">
                                        </button>
                                    </span>
                                </div>
                            </div>
                            <div  class="form-group">
                                <label class="xCNLabelFrm"><?php echo language('company/branch/branch','tBCHAddV1PostCode')?></label>
                                <input
                                    type="text"
                                    class="form-control"
                                    maxlength="5"
                                    id="oetBranchAddressPostCode"
                                    name="oetBranchAddressPostCode"
                                    value="<?php echo @$tFTAddV1PostCode;?>"
                                >
                            </div>
                            <div  class="form-group">
                                <label class="xCNLabelFrm"><?php echo language('company/branch/branch','tBCHAddRmk');?></label>
                                <textarea class="form-control" rows="4" maxlength="100" id="oetBranchAddressRmk" name="oetBranchAddressRmk"><?php echo @$tFTAddRmk;?></textarea>
                            </div>   
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 p-t-25">
                        <div class="form-group">
                            <div id="odvBranchAddressMapView" class="xCNMapShow"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif;?>
</form>
<script src="<?php echo base_url('application/modules/common/assets/js/jquery.mask.js')?>"></script>
<script src="<?php echo base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>
<?php include "script/jBranchAddressForm.php";?>