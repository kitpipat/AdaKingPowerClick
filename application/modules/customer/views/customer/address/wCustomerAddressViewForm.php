<?php
     $tCSTAddrCode  = $tCSTAddrCstCode;
    // Set Sta Call View Route
    if(isset($nStaCallView) && $nStaCallView == 1){
        $tCSTAddrRoute  ="customerAddressAddEvent";
    }else{
        $tCSTAddrRoute  ="customerAddressEditEvent";
    }
    // print_r($aCSTDataAddress);
    // Check Data Address
    if(isset($aCSTDataAddress) && !empty($aCSTDataAddress)){
        $tFTCstCode         = $aCSTDataAddress['FTCstCode'];
        $tFTAddGrpType      = $aCSTDataAddress['FTAddGrpType'];
        $nFNAddSeqNo        = $aCSTDataAddress['FNAddSeqNo'];
        $tFTAddRefNo        = $aCSTDataAddress['FTAddRefNo'];
        $tFTAddName         = $aCSTDataAddress['FTAddName'];
        $tFTAddRmk          = $aCSTDataAddress['FTAddRmk'];
        $tFTAreCode         = $aCSTDataAddress['FTAreCode'];
        $tFTAreName         = $aCSTDataAddress['FTAreName'];
        $tFTZneChain        = $aCSTDataAddress['FTZneChain'];
        $tFTZneChainName    = $aCSTDataAddress['FTZneChainName'];
        $tFTZneCode         = $aCSTDataAddress['FTZneCode'];
        $tFTZneName         = $aCSTDataAddress['FTZneName'];
        $tFTAddVersion      = $aCSTDataAddress['FTAddVersion'];
        $tFTAddV2Desc1      = $aCSTDataAddress['FTAddV2Desc1'];
        $tFTAddV2Desc2      = $aCSTDataAddress['FTAddV2Desc2'];
        $tFTAddWebsite      = $aCSTDataAddress['FTAddWebsite'];
        $tFTAddLongitude    = $aCSTDataAddress['FTAddLongitude'];
        $tFTAddLatitude     = $aCSTDataAddress['FTAddLatitude'];
        // จบฟอร์มสัน
        $tFTAddCountry      = $aCSTDataAddress['FTAddCountry'];
        $tFTAddV1No         = $aCSTDataAddress['FTAddV1No'];
        $tFTAddV1Village    = $aCSTDataAddress['FTAddV1Village'];
        $tFTAddV1Road       = $aCSTDataAddress['FTAddV1Road'];
        $tFTAddV1Soi        = $aCSTDataAddress['FTAddV1Soi'];
        $tFTAddV1PostCode   = $aCSTDataAddress['FTAddV1PostCode'];
        $tFTAddV1PvnCode    = $aCSTDataAddress['FTPvnCode'];
        $tFTPvnName         = $aCSTDataAddress['FTPvnName'];
        $tFTAddV1DstCode    = $aCSTDataAddress['FTDstCode'];
        $tFTDstName         = $aCSTDataAddress['FTDstName'];
        $tFTAddV1SubDist    = $aCSTDataAddress['FTSudCode'];
        $tFTSudName         = $aCSTDataAddress['FTSudName'];
        $tStaGrpType1       ="";
        $tStaGrpType2       ="";
        $tStaGrpType3       ="";
        switch ($tFTAddGrpType) {
            case '1':
                        $tStaGrpType1 = "selected active";
                break;
            case '2':
                        $tStaGrpType2 = "selected active";
                break;
            case '3':
                        $tStaGrpType3 = "selected active";
                break;
        }

    }else{
        $tFTCstCode         = $tCSTAddrCode;
        $tFTAddGrpType      = "1";
        $nFNAddSeqNo        = "";
        $tFTAddRefNo        = "";
        $tFTAddName         = "";
        $tFTAddRmk          = "";
        $tFTAreCode         = "";
        $tFTAreName         = "";
        $tFTZneChain        = "";
        $tFTZneChainName    = "";
        $tFTZneCode         = "";
        $tFTZneName         = "";
        $tFTAddVersion      = "";
        $tFTAddV2Desc1      = "";
        $tFTAddV2Desc2      = "";
        $tFTAddWebsite      = "";
        $tFTAddLongitude    = "";
        $tFTAddLatitude     = "";
        // จบฟอร์มสัน
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

        $tStaGrpType1       ="";
        $tStaGrpType2       ="";
        $tStaGrpType3       ="";
    }

    if(isset($aCSTDataVersion) && !empty($aCSTDataVersion)){
        if(isset($aCSTDataVersion['FTSysStaUsrValue']) && !empty($aCSTDataVersion['FTSysStaUsrValue'])){
            $nStaVersionAddress = $aCSTDataVersion['FTSysStaUsrValue']; // ใช้ที่อยู่แบบที่ User กำหนด
        }else{
            $nStaVersionAddress = $aCSTDataVersion['FTSysStaDefValue']; // ใช้ที่อยู่แบบที่ Systems กำหนด
        }
    }else{
        $nStaVersionAddress = 1;
    }
