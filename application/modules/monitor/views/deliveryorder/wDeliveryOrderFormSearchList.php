<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="panel panel-headline">
            <div class="panel-heading">
                <form class="contact100-form validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" id="ofmDOSearchData">
                    <div class="row">
                        <?php 
                            $tUsrLevel = $this->session->userdata('tSesUsrLevel');
                            $tBchMulti = $this->session->userdata("tSesUsrBchCodeMulti");

                            if( $tUsrLevel != "HQ" ){
                                $tDOAgnCode = $this->session->userdata('tSesUsrAgnCode');
                                $tDOAgnName = $this->session->userdata('tSesUsrAgnName');
                                $tDisabled = 'disabled';
                            }else{
                                $tDOAgnCode ='';
                                $tDOAgnName ='';
                                $tDisabled = '';
                            }
                        ?>
                        <input type="hidden" id="ohdDOAgnCode" value="<?=$tDOAgnCode?>">
                        <input type="hidden" id="ohdUsrLevel" value="<?=$tUsrLevel?>">
                        <input type="hidden" id="ohdBchMulti" value="<?=$tBchMulti?>">
                        <input type="hidden" id="ohdDOPageCurrent" value="1">
                        
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="row">
                                <!-- จากสาขา -->
                                <?php
                                    // if ( $this->session->userdata("tSesUsrLevel") != "HQ" ){
                                    //     if( $this->session->userdata("nSesUsrBchCount") <= 1 ){ //ค้นหาขั้นสูง
                                    //         $tBCHCode 	= $this->session->userdata("tSesUsrBchCodeDefault");
                                    //         $tBCHName 	= $this->session->userdata("tSesUsrBchNameDefault");
                                    //     }else{
                                    //         $tBCHCode 	= '';
                                    //         $tBCHName 	= '';
                                    //     }
                                    // }else{
                                    //     $tBCHCode 		= '';
                                    //     $tBCHName 		= '';
                                    // }
                                ?>
                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                                    <div class="form-group">
                                        <label class="xCNLabelFrm"><?= language('monitor/monitor/monitor','tDOBchFrm')?></label>
                                        <div class="input-group">
                                            <input type="text" class="form-control xCNHide xWRptAllInput" id="ohdDOFrmBchCode" name="ohdDOFrmBchCode" maxlength="5" value="">
                                            <input type="text" class="form-control xWPointerEventNone xWRptAllInput xCNInputNewUI" value="" id="oetDOFrmBchName" name="oetDOFrmBchName" readonly placeholder="<?= language('monitor/monitor/monitor','tDOBchFrm')?>">
                                            <span class="input-group-btn">
                                                <button id="obtDOBrowseFrmBch" type="button" class="btn xCNBtnBrowseAddOn">
                                                    <img src="<?php echo  base_url().'/application/modules/common/assets/images/icons/find-24.png'?>">
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <!-- จากสาขา -->

                                <!-- ถึงสาขา -->
                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                                    <div class="form-group">
                                        <label class="xCNLabelFrm"><?= language('monitor/monitor/monitor','tDOBchTo')?></label>
                                        <div class="input-group">
                                            <input type="text" class="form-control xCNHide xWRptAllInput" id="ohdDOToBchCode" name="ohdDOToBchCode" maxlength="5" value="">
                                            <input type="text" class="form-control xWPointerEventNone xWRptAllInput xCNInputNewUI" value="" id="oetDOToBchName" name="oetDOToBchName" readonly placeholder="<?= language('monitor/monitor/monitor','tDOBchTo')?>">
                                            <span class="input-group-btn">
                                                <button id="obtDOBrowseToBch" type="button" class="btn xCNBtnBrowseAddOn">
                                                    <img src="<?php echo  base_url().'/application/modules/common/assets/images/icons/find-24.png'?>">
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <!-- ถึงสาขา -->

                                <!-- จากวันที่เอกสาร -->
                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                                    <div class="form-group" style="height: 30px; margin-bottom: 10px;">
                                        <label class="xCNLabelFrm"><?php echo language('document/transferrequestbranch/transferrequestbranch','tTRBAdvSearchDocDate'); ?></label>
                                        <div class="input-group">
                                            <input
                                                class="form-control xCNDatePicker"
                                                type="text"
                                                id="oetDODocDateForm"
                                                name="oetDODocDateForm"
                                                placeholder="<?php echo language('document/transferrequestbranch/transferrequestbranch', 'tTRBAdvSearchDateFrom'); ?>"
                                            >
                                            <span class="input-group-btn" >
                                                <button id="obtDODocDateForm" type="button" class="btn xCNBtnDateTime"><img class="xCNIconCalendar"></button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <!-- จากวันที่เอกสาร -->

                                <!-- ถึงวันที่เอกสาร -->
                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                                    <label class="xCNLabelFrm"><?php echo language('document/transferrequestbranch/transferrequestbranch', 'tTRBAdvSearchDateTo'); ?></label>
                                    <div class="input-group" style="height: 30px; margin-bottom: 10px;">
                                        <input
                                            class="form-control xCNDatePicker"
                                            type="text"
                                            id="oetDODocDateTo"
                                            name="oetDODocDateTo"
                                            placeholder="<?php echo language('document/transferrequestbranch/transferrequestbranch', 'tTRBAdvSearchDateTo'); ?>"
                                        >
                                        <span class="input-group-btn" >
                                            <button id="obtDODocDateTo" type="button" class="btn xCNBtnDateTime"><img class="xCNIconCalendar"></button>
                                        </span>
                                    </div>
                                </div>
                                <!-- ถึงวันที่เอกสาร -->
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="row">
                                <!-- สถานะเอกสาร -->
                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3" id="odvDOStaDoc">
                                    <div class="form-group"  style="height: 30px; margin-top: 0px;">
                                        <label class="xCNLabelFrm"><?php echo language('monitor/monitor/monitor', 'tSDTLowtableThCol12'); ?></label>
                                        <select class="selectpicker form-control" id="ocmDOStaDoc" name="ocmDOStaDoc">
                                        <option value='0' selected><?php echo language('monitor/monitor/monitor', 'tSDTStaAll'); ?></option>
                                        <option value='1'><?php echo language('common/main/main', 'tStaDoc'); ?></option>
                                        <option value='2'><?php echo language('common/main/main', 'tStaDoc1'); ?></option>
                                        <option value='3'><?php echo language('common/main/main', 'tStaDoc3'); ?></option>
                                        </select>
                                    </div>
                                </div>
                                <!-- สถานะเอกสาร -->

                                <!-- เลขที่เอกสาร -->
                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                    <div class="form-group" style="height: 30px; margin-bottom: 10px;">
                                        <label class="xCNLabelFrm"><?= language('monitor/monitor/monitor','tMONDocNo')?></label>
                                        <input type="text" class="form-control xWRptAllInput" id="oetDODocNo" name="oetDODocNo" placeholder="<?= language('monitor/monitor/monitor','tMONDocNo')?>" autocomplete="off">
                                    </div>
                                </div>
                                <!-- เลขที่เอกสาร -->

                                <!-- ปุ่มค้นหา / ล้างการค้นหา -->
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                    <div class="form-group">
                                        <label class="xCNLabelFrm"></label>
                                        <div class="text-center">
                                            <a id="oahDOAdvanceSearch" class="btn xCNBTNPrimery  xCNBTNDefult1Btn" style="width:48%" onclick="JSvDOCallPageDataTable()"><?= language('monitor/monitor/monitor','tMONlabelSearch')?></a>
                                            &nbsp;
                                            <a id="oahDOSearchReset" class="btn xCNBTNDefult xCNBTNDefult1Btn"  style="width:48%"><?= language('monitor/monitor/monitor','tMONlabelClear')?></a>
                                        </div>
                                    </div>
                                </div>
                                <!-- ปุ่มค้นหา / ล้างการค้นหา -->
                            </div>
                        </div>


                    </div>
                </form>

                <section id="ostDODataTableDocument" style="margin-bottom:15px;"></section>

            </div>
        </div>
    </div>
