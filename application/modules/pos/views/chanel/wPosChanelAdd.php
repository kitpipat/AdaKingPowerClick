<?php
if ($aResult['rtCode'] == "1") {
    $tMenuTabDisable    = "";
    $tMenuTabToggle     = "tab";

    $tChnCode = $aResult['raHDItems']['rtChnCode'];
    $tChnName = $aResult['raHDItems']['rtChnName'];
    $tChnRefCode = $aResult['raHDItems']['rtChnRefCode'];
    $tChnBchCode = $aResult['raHDItems']['rtChnBchCode'];
    $tChnBchName = $aResult['raHDItems']['rtChnBchName'];
    $tChnAgnCode = $aResult['raHDItems']['rtChnAgnCode'];
    $tChnAgnName = $aResult['raHDItems']['rtChnAgnName'];
    $tChnAppCode = $aResult['raHDItems']['rtChnAppCode'];
    $tChnAppName = $aResult['raHDItems']['rtChnAppName'];
    $tChnPplCode = $aResult['raHDItems']['rtChnPplCode'];
    $tChnPplName = $aResult['raHDItems']['rtChnPplName'];
    $tChnWahCode = $aResult['raHDItems']['rtChnWahCode'];
    $tChnWahName = $aResult['raHDItems']['rtChnWahName'];
    $tChnStaUse = $aResult['raHDItems']['rtChnStaUse'];
    $tChnWahDO = $aResult['raHDItems']['rtChnWahDO'];
    $tChnWahDOName = $aResult['raHDItems']['rtChnWahDOName'];
    $tChnStaUseDO = $aResult['raHDItems']['rtChnStaUseDO'];
    $tChnStaAlwSNPL = $aResult['raHDItems']['rtChnStaAlwSNPL'];
    $tChnSeq = $aResult['raHDItems']['rtChnSeq'];
    $tRoute = "chanelEventEdit";
} else {
    $tMenuTabDisable    = " disabled xCNCloseTabNav";
    $tMenuTabToggle     = "false";

    $tChnCode = "";
    $tChnName = "";
    $tChnRefCode = "";
    $tRoute = "chanelEventAdd";
    $tChnBchCode = "";
    $tChnBchName = "";
    $tChnAgnCode = "";
    $tChnAgnName = "";
    $tChnAppCode = "";
    $tChnAppName = "";
    $tChnPplCode = "";
    $tChnPplName = "";
    $tChnWahCode = "";
    $tChnWahName = "";
    $tChnStaUse = 1;
    $tChnWahDO = "";
    $tChnWahDOName = "";
    $tChnStaUseDO = "";
    $tChnStaAlwSNPL = "";

    $tChnSeq = "";


    $tSesUsrLev = $this->session->userdata("tSesUsrLevel");
    $tSesUsrBchMuti =   $this->session->userdata("tSesUsrBchCodeMulti");
    $tSesUsrBchCount = $this->session->userdata("nSesUsrBchCount");
    $tSesAgnCode =  $this->session->userdata('tSesUsrAgnCode');
    $tSesAgnName =  $this->session->userdata('tSesUsrAgnName');

    $tSesUsrBchName =   $this->session->userdata("tSesUsrBchNameDefault");
    $tSesUsrBchCode = $this->session->userdata("tSesUsrBchCodeDefault");



    if ($tSesUsrLev != 'HQ') {
        $tChnAgnCode =  $tSesAgnCode;
        $tChnAgnName = $tSesAgnName;
    }

    if ( $this->session->userdata("tSesUsrLoginLevel") != "HQ" && $this->session->userdata("tSesUsrLoginLevel") != "AGN" ) {
        $tChnBchCode = $tSesUsrBchCode;
        $tChnBchName = $tSesUsrBchName;
    }
}



$tHeadReceiptPlaceholder = "Head of Receipt";
$tEndReceiptPlaceholder = "End of Receipt";

?>
<style>
    .xWChnMoveIcon {
        cursor: move !important;
        border-radius: 0px;
        box-shadow: none;
        padding: 0px 10px;
    }

    .dragged {
        position: absolute;
        opacity: 0.5;
        z-index: 2000;
    }

    .xWChnDyForm {
        border-radius: 0px;
        border: 0px;
    }

    .xWChnBtn {
        box-shadow: none;
    }

    .xWChnItemSelect {
        margin-bottom: 5px;
    }

    .alert-validate::before,
    .alert-validate::after {
        z-index: 100;
    }

    .input-group-addon:not(:first-child):not(:last-child),
    .input-group-btn:not(:first-child):not(:last-child),
    .input-group .form-control:not(:first-child):not(:last-child) {
        border-radius: 4px;
    }
