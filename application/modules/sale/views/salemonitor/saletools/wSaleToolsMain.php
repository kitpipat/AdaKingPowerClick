<style>
    .xWSTLSALHeadPanel{
        border-bottom:1px solid #cfcbcb8a !important;
        padding-bottom:0px !important;
    }

    .xWSTLSALTextNumber{
        font-size: 25px !important;
        font-weight: bold;
    }
    
    .xWSTLSALPanelMainRight{
        padding-bottom:0px;
        min-height:300px;
        overflow-x: auto;
    }

    .xWSTLSALFilter{
        cursor: pointer;
    }

    .xWSTLSALRequest{
        cursor: pointer;
    }
    .xWOverlayLodingChart{
        position: absolute;
	    min-width: 100%;
	    min-height: 100%;
	    width: 100%;
	    background: #FFFFFF;
	    z-index: 2500;
	    display: none;
	    top: 0%;
        margin-left: 0px;
        left: 0%;
    }
</style>
<?php
$dDateToday         = date("Y-m-d");
$dFirstDateOfMonth  = $dDateToday;
$dLastDateOfMonth   = $dDateToday;
?>
<div class="row">
  <form id="ofmSTLFormFilter" name="ofmSTLFormFilter" >
  <input type="hidden" id="oetSTLSALSort" name="oetSTLSALSort" value="">
    <input type="hidden" id="oetSTLSALFild" name="oetSTLSALFild" value="FTBchName,FTPosCode">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <!-- Tab STLnformation -->
        <div id="odvSTLSALPanelRight1" class="">
            <div class="panel-collapse collapse in" role="tabpanel">
                <div class="panel-body xWSTLSALPanelMainRight">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="" style="padding-bottom:0px;">
                            <div class="col-xs-12 col-md-3 col-lg-3">
                                    <div class="form-group">
                                        <label class="xCNLabelFrm"><?=language('sale/salemonitor/salemonitor', 'tSTLToolsOption')?></label>
                                     
                                                <select class=" form-control "  name="ocbSTLOptionType" id="ocbSTLOptionType">
                                                <option value="1" selected><?=language('sale/salemonitor/salemonitor', 'tSTLToolsCheckSaleShift')?></option>
                                                <option value="2"><?=language('sale/salemonitor/salemonitor', 'tSTLToolsImportBill')?></option>
                                                </select>
                                        
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-2 col-lg-2">
                                         <div class="form-group">
                                            <label class="xCNLabelFrm"><?=language('sale/salemonitor/salemonitor', 'tSMTBchName')?></label>
                                            <div class="input-group">
                                            <input type="text" class="form-control xCNHide" id="oetSMTSALFilterBchStaAll" name="oetSMTSALFilterBchStaAll">
                                            <input type="text" class="form-control xCNHide" id="oetSMTSALFilterBchCodeTool" name="oetSMTSALFilterBchCodeTool">
                                            <input type="text" class="form-control xWPointerEventNone" id="oetSMTSALFilterBchNameTool" name="oetSMTSALFilterBchNameTool" readonly>
                                            <span class="input-group-btn">
                                            <button id="obtSMTSALFilterBchTools" type="button" class="btn xCNBtnBrowseAddOn"><img class="xCNIconFind"></button>
                                            </span>
                                            </div>
                                            </div>
                                </div>
                                <div class="col-xs-12 col-md-2 col-lg-2">
                                             <div class="form-group">
                                                <label class="xCNLabelFrm"><?=language('sale/salemonitor/salemonitor', 'tSMTPos')?></label>
                                                <div class="input-group">
                                                <input type="text" class="form-control xCNHide" id="oetSMTSALFilterPosStaAll" name="oetSMTSALFilterPosStaAll">
                                                <input type="text" class="form-control xCNHide" id="oetSMTSALFilterPosCodeTool" name="oetSMTSALFilterPosCodeTool">
                                                <input type="text" class="form-control xWPointerEventNone" id="oetSMTSALFilterPosNameTool" name="oetSMTSALFilterPosNameTool" readonly>
                                                <span class="input-group-btn">
                                                <button id="obtSMTSALFilterPosTool" type="button" class="btn xCNBtnBrowseAddOn"><img class="xCNIconFind"></button>
                                                </span>
                                                </div>
                                                </div>
                                </div>
                                <div class="col-xs-12 col-md-2 col-lg-2">
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?=language('sale/salemonitor/salemonitor', 'tSTLToolsDate')?></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control text-center xCNDatePicker xWPointerEventNone" id="oetSTLSALDateDataTo" name="oetSTLSALDateDataTo" value="<?php echo @$dLastDateOfMonth; ?>">
                                        <span class="input-group-btn">
                                            <button id="obtSTLSALDateDataTo" type="button" class="btn xCNBtnBrowseAddOn"><img class="xCNIconCalendar"></button>
                                        </span>
                                    </div>
                                 </div>
                                 </div>
                                 <div class="col-xs-12 col-md-1 col-lg-1  " style="margin-top:25px;">   
                                    <button type="button" id="obtCallDataTable" class="btn btn-success btn-sm xCNBTNMngTable" data-toggle="dropdown" style="width: 100%;">
                                        <i class="fa fa-filter" aria-hidden="true"></i> <?=language('sale/salemonitor/salemonitor', 'tSTLToolsFilter')?>			
                                    </button>
                                </div>
                                <div class="col-xs-12 col-md-1 col-lg-1 "  style="margin-top:25px;">
                                    <button id="obtSTLReload" class="btn btn-info btn-sm" type="button" style="width: 100%;" >
                                        <i class="fa fa-refresh" aria-hidden="true"></i>  <?=language('sale/salemonitor/salemonitor', 'tSMTReload')?>
                                    </button>
                                </div>
                                <div class="col-xs-12 col-md-1 col-lg-1 " style="margin-top:25px;" >   
                                    <button type="button" id="obtSaleRepair" class="btn btn-primary btn-sm btn-md xCNBTNMngTable" data-toggle="dropdown" style="width: 100%;">
                                        <i class="fa fa-spinner" aria-hidden="true"></i> <?=language('sale/salemonitor/salemonitor', 'tSTLToolsRepair')?>				
                                    </button>
                                </div>
                                   
                                        <div class="col-md-12 xWSTLDataTable"  id="odvSTLDataTable">

                                        </div>
                                  
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>

 
    </div>
