<script type="text/javascript">
    $('#oimSearchAPI').click(function(){
        JCNxOpenLoading();
		JSvConnsetGenListAPI();
	});

	$('#oetSearchAPI').keypress(function(event){
		if(event.keyCode == 13){
			JCNxOpenLoading();
			JSvConnsetGenListAPI();
		}
    });
    


    // function Call SearchAPI
    function JSvConnsetGenListAPI(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            var tSearchApi      = $('#oetSearchAPI').val();
            var tStaApiTxnType  = $('#oetAPIStaApiTxnType').val();
            JCNxOpenLoading();
            $.ajax({
                type : "POST",
                url  : "connsetGenDataTable",
                data : {
                    tSearchApi      : tSearchApi,
                    tStaApiTxnType  : tStaApiTxnType
                },
                cache : false,
                Timeout : 0,
                async   : false,
                success : function(tResult){
                    $('#odvContentConnSetGenDataTable').html(tResult);
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


    var nLangEdits = <?=$this->session->userdata("tLangEdit")?>;

      //BrowseAgn 
      $('.oimBrowseApiFormat').click(function(e){
        e.preventDefault();
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSxCheckPinMenuClose();
           var tApiCode = $(this).attr('apicode');
            window.oPdtBrowseFmtCode = oBrowsefmtCode({
                'tReturnInputCode'  : 'oetApiFmtCode'+tApiCode,
                'tReturnInputName'  : 'oetApiFmtName'+tApiCode,
            });
            JCNxBrowseData('oPdtBrowseFmtCode');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });


    var oBrowsefmtCode = function(poReturnInput){
        var tInputReturnCode    = poReturnInput.tReturnInputCode;
        var tInputReturnName    = poReturnInput.tReturnInputName;


        var oOptionReturn       = {
            Title : ['interface/conSettingGenaral/consettinggenaral', 'tGenaralApiFormat'],
            Table:{Master:'TSysFormatAPI_L', PK:'FTApiFmtCode'},
       
            GrideView:{
                ColumnPathLang	: 'interface/conSettingGenaral/consettinggenaral',
                ColumnKeyLang	: ['tGenaralApiFormatCode', 'tGenaralApiFormatName'],
                ColumnsSize     : ['15%', '85%'],
                WidthModal      : 50,
                DataColumns		: ['TSysFormatAPI_L.FTApiFmtCode', 'TSysFormatAPI_L.FTApiFmtName'],
                DataColumnsFormat : ['', ''],
                Perpage			: 10,
                OrderBy			: ['TSysFormatAPI_L.FTApiFmtCode DESC'],
            },
            CallBack:{
                ReturnType	: 'S',
                Value		: [tInputReturnCode,"TSysFormatAPI_L.FTApiFmtCode"],
                Text		: [tInputReturnName,"TSysFormatAPI_L.FTApiFmtName"],
            },
            BrowseLev : 1,
        }
        return oOptionReturn;
    }

  

   

</script>