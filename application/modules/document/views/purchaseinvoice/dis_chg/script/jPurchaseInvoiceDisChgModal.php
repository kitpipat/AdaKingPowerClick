<script type="text/javascript">
    
    // Functionality : Add/Update Modal DisChage
    // Parameters : route
    // Creator : 02/07/2019 Wasin(Yoshi)
    // Return : -
    // Return Type : -
    function JSxPIOpenDisChgPanel(poParams){
        $("#odvPIDisChgHDTable").html('');
        $("#odvPIDisChgDTTable").html('');

        if(poParams.DisChgType  == 'disChgHD'){
            $('#ohdPIDisChgType').val('disChgHD');
            $(".xWPIDisChgHeadPanel").text('<?php echo language('document/purchaseinvoice/purchaseinvoice','tPIAdvDiscountcharging');?>');
            JSxPIDisChgHDList(1);
        }

        if(poParams.DisChgType  == 'disChgDT'){
            $('#ohdPIDisChgType').val('disChgDT');
            $(".xWPIDisChgHeadPanel").text('<?php echo language('document/purchaseinvoice/purchaseinvoice','tPIAdvDiscountcharginglist');?>');
            JSxPIDisChgDTList(1);
        }

        $('#odvPIDisChgPanel').modal({backdrop: 'static', keyboard: false})  
        $('#odvPIDisChgPanel').modal('show');
        console.log('JCNbPIIsDisChgType HD: ', JCNbPIIsDisChgType('disChgHD'));
        console.log('JCNbPIIsDisChgType DT: ', JCNbPIIsDisChgType('disChgDT'));
    }

    // Functionality : Call PI HD List
    // Parameters : route
    // Creator : 02/07/2019 Wasin(Yoshi)
    // Update : -
    // Return : -
    // Return Type : -
    function JSxPIDisChgHDList(pnPage){
        JCNxOpenLoading();
        var nPageCurrent = pnPage;
        if (nPageCurrent == undefined || nPageCurrent == "") {
            nPageCurrent = "1";
        }
        var oAdvanceSearch = '';
        $.ajax({
            type: "POST",
            url: "dcmPIDisChgHDList",
            data: {
                'tBCHCode'          : $('#oetPIFrmBchCode').val(),
                'tDocNo'            : $('#oetPIDocNo').val(),
                'oAdvanceSearch'    : oAdvanceSearch,
                'nPageCurrent'      : nPageCurrent
            },
            cache: false,
            timeout: 0,
            success: function (tResult){
                var oResult = JSON.parse(tResult);
                $("#odvPIDisChgHDTable").html(oResult.tPIViewDataTableList);
                JCNxCloseLoading();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }

    // Functionality : Call PI Document DTDisChg List
    // Parameters : route
    // Creator : 02/07/2019 Wasin(Yoshi)
    // Return : -
    // Return Type : -
    function JSxPIDisChgDTList(pnPage){
        JCNxOpenLoading();
        var nPageCurrent = pnPage;
        if (nPageCurrent == undefined || nPageCurrent == "") {
            nPageCurrent = "1";
        }
        var oAdvanceSearch = '';
        $.ajax({
            type: "POST",
            url: "dcmPIDisChgDTList",
            data: {
                'tBCHCode'          : $('#oetPIFrmBchCode').val(),
                'tDocNo'            : $('#oetPIDocNo').val(),
                'tSeqNo'            : DisChgDataRowDT.tSeqNo,
                'oAdvanceSearch'    : oAdvanceSearch,
                'nPageCurrent'      : nPageCurrent
            },
            cache: false,
            timeout: 0,
            success: function (tResult){
                var oResult = JSON.parse(tResult);
                $("#odvPIDisChgDTTable").html(oResult.tPIViewDataTableList);
                JCNxCloseLoading();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }

    // Functionality : เปลี่ยนหน้า Pagenation Modal HD Dis/Chg 
    // Parameters : Event Click Pagenation Modal Dis/Chg HD 
    // Creator : 03/07/2019 Wasin(Yoshi)
    // Return : View Table Dis/Chg HD
    // Return Type : View
    function JSvPIDisChgHDClickPage(ptPage){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof nStaSession !== "undefined" && nStaSession == 1){
            var nPageCurrent    = "";
            switch(ptPage){
                case "next":
                    //กดปุ่ม Next
                    $("#odvPIHDList .xWBtnNext").addClass("disabled");
                    nPageOld        = $("#odvPIHDList .xWPage .active").text(); // Get เลขก่อนหน้า
                    nPageNew        = parseInt(nPageOld, 10) + 1; // +1 จำนวน
                    nPageCurrent    = nPageNew;
                    break;
                break;
                case "previous":
                    //กดปุ่ม Previous
                    nPageOld        = $("#odvPIHDList .xWPage .active").text(); // Get เลขก่อนหน้า
                    nPageNew        = parseInt(nPageOld, 10) - 1; // -1 จำนวน
                    nPageCurrent    = nPageNew;
                break;
                default:
                    nPageCurrent    = ptPage;
            }
            JSxPIDisChgHDList(nPageCurrent);
        }else{
            JCNxShowMsgSessionExpired();
        }
    }

    // Functionality : เปลี่ยนหน้า Pagenation Modal DT Dis/Chg 
    // Parameters : Event Click Pagenation Modal Dis/Chg DT 
    // Creator : 03/07/2019 Wasin(Yoshi)
    // Return : View Table Dis/Chg DT
    // Return Type : View
    function JSvPIDisChgDTClickPage(ptPage){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof nStaSession !== "undefined" && nStaSession == 1){
            var nPageCurrent    = "";
            switch(ptPage){
                case "next":
                    //กดปุ่ม Next
                    $("#odvPIDTList .xWBtnNext").addClass("disabled");
                    nPageOld        = $("#odvPIDTList .xWPage .active").text(); // Get เลขก่อนหน้า
                    nPageNew        = parseInt(nPageOld, 10) + 1; // +1 จำนวน
                    nPageCurrent    = nPageNew;
                break;
                case "previous":
                    //กดปุ่ม Previous
                    nPageOld        = $("#odvPIDTList .xWPage .active").text(); // Get เลขก่อนหน้า
                    nPageNew        = parseInt(nPageOld, 10) - 1; // -1 จำนวน
                    nPageCurrent    = nPageNew;
                break;
                default:
                    nPageCurrent    = ptPage;
            }
            JSxPIDisChgDTList(nPageCurrent);
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
    function JSxPICalcDisChg(){
        console.log('Calc');
        var bLimitBeforeDisChg  = true;
        $('.xWPIDisChgTrTag').each(function(index){
            if($('.xWPIDisChgTrTag').length == 1){
                $('img.xWPIDisChgRemoveIcon').first().attr('onclick','JSxPIResetDisChgRemoveRow(this)').css('opacity', '1');
            }else{
                $('img.xWPIDisChgRemoveIcon').first().attr('onclick','').css('opacity','0.2');
            }

            if(bLimitBeforeDisChg){
                if(JCNbPIIsDisChgType('disChgDT')){
                    let cBeforeDisChg = (parseFloat(DisChgDataRowDT.tQty) * parseFloat(DisChgDataRowDT.tSetPrice))
                    $(this).find('td label.xWPIDisChgBeforeDisChg').first().text(accounting.formatNumber(cBeforeDisChg, 2, ','));
                }
                if(JCNbPIIsDisChgType('disChgHD')){
                    // let cBeforeDisChg = $('label#olbPISumFCXtdNet').text();
                    let cBeforeDisChg = $('#olbPISumFCXtdNet').text();
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
        });
    }

    // Functionality : Is Dis Chg Type
    // Parameters : -
    // Creator : 02/07/2019 Wasin(Yoshi)
    // Last Modified : -
    // Return : Status true is create page
    // Return Type : Boolean
    function JCNbPIIsDisChgType(ptDisChgType){
        try{
            var tPIDisChgType = $('#ohdPIDisChgType').val();
            var bStatus = false;
            if(ptDisChgType == "disChgHD"){
                if(tPIDisChgType == "disChgHD"){ // No have data
                    bStatus = true;
                }
            }
            if(ptDisChgType == "disChgDT"){
                if(tPIDisChgType == "disChgDT"){ // No have data
                    bStatus = true;
                }
            }
            return bStatus;
        }catch(err){
            console.log('JCNbPIIsCreatePage Error: ', err);
        }
    }

    // Functionality : ตรวจสอบว่ามีแถวอยู่หรือไม่ ในการทำรายการลดชาร์จ
    // Parameters : -
    // Creator : 03/07/2019 Wasin(Yoshi)
    // Last Modified : -
    // Return : Status Check Row Dis/Chg
    // Return Type : Boolean
    function JSbPIHasDisChgRow(){
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
    function JStPISetTrBody(pcBeforeDisChg, pcDisChgValue, pcAfterDisChg){
        console.log("JStPISetTrBody", pcBeforeDisChg);
        let tTemplate   = $("#oscPITrBodyTemplate").html();
        let oData       = {
            'cBeforeDisChg' : pcBeforeDisChg,
            'cDisChgValue'  : pcDisChgValue,
            'cAfterDisChg'  : pcAfterDisChg
        };
        let tRender     = JStPIRenderTemplate(tTemplate,oData);
        return tRender;
    }

    // Functionality : Replace Value to template
    // Parameters : -
    // Creator : 03/07/2019 Wasin(Yoshi)
    // Last Modified : -
    // Return : String Template Html Row Dis/Chg
    // Return Type : String
    function JStPIRenderTemplate(tTemplate,oData){
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
    function JSxPIResetDisChgColIndex(){
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
    function JCNxPIDisChgSetCreateAt(poEl){
        $(poEl).parents('tr.xWPIDisChgTrTag').find('input.xWPIDisChgCreatedAt').val(moment().format('DD-MM-YYYY HH:mm:ss'));
        console.log('DATE: ', $( poEl).parents('tr.xWPIDisChgTrTag').find('input.xWPIDisChgCreatedAt').val());    
    }

    // Functionality : Add Row Data Dis/Chg HD And DT
    // Parameters : -
    // Creator : 03/07/2019 Wasin(Yoshi)
    // Last Modified : -
    // Return : Row Dis/Chg In Modal
    // Return Type : None
    function JCNvPIAddDisChgRow(poEl){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof nStaSession !== "undefined" && nStaSession == 1) {

            cSumFCXtdNet = $('#olbPISumFCXtdNetAlwDis').val();

            // Check Append Row Dis/chg HD
            if(JCNbPIIsDisChgType('disChgHD')){
                var tDisChgHDTemplate;
                if(JSbPIHasDisChgRow()){
                    var oLastRow            = $('.xWPIDisChgTrTag').last();
                    var cAfterDisChgLastRow = oLastRow.find('td label.xWPIDisChgAfterDisChg').text();
                    tDisChgHDTemplate       = JStPISetTrBody(cAfterDisChgLastRow,'0.00','0.00');     
                }else{
                    tDisChgHDTemplate       = JStPISetTrBody(cSumFCXtdNet,'0.00', '0.00');
                }

                $('#otrPIDisChgHDNotFound').addClass('xCNHide');
                $('#otbPIDisChgDataDocHDList tbody').append(tDisChgHDTemplate);
                JSxPIResetDisChgColIndex();
                JCNxPIDisChgSetCreateAt(poEl);
                $('.dischgselectpicker').selectpicker();
            }
            
            // Check Append Row Dis/chg DT
            if(JCNbPIIsDisChgType('disChgDT')){
                console.log('DisChgDataRowDT: ',DisChgDataRowDT);
                var tDisChgHDTemplate;
                var cSumFCXtdNet    = accounting.formatNumber(DisChgDataRowDT.tNet, 2, ',');
                if(JSbPIHasDisChgRow()){
                    var oLastRow            = $('.xWPIDisChgTrTag').last();
                    var cAfterDisChgLastRow = oLastRow.find('td label.xWPIDisChgAfterDisChg').text();
                    tDisChgHDTemplate       = JStPISetTrBody(cAfterDisChgLastRow, '0.00', '0.00');
                }else{
                    tDisChgHDTemplate       = JStPISetTrBody(cSumFCXtdNet, '0.00', '0.00');
                }

                $('#otrPIDisChgDTNotFound').addClass('xCNHide');
                $('#otbPIDisChgDataDocDTList tbody').append(tDisChgHDTemplate);
                JSxPIResetDisChgColIndex();
                $('.dischgselectpicker').selectpicker();
                console.log('cSumFCXtdNet: ', cSumFCXtdNet);
            }
            JSxPICalcDisChg();
                    
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
    function JSxPIResetDisChgRemoveRow(poEl){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof nStaSession !== "undefined" && nStaSession == 1){
            $(poEl).parents('.xWPIDisChgTrTag').remove();
            if(JSbPIHasDisChgRow()){
                JSxPIResetDisChgColIndex();
            }else{
                $('#otrPIDisChgHDNotFound, #otrPIDisChgDTNotFound').removeClass('xCNHide');
            }
            JSxPICalcDisChg();
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
    function JSxPIDisChgSave(){
        // var nStaSession = JCNxFuncChkSessionExpired();
        var nStaSession = 1;
        if(typeof nStaSession !== "undefined" && nStaSession == 1){
            var aDisChgItems        = [];
            var cBeforeDisChgSum    = 0.00;
            var cAfterDisChgSum     = 0.00;

            $('.xWPIDisChgTrTag').each(function(index){
                var tCreatedAt  = $(this).find('input.xWPIDisChgCreatedAt').val();
                var nSeqNo      = '';
                var tStaDis     = '';
                if(JCNbPIIsDisChgType('disChgDT')){
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
            });

            var oDisChgSummary  = {
                'cBeforeDisChgSum'  : cBeforeDisChgSum,
                'cAfterDisChgSum'   : cAfterDisChgSum
            };

            // Check Call In HD
            if(JCNbPIIsDisChgType('disChgHD')){
                JCNxOpenLoading();
                $.ajax({
                    type: "POST",
                    url: "dcmPIAddEditHDDis",
                    data: {
                        'tBchCode'          : $('#oetPIFrmBchCode').val(),
                        'tDocNo'            : $('#oetPIDocNo').val(),
                        'tVatInOrEx'        : $('#ocmPIFrmSplInfoVatInOrEx').val(), // 1: รวมใน, 2: แยกนอก
                        'tDisChgItems'      : JSON.stringify(aDisChgItems),
                        'tDisChgSummary'    : JSON.stringify(oDisChgSummary)
                    },
                    cache: false,
                    timeout: 0,
                    success: function(oResult){
                        var aReturnData = JSON.parse(oResult);
                        if(aReturnData['nStaEvent'] == '1'){
                            $('#odvPIDisChgPanel').modal('hide');
                            JSvPILoadPdtDataTableHtml();
                        }else{
                            var tMessageError = aReturnData['tStaMessg'];
                            $('#odvPIDisChgPanel').modal('hide');
                            FSvCMNSetMsgErrorDialog(tMessageError);
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        JCNxResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            }

            // Check Call In DT
            if(JCNbPIIsDisChgType('disChgDT')){
                JCNxOpenLoading();
                $.ajax({
                    type : "POST",
                    url : "dcmPIAddEditDTDis",
                    data : {
                        'tSeqNo'            : DisChgDataRowDT.tSeqNo,
                        'tBchCode'          : $('#oetPIFrmBchCode').val(),
                        'tDocNo'            : $('#oetPIDocNo').val(),
                        'tVatInOrEx'        : $('#ocmPIFrmSplInfoVatInOrEx').val(), // 1: รวมใน, 2: แยกนอก
                        'tDisChgItems'      : JSON.stringify(aDisChgItems),
                        'tDisChgSummary'    : JSON.stringify(oDisChgSummary)
                    },
                    cache: false,
                    timeout: 0,
                    success: function(tResult){
                        console.log(tResult);
                        JSvPILoadPdtDataTableHtml();
                        $('#odvPIDisChgPanel').modal('hide');
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