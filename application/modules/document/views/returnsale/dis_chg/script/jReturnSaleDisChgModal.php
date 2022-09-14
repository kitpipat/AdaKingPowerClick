<script type="text/javascript">
    var nOptDecimalSave = $('#ohdOptDecimalSave').val();
    var nOptDecimalShow = $('#ohdOptDecimalShow').val();
    // Functionality : Add/Update Modal DisChage
    // Parameters : route
    // Creator : 02/07/2019 Wasin(Yoshi)
    // Return : -
    // Return Type : -
    function JSxRSOpenDisChgPanel(poParams){
        $("#odvRSDisChgHDTable").html('');
        $("#odvRSDisChgDTTable").html('');

        if(poParams.DisChgType  == 'disChgHD'){
            $('#ohdRSDisChgType').val('disChgHD');
            $(".xWPIDisChgHeadPanel").text('<?php echo language('document/returnsale/returnsale','tRSAdvDiscountcharging');?>');
            JSxRSDisChgHDList(1);
        }

        if(poParams.DisChgType  == 'disChgDT'){
            $('#ohdRSDisChgType').val('disChgDT');
            $(".xWPIDisChgHeadPanel").text('<?php echo language('document/returnsale/returnsale','tRSAdvDiscountcharginglist');?>');
            JSxRSDisChgDTList(1);
        }

        $('#odvRSDisChgPanel').modal({backdrop: 'static', keyboard: false})  
        $('#odvRSDisChgPanel').modal('show');
        console.log('JCNbRSIsDisChgType HD: ', JCNbRSIsDisChgType('disChgHD'));
        console.log('JCNbRSIsDisChgType DT: ', JCNbRSIsDisChgType('disChgDT'));
    }

    // Functionality : Call PI HD List
    // Parameters : route
    // Creator : 02/07/2019 Wasin(Yoshi)
    // Update : -
    // Return : -
    // Return Type : -
    function JSxRSDisChgHDList(pnPage){
        JCNxOpenLoading();
        var nPageCurrent = pnPage;
        if (nPageCurrent == undefined || nPageCurrent == "") {
            nPageCurrent = "1";
        }
        var oAdvanceSearch = '';
        $.ajax({
            type: "POST",
            url: "dcmRSDisChgHDList",
            data: {
                'tDocNo'            : $('#oetRSDocNo').val(),
                'tSelectBCH'        : $('#oetRSFrmBchCode').val(),
                'oAdvanceSearch'    : oAdvanceSearch,
                'nPageCurrent'      : nPageCurrent,
                'tRSSesSessionID'   : $('#ohdSesSessionID').val(),
                'tRSUsrCode'        : $('#ohdRSUsrCode').val(),
                'tRSLangEdit'       : $('#ohdRSLangEdit').val(),
                'tSesUsrLevel'      : $('#ohdSesUsrLevel').val(),
        },
            cache: false,
            timeout: 0,
            success: function (tResult){
                var oResult = JSON.parse(tResult);
                $("#odvRSDisChgHDTable").html(oResult.tRSViewDataTableList);
                JCNxCloseLoading();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                // JCNxResponseError(jqXHR, textStatus, errorThrown);
                JSxRSDisChgHDList(pnPage);
            }
        });
    }

    // Functionality : Call PI Document DTDisChg List
    // Parameters : route
    // Creator : 02/07/2019 Wasin(Yoshi)
    // Return : -
    // Return Type : -
    function JSxRSDisChgDTList(pnPage){
        JCNxOpenLoading();
        var nPageCurrent = pnPage;
        if (nPageCurrent == undefined || nPageCurrent == "") {
            nPageCurrent = "1";
        }
        var oAdvanceSearch = '';
        $.ajax({
            type: "POST",
            url: "dcmRSDisChgDTList",
            data: {
                'tSelectBCH'        : $('#oetRSFrmBchCode').val(),
                'tDocNo'            : $('#oetRSDocNo').val(),
                'tSeqNo'            : DisChgDataRowDT.tSeqNo,
                'oAdvanceSearch'    : oAdvanceSearch,
                'nPageCurrent'      : nPageCurrent,
                'tRSSesSessionID'   : $('#ohdSesSessionID').val(),
                'tRSUsrCode'        : $('#ohdRSUsrCode').val(),
                'tRSLangEdit'       : $('#ohdRSLangEdit').val(),
                'tSesUsrLevel'      : $('#ohdSesUsrLevel').val(),
            },
            cache: false,
            timeout: 0,
            success: function (tResult){
                var oResult = JSON.parse(tResult);
                $("#odvRSDisChgDTTable").html(oResult.tRSViewDataTableList);
                JCNxCloseLoading();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                // JCNxResponseError(jqXHR, textStatus, errorThrown);
                JSxRSDisChgDTList(pnPage);
            }
        });
    }

    // Functionality : เปลี่ยนหน้า Pagenation Modal HD Dis/Chg 
    // Parameters : Event Click Pagenation Modal Dis/Chg HD 
    // Creator : 03/07/2019 Wasin(Yoshi)
    // Return : View Table Dis/Chg HD
    // Return Type : View
    function JSvRSDisChgHDClickPage(ptPage){
        // var nStaSession = JCNxFuncChkSessionExpired();
        var nStaSession = 1;
        if(typeof nStaSession !== "undefined" && nStaSession == 1){
            var nPageCurrent    = "";
            switch(ptPage){
                case "next":
                    //กดปุ่ม Next
                    $("#odvRSHDList .xWBtnNext").addClass("disabled");
                    nPageOld        = $("#odvRSHDList .xWPage .active").text(); // Get เลขก่อนหน้า
                    nPageNew        = parseInt(nPageOld, 10) + 1; // +1 จำนวน
                    nPageCurrent    = nPageNew;
                    break;
                break;
                case "previous":
                    //กดปุ่ม Previous
                    nPageOld        = $("#odvRSHDList .xWPage .active").text(); // Get เลขก่อนหน้า
                    nPageNew        = parseInt(nPageOld, 10) - 1; // -1 จำนวน
                    nPageCurrent    = nPageNew;
                break;
                default:
                    nPageCurrent    = ptPage;
            }
            JSxRSDisChgHDList(nPageCurrent);
        }else{
            JCNxShowMsgSessionExpired();
        }
    }

    // Functionality : เปลี่ยนหน้า Pagenation Modal DT Dis/Chg 
    // Parameters : Event Click Pagenation Modal Dis/Chg DT 
    // Creator : 03/07/2019 Wasin(Yoshi)
    // Return : View Table Dis/Chg DT
    // Return Type : View
    function JSvRSDisChgDTClickPage(ptPage){
        // var nStaSession = JCNxFuncChkSessionExpired();
        var nStaSession = 1; 
        if(typeof nStaSession !== "undefined" && nStaSession == 1){
            var nPageCurrent    = "";
            switch(ptPage){
                case "next":
                    //กดปุ่ม Next
                    $("#odvRSDTList .xWBtnNext").addClass("disabled");
                    nPageOld        = $("#odvRSDTList .xWPage .active").text(); // Get เลขก่อนหน้า
                    nPageNew        = parseInt(nPageOld, 10) + 1; // +1 จำนวน
                    nPageCurrent    = nPageNew;
                break;
                case "previous":
                    //กดปุ่ม Previous
                    nPageOld        = $("#odvRSDTList .xWPage .active").text(); // Get เลขก่อนหน้า
                    nPageNew        = parseInt(nPageOld, 10) - 1; // -1 จำนวน
                    nPageCurrent    = nPageNew;
                break;
                default:
                    nPageCurrent    = ptPage;
            }
            JSxRSDisChgDTList(nPageCurrent);
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
    function JSxRSCalcDisChg(){
        console.log('Calc');
        var bLimitBeforeDisChg  = true;
        $('.xWPIDisChgTrTag').each(function(index){
            if($('.xWPIDisChgTrTag').length == 1){
                $('img.xWPIDisChgRemoveIcon').first().attr('onclick','JSxRSResetDisChgRemoveRow(this)').css('opacity', '1');
            }else{
                $('img.xWPIDisChgRemoveIcon').first().attr('onclick','').css('opacity','0.2');
            }

            if(bLimitBeforeDisChg){
                if(JCNbRSIsDisChgType('disChgDT')){
                    let cBeforeDisChg = (parseFloat(DisChgDataRowDT.tQty) * parseFloat(DisChgDataRowDT.tSetPrice));
                    console.log('TT : ' + cBeforeDisChg);
                    $(this).find('td label.xWPIDisChgBeforeDisChg').first().text(accounting.formatNumber(cBeforeDisChg, 2, ','));
                }
                if(JCNbRSIsDisChgType('disChgHD')){
                    // let cBeforeDisChg = $('label#olbSOSumFCXtdNet').text();
                    let cBeforeDisChg = $('#olbSumFCXtdNetAlwDis').val();
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
    function JCNbRSIsDisChgType(ptDisChgType){
        try{
            var tRSDisChgType = $('#ohdRSDisChgType').val();
            var bStatus = false;
            if(ptDisChgType == "disChgHD"){
                if(tRSDisChgType == "disChgHD"){ // No have data
                    bStatus = true;
                }
            }
            if(ptDisChgType == "disChgDT"){
                if(tRSDisChgType == "disChgDT"){ // No have data
                    bStatus = true;
                }
            }
            return bStatus;
        }catch(err){
            console.log('JCNbRSIsCreatePage Error: ', err);
        }
    }

    // Functionality : ตรวจสอบว่ามีแถวอยู่หรือไม่ ในการทำรายการลดชาร์จ
    // Parameters : -
    // Creator : 03/07/2019 Wasin(Yoshi)
    // Last Modified : -
    // Return : Status Check Row Dis/Chg
    // Return Type : Boolean
    function JSbRSHasDisChgRow(){
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
    function JStRSSetTrBody(pcBeforeDisChg, pcDisChgValue, pcAfterDisChg){
        console.log("JStRSSetTrBody", pcBeforeDisChg);
        let tTemplate   = $("#oscRSTrBodyTemplate").html();
        let oData       = {
            'cBeforeDisChg' : pcBeforeDisChg,
            'cDisChgValue'  : pcDisChgValue,
            'cAfterDisChg'  : pcAfterDisChg
        };
        let tRender     = JStRSRenderTemplate(tTemplate,oData);
        return tRender;
    }

    // Functionality : Replace Value to template
    // Parameters : -
    // Creator : 03/07/2019 Wasin(Yoshi)
    // Last Modified : -
    // Return : String Template Html Row Dis/Chg
    // Return Type : String
    function JStRSRenderTemplate(tTemplate,oData){
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
    function JSxRSResetDisChgColIndex(){
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
    function JCNxRSDisChgSetCreateAt(poEl){
        $(poEl).parents('tr.xWPIDisChgTrTag').find('input.xWPIDisChgCreatedAt').val(moment().format('DD-MM-YYYY HH:mm:ss'));
        console.log('DATE: ', $(poEl).parents('tr.xWPIDisChgTrTag').find('input.xWPIDisChgCreatedAt').val());    
    }

    // Functionality : Add Row Data Dis/Chg HD And DT
    // Parameters : -
    // Creator : 03/07/2019 Wasin(Yoshi)
    // Last Modified : -
    // Return : Row Dis/Chg In Modal
    // Return Type : None
    function JCNvRSAddDisChgRow(poEl){
        // var nStaSession = JCNxFuncChkSessionExpired();
           var  nStaSession = 1;
        if(typeof nStaSession !== "undefined" && nStaSession == 1) {

            //หาราคาที่อนุญาติลดเท่านั้น - วัฒน์
            var cSumFCXtdNet = $('#olbSumFCXtdNetAlwDis').val();
            
            // Check Append Row Dis/chg HD
            if(JCNbRSIsDisChgType('disChgHD')){
                var tDisChgHDTemplate;
                if(JSbRSHasDisChgRow()){
                    var oLastRow            = $('.xWPIDisChgTrTag').last();
                    var cAfterDisChgLastRow = oLastRow.find('td label.xWPIDisChgAfterDisChg').text();
                    tDisChgHDTemplate       = JStRSSetTrBody(cAfterDisChgLastRow,'0.00','0.00');     
                }else{
                    tDisChgHDTemplate       = JStRSSetTrBody(cSumFCXtdNet,'0.00', '0.00');
                }

                $('#otrRSDisChgHDNotFound').addClass('xCNHide');
                $('#otbRSDisChgDataDocHDList tbody').append(tDisChgHDTemplate);
                JSxRSResetDisChgColIndex();
                JCNxRSDisChgSetCreateAt(poEl);
                $('.dischgselectpicker').selectpicker();
            }
            
            // Check Append Row Dis/chg DT
            if(JCNbRSIsDisChgType('disChgDT')){
                var tDisChgHDTemplate;
                var cSumFCXtdNet    = accounting.formatNumber(DisChgDataRowDT.tNet, 2, ',');
                if(JSbRSHasDisChgRow()){
                    var oLastRow            = $('.xWPIDisChgTrTag').last();
                    var cAfterDisChgLastRow = oLastRow.find('td label.xWPIDisChgAfterDisChg').text();
                    tDisChgHDTemplate       = JStRSSetTrBody(cAfterDisChgLastRow, '0.00', '0.00');
                }else{
                    tDisChgHDTemplate       = JStRSSetTrBody(cSumFCXtdNet, '0.00', '0.00');
                }

                $('#otrRSDisChgDTNotFound').addClass('xCNHide');
                $('#otbRSDisChgDataDocDTList tbody').append(tDisChgHDTemplate);
                JSxRSResetDisChgColIndex();
                $('.dischgselectpicker').selectpicker();
            }
            JSxRSCalcDisChg();

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
    function JSxRSResetDisChgRemoveRow(poEl){
        // var nStaSession = JCNxFuncChkSessionExpired();
        var nStaSession = 1;
        if(typeof nStaSession !== "undefined" && nStaSession == 1){
            $(poEl).parents('.xWPIDisChgTrTag').remove();
            if(JSbRSHasDisChgRow()){
                JSxRSResetDisChgColIndex();
            }else{
                $('#otrRSDisChgHDNotFound, #otrRSDisChgDTNotFound').removeClass('xCNHide');
            }
            JSxRSCalcDisChg();
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
    function JSxRSDisChgSave(){
        // var nStaSession = JCNxFuncChkSessionExpired();
        var nStaSession = 1;
        if(typeof nStaSession !== "undefined" && nStaSession == 1){
            JCNxOpenLoading();
            var aDisChgItems        = [];
            var cBeforeDisChgSum    = 0.00;
            var cAfterDisChgSum     = 0.00;
            var tDisChgHD           = '';
            $('.xWPIDisChgTrTag').each(function(index){
                var tCreatedAt  = $(this).find('input.xWPIDisChgCreatedAt').val();
                var nSeqNo      = '';
                var tStaDis     = '';
                if(JCNbRSIsDisChgType('disChgDT')){
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
                        tDisChgTxt  = '-' + cDisChgNum;    
                        break;
                    }
                    case 2 : {
                        tDisChgTxt  = '-' + cDisChgNum + '%';
                        break;
                    }
                    case 3 : {
                        tDisChgTxt  = '+' + cDisChgNum;    
                        break;
                    }
                    case 4 : {
                        tDisChgTxt  = '+' + cDisChgNum + '%';    
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

            // Check Call In HD
            if(JCNbRSIsDisChgType('disChgHD')){
                // JCNxOpenLoading();
                $.ajax({
                    type: "POST",
                    url: "dcmRSAddEditHDDis",
                    data: {
                        'tBchCode'          : $('#oetRSFrmBchCode').val(),
                        'tDocNo'            : $('#oetRSDocNo').val(),
                        'tVatInOrEx'        : $('#ocmRSFrmSplInfoVatInOrEx').val(), // 1: รวมใน, 2: แยกนอก
                        'tDisChgItems'      : JSON.stringify(aDisChgItems),
                        'tDisChgSummary'    : JSON.stringify(oDisChgSummary),
                        'ohdSesSessionID'   : $('#ohdSesSessionID').val(),
                        'ohdRSUsrCode'        : $('#ohdRSUsrCode').val(),
                        'ohdRSLangEdit'       : $('#ohdRSLangEdit').val(),
                        'ohdSesUsrLevel'      : $('#ohdSesUsrLevel').val(),
                        'ohdRSSesUsrBchCode'  : $('#ohdRSSesUsrBchCode').val(),
                    },
                    cache: false,
                    timeout: 0,
                    success: function(oResult){
                        var aReturnData = JSON.parse(oResult);
                        if(aReturnData['nStaEvent'] == '1'){
                            $('#odvRSDisChgPanel').modal('hide');

                            var nDiscount = (cAfterDisChgSum-cBeforeDisChgSum);
                            console.log(nDiscount,"nDiscount");
                            $('#olbSumFCXtdAmt').text(numberWithCommas(parseFloat(nDiscount).toFixed(nOptDecimalShow)));
                            $('#olbDisChgHD').text(tDisChgHD);
                           

                            JSxRendercalculate();
                            JCNxCloseLoading();
                            // JSvRSLoadPdtDataTableHtml();
                        }else{
                            var tMessageError = aReturnData['tStaMessg'];
                            $('#odvRSDisChgPanel').modal('hide');
                            FSvCMNSetMsgErrorDialog(tMessageError);
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        JCNxResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            }

            // Check Call In DT
            if(JCNbRSIsDisChgType('disChgDT')){
                // JCNxOpenLoading();
                // console.log(JSON.stringify(aDisChgItems));
                // console.log(JSON.stringify(oDisChgSummary));
                // console.log(DisChgDataRowDT);
                $.ajax({
                    type : "POST",
                    url : "dcmRSAddEditDTDis",
                    data : {
                        'tSeqNo'            : DisChgDataRowDT.tSeqNo,
                        'tBchCode'          : $('#oetRSFrmBchCode').val(),
                        'tDocNo'            : $('#oetRSDocNo').val(),
                        'tVatInOrEx'        : $('#ocmRSFrmSplInfoVatInOrEx').val(), // 1: รวมใน, 2: แยกนอก
                        'tDisChgItems'      : JSON.stringify(aDisChgItems),
                        'tDisChgSummary'    : JSON.stringify(oDisChgSummary),
                        'ohdSesSessionID'   : $('#ohdSesSessionID').val(),
                        'ohdRSUsrCode'        : $('#ohdRSUsrCode').val(),
                        'ohdRSLangEdit'       : $('#ohdRSLangEdit').val(),
                        'ohdSesUsrLevel'      : $('#ohdSesUsrLevel').val(),
                        'ohdRSSesUsrBchCode'  : $('#ohdRSSesUsrBchCode').val(),
                    },
                    cache: false,
                    timeout: 0,
                    success: function(tResult){
                        $('#odvRSDisChgPanel').modal('hide');

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
                        $('#ospGrandTotal'+nSeq).text(numberWithCommas(parseFloat(cAfterDisChg).toFixed(nOptDecimalShow)));
                        $('.xWPdtItemList'+nSeq).attr('data-net',parseFloat(cAfterDisChg).toFixed(nOptDecimalSave));

                        if($('#olbDisChgHD').text() == ''){
                            $('#ospnetAfterHD'+nSeq).text(parseFloat(cAfterDisChg).toFixed(nOptDecimalShow));
                            $('.xWPdtItemList'+nSeq).attr('data-netafhd',parseFloat(cAfterDisChg).toFixed(nOptDecimalSave));
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
                        // JSvRSLoadPdtDataTableHtml();
                        // $('#odvRSDisChgPanel').modal('hide');
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