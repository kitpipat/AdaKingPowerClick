<style>
    .bootstrap-select>button {
        height: 35px;
        padding-top: 3px !important;
    }

    .DrillDown {
        cursor: pointer; font-size: 16px !important; 
        text-decoration: underline !important; 
        color: #0081c2 !important;
    }
    
</style>
<input type="hidden" id="oetSDTBrowseType" value="<?=$nSDTBrowseType?>">
<input type="hidden" id="oetSDTBrowseOption" value="<?=$tSDTBrowseOption?>">
<input type="hidden" id="oetSDTPage" value="">

<input type="text" class="form-control xCNHide xWRptAllInput" id="oetSDTSupplierCodeClick" name="oetSDTSupplierCodeClick" maxlength="5">
<input type="text" class="form-control xCNHide xWRptAllInput" id="ohdRptRoute" name="ohdRptRoute" value="<?php echo base_url("/monSDTExportExcel?") ?>" maxlength="5">
<?php 
    $tLangID = $this->session->userdata("tLangEdit");
?>
<input type="hidden" name="oetLangID" id="oetLangID" value="<?=$tLangID?>">
<div class="odvContentPage" id="odvContentPage">
    <div class="main-content" id="odvContent">
        <div id="odvAuditMainMenu" class="main-menu">
            <input type="hidden" name="oetSpcAgncyCode" id="oetSpcAgncyCode" value=""> 
            <div class="xCNMrgNavMenu">
                <div class="row xCNavRow" style="width:inherit;">
                    <div class="xCNDepositVMaster">
                        <div class="col-xs-12 col-md-6">
                            <ol id="oliMenuNav" class="breadcrumb">
                                <li style="cursor:pointer;" ><img id="oimImgFavicon" style="cursor:pointer; margin-top: -10px;" width="20px;" height="20px;" src="<?php echo base_url();?>application/modules/common/assets/images/icons/favorit.PNG" class="xCNDisabled xWImgDisable"></li>
                                <li id="oliAuditTitle" class="xCNLinkClick" onclick="JSxMonitorDefultHeader()"><?= language('monitor/monitor/monitor','tSDTTitle')?></li>
                                <input type="hidden" id="oetSesUsrLevel" value="<?php echo $this->session->userdata('tSesUsrLevel'); ?>">
                            </ol>
                        </div>
                        <div class="col-xs-12 col-md-6 text-right p-r-0 xCNHide">
                            <div class="demo-button xCNBtngroup" style="width:100%;">
                            <button class="btn xCNBTNDefult xCNBTNDefult2Btn" id="obtAUDExport" onclick="JSxMonitorExportExcel();"  type="button"><?= language('monitor/monitor/monitor','tMONBtnExport')?></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <form class="contact100-form validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" id="ofmSDTSearchData">
            <div id="odvContentPageSDT"  class="panel panel-headline">
            <div class="panel-heading">
                <div class="row">
                    <?php 
                        $tUsrLevel = $this->session->userdata('tSesUsrLevel');
                        $tBchMulti = $this->session->userdata("tSesUsrBchCodeMulti");

                        if( $tUsrLevel != "HQ" ){
                            $tSDTAgnCode = $this->session->userdata('tSesUsrAgnCode');
                            $tSDTAgnName = $this->session->userdata('tSesUsrAgnName');
                            $tDisabled = 'disabled';
                        }else{
                            $tSDTAgnCode ='';
                            $tSDTAgnName ='';
                            $tDisabled = '';
                        }
                    ?>
                    <input type="hidden" id="ohdSDTAgnCode" value="<?=$tSDTAgnCode?>">
                    <input type="hidden" id="ohdUsrLevel" value="<?=$tUsrLevel?>">
                    <input type="hidden" id="ohdBchMulti" value="<?=$tBchMulti?>">

                    <!-- สาขา -->
                    <?php
                        // if ( $this->session->userdata("tSesUsrLevel") != "HQ" ){
                        //     if( $this->session->userdata("nSesUsrBchCount") <= 1 ){ //ค้นหาขั้นสูง
                        //         $tBCHCode 	= $this->session->userdata("tSesUsrBchCodeDefault");
                        //         $tBCHName 	= $this->session->userdata("tSesUsrBchNameDefault");
                        //         $tDisabled  = 'disabled';
                        //     }else{
                        //         $tBCHCode 	= '';
                        //         $tBCHName 	= '';
                        //         $tDisabled  = '';
                        //     }
                        // }else{
                        //     $tBCHCode 		= '';
                        //     $tBCHName 		= '';
                        //     $tDisabled      = '';
                        // }
                    ?>

                    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-2 xCNHide">
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?= language('monitor/monitor/monitor','tSDTBch')?></label>
                            <div class="input-group">
                                <input type="text" class="form-control xCNHide xWRptAllInput" id="oetSDTBchCode" name="oetSDTBchCode" maxlength="5" value="">
                                <input type="text" class="form-control xWPointerEventNone xWRptAllInput xCNInputNewUI" value="" id="oetSDTBchName" name="oetSDTBchName" readonly placeholder="<?= language('monitor/monitor/monitor','tSDTBch')?>">
                                <span class="input-group-btn">
                                    <button id="obtSDTBrowseBch" type="button" class="btn xCNBtnBrowseAddOn">
                                        <img src="<?php echo  base_url().'/application/modules/common/assets/images/icons/find-24.png'?>">
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-5ths col-md-3 col-sm-3 col-xs-12">
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?= language('monitor/monitor/monitor','tSDTBchFrm')?></label>
                            <div class="input-group">
                                <input type="text" class="form-control xCNHide xWRptAllInput" id="oetSDTBchCodeForm" name="oetSDTBchCodeForm" maxlength="5" value="">
                                <input type="text" class="form-control xWPointerEventNone xWRptAllInput xCNInputNewUI" value="" id="oetSDTBchNameForm" name="oetSDTBchNameForm" readonly placeholder="<?= language('monitor/monitor/monitor','tSDTBch')?>">
                                <span class="input-group-btn">
                                    <button id="obtSDTBrowseBchForm" type="button" class="btn xCNBtnBrowseAddOn">
                                        <img src="<?php echo  base_url().'/application/modules/common/assets/images/icons/find-24.png'?>">
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-5ths col-md-3 col-sm-3 col-xs-12">
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?= language('monitor/monitor/monitor','tSDTBchTo')?></label>
                            <div class="input-group">
                                <input type="text" class="form-control xCNHide xWRptAllInput" id="oetSDTBchCodeTo" name="oetSDTBchCodeTo" maxlength="5" value="">
                                <input type="text" class="form-control xWPointerEventNone xWRptAllInput xCNInputNewUI" value="" id="oetSDTBchNameTo" name="oetSDTBchNameTo" readonly placeholder="<?= language('monitor/monitor/monitor','tSDTBch')?>">
                                <span class="input-group-btn">
                                    <button id="obtSDTBrowseBchTo" type="button" class="btn xCNBtnBrowseAddOn">
                                        <img src="<?php echo  base_url().'/application/modules/common/assets/images/icons/find-24.png'?>">
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- ประเภทเอกสาร -->
                    <div class="col-lg-5ths col-md-2 col-sm-2 col-xs-12">
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('document/transferreceiptOut/transferreceiptOut', 'tTWIConditionType'); ?></label>
                            <select class="selectpicker form-control" id="ocmSDTDocType" name="ocmSDTDocType">
                                <option value='0' selected><?php echo language('document/transferrequestbranch/transferrequestbranch', 'tTRBTitleMenu'); ?></option>
                                <option value='1'><?php echo language('document/transfer_branch_out/transfer_branch_out', 'tTitle'); ?></option>
                                <option value='2'><?php echo language('document/transferreceiptbranch/transferreceiptbranch', 'tTBITitle5'); ?></option>
                            </select>
                        </div>
                    </div>

                    <!-- สถานะเอกสาร -->
                    <div class="col-lg-5ths col-md-2 col-sm-2 col-xs-12">
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('monitor/monitor/monitor', 'tSDTLowtableThCol12'); ?></label>
                            <select class="selectpicker form-control" id="ocmStaDoc" name="ocmStaDoc">
                            <option value='0' selected><?php echo language('monitor/monitor/monitor', 'tSDTStaAll'); ?></option>
                            <option value='1'><?php echo language('common/main/main', 'tStaDoc'); ?></option>
                            <option value='2'><?php echo language('common/main/main', 'tStaDoc1'); ?></option>
                            <option value='3'><?php echo language('common/main/main', 'tStaDoc3'); ?></option>
                            </select>
                        </div>
                    </div>

                    <!-- สถานะใบรับโอน -->
                    <div class="col-lg-5ths col-md-2 col-sm-2 col-xs-12">
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('monitor/monitor/monitor', 'สถานะใบรับโอน'); ?></label>
                            <select class="selectpicker form-control" id="ocmStaDocTBI" name="ocmStaDocTBI">
                            <option value='0' selected><?php echo language('monitor/monitor/monitor', 'tSDTStaAll'); ?></option>
                            <option value='1'><?php echo language('common/main/main', 'รับโอนแล้ว'); ?></option>
                            <option value='2'><?php echo language('common/main/main', 'ยังไม่รับโอน'); ?></option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <!-- วันที่เอกสาร -->
                    <div class="col-lg-5ths col-md-3 col-sm-3 col-xs-12">
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('document/transferrequestbranch/transferrequestbranch','tTRBAdvSearchDocDate'); ?></label>
                            <div class="input-group">
                                <input
                                    class="form-control xCNDatePicker"
                                    type="text"
                                    id="oetSDTDocDateForm"
                                    name="oetSDTDocDateForm"
                                    placeholder="<?php echo language('document/transferrequestbranch/transferrequestbranch', 'tTRBAdvSearchDateFrom'); ?>"
                                >
                                <span class="input-group-btn" >
                                    <button id="obtSDTDocDateForm" type="button" class="btn xCNBtnDateTime"><img class="xCNIconCalendar"></button>
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- ถึงวันที่เอกสาร -->
                    <div class="col-lg-5ths col-md-3 col-sm-3 col-xs-12">
                        <label class="xCNLabelFrm"><?php echo language('document/transferrequestbranch/transferrequestbranch', 'tTRBAdvSearchDateTo'); ?></label>
                        <div class="input-group">
                            <input
                                class="form-control xCNDatePicker"
                                type="text"
                                id="oetSDTDocDateTo"
                                name="oetSDTDocDateTo"
                                placeholder="<?php echo language('document/transferrequestbranch/transferrequestbranch', 'tTRBAdvSearchDateTo'); ?>"
                            >
                            <span class="input-group-btn" >
                                <button id="obtSDTDocDateTo" type="button" class="btn xCNBtnDateTime"><img class="xCNIconCalendar"></button>
                            </span>
                        </div>
                    </div>
                    
                    <!-- เลขที่เอกสาร -->
                    <div class="col-lg-5ths col-md-4 col-sm-4 col-xs-12">
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?= language('monitor/monitor/monitor','tMONDocNo')?></label>
                            <input type="text" class="form-control xWRptAllInput" id="oetSDTDocNo" name="oetSDTDocNo" placeholder="<?= language('monitor/monitor/monitor','tMONDocNo')?>">
                        </div>
                    </div>
                    
                    <!-- ปุ่มค้นหา / ล้างการค้นหา -->
                    <div class="col-lg-5ths col-md-2 col-sm-2 col-xs-12">
                        <div class="form-group">
                            <label class="xCNLabelFrm"></label>
                            <div class="">
                                <a id="oahSDTAdvanceSearch" class="btn xCNBTNPrimery  xCNBTNDefult1Btn" onclick="JSxSDTSearchData()"><?= language('monitor/monitor/monitor','tMONlabelSearch')?></a>
                                &nbsp;
                                <a id="oahSDTSearchReset" class="btn xCNBTNDefult xCNBTNDefult1Btn"><?= language('monitor/monitor/monitor','tMONlabelClear')?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <div id="otbSDTDataTable">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

