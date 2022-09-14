<?php
$nTotalResult = 0;
$tResult = 0;
?>

<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">

            <span class="hidden" id="ospCardShiftTopUpCardCodeTemp"><?php echo $tDataListAll; ?></span>
            <input type="hidden" id="ohdCardShiftTopUpCountRowFromTemp" name="ohdCardShiftTopUpCountRowFromTemp" value="<?php echo $rnAllRow; ?>">
            <input type="hidden" id="ohdCardShiftCountSuccess" name="ohdCardShiftCountSuccess" value="<?php echo FSnSelectCountResultSuccess('TFNTCrdTopUpTmp'); ?>">

            <table class="table table-striped" id="otbCardShiftTopUpCardTable">
                <thead>
                    <tr>
                        <th nowrap class="xCNTextBold" style="width:5%;text-align:center;"><?= language('document/card/main', 'tMainNumber') ?></th>
                        <th nowrap class="xCNTextBold" style="width:200px;text-align:center;"><?= language('document/card/main', 'tExcelTopupCard') ?></th>
                        <th nowrap class="xCNTextBold" style="width:150px;text-align:center;"><?= language('document/card/main', 'tExcelTopup') ?></th>
                        <th nowrap class="xCNTextBold xTopupPmtAmt" style="width:150px;text-align:center;"><?= language('document/card/main', 'tExcelTopupPmtAmt') ?></th>
                        <th nowrap class="xCNTextBold xTopupPmtAmt" style="width:90px;text-align:center;"><?= language('document/card/main', 'tExcelTopCouponRev') ?></th>
                        <th nowrap class="xCNTextBold" style="width:10%;text-align:center;"><?= language('document/card/main', 'tExcelTopupStatus') ?></th>
                        <th nowrap class="xCNTextBold" style="width:15%;text-align:center;"><?= language('document/card/main', 'tExcelTopupProcessStatus') ?></th>
                        <th nowrap class="xCNTextBold" style="width:20%;text-align:center;"><?= language('document/card/main', 'tExcelTopupRemark') ?></th>
                        <!-- <th nowrap class="xCNTextBold" style="width:10%;text-align:center;"><?= language('document/card/main', 'tMainEdit') ?></th> -->
                        <th nowrap class="xCNTextBold" style="width:10%;text-align:center;"><?= language('document/card/main', 'tMainDelete') ?></th>
                    </tr>
                </thead>
                <tbody id="">
                    <?php if ($aDataList['rtCode'] == 1) : ?>
                        <?php $nTotalResult = $aDataList['CountTopUP'][0]['Total']; ?>
                        <?php foreach ($aDataList['raItems'] as $key => $aValue) : ?>
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

                            // ยอด
                            if ($aValue['FCXsdAmt'] == 0 || $aValue['FCXsdAmt'] == null) {
                                $tValue = '0.00';
                            } else {
                                $tValue = $aValue['FCXsdAmt'];
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
                            class="text-center xCNTextDetail2 xWCardShiftTopUpDataSource" 
                            id="otrCardShiftTopUpDataSource<?php echo $aValue['rtRowID']; ?>" 
                            data-sta-card="<?php echo $aValue['FTXsdStaCrd']; ?>" 
                            data-seq="<?php echo $aValue['FNXsdSeqNo']; ?>">

                                <td nowrap class="text-center"><?php echo $aValue['rtRowID']; ?></td>
                                <!-- <td nowrap class="xWCardShiftTopUpCardCode text-left">
                                    <input id="oetCardShiftTopUpCardCode<?php echo $aValue['rtRowID']; ?>" name="oetCardShiftTopUpCardCode<?php echo $aValue['rtRowID']; ?>" type="text" disabled="true" value="<?php echo $aValue['FTCrdCode']; ?>">
                                    <input id="oetCardShiftTopUpCardValueCode<?php echo $aValue['rtRowID']; ?>" type="hidden" value="<?php echo $aValue['FTCrdCode']; ?>">
                                </td> -->
                                <td nowrap class="xWCardShiftTopUpCardCode text-left">
                                    <div class="input-group">
                                        <input 
                                        data-seq="" 
                                        class="form-control xCNCardCode xCNPdtEditInLine xWValueEditInLine<?php echo $aValue['rtRowID']; ?> " 
                                        id="oetCardShiftTopUpCardCode<?php echo $aValue['rtRowID']; ?>" 
                                        name="oetCardShiftTopUpCardCode<?php echo $aValue['rtRowID']; ?>" 
                                        type="text" 
                                        disabled="true" 
                                        value="<?php echo $aValue['FTCrdCode']; ?>" 
                                        style="width: 100%;">
                                        <input 
                                        data-seq="" 
                                        id="oetCardShiftTopUpCardValueCode<?php echo $aValue['rtRowID']; ?>" 
                                        class="form-control xCNCardCode xCNPdtEditInLine xWValueEditInLine<?php echo $aValue['rtRowID']; ?>" 
                                        name="oetCardShiftTopUpCardValueCode<?php echo $aValue['rtRowID']; ?>" 
                                        type="hidden" 
                                        value="<?php echo $aValue['FTCrdCode']; ?>">
                                        <span class="input-group-btn">
                                            <button <?php echo $tDisabledBtn; ?> id="obtCardShiftTopUpCardCode<?php echo $aValue['rtRowID']; ?>" type="button" class="btn xCNBtnBrowseAddOn">
                                                <img src="<?php echo base_url('/application/modules/common/assets/images/icons/find-24.png'); ?>">
                                            </button>
                                        </span>
                                    </div>
                                </td>
                                <!-- <td nowrap class="xWCardShiftTopUpValue text-right">
                                    <input style="text-align: right;" id="oetCardShiftTopUpValue<?php echo $aValue['rtRowID']; ?>" name="oetCardShiftTopUpValue<?php echo $aValue['rtRowID']; ?>" type="text" disabled="true" value="<?php echo number_format($aValue['FCXsdAmt'], 2); ?>">
                                    <input id="oetCardShiftTopUpValueCode<?php echo $aValue['rtRowID']; ?>" type="hidden" value="<?php echo number_format($aValue['FCXsdAmt'], 2); ?>">
                                </td> -->
                                <td nowrap class="xWCardShiftTopUpValue text-right xWNextInput">
                                    <input 
                                    <?php echo $tDisabledBtn; ?> 
                                    data-seq="<?php echo $tFNSeq; ?>" 
                                    class="form-control xCNInputNumericWithDecimal xCNPdtEditInLine xWValueEditInLine<?php echo $aValue['rtRowID']; ?> " 
                                    style="text-align: right; <?php echo $tColorInput; ?>" 
                                    id="oetCardShiftTopUpValue<?php echo $aValue['rtRowID']; ?>" 
                                    name="oetCardShiftTopUpValue<?php echo $aValue['rtRowID']; ?>" 
                                    type="text" 
                                    value="<?php echo number_format($aValue['FCXsdAmt'], 2); ?>">
                                    <input id="oetCardShiftTopUpValueCode<?php echo $aValue['rtRowID']; ?>" type="hidden" value="<?php echo number_format($aValue['FCXsdAmt'], 2); ?>">
                                </td>
                                <td nowrap class="xWCardShiftTopUpValue text-right xWNextInput xTopupPmtAmt">
                                  <?php echo number_format($aValue['FCXsdAmtPmt'], 2); ?>
                                </td>

                                <!-- จำนวนคูปองที่ได้รับ -->
                                <td class="xWCardShiftTopUpValue text-right xWNextInput xTopupPmtAmt">
                                    <?php 
                                    if($aValue['FNXpdQty'] == ''){
                                        echo "0";
                                    }else{
                                        echo $aValue['FNXpdQty'];
                                    }
                                    ?>
                                </td>


                                <td nowrap class="xWCardShiftTopUpStatus text-center">
                                    <?php echo $tStatusCard; ?>
                                    <input type="hidden" class="xWCardShiftTopUpStatusCard" value="<?php echo $aValue['FTXsdStaCrd']; ?>">
                                </td>
                                <td nowrap class="text-center"><?php echo $tProcess; ?></td>
                                <!-- <td nowrap class="xWCardShiftTopUpCardRmk text-left"><?php echo $aValue['FTXsdRmk']; ?></td> -->
                                <!-- <td nowrap class="xWCardShiftTopUpCardRmk text-left">
                                    <input style="text-align: left;" id="oetCardShiftTopUpCardRmk<?php echo $aValue['rtRowID']; ?>" name="oetCardShiftTopUpCardRmk<?php echo $aValue['rtRowID']; ?>" type="text" disabled="true" value="<?php echo $aValue['FTXsdRmk']; ?>">
                                    <input id="oetCardShiftTopUpCardRmkCode<?php echo $aValue['rtRowID']; ?>" type="hidden" value="<?php echo $aValue['FTXsdRmk']; ?>">
                                </td> -->
                                <td nowrap class="text-left xWNextInput">
                                <?php if ($aValue['FTXsdStaCrd'] != 1) { ?>
                                    <label><?php echo $aValue['FTXsdRmk']; ?></label>
                                <?php } else { ?>
                                    <input 
                                    <?php echo $tDisabledRmk; ?> 
                                    data-seq="<?php echo $tFNSeq; ?>" 
                                    class="form-control  xWCardShiftTopUpCardRmk xCNPdtEditInLine xWValueEditInLine<?php echo $aValue['rtRowID']; ?> " 
                                    style="text-align: left; <?php echo $tColorInput; ?>" 
                                    id="oetCardShiftTopUpCardRmk<?php echo $aValue['rtRowID']; ?>" 
                                    name="oetCardShiftTopUpCardRmk<?php echo $aValue['rtRowID']; ?>" 
                                    type="text" 
                                    value="<?php echo $aValue['FTXsdRmk']; ?>">
                                <?php } ?>
                                </td>
                                <!-- <td nowrap class="text-center"> 
                                    <img  <?php echo $tDisabledStye; ?>  class="xCNIconTable xWCardShiftTopUpEdit" src="<?php echo  base_url('application/modules/common/assets/images/icons/edit.png'); ?>" onclick="JSxCardShiftTopUpDataSourceEditOperator(this, event, <?php echo $aValue['FNXsdSeqNo']; ?>)">
                                    <img class="xCNIconTable xWCardShiftTopUpSave hidden" src="<?php echo  base_url('application/modules/common/assets/images/icons/save.png'); ?>" onclick="JSxCardShiftTopUpDataSourceSaveOperator(this, event, <?php echo $aValue['FNXsdSeqNo']; ?>)">
                                    <img class="xCNIconTable xWCardShiftTopUpCancel hidden" src="<?php echo  base_url('application/modules/common/assets/images/icons/reply_new.png'); ?>" onclick="JSxCardShiftTopUpDataSourceCancelOperator(this, event)">
                                </td> -->
                                <td nowrap class="text-center">
                                    <img <?php echo $tDisabledStye; ?> class="xCNIconTable" src="<?php echo  base_url('application/modules/common/assets/images/icons/delete.png'); ?>" onClick="JSxCardShiftTopUpDataSourceDeleteOperator(this, event, <?php echo $nPage; ?>, '<?php echo $aValue['FTCrdCode']; ?>', <?php echo $aValue['FNXsdSeqNo']; ?>)">
                                </td>

                                <script>
                                    $(document).ready(function() {
                                        $('#obtCardShiftTopUpCardCode<?php echo $aValue['rtRowID']; ?>').click(function() {
                                            window.oCardShiftTopUpBrowseCardOption<?php echo $aValue['rtRowID']; ?> = oCardShiftTopUpBrowseCard<?php echo $aValue['rtRowID']; ?>(JStCardShiftTopUpGetCardCodeTemp());
                                            JCNxBrowseData('oCardShiftTopUpBrowseCardOption<?php echo $aValue['rtRowID']; ?>');
                                        });
                                    });

                                    var nLangEdit = <?php echo $this->session->userdata("tLangEdit"); ?>;

                                    var oCardShiftTopUpBrowseCard<?php echo $aValue['rtRowID']; ?> = function(ptNotCardCode) {
                                        
                                        let tNotIn = "";
                                        let tAgnCode        = '<?=$this->session->userdata("tSesUsrAgnCode")?>';
                                        let tSesUsrLevel    = '<?=$this->session->userdata("tSesUsrLevel")?>';
                                        let tWhereCardCode  = "";

                                        if(tSesUsrLevel != "HQ" && tAgnCode != ""){
                                            tWhereCardCode += " AND TFNMCard.FTAgnCode = '"+tAgnCode+"' ";
                                        }

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
                                                // Condition : [" AND (TFNMCard.FTCrdStaShift = '1') AND (TFNMCard.FTCrdStaActive = '1') AND (TFNMCard.FTCrdStaShift = '1') AND (CONVERT(date, TFNMCard.FDCrdExpireDate) > CONVERT(date, GETDATE())) " + tNotIn]
                                                Condition: ["" +
                                                    tWhereCardCode + 
                                                    "AND TFNMCard.FTCrdStaActive = '1' AND TFNMCardType.FTCtyStaPay = '1' AND ((TFNMCard.FTCrdStaShift = '2' AND TFNMCardType.FTCtyStaShift = '1') OR TFNMCardType.FTCtyStaShift = '2') AND (CONVERT(date, TFNMCard.FDCrdExpireDate) > CONVERT(date, GETDATE())) " + tNotIn]
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
                                                // OrderBy: ['TFNMCard_L.FTCrdName'],
                                                OrderBy: ['TFNMCard.FDCreateOn DESC'],
                                                SourceOrder: "ASC"
                                            },
                                            CallBack: {
                                                // StaDoc: '2',
                                                ReturnType: 'S',
                                                Value: ["oetCardShiftTopUpCardCode<?php echo $aValue['rtRowID']; ?>", "TFNMCard.FTCrdCode"],
                                                Text: ["oetCardShiftTopUpCardValueCode<?php echo $aValue['rtRowID']; ?>", "TFNMCard.FTCrdCode"]
                                            },
                                            RouteAddNew: 'card',
                                            BrowseLev: nStaCardShiftTopUpBrowseType
                                        };
                                        return oOptions;
                                    };
                                </script>
                            </tr>
                        <?php endforeach; ?>
                        <tr>

                            <?php
                            //GET Vat
                            $tResult = FCNcDOCGetVatData();
                            if ($tResult['cVatRate'] == '' || $tResult['cVatRate'] == null || $tResult['cVatRate'] == '.0000') {
                                $tTextVat = 'NULL';
                            } else {
                                $tTextVat = 'HAVE';
                            }
                            ?>
                            <td style="border: 0px solid #FFF !important;"></td>
                            <td style="border: 0px solid #FFF !important; text-align: right;">
                                <?php if ($tTextVat == 'HAVE') { ?>
                                    <label><?php echo language('document/card/cardtopup', 'tCardShiftTopUpNetWorth'); ?></label>
                                <?php } else { ?>
                                    <label><?php echo language('document/card/cardtopup', 'tCardShiftTopUpValueAdded'); ?></label>
                                    <br>
                                <?php } ?>
                            </td>
                            <td nowrap="" class="text-right xCNTextDetail2" style="text-align: right; border: 0px solid #FFF !important;  ">
                                <?php if ($tTextVat == 'HAVE') : ?>
                                    <?php
                                    $cTotalInVat = $nTotalResult;
                                    ?>
                                    <label style="padding: 0px 10px;" id="odlLabelTotal"><?php echo number_format($cTotalInVat, 2); ?></label>
                                <?php else : ?>
                                    <label style="padding: 0px 10px;" id="odlLabelValue"><?php echo number_format($nTotalResult, 2); ?></label>
                                    <br>
                                <?php endif; ?>
                            </td>
                            <td style="border: 0px solid #FFF !important;" colspan="6">
                        </tr>
                    <?php else : ?>
                        <tr id="otrCardShiftTopUpNoData">
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
        <input type="hidden" id="ohdCardShiftTopUpDataSourceCurrentPage" value="<?php echo $nPage ?>">
        <div class="xWCardShiftTopUpDataSourcePage btn-toolbar pull-right">
            <!-- เปลี่ยนชื่อ Class เป็นของเรื่องนั้นๆ -->
            <?php if ($nPage == 1) {
                $tDisabledLeft = 'disabled';
            } else {
                $tDisabledLeft = '-';
            } ?>
            <button onclick="JSvCardShiftTopUpDataSourceClickPage('previous','<?= $ptDocType ?>','<?= $tIDElement ?>')" class="btn btn-white btn-sm" <?php echo $tDisabledLeft ?>>
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
                <button onclick="JSvCardShiftTopUpDataSourceClickPage('<?php echo $i ?>','<?= $ptDocType ?>','<?= $tIDElement ?>')" type="button" class="btn xCNBTNNumPagenation <?php echo $tActive ?>" <?php echo $tDisPageNumber ?>><?php echo $i ?></button>
            <?php } ?>
            <?php if ($nPage >= $aDataList['rnAllPage']) {
                $tDisabledRight = 'disabled';
            } else {
                $tDisabledRight = '-';
            } ?>
            <button onclick="JSvCardShiftTopUpDataSourceClickPage('next','<?= $ptDocType ?>','<?= $tIDElement ?>')" class="btn btn-white btn-sm" <?php echo $tDisabledRight ?>>
                <!-- เปลี่ยนชื่อ Onclick เป็นของเรื่องนั้นๆ -->
                <i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
            </button>
        </div>
    </div>
