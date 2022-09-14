<?php
if ($tTypePage == "Add") {
    $tBch            = $aHD['raItems']['rtVslBch'];
    $tVstShopCode    = $aHD['raItems']['rtVslShp'];
    $tVstShpName    = $aHD['raItems']['rtShpName'];
    $tVstRowQty        = $aHD['raItems']['rtVslRowQty'];
    $tVstColQty        = $aHD['raItems']['rtVslColQty'];
    $tVstStatusHD    = $aHD['raItems']['rtVslStaUse'];

    $tRoute         = "VendingShopLayoutEventAdd";
} else if ($tTypePage == "Edit") {
    $tBch            = $aHD['raItems']['rtVslBch'];
    $tVstShopCode    = $aHD['raItems']['rtVslShp'];
    $tVstShpName    = $aHD['raItems']['rtShpName'];
    $tVstRowQty        = $aHD['raItems']['rtVslRowQty'];
    $tVstColQty        = $aHD['raItems']['rtVslColQty'];
    $tVstStatusHD   = $aHD['raItems']['rtVslStaUse'];

    $tRoute         = "VendingShopLayoutEventEdit";
}

$tPDTLayoutDT = JSON_encode($aDT);
?>

<div>
    <hr>
</div>
<div class="col-lg-12" style="padding: 0px;">
    <div class="row" style="padding-top:20px !important;">
        <div class="col-xs-12 col-md-4 col-lg-4">
            <div style="border: 1px solid #e8e8e8; border-radius: 3px; box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);">
                <div style="height:35px; background-color:#222b3c; color:#FFF; width:100%; border-top-left-radius: 3px; border-top-right-radius: 3px;">
                    <label style="margin:1% 20px;"> <?php echo language('vending/vendingshoplayout/vendingmanage', 'tDetailsPDFLayout') ?> </label>
                </div>
                <div style="padding: 20px;">
                    <div class="row">
                        <div class="col-lg-4 col-sm-4 col-xs-3"><span> <?php echo language('vending/vendingshoplayout/vendingmanage', 'tShopLayout') ?></span></div>
                        <div class="col-lg-8 col-sm-8 col-xs-9"><span> : <?= $tVstShpName ?> ( <?php echo language('vending/vendingshoplayout/vendingmanage', 'tCode') ?> <?= $tVstShopCode ?> )</span></div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4 col-sm-4 col-xs-4"><span> <?php echo language('vending/vendingshoplayout/vendingmanage', 'tCountRowShopLayout') ?></span></div>
                        <div class="col-lg-8 col-sm-8 col-xs-8"><span> : <?= number_format($tVstRowQty, 0) ?> <?php echo language('vending/vendingshoplayout/vendingmanage', 'tRowShopLayout') ?> </span></div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4 col-sm-4 col-xs-4"><span> <?php echo language('vending/vendingshoplayout/vendingmanage', 'tCountColShopLayout') ?></span></div>
                        <div class="col-lg-8 col-sm-8 col-xs-8"><span> : <?= number_format($tVstColQty, 0) ?> <?php echo language('vending/vendingshoplayout/vendingmanage', 'tColShopLayout') ?> </span></div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4 col-sm-4 col-xs-4"><span> <?php echo language('vending/vendingshoplayout/vendingmanage', 'tStatusShopLayout') ?></span></div>
                        <div class="col-lg-8 col-sm-8 col-xs-8"><span> : <?= $tVstStatusHD == 1 ? language('vending/vendingshoplayout/vendingmanage', 'tStatusTrueShopLayout') : language('vending/vendingshoplayout/vendingmanage', 'tStatusFalseShopLayout') ?> </span></div>
                    </div>
                    <input type='hidden' id="ohdShopName" value="<?= $tVstShpName ?>">
                    <input type='hidden' id="ohdShopHD" value="<?= $tVstShopCode ?>">
                    <input type='hidden' id="ohdStatusHD" value="<?= $tVstStatusHD ?>">
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-md-8 col-lg-8">
            <span> <?php echo language('vending/vendingshoplayout/vendingmanage', 'tMangePDTLayout') ?> </span>
            <div id="odvContentProduct">

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="form-group" id="obtBTNInsertVendingManage" style="margin-top:20px; display: block;">
                <button type="submit" style="float: right;  width: 35%; max-width:135px;" id="" class="btn btn-primary" onclick="JSxInsertPDTintoDatabase()"><?php echo language('vending/vendingshoplayout/vendingmanage', 'tSave') ?></button>
            </div>
        </div>
    </div>
</div>

