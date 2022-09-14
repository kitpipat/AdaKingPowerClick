<div class="panel panel-headline">
    <div class="panel-heading">
        <section id="ostSearchPromotion">
            <div class="row">
                <div class="col-xs-2 col-md-2">
                    <div class="form-group">
                        <label class="xCNLabelFrm"><?=language('product/pdtcheckprice/pdtcheckprice', 'tPCPSearchDisplay');?></label>
                        <select class="selectpicker form-control" id="ocmPCPDisplayType" name="ocmPCPDisplayType">
                            <option value="1"><?=language('product/pdtcheckprice/pdtcheckprice', 'tPCPSearchDisplay1');?></option>
                            <option value="2"><?=language('product/pdtcheckprice/pdtcheckprice', 'tPCPSearchDisplay2');?></option>
                        </select>
                    </div>
                </div>
                <div class="col-xs-4 col-md-4">
                    <div class="form-group">
                        <label class="xCNLabelFrm"><?=language('common/main/main', 'tSearch'); ?></label>
                        <div class="input-group">
                            <input class="form-control xCNInputWithoutSingleQuote" type="text" id="oetPCPSearchAll"
                                name="oetPCPSearchAll"
                                placeholder="<?= language('document/adjuststocksub/adjuststocksub', 'tAdjStkSubFillTextSearch') ?>"
                                onkeyup="javascript: if(event.keyCode == 13) {JSxPCPGetListPageTable()}"
                                autocomplete="off">
                            <span class="input-group-btn">
                                <button type="button" class="btn xCNBtnDateTime" onclick="JSxPCPGetListPageTable()">
                                    <img
                                        src="<?php echo base_url('application/modules/common/assets/images/icons/search-24.png'); ?>">
                                </button>
                            </span>
                        </div>
                    </div>
                    
                </div>
                <div class="col-xs-6 col-md-6" style="margin-top: 26px;">
                    <a id="oahPCPAdvanceSearch" class="btn xCNBTNDefult xCNBTNDefult1Btn" style="margin-right:10px;" href="javascript:;"><?php echo language('common/main/main', 'tAdvanceSearch'); ?></a>
                    <a id="oahPCPSearchReset" class="btn xCNBTNDefult xCNBTNDefult1Btn" href="javascript:;"><?php echo language('common/main/main', 'tClearSearch'); ?></a>
                </div>
            </div>

            <div class="row hidden" id="odvPCPAdvanceSearchContainer" style="margin-bottom:20px;">
                <div class="col-xs-12 col-md-3 col-lg-3">
                    <div class="col-lg-12 col-md-12 col-xs-12 no-padding">
                        <label
                            class="xCNLabelFrm"><?php echo language('product/pdtcheckprice/pdtcheckprice', 'tFromProduct'); ?></label>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <input class="form-control xCNHide" id="oetPCPPdtCodeFrom" name="oetPCPPdtCodeFrom"
                                maxlength="5">
                            <input class="form-control xWPointerEventNone" type="text" id="oetPCPPdtNameFrom"
                                name="oetPCPPdtNameFrom"
                                placeholder="<?php echo language('product/pdtcheckprice/pdtcheckprice', 'tFromProduct'); ?>"
                                readonly>
                            <span class="input-group-btn">
                                <button id="obtPCPBrowsePdtFrom" type="button" class="btn xCNBtnBrowseAddOn">
                                    <img
                                        src="<?php echo base_url() . 'application/modules/common/assets/images/icons/find-24.png' ?>">
                                </button>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="col-xs-12 col-md-3 col-lg-3">
                    <div class="col-lg-12 col-md-12 col-xs-12 no-padding">
                        <label
                            class="xCNLabelFrm"><?php echo language('product/pdtcheckprice/pdtcheckprice', 'tToProduct'); ?></label>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <input class="form-control xCNHide" id="oetPCPPdtCodeTo" name="oetPCPPdtCodeTo"
                                maxlength="5">
                            <input class="form-control xWPointerEventNone" type="text" id="oetPCPPdtNameTo"
                                name="oetPCPPdtNameTo"
                                placeholder="<?php echo language('product/pdtcheckprice/pdtcheckprice', 'tToProduct'); ?>"
                                readonly>

                            <span class="input-group-btn">
                                <button id="obtPCPBrowsePdtTo" type="button" class="btn xCNBtnBrowseAddOn">
                                    <img
                                        src="<?php echo base_url() . 'application/modules/common/assets/images/icons/find-24.png' ?>">
                                </button>
                            </span>
                        </div>
                    </div>
                </div>


                <div class="col-xs-12 col-md-3 col-lg-3">
                    <div class="col-lg-12 col-md-12 col-xs-12 no-padding">
                        <label
                            class="xCNLabelFrm"><?php echo language('product/pdtcheckprice/pdtcheckprice', 'tFromDocDate'); ?></label>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <input class="form-control input100 xCNDatePicker" type="text" id="oetPCPSearchDocDateFrom"
                                name="oetPCPSearchDocDateFrom"
                                placeholder="<?php echo language('product/pdtcheckprice/pdtcheckprice', 'tFromDocDate'); ?>">
                            <span class="input-group-btn">
                                <button id="obtPCPSearchDocDateFrom" type="button" class="btn xCNBtnDateTime">
                                    <img
                                        src="<?php echo base_url(); ?>application/modules/common/assets/images/icons/icons8-Calendar-100.png">
                                </button>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="col-xs-12 col-md-3 col-lg-3">
                    <div class="col-lg-12 col-md-12 col-xs-12 no-padding">
                        <label
                            class="xCNLabelFrm"><?php echo language('product/pdtcheckprice/pdtcheckprice', 'tToDocDate'); ?></label>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <input class="form-control input100 xCNDatePicker" type="text" id="oetPCPSearchDocDateTo"
                                name="oetPCPSearchDocDateTo"
                                placeholder="<?php echo language('product/pdtcheckprice/pdtcheckprice', 'tToDocDate'); ?>">
                            <span class="input-group-btn">
                                <button id="obtPCPSearchDocDateTo" type="button" class="btn xCNBtnDateTime">
                                    <img
                                        src="<?php echo base_url(); ?>application/modules/common/assets/images/icons/icons8-Calendar-100.png">
                                </button>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-md-3 col-lg-3">
                    <div class="col-lg-12 col-md-12 col-xs-12 no-padding">
                        <label
                            class="xCNLabelFrm"><?php echo language('product/pdtcheckprice/pdtcheckprice', 'tPCPUnitPdtFrom'); ?></label>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <input class="form-control xCNHide" id="oetPCPPunCodeFrom" name="oetPCPPunCodeFrom" maxlength="5">
                            <input class="form-control xWPointerEventNone" type="text" id="oetPCPPunNameFrom" name="oetPCPPunNameFrom"
                                placeholder="<?php echo language('product/pdtcheckprice/pdtcheckprice', 'tPCPUnitPdtFrom'); ?>"
                                readonly>
                            <span class="input-group-btn">
                                <button id="obtPCPBrowsePunFrom" type="button" class="btn xCNBtnBrowseAddOn">
                                    <img
                                        src="<?php echo base_url() . 'application/modules/common/assets/images/icons/find-24.png' ?>">
                                </button>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-md-3 col-lg-3">
                    <div class="col-lg-12 col-md-12 col-xs-12 no-padding">
                        <label
                            class="xCNLabelFrm"><?php echo language('product/pdtcheckprice/pdtcheckprice', 'tPCPUnitPdtTo'); ?></label>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <input class="form-control xCNHide" id="oetPCPPunCodeTo" name="oetPCPPunCodeTo" maxlength="5">
                            <input class="form-control xWPointerEventNone" type="text" id="oetPCPPunNameTo" name="oetPCPPunNameTo"
                                placeholder="<?php echo language('product/pdtcheckprice/pdtcheckprice', 'tPCPUnitPdtTo'); ?>"
                                readonly>
                            <span class="input-group-btn">
                                <button id="obtPCPBrowsePunTo" type="button" class="btn xCNBtnBrowseAddOn">
                                    <img
                                        src="<?php echo base_url() . 'application/modules/common/assets/images/icons/find-24.png' ?>">
                                </button>
                            </span>
                        </div>
                    </div>
                </div>
                
                <div class="col-xs-12 col-md-3 col-lg-3">
                    <div class="col-lg-12 col-md-12 col-xs-12 no-padding">
                        <label class="xCNLabelFrm"><?php echo language('product/pdtcheckprice/pdtcheckprice', 'tPCPPplFrom'); ?></label>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <input class="form-control xCNHide" id="oetPCPPplCodeFrom" name="oetPCPPplCodeFrom" maxlength="5">
                            <input class="form-control xWPointerEventNone" type="text" id="oetPCPPplNameFrom"name="oetPCPPplNameFrom" readonly
                                placeholder="<?php echo language('product/pdtcheckprice/pdtcheckprice', 'tPCPPplFrom'); ?>"
                            >
                            <span class="input-group-btn">
                                <button id="obtPCPBrowsePplFrom" type="button" class="btn xCNBtnBrowseAddOn">
                                    <img src="<?php echo base_url() . 'application/modules/common/assets/images/icons/find-24.png' ?>">
                                </button>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-md-3 col-lg-3">
                    <div class="col-lg-12 col-md-12 col-xs-12 no-padding">
                        <label class="xCNLabelFrm"><?php echo language('product/pdtcheckprice/pdtcheckprice', 'tPCPPplTo'); ?></label>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <input class="form-control xCNHide" id="oetPCPPplCodeTo" name="oetPCPPplCodeTo" maxlength="5">
                            <input class="form-control xWPointerEventNone" type="text" id="oetPCPPplNameTo" name="oetPCPPplNameTo" readonly
                                placeholder="<?php echo language('product/pdtcheckprice/pdtcheckprice', 'tPCPPplTo'); ?>"
                            >
                            <span class="input-group-btn">
                                <button id="obtPCPBrowsePplTo" type="button" class="btn xCNBtnBrowseAddOn">
                                    <img src="<?php echo base_url() . 'application/modules/common/assets/images/icons/find-24.png' ?>">
                                </button>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12">
                    <a id="oahPCPAdvanceSearchSubmit" class="btn xCNBTNPrimery pull-right"
                        href="javascript:;"
                        onclick="JSxPCPGetListPageTable()"><?php echo language('common/main/main', 'tSearch'); ?></a>
                </div>
            </div>
        </section>
    </div>
    <div class="panel-body">
        <section id="ostPCPDataTableDocument">
        </section>
    </div>
