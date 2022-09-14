var nStaVstBrowseType = $('#oetVstStaBrowse').val();
var tCallVstBackOption = $('#oetVstCallBackOption').val();

$('ducument').ready(function() {
    localStorage.removeItem('LocalItemData');
    JSxCheckPinMenuClose(); 
    JSxVstNavDefult();
    if (nStaVstBrowseType != 1) {
        JSvCallPageVendingShoptypeList();
    } else {
        JSvCallPageVendingshoptypeAdd();
    }
});

///function : Function Clear Defult Button Reason
//Parameters : -
//Creator : 07/02/2018 Supwat
//Update:   07/02/2018 Supwat
//Return : -
//Return Type : -
function JSxVstNavDefult() {
    // Menu Bar เข้ามาจาก หน้า Master หรือ Browse
    if (nStaVstBrowseType != 1) { // เข้ามาจาก  Master
        $('.obtChoose').hide();
        $('#oliVstTitleAdd').hide();
        $('#oliVstTitleEdit').hide();
        $('#odvBtnVstAddEdit').hide();
        $('#odvBtnVstInfo').show();
    } else { // เข้ามาจาก Browse Modal
        $('#odvModalBody #odvVstMainMenu').removeClass('main-menu');
        $('#odvModalBody #oliVstNavBrowse').css('padding', '2px');
        $('#odvModalBody #odvVstBtnGroup').css('padding', '0');
        $('#odvModalBody .xCNVstBrowseLine').css('padding', '0px 0px');
        $('#odvModalBody .xCNVstBrowseLine').css('border-bottom', '1px solid #e3e3e3');
    }
}

///function : Call Reason Page list  
//Parameters : - 
//Creator:	07/02/2018 Supwat
//Update:   07/02/2018 Supwat
//Return : View
//Return Type : View
function JSvCallPageVendingShoptypeList(pnPage) {
    // var nStaSession = JCNxFuncChkSessionExpired();
    // if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
    //     localStorage.tStaPageNow = 'JSvCallPageVendingShoptypeList';
    //     $('#oetSearchAll').val('');
    //     $.ajax({
    //         type: "POST",
    //         url: "VendingShopTypeList",
    //         cache: false,
    //         timeout: 0,
    //         success: function(tResult) {
    //             $('#odvContentPageVendingShopType').html(tResult);
    //             JSvVendingShopTypeDataTable(pnPage);
    //         },
    //         error: function(data) {
    //             console.log(data);
    //         }
    //     });
    // }else{
    //     JCNxShowMsgSessionExpired();
    // }
}

///function : Call VendingShopType Data List
//Parameters : Ajax Success Event 
//Creator:	07/02/2018 Supwat
//Update:   
//Return : View
//Return Type : View
function JSvVendingShopTypeDataTable(pnPage) {
    // var nStaSession = JCNxFuncChkSessionExpired();
    // if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
    //     var tSearchAll = $('#oetSearchAll').val();
    //     var nPageCurrent = pnPage;
    //     if (nPageCurrent == undefined || nPageCurrent == '') {
    //         nPageCurrent = '1';
    //     }
    //     JCNxOpenLoading();
    //     $.ajax({
    //         type: "POST",
    //         url: "VendingShopTypeDataTable",
    //         data: {
    //             tSearchAll: tSearchAll,
    //             nPageCurrent: nPageCurrent,
    //         },
    //         cache: false,
    //         Timeout: 0,
    //         success: function(tResult) {
    //             if (tResult != "") {
    //                 $('#ostDataVendingShopType').html(tResult);
    //             }
    //             JSxVstNavDefult();
    //             JCNxLayoutControll();
    //             JStCMMGetPanalLangHTML('TVDMShopType_L'); //โหลดภาษาใหม่
    //             JCNxCloseLoading();
    //         },
    //         error: function(data) {
    //             console.log(data);
    //         }
    //     });
    // }else{
    //     JCNxShowMsgSessionExpired();
    // }
}

