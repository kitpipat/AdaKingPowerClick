<style>
    #odvPanelMngDataDetail {
        padding-left : 15px !important;
        padding-right : 15px !important;
    }
    .xWMsgConditonErr{
        color: red !important;
        font-size: 18px !important;
    }
</style>

<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4" style="padding:0">

     <!--Panel ข้อมูลเอกสาร-->
     <div class="panel panel-default" style="margin-bottom: 25px;">
        <div class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
            <label class="xCNTextDetail1"><?php echo language('document/cardmngdata/cardmngdata', 'tCMDLabelPanelHeadCons'); ?></label>
            <a class="xCNMenuplus" role="button" data-toggle="collapse"  href="#odvCmdMngFromTypeConsInfo" aria-expanded="true">
                <i class="fa fa-plus xCNPlus"></i>
            </a>
        </div>
        <div id="odvCmdMngFromTypeConsInfo" class="xCNMenuPanelData panel-collapse collapse in" role="tabpanel">
            <div class="panel-body">
                <!--INPUT : สาขา-->
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 no-padding">
                    <?php 
                    $tUserBchName = $this->session->userdata('tSesUsrBchNameDefault');
                    $tUserBchCode = $this->session->userdata('tSesUsrBchCodeDefault');
                    ?>
                    <script>
                        var tUsrLevel = '<?=$this->session->userdata('tSesUsrLevel')?>';
                        if( tUsrLevel != "HQ" ){
                            var tBchCount = '<?=$this->session->userdata("nSesUsrBchCount");?>';
                            if(tBchCount < 2){
                                $('#obtBrowseBCH_cardShiftMng').attr('disabled',true);
                            }
                        }
                    </script>
                    <div class="form-group">
                        <label class="xCNLabelFrm"><?= language('document/topupvending/topupvending', 'tBCH'); ?></label>
                        <div class="input-group">
                            <input name="oetBCHName_cardShiftMng" id="oetBCHName_cardShiftMng" class="form-control" value="<?=$tUserBchName?>" type="text" readonly="">
                            <input name="oetBCHCode_cardShiftMng" id="oetBCHCode_cardShiftMng" value="<?=$tUserBchCode?>" class="form-control xCNHide" type="text">
                            <span class="input-group-btn">
                                <button class="btn xCNBtnBrowseAddOn" id="obtBrowseBCH_cardShiftMng" type="button">
                                    <img src="<?= base_url('application/modules/common/assets/images/icons/find-24.png'); ?>">
                                </button>
                            </span>
                        </div>
                    </div>
                </div>
                <div id="odvCmdMngFromTypeCons">
                    <div class="form-group">
                        <label class="xCNLabelFrm"><?php echo language('document/cardmngdata/cardmngdata', 'tCMDFromType') ?></label>
                        <select class="selectpicker form-control xCNSelectBox" id="ocmCMDType" name="ocmCMDType" onchange="JSxCardMngFrmChkCons()">
                            <option value='1'><?php echo language('document/cardmngdata/cardmngdata', 'tCMDTypeImport') ?></option>
                            <option value='2'><?php echo language('document/cardmngdata/cardmngdata', 'tCMDTypeExport') ?></option>
                        </select>
                    </div>
                </div>
                <div id="odvCmdMngFromTypeConsAppe"></div>
            </div>
        </div>
    </div>
</div>

<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8" style="padding-right:0">
    <div class="panel panel-headline">
        <div style="padding-top:20px !important;" id="odvSearchForExcel">
            <div class="col-xs-12 col-sm-8 col-md-6 col-lg-6">
                <div class="form-group">
                    <label class="xCNLabelFrm"><?php echo language('document/cardmngdata/cardmngdata', 'tCMDSearchDetail') ?></label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="oetSearchImportHelper" name="oetSearchImportHelper" value="" onkeypress="Javascript:if(event.keyCode==13) JSvClickCallTableTemp()">
                        <span class="input-group-btn">
                            <button id="obtSearchImportHelper" class="btn xCNBtnSearch" type="button" onclick="JSvClickCallTableTemp()">
                                <img  src="<?php echo base_url('/application/modules/common/assets/images/icons/search-24.png'); ?>">
                            </button>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div id="odvPanelCmdMngDataDetail" class="panel-body odvPanelCmdMngDataDetail">

        </div>
    </div>
</div>

<!--Modal Approve-->
<div class="modal fade xCNModalApprove" id="odvCardMngPopupApv">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="xCNHeardModal modal-title" style="display:inline-block"><?php echo language('document/card/cardtopup', 'tCardMngApproveTheDocument'); ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p><?php echo language('document/card/newcard', 'tCardShiftApproveStatus'); ?></p>
                <ul>
                    <li><?php echo language('document/card/newcard', 'tCardShiftApproveStatus1'); ?></li>
                    <li><?php echo language('document/card/newcard', 'tCardShiftApproveStatus2'); ?></li>
                    <li><?php echo language('document/card/newcard', 'tCardShiftApproveStatus3'); ?></li>
                    <li><?php echo language('document/card/newcard', 'tCardShiftApproveStatus4'); ?></li>
                </ul>
                <p><?php echo language('document/card/newcard', 'tCardShiftApproveStatus5'); ?></p>
                <p><strong><?php echo language('document/card/newcard', 'tCardShiftApproveStatus6'); ?></strong></p>
            </div>
            <div class="modal-footer">
                <button id="obtCardMngPopupApvConfirm" onclick="JSoImportProcess()" type="button" class="btn xCNBTNPrimery">
                    <?php echo language('common/main/main', 'tModalConfirm'); ?>
                </button>
                <button type="button" class="btn xCNBTNDefult" data-dismiss="modal">
                    <?php echo language('common/main/main', 'tModalCancel'); ?>
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="odvCardMngModalImportFileConfirm">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header xCNModalHead">
                <label class="xCNTextModalHeard"><?php echo language('document/card/cardreturn', 'tCardShiftReturnBringDataIntoTheTable') ?></label>
            </div>
            <div class="modal-body">
                <?php echo language('document/card/cardreturn', 'tCardShiftReturnImportFileConfirm'); ?>
            </div>
            <div class="modal-footer">
                <!-- แก้ -->
                <button id="osmCardMngBtnImportFileConfirm" onClick="" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" type="button">
                    <?php echo language('common/main/main', 'tModalConfirm') ?>
                </button>
                <!-- แก้ -->
                <button class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"  data-dismiss="modal">
                    <?php echo language('common/main/main', 'tModalCancel') ?>
                </button>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo base_url('application/modules/common/assets/js/jquery.mask.js')?>"></script>
