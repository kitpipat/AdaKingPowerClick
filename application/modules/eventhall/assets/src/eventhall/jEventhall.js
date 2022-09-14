var nStaEvntBrowseType   = $('#oetEvnthStaBrowse').val();
var tCallEvntBackOption  = $('#oetVocCallBackOption').val();

$('ducument').ready(function() {
    localStorage.removeItem('LocalItemData');
    // Check เปิดปิด Menu ตาม Pin
    JSxCheckPinMenuClose();
    JSxPdtNavDefult();
    if(nStaEvntBrowseType != '1'){
        JSvCallPageEventhallList();
    }else{
        // JSvCallPageProductAdd();
    }
});

// Function : Function Clear Defult Button Product
// Parameters : Document Redy And Function Event
// Creator : 31/01/2019 wasin(Yoshi)
// Return : Reset Defult Button
// Return Type : None
function JSxPdtNavDefult() {
    if(typeof(nStaEvntBrowseType) !== 'undefined' || nStaEvntBrowseType != 1){
        $('#oliEvnthTitleAdd').hide();
        $('#oliEvnthTitleEdit').hide();
        $('#odvBtnAddEdit').hide();
        $('#odvBtnEventInfo').show();
    }else{
        $('#odvModalBody #odvPdtMainMenu').removeClass('main-menu');
        $('#odvModalBody #oliPdtNavBrowse').css('padding', '2px');
        $('#odvModalBody #odvPdtBtnGroup').css('padding', '0');
        $('#odvModalBody .xCNPdtBrowseLine').css('padding', '0px 0px');
        $('#odvModalBody .xCNPdtBrowseLine').css('border-bottom', '1px solid #e3e3e3');
    }
}