?>
<form id="ofmCSTAddressForm" class="validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data">
    <button class="xCNHide" id="obtAddEditCSTAddress"  type="submit" onclick="JSoAddEditCustomerAddress()"></button>
    <!-- From Input Hidden Address Customer -->
    <input type="hidden" id="ohdCSTAddressRoute"    name="ohdCSTAddressRoute"   value="<?php echo @$tCSTAddrRoute;?>">
    <input type="hidden" id="ohdCSTAddressCstCode"  name="ohdCSTAddressCstCode" value="<?php echo @$tFTCstCode;?>">
    <input type="hidden" id="ohdCSTAddressVersion"  name="ohdCSTAddressVersion" value="<?php echo @$nStaVersionAddress;?>">
    <input type="hidden" id="ohdCSTAddressGrpType"  name="ohdCSTAddressGrpType" value="<?php echo @$tFTAddGrpType;?>">
    <input type="hidden" id="ohdCSTAddressSeqNo"    name="ohdCSTAddressSeqNo"   value="<?php echo @$nFNAddSeqNo;?>">
    <input type="hidden" id="ohdCSTAddressRefNo"    name="ohdCSTAddressRefNo"   value="<?php echo @$tFTAddRefNo;?>">
    <input type="hidden" id="ohdCSTAddressMapLong"  name="ohdCSTAddressMapLong" value="<?php echo @$tFTAddLongitude;?>">
    <input type="hidden" id="ohdCSTAddressMapLat"   name="ohdCSTAddressMapLat"  value="<?php echo @$tFTAddLatitude;?>">
    
    <?php if(isset($nStaVersionAddress) && $nStaVersionAddress == 2):?>
        <div class="panel-body" style="padding:0;">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">

                    <!-- AddressName -->
                    <div class="form-group">
                        <label class="xCNLabelFrm"><span style = "color:red">*</span> <?php echo language('customer/customer/customer','tCSTAddressName');?></label>
                            <input 
                                type="text"
                                class="form-control"
                                maxlength="200"
                                id="oetCstAddressName"
                                name="oetCstAddressName"
                                data-validate-required="<?php echo language('customer/customer/customer','tCSTAddressNameValid');?>"
                                autocomplete="off"
                                value="<?php echo $tFTAddName;?>">
                        </div>
                    <!-- end AddressName -->

                    <!-- AddRefNo -->
                    <!-- <div  class="form-group">
                        <label class="xCNLabelFrm"><?php echo language('customer/customer/customer','tCSTAddV1RefCode')?></label>
                            <div class="form-group">
                                <input type="text"
                                    class="form-control"
                                    maxlength="20" id="oetCstAddRefNo" 
                                    name="oetCstAddRefNo" 
                                    placeholder="<?php echo language('customer/customer/customer','tCSTAddV1RefCode')?>"
                                    autocomplete="off"
                                data-is-created=""
                            value="<?php echo $tFTAddRefNo; ?>">
                        </div>
                    </div> -->
                    <!-- end AddRefNo -->   

                    <!-- GrpType -->   
                    <div  class="form-group">
                        <label class="xCNLabelFrm"><?php echo language('customer/customer/customer','tCstAddGrpType')?></label>
                        <select class="selectpicker form-control xCNSelectBox" id="ocmCstGrpType" name="ocmCstGrpType">   
                            <option value="1" <?php echo  $tStaGrpType1 ; ?>><?php echo language('customer/customer/customer','tCstAddCustomerAddress')?></option>
                            <option value="2" <?php echo  $tStaGrpType2; ?>><?php echo language('customer/customer/customer','tCstAddCtr')?></option>
                            <option value="3" <?php echo  $tStaGrpType3; ?>><?php echo language('customer/customer/customer','tCstAddShip')?></option>
                        </select>
                    </div>     
                    <!-- end GrpType --> 

                    <!-- AddTaxNo --> 
                    <!-- <div  class="form-group">
                        <label class="xCNLabelFrm"><?php echo language('customer/customer/customer','tCstAddTaxNo')?></label>
                            <div class="form-group">
                                <input type="text"
                                    class="form-control xCNInputNumericWithDecimal"
                                    maxlength="20" id="oetCstAddTaxNo" name="oetCstAddTaxNo" 
                                    data-is-created=""
                                    value="<?php echo '' ; ?>">
                                </div>
                            </div>  -->
                    <!-- end AddTaxNo --> 

                    <!-- Address1 --> 
                    <div  class="form-group">
                        <label class="xCNLabelFrm"><?php echo language('customer/customer/customer','tCstAddV2Desc1')?></label>
                            <div class="form-group">
                            <textarea class="form-control " rows="4" maxlength="100" id="oetCstAddAddress1" name="oetCstAddAddress1"><?php echo $tFTAddV2Desc1; ?></textarea>
                        </div>
                    </div>
                    <!-- end Address1 --> 

                    <!-- Address2 --> 
                    <div  class="form-group">
                        <label class="xCNLabelFrm"><?php echo language('customer/customer/customer','tCstAddV2Desc2')?></label>
                        <div class="form-group">
                        <textarea class="form-control " rows="4" maxlength="100" id="oetCstAddAddress2" name="oetCstAddAddress2"><?php echo $tFTAddV2Desc2; ; ?></textarea>
                        </div>
                    </div>
                    <!-- end Address2 --> 

                    <!-- AddWeb --> 
                    <div  class="form-group">
                        <label class="xCNLabelFrm"><?php echo language('customer/customer/customer','tCstWebsite')?></label>
                            <div class="form-group">
                                <input type="text"
                                class="form-control"
                                maxlength="200" id="oetCstAddWeb" name="oetCstAddWeb" 
                                data-is-created=""
                                value="<?php echo $tFTAddWebsite; ?>">
                            </div>
                        </div>
                    <!-- end AddWeb --> 

                    <!-- Note --> 
                    <div  class="form-group">
                        <label class="xCNLabelFrm"><?php echo language('customer/customer/customer','tCstRmk')?></label>
                        <div class="form-group">
                            <textarea class="form-control " rows="4" maxlength="100" id="oetCstAddressRmk" name="oetCstAddressRmk"><?php echo $tFTAddRmk; ?></textarea>
                        </div>
                    </div>
                    <!-- end Note --> 
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 p-t-25">
                        <div class="form-group">
                            <div id="odvCSTAddressMapView" class="xCNMapShow"></div>
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
                            <label class="xCNLabelFrm"><span style = "color:red">*</span> <?php echo language('customer/customer/customer','tCSTAddressName');?></label>
                            <div class="form-group">
                                <input
                                    type="text"
                                    class="form-control"
                                    maxlength="200"
                                    id="oetCSTAddressName"
                                    name="oetCSTAddressName"
                                    data-validate-required="<?php echo language('customer/customer/customer','tCSTAddressNameValid');?>"
                                    value="<?php echo $tFTAddName;?>"
                                >
                            </div>
                        <!-- GrpType -->   
                        <div  class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('customer/customer/customer','tCstAddGrpType')?></label>
                            <select class="selectpicker form-control xCNSelectBox" id="ocmCstGrpType" name="ocmCstGrpType">   
                                <option value="1" <?php echo  $tStaGrpType1; ?>><?php echo language('customer/customer/customer','tCstAddCustomerAddress')?></option>
                                <option value="2" <?php echo  $tStaGrpType2; ?>><?php echo language('customer/customer/customer','tCstAddCtr')?></option>
                                <option value="3" <?php echo  $tStaGrpType3; ?>><?php echo language('customer/customer/customer','tCstAddShip')?></option>
                            </select>
                        </div>     
                        <!-- end GrpType --> 
                            <div class="form-group">
                                <label class="xCNLabelFrm"><?php echo language('customer/customer/customer','tCSTAddWebsite')?></label>
                                <input
                                    type="text"
                                    class="form-control"
                                    maxlength="200"
                                    id="oetCSTAddressWeb"
                                    name="oetCSTAddressWeb" 
                                    value="<?php echo $tFTAddWebsite;?>"
                                >
                            </div>
                            <div class="form-group">
                                <label class="xCNLabelFrm"><?php echo language('customer/customer/customer','tCSTAddV1No');?></label>
                                <input 
                                    type="text"
                                    class="form-control"
                                    maxlength="30"
                                    id="oetCSTAddressNo"
                                    name="oetCSTAddressNo"
                                    value="<?php echo $tFTAddV1No;?>"
                                >
                            </div>
                            <div class="form-group">
                                <label class="xCNLabelFrm"><?php echo language('customer/customer/customer','tCSTAddV1Village')?></label>
                                <input
                                    type="text"
                                    class="form-control"
                                    maxlength="70"
                                    id="oetCSTAddressVillage"
                                    name="oetCSTAddressVillage"
                                    value="<?php echo $tFTAddV1Village;?>"
                                >
                            </div>
                            <div class="form-group">
                                <label class="xCNLabelFrm"><?php echo language('customer/customer/customer','tCSTAddV1Road')?></label>
                                <input
                                    type="text"
                                    class="form-control"
                                    maxlength="30"
                                    id="oetCSTAddressRoad"
                                    name="oetCSTAddressRoad"
                                    value="<?php echo $tFTAddV1Road;?>"
                                >
                            </div>
                            <div class="form-group">
                                <label class="xCNLabelFrm"><?php echo language('customer/customer/customer','tCSTAddV1Soi')?></label>
                                <input
                                    type="text"
                                    class="form-control"
                                    maxlength="30"
                                    id="oetCSTAddressSoi"
                                    name="oetCSTAddressSoi"
                                    value="<?php echo $tFTAddV1Soi;?>"
                                >
                            </div>
                            <div class="form-group">
                                <label class="xCNLabelFrm"><span style = "color:red">*</span> <?php echo language('customer/customer/customer','tCSTAreCode');?></label>
                                <div class="input-group">
                                    <input type="text" class="form-control xCNHide" id="oetCSTAddressAreCode" name="oetCSTAddressAreCode" maxlength="5" value="<?php echo @$tFTAreCode;?>">
                                    <input
                                        type="text"
                                        class="form-control xWPointerEventNone"
                                        id="oetCSTAddressAreName"
                                        name="oetCSTAddressAreName"
                                        data-validate-required="<?php echo language('customer/customer/customer','tCSTAreCodeValid');?>"
                                        value="<?php echo $tFTAreName;?>"
                                        readonly
                                    >
                                    <span class="input-group-btn xCNStartDisabled">
                                        <button id="obtCSTAddressBrowseArea" type="button" class="btn xCNBtnBrowseAddOn">
                                            <img src="<?php echo  base_url().'application/modules/common/assets/images/icons/find-24.png'?>">
                                        </button>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="xCNLabelFrm"><span style = "color:red">*</span> <?php echo language('customer/customer/customer','tCSTZneCode');?></label>
                                <div class="input-group">
                                    <input type="text" class="form-control xCNHide" id="oetCSTAddressZneCode"   name="oetCSTAddressZneCode"     value="<?php echo @$tFTZneCode;?>">
                                    <input type="text" class="form-control xCNHide" id="oetCSTAddressZneName"   name="oetCSTAddressZneName"     value="<?php echo @$tFTZneName;?>">
                                    <input type="text" class="form-control xCNHide" id="oetCSTAddressZneChain"  name="oetCSTAddressZneChain"    value="<?php echo @$tFTZneChain;?>">
                                    <input type="text"
                                        class="form-control xWPointerEventNone"
                                        id="oetCSTAddressZneChainName"
                                        name="oetCSTAddressZneChainName"
                                        data-validate-required="<?php echo language('customer/customer/customer','tCSTZneCodeValid');?>"
                                        value="<?php echo $tFTZneChainName;?>"
                                        readonly
                                    >
                                    <span class="input-group-btn xCNStartDisabled">
                                        <button id="obtCSTAddressBrowseZone" type="button" class="btn xCNBtnBrowseAddOn">
                                            <img src="<?php echo  base_url().'application/modules/common/assets/images/icons/find-24.png'?>">
                                        </button>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="xCNLabelFrm"><?php echo  language('customer/customer/customer','tCSTAddV1PvnCode')?></label>
                                <div class="input-group">
                                    <input 
                                        type="text"
                                        class="form-control xCNHide"
                                        id="oetCSTAddressPvnCode"
                                        name="oetCSTAddressPvnCode"
                                        maxlength="5"
                                        value="<?php echo $tFTAddV1PvnCode;?>"
                                    >
                                    <input 
                                        type="text"
                                        class="form-control xWPointerEventNone"
                                        id="oetCSTAddressPvnName"
                                        name="oetCSTAddressPvnName"
                                        value="<?php echo $tFTPvnName;?>"
                                        readonly
                                    >
                                    <span class="input-group-btn">
                                        <button id="obtCSTAddressBrowseProvince" type="button" class="btn xCNBtnBrowseAddOn">
                                            <img src="<?php echo  base_url().'application/modules/common/assets/images/icons/find-24.png'?>">
                                        </button>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="xCNLabelFrm"><?php echo  language('customer/customer/customer','tCSTAddV1DstCode')?></label>
                                <div class="input-group">
                                    <input
                                        type="text"
                                        class="form-control xCNHide"
                                        id="oetCSTAddressDstCode"
                                        name="oetCSTAddressDstCode"
                                        maxlength="5"
                                        value="<?php echo $tFTAddV1DstCode;?>"
                                    >
                                    <input
                                        type="text"
                                        class="form-control xWPointerEventNone"
                                        id="oetCSTAddressDstName"
                                        name="oetCSTAddressDstName"
                                        value="<?php echo $tFTDstName ?>"
                                        readonly
                                    >
                                    <span class="input-group-btn xCNStartDisabled">
                                        <button id="obtCSTAddressBrowseDistrict" type="button" class="btn xCNBtnBrowseAddOn">
                                            <img src="<?php echo  base_url().'application/modules/common/assets/images/icons/find-24.png'?>">
                                        </button>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="xCNLabelFrm"><?php echo  language('customer/customer/customer','tCSTAddV1SubDist')?></label>
                                <div class="input-group">
                                    <input
                                        type="text"
                                        class="form-control xCNHide"
                                        id="oetCSTAddressSubDstCode"
                                        name="oetCSTAddressSubDstCode"
                                        maxlength="5"
                                        value="<?php echo $tFTAddV1SubDist;?>"
                                    >
                                    <input
                                        type="text"
                                        class="form-control xWPointerEventNone"
                                        id="oetCSTAddressSubDstName"
                                        name="oetCSTAddressSubDstName"
                                        value="<?php echo $tFTSudName;?>"
                                        readonly
                                    >
                                    <span class="input-group-btn xCNStartDisabled">
                                        <button id="obtCSTAddressBrowseSubDistrict" type="button" class="btn xCNBtnBrowseAddOn">
                                            <img src="<?php echo  base_url().'application/modules/common/assets/images/icons/find-24.png'?>">
                                        </button>
                                    </span>
                                </div>
                            </div>
                            <div  class="form-group">
                                <label class="xCNLabelFrm"><?php echo language('customer/customer/customer','tCSTAddV1PostCode')?></label>
                                <input
                                    type="text"
                                    class="form-control"
                                    maxlength="5"
                                    id="oetCSTAddressPostCode"
                                    name="oetCSTAddressPostCode"
                                    value="<?php echo $tFTAddV1PostCode;?>"
                                >
                            </div>

                            <!-- Note --> 
                            <div  class="form-group">
                                <label class="xCNLabelFrm"><?php echo language('customer/customer/customer','tCstRmk')?></label>
                                <div class="form-group">
                                    <textarea class="form-control " rows="4" maxlength="100" id="oetCSTAddressRmk" name="oetCSTAddressRmk"><?php echo $tFTAddRmk; ?></textarea>
                                </div>
                            </div>
                            <!-- end Note --> 
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 p-t-25">
                        <div class="form-group">
                            <div id="odvCSTAddressMapView" class="xCNMapShow"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif;?>
