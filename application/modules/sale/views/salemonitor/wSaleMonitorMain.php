<style>
    .xWSMTSALHeadPanel{
        /* border-bottom:1px solid #cfcbcb8a !important; */
        padding-bottom:0px !important;
    }

    .xWSMTSALTextNumber{
        font-size: 25px !important;
        font-weight: bold;
    }
    
    .xWSMTSALPanelMainRight{
        padding-bottom:0px;
        /* min-height:300px; */
        overflow-x: auto;
    }

    .xWSMTSALFilter{
        cursor: pointer;
    }

    .xWSMTSALRequest{
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
    <!-- input ค่า sort กับ ฟิวช์ ที่ส่งไป query ของ Total By Branch -->
    <input type="hidden" id="oetDSHSALSort" name="oetDSHSALSort" value="">
    <input type="hidden" id="oetDSHSALFild" name="oetDSHSALFild" value="FTBchName,FTPosCode">
    <input type="hidden" id="oetSMTPageCurrents" name="oetSMTPageCurrents" value="1">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <!-- Panel Sale Data -->
        <div id="odvSMTSALPanelRight1" class="">
            <div >
                <div class="panel-body xWSMTSALPanelMainRight">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="">
                                <div class="col-md-12 xWSMTSALHeadPanel">
                                    <div class="col-xs-12 col-sm-6 col-md-12 col-lg-12 p-l-0">
                                        <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8 text-left" style="padding:0px;margin-top:0.3rem; display: inline-flex;">
                                            <label class="xCNLabelFrm" style="margin-right: 10px; margin-top: 5px;"><?php echo @$aTextLang['tSMTSALDateDataFrom']; ?></label>
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <input type="text" class="form-control text-center xCNDatePicker xWPointerEventNone" id="oetSMTSALDateDataForm" name="oetSMTSALDateDataForm" value="<?php echo @$dFirstDateOfMonth; ?>">
                                                    <span class="input-group-btn">
                                                        <button id="obtSMTSALDateDataForm" type="button" class="btn xCNBtnBrowseAddOn"><img class="xCNIconCalendar"></button>
                                                    </span>
                                                </div>
                                            </div>

                                            <label class="xCNLabelFrm" style="margin-left: 10px;  margin-right: 10px; margin-top: 5px;"><?php echo @$aTextLang['tSMTSALDateDataTo']; ?></label>
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <input type="text" class="form-control text-center xCNDatePicker xWPointerEventNone" id="oetSMTSALDateDataTo" name="oetSMTSALDateDataTo" value="<?php echo @$dLastDateOfMonth; ?>">
                                                    <span class="input-group-btn">
                                                        <button id="obtSMTSALDateDataTo" type="button" class="btn xCNBtnBrowseAddOn"><img class="xCNIconCalendar"></button>
                                                    </span>
                                                </div>
                                            </div>

                                            <div class="form-group" style="margin-left: 10px;">
                                                <button id="obtSMTReload" class="btn btn-info" type="button">
                                                    <i class="fa fa-refresh" aria-hidden="true"></i> &nbsp; <?=language('sale/salemonitor/salemonitor', 'tSMTReload')?>
                                                </button>
                                            </div>

                                            <div class="form-group" style="margin-left: 10px;">
                                                <button id="obtSMTFilter" class="btn btn-info" type="button" data-keyfilter="FSD" data-keygrp="BCH,SHP,POS,USR">
                                                    <i class="fa fa-filter xWSMTSALFilter" aria-hidden="true"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            
                                <div class="col-md-12 xWSMTSALDataPanel"  id="odvPanelSaleData">
                            
                                </div>
                                <div class="xWOverlayLodingChart" data-keyfilter="FSD">
                                    <img src="<?php echo base_url(); ?>application/modules/common/assets/images/ada.loading.gif" class="xWImgLoading">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>

 
    </div>
</div>
<div id="odvSMTSALModalFilterHTML"></div>
<script type="text/javascript">
    $(document).ready(function(){

        $('.xCNDatePicker').datepicker({
            format: "yyyy-mm-dd",
            todayHighlight: true,
            enableOnReadonly: false,
            disableTouchKeyboard : true,
            autoclose: true
        });

        // Event Click Button Filter Date Data Form
        $('#obtSMTSALDateDataForm').unbind().click(function(){
            $('#oetSMTSALDateDataForm').datepicker('show');
        });

        // Event Click Button Filter Date Data To
        $('#obtSMTSALDateDataTo').unbind().click(function(){
            $('#oetSMTSALDateDataTo').datepicker('show');
        });


        // $('#oetSMTSALDateDataForm').change(function(){
        //     JCNxOpenLoading();
        //     JCNxSMTCallSaleDataTable();
        // });

        $('#oetSMTSALDateDataTo').change(function(){
            JCNxOpenLoading();
            JCNxSMTCallSaleDataTable();
        });

        $('#obtSMTFilter').unbind().click(function(){
            let nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== "undefined" && nStaSession == 1) {
                let tFilterDataKey  = $(this).data('keyfilter');
                let tFilterDataGrp  = $(this).data('keygrp');
                JSvSMTSALCallModalFilterDashBoard(tFilterDataKey,tFilterDataGrp,'1');
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        $('#ocbSMTRequestRepairing').unbind().click(function(){
            let nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== "undefined" && nStaSession == 1) {
            JSxSMTControlTableData();
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        $('#ocbSMTDataRequest').unbind().click(function(){
            let nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== "undefined" && nStaSession == 1) {
            JSxSMTControlTableData();
            }else{
                JCNxShowMsgSessionExpired();
            }
        });


        $('#ocbSMTInformationShitf').unbind().click(function(){
            // let nStaSession = JCNxFuncChkSessionExpired();
            // if(typeof(nStaSession) !== "undefined" && nStaSession == 1) {
            JSxSMTControlTableData();
            // }else{
            //     JCNxShowMsgSessionExpired();
            // }
         
        });
        
        let tFilterDataKey  = $('#obtSMTFilter').data('keyfilter');
        let tFilterDataGrp  = $('#obtSMTFilter').data('keygrp');
        JSvSMTSALCallModalFilterDashBoard(tFilterDataKey,tFilterDataGrp,'2');

        var oSMTPackDataSearch = JSON.parse(localStorage.getItem("oSMTPackDataSearch"));
        // console.log(oSMTPackDataSearch);
        if( oSMTPackDataSearch !== null ){
            $('#oetSMTSALDateDataForm').val(oSMTPackDataSearch['oetSMTSALDateDataForm']);
            $('#oetSMTSALDateDataTo').val(oSMTPackDataSearch['oetSMTSALDateDataTo']);
        }

        setTimeout(function() {
            JCNxSMTCallSaleDataTable();
        }, 500);
        
    });

    $('#obtSMTReload').click(function(){
        JCNxOpenLoading();
        JCNxSMTCallSaleDataTable();
    });



</script>
