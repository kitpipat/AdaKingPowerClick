<style>
    .BTNCancle{
        background-color: #D4D4D4 !important;
        border-color    : #D4D4D4 !important;
    }

    .BTNCancle:hover{
        color           : #FFFFFF !important;
        background-color: #aba9a9 !important;
        border-color    : #aba9a9 !important;
    }

    .BTNGPAll{
        background-color: #D4D4D4 !important;
        border-color    : #D4D4D4 !important;
    }

    .BTNGPAll:hover{
        color           : #FFFFFF !important;
        background-color: #aba9a9 !important;
        border-color    : #aba9a9 !important;
    }
</style>

<!--ชื่อเมนู-->
<div class="col-xs-12 col-md-9 col-lg-9">
    <label class="xCNLabelFrm" style="color: #179bfd !important; cursor:pointer;" onclick="$('#obtGpShopCancel').click()"><?php echo language('company/shopgpbypdt/shopgpbypdt','tSGPPTitle')?></label>
    <label class="xCNLabelFrm">
    <label class="xCNLabelFrm" style="color: #aba9a9 !important;"> / <?php echo language('company/shopgpbypdt/shopgpbypdt','tSGPPTBAdd')?> </label>   
</div>

<!--ปุ่มยกเลิก กับ ปุ่มบันทึก-->
<div class="col-xs-12 col-md-3 col-lg-3">
    <div class="row">
        <div class="col-lg-6 col-md-6 col-xs-6">
            <button type="button" id="obtGpShopCancel" style="width:100%;" class="btn xCNBTNDefult xCNBTNDefult2Btn">
                <?php echo language('company/shopgpbypdt/shopgpbypdt', 'tSGPPBTNCancel')?>
            </button>
        </div>
        <div class="col-lg-6 col-md-6 col-xs-6">

            <?php if($aAlwEventShopGpByPdt['tAutStaFull'] == 1 || ($aAlwEventShopGpByPdt['tAutStaAdd'] == 1 || $aAlwEventShopGpByPdt['tAutStaEdit'] == 1)) : ?>
                <div class="btn-group" style="width: 100%;">
                    <button type="submit" style="width: 85%;" class="btn xWBtnGrpSaveLeft" id="obtGpShopByPDTSave"> <?php echo  language('common/main/main', 'tSave')?></button>
                    <?php echo $vBtnSave?>
                    <style> .xWBtnGrpSaveRight{ width:15%; }</style>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!--ฟิลเตอร์ค้นหา-->
<?php $tSesUserLevel = $this->session->userdata("tSesUsrLevel"); ?>

