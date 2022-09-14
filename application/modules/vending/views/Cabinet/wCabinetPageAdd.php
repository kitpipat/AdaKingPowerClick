<?php
    $tRefShopCode = $tShpName . ' (' . $tShpCode . ')';
    if($tPageEvent == "PageAdd"){
        $tRoute                 = 'VendingCabinetEventAdd';
        $tCabinetSeq            = '';
        $CabinetType            = '';
        $tCabinetMaxRow         = 1;
        $tCabinetMaxColumn      = 1;
        $tCabinetTypeVDName     = '';
        $tCabinetTypeVDCode     = '';
        $tCabinetRemark         = '';
        $tCabinetName           = '';
        // $tCabinetShowRow        = '';
        // $tCabinetShowCol        = '';
    }else{
        $tRoute                 = 'VendingCabinetEventEdit';
        $tCabinetSeq            = $aGetContent['raItems'][0]['FNCabSeq'];
        if (isset($aGetContent['raItems'][0]['FNCabType'])) {
          $CabinetType            = $aGetContent['raItems'][0]['FNCabType'];
        }else {
          $CabinetType            = '';
        }

        $tCabinetMaxRow         = $aGetContent['raItems'][0]['FNCabMaxRow'];
        $tCabinetMaxColumn      = $aGetContent['raItems'][0]['FNCabMaxCol'];
        $tCabinetTypeVDName     = $aGetContent['raItems'][0]['FTShtName'];
        $tCabinetTypeVDCode     = $aGetContent['raItems'][0]['FTShtCode'];
        $tCabinetRemark         = $aGetContent['raItems'][0]['FTCabRmk'];
        $tCabinetName           = $aGetContent['raItems'][0]['FTCabName'];
        // $tCabinetShowRow        = $aGetContent['raItems'][0]['FNCabShwRow'];
        // $tCabinetShowCol        = $aGetContent['raItems'][0]['FNCabShwCol'];
    }
?>

