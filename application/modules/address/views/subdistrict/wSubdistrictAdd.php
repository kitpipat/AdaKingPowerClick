<?php 
if($aResult['rtCode'] == "1"){
    $tSdtCode       = $aResult['raItems']['rtSudCode'];
    $tSdtName       = $aResult['raItems']['rtSudName'];
    $tSdtDptCode    = $aResult['raItems']['rtDstCode'];
    $tSdtDptName    = $aResult['raItems']['rtDstName'];
    $tSdtPvnCode    = $aResult['raItems']['rtPvnCode'];
    $tSdtPvnName    = $aResult['raItems']['rtPvnName'];
    $tSdtLatitude   = $aResult['raItems']['rtSudLatitude'];
    $tSdtLongitude  = $aResult['raItems']['rtSudLongitude'];
    $tRoute = "subdistrictEventEdit";
}else{
    $tSdtCode       = "";
    $tSdtName       = "";
    $tSdtDptCode    = "";
    $tSdtDptName    = "";
    $tSdtPvnCode    = "";
    $tSdtPvnName    = "";
    $tSdtLatitude   = "";
    $tSdtLongitude  = "";
    $tRoute = "subdistrictEventAdd";
}
?>

<form class="contact100-form validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" autocorrect="off" autocapitalize="off" autocomplete="off" id="ofmAddSubdistrict">
    <button style="display:none" type="submit" id="obtSubmitSubdistrict" onclick="JSnAddEditSubdistrict('<?= $tRoute?>')"></button>
    <div style="margin-top:15px;" style="padding-top:20px !important;">
	
        <div class="panel-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="xCNLabelFrm"><span style="color:red">*</span><?php echo language('address/subdistrict/subdistrict','tSDTCode')?></label>
                        <div class="form-group" id="odvSubdistrictAutoGenCode">
                            <div class="validate-input">
                                <label class="fancy-checkbox">
                                    <input type="checkbox" id="ocbSubdistrictAutoGenCode" name="ocbSubdistrictAutoGenCode" checked="true" value="1">
                                    <span> <?php echo language('common/main/main', 'tGenerateAuto'); ?></span>
                                </label>
                            </div>
				        </div>

                        <div class="form-group" id="odvSubdistrictCodeForm">
                            <input type="hidden" id="ohdCheckDuplicateSdtCode" name="ohdCheckDuplicateSdtCode" value="1"> 
                            <div class="validate-input">
                                <input 
                                    type="text" 
                                    class="form-control xCNInputWithoutSpcNotThai" 
                                    maxlength="5" 
                                    id="oetSdtCode" 
                                    name="oetSdtCode"
                                    data-is-created="<?php echo $tSdtCode;?>"
                                    placeholder="#####"
                                    value="<?php echo $tSdtCode; ?>" 
                                    data-validate-required="<?php echo language('address/subdistrict/subdistrict','tSDTValiCode')?>"
                                    data-validate-dublicateCode="<?php echo language('address/subdistrict/subdistrict','tSDTValidCodeDup')?>"
                                >
                            </div>
				        </div>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <!--New-->
                    <div class="form-group">
                        <label class="xCNLabelFrm"><span style="color:red">*</span><?php echo language('address/subdistrict/subdistrict','tSDTProvince')?></label>
                        <div class="input-group">
                            <input type="text" class="form-control xCNHide" id="oetSdtPvncode" name="oetSdtPvncode" value="<?php echo $tSdtPvnCode?>">
                            <input type="text" class="form-control xWPointerEventNone" id="oetSdtPvnName" name="oetSdtPvnName" value="<?php echo $tSdtPvnName?>" readonly data-validate="<?php echo language('address/subdistrict/subdistrict','tSDTValiProvince')?>">
                            <span class="input-group-btn">
                                <button id="oimSdtBrowseProvince" type="button" class="btn xCNBtnBrowseAddOn">
                                    <img src="<?php echo  base_url().'/application/modules/common/assets/images/icons/find-24.png'?>">
                                </button>
                            </span>
                        </div>
                    </div>
                    <!--End-->

                </div>
                <div class="col-md-4">
                    <!--New-->
                    <div class="form-group">
                        <label class="xCNLabelFrm"><span style="color:red">*</span><?php echo language('address/subdistrict/subdistrict','tSDTDistrict')?></label>
                        <div class="input-group">
                            <input type="text" class="form-control xCNHide" id="oetSdtDstcode" name="oetSdtDstcode" value="<?php echo $tSdtDptCode?>">
                            <input type="text" class="form-control xWPointerEventNone" id="oetSdtDstName" name="oetSdtDstName" value="<?php echo $tSdtDptName?>" readonly data-validate="<?php echo language('address/subdistrict/subdistrict','tSDTValiDis')?>">
                            <span class="input-group-btn">
                                <button id="oimSdtBrowseDistrict" type="button" class="btn xCNBtnBrowseAddOn">
                                    <img src="<?php echo  base_url().'/application/modules/common/assets/images/icons/find-24.png'?>">
                                </button>
                            </span>
                        </div>
                    </div>
                    <!--End-->

                </div>
            </div>
            <div class="row">
                <div class="col-md-8">
                    <div class="form-group">
                        <div class="validate-input" data-validate="Please Insert Name">
                            <label class="xCNLabelFrm"><?= language('address/subdistrict/subdistrict','tSDTName')?></label>
                            <input
                                 type="text" 
                                 class="xCNInputWithoutSpc" 
                                 maxlength="100" 
                                 id="oetSdtName" 
                                 name="oetSdtName" 
                                 value="<?php echo $tSdtName;?>" 
                                 data-validate-required="<?php echo language('address/subdistrict/subdistrict','tSDTValidName')?>">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8">
                    <div class="form-group">
                        <label class="xCNTextDetail1"><?= language('address/subdistrict/subdistrict','tSDTMap')?></label>
                        <input type="hidden" id="oetSdtMapLong" name="oetSdtMapLong" value="<?=$tSdtLongitude?>">
                        <input type="hidden" id="oetSdtMapLat" name="oetSdtMapLat" value="<?=$tSdtLatitude?>">
                        <div id="odvMapEdit" class="xCNMapShow">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<?php include "script/jSubdistrictAdd.php"; ?>

