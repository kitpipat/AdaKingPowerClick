<script type="text/javascript">
    // Set Lang Edit 
    var nLangEdits  = <?php echo $this->session->userdata("tLangEdit")?>;
    var tBchCode    = $('#oetBchCode').val();
    // Option Warehouse
    var oBchBrowseWah = {
        Title: ['company/warehouse/warehouse','tWAHTitle'],
        Table: {Master:'TCNMWaHouse',PK:'FTWahCode'},
        Join: {
            Table:	['TCNMWaHouse_L'],
            On:['TCNMWaHouse_L.FTWahCode = TCNMWaHouse.FTWahCode AND TCNMWaHouse_L.FTBchCode = TCNMWaHouse.FTBchCode AND TCNMWaHouse_L.FNLngID = '+nLangEdits,]
        },
        Where :{
            Condition : ["AND TCNMWaHouse.FTWahStaType IN ('1','2') AND TCNMWaHouse.FTWahRefCode = '"+tBchCode+"' "]
        },
        GrideView:{
            ColumnPathLang	: 'company/warehouse/warehouse',
            ColumnKeyLang	: ['tWahCode','tWahName'],
            ColumnsSize     : ['15%','75%'],
            WidthModal      : 50,
            DataColumns		: ['TCNMWaHouse.FTWahCode','TCNMWaHouse_L.FTWahName'],
            DataColumnsFormat : ['',''],
            Perpage			: 10,
            OrderBy			: ['TCNMWaHouse.FDCreateOn DESC'],
        },
        CallBack:{
            ReturnType	: 'S',
            Value		: ["oetBchWahCode","TCNMWaHouse.FTWahCode"],
            Text		: ["oetBchWahName","TCNMWaHouse_L.FTWahName"],
        },
        RouteFrom : 'branch',
        RouteAddNew : 'warehouse',
        BrowseLev : nStaBchBrowseType,
    }

    var oBchBrowsePpl = {
        Title : ['product/pdtpricelist/pdtpricelist', 'tPPLTitle'],
        Table:{Master:'TCNMPdtPriList', PK:'FTPplCode'},
        Join :{
            Table: ['TCNMPdtPriList_L'],
            On: ['TCNMPdtPriList_L.FTPplCode = TCNMPdtPriList.FTPplCode AND TCNMPdtPriList_L.FNLngID = '+nLangEdits]
        },
        Where :{
            // Condition : ["AND TCNMBranch.FTWahStaType = '3' "]
        },
        GrideView:{
            ColumnPathLang	: 'product/pdtpricelist/pdtpricelist',
            ColumnKeyLang	: ['tPPLTBCode', 'tPPLTBName'],
            ColumnsSize     : ['15%', '85%'],
            WidthModal      : 50,
            DataColumns		: ['TCNMPdtPriList.FTPplCode', 'TCNMPdtPriList_L.FTPplName'],
            DataColumnsFormat : ['', ''],
            Perpage			: 10,
            OrderBy			: ['TCNMPdtPriList.FDCreateOn DESC'],
        },
        CallBack:{
            ReturnType	: 'S',
            Value		: ["oetBchPplRetCode", "TCNMPdtPriList.FTPplCode"],
            Text		: ["oetBchPplRetName", "TCNMPdtPriList.FTPplName"]
        },
        RouteAddNew : 'pdtpricegroup',
        BrowseLev : nStaBchBrowseType
    };

    var oBchBrowseMer = {
        Title : ['company/branch/branch', 'tBchMerChant'],
        Table:{Master:'TCNMMerchant', PK:'FTMerCode'},
        Join :{
            Table: ['TCNMMerchant_L'],
            On: ['TCNMMerchant_L.FTMerCode = TCNMMerchant.FTMerCode AND TCNMMerchant_L.FNLngID = '+nLangEdits]
        },
        GrideView:{
            ColumnPathLang	: 'company/branch/branch',
            ColumnKeyLang	: ['tBCHCode', 'tBCHName'],
            ColumnsSize     : ['15%', '85%'],
            WidthModal      : 50,
            DataColumns		: ['TCNMMerchant.FTMerCode', 'TCNMMerchant_L.FTMerName'],
            DataColumnsFormat : ['', ''],
            Perpage			: 10,
            OrderBy			: ['TCNMMerchant.FDCreateOn DESC'],
        },
        CallBack:{
            ReturnType      : 'S',
            Value           : ["oetBchMerCode", "TCNMMerchant.FTMerCode"],
            Text            : ["oetBchMerName", "TCNMMerchant_L.FTMerName"]
        },
        RouteAddNew : 'merchant',
        BrowseLev : nStaBchBrowseType
    };

    var tAgnCodeSession = '<?php echo $this->session->userdata("tSesUsrAgnCode"); ?>';
    var tAgnNameSession = '<?php echo $this->session->userdata("tSesUsrAgnName"); ?>';
    var tUsrLevSession = '<?php echo $this->session->userdata("tSesUsrLevel"); ?>';
    var tWhereAgn = "";

    if(tUsrLevSession != "HQ"){
        tWhereAgn = " AND TCNMAgency.FTAgnCode = '"+tAgnCodeSession+"' ";
        $('#obtBchBrowseAgency').attr('disabled',true);
        $('#oetBchAgnCode').val(tAgnCodeSession);
        $('#oetBchAgnName').val(tAgnNameSession);
    }else{
        tWhereAgn = "";
    }

    var oBchBrowseAgency = {
        Title : ['company/branch/branch', 'tBchAgnTitle'],
        Table:{Master:'TCNMAgency', PK:'FTAgnCode'},
        Join :{
            Table: ['TCNMAgency_L'],
            On: [' TCNMAgency.FTAgnCode = TCNMAgency_L.FTAgnCode AND TCNMAgency_L.FNLngID = '+nLangEdits]
        },
        Where :{
            Condition : [tWhereAgn]
        },
        GrideView:{
            ColumnPathLang	: 'company/branch/branch',
            ColumnKeyLang	: ['tBchAgnCode', 'tBchAgnName'],
            ColumnsSize     : ['15%', '85%'],
            WidthModal      : 50,
            DataColumns		: ['TCNMAgency.FTAgnCode', 'TCNMAgency_L.FTAgnName'],
            DataColumnsFormat : ['', ''],
            Perpage			: 10,
            OrderBy			: ['TCNMAgency.FDCreateOn DESC'],
        },
        CallBack:{
            ReturnType      : 'S',
            Value           : ["oetBchAgnCode", "TCNMAgency.FTAgnCode"],
            Text            : ["oetBchAgnName", "TCNMAgency_L.FTAgnName"]
        },
        RouteAddNew : 'agency',
        BrowseLev : nStaBchBrowseType
    };

    // Create By Napat(Jame) 11/06/2020
    function JSxBCHChkBchTypeShowAGNBrowse(){
        var tChkBchType = $('#ocmBchType').val();
        if(tChkBchType == "2" || tChkBchType == "4"){
            if('<?=$tBchAgnCode;?>' == '' || null){
                $('.xWBchDisplayAgency').show();
                $('#oetBchAgnCode').val(tAgnCodeSession);
                $('#oetBchAgnName').val(tAgnNameSession);
            }else{
                $('.xWBchDisplayAgency').show();
                $('#oetBchAgnCode').val();
                $('#oetBchAgnName').val();
            }
            // $('.xWBchDisplayAgency').show();
            // $('#oetBchAgnCode').val(tAgnCodeSession);
            // $('#oetBchAgnName').val(tAgnNameSession);
        }else{
            $('.xWBchDisplayAgency').hide();
            $('#oetBchAgnCode').val('');
            $('#oetBchAgnName').val('');
        }
    }

    // ตอนเลือก branch type ให้ตรวจสอบ ว่าต้องเปิด browse agency ไหม
    $('#ocmBchType').change(function(){
        JSxBCHChkBchTypeShowAGNBrowse();
    });

    $(document).ready(function(){

        // ตรวจสอบ branch type ตอนเข้าหน้าจอ add/edit
        JSxBCHChkBchTypeShowAGNBrowse();

        $('.selectpicker').selectpicker('refresh');

        $('.xCNDatePicker').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true,
            startDate: new Date(),
        });

        if(JCNbBrachIsCreatePage()){
            //Brach Code
            $("#oetBchCode").attr("disabled", true);
            $("#oetBchCode").attr("disabled", true);

            $('#ocbBrachAutoGenCode').change(function(){
    
                if($('#ocbBrachAutoGenCode').is(':checked')) {
                    $('#oetBchCode').val('');
                    $("#oetBchCode").attr("disabled", true);
                    $('#odvBchCodeForm').removeClass('has-error');
                    $('#odvBchCodeForm em').remove();
                }else{
                    $("#oetBchCode").attr("disabled", false);
                }
            });
            JSxBrachVisibleComponent('#ocbBrachAutoGenCode', true);
        }

        $('#oimBchBrowsePpl').click(function(){
			JSxCheckPinMenuClose();
            JCNxBrowseData('oBchBrowsePpl');
        });


        $('#oimBchBrowseMer').click(function(){
            JSxCheckPinMenuClose();
            JCNxBrowseData('oBchBrowseMer');
        });

        $('#obtBchBrowseAgency').click(function(){
            JSxCheckPinMenuClose();
            JCNxBrowseData('oBchBrowseAgency');
        });



        if(JCNbBrachIsUpdatePage()){
            // Brach Code
            $("#oetBchCode").attr("readonly", true);
            $('#ocbBrachAutoGenCode input').attr('disabled', true);
            JSxBrachVisibleComponent('#ocbBrachAutoGenCode', false);    
        }

        $('#oetBchCode').blur(function(){
            JSxCheckBrachCodeDupInDB();
        });

    //Functionality : Event Check Brach
    //Parameters : Event Blur Input Brach Code
    //Creator : 20/09/2019 Saharat (Golf)
    //Return : -
    //Return Type : -
    function JSxCheckBrachCodeDupInDB(){
        if(!$('#ocbBrachAutoGenCode').is(':checked')){
            $.ajax({
                type: "POST",
                url: "CheckInputGenCode",
                data: { 
                    tTableName: "TCNMBranch",
                    tFieldName: "FTBchCode",
                    tCode: $("#oetBchCode").val()
                },
                cache: false,
                timeout: 0,
                success: function(tResult){
                    var aResult = JSON.parse(tResult);
                    $("#ohdCheckDuplicateBchCode").val(aResult["rtCode"]);  
                // Set Validate Dublicate Code
                $.validator.addMethod('dublicateCode', function(value, element) {
                    if($("#ohdCheckDuplicateBchCode").val() == 1){
                        return false;
                    }else{
                        return true;
                    }
                },'');

                // From Summit Validate
                $('#ofmAddBranch').validate({
                    rules: {
                        oetBchCode : {
                            "required" :{
                                // ตรวจสอบเงื่อนไข validate
                                depends: function(oElement) {
                                if($('#ocbBrachAutoGenCode').is(':checked')){
                                    return false;
                                }else{
                                    return true;
                                }
                                }
                            },
                            "dublicateCode" :{}
                        },
                        oetBchName :     {"required" :{}},
                        oetBchRegNo:     {"required" :{}},
                    },
                    messages: {
                        oetBchCode : {
                            "required"      : $('#oetBchCode').attr('data-validate-required'),
                            "dublicateCode" : $('#oetBchCode').attr('data-validate-dublicateCode')
                        },
                        oetBchName : {
                            "required"      : $('#oetBchName').attr('data-validate-required'),
                        },
                        oetBchRegNo : {
                            "required"      : $('#oetBchRegNo').attr('data-validate-required'),
                        },
                    },
                    errorElement: "em",
                    errorPlacement: function (error, element ) {
                        error.addClass( "help-block" );
                        if ( element.prop( "type" ) === "checkbox" ) {
                            error.appendTo( element.parent( "label" ) );
                        } else {
                            var tCheck = $(element.closest('.form-group')).find('.help-block').length;
                            if(tCheck == 0){
                                error.appendTo(element.closest('.form-group')).trigger('change');
                            }
                        }
                    },
                    highlight: function ( element, errorClass, validClass ) {
                        $( element ).closest('.form-group').addClass( "has-error" ).removeClass( "has-success" );
                    },
                    unhighlight: function (element, errorClass, validClass) {
                        $( element ).closest('.form-group').addClass( "has-success" ).removeClass( "has-error" );
                    },
                    submitHandler: function(form){}
                });

                // Submit From brach
                $('#ofmAddBranch').submit();

                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });

        }    
    }




        // Set Event Click 
        $('#obtBchBrowseWah').unbind().click(function(){JCNxBrowseData('oBchBrowseWah');});
        $('#obtBchStart').unbind().click(function(){$('#oetBchStart').datepicker('show');});
        $('#obtBchStop').unbind().click(function(){$('#oetBchStop').datepicker('show');});
        $('#obtBchSaleStart').unbind().click(function(){$('#oetBchSaleStart').datepicker('show');});
        $('#obtBchSaleStop').unbind().click(function(){$('#oetBchSaleStop').datepicker('show');});
        $('#obtCrdStartDate').unbind().click(function(){
            $('#oetCrdStartDate').datepicker({
                format: "yyyy-mm-dd",
                todayHighlight: true,
                enableOnReadonly: false,
                startDate :'1900-01-01',
                disableTouchKeyboard : true,
                autoclose: true,
            });
            $('#oetCrdStartDate').datepicker('show');
        });


        // Event Click Tab
        $('#odvBranchPanelBody .xCNBCHTab').unbind().click(function(){
            let tRoutePage  = '<?php echo @$tRoute;?>';
            if(tRoutePage == 'branchEventAdd'){
                return;
            }else{
                let tTypeTab    = $(this).data('typetab');
                if(typeof(tTypeTab) !== undefined && tTypeTab == 'main'){
                    // *** Click Tab ข้อมูลทั่วไป
                    JCNxOpenLoading();
                    setTimeout(function(){
                        $('#odvBtnCmpEditInfo').show();
                        JCNxCloseLoading();
                        return;
                    },500);
                }else if(typeof(tTypeTab) !== undefined && tTypeTab == 'sub'){
                    $('#odvBtnCmpEditInfo').hide();
                    let tTabTitle   = $(this).data('tabtitle');
                    switch(tTabTitle){
                        case 'bchsetconnection':
                            // *** Click Tab ตั้งค่าการเชื่อมต่อ
                            JSxBranchSetingConnection();
                        break;
                        case 'bchaddress':
                            // *** Click Tab ที่อยู่
                            JCNvCallBCHContentAddress();
                        break;
                        default:
                            return;
                    }   
                }else{
                    return;
                }
            }
        });
    });

    //Get Data BranchCode    
    //Create By Witsarut 10/09/2019
    //Functionality : Event Check Bracnh
    function JSxBranchSetingConnection(){
        var ptBchCode   = '<?php echo $tBchCode;?>';
        // Check Login Expried
        var nStaSession = JCNxFuncChkSessionExpired();
        //if have Session 
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            $.ajax({
                type    : "POST",
                url     : 'BchSettingCon',
                data    : {
                    tBchCode    : ptBchCode
                },
                cache   : false,
                timeout : 0,
                success : function (tResult){
                    $('#odvBranchSetConnection').html(tResult);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }else{
            JCNxShowMsgSessionExpired();
        }
    }

    // Function: Call View Shop Address
	// Parameters: Event Click Tab
	// Creator: 11/09/2019 wasin(Yoshi)
	// Return: View
	// ReturnType: View
	function JCNvCallBCHContentAddress(){
        let tBchAddressCode	= '<?php echo @$tBchCode;?>';
        let tBchAddressName	= '<?php echo @$tBchName;?>';
        let nStaSession		= JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JCNxOpenLoading();
            $.ajax({
                type : "POST",
                url : "branchAddressData",
                data : {
                    'ptBchCode'	: tBchAddressCode,
                    'ptBchName'	: tBchAddressName
                },
                success	: function(tResult){
                    $('#odvBranchDataAddress').html(tResult);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }else{
            JCNxShowMsgSessionExpired();
        }
	}







</script>