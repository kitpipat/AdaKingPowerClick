var nStaPplBrowseType   = $('#oetPplStaBrowse').val();
var tCallPplBackOption  = $('#oetPplCallBackOption').val();
// alert(nStaPplBrowseType+'//'+tCallPplBackOption);
$('document').ready(function(){
    localStorage.removeItem('LocalItemData');
    JSxCheckPinMenuClose(); /*Check เปิดปิด Menu ตาม Pin*/
    JSxPplNavDefult();
    if(nStaPplBrowseType != 1){
        JSvCallPagePdtPriceList(1);
    }else{
        JSvCallPagePdtPriceAdd();
    }
});

//function : Function Clear Defult Button Product Pricelist
//Parameters : Document Ready
//Creator : 10/10/2018 witsarut
//Return : Show Tab Menu
//Return Type : -
function JSxPplNavDefult(){
    if(nStaPplBrowseType != 1 || nStaPplBrowseType == undefined){
        $('.xCNPplVBrowse').hide();
        $('.xCNPplVMaster').show();
        $('.xCNChoose').hide();
        $('#oliPplTitleAdd').hide();
        $('#oliPplTitleEdit').hide();
        $('#odvBtnAddEdit').hide();
        $('#odvBtnPplInfo').show();
    }else{
        $('#odvModalBody .xCNPplVMaster').hide();
        $('#odvModalBody .xCNPplVBrowse').show();
        $('#odvModalBody #odvPplMainMenu').removeClass('main-menu');
        $('#odvModalBody #oliPplNavBrowse').css('padding', '2px');
        $('#odvModalBody #odvPplBtnGroup').css('padding', '0');
        $('#odvModalBody .xCNPplBrowseLine').css('padding', '0px 0px');
        $('#odvModalBody .xCNPplBrowseLine').css('border-bottom', '1px solid #e3e3e3');
    }
}

//function : Function Show Event Error
//Parameters : Error Ajax Function 
//Creator : 10/10/2018 witsarut
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