</div>

<!-- <script src="<?php echo  base_url('application/modules/common/assets/js/jquery.mask.js')?>"></script>
<script src="<?php echo  base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script> -->
<script>
$(document).ready(function() {
    $('.selectpicker').selectpicker();

    $('#obtPCPSearchDocDateFrom').click(function() {
        event.preventDefault();
        $('#oetPCPSearchDocDateFrom').datepicker('show');
    });

    $('#obtPCPSearchDocDateTo').click(function() {
        event.preventDefault();
        $('#oetPCPSearchDocDateTo').datepicker('show');
    });

    $('.xCNDatePicker').datepicker({
        format: 'yyyy-mm-dd',
        todayHighlight: true
    });

    $(".selection-2").select2({
        // minimumResultsForSearch: 20,
        dropdownParent: $('#dropDownSelect1')
    });
});

$('#oahPCPAdvanceSearch').on('click', function() {
    if ($('#odvPCPAdvanceSearchContainer').hasClass('hidden')) {
        $('#odvPCPAdvanceSearchContainer').removeClass('hidden fadeIn').addClass('fadeIn');
    } else {
        $('#odvPCPAdvanceSearchContainer').addClass('hidden fadeIn');
    }
});

var nLangEdits = '<?php echo $this->session->userdata("tLangEdit");?>';

