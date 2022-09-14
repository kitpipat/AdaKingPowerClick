<?php 

    if($aMasterPdt['rtCode']=="1"){
        // echo "<pre>";print_r($aMasterPdt);
        $tFhnPdtCode = $aMasterPdt['raItems']['FTPdtCode'];
        $tFhnPdtName = $aMasterPdt['raItems']['FTPdtName'];
        $tFhnDepCode = $aMasterPdt['raItems']['FTDepCode'];
        $tFhnDepName = $aMasterPdt['raItems']['FTDepName'];
        $tFhnClsCode = $aMasterPdt['raItems']['FTClsCode'];
        $tFhnClsName = $aMasterPdt['raItems']['FTClsName'];
        $tFhnSclCode = $aMasterPdt['raItems']['FTSclCode'];
        $tFhnSclName = $aMasterPdt['raItems']['FTSclName'];
        $tFhnPgpCode = $aMasterPdt['raItems']['FTPgpCode'];
        $tFhnPgpName = $aMasterPdt['raItems']['FTPgpName'];
        $tFhnCmlCode = $aMasterPdt['raItems']['FTCmlCode'];
        $tFhnCmlName = $aMasterPdt['raItems']['FTCmlName'];
        $tFhnModNo   = $aMasterPdt['raItems']['FTFhnModNo'];
        $nFhnGender  = $aMasterPdt['raItems']['FTFhnGender'];
    }else{
        $tFhnPdtCode = '';
        $tFhnPdtName = '';
        $tFhnDepCode = '';
        $tFhnDepName = '';
        $tFhnClsCode = '';
        $tFhnClsName = '';
        $tFhnSclCode = '';
        $tFhnSclName = '';
        $tFhnPgpCode = '';
        $tFhnPgpName = '';
        $tFhnCmlCode = '';
        $tFhnCmlName = '';
        $tFhnModNo   = '';
        $nFhnGender  = '';
    }
