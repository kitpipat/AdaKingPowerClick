var nStaViaBrowseType   = $('#oetViaStaBrowse').val();
var tCallViaBackOption  = $('#oetViaCallBackOption').val();
// alert(nStaViaBrowseType+'//'+tCallViaBackOption);
$('document').ready(function(){
    localStorage.removeItem('LocalItemData');
    JSxCheckPinMenuClose(); /*Check เปิดปิด Menu ตาม Pin*/
    JSxViaNavDefult();
    if(nStaViaBrowseType != 1){
        JSvCallPageShipViaList();
    }else{
        JSvCallPageShipViaAdd();
    }
});

//function : Function Clear Defult Button ShipVia
//Parameters : Document Ready
//Creator : 17/10/2018 witsarut
//Return : Show Tab Menu
//Return Type : -
function JSxViaNavDefult(){
    if(nStaViaBrowseType != 1 || nStaViaBrowseType == undefined){
        $('.xCNViaVBrowse').hide();
        $('.xCNViaVMaster').show();
        $('.xCNChoose').hide();
        $('#oliViaTitleAdd').hide();
        $('#oliViaTitleEdit').hide();
        $('#odvBtnAddEdit').hide();
        $('#odvBtnViaInfo').show();
    }else{
        $('#odvModalBody .xCNViaVMaster').hide();
        $('#odvModalBody .xCNViaVBrowse').show();
        $('#odvModalBody #odvViaMainMenu').removeClass('main-menu');
        $('#odvModalBody #oliViaNavBrowse').css('padding', '2px');
        $('#odvModalBody #odvViaBtnGroup').css('padding', '0');
        $('#odvModalBody .xCNViaBrowseLine').css('padding', '0px 0px');
        $('#odvModalBody .xCNViaBrowseLine').css('border-bottom', '1px solid #e3e3e3');
    }
}

//function : Function Show Event Error
//Parameters : Error Ajax Function 
//Creator : 17/10/2018 witsarut
//Return : Modal Status Error
//Return Type : view
function JCNxResponseError(jqXHR,textStatus,errorThrown){
    JCNxCloseLoading();
    var tHtmlError = $(jqXHR.responseText);
    var tMsgError = "<h3 style='font-size:20px;color:red'>";
    tMsgError += "<i class='fa fa-exclamation-triangle'></i>";
    tMsgError += " Error<hr></h3>";
    switch (jqXHR.status) {
        case 404:
            tMsgError += tHtmlError.find('p:nth-child(2)').text();
            break;
        case 500:
            tMsgError += tHtmlError.find('p:nth-child(3)').text();
            break;

        default:
            tMsgError += 'something had error. please contact admin';
            break;
    }
    $("body").append(tModal);
    $('#modal-customs').attr("style", 'width: 450px; margin: 1.75rem auto;top:20%;');
    $('#myModal').modal({ show: true });
    $('#odvModalBody').html(tMsgError);
}

