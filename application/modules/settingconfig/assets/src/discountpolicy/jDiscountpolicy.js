var  nDispocilyBrowseType   = $('#oetDpcDisStaBrowseType').val();
var  tDispocilyBrowseOption = $('#oetDpcDisCallBackOption').val();

$("document").ready(function () {
    localStorage.removeItem("LocalItemData");
    JSxCheckPinMenuClose(); 
    JSvDpcDisCallPageList();
});

// Function : Call Page List
// Create By WItsarut 17/07/2020
function JSvDpcDisCallPageList(){
    JCNxOpenLoading();
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof(nStaSession) != 'undefined' && nStaSession == 1){
        try{
            localStorage.removeItem('LocalItemData');
            $.ajax({
                type   : "POST",
                url    : "discountpolicyList",
                data   : {},
                cache  : false,
                timeout : 5000,  
                success : function(tResult){
                    $('#odvContentPageDiscountpolicy').html(tResult);
                    JSvDpcDisDataTable();
                    JCNxCloseLoading();
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }catch(err){
            console.log('JSvDpcDisCallPageList Error', err);
        } 
    }else{
        JCNxShowMsgSessionExpired();
    }
}

//function: Call Product DiscountPolicy Data List
function JSvDpcDisDataTable(){
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
        try{
            var tSearchAll   =  $('#oetSearchDpcDis').val();
     
            $.ajax({
                type : "POST",
                url  : "discountpolicyLoadTable",
                data : { tSearchAll : tSearchAll },
                cache : false,
                timeout :0,
                success: function(tResult){
                    $('#odvContentDpcDisTable').html(tResult)
                    JCNxCloseLoading();
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }catch(err){
            console.log('JSvDpcDisCallPageList Error', err);
        }
    }else{
        JCNxShowMsgSessionExpired();
    }

}

//function Save Data Discount Policy
// Create By Witsarut 20/07/2020
function JSxDpcDisSave(){
    JCNxOpenLoading();

    var aData = $('#ofmAddEditPDCDis').serializeArray();
    var aPackData = [];
    var aResult =[];

    for(var i=0; i<aData.length;i++){
        var aDataName   = aData[i]['name'];
        var tValue      = aData[i]['value'];

        var aDataName = aData[i]['name'].split("_");
        var tCodeX = aDataName[1];
        var tCodeY = aDataName[2];
        
        aResult = [tCodeX,tCodeY,tValue];
        aPackData.push(aResult);
    }
    
  
    var nStaSession  = JCNxFuncChkSessionExpired();

    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
        $.ajax({
            type  : "POST",
            url   : "discountpolicySaveData",
            data  : {
                data: aPackData
            },
            cache:false,
            timeout : 0,
            success: function(tResult){
                console.log(tResult);
                JSvDpcDisCallPageList();
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