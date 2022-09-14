<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="table-responsive">
            <!--  จำนวนบัตรทั้งหมดในการ Import -->
            <input type="hidden" class="xWCardMngCountRowFromTemp" id="ohdCardMngTopUpCountRowFromTemp" name="ohdCardMngTopUpCountRowFromTemp" value="<?php echo FSnSelectCountResult('TFNTCrdTopUpTmp'); ?>">
             <!-- จำนวนบัตรมีข้อมูลมี่ถูกต้อง -->
            <input type="hidden" id="ohdCardMngTopUpCountSuccess" name="ohdCardMngTopUpCountSuccess" value="<?php echo FSnSelectCountResultSuccess('TFNTCrdTopUpTmp'); ?>">

            <table class="table table-striped" id="otbCrdMngTopUpCardTable">
                <thead>
                    <tr>
                        <th nowrap class="xCNTextBold" style="width:5%;text-align:center;"><?= language('document/card/main','tMainNumber')?></th>
                        <th nowrap class="xCNTextBold" style="width:20%;text-align:left;"><?= language('document/card/main','tExcelTopupCard')?></th>
                        <th nowrap class="xCNTextBold" style="width:10%;text-align:left;"><?= language('document/card/main','tExcelTopup')?></th>
                        <th nowrap class="xCNTextBold" style="width:20%;text-align:left;"><?= language('document/card/main','tExcelTopupStatus')?></th>
                        <th nowrap class="xCNTextBold" style="width:15%;text-align:left;"><?= language('document/card/main','tExcelTopupProcessStatus')?></th>
                        <th nowrap class="xCNTextBold" style="text-align:center;"><?= language('document/card/main','tExcelTopupRemark')?></th>
                        <th nowrap class="xCNTextBold" style="width:10%;text-align:center;"><?= language('document/card/main','tMainEdit')?></th>
                        <th nowrap class="xCNTextBold" style="width:10%;text-align:center;"><?= language('document/card/main','tMainDelete')?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if($aDataList['rtCode'] == 1) : ?>
                        <?php $nTotalResult = $aDataList['CountTopUP'][0]['Total']; ?>
                        <?php foreach($aDataList['raItems'] as $key => $aValue) : ?>
                            <?php
                                $tFNSeq = $aValue['FNXsdSeqNo'];

                                // เช็คสถานะบัตร
                                if($aValue['FTXsdStaCrd'] == '1'){
                                    $tClassSta      = "xWImpStaSuccess";
                                    $tTextStaCrd    = language('document/card/main','tMainSuccess');
                                    $tStatusCard    = '<img class="xCNIconTable" src="' . base_url() . 'application/modules/common/assets/images/icons/OK-Approve.png"> <span class="text-success">' . $tTextStaCrd . '</span>';
                                }else{
                                    $tClassSta      = "xWImpStaUnsuccess";
                                    $tTextStaCrd    = language('document/card/main','tMainUnSuccess');
                                    $tStatusCard    = '<img class="xCNIconTable" src="' . base_url() . 'application/modules/common/assets/images/icons/cancel.png"> <span class="text-danger">' . $tTextStaCrd . '</span>';
                                }

                                // ยอดเติมเงิน
                                if($aValue['FCXsdAmt'] == 0 || $aValue['FCXsdAmt'] == null){
                                    $tValue = '0.00';
                                }else{
                                    $tValue = number_format($aValue['FCXsdAmt'],2);
                                }

                                // ประมวลผลบัตร
                                if($aValue['FTXsdStaPrc'] == '' || $aValue['FTXsdStaPrc'] == null){
                                    $tProcess = language('document/card/main', 'tMainWaitingForProcessing');
                                }else{
                                    if($aValue['FTXsdStaPrc'] == "1"){
                                        $tProcess = language('document/card/main','tMainSuccessProcessed');
                                    }
                                    if($aValue['FTXsdStaPrc'] == "2"){
                                        $tProcess = language('document/card/main','tMainUnsuccessProcessed');
                                    }
                                }
                            ?>
                            <tr class="text-center xCNTextDetail2 xWCardMngTopUpDataSource" id="otrCardMngTopUpDataSource<?php echo $aValue['rtRowID']; ?>" data-seq="<?php echo $aValue['FNXsdSeqNo']; ?>">
                                <td nowrap class="text-center"><?php echo $aValue['rtRowID']; ?></td>
                                <td nowrap class="xWCardMngTopUpCardCode text-left">
                                    <input id="oetCardMngTopUpCardCode<?php echo $aValue['rtRowID']; ?>" name="oetCardMngTopUpCardCode<?php echo $aValue['rtRowID']; ?>" type="text" disabled="true" value="<?php echo $aValue['FTCrdCode']; ?>">
                                    <input id="oetCardMngTopUpCardValueCode<?php echo $aValue['rtRowID']; ?>" type="hidden" value="<?php echo $aValue['FTCrdCode']; ?>">
                                </td>
                                <td nowrap class="xWCardMngTopUpValue text-left">
                                    <input id="oetCardMngTopUpValue<?php echo $aValue['rtRowID']; ?>" name="oetCardMngTopUpValue<?php echo $tValue; ?>" type="text" disabled="true" value="<?php echo $tValue; ?>">
                                    <input id="oetCardMngTopUpValueCode<?php echo $aValue['rtRowID']; ?>" type="hidden" value="<?php echo $tValue; ?>">
                                </td>
                                <td nowrap class="xWCardMngTopUpStatus text-left">
                                    <?php echo $tStatusCard; ?>
                                    <input type="hidden" class="xWCardMngTopUpStatusCard" value="<?php echo $aValue['FTXsdStaCrd']; ?>">
                                </td>
                                <td nowrap class="text-left"><?php echo $tProcess; ?></td>
                                <td nowrap class="xWCardMngTopUpCardRmk text-left"><?php echo $aValue['FTXsdRmk']; ?></td>

                                <td nowrap class="text-center"> 
                                    <img class="xCNIconTable xWCardMngTopUpEdit" src="<?php echo  base_url('application/modules/common/assets/images/icons/edit.png'); ?>" onclick="JSxCardMngTopUpDataSourceEditOperator(this, event, <?php echo $aValue['FNXsdSeqNo']; ?>)">
                                    <img class="xCNIconTable xWCardMngTopUpSave hidden" src="<?php echo  base_url('application/modules/common/assets/images/icons/save.png'); ?>" onclick="JSxCardMngTopUpDataSourceSaveOperator(this, event, <?php echo $aValue['FNXsdSeqNo']; ?>)">
                                    <img class="xCNIconTable xWCardMngTopUpCancel hidden" src="<?php echo  base_url('application/modules/common/assets/images/icons/reply_new.png'); ?>" onclick="JSxCardMngTopUpDataSourceCancelOperator(this, event)">
                                </td>
                                <td nowrap class="text-center">
                                    <img class="xCNIconTable" src="<?php echo  base_url('application/modules/common/assets/images/icons/delete.png'); ?>" onClick="JSxCardMngTopUpDataSourceDeleteOperator(this, event, <?php echo $nPage; ?>, '<?php echo $aValue['FTCrdCode']; ?>', <?php echo $aValue['FNXsdSeqNo']; ?>)">
                                </td>
                            </tr>
                            <script>
                                $(document).ready(function(){  
                                    $('#oetCardMngTopUpCardCode<?php echo $aValue['rtRowID']; ?>').click(function(){
                                        window.oCardMngTopUpBrowseCardOption<?php echo $aValue['rtRowID']; ?> = oCardMngTopUpBrowseCard<?php echo $aValue['rtRowID']; ?>();
                                        JCNxBrowseData('oCardMngTopUpBrowseCardOption<?php echo $aValue['rtRowID']; ?>');
                                    });
                                });
                                
                                var nLangEdit = <?php echo $this->session->userdata("tLangEdit"); ?>;
                                var oCardMngTopUpBrowseCard<?php echo $aValue['rtRowID']; ?> = function () {
                                    var tWhereSessionID = "'"+ <?php echo $this->session->userdata("tSesSessionID");?> + "'";
                                    let oOptions = {
                                        Title : ['payment/card/card','tCRDTitle'],
                                        Table:{Master:'TFNMCard', PK:'FTCrdCode', PKName:'FTCrdName'},
                                        Join :{
                                            Table: ['TFNMCard_L','TFNTCrdTopUpTmp','TFNMCardType'],
                                            On: [
                                                "TFNMCard.FTCrdCode = TFNMCard_L.FTCrdCode AND TFNMCard_L.FNLngID = " + nLangEdit ,
                                                "TFNMCard.FTCrdCode	= TFNTCrdTopUpTmp.FTCrdCode AND TFNTCrdTopUpTmp.FTSessionID = " + tWhereSessionID,
                                                'TFNMCardType.FTCtyCode = TFNMCard.FTCtyCode'
                                            ]
                                        },
                                        Where :{
                                            Condition : [
                                                " AND (TFNMCardType.FTCtyStaShift = '1') AND (TFNMCard.FTCrdStaActive = '1') AND (TFNMCard.FTCrdStaShift = '1') AND (CONVERT(date, TFNMCard.FDCrdExpireDate) > CONVERT(date, GETDATE())) ",
                                                " AND (TFNTCrdTopUpTmp.FTCrdCode IS NULL)"
                                            ]
                                        },
                                        GrideView:{
                                            ColumnPathLang: 'payment/card/card',
                                            ColumnKeyLang: ['tCRDTBCode', 'tCRDTBName', ''],
                                            WidthModal: 50,
                                            DataColumns: ['TFNMCard.FTCrdCode', 'TFNMCard_L.FTCrdName', 'TFNMCard.FTCrdHolderID'],
                                            DisabledColumns:[2],
                                            DataColumnsFormat: ['', '', ''],
                                            Perpage: 500,
                                            OrderBy: ['TFNMCard_L.FTCrdName'],
                                            SourceOrder: "ASC"
                                        },
                                        CallBack:{
                                            ReturnType: 'S',
                                            Value: ["oetCardMngTopUpCardCode<?php echo $aValue['rtRowID']; ?>", "TFNMCard.FTCrdCode"],
                                            Text: ["oetCardMngTopUpCardValueCode<?php echo $aValue['rtRowID']; ?>", "TFNMCard.FTCrdCode"]
                                        },
                                        RouteAddNew : 'card',
                                        BrowseLev : nStaCmdBrowseType
                                        // DebugSQL : true
                                    }
                                    return oOptions;
                                }
                            </script>
                        <?php endforeach; ?>
                        <tr>
                            <td nowrap="" class="text-right xCNTextDetail2" colspan="8" style="padding-right: 20%;">
                                <div class="col-4 pull-right text-right" style="padding-left: 15%;">
                                    <?php 
                                        //GET Vat
                                        $tResult = FCNcDOCGetVatData(); 
                                        if($tResult['cVatRate'] == '' || $tResult['cVatRate'] == null || $tResult['cVatRate'] == '.0000'){
                                            $tTextVat = 'NULL';
                                        }else{
                                            $tTextVat = 'HAVE';
                                        }
                                    ?>

                                    <?php if ($tTextVat == 'HAVE') : ?>
                                        <?php
                                        $cCal = 0.00;
                                        $cVat = ($nTotalResult * $tResult['cVatRate']) / 100;
                                        $cTotalInVat = $nTotalResult + $cVat;
                                        ?>
                                        <label id="odlLabelValue"><?php echo number_format($nTotalResult, 2); ?></label>
                                        <br>
                                        <label id="odlLabelVat"><?php echo number_format($tResult['cVatRate'], 2, ".", ""); ?>%</label>
                                        <br>
                                        <label id="odlLabelTotal"><?php echo number_format($cTotalInVat, 2); ?></label>
                                    <?php else : ?>
                                        <label id="odlLabelValue"><?php echo number_format($nTotalResult, 2); ?></label>
                                        <br>
                                    <?php endif; ?>
                                        
                                </div>
                                <div class="col-4 pull-right text-left">
                                    <?php if($tTextVat == 'HAVE'){ ?>
                                        <label><?php echo language('document/card/cardtopup', 'tCardShiftTopUpCardTopUpValue'); ?></label>
                                        <br>
                                        <label><?php echo language('document/card/cardtopup', 'tCardShiftTopUpTaxRate'); ?></label>
                                        <br>
                                        <label><?php echo language('document/card/cardtopup', 'tCardShiftTopUpNetWorth'); ?></label>
                                    <?php }else{ ?>
                                        <label><?php echo language('document/card/cardtopup', 'tCardShiftTopUpValueAdded'); ?></label>
                                        <br>
                                    <?php } ?>
                                </div>
                            </td>
                        </tr>
                    <?php else : ?>
                        <tr id="otrCardMngTopUpNoData"><td nowrap class='text-center xCNTextDetail2' colspan='99'><?php echo language('common/main/main','tCMNNotFoundData'); ?></td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="row">
    <!-- เปลี่ยน -->
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
        <p><?= language('common/main/main','tResultTotalRecord')?> <?=$aDataList['rnAllRow']?> <?= language('common/main/main','tRecord')?> <?= language('common/main/main','tCurrentPage')?> <?=$aDataList['rnCurrentPage']?> / <?=$aDataList['rnAllPage']?></p>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
        <input type="hidden" id="ohdCardMngTopUpDataSourceCurrentPage" value="<?php echo $nPage ?>">
        <div class="xWCardMngTopUpDataSourcePage btn-toolbar pull-right"> <!-- เปลี่ยนชื่อ Class เป็นของเรื่องนั้นๆ --> 
            <?php if($nPage == 1){ $tDisabledLeft = 'disabled'; }else{ $tDisabledLeft = '-';} ?>
            <button onclick="JSvCardMngTopUpDataSourceClickPage('previous','<?=$ptDocType?>','<?=$tIDElement?>')" class="btn btn-white btn-sm" <?php echo $tDisabledLeft ?>> <!-- เปลี่ยนชื่อ Onclick เป็นของเรื่องนั้นๆ --> 
                <i class="fa fa-chevron-left f-s-14 t-plus-1"></i>
            </button>
            <?php for($i=max($nPage-2, 1); $i<=max(0, min($aDataList['rnAllPage'],$nPage+2)); $i++){?> <!-- เปลี่ยนชื่อ Parameter Loop เป็นของเรื่องนั้นๆ --> 
                <?php 
                    if($nPage == $i){ 
                        $tActive = 'active'; 
                        $tDisPageNumber = 'disabled';
                    }else{ 
                        $tActive = '';
                        $tDisPageNumber = '';
                    }
                ?>
                <!-- เปลี่ยนชื่อ Onclick เป็นของเรื่องนั้นๆ --> 
                <button onclick="JSvCardMngTopUpDataSourceClickPage('<?php echo $i?>','<?=$ptDocType?>','<?=$tIDElement?>')" type="button" class="btn xCNBTNNumPagenation <?php echo $tActive ?>" <?php echo $tDisPageNumber ?>><?php echo $i?></button>
            <?php } ?>
            <?php if($nPage >= $aDataList['rnAllPage']){  $tDisabledRight = 'disabled'; }else{  $tDisabledRight = '-';  } ?>
            <button onclick="JSvCardMngTopUpDataSourceClickPage('next','<?=$ptDocType?>','<?=$tIDElement?>')" class="btn btn-white btn-sm" <?php echo $tDisabledRight ?>> <!-- เปลี่ยนชื่อ Onclick เป็นของเรื่องนั้นๆ --> 
                <i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
            </button>
        </div>
    </div>
