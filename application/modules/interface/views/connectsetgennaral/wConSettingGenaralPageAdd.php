<?php
    // ตรวจสอบโหมดการทำงานว่าเป็น โหมดเพิ่มใหม่ หรือแก้ไข
    if($aResultApi['rtCode'] == 1){
        $tAgnCode     = $aResultApi['raItems']['FTAgnCode'];
        $tAgnName     = $aResultApi['raItems']['FTAgnName'];
        $tBchCode     = $aResultApi['raItems']['FTBchCode'];
        $tBchName     = $aResultApi['raItems']['FTBchName'];
        $tApiFmtCode  = $aResultApi['raItems']['FTApiFmtCode'];
        $tApiFmtName  = $aResultApi['raItems']['FTApiFmtName'];
        $tSpaUsrName  = $aResultApi['raItems']['FTSpaUsrCode'];
        $tSpaUsrPwd   = $aResultApi['raItems']['FTSpaUsrPwd'];
        $tSpaApiKey   = $aResultApi['raItems']['FTSpaApiKey'];
        $tSpaRmk      = $aResultApi['raItems']['FTSpaRmk'];
        $tApiUrlDt    = $aResultApi['raItems']['FTApiURL'];
        
        $tRoute     = "ConnSetGenaralEventAuthorEdit"; 
    }else{

        $tAgnCode     = "";
        $tAgnName     = "";
        $tApiFmtCode  = "";
        $tApiFmtName  = "";
        $tBchCode     = $tBchCompCode;
        $tBchName     = $tBchCompName;
        $tSpaUsrName  = "";
        $tSpaUsrPwd   = "";
        $tSpaApiKey   = "";
        $tSpaRmk      = "";
        $tApiUrlDt    = $tApiUrl;

        $tRoute       = "ConnSetGenaralEventAuthorAdd";
    }
    
    
