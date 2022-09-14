<?php 

    if($tEvent!="pdtFashionEventAdd"){
        $tFhnImgObj = $aMasterPdtClrSze['raItems']['FTImgObj'];
        $tFhnPdtCode = $aMasterPdtClrSze['raItems']['FTPdtCode'];
        $nFhnSeq     = $aMasterPdtClrSze['raItems']['FNFhnSeq'];
        $tFhnSeaCode = $aMasterPdtClrSze['raItems']['FTSeaCode'];
        $tFhnSeaName = $aMasterPdtClrSze['raItems']['FTSeaName'];
        $tFhnFabCode = $aMasterPdtClrSze['raItems']['FTFabCode'];
        $tFhnFabName = $aMasterPdtClrSze['raItems']['FTFabName'];
        $tFhnClrCode = $aMasterPdtClrSze['raItems']['FTClrCode'];
        $tFhnClrName = $aMasterPdtClrSze['raItems']['FTClrName'];
        $tFhnPszCode = $aMasterPdtClrSze['raItems']['FTPszCode'];
        $tFhnPszName = $aMasterPdtClrSze['raItems']['FTPszName'];
        $dFhnStart = $aMasterPdtClrSze['raItems']['FDFhnStart'];
        $tFhnPdtRefCode = $aMasterPdtClrSze['raItems']['FTFhnRefCode'];
        $nFhnPdtStatus  = $aMasterPdtClrSze['raItems']['FTFhnStaActive'];
    }else{
        $tFhnImgObj  = '';
        $tFhnPdtCode = $tPdtCode;
        $nFhnSeq     = '';
        $tFhnSeaCode = '';
        $tFhnSeaName = '';
        $tFhnFabCode = '';
        $tFhnFabName = '';
        $tFhnClrCode = '';
        $tFhnClrName = '';
        $tFhnPszCode = '';
        $tFhnPszName = '';
        $nFhnPdtStatus  = '1';
        $dFhnStart   = date('Y-m-d');
        if($aMasterPdt['rtCode']=="1"){
            $tFhnPdtRefCode   = $aMasterPdt['raItems']['FTFhnModNo'];
        }else{
            $tFhnPdtRefCode   = '';
        }

    }

    if($aMasterPdt['rtCode']=="1"){
        $tFhnPdtRefCodeDb   = $aMasterPdt['raItems']['FTFhnModNo'];
    }else{
        $tFhnPdtRefCodeDb   = '';
    }

?>
<style>
.xPadding5 {
    padding:5px
}
</style>
<form action="javascript:void(0);" class="validate-form" method="post" id="ofmAddEditPdtClrSze">
<input type="hidden" name="oetFhnPdtCode" id="oetFhnPdtCode" value="<?=$tFhnPdtCode?>">
<input type="hidden" name="oetFhnModNo" id="oetFhnModNo" value="<?=$tFhnPdtRefCodeDb?>">
<input type="hidden" name="ohdPdtClrSzeEvent" id="ohdPdtClrSzeEvent" value="<?=$tEvent?>">
<input type="hidden" name="oetFhnSeq" id="oetFhnSeq" value="<?=$nFhnSeq?>">


