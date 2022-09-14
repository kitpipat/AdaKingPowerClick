var tRptGrpMod          = $('#ohdRptGrpMod').val();
var nStaRptBrowseType   = $('#ohdRptBrowseType').val();
var tCallRptBackOption  = $('#ohdRptBrowseOption').val();
$('ducument').ready(function() {
    localStorage.removeItem('LocalItemData');
    // Check เปิดปิด Menu ตาม Pin
    JSxCheckPinMenuClose();
    if(nStaRptBrowseType != '1'){
        JSvCallPageReportMain();
    }else{
        JSvCallPageReportMain();
    }
});

// Function: Call Page Report All  
// Parameters: Document Redy And Function Call Back Event
// Creator:	12/03/2019 wasin(Yoshi)
// LastUpdate: -
// Return: View
// ReturnType: View
function JSvCallPageReportMain(){
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
        localStorage.tStaPageNow = 'JSvCallPageReportMain';
        // JCNxOpenLoading();
        $('.xCNOverlayReport').show();
        $.ajax({
            type: "POST",
            url: "rptReportMain",
            data: {'ptRptGrpMod' : tRptGrpMod},
            cache: false,
            timeout: 0,
            // async: false,
            success: function(tResult){
                var aReturnData = JSON.parse(tResult);
                if(aReturnData['nStaEvent'] == '1'){
                    $('#odvContentPageRpt').html(aReturnData['tViewReportMain']);
                }else{
                    var tMessageError   = aReturnData['tStaMessg'];
                    FSvCMNSetMsgErrorDialog(tMessageError);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }else{
        JCNxShowMsgSessionExpired();
    }
}

// Function: Call View Report Condition
// Parameters: Document Redy And Function Call Back Event
// Creator:	21/03/2019 wasin(Yoshi)
// LastUpdate: -
// Return: View
// ReturnType: View
function JSvCallPageReportCondition(){
    var aDataCodition = {
        'tRptModCode'   : $('#ohdRptModCode').val(),
        'tRptGrpCode'   : $('#ohdRptGrpCode').val(),
        'tRptCode'      : $('#ohdRptCode').val(),
        'tRptRoute'     : $('#ohdRptRoute').val(),
    };
    // JCNxOpenLoading();
    $('.xCNOverlayReport').show();

    $.ajax({
        type: "POST",
        url: "rptReportCondition",
        data: {'paDataCodition':aDataCodition},
        cache: false,
        timeout: 0,
        // async: false,
        success: function (tResult) {
            var aReturnData = JSON.parse(tResult);
            if(aReturnData['nStaEvent'] == '1'){
                $('#odvConditonSearchRptAll .xCNPDModlue').html(aReturnData['tViewCondition']);
            }else{
                var tMessageError = aReturnData['tStaMessg'];
                FSvCMNSetMsgErrorDialog(tMessageError);
            }
            JCNxLayoutControll();
            $('.xCNOverlayReport').hide();
        },
        error: function (jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

// Function: ฟักชั่น Call Report Data
// Parameters:  Event ปุ่ม ดาวน์โหลด และ ปุ่ม แสดงตัวอย่างรายงาน
// Creator: 01/04/2019 Wasin (Yoshi)
// LastUpdate: 10/04/2019 Wasin(Yoshi)
// Return: Report Response Data (Excel,PDF,View Before Print)
// ReturnType: -
function JSxReportDataExport(){
    var tRptTypeExport  = $('#ohdRptTypeExport').val();
    if (tRptTypeExport !== undefined && tRptTypeExport != ""){
        switch(tRptTypeExport){
            case 'html':
                JCNxCallDataReportHtml();
            break;
            case 'excel':
                JCNxCallDataReportHtml();
                // if(JSbReportDataExportSpout()==true){
                //     JCNxCallDataReportHtml();
                // }else{
                //    JCNxRptSetDataBeforeExport(); // New
                // }
            break;
            case 'pdf':
                FCNxDownloadReportExcel(); // Old
            break;
            
        }
    }
}


// Function: ฟักชั่น Call Report Data
// Parameters:  
// Creator: 30/07/2020 Nattakit (nale)
// LastUpdate: 
// Return: true : 
// ReturnType: boolean
function JSbReportDataExportSpout() {
    var aRptCode = [ //รหัสรายงานที่จะออก  Spout Excel
        '001001001',
        '001001002',
        '001001003',
        '001001004',
        '001001005',
        '001001006',
        '001001007',
        '001001014',
        '001001016',
        '001001025',
        '006001001',
        '006001002',
        '001001028',
        '001001029',
        '001003013',
        '001002001',
        '001002002',
        '001002006',
        '002002001',
        '004001012',
        '001001030',
        '001001031',
        '001001026',
        '001001027',
        '001003014',
        '004001016',  // รายงาน - การแลก/คืน บัตรเงินสด 
        '004001017'   // รายงาน - รายได้เนื่องจากการไม่คืนบัตร
    ];
    for ( let i = 0; i < aRptCode.length; i++) {
        if (aRptCode[i] == $('.active >td').data('rptcode')) {
            return true;
        }
      }
}

// Function: ฟักชั่น Call Report Data
// Parameters:  Event ปุ่ม ดาวน์โหลด และ ปุ่ม แสดงตัวอย่างรายงาน
// Creator: 01/04/2019 Wasin (Yoshi)
// LastUpdate: 10/04/2019 Wasin(Yoshi)
// Return: Report Response Data (Excel,PDF,View Before Print)
// ReturnType: -
function JCNxCallDataReportHtml(){
    var tRouteRpt = $('#ohdRptRoute').val();
    $('#ofmRptConditionFilter').attr('action',tRouteRpt).attr('target','_blank').attr('method','post');
    $('#ofmRptConditionFilter').submit();
    $('#ofmRptConditionFilter').attr('action','javascript:void(0)').removeAttr('target').removeAttr('method');
}

// Function: ฟังก์ชั่น Count DataReport And Calcurate Page
// Parameters:  Event ปุ่ม ดาวน์โหลด และ ปุ่ม แสดงตัวอย่างรายงาน
// Creator: 01/04/2019 Wasin (Yoshi)
// LastUpdate: -
// Return: -
// ReturnType: -
function FCNxDownloadReportExcel(){
    JCNxOpenLoading();
    var tRouteRpt   = $('#ohdRptRoute').val();
    $.ajax({
        type: "POST",
        url: tRouteRpt,
        data: $('#ofmRptConditionFilter').serialize(),
        cache: false,
        timeout: 0,
        success: function (tResult){
            var aDataRptReturn = JSON.parse(tResult);
            if(aDataRptReturn['nStaExport'] == 1){
                var tFileName   = aDataRptReturn['tFileName'];
                var tPathFolder = aDataRptReturn['tPathFolder'];
                // Append Bottom Download
                var oObjectBtnExport    = $("<a>");
                oObjectBtnExport.attr("href", tPathFolder + tFileName);
                $("#odvRptAppendBtnDownload").append(oObjectBtnExport);
                oObjectBtnExport.attr("download",tFileName);
                oObjectBtnExport[0].click();
                oObjectBtnExport.remove();
            }else{
                var tMessageError = aDataRptReturn['tMessage'];
                FSvCMNSetMsgErrorDialog(tMessageError);
            }
            JCNxCloseLoading();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

// ==================================================================================== Export Excel New ====================================================================================

// Function: ฟังก์ชั่น Calcurate Number And Decimal
// Parameters: Event ปุ่ม ดาวน์โหลด และ ปุ่ม แสดงตัวอย่างรายงาน
// Creator: 20/08/2019 Wasin (Yoshi)
// Last Update: -
// Return: -
// ReturnType: None
function JCNnConvertToFixed(nNum,nDec){
    if(typeof(nDec) != 'undefined' && nDec != null){
        var nDecimals   = nDec;
    }else{
        var nDecimals   = 2;
    }
    nNum *= Math.pow(10,nDecimals);
    nNum = (Math.round(nNum,nDecimals) + (((nNum - Math.round(nNum,nDecimals))>= 0.4)?1:0)) / Math.pow(10,nDecimals);
    return nNum.toFixed(nDecimals);
}

// Function: ฟังก์ชั่น Set Data In Modal Report Export Progress
// Parameters: Event ปุ่ม ดาวน์โหลด และ ปุ่ม แสดงตัวอย่างรายงาน
// Creator: 18/08/2019 Wasin (Yoshi)
// Last Update: -
// Return: -
// ReturnType: None
function JCNxRptSetMsgDataModalPrograss(poRptDataConfig){
    // Set Title Menu Report
    $('#odvModalReportPrograssExport .modal-header span#ospRptHeader').html(poRptDataConfig.tRptTitleModalProgress);

    // Set Check Open Button Dowlond
    if(typeof poRptDataConfig.nResStaZip == "undefined" || poRptDataConfig.nResStaZip == '0'){
        $('#odvModalReportPrograssExport .modal-footer button#obtRptPgDownload').prop("disabled",true);
    }else{
        $('#odvModalReportPrograssExport .modal-footer button#obtRptPgDownload').prop("disabled",false);
    }
    
    // Set Progerss Report
    if (typeof poRptDataConfig.nRptProgress == "undefined" || poRptDataConfig.nRptProgress == null) {
        $('#odvModalReportPrograssExport .modal-body #odvRptLodingBarProgress').hide();
        $('#odvModalReportPrograssExport .modal-body .xCNMessage').html(poRptDataConfig.tRptMsgBody);
        $('#odvModalReportPrograssExport').modal({ backdrop: 'static', keyboard: false });
        $('#odvModalReportPrograssExport').modal({ show: true });
    }else{
        $('#odvModalReportPrograssExport .modal-body #odvRptLodingBarProgress').show();
        $('#odvModalReportPrograssExport .modal-body .xCNMessage').html(poRptDataConfig.tRptMsgBody);
        $('#odvModalReportPrograssExport').modal({ backdrop: 'static', keyboard: false });
        $('#odvModalReportPrograssExport').modal({ show: true });
    }

    //setTimeout(function(){
        //progress แบบเดิม
        // var oBarRptLoading      = new ldBar("#odvRptLodingBarProgress");
        // if(poRptDataConfig.nRptProgress == 0 || poRptDataConfig.nRptProgress == null){
        //     pnProgress = 10;
        // }else{
        //     pnProgress = poRptDataConfig.nRptProgress;
        // }
        // var nConvertSetVakue    = parseInt(pnProgress);
        // oBarRptLoading.set(nConvertSetVakue);

        //progress แบบใหม่
        var oBarRptLoading      = new ldBar("#odvRptLodingBarProgress");
        if(poRptDataConfig.cProgress == 0 || poRptDataConfig.cProgress == null){
            pnProgress = 5;
        }else{
            pnProgress = poRptDataConfig.cProgress;
        }
        var nConvertSetVakue    = parseInt(pnProgress);
        oBarRptLoading.set(nConvertSetVakue);
    //},1000);
}

// Function: ฟังก์ชั่น SubScribe And Show Modal Progress
// Parameters: Event ปุ่ม ดาวน์โหลด และ ปุ่ม แสดงตัวอย่างรายงาน
// Creator: 19/08/2019 Wasin (Yoshi)
// Last Update: -
// Return: -
// ReturnType: None
function JCNxRptRabbitMQMessage(ptQueueNameSubscribe,poRptParams,poRptMqConfig){
    // *** Text Lang Report Modal Progress
    var tRptTitleModalProgress      = $('#ohdRptTitleModalProgress').val();
    var tRptRederExcelFile          = $('#ohdRptRederExcelFile').val();
    var tRptProcessZipFile          = $('#ohdRptProcessZipFile').val();
    var tRptProcessExportSuccess    = $('#ohdRptProcessExportSuccess').val();

    // Set Valiable Default Modal Progress
    var nRptStaZip              = poRptParams['FTStaZip'];
    var tRptSuccessFile         = parseFloat(poRptParams['FNSuccessFile']);
    var tRptTotalFile           = parseFloat(poRptParams['FNTotalFile']);
    var nRptProgressStart       = 0;
    if(tRptSuccessFile != '0' && tRptTotalFile != '0'){
        nRptProgressStart   = (tRptSuccessFile/tRptTotalFile)*100;
    }
    
    // Text String Data Success Or Total File
    var tTextMsgNewProcess      = tRptRederExcelFile+' '+tRptSuccessFile+'/'+tRptTotalFile;
    
    // Call Function Show Modal Progress
    var oRptDataConfig      = {
        'tRptTitleModalProgress'    : tRptTitleModalProgress,
        'tRptMsgBody'               : tTextMsgNewProcess,
        'nRptProgress'              : JCNnConvertToFixed(nRptProgressStart,0),
        'cProgress'                 : 5,
        'nResStaZip'                : nRptStaZip
    }

    JCNxRptSetMsgDataModalPrograss(oRptDataConfig);

    // Listening rabbit mq server
    var oClient     = Stomp.client(poRptMqConfig.host);

    var on_connect  = function (x) {
        oClient.subscribe(ptQueueNameSubscribe,function(oRespone) {
            try{
                var tDataResponeMQ  = oRespone.body;
                var tDataResponeMQ  = jQuery.parseJSON(tDataResponeMQ);
                var aDataResponeMQ  = JSON.parse(tDataResponeMQ);

                // Set Valiabel
                let tResRptCode         = aDataResponeMQ.ptRptCode;
                let tResUserCode        = aDataResponeMQ.ptUserCode;
                let nResTotalFile       = aDataResponeMQ.pnTotalFile;
                let nResSuccessFile     = aDataResponeMQ.pnSuccessFile;
                let nResStaZip          = aDataResponeMQ.pnStaZip;
                let nResStaExpFail      = aDataResponeMQ.pnStaExpFail;
                let nCaluratePercent    = ((nResSuccessFile/nResTotalFile)*100);
                var tResTextMsgProcess  = tRptRederExcelFile+' '+nResSuccessFile+'/'+nResTotalFile;
                
                //Check Error
                if(nResStaExpFail == 0){
                    if(nResSuccessFile == nResTotalFile && nResStaZip == '0'){
                        // ********************* Event Process Zip File (ทำการบีบอัดข้อมูลไฟล์) *********************
                        var oRptDataConfig      = {
                            'tRptTitleModalProgress'    : tRptTitleModalProgress,
                            'tRptMsgBody'               : tRptProcessZipFile,
                            'nRptProgress'              : nCaluratePercent,
                            'cProgress'                 : aDataResponeMQ.pcProgress,
                            'nResStaZip'                : nResStaZip
                        }
                        JCNxRptSetMsgDataModalPrograss(oRptDataConfig);
                        // Skip Report Prograss Export
                        $('#odvModalReportPrograssExport #obtRptPgSkipDownload').unbind();
                        $('#odvModalReportPrograssExport #obtRptPgSkipDownload').click(function(){
                            oClient.disconnect();
                            $('#odvModalReportPrograssExport').modal('hide');
                            $('.modal-backdrop').remove();
                        });
                        
                        // Download File Report
                        $('#odvModalReportPrograssExport #obtRptPgDownload').unbind();
                    }else if(nResSuccessFile == nResTotalFile && nResStaZip == '1'){
                        // ********************* Event Process Export File Success (ส่งออกข้อมูลไฟล์) *********************
                        var oRptDataConfig      = {
                            'tRptTitleModalProgress'    : tRptTitleModalProgress,
                            'tRptMsgBody'               : tRptProcessExportSuccess,
                            'nRptProgress'              : nCaluratePercent,
                            'cProgress'                 : aDataResponeMQ.pcProgress,
                            'nResStaZip'                : nResStaZip
                        }
                        JCNxRptSetMsgDataModalPrograss(oRptDataConfig);
    
                        // Skip Report Prograss Export
                        $('#odvModalReportPrograssExport #obtRptPgSkipDownload').unbind();
                        $('#odvModalReportPrograssExport #obtRptPgSkipDownload').click(function(){
                            oClient.disconnect();
                            $('#odvModalReportPrograssExport').modal('hide');
                            $('.modal-backdrop').remove();
                            $("#ofmRptConditionFilter #odvBtnRptProcessGrp button").removeClass('xCNDisabled').prop('disabled',false);
                        });
    
                        // Download File Report
                        $('#odvModalReportPrograssExport #obtRptPgDownload').unbind();
                        $('#odvModalReportPrograssExport #obtRptPgDownload').click(function(){
                            oClient.disconnect();
                            JCNxOpenLoading();
                            var aDataRpt            = {
                                'ptRptCode' : tResRptCode,
                                'ptUsrCode' : tResUserCode
                            };
                            $.ajax({
                                type: "POST",
                                url: 'rptReportConfirmDownloadFile',
                                data: {'paDataRpt' : aDataRpt},
                                cache: false,
                                success: function (tResult){
                                    var aDataRptReturn  = JSON.parse(tResult);
                                    var tMessage        = aDataRptReturn['tMessage'];
                                    switch(aDataRptReturn['nStaExport']){
                                        case 1:
                                            // Append Bottom Download
                                            var oObjectBtnExport    = $("<a>");
                                            oObjectBtnExport.attr("download",aDataRptReturn['tRptZipName']);
                                            oObjectBtnExport.attr("href",aDataRptReturn['tRptZipPath']);
                                            $("#odvRptAppendBtnDownload").append(oObjectBtnExport);
                                            oObjectBtnExport[0].click();
                                            oObjectBtnExport.remove();
                                            setTimeout(function(){
                                                // Remove Disable Button In Condition Filter
                                                $("#ofmRptConditionFilter #odvBtnRptProcessGrp button").removeClass('xCNDisabled').prop('disabled',false);
                                                $('#odvModalReportPrograssExport').modal('hide');
                                                $('.modal-backdrop').remove();
                                            },1000);
                                        break;
                                        case 800:
                                            FSvCMNSetMsgWarningDialog(tMessage);
                                        break;
                                        case 500:
                                            FSvCMNSetMsgErrorDialog(tMessage);
                                        break;
                                    }
                                    JCNxCloseLoading();
                                },
                                error: function(jqXHR, textStatus, errorThrown) {
                                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                                }
                            })
                        });
                    }else{
                        // ********************* Event Process Export File In Process (อยู๋ในกระบบนการ In Process) *********************
                        var oRptDataConfig      = {
                            'tRptTitleModalProgress'    : tRptTitleModalProgress,
                            'tRptMsgBody'               : tResTextMsgProcess,
                            'nRptProgress'              : nCaluratePercent,
                            'cProgress'                 : aDataResponeMQ.pcProgress,
                            'nResStaZip'                : nResStaZip
                        }
                        JCNxRptSetMsgDataModalPrograss(oRptDataConfig);
                        // Skip Report Prograss Export
                        $('#odvModalReportPrograssExport #obtRptPgSkipDownload').unbind();
                        $('#odvModalReportPrograssExport #obtRptPgSkipDownload').click(function(){
                            oClient.disconnect();
                            $('#odvModalReportPrograssExport').modal('hide');
                            $('.modal-backdrop').remove();
                        });
    
                        // Download File Report
                        $('#odvModalReportPrograssExport #obtRptPgDownload').unbind();
                    }
                }else{
                    var tRptMsgErrorZipFile = $('#ohdRptTextErrorZipFile').val();
                    FSvCMNSetMsgErrorDialog(tRptMsgErrorZipFile);
                }
            }catch (Err) {
                JCNxResponseError("Listening rabbit mq Export server: ", Err);
            }
        });
    };
    var on_error = function () {
        JCNxResponseError('Error Process Subscribe Report Export.');
    };

    // Skip Report Prograss Export
    $('#odvModalReportPrograssExport #obtRptPgSkipDownload').unbind();
    $('#odvModalReportPrograssExport #obtRptPgSkipDownload').click(function(){
        oClient.disconnect();
        $('#odvModalReportPrograssExport').modal('hide');
        $('.modal-backdrop').remove();
    });

    // Download File Report
    $('#odvModalReportPrograssExport #obtRptPgDownload').unbind();
    oClient.connect(poRptMqConfig.username, poRptMqConfig.password, on_connect, on_error, poRptMqConfig.vHost);
}

// Function: ฟังก์ชั่นเช็คข้อมูลในตาราง TSysHisExport
// Parameters:  Event ปุ่ม ดาวน์โหลด และ ปุ่ม แสดงตัวอย่างรายงาน
// Creator: 15/08/2019 Wasin (Yoshi)
// Last Update: -
// Return: -
// ReturnType: None
function JCNxRptChkDataInHisExport(){
    JCNxOpenLoading();
    $.ajax({
        type: "POST",
        url: 'rptReportChkDataInTSysHisExport',
        data: $('#ofmRptConditionFilter').serialize(),
        cache: false,
        timeout:0,
        success: function (tResult){
            var aDataReturn = JSON.parse(tResult);
            if(aDataReturn['nStaEvent'] == 1){
                JCNxCloseLoading();
            }else{
                var tMessageError = aDataReturn['tStaMessg'];
                FSvCMNSetMsgErrorDialog(tMessageError);
                JCNxCloseLoading();
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

// Function ฟังก์ชั่น Comfrim Download File
// Parameters: Event Click Button Confirm Download File
// Creator: 19/08/2019 Wasin (Yoshi)
// Last Update: Download File Export
// Return: -
// ReturnType: -
function JCNxRptComfirmDownloadFile(ptModalEvnActiveName,paDataRpt){
    JCNxOpenLoading();
    $.ajax({
        type: "POST",
        url: 'rptReportConfirmDownloadFile',
        data: {'paDataRpt' : paDataRpt},
        cache: false,
        success: function (tResult){
            let aDataRptReturn  = JSON.parse(tResult);
            let tMessage        = aDataRptReturn['tMessage'];
            switch(aDataRptReturn['nStaExport']){
                case 1:
                    // Append Bottom Download
                    var oObjectBtnExport    = $("<a>");
                    oObjectBtnExport.attr("download",aDataRptReturn['tRptZipName']);
                    oObjectBtnExport.attr("href",aDataRptReturn['tRptZipPath']);
                    $("#odvRptAppendBtnDownload").append(oObjectBtnExport);
                    oObjectBtnExport[0].click();
                    oObjectBtnExport.remove();
                    setTimeout(function(){
                        $('#'+ptModalEvnActiveName).modal('hide');
                        $('.modal-backdrop').remove();
                    },1000);
                break;
                case 800:
                    FSvCMNSetMsgWarningDialog(tMessage);
                break;
                case 500:
                    FSvCMNSetMsgErrorDialog(tMessage);
                break;
            }
            JCNxCloseLoading();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

// Function: ฟังก์ชั่น Cancle Download File
// Parameters: Event Click Cancel Download File
// Creator: 15/08/2019 Wasin (Yoshi)
// Last Update: -
// Return: -
// ReturnType: None
function JCNxRptCancelDownloadFile(paDataRpt){
    JCNxOpenLoading();
    $.ajax({
        type: "POST",
        url: 'rptReportCancelDownloadFile',
        data: {
            'paDataRpt' : paDataRpt
        },
        cache: false,
        timeout:0,
        success: function (tResult){
            var aDataReturn = JSON.parse(tResult);
            if(aDataReturn['nStaEvent'] == 1){
                $('#odvModalReportRedownload').modal('hide');
                $('body').removeClass('modal-open');
                $('.modal-backdrop').remove();
            }else{
                var tMessageError = aDataReturn['tStaMessg'];
                FSvCMNSetMsgErrorDialog(tMessageError);
            }
            JCNxCloseLoading();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

// Function: ฟังก์ชั่น Count DataReport And Calcurate Page
// Parameters:  Event ปุ่ม ดาวน์โหลด และ ปุ่ม แสดงตัวอย่างรายงาน
// Creator: 01/04/2019 Wasin (Yoshi)
// LastUpdate: -
// Return: -
// ReturnType: -
function JCNxRptSetDataBeforeExport(){
    JCNxOpenLoading();
    var tRouteRpt   =   $('#ohdRptRoute').val();
    $.ajax({
        type: "POST",
        url: tRouteRpt,
        data: $('#ofmRptConditionFilter').serialize(),
        cache: false,
        timeout:0,
        success: function (tResult){
            let aDataReturn     = JSON.parse(tResult);
            let tMessageError   = aDataReturn['tMessage'];
            if(aDataReturn['nStaEvent'] == 1){
                let nCountDataAllRpt    = aDataReturn['nCountPageAll'];
                if(nCountDataAllRpt > 0){
                    JCNxSendReportRabbitMQExport();
                }else{
                    let tMsgNotFoundData    = $("#ohdRptNotFoundDataInDBTemp").val();
                    FSvCMNSetMsgWarningDialog(tMsgNotFoundData);
                    JCNxCloseLoading();
                }
            }else{
                FSvCMNSetMsgErrorDialog(tMessageError);
                JCNxCloseLoading();
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

// Function: ฟังก์ชั่น Send Rabbit MQ Export Report
// Parameters:  Event ปุ่ม ดาวน์โหลด และ ปุ่ม แสดงตัวอย่างรายงาน
// Creator: 16/08/2019 Wasin (Yoshi)
// LastUpdate: -
// Return: -
// ReturnType: -
function JCNxSendReportRabbitMQExport(){
    JCNxOpenLoading();
    var tRouteRpt   = $('#ohdRptRoute').val();
    $.ajax({
        type: "POST",
        url: tRouteRpt+'CallExportFile',
        data: $('#ofmRptConditionFilter').serialize(),
        cache: false,
        timeout:0,
        success: function (tResult){
            let aDataReturn     = JSON.parse(tResult);
            let nStaEvent       = aDataReturn['nStaEvent'];
            let tMessageError   = aDataReturn['tMessage'];
            if(nStaEvent == 1){
                let aDataSubscribe  = aDataReturn['aDataSubscribe'];
                JCNxRptSubscribeExport(aDataSubscribe);
                JCNxCloseLoading();    
            }else{
                FSvCMNSetMsgErrorDialog(tMessageError);
                JCNxCloseLoading();    
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

// Function: ฟังก์ชั่น SubScript Reprot Export
// Parameters:   Fnc.(JCNxRptChkConditionExport,JCNxSendReportRabbitMQExport)
// Creator: 16/08/2019 Wasin (Yoshi)
// LastUpdate: -
// Return: -
// ReturnType: -
function JCNxRptSubscribeExport(paDataSubscribe){
    // Disable Button In Condition Filter
    $("#ofmRptConditionFilter #odvBtnRptProcessGrp button").addClass('xCNDisabled').prop('disabled',true);

    /** ========= Set Report Variable Parameter =========
     * Exc: RESRPT_reportCode_userCode_userSession_date(Ymd)_time(His)
    */
    let tSysBchCode     = paDataSubscribe['ptSysBchCode'];
    let tRptCompName    = paDataSubscribe['ptComName'];
    let tRptCode        = paDataSubscribe['ptRptCode'];
    let tUserCode       = paDataSubscribe['ptUserCode'];
    let tUserSessionID  = paDataSubscribe['ptUserSessionID'];
    let dDateSubscribe  = paDataSubscribe['pdDateSubscribe'];
    let dTimeSubscribe  = paDataSubscribe['pdTimeSubscribe'];

    let tQueueNameSubscribe = 'RESRPT_'+tSysBchCode+'_'+tRptCode+'_'+tUserCode+'_'+tUserSessionID+'_'+dDateSubscribe+'_'+dTimeSubscribe;
    
    let oRptMqConfig   = {
        host: "ws://" + oRPTSTOMMQConfig.host + ":15674/ws",
        username: oRPTSTOMMQConfig.user,
        password: oRPTSTOMMQConfig.password,
        vHost: oRPTSTOMMQConfig.vhost
    };

    let oRptParams      = {
        'FTComName'             : tRptCompName,
        'FTUsrCode'             : tUserCode,
        'FTUsrSession'          : tUserSessionID,
        'FTRptCode'             : tRptCode,
        'FDDateSubscribe'       : dDateSubscribe,
        'FDTimeSubscribe'       : dTimeSubscribe,
        'FNSuccessFile'         : 0,
        'FNTotalFile'           : 0,
        'FTStaDownload'         : 0,
        'FTStaZip'              : 0,
        'FTStaCancelDownload'   : 0,
    }
    var oBarRptLoading      = new ldBar("#odvRptLodingBarProgress");
    var nConvertSetVakue    = 0;
    oBarRptLoading.set(nConvertSetVakue);
    setTimeout(function(){
        JCNxRptRabbitMQMessage(tQueueNameSubscribe,oRptParams,oRptMqConfig);
    },1000);
}

// ==================================================================================== End Export Excel New ====================================================================================

// ================================================================================ Function Multi Select Filter ================================================================================
// Function: ฟังก์ชั่น SubScript Reprot Export
// Parameters:   Fnc.(JCNxRptChkConditionExport,JCNxSendReportRabbitMQExport)
// Creator: 16/08/2019 Wasin (Yoshi)
// LastUpdate: -
// Return: -
// ReturnType: -
function JCNxRptBrowseMultiSelectFilter(poOptions){
    $.ajax({
        type: "POST",
        url: 'rptReportConditionMultiSelect',
        cache: false,
        data: {'paOptions' : poOptions},
        success: function(ptResponse){
            let aDataReturn     = JSON.parse(ptResponse);
            let tDiveAppendHtml = aDataReturn['aDataOptionBrowse']['tDivAppend'];
            $('#'+tDiveAppendHtml).html(aDataReturn['tHtmlMultiSelect']);
        },
        error: function(jqXHR, textStatus, errorThrown){
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}



// ============================================================================== End Function Multi Select Filter ==============================================================================
















