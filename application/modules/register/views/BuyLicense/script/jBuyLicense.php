<script>
    $('document').ready(function(){
        JCNxOpenLoading();
        localStorage.removeItem('LocalItemData');
        JSxCheckPinMenuClose();
        JSvCallPageBuyLicenseList();
    });

    //หน้าหลัก
    function JSvCallPageBuyLicenseList(){
        $.ajax({
            type    : "POST",
            url     : "BuyLicenseList",
            cache   : false,
            data    : {'tTypepage' : '<?=$tTypepage?>'},
            timeout : 0,
            success : function(tResult){
                JCNxCloseLoading();
                if('<?=$tTypepage?>' == 2){ //ต่ออายุ
                    //ไม่ต้องโหลด page
                }else if('<?=$tTypepage?>' == 3){ //หน้า AddOn 
                    //ไม่ต้องโหลด page
                }else{
                    $('#odvContentPageBuylicense').html(tResult);

                    //Control ปุ่ม
                    $('.xCNBTNControlStep1').show();
                    $('.xCNBTNControlStep2').hide();
                    $('.xCNBTNControlStep3').hide();
                    $('.xCNBTNControlStep4').hide();
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }

    //กลับหน้าจอลงทะเบียน
    function JSxVCallPageInformation(){
        $.ajax({
            url     : 'ImformationRegister',
            type    : "POST",
            error   : function (jqXHR, textStatus, errorThrown) {
                JCNxCloseLoading();
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            },
            success : function (tView) {
                $(window).scrollTop(0);
                $('.odvMainContent').html(tView);
            }
        });
    }

    //ValidateEmail
    function validateEmail(email) {
        const re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(email);
    }

    //ไป Step2 - AddOn
    function JSxNextStepToPageAddOn(ptType){

        //ถ้ากดย้อนกลับ แบบเข้ามาจากการต่ออายุ
        if('<?=$tTypepage?>' == 2){
            JSxVCallPageInformation();
            return;
        }

        //ถ้าไม่มีการกรอกข้อมูลชื่อ
        if('<?=$tTypepage?>' == 1){ //ลงทะเบียน
            if($('#oetBuyName').val() == ''){
                $('#oetBuyName').focus();
                return;
            }

            //ถ้าไม่มีการกรอกข้อมูลอีเมล
            if($('#oetBuyEmail').val() == ''){
                $('#oetBuyEmail').focus();
                return;
            }else{
                var tEmail = validateEmail($('#oetBuyEmail').val());
                if(tEmail == false){
                    $("#oetBuyEmail-error").css('display','block');
                    return;
                }
            }

            //ถ้าไม่มีการกรอกเบอร์โทร
            if($('#oetBuyTel').val() == ''){
                $('#oetBuyTel').focus();
                return;
            }else if($('#oetBuyTel').val().length < 6){
                $('#oetBuyTel').focus();
                FSvCMNSetMsgWarningDialog('<?=language('register/buylicense/buylicense','tValidateTel6')?>');
                return;
            }

            //ไม่ได้เลือก package
            // if($('#ohdValuePackage').val() == '' || $('#ohdValuePackage').val() == null){
            //     $('#odvModalSelectedPackage').modal('show');
            //     return;
            // }
        }

        //ถ้ากดย้อนกลับ แบบเข้ามาจากการต่ออายุ
        if('<?=$tTypepage?>' == 0 && '<?=$this->session->userdata("tSessionCstPackageCode")?>' == 'P00001'){ //Demo ไม่สามารถเลือก Add-On ได้
            if(ptType == 'Next'){
                if($('#ohdValuePackage').val() == '' || $('#ohdValuePackage').val() == null){
                    $('#odvModalDemoCantSeletedAddOn').modal('show');
                    return;
                }
            }
        }else if('<?=$tTypepage?>' == 0){ //ไม่ได้เลือก package
            if(ptType == 'Next'){
                if($('#ohdValuePackage').val() == '' || $('#ohdValuePackage').val() == null){
                    $('#odvModalSelectedPackage').modal('show');
                    return;
                }
            }
        }

        //ข้อมูลแพ๊คเกจ
        var aPackage = [];
        var nValuePackage       = $('#ohdValuePackage').val();
        if(nValuePackage == '' || nValuePackage == null || nValuePackage == undefined){
            
        }else{
            var nTablePackagelength = $('#otbPackage tbody tr').length;
            for(var i=0; i<nTablePackagelength; i++){
                var tTitlePackage       = $('.xPackage' + nValuePackage).text();
                var nPricePackage       = $('.xPackagePrice' + nValuePackage).data('alwseleted');
                if(nPricePackage == 0){ //ไม่มีราคา
                    var tPricePackage   = $('.xPackagePrice' + nValuePackage).text().trim();
                    var aHiddenPackage  = $('#xCNValue' + nValuePackage).data('detailpackage');
                    var tMonth          = '-';
                    var tPDTSetPdtCode  = aHiddenPackage.rtPdtCode;
                    var tPDTSetPunCode  = aHiddenPackage.rtPunCode;
                    var tPDTSetPunName  = aHiddenPackage.rtPunName;
                    var tUnitFact       = aHiddenPackage.rcUnitFact;
                }else{
                    var tPricePackage   = $('.xPackagePrice' + nValuePackage).find('option:selected').text();
                    var aMountPackage   = tPricePackage.split("/");
                    var tPricePackage   = aMountPackage[0].trim();
                    var tMonth          = aMountPackage[1].trim();
                    var aHiddenPackage  = $('.xPackagePrice' + nValuePackage).find('option:selected').data('detailpackage');
                    var tPDTSetPdtCode  = aHiddenPackage.rtPdtCode;
                    var tPDTSetPunCode  = aHiddenPackage.rtPunCode;
                    var tPDTSetPunName  = aHiddenPackage.rtPunName;
                    var tUnitFact       = aHiddenPackage.rcUnitFact;
                }

                var tTextFeatuesAllow   = $("#otbPackage tbody tr:eq("+i+")").find('.xCNAllowList'+nValuePackage).data('flag');
                if(tTextFeatuesAllow == 1 || tTextFeatuesAllow == true){
                    var tTextFeatuesList        = $("#otbPackage tbody tr:eq("+i+") td").eq(0).text();
                    var aDetailPDT              = $('.xPackage' + nValuePackage).data('detailproduct');
                    var aDetailFeatues          = $("#otbPackage tbody tr:eq("+i+")").find('.xCNAllowList'+nValuePackage).data('detailproduct');
                    var tUnitPDTSet             = $("#otbPackage tbody tr:eq("+i+")").find('.xCNAllowList'+nValuePackage).data('itemproduct');

                    aPackage.push({
                        tTitlePackage       : tTitlePackage,
                        tUnitPDTSet         : tUnitPDTSet,
                        nPrice              : tPricePackage,
                        tMonth              : tMonth,
                        tTextFeatuesList    : tTextFeatuesList,
                        tPDTSetPdtCode      : tPDTSetPdtCode,
                        tPDTSetPunCode      : tPDTSetPunCode,
                        tPDTSetPunName      : tPDTSetPunName,
                        aDetailPDT          : aDetailPDT,
                        aDetailFeatues      : aDetailFeatues,
                        tUnitFact           : tUnitFact
                    });
                }
            }
        }

        JCNxOpenLoading();
        $.ajax({
            type    : "POST",
            url     : "BuyLicenseListAddOn",
            cache   : false,
            data    : {
                'tTypepage'         : '<?=$tTypepage?>',
                'aPackage'          : aPackage,
                'ptName'            :  $('#oetBuyName').val(),
                'ptEmail'           :  $('#oetBuyEmail').val(),
                'ptTel'             :  $('#oetBuyTel').val(),
                'ptTypeLicense'     :  $('#orbBuyTypeLicense:checked').val(),
                'pnCountbch'        :  $('#oetBuycountbch').val(),
                'pnValueType'       :  $('#ohdValueBlockBusiness').val(),
                'ptValueOther'      :  $('#oetBuyBusinessOther').val(),
                'pnValuePackage'    :  $('#ohdValuePackage').val()
            },
            timeout : 0,
            success : function(tResult){
                var oResult = JSON.parse(tResult);
                if(oResult.tStatus == 'fail' && oResult.tCodeError == 801){
                    JCNxCloseLoading();
                    FSvCMNSetMsgErrorDialog('<?=language('register/buylicense/buylicense', 'tTelphoneDuplicate')?>');
                    return;
                }else if(oResult.tStatus == 'fail'){
                    JCNxCloseLoading();
                    FSvCMNSetMsgErrorDialog('<?=language('register/buylicense/buylicense', 'tRegisterFail')?>');
                    return;
                }else{
                    JCNxCloseLoading();

                    //ถ้าลงทะเบียน แล้วให้ logout ออก
                    if('<?=$tTypepage?>' == 1){
                        $('#odvModalRegisAndBuyMoreOneBch').modal('show');
                        return;
                    }else{
                        if($('#orbBuyTypeLicense:checked').val() == 1){ //Demo : ทดลองใช้ จะไม่มี step ต่อไป
                            $('#odvModalRegisterSuccess').modal('show');
                        }else{ //Product : เปิดร้านค้าจริง จะไป step ต่อไป

                            if($('#oetBuycountbch').val() > 1){
                                //ต้องรออนุมัติ
                                $('#odvModalRegisAndBuyMoreOneBch').modal('show');
                                return;
                            }else{
                                $('#odvContentPageBuylicense').html(oResult['tViewHtml']);

                                //Control ปุ่ม
                                $('.xCNBTNControlStep1').hide();
                                $('.xCNBTNControlStep2').show();
                                $('.xCNBTNControlStep3').hide();
                                $('.xCNBTNControlStep4').hide();
                            }
                        }
                    }
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }

    //ไป Step 2 - AddOn แบบหน้าจอ Extend
    function JSxNextStepToPageAddOnExtend(){
        $.ajax({
            type    : "POST",
            url     : "BuyLicenseListAddOnExtend",
            cache   : false,
            data    : {
                'tTypepage'         : '<?=$tTypepage?>',
                'aPackage'          : [],
            },
            timeout : 0,
            success : function(tResult){
                var oResult = JSON.parse(tResult);
                JCNxCloseLoading();

                $('#odvContentPageBuylicense').html(oResult['tViewHtml']);

                //Control ปุ่ม
                $('.xCNBTNControlStep1').hide();
                $('.xCNBTNControlStep2').show();
                $('.xCNBTNControlStep3').hide();
                $('.xCNBTNControlStep4').hide();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }

    //ไป Step3 - แบบซื้อ
    function JSxNextStepToPageDatatableList(){
        //ต้องเอาข้อมูล step2 เอาไปลง temp
        
        //ข้อมูลฟิเจอร์
        var aFeatues = [];
        var nTableFeatueslength = $('#otbFeatues tbody tr').length;
        
        for(var i=0; i<nTableFeatueslength; i++){
            var tFeatureCode = $("#otbFeatues tbody tr:eq("+i+")").data('featurecode');
            var tCheckbox = $('#otbFeatues tbody tr #ocbListItem_'+tFeatureCode+' ').is(":checked") ? 1 : 0;
            if(tCheckbox == 1){
                var tTextFeatues        = $("#otbFeatues tbody tr:eq("+i+") td").eq(1).text();
                var tTextFeatuesDetail  = $("#otbFeatues tbody tr:eq("+i+") td").eq(2).text();
                var tTextFeatuesQty     = $("#otbFeatues tbody tr:eq("+i+") td").eq(3).find('.xCNFeaturemonth').find(":selected").text();
                var tTextFeatuesPrice   = $("#otbFeatues tbody tr:eq("+i+") td").eq(4).text();
                var oDetailFeatues      = $("#otbFeatues tbody tr:eq("+i+")").data('detailfeature');
                var tUnitCode           = $("#otbFeatues tbody tr:eq("+i+") td").eq(3).find('.xCNFeaturemonth').find(":selected").data('unit');
                var nFactor             = $("#otbFeatues tbody tr:eq("+i+") td").eq(3).find('.xCNFeaturemonth').find(":selected").data('factor');

                aFeatues.push({
                    tTextFeatues        : tTextFeatues, 
                    tTextDetail         : tTextFeatuesDetail,
                    tTextQty            : tTextFeatuesQty,
                    tTextPrice          : tTextFeatuesPrice,
                    tUnitCode           : tUnitCode,
                    nFactor             : nFactor,
                    oDetailFeatues      : oDetailFeatues
                });
            }
        }

        //ข้อมูลจุดขาย
        var aPos = [];
        var nTablePoslength     = $('#otbBuyPos tbody tr').length
        for(var j=0; j<nTablePoslength; j++){

            var tTextPos        = $("#otbBuyPos tbody tr:eq("+j+") td").eq(2).text();
            var tTextPosQty     = $("#otbBuyPos tbody tr:eq("+j+") td").eq(3).find('.xCNPosmonth').find(":selected").text();
            var tTextPosPrice   = $("#otbBuyPos tbody tr:eq("+j+") td").eq(4).text();
            var tStaVat         = $("#otbBuyPos tbody tr:eq("+j+") td").eq(3).find('.xCNPosmonth').find(":selected").attr('data-tStaVat');
            var tVatCode        = $("#otbBuyPos tbody tr:eq("+j+") td").eq(3).find('.xCNPosmonth').find(":selected").attr('data-tVatCode');
            var cVatRate        = $("#otbBuyPos tbody tr:eq("+j+") td").eq(3).find('.xCNPosmonth').find(":selected").attr('data-cVatRate');
            var tStaAlwDis      = $("#otbBuyPos tbody tr:eq("+j+") td").eq(3).find('.xCNPosmonth').find(":selected").attr('data-tStaAlwDis');
            var tStaSet         = $("#otbBuyPos tbody tr:eq("+j+") td").eq(3).find('.xCNPosmonth').find(":selected").attr('data-tStaSet');
            var tUnitcode       = $("#otbBuyPos tbody tr:eq("+j+") td").eq(3).find('.xCNPosmonth').find(":selected").attr('data-unitcode');
            var tPdtCode        = $("#otbBuyPos tbody tr:eq("+j+") td").eq(3).find('.xCNPosmonth').find(":selected").attr('data-tPdtCode');
            var nFactor         = $("#otbBuyPos tbody tr:eq("+j+") td").eq(3).find('.xCNPosmonth').find(":selected").attr('data-nFactor');
            var tVATInOrEx      = $("#otbBuyPos tbody tr:eq("+j+") td").eq(3).find('.xCNPosmonth').find(":selected").attr('data-tVATInOrEx');

            aPos.push({
                tPdtCode        : tPdtCode,
                tTextPos        : tTextPos, 
                tTextPosQty     : tTextPosQty,
                tTextPosPrice   : tTextPosPrice,
                tStaVat         : tStaVat,
                tVatCode        : tVatCode,
                cVatRate        : cVatRate,
                tStaAlwDis      : tStaAlwDis,
                tStaSet         : tStaSet,
                tUnitcode       : tUnitcode,
                nFactor         : nFactor,
                tVATInOrEx      : tVATInOrEx
            });
        }

        $.ajax({
            type    : "POST",
            url     : "BuyLicenseRecheckDetail",
            cache   : false,
            data    : {
                'tTypepage'     : '<?=$tTypepage?>',
                'aItemCustomer' : $('#ohdCustomerInfo').val(),
                'aFeatues'      : aFeatues,
                'aPos'          : aPos
            },
            timeout : 0,
            success : function(tResult){
                $('#odvContentPageBuylicense').html(tResult);

                //Control ปุ่ม
                $('.xCNBTNControlStep1').hide();
                $('.xCNBTNControlStep2').hide();
                $('.xCNBTNControlStep3').show();
                $('.xCNBTNControlStep4').hide();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }

    //ไป Step3 - แบบต่ออายุ
    function JSxNextStepToPageDatatableListExtend(){
        $.ajax({
            type    : "POST",
            url     : "BuyLicenseRecheckDetailExtend",
            cache   : false,
            data    : {
                'tTypepage'     : '<?=$tTypepage?>',
                'aItemCustomer' : ''
            },
            timeout : 0,
            success : function(tResult){
                $('#odvContentPageBuylicense').html(tResult);

                //Control ปุ่ม
                $('.xCNBTNControlStep1').hide();
                $('.xCNBTNControlStep2').hide();
                $('.xCNBTNControlStep3').show();
                $('.xCNBTNControlStep4').hide();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }

    //ไป Step4
    function JSvNextStepToPagePayment(){
        $.ajax({
            type    : "POST",
            url     : "BuyLicensePayment",
            cache   : false,
            data    : {
                'tTypepage'     : '<?=$tTypepage?>',
                'aItemCustomer' : $('#ohdCustomerInfoPayment').val(),
            },
            timeout : 0,
            success : function(tResult){
                var nGrand = $('#otdGrandLicense').text();
                if((nGrand == 0 || nGrand == '0.00')){ //เปิดร้านค้าจริง และ มีราคาสรุปเท่ากับ 0 จะ
                    JSxGenBillCasePriceZero();
                }else{
                    $('#odvContentPageBuylicense').html(tResult);

                    //Control ปุ่ม
                    $('.xCNBTNControlStep1').hide();
                    $('.xCNBTNControlStep2').hide();
                    $('.xCNBTNControlStep3').hide();
                    $('.xCNBTNControlStep4').show();
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }

    //ฟังก์ชั่น API Insert : กรณีราคาเป็น 0 ไม่ต้องแจ้งชำระเงิน
    function JSxGenBillCasePriceZero(){
        JCNxOpenLoading();
        $.ajax({
            type    : "POST",
            url     : "BuyLicenseInsert",
            cache   : false,
            data    : {
                'tTypepage'         : '<?=$tTypepage?>',
                'nTypePayment'      : 'free',
                'tCustomerID'       : $('#ohdCustomerID').val(),
                'tDocumentNumber'   : 'free',
                'nPriceGrand'       : 0.00,
                'tRCVCode'          : '007'
            },
            timeout : 0,
            success : function(tResult){
                var oResult = JSON.parse(tResult);
                if(oResult.aReturn['rtCode'] == '001'){
                    //ถ้าสมบูรณ์กลับไปหน้าจอจ่ายเงิน
                    $('#odvModalPaymentSuccessAndLogout').modal('show');
                    JCNxCloseLoading();
                }else{  
                    FSvCMNSetMsgErrorDialog('เกิดข้อผิดพลาด');
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }

    //ฟังก์ชั่น API Insert : กรณีราคามากกว่า 0 ต้องแจ้งชำระเงิน
    function JSxCallAPIInsertDocument(){
        var nTypePayment = $('input[name=orbPaymentBy]:checked').val();
        if(nTypePayment != undefined){ //ชำระแบบโอนเงิน + ชำระแบบพร้อมเพย์

            JCNxOpenLoading();

            $.ajax({
                type    : "POST",
                url     : "BuyLicenseInsert",
                cache   : false,
                data    : {
                    'tTypepage'         : '<?=$tTypepage?>',
                    'nTypePayment'      : nTypePayment,
                    'tCustomerID'       : $('#ohdCustomerID').val(),
                    'tDocumentNumber'   : $('#ohdDocumentDummyForPayment').val(),
                    'nPriceGrand'       : $('.xCNPriceGrand').text(),
                    'tRCVCode'          : $('#ohdValuePaymentRcv').val()
                },
                timeout : 0,
                success : function(tResult){
                    var oResult = JSON.parse(tResult);
                    if(oResult.aReturn['rtCode'] == '001'){ //ถ้าสมบูรณ์กลับไปหน้าจอจ่ายเงิน
                        if(oResult.rtFmtCode == '005'){ //แบบโอน
                            $('#odvModalPaymentSuccessAndLogout').modal('show');
                        }else if(oResult.rtFmtCode == '013'){// พร้อมเพย์
                            window.location.href = 'logout';
                        }
                        JCNxCloseLoading();
                    }else{  
                        FSvCMNSetMsgErrorDialog('เกิดข้อผิดพลาด');
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }else{
            FSvCMNSetMsgErrorDialog('กรุณาเลือกประเภทการชำระเงิน');
            return;
        }
    }

</script>