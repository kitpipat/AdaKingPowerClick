<script>   

/**
 * Functionality : Add or Update
 * Parameters : route
 * Creator : 23/05/2019 Piya
 * Update : -
 * Return : -
 * Return Type : -
 */
function JSxCreditNoteOpenDisChgPanel(poParams) {

    $tDiscountcharg = $('#oetDiscountcharg').val();
    $tDiscountcharginglist  =  $('#oetDiscountcharginglist').val();


    $("#odvCreditNoteDisChgHDTable").html('');
    $("#odvCreditNoteDisChgDTTable").html('');
    
    if(poParams.DisChgType == 'disChgHD'){
        $('#ohdCreditNoteDisChgType').val('disChgHD');
        $(".xWCreditNoteDisChgHeadPanel").text($tDiscountcharg);
        JSxCreditNoteDisChgHDList(1);
    }
    if(poParams.DisChgType == 'disChgDT'){
        $('#ohdCreditNoteDisChgType').val('disChgDT');
        $(".xWCreditNoteDisChgHeadPanel").text($tDiscountcharginglist);
        JSxCreditNoteDisChgDTList(1);
    }
   
    $('#odvCreditNoteDisChgPanel').modal('show');
    
    // console.log('JCNbCreditNoteIsDisChgType HD: ', JCNbCreditNoteIsDisChgType('disChgHD'));
    // console.log('JCNbCreditNoteIsDisChgType DT: ', JCNbCreditNoteIsDisChgType('disChgDT'));
    
}

/**
 * Functionality : Call PI HD List
 * Parameters : route
 * Creator : 21/06/2019 Piya
 * Update : -
 * Return : -
 * Return Type : -
 */
