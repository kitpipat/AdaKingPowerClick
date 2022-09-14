<div class="row" style="width:inherit;">
    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
        <div class="row">
            <div class="input-group">
                <input 
                class="form-control xCNInputWithoutSingleQuote" 
                type="text" id="oetSearchAllStep1" 
                name="oetSearchAllStep1" 
                placeholder="<?= language('document/RefillProductVD/RefillProductVD', 'tRVDFillTextSearch') ?>" 
                onkeypress="if (event.keyCode == 13) {return false;}"
                autocomplete="off">
                <span class="input-group-btn">
                    <button type="button" class="btn xCNBtnDateTime">
                        <img src="<?=base_url('application/modules/common/assets/images/icons/search-24.png') ?>">
                    </button>
                </span>
            </div>
        </div>
    </div>
    <!--เพิ่ม-->
    <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8 text-right p-r-0 xCNhideWhenApproveOrCancel">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="btn-group xCNDropDrownGroup">
                    <button id="obtRVDInsertToTempStep1" class="xCNBTNPrimeryPlus" type="button" onclick="JSxRVDInsertToTempStep1()" style="margin-left: 20px; margin-top: 0px;">+</button>
                </div>
            </div>
        </div>
    </div>
    <!--ตาราง-->
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div id="odvContentStep1" class="row" style="margin-top: 10px;"></div>
    </div>
</div>

<!-- เลือกเงื่อนไขใน Step 1 -->
<div id="odvRVDConditionConfigRefillPDT" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header xCNModalHead">
                <label class="xCNTextModalHeard"><?= language('document/RefillProductVD/RefillProductVD', 'tTextStep1') ?></label>
            </div>
            <div class="modal-body">
                <!--สาขา-->
                <div class="form-group">
                    <label class="xCNLabelFrm"><?= language('document/RefillProductVD/RefillProductVD', 'tRVDTBBch'); ?></label>
                    <div class="form-group">
                        <input name="oetRVDConditionBCHName" id="oetRVDConditionBCHName" class="form-control" value="<?=$tRVDBchName ?>" type="text" readonly="" 
                               placeholder="<?= language('document/RefillProductVD/RefillProductVD', 'tRVDTBBch') ?>">
                        <input name="oetRVDConditionBCHCode" id="oetRVDConditionBCHCode" value="<?= $tRVDBchCode ?>" class="form-control xCNHide" type="text">
                        <!-- <span class="input-group-btn">
                            <button class="btn xCNBtnBrowseAddOn" id="obtBrowseConditionBCH" type="button">
                                <img src="<?= base_url() . '/application/modules/common/assets/images/icons/find-24.png' ?>">
                            </button>
                        </span> -->
                    </div>
                </div>
                <!--กลุ่มธุรกิจ-->
                <div class="form-group">
                    <label class="xCNLabelFrm"><?= language('merchant/merchant/merchant','tMerchantTitle'); ?></label>
                    <div class="input-group">
                        <input name="oetRVDConditionMERName" id="oetRVDConditionMERName" class="form-control xWRVDClearOnShwModal" value="" type="text" readonly="" 
                               placeholder="<?= language('merchant/merchant/merchant','tMerchantTitle') ?>">
                        <input name="oetRVDConditionMERCode" id="oetRVDConditionMERCode" value="" class="form-control xWRVDClearOnShwModal xCNHide" type="text">
                        <span class="input-group-btn">
                            <button class="btn xCNBtnBrowseAddOn" id="obtBrowseConditionMER" type="button">
                                <img src="<?= base_url() . '/application/modules/common/assets/images/icons/find-24.png' ?>">
                            </button>
                        </span>
                    </div>
                </div>
                <!--ร้านค้า-->
                <div class="form-group">
                    <label class="xCNLabelFrm"><?= language("company/shop/shop","tSHPTitle_LAYOUT"); ?></label>
                    <div class="input-group">
                        <input name="oetRVDConditionSHPName" id="oetRVDConditionSHPName" class="form-control xWRVDClearOnShwModal" value="" type="text" readonly="" 
                               placeholder="<?= language("company/shop/shop","tSHPTitle_LAYOUT") ?>">
                        <input name="oetRVDConditionSHPCode" id="oetRVDConditionSHPCode" value="" class="form-control xWRVDClearOnShwModal xCNHide" type="text">
                        <span class="input-group-btn">
                            <button class="btn xCNBtnBrowseAddOn" id="obtBrowseConditionSHP" type="button">
                                <img src="<?= base_url() . '/application/modules/common/assets/images/icons/find-24.png' ?>">
                            </button>
                        </span>
                    </div>
                </div>
                <!--ตู้ขายสินค้า-->
                <div class="form-group">
                    <label class="xCNLabelFrm"><?= language('document/RefillProductVD/RefillProductVD', 'tRVDTBPos'); ?></label>
                    <div class="input-group">
                        <input name="oetRVDConditionPOSName" id="oetRVDConditionPOSName" class="form-control xWRVDClearOnShwModal" value="" type="text" readonly="" 
                               placeholder="<?= language('document/RefillProductVD/RefillProductVD', 'tRVDTBPos') ?>">
                        <input name="oetRVDConditionPOSCode" id="oetRVDConditionPOSCode" value="" class="form-control xWRVDClearOnShwModal xCNHide" type="text">
                        <span class="input-group-btn">
                            <button class="btn xCNBtnBrowseAddOn" id="obtBrowseConditionPOS" type="button">
                                <img src="<?= base_url() . '/application/modules/common/assets/images/icons/find-24.png' ?>">
                            </button>
                        </span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button onclick="JSxConfrimConditionMoveDataToTemp(true)" type="button" class="btn xCNBTNPrimery" data-dismiss="modal">
                    <?= language('common/main/main', 'tModalConfirm'); ?>
                </button>
                <button type="button" class="btn xCNBTNDefult" data-dismiss="modal">
                    <?= language('common/main/main', 'tModalCancel'); ?>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- ไม่มีสินค้าเอาเข้า step 1 -->
