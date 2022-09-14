var nStaCdcBrowseType = $('#oetCdcStaBrowse').val();
var tCallCdcBackOption = $('#oetCdcCallBackOption').val();

$('document').ready(function() {
    localStorage.removeItem('LocalItemData');
    JSxCheckPinMenuClose(); /*Check เปิดปิด Menu ตาม Pin*/
    JSxCDCNavDefult();

    if (nStaCdcBrowseType != 1) {
        JSvCallPageCreditcardList();
    } else {
        JSvCallPageCreditcardAdd();
    }

});

function JSxCDCNavDefult() {
    if (nStaCdcBrowseType != 1 || nStaCdcBrowseType == undefined) {
        $('.xCNCdcVBrowse').hide();
        $('.xCNCdcVMaster').show();
        $('#oliCdcTitleAdd').hide();
        $('#oliCdcTitleEdit').hide();
        $('#odvBtnAddEdit').hide();
        $('.obtChoose').hide();
        $('#odvBtnCdcInfo').show();
    } else { 
        $('#odvModalBody .xCNCdcVMaster').hide();
        $('#odvModalBody .xCNCdcVBrowse').show();
        $('#odvModalBody #odvCdcMainMenu').removeClass('main-menu');
        $('#odvModalBody #oliCdcNavBrowse').css('padding', '2px');
        $('#odvModalBody #odvCdcBtnGroup').css('padding', '0');
        $('#odvModalBody .xCNCdcBrowseLine').css('padding', '0px 0px');
        $('#odvModalBody .xCNCdcBrowseLine').css('border-bottom', '1px solid #e3e3e3');
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

//Functionality : (event) Add/Edit Creditcard
//Parameters : form
//Creator : 02/07/2018 Krit(Copter)
//update : 28/01/2020 Saharat(GolF)
//Return : Status Add
//Return Type : n
function JSnAddEditCreditcard(ptRoute) {
  
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
        $('#ofmAddCreditcard').validate().destroy();
        $.validator.addMethod('dublicateCode', function(value, element) {
            if(ptRoute == "creditcardEventAdd"){
                if($("#ohdCheckDuplicatePdtCode").val() == 1){
                    return false;
                }else{
                    return true;
                }
            }else{
                return true;
            }
        },'');
        $('#ofmAddCreditcard').validate({
            rules: {
                oetCrdCode:     {
                    "required": {
                        depends: function(oElement) {
                            if(ptRoute == "creditcardEventAdd"){
                                if($('#ocbCreditcardAutoGenCode').is(':checked')){
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
                oetCrdName: {"required" :{}},
                oetBnkName: {"required" :{}},
            },
            messages: {
                oetCrdCode : {
                    "required"      : $('#oetCrdCode').attr('data-validate-required'),
                    "dublicateCode" : $('#oetCrdCode').attr('data-validate-dublicateCode')
                },
                oetCrdName : {
                    "required"      : $('#oetCrdName').attr('data-validate-required'),
                },
                oetBnkName : {
                    "required"      : $('#oetBnkName').attr('data-validate-required'),
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
            submitHandler: function(form) {
                // console.log( $('#ofmAddCreditcard').serializeArray() );
                $.ajax({
                    type: "POST",
                    url: ptRoute,
                    data: $('#ofmAddCreditcard').serialize(),
                    cache: false,
                    timeout: 0,
                    success: function(tResult) {
                        if (nStaCdcBrowseType != 1) {
                            var aReturn = JSON.parse(tResult);
                            if (aReturn['nStaEvent'] == 1) {
                                if (aReturn['nStaCallBack'] == '1' || aReturn['nStaCallBack'] == null) {
                                    JSvCallPageCreditcardEdit(aReturn['tCodeReturn'])
                                } else if (aReturn['nStaCallBack'] == '2') {
                                    JSvCallPageCreditcardAdd();
                                } else if (aReturn['nStaCallBack'] == '3') {
                                    JSvCallPageCreditcardList();
                                }
                                JCNxImgWarningMessage(aReturn['aImgReturn']);
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

function JSvCallPageCreditcardAdd() {

    $.ajax({
        type: "GET",
        url: "creditcardPageAdd",
        data: {},
        cache: false,
        timeout: 5000,
        success: function(tResult) {
            if (nStaCdcBrowseType == 1) {
                $('#odvModalBodyBrowse').html(tResult);
                $('#odvModalBodyBrowse .panel-body').css('padding-top', '0');
            } else {
                $('.xCNCdcVBrowse').hide(); 
                $('.xCNCdcVMaster').show();
                $('#oliCdcTitleEdit').hide();
                $('#oliCdcTitleAdd').show();
                $('#odvBtnCdcInfo').hide();
                $('#odvBtnAddEdit').show();
            }
            $('#obtBarSubmitCdc').show();

            $('#odvContentPageCreditcard').html(tResult);

        },
        error: function(data) {
            console.log(data);
        }
    });
}

// //Functionality : Call Credit Page Edit  
// //Parameters : -
// //Creator : 02/07/2018 krit
// //Return : View
// //Return Type : View
function JSvCallPageCreditcardEdit(ptCrdCode){
    
    JCNxOpenLoading();
    JStCMMGetPanalLangSystemHTML('JSvCallPageCreditcardEdit', ptCrdCode);

    $.ajax({
        type: "POST",
        url: "creditcardPageEdit",
        data: { tCrdCode: ptCrdCode },
        cache: false,
        timeout: 0,
        success: function(tResult) {
            if (tResult != '') {
                $('#oliCdcTitleAdd').hide();
                $('#oliCdcTitleEdit').show();
                $('#odvBtnCdcInfo').hide();
                $('#odvBtnAddEdit').show();
                $('#odvContentPageCreditcard').html(tResult);
                $('#oetCrdCode').addClass('xCNDisable');
                $('.xCNDisable').attr('readonly', true);
                $('#obtGenCodeCrd').attr('disabled', true);
            }

            JCNxLayoutControll();
            JCNxCloseLoading();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

function JSvCallPageCreditcardList() {

    localStorage.tStaPageNow = 'JSvCallPageCreditcardList';

    $.ajax({
        type: "GET",
        url: "creditcardFormSearchList",
        data: {},
        cache: false,
        timeout: 5000,
        success: function(tResult) {

            $('#odvContentPageCreditcard').html(tResult);

            JSxCDCNavDefult();
            JSvCallPageCreditcardDataTable(); //แสดงข้อมูลใน List
        },
        error: function(data) {
            console.log(data);
        }
    });

}

function JSvCallPageCreditcardDataTable(pnPage) {

    var tSearchAll = $('#oetSearchAll').val();
    var nPageCurrent = pnPage;
    if (nPageCurrent == undefined || nPageCurrent == '') {
        nPageCurrent = '1';
    }

    JCNxOpenLoading();
    $.ajax({
        type: "POST",
        url: "creditcardDataTable",
        data: {            
                tSearchAll: tSearchAll,
                nPageCurrent: nPageCurrent
            },
        cache: false,
        timeout: 5000,
        success: function(tResult) {
          
            $('#odvContentCreditcardData').html(tResult);
       
            JSxCDCNavDefult();
            JCNxLayoutControll();
            JStCMMGetPanalLangHTML('TFNMCreditCard_L'); //โหลดภาษาใหม่
            JCNxCloseLoading();

        },
        error: function(data) {
            console.log(data);
        }
    });

}

// //Functionality : (event) Delete
// //Parameters : tIDCode รหัส Creditcard
// //Creator : 03/07/2018 Krit(Copter)
// //Return : 
//Return Type : Status Number
function JSnCreditcardDel(pnPage,ptName,tIDCode) {
    var aData = $('#ohdConfirmIDDelete').val();
    var aTexts = aData.substring(0, aData.length - 2);
    var aDataSplit = aTexts.split(" , ");
    var aDataSplitlength = aDataSplit.length;
    var aNewIdDelete = [];
    var tDeleteYesOrNot  = $('#oetTextComfirmDeleteYesOrNot').val();
    if (aDataSplitlength == '1') {
        $('#odvModalDelCreditcard').modal('show');
        $('#ospConfirmDelete').html($('#oetTextComfirmDeleteSingle').val() + tIDCode + ' ( ' + ptName + ' ) '+tDeleteYesOrNot );
        $('#osmConfirm').on('click', function(evt) {

            if (localStorage.StaDeleteArray != '1') {
                JCNxOpenLoading();
                $.ajax({
                    type: "POST",
                    url: "creditcardEventDelete",
                    data: { 'tIDCode': tIDCode},
                    cache: false,
                    success: function(tResult) {
                        tResult = tResult.trim();
                        var tData = $.parseJSON(tResult);
                        $('#odvModalDelCreditcard').modal('hide');
                        $('#ospConfirmDelete').text($('#oetTextComfirmDeleteSingle').val());
                        $('#ohdConfirmIDDelete').val('');
                        localStorage.removeItem('LocalItemData');
                        $('.modal-backdrop').remove();
                        JSvCallPageCreditcardDataTable(pnPage);
                        JCNxCloseLoading();
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            }


        });
    }
    // var aData = $('#ospConfirmIDDelete').val();
    // var aTexts = aData.substring(0, aData.length - 2);
    // var aDataSplit = aTexts.split(" , ");
    // var aDataSplitlength = aDataSplit.length;
    // var aNewIdDelete = [];
    // if (aDataSplitlength == '1') {
    //     $('#odvModalDelCreditcard').modal('show');
    //     $('#ospConfirmDelete').html('ยืนยันการลบข้อมูล หมายเลข : ' + tIDCode);
    //     $('#osmConfirm').on('click', function(evt) {
    //         JCNxOpenLoading();
    //         $.ajax({
    //             type: "POST",
    //             url: "creditcardEventDelete",
    //             data: { 'tIDCode': tIDCode },
    //             cache: false,
    //             success: function(tResult) {
    //                 var aReturn = JSON.parse(tResult);
    //                 if (aReturn['nStaEvent'] == 1) {
    //                     $('#odvModalDelCreditcard').modal('hide');
    //                     $('#ospConfirmDelete').text('ยืนยันการลบข้อมูลของ : ');
    //                     $('#ospConfirmIDDelete').val('');
    //                     localStorage.removeItem('LocalItemData');
    //                     setTimeout(function() {
    //                         JSvCallPageCreditcardDataTable();
    //                     }, 500);
    //                 } else {
    //                     alert(aReturn['tStaMessg']);
    //                 }
    //                 JSxCDCNavDefult();
    //             },
    //             error: function(jqXHR, textStatus, errorThrown) {
    //                 JCNxResponseError(jqXHR, textStatus, errorThrown);
    //             }
    //         });
    //     });
    // }
}

// //Functionality : (event) Delete All
// //Parameters :
// //Creator : 15/05/2018 wasin
// //Return : 
// //Return Type :
function JSnCreditcardDelChoose(pnPage) {
       
    JCNxOpenLoading();

    var tNamepage = '';
    var aDataIdBranch = '';
    var nStaBrowse = '';
    var tStaInto = '';
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

        $.ajax({
            type: "POST",
            url: "creditcardEventDelete",
            data: { 'tIDCode': aNewIdDelete },
            success: function(tResult) {
                
                JSxCDCNavDefult();
                setTimeout(function() {
                    $('#odvModalDelCreditcard').modal('hide');
                    JSvCallPageCreditcardDataTable(pnPage);
                    $('#ospConfirmDelete').text($('#oetTextComfirmDeleteSingle').val());
                    $('#ohdConfirmIDDelete').val('');
                    localStorage.removeItem('LocalItemData');
                    $('.obtChoose').hide();
                    $('.modal-backdrop').remove();
                }, 1000);

            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });


    } else {
        localStorage.StaDeleteArray = '0';

        return false;
    }

    // JCNxOpenLoading();
    // var aData = $('#ospConfirmIDDelete').val();
    // var aTexts = aData.substring(0, aData.length - 2);
    // var aDataSplit = aTexts.split(" , ");
    // var aDataSplitlength = aDataSplit.length;
    // var aNewIdDelete = [];
    // for ($i = 0; $i < aDataSplitlength; $i++) {
    //     aNewIdDelete.push(aDataSplit[$i]);
    // }
    // if (aDataSplitlength > 1) {
    //     localStorage.StaDeleteArray = '1';
    //     $.ajax({
    //         type: "POST",
    //         url: "creditcardEventDelete",
    //         data: { 'tIDCode': aNewIdDelete },
    //         success: function(tResult) {
    //             var aReturn = JSON.parse(tResult);
    //             if (aReturn['nStaEvent'] == 1) {
    //                 setTimeout(function() {
    //                     $('#odvModalDelCreditcard').modal('hide');
    //                     JSvCallPageCreditcardDataTable();
    //                     $('#ospConfirmDelete').text('ยืนยันการลบข้อมูลของ : ');
    //                     $('#ospConfirmIDDelete').val('');
    //                     localStorage.removeItem('LocalItemData');
    //                     $('.modal-backdrop').remove();
    //                 }, 1000);
    //             } else {
    //                 alert(aReturn['tStaMessg']);
    //             }
    //             JSxCDCNavDefult();
    //         },
    //         error: function(jqXHR, textStatus, errorThrown) {
    //             JCNxResponseError(jqXHR, textStatus, errorThrown);
    //         }
    //     });
    // } else {
    //     localStorage.StaDeleteArray = '0';
    //     return false;
    // }
}

// //Functionality : เปลี่ยนหน้า pagenation
// //Parameters : -
// //Creator : 02/07/2018 Krit(Copter)
// //Return : View
// //Return Type : View
function JSvCDCClickPage(ptPage) {
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
    JSvCallPageCreditcardDataTable(nPageCurrent);
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
            console.log(data);
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

//Functionality: Search CreditCard List
//Parameters: tSearchAll = ข้อความที่ใช้ค้นหา , nPageCurrent = 1
//Creator: 14/01/2019 Jame
//Return: View
//Return Type: View
function JSvSearchAllCreditcard() {
    var tSearchAll = $('#oetSearchAll').val();

    JCNxOpenLoading();
    $.ajax({
        type: "POST",
        url: "creditcardDataTable",
        data: {
            tSearchAll: tSearchAll,
            nPageCurrent: 1
        },
        cache: false,
        Timeout: 0,
        success: function(tResult) {
            if (tResult != "") {
                $('#odvContentCreditcardData').html(tResult);
            }
            JSxCDCNavDefult();
            JCNxLayoutControll();
            JStCMMGetPanalLangHTML('TFNMCreditCard_L'); //โหลดภาษาใหม่
            JCNxCloseLoading();
        },
        error: function(data) {
            console.log(data);
        }
    });
}

// Functionality: Function Check Is Create Page
// Parameters: Event Documet Redy
// Creator: 22/03/2019 wasin(Yoshi)
// Return: object Status Delete
// ReturnType: boolean
function JSbCreditcardIsCreatePage(){
    try{
        const tCrdCode = $('#oetCrdCode').data('is-created');    
        var bStatus = false;
        if(tCrdCode == ""){ // No have data
            bStatus = true;
        }
        return bStatus;
    }catch(err){
        console.log('JSbCreditcardIsCreatePage Error: ', err);
    }
}

// Functionality: Function Check Is Update Page
// Parameters: Event Documet Redy
// Creator: 22/03/2019 wasin(Yoshi)
// Return: object Status Delete
// ReturnType: boolean
function JSbCreditcardIsUpdatePage(){
    try{
        const tCrdCode = $('#oetCrdCode').data('is-created');
        var bStatus = false;
        if(!tCrdCode == ""){ // Have data
            bStatus = true;
        }
        return bStatus;
    }catch(err){
        console.log('JSbCreditcardIsUpdatePage Error: ', err);
    }
}

// Functionality : Show or Hide Component
// Parameters : ptComponent is element on document(id or class or...),pbVisible is visible
// Creator : 22/03/2019 Wasin (Yoshi)
// Return : -
// Return Type : -
function JSxCredditcardVisibleComponent(ptComponent, pbVisible, ptEffect){
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
        console.log('JSxCredditcardVisibleComponent Error: ', err);
    }
}