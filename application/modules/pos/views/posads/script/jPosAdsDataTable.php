<script type="text/javascript">

    $('.selectpicker').selectpicker();
    $('.xWPosAdsEdit').click(function(){JSxClickEventEditInlineData(this);});
    $('.xWPosAdsSave').click(function(){JSxClickEventSaveInlineData(this);});
    $('.xWPosAdsCancel').click(function(){JSxClickEventCancleInlineData(this);});
    $('#obtBrowseAdvertise').click(function(){
        // Create By Witsarut 04/10/2019
            JSxCheckPinMenuClose();
        // Create By Witsarut 04/10/2019
        JCNxBrowseData('oBrowseAdvertise');
    });

    // PosAds VD
    $('.xWPosAdsPosVDInLine').click(function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            var tPosAdsPosVDCode = $(this).parents('.xWPosAdsDataSource').find('.xWPosAdsPosVD input[type=hidden]').attr('id');
            var tPosAdsPosVDName = $(this).parents('.xWPosAdsDataSource').find('.xWPosAdsPosVD input[type=text]').attr('id');
            window.oBrowsePosVDOption = oBrowsePosVD({
                'tReturnInputPosVDCode'  : tPosAdsPosVDCode,
                'tReturnInputPosVDName'  : tPosAdsPosVDName
            });
            JCNxBrowseData('oBrowsePosVDOption');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });


    var oBrowsePosVD    = function(poReturnInput){
        var tReturnInputPosVDCode    = poReturnInput.tReturnInputPosVDCode;
        var tInputReturnPosVDName    = poReturnInput.tReturnInputPosVDName;
        var oOptionReturn            = {
            Title : ['pos/posads/posads','tBrowsePosAdsTitle'],
            Table : {Master:'TCNMAdMsg' ,PK:'FTAdvCode'},
            Join :{
                Table: ['TCNMAdMsg_L'],
                On:['TCNMAdMsg_L.FTAdvCode = TCNMAdMsg.FTAdvCode  AND TCNMAdMsg_L.FNLngID = '+nLangEdits,]
            },
            GrideView:{
                ColumnPathLang  : 'pos/posads/posads',
                ColumnKeyLang   : ['tBrowseADVCode','tBrowseADVName'],
                ColumnsSize     : ['10%','75%'],
                WidthModal      : 50,
                DataColumns		: ['TCNMAdMsg.FTAdvCode','TCNMAdMsg_L.FTAdvName'],
                DataColumnsFormat : ['',''],
                Perpage			: 5,
                OrderBy			: ['TCNMAdMsg.FTAdvCode'],
                SourceOrder		: "ASC"
            },
            CallBack:{
                
                ReturnType	: 'S',
                Value		: [tReturnInputPosVDCode,"TCNMAdMsg.FTAdvCode"],
                Text		: [tInputReturnPosVDName,"TCNMAdMsg_L.FTAdvName"],
            }
        }
        return oOptionReturn;
    }


     // tBAdsAdvertise (โฆษณา)
     var oBrowseAdvertise = {
        Title : ['pos/posads/posads','tBrowsePosAdsTitle'],
        Table : {Master:'TCNMAdMsg' ,PK:'FTAdvCode',PKName:'FTAdvName'},
        Join :{
            Table: ['TCNMAdMsg_L'],
            On:['TCNMAdMsg_L.FTAdvCode = TCNMAdMsg.FTAdvCode  AND TCNMAdMsg_L.FNLngID = '+nLangEdits,]
        },
        GrideView:{
            ColumnPathLang  : 'pos/posads/posads',
            ColumnKeyLang   : ['tBrowseADVCode','tBrowseADVName'],
            ColumnsSize     : ['10%','75%'],
            WidthModal      : 50,
            DataColumns     : ['TCNMAdMsg.FTAdvCode','TCNMAdMsg_L.FTAdvName','TCNMAdMsg.FDAdvStart','TCNMAdMsg.FDAdvStop'],
            DisabledColumns : [2,3],
            DataColumnsFormat : ['',''],
            Perpage			: 10,
            OrderBy			: ['TCNMAdMsg.FDCreateOn DESC'],

        },
        CallBack:{
            StaSingItem : '1',
            ReturnType  : 'S',
            Value       : ["oetPosAdvertiseCode","TCNMAdMsg.FTAdvCode"],
            Text        : ["oetPosAdvertiseName","TCNMAdMsg_L.FTAdvName"],
        },
        RouteAddNew : 'adMessage',
        BrowseLev : nStaAdsBrowseType,
        NextFunc:{
            FuncName:'JSxGetDateStartFormPosAds',
            ArgReturn:['FDAdvStart','FDAdvStop']
        },
    }

    //เพิ่มข้อมูลวันที่เริ่ม สิ้นสุด page PosAdsAdd
    function JSxGetDateStartFormPosAds(ptData){
        var aReturn = JSON.parse(ptData);
       if(aReturn[0] != "" && aReturn[0] != null){
            $('#ohdAdsStart').val(aReturn[0]);  
       }
       if(aReturn[1] != "" && aReturn[1] != null ){
            $('#ohdAdsStop').val(aReturn[1]);  
       }
    }

    // Edit
    function JSxClickEventEditInlineData(oEvent){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            var tRecordId           = $(oEvent).parents('.xWPosAdsDataSource').attr('id');
            var oPosAdsDataLocal    = {
                'tPosAdsPosVDCode'  : $(oEvent).parents('.xWPosAdsDataSource').find('.xWPosAdsPosVD input[type=hidden]').val(),
                'tPosAdsPosVDName'  : $(oEvent).parents('.xWPosAdsDataSource').find('.xWPosAdsPosVD input[type=text]').val(),
            };

            // Backup Record
            localStorage.setItem(tRecordId,JSON.stringify(oPosAdsDataLocal));

            // Visibled icons
            $(oEvent).parents('.xWPosAdsDataSource').find('.xWPosAdsEdit').addClass('hidden');
            $(oEvent).parents('.xWPosAdsDataSource').find('.xWPosAdsSave ').removeClass('hidden');
            $(oEvent).parents('.xWPosAdsDataSource').find('.xWPosAdsCancel').removeClass('hidden');

            // Remove Disable
            $(oEvent).parents('.xWPosAdsDataSource').find('.xWPosAdsPosVD input[type=text]').prop("disabled",false).css('cursor','pointer');
            

            var tPosAdsPositionSlt  = $(oEvent).parents('.xWPosAdsDataSource').find('.xWPosAdsPosition input[type=hidden]').val();
            var tPosAdsWidthSlt     = $(oEvent).parents('.xWPosAdsDataSource').find('.xWPosAdsWidth input[type=hidden]').val();
            var tPosAdsHeighSlt     = $(oEvent).parents('.xWPosAdsDataSource').find('.xWPosAdsHigth input[type=hidden]').val();

            $(oEvent).parents('.xWPosAdsDataSource').find('.xWPosAdsPosition .selectpicker').val(tPosAdsPositionSlt);
            $(oEvent).parents('.xWPosAdsDataSource').find('.xWPosAdsWidth .selectpicker').val(tPosAdsWidthSlt);
            $(oEvent).parents('.xWPosAdsDataSource').find('.xWPosAdsHigth .selectpicker').val(tPosAdsHeighSlt);

            $(oEvent).parents('.xWPosAdsDataSource').find('.xWPosAdsPosition .selectpicker').prop("disabled",false).css('cursor','pointer');
            $(oEvent).parents('.xWPosAdsDataSource').find('.xWPosAdsPosition .selectpicker').selectpicker('refresh');

            $(oEvent).parents('.xWPosAdsDataSource').find('.xWPosAdsWidth .selectpicker').prop("disabled",false).css('cursor','pointer');
            $(oEvent).parents('.xWPosAdsDataSource').find('.xWPosAdsWidth .selectpicker').selectpicker('refresh');

            $(oEvent).parents('.xWPosAdsDataSource').find('.xWPosAdsHigth .selectpicker').prop("disabled",false).css('cursor','pointer');
            $(oEvent).parents('.xWPosAdsDataSource').find('.xWPosAdsHigth .selectpicker').selectpicker('refresh');

            $.getScript("application/modules/common/assets/vendor/bootstrap-select-1.13.2/dist/css/bootstrap-select.min.css");
            $.getScript("application/modules/common/assets/vendor/bootstrap-select-1.13.2/dist/js/bootstrap-select.min.js");

        }else{
            JCNxShowMsgSessionExpired();
        }
    }
    // Save
    function JSxClickEventSaveInlineData(oEvent){

        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            var tSaveId           = $(oEvent).parents('.xWPosAdsDataSource').attr('id');
            var oPosAdsData    = {
                'tPosAdsPosBchCode'  : $(oEvent).parents('.xWPosAdsDataSource').find('.xWPosAdsPosBch input[type=hidden]').val(),
                'tPosAdsPosShpCode'  : $(oEvent).parents('.xWPosAdsDataSource').find('.xWPosAdsPosShp input[type=hidden]').val(),
                'tPosAdsPosCode'     : $(oEvent).parents('.xWPosAdsDataSource').find('.xWPosAdsPos input[type=hidden]').val(),
                'tPosAdsPosSeq'     : $(oEvent).parents('.xWPosAdsDataSource').find('.xWPosAdsPosSeq input[type=hidden]').val(),
                'tPosAdsPosVDCode'   : $(oEvent).parents('.xWPosAdsDataSource').find('.xWPosAdsPosVD input[type=hidden]').val(),
                'tPosAdsPositionSlt' : $(oEvent).parents('.xWPosAdsDataSource').find('.xWPosAdsPosition .selectpicker').val(),
                'tPosAdsWidthSlt'    : $(oEvent).parents('.xWPosAdsDataSource').find('.xWPosAdsWidth .selectpicker').val(),
                'tPosAdsHeighSlt'    : $(oEvent).parents('.xWPosAdsDataSource').find('.xWPosAdsHigth .selectpicker').val(),
            };
        

        
            // Update Data Posads
            JSxPosAdsUpdateInline(oPosAdsData);
           
                
            // Remove Seft Record Backup
            localStorage.removeItem(tSaveId);
                
            // Visibled icons
            $(oEvent).parents('.xWPosAdsDataSource').find('.xWPosAdsEdit').removeClass('hidden');
            $(oEvent).parents('.xWPosAdsDataSource').find('.xWPosAdsSave ').addClass('hidden');
            $(oEvent).parents('.xWPosAdsDataSource').find('.xWPosAdsCancel').addClass('hidden');

            // Add Disable
            $(oEvent).parents('.xWPosAdsDataSource').find('.xWPosAdsPosVD input[type=text]').prop("disabled",true).removeAttr('style');
            $(oEvent).parents('.xWPosAdsDataSource').find('.xWPosAdsPosition .selectpicker').prop("disabled",true).removeAttr('style');
            $(oEvent).parents('.xWPosAdsDataSource').find('.xWPosAdsPosition .selectpicker').selectpicker('refresh');
            $(oEvent).parents('.xWPosAdsDataSource').find('.xWPosAdsWidth .selectpicker').prop("disabled",true).removeAttr('style');
            $(oEvent).parents('.xWPosAdsDataSource').find('.xWPosAdsWidth .selectpicker').selectpicker('refresh');
            $(oEvent).parents('.xWPosAdsDataSource').find('.xWPosAdsHigth .selectpicker').prop("disabled",true).removeAttr('style');
            $(oEvent).parents('.xWPosAdsDataSource').find('.xWPosAdsHigth .selectpicker').selectpicker('refresh');

        }else{
            JCNxShowMsgSessionExpired();
        }

    }
    // Cancel
    function JSxClickEventCancleInlineData(oEvent){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            var tRecordId       = $(oEvent).parents('.xWPosAdsDataSource').attr('id');

            // Restore Seft Record
            var oBackupRecord   = JSON.parse(localStorage.getItem(tRecordId));

            $(oEvent).parents('.xWPosAdsDataSource').find('.xWPosAdsPosVD input[type=hidden]').val(oBackupRecord['tPosAdsPosVDCode']);
            $(oEvent).parents('.xWPosAdsDataSource').find('.xWPosAdsPosVD input[type=text]').val(oBackupRecord['tPosAdsPosVDName']);

            // Remove Seft Record Backup
            localStorage.removeItem(tRecordId);
            
            // Visibled icons
            $(oEvent).parents('.xWPosAdsDataSource').find('.xWPosAdsEdit').removeClass('hidden');
            $(oEvent).parents('.xWPosAdsDataSource').find('.xWPosAdsSave ').addClass('hidden');
            $(oEvent).parents('.xWPosAdsDataSource').find('.xWPosAdsCancel').addClass('hidden');

            // Add Disable

            $(oEvent).parents('.xWPosAdsDataSource').find('.xWPosAdsPosVD input[type=text]').prop("disabled",true).removeAttr('style');
            $(oEvent).parents('.xWPosAdsDataSource').find('.xWPosAdsPosition .selectpicker').prop("disabled",true).removeAttr('style');
            $(oEvent).parents('.xWPosAdsDataSource').find('.xWPosAdsPosition .selectpicker').selectpicker('refresh');
            $(oEvent).parents('.xWPosAdsDataSource').find('.xWPosAdsWidth .selectpicker').prop("disabled",true).removeAttr('style');
            $(oEvent).parents('.xWPosAdsDataSource').find('.xWPosAdsWidth .selectpicker').selectpicker('refresh');
            $(oEvent).parents('.xWPosAdsDataSource').find('.xWPosAdsHigth .selectpicker').prop("disabled",true).removeAttr('style');
            $(oEvent).parents('.xWPosAdsDataSource').find('.xWPosAdsHigth .selectpicker').selectpicker('refresh');


            $.getScript("application/modules/common/assets/vendor/bootstrap-select-1.13.2/dist/css/bootstrap-select.min.css");
            $.getScript("application/modules/common/assets/vendor/bootstrap-select-1.13.2/dist/js/bootstrap-select.min.js");

        }else{
            JCNxShowMsgSessionExpired();
        }
    }


    function JSxPosAdsUpdateInline(ptPosAdsData){ 
        $.ajax({
            type: "POST",
            url: "posAdsEventEdit",
            data: { tPosAdsData: ptPosAdsData },
            cache: false,
            timeout: 0,
            success: function(tResult){
                if(tResult != ''){
                    $('#oliAdsTitleAdd').hide();
                    $('#oliAdsTitleEdit').show();
                    $('#odvBtnAdsInfo').hide();
                    $('#odvBtnAddEdit').show();
                    $('#odvContentPagePosAds').html(tResult);
                    $('#oetAdsCode').addClass('xCNDisable');
                    $('#oetAdsCode').attr('readonly', true);
                    $('.xCNBtnGenCode').attr('disabled', true);
                }
                JCNxLayoutControll();
                JCNxCloseLoading();
                JSvCallPagePosAdsList();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }

</script>