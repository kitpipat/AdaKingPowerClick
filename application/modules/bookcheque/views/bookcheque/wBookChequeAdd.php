<?php
if ($aResult['rtCode'] == "1") {
    $tChqCode           = $aResult['raItems']['rtChqCode'];
    $tChqName           = $aResult['raItems']['rtChqName'];
    $tChqRmk            = $aResult['raItems']['rtChqRmk'];
    $tChqtStaUse        = $aResult['raItems']['rtChqStaAct'];
    $tChqMin            = $aResult['raItems']['rtChqMin'];
    $tChqMax            = $aResult['raItems']['rtChqMax'];
    $tBchCode           = $aResult['raItems']['rtBchCode'];
    $tBnkCode           = $aResult['raItems']['rtBnkCode'];
    $tBnkName           = $aResult['raItems']['rtBnkName'];
    $tBchName           = $aResult['raItems']['rtBchName'];
    $tChqStaPrcDoc      = $aResult['raItems']['rtChqStaPrcDoc'];
    $tBbkName           = $aResult['raItems']['rtBbkName'];
    $tBbkCode           = $aResult['raItems']['rtBbkCode'];
    $tRoute             = "BookChequeUpdateevent";

    //Event Control
    if (isset($aAlwEventBookCheque)) {
        if ($aAlwEventBookCheque['tAutStaFull'] == 1 || $aAlwEventBookCheque['tAutStaEdit'] == 1) {
            $nAutStaEdit = 1;
        } else {
            $nAutStaEdit = 0;
        }
    } else {
        $nAutStaEdit = 0;
    }
} else {
    $tChqCode           = "";
    $tChqName           = "";
    $tChqRmk            = "";
    $tChqMin            = "";
    $tChqMax            = "";
    $tBbkCode           = "";
    $tBchCode           = $this->session->userdata("tSesUsrBchCodeDefault");
    $tBchName           = $this->session->userdata("tSesUsrBchNameDefault");
    $tBnkCode           = "";
    $tBnkName           = "";
    $tChqStaPrcDoc      = "";
    $tChqtStaUse        = "";
    $tBbkName           = "";
    $tBbkCode           = "";
    $tRoute             = "BookChequeAddevent";
    $nAutStaEdit        = 0; //Event Control
}

if ($tChqtStaUse == "") {
    $tChqtStaUse == 1;
}
?>

