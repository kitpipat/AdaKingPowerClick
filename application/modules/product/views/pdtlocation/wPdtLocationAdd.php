<?php
    if(isset($nStaAddOrEdit) && $nStaAddOrEdit == 1){
        $tRoute     = "pdtlocationEventEdit"; 
        $tPlcCode   = $aLocData['raItems']['rtPlcCode'];
        $tPlcName   = $aLocData['raItems']['rtPlcName'];
        $tPlcRmk    = $aLocData['raItems']['rtPlcRmk'];

        $tPlcAgnCode   = $aLocData['raItems']['rtAgnCode'];
        $tPlcAgnName   = $aLocData['raItems']['rtAgnName'];
    }else{
        $tRoute     = "pdtlocationEventAdd";
        $tPlcCode   = "";
        $tPlcName   = "";
        $tPlcRmk    = "";

        $tPlcAgnCode   = $tSesAgnCode;
        $tPlcAgnName   = $tSesAgnName;
    }
?>

<form class="contact100-form validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" id="ofmAddPdtLoc">
    <button style="display:none" type="submit" id="obtSubmitPdtLoc" onclick="JSoAddEditPdtLoc('<?= $tRoute?>')"></button>
    <input type="hidden" id="ohdPdtLocationRoute" value="<?php echo $tRoute; ?>">
    <div class="panel panel-headline">
        <div class="panel-body" style="padding-top:20px !important;">
            <div class="row">
                <div class="col-xs-12 col-md-5 col-lg-5">
                    <div class="form-group">
                        <input type="hidden" value="0" id="ohdCheckPlcClearValidate" name="ohdCheckPlcClearValidate"> 
                        <label class="xCNLabelFrm"><span style="color:red">*</span><?= language('product/pdtlocation/pdtlocation','tLOCFrmLocCode')?></label>
                        <?php
                        if($tRoute=="pdtlocationEventAdd"){
                        ?>
                        <div class="form-group" id="odvPunAutoGenCode">
                            <div class="validate-input">
                                <label class="fancy-checkbox">
                                    <input type="checkbox" id="ocbPlcAutoGenCode" name="ocbPlcAutoGenCode" checked="true" value="1">
                                    <span> <?php echo language('common/main/main', 'tGenerateAuto'); ?></span>
                                </label>
                            </div>
                        </div>
                        
                        <div class="form-group" id="odvPlcCodeForm">
                            <input 
                                type="text" 
                                class="form-control xCNInputWithoutSpcNotThai xCNInputWithoutSingleQuote" 
                                maxlength="5" 
                                id="oetPlcCode" 
                                name="oetPlcCode"
                                data-is-created="<?php  ?>"
                                placeholder="<?= language('product/pdtlocation/pdtlocation','tLOCFrmLocCode')?>"
                                value="<?php  ?>" 
                                data-validate-required="<?php echo language('product/pdtlocation/pdtlocation','tLOCValidCode')?>"
                                data-validate-dublicateCode="<?php echo language('product/pdtlocation/pdtlocation','tLOCVldCodeDuplicate')?>"
                                readonly
                                onfocus="this.blur()">
                            <input type="hidden" value="2" id="ohdCheckDuplicatePlcCode" name="ohdCheckDuplicatePlcCode"> 
                        </div>
                        <?php
                        }else{
                        ?>
                        <div class="form-group" id="odvPlcCodeForm">
                            <div class="validate-input">
                                <label class="fancy-checkbox">
                                <input 
                                    type="text" 
                                    class="form-control xCNInputWithoutSpcNotThai xCNInputWithoutSingleQuote" 
                                    maxlength="5" 
                                    id="oetPlcCode" 
                                    name="oetPlcCode"
                                    data-is-created="<?php  ?>"
                                    placeholder="<?= language('product/pdtlocation/pdtlocation','tLOCFrmLocCode')?>"
                                    value="<?php echo $tPlcCode; ?>" 
                                    readonly
                                    onfocus="this.blur()">
                                </label>
                            </div>
                        <?php
                        }
                        ?>

                    </div>

                    <?php
                            if ($tRoute ==  "pdtgroupEventAdd") {
                                $tPlcAgnCode   = $tSesAgnCode;
                                $tPlcAgnName   = $tSesAgnName;
                                $tDisabled     = '';
                                $tNameElmIDAgn = 'oimBrowseAgn';
                            } else {
                                $tPlcAgnCode    = $tPlcAgnCode;
                                $tPlcAgnName    = $tPlcAgnName;
                                $tDisabled      = '';
                                $tNameElmIDAgn  = 'oimBrowseAgn';
                            }
                            ?>


                            <!-- เพิ่ม AD Browser -->
                            <div class="form-group  <?php if (!FCNbGetIsAgnEnabled()) : echo 'xCNHide';
                                                    endif; ?>">
                                <label class="xCNLabelFrm"><?php echo language('product/pdtgroup/pdtgroup', 'tPGPAgency') ?></label>
                                <div class="input-group"><input type="text" class="form-control xCNHide" id="oetPlcAgnCode" name="oetPlcAgnCode" maxlength="5" value="<?= @$tPlcAgnCode; ?>">
                                    <input type="text" class="form-control xWPointerEventNone" id="oetPlcAgnName" name="oetPlcAgnName" maxlength="100" placeholder="<?php echo language('interface/connectionsetting/connectionsetting', 'tTBAgency') ?>" value="<?= @$tPlcAgnName; ?>" readonly>
                                    <span class="input-group-btn">
                                        <button id="<?= @$tNameElmIDAgn; ?>" type="button" class="btn xCNBtnBrowseAddOn <?= @$tDisabled ?>">
                                            <img src="<?php echo  base_url() . '/application/modules/common/assets/images/icons/find-24.png' ?>">
                                        </button>
                                    </span>
                                </div>
                            </div>

                    <div class="form-group">
                        <label class="xCNLabelFrm"><span style="color:red">*</span><?= language('product/pdtlocation/pdtlocation','tLOCFrmLocName')?></label>
                        <input type="text" class="form-control" maxlength="50" id="oetPlcName" name="oetPlcName" value="<?=$tPlcName?>" 
                        data-validate-required="<?= language('product/pdtlocation/pdtlocation','tLOCValidName')?>"
                        placeholder="<?= language('product/pdtlocation/pdtlocation','tLOCFrmLocName')?>"
                        >
                    </div>
                    <div class="form-group">
                        <label class="xCNLabelFrm"><?= language('product/pdtlocation/pdtlocation','tLOCFrmLocRmk')?></label>
                        <textarea class="form-control" maxlength="100" rows="4" id="otaPlcRmk" name="otaPlcRmk"><?=$tPlcRmk?></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<script src="<?= base_url('application/modules/common/assets/js/jquery.mask.js')?>"></script>
