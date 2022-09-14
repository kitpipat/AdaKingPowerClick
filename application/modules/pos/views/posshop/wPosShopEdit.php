<form class="contact100-form validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" id="ofmEditPosShop">
    <button style="display:none" type="submit" id="obtSubmitEditPsh" onclick="JSoEditPosShop()"></button>
    <div class="panel panel-headline">
        <div class="panel-body" style="padding-top:20px !important;">
            <div class="row">
                <div class="col-xs-12 col-md-5 col-lg-5">
                    
                    <div class="form-group">
                        <div class="input-group">
                            <input name="oetBchCode" id="oetBchCode" class="form-control xCNHide" value="<?=$aPshData['raItems']['FTBchCode']?>">
                            <input name="oetShpCode" id="oetShpCode" class="form-control xCNHide" value="<?=$aPshData['raItems']['FTShpCode']?>" data-validate="<?= language('product/pdtsize/pdtsize','tPSZValidCode')?>">
                            <input name="oetShpName" id="oetShpName" class="form-control xWPointerEventNone xWRptConsCrdInput"  type="text" readonly="" value="<?=$aPshData['raItems']['FTShpName']?>" placeholder="<?= language('pos/posshop/posshop','tPshPHShop')?>">
                            <span class="input-group-btn">
                                <button class="btn xCNBtnBrowseAddOn" id="btnBrowseShop" type="button">
                                    <img src="<?php echo  base_url().'/application/modules/common/assets/images/icons/find-24.png'?>">
                                </button>
                            </span>
                        </div>
                    </div>

                    
                    <div class="form-group">
                        <div class="input-group">
                            <input name="oetPosCode" id="oetPosCode" class="form-control xCNHide" value="<?=$aPshData['raItems']['FTPosCode']?>">
                            <input name="oetPosName" id="oetPosName" class="form-control xWPointerEventNone xWRptConsCrdInput"  type="text" readonly="" value="<?=$aPshData['raItems']['FTPosCode']?>" placeholder="<?= language('pos/posshop/posshop','tPshPHPOS')?>">
                            <span class="input-group-btn">
                                <button class="btn xCNBtnBrowseAddOn" id="btnBrowsePos" type="button">
                                    <img src="<?php echo  base_url().'/application/modules/common/assets/images/icons/find-24.png'?>">
                                </button>
                            </span>
                        </div>
                    </div>
                

                
                    <div class="form-group">
                        <input name="oetPshPosSN" id="oetPshPosSN" type="text" value="<?=$aPshData['raItems']['FTPshPosSN']?>" placeholder="<?= language('pos/posshop/posshop','tPshTBSN')?>">
                    </div>
                

                    
                    <div class="form-group">
                        <select class="selectpicker form-control" id="ocmPshStaUse" name="ocmPshStaUse" maxlength="1">
                            <option value="1" <?php if(intval($aPshData['raItems']['FTPshStaUse'])==1){ echo "selected"; }?>><?=language('pos/posshop/posshop','tPshStaActive')?></option>
                            <option value="2" <?php if(intval($aPshData['raItems']['FTPshStaUse'])==2){ echo "selected"; }?>><?=language('pos/posshop/posshop','tPshStaNotActive')?></option>
                        </select>
                    </div>
                    

                </div>
            </div>
        </div>
    </div>
</form>
<script src="<?= base_url('application/modules/common/assets/js/jquery.mask.js')?>"></script>
<script src="<?= base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>
<script type="text/javascript">
    $('.selectpicker').selectpicker();
</script>