<form class="validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" id="ofmAddBookCheque">
    <input id="ohdOldBchCode" name="ohdOldBchCode" type="hidden" value="<?php echo $tBchCode; ?>"><?php // Branch code เดิมที่กำลังจะแก้ไข ไว้อ้างอิงในคำสั่ง sql. 08/04/2020 surawat 
                                                                                                    ?>
    <input id="ohdOldChqCode" name="ohdOldChqCode" type="hidden" value="<?php echo $tChqCode; ?>"><?php // Cheque code เดิมที่กำลังจะแก้ไข ไว้อ้างอิงในคำสั่ง sql. 08/04/2020 surawat 
                                                                                                    ?>
    <button style="display:none" type="submit" id="obtBarSubmitBcq" onclick="JSnBCQAddEdit('<?php echo $tRoute; ?>')"></button>
    <div class="panel-body" style="padding-top:20px !important;">
        <div class="row">
            <div class="col-xs-6 col-sm-6">


                <div class="col-xs-12 col-md-8 col-lg-8">

                    <div class="form-group">
                        <div class="validate-input">
                            <label class="xCNLabelFrm"><span class="text-danger">*</span><?php echo language('bookcheque/bookcheque/bookcheque', 'tBcqtCode'); ?> </label>
                            <input type="text" class="form-control" maxlength="5" id="oetChqCode" name="oetChqCode" placeholder="<?php echo language('bookcheque/bookcheque/bookcheque', 'tBcqtCode'); ?>" autocomplete="off" value="<?php echo $tChqCode ?>" data-validate-required="<?php echo language('bookcheque/bookcheque/bookcheque', 'tBcqValidateCode'); ?>" <?php echo !empty($tChqCode) ? 'readonly' : ''; ?>>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="validate-input">
                            <label class="xCNLabelFrm"><span class="text-danger">*</span><?php echo language('bookcheque/bookcheque/bookcheque', 'tBcqtNo'); ?></label>
                            <input type="text" class="form-control" maxlength="20" id="oetChqStaPrcDoc" name="oetChqStaPrcDoc" placeholder="<?php echo language('bookcheque/bookcheque/bookcheque', 'tBcqtNo'); ?>" autocomplete="off" value="<?php echo $tChqStaPrcDoc ?>" data-validate-required="<?php echo language('bookcheque/bookcheque/bookcheque', 'tBcqvalidateNo'); ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="validate-input">
                            <label class="xCNLabelFrm"><span class="text-danger">*</span><?php echo language('bookcheque/bookcheque/bookcheque', 'tBcqName'); ?></label>
                            <input type="text" class="form-control" maxlength="100" id="oetChqName" name="oetChqName" placeholder="<?php echo language('bookcheque/bookcheque/bookcheque', 'tBcqName'); ?>" autocomplete="off" value="<?php echo $tChqName ?>" data-validate-required="<?php echo language('bookcheque/bookcheque/bookcheque', 'tBcqvalidateName'); ?>">
                        </div>
                    </div>

                    <?php
                        if ( $this->session->userdata("tSesUsrLevel") != "HQ" ){
                            if( $this->session->userdata("nSesUsrBchCount") <= 1 ){ //ค้นหาขั้นสูง
                                $tDisabled = 'disabled';
                            }else{
                                $tDisabled = '';
                            }
                        }else{
                            $tDisabled = '';
                        }
                    ?>
                    
                    <div class="form-group">
                        <label class="xCNLabelFrm"><span class="text-danger">*</span><?php echo language('bookcheque/bookcheque/bookcheque', 'tBcqBch'); ?></label>
                        <div class="input-group">
                            <input type="text" class="form-control xCNHide" id="oetBchCode" name="oetBchCode" value="<?php echo $tBchCode ?>" data-validate="<?php echo language('bookcheque/bookcheque/bookcheque', 'tBcqvalidateBch'); ?>" <?php echo !empty($tBchCode) ? 'readonly' : ''; ?>>
                            <input type="text" class="form-control xCNInputWithoutSpcNotThai" id="oetBchName" name="oetBchName" value="<?php echo $tBchName ?>" data-validate="<?php echo language('bookcheque/bookcheque/bookcheque', 'tBcqvalidateBch'); ?>" readonly="" data-validate-required="<?php echo language('bookcheque/bookcheque/bookcheque', 'tBcqvalidateBch'); ?>" <?php echo !empty($tBchCode) ? 'readonly' : ''; ?>>
                            <span class="input-group-btn">
                                <button id="obtBrowseBranch" type="button" class="btn xCNBtnBrowseAddOn" <?=$tDisabled?>>
                                    <img src="<?php echo base_url() . '/application/modules/common/assets/images/icons/find-24.png' ?>">
                                </button>
                            </span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="xCNLabelFrm"><span class="text-danger">*</span><?php echo language('bookcheque/bookcheque/bookcheque', 'tBcqtBBName'); ?></label>
                        <div class="input-group">
                            <input type="text" class="form-control xCNHide" id="oetBbkCode" name="oetBbkCode" value="<?php echo $tBbkCode ?>" data-validate="<?php echo language('bookcheque/bookcheque/bookcheque', 'tBcqtBBName'); ?>">
                            <input type="text" class="form-control xCNInputWithoutSpcNotThai" id="oetBbkName" name="oetBbkName" value="<?php echo $tBbkName ?>" data-validate="กรุณาเลือกสมุดบัญชี" readonly="" data-validate-required="<?php echo language('bookcheque/bookcheque/bookcheque', 'tBcqvalidateBBk'); ?>">
                            <span class="input-group-btn">
                                <button id="obtBrowseBnk" type="button" class="btn xCNBtnBrowseAddOn">
                                    <img src="<?php echo base_url() . '/application/modules/common/assets/images/icons/find-24.png' ?>">
                                </button>
                            </span>
                        </div>
                    </div>



                    <div class="form-group">
                        <div class="validate-input">
                            <label class="xCNLabelFrm"><span class="text-danger">*</span><?php echo language('bookcheque/bookcheque/bookcheque', 'tBcqDocnumMin'); ?></label>
                            <input type="number" style="text-align: right;" class="form-control" maxlength="200" id="onbChqMin" name="onbChqMin" placeholder="<?php echo language('bookcheque/bookcheque/bookcheque', 'tBcqDocnumMin'); ?>" autocomplete="off" value="<?php echo $tChqMin ?>" data-validate-required="<?php echo language('bookcheque/bookcheque/bookcheque', 'tBcqvalidateMin'); ?>">

                        </div>
                    </div>
                    <div class="form-group">
                        <div class="validate-input">
                            <label class="xCNLabelFrm"><span class="text-danger">*</span><?php echo language('bookcheque/bookcheque/bookcheque', 'tBcqDocnumMax'); ?></label>
                            <input type="number" style="text-align: right;" class="form-control" maxlength="200" id="onbChqMax" name="onbChqMax" placeholder="<?php echo language('bookcheque/bookcheque/bookcheque', 'tBcqDocnumMax'); ?>" autocomplete="off" value="<?php echo $tChqMax ?>" data-validate-required="<?php echo language('bookcheque/bookcheque/bookcheque', 'tBcqvalidateMax'); ?>">

                        </div>
                    </div>


                    <div class="form-group">
                        <label class="xCNLabelFrm"><?php echo language('bookcheque/bookcheque/bookcheque', 'tBcqRmk'); ?></label>
                        <textarea class="form-control" maxlength="100" rows="4" id="otaChqRmk" name="otaChqRmk"><?php echo $tChqRmk ?></textarea>
                    </div>
                    <!-- สถาณะใช้งาน -->
                    <div class="form-group">
                        <label class="fancy-checkbox">
                            <?php
                            if (!isset($tChqtStaUse) || $tChqtStaUse != 1) : ?>
                                <input type="checkbox" id="ocbChqtcheck" name="ocbChqtcheck" value="1">
                            <?php else : ?>
                                <input type="checkbox" id="ocbChqtcheck" name="ocbChqtcheck" value="1" checked>
                            <?php endif; ?>
                            <span><?php echo language('coupon/coupontype/coupontype', 'tCptStaUse'); ?>
                        </label>
                    </div>



                </div>
