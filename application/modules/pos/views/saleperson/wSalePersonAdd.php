<?php
if($aResult['rtCode'] == "1"){
    $tSpnCode       = $aResult['raItems']['rtSpnCode'];
    $tSpnName       = $aResult['raItems']['rtSpnName'];
    $tSpnRmk        = $aResult['raItems']['rtSpnRmk'];
    $tSpnTel        = $aResult['raItems']['rtSpnTel'];
    $tSpnEmail      = $aResult['raItems']['rtSpnEmail'];
    $tBchCode       = $aResult['raItems']['rtBchCode'];
    $tShpCode       = $aResult['raItems']['rtShpCode'];
    $tBchName       = $aResult['raItems']['rtBchName'];
    $tShpName       = $aResult['raItems']['rtShpName'];
    $tRoute         = "salepersonEventEdit";
}else{
    $tSpnCode       = "";
    $tSpnName       = "";
    $tSpnRmk        = "";
    $tSpnTel        = "";
    $tSpnEmail      = "";
    $tBchCode       = $this->session->userdata("tSesUsrBchCodeDefault");
    $tShpCode       = $this->session->userdata("tSesUsrShpCodeDefault");
    $tBchName       = $this->session->userdata("tSesUsrBchNameDefault");
    $tShpName       = $this->session->userdata("tSesUsrShpNameDefault");
    $tRoute         = "salepersonEventAdd";
}
?>
<style>
    .xCNCenter {
        margin-left: auto;
        margin-right: auto;
    }
