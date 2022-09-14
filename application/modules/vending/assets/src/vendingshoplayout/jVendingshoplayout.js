var nStaVslBrowseType = $('#oetVslStaBrowse').val();
var tCallVslBackOption = $('#oetVslCallBackOption').val();

$('ducument').ready(function() {
    localStorage.removeItem('LocalItemData');
    JSxCheckPinMenuClose(); /*Check เปิดปิด Menu ตาม Pin*/
    JSxVslNavDefult();
    if (nStaVslBrowseType != 1) {
        JSvCallPageVendingShoplayoutList();
    } else {
        JSvCallPageVendingShoplayoutAdd();
    }

});

///function : Function Clear Defult Button Vending shop layout
//Parameters : -
//Creator : 07/02/2018 Supwat
//Update:   07/02/2018 Supwat
//Return : -
//Return Type : -
function JSxVslNavDefult() {
    // Menu Bar เข้ามาจาก หน้า Master หรือ Browse
    if (nStaVslBrowseType != 1) { // เข้ามาจาก  Master
        $('.obtChoose').hide();
        $('#oliVslTitleAdd').hide();
        $('#oliVslTitleEdit').hide();
        $('#odvBtnVslAddEdit').hide();
        $('#odvBtnVslInfo').show();

        //store and manageproduct
        $('#oliVslStore').hide();
        $('#oliVslManageProduct').hide();

        //Hide ปุ่ม save ของ manage
        $('#odvBtnVslManage').hide();

    } else { // เข้ามาจาก Browse Modal
        $('#odvModalBody #odvVslMainMenu').removeClass('main-menu');
        $('#odvModalBody #oliVslNavBrowse').css('padding', '2px');
        $('#odvModalBody #odvVslBtnGroup').css('padding', '0');
        $('#odvModalBody .xCNVslBrowseLine').css('padding', '0px 0px');
        $('#odvModalBody .xCNVslBrowseLine').css('border-bottom', '1px solid #e3e3e3');
    }
}

///function : Call Vending shop layout Page list  
//Parameters : - 
//Creator:	07/02/2018 Supwat
//Update:   07/02/2018 Supwat
//Return : View
//Return Type : View
function JSvCallPageVendingShoplayoutList(pnPage) {
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
        localStorage.tStaPageNow = 'JSvCallPageVendingShoplayoutList';
        $('#oetSearchAll').val('');
        $.ajax({
            type: "POST",
            url: "VendingShopLayoutList",
            cache: false,
            timeout: 0,
            success: function(tResult) {
                $('#odvContentPageVendingShoplayout').html(tResult);
                JSvVendingShoplayoutDataTable(pnPage);
            },
            error: function(data) {
                console.log(data);
            }
        });
    }else{
        JCNxShowMsgSessionExpired();
    }
}