</style>
<div class="panel panel-headline">
    <div class="panel-body">

        <div id="odvPdtRowNavMenu" class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="custom-tabs-line tabs-line-bottom left-aligned">
                    <ul class="nav" role="tablist">
                        <li id="oliChnInfo1" class="xWMenu active xCNStaHideShow">
                            <a role="tab" data-toggle="tab" data-target="#odvChnContentInfo1" aria-expanded="true"><?php echo language('pos/poschannel/poschannel', 'ข้อมูลหลัก') ?></a>
                        </li>
                        <li id="oliChnInfo2" class="xWMenu xWSubTab xCNStaHideShow <?php echo $tMenuTabDisable; ?>">
                            <a role="tab" data-toggle="<?php echo $tMenuTabToggle; ?>" data-target="#odvChnContentInfo2" aria-expanded="false"><?php echo language('pos/poschannel/poschannel', 'กำหนดคลัง') ?></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div id="odvPdtRowContentMenu" class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="tab-content">

                    <!-- Tab Content Info 1 -->
                    <div id="odvChnContentInfo1" class="tab-pane fade active in">
                        <form class="validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" autocorrect="off" autocapitalize="off" autocomplete="off" id="ofmAddChanel">
                            <button style="display:none" type="submit" id="obtSubmitChanel" onclick="JSnAddEditChanel('<?= $tRoute ?>')"></button>
                            <div class="panel-body" style="padding-top:20px !important;">
                                <div class="row">
                                    <div class="col-xs-12 col-md-5 col-lg-5">

                                        <input type="hidden" class="input100 xCNHide" id="oetChnSeq" name="oetChnSeq"  value="<?php echo $tChnSeq; ?>">
                                        <input type="hidden" class="input100 xCNHide" id="oetChnUsrLoginLevel" name="oetChnUsrLoginLevel"  value="<?php echo $this->session->userdata("tSesUsrLoginLevel"); ?>">
                                        


                                        <label class="xCNLabelFrm"><span style="color:red">*</span><?php echo language('pos/poschannel/poschannel', 'tCHNLabelChannelCode'); ?></label>
                                        <div class="form-group" id="odvSlipmessageAutoGenCode">
                                            <div class="validate-input">
                                                <label class="fancy-checkbox">
                                                    <input type="checkbox" id="ocbSlipmessageAutoGenCode" name="ocbSlipmessageAutoGenCode" checked="true" value="1">
                                                    <span><?php echo language('common/main/main', 'tGenerateAuto'); ?></span>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="form-group" id="odvSlipmessageCodeForm">
                                            <input type="hidden" id="ohdCheckDuplicateChnCode" name="ohdCheckDuplicateChnCode" value="1">
                                            <div class="validate-input">
                                                <input type="text" class="form-control xCNInputWithoutSpcNotThai" maxlength="5" id="oetChnCode" name="oetChnCode" data-is-created="<?php echo $tChnCode; ?>" placeholder="<?php echo language('pos/poschannel/poschannel', 'tCHNLabelChannelCode'); ?>" autocomplete="off" value="<?php echo $tChnCode; ?>" data-validate-required="<?php echo language('pos/poschannel/poschannel', 'tCHNValidCode') ?>" data-validate-dublicateCode="<?php echo language('pos/poschannel/poschannel', 'tCHNValidCodeDup'); ?>">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="validate-input">
                                                <label class="xCNLabelFrm"><span style="color:red">*</span><?php echo language('pos/poschannel/poschannel', 'tCHNLabelChannelName'); ?></label>

                                                <input type="text" class="form-control" maxlength="70" id="oetChnName" name="oetChnName" autocomplete="off" placeholder="<?php echo language('pos/poschannel/poschannel', 'tCHNLabelChannelName'); ?>" value="<?php echo $tChnName; ?>" data-validate-required="<?php echo language('pos/poschannel/poschannel', 'tCHNValidName'); ?>">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="xCNLabelFrm"><span style="color:red">*</span><?php echo language('pos/poschannel/poschannel', 'tCHNLabelSystem'); ?></label>
                                            <div class="input-group">
                                                <input type="text" class="form-control xCNHide" id="oetChnAppCode" name="oetChnAppCode" value="<?php echo $tChnAppCode; ?>">
                                                <input type="text" class="form-control xWPointerEventNone" id="oetChnAppName" name="oetChnAppName" placeholder="" value="<?php echo $tChnAppName; ?>" data-validate-required="<?php echo language('pos/poschannel/poschannel', 'tCHNInputValidApp') ?>" readonly>
                                                <span class="input-group-btn">
                                                    <button id="oimChnBrowseApp" type="button" class="btn xCNBtnBrowseAddOn"><img class="xCNIconFind"></button>
                                                </span>
                                            </div>
                                        </div>

                                        <div class="form-group <?php if (!FCNbGetIsAgnEnabled()) : echo 'xCNHide'; endif; ?>">
                                            <label class="xCNLabelFrm"><?php echo language('pos/poschannel/poschannel', 'tCHNLabelAgency'); ?></label>
                                            <div class="input-group">
                                                <input type="text" id="oetChnAgnCode" class="form-control xCNHide" name="oetChnAgnCode" value="<?php echo $tChnAgnCode; ?>">
                                                <input type="text" id="oetChnAgnName" class="form-control" name="oetChnAgnName" value="<?php echo $tChnAgnName; ?>" data-validate-required="กรุณากรอกตัวแทนขาย" readonly>
                                                <span class="input-group-btn">
                                                    <?php
                                                    // Last Update : 21/05/2020 nale  ถ้าเข้ามาเป็น User ระดับ HQ ให้เลือก Agency ได้
                                                    if (!empty($this->session->userdata('tSesUsrAgnCode')) || $this->session->userdata('nSesUsrBchCount') > 0) {
                                                        $tDisableBrowseAgency = 'disabled';
                                                    } else {
                                                        $tDisableBrowseAgency = '';
                                                    }
                                                    ?>
                                                    <button id="obtBrowseAgency" type="button" class="btn xCNBtnBrowseAddOn" <?php echo @$tDisableBrowseAgency; ?>>
                                                        <img class="xCNIconFind">
                                                    </button>
                                                </span>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="xCNLabelFrm"><?php echo language('pos/poschannel/poschannel', 'tCHNLabelBranch'); ?></label>
                                            <div class="input-group">
                                                <input type="text" class="input100 xCNHide" id="oetWahBchCodeCreated" name="oetWahBchCodeCreated" maxlength="5" value="<?php echo $tChnBchCode; ?>">
                                                <input class="form-control xWPointerEventNone" type="text" id="oetWahBchNameCreated" name="oetWahBchNameCreated" value="<?php echo $tChnBchName; ?>" data-validate-required="<?php echo language('company/warehouse/warehouse', 'tWAHValidbch') ?>" readonly>
                                                <span class="input-group-btn xWConditionSearchPdt">
                                                    <button id="obtWahBrowseBchCreated" type="button" class="btn xCNBtnBrowseAddOn" <?php echo ($this->session->userdata("nSesUsrBchCount") == 1 && $this->session->userdata("tSesUsrLoginLevel") != "HQ" && $this->session->userdata("tSesUsrLoginLevel") != "AGN" ) ? 'disabled' : ''; ?>>
                                                        <img src="<?php echo base_url('application/modules/common/assets/images/icons/find-24.png'); ?>">
                                                    </button>
                                                </span>
                                            </div>
                                        </div>

                                        <!-- <div class="form-group" id="odvWarehouse">
                                            <label class="xCNLabelFrm"><?php echo language('pos/poschannel/poschannel', 'tCHNLabelWahouse'); ?></label>
                                            <div class="input-group">
                                                <input class="form-control xCNHide" id="oetBchWahCode" name="oetBchWahCode" maxlength="5" value="<?php echo $tChnWahCode; ?>">
                                                <input class="form-control xWPointerEventNone" type="text" id="oetBchWahName" name="oetBchWahName" value="<?php echo $tChnWahName; ?>" readonly>
                                                <span class="input-group-btn">
                                                    <button id="obtBchBrowseWah" type="button" class="btn xCNBtnBrowseAddOn">
                                                        <img src="<?php echo  base_url() . 'application/modules/common/assets/images/icons/find-24.png' ?>">
                                                    </button>
                                                </span>
                                            </div>
                                        </div> -->

                                        <!-- แยกคลังขาย / คลังส่ง -->
                                        <!-- <input type="hidden" id="ohdWahType" value=""> -->

                                        <!-- <div class="form-group" id="odvDeliveryWarehouse">
                                            <label class="xCNLabelFrm"><?php echo language('pos/poschannel/poschannel', 'tCHNLabelDeliveryWahouse'); ?></label>
                                            <div class="input-group">
                                                <input class="form-control xCNHide" id="oetDeliveryWahCode" name="oetDeliveryWahCode" maxlength="5" value="<?php echo $tChnWahDO; ?>">
                                                <input class="form-control xWPointerEventNone" type="text" id="oetDeliveryWahName" name="oetDeliveryWahName" value="<?php echo $tChnWahDOName; ?>" readonly>
                                                <span class="input-group-btn">
                                                    <button id="obtDeliveryBrowseWah" type="button" class="btn xCNBtnBrowseAddOn">
                                                        <img src="<?php echo  base_url() . 'application/modules/common/assets/images/icons/find-24.png' ?>">
                                                    </button>
                                                </span>
                                            </div>
                                        </div> -->

                                        <div class='form-group'>
                                            <label class="xCNLabelFrm"><?php echo language('pos/poschannel/poschannel', 'tCHNLabelPriceGroup'); ?></label>
                                            <div class='input-group'>
                                                <input type='text' class='form-control xCNHide xWRddAllInput' id='oetChnPplCode' name='oetChnPplCode' maxlength='5' value="<?php echo $tChnPplCode; ?>">
                                                <input type='text' class='form-control xWPointerEventNone xWCPHAllInput' id='oetChnPplName' name='oetChnPplName' value="<?php echo $tChnPplName; ?>" readonly>
                                                <span class='input-group-btn'>
                                                    <button id='obtChnBrowsePpl' type='button' class='btn xCNBtnBrowseAddOn'><img class='xCNIconFind'></button>
                                                </span>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="validate-input">
                                                <label class="xCNLabelFrm"><?php echo language('pos/poschannel/poschannel', 'tCHNLabelRefCode'); ?></label>
                                                <input type="text" class="form-control" maxlength="20" id="oetChnRefCode" name="oetChnRefCode" autocomplete="off" placeholder="<?php echo language('pos/poschannel/poschannel', 'tCHNLabelRefCode'); ?>" value="<?php echo $tChnRefCode; ?>">
                                            </div>
                                        </div>

                                        <!-- รับ S/N ในใบจัด -->
                                        <div class="form-group"> 
                                            <label class="fancy-checkbox"> 
                                                <?php if (isset($tChnStaAlwSNPL) && $tChnStaAlwSNPL == 1) {
                                                    $tChecked   = 'checked'; 
                                                } else {
                                                    $tChecked   = ''; 
                                                } ?> 
                                                <input type="checkbox" id="ocbChnStaAlwSNPL" name="ocbChnStaAlwSNPL" <?php echo $tChecked; ?>> 
                                                    <span> <?php echo language('company/warehouse/warehouse', 'tPosStaAlwSNPL'); ?></span> 
                                            </label> 
                                        </div>

                                        <div class="form-group">
                                            <label class="fancy-checkbox">
                                                <?php
                                                if (isset($tChnStaUseDO) && $tChnStaUseDO == 1) {
                                                    $tChecked   = 'checked';
                                                } else {
                                                    $tChecked   = '';
                                                }
                                                ?>
                                                <input type="checkbox" id="ocbChnStaUseDO" name="ocbChnStaUseDO" <?php echo $tChecked; ?>>
                                                <span> <?php echo language('pos/poschannel/poschannel', 'tCHNStaUseTransDoc'); ?></span>
                                            </label>
                                        </div>

                                        <div class="form-group">
                                            <label class="fancy-checkbox">
                                                <?php
                                                if (isset($tChnStaUse) && $tChnStaUse == 1) {
                                                    $tChecked   = 'checked';
                                                } else {
                                                    $tChecked   = '';
                                                }
                                                ?>
                                                <input type="checkbox" id="ocbChnStatusUse" name="ocbChnStatusUse" <?php echo $tChecked; ?>>
                                                <span> <?php echo language('common/main/main', 'tStaUse'); ?></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </form>                
                    </div>
                    <!-- Tab Content Info 1 -->

                    <!-- Tab Content Info 2 -->
                    <div id="odvChnContentInfo2" class="tab-pane fade">

                        <div class="row" style="margin-bottom:10px;">
                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                <label class="xCNLabelFrm" style="color: #1866ae !important; cursor:pointer;"><?php echo language('pos/poschannel/poschannel', 'tCHNTitle'); ?> : <?=$tChnName?></label>
                                <label class="xCNLabelFrm xWCSWPageEdit" style="color: #aba9a9 !important;display: none;"> / <?php echo language('common/main/main', 'tEdit') ?> </label>
                                <label class="xCNLabelFrm xWCSWPageAdd" style="color: #aba9a9 !important;display: none;"> / <?php echo language('common/main/main', 'tAdd') ?> </label>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right xWCSWBtnAdd">
                                <button id="obtChnSpcWahAdd" class="xCNBTNPrimeryPlus" type="button">+</button>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right xWCSWPageAddEdit" style="display: none;">
                                <button type="button" onclick="JSvCHNPageSpcWah();" class="btn" style="background-color: #D4D4D4; color: #000000;"><?php echo language('common/main/main', 'tCancel') ?></button>
                                <button type="button" id="obtCSWClickSave" style="background-color: rgb(23, 155, 253); color: white;" class="btn"> <?php echo  language('common/main/main', 'tSave') ?></button>
                            </div>
                        </div>

                        <div id="odvChnSpcWahContentDataTable"></div>

                    </div>
                    <!-- Tab Content Info 2 -->

                </div>
            </div>
        </div>

    </div>