<div class="col-xs-12 col-md-12 col-lg-12">
    <div class="row">

        <!--สาขาที่มีผล-->
        <div class="col-lg-3 col-md-3 col-xs-12">
            <div class="form-group">
                <label class="xCNLabelFrm"><?=language('company/shopgpbyshp/shopgpbyshp','tSGPPHeadBch');?></label>
        
                <?php if($tNameBch == '' && $tSesUserLevel == 'HQ'){ ?>
                    <div class="input-group">
                        <input name="oetInputBchName" id="oetInputBchName" class="form-control"  type="text" readonly="" placeholder="<?=language('pos/posshop/posshop','tSGPPHeadBch')?>">
                        <input name="oetInputBchCode" id="oetInputBchCode" class="form-control xCNHide"  type="text" >
                        <span class="input-group-btn">
                            <button class="btn xCNBtnBrowseAddOn" id="obtBrowseBranch" type="button">
                                <img src="<?=base_url().'/application/modules/common/assets/images/icons/find-24.png'?>">
                            </button>
                        </span>
                    </div>
                <?php }else{ ?>
                    <input type="text" class="form-control" disabled value="<?=$tNameBch['raItems']['FTBchName']?>">
                    <input name="oetInputBchCode" id="oetInputBchCode" class="form-control xCNHide"  type="text" value="<?=$tNameBch['raItems']['FTBchCode']?>">
                <?php } ?>
            </div>
        </div>

        <!--ร้านค้า-->
        <div class="col-lg-3 col-md-3 col-xs-12">
            <div class="form-group">
                <div class="validate-input">
                    <label class="xCNLabelFrm"><?=language('company/shopgpbyshp/shopgpbyshp','tSGPPHeadShop');?></label>
                    <input type="text" class="form-control" disabled id="oetLableShopname" name="oetLableShopname" value="<?=$aDT['raItems']['FTShpName']?>">
                </div>
            </div>
        </div>

        <!--วันที่มีผล-->
        <div class="col-lg-3 col-md-3 col-xs-12">
            <div class="form-group">
                <label class="xCNLabelFrm"><?=language('company/shopgpbyshp/shopgpbyshp','tSGPSDateStart');?></label>
                <div class="input-group">
                    <input type="text" class="form-control xCNDatePickerInsertPDT xCNInputMaskDate" id="oetShopGpByPDTInsertDateStart" name="oetShopGpByPDTDateStart" placeholder="<?=language('company/shopgpbyshp/shopgpbyshp','tSGPSDateStart');?>" autocomplete="off">
                    <span class="input-group-btn">
                        <button id="obtShopGpByPDTInsertDateStart" type="button" class="btn xCNBtnDateTime">
                            <img  src="<?=base_url().'application/modules/common/assets/images/icons/icons8-Calendar-100.png'?>">
                        </button>
                    </span>
                </div>
            </div>
        </div>

        <!--GP ALL-->
        <div class="col-lg-3 col-md-3 col-xs-12">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-xs-6">
                    <label class="xCNLabelFrm" style="color:#FFF !important;">.</label>
                    <input type="text" style="text-align: right;" class="form-control xCNInputNumericWithDecimal" maxlength="5" id="oetShopGpByPDTPercent" name="oetShopGpByPDTPercent" placeholder="% GP">
                </div>
                <div class="col-lg-6 col-md-6 col-xs-6">
                    <label class="xCNLabelFrm" style="color:#FFF !important;">.</label>
                    <button type="button" id="obtUseGPAll" style="width: 100%;" class="btn BTNCancle" onclick="">
                        <?php echo language('company/shopgpbypdt/shopgpbypdt', 'tSGPPBTNUseGPAll')?>
                    </button>
                </div>
            </div>
        </div>

    </div>
</div>

<!--ตาราง-->
<div class="col-xs-12 col-md-12 col-lg-12">
    <div id="odvContentGPTableProduct"></div>
</div>

<script src="<?php echo base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>
<script type="text/javascript">
    $('ducument').ready(function(){ 

        //ปุ่ม Cancel
        $('#obtGpShopCancel').click(function(){
            var tBCH = $('#ohdShopGPPDTBch').val();
            var tSHP = $('#ohdShopGPPDTShp').val();
            JSvCallPageShopGpByPdtMain(tBCH,tSHP,1);
        });
        
        //Date picker
        $('.xCNDatePickerInsertPDT').datepicker({
            format          : 'yyyy-mm-dd',
            autoclose       : true,
            todayHighlight  : true,
            startDate       : new Date(),
        });
        $('#obtShopGpByPDTInsertDateStart').click(function(){$('#oetShopGpByPDTInsertDateStart').datepicker('show')});

        //Table GP Insert
        var tHTMLs;
        JSxCreateTableInsertGPPDT();
    });

    //Table GP Insert
    function JSxCreateTableInsertGPPDT(){
        $.ajax({
            type    : "POST",
            url     : "CmpShopGpByProductTableInsertProduct",
            data    : { },
            success: function (oResult) {
                JCNxCloseLoading();
                tHTMLs = '';
                localStorage.removeItem("LocalItemData");
                $('#odvContentGPTableProduct').html(oResult); 
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }

    //Browse สาขา
    var nLangEdits  = <?=$this->session->userdata("tLangEdit")?>;
    var tBchCode    = "<?=$tWhereBranch?>";
    var oCmpBrowseBranch = {
        Title   : ['company/branch/branch','tBCHTitle'],
        Table   : {Master:'TCNMBranch',PK:'FTBchCode',PKName:'FTBchName'},
        Join    : {
            Table   : ['TCNMBranch_L'],
            On      : ['TCNMBranch_L.FTBchCode = TCNMBranch.FTBchCode AND TCNMBranch_L.FNLngID = '+nLangEdits,]
        },
        Where   : {
            Condition : ["AND TCNMBranch.FTBchCode IN ("+tBchCode+") "]
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
            Value		: ["oetInputBchCode","TCNMBranch.FTBchCode"],
            Text		: ["oetInputBchName","TCNMBranch_L.FTBchName"],
        },
        // DebugSQL : true
    }
    $('#obtBrowseBranch').click(function(){ JCNxBrowseData('oCmpBrowseBranch'); });
   
</script>