</div>

</div>
<script src="<?php echo base_url('application/modules/monitor/assets/src/chkstadoctransfer/jChkStaDocTransfer.js'); ?>"></script>
<script type="text/javascript">
    $('document').ready(function(){
        var nStaBrowseType = $('#oetSDTBrowseType').val()

        if (nStaBrowseType == 0) {
            //เคลียค่า
            localStorage.removeItem("aValues");
            localStorage.tCheckBackStageData = '';
        }

        $('#odvSDTStaDocTBO').hide();
        $('#odvSDTStaDocTRB').show();
        $('#odvSDTStaDocTBI').hide();

        $('.selectpicker').selectpicker();

        $('.xCNDatePicker').datepicker({
            format: "yyyy-mm-dd",
            todayHighlight: true,
            enableOnReadonly: false,
            disableTouchKeyboard : true,
            autoclose: true
        });

        // Doc Date From
        $('#obtSDTDocDateForm').unbind().click(function(){
            $('#oetSDTDocDateForm').datepicker('show');
        });

        // Doc Date To
        $('#obtSDTDocDateTo').unbind().click(function(){
            $('#oetSDTDocDateTo').datepicker('show');
        });

        JSxCheckPinMenuClose(); /*Check เปิดปิด Menu ตาม Pin*/
        JSxSDTSearchData();
    });

    $('#ocmSDTDocType').on('change', function() {
        $("#ocmStaDoc").val("0").selectpicker("refresh");
    });

    $('#oahSDTSearchReset').unbind().click(function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSxSDTClearAdvSearchData();
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    // ล้างค่า Input ทั้งหมดใน Advance Search
    function JSxSDTClearAdvSearchData(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof nStaSession !== "undefined" && nStaSession == 1){
            $('#ofmSDTSearchData').find('input').val('');
            JSxMonitorDefultHeader();
        }else{
            JCNxShowMsgSessionExpired();
        }
    }
  
    function JSxSDTSearchData(pnPage) {
        var nBackPage = $('#oetSDTPage').val();
        var nStaSession = JCNxFuncChkSessionExpired();
        var oAdvanceSearch = JSoSDTGetAdvanceSearchData();
        var aLocalPage = JSON.parse(localStorage.getItem("aValues"));

        if (aLocalPage != null) {
                var nPageCurrent = aLocalPage.nBackPage;
            } else {
                var nPageCurrent = pnPage;
            }
        if (nPageCurrent == undefined || nPageCurrent == '') {
            nPageCurrent = '1';
        }

        JCNxOpenLoading();
        JSxCheckPinMenuClose(); // Hidden Pin Menu
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
        $.ajax({
            type: "POST",
            url: "monSDTList",
            data: {oAdvanceSearch : oAdvanceSearch,
                    nPageCurrent: nPageCurrent},
            cache: false,
            timeout: 0,
            success: function(wResult){
                var aLocalValue = JSON.parse(localStorage.getItem("aValues"));
                if (aLocalValue != null) {
                    var tStaDocTBI  = aLocalValue.tStaDocTBI;
                    var tStaDoc     = aLocalValue.tStaDoc;
                    var tDocType    = aLocalValue.tDocType;

                    if (tDocType == 0) {
                        $("#ocmSDTDocType").val("0").selectpicker("refresh");
                    } else if (tDocType == 1) {
                        $("#ocmSDTDocType").val("1").selectpicker("refresh");
                    } else {
                        $("#ocmSDTDocType").val("2").selectpicker("refresh");
                    }

                    if (tStaDoc == 1) {
                        $("#ocmStaDoc").val("1").selectpicker("refresh");
                    } else if (tStaDoc == 2) {
                        $("#ocmStaDoc").val("2").selectpicker("refresh");
                    } else if (tStaDoc == 3) {
                        $("#ocmStaDoc").val("3").selectpicker("refresh");
                    } else {
                        $("#ocmStaDoc").val("0").selectpicker("refresh");
                    }

                    if (tStaDocTBI == 1) {
                        $("#ocmStaDocTBI").val("1").selectpicker("refresh");
                    } else if (tStaDocTBI == 2) {
                        $("#ocmStaDocTBI").val("2").selectpicker("refresh");
                    } else {
                        $("#ocmStaDocTBI").val("0").selectpicker("refresh");
                    }
                }
                //เคลียค่า
                localStorage.removeItem("aValues");
                localStorage.tCheckBackStageData = '';
                $("#otbSDTDataTable").html(wResult);
                JCNxCloseLoading();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
        }
    }

    // รวม Values ต่างๆของการค้นหาขั้นสูง
    function JSoSDTGetAdvanceSearchData() {
        var aLocalValue = JSON.parse(localStorage.getItem("aValues"));
        var tOldData = localStorage.tCheckBackStageData;

        if (tOldData == 'monDocTransferData') {
            var oAdvanceSearchData = {
                tBchCode            : aLocalValue.tBchCode,
                tBchCodeFrm         : aLocalValue.tBchCodeFrm,
                tBchCodeTo          : aLocalValue.tBchCodeTo,
                tDocType            : aLocalValue.tDocType,
                tStaDoc             : aLocalValue.tStaDoc,
                tStaDocTBI          : aLocalValue.tStaDocTBI,
                tDocNo              : aLocalValue.tDocNo,
                tDocDateForm        : aLocalValue.tDocDateForm,
                tDocDateTo          : aLocalValue.tDocDateTo
            };
        }else{
            var oAdvanceSearchData = {
                tBchCode            : $("#oetSDTBchCode").val(),
                tBchCodeFrm         : $("#oetSDTBchCodeForm").val(),
                tBchCodeTo          : $("#oetSDTBchCodeTo").val(),
                tDocType            : $("#ocmSDTDocType").val(),
                tStaDoc             : $("#ocmStaDoc").val(),
                tStaDocTBI          : $("#ocmStaDocTBI").val(),
                tDocNo              : $("#oetSDTDocNo").val(),
                tDocDateForm        : $("#oetSDTDocDateForm").val(),
                tDocDateTo          : $("#oetSDTDocDateTo").val()
            };
        }

        
        return oAdvanceSearchData;
    }

    function JSxMonitorDefultHeader() {
        var nStaSession = JCNxFuncChkSessionExpired();
        JCNxOpenLoading();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
        $.ajax({
            type: "POST",
            url: "monSDT/0/0",
            cache: false,
            timeout: 0,
            success: function(wResult){

                $('#odvContentPage').html(wResult);

                //JSxMonitorDefult();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
        }
    }

    // สาขา
    $('#obtSDTBrowseBch').unbind().click(function() {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
            JSxCheckPinMenuClose(); // Hidden Pin Menu
            oSDTBrowseBch = oSDTBrowseBchCode({
                'tReturnInputCode': 'oetSDTBchCode',
                'tReturnInputName': 'oetSDTBchName',
            });
            JCNxBrowseData('oSDTBrowseBch');
        } else {
            JCNxShowMsgSessionExpired();
        }
    });

    $('#obtSDTBrowseBchForm').unbind().click(function() {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
            JSxCheckPinMenuClose(); // Hidden Pin Menu
            oSDTBrowseBch = oSDTBrowseBchCode({
                'tReturnInputCode': 'oetSDTBchCodeForm',
                'tReturnInputName': 'oetSDTBchNameForm',
            });
            JCNxBrowseData('oSDTBrowseBch');
        } else {
            JCNxShowMsgSessionExpired();
        }
    });

    // สาขา
    $('#obtSDTBrowseBchTo').unbind().click(function() {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
            JSxCheckPinMenuClose(); // Hidden Pin Menu
            oSDTBrowseBch = oSDTBrowseBchCode({
                'tReturnInputCode': 'oetSDTBchCodeTo',
                'tReturnInputName': 'oetSDTBchNameTo',
            });
            JCNxBrowseData('oSDTBrowseBch');
        } else {
            JCNxShowMsgSessionExpired();
        }
    });
    

    var tUsrLevel 	  	= "<?=$this->session->userdata("tSesUsrLevel"); ?>";
    var tBchCodeMulti 	= "<?=$this->session->userdata("tSesUsrBchCodeMulti"); ?>";
    var nCountBch 		= "<?=$this->session->userdata("nSesUsrBchCount"); ?>";
    var nLangEdits      = "<?=$this->session->userdata("tLangEdit")?>";

    if(tUsrLevel != "HQ"){
        tWhere = " AND TCNMBranch.FTBchCode IN ("+tBchCodeMulti+") ";
    }else{
        tWhere = "";
    }

    var oSDTBrowseBchCode = function(poReturnInputBch) {
        let tInputReturnCode    = poReturnInputBch.tReturnInputCode;
        let tInputReturnName    = poReturnInputBch.tReturnInputName;
        var tWhere              = '';
        var tSQLWhereBch        = '';
        var tSQLWhereAgn        = '';
        var tUsrLevel           = $('#ohdUsrLevel').val();
        var tBchMulti           = $('#ohdBchMulti').val();
        
        if(tUsrLevel != "HQ"){
            tSQLWhereBch = " AND TCNMBranch.FTBchCode IN ("+tBchMulti+")";
        }else{
            tSQLWhereBch = "";
        }

        let oOptionReturn = {
            Title: ['company/branch/branch', 'tBCHTitle'],
            Table: {
                Master: 'TCNMBranch',
                PK: 'FTBchCode'
            },
            Join: {
                Table: ['TCNMBranch_L'],
                On: [
                    'TCNMBranch.FTBchCode = TCNMBranch_L.FTBchCode AND TCNMBranch_L.FNLngID = ' + nLangEdits
                ]
            },
            Where: {
                Condition: [tSQLWhereAgn,tSQLWhereBch,tWhere]
            },
            GrideView: {
                ColumnPathLang: 'company/branch/branch',
                ColumnKeyLang: ['tBchCode', 'tBCHSubTitle'],
                ColumnsSize: ['15%', '90%'],
                WidthModal: 50,
                DataColumns: ['TCNMBranch.FTBchCode', 'TCNMBranch_L.FTBchName'],
                DataColumnsFormat: ['', ''],
                Perpage: 10,
                OrderBy: ['TCNMBranch.FDCreateOn DESC'],
            },
            debugSQL: true,
            CallBack: {
                ReturnType: 'S',
                Value: [tInputReturnCode, "TCNMBranch.FTBchCode"],
                Text: [tInputReturnName, "TCNMBranch_L.FTBchName"]
            },
        };
        return oOptionReturn;
    }

</script>
