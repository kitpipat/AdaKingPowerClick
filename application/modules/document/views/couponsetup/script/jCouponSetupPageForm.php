<script src="<?php echo  base_url('application/modules/common/assets/js/jquery.mask.js')?>"></script>
<script src="<?php echo  base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>
<script src="<?php echo  base_url('application/modules/common/assets/js/global/ExcelJS/xlsx.full.min.js')?>"></script>
<script src="<?php echo  base_url('application/modules/common/assets/js/global/ExcelJS/jszip.js')?>"></script>
<script type="text/javascript">
    var nLangEdits      = '<?php echo $this->session->userdata("tLangEdit");?>';
    var tUsrApvName     = '<?php echo $this->session->userdata("tSesUsername");?>';
    var tSesUsrLevel    = '<?php echo $this->session->userdata('tSesUsrLevel');?>';

   let  CPHFrmCphDisType=  $('#ostCPHFrmCphDisType').val();
   if(CPHFrmCphDisType==3){
                $('#obtCPHBrowseHDCstPri').attr('disabled',false);
              }else{
                  $('#obtCPHBrowseHDCstPri').attr('disabled',true);
                 $('#oetCPHHDCstPriCode').val('');
                 $('#oetCPHHDCstPriName').val('');
              }
    $('#ostCPHFrmCphDisType').unbind().change(function(){
              var nValue = $(this).val();
              if(nValue==3){
                $('#obtCPHBrowseHDCstPri').attr('disabled',false);
              }else{
                  $('#obtCPHBrowseHDCstPri').attr('disabled',true);
                 $('#oetCPHHDCstPriCode').val('');
                 $('#oetCPHHDCstPriName').val('');
              }
        });

    $('.selectpicker').selectpicker('refresh');

    $('.xCNMenuplus').unbind().click(function(){
        if($(this).hasClass('collapsed')){
            $('.xCNMenuplus').removeClass('collapsed').addClass('collapsed');
            $('.xCNMenuPanelData').removeClass('in');
        }
    }); 
    
    $('.xCNDatePicker').datepicker({
        format: "yyyy-mm-dd",
        todayHighlight: true,
        enableOnReadonly: false,
        disableTouchKeyboard : true,
        autoclose: true
    });

    $('.xCNTimePicker').datetimepicker({
        format: 'HH:mm:ss'
    });

    // Event Click Date Start Coupon
    $('#obtCPHFrmDateStart').unbind().click(function(){
        $('#oetCPHFrmCphDateStart').datepicker('show');
    });

    // Event Click Date Stop Coupon
    $('#obtCPHFrmDateStop').unbind().click(function(){
        $('#oetCPHFrmCphDateStop').datepicker('show');
    });

    $('#oetCPHFrmCphStaClosed').unbind().click(function(){
        var nCPHStaDoc          = $("#ohdCPHStaDoc").val();
          var nCPHStaApv        = $("#ohdCPHStaApv").val();
        if(nCPHStaDoc == 1 && nCPHStaApv == 1){

            $('#odvCPHModalStopCoupon').modal('show');
            if( $('input[name="oetCPHFrmCphStaClosed"]:checked').val() == 'on' ){ //ถ้ามันเปิดอยู่
                //คุณแน่ใจที่จะหยุดใช้งาน
                $('.ospCPHModalStopCoupon').text('<?=language('document/couponsetup/couponsetup','tDetailStopCoupon'); ?>');
            }else{ //ถ้ามันปิดอยู่
                //คุณแน่ใจที่จะเปลี่ยนสถานะกลับมาใช้งาน
                $('.ospCPHModalStopCoupon').text('<?=language('document/couponsetup/couponsetup','tDetailChangeStartCoupon'); ?>');
            }
        }
    });


    function JSxCPHChangStatusAfApv(){
        JCNxOpenLoading();
        if( $('input[name="oetCPHFrmCphStaClosed"]:checked').val() == 'on' ){
            var nStaClosed = 2;
        }else{
            var nStaClosed = 1;
        }

        var tCPHDocNo    = $("#ohdCPHDocNo").val();
        var tBchCode     = $('#ohdCPHUsrBchCode').val();
        $.ajax({
            type: "POST",
            url: "dcmCouponSetupChangStatusAfApv",
            data: {
                nStaClosed  : nStaClosed,
                tCPHDocNo   : tCPHDocNo,
                tBchCode    : tBchCode
            },
            cache: false,
            timeout: 0,
            success: function (oResult){
                var aReturnData = JSON.parse(oResult);
                JCNxCloseLoading();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }

    var oCHDCstPriOption = function(poReturnInputCstPri){
        let tNextFuncNameCstPri    = poReturnInputCstPri.tNextFuncName;
        let aArgReturnCstPri       = poReturnInputCstPri.aArgReturn;
        let tInputReturnCodeCstPri = poReturnInputCstPri.tReturnInputCode;
        let tInputReturnNameCstPri = poReturnInputCstPri.tReturnInputName;
        let oOptionReturnHDCstPri    = {
            Title: ['product/pdtpricelist/pdtpricelist','tPPLTitle'],
            Table:{Master:'TCNMPdtPriList',PK:'FTPplCode',PKName:'FTPplName'},
            Join :{
                Table:	['TCNMPdtPriList_L'],
                On:['TCNMPdtPriList_L.FTPplCode = TCNMPdtPriList.FTPplCode AND TCNMPdtPriList_L.FNLngID = '+nLangEdits]
            },
            GrideView:{
                ColumnPathLang	: 'product/pdtpricelist/pdtpricelist',
                ColumnKeyLang	: ['tPPLTBCode','tPPLTBName'],
                ColumnsSize     : ['15%','75%'],
                WidthModal      : 50,
                DataColumns		: ['TCNMPdtPriList.FTPplCode','TCNMPdtPriList_L.FTPplName'],
                DataColumnsFormat : ['',''],
                Perpage			: 10,
                OrderBy			: ['TCNMPdtPriList_L.FTPplCode ASC'],
            },
            CallBack:{
                ReturnType	: 'S',
                Value		: [tInputReturnCodeCstPri,"TCNMPdtPriList.FTPplCode"],
                Text		: [tInputReturnNameCstPri,"TCNMPdtPriList_L.FTPplName"]
            },
       
            RouteAddNew: 'pdtpricelist',
            BrowseLev: 0
        };
        return oOptionReturnHDCstPri;
    };

    $('#obtCPHBrowseHDCstPri').unbind().click(function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSxCheckPinMenuClose(); // Hidden Pin Menu
            window.oCPHHDCstPriOptionFrom = undefined;
            oCPHHDCstPriOptionFrom        = oCHDCstPriOption({
                'tReturnInputCode'  : 'oetCPHHDCstPriCode',
                'tReturnInputName'  : 'oetCPHHDCstPriName',
                'tNextFuncName'     : '',
                'aArgReturn'        : ['FTPplCode','FTPplName']
            });
            JCNxBrowseData('oCPHHDCstPriOptionFrom');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    var oCPHBrowseCouponType    = function(poDataCPT){
        let tInputCPTReturnCode = poDataCPT.tReturnInputCode;
        let tInputCPTReturnName = poDataCPT.tReturnInputName;
        var tAgnCode   = '<?php echo $this->session->userdata("tSesUsrAgnCode") ?>';

        var tSQLWhere = '';

        if(tAgnCode != ''){
            tSQLWhere = "AND TFNMCouponType.FTAgnCode = "+ tAgnCode + " OR ISNULL(TFNMCouponType.FTAgnCode,'') = ''";
        }

        let oCPTOptionReturn    = {
            Title   : ['coupon/coupontype/coupontype','tCPTTitle'],
            Table   : {Master:'TFNMCouponType',PK:'FTCptCode'},
            Join    : {
                Table   : ['TFNMCouponType_L'],
                On      : ['TFNMCouponType.FTCptCode = TFNMCouponType_L.FTCptCode AND TFNMCouponType_L.FNLngID = '+nLangEdits]
            },
            Where : {
                Condition : [' AND (TFNMCouponType.FTCptStaUse = 1)'+tSQLWhere]
            },
            GrideView : {
                ColumnPathLang	    : 'coupon/coupontype/coupontype',
                ColumnKeyLang	    : ['tCPTCode','tCPTName'],
                ColumnsSize         : ['15%','75%'],
                WidthModal          : 50,
                DataColumns         : ['TFNMCouponType.FTCptCode','TFNMCouponType_L.FTCptName'],
                DataColumnsFormat   : ['',''],
                Perpage			    : 5,
                OrderBy			    : ['TFNMCouponType.FTCptCode ASC'],
            },
            CallBack : {
                ReturnType	: 'S',
                Value		: [tInputCPTReturnCode,"TFNMCouponType.FTCptCode"],
                Text		: [tInputCPTReturnName,"TFNMCouponType_L.FTCptName"],
            },
            RouteAddNew : 'coupontype',
            BrowseLev   : nCPHStaBrowseType,
        };
        return oCPTOptionReturn;
    }
 
    var oCPHBrowsePdtPriListTo  = function(poDataPplTo){
        let tInputPplToReturnCode   = poDataPplTo.tReturnInputCode;
        let tInputPplToReturnName   = poDataPplTo.tReturnInputName;
        let oPplToOptionReturn      = {
            Title   : ['document/couponsetup/couponsetup','tCPHPplTitle'],
            Table   : {Master:'TCNMPdtPriList',PK:'FTPplCode'},
            Join    : {
                Table   : ['TCNMPdtPriList_L'],
                On      : ['TCNMPdtPriList.FTPplCode = TCNMPdtPriList_L.FTPplCode AND TCNMPdtPriList_L.FNLngID = '+nLangEdits]
            },
            GrideView: {
                ColumnPathLang	    : 'document/couponsetup/couponsetup',
                ColumnKeyLang	    : ['tCPHPplCode','tCPHPplName'],
                ColumnsSize         : ['15%','75%'],
                WidthModal          : 50,
                DataColumns		    : ['TCNMPdtPriList.FTPplCode','TCNMPdtPriList_L.FTPplName'],
                DataColumnsFormat   : ['','',''],
                Perpage			    : 5,
                OrderBy			    : ['TCNMPdtPriList.FTPplCode ASC'],
            },
            CallBack : {
                ReturnType	: 'S',
                Value		: [tInputPplToReturnCode,"TCNMPdtPriList.FTPplCode"],
                Text		: [tInputPplToReturnName,"TCNMPdtPriList_L.FTPplName"],
            },
            RouteAddNew : 'productpricelist',
            BrowseLev   : 1,
        };
        return oPplToOptionReturn;
    }

    // Event Browse Coupon Type
    $('#obtCPHBrowseCouponType').unbind().click(function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSxCheckPinMenuClose();
            window.oCPHBrowseCouponTypeOption   = undefined;
            oCPHBrowseCouponTypeOption          = oCPHBrowseCouponType({
                'tReturnInputCode'  : 'oetCPHFrmCptCode',
                'tReturnInputName'  : 'oetCPHFrmCptName',
            });
            JCNxBrowseData('oCPHBrowseCouponTypeOption');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    // Event Browse Product Price List
    $('#obtCPHBrowseCouponPriceGrpTo').unbind().click(function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSxCheckPinMenuClose();
            window.oCPHBrowsePdtPriListToOption = undefined;
            oCPHBrowsePdtPriListToOption        = oCPHBrowsePdtPriListTo({
                'tReturnInputCode'  : 'oetCPHFrmCphPplToCode',
                'tReturnInputName'  : 'oetCPHFrmCphPplToName',
            });
            JCNxBrowseData('oCPHBrowsePdtPriListToOption');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });
    
    $('#obtCPHAddCouponDT').unbind().click(function(){
        let nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            let tCPHTemplateModal   = $('#oscCPHTemplateModalCreate').html();
            $('#odvCPHAppendModalCreateHtml').html(tCPHTemplateModal);
            $('#odvCPHAppendModalCreateHtml #odvCPHFormAddCoupon').modal({backdrop: 'static', keyboard: false}) 
            $("#odvCPHAppendModalCreateHtml #odvCPHFormAddCoupon").modal('show');

            $('.xWCPHModalSelect').selectpicker('refresh');

            // Set Defult Div Show Data
            $('#odvCPHModalCouponTypeCreate1').show();
            $('#odvCPHModalCouponTypeCreate2').hide();
            $('#odvCPHModalInputCreateCoupon').hide();

            // Event Change นำเข้าคูปอง / สร้างคูปอง
            $('#ostCPHModalCouponTypeCreate').unbind().change(function(){
                // ล้างค่าข้อมูลเงื่อนไขในการสร้างคูปอง
                $('.xWCPHModalInputCreateCoupon input').val('');
                let nStaCouponTypeCreate    = $(this).val();
                if(nStaCouponTypeCreate == '1'){
                    $('#odvCPHModalCouponTypeCreate2').hide();
                    $('#odvCPHModalInputCreateCoupon').hide();
                    $('#odvCPHModalCouponTypeCreate1').show();
                    // แสดงปุ่มดาวน์โหลดแม่แบบ
                    $('#obtCPHModalDownloadTemplate').show();
                }else if(nStaCouponTypeCreate == '2'){
                    $('#odvCPHModalCouponTypeCreate1').hide();
                    $('#odvCPHModalInputCreateCoupon').show();
                    $('#odvCPHModalCouponTypeCreate2').show();

                    // Show Hide Input Codition Default
                    $('.xWCPHModalInputCreateCoupon').hide();
                    $('#odvCPHModalFormBarWidth').show();
                    $('#odvCPHModalFormBarStartCode').show();
                    $('#odvCPHModalFormBarQty').show();
                    $('#odvCPHModalFormBarHisQtyUse').show();
                    // ซ่อนปุ่มดาวน์โหลดแม่แบบ
                    $('#obtCPHModalDownloadTemplate').hide();
                }
                $('#ostCPHModalCouponTypeCreate').val(nStaCouponTypeCreate).selectpicker('refresh');
            });

            // Event Change สร้างคูปอง auto / customs
            $('#ostCPHModalCouponCreateMng').unbind().change(function(){
                // ล้างค่าข้อมูลเงื่อนไขในการสร้างคูปอง
                $('.xWCPHModalInputCreateCoupon input').val('');
                $('#odvCPHModalCouponTypeCreate1').hide();
                $('#odvCPHModalInputCreateCoupon').hide();
                $('#odvCPHModalCouponTypeCreate2').show();
                let nStaCouponCreateMng = $(this).val();
                if(nStaCouponCreateMng == '1'){
                    $('#odvCPHModalCouponCreateMng2').hide();
                    $('#odvCPHModalCouponCreateMng1').show();
                    
                    // Show Hide Input Codition Default
                    $('#odvCPHModalInputCreateCoupon').show();
                    $('.xWCPHModalInputCreateCoupon').hide();
                    $('#odvCPHModalFormBarWidth').show();
                    $('#odvCPHModalFormBarStartCode').show();
                    $('#odvCPHModalFormBarQty').show();
                    $('#odvCPHModalFormBarHisQtyUse').show();

                }else if(nStaCouponCreateMng == '2'){
                    $('#odvCPHModalCouponCreateMng1').hide();
                    $('#odvCPHModalCouponCreateMng2').show();

                    // Show Hide Input Codition Default
                    $('#odvCPHModalInputCreateCoupon').show();
                    $('.xWCPHModalInputCreateCoupon').hide();
                    $('#odvCPHModalFormCouponCode').show();
                    $('#odvCPHModalFormBarHisQtyUse').show();
                }
                $('#ostCPHModalCouponCreateMng').val(nStaCouponCreateMng).selectpicker('refresh');
            });

            // Event Change สร้างคูปอง auto ประเภทบาร์ฺโค๊ด
            $('#ostCPHModalCouponCreateMng1Bar').unbind().change(function(){
                // ล้างค่าข้อมูลเงื่อนไขในการสร้างคูปอง
                $('.xWCPHModalInputCreateCoupon input').val('');
                $('#odvCPHModalCouponTypeCreate1').hide();
                $('#odvCPHModalInputCreateCoupon').hide();
                $('#odvCPHModalCouponTypeCreate2').show();
                let nStaCouponCreateMng1Bar = $(this).val();
                switch(nStaCouponCreateMng1Bar){
                    case '1': {
                        // Show Hide Input Codition Default
                        $('#odvCPHModalInputCreateCoupon').show();
                        $('.xWCPHModalInputCreateCoupon').hide();
                        // Show Input Condition
                        $('#odvCPHModalFormBarWidth').show();
                        $('#odvCPHModalFormBarStartCode').show();
                        $('#odvCPHModalFormBarQty').show();
                        $('#odvCPHModalFormBarHisQtyUse').show();
                        break;
                    }
                    case '2': {
                        // Show Hide Input Codition Default
                        $('#odvCPHModalInputCreateCoupon').show();
                        $('.xWCPHModalInputCreateCoupon').hide();
                        // Show Input Condition
                        $('#odvCPHModalFormBarWidth').show();
                        $('#odvCPHModalFormBarPrefix').show();
                        $('#odvCPHModalFormBarStartCode').show();
                        $('#odvCPHModalFormBarQty').show();
                        $('#odvCPHModalFormBarHisQtyUse').show();
                        break;
                    }
                    case '3': {
                        // Show Hide Input Codition Default
                        $('#odvCPHModalInputCreateCoupon').show();
                        $('.xWCPHModalInputCreateCoupon').hide();
                        // Show Input Condition
                        $('#odvCPHModalFormBarWidth').show();
                        $('#odvCPHModalFormBarQty').show();
                        $('#odvCPHModalFormBarHisQtyUse').show();
                        break;
                    }
                }
                $('#ostCPHModalCouponCreateMng1Bar').val(nStaCouponCreateMng1Bar).selectpicker('refresh');
            });

            // Event Change สร้างคูปอง กำหนดเอง ประเภทบาร์ฺโค๊ด
            $('#ostCPHModalCouponCreateMng2Bar').unbind().change(function(){
                // ล้างค่าข้อมูลเงื่อนไขในการสร้างคูปอง
                $('.xWCPHModalInputCreateCoupon input').val('');
                $('#odvCPHModalCouponTypeCreate1').hide();
                $('#odvCPHModalInputCreateCoupon').hide();
                $('#odvCPHModalCouponTypeCreate2').show();
                let nStaCouponCreateMng2Bar = $(this).val();
                switch(nStaCouponCreateMng2Bar){
                    case '1': {
                        // Show Hide Input Codition Default
                        $('#odvCPHModalInputCreateCoupon').show();
                        $('.xWCPHModalInputCreateCoupon').hide();
                        // Show Input Condition
                        $('#odvCPHModalFormCouponCode').show();
                        $('#odvCPHModalFormBarHisQtyUse').show();
                        break;
                    }
                    case '2': {
                        // Show Hide Input Codition Default
                        $('#odvCPHModalInputCreateCoupon').show();
                        $('.xWCPHModalInputCreateCoupon').hide();
                        // Show Input Condition
                        $('#odvCPHModalFormBarPrefix').show();
                        $('#odvCPHModalFormCouponCode').show();
                        $('#odvCPHModalFormBarHisQtyUse').show();
                        break;
                    }
                }
                $('#ostCPHModalCouponCreateMng2Bar').val(nStaCouponCreateMng2Bar).selectpicker('refresh');
            });
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    function JSxCPHModalFuncImportFile(poElement, poEvent) {
        try{
            console.log('Import run');
            var oFile = $(poElement)[0].files[0];
            $("#oetCPHModalFileShowName").val(oFile.name);
        }catch(err){
            console.log("JSxCPHModalFuncImportFile Error: ", err);
        }
    }

    function JSxValidateFileExcel(){
        var fileUpload  = $("#oetCPHModalFileInport")[0];
        //Validate whether File is valid Excel file.
        var regex       = /^([a-zA-Z0-9ก-ฮ ()\s_\\.\-:])+(.xls|.xlsx)$/;
        if (regex.test(fileUpload.value.toLowerCase())) {
            if (typeof (FileReader) != "undefined") {
                var reader  = new FileReader();
                //For Browsers other than IE.
                if (reader.readAsBinaryString) {
                    reader.onload = function (e) {
                        JSxProcessExcel(e.target.result);
                    };
                    reader.readAsBinaryString(fileUpload.files[0]);
                } else {
                    //For IE Browser.
                    reader.onload = function (e) {
                        var data = "";
                        var bytes = new Uint8Array(e.target.result);
                        for (var i = 0; i < bytes.byteLength; i++) {
                            data += String.fromCharCode(bytes[i]);
                        }
                        JSxProcessExcel(data);
                    };
                    reader.readAsArrayBuffer(fileUpload.files[0]);
                }
            }else{
                $tMsgWannigFileNotSupport   = "This browser does not support HTML5.";
                alert($tMsgWannigFileNotSupport);
            }
        }else{
            $tMsgWannigFileNotFoundFile = "<?php echo language('document/couponsetup/couponsetup','tCPHModalValidateExcelNotFound') ?>"
            alert($tMsgWannigFileNotFoundFile);
        }
    }

    // Function Behide Event Save Coupon Setup
    function JSxProcessExcel(data) {
        //Read the Excel File data.
        var workbook    = XLSX.read(data, {
            type: 'binary'
        });
        //Fetch the name of First Sheet.
        var firstSheet  = workbook.SheetNames[0];
        //Read all rows from First Sheet into an JSON array.
        var excelRows   = XLSX.utils.sheet_to_row_object_array(workbook.Sheets[firstSheet]);
        //Create a HTML Table element.
        var table       = $("<table />");
        table[0].border = "1";
        //Add the header row.
        var row         = $(table[0].insertRow(-1));
        //Add the header cells.
        var headerCell  = $("<th />");
        headerCell.html("Id");
        row.append(headerCell);
 
        var headerCell  = $("<th />");
        headerCell.html("Name");
        row.append(headerCell);
 
        var headerCell  = $("<th />");
        headerCell.html("Country");
        row.append(headerCell);
 
        let nCountDataInTableDT = $('#odvCPHDataPanelDetail #otbCPHDataDetailDT tbody .xWCPHDataDetailItems').length;
        $('#odvCPHDataPanelDetail #otbCPHDataDetailDT tbody').find('.xWCPHTextNotfoundData').parent().remove();
        //Add the data rows from Excel file.
        for (var i = 0; i < excelRows.length; i++) {
            //Add the Data Row Detail DT.
            nCountDataInTableDT++;
            let tTemplate   = $("#oscCPHTemplateDataDetailDT").html();
                let oData       = {
                    'tImgCPHCouponOld'  : $('#oetImgInputCouponOld').val(),
                    'tImgCPHCouponNew'  : $('#oetImgInputCoupon').val(),
                    'tTextCpdAlwMaxUse' : excelRows[i].MaxUse,
                    'tTextCpdBarCpn'    : excelRows[i].CouponCode,
                    'nKeyNumber'        : nCountDataInTableDT,
                };
                let tRenderAppend   = JStCPHRenderTemplateDetailDT(tTemplate,oData);
                $('#odvCPHDataPanelDetail #otbCPHDataDetailDT tbody').append(tRenderAppend);
        }
        setTimeout(function(){
            $('#odvCPHFormAddCoupon').modal('hide');
            $('body').removeClass('modal-open');
            $('.modal-backdrop').remove();
            JCNxCloseLoading();
        },500);
    };

    // Function Behide Event Save Coupon Setup
    function JSoCPHModalSaveCreateCoupon(){
        var tCPHModalCouponTypeCreate = $('#ostCPHModalCouponTypeCreate').val();
        if(tCPHModalCouponTypeCreate == 1){
            JSxValidateFileExcel();
        }else{
            $('#obtCPHSubmitFromSaveCondition').trigger('click');
        }
    }

    // Function Render Data Detail DT
    function JStCPHRenderTemplateDetailDT(tTemplate,oData){
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

    // Function Event Delete Row Data Table 
    function JSxCPHDeleteRowDTItems(oEvent){
        JCNxOpenLoading();
        // Remove Row Data DT 
        $(oEvent).parents('.xWCPHDataDetailItems').remove();
        setTimeout(function(){
            var nCountDataInTableDT = $('#otbCPHDataDetailDT tbody tr.xWCPHDataDetailItems').length;
            if(nCountDataInTableDT == 0){
                var tTextDataNotFound   = "<tr><td class='text-center xCNTextDetail2 xWCPHTextNotfoundData' colspan='100%'><?php echo language('common/main/main','tCMNNotFoundData')?></td></tr>";
                $('#otbCPHDataDetailDT tbody').html(tTextDataNotFound);
            }else{
                var tNumberSeq  = 1;
                $( "#otbCPHDataDetailDT tbody tr.xWCPHDataDetailItems" ).each(function(){
                    $(this).find('.xWCPHNumberSeq').text(tNumberSeq);
                    tNumberSeq++;
                });
            }
            JCNxCloseLoading();
        },500)        
    }

    // Function Event Create Coupon DT And Validate Input
    function JSxCPHEventCreateCouponDT(){
        $('#ofmCPHModalCreateCouponForm').validate({
            focusInvalid: false,
            onclick: false,
            onfocusout: false,
            onkeyup: false,
            rules: {
                oetCPHModalInputBarWidth        : {"required" : true},
                oetCPHModalInputBarPrefix       : {"required" : true},
                oetCPHModalInputBarStartCode    : {"required" : true},
                oetCPHModalInputBarQty          : {"required" : true},
                oetCPHModalInputCouponCode      : {"required" : true},
                oetCPHModalInputBarHisQtyUse    : {"required" : true},
            },
            messages: {
                oetCPHModalInputBarWidth        : {"required" : 'กรุณาเพิ่มข้อมูลความกว้างบารโค๊ต.'},
                oetCPHModalInputBarPrefix       : {"required" : 'กรุณาเพิ่มข้อมูลตัวอักษร.'},
                oetCPHModalInputBarStartCode    : {"required" : 'กรุณาเพิ่มข้อมูลรหัสคูปองเริ่มต้น.'},
                oetCPHModalInputBarQty          : {"required" : 'กรุณาเพิ่มข้อมูลจำนวนคูปอง.'},
                oetCPHModalInputCouponCode      : {"required" : 'กรุณาเพิ่มข้อมูลรหัสคูปอง.'},
                oetCPHModalInputBarHisQtyUse    : {"required" : 'กรุณาเพิ่มข้อมูลจำนวนคูปองที่ใช้งานได้.'},
            },
            errorElement: "em",
            errorPlacement: function (error, element) {
                error.addClass("help-block");
                if(element.prop("type") === "checkbox") {
                    error.appendTo(element.parent("label"));
                }else{
                    var tCheck  = $(element.closest('.form-group')).find('.help-block').length;
                    if(tCheck == 0) {
                        error.appendTo(element.closest('.form-group')).trigger('change');
                    }
                }
            },
            highlight: function (element, errorClass, validClass) {
                $(element).closest('.form-group').addClass("has-error");
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).closest('.form-group').removeClass("has-error");
            },
            submitHandler: function (form){
                JCNxOpenLoading();
                $.ajax({
                    type: "POST",
                    url: "dcmCouponSetupEventAddCouponToDT",
                    data: $('#ofmCPHModalCreateCouponForm').serialize(),
                    success: function (oDataReturn) {
                        // สร้าง แบบ Custom
                        let aDataReturn         = JSON.parse(oDataReturn);
                        let tImgCPHCouponOld    = aDataReturn.ptImgCPHCouponOld;
                        let tImgCPHCouponNew    = aDataReturn.ptImgCPHCouponNew;
                        let tTextCpdAlwMaxUse   = aDataReturn.ptInputBarHisQtyUse;
                        let aDataCouponBar      = aDataReturn.paDataCouponBar;
                        let nCountDataInTableDT = $('#odvCPHDataPanelDetail #otbCPHDataDetailDT tbody .xWCPHDataDetailItems').length;
                        $('#odvCPHDataPanelDetail #otbCPHDataDetailDT tbody').find('.xWCPHTextNotfoundData').parent().remove();
                        $.each(aDataCouponBar,function(nKey,tTextCpdBarCpn){
                            nCountDataInTableDT++;
                            let tTemplate   = $("#oscCPHTemplateDataDetailDT").html();
                            let oData       = {
                                'tImgCPHCouponOld'  : tImgCPHCouponOld,
                                'tImgCPHCouponNew'  : tImgCPHCouponNew,
                                'tTextCpdAlwMaxUse' : tTextCpdAlwMaxUse,
                                'tTextCpdBarCpn'    : tTextCpdBarCpn,
                                'nKeyNumber'        : nCountDataInTableDT,
                            };
                            let tRenderAppend   = JStCPHRenderTemplateDetailDT(tTemplate,oData);
                            $('#odvCPHDataPanelDetail #otbCPHDataDetailDT tbody').append(tRenderAppend);
                        });
                        setTimeout(function(){
                            $('#odvCPHFormAddCoupon').modal('hide');
                            $('body').removeClass('modal-open');
                            $('.modal-backdrop').remove();
                            JCNxCloseLoading();
                        },500);
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        JCNxResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            },
        });
    }

    // Event Search Menu
    $("#oetCPHSearchDataDT").on("keyup", function() {

        //flow : ใหม่ search by wat
        var value = $(this).val().toLowerCase();
        $("#otbCPHDataDetailDT tr").filter(function(index) {
            if (index !== 0) {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            }
        });

        //flow : เดิม search by yoshi
        // var value = $(this).val();
        // $("#otbCPHDataDetailDT tr").each(function(index) {
            // if (index !== 0) {
            //     $row = $(this);
            //     var $tdElement = $row.find("td:first");
            //     var id  = $tdElement.text();
            //     var matchedIndex = id.indexOf(value);
            //     if (matchedIndex != 0) {
            //         $row.hide();
            //     }
            //     else {
            //         $row.show();
            //     }
            // }
        // });
    });

    // Event Control Date Default
    $('#ocbCPHStaAutoGenCode').on('change', function (e) {
        if($('#ocbCPHStaAutoGenCode').is(':checked')){
            $("#oetCPHDocNo").val('');
            $("#oetCPHDocNo").attr("readonly", true);
            $('#oetCPHDocNo').closest(".form-group").css("cursor","not-allowed");
            $('#oetCPHDocNo').css("pointer-events","none");
            $("#oetCPHDocNo").attr("onfocus", "this.blur()");
            $('#ofmCouponSetupAddEditForm').removeClass('has-error');
            $('#ofmCouponSetupAddEditForm .form-group').closest('.form-group').removeClass("has-error");
            $('#ofmCouponSetupAddEditForm em').remove();
        }else{
            $('#oetCPHDocNo').closest(".form-group").css("cursor","");
            $('#oetCPHDocNo').css("pointer-events","");
            $('#oetCPHDocNo').attr('readonly',false);
            $("#oetCPHDocNo").removeAttr("onfocus");
        }
    });

    var dCurrentDate    = new Date();
    var tAmOrPm         = (dCurrentDate.getHours() < 12) ? "AM" : "PM";
    var tCurrentTime    = dCurrentDate.getHours() + ":" + dCurrentDate.getMinutes() + " " + tAmOrPm;

    if($('#oetCPHDocDate').val() == ''){
        $('#oetCPHDocDate').datepicker("setDate",dCurrentDate); 
    }

    if($('#oetCPHDocTime').val() == ''){
        $('#oetCPHDocTime').val(tCurrentTime);
    }

    $('#obtCPHDocDate').unbind().click(function(){
        $('#oetCPHDocDate').datepicker('show');
    });

    $('#obtCPHDocTime').unbind().click(function(){
        $('#oetCPHDocTime').datetimepicker('show');
    });

    $('#oimBrowseBch').click(function(){ JCNxBrowseData('oBrowseBch'); });

    var tUsrLevel     = "<?php echo $this->session->userdata("tSesUsrLevel"); ?>";
    var tBchCodeMulti = "<?php echo $this->session->userdata("tSesUsrBchCodeMulti"); ?>";
    var nCountBch     = "<?php echo $this->session->userdata("nSesUsrBchCount"); ?>";
    var tWhere        = "";

    if(nCountBch == 1){
        $('#oimBrowseBch').attr('disabled',true);
    }
    if(tUsrLevel != "HQ"){
        tWhere = " AND TCNMBranch.FTBchCode IN ("+tBchCodeMulti+") ";
    }else{
        tWhere = "";
    }

    var oBrowseBch = {
        Title   : ['company/branch/branch','tBCHTitle'],
        Table   : {Master:'TCNMBranch',PK:'FTBchCode',PKName:'FTBchName'},
        Join    : {
            Table   : ['TCNMBranch_L','TCNMWaHouse_L'],
            On      : ['TCNMBranch_L.FTBchCode = TCNMBranch.FTBchCode AND TCNMBranch_L.FNLngID ='+nLangEdits,
                        'TCNMBranch.FTWahCode = TCNMWaHouse_L.FTWahCode AND TCNMBranch.FTBchCode = TCNMWaHouse_L.FTBchCode AND TCNMWaHouse_L.FNLngID ='+nLangEdits,
            ]
        },
        Where : {
            Condition : [tWhere]
        },
        GrideView:{
            ColumnPathLang    : 'company/branch/branch',
            ColumnKeyLang     : ['tBCHCode','tBCHName',''],
            ColumnsSize       : ['15%','75%',''],
            WidthModal        : 50,
            DataColumns       : ['TCNMBranch.FTBchCode','TCNMBranch_L.FTBchName','TCNMWaHouse_L.FTWahCode','TCNMWaHouse_L.FTWahName'],
            DataColumnsFormat : ['',''],
            DisabledColumns   : [2,3],
            Perpage           : 10,
            OrderBy           : ['TCNMBranch.FDCreateOn DESC'],
        },
        CallBack:{
            ReturnType        : 'S',
            Value             : ["ohdCPHUsrBchCode","TCNMBranch.FTBchCode"],
            Text              : ["ohdCPHUsrBchName","TCNMBranch_L.FTBchName"],
        }
    }

    //พิมพ์
    function JSvCPHPrintDoc(){
        var aInfor = [
            {"Lang"         : '<?=FCNaHGetLangEdit(); ?>'}, // Lang ID
            {"ComCode"      : '<?=FCNtGetCompanyCode(); ?>'}, // Company Code
            {"BranchCode"   : '<?=FCNtGetAddressBranch($tCPHUsrBchCode ); ?>' }, // สาขาที่ออกเอกสาร
            {"DocCode"      : $('#oetCPHDocNo').val()  }, // เลขที่เอกสาร
            {"DocBchCode"   : '<?=$tCPHUsrBchCode;?>'}
        ];
        window.open('<?=base_url()?>'+"formreport/Frm_SQL_FCCoupon?infor="+JCNtEnCodeUrlParameter(aInfor), '_blank');
    }
</script>