<script src="<?php echo base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>

<script type="text/javascript">
    var nStaImportProcess   = 0;
    var nStaExportProcess   = 0;

    var nLangEdits      = '<?php echo $this->session->userdata("tLangEdit")?>';
    var oLangMngData    =  {
        tCMDValExpNoCondition: '<?php echo language('document/cardmngdata/cardmngdata','tCMDValExpNoCondition')?>',
        tCMDValExpNoDataInTable: '<?php echo language('document/cardmngdata/cardmngdata','tCMDValExpNoDataInTable')?>',
        tCMDValImpNoBrowsFile: '<?php echo language('document/cardmngdata/cardmngdata','tCMDValImpNoBrowsFile')?>',
        tCMDStatusChkFileDataImport: '<?php echo language('document/cardmngdata/cardmngdata','tCMDStatusChkFileDataImport')?>',
        tCMDStatusChkProcessGone: '<?php echo language('document/cardmngdata/cardmngdata','tCMDStatusChkProcessGone')?>',
        tCMDErrorReason: '<?php echo language('document/card/main','tMainChooseReason')?>'
    };
    $(document).ready(function(){
        JSxCardMngFrmChkCons();
        JSxImportChangeLoadMask();
    });

    //Option Browse Condition Export File
    var oOptCrdTypeForm = {
        Title : ['payment/cardtype/cardtype','tCTYTitle'],
        Table:{Master:'TFNMCardType',PK:'FTCtyCode'},
        Join :{
            Table:	['TFNMCardType_L'],
            On:['TFNMCardType_L.FTCtyCode = TFNMCardType.FTCtyCode AND TFNMCardType_L.FNLngID = '+nLangEdits]
        },
        GrideView:{
            ColumnPathLang: 'payment/cardtype/cardtype',
            ColumnKeyLang: ['tCTYCode','tCTYName'],
            DataColumns: ['TFNMCardType.FTCtyCode', 'TFNMCardType_L.FTCtyName'],
            Perpage: 10,
            OrderBy: ['TFNMCardType.FTCtyCode'],
            SourceOrder: "ASC"
        },
        CallBack: {
            ReturnType: 'S',
            Value: ["oetCMDFromCardTypeCode", "TFNMCardType.FTCtyCode"],
            Text: ["oetCMDFromCardTypeName", "TFNMCardType_L.FTCtyName"]
        },
        RouteAddNew: 'cardtype',
        BrowseLev: nStaCmdBrowseType
    };
    var oOptCrdTypeTo = {
        Title : ['payment/cardtype/cardtype', 'tCTYTitle'],
        Table:{Master:'TFNMCardType',PK:'FTCtyCode'},
        Join: {
            Table: ['TFNMCardType_L'],
            On: ['TFNMCardType_L.FTCtyCode = TFNMCardType.FTCtyCode AND TFNMCardType_L.FNLngID = '+nLangEdits]
        },
        GrideView: {
            ColumnPathLang: 'payment/cardtype/cardtype',
            ColumnKeyLang: ['tCTYCode','tCTYName'],
            DataColumns: ['TFNMCardType.FTCtyCode','TFNMCardType_L.FTCtyName'],
            Perpage: 10,
            OrderBy: ['TFNMCardType.FTCtyCode'],
            SourceOrder: "ASC"
        },
        CallBack:{
            ReturnType: 'S',
            Value: ["oetCMDToCardTypeCode","TFNMCardType.FTCtyCode"],
            Text: ["oetCMDToCardTypeName","TFNMCardType_L.FTCtyName"]
        },
        RouteAddNew : 'cardtype',
        BrowseLev : nStaCmdBrowseType
    };

    var oOptCrdCodeFrom = {
        Title : ['payment/card/card','tCRDTitle'],
        Table:{Master:'TFNMCard',PK:'FTCrdCode'},
        Join :{
            Table:	['TFNMCard_L'],
            On:['TFNMCard_L.FTCrdCode = TFNMCard.FTCrdCode AND TFNMCard_L.FNLngID = '+nLangEdits]
        },
        GrideView: {
            ColumnPathLang: 'payment/card/card',
            ColumnKeyLang: ['tCRDTBCode', 'tCRDTBName'],
            DataColumns: ['TFNMCard.FTCrdCode', 'TFNMCard_L.FTCrdName'],
            Perpage: 10,
            OrderBy: ['TFNMCard.FTCrdCode'],
            SourceOrder: "ASC"
        },
        CallBack: {
            ReturnType: 'S',
            Value: ["oetCMDFromCardCode", "TFNMCard.FTCrdCode"],
            Text: ["oetCMDFromCardName", "TFNMCard.FTCrdCode"]
        },
        RouteAddNew : 'card',
        BrowseLev : nStaCmdBrowseType
    };
    var oOptCrdCodeTo = {
        Title: ['payment/card/card','tCRDTitle'],
        Table: {Master:'TFNMCard',PK:'FTCrdCode'},
        Join: {
            Table: ['TFNMCard_L'],
            On: ['TFNMCard_L.FTCrdCode = TFNMCard.FTCrdCode AND TFNMCard_L.FNLngID = '+nLangEdits]
        },
        GrideView: {
            ColumnPathLang: 'payment/card/card',
            ColumnKeyLang: ['tCRDTBCode', 'tCRDTBName'],
            DataColumns: ['TFNMCard.FTCrdCode', 'TFNMCard_L.FTCrdName'],
            Perpage: 10,
            OrderBy: ['TFNMCard.FTCrdCode'],
            SourceOrder: "ASC"
        },
        CallBack: {
            ReturnType: 'S',
            Value: ["oetCMDToCardCode", "TFNMCard.FTCrdCode"],
            Text: ["oetCMDToCardName", "TFNMCard.FTCrdCode"]
        },
        RouteAddNew: 'card',
        BrowseLev: nStaCmdBrowseType
    };

    var oOptCrdNameFrom = {
        Title : ['payment/card/card','tCRDTitle'],
        Table:{Master:'TFNMCard',PK:'FTCrdCode'},
        Join: {
            Table: ['TFNMCard_L'],
            On: ['TFNMCard_L.FTCrdCode = TFNMCard.FTCrdCode AND TFNMCard_L.FNLngID = '+nLangEdits]
        },
        GrideView: {
            ColumnPathLang: 'payment/card/card',
            ColumnKeyLang: ['tCRDTBCode', 'tCRDTBName'],
            DataColumns: ['TFNMCard.FTCrdCode', 'TFNMCard_L.FTCrdName'],
            Perpage: 10,
            OrderBy: ['TFNMCard.FTCrdCode'],
            SourceOrder: "ASC"
        },
        CallBack: {
            ReturnType: 'S',
            Value: ["oetCMDFromNameCardCode", "TFNMCard.FTCrdCode"],
            Text: ["oetCMDFromNameCardName", "TFNMCard.FTCrdName"]
        },
        RouteAddNew: 'card',
        BrowseLev: nStaCmdBrowseType
    };
    var oOptCrdNameTo = {
        Title: ['payment/card/card','tCRDTitle'],
        Table: {Master:'TFNMCard', PK:'FTCrdCode'},
        Join: {
            Table: ['TFNMCard_L'],
            On: ['TFNMCard_L.FTCrdCode = TFNMCard.FTCrdCode AND TFNMCard_L.FNLngID = '+nLangEdits]
        },
        GrideView: {
            ColumnPathLang: 'payment/card/card',
            ColumnKeyLang: ['tCRDTBCode','tCRDTBName'],
            DataColumns: ['TFNMCard.FTCrdCode','TFNMCard_L.FTCrdName'],
            Perpage: 10,
            OrderBy: ['TFNMCard.FTCrdCode'],
            SourceOrder: "ASC"
        },
        CallBack:{
            ReturnType: 'S',
            Value: ["oetCMDToNameCardCode", "TFNMCard.FTCrdCode"],
            Text: ["oetCMDToNameCardName", "TFNMCard.FTCrdName"]
        },
        RouteAddNew: 'card',
        BrowseLev: nStaCmdBrowseType
    };

    var oOptCrdHolderIDFrom = {
        Title: ['payment/card/card','tCRDTitle'],
        Table: {Master:'TFNMCard',PK:'FTCrdCode'},
        Join: {
            Table: ['TFNMCard_L'],
            On: ['TFNMCard_L.FTCrdCode = TFNMCard.FTCrdCode AND TFNMCard_L.FNLngID = '+nLangEdits]
        },
        GrideView: {
            ColumnPathLang: 'payment/card/card',
            ColumnKeyLang: ['tCRDTBCode', 'tCRDTBHolderID', 'tCRDTBName'],
            DataColumns: ['TFNMCard.FTCrdCode', 'TFNMCard.FTCrdHolderID', 'TFNMCard_L.FTCrdName'],
            DisabledColumns: [0],
            Perpage: 10,
            OrderBy: ['TFNMCard.FTCrdHolderID'],
            SourceOrder: "ASC"
        },
        CallBack: {
            ReturnType: 'S',
            Value: ["oetCMDFromCardHolderIDCode", "TFNMCard.FTCrdHolderID"],
            Text: ["oetCMDFromCardHolderIDName", "TFNMCard.FTCrdHolderID"]
        },
        RouteAddNew: 'card',
        BrowseLev: nStaCmdBrowseType
    };
    var oOptCrdHolderIDTo = {
        Title: ['payment/card/card', 'tCRDTitle'],
        Table: {Master:'TFNMCard', PK:'FTCrdCode'},
        Join: {
            Table: ['TFNMCard_L'],
            On: ['TFNMCard_L.FTCrdCode = TFNMCard.FTCrdCode AND TFNMCard_L.FNLngID = '+nLangEdits]
        },
        GrideView:{
            ColumnPathLang: 'payment/card/card',
            ColumnKeyLang: ['tCRDTBCode', 'tCRDTBHolderID', 'tCRDTBName'],
            DataColumns: ['TFNMCard.FTCrdCode', 'TFNMCard.FTCrdHolderID', 'TFNMCard_L.FTCrdName'],
            DisabledColumns: [0],
            Perpage: 10,
            OrderBy: ['TFNMCard.FTCrdHolderID'],
            SourceOrder: "ASC"
        },
        CallBack:{
            ReturnType: 'S',
            Value: ["oetCMDToCardHolderIDCode","TFNMCard.FTCrdHolderID"],
            Text: ["oetCMDToCardHolderIDName","TFNMCard.FTCrdHolderID"]
        },
        RouteAddNew: 'card',
        BrowseLev: nStaCmdBrowseType
    };

    /**
     * Function: Check Card Management Data Type (Import - Export)
     * Parameters : Document Ready
     * Creator : 24/10/2018 wasin
     * Return : Show Group Condition
     * Return Type : -
     */
    function JSxCardMngFrmChkCons(){
        var nCardMngDataType = $('#ocmCMDType').val();
        if(nCardMngDataType == '1'){
            
            // นำเข้าข้อมูล
            $("#odvCmdMngFromTypeConsAppe").empty()
            .append($('<div>') // SELECT BOX
            .attr('class','form-group')
                .append($('<label>')
                .attr('class','xCNLabelFrm')
                .text('<?php echo language('document/cardmngdata/cardmngdata','tCMDDataEntry')?>')
                )
                .append($('<select>')
                .attr('class','selectpicker form-control xCNSelectBox')
                .attr('id','ocmCmdDataEntry')
                .attr('name','ocmCmdDataEntry')
                    .append($('<option>')
                    .attr('value','1')
                    .text('<?php echo language('document/cardmngdata/cardmngdata','tCMDDataEntryNewCard')?>')
                    )
                    .append($('<option>')
                    .attr('value','2')
                    .text('<?php echo language('document/cardmngdata/cardmngdata','tCMDDataEntryTopUp')?>')
                    )
                    .append($('<option>')
                    .attr('value','3')
                    .text('<?php echo language('document/cardmngdata/cardmngdata','tCMDDataEntryTransCrd')?>')
                    )
                    .append($('<option>')
                    .attr('value','4')
                    .text('<?php echo language('document/cardmngdata/cardmngdata','tCMDDataEntryClearCrd')?>')
                    )
                    .change(function(){
                        $('#oetCmdImportShowName').val('');
                        $('#oflCmdImportFile').val('');
                        JSxImportChangeLoadMask();
                        JSvImpSelectDataInTable();
                    })
                )
            )

            .append($('<div>') // SHOW QTY
            .attr('class','form-group row')
                .append($('<div>')
                .attr('class','col-xs-6 col-sm-6 col-md-6 col-lg-6')
                    .append($('<label>')
                    .attr('class','xCNLabelFrm')
                    .text('<?php echo language('document/cardmngdata/cardmngdata','tCMDQtyCardSuccess')?>')
                    )
                    .append($('<input>')
                    .attr('type','text')
                    .attr('id','oetQtyCardSuccess')
                    .attr('class','form-control xWPointerEventNone text-right')
                    .attr('readonly', true)
                    )
                    .append($('<span>')
                    .css('position','absolute')
                    .css('right','-17px')
                    .css('bottom','2px')
                    .text('<?php echo language('document/cardmngdata/cardmngdata','tCMDCardSuccessUnit')?>')
                    )
                )
            )

            .append($('<div>') // BTN UPLOAD
            .attr('class','form-group')
                .append($('<label>')
                .attr('class','xCNLabelFrm')
                .text('<?php echo language('document/cardmngdata/cardmngdata','tCMDFileUplode');?>')
                )
                .append($('<div>')
                .attr('class','input-group')
                    .append($('<input>')
                    .attr('type','text')
                    .attr('class','form-control xWPointerEventNone')
                    .attr('id','oetCmdImportShowName')
                    .attr('placeholder', '<?php echo language('document/cardmngdata/cardmngdata','tCMDBtnBrowseFile');?>')
                    .attr('name','oetCmdImportShowName')
                    .attr('readonly',true)
                    )
                    .append($('<span>')
                    .attr('class','input-group-btn')
                        .append($('<input>')
                        .attr('type','file')
                        .attr('class','xCNHide')
                        .attr('id','oflCmdImportFile')
                        .attr('onchange', 'JSxCardMngSetImportFile(this, event)')
                        .attr('accept','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet')
                        )
                        .append($('<button>')
                        .attr('type','button')
                        .attr('class','btn btn-primary')
                        .text('+ <?php echo language('document/cardmngdata/cardmngdata','tCMDBtnBrowseFile');?>')
                            .click(function(){
                                $(this).parent().find('#oflCmdImportFile').click();
                            })
                        )
                    )
                )
            )

            .append($('<div>') // MSQ ERROR
            .attr('class','form-group')
                .append($('<div>')
                .attr('id','odvCMDMessageImport')
                .attr('class','col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right')
                )
            )

            .append($('<div>') // RADIO PROCESS
            .attr('id','odvStaConsProcess')
            .attr('class','form-group')
                .append($('<label>')
                .attr('class','fancy-radio xCNRadioMain')
                    .append($('<input>')
                    .attr('type','radio')
                    .attr('class','xWCmdConsImport')
                    .attr('name','ocbCmdConsImport')
                    .attr('value','2')
                    .attr('checked',true)
                    )
                    .append($('<span>')
                        .append($('<i>'))
                        .append('<?php echo language('document/cardmngdata/cardmngdata','tCMDImportCons2');?>')
                    )
                )
                .append($('<label>')
                .attr('class','fancy-radio xCNRadioMain')
                    .append($('<input>')
                    .attr('type','radio')
                    .attr('class','xWCmdConsImport')
                    .attr('name','ocbCmdConsImport')
                    .attr('value','1')
                    )
                    .append($('<span>')
                        .append($('<i>'))
                        .append('<?php echo language('document/cardmngdata/cardmngdata','tCMDImportCons1');?>')
                    )
                )
            )

            .append($('<div>') // REASON CHANGE CARD
            .attr('id','odvReasonChangeCard')
            )

            .append($('<div>') // MSQ ERROR REASON
            .attr('class','form-group')
                .append($('<div>')
                .attr('id','odvCMDMessageReason')
                .attr('class','col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right')
                )
            )

            .append($('<div>') // BTN
            .attr('class','form-group')
                .append($('<div>') // ดาวน์โหลด
                .attr('class','col-xs-6 col-sm-6 col-md-6 col-lg-6 text-left')
                .css('padding-left','0')
                    .append($('<a>')
                    .attr('id','oahCmdLoadMask')
                    .attr('class','btn xCNBTNDefult xCNBTNDefult1Btn')
                    .attr('target','_blank')
                    .text('<?php echo language('document/cardmngdata/cardmngdata','tCMDBtnExcelMask')?>')
                    )
                )
                .append($('<div>') // นำข้อมูลเข้าตาราง
                .attr('class','col-xs-6 col-sm-6 col-md-6 col-lg-6')
                .css('padding-right','0')
                .css('text-align','right')
                    .append($('<button>')
                    .attr('type','button')
                    .attr('class','btn xCNBTNPrimery xCNBTNPrimery1Btn')
                    .text('<?php echo language('document/cardmngdata/cardmngdata','tCMDBtnImportTbl');?>')
                        .click(function(){
                            nStaImportProcess = 0;
                            JSoChkConditionImport();
                        })
                    )
                )
            ).hide().fadeIn('slow');

            $('#obtCmdDataProcess').attr('onclick','JSoImportProcessData(false)')
            JSvImpSelectDataInTable();
        }else{
            
            // ส่งออกข้อมูล
            $("#odvCmdMngFromTypeConsAppe").empty()
            .append($('<div>')
            .attr('class','form-group')
                .append($('<label>')
                .attr('class','xCNLabelFrm')
                .text('<?php echo language('document/cardmngdata/cardmngdata','tCMDDataEntry')?>')
                )
                .append($('<select>')
                .attr('class','selectpicker form-control xCNSelectBox')
                .attr('id','ocmCmdDataEntry')
                .attr('name','ocmCmdDataEntry')
                    .append($('<option>')
                    .attr('value','1')
                    .text('<?php echo language('document/cardmngdata/cardmngdata','tCMDDataEntryCrdDetail')?>')
                    )
                )
            )
            .append($('<div>')
            .attr('class','form-group')
                .append($('<label>')
                .attr('class','xCNLabelFrm')
                .text('<?php echo language('document/cardmngdata/cardmngdata','tCMDCardType')?>')
                )
                .append($('<div>')
                .attr('class','row')
                    .append($('<div>')
                    .attr('class','col-xs-12 col-sm-6 col-md-6 col-lg-6')
                        .append($('<div>')
                        .attr('class','input-group')
                            .append($('<input>')
                            .attr('type','text')
                            .attr('class','form-control xCNHide')
                            .attr('id','oetCMDFromCardTypeCode')
                            )
                            .append($('<input>')
                            .attr('type','text')
                            .attr('class','form-control xWPointerEventNone')
                            .attr('id','oetCMDFromCardTypeName')
                            .attr('placeholder','<?php echo language('document/cardmngdata/cardmngdata','tCMDForm');?>')
                            )
                            .append($('<span>')
                            .attr('class','input-group-btn')
                                .append($('<button>')
                                .attr('type','button')
                                .attr('class','btn xCNBtnBrowseAddOn')
                                    .append($('<img>')
                                    .attr('src','<?php echo base_url('/application/modules/common/assets/images/icons/find-24.png'); ?>')
                                    )
                                    .click(function(){
                                        JCNxBrowseData('oOptCrdTypeForm');
                                    })
                                )
                            )
                        )
                    )
                    .append($('<div>')
                    .attr('class','col-xs-12 col-sm-6 col-md-6 col-lg-6')
                        .append($('<div>')
                        .attr('class','input-group')
                            .append($('<input>')
                            .attr('type','text')
                            .attr('class','form-control xCNHide')
                            .attr('id','oetCMDToCardTypeCode')
                            )
                            .append($('<input>')
                            .attr('type','text')
                            .attr('class','form-control xWPointerEventNone')
                            .attr('id','oetCMDToCardTypeName')
                            .attr('placeholder','<?php echo language('document/cardmngdata/cardmngdata','tCMDTo');?>')
                            )
                            .append($('<span>')
                            .attr('class','input-group-btn')
                                .append($('<button>')
                                .attr('type','button')
                                .attr('class','btn xCNBtnBrowseAddOn')
                                    .append($('<img>')
                                    .attr('src','<?php echo base_url('/application/modules/common/assets/images/icons/find-24.png'); ?>')
                                    )
                                    .click(function(){
                                        JCNxBrowseData('oOptCrdTypeTo');
                                    })
                                )
                            )
                        )
                    )
                )
            )
            .append($('<div>')
            .attr('class','form-group')
                .append($('<label>')
                .attr('class','xCNLabelFrm')
                .text('<?php echo language('document/cardmngdata/cardmngdata','tCMDCardCode')?>')
                )
                .append($('<div>')
                .attr('class','row')
                    .append($('<div>')
                    .attr('class','col-xs-12 col-sm-6 col-md-6 col-lg-6')
                        .append($('<div>')
                        .attr('class','input-group')
                            .append($('<input>')
                            .attr('type','text')
                            .attr('class','form-control xCNHide')
                            .attr('id','oetCMDFromCardCode')
                            )
                            .append($('<input>')
                            .attr('type','text')
                            .attr('class','form-control xWPointerEventNone')
                            .attr('id','oetCMDFromCardName')
                            .attr('placeholder','<?php echo language('document/cardmngdata/cardmngdata','tCMDForm');?>')
                            )
                            .append($('<span>')
                            .attr('class','input-group-btn')
                                .append($('<button>')
                                .attr('type','button')
                                .attr('class','btn xCNBtnBrowseAddOn')
                                    .append($('<img>')
                                    .attr('src','<?php echo base_url('/application/modules/common/assets/images/icons/find-24.png'); ?>')
                                    )
                                    .click(function(){
                                        JCNxBrowseData('oOptCrdCodeFrom');
                                    })
                                )
                            )
                        )
                    )
                    .append($('<div>')
                    .attr('class','col-xs-12 col-sm-6 col-md-6 col-lg-6')
                        .append($('<div>')
                        .attr('class','input-group')
                            .append($('<input>')
                            .attr('type','text')
                            .attr('class','form-control xCNHide')
                            .attr('id','oetCMDToCardCode')
                            )
                            .append($('<input>')
                            .attr('type','text')
                            .attr('class','form-control xWPointerEventNone')
                            .attr('id','oetCMDToCardName')
                            .attr('placeholder','<?php echo language('document/cardmngdata/cardmngdata','tCMDTo');?>')
                            )
                            .append($('<span>')
                            .attr('class','input-group-btn')
                                .append($('<button>')
                                .attr('type','button')
                                .attr('class','btn xCNBtnBrowseAddOn')
                                    .append($('<img>')
                                    .attr('src','<?php echo base_url('/application/modules/common/assets/images/icons/find-24.png'); ?>')
                                    )
                                    .click(function(){
                                        JCNxBrowseData('oOptCrdCodeTo');
                                    })
                                )
                            )
                        )
                    )
                )
            )
            .append($('<div>')
            .attr('class','form-group')
                .append($('<label>')
                .attr('class','xCNLabelFrm')
                .text('<?php echo language('document/cardmngdata/cardmngdata','tCMDCardName')?>')
                )
                .append($('<div>')
                .attr('class','row')
                    .append($('<div>')
                    .attr('class','col-xs-12 col-sm-6 col-md-6 col-lg-6')
                        .append($('<div>')
                        .attr('class','input-group')
                            .append($('<input>')
                            .attr('type','text')
                            .attr('class','form-control xCNHide')
                            .attr('id','oetCMDFromNameCardCode')
                            )
                            .append($('<input>')
                            .attr('type','text')
                            .attr('class','form-control xWPointerEventNone')
                            .attr('id','oetCMDFromNameCardName')
                            .attr('placeholder','<?php echo language('document/cardmngdata/cardmngdata','tCMDForm');?>')
                            )
                            .append($('<span>')
                            .attr('class','input-group-btn')
                                .append($('<button>')
                                .attr('type','button')
                                .attr('class','btn xCNBtnBrowseAddOn')
                                    .append($('<img>')
                                    .attr('src','<?php echo base_url('/application/modules/common/assets/images/icons/find-24.png'); ?>')
                                    )
                                    .click(function(){
                                        JCNxBrowseData('oOptCrdNameFrom');
                                    })
                                )
                            )
                        )
                    )
                    .append($('<div>')
                    .attr('class','col-xs-12 col-sm-6 col-md-6 col-lg-6')
                        .append($('<div>')
                        .attr('class','input-group')
                            .append($('<input>')
                            .attr('type','text')
                            .attr('class','form-control xCNHide')
                            .attr('id','oetCMDToNameCardCode')
                            )
                            .append($('<input>')
                            .attr('type','text')
                            .attr('class','form-control xWPointerEventNone')
                            .attr('id','oetCMDToNameCardName')
                            .attr('placeholder','<?php echo language('document/cardmngdata/cardmngdata','tCMDTo');?>')
                            )
                            .append($('<span>')
                            .attr('class','input-group-btn')
                                .append($('<button>')
                                .attr('type','button')
                                .attr('class','btn xCNBtnBrowseAddOn')
                                    .append($('<img>')
                                    .attr('src','<?php echo base_url('/application/modules/common/assets/images/icons/find-24.png'); ?>')
                                    )
                                    .click(function(){
                                        JCNxBrowseData('oOptCrdNameTo');
                                    })
                                )
                            )
                        )
                    )
                )
            )
            .append($('<div>')
            .attr('class','form-group')
                .append($('<label>')
                .attr('class','xCNLabelFrm')
                .text('<?php echo language('document/cardmngdata/cardmngdata','tCMDCardHolderID')?>')
                )
                .append($('<div>')
                .attr('class','row')
                    .append($('<div>')
                    .attr('class','col-xs-12 col-sm-6 col-md-6 col-lg-6')
                        .append($('<div>')
                        .attr('class','input-group')
                            .append($('<input>')
                            .attr('type','text')
                            .attr('class','form-control xCNHide')
                            .attr('id','oetCMDFromCardHolderIDCode')
                            )
                            .append($('<input>')
                            .attr('type','text')
                            .attr('class','form-control xWPointerEventNone')
                            .attr('id','oetCMDFromCardHolderIDName')
                            .attr('placeholder','<?php echo language('document/cardmngdata/cardmngdata','tCMDForm');?>')
                            )
                            .append($('<span>')
                            .attr('class','input-group-btn')
                                .append($('<button>')
                                .attr('type','button')
                                .attr('class','btn xCNBtnBrowseAddOn')
                                    .append($('<img>')
                                    .attr('src','<?php echo base_url('/application/modules/common/assets/images/icons/find-24.png'); ?>')
                                    )
                                    .click(function(){
                                        JCNxBrowseData('oOptCrdHolderIDFrom');
                                    })
                                )
                            )
                        )
                    )
                    .append($('<div>')
                    .attr('class','col-xs-12 col-sm-6 col-md-6 col-lg-6')
                        .append($('<div>')
                        .attr('class','input-group')
                            .append($('<input>')
                            .attr('type','text')
                            .attr('class','form-control xCNHide')
                            .attr('id','oetCMDToCardHolderIDCode')
                            )
                            .append($('<input>')
                            .attr('type','text')
                            .attr('class','form-control xWPointerEventNone')
                            .attr('id','oetCMDToCardHolderIDName')
                            .attr('placeholder','<?php echo language('document/cardmngdata/cardmngdata','tCMDTo');?>')
                            )
                            .append($('<span>')
                            .attr('class','input-group-btn')
                                .append($('<button>')
                                .attr('type','button')
                                .attr('class','btn xCNBtnBrowseAddOn')
                                    .append($('<img>')
                                    .attr('src','<?php echo base_url('/application/modules/common/assets/images/icons/find-24.png'); ?>')
                                    )
                                    .click(function(){
                                        JCNxBrowseData('oOptCrdHolderIDTo');
                                    })
                                )
                            )
                        )
                    )
                )
            )
            .append($('<div>')
            .attr('class','form-group')
            .css('margin','0')
                .append($('<div>')
                .attr('class','')
                .css('padding-top','10px')
                    .append($('<div>')
                    .attr('id','odvCMDMessageExport')
                    .attr('class','col-xs-6 col-sm-6 col-md-6 col-lg-6 text-left')
                    )
                    .append($('<div>')
                    .attr('class','col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right')
                    .css('padding-right','0')
                        .append($('<button>')
                        .attr('type','button')
                        .attr('class','btn xCNBTNPrimery')
                        .text('<?php echo language('document/cardmngdata/cardmngdata','tCMDBtnImportTbl');?>')
                            .click(function(){
                                nStaExportProcess = 0;
                                var aReturn = JSoChkConditionExport();
                                if(aReturn['nStaCheck'] == 1){
                                    JSvExpSelectDataInTable(1,aReturn['aDataCondition']);
                                }
                            })
                        )
                    )
                )
            ).hide().fadeIn('slow');
            // Call Data Export
            $('#obtCmdDataProcess').attr('onclick','JSoExportProcessData()')
            JSvExpSelectDataInTable();
        }
        $('.xCNSelectBox').selectpicker();
    }

    /**
    * Function: Set Link Download Mask Excel
    * Parameters : Document Ready
    * Creator : 24/10/2018 wasin
    * Return : Show Group Condition
    * /Return Type : -
    */
    function JSxImportChangeLoadMask(){
       
        var nStaDataList = $('#ocmCmdDataEntry').val();
        var tHTML = '';
        switch(nStaDataList) {
            case '1':
                var tNameTable = 'TFNTCrdImpTmp';
                $('#odvStaConsProcess').show();
                $('#odvReasonChangeCard').hide();
                $('#odvCMDMessageReason').hide();
                $('#oahCmdLoadMask').attr('href','<?php echo base_url('application/modules/document/assets/carddocfile/Temp_NewCard.xlsx'); ?>');
                break;
            case '2':
                var tNameTable = 'TFNTCrdTopUpTmp';
                $('#odvStaConsProcess').hide();
                $('#odvReasonChangeCard').hide();
                $('#odvCMDMessageReason').hide();
                $('#oahCmdLoadMask').attr('href','<?php echo base_url('application/modules/document/assets/carddocfile/Temp_TopUP.xlsx'); ?>');
                break;
            case '3':
                var tNameTable = 'TFNTCrdVoidTmp';
                $('#odvStaConsProcess').hide();
                $('#odvCMDMessageReason').show();
                $('#odvReasonChangeCard').html('');
                
                    tHTML += '<div class="form-group">';
                    tHTML += '<label class="xCNLabelFrm">เหตุผลการเปลี่ยนบัตร</label>';
                    tHTML += '<div class="input-group">';
                    tHTML += '<input type="text" class="xCNHide" id="oetCardReasonCode" name="oetCardReasonCode">';
                    tHTML += '<input class="form-control xWPointerEventNone" type="text" id="oetCardReasonName" name="oetCardReasonName" readonly="">';
                    tHTML += '<span class="xWConditionSearchPdt input-group-btn">';
                    tHTML += '<button id="oimCardReasonFile" type="button" class="xWConditionSearchPdt btn xCNBtnBrowseAddOn">';
                    tHTML += '<img class="xCNIconFind">';
                    tHTML += '</button>';
                    tHTML += '</span>';
                    tHTML += '</div>';
                    tHTML += '</div>';

                $('#odvReasonChangeCard').append(tHTML);
                $('#odvReasonChangeCard').show();

                $('#oahCmdLoadMask').attr('href','<?php echo base_url('application/modules/document/assets/carddocfile/Temp_CardTrf.xlsx'); ?>');
                break;
            case '4':
                var tNameTable = 'TFNTCrdImpTmp';
                $('#odvStaConsProcess').hide();
                $('#odvReasonChangeCard').hide();
                $('#odvCMDMessageReason').hide();
                $('#oahCmdLoadMask').attr('href','<?php echo base_url('application/modules/document/assets/carddocfile/Temp_ClearCard.xlsx'); ?>');
                break;
        }

        // Clear Temp By Table 
        JSnCallDeleteHelperByTable(tNameTable);

        $('#oimCardReasonFile').click(function(){ 
            JCNxBrowseData('oCardShiftChangeBrowseReasonFile');
        });
    }

    // Reason File 
    var oCardShiftChangeBrowseReasonFile = {
        Title: ['other/reason/reason','tRSNTitle'],
        Table: {Master:'TCNMRsn', PK:'FTRsnCode'},
        Join: {
            Table: ['TCNMRsn_L'],
            On: ['TCNMRsn_L.FTRsnCode = TCNMRsn.FTRsnCode AND TCNMRsn_L.FNLngID = '+nLangEdits]
        },
        Where: {
            Condition: ["/*AND TCNMRsn.FTRsgCode = '007' */"]
        },
        GrideView:{
            ColumnPathLang: 'other/reason/reason',
            ColumnKeyLang: ['tRSNTBCode', 'tRSNTBName'],
            // ColumnsSize: ['15%', '85%'],
            WidthModal: 50,
            DataColumns: ['TCNMRsn.FTRsnCode', 'TCNMRsn_L.FTRsnName'],
            DisabledColumns:[],
            DataColumnsFormat: ['', ''],
            Perpage: 5,
            OrderBy: ['TCNMRsn_L.FTRsnName'],
            SourceOrder: "ASC"
        },
        CallBack: {
            ReturnType: 'S',
            Value: ["oetCardReasonCode", "TCNMRsn.FTRsnCode"],
            Text: ["oetCardReasonName", "TCNMRsn_L.FTRsnName"]
        },
        RouteAddNew: 'reason',
        BrowseLev: nStaCmdBrowseType,
        NextFunc:{
            FuncName:   'JSxCallChangeReasonFile',
            ArgReturn:   ['FTRsnCode']
        }
    };  

    function JSxCallChangeReasonFile(){
        $('#odvCMDMessageReason').hide();
    }

    /**
    * Functionality : Set after change file
    * Parameters : poElement is Itself element, poEvent is Itself event
    * Creator : 30/04/2019 piya
    * Last Modified : -
    * Return : -
    * Return Type : -
    */
    function JSxCardMngSetImportFile(poElement, poEvent){
        try{
            var oFile = $(poElement)[0].files[0];
            $("#oetCmdImportShowName").val(oFile.name);
        }catch(err){
            console.log("JSxCardMngSetImportFile Error: ", err);
        }
    }

    $("#obtBrowseBCH_cardShiftMng").click(function() {
        var nLangEdits = <?php echo $this->session->userdata("tLangEdit"); ?>;
        var tUsrLevel = "<?= $this->session->userdata('tSesUsrLevel') ?>";
        var tBchMulti = "<?= $this->session->userdata("tSesUsrBchCodeMulti"); ?>";
        var tSQLWhere = "";
        if (tUsrLevel != "HQ") {
            tSQLWhere = " AND TCNMBranch.FTBchCode IN (" + tBchMulti + ") ";
        }

        window.oBrowse_Branch = {
            Title: ['authen/user/user', 'tBrowseBCHTitle'],
            Table: {
                Master: 'TCNMBranch',
                PK: 'FTBchCode'
            },
            Join: {
                Table: ['TCNMBranch_L'],
                On: ['TCNMBranch_L.FTBchCode = TCNMBranch.FTBchCode AND TCNMBranch_L.FNLngID = ' + nLangEdits]
            },
            Where: {
                Condition: [tSQLWhere]
            },
            GrideView: {
                ColumnPathLang: 'authen/user/user',
                ColumnKeyLang: ['tBrowseBCHCode', 'tBrowseBCHName'],
                ColumnsSize: ['10%', '75%'],
                DataColumns: ['TCNMBranch.FTBchCode', 'TCNMBranch_L.FTBchName'],
                DataColumnsFormat: ['', ''],
                WidthModal: 50,
                Perpage: 10,
                OrderBy: ['TCNMBranch.FTBchCode'],
                SourceOrder: "ASC"
            },
            CallBack: {
                ReturnType: 'S',
                Value: ["oetBCHCode_cardShiftMng", "TCNMBranch.FTBchCode"],
                Text: ["oetBCHName_cardShiftMng", "TCNMBranch_L.FTBchName"]
            },
            NextFunc: {
                FuncName: 'JSxSetConfigBCH_cardShiftTopUp',
                ArgReturn: ['FTBchCode']
            },
            RouteAddNew: 'branch',
            BrowseLev: 1
        };
        JCNxBrowseData('oBrowse_Branch');
    });
</script>






