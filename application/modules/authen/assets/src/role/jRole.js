var nStaRoleBrowseType  = $('#oetRoleStaBrowse').val();
var tCallRoleBackOption = $('#oetRoleCallBackOption').val();

$('ducument').ready(function(){
    localStorage.removeItem('LocalItemData');
    JSxCheckPinMenuClose();
    if(typeof(nStaRoleBrowseType) != 'undefined' && nStaRoleBrowseType == 0){
        // Event Click Navigater Title (คลิก Title)
        $('#oliRoleTitle').unbind().click(function(){
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== "undefined" && nStaSession == 1) {
                JSvCallPageRoleList();
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        // Event Click Button Add Page
        $('#obtRoleCallPageAdd').unbind().click(function(){
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== "undefined" && nStaSession == 1) {
                JSvCallPageRoleAdd();
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        // Event Click Call Back Page
        $('#obtRoleCallBackPage').unbind().click(function(){
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== "undefined" && nStaSession == 1) {
                JSvCallPageRoleList();
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        // Event Click Submit From Add/Edit Role
        $('#obtRoleSubmitFrom').unbind().click(function(){
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== "undefined" && nStaSession == 1) {
                $('#obtRoleAddEditEvent').unbind().click();
            }else{
                JCNxShowMsgSessionExpired();
            }
        });
    
        JSxRoleNavDefult();
        JSvCallPageRoleList();
    }else{
        // Event Modal Call Back Before List
        $('#oahRoleBrowseCallBack').unbind().click(function (){
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== "undefined" && nStaSession == 1) {
                JCNxBrowseData(tCallRoleBackOption);
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        // Event Modal Call Back Previous
        $('#oliRoleBrowsePrevious').unbind().click(function (){
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== "undefined" && nStaSession == 1) {
                JCNxBrowseData(tCallRoleBackOption);
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        // Event Submit In Modal
        $('#obtRoleBrowseSubmit').unbind().click(function () {
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== "undefined" && nStaSession == 1) {
                $('#obtRoleAddEditEvent').unbind().click();
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        JSxRoleNavDefult();
        JSvCallPageRoleAdd();
    }
});

// Function : Function Clear Defult Button Role
// Parameters : Document Ready Call Function
// Creator : 22/06/2018 wasin(Yoshi)
// LastUpdate : 13/08/2019 Wasin(Yoshi)
// Return : 
// Return Type : -
function JSxRoleNavDefult(){
    if(typeof(nStaRoleBrowseType) != 'undefined' && nStaRoleBrowseType == 0){
        $('.obtChoose').hide();
        $('#oliRoleTitleAdd').hide();
        $('#oliRoleTitleEdit').hide();
        $('#odvRoleBtnGrpAddEdit').hide();
        $('#odvRoleBtnGrpInfo').show();
    }else{
        $('#odvModalBody #odvRoleMainMenu').removeClass('main-menu');
        $('#odvModalBody #oliRoleNavBrowse').css('padding', '2px');
        $('#odvModalBody #odvRoleBtnGroup').css('padding', '0');
        $('#odvModalBody .xCNRoleBrowseLine').css('padding', '0px 0px');
        $('#odvModalBody .xCNRoleBrowseLine').css('border-bottom', '1px solid #e3e3e3');
    }
}

// Function : Call Role Page list  
// Parameters : Doccument Ready and Event Button Parameter
// Creator :	22/06/2018 wasin
// Last Update : 15/01/2019 Wasin(Yoshi)
// Return : View
// Return Type : View
function JSvCallPageRoleList() {
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
        JCNxOpenLoading();
        $('#oetSearchAll').val('');
        $.ajax({
            type: "POST",
            url: "roleList",
            cache: false,
            timeout: 0,
            success: function(tResult) {
                if (tResult != "") {
                    $('#odvRoleContentPage').html(tResult);
                    JSvCallPageRoleDataTable();
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }else{
        JCNxShowMsgSessionExpired();
    }
}

// Function : Call Role Data Table List
// Parameters : Ajax Success Event 
// Creator:	22/06/2018 wasin
// Last Update : 13/08/2019 Wasin(Yoshi)
// Return : View
// Return Type : View
function JSvCallPageRoleDataTable(pnPage){
    var tSearchAll      = $('#oetSearchAll').val();
    var nPageCurrent    = pnPage;
    if (nPageCurrent == undefined || nPageCurrent == '') { 
        nPageCurrent = '1';
    }
    JCNxOpenLoading();
    $.ajax({
        type: "POST",
        url: "roleDataTable",
        data: {
            'ptSearchAll'   : tSearchAll,
            'pnPageCurrent' : nPageCurrent
        },
        cache: false,
        success: function(tResult) {
            var aDataReturn     = JSON.parse(tResult);
            var tMessageError   = aDataReturn['tStaMessg'];
            if(aDataReturn['nStaEvent'] === 1){
                JSxRoleNavDefult();
                $('#ostPanelDataRole').html(aDataReturn['tRoleViewDataTableList']);
            }else{
                FSvCMNSetMsgErrorDialog(tMessageError);
            }
            JCNxLayoutControll();
            JCNxCloseLoading();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

// Functionality : Call Role Page Add  
// Parameters : Event Button Click Call Page And Document Ready
// Creator : 22/06/2018 wasin
// Last Update : 15/08/2019 Wasin(Yoshi)
// Return : View Page Add
// Return Type : View
function JSvCallPageRoleAdd(){
    JCNxOpenLoading();
    JStCMMGetPanalLangSystemHTML('','');
    $.ajax({
        type: "POST",
        url: "rolePageAdd",
        cache: false,
        success: function(tResult){
            var aReturnData = JSON.parse(tResult);
            if(aReturnData['nStaEvent'] == '1'){
                if (nStaRoleBrowseType == '1'){
                    $('#odvModalBodyBrowse .panel-body').css('padding-top', '0');
                    $('#odvModalBodyBrowse').html(aReturnData['tRoleViewPageAdd']);
                }else{
                    $('#oliRoleTitleEdit').hide();
                    $('#odvRoleBtnGrpInfo').hide();
                    $('#oliRoleTitleAdd').show();
                    $('#odvRoleBtnGrpAddEdit').show();
                    $('#odvRoleContentPage').html(aReturnData['tRoleViewPageAdd']);
                }
            }else{
                var tMessageError = aReturnData['tStaMessg'];
                FSvCMNSetMsgErrorDialog(tMessageError);
            }
            JCNxCloseLoading();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

// Functionality : Call Role Page Edit  
// Parameters : -
// Creator : 26/06/2018 wasin
// Last Update : 15/01/2019 Wasin(Yoshi)
// Return : View
// Return Type : View
function JSvCallPageRoleEdit(ptRolCode) {
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
        JCNxOpenLoading();
        JStCMMGetPanalLangSystemHTML('JSvCallPageRoleEdit', ptRolCode);
        $.ajax({
            type: "POST",
            url: "rolePageEdit",
            data: { tRolCode: ptRolCode },
            cache: false,
            timeout: 0,
            success: function(tResult) {
                var aReturnData = JSON.parse(tResult);
                if(aReturnData['nStaEvent'] == '1'){
                    $('#odvRoleBtnGrpInfo').hide();
                    $('#oliRoleTitleAdd').hide();
                    $('#oliRoleTitleEdit').show();
                    $('#odvRoleBtnGrpAddEdit').show();
                    $('#odvRoleContentPage').html(aReturnData['tRoleViewPageEdit']);
                    JSxControlCheckBoxListTable(aReturnData);
                }else{
                    var tMessageError = aReturnData['tStaMessg'];
                    FSvCMNSetMsgErrorDialog(tMessageError);
                }
                JCNxLayoutControll();
                JCNxCloseLoading();
            },
            error: function(jqXHR,textStatus,errorThrown) {
                JCNxResponseError(jqXHR,textStatus,errorThrown);
            }
        });
    }else{
        JCNxShowMsgSessionExpired();
    }
}

// Functionality : Event Controll Check Box
// Parameters : form
// Creator : 29/08/19 Wasin(Yoshi)
// Last Update : -
// Return : Event Control Check Box
// Return Type : None
function JSxControlCheckBoxListTable(paReturnData){

    // Loop Check Menu List
    let aDataRoleMenuEdit   = paReturnData['aDataRoleMenuEdit'];
    if(aDataRoleMenuEdit['rtCode'] == '1'){
        var tGmnModCodeKeep = '';
        var aItem           = [];
        $.each(aDataRoleMenuEdit['raItems'],function(nKey,aValueMenu){
            var tGmnModCode   = aValueMenu['FTGmnModCode'];
            var tGmnCode      = aValueMenu['FTGmnCode'];
            var tMnuCode      = aValueMenu['FTMnuCode'];

            if(nKey == 0){
                tGmnModCodeKeep = '';
            }

            // Check Status Read
            if(aValueMenu['FTUsrUseStaStaRead'] == 1 && aValueMenu['FTAutStaRead'] == 1){
                $('#otbModuleMenuRole tbody .xCNDataRole[data-gmc='+tGmnModCode+'][data-gmn='+tGmnCode+'][data-mnc='+tMnuCode+'] .xCNIsUseChkBox .xWDataRoleRead').prop("checked",true);
            }else{
                $('#otbModuleMenuRole tbody .xCNDataRole[data-gmc='+tGmnModCode+'][data-gmn='+tGmnCode+'][data-mnc='+tMnuCode+'] .xCNIsUseChkBox .xWDataRoleRead').prop("checked",false);
            }

            // Check Status Add
            if(aValueMenu['FTUsrUseStaStaAdd'] == 1 && aValueMenu['FTAutStaAdd'] == 1){
                $('#otbModuleMenuRole tbody .xCNDataRole[data-gmc='+tGmnModCode+'][data-gmn='+tGmnCode+'][data-mnc='+tMnuCode+'] .xCNIsUseChkBox .xWDataRoleAdd').prop("checked",true);
            }else{
                $('#otbModuleMenuRole tbody .xCNDataRole[data-gmc='+tGmnModCode+'][data-gmn='+tGmnCode+'][data-mnc='+tMnuCode+'] .xCNIsUseChkBox .xWDataRoleAdd').prop("checked",false);
            }

            // Check Status Delete
            if(aValueMenu['FTUsrUseStaStaDelete'] == 1 && aValueMenu['FTAutStaDelete'] == 1){
                $('#otbModuleMenuRole tbody .xCNDataRole[data-gmc='+tGmnModCode+'][data-gmn='+tGmnCode+'][data-mnc='+tMnuCode+'] .xCNIsUseChkBox .xWDataRoleDel').prop("checked",true);
            }else{
                $('#otbModuleMenuRole tbody .xCNDataRole[data-gmc='+tGmnModCode+'][data-gmn='+tGmnCode+'][data-mnc='+tMnuCode+'] .xCNIsUseChkBox .xWDataRoleDel').prop("checked",false);
            }

            // Check Status Edit
            if(aValueMenu['FTUsrUseStaStaEdit'] == 1 && aValueMenu['FTAutStaEdit'] == 1){
                $('#otbModuleMenuRole tbody .xCNDataRole[data-gmc='+tGmnModCode+'][data-gmn='+tGmnCode+'][data-mnc='+tMnuCode+'] .xCNIsUseChkBox .xWDataRoleEdit').prop("checked",true);
            }else{
                $('#otbModuleMenuRole tbody .xCNDataRole[data-gmc='+tGmnModCode+'][data-gmn='+tGmnCode+'][data-mnc='+tMnuCode+'] .xCNIsUseChkBox .xWDataRoleEdit').prop("checked",false);
            }

            // Check Status Appove
            if(aValueMenu['FTUsrUseStaStaAppv'] == 1 && aValueMenu['FTAutStaAppv'] == 1){
                $('#otbModuleMenuRole tbody .xCNDataRole[data-gmc='+tGmnModCode+'][data-gmn='+tGmnCode+'][data-mnc='+tMnuCode+'] .xCNIsUseChkBox .xWDataRoleAppv').prop("checked",true);
            }else{
                $('#otbModuleMenuRole tbody .xCNDataRole[data-gmc='+tGmnModCode+'][data-gmn='+tGmnCode+'][data-mnc='+tMnuCode+'] .xCNIsUseChkBox .xWDataRoleAppv').prop("checked",false);
            }

            // Check Status Cancel
            if(aValueMenu['FTUsrUseStaStaCancel'] == 1 && aValueMenu['FTAutStaCancel'] == 1){
                $('#otbModuleMenuRole tbody .xCNDataRole[data-gmc='+tGmnModCode+'][data-gmn='+tGmnCode+'][data-mnc='+tMnuCode+'] .xCNIsUseChkBox .xWDataRoleCancel').prop("checked",true);
            }else{
                $('#otbModuleMenuRole tbody .xCNDataRole[data-gmc='+tGmnModCode+'][data-gmn='+tGmnCode+'][data-mnc='+tMnuCode+'] .xCNIsUseChkBox .xWDataRoleCancel').prop("checked",false);
            }

            // Check Status Cancel
            if(aValueMenu['FTUsrUseStaPrintMore'] == 1 && aValueMenu['FTAutStaPrintMore'] == 1){
                $('#otbModuleMenuRole tbody .xCNDataRole[data-gmc='+tGmnModCode+'][data-gmn='+tGmnCode+'][data-mnc='+tMnuCode+'] .xCNIsUseChkBox .xWDataRolePrintMore').prop("checked",true);
            }else{
                $('#otbModuleMenuRole tbody .xCNDataRole[data-gmc='+tGmnModCode+'][data-gmn='+tGmnCode+'][data-mnc='+tMnuCode+'] .xCNIsUseChkBox .xWDataRolePrintMore').prop("checked",false);
            }

            //เก็บค่าไว้ สำหรับทำ checkbox all กรณีเเก้ไข
            if(tGmnModCodeKeep != tGmnModCode){
                aItemSort = { 
                    'nRound'            : nKey,
                    'tCode'             : tGmnModCode , 
                    'nInputCheckAll'    : $('#otbModuleMenuRole tbody .xCNDataRole[data-gmc='+tGmnModCode+']').find('.xCNIsUseChkBox').length }
                aItem.push(aItemSort);
            }
            tGmnModCodeKeep = aValueMenu['FTGmnModCode'];
        }); 


        for(var j=0; j<aItem.length; j++){
            var nValueCheck =  $('#otbModuleMenuRole tbody .xCNDataRole[data-gmc='+aItem[j].tCode+'] input:checked').length;  
            if(nValueCheck == aItem[j].nInputCheckAll){
                $('.xWHeardRoleAll[data-gmc='+aItem[j].tCode+']').find('.xWCheckAll').find('.xWOcbCheckAll').prop('checked',true);
            }
        }
    }
    
    // Loop Check Menu Report List
    let aDataRoleMenuRptEdit    = paReturnData['aDataRoleMenuRptEdit'];
    if(aDataRoleMenuRptEdit['rtCode'] == '1'){
        var tRptModCodeKeep = '';
        var aItem           = [];
        $.each(aDataRoleMenuRptEdit['raItems'],function(nKey,aValueRptMenu){
            let tRptGrpModCode  = aValueRptMenu['FTGrpRptModCode'];
            let tRptGrpCode     = aValueRptMenu['FTGrpRptCode'];
            let tRptCode        = aValueRptMenu['FTRptCode'];

            if(nKey == 0){
                tRptModCodeKeep = '';
            }

            // Check Status Allow Report
            if(aValueRptMenu['FTUfrStaAlw'] == 1){
                $('#otbModuleMenuRole tbody .xCNDataReport[data-rmc='+tRptGrpModCode+'][data-grc='+tRptGrpCode+'][data-rtc='+tRptCode+'] .xWDataReportAllow').prop("checked",true);
            }else{
                $('#otbModuleMenuRole tbody .xCNDataReport[data-rmc='+tRptGrpModCode+'][data-grc='+tRptGrpCode+'][data-rtc='+tRptCode+'] .xWDataReportAllow').prop("checked",false);
            }

            //เก็บค่าไว้ สำหรับทำ checkbox all กรณีเเก้ไข
            if(tRptModCodeKeep != tRptGrpModCode){
                aItemSort = { 
                    'nRound'            : nKey,
                    'tCode'             : tRptGrpModCode , 
                    'nInputCheckAll'    : $('#otbModuleMenuRole tbody .xCNDataReport[data-rmc='+tRptGrpModCode+']').find('.xWDataReportAllow').length }
                aItem.push(aItemSort);
            }
            tRptModCodeKeep = aValueRptMenu['FTGrpRptModCode'];
        });

        console.log(aItem);
        for(var k=0; k<aItem.length; k++){
            var nValueCheck =  $('#otbModuleMenuRole tbody .xCNDataReport[data-rmc='+aItem[k].tCode+'] input:checked').length;  
            if(nValueCheck == aItem[k].nInputCheckAll){
                $('.xWHeardReportAll[data-rmc='+aItem[k].tCode+']').find('.xWCheckAll').find('.xWAllow').prop('checked',true);
            }
        }
    }

}

// Functionality : (event) Add/Edit Role
// Parameters : form
// Creator : 26/06/2018 wasin
// Last Update : 15/01/2019 Wasin(Yoshi)
// Return : Status Add
// Return Type : n
function JSxAddEditRole(ptRoute){
    $('#ofmAddEditRole').validate().destroy();
    $.validator.addMethod('dublicateCode',function(value,element){
        if(ptRoute == "roleEventAdd"){
            if($("ohdCheckDuplicateRoleCode").val() == 1){
                return false;
            }else{
                return true;
            }
        }else{
            return true;
        }
    },'');

    // console.log($('#ohdSesUsrLoginLevel').val());

    $('#ofmAddEditRole').validate({
        rules: {
            oetRolCode: {
                "required" : {
                    depends: function(oElement){
                        if(ptRoute == "roleEventAdd"){
                            if($('#ocbRoleAutoGenCode').is(':checked')){
                                return false;
                            }else{
                                return true;
                            }
                        }else{
                            return true;
                        }
                    }
                },
                "dublicateCode": {}
            },
            oetRolName:  {"required" :{}},
            oetSpcBranchName : {
                "required" : {
                    depends: function(oElement){
                        if(ptRoute == "roleEventAdd"){
                            if( $('#ohdSesUsrLoginLevel').val() != "HQ" && $('#ohdSesUsrLoginLevel').val() != "AGN" ){
                                return true;
                            }else{
                                return false;
                            }
                        }else{
                            return false;
                        }
                    }
                },
            }
        },
        messages: {
            oetRolCode : {
                "required"      : $('#oetRolCode').attr('data-validate-required'),
                "dublicateCode" : $('#oetRolCode').attr('data-validate-dublicateCode')
            },
            oetRolName : {
                "required"      : $('#oetRolName').attr('data-validate-required'),
                "dublicateCode" : $('#oetRolName').attr('data-validate-dublicateCode')
            },
            oetSpcBranchName : {
                "required"      : $('#oetSpcBranchName').attr('data-validate-required'),
            }
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
        highlight: function(element, errorClass, validClass) {
            $( element ).closest('.form-group').addClass( "has-error" ).removeClass( "has-success" );
        },
        unhighlight: function(element, errorClass, validClass) {
            $( element ).closest('.form-group').addClass( "has-success" ).removeClass( "has-error" );
        },
        submitHandler: function(form){
            if(!$('#ocbRoleAutoGenCode').is(':checked')){
                JSxRoleValidateDocCodeDublicate();
            }else{
                JSxRoleSubmitEventByButton();
            }
        }
    });
}

// Functionality : Function Check Code Role Duplicate In DB
// Parameters : Function AddEdit Role
// Creator : 28/08/2019 wasin(Yoshi)
// LastUpdate: -
// Return :  Check Data Role Code
// Return Type : None Return Value Use Event Control
function JSxRoleValidateDocCodeDublicate(){
    $.ajax({
        type: "POST",
        url: "CheckInputGenCode",
        data: {
            'tTableName'    : 'TCNMUsrRole',
            'tFieldName'    : 'FTRolCode',
            'tCode'         : $('#oetRolCode').val()
        },
        success: function (oResult){
            var aResultData = JSON.parse(oResult);
            $("#ohdCheckDuplicateRoleCode").val(aResultData["rtCode"]);
            $('#ofmAddEditRole').validate().destroy();

            $.validator.addMethod('dublicateCode', function(value,element){
                if($("#ohdRoleRouteData").val() == "roleEventAdd"){
                    if($('#ocbRoleAutoGenCode').is(':checked')) {
                        return true;
                    }else{
                        if($("#ohdCheckDuplicateRoleCode").val() == 1) {
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
            $('#ofmAddEditRole').validate({
                focusInvalid: false,
                onclick: false,
                onfocusout: false,
                onkeyup: false,
                rules: {
                    oetRolCode : {"dublicateCode": {}}
                },
                messages: {
                    oetRolCode : {"dublicateCode"  : $('#oetRolCode').attr('data-validate-dublicatecode')}
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
                submitHandler: function (form) {
                    JSxRoleSubmitEventByButton();
                }
            });
            $("#ofmAddEditRole").submit();            
        },
        error: function (jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

// Functionality : Function Check Code Role Duplicate In DB
// Parameters : Function AddEdit Role
// Creator : 28/08/2019 wasin(Yoshi)
// LastUpdate: -
// Return :  Check Data Role Code
// Return Type : None Return Value Use Event Control
function JSxRoleSubmitEventByButton(){
    JCNxOpenLoading();
    // **** วนลูปดึงข้อมูล Role ของ Menu
    var aRoleMnuData    = [];
    $('#otbModuleMenuRole .xCNDataRole').each(function(){
        let tGrpModCode         = $(this).data('gmc');
        let tGrpCode            = $(this).data('gmn');
        let tMenuCode           = $(this).data('mnc');
        let tMenuStaRead        = $(this).find('.xWDataRoleRead').is(':checked')?       1 : 0;
        let tMenuStaAdd         = $(this).find('.xWDataRoleAdd').is(':checked')?        1 : 0;
        let tMenuStaDel         = $(this).find('.xWDataRoleDel').is(':checked')?        1 : 0;
        let tMenuStaEdit        = $(this).find('.xWDataRoleEdit').is(':checked')?       1 : 0;
        let tMenuStaAppv        = $(this).find('.xWDataRoleAppv').is(':checked')?       1 : 0;
        let tMenuStaCancel      = $(this).find('.xWDataRoleCancel').is(':checked')?     1 : 0;
        let tMenuStaPrintMore   = $(this).find('.xWDataRolePrintMore') .is(':checked')? 1 : 0;
        if(tMenuStaRead  == 1 || tMenuStaAdd == 1 || tMenuStaDel == 1 || tMenuStaEdit == 1 || tMenuStaAppv == 1 || tMenuStaCancel == 1 || tMenuStaPrintMore == 1){
            aRoleMnuData.push({
                'tGrpModCode'       : tGrpModCode,
                'tGrpCode'          : tGrpCode,
                'tMenuCode'         : tMenuCode,
                'tMenuStaRead'      : tMenuStaRead,
                'tMenuStaAdd'       : tMenuStaAdd,
                'tMenuStaDel'       : tMenuStaDel,
                'tMenuStaEdit'      : tMenuStaEdit,
                'tMenuStaAppv'      : tMenuStaAppv,
                'tMenuStaCancel'    : tMenuStaCancel,
                'tMenuStaPrintMore' : tMenuStaPrintMore
            });
        }
    })

    // **** วนลูปดึงข้อมูล Role ของ Report
    var aRoleRptData    = [];
    $('#otbModuleMenuRole .xCNDataReport').each(function(){
        let tRptGrpModCode  = $(this).data('rmc');
        let tRptGrpCode     = $(this).data('grc');
        let tRptCode        = $(this).data('rtc');
        let tRptStaAlw      = $(this).find('.xWDataReportAllow').is(':checked')?  1 : 0;
        if(tRptStaAlw == 1){
            aRoleRptData.push({
                'tRptGrpModCode'    : tRptGrpModCode,
                'tRptGrpCode'       : tRptGrpCode,
                'tRptCode'          : tRptCode,
                'tRptStaAlw'        : tRptStaAlw
            });
        }
    });
    // **** Send Ajax Add/Edit Role
    var tRoleCode           = $('#oetRolCode').val();
    var tRoleName           = $('#oetRolName').val();
    var tRoleLevel          = $('#ocmRolLevel').val();
    var tRoleRemark         = $('#otaRolRemark').val();
    var tRoleAutoGenCode    = $('#ocbRoleAutoGenCode').is(':checked')? 1 : 0;

    var tSpcAgnCode         =  $('#oetSpcAgncyCode').val();
    var tSpcBchCode         =  $('#oetSpcBranchCode').val();
    var tSpcAgncyCodeOld    =  $('#oetSpcAgncyCodeOld').val();
    var tSpcBranchCodeOld  =  $('#oetSpcBranchCodeOld').val();

    var tImageOld    = $('#oetImgInputRoleOld').val();
    var tImageNew    = $('#oetImgInputRole').val();
    console.log(JSaGetRoleNotiSettingSelect());
    $.ajax({
        type: "POST",
        url: $('#ohdRoleRouteData').val(),
        data: {
            'ptRoleAutoGenCode' : tRoleAutoGenCode,
            'ptRoleCode'        : tRoleCode,
            'ptRoleName'        : tRoleName,
            'ptRoleLevel'       : tRoleLevel,
            'ptRoleRemark'      : tRoleRemark,
            'paRoleMnuData'     : aRoleMnuData,
            'paRoleRptData'     : aRoleRptData,
            'paRoleFuncSetting' : JSaGetRoleFuncSettingSelect(),
            'paRoleFuncSettingNotChecked' : JSaGetRoleFuncSettingNotSelect(),
            'paRoleNotiSetting' : JSaGetRoleNotiSettingSelect(),
            'ptImageOld'        : tImageOld,
            'ptImageNew'        : tImageNew,
            'ptSpcAgnCode'      : tSpcAgnCode,
            'ptSpcBchCode'      : tSpcBchCode,
            'ptSpcAgncyCodeOld' : tSpcAgncyCodeOld,
            'ptSpcBranchCodeOld': tSpcBranchCodeOld
        },
        success: function (tResult){
            if(nStaRoleBrowseType != 1) {
                let aDataReturn = JSON.parse(tResult);
                if(aDataReturn['nStaEvent'] == '1'){
                    var nRoleStaCallBack    = aDataReturn['nStaCallBack'];
                    var tRoleCodeReturn     = aDataReturn['tCodeReturn'];
                    switch(nRoleStaCallBack){
                        case 1 :
                            JSvCallPageRoleEdit(tRoleCodeReturn);
                        break;
                        case 2 :
                            JSvCallPageRoleAdd();
                        break;
                        case 3 :
                            JSvCallPageRoleList();
                        break;
                        default :
                            JSvCallPageRoleEdit(tRoleCodeReturn);
                    }
                    JCNxImgWarningMessage(aDataReturn['aImgReturn']);
                }else{
                    var tMsgErrorFunction   = aDataReturn['tStaMessg'];
                    FSvCMNSetMsgErrorDialog('<p class="text-left">'+tMsgErrorFunction+'</p>');
                }
                JCNxCloseLoading();
            }else{
                JCNxCloseLoading();
                JCNxBrowseData(tCallRoleBackOption);
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

// Functionality : (event) Delete
// Parameters : tIDCod รหัส RoleCode
// Creator : 26/06/2018 wasin
// Last Update : 15/01/2019 Wasin(Yoshi)
// Return : 
// Return Type :
function JSnRoleDel(tCurrentPage,ptName,tIDCode,tYesOnNo) {
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
        var aData = $('#ohdConfirmIDDelete').val();
        var aTexts = aData.substring(0, aData.length - 2);
        var aDataSplit = aTexts.split(" , ");
        var aDataSplitlength = aDataSplit.length;
        var aNewIdDelete = [];
        if (aDataSplitlength == '1') {
            $('#odvModalDelRole').modal('show');
            $('#odvModalDelRole #ospConfirmDelete').html($('#oetTextComfirmDeleteSingle').val() +  tIDCode + ' ( ' + ptName + ' ) '+ tYesOnNo );
            $('#odvModalDelRole #osmConfirm').unbind().click(function(){
                JCNxOpenLoading();
                $.ajax({
                    type: "POST",
                    url: "roleEventDelete",
                    data: { 'ptDeleteIDCode': tIDCode },
                    cache: false,
                    timeout: 0,
                    success: function(tResult) {
                        var aReturnData     = JSON.parse(tResult);
                        var tTextMassage    = aReturnData['tStaMessg'];
                        if(aReturnData['nStaEvent'] == 1) {
                            $('#odvModalDelRole').modal('hide');
                            $('#odvModalDelRole #ospConfirmDelete').html($('#oetTextComfirmDeleteSingle').val());
                            $('.modal-backdrop').remove();
                            setTimeout(function(){
                                var nNumRowRolLoc   = aReturnData['nNumRowRolLoc'];
                                if(nNumRowRolLoc != 0){
                                    if(nNumRowRolLoc > 10){
                                        var nNumPage    = Math.ceil(nNumRowRolLoc/10);
                                        if(tCurrentPage <= nNumPage){
                                            JSvCallPageRoleList(tCurrentPage);
                                        }else{
                                            JSvCallPageRoleList(nNumPage);
                                        }
                                    }else{
                                        JSvCallPageRoleList(1);
                                    }
                                }else{
                                    JSvCallPageRoleList(1);
                                }
                            },500);
                        }else{
                            FSvCMNSetMsgErrorDialog(tTextMassage);
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            });
        }
    }else{
        JCNxShowMsgSessionExpired();
    }
}

// Functionality : (event) Delete All
// Parameters :
// Creator : 26/06/2018 wasin
// Last Update : 15/01/2019 Wasin(Yoshi)
// Return :
// Return Type :
function JSaRoleDelChoose(pnPage) {
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
        var aData = $('#ohdConfirmIDDelete').val();
        var aTexts = aData.substring(0, aData.length - 2);
        var aDataSplit = aTexts.split(" , ");
        var aDataSplitlength = aDataSplit.length;
        var aNewIdDelete = [];
        for ($i = 0; $i < aDataSplitlength; $i++) {
            aNewIdDelete.push(aDataSplit[$i]);
        }
        if (aDataSplitlength > 1) {
            localStorage.StaDeleteArray = '1';
            $.ajax({
                type: "POST",
                url: "roleEventDelete",
                data: { 'ptDeleteIDCode': aNewIdDelete },
                success: function(tResult) {
                    var aReturn = JSON.parse(tResult);
                    if (aReturn['nStaEvent'] == '1') {
                        setTimeout(function() {
                            $('#odvModalDelRole').modal('hide');
                            $('#ospConfirmDelete').text($('#oetTextComfirmDeleteSingle').val());
                            $('#ohdConfirmIDDelete').val('');
                            localStorage.removeItem('LocalItemData');
                            $('.modal-backdrop').remove();
                            if(aReturn["nNumRowRolLoc"]!=0){
                                if(aReturn["nNumRowRolLoc"]>10){
                                    nNumPage = Math.ceil(aReturn["nNumRowRolLoc"]/10);
                                    if(pnPage<=nNumPage){
                                        JSvCallPageRoleList(pnPage);
                                    }else{
                                        JSvCallPageRoleList(nNumPage);
                                    }
                                }else{
                                    JSvCallPageRoleList(1);
                                }
                            }else{
                                JSvCallPageRoleList(1);
                            }
                        }, 500);
                    } else {
                        alert(aReturn['tStaMessg']);
                    }
                    JSxRoleNavDefult();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        } else {
            localStorage.StaDeleteArray = '0';
            return false;
        }
    }else{
        JCNxShowMsgSessionExpired();
    }
}

//Functionality : เปลี่ยนหน้า pagenation
//Parameters : Event Click Button
//Creator : 27/08/2019 wasin(Yoshi)
//Return : View
//Return Type : View
function JSvRoleClickPage(ptPage){
    var nPageCurrent = '';
    switch (ptPage) {
        case 'next': //กดปุ่ม Next
            $('.xWBtnNext').addClass('disabled');
            nPageOld = $('.xWPageRoleGrp .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
            nPageCurrent = nPageNew
            break;
        case 'previous': //กดปุ่ม Previous
            nPageOld = $('.xWPageRoleGrp .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
            nPageCurrent = nPageNew
            break;
        default:
            nPageCurrent = ptPage
    }
    JCNxOpenLoading();
    JSvCallPageRoleDataTable(nPageCurrent);
}

// Functionality: Function Chack And Show Button Delete All
// Parameters: LocalStorage Data
// Creator: 22/06/2018 wasin
// Last Update : 15/08/2019 Wasin(Yoshi)
// Return: Show Button Delete All
// Return Type: -
function JCNxRoleShowBtnChoose(){
    var aArrayConvert   = [JSON.parse(localStorage.getItem("LocalItemData"))];
    if(aArrayConvert[0] == null || aArrayConvert[0] == ""){
        $("#odvMngTableList #oliBtnDeleteAll").addClass("disabled");
    }else{
        nNumOfArr = aArrayConvert[0].length;
        if (nNumOfArr > 1) {
            $("#odvMngTableList #oliBtnDeleteAll").removeClass("disabled");
        } else {
            $("#odvMngTableList #oliBtnDeleteAll").addClass("disabled");
        }
    }
}

// Functionality: Insert Text In Modal Delete
// Parameters: LocalStorage Data
// Creator: 22/06/2018 wasin
// Last Update : 15/08/2019 Wasin(Yoshi)
// Return: Insert Code In Text Input
// Return Type: -
function JCNxRoleTextInModal(){
    var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
    if (aArrayConvert[0] == null || aArrayConvert[0] == "") { } else {
        var tTextCode = "";
        for ($i = 0; $i < aArrayConvert[0].length; $i++) {
            tTextCode += aArrayConvert[0][$i].nCode;
            tTextCode += " , ";
        }

        //Disabled ปุ่ม Delete
        if (aArrayConvert[0].length > 1) {
            $(".xCNIconDel").addClass("xCNDisabled");
        } else {
            $(".xCNIconDel").removeClass("xCNDisabled");
        }
        $("#odvModalDelRole #ospConfirmDelete").text($('#oetTextComfirmDeleteMulti').val());
        $("#odvModalDelRole #ohdConfirmIDDelete").val(tTextCode);
    }
}

// Functionality: Check Data Duplicate In Array
// Parameters: Event Select List Branch
// Creator: 22/06/2018 wasin
// Last Update : 15/08/2019 Wasin(Yoshi)
// Return: Duplicate/none
// Return Type: string
function JCNxRoleFindObjectByKey(array,key,value){
    for (var i = 0; i < array.length; i++) {
        if (array[i][key] === value) {
            return "Dupilcate";
        }
    }
    return "None";
}

// Functionality: Function Check Is Create Page
// Parameters: Event Documet Redy
// Creator: 22/03/2019 wasin(Yoshi)
// Return: object Status Delete
// ReturnType: boolean
function JSbRoleIsCreatePage(){
    try{
        const tRoleCode = $('#oetRolCode').data('is-created');    
        var bStatus = false;
        if(tRoleCode == ""){ // No have data
            bStatus = true;
        }
        return bStatus;
    }catch(err){
        console.log('JSbRoleIsCreatePage Error: ', err);
    }
}

// Functionality: Function Check Is Update Page
// Parameters: Event Documet Redy
// Creator: 22/03/2019 wasin(Yoshi)
// Return: object Status Delete
// ReturnType: boolean
function JSbRoleIsUpdatePage(){
    try{
        const tRoleCode = $('#oetRolCode').data('is-created');
        var bStatus = false;
        if(!tRoleCode == ""){ // Have data
            bStatus = true;
        }
        return bStatus;
    }catch(err){
        console.log('JSbRoleIsUpdatePage Error: ', err);
    }
}

// Functionality : Show or Hide Component
// Parameters : ptComponent is element on document(id or class or...),pbVisible is visible
// Creator : 22/03/2019 Wasin (Yoshi)
// Return : -
// Return Type : -
function JSxRoleVisibleComponent(ptComponent, pbVisible, ptEffect){
    try{
        if(pbVisible == false){
            $(ptComponent).addClass('hidden');
        }
        if(pbVisible == true){
            // $(ptComponent).removeClass('hidden');
            $(ptComponent).removeClass('hidden fadeIn animated').addClass('fadeIn animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend',function(){
                $(this).removeClass('hidden fadeIn animated');
            });
        }
    }catch(err){
        console.log('JSxRoleVisibleComponent Error: ', err);
    }
}

// Functionality: Function Check Is Create Page
// Parameters: Event Documet Redy
// Creator: 22/03/2019 wasin(Yoshi)
// Return: object Status Delete
// ReturnType: boolean
function JSbRoleIsCreatePage(){
    try{
        const tRoleCode = $('#oetRolCode').data('is-created');    
        var bStatus = false;
        if(tRoleCode == ""){ // No have data
            bStatus = true;
        }
        return bStatus;
    }catch(err){
        console.log('JSbRoleIsCreatePage Error: ', err);
    }
}

// Functionality: Function Check Is Update Page
// Parameters: Event Documet Redy
// Creator: 22/03/2019 wasin(Yoshi)
// Return: object Status Delete
// ReturnType: boolean
function JSbRoleIsUpdatePage(){
    try{
        const tRoleCode = $('#oetRolCode').data('is-created');
        var bStatus = false;
        if(!tRoleCode == ""){ // Have data
            bStatus = true;
        }
        return bStatus;
    }catch(err){
        console.log('JSbRoleIsUpdatePage Error: ', err);
    }
}

// Functionality : Show or Hide Component
// Parameters : ptComponent is element on document(id or class or...),pbVisible is visible
// Creator : 22/03/2019 Wasin (Yoshi)
// Return : -
// Return Type : -
function JSxRoleVisibleComponent(ptComponent, pbVisible, ptEffect){
    try{
        if(pbVisible == false){
            $(ptComponent).addClass('hidden');
        }
        if(pbVisible == true){
            // $(ptComponent).removeClass('hidden');
            $(ptComponent).removeClass('hidden fadeIn animated').addClass('fadeIn animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend',function(){
                $(this).removeClass('hidden fadeIn animated');
            });
        }
    }catch(err){
        console.log('JSxRoleVisibleComponent Error: ', err);
    }
}



