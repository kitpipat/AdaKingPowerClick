<script type="text/javascript">
 $(document).ready(function(){

    $(document).on("keypress", 'form', function (e) {
        var code = e.keyCode || e.which;
        if (code == 13) {
            e.preventDefault();
            return false;
        }
    });

    $('.form-control').on("keypress",function(e){
        var code = e.keyCode || e.which;
        if (code == 13) {
            var nIndex = $(".form-control:not(:disabled):input[type='text']:input:not([readonly]):input:not([type=hidden])").index($(this));
            $(".form-control:not(:disabled):input[type='text']:input:not([readonly]):input:not([type=hidden])").eq( nIndex + 1 ).focus().select();
        }
    });

    $.ajax({
        type    : "POST",
        url     : "SettingConfigLoadViewSearch",
        data    : {
            ptTypePage : 'Agency'
        },
        cache   : false,
        timeout : 0,
        success : function (tResult) {
            $("#odvInforSettingconfig").html(tResult);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });

    $('.selectpicker').selectpicker();
    if(JSbAgencyIsCreatePage()){
        //Agency Code
        $("#oetAgnCode").attr("disabled", true);
        $('#ocbAgencyAutoGenCode').change(function(){
            if($('#ocbAgencyAutoGenCode').is(':checked')) {
                $('#oetAgnCode').val('');
                $("#oetAgnCode").attr("disabled", true);
                $('#odvAgnCodeForm').removeClass('has-error');
                $('#odvAgnCodeForm em').remove();
            }else{
                $("#oetAgnCode").attr("disabled", false);
            }
        });
        JSxAgencyVisibleComponent('#ocbVatrateAutoGenCode', true);
    }
    
    if(JSbAgencyIsUpdatePage()){
        // Agency Code
        $("#oetAgnCode").attr("readonly", true);
        $('#odvAgnAutoGenCode input').attr('disabled', true);
        JSxAgencyVisibleComponent('#odvAgnAutoGenCode', false);    

        }


               // Event Browse สกุลเงิน
               $('#obtAgnBrowseCurrency').click(function() { 
            poElement = this;
            if (poElement.getAttribute("data-dblclick") == null) {
                poElement.setAttribute("data-dblclick", 1);
                $(poElement).select();
                setTimeout(function () {
                    if (poElement.getAttribute("data-dblclick") == 1) {
                        var nStaSession = JCNxFuncChkSessionExpired();
                        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                            // Create By Witsarut 04/10/2019
                                JSxCheckPinMenuClose();
                             // Create By Witsarut 04/10/2019
                            window.oAgnCurrencyOption   = undefined;
                            oAgnCurrencyOption          = oAgnCurrency({
                                'tReturnInputCode'  : 'oetAgnRteCode',
                                'tReturnInputName'  : 'oetAgnRteName',
                            });
                            JCNxBrowseData('oAgnCurrencyOption');
                        }else{
                            JCNxShowMsgSessionExpired();
                        }
                    }
                    poElement.removeAttribute("data-dblclick");
                }, 300);
            }
        });

        // Event Browse อัตรภาษี
        $('#obtAgnBrowseVatRate').click(function() { 
            poElement = this;
            if (poElement.getAttribute("data-dblclick") == null) {
                poElement.setAttribute("data-dblclick", 1);
                $(poElement).select();
                setTimeout(function () {
                    if (poElement.getAttribute("data-dblclick") == 1) {
                        var nStaSession = JCNxFuncChkSessionExpired();
                        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                             // Create By Witsarut 04/10/2019
                                JSxCheckPinMenuClose();
                             // Create By Witsarut 04/10/2019
                            window.oAgnVatRateOption   = undefined;
                            oAgnVatRateOption          = oAgnVatRate({
                                'tReturnInputCode'  : 'oetVatRateCode',
                                'tReturnInputName'  : 'oetVatRateName',
                            });
                            JCNxBrowseData('oAgnVatRateOption');
                        }else{
                            JCNxShowMsgSessionExpired();
                        }
                    }
                    poElement.removeAttribute("data-dblclick");
                }, 300);
            }
        });

        
    });
    $('#oetAgnCode').blur(function(){
        JSxCheckAgencyCodeDupInDB();
    });

        
    $('#oimAGNBrowsePpl').click(function(){
		// Create By Witsarut 04/10/2019
			JSxCheckPinMenuClose();
		// Create By Witsarut 04/10/2019
		JCNxBrowseData('oAGNBrowsePpl');
	});

    //Functionality : Event Check Agency
    //Parameters : Event Blur Input Agency Code
    //Creator : 25/03/2019 wasin (Yoshi)
    //Update : 30/05/2019 saharat (Golf)
    //Return : -
    //Return Type : -
    function JSxCheckAgencyCodeDupInDB(){
        if(!$('#ocbAgencyAutoGenCode').is(':checked')){
            $.ajax({
                type: "POST",
                url: "CheckInputGenCode",
                data: { 
                    tTableName: "TCNMAgency",
                    tFieldName: "FTAgnCode",
                    tCode: $("#oetAgnCode").val()
                },
                cache: false,
                timeout: 0,
                success: function(tResult){
                    var aResult = JSON.parse(tResult);
                    $("#ohdCheckDuplicateAgnCode").val(aResult["rtCode"]);  
                // Set Validate Dublicate Code
                $.validator.addMethod('dublicateCode', function(value, element) {
                    if($("#ohdCheckDuplicateAgnCode").val() == 1){
                        return false;
                    }else{
                        return true;
                    }
                },'');

                // From Summit Validate
                $('#ofmAddAgn').validate({
                    rules: {
                        oetAgnCode : {
                            "required" :{
                                // ตรวจสอบเงื่อนไข validate
                                depends: function(oElement) {
                                if($('#ocbAgencyAutoGenCode').is(':checked')){
                                    return false;
                                }else{
                                    return true;
                                }
                                }
                            },
                            "dublicateCode" :{}
                        },
                        oetAgnName:     {"required" :{}},
                        oetAgnEmail:     {"required" :{}},
                        oetVatRateName:   {"required" :{}},
                        oetAgnRteName:    {"required" :{}},
                    },
                    messages: {
                        oetAgnCode : {
                            "required"      : $('#oetAgnCode').attr('data-validate-required'),
                            "dublicateCode" : $('#oetAgnCode').attr('data-validate-dublicateCode')
                        },
                        oetAgnName : {
                            "required"      : $('#oetAgnName').attr('data-validate-required'),
                        },
                        oetAgnEmail : {
                            "required"      : $('#oetAgnEmail').attr('data-validate-required'),
                        },
                        oetVatRateName : {
                            "required"      : $('#oetVatRateName').attr('data-validate-required'),
                        },
                        oetAgnRteName : {
                            "required"      : $('#oetAgnRteName').attr('data-validate-required'),
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

                // Submit From
                $('#ofmAddAgn').submit();

                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });

        }    
    }


    $('ducument').ready(function(){
    JSxShowButtonChoose();
	var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
	var nlength = $('#odvRGPList').children('tr').length;
	for($i=0; $i < nlength; $i++){
		var tDataCode = $('#otrCoupon'+$i).data('code')
		if(aArrayConvert == null || aArrayConvert == ''){
		}else{
			var aReturnRepeat = findObjectByKey(aArrayConvert[0],'nCode',tDataCode);
			if(aReturnRepeat == 'Dupilcate'){
				$('#ocbListItem'+$i).prop('checked', true);
			}else{ }
		}
	}

	$('.ocbListItem').click(function(){
        var nCode = $(this).parent().parent().parent().data('code');  //code
        var tName = $(this).parent().parent().parent().data('name');  //code
        $(this).prop('checked', true);
        var LocalItemData = localStorage.getItem("LocalItemData");
        var obj = [];
        if(LocalItemData){
            obj = JSON.parse(LocalItemData);
        }else{ }
        var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
        if(aArrayConvert == '' || aArrayConvert == null){
            obj.push({"nCode": nCode, "tName": tName });
            localStorage.setItem("LocalItemData",JSON.stringify(obj));
            JSxPaseCodeDelInModal();
        }else{
            var aReturnRepeat = findObjectByKey(aArrayConvert[0],'nCode',nCode);
            if(aReturnRepeat == 'None' ){           //ยังไม่ถูกเลือก
                obj.push({"nCode": nCode, "tName": tName });
                localStorage.setItem("LocalItemData",JSON.stringify(obj));
                JSxPaseCodeDelInModal();
            }else if(aReturnRepeat == 'Dupilcate'){	//เคยเลือกไว้แล้ว
                localStorage.removeItem("LocalItemData");
                $(this).prop('checked', false);
                var nLength = aArrayConvert[0].length;
                for($i=0; $i<nLength; $i++){
                    if(aArrayConvert[0][$i].nCode == nCode){
                        delete aArrayConvert[0][$i];
                    }
                }
                var aNewarraydata = [];
                for($i=0; $i<nLength; $i++){
                    if(aArrayConvert[0][$i] != undefined){
                        aNewarraydata.push(aArrayConvert[0][$i]);
                    }
                }
                localStorage.setItem("LocalItemData",JSON.stringify(aNewarraydata));
                JSxPaseCodeDelInModal();
            }
        }
        JSxShowButtonChoose();
    })
});

var nLangEdits = <?=$this->session->userdata("tLangEdit")?>;

$('#oimAgnBrowseBch').click(function(){
    JSxCheckPinMenuClose();
    JCNxBrowseData('oBrowseBch');
});


tUsrLevel   = "<?=$this->session->userdata('tSesUsrLevel')?>";
tBchMulti   = "<?=$this->session->userdata("tSesUsrBchCodeMulti"); ?>";

tSQLWhere   = "";

if(tUsrLevel != "HQ"){
    tSQLWhere = " AND TCNMBranch.FTBchCode IN ("+tBchMulti+") ";
}

var oBrowseBch = {
    Title : ['company/branch/branch','tBCHTitle'],
    Table:{Master:'TCNMBranch',PK:'FTBchCode',PKName:'FTBchName'},
    Join :{
        Table:	['TCNMBranch_L'],
        On:['TCNMBranch_L.FTBchCode = TCNMBranch.FTBchCode AND TCNMBranch_L.FNLngID = '+nLangEdits,]
    },
    Where: {
        Condition: [tSQLWhere]
    },
    GrideView:{
        ColumnPathLang	: 'company/branch/branch',
        ColumnKeyLang	: ['tBCHCode','tBCHName'],
        ColumnsSize     : ['15%','75%'],
        WidthModal      : 50,
        DataColumns		: ['TCNMBranch.FTBchCode','TCNMBranch_L.FTBchName'],
        DataColumnsFormat : ['',''],
        Perpage			: 10,
        OrderBy			: ['TCNMBranch.FDCreateOn DESC'],
    },
    CallBack:{
        ReturnType	: 'S',
        Value		: ["oetAgnBchCode","TCNMBranch.FTBchCode"],
        Text		: ["oetAgnBchName","TCNMBranch_L.FTBchName"],
    },
    RouteAddNew : 'branch',
    // BrowseLev : nStaShpBrowseType
}




var oAGNBrowsePpl = {
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
		Value		: ["oetAGNPplRetCode", "TCNMPdtPriList.FTPplCode"],
		Text		: ["oetAGNPplRetName", "TCNMPdtPriList.FTPplName"]
	},
	RouteAddNew : 'pdtpricegroup',
	BrowseLev : $('#oetANGStaBrowse').val()
};

    
    // Option Currency
    var oAgnCurrency    = function(poDataFnc){
        var tInputReturnCode    = poDataFnc.tReturnInputCode;
        var tInputReturnName    = poDataFnc.tReturnInputName;
        var oOptionReturn       = {
            Title   : ['payment/rate/rate','tRTETitle'],
            Table   :{Master:'TFNMRate',PK:'FTRteCode'},
            Join    :{
                Table : ['TFNMRate_L'],
                On : ['TFNMRate_L.FTRteCode = TFNMRate.FTRteCode AND TFNMRate_L.FNLngID = '+nLangEdits,]
            },
            GrideView:{
                ColumnPathLang	: 'payment/rate/rate',
                ColumnKeyLang	: ['tRTETBRteCode','tRTETBRteName'],
                ColumnsSize     : ['10%','75%'],
                DataColumns		: ['TFNMRate.FTRteCode','TFNMRate_L.FTRteName'],
                DataColumnsFormat : ['',''],
                WidthModal      : 50,
                Perpage			: 10,
                OrderBy			: ['TFNMRate.FDCreateOn DESC'],
            },
            CallBack:{
                ReturnType	: 'S',
                Value		: [tInputReturnCode,"TFNMRate.FTRteCode"],
                Text		: [tInputReturnName,"TFNMRate_L.FTRteName"],
            },
            RouteAddNew : 'rate',
            BrowseLev : $('#oetANGStaBrowse').val(),
            // DebugSQL : true
        };
        return oOptionReturn;
    }
    var oAgnVatRate     = function(poDataFnc){
        var tInputReturnCode    = poDataFnc.tReturnInputCode;
        var tInputReturnName    = poDataFnc.tReturnInputName;
        var tTextLeftJoin       = "( SELECT Result.* ";
            tTextLeftJoin       += " FROM ";
            tTextLeftJoin       += " ( ";
            tTextLeftJoin       += "   SELECT VatAtv.* FROM (  ";
            tTextLeftJoin       += "     SELECT  ";
            tTextLeftJoin       += "        row_number() over (partition by TCNMVatRate.FTVatCode order by FDVatStart DESC) as VatRateActive, ";
            tTextLeftJoin       += "        TCNMVatRate.FDVatStart, ";
            tTextLeftJoin       += "        TCNMVatRate.FTVatCode,  ";
            tTextLeftJoin       += "        TCNMVatRate.FCVatRate ";
            tTextLeftJoin       += "     FROM TCNMVatRate ";
            tTextLeftJoin       += "     WHERE 1 = 1 ";
            tTextLeftJoin       += "    AND (CONVERT(VARCHAR(19), GETDATE(), 121) >= CONVERT(VARCHAR(19), TCNMVatRate.FDVatStart, 121)) ";
            tTextLeftJoin       += " ) VatAtv WHERE VatAtv.VatRateActive = 1 ";
            tTextLeftJoin       += " ) AS Result ";
            tTextLeftJoin       += ") AS TVJOIN ";

        var oOptionReturn       = {
            Title : ['company/vatrate/vatrate','tVATTitle'],
            Table : {Master:'TCNMVatRate',PK:'FTVatCode'},
            Join    :{
                Table : [tTextLeftJoin],
                SpecialJoin : ['INNER JOIN'],
                On : ['TCNMVatRate.FTVatCode = TVJOIN.FTVatCode AND TCNMVatRate.FDVatStart = TVJOIN.FDVatStart']
            },
            GrideView :{
                ColumnPathLang	: 'company/vatrate/vatrate',
                ColumnKeyLang	: ['tVATTBCode','tVATTBRate','tVATDateStart'],
                DataColumns		: ['TCNMVatRate.FTVatCode','TCNMVatRate.FCVatRate','TCNMVatRate.FDVatStart'],
                Perpage			: 10,
                OrderBy			: ['TCNMVatRate.FDCreateOn DESC'],
            },
            CallBack:{
                ReturnType	: 'S',
                Value		: [tInputReturnCode,"TCNMVatRate.FTVatCode"],
                Text		: [tInputReturnName,"TCNMVatRate.FCVatRate"],
            },
            // DebugSQL : true
        };
        return oOptionReturn;
    }

    $('#oimAgnBrowseChanel').click(function() {
        JSxCheckPinMenuClose();
        var tAgnCodeParam = $('#oetAgnCode').val();
        window.oBrowsePosOption = undefined;
        oBrowseAgnOption = oAGNBrowseChanel({
            'tAgnCodeParam': tAgnCodeParam
        });
        JCNxBrowseData('oBrowseAgnOption');
    });

    var tUsrLevel = "<?php echo $this->session->userdata("tSesUsrLevel"); ?>";
    var tSesUsrLoginLevel = "<?php echo $this->session->userdata("tSesUsrLoginLevel"); ?>";
    var tBchCodeMulti = "<?php echo $this->session->userdata("tSesUsrBchCodeMulti"); ?>";
    var nCountBch = "<?php echo $this->session->userdata("nSesUsrBchCount"); ?>";
    var tUsrAgnCode = "<?php echo $this->session->userdata("tSesUsrAgnCode"); ?>";
    var tWhere = "";
    var tAgnCode = $('#oetAgnCode').val();

    if (tUsrLevel != "HQ") {
        if (tAgnCode != "") {
            tWhereAgnCode = " AND ( TCNMChannelSpc.FTAgnCode = '" + tAgnCode + "' OR ISNULL(TCNMChannelSpc.FTAgnCode,'') = '' ) ";
        } else {
            tWhereAgnCode = " AND ( TCNMChannelSpc.FTAgnCode = '" + tUsrAgnCode + "' OR ISNULL(TCNMChannelSpc.FTAgnCode,'') = '' ) ";
        }

        if( tSesUsrLoginLevel != "AGN" ){
            tWhereAgnCode += " AND ( TCNMChannelSpc.FTBchCode IN (" + tBchCodeMulti + ") OR ISNULL(TCNMChannelSpc.FTBchCode,'') = '' ) ";
        }

        if( tSesUsrLoginLevel == "SHP" ){
            var tSesUsrShpCodeMulti = "<?=$this->session->userdata("tSesUsrShpCodeMulti")?>";
            tWhereAgnCode += " AND ( TCNMChannelSpc.FTShpCode IN (" + tSesUsrShpCodeMulti + ") OR ISNULL(TCNMChannelSpc.FTShpCode,'') = '' ) ";
        }

        

    } else {
        tWhereAgnCode = "";
        if (tAgnCode != "") {
            tWhereAgnCode = " AND ( TCNMChannelSpc.FTAgnCode = '" + tAgnCode + "' OR ISNULL(TCNMChannelSpc.FTAgnCode,'') = '' ) "
        } else {
            tWhereAgnCode = ""
        }
    }

    // Option Chanel
    var oAGNBrowseChanel = function(poDataFnc) {
        var tPOSBchCodeParam    = poDataFnc.tPOSBchCodeParam;
        var tWhereBchChn        = '';
        var oOptionReturn = {
            Title: ['pos/poschannel/poschannel', 'tCHNLabelTitle'],
            Table: {
                Master: 'TCNMChannel',
                PK: 'FTChnCode',
                PKName: 'FTChnName'
            },
            Join: {
                Table: ['TCNMChannelSpc', 'TCNMChannel_L'],
                On: ['TCNMChannelSpc.FTChnCode = TCNMChannel.FTChnCode', 'TCNMChannel_L.FTChnCode = TCNMChannel.FTChnCode  AND TCNMChannel_L.FNLngID = ' + nLangEdits, ]
            },
            Where: {
                Condition: [tWhereAgnCode]
            },
            GrideView: {
                ColumnPathLang: 'pos/poschannel/poschannel',
                ColumnKeyLang: ['tCHNLabelChannelCode', 'tCHNLabelChannelName'],
                ColumnsSize: ['15%', '75%'],
                WidthModal: 50,
                DataColumns: ['TCNMChannel.FTChnCode', 'TCNMChannel_L.FTChnName'],
                DataColumnsFormat: ['', ''],
                Perpage: 10,
                OrderBy: ['TCNMChannel.FTChnCode DESC'],
            },
            CallBack: {
                ReturnType: 'S',
                Value: ["oetAgnChanelCode", "TCNMChannel.FTChnCode"],
                Text: ["oetAgnChanelName", "TCNMChannel_L.FTChnName"],
            },
        }
        return oOptionReturn;
    }


</script>