</form>
<script src="<?php echo base_url('application/modules/common/assets/js/jquery.mask.js')?>"></script>
<script src="<?php echo base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>
<script type="text/javascript">
    var nCSTAddrLangEdits       = '<?php echo $this->session->userdata("tLangEdit");?>';
    // Option Browse ภูมิภาค
    var oCSTAddressArea         = function(poDataFnc){
        let tCSTAREInputReturnCode  = poDataFnc.tReturnInputCode;
        let tCSTAREInputReturnName  = poDataFnc.tReturnInputName;
        let oCSTAREOptionReturn     = {
            Title   : ['address/area/area','tARETitle'],
            Table   : {Master:'TCNMArea',PK:'FTAreCode'},
            Join    : {
                Table:	['TCNMArea_L'],
                On:['TCNMArea.FTAreCode = TCNMArea_L.FTAreCode AND TCNMArea_L.FNLngID = '+nCSTAddrLangEdits,]
            },
            GrideView:{
                ColumnPathLang	    : 'address/area/area',
                ColumnKeyLang	    : ['tARECode','tAREName'],
                ColumnsSize         : ['15%','75%'],
                WidthModal          : 50,
                DataColumns		    : ['TCNMArea.FTAreCode','TCNMArea_L.FTAreName'],
                DataColumnsFormat   : ['',''],
                Perpage			    : 10,
                OrderBy			    : ['TCNMArea.FTAreCode ASC'],
            },
            CallBack:{
                ReturnType	: 'S',
                Value		: [tCSTAREInputReturnCode,"TCNMArea.FTAreCode"],
                Text		: [tCSTAREInputReturnName,"TCNMArea_L.FTAreName"],
            },
            RouteAddNew : 'area',
            BrowseLev   : nStaCstBrowseType
        };
        return oCSTAREOptionReturn;
    }
    // Option Browse โซน
    var oCSTAddressZone         = function(poDataFnc){
        let tCSTZNEInputReturnCode  = poDataFnc.tReturnInputCode;
        let tCSTZNEInputReturnName  = poDataFnc.tReturnInputName;
        let tCSTZNENextFuncName     = poDataFnc.tNextFuncName;
        let aCSTZNEArgReturn        = poDataFnc.aArgReturn;
        let oCSTZNEOptionReturn     = {
            Title   : ['address/zone/zone','tZNETitle'],
            Table   : {Master:'TCNMZone',PK:'FTZneChain'},
            Join    : {
                Table   : ['TCNMZone_L'],
                On      : ['TCNMZone.FTZneChain = TCNMZone_L.FTZneChain AND TCNMZone_L.FNLngID = '+nCSTAddrLangEdits,]
            },
            GrideView:{
                ColumnPathLang	    : 'address/zone/zone',
                ColumnKeyLang	    : ['tZNECode','tZNEChainName','tZNEZCode','tZNEName'],
                ColumnsSize         : ['20%','25','20','25%'],
                WidthModal          : 50,
                DataColumns		    : ['TCNMZone.FTZneChain','TCNMZone_L.FTZneChainName','TCNMZone.FTZneCode','TCNMZone_L.FTZneName'],
                DataColumnsFormat   : ['','','',''],
                Perpage			    : 10,
                OrderBy			    : ['TCNMZone.FTZneChain ASC'],
            },
            CallBack:{
                ReturnType	: 'S',
                Value		: [tCSTZNEInputReturnCode,"TCNMZone.FTZneChain"],
                Text		: [tCSTZNEInputReturnName,"TCNMZone_L.FTZneChainName"],
            },
            NextFunc:{
                FuncName    : tCSTZNENextFuncName,
                ArgReturn   : aCSTZNEArgReturn
            },
            RouteAddNew : 'zone',
            BrowseLev   : nStaCstBrowseType
        };
        return oCSTZNEOptionReturn;
    }
    // Option Browse จังหวัด
    var oCSTAddressProvince     = function(poDataFnc){
        let tCSTPVNInputReturnCode  = poDataFnc.tReturnInputCode;
        let tCSTPVNInputReturnName  = poDataFnc.tReturnInputName;
        let tCSTPVNNextFuncName     = poDataFnc.tNextFuncName;
        let aCSTPVNArgReturn        = poDataFnc.aArgReturn;
        let oCSTPVNOptionReturn     = {
            Title : ['address/province/province','tPVNTitle'],
            Table:{Master:'TCNMProvince',PK:'FTPvnCode'},
            Join :{
                Table:	['TCNMProvince_L'],
                On:['TCNMProvince_L.FTPvnCode = TCNMProvince.FTPvnCode AND TCNMProvince_L.FNLngID = '+nCSTAddrLangEdits,]
            },
            GrideView:{
                ColumnPathLang	    : 'address/province/province',
                ColumnKeyLang	    : ['tPVNCode','tPVNName'],
                ColumnsSize         : ['15%','75%'],
                WidthModal          : 50,
                DataColumns		    : ['TCNMProvince.FTPvnCode','TCNMProvince_L.FTPvnName','TCNMProvince.FTPvnLatitude','TCNMProvince.FTPvnLongitude'],
                DataColumnsFormat   : ['','','',''],
                DisabledColumns     : [2,3],
                Perpage			    : 10,
                OrderBy			    : ['TCNMProvince.FTPvnCode ASC'],
            },
            CallBack:{
                ReturnType	: 'S',
                Value		: [tCSTPVNInputReturnCode,"TCNMProvince.FTPvnCode"],
                Text		: [tCSTPVNInputReturnName,"TCNMProvince_L.FTPvnName"],
            },
            NextFunc:{
                FuncName    : tCSTPVNNextFuncName,
                ArgReturn   : aCSTPVNArgReturn
            },
            RouteAddNew : 'province',
            BrowseLev   : nStaCstBrowseType
        };
        return oCSTPVNOptionReturn;
    }
    // Option Browse อำเภอ
    var oCSTAddressDistrict     = function(poDataFnc){
        let tCSTDSTInputReturnCode  = poDataFnc.tReturnInputCode;
        let tCSTDSTInputReturnName  = poDataFnc.tReturnInputName;
        let tCSTDSTNextFuncName     = poDataFnc.tNextFuncName;
        let aCSTDSTArgReturn        = poDataFnc.aArgReturn;
        let oCSTDSTOptionReturn     = {
            Title   : ['address/district/district','tDSTTitle'],
            Table   : {Master:'TCNMDistrict',PK:'FTDstCode'},
            Join    : {
                Table   : ['TCNMDistrict_L'],
                On      : ['TCNMDistrict_L.FTDstCode = TCNMDistrict.FTDstCode AND TCNMDistrict_L.FNLngID = '+nCSTAddrLangEdits]
            },
            Filter:{
                Selector    : 'oetCSTAddressPvnCode',
                Table       : 'TCNMDistrict',
                Key         : 'FTPvnCode'
            },
            GrideView:{
                ColumnPathLang	    : 'address/district/district',
                ColumnKeyLang	    : ['tDSTTBCode','tDSTTBName'],
                ColumnsSize         : ['15%','75%'],
                WidthModal          : 50,
                DataColumns		    : ['TCNMDistrict.FTDstCode','TCNMDistrict_L.FTDstName','TCNMDistrict.FTDstLatitude','TCNMDistrict.FTDstLongitude'],
                DataColumnsFormat   : ['','','',''],
                DisabledColumns     : [2,3],
                Perpage			    : 10,
                OrderBy			    : ['TCNMDistrict.FTDstCode ASC'],
            },
            CallBack:{
                ReturnType	: 'S',
                Value		: [tCSTDSTInputReturnCode,"TCNMDistrict.FTDstCode"],
                Text		: [tCSTDSTInputReturnName,"TCNMDistrict_L.FTDstName"],
            },
            NextFunc:{
                FuncName    : tCSTDSTNextFuncName,
                ArgReturn   : aCSTDSTArgReturn
            },
            RouteAddNew : 'district',
            BrowseLev   : nStaCstBrowseType
        };
        return oCSTDSTOptionReturn;
    }
    // Option Browse ตำบล
    var oCSTAddressSubDistrict  = function(poDataFnc){
        let tCSTSDTInputReturnCode  = poDataFnc.tReturnInputCode;
        let tCSTSDTInputReturnName  = poDataFnc.tReturnInputName;
        let tCSTSDTNextFuncName     = poDataFnc.tNextFuncName;
        let aCSTSDTArgReturn        = poDataFnc.aArgReturn;
        let oCSTSDTOptionReturn     = {
            Title   : ['address/subdistrict/subdistrict','tSDTTitle'],
            Table   : {Master:'TCNMSubDistrict',PK:'FTSudCode'},
            Join    : {
                Table   : ['TCNMSubDistrict_L'],
                On      : ['TCNMSubDistrict_L.FTSudCode = TCNMSubDistrict.FTSudCode AND TCNMSubDistrict_L.FNLngID = '+nCSTAddrLangEdits]
            },
            Filter:{
                Selector    : 'oetCSTAddressDstCode',
                Table       : 'TCNMSubDistrict',
                Key         : 'FTDstCode'
            },
            GrideView:{
                ColumnPathLang	    : 'address/subdistrict/subdistrict',
                ColumnKeyLang	    : ['tSDTTBCode','tSDTTBSubdistrict'],
                ColumnsSize         : ['15%','75%'],
                WidthModal          : 50,
                DataColumns		    : ['TCNMSubDistrict.FTSudCode','TCNMSubDistrict_L.FTSudName','TCNMSubDistrict.FTSudLatitude','TCNMSubDistrict.FTSudLongitude'],
                DataColumnsFormat   : ['','','',''],
                DisabledColumns     : [2,3],
                Perpage			    : 10,
                OrderBy			    : ['TCNMSubDistrict.FTSudCode ASC'],
            },
            CallBack:{
                ReturnType	: 'S',
                Value		: [tCSTSDTInputReturnCode,"TCNMSubDistrict.FTSudCode"],
                Text		: [tCSTSDTInputReturnName,"TCNMSubDistrict_L.FTSudName"],
            },
            NextFunc:{
                FuncName    : tCSTSDTNextFuncName,
                ArgReturn   : aCSTSDTArgReturn
            },
            RouteAddNew : 'subdistrict',
            BrowseLev   : nStaCstBrowseType
        };
        return oCSTSDTOptionReturn;
    }

    $(document).ready(function(){
        $('.selectpicker').selectpicker('refresh');

        // Event Customer Address Browse Area
        $('#obtCSTAddressBrowseArea').unbind().click(function(){
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                JSxCheckPinMenuClose();
                window.oCSTAddressAreaOption    = undefined;
                oCSTAddressAreaOption           = oCSTAddressArea({
                    'tReturnInputCode'  : 'oetCSTAddressAreCode',
                    'tReturnInputName'  : 'oetCSTAddressAreName',
                });
                JCNxBrowseData('oCSTAddressAreaOption');
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        // Event Customer Address Browse Zone
        $('#obtCSTAddressBrowseZone').unbind().click(function(){
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                JSxCheckPinMenuClose();
                window.oCSTAddressZoneOption    = undefined;
                oCSTAddressZoneOption           = oCSTAddressZone({
                    'tReturnInputCode'  : 'oetCSTAddressZneChain',
                    'tReturnInputName'  : 'oetCSTAddressZneChainName',
                    'tNextFuncName'     : 'JCNxCustomerAddressNextFuncZone',
                    'aArgReturn'        : ['FTZneChain','FTZneChainName','FTZneCode','FTZneName']
                });
                JCNxBrowseData('oCSTAddressZoneOption');
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        // Event Customer Address Browse Province
        $('#obtCSTAddressBrowseProvince').unbind().click(function(){
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                JSxCheckPinMenuClose();
                window.oCSTAddressProvinceOption    = undefined;
                oCSTAddressProvinceOption           = oCSTAddressProvince({
                    'tReturnInputCode'  : 'oetCSTAddressPvnCode',
                    'tReturnInputName'  : 'oetCSTAddressPvnName',
                    'tNextFuncName'     : 'JCNxCustomerAddressSetMapProvince',
                    'aArgReturn'        : ['FTPvnCode','FTPvnName','FTPvnLatitude','FTPvnLongitude']
                });
                JCNxBrowseData('oCSTAddressProvinceOption');
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        // Event Customer Address Browse District
        $('#obtCSTAddressBrowseDistrict').unbind().click(function(){
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                JSxCheckPinMenuClose();
                window.oCSTAddressDistrictOption    = undefined;
                oCSTAddressDistrictOption           = oCSTAddressDistrict({
                    'tReturnInputCode'  : 'oetCSTAddressDstCode',
                    'tReturnInputName'  : 'oetCSTAddressDstName',
                    'tNextFuncName'     : 'JCNxCustomerAddressSetMapDistrict',
                    'aArgReturn'        : ['FTDstCode','FTDstName','FTDstLatitude','FTDstLongitude']
                });
                JCNxBrowseData('oCSTAddressDistrictOption');
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        // Event Customer Address Browse Sub-District
        $('#obtCSTAddressBrowseSubDistrict').unbind().click(function(){
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                JSxCheckPinMenuClose();
                window.oCSTAddressSubDistrictOption = undefined;
                oCSTAddressSubDistrictOption        = oCSTAddressSubDistrict({
                    'tReturnInputCode'  : 'oetCSTAddressSubDstCode',
                    'tReturnInputName'  : 'oetCSTAddressSubDstName',
                    'tNextFuncName'     : 'JCNxCustomerAddressSetMapSubDistrict',
                    'aArgReturn'        : ['FTSudCode','FTSudName','FTSudLatitude','FTSudLongitude']
                });
                JCNxBrowseData('oCSTAddressSubDistrictOption');
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        var poCSTDataMap    = {
            'tMapLongitude' : <?php echo (isset($tFTAddLongitude)&&!empty($tFTAddLongitude))?   floatval($tFTAddLongitude)  : floatval('100.50182294100522');?>,
            'tMapLatitude'  : <?php echo (isset($tFTAddLatitude)&&!empty($tFTAddLatitude))?     floatval($tFTAddLatitude)   : floatval('13.757309968845291');?>,
        };
        JSxCustomerAddressSetMapToShow(poCSTDataMap);
    });
    
    // Function: Set Map Data Customer Address
    // Parameters: Document Ready And Event Next Functon Browse 
    // Creator: 08/11/2019 Wasin(Yoshi)
    // Return: Set Map In Div
    // ReturnType:None
    function JSxCustomerAddressSetMapToShow(poCSTDataMap){
        let tCSTMapLongitude    = poCSTDataMap.tMapLongitude;
        let tCSTMapLatitude     = poCSTDataMap.tMapLatitude;
        let nCSTStatusLoadMap   = 0;
        if(nCSTStatusLoadMap == 0){
            $("#odvCSTAddressMapView").empty();
            var oCSTMapCompany  = {
                tDivShowMap	:'odvCSTAddressMapView',
                cLongitude	: parseFloat(tCSTMapLongitude),
                cLatitude	: parseFloat(tCSTMapLatitude),
                tInputLong	: 'ohdCSTAddressMapLong',
                tInputLat	: 'ohdCSTAddressMapLat',
                tIcon		: '<?php echo base_url().'application/modules/common/assets/images/icons/icon_mark.png';?>',
                tStatus		: '2'	
            }
            JSxMapAddEdit(oCSTMapCompany);
			nCSTStatusLoadMap = 1;
        }
    }

    // Function: Event Next func Customer Address Browse Zone
    // Parameters: Event Next Functon Browse 
    // Creator: 08/11/2019 Wasin(Yoshi)
    // Return: None
    // ReturnType: None
    function JCNxCustomerAddressNextFuncZone(ptDataNextFunc){
        let aDataNextFunc,tZneChain,tZneChainName,tZneCode,tZneName;
        if(typeof(ptDataNextFunc) != undefined && ptDataNextFunc != "NULL"){
            aDataNextFunc   = JSON.parse(ptDataNextFunc);
            tZneChain       = aDataNextFunc[0];
            tZneChainName   = aDataNextFunc[1];
            tZneCode        = aDataNextFunc[2];
            tZneName        = aDataNextFunc[3];
            $('#oetCSTAddressZneChain').val(tZneChain);
            $('#oetCSTAddressZneChainName').val(tZneChainName);
            $('#oetCSTAddressZneCode').val(tZneCode);
            $('#oetCSTAddressZneName').val(tZneName);
        }else{
            // Clear Input Values 
            $('#oetCSTAddressZneChain').val('');
            $('#oetCSTAddressZneChainName').val('');
            $('#oetCSTAddressZneCode').val('');
            $('#oetCSTAddressZneName').val('');
        }
    }

    // Function: Event Next func Customer Address Browse Province
    // Parameters: Event Next Functon Browse 
    // Creator: 08/11/2019 Wasin(Yoshi)
    // Return: None
    // ReturnType: None
    function JCNxCustomerAddressSetMapProvince(ptDataNextFunc){
        let aDataNextFunc,tPvnCode,tPvnName,tPvnLatitude,tPvnLongitude;
        if(typeof(ptDataNextFunc) != undefined && ptDataNextFunc != "NULL"){
            aDataNextFunc   = JSON.parse(ptDataNextFunc);
            tPvnCode        = aDataNextFunc[0];
            tPvnName        = aDataNextFunc[1];
            tPvnLatitude    = aDataNextFunc[2];
            tPvnLongitude   = aDataNextFunc[3];
            aDataCallMap    = {
                'tMapLatitude'  : parseFloat(tPvnLatitude),
                'tMapLongitude' : parseFloat(tPvnLongitude),
            };
            $('#ohdCSTAddressMapLong').val(aDataCallMap.tMapLongitude);
            $('#ohdCSTAddressMapLat').val(aDataCallMap.tMapLatitude);
            JSxCustomerAddressSetMapToShow(aDataCallMap);
            // **** Clear Value ****
            $('#oetCSTAddressDstCode').val('');
            $('#oetCSTAddressDstName').val('');
            $('#oetCSTAddressSubDstCode').val('');
            $('#oetCSTAddressSubDstName').val('');
        }else{
            // **** Clear Value ****
            $('#oetCSTAddressDstCode').val('');
            $('#oetCSTAddressDstName').val('');
            $('#oetCSTAddressSubDstCode').val('');
            $('#oetCSTAddressSubDstName').val('');
            $('#ohdCSTAddressMapLong').val('');
            $('#ohdCSTAddressMapLat').val('');
        }
    }

    // Function: Event Netfunc Customer Address Browse District
    // Parameters: Event Next Functon Browse 
    // Creator: 08/11/2019 Wasin(Yoshi)
    // Return: None
    // ReturnType: None
    function JCNxCustomerAddressSetMapDistrict(ptDataNextFunc){
        let aDataNextFunc,tDstCode,tDstName,tDstLatitude,tDstLongitude;
        if(typeof(ptDataNextFunc) != undefined && ptDataNextFunc != "NULL"){
            aDataNextFunc   = JSON.parse(ptDataNextFunc);
            tDstCode        = aDataNextFunc[0];
            tDstName        = aDataNextFunc[1];
            tDstLatitude    = aDataNextFunc[2];
            tDstLongitude   = aDataNextFunc[3];
            aDataCallMap    = {
                'tMapLatitude'  : parseFloat(tDstLatitude),
                'tMapLongitude' : parseFloat(tDstLongitude),
            };
            $('#ohdCSTAddressMapLong').val(aDataCallMap.tMapLongitude);
            $('#ohdCSTAddressMapLat').val(aDataCallMap.tMapLatitude);
            JSxCustomerAddressSetMapToShow(aDataCallMap);
            // **** Clear Value ****
            $('#oetCSTAddressSubDstCode').val('');
            $('#oetCSTAddressSubDstName').val('');
        }else{
            // **** Clear Value ****
            $('#oetCSTAddressSubDstCode').val('');
            $('#oetCSTAddressSubDstName').val('');
            $('#ohdCSTAddressMapLong').val('');
            $('#ohdCSTAddressMapLat').val('');
        }
    }

    // Function: Event Netfunc Customer Address Browse Sub District
    // Parameters: Event Next Functon Browse 
    // Creator: 08/11/2019 Wasin(Yoshi)
    // Return: None
    // ReturnType: None
    function JCNxCustomerAddressSetMapSubDistrict(ptDataNextFunc){
        let aDataNextFunc,tSubDstCode,tSubDstName,tSubDstLatitude,tSubDstLongitude;
        if(typeof(ptDataNextFunc) != undefined && ptDataNextFunc != "NULL"){
            aDataNextFunc       = JSON.parse(ptDataNextFunc);
            tSubDstCode         = aDataNextFunc[0];
            tSubDstName         = aDataNextFunc[1];
            tSubDstLatitude     = aDataNextFunc[2];
            tSubDstLongitude    = aDataNextFunc[3];
            aDataCallMap    = {
                'tMapLatitude'  : parseFloat(tSubDstLatitude),
                'tMapLongitude' : parseFloat(tSubDstLongitude),
            };
            $('#ohdCSTAddressMapLong').val(aDataCallMap.tMapLongitude);
            $('#ohdCSTAddressMapLat').val(aDataCallMap.tMapLatitude);
            JSxCustomerAddressSetMapToShow(aDataCallMap);
        }else{
            // **** Clear Value ****
            $('#ohdCSTAddressMapLong').val('');
            $('#ohdCSTAddressMapLat').val('');
        }
    }
</script>