<div class="modal fade" id="odvImportPDTInStep1">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header xCNModalHead">
				<label class="xCNTextModalHeard"><?=language('document/document/document', 'tDocStawarning') ?></label>
			</div>
			<div class="modal-body">
				<p><?= language('common/main/main','tCMNNotFoundData')?></p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn xCNBTNPrimery"  data-dismiss="modal">
					<?=language('common/main/main', 'tModalConfirm'); ?>
				</button>
			</div>
		</div>
	</div>
</div>

<!--เอาไว้เช็คว่า modal เปิดซ้อนกันไหม-->
<input name="ohdModalCenterIsOpen" id="ohdModalCenterIsOpen" type="hidden" value="0">
<input name="ohdClickConfirmPDTStep1" id="ohdClickConfirmPDTStep1" type="hidden" value="0">

<script>

    //เช็คว่าเอกสารอนุมัติ หรือ ยกเลิกหรือเปล่า
    JSxControlWhenApproveOrCancel();

    $(document).on('hide.bs.modal','#myModal', function () {
        //Modal จะไม่ซ้อนกัน
        if($('#ohdModalCenterIsOpen').val() == 1){
            $('#odvRVDConditionConfigRefillPDT').modal('show');
        }
        $('#ohdModalCenterIsOpen').val(0)
    });

    //ย้อนกลับไป Step1
    function JSxRVDBackToStep1(){
        $('.xCNRefillVDStep1').click();
        $('#ohdClickStep').val(1);
    }

    //ถ้ากด step1 จะ block ปุ่ม
    $('.xCNRefillVDStep1').on('click', function(){
        $('#ohdClickStep').val(1);
        $('.xCNRefillBackStep').hide(); //ย้อนกลับไม่ต้องโชว์
        $('.xCNRefillNextStep').show(); //ถัดไปต้องโชว์
    });

    //ย้อนกลับไป Step2
    function JSxRVDBackToStep2(){
        $('.xCNRefillVDStep2').click();
        if($('#oetRVDWahTransferCode').val() == '' || $('#oetRVDWahTransferCode').val() == null){
            $('#oetRVDWahTransferName').focus();
        }
        $('#ohdClickStep').val(2);
    }

    //ค้นหาใน Step1
    $("#oetSearchAllStep1").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#otdTBodyTableStep1 tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });

    //โหลดตาราง
    JSvRVDCallTableStep1();
    function JSvRVDCallTableStep1(){
        try{
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                JCNxOpenLoading();
                $.ajax({
                    type    : "POST",
                    url     : "docRVDRefillPDTVDLoadTableStep1",
                    cache   : false,
                    data    : { tDocumentNumber : $('#oetRVDDocNo').val() },
                    timeout : 0,
                    success: function(oResult) {
                        var aReturnData = JSON.parse(oResult);
                        if (aReturnData['nStaEvent'] == '1') {
                            $('#odvContentStep1').html(aReturnData['tViewer']);
                            JCNxCloseLoading();
                        }else {
                            var tMessageError = aReturnData['tStaMessg'];
                            FSvCMNSetMsgErrorDialog(tMessageError);
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(jqXHR, textStatus, errorThrown);
                    }
                });
            }else{
                JCNxShowMsgSessionExpired();
            }
        }catch(err){
            console.log('JSvRVDCallTableStep1 Error: ', err);
        }
    }

    //เพิ่มข้อมูลลงตาราง Temp
    function JSxRVDInsertToTempStep1(){
        $('.xWRVDClearOnShwModal').val('');
        $('#odvRVDConditionConfigRefillPDT').modal('show');
    }

    //กดยืนยันหลังจากได้เงื่อนไขใน Step1 แล้ว
    function JSxConfrimConditionMoveDataToTemp(){
        var tBCHCode = $("#oetRVDConditionBCHCode").val();
        var tMERCode = $("#oetRVDConditionMERCode").val();
        var tSHPCode = $("#oetRVDConditionSHPCode").val();
        var tPOSCode = $("#oetRVDConditionPOSCode").val();

        try{
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                $.ajax({
                    type    : "POST",
                    url     : "docRVDRefillPDTVDInsStep1",
                    data    : {
                        tDocumentNumber : $('#oetRVDDocNo').val(),
                        tBCHCode        : tBCHCode,
                        tMERCode        : tMERCode,
                        tSHPCode        : tSHPCode,
                        tPOSCode        : tPOSCode
                    },
                    cache   : false,
                    timeout : 0,
                    success: function(oResult) {
                        var aResult = JSON.parse(oResult)
                        if(aResult.nStaEvent == 1){
                            JSvRVDCallTableStep1();

                            //ให้ step2 โหลดใหม่
                            $('#ohdRefillVDDontRefresh').val(0);

                            //ถ้ากดยืนยัน ถือว่าเป็นการเลือกสินค้าใหม่
                            $('#ohdClickConfirmPDTStep1').val(1);
                        }else if(aResult.nStaEvent == 500){
                            $('#odvImportPDTInStep1').modal('show');
                        }

                        //ล้างค่าใน localStorage
                        localStorage.removeItem("SetQTYInItem");
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(jqXHR, textStatus, errorThrown);
                    }
                });
            }else{
                JCNxShowMsgSessionExpired();
            }
        }catch(err){
            console.log('JSxConfrimConditionMoveDataToTemp Error: ', err);
        }
    }

    //=========== เลือกสาขา ===========
    $('#obtBrowseConditionBCH').click(function(){
        //ยกเลิก
    });
    var oBrowseRefillVending_Condition_BCH_Option = function(paDataparameter){
        //ยกเลิก
    }
    function JSxNextFuncVending_Condition_BCH_Option(poJsonData){
        //ยกเลิก
    }

    //=========== เลือกกลุ่มธุรกิจ ===========
    $('#obtBrowseConditionMER').click(function(){
        oBrowseRefillVending_Condition_MER = oBrowseRefillVending_Condition_MER_Option({});
        JCNxBrowseData('oBrowseRefillVending_Condition_MER');
        $('#odvRVDConditionConfigRefillPDT').modal('hide');
        $('#ohdModalCenterIsOpen').val(1)
    });
    var oBrowseRefillVending_Condition_MER_Option = function(paDataparameter){
        var oOptionReturn = {
            Title   :   ['merchant/merchant/merchant','tMerchantTitle'],
            Table   :   {Master:'TCNMMerchant', PK:'FTMerCode'},
            Join    :   {
                Table   :	['TCNMMerchant_L'],
                On      :   ['TCNMMerchant.FTMerCode = TCNMMerchant_L.FTMerCode AND TCNMMerchant_L.FNLngID = ' + nLangEdits] 
            },
            GrideView   :  {
                ColumnPathLang	: 'merchant/merchant/merchant',
                ColumnKeyLang	: ['tMCNTBCode','tMCNTBName'],
                ColumnsSize     : ['10%','75%'],
                DataColumns	    : ['TCNMMerchant.FTMerCode','TCNMMerchant_L.FTMerName'],
                DataColumnsFormat : ['',''],
                WidthModal      : 50,
                Perpage			: 10,
                OrderBy			: ['TCNMMerchant.FDCreateOn DESC'],
            },
            CallBack:{
                ReturnType	: 'S',
                Value		: ["oetRVDConditionMERCode","TCNMMerchant.FTMerCode"],
                Text		: ["oetRVDConditionMERName","TCNMMerchant_L.FTMerName"]
            },
            NextFunc    :   {
                FuncName    : 'JSxNextFuncVending_Condition_MER_Option',
                ArgReturn   : ['FTMerCode']
            },
        }
        return oOptionReturn;
    }
    function JSxNextFuncVending_Condition_MER_Option(){
        //เปิด modal เดิม
        $('#odvRVDConditionConfigRefillPDT').modal('show');
    }
   
    //=========== เลือกร้านค้า ===========
    $('#obtBrowseConditionSHP').click(function(){
        oBrowseRefillVending_Condition_SHP = oBrowseRefillVending_Condition_SHP_Option({});
        JCNxBrowseData('oBrowseRefillVending_Condition_SHP');
        $('#odvRVDConditionConfigRefillPDT').modal('hide');
        $('#ohdModalCenterIsOpen').val(1)
    });
    var oBrowseRefillVending_Condition_SHP_Option = function(paDataparameter){
        let tWhereCond  = "";

        let tBchCode    = $('#oetRVDConditionBCHCode').val();
        let tMerCode    = $("#oetRVDConditionMERCode").val();
        if( tMerCode != "" ){
            tWhereCond += " AND TCNMShop.FTMerCode = '"+tMerCode+"' ";
        }

        var oOptionReturn    = {
            Title   :   ["company/shop/shop","tSHPTitle_LAYOUT"],
            Table   :   {Master:"TCNMShop", PK:"FTShpCode"},
            Join    :   {
                Table   : ['TCNMShop_L','TCNMBranch_L'],
                On      : [
                    'TCNMShop_L.FTBchCode = TCNMShop.FTBchCode AND TCNMShop_L.FTShpCode = TCNMShop.FTShpCode AND TCNMShop_L.FNLngID = ' + nLangEdits,
                    'TCNMShop_L.FTBchCode = TCNMBranch_L.FTBchCode AND TCNMBranch_L.FNLngID = '+ nLangEdits
                ]
            },
            Where:{ 
                Condition : [ " AND TCNMShop.FTBchCode = '"+tBchCode+"' " + tWhereCond ]
            },
            GrideView   : {
                ColumnPathLang      : 'company/shop/shop',
                ColumnKeyLang       : ['tShopCode_LAYOUT','tShopName_LAYOUT'],
                ColumnsSize         : ['15%','55%'],
                WidthModal          : 50,
                DataColumns         : ['TCNMShop.FTShpCode','TCNMShop_L.FTShpName'],
                DataColumnsFormat   : ['','',''],
                Perpage             : 10,
                OrderBy			    : ['TCNMShop.FDCreateOn DESC'],
            },
            CallBack: {
                ReturnType	: 'S',
                Value		: ["oetRVDConditionSHPCode","TCNMShop.FTShpCode"],
                Text		: ["oetRVDConditionSHPName","TCNMShop_L.FTShpName"],
            },
            NextFunc    :   {
                FuncName    : 'JSxNextFuncVending_Condition_SHP_Option',
                ArgReturn   : ['FTShpCode']
            },
        }
        return oOptionReturn;
    }
    function JSxNextFuncVending_Condition_SHP_Option(poJsonData){
        if(poJsonData != 'NULL'){
            $('#obtBrowseConditionPOS').attr('disabled',false);

            //ล้างค่า
            $('#oetRVDConditionPOSCode , #oetRVDConditionPOSName').val();
        }else{
            $('#obtBrowseConditionPOS').attr('disabled',true);
        }

        //เปิด modal เดิม
        $('#odvRVDConditionConfigRefillPDT').modal('show');
    }

    //=========== เลือกตู้ขายสินค้า ===========
    $('#obtBrowseConditionPOS').attr('disabled',true);
    $('#obtBrowseConditionPOS').click(function(){
        oBrowseRefillVending_Condition_POS = oBrowseRefillVending_Condition_POS_Option({});
        JCNxBrowseData('oBrowseRefillVending_Condition_POS');
        $('#odvRVDConditionConfigRefillPDT').modal('hide');
        $('#ohdModalCenterIsOpen').val(1)
    });
    var oBrowseRefillVending_Condition_POS_Option = function(paDataparameter){
        var oOptionReturn   = {
            Title   :  ['company/shop/shop', 'tShpType4'],
            Table   :  { Master : 'TVDMPosShop', PK : 'FTPosCode'},
            Join    :  {
                Table   : ['TCNMPos_L'],
                On      : [
                    'TVDMPosShop.FTBchCode = TCNMPos_L.FTBchCode AND TVDMPosShop.FTPosCode = TCNMPos_L.FTPosCode AND TCNMPos_L.FNLngID = ' + nLangEdits,
                ]
            },
            Where:{ 
                Condition : [ " AND TVDMPosShop.FTBchCode = '"+$('#oetRVDConditionBCHCode').val()+"' AND TVDMPosShop.FTShpCode = '"+$('#oetRVDConditionSHPCode').val()+"' "]
            },
            GrideView: {
                ColumnPathLang  : 'pos/posshop/posshop',
                ColumnKeyLang   : ['tPshBRWShopTBCode', 'tPshBRWPosTBName'],
                ColumnsSize     : ['25%', '75%'],
                WidthModal      : 50,
                DataColumns     : ['TVDMPosShop.FTPosCode', 'TCNMPos_L.FTPosName'],
                DataColumnsFormat: ['', ''],
                Perpage         : 10,
                OrderBy         : ['TCNMPos_L.FTPosCode'],
                SourceOrder     : "ASC"
            },
            CallBack: {
                ReturnType  : 'S',
                Value       : ["oetRVDConditionPOSCode", "TCNMPos_L.FTPosCode"],
                Text        : ["oetRVDConditionPOSName", "TCNMPos_L.FTPosName"],
            },
            NextFunc    :   {
                FuncName    : 'JSxNextFuncVending_Condition_POS_Option',
                ArgReturn   : ['FTPosCode']
            },
            // DebugSQL : true
        }
        return oOptionReturn;
    }
    function JSxNextFuncVending_Condition_POS_Option(){
        //เปิด modal เดิม
        $('#odvRVDConditionConfigRefillPDT').modal('show');
    }
</script>