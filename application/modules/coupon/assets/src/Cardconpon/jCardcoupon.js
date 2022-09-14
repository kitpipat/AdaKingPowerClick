var nStaVocBrowseType = $('#oetVocStaBrowse').val();
var tCallVocBackOption = $('#oetVocCallBackOption').val();
$('document').ready(function() {
    localStorage.removeItem('LocalItemData');
    JSxCheckPinMenuClose(); /*Check เปิดปิด Menu ตาม Pin*/
    JSxCPTNavDefult();

    if (nStaVocBrowseType != 1) {
        JSvCallPageCouponTypeList();
    } else {
        JSvCallPageCardCouponAdd();
    }

});

function JSxCPTNavDefult() {
    if (nStaVocBrowseType != 1 || nStaVocBrowseType == undefined) {
        $('.xCNVocVBrowse').hide();
        $('.xCNVocVMaster').show();
        $('#oliVocTitleAdd').hide();
        $('#oliVocTitleEdit').hide();
        $('#odvBtnAddEdit').hide();
        $('.obtChoose').hide();
        $('#odvBtnVocInfo').show();
    } else {
        $('#odvModalBody .xCNVocVMaster').hide();
        $('#odvModalBody .xCNVocVBrowse').show();
        $('#odvModalBody #odvVocMainMenu').removeClass('main-menu');
        $('#odvModalBody #oliVocNavBrowse').css('padding', '2px');
        $('#odvModalBody #odvVocBtnGroup').css('padding', '0');
        $('#odvModalBody .xCNVocBrowseLine').css('padding', '0px 0px');
        $('#odvModalBody .xCNVocBrowseLine').css('border-bottom', '1px solid #e3e3e3');
    }
}

//function : Function Show Event Error
//Parameters : Error Ajax Function 
//Creator : 04/07/2018 Krit
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