<form class="validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" id="ofmAddCabinet">

    <!--ปุ่มยกเลิก กับ ปุ่มบันทึก-->
    <div class="col-lg-12 col-md-12 col-xs-12   text-right">
        <button type="button" onclick="JSxGetSHPContentCabinet();"
                id="obtCabinetCancel" class="btn"
                style="background-color: #D4D4D4; color: #000000;">
                <?=language('company/shopgpbypdt/shopgpbypdt', 'tSGPPBTNCancel')?>
        </button>
        <button type="submit" class="btn" style="background-color: rgb(23, 155, 253); color: white;"
                id="obtCabinetSave"
                onclick="JSoEventInsertCabinet('','<?=$tRoute?>')"><?=language('common/main/main', 'tSave')?>
        </button>
    </div>

    <input type="hidden" id="ohdSeqCabinet" name="ohdSeqCabinet" value="<?=$tCabinetSeq?>">

    <!--form-->
    <div class="col-lg-5 col-md-5 col-xs-12">

        <!--ข้อมูลร้านค้า-->
        <div class="form-group">
            <label class="xCNLabelFrm"><?=language('vending/cabinet/cabinet','tTableCabinetInfoShop')?></label>
            <input
                class="form-control"
                type="text"
                id="oetRefShopCode"
                name="oetRefShopCode"
                placeholder="<?=language('vending/cabinet/cabinet','tTableCabinetCodeRef')?>"
                maxlength="100"
                readonly
                value="<?=@$tRefShopCode?>">
        </div>

        <!--ชื่อ-->
        <div class="form-group">
            <label class="xCNLabelFrm"><span style="color:red">* </span><?=language('vending/cabinet/cabinet','tTableCabinetName')?></label>
            <input
                class="form-control text-left"
                type="text"
                id="oetCabinetName"
                name="oetCabinetName"
                autocomplete="off"
                placeholder="<?=language('vending/cabinet/cabinet','tTableCabinetName')?>"
                maxlength="225"
                data-validate-required = "<?= language('vending/cabinet/cabinet','tvalidateCabinetName')?>"
                value="<?=@$tCabinetName?>">
        </div>

        <!--ประเภทตู้-->
        <!-- <div class="form-group">
            <label class="xCNLabelFrm"><?=language('vending/cabinet/cabinet','tTableCabinetType')?></label>
            <select class="selectpicker form-control" id="ocmCabinetType" name="ocmCabinetType" maxlength="1">
                <option value="1" <?=($CabinetType == 1) ? 'selected' : '';?>><?=language('vending/cabinet/cabinet','tSelectCabinetTypeVending')?></option>
                <option value="2" <?=($CabinetType == 2) ? 'selected' : '';?>><?=language('vending/cabinet/cabinet','tSelectCabinetTypeLocker')?></option>
            </select>
        </div> -->

        <!--ประเภทร้านค้า-->
        <div class="form-group">
            <label class="xCNLabelFrm"><span style="color:red">* </span><?=language('vending/cabinet/cabinet','tTableCabinetTypeShop');?></label>
            <div class="input-group">
                <input name="oetCabinetShopTypeName" id="oetCabinetShopTypeName" class="form-control" value="<?=$tCabinetTypeVDName;?>"  type="text" readonly="" placeholder="<?=language('vending/cabinet/cabinet','tTableCabinetTypeShop')?>
                " data-validate-required = "<?= language('vending/cabinet/cabinet','tvalidateCabinetTypeVending')?>">
                <input name="oetCabinetShopTypeCode" id="oetCabinetShopTypeCode" value="<?=$tCabinetTypeVDCode; ?>" class="form-control xCNHide"  type="text" >
                <span class="input-group-btn">
                    <button class="btn xCNBtnBrowseAddOn" id="obtBrowseCabinetShopType" type="button">
                        <img src="<?=base_url().'/application/modules/common/assets/images/icons/find-24.png'?>">
                    </button>
                </span>
            </div>
        </div>

        <div class="row">
            <!--จำนวนแถวสูงสุด-->
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                <div class="form-group">
                    <label class="xCNLabelFrm"><?=language('vending/cabinet/cabinet','tTableCabinetMaxRow')?></label>
                    <input
                        class="form-control text-right xCNInputNumericWithoutDecimal"
                        type="text"
                        id="oetCabinetMaxRow"
                        name="oetCabinetMaxRow"
                        placeholder="<?=language('vending/cabinet/cabinet','tTableCabinetMaxRow')?>"
                        maxlength="2"
                        autocomplete="off"
                        value="<?=@$tCabinetMaxRow?>">
                </div>
            </div>

            <!--การแสดงแถว-->
            <!-- <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                <div class="form-group">
                    <label class="xCNLabelFrm"><?=language('vending/cabinet/cabinet','tTableCabinetShowRow')?></label>
                    <select class="selectpicker form-control" id="ocmCabinetShwRow" name="osmCabinetShwRow" maxlength="1">
                        <option value="2" <?=($tCabinetShowRow == 2) ? 'selected' : '';?>>2</option>
                        <option value="3" <?=($tCabinetShowRow == 3) ? 'selected' : '';?>>3</option>
                        <option value="4" <?=($tCabinetShowRow == 4) ? 'selected' : '';?>>4</option>
                        <option value="5" <?=($tCabinetShowRow == 5) ? 'selected' : '';?>>5</option>
                    </select>
                </div>
            </div> -->

            <!--จำนวนคอลัมน์สูงสุด-->
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                <div class="form-group">
                    <label class="xCNLabelFrm"><?=language('vending/cabinet/cabinet','tTableCabinetMaxColumn')?></label>
                    <input
                        class="form-control text-right xCNInputNumericWithoutDecimal"
                        type="text"
                        id="oetCabinetMaxColumn"
                        name="oetCabinetMaxColumn"
                        placeholder="<?=language('vending/cabinet/cabinet','tTableCabinetMaxColumn')?>"
                        maxlength="2"
                        autocomplete="off"
                        value="<?=@$tCabinetMaxColumn?>">
                </div>
            </div>

            <!--การแสดงแถว-->
            <!-- <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                <div class="form-group">
                    <label class="xCNLabelFrm"><?=language('vending/cabinet/cabinet','tTableCabinetShowCol')?></label>
                    <select class="selectpicker form-control" id="ocmCabinetShwCol" name="osmCabinetShwCol" maxlength="1">
                        <option value="2" <?=($tCabinetShowCol == 2) ? 'selected' : '';?>>2</option>
                        <option value="3" <?=($tCabinetShowCol == 3) ? 'selected' : '';?>>3</option>
                        <option value="4" <?=($tCabinetShowCol == 4) ? 'selected' : '';?>>4</option>
                        <option value="5" <?=($tCabinetShowCol == 5) ? 'selected' : '';?>>5</option>
                    </select>
                </div>
            </div> -->

        </div>
        <!--หมายเหตุ-->
        <div class="form-group">
            <div class="validate-input">
                <label class="xCNLabelFrm"><?= language('vending/cabinet/cabinet','tTableCabinetRemark')?></label>
                <textarea class="input100" style="resize: none; padding: 10px;" rows="10" maxlength="255" id="oetCabinetRemark" name="oetCabinetRemark"
                placeholder="<?= language('vending/cabinet/cabinet','tTableCabinetRemark')?>"><?= $tCabinetRemark?></textarea>
            </div>
        </div>

    </div>