//Functionality : Call VendingShopType Page Add  
//Parameters : -
//Creator : 09/05/2018 Supwat
//Update: 07/02/2018 Supwat(yoshi)
//Return : View
//Return Type : View
function JSvCallPageVendingshoptypeAdd() {
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
        JCNxOpenLoading();
        JStCMMGetPanalLangSystemHTML('', '');
        $.ajax({
            type    : "POST",
            url     : "VendingShopTypePageAdd",
            cache   : false,
            timeout : 0,
            success : function(tResult) {
                if (nStaVstBrowseType == 1) {
                    $('#odvModalBodyBrowse').html(tResult);
                    $('#odvModalBodyBrowse .panel-body').css('padding-top','0');
                } else {
                    $('.xCNVstVBrowse').hide();
                    $('.xCNVstVMaster').show();
                    $('#oliVstTitleEdit').hide();
                    $('#oliVstTitleAdd').show();
                    $('#odvBtnVstInfo').hide();
                    $('#odvBtnVstAddEdit').show();
                }
                // $('#odvSHPContentInfoVT').html(tResult);
                JCNxLayoutControll();
                JCNxCloseLoading();
            },
            error: function(data) {
                console.log(data);
            }
        });
    }else{
        JCNxShowMsgSessionExpired();
    }
}

//Functionality : Call VendingShopType Page Edit  
//Parameters : -
//Creator: 09/05/2018 Supwat(yoshi)
//Update: 07/02/2018 Supwat(yoshi)
//Return : View
//Return Type : View
function JSvCallPageVendingShoptypeEdit(ptVstCode) {
    // var nStaSession = JCNxFuncChkSessionExpired();
    // if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
    //     JCNxOpenLoading();
    //     JStCMMGetPanalLangSystemHTML('JSvCallPageVendingShoptypeEdit', ptVstCode);
    //     $.ajax({
    //         type: "POST",
    //         url: "VendingShopTypePageEdit",
    //         data: { tVstCode: ptVstCode},
    //         cache: false,
    //         timeout: 0,
    //         success: function(tResult) {
    //             if (tResult != "") {
    //                 $('#oliVstTitleAdd').hide();
    //                 $('#oliVstTitleEdit').show();
    //                 $('#odvBtnVstInfo').hide();
    //                 $('#odvBtnVstAddEdit').show();
    //                 $('#odvContentPageVendingShopType').html(tResult);
    //                 $('#oetVstCode').addClass('xCNDisable');
    //                 $('.xCNDisable').attr('readonly', true);
    //                 $('.xCNiConGen').attr('disabled', true);
    //                 $('#oimBrowseShop').attr('disabled', true);
    //             }
    //             JCNxLayoutControll();
    //             JCNxCloseLoading();
    //         },
    //         error: function(data) {
    //             console.log(data);
    //         }
    //     });
    // }else{
    //     JCNxShowMsgSessionExpired();
    // }
}

//Functionality : (event) Add/Edit VendingShopType
//Parameters : form
//Creator : 09/05/2018 Supwat
//Return : object Status Event And Event Call Back
//Return Type : object
function JSnAddEditVendingShopType(ptRoute) {
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
        $('#ofmAddVendingShopType').validate({
            rules: {
                oetVstName      : "required"
            },
            messages: {
                oetVstName      : $('#oetVstName').data('validate')
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
                $(element).closest('.form-group').addClass( "has-success" ).removeClass( "has-error" );
            },
            submitHandler: function(form) {
                $.ajax({
                    type    : "POST",
                    url     : ptRoute,
                    data    : $('#ofmAddVendingShopType').serialize(),
                    cache   : false,
                    timeout : 0,
                    success : function(tResult) {
                        JCNxCloseLoading();
                        JCNxBrowseData(tCallVstBackOption);
                    },
                    error: function(data) {
                        console.log(data);
                    }
                });
            }
        });
    }else{
        JCNxShowMsgSessionExpired();
    }
}

