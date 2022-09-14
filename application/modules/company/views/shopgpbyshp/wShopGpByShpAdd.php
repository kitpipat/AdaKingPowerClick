<?php
if($aResult['rtCode'] == "1"){
    $tBchCode       	= $aResult['raItems']['FTBchCode'];
    $tShpCode       	= $aResult['raItems']['FTShpCode'];
    $tDataStart         = $aResult['raItems']['FDSgpStart'];
    $tBchName           = $aResult['raItems']['FTBchName'];
    $tShopGpAvg         = $aResult['raItems']['FCSgpPerAvg'];
    $tSeq               = $aResult['raItems']['FNSgpSeq'];

    //route
	$tRoute         	= "CmpShopGpByShpGPEventEdit";
	//Event Control
	if(isset($aAlwEventShopGpByShp)){
		if($aAlwEventShopGpByShp['tAutStaFull'] == 1 || $aAlwEventShopGpByShp['tAutStaEdit'] == 1){
			$nAutStaEdit = 1;
		}else{
			$nAutStaEdit = 0;
		}
	}else{
		$nAutStaEdit = 0;
	}
}else{

    $aBchCodeChck  = explode(",",$tBchCode);
    $tCountBch = FCNnHSizeOf($aBchCodeChck);  
    if($tCountBch == '1' ) {
        $tBchCode      =  $tBchCode;
        $tBchName      =  $tNameBch['raItems']['FTBchName'];
    }else{
        $tBchCode      =  "";
        $tBchName      =  "";
    }
    $tShpCode      =  "";
    $tDataStart    =  "";
    $tShopGpAvg    =  "";
    $tSeq          =  "";
    
    //route
	$tRoute         = "CmpShopGpByShpGPAdd";
	$nAutStaEdit = 0; //Event Control
}

?>
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
<form class="validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" id="ofmAddShpByGp">

<!--ชื่อเมนู-->
<div class="col-lg-6 col-md-6 col-xs-12 ">
            <label class="xCNLabelFrm">
    <label class="xCNLabelFrm" style="color: #179bfd !important; cursor:pointer;" onclick="$('#obtGpShopCancel').click()"><?php echo language('company/shopgpbyshp/shopgpbyshp','tSGPSTitle')?></label>
    <label class="xCNLabelFrm">
    <label class="xCNLabelFrm xWPageAdd" style="color: #aba9a9 !important;"> / <?php echo language('company/shopgpbypdt/shopgpbypdt','tSGPPTBAdd')?> </label> 
    <label class="xCNLabelFrm xWPageEdit hidden" style="color: #aba9a9 !important;"> / <?php echo language('company/shopgpbypdt/shopgpbypdt','tSGPTBEdit')?> </label>   
</div>

<!--ปุ่มยกเลิก กับ ปุ่มบันทึก-->
 <div class="col-lg-6 col-md-6 col-xs-12   text-right">
    <button type="button" onclick="JSxGetSHPContentInfoGPS();" id="obtGpShopCancel" class="btn" style="background-color: #D4D4D4; color: #000000;">
        <?php echo language('company/shopgpbypdt/shopgpbypdt', 'tSGPPBTNCancel')?>
    </button>
    <?php if($aAlwEventShopGpByShp['tAutStaFull'] == 1 || ($aAlwEventShopGpByShp['tAutStaAdd'] == 1 || $aAlwEventShopGpByShp['tAutStaEdit'] == 1)) : ?>
            <button type="submit" class="btn" style="background-color: rgb(23, 155, 253); color: white;" id="obtGpShopBySHPSave" onclick="JSoAddShopGpBySHP('','<?= $tRoute?>')"> <?php echo  language('common/main/main', 'tSave')?></button>
    <?php endif; ?>
