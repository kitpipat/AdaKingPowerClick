var nStaPosBrowseType   = $('#oetPosStaBrowse').val();
var tCallPosBackOption  = $('#oetPosCallBackOption').val();
var nRouteFrom          = $('#oetPosnRouteFrom').val();

var bValidFormAddPosTabGeneral = false;
var bValidFormAddPosTabAddress = false;
var nCurrentValidTab = 1; // 1 general 2 address
var nCurrentDisplayTab = 1; // 1 general 2 address

$('document').ready(function(){
    localStorage.removeItem('LocalItemData');
    JSxCheckPinMenuClose(); /*Check เปิดปิด Menu ตาม Pin*/
    JSxPosNavDefult();
    if(nStaPosBrowseType != 1){
        JSvCallPageSaleMachineList();
    }else{
        JSvCallPageSaleMachineAdd();
    }

    // สร้างเครื่องจุดขายจากหน้าจอ รูปแบบตู้ฝาก POS Type 5 ไม่ใช้คลังสินค้า ต้องปิดคลังไป
    if( nStaPosBrowseType == '1' && nRouteFrom == '5' ){
        setTimeout(function(){
            $('#odvWarehouseForm').css("display","none");
        }, 1000);
        
    }

});

//function : Function Clear Defult Button SaleMachine
//Parameters : Document Ready
//Creator : 30/10/2018 witsarut
//Return : Show Tab Menu
//Return Type : -
function JSxPosNavDefult(){
    if(nStaPosBrowseType != 1 || nStaPosBrowseType == undefined){
        $('.xCNPosVBrowse').hide();
        $('.xCNPosVMaster').show();
        $('.xCNChoose').hide();
        $('#oliPosTitleAdd').hide();
        $('#oliPosTitleEdit').hide();
        $('#oliPosTitleAddPageDivice').hide();
        $('#odvBtnAddEdit').hide();
        $('#odvBtnPosInfo').show();
    }else{
        $('#odvModalBody .xCNPosVMaster').hide();
        $('#odvModalBody .xCNPosVBrowse').show();
        $('#odvModalBody #odvPosMainMenu').removeClass('main-menu');
        $('#odvModalBody #oliPosNavBrowse').css('padding', '2px');
        $('#odvModalBody #odvPosBtnGroup').css('padding', '0');
        $('#odvModalBody .xCNPosBrowseLine').css('padding', '0px 0px');
        $('#odvModalBody .xCNPosBrowseLine').css('border-bottom', '1px solid #e3e3e3');
    }
}

//function : Function Show Event Error
//Parameters : Error Ajax Function 
//Creator : 30/10/2018 witsarut
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

