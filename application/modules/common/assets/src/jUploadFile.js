//System : AdaPos5.0 Upload File JavaScript Function Center
//Job : Upload File Other Center 
//Create : 10-06-2021 
//By : Nattakit K.
//PreFixFunct : JCNxUPF
//poParam : ptElementID , ptBchCode , ptDocNo , ptDocKey , ptSessionID , pnEvent (1:add , 2:edit)
function JCNxUPFCallDataTable(poParam){

    let tElementID  = poParam.ptElementID;
    let tBchCode    = poParam.ptBchCode;
    let tDocNo      = poParam.ptDocNo;
    let tDocKey    = poParam.ptDocKey;
    let tSessionID = poParam.ptSessionID;
    let nEvent     = poParam.pnEvent;
    let tCallBackFunct  = poParam.ptCallBackFunct;

    $.ajax({
        type		: "POST",
        url			: "UPFDataTable",
        data		: {  
                         'tElementID' : tElementID,
                         'tBchCode'   : tBchCode , 
                         'tDocNo'     : tDocNo ,
                         'tDocKey'    : tDocKey,
                         'tSessionID' : tSessionID,
                         'nEvent'     : nEvent,
                         'tCallBackFunct' : tCallBackFunct
                      },
        async       : false,
        success	: function (aResult) {
            $('#'+tElementID).html(aResult);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            $('#'+tElementID).html('error config');
        }
    });
}


//System : AdaPos5.0 Upload File JavaScript Function Center
//Job : Upload File Other Center 
//Create : 10-06-2021 
//By : Nattakit K.
//PreFixFunct : JCNxUPF
//poParam : ptElementID , ptBchCode , ptDocNo , ptDocKey , ptSessionID , pnEvent (1:add , 2:edit)
function JCNxUPFCallDataTableForNew(poParam){

    let tElementID  = poParam.ptElementID;
    let tBchCode    = poParam.ptBchCode;
    let tDocNo      = poParam.ptDocNo;
    let tDocKey    = poParam.ptDocKey;
    let tSessionID = poParam.ptSessionID;
    let nEvent     = poParam.pnEvent;
    let tCallBackFunct  = poParam.ptCallBackFunct;

    $.ajax({
        type		: "POST",
        url			: "UPFDataTableForNew",
        data		: {  
                         'tElementID' : tElementID,
                         'tBchCode'   : tBchCode , 
                         'tDocNo'     : tDocNo ,
                         'tDocKey'    : tDocKey,
                         'tSessionID' : tSessionID,
                         'nEvent'     : nEvent,
                         'tCallBackFunct' : tCallBackFunct
                      },
        async       : false,
        success	: function (aResult) {
            $('#'+tElementID).html(aResult);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            $('#'+tElementID).html('error config');
        }
    });
}