//Functionality : (event) Add/Edit Voucher
//Parameters : form
//Creator : 02/07/2018 Krit(Copter)
//Return : Status Add
//Return Type : n
function JSnAddEditCardCoupon(ptRoute) {
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
        $('#ofmAddCardCoupon').validate().destroy();
        $.validator.addMethod('dublicateCode', function(value, element) {
            if(ptRoute == "CardCouponEventAdd"){
                if($("#ohdCheckDuplicateCptCode").val() == 1){
                    return false;
                }else{
                    return true;
                }
            }else{
                return true;
            }
        },'');
        $('#ofmAddCardCoupon').validate({
            rules: {
                oetCclCode:     {
                    "required": {
                        depends: function(oElement) {
                            if(ptRoute == "CardCouponEventAdd"){
                                if($('#ocbCoupontypeAutoGenCode').is(':checked')){
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
                oetCclName: {"required" :{}},
            },
            messages: {
                oetCclCode : {
                    "required"      : $('#oetCclCode').attr('data-validate-required'),
                    "dublicateCode" : $('#oetCclCode').attr('data-validate-dublicateCode')
                },
                oetCclName : {
                    "required"      : $('#oetCclName').attr('data-validate-required'),
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
            $.ajax({
                type: "POST",
                url: ptRoute,
                data: $('#ofmAddCardCoupon').serialize(),
                cache: false,
                timeout: 0,
                success: function(tResult) {
                    if (nStaVocBrowseType != 1) {
                        var aReturn = JSON.parse(tResult);
                        if (aReturn['nStaEvent'] == 1) {
                            if (aReturn['nStaCallBack'] == '1' || aReturn['nStaCallBack'] == null) {
                                JSvCallPageCardCouponEdit(aReturn['tCodeReturn'])
                            } else if (aReturn['nStaCallBack'] == '2') {
                                JSvCallPageCardCouponAdd();
                            } else if (aReturn['nStaCallBack'] == '3') {
                                JSvCallPageCouponTypeList();
                            }
                        } else {
                            alert(aReturn['tStaMessg']);
                        }
                    } else {
                        JCNxBrowseData(tCallVocBackOption);
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

function JSvCallPageCouponTypeList() {
    localStorage.tStaPageNow = 'JSvCallPageCouponTypeList';

    $.ajax({
        type: "GET",
        url: "CardCouponFormSearchList",
        data: {},
        cache: false,
        timeout: 5000,
        success: function(tResult) {

            $('#odvContentPageCardCoupontype').html(tResult);
            JSxCPTNavDefult();

            JSvCallPageCardCouponDataTable(); //แสดงข้อมูลใน List
        },
        error: function(data) {
            console.log(data);
        }
    });

}

function JSvCallPageCardCouponDataTable(pnPage) {

    var tSearchAll = $('#oetSearchAll').val();
    var nPageCurrent = pnPage;
    if (nPageCurrent == undefined || nPageCurrent == '') {
        nPageCurrent = '1';
    }

    JCNxOpenLoading();
    $.ajax({
        type: "POST",
        url: "CardCouponDataTable",
        data: {            
                tSearchAll: tSearchAll,
                nPageCurrent: nPageCurrent
            },
        cache: false,
        timeout: 5000,
        success: function(tResult) {
            
            $('#odvContentPageCoupontypeData').html(tResult);

            JSxCPTNavDefult();
            JCNxLayoutControll();
            JStCMMGetPanalLangHTML('TFNMCouponType_L'); //โหลดภาษาใหม่
            JCNxCloseLoading();

        },
        error: function(data) {
            console.log(data);
        }
    });
}


//Functionality : Call Credit Page Edit  
//Parameters : -
//Creator : 02/07/2018 krit
//Return : View
//Return Type : View
function JSvCallPageCardCouponAdd() {
    $.ajax({
        type: "GET",
        url: "CardCouponPageAdd",
        data: {},
        cache: false,
        timeout: 5000,
        success: function(tResult) {
            if (nStaVocBrowseType == 1) {
                $('.xCNVocVMaster').hide();
                $('.xCNVocVBrowse').show();
            } else {
                $('.xCNVocVBrowse').hide();
                $('.xCNVocVMaster').show();
                $('#oliVocTitleEdit').hide();
                $('#oliVocTitleAdd').show();
                $('#odvBtnVocInfo').hide();
                $('#odvBtnAddEdit').show();
            }
            $('#obtBarSubmitVoc').show();

            $('#odvContentPageCardCoupontype').html(tResult);
        },
        error: function(data) {
            console.log(data);
        }
    });
}


//Functionality : Call Credit Page Edit
//Parameters : -
//Creator : 04/07/2018 Krit(Copter)
//Return : View
//Return Type : View
function JSvCallPageCardCouponEdit(ptCclCode){
 
    JCNxOpenLoading();
    JStCMMGetPanalLangSystemHTML('JSvCallPageCardCouponEdit', ptCclCode);

    $.ajax({
        type: "POST",
        url: "CardCouponPageEdit",
        data: { tCclCode : ptCclCode },
        cache: false,
        timeout: 0,
        success: function(tResult) {

            if (tResult != '') {
                $('#oliVocTitleAdd').hide();
                $('#oliVocTitleEdit').show();
                $('#odvBtnVocInfo').hide();
                $('#odvBtnAddEdit').show();
                $('#odvContentPageCardCoupontype').html(tResult);
                $('#oetCclCode').addClass('xCNDisable');
                $('.xCNDisable').attr('readonly', true);
                $('.xCNiConGen').hide();
                $('#obtGenCodeVoc').attr('disabled', true);
            }

            //Control Event Button
            if ($('#ohdCclAutStaEdit').val() == 0) {
                $('#obtBarSubmitVoc').hide();
                $('.xCNUplodeImage').hide();
                $('.xCNIconBrowse').hide();
                $("select").prop('disabled', true);
                // $('input').attr('disabled', true);
            }else{
                $('#obtBarSubmitVoc').show();
                $('.xCNUplodeImage').show();
                $('.xCNIconBrowse').show();
                $("select").prop('disabled', false);
                $('input').attr('disabled', false);
            }
            //Control Event Button

            JCNxLayoutControll();
            JCNxCloseLoading();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}



//Functionality : gen code Branch
//Parameters : -
//Creator : 04/04/2018 Krit(Copter)
//Return : Data
//Return Type : String
function JStBCHGenerateVoucherCode() {

    JCNxOpenLoading();

    var tTableName = 'TFNMVoucher';
    $.ajax({
        type: "POST",
        url: "generateCode",
        data: { tTableName: tTableName },
        cache: false,
        success: function(tResult) {

            var tData = $.parseJSON(tResult);
            if (tData.rtCode == '1') {
                $('#oetVotCode').val(tData.rtVocCode);

                $('.xCNDisable').attr('readonly', true);
                $('#oetVotCode').addClass('xCNDisable');
                $('.xCNDisable').attr('readonly', true);

                //ปุ่ม Gen
                $('.xCNiConGen').css('display', 'none');

            } else {
                $('#oetVotCode').val(tData.rtDesc);
            }
            JCNxCloseLoading();
            $('#oetVocName').focus();
        },
        error: function(data) {
            console.log(data);
        }
    });
}


// //Functionality : (event) Delete
// //Parameters : tIDCode รหัส Voucher
// //Creator : 03/07/2018 Krit(Copter)
// //Return : 
//Return Type : Status Number
function JSnCardCouponDel(pnPage,ptName,tIDCode) {
    var aData = $('#ohdConfirmIDDelete').val();
    var aTexts = aData.substring(0, aData.length - 2);
    var aDataSplit = aTexts.split(" , ");
    var aDataSplitlength = aDataSplit.length;
    var aNewIdDelete = [];

    if (aDataSplitlength == '1') {
        $('#odvModalDelVoucher').modal('show');
        $('#ospConfirmDelete').html($('#oetTextComfirmDeleteSingle').val() + tIDCode + ' ( ' + ptName + ' ) ');
        $('#osmConfirm').on('click', function(evt) {

            if (localStorage.StaDeleteArray != '1') {
                JCNxOpenLoading();
                $.ajax({
                    type: "POST",
                    url: "CardCouponEventDelete",
                    data: { 'tIDCode': tIDCode},
                    cache: false,
                    success: function(tResult) {
                        tResult = tResult.trim();
                        var tData = $.parseJSON(tResult);
                        $('#odvModalDelVoucher').modal('hide');
                        $('#ospConfirmDelete').text($('#oetTextComfirmDeleteSingle').val());
                        $('#ohdConfirmIDDelete').val('');
                        localStorage.removeItem('LocalItemData');
                        $('.modal-backdrop').remove();
                        JSvCallPageCardCouponDataTable(pnPage);
                        JCNxCloseLoading();
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            }
        });
    }

}


// //Functionality : (event) Delete All
// //Parameters :
// //Creator : 04/07/2018 Krit
// //Return : 
// //Return Type :
function JSnCardCouponDelChoose(pnPage) {
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
            url: "CardCouponEventDelete",
            data: { 'tIDCode': aNewIdDelete },
            success: function(tResult) {
                
                // JSxCPNNavDefult();
                setTimeout(function() {
                    $('#odvModalDelVoucher').modal('hide');
                    JSvCallPageCardCouponDataTable(pnPage);
                    $('#ospConfirmDelete').text($('#oetTextComfirmDeleteSingle').val());
                    $('#ohdConfirmIDDelete').val('');
                    localStorage.removeItem('LocalItemData');
                    $('.obtChoose').hide();
                    $('.modal-backdrop').remove();
                    JCNxCloseLoading();
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
}


// //Functionality : เปลี่ยนหน้า pagenation
// //Parameters : -
// //Creator : 02/07/2018 Krit(Copter)
// //Return : View
// //Return Type : View
function JSvVOCClickPage(ptPage) {
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
    JSvCallPageCardCouponDataTable(nPageCurrent);
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

//Functionality: Search Voucher List
//Parameters: tSearchAll = ข้อความที่ใช้ค้นหา , nPageCurrent = 1
//Creator: 15/01/2019 Jame
//Return: View
//Return Type: View
function JSvSearchAllCardCoupon() {
    var tSearchAll = $('#oetSearchAll').val();
    JCNxOpenLoading();
    $.ajax({
        type: "POST",
        url: "CardCouponDataTable",
        data: {
            tSearchAll: tSearchAll,
            nPageCurrent: 1
        },
        cache: false,
        Timeout: 0,
        success: function(tResult) {

            if (tResult != "") {
                $('#odvContentPageCoupontypeData').html(tResult);
            }
            
            JSxCPTNavDefult();
            JCNxLayoutControll();
            JStCMMGetPanalLangHTML('TFNMCrdCpnList_L'); //โหลดภาษาใหม่
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
function JSbCardCouponIsCreatePage(){
    try{
        const tCclCodeCode = $('#oetCclCode').data('is-created');    
        var bStatus = false;
        if(tCclCodeCode == ""){ // No have data
            bStatus = true;
        }
        return bStatus;
    }catch(err){
        console.log('JSbCardCouponIsCreatePage Error: ', err);
    }
}

// Functionality: Function Check Is Update Page
// Parameters: Event Documet Redy
// Creator: 22/03/2019 wasin(Yoshi)
// Return: object Status Delete
// ReturnType: boolean
function JSbCardCouponIsUpdatePage(){
    try{
        const tCclCode = $('#oetCclCode').data('is-created');
        var bStatus = false;
        if(!tCclCode == ""){ // Have data
            bStatus = true;
        }
        return bStatus;
    }catch(err){
        console.log('JSbCardCouponIsUpdatePage Error: ', err);
    }
}

// Functionality : Show or Hide Component
// Parameters : ptComponent is element on document(id or class or...),pbVisible is visible
// Creator : 22/03/2019 Wasin (Yoshi)
// Return : -
// Return Type : -
function JSxCardCouponVisibleComponent(ptComponent, pbVisible, ptEffect){
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
        console.log('JSxCardCouponVisibleComponent Error: ', err);
    }
}
