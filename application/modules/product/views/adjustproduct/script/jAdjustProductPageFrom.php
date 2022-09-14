<script>
$(function(){
    $('.selectpicker').selectpicker();
    JSxAPJSetOptionsTable();
    localStorage.removeItem("LocalItemData");
    localStorage.removeItem("Ada.ProductListCenter");
    JSxAPJFilterDataToTemp();
});

    var tBaseURL = '<?php echo base_url(); ?>';
    var nLangEdits = '<?php echo $this->session->userdata("tLangEdit") ?>';

function JSxAPJSetOptionsTable(){

      let tTable = $('#ocmAJPSelectTable').val();
      $('#ocmAJPSelectField option').remove();
      $('#ocmAJPSelectField').append(JStAJPGetOptionFieldHtml(tTable)).selectpicker('refresh');
      $('#ocmAJPSelectField').val($('#ocmAJPSelectField option').first().val()).selectpicker('refresh');
      
      let tField = $('#ocmAJPSelectField').val();
      $('#ocmAJPSelectValue option').remove();
      $('#ocmAJPSelectValue').append(JStAJPGetOptionValueHtml(tField)).selectpicker('refresh');
      $('#ocmAJPSelectValue').val($('#ocmAJPSelectValue option').first().val()).selectpicker('refresh');
      JSxAPJFilterDataToTemp();
}

function JSxAPJSetOptionsField(){
    let tField = $('#ocmAJPSelectField').val();
      $('#ocmAJPSelectValue option').remove();
      $('#ocmAJPSelectValue').append(JStAJPGetOptionValueHtml(tField)).selectpicker('refresh');
      $('#ocmAJPSelectValue').val($('#ocmAJPSelectValue option').first().val()).selectpicker('refresh');
}



$('#ocmAJPSelectTable').on('change',function(){
    JSxAPJSetOptionsTable();
});

$('#ocmAJPSelectField').on('change',function(){
    JSxAPJSetOptionsField();
});

$('#obtMainAdjustProductFilter').on('click',function(){
    JSxAPJFilterDataToTemp();
});

$('#obtMainAlertConfirmUpdate').click(function(){
    $('#ospAJPCoutTotalSelecet').text($('#ohdAJPCountSelectRow').val());
    $('#odvAJPModalConfirmUpdate').modal('show');
});


