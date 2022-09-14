<script type="text/javascript">
    var nChqLangEdits    = '<?php echo $this->session->userdata("tLangEdit");?>';
    var tChqBchCode      =  $('#ohdChqBchCode').val();
    var tChqShpCode      =  $('#ohdChqShpCode').val();

    // ตรวจสอบระดับของ User  07/02/2020 Saharat(Golf)
    var tStaUsrLevel    = '<?php  echo $this->session->userdata("tSesUsrLevel"); ?>';
    var tUsrBchCode     = '<?php  echo $this->session->userdata("tSesUsrBchCode"); ?>';
    var tUsrBchName     = '<?php  echo $this->session->userdata("tSesUsrBchName"); ?>';
    var tUsrShpCode     = '<?php  echo $this->session->userdata("tSesUsrShpCode"); ?>';
    var tUsrShpName     = '<?php  echo $this->session->userdata("tSesUsrShpName"); ?>';

    $( document ).ready(function() {

      // ตรวจสอบระดับUser banch  07/02/2020 Saharat(Golf)
      if(tUsrBchCode  != ""){ 
            $('#oetBchCode').val(tUsrBchCode);
            $('#oetBchName').val(tUsrBchName);
            $('#obtBrowseBranch').attr("disabled", true);
            // $('#obtBrowseShop').prop("disabled",false);
        }

      // ตรวจสอบระดับUser shop  07/02/2020 Saharat(Golf)
      // if(tUsrShpCode  != ""){ 
      //       $('#oetChqShpCode').val(tUsrShpCode);
      //       $('#oetChqShpName').val(tUsrShpName);
      //       $('#obtChqBrowseShop').attr("disabled", true);
      //       $('#obtChqBrowsePos').prop("disabled",false);
      //   }


    });

  var oChqBrowseBch1  = function(poReturnInput){

let tBchInputReturnCode = poReturnInput.tReturnInputCode;
let tBchInputReturnName = poReturnInput.tReturnInputName;
let tBchNextFuncName    = poReturnInput.tNextFuncName;
let aBchArgReturn       = poReturnInput.aArgReturn;

let oBchOptionReturn    = {
    Title: ['company/branch/branch','tBCHTitle'],
    Table:{Master:'TCNMBranch',PK:'FTBchCode'},
    Join :{
        Table:	['TCNMBranch_L'],
        On:['TCNMBranch_L.FTBchCode = TCNMBranch.FTBchCode AND TCNMBranch_L.FNLngID = '+nChqLangEdits]
    },
    GrideView:{
        ColumnPathLang	: 'company/branch/branch',
        ColumnKeyLang	: ['tBCHCode','tBCHName'],
        ColumnsSize     : ['15%','75%'],
        WidthModal      : 50,
        DataColumns		: ['TCNMBranch.FTBchCode','TCNMBranch_L.FTBchName'],
        DataColumnsFormat : ['',''],
        Perpage			: 10,
        OrderBy			: ['TCNMBranch_L.FTBchCode ASC'],
    },
    CallBack:{
        ReturnType	: 'S',
        Value		: [tBchInputReturnCode,"TCNMBranch.FTBchCode"],
        Text		: [tBchInputReturnName,"TCNMBranch_L.FTBchName"]
    },
    NextFunc : {
        FuncName    : tBchNextFuncName,
        ArgReturn   : aBchArgReturn
    },
    RouteAddNew: 'branch',
    BrowseLev: 1
}
return oBchOptionReturn;
}




     // Event Browse Branch
     $('#obtBrowseBranch').unbind().click(function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSxCheckPinMenuClose();
            window.oChqBrowseBchOption   = undefined;
            oChqBrowseBchOption          = oChqBrowseBch1({
                'tReturnInputCode'  : 'oetBchCode',
                'tReturnInputName'  : 'oetBchName',
                'tNextFuncName'     : 'JSxChqConsNextFuncBrowseBch',
                'aArgReturn'        : ['FTBchCode','FTBchName']
            });
            JCNxBrowseData('oChqBrowseBchOption');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });


     // Functionality : Next Function Branch
    // Parameter : Event Next Func Modal
    // Create : 29/10/2019 Wasin(Yoshi)
    // Return : Clear Velues Data
    // Return Type : -
    function JSxChqConsNextFuncBrowseBch(poDataNextfunc){
        if(poDataNextfunc == 'NULL'){
            // Start Add Disable Button Browse
            $('#obtBKLBrowseShop').prop("disabled",true);
            $('#obtBKLBrowsePos').prop("disabled",true);
           
            // Clear Data Input
            $('.xWInputBranch').val('');
            $('.xWInputShop').val('');
            $('.xWInputPos').val('');
     
        }else{
            // Start Remove Disable Button Browse
            $('#obtBKLBrowseShop').prop("disabled",false);
            // End Remove Disable Button Browse     
            let aDataNextfunc   = JSON.parse(poDataNextfunc);
            let tChqBchCode  = aDataNextfunc[0];
            let tChqOldBchCode  = $('#oetBKLBchCodeOld').val();
            if(tChqOldBchCode != tChqBchCode){
                $('#oetChqBchCodeOld').val(tChqBchCode);
                // Start Add Disable Button Browse
                $('#obtBKLBrowsePos').prop("disabled",true);
               
                // Clear Data Input
                $('.xWInputShop').val('');
                $('.xWInputPos').val('');
             
            }
        }
        return;
    }

</script>