// Function : Call Page Event Hall list  
// Parameters : Document Redy And Event Button
// Creator :	05/06/2019 saharat(Golf)
// Return : View
// Return Type : View
function JSvCallPageEventhallList(pnPage) {
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
        localStorage.tStaPageNow = 'JSvCallPageEventhallList';
        $('#oetSearchAll').val('');
        JCNxOpenLoading();
        $.ajax({
            type: "POST",
            url: "EventhallSearchList",
            cache: false,
            timeout: 0,
            success: function(tResult){
                $('#odvContentPageEventhall').html(tResult);
                JSvCallPageEventHallDataTable(pnPage);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
        JCNxCloseLoading();
    }else{
        JCNxShowMsgSessionExpired();
    }
}

// Function: Call Product Type Data List
// Parameters:  Event Button And Ajax Function Success
// Creator:	05/06/2019 saharat(Golf)
// Return: View
// Return Type: View
function JSvCallPageEventHallDataTable(pnPage){
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
        var tSearchAll      = $('#oetSearchProduct').val();
        var nPageCurrent    = (pnPage === undefined || pnPage == '')? '1' : pnPage;
        $.ajax({
            type: "POST",
            url: "EventHallDataTable",
            data: {
                tSearchAll      : tSearchAll,
                nPageCurrent    : nPageCurrent,
            },
            cache: false,
            Timeout: 0,
            async: false,
            success: function(oResult){
                var aReturnData = JSON.parse(oResult);
                if(aReturnData['nStaEvent'] == '1'){
                    JSxPdtNavDefult();
                    $('#odvContentEventHallData').html(aReturnData['vEventHallPageDataTable']);
                }else{
                    var tMessageError   = aReturnData['tStaMessg'];
                    FSvCMNSetMsgErrorDialog(tMessageError);
                }
                JCNxLayoutControll();
                JCNxCloseLoading();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        })
    }else{
        JCNxShowMsgSessionExpired();
    }
}

// Function: Call Product Page Add  
// Parameters:  Event Click Add Button 
// Creator:	01/02/2019 wasin(Yoshi)
// Return: View
// Return Type: View
function JSvCallPageProductAdd(){
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
        JCNxOpenLoading();
        JStCMMGetPanalLangSystemHTML('', '');
        $.ajax({
            type: "POST",
            url: "productPageAdd",
            cache: false,
            Timeout: 0,
            async: false,
            success: function(oResult){
                var aReturnData = JSON.parse(oResult);
                if(aReturnData['nStaEvent'] == '1'){
                    if (nStaPdtBrowseType == 1) {
                        $('#odvModalBodyBrowse .panel-body').css('padding-top','0');
                        $('#odvModalBodyBrowse').html(aReturnData['vPdtPageAdd']);
                    }else{
                        $('#oliPdtTitleEdit').hide();
                        $('#oliPdtTitleAdd').show();
                        $('#odvBtnPdtInfo').hide();
                        $('#odvBtnPdtAddEdit').show();
                        $('#odvContentPageProduct').html(aReturnData['vPdtPageAdd']);
                    }
                }else{
                    var tMessageError   = aReturnData['tStaMessg'];
                    FSvCMNSetMsgErrorDialog(tMessageError);
                }
                JCNxLayoutControll();
                JCNxCloseLoading();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }else{
        JCNxShowMsgSessionExpired();
    }
}

// Function: Call Product Page Edit  
// Parameters:  Event Click Add Button 
// Creator:	01/02/2019 wasin(Yoshi)
// Return: View
// Return Type: View
function JSvCallPageProductEdit(ptPdtCode){
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
        JCNxOpenLoading();
        JStCMMGetPanalLangSystemHTML('JSvCallPageProductEdit',ptPdtCode);
        $.ajax({
            type: "POST",
            url: "productPageEdit",
            data:{ tPdtCode : ptPdtCode },
            cache: false,
            timeout: 0,
            async: false,
            success: function(oResult){
                var aReturnData = JSON.parse(oResult);
                if(aReturnData['nStaEvent'] == '1'){
                    $('#oliPdtTitleAdd').hide();
                    $('#odvBtnPdtInfo').hide();

                    $('#oliPdtTitleEdit').show();
                    $('#odvBtnPdtAddEdit').show();

                    $('#odvContentPageProduct').html(aReturnData['vPdtPageAdd']);
                }else{
                    var tMessageError   = aReturnData['tStaMessg'];
                    FSvCMNSetMsgErrorDialog(tMessageError);
                }
                JCNxLayoutControll();
                JCNxCloseLoading();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }else{
        JCNxShowMsgSessionExpired();
    }
}

// Function: Function Generate Product Code
// Parameters:  Event Click Gen Code Button 
// Creator:	07/02/2019 wasin(Yoshi)
// Return: View
// Return Type: View
function JSoGenerateProductCode(){
    var nStaSession     = JCNxFuncChkSessionExpired();
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
        $('#oetPdtCode').closest('.form-group').addClass( "has-success" ).removeClass( "has-error");
        $('#oetPdtCode').closest('.form-group').find(".help-block").fadeOut('slow').remove();
        var tTableName   = 'TCNMPdt';
        JCNxOpenLoading();
        $.ajax({
            type: "POST",
            url: "generateCode",
            data: { tTableName: tTableName },
            cache: false,
            timeout: 0,
            async: false,
            success: function(oResult) {
                var aDataReturn = $.parseJSON(oResult);
                if (aDataReturn.rtCode == '1') {
                    $('#oetPdtCode').val(aDataReturn['rtPdtCode']);
                    $('#oetPdtCode').addClass('xCNDisable');
                    $('#oetPdtCode').attr('readonly', true);
                    $('.xCNBtnGenCode').attr('disabled', true);
                    $('#oetPdtName').focus();
                    JCNxCloseLoading();
                }else{
                    var tMessageError   =   aDataReturn['rtDesc'];
                    FSvCMNSetMsgErrorDialog(tMessageError);
                    JCNxCloseLoading();
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }else{
        JCNxShowMsgSessionExpired();
    }
}

// Function: Function Add/Edit Product
// Parameters:  Object In Next Funct Modal Browse
// Creator:	14/02/2019 wasin(Yoshi)
// Return: object View Event Not Sale Data Table
// Return Type: object
function JSoAddEditProduct(ptRoute){
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
        $('#ofmAddEditProduct').validate().destroy();
        
        $.validator.addMethod('dublicateCode', function(value, element) {
            if(ptRoute == "reasonEventAdd"){
                if($("#ohdCheckDuplicatePdtCode").val() == 1){
                    return false;
                }else{
                    return true;
                }
            }else{
                return true;
            }
        },'');

        $('#ofmAddEditProduct').validate({
            rules: {
                oetPdtCode:     {
                    "required": {
                        depends: function(oElement) {
                            if(ptRoute == "productEventAdd"){
                                if($('#ocbProductAutoGenCode').is(':checked')){
                                    return false;
                                }else{
                                    return true;
                                }
                            }else{
                                return true;
                            }
                        }
                    },
                    "dublicateCode": {}
                },
                oetPdtName:     {"required" :{}},
            },
            messages: {
                oetPdtCode : {
                    "required"      : $('#oetPdtCode').attr('data-validate-required'),
                    "dublicateCode" : $('#oetPdtCode').attr('data-validate-dublicateCode')
                },
                oetPdtName : {
                    "required"      : $('#oetPdtName').attr('data-validate-required'),
                },
            },
            errorElement: "em",
            errorPlacement: function (error, element ) {
                error.addClass( "help-block" );
                if ( element.prop( "type" ) === "checkbox" ) {
                    error.appendTo( element.parent( "label" ) );
                } else {
                    var tCheck = $(element.closest('.form-group')).find('.help-block').length;
                    if(tCheck == 0){
                        error.appendTo(element.closest('.form-group')).trigger('change');
                    }
                }
            },
            highlight: function(element, errorClass, validClass) {
                $(element).closest('.form-group').addClass( "has-error" ).removeClass( "has-success" );
            },
            unhighlight: function(element, errorClass, validClass) {
                var nStaCheckValid  = $(element).parents('.form-group').find('.help-block').length
                if(nStaCheckValid != 0){
                    $(element).closest('.form-group').addClass( "has-success" ).removeClass( "has-error" );
                }
            },
            submitHandler: function(form){
                var tStaChkPackSize = ($('#odvPdtSetPackSizeTable table tbody tr.xWPdtPackSizeRow').length > 0)? "TRUE" : "FALSE";
                if(tStaChkPackSize == "TRUE"){
                    var aChkBarCodeInPackSizeAll    = JSaChkBarCodeInPackSizeAll();
                    var tStaChkBarCode  = (aChkBarCodeInPackSizeAll.length == 0)? "TRUE" : "FALSE";
                    if(tStaChkBarCode == "TRUE"){
                        // Get Data Image Name
                        var aPdtImg = [];
                        $('.xCNImgTumblr').each(function(){
                            aPdtImg.push($(this).data('img'));
                        });

                        // Get Value Data Unit , Barcode ,Supplier
                        var aPdtDataPackSize    = [];
                        $('#odvPdtContentInfo1 #odvPdtSetPackSizeTable table tbody .xWPdtDataUnitRow').each(function(){
                            // รหัสหน่วยสินค้า
                            var tPdtPunCode = $(this).find('.xWPdtPunCode').val();

                            // ลูปดึงข้อมูลบาร์โค้ดตามหน่วยสินค้า
                            var oDataBarCoed   = [];
                            $(this).parents('#odvPdtSetPackSizeTable').find('#otrPdtUnitBarCodeRow'+tPdtPunCode+' .xWPdtUnitDataBarCode .xWBarCodeItem').each(function(){
                                var oBarCode    = {
                                    'tPdtBarCode'       : $(this).find('.xWPdtAebBarCodeItem').val(),
                                    'tPdtPlcCode'       : $(this).find('.xWPdtAebPlcCodeItem').val(),
                                    'tPdtBarStaUse'     : $(this).find('.xWPdtAebBarStaUseItem').val(),
                                    'tPdtBarStaAlwSale' : $(this).find('.xWPdtAebBarStaAlwSaleItem').val(),
                                };
                                oDataBarCoed.push(oBarCode);
                            });
                            // End ลูปดึงข้อมูลผู้จำหน่ายตามหน่วยสินค้า
                            var oDataSupplier   = [];
                            $(this).parents('#odvPdtSetPackSizeTable').find('#otrPdtUnitBarCodeRow'+tPdtPunCode+' .xWPdtUnitDataSupplier .xWAddSupplierItem').each(function(){
                                var oDataSpl    = {
                                    'tPdtBarCode'   : $(this).find('.xWPdtAesBarCodeItem').val(),
                                    'tPdtSplCode'   : $(this).find('.xWPdtAesSplCodeItem').val(),
                                    'tPdtStaAlwPO'   : $(this).find('.xWPdtAesSplStaAlwPOItem').val(),
                                };
                                oDataSupplier.push(oDataSpl);
                            })

                            // Get Data Pack Size
                            var oDataPsz   = {
                                'tPdtPunCode'       : tPdtPunCode,
                                'tPdtUnitFact'      : $(this).parents('#odvPdtSetPackSizeTable').find('#oetPdtUnitFact'+tPdtPunCode).val(),
                                'tPdtGrade'         : $(this).find('.xWPdtGrade').val(),
                                'tPdtWeight'        : $(this).find('.xWPdtWeight').val(),
                                'tPdtClrCode'       : $(this).find('.xWPdtClrCode').val(),
                                'tPdtSizeCode'      : $(this).find('.xWPdtSizeCode').val(),
                                'tPdtUnitDim'       : $(this).find('.xWPdtUnitDim').val(),
                                'tPdtPkgDim'        : $(this).find('.xWPdtPkgDim').val(),
                                'tPdtStaAlwPick'    : $(this).find('.xWPdtStaAlwPick').val(),
                                'tPdtStaAlwPoHQ'    : $(this).find('.xWPdtStaAlwPoHQ').val(),
                                'tPdtStaAlwBuy'     : $(this).find('.xWPdtStaAlwBuy').val(),
                                'tPdtStaAlwSale'    : $(this).find('.xPdtStaAlwSale').val(),
                                'oDataBarCode'      : oDataBarCoed,
                                'oDataSupplier'     : oDataSupplier,
                            }
                            aPdtDataPackSize.push(oDataPsz);
                            // End Get Data Pack Size
                        });

                        // Product Information 1
                        var aPdtDataInfo1       = {
                            'tIsAutoGenCode'    : ($('#ocbProductAutoGenCode').is(':checked')) ? 1 : 2,
                            'tPdtCode'          : $('#oetPdtCode').val(),
                            'tPdtStkCode'       : $('#oetPdtCode').val(),
                            'tPdtName'          : $('#oetPdtName').val(),
                            'tPdtNameOth'       : $('#oetPdtNameOth').val(),
                            'tPdtNameABB'       : $('#oetPdtNameABB').val(),
                            'tPdtVatCode'       : $('#ocmPdtVatCode').val(),
                            'tPdtVatCode'       : $('#ocmPdtVatCode').val(),
                            'nPdtStaVatBuy'     : ($('#ocbPdtStaVatBuy').is(':checked')) ? 1 : 2,
                            'nPdtStaVat'        : ($('#ocbPdtStaVat').is(':checked')) ? 1 : 2,
                            'nPdtStaPoint'      : ($('#ocbPdtPoint').is(':checked')) ? 1 : 2,
                            'nPdtStaActive'     : ($('#ocbPdtStaActive').is(':checked')) ? 1 : 2,
                            'nPdtStkControl'    : ($('#ocbPdtStkControl').is(':checked')) ? 1 : 2,
                            'nPdtStaAlwReturn'  : ($('#ocbPdtStaAlwReturn').is(':checked')) ? 1 : 2,
                            'nPdtStaAlwDis'     : ($('#ocbPdtStaAlwDis').is(':checked')) ? 1 : 2,
                        };

                        // Product Information 2
                        var aPdtDataInfo2       = {
                            'tPdtBchCode'   : $('#oetPdtBchCode').val(),
                            'tPdtMerCode'   : $('#oetPdtMerCode').val(),
                            'tPdtPgpChain'  : $('#oetPdtPgpChain').val(),
                            'tPdtPtyCode'   : $('#oetPdtPtyCode').val(),
                            'tPdtPbnCode'   : $('#oetPdtPbnCode').val(),
                            'tPdtPmoCode'   : $('#oetPdtPmoCode').val(),
                            'tPdtTcgCode'   : $('#oetPdtTcgCode').val(),
                            'tPdtSaleStart' : $('#oetPdtSaleStart').val(),
                            'tPdtSaleStop'  : $('#oetPdtSaleStop').val(),
                            'tPdtPointTime' : $('#oetPdtPointTime').val(),
                            // 'tPdtStkFac'    : $('#oetPdtStkFac').val(),
                            'tPdtQtyOrdBuy' : $('#oetPdtQtyOrdBuy').val(),
                            'tPdtMax'       : $('#oetPdtMax').val(),
                            'tPdtMin'       : $('#oetPdtMin').val(),
                            'tPdtCostDef'   : $('#oetPdtCostDef').val(),
                            'tPdtCostOth'   : $('#oetPdtCostOth').val(),
                            'tPdtCostStd'   : $('#oetPdtCostStd').val(),
                            'tPdtRmk'       : $('#otaPdtRmk').val(),
                        };
            
                        // Product Set Data
                        var aPdtDataAllSet      = [];
                        var nStaCountPdtSet     = $('#odvPdtContentSet #odvPdtSetTable table tbody .xWPdtSetRow').length;
                        if(nStaCountPdtSet > 0){
                            var oDataPdtCodeSet = [];
                            $('#odvPdtContentSet #odvPdtSetTable table tbody .xWPdtSetRow').each(function(){
                                var oPdtDataGetRow = {
                                    'tPdtCodeSetCode'   : $(this).data('pdtcode'),
                                    'tPdtCodeSetName'   : $(this).data('pdtname'),
                                    'tPdtCodeSetQty'    : $(this).find('.xCNPdtSetQty').val()
                                }
                                oDataPdtCodeSet.push(oPdtDataGetRow);
                            });

                            if($('#odvPdtContentSet #odvPdtSetConfig #odvPdtSetChackBoxSta #ocbPdtSubPrice').is(':checked')){
                                var tPdtStaSetPri   = '2';
                            }else if($('#odvPdtContentSet #odvPdtSetConfig #odvPdtSetChackBoxSta #ocbPdtSetPrice').is(':checked')){
                                var tPdtStaSetPri   = '1';
                            }else{
                                var tPdtStaSetPri   = '';
                            }
                            aPdtDataAllSet  = {
                                'oPdtCodeSetData'   : oDataPdtCodeSet,
                                'tPdtStaSetShwDT'   : ($('#odvPdtContentSet #odvPdtSetConfig #odvPdtSetChackBoxSta #ocbPdtStaSetShwDT').is(':checked'))? '1' : '2',
                                'tPdtStaSetPri'     : tPdtStaSetPri
                            };
                        }

                        // Product Evn Not Sale
                        var tPdtEvnNotSale  =   $('#ohdPdtEvnNoSleCode').val();

                        JCNxOpenLoading();
                        $.ajax({
                            type: "POST",
                            url: ptRoute,
                            data: {
                                'aPdtImg'           : aPdtImg,
                                'aPdtDataInfo1'     : aPdtDataInfo1,
                                'aPdtDataInfo2'     : aPdtDataInfo2,
                                'aPdtDataPackSize'  : aPdtDataPackSize,
                                'aPdtDataAllSet'    : aPdtDataAllSet,
                                'tPdtEvnNotSale'    : tPdtEvnNotSale,
                            },
                            async: false,
                            cache: false,
                            timeout: 0,
                            success: function(oResult){
                                if(nStaPdtBrowseType != 1) {
                                    var aReturnData = JSON.parse(oResult);
                                    if(aReturnData['nStaEvent'] == 1){
                                        switch(aReturnData['nStaCallBack']){
                                            case '1' :
                                                JSvCallPageProductEdit(aReturnData['tCodeReturn']);
                                            break;
                                            case '2' :
                                                JSvCallPageProductAdd();
                                            break;
                                            case '3' :
                                                JSvCallPageProductList();
                                            break;
                                            default:
                                                JSvCallPageProductEdit(aReturnData['tCodeReturn']);
                                        }
                                    }else{
                                        var tMsgErrReturn   = aReturnData['tStaMessg'];
                                        FSvCMNSetMsgErrorDialog(tMsgErrReturn);
                                    }
                                }else{
                                    JCNxBrowseData(tCallPdtBackOption);
                                }
                            },
                            error: function(jqXHR, textStatus, errorThrown){
                                JCNxResponseError(jqXHR,textStatus,errorThrown);
                            }
                        });
                    }else{
                        var oObjBarNotFoundMsg  = objValidateMsg['tPDTValidPdtBar'];
                        FSvCMNSetMsgWarningDialog(oObjBarNotFoundMsg);
                    }
                }else{
                    var oObjPszAndBarNotFoundMsg = objValidateMsg['tPDTValidPdtPszAndBarCode'];
                    FSvCMNSetMsgWarningDialog(oObjPszAndBarNotFoundMsg);
                }
            }
        });
    }else{
        JCNxShowMsgSessionExpired();
    }
}

// Function: Function Check BarCode In PackSize All
// Parameters:
// Creator:	14/02/2019 wasin(Yoshi)
// Return: aData BarCode All In PackSize
// Return Type: Array
function JSaChkBarCodeInPackSizeAll(){
    var aStaReturn = [];
    $('#odvPdtContentInfo1 #odvPdtSetPackSizeTable .xWPdtUnitBarCodeRow').each(function(){
        var nCountBarCodeRow    = $(this).find('.xWPdtUnitDataBarCode .xWBarCodeItem').length;
        if(nCountBarCodeRow == 0){
            var oStaChkCount = {
                'staPunCode': $(this).data('puncode'),
                'staPunName': $(this).data('punname')
            }
            aStaReturn.push(oStaChkCount);
        }
    });
    return aStaReturn;  
}

// Functionality : เปลี่ยนหน้า pagenation
// Parameters : Event Click Pagenation
// Creator : 25/02/2019 wasin(Yoshi)
// Return : View
// Return Type : View
function JSvProductClickPage(ptPage){
    var nPageCurrent = '';
    switch (ptPage) {
        case 'next': //กดปุ่ม Next
            $('.xWBtnNext').addClass('disabled');
            nPageOld = $('.xWPageProduct .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
            nPageCurrent = nPageNew
            break;
        case 'previous': //กดปุ่ม Previous
            nPageOld = $('.xWPageProduct .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
            nPageCurrent = nPageNew
            break;
        default:
            nPageCurrent = ptPage
    }
    JCNxOpenLoading();
    JSvCallPageProductDataTable(nPageCurrent);
}

// Functionality: Function Chack And Show Button Delete All
// Parameters: LocalStorage Data
// Creator : 25/02/2019 wasin(Yoshi)
// Return: - 
// Return Type: -
function JSxShowButtonChoose() {
    var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
    if (aArrayConvert[0] == null || aArrayConvert[0] == '') {
        $('#odvMngTableList #oliBtnDeleteAll').addClass('disabled');
    } else {
        nNumOfArr = aArrayConvert[0].length;
        if (nNumOfArr > 1) {
            $('#odvMngTableList #oliBtnDeleteAll').removeClass('disabled');
        } else {
            $('#odvMngTableList #oliBtnDeleteAll').addClass('disabled');
        }
    }
}

// Functionality: Insert Text In Modal Delete
// Parameters: LocalStorage Data
// Creator : 25/02/2019 wasin(Yoshi)
// Return: -
// Return Type: -
function JSxPaseCodeDelInModal() {
    var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
    if (aArrayConvert[0] == null || aArrayConvert[0] == '') {} else {
        var tTextCode = '';
        for ($i = 0; $i < aArrayConvert[0].length; $i++) {
            tTextCode += aArrayConvert[0][$i].nCode;
            tTextCode += ' , ';
        }
        $('#odvModalDeletePdtMultiple #ospTextConfirmDelMultiple').text($('#oetTextComfirmDeleteMulti').val());
        $('#odvModalDeletePdtMultiple #ohdConfirmIDDelMultiple').val(tTextCode);
    }
}

// Functionality: Function Chack Value LocalStorage
// Parameters: Event Select List Reason
// Creator: 25/02/2019 wasin(Yoshi)
// Return: Duplicate/none
// Return Type: string
function findObjectByKey(array, key, value) {
    for (var i = 0; i < array.length; i++) {
        if (array[i][key] === value) {
            return 'Dupilcate';
        }
    }
    return 'None';
}

// Functionality: Event Single Delete Product Single
// Parameters: Event Icon Delete
// Creator: 26/02/2019 wasin(Yoshi)
// Return: object Status Delete
// ReturnType: object
function JSoProductDeleteSingle(pnPageDel,pnPageCodeDel,pnPageNameDel){
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
        $('#odvModalDeletePdtSingle #ospTextConfirmDelSingle').html($('#oetTextComfirmDeleteSingle').val() + pnPageCodeDel+' ('+pnPageNameDel+')');
        $('#odvModalDeletePdtSingle').modal('show');
        $('#odvModalDeletePdtSingle #osmConfirmDelSingle').unbind().click(function(){
            JCNxOpenLoading();
            $.ajax({
                type: "POST",
                url: "productEventDelete",
                data: { 'tIDCode': pnPageCodeDel},
                cache: false,
                timeout: 0,
                success: function(oResult){
                    var aReturnData = JSON.parse(oResult);
                    if(aReturnData['nStaEvent'] == 1){
                        $('#odvModalDeletePdtSingle').modal('hide');
                        $('#odvModalDeletePdtSingle #ospTextConfirmDelSingle').html($('#oetTextComfirmDeleteSingle').val());
                        $('.modal-backdrop').remove();
                        setTimeout(function() {
                            JSvCallPageProductDataTable(pnPageDel);
                        },500);
                    }else{
                        JCNxCloseLoading();
                        FSvCMNSetMsgErrorDialog(aReturnData['tStaMessg']);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        });
    }else{
        JCNxShowMsgSessionExpired();
    }
}

// Functionality: Event Single Delete Product Single
// Parameters: Event Icon Delete
// Creator: 26/02/2019 wasin(Yoshi)
// Return: object Status Delete
// ReturnType: object
function JSoProductDeleteMultiple(){
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
        
        var aDataDelMultiple    = $('#odvModalDeletePdtMultiple #ohdConfirmIDDelMultiple').val();
        var aTextsDelMultiple   = aDataDelMultiple.substring(0, aDataDelMultiple.length - 2);
        var aDataSplit          = aTextsDelMultiple.split(" , ");
        var nDataSplitlength    = aDataSplit.length;
        var aNewIdDelete        = [];
        for ($i = 0; $i < nDataSplitlength; $i++) {
            aNewIdDelete.push(aDataSplit[$i]);
        }
        if (nDataSplitlength > 1){
            JCNxOpenLoading();
            localStorage.StaDeleteArray = '1';
            $.ajax({
                type: "POST",
                url: "productEventDelete",
                data: { 'tIDCode': aNewIdDelete },
                cache: false,
                timeout: 0,
                success: function(oResult) {
                    var aReturnData = JSON.parse(oResult);
                    if(aReturnData['nStaEvent'] == 1) {
                        setTimeout(function(){
                            $('#odvModalDeletePdtMultiple').modal('hide');
                            $('#odvModalDeletePdtMultiple #ospTextConfirmDelMultiple').empty();
                            $('#odvModalDeletePdtMultiple #ohdConfirmIDDelMultiple').val('');
                            localStorage.removeItem('LocalItemData');
                            JSvCallPageProductList();
                            $('.modal-backdrop').remove();
                        });
                    }else{
                        JCNxCloseLoading();
                        FSvCMNSetMsgErrorDialog(aReturnData['tStaMessg']);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }
    }else{
        JCNxShowMsgSessionExpired();
    }
}

// Functionality: Function Check Is Create Page
// Parameters: Event Documet Redy
// Creator: 26/03/2019 wasin(Yoshi)
// Return: object Status Delete
// ReturnType: boolean
function JSbProductIsCreatePage(){
    try{
        const tPdtCode = $('#oetPdtCode').data('is-created');    
        var bStatus = false;
        if(tPdtCode ==  ""){ // No have data
            bStatus = true;
        }
        return bStatus;
    }catch(err){
        console.log('JSbProductIsCreatePage Error: ', err);
    }
}

// Functionality: Function Check Is Update Page
// Parameters: Event Documet Redy
// Creator: 26/03/2019 wasin(Yoshi)
// Return: object Status Delete
// ReturnType: boolean
function JSbProductIsUpdatePage(){
    try{
        const tPdtCode = $('#oetPdtCode').data('is-created');
        var bStatus = false;
        if(!tPdtCode == ""){ // Have data
            bStatus = true;
        }
        return bStatus;
    }catch(err){
        console.log('JSbProductIsUpdatePage Error: ', err);
    }
}

// Functionality : Show or Hide Component
// Parameters : ptComponent is element on document(id or class or...),pbVisible is visible
// Creator : 26/03/2019 Wasin (Yoshi)
// Return : -
// Return Type : -
function JSxProductVisibleComponent(ptComponent, pbVisible, ptEffect){
    try{
        if(pbVisible == false){
            $(ptComponent).addClass('hidden');
        }
        if(pbVisible == true){
            // $(ptComponent).removeClass('hidden');
            $(ptComponent).removeClass('hidden fadeIn animated').addClass('fadeIn animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend',function(){
                $(this).removeClass('hidden fadeIn animated');
            });
        }
    }catch(err){
        console.log('JSxProductVisibleComponent Error: ', err);
    }
}