///function : Call VendingShoplayout Data List
//Parameters : Ajax Success Event 
//Creator:	07/02/2018 Supwat
//Update:   
//Return : View
//Return Type : View
function JSvVendingShoplayoutDataTable(pnPage) {
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
        var tSearchAll = $('#oetSearchAll').val();
        var nPageCurrent = pnPage;
        if (nPageCurrent == undefined || nPageCurrent == '') {
            nPageCurrent = '1';
        }
        JCNxOpenLoading();
        $.ajax({
            type: "POST",
            url: "VendingShopLayoutDataTable",
            data: {
                tSearchAll: tSearchAll,
                nPageCurrent: nPageCurrent,
            },
            cache: false,
            Timeout: 0,
            success: function(tResult) {
                if (tResult != "") {
                    $('#ostDataVendingShopLayout').html(tResult);
                }
                JSxVslNavDefult();
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

//Functionality : Call VendingShoplayout Page Add  
//Parameters : -
//Creator : 09/05/2018 Supwat
//Update: 07/02/2018 Supwat(yoshi)
//Return : View
//Return Type : View
function JSvCallPageVendingShoplayoutAdd() {
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
        JCNxOpenLoading();
        JStCMMGetPanalLangSystemHTML('', '');
        $.ajax({
            type: "POST",
            url: "VendingShopLayoutPageAdd",
            cache: false,
            timeout: 0,
            success: function(tResult) {
                if (nStaVslBrowseType == 1) {
                    $('#odvModalBodyBrowse').html(tResult);
                    $('#odvModalBodyBrowse .panel-body').css('padding-top','0');
                } else {
                    $('.xCNVslVBrowse').hide();
                    $('.xCNVslVMaster').show();
                    $('#oliVslTitleEdit').hide();
                    $('#oliVslTitleAdd').show();
                    $('#odvBtnVslInfo').hide();
                    $('#odvBtnVslAddEdit').show();
                }
                $('#odvContentPageVendingShoplayout').html(tResult);
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

//Functionality : Call VendingShoplayout Page Edit  
//Parameters : -
//Creator: 09/05/2018 Supwat(yoshi)
//Update: 07/02/2018 Supwat(yoshi)
//Return : View
//Return Type : View
function JSvCallPageVendingShoplayoutEdit(ptVslCode) {
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
        JCNxOpenLoading();
        JStCMMGetPanalLangSystemHTML('JSvCallPageVendingShoplayoutEdit', ptVslCode);
        $.ajax({
            type: "POST",
            url: "VendingShopLayoutPageEdit",
            data: { tVslCode: ptVslCode},
            cache: false,
            timeout: 0,
            success: function(tResult) {
                if (tResult != "") {
                    $('#oliVslTitleAdd').hide();
                    $('#oliVslTitleEdit').show();
                    $('#odvBtnVslInfo').hide();
                    $('#odvBtnVslAddEdit').show();
                    $('#odvContentPageVendingShoplayout').html(tResult);
                    $('#oetVslCode').addClass('xCNDisable');
                    $('.xCNDisable').attr('readonly', true);
                    $('.xCNiConGen').attr('disabled', true);
                    $('#oimBrowseShop').attr('disabled', true);
                }
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

//Functionality : (event) Add/Edit VendingShoplayout
//Parameters : form
//Creator : 09/05/2018 Supwat
//Return : object Status Event And Event Call Back
//Return Type : object
function JSnAddEditVendingShopLayout(ptRoute) {
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
        $('#ofmAddVendingShoplayout').validate({
            rules: {
                oetLayName     : "required"
            },
            messages: {
                oetLayName   : $('#oetLayName').data('validate')
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

                var tRow = $('#oetVstRowQty').val();
                if(tRow <= 0){ $('#oetVstRowQty').val(1); }

                var tCol = $('#oetVstColQty').val();
                if(tCol <= 0){ $('#oetVstColQty').val(1); }

                //check ประเภท
                var tTypepage   = $('#ohdTypepageVSL').val();
                //check ช่อง
                var tOldColQty  = $('#ohdOldColQty').val();
                var tNewColQty  = $('#oetVstColQty').val();
                var tNewRowQty  = $('#oetVstRowQty').val();
                if(tTypepage == 'Edit' && (tNewColQty < tOldColQty)){
                    $('#odvModalWaringColLess').modal('show');
                    var tStatusPass = false;
                }else{
                    var tStatusPass = true;
                }

                if(tStatusPass == true){
                    $.ajax({
                        type    : "POST",
                        url     : ptRoute,
                        data    : $('#ofmAddVendingShoplayout').serialize(),
                        cache   : false,
                        timeout : 0,
                        success : function(tResult) {
                            if (nStaVslBrowseType != 1) {
                                var aReturn = JSON.parse(tResult);
                                if (aReturn['nStaEvent'] == 1) {
                                    JSnVendingShoplayoutManageProduct(aReturn['tCodeReturn']);
                                    $('#ohdTypepageVSL').val('Edit');
                                    $('#obtBTNUpdateFormatvending').css('display','block');
                                    $('#obtBTNInsertFormatvending').css('display','none');

                                    $('#ohdOldColQty').val(tNewColQty);
                                    $('#ohdOldRowQty').val(tNewRowQty);
                                } else {
                                    FSvCMNSetMsgWarningDialog(aReturn['tStaMessg']);
                                }
                            } else {
                                JCNxCloseLoading();
                                JCNxBrowseData(tCallVslBackOption);
                            }
                        },
                        error: function(data) {
                            console.log(data);
                        }
                    });
                }
            }
        });
    }else{
        JCNxShowMsgSessionExpired();
    }
}

//confirm cast จำนวนช่องน้อยกว่าปัจจุบัน
function JSnVendingConfirmColLess(){
    $('#odvModalWaringColLess').modal('hide');
    var tNewColQty  = $('#oetVstColQty').val();
    var tNewRowQty  = $('#oetVstRowQty').val();
    $.ajax({
        type    : "POST",
        url     : 'VendingShopLayoutEventDeleteColandUpdate',
        data    : $('#ofmAddVendingShoplayout').serialize(),
        cache   : false,
        timeout : 0,
        success : function(tResult) {
            if (nStaVslBrowseType != 1) {
                var aReturn = JSON.parse(tResult);
                if (aReturn['nStaEvent'] == 1) {
                    JSnVendingShoplayoutManageProduct(aReturn['tCodeReturn']);
                    $('#ohdTypepageVSL').val('Edit');
                    $('#obtBTNUpdateFormatvending').css('display','block');
                    $('#obtBTNInsertFormatvending').css('display','none');

                    $('#ohdOldColQty').val(tNewColQty);
                    $('#ohdOldRowQty').val(tNewRowQty);
                } else {
                    FSvCMNSetMsgWarningDialog(aReturn['tStaMessg']);
                }
            } else {
                JCNxCloseLoading();
                JCNxBrowseData(tCallVslBackOption);
            }
        },
        error: function(data) {
            console.log(data);
        }
    });
}

//Functionality: เปลี่ยนหน้า pagenation
//Parameters: -
//Creator: 09/05/2018 Supwat
//Update: 07/02/2018 Supwat
//Return: View
//Return Type: View
function JSvClickPage(ptPage) {
    var nPageCurrent = '';
    var nPageNew;
    switch (ptPage) {
        case 'next': //กดปุ่ม Next
            $('.xWBtnNext').addClass('disabled');
            nPageOld = $('.xWPageVendingShoplayout .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
            nPageCurrent = nPageNew;
            break;
        case 'previous': //กดปุ่ม Previous
            nPageOld = $('.xWPageVendingShoplayout .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
            nPageCurrent = nPageNew;
            break;
        default:
            nPageCurrent = ptPage;
    }
    JSvVendingShoplayoutDataTable(nPageCurrent);
}

//Functionality: (event) Delete
//Parameters: Button Event [tIDCode ]
//Creator: 10/05/2018 Supwat
//Update: 07/02/2018 Supwat
//Return: Event Delete Reason List
//Return Type: -
function JSnVendingShoplayoutDel(tCurrentPage,tDelName,tIDCode,ptBch) {
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
        var aData = $('#ohdConfirmIDDelete').val();
        var aTexts = aData.substring(0, aData.length - 2);
        var aDataSplit = aTexts.split(" , ");
        var aDataSplitlength = aDataSplit.length;
        var aNewIdDelete = [];
        if (aDataSplitlength == '1') {
            $('#odvModalDelSingle').modal('show');
            $('#ospConfirmDeleteSingle').html($('#oetTextComfirmDeleteSingle').val() + tIDCode + ' (' + tDelName + ')');
            $('#osmConfirmSingle').unbind().click(function(evt){
                if (localStorage.StaDeleteArray != '1') {
                    $.ajax({
                        type: "POST",
                        url: "VendingShopLayoutEventDelete",
                        data: { 'tIDCode': tIDCode , 'ptBch' : ptBch , 'tType' : 'Singledelete'},
                        cache: false,
                        success: function(tResult) {
                            var aReturn = JSON.parse(tResult);
                            if (aReturn['nStaEvent'] == 1) {
                                $('#odvModalDelSingle').modal('hide');
                                $('#ospConfirmDeleteSingle').text($('#oetTextComfirmDeleteSingle').val());
                                $('#ohdConfirmIDDelete').val('');
                                localStorage.removeItem('LocalItemData');
                                $('.modal-backdrop').remove();
                                setTimeout(function() {
                                    JSvVendingShoplayoutDataTable(tCurrentPage);
                                }, 500);
                            } else {
                                FSvCMNSetMsgWarningDialog(aReturn['tStaMessg']);
                                //alert(aReturn['tStaMessg']);
                            }
                            JSxVslNavDefult();
                        },
                        error: function(data) {
                            console.log(data);
                        }
                    });
                }
            });
        }
    }else{
        JCNxShowMsgSessionExpired();
    }
}

//Functionality : (event) จากปุ่ม Delete All
//Parameters : Button Event 
//Creator : 10/05/2018 Supwat
//Update: 07/02/2018 Supwat
//Return : Event Delete All Select List
//Return Type : -
function JSnVendingShopLayoutDelChoose(tCurrentPage) {
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
        JCNxOpenLoading();
        $('#ospConfirmDelete').text($('#oetTextComfirmDeleteMulti').val());
        var aData               = $('#ohdConfirmIDDelete').val();
        var aTexts              = aData.substring(0, aData.length - 2);
        var aDataSplit          = aTexts.split(" , ");
        var aDataSplitlength    = aDataSplit.length;
        var aNewIdDelete        = [];

        for ($i = 0; $i < aDataSplitlength; $i++) {
            aNewIdDelete.push(aDataSplit[$i]);
        }

        if (aDataSplitlength > 1) {
            localStorage.StaDeleteArray = '1';
            $.ajax({
                type: "POST",
                url: "VendingShopLayoutEventDelete",
                data: { 'tIDCode': aNewIdDelete , 'tType' : 'Multidelete'  },
                success: function(tResult) {
                    var aReturn = JSON.parse(tResult);
                    if (aReturn['nStaEvent'] == '1') {
                        setTimeout(function() {
                            $('#odvModalDelVendingShopLayout').modal('hide');
                            JSvVendingShoplayoutDataTable(tCurrentPage);
                            $('#ospConfirmDelete').empty();
                            $('#ohdConfirmIDDelete').val();
                            localStorage.removeItem('LocalItemData');
                            $('.modal-backdrop').remove();
                        }, 1000);
                    } else {
                        alert(aReturn['tStaMessg']);
                    }
                    JSxVslNavDefult();
                },
                error: function(data) {
                    console.log(data);
                }
            });
        } else {
            localStorage.StaDeleteArray = '0';
            return false;
        }
    }else{
        JCNxShowMsgSessionExpired();
    }
}

//Functionality: Function Show Button Delete All
//Parameters:   Event Parameter
//Creator:  07/02/2018 Supwat
//Return: Event Button Delete All
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

//Functionality: Function Insert Text Delete
//Parameters: Event Parameter
//Creator: 07/02/2018 Supwat
//Return: Event Insert Text
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
        $('#ospConfirmDelete').text($('#oetTextComfirmDeleteSingle').val() + tTexts);
        $('#ohdConfirmIDDelete').val(tTextCode);
    }
}

//Functionality: Function Chack Dupilcate Data
//Parameters: Event Select List Reason
//Creator: 07/02/2018 Supwat
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

//Choose Checkbox
function JSxVendingShoplayoutVisibledDelAllBtn(poElement,poEvent){ // Action start after change check box value.
    try{
        var nCheckedCount = $('#odvRGPList td input:checked').length;
        if(nCheckedCount > 1){
            $('#oliBtnDeleteAll').removeClass("disabled");
        }else{
            $('#oliBtnDeleteAll').addClass("disabled");
        }
    }catch (err){
        //console.log('JSxDepartmentVisibledDelAllBtn Error: ', err);
    }
}


//Functionality: Insert Text In Modal Delete
//Parameters: LocalStorage Data
//Creator: 11/10/2018 Supwat
//Return: -
//Return Type: -
function JSxPaseCodeDelInModal() {
    var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
    if (aArrayConvert[0] == null || aArrayConvert[0] == '') {} else {
        var tTextCode = '';
        for ($i = 0; $i < aArrayConvert[0].length; $i++) {
            tTextCode += aArrayConvert[0][$i].nCode + '&&';
            tTextCode += aArrayConvert[0][$i].tBCHCode;
            tTextCode += ' , ';
        }
        $('#ospConfirmDelete').text($('#oetTextComfirmDeleteMulti').val());
        $('#ohdConfirmIDDelete').val(tTextCode);
    }
}