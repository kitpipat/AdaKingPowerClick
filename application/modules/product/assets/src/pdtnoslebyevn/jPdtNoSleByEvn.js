var nStaEvnBrowseType   = $('#oetEvnStaBrowse').val();
var tCallEvnBackOption  = $('#oetEvnCallBackOption').val();
// var bStatusNoSaleMainTabValidate = false;
// var bStatusNoSaleTimeTabValidate = false;
//var nCurrentValidTab = 1; // 1 bStatusNoSaleMain 2 bStatusNoSaleTime
// var bStatus1NoSaleTimeTabValidate = false;
// var bStatus2NoSaleTimeTabValidate = false;
// var bStatus3NoSaleTimeTabValidate = false;
var nCurrentDisplayTab = 1; // 1 bStatusNoSaleMain 2 bStatusNoSaleTime
// alert(nStaEvnBrowseType+'//'+tCallEvnBackOption);
$('document').ready(function(){
    localStorage.removeItem('LocalItemData');
    JSxCheckPinMenuClose(); /*Check เปิดปิด Menu ตาม Pin*/
    JSxEvnNavDefult();
    if(nStaEvnBrowseType != 1){
        JSvCallPagePdtNoSleByEvnList();
    }else{
        // JSvCallPagePdtNoSleByEvnAdd();
    }
});

//function : Function Clear Defult Button Product NoSale By Event
//Parameters : Document Ready
//Creator : 21/09/2018 wasin
//Return : Show Tab Menu
//Return Type : -
function JSxEvnNavDefult(){
    if(nStaEvnBrowseType != 1 || nStaEvnBrowseType == undefined){
        $('.xCNEvnVBrowse').hide();
        $('.xCNEvnVMaster').show();
        $('.xCNChoose').hide();
        $('#oliEvnTitleAdd').hide();
        $('#oliEvnTitleEdit').hide();
        $('#odvBtnAddEdit').hide();
        $('#odvBtnEvnInfo').show();
    }else{
        $('#odvModalBody .xCNEvnVMaster').hide();
        $('#odvModalBody .xCNEvnVBrowse').show();
        $('#odvModalBody #odvEvnMainMenu').removeClass('main-menu');
        $('#odvModalBody #oliEvnNavBrowse').css('padding', '2px');
        $('#odvModalBody #odvEvnBtnGroup').css('padding', '0');
        $('#odvModalBody .xCNEvnBrowseLine').css('padding', '0px 0px');
        $('#odvModalBody .xCNEvnBrowseLine').css('border-bottom', '1px solid #e3e3e3');
    }
}

//function : Function Show Event Error
//Parameters : Error Ajax Function 
//Creator : 21/09/2018 wasin
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

