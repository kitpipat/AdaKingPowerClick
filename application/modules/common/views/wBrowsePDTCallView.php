<?php
//Get parameter SPL
if (empty($tParameterSPL)) {
    $tSPLCode   = '';
} else {
    if ($tParameterSPL[0] == '') {
        $tSPLCode   = '';
    } else {
        $tSPLCode   = $tParameterSPL[0];
    }
}

//Get parameter BCH
if (empty($tParameterBCH)) {
    $tBCHCode   = '';
} else {
    if ($tParameterBCH[0] == '') {
        $tBCHCode   = '';
    } else {
        $tBCHCode   = $tParameterBCH[0];
    }
}

//Get parameter MER
if (empty($tParameterMER)) {
    $tMERCode   = '';
} else {
    if ($tParameterMER[0] == '') {
        $tMERCode   = '';
    } else {
        $tMERCode   = $tParameterMER[0];
    }
}

//Get parameter SHP
if (empty($tParameterSHP)) {
    $tSHPCode   = '';
} else {
    if ($tParameterSHP[0] == '') {
        $tSHPCode   = '';
    } else {
        $tSHPCode   = $tParameterSHP[0];
    }
}


//Get tParameter DISTYPE
if (empty($tParameterDISTYPE)) {
    $tDISTYPE   = '';
} else {
    $tDISTYPE   = $tParameterDISTYPE;
}

//Get parameter not in item
if (empty($aNotinItem)) {
    $tTextNotinItem = '';
} else {
    $tTextNotinItem = '';
    for ($i = 0; $i < FCNnHSizeOf($aNotinItem); $i++) {
        $tTextNotinItem .= $aNotinItem[$i][0] . ':::' . $aNotinItem[$i][1] . ',';

        if ($i == FCNnHSizeOf($aNotinItem) - 1) {
            $tTextNotinItem = substr($tTextNotinItem, 0, -1);
        }
    }
}
?>

<!-- element name and value -->
<input type='hidden' name="odhEleNamePDT" id="odhEleNamePDT" value="<?= $tElementreturn[0] ?>">
<input type='hidden' name="odhEleValuePDT" id="odhEleValuePDT" value="<?= $tElementreturn[1] ?>">
<input type='hidden' name="odhEleNameNextFunc" id="odhEleNameNextFunc" value="<?= $tNameNextFunc ?>">
<input type='hidden' name="odhEleReturnType" id="odhEleReturnType" value="<?= $tReturnType ?>">
<input type='hidden' name="odhSelectTier" id="odhEleSelectTier" value="<?= $tSelectTier ?>">
<input type='hidden' name="odhTimeStorage" id="odhTimeStorage" value="<?= $tTimeLocalstorage ?>">
<input type='hidden' name="ohdSessionBCH" id="ohdSessionBCH" value="<?= $this->session->userdata("tSesUsrBchCode") ?>">
<input type='hidden' name="ohdSessionSHP" id="ohdSessionSHP" value="<?= $this->session->userdata("tSesUsrShpCode") ?>">
<input type='hidden' name="ohdNotinItem" id="ohdNotinItem" value="<?= $tTextNotinItem ?>">
<input type='hidden' name="ohdProductCode" id="ohdProductCode" value="<?= $tParameterProductCode ?>">
<input type='hidden' name="ohdAgenCode" id="ohdAgenCode" value="<?= $tParameterAgenCode ?>">

<div class="row">
    <!--layout search-->
    <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
        <!--content tab-->
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="row">

                    <!--ค้นหา-->
                    <div class="col-lg-2 col-md-2">
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?= language('common/main/main', 'tSearch') ?></label>
                            <select class="selectpicker form-control" id="ocmSearchPDTSelectbox" name="ocmSearchPDTSelectbox">
                                <!-- <option value="ALL"><?= language('common/main/main', 'tAll'); ?></option> -->
                                <option value="FTPdtName"><?= language('common/main/main', 'tCenterModalPDTNamePDT'); ?></option>
                                <option value="FTPdtCode"><?= language('common/main/main', 'tCenterModalPDTCodePDT'); ?></option>
                                <option value="FTBarCode"><?= language('common/main/main', 'tCenterModalPDTBarcode'); ?></option>
                                <option value="FTPgpCode"><?= language('common/main/main', 'tCenterModalPDTPGPFrom'); ?></option>
                                <option value="FTPtyCode"><?= language('common/main/main', 'tCenterModalPDTPTYFrom'); ?></option>
                                <option value="FTBuyer"><?= language('common/main/main', 'tCenterModalPDTPurchasing'); ?></option>
                                <!-- <option value="FTPlcCode"><?= language('common/main/main', 'tCenterModalPDTLOGSEQFrom'); ?></option> -->
                            </select>
                        </div>
                        <style>
                            .bootstrap-select>.dropdown-toggle {
                                height: 35px;
                            }
                        </style>
                        <script>
                            $('.selectpicker').selectpicker();
                        </script>
                    </div>

                    <!--กรอกคำค้นหา-->
                    <div class="col-lg-3 col-md-3">
                        <div class="form-group">
                            <label class="xCNLabelFrm"></label>
                            <div class="input-group">
                                <input type="text" class="form-control xCNInputWithoutSingleQuote" id="oetSearchPDTText" name="oetSearchPDTText" onkeyup="Javascript:if(event.keyCode==13) JSxGetPDTTable()" value="" placeholder="<?= language('common/main/main', 'tPlaceholder') ?>">
                                <span class="input-group-btn">
                                    <button class="btn xCNBtnSearch" type="button" onclick="JSxGetPDTTable()">
                                        <img class="xCNIconAddOn" src="<?= base_url() . '/application/modules/common/assets/images/icons/search-24.png' ?>">
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>

                    <!--สินค้าเคลือนไหว-->
                    <div class="col-lg-3 col-md-3" style="margin-top: 40px;">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="ocbPDTMoveon" id="ocbPDTMoveon" value="1" checked>
                            <label class="form-check-label">
                                <?= language('common/main/main', 'tCenterModalPDTMoveon') ?>
                            </label>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!--end layout search-->

    <!--layout table-->
    <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
        <div id="odvTableContentPDT" style="height:412px;">
            <img src="<?php echo base_url() ?>application/modules/common/assets/images/ada.loading.gif" class="xWImgLoading">
        </div>
    </div>
    <!--end layout table-->