//Browse Product
var oPCPBrowsePdt = function(poReturnInput) {
    var tInputReturnCode = poReturnInput.tReturnInputCode;
    var tInputReturnName = poReturnInput.tReturnInputName;

    let tAgnCode     = '<?php echo $this->session->userdata("tSesUsrAgnCode"); ?>';
    let tCondition ='';
    if( tAgnCode != '' ){
        tCondition += " AND TCNMPdtSpcBch.FTAgnCode = '"+tAgnCode+"' ";
    }

    var oOptionReturn = {
        
        Title: ['product/product/product', 'tPDTTitle'],
        Table: {
            Master: 'TCNMPdt',
            PK: 'FTPdtCode'
        },
        Join: {
            Table: ['TCNMPdt_L','TCNMPdtSpcBch'],
            On: ['TCNMPdt_L.FTPdtCode = TCNMPdt.FTPdtCode AND TCNMPdt_L.FNLngID = ' + nLangEdits, 
                'TCNMPdtSpcBch.FTPdtCode = TCNMPdt.FTPdtCode'
            ]
        },
        Where:{
            Condition : [tCondition]
        },
        GrideView: {
            ColumnPathLang: 'product/product/product',
            ColumnKeyLang: ['tPDTCode', 'tPDTName'],
            ColumnsSize: ['15%', '75%'],
            WidthModal: 50,
            DataColumns: ['TCNMPdt.FTPdtCode', 'TCNMPdt_L.FTPdtName'],
            DataColumnsFormat: ['', ''],
            Perpage: 10,
            OrderBy: ['TCNMPdt.FDCreateOn DESC'],
            IgnoreRow: 1
        },
        CallBack: {
            ReturnType: 'S',
            Value: [tInputReturnCode, "TCNMPdt.FTPdtCode"],
            Text: [tInputReturnName, "TCNMPdt_L.FTPdtName"],
        },
        NextFunc: {
            FuncName: 'FSxPCPSetBrowsePdtTo',
            ArgReturn: ['FTPdtCode', 'FTPdtName']
        },
        // DebugSQL: true,
    }
    return oOptionReturn;
};