//Functionality: เปลี่ยนหน้า pagenation
//Parameters: -
//Creator: 09/05/2018 Supwat
//Update: 07/02/2018 Supwat
//Return: View
//Return Type: View
function JSvClickPage(ptPage) {
    // var nPageCurrent = '';
    // var nPageNew;
    // switch (ptPage) {
    //     case 'next': //กดปุ่ม Next
    //         $('.xWBtnNext').addClass('disabled');
    //         nPageOld = $('.xWPageVendingShoptype .active').text(); // Get เลขก่อนหน้า
    //         nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
    //         nPageCurrent = nPageNew;
    //         break;
    //     case 'previous': //กดปุ่ม Previous
    //         nPageOld = $('.xWPageVendingShoptype .active').text(); // Get เลขก่อนหน้า
    //         nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
    //         nPageCurrent = nPageNew;
    //         break;
    //     default:
    //         nPageCurrent = ptPage;
    // }
    // JSvVendingShopTypeDataTable(nPageCurrent);
}

//Functionality: (event) Delete
//Parameters: Button Event [tIDCode รหัสเหตุผล]
//Creator: 10/05/2018 Supwat
//Update: 07/02/2018 Supwat
//Return: Event Delete Reason List
//Return Type: -
function JSnVendingShopTypeDel(tCurrentPage,tDelName,tIDCode) {
    // var nStaSession = JCNxFuncChkSessionExpired();
    // if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
    //     var aData = $('#ohdConfirmIDDelete').val();
    //     var aTexts = aData.substring(0, aData.length - 2);
    //     var aDataSplit = aTexts.split(" , ");
    //     var aDataSplitlength = aDataSplit.length;
    //     var aNewIdDelete = [];
    //     if (aDataSplitlength == '1') {
    //         $('#odvModalDelVendingShopType').modal('show');
    //         $('#ospConfirmDelete').html($('#oetTextComfirmDeleteSingle').val() + tIDCode + ' (' + tDelName + ')');
    //         $('#osmConfirm').on('click', function(evt) {
    //             if (localStorage.StaDeleteArray != '1') {
    //                 $.ajax({
    //                     type: "POST",
    //                     url: "VendingShopTypeEventDelete",
    //                     data: { 'tIDCode': tIDCode },
    //                     cache: false,
    //                     success: function(tResult) {
    //                         var aReturn = JSON.parse(tResult);
    //                         if (aReturn['nStaEvent'] == 1) {
    //                             $('#odvModalDelVendingShopType').modal('hide');
    //                             $('#ospConfirmDelete').text($('#oetTextComfirmDeleteSingle').val());
    //                             $('#ohdConfirmIDDelete').val('');
    //                             localStorage.removeItem('LocalItemData');
    //                             $('.modal-backdrop').remove();
    //                             setTimeout(function() {
    //                                 JSvVendingShopTypeDataTable(tCurrentPage);
    //                             }, 500);
    //                         } else {
    //                             FSvCMNSetMsgWarningDialog(aReturn['tStaMessg']);
    //                             //alert(aReturn['tStaMessg']);
    //                         }
    //                         JSxVstNavDefult();
    //                     },
    //                     error: function(data) {
    //                         console.log(data);
    //                     }
    //                 });
    //             }
    //         });
    //     }
    // }else{
    //     JCNxShowMsgSessionExpired();
    // }
}

//Functionality : (event) Delete All
//Parameters : Button Event 
//Creator : 10/05/2018 Supwat
//Update: 07/02/2018 Supwat
//Return : Event Delete All Select List
//Return Type : -
function JSnVendingShopTypeDelChoose(tCurrentPage) {
    // var nStaSession = JCNxFuncChkSessionExpired();
    // if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
    //     JCNxOpenLoading();
    //     var aData = $('#ohdConfirmIDDelete').val();
    //     var aTexts = aData.substring(0, aData.length - 2);
    //     var aDataSplit = aTexts.split(" , ");
    //     var aDataSplitlength = aDataSplit.length;
    //     var aNewIdDelete = [];

    //     for ($i = 0; $i < aDataSplitlength; $i++) {
    //         aNewIdDelete.push(aDataSplit[$i]);
    //     }

    //     if (aDataSplitlength > 1) {
    //         localStorage.StaDeleteArray = '1';
    //         $.ajax({
    //             type: "POST",
    //             url: "VendingShopTypeEventDelete",
    //             data: { 'tIDCode': aNewIdDelete },
    //             success: function(tResult) {
    //                 var aReturn = JSON.parse(tResult);
    //                 if (aReturn['nStaEvent'] == '1') {
    //                     setTimeout(function() {
    //                         $('#odvModalDelVendingShopType').modal('hide');
    //                         JSvVendingShopTypeDataTable(tCurrentPage);
    //                         $('#ospConfirmDelete').empty();
    //                         $('#ohdConfirmIDDelete').val();
    //                         localStorage.removeItem('LocalItemData');
    //                         $('.modal-backdrop').remove();
    //                     }, 1000);
    //                 } else {
    //                     alert(aReturn['tStaMessg']);
    //                 }
    //                 JSxVstNavDefult();
    //             },
    //             error: function(data) {
    //                 console.log(data);
    //             }
    //         });
    //     } else {
    //         localStorage.StaDeleteArray = '0';
    //         return false;
    //     }
    // }else{
    //     JCNxShowMsgSessionExpired();
    // }
}

