var nStaCmpBrowseType = $('#oetCmpStaBrowse').val();
var tCallCmpBackOption = $('#oetCmpCallBackOption').val();
var nCurrentTab = 1; // 11/04/2019 pap ตัวแปรเก็บแท็ปที่แสดงในปัจจุบัน
var bStsValidTabGenaral = false; // 11/04/2019 ตัวแปรตรวจสอบ validate tab general
var bStsValidTabAddress = false; // 11/04/2019 ตัวแปรตรวจสอบ validate tab address
$('ducument').ready(function() {
    localStorage.removeItem('LocalItemData');
    JSxCheckPinMenuClose(); /*Check เปิดปิด Menu ตาม Pin*/
    JSxCMPNavDefult();
    if (nStaCmpBrowseType != 1) {
        JSvCallPageCompanyList();
    } else {
        JSxCallPageCompanyEdit();
    }
});

//function : Function Clear Defult Button
//Parameters : -
//Creator : 30/04/2018 Wasin
//Last Update: 02/07/2018 wasin [ปรับรองรับการเพิ่มข้อมูลผ่านหน้าและ Modal Error Browse]
//Return : -
//Return Type : -
function JSxCMPNavDefult() {
    if (nStaCmpBrowseType != 1) {
        $('.xCNCmpVBrowse').hide();
        $('.xCNCmpVMaster').show();
        $('#odvColNavMenu').addClass('col-xs-8').removeClass('col-xs-12');
        $('#odvColBtnMenu').addClass('col-xs-4').removeClass('col-xs-12');
        $('#oliCMPEditInfo').hide();
        $('#oliCMPTitle').show();
        $('#odvBtnAddEdit').hide();
        $('#odvBtnCmpInfo').show();
    }else{
        $('#odvModalBody .xCNCmpVMaster').hide();
        $('#odvModalBody .xCNCmpVBrowse').show();
        $('#odvModalBody #odvCmpMainMenu').removeClass('main-menu');
        $('#odvModalBody #oliCmpNavBrowse').css('padding', '2px');
        $('#odvModalBody #odvCmpBtnGroup').css('padding', '0');
        $('#odvModalBody .xCNCmpBrowseLine').css('padding', '0px 0px');
        $('#odvModalBody .xCNCmpBrowseLine').css('border-bottom', '1px solid #e3e3e3');
    }
}

//function : Call Company Page list 
//Parameters : Event Document Redy And Event Call Back Button
//Creator :	30/04/2018 Wasin
//Last Update: 04/09/2019 wasin(Yoshi)
//Return : View
//Return Type : View
function JSvCallPageCompanyList(){
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
        localStorage.tStaPageNow = 'JSvCallPageCompanyList';
        JCNxOpenLoading();
        $.ajax({
            type: "POST",
            url: "companyList",
            success: function(tResult) {
                var aDataReturn = JSON.parse(tResult);
                if(aDataReturn['nStaEvent'] == 1){
                    $('#odvContentPageCompany').html(aDataReturn['tCompanyListView']);
                    JSxCMPNavDefult();
                    JCNxLayoutControll();
                    JStCMMGetPanalLangHTML('TCNMComp_L');
                }else{
                    var tMessageError   = aDataReturn['tStaMessg'];
                    FSvCMNSetMsgErrorDialog(tMessageError);
                }
                JCNxCloseLoading();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }else{
        JCNxShowMsgSessionExpired();
    }
}

//function : Open Tag Input Edit Page
//Parameters : - 
//Creator :	30/04/2018 Wasin
//Last Update: 02/07/2018 wasin [ปรับรองรับการเพิ่มข้อมูลผ่านหน้าและ Modal Error Browse]
//Return : -
//Return Type : -
function JSxCallPageCompanyEdit(ptCmpCode) {
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
        if (ptCmpCode != "") {
            JStCMMGetPanalLangSystemHTML('JSxCallPageCompanyEdit',ptCmpCode);
        } else {
            JStCMMGetPanalLangSystemHTML('', '');
        }
        JCNxOpenLoading();
        $.ajax({
            type: "POST",
            url: "companyPageEdit",
            success: function(tResult){
                var aDataReturn = JSON.parse(tResult);
                if(aDataReturn['nStaEvent'] == 1){
                    $('#odvBtnCmpInfo').hide();
                    $('#oliCMPEditInfo').show();
                    $('#odvBtnAddEdit').show();
                    $('#odvContentPageCompany').html(aDataReturn['tCompanyFormView']);
                }else{
                    var tMessageError   = aDataReturn['tStaMessg'];
                    FSvCMNSetMsgErrorDialog(tMessageError);
                }
                JCNxCloseLoading();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }else{
        JCNxShowMsgSessionExpired();
    }
}

//function : Function Add Edit Company
//Parameters : 
//Creator : 30/04/2018 Wasin
//Update: 02/07/2018 wasin [ปรับรองรับการเพิ่มข้อมูลผ่านหน้าและ Modal Error Browse]
//Update : 04/09/2019 Wasin [เปลี่ยน รูปแบบการ Add ตัดข้อมูลในส่วนของ ที่อยู่ ]
//Return : Call Back Data
//Return Type :  object
function JSnAddEditCompany(){
    $('#ofmAddEditCompany').validate().destroy();
    $('#ofmAddEditCompany').validate({
        rules: {
            oetCmpName      : {"required" :{}},
            oetCmpBchName   : {"required" :{}},
            oetVatRateName  : {"required" :{}},
            oetCmpRteName   : {"required" :{}},
        },
        messages: {
            oetCmpName      : {
                "required"  : $('#oetCmpName').attr('data-validate-required'),
            },
            oetCmpBchName   : {
                "required"  : $('#oetCmpBchName').attr('data-validate-required'),
            },
            oetVatRateName  : {
                "required"  : $('#oetVatRateName').attr('data-validate-required'),
            },
            oetCmpRteName   : {
                "required"  : $('#oetVatRateName').attr('data-validate-required'),
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
            $(element).closest('.form-group').addClass( "has-error" ).removeClass( "has-success" );
        },
        unhighlight: function(element, errorClass, validClass) {
            $( element ).closest('.form-group').addClass( "has-success" ).removeClass( "has-error" );
        },
        submitHandler: function(form){
            JCNxOpenLoading();
            $.ajax({
                type: "POST",
                url: $('#oetCmpRoute').val(),
                data: $('#ofmAddEditCompany').serialize(),
                success: function (tResult){
                    var aDataReturn = JSON.parse(tResult);
                    if(aDataReturn['nStaEvent'] == 1){
                        JSvCallPageCompanyList();
                        JCNxImgWarningMessage(aDataReturn['aImgReturn']);
                    }else{
                        var tMsgErrorFunction   = aDataReturn['tStaMessg'];
                        FSvCMNSetMsgErrorDialog('<p class="text-left">'+tMsgErrorFunction+'</p>');
                    }
                    JCNxCloseLoading();
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }
    });
}
