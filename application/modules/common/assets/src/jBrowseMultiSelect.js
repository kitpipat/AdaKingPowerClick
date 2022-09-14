
var tHtmlModalMulti  = '<div id="odvModalBrowseMulti" class="modal fade xCNModalByModule" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" style="overflow-x: hidden;overflow-y: auto;">';
tHtmlModalMulti     += '<div class="modal-dialog" role="document">';
tHtmlModalMulti     += '<div class="modal-content">'
tHtmlModalMulti     += '</div>';
tHtmlModalMulti     += '</div>';
tHtmlModalMulti     += '</div>';

// Function: ฟังก์ชั่น Browse Data Multiple Select
// Parameters: Data Option Browse
// Creator: 12/12/2019 Wasin (Yoshi)
// Return: Append Data To Div Response
// ReturnType: None
function JCNxBrowseMultiSelect(ptOptions){
    if(window[ptOptions] != undefined || window[ptOptions] != null) {

        // Check Default Width Modal
        let nPercentWidth   = ''
        if(window[ptOptions].GrideView.WidthModal == '' || window[ptOptions].GrideView.WidthModal == null) {
            nPercentWidth   = '50';
        }else{
            nPercentWidth   = window[ptOptions].GrideView.WidthModal;
        }
    
        let nMaxWindows     = jQuery(window).width();
        let nMinWindows     = jQuery(window).height();
        let nCalcMinWidth   = ((nPercentWidth / 100) * (nMaxWindows - nMinWindows)) + nMinWindows;

        // Check Option Filter (undefined,Null)
        let tMultiBrowseFilter  = '';
        if(window[ptOptions].Filter != undefined || window[ptOptions].Filter != null){
            tMultiBrowseFilter  = $('#' + window[ptOptions].Filter.Selector).val();
        }

        // Check Option Not In (undefined,Null) 
        let tMultiBrowseNotIn   = '';
        if(window[ptOptions].NotIn != undefined || window[ptOptions].NotIn != null){
            tMultiBrowseNotIn   = $('#' + window[ptOptions].NotIn.Selector).val();
        }

        // Check Data Input Text And Get Data Input Text
        let tDataInputText      = "";
        if(window[ptOptions].CallBack.Text != undefined || window[ptOptions].CallBack.Text != null) {
            let tIDInputNameText    = window[ptOptions].CallBack.Text[0];
            tDataInputText          = $('#' + tIDInputNameText).val();
        }

        // Check Data Input Value And Get Data Input Value
        let tDataInputValue     = "";
        if(window[ptOptions].CallBack.Value != undefined || window[ptOptions].CallBack.Value != null){
            let tIDInputNameValue   = window[ptOptions].CallBack.Value[0];
            tDataInputValue         = $('#' + tIDInputNameValue).val();
        }

        // Check Data Input Status All And Get Data Input Status All
        let tDataInputStaAll    = "";
        if(window[ptOptions].CallBack.StausAll != undefined || window[ptOptions].CallBack.StausAll != null){
            let tIDInputNameStaAll  = window[ptOptions].CallBack.StausAll[0];
            tDataInputStaAll        = $('#' + tIDInputNameStaAll).val();
        }

        // Send Ajax Browse
        $.ajax({
            type    : "POST",
            url     : 'BrowseMultiple',
            cache   : false,
            data    : {
                'paOptions'     : window[ptOptions],
                'ptOptionsName' : ptOptions,
                'ptFilter'      : tMultiBrowseFilter,
                'ptNotIn'       : tMultiBrowseNotIn,
                'ptCallVal'     : tDataInputValue,
                'ptCallText'    : tDataInputText,
                'ptCallStaAll'  : tDataInputStaAll,
            },
            timeout: 0,
            success: function(tResult) {
                $('#odvModalBrowseMultiContent').html(tHtmlModalMulti);
                $('#odvModalBrowseMulti .modal-dialog').attr("style", 'min-width:' + nCalcMinWidth + 'px; margin: 1.75rem auto;');
                $('#odvModalBrowseMulti .modal-content').html(tResult);
                $('#odvModalBrowseMulti').modal({ show: true });
            },
            error: function(jqXHR, textStatus, errorThrown){
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }else{
        alert('Not Found Option Browse Multi Select.');
    }
}

// Function: ฟังก์ชั่น Search Data Browse Multi
// Parameters: Data Option Browse
// Creator: 18/12/2019 Wasin (Yoshi)
// Return: Append Data To Div Response
// ReturnType: None
function JCNxSearchMultiBrowse(ptOptions){
    if(window[ptOptions] != undefined || window[ptOptions] != null) {
        // Data Search
        let tTextFilterSearch   = $('#odvModalBrowseMulti #oetMultiBrowseInputFilterSerch').val();

        // Check Option Filter (undefined,Null)
        let tMultiBrowseFilter  = '';
        if(window[ptOptions].Filter != undefined || window[ptOptions].Filter != null){
            tMultiBrowseFilter  = $('#' + window[ptOptions].Filter.Selector).val();
        }

        // Check Option Not In (undefined,Null) 
        let tMultiBrowseNotIn   = '';
        if(window[ptOptions].NotIn != undefined || window[ptOptions].NotIn != null){
            tMultiBrowseNotIn   = $('#' + window[ptOptions].NotIn.Selector).val();
        }

        // Check Data Input Text And Get Data Input Text
        let tDataInputText      = "";
        if(window[ptOptions].CallBack.Text != undefined || window[ptOptions].CallBack.Text != null) {
            let tIDInputNameText    = window[ptOptions].CallBack.Text[0];
            tDataInputText          = $('#' + tIDInputNameText).val();
        }

        // Check Data Input Value And Get Data Input Value
        let tDataInputValue     = "";
        if(window[ptOptions].CallBack.Value != undefined || window[ptOptions].CallBack.Value != null){
            let tIDInputNameValue   = window[ptOptions].CallBack.Value[0];
            tDataInputValue         = $('#' + tIDInputNameValue).val();
        }

        // Check Data Input Status All And Get Data Input Status All
        let tDataInputStaAll    = "";
        if(window[ptOptions].CallBack.StausAll != undefined || window[ptOptions].CallBack.StausAll != null){
            let tIDInputNameStaAll  = window[ptOptions].CallBack.StausAll[0];
            tDataInputStaAll        = $('#' + tIDInputNameStaAll).val();
        }

        $.ajax({
            type    : "POST",
            url     : 'BrowseMultiple',
            cache   : false,
            data    : {
                'paOptions'         : window[ptOptions],
                'ptOptionsName'     : ptOptions,
                'ptFilter'          : tMultiBrowseFilter,
                'ptFilterSearch'    : tTextFilterSearch,
                'ptNotIn'           : tMultiBrowseNotIn,
                'ptCallVal'         : tDataInputValue,
                'ptCallText'        : tDataInputText,
                'ptCallStaAll'      : tDataInputStaAll,
            },
            timeout: 0,
            success: function(tResult) {
                $('#odvModalBrowseMulti .modal-content').html(tResult);
            },
            error: function(jqXHR, textStatus, errorThrown){
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }else{
        let tOptionNotFound = "Do not set options";
        FSvCMNSetMsgErrorDialog(tOptionNotFound);
    }
}

// Function: ฟังก์ชั่น Confirm Select Modal Multi Browse
// Parameters: Data Option Browse
// Creator: 18/12/2019 Wasin (Yoshi)
// Return: Push Data To Input Select
// ReturnType: None
function JCNxMultiBrowseConfirmSelected(ptOptions){
    // Check Name Input Return Status All
    let tCallBackStausAll  = "";
    if (window[ptOptions].CallBack.StausAll != undefined || window[ptOptions].CallBack.StausAll != null) {
        tCallBackStausAll  = window[ptOptions].CallBack.StausAll[0];
    }

    // Check Name Input Return Value
    let tCallBackValue  = "";
    if (window[ptOptions].CallBack.Value != undefined || window[ptOptions].CallBack.Value != null) {
        tCallBackValue  = window[ptOptions].CallBack.Value[0];
    }

    // Check Name Input Return Text
    let tCallBackText   = "";
    if (window[ptOptions].CallBack.Text != undefined || window[ptOptions].CallBack.Text != null) {
        tCallBackText   = window[ptOptions].CallBack.Text[0];
    }

    // Set Data In Modal To Input
    let tDataReturnStaAll   = $('#ohdMultiBrowseCallBackStaAll').val();
    let tDataReturnValue    = $('#ohdMultiBrowseCallBackValue').val();
    let tDataReturnText     = $('#ohdMultiBrowseCallBackText').val();
    $('#'+tCallBackStausAll).val(tDataReturnStaAll);
    $('#'+tCallBackValue).val(tDataReturnValue);
    $('#'+tCallBackText).val(tDataReturnText);

    // Check Data Next Func.
    if (window[ptOptions].NextFunc != undefined || window[ptOptions].NextFunc != null) {
        tGotoFunction   = (window[ptOptions].NextFunc.FuncName);
        aDataPKID       = tDataReturnValue.split(',');
        let aCalBackVal = [];
        for (var i = 0; i < aDataPKID.length; i++) {
            aCalBackVal.push($('#ohdCallBackArg' + aDataPKID[i]).val());
        }
        var oJsonData       = JSON.stringify(aCalBackVal);
        var oJsonCallBack   = JSON.parse(oJsonData);

        $('#odvModalBrowseMulti').modal('hide');
        $('.modal-backdrop').remove();
        $('body').removeClass( "modal-open" );
        return window[tGotoFunction](oJsonCallBack);
    }

    $('#odvModalBrowseMulti').modal('hide');
    $('.modal-backdrop').remove();
    $('body').removeClass( "modal-open" );
}

// Function: ฟังก์ชั่น Loop Set Data Select Input
// Parameters: Data Option Browse
// Creator: 17/12/2019 Wasin (Yoshi)
// Return: Set Data To Input Modal Hidden
// ReturnType: None
function JCNxLoopSetInputDataValueAndText(){
    let tTextDataValue  = '';
    let tTextDataText   = '';
    let nCountLoopSlt   = 0
    $('#otbMultiBrowseDataTable .xWMultiDataItems').each(function(){
        let nStaChkInputSlt = ($(this).find('.xWMultiSelectItems').is(":checked"))? 1 : 0 ;
        if(nStaChkInputSlt == 1){
            tTextDataValue  += $(this).data('code')+',';
            tTextDataText   += $(this).data('name')+',';
            nCountLoopSlt ++;
        }
    });
    tTextDataValue  = tTextDataValue.substring(0,tTextDataValue.length - 1);
    tTextDataText   = tTextDataText.substring(0,tTextDataText.length - 1);
    $('#ohdMultiBrowseCallBackValue').val(tTextDataValue);
    $('#ohdMultiBrowseCallBackText').val(tTextDataText);
}