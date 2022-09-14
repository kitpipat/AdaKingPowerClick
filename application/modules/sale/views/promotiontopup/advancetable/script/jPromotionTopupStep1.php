<script>

    $(document).ready(function(){
        JSxPTUPageStep1DataTable();
    });

    // แสดงรายการ ประเภทบัตร
    // Create By : Napat(Jame) 22/09/2020
    function JSxPTUPageStep1DataTable(){
        $.ajax({
            type: "POST",
            url: "docPTUPageStep1DataTable",
            data: {
                'tDocNo'    : $('#oetPTUDocNo').val(),
                'tBchCode'  : $('#oetPTUBchCode').val()
            },
            cache: false,
            timeout: 0,
            success: function(tResult) {
                $('#odvPTUDataTableStep1').html(tResult);
                JCNxCloseLoading();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
                JCNxCloseLoading();
            }
        });
    }

    // ลบรายการ ประเภทบัตร
    // Create By : Napat(Jame) 22/09/2020
    function JSxPTUEventStep1Delete(poObj){
        JCNxOpenLoading();
        $.ajax({
            type: "POST",
            url: "docPTUEventStepDelete",
            data: {
                'tDocNo'    : $('#oetPTUDocNo').val(),
                'tBchCode'  : $('#oetPTUBchCode').val(),
                'nSeq'      : $(poObj).parent().parent().attr('data-seq'),
                'tDocKey'   : 'TFNTCrdPmtDT'
            },
            cache: false,
            timeout: 0,
            success: function(oResult) {
                var aResult = $.parseJSON(oResult);
                if( aResult['tCode'] == '1' ){
                    JSxPTUPageStep1DataTable();
                }else{
                    alert(aResult['tDesc']);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
                JCNxCloseLoading();
            }
        });
    }

    // Create By : Napat(Jame) 23/09/2020
    function JSxPTUEventStep1Edit(poObj){
        var tCtyCode = $(poObj).parent().parent().attr('data-ctycode');
        var tCtyName = $(poObj).parent().parent().attr('data-ctyname');
        var tStaType = $(poObj).parent().parent().attr('data-statype');
        
        $('#oetPTUAddCtyCode').val(tCtyCode);
        $('#oetPTUAddCtyName').val(tCtyName);
        $('#ocmPTUAddPmdStaType').selectpicker('val', tStaType);

        $('#odvPTUAddCardTypeModal').modal('show');
    }

    // Create By : Napat(Jame) 22/09/2020
    function JSxPTUStep1AddEditCardType(){
        var tCtyCode = $('#oetPTUAddCtyCode').val();
        if( tCtyCode != '' ){
            $('#oetPTUAddCtyName').closest('.form-group').removeClass( "has-error" );
            $('#odvPTUAddCardTypeModal').modal('hide');
            JCNxOpenLoading();
            $.ajax({
                type: "POST",
                url: "docPTUEventStep1AddEditCardType",
                data: {
                    'tDocNo'    : $('#oetPTUDocNo').val(),
                    'tBchCode'  : $('#oetPTUBchCode').val(),
                    'tCtyCode'  : $('#oetPTUAddCtyCode').val(),
                    'tStaType'  : $('#ocmPTUAddPmdStaType').val()
                },
                cache: false,
                timeout: 0,
                success: function(oResult) {
                    var aResult = $.parseJSON(oResult);
                    if( aResult['tCode'] == '1' ){
                        JSxPTUPageStep1DataTable();
                    }else{
                        alert(aResult['tDesc']);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                    JCNxCloseLoading();
                }
            });
        }else{
            $('#oetPTUAddCtyName').closest('.form-group').addClass( "has-error" ).removeClass( "has-success" );
        }

    }

    // ลบรายการ ประเภทบัตร
    // Create By : Napat(Jame) 22/09/2020
    $('#obtPTUBrowseCardType').off('click');
    $('#obtPTUBrowseCardType').on('click',function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JCNxBrowseData('oOptionBrowsCardType');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    var tSesSessionID = '<?php echo $this->session->userdata("tSesSessionID"); ?>';
    var tSesUsrLevel  = '<?=$this->session->userdata("tSesUsrLevel")?>';
    var tAgnCode      = '<?=$this->session->userdata("tSesUsrAgnCode")?>';
    var tWhereSQL     = "";

    if( tSesUsrLevel != "HQ" && tAgnCode != "" ){
        tWhereSQL += " AND FTAgnCode = '"+tAgnCode+"' ";
    }

    var oOptionBrowsCardType  = {
        Title : ['payment/cardtype/cardtype', 'tCTYTitle'],
        Table:{Master:'TFNMCardType', PK:'FTCtyCode'},
        Join :{
            Table: ['TFNMCardType_L','TCNTCrdPmtTmp'],
            On: [
                'TFNMCardType_L.FTCtyCode = TFNMCardType.FTCtyCode AND TFNMCardType_L.FNLngID = ' + nLangEdit,
                "TCNTCrdPmtTmp.FTCtyCode = TFNMCardType.FTCtyCode AND TCNTCrdPmtTmp.FTPmhDocNo = 'PTUTEMP' AND TCNTCrdPmtTmp.FTDocKey = 'TFNTCrdPmtDT' AND TCNTCrdPmtTmp.FTSessionID = '" + tSesSessionID + "' "
            ]
        },
        Where:{
            Condition: [ " AND TCNTCrdPmtTmp.FTCtyCode IS NULL " + tWhereSQL ]
        },
        GrideView:{
            ColumnPathLang	: 'payment/cardtype/cardtype',
            ColumnKeyLang	: ['tCTYCode', 'tCTYName'],
            ColumnsSize     : ['15%', '85%'],
            WidthModal      : 20,
            DataColumns		: ['TFNMCardType.FTCtyCode', 'TFNMCardType_L.FTCtyName'],
            DisabledColumns	:[],
            DataColumnsFormat : ['', ''],
            Perpage			: 10,
            OrderBy			: ['TFNMCardType.FDCreateOn DESC']
            // SourceOrder		: "DESC"
        },
        CallBack:{
            ReturnType	: 'S',
            Value		: ["oetPTUAddCtyCode", "TFNMCardType.FTCtyCode"],
            Text		: ["oetPTUAddCtyName", "TFNMCardType_L.FTCtyName"]
        },
        // DebugSQL : true,
        RouteAddNew : 'cardtype',
        BrowseLev : 2
    }

    // Create By : Napat(Jame) 23/09/2020
    $('#obtPTUStep1AddCardType').off('click');
    $('#obtPTUStep1AddCardType').on('click',function(){
        $('#oetPTUAddCtyCode').val('');
        $('#oetPTUAddCtyName').val('');
        $("#ocmPTUAddPmdStaType").prop("selectedIndex", 0);
        $("#ocmPTUAddPmdStaType").selectpicker("refresh");

        $('#odvPTUAddCardTypeModal').modal('show');
    });

    /*
    function : ตรวจสอบข้อมูลก่อน Next Step
    Parameters : -
    Creator : 23/09/2020 Napat(Jame)
    Return : Status
    Return Type : boolean
    */
    function JCNbPTUStep1IsValid() {
        var bStatus = false;
        var nStep1NumRow = $('#oetPTUStep1NumRow').val();
        if(nStep1NumRow > 0){
            bStatus = true;
        }
        return bStatus;
    }

</script>