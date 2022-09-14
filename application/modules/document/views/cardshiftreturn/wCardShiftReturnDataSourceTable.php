<?php
if ($aDataList['rtCode'] == '1') {
    $nCurrentPage = $aDataList['rnCurrentPage'];
} else {
    $nCurrentPage = '1';
}
?>
<style>
    .xWImpStaSuccess {
        color: #007b00 !important;
        font-size: 18px !important;
        font-weight: bold;
    }

    .xWImpStaInProcess {
        color: #7b7f7b !important;
        font-size: 18px !important;
        font-weight: bold;
    }

    .xWImpStaUnsuccess {
        color: #f60a0a !important;
        font-size: 18px !important;
        font-weight: bold;
    }
</style>
<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">

            <span class="hidden" id="ospCardShiftReturnCardCodeTemp"><?php echo $tDataListAll; ?></span>
            <input type="hidden" id="ohdCardShiftReturnCountRowFromTemp" name="ohdCardShiftStatusCountRowFromTemp" value="<?php echo $rnAllRow; ?>">
            <input type="hidden" id="ohdCardShiftCountSuccess" name="ohdCardShiftCountSuccess" value="<?php echo FSnSelectCountResultSuccess('TFNTCrdShiftTmp'); ?>">

            <table class="table table-striped" id="otbCardShiftReturnCardTable">
                <thead>
                    <th nowrap class="xCNTextBold text-center" style="width:5%;"><?php echo language('common/main/main', 'tCMNSequence'); ?></th>
                    <th nowrap class="xCNTextBold text-center" style="width:20%;"><?php echo language('document/card/cardreturn', 'tCardShiftReturnTBCode'); ?></th>
                    <th nowrap class="xCNTextBold text-center" style="width:20%;"><?php echo language('document/card/cardreturn', 'tCardShiftReturnTBCardStatus'); ?></th>
                    <th nowrap class="xCNTextBold text-center" style="width:15%;"><?php echo language('document/card/cardreturn', 'tCardShiftReturnTBProcessStatus'); ?></th>
                    <th nowrap class="xCNTextBold text-center" style="width:15%;"><?php echo language('document/card/cardreturn', 'tCardShiftReturnTBRmk'); ?></th>
                    <!-- <th nowrap class="xCNTextBold text-center" style="width:15%;"><?php echo language('document/card/cardreturn', 'tCardShiftReturnTBEdit'); ?></th> -->
                    <th nowrap class="xCNTextBold text-center" style="width:10%;"><?php echo language('document/card/cardreturn', 'tCardShiftReturnTBDelete'); ?></th>
                </thead>
                <tbody id="otbCardShiftReturnDataSourceList">
                    <?php if ($aDataList['rtCode'] == 1) : ?>
                        <?php foreach ($aDataList['raItems'] as $key => $aValue) : ?>
                            <?php
                            // สถานะบัตร
                            if ($aValue['FTXsdStaCrd'] == '1') {
                                $tClassSta      = "xWImpStaSuccess";
                                $tTextStaCrd    = language('document/card/main', 'tMainSuccess');
                                $tStatusCard    = '<img class="xCNIconTable" src="' . base_url() . 'application/modules/common/assets/images/icons/OK-Approve.png"> <span class="text-success">' . $tTextStaCrd . '</span>';
                            } else {
                                $tClassSta      = "xWImpStaUnsuccess";
                                $tTextStaCrd    = language('document/card/main', 'tMainUnSuccess');
                                $tStatusCard    = '<img class="xCNIconTable" src="' . base_url() . 'application/modules/common/assets/images/icons/cancel.png"> <span class="text-danger">' . $tTextStaCrd . '</span>';
                            }

                            $tProcess = '';
                            // ประมวลผลบัตร
                            if ($tStaPrcDoc == "1" || $tStaPrcDoc == "2") { // Document Processing or Approved
                                $tDisabled = 'disabled';
                                $tColorInput = '';
                                if ($tStaPrcDoc == "1") { // Document Is Approved
                                    if ($aValue['FTXsdStaPrc'] == "1") { // Card Is Process Success
                                        $tProcess = language('document/card/main', 'tMainSuccessProcessed');
                                    }
                                    if ($aValue['FTXsdStaPrc'] == "2") { // Card Is Process Unsuccess
                                        $tProcess = language('document/card/main', 'tMainUnsuccessProcessed');
                                    }
                                }
                                if ($tStaPrcDoc == "2") { // Document Is Processing
                                    $tProcess = language('document/card/main', 'tMainProcessing');
                                }
                            } else {
                                $tColorInput = 'style="    
                                background: rgb(270, 270, 270);
                                box-shadow: 0px 0px 0px inset;
                                border-top: 0px !important;
                                border-left: 0px !important;
                                border-right: 0px !important;
                                padding: 0px;
                                text-align: left;
                                min-width: 100px;"';
                                $tDisabled = '';
                                if (empty($aValue['FTXsdStaPrc'])) { // Card Is Waiting Process
                                    $tProcess = language('document/card/main', 'tMainWaitingForProcessing');
                                }
                                if ($tStaDoc == "3") { // Document Is Cancle
                                    $tProcess = 'N/A';
                                }
                            }

                            // สถานะเอกสาร
                            $tDisabledStye = "";
                            $tStaDocProcess = "";
                            if ($tStaPrcDoc == "1" || $tStaPrcDoc == "2") { // Document Processing or Approved
                                $tDisabledStye = 'style="opacity: 0.2; cursor: default;"';
                                if ($tStaPrcDoc == "1") {
                                    $tStaDocProcess = '<img class="xCNIconTable" src="' . base_url() . '/application/assets/icons/OK-Approve.png"> <span class="text-success">' . language('document/card/cardstatus', 'tCardShiftStatusTBApproved') . '</span>';
                                }
                                if ($tStaPrcDoc == "2") {
                                    $tStaDocProcess = language('document/card/cardstatus', 'tCardShiftStatusTBProcessing');
                                }
                            } else { // Document cancel status
                                if ($tStaDoc == "3") {
                                    $tStaDocProcess = 'N/A';
                                    $tDisabledStye = 'style="opacity: 0.2; cursor: default;"';
                                }
                            }

                            $tDisabledBtn = "";
                            $tDisabledRmk = "";

                            if ($tStaPrcDoc == "1" || $tStaPrcDoc == "2" || $tStaDoc == "3") { // Document Processing or Approved
                                $tDisabledBtn = "disabled";
                                $tDisabledRmk = "disabled";
                            }
                            ?>

                            <tr 
                            class="text-center xCNTextDetail2 xWCardShiftReturnDataSource" 
                            id="otrCardShiftReturnDataSource<?php echo $aValue['rtRowID']; ?>" 
                            data-sta-card="<?php echo $aValue['FTXsdStaCrd']; ?>" 
                            data-seq="<?php echo $aValue['FNXsdSeqNo']; ?>">

                                <td nowrap class="text-center"><?php echo $aValue['rtRowID']; ?></td>
                                <!-- <td nowrap class="xWCardShiftReturnCardCode text-left">
                                    <input id="oetCardShiftReturnCardName<?php echo $aValue['rtRowID']; ?>" name="oetCardShiftReturnCardName<?php echo $aValue['rtRowID']; ?>" type="text" disabled="true" value="<?php echo $aValue['FTCrdCode']; ?>">
                                    <input id="oetCardShiftReturnCardCode<?php echo $aValue['rtRowID']; ?>" type="hidden" value="<?php echo $aValue['FTCrdCode']; ?>">
                                </td> -->
                                <td nowrap class="xWCardShiftReturnCardCode text-left">
                                    <div class="input-group">
                                        <input 
                                        data-seq="" 
                                        class="form-control xCNPdtEditInLine xWValueEditInLine<?php echo $aValue['rtRowID']; ?> " 
                                        id="oetCardShiftReturnCardName<?php echo $aValue['rtRowID']; ?>" 
                                        name="oetCardShiftReturnCardName<?php echo $aValue['rtRowID']; ?>" 
                                        type="text" 
                                        disabled="true" 
                                        value="<?php echo $aValue['FTCrdCode']; ?>" 
                                        style="width: 100%;">
                                        <input 
                                        data-seq="" 
                                        id="oetCardShiftReturnCardCode<?php echo $aValue['rtRowID']; ?>" 
                                        class="form-control xCNPdtEditInLine xWValueEditInLine<?php echo $aValue['rtRowID']; ?>" 
                                        name="oetCardShiftReturnCardCode<?php echo $aValue['rtRowID']; ?>" 
                                        type="hidden" 
                                        value="<?php echo $aValue['FTCrdCode']; ?>">
                                        <span class="input-group-btn">
                                            <button 
                                            <?php echo $tDisabledBtn; ?> 
                                            id="obtCardShiftReturnCardName<?php echo $aValue['rtRowID']; ?>" 
                                            type="button" 
                                            class="btn xCNBtnBrowseAddOn">
                                                <img src="<?php echo base_url('/application/modules/common/assets/images/icons/find-24.png'); ?>">
                                            </button>
                                        </span>
                                    </div>
                                </td>
                                <td nowrap class="xWCardShiftReturnStatus text-left">
                                    <?php echo $tStatusCard; ?>
                                    <input type="hidden" class="xWCardShiftReturnStatusCard" value="<?php echo $aValue['FTXsdStaCrd']; ?>">
                                </td>
                                <td nowrap class="text-left"><?php echo $tProcess; ?></td>
                                <td nowrap class="text-left xWNextInput">
                                <?php if ($aValue['FTXsdStaCrd'] != 1) { ?>
                                    <label><?php echo $aValue['FTXsdRmk']; ?></label>
                                <?php } else { ?>
                                    <input 
                                    <?php echo $tDisabledRmk; ?> 
                                    <?php echo $tColorInput; ?> 
                                    type="text" 
                                    class="form-control xWCardShiftReturnCardRmk xCNPdtEditInLine xWValueEditInLine<?php echo $aValue['rtRowID']; ?> " 
                                    style="text-align: left;" 
                                    id="oetCardShiftReturnCardRmk<?php echo $aValue['rtRowID']; ?>" 
                                    name="oetCardShiftReturnCardRmk<?php echo $aValue['rtRowID']; ?>" 
                                    value="<?php echo $aValue['FTXsdRmk']; ?>">
                                <?php } ?>
                                </td>
                                <td nowrap class="text-center">
                                    <img 
                                    <?php echo $tDisabledStye; ?> 
                                    class="xCNIconTable" 
                                    src="<?php echo base_url('application/modules/common/assets/images/icons/delete.png'); ?>" 
                                    onClick="JSxCardShiftReturnDataSourceDeleteOperator(this, event, <?php echo $nPage; ?>, '<?php echo $aValue['FTCrdCode']; ?>', <?php echo $aValue['FNXsdSeqNo']; ?>)">
                                </td>
                                <script>
                                    $(document).ready(function() {
                                        $('#obtCardShiftReturnCardName<?php echo $aValue['rtRowID']; ?>').click(function() {
                                            window.oCardShiftReturnBrowseCardOption<?php echo $aValue['rtRowID']; ?> = oCardShiftReturnBrowseCard<?php echo $aValue['rtRowID']; ?>(JStCardShiftReturnGetCardCodeTemp());
                                            JCNxBrowseData('oCardShiftReturnBrowseCardOption<?php echo $aValue['rtRowID']; ?>');
                                        });
                                    });
                                    var nLangEdit = <?php echo $this->session->userdata("tLangEdit"); ?>;
                                    var oCardShiftReturnBrowseCard<?php echo $aValue['rtRowID']; ?> = function(ptNotCardCode) {
                                        let tNotIn = "";
                                        if (!ptNotCardCode == "") {
                                            tNotIn = "AND TFNMCard.FTCrdCode NOT IN (" + ptNotCardCode + ")";
                                        }
                                        let oOptions = {
                                            Title: ['payment/card/card', 'tCRDTitle'],
                                            Table: {
                                                Master: 'TFNMCard',
                                                PK: 'FTCrdCode',
                                                PKName: 'FTCrdName'
                                            },
                                            Join: {
                                                Table: ['TFNMCard_L','TFNMCardType'],
                                                On: [
                                                    'TFNMCard_L.FTCrdCode = TFNMCard.FTCrdCode AND TFNMCard_L.FNLngID = ' + nLangEdits,
                                                    'TFNMCardType.FTCtyCode = TFNMCard.FTCtyCode'
                                                ]
                                            },
                                            Where: {
                                                // Condition: [" AND (TFNMCardType.FTCtyStaShift = '1') AND (TFNMCard.FTCrdStaActive = '1') AND (TFNMCard.FTCrdStaShift = '1') AND (CONVERT(date, TFNMCard.FDCrdExpireDate) > CONVERT(date, GETDATE())) " + tNotIn]
                                                Condition: ["AND ( ((TFNMCardType.FTCtyStaShift = '1') AND (TFNMCard.FTCrdStaShift = '2')) )" + tNotIn]
                                            },
                                            GrideView: {
                                                ColumnPathLang: 'payment/card/card',
                                                ColumnKeyLang: ['tCRDTBCode', 'tCRDTBName', ''],
                                                // ColumnsSize     : ['15%', '85%'],
                                                WidthModal: 50,
                                                DataColumns: ['TFNMCard.FTCrdCode', 'TFNMCard_L.FTCrdName', 'TFNMCard.FTCrdHolderID'],
                                                DisabledColumns: [2],
                                                DataColumnsFormat: ['', '', ''],
                                                Perpage: 10,
                                                OrderBy: ['TFNMCard_L.FTCrdName'],
                                                SourceOrder: "ASC"
                                            },
                                            CallBack: {
                                                // StaDoc: '2',
                                                ReturnType: 'S',
                                                Value: ["oetCardShiftReturnCardCode<?php echo $aValue['rtRowID']; ?>", "TFNMCard.FTCrdCode"],
                                                Text: ["oetCardShiftReturnCardName<?php echo $aValue['rtRowID']; ?>", "TFNMCard.FTCrdCode"]
                                            },
                                            NextFunc: {
                                                FuncName: 'JSxCardShiftReturnCallBackCardChange',
                                                ArgReturn: ['FTCrdCode', 'FTCrdHolderID']
                                            },
                                            // RouteFrom : 'cardShiftChange',
                                            RouteAddNew: 'card',
                                            BrowseLev: nStaCardShiftReturnBrowseType
                                        };
                                        return oOptions;
                                    };
                                </script>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr id="otrCardShiftReturnNoData">
                            <td nowrap class='text-center xCNTextDetail2' colspan='999'><?php echo language('common/main/main', 'tCMNNotFoundData'); ?></td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="row">
    <!-- เปลี่ยน -->
    <div class="col-md-6">
        <p><?= language('common/main/main', 'tResultTotalRecord') ?> <?= $aDataList['rnAllRow'] ?> <?= language('common/main/main', 'tRecord') ?> <?= language('common/main/main', 'tCurrentPage') ?> <?= $aDataList['rnCurrentPage'] ?> / <?= $aDataList['rnAllPage'] ?></p>
    </div>
    <!-- เปลี่ยน -->
    <div class="col-md-6">
        <input type="hidden" id="ohdCardShiftReturnDataSourceCurrentPage" value="<?php echo $nPage ?>">
        <div class="xWCardShiftReturnDataSourcePage btn-toolbar pull-right">
            <!-- เปลี่ยนชื่อ Class เป็นของเรื่องนั้นๆ -->
            <?php if ($nPage == 1) {
                $tDisabledLeft = 'disabled';
            } else {
                $tDisabledLeft = '-';
            } ?>
            <button onclick="JSvCardShiftReturnDataSourceClickPage('previous','<?= $ptDocType ?>','<?= $tIDElement ?>')" class="btn btn-white btn-sm" <?php echo $tDisabledLeft ?>>
                <!-- เปลี่ยนชื่อ Onclick เป็นของเรื่องนั้นๆ -->
                <i class="fa fa-chevron-left f-s-14 t-plus-1"></i>
            </button>
            <?php for ($i = max($nPage - 2, 1); $i <= max(0, min($aDataList['rnAllPage'], $nPage + 2)); $i++) { ?>
                <!-- เปลี่ยนชื่อ Parameter Loop เป็นของเรื่องนั้นๆ -->
                <?php
                if ($nPage == $i) {
                    $tActive = 'active';
                    $tDisPageNumber = 'disabled';
                } else {
                    $tActive = '';
                    $tDisPageNumber = '';
                }
                ?>
                <!-- เปลี่ยนชื่อ Onclick เป็นของเรื่องนั้นๆ -->
                <button onclick="JSvCardShiftReturnDataSourceClickPage('<?php echo $i ?>','<?= $ptDocType ?>','<?= $tIDElement ?>')" type="button" class="btn xCNBTNNumPagenation <?php echo $tActive ?>" <?php echo $tDisPageNumber ?>><?php echo $i ?></button>
            <?php } ?>
            <?php if ($nPage >= $aDataList['rnAllPage']) {
                $tDisabledRight = 'disabled';
            } else {
                $tDisabledRight = '-';
            } ?>
            <button onclick="JSvCardShiftReturnDataSourceClickPage('next','<?= $ptDocType ?>','<?= $tIDElement ?>')" class="btn btn-white btn-sm" <?php echo $tDisabledRight ?>>
                <!-- เปลี่ยนชื่อ Onclick เป็นของเรื่องนั้นๆ -->
                <i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
            </button>
        </div>
    </div>
