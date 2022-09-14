<script type="text/javascript">

    var nStaDrugBrowseType   = $('#oetDrugStaBrowse').val();
    var tCallPunBackOption   = $('#oetDrugCallBackOption').val();

    var nLangEdits  = '<?php echo $this->session->userdata("tLangEdit");?>';

    // Event Browse หน่วย
    $('#oimBrowseDepart').click(function(){
            JSxCheckPinMenuClose();
        JCNxBrowseData('oBrowseDepart');
    });


    // Event Click Cancel
    $('#obtPdtCancel').click(function(){
        JSvCallPageProductList();
    });



    // Option Unit หน่วย
    var oBrowseDepart = {
        Title : ['product/pdtunit/pdtunit','tPUNTitle'],
        Table:{Master:'TCNMPdtUnit',PK:'FTPunCode'},
        Join :{
            Table:	['TCNMPdtUnit_L'],
            On:['TCNMPdtUnit_L.FTPunCode = TCNMPdtUnit.FTPunCode AND TCNMPdtUnit_L.FNLngID = '+nLangEdits]
        },
        GrideView:{
            ColumnPathLang	: 'product/pdtunit/pdtunit',
            ColumnKeyLang	: ['tPUNFrmPunCode','tPUNFrmPunName'],
            DataColumns		: ['TCNMPdtUnit.FTPunCode','TCNMPdtUnit_L.FTPunName'],
            ColumnsSize     : ['10%','75%'],
            DataColumnsFormat : ['',''],
            WidthModal      : 50,
            Perpage			: 10,
            OrderBy			: ['TCNMPdtUnit.FTPunCode'],
            SourceOrder		: "ASC"
        },
        CallBack:{
            ReturnType	: 'S',
            Value		: ["oetPdtVolumName","TCNMPdtUnit.FTPunCode"],
            Text		: ["oetPdtVolumName","TCNMPdtUnit_L.FTPunName"]
        },
       
        RouteAddNew : 'pdtunit',
        BrowseLev : nStaDrugBrowseType,
    };

</script>


