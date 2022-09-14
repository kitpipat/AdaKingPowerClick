<?php
    if(isset($nStaAddOrEdit) && $nStaAddOrEdit == 1){
        $tRoute     = "departmentEventEdit"; 
        $tDptCode   = $aDptData['raItems']['rtDptCode'];
        $tDptName   = $aDptData['raItems']['rtDptName'];
        $tDptRmk    = $aDptData['raItems']['rtDptRmk'];

        $tDptAgnCode   = $aDptData['raItems']['rtAgnCode'];
        $tDptAgnName   = $aDptData['raItems']['rtAgnName'];
    }else{
        $tRoute     = "departmentEventAdd";
        $tDptCode   = "";
        $tDptName   = "";
        $tDptRmk    = "";

        // $tDptAgnCode   = $aResult['tSesAgnCode'];
        // $tDptAgnName   = $aResult['tSesAgnName'];

        $tDptAgnCode   = $tSesAgnCode;
        $tDptAgnName   = $tSesAgnName;
    }
?>

<form class="validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" id="ofmAddEditDepartment">
    <button style="display:none" type="submit" id="obtSubmitDpt" onclick="JSoAddEditDpt('<?php echo  $tRoute?>')"></button>
    <div class="panel-body" style="padding-top:20px !important;">
        <div class="row">
            <div class="col-xs-12 col-md-5 col-lg-5">
                <label class="xCNLabelFrm"><span style="color:red">*</span><?php echo language('authen/department/department','tDPTCode');?></label>
                <div class="form-group" id="odvDepartmentAutoGenCode">
                    <div class="validate-input">
                        <label class="fancy-checkbox">
                            <input type="checkbox" id="ocbDepartmentAutoGenCode" name="ocbDepartmentAutoGenCode" checked="true" value="1">
                            <span> <?php echo language('common/main/main', 'tGenerateAuto'); ?></span>
                        </label>
                    </div>
                </div>
                <div class="form-group" id="odvDepartmentCodeForm">
                    <input type="hidden" id="ohdCheckDuplicateDptCode" name="ohdCheckDuplicateDptCode" value="1"> 
                    <div class="validate-input">
                        <input 
                            type="text" 
                            class="form-control xCNGenarateCodeTextInputValidate" 
                            maxlength="5" 
                            id="oetDptCode" 
                            name="oetDptCode"
                            placeholder="<?php echo language('authen/department/department','tDPTCode');?>"
                            data-is-created="<?php echo $tDptCode; ?>"
                            value="<?php echo $tDptCode; ?>" 
                            autocomplete="off"
                            data-validate-required = "<?php echo language('authen/department/department','tDPTValidCode');?>"
                            data-validate-dublicateCode = "<?php echo language('authen/department/department','tDPTValidCodeDup')?>"
                        >
                    </div>
                </div>
                <?php
                if ($tRoute ==  "pdtgroupEventAdd") {
                    $tDptAgnCode   = $tSesAgnCode;
                    $tDptAgnName   = $tSesAgnName;
                    $tDisabled     = '';
                    $tNameElmIDAgn = 'oimBrowseAgn';
                } else {
                    $tDptAgnCode    = $tDptAgnCode;
                    $tDptAgnName    = $tDptAgnName;
                    $tDisabled      = '';
                    $tNameElmIDAgn  = 'oimBrowseAgn';
                }
                ?>


                <!-- เพิ่ม AD Browser -->
                <div class="form-group  <?php if (!FCNbGetIsAgnEnabled()) : echo 'xCNHide';
                                        endif; ?>">
                    <label class="xCNLabelFrm"><?php echo language('product/pdtgroup/pdtgroup', 'tPGPAgency') ?></label>
                    <div class="input-group"><input type="text" class="form-control xCNHide" id="oetDptAgnCode" name="oetDptAgnCode" maxlength="5" value="<?= @$tDptAgnCode; ?>">
                        <input type="text" class="form-control xWPointerEventNone" id="oetDptAgnName" name="oetDptAgnName" maxlength="100" placeholder="<?php echo language('interface/connectionsetting/connectionsetting', 'tTBAgency') ?>" value="<?= @$tDptAgnName; ?>" readonly>
                        <span class="input-group-btn">
                            <button id="<?= @$tNameElmIDAgn; ?>" type="button" class="btn xCNBtnBrowseAddOn <?= @$tDisabled ?>">
                                <img src="<?php echo  base_url() . '/application/modules/common/assets/images/icons/find-24.png' ?>">
                            </button>
                        </span>
                    </div>
                </div>



                <div class="form-group">
                    <label class="xCNLabelFrm"><span style =color:red>*</span><?php echo language('authen/department/department','tDPTName')?></label> <!-- เปลี่ยนชื่อ Class -->
                    <input type="text" class="form-control" maxlength="50" id="oetDptName" name="oetDptName" value="<?php echo $tDptName?>" 
                    placeholder="<?php echo language('authen/department/department','tDPTName')?>"
                    autocomplete="off"
                    data-validate-required = "<?php echo language('authen/department/department','tDPTValidName')?>"> <!-- เปลี่ยนชื่อ Class เพิ่ม DataValidate -->
                </div>
                <div class="form-group">
                    <div class="validate-input">
                        <label class="xCNLabelFrm"><?php echo language('authen/department/department','tDPTRemark')?></label>
                        <textarea class="form-control" maxlength="100" rows="4" id="otaDptRemark" name="otaDptRemark"><?php echo $tDptRmk; ?></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<script src="<?php echo base_url(); ?>application/modules/common/assets/js/jquery.mask.js"></script>
<script src="<?php echo base_url(); ?>application/modules/common/assets/src/jFormValidate.js"></script>
<?php include "script/jDepartmentAdd.php"; ?>

<script type="text/javascript">

//BrowseAgn 
    $('#oimBrowseAgn').click(function(e) {
        e.preventDefault();
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
            JSxCheckPinMenuClose();
            window.oPdtBrowseAgencyOption = oBrowseAgn({
                'tReturnInputCode': 'oetDptAgnCode',
                'tReturnInputName': 'oetDptAgnName',
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