$('#obtMainSaveAdjustProduct').click(function(){
    var nStaSession = JCNxFuncChkSessionExpired();
    JCNxOpenLoading();
    var aItem = [JSON.parse(localStorage.getItem("aItemCheckByProduct"))];
    if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
        $.ajax({
            type: "POST",
            url: "adjustProductEventUpdate",
            data : {
                tAJPSelectTable : $('#ocmAJPSelectTable').val(),
                tAJPSelectField : $('#ocmAJPSelectField').val(),
                tAJPSelectValue : $('#ocmAJPSelectValue').val(),
                aItem           : aItem
            },
            cache: false,
            timeout: 0,
            success: function(oResult) {
                var aResult = JSON.parse(oResult);
                if(aResult['rtCode']=='1'){
                    FSvCMNSetMsgSucessDialog(aResult['rtDesc']);
                }else{
                    FSvCMNSetMsgWarningDialog(aResult['rtDesc']);
                }
                $('#odvAJPModalConfirmUpdate').modal('hide');
                JCNxCloseLoading();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    } else {
        JCNxShowMsgSessionExpired();
    }
});

function JSxAPJUpdateStaAlw(paData){
    var nStaSession = JCNxFuncChkSessionExpired();
    JCNxOpenLoading();
    if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
        $.ajax({
            type: "POST",
            url: "adjustProductEventEditRowIDInTemp",
            data: paData,
            cache: false,
            timeout: 0,
            success: function(oResult) {
                JCNxCloseLoading();
                var aResult = JSON.parse(oResult);
                if(aResult['rtCode']=='1'){
                    $('#ohdAJPCountSelectRow').val(aResult['rnCountRow']);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    } else {
        JCNxShowMsgSessionExpired();
    }
}

function JSxAPJUpdateStaAlwAll(paData){
    var nStaSession = JCNxFuncChkSessionExpired();
    JCNxOpenLoading();
    if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
        $.ajax({
            type: "POST",
            url: "adjustProductEventEditRowAllInTemp",
            data: paData,
            cache: false,
            timeout: 0,
            success: function(oResult) {
                JCNxCloseLoading();
                var aResult = JSON.parse(oResult);
                console.log(aResult);
                if(aResult['rtCode']=='1'){
                    $('#ohdAJPCountSelectRow').val(aResult['rnCountRow']);
                }
                // JSxAPJCallDataTable(1);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    } else {
        JCNxShowMsgSessionExpired();
    }
}

function JSxAPJFilterDataToTemp(){
    var nStaSession = JCNxFuncChkSessionExpired();
    JCNxOpenLoading();
    if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
        $.ajax({
            type: "POST",
            url: "adjustProductDumpDataToTemp",
            data: $('#ofmAdjustProduct').serialize(),
            cache: false,
            timeout: 0,
            success: function(oResult) {
                var aResult = JSON.parse(oResult);
                // if(aResult['rtCode']=='1'){
                    JSxAPJCallDataTable();
                // }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    } else {
        JCNxShowMsgSessionExpired();
    }
}


function JSxAPJCallDataTable(pnPage){
    var nStaSession = JCNxFuncChkSessionExpired();
    JCNxOpenLoading();
    if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
    var nPageCurrent = pnPage;
    if(typeof(nPageCurrent) == undefined || nPageCurrent == "") {
        nPageCurrent = "1";
    }
        $.ajax({
            type: "POST",
            url: "adjustProductDataTable",
            data: {
                nPageCurrent    : nPageCurrent,
                ocmAJPSelectTable : $('#ocmAJPSelectTable').val(),
                ocmAJPSelectField : $('#ocmAJPSelectField').val(),
                ocmAJPSelectValue : $('#ocmAJPSelectValue').val(),
                nPagePDTAll: $('#nPagePDTAll').val()
            },
            cache: false,
            timeout: 0,
            success: function(tView) {
                $('#odvAJPDataTable').html(tView);
                JCNxCloseLoading();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    } else {
        JCNxShowMsgSessionExpired();
    }
}

//Functionality : เปลี่ยนหน้า pagenation
//Parameters : Event Click Pagenation
//Creator : 17/10/2018 witsarut
//Return : View
//Return Type : View
function JSvAJPClickPage(ptPage) {
    var nPageCurrent = '';
    switch (ptPage) {
        case 'next': //กดปุ่ม Next
            $('.xWBtnNext').addClass('disabled');
            nPageOld = $('.xWPagePdtPbn .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
            nPageCurrent = nPageNew
            break;
        case 'previous': //กดปุ่ม Previous
            nPageOld = $('.xWPagePdtPbn .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
            nPageCurrent = nPageNew
            break;
        default:
            nPageCurrent = ptPage
    }
    JCNxOpenLoading();
    JSxAPJCallDataTable(nPageCurrent);
}

function JStAJPGetOptionFieldHtml(ptTable){
    let tHTML = "";
    switch(ptTable) {
        case 'TCNMPdt':
            tHTML +='<option value="FTPdtPoint"><?= language('product/product/product','tAdjPdtStaPoint')?></option>';
            tHTML +='<option value="FTPdtStaAlwDis"><?= language('product/product/product','tAdjPdtStaDis')?></option>';
            tHTML +='<option value="FTPdtStaVat"><?= language('product/product/product','tAdjPdtStaVat')?></option>';
            tHTML +='<option value="FTPdtStaActive"><?= language('product/product/product','tAdjPdtStaAvtive')?></option>';
            tHTML +='<option value="FTPdtStaLot"><?= language('product/product/product','tAdjPdtStaAlwDot')?></option>';
            tHTML +='<option value="FTPdtStaAlwBook"><?= language('product/product/product','tAdjPdtStaAlwRent')?></option>';
            tHTML +='<option value="FTPdtStaAlwReturn"><?= language('product/product/product','tAdjPdtStaAlwReturn')?></option>';
            tHTML +='<option value="FTPdtStaAlwWHTax"><?= language('product/product/product','tAdjPdtStaAlwCutVat')?></option>';
        break;
        case 'TCNMPdtPackSize':
            tHTML +='<option value="FTPdtStaAlwPick"><?= language('product/product/product','tAdjPdtStaPO')?></option>';
            tHTML +='<option value="FTPdtStaAlwPoHQ"><?= language('product/product/product','tAdjPdtStaAlwHQ')?></option>';
            tHTML +='<option value="FTPdtStaAlwBuy"><?= language('product/product/product','tAdjPdtStaAlwPO')?></option>';
            tHTML +='<option value="FTPdtStaAlwSale"><?= language('product/product/product','tAdjPdtStaAlwSale')?></option>';
        break;
        case 'TCNMPdtBar':
            tHTML +='<option class="xOption TCNMPdtBar" value="FTBarStaUse"><?= language('product/product/product','tAdjPdtStaAlwUse')?></option>';
            tHTML +='<option class="xOption TCNMPdtBar" value="FTBarStaAlwSale"><?= language('product/product/product','tAdjPdtStaAlwSale')?></option>';
        break;
    }

    return tHTML;
}

function JStAJPGetOptionValueHtml(ptField){
    let tHTML = "";
            tHTML +='<option value=""><?= language('product/product/product','tAdjPdtNull')?></option>';
    switch(ptField) {
        case 'FTPdtPoint':
            tHTML +='<option value="1"><?= language('product/product/product','tAdjPdtStaPoint1')?></option>';
            tHTML +='<option value="2"><?= language('product/product/product','tAdjPdtStaPoint2')?></option>';
        break;
        case 'FTPdtStaAlwDis':
            tHTML +='<option value="1"><?= language('product/product/product','tAdjPdtStaAlw1')?></option>';
            tHTML +='<option value="2"><?= language('product/product/product','tAdjPdtStaAlw2')?></option>';
        break;
        case 'FTPdtStaVat':
            tHTML +='<option value="1"><?= language('product/product/product','tAdjPdtStaHave1')?></option>';
            tHTML +='<option value="2"><?= language('product/product/product','tAdjPdtStaHave2')?></option>';
        break;
        case 'FTPdtStaActive':
            tHTML +='<option value="1"><?= language('product/product/product','tAdjPdtStaEnable1')?></option>';
            tHTML +='<option value="2"><?= language('product/product/product','tAdjPdtStaEnable2')?></option>';
        break;
        case 'FTPdtStaAlwPick':
            tHTML +='<option value="1"><?= language('product/product/product','tAdjPdtStaAlw1')?></option>';
            tHTML +='<option value="2"><?= language('product/product/product','tAdjPdtStaAlw2')?></option>';
        break;
        case 'FTPdtStaLot':
            tHTML +='<option value="1"><?= language('product/product/product','tAdjPdtStaAlw1')?></option>';
            tHTML +='<option value="2"><?= language('product/product/product','tAdjPdtStaAlw2')?></option>';
        break;
        case 'FTPdtStaAlwBook':
            tHTML +='<option value="1"><?= language('product/product/product','tAdjPdtStaAlw1')?></option>';
            tHTML +='<option value="2"><?= language('product/product/product','tAdjPdtStaAlw2')?></option>';
        break;
        case 'FTPdtStaAlwReturn':
            tHTML +='<option value="1"><?= language('product/product/product','tAdjPdtStaAlw1')?></option>';
            tHTML +='<option value="2"><?= language('product/product/product','tAdjPdtStaAlw2')?></option>';
        break;
        case 'FTPdtStaAlwWHTax':
            tHTML +='<option value="1"><?= language('product/product/product','tAdjPdtStaAlw1')?></option>';
            tHTML +='<option value="2"><?= language('product/product/product','tAdjPdtStaAlw2')?></option>';
        break;
        case 'FTPdtStaAlwPoHQ':
            tHTML +='<option value="1"><?= language('product/product/product','tAdjPdtStaAlw1')?></option>';
            tHTML +='<option value="2"><?= language('product/product/product','tAdjPdtStaAlw2')?></option>';
        break;
        case 'FTPdtStaAlwBuy':
            tHTML +='<option value="1"><?= language('product/product/product','tAdjPdtStaAlw1')?></option>';
            tHTML +='<option value="2"><?= language('product/product/product','tAdjPdtStaAlw2')?></option>';
        break;
        case 'FTPdtStaAlwSale':
            case 'FTPdtStaAlwBuy':
            tHTML +='<option value="1"><?= language('product/product/product','tAdjPdtStaAlw1')?></option>';
            tHTML +='<option value="2"><?= language('product/product/product','tAdjPdtStaAlw2')?></option>';
        break;
        case 'FTBarStaUse':
            tHTML +='<option value="1"><?= language('product/product/product','tAdjPdtStaAlwUse1')?></option>';
            tHTML +='<option value="2"><?= language('product/product/product','tAdjPdtStaAlwUse2')?></option>';
        break;
        case 'FTBarStaAlwSale':
            case 'FTPdtStaAlwBuy':
            tHTML +='<option value="1"><?= language('product/product/product','tAdjPdtStaAlw1')?></option>';
            tHTML +='<option value="2"><?= language('product/product/product','tAdjPdtStaAlw2')?></option>';
        break;
    }

    return tHTML;
}


function JSxClearConditionAll() {
        <?php if($this->session->userdata('tSesUsrAgnCode')==''){  ?>
            $('#oetAJPAgnCode').val('');
            $('#oetAJPAgnName').val('');
        <?php } ?>
        <?php if(FCNbUsrIsAgnLevel()){  ?>
            $('#oetAJPBchCode').val('');
            $('#oetAJPBchName').val('');
        <?php } ?>
            $('#oetAJPPdtCodeFrom').val('');
            $('#oetAJPPdtNameFrom').val('');

            $('#oetAJPPdtCodeTo').val('');
            $('#oetAJPPdtNameTo').val('');

            $('#oetAJPPdtCodeTo').val('');
            $('#oetAJPPdtNameTo').val('');

            $('#oetAJPPgpCode').val('');
            $('#oetAJPPgpName').val('');

            $('#oetAJPPbnCode').val('');
            $('#oetAJPPbnName').val('');

            $('#oetAJPPmoCode').val('');
            $('#oetAJPPmoName').val('');

            $('#oetAJPPtyCode').val('');
            $('#oetAJPPtyName').val('');

            $('#ocmAJPStaAlwPoHQ').val('').selectpicker('refresh');

            localStorage.removeItem("LocalItemData");
            localStorage.removeItem("Ada.ProductListCenter");
    }


$('#obtAJPBrowsPdtFrom').click(function(){
    JSxAPJBrowsePdt('from');
});

$('#obtAJPBrowsPdtTo').click(function(){
    JSxAPJBrowsePdt('to');
});


/*
function : Function Browse Pdt
Parameters : Error Ajax Function 
Creator : 22/05/2019 Piya(Tiger)
Return : Modal Status Error
Return Type : view
*/
function JSxAPJBrowsePdt(ptType) {
    $('#odvModalDOCPDT').modal({backdrop: 'static', keyboard: false});
    if(ptType == 'from'){
        tNextFunc = 'JSxAPJBrowsePdtFrom';
    }else{
        tNextFunc = 'JSxAPJBrowsePdtTo';
    }
    if(localStorage.getItem("Ada.ProductListCenter") === null){
        localStorage.setItem("Ada.ProductListCenter",true);
        var dTime               = new Date();
        var dTimelocalStorage   = dTime.getTime();

        $.ajax({
            type: "POST",
            url: "BrowseDataPDT",
            data: {
                'Qualitysearch'   : ['SUP','NAMEPDT','CODEPDT','FromToBCH','FromToSHP','FromToPGP','FromToPTY'],
                'PriceType'       : ['Pricesell'],
                'SelectTier'      : ['PDT'],//PDT, Barcode
                // 'Elementreturn'   : ['oetASTFilterPdtCodeFrom','oetASTFilterPdtNameFrom'],
                'ShowCountRecord' : 10,
                'NextFunc'        : tNextFunc,
                'ReturnType'      : 'S', //S = Single M = Multi
                'SPL'             : ['',''],
                'BCH'             : [$('#oetAJPBchCode').val(),''],//Code, Name
                'SHP'             : ['',''],
                'TimeLocalstorage': dTimelocalStorage
            },
            cache: false,
            timeout: 0,
            success: function(tResult){
                // $('#odvModalDOCPDT').modal({backdrop: 'static', keyboard: false})  
                $('#odvModalDOCPDT').modal({ show: true });

                //remove localstorage
                localStorage.removeItem("LocalItemDataPDT");
                $('#odvModalsectionBodyPDT').html(tResult);
            },
            error: function(data) {
                console.log(data);
            }
        });
    }else{
        $('#odhEleNameNextFunc').val(tNextFunc);
        $('#odvModalDOCPDT').modal({ show: true });
    }
}

function JSxAPJBrowsePdtFrom(poPdtData){
    var aDataPdt = JSON.parse(poPdtData);
    var tPdtCode = aDataPdt[0]['packData']['PDTCode'];
    var tPdtName = aDataPdt[0]['packData']['PDTName'];

    $('#oetAJPPdtCodeFrom').val(tPdtCode);
    $('#oetAJPPdtNameFrom').val(tPdtName);

    if($('#oetAJPPdtCodeTo').val() == ''){
        $('#oetAJPPdtCodeTo').val(tPdtCode);
        $('#oetAJPPdtNameTo').val(tPdtName);
    }
    
}

function JSxAPJBrowsePdtTo(poPdtData){
    var aDataPdt = JSON.parse(poPdtData);
    var tPdtCode = aDataPdt[0]['packData']['PDTCode'];
    var tPdtName = aDataPdt[0]['packData']['PDTName'];

    $('#oetAJPPdtCodeTo').val(tPdtCode);
    $('#oetAJPPdtNameTo').val(tPdtName);

    if($('#oetAJPPdtCodeFrom').val() == ''){
        $('#oetAJPPdtCodeFrom').val(tPdtCode);
        $('#oetAJPPdtNameFrom').val(tPdtName);
    }
}


    // Click Browse Agency
    $('#obtAJPBrowsAgn').click(function(e) {
        e.preventDefault();
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
            JSxCheckPinMenuClose();
            window.oPdtBrowseAgencyOption = oPdtBrowseAgency({
                'tReturnInputCode': 'oetAJPAgnCode',
                'tReturnInputName': 'oetAJPAgnName'
            });
            JCNxBrowseData('oPdtBrowseAgencyOption');
        } else {
            JCNxShowMsgSessionExpired();
        }
    });


    // Click Browse Branch
    $('#obtAJPBrowsBch').click(function(e) {
        e.preventDefault();
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
            JSxCheckPinMenuClose();
            window.oPdtBrowseBranchOption = oPdtBrowseBranch({
                'tReturnInputCode': 'oetAJPBchCode',
                'tReturnInputName': 'oetAJPBchName',
                'tAgnCodeWhere': $('#oetAJPAgnCode').val(),
            });
            JCNxBrowseData('oPdtBrowseBranchOption');
        } else {
            JCNxShowMsgSessionExpired();
        }
    });

    // Click Browse Product Group
    $('#obtAJPBrowsPgp').click(function(e) {
        e.preventDefault();
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
            // Create By Witsarut 04/10/2019
            JSxCheckPinMenuClose();
            // Create By Witsarut 04/10/2019
            window.oPdtBrowsePdtGrpOption = oPdtBrowsePdtGrp({
                'tReturnInputCode': 'oetAJPPgpCode',
                'tReturnInputName': 'oetAJPPgpName',
                'tAgnCodeWhere': $('#oetAJPAgnCode').val()
            });
            JCNxBrowseData('oPdtBrowsePdtGrpOption');
        } else {
            JCNxShowMsgSessionExpired();
        }
    });


   // Click Browse Product Type
   $('#obtAJPBrowsPty').click(function(e) {
        e.preventDefault();
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
            // Create By Witsarut 04/10/2019
            JSxCheckPinMenuClose();
            // Create By Witsarut 04/10/2019
            window.oPdtBrowsePdtTypeOption = oPdtBrowsePdtType({
                'tReturnInputCode': 'oetAJPPtyCode',
                'tReturnInputName': 'oetAJPPtyName',
                'tAgnCodeWhere': $('#oetAJPAgnCode').val()
            });
            JCNxBrowseData('oPdtBrowsePdtTypeOption');
        } else {
            JCNxShowMsgSessionExpired();
        }
    });

    // Click Browse Product Brand
    $('#obtAJPBrowsPbn').click(function(e) {
        e.preventDefault();
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
            // Create By Witsarut 04/10/2019
            JSxCheckPinMenuClose();
            // Create By Witsarut 04/10/2019
            window.oPdtBrowsePdtBrandOption = oPdtBrowsePdtBrand({
                'tReturnInputCode': 'oetAJPPbnCode',
                'tReturnInputName': 'oetAJPPbnName',
                'tAgnCodeWhere': $('#oetAJPAgnCode').val()
            });
            JCNxBrowseData('oPdtBrowsePdtBrandOption');
        } else {
            JCNxShowMsgSessionExpired();
        }
    });

    // Click Browse Product Model
    $('#obtAJPBrowsPmo').click(function(e) {
        e.preventDefault();
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
            // Create By Witsarut 04/10/2019
            JSxCheckPinMenuClose();
            // Create By Witsarut 04/10/2019
            window.oPdtBrowsePdtModelOption = oPdtBrowsePdtModel({
                'tReturnInputCode': 'oetAJPPmoCode',
                'tReturnInputName': 'oetAJPPmoName',
                'tAgnCodeWhere': $('#oetAJPAgnCode').val()
            });
            JCNxBrowseData('oPdtBrowsePdtModelOption');
        } else {
            JCNxShowMsgSessionExpired();
        }
    });



    //เลือกสาขา
    var oPdtBrowseAgency = function(poReturnInput) {
        var tInputReturnCode = poReturnInput.tReturnInputCode;
        var tInputReturnName = poReturnInput.tReturnInputName;

        var oOptionReturn = {
            Title: ['ticket/agency/agency', 'tAggTitle'],
            Table: {
                Master: 'TCNMAgency',
                PK: 'FTAgnCode'
            },
            Join: {
                Table: ['TCNMAgency_L'],
                On: ['TCNMAgency_L.FTAgnCode = TCNMAgency.FTAgnCode AND TCNMAgency_L.FNLngID = ' + nLangEdits]
            },
            GrideView: {
                ColumnPathLang: 'ticket/agency/agency',
                ColumnKeyLang: ['tAggCode', 'tAggName'],
                ColumnsSize: ['15%', '85%'],
                WidthModal: 50,
                DataColumns: ['TCNMAgency.FTAgnCode', 'TCNMAgency_L.FTAgnName'],
                DataColumnsFormat: ['', ''],
                Perpage: 10,
                OrderBy: ['TCNMAgency.FDCreateOn DESC'],
            },
            CallBack: {
                ReturnType: 'S',
                Value: [tInputReturnCode, "TCNMAgency.FTAgnCode"],
                Text: [tInputReturnName, "TCNMAgency_L.FTAgnName"],
            },
            RouteAddNew: 'agency',
            BrowseLev: nStaPdtBrowseType,
            NextFunc: {
                FuncName: 'JSxClearBrowseConditionAgn',
                ArgReturn: ['FTAgnCode']
            },
            BrowseLev : 1
        }
        return oOptionReturn;
    }




    function JSxClearBrowseConditionAgn(ptData) {
        // aData = JSON.parse(ptData);
        if (ptData != '' || ptData != 'NULL') {

            $('#oetAJPBchCode').val('');
            $('#oetAJPBchName').val('');

            $('#oetAJPPdtCodeFrom').val('');
            $('#oetAJPPdtNameFrom').val('');

            $('#oetAJPPdtCodeTo').val('');
            $('#oetAJPPdtNameTo').val('');

            $('#oetAJPPdtCodeTo').val('');
            $('#oetAJPPdtNameTo').val('');

            $('#oetAJPPgpCode').val('');
            $('#oetAJPPgpName').val('');

            $('#oetAJPPbnCode').val('');
            $('#oetAJPPbnName').val('');

            $('#oetAJPPmoCode').val('');
            $('#oetAJPPmoName').val('');

            $('#oetAJPPtyCode').val('');
            $('#oetAJPPtyName').val('');

            localStorage.removeItem("LocalItemData");
            localStorage.removeItem("Ada.ProductListCenter");
        }
    }


    function JSxClearBrowseConditionBCH(ptData){
    // aData = JSON.parse(ptData);
    if (ptData != '' || ptData != 'NULL') {


        $('#oetAJPPdtCodeFrom').val('');
        $('#oetAJPPdtNameFrom').val('');

        $('#oetAJPPdtCodeTo').val('');
        $('#oetAJPPdtNameTo').val('');

        localStorage.removeItem("LocalItemData");
        localStorage.removeItem("Ada.ProductListCenter");

        }
    }
    //เลือกสาขา
    var oPdtBrowseBranch = function(poReturnInput) {
        var tInputReturnCode = poReturnInput.tReturnInputCode;
        var tInputReturnName = poReturnInput.tReturnInputName;
        var tAgnCodeWhere = poReturnInput.tAgnCodeWhere;

        var nCountBCH = '<?= $this->session->userdata('nSesUsrBchCount') ?>';
        // alert(nCountBCH);
        if (nCountBCH != '0') {
            //ถ้าสาขามากกว่า 1
            tBCH = "<?= $this->session->userdata('tSesUsrBchCodeMulti'); ?>";
            tWhereBCH = " AND TCNMBranch.FTBchCode IN ( " + tBCH + " ) ";
        } else {
            tWhereBCH = '';
        }

        if (tAgnCodeWhere == '' || tAgnCodeWhere == null) {
            tWhereAgn = '';
        } else {
            tWhereAgn = " AND TCNMBranch.FTAgnCode = '" + tAgnCodeWhere + "'";
        }


        var oOptionReturn = {
            Title: ['company/branch/branch', 'tBCHTitle'],
            Table: {
                Master: 'TCNMBranch',
                PK: 'FTBchCode'
            },
            Join: {
                Table: ['TCNMBranch_L', 'TCNMAgency_L'],
                On: [
                    'TCNMBranch_L.FTBchCode = TCNMBranch.FTBchCode AND TCNMBranch_L.FNLngID = ' + nLangEdits,
                    'TCNMAgency_L.FTAgnCode = TCNMBranch.FTAgnCode AND TCNMAgency_L.FNLngID = ' + nLangEdits,
                ]
            },
            Where: {
                Condition: [tWhereBCH + tWhereAgn]
                // Condition: [tWhereAgn]
            },
            GrideView: {
                ColumnPathLang: 'company/branch/branch',
                ColumnKeyLang: ['tBCHCode', 'tBCHName'],
                ColumnsSize: ['15%', '75%'],
                DataColumns: ['TCNMBranch.FTBchCode', 'TCNMBranch_L.FTBchName', 'TCNMAgency_L.FTAgnName', 'TCNMBranch.FTAgnCode'],
                DataColumnsFormat: ['', '', '', ''],
                DisabledColumns: [2, 3],
                WidthModal: 50,
                Perpage: 10,
                OrderBy: ['TCNMBranch.FDCreateOn DESC'],
            },
            CallBack: {
                ReturnType: 'S',
                Value: [tInputReturnCode, "TCNMBranch.FTBchCode"],
                Text: [tInputReturnName, "TCNMBranch_L.FTBchName"],
            },
            RouteAddNew: 'branch',
            BrowseLev: nStaPdtBrowseType,
            NextFunc: {
                FuncName: 'JSxClearBrowseConditionBCH',
                ArgReturn: ['FTAgnName', 'FTAgnCode']
            },
            BrowseLev : 1
        }
        return oOptionReturn;
    }

    // Option Browse Product Group
    var oPdtBrowsePdtGrp = function(poReturnInput) {
        var tInputReturnCode = poReturnInput.tReturnInputCode;
        var tInputReturnName = poReturnInput.tReturnInputName;
        var tAgnCodeWhere = poReturnInput.tAgnCodeWhere;

        if (tAgnCodeWhere == '' || tAgnCodeWhere == null) {
            tWhereAgn = '';
        } else {
            tWhereAgn = " AND TCNMPdtGrp.FTAgnCode = '" + tAgnCodeWhere + "'";
        }

        var oOptionReturn = {
            Title: ['product/pdtgroup/pdtgroup', 'tPGPTitle'],
            Table: {
                Master: 'TCNMPdtGrp',
                PK: 'FTPgpChain'
            },
            Join: {
                Table: ['TCNMPdtGrp_L'],
                On: ['TCNMPdtGrp.FTPgpChain = TCNMPdtGrp_L.FTPgpChain AND TCNMPdtGrp_L.FNLngID = ' + nLangEdits]
            },
            Where: {
                Condition: [tWhereAgn]
            },
            GrideView: {
                ColumnPathLang: 'product/pdtgroup/pdtgroup',
                ColumnKeyLang: ['tPGPCode', 'tPGPChainCode', 'tPGPName', 'tPGPChain'],
                ColumnsSize: ['10%', '15%', '40%', '35%'],
                DataColumns: ['TCNMPdtGrp.FTPgpCode', 'TCNMPdtGrp.FTPgpChain', 'TCNMPdtGrp_L.FTPgpName', 'TCNMPdtGrp_L.FTPgpChainName'],
                DataColumnsFormat: ['', '', '', ''],
                WidthModal: 50,
                Perpage: 10,
                OrderBy: ['TCNMPdtGrp.FDCreateOn DESC'],
                // SourceOrder: "ASC"
            },
            CallBack: {
                ReturnType: 'S',
                Value: [tInputReturnCode, "TCNMPdtGrp.FTPgpChain"],
                Text: [tInputReturnName, "TCNMPdtGrp_L.FTPgpChainName"],
            },
            // RouteAddNew : 'pdtgroup',
            BrowseLev : 1
        }
        return oOptionReturn;
    }




    // Option Browse Product Type
    var oPdtBrowsePdtType = function(poReturnInput) {
        var tInputReturnCode = poReturnInput.tReturnInputCode;
        var tInputReturnName = poReturnInput.tReturnInputName;
        var tAgnCodeWhere = poReturnInput.tAgnCodeWhere;

        if (tAgnCodeWhere == '' || tAgnCodeWhere == null) {
            tWhereAgn = '';
        } else {
            tWhereAgn = " AND TCNMPdtType.FTAgnCode = '" + tAgnCodeWhere + "'";
        }
        var oOptionReturn = {
            Title: ['product/pdttype/pdttype', 'tPTYTitle'],
            Table: {
                Master: 'TCNMPdtType',
                PK: 'FTPtyCode'
            },
            Join: {
                Table: ['TCNMPdtType_L'],
                On: ['TCNMPdtType_L.FTPtyCode = TCNMPdtType.FTPtyCode AND TCNMPdtType_L.FNLngID = ' + nLangEdits]
            },
            Where: {
                Condition: [tWhereAgn]
            },
            GrideView: {
                ColumnPathLang: 'product/pdttype/pdttype',
                ColumnKeyLang: ['tPTYCode', 'tPTYName'],
                ColumnsSize: ['10%', '90%'],
                DataColumns: ['TCNMPdtType.FTPtyCode', 'TCNMPdtType_L.FTPtyName'],
                DataColumnsFormat: ['', ''],
                WidthModal: 50,
                Perpage: 5,
                OrderBy: ['TCNMPdtType.FTPtyCode'],
                // SourceOrder: "DESC"
            },
            CallBack: {
                ReturnType: 'S',
                Value: [tInputReturnCode, "TCNMPdtType.FTPtyCode"],
                Text: [tInputReturnName, "TCNMPdtType_L.FTPtyName"],
            },
            // RouteAddNew: 'pdttype',
            BrowseLev: 1
        }
        return oOptionReturn;
    }


    
    // Option Browse Product Brand
    var oPdtBrowsePdtBrand = function(poReturnInput) {
        var tInputReturnCode = poReturnInput.tReturnInputCode;
        var tInputReturnName = poReturnInput.tReturnInputName;
        var tAgnCodeWhere = poReturnInput.tAgnCodeWhere;

        if (tAgnCodeWhere == '' || tAgnCodeWhere == null) {
            tWhereAgn = '';
        } else {
            tWhereAgn = " AND TCNMPdtBrand.FTAgnCode = '" + tAgnCodeWhere + "'";
        }

        var oOptionReturn = {
            Title: ['product/pdtbrand/pdtbrand', 'tPBNTitle'],
            Table: {
                Master: 'TCNMPdtBrand',
                PK: 'FTPbnCode'
            },
            Join: {
                Table: ['TCNMPdtBrand_L'],
                On: ['TCNMPdtBrand_L.FTPbnCode = TCNMPdtBrand.FTPbnCode AND TCNMPdtBrand_L.FNLngID = ' + nLangEdits]
            },
            Where: {
                Condition: [tWhereAgn]
            },
            GrideView: {
                ColumnPathLang: 'product/pdtbrand/pdtbrand',
                ColumnKeyLang: ['tPBNCode', 'tPBNName'],
                ColumnsSize: ['10%', '90%'],
                DataColumns: ['TCNMPdtBrand.FTPbnCode', 'TCNMPdtBrand_L.FTPbnName'],
                DataColumnsFormat: ['', ''],
                WidthModal: 50,
                Perpage: 10,
                OrderBy: ['TCNMPdtBrand.FDCreateOn DESC'],
                // SourceOrder: "DESC"
            },
            CallBack: {
                ReturnType: 'S',
                Value: [tInputReturnCode, "TCNMPdtBrand.FTPbnCode"],
                Text: [tInputReturnName, "TCNMPdtBrand_L.FTPbnName"],
            },
            // RouteAddNew : 'pdtbrand',
            BrowseLev : 1
        }
        return oOptionReturn;
    }

    // Option Browse Product Model
    var oPdtBrowsePdtModel = function(poReturnInput) {
        var tInputReturnCode = poReturnInput.tReturnInputCode;
        var tInputReturnName = poReturnInput.tReturnInputName;
        var tAgnCodeWhere = poReturnInput.tAgnCodeWhere;

        if (tAgnCodeWhere == '' || tAgnCodeWhere == null) {
            tWhereAgn = '';
        } else {
            tWhereAgn = " AND TCNMPdtModel.FTAgnCode = '" + tAgnCodeWhere + "'";
        }

        var oOptionReturn = {
            Title: ['product/pdtmodel/pdtmodel', 'tPMOTitle'],
            Table: {
                Master: 'TCNMPdtModel',
                PK: 'FTPmoCode'
            },
            Join: {
                Table: ['TCNMPdtModel_L'],
                On: ['TCNMPdtModel_L.FTPmoCode = TCNMPdtModel.FTPmoCode AND TCNMPdtModel_L.FNLngID = ' + nLangEdits]
            },
            Where: {
                Condition: [tWhereAgn]
            },
            GrideView: {
                ColumnPathLang: 'product/pdtmodel/pdtmodel',
                ColumnKeyLang: ['tPMOCode', 'tPMOName'],
                ColumnsSize: ['10%', '90%'],
                DataColumns: ['TCNMPdtModel.FTPmoCode', 'TCNMPdtModel_L.FTPmoName'],
                DataColumnsFormat: ['', ''],
                WidthModal: 50,
                Perpage: 10,
                OrderBy: ['TCNMPdtModel.FDCreateOn DESC'],
                // SourceOrder: "DESC"
            },
            CallBack: {
                ReturnType: 'S',
                Value: [tInputReturnCode, "TCNMPdtModel.FTPmoCode"],
                Text: [tInputReturnName, "TCNMPdtModel_L.FTPmoName"],
            },
            // RouteAddNew: 'pdtmodel',
            BrowseLev: 1
        }
        return oOptionReturn;
    }


</script>