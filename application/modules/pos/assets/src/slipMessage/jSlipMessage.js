var nStaSmgBrowseType = $('#oetSmgStaBrowse').val();
var tCallSmgBackOption = $('#oetSmgCallBackOption').val();

/*============================= Begin Auto Run ===============================*/

$('document').ready(function() {
    localStorage.removeItem('LocalItemData');
    JSxCheckPinMenuClose(); /*Check เปิดปิด Menu ตาม Pin*/
    JSxSlipMessageNavDefult();
    if (nStaSmgBrowseType != 1) {
        JSvCallPageSlipMessage(1);
    } else {
        JSvCallPageSlipMessageAdd();
    }
});

/*============================= End Auto Run =================================*/

/**
 * Functionality : Function Clear Defult Button Slip Message
 * Parameters : -
 * Creator : 03/09/2018 piya
 * Last Modified : -
 * Return : -
 * Return Type : -
 */
function JSxSlipMessageNavDefult() {
    try{
        if (nStaSmgBrowseType != 1 || nStaSmgBrowseType == undefined) {
            $('.xCNSmgVBrowse').hide();
            $('.xCNSmgVMaster').show();
            $('#oliSmgTitleAdd').hide();
            $('#oliSmgTitleEdit').hide();
            $('#odvBtnAddEdit').hide();
            $('.obtChoose').hide();
            $('#odvBtnSmgInfo').show();
        } else {
            $('#odvModalBody .xCNSmgVMaster').hide();
            $('#odvModalBody .xCNSmgVBrowse').show();
            $('#odvModalBody #odvSmgMainMenu').removeClass('main-menu');
            $('#odvModalBody #oliSmgNavBrowse').css('padding', '2px');
            $('#odvModalBody #odvSmgBtnGroup').css('padding', '0');
            $('#odvModalBody .xCNSmgBrowseLine').css('padding', '0px 0px');
            $('#odvModalBody .xCNSmgBrowseLine').css('border-bottom', '1px solid #e3e3e3');
        }
    }catch(err){
        console.log('JSxSlipMessageNavDefult Error: ', err);
    }
}

/**
 * Functionality : Function Show Event Error
 * Parameters : Error Ajax Function
 * Creator : 03/09/2018 piya
 * Last Modified : -
 * Return : Modal Status Error
 * Return Type : view
 */
function JCNxSlipMessageResponseError(jqXHR, textStatus, errorThrown) {
    try{
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
    }catch(err){
        console.log('JCNxSlipMessageResponseError Error: ', err);
    }
}

/**
 * Functionality : Call Slip Message Page list
 * Parameters : {params}
 * Creator : 03/09/2018 piya
 * Last Modified : -
 * Return : view
 * Return Type : view
 */