</div>

<script src="<?= base_url('application/modules/common/assets/js/jquery.mask.js') ?>"></script>
<script src="<?= base_url('application/modules/common/assets/src/jFormValidate.js') ?>"></script>
<?php include 'script/jPosChanelAdd.php'; ?>

<script type="text/javascript">


    $('#obtCSWClickSave').off('click').on('click', function(){
        $('#obtCSWSubmit').click();
    });

    $('#obtChnSpcWahAdd').off('click').on('click', function(){
        JSvCHNPageSpcWahAdd();
    });

    $('.xCNStaHideShow').off('click').on('click', function(){
        var tMenuID = $(this).attr('id');
        var tStaDis = $(this).hasClass('disabled');
        if( !tStaDis ){
            switch(tMenuID){
                case 'oliChnInfo1':
                    $('#odvChnBtnSave').show();
                    break;
                case 'oliChnInfo2':
                    $('#odvChnBtnSave').hide();
                    JSvCHNPageSpcWah();
                    break;
            }
        }
    });

    $(function() {
        if (JCNbChanelIsCreatePage()) { // For create page

            // Set head of receipt default
            JSxChanelRowDefualt('head', 1);
            // Set end of receipt default
            JSxChanelRowDefualt('end', 1);

        } else { // for update page

            if (JCNnChanelCountRow('head') <= 0) {
                // Set head of receipt default
                JSxChanelRowDefualt('head', 1);
            }
            if (JCNnChanelCountRow('end') <= 0) {
                // Set end of receipt default
                JSxChanelRowDefualt('end', 1);
            }

        }
        JSaChanelGetSortData('head');
        // Remove sort data
        JSxChanelRemoveSortData('all');

        $('#odvChnSlipHeadContainer').sortable({
            items: '.xWChnItemSelect',
            opacity: 0.7,
            axis: 'y',
            handle: '.xWChnMoveIcon',
            update: function(event, ui) {
                var aToArray = $(this).sortable('toArray');
                var aSerialize = $(this).sortable('serialize', {
                    key: ".sort"
                });
                // JSxChanelSetRowSortData('head', aToArray);
                // JSoChanelSortabled('head', true);
            }
        });

        $('#odvChnSlipEndContainer').sortable({
            items: '.xWChnItemSelect',
            opacity: 0.7,
            axis: 'y',
            handle: '.xWChnMoveIcon',
            update: function(event, ui) {
                var aToArray = $(this).sortable('toArray');
                var aSerialize = $(this).sortable('serialize', {
                    key: ".sort"
                });
                // JSxChanelSetRowSortData('end', aToArray);
                // JSoChanelSortabled('end', true);
            }
        });

        $('.xWTooltipsBT').tooltip({
            'placement': 'bottom'
        });
        $('[data-toggle="tooltip"]').tooltip({
            'placement': 'top'
        });

        $('#oimChnBrowseProvince').click(function() {
            JCNxBrowseData('oPvnOption');
        });

        if (JCNbChanelIsUpdatePage()) {
            $("#obtGenCodeChanel").attr("disabled", true);
        }
    });

    var nLangEdits = '<?php echo $this->session->userdata("tLangEdit") ?>';
    var nStaPdtBrowseType = $('#ohdPdtStaBrowseType').val();

    // Click Browse Agency
    $('#obtBrowseAgency').click(function(e) {
        e.preventDefault();
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
            JSxCheckPinMenuClose();
            window.oPdtBrowseAgencyOption = oPdtBrowseAgency({
                'tReturnInputCode': 'oetChnAgnCode',
                'tReturnInputName': 'oetChnAgnName',
                'tBchCodeWhere': $('#oetPdtBchCode').val(),
            });
            JCNxBrowseData('oPdtBrowseAgencyOption');
        } else {
            JCNxShowMsgSessionExpired();
        }
    });



    //เลือกตัวแทนขาย
    var oPdtBrowseAgency = function(poReturnInput) {
        var tInputReturnCode = poReturnInput.tReturnInputCode;
        var tInputReturnName = poReturnInput.tReturnInputName;
        var tBchCodeWhere = poReturnInput.tBchCodeWhere;

        var tSesLev = '<?php echo $this->session->userdata('tSesUsrLevel'); ?>'
        var tSesAgenCde = '<?php echo $this->session->userdata('tSesUsrAgnCode'); ?>'

        var tWhereAgn = '';
        if (tSesLev != 'HQ') {
            tWhereAgn = " AND TCNMBranch.FTAgnCode = '" + tSesAgenCde + "'";
        } else {
            tWhereAgn = '';
        }

        var oOptionReturn = {
            Title: ['ticket/agency/agency', 'tAggTitle'],
            Table: {
                Master: 'TCNMAgency',
                PK: 'FTAgnCode'
            },
            Join: {
                Table: ['TCNMAgency_L'],
                On: ['TCNMAgency_L.FTAgnCode = TCNMAgency.FTAgnCode AND TCNMAgency_L.FNLngID = ' + nLangEdits]
            },
            Where: {
                Condition: [
                    tWhereAgn
                ]
            },
            GrideView: {
                ColumnPathLang: 'ticket/agency/agency',
                ColumnKeyLang: ['tAggCode', 'tAggName'],
                ColumnsSize: ['15%', '85%'],
                WidthModal: 50,
                DataColumns: ['TCNMAgency.FTAgnCode', 'TCNMAgency_L.FTAgnName'],
                DataColumnsFormat: ['', ''],
                Perpage: 10,
                OrderBy: ['TCNMAgency.FDCreateOn DESC'],
            },
            CallBack: {
                ReturnType: 'S',
                Value: [tInputReturnCode, "TCNMAgency.FTAgnCode"],
                Text: [tInputReturnName, "TCNMAgency_L.FTAgnName"],
            },
            RouteAddNew: 'agency',
            BrowseLev: nStaPdtBrowseType,
            NextFunc: {
                FuncName: 'JSxClearBrowseConditionAgn',
                ArgReturn: ['FTAgnCode']
            }
        }
        return oOptionReturn;
    }

    function JSxClearBrowseConditionAgn(ptData) {
        // aData = JSON.parse(ptData);
        if (ptData != '' || ptData != 'NULL') {

            $('#oetWahBchCodeCreated').val('');
            $('#oetWahBchNameCreated').val('');

            $('#oetBchWahCode').val('');
            $('#oetBchWahName').val('');
        }
    }

    // ระบบ
    $('#oimChnBrowseApp').click(function() {
        JSxCheckPinMenuClose();
        JCNxBrowseData('oBrowsetSysApp');
    });

    // ระบบ
    var oBrowsetSysApp = {
        Title: ['payment/recivespc/recivespc', 'tBrowseAppTitle'],
        Table: {
            Master: 'TSysApp',
            PK: 'FTAppCode'
        },
        Join: {
            Table: ['TSysApp_L'],
            On: ['TSysApp_L.FTAppCode = TSysApp.FTAppCode AND TSysApp_L.FNLngID =' + nLangEdits]
        },
        GrideView: {
            ColumnPathLang: 'payment/recivespc/recivespc',
            ColumnKeyLang: ['tBrowseAppCode', 'tBrowseAppName'],
            ColumnsSize: ['15%', '75%'],
            DataColumns: ['TSysApp.FTAppCode', 'TSysApp_L.FTAppName'],
            DataColumnsFormat: ['', ''],
            WidthModal: 50,
            Perpage: 10,
            OrderBy: ['TSysApp.FTAppCode ASC'],
        },
        CallBack: {
            ReturnType: 'S',
            Value: ["oetChnAppCode", "TSysApp.FTAppCode"],
            Text: ["oetChnAppName", "TSysApp_L.FTAppName"]
        },
        // NextFunc: {
        //     FuncName: 'JSxNextFuncRcvSpc',
        //     ArgReturn: ['FTAppCode']
        // },
    };

    $('#obtChnBrowsePpl').unbind().click(function() {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
            JSxCheckPinMenuClose(); // Hidden Pin Menu
            window.oRptRddCstPriOptionFrom = undefined;
            oRptRddCstPriOptionFrom = oRptCstPriOption({
                'tReturnInputCode': 'oetChnPplCode',
                'tReturnInputName': 'oetChnPplName',

                'aArgReturn': ['FTPplCode', 'FTPplName']
            });
            JCNxBrowseData('oRptRddCstPriOptionFrom');
        } else {
            JCNxShowMsgSessionExpired();
        }
    });

    var oRptCstPriOption = function(poReturnInputCstPri) {
        let aArgReturnCstPri = poReturnInputCstPri.aArgReturn;
        let tInputReturnCodeCstPri = poReturnInputCstPri.tReturnInputCode;
        let tInputReturnNameCstPri = poReturnInputCstPri.tReturnInputName;
        let tWhereCondition = '';

        let tSesUsrAgnCode = '<?=$this->session->userdata("tSesUsrAgnCode");?>';
        if( tSesUsrAgnCode != "" ){
            tWhereCondition = " AND ( TCNMPdtPriList.FTAgnCode = '"+tSesUsrAgnCode+"' OR ISNULL(TCNMPdtPriList.FTAgnCode,'') = '' ) ";
        }

        let oOptionReturnCstPri = {
            Title: ['product/pdtpricelist/pdtpricelist', 'tPPLTitle'],
            Table: {
                Master: 'TCNMPdtPriList',
                PK: 'FTPplCode',
                PKName: 'FTPplName'
            },
            Join: {
                Table: ['TCNMPdtPriList_L'],
                On: ['TCNMPdtPriList_L.FTPplCode = TCNMPdtPriList.FTPplCode AND TCNMPdtPriList_L.FNLngID = ' + nLangEdits]
            },
            Where: {
                Condition: [ tWhereCondition ]
            },
            GrideView: {
                ColumnPathLang: 'product/pdtpricelist/pdtpricelist',
                ColumnKeyLang: ['tPPLTBCode', 'tPPLTBName'],
                ColumnsSize: ['15%', '75%'],
                WidthModal: 50,
                DataColumns: ['TCNMPdtPriList.FTPplCode', 'TCNMPdtPriList_L.FTPplName'],
                DataColumnsFormat: ['', ''],
                Perpage: 10,
                OrderBy: ['TCNMPdtPriList.FDCreateOn DESC'],
            },
            CallBack: {
                ReturnType: 'S',
                Value: [tInputReturnCodeCstPri, "TCNMPdtPriList.FTPplCode"],
                Text: [tInputReturnNameCstPri, "TCNMPdtPriList_L.FTPplName"]
            },

            RouteAddNew: 'pdtpricegroup',
            BrowseLev: 0
        };
        return oOptionReturnCstPri;
    };


    /*===== Begin Browse ===============================================================*/



    // สาขาที่สร้าง
    $("#obtWahBrowseBchCreated").click(function() {
        var tUsrLevel = "<?php echo $this->session->userdata("tSesUsrLevel"); ?>";
        var tBchCodeMulti = "<?php echo $this->session->userdata("tSesUsrBchCodeMulti"); ?>";
        var nCountBch = "<?php echo $this->session->userdata("nSesUsrBchCount"); ?>";
        var tAgnCodeWhere = $('#oetChnAgnCode').val()
        var tWhere = "";
        var tWhereAgn = '';

        // if (nCountBch == 1) {
        //     $('#obtWahBrowseBchCreated').attr('disabled', true);
        // }
        if (tUsrLevel != "HQ") {
            tWhere = " AND TCNMBranch.FTBchCode IN (" + tBchCodeMulti + ") ";

        } else {
            tWhere = "";
        }

        if (tAgnCodeWhere == '' || tAgnCodeWhere == null) {
            tWhereAgn = '';
        } else {
            tWhereAgn = " AND TCNMBranch.FTAgnCode = '" + tAgnCodeWhere + "'";
        }
        // option 
        window.oWahBrowseBchCreated = {
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
                Condition: [
                    tWhere + tWhereAgn
                ]
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
                Value: ["oetWahBchCodeCreated", "TCNMBranch.FTBchCode"],
                Text: ["oetWahBchNameCreated", "TCNMBranch_L.FTBchName"]
            },
            // DebugSQL: true,
            NextFunc: {
                FuncName: 'JSxClearBrowseConditionBch',
                ArgReturn: ['FTBchCode']
            },
            RouteAddNew: 'branch',
            BrowseLev: 1
        };
        JCNxBrowseData('oWahBrowseBchCreated');
    });


    function JSxClearBrowseConditionBch(ptData) {
        // aData = JSON.parse(ptData);
        if (ptData != '' || ptData != 'NULL') {


            $('#oetBchWahCode').val('');
            $('#oetBchWahName').val('');
        }
    }

    $('#obtBchBrowseWah').click(function() {
        JSxCheckPinMenuClose();
        $('#ohdWahType').val("");
        $('#ohdWahType').val("1");
        var tPOSBchCodeParam = $('#oetWahBchCodeCreated').val();
        window.oBrowsePosOption = undefined;
        oBrowsePosOption = oBrowsePosBch({
            'tReturnInputCode': 'oetBchWahCode',
            'tReturnInputName': 'oetBchWahName',
            'tPOSBchCodeParam': tPOSBchCodeParam
        });
        JCNxBrowseData('oBrowsePosOption');
    });

    $('#obtDeliveryBrowseWah').click(function() {
        JSxCheckPinMenuClose();
        $('#ohdWahType').val("");
        $('#ohdWahType').val("2");
        var tPOSBchCodeParam = $('#oetWahBchCodeCreated').val();
        window.oBrowsePosOption = undefined;
        oBrowsePosOption = oBrowsePosBch({
            'tReturnInputCode': 'oetDeliveryWahCode',
            'tReturnInputName': 'oetDeliveryWahName',
            'tPOSBchCodeParam': tPOSBchCodeParam
        });
        JCNxBrowseData('oBrowsePosOption');
    });

    // Add warehouse
    var oBrowsePosBch = function(poDataFnc) {
        var tPOSBchCodeParam = poDataFnc.tPOSBchCodeParam;
        let tInputWahCode = poDataFnc.tReturnInputCode;
        let tInputWahName = poDataFnc.tReturnInputName;
        var tBchCode = $('#oetWahBchCodeCreated').val();
        var nWahType = $('#ohdWahType').val();
        var tWhereSraType = '';
        var tWhereWahType = '';

        if ($("#oetWahBchCodeCreated").val() != "") {
            tWhereSraType += " AND TCNMWaHouse.FTBchCode = '" + tBchCode + "'";
        } else {
            tWhereSraType += "";
        }

        if (nWahType != "") {
            tWhereWahType += " AND TCNMWaHouse.FTWahStaType = '" + nWahType + "'";
        } else {
            tWhereWahType += "";
        }

        var oOptionReturn = {
            Title: ['company/warehouse/warehouse', 'tWAHTitle'],
            Table: {
                Master: 'TCNMWaHouse',
                PK: 'FTWahCode'
            },
            Join: {
                Table: ['TCNMWaHouse_L'],
                On: ['TCNMWaHouse_L.FTWahCode = TCNMWaHouse.FTWahCode AND TCNMWaHouse_L.FTBchCode = TCNMWaHouse.FTBchCode  AND TCNMWaHouse_L.FNLngID = ' + nLangEdits, ]
            },
            Where: {
                Condition: [tWhereSraType,tWhereWahType]
            },
            GrideView: {
                ColumnPathLang: 'company/warehouse/warehouse',
                ColumnKeyLang: ['tWahCode', 'tWahName'],
                ColumnsSize: ['15%', '75%'],
                WidthModal: 50,
                DataColumns: ['TCNMWaHouse.FTWahCode', 'TCNMWaHouse_L.FTWahName'],
                DataColumnsFormat: ['', ''],
                Perpage: 5,
                OrderBy: ['TCNMWaHouse.FTWahCode'],
                SourceOrder: "ASC"
            },

            CallBack: {
                ReturnType: 'S',
                Value: [tInputWahCode, "TCNMWaHouse.FTWahCode"],
                Text: [tInputWahName, "TCNMWaHouse_L.FTWahName"],
            },

            RouteFrom: 'chanel',
            RouteAddNew: 'warehouse',
        }
        return oOptionReturn;
    }
    /*===== End Browse =================================================================*/
</script>

<?php include 'script/wPosChanelScript.php'; ?>