</div>
<!-- Modal Delete Table -->
<div class="modal fade" id="odvCardShiftReturnModalConfirmDelRecord">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header xCNModalHead">
                <label class="xCNTextModalHeard"><?php echo language('common/main/main', 'tModalDelete') ?></label>
            </div>
            <div class="modal-body">
                <span class="xCNTextModal" style="display: inline-block; word-break:break-all"><?php echo language('common/main/main', 'tModalDeleteSingle'); ?> <span id="ospCardShiftReturnConfirDelMessage"></span></span>
            </div>
            <div class="modal-footer">
                <button id="osmCardShiftReturnConfirmDelRecord" type="button" class="btn xCNBTNPrimery">
                    <?php echo language('common/main/main', 'tModalConfirm'); ?>
                </button>
                <button type="button" class="btn xCNBTNDefult" data-dismiss="modal">
                    <?php echo language('common/main/main', 'tModalCancel'); ?>
                </button>
            </div>
        </div>
    </div>
</div>
<!-- End Modal Delete Table -->

<script>
    $('.xCNPdtEditInLine').off().on('change keyup', function(e) {
        if (e.type === 'change' || e.keyCode === 13) {
            if (e.type === 'change') {}
            JSxCardShiftReturnDataSourceSaveOperator(this, event, $(this).data('seq'), <?php echo $nPage; ?>);
        }
    });
</script>