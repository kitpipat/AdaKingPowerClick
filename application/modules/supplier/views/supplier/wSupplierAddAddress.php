<?php
if($nStaAddOrEdit==1){
    $tRout                ="supplierEventEditAddress";
    $tFTSplCode           = $aSplAddressData['raItems']['FTSplCode'];//
    $nFNAddSeqNo          = $aSplAddressData['raItems']['FNAddSeqNo'];
    $tFTAddVersion        = $aSplAddressData['raItems']['FTAddVersion'];
    $tFTAddName           = $aSplAddressData['raItems']['FTAddName'];
    $tFTAddRefNo          = $aSplAddressData['raItems']['FTAddRefNo'];
    $tFTAddGrpType        = $aSplAddressData['raItems']['FTAddGrpType'];
    $tFTAddTaxNo          = $aSplAddressData['raItems']['FTAddTaxNo'];
    $tFTAddV2Desc1        = $aSplAddressData['raItems']['FTAddV2Desc1'];
    $tFTAddV2Desc2        = $aSplAddressData['raItems']['FTAddV2Desc2'];
    $tFTAddWebsite        = $aSplAddressData['raItems']['FTAddWebsite'];
    $tFTAddRmk            = $aSplAddressData['raItems']['FTAddRmk'];
    $tFTAddLongitude      = $aSplAddressData['raItems']['FTAddLongitude'];
    $tFTAddLatitude       = $aSplAddressData['raItems']['FTAddLatitude'];
    //จบฟอร์มสัน
    $tFTAddCountry        = $aSplAddressData['raItems']['FTAddCountry'];
    $tFTAddV1No           = $aSplAddressData['raItems']['FTAddV1No'];
    $tFTAddV1Village      = $aSplAddressData['raItems']['FTAddV1Village'];
    $tFTAddV1Road         = $aSplAddressData['raItems']['FTAddV1Road'];
    $tFTAddV1Soi          = $aSplAddressData['raItems']['FTAddV1Soi'];
    $tFTAddV1PostCode     = $aSplAddressData['raItems']['FTAddV1PostCode'];
    $tFTAddV1PvnCode      = $aSplAddressSeparate['FTAddV1PvnCode'];
    $tFTPvnName           = $aSplAddressSeparate['FTPvnName'];
    $tFTDstName           = $aSplAddressSeparate['FTDstName'];
    $tFTAddV1DstCode      = $aSplAddressSeparate['FTAddV1DstCode'];
    $tFTSudName           = $aSplAddressSeparate['FTSudName'];
    $tFTAddV1SubDist      = $aSplAddressSeparate['FTAddV1SubDist'];
}else{
    $tRout             ="supplierEventAddAddress";
    $tFTSplCode        = "";//
    $nFNAddSeqNo       = "";
    $tFTAddVersion     = "";
    $tFTAddName        = "";
    $tFTAddGrpType     = 1;
    $tFTAddRefNo       = "";
    $tFTAddTaxNo       = "";
    $tFTAddV2Desc1     = "";
    $tFTAddV2Desc2     = "";
    $tFTAddWebsite     = "";
    $tFTAddRmk         = "";
    $tFTAddLongitude   = "";
    $tFTAddLatitude    = "";
    //จบฟอร์มสัน
    $tFTAddCountry     = "";
    $tFTAddV1No        = "";
    $tFTAddV1Village   = "";
    $tFTAddV1Road      = "";
    $tFTAddV1Soi       = "";
    $tFTAddV1PostCode  = "";
    $tFTAddV1PvnCode   = "";
    $tFTPvnName        = "";
    $tFTDstName        = "";
    $tFTAddV1DstCode   = "";
    $tFTSudName        = "";
    $tFTAddV1SubDist   = "";
}
// print_r($aData);
?>

