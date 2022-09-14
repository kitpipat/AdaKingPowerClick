<script type="text/javascript">
    $(document).ready(function() {

        //ถ้าเป็น page 1 จะต้องซ่อนปุ่มย้อนกลับ
        var tClickPage = $('#ohdClickStep').val();
        if(tClickPage == 1){
            $('.xCNRefillBackStep').hide();        
        }

        //กดย้อนกลับ Back Step
        $('.xCNRefillBackStep').on('click', function(){
            var tCurrentTab = $('#ohdClickStep').val();
            if(tCurrentTab == 4){
                $('.xCNRefillVDStep3').click();
                $('#ohdClickStep').val(3);
                $('.xCNRefillNextStep').show();
            }else if(tCurrentTab == 3){
                $('.xCNRefillVDStep2').click();
                $('#ohdClickStep').val(2);
                $('.xCNRefillNextStep').show();
            }else if(tCurrentTab == 2){
                $('.xCNRefillVDStep1').click();
                $('#ohdClickStep').val(1);
                $('.xCNRefillBackStep').hide();
            }

        });

        //กดถัดไป Next Step
        $('.xCNRefillNextStep').on('click', function(){
            var tCurrentTab = $('#ohdClickStep').val();
            if(tCurrentTab == 1){
                $('.xCNRefillVDStep2').click();
                $('#ohdClickStep').val(2);
                $('.xCNRefillBackStep').show();
            }else if(tCurrentTab == 2){
                $('.xCNRefillVDStep3').click();
                $('#ohdClickStep').val(3);
                $('.xCNRefillBackStep').show();
            }else if(tCurrentTab == 3){
                $('.xCNRefillVDStep4').click();
                $('#ohdClickStep').val(4);
                $('.xCNRefillBackStep').show();
                $('.xCNRefillNextStep').hide();
            }
        });

        var nLangEdits = '<?= $this->session->userdata("tLangEdit"); ?>';

        $('.selectpicker').selectpicker('refresh');

        $('.xCNDatePicker').datepicker({
            format              : "yyyy-mm-dd",
            todayHighlight      : true,
            enableOnReadonly    : false,
            startDate           : '1900-01-01',
            disableTouchKeyboard: true,
            autoclose           : true
        });

        $('.xCNTimePicker').datetimepicker({
            format              : 'HH:mm:ss'
        });

        /* =============================== Check Box Auto GenCode ==============================*/
        $('#ocbRVDStaAutoGenCode').on('change', function(e) {
            if ($('#ocbRVDStaAutoGenCode').is(':checked')) {
                $("#oetRVDDocNo").val('');
                $("#oetRVDDocNo").attr("readonly", true);
                $('#oetRVDDocNo').closest(".form-group").css("cursor", "not-allowed");
                $('#oetRVDDocNo').css("pointer-events", "none");
                $("#oetRVDDocNo").attr("onfocus", "this.blur()");
                $('#ofmRVDFormAdd').removeClass('has-error');
                $('#ofmRVDFormAdd .form-group').closest('.form-group').removeClass("has-error");
                $('#ofmRVDFormAdd em').remove();
            } else {
                $('#oetRVDDocNo').closest(".form-group").css("cursor", "");
                $('#oetRVDDocNo').css("pointer-events", "");
                $('#oetRVDDocNo').attr('readonly', false);
                $("#oetRVDDocNo").removeAttr("onfocus");
            }
        });

        /* =============================== Click Tab ===========================================*/
        $('.xCNRefillVDCircle').on('click', function(){
            var tTab = $(this).data('tab');
            $('.xCNRefillVDCircle').removeClass('active');
            $(this).addClass('active');
            $('a[href="#'+tTab+'"]').tab('show');
        });
    });

    // =========== เลือกสาขาเอกสาร ===========
    $('#obtBrowseBchTransfer').click(function(){
        oBrowseRefillVending_Bch = oBrowseRefillVending_Bch_option({});
        JCNxBrowseData('oBrowseRefillVending_Bch');
    });
    var oBrowseRefillVending_Bch_option = function(paDataparameter){
        tUsrLevel = "<?=$this->session->userdata('tSesUsrLevel')?>";
        tBchMulti = "<?=$this->session->userdata("tSesUsrBchCodeMulti"); ?>";
        tSQLWhere = "";
        if(tUsrLevel != "HQ"){
            tSQLWhere = " AND TCNMBranch.FTBchCode IN ("+tBchMulti+") ";
        }

        var oOptionReturn = {
            Title: ['authen/user/user', 'tBrowseBCHTitle'],
            Table: {
                Master  : 'TCNMBranch',
                PK      : 'FTBchCode'
            },
            Join: {
                Table   : ['TCNMBranch_L'],
                On      : ['TCNMBranch_L.FTBchCode = TCNMBranch.FTBchCode AND TCNMBranch_L.FNLngID = ' + nLangEdits]
            },
            Where: {
                Condition   : [tSQLWhere]
            },
            GrideView: {
                ColumnPathLang      : 'authen/user/user',
                ColumnKeyLang       : ['tBrowseBCHCode', 'tBrowseBCHName'],
                ColumnsSize         : ['10%', '75%'],
                DataColumns         : ['TCNMBranch.FTBchCode', 'TCNMBranch_L.FTBchName'],
                DataColumnsFormat   : ['', ''],
                WidthModal          : 50,
                Perpage             : 10,
                OrderBy             : ['TCNMBranch.FTBchCode'],
                SourceOrder         : "ASC"
            },
            CallBack: {
                ReturnType          : 'S',
                Value               : ["oetRVDBchCode", "TCNMBranch.FTBchCode"],
                Text                : ["oetRVDBchName", "TCNMBranch_L.FTBchName"]
            },
            NextFunc: {
                FuncName            : 'JSxUnDisabledInWahouse',
                ArgReturn           : ['FTBchCode','FTBchName']
            },
            RouteAddNew     : 'branch',
            BrowseLev       : 1
        };
        return oOptionReturn;
    }
    function JSxUnDisabledInWahouse(poJsonData){
        if(poJsonData == 'NULL'){
            $('#obtBrowseWahTransfer').attr('disabled',true);
        }else{
            $('#obtBrowseWahTransfer').attr('disabled',false);

            var aResult = JSON.parse(poJsonData);
            //เงื่อนไข step 1 ต้องใช้สาขาตัวเดียวกัน
            $('#oetRVDConditionBCHCode').val(aResult[0]);
            $('#oetRVDConditionBCHName').val(aResult[1]);
        }
    }

    // =========== เลือกพนักงานขนส่ง / เติม ===========
    $('#obtBrowseCusTransfer').click(function(){
        oBrowseRefillVending_Employees = oBrowseRefillVending_Employees_option({});
        JCNxBrowseData('oBrowseRefillVending_Employees');
    });
    var oBrowseRefillVending_Employees_option = function(paDataparameter){
        var tAgnCode = '<?=$this->session->userdata("tSesUsrAgnCode")?>';

        if(tAgnCode == '' || tAgnCode == null){
            var tTableJoin      = ['TCNMUser_L'];
            var tTableJoinWhere = ['TCNMUser.FTUsrCode = TCNMUser_L.FTUsrCode AND TCNMUser_L.FNLngID = ' + nLangEdits + ' ']
            var tWhereCondition = "";
        }else{
            var tTableJoin      = ['TCNMUser_L','TCNTUsrGroup'];
            var tTableJoinWhere = ['TCNMUser.FTUsrCode = TCNMUser_L.FTUsrCode AND TCNMUser_L.FNLngID = ' + nLangEdits, 
                                   'TCNMUser.FTUsrCode = TCNTUsrGroup.FTUsrCode ']
            var tWhereCondition = ['AND TCNTUsrGroup.FTAgnCode = ' + tAgnCode + ' ']
        }

        var oOptionReturn   = {
            Title   : ['authen/user/user', 'tUSRTitle'],
            Table   : {
                Master  : 'TCNMUser',
                PK      : 'FTUsrCode'
            },
            Join    : {
                Table   : tTableJoin,
                On      : tTableJoinWhere
            },
            Where   : {
                Condition   : tWhereCondition
            },
            GrideView: {
                ColumnPathLang      : 'authen/user/user',
                ColumnKeyLang       : ['tUSRCode', 'tUSRTBName'],
                ColumnsSize         : ['10%', '30%'],
                WidthModal          : 50,
                DataColumns         : ['TCNMUser.FTUsrCode', 'TCNMUser_L.FTUsrName'],
                DataColumnsFormat   : ['', ''],
                Perpage             : 10,
                OrderBy             : ['TCNMUser.FTUsrCode DESC'],
            },
            CallBack: {
                ReturnType          : 'S',
                Value               : ['oetRVDCusTransferCode', "TCNMUser.FTUsrCode"],
                Text                : ['oetRVDCusTransferName', "TCNMUser_L.FTUsrName"]
            },
            // DebugSQL : true
        }
        return oOptionReturn;
    }

    // =========== เลือกคลังขนส่ง ====================
    $('#obtBrowseWahTransfer').click(function(){
        oBrowseRefillVending_Wahouse = oBrowseRefillVending_Wahouse_option({});
        JCNxBrowseData('oBrowseRefillVending_Wahouse');
    });
    var oBrowseRefillVending_Wahouse_option = function(paDataparameter){
        var tWhereBch = $('#oetRVDBchCode').val();
        var oOptionReturn   = {
            Title   : ['company/shop/shop', 'tSHPWah'],
            Table   : {
                Master  : 'TCNMWaHouse',
                PK      : 'FTWahCode'
            },
            Join    : {
                Table   : ['TCNMWaHouse_L'],
                On      : [
                            'TCNMWaHouse_L.FTWahCode = TCNMWaHouse.FTWahCode AND TCNMWaHouse_L.FTBchCode = TCNMWaHouse.FTBchCode  AND TCNMWaHouse_L.FNLngID = ' + nLangEdits, 
                        ]
            },
            Where   : {
                Condition   : ['AND TCNMWaHouse.FTBchCode = ' + tWhereBch + ' AND TCNMWaHouse.FTWahStaType != 6']
            },
            GrideView   : {
                ColumnPathLang      : 'company/shop/shop',
                ColumnKeyLang       : ['tWahCode','tWahName'],
                ColumnsSize         : ['10%','20%'],
                WidthModal          : 50,
                DataColumns         : ['TCNMWaHouse.FTWahCode', 'TCNMWaHouse_L.FTWahName'],
                DataColumnsFormat   : ['',''],
                Perpage             : 10,
                OrderBy             : ['TCNMWaHouse.FDCreateOn DESC']
            },
            CallBack: {
                ReturnType          : 'S',
                Value               : ["oetRVDWahTransferCode", "TCNMWaHouse.FTWahCode"],
                Text                : ["oetRVDWahTransferName", "TCNMWaHouse_L.FTWahName"],
            },
            // DebugSQL : true
        }
        return oOptionReturn;
    }

    // =========== เลือกขนส่งโดย ====================
    $('#obtBrowseWahTransferBy').click(function(){
        oBrowseRefillVending_Courier = oBrowseRefillVending_Courier_option({});
        JCNxBrowseData('oBrowseRefillVending_Courier');
    });
    var oBrowseRefillVending_Courier_option = function(paDataparameter){
        var oOptionReturn   = {
            Title   : ['shipvia/shipvia/shipvia', 'tVIATitle'],
            Table   : {
                Master  : 'TCNMShipVia',
                PK      : 'FTViaCode'
            },
            Join    : {
                Table   : ['TCNMShipVia_L'],
                On      : [
                            'TCNMShipVia.FTViaCode = TCNMShipVia_L.FTViaCode AND TCNMShipVia_L.FNLngID = ' + nLangEdits
                        ]
            },
            GrideView: {
                ColumnPathLang      : 'shipvia/shipvia/shipvia',
                ColumnKeyLang       : ['tVIACode', 'tVIAName'],
                ColumnsSize         : ['10%', '30%'],
                WidthModal          : 50,
                DataColumns         : ['TCNMShipVia.FTViaCode', 'TCNMShipVia_L.FTViaName'],
                DataColumnsFormat   : ['', ''],
                Perpage             : 10,
                OrderBy             : ['TCNMShipVia.FTViaCode DESC'],
            },
            CallBack: {
                ReturnType          : 'S',
                Value               : ['oetRVDWahTransferByCode', "TCNMShipVia.FTViaCode"],
                Text                : ['oetRVDWahTransferByName', "TCNMShipVia_L.FTViaName"]
            },
            RouteAddNew             : 'shipvia',
            BrowseLev               : 0,
        }
        return oOptionReturn;
    }

    // =========== เหตุผล ==========================
    $('#obtBrowseRVDReason').click(function(){
        oBrowseRefillVending_Reason = oBrowseRefillVending_Reason_option({});
        JCNxBrowseData('oBrowseRefillVending_Reason');
    });
    var oBrowseRefillVending_Reason_option = function(paDataparameter){
        var oOptionReturn   = {
            Title   : ['other/reason/reason', 'tRSNTitle'],
            Table   : {
                Master  : 'TCNMRsn',
                PK      : 'FTRsnCode'
            },
            Join    : {
                Table   : ['TCNMRsn_L','TSysRsnGrp_L'],
                On      : [
                            'TCNMRsn.FTRsnCode = TCNMRsn_L.FTRsnCode AND TCNMRsn_L.FNLngID = ' + nLangEdits ,
                            'TCNMRsn.FTRsgCode = TSysRsnGrp_L.FTRsgCode' 
                        ]
            },
            Where   : {
                Condition   : [' AND TSysRsnGrp_L.FTRsgCode = 013']
            },
            GrideView: {
                ColumnPathLang      : 'other/reason/reason',
                ColumnKeyLang       : ['tRSNTBCode', 'tRSNTBName'],
                ColumnsSize         : ['10%', '30%'],
                WidthModal          : 50,
                DataColumns         : ['TCNMRsn.FTRsnCode', 'TCNMRsn_L.FTRsnName'],
                DataColumnsFormat   : ['', ''],
                Perpage             : 10,
                OrderBy             : ['TCNMRsn.FDCreateOn DESC'],
            },
            CallBack: {
                ReturnType          : 'S',
                Value               : ['oetRVDReasonCode', "TCNMRsn.FTRsnCode"],
                Text                : ['oetRVDReasonName', "TCNMRsn_L.FTRsnName"]
            },
            // DebugSQL : true
        }
        return oOptionReturn;
    }

    //กดพิพม์เอกสารแม่ - เอกสารใบเติมสินค้าแบบชุด
    function JSxRVDPrintDocument(){
        var aInfor = [
            {"Lang"         : '<?=FCNaHGetLangEdit(); ?>'},
            {"ComCode"      : '<?=FCNtGetCompanyCode(); ?>'}, 
            {"BranchCode"   : '<?=FCNtGetAddressBranch($tRVDBchCode); ?>' }, 
            {"DocCode"      : $('#oetRVDDocNo').val() } 
        ];

        window.open("<?=base_url(); ?>formreport/Frm_SQL_SMBillRefillSet?infor=" + JCNtEnCodeUrlParameter(aInfor), '_blank');
    }

    //กดพิมพ์เอกสารลูก - เอกสารใบเติมสินค้าแบบเดียว
    // LastUpdate : Napat(Jame) 21/02/2022 พิมพ์เอกสารใบโอนระหว่างคลัง
    function JSvRVDPrintDocumentTopup(){
        var tDocNo = $('#ohdDocumentprintTopup').val();
        var aTextDocument = tDocNo.split(",");
        for(var i=0; i<aTextDocument.length; i++){
            var aInfor = [
                {"Lang"         : '<?=FCNaHGetLangEdit(); ?>'}, // Lang ID
                {"ComCode"      : '<?=FCNtGetCompanyCode(); ?>'}, // Company Code
                {"BranchCode"   : '<?=FCNtGetAddressBranch($tRVDBchCode); ?>'}, // สาขาที่ออกเอกสาร
                {"DocCode"      : aTextDocument[i]}, // เลขที่เอกสาร
                {"DocBchCode"   : '<?=$tRVDBchCode;?>'}
            ];
            window.open("<?=base_url(); ?>formreport/ALLMPdtBillTnf?infor=" + JCNtEnCodeUrlParameter(aInfor), '_blank');
        }
    }

</script>