function JSxCreditNoteDisChgHDList(pnPage) {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof nStaSession !== "undefined" && nStaSession == 1) {
        
        JCNxOpenLoading();

        var nPageCurrent = pnPage;
        if (nPageCurrent == undefined || nPageCurrent == "") {
            nPageCurrent = "1";
        }

        var oAdvanceSearch = ''; // JSoCreditNoteGetAdvanceSearchData();

        $.ajax({
            type: "POST",
            url: "creditNoteDisChgHDList",
            data: $("#ofmAddCreditNote").serialize() + '&' + $("#ofmCreditNoteRefPIHDForm").serialize() + '&oAdvanceSearch=' + oAdvanceSearch + '&nPageCurrent=' + nPageCurrent + '&tBchCode=' + $('#oetCreditNoteBchCode').val(),
            cache: false,
            timeout: 5000,
            success: function (tResult) {
                try{
                    var oResult = JSON.parse(tResult);
                    $("#odvCreditNoteDisChgHDTable").html(oResult.tPIViewDataTableList);
                    JCNxCloseLoading();
                }catch(err){
                    console.log('JSxCreditNoteDisChgHDList Error: ', err);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
        
    }else {
        JCNxShowMsgSessionExpired();
    }    
}

/**
 * Functionality : Call PI DT List
 * Parameters : route
 * Creator : 21/06/2019 Piya
 * Update : -
 * Return : -
 * Return Type : -
 */
function JSxCreditNoteDisChgDTList(pnPage) {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof nStaSession !== "undefined" && nStaSession == 1) {
        
        JCNxOpenLoading();

        var nPageCurrent = pnPage;
        if (nPageCurrent == undefined || nPageCurrent == "") {
            nPageCurrent = "1";
        }

        var oAdvanceSearch = ''; // JSoCreditNoteGetAdvanceSearchData();

        $.ajax({
            type: "POST",
            url: "creditNoteDisChgDTList",
            data: $("#ofmAddCreditNote").serialize() + '&tSeqNo=' + DisChgDataRowDT.tSeqNo + '&oAdvanceSearch=' + oAdvanceSearch + '&nPageCurrent=' + nPageCurrent + '&tBchCode=' + $('#oetCreditNoteBchCode').val(),
            cache: false,
            timeout: 5000,
            success: function (tResult) {
                try{
                    var oResult = JSON.parse(tResult);
                    $("#odvCreditNoteDisChgDTTable").html(oResult.tPIViewDataTableList);
                    JCNxCloseLoading();
                }catch(err){
                    console.log('JSxCreditNoteDisChgDTList Error: ', err);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    
    }else {
        JCNxShowMsgSessionExpired();
    }
}

/**
 * Functionality : เปลี่ยนหน้า pagenation
 * Parameters : -
 * Creator : 22/05/2019 Piya
 * Return : View
 * Return Type : View
 */
function JSvCreditNoteDisChgHDClickPage(ptPage) {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof nStaSession !== "undefined" && nStaSession == 1) {
        
        var nPageCurrent = "";
        switch (ptPage) {
            case "next": //กดปุ่ม Next
                $("#odvCreditNoteDisChgHDList .xWBtnNext").addClass("disabled");
                nPageOld = $("#odvCreditNoteDisChgHDList .xWPage .active").text(); // Get เลขก่อนหน้า
                nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
                nPageCurrent = nPageNew;
                break;
            case "previous": //กดปุ่ม Previous
                nPageOld = $("#odvCreditNoteDisChgHDList .xWPage .active").text(); // Get เลขก่อนหน้า
                nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
                nPageCurrent = nPageNew;
                break;
            default:
                nPageCurrent = ptPage;
        }
        JSxCreditNotePIHDList(nPageCurrent);
        
    } else {
        JCNxShowMsgSessionExpired();
    }
}

/**
 * Functionality : เปลี่ยนหน้า pagenation
 * Parameters : -
 * Creator : 22/05/2019 Piya
 * Return : View
 * Return Type : View
 */
function JSvCreditNoteDisChgDTClickPage(ptPage) {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof nStaSession !== "undefined" && nStaSession == 1) {
        
        var nPageCurrent = "";
        switch (ptPage) {
            case "next": //กดปุ่ม Next
                $("#odvCreditNoteDisChgDTList .xWBtnNext").addClass("disabled");
                nPageOld = $("#odvCreditNoteDisChgDTList .xWPage .active").text(); // Get เลขก่อนหน้า
                nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
                nPageCurrent = nPageNew;
                break;
            case "previous": //กดปุ่ม Previous
                nPageOld = $("#odvCreditNoteDisChgDTList .xWPage .active").text(); // Get เลขก่อนหน้า
                nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
                nPageCurrent = nPageNew;
                break;
            default:
                nPageCurrent = ptPage;
        }
        JSxCreditNotePIDTList(nPageCurrent,null);
        
    } else {
        JCNxShowMsgSessionExpired();
    }    
}

/**
 * Functionality : Is Dis Chg Type
 * Parameters : -
 * Creator : 22/05/2019 piya
 * Last Modified : -
 * Return : Status true is create page
 * Return Type : Boolean
 */
function JCNbCreditNoteIsDisChgType(ptDisChgType){
    try{
        var tCreditNoteDisChgType = $('#ohdCreditNoteDisChgType').val();
        var bStatus = false;
        if(ptDisChgType == "disChgHD"){
            if(tCreditNoteDisChgType == "disChgHD"){ // No have data
                bStatus = true;
            }
        }
        if(ptDisChgType == "disChgDT"){
            if(tCreditNoteDisChgType == "disChgDT"){ // No have data
                bStatus = true;
            }
        }
        return bStatus;
    }catch(err){
        console.log('JCNbCreditNoteIsCreatePage Error: ', err);
    }
}

/**
* Functionality : คำนวณ ส่วนลด
* Parameters : -
* Creator : 27/06/2019 piya
* Last Modified : -
* Return : -
* Return Type : -
*/
function JSxCreditNoteCalcDisChg(){
    // console.log('Begin Cal >>>>>>>>>> ');
    var bLimitBeforeDisChg = true;
    $('.xWCreditNoteDisChgTrTag').each(function(index){
        if($('.xWCreditNoteDisChgTrTag').length == 1){
            $('img.xWCreditNoteDisChgRemoveIcon').first().attr('onclick', 'JSxCreditNoteResetDisChgRemoveRow(this)').css('opacity', '1');
        }else{
            $('img.xWCreditNoteDisChgRemoveIcon').first().attr('onclick', '').css('opacity', '0.2');
        } 
        
        if(bLimitBeforeDisChg){
            if(JCNbCreditNoteIsDisChgType('disChgDT')){
                let cBeforeDisChg = (parseFloat(DisChgDataRowDT.tQty) * parseFloat(DisChgDataRowDT.tSetPrice))
                $(this).first().find('td label.xWCreditNoteDisChgBeforeDisChg').text(accounting.formatNumber(cBeforeDisChg, 2, ','));
            }
            if(JCNbCreditNoteIsDisChgType('disChgHD')){
                // let cBeforeDisChg = $('label#olbCrdditNoteSumFCXtdNet').text();
                let cBeforeDisChg = $('#olbCrdSumFCXtdNetAlwDis').val();
                $(this).first().find('td label.xWCreditNoteDisChgBeforeDisChg').text(accounting.formatNumber(cBeforeDisChg, 2, ','));
            }
        }
        bLimitBeforeDisChg = false;
        
        var cCalc;
        var nDisChgType = $(this).find('td select.xWCreditNoteDisChgType').val();
        var cDisChgNum = $(this).find('td input.xWCreditNoteDisChgNum').val();
        // console.log('DisChg Type: ', nDisChgType);
        var cDisChgBeforeDisChg = accounting.unformat($(this).find('td label.xWCreditNoteDisChgBeforeDisChg').text());
        var cDisChgValue = $(this).find('td label.xWCreditNoteDisChgValue').text();
        var cDisChgAfterDisChg = $(this).find('td label.xWCreditNoteDisChgAfterDisChg').text();
        
        if(nDisChgType == 1){ // ลดบาท
            // console.log('cDisChgBeforeDisChg: ', cDisChgBeforeDisChg);
            // console.log('cDisChgNum: ', cDisChgNum);
            cCalc = parseFloat(cDisChgBeforeDisChg) - parseFloat(cDisChgNum);
            // console.log('cCalc: ', cCalc);
            $(this).find('td label.xWCreditNoteDisChgValue').text(accounting.formatNumber(cDisChgNum, 2, ','));
        }
        
        if(nDisChgType == 2){ // ลด %
            var cDisChgPercent = (cDisChgBeforeDisChg * parseFloat(cDisChgNum)) / 100;
            cCalc = parseFloat(cDisChgBeforeDisChg) - cDisChgPercent;
            $(this).find('td label.xWCreditNoteDisChgValue').text(accounting.formatNumber(cDisChgPercent, 2, ','));
        }
        
        if(nDisChgType == 3){ // ชาร์จบาท
            cCalc = parseFloat(cDisChgBeforeDisChg) + parseFloat(cDisChgNum);
            $(this).find('td label.xWCreditNoteDisChgValue').text(accounting.formatNumber(cDisChgNum, 2, ','));
        }
        
        if(nDisChgType == 4){ // ชาร์ท %
            var cDisChgPercent = (parseFloat(cDisChgBeforeDisChg) * parseFloat(cDisChgNum)) / 100;
            cCalc = parseFloat(cDisChgBeforeDisChg) + cDisChgPercent;
            $(this).find('td label.xWCreditNoteDisChgValue').text(accounting.formatNumber(cDisChgPercent, 2, ','));
        }
        
        $(this).find('td label.xWCreditNoteDisChgAfterDisChg').text(accounting.formatNumber(cCalc, 2, ','));
        $(this).next().not('#otrCreditNoteDisChgDTNotFound').find('td label.xWCreditNoteDisChgBeforeDisChg').text(accounting.formatNumber(cCalc, 2, ','));
        
    });
    // console.log('End Cal >>>>>>>>>>');
}

/**
 * Functionality : Calc Dis Chg HD And Add
 * Parameters : -
 * Creator : 22/05/2019 piya
 * Last Modified : -
 * Return : Status true is create page
 * Return Type : Boolean
 */
function JCNvCreditNoteAddDisChgRow(){
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof nStaSession !== "undefined" && nStaSession == 1) {   

        //เอาเฉพาะราคาที่อนุญาติลดมาคิดเท่านั้น
        cSumFCXtdNet = $('#olbCrdSumFCXtdNetAlwDis').val();

        if(!JSbCreditNoteHasDisChgRow()){
            $('#otrCreditNoteDisChgDTNotFound').remove();
        }
        
        var tCreatedAt = moment().format('YYYY-MM-DD HH:mm:ss');
        
        if(JCNbCreditNoteIsDisChgType('disChgHD')){
            
            var tDisChgHDTemplate;
            // var cSumFCXtdNet = $('#olbCrdditNoteSumFCXtdNet').text();
            if(JSbCreditNoteHasDisChgRow()){
                var oLastRow = $('.xWCreditNoteDisChgTrTag').last();
                var cAfterDisChgLastRow = oLastRow.find('td label.xWCreditNoteDisChgAfterDisChg').text();
                tDisChgHDTemplate = JStCreditNoteSetTrBody(cAfterDisChgLastRow, '0.00', '0.00', tCreatedAt);     
            }else{
                tDisChgHDTemplate = JStCreditNoteSetTrBody(cSumFCXtdNet, '0.00', '0.00', tCreatedAt);
            }


            $('#otrCreditNoteDisChgHDNotFound').addClass('xCNHide');
            $('#otbDisChgDataDocHDList tbody').append(tDisChgHDTemplate);
            JSxCreditNoteResetDisChgColIndex();
            $('.dischgselectpicker').selectpicker();
            // console.log('cSumFCXtdNet: ', cSumFCXtdNet);

        }

        if(JCNbCreditNoteIsDisChgType('disChgDT')){
            // console.log('DisChgDataRowDT: ', DisChgDataRowDT);
            var tDisChgHDTemplate;
            var cSumFCXtdNet = accounting.formatNumber(DisChgDataRowDT.tNet, 2, ',');
            if(JSbCreditNoteHasDisChgRow()){
                var oLastRow = $('.xWCreditNoteDisChgTrTag').last();
                var cAfterDisChgLastRow = oLastRow.find('td label.xWCreditNoteDisChgAfterDisChg').text();
                tDisChgHDTemplate = JStCreditNoteSetTrBody(cAfterDisChgLastRow, '0.00', '0.00', tCreatedAt);     
            }else{
                tDisChgHDTemplate = JStCreditNoteSetTrBody(cSumFCXtdNet, '0.00', '0.00', tCreatedAt);
            }


            $('#otrCreditNoteDisChgDTNotFound').addClass('xCNHide');
            $('#otbDisChgDataDocDTList tbody').append(tDisChgHDTemplate);
            JSxCreditNoteResetDisChgColIndex();
            $('.dischgselectpicker').selectpicker();
            // console.log('cSumFCXtdNet: ', cSumFCXtdNet);
        }

        JSxCreditNoteCalcDisChg();
    } else {
        JCNxShowMsgSessionExpired();
    }    
}

/**
 * Functionality : Save Dis Chg to DB
 * Parameters : -
 * Creator : 22/06/2019 piya
 * Last Modified : -
 * Return : -
 * Return Type : -
 */
function JSxCreditNoteDisChgSave() {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof nStaSession !== "undefined" && nStaSession == 1) {
        
        /*if(!JSbCreditNoteHasDisChgRow()){
            FSvCMNSetMsgWarningDialog('ไม่พบรายการ ส่วนลด/ชาร์จ');
        }*/

        var aDisChgItems = [];
        var cBeforeDisChgSum = 0.00;
        var cAfterDisChgSum = 0.00;
        $('.xWCreditNoteDisChgTrTag').each(function(index){
            
            var tCreatedAt = $(this).find('input.xWCreditNoteDisChgCreatedAt').val();
            
            var nSeqNo = '';
            var tStaDis = '';
            if(JCNbCreditNoteIsDisChgType('disChgDT')){
                nSeqNo = DisChgDataRowDT.tSeqNo;
                tStaDis = DisChgDataRowDT.tStadis;
            }
            
            var cBeforeDisChg = accounting.unformat($(this).find('td label.xWCreditNoteDisChgBeforeDisChg').text());
            var cAfterDisChg = accounting.unformat($(this).find('td label.xWCreditNoteDisChgAfterDisChg').text());
            var cDisChgValue = accounting.unformat($(this).find('td label.xWCreditNoteDisChgValue').text());
            var nDisChgType = parseInt($(this).find('td select.xWCreditNoteDisChgType').val());
            var cDisChgNum = accounting.unformat($(this).find('td input.xWCreditNoteDisChgNum').val());
            
            // Dis Chg Summary
            cBeforeDisChgSum += parseFloat(cBeforeDisChg);
            cAfterDisChgSum += parseFloat(cAfterDisChg);
            
            // Dis Chg Text
            var tDisChgTxt = '';
            switch(nDisChgType){
                case 1 : {
                    tDisChgTxt = '-' + cDisChgNum;    
                    break;
                }
                case 2 : {
                    tDisChgTxt = '-' + cDisChgNum + '%';
                    break;
                }
                case 3 : {
                    tDisChgTxt = '+' + cDisChgNum;    
                    break;
                }
                case 4 : {
                    tDisChgTxt = '+' + cDisChgNum + '%';    
                    break;
                }
                default : {}
            }
            
            aDisChgItems.push({
                cBeforeDisChg: cBeforeDisChg,
                cDisChgValue: cDisChgValue,
                cAfterDisChg: cAfterDisChg,
                nDisChgType: nDisChgType,
                cDisChgNum: cDisChgNum,
                tDisChgTxt: tDisChgTxt,
                tCreatedAt: tCreatedAt,
                nSeqNo: nSeqNo,
                tStaDis: tStaDis
            });
            
        });
        
        var oDisChgSummary = {cBeforeDisChgSum: cBeforeDisChgSum, cAfterDisChgSum: cAfterDisChgSum};
        
        if (JCNbCreditNoteIsDisChgType('disChgHD')) {
            $.ajax({
                type: "POST",
                url: "creditNoteAddEditHDDis",
                data: {
                    tBchCode        : $('#oetCreditNoteBchCode').val(),
                    tDocNo          : $('#oetCreditNoteDocNo').val(),
                    tSplVatType     : JSxCreditNoteIsSplUseVatType('in') ? '1' : '2', // 1: รวมใน, 2: แยกนอก
                    tDisChgItems    : JSON.stringify(aDisChgItems),
                    tDisChgSummary  : JSON.stringify(oDisChgSummary)
                },
                cache: false,
                timeout: 5000,
                success: function (tResult) {
                    if (JCNbCreditNoteIsDocType('havePdt')) {
                        JSvCreditNoteLoadPdtDataTableHtml(1, false);
                    }
                    if (JCNbCreditNoteIsDocType('nonePdt')) {
                        JSvCreditNoteLoadNonePdtDataTableHtml(1, false);
                    }
                    $('#odvCreditNoteDisChgPanel').modal('hide');
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }

        if (JCNbCreditNoteIsDisChgType('disChgDT')) {
            $.ajax({
                type: "POST",
                url: "creditNoteAddEditDTDis",
                data: {
                    tBchCode        : $('#oetCreditNoteBchCode').val(),
                    tSeqNo          : DisChgDataRowDT.tSeqNo,
                    tDocNo          : $('#oetCreditNoteDocNo').val(),
                    tSplVatType     : JSxCreditNoteIsSplUseVatType('in') ? '1' : '2', // 1: รวมใน, 2: แยกนอก
                    tDisChgItems    : JSON.stringify(aDisChgItems),
                    tDisChgSummary  : JSON.stringify(oDisChgSummary)
                },
                cache: false,
                timeout: 5000,
                success: function (tResult) {
                    // console.log(tResult);
                    if (JCNbCreditNoteIsDocType('havePdt')) {
                        JSvCreditNoteLoadPdtDataTableHtml(1, false);
                    }
                    if (JCNbCreditNoteIsDocType('nonePdt')) {
                        JSvCreditNoteLoadNonePdtDataTableHtml(1, false);
                    }
                    $('#odvCreditNoteDisChgPanel').modal('hide');
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }
        
    }else {
        JCNxShowMsgSessionExpired();
    }
}

/**
* Functionality : Set <tr> body
* Parameters : poOldCard
* Creator : 13/11/2018 piya
* Last Modified : -
* Return : template
* Return Type : string
*/
function JStCreditNoteSetTrBody(pcBeforeDisChg, pcDisChgValue, pcAfterDisChg, ptCreatedAt){
    try{
        // console.log("JStCreditNoteSetTrBody", pcBeforeDisChg);
        let tTemplate = $("#oscCreditNoteTrBodyTemplate").html();
        let oData = {cBeforeDisChg: pcBeforeDisChg, cDisChgValue: pcDisChgValue, cAfterDisChg: pcAfterDisChg, tCreatedAt: ptCreatedAt};
        let tRender = JStCreditNoteRenderTemplate(tTemplate, oData);
        return tRender;
    }catch(err){
        console.log("JStCreditNoteSetTrBody Error: ", err);
    }
}

/**
* Functionality : Replace value to template
* Parameters : tTemplate, tData
* Creator : 31/10/2018 piya
* Last Modified : -
* Return : view
* Return Type : string
*/
function JStCreditNoteRenderTemplate(tTemplate, oData){
    try{
        String.prototype.fmt = function (hash) {
            let tString = this, nKey; 
            for(nKey in hash){
                tString = tString.replace(new RegExp('\\{' + nKey + '\\}', 'gm'), hash[nKey]); 
            }
            return tString;
        };
        let tRender = "";
        tRender = tTemplate.fmt(oData);

        return tRender;
    }catch(err){
        console.log("JStCreditNoteRenderTemplate Error: ", err);
    }
}

/**
* Functionality : Reset column index in dischg modal
* Parameters : -
* Creator : 27/06/2019 piya
* Last Modified : -
* Return : -
* Return Type : -
*/
function JSxCreditNoteResetDisChgColIndex(){
    $('.xWCreditNoteDisChgIndex').each(function(index){
        $(this).text(index+1);
    });
}

/**
* Functionality : Remove Dis Chg Row
* Parameters : -
* Creator : 27/06/2019 piya
* Last Modified : -
* Return : -
* Return Type : -
*/
function JSxCreditNoteResetDisChgRemoveRow(poEl){
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof nStaSession !== "undefined" && nStaSession == 1) {
        
        $(poEl).parents('.xWCreditNoteDisChgTrTag').remove();

        if(JSbCreditNoteHasDisChgRow()){
            JSxCreditNoteResetDisChgColIndex();
        }else{
            var oTrNotFound = $('#oscCreditNoteTrNotFoundTemplate').html();
            $('.xWDisChgTBBody').append(oTrNotFound);
        }
        JSxCreditNoteCalcDisChg();
        
    } else {
        JCNxShowMsgSessionExpired();
    }    
}

/**
* Functionality : ตรวจสอบว่ามีแถวอยู่หรือไม่ ในการทำรายการลดชาร์จ
* Parameters : -
* Creator : 27/06/2019 piya
* Last Modified : -
* Return : status
* Return Type : boolean
*/
function JSbCreditNoteHasDisChgRow(){
    var bStatus = false;
    var nRowCount = $('.xWCreditNoteDisChgTrTag').length;
    // console.log('nRowCount: ', nRowCount);
    if(nRowCount > 0){
        bStatus = true;
    }
    return bStatus;
}
</script>