</style>
<div class="panel panel-headline">
    <div class="panel-body">
        <form class="contact100-form validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" autocorrect="off" autocapitalize="off" autocomplete="off" id="ofmAddSalePerson">
            <button style="display:none" type="submit" id="obtSubmitSalePerson" onclick="JSnAddEditSalePerson('<?= $tRoute?>')"></button>
            
            <div class="row">
                <div class="col-xl-4 col-lg-4 col-md-4">
                    <div class="form-group">
                        <div id="odvSpnImg">
                            <?php
                                if(isset($tImgObjAll) && !empty($tImgObjAll)){
                                    $tFullPatch = './application/modules/'.$tImgObjAll;                        
                                    if (file_exists($tFullPatch)){
                                        $tPatchImg = base_url().'/application/modules/'.$tImgObjAll;
                                    }else{
                                        $tPatchImg = base_url().'application/modules/common/assets/images/300x60.png';
                                    }
                                }else{
                                    $tPatchImg = base_url().'application/modules/common/assets/images/300x60.png';
                                }
                            ?>
                            <img id="oimImgMasterSalePerson" class="img-responsive xCNImgCenter" src="<?php echo @$tPatchImg;?>">
                        </div>
                        <div class="form-group">
                            <div class="xCNUplodeImage">
                                <input type="text" class="xCNHide" id="oetImgInputSalePerson"       name="oetImgInputSalePerson"    value="<?php echo @$tImgName;?>">
                                <input type="text" class="xCNHide" id="oetImgInputSalePersonOld"    name="oetImgInputSalePersonOld" value="<?php echo @$tImgName;?>">
                                <button type="button" class="btn xCNBTNDefult" onclick="JSvImageCallTempNEW('','','SalePerson')">
                                    <i class="fa fa-picture-o xCNImgButton"></i> <?php echo language('common/main/main','tSelectPic')?>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-8 col-lg-8 col-md-8">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xl-12 col-lg-12">
                                <label class="xCNLabelFrm"><span style="color:red">*</span><?php echo language('pos/saleperson/saleperson','tSPNCode')?></label>
                                <div class="form-group" id="odvSalePersonAutoGenCode">
                                    <div class="validate-input">
                                        <label class="fancy-checkbox">
                                            <input type="checkbox" id="ocbSalePersonAutoGenCode" name="ocbSalePersonAutoGenCode" checked="true" value="1">
                                            <span> <?php echo language('common/main/main', 'tGenerateAuto'); ?></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group" id="odvSalePersonCodeForm">
                                    <input type="hidden" id="ohdCheckDuplicateSpnCode" name="ohdCheckDuplicateSpnCode" value="1"> 
                                    <div class="validate-input">
                                        <input 
                                            type="text" 
                                            class="form-control xCNInputWithoutSpcNotThai" 
                                            maxlength="5" 
                                            id="oetSpnCode" 
                                            name="oetSpnCode"
                                            data-is-created="<?php echo $tSpnCode; ?>"
                                            placeholder="<?php echo language('pos/saleperson/saleperson','tSPNCode')?>"
                                            value="<?php echo $tSpnCode; ?>" 
                                            data-validate-required = "<?php echo language('pos/saleperson/saleperson','tSPNValidateCode');?>"
                                            data-validate-dublicateCode ="<?php echo language('pos/saleperson/saleperson','tSPNValidateCodeDup')?>"
                                        >
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-12 col-lg-12">
                                <div class="form-group">   
                                        <label class="xCNLabelFrm"><span style="color:red">*</span><?= language('pos/saleperson/saleperson','tSPNName')?></label>
                                        <input type="text" class="form-control" maxlength="100" id="oetSpnName" name="oetSpnName" value="<?= $tSpnName ?>"
                                        data-validate-required="<?php echo language('pos/saleperson/saleperson','tSPNNameValidate');?>"> <!--xCNInputWithoutSpc-->
                                </div>

                                <div class="form-group">
                                        <label class="xCNLabelFrm"><span style="color:red">*</span><?= language('pos/saleperson/saleperson','tSPNEmail')?></label>
                                        <input type="email" class="form-control" maxlength="100" id="oetSpnEmail" name="oetSpnEmail" value="<?=$tSpnEmail?>"
                                        data-validate-required="<?php echo language('pos/saleperson/saleperson','tSPNEmailValidate');?>"> <!-- xCNInputWithoutSpcNotThai -->
                                </div>
                                <div class="form-group">
                                    <div class="validate-input" data-validate="Please Insert Tel">
                                        <label class="xCNLabelFrm"><?= language('pos/saleperson/saleperson','tSPNTel')?></label>
                                        <input type="text" class="input100 xCNInputWithoutSpc" maxlength="100" id="oetSpnTel" name="oetSpnTel" value="<?= $tSpnTel ?>">
                                    </div>
                                </div>
                                <?php
                                $tSelected = '';
                                if($tBchCode != "" && $tShpCode != ""){
                                    $tSelected = 'selected="true"';
                                }
                                ?>
                                <div class="form-group">
                                    <div class="validate-input" data-validate="Please Insert Level">
                                        <label class="xCNLabelFrm"><?php echo language('pos/saleperson/saleperson', 'tSPNLelvel'); ?></label>
                                        <select class="selectpicker form-control xCNSelectBox" id="oetSpnLevel" name="oetSpnLevel" onchange="JSxVisibledRefMode(this, event)">
                                            <option value="1"><?php echo language('pos/saleperson/saleperson', 'tSPNBranceLevel'); ?></option>
                                            <option value="2" <?php echo $tSelected; ?>><?php echo language('pos/saleperson/saleperson', 'tSPNShopLevel'); ?></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group" id="xWBranchMode">
                                    <div class="validate-input" data-validate="Please Enter">
                                        <label class="xCNLabelFrm"><?= language('pos/saleperson/saleperson','tSPNRef')?></label>
                                        <input type="text" class="form-control xCNHide" id="oetBchCode" name="oetBchCode" maxlength="5" value="<?= $tBchCode ?>">
                                        <input class="input100 xWPointerEventNone" type="text" id="oetBchName" name="oetBchName" placeholder="###" value="<?= $tBchName ?>" readonly>
                                        <img id="oimSpnBrowseBranch" class="xCNIconBrowse" src="<?= base_url().'/application/modules/common/assets/images/icons/find-24.png'?>">
                                    </div>
                                </div>
                                <div class="form-group" id="xWShopMode">
                                    <div class="validate-input" data-validate="Please Enter">
                                        <label class="xCNLabelFrm"><?= language('pos/saleperson/saleperson','tSPNRef')?></label>
                                        <input type="text" class="form-control xCNHide" id="oetShpCode" name="oetShpCode" maxlength="5" value="<?= $tShpCode ?>">
                                        <input class="input100 xWPointerEventNone" type="text" id="oetShpName" name="oetShpName" placeholder="###" value="<?= $tShpName ?>" readonly>
                                        <img id="oimSpnBrowseShop" class="xCNIconBrowse" src="<?= base_url().'/application/modules/common/assets/images/icons/find-24.png'?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="validate-input">
                                                <label class="xCNLabelFrm"><?php echo language('pos/saleperson/saleperson','tSPNRemark');?></label>
                                                <textarea maxlength="100" rows="4" id="otaSpnRemark" name="otaSpnRemark"><?= $tSpnRmk ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </form>
    </div>
</div>
<script src="<?= base_url('application/modules/common/assets/js/jquery.mask.js')?>"></script>
<script src="<?= base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>
<?php include "script/jSalePersonAdd.php"; ?>