</div>


<script>
    $('document').ready(function(){
        $('.selectpicker').selectpicker();

        $('.xCNDatePicker').datepicker({
            format: "yyyy-mm-dd",
            todayHighlight: true,
            enableOnReadonly: false,
            disableTouchKeyboard : true,
            autoclose: true
        });

        // Doc Date From
        $('#obtDODocDateForm').unbind().click(function(){
            $('#oetDODocDateForm').datepicker('show');
        });

        // Doc Date To
        $('#obtDODocDateTo').unbind().click(function(){
            $('#oetDODocDateTo').datepicker('show');
        });

        var aDOAdvSearch = JSON.parse(localStorage.getItem("oDOAdvSearch"));
        if ( aDOAdvSearch != null ) {
            $('#ohdDOFrmBchCode').val(aDOAdvSearch['tDOFrmBchCode']);
            $('#oetDOFrmBchName').val(aDOAdvSearch['tDOFrmBchName']);
            $('#ohdDOToBchCode').val(aDOAdvSearch['tDOToBchCode']);
            $('#oetDOToBchName').val(aDOAdvSearch['tDOToBchName']);
            $('#oetDODocDateForm').val(aDOAdvSearch['tDODocDateForm']);
            $('#oetDODocDateTo').val(aDOAdvSearch['tDODocDateTo']);
            $('#ocmDOStaDoc').val(aDOAdvSearch['tDOStaDoc']);
            $('#oetDODocNo').val(aDOAdvSearch['tDODocNo']);
            $('#ohdDOPageCurrent').val(aDOAdvSearch['nPageCurrent']);
        }

    });

    function JSvDOApvDocMulti(){
        $('#odvDOModalApvDocMultiple').modal('show');
    }

    $('#ocmDODocType').on('change', function() {
        if (this.value == 0) {
            $('#odvDOStaDocTBO').hide();
            $('#odvDOStaDocTRB').show();
            $('#odvDOStaDocTBI').hide();
        }else if(this.value == 1){
            $('#odvDOStaDocTBO').show();
            $('#odvDOStaDocTRB').hide();
            $('#odvDOStaDocTBI').hide();
        }else{
            $('#odvDOStaDocTBO').hide();
            $('#odvDOStaDocTRB').hide();
            $('#odvDOStaDocTBI').show();
        }
    });

    $('#oahDOSearchReset').unbind().click(function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            localStorage.removeItem("oDOAdvSearch");
            $('#ofmDOSearchData').find('input').val('');
            JSvDOCallPageList();
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    // ล้างค่า Input ทั้งหมดใน Advance Search
    // function JSxDOClearAdvSearchData(){
    //     var nStaSession = JCNxFuncChkSessionExpired();
    //     if(typeof nStaSession !== "undefined" && nStaSession == 1){
    //         localStorage.removeItem("DO_LocalItemDataApv");
    //         // $('#ofmDOSearchData').find('input').val('');
    //         JSvDOCallPageList();
    //     }else{
    //         JCNxShowMsgSessionExpired();
    //     }
    // }

    // รวม Values ต่างๆของการค้นหาขั้นสูง
    // function JSoDOGetAdvanceSearchData() {
    //     var aLocalValue = JSON.parse(localStorage.getItem("aValues"));
    //     var tOldData = localStorage.tCheckBackStageData;
    //     if (tOldData == 'monDocTransferData') {
    //         var oAdvanceSearchData = {
    //             tBchCode            : aLocalValue.tBchCode,
    //             tDocType            : aLocalValue.tDocType,
    //             tStaDocTRB          : aLocalValue.tStaDocTRB,
    //             tStaDocTBO          : aLocalValue.tStaDocTBO,
    //             tStaDocTBI          : aLocalValue.tStaDocTBI,
    //             tDocNo              : aLocalValue.tDocNo,
    //             tDocDateForm        : aLocalValue.tDocDateForm,
    //             tDocDateTo          : aLocalValue.tDocDateTo
    //         };
    //     }else{
    //         var oAdvanceSearchData = {
    //             tBchCode            : $("#ohdDOBchCode").val(),
    //             tStaDoc             : $("#ocmStaDoc").val(),
    //             tDocNo              : $("#oetDODocNo").val().trim(),
    //             tDocDateForm        : $("#oetDODocDateForm").val(),
    //             tDocDateTo          : $("#oetDODocDateTo").val()
    //         };
    //     }

        
    //     return oAdvanceSearchData;
    // }

    // จากสาขา
    $('#obtDOBrowseFrmBch').unbind().click(function() {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
            JSxCheckPinMenuClose(); // Hidden Pin Menu
            oDOBrowseBch = oDOBrowseBchCode({
                'tReturnInputCode': 'ohdDOFrmBchCode',
                'tReturnInputName': 'oetDOFrmBchName',
            });
            JCNxBrowseData('oDOBrowseBch');
        } else {
            JCNxShowMsgSessionExpired();
        }
    });
    // จากสาขา

    // ถึงสาขา
    $('#obtDOBrowseToBch').unbind().click(function() {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
            JSxCheckPinMenuClose(); // Hidden Pin Menu
            oDOBrowseBch = oDOBrowseBchCode({
                'tReturnInputCode': 'ohdDOToBchCode',
                'tReturnInputName': 'oetDOToBchName',
            });
            JCNxBrowseData('oDOBrowseBch');
        } else {
            JCNxShowMsgSessionExpired();
        }
    });
    // ถึงสาขา
    

    
    var tUsrLevel 	  	    = "<?=$this->session->userdata("tSesUsrLevel");?>";
    var tBchCodeMulti 	    = "<?=$this->session->userdata("tSesUsrBchCodeMulti");?>";
    // var nCountBch 		= "<?=$this->session->userdata("nSesUsrBchCount"); ?>";
    var nLangEdits      = "<?=$this->session->userdata("tLangEdit")?>";
    // var tWhere 			= "";

    // if(nCountBch == 1){
    //     $('#obtDOBrowseBch').attr('disabled',true);
    // }
    // if(tUsrLevel != "HQ"){
    //     tWhere = " AND TCNMBranch.FTBchCode IN ("+tBchCodeMulti+") ";
    // }else{
    //     tWhere = "";
    // }

    var oDOBrowseBchCode = function(poReturnInputBch) {
        let tInputReturnCode    = poReturnInputBch.tReturnInputCode;
        let tInputReturnName    = poReturnInputBch.tReturnInputName;
        // var tWhere              = '';
        var tSQLWhereBch        = '';
        
        if(tUsrLevel != "HQ"){
            tSQLWhereBch = " AND TCNMBranch.FTBchCode IN ("+tBchCodeMulti+")";
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
                Condition: [tSQLWhereBch]
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