<br>
<?php if($tFTAddVersion==""){?>
    <?php 
        foreach ($aData['raItems'] as $value)
        if($value['FTSysStaUsrValue']!="" && $value['FTSysStaDefValue']!=""){
            if($value['FTSysStaUsrValue']==1){//ผู้ใช้เลือกฟอร์มสั้น UsrValue = 1
    ?>     
    <form class="contact100-form validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" id="ofmAddAddress">
                    <div class="demo-button xCNBtngroup" style="width:100%;" align="right">
                        <button class="btn" type="reset"  onclick="JSxAddressDatatable($('#ohdSupcode').val());" style="background-color: #D4D4D4; color: #000000;"><?php echo language('supplier/supplier/supplier','tSPLTBReset')?></button>
                        <button type="submit" class="btn" onclick="JSoAddEditSupplierAddress('<?php echo $tRout;?>', $('#ohdSupcode').val(), $('#ohdSeqNo').val())" style="background-color:#179BFD; color:white;"><?php echo language('common/main/main', 'tSave')?></button>
                    </div>
        <input type="hidden" class="form-control" id="oetCmpMapLong" name="oetCmpMapLong" value="<?php echo $tFTAddLongitude?>">
        <input type="hidden" class="form-control" id="oetCmpMapLat" name="oetCmpMapLat" value="<?php echo $tFTAddLatitude?>">
        <input type="hidden" class="form-control" id="ohdSeqNo" name="ohdSeqNo" value="<?php echo $nFNAddSeqNo ; ?>">
        <input type="hidden" class="form-control" id="ohdVersion" name="ohdVersion" value="1">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div  class="form-group">
                                <label class="xCNLabelFrm"><?php echo language('supplier/supplier/supplier','tAddressName')?></label>
                                <div class="form-group">
                                    <input type="text"
                                    class="form-control"
                                    maxlength="200" id="oetSplAddName" name="oetSplAddName" 
                                    data-is-created=""
                                    value="<?php echo $tFTAddName ; ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div  class="form-group">
                                <label class="xCNLabelFrm"><?php echo language('supplier/supplier/supplier','tAddV1RefCode')?></label>
                                <div class="form-group">
                                    <input type="text"
                                    class="form-control"
                                    maxlength="20" id="oetSplAddRefNo" name="oetSplAddRefNo" 
                                    data-is-created=""
                                    value="<?php echo $tFTAddRefNo ; ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php $select1="";$select2="";$select3="";
                        if($tFTAddGrpType==1){
                            $select1="selected";
                        }
                        if($tFTAddGrpType==2){
                            $select2="selected";
                        }
                        if($tFTAddGrpType==3){
                            $select3="selected";
                        }                            
                    ?>
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div  class="form-group">
                                <label class="xCNLabelFrm"><?php echo language('supplier/supplier/supplier','tAddGrpType')?></label>
                                    <select class="selectpicker form-control xCNSelectBox" id="oetSplGrpType" name="oetSplGrpType">
                                        <option value="1" <?php echo $select1?>><?php echo language('supplier/supplier/supplier','tSlcAddName')?></option>
                                        <option value="2" <?php echo $select2?>><?php echo language('supplier/supplier/supplier','tSlcAddCtr')?></option>
                                        <option value="3" <?php echo $select3?>><?php echo language('supplier/supplier/supplier','tSlcAddShip')?></option>
                                    </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div  class="form-group">
                                <label class="xCNLabelFrm"><?php echo language('supplier/supplier/supplier','tAddTaxNo')?></label>
                                <div class="form-group">
                                    <input type="text"
                                    class="form-control xCNInputNumericWithDecimal"
                                    maxlength="20" id="oetSplAddTaxNo" name="oetSplAddTaxNo" 
                                    data-is-created=""
                                    value="<?php echo $tFTAddTaxNo ; ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div  class="form-group">
                                <label class="xCNLabelFrm"><?php echo language('supplier/supplier/supplier','tAddV2Desc1')?></label>
                                <div class="form-group">
                                <textarea class="form-group" rows="4" maxlength="100" id="oetSplAddAddress1" name="oetSplAddAddress1"><?php echo $tFTAddV2Desc1 ; ?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div  class="form-group">
                                <label class="xCNLabelFrm"><?php echo language('supplier/supplier/supplier','tAddV2Desc2')?></label>
                                <div class="form-group">
                                <textarea class="form-group" rows="4" maxlength="100" id="oetSplAddAddress1ฃ2" name="oetSplAddAddress2"><?php echo $tFTAddV2Desc2 ; ?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div  class="form-group">
                                <label class="xCNLabelFrm"><?php echo language('supplier/supplier/supplier','tAddWebsite')?></label>
                                <div class="form-group">
                                    <input type="text"
                                    class="form-control"
                                    maxlength="200" id="oetSplAddWeb" name="oetSplAddWeb" 
                                    data-is-created=""
                                    value="<?php echo $tFTAddWebsite ; ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div  class="form-group">
                                <label class="xCNLabelFrm"><?php echo language('supplier/supplier/supplier','tCtrRmk')?></label>
                                <div class="form-group">
                                    <textarea class="form-group" rows="4" maxlength="100" id="oetSplAddNote" name="oetSplAddNote"><?php echo $tFTAddRmk ; ?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                

                <div class="col-lg-6 col-md-6">
                <br>
                    <div class="form-group">
                        <div id="odvMapEdit" class="xCNMapShow"></div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <?php
            }else{//ผู้ใช้เลือกฟอร์มยาว UsrValue = 2
    ?>
    <form class="contact100-form validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" id="ofmAddAddress">
                    <div class="demo-button xCNBtngroup" style="width:100%;" align="right">
                        <button class="btn" type="reset" onclick="JSxAddressDatatable($('#ohdSupcode').val())"  style="background-color: #D4D4D4; color: #000000;"><?php echo language('supplier/supplier/supplier','tSPLTBReset')?></button>
                        <button type="submit" class="btn" onclick="JSoAddEditSupplierAddress('<?php echo $tRout;?>', $('#ohdSupcode').val(), $('#ohdSeqNo').val())" style="background-color:#179BFD; color:white;"><?php echo language('common/main/main', 'tSave')?></button>
                    </div>
        <input type="hidden" class="form-control" id="oetCmpMapLong" name="oetCmpMapLong" value="<?php echo $tFTAddLongitude?>">
        <input type="hidden" class="form-control" id="oetCmpMapLat" name="oetCmpMapLat" value="<?php echo $tFTAddLatitude?>">
        <input type="hidden" class="form-control" id="ohdSeqNo" name="ohdSeqNo" value="<?php echo $nFNAddSeqNo ; ?>">
        <input type="hidden" class="form-control" id="ohdVersion" name="ohdVersion" value="2">

        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div  class="form-group">
                                <label class="xCNLabelFrm"><?php echo language('supplier/supplier/supplier','tAddressName')?></label>
                                <div class="form-group">
                                    <input type="text"
                                    class="form-control"
                                    maxlength="200" id="oetSplAddName" name="oetSplAddName" 
                                    placeholder="<?php echo language('supplier/supplier/supplier','tAddressName')?>"
                                    autocomplete="off"
                                    data-is-created=""
                                    value="<?php echo $tFTAddName ; ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div  class="form-group">
                                <label class="xCNLabelFrm"><?php echo language('supplier/supplier/supplier','tAddV1RefCode')?></label>
                                <div class="form-group">
                                    <input type="text"
                                    class="form-control"
                                    maxlength="20" id="oetSplAddRefNo" 
                                    name="oetSplAddRefNo" 
                                    placeholder="<?php echo language('supplier/supplier/supplier','tAddV1RefCode')?>"
                                    autocomplete="off"
                                    data-is-created=""
                                    value="<?php echo $tFTAddRefNo ; ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div  class="form-group">
                                <label class="xCNLabelFrm"><?php echo language('supplier/supplier/supplier','tAddTaxNo')?></label>
                                <div class="form-group">
                                    <input type="text"
                                    class="form-control xCNInputNumericWithDecimal"
                                    maxlength="20" id="oetSplAddTaxNo" name="oetSplAddTaxNo" 
                                    placeholder="<?php echo language('supplier/supplier/supplier','tAddTaxNo')?>"
                                    autocomplete="off"
                                    data-is-created=""
                                    value="<?php echo $tFTAddTaxNo ; ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php $select1="";$select2="";$select3="";
                        if($tFTAddGrpType==1){
                            $select1="selected";
                        }
                        if($tFTAddGrpType==2){
                            $select2="selected";
                        }
                        if($tFTAddGrpType==3){
                            $select3="selected";
                        }                            
                    ?>
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div  class="form-group">
                                <label class="xCNLabelFrm"><?php echo language('supplier/supplier/supplier','tAddGrpType')?></label>
                                    <select class="selectpicker form-control xCNSelectBox" id="oetSplGrpType" name="oetSplGrpType">   
                                        <option value="1" <?php echo $select1?>><?php echo language('supplier/supplier/supplier','tSlcAddName')?></option>
                                        <option value="2" <?php echo $select2?>><?php echo language('supplier/supplier/supplier','tSlcAddCtr')?></option>
                                        <option value="3" <?php echo $select3?>><?php echo language('supplier/supplier/supplier','tSlcAddShip')?></option>
                                    </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div  class="form-group">
                                <label class="xCNLabelFrm"><?php echo language('supplier/supplier/supplier','tAddCountry')?></label>
                                <div class="form-group">
                                    <input type="text"
                                    class="form-control"
                                    maxlength="100" id="oetSplAddCountry" name="oetSplAddCountry" 
                                    placeholder="<?php echo language('supplier/supplier/supplier','tAddCountry')?>" 
                                    autocomplete="off"
                                    data-is-created=""
                                    value="<?php echo $tFTAddCountry ; ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="row">
                        <div class="col-md-12 col-sm-12">
                        <label class="xCNLabelFrm"><?php echo language('supplier/supplier/supplier','เขต/ภูมิภาค')?></label>
                            <div class="input-group">
                                <input class="form-control xCNHide" id="oetSplZneCode" name="oetSplZneCode" maxlength="5" onchange="JSxResetVal('oetSplZneCode','<?php echo @$aCnfAddPanal[0]->FTZneCode;?>',1)" value="<?php echo @$aCnfAddPanal[0]->FTZneChain;?>">
                                <input class="form-control xWPointerEventNone" type="text" id="oetSplZneName" name="oetSplZneName" value="<?php echo @$aCnfAddPanal[0]->FTZneName;?>" readonly>
                                <span class="input-group-btn">
                                    <button id="obtSplBrowseZone" type="button" class="btn xCNBtnBrowseAddOn">
                                        <img src="<?php echo  base_url().'application/modules/common/assets/images/icons/find-24.png'?>">
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div> -->
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div class="form-group">
                                <label class="xCNLabelFrm"><?php echo  language('company/branch/branch','tAddV1PvnCode')?></label>
                                <div class="input-group">
                                    <input class="form-control xCNHide" id="oetAddPvnCode" name="oetAddPvnCode" maxlength="5" onchange="JSxResetVal('oetAddPvnCode','<?php echo $tFTAddV1PvnCode ; ?>',3)" value="<?php echo $tFTAddV1PvnCode; ?>"> <!--value="<?php if(@$nCnfAddVersion == '1'){ echo @$aCnfAddPanal[0]->FTAddV1PvnCode; } ?>" -->
                                    <input class="form-control xWPointerEventNone" type="text" id="oetAddPvnName" name="oetAddPvnName" value="<?php echo $tFTPvnName; ?>" readonly>
                                    <span class="input-group-btn">
                                        <button id="obtSplBrowseProvince" type="button" class="btn xCNBtnBrowseAddOn">
                                            <img src="<?php echo  base_url().'application/modules/common/assets/images/icons/find-24.png'?>">
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div class="form-group">
                                <label class="xCNLabelFrm"><?php echo  language('company/branch/branch','tAddV1DstCode')?></label>
                                <div class="input-group">
                                    <input class="form-control xCNHide" id="oetAddDstCode" name="oetAddDstCode" maxlength="5" onchange="JSxResetVal('oetAddDstCode','<?php echo $tFTAddV1DstCode ; ?>',4)" value="<?php echo $tFTAddV1DstCode ;?>">
                                    <input class="form-control xWPointerEventNone" type="text" id="oetAddDstName" name="oetAddDstName" value="<?php echo $tFTDstName ?>" readonly>
                                    <span class="input-group-btn">
                                        <button id="obtSplBrowseDistrict" type="button" class="btn xCNBtnBrowseAddOn">
                                            <img src="<?php echo  base_url().'application/modules/common/assets/images/icons/find-24.png'?>">
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div class="form-group">
                                <label class="xCNLabelFrm"><?php echo  language('company/branch/branch','tAddV1SubDist')?></label>
                                <div class="input-group">
                                    <input class="form-control xCNHide" id="oetAddSubDistCode" name="oetAddSubDistCode" maxlength="5" value="<?php echo $tFTAddV1SubDist ;?>">
                                    <input class="form-control xWPointerEventNone" type="text" id="oetAddSubDistName" name="oetAddSubDistName" value="<?php echo $tFTSudName ; ?>" readonly>
                                    <span class="input-group-btn">
                                        <button id="obtSplBrowseSubDistrict" type="button" class="btn xCNBtnBrowseAddOn">
                                            <img src="<?php echo  base_url().'application/modules/common/assets/images/icons/find-24.png'?>">
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div  class="form-group">
                                <label class="xCNLabelFrm"><?php echo language('supplier/supplier/supplier','tAddV1No')?></label>
                                <div class="form-group">
                                    <input type="text"
                                    class="form-control"
                                    maxlength="20" id="oetSplAddHomeNo" name="oetSplAddHomeNo"
                                    placeholder="<?php echo language('supplier/supplier/supplier','tAddV1No')?>" 
                                    autocomplete="off"
                                    data-is-created=""
                                    value="<?php echo $tFTAddV1No ; ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div  class="form-group">
                                <label class="xCNLabelFrm"><?php echo language('supplier/supplier/supplier','tAddV1Village')?></label>
                                <div class="form-group">
                                    <input type="text"
                                    class="form-control"
                                    maxlength="20" id="oetSplAddvillage" name="oetSplAddvillage"
                                    placeholder="<?php echo language('supplier/supplier/supplier','tAddV1Village')?>" 
                                    autocomplete="off"
                                    data-is-created=""
                                    value="<?php echo $tFTAddV1Village ; ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div  class="form-group">
                                <label class="xCNLabelFrm"><?php echo language('supplier/supplier/supplier','tAddV1Road')?></label>
                                <div class="form-group">
                                    <input type="text"
                                    class="form-control"
                                    maxlength="20" id="oetSplAddRoad" name="oetSplAddRoad" 
                                    placeholder="<?php echo language('supplier/supplier/supplier','tAddV1Road')?>" 
                                    autocomplete="off"
                                    data-is-created=""
                                    value="<?php echo $tFTAddV1Road ; ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div  class="form-group">
                                <label class="xCNLabelFrm"><?php echo language('supplier/supplier/supplier','tAddV1Soi')?></label>
                                <div class="form-group">
                                    <input type="text"
                                    class="form-control"
                                    maxlength="20" id="oetSplAddAlley" name="oetSplAddAlley" 
                                    placeholder="<?php echo language('supplier/supplier/supplier','tAddV1Soi')?>" 
                                    autocomplete="off"
                                    data-is-created=""
                                    value="<?php echo $tFTAddV1Soi ; ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div  class="form-group">
                                <label class="xCNLabelFrm"><?php echo language('supplier/supplier/supplier','tAddV1PostCode')?></label>
                                <div class="form-group">
                                    <input type="text"
                                    class="form-control xCNInputNumericWithDecimal"
                                    maxlength="5" id="oetSplAddZipCode" name="oetSplAddZipCode" 
                                    placeholder="<?php echo language('supplier/supplier/supplier','tAddV1PostCode')?>"
                                    autocomplete="off"
                                    data-is-created=""
                                    value="<?php echo $tFTAddV1PostCode ; ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div  class="form-group">
                                <label class="xCNLabelFrm"><?php echo language('supplier/supplier/supplier','tAddWebsite')?></label>
                                <div class="form-group">
                                    <input type="text"
                                    class="form-control"
                                    maxlength="200" id="oetSplAddWeb" name="oetSplAddWeb" 
                                    placeholder="<?php echo language('supplier/supplier/supplier','tAddWebsite')?>"
                                    autocomplete="off"
                                    data-is-created=""
                                    value="<?php echo $tFTAddWebsite ; ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div  class="form-group">
                                <label class="xCNLabelFrm"><?php echo language('supplier/supplier/supplier','tCtrRmk')?></label>
                                <div class="form-group">
                                    <textarea class="input100" rows="4" maxlength="100" id="oetSplAddNote" name="oetSplAddNote"><?php echo $tFTAddRmk ; ?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="col-lg-6 col-md-6">
                <br>
                    <div class="form-group">
                        <div id="odvMapEdit" class="xCNMapShow"></div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <?php
            }//จบฟอร์มยาว UsrValue = 2
    }else{
        if($value['FTSysStaDefValue']==1){//ฟอร์อมสั้น Default DefValdue = 1 (ผู้ใช้ไม่ได้เลือก) 
    ?>
    <form class="contact100-form validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" id="ofmAddAddress">
                    <div class="demo-button xCNBtngroup" style="width:100%;" align="right">
                        <button class="btn" type="reset"  onclick="JSxAddressDatatable($('#ohdSupcode').val());" style="background-color: #D4D4D4; color: #000000;"><?php echo language('supplier/supplier/supplier','tSPLTBReset')?></button>
                        <button type="submit" class="btn" onclick="JSoAddEditSupplierAddress('<?php echo $tRout;?>', $('#ohdSupcode').val(), $('#ohdSeqNo').val())" style="background-color:#179BFD; color:white;"><?php echo language('common/main/main', 'tSave')?></button>
                    </div>
        <input type="hidden" class="form-control" id="oetCmpMapLong" name="oetCmpMapLong" value="<?php echo $tFTAddLongitude?>">
        <input type="hidden" class="form-control" id="oetCmpMapLat" name="oetCmpMapLat" value="<?php echo $tFTAddLatitude?>">
        <input type="hidden" class="form-control" id="ohdSeqNo" name="ohdSeqNo" value="<?php echo $nFNAddSeqNo ; ?>">
        <input type="hidden" class="form-control" id="ohdVersion" name="ohdVersion" value="1">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div  class="form-group">
                                <label class="xCNLabelFrm"><?php echo language('supplier/supplier/supplier','tAddressName')?></label>
                                <div class="form-group">
                                    <input type="text"
                                    class="form-control"
                                    maxlength="200" id="oetSplAddName" name="oetSplAddName" 
                                    data-is-created=""
                                    value="<?php echo $tFTAddName ; ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div  class="form-group">
                                <label class="xCNLabelFrm"><?php echo language('supplier/supplier/supplier','tAddV1RefCode')?></label>
                                <div class="form-group">
                                    <input type="text"
                                    class="form-control"
                                    maxlength="20" id="oetSplAddRefNo" name="oetSplAddRefNo" 
                                    data-is-created=""
                                    value="<?php echo $tFTAddRefNo ; ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php $select1="";$select2="";$select3="";
                        if($tFTAddGrpType==1){
                            $select1="selected";
                        }
                        if($tFTAddGrpType==2){
                            $select2="selected";
                        }
                        if($tFTAddGrpType==3){
                            $select3="selected";
                        }                            
                    ?>
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div  class="form-group">
                                <label class="xCNLabelFrm"><?php echo language('supplier/supplier/supplier','tAddGrpType')?></label>
                                    <select class="selectpicker form-control xCNSelectBox" id="oetSplGrpType" name="oetSplGrpType">
                                        <option value="1" <?php echo $select1?>><?php echo language('supplier/supplier/supplier','tSlcAddName')?></option>
                                        <option value="2" <?php echo $select2?>><?php echo language('supplier/supplier/supplier','tSlcAddCtr')?></option>
                                        <option value="3" <?php echo $select3?>><?php echo language('supplier/supplier/supplier','tSlcAddShip')?></option>
                                    </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div  class="form-group">
                                <label class="xCNLabelFrm"><?php echo language('supplier/supplier/supplier','tAddTaxNo')?></label>
                                <div class="form-group">
                                    <input type="text"
                                    class="form-control xCNInputNumericWithDecimal"
                                    maxlength="20" id="oetSplAddTaxNo" name="oetSplAddTaxNo" 
                                    data-is-created=""
                                    value="<?php echo $tFTAddTaxNo ; ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div  class="form-group">
                                <label class="xCNLabelFrm"><?php echo language('supplier/supplier/supplier','tAddV2Desc1')?></label>
                                <div class="form-group">
                                <textarea class="input100" rows="4" maxlength="100" id="oetSplAddAddress1" name="oetSplAddAddress1"><?php echo $tFTAddV2Desc1 ; ?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div  class="form-group">
                                <label class="xCNLabelFrm"><?php echo language('supplier/supplier/supplier','tAddV2Desc2')?></label>
                                <div class="form-group">
                                <textarea class="input100" rows="4" maxlength="100" id="oetSplAddAddress1ฃ2" name="oetSplAddAddress2"><?php echo $tFTAddV2Desc2 ; ?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div  class="form-group">
                                <label class="xCNLabelFrm"><?php echo language('supplier/supplier/supplier','tAddWebsite')?></label>
                                <div class="form-group">
                                    <input type="text"
                                    class="form-control"
                                    maxlength="200" id="oetSplAddWeb" name="oetSplAddWeb" 
                                    data-is-created=""
                                    value="<?php echo $tFTAddWebsite ; ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div  class="form-group">
                                <label class="xCNLabelFrm"><?php echo language('supplier/supplier/supplier','tCtrRmk')?></label>
                                <div class="form-group">
                                    <textarea class="input100" rows="4" maxlength="100" id="oetSplAddNote" name="oetSplAddNote"><?php echo $tFTAddRmk ; ?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                

                <div class="col-lg-6 col-md-6">
                <br>
                    <div class="form-group">
                        <div id="odvMapEdit" class="xCNMapShow"></div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <?php
        }else{ //ฟอร์อมยาว Default DefValdue = 2 (ผู้ใช้ไม่ได้เลือก)  
    ?>
    <form class="contact100-form validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" id="ofmAddAddress">
                    <div class="demo-button xCNBtngroup" style="width:100%;" align="right">
                        <button class="btn" type="reset" onclick="JSxAddressDatatable($('#ohdSupcode').val());"  style="background-color: #D4D4D4; color: #000000;"><?php echo language('supplier/supplier/supplier','tSPLTBReset')?></button>
                        <button type="submit" class="btn" onclick="JSoAddEditSupplierAddress('<?php echo $tRout;?>', $('#ohdSupcode').val(), $('#ohdSeqNo').val())" style="background-color:#179BFD; color:white;"><?php echo language('common/main/main', 'tSave')?></button>
                    </div>
        <input type="hidden" class="form-control" id="oetCmpMapLong" name="oetCmpMapLong" value="<?php echo $tFTAddLongitude?>">
        <input type="hidden" class="form-control" id="oetCmpMapLat" name="oetCmpMapLat" value="<?php echo $tFTAddLatitude?>">
        <input type="hidden" class="form-control" id="ohdSeqNo" name="ohdSeqNo" value="<?php echo $nFNAddSeqNo ; ?>">
        <input type="hidden" class="form-control" id="ohdVersion" name="ohdVersion" value="2">

        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div  class="form-group">
                                <label class="xCNLabelFrm"><?php echo language('supplier/supplier/supplier','tAddressName')?></label>
                                <div class="form-group">
                                    <input type="text"
                                    class="form-control"
                                    maxlength="200" id="oetSplAddName" name="oetSplAddName" 
                                    data-is-created=""
                                    value="<?php echo $tFTAddName ; ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div  class="form-group">
                                <label class="xCNLabelFrm"><?php echo language('supplier/supplier/supplier','tAddV1RefCode')?></label>
                                <div class="form-group">
                                    <input type="text"
                                    class="form-control xCNInputWithoutSpcNotThai"
                                    maxlength="20" id="oetSplAddRefNo" name="oetSplAddRefNo" 
                                    data-is-created=""
                                    value="<?php echo $tFTAddRefNo ; ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div  class="form-group">
                                <label class="xCNLabelFrm"><?php echo language('supplier/supplier/supplier','tAddTaxNo')?></label>
                                <div class="form-group">
                                    <input type="text"
                                    class="form-control xCNInputNumericWithDecimal"
                                    maxlength="20" id="oetSplAddTaxNo" name="oetSplAddTaxNo" 
                                    data-is-created=""
                                    value="<?php echo $tFTAddTaxNo ; ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php $select1="";$select2="";$select3="";
                        if($tFTAddGrpType==1){
                            $select1="selected";
                        }
                        if($tFTAddGrpType==2){
                            $select2="selected";
                        }
                        if($tFTAddGrpType==3){
                            $select3="selected";
                        }                            
                    ?>
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div  class="form-group">
                                <label class="xCNLabelFrm"><?php echo language('supplier/supplier/supplier','tAddGrpType')?></label>
                                    <select class="selectpicker form-control xCNSelectBox" id="oetSplGrpType" name="oetSplGrpType">   
                                        <option value="1" <?php echo $select1?>><?php echo language('supplier/supplier/supplier','tSlcAddName')?></option>
                                        <option value="2" <?php echo $select2?>><?php echo language('supplier/supplier/supplier','tSlcAddCtr')?></option>
                                        <option value="3" <?php echo $select3?>><?php echo language('supplier/supplier/supplier','tSlcAddShip')?></option>
                                    </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div  class="form-group">
                                <label class="xCNLabelFrm"><?php echo language('supplier/supplier/supplier','tAddCountry')?></label>
                                <div class="form-group">
                                    <input type="text"
                                    class="form-control"
                                    maxlength="100" id="oetSplAddCountry" name="oetSplAddCountry" 
                                    data-is-created=""
                                    value="<?php echo $tFTAddCountry ; ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="row">
                        <div class="col-md-12 col-sm-12">
                        <label class="xCNLabelFrm"><?php echo language('supplier/supplier/supplier','เขต/ภูมิภาค')?></label>
                            <div class="input-group">
                                <input class="form-control xCNHide" id="oetSplZneCode" name="oetSplZneCode" maxlength="5" onchange="JSxResetVal('oetSplZneCode','<?php echo @$aCnfAddPanal[0]->FTZneCode;?>',1)" value="<?php echo @$aCnfAddPanal[0]->FTZneChain;?>">
                                <input class="form-control xWPointerEventNone" type="text" id="oetSplZneName" name="oetSplZneName" value="<?php echo @$aCnfAddPanal[0]->FTZneName;?>" readonly>
                                <span class="input-group-btn">
                                    <button id="obtSplBrowseZone" type="button" class="btn xCNBtnBrowseAddOn">
                                        <img src="<?php echo  base_url().'application/modules/common/assets/images/icons/find-24.png'?>">
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div> -->
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div class="form-group">
                                <label class="xCNLabelFrm"><?php echo  language('company/branch/branch','tAddV1PvnCode')?></label>
                                <div class="input-group">
                                    <input class="form-control xCNHide" id="oetAddPvnCode" name="oetAddPvnCode" maxlength="5" onchange="JSxResetVal('oetAddPvnCode','<?php echo $tFTAddV1PvnCode ; ?>',3)" value="<?php echo $tFTAddV1PvnCode; ?>"> <!--value="<?php if(@$nCnfAddVersion == '1'){ echo @$aCnfAddPanal[0]->FTAddV1PvnCode; } ?>" -->
                                    <input class="form-control xWPointerEventNone" type="text" id="oetAddPvnName" name="oetAddPvnName" value="<?php echo $tFTPvnName; ?>" readonly>
                                    <span class="input-group-btn">
                                        <button id="obtSplBrowseProvince" type="button" class="btn xCNBtnBrowseAddOn">
                                            <img src="<?php echo  base_url().'application/modules/common/assets/images/icons/find-24.png'?>">
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div class="form-group">
                                <label class="xCNLabelFrm"><?php echo  language('company/branch/branch','tAddV1DstCode')?></label>
                                <div class="input-group">
                                    <input class="form-control xCNHide" id="oetAddDstCode" name="oetAddDstCode" maxlength="5" onchange="JSxResetVal('oetAddDstCode','<?php echo $tFTAddV1DstCode ; ?>',4)" value="<?php echo $tFTAddV1DstCode ;?>">
                                    <input class="form-control xWPointerEventNone" type="text" id="oetAddDstName" name="oetAddDstName" value="<?php echo $tFTDstName ?>" readonly>
                                    <span class="input-group-btn">
                                        <button id="obtSplBrowseDistrict" type="button" class="btn xCNBtnBrowseAddOn">
                                            <img src="<?php echo  base_url().'application/modules/common/assets/images/icons/find-24.png'?>">
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div class="form-group">
                                <label class="xCNLabelFrm"><?php echo  language('company/branch/branch','tAddV1SubDist')?></label>
                                <div class="input-group">
                                    <input class="form-control xCNHide" id="oetAddSubDistCode" name="oetAddSubDistCode" maxlength="5" value="<?php echo $tFTAddV1SubDist ;?>">
                                    <input class="form-control xWPointerEventNone" type="text" id="oetAddSubDistName" name="oetAddSubDistName" value="<?php echo $tFTSudName ; ?>" readonly>
                                    <span class="input-group-btn">
                                        <button id="obtSplBrowseSubDistrict" type="button" class="btn xCNBtnBrowseAddOn">
                                            <img src="<?php echo  base_url().'application/modules/common/assets/images/icons/find-24.png'?>">
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div  class="form-group">
                                <label class="xCNLabelFrm"><?php echo language('supplier/supplier/supplier','tAddV1No')?></label>
                                <div class="form-group">
                                    <input type="text"
                                    class="form-control"
                                    maxlength="20" id="oetSplAddHomeNo" name="oetSplAddHomeNo" 
                                    data-is-created=""
                                    value="<?php echo $tFTAddV1No ; ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div  class="form-group">
                                <label class="xCNLabelFrm"><?php echo language('supplier/supplier/supplier','tAddV1Village')?></label>
                                <div class="form-group">
                                    <input type="text"
                                    class="form-control"
                                    maxlength="20" id="oetSplAddvillage" name="oetSplAddvillage" 
                                    data-is-created=""
                                    value="<?php echo $tFTAddV1Village ; ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div  class="form-group">
                                <label class="xCNLabelFrm"><?php echo language('supplier/supplier/supplier','tAddV1Road')?></label>
                                <div class="form-group">
                                    <input type="text"
                                    class="form-control"
                                    maxlength="20" id="oetSplAddRoad" name="oetSplAddRoad" 
                                    data-is-created=""
                                    value="<?php echo $tFTAddV1Road ; ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div  class="form-group">
                                <label class="xCNLabelFrm"><?php echo language('supplier/supplier/supplier','tAddV1Soi')?></label>
                                <div class="form-group">
                                    <input type="text"
                                    class="form-control"
                                    maxlength="20" id="oetSplAddAlley" name="oetSplAddAlley" 
                                    data-is-created=""
                                    value="<?php echo $tFTAddV1Soi ; ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div  class="form-group">
                                <label class="xCNLabelFrm"><?php echo language('supplier/supplier/supplier','tAddV1PostCode')?></label>
                                <div class="form-group">
                                    <input type="text"
                                    class="form-control xCNInputNumericWithDecimal"
                                    maxlength="5" id="oetSplAddZipCode" name="oetSplAddZipCode" 
                                    data-is-created=""
                                    value="<?php echo $tFTAddV1PostCode ; ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div  class="form-group">
                                <label class="xCNLabelFrm"><?php echo language('supplier/supplier/supplier','tAddWebsite')?></label>
                                <div class="form-group">
                                    <input type="text"
                                    class="form-control"
                                    maxlength="200" id="oetSplAddWeb" name="oetSplAddWeb" 
                                    data-is-created=""
                                    value="<?php echo $tFTAddWebsite ; ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div  class="form-group">
                                <label class="xCNLabelFrm"><?php echo language('supplier/supplier/supplier','tCtrRmk')?></label>
                                <div class="form-group">
                                    <textarea class="input100" rows="4" maxlength="100" id="oetSplAddNote" name="oetSplAddNote"><?php echo $tFTAddRmk ; ?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="col-lg-6 col-md-6">
                <br>
                    <div class="form-group">
                        <div id="odvMapEdit" class="xCNMapShow"></div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <?php
        }
    }
}else{

    if($tFTAddVersion=="1"){?>
            <form class="contact100-form validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" id="ofmAddAddress">
                        <div class="demo-button xCNBtngroup" style="width:100%;" align="right">
                            <button class="btn" type="reset"  onclick="JSxAddressDatatable($('#ohdSupcode').val());" style="background-color: #D4D4D4; color: #000000;"><?php echo language('supplier/supplier/supplier','tSPLTBReset')?></button>
                            <button type="submit" class="btn" onclick="JSoAddEditSupplierAddress('<?php echo $tRout;?>', $('#ohdSupcode').val(), $('#ohdSeqNo').val())" style="background-color:#179BFD; color:white;"><?php echo language('common/main/main', 'tSave')?></button>
                        </div>
                <input type="hidden" class="form-control" id="oetCmpMapLong" name="oetCmpMapLong" value="<?php echo $tFTAddLongitude?>">
                <input type="hidden" class="form-control" id="oetCmpMapLat" name="oetCmpMapLat" value="<?php echo $tFTAddLatitude?>">
                <input type="hidden" class="form-control" id="ohdSeqNo" name="ohdSeqNo" value="<?php echo $nFNAddSeqNo ; ?>">
                <input type="hidden" class="form-control" id="ohdVersion" name="ohdVersion" value="1">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-6 col-md-6">
                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <div  class="form-group">
                                        <label class="xCNLabelFrm"><?php echo language('supplier/supplier/supplier','tAddressName')?></label>
                                        <div class="form-group">
                                            <input type="text"
                                            class="form-control"
                                            maxlength="200" id="oetSplAddName" name="oetSplAddName" 
                                            data-is-created=""
                                            value="<?php echo $tFTAddName ; ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <div  class="form-group">
                                        <label class="xCNLabelFrm"><?php echo language('supplier/supplier/supplier','tAddV1RefCode')?></label>
                                        <div class="form-group">
                                            <input type="text"
                                            class="form-control"
                                            maxlength="20" id="oetSplAddRefNo" name="oetSplAddRefNo" 
                                            data-is-created=""
                                            value="<?php echo $tFTAddRefNo ; ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php $select1="";$select2="";$select3="";
                                if($tFTAddGrpType==1){
                                    $select1="selected";
                                }
                                if($tFTAddGrpType==2){
                                    $select2="selected";
                                }
                                if($tFTAddGrpType==3){
                                    $select3="selected";
                                }                            
                            ?>
                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <div  class="form-group">
                                        <label class="xCNLabelFrm"><?php echo language('supplier/supplier/supplier','tAddGrpType')?></label>
                                            <select class="selectpicker form-control xCNSelectBox" id="oetSplGrpType" name="oetSplGrpType">
                                                <option value="1" <?php echo $select1?>><?php echo language('supplier/supplier/supplier','tSlcAddName')?></option>
                                                <option value="2" <?php echo $select2?>><?php echo language('supplier/supplier/supplier','tSlcAddCtr')?></option>
                                                <option value="3" <?php echo $select3?>><?php echo language('supplier/supplier/supplier','tSlcAddShip')?></option>
                                            </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <div  class="form-group">
                                        <label class="xCNLabelFrm"><?php echo language('supplier/supplier/supplier','tAddTaxNo')?></label>
                                        <div class="form-group">
                                            <input type="text"
                                            class="form-control xCNInputNumericWithDecimal"
                                            maxlength="20" id="oetSplAddTaxNo" name="oetSplAddTaxNo" 
                                            data-is-created=""
                                            value="<?php echo $tFTAddTaxNo ; ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <div  class="form-group">
                                        <label class="xCNLabelFrm"><?php echo language('supplier/supplier/supplier','tAddV2Desc1')?></label>
                                        <div class="form-group">
                                        <textarea class="input100" rows="4" maxlength="100" id="oetSplAddAddress1" name="oetSplAddAddress1"><?php echo $tFTAddV2Desc1 ; ?></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <div  class="form-group">
                                        <label class="xCNLabelFrm"><?php echo language('supplier/supplier/supplier','tAddV2Desc2')?></label>
                                        <div class="form-group">
                                        <textarea class="input100" rows="4" maxlength="100" id="oetSplAddAddress2" name="oetSplAddAddress2"><?php echo $tFTAddV2Desc2 ; ?></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <div  class="form-group">
                                        <label class="xCNLabelFrm"><?php echo language('supplier/supplier/supplier','tAddWebsite')?></label>
                                        <div class="form-group">
                                            <input type="text"
                                            class="form-control"
                                            maxlength="200" id="oetSplAddWeb" name="oetSplAddWeb" 
                                            data-is-created=""
                                            value="<?php echo $tFTAddWebsite ; ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <div  class="form-group">
                                        <label class="xCNLabelFrm"><?php echo language('supplier/supplier/supplier','tCtrRmk')?></label>
                                        <div class="form-group">
                                            <textarea class="form-group" rows="4" maxlength="100" id="oetSplAddNote" name="oetSplAddNote"><?php echo $tFTAddRmk ; ?></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        

                        <div class="col-lg-6 col-md-6">
                        <br>
                            <div class="form-group">
                                <div id="odvMapEdit" class="xCNMapShow"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
<?php }else{ ?>
            <form class="contact100-form validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" id="ofmAddAddress">
                            <div class="demo-button xCNBtngroup" style="width:100%;" align="right">
                                <button class="btn" type="reset"   style="background-color: #D4D4D4; color: #000000;"><?php echo language('supplier/supplier/supplier','tSPLTBReset')?></button>
                                <button type="submit" class="btn" onclick="JSoAddEditSupplierAddress('<?php echo $tRout;?>', $('#ohdSupcode').val(), $('#ohdSeqNo').val())" style="background-color:#179BFD; color:white;"><?php echo language('common/main/main', 'tSave')?></button>
                            </div>
                <input type="hidden" class="form-control" id="oetCmpMapLong" name="oetCmpMapLong" value="<?php echo $tFTAddLongitude?>">
                <input type="hidden" class="form-control" id="oetCmpMapLat" name="oetCmpMapLat" value="<?php echo $tFTAddLatitude?>">
                <input type="hidden" class="form-control" id="ohdSeqNo" name="ohdSeqNo" value="<?php echo $nFNAddSeqNo ; ?>">
                <input type="hidden" class="form-control" id="ohdVersion" name="ohdVersion" value="2">

                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-6 col-md-6">
                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <div  class="form-group">
                                        <label class="xCNLabelFrm"><?php echo language('supplier/supplier/supplier','tAddressName')?></label>
                                        <div class="form-group">
                                            <input type="text"
                                            class="form-control"
                                            maxlength="200" id="oetSplAddName" name="oetSplAddName" 
                                            data-is-created=""
                                            value="<?php echo $tFTAddName ; ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <div  class="form-group">
                                        <label class="xCNLabelFrm"><?php echo language('supplier/supplier/supplier','tAddV1RefCode')?></label>
                                        <div class="form-group">
                                            <input type="text"
                                            class="form-control xCNInputWithoutSpcNotThai"
                                            maxlength="20" id="oetSplAddRefNo" name="oetSplAddRefNo" 
                                            data-is-created=""
                                            value="<?php echo $tFTAddRefNo ; ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <div  class="form-group">
                                        <label class="xCNLabelFrm"><?php echo language('supplier/supplier/supplier','tAddTaxNo')?></label>
                                        <div class="form-group">
                                            <input type="text"
                                            class="form-control xCNInputNumericWithDecimal"
                                            maxlength="20" id="oetSplAddTaxNo" name="oetSplAddTaxNo" 
                                            data-is-created=""
                                            value="<?php echo $tFTAddTaxNo ; ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php $select1="";$select2="";$select3="";
                                if($tFTAddGrpType==1){
                                    $select1="selected";
                                }
                                if($tFTAddGrpType==2){
                                    $select2="selected";
                                }
                                if($tFTAddGrpType==3){
                                    $select3="selected";
                                }                            
                            ?>
                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <div  class="form-group">
                                        <label class="xCNLabelFrm"><?php echo language('supplier/supplier/supplier','tAddGrpType')?></label>
                                            <select class="selectpicker form-control xCNSelectBox" id="oetSplGrpType" name="oetSplGrpType">   
                                                <option value="1" <?php echo $select1?>><?php echo language('supplier/supplier/supplier','tSlcAddName')?></option>
                                                <option value="2" <?php echo $select2?>><?php echo language('supplier/supplier/supplier','tSlcAddCtr')?></option>
                                                <option value="3" <?php echo $select3?>><?php echo language('supplier/supplier/supplier','tSlcAddShip')?></option>
                                            </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <div  class="form-group">
                                        <label class="xCNLabelFrm"><?php echo language('supplier/supplier/supplier','tAddCountry')?></label>
                                        <div class="form-group">
                                            <input type="text"
                                            class="form-control"
                                            maxlength="100" id="oetSplAddCountry" name="oetSplAddCountry" 
                                            data-is-created=""
                                            value="<?php echo $tFTAddCountry ; ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="row">
                                <div class="col-md-12 col-sm-12">
                                <label class="xCNLabelFrm"><?php echo language('supplier/supplier/supplier','เขต/ภูมิภาค')?></label>
                                    <div class="input-group">
                                        <input class="form-control xCNHide" id="oetSplZneCode" name="oetSplZneCode" maxlength="5" onchange="JSxResetVal('oetSplZneCode','<?php echo @$aCnfAddPanal[0]->FTZneCode;?>',1)" value="<?php echo @$aCnfAddPanal[0]->FTZneChain;?>">
                                        <input class="form-control xWPointerEventNone" type="text" id="oetSplZneName" name="oetSplZneName" value="<?php echo @$aCnfAddPanal[0]->FTZneName;?>" readonly>
                                        <span class="input-group-btn">
                                            <button id="obtSplBrowseZone" type="button" class="btn xCNBtnBrowseAddOn">
                                                <img src="<?php echo  base_url().'application/modules/common/assets/images/icons/find-24.png'?>">
                                            </button>
                                        </span>
                                    </div>
                                </div>
                            </div> -->
                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <label class="xCNLabelFrm"><?php echo  language('company/branch/branch','tAddV1PvnCode')?></label>
                                        <div class="input-group">
                                            <input class="form-control xCNHide" id="oetAddPvnCode" name="oetAddPvnCode" maxlength="5" onchange="JSxResetVal('oetAddPvnCode','<?php echo $tFTAddV1PvnCode ; ?>',3)" value="<?php echo $tFTAddV1PvnCode; ?>"> <!--value="<?php if(@$nCnfAddVersion == '1'){ echo @$aCnfAddPanal[0]->FTAddV1PvnCode; } ?>" -->
                                            <input class="form-control xWPointerEventNone" type="text" id="oetAddPvnName" name="oetAddPvnName" value="<?php echo $tFTPvnName; ?>" readonly>
                                            <span class="input-group-btn">
                                                <button id="obtSplBrowseProvince" type="button" class="btn xCNBtnBrowseAddOn">
                                                    <img src="<?php echo  base_url().'application/modules/common/assets/images/icons/find-24.png'?>">
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <label class="xCNLabelFrm"><?php echo  language('company/branch/branch','tAddV1DstCode')?></label>
                                        <div class="input-group">
                                            <input class="form-control xCNHide" id="oetAddDstCode" name="oetAddDstCode" maxlength="5" onchange="JSxResetVal('oetAddDstCode','<?php echo $tFTAddV1DstCode ; ?>',4)" value="<?php echo $tFTAddV1DstCode ;?>">
                                            <input class="form-control xWPointerEventNone" type="text" id="oetAddDstName" name="oetAddDstName" value="<?php echo $tFTDstName ?>" readonly>
                                            <span class="input-group-btn">
                                                <button id="obtSplBrowseDistrict" type="button" class="btn xCNBtnBrowseAddOn">
                                                    <img src="<?php echo  base_url().'application/modules/common/assets/images/icons/find-24.png'?>">
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <label class="xCNLabelFrm"><?php echo  language('company/branch/branch','tAddV1SubDist')?></label>
                                        <div class="input-group">
                                            <input class="form-control xCNHide" id="oetAddSubDistCode" name="oetAddSubDistCode" maxlength="5" value="<?php echo $tFTAddV1SubDist ;?>">
                                            <input class="form-control xWPointerEventNone" type="text" id="oetAddSubDistName" name="oetAddSubDistName" value="<?php echo $tFTSudName ; ?>" readonly>
                                            <span class="input-group-btn">
                                                <button id="obtSplBrowseSubDistrict" type="button" class="btn xCNBtnBrowseAddOn">
                                                    <img src="<?php echo  base_url().'application/modules/common/assets/images/icons/find-24.png'?>">
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <div  class="form-group">
                                        <label class="xCNLabelFrm"><?php echo language('supplier/supplier/supplier','tAddV1No')?></label>
                                        <div class="form-group">
                                            <input type="text"
                                            class="form-control"
                                            maxlength="20" id="oetSplAddHomeNo" name="oetSplAddHomeNo" 
                                            data-is-created=""
                                            value="<?php echo $tFTAddV1No ; ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <div  class="form-group">
                                        <label class="xCNLabelFrm"><?php echo language('supplier/supplier/supplier','tAddV1Village')?></label>
                                        <div class="form-group">
                                            <input type="text"
                                            class="form-control"
                                            maxlength="20" id="oetSplAddvillage" name="oetSplAddvillage" 
                                            data-is-created=""
                                            value="<?php echo $tFTAddV1Village ; ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <div  class="form-group">
                                        <label class="xCNLabelFrm"><?php echo language('supplier/supplier/supplier','tAddV1Road')?></label>
                                        <div class="form-group">
                                            <input type="text"
                                            class="form-control"
                                            maxlength="20" id="oetSplAddRoad" name="oetSplAddRoad" 
                                            data-is-created=""
                                            value="<?php echo $tFTAddV1Road ; ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <div  class="form-group">
                                        <label class="xCNLabelFrm"><?php echo language('supplier/supplier/supplier','tAddV1Soi')?></label>
                                        <div class="form-group">
                                            <input type="text"
                                            class="form-control"
                                            maxlength="20" id="oetSplAddAlley" name="oetSplAddAlley" 
                                            data-is-created=""
                                            value="<?php echo $tFTAddV1Soi ; ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <div  class="form-group">
                                        <label class="xCNLabelFrm"><?php echo language('supplier/supplier/supplier','tAddV1PostCode')?></label>
                                        <div class="form-group">
                                            <input type="text"
                                            class="form-control xCNInputNumericWithDecimal"
                                            maxlength="5" id="oetSplAddZipCode" name="oetSplAddZipCode" 
                                            data-is-created=""
                                            value="<?php echo $tFTAddV1PostCode ; ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <div  class="form-group">
                                        <label class="xCNLabelFrm"><?php echo language('supplier/supplier/supplier','tAddWebsite')?></label>
                                        <div class="form-group">
                                            <input type="text"
                                            class="form-control"
                                            maxlength="200" id="oetSplAddWeb" name="oetSplAddWeb" 
                                            data-is-created=""
                                            value="<?php echo $tFTAddWebsite ; ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <div  class="form-group">
                                        <label class="xCNLabelFrm"><?php echo language('supplier/supplier/supplier','tCtrRmk')?></label>
                                        <div class="form-group">
                                            <textarea class="input100" rows="4" maxlength="100" id="oetSplAddNote" name="oetSplAddNote"><?php echo $tFTAddRmk ; ?></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="col-lg-6 col-md-6">
                        <br>
                            <div class="form-group">
                                <div id="odvMapEdit" class="xCNMapShow"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
<?php
    }
}
?>