<script type="text/javascript">
    $(document).ready(function(){
        $('.xWTooltipsBT').tooltip({'placement': 'bottom'});
        $('[data-toggle="tooltip"]').tooltip({'placement': 'top'});
        // //Call Map Api
        var oMapSubdistrict = {
            tDivShowMap	:'odvMapEdit',
            cLongitude	: <?=(isset($tSdtLongitude)&&!empty($tSdtLongitude))? floatval($tSdtLongitude):floatval('100.50182294100522')?>,
            cLatitude	: <?=(isset($tSdtLatitude)&&!empty($tSdtLatitude))? floatval($tSdtLatitude):floatval('13.757309968845291')?>,
            tInputLong	: 'oetSdtMapLong',
            tInputLat	: 'oetSdtMapLat',
            tIcon		: "https://openlayers.org/en/v4.6.5/examples/data/icon.png",
            tStatus		: '2'	
        }
        JSxMapAddEdit(oMapSubdistrict);
    });

    // Lang Browse Zone
    var nLangEdits = <?=$this->session->userdata("tLangEdit")?>;
    //Set Option Browse Province
    var oPvnOption = {
        Title : ['address/subdistrict/subdistrict','tBrowsePVNTitle'],
        Table:{Master:'TCNMProvince',PK:'FTPvnCode'},
        Join :{
            Table:	['TCNMProvince_L'],
            On:['TCNMProvince_L.FTPvnCode = TCNMProvince.FTPvnCode AND TCNMProvince_L.FNLngID = '+nLangEdits,]
        },
        GrideView:{
            ColumnPathLang	    : 'address/subdistrict/subdistrict',
            ColumnKeyLang	    : ['tBrowsePVNCode','tBrowsePVNName'],
            DataColumns		    : ['TCNMProvince.FTPvnCode','TCNMProvince_L.FTPvnName'],
            ColumnsSize         : ['10%','75%'],
            DataColumnsFormat   : ['',''],
            WidthModal          : 50,
            Perpage			    : 10,
            OrderBy			    : ['TCNMProvince.FTPvnCode'],
            SourceOrder		    : "ASC"
        },
        NextFunc:{
            FuncName:'JSxNextFuncSubDistrictProvince',
            ArgReturn:['FTPvnCode']
        },
        CallBack:{
            ReturnType	: 'S',
            Value		: ["oetSdtPvncode","TCNMProvince,FTPvnCode"],
		    Text		: ["oetSdtPvnName","TCNMProvince_L.FTPvnName"],
        },
        RouteAddNew : 'province',
        BrowseLev : nStaSdtBrowseType 
    }
    //Set Option Browse District
    var oDstOption = {
        Title : ['address/subdistrict/subdistrict','tBrowseDSTTitle'],
        Table:{Master:'TCNMDistrict',PK:'FTDstCode'},
        Join :{
            Table:	['TCNMDistrict_L'],
            On:['TCNMDistrict_L.FTDstCode = TCNMDistrict.FTDstCode AND TCNMDistrict_L.FNLngID = '+nLangEdits,]
        },
        Filter:{
		    Selector:'oetSdtPvncode',
		    Table:'TCNMDistrict',
            Key:'FTPvnCode'
	    },
        GrideView:{
            ColumnPathLang	    : 'address/subdistrict/subdistrict',
            ColumnKeyLang	    : ['tBrowseDSTCode','tBrowseDSTName'],
            DataColumns		    : ['TCNMDistrict.FTDstCode','TCNMDistrict_L.FTDstName'],
            ColumnsSize         : ['10%','75%'],
            DataColumnsFormat   : ['',''],
            WidthModal          : 50,
            Perpage			    : 10,
            OrderBy			    : ['TCNMDistrict.FTDstCode'],
            SourceOrder		    : "ASC"
        },
        NextFunc:{
            FuncName:'JSxNextFuncSubDistrictDistrict',
            ArgReturn:['FTDstCode']
        },
        CallBack:{
            ReturnType	: 'S',
            Value		: ["oetSdtDstcode","TCNMDistrict,FTDstCode"],
		    Text		: ["oetSdtDstName","TCNMDistrict_L.FTDstName"],
        },
        RouteAddNew : 'district',
        BrowseLev : nStaSdtBrowseType
    }
    //Event Browse
    $('#oimSdtBrowseProvince').click(function(){JCNxBrowseData('oPvnOption');});
    $('#oimSdtBrowseDistrict').click(function(){JCNxBrowseData('oDstOption');});
    //Event CallBack Chang
    $('#oetSdtPvncode').change(function(){
        //remove Class ที่ทำให้กดไม่ได้ออก District
	    $('#oetSdtDstcode').val('');
	    $('#oetSdtDstName').val('');
	    $('#oimSdtBrowseDistrict').removeClass('xWPointerEventNone');
	    $('.xWSDTDstName').removeClass('xWCurNotAlw');
    });

    function JSxNextFuncSubDistrictProvince(){
        $('#oetSdtPvnName').closest('.form-group').addClass( "has-success" ).removeClass( "has-error");
        $('#oetSdtPvnName').closest('.form-group').find(".help-block").fadeOut('slow').remove();
    }

    function JSxNextFuncSubDistrictDistrict(){
        $('#oetSdtDstName').closest('.form-group').addClass( "has-success" ).removeClass( "has-error");
        $('#oetSdtDstName').closest('.form-group').find(".help-block").fadeOut('slow').remove();
    }
</script>