</form>


<script type="text/javascript">
    $('.selectpicker').selectpicker();
    $(".selection-2").select2({
        minimumResultsForSearch: 20,
        dropdownParent: $('#dropDownSelect1')
    });

    $('.xWTooltipsBT').tooltip({
        'placement': 'bottom'
    });
    $('[data-toggle="tooltip"]').tooltip({
        'placement': 'top'
    });

    //Set Lang Edit 
    var nLangEdits = <?= $this->session->userdata("tLangEdit") ?>;



    var nChqLangEdits = '<?php echo $this->session->userdata("tLangEdit"); ?>';
    var tChqBchCode = $('#ohdChqBchCode').val();
    var tChqShpCode = $('#ohdChqShpCode').val();

    // ตรวจสอบระดับของ User  07/02/2020 Saharat(Golf)
    var tStaUsrLevel = '<?php echo $this->session->userdata("tSesUsrLevel"); ?>';
    var tUsrBchCode = '<?php echo $this->session->userdata("tSesUsrBchCode"); ?>';
    var tUsrBchName = '<?php echo $this->session->userdata("tSesUsrBchName"); ?>';
    var tUsrShpCode = '<?php echo $this->session->userdata("tSesUsrShpCode"); ?>';
    var tUsrShpName = '<?php echo $this->session->userdata("tSesUsrShpName"); ?>';

    $(document).ready(function() {

       
    });

    var oChqBrowseBch1 = function(poReturnInput) {

        let tBchInputReturnCode = poReturnInput.tReturnInputCode;
        let tBchInputReturnName = poReturnInput.tReturnInputName;
        let tBchNextFuncName = poReturnInput.tNextFuncName;
        let aBchArgReturn = poReturnInput.aArgReturn;

        var tUsrLevel 	  	= "<?php echo $this->session->userdata("tSesUsrLevel"); ?>";
        var tBchCodeMulti 	= "<?php echo $this->session->userdata("tSesUsrBchCodeMulti"); ?>";
        var nCountBch 		= "<?php echo $this->session->userdata("nSesUsrBchCount"); ?>";
        var tWhere 			= "";

        if(tUsrLevel != "HQ"){
            tWhere = " AND TCNMBranch.FTBchCode IN ("+tBchCodeMulti+") ";
        }else{
            tWhere = "";
        }

        let oBchOptionReturn = {
            Title: ['company/branch/branch', 'tBCHTitle'],
            Table: {
                Master: 'TCNMBranch',
                PK: 'FTBchCode'
            },
            Join: {
                Table: ['TCNMBranch_L'],
                On: ['TCNMBranch_L.FTBchCode = TCNMBranch.FTBchCode AND TCNMBranch_L.FNLngID = ' + nChqLangEdits]
            },
            Where:{
                Condition : [tWhere]
            },
            GrideView: {
                ColumnPathLang: 'company/branch/branch',
                ColumnKeyLang: ['tBCHCode', 'tBCHName'],
                ColumnsSize: ['15%', '75%'],
                WidthModal: 50,
                DataColumns: ['TCNMBranch.FTBchCode', 'TCNMBranch_L.FTBchName'],
                DataColumnsFormat: ['', ''],
                Perpage: 10,
                OrderBy: ['TCNMBranch.FDCreateOn DESC'],
            },
            CallBack: {
                ReturnType: 'S',
                Value: [tBchInputReturnCode, "TCNMBranch.FTBchCode"],
                Text: [tBchInputReturnName, "TCNMBranch_L.FTBchName"]
            },
            NextFunc: {
                FuncName: tBchNextFuncName,
                ArgReturn: aBchArgReturn
            },
            RouteAddNew: 'branch',
            BrowseLev: 1
        }
        return oBchOptionReturn;
    }




    // Event Browse Branch
    $('#obtBrowseBranch').unbind().click(function() {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
            JSxCheckPinMenuClose();
            window.oChqBrowseBchOption = undefined;
            oChqBrowseBchOption = oChqBrowseBch1({
                'tReturnInputCode': 'oetBchCode',
                'tReturnInputName': 'oetBchName',
                'tNextFuncName': 'JSxChqConsNextFuncBrowseBch',
                'aArgReturn': ['FTBchCode', 'FTBchName']
            });
            JCNxBrowseData('oChqBrowseBchOption');
        } else {
            JCNxShowMsgSessionExpired();
        }
    });


    // Functionality : Next Function Branch
    // Parameter : Event Next Func Modal
    // Create : 29/10/2019 Wasin(Yoshi)
    // Return : Clear Velues Data
    // Return Type : -
    function JSxChqConsNextFuncBrowseBch(poDataNextfunc) {
        if (poDataNextfunc == 'NULL') {
            // Start Add Disable Button Browse
            $('#obtBKLBrowseShop').prop("disabled", true);
            $('#obtBKLBrowsePos').prop("disabled", true);

            // Clear Data Input
            $('.xWInputBranch').val('');
            $('.xWInputShop').val('');
            $('.xWInputPos').val('');
            $('#obtBrowseBnk').attr('disabled');
        } else {
            $('#obtBrowseBnk').removeAttr('disabled');
            // Start Remove Disable Button Browse
            $('#obtBKLBrowseShop').prop("disabled", false);
            // End Remove Disable Button Browse     
            let aDataNextfunc = JSON.parse(poDataNextfunc);
            let tChqBchCode = aDataNextfunc[0];
            let tChqOldBchCode = $('#oetBKLBchCodeOld').val();
            if (tChqOldBchCode != tChqBchCode) {
                $('#oetChqBchCodeOld').val(tChqBchCode);
                // Start Add Disable Button Browse
                $('#obtBKLBrowsePos').prop("disabled", true);

                // Clear Data Input
                $('.xWInputShop').val('');
                $('.xWInputPos').val('');

            }
        }
        return;
    }

    //Set Event Browse 
    // $('#obtBrowseBnk').click(function(){JCNxBrowseData('oChqBrowseBnk');});
    var oChqBrowseBbk = {};
    $('#obtBrowseBnk').click(function() {

        oChqBrowseBbk = {
            Title: ['bank/bank/bank', 'tBNKTitle'],
            Table: {
                Master: 'TFNMBookBank',
                PK: 'FTBbkCode'
            },
            Join: {
                Table: ['TFNMBookBank_L', 'TFNMBank_L'],
                On: ['TFNMBookBank.FTBchCode = TFNMBookBank_L.FTBchCode AND TFNMBookBank.FTBbkCode = TFNMBookBank_L.FTBbkCode AND TFNMBookBank_L.FNLngID = ' + nLangEdits,
                    'TFNMBookBank.FTBnkCode = TFNMBank_L.FTBnkCode AND TFNMBank_L.FNLngID = ' + nLangEdits
                ]
            },
            Where: {
                Condition: [' AND TFNMBookBank.FTBchCode = \'' + $('#oetBchCode').val() + '\' '],
            },
            GrideView: {
                ColumnPathLang: 'bank/bank/bank',
                ColumnKeyLang: ['tBNKBbkCode', 'tBNKBbkName', 'tBNKTBName'],
                ColumnsSize: ['15%', '25%', '50%'],
                WidthModal: 50,
                DataColumns: ['TFNMBookBank.FTBbkCode', 'TFNMBookBank_L.FTBbkName', 'TFNMBank_L.FTBnkName'],
                DataColumnsFormat: ['', '', ''],
                Perpage: 10,
                OrderBy: ['TFNMBookBank.FDCreateOn DESC'],
                // SourceOrder: "ASC"
            },
            CallBack: {
                ReturnType: 'S',
                Value: ["oetBbkCode", "TFNMBookBank.FTBbkCode"],
                Text: ["oetBbkName", "TFNMBookBank_L.FTBbkName"],
            },
            // RouteAddNew : 'bankindex',
            RouteAddNew: 'BookBank',
            // BrowseLev : nStaBcqBrowseType
            BrowseLev: 1,
        }

        JCNxBrowseData('oChqBrowseBbk');
    });

    $('#obtBrowseBranch').click(function() {
        $('#obtBrowseBnk').attr('disabled', true);
        $('#oetBbkName').val('');
        $('#oetBbkCode').val('');
        JCNxBrowseData('oChqBrowseBch');
    });
</script>