<script>
JSxChekDisableAddress()
$(document).ready(function(){
    $('.selectpicker').selectpicker();
    JSxSetMapToShow();
});
function JSxSetMapToShow(){
    var nStatusLoadMap = 0;
		if(nStatusLoadMap==0){
			//Call Map Api
            var oMapCompany = {
                                tDivShowMap	:'odvMapEdit',
                                cLongitude	: <?php echo (isset($tFTAddLongitude)&&!empty($tFTAddLongitude))? floatval($tFTAddLongitude):floatval('100.50182294100522')?>,
                                cLatitude	: <?php echo (isset($tFTAddLatitude)&&!empty($tFTAddLatitude))? floatval($tFTAddLatitude):floatval('13.757309968845291')?>,
                                tInputLong	: 'oetCmpMapLong',
                                tInputLat	: 'oetCmpMapLat',
                                tIcon		: "https://openlayers.org/en/v4.6.5/examples/data/icon.png",
                                tStatus		: '2'	
                            }
            JSxMapAddEdit(oMapCompany);
			nStatusLoadMap = 1;
        }
    }

    var nLangEdits = <?php echo $this->session->userdata("tLangEdit")?>;

    //ภูมิภาค
    var oSplBrowseZone = {
	Title : ['address/zone/zone','tZNESubTitle'],
	Table:{Master:'TCNMZone',PK:'FTZneCode'},
	Join :{
		Table:	['TCNMZone_L'],
		On:['TCNMZone_L.FTZneCode = TCNMZone.FTZneCode AND TCNMZone_L.FNLngID = '+nLangEdits,]
    },
    
    GrideView:{
		ColumnPathLang	: 'address/zone/zone',
		ColumnKeyLang	: ['tZNECode','tZNEName'],
		ColumnsSize     : ['15%','75%'],
        WidthModal      : 50,
		DataColumns		: ['TCNMZone.FTZneCode','TCNMZone_L.FTZneName'],
		DataColumnsFormat : ['',''],
		Perpage			: 5,
		OrderBy			: ['TCNMZone.FTZneCode'],
		SourceOrder		: "ASC"
	},
	CallBack:{
		ReturnType	: 'S',
		Value		: ["oetSplZneCode","TCNMZone.FTZneCode"],
		Text		: ["oetSplZneName","TCNMZone_L.FTZneName"],
	},
	NextFunc:{
		FuncName:'JSxChekDisableAddress',
		ArgReturn:['FTZneCode',]
    },
	RouteAddNew : 'zone',
    // BrowseLev : nStaBchBrowseType
}


