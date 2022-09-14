<div class="row">

    <!--ซ่อนค่าไว้-->
    <input type="hidden" name="ohdShopGPPDTBch" id="ohdShopGPPDTBch" value="<?=$tBchCode?>">
    <input type="hidden" name="ohdShopGPPDTShp" id="ohdShopGPPDTShp" value="<?=$tShpCode?>">
    
    <!--Content Shop by GP-->
    <div id="odvSetionShopGPByPDT">
        <!--วันที่มีผล ปุ่มค้นหา-->
        <div class="col-xs-12 col-md-7 col-lg-7">
            <div class="row">
                <div class="col-lg-6 col-sm-6 col-md-6 col-xs-10">
                    <div class="form-group">
                        <div class="input-group">
                            <input type="text" class="form-control xCNDatePickerPDT xCNInputMaskDate" id="oetShopGpByPDTDateStart" name="oetShopGpByPDTDateStart" placeholder="<?php echo language('company/shopgpbyshp/shopgpbyshp','tSGPSDateStart');?>" autocomplete="off">
                            <span class="input-group-btn">
                                <button id="obtShopGpByPDTDateStart" type="button" class="btn xCNBtnDateTime">
                                    <img  src="<?=base_url().'application/modules/common/assets/images/icons/icons8-Calendar-100.png'?>">
                                </button>
                                <button style="margin-left: -5px;" id="oimSearchSpaPdtPri" class="btn xCNBtnSearch" type="button" onclick="JSvCallPageShopGpByProductDataTable()">
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
            <?php if($aAlwEventShopGpByPdt['tAutStaFull'] == 1 || $aAlwEventShopGpByPdt['tAutStaDelete'] == 1 ) : ?>
                <div id="odvMngTableList" class="btn-group xCNDropDrownGroup">
                    <button type="button" class="btn xCNBTNMngTable" data-toggle="dropdown">
                        <?=language('common/main/main','tCMNOption')?>
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                        <li id="oliBtnDeleteAll" class="disabled">
                            <a data-toggle="modal" data-target="#odvModalDelMainGP"><?=language('common/main/main','tDelAll')?></a>
                        </li>
                    </ul>
                </div>
            <?php endif; ?>

            <button id="obtShopGpByPdt" name="obtShopGpByPdt" class="xCNBTNPrimeryPlus" type="button" style="margin-left: 20px; margin-top: 0px;">+</button>
        </div>

        <!--ตาราง-->
        <div class="col-xs-12 col-md-12 col-lg-12">
            <div id="odvContentGPProduct"></div>
        </div>
    </div>
</div>

<script src="<?php echo base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>
<script type="text/javascript">
    $('ducument').ready(function(){ 

        //Date picker
        $('.xCNDatePickerPDT').datepicker({
            format          : 'yyyy-mm-dd',
            autoclose       : true,
            todayHighlight  : true
        });
        $('#obtShopGpByPDTDateStart').click(function(){$('#oetShopGpByPDTDateStart').datepicker('show')});

        //Page Add product Shop GP By PDT
        $('#obtShopGpByPdt').click(function(){
            JCNxOpenLoading();
            $.ajax({
                type: "POST",
                url: "CmpShopGpByProductPageAdd",
                data: {
                    tBchCode           : $('#ohdShopGPPDTBch').val(),
                    tShpCode           : $('#ohdShopGPPDTShp').val(),
                    tPageEvent         : 'PageAdd'
                },
                success: function (oResult) {
                    $('#odvSetionShopGPByPDT').html(oResult);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        });

    });
</script>