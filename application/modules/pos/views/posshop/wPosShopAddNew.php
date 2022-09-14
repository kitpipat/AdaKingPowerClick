<?php
    if($aResult['rtCode'] == 1){
        $tBchCode   = $aResult['raItems']['FTBchCode'];
        $tShpCode   = $aResult['raItems']['FTShpCode'];
        $tPosCode   = $aResult['raItems']['FTPosCode'];
        $tPshPosSN  = $aResult['raItems']['FTPshPosSN'];
        $tPshStaUse = $aResult['raItems']['FTPshStaUse'];
        $tPosRegNo  = $aResult['raItems']['FTPosName'];
        
        if($tShpTypeCode == 5){
            $tPshNetIP   = $aResult['raItems']['FTPshNetIP'];
            $tPshNetPort = $aResult['raItems']['FTPshNetPort'];
        }

        $tRoute     = "posshopEventEdit"; 
    }else{

        $tBchCode     = "";
        $tShpCode     = "";
        $tPosCode     = "";
        $tPshPosSN    = "";
        $tPshStaUse   = "";
        $tPshNetIP    = "";
        $tPshNetPort  = "";
        $tPosRegNo    = "";
        
        $tRoute     = "posshopEventAdd";
    }
?>

<!-- Nav Tab Add Product -->
<div id="odvPshRowNavMenu" class="row">
		<div class="custom-tabs-line tabs-line-bottom left-aligned">
			<ul class="nav" role="tablist">
				<!--ข้อมูลหลัก-->
				<li id="oliPSHDetail" class="xWMenu active" data-menutype="PS" onclick="">
					<a role="tab" data-toggle="tab" data-target="#odvPSHContentInfoPS" aria-expanded="true"><?php echo language('pos/posshop/posshop','tPshTBMasterData')?></a>
				</li>

				<!--โฆษณา-->
				<!-- <li id="oliPSHDetail" class="xWMenu " data-menutype="AM" onclick="">
					<a role="tab" data-toggle="tab" data-target="#odvPSHContentInfoAM" aria-expanded="true"><?php echo language('pos/posshop/posshop','tPshTBAdvertisement')?></a>
				</li> -->
                
                <?php if($rtCode != 1){ ?>
                <?php if($tShpTypeCode == 5 ) : ?>
				<!--ตั้งค่าเอเอาท์-->
				<li id="oliPSHDetail" class="xWMenu " data-menutype="ST" onclick="JSxGetPSHContentLayoutSetting()">
					<a role="tab" data-toggle="tab" data-target="#odvPSHContentInfoST" aria-expanded="true"><?php echo language('pos/posshop/posshop','tPshTBSetting')?></a>
				</li>
				<!--สั่ง/จ่าย-->
				<!-- <li id="oliPSHDetail" class="xWMenu " data-menutype="OP" onclick="">
					<a role="tab" data-toggle="tab" data-target="#odvPSHContentInfoOP" aria-expanded="true"><?php echo language('pos/posshop/posshop','tPshTBOpenpay')?></a>
				</li> -->
				<!--ตรวจสอบสถานะ-->
				<li id="oliPSHDetail" class="xWMenu " data-menutype="CS" onclick="JSxGetPSHContentCheckStatus()">
					<a role="tab" data-toggle="tab" data-target="#odvPSHContentInfoCS" aria-expanded="true"><?php echo language('pos/posshop/posshop','tPshTBCheckStatus')?></a>
				</li>
				<!--ใบปรับสถานะ-->
				<li id="oliPSHDetail" class="xWMenu " data-menutype="CG" onclick="JSxGetPSHContentAdjustStatus()">
					<a role="tab" data-toggle="tab" data-target="#odvPSHContentInfoCG" aria-expanded="true"><?php echo language('pos/posshop/posshop','tPshTBChangeStatus')?></a>
				</li>
                <?php endif; ?>
                <?php } ?>
            </ul>
        </div>
    </div>
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom: 25px;"> </div>

	<!-- Tab panes -->
	<div class="tab-content row">

        <!-- ข้อมูลหลัก -->
        <div id="odvPSHContentInfoPS" class="tab-pane fade active in"> 
            <form class="validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" id="ofmAddPosShop">
                <input id="oetPshPSHShpType" name="oetPshPSHShpType"  type="hidden" value="<?php echo $tShpTypeCode?>">
                <input id="oetPshPSHBchCode" name="oetPshPSHBchCode"  type="hidden" value="<?php echo $aPSHBchCode?>">
                <input id="oetPshPSHShpCod"  name="oetPshPSHShpCod"   type="hidden" value="<?php echo $aPSHShpCode?>">
                <input id="oetPshPSHPosCode"  name="oetPshPSHPosCode"   type="hidden" value="<?php echo $tPosCode?>">
                <div class="row">
    
                    <!--ปุ่มเพิ่ม-->
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12  text-right">
                        <?php if($aAlwEventPosShop['tAutStaFull'] == 1 || ($aAlwEventPosShop['tAutStaAdd'] == 1 || $aAlwEventPosShop['tAutStaEdit'] == 1)) : ?>
                                <button type="submit" class="btn" style="background-color: rgb(23, 155, 253); color: white;" id="obtAddPosShop"  onclick="JSoAddPosShop('<?= $tRoute?>')"> <?php echo  language('common/main/main', 'tSave')?></button>
                        <?php endif; ?>
                    </div>

                </div>
                <div class="row">
                    <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5">
                        <div class="form-group">
                            <label class="xCNLabelFrm">
                                <span style="color:red">*</span>
                                <?= language('pos/posshop/posshop','tPshPHPOSChoose')?>
                            </label>
                            <div class="input-group">
                            <input name="oetPosCodeSNOld" id="oetPosCodeSNOld" class="form-control xCNHide" value="<?php echo $tPosCode; ?>">
                                <input name="oetPosCodeSN" id="oetPosCodeSN" class="form-control xCNHide" value="<?php echo $tPosCode; ?>">
                                <input name="oetPosName" id="oetPosName" class="form-control xWPointerEventNone xWRptConsCrdInput"  type="text" readonly="" value="<?php echo $tPosRegNo; ?>" placeholder="<?= language('pos/posshop/posshop','tPshPHPOS')?>" data-validate="<?= language('pos/posshop/posshop','tPSHValidPosCode')?>">
                                <span class="input-group-btn">
                                    <button class="btn xCNBtnBrowseAddOn" id="btnBrowsePos" type="button">
                                        <img src="<?php echo  base_url().'/application/modules/common/assets/images/icons/find-24.png'?>">
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>
                    </div>

                    <div class="row">
                    <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5">
                        <div class="form-group">
                            <label class="xCNLabelFrm">
                                <span style="color:red">*</span>
                                <?= language('pos/posshop/posshop','tPshPHPOSSN')?>
                            </label>
                            <input name="oetPshPosSN" id="oetPshPosSN" maxlength="255"  type="text" value="<?php echo $tPshPosSN; ?>" autocomplete="off" placeholder="<?= language('pos/posshop/posshop','tPshTBSN')?>" data-validate="<?= language('pos/posshop/posshop','tPSHValidPshPosSN')?>">
                        </div>
                    </div>
                    </div>

                    <div class="row">
                    <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5">
                        <div class="form-group">
                        <label class="xCNLabelFrm">
                            <span style="color:red">*</span>
                            <?= language('pos/posshop/posshop','tPshSelectSta')?>
                        </label>
                        <select class="selectpicker form-control" id="ocmPshStaUse" name="ocmPshStaUse" maxlength="1" data-validate="<?= language('pos/posshop/posshop','tPSHValidocmPshStaUse')?>">
                            <!-- <option value="" checked><?=language('pos/posshop/posshop','tPshSelectSta')?></option> -->
                            <option value="1"><?=language('pos/posshop/posshop','tPshStaActive')?></option>
                            <option value="2"><?=language('pos/posshop/posshop','tPshStaNotActive')?></option>
                        </select>
                        </div>
                    </div>
                    </div>

                    <div class="row">
                    <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5">
                        <div class="form-group">
                        <label class="xCNLabelFrm">
                            <span style="color:red">*</span>
                        <?= language('pos/posshop/posshop','tPSHNoSetLayoutStatus')?>
                        </label>
                        <select class="selectpicker form-control" id="ocmPshStaSceLayout" name="ocmPshStaSceLayout" maxlength="1" data-validate="<?= language('pos/posshop/posshop','tPSHValidocmPshStaUse')?>">

                            <?php if($tShpType == '6') {?>
                            <option value="1"><?=language('vending/cabinet/cabinet','tTableCabinetPayPdt')?></option>
                            <option value="2"><?=language('vending/cabinet/cabinet','tTableCabinetPaySelect')?></option>
                            <option value="3"><?=language('vending/cabinet/cabinet','tTableCabinetSelectAdvertising')?></option>
                            <option value="4"><?=language('vending/cabinet/cabinet','tTableCabinetSelect')?></option>
                            <?php }else if($tShpType == '4') {?>
                            <option value="5"><?=language('vending/cabinet/cabinet','tTableCabinetSellPdt')?></option>
                            <option value="6"><?=language('vending/cabinet/cabinet','tTableCabinetSelPdtAdvertising')?></option>
                            <?php } ?>
                        </select>
                        </div>
                    </div>
                    </div>

                    <?php
                    if($tShpTypeCode == '5') : ?>
                    <div class="row">
                    <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5">
                        <div class="form-group">
                            <label class="xCNLabelFrm">
                                <span style="color:red">*</span>
                                <?= language('pos/posshop/posshop','tPshTBIpAs')?>
                            </label>
                            <input name="oetPshPosShopIP" id="oetPshPosShopIP" type="text" value="<?php echo $tPshNetIP; ?>" autocomplete="off" placeholder="<?= language('pos/posshop/posshop','tPshTBIpAs')?>" data-validate="<?= language('pos/posshop/posshop','tPSHValidocmPshIpAs')?>">
                        </div>
                    </div>
                    </div>

                    <div class="row">
                    <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5">
                        <div class="form-group">
                            <label class="xCNLabelFrm">
                                <span style="color:red">*</span>
                                <?= language('pos/posshop/posshop','tPshTBIpPt')?>
                            </label>
                            <input name="oetPshPosShopPort" id="oetPshPosShopPort" type="text" value="<?php echo $tPshNetPort; ?>" autocomplete="off" placeholder="<?= language('pos/posshop/posshop','tPshTBIpPt')?>" data-validate="<?= language('pos/posshop/posshop','tPSHValidocmPshIpPt')?>">
                        </div>
                    </div>
                    </div>
                    <?php  endif;?>

                </form>
                </div>
   

       
		<!-- โฆษณา -->
		<div id="odvPSHContentInfoAM" class="tab-pane fade">โฆษณา</div>	

		<!-- ตั้งค่าเอเอาท์ -->
		<div id="odvPSHContentInfoST" class="tab-pane fade">ตั้งค่าเอเอาท์</div>	

		<!-- สั่ง/จ่าย -->
		<div id="odvPSHContentInfoOP" class="tab-pane fade">สั่ง/จ่าย</div>

		<!-- ตรวจสอบสถานะ -->
		<div id="odvPSHContentInfoCS" class="tab-pane fade"></div>

		<!-- ใบปรับสถานะ -->
		<div id="odvPSHContentInfoCG" class="tab-pane fade"></div>

		

	</div>