function JCNxUPFAddData(ptDocKeyElement){
    // JCNxOpenLoading();
    var tUPFViewBchCode = $("#ohdUPFViewBchCode"+ptDocKeyElement).val();
    var tUPFViewDocNo = $("#ohdUPFViewDocNo"+ptDocKeyElement).val();
    var tUPFViewDocKey = $("#ohdUPFViewDocKey"+ptDocKeyElement).val();
    var tUPFViewSessionID = $("#ohdUPFViewSessionID"+ptDocKeyElement).val();
    var tUPFViewtElementID = $("#ohdUPFViewtElementID"+ptDocKeyElement).val();
    var tUPFViewCallBackFunct = $("#ohdUPFViewCallBackFunct"+ptDocKeyElement).val();
    
    let oBjectFile = {
        ptElementID:tUPFViewtElementID,  
        ptBchCode:tUPFViewBchCode,
        ptDocNo:tUPFViewDocNo,
        ptDocKey:tUPFViewDocKey,
        ptSessionID:tUPFViewSessionID,
        ptCallBackFunct:tUPFViewCallBackFunct,
        pnEvent:3
    }

    var nI = $('.xFileUpload'+ptDocKeyElement).last().data('seqfile');
    var tUPFElementAttr = 'oflUPFData'+ptDocKeyElement+"_"+nI;
    // alert(tUPFElementAttr);
    // 100000000 (byte)  =  100 mb
    var tFileNameFull = document.getElementById(tUPFElementAttr).files[0].name;
    var nFileSize = document.getElementById(tUPFElementAttr).files[0].size;
    var tFileType = document.getElementById(tUPFElementAttr).files[0].type;
    var file_info = tFileNameFull+"\n"+nFileSize+"\n"+tFileType;
    console.log(file_info);
    if(tFileNameFull.length>30){
        var tFileName = tFileNameFull.slice(0, 30)+"...";
    }else{
        var tFileName = tFileNameFull;
    }
    let tFunctionDeleteDataElement = 'JCNxUPFDeleteDataElement("'+nI+'","'+ptDocKeyElement+'")';
    let tMarkUpTr = "";
    tMarkUpTr += "<tr style='border-bottom-color: white;' class='xUPFTdHilight xUPFTrPadding5 xTableDnD"+ptDocKeyElement+"' id='otrKeyFile"+ptDocKeyElement+"_"+nI+"' data-fleseq='"+nI+"' >";
    tMarkUpTr += "<td width='90%' style='border-right-color: #cccccc3d;'>&nbsp;<label title='"+tFileNameFull+"'>"+tFileName+"</label></td>";
    tMarkUpTr += "<td width='10%'> <label class='xUPFDeleteFile' onclick='"+tFunctionDeleteDataElement+"'><b>x</b></label></td>";
    tMarkUpTr += "</tr>";
    
    var nINew =  nI+1;
    let tFunctionAddData = 'JCNxUPFAddData("'+ptDocKeyElement+'")';
    let tMarkUpInput = "<input type='file' name='oflUPFData"+ptDocKeyElement+"[]' id='oflUPFData"+ptDocKeyElement+"_"+nINew+"'  class='inputfile xFileUpload"+ptDocKeyElement+"' data-seqfile='"+nINew+"' onchange='"+tFunctionAddData+"' ></input>";
    
    if(nFileSize<=100000000){
    $('#otbUPFTableDnD'+ptDocKeyElement).append(tMarkUpTr);
    $('.xFileInputPosition'+ptDocKeyElement).append(tMarkUpInput);

    JCNxUPFSetInputUpload(ptDocKeyElement);

    }else{
        FSvCMNSetMsgWarningDialog('<p class="text-left"> ไม่สามารถอัพโหลดไฟล์ได้เนื่องจาก ไฟล์มีขนาดใหญ่เกินกำหนด <br/> *ขนาดไฟล์ต้องไม่เกิน 100MB </p>');
    }
    JCNxUPFSetNotFonud(ptDocKeyElement);
}