function FSxPCPSetBrowsePdtTo(oArgReturn) {
    if( oArgReturn != "NULL" ){
        var aArgReturn = JSON.parse(oArgReturn)
        if ($('#oetPCPPdtCodeTo').val() == '') {
            $('#oetPCPPdtCodeTo').val(aArgReturn[0]);
            $('#oetPCPPdtNameTo').val(aArgReturn[1]);
        }
        if ($('#oetPCPPdtCodeFrom').val() == '') {
            $('#oetPCPPdtCodeFrom').val(aArgReturn[0]);
            $('#oetPCPPdtNameFrom').val(aArgReturn[1]);
        }
    }
}

//Browse หน่วยสินค้า
var oPCPBrowseUnit = function(poReturnInput) {
    var tInputReturnCode = poReturnInput.tReturnInputCode;
    var tInputReturnName = poReturnInput.tReturnInputName;

    let tCondition ='';
    let tAgnCode     = '<?php echo $this->session->userdata("tSesUsrAgnCode"); ?>';

    if(tAgnCode != ''){
        tCondition += " AND TCNMPdtUnit.FTAgnCode = '"+tAgnCode+"' ";
    }

    var oOptionReturn = {
        Title: ['product/pdtunit/pdtunit', 'tPUNTitle'],
        Table: {
            Master: 'TCNMPdtUnit',
            PK: 'FTPunCode'
        },
        Join: {
            Table: ['TCNMPdtUnit_L'],
            On: ['TCNMPdtUnit_L.FTPunCode = TCNMPdtUnit.FTPunCode AND TCNMPdtUnit_L.FNLngID = ' + nLangEdits, ]
        },
        Where:{
            Condition : [tCondition]
        },
        GrideView: {
            ColumnPathLang: 'product/pdtunit/pdtunit',
            ColumnKeyLang: ['tPUNFrmPunCode', 'tPUNFrmPunName'],
            ColumnsSize: ['15%', '75%'],
            WidthModal: 50,
            DataColumns: ['TCNMPdtUnit.FTPunCode', 'TCNMPdtUnit_L.FTPunName'],
            DataColumnsFormat: ['', ''],
            Perpage: 10,
            OrderBy: ['TCNMPdtUnit.FDCreateOn DESC'],
        },
        CallBack: {
            ReturnType: 'S',
            Value: [tInputReturnCode, "TCNMPdtUnit.FTPunCode"],
            Text: [tInputReturnName, "TCNMPdtUnit_L.FTPunName"],
        },
        NextFunc: {
            FuncName: 'FSxPCPCallBackBrowseUnit',
            ArgReturn: ['FTPunCode', 'FTPunName']
        },
        // DebugSQL: true,
    }
    return oOptionReturn;
};