//จังหวัด
var oSplBrowseProvince = {
	Title : ['address/province/province','tPVNTitle'],
	Table:{Master:'TCNMProvince',PK:'FTPvnCode'},
	Join :{
		Table:	['TCNMProvince_L'],
		On:['TCNMProvince_L.FTPvnCode = TCNMProvince.FTPvnCode AND TCNMProvince_L.FNLngID = '+nLangEdits,]
	},
	// Filter:{
	// 	Selector:'oetAddV1PvnCode',
	// 	Table:'TCNMProvince',
    //     Key:'FTPvnCode'
	// },
	GrideView:{
		ColumnPathLang	: 'address/province/province',
		ColumnKeyLang	: ['tPVNCode','tPVNName'],
		ColumnsSize     : ['15%','75%'],
        WidthModal      : 50,
		DataColumns		: ['TCNMProvince.FTPvnCode','TCNMProvince_L.FTPvnName'],
		DataColumnsFormat : ['',''],
		Perpage			: 5,
		OrderBy			: ['TCNMProvince.FTPvnCode'],
		SourceOrder		: "ASC"
	},
	CallBack:{
		ReturnType	: 'S',
		Value		: ["oetAddPvnCode","TCNMProvince.FTPvnCode"],
		Text		: ["oetAddPvnName","TCNMProvince_L.FTPvnName"],
	},
	NextFunc:{
		FuncName:'JSxChekDisableAddress',
		ArgReturn:['FTPvnCode',]
    },
	RouteAddNew : 'province',
	// BrowseLev : nStaBchBrowseType
}

