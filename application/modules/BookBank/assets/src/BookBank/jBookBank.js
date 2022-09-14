var nStaCdcBrowseType = $('#oetBbkStaBrowse').val();
var tCallCdcBackOption = $('#oetBbkCallBackOption').val();

$('document').ready(function() {
    localStorage.removeItem('LocalItemData');
    JSxCheckPinMenuClose(); /*Check เปิดปิด Menu ตาม Pin*/
    JSxBBKNavDefult();

    if (nStaCdcBrowseType != 1) {
        JSvCallPageBookBankList();
    } else {
        JSvCallPageBookBankAdd();
    }

});

function JSxBBKNavDefult() {
    if (nStaCdcBrowseType != 1 || nStaCdcBrowseType == undefined) {
        $('.xCNCdcVBrowse').hide();
        $('.xCNBbkVMaster').show();
        $('#oliBbkTitleAdd').hide();
        $('#oliBbkTitleEdit').hide();
        $('#odvBtnBbkAddEdit').hide();
        $('#odvBtnBbkInfo').show();
        $('.obtChoose').hide();
    } else { 
        $('#odvModalBody .xCNCdcVMaster').hide();
        $('#odvModalBody .xCNCdcVBrowse').show();
        $('#odvModalBody #odvCdcMainMenu').removeClass('main-menu');
        $('#odvModalBody #oliBbkNavBrowse').css('padding', '2px');
        $('#odvModalBody #odvBbkBtnGroup').css('padding', '0');
        $('#odvModalBody .xCNBbkBrowseLine').css('padding', '0px 0px');
        $('#odvModalBody .xCNBbkBrowseLine').css('border-bottom', '1px solid #e3e3e3');
    }
}

