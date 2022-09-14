var nSMTSALBrowseType   = $("#ohdSMTSALBrowseType").val();
var tSMTSALBrowseOption = $("#ohdSMTSALBrowseOption").val();

$("document").ready(function(){
    localStorage.removeItem("LocalItemData");
    JSxCheckPinMenuClose();
    if(typeof(nSMTSALBrowseType) != 'undefined' && nSMTSALBrowseType == 0){


        // Event Click Navigater Title (คลิก Title ของเอกสาร)
        $('#oliSMTSALTitle').unbind().click(function(){
            let nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== "undefined" && nStaSession == 1) {
                // $('#oetSMTSALDateDataTo').val($(this).attr('datenow'));
                JSvSMTSALPageDashBoardMain();
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        JCNxOpenLoading();
        JSvSMTSALPageDashBoardMain();
        // JSxSMTSubMQResponsRepair();
    }
    

});



// Function: Call Main Page DashBoard
// Parameters: Document Ready Or Parameter Event
// Creator: 14/01/2020 Wasin(Yoshi)
// Return: View Page Main
// ReturnType: View
function JSvSMTSALPageDashBoardMain(){
    JCNxOpenLoading();
    // const tDateDataForm = $('#oetSMTSALDateDataForm').val();
    // const tDateDataTo   = $('#oetSMTSALDateDataTo').val();
    $.ajax({
        type: "POST",
        url: "salemonitorMainPage",
        cache: false,
        data: {
            // 'ptDateDataForm'    : tDateDataForm,
            // 'ptDateDataTo'      : tDateDataTo
        },
        timeout: 0,
        success: function (tResult){
            $("#odvSMTSALContentPage").html(tResult);

       //     JCNxSMTCallSaleDataTable();
            // JCNxSMTCallApiDataTable();
    
            // JCNxCloseLoading();
        },
        error: function (jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}



// Function: Call Modal Option Modal Filter
// Parameters: Document Ready Or Parameter Event
// Creator: 31/01/2020 Wasin(Yoshi)
// Return: View Page Main
// ReturnType: View
function JSvSMTSALCallModalFilterDashBoard(ptFilterDataKey,ptFilterDataGrp,ptStaShw){

    // var nSMTSALFilterBchCodeCount = $('#oetSMTSALFilterBchCodeCount').val();
    var oSMTPackDataSearch = JSON.parse(localStorage.getItem("oSMTPackDataSearch"));
    // console.log(oSMTPackDataSearch);
    if( oSMTPackDataSearch !== null ){
        var tSMTSALFilterBchCode = oSMTPackDataSearch['oetSMTSALFilterBchCode'];
        var tSMTSALFilterBchStaAll = oSMTPackDataSearch['oetSMTSALFilterBchStaAll'];
        var tSMTSALFilterBchName = oSMTPackDataSearch['oetSMTSALFilterBchName'];
        
        var tSMTSALFilterShpStaAll = oSMTPackDataSearch['oetSMTSALFilterShpStaAll'];
        var tSMTSALFilterShpCode = oSMTPackDataSearch['oetSMTSALFilterShpCode'];
        var tSMTSALFilterShpName = oSMTPackDataSearch['oetSMTSALFilterShpName'];

        var oetSMTSALFilterPosStaAll = oSMTPackDataSearch['oetSMTSALFilterPosStaAll'];
        var oetSMTSALFilterPosCode = oSMTPackDataSearch['oetSMTSALFilterPosCode'];
        var oetSMTSALFilterPosName = oSMTPackDataSearch['oetSMTSALFilterPosName'];

        var tSMTSALFilterUsrStaAll = oSMTPackDataSearch['oetSMTSALFilterUsrStaAll'];
        var tSMTSALFilterUsrCode = oSMTPackDataSearch['oetSMTSALFilterUsrCode'];
        var tSMTSALFilterUsrName = oSMTPackDataSearch['oetSMTSALFilterUsrName'];
    }else{
        var tSMTSALFilterBchCode = $('#oetSMTSALFilterBchCode').val();
        var tSMTSALFilterBchStaAll = $('#oetSMTSALFilterBchStaAll').val();
        var tSMTSALFilterBchName = $('#oetSMTSALFilterBchName').val();

        var tSMTSALFilterShpStaAll = $('#oetSMTSALFilterShpStaAll').val();
        var tSMTSALFilterShpCode = $('#oetSMTSALFilterShpCode').val();
        var tSMTSALFilterShpName = $('#oetSMTSALFilterShpName').val();

        var oetSMTSALFilterPosStaAll = $('#oetSMTSALFilterPosStaAll').val();
        var oetSMTSALFilterPosCode = $('#oetSMTSALFilterPosCode').val();
        var oetSMTSALFilterPosName = $('#oetSMTSALFilterPosName').val();

        var tSMTSALFilterUsrStaAll = $('#oetSMTSALFilterUsrStaAll').val();
        var tSMTSALFilterUsrCode = $('#oetSMTSALFilterUsrCode').val();
        var tSMTSALFilterUsrName = $('#oetSMTSALFilterUsrName').val();
    }

    $.ajax({
        type: "POST",
        url: "salemonitorCallModalFilter",
        data: {
            'ptFilterDataKey'   : ptFilterDataKey,
            'ptFilterDataGrp'   : ptFilterDataGrp,
        },
        cache: false,
        timeout: 0,
        success : function(ptViewModalHtml){
            $('#odvSMTSALModalFilterHTML').html(ptViewModalHtml);

            if( ptStaShw == '1' ){
                $('#odvSMTSALModalFilter').modal({backdrop: 'static', keyboard: false})  
                $('#odvSMTSALModalFilter').modal('show');
            }

            // $('#nSMTSALFilterBchCodeCount').val(nSMTSALFilterBchCodeCount);
            $('#oetSMTSALFilterBchCode').val(tSMTSALFilterBchCode);
            $('#oetSMTSALFilterBchStaAll').val(tSMTSALFilterBchStaAll);
            $('#oetSMTSALFilterBchName').val(tSMTSALFilterBchName);
            
            $('#oetSMTSALFilterShpStaAll').val(tSMTSALFilterShpStaAll);
            $('#oetSMTSALFilterShpCode').val(tSMTSALFilterShpCode);
            $('#oetSMTSALFilterShpName').val(tSMTSALFilterShpName);

            $('#oetSMTSALFilterPosStaAll').val(oetSMTSALFilterPosStaAll);
            $('#oetSMTSALFilterPosCode').val(oetSMTSALFilterPosCode);
            $('#oetSMTSALFilterPosName').val(oetSMTSALFilterPosName);

            $('#oetSMTSALFilterUsrStaAll').val(tSMTSALFilterUsrStaAll);
            $('#oetSMTSALFilterUsrCode').val(tSMTSALFilterUsrCode);
            $('#oetSMTSALFilterUsrName').val(tSMTSALFilterUsrName);

            var tFilterBchCode = $('#ohdSMTSALSessionBchCode').val();
            var tFilterBchName = $('#ohdSMTSALSessionBchName').val();
            var nSesUsrBchCount = $('#odhnSesUsrBchCount').val();
            if( nSesUsrBchCount == 1 && tSMTSALFilterBchCode == "" ){
                $('#oetSMTSALFilterBchCode').val(tFilterBchCode);
                $('#oetSMTSALFilterBchName').val(tFilterBchName);
                $('#obtSMTSALFilterShp').attr('disabled',false);
                $('#obtSMTSALFilterPos').attr('disabled',true);
                $('#obtSMTSALFilterBch').attr('disabled',true);
            }

            // if( tSMTSALFilterBchCode != "" && nSMTSALFilterBchCodeCount == 1 ){
            //     $('#obtSMTSALFilterShp').attr('disabled',false);
            //     $('#obtSMTSALFilterPos').attr('disabled',false);
            // }

        },
        error : function (jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR,textStatus,errorThrown);
        }
    });
}

// Function: Confirm Filter DashBoard
// Parameters: Document Ready Or Parameter Event
// Creator: 06/02/2020 Wasin(Yoshi)
// Return: View Page Main
// ReturnType: View
function JCNxSMTSALConfirmFilter(ptFilterKey){
    const tDateDataTo   = $('#oetSMTSALDateDataTo').val();
    JCNxOpenLoading();
    if($('#ohdSMTSALFilterKey').val()=='FSD'){
        JCNxSMTCallSaleDataTable();
    }else{
        JCNxSMTCallApiDataTable();
    }
    $('#odvSMTSALModalFilter').modal('hide');
}




// Function: Confirm Filter DashBoard
// Parameters: Document Ready Or Parameter Event
// Creator: 06/02/2020 Wasin(Yoshi)
// Return: View Page Main
// ReturnType: View
function JCNxSMTCallSaleDataTable(nPageCurrent){
    const tDateDataForm   = $('#oetSMTSALDateDataForm').val();
    const tDateDataTo     = $('#oetSMTSALDateDataTo').val();
    const tDSHSALSort     = $('#oetDSHSALSort').val();
    const tDSHSALFild     = $('#oetDSHSALFild').val();
    
    if( nPageCurrent == '' || nPageCurrent == undefined || nPageCurrent == 'NaN' ){
        var oSMTPackDataSearch = JSON.parse(localStorage.getItem("oSMTPackDataSearch"));
        if( oSMTPackDataSearch !== null ){
            nPageCurrent = oSMTPackDataSearch['nPageCurrents'];
        }else{
            nPageCurrent = 1;
        }
    }
    
    var oSMTPackDataSearch = {
        'oetSMTSALDateDataForm'         : $('#oetSMTSALDateDataForm').val(),
        'oetSMTSALDateDataTo'           : $('#oetSMTSALDateDataTo').val(),

        'oetSMTSALFilterBchStaAll'      : $('#oetSMTSALFilterBchStaAll').val(),
        'oetSMTSALFilterBchCode'        : $('#oetSMTSALFilterBchCode').val(),
        'oetSMTSALFilterBchName'        : $('#oetSMTSALFilterBchName').val(),

        'oetSMTSALFilterShpStaAll'      : $("#oetSMTSALFilterShpStaAll").val(),
        'oetSMTSALFilterShpCode'        : $("#oetSMTSALFilterShpCode").val(),
        'oetSMTSALFilterShpName'        : $("#oetSMTSALFilterShpName").val(),

        'oetSMTSALFilterPosStaAll'      : $("#oetSMTSALFilterPosStaAll").val(),
        'oetSMTSALFilterPosCode'        : $("#oetSMTSALFilterPosCode").val(),
        'oetSMTSALFilterPosName'        : $("#oetSMTSALFilterPosName").val(),

        'oetSMTSALFilterUsrStaAll'      : $("#oetSMTSALFilterUsrStaAll").val(),
        'oetSMTSALFilterUsrCode'        : $("#oetSMTSALFilterUsrCode").val(),
        'oetSMTSALFilterUsrName'        : $("#oetSMTSALFilterUsrName").val(),

        'nPageCurrents'                 : nPageCurrent
    };
    localStorage.setItem("oSMTPackDataSearch", JSON.stringify(oSMTPackDataSearch));
    // console.log($('#odvSMTSALModalFilter #ofmSMTSALFormFilter').serializeArray());

    $.ajax({
        type: "POST",
        url: "salemonitorCallSaleDataTable",
        data: $('#odvSMTSALModalFilter #ofmSMTSALFormFilter').serialize()+"&oetSMTSALDateDataForm="+tDateDataForm+"&oetSMTSALDateDataTo="+tDateDataTo+"&oetDSHSALSort="+tDSHSALSort+"&oetDSHSALFild="+tDSHSALFild+"&nPageCurrent="+nPageCurrent,
        cache: false,
        timeout: 0,
        success : function(paDataReturn){
            $('#odvPanelSaleData').html(paDataReturn);
            // var tSesUsrBchCode =  $('#odhSesUsrBchCode').val();
            // JSxSMTControlTableData();
            // JSxSMTCallMQRequestSaleData(tSesUsrBchCode,'','',10);
            JCNxCloseLoading();
        },
        error : function (jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR,textStatus,errorThrown);
        }
    });
}



// Function: Sort And Filter Total By Branch
// Parameters: Document Ready Or Parameter Event
// Creator: 17/06/2020 Worakorn
// Return: View Page Main
// ReturnType: View
function JSvTotalByBranchSort(ptFild) {

    const oetDSHSALSort = $('#oetDSHSALSort').val();

    $('#oetDSHSALFild').val(ptFild);

    if (oetDSHSALSort == 'ASC') {
        $('#oetDSHSALSort').val('DESC');
    } else {
        $('#oetDSHSALSort').val('ASC');
    }
    JCNxSMTCallSaleDataTable();

}



    //Functionality : เปลี่ยนหน้า pagenation
    //Parameters : Event Click Pagenation
    //Creator : 06/10/2020 Worakorn
    //Return : View
    //Return Type : View
    function JSvSaleMonitorClickPage(ptPage) {
        var nPageCurrent = '';
        switch (ptPage) {
            case 'next': //กดปุ่ม Next
                $('.xWBtnNext').addClass('disabled');
                nPageOld = $('.xWPageTotalByBranch .active').text(); // Get เลขก่อนหน้า
                nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
                nPageCurrent = nPageNew
                break;
            case 'previous': //กดปุ่ม Previous
                nPageOld = $('.xWPageTotalByBranch .active').text(); // Get เลขก่อนหน้า
                nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
                nPageCurrent = nPageNew
                break;
            default:
                nPageCurrent = ptPage
        }

        $('#oetSMTPageCurrents').val(nPageCurrent);
        JCNxSMTCallSaleDataTable(nPageCurrent);
    }



    //Functionality : 
    //Parameters : 
    //Creator : 27/08/2020 Nattakit
    //Return : View
    //Return Type : View
    function JCNxSMTCallMQInformation(){

        JCNxOpenLoading();
        $.ajax({
            type: "POST",
            url: "dasMQICallMianPage",
            cache: false,
            timeout: 0,
            success: function (tResult){
                $("#odvSMTMQInformation").html(tResult);
                // JCNxCloseLoading();

            },
            error: function (jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });

    }



    //Functionality : 
    //Parameters : 
    //Creator : 27/08/2020 Nattakit
    //Return : View
    //Return Type : View
    function JCNxSMTCallSaleTools(){

        JCNxOpenLoading();
        $.ajax({
            type: "POST",
            url: "dasSTLCallMianPage",
            cache: false,
            timeout: 0,
            success: function (tResult){
                $("#odvSMTSaleTools").html(tResult);
                // JCNxCloseLoading();

            },
            error: function (jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });

    }


    //Functionality : 
    //Parameters : 
    //Creator : 27/08/2020 Nattakit
    //Return : View
    //Return Type : View
    function JCNxSMTCallSaleImport(){

        JCNxOpenLoading();
        $.ajax({
            type: "POST",
            url: "dasIMPCallMianPage",
            cache: false,
            timeout: 0,
            success: function (tResult){
                $("#odvSMTSaleTools").html(tResult);
                // JCNxCloseLoading();

            },
            error: function (jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });

    }
    

    