//อำเภอ
var oSplBrowseDistrict = {
	Title : ['address/district/district','tDSTTitle'],
	Table:{Master:'TCNMDistrict',PK:'FTDstCode'},
	Join :{
		Table:	['TCNMDistrict_L'],
		On:['TCNMDistrict_L.FTDstCode = TCNMDistrict.FTDstCode AND TCNMDistrict_L.FNLngID = '+nLangEdits,]
	},
	Filter:{
		Selector:'oetAddV1PvnCode',
		Table:'TCNMDistrict',
        Key:'FTPvnCode'
	},
	GrideView:{
		ColumnPathLang	: 'address/district/district',
		ColumnKeyLang	: ['tDSTTBCode','tDSTTBName'],
		ColumnsSize     : ['15%','75%'],
        WidthModal      : 50,
		DataColumns		: ['TCNMDistrict.FTDstCode','TCNMDistrict_L.FTDstName'],
		DataColumnsFormat : ['',''],
		Perpage			: 5,
		OrderBy			: ['TCNMDistrict.FTDstCode'],
		SourceOrder		: "ASC"
	},
	CallBack:{
		ReturnType	: 'S',
		Value		: ["oetAddDstCode","TCNMDistrict.FTDstCode"],
		Text		: ["oetAddDstName","TCNMDistrict_L.FTDstName"],
	},
	NextFunc:{
		FuncName:'JSxChekDisableAddress',
		ArgReturn:['FTDstCode',]
    },
	RouteAddNew : 'district',
	// BrowseLev : nStaBchBrowseType
}