//function : Call Product Pricelist Page list  
//Parameters : Document Redy And Event Button
//Creator :	10/10/2018 witsarut
//Return : View
//Return Type : View
function JSvCallPagePdtPriceList(pnPage){
    localStorage.tStaPageNow = 'JSvCallPagePdtPriceList';
    $('#oetSearchPdtPrice').val('');
    JCNxOpenLoading();    
    $.ajax({
        type: "POST",
        url: "pdtpricegroupList",
        cache: false,
        timeout: 0,
        success: function(tResult){
            $('#odvContentPagePdtPrice').html(tResult);
            JSvPdtPriceDataTable(pnPage);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

//function: Call Product Pricelist Data List
//Parameters: Ajax Success Event 
//Creator:	10/10/2018 witsarut
//Return: View
//Return Type: View
function JSvPdtPriceDataTable(pnPage){
    var tSearchAll      = $('#oetSearchPdtPrice').val();
    var nPageCurrent    = (pnPage === undefined || pnPage == '')? '1' : pnPage;
    $.ajax({
        type: "POST",
        url: "pdtpricegroupDataTable",
        data: {
            tSearchAll: tSearchAll,
            nPageCurrent: nPageCurrent,
        },
        cache: false,
        Timeout: 0,
        success: function(tResult){
            if (tResult != "") {
                $('#ostDataPdtPrice').html(tResult);
            }
            JSxPplNavDefult();
            JCNxLayoutControll();
            JStCMMGetPanalLangHTML('TCNMPdtPriList_L'); //โหลดภาษาใหม่
            JCNxCloseLoading();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

//Functionality : Call Product Pricelist Page Add  
//Parameters : Event Button Click
//Creator : 10/10/2018 witsarut
//Updatae : 29/03/2019 pap
//Return : View
//Return Type : View
function JSvCallPagePdtPriceAdd(){
    JCNxOpenLoading();
    JStCMMGetPanalLangSystemHTML('', '');
    $.ajax({
        type: "POST",
        url: "pdtpricegroupPageAdd",
        cache: false,
        timeout: 0,
        success: function(tResult){
            if (nStaPplBrowseType == 1) {
                $('#odvModalBodyBrowse').html(tResult);
                $('#odvModalBodyBrowse .panel-body').css('padding-top', '0');
            }else{
                $('.xCNPplVBrowse').hide();
                $('.xCNPplVMaster').show();
                $('#oliPplTitleEdit').hide();
                $('#oliPplTitleAdd').show();
                $('#odvBtnPplInfo').hide();
                $('#odvBtnAddEdit').show();
            }
            $('#odvContentPagePdtPrice').html(tResult);
            $('#ocbPplAutoGenCode').change(function(){
                $("#oetPplCode").val("");
                $("#ohdCheckDuplicatePplCode").val("1");
                if($('#ocbPplAutoGenCode').is(':checked')) {
                    $("#oetPplCode").attr("readonly", true);
                    $("#oetPplCode").attr("onfocus", "this.blur()");
                    $('#ofmAddPdtPrice').removeClass('has-error');
                    $('#ofmAddPdtPrice em').remove();
                }else{
                    $("#oetPplCode").attr("readonly", false);
                    $("#oetPplCode").removeAttr("onfocus");
                }
            });
            $("#oetPplCode").blur(function(){
                if(!$('#ocbPplAutoGenCode').is(':checked')) {
                    if($("#ohdCheckPdtPriceGroupClearValidate").val()==1){
                        $('#ofmAddPdtPrice').validate().destroy();
                        $("#ohdCheckPdtPriceGroupClearValidate").val("0");
                    }
                    if($("#ohdCheckPdtPriceGroupClearValidate").val()==0){
                        $.ajax({
                            type: "POST",
                            url: "CheckInputGenCode",
                            data: { 
                                tTableName : "TCNMPdtPriList",
                                tFieldName : "FTPplCode",
                                tCode : $("#oetPplCode").val()
                            },
                            cache: false,
                            timeout: 0,
                            success: function(tResult){
                                var aResult = JSON.parse(tResult);
                                $("#ohdCheckDuplicatePplCode").val(aResult["rtCode"]);
                                JSxValidationFormPdtPriceGroup("",$("#ohdPdtPriceGroupRoute").val());
                                $('#ofmAddPdtPrice').submit();
                                
                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                                JCNxResponseError(jqXHR, textStatus, errorThrown);
                            }
                        });
                    }
                }
            });







            JCNxLayoutControll();
            JCNxCloseLoading();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

//Functionality : center validate form
//Parameters : function submit name, route
//Creator : 29/03/2019 pap
//Update : -
//Return : -
//Return Type : -
function JSxValidationFormPdtPriceGroup(pFnSubmitName,ptRoute){
    $.validator.addMethod('dublicateCode', function(value, element) {
        if(ptRoute=="pdtpricegroupEventAdd"){
            if($('#ocbPplAutoGenCode').is(':checked')){
                return true;
            }else{
                if($("#ohdCheckDuplicatePplCode").val()==1){
                    return false;
                }else{
                    return true;
                }
            }
        }else{
            return true;
        }
    }, '');
    $('#ofmAddPdtPrice').validate({
        rules: {
            oetPplCode : {
                "required" :{
                // ตรวจสอบเงื่อนไข validate
                depends: function(oElement) {
                    if(ptRoute=="pdtpricegroupEventAdd"){
                        if($('#ocbPplAutoGenCode').is(':checked')){
                            return false;
                        }else{
                            return true;
                        }
                    }else{
                        return false;
                    }
                }
                },
                "dublicateCode" :{}
            },
            oetPplName: {
                "required" :{}
            }
        },
        messages: {
            oetPplCode : {
                "required" :$('#oetPplCode').attr('data-validate-required'),
                "dublicateCode" : $('#oetPplCode').attr('data-validate-dublicateCode')
            },
            oetPplName : {
                "required" :$('#oetPplName').attr('data-validate-required')
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
        highlight: function ( element, errorClass, validClass ) {
            $( element ).closest('.form-group').addClass( "has-error" );
        },
        unhighlight: function (element, errorClass, validClass) {
            $( element ).closest('.form-group').removeClass( "has-error" );
        },
        submitHandler: function(form){
            if(pFnSubmitName!=""){
                window[pFnSubmitName](ptRoute);
            }
        }
    });
}

//Functionality : function submit by submit button only
//Parameters : route
//Creator : 29/03/2019 pap
//Update : -
//Return : -
//Return Type : -
function JSxSubmitEventByButton(ptRoute){
    if($("#ohdCheckPdtPriceGroupClearValidate").val()==1){
        JCNxOpenLoading();
        $.ajax({
            type: "POST",
            url: ptRoute,
            data: $('#ofmAddPdtPrice').serialize(),
            success: function(oResult){
                if(nStaPplBrowseType != 1) {
                    var aReturn = JSON.parse(oResult);
                    if(aReturn['nStaEvent'] == 1){
                        switch(aReturn['nStaCallBack']) {
                            case '1':
                                JSvCallPagePdtPriceEdit(aReturn['tCodeReturn']);
                                break;
                            case '2':
                                JSvCallPagePdtPriceAdd();
                                break;
                            case '3':
                                JSvCallPagePdtPriceList(1);
                                break;
                            default:
                                JSvCallPagePdtPriceEdit(aReturn['tCodeReturn']);
                        }
                    }else{
                        JCNxCloseLoading();
                        FSvCMNSetMsgWarningDialog(aReturn['tStaMessg']);
                    }
                }else{
                    JCNxCloseLoading(); 
                    JCNxBrowseData(tCallPplBackOption);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }
}

//Functionality : Call Product Pricelist Page Edit  
//Parameters : Event Button Click 
//Creator : 10/10/2018 witsarut
//Return : View
//Return Type : View
function JSvCallPagePdtPriceEdit(ptPplCode){
    JCNxOpenLoading();
    JStCMMGetPanalLangSystemHTML('JSvCallPagePdtPriceEdit',ptPplCode);
    $.ajax({
        type: "POST",
        url: "pdtpricegroupPageEdit",
        data: { tPplCode: ptPplCode },
        cache: false,
        timeout: 0,
        success: function(tResult){
            if(tResult != ''){
                $('#oliPplTitleAdd').hide();
                $('#oliPplTitleEdit').show();
                $('#odvBtnPplInfo').hide();
                $('#odvBtnAddEdit').show();
                $('#odvContentPagePdtPrice').html(tResult);
                $('#oetPplCode').addClass('xCNDisable');
                $('#oetPplCode').attr('readonly', true);
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

//Functionality : set click status submit form from save button
//Parameters : -
//Creator : 26/03/2019 pap
//Return : -
//Return Type : -
function JSxSetStatusClickPdtPriceGroupSubmit(){
    $("#ohdCheckPdtPriceGroupClearValidate").val("1");
}

//Functionality : Event Add/Edit Product Pricelist
//Parameters : From Submit
//Creator : 10/10/2018 witsarut
//Updatae : 29/03/2019 pap
//Return : Status Event Add/Edit Product Pricelist
//Return Type : object
function JSoAddEditPdtPrice(ptRoute){
    if($("#ohdCheckPdtPriceGroupClearValidate").val()==1){
        $('#ofmAddPdtPrice').validate().destroy();
        if(!$('#ocbPplAutoGenCode').is(':checked')) {
            $.ajax({
                type: "POST",
                url: "CheckInputGenCode",
                data: { 
                    tTableName : "TCNMPdtPriList",
                    tFieldName : "FTPplCode",
                    tCode : $("#oetPplCode").val()
                },
                cache: false,
                timeout: 0,
                success: function(tResult){
                    var aResult = JSON.parse(tResult);
                    $("#ohdCheckDuplicatePplCode").val(aResult["rtCode"]);
                    JSxValidationFormPdtPriceGroup("JSxSubmitEventByButton",ptRoute);
                    $('#ofmAddPdtPrice').submit();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }else{
            JSxValidationFormPdtPriceGroup("JSxSubmitEventByButton",ptRoute);
        }
        
    }
}

//Functionality : Generate Code Product Pricelist
//Parameters : Event Button Click
//Creator : 10/10/2018 witsarut
//Return : Event Push Value In Input
//Return Type : -
function JStGeneratePdtPriceCode(){
    $('#oetPplCode').parent().removeClass('alert-validate');
    var tTableName = 'TCNMPdtPriList';
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
                $('#oetPplCode').val(tData.rtPplCode);
                $('#oetPplCode').addClass('xCNDisable');
                $('#oetPplCode').attr('readonly', true);
                $('.xCNBtnGenCode').attr('disabled', true); //เปลี่ยน Class ใหม่
                $('#oetPplName').focus();
            } else {
                $('#oetPplCode').val(tData.rtDesc);
            }
            JCNxCloseLoading();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

//Functionality : Event Single Delete
//Parameters : Event Icon Delete
//Creator : 10/10/2018 witsarut
//Update : 1/04/2019 pap
//Return : object Status Delete
//Return Type : object
function JSoPdtPriceDel(pnPage,ptName,tIDCode,tYesOnNo){
    var aData = $('#ohdConfirmIDDelete').val();
    var aTexts = aData.substring(0, aData.length - 2);
    var aDataSplit = aTexts.split(" , ");
    var aDataSplitlength = aDataSplit.length;
    var aNewIdDelete = [];

    if (aDataSplitlength == '1') {

        $('#odvModalDelPdtPrice').modal('show');
        $('#ospConfirmDelete').html($('#oetTextComfirmDeleteSingle').val() + tIDCode + ' ( ' + ptName + ' ) '+ tYesOnNo );
        $('#osmConfirm').on('click', function(evt) {

            if (localStorage.StaDeleteArray != '1') {

                $.ajax({
                    type: "POST",
                    url: "pdtpricegroupEventDelete",
                    data: { 'tIDCode': tIDCode},
                    cache: false,
                    success: function(tResult) {
                        tResult = tResult.trim();
                        var tData = $.parseJSON(tResult);

                        // $('#odvModalDelPdtPrice').modal('hide');
                        // $('#ospConfirmDelete').text($('#oetTextComfirmDeleteSingle').val());
                        // $('#ohdConfirmIDDelete').val('');
                        // localStorage.removeItem('LocalItemData');
                        // $('.modal-backdrop').remove();
                        // JSvPdtPriceDataTable(pnPage);

                        if (tData['nStaEvent'] == '1'){
                            $('#odvModalDelPdtPrice').modal('hide');
                            $('#ospConfirmDelete').empty();
                            localStorage.removeItem('LocalItemData');
                            $('#ohdConfirmIDDelete').val('');
                            setTimeout(function() {
                                if(tData["nNumRowPdtGrp"]!=0){
                                    if(tData["nNumRowPdtGrp"]>10){
                                        nNumPage = Math.ceil(tData["nNumRowPdtGrp"]/10);
                                        if(pnPage<=nNumPage){
                                            JSvCallPagePdtPriceList(pnPage);
                                        }else{
                                            JSvCallPagePdtPriceList(nNumPage);
                                        }
                                    }else{
                                        JSvCallPagePdtPriceList(1);
                                    }
                                }else{
                                    JSvCallPagePdtPriceList(1);
                                }
                            }, 500);
                        }else{
                            JCNxOpenLoading();
                            alert(tData['tStaMessg']);                        
                        }
                        JSxPplNavDefult();

                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            }


        });
    }
    // var aData               = $('#ospConfirmIDDelete').val();
    // var aTexts              = aData.substring(0, aData.length - 2);
    // var aDataSplit          = aTexts.split(" , ");
    // var aDataSplitlength    = aDataSplit.length;
    // var aNewIdDelete        = [];
    // if (aDataSplitlength == '1'){
       
    //     $('#odvModalDelPdtPrice').modal('show');
    //     $('#ospConfirmDelete').html('ยืนยันการลบข้อมูล หมายเลข : ' + tIDCode);
    //     $('#osmConfirm').on('click', function(evt){
    //         JCNxOpenLoading();
    //         $.ajax({
    //             type: "POST",
    //             url: "pdtpricelistEventDelete",
    //             data: { 'tIDCode': tIDCode },
    //             cache: false,
    //             timeout: 0,
    //             success: function(oResult){
    //                 var aReturn = JSON.parse(oResult);
    //                 if (aReturn['nStaEvent'] == 1){
    //                     $('#odvModalDelPdtPrice').modal('hide');
    //                     $('#ospConfirmDelete').text('ยืนยันการลบข้อมูลของ : ');
    //                     $('#ospConfirmIDDelete').val('');
    //                     localStorage.removeItem('LocalItemData');
    //                     setTimeout(function() {
    //                         JSvPdtPriceDataTable();
    //                     }, 500);
    //                 }else{
    //                     alert(aReturn['tStaMessg']);                        
    //                 }
    //                 JSxPplNavDefult();
    //             },
    //             error: function(jqXHR, textStatus, errorThrown) {
    //                 JCNxResponseError(jqXHR, textStatus, errorThrown);
    //             }
    //         });
    //     });
    // }
}

//Functionality: Event Multi Delete
//Parameters: Event Button Delete All
//Creator: 10/10/2018 witsarut
//Update: 1/4/2019 pap
//Return:  object Status Delete
//Return Type: object
function JSoPdtPriceDelChoose(pnPage){
    JCNxOpenLoading();
    var tCurrentPage = $("#nCurrentPageTB").val();
	var aData 				= $('#ohdConfirmIDDelete').val();
	var aTexts				= aData.substring(0, aData.length-2);
	var aDataSplit			= aTexts.split(" , ");
	var aDataSplitlength	= aDataSplit.length;
	var aNewIdDelete		= [];
	
	for($i=0; $i<aDataSplitlength; $i++){
		aNewIdDelete.push(aDataSplit[$i]);
	}

	if(aDataSplitlength > 1){
		
		localStorage.StaDeleteArray = '1';
		
 		$.ajax({
		type: "POST",
		url: "pdtpricegroupEventDelete",
		data: { 'tIDCode' : aNewIdDelete },
		success: function (tResult) {
			
				// setTimeout(function(){
				// 		$('#odvModalDelPdtPrice').modal('hide');
				// 		$('#ospConfirmDelete').text($('#oetTextComfirmDeleteSingle').val());
				// 		$('#ohdConfirmIDDelete').val('');
				// 		localStorage.removeItem('LocalItemData');
				// 		JSvPdtPriceDataTable(pnPage);
				// 		$('.modal-backdrop').remove();
                // },500);
                

                var aReturn = JSON.parse(tResult);
                if (aReturn['nStaEvent'] == '1'){
                    $('#odvModalDelPdtPrice').modal('hide');
                    $('#ospConfirmDelete').empty();
                    localStorage.removeItem('LocalItemData');
                    $('#ohdConfirmIDDelete').val('');
                    $('#ospConfirmIDDelete').val('');
                    setTimeout(function() {
                        if(aReturn["nNumRowPdtGrp"]!=0){
                            if(aReturn["nNumRowPdtGrp"]>10){
                                nNumPage = Math.ceil(aReturn["nNumRowPdtGrp"]/10);
                                if(tCurrentPage<=nNumPage){
                                    JSvCallPagePdtPriceList(tCurrentPage);
                                }else{
                                    JSvCallPagePdtPriceList(nNumPage);
                                }
                            }else{
                                JSvCallPagePdtPriceList(1);
                            }
                        }else{
                            JSvCallPagePdtPriceList(1);
                        }
                    }, 500);
                }else{
                    JCNxOpenLoading();
                    alert(tData['tStaMessg']);                        
                }
                JSxPplNavDefult();
				
			},
			error: function (data) {
				console.log(data);
			}
		});

		
	}else{
		localStorage.StaDeleteArray = '0';
		
		return false;
	}
    // JCNxOpenLoading();
    // var aData       = $('#ospConfirmIDDelete').val();
    // var aTexts      = aData.substring(0, aData.length - 2);
    // var aDataSplit  = aTexts.split(" , ");
    // var aDataSplitlength = aDataSplit.length;
    // var aNewIdDelete = [];
    // for ($i = 0; $i < aDataSplitlength; $i++) {
    //     aNewIdDelete.push(aDataSplit[$i]);
    // }
    // if (aDataSplitlength > 1){
    //     localStorage.StaDeleteArray = '1';
    //     $.ajax({
    //         type: "POST",
    //         url: "pdtpricelistEventDelete",
    //         data: { 'tIDCode': aNewIdDelete },
    //         cache: false,
    //         timeout: 0,
    //         success: function(oResult) {
    //             var aReturn = JSON.parse(oResult);
    //             if (aReturn['nStaEvent'] == 1) {
    //                 setTimeout(function() {
    //                     $('#odvModalDelPdtPrice').modal('hide');
    //                     JSvCallPagePdtPriceList();
    //                     $('#ospConfirmDelete').text('ยืนยันการลบข้อมูลของ : ');
    //                     $('#ospConfirmIDDelete').val('');
    //                     localStorage.removeItem('LocalItemData');
    //                     $('.modal-backdrop').remove();
    //                 },1000);
    //             }else{
    //                 alert(aReturn['tStaMessg']);
    //             }
    //             JSxPplNavDefult();
    //         },
    //         error: function(jqXHR, textStatus, errorThrown) {
    //             JCNxResponseError(jqXHR, textStatus, errorThrown);
    //         }
    //     });
    // }else{
    //     localStorage.StaDeleteArray = '0';
    //     return false;
    // }
}

//Functionality : เปลี่ยนหน้า pagenation
//Parameters : Event Click Pagenation
//Creator : 10/10/2018 witsarut
//Return : View
//Return Type : View
function JSvPdtPriceClickPage(ptPage) {
    var nPageCurrent = '';
    switch (ptPage) {
        case 'next': //กดปุ่ม Next
            $('.xWBtnNext').addClass('disabled');
            nPageOld = $('.xWPagePdtPrice .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
            nPageCurrent = nPageNew
            break;
        case 'previous': //กดปุ่ม Previous
            nPageOld = $('.xWPagePdtPrice .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
            nPageCurrent = nPageNew
            break;
        default:
            nPageCurrent = ptPage
    }
    JCNxOpenLoading();
    JSvPdtPriceDataTable(nPageCurrent);
}

//Functionality: Function Chack And Show Button Delete All
//Parameters: LocalStorage Data
//Creator: 10/10/2018 witsarut
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
//Creator: 10/10/2018 witsarut
//Return: -
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
    //     $('#ospConfirmDelete').text('ยืนยันการลบข้อมูลของ : ' + tTexts);
    //     $('#ospConfirmIDDelete').val(tTextCode);
    // }
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
//Parameters: Event Select List Reason
//Creator: 10/10/2018 witsarut
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