?>
<style>
.xPadding5 {
    padding:5px
}
</style>
<form action="javascript:void(0);" class="validate-form" method="post" id="ofmAddEditProductFashion">
<input type="hidden" name="oetFhnPdtCode" id="oetFhnPdtCode" value="<?=$tFhnPdtCode?>">
<div id="odvPdtFashionMenuSelectPdt" class="row">
    <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9" style="margin-bottom:10px;">

        <div class="row xPadding5" >
            <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3" id="odvtTmpImgForPdtFashionPage">
                <label id="" class="xCNLabelFrm"><?= language('product/product/product', 'tFhnPdtName') ?> </label>
            </div>
            <div class="col-xs-12 col-sm-3 col-md-6 col-lg-6" id="odvFnhPdtName">
                <?=$tFhnPdtName?>
            </div>
        </div>

        <div class="row xPadding5 <?php if( !FCNbGetIsCategoryEnabled(1)) : echo 'xCNHide';  endif;?>">
            <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3" id="odvtTmpImgForPdtFashionPage">
                <label id="" class="xCNLabelFrm"><?= language('product/product/product', 'tFhnPdtDepart') ?> </label>
            </div>
            <div class="col-xs-12 col-sm-3 col-md-6 col-lg-6" id="">
                    <div class="input-group">
                        <input type="text" id="oetFhnPdtDepartCode" class="form-control xCNHide xWCatCodeLevel1" data-catlevel="1" name="oetFhnPdtDepartCode" value="<?=$tFhnDepCode?>" data-validate="<?= language('product/product/product', 'tFhnPdtDepart') ?>" >
                        <input type="text" id="oetFhnPdtDepartName" class="form-control" name="oetFhnPdtDepartName" value="<?=$tFhnDepName?>" readonly>
                        <span class="input-group-btn">
                            <button id="obFhnPdtDepartBrows" type="button" class="btn xCNBtnBrowseAddOn xWCatLevel1">
                                <img src="<?php echo base_url() . '/application/modules/common/assets/images/icons/find-24.png' ?>">
                            </button>
                        </span>
                    </div>
            </div>
        </div>

        <div class="row xPadding5 <?php if( !FCNbGetIsCategoryEnabled(2)) : echo 'xCNHide';  endif;?>">
            <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3" id="odvtTmpImgForPdtFashionPage">
                <label id="" class="xCNLabelFrm"><?= language('product/product/product', 'tFhnPdtClass') ?> </label>
            </div>
            <div class="col-xs-12 col-sm-3 col-md-6 col-lg-6" id="">
                    <div class="input-group">
                        <input type="text" id="oetFhnPdtClassCode" class="form-control xCNHide xWCatChkValDisBtn xWCatCodeLevel2" data-catlevel="2" name="oetFhnPdtClassCode" value="<?=$tFhnClsCode?>" data-validate="<?= language('product/product/product', 'tFhnPdtClass') ?>">
                        <input type="text" id="oetFhnPdtClassName" class="form-control" name="oetFhnPdtClassName" value="<?=$tFhnClsName?>" readonly>
                        <span class="input-group-btn">
                            <button id="obFhnPdtClassBrows" type="button" class="btn xCNBtnBrowseAddOn xWCatLevel2">
                                <img src="<?php echo base_url() . '/application/modules/common/assets/images/icons/find-24.png' ?>">
                            </button>
                        </span>
                    </div>
            </div>
        </div>

        <div class="row xPadding5 <?php if( !FCNbGetIsCategoryEnabled(3)) : echo 'xCNHide';  endif;?>">
            <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3" id="odvtTmpImgForPdtFashionPage">
                <label id="" class="xCNLabelFrm"><?= language('product/product/product', 'tFhnPdtSubClass') ?> </label>
            </div>
            <div class="col-xs-12 col-sm-3 col-md-6 col-lg-6" id="">
                    <div class="input-group">
                        <input type="text" id="oetFhnPdtSubClassCode" class="form-control xCNHide xWCatChkValDisBtn xWCatCodeLevel3" data-catlevel="3" name="oetFhnPdtSubClassCode" value="<?=$tFhnSclCode?>" data-validate="<?= language('product/product/product', 'tFhnPdtSubClass') ?>">
                        <input type="text" id="oetFhnPdtSubClassName" class="form-control" name="oetFhnPdtSubClassName" value="<?=$tFhnSclName?>" readonly>
                        <span class="input-group-btn">
                            <button id="obFhnPdtSubClassBrows" type="button" class="btn xCNBtnBrowseAddOn xWCatLevel3">
                                <img src="<?php echo base_url() . '/application/modules/common/assets/images/icons/find-24.png' ?>">
                            </button>
                        </span>
                    </div>
            </div>
        </div>

        <div class="row xPadding5 <?php if( !FCNbGetIsCategoryEnabled(4)) : echo 'xCNHide';  endif;?>">
            <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3" id="odvtTmpImgForPdtFashionPage">
                <label id="" class="xCNLabelFrm"><?= language('product/product/product', 'tFhnPdtGroup') ?> </label>
            </div>
            <div class="col-xs-12 col-sm-3 col-md-6 col-lg-6" id="">
                    <div class="input-group">
                        <input type="text" id="oetFhnPdtGroupCode" class="form-control xCNHide xWCatChkValDisBtn xWCatCodeLevel4" data-catlevel="4" name="oetFhnPdtGroupCode" value="<?=$tFhnPgpCode?>" data-validate="<?= language('product/product/product', 'tFhnPdtGroup') ?>">
                        <input type="text" id="oetFhnPdtGroupName" class="form-control" name="oetFhnPdtGroupName" value="<?=$tFhnPgpName?>" readonly>
                        <span class="input-group-btn">
                            <button id="obFhnPdtGroupBrows" type="button" class="btn xCNBtnBrowseAddOn xWCatLevel4">
                                <img src="<?php echo base_url() . '/application/modules/common/assets/images/icons/find-24.png' ?>">
                            </button>
                        </span>
                    </div>
            </div>
        </div>


        <div class="row xPadding5 <?php if( !FCNbGetIsCategoryEnabled(5)) : echo 'xCNHide';  endif;?>">
            <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3" id="odvtTmpImgForPdtFashionPage">
                <label id="" class="xCNLabelFrm"><?= language('product/product/product', 'tFhnPdtComLines') ?> </label>
            </div>
            <div class="col-xs-12 col-sm-3 col-md-6 col-lg-6" id="">
                    <div class="input-group">
                        <input type="text" id="oetFhnPdtComLinesCode" class="form-control xCNHide xWCatChkValDisBtn xWCatCodeLevel5" data-catlevel="5" name="oetFhnPdtComLinesCode" value="<?=$tFhnCmlCode?>" data-validate="<?= language('product/product/product', 'tFhnPdtComLines') ?>">
                        <input type="text" id="oetFhnPdtComLinesName" class="form-control" name="oetFhnPdtComLinesName" value="<?=$tFhnCmlName?>" readonly>
                        <span class="input-group-btn">
                            <button id="obFhnPdtComLinesBrows" type="button" class="btn xCNBtnBrowseAddOn xWCatLevel5">
                                <img src="<?php echo base_url() . '/application/modules/common/assets/images/icons/find-24.png' ?>">
                            </button>
                        </span>
                    </div>
            </div>
        </div>


        <div class="row xPadding5">
            <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3" id="odvtTmpImgForPdtFashionPage">
                <label id="olbCatPdtMod" class="xCNLabelFrm"></label>
            </div>
            <div class="col-xs-12 col-sm-3 col-md-6 col-lg-6" id="">
                        <input type="text" id="oetFhnPdtModelNo" class="form-control" name="oetFhnPdtModelNo" maxlength="30" value="<?=$tFhnModNo?>" data-validate="<?= language('product/product/product', 'tFhnPdtMod') ?>" autocomplete="off">
            </div>
        </div>

        <div class="row xPadding5">      
            <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3" id="odvtTmpImgForPdtFashionPage">
                <label id="" class="xCNLabelFrm"><?= language('product/product/product', 'tFhnPdtGender') ?> </label>
            </div>
            <div class="col-xs-12 col-sm-3 col-md-6 col-lg-6" id="">
                    <select class="form-control" name="ocmFhnPdtGender" id="ocmFhnPdtGender" >
                        <option value="1" <?php if($nFhnGender=='1'){ echo 'selected'; } ?>><?= language('product/product/product', 'tFhnPdtGender1') ?></option>
                        <option value="2" <?php if($nFhnGender=='2'){ echo 'selected'; } ?>><?= language('product/product/product', 'tFhnPdtGender2') ?></option>
                        <option value="3" <?php if($nFhnGender=='3'){ echo 'selected'; } ?>><?= language('product/product/product', 'tFhnPdtGender3') ?></option>
                    </select>
            </div>
        </div>

  
     </div>
      <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 text-right" style="margin-bottom:10px;">
                          
                                <button id="obtPdtFashionBack" class="btn " type="button" style="background-color: #D4D4D4; color: #000000;"><?= language('common/main/main', 'tCancel') ?></button>
                                <button id="obtPdtFashionSave" class="btn " type="button" style="background-color: rgb(23, 155, 253); color: white;"><?= language('common/main/main', 'tSave') ?></button>
      </div>