//ตำบล
var oSplBrowseSubDistrict = {
	Title : ['address/subdistrict/subdistrict','tSDTTitle'],
	Table:{Master:'TCNMSubDistrict',PK:'FTSudCode'},
	Join :{
		Table:	['TCNMSubDistrict_L'],
		On:['TCNMSubDistrict_L.FTSudCode = TCNMSubDistrict.FTSudCode AND TCNMSubDistrict_L.FNLngID = '+nLangEdits,]
	},
	Filter:{
		Selector:'oetAddV1DstCode',
		Table:'TCNMSubDistrict',
        Key:'FTDstCode'
	},
	GrideView:{
		ColumnPathLang	: 'address/subdistrict/subdistrict',
		ColumnKeyLang	: ['tSDTTBCode','tSDTTBSubdistrict'],
		ColumnsSize     : ['15%','75%'],
        WidthModal      : 50,
		DataColumns		: ['TCNMSubDistrict.FTSudCode','TCNMSubDistrict_L.FTSudName'],
		DataColumnsFormat : ['',''],
		Perpage			: 5,
		OrderBy			: ['TCNMSubDistrict.FTSudCode'],
		SourceOrder		: "ASC"
	},
	CallBack:{
		ReturnType	: 'S',
		Value		: ["oetAddSubDistCode","TCNMSubDistrict.FTSudCode"],
		Text		: ["oetAddSubDistName","TCNMSubDistrict_L.FTSudName"],
	},
	NextFunc:{
		FuncName:'JSxChekDisableAddress',
		ArgReturn:['FTSudCode',]
    },
	RouteAddNew : 'subdistrict',
	// BrowseLev : nStaBchBrowseType
}