</div>

<!-- Modal Delete Table -->
<div class="modal fade" id="odvCardShiftTopUpModalConfirmDelRecord">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header xCNModalHead">
                <label class="xCNTextModalHeard"><?php echo language('common/main/main', 'tModalDelete') ?></label>
            </div>
            <div class="modal-body">
                <span class="xCNTextModal" style="display: inline-block; word-break:break-all"><?php echo language('common/main/main', 'tModalDeleteSingle'); ?> <span id="ospCardShiftTopUpConfirDelMessage"></span></span>
            </div>
            <div class="modal-footer">
                <button id="osmCardShiftTopUpConfirmDelRecord" type="button" class="btn xCNBTNPrimery">
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
        
        var nTotalResult    = '<?php // echo isset($nTotalResult) ? number_format($nTotalResult, 2) : '0'; 
                                ?>';
        var nRate           = '<?php // $tResult['cVatRate'];
                                ?>';

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
       if ($('#ohdCardShiftXshStaApv').val()=='1') {
 
            $('.xTopupPmtAmt').show();

       }else{

            $('.xTopupPmtAmt').hide();
       }

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
            JSxCardShiftTopUpDataSourceSaveOperator(this, event, $(this).data('seq'), <?php echo $nPage; ?>, tValueNext, tNextElementID);
        }
    });
</script>