</div>
<?php $tSesUserLevel = $this->session->userdata("tSesUsrLevel"); ?>
 <!--สาขาที่มีผล-->
    <div class="col-lg-6 col-md-6 col-xs-12">
        <div class="form-group">
            <label class="xCNLabelFrm"><?=language('company/shopgpbyshp/shopgpbyshp','tSGPPHeadBch');?></label>
    
            <?php if($tNameBch == '' && $tSesUserLevel == 'HQ'){ ?>
                <div class="input-group">
                    <input name="oetInputBchName" id="oetInputBchName" class="form-control" value="<?php echo $tBchName; ?>"  type="text" readonly="" placeholder="<?=language('pos/posshop/posshop','tSGPPHeadBch')?>
                    " data-validate-required = "<?= language('company/shopgpbyshp/shopgpbyshp','tSGPValidateBch')?>">
                    <input name="oetInputBchCode" id="oetInputBchCode" value="<?php echo $tBchCode; ?>" class="form-control xCNHide"  type="text" >
                    <span class="input-group-btn">
                        <button class="btn xCNBtnBrowseAddOn" id="obtBrowseBranch" type="button">
                            <img src="<?=base_url().'/application/modules/common/assets/images/icons/find-24.png'?>">
                        </button>
                    </span>
                </div>
            <?php }else{ ?>
                <input type="text" class="form-control" readonly="" id="oetInputBchName"   name="oetInputBchName"   value="<?php echo $tBchName;?>">
                <input type="text" class="form-control xCNHide"  id="oetInputBchCode"      name="oetInputBchCode"   value="<?php echo $tBchCode;?>">
            <?php } ?>
        </div>
            <div class="form-group">
                <label class="xCNLabelFrm"><?php echo language('company/shopgpbyshp/shopgpbyshp','tSGPSDateStart')?></label>
                <div class="input-group">
                    <input type="text" class="form-control xCNDatePicker text-center"  id="oetShopGpDateNew" name="oetShopGpDateNew" value="<?php if($tDataStart != ''){ echo date("Y-m-d", strtotime($tDataStart)); } ?>" autocomplete="off"
                    data-validate-required = "<?= language('company/shopgpbyshp/shopgpbyshp','tSGPValidateDate')?>"
                    >
                    <input type="hidden" class="form-control" id="oetShopGpDateOld" name="oetShopGpDateOld"   value="<?= date("Y-m-d", strtotime($tDataStart))?>">
                    <span class="input-group-btn">
                        <button id="obtSearchShopGpByShp" type="button" class="btn xCNBtnBrowseAddOn">
                            <img src="<?php echo  base_url().'application/modules/common/assets/images/icons/icons8-Calendar-100.png'?>">
                        </button>
                    </span>
                </div>
            </div>
            <div class="form-group">
            <label class="xCNLabelFrm"><?=language('company/shopgpbyshp/shopgpbyshp','tSGPTBPerAvg');?></label>
                <input type="text" class="form-control text-right xCNInputNumericWithDecimal xCNInputWithoutSingleQuote" autocomplete="off" id="oetShopGpAvg"  name="oetShopGpAvg" placeholder="% GP" value="<?php echo $tShopGpAvg;?>"
                data-validate-required = "<?= language('company/shopgpbyshp/shopgpbyshp','tSGPValidateGp')?>"
                >
            </div>
        </div>
    </div>
</form>
<script src="<?php echo base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>
<script type="text/javascript">
    $('ducument').ready(function(){ 
        //ปุ่ม Cancel
        $('#obtGpShopCancel').click(function(){
                var tBCH = $('#ohdShopGpByShpBchCode').val();
                var tSHP = $('#ohdShopGpByShpShpCode').val();
                JSvCallPageShopGpByShpMain(tBCH,tSHP,1);
            }); 

        // Set Date Picker
        $('.xCNDatePicker').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true,
            startDate: new Date(),
        });
    });

$('#obtSearchShopGpByShp').click(function(){$('#oetShopGpDateNew').datepicker('show')});
    //Browse สาขา
    // var nLangEdits  = <?=$this->session->userdata("tLangEdit")?>;
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



    //ปุ่ม Save
    
    function JSoAddShopGpBySHP(ptStaGp,ptRoute){
          var dDateNew   = $('#oetShopGpDateNew').val();
        $('#ofmAddShpByGp').validate({
            focusInvalid: true,
            onclick: false,
            onfocusout: false,
            onkeyup: false,
            rules: {
                oetInputBchName  : { "required": true },
                oetShopGpDateNew : { "required": true },
                oetShopGpAvg     : { "required": true }
            },
            messages: {
                oetInputBchName : {
                "required"      : $('#oetInputBchName').attr('data-validate-required')
                },
                oetShopGpDateNew : {
                "required"      : $('#oetShopGpDateNew').attr('data-validate-required')
                },
                oetShopGpAvg : {
                "required"      : $('#oetShopGpAvg').attr('data-validate-required')
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
                // JSoAddGpByShop();
                if(ptStaGp == '' && ptStaGp == undefined){
                        tStaGp == "";
                }else{
                    var tStaGp  = ptStaGp;
                }

                $.ajax({
                    type: "POST",
                    url : ptRoute,
                    data: {
                            tBchCode           : $('#oetInputBchCode').val(),
                            tShpCode           : $('#ohdShopGpByShpShpCode').val(),
                            tBchName           : $('#oetInputBchName').val(),
                            tShpGpAvg          : $('#oetShopGpAvg').val(),
                            dDateNew           : $('#oetShopGpDateNew').val(),
                            dDateOld           : $('#oetShopGpDateOld').val(),
                            pnSeq              : '<?=$tSeq?>'
                    },
                    success: function (oResult) {
                        var tResult = JSON.parse(oResult);
                        var aReturn = JSON.parse(oResult);
                        if (aReturn['nStaEvent'] == 1) {
                            JSxGetSHPContentInfoGPS();
                        } else {
                            alert(aReturn['rtDesc']);
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
