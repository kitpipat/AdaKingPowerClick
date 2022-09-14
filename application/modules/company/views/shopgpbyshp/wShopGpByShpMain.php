<style>
    @media (min-width: 1200px) {
        #odvDivMngTable {
            margin-top: 34px !important;
        }

        #odvRowAddGpToTable {
            padding-top: 10px !important;
        }

        .xWBtnAddShopGpTable {
            width: 8.666667% !important;
            padding-left: 0px !important;
        }

        .xWBtnAddShopGpTable .btn {
            width: 100% !important;
        }

        .xWInputGpVal {
            padding-left: 0px !important;
            padding-right: 10px !important;
        }

        .xWDateStartGpSlt{
            width: 24.6% !important;
        }

    }
</style>
<div class="row">
<input type="hidden" id="ohdShopGpByShpBchCode" name="ohdShopGpByShpBchCode" value="<?php echo $tBchCode;?>">
<input type="hidden" id="ohdShopGpByShpShpCode" name="ohdShopGpByShpShpCode" value="<?php echo $tShpCode;?>">
<input type="hidden" id="ohdShopGpByShpPageShpCallBack;" value="<?php echo $nPageShpCallBack;?>">
<input type="hidden" id="ohdBtnGrpRightGpShop" value="<?php echo htmlspecialchars($vBtnSaveGpShp); ?>">

<div id="odvSetionShopGPByShp">
    <!--วันที่มีผล ปุ่มค้นหา-->
    <div class="col-xs-12 col-md-7 col-lg-7">
        <div class="row">
            <?php   
                $aBchCode  = explode(",",$tBchCode);
                $tCountBch = FCNnHSizeOf($aBchCode);  
                if($tCountBch != '1' ) :
            ?>
        <div class="col-lg-3 col-sm-6 col-md-6 col-xs-10">
		    <div class="form-group">  
                <select class="selectpicker form-control" id="ocmShopGpByShpBchCode" name="ocmShopGpByShpBchCode" maxlength="1">
                    <?php 
                    $aBchCode  = explode(",",$tBchCode);
                    foreach($aBchCode as $tBchCode){ ?>
                        <option value="<?=$tBchCode?>"><?=$tBchCode?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <?php endif; ?>    
            <div class="col-lg-6 col-sm-6 col-md-6 col-xs-10">
                <div class="form-group">
                    <div class="input-group">
                        <input type="text" class="form-control xCNDatePickerPDT xCNInputMaskDate" id="oetSearchShopGpShp" name="oetSearchShopGpShp" placeholder="<?php echo language('company/shopgpbyshp/shopgpbyshp','tSGPSDateStart');?>" autocomplete="off">
                        <span class="input-group-btn">
                            <button id="obtSearchShopGpByShp" type="button" class="btn xCNBtnDateTime">
                                <img  src="<?=base_url().'application/modules/common/assets/images/icons/icons8-Calendar-100.png'?>">
                            </button>
                            <button style="margin-left: -5px;" id="oimSearchSpaPdtPri" class="btn xCNBtnSearch" type="button" onclick="JSvSearchAllShopGp()">
                                <img class="xCNIconAddOn" src="<?=base_url().'/application/modules/common/assets/images/icons/search-24.png'?>">
                            </button>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
     <!--ปุ่มตัวเลือก กับ ปุ่มเพิ่ม-->
     <div class="col-xs-12 col-md-5 col-lg-5 text-right">
            <?php if($aAlwEventShopGpByShp['tAutStaFull'] == 1 || $aAlwEventShopGpByShp['tAutStaDelete'] == 1 ) : ?>
                <div id="odvMngTableList" class="btn-group xCNDropDrownGroup">
                    <button type="button" class="btn xCNBTNMngTable" data-toggle="dropdown">
                        <?=language('common/main/main','tCMNOption')?>
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                        <li id="oliBtnDeleteAll" class="disabled">
                            <a data-toggle="modal" data-target="#odvModalDelShopGpShp"><?=language('common/main/main','tDelAll')?></a>
                        </li>
                    </ul>
                </div>
            <?php endif; ?>
            <button id="obtShopGpByShp" name="obtShopGpByShp" class="xCNBTNPrimeryPlus" type="button" onclick="JSvCallPageShopByGpAdd()" style="margin-left: 20px; margin-top: 0px;">+</button>
        </div>

<div class="col-xs-12 col-md-12 col-lg-12">
    <div id="odvSetionShopGPBySHP"></div>
</div>
</div>
</div>
</div>


<?php include "script/jShopGpByShpAdd.php"; ?>
<script src="<?php echo base_url('application/modules/common/assets/js/jquery.mask.js')?>"></script>
<script src="<?php echo base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>
<script type="text/javascript">
    $('ducument').ready(function(){ 

        //Date picker
        $('.xCNDatePickerPDT').datepicker({
            format          : 'yyyy-mm-dd',
            autoclose       : true,
            todayHighlight  : true
        });
        $('#obtSearchShopGpByShp').click(function(){$('#oetSearchShopGpShp').datepicker('show')});
    });
</script>