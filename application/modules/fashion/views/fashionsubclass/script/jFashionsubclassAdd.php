<script type="text/javascript">

    $(document).ready(function() {
        $('#ocbSCLAutoGenCode').change(function() {
            if ($('#ocbSCLAutoGenCode').is(':checked')) {
                $('#oetSclCode').val('');
                $("#oetSclCode").attr("readonly", true);
            } else {
                $("#oetSclCode").attr("readonly", false);
            }
        });

        var tRoute = '<?php echo $tSCLRoute ?>';
        if( tRoute != 'masSCLEventAdd' ){
            $('#odvSCLAutoGenCode').hide();
        }

        var tSesUsrLevel = '<?php echo $this->session->userdata("tSesUsrLevel");?>';
        if( tSesUsrLevel != "HQ" ){
            $('#obtSCLBrowseAgn').attr('disabled',true);
        }

    });

    //Browse Agency
    $('#obtSCLBrowseAgn').click(function(e){
        e.preventDefault();
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSxCheckPinMenuClose();
            window.oBrowseAgencyOption = oSCLBrowseAgn({
                'tReturnInputCode'  : 'oetSclAgnCode',
                'tReturnInputName'  : 'oetSclAgnName',
            });
            JCNxBrowseData('oBrowseAgencyOption');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    var nLangEdits  = <?php echo $this->session->userdata("tLangEdit")?>;

    //Option Agn
    var oSCLBrowseAgn =   function(poReturnInput){
        var tInputReturnCode    = poReturnInput.tReturnInputCode;
        var tInputReturnName    = poReturnInput.tReturnInputName;

        var oOptionReturn       = {
            Title : ['ticket/agency/agency', 'tAggTitle'],
            Table:{Master:'TCNMAgency', PK:'FTAgnCode'},
            Join :{
            Table: ['TCNMAgency_L'],
                On: ['TCNMAgency_L.FTAgnCode = TCNMAgency.FTAgnCode AND TCNMAgency_L.FNLngID = '+nLangEdits]
            },
            GrideView:{
                ColumnPathLang	: 'ticket/agency/agency',
                ColumnKeyLang	: ['tAggCode', 'tAggName'],
                ColumnsSize     : ['15%', '85%'],
                WidthModal      : 50,
                DataColumns		: ['TCNMAgency.FTAgnCode', 'TCNMAgency_L.FTAgnName'],
                DataColumnsFormat : ['', ''],
                Perpage			: 10,
                OrderBy			: ['TCNMAgency.FDCreateOn DESC'],
            },
            CallBack:{
                ReturnType	: 'S',
                Value		: [tInputReturnCode,"TCNMAgency.FTAgnCode"],
                Text		: [tInputReturnName,"TCNMAgency_L.FTAgnName"],
            },
            RouteAddNew : 'agency',
            BrowseLev : 1,
        }
        return oOptionReturn;
    }

</script>