//Functionality: Function Show Button Delete All
//Parameters:   Event Parameter
//Creator:  07/02/2018 Supwat
//Return: Event Button Delete All
//Return Type: -
function JSxShowButtonChoose() {
    // var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
    // if (aArrayConvert[0] == null || aArrayConvert[0] == '') {
    //     $('.obtChoose').hide();
    // } else {
    //     nNumOfArr = aArrayConvert[0].length;
    //     if (nNumOfArr > 1) {
    //         $('.obtChoose').fadeIn(300);
    //     } else {
    //         $('.obtChoose').fadeOut(300);
    //     }
    // }
}

//Functionality: Function Insert Text Delete
//Parameters: Event Parameter
//Creator: 07/02/2018 Supwat
//Return: Event Insert Text
//Return Type: -
function JSxTextinModal() {
    // var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];

    // if (aArrayConvert[0] == null || aArrayConvert[0] == '') {} else {
    //     var tText = '';
    //     var tTextCode = '';
    //     for ($i = 0; $i < aArrayConvert[0].length; $i++) {
    //         tText += aArrayConvert[0][$i].tName + '(' + aArrayConvert[0][$i].nCode + ') ';
    //         tText += ' , ';

    //         tTextCode += aArrayConvert[0][$i].nCode;
    //         tTextCode += ' , ';
    //     }
    //     var tTexts = tText.substring(0, tText.length - 2);
    //     $('#ospConfirmDelete').text($('#oetTextComfirmDeleteSingle').val() + tTexts);
    //     $('#ohdConfirmIDDelete').val(tTextCode);
    // }
}

//Functionality: Function Chack Dupilcate Data
//Parameters: Event Select List Reason
//Creator: 07/02/2018 Supwat
//Return: Duplicate/none
//Return Type: string
function findObjectByKey(array, key, value) {
    // for (var i = 0; i < array.length; i++) {
    //     if (array[i][key] === value) {
    //         return 'Dupilcate';
    //     }
    // }
    // return 'None';
}

//Choose Checkbox
function JSxVendingShoptypeVisibledDelAllBtn(poElement,poEvent){ // Action start after change check box value.
    // try{
    //     var nCheckedCount = $('#odvRGPList td input:checked').length;
    //     if(nCheckedCount > 1){
    //         $('#oliBtnDeleteAll').removeClass("disabled");
    //     }else{
    //         $('#oliBtnDeleteAll').addClass("disabled");
    //     }
    // }catch (err){
    //     //console.log('JSxDepartmentVisibledDelAllBtn Error: ', err);
    // }
}


//Functionality: Insert Text In Modal Delete
//Parameters: LocalStorage Data
//Creator: 11/10/2018 Supwat
//Return: -
//Return Type: -
function JSxPaseCodeDelInModal() {
    // var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
    // if (aArrayConvert[0] == null || aArrayConvert[0] == '') {} else {
    //     var tTextCode = '';
    //     for ($i = 0; $i < aArrayConvert[0].length; $i++) {
    //         tTextCode += aArrayConvert[0][$i].nCode;
    //         tTextCode += ' , ';
    //     }
    //     $('#ospConfirmDelete').text($('#oetTextComfirmDeleteMulti').val());
    //     $('#ohdConfirmIDDelete').val(tTextCode);
    // }
}