</form>

<script src="<?=base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>
<script type="text/javascript">
    $('ducument').ready(function(){
        $('.selectpicker').selectpicker();
    });

    var nLangEdits  = '<?=$this->session->userdata("tLangEdit")?>';
    var oCmpBrowseShopType = {
        Title   : ['vending/cabinet/cabinet','tTableCabinetTypeShop'],
        Table   : {Master:'TVDMShopType', PK:'FTShtCode'},
        Join    : {
            Table   : ['TVDMShopType_L'],
            On      : ['TVDMShopType_L.FTShtCode = TVDMShopType.FTShtCode AND TVDMShopType_L.FNLngID = '+nLangEdits,]
        },
        GrideView   : {
            ColumnPathLang	: 'vending/cabinet/cabinet',
            ColumnKeyLang	: ['tVstTBCode','tVstTBName','tTableCabinetTypeShop','tVstTBTemp1','tVstTBTemp2','tVstTBTemp3','tVstRemark'],
            ColumnsSize     : ['10%','25%','10%','10%','10%','10%','10%'],
            WidthModal      : 50,
            DataColumns		: ['TVDMShopType.FTShtCode','TVDMShopType_L.FTShtName','TVDMShopType.FTShtType','TVDMShopType.FNShtValue','TVDMShopType.FNShtMin','TVDMShopType.FNShtMax','TVDMShopType_L.FTShtRemark'],
            DataColumnsFormat : ['','','','Number:0','Number:0','Number:0',''],
            Perpage			: 5,
            OrderBy			: ['TVDMShopType.FTShtCode'],
            SourceOrder		: "ASC"
        },
        CallBack:{
            ReturnType	: 'S',
            Value		: ["oetCabinetShopTypeCode","TVDMShopType.FTShtCode"],
            Text		: ["oetCabinetShopTypeName","TVDMShopType_L.FTShtName"],
        },
        RouteAddNew : 'VendingShopType',
        BrowseLev   : 0,
        // DebugSQL    : true
    }
    $('#obtBrowseCabinetShopType').click(function(){
        JCNxBrowseData('oCmpBrowseShopType');
    });

    //ปุ่ม Save
    function JSoEventInsertCabinet(ptStaGp,ptRoute){
        $('#ofmAddCabinet').validate({
                focusInvalid    : true,
                onclick         : false,
                onfocusout      : false,
                onkeyup         : false,
                rules: {
                    oetCabinetName : { "required": true },
                    oetCabinetShopTypeName  : { "required": true },
                    oetCabinetShopType : { "required": true }
                },
                messages: {
                    oetCabinetName : {
                        "required"      : $('#oetCabinetName').attr('data-validate-required')
                    },
                    oetCabinetShopTypeName : {
                        "required"      : $('#oetCabinetShopTypeName').attr('data-validate-required')
                    },
                    oetCabinetShopType : {
                        "required"      : $('#oetCabinetShopType').attr('data-validate-required')
                    }
                },
                errorElement: "em",
                errorPlacement: function (error, element) {
                    error.addClass("help-block");
                    if (element.prop("type") === "checkbox") {
                    error.appendTo(element.parent("label"));
                    } else {
                    var tCheck = $(element.closest('.form-group')).find('.help-block').length;
                    if (tCheck == 0) {
                        error.appendTo(element.closest('.form-group')).trigger('change');
                    }
                }
                },
                highlight: function (element, errorClass, validClass) {
                    $(element).closest('.form-group').addClass("has-error");
                },
                unhighlight: function (element, errorClass, validClass) {
                    $(element).closest('.form-group').removeClass("has-error");
                },
                submitHandler: function (form)
                {
                    $.ajax({
                        type    : "POST",
                        url     : ptRoute,
                        data    : $('#ofmAddCabinet').serialize()  + "&BCHCode=" + $('#ohdShopCabinetPDTBch').val() + "&SHPCode=" + $('#ohdShopCabinetPDTShp').val() ,
                        success: function (oResult) {
                            var aResult = JSON.parse(oResult);
                            if(aResult.rtCode == 1){
                                JSxGetSHPContentCabinet();
                            }else{
                                alert('fail');
                            }
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            JCNxResponseError(jqXHR, textStatus, errorThrown);
                        }
                    });
                }
        });
    }
</script>
