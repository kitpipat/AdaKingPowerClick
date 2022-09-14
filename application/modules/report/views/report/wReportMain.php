<style>
    .xWPanelHeadMenuRpt {
        padding-top: 10px !important;
        padding-bottom: 10px !important;
        padding-left: 15px !important;
    }

    .xCNPanelHeadBGColor{
        background-color : #FFF !important;
    }

    #odvModalReportPrograssExport .xCNModalHead i{
        color: #08f93e !important;
    }

    #odvModalReportPrograssExport .xCNModalHead #ospRptHeader{
        font-size: 23px !important;
        font-weight: bold !important;
        color: #08f93e !important;
    }

    #odvModalReportPrograssExport .xCNMessage{
        font-size: 22px !important;
        font-weight: bold !important;
    }

    .xCNTableScrollY{
        overflow-y      : auto;
        /* max-height      : 200px; */
    }

    .xCNTextDetail1{
        font-size       : 18px !important;
        font-weight     : bold;
        text-align      : left;
    }

    .xCNTableBorder thead th, .xCNTableBorder>thead>tr>th, .xCNTableBorder tbody tr, .xCNTableBorder>tbody>tr>td{
        border          : 0px solid red !important;
    }

</style>
<?php if(isset($aDataRptMenu) && $aDataRptMenu['rtCode'] == 1): ?>
    <div class="row">
        <div class="col-xs-12 col-sm-6 col-md-5 col-lg-5">
            <?php $tMnuGrpCode  = ""; ?>
            <?php foreach($aDataRptMenu['raItems'] AS $nKey1 => $aRptValue1):?>
                <?php if($tMnuGrpCode != $aRptValue1['FTRptGrpCode']):?>
                    <?php $tMnuGrpCode = $aRptValue1['FTRptGrpCode'];?>
                    <?php
                        if($nKey1 == 0){
                            $tIconCollapsed     = "";
                            $tContentCollapse   = "collapse in";
                            $tExpandedChk       = "true";
                            $tFirstRowData      = " xCNFirstTbl";
                        }else{
                            $tIconCollapsed     = "collapsed";
                            $tContentCollapse   = "collapse";
                            $tExpandedChk       = "false";
                            $tFirstRowData      = "";
                        }
                    ?>
                    <div class="panel panel-default" style="margin-bottom: 25px;">
                        <div id="odvHead<?php echo $aRptValue1['FTRptGrpCode'];?>" class="panel-heading xCNPanelHeadBGColor xWPanelHeadMenuRpt" role="tab">
                            <label class="xCNTextDetail1"><?php echo $aRptValue1['FTRptGrpName'];?></label>
                            <a class="xCNMenuplus <?php echo $tIconCollapsed;?>" role="button" data-toggle="collapse"  href="#odvRptData<?php echo $aRptValue1['FTRptGrpCode'];?>" aria-expanded="<?php echo $tExpandedChk;?>">
                                <i class="fa fa-plus xCNPlus"></i>
                            </a>
                        </div>
                        <div id="odvRptData<?php echo $aRptValue1['FTRptGrpCode'];?>" class="xCNMenuPanelData panel-collapse <?php echo $tContentCollapse;?>" role="tabpanel" aria-expanded="<?php echo $tExpandedChk;?>">
                            <div class="panel-body xCNPDModlue" style="padding:7px;">
                                <div class="table-responsive xCNTableScrollY">
                                    <table id="otbRpt<?php echo $aRptValue1['FTRptGrpCode'];?>" class="table xCNTableBorder xCNTableRpt<?php echo $tFirstRowData;?>" style="margin:0;">
                                        <tbody>
                                            <?php $tMnuRptCode  = ""; ?>
                                            <?php $tMnuRptSeq   = 1; ?>
                                            <?php foreach($aDataRptMenu['raItems'] AS $nKey2 => $aRptValue2):?>
                                                <?php if($tMnuGrpCode == $aRptValue2['FTRptGrpCode'] && $tMnuRptCode != $aRptValue2['FTRptCode']):?>
                                                    <?php if(!empty($aRptValue2['FTRptModCode']) && !empty($aRptValue2['FTRptGrpCode']) && !empty($aRptValue2['FTRptCode'])): ?>
                                                        <tr>
                                                            <td
                                                                class="xCNRPTSelect"
                                                                role="tab"
                                                                data-toggle="tab"
                                                                data-rptmodcode="<?php echo $aRptValue2['FTRptModCode'];?>"
                                                                data-rptgrpcode="<?php echo $aRptValue2['FTRptGrpCode'];?>"
                                                                data-rptcode="<?php echo $aRptValue2['FTRptCode'];?>"
                                                                data-rptname="<?php echo $aRptValue2['FTRptName']?>"
                                                                data-rptroute="<?php echo $aRptValue2['FTRptRoute'];?>"
                                                                aria-expanded="true"
                                                            >
                                                            <?php echo $tMnuRptSeq.". ".$aRptValue2['FTRptName'];?>
                                                            </td>
                                                        </tr>
                                                    <?php endif;?>
                                                    <?php $tMnuRptCode = $aRptValue2['FTRptCode']; ?>
                                                    <?php $tMnuRptSeq++; ?>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif;?>
            <?php endforeach; ?>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-7 col-lg-7">
            <div class="panel panel-default" style="margin-bottom: 25px;">
                <!-- <div id="odvRptAllConditionPanel" class="panel-heading xCNPanelHeadColor xWPanelHeadMenuRpt">
                    <label class="xCNTextDetail1"><?php echo language('report/report/report','tPanelCondition');?></label>
                </div> -->
                <div id="odvConditonSearchRptAll" class="panel-collapse collapse in" role="tabpanel">
                    <form action="javascript:void(0);" id="ofmRptConditionFilter">
                        <input type="hidden" id="ohdRptTypeExport" name="ohdRptTypeExport">
                        <input type="hidden" id="ohdRptModCode" name="ohdRptModCode">
                        <input type="hidden" id="ohdRptGrpCode" name="ohdRptGrpCode">
                        <input type="hidden" id="ohdRptCode" name="ohdRptCode">
                        <input type="hidden" id="ohdRptName" name="ohdRptName">
                        <input type="hidden" id="ohdRptRoute" name="ohdRptRoute">
                        <div class="panel-body xCNPDModlue">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" id="ohdReDownloadTextMsgHead"      value="<?php echo language('common/main/main','tReDownloadTextMsgHead');?>">
    <input type="hidden" id="ohdReDownloadTextMsgYesOrNo"   value="<?php echo language('common/main/main','tReDownloadTextMsgYesOrNo');?>">
    <input type="hidden" id="ohdReDownloadWhenDate"         value="<?php echo language('common/main/main','tReDownloadWhenDate');?>">
    <input type="hidden" id="ohdRptNotFoundDataInDBTemp"    value="<?php echo language('common/main/main','tRptNotFoundDataInDBTemp');?>">
    <input type="hidden" id="ohdRptTitleModalProgress"      value="<?php echo language('common/main/main','tRptTitleModalProgress');?>">
    <input type="hidden" id="ohdRptRederExcelFile"          value="<?php echo language('common/main/main','tRptRederExcelFile');?>">
    <input type="hidden" id="ohdRptProcessZipFile"          value="<?php echo language('common/main/main','tRptProcessZipFile');?>">
    <input type="hidden" id="ohdRptProcessExportSuccess"    value="<?php echo language('common/main/main','tRptProcessExportSuccess');?>">
    <input type="hidden" id="ohdRptTextFileAllAndSuccess"   value="<?php echo language('common/main/main','tRptTextFileAllAndSuccess');?>">
    <input type="hidden" id="ohdRptTextErrorZipFile"        value="<?php echo language('common/main/main','tRptErrorZipFile');?>">
    <div id="odvRptAppendBtnDownload"></div>
    <!-- ==================================================================== Modal Report Prograss ===================================================================== -->
        <div id="odvModalReportPrograssExport" class="modal fade xWModalReport" tabindex="-1" role="dialog" style="overflow: hidden auto; z-index: 7000;">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header xCNModalHead">
                        <h3><i class="fa fa-info"></i> <span id="ospRptHeader"></span></h3>
                    </div>
                    <div class="modal-body">
                        <div class="xCNMessage"></div>
                        <div class="clearfix"></div>
                        <div class="text-center">
                            <div 
                                id="odvRptLodingBarProgress"
                                style="width:100%;height:2%;margin:auto;"
                                class="ldBar label-center"
                                data-preset="rainbow"
                                data-stroke="data:ldbar/res,stripe(#0097e6,#00a8ff,1)"
                                data-stroke-width="1.5"
                                data-value="0"
                            >
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button id="obtRptPgSkipDownload" class="btn btn-warning" type="button"><?php echo language('common/main/main','tSkipDownloadFile')?></button>
                        <button id="obtRptPgDownload" class="btn btn-info" type="button"><?php echo language('common/main/main','tDownloadFile')?></button>
                    </div>
                </div>
            </div>
        </div>
    <!-- ================================================================================================================================================================ -->


    <!-- ================================================================ Modal Report Re-Download File ================================================================= -->
        <div id="odvModalReportRedownload" class="modal fade xWModalReport" tabindex="-1" role="dialog" aria-labelledby="modalreportloadingdata" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header xCNModalHead">
                        <h3 style="font-size:20px;color:#08f93e;font-weight:1000;"><i class="fa fa-download"></i> <span><?php echo language('common/main/main','tReDownloadFile');?></span></h3>
                    </div>
                    <div class="modal-body">
                        <span id="ospTextFileNameDownload" class="xCNTextModal" style="display: inline-block; word-break:break-all"></span>
                    </div>
                    <div class="modal-footer">
                        <button id="obtRptCancelDownload" class="btn btn-danger" type="button"><?php echo language('common/main/main','tCancelDownloadFile')?></button>
                        <button id="obtRptSkipDownload" class="btn btn-warning" type="button"><?php echo language('common/main/main','tSkipDownloadFile')?></button>
                        <button id="obtRptDownload" class="btn btn-info" type="button"><?php echo language('common/main/main','tDownloadFile')?></button>
                    </div>
                </div>
            </div>
        </div>
    <!-- ================================================================================================================================================================ -->

    <!-- ================================================================ Modal Report กรุณากรอกข้อมูลให้ครบถ้วน ================================================================= -->
    <div id="odvModalWarningInputEmpty" class="modal fade xWModalReport" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header xCNModalHead">
                    <h3 style="font-size:20px;color:#FFF;font-weight:1000;">
                        <span><?=language('common/main/main','tModalWarning');?></span>
                    </h3>
                </div>
                <div class="modal-body">
                    <span class="xCNTextModal xCNWarningInputEmpty" style="display: inline-block; word-break:break-all"></span>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn xCNBTNPrimery"  data-dismiss="modal">
                        <?=language('common/main/main', 'tModalConfirm'); ?>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- ================================================================================================================================================================ -->

    <?php include "script/jReportMain.php";?>
<?php else:?>
    <script type="text/javascript">
        $(document).ready(function(){
            $('.odvMainContent').empty();
            var tReportTextNotFoundRole = '<?php echo language('report/report/report','tReportNotfoundRole');?>'
            FSvCMNSetMsgWarningDialog(tReportTextNotFoundRole);
            $('#odvModalWanning button').unbind().click(function(){
                location.reload();
            });
            JCNxCloseLoading();
        });
    </script>                 
<?php endif;?>

<script>
    $('.xCNMenuplus').unbind().click(function(){
        //เปิดแค่ panal เดียว
        if($(this).hasClass('collapsed')){
            $('.xCNMenuplus').removeClass('collapsed').addClass('collapsed');
            $('.xCNMenuPanelData').removeClass('in');
        }
    });
</script>

