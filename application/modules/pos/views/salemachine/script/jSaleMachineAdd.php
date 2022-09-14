<script type="text/javascript">
    $(document).ready(function(){

        JSxPOSGetPosContentShwRowCol();

        if( bIsAddPage ){
            let tWahBchCode = $('#oetWahBchCodeCreated').val();
            if( tWahBchCode !== undefined ){
                let tWahBchName = $('#oetWahBchNameCreated').val();
                $('#oetPosBchCode').val(tWahBchCode);
                $('#oetPosBchName').val(tWahBchName);
                $('#oimPosBrowseBch').attr('disabled',true);

                let WahStaType = $('#ocmWahStaType').val();
                switch(WahStaType){
                    case '2':
                        $('#ocmPosType').val(1);
                        break;
                    case '6':
                        $('#ocmPosType').val(4);
                        break;
                    default:
                        $('#ocmPosType').val(1);
                        break;
                }
                $('#ocmPosType').attr('disabled',true);
            }
        }

        // Event Tab
        $('#odvPosPanelBody .xCNPOSTab').unbind().click(function(){
            let tPosRoute       = '<?php echo @$tRoute;?>';
            if(tPosRoute == 'salemachineEventAdd'){
                return;
            }else{
                let tTypeTab    = $(this).data('typetab');
                if(typeof(tTypeTab) !== undefined && tTypeTab == 'main'){
                    JCNxOpenLoading();
                    setTimeout(function(){
                        $('#odvPosMainMenu #odvBtnAddEdit').show();
                        JCNxCloseLoading();
                        return;
                    },500);
                }else if(typeof(tTypeTab) !== undefined && tTypeTab == 'sub'){
                    $('#odvPosMainMenu #odvBtnAddEdit').hide();
                    let tTabTitle   = $(this).data('tabtitle');
                    switch(tTabTitle){
                        case 'posinfomachine':
                            JCNxOpenLoading();
                            setTimeout(function(){
                                JCNxCloseLoading();
                                return;
                            },500);
                        break;
                        case 'posads':
                            JSxPosAdsGetContent();
                        break;
                        case 'posspccat':
                            JSxPosSpcCatGetContent();
                        break;
                        case 'posaddress':
                            JSxGetPosContentAddress();
                        break;
                    }
                }   
            }
        });

    if(JSbSaleMachineIsCreatePage()){
        $("#oetPosCode").attr("disabled", true);
        $('#ocbPosAutoGenCode').change(function(){
            if($('#ocbPosAutoGenCode').is(':checked')) {
                $('#oetPosCode').val('');
                $("#oetPosCode").attr("disabled", true);
                $('#odvPosCodeForm').removeClass('has-error');
                $('#odvPosCodeForm em').remove();
            }else{
                $("#oetPosCode").attr("disabled", false);
            }
        });
        JSxSaleMachineVisibleComponent('#ocbPosAutoGenCode', true);
    }
    
    if(JSbSaleMachineIsUpdatePage()){
        $("#oetPosCode").attr("readonly", true);
        $('#odvPosAutoGenCode input').attr('disabled', true);
        JSxSaleMachineVisibleComponent('#odvPosAutoGenCode', false);    

        }
    });
    
    $('#oetPosCode').blur(function(){
        // JSxPosValidateDocCodeDublicate();
    });

    // Functionality: Function Check Is Create Page
    // Parameters: Event Documet Redy
    // Creator: 23/09/2019 saharat(Golf)
    // Return: object Status Delete
    // ReturnType: boolean
    function JSxPosValidateDocCodeDublicate(){
    if(!$('#ocbPosAutoGenCode').is(':checked')){
        $.ajax({
            type: "POST",
            url: "CheckInputGenCode",
            data: { 
                tTableName: "TCNMPos",
                tFieldName: "FTPosCode",
                tCode: $('#oetPosCode').val()
            },
            cache: false,
            timeout: 0,
            success: function(tResult){
            var aResultData = JSON.parse(tResult);
            $("#ohdCheckPosValidate").val(aResultData["rtCode"]);
            $('#ofmAddSaleMachine').validate().destroy();
            $.validator.addMethod('dublicateCode', function(value,element){
                if($("#ohdTMacFormRoute").val() == "salemachineEventAdd"){
                    if($('#ocbPosAutoGenCode').is(':checked')) {
                        return true;
                    }else{
                        if($("#ohdCheckPosValidate").val() == 1) {
                            return false;
                        }else{
                            return true;
                        }
                    }
                }else{
                    return true;
                }
            });

            // Set Form Validate From Add 
            $('#ofmAddSaleMachine').validate({
                focusInvalid: false,
                onclick: false,
                onfocusout: false,
                onkeyup: false,
                rules: {
                    oetPosCode : {"dublicateCode": {}},
                    oetPosBchName : {"dublicateCode": {}},
                },
                messages: {
                    oetPosCode : {"dublicateCode"  : $('#oetPosCode').attr('data-validate-dublicatecode')}
                },
                messages: {
                    oetPosBchName : {"dublicateCode"  : $('#oetPosBchName').attr('data-validate-dublicatecode')}
                },
                errorElement: "em",
                errorPlacement: function (error, element) {
                    error.addClass("help-block");
                    if(element.prop("type") === "checkbox") {
                        error.appendTo(element.parent("label"));
                    }else{
                        var tCheck = $(element.closest('.form-group')).find('.help-block').length;
                        if (tCheck == 0) {
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
                submitHandler: function (form) {}
            });
            $('#obtSubmitSaleMachine').submit();
        },
        error: function (jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
            },
        });
        }
    }


    // Create By : Witsarut
    // Create Date : 10/08/2019
    // Functional : Get Content for PosAds
    // Return : -
    // Return Type : -
    // Parameter : Route Name
    function JSxPosAdsGetContent(){
        var tBchCode    = $('#ohdBchCode').val();
        var tShpCode    = $('#ohdShpCode').val();
        var tPosCode    = '<?php echo @$tPosCode?>';
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            $.ajax({
                type: "POST",
                url: "posAds/0/0",
                data: {
                    tPosCode  : tPosCode,
                    tBchCode  : tBchCode,
                    tShpCode  : tShpCode
                },
                cache	: false,
                timeout	: 0,
                success	: function(tResult){
                    $('#odvPosPanelBody #odvInforPosAds').html(tResult);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }else{
            JCNxShowMsgSessionExpired();
        }
    }

    // Create By : Napat(Jame) 05/05/2022
    function JSxPosSpcCatGetContent(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            $('#odvPosPanelBody #odvInfoPosSpcCat').html('');
            JCNxOpenLoading();
            $.ajax({
                type: "POST",
                url: "masPOSSpcCatPageList",
                cache	: false,
                timeout	: 0,
                success	: function(tResult){
                    $('#odvPosPanelBody #odvInfoPosSpcCat').html(tResult);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }else{
            JCNxShowMsgSessionExpired();
        }
    }
    
    // Function: Event Call Salemachine Address
    // Parameters : Event Click Tab
    // Creator : 16/09/2019 wasin(Yoshi)
    // Return : -
    // Return Type : -
    function JSxGetPosContentAddress(){
        let tPosCode    = '<?php echo @$tPosCode;?>';
        let nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JCNxOpenLoading();
            $.ajax({
                type    : "POST",
                url     : "salemachineAddressData",
                data    : {'ptPosCode':tPosCode},
                success	: function(tResult){
                    $('#odvPosPanelBody #odvPOSAddressData').html(tResult);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }else{
            JCNxShowMsgSessionExpired();
        }
    }

    //check type ว่าใช่ type 4 หรือไม่ ถ้าใช่ให้เปิด WarehouseForm ถ้าไม่ใช่ ปิด WarehouseForm

    $("#ocmPosType").change(function(){
        var tPosType = $('#ocmPosType').val();
        if(tPosType == 4 || tPosType == 1){
            $('#odvWarehouseForm').removeAttr("style");
        }else{
            $("#odvWarehouseForm").attr("style", "display:none;");
        }

        // แสดงเฉพาะ จุดขาย + ตู้ขายสินค้า
        if( tPosType != '1' && tPosType != '4' ){
            $('#odvPOSShwRowShwCol').hide();
        }else{
            $('#odvPOSShwRowShwCol').show();
            JSxPOSGetPosContentShwRowCol();
        }

    });

    // Create By : Napat(Jame) 01/03/2021
    function JSxPOSGetPosContentShwRowCol(){
        var tPosType = $('#ocmPosType').val();
        if( tPosType == '1' || tPosType == '4' ){

            var nPosShwRow  = $('#ohdPosShwRow').val();
            var nPosShwCol  = $('#ohdPosShwCol').val();

            // console.log(nPosShwRow);
            // console.log(nPosShwCol);

            // console.log(typeof(nPosShwRow));
            // console.log(typeof(nPosShwCol));

            switch (tPosType) {
                case '1':
                    nStartRow = 1;
                    nEndRow   = 10;
                    nStartCol = 1;
                    nEndCol   = 10;
                    break;
                case '4':
                    nStartRow = 2;
                    nEndRow   = 5;
                    nStartCol = 2;
                    nEndCol   = 5;
                    break;
            }

            $('#ocmPosShwRow').find('option').remove();
            $('#ocmPosShwCol').find('option').remove();

            setTimeout(function(){ 
                $('.selectpicker').selectpicker("refresh");
            }, 100);

            for (i = nStartRow; i <= nEndRow; i++){
                $('#ocmPosShwRow').append( $('<option>',{ value: i, text: i, class: 'xCNShwRow'+i }) );
            }

            for (i = nStartCol; i <= nEndCol; i++){
                $('#ocmPosShwCol').append( $('<option>',{ value: i, text: i, class: 'xCNShwCol'+i }) );
            }

            if( nPosShwRow != '0' && nPosShwCol != '0' ){
                // alert('if');
                $(".xCNShwRow"+nPosShwRow).attr('selected',true);
                $(".xCNShwCol"+nPosShwCol).attr('selected',true);
            }else{
                // alert('else');
                $("#ocmPosShwRow option:first").attr('selected',true);
                $("#ocmPosShwCol option:first").attr('selected',true);
            }

            setTimeout(function(){ 
                $('.selectpicker').selectpicker("refresh");
            }, 100);
            

        }
    }

    $('#oimPosBrowseChanel').click(function() {
        JSxCheckPinMenuClose();
        var tPOSBchCodeParam = $('#oetPosBchCode').val();
        window.oBrowsePosOption = undefined;
        oBrowsePosOption = oSaleMachineBrowseChanel({
            'tPOSBchCodeParam': tPOSBchCodeParam
        });
        JCNxBrowseData('oBrowsePosOption');
    });

    // Option Chanel
    var oSaleMachineBrowseChanel = function(poDataFnc) {
        var tPOSBchCodeParam = poDataFnc.tPOSBchCodeParam;
        var tWhereBchChn    = '';
        var tBchCode        = $('#oetPosBchCode').val();
        var tSesUsrLoginLevel = '<?=$this->session->userdata("tSesUsrLoginLevel")?>';

        if( tSesUsrLoginLevel != "HQ" ){
            var tSesUsrAgnCode = '<?=$this->session->userdata("tSesUsrAgnCode")?>';
            tWhereBchChn += " AND ( TCNMChannelSpc.FTAgnCode = '"+tSesUsrAgnCode+"' OR ISNULL(TCNMChannelSpc.FTAgnCode,'') = '' ) ";

            if( tSesUsrLoginLevel != "AGN" ){
                var tSesUsrBchCodeMulti = "<?=$this->session->userdata("tSesUsrBchCodeMulti")?>";
                tWhereBchChn += " AND ( TCNMChannelSpc.FTBchCode IN ("+tSesUsrBchCodeMulti+") OR ISNULL(TCNMChannelSpc.FTBchCode,'') = '' ) ";
            }

            if( tSesUsrLoginLevel == "SHP" ){
                var tSesUsrShpCodeMulti = "<?=$this->session->userdata("tSesUsrShpCodeMulti")?>";
                tWhereBchChn += " AND ( TCNMChannelSpc.FTShpCode IN ("+tSesUsrShpCodeMulti+") OR ISNULL(TCNMChannelSpc.FTShpCode,'') = '' ) ";
            }
        }

        var oOptionReturn = {
            Title: ['pos/poschannel/poschannel', 'tCHNLabelTitle'],
            Table: {
                Master: 'TCNMChannel',
                PK: 'FTChnCode',
                PKName: 'FTChnName'
            },
            Join: {
                Table: ['TCNMChannelSpc','TCNMChannel_L'],
                On: [
                    'TCNMChannelSpc.FTChnCode = TCNMChannel.FTChnCode',
                    'TCNMChannel_L.FTChnCode = TCNMChannel.FTChnCode AND TCNMChannel_L.FNLngID = ' + nLangEdits
                ]
            },
            Where: {
                Condition: [tWhereBchChn]
            },
            GrideView: {
                ColumnPathLang: 'pos/poschannel/poschannel',
                ColumnKeyLang: ['tCHNLabelChannelCode', 'tCHNLabelChannelName'],
                ColumnsSize: ['15%', '75%'],
                WidthModal: 50,
                DataColumns: ['TCNMChannel.FTChnCode', 'TCNMChannel_L.FTChnName'],
                DataColumnsFormat: ['', ''],
                Perpage: 10,
                OrderBy: ['TCNMChannel.FDCreateOn DESC'],

            },
            // DebugSQL : true,
            CallBack: {
                ReturnType: 'S',
                Value: ["oetPosChanelCode", "TCNMChannel.FTChnCode"],
                Text: ["oetPosChanelName", "TCNMChannel_L.FTChnName"],
            },

        }
        return oOptionReturn
    }


</script>