<script src="<?= base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>
<script>
    $('#obtGenCodePdtLoc').click(function(){
        JStGeneratePdtLocCode();
    });

        //BrowseAgn 
        $('#oimBrowseAgn').click(function(e) {
        e.preventDefault();
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
            JSxCheckPinMenuClose();
            window.oPdtBrowseAgencyOption = oBrowseAgn({
                'tReturnInputCode': 'oetPlcAgnCode',
                'tReturnInputName': 'oetPlcAgnName',
            });
            JCNxBrowseData('oPdtBrowseAgencyOption');
        } else {
            JCNxShowMsgSessionExpired();
        }
    });

    var nLangEdits = <?php echo $this->session->userdata("tLangEdit") ?>;

    //Option Agn
    var oBrowseAgn = function(poReturnInput) {
        var tInputReturnCode = poReturnInput.tReturnInputCode;
        var tInputReturnName = poReturnInput.tReturnInputName;

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
            BrowseLev: 1,
        }
        return oOptionReturn;
    }

    var tStaUsrLevel = '<?php echo $this->session->userdata("tSesUsrLevel"); ?>';


    if (tStaUsrLevel == 'BCH' || tStaUsrLevel == 'SHP') {
        $('#oimBrowseAgn').attr("disabled", true);

    }
</script>