function JSvCallPageSlipMessage(pnPage) {
    try{
        localStorage.tStaPageNow = 'JSvCallPageSlipMessageList';

        $('#oetSearchAll').val('');
        $.ajax({
            type: "POST",
            url: "slipMessageList",
            cache: false,
            timeout: 0,
            success: function(tResult) {
                $('#odvContentPageSlipMessage').html(tResult);
                JSvSlipMessageDataTable(pnPage);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }catch(err){
        console.log('JSvCallPageSlipMessage Error: ', err);
    }
}

/**
 * Functionality : Call Recive Data List
 * Parameters : Ajax Success Event
 * Creator : 28/08/2018 piya
 * Last Modified : -
 * Return : view
 * Return Type : view
 */
function JSvSlipMessageDataTable(pnPage) {
    try{
        var tSearchAll = $('#oetSearchAll').val();
        var nPageCurrent = pnPage;
        if (nPageCurrent == undefined || nPageCurrent == '') {
            nPageCurrent = '1';
        }
        JCNxOpenLoading();
        $.ajax({
            type: "POST",
            url: "slipMessageDataTable",
            data: {
                tSearchAll: tSearchAll,
                nPageCurrent: nPageCurrent
            },
            cache: false,
            Timeout: 0,
            success: function(tResult) {
                if (tResult != "") {
                    $('#ostDataSlipMessage').html(tResult);
                }
                JSxSlipMessageNavDefult();
                JCNxLayoutControll();
                // JStCMMGetPanalLangHTML('TCNMSlipMsgHD_L'); //โหลดภาษาใหม่
                JCNxCloseLoading();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }catch(err){
        console.log('JSvSlipMessageDataTable Error: ', err);
    }
}

/**
 * Functionality : Call Slip Message Page Add
 * Parameters : {params}
 * Creator : 03/09/2018 piya
 * Last Modified : -
 * Return : view
 * Return Type : view
 */
function JSvCallPageSlipMessageAdd() {
    try{
        JCNxOpenLoading();
        // JStCMMGetPanalLangSystemHTML('', '');
        $.ajax({
            type: "POST",
            url: "slipMessagePageAdd",
            cache: false,
            timeout: 0,
            success: function(tResult) {
                if (nStaSmgBrowseType == 1) {
                    $('.xCNSmgVMaster').hide();
                    $('.xCNSmgVBrowse').show();
                } else {
                    $('.xCNSmgVBrowse').hide();
                    $('.xCNSmgVMaster').show();
                    $('#oliSmgTitleEdit').hide();
                    $('#oliSmgTitleAdd').show();
                    $('#odvBtnSmgInfo').hide();
                    $('#odvBtnAddEdit').show();
                }
                $('#odvContentPageSlipMessage').html(tResult);
                JCNxLayoutControll();
                JCNxCloseLoading();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }catch(err){
        console.log('JSvCallPageSlipMessageAdd Error: ', err);
    }
}

/**
 * Functionality : Call Slip Message Page Edit
 * Parameters : {params}
 * Creator : 03/09/2018 piya
 * Last Modified : -
 * Return : view
 * Return Type : view
 */
function JSvCallPageSlipMessageEdit(ptSmgCode) {
    try{
        JCNxOpenLoading();
        // JStCMMGetPanalLangSystemHTML('JSvCallPageSlipMessageEdit', ptSmgCode);

        $.ajax({
            type: "POST",
            url: "slipMessagePageEdit",
            data: { tSmgCode: ptSmgCode },
            cache: false,
            timeout: 0,
            success: function(tResult) {
                if (tResult != '') {
                    $('#oliSmgTitleAdd').hide();
                    $('#oliSmgTitleEdit').show();
                    $('#odvBtnSmgInfo').hide();
                    $('#odvBtnAddEdit').show();
                    $('#odvContentPageSlipMessage').html(tResult);
                    $('#oetSmgCode').addClass('xCNDisable');
                    $('.xCNDisable').attr('readonly', true);
                }
                JCNxLayoutControll();
                JCNxCloseLoading();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }catch(err){
        console.log('JSvCallPageSlipMessageEdit Error: ', err);
    }
}



//Functionality : Event Add/Edit SlipMessage
//Parameters : From Submit
//Creator : 17/10/2018 witsarut
//Return : Status Event Add/Edit  SlipMessage
//Return Type : object
// function JSnAddEditSlipMessage(ptRoute){
    // $('#ofmAddSlipMessage').validate().destroy();
    // $.validate.addMethod('dublicateCode', function(value, element){
    //     if(ptRoute == 'slipMessageEventAdd'){
    //         if($('#ohdCheckDuplicateSmgCode').val()==1){
    //             return false;
    //         }else{
    //             return true;
    //         }
    //     }else{
    //         return true;
    //     }
    // }, '');

    // $('#ofmAddSlipMessage').validate({
    //     rules: {
    //         oetSmgCode: {
    //             "required" : {
    //                 depends: function(oElement){
    //                     if(ptRoute == "slipMessageEventAdd"){
    //                         if($('#ocbSlipmessageAutoGenCode').is(':checked')){
    //                             return false;
    //                         }else{
    //                             return true;
    //                         }
    //                     }else{
    //                         return true;
    //                     }
    //                 }       
    //             },
    //             "dublicateCode": {}
    //         },
    //         oetSmgTitle:  {"required" :{}},
    //     },
    //     messages: {
    //         oetSmgCode: {
    //             "required"      :  $('#oetSmgCode').attr('data-validate-required'),
    //             "dublicateCode" :  $('#oetSmgCode').attr('data-validate-dublicateCode')
    //         },

    //         oetSmgTitle: {
    //             "required"      :  $('#oetSmgTitle').attr('data-validate-required'),
    //         }
    //     },
    //     errorElement: "em",
    //     errorPlacement: function (error, element ) {
    //         error.addClass( "help-block" );
    //         if ( element.prop( "type" ) === "checkbox" ) {
    //             error.appendTo( element.parent( "label" ) );
    //         } else {
    //             var tCheck = $(element.closest('.form-group')).find('.help-block').length;
    //             if(tCheck == 0){
    //                 error.appendTo(element.closest('.form-group')).trigger('change');
    //             }
    //         }
    //     },
    //     highlight: function ( element, errorClass, validClass ) {
    //         $( element ).closest('.form-group').addClass( "has-error" ).removeClass( "has-success" );
    //     },
    //     unhighlight: function (element, errorClass, validClass) {
    //         $( element ).closest('.form-group').addClass( "has-success" ).removeClass( "has-error" );
    //     },
    //     submitHandler: function(form){
    //         $.ajax({
    //             type: "POST",
    //             url: ptRoute,
    //             data: $('#ofmAddSlipMessage').serialize(),
    //             cache: false,
    //             timeout: 0,
    //             success: function(tResult) {
    //                 var aReturn = JSON.parse(tResult);

    //                     if(aReturn['nStaEvent'] == 1) {
    //                         if(aReturn['nStaCallBack'] == '1' || aReturn['nStaCallBack'] == null) {
    //                             JSvCallPageSlipMessageEdit(aReturn['tCodeReturn']);
    //                         }else if(aReturn['nStaCallBack'] == '2') {
    //                             JSvCallPageSlipMessageAdd();
    //                         }else if (aReturn['nStaCallBack'] == '3') {
    //                             JSvCallPageSlipMessage(pnPage);
    //                         }
    //                     }else{
    //                             alert(aReturn['tStaMessg']);
    //                         }
    //             },
    //             error: function(data) {
    //                 console.log(data)
    //             }
    //         });
    //     },
    // });
// }


/**
 * Functionality : Generate Code Slip Message
 * Parameters : {params}
 * Creator : 03/09/2018 piya
 * Last Modified : -
 * Return : data
 * Return Type : string
 */
// function JStGenerateSlipMessageCode() {
//     try{
//         var tTableName = 'TCNMSlipMsgHD_L';
//         $.ajax({
//             type: "POST",
//             url: "generateCode",
//             data: { tTableName: tTableName },
//             cache: false,
//             timeout: 0,
//             success: function(tResult) {
//                 var tData = $.parseJSON(tResult);
//                 if (tData.rtCode == '1') {
//                     $('#oetSmgCode').val(tData.rtSmgCode);
//                     $('#oetSmgCode').addClass('xCNDisable');
//                     $('.xCNDisable').attr('readonly', true);
//                     //----------Hidden ปุ่ม Gen
//                     $('.xCNiConGen').attr('disabled', true);
//                 } else {
//                     $('#oetSmgCode').val(tData.rtDesc);
//                 }
//                 $('#oetSmgName').focus();
//             },
//             error: function(jqXHR, textStatus, errorThrown) {
//                 JCNxResponseError(jqXHR, textStatus, errorThrown);
//             }
//         });
//     }catch(err){
//         console.log('JStGenerateSlipMessageCode Error: ', err);
//     }
// }

/**
 * Functionality : Check Slip Message Code In DB
 * Parameters : {params}
 * Creator : 03/09/2018 piya
 * Last Modified : -
 * Return : status, message
 * Return Type : string
 */
// function JStCheckSlipMessageCode() {
//     try{
//         var tCode = $('#oetSmgCode').val();
//         var tTableName = 'TCNMSlipMsgHD_L';
//         var tFieldName = 'FTSmgCode';
//         if (tCode != '') {
//             $.ajax({
//                 type: "POST",
//                 url: "CheckInputGenCode",
//                 data: {
//                     tTableName: tTableName,
//                     tFieldName: tFieldName,
//                     tCode: tCode
//                 },
//                 cache: false,
//                 success: function(tResult) {
//                     var tData = $.parseJSON(tResult);
//                     $('.btn-default').attr('disabled', true);
//                     if (tData.rtCode == '1') { //มี Code นี้ในระบบแล้ว จะส่งไปหน้า Edit
//                         alert('มี id นี้แล้วในระบบ');
//                         JSvCallPageSlipMessageEdit(tCode);
//                     } else {
//                         alert('ไม่พบระบบจะ Gen ใหม่');
//                         JStGenerateSlipMessageCode();
//                     }
//                     $('.wrap-input100').removeClass('alert-validate');
//                     $('.btn-default').attr('disabled', false);
//                 },
//                 error: function(jqXHR, textStatus, errorThrown) {
//                     JCNxResponseError(jqXHR, textStatus, errorThrown);
//                 }
//             });
//         }
//     }catch(err){
//         console.log('JStCheckSlipMessageCode Error: ', err);
//     }
// }

/**
 * Functionality : Set data on select multiple, use in table list main page
 * Parameters : -
 * Creator : 27/08/2018 piya
 * Last Modified : -
 * Return : -
 * Return Type : -
 */
function JSxSlipMessageSetDataBeforeDelMulti(){ // Action start after delete all button click.
    try{
        var oChecked = $('#odvRGPList td input:checked');
        var tValue = '';
        $(oChecked).each( function(pnIndex){
            tValue += $(this).parents('tr.otrSlipMessage').find('td.otdSmgCode').text() + ', ';
        });
        $('#ospConfirmDelete').text(tValue.replace(/, $/,""));
    }catch(err){
        console.log('JSxSlipMessageSetDataBeforeDelMulti Error: ', err);
    }
}



function JSaSlipMessageDelete(pnPage,ptName,tIDCode) {

    var aData = $('#ohdConfirmIDDelete').val();
    var aTexts = aData.substring(0, aData.length - 2);
    var aDataSplit = aTexts.split(" , ");
    var aDataSplitlength = aDataSplit.length;
    var aNewIdDelete = [];
    if (aDataSplitlength == '1') {
        $('#odvModalDelSlipMessage').modal('show');
        $('#ospConfirmDelete').html($('#oetTextComfirmDeleteSingle').val() + ' ' + tIDCode + ' ( ' + ptName + ' ) ');
        $('#osmConfirm').on('click', function(evt) {
            $.ajax({
                type: "POST",
                url: "slipMessageDelete",
                data: { 'tIDCode': tIDCode},
                cache: false,
                timeout:0,
                success: function(tResult) {
                    // tResult = tResult.trim();
                    var aReturn = JSON.parse(tResult);
                    if(aReturn['nStaEvent'] == 1){
                        $('#odvModalDelSlipMessage').modal('hide');
                        $('#ospConfirmDelete').text($('#oetTextComfirmDeleteSingle').val());
                        $('#ohdConfirmIDDelete').val('');
                        localStorage.removeItem('LocalItemData');
                        $('.modal-backdrop').remove();
                        setTimeout(function(){
                            if(aReturn["nNumRowSmgLoc"]!= 0){
                                if(aReturn["nNumRowSmgLoc"]> 10){
                                    nNumPage = Math.ceil(aReturn["nNumRowSmgLoc"]/10);
                                    if(pnPage<=nNumPage){
                                        JSvCallPageSlipMessage(pnPage);
                                    }else{
                                        JSvCallPageSlipMessage(nNumPage);
                                    }
                                }else{
                                    JSvCallPageSlipMessage(1);
                                }
                            }else{
                                JSvCallPageSlipMessage(1);
                            }
                        }, 500);
                    }else{
                        JCNxOpenLoading();
                        alert(aReturn['tStaMessg']); 
                    }
                    JSxSlipMessageNavDefult();         
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        });
    }
}


// //Functionality : (event) Delete All
// //Parameters :
// //Creator : 17/01/2019 napat
// //Return : 
// //Return Type :
function JSnSlipMessageDelChoose(pnPage) {

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
            url: "slipMessageDelete",
            data: { 'tIDCode': aNewIdDelete },
            success: function(tResult) {
                var aReturn = JSON.parse(tResult);
                if(aReturn['nStaEvent'] == 1){
                    setTimeout(function() {
                        $('#odvModalDelSlipMessage').modal('hide');
                        JSvSlipMessageDataTable(pnPage);
                        $('#ospConfirmDelete').text($('#oetTextComfirmDeleteSingle').val());
                        $('#ohdConfirmIDDelete').val('');
                        localStorage.removeItem('LocalItemData');
                        // $('.obtChoose').hide();
                        $('.modal-backdrop').remove();

                        if(aReturn["nNumRowSmgLoc"]!= 0){
                            if(aReturn["nNumRowSmgLoc"]> 10){
                                nNumPage = Math.ceil(aReturn["nNumRowSmgLoc"]/10);
                                if(pnPage<=nNumPage){
                                    JSvCallPageSlipMessage(pnPage);
                                }else{
                                    JSvCallPageSlipMessage(nNumPage);
                                }
                            }else{
                                JSvCallPageSlipMessage(1);
                            }
                        }else{
                            JSvCallPageSlipMessage(1);
                        }    
                    }, 500);
                }else{
                    JCNxOpenLoading();
                    alert(aReturn['tStaMessg']);
                }
                JSxSlipMessageNavDefult();
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

/**
 * Functionality : Pagenation changed
 * Parameters : -
 * Creator : 03/09/2018 piya
 * Last Modified : -
 * Return : view
 * Return Type : view
 */
function JSvSlipMessageClickPage(ptPage) {
    try{
        var nPageCurrent = '';
        var nPageNew;
        switch (ptPage) {
            case 'next': //กดปุ่ม Next
                $('.xWBtnNext').addClass('disabled');
                nPageOld = $('.xWPageGrp .active').text(); // Get เลขก่อนหน้า
                nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
                nPageCurrent = nPageNew;
                break;
            case 'previous': //กดปุ่ม Previous
                nPageOld = $('.xWPageGrp .active').text(); // Get เลขก่อนหน้า
                nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
                nPageCurrent = nPageNew;
                break;
            default:
                nPageCurrent = ptPage;
        }
        JSvSlipMessageDataTable(nPageCurrent);
    }catch(err){
        console.log('JSvSlipMessageClickPage Error: ', err);
    }
}

/**
 * Functionality : Show or hide delete all button
 * Show on multiple selections, Hide on one or none selection 
 * Use in table list main page
 * Parameters : poElement is Itself element, poEvent is Itself event
 * Creator : 03/09/2018 piya
 * Last Modified : -
 * Return : -
 * Return Type : -
 */
// function JSxSlipMessageVisibledDelAllBtn(poElement = null, poEvent = null){ // Action start after change check box value.
//     try{
//         var nCheckedCount = $('#odvRGPList td input:checked').length;
//         if(nCheckedCount > 1){
//             $('#oliBtnDeleteAll').removeClass("disabled");
//         }else{
//             $('#oliBtnDeleteAll').addClass("disabled");
//         }
//     }catch (err){
//         console.log('JSxSlipMessageVisibledDelAllBtn Error: ', err);
//     }
// }
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
//Creator: 17/01/2019 napat
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

/**
 * Functionality : Delete head recive or end recive row
 * Parameters : poElement is Itself element, poEvent is Itself event
 * Creator : 06/09/2018 piya
 * Last Modified : -
 * Return : -
 * Return Type : -
 */
// function JSxSlipMessageDeleteRow(poElement = null, poEvent = null){
//     try{
//         if(confirm('Delete ?')){
//             $(poElement).parents('.xWSmgItemSelect').remove();
//         }
//     }catch(err){
//         console.log('JSxSlipMessageDeleteRow Error: ', err);
//     }
// }

/**
 * Functionality : Delete head recive or end recive row
 * Parameters : poElement is Itself element, poEvent is Itself event
 * Creator : 06/09/2018 piya
 * Last Modified : -
 * Return : -
 * Return Type : -
 */
function JSxSlipMessageDeleteRowHead(poElement = null, poEvent = null, pnRowNumber){
    try{
        if((JCNnSlipMessageCountRow('head') == 1)){return;}
        var i = $('.xSmgRowNumber').val();
        $('#odvSmgModalDelTextHead #ospRowDel').html(pnRowNumber);
        $("#odvSmgModalDelTextHead").modal("show");
        $('#odvSmgModalDelTextHead #osmConfirmDelSingleHead').unbind().click(function() {
            $(poElement).parents('.xWSmgItemSelect').remove();
            $("#odvSmgModalDelTextHead").modal("hide");
        })
    }catch(err){
        console.log('JSxSlipMessageDeleteRow Error: ', err);
    }
}

/**
 * Functionality : Delete head recive or end recive row
 * Parameters : poElement is Itself element, poEvent is Itself event
 * Creator : 06/09/2018 piya
 * Last Modified : -
 * Return : -
 * Return Type : -
 */
function JSxSlipMessageDeleteRowEnd(poElement = null, poEvent = null, pnRowNumber){
    try{
        if((JCNnSlipMessageCountRow('end') == 1)){return;}
        $('#odvSmgModalDelTextEnd #ospRowDel').html(pnRowNumber);
        $("#odvSmgModalDelTextEnd").modal("show");
        $('#odvSmgModalDelTextEnd #osmConfirmDelSingleEnd').unbind().click(function() {
            $(poElement).parents('.xWSmgItemSelect').remove();
            $("#odvSmgModalDelTextEnd").modal("hide");
        })
    }catch(err){
        console.log('JSxSlipMessageDeleteRow Error: ', err);
    }
}

/**
 * Functionality : Add head of receipt row
 * Parameters : -
 * Creator : 06/09/2018 piya
 * Last Modified : -
 * Return : -
 * Return Type : -
 */
function JSxSlipMessageAddHeadReceiptRow(){
    try{
        if(JCNnSlipMessageCountRow('head') >= 10){return;}
        
        let nIndex = JCNnSlipMessageGetMaxID('head');
        // console.log('MaxID: ', JCNnSlipMessageGetMaxID('head'));
        
        // Get template in wSlipMessageAdd.php
        var template = $.validator.format($.trim($('#oscSlipHeadRowTemplate').html()));
        // Add template
        $(template(++nIndex)).appendTo("#odvSmgSlipHeadContainer");
    }catch(err){
        console.log('JSxSlipMessageAddHeadReceiptRow Error: ', err);
    }
}

/**
 * Functionality : Add end of receipt row
 * Parameters : -
 * Creator : 06/09/2018 piya
 * Last Modified : -
 * Return : -
 * Return Type : -
 */
function JSxSlipMessageAddEndReceiptRow(){
    try{
        if(JCNnSlipMessageCountRow('end') >= 10){return;}
        
        let nIndex = JCNnSlipMessageGetMaxID('end');

        // Get template in wSlipMessageAdd.php
        var template = $.validator.format($.trim($('#oscSlipEndRowTemplate').html()));
        // Add template
        $(template(++nIndex)).appendTo("#odvSmgSlipEndContainer");
    }catch(err){
        console.log('JSxSlipMessageAddEndReceiptRow Error: ', err);
    }
}

/**
 * Functionality : {description}
 * Parameters : ptReceiptType is type for Head of receipt("head") End of receipt("end"),
 * Creator : 07/09/2018 piya
 * Last Modified : -
 * Return : Max id number
 * Return Type : number
 */
function JCNnSlipMessageGetMaxID(ptReceiptType){
    try{
        if(JCNnSlipMessageCountRow(ptReceiptType) <= 0){return 0;}

        if(ptReceiptType == 'head'){
            let nMaxID = 0;
            let oHeadItems = $('#odvSmgSlipHeadContainer .xWSmgItemSelect');
            oHeadItems.each((pnIndex, poElement) => {
                let tElementID = $(poElement).attr('id');
                if(nMaxID < tElementID){
                    nMaxID = tElementID;
                }
            });
            return nMaxID;
        }
        if(ptReceiptType == 'end'){
            let nMaxID = 0;
            let oHeadItems = $('#odvSmgSlipEndContainer .xWSmgItemSelect');
            oHeadItems.each((pnIndex, poElement) => {
                let tElementID = $(poElement).attr('id');
                if(nMaxID < tElementID){
                    nMaxID = tElementID;
                }
            });
            return nMaxID;
        }
    }catch(err){
        console.log('JCNnSlipMessageGetMaxID Error: ', err);
    }
}

/**
 * Functionality : Count row in head of receipt or end of receipt
 * Parameters : ptReceiptPosition is position for limit(head or end)
 * Creator : 06/09/2018 piya
 * Last Modified : -
 * Return : Row count
 * Return Type : number
 */
function JCNnSlipMessageCountRow(ptReceiptPosition){
    try{
        if(ptReceiptPosition == 'head'){
            let nHeadRow = $('#odvSmgSlipHeadContainer .xWSmgItemSelect').length;
            return nHeadRow;
        }
        if(ptReceiptPosition == 'end'){
            let nEndRow = $('#odvSmgSlipEndContainer .xWSmgItemSelect').length;
            return nEndRow;
        }
    }catch(err){
        console.log('JCNnSlipMessageCountRow Error: ', err);
    }
}

/**
 * Functionality : Display head of receipt and end of receipt row
 * Parameters : ptReceiptType is type for Head of receipt("head") End of receipt("end"), 
 * pnRows is number for row item
 * Creator : 07/09/2018 piya
 * Last Modified : -
 * Return : -
 * Return Type : -
 */
function JSxSlipMessageRowDefualt(ptReceiptType, pnRows){
    try{
        // Validate pnRows
        if(pnRows <= 0){return;}// Invalid exit function
        
        // Setting Type
        let tReceiptType;
        if(ptReceiptType == "end"){
            tReceiptType = "End";
        }
        if(ptReceiptType == "head"){
            tReceiptType = "Head";
        }
        
        // Get template in wSlipMessageAdd.php
        var template = $.validator.format($.trim($("#oscSlip" + tReceiptType + "RowTemplate").html()));
        
        // Add template by pnRows
        for(let loop=1; loop<=pnRows; loop++){
            $(template(loop)).appendTo("#odvSmgSlip" + tReceiptType + "Container");
        }
    }catch(err){
        console.log('JSxSlipMessageRowDefualt Error: ', err);
    }
}

/**
 * Functionality : Set data sort from sortable plugin
 * Parameters : ptReceiptType is type for sort, paSortData is row sort
 * Creator : 07/08/2018 piya
 * Last Modified : -
 * Return : -
 * Return Type : -
 */
function JSxSlipMessageSetRowSortData(ptReceiptType, paSortData){
    try{
        if(ptReceiptType == 'head'){
            localStorage.removeItem('headReceiptSort');
            localStorage.setItem('headReceiptSort', JSON.stringify(paSortData));
        }
        if(ptReceiptType == 'end'){
            localStorage.removeItem('endReceiptSort');
            localStorage.setItem('endReceiptSort', JSON.stringify(paSortData));
        }
    }catch(err){
        console.log('JSxSlipMessageSetRowSortData Error: ', err);
    }
}

/**
 * Functionality : Remove data sort from sortable plugin
 * Parameters : ptReceiptType is type for remove sort data(head, end, all)
 * Creator : 07/08/2018 piya
 * Last Modified : -
 * Return : -
 * Return Type : -
 */
function JSxSlipMessageRemoveSortData(ptReceiptType){
    try{
        if(ptReceiptType == 'head'){
            localStorage.removeItem('headReceiptSort');
        }
        if(ptReceiptType == 'end'){
            localStorage.removeItem('endReceiptSort');
        }
        if(ptReceiptType == 'all'){
            localStorage.removeItem('headReceiptSort');
            localStorage.removeItem('endReceiptSort');
        }
    }catch(err){
        console.log('JSxSlipMessageRemoveSortData Error: ', err);
    }
}

/**
 * Functionality : Get data sort from sortable plugin
 * Parameters : ptReceiptType is type for get sort data(head, end)
 * Creator : 07/08/2018 piya
 * Last Modified : -
 * Return : Sort data
 * Return Type : array
 */
function JSaSlipMessageGetSortData(ptReceiptType){
    try{
        if(ptReceiptType == 'head'){
            if(!(localStorage.getItem('headReceiptSort') == null)){
                return JSON.parse(localStorage.getItem('headReceiptSort'));
            }
        }
        if(ptReceiptType == 'end'){
            if(!(localStorage.getItem('endReceiptSort') == null)){
                return JSON.parse(localStorage.getItem('endReceiptSort'));
            }
        }
    }catch(err){
        console.log('JSaSlipMessageGetSortData Error: ', err);
    }
}

/**
 * Functionality : Prepare sort number after move row
 * Parameters : ptReceiptType is type for sorting(head, end), 
 * pbUseStringFormat is use string format? (set true return string format, set false return object format)
 * Creator : 07/09/2018 piya
 * Last Modified : -
 * Return : Head of receipt or End of receipt value
 * Return Type : object
 */
function JSoSlipMessageSortabled(ptReceiptType, pbUseStringFormat){
    try{
        if(ptReceiptType == 'head'){
            let aSortData = JSaSlipMessageGetSortData('head');
            let aSortabled = {};
            $.each(aSortData, (pnIndex, pnValue) => {
                let tValue = $('#odvSmgSlipHeadContainer .xWSmgItemSelect[id=' + pnValue + ']').find('.xWSmgDyForm').val();
                aSortabled[pnIndex] = tValue;
            });
            // console.log('Sortabled: ', aSortabled);
            if(pbUseStringFormat){
                return JSON.stringify(aSortabled);
            }else{
                return aSortabled;
            }
        }
        if(ptReceiptType == 'end'){
            let aSortData = JSaSlipMessageGetSortData('end');
            let aSortabled = {};
            $.each(aSortData, (pnIndex, pnValue) => {
                let tValue = $('#odvSmgSlipEndContainer .xWSmgItemSelect[id=' + pnValue + ']').find('.xWSmgDyForm').val();
                aSortabled[pnIndex] = tValue;
            });
            // console.log('Sortabled: ', aSortabled);
            if(pbUseStringFormat){
                return JSON.stringify(aSortabled);
            }else{
                return aSortabled;
            }
        }
    }catch(err){
        console.log('JSoSlipMessageSortabled Error: ', err);
    }
}

/**
 * Functionality : Is create page.
 * Parameters : -
 * Creator : 31/08/2018 piya
 * Last Modified : -
 * Return : Status true is create page
 * Return Type : Boolean
 */
function JCNbSlipMessageIsCreatePage(){
    try{
        const tSmgCode = $('#oetSmgCode').data('is-created');
        var bStatus = false;
        if(tSmgCode == ""){ // No have data
            bStatus = true;
        }
        return bStatus;
    }catch(err){
        console.log('JCNbSlipMessageIsCreatePage Error: ', err);
    }
}

/**
 * Functionality : Is update page.
 * Parameters : -
 * Creator : 24/08/2018 piya
 * Last Modified : 27/08/2018 piya
 * Return : Status true is update page
 * Return Type : Boolean
 */
function JCNbSlipMessageIsUpdatePage(){
    try{
        const tVCode = $('#oetSmgCode').data('is-created');
        let bStatus = false;
        if(tVCode != ""){ // Have data
            bStatus = true;
        }
        return bStatus;
    }catch(err){
        console.log('JCNbSlipMessageIsUpdatePage Error: ', err);
    }
}

//Functionality: Function Chack Value LocalStorage
//Parameters: Event Select List Branch
//Creator: 17/01/2019 Napat
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
function JSbSmgIsCreatePage(){
    try{
        const tSmgCode = $('#oetSmgCode').data('is-created');    
        var bStatus = false;
        if(tSmgCode == ""){ // No have data
            bStatus = true;
        }
        return bStatus;
    }catch(err){
        console.log('JSbSmgIsCreatePage Error: ', err);
    }
}

// Functionality: Function Check Is Update Page
// Parameters: Event Documet Redy
// Creator: 22/03/2019 wasin(Yoshi)
// Return: object Status Delete
// ReturnType: boolean
function JSbSmgIsUpdatePage(){
    try{
        const tSmgCode = $('#oetSmgCode').data('is-created');
        var bStatus = false;
        if(!tSmgCode == ""){ // Have data
            bStatus = true;
        }
        return bStatus;
    }catch(err){
        console.log('JSbSmgIsUpdatePage Error: ', err);
    }
}

// Functionality : Show or Hide Component
// Parameters : ptComponent is element on document(id or class or...),pbVisible is visible
// Creator : 22/03/2019 Wasin (Yoshi)
// Return : -
// Return Type : -
function JSxSmgVisibleComponent(ptComponent, pbVisible, ptEffect){
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
        console.log('JSxSmgVisibleComponent Error: ', err);
    }
}

// Functionality: Function Check Is Create Page
// Parameters: Event Documet Redy
// Creator: 22/03/2019 wasin(Yoshi)
// Return: object Status Delete
// ReturnType: boolean
function JSbSmgIsCreatePage(){
    try{
        const tSmgCode = $('#oetSmgCode').data('is-created');    
        var bStatus = false;
        if(tSmgCode == ""){ // No have data
            bStatus = true;
        }
        return bStatus;
    }catch(err){
        console.log('JSbSmgIsCreatePage Error: ', err);
    }
}

// Functionality: Function Check Is Update Page
// Parameters: Event Documet Redy
// Creator: 22/03/2019 wasin(Yoshi)
// Return: object Status Delete
// ReturnType: boolean
function JSbSmgIsUpdatePage(){
    try{
        const tSmgCode = $('#oetSmgCode').data('is-created');
        var bStatus = false;
        if(!tSmgCode == ""){ // Have data
            bStatus = true;
        }
        return bStatus;
    }catch(err){
        console.log('JSbSmgIsUpdatePage Error: ', err);
    }
}

// Functionality : Show or Hide Component
// Parameters : ptComponent is element on document(id or class or...),pbVisible is visible
// Creator : 22/03/2019 Wasin (Yoshi)
// Return : -
// Return Type : -
function JSxSmgVisibleComponent(ptComponent, pbVisible, ptEffect){
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
        console.log('JSxSmgVisibleComponent Error: ', err);
    }
}