function JSxChekDisableAddress(){
		// tAreCode  = $('#oetBchAreCode').val();
        tZneCode  = $('#oetSplZneCode').val();
        tPvnCode  = $('#oetAddPvnCode').val();
		tDstCode  = $('#oetAddDstCode').val();

		// obtBchBrowseDistrict
        // if(tAreCode == '' || tAreCode == null){
		// 	$('#obtBchBrowseZone').prop('disabled',true);
        // }else{
		// 	$('#obtBchBrowseZone').prop('disabled',false);
		// }
		
        // if(tZneCode == '' || tZneCode == null){
        //     $('#obtSplBrowseProvince').prop('disabled',true);
        // }else{
        //     $('#obtSplBrowseProvince').prop('disabled',false);
		// }
		
        if(tPvnCode == '' || tPvnCode == null){
            $('#obtSplBrowseDistrict').prop('disabled',true);
        }else{
            $('#obtSplBrowseDistrict').prop('disabled',false);
		}
		
        if(tDstCode == '' || tDstCode == null){
            $('#obtSplBrowseSubDistrict').prop('disabled',true);
        }else{
            $('#obtSplBrowseSubDistrict').prop('disabled',false);
        }
        
}
function JSxResetVal(ptInputID,ptVal,pnSta){
	if(typeof ptVal !== "undefined" && ptVal != "") {
	tInputID = $('#'+ptInputID).val();
		if(tInputID != ptVal && pnSta == 1){
			$('#oetSplZneCode').val('');
			$('#oetAddPvnCode').val('');
			$('#oetAddDstCode').val('');
			$('#oetAddSubDistCode').val('');
			
			$('#oetSplZneName').val('');
			$('#oetAddPvnName').val('');
			$('#oetAddDstName').val('');
			$('#oetAddSubDistName').val('');
		}
		if(tInputID != ptVal && pnSta == 2){
			$('#oetAddPvnCode').val('');
			$('#oetAddDstCode').val('');
			$('#oetAddSubDistCode').val('');
			
			$('#oetAddPvnName').val('');
			$('#oetAddDstName').val('');
			$('#oetAddSubDistName').val('');
		}
		if(tInputID != ptVal && pnSta == 3){
			$('#oetAddDstCode').val('');
			$('#oetAddSubDistCode').val('');

			$('#oetAddDstName').val('');
			$('#oetAddSubDistName').val('');
		}
		if(tInputID != ptVal && pnSta == 4){
			$('#oetAddSubDistCode').val('');
			
			$('#oetAddSubDistName').val('');
		}
	}
}
$('#obtSplBrowseZone').click(function(){JCNxBrowseData('oSplBrowseZone');});
$('#obtSplBrowseProvince').click(function(){JCNxBrowseData('oSplBrowseProvince');});
$('#obtSplBrowseDistrict').click(function(){JCNxBrowseData('oSplBrowseDistrict');});
$('#obtSplBrowseSubDistrict').click(function(){JCNxBrowseData('oSplBrowseSubDistrict');});


</script>
<script src="<?= base_url('application/modules/common/assets/js/jquery.mask.js')?>"></script>
<script src="<?= base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>