?>
<form id="ofmAddEditSetGenaral1" class="validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data">
    <input type="hidden" value="<?php echo $tRoute; ?>" id="ohdTRoute">
    <div class="row">
        <div class="col-xs-12 col-md-12 col-lg-12 text-right">
            <button type="button" onclick="JSvCallPageSetEdit('<?=@$tAPIApiSeq;?>', '<?=@$tAPIApiCode;?>');" id="obtConnSetGenaralCancel" class="btn xCNBTNDefult xCNBTNDefult2Btn" style="margin-left: 5px;">
                <?php echo language('common/main/main', 'tCancel')?>
            </button>
            <button type="submit" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" style="margin-left: 5px;" id="obtConnSetGenaralSave" onclick="JSxSaveAddEdit2('<?=$tRoute;?>')"> 
                <?php echo  language('common/main/main', 'tSave')?>
            </button>
        </div>	
    </div>
    <div class="col-lg-12 col-md-12 col-xs-12">
        <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5">
            <?php
                $tBchConSetGenaral       = "";
                $tBchNameConSetGenaral   = "";
                if($tRoute == "ConnSetGenaralEventAuthorAdd"){
                    // echo 'Add';
                    $tBchConSetGenaral      =  $tBchCompCode;
                    $tBchNameConSetGenaral  =  $tBchCompName; 
                    $tDisabled          = '';
                    $tNameElmIDAgn      = 'oimBrowseAgn';
                    $tNameElmIDBch      = 'oimBrowseBch';
                }else{
                    // echo 'Edit';
                    $tBchConSetGenaral      =  $tBchCode;
                    $tBchNameConSetGenaral  =  $tBchName;
                    $tDisabled      = 'disabled';
                    $tNameElmIDBch  = '';
                    $tNameElmIDAgn  = '';
                }
            ?>
            <!-- Browser Agency -->
            <div class="form-group">
                <label class="xCNLabelFrm"><span style="color:red">*</span><?php echo language('interface/connectionsetting/connectionsetting','tTBAgency')?></label>
                        <div class="input-group"><input type="text" class="form-control xCNHide" id="oetSetAgnCode" name="oetSetAgnCode" maxlength="5" value="<?=@$tAgnCode;?>">
                        <input  type="text" class="form-control xWPointerEventNone" id="oetSetAgnName" name="oetSetAgnName"
                            maxlength="100" placeholder="<?php echo language('interface/connectionsetting/connectionsetting','tTBAgency')?>" value="<?=@$tAgnName;?>"
                            data-validate-required = "<?php echo language('interface/connectionsetting/connectionsetting','tValiAgency')?>" 
                            readonly>
                        <span class="input-group-btn">
                        <button id="<?=@$tNameElmIDAgn;?>" type="button" class="btn xCNBtnBrowseAddOn <?=@$tDisabled?>">
                            <img src="<?php echo  base_url().'/application/modules/common/assets/images/icons/find-24.png'?>">
                        </button>
                    </span>
                </div>
            </div>

            <!-- Browser Branch -->
            <div class="form-group">
                <label class="xCNLabelFrm"><span style="color:red">*</span><?php echo language('company/branch/branch','tBCHTitle')?></label>
                <div class="input-group">
                    <input type="text" class="form-control xCNHide xCNInputWithoutSpcNotThai xCNInputWithoutSingleQuote" 
                        id="oetSetBchCode" 
                        name="oetSetBchCode" 
                        maxlength="5" 
                        value="<?=@$tBchConSetGenaral;?>">
                    <input type="text" class="form-control xWPointerEventNone" 
                        id="oetSetBchName" 
                        name="oetSetBchName" 
                        maxlength="100"
                        placeholder="<?php echo language('interface/connectionsetting/connectionsetting','tTBBanch')?>" value="<?=@$tBchNameConSetGenaral;?>"
                        data-validate-required = "<?php echo language('interface/connectionsetting/connectionsetting','tValiBanch')?>" 
                        readonly
                    >
                    <span class="input-group-btn">
                        <button id="<?=@$tNameElmIDBch;?>" type="button" class="btn xCNBtnBrowseAddOn <?=@$tDisabled?>">
                            <img src="<?php echo  base_url().'/application/modules/common/assets/images/icons/find-24.png'?>">
                        </button>
                    </span>
                </div>
            </div>

            <!-- API URL -->
            <div class="form-group">
            <label class="xCNLabelFrm"><?php echo language('interface/connectionsetting/connectionsetting', 'tAPIURL');?></label>
                <input 
                    class="form-control" 
                    type="text" 
                    id="oetApiUrl" 
                    name="oetApiUrl" 
                    value="<?=$tApiUrlDt;?>"
                    >
            </div>

            <!-- Browser ApiFMT -->
            <div class="form-group">
                <label class="xCNLabelFrm"><span style="color:red">*</span><?php echo language('interface/conSettingGenaral/conSettingGenaral','tGenaralApiFormat')?></label>
                        <div class="input-group"><input type="text" class="form-control xCNHide" id="oetfmtCode" name="oetfmtCode" maxlength="5" value="<?=@$tApiFmtCode;?>">
                        <input  type="text" class="form-control xWPointerEventNone" id="oetfmtName" name="oetfmtName"
                            maxlength="100" placeholder="<?php echo language('interface/conSettingGenaral/conSettingGenaral','tGenaralApiFormat')?>" value="<?=@$tApiFmtName;?>"
                            data-validate-required = "<?php echo language('interface/conSettingGenaral/conSettingGenaral','tApiFormatValidate')?>" 
                            readonly>
                        <span class="input-group-btn">
                        <button id="oimBrowseApiFmt" type="button" class="btn xCNBtnBrowseAddOn ">
                            <img src="<?php echo  base_url().'/application/modules/common/assets/images/icons/find-24.png'?>">
                        </button>
                    </span>
                </div>
            </div>


            <!-- API UsrName -->
            <div class="form-group">
            <label class="xCNLabelFrm"><?php echo language('interface/connectionsetting/connectionsetting', 'tAPIUSR');?></label>
                <input 
                    class="form-control" 
                    type="text" 
                    id="oetApiUsrName" 
                    name="oetApiUsrName" 
                    value="<?=$tSpaUsrName;?>">
            </div>


            <!-- API Password -->
            <div class="form-group">
            <label class="xCNLabelFrm"><?php echo language('interface/connectionsetting/connectionsetting', 'tAPIPw');?></label>
                <input 
                    class="form-control" 
                    type="password" 
                    id="oetApiPassword" 
                    name="oetApiPassword" 
                    data-oldpws="<?=$tSpaUsrPwd;?>"
                    value="<?=$tSpaUsrPwd;?>">
            </div>

            <!-- API Key -->
            <div class="form-group">
            <label class="xCNLabelFrm"><?php echo language('interface/connectionsetting/connectionsetting', 'tAPIKey');?></label>
                <input 
                    class="form-control" 
                    type="text" 
                    id="oetApiKey" 
                    name="oetApiKey" 
                    value="<?=$tSpaApiKey;?>">
            </div>

            <!-- หมายเหตุ -->
            <div class="form-group">
                <div class="validate-input">
                    <label class="xCNLabelFrm"><?php echo language('interface/connectionsetting/connectionsetting', 'tRemark')?></label>
                    <textarea class="form-control" maxlength="100" rows="4" id="otaApiRemark" name="otaApiRemark"><?php echo $tSpaRmk; ?></textarea>
                </div>
            </div>
        </div>
    </div>

    
    <?php
        $tCmpCode   =   $aResComp['raItems']['rtCmpCode'];
    ?>

    <input type="hidden" id="oetCmpCode" name="oetCmpCode" value="<?=$tCmpCode;?>">
    <input type="hidden" id="oetApiCode" name="oetApiCode" value="<?=$tAPIApiCode;?>">
    <input type="hidden" id="oetApiSeq"  name="oetApiSeq" value="<?=$tAPIApiSeq;?>">
    <input type="hidden" id="oetApiUrlTemp"  name="oetApiUrlTemp" value="<?=$tApiUrlDt;?>">
    <input type="hidden" id="oetfmtCodeTemp"   name="oetfmtCodeTemp" value ="<?=$tApiFmtCode;?>">  

</form>
<?php include "script/jConnectionSetApiAuthor.php"; ?>
<script src="<?php echo base_url('application/modules/common/assets/js/jquery.mask.js')?>"></script>
<script src="<?php echo base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>