<div id="" class="">
    <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3" style="margin-bottom:10px;">
       <?php echo FCNtHGetContentUploadImage(@$tFhnImgObj,'PdtFashion'); ?>
      </div>

    <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9" style="margin-bottom:10px;">

        <div class="row xPadding5" >
            <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3" id="odvtPageAddTmpImgForPdtFashionPage">
                <label id="" class="xCNLabelFrm"><?= language('product/product/product', 'tFhnPdtName') ?> </label>
            </div>
            <div class="col-xs-12 col-sm-3 col-md-6 col-lg-6" id="odvFnhPageAddPdtName">
                <?=$tFhnPdtName?>
            </div>
        </div>

        <div class="row xPadding5">
            <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3" id="odvtTmpImgForPdtFashionPage">
                <label id="" class="xCNLabelFrm"><?= language('product/product/product', 'tFhnPdtDataTableSeason') ?> </label>
            </div>
            <div class="col-xs-12 col-sm-3 col-md-6 col-lg-6" id="">
                    <div class="input-group">
                        <input type="text" id="oetFhnPdtSeasonCode" class="form-control xCNHide" name="oetFhnPdtSeasonCode" value="<?=$tFhnSeaCode?>" data-validate="<?= language('product/product/product', 'tFhnPdtDataTableSeason') ?>" >
                        <input type="text" id="oetFhnPdtSeasonName" class="form-control" name="oetFhnPdtSeasonName" value="<?=$tFhnSeaName?>" readonly>
                        <span class="input-group-btn">
                            <button id="obFhnPdtSeasonBrows" type="button" class="btn xCNBtnBrowseAddOn">
                                <img src="<?php echo base_url() . '/application/modules/common/assets/images/icons/find-24.png' ?>">
                            </button>
                        </span>
                    </div>
            </div>
        </div>

        <div class="row xPadding5">
            <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3" id="odvtTmpImgForPdtFashionPage">
                <label id="" class="xCNLabelFrm"><?= language('product/product/product', 'tFhnPdtDataTableFabric') ?> </label>
            </div>
            <div class="col-xs-12 col-sm-3 col-md-6 col-lg-6" id="">
                    <div class="input-group">
                        <input type="text" id="oetFhnPdtFabricCode" class="form-control xCNHide" name="oetFhnPdtFabricCode" value="<?=$tFhnFabCode?>" data-validate="<?= language('product/product/product', 'tFhnPdtDataTableFabric') ?>">
                        <input type="text" id="oetFhnPdtFabricName" class="form-control" name="oetFhnPdtFabricName" value="<?=$tFhnFabName?>" readonly>
                        <span class="input-group-btn">
                            <button id="obFhnPdtFabricBrows" type="button" class="btn xCNBtnBrowseAddOn">
                                <img src="<?php echo base_url() . '/application/modules/common/assets/images/icons/find-24.png' ?>">
                            </button>
                        </span>
                    </div>
            </div>
        </div>

        <div class="row xPadding5">
            <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3" id="odvtTmpImgForPdtFashionPage">
                <label id="" class="xCNLabelFrm"><?= language('product/product/product', 'tFhnPdtDataTableColor') ?> </label>
            </div>
            <div class="col-xs-12 col-sm-3 col-md-6 col-lg-6" id="">
                    <div class="input-group">
                        <input type="text" id="oetFhnPdtColorCode" class="form-control xCNHide" name="oetFhnPdtColorCode" value="<?=$tFhnClrCode?>" data-validate="<?= language('product/product/product', 'tFhnPdtDataTableColor') ?>">
                        <input type="text" id="oetFhnPdtColorName" class="form-control" name="oetFhnPdtColorName" value="<?=$tFhnClrName?>" readonly>
                        <span class="input-group-btn">
                            <button id="obFhnPdtColorBrows" type="button" class="btn xCNBtnBrowseAddOn">
                                <img src="<?php echo base_url() . '/application/modules/common/assets/images/icons/find-24.png' ?>">
                            </button>
                        </span>
                    </div>
            </div>
        </div>

        <div class="row xPadding5">
            <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3" id="odvtTmpImgForPdtFashionPage">
                <label id="" class="xCNLabelFrm"><?= language('product/product/product', 'tFhnPdtDataTableSize') ?> </label>
            </div>
            <div class="col-xs-12 col-sm-3 col-md-6 col-lg-6" id="">
                    <div class="input-group">
                        <input type="text" id="oetFhnPdtSizeCode" class="form-control xCNHide" name="oetFhnPdtSizeCode" value="<?=$tFhnPszCode?>" data-validate="<?= language('product/product/product', 'tFhnPdtDataTableSize') ?>">
                        <input type="text" id="oetFhnPdtSizeName" class="form-control" name="oetFhnPdtSizeName" value="<?=$tFhnPszName?>" readonly>
                        <span class="input-group-btn">
                            <button id="obFhnPdtSizeBrows" type="button" class="btn xCNBtnBrowseAddOn">
                                <img src="<?php echo base_url() . '/application/modules/common/assets/images/icons/find-24.png' ?>">
                            </button>
                        </span>
                    </div>
            </div>
        </div>
        
        <div class="row xPadding5">
            <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3" id="odvtTmpImgForPdtFashionPage">
                <label id="" class="xCNLabelFrm"><span style="color:red">*</span> <?= language('product/product/product', 'tFhnPdtDataTableRefCode') ?> </label>
            </div>
            <div class="col-xs-12 col-sm-3 col-md-6 col-lg-6" id="">
                <input type="hidden" id="oetFhnPdtRefCodeOld" class="form-control" name="oetFhnPdtRefCodeOld" maxlength="50" value="<?=$tFhnPdtRefCode?>">
                <input type="text"   id="oetFhnPdtRefCode"    class="form-control" name="oetFhnPdtRefCode"    maxlength="50" value="<?=$tFhnPdtRefCode?>" data-validate="<?= language('product/product/product', 'tFhnPdtDataTableRefCode') ?>" <?php   if($tEvent!="pdtFashionEventAdd"){ echo 'readonly'; }  ?>>
            </div>
        </div>


        <div class="row xPadding5"> 
            <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3" id="odvtTmpImgForPdtFashionPage">
                <label id="" class="xCNLabelFrm"><?= language('product/product/product', 'tFhnPdtStart') ?> </label>
            </div>
            <div class="col-xs-12 col-sm-3 col-md-6 col-lg-6" id="">
                   
                    <div class="form-group">
                               <div class="input-group">
                                        <input
                                            type="text"
                                            class="form-control xCNDatePicker xCNInputMaskDate"
                                            id="oetFhnPdtStratDate"
                                            name="oetFhnPdtStratDate"
                                            value="<?=$dFhnStart?>"
                                        >
                                        <span class="input-group-btn">
                                            <button id="obtFhnPdtStratDate" type="button" class="btn xCNBtnDateTime"><img class="xCNIconCalendar"></button>
                                        </span>
                                </div>
                    </div>
            </div>
        </div>
 

        <div class="row xPadding5">      
            <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3" id="odvtTmpImgForPdtFashionPage">
                <label id="" class="xCNLabelFrm"><?= language('product/product/product', 'tFhnPdtDataTableStatus') ?> </label>
            </div>
            <div class="col-xs-12 col-sm-3 col-md-6 col-lg-6" id="">
                                <label class="fancy-checkbox">
                                    <input id="ocbFhnPdtStatus" type="checkbox" class="ocbFhnPdtStatus" name="ocbFhnPdtStatus" value="1" <?php if($nFhnPdtStatus=='1'){ echo 'checked'; }  ?>  >
                                    <span>&nbsp;<?= language('product/product/product', 'tFhnPdtDataTableUse1') ?></span>
                                </label>
            </div>
        </div>

      
     </div>

</div>
</form>

<?php include "script/jPdtfashionPageAdd.php"; ?>