//function : Call Page list Product NoSale By Event
//Parameters : Document Redy And Event Button
//Creator :	21/09/2018 wasin
//Return : View
//Return Type : View
function JSvCallPagePdtNoSleByEvnList(){
    localStorage.tStaPageNow = 'JSvCallPagePdtNoSleByEvnList';
    $('#oetSearchPdtNoSleByEvn').val('');
    JCNxOpenLoading();    
    $.ajax({
        type: "POST",
        url: "pdtnoslebyevnList",
        cache: false,
        timeout: 0,
        success: function(tResult){
            $('#odvContentPagePdtNoSleByEvn').html(tResult);
            JSvPdtNoSleByEvnDataTable();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

//function: Call Data List Product NoSale By Event
//Parameters: Ajax Success Event 
//Creator:	21/09/2018 wasin
//Return: View
//Return Type: View
function JSvPdtNoSleByEvnDataTable(pnPage){
    var tSearchAll  = $('#oetSearchPdtNoSleByEvn').val();
    var nPageCurrent    = (pnPage === undefined || pnPage == '')? '1' : pnPage;
    $.ajax({
        type: "POST",
        url: "pdtnoslebyevnDataTable",
        data: {
            tSearchAll: tSearchAll,
            nPageCurrent: nPageCurrent,
        },
        cache: false,
        Timeout: 0,
        success: function(tResult){
            if (tResult != "") {
                $('#ostDataPdtNoSleByEvn').html(tResult);
            }
            JSxEvnNavDefult();
            JCNxLayoutControll();
            JStCMMGetPanalLangHTML('TCNMPdtNoSleByEvn_L'); //โหลดภาษาใหม่
            JCNxCloseLoading();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

//Functionality : Call Page Add Product NoSale By Event 
//Parameters : Event Button Click
//Creator : 24/09/2018 wasin
//Update : 23/04/2019 pap
//Return : View
//Return Type : View
function JSvCallPagePdtNoSleByEvnAdd(){
    JCNxOpenLoading();
    JStCMMGetPanalLangSystemHTML('', '');
    $.ajax({
        type: "POST",
        url: "pdtnoslebyevnPageAdd",
        cache: false,
        timeout: 0,
        success: function(tResult){
            if (nStaEvnBrowseType == 1) {
                $('.xCNEvnVMaster').hide();
                $('.xCNEvnVBrowse').show();
            }else{
                $('.xCNEvnVBrowse').hide();
                $('.xCNEvnVMaster').show();
                $('#oliEvnTitleEdit').hide();
                $('#oliEvnTitleAdd').show();
                $('#odvBtnEvnInfo').hide();
                $('#odvBtnAddEdit').show();
            }
            $('#odvContentPagePdtNoSleByEvn').html(tResult);
            $('#ocbEvnAutoGenCode').change(function(){
                $("#oetEvnCode").val("");
                if($('#ocbEvnAutoGenCode').is(':checked')) {
                    $("#oetEvnCode").attr("readonly", true);
                    $("#oetEvnCode").attr("onfocus", "this.blur()");
                    $('#odvEvnCodeForm').removeClass('has-error');
                    $('#odvEvnCodeForm em').remove();
                }else{
                    $("#oetEvnCode").attr("readonly", false);
                    $("#oetEvnCode").removeAttr("onfocus");
                }
            });
            $("#oetEvnCode,#oetEvnName,#otaEvnRmk").blur(function(){
                JSxSetStatusClickPdtNoSaleSubmit(0);
                JSxValidationFormEvn();
                $("#ofmPdtNoSleByEvnAdd").submit();
            });

            JCNxLayoutControll();
            JCNxCloseLoading();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

//Functionality : Call Page Edit Product NoSale By Event 
//Parameters : Event Button Click 
//Creator : 24/09/2018 wasin
//Return : View
//Return Type : View
function JSvCallPagePdtNoSleByEvnEdit(ptEvnCode){
    JCNxOpenLoading();
    JStCMMGetPanalLangSystemHTML('JSvCallPagePdtNoSleByEvnEdit',ptEvnCode);
    $.ajax({
        type: "POST",
        url: "pdtnoslebyevnPageEdit",
        data: { tEvnCode: ptEvnCode },
        cache: false,
        timeout: 0,
        success: function(tResult){
            if(tResult != ''){
                $('#oliEvnTitleAdd').hide();
                $('#oliEvnTitleEdit').show();
                $('#odvBtnEvnInfo').hide();
                $('#odvBtnAddEdit').show();
                $('#odvContentPagePdtNoSleByEvn').html(tResult);
                $('#oetEvnCode').addClass('xCNDisable');
                $('.xCNDisable').attr('readonly', true);
                $('.xCNiConGen').css('display', 'none');
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

//Functionality : แสดงโมดอล เพื่อเพิ่มช่วงเวลา
//Parameters : -
//Creator : 23/04/2019 pap
//Update : -
//Return : -
//Return Type : -
function JSxAddDateTimeToPdtNosaleShowModal(){
    $("#odvModalAddDataPdtNoSleByEvn").modal("show");
    $('#ofmModalNosaleSetDateTimeInfor').validate().destroy();
    $('#ofmModalNosaleSetDateTimeInfor .has-error').removeClass( "has-error" );
}

//Functionality : เพิ่มแถวข้อมูลจากการเพิ่ม ช่วงเวลาใน โมดอล
//Parameters : -
//Creator : 23/04/2019 pap
//Update : -
//Return : -
//Return Type : -
function JSxCreateElementInDataTableDteTmeModal(){
    //otbNosaleDateTimeOrder
    //JSvCallPagePdtNoSleByEvnEdit('<?php echo $aValue['rtEvnCode']?>')
    var tHtml = "<tr>";
    if($("#ocmEvnType").val()==1){
        tHtml += "   <td class=\"text-center\">";
        tHtml += "      <span>"+$("#ocmEvnType > option[value='1']").html()+"</span>";
        if($("#ocbEvnStaAllDay").prop("checked")){
            tHtml += "      <input type=\"hidden\" class=\"xWOcbEvnStaAllDay\"  value=\"1\" name=\"ocbEvnStaAllDay[]\">";
        
        }else{
            tHtml += "      <input type=\"hidden\" class=\"xWOcbEvnStaAllDay\"  value=\"0\" name=\"ocbEvnStaAllDay[]\">";
        }
        tHtml += "      <input type=\"hidden\" class=\"xWEvnTypeSend\"  value=\"1\" name=\"ocmEvnTypeSend[]\">";
        tHtml += "   </td>";
        tHtml += "   <td class=\"text-center\">";
        tHtml += "      <span>-</span>";
        tHtml += "      <input type=\"hidden\" value=\"\" name=\"oetEvnDStartSend[]\">";
        tHtml += "   </td>";
        tHtml += "   <td class=\"text-center\">";
        tHtml += "      <span>"+$("#oetEvnTStart").val()+"</span>";
        tHtml += "      <input type=\"hidden\" value=\""+$("#oetEvnTStart").val()+"\" name=\"oetEvnTStartSend[]\">";
        tHtml += "   </td>";
        tHtml += "   <td class=\"text-center\">";
        tHtml += "      <span>-</span>";
        tHtml += "      <input type=\"hidden\" value=\"\" name=\"oetEvnDFinishSend[]\">";
        tHtml += "   </td>";
        tHtml += "   <td class=\"text-center\">";
        tHtml += "      <span>"+$("#oetEvnTFinish").val()+"</span>";
        tHtml += "      <input type=\"hidden\" value=\""+$("#oetEvnTFinish").val()+"\" name=\"oetEvnTFinishSend[]\">";
        tHtml += "   </td>";
        tHtml += "   <td class=\"text-center\">";
        tHtml += "      <img class=\"xCNIconTable\" src=\""+$("#ohdIconPathDelete").val()+"\" onClick=\"JSxDeleteNoSaleItemFont(this);\">";
        tHtml += "   </td>";
    }else{
        tHtml += "   <td class=\"text-center\">";
        tHtml += "      <span>"+$("#ocmEvnType > option[value='2']").html()+"</span>";
        if($("#ocbEvnStaAllDay").prop("checked")){
            tHtml += "      <input type=\"hidden\" class=\"xWOcbEvnStaAllDay\"  value=\"1\" name=\"ocbEvnStaAllDay[]\">";
        
        }else{
            tHtml += "      <input type=\"hidden\" class=\"xWOcbEvnStaAllDay\"  value=\"0\" name=\"ocbEvnStaAllDay[]\">";
        }
        tHtml += "      <input type=\"hidden\" value=\"2\" name=\"ocmEvnTypeSend[]\" class=\"xWEvnTypeSend\">";
        tHtml += "   </td>";
        tHtml += "   <td class=\"text-center\">";
        tHtml += "      <span>"+$("#oetEvnDStart").val()+"</span>";
        tHtml += "      <input type=\"hidden\" value=\""+$("#oetEvnDStart").val()+"\" name=\"oetEvnDStartSend[]\">";
        tHtml += "   </td>";
        if($("#ocbEvnStaAllDay").prop("checked")){
            tHtml += "   <td class=\"text-center\">";
            tHtml += "      <span>-</span>";
            tHtml += "      <input type=\"hidden\" value=\"\" name=\"oetEvnTStartSend[]\">";
            tHtml += "   </td>";
        }else{
            tHtml += "   <td class=\"text-center\">";
            tHtml += "      <span>"+$("#oetEvnTStart").val()+"</span>";
            tHtml += "      <input type=\"hidden\" value=\""+$("#oetEvnTStart").val()+"\" name=\"oetEvnTStartSend[]\">";
            tHtml += "   </td>";
        }
        
        tHtml += "   <td class=\"text-center\">";
        tHtml += "      <span>"+$("#oetEvnDFinish").val()+"</span>";
        tHtml += "      <input type=\"hidden\" value=\""+$("#oetEvnDFinish").val()+"\" name=\"oetEvnDFinishSend[]\">";
        tHtml += "   </td>";
        if($("#ocbEvnStaAllDay").prop("checked")){
            tHtml += "   <td class=\"text-center\">";
            tHtml += "      <span>-</span>";
            tHtml += "      <input type=\"hidden\" value=\"\" name=\"oetEvnTFinishSend[]\">";
            tHtml += "   </td>";
        }else{
            tHtml += "   <td class=\"text-center\">";
            tHtml += "      <span>"+$("#oetEvnTFinish").val()+"</span>";
            tHtml += "      <input type=\"hidden\" value=\""+$("#oetEvnTFinish").val()+"\" name=\"oetEvnTFinishSend[]\">";
            tHtml += "   </td>";
        }
       
        tHtml += "   <td class=\"text-center\">";
        tHtml += "      <img class=\"xCNIconTable\" src=\""+$("#ohdIconPathDelete").val()+"\" onClick=\"JSxDeleteNoSaleItemFont(this);\">";
        tHtml += "   </td>";
    }
    tHtml += "</tr>";
    if($("#otbNosaleDateTimeOrder > tr#otrEvnFrmNoData").length!=0){
        $("#otbNosaleDateTimeOrder").html(tHtml);
    }else{
        $("#otbNosaleDateTimeOrder").append(tHtml);
    }
    
}

//Functionality : ลบแถวข้อมูลจากการเพิ่ม ช่วงเวลาใน โมดอล  (font end)
//Parameters : -
//Creator : 23/04/2019 pap
//Update : -
//Return : -
//Return Type : -
function JSxDeleteNoSaleItemFont(pElement){
    $($(pElement).parent()).parent().remove();
    if($("#otbNosaleDateTimeOrder tr").length==0){
        var tHtml = "<tr id=\"otrEvnFrmNoData\"><td class='text-center xCNTextDetail2' colspan='6'>"+$("#ohdEvnFrmNoData").val()+"</td></tr>";
        $("#otbNosaleDateTimeOrder").html(tHtml);
        
    }
}

//Functionality : ลบแถวข้อมูลจากการเพิ่ม ช่วงเวลา  (back end)
//Parameters : -
//Creator : 23/04/2019 pap
//Update : -
//Return : -
//Return Type : -
function JSxDeleteNoSaleItemBack(pnSeq){
    //$("#oetEvnCode").val()
}

//Functionality : เซ็ตค่าเพื่อให้รู้ว่าตอนนี้กดปุ่มบันทึกหลักจริงๆ (เพราะมีการซัมมิทฟอร์มแต่ไม่บันทึกเพื่อให้เกิด validate ใน on blur)
//Parameters : -
//Creator : 23/04/2019 pap
//Update : -
//Return : -
//Return Type : -
function JSxSetStatusClickPdtNoSaleSubmit(pnStatus){
    $("#ohdCheckEvnSubmitByButton").val(pnStatus);
}

//Functionality : เซ็ตค่าเพื่อให้รู้ว่าตอนนี้แท็ปไหนแสดงอยู่
//Parameters : -
//Creator : 23/04/2019 pap
//Update : -
//Return : -
//Return Type : -
function JSxSetStatusCurrentTab(pnNumCurTab){
    // ใช้ในการตรวจสอบว่า ขณะนี้อยู่แท็ปใด เพื่อใช้ในการ validate form
    nCurrentDisplayTab = pnNumCurTab;
}

//Functionality : (เมื่อกดปุ่มบันทึกรองในโมดอล เพื่อทำการ validate form และบันทึกช่วงเวลาที่เพิ่มจาก โมดอล)
//Parameters : -
//Creator : 23/04/2019 pap
//Update : -
//Return : -
//Return Type : -
function JSxAddDateTimeOrderFromModal(ptRoute){
    JSxValidateModalAddDateTimeNoSale(ptRoute);
}

//Functionality : function submit by submit button only (ส่งข้อมูลที่ผ่านการ validate ไปบันทึกฐานข้อมูล)
//Parameters : route
//Creator : 23/04/2019 pap
//Update : -
//Return : -
//Return Type : -
function JSxSubmitEventByButton(){
    JCNxOpenLoading();
    $.ajax({
        type: "POST",
        url: $("#ohdEvnRoute").val(),
        data: $('#ofmPdtNoSleByEvnAdd').serialize(),
        cache: false,
        timeout: 0,
        success: function(oResult){
            if(nStaEvnBrowseType != 1) {
                var aReturn = JSON.parse(oResult);
                if(aReturn['nStaEvent'] == 1){
                    switch(aReturn['nStaCallBack']) {
                        case '1':
                            JSvCallPagePdtNoSleByEvnEdit(aReturn['tCodeReturn']);
                            break;
                        case '2':
                            JSvCallPagePdtNoSleByEvnAdd();
                            break;
                        case '3':
                            JSvCallPagePdtNoSleByEvnList();
                            break;
                        default:
                            JSvCallPagePdtNoSleByEvnEdit(aReturn['tCodeReturn']);
                    }
                }else{
                    alert(aReturn['tStaMessg']);
                    if(aReturn['nStaEvent'] == 901){
                        JSvCallPagePdtNoSleByEvnEdit(aReturn['tCodeReturn']);
                    }
                }
            }else{
                JCNxCloseLoading();
                JCNxBrowseData(tCallEvnBackOption);
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

//Functionality : Event Add/Edit Product NoSale By Event (เมื่อกดปุ่มบันทึกหลัก เพื่อทำการ validate form และส่งค่าไป)
//Parameters : From Submit
//Creator : 26/09/2018 wasin
//Update : 23/04/2019 pap
//Return : Status Event Add/Edit Product NoSale By Event
//Return Type : object
function JSoAddEditPdtNoSleByEvn(){
    // ตรวจสอบการ validate แต่ละ tab ก่อน ค่อยส่งไป JSxSubmitEventByButton
    $('#ofmPdtNoSleByEvnAdd').validate().destroy();
   if(nCurrentDisplayTab==1){
        $("#ohdCheckEvnClearValidate").val(0);
        JSxValidationFormEvn();
    }else{
        if($("#ohdEvnRoute").val()=="pdtnoslebyevnEventAdd"){
            if($("input.xWEvnTypeSend").length<1){
                alert("โปรดระบุช่วงเวลาอย่างน้อย 1 รายการ");
            }else{
                $("#oliEventTimeTap").removeClass("active");
                $("#odvEventTimeTap").removeClass("active");
                $("#oliNameEventTap").addClass("active");
                $("#odvNameEventTap").addClass("active");
                nCurrentDisplayTab = 1;
                JSxValidationFormEvn();
            }
        }else{
            $("#oliEventTimeTap").removeClass("active");
            $("#odvEventTimeTap").removeClass("active");
            $("#oliNameEventTap").addClass("active");
            $("#odvNameEventTap").addClass("active");
            nCurrentDisplayTab = 1;
            JSxValidationFormEvn();
        }
        
    }
}

//Functionality : main validate form (validate ฟอร์มส่วนนอกโมดอลเพิ่มช่วงเวลา) (validate ขั้นที่ 1 ตรวจสอบทั่วไป)
//Parameters : -
//Creator : 23/04/2019 pap
//Update : -
//Return : -
//Return Type : -
function JSxValidationFormEvn(){
    if($("#ohdCheckEvnClearValidate").val()!=0){
        $('#ofmPdtNoSleByEvnAdd').validate().destroy();
    }
    $('#ofmPdtNoSleByEvnAdd').validate({
       rules: {
            oetEvnCode : {
                "required" :{
                  // ตรวจสอบเงื่อนไข validate
                  depends: function(oElement) {
                    if($("#ohdEvnRoute").val()=="pdtnoslebyevnEventAdd"){
                        if($('#ocbEvnAutoGenCode').is(':checked')){
                            return false;
                        }else{
                            return true;
                        }
                    }else{
                        return false;
                    }
                  }
                }
            },
            oetEvnName: {
                "required" :{}
            }
        },
        messages: {
            oetEvnCode : {
                "required" :$('#oetEvnCode').attr('data-validate-required')
            },
            oetEvnName : {
                "required" :$('#oetEvnName').attr('data-validate-required')
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
            if(!$('#ocbEvnAutoGenCode').is(':checked')) {
                JSxValidDuplicateCode();
            }else{
                if($("#ohdCheckEvnSubmitByButton").val()==1){
                    if($("#ohdEvnRoute").val()=="pdtnoslebyevnEventAdd"){
                        if($("input.xWEvnTypeSend").length<1){
                            $("#oliNameEventTap").removeClass("active");
                            $("#odvNameEventTap").removeClass("active");
                            $("#oliEventTimeTap").addClass("active");
                            $("#odvEventTimeTap").addClass("active");
                            nCurrentDisplayTab = 2;
                            alert("โปรดระบุช่วงเวลาอย่างน้อย 1 รายการ");
                        }else{
                            JSxSubmitEventByButton();
                        }
                    }else{
                        JSxSubmitEventByButton();
                    }
                }
            }
        }
    });
    if($("#ohdCheckEvnClearValidate").val()!=0){
        $("#ofmPdtNoSleByEvnAdd").submit();
        $("#ohdCheckEvnClearValidate").val(0);
    }
}

//Functionality : main validate form (validate ฟอร์มส่วนนอกโมดอลเพิ่มช่วงเวลา) (validate ขั้นที่ 2 ตรวจสอบรหัสซ้ำจากฐานข้อมูล)
//Parameters : -
//Creator : 23/04/2019 pap
//Update : -
//Return : -
//Return Type : -
function JSxValidDuplicateCode(){
    $.ajax({
        type: "POST",
        url: "CheckInputGenCode",
        data: { 
            tTableName : "TCNMPdtNoSleByEvn",
            tFieldName : "FTEvnCode",
            tCode : $("#oetEvnCode").val()
        },
        cache: false,
        timeout: 0,
        success: function(tResult){
            var aResult = JSON.parse(tResult);
            $("#ohdCheckDuplicateEvnCode").val(aResult["rtCode"]);
            if($("#ohdCheckEvnClearValidate").val()!=1){
                $('#ofmPdtNoSleByEvnAdd').validate().destroy();
            }
            $.validator.addMethod('dublicateCode', function(value, element) {
                if($("#ohdEvnRoute").val()=="pdtnoslebyevnEventAdd"){
                    if($('#ocbEvnAutoGenCode').is(':checked')){
                        return true;
                    }else{
                        if($("#ohdCheckDuplicateEvnCode").val()==1){
                            return false;
                        }else{
                            return true;
                        }
                    }
                }else{
                    return true;
                }
            });
            $('#ofmPdtNoSleByEvnAdd').validate({
                rules: {
                    oetEvnCode : {
                        "dublicateCode" :{}
                    }
                },
                messages: {
                    oetEvnCode : {
                        "dublicateCode" : $('#oetEvnCode').attr('data-validate-dublicateCode')
                    }
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
                    if($("#ohdCheckEvnSubmitByButton").val()==1){
                        if($("#ohdEvnRoute").val()=="pdtnoslebyevnEventAdd"){
                            if($("input.xWEvnTypeSend").length<1){
                                $("#oliNameEventTap").removeClass("active");
                                $("#odvNameEventTap").removeClass("active");
                                $("#oliEventTimeTap").addClass("active");
                                $("#odvEventTimeTap").addClass("active");
                                nCurrentDisplayTab = 2;
                                alert("โปรดระบุช่วงเวลาอย่างน้อย 1 รายการ");
                            }else{
                                JSxSubmitEventByButton();
                            }
                        }else{
                            JSxSubmitEventByButton();
                        } 
                    }
                }
            });
            if($("#ohdCheckEvnClearValidate").val()!=1){
                $("#ofmPdtNoSleByEvnAdd").submit();
                $("#ohdCheckEvnClearValidate").val(1);
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
    
}

//Functionality : sub validate form (validate ฟอร์มส่วนในโมดอลเพิ่มช่วงเวลา) (validate ขั้นที่ 1 ตรวจสอบทั่วไป)
//Parameters : -
//Creator : 23/04/2019 pap
//Update : -
//Return : -
//Return Type : -
function JSxValidateModalAddDateTimeNoSale(ptRoute){
    if(bStatusValidDateTimeNosale!=0){
        $('#ofmModalNosaleSetDateTimeInfor').validate().destroy();
    }
    $.validator.addMethod('compareFormatDate', function(value, element) {
        if($("#ocmEvnType").val()==2){
            // สร้างตัวแปรเก็บค่า วันที่ในโมเดล
            var dDateStart     = $("#oetEvnDStart").val();
            var dDateFinish    = $("#oetEvnDFinish").val();
            if(dDateStart!="" && dDateFinish!=""){
                if($("#ocbEvnStaAllDay").prop("checked")){
                    if(dDateFinish <= dDateStart){
                        return false;
                    }else{
                        return true;
                    }
                }else{
                    if(dDateFinish < dDateStart){
                        return false;
                    }else{
                        return true;
                    }
                }
            }else{
                return false;
            }
        }else{
            return true;
        }
    });
    $.validator.addMethod('compareFormatTime', function(value, element) {
        if($("#ocmEvnType").val()==2){
            if($("#ocbEvnStaAllDay").prop("checked")){
                return true;
            }else{
                // สร้างตัวแปรเก็บค่า เวลาในโมเดล
                var tTimeStart     = $("#oetEvnTStart").val();
                var tTimeFinish    = $("#oetEvnTFinish").val();
                if(tTimeStart!="" && tTimeFinish!=""){
                    if(tTimeFinish <= tTimeStart){
                        return false;
                    }else{
                        return true;
                    }
                }else{
                    return false;
                }

            }
        }else{
            // สร้างตัวแปรเก็บค่า เวลาในโมเดล
            var tTimeStart     = $("#oetEvnTStart").val();
            var tTimeFinish    = $("#oetEvnTFinish").val();
            if(tTimeStart!="" && tTimeFinish!=""){
                if(tTimeFinish <= tTimeStart){
                    return false;
                }else{
                    return true;
                }
            }else{
                return false;
            }


        }
    });
    $('#ofmModalNosaleSetDateTimeInfor').validate({
        rules: {
            oetEvnDStart :{
                "required" :{
                    // ตรวจสอบเงื่อนไข validate
                    depends: function(oElement) {
                        if($("#ocmEvnType").val()==2){
                            return true;
                        }else{
                            return false;
                        }
                    }
                },
                "maxlength" :10,
                "compareFormatDate" :{}
            },
            oetEvnDFinish :{
                "required" :{
                    // ตรวจสอบเงื่อนไข validate
                    depends: function(oElement) {
                        if($("#ocmEvnType").val()==2){
                            return true;
                        }else{
                            return false;
                        }
                    }
                },
                "maxlength" :10
                
            },
            oetEvnTStart :{
                "required" :{
                    // ตรวจสอบเงื่อนไข validate
                    depends: function(oElement) {
                        if($("#ocmEvnType").val()==2){
                            if($("#ocbEvnStaAllDay").prop("checked")){
                                return false;
                            }else{
                                return true;
                            }
                        }else{
                            return true;
                        }
                    }
                },
                "maxlength" :8,
                "compareFormatTime" : {}
            },
            oetEvnTFinish :{
                "required" :{
                    // ตรวจสอบเงื่อนไข validate
                    depends: function(oElement) {
                        if($("#ocmEvnType").val()==2){
                            if($("#ocbEvnStaAllDay").prop("checked")){
                                return false;
                            }else{
                                return true;
                            }
                        }else{
                            return true;
                        }
                    }
                },
                "maxlength" :8
            }
        },
        messages: {
            oetEvnDStart :{
                "required" : $("#oetEvnDStart").attr("data-validate-required"),
                "maxlength" : $("#oetEvnDStart").attr("data-validate-maxlength"),
                "compareFormatDate" : $("#oetEvnDStart").attr("data-validate-compareFormatDate")
            },
            oetEvnDFinish :{
                "required" : $("#oetEvnDFinish").attr("data-validate-required"),
                "maxlength" : $("#oetEvnDFinish").attr("data-validate-maxlength")
                
            },
            oetEvnTStart :{
                "required" : $("#oetEvnTStart").attr("data-validate-required"),
                "maxlength" : $("#oetEvnTStart").attr("data-validate-maxlength"),
                "compareFormatTime" : $("#oetEvnTStart").attr("data-validate-compareFormatTime")
            },
            oetEvnTFinish :{
                "required" : $("#oetEvnTFinish").attr("data-validate-required"),
                "maxlength" : $("#oetEvnTFinish").attr("data-validate-maxlength")
            }
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
            JSxValidDaplicateDateTimeFontEnd(ptRoute);
        }
    });
    if(bStatusValidDateTimeNosale!=0){
        $('#ofmModalNosaleSetDateTimeInfor').submit();
        bStatusValidDateTimeNosale = 0;
    }
}

//Functionality : sub validate form (validate ฟอร์มส่วนในโมดอลเพิ่มช่วงเวลา) (validate ขั้นที่ 2 ตรวจสอบการเพิ่มช่วงเวลาทับซ้อนกับช่วงเวลาเดิมจากข้อมูลที่แสดงผลของหน้าเว็บ)
//Parameters : -
//Creator : 23/04/2019 pap
//Update : -
//Return : -
//Return Type : -
function JSxValidDaplicateDateTimeFontEnd(ptRoute){
    if(bStatusValidDateTimeNosale!=1){
        $('#ofmModalNosaleSetDateTimeInfor').validate().destroy();
    }
    $.validator.addMethod('duplicateDateTimeInFontEnd', function(value, element) {
        var tOetEvnDStartVal = $("#oetEvnDStart").val();
        var tOetEvnDFinishVal = $("#oetEvnDFinish").val();
        var tOetEvnTStartVal = $("#oetEvnTStart").val();
        var tOetEvnTFinishVal = $("#oetEvnTFinish").val();
        if($("#ocmEvnType").val()==1){
            // ช่วงเวลา
            if(aDataTypeByTimeCompare.length!=0){
                var bCheckTimeCompare = true;
                for(var nI = 0;nI<aDataTypeByTimeCompare.length;nI++){
                    let tCompareTStartSend = aDataTypeByTimeCompare[nI].evnTStartSend;
                    let tCompareTFinishSend = aDataTypeByTimeCompare[nI].evnTFinishSend;
                    if(tOetEvnTStartVal<=tCompareTStartSend){
                        if(tOetEvnTFinishVal<=tCompareTStartSend){
                            if(tOetEvnTStartVal==tCompareTStartSend && 
                               tOetEvnTFinishVal==tCompareTFinishSend){
                                bCheckTimeCompare = false;
                                break;
                            }else{
                                if(tOetEvnTStartVal<tOetEvnTFinishVal){
                                    bCheckTimeCompare = true;
                                }else{
                                    bCheckTimeCompare = false;
                                    break;
                                }
                            }
                        }else{
                            if(tOetEvnTStartVal>=tCompareTFinishSend){
                                if(tOetEvnTFinishVal>=tCompareTFinishSend){
                                    if(tOetEvnTStartVal==tCompareTStartSend && 
                                       tOetEvnTFinishVal==tCompareTFinishSend){
                                        bCheckTimeCompare = false;
                                        break;
                                    }else{
                                        if(tOetEvnTStartVal<tOetEvnTFinishVal){
                                            bCheckTimeCompare = true;
                                        }else{
                                            bCheckTimeCompare = false;
                                            break;
                                        }
                                    }
                                }else{
                                    bCheckTimeCompare = false;
                                    break;
                                }
                            }else{
                                bCheckTimeCompare = false;
                                break;
                            }
                        }
                    }else if(tOetEvnTStartVal>tCompareTStartSend){
                        if(tOetEvnTStartVal>=tCompareTFinishSend){
                            if(tOetEvnTFinishVal>=tCompareTFinishSend){
                                if(tOetEvnTStartVal==tCompareTStartSend && 
                                   tOetEvnTFinishVal==tCompareTFinishSend){
                                    bCheckTimeCompare = false;
                                    break;
                                }else{
                                    if(tOetEvnTStartVal<tOetEvnTFinishVal){
                                        bCheckTimeCompare = true;
                                    }else{
                                        bCheckTimeCompare = false;
                                        break;
                                    }
                                }
                            }else{
                                bCheckTimeCompare = false;
                                break;
                            }
                        }else{
                            bCheckTimeCompare = false;
                            break;
                        }
                    }
                    
                }
                if(bCheckTimeCompare){
                    return true;
                }else{
                    return false;
                }
            }else{
                if(tOetEvnTStartVal<tOetEvnTFinishVal){
                    return true;
                }else{
                    return false;
                }
            }
            // end ช่วงเวลา
        }else{
            if($("#ocbEvnStaAllDay").prop("checked")){
                // ช่วงวันที่ ทั้งวัน
                if(aDataTypeByDateAndAllDayCompare.length!=0){
                    var bCheckDateAllCompare = true;
                    for(var nI = 0;nI<aDataTypeByDateAndAllDayCompare.length;nI++){
                        let tCompareDStartSend = aDataTypeByDateAndAllDayCompare[nI].oetEvnDStart;
                        let tCompareDFinishSend = aDataTypeByDateAndAllDayCompare[nI].oetEvnDFinish;
                        if(tOetEvnDStartVal<=tCompareDStartSend){
                            if(tOetEvnDFinishVal<=tCompareDStartSend){
                                if(tOetEvnDStartVal==tCompareDStartSend && 
                                tOetEvnDFinishVal==tCompareDFinishSend){
                                    bCheckDateAllCompare = false;
                                    break;
                                }else{
                                    if(tOetEvnDStartVal<tOetEvnDFinishVal){
                                        bCheckDateAllCompare = true;
                                    }else{
                                        bCheckDateAllCompare = false;
                                        break;
                                    }
                                }
                            }else{
                                if(tOetEvnDStartVal>=tCompareDFinishSend){
                                    if(tOetEvnDFinishVal>=tCompareDFinishSend){
                                        if(tOetEvnDStartVal==tCompareDStartSend && 
                                        tOetEvnDFinishVal==tCompareDFinishSend){
                                            bCheckDateAllCompare = false;
                                            break;
                                        }else{
                                            if(tOetEvnDStartVal<tOetEvnDFinishVal){
                                                bCheckDateAllCompare = true;
                                            }else{
                                                bCheckDateAllCompare = false;
                                                break;
                                            }
                                        }
                                    }else{
                                        bCheckDateAllCompare = false;
                                        break;
                                    }
                                }else{
                                    bCheckDateAllCompare = false;
                                    break;
                                }
                            }
                        }else if(tOetEvnDStartVal>tCompareDStartSend){
                            if(tOetEvnDStartVal>=tCompareDFinishSend){
                                if(tOetEvnDFinishVal>=tCompareDFinishSend){
                                    if(tOetEvnDStartVal==tCompareDStartSend && 
                                    tOetEvnDFinishVal==tCompareDFinishSend){
                                        bCheckDateAllCompare = false;
                                        break;
                                    }else{
                                        if(tOetEvnDStartVal<tOetEvnDFinishVal){
                                            bCheckDateAllCompare = true;
                                        }else{
                                            bCheckDateAllCompare = false;
                                            break;
                                        }
                                    }
                                }else{
                                    bCheckDateAllCompare = false;
                                    break;
                                }
                            }else{
                                bCheckDateAllCompare = false;
                                break;
                            }
                        }
                        
                    }
                    if(bCheckDateAllCompare){
                        if(tOetEvnDStartVal<tOetEvnDFinishVal){
                            return true;
                        }else{
                            return false;
                        }
                    }else{
                        return false;
                    }
                }else{
                    if(tOetEvnDStartVal<tOetEvnDFinishVal){
                        return true;
                    }else{
                        return false;
                    }
                }
                // end ช่วงวันที่ ทั้งวัน
            }else{
                // ช่วงวันที่ ไม่ทั้งวัน
                if(aDataTypeByDateAndNoAllDayCompare.length!=0){
                    if(tOetEvnDStartVal!=tOetEvnDFinishVal){
                        var bCheckDateSecCompare = true;
                        for(var nI = 0;nI<aDataTypeByDateAndNoAllDayCompare.length;nI++){
                            let tCompareDStartSend = aDataTypeByDateAndNoAllDayCompare[nI].oetEvnDStart;
                            let tCompareDFinishSend = aDataTypeByDateAndNoAllDayCompare[nI].oetEvnDFinish;
                            if(tOetEvnDStartVal<tCompareDStartSend){
                                if(tOetEvnDFinishVal<tCompareDStartSend){
                                    if(tOetEvnDStartVal==tCompareDStartSend && 
                                    tOetEvnDFinishVal==tCompareDFinishSend){
                                        bCheckDateSecCompare = false;
                                        break;
                                    }else{
                                        if(tOetEvnDStartVal<=tOetEvnDFinishVal){
                                            bCheckDateSecCompare = true;
                                        }else{
                                            bCheckDateSecCompare = false;
                                            break;
                                        }
                                    }
                                }else{
                                    if(tOetEvnDStartVal>tCompareDFinishSend){
                                        if(tOetEvnDFinishVal>tCompareDFinishSend){
                                            if(tOetEvnDStartVal==tCompareDStartSend && 
                                            tOetEvnDFinishVal==tCompareDFinishSend){
                                                bCheckDateSecCompare = false;
                                                break;
                                            }else{
                                                if(tOetEvnDStartVal<=tOetEvnDFinishVal){
                                                    bCheckDateSecCompare = true;
                                                }else{
                                                    bCheckDateSecCompare = false;
                                                    break;
                                                }
                                            }
                                        }else{
                                            bCheckDateSecCompare = false;
                                            break;
                                        }
                                    }else{
                                        bCheckDateSecCompare = false;
                                        break;
                                    }
                                }
                            }else if(tOetEvnDStartVal>tCompareDStartSend){
                                if(tOetEvnDStartVal>tCompareDFinishSend){
                                    if(tOetEvnDFinishVal>tCompareDFinishSend){
                                        if(tOetEvnDStartVal==tCompareDStartSend && 
                                        tOetEvnDFinishVal==tCompareDFinishSend){
                                            bCheckDateSecCompare = false;
                                            break;
                                        }else{
                                            if(tOetEvnDStartVal<=tOetEvnDFinishVal){
                                                bCheckDateSecCompare = true;
                                            }else{
                                                bCheckDateSecCompare = false;
                                                break;
                                            }
                                        }
                                    }else{
                                        bCheckDateSecCompare = false;
                                        break;
                                    }
                                }else{
                                    bCheckDateSecCompare = false;
                                    break;
                                }
                            }else if(tOetEvnDStartVal==tCompareDStartSend){
                                bCheckDateSecCompare = false;
                                break;
                            }
                            
                        }
                        if(bCheckDateSecCompare){
                            if(tOetEvnDStartVal<=tOetEvnDFinishVal){
                                bCheckDateSecCompare = true;
                            }else{
                                bCheckDateSecCompare = false;
                            }
                        }
                        var bCheckTimeSecCompare = true;
                        for(var nI = 0;nI<aDataTypeByDateAndNoAllDayCompare.length;nI++){
                            let tCompareTStartSend = aDataTypeByDateAndNoAllDayCompare[nI].evnTStartSend;
                            let tCompareTFinishSend = aDataTypeByDateAndNoAllDayCompare[nI].evnTFinishSend;
                            if(tOetEvnTStartVal<=tCompareTStartSend){
                                if(tOetEvnTFinishVal<=tCompareTStartSend){
                                    if(tOetEvnTStartVal==tCompareTStartSend && 
                                    tOetEvnTFinishVal==tCompareTFinishSend){
                                        bCheckTimeSecCompare = false;
                                        break;
                                    }else{
                                        if(tOetEvnTStartVal<tOetEvnTFinishVal){
                                            bCheckTimeSecCompare = true;
                                        }else{
                                            bCheckTimeSecCompare = false;
                                            break;
                                        }
                                    }
                                }else{
                                    if(tOetEvnTStartVal>=tCompareTFinishSend){
                                        if(tOetEvnTFinishVal>=tCompareTFinishSend){
                                            if(tOetEvnTStartVal==tCompareTStartSend && 
                                            tOetEvnTFinishVal==tCompareTFinishSend){
                                                bCheckTimeSecCompare = false;
                                                break;
                                            }else{
                                                if(tOetEvnTStartVal<tOetEvnTFinishVal){
                                                    bCheckTimeSecCompare = true;
                                                }else{
                                                    bCheckTimeSecCompare = false;
                                                    break;
                                                }
                                            }
                                        }else{
                                            bCheckTimeSecCompare = false;
                                            break;
                                        }
                                    }else{
                                        bCheckTimeSecCompare = false;
                                        break;
                                    }
                                }
                            }else if(tOetEvnTStartVal>tCompareTStartSend){
                                if(tOetEvnTStartVal>=tCompareTFinishSend){
                                    if(tOetEvnTFinishVal>=tCompareTFinishSend){
                                        if(tOetEvnTStartVal==tCompareTStartSend && 
                                        tOetEvnTFinishVal==tCompareTFinishSend){
                                            bCheckTimeSecCompare = false;
                                            break;
                                        }else{
                                            if(tOetEvnTStartVal<tOetEvnTFinishVal){
                                                bCheckTimeSecCompare = true;
                                            }else{
                                                bCheckTimeSecCompare = false;
                                                break;
                                            }
                                        }
                                    }else{
                                        bCheckTimeSecCompare = false;
                                        break;
                                    }
                                }else{
                                    bCheckTimeSecCompare = false;
                                    break;
                                }
                            }
                            
                        }
                        if(bCheckTimeSecCompare){
                            if(tOetEvnTStartVal<tOetEvnTFinishVal){
                                bCheckTimeSecCompare = true;
                            }else{
                                bCheckTimeSecCompare = false;
                            }
                        }
                        if(bCheckDateSecCompare || bCheckTimeSecCompare){
                            return true;
                        }else{
                            return false;
                        }
                    }else{
                        var bCheckTimeSecCompare = true;
                        for(var nI = 0;nI<aDataTypeByDateAndNoAllDayCompare.length;nI++){
                            let tCompareDStartSend = aDataTypeByDateAndNoAllDayCompare[nI].oetEvnDStart;
                            let tCompareDFinishSend = aDataTypeByDateAndNoAllDayCompare[nI].oetEvnDFinish;
                            let tCompareTStartSend = aDataTypeByDateAndNoAllDayCompare[nI].evnTStartSend;
                            let tCompareTFinishSend = aDataTypeByDateAndNoAllDayCompare[nI].evnTFinishSend;
                            if((tOetEvnDStartVal==tCompareDStartSend)||(tOetEvnDStartVal==tCompareDFinishSend)){
                                if(tOetEvnTStartVal<=tCompareTStartSend){
                                    if(tOetEvnTFinishVal<=tCompareTStartSend){
                                        if(tOetEvnTStartVal==tCompareTStartSend && 
                                        tOetEvnTFinishVal==tCompareTFinishSend){
                                            bCheckTimeSecCompare = false;
                                            break;
                                        }else{
                                            if(tOetEvnTStartVal<tOetEvnTFinishVal){
                                                bCheckTimeSecCompare = true;
                                            }else{
                                                bCheckTimeSecCompare = false;
                                                break;
                                            }
                                        }
                                    }else{
                                        if(tOetEvnTStartVal>=tCompareTFinishSend){
                                            if(tOetEvnTFinishVal>=tCompareTFinishSend){
                                                if(tOetEvnTStartVal==tCompareTStartSend && 
                                                tOetEvnTFinishVal==tCompareTFinishSend){
                                                    bCheckTimeSecCompare = false;
                                                    break;
                                                }else{
                                                    if(tOetEvnTStartVal<tOetEvnTFinishVal){
                                                        bCheckTimeSecCompare = true;
                                                    }else{
                                                        bCheckTimeSecCompare = false;
                                                        break;
                                                    }
                                                }
                                            }else{
                                                bCheckTimeSecCompare = false;
                                                break;
                                            }
                                        }else{
                                            bCheckTimeSecCompare = false;
                                            break;
                                        }
                                    }
                                }else if(tOetEvnTStartVal>tCompareTStartSend){
                                    if(tOetEvnTStartVal>=tCompareTFinishSend){
                                        if(tOetEvnTFinishVal>=tCompareTFinishSend){
                                            if(tOetEvnTStartVal==tCompareTStartSend && 
                                            tOetEvnTFinishVal==tCompareTFinishSend){
                                                bCheckTimeSecCompare = false;
                                                break;
                                            }else{
                                                if(tOetEvnTStartVal<tOetEvnTFinishVal){
                                                    bCheckTimeSecCompare = true;
                                                }else{
                                                    bCheckTimeSecCompare = false;
                                                    break;
                                                }
                                            }
                                        }else{
                                            bCheckTimeSecCompare = false;
                                            break;
                                        }
                                    }else{
                                        bCheckTimeSecCompare = false;
                                        break;
                                    }
                                }
                            }
                        }
                        if(bCheckTimeSecCompare){
                            return true;
                        }else{
                            return false;
                        }
                    }
                }else{
                    let bCheckDateSecCompare = true;
                    if(tOetEvnDStartVal<=tOetEvnDFinishVal){
                        bCheckDateSecCompare = true;
                    }else{
                        bCheckDateSecCompare = false;
                    }
                    let bCheckTimeSecCompare = true;
                    if(tOetEvnTStartVal<tOetEvnTFinishVal){
                        bCheckTimeSecCompare = true;
                    }else{
                        bCheckTimeSecCompare = false;
                    }
                    if(bCheckDateSecCompare && bCheckTimeSecCompare){
                        return true;
                    }else{
                        return false;
                    }
                }
                // end ช่วงวันที่ ไม่ทั้งวัน
            }
        }
    });
    $('#ofmModalNosaleSetDateTimeInfor').validate({
        onfocusout: false, 
        onkeyup: false,
        rules: {
            "oetEvnTStart" :{
                "duplicateDateTimeInFontEnd" :{
                    depends: function(oElement) {
                        if($("#ocmEvnType").val()==1){
                            return true;
                        }else{
                            return false;
                        }
                    }
                }
            },
            "oetEvnDStart" :{
                "duplicateDateTimeInFontEnd" :{
                    depends: function(oElement) {
                        if($("#ocmEvnType").val()==2){
                            return true;
                        }else{
                            return false;
                        }
                    }
                }
            }
        },
        messages: {
            "oetEvnTStart" :{
                "duplicateDateTimeInFontEnd" : "ไม่สามารถใช้ช่วงเวลาหรือวันที่นี้ได้ เพราะช่วงเวลาหรือวันที่ดังกล่าวทับซ้อนกัน"
            },
            "oetEvnDStart" :{
                "duplicateDateTimeInFontEnd" : "ไม่สามารถใช้ช่วงเวลาหรือวันที่นี้ได้ เพราะช่วงเวลาหรือวันที่ดังกล่าวทับซ้อนกัน"
            }
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
            JSxValidDaplicateDateTimeBackEnd(ptRoute);
        }
    });
    if(bStatusValidDateTimeNosale!=1){
        $('#ofmModalNosaleSetDateTimeInfor').submit();
        bStatusValidDateTimeNosale = 1;
    }
}

//Functionality : sub validate form (validate ฟอร์มส่วนในโมดอลเพิ่มช่วงเวลา) (validate ขั้นที่ 3 ตรวจสอบการเพิ่มช่วงเวลาทับซ้อนกับช่วงเวลาเดิมจากข้อมูลที่บันทึกไว้ในฐานข้อมูล)
//Parameters : -
//Creator : 23/04/2019 pap
//Update : -
//Return : -
//Return Type : -
function JSxValidDaplicateDateTimeBackEnd(ptRoute){
    var tRoute;
    var oFilter;
    var bStatusTypeAdd;
    var tOetEvnDStartVal = $("#oetEvnDStart").val();
    var tOetEvnDFinishVal = $("#oetEvnDFinish").val();
    var tOetEvnTStartVal = $("#oetEvnTStart").val();
    var tOetEvnTFinishVal = $("#oetEvnTFinish").val();
    if($("#ocmEvnType").val()==1){
        bStatusTypeAdd = "time";
        if(ptRoute=="pdtnoslebyevnEventEdit"){
            tRoute = "pdtnosleCheckTimeDuplicate";
            oFilter = {  
                "tOetEvnCode" : $("#oetEvnCode").val(),
                "tOetEvnTStartVal" : tOetEvnTStartVal,  
                "tOetEvnTFinishVal" : tOetEvnTFinishVal
            };
        }
    }else{
        if($("#ocbEvnStaAllDay").prop("checked")){
            bStatusTypeAdd = "date";
            if(ptRoute=="pdtnoslebyevnEventEdit"){
                tRoute = "pdtnosleCheckDateDuplicate";
                oFilter = {  
                    "tOetEvnCode" : $("#oetEvnCode").val(),
                    "tOetEvnDStartVal" : tOetEvnDStartVal,  
                    "tOetEvnDFinishVal" : tOetEvnDFinishVal
                };
            }
        }else{
            bStatusTypeAdd = "datetime";
            if(ptRoute=="pdtnoslebyevnEventEdit"){
                tRoute = "pdtnosleCheckDateTimeDuplicate";
                oFilter = {  
                    "tOetEvnCode" : $("#oetEvnCode").val(),
                    "tOetEvnDStartVal" : tOetEvnDStartVal,  
                    "tOetEvnDFinishVal" : tOetEvnDFinishVal,
                    "tOetEvnTStartVal" : tOetEvnTStartVal,  
                    "tOetEvnTFinishVal" : tOetEvnTFinishVal
                };
            }
        }
    }
    if(ptRoute=="pdtnoslebyevnEventEdit"){
        $.ajax({
            type: "POST",
            url: tRoute,
            data: oFilter,
            cache: false,
            timeout: 0,
            success: function(tResult) {
                var bReturn = JSON.parse(tResult);
                if(bStatusValidDateTimeNosale!=2){
                    $('#ofmModalNosaleSetDateTimeInfor').validate().destroy();
                }
                $.validator.addMethod('duplicateDateTimeInBackEnd', function(value, element) {
                    if(bReturn){
                        if(bStatusTypeAdd=="time"){
                            aDataTypeByTimeCompare.push({
                                "evnTStartSend" : tOetEvnTStartVal, 
                                "evnTFinishSend" : tOetEvnTFinishVal
                            });
                        }else if(bStatusTypeAdd=="date"){
                            aDataTypeByDateAndAllDayCompare.push({
                                "oetEvnDStart" : tOetEvnDStartVal, 
                                "oetEvnDFinish" : tOetEvnDFinishVal
                            });
                        }else{
                            aDataTypeByDateAndNoAllDayCompare.push({
                                "oetEvnDStart" : tOetEvnDStartVal, 
                                "oetEvnDFinish" : tOetEvnDFinishVal,
                                "evnTStartSend" : tOetEvnTStartVal, 
                                "evnTFinishSend" : tOetEvnTFinishVal
                            });
                        }
                        return true;
                    }else{
                        return false;
                    }
                });
                $('#ofmModalNosaleSetDateTimeInfor').validate({
                    onfocusout: false, 
                    onkeyup: false,
                    rules: {
                        "oetEvnTStart" :{
                            "duplicateDateTimeInBackEnd" :{
                                depends: function(oElement) {
                                    if($("#ocmEvnType").val()==1){
                                        return true;
                                    }else{
                                        return false;
                                    }
                                }
                            }
                        },
                        "oetEvnDStart" :{
                            "duplicateDateTimeInBackEnd" :{
                                depends: function(oElement) {
                                    if($("#ocmEvnType").val()==2){
                                        return true;
                                    }else{
                                        return false;
                                    }
                                }
                            }
                        }
                    },
                    messages: {
                        "oetEvnTStart" :{
                            "duplicateDateTimeInBackEnd" : "ไม่สามารถใช้ช่วงเวลาหรือวันที่นี้ได้ เพราะช่วงเวลาหรือวันที่ดังกล่าวทับซ้อนกันใน ฐานข้อมูล"
                        },
                        "oetEvnDStart" :{
                            "duplicateDateTimeInBackEnd" : "ไม่สามารถใช้ช่วงเวลาหรือวันที่นี้ได้ เพราะช่วงเวลาหรือวันที่ดังกล่าวทับซ้อนกันใน ฐานข้อมูล"
                        }
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
                        JSxCreateElementInDataTableDteTmeModal();
                        $("#oetEvnDStart").val("");
                        $("#oetEvnDFinish").val("");
                        $("#oetEvnTStart").val("");
                        $("#oetEvnTFinish").val("");
                        $("#odvModalAddDataPdtNoSleByEvn").modal("hide");
                    }
                });
                if(bStatusValidDateTimeNosale!=2){
                    $('#ofmModalNosaleSetDateTimeInfor').submit();
                    bStatusValidDateTimeNosale = 2;
                }
    
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }else{
        if(bStatusTypeAdd=="time"){
            aDataTypeByTimeCompare.push({
                "evnTStartSend" : tOetEvnTStartVal, 
                "evnTFinishSend" : tOetEvnTFinishVal
            });
        }else if(bStatusTypeAdd=="date"){
            aDataTypeByDateAndAllDayCompare.push({
                "oetEvnDStart" : tOetEvnDStartVal, 
                "oetEvnDFinish" : tOetEvnDFinishVal
            });
        }else{
            aDataTypeByDateAndNoAllDayCompare.push({
                "oetEvnDStart" : tOetEvnDStartVal, 
                "oetEvnDFinish" : tOetEvnDFinishVal,
                "evnTStartSend" : tOetEvnTStartVal, 
                "evnTFinishSend" : tOetEvnTFinishVal
            });
        }
        JSxCreateElementInDataTableDteTmeModal();
        $("#oetEvnDStart").val("");
        $("#oetEvnDFinish").val("");
        $("#oetEvnTStart").val("");
        $("#oetEvnTFinish").val("");
        $("#odvModalAddDataPdtNoSleByEvn").modal("hide");
    }   
}

//Functionality : Generate Code Product NoSale By Event
//Parameters : Event Button Click
//Creator : 26/09/2018 wasin
//Return : Event Push Value In Input
//Return Type : -
function JStGeneratePdtNoSleByEvnCode(){
    $('#oetEvnCode').parent().removeClass('alert-validate');
    var tTableName = 'TCNMPdtNoSleByEvn';
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
                $('#oetEvnCode').val(tData.rtEvnCode);
                $('#oetEvnCode').addClass('xCNDisable');
                $('.xCNDisable').attr('readonly', true);
                //----------Hidden ปุ่ม Gen
                $('.xCNiConGen').css('display', 'none');
                $('#oetEvnName').focus();
                $('.xCNBtnGenCode').attr('disabled', true);
            }else{
                $('#oetEvnCode').val(tData.rtDesc);
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
//Creator : 24/09/2018 wasin
//Return : object Status Delete
//Return Type : object
function JSoPdtNoSleByEvnDel(pnPage,ptName,tIDCode){
    var aData = $('#ohdConfirmIDDelete').val();
    var aTexts = aData.substring(0, aData.length - 2);
    var aDataSplit = aTexts.split(" , ");
    var aDataSplitlength = aDataSplit.length;
    var aNewIdDelete = [];

    if (aDataSplitlength == '1') {

        $('#odvModalDelPdtNoSleByEvn').modal('show');
        $('#ospConfirmDelete').html($('#oetTextComfirmDeleteSingle').val() + tIDCode + ' ( ' + ptName + ' ) ');
        $('#osmConfirm').on('click', function(evt) {

            if (localStorage.StaDeleteArray != '1') {

                $.ajax({
                    type: "POST",
                    url: "pdtnoslebyevnEventDelete",
                    data: { 'tIDCode': tIDCode},
                    cache: false,
                    success: function(tResult) {
                        tResult = tResult.trim();
                        var tData = $.parseJSON(tResult);

                        $('#odvModalDelPdtNoSleByEvn').modal('hide');
                        $('#ospConfirmDelete').text($('#oetTextComfirmDeleteSingle').val());
                        $('#ohdConfirmIDDelete').val('');
                        localStorage.removeItem('LocalItemData');
                        $('.modal-backdrop').remove();
                        JSvPdtNoSleByEvnDataTable(pnPage);

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
    //     $('#odvModalDelPdtNoSleByEvn').modal('show');
    //     $('#ospConfirmDelete').html('ยืนยันการลบข้อมูล หมายเลข : ' + tIDCode);
    //     $('#osmConfirm').on('click', function(evt){
    //         JCNxOpenLoading();
    //         $.ajax({
    //             type: "POST",
    //             url: "pdtnoslebyevnEventDelete",
    //             data: { 'tIDCode': tIDCode },
    //             cache: false,
    //             timeout: 0,
    //             success: function(oResult){
    //                 var aReturn = JSON.parse(oResult);
    //                 if (aReturn['nStaEvent'] == 1){
    //                     $('#odvModalDelPdtNoSleByEvn').modal('hide');
    //                     $('#ospConfirmDelete').text('ยืนยันการลบข้อมูลของ : ');
    //                     $('#ospConfirmIDDelete').val('');
    //                     localStorage.removeItem('LocalItemData');
    //                     setTimeout(function() {
    //                         JSvPdtNoSleByEvnDataTable();
    //                     }, 500);
    //                 }else{
    //                     alert(aReturn['tStaMessg']);                        
    //                 }
    //                 JSxEvnNavDefult();
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
//Creator: 24/09/2018 wasin
//Return:  object Status Delete
//Return Type: object

function  JSoPdtNoSleByEvnDelChoose(pnPage){
	JCNxOpenLoading();

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
            url: "pdtnoslebyevnEventDelete",
            data: { 'tIDCode': aNewIdDelete },
            success: function(tResult) {
                
                JSxEvnNavDefult();
                setTimeout(function() {
                    $('#odvModalDelPdtNoSleByEvn').modal('hide');
                    JSvPdtNoSleByEvnDataTable(pnPage);
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

	// var aData 				= $('#ohdConfirmIDDelete').val();
	// var aTexts				= aData.substring(0, aData.length-2);
	// var aDataSplit			= aTexts.split(" , ");
	// var aDataSplitlength	= aDataSplit.length;
	// var aNewIdDelete		= [];
	
	// for($i=0; $i<aDataSplitlength; $i++){
	// 	aNewIdDelete.push(aDataSplit[$i]);
	// }

	// if(aDataSplitlength > 1){
		
	// 	localStorage.StaDeleteArray = '1';
		
 	// 	$.ajax({
	// 	type: "POST",
	// 	url: "pdtnoslebyevnEventDelete",
	// 	data: { 'tIDCode' : aNewIdDelete },
	// 	success: function (tResult) {
			
	// 			setTimeout(function(){
	// 					$('#odvModalDelPdtNoSleByEvn').modal('hide');
	// 					$('#ospConfirmDelete').text('ยืนยันการลบข้อมูลของ : ');
	// 					$('#ohdConfirmIDDelete').val('');
	// 					localStorage.removeItem('LocalItemData');
	// 					JSvCallPageWarehouseList();
	// 					$('.modal-backdrop').remove();
	// 			},500);
				
	// 		},
	// 		error: function (data) {
	// 			console.log(data);
	// 		}
	// 	});

		
	// }else{
	// 	localStorage.StaDeleteArray = '0';
		
	// 	return false;
	// }
	
}


//Functionality : เปลี่ยนหน้า pagenation
//Parameters : Event Click Pagenation
//Creator : 24/01/2019 witsarut
//Return : View
//Return Type : View

function JSvClickPage(ptPage){
	var nPageCurrent = '';
	switch (ptPage) {
		case 'next': //กดปุ่ม Next
			$('.xWBtnNext').addClass('disabled');
			nPageOld = $('.xWPagePdtNoSleByEvn .active').text(); // Get เลขก่อนหน้า
			nPageNew = parseInt(nPageOld,10)+1; // +1 จำนวน
			nPageCurrent = nPageNew
			break;
		case 'previous': //กดปุ่ม Previous
			nPageOld = $('.xWPagePdtNoSleByEvn .active').text(); // Get เลขก่อนหน้า
			nPageNew = parseInt(nPageOld,10)-1; // -1 จำนวน
			nPageCurrent = nPageNew
			break;
	default:
		nPageCurrent = ptPage
	}
	JSvPdtNoSleByEvnDataTable(nPageCurrent);
}


//Functionality: Function Chack And Show Button Delete All
//Parameters: LocalStorage Data
//Creator: 24/09/2018 wasin
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
//Creator: 24/09/2018 wasin
//Return: -
//Return Type: -
function JSxTextinModal() {
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
//Creator: 24/09/2018 wasin
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