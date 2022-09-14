<div class="row">

    <!--ซ่อนค่าไว้-->
    <input type="hidden" name="ohdShopCabinetPDTBch" id="ohdShopCabinetPDTBch" value="<?=$tBchCode?>">
    <input type="hidden" name="ohdShopCabinetPDTShp" id="ohdShopCabinetPDTShp" value="<?=$tShpCode?>">
    
    <!--Content Cabinet-->
    <div id="odvSetionCabinet">
        <!--ปุ่มค้นหา-->
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-left">
		    <p style="font-weight: bold;"><?=language('vending/cabinet/cabinet','tTiTleCabinet');?></p>
		</div>
        <div class="col-xs-12 col-md-7 col-lg-7">
            <div class="row">
                <div class="col-lg-6 col-sm-6 col-md-6 col-xs-10">
                    <div class="form-group">
                        <div class="input-group">
                            <input type="text" class="form-control xCNInputWithoutSingleQuote" id="oetShopCabinetSearch" name="oetShopCabinetSearch" onkeypress="Javascript:if(event.keyCode==13) JSvVDCabinetList()" placeholder="<?=language('common/main/main','tPlaceholder');?>" autocomplete="off">
                            <span class="input-group-btn">
                                <button style="margin-left: -5px;" class="btn xCNBtnSearch" type="button" onclick="JSvVDCabinetList()">
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
            <div id="odvMngTableList" class="btn-group xCNDropDrownGroup">
                <button type="button" class="btn xCNBTNMngTable" data-toggle="dropdown">
                    <?=language('common/main/main','tCMNOption')?>
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu" role="menu">
                    <li id="oliBtnDeleteAll" class="disabled">
                        <a data-toggle="modal" data-target="#odvModalDelCabinetMuti"><?=language('common/main/main','tDelAll')?></a>
                    </li>
                </ul>
            </div>

            <button id="obtPageInsertCabinet" name="obtPageInsertCabinet" class="xCNBTNPrimeryPlus" type="button" style="margin-left: 20px; margin-top: 0px;">+</button>
        </div>

        <!--ตาราง-->
        <div class="col-xs-12 col-md-12 col-lg-12">
            <div id="odvContentCabinet"></div>
        </div>
    </div>
</div>

<script src="<?php echo base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>
<?php include "script/jCabinet.php"; ?>
<script type="text/javascript">
    $('ducument').ready(function(){ 

        //Page Insert
        $('#obtPageInsertCabinet').click(function(){
            JCNxOpenLoading();
            $.ajax({
                type    : "POST",
                url     : "VendingCabinetPageAdd",
                data: {
                    tBchCode           : $('#ohdShopCabinetPDTBch').val(),
                    tShpCode           : $('#ohdShopCabinetPDTShp').val(),
                    nSeq               : 0,
                    tPageEvent         : 'PageAdd'
                },
                success: function (oResult) {
                    $('#odvSetionCabinet').html(oResult);
                    JCNxCloseLoading();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        });

    });
</script>