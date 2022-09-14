<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="table-responsive">
            <!--  จำนวนบัตรทั้งหมดในการ Import -->
            <input type="hidden" class="xWCardMngCountRowFromTemp" id="ohdCardMngNewCardCountRowFromTemp" name="ohdCardMngNewCardCountRowFromTemp" value="<?php echo FSnSelectCountResult('TFNTCrdImpTmp'); ?>">
             <!-- จำนวนบัตรมีข้อมูลมี่ถูกต้อง -->
            <input type="hidden" id="ohdCardMngNewCardCountSuccess" name="ohdCardMngNewCardCountSuccess" value="<?php echo FSnSelectCountResultSuccess('TFNTCrdImpTmp'); ?>">
            
            <table class="table table-striped" id="otbCrdMngNewCardCardTable">
                <thead>
                    <tr>
                        <th nowrap class="xCNTextBold text-center" style="width:5%;"><?php  echo language('common/main/main','tCMNSequence')?></th>
                        <th nowrap class="xCNTextBold text-center" style="width:20%;"><?php echo language('document/card/newcard','tCardShiftNewCardTBCode'); ?></th>
                        <th nowrap class="xCNTextBold text-center" style="width:20%;"><?php echo language('document/card/newcard','tCardShiftNewCardTBName'); ?></th>
                        <th nowrap class="xCNTextBold text-center" style="width:20%;"><?php echo language('document/card/newcard','tCardShiftNewCardTBCardType'); ?></th>
                        <th nowrap class="xCNTextBold text-center" style="width:20%;"><?php echo language('document/card/newcard','tCardShiftNewCardTBDepartmentName'); ?></th>
                        <th nowrap class="xCNTextBold text-center" style="width:5%;"><?php  echo language('document/card/newcard','tCardShiftNewCardTBCardStatus'); ?></th>
                        <th nowrap class="xCNTextBold text-center" style="width:5%;"><?php  echo language('document/card/newcard','tCardShiftNewCardTBProcessStatus'); ?></th>
                        <th nowrap class="xCNTextBold text-center" style="width:5%;"><?php  echo language('document/card/newcard','tCardShiftNewCardTBRmk'); ?></th>
                        <th nowrap class="xCNTextBold text-center" style="width:5%;"><?php  echo language('document/card/newcard','tCardShiftNewCardTBEdit'); ?></th>
                        <th nowrap class="xCNTextBold text-center" style="width:5%;"><?php  echo language('document/card/newcard','tCardShiftNewCardTBDelete'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if($aDataList['rtCode'] == 1) : ?>
                        <?php foreach($aDataList['raItems'] as $key => $aValue) :?>
                            <?php
                                $tFNSeq = $aValue['rtRowID'];
                                
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
                                if(empty($aValue['FTCidStaPrc'])){
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
                            <tr class="text-center xCNTextDetail2 xWCardMngNewCardDataSource" id="otrCardMngNewCardDataSource<?php echo $aValue['rtRowID']; ?>" data-seq="<?php echo $aValue['FNCidSeqNo']; ?>">
                                <td nowrap class="text-center"><?php echo $aValue['rtRowID']; ?></td>
                                <td nowrap class="xWCardMngNewCardCardCode text-left">
                                    <input id="oetCardMngNewCardCode<?php echo $aValue['rtRowID']; ?>" name="oetCardMngNewCardCode<?php echo $aValue['rtRowID']; ?>" type="text" disabled="true" value="<?php echo $aValue['FTCidCrdCode']; ?>" maxlength="30">
                                </td>
                                <td nowrap class="xWCardMngNewCardCardName text-left">
                                    <input id="oetCardMngNewCardCardName<?php echo $aValue['rtRowID']; ?>" name="oetCardMngNewCardCardName<?php echo $aValue['rtRowID']; ?>" type="text" disabled="true" value="<?php echo $aValue['FTCidCrdName']; ?>" maxlength="255">
                                </td>
                                <td nowrap class="xWCardMngNewCardCty text-left">
                                    <input id="oetCardMngNewCardCtyName<?php echo $aValue['rtRowID']; ?>" name="oetCardMngNewCardCtyName<?php echo $aValue['rtRowID']; ?>" type="text" disabled="true" value="<?php echo $aValue['FTCtyName']; ?>">
                                    <input id="ohdCardMngNewCardCtyCode<?php echo $aValue['rtRowID']; ?>" name="ohdCardMngNewCardCtyCode<?php echo $aValue['rtRowID']; ?>" type="hidden" value="<?php echo $aValue['FTCtyCode']; ?>">
                                </td>
                                <td nowrap class="xWCardMngNewCardDepart text-left">
                                    <input id="oetCardMngNewCardDptName<?php echo $aValue['rtRowID']; ?>" name="oetCardMngNewCardDptName<?php echo $aValue['rtRowID']; ?>" type="text" disabled="true" value="<?php echo $aValue['FTDptName']; ?>">
                                    <input id="ohdCardMngNewCardDptCode<?php echo $aValue['rtRowID']; ?>" name="ohdCardMngNewCardDptCode<?php echo $aValue['rtRowID']; ?>" type="hidden" value="<?php echo $aValue['FTCidCrdDepart']; ?>">
                                </td>
                                <td nowrap class="xWCardMngNewCardStatus text-left">
                                    <?php echo $tStatusCard; ?>
                                    <input type="hidden" class="xWCardMngNewCardStatus" value="<?php echo $aValue['FTCidStaCrd']; ?>">
                                </td>
                                <td nowrap class="text-left"><?php echo $tProcess; ?></td>
                                <td nowrap class="text-left"><?php echo $aValue['FTCidRmk']; ?></td>
                                <td nowrap class="text-center">
                                    <img class="xCNIconTable xWCardMngNewCardEdit" src="<?php echo  base_url('application/modules/common/assets/images/icons/edit.png'); ?>" onclick="JSxCardMngNewCardDataSourceEditOperator(this, event, <?php echo $aValue['FNCidSeqNo']; ?>)">
                                    <img class="xCNIconTable xWCardMngNewCardSave hidden" src="<?php echo  base_url('application/modules/common/assets/images/icons/save.png'); ?>" onclick="JSxCardMngNewCardDataSourceSaveOperator(this, event, <?php echo $aValue['FNCidSeqNo']; ?>, <?php echo $nPage; ?>)">
                                    <img class="xCNIconTable xWCardMngNewCardCancel hidden" src="<?php echo  base_url('application/modules/common/assets/images/icons/reply_new.png'); ?>" onclick="JSxCardMngNewCardDataSourceCancelOperator(this, event)">
                                </td>
                                <td nowrap class="text-center">
                                    <img class="xCNIconTable" src="<?php echo  base_url('application/modules/common/assets/images/icons/delete.png'); ?>" onClick="JSxCardMngNewCardDataSourceDeleteOperator(this, event, <?php echo $nPage; ?>, '<?php echo $aValue['FTCidCrdCode']; ?>', <?php echo $aValue['FNCidSeqNo']; ?>)">
                                </td>
                            </tr>
                            <script type=text/javascript>
                                var nLangEdit = <?php echo $this->session->userdata("tLangEdit"); ?>;
                                $(document).ready(function () {
                                    // คลิกปุ่มประเภทบัตร
                                    $('#oetCardMngNewCardCtyName<?php echo $aValue['rtRowID']; ?>').click(function() {
                                        window.oCardMngNewCardBrowseNewCardCtyOption<?php echo $aValue['rtRowID']; ?> = oCardMngNewCardBrowseNewCardCty<?php echo $aValue['rtRowID']; ?>();
                                        JCNxBrowseData('oCardMngNewCardBrowseNewCardCtyOption<?php echo $aValue['rtRowID']; ?>');
                                    });
                                    // คลิกปุ่มหน่วยหงาน//แผนก
                                    $('#oetCardMngNewCardDptName<?php echo $aValue['rtRowID']; ?>').click(function() {
                                        window.oCardMngNewCardBrowseNewCardDptOption<?php echo $aValue['rtRowID']; ?> = oCardMngNewCardBrowseNewCardDpt<?php echo $aValue['rtRowID']; ?>();
                                        JCNxBrowseData('oCardMngNewCardBrowseNewCardDptOption<?php echo $aValue['rtRowID']; ?>');
                                    })
                                });
                                // Option Select Modal Browse Card Type
                                var oCardMngNewCardBrowseNewCardCty<?php echo $aValue['rtRowID']; ?> = function () {
                                    var oOptions = {
                                        Title: ['payment/cardtype/cardtype', 'tCTYTitle'],
                                        Table:{Master:'TFNMCardType', PK:'FTCtyCode'},
                                        Join: {
                                            Table: ['TFNMCardType_L'],
                                            On: ['TFNMCardType_L.FTCtyCode = TFNMCardType.FTCtyCode AND TFNMCardType_L.FNLngID = '+nLangEdit]
                                        },
                                        GrideView: {
                                            ColumnPathLang: 'payment/cardtype/cardtype',
                                            ColumnKeyLang: ['tCTYCode', 'tCTYName'],
                                            WidthModal: 50,
                                            DataColumns: ['TFNMCardType.FTCtyCode', 'TFNMCardType_L.FTCtyName'],
                                            DisabledColumns: [],
                                            DataColumnsFormat: ['', ''],
                                            Perpage: 100,
                                            OrderBy: ['TFNMCardType_L.FTCtyName'],
                                            SourceOrder: "ASC"
                                        },
                                        CallBack:{
                                            ReturnType: 'S',
                                            Value: ["ohdCardMngNewCardCtyCode<?php echo $aValue['rtRowID']; ?>", "TFNMCardType.FTCtyCode"],
                                            Text: ["oetCardMngNewCardCtyName<?php echo $aValue['rtRowID']; ?>", "TFNMCardType.FTCtyName"]
                                        },
                                        RouteAddNew: 'cardtype',
                                        BrowseLev: nStaCmdBrowseType
                                    }
                                    return oOptions;
                                }

                                // Option Select Modal Browse  Depart
                                var oCardMngNewCardBrowseNewCardDpt<?php echo $aValue['rtRowID']; ?> = function () {
                                    var oOptions = {
                                        Title: ['authen/department/department', 'tDPTTitle'],
                                        Table: {Master:'TCNMUsrDepart', PK:'FTDptCode'},
                                        Join: {
                                            Table: ['TCNMUsrDepart_L'],
                                            On: ['TCNMUsrDepart_L.FTDptCode = TCNMUsrDepart.FTDptCode AND TCNMUsrDepart_L.FNLngID = '+nLangEdit]
                                        },
                                        GrideView: {
                                            ColumnPathLang: 'authen/department/department',
                                            ColumnKeyLang: ['tDPTTBCode', 'tDPTTBName'],
                                            WidthModal: 50,
                                            DataColumns: ['TCNMUsrDepart.FTDptCode', 'TCNMUsrDepart_L.FTDptName'],
                                            DisabledColumns: [],
                                            DataColumnsFormat: ['', ''],
                                            Perpage: 100,
                                            OrderBy: ['TCNMUsrDepart_L.FTDptName'],
                                            SourceOrder: "ASC"
                                        },
                                        CallBack:{
                                            ReturnType: 'S',
                                            Value: ["ohdCardMngNewCardDptCode<?php echo $aValue['rtRowID']; ?>", "TCNMUsrDepart.FTDptName"],
                                            Text: ["oetCardMngNewCardDptName<?php echo $aValue['rtRowID']; ?>", "TCNMUsrDepart.FTDptName"]
                                        },
                                        RouteAddNew: 'department',
                                        BrowseLev: nStaCmdBrowseType
                                    }
                                    return oOptions;
                                }
                            </script>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr id="otrCardMngNewCardNoData">
                            <td nowrap class='text-center xCNTextDetail2' colspan='10'><?php echo language('common/main/main','tCMNNotFoundData'); ?></td>
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
        <input type="hidden" id="ohdCardMngNewCardDataSourceCurrentPage" value="<?php echo $nPage ?>">
        <div class="xWCardMngNewCardDataSourcePage btn-toolbar pull-right"> <!-- เปลี่ยนชื่อ Class เป็นของเรื่องนั้นๆ --> 
            <?php if($nPage == 1){ $tDisabledLeft = 'disabled'; }else{ $tDisabledLeft = '-';} ?>
            <button onclick="JSvCardMngNewCardDataSourceClickPage('previous','<?=$ptDocType?>','<?=$tIDElement?>')" class="btn btn-white btn-sm" <?php echo $tDisabledLeft ?>> <!-- เปลี่ยนชื่อ Onclick เป็นของเรื่องนั้นๆ --> 
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
                <button onclick="JSvCardMngNewCardDataSourceClickPage('<?php echo $i?>','<?=$ptDocType?>','<?=$tIDElement?>')" type="button" class="btn xCNBTNNumPagenation <?php echo $tActive ?>" <?php echo $tDisPageNumber ?>><?php echo $i?></button>
            <?php } ?>
            <?php if($nPage >= $aDataList['rnAllPage']){  $tDisabledRight = 'disabled'; }else{  $tDisabledRight = '-';  } ?>
            <button onclick="JSvCardMngNewCardDataSourceClickPage('next','<?=$ptDocType?>','<?=$tIDElement?>')" class="btn btn-white btn-sm" <?php echo $tDisabledRight ?>> <!-- เปลี่ยนชื่อ Onclick เป็นของเรื่องนั้นๆ --> 
                <i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
            </button>
        </div>
    </div>
</div>

<!-- Modal Delete Table -->
    <div class="modal fade" id="odvCardMngNewCardModalConfirmDelRecord">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header xCNModalHead">
                    <label class="xCNTextModalHeard"><?php echo language('common/main/main', 'tModalDelete') ?></label>
                </div>
                <div class="modal-body">
                    <span class="xCNTextModal" style="display: inline-block; word-break:break-all"><?php echo language('common/main/main', 'tModalDeleteSingle'); ?> <span id="ospCardMngNewCardConfirDelMessage"></span></span>
                </div>
                <div class="modal-footer">
                    <button id="osmCardMngNewCardConfirmDelRecord" type="button" class="btn xCNBTNPrimery">
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
            'tQtyAllRow'    : $('#ohdCardMngNewCardCountRowFromTemp').val(),
            'tQtySucessRow' : $('#ohdCardMngNewCardCountSuccess').val()
        };
        JSxSetQtyCardAllAndAllRow(oSetQtySucessAllRow);
    });
</script>

<?php include "script/wCardMngNewCardDataSourceTable.php"; ?>










