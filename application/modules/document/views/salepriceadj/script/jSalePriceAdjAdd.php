<script type="text/javascript">
    var nLangEdits = <?=$this->session->userdata("tLangEdit")?>;
    var tUsrBchCode = $('#oetBchCode').val();
    var tFTZneChain = "";

    $('#oimSearchSpaPdtPri').click(function(){
        JCNxOpenLoading();
        JSvSpaPdtPriDataTable();
    });

    $('#oetSearchSpaPdtPri').keypress(function(event){
        if(event.keyCode == 13){
            event.preventDefault();
            JCNxOpenLoading();
            JSvSpaPdtPriDataTable();
        }
    });

    //Added by Napat(Jame) 15/11/2562
    //แก้ปัญหาเวลากด enter แล้วชอบเด้งไปปุ่ม submit
    $(":input").keypress(function(event){
        if(event.keyCode == 13){
            event.preventDefault();
        }
    });

    $(document).ready(function(){

        JSxCheckSwitchDocType();

        $('#oetXphDocNo').attr('readonly',true);

        /*===========================================================================*/
        var tLangCode = $("#ohdLangEdit").val();
        var tUsrBchCode = $("#oetBchCode").val();
        var tUsrApv = $("#oetXthApvCodeUsrLogin").val();
        var tStaPrcDoc = $("#oetStaPrcDoc").val();
        var tUsrCode = $("#oetUsrCode").val();
        var tDocNo = $("#oetXphDocNo").val();
        var tPrefix = 'RESAJP';
        var tStaDelMQ = $("#oetStaDelQname").val();
        var tStaApv = $("#oetStaApv").val();
        var tQName = tPrefix + '_' + tDocNo + '_' +tUsrApv;

        // MQ Message Config
        var poDocConfig = {
            tLangCode: tLangCode,
            tUsrBchCode: tUsrBchCode,
            tUsrApv: tUsrApv,
            tDocNo: tDocNo,
            tPrefix: tPrefix,
            tStaDelMQ: tStaDelMQ,
            tStaApv: tStaApv,
            tQName: tQName
        };

        var poMqConfig = {
            host: 'ws://' + oSTOMMQConfig.host + ':15674/ws',
            username: oSTOMMQConfig.user,
            password: oSTOMMQConfig.password,
            vHost: oSTOMMQConfig.vhost
        };

        // Callback Page Control(function)
        var poCallback = {
            tCallPageEdit: 'JSvCallPageSpaEdit',
            tCallPageList: 'JSvCallPageSpaList'
        };

        // Update Status For Delete Qname Parameter
        var poUpdateStaDelQnameParams = {
            ptDocTableName : "TCNTPdtAdjPriHD",
            ptDocFieldDocNo: "FTXphDocNo",
            ptDocFieldStaApv: "FTXphStaPrcDoc",
            ptDocFieldStaDelMQ: "FTXphStaDelMQ",
            ptDocStaDelMQ: "1",
            ptDocNo : tDocNo
        };

        //if ((JCNbCardShiftOutIsUpdatePage() && JSbSPAIsStaApv('2')) && (tUsrCode == tUsrApv)) {
        // if ((tDocNo != "" && tStaPrcDoc == "2") && (tUsrCode == tStaApv)){ // 2 = Processing and user approved
        // if ((tDocNo != "" && tStaPrcDoc == "2") && (tUsrCode == tStaApv)){
        // alert('tStaApv: ' + tStaPrcDoc);

        // console.log('tDocNo'+tDocNo);
        // console.log('tStaPrcDoc'+tStaPrcDoc);
        // console.log('tUsrCode'+tUsrCode);
        // console.log('tStaApv'+tUsrApv);

        if((tDocNo != "" && tStaPrcDoc == "2") && (tUsrCode == tUsrApv)){
            FSxCMNRabbitMQMessage(poDocConfig, poMqConfig, poUpdateStaDelQnameParams, poCallback);
        }
        // else{

        //     alert('Not Show Mag \ntDocNo: ' + tDocNo + '\ntUsrCode: ' + tUsrCode + ' = ' + tStaApv + '\nJSbSPAIsStaApv: ' + tStaPrcDoc);

        // }


        if(tStaApv != "" && tStaDelMQ == ""){ // Qname removed ?
            // alert('Q Delete');
            // Delete Queue Name Parameter
            var poDelQnameParams = {
                ptPrefixQueueName: tPrefix,
                ptBchCode: "",
                ptDocNo: tDocNo,
                ptUsrCode: tStaApv
            };
            FSxCMNRabbitMQDeleteQname(poDelQnameParams);
            FSxCMNRabbitMQUpdateStaDeleteQname(poUpdateStaDelQnameParams);
        }
        // else{

        //     alert('Not Q Delete');

        // }
        /*===========================================================================*/

        // if(tUsrBchCode==""){ JSxGetBchComp(); } // Get Bch from Company

        $('.selectpicker').selectpicker();

        $('#obtAddPdt').click(function(){
            JSxCheckPinMenuClose(); // Hide Menu Pin
            JSvPDTBrowseList();
        });

        $('#ocbStaAutoGenCode').click(function(){
            JSxSPACheckAutoGenerate();
        });

        $('#obtBtnSpaCancel').click(function(){
            JSxSPAUpdateStaDocCancel();
        });


        $('#obtAdjAll').click(function(){
            JSxSpaAdjAll();
        });

        // DATE
        $('#obtXphDocDate').click(function(){
            event.preventDefault();
            $('#oetXphDocDate').datepicker('show');
        });
        $('#obtXphDStart').click(function(){
            event.preventDefault();
            $('#oetXphDStart').datepicker('show');
        });
        $('#obtXphDStop').click(function(){
            event.preventDefault();
            $('#oetXphDStop').datepicker('show');
        });
        $('#obtXphRefIntDate').click(function(){
            event.preventDefault();
            $('#oetXphRefIntDate').datepicker('show');
        });

        $('.xCNTimePicker').datetimepicker({
            format: 'HH:mm',
        });
        $('#obtXphDocTime').click(function(){
            event.preventDefault();
            $('#oetXphDocTime').datetimepicker('show');
        });
        $('#obtXphTStart').click(function(){
            event.preventDefault();
            $('#oetXphTStart').datetimepicker('show');
        });
        $('#obtXphTStop').click(function(){
            event.preventDefault();
            $('#oetXphTStop').datetimepicker('show');
        });

        JSxCheckDocType($('#ocmXphDocType').val());
        var dDateStop   = $('#ohdDateStop').val();
        $('#ocmXphDocType').change(function(){
            JSxCheckDocType(this.value);
            JSxCheckSwitchDocType();
            $('#oetXphDStop').val(dDateStop);
        });

        /*================= ตรวจสอบ DocType 18/10/2019 Saharat(GolF) =======================*/
        function JSxCheckSwitchDocType(){
            var tXphDocType = $('#ocmXphDocType').val();
            var dXphDStart  = $('#oetXphDStart').val();
            switch (tXphDocType) {
                case "1":
                    $('#odvXphTStop').hide();
                    $('#odvXphDStop').hide();
                    $('#oetCheckDate').val('1');
                break;
                case "2":
                    $('#odvXphTStop').show();
                    $('#odvXphDStop').show();
                    $('#oetCheckDate').val('2');
                break;
            }
        }
        /*==================================================================================*/

        $('#btnBrowseZone').click(function(){
            var tBchTo = $('#oetXphBchTo').val();
            if(tBchTo!=""){
                oCmpBrowseZone.Where.Condition = [" AND FTZneRefCode = " + tBchTo + " AND FTZneTable = 'TCNMBranch'"];
            }else{
                oCmpBrowseZone.Where.Condition = [""];
            }
            JCNxBrowseData('oCmpBrowseZone');
        });

        $('#btnBrowseAgency').unbind().click(function(){
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                JSxCheckPinMenuClose(); // Hide Menu Pin
                JCNxBrowseData('oCmpBrowseAgency');
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        $('#btnBrowseMerchant').unbind().click(function(){
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                JSxCheckPinMenuClose(); // Hide Menu Pin
                JCNxBrowseData('oCmpBrowseMerchant');
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        $('#btnBrowseBranch').unbind().click(function(){
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                JSxCheckPinMenuClose(); // Hide Menu Pin
                JCNxBrowseData('oCmpBrowseBranch');
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        $('#btnBrowseMerChrant').unbind().click(function(){
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                JSxCheckPinMenuClose(); // Hide Menu Pin
                JCNxBrowseData('oCmpBrowseMerChrant');
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        $('#btnBrowseShop').unbind().click(function(){
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                JSxCheckPinMenuClose(); // Hide Menu Pin
                JCNxBrowseData('oCmpBrowseShop');
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        $('#btnBrowsePdtPriList').unbind().click(function(){
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                JSxCheckPinMenuClose(); // Hide Menu Pin
                JCNxBrowseData('oCmpBrowsePdtPriList');
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        $('#obtBrowseSaleAdjBCH').unbind().click(function(){
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                JSxCheckPinMenuClose(); // Hide Menu Pin
                JCNxBrowseData('oBrowseSaleAdj_BCH');
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        //เนลแก้ไขให้เลือกวันที่น้อยกว่าวันปัจจุบัน
        $('.xCNDatePicker').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true,
            startDate:'1900-01-01',
        });

        // $('.xCNStartDatePicker').datepicker({
        //     format: 'yyyy-mm-dd',
        //     autoclose: true,
        //     todayHighlight: true,
        //     startDate: new Date(),
        // });
        // $('.xCNStopDatePicker').datepicker({
        //     format: 'yyyy-mm-dd',
        //     autoclose: true,
        //     todayHighlight: true,
        //     startDate: new Date(),
        // });


        // $('.xWRelationshipDate').click(function(){
        //     // JSxSPACheckRelationshipDate(this.id);

        //     var dStart = $('#oetXphDStart').val();

        //     if(dStart != ""){
        //         console.log('1');
        //         $('.xCNStopDatePicker').datepicker('destroy');

        //         $('.xCNStopDatePicker').datepicker({
        //             format: 'yyyy-mm-dd',
        //             autoclose: true,
        //             todayHighlight: true,
        //             startDate: dStart,
        //         });
        //         // $('.xCNStopDatePicker').datepicker("refresh");

        //     }
        //     $(this.id).datepicker('show');

        // });

        // $('.xCNDatePicker').datepicker({
        //     format: 'yyyy-mm-dd',
        //     autoclose: true,
        //     todayHighlight: true,
        //     startDate: new Date(),
        // }).on('changeDate', function(e) {
        //     $('.xCNStopDatePicker').datepicker({
        //         format: 'yyyy-mm-dd',
        //         autoclose: true,
        //         startDate: e.date,
        //     });
        // });

        // $('.xCNStartDatePicker')
        // $('.xCNStopDatePicker').datepicker({
        //     format: 'yyyy-mm-dd',
        //     autoclose: true,
        //     todayHighlight: true,
        //     startDate: new Date(),
        // });

        // $('#oetXphDStart').data('DateTimePicker').getStartDate('03/14/2019');
        // $('#oetXphDStart').datepicker('getStartDate', '2019-03-14');

    });

    $('#obtBtnSpaApv').click(function(){
        JSxSPAApprove(false);
    });
    $('#obtSalePriAdjPopupApvConfirm').click(function(){
        $("#oetStaPrcDoc").val(2);
        JSxSPAApprove(true);
    });

    var tUsrLevel = "<?php echo $this->session->userdata("tSesUsrLevel"); ?>";
    var tBchCodeMulti = "<?php echo $this->session->userdata("tSesUsrBchCodeMulti"); ?>";
    var nCountBch = "<?php echo $this->session->userdata("nSesUsrBchCount"); ?>";
    var tWhere = "";

    if(nCountBch == 1){
        $('#obtBrowseSaleAdjBCH').attr('disabled',true);
    }
    if(tUsrLevel != "HQ"){
        tWhere = " AND TCNMBranch.FTBchCode IN ("+tBchCodeMulti+") ";
    }else{
        tWhere = "";
    }

    var oBrowseSaleAdj_BCH = {
        Title   : ['company/branch/branch','tBCHTitle'],
        Table   : {Master:'TCNMBranch',PK:'FTBchCode',PKName:'FTBchName'},
        Join    : {
            Table   : ['TCNMBranch_L','TCNMWaHouse_L'],
            On      : ['TCNMBranch_L.FTBchCode = TCNMBranch.FTBchCode AND TCNMBranch_L.FNLngID ='+nLangEdits,
                        'TCNMBranch.FTWahCode = TCNMWaHouse_L.FTWahCode AND TCNMBranch.FTBchCode = TCNMWaHouse_L.FTBchCode AND TCNMWaHouse_L.FNLngID ='+nLangEdits,
            ]
        },
        Where:{
            Condition : [tWhere]
        },
        GrideView:{
            ColumnPathLang : 'company/branch/branch',
            ColumnKeyLang : ['tBCHCode','tBCHName',''],
            ColumnsSize     : ['15%','75%',''],
            WidthModal      : 50,
            DataColumns  : ['TCNMBranch.FTBchCode','TCNMBranch_L.FTBchName','TCNMWaHouse_L.FTWahCode','TCNMWaHouse_L.FTWahName'],
            DataColumnsFormat : ['',''],
            DisabledColumns   : [2,3],
            Perpage   : 5,
            OrderBy   : ['TCNMBranch_L.FTBchName'],
            SourceOrder  : "ASC"
        },
        CallBack:{
            ReturnType : 'S',
            Value  : ["oetBchCode","TCNMBranch.FTBchCode"],
            Text  : ["oetSaleAdjBchName","TCNMBranch_L.FTBchName"],
        },
    }

    var oCmpBrowseZone = {
        Title : ['document/salepriceadj/salepriceadj','tSpaBRWZoneTitle'],
        Table:{Master:'TCNMZoneObj',PK:'FNZneID'},
        Join :{
            Table           : ['TCNMZone_L'],
            On              : ['TCNMZone_L.FTZneChain = TCNMZoneObj.FTZneChain AND TCNMZone_L.FNLngID = '+nLangEdits]
        },
        Where:{
            Condition : []
        },
        GrideView:{
            ColumnPathLang	: 'document/salepriceadj/salepriceadj',
            ColumnKeyLang	: ['tSpaBRWZoneTBCode','tSpaBRWZoneTBName'],
            ColumnsSize     : ['10%','75%'],
            DataColumns		: ['TCNMZone_L.FTZneCode','TCNMZone_L.FTZneName','TCNMZoneObj.FNZneID'],
            DisabledColumns : [2],
            DataColumnsFormat : ['',''],
            WidthModal      : 50,
            Perpage			: 10,
            OrderBy			: ['TCNMZoneObj.FTCreateBy'],
            SourceOrder		: "DESC"
        },
        CallBack:{
            ReturnType	: 'S',
            Value       : ["oetZneChain","TCNMZoneObj.FTZneChain"],
            Text		: ["oetZneName","TCNMZone_L.FTZneName"],
        },
        // DebugSQL : true
        // NextFunc:{
        //     FuncName:'JSxSetCondition',
        //     ArgReturn:['FTZneChain']
        // },
    }

    var oCmpBrowseBranch = {
        Title : ['document/salepriceadj/salepriceadj','tSpaBRWBranchTitle'],
        Table:{Master:'TCNMBranch',PK:'FTBchCode'},
        Join :{
            Table:	['TCNMBranch_L'],
            On:['TCNMBranch_L.FTBchCode = TCNMBranch.FTBchCode AND TCNMBranch_L.FNLngID = '+nLangEdits,]
        },
        GrideView:{
            ColumnPathLang	: 'document/salepriceadj/salepriceadj',
            ColumnKeyLang	: ['tSpaBRWBranchTBCode','tSpaBRWBranchTBName'],
            ColumnsSize     : ['10%','75%'],
            DataColumns		: ['TCNMBranch.FTBchCode','TCNMBranch_L.FTBchName'],
            DataColumnsFormat : ['',''],
            WidthModal      : 50,
            Perpage			: 10,
            OrderBy			: ['TCNMBranch.FTCreateBy'],
            SourceOrder		: "DESC"
        },
        CallBack:{
            ReturnType	: 'S',
            Value       : ["oetXphBchTo","TCNMBranch.FTBchCode"],
            Text		: ["oetBchName","TCNMBranch_L.FTBchName"],
        },
        NextFunc: {
                    FuncName: 'JSxSetAfterSElectBrach',
                    ArgReturn: ['FTBchCode', 'FTBchName']
        },
        // DebugSQL : true
    }
    var tOldBranchSelect = $("#oetXphBchTo").val();
    function JSxSetAfterSElectBrach(paBranchInfor){
        var aData = JSON.parse(paBranchInfor);
        if(aData[0]!=tOldBranchSelect){
            if($("#oetXphBchTo").val()!=""){
                $("#oetXphMerCode").val("");
                $("#oetMerName").val("");
            }
            tOldBranchSelect = aData[0];
        }

    }

    var oCmpBrowseMerChrant = {
        Title : ['merchant/merchant/merchant','tMerchantTitle'],
        Table:{Master:'TCNMMerchant_L',PK:'FTMerCode'},
        Where: {
                Condition: [
                    function(){
                        var tSQL = "";
                        if($("#oetXphBchTo").val()!=""){
                            tSQL += "AND (SELECT COUNT(FTShpCode) FROM TCNMShop WHERE TCNMShop.FTShpStaActive = 1 AND TCNMShop.FTMerCode = TCNMMerchant_L.FTMerCode AND TCNMShop.FTBchCode = '" + $("#oetXphBchTo").val() + "') != 0";
                        }
                        return tSQL;
                    }
                ]
        },
        GrideView:{
            ColumnPathLang	: 'merchant/merchant/merchant',
            ColumnKeyLang	: ['tMCNTBCode','tMCNTBName'],
            ColumnsSize     : ['10%','75%'],
            DataColumns		: ['TCNMMerchant_L.FTMerCode','TCNMMerchant_L.FTMerName'],
            DataColumnsFormat : ['',''],
            WidthModal      : 50,
            Perpage			: 10,
            OrderBy			: ['TCNMMerchant_L.FTMerCode'],
            SourceOrder		: "Desc"
        },
        CallBack:{
            ReturnType	: 'S',
            Value       : ["oetXphMerCode","TCNMMerchant_L.FTMerCode"],
            Text		: ["oetMerName","TCNMMerchant_L.FTMerName"],
        },
        // DebugSQL : true
    }

    var oCmpBrowsePdtPriList = {
        Title : ['document/salepriceadj/salepriceadj','tSpaBRWPdtPriListTitle'],
        Table:{Master:'TCNMPdtPriList',PK:'FTPplCode'},
        Join :{
            Table:	['TCNMPdtPriList_L'],
            On:['TCNMPdtPriList_L.FTPplCode = TCNMPdtPriList.FTPplCode AND TCNMPdtPriList_L.FNLngID = '+nLangEdits,]
        },
        Where :{
               Condition : ["AND TCNMPdtPriList.FTAgnCode = '<?php echo $tAgnCode; ?>'"],
        },
        GrideView:{
            ColumnPathLang	: 'document/salepriceadj/salepriceadj',
            ColumnKeyLang	: ['tSpaBRWPdtPriListTBCode','tSpaBRWPdtPriListTBName'],
            ColumnsSize     : ['15%','85%'],
            DataColumns		: ['TCNMPdtPriList.FTPplCode','TCNMPdtPriList_L.FTPplName'],
            DataColumnsFormat : ['',''],
            WidthModal      : 50,
            Perpage			: 10,
            OrderBy			: ['TCNMPdtPriList.FDCreateON'],
            SourceOrder		: "Desc"
        },
        CallBack:{
            ReturnType	: 'S',
            Value       : ["oetPplCode","TCNMPdtPriList.FTPplCode"],
            Text		: ["oetPplName","TCNMPdtPriList_L.FTPplName"],
        }
    }

    var oCmpBrowseAgency = {
        Title : ['document/salepriceadj/salepriceadj','tSpaBRWAgencyTitle'],
        Table:{Master:'TCNMAgencyGrp',PK:'FTAggCode'},
        Join :{
            Table:	['TCNMAgencyGrp_L'],
            On:['TCNMAgencyGrp_L.FTAggCode = TCNMAgencyGrp.FTAggCode AND TCNMAgencyGrp_L.FNLngID = '+nLangEdits,]
        },
        GrideView:{
            ColumnPathLang	: 'document/salepriceadj/salepriceadj',
            ColumnKeyLang	: ['tSpaBRWAgencyTBCode','tSpaBRWAgencyTBName'],
            ColumnsSize     : ['10%','75%'],
            DataColumns		: ['TCNMAgencyGrp.FTAggCode','TCNMAgencyGrp_L.FTAggName'],
            DataColumnsFormat : ['',''],
            WidthModal      : 50,
            Perpage			: 10,
            OrderBy			: ['TCNMAgencyGrp.FDCreateON'],
            SourceOrder		: "DESC"
        },
        CallBack:{
            ReturnType	: 'S',
            Value       : ["oetAggCode","TCNMAgencyGrp.FTAggCode"],
            Text		: ["oetAggName","TCNMAgencyGrp_L.FTAggName"],
        }
    }

    var oCmpBrowseMerchant = {
        Title : ['document/salepriceadj/salepriceadj','tSpaBRWMRCTitle'],
        Table:{Master:'TCNMMerchant',PK:'FTMerCode'},
        Join :{
            Table:	['TCNMMerchant_L'],
            On:['TCNMMerchant_L.FTMerCode = TCNMMerchant.FTMerCode AND TCNMMerchant_L.FNLngID = '+nLangEdits,]
        },
        GrideView:{
            ColumnPathLang	: 'document/salepriceadj/salepriceadj',
            ColumnKeyLang	: ['tSpaBRWMRCTBCode','tSpaBRWMRCTBName'],
            ColumnsSize     : ['10%','75%'],
            DataColumns		: ['TCNMMerchant.FTMerCode','TCNMMerchant_L.FTMerName'],
            DataColumnsFormat : ['',''],
            WidthModal      : 50,
            Perpage			: 10,
            OrderBy			: ['TCNMMerchant.FDCreateON'],
            SourceOrder		: "DESC"
        },
        CallBack:{
            ReturnType	: 'S',
            Value       : ["oetMerCode","TCNMMerchant.FTMerCode"],
            Text		: ["oetMerName","TCNMMerchant_L.FTMerName"],
        }
    }

    /*===== Begin Import Excel =========================================================*/
    function JSxOpenImportForm(){

        var tNameModule = 'AdjPrice';
        var tTypeModule = 'document';
        var tAfterRoute = 'JSxImportExcelCallback'; // call func
        var tFlagClearTmp = '1' // null = ไม่สนใจ 1 = ลบหมดเเล้วเพิ่มใหม่ 2 = เพิ่มต่อเนื่อง

        var aPackdata = {
        'tNameModule' : tNameModule,
        'tTypeModule' : tTypeModule,
        'tAfterRoute' : tAfterRoute,
        'tFlagClearTmp' : tFlagClearTmp
        };

        JSxImportPopUp(aPackdata);
    }

    function JSxImportExcelCallback(){
        JCNxOpenLoading();
        setTimeout(function(){
            JSvSpaPdtPriDataTable();
        }, 50);
    }
    /*===== End Import Excel ===========================================================*/

    //Functionality : Print Document
    function JSvADJPricePrintDoc(){
        var aInfor = [
            {"Lang"         : '<?=FCNaHGetLangEdit(); ?>'}, // Lang ID
            {"ComCode"      : '<?=FCNtGetCompanyCode(); ?>'}, // Company Code
            {"BranchCode"   : '<?=FCNtGetAddressBranch($tBchCode); ?>' }, // สาขาที่ออกเอกสาร
            {"DocCode"      : $('#oetXphDocNo').val()  }, // เลขที่เอกสาร
            {"DocBchCode"   : '<?=$tBchCode;?>' }
        ];
        window.open($("#ohdBaseUrl").val()+"formreport/Frm_SQL_ALLMPdtBillAdjustPrice?infor="+JCNtEnCodeUrlParameter(aInfor), '_blank');
    }

</script>