<script src="<?= base_url('application/modules/common/assets/js/jquery.mask.js')?>"></script>
<script src="<?= base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>
<?php include "script/jPosShopMain.php"; ?>

<script type="text/javascript">
	$('.selectpicker').selectpicker();
	$(document).ready(function () {
        $('#btnBrowsePos').click(function(){
            window.oCmpBrowsePosOption  = oCmpBrowsePos({
                'tBchCode'  : $('#oetPshPSHBchCode').val(),
                'tShopCode' : $('#oetPshPSHShpCod').val(),
            });
            
            JCNxBrowseData('oCmpBrowsePosOption');
        });
		// $('#odvBtnShpInfo').hide();
		var tSHPCode = $('#oetShpCode').val();
		$('#oetShpCodePosList').val(tSHPCode);

		var tBCHCode = $('#oetBchCode').val();
		$('#oetBchCode').val(tBCHCode);
	});


	//Browse POS
    var oCmpBrowsePos   = function(paData){
        var tBchCode        = paData.tBchCode;
        var tShopCode       = paData.tShopCode;
        var aBchCode        = tBchCode.split(',');
        var tStringWhereBch =   "";
        var tShpType = $('#oetPshPSHShpType').val();

        $.each(aBchCode,function(nKey,aVal){
            var tBchCodeSplit   =   aVal.trim();
            if(nKey == 0){
                tStringWhereBch += "FTBchCode = '"+tBchCodeSplit+"'";
            }else{
                tStringWhereBch += " OR FTBchCode = '"+tBchCodeSplit+"'";
            }
        });
        var tWhereNotIn = " SELECT DISTINCT FTPosCode FROM TVDMPosShop WHERE 1=1 AND ("+tStringWhereBch+") AND (FTShpCode = '"+tShopCode+"') ";

        switch (tShpType) {
                case  "1": 
                    tWhereIn = "AND FTPosType = '1' AND FTPosType = '2' AND FTPosType = '3'  " 
                break;
                case  "2": 
                    tWhereIn = "AND FTPosType = '1' AND FTPosType = '2' AND FTPosType = '3' "
                break;
                case  "3": 
                    tWhereIn = "AND FTPosType = '1' AND FTPosType = '2' AND FTPosType = '3' "
                break;
                case  "4": 
                    tWhereIn = "AND FTPosType = '4'"
                break;
                case  "5": 
                    tWhereIn = "AND FTPosType = '5' ";
                    var tWhereNotIn = " SELECT DISTINCT FTPosCode FROM TRTMShopPos WHERE 1=1 AND ("+tStringWhereBch+") AND (FTShpCode = '"+tShopCode+"') ";
                break;
                default: 
                    tWhereIn = ""
        }
        
        var oOptionReturn = {
            Title 	: ['pos/posshop/posshop','tPshBRWPOSTitle'],
            Table	: {Master:'TCNMPos',PK:'FTPosCode'},
            Join 	: {
            Table	:	['TCNMPos_L'],
            On		:	["TCNMPos.FTPosCode = TCNMPos_L.FTPosCode AND TCNMPos.FTBchCode = TCNMPos_L.FTBchCode  "]
        },	
            Where :{
                Condition : [" AND TCNMPos.FTBchCode = "+tBchCode+" AND TCNMPos.FTPosCode NOT IN ("+tWhereNotIn+") "+tWhereIn+" "]
            }, 
            GrideView:{
                ColumnPathLang	: 'pos/posshop/posshop',
                ColumnKeyLang	: ['tPshTBPosCode','tPshTBPosName','tPshBRWShopTBRegNo'],
                ColumnsSize     : ['30%','50%','20%'],
                DataColumns		: ['TCNMPos.FTPosCode' ,'TCNMPos_L.FTPosName', 'TCNMPos.FTPosRegNo'],
                DataColumnsFormat : ['','',''],
                WidthModal      : 40,
                Perpage			: 10,
                OrderBy			: ['TCNMPos.FTPosCode'],
                SourceOrder		: "ASC"
            },
            CallBack:{
                ReturnType	: 'S',
                Value       : ["oetPosCodeSN","TCNMPos.FTPosCode"],
                Text		: ["oetPosName","TCNMPos_L.FTPosName"],
            }, 
            NextFunc:{
                FuncName    :'JSvNOTINItem',
                ArgReturn   :['FTPosCode']
            },
            RouteFrom : tShpType,
            RouteAddNew : 'salemachine',
            BrowseLev : 0,
            // DebugSQL : true,
        };
        return oOptionReturn;
    };
    
    function JSvNOTINItem(elem){
        //alert(elem)
    }
</script>


