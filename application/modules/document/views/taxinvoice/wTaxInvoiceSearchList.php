<style>
    .bootstrap-select>.dropdown-toggle {
        padding: 3px;
    }
</style>
<div class="panel panel-headline">
    <div class="panel-heading">
        <div class="row">

            <!-- START Branch -->
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                <div class="form-group">
                    <label class="xCNLabelFrm"><?php echo language('document/taxinvoice/taxinvoice','tTAXBusiness2');?></label>
                    <div class="input-group">
                        <input type="text" class="form-control xCNHide" id="oetTXIBchCode" name="oetTXIBchCode">
                        <input type="text" class="form-control xWPointerEventNone" id="oetTXIBchName" name="oetTXIBchName" readonly placeholder="<?php echo language('document/taxinvoice/taxinvoice','tTAXBusiness2');?>">
                        <span class="input-group-btn">
                            <button id="obtTXIBrowseBranch" type="button" class="btn xCNBtnBrowseAddOn"><img class="xCNIconFind"></button>
                        </span>
                    </div>
                </div>
            </div>
            <!-- END Branch -->

            <!-- START Doc Type -->
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                <div class="form-group">
                    <label class="xCNLabelFrm"><?=language('document/taxinvoice/taxinvoice','tTAXDocumentType');?></label>
                    <select class="selectpicker form-control" id="oetTXIDocType" name="oetTXIDocType">
                        <option value=""><?=language('common/main/main','tAll');?></option>
                        <option value="4"><?=language('document/taxinvoice/taxinvoice','tTAXDocType4');?></option>
                        <option value="5"><?=language('document/taxinvoice/taxinvoice','tTAXDocType5');?></option>
                    </select>
                </div>
            </div>
            <!-- END Doc Type -->

            <!-- START Doc No -->
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                <div class="form-group">
                    <label class="xCNLabelFrm"><?=language('document/taxinvoice/taxinvoice','tTAXDocNoNew');?></label>
                    <input class="form-control xCNInpuASTthoutSingleQuote" type="text" id="oetTXIDocNo" name="oetTXIDocNo" placeholder="<?=language('document/taxinvoice/taxinvoice','tTAXDocNoNew')?>" autocomplete="off" >
                </div>
            </div>
            <!-- END Doc No -->

            <!-- START From Doc Date -->
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                <div class="form-group">
                    <label class="xCNLabelFrm"><?php echo language('document/document/document','tDocDateFrom');?></label>
                    <div class="input-group">
                        <input type="text" class="form-control xCNDatePicker xCNInputMaskDate text-left" id="oetTXIFromDocDate" name="oetTXIFromDocDate" value="" placeholder="YYYY-MM-DD">
                        <span class="input-group-btn">
                            <button id="obtTXIFromDocDate" type="button" class="btn xCNBtnDateTime"><img class="xCNIconCalendar"></button>
                        </span>
                    </div>
                </div>
            </div>
            <!-- END From Doc Date -->

            <!-- START To Doc Date -->
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                <div class="form-group">
                    <label class="xCNLabelFrm"><?php echo language('document/document/document','tDocDateTo');?></label>
                    <div class="input-group">
                        <input type="text" class="form-control xCNDatePicker xCNInputMaskDate text-left" id="oetTXIToDocDate" name="oetTXIToDocDate" value="" placeholder="YYYY-MM-DD">
                        <span class="input-group-btn">
                            <button id="obtTXIToDocDate" type="button" class="btn xCNBtnDateTime"><img class="xCNIconCalendar"></button>
                        </span>
                    </div>
                </div>
            </div>
            <!-- END To Doc Date -->

            <!-- START DOC STATUS -->
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                <div class="form-group">
                    <label class="xCNLabelFrm"><?php echo language('authen/user/user','สถานะเอกสาร')?></label>
                    <div class="input-group">
                        <input type="text" class="form-control xCNHide" id="oetTAXStaDoc" name="oetTAXStaDoc" value="1,4">
                        <input type="text" class="form-control xWPointerEventNone" id="oetTAXStaDocName" name="oetTAXStaDocName" value="ใช้งาน" readonly placeholder="<?php echo language('authen/user/user','สถานะเอกสาร')?>">
                        <span class="input-group-btn">
                            <button id="obtTAXBrowseStaDoc" type="button" class="btn xCNBtnBrowseAddOn">
                                <img src="<?php echo  base_url().'/application/modules/common/assets/images/icons/find-24.png'?>">
                            </button>
                        </span>
                    </div>
                </div>
            </div>
            <!-- END DOC STATUS -->

        </div>
            
        <div class="row">

            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-10"></div>

            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2 text-right">
                <button id="obtTXISearch" class="btn xCNBTNPrimery" type="button" style="width: 100%;"><?=language('common/main/main','tCenterModalPDTConfirm');?></button>
            </div>
        
        </div>

    </div>
    <div class="panel-body">
		<section id="ostContentDatatableABB"></section>
	</div>
