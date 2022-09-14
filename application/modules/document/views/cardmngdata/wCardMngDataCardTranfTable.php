<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            
            <span class="hidden" id="ospCardShiftChangeCardCodeTemp"><?php echo $tDataListAll; ?></span>
            <input type="hidden" class="xWCardMngCountRowFromTemp" id="ohdCardMngShiftChangeCountRowFromTemp" name="ohdCardShiftChangeCountRowFromTemp" value="<?php echo FSnSelectCountResult('TFNTCrdVoidTmp'); ?>">
            <input type="hidden" id="ohdCardMngShiftChangeCountSuccess" name="ohdCardShiftChangeCountSuccess" value="<?php echo FSnSelectCountResultSuccess('TFNTCrdVoidTmp'); ?>">
            
            <table class="table table-striped" id="otbCardShiftChangeCardTable">
                <thead>
                    <tr>
                        <th nowrap class="xCNTextBold text-center" style="width:5%;"><?php echo language('common/main/main','tCMNSequence'); ?></th>
                        <th nowrap class="xCNTextBold text-left" style="width:20%;"><?php echo language('document/card/cardchange','tCardShiftChangeTBOldCode'); ?></th>
                        <th nowrap class="xCNTextBold text-left" style="width:20%;"><?php echo language('document/card/cardchange','tCardShiftChangeTBNewCode'); ?></th>
                        <?php if(true) : ?>
                        <th nowrap class="xCNTextBold text-left" style="width:20%;"><?php echo language('document/card/cardchange','tCardShiftChangeTBReason'); ?></th>       
                        <?php endif; ?>
                        <th nowrap class="xCNTextBold text-left" style="width:20%;"><?php echo language('document/card/main','tExcelCardTnfChangeValueOld'); ?></th>
                        <th nowrap class="xCNTextBold text-left" style="width:10%;"><?php echo language('document/card/cardchange','tCardShiftChangeTBCardStatus'); ?></th>
                        <th nowrap class="xCNTextBold text-left" style="width:10%;"><?php echo language('document/card/cardchange','tCardShiftChangeTBProcessStatus'); ?></th>
                        <th nowrap class="xCNTextBold text-left" style="width:10%;"><?php echo language('document/card/cardchange','tCardShiftChangeTBRmk'); ?></th>
                        <th nowrap class="xCNTextBold text-center" style="width:5%;"><?php echo language('document/card/cardchange','tCardShiftChangeTBEdit'); ?></th>
                        <th nowrap class="xCNTextBold text-center" style="width:5%;"><?php echo language('document/card/cardchange','tCardShiftChangeTBDelete'); ?></th>
                    </tr>
                </thead>
                <tbody id="otbCardShiftChangeDataSourceList">
                    <?php if($aDataList['rtCode'] == 1) : ?>
                        <?php foreach($aDataList['raItems'] as $key => $aValue) : ?>
                            <?php
                                $tFNSeq = $aValue['rtRowID'];
                                
                                // สถานะบัตร
                                if($aValue['FTCvdStaCrd'] == '1'){
                                    $tClassSta   = "xWImpStaSuccess";
                                    $tTextStaCrd    = language('document/card/main','tMainSuccess');
                                    $tStatusCard    = '<img class="xCNIconTable" src="' . base_url() . 'application/modules/common/assets/images/icons/OK-Approve.png"> <span class="text-success">' . $tTextStaCrd . '</span>';
                                }else{
                                    $tClassSta   = "xWImpStaUnsuccess";
                                    $tTextStaCrd    = language('document/card/main','tMainUnSuccess');
                                    $tStatusCard    = '<img class="xCNIconTable" src="' . base_url() . 'application/modules/common/assets/images/icons/cancel.png"> <span class="text-danger">' . $tTextStaCrd . '</span>';
                                }
                                
                                // ยอดค่าเก่า
                                if($aValue['FCCvdOldBal'] == '' || $aValue['FCCvdOldBal'] == null){
                                    $nValueOld = '0.00';
                                }else{
                                    $nValueOld = $aValue['FCCvdOldBal'];
                                }
                                
                                // ประมวลผลบัตร
                                if($aValue['FTCvdStaPrc'] == '' || $aValue['FTCvdStaPrc'] == null){
                                    $tProcess = language('document/card/main', 'tMainWaitingForProcessing');
                                }else{
                                    if($aValue['FTCvdStaPrc'] == "1"){
                                        $tProcess = language('document/card/main','tMainSuccessProcessed');
                                    }
                                    if($aValue['FTCvdStaPrc'] == "2"){
                                        $tProcess = language('document/card/main','tMainUnsuccessProcessed');
                                    }
                                }
                            ?>
                            <tr class="text-center xCNTextDetail2 xWCardShiftChangeDataSource" id="otrCardShiftChangeDataSource<?php echo $aValue['rtRowID']; ?>" data-seq="<?php echo $aValue['FNCvdSeqNo']; ?>">
                                <td nowrap class="text-center"><?php echo $aValue['rtRowID']; ?></td>
                                <td nowrap class="xWCardShiftChangeCardCode text-left">
                                    <input id="oetCardShiftChangeCardName<?php echo $aValue['rtRowID']; ?>" name="oetCardShiftChangeCardName<?php echo $aValue['rtRowID']; ?>" type="text" disabled="true" value="<?php echo $aValue['FTCvdOldCode']; ?>">
                                    <input id="ohdCardShiftChangeCardCode<?php echo $aValue['rtRowID']; ?>" type="hidden" value="<?php echo $aValue['FTCvdOldCode']; ?>">
                                    <!-- เพิ่ม Hidden Holder ID -->
                                    <input type="hidden" id="ohdCardShiftChangeHoldID<?php echo $aValue['rtRowID']; ?>" value="<?php echo $aValue['FTCrdHolderID']; ?>">
                                </td>
                                <td nowrap class="xWCardShiftChangeNewCardCode text-left">
                                    <input id="oetCardShiftChangeNewCardName<?php echo $aValue['rtRowID']; ?>" name="oetCardShiftChangeNewCardName<?php echo $aValue['rtRowID']; ?>" type="text" disabled="true" value="<?php echo $aValue['FTCvdNewCode']; ?>">
                                    <input id="ohdCardShiftChangeNewCardCode<?php echo $aValue['rtRowID']; ?>" type="hidden" value="<?php echo $aValue['FTCvdNewCode']; ?>">
                                </td>
                                <?php if(true) : ?>
                                <td nowrap class="xWCardShiftChangeReason text-left">
                                    <input id="oetCardShiftChangeReasonName<?php echo $aValue['rtRowID']; ?>" name="" type="text" disabled="true" value="<?php echo $aValue['FTRsnName']; ?>">
                                    <input id="ohdCardShiftChangeReasonCode<?php echo $aValue['rtRowID']; ?>" type="hidden" value="<?php echo $aValue['FTRsnCode']; ?>">
                                </td>
                                <?php endif; ?>
                                <td nowrap class="text-left"><?php echo number_format($nValueOld, 2, ".", ""); ?></td>
                                <td nowrap class="xWCardShiftChangeStatus text-left">
                                    <?php echo $tStatusCard; ?>
                                    <input type="hidden" class="xWCardShiftChangeStatusCard" value="<?php echo $aValue['FTCvdStaCrd']; ?>">
                                </td>
                                <td nowrap class="text-left"><?php echo $tProcess; ?></td>
                                <td nowrap class="xWCardShiftChangeCardRmk text-left"><?php echo $aValue['FTCvdRmk']; ?></td>
                                <td nowrap class="text-center"> 
                                    <img class="xCNIconTable xWCardShiftChangeEdit" src="<?php echo  base_url('application/modules/common/assets/images/icons/edit.png'); ?>" onclick="JSxCardMngShiftChangeDataSourceEditOperator(this, event, <?php echo $aValue['FNCvdSeqNo']; ?>); JSxCardMngChangeSetCardCodeTemp();">
                                    <img class="xCNIconTable xWCardShiftChangeSave hidden" src="<?php echo  base_url('application/modules/common/assets/images/icons/save.png'); ?>" onclick="JSxCardMngShiftChangeDataSourceSaveOperator(this, event, <?php echo $aValue['FNCvdSeqNo']; ?>)">
                                    <img class="xCNIconTable xWCardShiftChangeCancel hidden" src="<?php echo  base_url('application/modules/common/assets/images/icons/reply_new.png'); ?>" onclick="JSxCardMngShiftChangeDataSourceCancelOperator(this, event)">
                                </td>
                                <td nowrap class="text-center">
                                    <img class="xCNIconTable" src="<?php echo  base_url('application/modules/common/assets/images/icons/delete.png'); ?>" onClick="JSxCardMngShiftChangeDataSourceDeleteOperator(this, event, <?php echo $nPage; ?>, '<?php echo $aValue['FTCvdOldCode']; ?>', <?php echo $aValue['FNCvdSeqNo']; ?>)">
                                </td>
                                <script>
                                $(document).ready(function(){  
                                    $('#oetCardShiftChangeCardName<?php echo $aValue['rtRowID']; ?>').click(function(){
                                        window.oCardShiftChangeBrowseCardOption<?php echo $aValue['rtRowID']; ?> = oCardShiftChangeBrowseCard<?php echo $aValue['rtRowID']; ?>(JStCardMngChangeGetCardCodeTemp());
                                        JCNxBrowseData('oCardShiftChangeBrowseCardOption<?php echo $aValue['rtRowID']; ?>');
                                    });
                                    $('#oetCardShiftChangeNewCardName<?php echo $aValue['rtRowID']; ?>').click(function(){
                                        let tOldCardCode = $('#ohdCardShiftChangeCardCode<?php echo $aValue['rtRowID']; ?>').val();
                                        window.oCardShiftChangeBrowseNewCardOption<?php echo $aValue['rtRowID']; ?> = oCardShiftChangeBrowseNewCard<?php echo $aValue['rtRowID']; ?>(tOldCardCode);
                                        JCNxBrowseData('oCardShiftChangeBrowseNewCardOption<?php echo $aValue['rtRowID']; ?>');
                                    });
                                    $('#oetCardShiftChangeReasonName<?php echo $aValue['rtRowID']; ?>').click(function(){
                                        window.oCardShiftChangeBrowseReasonOption<?php echo $aValue['rtRowID']; ?> = oCardShiftChangeBrowseReason<?php echo $aValue['rtRowID']; ?>();
                                        JCNxBrowseData('oCardShiftChangeBrowseReasonOption<?php echo $aValue['rtRowID']; ?>');
                                    });
                                });
                                
                                var nLangEdit = <?php echo $this->session->userdata("tLangEdit"); ?>;

                                // Browse Old Card
                                var oCardShiftChangeBrowseCard<?php echo $aValue['rtRowID']; ?> = function (ptNotCardCode) {
                                    let tNotIn = "";
                                    if(!ptNotCardCode == ""){
                                        tNotIn = "AND TFNMCard.FTCrdCode NOT IN (" + ptNotCardCode + ")";
                                    }
                                    var tWhereSessionID = "'"+ <?php echo $this->session->userdata("tSesSessionID");?> + "'";
                                    var oOptions = {
                                        Title: ['payment/card/card','tCRDTitle'],
                                        Table: {Master:'TFNMCard', PK:'FTCrdCode', PKName:'FTCrdName'},
                                        Join: {
                                            Table: ['TFNMCard_L','TFNTCrdVoidTmp', 'TFNMCardType'],
                                            On: [
                                                'TFNMCard_L.FTCrdCode = TFNMCard.FTCrdCode AND TFNMCard_L.FNLngID = ' + nLangEdits,
                                                "TFNMCard.FTCrdCode = TFNTCrdVoidTmp.FTCvdOldCode AND TFNTCrdVoidTmp.FTSessionID = " + tWhereSessionID,
                                                'TFNMCardType.FTCtyCode = TFNMCard.FTCtyCode'
                                            ]
                                        },
                                        Where: {
                                            Condition: [
                                                " AND ((TFNMCardType.FTCtyStaShift = '2') OR ((TFNMCardType.FTCtyStaShift = '1') AND (TFNMCard.FTCrdStaShift = '1')) AND (TFNMCard.FTCrdStaActive = '1') AND (CONVERT(date, TFNMCard.FDCrdExpireDate) > CONVERT(date, GETDATE())))",
                                                " AND (TFNTCrdVoidTmp.FTCvdOldCode IS NULL)" + tNotIn
                                            ]
                                        },
                                        GrideView:{
                                            ColumnPathLang: 'payment/card/card',
                                            ColumnKeyLang: ['tCRDTBCode', 'tCRDTBName', ''],
                                            WidthModal: 50,
                                            DataColumns: ['TFNMCard.FTCrdCode', 'TFNMCard_L.FTCrdName', 'TFNMCard.FTCrdHolderID'],
                                            DisabledColumns: [2],
                                            DataColumnsFormat: ['', '', ''],
                                            Perpage: 500,
                                            OrderBy: ['TFNMCard_L.FTCrdName'],
                                            SourceOrder: "ASC"
                                        },
                                        CallBack:{
                                            ReturnType: 'S',
                                            Value: ["ohdCardShiftChangeCardCode<?php echo $aValue['rtRowID']; ?>", "TFNMCard.FTCrdCode"],
                                            Text: ["oetCardShiftChangeCardName<?php echo $aValue['rtRowID']; ?>", "TFNMCard.FTCrdCode"]
                                        },
                                        NextFunc:{
                                            //เพิ่ม Hidden Holder ID
                                            FuncName: 'JSxCardShiftChangeCallBackCardChange<?php echo $aValue['rtRowID']; ?>',
                                            ArgReturn: ['FTCrdCode', 'FTCrdHolderID']
                                        },
                                        RouteAddNew: 'card',
                                        BrowseLev: nStaCmdBrowseType
                                        // DebugSQL: true
                                    };
                                    return oOptions;
                                };

                                // Browse New Card
                                var oCardShiftChangeBrowseNewCard<?php echo $aValue['rtRowID']; ?> = function (ptNotCardCode) {
                                    
                                    let tNotIn = "";
                                    if(!ptNotCardCode == ""){
                                        tNotIn = "AND TFNMCard.FTCrdCode NOT IN ('" + ptNotCardCode + "')";
                                    }
                                    
                                    var tHolID = $('#ohdCardShiftChangeHoldID<?php echo $aValue['rtRowID']; ?>').val();
                                    var tWhereSessionID = "'"+ <?php echo $this->session->userdata("tSesSessionID");?> + "'";
                                    let oOptions = {
                                        Title : ['payment/card/card','tCRDTitle'],
                                        Table:{Master:'TFNMCard', PK:'FTCrdCode', PKName:'FTCrdName'},
                                        Join :{
                                            Table: ['TFNMCard_L','TFNTCrdVoidTmp', 'TFNMCardType'],
                                            On: [
                                                'TFNMCard_L.FTCrdCode = TFNMCard.FTCrdCode AND TFNMCard_L.FNLngID = ' + nLangEdits,
                                                "TFNMCard.FTCrdCode = TFNTCrdVoidTmp.FTCvdOldCode AND TFNTCrdVoidTmp.FTSessionID = " + tWhereSessionID,
                                                'TFNMCardType.FTCtyCode = TFNMCard.FTCtyCode'
                                            ]
                                        },
                                        Where :{
                                            Condition: function(){
                                                var  tSQLBalance = "" +
                                                " AND TFNMCard.FTCrdCode IN (SELECT CB.FTCrdCode FROM(SELECT CRD.FTCrdCode, SUM(CASE WHEN CRDB.FTCrdTxnCode='001' THEN ISNULL(CRDB.FCCrdValue,0) ELSE 0 END) CashIn," + 
                                                " SUM(CASE WHEN CRDB.FTCrdTxnCode='002' THEN ISNULL(CRDB.FCCrdValue,0) ELSE 0 END) Promotion , SUM(CASE WHEN CRDB.FTCrdTxnCode='003' THEN ISNULL(CRDB.FCCrdValue,0)" +
                                                " ELSE 0 END) DepositCrd , SUM(CASE WHEN CRDB.FTCrdTxnCode='004' THEN ISNULL(CRDB.FCCrdValue,0) ELSE 0 END) DepositPdt , SUM(CASE WHEN CRDB.FTCrdTxnCode='005' THEN ISNULL(CRDB.FCCrdValue,0)" +
                                                " ELSE 0 END) NotReturn , SUM(CASE WHEN CRDB.FTCrdTxnCode='006' THEN ISNULL(CRDB.FCCrdValue,0) ELSE 0 END) Payment FROM TFNMCard CRD WITH (NOLOCK)" +
                                                " LEFT JOIN TFNMCardBal CRDB WITH (NOLOCK) ON CRDB.FTCrdCode = CRD.FtCrdCode GROUP BY CRD.FTCrdCode ) CB WHERE ((CB.CashIn + CB.Promotion) - CB.Payment ) = 0)";

                                                return [
                                                    " AND ( (TFNMCardType.FTCtyStaShift = '2') OR ((TFNMCardType.FTCtyStaShift = '1') AND (TFNMCard.FTCrdStaShift = '1')) AND (TFNMCard.FTCrdStaActive = '2') " + tSQLBalance + "AND (CONVERT(date, TFNMCard.FDCrdExpireDate) > CONVERT(date, GETDATE())) ) AND TFNMCard.FTCrdHolderID = '" + tHolID + "' " + tNotIn,
                                                    " AND (TFNTCrdVoidTmp.FTCvdOldCode IS NULL)"
                                                ]
                                            }
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
                                            Value: ["ohdCardShiftChangeNewCardCode<?php echo $aValue['rtRowID']; ?>", "TFNMCard.FTCrdCode"],
                                            Text: ["oetCardShiftChangeNewCardName<?php echo $aValue['rtRowID']; ?>", "TFNMCard.FTCrdCode"]
                                        },
                                        NextFunc:{
                                            FuncName: 'JSxCardShiftChangeCallBackCardChange',
                                            ArgReturn: ['FTCrdCode', 'FTCrdHolderID']
                                        },
                                        RouteAddNew : 'card',
                                        BrowseLev : nStaCmdBrowseType
                                        // DebugSQL: true
                                    };
                                    return oOptions;
                                };

                                // Browse Reason
                                var oCardShiftChangeBrowseReason<?php echo $aValue['rtRowID']; ?> = function () {                                
                                    let oOptions = {
                                        Title : ['other/reason/reason','tRSNTitle'],
                                        Table:{Master:'TCNMRsn', PK:'FTRsnCode'},
                                        Join :{
                                            Table: ['TCNMRsn_L'],
                                            On: ['TCNMRsn_L.FTRsnCode = TCNMRsn.FTRsnCode AND TCNMRsn_L.FNLngID = '+nLangEdits]
                                        },
                                        Where :{
                                            Condition : ["AND TCNMRsn.FTRsgCode = '007' "]
                                        },
                                        GrideView:{
                                            ColumnPathLang	: 'other/reason/reason',
                                            ColumnKeyLang	: ['tRSNTBCode', 'tRSNTBName'],
                                            // ColumnsSize     : ['15%', '85%'],
                                            WidthModal      : 50,
                                            DataColumns		: ['TCNMRsn.FTRsnCode', 'TCNMRsn_L.FTRsnName'],
                                            DisabledColumns	:[],
                                            DataColumnsFormat : ['', ''],
                                            Perpage			: 5,
                                            OrderBy			: ['TCNMRsn_L.FTRsnName'],
                                            SourceOrder		: "ASC"
                                        },
                                        CallBack:{
                                            ReturnType	: 'S',
                                            Value		: ["ohdCardShiftChangeReasonCode<?php echo $aValue['rtRowID']; ?>", "TCNMRsn.FTRsnCode"],
                                            Text		: ["oetCardShiftChangeReasonName<?php echo $aValue['rtRowID']; ?>", "TCNMRsn_L.FTRsnName"]
                                        },
                                        RouteAddNew : 'reason',
                                        BrowseLev : nStaCmdBrowseType
                                    };
                                    return oOptions;
                                };

                                function JSxCardShiftChangeCallBackCardChange<?php echo $aValue['rtRowID']; ?>(poHold){
                                    try{
                                        paHold= JSON.parse(poHold);
                                        $('#ohdCardShiftChangeHoldID'+<?php echo $aValue['rtRowID']; ?>).val(paHold[1]);
                                    }catch(err){
                                        console.log('JSxCardShiftChangeCallBackCardChange Error: ', err);
                                    }
                                }
                                </script>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                            <tr id="otrCardShiftChangeNoData"><td nowrap class='text-center xCNTextDetail2' colspan='10'><?php echo language('common/main/main','tCMNNotFoundData'); ?></td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="row">
    <!-- เปลี่ยน -->
    <div class="col-md-6">
        <p><?= language('common/main/main','tResultTotalRecord')?> <?=$aDataList['rnAllRow']?> <?= language('common/main/main','tRecord')?> <?= language('common/main/main','tCurrentPage')?> <?=$aDataList['rnCurrentPage']?> / <?=$aDataList['rnAllPage']?></p>
    </div>
	<!-- เปลี่ยน -->
    <div class="col-md-6">
        <input type="hidden" id="ohdCardShiftChangeDataSourceCurrentPage" value="<?php echo $nPage ?>">
        <div class="xWCardShiftChangeDataSourcePage btn-toolbar pull-right"> <!-- เปลี่ยนชื่อ Class เป็นของเรื่องนั้นๆ --> 
            <?php if($nPage == 1){ $tDisabledLeft = 'disabled'; }else{ $tDisabledLeft = '-';} ?>
            <button onclick="JSvCardShiftChangeDataSourceClickPage('previous','<?=$ptDocType?>','<?=$tIDElement?>')" class="btn btn-white btn-sm" <?php echo $tDisabledLeft ?>> <!-- เปลี่ยนชื่อ Onclick เป็นของเรื่องนั้นๆ --> 
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
                <button onclick="JSvCardShiftChangeDataSourceClickPage('<?php echo $i?>','<?=$ptDocType?>','<?=$tIDElement?>')" type="button" class="btn xCNBTNNumPagenation <?php echo $tActive ?>" <?php echo $tDisPageNumber ?>><?php echo $i?></button>
            <?php } ?>
            <?php if($nPage >= $aDataList['rnAllPage']){  $tDisabledRight = 'disabled'; }else{  $tDisabledRight = '-';  } ?>
            <button onclick="JSvCardShiftChangeDataSourceClickPage('next','<?=$ptDocType?>','<?=$tIDElement?>')" class="btn btn-white btn-sm" <?php echo $tDisabledRight ?>> <!-- เปลี่ยนชื่อ Onclick เป็นของเรื่องนั้นๆ --> 
                <i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
            </button>
        </div>
    </div>
</div>

<!-- Modal Delete Table -->
<div class="modal fade" id="odvCardShiftChangeModalConfirmDelRecord">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header xCNModalHead">
                <label class="xCNTextModalHeard"><?php echo language('common/main/main', 'tModalDelete') ?></label>
            </div>
            <div class="modal-body">
                <span class="xCNTextModal" style="display: inline-block; word-break:break-all"><?php echo language('common/main/main', 'tModalDeleteSingle'); ?> <span id="ospCardShiftChangeConfirDelMessage"></span></span>
            </div>
            <div class="modal-footer">
                <button id="osmCardShiftChangeConfirmDelRecord" type="button" class="btn xCNBTNPrimery">
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

<?php include "script/wCardMngTranfDataSourceTable.php"; ?>