//function : Call SaleMachine Page list  
//Parameters : Document Redy And Event Button
//Creator :	30/10/2018 witsarut
//Return : View
//Return Type : View
function JSvCallPageSaleMachineList(){
    localStorage.tStaPageNow = 'JSvCallPageSaleMachineList';
    $('#oetSearchSaleMachine').val('');
    JCNxOpenLoading();    
    $.ajax({
        type: "POST",
        url: "salemachineList",
        cache: false,
        timeout: 0,
        success: function(tResult){
            $('#odvContentPageSaleMachine').html(tResult);
            JSvSaleMachineDataTable();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}


//function: Call SaleMachine Data List
//Parameters: Ajax Success Event 
//Creator:	30/10/2018 witsarut
//Return: View
//Return Type: View
function JSvSaleMachineDataTable(pnPage){
    var tSearchAll      = $('#oetSearchSaleMachine').val();
    var nPageCurrent    = (pnPage === undefined || pnPage == '')? '1' : pnPage;
    $.ajax({
        type: "POST",
        url: "salemachineDataTable",
        data: {
            tSearchAll: tSearchAll,
            nPageCurrent: nPageCurrent,
        },
        cache: false,
        Timeout: 0,
        success: function(tResult){
            if (tResult != "") {
                $('#ostDataSaleMachine').html(tResult);
            }
            JSxPosNavDefult();
            JCNxLayoutControll();
            JCNxCloseLoading();
            localStorage.removeItem('LocalItemData');
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

//Functionality : Call SaleMachine Page Add  
//Parameters : Event Button Click
//Creator : 30/10/2018 witsarut
//Update : 28/03/2019 pap
//Return : View
//Return Type : View
function JSvCallPageSaleMachineAdd(){
    JCNxOpenLoading();
    JStCMMGetPanalLangSystemHTML('', '');
    var nRoutetype = nRouteFrom;
    $.ajax({
        type: "POST",
        url: "salemachinePageAdd",
        data : {
            nRoutetype : nRoutetype
        },
        cache: false,
        timeout: 0,
        success: function(tResult){
            if (nStaPosBrowseType == 1) {
                $('.xCNPosVMaster').hide();
                $('.xCNPosVBrowse').show();
                $('#odvModalBodyBrowse').html(tResult)
                $('#odvModalBodyBrowse .panel-body').css('padding-top','0');
            }else{
                $('.xCNPosVBrowse').hide();
                $('.xCNPosVMaster').show();
                $('#oliPosTitleEdit').hide();
                $('#oliPosTitleAdd').show();
                $('#odvBtnPosInfo').hide();
                $('#odvBtnAddEdit').show();
            }
       
            $('#odvContentPageSaleMachine').html(tResult);
            JCNxCloseLoading();
            JCNxLayoutControll();
 
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

//Functionality : Call SaleMachine Page Edit  
//Parameters : Event Button Click 
//Creator : 30/10/2018 witsarut
//updete  : 23/09/2019 Saharat(Golf)
//Return : View
//Return Type : View
function JSvCallPageSaleMachineEdit(ptPosCode,ptPosType,ptBchCode){
    JCNxOpenLoading();
    JStCMMGetPanalLangSystemHTML('JSvCallPageSaleMachineEdit',ptPosCode);
    if(ptPosType == undefined && ptPosType == null){
        var ptPosType = $('#ocmPosType').val();
    }
    $.ajax({
        type: "POST",
        url: "salemachinePageEdit",
        data: { tPosCode : ptPosCode,
                tPosType : ptPosType,
                tBchCode : ptBchCode
        },
        cache: false,
        timeout: 0,
        success: function(tResult){
            if(tResult != ''){
                $('#oliPosTitleAdd').hide();
                $('#oliPosTitleEdit').show();
                $('#odvBtnPosInfo').hide();
                $('#odvBtnAddEdit').show();
                $('#odvContentPageSaleMachine').html(tResult);
                $("#ocmPosType option[value='" + ptPosType + "']").attr('selected', true).trigger('change');
                $('#oetPosCode').addClass('xCNDisable');
                $('#oetPosCode').attr('readonly', true);
                $('.xCNBtnGenCode').attr('disabled', true);
            }
            $.ajax({
                type: "POST",
                url: "salemachinedeviceDataTable",
                data: {
                    tSearchAll: "",
                    nPageCurrent: 1,
                    nPosCode: ptPosCode,
                    tBchCode : ptBchCode
                },
                cache: false,
                Timeout: 0,
                success: function(tResult){
                    $('#odvMachineContentPage').html(tResult);
                    $('#obtSearchSaleMachineDevice').click(function(){
                        var tPosCode = $('#oetPosCode').val();
                        JCNxOpenLoading();
                        JSvSaleMachineDeviceDataTable(1,tPosCode);
                        
                    });
                    JSxPhwInMacNavDefult();
                    JCNxLayoutControll();
                    JCNxCloseLoading();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
            
            $("#ocmPosType").change(function(){
                var tPosType =  $("#ocmPosType option:selected").val();
                if(tPosType != 4 && tPosType != 1){
                     $("#odvWarehouseForm").css("display","none");
                     $("#oetBchWahCode").attr("disabled","disabled");
                     $("#oetBchWahName").attr("disabled","disabled");
                }else{
                     $("#odvWarehouseForm").css("display","block");
                     $("#oetBchWahCode").removeAttr("disabled");
                     $("#oetBchWahCode").val("");
                     $("#oetBchWahName").removeAttr("disabled");
                     $("#oetBchWahName").val("");
                    //  JSxValidFormAddEditSaleMachineTapGeneral();
                }
             });
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

//function : Function Clear Defult Button SaleMachineDevice
//Parameters : Document Ready
//Creator : 07/11/2018 pap
//Return : Show Tab Menu
//Return Type : -
function JSxPhwInMacNavDefult(){
    
    if(nStaPosBrowseType != 1 || nStaPosBrowseType == undefined){
        $('.xCNPhwVBrowse').hide();
        $('.xCNPhwVMaster').show();
        $('.xCNChoose').hide();
        $('#oliPhwTitleAdd').hide();
        $('#oliPhwTitleEdit').hide();
        $('#oliPhwTitleAddPageDivice').hide();
        $('#odvBtnMacAddEdit').hide();
        $('#odvBtnMacPhwInfo').show();
    }else{
        
        $('#odvModalBody .xCNPhwVMaster').hide();
        $('#odvModalBody .xCNPhwVBrowse').show();
        $('#odvModalBody #odvPhwMainMenu').removeClass('main-menu');
        $('#odvModalBody #oliPhwNavBrowse').css('padding', '2px');
        $('#odvModalBody #odvPhwBtnGroup').css('padding', '0');
        $('#odvModalBody .xCNPhwBrowseLine').css('padding', '0px 0px');
        $('#odvModalBody .xCNPhwBrowseLine').css('border-bottom', '1px solid #e3e3e3');
    }
}

//Functionality : เซ็ตค่าเพื่อให้รู้ว่าตอนนี้แท็ปไหนแสดงอยู่
//Parameters : -
//Creator : 28/03/2019 pap
//Update : -
//Return : -
//Return Type : -
function JSxSetStatusCurrentTab(pnNumCurTab){
    nCurrentDisplayTab = pnNumCurTab;
}

//Functionality : เซ็ตค่าสเตตัสการกดปุ่ม ซับมิสฟอร์ม เพื่อให้รู้ว่าฟอร์มเกิดการซับมิสจากการกดปุ่มจริง  (มีการซับมิสฟอร์มหลอกๆเพื่อให้เกิดการตรวจสอบ)
//Parameters : -
//Creator : 28/03/2019 pap
//Update : -
//Return : -
//Return Type : -
function JSxSetStatusClickPosSubmit(){
    $("#ohdCheckPosClearValidate").val("1");
}

//Functionality : Event Add/Edit SaleMachine
//Parameters : From Submit
//Creator : 30/10/2018 witsarut
//Update : 23/09/2019 Saharat(Golf)
//Return : Status Event Add/Edit SaleMachine
//Return Type : object
function JSoAddEditSaleMachine(){
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
        $('#ofmAddSaleMachine').validate().destroy();
        $.validator.addMethod('dublicateCode', function(value, element) {
            if($('#ohdTMacFormRoute').val() == "salemachineEventAdd"){
                if ($("#ohdCheckPosValidate").val() == 1) {
                    return false;
                } else {
                    return true;
                }
            } else {
                return true;
            }
        }, '');
        $('#ofmAddSaleMachine').validate({
            rules: {
                oetPosCode: {
                    "required": {
                        depends: function(oElement) {
                            if($('#ohdTMacFormRoute').val() == "salemachineEventAdd"){
                                if ($('#ocbPosAutoGenCode').is(':checked')) {
                                    return false;
                                } else {
                                    return true;
                                }
                            } else {
                                return true;
                            }
                        }
                    },
                    // "dublicateCode": {}
                },
                oetPosName : {"required": {}},
                oetPosRegNo: { "required": {} },
                oetPosBchName: { "required": {} },
            },
            messages: {
                oetPosCode: {
                    "required": $('#oetPosCode').attr('data-validate-required'),
                    // "dublicateCode": $('#oetPosCode').attr('data-validate-dublicateCode')
                },
                oetPosRegNo: {
                    "required": $('#oetPosRegNo').attr('data-validate-required'),
                },
                oetPosBchName: {
                    "required": $('#oetPosBchName').attr('data-validate-required'),
                },
                oetPosName:{
                    "required": $('#oetPosName').attr('data-validate-required'),
                },
            },
            errorElement: "em",
            errorPlacement: function(error, element) {
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
            highlight: function(element, errorClass, validClass) {
                $(element).closest('.form-group').addClass("has-error").removeClass("has-success");
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).closest('.form-group').addClass("has-success").removeClass("has-error");
            },
            submitHandler: function(form) {
                $('#ocmPosType').attr('disabled',false);
                $.ajax({
                    type: "POST",
                    url: $("#ohdTMacFormRoute").val(),
                    data: $('#ofmAddSaleMachine').serialize(),
                    success: function(oResult){
                        if(nStaPosBrowseType != 1) {
                            var aReturn = JSON.parse(oResult);
                            if(aReturn['nStaEvent'] == 1){
                                switch(aReturn['nStaCallBack']) {
                                    case '1':
                                        JSvCallPageSaleMachineEdit(aReturn['tCodeReturn'],aReturn['tPosType'],aReturn['tBchCode']);
                                        break;
                                    case '2':
                                        JSvCallPageSaleMachineAdd();
                                        break;
                                    case '3':
                                        JSvCallPageSaleMachineList();
                                        break;
                                    default:
                                        JSvCallPageSaleMachineEdit(aReturn['tCodeReturn'],aReturn['tPosType'],aReturn['tBchCode']);
                                }
                            }else{
                                alert(aReturn['tStaMessg']);
                                JSvCallPageSaleMachineList();
                            }
                        }else{
                            JCNxCloseLoading();
                            JCNxBrowseData(tCallPosBackOption);
                            
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

function JSxPosSubmitEventByButton(){
    JCNxOpenLoading();
    $.ajax({
        type: "POST",
        url: $("#ohdTMacFormRoute").val(),
        data: $('#ofmAddSaleMachine').serialize(),
        success: function(oResult){
            if(nStaPosBrowseType != 1) {
                var aReturn = JSON.parse(oResult);
                if(aReturn['nStaEvent'] == 1){
                    switch(aReturn['nStaCallBack']) {
                        case '1':
                            JSvCallPageSaleMachineEdit(aReturn['tCodeReturn']);
                            break;
                        case '2':
                            JSvCallPageSaleMachineAdd();
                            break;
                        case '3':
                            JSvCallPageSaleMachineList();
                            break;
                        default:
                            JSvCallPageSaleMachineEdit(aReturn['tCodeReturn']);
                    }
                }else{
                    alert(aReturn['tStaMessg']);
                    JSvCallPageSaleMachineList();
                }
            }else{
                JCNxCloseLoading();
                JCNxBrowseData(tCallPosBackOption);
                
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

   

//Functionality : Event Single Delete
//Parameters : Event Icon Delete
//Creator : 30/10/2018 witsarut
//update : 17/09/2019 Saharat(golf)
//Return : object Status Delete
//Return Type : object
function JSoSaleMachineDel(pnPage,ptName,tIDCode,ptBchCode){
 
    var aData               = $('#ohdConfirmIDDelete').val();
    var aTexts              = aData.substring(0, aData.length - 2);
    var aDataSplit          = aTexts.split(" , ");
    var aDataSplitlength    = aDataSplit.length;
    var aNewIdDelete        = [];

    var tConfirm =$('#ohdDeleteconfirm').val();
    var tConfirmYN =$('#ohdDeleteconfirmYN').val();
    if (aDataSplitlength == '1') {

        $('#odvModalDelSaleMachine').modal('show');
        $('#ospConfirmDelete').text(tConfirm + ' ' + tIDCode + ' ( ' + ptName + ' ) ' +tConfirmYN);
        $('#osmConfirm').on('click', function(evt) {

            if (localStorage.StaDeleteArray != '1') {
                JCNxOpenLoading();
                $.ajax({
                    type: "POST",
                    url: "salemachineEventDelete",
                    data: { 
                        'tIDCode'   : tIDCode,
                        'tBchCode'  : ptBchCode
                    },
                    cache: false,
                    success: function(tResult) {
                        tResult = tResult.trim();
                        var tData = $.parseJSON(tResult);
                        if (tData['nStaEvent'] == '1'){
                            $('#odvModalDelSaleMachine').modal('hide');
                            $('#ospConfirmDelete').empty();
                            localStorage.removeItem('LocalItemData');
                            $('#odvModalDelSaleMachine .ohdConfirmIDDelete').val('');
                            setTimeout(function() {
                                if(tData["nNumRowPos"]!=0){
                                    if(tData["nNumRowPos"]>10){
                                        nNumPage = Math.ceil(tData["nNumRowPos"]/10);
                                        if(pnPage<=nNumPage){
                                            JSvSaleMachineDataTable(pnPage);
                                        }else{
                                            JSvSaleMachineDataTable(nNumPage);
                                        }
                                    }else{
                                        JSvSaleMachineDataTable(1);
                                    }
                                }else{
                                    JSvSaleMachineDataTable(1);
                                }
                            }, 500);
                        }else{
                            JCNxCloseLoading();
                            alert(tData['tStaMessg']);                        
                        }
                        JSxPosNavDefult();
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            }


        });
    }
}

//Functionality: Event Multi Delete
//Parameters: Event Button Delete All
//Creator: 30/10/2018 witsarut
//update : 17/09/2019 Saharat(golf)
//Return:  object Status Delete
//Return Type: object
function JSoSaleMachineDelChoose(tCurrentPage){
    var aData = $('#ohdConfirmIDDelete').val();
    var aTexts = aData.substring(0, aData.length - 2);
    var aDataSplit = aTexts.split(" , ");
    var aDataSplitlength = aDataSplit.length;
    var aNewIdDelete = [];

    for ($i = 0; $i < aDataSplitlength; $i++) {
        aNewIdDelete.push(aDataSplit[$i]);
    }

    if (aDataSplitlength > 1) {

        localStorage.StaDeleteArray = '1';
        JCNxOpenLoading();
        $.ajax({
            type: "POST",
            url: "salemachineEventDelete",
            data: { 'tIDCode': aNewIdDelete },
            success: function(tResult) {
                var aReturn = JSON.parse(tResult);
                if (aReturn['nStaEvent'] == '1'){
                    $('#odvModalDelSaleMachine').modal('hide');
                    $('#ospConfirmDelete').empty();
                    localStorage.removeItem('LocalItemData');
                    $('#odvModalDelSaleMachine .ohdConfirmIDDelete').val('');
                    $('#ospConfirmIDDelete').val('');
                    setTimeout(function() {
                        if(aReturn["nNumRowPos"]!=0){
                            if(aReturn["nNumRowPos"]>10){
                                nNumPage = Math.ceil(aReturn["nNumRowPos"]/10);
                                if(tCurrentPage<=nNumPage){
                                    JSvSaleMachineDataTable(tCurrentPage);
                                }else{
                                    JSvSaleMachineDataTable(nNumPage);
                                }
                            }else{
                                JSvSaleMachineDataTable(1);
                            }
                        }else{
                            JSvSaleMachineDataTable(1);
                        }
                    }, 500);
                }else{
                    JCNxCloseLoading();
                    alert(aReturn['tStaMessg']);                        
                }
                JSxPosNavDefult();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });


    } else {
        localStorage.StaDeleteArray = '0';

        return false;
    }
}

//Functionality : เปลี่ยนหน้า pagenation
//Parameters : Event Click Pagenation
//Creator : 30/10/2018 witsarut
//Return : View
//Return Type : View
function JSvSaleMachineClickPage(ptPage) {
    var nPageCurrent = '';
    switch (ptPage) {
        case 'next': //กดปุ่ม Next
            $('.xWBtnNext').addClass('disabled');
            nPageOld = $('.xCNBTNNumPagenation.active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
            nPageCurrent = nPageNew
            break;
        case 'previous': //กดปุ่ม Previous
            nPageOld = $('.xCNBTNNumPagenation.active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
            nPageCurrent = nPageNew
            break;
        default:
            nPageCurrent = ptPage
    }
    JCNxOpenLoading();
    JSvSaleMachineDataTable(nPageCurrent);
}

//Functionality: Function Chack And Show Button Delete All
//Parameters: LocalStorage Data
//Creator: 15/05/2018
//Return: - 
//Return Type: -
function JSxSaleMachineShowButtonChoose() {
    var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
    if (aArrayConvert[0] == null || aArrayConvert[0] == '') {
        $('#odvMngTableList #oliBtnDeleteAll').addClass('disabled');
    } else {
        nNumOfArr = aArrayConvert[0].length;
        if (nNumOfArr > 1) {
            $('#odvMngTableList #oliBtnDeleteAll').removeClass('disabled');
            $('.xCNIconDel').addClass('xCNDisabled');
        } else {
            $('#odvMngTableList #oliBtnDeleteAll').addClass('disabled');
            $('.xCNIconDel').removeClass('xCNDisabled');
        }
    }
}

//Functionality: Insert Text In Modal Delete
//Parameters: LocalStorage Data
//Creator: 15/05/2018 wasin
//Return: -
//Return Type: -
function JSxSaleMachinePaseCodeDelInModal() {
    var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
    if (aArrayConvert[0] == null || aArrayConvert[0] == '') {} else {
        var tTextCode = '';
        for ($i = 0; $i < aArrayConvert[0].length; $i++) {
            tTextCode += aArrayConvert[0][$i].nCode;
            tTextCode += ' , ';
        }
        $('#ospConfirmDelete').text($('#oetTextComfirmDeleteMulti').val());
        $('#ohdConfirmIDDelete').val(tTextCode);
    }
}


//Functionality: Function Chack Value LocalStorage
//Parameters: Event Select List Branch
//Creator: 06/06/2018 Krit
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
// Creator: 07/06/2019 saharat(Golf)
// Return: object Status Delete
// ReturnType: boolean
function JSbSaleMachineIsCreatePage() {
    try {
        const tPosCode = $('#oetPosCode').data('is-created');
        var bStatus = false;
        if (tPosCode == "") { // No have data
            bStatus = true;
        }
        return bStatus;
    } catch (err) {
        console.log('JSbSaleMachineIsCreatePage Error: ', err);
    }
}

// Functionality: Function Check Is Update Page
// Parameters: Event Documet Redy
// Creator: 07/06/2019 saharat(Golf)
// Return: object Status Delete
// ReturnType: boolean
function JSbSaleMachineIsUpdatePage() {
    try {
        const tPosCode = $('#oetPosCode').data('is-created');
        var bStatus = false;
        if (!tPosCode == "") { // Have data
            bStatus = true;
        }
        return bStatus;
    } catch (err) {
        console.log('JSbSaleMachineIsUpdatePage Error: ', err);
    }
}

// Functionality : Show or Hide Component
// Parameters : ptComponent is element on document(id or class or...),pbVisible is visible
// Creator: 07/06/2019 saharat(Golf)
// Return : -
// Return Type : -
function JSxSaleMachineVisibleComponent(ptComponent, pbVisible, ptEffect) {
    try {
        if (pbVisible == false) {
            $(ptComponent).addClass('hidden');
        }
        if (pbVisible == true) {

            $(ptComponent).removeClass('hidden fadeIn animated').addClass('fadeIn animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function() {
                $(this).removeClass('hidden fadeIn animated');
            });
        }
    } catch (err) {
        console.log('JSxSaleMachineVisibleComponent Error: ', err);
    }
}