</div>

<script src="<?=base_url('application/modules/common/assets/js/jquery.mask.js')?>"></script>
<script src="<?=base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>
<script>
    //โหลดหน้าจอ Datatable
    JSxLoadContentDatatable(1);
    function JSxLoadContentDatatable(pnPage){

        var aDataSearch = {
            'tTXIBchCode'       : $('#oetTXIBchCode').val(),
            'tTXIDocType'       : $('#oetTXIDocType').val(),
            'tTXIDocNo'         : $('#oetTXIDocNo').val(),
            'tTXIFromDocDate'   : $('#oetTXIFromDocDate').val(),
            'tTXIToDocDate'     : $('#oetTXIToDocDate').val(),
            'tTAXStaDoc'        : $('#oetTAXStaDoc').val()
        };

        $.ajax({
            type    : "POST",
            url     : "dcmTXINLoadListDataTable",
            data    : { 
                'nPage'       : pnPage, 
                'aDataSearch' : aDataSearch
            },
            cache   : false,
            Timeout : 0,
            success : function (oResult) {
                $('#ostContentDatatableABB').html(oResult);
                JCNxCloseLoading();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }

    $('#obtTXISearch').off('click').on('click',function(){
        JCNxOpenLoading();
        JSxLoadContentDatatable(1);
    });

    $('.selectpicker').selectpicker('refresh');

    $('.xCNDatePicker').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true,
        stopDate: new Date(),
    });

    $('#obtTXIFromDocDate').unbind().click(function() {
        $('#oetTXIFromDocDate').datepicker('show');
    });

    $('#obtTXIToDocDate').unbind().click(function() {
        $('#oetTXIToDocDate').datepicker('show');
    });

    // Control Branch
    var tSesUsrLevel        = '<?php echo $this->session->userdata("tSesUsrLevel"); ?>';
    var nSesUsrBchCount     = <?php echo $this->session->userdata("nSesUsrBchCount"); ?>;
    if( nSesUsrBchCount == 1 && tSesUsrLevel != "HQ" ){
        $('#obtTXIBrowseBranch').attr('disabled',true);
    }

    var tUsrBchCodeDefault  = '<?php echo $this->session->userdata("tSesUsrBchCodeDefault"); ?>';
    var tUsrBchNameDefault  = '<?php echo $this->session->userdata("tSesUsrBchNameDefault"); ?>';
    if( tSesUsrLevel != "HQ" ){
        $('#oetTXIBchCode').val(tUsrBchCodeDefault);
        $('#oetTXIBchName').val(tUsrBchNameDefault);
    }
    

    $('#obtTXIBrowseBranch').click(function() {
        JSxCheckPinMenuClose();
        window.oBrowseBranchOption = undefined;
        oBrowseBranchOption = oBrowseBranch({
            'tReturnCode' : 'oetTXIBchCode',
            'tReturnName' : 'oetTXIBchName'
        });
        JCNxBrowseData('oBrowseBranchOption');
    });

    var oBrowseBranch = function(poDataFnc) {
        var nLangEdits = <?php echo $this->session->userdata("tLangEdit")?>;
        var tReturnCode = poDataFnc.tReturnCode;
        var tReturnName = poDataFnc.tReturnName;


        var oOptionReturn = {
            Title: ['company/branch/branch', 'tBCHTitle'],
            Table: {
                Master  : 'TCNMBranch',
                PK      : 'FTBchCode'
            },
            Join: {
                Table: ['TCNMBranch_L'],
                On: [
                    'TCNMBranch_L.FTBchCode = TCNMBranch.FTBchCode AND TCNMBranch_L.FNLngID = ' + nLangEdits
                ]
            },
            GrideView: {
                ColumnPathLang: 'company/branch/branch',
                ColumnKeyLang: ['tBCHCode', 'tBCHName'],
                ColumnsSize: ['15%', '75%'],
                WidthModal: 50,
                DataColumns: ['TCNMBranch.FTBchCode', 'TCNMBranch_L.FTBchName'],
                DataColumnsFormat: ['', ''],
                Perpage: 5,
                OrderBy: ['TCNMBranch.FDCreateOn'],
                SourceOrder: "DESC"
            },
            CallBack: {
                ReturnType  : 'S',
                Value       : [tReturnCode, "TCNMBranch.FTBchCode"],
                Text        : [tReturnName, "TCNMBranch_L.FTBchName"],
            },
        }
        return oOptionReturn;
    }
    // End Control Branch

    $('#obtTAXBrowseStaDoc').off('click').on('click',function(){
        var nStaSession  = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSxCheckPinMenuClose();
            oTAXStaDoc = oTAXBrowseStaDoc({
                'tReturnInputCode'  : 'oetTAXStaDoc',
                'tReturnInputName'  : 'oetTAXStaDocName'
            });
            JCNxBrowseMultiSelect('oTAXStaDoc');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    var oTAXBrowseStaDoc = function(poReturnInput){
        let tInputReturnCode    = poReturnInput.tReturnInputCode;
        let tInputReturnName    = poReturnInput.tReturnInputName;

        var tSQL = "";
        tSQL += " SELECT '1,4' AS FTStaDoc, 'ใช้งาน' AS FTStaDocName "; /*สมบูรณ์*/
        tSQL += " UNION ";
        tSQL += " SELECT '2,3,5' AS FTStaDoc, 'ยกเลิก' AS FTStaDocName "; /*ไม่สมบูรณ์*/
        // tSQL += " UNION ";
        // tSQL += " SELECT '3' AS FTStaDoc, 'ยกเลิก' AS FTStaDocName "; /*ยกเลิก(ไม่ใช้งาน)*/
        // tSQL += " UNION ";
        // tSQL += " SELECT '4' AS FTStaDoc, 'ใช้งาน' AS FTStaDocName "; /*ยกเลิก(ใช้งาน)*/
        // tSQL += " UNION ";
        // tSQL += " SELECT '5' AS FTStaDoc, 'ยกเลิก' AS FTStaDocName "; /*แก้ไข*/

        let oRoleOptionReturn       = {
            Title : ['authen/user/user','สถานเอกสาร'],
            Table : { Master: " ( "+tSQL+" ) A ", PK: 'FTStaDoc' },
            GrideView:{
                ColumnPathLang	: 'authen/user/user',
                ColumnKeyLang	: ['รหัส','สถานะเอกสาร'],
                ColumnsSize     : ['15%','75%'],
                WidthModal      : 50,
                DataColumns		: ["A.FTStaDoc","A.FTStaDocName"],
                DataColumnsFormat : ['',''],
                Perpage			: 10,
                OrderBy			: ['A.FTStaDoc ASC'],
                DisabledColumns	: [0],
            },
            CallBack:{
                Value		: [tInputReturnCode,"A.FTStaDoc"],
                Text		: [tInputReturnName,"A.FTStaDocName"],
            },

        };
        return oRoleOptionReturn;
    }

</script>