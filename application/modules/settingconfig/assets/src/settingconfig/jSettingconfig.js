var nStaSettingConfigBrowseType     = $("#oetSettingConfigStaBrowse").val();
var tCallSettingConfigBackOption    = $("#oetSettingConfigCallBackOption").val();

$("document").ready(function () {
    localStorage.removeItem("LocalItemData");
    JSxCheckPinMenuClose(); 
    JSvSettingConfigCallPageList();
});

//Get FuncHD List Page
function JSvSettingConfigCallPageList() {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof nStaSession !== "undefined" && nStaSession == 1) {
        try {
            localStorage.removeItem('LocalItemData');
            $.ajax({
                type    : "POST",
                url     : "SettingConfigGetList",
                data    : {},
                cache   : false,
                timeout : 5000,
                success : function (tResult) {
                    $("#odvContentPageSettingConfig").html(tResult);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }catch (err) {
            console.log('JSvSettingConfigCallPageList Error: ', err);
        }
    } else {
        JCNxShowMsgSessionExpired();
    }
}

/////////////////////////////////////////////////////////////////////////////////////////////// แท็บตั้งค่าระบบ

//Load View Setting Config Search (หน้าค้นหา + ปุ่มบันทึก)
function JSvSettingConfigLoadViewSearch(){
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof nStaSession !== "undefined" && nStaSession == 1) {
        try {
            localStorage.removeItem('LocalItemData');
            $.ajax({
                type    : "POST",
                url     : "SettingConfigLoadViewSearch",
                data    : {
                    ptTypePage : 'Main'
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
        }catch (err) {
            console.log('JSvSettingConfigCallPageList Error: ', err);
        }
    } else {
        JCNxShowMsgSessionExpired();
    }
}

//Load Table Setting 
function JSvSettingConfigLoadTable(){
    JCNxOpenLoading();
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof nStaSession !== "undefined" && nStaSession == 1) {
        try {
            localStorage.removeItem('LocalItemData');

            var tAppType    = $("#ocmAppType option:selected").val();
            var tSearch     = $('#oetSearchAll').val();
            var tTypePage   = $('#ohdSETTypePage').val();
            if( tTypePage == "Agency" ){
                tAgnCode = $('#oetAgnCode').val();
            }else{
                tAgnCode = '';
            }

            $.ajax({
                type    : "POST",
                url     : "SettingConfigLoadTable",
                data    : { 
                    tAppType    : tAppType, 
                    tSearch     : tSearch,
                    ptTypePage  : tTypePage,
                    ptAgnCode   : tAgnCode
                },
                cache   : false,
                timeout : 0,
                success : function (tResult) {
                    aPackData       = [];
                    aPackDataInput  = [];
                    $("#odvContentConfigTable").html('');
                    $("#odvContentConfigTable").html(tResult);
                    JSxControlScroll();
                    JCNxCloseLoading();
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }catch (err) {
            console.log('JSvSettingConfigCallPageList Error: ', err);
        }
    } else {
        JCNxShowMsgSessionExpired();
    }
}

//ควบคุมตารางให้มีสกอร์ หรือไม่มีสกอร์
function JSxControlScroll(){
    var nWindowHeight = ( $(window).height() - 460 ) / 2 ;

    //สำหรับตารางที่เป็นเช็คบ๊อก
    var nLenCheckbox =  $('#otbTableForCheckbox tbody tr').length;
    if(nLenCheckbox > 6){
        $('.xCNTableHeightCheckbox').css('height',nWindowHeight);
    }else{
        $('.xCNTableHeightCheckbox').css('height','auto');
    }

    //สำหรับตารางอื่นๆ
    var nLenInput =  $('#otbTableForInput tbody tr').length;
    if(nLenCheckbox < 6){
        var nWindowHeightInput = ( $(window).height() - 125 ) / 2 ;
    }else{
        var nWindowHeightInput = nWindowHeight;
    }

    if(nLenInput > 6){
        $('.xCNTableHeightInput').css('height',nWindowHeightInput);
    }else{
        $('.xCNTableHeightInput').css('height','auto');
    }
}

//โชว์ Modal ยกเลิก
function JSxSETCancel(){
    $('#odvModalSETCancel').modal('show');
}

//Event Modal ยกเลิก
function JSxSETModalCancel(){
    $('#odvModalSETCancel').modal('hide');

    //ล้างค่าก่อนโหลดหน้าอีกครั้ง
    $("#ocmAppType option[value='0']").attr("selected","selected");
    $('.selectpicker').selectpicker('refresh');
    $('#oetSearchAll').val('');
    JSvSettingConfigLoadTable();
}

//Event Value in Checkbox
var aPackData = [];
function JSxEventClickCheckbox(elem){
    var tSyscode    = $(elem).attr('data-syscode');
    var tSysapp     = $(elem).attr('data-sysapp');
    var tSyskey     = $(elem).attr('data-syskey');
    var tSysseq     = $(elem).attr('data-sysseq');
    var tChcekbox   = $(elem).is(':checked') ? 1 : 0;

    var nLenArray   = aPackData.length;
    if(nLenArray >= 1){
        for($i=0; $i<aPackData.length; $i++){
            if(tSyscode == aPackData[$i]['tSyscode'] 
                && tSysapp == aPackData[$i]['tSysapp']
                && tSyskey == aPackData[$i]['tSyskey']
                && tSysseq == aPackData[$i]['tSysseq']  ){
                    aPackData.splice($i, 1);
            }
        }
    }
    
    //เก็บค่าไว้ใน array
    var aSubValue   = {
        'tSyscode'  : tSyscode , 
        'tSysapp'   : tSysapp ,
        'tSyskey'   : tSyskey ,
        'tSysseq'   : tSysseq ,
        'nValue'    : tChcekbox ,
        'tKind'     : 'Make',
        'tType'     : 'checkbox'
    };
    aPackData.push(aSubValue);
}

//Event Save - บันทึก
function JSxSETSave(){
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof nStaSession !== "undefined" && nStaSession == 1) {
        try {
            // console.log(aPackDataInput);
            aPackDataInput = JSxConfigEachValueToArray();
             console.log("aPackDataInput",aPackDataInput);
            for(i=0; i<aPackDataInput.length; i++){
                if(aPackDataInput[i].tType=='7'){
                    if(aPackDataInput[i].nValue!=aPackDataInput[i].tOldpws){
                        aPackDataInput[i].nValue = JCNtAES128EncryptData(aPackDataInput[i].nValue,tKey,tIV);
                    
                    }
                }
            }
            var aMergeArray = aPackData.concat(aPackDataInput);
            var tTypePage   = $('#ohdSETTypePage').val();
            if( tTypePage == "Agency" ){
                tAgnCode = $('#oetAgnCode').val();
            }else{
                tAgnCode = '';
            }

            localStorage.removeItem('LocalItemData');
            $.ajax({
                type    : "POST",
                url     : "SettingConfigSave",
                data    : {
                    aMergeArray   : aMergeArray,
                    ptTypePage    : tTypePage,
                    ptAgnCode     : tAgnCode
                },
                cache   : false,
                timeout : 0,
                success : function (tResult) {
                    JSvSettingConfigLoadTable();
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }catch (err) {
            console.log('JSvSettingConfigCallPageList Error: ', err);
        }
    } else {
        JCNxShowMsgSessionExpired();
    }
}

//Event Default - โชว์หน้าต่าง ใช้แม่แบบ
function JSxSETReDefault(){
    $('#odvModalSETDefault').modal('show');
}

//Event Use Default  - ใช้แม่แบบ
function JSxSETModalDefault(){
    $('#odvModalSETDefault').modal('hide');
    $.ajax({
        type    : "POST",
        url     : "SettingConfigUseDefaultValue",
        data    : { },
        cache   : false,
        timeout : 5000,
        success : function (tResult) {
            $("#ocmAppType option[value='0']").attr("selected","selected");
            $('.selectpicker').selectpicker('refresh');
            $('#oetSearchAll').val('');
            JSvSettingConfigLoadTable();
        },
        error: function (jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

/////////////////////////////////////////////////////////////////////////////////////////////// แท็บรหัสอัตโนมัติ


//Load View Setting Number Search (หน้าค้นหา + ปุ่มบันทึก)
function JSvSettingNumberLoadViewSearch(){
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof nStaSession !== "undefined" && nStaSession == 1) {
        try {
            localStorage.removeItem('LocalItemData');
            $.ajax({
                type    : "POST",
                url     : "SettingAutonumberLoadViewSearch",
                data    : {},
                cache   : false,
                timeout : 5000,
                success : function (tResult) {
                    $("#odvInforAutonumber").html(tResult);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }catch (err) {
            console.log('JSvSettingConfigCallPageList Error: ', err);
        }
    } else {
        JCNxShowMsgSessionExpired();
    }
}

function JSvSCFLoadViewAPISearch(){
    JCNxOpenLoading();
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof nStaSession !== "undefined" && nStaSession == 1) {
        try {
            localStorage.removeItem('LocalItemData');
            $.ajax({
                type    : "POST",
                url     : "connectSetGenaral",
                data    : {
                    tStaApiTxnType : '3'
                },
                cache   : false,
                success : function (tResult) {
                    $("#odvSCFApiCentent").html(tResult);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }catch (err) {
            console.log('JSvSCFLoadViewAPISearch Error: ', err);
        }
    }else{
        JCNxShowMsgSessionExpired();
    }
}

//Load View Datatable
function JSvSettingAutoNumberLoadTable(){
    JCNxOpenLoading();
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof nStaSession !== "undefined" && nStaSession == 1) {
        try {
            localStorage.removeItem('LocalItemData');

            var tAppType    = '';
            var tSearch     = $('#oetSearchAllAutoNumber').val();
            $.ajax({
                type    : "POST",
                url     : "SettingAutonumberLoadTable",
                data    : { 'tAppType' : tAppType , 'tSearch' : tSearch , 'tAgnCode' : $('#oetAgnCode').val()},
                cache   : false,
                timeout : 5000,
                success : function (tResult) {
                    aPackData       = [];
                    aPackDataInput  = [];
                    $("#odvContentAutoNumber").html('');
                    $("#odvContentAutoNumber").html(tResult);
                    JCNxCloseLoading();
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }catch (err) {
            console.log('JSvSettingConfigCallPageList Error: ', err);
        }
    } else {
        JCNxShowMsgSessionExpired();
    }
}

//Load Page Update
function JSvCallPageUpdateAutonumber(ptTable,pnSeq){
    JCNxOpenLoading();
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof nStaSession !== "undefined" && nStaSession == 1) {
        try {
            localStorage.removeItem('LocalItemData');
            $.ajax({
                type    : "POST",
                url     : "SettingAutonumberLoadPageEdit",
                data    : { 'ptTable' : ptTable , 'pnSeq' : pnSeq , 'tAgnCode' : $('#oetAgnCode').val()},
                cache   : false,
                timeout : 5000,
                success : function (tResult) {
                    $("#odvInforAutonumber").html('');
                    setTimeout(function(){  
                        $("#odvInforAutonumber").html(tResult);
                    }, 500);
                    JCNxCloseLoading();
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }catch (err) {
            console.log('JSvSettingConfigCallPageList Error: ', err);
        }
    } else {
        JCNxShowMsgSessionExpired();
    }
}