<!-- modal show product-->
<div class="modal fade" id="odvModalVendingPDT">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header xCNModalHead">
                <label class="xCNTextModalHeard"><?php echo language('vending/vendingshoplayout/vendingmanage', 'tVendingPDT') ?></label>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-6">
                        <img id="oimPDTImage" style="max-width: 140px !important; min-height: 140px !important; margin: 0px auto; display: block;" src="<?php echo  base_url() . '/application/modules/common/assets/images/imageItemVending.png' ?>">
                        <button type="button" class="btn xCNBtnBrowseAddOn" onclick="JSxInsertPDT();" style="margin: 10px auto; display: block; width: 50%; background-color:#179BFD !important; color: #FFF !important; font-size: 17px;">
                            <p id="ospTextInsertandChange" style="color:#FFF;"><?php echo language('vending/vendingshoplayout/vendingmanage', 'tInsertLayout') ?></p>
                        </button>
                    </div>
                    <div class="col-lg-6">
                        <span id="ospDetailRowandCol" style="font-weight: bold;"><?php echo language('vending/vendingshoplayout/vendingmanage', 'tRowISLayout') ?></span><br>
                        <span id="ospDetailPDTName" style="font-size: 22px !important;"> <?php echo language('vending/vendingshoplayout/vendingmanage', 'tNamePDFLayout') ?> </span><br>
                        <span id="ospDetailPDTDescription" style="font-size: 18px !important;"> <?php echo language('vending/vendingshoplayout/vendingmanage', 'tDetailPDFLayout') ?> </span><br>

                        <div class="row">
                            <!--อุณหภูมิ-->
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label><?= language('vending/vendingshoplayout/vendingmanage', 'tPDTTemp') ?></label>
                                    <div class="validate-input">
                                        <input type="text" class="form-control xCNInputNumericWithoutDecimal" id="oetPdtTemp" name="oetPdtTemp" value="" maxlength="3" placeholder="0" readonly>
                                    </div>
                                </div>
                            </div>

                            <!--เวลาในการอุ่น-->
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label><?= language('vending/vendingshoplayout/vendingmanage', 'tPDTTime') ?></label>
                                    <div class="validate-input">
                                        <input type="text" class="form-control xCNInputNumericWithoutDecimal" id="oetPdtTime" name="oetPdtTime" value="" maxlength="8" placeholder="/ วินาที" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!--ความลึก-->
                        <div class="form-group">
                            <label><?= language('vending/vendingshoplayout/vendingmanage', 'tPDTDim') ?></label>
                            <div class="validate-input">
                                <input type="text" style="text-align: right;" class="form-control xCNInputNumericWithoutDecimal" id="oetPdtDim" name="oetPdtDim" value='' maxlength="3">
                            </div>
                        </div>

                        <!--ความกว้าง-->
                        <div class="form-group">
                            <label><?= language('vending/vendingshoplayout/vendingmanage', 'tPDTWidth') ?></label>
                            <div class="validate-input">
                                <input type="text" style="text-align: right;" class="form-control xCNInputNumericWithoutDecimal" id="oetPdtWidth" name="oetPdtWidth" value='' maxlength="3">
                            </div>
                        </div>
                        <!--รหัสสินค้า-->
                        <input type="hidden" id="ohdBCHCode" name="ohdBCHCode" value="<?= $tBch ?>">
                        <input type="hidden" id="ohdFTLayColQtyMax" name="ohdFTLayColQtyMax" value="<?= $tVstColQty ?>">
                        <input type="hidden" id="ohdPdtCode" name="ohdPdtCode">
                        <input type="hidden" id="ohdPdtBarcode" name="ohdPdtBarcode">
                        <input type="hidden" id="ohdPdtImage" name="ohdPdtImage">
                        <input type="hidden" id="ohdPdtRow" name="ohdPdtRow">
                        <input type="hidden" id="ohdPdtWidth" name="ohdPdtWidth">
                        <input type="hidden" id="ohdTypeAddorEdit" name="ohdTypeAddorEdit">

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button id="osmConfirm" type="button" class="btn xCNBTNPrimery" onClick="JSnVendingConfirmPDT()">
                    <?php echo language('common/main/main', 'tModalConfirm'); ?>
                </button>
                <button type="button" class="btn xCNBTNDefult" data-dismiss="modal">
                    <?php echo language('common/main/main', 'tModalCancel'); ?>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- modal set height-->
<div class="modal fade" id="odvModalSetHeight">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header xCNModalHead">
                <label class="xCNTextModalHeard"><?php echo language('vending/vendingshoplayout/vendingmanage', 'tSetHeightHead') ?></label>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-6">

                        <!--ความสูง-->
                        <div class="form-group">
                            <label id="olaSetHeight"><?php echo language('vending/vendingshoplayout/vendingmanage', 'tSetHeightLayout') ?></label>
                            <div class="validate-input">
                                <input type="text" class="form-control xCNInputNumericWithoutDecimal" id="oetPdtSetheight" name="oetPdtSetheight" value="" maxlength="4" placeholder="/ เซนติเมตร">
                            </div>
                        </div>

                        <!--value set height-->
                        <input type="hidden" id="ohdSetHeightRow">
                        <div id="odvHiddenSetHeightHidden" style="display:none;"></div>

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button id="osmConfirm" type="button" class="btn xCNBTNPrimery" onClick="JSnVendingConfirmSetHeight()">
                    <?php echo language('common/main/main', 'tModalConfirm'); ?>
                </button>
                <button type="button" class="btn xCNBTNDefult" data-dismiss="modal">
                    <?php echo language('common/main/main', 'tModalCancel'); ?>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- modal Full Product -->