//function : Call ShipVia Page list  
//Parameters : Document Redy And Event Button
//Creator :	17/10/2018 witsarut
//Return : View
//Return Type : View
function JSvCallPageShipViaList(){
    localStorage.tStaPageNow = 'JSvCallPageShipViaList';
    $('#oetSearchShipVia').val('');
    JCNxOpenLoading();    
    $.ajax({
        type: "POST",
        url: "shipviaList",
        cache: false,
        timeout: 0,
        success: function(tResult){
            $('#odvContentPageShipVia').html(tResult);
            JSvShipViaDataTable();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

//function: Call ShipVia Data List
//Parameters: Ajax Success Event 
//Creator:	17/10/2018 witsarut
//Return: View
//Return Type: View
function JSvShipViaDataTable(pnPage){
    var tSearchAll      = $('#oetSearchShipVia').val();
    var nPageCurrent    = (pnPage === undefined || pnPage == '')? '1' : pnPage;
    $.ajax({
        type: "POST",
        url: "shipviaDataTable",
        data: {
            tSearchAll: tSearchAll,
            nPageCurrent: nPageCurrent,
        },
        cache: false,
        Timeout: 0,
        success: function(tResult){
            if (tResult != "") {
                $('#ostDataShipVia').html(tResult);
            }
            JSxViaNavDefult();
            JCNxLayoutControll();
            JStCMMGetPanalLangHTML('TCNMShipVia_L'); //โหลดภาษาใหม่
            JCNxCloseLoading();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

//Functionality : Call ShipVia Page Add  
//Parameters : Event Button Click
//Creator : 17/10/2018 witsarut
//Return : View
//Return Type : View
function JSvCallPageShipViaAdd(){
    JCNxOpenLoading();
    JStCMMGetPanalLangSystemHTML('', '');
    $.ajax({
        type: "POST",
        url: "shipviaPageAdd",
        cache: false,
        timeout: 0,
        success: function(tResult){
            if (nStaViaBrowseType == 1) {
                $('#odvModalBodyBrowse').html(tResult);
                $('#odvModalBodyBrowse .panel-body').css('padding-top','0');

                // $('.xCNViaVMaster').hide();
                // $('.xCNViaVBrowse').show();
            }else{
                $('.xCNViaVBrowse').hide();
                $('.xCNViaVMaster').show();
                $('#oliViaTitleEdit').hide();
                $('#oliViaTitleAdd').show();
                $('#odvBtnViaInfo').hide();
                $('#odvBtnAddEdit').show();
            }
            $('#odvContentPageShipVia').html(tResult);
            JCNxLayoutControll();
            JCNxCloseLoading();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

//Functionality : Call ShipVia Page Edit  
//Parameters : Event Button Click 
//Creator : 17/10/2018 witsarut
//Return : View
//Return Type : View
function JSvCallPageShipViaEdit(ptViaCode){
    JCNxOpenLoading();
    JStCMMGetPanalLangSystemHTML('JSvCallPageShipViaEdit',ptViaCode);
    $.ajax({
        type: "POST",
        url: "shipviaPageEdit",
        data: { tViaCode: ptViaCode },
        cache: false,
        timeout: 0,
        success: function(tResult){
            if(tResult != ''){
                $('#oliViaTitleAdd').hide();
                $('#oliViaTitleEdit').show();
                $('#odvBtnViaInfo').hide();
                $('#odvBtnAddEdit').show();
                $('#odvContentPageShipVia').html(tResult);
                $('#oetViaCode').addClass('xCNDisable');
                $('#oetViaCode').attr('readonly', true);
                $('.xCNBtnGenCode').attr('disabled', true);
            }
            JCNxLayoutControll();
            JCNxCloseLoading();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

//Functionality : Event Add/Edit ShipVia
//Parameters : From Submit
//Creator : 17/10/2018 witsarut
//Return : Status Event Add/Edit ShipVia
//Return Type : object
function JSoAddEditShipVia(ptRoute){
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
        $('#ofmAddShipVia').validate().destroy();
        $.validator.addMethod('dublicateCode', function(value, element) {
            if(ptRoute == "shipviaEventAdd"){
                if($("#ohdCheckDuplicateViaCode").val() == 1){
                    return false;
                }else{
                    return true;
                }
            }else{
                return true;
            }
        },'');
        $('#ofmAddShipVia').validate({
            rules: {
                oetViaCode:     {
                    "required": {
                        depends: function(oElement) {
                            if(ptRoute == "shipviaEventAdd"){
                                if($('#ocbShipviaAutoGenCode').is(':checked')){
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
                oetViaName: {"required" :{}},
            },
            messages: {
                oetViaCode : {
                    "required"      : $('#oetViaCode').attr('data-validate-required'),
                    "dublicateCode" : $('#oetViaCode').attr('data-validate-dublicateCode')
                },
                oetViaName : {
                    "required"      : $('#oetViaName').attr('data-validate-required'),
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
                $( element ).closest('.form-group').addClass( "has-error" ).removeClass( "has-success" );
            },
            unhighlight: function(element, errorClass, validClass) {
                $( element ).closest('.form-group').addClass( "has-success" ).removeClass( "has-error" );
            },
        submitHandler: function(form){
            JCNxOpenLoading();
            $.ajax({
                type: "POST",
                url: ptRoute,
                data: $('#ofmAddShipVia').serialize(),
                success: function(oResult){
                    if(nStaViaBrowseType != 1) {
                        var aReturn = JSON.parse(oResult);
                        if(aReturn['nStaEvent'] == 1){
                            switch(aReturn['nStaCallBack']) {
                                case '1':
                                    JSvCallPageShipViaEdit(aReturn['tCodeReturn']);
                                    break;
                                case '2':
                                    JSvCallPageShipViaAdd();
                                    break;
                                case '3':
                                    JSvCallPageShipViaList();
                                    break;
                                default:
                                    JSvCallPageShipViaEdit(aReturn['tCodeReturn']);
                            }
                        }else{
                            alert(aReturn['tStaMessg']);
                        }
                    }else{
                        JCNxCloseLoading();
                        JCNxBrowseData(tCallViaBackOption);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            },
        });
    }
}

//Functionality : Generate Code ShipVia
//Parameters : Event Button Click
//Creator : 17/10/2018 witsarut
//Return : Event Push Value In Input
//Return Type : -
function JStGenerateShipViaCode(){
    $('#oetViaCode').parent().removeClass('alert-validate');
    var tTableName = 'TCNMShipVia';
    JCNxOpenLoading();
    $.ajax({
        type: "POST",
        url: "generateCode",
        data: { tTableName: tTableName },
        cache: false,
        timeout: 0,
        success: function(tResult) {
            var tData = $.parseJSON(tResult);
            if (tData.rtCode == '1') {
                $('#oetViaCode').val(tData.rtViaCode);
                $('#oetViaCode').addClass('xCNDisable');
                $('#oetViaCode').attr('readonly', true);
                $('.xCNBtnGenCode').attr('disabled', true); //เปลี่ยน Class ใหม่
                $('#oetViaName').focus();
            } else {
                $('#oetViaCode').val(tData.rtDesc);
            }
            JCNxCloseLoading();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseErroe(jqXHR, textStatus, errorThrown);
        }
    });
}

//Functionality : Event Single Delete
//Parameters : Event Icon Delete
//Creator : 17/10/2018 witsarut
//Return : object Status Delete
//Return Type : object
function JSoShipViaDel(tIDCode){
    var aData               = $('#ospConfirmIDDelete').val();
    var aTexts              = aData.substring(0, aData.length - 2);
    var aDataSplit          = aTexts.split(" , ");
    var aDataSplitlength    = aDataSplit.length;
    var aNewIdDelete        = [];
    if (aDataSplitlength == '1'){
       
        $('#odvModalDelShipVia').modal('show');
        $('#ospConfirmDelete').html('ยืนยันการลบข้อมูล หมายเลข : ' + tIDCode);
        $('#osmConfirm').on('click', function(evt){
            JCNxOpenLoading();
            $.ajax({
                type: "POST",
                url: "shipviaEventDelete",
                data: { 'tIDCode': tIDCode },
                cache: false,
                timeout: 0,
                success: function(oResult){
                    var aReturn = JSON.parse(oResult);
                    if (aReturn['nStaEvent'] == 1){
                        $('#odvModalDelShipVia').modal('hide');
                        $('#ospConfirmDelete').text('ยืนยันการลบข้อมูลของ : ');
                        $('#ospConfirmIDDelete').val('');
                        localStorage.removeItem('LocalItemData');
                        setTimeout(function() {
                            JSvShipViaDataTable();
                        }, 500);
                    }else{
                        alert(aReturn['tStaMessg']);                        
                    }
                    JSxViaNavDefult();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        });
    }
}

//Functionality: Event Multi Delete
//Parameters: Event Button Delete All
//Creator: 17/10/2018 witsarut
//Return:  object Status Delete
//Return Type: object
function JSoShipViaDelChoose(){
    JCNxOpenLoading();
    var aData       = $('#ospConfirmIDDelete').val();
    var aTexts      = aData.substring(0, aData.length - 2);
    var aDataSplit  = aTexts.split(" , ");
    var aDataSplitlength = aDataSplit.length;
    var aNewIdDelete = [];
    for ($i = 0; $i < aDataSplitlength; $i++) {
        aNewIdDelete.push(aDataSplit[$i]);
    }
    if (aDataSplitlength > 1){
        localStorage.StaDeleteArray = '1';
        $.ajax({
            type: "POST",
            url: "shipviaEventDelete",
            data: { 'tIDCode': aNewIdDelete },
            cache: false,
            timeout: 0,
            success: function(oResult) {
                var aReturn = JSON.parse(oResult);
                if (aReturn['nStaEvent'] == 1) {
                    setTimeout(function() {
                        $('#odvModalDelShipVia').modal('hide');
                        JSvCallPageShipViaList();
                        $('#ospConfirmDelete').text('ยืนยันการลบข้อมูลของ : ');
                        $('#ospConfirmIDDelete').val('');
                        localStorage.removeItem('LocalItemData');
                        $('.modal-backdrop').remove();
                    },1000);
                }else{
                    alert(aReturn['tStaMessg']);
                }
                JSxViaNavDefult();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }else{
        localStorage.StaDeleteArray = '0';
        return false;
    }
}

//Functionality : เปลี่ยนหน้า pagenation
//Parameters : Event Click Pagenation
//Creator : 17/10/2018 witsarut
//Return : View
//Return Type : View
function JSvShipViaClickPage(ptPage) {
    var nPageCurrent = '';
    switch (ptPage) {
        case 'next': //กดปุ่ม Next
            $('.xWBtnNext').addClass('disabled');
            nPageOld = $('.xWPageShipVia .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
            nPageCurrent = nPageNew
            break;
        case 'previous': //กดปุ่ม Previous
            nPageOld = $('.xWPageShipVia .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
            nPageCurrent = nPageNew
            break;
        default:
            nPageCurrent = ptPage
    }
    JCNxOpenLoading();
    JSvShipViaDataTable(nPageCurrent);
}

//Functionality: Function Chack And Show Button Delete All
//Parameters: LocalStorage Data
//Creator: 17/10/2018 witsarut
//Return: - 
//Return Type: -
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

//Functionality: Insert Text In Modal Delete
//Parameters: LocalStorage Data
//Creator: 17/10/2018 witsarut
//Return: -
//Return Type: -
function JSxTextinModal() {
    var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
    if (aArrayConvert[0] == null || aArrayConvert[0] == '') {} else {
        var tText = '';
        var tTextCode = '';
        for ($i = 0; $i < aArrayConvert[0].length; $i++) {
            tText += aArrayConvert[0][$i].tName + '(' + aArrayConvert[0][$i].nCode + ') ';
            tText += ' , ';

            tTextCode += aArrayConvert[0][$i].nCode;
            tTextCode += ' , ';
        }
        var tTexts = tText.substring(0, tText.length - 2);
        $('#ospConfirmDelete').text('ยืนยันการลบข้อมูลของ : ' + tTexts);
        $('#ospConfirmIDDelete').val(tTextCode);
    }
}

//Functionality: Function Chack Value LocalStorage
//Parameters: Event Select List Reason
//Creator: 17/10/2018 witsarut
//Return: Duplicate/none
//Return Type: string
function findObjectByKey(array, key, value) {
    for (var i = 0; i < array.length; i++) {
        if (array[i][key] === value) {
            return 'Dupilcate';
        }
    }
    return 'None';
}

// Functionality: Function Check Is Create Page
// Parameters: Event Documet Redy
// Creator: 22/03/2019 wasin(Yoshi)
// Return: object Status Delete
// ReturnType: boolean
function JSbShipviaIsCreatePage(){
    try{
        const tViaCode = $('#oetViaCode').data('is-created');    
        var bStatus = false;
        if(tViaCode == ""){ // No have data
            bStatus = true;
        }
        return bStatus;
    }catch(err){
        console.log('JSbShipviaIsCreatePage Error: ', err);
    }
}

// Functionality: Function Check Is Update Page
// Parameters: Event Documet Redy
// Creator: 22/03/2019 wasin(Yoshi)
// Return: object Status Delete
// ReturnType: boolean
function JSbShipviaIsUpdatePage(){
    try{
        const tViaCode = $('#oetViaCode').data('is-created');
        var bStatus = false;
        if(!tViaCode == ""){ // Have data
            bStatus = true;
        }
        return bStatus;
    }catch(err){
        console.log('JSbShipviaIsUpdatePage Error: ', err);
    }
}

// Functionality : Show or Hide Component
// Parameters : ptComponent is element on document(id or class or...),pbVisible is visible
// Creator : 22/03/2019 Wasin (Yoshi)
// Return : -
// Return Type : -
function JSxShipviaVisibleComponent(ptComponent, pbVisible, ptEffect){
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
        console.log('JSxVoucherVisibleComponent Error: ', err);
    }
}