</div>

<!-- Modal Delete Table -->
<div class="modal fade" id="odvCardMngTopUpModalConfirmDelRecord">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header xCNModalHead">
                <label class="xCNTextModalHeard"><?php echo language('common/main/main', 'tModalDelete') ?></label>
            </div>
            <div class="modal-body">
                <span class="xCNTextModal" style="display: inline-block; word-break:break-all"><?php echo language('common/main/main', 'tModalDeleteSingle'); ?> <span id="ospCardMngTopUpConfirDelMessage"></span></span>
            </div>
            <div class="modal-footer">
                <button id="osmCardMngTopUpConfirmDelRecord" type="button" class="btn xCNBTNPrimery">
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

<script type="text/javascript">
    $(document).ready(function(){
        var oSetQtySucessAllRow = {
            'tQtyAllRow'    : $('#ohdCardMngTopUpCountRowFromTemp').val(),
            'tQtySucessRow' : $('#ohdCardMngTopUpCountSuccess').val()
        }
        JSxSetQtyCardAllAndAllRow(oSetQtySucessAllRow);
    });
</script>

<!--script>

    /*JSXCalculateTotal();
    function JSXCalculateTotal(){
        var nTotalResult    = '<?php echo (isset($nTotalResult) && !empty($nTotalResult)) ? $nTotalResult : 0 ?>';
        var nRate           = '<?php echo (isset($tResult['cVatRate']) && !empty($tResult['cVatRate'])) ? $tResult['cVatRate'] : 0 ?>';

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

<?php include "script/wCardMngTopUpDataSourceTable.php"; ?>