<div class="modal fade" id="odvModalFullPDT">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header xCNModalHead">
                <label class="xCNTextModalHeard"><?php echo language('vending/vendingshoplayout/vendingmanage', 'tColFullLayout') ?></label>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-6">
                        <?php echo language('vending/vendingshoplayout/vendingmanage', 'tColFullLayout') ?>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn xCNBTNDefult" data-dismiss="modal">
                    <?php echo language('common/main/main', 'tModalCancel'); ?>
                </button>
            </div>
        </div>
    </div>
</div>

<script src="<?= base_url('application/modules/common/assets/src/jFormValidate.js') ?>"></script>
<script>
    var tLangRowLayout = '<?php echo language('vending/vendingshoplayout/vendingmanage', 'tRowLayout') ?>';
    var tSelectLayout = '<?php echo language('vending/vendingshoplayout/vendingmanage', 'tSelectLayout') ?>';
    var tSetHeightLayout = '<?php echo language('vending/vendingshoplayout/vendingmanage', 'tSetHeightLayout') ?>';
    var tResetLayout = '<?php echo language('vending/vendingshoplayout/vendingmanage', 'tResetLayout') ?>';
    var tInsertPDTLayout = '<?php echo language('vending/vendingshoplayout/vendingmanage', 'tInsertPDTLayout') ?>';
    var tRowISLayout = '<?php echo language('vending/vendingshoplayout/vendingmanage', 'tRowISLayout') ?>';
    var tColISLayout = '<?php echo language('vending/vendingshoplayout/vendingmanage', 'tColISLayout') ?>';
    var tColFullLayout = '<?php echo language('vending/vendingshoplayout/vendingmanage', 'tColFullLayout') ?>';
    var tPlzInsertPDFLayout = '<?php echo language('vending/vendingshoplayout/vendingmanage', 'tPlzInsertPDFLayout') ?>';
    var tNamePDFLayout = '<?php echo language('vending/vendingshoplayout/vendingmanage', 'tNamePDFLayout') ?>';
    var tDetailPDFLayout = '<?php echo language('vending/vendingshoplayout/vendingmanage', 'tDetailPDFLayout') ?>';


    var tRowHD = '<?= number_format($tVstRowQty, 0) ?>'; // ชั้น
    var tColHD = '<?= number_format($tVstColQty, 0) ?>'; // ช่อง
    var tCNRow = 0;
    var tCNRowWidth = 0;
    var tTotalCantInput = 0;

    //step 1 create Table for PDT
    var aDataHTMLRecord = '';
    var nNumberRow = 1;
    for ($i = 0; $i < tRowHD; $i++) {
        aDataHTMLRecord += '<div class="">';
        aDataHTMLRecord += '<div id="odvContentPDTRow' + nNumberRow + '" style="height:140px; background-color:#FFF; border:1px solid #e8e8e8; margin-top: 5px; box-shadow:0 2px 6px rgba(0, 0, 0, 0.05);">';

        //left
        aDataHTMLRecord += '<div class="col-lg-10">';
        aDataHTMLRecord += '<div class="row" id="odvContentPDTRowDetail' + nNumberRow + '" style="white-space:nowrap; overflow-x:auto; padding: 11px;">';
        aDataHTMLRecord += '</div>';
        aDataHTMLRecord += '</div>';

        //right
        aDataHTMLRecord += '<div class="col-lg-2" style="border-left: 1px solid #e8e8e8; height: 100%;">';
        aDataHTMLRecord += '<div class="form-group" style="margin-top: 10px;">';
        aDataHTMLRecord += '<label class="xCNLabelFrm">' + tLangRowLayout + ' ' + nNumberRow + '</label>';


        // aDataHTMLRecord += '<select class="form-control ocmSelectManagement" id="ocmSelectManagement'+ nNumberRow +'" name="ocmSelectManagement'+ nNumberRow +'" onchange="JSxSelectOption(this,'+ nNumberRow +')">';
        // aDataHTMLRecord += '<option value="0" selected disabled >ตัวเลือก</option>';
        // aDataHTMLRecord += '<option value="optSetHeight'+nNumberRow+'" >   ตั้งค่าความสูง  </option>';
        // aDataHTMLRecord += '<option value="optInsertPDT'+nNumberRow+'">   เพิ่มสินค้า     </option>';
        // aDataHTMLRecord += '<option value="optResetPDT'+nNumberRow+'">    จัดใหม่       </option>';
        // aDataHTMLRecord += '</select>';

        aDataHTMLRecord += '<ul class="oulOptionSelect" id="ocmSelectManagement' + nNumberRow + '" name="ocmSelectManagement' + nNumberRow + '"><span class="lnr lnr-chevron-down" style="float: right; margin: 10px 10px; font-size: 10px !important; cursor: pointer;"></span>';
        aDataHTMLRecord += '<li class="init optSetTextHead' + nNumberRow + '" >' + tSelectLayout + '</li>';
        aDataHTMLRecord += '<li data-value="optSetHeight' + nNumberRow + '"  class="oliFirst" onclick="JSxSelectOptionUI(this,' + nNumberRow + ')">' + tSetHeightLayout + '</li>';
        aDataHTMLRecord += '<li data-value="optResetPDT' + nNumberRow + '" class="oliLast" onclick="JSxSelectOptionUI(this,' + nNumberRow + ')">' + tResetLayout + '</li>';
        aDataHTMLRecord += '</ul>';


        aDataHTMLRecord += '<div class="odvIconAddPDTMore" style="display:block; cursor: pointer; margin: 10px 0px; text-decoration: underline;" id="odvIconAddPDTMore' + nNumberRow + '" onclick="JSxInsertRow(' + nNumberRow + ')">' + tInsertPDTLayout + '</div>';
        aDataHTMLRecord += '</div>';
        aDataHTMLRecord += '</div>';

        aDataHTMLRecord += '</div>';
        aDataHTMLRecord += '</div>';
        nNumberRow++;
    }
    $("#odvContentProduct").append(aDataHTMLRecord);

    //step 2 modal PDF
    function JSxInsertRow(tRow) {
        $('#ospTextInsertandChange').text('<?= language('vending/vendingshoplayout/vendingmanage', 'tInsertLayout') ?>');

        //set value
        JsxResetProduct();

        //parameter : tRow จำนวนชั้น
        //จำนวนชั้น
        $('#ohdPdtRow').val(tRow);
        $('#ohdTypeAddorEdit').val('insert');

        //ห้ามกรอกเกิน
        var tCNRow = $('.xCNRow' + tRow).length;
        var tNewRowShow = tCNRow + 1;
        $('#ospDetailRowandCol').text(tRowISLayout + tRow + tColISLayout + tNewRowShow);

        //จำนวนช่อง
        $('#ohdPdtWidth').val(tNewRowShow);

        $('.xCNRow' + tRow).each(function(i, obj) {
            tCNRowWidth = parseInt($(obj).attr('data-rowwidth')) + parseInt(tCNRowWidth);
        });

        //alert('INSERT =>  ใช้ช่องไปแล้วทั้งหมด : ' + tCNRowWidth + ' อนุญาติใช้ทั้งหมด : ' + tColHD);
        if (tCNRowWidth < tColHD) {
            $('#odvModalVendingPDT').modal('show');
            tTotalCantInput = tColHD - tCNRowWidth;
            //alert('เหลือใช้เพียง : ' + tTotalCantInput);
            $('#oetPdtWidth').change(function(e) {
                if ($(this).val() > tTotalCantInput) {
                    $(this).val(tTotalCantInput);
                }

                if ($(this).val() == 0) {
                    $(this).val(1);
                }
            });
        } else {
            // alert(tColFullLayout);
            $('#odvModalFullPDT').modal('show');
            tTotalCantInput = 0;
        }

        tCNRow = 0;
        tCNRowWidth = 0;
    }

    //step 3 BTN insert PDF Browse modal pdt
    function JSxInsertPDT() {
        //NextFunc : FTPdtCode','FTPdtName','FTPdtRmk','FTImgObj','FCPdtCookTime','FCPdtCookHeat
        var dTime = new Date();
        var dTimelocalStorage = dTime.getTime();

        aMulti = [];
        $.ajax({
            type: "POST",
            url: "BrowseDataPDT",
            data: {
                Qualitysearch: [
                    /*"SUP",
                    "PurchasingManager",
                    "NAMEPDT",
                    "CODEPDT",
                    "BARCODE",
                    'LOC',
                    "FromToBCH",
                    "Merchant",
                    "GroupMerchant",
                    "FromToSHP",
                    "FromToPGP",
                    "FromToPTY",
                    "PDTLOGSEQ"*/
                ],
                'PriceType': ['Pricesell'],
                'SelectTier': ['PDT'],
                'ShowCountRecord': 10,
                'NextFunc': 'JsxSetPDTInModal',
                'ReturnType': 'S',
                'SPL': ['', ''],
                'BCH': ['', ''],
                'SHP': [$('#ohdShopHD').val(), $('#ohdShopName').val()],
                'TimeLocalstorage': dTimelocalStorage
            },
            cache: false,
            timeout: 5000,
            success: function(tResult) {
                $('#odvModalDOCPDT').modal({
                    backdrop: 'static',
                    keyboard: false
                })
                $('#odvModalDOCPDT').modal({
                    show: true
                });

                //remove localstorage
                localStorage.removeItem("LocalItemDataPDT");
                localStorage.removeItem("LocalItemDataPDT" + dTimelocalStorage);
                $('#odvModalsectionBodyPDT').html(tResult);
            },
            error: function(data) {
                console.log(data);
            }
        });
    }

    //set text in modal
    function JsxSetPDTInModal(elem) {
        var aData = JSON.parse(elem);

        var tPDTCode = aData[0].packData.PDTCode;
        var tPDTName = aData[0].packData.PDTName;
        var tPDTDetail = aData[0].packData.Remark;
        var tPDTImage = aData[0].packData.IMAGE;
        var tCookTime = aData[0].packData.CookTime;
        var tCookHeat = aData[0].packData.CookHeat;
        var tBarcode = aData[0].packData.Barcode;

        var tImg = '';
        if (tPDTImage != null) {
            tImg += tPDTImage.substr(0, 1)
        }


        if (tPDTImage == '' || tPDTImage == null) {
            var tPathImage = '<?= base_url() ?>' + 'application/modules/common/assets/images/imageItemVending.png';
        } else if (tImg == '#') {
            var tPathImage = tPDTImage;
        } else {
            var aImgObj = tPDTImage.split("application");
            var tFullPatch = './application' + aImgObj[1];
            var tPathImage = '<?= base_url() ?>' + 'application' + aImgObj[1];
        }

        $('#ospDetailPDTName').text(tPDTName);
        $('#ospDetailPDTDescription').text(tPDTDetail);
        $('#oimPDTImage').attr('src', tPathImage);
        $('#ohdPdtBarcode').val(tBarcode);
        $('#ohdPdtCode').val(tPDTCode);
        $('#ohdPdtImage').val(tPathImage);
        $('#oetPdtTemp').val(tCookHeat);
        $('#oetPdtTime').val(tCookTime);
    }

    //step 4 Confirm PDT
    function JSnVendingConfirmPDT() {
        var tTypeorEdit = $('#ohdTypeAddorEdit').val();
        tTotalCantInput = 0;
        tCNRowWidth = 0;

        if (tTypeorEdit == 'insert') {
            var tPDTDim = $('#oetPdtDim').val();
            var tPDTTemp = $('#oetPdtTemp').val();
            var tPDTTime = $('#oetPdtTime').val();
            var tPDTWidth = $('#oetPdtWidth').val();
            var tBarcode = $('#ohdPdtBarcode').val();
            var tPDTCode = $('#ohdPdtCode').val();
            var tPDTImage = $('#ohdPdtImage').val();
            var tRow = $('#ohdPdtRow').val();
            var tStartWidth = $('#ohdPdtWidth').val();
            var tNamePDT = $('#ospDetailPDTName').text();
            var tDetailPDT = $('#ospDetailPDTDescription').text();


            var tImg = '';
            if (tPDTImage != null) {
                tImg += tPDTImage.substr(0, 1)
            }

            if (tPDTCode == '' || tPDTCode == null) {
                JSxInsertPDT();
                //alert(tPlzInsertPDFLayout);
            } else {
                if (tPDTWidth == '' || tPDTWidth == null) {
                    $('#oetPdtWidth').focus();
                } else {


                    if (tPDTImage == '' || tPDTImage == null) {
                        var tPDTImage = '<?= base_url() ?>' + 'application/modules/common/assets/images/imageItemVending.png';
                    } else if (tImg == '#') {
                        var tPDTImage = tPDTImage;
                    } else {
                        var aImgObj = tPDTImage.split("application");
                        var tFullPatch = './application' + aImgObj[1];
                        var tPDTImage = '<?= base_url() ?>' + 'application' + aImgObj[1];
                    }

                    if (tPDTDim == '' || tPDTDim == null) {
                        tPDTDim = 1;
                    }

                    //append PDT
                    var tWidthPDT = tPDTWidth + '00px';
                    var tHTML = '<div class="xCNRow' + tRow + '" id="Key' + tRow + '' + tStartWidth + '" data-rowstart=' + tRow + ' data-rowstartcol=' + tStartWidth + ' data-rowwidth=' + tPDTWidth + ' data-rowdim=' + tPDTDim + ' data-rowtemp=' + tPDTTemp + ' data-rowtime=' + tPDTTime + ' data-rowcode=' + tPDTCode + ' data-rowimage=' + tPDTImage + ' data-rownamepdt=' + tNamePDT + '  data-rowdetailpdt="' + tDetailPDT + '" data-barcode="' + tBarcode + '" style="height: 100px; background:#FFF; border:1px solid #e6e6e6; border-radius: 10px; display:inline-block; width:' + tWidthPDT + '; margin-right:10px;">';
                    tHTML += '<div style="width: 80px; margin: 10px auto; height: 80px; display: block;">';
                    if (tImg == '#') {
                        tHTML += '<span style=" background-color:' + tPDTImage + ' !important; position: absolute; max-height: 90%; max-width: 90%; top: 0; bottom: 0; left: 0; right: 0; margin: auto;"  />';
                    } else {
                        tHTML += '<img style="width: 100%; height:100%; display: block; cursor: pointer;" src=' + tPDTImage + ' onclick="JSxChangePDT(' + tRow + ',' + tStartWidth + ')">';

                    }
                    tHTML += '</div>';
                    tHTML += '</div>';
                    $("#odvContentPDTRow" + tRow + " #odvContentPDTRowDetail" + tRow + ":first-child").append(tHTML);
                    $('#odvModalVendingPDT').modal('hide');
                    //ล้างค่า  PDT in modal
                    JsxResetProduct();
                }
            }

        } else if (tTypeorEdit == 'edit') {
            var tPDTDim = $('#oetPdtDim').val();
            var tPDTTemp = $('#oetPdtTemp').val();
            var tPDTTime = $('#oetPdtTime').val();
            var tPDTWidth = $('#oetPdtWidth').val();
            var tBarcode = $('#ohdPdtBarcode').val();
            var tPDTCode = $('#ohdPdtCode').val();
            var tPDTImage = $('#ohdPdtImage').val();
            var tRow = $('#ohdPdtRow').val();
            var tStartWidth = $('#ohdPdtWidth').val();
            var tNamePDT = $('#ospDetailPDTName').text();
            var tDetailPDT = $('#ospDetailPDTDescription').text();

            $('#Key' + tRow + tStartWidth).attr('data-rowstartcol', tStartWidth);
            $('#Key' + tRow + tStartWidth).attr('data-rowwidth', tPDTWidth);
            $('#Key' + tRow + tStartWidth).attr('data-rowdim', tPDTDim);
            $('#Key' + tRow + tStartWidth).attr('data-rowtemp', tPDTTemp);
            $('#Key' + tRow + tStartWidth).attr('data-rowtime', tPDTTime);
            $('#Key' + tRow + tStartWidth).attr('data-rowcode', tPDTCode);
            $('#Key' + tRow + tStartWidth).attr('data-rowimage', tPDTImage);
            $('#Key' + tRow + tStartWidth).attr('data-rownamepdt', tNamePDT);
            $('#Key' + tRow + tStartWidth).attr('data-rowdetailpdt', tDetailPDT);
            $('#Key' + tRow + tStartWidth).attr('data-barcode', tBarcode);
            $('#Key' + tRow + tStartWidth).children().children().attr('src', tPDTImage);
            var tWidthPDT = tPDTWidth + '00px';
            $('#Key' + tRow + tStartWidth).css('width', tWidthPDT);
            $('#odvModalVendingPDT').modal('hide');
            //ล้างค่า  PDT in modal
            JsxResetProduct();
        }
    }

    //ล้างค่า PDT in modal
    function JsxResetProduct() {
        $('#oetPdtDim').val('');
        $('#oetPdtTemp').val('');
        $('#oetPdtTime').val('');
        $('#oetPdtWidth').val('');
        $('#ohdPdtBarcode').val('');
        $('#ohdPdtCode').val('');
        $('#ohdPdtImage').val('');
        $('#ohdPdtRow').val('');
        $('#ospDetailPDTName').text(tNamePDFLayout);
        $('#ospDetailPDTDescription').text(tDetailPDFLayout);
        var tPathImage = '<?= base_url() ?>' + 'application/modules/common/assets/images/imageItemVending.png';
        $('#oimPDTImage').attr('src', tPathImage);


        var tDim = $('#oetPdtDim').val();
        var tWidth = $('#oetPdtWidth').val();
        if (tDim == '' || tDim == null) {
            $('#oetPdtDim').val(1);
        }
        if (tWidth == '' || tWidth == null) {
            $('#oetPdtWidth').val(1);
        }
    }

    //step 5 เปลี่ยนสินค้า
    function JSxChangePDT(tRow, tStartWidth) {
        $('#ospTextInsertandChange').text('<?= language('vending/vendingshoplayout/vendingmanage', 'tChangeLayout') ?>');
        $('#odvModalVendingPDT').modal('show');

        var tPDT = $('#Key' + tRow + tStartWidth);
        var tStarRow = tPDT.attr('data-rowstart');
        var tStarCol = tPDT.attr('data-rowstartcol');
        var tUseRow = tPDT.attr('data-rowwidth');
        var tPDTDim = tPDT.attr('data-rowdim');
        var tPDTTemp = tPDT.attr('data-rowtemp');
        var tPDTTime = tPDT.attr('data-rowtime');
        var tPDTCode = tPDT.attr('data-rowcode');
        var tPDTImage = tPDT.attr('data-rowimage');
        var tBarcode = tPDT.attr('data-barcode');

        var tImg = '';
        if (tPDTImage != null) {
            tImg += tPDTImage.substr(0, 1)
        }


        if (tPDTImage == '' || tPDTImage == null) {
            var tPDTImage = '<?= base_url() ?>' + 'application/modules/common/assets/images/imageItemVending.png';
        } else if (tImg == '#') {
            var tPDTImage = tPDTImage;
        } else {
            var aImgObj = tPDTImage.split("application");
            var tFullPatch = './application' + aImgObj[1];
            var tPDTImage = '<?= base_url() ?>' + 'application' + aImgObj[1];
        }

        var tPDTNamepdt = tPDT.attr('data-rownamepdt');
        var tPDTNDetailpdt = tPDT.attr('data-rowdetailpdt');

        $('#ohdPdtRow').val(tRow)
        $('#ohdPdtWidth').val(tStartWidth);
        $('#ohdTypeAddorEdit').val('edit');

        $('#ospDetailRowandCol').text(tRowISLayout + tStarRow + tColISLayout + tStarCol);


        $('.xCNRow' + tRow).each(function(i, obj) {
            tCNRowWidth = parseInt($(obj).attr('data-rowwidth')) + parseInt(tCNRowWidth);
        });

        //alert('EDIT => ถูกใช้งานไปแล้ว : ' + tCNRowWidth + ' อนุญาติใช้ทั้งหมด : ' + tColHD + ' ตัวมันเองใช้อยู่ : ' + tUseRow);
        tTotalCantInput = parseInt(tColHD - tCNRowWidth) + parseInt(tUseRow);
        $('#odvModalVendingPDT').modal('show');
        $('#oetPdtWidth').change(function(e) {
            if ($(this).val() > tTotalCantInput) {
                $(this).val(tTotalCantInput);
            }

            if ($(this).val() == 0) {
                $(this).val(1);
            }
        });


        $('#oetPdtDim').val(tPDTDim);
        $('#oetPdtTemp').val(tPDTTemp);
        $('#oetPdtTime').val(tPDTTime);
        $('#oetPdtWidth').val(tUseRow);
        $('#ohdPdtBarcode').val(tBarcode);
        $('#ohdPdtCode').val(tPDTCode);
        $('#oimPDTImage').attr('src', tPDTImage);
        $('#ohdPdtRow').val(tStarRow);
        $('#ohdPdtImage').val(tPDTImage);

        $('#ospDetailPDTName').text(tPDTNamepdt);
        $('#ospDetailPDTDescription').text(tPDTNDetailpdt);
        $('#ohdTypeAddorEdit').val('edit');
        tCNRowWidth = 0;
    }

    //BTN Reset PDT in row
    function JSxResetDatainRow(pnRow) {
        $('#odvContentPDTRowDetail' + pnRow).empty();
        JsxResetProduct();
    }

    //Select option
    function JSxSelectOption(ptElement, ptRow) {
        $(ptElement).removeClass('ocmSelectManagement');
        //$('.ocmSelectManagement option[value=0]').prop('selected',true);
        $('.ocmSelectManagement option[value=0]').prop('selected', true);

        var tOption = $('#ocmSelectManagement' + ptRow + ' option:selected').val();
        //$('.odvIconAddPDTMore').css('display','none');
        switch (tOption) {
            case 'optSetHeight' + ptRow:
                JSxSetHeight(ptRow);
                break;
            case 'optInsertPDT' + ptRow:
                $('#odvIconAddPDTMore' + ptRow).css('display', 'block');
                JSxInsertRow(ptRow);
                break;
            case 'optResetPDT' + ptRow:
                JSxResetDatainRow(ptRow);
                break;
            default:
        }

        $(ptElement).addClass('ocmSelectManagement');
    }

    //modal set height
    function JSxSetHeight(ptRow) {
        $('#oetPdtSetheight').val('');
        $('#olaSetHeight').text(tSetHeightLayout + ' ' + tLangRowLayout + ' ' + ptRow);
        $('#odvModalSetHeight').modal('show');
        $('#ohdSetHeightRow').val(ptRow);

        var tCheckClass = $('#odvHiddenSetHeightHidden').children().hasClass("ohdValueSetHeightByRow" + ptRow);
        if (tCheckClass == true) {
            var nValueold = $('#ohdValueSetHeightByRow' + ptRow).val();
            $('#oetPdtSetheight').val(nValueold);
        }

    }

    //confirm set height
    function JSnVendingConfirmSetHeight() {
        var nValue = $('#oetPdtSetheight').val();
        var nSetHeightRow = $('#ohdSetHeightRow').val();
        var tCheckClass = $('#odvHiddenSetHeightHidden').children().hasClass("ohdValueSetHeightByRow" + nSetHeightRow);
        //check class ว่าเคยมีความสูงแล้วหรือยัง
        if (tCheckClass == true) {
            $('#ohdValueSetHeightByRow' + nSetHeightRow).val(nValue);
        } else if (tCheckClass == false) {
            var tHTMLValue = "<input type='hidden' class='ohdValueSetHeightByRow" + nSetHeightRow + "' id='ohdValueSetHeightByRow" + nSetHeightRow + "' value='" + nValue + "'>";
            $('#odvHiddenSetHeightHidden').append(tHTMLValue);
        }
        $('#odvModalSetHeight').modal('hide');
    }

    //case เข้ามาแบบมี Data (edit)
    var tChecktypeTo = '<?= $tPDTLayoutDT ?>';
    var taPDTLayput = JSON.parse(tChecktypeTo);
    if (taPDTLayput.rtCode == 1) {
        var tPDTItem = taPDTLayput.raItems;
        var tPDTCountItem = tPDTItem.length;

        for ($i = 0; $i < tPDTCountItem; $i++) {
            var tPDTDim = tPDTItem[$i].rtPdtDim;
            var tPDTTemp = (tPDTItem[$i].rtPdtCookHeat == null) ? '0' : tPDTItem[$i].rtPdtCookHeat;
            var tPDTTime = (tPDTItem[$i].rtPdtCookTime == null) ? '0' : tPDTItem[$i].rtPdtCookTime;
            var tPDTWidth = Number(tPDTItem[$i].rtPdtWide);
            var tBarcode = tPDTItem[$i].rtPdtBarcode;
            var tPDTCode = tPDTItem[$i].rtPdtCode;
            var tPDTImage = tPDTItem[$i].rtPdtImage;
            var tRow = tPDTItem[$i].rtPdtRow;
            var tStartWidth = parseInt(tPDTItem[$i].rtPdtCol) + 1;
            var tNamePDT = tPDTItem[$i].rtPdtName;
            var tDetailPDT = tPDTItem[$i].rtPdtRmk;


            var tImg = '';
            if (tPDTImage != null) {
                tImg += tPDTImage.substr(0, 1)
            }

            if (tPDTImage == '' || tPDTImage == null) {
                var tPDTImage = '<?= base_url() ?>' + 'application/modules/common/assets/images/imageItemVending.png';
            } else if (tImg == '#') {
                var tPDTImage = tPDTImage;
            } else {
                var aImgObj = tPDTImage.split("application");
                var tFullPatch = './application' + aImgObj[1];
                var tPDTImage = '<?= base_url() ?>' + 'application' + aImgObj[1];
            }

            var tWidthPDT = tPDTWidth + '00px';
            var tHTML = '<div class="xCNRow' + tRow + '" id="Key' + tRow + '' + tStartWidth + '" data-rowstart=' + tRow + ' data-rowstartcol=' + tStartWidth + ' data-rowwidth=' + tPDTWidth + ' data-rowdim=' + tPDTDim + ' data-rowtemp=' + tPDTTemp + ' data-rowtime=' + tPDTTime + ' data-rowcode=' + tPDTCode + ' data-rowimage=' + tPDTImage + ' data-rownamepdt=' + tNamePDT + '  data-rowdetailpdt="' + tDetailPDT + '" data-barcode="' + tBarcode + '" style="height: 100px; background:#FFF; border:1px solid #e6e6e6; border-radius: 10px; display:inline-block; width:' + tWidthPDT + '; margin-right:10px;">';
            tHTML += '<div style="width: 80px; margin: 10px auto; height: 80px; display: block;">';
            if (tImg == '#') {
                tHTML += '<span style=" background-color:' + tPDTImage + ' !important; position: absolute; max-height: 90%; max-width: 90%; top: 0; bottom: 0; left: 0; right: 0; margin: auto;"  />';

            } else {
                tHTML += '<img style="width: 100%; height:100%; display: block; cursor: pointer;" src=' + tPDTImage + ' onclick="JSxChangePDT(' + tRow + ',' + tStartWidth + ')">';

            }
            tHTML += '</div>';
            tHTML += '</div>';
            $("#odvContentPDTRow" + tRow + " #odvContentPDTRowDetail" + tRow + ":first-child").append(tHTML);
            JsxResetProduct();


            var nValue = tPDTItem[$i].rtPdtHigh;
            var tCheckClass = $('#odvHiddenSetHeightHidden').children().hasClass("ohdValueSetHeightByRow" + tRow);
            //check class ว่าเคยมีความสูงแล้วหรือยัง
            if (tCheckClass == true) {
                $('#ohdValueSetHeightByRow' + tRow).val(nValue);
            } else if (tCheckClass == false) {
                var tHTMLValue = "<input type='hidden' class='ohdValueSetHeightByRow" + tRow + "' id='ohdValueSetHeightByRow" + tRow + "' value='" + nValue + "'>";
                $('#odvHiddenSetHeightHidden').append(tHTMLValue);
            }
        }
    }
