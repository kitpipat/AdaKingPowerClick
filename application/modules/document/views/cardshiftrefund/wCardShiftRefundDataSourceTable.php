<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">

            <span class="hidden" id="ospCardShiftRefundCardCodeTemp"><?php echo $tDataListAll; ?></span>
            <input type="hidden" id="ohdCardShiftRefundCountRowFromTemp" name="ohdCardShiftRefundCountRowFromTemp" value="<?= $rnAllRow ?>">
            <input type="hidden" id="ohdCardShiftCountSuccess" name="ohdCardShiftCountSuccess" value="<?php echo FSnSelectCountResultSuccess('TFNTCrdTopUpTmp'); ?>">

            <table class="table table-striped" style="width:100%">
                <thead>
                    <tr>
                        <th nowrap class="xCNTextBold" style="width:5%;text-align:center;"><?= language('document/card/main', 'tMainNumber') ?></th>
                        <th nowrap class="xCNTextBold" style="width:200px;text-align:center;"><?= language('document/card/main', 'tExcelcardShiftRefundCode') ?></th>
                        <th nowrap class="xCNTextBold" style="text-align:center;"><?= language('document/card/main', 'tExcelcardShiftRefundValue') ?></th>
                        <th nowrap class="xCNTextBold" style="text-align:center;"><?= language('document/card/main', 'tExcelcardShiftRefundStatus') ?></th>
                        <th nowrap class="xCNTextBold" style="text-align:center;"><?= language('document/card/main', 'tExcelcardShiftRefundProcessStatus') ?></th>
                        <th nowrap class="xCNTextBold" style="text-align:center;"><?= language('document/card/main', 'tExcelcardShiftRefundRemark') ?></th>
                        <!-- <th nowrap class="xCNTextBold" style="width:10%;text-align:center;"><?= language('document/card/main', 'tMainEdit') ?></th> -->
                        <th nowrap class="xCNTextBold" style="width:10%;text-align:center;"><?= language('document/card/main', 'tMainDelete') ?></th>
                    </tr>
                </thead>
                <tbody id="otbCardShiftRefundDataSourceList">
                    <?php if ($aDataList['rtCode'] == 1) : ?>
                        <?php $nTotalResult = $aDataList['CountTopUP'][0]['Total']; ?>
                        <?php foreach ($aDataList['raItems'] as $key => $aValue) { ?>
                            <tr 
                            class="text-center xCNTextDetail2 xWCardShiftRefundDataSource" 
                            id="otrCardShiftRefundDataSource<?php echo $aValue['rtRowID']; ?>" 
                            data-sta-card="<?php echo $aValue['FTXsdStaCrd']; ?>"
                            data-seq="<?php echo $aValue['FNXsdSeqNo']; ?>">

                                <?php
                                $tFNSeq = $aValue['FNXsdSeqNo'];

                                // สถานะบัตร
                                if ($aValue['FTXsdStaCrd'] == '1') {
                                    $tClassSta = "xWImpStaSuccess";
                                    $tTextStaCrd = language('document/card/main', 'tMainSuccess');
                                    $tStatusCard = '<img class="xCNIconTable" src="' . base_url() . 'application/modules/common/assets/images/icons/OK-Approve.png"> <span class="text-success">' . $tTextStaCrd . '</span>';
                                } else {
                                    $tClassSta = "xWImpStaUnsuccess";
                                    $tTextStaCrd = language('document/card/main', 'tMainUnSuccess');
                                    $tStatusCard = '<img class="xCNIconTable" src="' . base_url() . 'application/modules/common/assets/images/icons/cancel.png"> <span class="text-danger">' . $tTextStaCrd . '</span>';
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
                                    $tColorInput = '   
                                    background: rgb(270, 270, 270);
                                    box-shadow: 0px 0px 0px inset;
                                    border-top: 0px !important;
                                    border-left: 0px !important;
                                    border-right: 0px !important;
                                    padding: 0px;
                                    min-width: 100px;';
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
                                        $tStaDocProcess = '<img class="xCNIconTable" src="' . base_url() . 'application/modules/common/assets/images/icons/OK-Approve.png"> <span class="text-success">' . language('document/card/cardstatus', 'tCardShiftStatusTBApproved') . '</span>';
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
                                <td nowrap class="text-center"> <?= $aValue['rtRowID'] ?></td>
                                <td nowrap class="xWCardShiftRefundCardCode text-left">
                                    <div class="input-group">
                                        <input 
                                        data-seq="" 
                                        class="form-control xCNPdtEditInLine- xWValueEditInLine<?php echo $aValue['rtRowID']; ?> " 
                                        id="oetCardShiftRefundCardCode<?php echo $aValue['rtRowID']; ?>" 
                                        name="oetCardShiftRefundCardCode<?php echo $aValue['rtRowID']; ?>" 
                                        type="text" 
                                        disabled="true" 
                                        value="<?php echo $aValue['FTCrdCode']; ?>" 
                                        style="width: 100%;">
                                        <input 
                                        data-seq="" 
                                        id="oetCardShiftRefundCardValueCode<?php echo $aValue['rtRowID']; ?>" 
                                        class="form-control xCNPdtEditInLine- xWValueEditInLine<?php echo $aValue['rtRowID']; ?>" 
                                        name="oetCardShiftRefundCardValueCode<?php echo $aValue['rtRowID']; ?>" 
                                        type="hidden" 
                                        value="<?php echo $aValue['FTCrdCode']; ?>">
                                        <span class="input-group-btn">
                                            <button <?php echo $tDisabledBtn; ?> id="obtCardShiftRefundCardCode<?php echo $aValue['rtRowID']; ?>" type="button" class="btn xCNBtnBrowseAddOn">
                                                <img src="<?php echo base_url('/application/modules/common/assets/images/icons/find-24.png'); ?>">
                                            </button>
                                        </span>
                                    </div>
                                </td>
                                <td nowrap class="xWCardShiftRefundValue text-right xWNextInput">
                                    <input 
                                    <?php echo $tDisabledBtn; ?> 
                                    data-seq="<?php echo $tFNSeq; ?>" 
                                    class="form-control xCNInputNumericWithDecimal xCNPdtEditInLine xWValueEditInLine<?php echo $aValue['rtRowID']; ?> " 
                                    style="text-align: right; <?php echo $tColorInput; ?>" 
                                    id="oetCardShiftRefundValue<?php echo $aValue['rtRowID']; ?>" 
                                    name="oetCardShiftRefundValue<?php echo $aValue['rtRowID']; ?>" 
                                    type="text" 
                                    value="<?php echo number_format($aValue['FCXsdAmt'], 2); ?>">
                                    <input 
                                    id="ohdCardShiftRefundValue<?php echo $aValue['rtRowID']; ?>" 
                                    name="ohdCardShiftRefundValue<?php echo $aValue['rtRowID']; ?>"
                                    type="hidden" 
                                    value="<?php echo number_format($aValue['FCXsdAmt'], 2); ?>">
                                </td>
                                <td nowrap class="text-center   <?= $tClassSta ?>"> <?= $tStatusCard ?></td>
                                <td nowrap class="text-center   <?= $tClassSta ?>"> <?= $tProcess ?></td>
                                <?php if ($aValue['FTXsdStaCrd'] != 1) { ?>
                                    <td nowrap class="text-left"><?php echo $aValue['FTXsdRmk']; ?></td>
                                <?php } else { ?>
                                    <td nowrap class="text-left xWNextInput">
                                        <input 
                                        <?php echo $tDisabledRmk; ?> 
                                        data-seq="<?php echo $tFNSeq; ?>" 
                                        class="form-control  xWCardShiftRefundRmk xCNPdtEditInLine xWValueEditInLine<?php echo $aValue['rtRowID']; ?> " 
                                        style="text-align: left; <?php echo $tColorInput; ?>" 
                                        id="oetCardShiftRefundRmk<?php echo $aValue['rtRowID']; ?>" 
                                        name="oetCardShiftRefundRmk<?php echo $aValue['rtRowID']; ?>" 
                                        type="text" 
                                        value="<?php echo $aValue['FTXsdRmk']; ?>">
                                    </td>
                                <?php } ?>
                                <td>
                                    <img <?php echo $tDisabledStye; ?> class="xCNIconTable" src="<?php echo base_url('application/modules/common/assets/images/icons/delete.png'); ?>" onClick="JSxCardShiftRefundDataSourceDeleteOperator(this, event, <?php echo $nPage; ?>, '<?php echo $aValue['FTCrdCode']; ?>', <?php echo $aValue['FNXsdSeqNo']; ?>)">
                                </td>
                                <script>
                                    $(document).ready(function() {
                                        $('#obtCardShiftRefundCardCode<?php echo $aValue['rtRowID']; ?>').click(function() {
                                            window.oCardShiftRefundBrowseCardOption<?php echo $aValue['rtRowID']; ?> = oCardShiftRefundBrowseCard<?php echo $aValue['rtRowID']; ?>();
                                            JCNxBrowseData('oCardShiftRefundBrowseCardOption<?php echo $aValue['rtRowID']; ?>');
                                        });
                                        var tCryStaPay = '<?=$aValue['FTCtyStaPay']?>';
                                        $('#oetCardShiftRefundCardType').val(tCryStaPay);
                                        // console.log(tCryStaPay);
                                        if( tCryStaPay == '2' ){
                                            $('#olbCardShiftRefundTotalText').text('<?=language('document/card/cardrefund', 'tCardShiftRefundCardRefundValue2'); ?>');
                                        }else{
                                            $('#olbCardShiftRefundTotalText').text('<?=language('document/card/cardrefund', 'tCardShiftRefundCardRefundValue'); ?>');
                                        }
                                    });

                                    var nLangEdit = <?php echo $this->session->userdata("tLangEdit"); ?>;

                                    var oCardShiftRefundBrowseCard<?php echo $aValue['rtRowID']; ?> = function() {
                                        let tNotIn          = "";
                                        let ptNotCardCode   = JStCardShiftRefundGetCardCodeTemp();
                                        let tAgnCode        = '<?=$this->session->userdata("tSesUsrAgnCode")?>';
                                        let tSesUsrLevel    = '<?=$this->session->userdata("tSesUsrLevel")?>';
                                        let tCardType       = $('#oetCardShiftRefundCardType').val();
                                        var nFromCard = $('#oetCardShiftRefundFromCardTypeCode').val();
                                        var nToCard = $('#oetCardShiftRefundToCardTypeCode').val();
                                        let tWhereCardCode  = "";
                                        var tWhereInCard = "";
                                        // console.log(tCardType);
                                        if (nFromCard != '' || nToCard != '') {
                                            tWhereInCard = " AND TFNMCardType.FTCtyCode IN (" + nFromCard + "," + nToCard + ")";
                                        }


                                        if( tCardType != "" ){
                                            tWhereCardCode += " AND TFNMCardType.FTCtyStaPay = '"+tCardType+"' ";
                                        }

                                        if( tSesUsrLevel != "HQ" && tAgnCode != "" ){
                                            tWhereCardCode += " AND TFNMCard.FTAgnCode = '"+tAgnCode+"' ";
                                        }

                                        if (!ptNotCardCode == "") {
                                            tNotIn = "AND TFNMCard.FTCrdCode NOT IN (" + ptNotCardCode + ")";
                                        }
                                        console.log("NOT IN TEMP: ", tNotIn);
                                        let oOptions = {
                                            Title: ['payment/card/card', 'tCRDTitle'],
                                            Table: {
                                                Master: 'TFNMCard',
                                                PK: 'FTCrdCode',
                                                PKName: 'FTCrdName'
                                            },
                                            Join: {
                                                Table: [
                                                'TFNMCard_L',
                                                'TFNMCardType',
                                                " (SELECT CRD.FTCrdCode, SUM ( CASE WHEN CRDB.FTCrdTxnCode = '001' THEN ISNULL(CRDB.FCCrdValue, 0) ELSE 0 END ) CashIn, SUM ( CASE WHEN CRDB.FTCrdTxnCode = '002' THEN ISNULL(CRDB.FCCrdValue, 0)" +
                                                " ELSE 0 END ) Promotion, SUM ( CASE WHEN CRDB.FTCrdTxnCode = '003' THEN ISNULL(CRDB.FCCrdValue, 0) ELSE 0 END ) DepositCrd, SUM ( CASE WHEN CRDB.FTCrdTxnCode = '004' THEN ISNULL(CRDB.FCCrdValue, 0)" +
                                                " ELSE 0 END ) DepositPdt, SUM ( CASE WHEN CRDB.FTCrdTxnCode = '005' THEN ISNULL(CRDB.FCCrdValue, 0) ELSE 0 END ) NotReturn, SUM ( CASE WHEN CRDB.FTCrdTxnCode = '006' THEN ISNULL(CRDB.FCCrdValue, 0)" +
                                                " ELSE 0 END ) Payment FROM TFNMCard CRD WITH (NOLOCK) LEFT JOIN TFNMCardBal CRDB WITH (NOLOCK) ON CRDB.FTCrdCode = CRD.FtCrdCode GROUP BY CRD.FTCrdCode) CRDB"
                                                ],
                                                On: [
                                                    'TFNMCard_L.FTCrdCode = TFNMCard.FTCrdCode AND TFNMCard_L.FNLngID = ' + nLangEdits,
                                                    'TFNMCardType.FTCtyCode = TFNMCard.FTCtyCode',
                                                    'CRDB.FTCrdCode = TFNMCard.FTCrdCode'
                                                ]
                                            },
                                            Where: {
                                                Condition: ["" +
                                                    tWhereCardCode + 
                                                    " AND TFNMCard.FTCrdCode IN (SELECT CB.FTCrdCode FROM(SELECT CRD.FTCrdCode, SUM(CASE WHEN CRDB.FTCrdTxnCode='001' THEN ISNULL(CRDB.FCCrdValue,0) ELSE 0 END) CashIn," + 
                                                    " SUM(CASE WHEN CRDB.FTCrdTxnCode='002' THEN ISNULL(CRDB.FCCrdValue,0) ELSE 0 END) Promotion , SUM(CASE WHEN CRDB.FTCrdTxnCode='003' THEN ISNULL(CRDB.FCCrdValue,0)" +
                                                    " ELSE 0 END) DepositCrd , SUM(CASE WHEN CRDB.FTCrdTxnCode='004' THEN ISNULL(CRDB.FCCrdValue,0) ELSE 0 END) DepositPdt , SUM(CASE WHEN CRDB.FTCrdTxnCode='005' THEN ISNULL(CRDB.FCCrdValue,0)" +
                                                    " ELSE 0 END) NotReturn , SUM(CASE WHEN CRDB.FTCrdTxnCode='006' THEN ISNULL(CRDB.FCCrdValue,0) ELSE 0 END) Payment FROM TFNMCard CRD WITH (NOLOCK)" +
                                                    " LEFT JOIN TFNMCardBal CRDB WITH (NOLOCK) ON CRDB.FTCrdCode = CRD.FtCrdCode GROUP BY CRD.FTCrdCode ) CB)" +
                                                    " AND TFNMCard.FTCrdStaActive = '1' AND (TFNMCard.FTCrdStaShift = '2') " + tNotIn + tWhereInCard
                                                ]
                                            },
                                            GrideView: {
                                                ColumnPathLang: 'payment/card/card',
                                                ColumnKeyLang: ['tCRDTBCode', 'tCRDTBName', 'ยอดเงินในบัตร'],
                                                // ColumnsSize     : ['15%', '85%'],
                                                WidthModal: 50,
                                                DataColumns: ["TFNMCard.FTCrdCode", "TFNMCard_L.FTCrdName", "/*CRDB.FCCrdValue.*/(CASE WHEN ((CRDB.CashIn + CRDB.Promotion) - (CRDB.Payment + CRDB.NotReturn)) < 0 THEN 0 ELSE ((CRDB.CashIn + CRDB.Promotion) - (CRDB.Payment + CRDB.NotReturn))END) AS FCCrdValue ,ISNULL(dbo.F_GETnCardCheckout(TFNMCard.FTCrdCode), 0) FCXsdAmt"],
                                                DisabledColumns: [],
                                                DataColumnsFormat: ['', '', 'Number:0'],
                                                Perpage: 500,
                                                OrderBy: ['TFNMCard_L.FTCrdName'],
                                                SourceOrder: "ASC"
                                            },
                                            NextFunc: {
                                                FuncName: 'JSxCardShiftRefundCallBackCardRefund<?php echo $aValue['rtRowID']; ?>',
                                                ArgReturn: ['FTCrdCode', 'FTCrdName', 'FCCrdValue','FCXsdAmt']
                                            },
                                            CallBack: {
                                                // StaDoc: '2',
                                                ReturnType: 'S',
                                                Value: ["oetCardShiftRefundCardCode<?php echo $aValue['rtRowID']; ?>", "TFNMCard.FTCrdCode"],
                                                Text: ["oetCardShiftRefundCardValueCode<?php echo $aValue['rtRowID']; ?>", "TFNMCard.FTCrdCode"]
                                            },
                                            RouteAddNew: 'card',
                                            BrowseLev: nStaCardShiftRefundBrowseType,
                                            // DebugSQL: true
                                        };
                                        return oOptions;
                                    };

                                    function JSxCardShiftRefundCallBackCardRefund<?php echo $aValue['rtRowID']; ?>(ptCard) {
                                        poCard = JSON.parse(ptCard);
                                        $('#oetCardShiftRefundValue' + <?php echo $aValue['rtRowID']; ?>).val(parseFloat(poCard[3]).toFixed(2)).trigger("change");
                                        $('#ohdCardShiftRefundValue' + <?php echo $aValue['rtRowID']; ?>).val(parseFloat(poCard[3]).toFixed(2));
                                    }
                                </script>
                            </tr>
                        <?php } ?>
                </tbody>

                <!-- <tbody> -->
                <tr>
                    <!-- <td nowrap="" class="text-right xCNTextDetail2" colspan="7" style="padding-right: 20%;"> -->
                    <?php
                        //GET Vat
                        $tResult = FCNcDOCGetVatData();
                        if ($tResult['cVatRate'] == '' || $tResult['cVatRate'] == null || $tResult['cVatRate'] == '.00') {
                            $tTextVat = 'NULL';
                        } else {
                            $tTextVat = 'HAVE';
                        }
                    ?>
                    <td style="border: 0px solid #FFF !important;"></td>
                    <td nowrap="" class="text-right xCNTextDetail2" style="text-align: right; border: 0px solid #FFF !important;  ">
                        <label id="olbCardShiftRefundTotalText"><?php echo language('document/card/cardrefund', 'tCardShiftRefundCardRefundValue'); ?></label>
                        <!-- <?php if ($tTextVat == 'HAVE') { ?> -->
                            <!-- <label><?php echo language('document/card/cardrefund', 'tCardShiftRefundCardRefundValue'); ?></label>55 -->
                            <!-- <br>
                                    <label><?php echo language('document/card/cardtopup', 'tCardShiftTopUpTaxRate'); ?></label>
                                    <br>
                                    <label><?php echo language('document/card/cardrefund', 'tCardShiftRefundNetReturnValue'); ?></label> -->
                        <!-- <?php } else { ?>
                            <label><?php echo language('document/card/cardrefund', 'tCardShiftRefundCardRefundValue'); ?></label>66
                            <br>
                        <?php } ?> -->
                    </td>
                    <td style="border: 0px solid #FFF !important; text-align: right;">


                        <?php if ($tTextVat == 'HAVE') : ?>
                            <?php
                            $cCal = 0.00;
                            $cVat = ($nTotalResult * $tResult['cVatRate']) / 100;
                            $cTotalInVat = $nTotalResult + $cVat;
                            ?>
                            <label id="odlLabelValue"><?php echo number_format($nTotalResult, 2); ?></label>
                            <!-- <br>
                                    <label id="odlLabelVat"><?php echo number_format($tResult['cVatRate'], 2, ".", ""); ?>%</label>
                                    <br>
                                    <label id="odlLabelTotal"><?php echo number_format($cTotalInVat, 2); ?></label> -->
                        <?php else : ?>
                            <label id="odlLabelValue"><?php echo number_format($nTotalResult, 2); ?></label>
                            <br>
                        <?php endif; ?>

                    </td>

                    <!-- </td> -->
                    <td style="border: 0px solid #FFF !important;" colspan="5">
                </tr>
                <!-- </tbody> -->

            <?php else : ?>
                <tr id="otrCardShiftRefundNoData">
                    <td nowrap class='text-center xCNTextDetail2' colspan='10'><?php echo language('common/main/main', 'tCMNNotFoundData'); ?></td>
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
        <input type="hidden" id="ohdCardShiftRefundDataSourceCurrentPage" value="<?php echo $nPage ?>">
        <div class="xWCardShiftRefundDataSourcePage btn-toolbar pull-right">
            <!-- เปลี่ยนชื่อ Class เป็นของเรื่องนั้นๆ -->
            <?php if ($nPage == 1) {
                $tDisabledLeft = 'disabled';
            } else {
                $tDisabledLeft = '-';
            } ?>
            <button onclick="JSvCardShiftRefundDataSourceClickPage('previous','<?= $ptDocType ?>','<?= $tIDElement ?>')" class="btn btn-white btn-sm" <?php echo $tDisabledLeft ?>>
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
                <button onclick="JSvCardShiftRefundDataSourceClickPage('<?php echo $i ?>','<?= $ptDocType ?>','<?= $tIDElement ?>')" type="button" class="btn xCNBTNNumPagenation <?php echo $tActive ?>" <?php echo $tDisPageNumber ?>><?php echo $i ?></button>
            <?php } ?>
            <?php if ($nPage >= $aDataList['rnAllPage']) {
                $tDisabledRight = 'disabled';
            } else {
                $tDisabledRight = '-';
            } ?>
            <button onclick="JSvCardShiftRefundDataSourceClickPage('next','<?= $ptDocType ?>','<?= $tIDElement ?>')" class="btn btn-white btn-sm" <?php echo $tDisabledRight ?>>
                <!-- เปลี่ยนชื่อ Onclick เป็นของเรื่องนั้นๆ -->
                <i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
            </button>
        </div>
    </div>
