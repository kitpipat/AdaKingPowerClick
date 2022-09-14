<?php

if($aResult['tCode'] == "1"){
    // Master Info
    $tCryCode           = $aResult['aItems']['FTCryCode'];
    $tCryName           = $aResult['aItems']['FTCryName'];
    $tCryNameOth        = $aResult['aItems']['FTCryNameOth'];
    $dCryDob            = $aResult['aItems']['FDCryDob'];
    $tCryBusiness       = $aResult['aItems']['FTCryBusiness'];
    $tCryBchHQ          = $aResult['aItems']['FTCryBchHQ'];
    $tCryBchCode        = $aResult['aItems']['FTCryBchCode'];
    $tCrySex            = $aResult['aItems']['FTCrySex'];
    $tCryCtyCode        = $aResult['aItems']['FTCtyCode'];
    $tCryCtyName        = $aResult['aItems']['FTCtyName'];
    $tCryCgpCode        = $aResult['aItems']['FTCgpCode'];
    $tCryCgpName        = $aResult['aItems']['FTCgpName'];
    $tCryCardID         = $aResult['aItems']['FTCryCardID'];
    $tCryTaxNo          = $aResult['aItems']['FTCryTaxNo'];
    $tCryTel            = $aResult['aItems']['FTCryTel'];
    $tCryFax            = $aResult['aItems']['FTCryFax'];
    $tCryEmail          = $aResult['aItems']['FTCryEmail'];
    $tCryLoginType      = $aResult['aItems']['FTCryLoginType'];
    $tCryDelimeterQR    = $aResult['aItems']['FTCryDelimeterQR'];
    $tCryRmk            = $aResult['aItems']['FTCryRmk'];
    $tCryStaActive      = $aResult['aItems']['FTCryStaActive'];
    $tCryCrTerm         = $aResult['aItems']['FNCryCrTerm'];
    $tCryCrLimit        = $aResult['aItems']['FCCryCrLimit'];
    $tDisabledTab       = 'tab';
    $tMenuTabDisable 	= "";
    // Route
    $tRoute = "courierEventEdit";
}else{
    // Master Info
    $tCryCode           = "";
    $tCryName           = "";
    $tCryNameOth        = "";
    $dCryDob            = "";
    $tCryBusiness       = "";
    $tCryBchHQ          = "";
    $tCryBchCode        = "";
    $tCrySex            = "";
    $tCryCtyCode        = "";
    $tCryCtyName        = "";
    $tCryCgpCode        = "";
    $tCryCgpName        = "";
    $tCryCardID         = "";
    $tCryTaxNo          = "";
    $tCryTel            = "";
    $tCryFax            = "";
    $tCryEmail          = "";
    $tCryLoginType      = "";
    $tCryDelimeterQR    = "";
    $tCryRmk            = "";
    $tCryStaActive      = "1";
    $tCryCrTerm         = "";
    $tCryCrLimit        = "";
    $tDisabledTab       = 'false';
    $tMenuTabDisable 	= " disabled xCNCloseTabNav";
    // Route
    $tRoute = "courierEventAdd";
}
?>
<div id="odvCourierPanelBody" class="panel-body">
    <div class="row">
        <div class=">col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="custom-tabs-line tabs-line-bottom left-aligned">
                <ul class="nav" role="tablist">
                    <li id="oliCourierInfo" class="xCNCryTab active" data-typetab="main" data-tabtitle="cryinfo">
                        <a role="tab" data-toggle="tab" data-target="#odvCryInfo" aria-expanded="true"><?php echo language('courier/courier/courier','tCRYTABInfo')?></a>
                    </li>
                    <li id="oliCourierAddress" class="xCNCryTab<?php echo $tMenuTabDisable;?>" data-typetab="sub" data-tabtitle="cryaddress"> 
                        <a role="tab" data-toggle="<?php echo $tDisabledTab;?>" data-target="#odvCRYAddressData" aria-expanded="false"><?php echo language('courier/courier/courier','tCRYTABAddress')?></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="tab-content">
            <div id="odvCryInfo" class="tab-pane fade active in">
                <form class="contact100-form validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" id="ofmCourierAdd">
                    <button style="display:none" type="submit" id="obtCrySubmit" onclick="JSoEventCourierAddEdit('<?php echo $tRoute?>')"></button>
                    <div class="col-xl-12 col-lg-4 col-md-4" id="odvCstMasterImgContainer">
                        <?php echo FCNtHGetContentUploadImage(@$tImgObjAll,'Courier');?>
                    </div>
                    <div class="col-xl-12 col-lg-6 col-md-6" id="odvContentContainer">
                        
                        <div class="form-group xWAutoGenerate">
                            <label class="fancy-checkbox">
                                <input type="checkbox" id="ocbCryStaAutoGenCode" name="ocbCryStaAutoGenCode" maxlength="1" checked>
                                <span class="xCNLabelFrm"><?php echo language('courier/courier/courier', 'tCRYADDAutoGen'); ?></span>
                            </label>
                        </div>
                    
                        <div class="form-group">
                            <label class="xCNLabelFrm"><span class="text-danger">*</span> <?php echo language('courier/courier/courier','tCRYTBCode');?></label>
                            <input type="text" class="form-control xCNInputWithoutSpcNotThai xCNInputWithoutSingleQuote" id="oetCryCode" name="oetCryCode" maxlength="20" value="<?php echo $tCryCode?>"  data-validate="<?php echo language('courier/courier/courier', 'tCRYVrdCode'); ?>" placeholder="<?php echo language('courier/courier/courier','tCRYTBCode');?>">
                        </div>

                        <div class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('courier/courier/courier','tCRYADDBusiness');?></label>
                            <select class="selectpicker form-control" id="ocmCryBusiness" name="ocmCryBusiness" maxlength="1" onchange="JSxCourierControlSex(this.value)">
                                
                                <option value="1" <?php echo $tCryBusiness == "1" ? "selected" : "";?>><?php echo language('courier/courier/courier', 'tCRYTDBusiness1'); ?></option>
                                <option value="2" <?php echo $tCryBusiness == "2" ? "selected" : "";?>><?php echo language('courier/courier/courier', 'tCRYTDBusiness2'); ?></option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('courier/courier/courier','tCRYADDBchHQ');?></label>
                            <select class="selectpicker form-control" id="ocmCryBchHQ" name="ocmCryBchHQ" maxlength="1" onchange="JSxCourierControlBranch(this.value)">
                                
                                <option value="1" <?php echo $tCryBchHQ == "1" ? "selected" : "";?>><?php echo language('courier/courier/courier', 'tCRYADDBch1'); ?></option>
                                <option value="2" <?php echo $tCryBchHQ == "2" ? "selected" : "";?>><?php echo language('courier/courier/courier', 'tCRYADDBch2'); ?></option>
                            </select>
                        </div>

                        <div class="form-group xWCryBchControl xCNHide">
                            <label class="xCNLabelFrm"><?php echo language('courier/courier/courier','tCRYADDBch2');?></label>
                            <input type="text" class="form-control" id="oetCryBchCode" name="oetCryBchCode" maxlength="50" value="<?php echo $tCryBchCode?>">
                        </div>

                        <div class="form-group">
                            <label class="xCNLabelFrm"><span class="text-danger">*</span> <?php echo language('courier/courier/courier','tCRYTBName');?></label>
                            <input type="text" class="form-control" id="oetCryName" name="oetCryName" maxlength="200" value="<?php echo $tCryName?>"  data-validate="<?php echo language('courier/courier/courier', 'tCRYVrdName'); ?>" placeholder="<?php echo language('courier/courier/courier','tCRYTBName');?>">
                        </div>

                        <div class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('courier/courier/courier','tCRYTBNameOth');?></label>
                            <input type="text" class="form-control" id="oetCryNameOth" name="oetCryNameOth" maxlength="200" 
                            placeholder="<?php echo language('courier/courier/courier','tCRYTBNameOth');?>"
                            value="<?php echo $tCryNameOth?>">
                        </div>

                        <div class="form-group xWCrySexControl xCNHide">
                            <label class="radio-inline">
                                <input type="radio" name="oetCrySex" id="oetCrySex1" value="1" <?php if($tCrySex=='1'){ echo 'checked'; } ?>> <label for="oetCrySex1" style="cursor: pointer;" class="xCNLabelFrm"><?php echo language('courier/courier/courier','tCRYADDSex1');?></label>
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="oetCrySex" id="oetCrySex2" value="2" <?php if($tCrySex=='2'){ echo 'checked'; } ?>> <label for="oetCrySex2" style="cursor: pointer;" class="xCNLabelFrm"><?php echo language('courier/courier/courier','tCRYADDSex2');?></label>
                            </label>
                        </div>

                        <div class="form-group xWCryDobControl xCNHide">
                            <label class="xCNLabelFrm"><?php echo language('courier/courier/courier', 'tCRYADDDob'); ?></label>
                            <div class="input-group">
                                <input type="text" class="form-control xCNDatePicker xCNInputMaskDate" id="oetCryDob" name="oetCryDob" autocomplete="off" value="<?php echo $dCryDob; ?>">
                                <span class="input-group-btn">
                                    <button id="obtCryDob" type="button" class="btn xCNBtnDateTime">
                                        <img src="<?php echo base_url().'/application/modules/common/assets/images/icons/icons8-Calendar-100.png'?>">
                                    </button>
                                </span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('courier/courier/courier','tCRYGroupTitle');?></label>
                            <div class="input-group">
                                <input name="oetCryCgpCode" id="oetCryCgpCode" class="form-control xCNHide" value="<?php echo $tCryCgpCode?>">
                                <input name="oetCryCgpName" id="oetCryCgpName" class="form-control xWPointerEventNone xWRptConsCrdInput"  type="text" readonly="" value="<?php echo $tCryCgpName?>">
                                <span class="input-group-btn">
                                    <button class="btn xCNBtnBrowseAddOn" id="btnBrowseGroup" type="button">
                                        <img src="<?php echo base_url().'/application/modules/common/assets/images/icons/find-24.png'?>">
                                    </button>
                                </span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('courier/courier/courier','tCRYTypeTitle');?></label>
                            <div class="input-group">
                                <input name="oetCtyCode" id="oetCtyCode" class="form-control xCNHide" value="<?php echo $tCryCtyCode?>">
                                <input name="oetCtyName" id="oetCtyName" class="form-control xWPointerEventNone xWRptConsCrdInput"  type="text" readonly="" value="<?php echo $tCryCtyName?>">
                                <span class="input-group-btn">
                                    <button class="btn xCNBtnBrowseAddOn" id="btnBrowseType" type="button">
                                        <img src="<?php echo base_url().'/application/modules/common/assets/images/icons/find-24.png'?>">
                                    </button>
                                </span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="xCNLabelFrm"><span class="text-danger">*</span> <?php echo language('courier/courier/courier','tCryCardID');?></label>
                            <input type="text" class="form-control" id="oetCryCardID" name="oetCryCardID" maxlength="20" value="<?php echo $tCryCardID?>" data-validate="<?php echo language('courier/courier/courier', 'tCRYVrdCardID'); ?>"
                            placeholder="<?php echo language('courier/courier/courier','tCryCardID');?>"
                            autocomplete="off"
                            >
                        </div>

                        <div class="form-group">
                            <label class="xCNLabelFrm"><span class="text-danger">*</span> <?php echo language('courier/courier/courier','tCryTaxNo');?></label>
                            <input type="text" class="form-control xCNInputMaskTaxNo" id="oetCryTaxNo" name="oetCryTaxNo" maxlength="20" value="<?php echo $tCryTaxNo?>" data-validate="<?php echo language('courier/courier/courier', 'tCRYVrdTaxNo'); ?>"
                            placeholder="<?php echo language('courier/courier/courier','tCryTaxNo');?>"
                            autocomplete="off"
                            >
                        </div>

                        <div class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('courier/courier/courier','tCryTel');?></label>
                            <input type="text" class="form-control" id="oetCryTel" name="oetCryTel" maxlength="50" value="<?php echo $tCryTel?>"
                            placeholder="<?php echo language('courier/courier/courier','tCryTel');?>"
                            autocomplete="off"
                            >
                        </div>

                        <div class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('courier/courier/courier','tCryFax');?></label>
                            <input type="text" class="form-control" id="oetCryFax" name="oetCryFax" maxlength="50" value="<?php echo $tCryFax?>"
                            placeholder="<?php echo language('courier/courier/courier','tCryFax');?>"
                            autocomplete="off"
                            >
                        </div>

                        <div class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('courier/courier/courier','tCRYTBEmail');?></label>
                            <input type="text" class="form-control" id="oetCryEmail" name="oetCryEmail" maxlength="50" value="<?php echo $tCryEmail?>"
                            placeholder="<?php echo language('courier/courier/courier','tCRYTBEmail');?>"
                            autocomplete="off"
                            >
                        </div>

                        <div class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('courier/courier/courier','tCRYTBCrTerm');?></label>
                            <input type="text" class="form-control xCNInputNumericWithoutDecimal" id="oetCryCrTerm" name="oetCryCrTerm" maxlength="50" value="<?php echo $tCryCrTerm?>"
                            placeholder="<?php echo language('courier/courier/courier','tCRYTBCrTerm');?>"
                            autocomplete="off"
                            >
                        </div>

                        <div class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('courier/courier/courier','tCRYTBCrLimit');?></label>
                            <input type="text" class="form-control xCNInputNumericWithDecimal" id="oetCryCrLimit" name="oetCryCrLimit" maxlength="18" value="<?php echo $tCryCrLimit?>"
                            placeholder="<?php echo language('courier/courier/courier','tCRYTBCrLimit');?>"
                            autocomplete="off"
                            >
                        </div>

                        <div class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('courier/courier/courier','tCryLoginType');?></label>
                            <select class="selectpicker form-control" id="ocmCryLoginType" name="ocmCryLoginType" maxlength="1">
                                <option value="1" <?php echo $tCryLoginType == "1" ? "selected" : "";?>><?php echo language('courier/courier/courier', 'tCryLoginType1'); ?></option>
                                <option value="2" <?php echo $tCryLoginType == "2" ? "selected" : "";?>><?php echo language('courier/courier/courier', 'tCryLoginType2'); ?></option>
                                <option value="3" <?php echo $tCryLoginType == "3" ? "selected" : "";?>><?php echo language('courier/courier/courier', 'tCryLoginType3'); ?></option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('courier/courier/courier','tCRYDelimeterQR');?></label>
                            <input type="text" class="form-control" id="oetCryDelimeterQR" name="oetCryDelimeterQR" maxlength="3" value="<?php echo $tCryDelimeterQR?>"
                            placeholder="<?php echo language('courier/courier/courier','tCRYDelimeterQR');?>"
                            autocomplete="off"
                            >
                        </div>

                        <div class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('courier/courier/courier', 'tCryRmk'); ?></label>
                            <textarea class="form-control" maxlength="100" rows="4" id="otaCryRmk" name="otaCryRmk"><?php echo $tCryRmk?></textarea>
                        </div>

                        <div class="form-group">
                            <div class="checkbox">
                                <label class="xCNLabelFrm">
                                    <input type="checkbox" id="ocbCryStaActive" name="ocbCryStaActive" value="<?php echo $tCryStaActive?>" checked>
                                    <?php echo language('courier/courier/courier','tCryStaActive');?>
                                </label>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div id="odvCRYAddressData" class="tab-pane fade">
            </div>
        </div>
    </div>
</div>
<script src="<?php echo base_url('application/modules/common/assets/js/jquery.mask.js')?>"></script>
<script src="<?php echo base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>
<?php include "script/jCourierAdd.php";?>