</div>

<script>
    //Get Data
    JSxGetPDTTable();

    function JSxGetPDTTable(pnPage) {
        if (pnPage == '' || pnPage == null) {
            pnPage = 1;
        } else {
            pnPage = pnPage;
        }

        var SelectTier = $('#odhEleSelectTier').val();
        var aPriceType = '<?= $aPriceType[0] ?>';

        //สินค้าเคลื่อนไหว
        if ($('#ocbPDTMoveon').is(":checked")) {
            var nPDTMoveon = 1;
        } else {
            var nPDTMoveon = 2;
        }

        var nPageTotal = $('#ospAllPDTRow').text();

        //ตัว รีโหลดเวลาโหลดสินค้า
        var tImage = "<img src='<?= base_url() ?>application/modules/common/assets/images/ada.loading.gif' class='xWImgLoading'>";
        $('#odvTableContentPDT').html(tImage);
        $('#odvTableContentPDT').css('height', '412px');

        $.ajax({
            type: "POST",
            url: "BrowseDataPDTTableCallView",
            data: {
                'tPagename': '<?= $tPagename ?>',
                'nPage': pnPage,
                'nRow': '<?= $nShowCountRecord ?>',
                'aPriceType': '<?= json_encode($aPriceType) ?>',
                'BCH': '<?= $tBCHCode ?>',
                'SHP': '<?= $tSHPCode ?>',
                'MER': '<?= $tMERCode ?>',
                'SPL': '<?= $tSPLCode ?>',
                'DISTYPE': '<?= $tDISTYPE ?>',
                'SelectTier': $('#odhEleSelectTier').val(),
                'ReturnType': $('#odhEleReturnType').val(),
                'aNotinItem': $('#ohdNotinItem').val(),
                'PDTMoveon': nPDTMoveon,
                'tSearchText': $('#oetSearchPDTText').val(),
                'tSearchSelect': $('#ocmSearchPDTSelectbox option:selected').val(),
                'nTotalResult': nPageTotal,
                'ProductCode': '<?= $tParameterProductCode ?>',
                'AgenCode': '<?= $tParameterAgenCode ?>',
                'tNotInPdtType': '<?= json_encode($tNotInPdtType) ?>',
                'tWhere' : <?= json_encode($tWhere) ?>,
                'tStaPdtLay' : '<?=$tStaPdtLay?>'
            },
            cache: false,
            timeout: 0,
            success: function(tResult) {
                $('#odvTableContentPDT').html(tResult);
                $('#odvTableContentPDT').css('height', 'auto');

                var tTimeStorage = $('#odhTimeStorage').val();
                var LocalItemDataPDT = localStorage.getItem("LocalItemDataPDT" + tTimeStorage);
                if (LocalItemDataPDT != '' || LocalItemDataPDT != null) {
                    var tResultPDT = JSON.parse(LocalItemDataPDT);
                    if (tResultPDT == null || tResultPDT == '') {

                    } else {
                        var nCount = tResultPDT.length;
                        for ($i = 0; $i < nCount; $i++) {
                            var tStringCheck = tResultPDT[$i].pnPdtCode + tResultPDT[$i].ptBarCode;
                            var tChcek = 'JSxPDTClickMuti' + tStringCheck;
                            $('.' + tChcek).addClass('xCNActivePDT');
                            $('.' + tChcek).find('td').attr('style', 'color: #FFF !important;');
                        }
                    }
                }
            },
            error: function(data) {
                console.log(data);
            }
        });
    }
</script>