</div>
<hr>
</form>

 <div id="odvPdtFashionTable" class="row" style="margin-top:10px">
 
        <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9 ">
            <label id="olbFhnPdtClrSzeTitle" class="xCNLabelFrm xCNTextLink"><?= language('product/product/product', 'tFhnPdtDetail') ?> </label> <label id="olbPdtClrSzeAdd" class="xCNLabelFrm xCNHide"> / <?= language('product/product/product', 'เพิ่ม') ?> </label> <label id="olbPdtClrSzeEdit" class="xCNLabelFrm xCNHide"> / <?= language('product/product/product', 'แก้ไข') ?> </label> 
        </div>

        <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 text-right" style="margin-bottom:10px;">
             <button id="obtPdtClrSzeBack" class="btn xCNHide" type="button" style="background-color: #D4D4D4; color: #000000;"><?= language('common/main/main', 'tCancel') ?></button>
             <button id="obtPdtClrSzeSave" class="btn xCNHide" type="button" style="background-color: rgb(23, 155, 253); color: white;"><?= language('common/main/main', 'tSave') ?></button>
        </div>

                
          <div class="col-lg-6 col-md-6 col-xs-12 col-sm-8 odvPdtClrSzePanelSheach" id="">
                    <div class="form-group">
                        <!-- <label class="xCNLabelFrm"><?php echo language('product/product/product','tPDTSearch')?></label> -->
                        <div class="input-group">
                            <input type="text" class="form-control xCNInputWithoutSpc" id="oetSearchFhnPdtColorSze" name="oetSearchFhnPdtColorSze" placeholder="<?php echo language('common/main/main','tPlaceholder')?>">
                            <span class="input-group-btn">
                                <button id="oimSearchFhnPdtColorSze" class="btn xCNBtnSearch" type="button">
                                    <img class="xCNIconAddOn" src="<?php echo base_url().'/application/modules/common/assets/images/icons/search-24.png'?>">
                                </button>
                            </span>
                        </div>
                    </div>
                </div>
            <div class="col-xs-12 col-sm-4 col-md-6 col-lg-6 text-right odvPdtClrSzePanelSheach" style="margin-bottom:10px;">
                <button id="obtPdtClrSzeAdd" class="xCNBTNPrimeryPlus" type="button">+</button>
            </div>

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 xPadding5">
                            <!-- DataTable Product Set -->
         <div id="odvPdtColorSizeDataTable" class="table-responsive"></div>
                            <!-- End DataTable Product Set -->

        </div>
        </div>
</div>
<?php include('script/jPdtfashionPageFrom.php');?>