function FSxPCPCallBackBrowseUnit(oArgReturn) {
    if( oArgReturn != "NULL" ){
        var aArgReturn = JSON.parse(oArgReturn)
        if ($('#oetPCPPunCodeTo').val() == '') {
            $('#oetPCPPunCodeTo').val(aArgReturn[0]);
            $('#oetPCPPunNameTo').val(aArgReturn[1]);
        }
        if ($('#oetPCPPunCodeFrom').val() == '') {
            $('#oetPCPPunCodeFrom').val(aArgReturn[0]);
            $('#oetPCPPunNameFrom').val(aArgReturn[1]);
        }
    }
}

//Browse กลุ่มราคาสินค้า
var oPCPBrowsePpl = function(poReturnInput) {
    var tInputReturnCode = poReturnInput.tReturnInputCode;
    var tInputReturnName = poReturnInput.tReturnInputName;

    let tAgnCode     = '<?php echo $this->session->userdata("tSesUsrAgnCode"); ?>';

    let tCondition ='';
    if(tAgnCode != ''){
        tCondition += " AND TCNMPdtPriList.FTAgnCode = '"+tAgnCode+"' ";
    }

    var oOptionReturn = {
        Title: ['product/pdtpricelist/pdtpricelist', 'tPPLTitle'],
        Table: {
            Master: 'TCNMPdtPriList',
            PK: 'FTPplCode'
        },
        Join: {
            Table: ['TCNMPdtPriList_L'],
            On: ['TCNMPdtPriList_L.FTPplCode = TCNMPdtPriList.FTPplCode AND TCNMPdtPriList_L.FNLngID = ' +
                nLangEdits,
            ]
        },
        Where: {
            Condition: [tCondition + " UNION SELECT '1' ,'NA','ไม่กำหนดกลุ่มราคา' " ]
        },
        GrideView: {
            ColumnPathLang: 'product/pdtpricelist/pdtpricelist',
            ColumnKeyLang: ['tPPLTBCode', 'tPPLTBName'],
            ColumnsSize: ['15%', '75%'],
            WidthModal: 50,
            DataColumns: ['TCNMPdtPriList.FTPplCode', 'TCNMPdtPriList_L.FTPplName'],
            DataColumnsFormat: ['', ''],
            Perpage: 10,
            OrderBy: ['TCNMPdtPriList.FDCreateOn DESC'],
            StartRow: 1
        },
        CallBack: {
            ReturnType: 'S',
            Value: [tInputReturnCode, "TCNMPdtPriList.FTPplCode"],
            Text: [tInputReturnName, "TCNMPdtPriList_L.FTPplName"],
        },
        NextFunc: {
            FuncName: 'FSxPCPCallBackBrowsePpl',
            ArgReturn: ['FTPplCode', 'FTPplName']
        },
        // DebugSQL: true,
    }
    return oOptionReturn;
};

function FSxPCPCallBackBrowsePpl(oArgReturn) {
    if( oArgReturn != "NULL" ){
        var aArgReturn = JSON.parse(oArgReturn)
        if ($('#oetPCPPplCodeTo').val() == '') {
            $('#oetPCPPplCodeTo').val(aArgReturn[0]);
            $('#oetPCPPplNameTo').val(aArgReturn[1]);
        }
        if ($('#oetPCPPplCodeFrom').val() == '') {
            $('#oetPCPPplCodeFrom').val(aArgReturn[0]);
            $('#oetPCPPplNameFrom').val(aArgReturn[1]);
        }
    }
}