</script>



<!--New option -->
<style>
    .oulOptionSelect {
        height: 32px;
        width: 100%;
        border-radius: 2px;
        border: 1px solid #ccc;
        font-size: 15px !important;
    }

    .oulOptionSelect li {
        padding: 2px 10px;
        z-index: 100;
        font-size: 18px !important;
    }

    .oulOptionSelect li:not(.init) {
        float: left;
        width: 100%;
        font-size: 17px !important;
        display: none;
        background: #FFF;
        border-left: 1px solid #71a3ff;
        border-right: 1px solid #71a3ff;
    }

    .oliFirst {
        border-top: 1px solid #71a3ff;
        margin-top: 1px;
        position: absolute;
    }

    .oliLast {
        border-bottom: 1px solid #71a3ff;
        margin-top: 30px;
        position: absolute;
    }



    .oulOptionSelect li:not(.init):hover,
    .oulOptionSelect li.selected:not(.init) {
        color: #FFF;
        cursor: pointer;
        background: #09f;
    }

    li.init {
        cursor: pointer;
    }

    /* a#submit { z-index: 1; } */
</style>
<script>
    $(".oulOptionSelect").on("click", ".init", function() {
        $(this).closest(".oulOptionSelect").children('li:not(.init)').toggle();
    });

    function JSxSelectOptionUI(ptElement, numrow) {
        $('.init').text(tSelectLayout);

        var tText = $(ptElement).html();
        $('.optSetTextHead' + numrow).text(tText);

        $(ptElement).closest(".oulOptionSelect").children('li:not(.init)').toggle();

        var tValue = $(ptElement).data('value');
        switch (tValue) {
            case 'optSetHeight' + numrow:
                JSxSetHeight(numrow);
                break;
                // case 'optInsertPDT'+numrow:
                //     $('#odvIconAddPDTMore'+numrow).css('display','block');
                //     JSxInsertRow(numrow);
                //     break;
            case 'optResetPDT' + numrow:
                JSxResetDatainRow(numrow);
                break;
            default:
        }
    }
</script>