</div>
</form>
<script type="text/javascript">
    $(document).ready(function(){
        
        $('.xCNDatePicker').datepicker({
            format: "yyyy-mm-dd",
            todayHighlight: true,
            enableOnReadonly: false,
            disableTouchKeyboard : true,
            autoclose: true
        });


        // Event Click Button Filter Date Data To
        $('#obtSTLSALDateDataTo').unbind().click(function(){
         
            $('#oetSTLSALDateDataTo').datepicker('show');
        });

        JCNxSTLCallDataTable();

        var tFilterBchCode = $('#ohdSMTSALSessionBchCode').val();
        var tFilterBchName = $('#ohdSMTSALSessionBchName').val();
        var nSesUsrBchCount = $('#odhnSesUsrBchCount').val();
        if(nSesUsrBchCount==1){
                $('#oetSMTSALFilterBchCodeTool').val(tFilterBchCode);
                $('#oetSMTSALFilterBchNameTool').val(tFilterBchName);
                $('#obtSMTSALFilterShpTool').attr('disabled',false);
                $('#obtSMTSALFilterPosTool').attr('disabled',false);
                $('#obtSMTSALFilterBchTools').attr('disabled',true);
            }else{
                $('#obtSMTSALFilterShpTool').attr('disabled',true);
                $('#obtSMTSALFilterPosTool').attr('disabled',true);
                $('#obtSMTSALFilterBchTools').attr('disabled',false);      
            
        }

        
    });


    $('#obtSTLReload').click(function(){
        JCNxSTLCallDataTable();
    });


    var nLangEdits  = '<?php echo $this->session->userdata("tLangEdit");?>';
    $('#obtCallDataTable').click(function(){
        JCNxSTLCallDataTable();
    })
            // Function: Confirm Filter DashBoard
            // Parameters: Document Ready Or Parameter Event
            // Creator: 06/02/2020 Nattakit
            // Return: View Data Table
            // ReturnType: View
            function JCNxSTLCallDataTable(nPageCurrent){
                JCNxOpenLoading();
                if(nPageCurrent=='' || nPageCurrent == undefined || nPageCurrent == 'NaN' ){
                    nPageCurrent = 1;
                }
                $.ajax({
                    type: "POST",
                    url: "dasSTLCallDataTable",
                    data: $('#ofmSTLFormFilter').serialize()+"&nPageCurrent="+nPageCurrent,
                    cache: false,
                    timeout: 0,
                    success : function(paDataReturn){
                        $('#odvSTLDataTable').html(paDataReturn);
    
                        JCNxCloseLoading();
                    },
                    error : function (jqXHR, textStatus, errorThrown) {
                        JCNxResponseError(jqXHR,textStatus,errorThrown);
                    }
                });
            }




      // Event Click Browse Multi Branch
      $('#obtSMTSALFilterBchTools').unbind().click(function(){
            let nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== "undefined" && nStaSession == 1) {
                JSxCheckPinMenuClose(); // Hidden Pin Menu
                let tTextWhereInBranch      = '';
                if($('#odhnSesUsrBchCount').val() >=1){
                    var tDataBranch = "<?=$this->session->userdata('tSesUsrBchCodeMulti')?>";
                    tTextWhereInBranch      = ' AND (TCNMBranch.FTBchCode IN ('+tDataBranch+'))';
                }
                window.oSMTSALBrowseBchOption   = undefined;
                oSMTSALBrowseBchOption          = {
                    Title   : ['company/branch/branch','tBCHTitle'],
                    Table   : {Master:'TCNMBranch',PK:'FTBchCode'},
                    Join    : {
                        Table   : ['TCNMBranch_L'],
                        On      : ['TCNMBranch_L.FTBchCode = TCNMBranch.FTBchCode AND TCNMBranch_L.FNLngID = '+nLangEdits]
                    },
                    Where :{
                        Condition : [tTextWhereInBranch]
                    },
                    GrideView:{
                        ColumnPathLang  	: 'company/branch/branch',
                        ColumnKeyLang	    : ['tBCHCode','tBCHName'],
                        ColumnsSize         : ['15%','75%'],
                        WidthModal          : 50,
                        DataColumns		    : ['TCNMBranch.FTBchCode','TCNMBranch_L.FTBchName'],
                        DataColumnsFormat   : ['',''],
                        OrderBy			    : ['TCNMBranch_L.FTBchCode ASC'],
                    },
                    NextFunc:{
                        FuncName:'JSxSMTSetBrowsShopPos',
                        ArgReturn:['FTBchCode']
                    },
                    CallBack:{
                        StausAll    : ['oetSMTSALFilterBchStaAll'],
                        Value		: ['oetSMTSALFilterBchCodeTool','TCNMBranch.FTBchCode'],
                        Text		: ['oetSMTSALFilterBchNameTool','TCNMBranch_L.FTBchName']
                    },
           
                };
                JCNxBrowseMultiSelect('oSMTSALBrowseBchOption');
            }else{
                JCNxShowMsgSessionExpired();
            }
        });
        

        function JSxSMTSetBrowsShopPos(ptParam){
            console.log(ptParam);
            if(ptParam.length==1){
                $('#obtSMTSALFilterShpTool').attr('disabled',false);
                $('#obtSMTSALFilterPosTool').attr('disabled',false);
            }else{
                $('#obtSMTSALFilterShpTool').attr('disabled',true);
                $('#obtSMTSALFilterPosTool').attr('disabled',true);      
            }
        }


    // Event Click Browse Multi Pos
    $('#obtSMTSALFilterPosTool').unbind().click(function(){
            let nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                var tFilterBchCode = $('#oetSMTSALFilterBchCodeTool').val();
                var tFilterBchCodeWhere = tFilterBchCode.replace(",","','");
                if(tFilterBchCodeWhere!=''){
                  var tConditionWhere = " AND TCNMPos.FTBchCode IN ('"+tFilterBchCodeWhere+"')";
                }else{
                    var tConditionWhere = "";
                }
                JSxCheckPinMenuClose(); // Hidden Pin Menu
                window.oSMTSALBrowsePosOption   = undefined;
                oSMTSALBrowsePosOption          = {
                    Title       : ["pos/salemachine/salemachine","tPOSTitle"],
                    Table       : { Master:'TCNMPos', PK:'FTPosCode'},
                    Join    : {
                        Table   : ['TCNMPos_L'],
                        On      : [
                            'TCNMPos.FTPosCode = TCNMPos_L.FTPosCode AND TCNMPos.FTBchCode = TCNMPos_L.FTbchCode AND TCNMPos_L.FNLngID = '+nLangEdits
                        ]
                    },
                    Where   : {
                        Condition : [tConditionWhere]
                    },
                    GrideView   : {
                        ColumnPathLang  : 'pos/salemachine/salemachine',
                        ColumnKeyLang   : ['tPOSCode','tPOSRegNo'],
                        ColumnsSize     : ['10%','80%'],
                        WidthModal      : 50,
                        DataColumns     : ["TCNMPos.FTPosCode","TCNMPos_L.FTPosName"],
                        DataColumnsFormat : ['',''],
                        OrderBy         : ['TCNMPos.FTPosCode ASC'],
                    },
                    CallBack    : {
                        StausAll    : ['oetSMTSALFilterPosStaAll'],
                        Value       : ['oetSMTSALFilterPosCodeTool',"TCNMPos.FTPosCode"],
                        Text        : ['oetSMTSALFilterPosNameTool',"TCNMPos_L.FTPosName"]
                    }
                };
                JCNxBrowseMultiSelect('oSMTSALBrowsePosOption');
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

// Function: Sort And Filter Total By Branch
// Parameters: Document Ready Or Parameter Event
// Creator: 17/06/2020 Worakorn
// Return: View Page Main
// ReturnType: View
function JSvSTLTotalByBranchSort(ptFild) {

const oetSTLSALSort = $('#oetSTLSALSort').val();

$('#oetSTLSALFild').val(ptFild);

if (oetSTLSALSort == 'ASC') {
    $('#oetSTLSALSort').val('DESC');
} else {
    $('#oetSTLSALSort').val('ASC');
}
JCNxSTLCallDataTable();

}

$('#obtSaleRepair').click(function(){
        if(confirm('<?=language('sale/salemonitor/salemonitor', 'tSTLToolsConfirmRepair')?>')==true){
            JCNxOpenLoading();
            var oListItem = [];
            var i = 0;
            $(".ocbSTLListItem:checkbox:checked").map(function(){
                oListItem[i] = { tRouting:$(this).data('routing') , tShiftCode:$(this).val() };
                i++;
                }).get(); 
                // console.log(oListItem);
            $.ajax({
                    type: "POST",
                    url: "dasSTLEventRepair",
                    data: {oListItem:oListItem},
                    cache: false,
                    timeout: 0,
                    success : function(paDataReturn){
                        var paDataReturn = JSON.parse(paDataReturn);
                    
                        if(paDataReturn['nStaEvent']==1){
                            setTimeout(() => {
                                JCNxCloseLoading();
                                FSvCMNSetMsgSucessDialog('<?=language('sale/salemonitor/salemonitor', 'tSTLToolsRepairing')?>');
                                JCNxSTLCallDataTable();
                            }, 5000);

                        }else{
                            FSvCMNSetMsgWarningDialog(paDataReturn['tStaMessg']);
                        }
                    },
                    error : function (jqXHR, textStatus, errorThrown) {
                        JCNxResponseError(jqXHR,textStatus,errorThrown);
                    }
                });

        }
});


$('#ocbSTLOptionType').change(function(){
      var  nSTLOptionType = $(this).val();

      if(nSTLOptionType==1){
        JCNxSMTCallSaleTools();
      }else{
        JCNxSMTCallSaleImport();
      }
})

</script>
