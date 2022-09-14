
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="table-responsive">
            <span class="hidden" id="ohdCrdMngClearCardCardCodeTemp"><?php echo $tDataListAll; ?></span>
            <input type="hidden" class="xWCardMngCountRowFromTemp" id="ohdCardMngShiftClearCountRowFromTemp" name="ohdCardMngShiftClearCountRowFromTemp" value="<?php echo FSnSelectCountResult('TFNTCrdImpTmp'); ?>">
            <input type="hidden" id="ohdCardMngShiftClearCountSuccess" name="ohdCardMngShiftClearCountSuccess" value="<?php echo FSnSelectCountResultSuccess('TFNTCrdImpTmp'); ?>">

            <input type="hidden" id="ohdCrdMngClearCardCountRowFromTemp" name="ohdCrdMngClearCardCountRowFromTemp" value="<?php echo $rnAllRow;?>">
            <table class="table table-striped" id="otbCrdMngClearCardCardTable">
                <thead>
                    <tr>
                        <th nowrap class="xCNTextBold" style="width:5%;text-align:center;"><?= language('document/card/main','tMainNumber')?></th>
                        <th nowrap class="xCNTextBold" style="width:20%;text-align:left;"><?= language('document/card/main','tExcelClearCardCode')?></th>
                        <th nowrap class="xCNTextBold" style="width:20%;text-align:left;"><?= language('document/card/main','tExcelClearCardStatus')?></th>
                        <th nowrap class="xCNTextBold" style="width:15%;text-align:left;"><?= language('document/card/main','tExcelClearCardProcessStatus')?></th>
                        <th nowrap class="xCNTextBold" style="text-align:center;"><?= language('document/card/main','tExcelClearCardRemark')?></th>
                        <th nowrap class="xCNTextBold" style="width:10%;text-align:center;"><?= language('document/card/main','tMainEdit')?></th>
                        <th nowrap class="xCNTextBold" style="width:10%;text-align:center;"><?= language('document/card/main','tMainDelete')?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if($aDataList['rtCode'] == 1) : ?>
                        <?php $nTotalResult = $aDataList['CountTopUP'][0]['Total']; ?>
                        <?php foreach($aDataList['raItems'] as $key => $aValue) : ?>
                            <?php
                                $tFNSeq = $aValue['FNCidSeqNo'];

                                // เช็คสถานะบัตร
                                if($aValue['FTCidStaCrd'] == '1'){
                                    $tClassSta      = "xWImpStaSuccess";
                                    $tTextStaCrd    = language('document/card/main','tMainSuccess');
                                    $tStatusCard    = '<img class="xCNIconTable" src="' . base_url() . 'application/modules/common/assets/images/icons/OK-Approve.png"> <span class="text-success">' . $tTextStaCrd . '</span>';
                                }else{
                                    $tClassSta      = "xWImpStaUnsuccess";
                                    $tTextStaCrd    = language('document/card/main','tMainUnSuccess');
                                    $tStatusCard    = '<img class="xCNIconTable" src="' . base_url() . 'application/modules/common/assets/images/icons/cancel.png"> <span class="text-danger">' . $tTextStaCrd . '</span>';
                                }

                                // ประมวลผลบัตร
                                if($aValue['FTCidStaPrc'] == '' || $aValue['FTCidStaPrc'] == null){
                                    $tProcess = language('document/card/main', 'tMainWaitingForProcessing');
                                }else{
                                    if($aValue['FTCidStaPrc'] == "1"){
                                        $tProcess = language('document/card/main','tMainSuccessProcessed');
                                    }
                                    if($aValue['FTCidStaPrc'] == "2"){
                                        $tProcess = language('document/card/main','tMainUnsuccessProcessed');
                                    }
                                }
                            ?>
                            <tr class="text-center xCNTextDetail2 xWCardMngClearDataSource" id="otrCardMngClearDataSource<?php echo $aValue['rtRowID']; ?>" data-seq="<?php echo $aValue['FNCidSeqNo']; ?>">
                                <td nowrap class="text-center"><?php echo $aValue['rtRowID']; ?></td>
                                <td nowrap class="xWCardMngClearCardCode text-left">
                                    <input id="oetCardMngClearCardCode<?php echo $aValue['rtRowID']; ?>" name="oetCardMngClearCardCode<?php echo $aValue['rtRowID']; ?>" type="text" disabled="true" value="<?php echo $aValue['FTCidCrdCode']; ?>">
                                    <input id="oetCardMngClearCardValueCode<?php echo $aValue['rtRowID']; ?>" type="hidden" value="<?php echo $aValue['FTCidCrdCode']; ?>">
                                </td>
                                <td nowrap class="xWCardMngClearStatus text-left">
                                    <?php echo $tStatusCard; ?>
                                    <input type="hidden" class="xWCardMngClearStatusCard" value="<?php echo $aValue['FTCidStaCrd']; ?>">
                                </td>
                                <td nowrap class="text-left"><?php echo $tProcess; ?></td>
                                <td nowrap class="xWCardMngClearCardRmk text-left"><?php echo $aValue['FTCidRmk']; ?></td>

                                <td nowrap class="text-center"> 
                                    <img class="xCNIconTable xWCardMngClearEdit" src="<?php echo  base_url('application/modules/common/assets/images/icons/edit.png'); ?>" onclick="JSxCardMngClearDataSourceEditOperator(this, event, <?php echo $aValue['FNCidSeqNo']; ?>)">
                                    <img class="xCNIconTable xWCardMngClearSave hidden" src="<?php echo  base_url('application/modules/common/assets/images/icons/save.png'); ?>" onclick="JSxCardMngClearDataSourceSaveOperator(this, event, <?php echo $aValue['FNCidSeqNo']; ?>)">
                                    <img class="xCNIconTable xWCardMngClearCancel hidden" src="<?php echo  base_url('application/modules/common/assets/images/icons/reply_new.png'); ?>" onclick="JSxCardMngClearDataSourceCancelOperator(this, event)">
                                </td>
                                <td nowrap class="text-center">
                                    <img class="xCNIconTable" src="<?php echo  base_url('application/modules/common/assets/images/icons/delete.png'); ?>" onClick="JSxCardMngClearDataSourceDeleteOperator(this, event, <?php echo $nPage; ?>, '<?php echo $aValue['FTCidCrdCode']; ?>', <?php echo $aValue['FNCidSeqNo']; ?>)">
                                </td>
                            </tr>
                            <script>
                                $(document).ready(() => {  
                                    $('#oetCardMngClearCardCode<?php echo $aValue['rtRowID']; ?>').click(function(){
                                        window.oCardMngClearBrowseCardOption<?php echo $aValue['rtRowID']; ?> = oCardMngClearBrowseCard<?php echo $aValue['rtRowID']; ?>();
                                        JCNxBrowseData('oCardMngClearBrowseCardOption<?php echo $aValue['rtRowID']; ?>');
                                    });
                                });
                                
                                var nLangEdit = <?php echo $this->session->userdata("tLangEdit"); ?>;
                                var oCardMngClearBrowseCard<?php echo $aValue['rtRowID']; ?> = function () {
                                    var tWhereSessionID = "'"+ <?php echo $this->session->userdata("tSesSessionID");?> + "'";
                                    let oOptions = {
                                        Title : ['payment/card/card','tCRDTitle'],
                                        Table:{Master:'TFNMCard', PK:'FTCrdCode', PKName:'FTCrdName'},
                                        Join :{
                                            Table: ['TFNMCard_L','TFNTCrdImpTmp','TFNMCardType'],
                                            On: [
                                                "TFNMCard.FTCrdCode = TFNMCard_L.FTCrdCode AND TFNMCard_L.FNLngID = " + nLangEdit ,
                                                "TFNMCard.FTCrdCode	= TFNTCrdImpTmp.FTCidCrdCode AND TFNTCrdImpTmp.FTSessionID = " + tWhereSessionID,
                                                'TFNMCardType.FTCtyCode = TFNMCard.FTCtyCode'
                                            ]
                                        },
                                        Where :{
                                            Condition : [
                                                " AND (TFNMCardType.FTCtyStaShift = '1') AND (TFNMCard.FTCrdStaActive = '1') AND (TFNMCard.FTCrdStaShift = '1') AND (CONVERT(date, TFNMCard.FDCrdExpireDate) > CONVERT(date, GETDATE())) ",
                                                " AND (TFNTCrdImpTmp.FTCidCrdCode IS NULL)"
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
                                            Value: ["oetCardMngClearCardCode<?php echo $aValue['rtRowID']; ?>", "TFNMCard.FTCrdCode"],
                                            Text: ["oetCardMngClearCardValueCode<?php echo $aValue['rtRowID']; ?>", "TFNMCard.FTCrdCode"]
                                        },
                                        RouteAddNew: 'card',
                                        BrowseLev: nStaCmdBrowseType,
                                        // DebugSQL: true
                                    }
                                    return oOptions;
                                }
                            </script>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr id="otrCardMngClearNoData"><td nowrap class='text-center xCNTextDetail2' colspan='99'><?php echo language('common/main/main','tCMNNotFoundData'); ?></td></tr>
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
        <input type="hidden" id="ohdCardMngClearDataSourceCurrentPage" value="<?php echo $nPage ?>">
        <div class="xWCardMngClearDataSourcePage btn-toolbar pull-right"> <!-- เปลี่ยนชื่อ Class     --> 
            <?php if($nPage == 1){ $tDisabledLeft = 'disabled'; }else{ $tDisabledLeft = '-';} ?>
            <button onclick="JSvCardMngClearDataSourceClickPage('previous','<?=$ptDocType?>','<?=$tIDElement?>')" class="btn btn-white btn-sm" <?php echo $tDisabledLeft ?>> <!-- เปลี่ยนชื่อ Onclick เป็นของเรื่องนั้นๆ --> 
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
                <button onclick="JSvCardMngClearDataSourceClickPage('<?php echo $i?>','<?=$ptDocType?>','<?=$tIDElement?>')" type="button" class="btn xCNBTNNumPagenation <?php echo $tActive ?>" <?php echo $tDisPageNumber ?>><?php echo $i?></button>
            <?php } ?>
            <?php if($nPage >= $aDataList['rnAllPage']){  $tDisabledRight = 'disabled'; }else{  $tDisabledRight = '-';  } ?>
            <button onclick="JSvCardMngClearDataSourceClickPage('next','<?=$ptDocType?>','<?=$tIDElement?>')" class="btn btn-white btn-sm" <?php echo $tDisabledRight ?>> <!-- เปลี่ยนชื่อ Onclick เป็นของเรื่องนั้นๆ --> 
                <i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
            </button>
        </div>
    </div>
</div>

<!-- Modal Delete Table -->
<div class="modal fade" id="odvCardMngClearModalConfirmDelRecord">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header xCNModalHead">
				<label class="xCNTextModalHeard"><?php echo language('common/main/main', 'tModalDelete')?></label>
			</div>
			<div class="modal-body">
                <span class="xCNTextModal" style="display: inline-block; word-break:break-all"><?php echo language('common/main/main', 'tModalDeleteSingle'); ?> <span id="ospCardMngClearConfirDelMessage"></span></span>
			</div>
			<div class="modal-footer">
				<button id="osmCardMngClearConfirmDelRecord" type="button" class="btn xCNBTNPrimery">
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
    JSXCalculateTotal();
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
    }
</script>

<?php include "script/wCardMngClearDataSourceTable.php"; ?>

