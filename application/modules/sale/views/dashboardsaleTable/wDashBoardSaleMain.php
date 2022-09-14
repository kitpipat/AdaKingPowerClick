<style>
    .xWDSHSALHeadPanel {
        border-bottom: 1px solid #cfcbcb8a !important;
        padding-bottom: 0px !important;
    }

    .xWDSHSALTextNumber {
        font-size: 25px !important;
        font-weight: bold;
    }

    .xWDSHSALPanelMainRight {
        padding-bottom: 0px;
        min-height: 300px;
        overflow-x: auto;
    }

    .xWDSHSALFilter {
        cursor: pointer;
    }

    .xWOverlayLodingChart {
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

    .xCNTextDetailDB {
        font-size: 20px  !important;
        font-weight: bold;
        color: black;
    }
</style>




<div class="row">
   \

    <!-- Panel ข้อมูลการขาย ตามสาขา ตามจุดขาย -->


    
      
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div id="odvDSHSALPanelLeft5" class="panel panel-default">
                    <div class="panel-collapse collapse in" role="tabpanel">
                        <div class="panel-body" style="padding-bottom:0px;">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="panel-body" style="padding-bottom:0px;">
                                        <div class="row xWDSHSALHeadPanel">
                                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 p-l-0">
                                                <label class="xCNTextDetailDB"><?php echo @$aTextLang['tDSHSALTotalByBranch']; ?></label>
                                            </div>
                                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 p-r-0 text-right">
                                                <i class="fa fa-filter xWDSHSALFilter" aria-hidden="true" data-keyfilter="FBB" data-keygrp="BCH,POS,DIF"></i>
                                            </div>
                                        </div>
                                        <div class="row xWDSHSALDataPanel">
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
   

    <!-- input ค่า sort กับ ฟิวช์ ที่ส่งไป query ของ Total By Branch -->
    <input type="hidden" id="oetDSHSALSort" name="oetDSHSALSort" value="">
    <input type="hidden" id="oetDSHSALFild" name="oetDSHSALFild" value="FTBchName,FTPosCode">
    <input type="hidden" id="oetDSHSALUserCode" name="oetDSHSALUserCode" value="<?php echo $this->session->userdata("tSesUserCode"); ?>">




</div>
<div id="odvDSHSALModalFilterHTML"></div>
<script type="text/javascript">
    $(document).ready(function() {

        $('.xWDSHSALFilter').unbind().click(function() {
            let nStaSession = JCNxFuncChkSessionExpired();
            if (typeof(nStaSession) !== "undefined" && nStaSession == 1) {
                let tFilterDataKey = $(this).data('keyfilter');
                let tFilterDataGrp = $(this).data('keygrp');
                JSvDSHSALCallModalFilterDashBoard(tFilterDataKey, tFilterDataGrp);
            } else {
                JCNxShowMsgSessionExpired();
            }
        });
    });
</script>