$('#obtPCPBrowsePdtFrom').unbind().click(function() {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
        JSxCheckPinMenuClose();
        window.oPCPBrowsePdtToOption = oPCPBrowsePdt({
            'tReturnInputCode': 'oetPCPPdtCodeFrom',
            'tReturnInputName': 'oetPCPPdtNameFrom'
        });
        JCNxBrowseData('oPCPBrowsePdtToOption');
    } else {
        JCNxShowMsgSessionExpired();
    }
});

$('#obtPCPBrowsePdtTo').unbind().click(function() {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
        JSxCheckPinMenuClose();
        window.oPCPBrowsePdtToOption = oPCPBrowsePdt({
            'tReturnInputCode': 'oetPCPPdtCodeTo',
            'tReturnInputName': 'oetPCPPdtNameTo'
        });
        JCNxBrowseData('oPCPBrowsePdtToOption');
    } else {
        JCNxShowMsgSessionExpired();
    }
});

$('#obtPCPBrowsePunFrom').unbind().click(function() {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
        JSxCheckPinMenuClose();
        window.oPCPBrowsePunOption = oPCPBrowseUnit({
            'tReturnInputCode': 'oetPCPPunCodeFrom',
            'tReturnInputName': 'oetPCPPunNameFrom'
        });
        JCNxBrowseData('oPCPBrowsePunOption');
    } else {
        JCNxShowMsgSessionExpired();
    }
});

$('#obtPCPBrowsePunTo').unbind().click(function() {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
        JSxCheckPinMenuClose();
        window.oPCPBrowsePunOption = oPCPBrowseUnit({
            'tReturnInputCode': 'oetPCPPunCodeTo',
            'tReturnInputName': 'oetPCPPunNameTo'
        });
        JCNxBrowseData('oPCPBrowsePunOption');
    } else {
        JCNxShowMsgSessionExpired();
    }
});

$('#obtPCPBrowsePplFrom').unbind().click(function() {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
        JSxCheckPinMenuClose();
        window.oPCPBrowsePplOption = oPCPBrowsePpl({
            'tReturnInputCode': 'oetPCPPplCodeFrom',
            'tReturnInputName': 'oetPCPPplNameFrom'
        });
        JCNxBrowseData('oPCPBrowsePplOption');
    } else {
        JCNxShowMsgSessionExpired();
    }
});

$('#obtPCPBrowsePplTo').unbind().click(function() {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
        JSxCheckPinMenuClose();
        window.oPCPBrowsePplOption = oPCPBrowsePpl({
            'tReturnInputCode': 'oetPCPPplCodeTo',
            'tReturnInputName': 'oetPCPPplNameTo'
        });
        JCNxBrowseData('oPCPBrowsePplOption');
    } else {
        JCNxShowMsgSessionExpired();
    }
});

//ล้างข้อมูลการค้นหา
$('#oahPCPSearchReset').unbind().click(function() {
    $('#oetPCPSearchAll').val('');

    $('#oetPCPPdtCodeFrom').val('');
    $('#oetPCPPdtCodeTo').val('');
    $('#oetPCPPdtNameFrom').val('');
    $('#oetPCPPdtNameTo').val('');

    $('#oetPCPPunNameFrom').val('');
    $('#oetPCPPunCodeFrom').val('');
    $('#oetPCPPunNameTo').val('');
    $('#oetPCPPunCodeTo').val('');

    $('#oetPCPPplCodeFrom').val('');
    $('#oetPCPPplNameFrom').val('');
    $('#oetPCPPplCodeTo').val('');
    $('#oetPCPPplNameTo').val('');

    $(".xCNDatePicker").datepicker("setDate", null);
    // $("#ocmPCPPdtPriList")
    //     .val("0")
    //     .selectpicker("refresh");
    JSxPCPGetListPageTable();
});

$('#oetPCPSearchDocDateFrom').change(function() {
    if ($('#oetPCPSearchDocDateTo').val() == '') {
        $('#oetPCPSearchDocDateTo').val($('#oetPCPSearchDocDateFrom').val());
    }
});

$('#ocmPCPDisplayType').change(function(){
    JSxPCPGetListPageTable();
});
</script>