function JCNxUPFAddDataForNew(ptDocKeyElement){
    // JCNxOpenLoading();
    var tUPFViewBchCode = $("#ohdUPFViewBchCode"+ptDocKeyElement).val();
    var tUPFViewDocNo = $("#ohdUPFViewDocNo"+ptDocKeyElement).val();
    var tUPFViewDocKey = $("#ohdUPFViewDocKey"+ptDocKeyElement).val();
    var tUPFViewSessionID = $("#ohdUPFViewSessionID"+ptDocKeyElement).val();
    var tUPFViewtElementID = $("#ohdUPFViewtElementID"+ptDocKeyElement).val();
    var tUPFViewCallBackFunct = $("#ohdUPFViewCallBackFunct"+ptDocKeyElement).val();
    
    let oBjectFile = {
        ptElementID:tUPFViewtElementID,  
        ptBchCode:tUPFViewBchCode,
        ptDocNo:tUPFViewDocNo,
        ptDocKey:tUPFViewDocKey,
        ptSessionID:tUPFViewSessionID,
        ptCallBackFunct:tUPFViewCallBackFunct,
        pnEvent:3
    }

    var nI = $('.xFileUpload'+ptDocKeyElement).last().data('seqfile');
    var tUPFElementAttr = 'oflUPFData'+ptDocKeyElement+"_"+nI;
    // alert(tUPFElementAttr);
    // 100000000 (byte)  =  100 mb
    var tFileNameFull = document.getElementById(tUPFElementAttr).files[0].name;
    var nFileSize = document.getElementById(tUPFElementAttr).files[0].size;
    var tFileType = document.getElementById(tUPFElementAttr).files[0].type;
    var file_info = tFileNameFull+"\n"+nFileSize+"\n"+tFileType;
    console.log(file_info);
    if(tFileNameFull.length>30){
        var tFileName = tFileNameFull.slice(0, 30)+"...";
    }else{
        var tFileName = tFileNameFull;
    }
    let tFunctionDeleteDataElement = 'JCNxUPFDeleteDataElement("'+nI+'","'+ptDocKeyElement+'")';
    let tMarkUpTr = "";
    tMarkUpTr += "<span class='label label-info m-r-5 xTableDnD"+ptDocKeyElement+"' id='otrKeyFile"+ptDocKeyElement+"_"+nI+"' data-fleseq='"+nI+"' >";
    tMarkUpTr += "<label class='xUPFDeleteFile' onclick='"+tFunctionDeleteDataElement+"'><b>x</b></label>";
    tMarkUpTr += "&nbsp;&nbsp;<label title='"+tFileNameFull+"'>"+tFileName+"</label>";
    tMarkUpTr += "</span>";

    var nINew =  nI+1;
    let tFunctionAddData = 'JCNxUPFAddDataForNew("'+ptDocKeyElement+'")';
    let tMarkUpInput = "<input type='file' name='oflUPFData"+ptDocKeyElement+"[]' id='oflUPFData"+ptDocKeyElement+"_"+nINew+"'  class='inputfile xFileUpload"+ptDocKeyElement+"' data-seqfile='"+nINew+"' onchange='"+tFunctionAddData+"' ></input>";
    
    if(nFileSize<=100000000){
    $('#otbUPFTableDnD'+ptDocKeyElement).append(tMarkUpTr);
    $('.xFileInputPosition'+ptDocKeyElement).append(tMarkUpInput);

    JCNxUPFSetInputUpload(ptDocKeyElement);

    }else{
        FSvCMNSetMsgWarningDialog('<p class="text-left"> ไม่สามารถอัพโหลดไฟล์ได้เนื่องจาก ไฟล์มีขนาดใหญ่เกินกำหนด <br/> *ขนาดไฟล์ต้องไม่เกิน 100MB </p>');
    }
    JCNxUPFSetNotFonud(ptDocKeyElement);
}


function JCNxUPFSetNotFonud(ptDocKeyElement){
    var nI = $('.xTableDnD'+ptDocKeyElement).length;
    if(nI>0){
         $('.xNotFoundDataFile'+ptDocKeyElement).hide();
    }else{
        $('.xNotFoundDataFile'+ptDocKeyElement).show();
    }
}


function JCNxUPFInsertDataFile(poParam){

    let tElementID  = poParam.ptElementID;
    let tBchCode    = poParam.ptBchCode;
    let tDocNo      = poParam.ptDocNo;
    let tDocKey    = poParam.ptDocKey;
    let ptDocKeyElement = tDocKey+tElementID;
    let nCheckFileUpLoad = 0;




    var oFileData = new FormData();
    $('.xFileUpload'+ptDocKeyElement).each(function(x){
        let tElementID = $(this).attr('id');
        if(document.getElementById(tElementID).files[0]!=undefined){
            oFileData.append("ofiles[]", document.getElementById(tElementID).files[0]);
            nCheckFileUpLoad++;
        }
    }); 

    oFileData.append("tBchCode", tBchCode);
    oFileData.append("tDocNo", tDocNo);
    oFileData.append("tDocKey", tDocKey);
    
            $.ajax({
                type: 'POST',
                url: 'UPFEventAdd',
                data: oFileData,
                dataType: "text",
                contentType: false, // Not to set any content header
                processData: false, // Not to process data
                success: function (tData) {
                    JCNxCloseLoading();
                    let oData = JSON.parse(tData);
                    if(oData['nStaEvent']=='001'){
                        // JCNxUPFCallDataTable(oBjectFile);
                    }else{
                        $('#'+tElementID).html(oData['tStaMessg']);
                    }
                    // setTimeout(function () {
                    //     return window[tUPFViewCallBackFunct](oData);
                    // }, 500);
                },
            });

}

function JCNxUPFDeleteDataElement(nSeq,ptDocKeyElement){
    $('#oflUPFData'+ptDocKeyElement+'_'+nSeq).remove();
    $('#otrKeyFile'+ptDocKeyElement+'_'+nSeq).remove();
    JCNxUPFSetNotFonud(ptDocKeyElement);
}   

