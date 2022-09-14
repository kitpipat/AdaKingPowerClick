<script type="text/javascript">
    
    // Functionality : Add/Update Modal DisChage
    // Parameters : route
    // Creator : 02/07/2019 Wasin(Yoshi)
    // Return : -
    // Return Type : -
    function JSxPOOpenDisChgPanel(poParams){
        $("#odvPODisChgHDTable").html('');
        $("#odvPODisChgDTTable").html('');

        if(poParams.DisChgType  == 'disChgHD'){
            $('#ohdPODisChgType').val('disChgHD');
            $(".xWPIDisChgHeadPanel").text('<?php echo language('document/purchaseorder/purchaseorder','tPOAdvDiscountcharging');?>');
            JSxPODisChgHDList(1);
        }

        if(poParams.DisChgType  == 'disChgDT'){
            $('#ohdPODisChgType').val('disChgDT');
            $(".xWPIDisChgHeadPanel").text('<?php echo language('document/purchaseorder/purchaseorder','tPOAdvDiscountcharginglist');?>');
            JSxPODisChgDTList(1);
        }

        $('#odvPODisChgPanel').modal({backdrop: 'static', keyboard: false})  
        $('#odvPODisChgPanel').modal('show');
        console.log('JCNbPOIsDisChgType HD: ', JCNbPOIsDisChgType('disChgHD'));
        console.log('JCNbPOIsDisChgType DT: ', JCNbPOIsDisChgType('disChgDT'));
    }

    // Functionality : Call PI HD List
    // Parameters : route
    // Creator : 02/07/2019 Wasin(Yoshi)
    // Update : -
    // Return : -
    // Return Type : -
    function JSxPODisChgHDList(pnPage){
        JCNxOpenLoading();
        var nPageCurrent = pnPage;
        if (nPageCurrent == undefined || nPageCurrent == "") {
            nPageCurrent = "1";
        }
        var oAdvanceSearch = '';
        $.ajax({
            type: "POST",
            url: "docPODisChgHDList",
            data: {
                'tDocNo'            : $('#oetPODocNo').val(),
                'tSelectBCH'        : $('#oetPOFrmBchCode').val(),
                'oAdvanceSearch'    : oAdvanceSearch,
                'nPageCurrent'      : nPageCurrent,
                'tPOSesSessionID'   : $('#ohdSesSessionID').val(),
                'tPOUsrCode'        : $('#ohdPOUsrCode').val(),
                'tPOLangEdit'       : $('#ohdPOLangEdit').val(),
                'tSesUsrLevel'      : $('#ohdSesUsrLevel').val(),
        },
            cache: false,
            timeout: 0,
            success: function (tResult){
                var oResult = JSON.parse(tResult);
                $("#odvPODisChgHDTable").html(oResult.tPOViewDataTableList);
                JCNxCloseLoading();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                // JCNxResponseError(jqXHR, textStatus, errorThrown);
                JSxPODisChgHDList(pnPage);
            }
        });
    }

    // Functionality : Call PI Document DTDisChg List
    // Parameters : route
    // Creator : 02/07/2019 Wasin(Yoshi)
    // Return : -
    // Return Type : -
    function JSxPODisChgDTList(pnPage){
        JCNxOpenLoading();
        var nPageCurrent = pnPage;
        if (nPageCurrent == undefined || nPageCurrent == "") {
            nPageCurrent = "1";
        }
        var oAdvanceSearch = '';
        $.ajax({
            type: "POST",
            url: "docPODisChgDTList",
            data: {
                'tSelectBCH'        : $('#oetPOFrmBchCode').val(),
                'tDocNo'            : $('#oetPODocNo').val(),
                'tSeqNo'            : DisChgDataRowDT.tSeqNo,
                'oAdvanceSearch'    : oAdvanceSearch,
                'nPageCurrent'      : nPageCurrent,
                'tPOSesSessionID'   : $('#ohdSesSessionID').val(),
                'tPOUsrCode'        : $('#ohdPOUsrCode').val(),
                'tPOLangEdit'       : $('#ohdPOLangEdit').val(),
                'tSesUsrLevel'      : $('#ohdSesUsrLevel').val(),
            },
            cache: false,
            timeout: 0,
            success: function (tResult){
                var oResult = JSON.parse(tResult);
                $("#odvPODisChgDTTable").html(oResult.tPOViewDataTableList);
                JCNxCloseLoading();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                // JCNxResponseError(jqXHR, textStatus, errorThrown);
                JSxPODisChgDTList(pnPage);
            }
        });
    }

    // Functionality : เปลี่ยนหน้า Pagenation Modal HD Dis/Chg 
    // Parameters : Event Click Pagenation Modal Dis/Chg HD 
    // Creator : 03/07/2019 Wasin(Yoshi)
    // Return : View Table Dis/Chg HD
    // Return Type : View
    function JSvPODisChgHDClickPage(ptPage){
        // var nStaSession = JCNxFuncChkSessionExpired();
        var nStaSession = 1;
        if(typeof nStaSession !== "undefined" && nStaSession == 1){
            var nPageCurrent    = "";
            switch(ptPage){
                case "next":
                    //กดปุ่ม Next
                    $("#odvPOHDList .xWBtnNext").addClass("disabled");
                    nPageOld        = $("#odvPOHDList .xWPage .active").text(); // Get เลขก่อนหน้า
                    nPageNew        = parseInt(nPageOld, 10) + 1; // +1 จำนวน
                    nPageCurrent    = nPageNew;
                    break;
                break;
                case "previous":
                    //กดปุ่ม Previous
                    nPageOld        = $("#odvPOHDList .xWPage .active").text(); // Get เลขก่อนหน้า
                    nPageNew        = parseInt(nPageOld, 10) - 1; // -1 จำนวน
                    nPageCurrent    = nPageNew;
                break;
                default:
                    nPageCurrent    = ptPage;
            }
            JSxPODisChgHDList(nPageCurrent);
        }else{
            JCNxShowMsgSessionExpired();
        }
    }

    // Functionality : เปลี่ยนหน้า Pagenation Modal DT Dis/Chg 
    // Parameters : Event Click Pagenation Modal Dis/Chg DT 
    // Creator : 03/07/2019 Wasin(Yoshi)
    // Return : View Table Dis/Chg DT
    // Return Type : View
    function JSvPODisChgDTClickPage(ptPage){
        // var nStaSession = JCNxFuncChkSessionExpired();
        var nStaSession = 1; 
        if(typeof nStaSession !== "undefined" && nStaSession == 1){
            var nPageCurrent    = "";
            switch(ptPage){
                case "next":
                    //กดปุ่ม Next
                    $("#odvPODTList .xWBtnNext").addClass("disabled");
                    nPageOld        = $("#odvPODTList .xWPage .active").text(); // Get เลขก่อนหน้า
                    nPageNew        = parseInt(nPageOld, 10) + 1; // +1 จำนวน
                    nPageCurrent    = nPageNew;
                break;
                case "previous":
                    //กดปุ่ม Previous
                    nPageOld        = $("#odvPODTList .xWPage .active").text(); // Get เลขก่อนหน้า
                    nPageNew        = parseInt(nPageOld, 10) - 1; // -1 จำนวน
                    nPageCurrent    = nPageNew;
                break;
                default:
                    nPageCurrent    = ptPage;
            }
            JSxPODisChgDTList(nPageCurrent);
        }else{
            JCNxShowMsgSessionExpired();
        }
    }

    // Functionality : คำนวณ ส่วนลด
    // Parameters : -
    // Creator : 27/06/2019 piya
    // Last Modified : -
    // Return : -
    // Return Type : -
    function JSxPOCalcDisChg(){
        console.log('Calc');
        var bLimitBeforeDisChg  = true;
        $('.xWPIDisChgTrTag').each(function(index){
            if($('.xWPIDisChgTrTag').length == 1){
                $('img.xWPIDisChgRemoveIcon').first().attr('onclick','JSxPOResetDisChgRemoveRow(this)').css('opacity', '1');
            }else{
                $('img.xWPIDisChgRemoveIcon').first().attr('onclick','').css('opacity','0.2');
            }

            if(bLimitBeforeDisChg){
                if(JCNbPOIsDisChgType('disChgDT')){
                    let cBeforeDisChg = (parseFloat(DisChgDataRowDT.tQty) * parseFloat(DisChgDataRowDT.tSetPrice));
                    console.log('TT : ' + cBeforeDisChg);
                    $(this).find('td label.xWPIDisChgBeforeDisChg').first().text(accounting.formatNumber(cBeforeDisChg, 2, ','));
                }
                if(JCNbPOIsDisChgType('disChgHD')){
                    let cBeforeDisChg = $('#olbSumFCXtdNet').text();
                    // let cBeforeDisChg = $('#olbSumFCXtdNetAlwDis').val();
                    $(this).find('td label.xWPIDisChgBeforeDisChg').first().text(accounting.formatNumber(cBeforeDisChg, 2, ','));
                }
            }

            bLimitBeforeDisChg = false;

            var cCalc;
            var nDisChgType = $(this).find('td select.xWPIDisChgType').val();
            var cDisChgNum  = $(this).find('td input.xWPIDisChgNum').val();
            console.log('DisChg Type: ', nDisChgType);
            var cDisChgBeforeDisChg = accounting.unformat($(this).find('td label.xWPIDisChgBeforeDisChg').text());
            var cDisChgValue = $(this).find('td label.xWPIDisChgValue').text();
            var cDisChgAfterDisChg = $(this).find('td label.xWPIDisChgAfterDisChg').text();

            if(nDisChgType == 1){ // ลดบาท
                console.log('cDisChgBeforeDisChg: ', cDisChgBeforeDisChg);
                console.log('cDisChgNum: ', cDisChgNum);
                cCalc = parseFloat(cDisChgBeforeDisChg) - parseFloat(cDisChgNum);
                console.log('cCalc: ', cCalc);
                $(this).find('td label.xWPIDisChgValue').text(accounting.formatNumber(cDisChgNum, 2, ','));
            }
            
            if(nDisChgType == 2){ // ลด %
                var cDisChgPercent  = (cDisChgBeforeDisChg * parseFloat(cDisChgNum)) / 100;
                cCalc = parseFloat(cDisChgBeforeDisChg) - cDisChgPercent;
                $(this).find('td label.xWPIDisChgValue').text(accounting.formatNumber(cDisChgPercent, 2, ','));
            }
            
            if(nDisChgType == 3){ // ชาร์จบาท
                cCalc = parseFloat(cDisChgBeforeDisChg) + parseFloat(cDisChgNum);
                $(this).find('td label.xWPIDisChgValue').text(accounting.formatNumber(cDisChgNum, 2, ','));
            }
            
            if(nDisChgType == 4){ // ชาร์ท %
                var cDisChgPercent = (parseFloat(cDisChgBeforeDisChg) * parseFloat(cDisChgNum)) / 100;
                cCalc = parseFloat(cDisChgBeforeDisChg) + cDisChgPercent;
                $(this).find('td label.xWPIDisChgValue').text(accounting.formatNumber(cDisChgPercent, 2, ','));
            }

            $(this).find('td label.xWPIDisChgAfterDisChg').text(accounting.formatNumber(cCalc, 2, ','));
            $(this).next().find('td label.xWPIDisChgBeforeDisChg').text(accounting.formatNumber(cCalc, 2, ','));

            $('#olbSumFCXtdNetAfHD').text(accounting.formatNumber(cCalc, 2, ','));
        });
    }

    // Functionality : Is Dis Chg Type
    // Parameters : -
    // Creator : 02/07/2019 Wasin(Yoshi)
    // Last Modified : -
    // Return : Status true is create page
    // Return Type : Boolean
    function JCNbPOIsDisChgType(ptDisChgType){
        try{
            var tPODisChgType = $('#ohdPODisChgType').val();
            var bStatus = false;
            if(ptDisChgType == "disChgHD"){
                if(tPODisChgType == "disChgHD"){ // No have data
                    bStatus = true;
                }
            }
            if(ptDisChgType == "disChgDT"){
                if(tPODisChgType == "disChgDT"){ // No have data
                    bStatus = true;
                }
            }
            return bStatus;
        }catch(err){
            console.log('JCNbPOIsCreatePage Error: ', err);
        }
    }

    // Functionality : ตรวจสอบว่ามีแถวอยู่หรือไม่ ในการทำรายการลดชาร์จ
    // Parameters : -
    // Creator : 03/07/2019 Wasin(Yoshi)
    // Last Modified : -
    // Return : Status Check Row Dis/Chg
    // Return Type : Boolean
    function JSbPOHasDisChgRow(){
        var bStatus     = false;
        var nRowCount   = $('.xWPIDisChgTrTag').length;
        console.log('nRowDisChgCount: ',nRowCount);
        if(nRowCount > 0){
            bStatus = true;
        }
        return bStatus;
    }

    // Functionality : Set Row ข้อมูลลดชาร์ทในตาราง Modal Dis/Chg
    // Parameters : -
    // Creator : 03/07/2019 Wasin(Yoshi)
    // Last Modified : -
    // Return : String Text Html Row Dis/Chg
    // Return Type : String
    function JStPOSetTrBody(pcBeforeDisChg, pcDisChgValue, pcAfterDisChg){
        console.log("JStPOSetTrBody", pcBeforeDisChg);
        let tTemplate   = $("#oscPOTrBodyTemplate").html();
        let oData       = {
            'cBeforeDisChg' : pcBeforeDisChg,
            'cDisChgValue'  : pcDisChgValue,
            'cAfterDisChg'  : pcAfterDisChg
        };
        let tRender     = JStPORenderTemplate(tTemplate,oData);
        return tRender;
    }

    // Functionality : Replace Value to template
    // Parameters : -
    // Creator : 03/07/2019 Wasin(Yoshi)
    // Last Modified : -
    // Return : String Template Html Row Dis/Chg
    // Return Type : String
    function JStPORenderTemplate(tTemplate,oData){
        String.prototype.fmt    = function (hash) {
            let tString = this, nKey; 
            for(nKey in hash){
                tString = tString.replace(new RegExp('\\{' + nKey + '\\}', 'gm'), hash[nKey]); 
            }
            return tString;
        };
        let tRender = "";
        tRender     = tTemplate.fmt(oData);
        return tRender;
    }

    // Functionality : Reset column index in dischg modal
    // Parameters : -
    // Creator : 03/07/2019 Wasin(Yoshi)
    // Last Modified : -
    // Return : -
    // Return Type : -
    function JSxPOResetDisChgColIndex(){
        $('.xWPIDisChgIndex').each(function(index){
            $(this).text(index+1);
        });
    }


    // Functionality : กำหนดวันที่ เวลา ให้กับแต่ละรายการ ลด/ชาร์จ
    // Parameters : -
    // Creator : 03/07/2019 Wasin(Yoshi)
    // Last Modified : -
    // Return : -
    // Return Type : -
    function JCNxPODisChgSetCreateAt(poEl){
        $(poEl).parents('tr.xWPIDisChgTrTag').find('input.xWPIDisChgCreatedAt').val(moment().format('DD-MM-YYYY HH:mm:ss'));
        console.log('DATE: ', $(poEl).parents('tr.xWPIDisChgTrTag').find('input.xWPIDisChgCreatedAt').val());    
    }

    // Functionality : Add Row Data Dis/Chg HD And DT
    // Parameters : -
    // Creator : 03/07/2019 Wasin(Yoshi)
    // Last Modified : -
    // Return : Row Dis/Chg In Modal
    // Return Type : None
    function JCNvPOAddDisChgRow(poEl){
        // var nStaSession = JCNxFuncChkSessionExpired();
           var  nStaSession = 1;
        if(typeof nStaSession !== "undefined" && nStaSession == 1) {

            //หาราคาที่อนุญาติลดเท่านั้น - วัฒน์
            var cSumFCXtdNet = $('#olbSumFCXtdNetAlwDis').val();
            
            // Check Append Row Dis/chg HD
            if(JCNbPOIsDisChgType('disChgHD')){
                var tDisChgHDTemplate;
                if(JSbPOHasDisChgRow()){
                    var oLastRow            = $('.xWPIDisChgTrTag').last();
                    var cAfterDisChgLastRow = oLastRow.find('td label.xWPIDisChgAfterDisChg').text();
                    tDisChgHDTemplate       = JStPOSetTrBody(cAfterDisChgLastRow,'0.00','0.00');     
                }else{
                    tDisChgHDTemplate       = JStPOSetTrBody(cSumFCXtdNet,'0.00', '0.00');
                }

                $('#otrPODisChgHDNotFound').addClass('xCNHide');
                $('#otbPODisChgDataDocHDList tbody').append(tDisChgHDTemplate);
                JSxPOResetDisChgColIndex();
                JCNxPODisChgSetCreateAt(poEl);
                $('.dischgselectpicker').selectpicker();
            }
            
            // Check Append Row Dis/chg DT
            if(JCNbPOIsDisChgType('disChgDT')){
                var tDisChgHDTemplate;
                var cSumFCXtdNet    = accounting.formatNumber(DisChgDataRowDT.tNet, 2, ',');
                if(JSbPOHasDisChgRow()){
                    var oLastRow            = $('.xWPIDisChgTrTag').last();
                    var cAfterDisChgLastRow = oLastRow.find('td label.xWPIDisChgAfterDisChg').text();
                    tDisChgHDTemplate       = JStPOSetTrBody(cAfterDisChgLastRow, '0.00', '0.00');
                }else{
                    tDisChgHDTemplate       = JStPOSetTrBody(cSumFCXtdNet, '0.00', '0.00');
                }

                $('#otrPODisChgDTNotFound').addClass('xCNHide');
                $('#otbPODisChgDataDocDTList tbody').append(tDisChgHDTemplate);
                JSxPOResetDisChgColIndex();
                $('.dischgselectpicker').selectpicker();
            }
            JSxPOCalcDisChg();

        }else{
            JCNxShowMsgSessionExpired();
        }
    }


    // Functionality : Remove Dis/Chg Row In Modal
    // Parameters : -
    // Creator : 03/07/2019 Wasin(Yoshi)
    // Last Modified : -
    // Return : -
    // Return Type : -
    function JSxPOResetDisChgRemoveRow(poEl){
        // var nStaSession = JCNxFuncChkSessionExpired();
        var nStaSession = 1;
        if(typeof nStaSession !== "undefined" && nStaSession == 1){
            $(poEl).parents('.xWPIDisChgTrTag').remove();
            if(JSbPOHasDisChgRow()){
                JSxPOResetDisChgColIndex();
            }else{
                $('#otrPODisChgHDNotFound, #otrPODisChgDTNotFound').removeClass('xCNHide');
            }
            JSxPOCalcDisChg();
        }else{
            JCNxShowMsgSessionExpired();
        }   
    }

    // Functionality : Functon Save Dis/Chg
    // Parameters : Event Click Button Save In Modal
    // Creator : 03/07/2019 Wasin(Yoshi)
    // Last Modified : -
    // Return : -
    // Return Type : None
    function JSxPODisChgSave(){
        // var nStaSession = JCNxFuncChkSessionExpired();
        var nStaSession = 1;
        if(typeof nStaSession !== "undefined" && nStaSession == 1){
            JCNxOpenLoading();
            var nPOODecimalShow = $('#ohdPOODecimalShow').val();
            var aDisChgItems        = [];
            var cBeforeDisChgSum    = 0.00;
            var cAfterDisChgSum     = 0.00;
            var tDisChgHD           = '';
            $('.xWPIDisChgTrTag').each(function(index){
                var tCreatedAt  = $(this).find('input.xWPIDisChgCreatedAt').val();
                var nSeqNo      = '';
                var tStaDis     = '';
                if(JCNbPOIsDisChgType('disChgDT')){
                    nSeqNo  = DisChgDataRowDT.tSeqNo;
                    tStaDis = DisChgDataRowDT.tStadis;
                }
                var cBeforeDisChg   = accounting.unformat($(this).find('td label.xWPIDisChgBeforeDisChg').text());
                var cAfterDisChg    = accounting.unformat($(this).find('td label.xWPIDisChgAfterDisChg').text());
                var cDisChgValue    = accounting.unformat($(this).find('td label.xWPIDisChgValue').text());
                var nDisChgType     = parseInt($(this).find('td select.xWPIDisChgType').val());
                var cDisChgNum      = accounting.unformat($(this).find('td input.xWPIDisChgNum').val());
                // Dis Chg Summary
                cBeforeDisChgSum    += parseFloat(cBeforeDisChg);
                cAfterDisChgSum     += parseFloat(cAfterDisChg);
                // Dis Chg Text
                var tDisChgTxt = '';
                switch(nDisChgType){
                    case 1 : {
                        tDisChgTxt  = '-' + numberWithCommas(cDisChgNum);    
                        break;
                    }
                    case 2 : {
                        tDisChgTxt  = '-' + numberWithCommas(cDisChgNum) + '%';
                        break;
                    }
                    case 3 : {
                        tDisChgTxt  = '+' + numberWithCommas(cDisChgNum);    
                        break;
                    }
                    case 4 : {
                        tDisChgTxt  = '+' + numberWithCommas(cDisChgNum) + '%';    
                        break;
                    }
                    default : {}
                }
                aDisChgItems.push({
                    'cBeforeDisChg' : cBeforeDisChg,
                    'cDisChgValue'  : cDisChgValue,
                    'cAfterDisChg'  : cAfterDisChg,
                    'nDisChgType'   : nDisChgType,
                    'cDisChgNum'    : cDisChgNum,
                    'tDisChgTxt'    : tDisChgTxt,
                    'tCreatedAt'    : tCreatedAt,
                    'nSeqNo'        : nSeqNo,
                    'tStaDis'       : tStaDis
                });


                if(tDisChgHD!=''){
                    tDisChgHD += ','+tDisChgTxt;
                }else{
                    tDisChgHD += tDisChgTxt;
                }
               
                
            });

            var oDisChgSummary  = {
                'cBeforeDisChgSum'  : cBeforeDisChgSum,
                'cAfterDisChgSum'   : cAfterDisChgSum
            };
            var nPOODecimalShow = $('#ohdPOODecimalShow').val();
            // Check Call In HD
            if(JCNbPOIsDisChgType('disChgHD')){
                // JCNxOpenLoading();
                $.ajax({
                    type: "POST",
                    url: "docPOAddEditHDDis",
                    data: {
                        'tBchCode'          : $('#oetPOFrmBchCode').val(),
                        'tDocNo'            : $('#oetPODocNo').val(),
                        'tVatInOrEx'        : $('#ocmPOFrmSplInfoVatInOrEx').val(), // 1: รวมใน, 2: แยกนอก
                        'tDisChgItems'      : JSON.stringify(aDisChgItems),
                        'tDisChgSummary'    : JSON.stringify(oDisChgSummary),
                        'ohdSesSessionID'   : $('#ohdSesSessionID').val(),
                        'ohdPOUsrCode'        : $('#ohdPOUsrCode').val(),
                        'ohdPOLangEdit'       : $('#ohdPOLangEdit').val(),
                        'ohdSesUsrLevel'      : $('#ohdSesUsrLevel').val(),
                        'ohdPOSesUsrBchCode'  : $('#ohdPOSesUsrBchCode').val(),
                    },
                    cache: false,
                    timeout: 0,
                    success: function(oResult){
                        var aReturnData = JSON.parse(oResult);
                        if(aReturnData['nStaEvent'] == '1'){
                            $('#odvPODisChgPanel').modal('hide');

                            var nDiscount = (cAfterDisChgSum-cBeforeDisChgSum);
                            console.log(nDiscount,"nDiscount");
                            $('#olbSumFCXtdAmt').text(numberWithCommas(parseFloat(nDiscount).toFixed(nPOODecimalShow)));
                            $('#olbDisChgHD').text(tDisChgHD);
                           

                            JSxRendercalculate();
                            JSvPOCallEndOfBill();
                            JCNxCloseLoading();
                            // JSvPOLoadPdtDataTableHtml();
                        }else{
                            var tMessageError = aReturnData['tStaMessg'];
                            $('#odvPODisChgPanel').modal('hide');
                            FSvCMNSetMsgErrorDialog(tMessageError);
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        JCNxResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            }

            // Check Call In DT
            if(JCNbPOIsDisChgType('disChgDT')){
                // JCNxOpenLoading();
                // console.log(JSON.stringify(aDisChgItems));
                // console.log(JSON.stringify(oDisChgSummary));
                // console.log(DisChgDataRowDT);
                $.ajax({
                    type : "POST",
                    url : "docPOAddEditDTDis",
                    data : {
                        'tSeqNo'            : DisChgDataRowDT.tSeqNo,
                        'tBchCode'          : $('#oetPOFrmBchCode').val(),
                        'tDocNo'            : $('#oetPODocNo').val(),
                        'tVatInOrEx'        : $('#ocmPOFrmSplInfoVatInOrEx').val(), // 1: รวมใน, 2: แยกนอก
                        'tDisChgItems'      : JSON.stringify(aDisChgItems),
                        'tDisChgSummary'    : JSON.stringify(oDisChgSummary),
                        'ohdSesSessionID'   : $('#ohdSesSessionID').val(),
                        'ohdPOUsrCode'        : $('#ohdPOUsrCode').val(),
                        'ohdPOLangEdit'       : $('#ohdPOLangEdit').val(),
                        'ohdSesUsrLevel'      : $('#ohdSesUsrLevel').val(),
                        'ohdPOSesUsrBchCode'  : $('#ohdPOSesUsrBchCode').val(),
                    },
                    cache: false,
                    timeout: 0,
                    success: function(tResult){
                        $('#odvPODisChgPanel').modal('hide');

                        var nSeq            = DisChgDataRowDT.tSeqNo;
                        var cAfterDisChg    = 0;
                        var tTextDisChgDT   = "";
                        for(var i=0;i<aDisChgItems.length;i++){
                            if(tTextDisChgDT == ""){
                                tTextDisChgDT = aDisChgItems[i].tDisChgTxt;
                            }else{
                                tTextDisChgDT = tTextDisChgDT + "," + aDisChgItems[i].tDisChgTxt;
                            }
                            cAfterDisChg = aDisChgItems[i].cAfterDisChg
                        }

                        $('#xWDisChgDTTmp'+nSeq).text(tTextDisChgDT);

                        if(cAfterDisChg == 0){
                            var nQty    = $('#ohdQty'+nSeq).val();
                            var cPrice  = $('#ohdPrice'+nSeq).val();
                            cAfterDisChg = parseFloat(nQty * cPrice);
                        }
                        $('#ospGrandTotal'+nSeq).text(numberWithCommas(parseFloat(cAfterDisChg).toFixed(2)));
                        $('.xWPdtItemList'+nSeq).attr('data-net',parseFloat(cAfterDisChg).toFixed(2));

                        if($('#olbDisChgHD').text() == ''){
                            $('#ospnetAfterHD'+nSeq).text(parseFloat(cAfterDisChg).toFixed(2));
                            $('.xWPdtItemList'+nSeq).attr('data-netafhd',parseFloat(cAfterDisChg).toFixed(2));
                        }

                        // console.log('#xWDisChgDTTmp'+DisChgDataRowDT.tSeqNo);
                        // var tTextDisChgDT = $('#xWDisChgDTTmp'+DisChgDataRowDT.tSeqNo).val();
                        // console.log(tTextDisChgDT);
                        // console.log(typeof(tTextDisChgDT));
                        // console.log(aDisChgItems);
                        // if(tTextDisChgDT == '' || tTextDisChgDT === undefined){
                        //     $('#xWDisChgDTTmp'+DisChgDataRowDT.tSeqNo).val(aDisChgItems.cDisChgNum);
                        // }else{
                        //     $('#xWDisChgDTTmp'+DisChgDataRowDT.tSeqNo).val(tTextDisChgDT + ',' + aDisChgItems.cDisChgNum);
                        // }
                        // console.log(tTextDisChgDT);
                        // console.log(typeof(tTextDisChgDT));
                        // aDisChgItems.cDisChgNum

                        JSxRendercalculate();
                        JCNxCloseLoading();
                        // JSvPOLoadPdtDataTableHtml();
                        // $('#odvPODisChgPanel').modal('hide');
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        JCNxResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            }
        }else{
            JCNxShowMsgSessionExpired();
        }
    }



</script>