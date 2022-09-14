<script type="text/javascript">
    var nLangEdits      = '<?php echo $this->session->userdata("tLangEdit");?>';

    // Option Browse กลุ่มบริษัทขนส่ง
    var oCmpBrowseGroup = {
        Title : ['courier/courier/courier','tCRYGroupTitle'],
        Table:{Master:'TCNMCourierGrp',PK:'FTCgpCode'},
        Join :{
            Table:	['TCNMCourierGrp_L'],
            On:['TCNMCourierGrp_L.FTCgpCode = TCNMCourierGrp.FTCgpCode AND TCNMCourierGrp_L.FNLngID = '+nLangEdits,]
        },
        GrideView:{
            ColumnPathLang	: 'courier/courier/courier',
            ColumnKeyLang	: ['tCRYGroupCode','tCRYGroupName'],
            ColumnsSize     : ['10%','75%'],
            DataColumns		: ['TCNMCourierGrp.FTCgpCode','TCNMCourierGrp_L.FTCgpName'],
            DataColumnsFormat : ['',''],
            WidthModal      : 50,
            Perpage			: 10,
            OrderBy			: ['TCNMCourierGrp.FTCgpCode'],
            SourceOrder		: "ASC"
        },
        CallBack:{
            ReturnType	: 'S',
            Value       : ["oetCryCgpCode","TCNMCourierGrp.FTCgpCode"],
            Text		: ["oetCryCgpName","TCNMCourierGrp_L.FTCgpName"],
        },
    }

    // Option Browse ประเภทบริษัทขนส่ง
    var oCmpBrowseType  = {
        Title : ['courier/courier/courier','tCRYTypeTitle'],
        Table:{Master:'TCNMCourierType',PK:'FTCtyCode'},
        Join :{
            Table:	['TCNMCourierType_L'],
            On:['TCNMCourierType_L.FTCtyCode = TCNMCourierType.FTCtyCode AND TCNMCourierType_L.FNLngID = '+nLangEdits,]
        },
        GrideView:{
            ColumnPathLang	: 'courier/courier/courier',
            ColumnKeyLang	: ['tCRYTypeCode','tCRYTypeName'],
            ColumnsSize     : ['10%','75%'],
            DataColumns		: ['TCNMCourierType.FTCtyCode','TCNMCourierType_L.FTCtyName'],
            DataColumnsFormat : ['',''],
            WidthModal      : 50,
            Perpage			: 10,
            OrderBy			: ['TCNMCourierType.FTCtyCode'],
            SourceOrder		: "ASC"
        },
        CallBack:{
            ReturnType	: 'S',
            Value       : ["oetCtyCode","TCNMCourierType.FTCtyCode"],
            Text		: ["oetCtyName","TCNMCourierType_L.FTCtyName"],
        },
    }

    $('document').ready(function(){
        $('.selectpicker').selectpicker('refresh');
        $('.xCNDatePicker').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true,
        });

        $('#obtCryDob').unbind().click(function(){
            $('.xCNDatePicker').datepicker('show');
        });

        $('#ocbCryStaAutoGenCode').unbind().click(function(){
            if($('#ocbCryStaAutoGenCode').prop('checked') == true){
                $('#oetCryCode').attr('readonly',true).val('');
            }else{
                $('#oetCryCode').attr('readonly',false).val('');
            }
        });

        $('#btnBrowseGroup').unbind().click(function(){
            JSxCheckPinMenuClose(); // Hidden Pin Menu
            JCNxBrowseData('oCmpBrowseGroup');
        });

        $('#btnBrowseType').unbind().click(function(){
            JSxCheckPinMenuClose(); // Hidden Pin Menu
            JCNxBrowseData('oCmpBrowseType');
        });

        // Event Click Tab
        $('#odvCourierPanelBody .xCNCryTab').unbind().click(function(){
            let tCryRoute   = '<?php echo @$tRoute;?>';
            if(tCryRoute == 'courierEventAdd'){
                return;
            }else{
                let tTypeTab    = $(this).data('typetab');
                if(typeof(tTypeTab) !== undefined && tTypeTab == 'main'){
                    JCNxOpenLoading();
                    setTimeout(function(){
                        $('#odvBtnAddEdit').show();
                        JCNxCloseLoading();
                        return;
                    },500);
                }else if(typeof(tTypeTab) !== undefined && tTypeTab == 'sub'){
                    $('#odvBtnAddEdit').hide();
                    let tTabTitle   = $(this).data('tabtitle');
                    switch(tTabTitle){
                        case 'cryaddress':
                            JSxGetCourierContentAddress();
                        break;
                    }
                }else{
                    return;
                }
            }
        });
        if($("#ocmCryBchHQ").val() == '2'){
            $('.xWCryBchControl').removeClass('xCNHide');
        }else{
            $('.xWCryBchControl').addClass('xCNHide');
        }
    });

    // Function: Event Call Courier Address
    // Parameters : Event Click Tab
    // Creator : 12/09/2019 wasin(Yoshi)
    // Return : -
    // Return Type : -
    function JSxGetCourierContentAddress(){
        let tCryCode    = '<?php echo @$tCryCode;?>';
        let tCryName    = '<?php echo @$tCryName;?>';
        let nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JCNxOpenLoading();
            $.ajax({
                type : "POST",
                url : "courierAddressData",
                data : {
                    'ptCryCode' : tCryCode,
                    'ptCryName' : tCryName,
                },
                success	: function(tResult){
                    $('#odvCRYAddressData').html(tResult);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }else{
            JCNxShowMsgSessionExpired();
        }
    }
</script>