function JCNxUPFDeleteData(nSeq,ptDocKeyElement,ptFullpath){
    JCNxOpenLoading();
    var tUPFViewBchCode = $("#ohdUPFViewBchCode"+ptDocKeyElement).val();
    var tUPFViewDocNo = $("#ohdUPFViewDocNo"+ptDocKeyElement).val();
    var tUPFViewDocKey = $("#ohdUPFViewDocKey"+ptDocKeyElement).val();
    var tUPFViewSessionID = $("#ohdUPFViewSessionID"+ptDocKeyElement).val();
    var tUPFViewtElementID = $("#ohdUPFViewtElementID"+ptDocKeyElement).val();
    var tUPFViewCallBackFunct = $("#ohdUPFViewCallBackFunct"+ptDocKeyElement).val();

    let oBjectFile = {
        ptElementID:tUPFViewtElementID,  
        ptBchCode:tUPFViewBchCode,
        ptDocNo:tUPFViewDocNo,
        ptDocKey:tUPFViewDocKey,
        ptSessionID:tUPFViewSessionID,
        ptCallBackFunct:tUPFViewCallBackFunct,
        pnEvent:3
    }

    var oFileData = {
        tBchCode:tUPFViewBchCode,
        tDocNo:tUPFViewDocNo,
        tDocKey:tUPFViewDocKey,
        nSeq:nSeq,
        tSessionID:tUPFViewSessionID,
        tFullpath:ptFullpath
    }


    $.ajax({
        type: 'POST',
        url: 'UPFEventDelete',
        data: oFileData,
        dataType: "text",
        success: function (tData) {
               JCNxCloseLoading();
             let oData = JSON.parse(tData);
            if(oData['rtCode']=='1'){
                // JCNxUPFCallDataTable(oBjectFile);
                $('#otbUPFTableDnD'+ptDocKeyElement+' #'+nSeq).remove();
                JCNxUPFSetNotFonud(ptDocKeyElement);
            }
            setTimeout(function () {
                if(tUPFViewCallBackFunct!=''){
                    return window[tUPFViewCallBackFunct](oData);
                }
            }, 500);
         
        },
    });


}


function JCNxUFPSortSeqUpdate(nRowIdFrom,nRowIdTo,ptDocKeyElement){
    JCNxOpenLoading();
    var tUPFViewBchCode = $("#ohdUPFViewBchCode"+ptDocKeyElement).val();
    var tUPFViewDocNo = $("#ohdUPFViewDocNo"+ptDocKeyElement).val();
    var tUPFViewDocKey = $("#ohdUPFViewDocKey"+ptDocKeyElement).val();
    var tUPFViewSessionID = $("#ohdUPFViewSessionID"+ptDocKeyElement).val();
    var tUPFViewtElementID = $("#ohdUPFViewtElementID"+ptDocKeyElement).val();
    var tUPFViewCallBackFunct = $("#ohdUPFViewCallBackFunct"+ptDocKeyElement).val();

    let oBjectFile = {
        ptElementID:tUPFViewtElementID,  
        ptBchCode:tUPFViewBchCode,
        ptDocNo:tUPFViewDocNo,
        ptDocKey:tUPFViewDocKey,
        ptSessionID:tUPFViewSessionID,
        ptCallBackFunct:tUPFViewCallBackFunct,
        pnEvent:3
    }
    var oFileData = {
        tBchCode:tUPFViewBchCode,
        tDocNo:tUPFViewDocNo,
        tDocKey:tUPFViewDocKey,
        nRowIdFrom:nRowIdFrom,
        nRowIdTo:nRowIdTo,
        tSessionID:tUPFViewSessionID
    }

    
    $.ajax({
        type: 'POST',
        url: 'UPFEventEdit',
        data: oFileData,
        dataType: "text",
        success: function (tData) {
               JCNxCloseLoading();
             let oData = JSON.parse(tData);
            if(oData['rtCode']=='1'){
                // JCNxUPFCallDataTable(oBjectFile);
            }
            setTimeout(function () {
                if(tUPFViewCallBackFunct!=''){
                    return window[tUPFViewCallBackFunct](oData);
                }
            }, 500);
        },
    });


}



function JCNxUPFSetInputUpload(ptDocKeyElement){

    var tLastSeqInputID = $('.xFileUpload'+ptDocKeyElement).last().attr('id');
    $('#olbUPFChsForInput'+ptDocKeyElement).attr('for',tLastSeqInputID);
   
}