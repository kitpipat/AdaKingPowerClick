<?php
if($tStatus ==  "pageadd"){
    $tBchCodeSend      = '';
    $tShpCode          = $tShpCode;
    $tShtType          = 1;
    $tShtName          = "";
    $tShtRemark        = "";
    $tShpName          = $aDataLockerType;
}else{
    $tBchCodeSend      = $aDataLockerType['FTBchCode'];
    $tShpCode          = $aDataLockerType['FTShpCode'];
    $tShtType          = $aDataLockerType['FTShtType'];
    $tShtName          = $aDataLockerType['FTShtName'];
    $tShtRemark        = $aDataLockerType['FTShtRemark'];
    $tShpName          = $aDataLockerType['FTShpName'];
}
?>


<div class="row">
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        <label class="xCNLabelFrm" style="color: #179bfd !important; cursor:pointer;" onclick="JSxGetSHPContentSmartLockerType();"><?=language('company/shop/shop','tNameTabSmartLockerLayout')?></label>
        <label class="xCNLabelFrm xWPageAdd" style="color: #aba9a9 !important;"> / 
            <?php if($tStatus == 'pageadd'){ ?>
                <?=language('company/smartlockerSize/smartlockerSize','tSMSSizeAdd')?> </p> 
            <?php }else{ ?>
                <?=language('common/main/main', 'tEdit')?> </p> 
            <?php } ?>
    </div>
	
   <!--ปุ่มเพิ่ม-->
   <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6  text-right">
        <button type="button" onclick="JSxGetSHPContentSmartLockerType();" class="btn" style="background-color: #D4D4D4; color: #000000;">
            <?=language('company/shopgpbypdt/shopgpbypdt', 'tSGPPBTNCancel')?>
        </button>
        <?php 
            if($tStatus == 'pageadd'){ ?>
                <button type="submit" class="btn" style="background-color: rgb(23, 155, 253); color: white;" onclick="JSvSmartLockertTypeEventAdd()"> 
                    <?=language('common/main/main', 'tSave')?>
                </button>
            <?php }else{ ?>
                <button type="submit" class="btn" style="background-color: rgb(23, 155, 253); color: white;" onclick="JSvSmartLockertTypeEventEdit('<?=$tBchCodeSend?>','<?=$tShpCode?>')"> 
                    <?=language('common/main/main', 'tSave')?>
                </button>
            <?php } ?>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><hr></div>

    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <form class="contact100-form validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" id="ofmAddSmartLockerType">            
            <input type="hidden" name="ohdSmartLockerTypeSHP" id="ohdSmartLockerTypeSHP"  value="<?=$tShpCode?>">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-4 col-md-4">
                            <?php $select1="";$select2="";$select3="";
                                if($tShtType==1){
                                    $select1="selected";
                                }
                                if($tShtType==2){
                                    $select2="selected";
                                }
                                if($tShtType==3){
                                    $select3="selected";
                                }                            
                            ?>

                        <!--สาขาที่มีผล-->
                        <?php $tSesUserLevel = $this->session->userdata("tSesUsrLevel"); ?>
                        <!-- <div class="row">
                            <div class="col-lg-12 col-md-12 col-xs-12">
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?=language('company/smartlockerlayout/smartlockerlayout','tSMLLayoutTableBch');?></label>
                                    <?php if($tNameBch == '' && $tSesUserLevel == 'HQ'){ ?>
                                        <div class="input-group">
                                            <input name="oetInputSmartLockerTypeBchName" id="oetInputSmartLockerTypeBchName" class="form-control xCNRemoveValue"  type="text" readonly="" placeholder="<?=language('company/shopgpbyshp/shopgpbyshp','tSMLLayoutTableBch')?>">
                                            <input name="oetInputSmartLockerTypeBchCode" id="oetInputSmartLockerTypeBchCode" class="form-control xCNHide xCNRemoveValue"  type="text" >
                                            <span class="input-group-btn">
                                                <button class="btn xCNBtnBrowseAddOn" id="obtSmartLockerTypeBrowseBranch" type="button">
                                                    <img src="<?=base_url().'/application/modules/common/assets/images/icons/find-24.png'?>">
                                                </button>
                                            </span>
                                        </div>
                                    <?php }else{ ?>
                                        <input type="text" class="form-control" disabled value="<?=$tNameBch['raItems']['FTBchName']?>">
                                        <input name="oetInputSmartLockerTypeBchCode" id="oetInputSmartLockerTypeBchCode" class="form-control xCNHide" type="hidden" value="<?=$tNameBch['raItems']['FTBchCode']?>" >
                                    <?php } ?>
                                </div>
                            </div>
                        </div> -->
                        <input name="oetInputSmartLockerTypeBchCode" id="oetInputSmartLockerTypeBchCode" class="form-control xCNHide" type="hidden" value="<?=$tNameBch['raItems']['FTBchCode']?>" >
                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <div  class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('company/smartlockerlayout/smartlockerlayout','tSMLLayoutTableShp')?></label>
                                    <div class="form-group">
                                        <input type="text"
                                        class="form-control"
                                        maxlength="200" id="oetShpName"
                                        name="oetShpName" 
                                        value="<?php echo $tShpName ; ?>"
                                        readonly>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <div  class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('company/shop/shop','tNameTabSmartLockerLayout')?></label>
                                    <select class="selectpicker form-control xCNSelectBox" id="oetShtType" name="oetShtType">
                                        <option value="1" <?php echo $select1; ?>><?php echo language('supplier/supplier/supplier','tGeneralLoc')?></option>
                                        <option value="2" <?php echo $select2; ?>><?php echo language('supplier/supplier/supplier','tTempleLoc')?></option>
                                        <!-- <option value="3" <?php echo $select3; ?>><?php echo language('supplier/supplier/supplier','QR CODE')?></option> -->
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <div  class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('company/shop/shop','tLocTypeName')?></label>
                                    <div class="form-group">
                                        <input type="text"
                                        class="form-control"
                                        maxlength="200" id="oetShtName" name="oetShtName" 
                                        data-is-created=""
                                        value="<?php echo $tShtName ; ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?= language('company/shop/shop','tLocRemark')?></label>
                                    <textarea class="form-control" rows="4"  maxlength="100" id="oetShtRemark" name="oetShtRemark"><?php echo $tShtRemark?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
     $(document).ready(function(){
        $('.selectpicker').selectpicker();                               
    });

    //Browse สาขา
    var nLangEdits  = <?=$this->session->userdata("tLangEdit")?>;
    var tBchCodeWhere    = "<?=$tWhereBranch?>";
    var oSSmartLockerTypeBrowseBranch = {
        Title   : ['company/branch/branch','tBCHTitle'],
        Table   : {Master:'TCNMBranch',PK:'FTBchCode',PKName:'FTBchName'},
        Join    : {
            Table   : ['TCNMBranch_L'],
            On      : ['TCNMBranch_L.FTBchCode = TCNMBranch.FTBchCode AND TCNMBranch_L.FNLngID = '+nLangEdits,]
        },
        Where   : {
            Condition : ["AND TCNMBranch.FTBchCode IN ("+tBchCodeWhere+") "]
        },
        GrideView   : {
            ColumnPathLang	: 'company/branch/branch',
            ColumnKeyLang	: ['tBCHCode','tBCHName'],
            ColumnsSize     : ['15%','75%'],
            WidthModal      : 50,
            DataColumns		: ['TCNMBranch.FTBchCode','TCNMBranch_L.FTBchName'],
            DataColumnsFormat : ['',''],
            Perpage			: 5,
            OrderBy			: ['TCNMBranch_L.FTBchName'],
            SourceOrder		: "ASC"
        },
        CallBack:{
            ReturnType	: 'S',
            Value		: ["oetInputSmartLockerTypeBchCode","TCNMBranch.FTBchCode"],
            Text		: ["oetInputSmartLockerTypeBchName","TCNMBranch_L.FTBchName"],
        }
        // DebugSQL : true
    }
    $('#obtSmartLockerTypeBrowseBranch').click(function(){ 
        JCNxBrowseData('oSSmartLockerTypeBrowseBranch'); 
        JCNxCloseLoading();
    });

</script>
<script src="<?= base_url('application/modules/common/assets/js/jquery.mask.js')?>"></script>
<script src="<?= base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>