//function : Function Show Event Error
//Parameters : Error Ajax Function 
//Creator : 02/07/2018 wasin
//Return : Modal Status Error
//Return Type : view
function JCNxResponseError(jqXHR, textStatus, errorThrown) {
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

//Functionality : Call Page  BookBankList
//Parameters : -
//Creator : 31/01/2020 Saharat(Golf)
//Return : View
//Return Type : View
function JSvCallPageBookBankList() {
    $.ajax({
        type: "GET",
        url: "BookBankList",
        cache: false,
        timeout: 0,
        success: function(tResult) {
            $('#odvContentPageBookBank').html(tResult);
            JSxBBKNavDefult();
            //แสดงข้อมูลใน List
            JSvCallPageBookBankDataTable(); 
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });

}

//Functionality : โหลดข้อมูล BookBank
//Parameters : pnPage หน้าของข้อมูล
//Creator : 31/01/2020 Saharat(Golf)
//Return : View
//Return Type : View
function JSvCallPageBookBankDataTable(pnPage) {
    var tSearchAll = $('#oetSearchAll').val();
    var nPageCurrent = pnPage;
    if (nPageCurrent == undefined || nPageCurrent == '') {
        nPageCurrent = '1';
    }
    JCNxOpenLoading();
    $.ajax({
        type: "POST",
        url: "BookBankDataTable",
        data: {            
                tSearchAll: tSearchAll,
                nPageCurrent: nPageCurrent
            },
        cache: false,
        timeout: 0,
        success: function(tResult) {
            $('#odvContentBookBankData').html(tResult);
            JSxBBKNavDefult();
            JCNxLayoutControll();
            JCNxCloseLoading();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });

}

//Functionality : โหลดหน้า เพิ่มข้อมูล BookBank
//Parameters : -
//Creator : 31/01/2020 Saharat(Golf)
//Return : View
//Return Type : View
function JSvCallPageBookBankAdd() {
    $.ajax({
        type: "GET",
        url: "BookBankEventPageAdd",
        data: {},
        cache: false,
        timeout: 0,
        success: function(tResult) {
            if (nStaCdcBrowseType == 1) {
                $('#odvModalBodyBrowse').html(tResult);
                $('#odvModalBodyBrowse .panel-body').css('padding-top', '0');
            } else {
                $('#oliBbkTitleEdit').hide();
                $('#oliBbkTitleAdd').show();
                $('#odvBtnBbkInfo').hide();
                $('#odvBtnBbkAddEdit').show();
            }
            $('#odvContentPageBookBank').html(tResult);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

//Functionality : (event) Add/Edit Bookbank
//Parameters : form
//Creator : 04/02/2020 Saharat(GolF)
//update : 10/04/2020 surawat
//Return : Status Add
//Return Type : n
function JSnAddEditBookbank(ptRoute) {
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
        
        $('#oetBbkBchCode').attr('data-nisdup', '0');
        $('#ofmAddBookbank').validate().destroy();
            $.validator.addMethod('dublicateCode', function(value, element) {
                if(ptRoute == "BookBankEventAddContentDetail"){
                    if( $('#oetBbkBchCode').attr('data-nisdup') == '1'){
                        return false;
                    }
                    return true;
                }else{
                    return true;
                }
            },'');

        // JCNxOpenLoading();
        
        $.ajax({
            type: "POST",
            url: "CheckInputGenCode",
            data: { 
                tTableName: "TFNMBookBank",
                tFieldName: "FTBbkCode",
                tCode: $("#oetBbkCode").val(),
                tFiledBch: 'FTBchCode',
                tBchCode: $("#oetBbkBchCode").val()
            },
            async : false,
            cache: false,
            timeout: 0,
            success: function(tResult){
                var oResult = JSON.parse(tResult);
                    
                $('#oetBbkBchCode').attr('data-nisdup', oResult['rtCode']);
                // console.log($('#oetBbkBchCode').attr('data-nisdup'));
                // JCNxCloseLoading();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
                JCNxCloseLoading();
            }
        });

        
        $('#ofmAddBookbank').validate({
            rules: {
                oetBbkCode:     {
                    "required": {
                        depends: function(oElement) {
                            if(ptRoute == "BookBankEventAddContentDetail"){
                                if($('#ocbBookbankAutoGenCode').is(':checked')){
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
                oetBbkName: {"required" :{}},
                oetBbkAccNo: {"required" :{}},
                oetBnkName: { required: {} },
                oetBbkBchName: { "required": {} },
            },
            messages: {
                oetBbkCode : {
                    "required"      : $('#oetBbkCode').attr('data-validate-required'),
                    "dublicateCode" : $('#oetBbkCode').attr('data-validate-dublicateCode')
                },
                oetBbkName : {
                    "required"      : $('#oetBbkName').attr('data-validate-required'),
                },
                oetBbkAccNo : {
                    "required"      : $('#oetBbkAccNo').attr('data-validate-required'),
                },
                oetBnkName : {
                    "required"      : 'กรุณาเลือกธนาคาร'
                },
                oetBchName: {
                    // "required"     : "กรุณากรอก 
                    "required": $('#oetBbkBchName').attr('data-validate-dublicateCode')
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
            // showErrors: function(errorMap, errorList) {
            //     JCNxCloseLoading();
            // },
            submitHandler: function(form) {
                $.ajax({
                    type: "POST",
                    url: ptRoute,
                    data: $('#ofmAddBookbank').serialize(),
                    cache: false,
                    timeout: 0,
                    success: function(tResult) {
                        if (nStaCdcBrowseType != 1) {
                            var aReturn = JSON.parse(tResult);
                            if (aReturn['nStaEvent'] == 1) {
                                if (aReturn['nStaCallBack'] == '1' || aReturn['nStaCallBack'] == null) {
                                    JSvCallPageBookBankEdit(aReturn['tCodeReturn'],aReturn['tTypeReturn'],aReturn['tStaActiveReturn'], aReturn['tBchCodeReturn']);
                                } else if (aReturn['nStaCallBack'] == '2') {
                                    JSvCallPageBookBankAdd();
                                } else if (aReturn['nStaCallBack'] == '3') {
                                    JSvCallPageBookBankList();
                                }
                            } else {
                                alert(aReturn['tStaMessg']);
                            }
                        } else {
                            JCNxBrowseData(tCallCdcBackOption);
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


//Functionality : Call Credit Page Edit  
//Parameters : from ofmAddBookbank
//Creator :  04/02/2020 Saharat(Golf)
// Last Modified : 10/04/2020 surawat
//Return : View
//Return Type : View
function JSvCallPageBookBankEdit(ptBbkCode,ptBbkType,ptBbkStaActive, ptBchCode){
    console.log(ptBbkCode);
    console.log(ptBbkType);
    console.log(ptBbkStaActive);
    console.log(ptBchCode);
    JCNxOpenLoading();
    $.ajax({
        type: "POST",
        url: "BookBankEventPageEdit",
        data: { tBbkCode: ptBbkCode ,
                tBchCode: ptBchCode},
        cache: false,
        timeout: 0,
        success: function(tResult) {
            if (tResult != '') {
                $('#oliBbkTitleEdit').show();
                $('#oliBbkTitleAdd').hide();
                $('#odvBtnBbkInfo').hide();
                $('#odvBtnBbkAddEdit').show();
                $('#odvContentPageBookBank').html(tResult);
                $('#oetBbkCode').addClass('xCNDisable');
                $('.xCNDisable').attr('readonly', true);
                //Check Select StaActive By Value
                $("#ocmBbkType option[value='" + ptBbkType + "']").attr('selected', true).trigger('change');
                //ตรวจสอบการใช้งาน 1ใช้งาน 2ไม่ใช้งาน
                if(ptBbkStaActive == 1){
                    $('#ocbStaActive').attr('checked', true).trigger('refresh');
                }else{
                    $('#ocbStaActive').attr('checked', false).trigger('refresh');
                }
            }   
            JCNxCloseLoading();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}



//Functionality : (event) Delete
//Parameters : tIDCode รหัส Creditcard
//Creator : 
// Last Modified : 10/04/2020 surawat
//Return : 
//Return Type : Status Number
function JSnBookBankDel(pnPage,ptName,tIDCode, ptBchName, ptBchCode) {
    //console.log('JSnBookBankDel');
    var aData = $('#ohdConfirmIDDelete').val();
    var aTexts = aData.substring(0, aData.length - 2);
    var aDataSplit = aTexts.split(" , ");
    var aDataSplitlength = aDataSplit.length;
    var tYesOrNot      = $('#oetTextComfirmDeleteYesOrNot').val();
    if (aDataSplitlength == '1') {
        $('#odvModalDelBookBank').modal('show');
        $('#ospConfirmDelete').html($('#oetTextComfirmDeleteSingle').val() + tIDCode + ' ( ' + ptName + ' ) ' + ptBchName + ' ' + tYesOrNot);
        // $('#osmConfirm').on('click', function(evt) {
        $('#osmConfirm').hide();
        $('#osmConfirmDelete1').show();
        $('#osmConfirmDelete1').off("click"); //ล้าง event เก่าก่อน 09/04/2020 surawat
        $('#osmConfirmDelete1').on('click', function(evt) {
            // console.log(localStorage.StaDeleteArray);
            // if (localStorage.StaDeleteArray != '1') {
                JCNxOpenLoading();
                $.ajax({
                    type: "POST",
                    url: "BookBankEventDelete",
                    data:   {   'tIDCode': tIDCode, 
                                'tBchCode': ptBchCode },
                    cache: false,
                    success: function(aReturn) {
                        //แสดงปุ่ม osmConfirm _เป็นค่าเริ่มต้น 09/04/2020 surawat
                        $('#osmConfirmDelete1').hide();
                        $('#osmConfirm').show();
                        //แสดงปุ่ม osmConfirm _เป็นค่าเริ่มต้น 09/04/2020 surawat
                        aReturn = aReturn.trim();
                        var aReturn = $.parseJSON(aReturn);
                        if (aReturn['nStaEvent'] == '1') {
                            $('#odvModalDelBookBank').modal('hide');
                            $('#ospConfirmDelete').text($('#oetTextComfirmDeleteSingle').val());
                            $('#ohdConfirmIDDelete').val('');
                            localStorage.removeItem('LocalItemData');
                            $('.modal-backdrop').remove();
                            setTimeout(function() {
                                if (aReturn["nNumRowBbk"] != 0) {
                                    if (aReturn["nNumRowBbk"] > 10) {
                                        nNumPage = Math.ceil(aReturn["nNumRowBbk"] / 10);
                                        if (pnPage <= nNumPage) {
                                            JSvCallPageBookBankDataTable(pnPage);
                                        } else {
                                            JSvCallPageBookBankDataTable(nNumPage);
                                        }
                                    } else {
                                        JSvCallPageBookBankDataTable(1);
                                    }
                                } else {
                                    JSvCallPageBookBankDataTable(1);
                                }
                            }, 500);
                        } else {
                            alert(aReturn['tStaMessg']);
                        }
                        JCNxOpenLoading();
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        //แสดงปุ่ม osmConfirm _เป็นค่าเริ่มต้น 09/04/2020 surawat
                        $('#osmConfirmDelete1').hide();
                        $('#osmConfirm').show();
                        //แสดงปุ่ม osmConfirm _เป็นค่าเริ่มต้น 09/04/2020 surawat
                        JCNxResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            // }
        });
    }

}

// //Functionality : (event) Delete All
// //Parameters :
// //Creator : 15/05/2018 wasin
// Last Modified : 10/04/2020 surawat
// //Return : 
// //Return Type :
function JSnCreditcardDelChoose(pnPage) {
    //console.log('JSnBookBankDelChoose');
    JCNxOpenLoading();
    var aData = $('#ohdConfirmIDDelete').val();
    // var aTexts = aData.substring(0, aData.length - 2);
    // var aDataSplit = aTexts.split(" , ");
    // var aDataSplitlength = aDataSplit.length;
    var aBbkChosenData = JSON.parse(aData);
    
    var aNewIdDelete = [];

    for (var i = 0; i < aBbkChosenData.length; i++) {
        aNewIdDelete.push({
            'tIDCode': aBbkChosenData[i]['nCode'],
            'tBchCode': aBbkChosenData[i]['tBchCode']
        });
    }
    //console.log(aNewIdDelete);
    if (aNewIdDelete.length > 0) {
        // localStorage.StaDeleteArray = '1';
        $.ajax({
            type: "POST",
            url: "BookBankEventDelete",
            // data: { 'tIDCode': aNewIdDelete },
            data: { 'aBbkDataToDelete': aNewIdDelete  },
            success: function(tReturn) {
                aReturn = tReturn.trim();
                var aReturn = $.parseJSON(aReturn);
                if (aReturn['nStaEvent'] == '1') {
                    $('#odvModalDelBookBank').modal('hide');
                    $('#ospConfirmDelete').text($('#oetTextComfirmDeleteSingle').val());
                    $('#ohdConfirmIDDelete').val('');
                    localStorage.removeItem('LocalItemData');
                    $('.modal-backdrop').remove();
                    setTimeout(function() {
                        if (aReturn["nNumRowBbk"] != 0) {
                            if (aReturn["nNumRowBbk"] > 10) {
                                nNumPage = Math.ceil(aReturn["nNumRowBbk"] / 10);
                                if (pnPage <= nNumPage) {
                                    JSvCallPageBookBankDataTable(pnPage);
                                } else {
                                    JSvCallPageBookBankDataTable(nNumPage);
                                }
                            } else {
                                JSvCallPageBookBankDataTable(1);
                            }
                        } else {
                            JSvCallPageBookBankDataTable(1);
                        }
                    }, 500);
                } else {
                    alert(aReturn['tStaMessg']);
                }
                JCNxOpenLoading();

            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });


    } else {
        // localStorage.StaDeleteArray = '0';

        return false;
    }

}

// //Functionality : เปลี่ยนหน้า pagenation
// //Parameters : -
// //Creator : 04/02/2020 Saharat(Golf)
// //Return : View
// //Return Type : View
function JSvBBKClickPage(ptPage) {
    var nPageCurrent = '';
    switch (ptPage) {
        case 'next': //กดปุ่ม Next
            $('.xWBtnNext').addClass('disabled');
            nPageOld = $('.xWCDCPaging .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
            nPageCurrent = nPageNew
            break;
        case 'previous': //กดปุ่ม Previous
            nPageOld = $('.xWCDCPaging .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
            nPageCurrent = nPageNew
            break;
        default:
            nPageCurrent = ptPage
    }
    JSvCallPageBookBankDataTable(nPageCurrent);
}

//Functionality : gen code Branch
//Parameters : -
//Creator : 04/04/2018 Krit(Copter)
//Return : Data
//Return Type : String
function JStGenerateCreditcardCode() {

    JCNxOpenLoading();

    var tTableName = 'TFNMCreditCard';
    $.ajax({
        type: "POST",
        url: "generateCode",
        data: { tTableName: tTableName },
        cache: false,
        success: function(tResult) {

            var tData = $.parseJSON(tResult);
            if (tData.rtCode == '1') {
                $('#oetCrdCode').val(tData.rtCrdCode);

                $('.xCNDisable').attr('readonly', true);
                $('#oetCrdCode').addClass('xCNDisable');
                $('.xCNDisable').attr('readonly', true);

                //ปุ่ม Gen
                $('.xCNiConGen').css('display', 'none');

            } else {
                $('#oetCrdCode').val(tData.rtDesc);
            }
            JCNxCloseLoading();
            $('#oetCrdName').focus();
        },
        error: function(data) {
            //console.log(data);
        }
    });
}

//Functionality: Function Chack And Show Button Delete All
//Parameters: LocalStorage Data
//Creator: 15/05/2018
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
//Creator: 15/05/2018 wasin
// Last Modified : 10/04/2020 surawat
//Return: -
//Return Type: -
function JSxPaseCodeDelInModal() {

    var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
    if (aArrayConvert[0] == null || aArrayConvert[0] == '') {} else {
        var tTextCode = '';
        for ($i = 0; $i < aArrayConvert[0].length; $i++) {
            tTextCode += aArrayConvert[0][$i].nCode;
            tTextCode += ' , ';
        }
        $('#ospConfirmDelete').text($('#oetTextComfirmDeleteMulti').val());
    }
    $('#ohdConfirmIDDelete').val(localStorage.getItem("LocalItemData"));
    //console.log($('#ohdConfirmIDDelete').val());
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
// Creator: 04/02/2020 saharat(Golf)
// Last Modified : 10/04/2020 surawat
// Return: object Status Delete
// ReturnType: boolean
function JSbBookbankIsCreatePage(){
    try{
        const tBbkCode = $('#oetBbkCode').data('is-created');  
        var bStatus = false;
        if(tBbkCode == ""){ // No have data
            bStatus = true;
        }
        return bStatus;
    }catch(err){
        //console.log('JSbBookbankIsCreatePage Error: ', err);
    }
}

// Functionality: Function Check Is Update Page
// Parameters: Event Documet Redy
// Creator: 04/02/2020 Saharat(Golf)
// Last Modified : 10/04/2020 surawat
// Return: object Status Delete
// ReturnType: boolean
function JSbBookbankIsUpdatePage(){
    try{
        const tBbkCode = $('#oetBbkCode').data('is-created');
        var bStatus = false;
        if(!tBbkCode == ""){ // Have data
            bStatus = true;
        }
        return bStatus;
    }catch(err){
        //console.log('JSbBookbankIsUpdatePage Error: ', err);
    }
}

// Functionality : Show or Hide Component
// Parameters : ptComponent is element on document(id or class or...),pbVisible is visible
// Creator : 22/03/2019 Wasin (Yoshi)
// Return : -
// Return Type : -
function JSxBookbankVisibleComponent(ptComponent, pbVisible, ptEffect){
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
        //console.log('JSxBookbankVisibleComponent Error: ', err);
    }
}