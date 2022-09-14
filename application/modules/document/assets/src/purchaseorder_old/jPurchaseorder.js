var nStaPOBrowseType = $('#oetPOStaBrowse').val();
var tCallPOBackOption = $('#oetPOCallBackOption').val();
$('document').ready(function() {
    
    localStorage.removeItem('LocalItemData');
    JSxCheckPinMenuClose(); /*Check เปิดปิด Menu ตาม Pin*/
    JSxPMTNavDefult();

    if (nStaPOBrowseType != 1) {
        JSvCallPagePOList();
    } else {
        JSvCallPagePOAdd();
    }

});

function JSxPMTNavDefult() {
    if (nStaPOBrowseType != 1 || nStaPOBrowseType == undefined) {
        $('.xCNPOVBrowse').hide();
        $('.xCNPOVMaster').show();
        $('#oliPOTitleAdd').hide();
        $('#oliPOTitleEdit').hide();
        $('#odvBtnAddEdit').hide();
        $('.obtChoose').hide();
        $('#odvBtnPOInfo').show();
    } else {
        $('#odvModalBody .xCNPOVMaster').hide();
        $('#odvModalBody .xCNPOVBrowse').show();
        $('#odvModalBody #odvPOMainMenu').removeClass('main-menu');
        $('#odvModalBody #oliPONavBrowse').css('padding', '2px');
        $('#odvModalBody #odvPOBtnGroup').css('padding', '0');
        $('#odvModalBody .xCNPOBrowseLine').css('padding', '0px 0px');
        $('#odvModalBody .xCNPOBrowseLine').css('border-bottom', '1px solid #e3e3e3');
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


//Function : Get Pdt List In to Table
function JCNvPOBrowsePdt(){

    tXphDocNo = $('#oetXphDocNo').val();
    tSplCode = $('#oetSplCode').val();

    //Check ต้องมีค่า
    if(tXphDocNo != '' && tSplCode != ''){
        //Clear Active ที่ค้างอยู่
        $('#odvPdtDataMultiSelection').html('');
        $('#odvBrowsePdtPanal .collapse').removeClass('active');

        tSplCode = $('#oetSplCode').val();
        tStaPage = $('#ohdBrowsePdtStaPage').val();
        nStaLoad = $('#odvBrowsePdtPanal').html().length;

        //Count text in div เพื่อ Check ที่จะไม่ต้อง โหลด Html มาลงใหม่
        if(nStaLoad < 20){
            $.ajax({
                type: "POST",
                url: "BrowseGetPdtList",
                data: {
                    tSplCode:tSplCode,
                    tStaPage:tStaPage
                },
                cache: false,
                timeout: 5000,
                success: function(tResult){
                    
                    $('#odvBrowsePdtPanal').html(tResult);
                
                    $('#odvBrowsePdt').modal('toggle');
        
                },
                error: function(data) {
                    console.log(data);
                }
            });
        }else{
            $('#odvBrowsePdt').modal('toggle');
        }
    }else{
        FSvCMNSetMsgWarningDialog(aLocale['tMsgPlsEnterCodeAndSpl']);
    }
  
}

function JSnPOApprove(pbIsConfirm){

    tXphDocNo = $('#oetXphDocNo').val();
    
    if(pbIsConfirm){
        
        $.ajax({
            type: "POST",
            url: "POApprove",
            data: { 
                tXphDocNo : tXphDocNo
            },
            cache: false,
            timeout: 5000,
            success: function(tResult){
                
                $("#odvPOPopupApv").modal('hide');

                aResult = $.parseJSON(tResult);
                if(aResult.nSta == 1){
                    JSvCallPagePOEdit(tXphDocNo)
                }else{
                    JCNxCloseLoading();
                    tMsgBody = aResult.tMsg
                    FSvCMNSetMsgWarningDialog(tMsgBody);
                }

            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }else{
        $("#odvPOPopupApv").modal('show');
    }
}


function JSnPOCancel(pbIsConfirm){

    tXphDocNo = $('#oetXphDocNo').val();
    
    if(pbIsConfirm){
        
        $.ajax({
            type: "POST",
            url: "POCancel",
            data: { 
                tXphDocNo : tXphDocNo
            },
            cache: false,
            timeout: 5000,
            success: function(tResult){
                
                $("#odvPOPopupCancel").modal('hide');

                aResult = $.parseJSON(tResult);
                if(aResult.nSta == 1){
                    JSvCallPagePOEdit(tXphDocNo)
                }else{
                    JCNxCloseLoading();
                    tMsgBody = aResult.tMsg
                    FSvCMNSetMsgWarningDialog(tMsgBody);
                }

            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }else{
        //Check Status Approve for Control Msg In Modal
        nStaApv = $('#ohdXphStaApv').val();

        if(nStaApv == 1){
            $('#obpMsgApv').show();
        }else{
            $('#obpMsgApv').hide();
        }

        $("#odvPOPopupCancel").modal('show');
    }
}

//Function : GET Scan BarCode
function JSvPOScanPdtHTML(){
    
    tBarCode = $('#oetScanPdtHTML').val();
    tSplCode = $('#oetSplCode').val();

    if(tBarCode != ''){
        
        JCNxOpenLoading();

        $.ajax({
            type: "POST",
            url: "POGetPdtBarCode",
            data: { 
                tBarCode : tBarCode,
                tSplCode : tSplCode
            },
            cache: false,
            timeout: 5000,
            success: function(tResult){
    
                aResult = $.parseJSON(tResult);

                if(aResult.aData != 0){
    
                    tData = $.parseJSON(aResult.aData);

                    tPdtCode = tData[0].FTPdtCode
                    tPunCode = tData[0].FTPunCode
    
                    //Funtion Add Pdt To Table
                    FSvPDTAddPdtIntoTableDT(tPdtCode,tPunCode);
    
                    $('#oetScanPdtHTML').val('');
                    $('#oetScanPdtHTML').focus();
    
                }else{
                    JCNxCloseLoading();
                    tMsgBody = aResult.tMsg
                    FSvCMNSetMsgWarningDialog(tMsgBody);
                }
    
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }else{
        $('#oetScanPdtHTML').focus();
    }

}

function JSnPORemoveAllDTInFile(){
    
    ptXphDocNo = $('#oetXphDocNo').val();

    $.ajax({
        type: "POST",
        url: "PORemoveAllPdtInFile",
        data: { 
            ptXphDocNo  : ptXphDocNo
        },
        cache: false,
        timeout: 5000,
        success: function(tResult){

            JSvPOLoadPdtDataTableHtml();

        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });

}

function JSnPORemoveDTInFile(ptIndex,ptPdtCode){
    
    ptXphDocNo = $('#oetXphDocNo').val();
    $.ajax({
        type: "POST",
        url: "PORemovePdtInFile",
        data: { 
            ptXphDocNo  : ptXphDocNo,
            ptIndex     : ptIndex,
            ptPdtCode   : ptPdtCode 
        },
        cache: false,
        timeout: 5000,
        success: function(tResult){

            JSvPOLoadPdtDataTableHtml();

        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });

}

//Function : เพิ่มสินค้าจาก ลง Table ฝั่ง Client
//Create : 2018-08-28 Krit(Copter)
function FSvPDTAddPdtIntoTableDT(ptPdtCode,ptPunCode,pnXphVATInOrEx){

    ptOptDocAdd = $('#ohdOptScanSku').val();

    JCNxOpenLoading();

    ptXphDocNo = $('#oetXphDocNo').val();
    ptBchCode = $('#ohdSesUsrBchCode').val();

    $.ajax({
        type: "POST",
        url: "POAddPdtIntoTableDT",
        data: { 
                ptXphDocNo  : ptXphDocNo,
                ptBchCode   : ptBchCode,
                ptPdtCode   : ptPdtCode,
                ptPunCode   : ptPunCode,
                ptOptDocAdd : ptOptDocAdd,
                pnXphVATInOrEx : pnXphVATInOrEx
        },
        cache: false,
        timeout: 5000,
        success: function(tResult){

            JMvDOCGetPdtImgScan(ptPdtCode)

            JSvPOLoadPdtDataTableHtml();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
    
}

//Function : เพิ่มสินค้าจาก ลง Table ฝั่ง Client
//Create : 2018-08-28 Krit(Copter)
function FSvPOEditPdtIntoTableDT(ptEditSeqNo,paField,paValue){

    ptXphDocNo  = $('#oetXphDocNo').val();
    ptBchCode   = $('#ohdSesUsrBchCode').val(); 
    
    $.ajax({
        type: "POST",
        url: "POEditPdtIntoTableDT",
        data: { 
                ptXphDocNo : ptXphDocNo,
                ptEditSeqNo : ptEditSeqNo,
                paField     : paField,
                paValue     : paValue
        },
        cache: false,
        timeout: 5000,
        success: function(tResult){

            JSvPOLoadPdtDataTableHtml();
            
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
    
}


function FSvGetSelectShpByBch(ptBchCode){

    $.ajax({
        type: "POST",
        url: "POGetShpByBch",
        data: {ptBchCode : ptBchCode},
        cache: false,
        timeout: 5000,
        success: function(tResult){

            var tData = $.parseJSON(tResult);
      
            $('#ostShpCode option').each(function(){
                    
                if ($(this).val() != '')
                {
                    $(this).remove();
                }
            });

            if(tData.raItems != undefined){
                for (var i=0;i<tData.raItems.length;i++) {
                 
                    if(tData.raItems[i].rtShpCode != ''){
                      
                    //    $('.xWostShpCode #ostShpCode').append($('option')
                    //                    .val(tData.raItems[i].rtShpCode)
                    //                    .text(tData.raItems[i].rtShpName)
                    //    );
                        var data = {
                            id: tData.raItems[i].rtShpCode,
                            text: tData.raItems[i].rtShpName
                        };

                       var newOption = new Option(data.text, data.id, false, false);
                        $('#ostShpCode').append(newOption).trigger('change');
                    }
               }
            }

        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });

}


//Functionality : Call Purchase Page Add  
//Parameters : -
//Creator : 02/07/2018 Krit(Copter)
//Return : View
//Return Type : View
function JSvCallPagePOAdd() {

    $.ajax({
        type: "POST",
        url: "POPageAdd",
        data: {},
        cache: false,
        timeout: 5000,
        success: function(tResult) {

            if (nStaPOBrowseType == 1) {
                $('.xCNPOVMaster').hide();
                $('.xCNPOVBrowse').show();
            } else {
                $('.xCNPOVBrowse').hide();
                $('.xCNPOVMaster').show();
                $('#oliPOTitleEdit').hide();
                $('#oliPOTitleAdd').show();
                $('#odvBtnPOInfo').hide();
                $('#odvBtnAddEdit').show();
                $('#obtPOApprove').hide();
                $('#obtPOCancel').hide();
            }

            $('#odvContentPagePO').html(tResult);
            
            // Control Object And Button ปิด เปิด 
            JCNxPOControlObjAndBtn();

            //Load Pdt Table
            JSvPOLoadPdtDataTableHtml();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });

}


function JSnPmhAddCondition(){
	
    $('#ofmAddCondition').validate({
    rules: {
        oetPmcGrpName 	: "required",
        oetPmcStaGrpCond: "required",
        oetPmcBuyQty 	: "required",
        oetPmcBuyAmt 	: "required",
        ostPmcGetCond	: "required",
    },
    messages: {
        oetPmcGrpName 	: "",
        oetPmcStaGrpCond: "",
        oetPmcBuyQty 	: "",
        oetPmcBuyAmt 	: "",
        ostPmcGetCond	: "",
    },
    errorClass: "alert-validate",
    validClass: "",
    highlight: function(element, errorClass, validClass) {

        $(element).parent('.validate-input').addClass(errorClass).removeClass(validClass);
        $(element).parent().parent('.validate-input').addClass(errorClass).removeClass(validClass);
        
    },
    unhighlight: function(element, errorClass, validClass) {

        $(element).parent('.validate-input').removeClass(errorClass).addClass(validClass);
        $(element).parent().parent('.validate-input').removeClass(errorClass).addClass(validClass);
        
    },
    submitHandler: function(form) {

    //กลุ่ม
    nPmcGrpName = $('#oetPmcGrpName').val();
    tPmcGrpName = $('#oetPmcGrpName option:selected').text();

    //ประเภทการซื้อ/รับ
    nPmcStaGrpCond = $('#oetPmcStaGrpCond').val();
    tPmcStaGrpCond = $('#oetPmcStaGrpCond option:selected').text();

    //put ลง Input hiden เพื่อเช็คประเภท
    if(nPmcStaGrpCond != '' || nPmcStaGrpCond == undefined){

        tStaGrpCondHave = $('#ohdStaGrpCondHave').val();

        if(tStaGrpCondHave != ''){
            tStaGrpCondHave += ','+nPmcStaGrpCond;
            $('#ohdStaGrpCondHave').val(tStaGrpCondHave);
        }else{
            $('#ohdStaGrpCondHave').val(nPmcStaGrpCond);
        }
    }

    //ซื้อครบจำนวน
    nPmcBuyQty = $('#oetPmcBuyQty').val();
    if(nPmcBuyQty == '' || nPmcBuyQty == undefined){
        nPmcBuyQty = '-';
    }else{
        nPmcBuyQty = parseFloat(nPmcBuyQty);
        nPmcBuyQty =  nPmcBuyQty.toFixed(2);
    }

    //ซื้อครบมูลค่า
    nPmcBuyAmt = $('#oetPmcBuyAmt').val();
    if(nPmcBuyAmt == '' || nPmcBuyAmt == undefined){
        nPmcBuyAmt = '-';
    }else{
        nPmcBuyAmt = parseFloat(nPmcBuyAmt);
        nPmcBuyAmt = nPmcBuyAmt.toFixed(2)
    }

    //รูปแบบส่วนลด
    nPmcGetCond = $('#ostPmcGetCond').val();
    tPmcGetCond = $('#ostPmcGetCond option:selected').text();

    if(nPmcGetCond == 4){
        ohdControllCound = $('#ohdControllCound').val();
        $('#ohdControllCound').val(ohdControllCound+nPmcGetCond+',');
    }

    //Avg %
    nPmcPerAvgDis = $('#oetPmcPerAvgDis').val();
    if(nPmcPerAvgDis == '' || nPmcPerAvgDis == undefined){
        nPmcPerAvgDis = '-';
    }else{
        nPmcPerAvgDis = parseFloat(nPmcPerAvgDis);
        nPmcPerAvgDis = nPmcPerAvgDis.toFixed(2)
    }

    //มูลค่า
    nPmcGetValue = $('#oetPmcGetValue').val();
    if(nPmcGetValue == '' || nPmcGetValue == undefined){
        nPmcGetValue = '-';
    }else{
        nPmcGetValue = parseFloat(nPmcGetValue);
        nPmcGetValue = nPmcGetValue.toFixed(2)
    }

    //จำนวน
    nPmcGetQty = $('#oetPmcGetQty').val();
    if(nPmcGetQty == '' || nPmcGetQty == undefined){
        nPmcGetQty = '-';
    }else{
        nPmcGetQty = parseFloat(nPmcGetQty);
        nPmcGetQty = nPmcGetQty.toFixed(2)
    }
    

    //ขั้นต่ำ
    nPmcBuyMinQty = $('#oetPmcBuyMinQty').val();
    if(nPmcBuyMinQty == '' || nPmcBuyMinQty == undefined){
        nPmcBuyMinQty = '-';
    }else{
        nPmcBuyMinQty = parseFloat(nPmcBuyMinQty);
        nPmcBuyMinQty = nPmcBuyMinQty.toFixed(2)
    }

    //ไม่เกิน
    nPmcBuyMaxQty = $('#oetPmcBuyMaxQty').val();
    if(nPmcBuyMaxQty == '' || nPmcBuyMaxQty == undefined){
        nPmcBuyMaxQty = '-';
    }else{
        nPmcBuyMaxQty = parseFloat(nPmcBuyMaxQty);
        nPmcBuyMaxQty = nPmcBuyMaxQty.toFixed(2)
    }




    ohdSpmStaBuy = $('#ohdSpmStaBuy').val();
    if(ohdSpmStaBuy == '3' || ohdSpmStaBuy == '4'){
        nBuyVal = nPmcBuyQty
    }else if(ohdSpmStaBuy == '1' || ohdSpmStaBuy == '2'){
        nBuyVal = nPmcBuyAmt
    }

    var nRows= $('#odvCondition tr.xWCondition').length;
    var	nRows = nRows+1;

  
    if(nRows >= 0){
        //Append Tr Unit
        $("#odvCondition").append($('<tr>')
        .addClass('text-center xCNTextDetail2 xWCondition')
        .attr('id','otrCondition'+nRows)
        .attr('data-grpcound',nPmcStaGrpCond)
        .attr('data-getcound',nPmcGetCond)
        .attr('data-name',tPmcGrpName)

            //<input type="text" name="ohdCondition[]" value="1,กลุ่มซื้อ,1,1,,10,11,12">
            .append($('<input>')
            .addClass('xCNHide '+'xWValHiden'+nPmcGrpName)
            .attr('name','ohdCondition[]')
            .val(nRows+','+tPmcGrpName+','+nPmcStaGrpCond+','+nPmcPerAvgDis+','+nPmcGetValue+','+nPmcGetQty+','+nPmcGetCond+','+nPmcBuyAmt+','+nPmcBuyQty+','+nPmcBuyMinQty+','+nPmcBuyMaxQty+','+nPmcGrpName)
            )
            
            //Append Td ลำดับ
            .append($('<td>')
            .text(nRows)
            )

            //Append Td กลุ่ม
            .append($('<td>')
            .addClass('text-left '+'xWPut'+nPmcGrpName)
            .text(tPmcGrpName)
            )

            //Append Td ซื้อ/ร้บ
            .append($('<td>')
            .text(tPmcStaGrpCond)
            )

            //Append Td Avg
            .append($('<td>')
            .addClass('text-right')
            .text(nPmcPerAvgDis)
            )

            //Append Td Buy Amt
            .append($('<td>')
            .addClass('text-right')
            .text(nPmcBuyAmt)
            )

            //Append Td Buy Qty
            .append($('<td>')
            .addClass('text-right')
            .text(nPmcBuyQty)
            )

            //Append Td Min Amt
            .append($('<td>')
            .addClass('text-right')
            .text(nPmcBuyMinQty)
            )

            //Append Td Max Amt
            .append($('<td>')
            .addClass('text-right')
            .text(nPmcBuyMaxQty)
            )

            //Append Td Value
            .append($('<td>')
            .addClass('text-right')
            .text(nPmcGetValue)
            )


            //Append Td Qty
            .append($('<td>')
            .addClass('text-right')
            .text(nPmcGetQty)
            )

            //Append Td Delete
            .append($('<td>')
            .attr('class', 'text-center')
                .append($('<lable>')
                .attr('class','xCNTextLink')
                    .append($('<i>')
                    .attr('class','fa fa-trash-o')
                    .attr('onclick','JSnRemoveRow(this)')
                    )
                )
            )
        )
        
    }else{
        alert('Duplicate');
    }

    $('#').val()

    $('#odvModalPmhCondition').modal('toggle'); /*Close Modal*/

    //Clear Data Input
    $('#odvModalPmhCondition input').val('');
    $('#odvModalPmhCondition select').val('').trigger('change');
    //Clear Data Input

    JSxPMTControlGetCond(); //Check Cound เพื่อ Controll Layout

    },
    errorPlacement: function(error, element) {
        return true;
    }
});

}







// //Functionality : (event) Add/Edit
// //Parameters : form
// //Creator : 02/07/2018 Krit(Copter)
// //Return : Status Add
// //Return Type : n
function JSnAddEditPO(ptRoute) {
    
    $('#ofmAddPO').validate({
        rules: {
            oetXphDocNo         : "required",
            oetXphDocDate       : "required",
            oetXphVatRateInput  : "required",
            oetSplCode          : "required",
        },
        messages: {
            oetXphDocNo         : $('#oetXphDocNo').data('validate'),
            oetXphDocDate       : $('#oetXphDocDate').data('validate'),
            oetXphVatRateInput  : $('#oetXphVatRateInput').data('validate'),
            oetSplCode          : $('#oetSplCode').data('validate')
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
            $( element ).closest('.form-group').addClass( "has-error" ).removeClass( "has-success" );
        },
        unhighlight: function (element, errorClass, validClass) {
            $( element ).closest('.form-group').addClass( "has-success" ).removeClass( "has-error" );
        },
        submitHandler: function(form) {

            $.ajax({
                type: "POST",
                url: ptRoute,
                data: $('#ofmAddPO').serialize(),
                cache: false,
                timeout: 0,
                success: function(tResult) {
                    if (nStaPOBrowseType != 1) {
                        var aReturn = JSON.parse(tResult);
                        if (aReturn['nStaEvent'] == 1) {
                            if (aReturn['nStaCallBack'] == '1' || aReturn['nStaCallBack'] == null) {
                                JSvCallPagePOEdit(aReturn['tCodeReturn'])
                            } else if (aReturn['nStaCallBack'] == '2') {
                                JSvCallPagePOAdd();
                            } else if (aReturn['nStaCallBack'] == '3') {
                                JSvCallPagePOList();
                            }
                        } else {
                            tMsgBody = aReturn['tStaMessg'];
                            FSvCMNSetMsgWarningDialog(tMsgBody)
                        }
                    } else {
                        JCNxBrowseData(tCallPOBackOption);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
            
        }
    });
}


function JSvCallPagePOList() {

    $.ajax({
        type: "GET",
        url: "POFormSearchList",
        data: {},
        cache: false,
        timeout: 5000,
        success: function(tResult) {

            $('#odvContentPagePO').html(tResult);
            JSxPMTNavDefult();

            JSvCallPagePODataTable(); //แสดงข้อมูลใน List
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });

}


function JSvCallPagePODataTable(pnPage) {

    JCNxOpenLoading();

    var tBchCode        = $('#ostBchCode').val();
    var tShpCode        = $('#ostShpCode').val();
    var tXphStaDoc      = $('#ostXphStaDoc').val();
    var dXphDocDateFrom = $('#oetXphDocDateFrom').val();
    var dXphDocDateTo   = $('#oetXphDocDateTo').val();
    
    
    var tSearchAll = $('#oetXphDocNo').val();
    var nPageCurrent = pnPage;
    if (nPageCurrent == undefined || nPageCurrent == '') {
        nPageCurrent = '1';
    }

    $.ajax({
        type: "POST",
        url: "PODataTable",
        data: {            
                tBchCode : tBchCode,
                tShpCode : tShpCode,
                tXphStaDoc : tXphStaDoc,
                dXphDocDateFrom : dXphDocDateFrom,
                dXphDocDateTo : dXphDocDateTo,
                tSearchAll: tSearchAll,
                nPageCurrent: nPageCurrent
            },
        cache: false,
        timeout: 5000,
        success: function(tResult) {
            
            $('#odvContentPurchaseorder').html(tResult);

            JSxPMTNavDefult();
            JCNxLayoutControll();
            JCNxCloseLoading();

        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}


//Functionality : Call Credit Page Edit
//Parameters : -
//Creator : 04/07/2018 Krit(Copter)
//Return : View
//Return Type : View
function JSvCallPagePOEdit(ptXphDocNo){

    JCNxOpenLoading();
    JStCMMGetPanalLangSystemHTML('JSvCallPagePOEdit', ptXphDocNo);

    $.ajax({
        type: "POST",
        url: "POPageEdit",
        data: { ptXphDocNo : ptXphDocNo },
        cache: false,
        timeout: 0,
        success: function(tResult) {

            if (tResult != '') {
                $('#oliPOTitleAdd').hide();
                $('#oliPOTitleEdit').show();
                $('#odvBtnPOInfo').hide();
                $('#odvBtnAddEdit').show();
                $('#odvContentPagePO').html(tResult);
                $('#oetXphDocNo').addClass('xCNDisable');
                $('.xCNDisable').attr('readonly', true);
                $('.xCNiConGen').hide();
                $('#obtPOApprove').show();
                $('#obtPOCancel').show();
            }

            //Control Event Button
            if ($('#ohdPOAutStaEdit').val() == 0) {
                $('.xCNUplodeImage').hide();
                $('.xCNIconBrowse').hide();
                $('.xCNEditRowBtn').hide();
                $("select").prop('disabled', true);
                $('input').attr('disabled', true);
                
            }else{
                $('.xCNUplodeImage').show();
                $('.xCNIconBrowse').show();
                $('.xCNEditRowBtn').show();
                $("select").prop('disabled', false);
                $('input').attr('disabled', false);
            }
             //Control Event Button

             //Function Load Table Pdt ของ PO
            JSvPOLoadPdtDataTableHtml();

             //Put Data 
            ohdXphCshOrCrd = $('#ohdXphCshOrCrd').val();
            $("#ostXphCshOrCrd option[value='" + ohdXphCshOrCrd + "']").attr('selected', true).trigger('change');

            ohdXphVATInOrEx = $('#ohdXphVATInOrEx').val();
            $("#ostXphVATInOrEx option[value='" + ohdXphVATInOrEx + "']").attr('selected', true).trigger('change');

            ohdXphDstPaid = $('#ohdXphDstPaid').val();
            $("#ostXphDstPaid option[value='" + ohdXphDstPaid + "']").attr('selected', true).trigger('change');

            // Control Object And Button ปิด เปิด 
            JCNxPOControlObjAndBtn();

            JCNxLayoutControll();
        
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

//Function : Control Object And Button ปิด เปิด 
function JCNxPOControlObjAndBtn(){

    //Check สถานะอนุมัติ
    ohdXphStaApv = $('#ohdXphStaApv').val();
    ohdXphStaDoc = $('#ohdXphStaDoc').val();

    //Set Default
    //Btn Cancel
    $('#obtPOCancel').attr('disabled',false);
    //Btn Apv
    $('#obtPOApprove').attr('disabled',false);
    $('.form-control').attr('disabled',false);
    $('.ocbListItem').attr('disabled',false);
    $('.xCNBtnBrowseAddOn').attr('disabled',false);
    $('.xCNBtnDateTime').attr('disabled',false);
    $('.xCNDocBrowsePdt').attr('disabled',false).removeClass('xCNBrowsePdtdisabled');
    $('.xCNDocDrpDwn').show();
    $('#oetSearchPdtHTML').attr('disabled',false);
    $('.xWBtnGrpSaveLeft').attr('disabled',false);
    $('.xWBtnGrpSaveRight').attr('disabled',false);
    $('#oliBtnEditShipAdd').show();
    $('#oliBtnEditTaxAdd').show();

    if(ohdXphStaApv == 1 ){
        //Btn Apv
        $('#obtPOApprove').attr('disabled',true);
        //Control input ปิด
        $('.form-control').attr('disabled',true);
        $('.ocbListItem').attr('disabled',true);
        $('.xCNBtnBrowseAddOn').attr('disabled',true);
        $('.xCNBtnDateTime').attr('disabled',true);
        $('.xCNDocBrowsePdt').attr('disabled',true).addClass('xCNBrowsePdtdisabled');
        $('.xCNDocDrpDwn').hide();
        $('#oetSearchPdtHTML').attr('disabled',false);
        $('.xWBtnGrpSaveLeft').attr('disabled',true);
        $('.xWBtnGrpSaveRight').attr('disabled',true);
        $('#oliBtnEditShipAdd').hide();
        $('#oliBtnEditTaxAdd').hide();

    }
    //Check สถานะเอกสาร
    if(ohdXphStaDoc == 3){
        //Btn Cancel
        $('#obtPOCancel').attr('disabled',true);
        //Btn Apv
        $('#obtPOApprove').attr('disabled',true);
        //Control input ปิด
        $('.form-control').attr('disabled',true);
        $('.ocbListItem').attr('disabled',true);
        $('.xCNBtnBrowseAddOn').attr('disabled',true);
        $('.xCNBtnDateTime').attr('disabled',true);
        $('.xCNDocBrowsePdt').attr('disabled',true).addClass('xCNBrowsePdtdisabled');
        $('.xCNDocDrpDwn').hide();
        $('#oetSearchPdtHTML').attr('disabled',false);
        $('.xWBtnGrpSaveLeft').attr('disabled',true);
        $('.xWBtnGrpSaveRight').attr('disabled',true);
        $('#oliBtnEditShipAdd').hide();
        $('#oliBtnEditTaxAdd').hide();
        
    }

}


// //Functionality : (event) Delete
// //Parameters : tIDCode รหัส 
// //Creator : 03/07/2018 Krit(Copter)
// //Return : 
//Return Type : Status Number
function JSnPODel(tCurrentPage,tIDCode) {
    var aData = $('#ohdConfirmIDDelete').val();
    var aTexts = aData.substring(0, aData.length - 2);
    var aDataSplit = aTexts.split(" , ");
    var aDataSplitlength = aDataSplit.length;
    var aNewIdDelete = [];
    if (aDataSplitlength == '1') {
        $('#odvModalDelPO').modal('show');
        $('#ospConfirmDelete').html('ยืนยันการลบข้อมูล หมายเลข : ' + tIDCode);
        $('#osmConfirm').on('click', function(evt) {
            JCNxOpenLoading();
            $.ajax({
                type: "POST",
                url: "POEventDelete",
                data: { 'tIDCode': tIDCode },
                cache: false,
                success: function(tResult) {
                   
                    var aReturn = JSON.parse(tResult);

                    if (aReturn['nStaEvent'] == 1) {
                        $('#odvModalDelPO').modal('hide');
                        $('#ospConfirmDelete').text('ยืนยันการลบข้อมูลของ : ');
                        $('#ohdConfirmIDDelete').val('');
                        localStorage.removeItem('LocalItemData');
                        setTimeout(function() {
                            JSvPOClickPage(tCurrentPage)
                        }, 500);
                    } else {
                        alert(aReturn['tStaMessg']);
                    }
                    JSxPMTNavDefult();
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
// //Creator : 04/07/2018 Krit
// //Return : 
// //Return Type :
function JSnPODelChoose() {
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
            url: "POEventDelete",
            data: { 'tIDCode': aNewIdDelete },
            success: function(tResult) {
                var aReturn = JSON.parse(tResult);
                if (aReturn['nStaEvent'] == 1) {
                    setTimeout(function() {
                        $('#odvModalDelPO').modal('hide');
                        JSvCallPagePODataTable();
                        $('#ospConfirmDelete').text('ยืนยันการลบข้อมูลของ : ');
                        $('#ohdConfirmIDDelete').val('');
                        localStorage.removeItem('LocalItemData');
                        $('.modal-backdrop').remove();
                    }, 1000);
                } else {
                    alert(aReturn['tStaMessg']);
                }
                JSxPMTNavDefult();
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
function JSvPOClickPage(ptPage) {
    var nPageCurrent = '';
    switch (ptPage) {
        case 'next': //กดปุ่ม Next
            $('.xWBtnNext').addClass('disabled');
            nPageOld = $('.xWPagePO .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
            nPageCurrent = nPageNew
            break;
        case 'previous': //กดปุ่ม Previous
            nPageOld = $('.xWPagePO .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
            nPageCurrent = nPageNew
            break;
        default:
            nPageCurrent = ptPage
    }
    JSvCallPagePODataTable(nPageCurrent);
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
function JSxTextinModal() {
    var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
    if (aArrayConvert[0] == null || aArrayConvert[0] == '') {} else {
        var tTextCode = '';
        for ($i = 0; $i < aArrayConvert[0].length; $i++) {
            tTextCode += aArrayConvert[0][$i].nCode;
            tTextCode += ' , ';
        }
        //Disabled ปุ่ม Delete
        if(aArrayConvert[0].length > 1){
            $('.xCNIconDel').addClass('xCNDisabled');
        }else{
            $('.xCNIconDel').removeClass('xCNDisabled');
        }

        $('#ospConfirmDelete').text('ท่านต้องการลบข้อมูลทั้งหมดหรือไม่ ?');
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






//Functionality : Generate Code Subdistrict
//Parameters : Event Icon Click
//Creator : 07/06/2018 wasin
//Return : Data
//Return Type : String
function JStGeneratePOCode() {
    var tTableName = 'TAPTOrdHD';
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

                $('#oetXphDocNo').val(tData.rtXphDocNo);
                $('#oetXphDocNo').addClass('xCNDisable');
                $('.xCNDisable').attr('readonly', true);
                //----------Hidden ปุ่ม Gen
                $('.xCNBtnGenCode').attr('disabled', true);
                $('#oetXphDocNo').focus();
                $('#oetXphDocDate').focus();

                JStCMNCheckDuplicateCodeMaster('oetXphDocNo','JSvCallPagePOEdit','TAPTOrdHD','FTXphDocNo');
            } else {
                $('#oetXphDocNo').val(tData.rtDesc);
            }
            JCNxCloseLoading();
            
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}













// Advance Table
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	//Function : Gen  Html มาแปะ ในหน้า App Po
	function JSvPOLoadPdtDataTableHtml(){

        tXphDocNo   = $('#oetXphDocNo').val();
        tXphStaApv  = $('#ohdXphStaApv').val();
        tXphStaDoc  = $('#ohdXphStaDoc').val();

        $.ajax({
            type: "POST",
            url: "POPdtAdvanceTableLoadData",
            data: {
                tXphDocNo:tXphDocNo,
                tXphStaApv:tXphStaApv,
                tXphStaDoc:tXphStaDoc
            },
            cache: false,
            Timeout: 0,
            success: function(tResult) {

                $('#odvPdtTablePanal').html(tResult);

                //Load HDDis Table Panal และ Modal
                JSvPOCallGetHDDisTableData();
                
                JCNxCloseLoading();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
	
	}
	
	function JSxOpenColumnFormSet(){
	
		$.ajax({
				type: "POST",
				url: "POAdvanceTableShowColList",
				data: {},
				cache: false,
				Timeout: 0,
				success: function(tResult){

					$("#odvShowOrderColumn").modal({ show: true });
					$('#odvOderDetailShowColumn').html(tResult);
					//JSCNAdjustTable();
				},
				error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
		});
   }

	function JSxSaveColumnShow(){

			var aColShowSet = [];
			$(".ocbColStaShow:checked").each(function(){
				aColShowSet.push($(this).data('id'));
			});

			var aColShowAllList = [];
			$(".ocbColStaShow").each(function(){
			aColShowAllList.push($(this).data('id'));
			});


			var aColumnLabelName = [];
			$(".olbColumnLabelName").each(function(){
			aColumnLabelName.push($(this).text());
			});

			//alert(aColShowAllList);

			var nStaSetDef;
			if($('#ocbSetToDef').is(':checked')){
			nStaSetDef = 1;
			}else{
			nStaSetDef = 0;
			}
			//alert(aColShowSet);

			$.ajax({
				type: "POST",
				url: "POAdvanceTableShowColSave",
				data: {aColShowSet:aColShowSet,
						nStaSetDef:nStaSetDef,
						aColShowAllList:aColShowAllList,
						aColumnLabelName:aColumnLabelName
						},
				cache: false,
				Timeout: 0,
				success: function(tResult) {
					$('#odvShowOrderColumn').modal('hide');
					$('.modal-backdrop').remove();
					//Function Gen Table Pdt ของ PO
					JSvPOLoadPdtDataTableHtml();
				},
				error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
			});
    }

    //ปรับ Value ใน Input หลัวจาก กรอก เสร็จ
    function JSxPOAdjInputFormat(ptInputID){

        cVal = $('#'+ptInputID).val();
        cVal = accounting.toFixed(cVal, nOptDecimalShow);
        $('#'+ptInputID).val(cVal);

    }
    

    function JSvPOCallGetHDDisTableData(){

        tXphDocNo 			= $('#oetXphDocNo').val();
        nXphVATInOrEx 		= $('#ostXphVATInOrEx').val();
        nXphRefAEAmt 		= $('#oetXphRefAEAmtInput').val();
        nXphVATRate 		= $('#oetXphVatRateInput').val();
        nXphWpTax 			= $('#oetFCXphWpTaxInput').val();
        
            $.ajax({
            type: "POST",
            url: "POGetHDDisTableData",
            data: { 
                'tXphDocNo'    		: tXphDocNo,
                'nXphVATInOrEx'		: nXphVATInOrEx,
                'nXphRefAEAmt' 		: nXphRefAEAmt,
                'nXphVATRate'  		: nXphVATRate,
                'nXphWpTax'			: nXphWpTax
            },
            cache: false,
            success: function(tResult) {
                
                $('#odvHDDisListPanal').html(tResult);
                
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    
    }