</div>

<!-- Modal Delete Table -->
<div class="modal fade" id="odvCardShiftRefundModalConfirmDelRecord">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header xCNModalHead">
                <label class="xCNTextModalHeard"><?php echo language('common/main/main', 'tModalDelete') ?></label>
            </div>
            <div class="modal-body">
                <span class="xCNTextModal" style="display: inline-block; word-break:break-all"><?php echo language('common/main/main', 'tModalDeleteSingle'); ?> <span id="ospCardShiftRefundConfirDelMessage"></span></span>
            </div>
            <div class="modal-footer">
                <button id="osmCardShiftRefundConfirmDelRecord" type="button" class="btn xCNBTNPrimery">
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
<!--script>
    /*JSXCalculateTotal();

    function JSXCalculateTotal(){
        
        var nTotalResult    = '<?php echo isset($nTotalResult) ? number_format($nTotalResult, 2) : '0'; ?>';
        var nRate           = '<?= $tResult['cVatRate']; ?>';

        if(nRate == '.0000' || nRate == '' || nRate == null){
            var tResult = parseFloat(nTotalResult);
            $('#odlLabelValue').text(tResult.toFixed(2));
        }else{
            $('#odlLabelValue').text(nTotalResult);
            var nCal = (nTotalResult * nRate)/100;
            var nCal = parseFloat(nCal) + parseFloat(nTotalResult);
            $('#odlLabelTotal').text('');
            $('#odlLabelTotal').text(nCal.toFixed(2));
        }
    }*/
</script-->
<script>
    $('.xCNPdtEditInLine').off().on('change keyup', function(e) {
        if (e.type === 'change' || e.keyCode === 13) {
            if (e.type === 'change') {
                var tNextElement = $(this).closest('form').find('.xWNextInput input[type=text]');
                var tNextElementID = tNextElement.eq(tNextElement.index(this) + 1).attr('id');
                var tValueNext = $('#' + tNextElementID).val();

                $('#' + tNextElementID).val(tValueNext);
                $('#' + tNextElementID).focus();
                $('#' + tNextElementID).select();
            }
            JSxCardShiftRefundDataSourceSaveOperator(this, event, $(this).data('seq'), <?php echo $nPage; ?>, tValueNext, tNextElementID);
        }
    });
</script>