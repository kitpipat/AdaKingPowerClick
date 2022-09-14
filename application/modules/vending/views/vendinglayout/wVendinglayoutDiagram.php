<style>

    @media print{
        
        .xWOdvBtnMenu , 
        #odvLangEditPanal, 
        #oliMenuNav , 
        #odvShopRowNavMenu , 
        #odvDetailShopLayout , 
        #obtSaveShopLayout , 
        #obtCancelShopLayout , 
        #obtPrintShopLayout {
            display: none;
        }

        #odvContentProductBorder{
            margin-top  : -80px;
            margin-left : -30px;
        }

        html, body {
            height  : 100%; 
            margin  : 0 !important; 
            padding : 0 !important;
            overflow: hidden;
        }

        @page {
            margin  : 0;
            size    : landscape
        }

    }


    #odvContentProduct {
        width: 100%;
        height: auto;
        min-height: 600px;
        border: 1px solid #FFF;
    }

    .wCNOuterPDT {
        border-radius: 2px;
        max-width: 70px !important;
        max-height: 70px !important;
        border: 1px solid #d4d4d4;
        background: #FFF;
        margin: 4px;
        position: relative;
        display: inline-block;
    }

    .xCNLineFloor {
        /* width           :100%; 
        height          :1px;
        background      :#eaeaea; */
        margin: 3px 0px 0px 0px;
    }

    .wCNInnerPDT {
        /* width           : 90%;
        height          : 90%;
        border-radius   : 2px;
        top             : 5%;
        left            : 5%;
        background      : #D8D8D8 ;
        position        : absolute; */
        width: 100%;
        height: 100%;
        border-radius: 0px;
        top: 0%;
        left: 0%;
        background: #f6f6f6;
        position: absolute;
    }

    .xCNBackgroundwhite {
        background: #FFF !important;
    }

    .wCNOuterPDT:hover {
        border-color: #0081c2;
    }

    .wCNOuterPDT:hover .wCNInnerPDT {
        background: #0081c2;
        cursor: pointer;
    }

    .wCNFontInsertPDTFloorMore1 {
        display: block;
        margin: 18% 20%;
        text-align: center;
        font-size: 1.5rem !important;
    }

    .wCNFontInsertPDTFloorMore10 {
        display: block;
        margin: 30% 35%;
        text-align: center;
    }

    .wCNFontInsertPDTFloorMore20 {
        display: block;
        margin: 0% 35%;
        text-align: center;
    }

    .wCNFontInsertPDTFloorMore30 {
        display: block;
        margin: 0% 35%;
        text-align: center;
    }

    .wCNOuterPDT:hover .wCNFontInsertPDTFloorMore1,
    .wCNOuterPDT:hover .wCNFontInsertPDTFloorMore10,
    .wCNOuterPDT:hover .wCNFontInsertPDTFloorMore20,
    .wCNOuterPDT:hover .wCNFontInsertPDTFloorMore30 {
        color: #FFF;
    }

    .xCNBtnDelete {
        background-color: #f36767;
        border-radius: 50px;
        width: 20px;
        height: 20px;
        position: absolute;
        z-index: 99;
        right: -10px;
        top: -10px;
        display: none;
        color: #FFF;
        border: 1px solid #f17575;
        box-shadow: 2px 2px 3px 0px rgb(173, 173, 173);
    }

    .xCNBtnDeleteShow {
        display: block;
        cursor: pointer;
    }

    .xCNFontBtnDelete {
        text-align: center;
        display: block;
        font-size: 0.8rem !important;
        font-weight: bold;
    }

    .xCNFontHeadPanel {
        font-weight: bold;
    }

    .xCNBTNSave {
        float: right;
        width: 15%;
        max-width: 135px;
        margin-left: 15px;
        margin-bottom: 10px;
    }

    .xCNBTNCancel {
        float: right;
        background-color: #D4D4D4;
        width: 15%;
        max-width: 135px;
        margin-left: 15px;
        margin-bottom: 10px;
    }

    .xCNBTNCancel:hover {
        background-color: #cdcccc;
    }

    .xCNBTNSetting {
        float: right;
        width: 35%;
        max-width: 135px;
        margin-left: 5px;
        margin-bottom: 10px;
    }

    .xCNDescription {
        display: none;
        position: absolute;
        border: 1px solid #FFF;
        z-index: 99;
        color: #FFF;
        background: #0081c2;
        top: 50px;
        right: -50px;
        font-size: 14px !important;
        width: auto;
        height: auto;
        padding: 5px;
    }

    .xCNTextDetailCabinet {
        text-align: right;
        display: block;
    }

    .xCNLayout {
        margin: 0px 20px;
        font-weight: bold;
    }

    .xCNLine {
        margin: 0px;
        margin-bottom: 10px;
    }

    .xCNBTNImportDiagram{
        width : 100%;
    }

    .xCNBTNExportDiagram{
        width : 100%;
    }

</style>

<div class="row" id="odvContentListDiagram">

    <div class="col-xs-12 col-md-3 col-lg-3" id="odvDetailShopLayout">

        <!--ร้านค้า-->
        <div class="row">
            <div class="col-xs-12 col-md-12 col-lg-12">
                <div style="padding: 20px; border:1px solid #eaeaea;">
                    <label class="xCNFontHeadPanel"> <?= language('vending/vendingshoplayout/vendingmanage', 'tShopLayout') ?> </label><br>
                    <span id="ospShopLayoutName"></span>
                </div>
            </div>
        </div>

        <!--Cabinet-->
        <div class="row" style="margin-top:15px; margin-bottom:15px;">
            <div class="col-xs-12 col-md-12 col-lg-12" id="odvContentListDiagramDetail">
                <div style="padding: 20px; border:1px solid #eaeaea;">
                    <label class="xCNFontHeadPanel"> <?= language('vending/cabinet/cabinet', 'tTiTleCabinetHead'); ?> </label>

                    <!--ปุ่มตั้งค่า-->
                    <div class="row" id="odvContentProductBTN" style="margin-left: 0px; margin-right: 0px; float: right;">
                        <button type="button" class="" onclick="JSxSettingVendingLayout('EDIT')" style="margin-bottom: 5px;">
                            <img class="xCNIconTable xWIconTable" src="<?= base_url() . '/application/modules/common/assets/images/icons/Settings.png' ?>" style="width: 20px; margin-top: -3px;">
                            <span class="xCNFontHeadPanel"> <?= language('vending/vendingshoplayout/vendingmanage', 'tSetting') ?> </span>
                        </button>
                    </div>

                    <div class="form-group">
                        <select class="selectpicker form-control" id="osmSelectCabinet">
                            <option selected disabled value="null"><?= language('vending/cabinet/cabinet', 'tvalidateCabinet') ?></option>
                            <?php if(isset($aCabinet['raItems'])){ ?>
                                <?php for ($i = 0; $i < FCNnHSizeOf($aCabinet['raItems']); $i++) { ?>
                                    <?php $tCabinetSeq = intval($aCabinet['raItems'][$i]['FNCabSeq']) + 1; ?>
                                    <option class="xCNOptionCabinet" value="<?= $aCabinet['raItems'][$i]['FNCabSeq'] ?>" data-row="<?= $aCabinet['raItems'][$i]['FNCabMaxRow'] ?>" data-col="<?= $aCabinet['raItems'][$i]['FNCabMaxCol'] ?>" data-shoptype="<?= $aCabinet['raItems'][$i]['FTShtType'] ?>" data-cabinet="<?= $aCabinet['raItems'][$i]['FNCabType'] ?>" data-cabinetname="<?= $aCabinet['raItems'][$i]['FTCabName'] ?>" data-cabinetreason="<?= $aCabinet['raItems'][$i]['FTCabRmk'] ?>"><?= $aCabinet['raItems'][$i]['FTCabName'] . ' กลุ่มช่องที่ : ' . $tCabinetSeq; ?></option>
                                <?php } ?>
                            <?php } ?>
                        </select>
                    </div>
                    <input type='hidden' id="ohdCabinetValue" value="">
                    <input type='hidden' id="ohdCabinetNameHidden" value="">
                    <input type='hidden' id="ohdCabinetReasonHidden" value="">

                    <label class="xCNFontHeadPanel"> <?= language('vending/cabinet/cabinet', 'tTiTleDetailCabinet'); ?> </label>
                    <div class="row">
                        <div class="col-lg-4 col-sm-12 col-xs-12"><span> <?= language('vending/vendingshoplayout/vendingmanage', 'tCabinetType') ?></span></div>
                        <div class="col-lg-8 col-sm-12 col-xs-12 xCNTextDetailCabinet"><span id="ospDetailCabinetType"> - </span></div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4 col-sm-12 col-xs-12"><span> <?= language('vending/cabinet/cabinet', 'tTableCabinetTypeShop') ?></span></div>
                        <div class="col-lg-8 col-sm-12 col-xs-12 xCNTextDetailCabinet"><span id="ospDetailCabinetVDType"> - </span></div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4 col-sm-12 col-xs-12"><span> <?= language('vending/vendingshoplayout/vendingmanage', 'tCountRowShopLayout') ?></span></div>
                        <div class="col-lg-8 col-sm-12 col-xs-12 xCNTextDetailCabinet"><span id="ospDetailCabinetRow"> 0 </span><span> <?= language('vending/vendingshoplayout/vendingmanage', 'tRowShopLayout') ?></span></div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4 col-sm-12 col-xs-12"><span> <?= language('vending/vendingshoplayout/vendingmanage', 'tCountColShopLayout') ?></span></div>
                        <div class="col-lg-8 col-sm-12 col-xs-12 xCNTextDetailCabinet"><span id="ospDetailCabinetColumn"> 0 </span><span> <?= language('vending/vendingshoplayout/vendingmanage', 'tColShopLayout') ?></span></div>
                    </div>
                    <input type='hidden' id="ohdShopName" value="<?= @$aHD['raItems'][0]['rtShpName'] ?>">
                    <input type='hidden' id="ohdShopHD" value="<?= @$aHD['raItems'][0]['rtVslShp'] ?>">
                    <input type='hidden' id="ohdStatusHD" value="<?= @$aHD['raItems'][0]['rtVslStaUse'] ?>">
                </div>
            </div>
        </div>

        <!--นำเข้า / ส่งออก-->
        <div class="row" style="margin-top:15px; margin-bottom:15px;">
            <div class="col-xs-6 col-md-6 col-lg-6">
                <button type="button" class="btn btn-primary xCNBTNImportDiagram" onclick="JSxImportDiagram()"> <?= language('common/main/main', 'tImport') ?></button>
            </div>
            <div class="col-xs-6 col-md-6 col-lg-6">
                <button type="button" class="btn btn-primary xCNBTNExportDiagram" onclick="JSxExportDiagram()"> <?= language('common/main/main', 'tExport') ?></button>
                <a id="ohdDowloadFile" href="<?=base_url();?>application\modules\vending\views\vendinglayout\wExportFile.php?ptFile="></a>
            </div>
        </div>
    </div>

    <div class="col-xs-12 col-md-9 col-lg-9" id="odvContentProductBorder" style="border : 1px solid #eaeaea;">
        <!--ปุ่มตั้งค่า ปุ่มบันทึก-->
        <div class="row" id="odvContentProductBTN" style="margin-top: 15px; margin-right: 0px;">
            <span class="xCNLayout"><?= language('vending/vendingshoplayout/vendingmanage', 'tVendingLayout') ?></span>
            <button type="button" id="obtSaveShopLayout" class="btn btn-primary xCNBTNSave" onclick="JSxSaveDiagram()"> <?= language('vending/vendingshoplayout/vendingmanage', 'tSave') ?></button>
            <button type="button" id="obtCancelShopLayout" class="btn xCNBTNCancel" onclick="JSxCancelDiagram()"> <?= language('vending/vendingshoplayout/vendingmanage', 'tCancel') ?></button>
            <button type="button" id="obtPrintShopLayout" class="btn xCNBTNCancel" onclick="JSxPrintDiagram()"> <?= language('common/main/main', 'tCMNPrint') ?></button>
        </div>

        <div>
            <hr class="xCNLine">
        </div>

        <!--โชว์สินค้า-->
        <div id="odvContentProduct">
            <?php include "wEmptyDiagram.php"; ?>
        </div>
    </div>
</div>

<!--Modal แสดงรายละเอียดสินค้า-->
<div class="modal fade" id="odvModalVendingPDT">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header xCNModalHead">
                <label class="xCNTextModalHeard"><?= language('vending/vendingshoplayout/vendingmanage', 'tVendingPDT') ?></label>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="xWClassShowImgColor"></div>
                        <!-- <img id="oimPDTImage" style="max-width: 140px !important; min-height: 140px !important; margin: 0px auto; display: block;" src="<?= base_url() . '/application/modules/common/assets/images/imageItemVending.png' ?>"> -->
                        <button type="button" class="btn xCNBtnBrowseAddOn" onclick="JSxSelectPDTintoDiagram('','','EDIT')" style="margin: 10px auto; display: block; width: 50%; background-color:#179BFD !important; color: #FFF !important; font-size: 17px;">
                            <p id="ospTextInsertandChange" style="color:#FFF;"><?= language('vending/vendingshoplayout/vendingmanage', 'tChangeLayout') ?></p>
                        </button>
                    </div>
                    <div class="col-lg-6">
                        <span id="ospDetailRowandCol" style="font-weight: bold;"><?= language('vending/vendingshoplayout/vendingmanage', 'tRowISLayout') ?></span><br>
                        <span id="ospDetailPDTName" style="font-size: 22px !important;"> <?= language('vending/vendingshoplayout/vendingmanage', 'tNamePDFLayout') ?> </span><br>
                        <span id="ospDetailPDTDescription" style="font-size: 18px !important;"> <?= language('vending/vendingshoplayout/vendingmanage', 'tDetailPDFLayout') ?> </span><br>

                        <div class="row xCNHide">
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

                        <!--เลือกประเภทคลัง-->
                        <div class="form-group">
                            <label><?=language('vending/vendingshoplayout/vendingmanage', 'tWahhouse')?> <span class="text-danger"><?=language('vending/vendingshoplayout/vendingmanage', 'tWahhouseDT')?></span></label>
                            <div class="validate-input">
                                <?php if ($aGetWahhouse['rtCode'] == 800) { ?>
                                    <span style="color:red;"> * <?= language('vending/vendingshoplayout/vendingmanage', 'tWahhouseNotFound') ?> <span>
                                        <?php } else { ?>
                                            <select class="selectpicker form-control" id="osmSelectWahHouse">
                                                <?php for ($i = 0; $i < FCNnHSizeOf($aGetWahhouse['raItems']); $i++) { ?>
                                                    <?php
                                                    if ($aGetWahhouse['raItems'][$i]['WAHMain'] == $aGetWahhouse['raItems'][$i]['FTWahCode']) {
                                                        $tSelectWahDefault = 'selected';
                                                    } else {
                                                        $tSelectWahDefault = '';
                                                    }
                                                    ?>
                                                    <option <?= $tSelectWahDefault ?> value="<?= $aGetWahhouse['raItems'][$i]['FTWahCode'] ?>"><?= $aGetWahhouse['raItems'][$i]['FTWahName'] ?></option>
                                                <?php } ?>
                                            </select>
                                        <?php } ?>
                            </div>
                            <?php
                            if ($aGetWahhouse['rtCode'] == 800) {
                                $nWahCodedefault = 0;
                            } else {
                                $nWahCodedefault = $aGetWahhouse['raItems'][0]['WAHMain'];
                            }
                            ?>
                            <!-- <input type="hidden" id="ohdHiddenWahCodedefault" value="<?= $nWahCodedefault ?>"> -->
                        </div>

                        <!--สถานะหมุนเกลียว-->
                        <div class="form-group">
                            <div class="validate-input">
                                <label class="fancy-checkbox">
                                    <input type="checkbox" id="ocbStatusControlXY" name="ocbStatusControlXY" checked="true" value="1">
                                    <span> <?= language('vending/vendingshoplayout/vendingmanage', 'tControlXY'); ?></span>
                                </label>
                            </div>
                        </div>

                        <!--ข้อความว่าใช้ช้องเกิน-->
                        <div id="odvWarningColumnLimit" style="float:right; display:none"><span style="color: red;">* </span><span style="color: red;"><?= language('vending/vendingshoplayout/vendingmanage', 'tVendingMaximum'); ?></span></div>

                        <!--รหัสสินค้า-->
                        <input type="hidden" id="ohdBCHCode" name="ohdBCHCode" value="">
                        <input type="hidden" id="ohdFTLayColQtyMax" name="ohdFTLayColQtyMax" value="">
                        <input type="hidden" id="ohdPdtCode" name="ohdPdtCode">
                        <input type="hidden" id="ohdPdtBarcode" name="ohdPdtBarcode">
                        <input type="hidden" id="ohdPdtImage" name="ohdPdtImage">
                        <input type="hidden" id="ohdPdtRow" name="ohdPdtRow">
                        <input type="hidden" id="ohdPdtWidth" name="ohdPdtWidth">

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button id="osmConfirm" type="button" class="btn xCNBTNPrimery" onClick="JSxVendingConfirmPDT()">
                    <?php echo language('common/main/main', 'tModalConfirm'); ?>
                </button>
                <button type="button" class="btn xCNBTNDefult" data-dismiss="modal">
                    <?php echo language('common/main/main', 'tModalCancel'); ?>
                </button>
            </div>
        </div>
    </div>
</div>


<!--Modal นำเข้า Diagram-->
<div class="modal fade" id="odvModalVendingImport" data-toggle="modal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" style="overflow: hidden auto; z-index: 7000; display: none;">
    <div class="modal-dialog" role="document" style="width: 900px; margin: 1.75rem auto;top:5%;">
        <div class="modal-content">
            <div class="modal-header xCNModalHead">
                <div class="row">
                    <div class="col-xs-12 col-md-6">
                        <label class="xCNTextModalHeard" style="font-weight: bold; font-size: 20px;">นำเข้าข้อมูล</label>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <div id="odvContentVendingFileImport">
                    <div class="form-group">
                        <div class="input-group">
                            <input type="text" class="form-control" id="oetFileNameVendingImport" name="oetFileNameVendingImport" placeholder="เลือกไฟล์" readonly="">
                            <input type="file" class="form-control" style="visibility: hidden; position: absolute;" id="oefFileVendingImport" name="oefFileVendingImport" onchange="JSxCheckFileVendingImport(this, event)" 
                            accept=".json">
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-primary" style="border-radius: 0px 5px 5px 0px;" onclick="$('#oefFileVendingImport').click()">
                                    เลือกไฟล์                                                            
                                </button>
                                <button class="btn xCNBTNPrimery xCNBTNPrimery2Btn" style="border-radius: 0px !important; margin-left: 30px; width: 100px;" onclick="JSxConfrimFileVendingImport()"><?php echo language('common/main/main', 'ตกลง') ?></button>  
                            </span>
                        </div>
                    </div>
                </div>
                <div id="odvContentVendingRenderHTMLImport"></div>
            </div>
            <div class="modal-footer">
                <div class="row">
                    <div class="col-lg-6">
                        <span id="ospTextSummaryImport" style="text-align: left; display: block; font-weight: bold;"></span>
                    </div>
                    <div class="col-lg-6">
                        <button class="btn xCNBTNPrimery xCNBTNPrimery2Btn" id="obtIMPVendingUpdateAgain" style="display:none;"><?= language('common/main/main', 'เลือกไฟล์ใหม่') ?></button>
                        <button class="btn xCNBTNPrimery xCNBTNPrimery2Btn" id="obtIMPVendingConfirm" onclick="JSxImportDiagramToDatabase();" data-dismiss="modal" style="display:none;"><?= language('common/main/main', 'ยืนยันการนำเข้า') ?></button>
                        <button class="btn xCNBTNDefult xCNBTNDefult2Btn" id="obtIMPVendingCancel" data-dismiss="modal"><?= language('common/main/main', 'ยกเลิก') ?></button> 
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Import Fail -->
<div class="modal fade" id="odvVendingImportFail">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header xCNModalHead">
				<label class="xCNTextModalHeard"><?=language('document/document/document', 'รูปแบบไม่สมบูรณ์') ?></label>
			</div>
			<div class="modal-body">
				<p>รูปแบบตู้ มีสินค้าที่นำเข้าไม่สมบูรณ์ กรุณาลบหรือเลือกสินค้าใหม่ก่อนกดบันทึก</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn xCNBTNPrimery"  data-dismiss="modal">
					<?=language('common/main/main', 'tModalConfirm'); ?>
				</button>
			</div>
		</div>
	</div>
</div>

<!--สินค้ามี STKBal > 0 -->
<div class="modal fade" id="odvVendingProductSTKBal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header xCNModalHead">
				<label class="xCNTextModalHeard"><?=language('document/document/document', 'tDocStawarning') ?></label>
			</div>
			<div class="modal-body">
				<p id="ospVendingProductSTKBalText"></p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn xCNBTNPrimery"  data-dismiss="modal">
					<?=language('common/main/main', 'tModalConfirm'); ?>
				</button>
			</div>
		</div>
	</div>
</div>

<!--มีเอกสาร ใบตรวจนับ + ใบเติมสินค้า + ใบนำสินค้าออกที่ยังไม่ได้อนุมัติ-->
<div class="modal fade" id="odvVendingDocumentWhenNotApv">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header xCNModalHead">
				<label class="xCNTextModalHeard"><?=language('document/document/document', 'tDocStawarning') ?></label>
			</div>
			<div class="modal-body">
				<p id="ospVendingDocumentWhenNotApv"></p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn xCNBTNPrimery"  data-dismiss="modal">
					<?=language('common/main/main', 'tModalConfirm'); ?>
				</button>
			</div>
		</div>
	</div>
</div>


<script>
    var tName = $('#oetShpName').val();
    $('#ospShopLayoutName').text(tName);
    $('.selectpicker').selectpicker();

    $('#obtSaveShopLayout').attr('disabled', true);
    $('#obtCancelShopLayout').attr('disabled', true);
    $('#obtPrintShopLayout').attr('disabled', true);
    

    //เลือก cabinet 
    $('#osmSelectCabinet').change(function() {
        nValue = $(this).val();
        nRow = $(this).children('option:selected').data('row');
        nCol = $(this).children('option:selected').data('col');
        nShoptype = $(this).children('option:selected').data('shoptype');
        nCabinet = $(this).children('option:selected').data('cabinet');
        tCabinetName = $(this).children('option:selected').data('cabinetname');
        tCabinetReason = $(this).children('option:selected').data('cabinetreason');

        if (nShoptype == 1) {
            nShoptype = '<?= language('vending/vendingshoptype/vendingshoptype', 'tVstTypeVending01') ?>';
        } else if (nShoptype == 2) {
            nShoptype = '<?= language('vending/vendingshoptype/vendingshoptype', 'tVstTypeVending02') ?>';
        } else {
            nShoptype = '<?= language('vending/vendingshoptype/vendingshoptype', 'tVstTypeVending03') ?>';
        }

        if (nCabinet == 1) {
            nCabinet = '<?= language('vending/cabinet/cabinet', 'tSelectCabinetTypeVending') ?>';
        } else {
            nCabinet = '<?= language('vending/cabinet/cabinet', 'tSelectCabinetTypeLocker') ?>';
        }

        $('#ohdCabinetValue').val(nValue);
        $('#ospDetailCabinetType').text(nCabinet);
        $('#ospDetailCabinetVDType').text(nShoptype);
        $('#ospDetailCabinetRow').text(nRow);
        $('#ospDetailCabinetColumn').text(nCol);
        $('#ohdCabinetNameHidden').val(tCabinetName);
        $('#ohdCabinetReasonHidden').val(tCabinetReason);
        $('#ohdFTLayColQtyMax').val(nCol);
        $('#odvContentProduct').html('');

        JSxDrawDiagram();

        $('#obtSaveShopLayout').attr('disabled', false);
        $('#obtCancelShopLayout').attr('disabled', false);
        $('#obtPrintShopLayout').attr('disabled', false);

    });

    //################################################################################################################ P R O C E S S - D R A W - DIAGRAM

    var nWidthColumndefault;
    var nHeightColumndefault;
    var nSelectFloor = 0;
    var nSelectColumn = 0;
    var nHeightDiagram = 600;
    var nColumnDiagram = 0;
    var nFloorDiagram = 0;

    function JSxDrawDiagram() {
        $.ajax({
            type: "POST",
            url: "VendingGetDTShopLayout",
            cache: false,
            data: {
                tBchCode: $('#ohdBchCode').val(),
                tShopCode: $('#ohdShpCode').val(),
                nSeqCabinet: $('#ohdCabinetValue').val()
            },
            timeout: 0,
            success: function(tResult) {
                var oResult = JSON.parse(tResult);
                JSxInsert_DrawDiagram();
                if (oResult.aDT.rtCode == 800) {
                    //ไม่เคยเพิ่มข้อมูลมาก่อน
                } else {
                    //มีข้อมูลเเล้ววิ่งเข้า EDIT
                    JSxEdit_DrawDiagram(oResult);
                }
            },
            error: function(data) {
                console.log(data);
            }
        });
    }

    //ไม่เคยเพิ่มข้อมูลมาก่อน
    function JSxInsert_DrawDiagram() {
        nColumnDiagram = $('#ospDetailCabinetColumn').text();
        nFloorDiagram = $('#ospDetailCabinetRow').text();
        JSxCreateDiagram_Floor();
        JSxCreateDiagram_Column();
        JSxColumnDeleteHover();
        JSxCheckColumnLimit();
    }

    //ห้ามใส่จำนวนช่องเกิน
    function JSxCheckColumnLimit() {
        $('#oetPdtWidth').keyup(function() {
            var nUseColumn = parseInt($(this).val());
            if (nUseColumn > parseInt($('#ohdFTLayColQtyMax').val())) {
                $('#odvWarningColumnLimit').css('display', 'block');
            } else {
                $('#odvWarningColumnLimit').css('display', 'none');
            }
        });
    }

    //สร้างจำนวนชั้น
    function JSxCreateDiagram_Floor() {
        //กำหนดสัดส่วนความสูง จากจำนวนชั้น สาเหตุมาเพราะความสูงของ diagram สูงสุดที่ 600px
        if (nFloorDiagram >= 8) {
            //ถ้าจำนวนชั้นมากกว่า 8 จะต้องใช้ความสูงแบบสัดส่วน 
            var nCalculatePanelHeight = nHeightDiagram / nFloorDiagram;
            var nPanelHeight = Math.floor(nCalculatePanelHeight) + 'px';
            var nPanelHeight = '75px';
        } else {
            //ถ้าจำนวนชั้น น้อยกว่า 8 จะใช้ความสูงที่ 75px (8*75);
            var nPanelHeight = '75px';
        }

        //วนลูปสร้างจำนวนชั้น
        for (f = 1; f <= nFloorDiagram; f++) {
            var oFloor = "<div id='odvFloor" + f + "' style='width:100%; height:" + nPanelHeight + ";'></div>";
            oFloor += "<div class='xCNLineFloor'></div>"
            $('#odvContentProduct').append(oFloor);
        }
    }

    //สร้างความกว้าง
    function JSxCreateDiagram_Column() {
        var tWidthColumnAll = 0;
        for (w = 1; w <= nColumnDiagram; w++) {
            tWidthColumnAll += 78.25
        }
        var tWidthAll = $('#odvContentProduct').width();
        if (tWidthColumnAll > 550) {
            $('#odvContentProduct').css('max-width', tWidthColumnAll + 'px');
            $('#odvContentProductBTN').css('max-width', tWidthColumnAll + 'px');
        } else {
            //ใช้ความกว้าง auto
            $('#odvContentProduct').css('max-width', '550px');
            $('#odvContentProductBTN').css('max-width', '550px');
        }

        for (f = 1; f <= nFloorDiagram; f++) {
            var tIDFloor = 'odvFloor' + f;
            //หาว่าความกว้างของแต่ละชั้นเท่าไหร่ 
            var nWidthFloor = $('#' + tIDFloor).width();
            var nHeightFloor = $('#' + tIDFloor).height();

            //เอาความกว้างของชั้นมาหาสัดส่วน เพื่อให้แต่ละช่องเท่ากัน ต้องลบ 8 เพราะ marginข้างละ 4 
            if (tWidthColumnAll > tWidthAll) {
                //ต้องหาสัดส่วน
                var nWidthColumn = nWidthFloor / nColumnDiagram;
                var nWidthColumnOuter = Math.floor(nWidthColumn) - 8 + 'px';
                nWidthColumndefault = nWidthColumnOuter;
            } else {
                var nWidthColumnOuter = '70px';
                nWidthColumndefault = nWidthColumnOuter;
            }

            //เอาความสูงของชั้นมาหาสัดส่วน เพื่อให้แต่ละช่องสูงเท่ากัน 
            // var nHeightColumnOuter      = Math.floor(nHeightFloor) - 8 + 'px';
            var nHeightColumnOuter = '70px';
            nHeightColumndefault = nHeightColumnOuter;

            //กำหนดขนาดของ font
            var tFontInsert = 'wCNFontInsertPDTFloorMore1';


            for (c = 1; c <= nColumnDiagram; c++) {
                var tIDColumn = "odvFloor" + f + "Column" + c;
                var oEventInsertPDT = "JSxSelectPDTintoDiagram(" + f + "," + c + ",'INSERT')";
                var oEventDeletePDT = "JSxDeletePDTintoDiagram(" + f + "," + c + ")";
                var oColumn = "<div id='" + tIDColumn + "' data-UseThisColumn='false' class='wCNOuterPDT' style='width:" + nWidthColumnOuter + "; height:" + nHeightColumnOuter + ";'>";
                oColumn += "<div class='xCNBtnDelete' onclick=" + oEventDeletePDT + "><span class='xCNFontBtnDelete'> X </span></div>";
                oColumn += "<div class='wCNInnerPDT' onclick=" + oEventInsertPDT + "><span class='" + tFontInsert + "'>+<span></div>";
                oColumn += "<div class='xCNDescription'>ชั้นที่ : " + f + ' ช่องที่ : ' + c + "</div>";
                oColumn += "</div>";
                $('#' + tIDFloor).append(oColumn);
            }
        }
    }

    //เลือกสินค้า ลง Diagram
    function JSxSelectPDTintoDiagram(pnFloor, pnColumn, ptType) {

        //ถ้าเป็นค่าว่างจากการกดเข้ามาแบบเปลี่ยนสินค้า
        if (pnFloor == '') {
            pnFloor = nSelectFloor
        }
        if (pnColumn == '') {
            pnColumn = nSelectColumn
        }

        //มีค่าส่งมาจากการกดเลือกครั้งล่าสุด
        nSelectFloor = pnFloor;
        nSelectColumn = pnColumn;

        if (ptType == 'EDIT') {

            //ถ้า STK Bal > 0 ลบไม่ได้
            var aDetailData = $('#odvFloor' + nSelectFloor + 'Column' + nSelectColumn).attr('data-info');
            var aDetailData = JSON.parse(aDetailData);
            if(aDetailData.nSTKBal != 0){
                var tTextPDTName = aDetailData.tPDTName;
                $('#odvVendingProductSTKBal').modal('show');
                $('#ospVendingProductSTKBalText').html(tTextPDTName + ' มีในช่องอยู่ ' + "<strong>" + aDetailData.nSTKBal + "</strong>" + ' ชิ้น กรุณาทำเอกสารใบนำสินค้าออก (ตู้สินค้า) ก่อนทำการลบ');
                return;
            }

            //เปลี่ยนสินค้า
            $('#odvModalVendingPDT').modal('hide');

            //อนุญาติให้เลือกสินค้าได้อีกครัง
            var bModalShowPDT = true;
        } else {
            //กดที่ช่องสินค้า
            var oElm = $('#odvFloor' + nSelectFloor + 'Column' + nSelectColumn).attr('data-UseThisColumn').toString();

            //เช็คก่อนว่ามี สินค้าหรือยัง
            if (oElm == 'true') {
                //เคยเลือกสินค้าแล้ว ต้องแสดงหน้ารายละเอียดสินค้า
                setTimeout(function() {
                    $('#odvModalVendingPDT').modal('show');
                }, 700);
                var oPackData = $('#odvFloor' + nSelectFloor + 'Column' + nSelectColumn).attr('data-info');
                var oPackData = JSON.parse(oPackData);

                //console.log(oPackData);
                var tRowISLayout = '<?= language('vending/vendingshoplayout/vendingmanage', 'tRowISLayout') ?>';
                var tColISLayout = '<?= language('vending/vendingshoplayout/vendingmanage', 'tColISLayout') ?>';
                $('#ospDetailRowandCol').text(tRowISLayout + nSelectFloor + tColISLayout + nSelectColumn);
                $('#ospDetailPDTName').text(oPackData.tPDTName);
                $('#ospDetailPDTDescription').text(oPackData.tPDTDetail);
                // $('#oimPDTImage').attr('src', oPackData.tImage);
                $('#ohdPdtBarcode').val(oPackData.tPDTBarCode);
                $('#ohdPdtCode').val(oPackData.nPDTCode);
                $('#ohdPdtImage').val(oPackData.tImage);
                $('#oetPdtTemp').val(oPackData.nTempVD);
                $('#oetPdtTime').val(oPackData.nTimeVD);
                $('#oetPdtWidth').val(oPackData.nUseColumn);
                $('#oetPdtDim').val(oPackData.nDim);

                var tImg        = oPackData.tImage.substr(0, 1);
                var tPathImg    = oPackData.tImage;
                if (tImg != '#') {
                    tHTML = '<img style="max-width: 140px !important; min-height: 140px !important; margin: 0px auto; display: block;" src=' + tPathImg + '>';
                } else {
                    tHTML = '<span style=" background-color:' + tPathImg + ' !important; max-width: 140px !important; min-height: 140px !important; margin: 0px auto; display: block;"  />';
                }
                $('#odvModalVendingPDT').find('.xWClassShowImgColor').html(tHTML);



                if (oPackData.tStatusSpring == 1) {
                    $('#ocbStatusControlXY').prop('checked', true);
                } else {
                    $('#ocbStatusControlXY').prop('checked', false);
                }

                $('#osmSelectWahHouse option[value="' + oPackData.nWahCode + '"]').prop('selected', true);
                $('.selectpicker').selectpicker('refresh');

                //ไม่อนุญาติให้เลือกสินค้า แค่โชว์รายละเอียด
                var bModalShowPDT = false;
            } else {
                //ถ้ายังไม่มีให้เพิ่มสินค้า
                if (ptType == 'INSERT') {
                    JSxResetPanelProduct();

                    //อนุญาติให้เลือกสินค้าได้อีกครัง
                    var bModalShowPDT = true;
                }
            }
        }

      
        if (bModalShowPDT == true) {
            var dTime = new Date();
            var dTimelocalStorage = dTime.getTime();
            aMulti = [];
            $.ajax({
                type: "POST",
                url: "BrowseDataPDT",
                data: {
                    'Qualitysearch': [],
                    'PriceType': ['Pricesell'],
                    // 'SelectTier'      : ['PDT'],
                    'ShowCountRecord': 10,
                    'NextFunc': 'JSxSetPDTInModal',
                    'ReturnType': 'S',
                    'SPL': ['', ''],
                    'BCH': [$('#ohdBchCode').val(), $('#ohdBchCode').val()],
                    'SHP': ['', ''],
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
    }

    //โชว์หน้าต่างแสดงรายละเอียดสินค้า
    function JSxSetPDTInModal(elem) {
        $('#ocbStatusControlXY').prop('checked', true);
        //ซ่อน Text warning ก่อน
        $('#odvWarningColumnLimit').css('display', 'none');

        setTimeout(function() {
            $('#odvModalVendingPDT').modal('show');
        }, 700);
        var aData = JSON.parse(elem);

        var tPDTCode = aData[0].packData.PDTCode;
        var tPDTName = aData[0].packData.PDTName;
        var tPDTDetail = aData[0].packData.Remark;
        var tPDTImage = aData[0].packData.IMAGE;
        var tCookTime = aData[0].packData.CookTime;
        var tCookHeat = aData[0].packData.CookHeat;
        var tBarcode = aData[0].packData.Barcode;

        if (tPDTImage == '' || tPDTImage == null) {
            var tImg = '';
        }else{
            var tImg = tPDTImage.substr(0, 1);
        }

        if (tPDTImage == '' || tPDTImage == null) {
            var tPathImage = '<?= base_url() ?>' + 'application/modules/common/assets/images/imageItemVending.png';
        } else if (tImg == '#') {
            var tPathImage = tPDTImage;
        } else {
            // var aImgObj = tPDTImage.split("application");
            // var tFullPatch = './application' + aImgObj[1];
            // var tPathImage = '<?= base_url() ?>' + 'application' + aImgObj[1];
            var tPathImage = tPDTImage;
        }
        
        var tRowISLayout = '<?= language('vending/vendingshoplayout/vendingmanage', 'tRowISLayout') ?>';
        var tColISLayout = '<?= language('vending/vendingshoplayout/vendingmanage', 'tColISLayout') ?>';

        $('#ospDetailRowandCol').text(tRowISLayout + nSelectFloor + tColISLayout + nSelectColumn);
        $('#ospDetailPDTName').text(tPDTName + ' รหัส : ' + tPDTCode);
        $('#ospDetailPDTDescription').text(tPDTDetail);

        if (tImg != '#') {
            tHTML = '<img style="max-width: 140px !important; min-height: 140px !important; margin: 0px auto; display: block;" src=' + tPathImage + '>';
        } else {
            tHTML = '<span style=" background-color:' + tPathImage + ' !important; max-width: 140px !important; min-height: 140px !important; margin: 0px auto; display: block;"  />';
        }
        $('#odvModalVendingPDT').find('.xWClassShowImgColor').html(tHTML);
        $('#ohdPdtImage').val(tPathImage);
        // $('#oimPDTImage').attr('src', tPathImage);

        $('#ohdPdtBarcode').val(tBarcode);
        $('#ohdPdtCode').val(tPDTCode);
        $('#ohdPdtImage').val(tPathImage);
        $('#oetPdtTemp').val(tCookHeat);
        $('#oetPdtTime').val(tCookTime);
    }

    //กดยืนยันเลือกสินค้า จากหน้าต่างแสดงรายละเอียดสินค้า
    function JSxVendingConfirmPDT() {
        if ($('#ohdHiddenWahCodedefault').val() == 0) {
            return;
        }

        var tPDTDim = $('#oetPdtDim').val();
        if ($('#ocbStatusControlXY').is(":checked")) {
            tStatusSpring = 1;
        } else {
            tStatusSpring = 0;
        }
        var tStatusSpring   = tStatusSpring;
        var tPDTTemp        = $('#oetPdtTemp').val();
        var tPDTTime        = $('#oetPdtTime').val();
        var tPDTWidth       = $('#oetPdtWidth').val();
        var tBarcode        = $('#ohdPdtBarcode').val();
        var tPDTCode        = $('#ohdPdtCode').val();
        var tPDTImage       = $('#ohdPdtImage').val();
        var tRow            = $('#ohdPdtRow').val();
        var tStartWidth     = $('#ohdPdtWidth').val();
        var tNamePDT        = $('#ospDetailPDTName').text();
        var tDetailPDT      = $('#ospDetailPDTDescription').text();
        var nWahCode        = $('#osmSelectWahHouse option:selected').val();
        
        if(tPDTImage == '' || tPDTImage == null){
            var tImg  = '';
        }else{
            var tImg  = tPDTImage.substr(0, 1);
        }

        //ต้องกำหนดว่าสินค้านี้ใช้ช่องเท่าไหร่
        if (tPDTWidth == '' || tPDTWidth == null) {
            $('#oetPdtWidth').focus();
        } else {
            //ถ้ารูปภาพเป็นค่าว่าง
            if (tPDTImage == '' || tPDTImage == null) {
                var tPDTImage   = '<?= base_url() ?>' + 'application/modules/common/assets/images/imageItemVending.png';
            // } else if (tImg == '#') {
            //     var tPDTImage   = tPDTImage;
            } else {
                // var aImgObj     = tPDTImage.split("application");
                // var tFullPatch  = './application' + aImgObj[1];
                // var tPDTImage   = '<?= base_url() ?>' + 'application' + aImgObj[1];
                var tPDTImage   = tPDTImage;
            }

            //ถ้าความลึกเป็นค่าว่าง
            if (tPDTDim == '' || tPDTDim == null) {
                tPDTDim = 1;
            }

            var oPackData = {
                'nColumn'       : nSelectColumn, //ช่องที่
                'nFloor'        : nSelectFloor, //ชั้นที่
                'nUseColumn'    : tPDTWidth, //ใช้กี่ช่อง
                'nDim'          : tPDTDim, //ความลึก
                'nTempVD'       : tPDTTemp, //อุณหภูมิในการอุ่น
                'nTimeVD'       : tPDTTime, //เวลาในการอุ่น
                'nPDTCode'      : tPDTCode, //รหัสสินค้า
                'tImage'        : tPDTImage, //รูปภาพ
                'tPDTName'      : tNamePDT, //ชื่อสินค้า
                'tPDTBarCode'   : tBarcode, //บาร์โค๊ดสินค้า
                'tPDTDetail'    : tDetailPDT, //รายละเอียดสินค้า
                'tStatusSpring' : tStatusSpring, //สถานะหมุนเกลียว
                'nWahCode'      : nWahCode, //รหัสคลังสินค้า
                'nSTKBal'       : 0 //จำนวนคงเหลือในคลัง
            };
            var tPackData = JSON.stringify(oPackData);

            //คือมีการใช้ช่องสินค้ามากกว่า 1 ช่อง จะต้องมีการ mergth
            if (tPDTWidth >= 1) {
                var bWaring = JSxMergeColumn(tPackData);
            }

            //ถ้าใส่ช่องไม่เกิน จะทำงานได้ปกติ
            if (bWaring == true) {
                if (tImg != '#') {
                    tHTML = '<img style=" position: absolute; max-height: 90%; max-width: 90%; top: 0; bottom: 0; left: 0; right: 0; margin: auto;" src=' + tPDTImage + '>';
                } else {
                    tHTML = '<span style=" background-color:' + tPDTImage + ' !important; position: absolute; max-height: 90%; max-width: 90%; top: 0; bottom: 0; left: 0; right: 0; margin: auto;"  />';

                }
                // tHTML = '<img style=" position: absolute; max-height: 90%; max-width: 90%; top: 0; bottom: 0; left: 0; right: 0; margin: auto;" src=' + tPDTImage + '>';
                $('#odvFloor' + nSelectFloor + 'Column' + nSelectColumn).find('.wCNInnerPDT').addClass('xCNBackgroundwhite');

                $('#odvFloor' + nSelectFloor + 'Column' + nSelectColumn).attr('data-info', tPackData);
                $('#odvFloor' + nSelectFloor + 'Column' + nSelectColumn).attr('data-UseThisColumn', true);
                $('#odvFloor' + nSelectFloor + 'Column' + nSelectColumn).children('.wCNInnerPDT').html(tHTML);
                $('#odvModalVendingPDT').modal('hide');
            }
        }

    }

    //รวมช่อง
    function JSxMergeColumn(oPackData) {
        var oPackData = JSON.parse(oPackData);
        nSelectFloor = nSelectFloor;
        nSelectColumn = nSelectColumn;
        var tNameShort = oPackData.tPDTName;
        var tNameShort = tNameShort.substring(0, 20) + '...';

        var nMerge = $('#odvFloor' + nSelectFloor + 'Column' + nSelectColumn).attr('data-Merge');
        if (nMerge == undefined) {
            nMerge = 0
        }

        //เช็คว่าใส่ช่องเกินหรือเปล่า
        if (parseInt(oPackData.nUseColumn) > parseInt($('#ohdFTLayColQtyMax').val())) {
            $('#odvWarningColumnLimit').css('display', 'block');
            return false;
        } else {

            //ใช้กี่ช่อง ต้องลบ 1 เสมอ เพราะจะไม่รวมช่องตัวเอง
            var nUseColumn = oPackData.nUseColumn - 1;

            //ใช้ชั้นที่เท่าไหร่
            nSelectFloor;

            //ใช้ช่องที่เท่าไหร่
            nSelectColumn;

            //เช็คว่าเหลือใช้ได้จริงๆ กี่ช่อง
            var nCanUseColumn = parseInt($('#ohdFTLayColQtyMax').val()) - (nSelectColumn + nUseColumn);
            // console.log('คุณกำลังเลือกช่องที่ : ' + nSelectColumn + ' กำลังใช้อยู่ : ' + oPackData.nUseColumn + ' เหลือให้ใช้ : ' + nCanUseColumn);
            if (nCanUseColumn < 0) {
                $('#odvWarningColumnLimit').css('display', 'block');
                return false;
            }

            //Loop แรกวิ่งเข้าไปเช็คก่อนว่า ช่องด้านขวามันมีการใช้งานหรือยัง ต้องวนลูปให้ครบ
            var nWidthColumnDel = 0;
            var tWidthColumndefault = nWidthColumndefault.split("px");
            var bHaveB4Merge = '';
            for (i = nSelectColumn + 1; i <= nSelectColumn + nUseColumn; i++) {
                //เช็คว่าช่องที่จะใช้ในการ merge มีการใช้งานเเล้วหรือยัง
                if (bHaveB4Merge == true) {
                    //ถ้าเจอ ช่องที่ถูกใช้งานแล้ว ให้ออกลูปเลย 
                } else {
                    var nHaveMerge = $("#odvFloor" + nSelectFloor + "Column" + i).attr('data-Merge');
                    if (nHaveMerge == undefined || nHaveMerge == 0) {
                        bHaveB4Merge = false;
                    } else {
                        //ช่องด้านขวาถูกใช้งาน
                        bHaveB4Merge = true;
                    }
                }
            }

            //ช่องด้านขวาของตัวมันเองมีการ Merge เพิ่มไม่ได้
            if (bHaveB4Merge == true) {
                $('#odvWarningColumnLimit').css('display', 'block');
                return false;
            }

            //Loop สองลบช่องที่อยู่ด้านขวาของตัวเอง ออกให้หมด
            var nWidthColumnDel = 0;
            var tWidthColumndefault = nWidthColumndefault.split("px");
            for (i = nSelectColumn + 1; i <= nSelectColumn + nUseColumn; i++) {
                //ต้อง + 8 คือ margin div ใน ซ้าย 4 ขวา 4
                nWidthColumnDel += parseInt(tWidthColumndefault[0]) + 8;
                $("#odvFloor" + nSelectFloor + "Column" + i).remove();
                // console.log(nWidthColumnDel);
            }

            //ต้อง + 4 เพราะมี margin
            var nHeightDiv = $('#odvFloor' + nSelectFloor + 'Column' + nSelectColumn).height() + 4;
            var nWidthDiv = nWidthColumnDel + parseInt(tWidthColumndefault[0]);
            // console.log(tWidthColumndefault[0]);
            $('#odvFloor' + nSelectFloor + 'Column' + nSelectColumn).attr("style", 'max-width : ' + nWidthDiv + 'px !important; width: ' + nWidthDiv + 'px; height:' + nHeightDiv + 'px;');
            $('#odvFloor' + nSelectFloor + 'Column' + nSelectColumn).attr('data-Merge', nUseColumn + 1);

            if (nUseColumn >= nMerge) {
                //console.log('เพิ่มช่อง');
                var tElementID = '#odvFloor' + nSelectFloor + 'Column' + nSelectColumn;
                var tNameDescription = "ชั้นที่ : " + nSelectFloor + ' ช่องที่ : ' + nSelectColumn + '<br>' + tNameShort;
                $(tElementID + ' > .xCNDescription').html(tNameDescription);
            } else {
                //เอาช่องก่อน ลบ ช่องใหม่ จะได้จำนวนที่ ต้องเพิ่มเติม
                var nCreateColumnFrom = nSelectColumn + (nUseColumn + 1);
                var nResultColumn = parseInt(nMerge) - parseInt(oPackData.nUseColumn);
                var nCreateColumnTo = parseInt(nCreateColumnFrom) + nResultColumn;
                //console.log('::::: ลดช่อง :::::');
                // console.log('เริ่มสร้างตั้งแต่ : ' + nCreateColumnFrom + ' ถึง : ' + nCreateColumnTo);

                //กำหนดขนาดของ font
                var tFontInsert = 'wCNFontInsertPDTFloorMore1';
                var tElementID = '#odvFloor' + nSelectFloor + 'Column' + nSelectColumn;
                for (k = nCreateColumnFrom; k < nCreateColumnTo; k++) {
                    var tIDColumn = "odvFloor" + nSelectFloor + "Column" + k;
                    var oEventInsertPDT = "JSxSelectPDTintoDiagram(" + nSelectFloor + "," + k + ",'INSERT')";
                    var oEventDeletePDT = "JSxDeletePDTintoDiagram(" + nSelectFloor + "," + k + ")";
                    var oColumn = "<div id='" + tIDColumn + "' data-UseThisColumn='false' class='wCNOuterPDT' style='width:" + nWidthColumndefault + "; height:" + nHeightColumndefault + ";'>";
                    oColumn += "<div class='xCNBtnDelete' onclick=" + oEventDeletePDT + "><span class='xCNFontBtnDelete'> X </span></div>";
                    oColumn += "<div class='wCNInnerPDT' onclick=" + oEventInsertPDT + "><span class='" + tFontInsert + "'>+<span></div>";
                    oColumn += "<div class='xCNDescription'>ชั้นที่ : " + nSelectFloor + ' ช่องที่ : ' + k + "</div>";
                    oColumn += "</div>";
                    $(tElementID).after(oColumn);
                    tElementID = '#odvFloor' + nSelectFloor + 'Column' + k;
                }
                JSxColumnDeleteHover();
            }

            return true;
        }


    }

    //ล้างค่า จากหน้าต่างแสดงรายละเอียดสินค้า
    function JSxResetPanelProduct() {
        var nWahCodeDefault = $('#ohdHiddenWahCodedefault').val();
        $('#osmSelectWahHouse option[value="' + nWahCodeDefault + '"]').prop('selected', true);

        $('#oetPdtDim').val('');
        $('#oetPdtTemp').val('');
        $('#oetPdtTime').val('');
        $('#oetPdtWidth').val('');
        $('#ohdPdtBarcode').val('');
        $('#ohdPdtCode').val('');
        $('#ohdPdtImage').val('');
        $('#ohdPdtRow').val('');
        $('#ospDetailPDTName').text('');
        $('#ospDetailPDTDescription').text('');

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

    //ถ้ามีสินค้าอยู่ในช่องแล้ว เอาเมาส์ไป hover จะขึ้นปุ่มลบ
    function JSxColumnDeleteHover() {
        $('.wCNOuterPDT').hover(
            function() {
                var oElm = $(this).attr('data-UseThisColumn').toString();
                if (oElm == 'true') {
                    $(this).children('.xCNBtnDelete').addClass('xCNBtnDeleteShow');
                }

                $(this).children('.xCNDescription').show();
            },
            function() {
                $(this).children('.xCNBtnDelete').removeClass('xCNBtnDeleteShow');
                $(this).children('.xCNDescription').hide();
            }
        );
    }

    //ลบสินค้าใน Diagram
    function JSxDeletePDTintoDiagram(pnFloor, pnColumn) {
        var nSelectFloor = pnFloor;
        var nSelectColumn = pnColumn;

        //กำหนดขนาดของ font
        if (nSelectFloor <= 7) {
            var tFontInsert = 'wCNFontInsertPDTFloorMore1';
        } else if (nSelectFloor > 7 && nSelectFloor <= 10) {
            var tFontInsert = 'wCNFontInsertPDTFloorMore1';
        } else if (nSelectFloor > 10 && nSelectFloor < 15) {
            var tFontInsert = 'wCNFontInsertPDTFloorMore1';
        } else {
            var tFontInsert = 'wCNFontInsertPDTFloorMore1';
        }

        //ถ้า STK Bal > 0 ลบไม่ได้
        var aDetailData = $('#odvFloor' + nSelectFloor + 'Column' + nSelectColumn).attr('data-info');
        var aDetailData = JSON.parse(aDetailData);
        if(aDetailData.nSTKBal != 0){
            var tTextPDTName = aDetailData.tPDTName;
            $('#odvVendingProductSTKBal').modal('show');
            $('#ospVendingProductSTKBalText').html(tTextPDTName + ' มีในช่องอยู่ ' + "<strong>" + aDetailData.nSTKBal + "</strong>" + ' ชิ้น กรุณาทำเอกสารใบนำสินค้าออก (ตู้สินค้า) ก่อนทำการลบ');
            return;
        }

        //ทำให้ช่องนี้กลับมาว่างอีกครั้ง
        $('#odvFloor' + nSelectFloor + 'Column' + nSelectColumn).attr('data-info', '');
        $('#odvFloor' + nSelectFloor + 'Column' + nSelectColumn).attr('data-UseThisColumn', false);

        var nMerge = $('#odvFloor' + nSelectFloor + 'Column' + nSelectColumn).attr('data-Merge');
        if (nMerge > 1) {
            //มีการ Merge ลบแบบวนลูปสร้างใหม่อีกครั้ง
            $('#odvFloor' + nSelectFloor + 'Column' + nSelectColumn).attr("style", 'width: ' + nWidthColumndefault + '; height:' + nHeightColumndefault + ';');
            $('#odvFloor' + nSelectFloor + 'Column' + nSelectColumn).attr('data-Merge', 0);

            var tElementID = '#odvFloor' + nSelectFloor + 'Column' + nSelectColumn;
            //ลูป จะเริ่มสร้างตัวถัดไป จน ถึง ตัวถัดไป + ช่องที่ถูก merge-1
            for (i = nSelectColumn + 1; i <= nSelectColumn + (nMerge - 1); i++) {
                var tIDColumn = "odvFloor" + nSelectFloor + "Column" + i;
                var oEventInsertPDT = "JSxSelectPDTintoDiagram(" + nSelectFloor + "," + i + ",'INSERT')";
                var oEventDeletePDT = "JSxDeletePDTintoDiagram(" + nSelectFloor + "," + i + ")";
                var oColumn = "<div id='" + tIDColumn + "' data-UseThisColumn='false' class='wCNOuterPDT' style='width:" + nWidthColumndefault + "; height:" + nHeightColumndefault + ";'>";
                oColumn += "<div class='xCNBtnDelete' onclick=" + oEventDeletePDT + "><span class='xCNFontBtnDelete'> X </span></div>";
                oColumn += "<div class='wCNInnerPDT' onclick=" + oEventInsertPDT + "><span class='" + tFontInsert + "'>+<span></div>";
                oColumn += "<div class='xCNDescription'>ชั้นที่ : " + nSelectFloor + ' ช่องที่ : ' + i + "</div>";
                oColumn += "</div>";
                $(tElementID).after(oColumn);
                tElementID = '#odvFloor' + nSelectFloor + 'Column' + i;
            }
        }

        //ไม่มีการ Merge ลบแบบปกติ
        tHTML = "<span class='" + tFontInsert + "'>+<span></div>";
        $('#odvFloor' + nSelectFloor + 'Column' + nSelectColumn).children('.wCNInnerPDT').html(tHTML);
        $('#odvFloor' + nSelectFloor + 'Column' + nSelectColumn).children('.xCNBtnDelete').removeClass('xCNBtnDeleteShow');
        $('#odvFloor' + nSelectFloor + 'Column' + nSelectColumn).find('.wCNInnerPDT').removeClass('xCNBackgroundwhite');
        $('#odvFloor' + nSelectFloor + 'Column' + nSelectColumn).attr('data-Merge', 0);
        var tDescription = "ชั้นที่ : " + nSelectFloor + ' ช่องที่ : ' + nSelectColumn;
        $('#odvFloor' + nSelectFloor + 'Column' + nSelectColumn + ' > .xCNDescription').html(tDescription);
        JSxColumnDeleteHover();
    }

    //################################################################################################################ P R O C E S S - S A V E

    //เพิ่มข้อมูลลงฐานข้อมูล
    function JSxSaveDiagram() {

        //Check ก่อนว่าเอกสาร - ใบเติมแบบเดี่ยว - ใบตรวจนับ - ใบนำสินค้าออก
        $.ajax({
            type    : "POST",
            url     : "VendingLayoutCheckDocumentWhenNotApv",
            cache   : false,

            data: {
                tBchCode    : $('#ohdBchCode').val()
            },
            timeout : 0,
            success : function(tResult) {
                var oResult  = JSON.parse(tResult);
                if(oResult.rtCode == 800){
                    //เอกสารทุกตัวผ่านหมด
                    
                    //จำนวนชั้น
                    nFloorAll = $('#ospDetailCabinetRow').text();

                    //จำนวนช่อง
                    nColumnAll = $('#ospDetailCabinetColumn').text();

                    //เก็บข้อมูลไว้
                    aPackData = [];

                    //ลูปชั้น
                    for (f = 1; f <= nFloorAll; f++) {
                        //ลูปช่อง
                        for (c = 1; c <= nColumnAll; c++) {
                            if ($('#odvFloor' + f + 'Column' + c).attr('data-UseThisColumn') == 'true') {
                                //console.log('#odvFloor'+f+'Column'+c + '=> มีข้อมูล');
                                var oDatainfo = $('#odvFloor' + f + 'Column' + c).attr('data-info');
                                aPackData.push(JSON.parse(oDatainfo));
                            } else {
                                var tCheckElemID = $('#odvFloor' + f + 'Column' + c).length;
                                if (tCheckElemID == 0) { //คือ Div นี้ไม่ได้ใช้งาน คือถูก Merge

                                } else {
                                    var oPackData = {
                                        'nColumn'       : c, //ช่องที่
                                        'nFloor'        : f, //ชั้นที่
                                        'nUseColumn'    : 1, //ใช้กี่ช่อง
                                        'nDim'          : 0, //ความลึก
                                        'nTempVD'       : 0, //อุณหภูมิในการอุ่น
                                        'nTimeVD'       : 0, //เวลาในการอุ่น
                                        'nPDTCode'      : null, //รหัสสินค้า
                                        'tImage'        : null, //รูปภาพ
                                        'tPDTName'      : null, //ชื่อสินค้า
                                        'tPDTBarCode'   : null, //บาร์โค๊ดสินค้า
                                        'tPDTDetail'    : null, //รายละเอียดสินค้า
                                        'tStatusSpring' : 1, //สถานะหมุนเกลียว
                                        'nWahCode'      : null, //รหัสคลังสินค้า
                                        'nSTKBal'       : 0
                                    };
                                    var tPackData = JSON.stringify(oPackData);
                                    aPackData.push(JSON.parse(tPackData));
                                }
                            }
                        }
                    }   

                    //เช็คว่าสินค้า import fail หรือไม่
                    var tStatusBeforSave = true;
                    for(n = 0; n < aPackData.length; n++){
                        var nCheckImport = aPackData[n].nPDTCode;
                        if(nCheckImport == 'IMPORTFAIL'){
                            var tStatusBeforSave = false;
                            break;
                        }
                    }

                    // เอา Diagram ลงฐานข้อมูล 
                    if(tStatusBeforSave == true){
                        $.ajax({
                            type: "POST",
                            url: "VendingLayoutInsertDiagram",
                            cache: false,
                            data: {
                                tBchCode: $('#ohdBchCode').val(),
                                tShopCode: $('#ohdShpCode').val(),
                                nColQtyMax: parseInt($('#ohdFTLayColQtyMax').val()),
                                aPackData: aPackData,
                                nSeqCabinet: $('#ohdCabinetValue').val()
                            },
                            timeout: 0,
                            success: function(tResult) {
                                // console.log(tResult);
                                JCNxOpenLoading();

                                setTimeout(function() {
                                    JCNxCloseLoading();
                                }, 500);
                                // JSvVEDDataList();
                            },
                            error: function(data) {
                                console.log(data);
                            }
                        });
                    }else if(tStatusBeforSave == false){
                        $('#odvVendingImportFail').modal('show');
                    }
                }else{
                    //มีเอกสารที่ยังไม่ผ่าน
                    var tText       = 'ตรวจพบเอกสาร';
                    var tTextDetail = '';
                    for(i=0; i<(oResult.raItem).length; i++){
                        if( oResult.raItem[i].DOCTYPE == 'TOPUP'){
                            tTextDetail += 'ใบเติมสินค้า (ตู้สินค้า) ,';
                        }else if(oResult.raItem[i].DOCTYPE == 'PDTOUT'){
                            tTextDetail += 'ใบนำสินค้าออก (ตู้สินค้า) ,';
                        }else if(oResult.raItem[i].DOCTYPE == 'ADJ'){
                            tTextDetail += 'ใบตรวจนับสต๊อคสินค้า (ตู้สินค้า)  ,';
                        }

                        if(i == (oResult.raItem).length - 1){
                            tTextDetail = tTextDetail.substring(0,tTextDetail.length - 1);
                        }
                    }

                    tText += tTextDetail + ' มีเอกสารที่ค้างอยู่ กรุณาอนุมัติ หรือยกเลิกเอกสารดังกล่าว ก่อนการบันทึก';
                    $('#odvVendingDocumentWhenNotApv').modal('show');
                    $('#ospVendingDocumentWhenNotApv').text(tText);
                    return;
                }
            },
            error   : function(data) {
                console.log(data);
            }
        });
    }

    //################################################################################################################ P R O C E S S - E D I T

    //ขาแก้ไข
    function JSxEdit_DrawDiagram(ptDataDiagram) {
        var tResult = ptDataDiagram.aDT;
        var tPDTinDiagram = tResult.raItems;
        var tStatusDT = tResult.rtCode;
        if (tStatusDT != 800) {
            var aPDTinDiagram = tPDTinDiagram;
            var nLastFloor = 0;
            var nLastColumn = 0;
            
            for (i = 0; i < aPDTinDiagram.length; i++) {
                var nDBColumn = parseInt(aPDTinDiagram[i].rtPdtCol) + 1; //ช่องที่
                var nDBFloor = aPDTinDiagram[i].rtPdtRow; //ชั้นที่
                var nDBColWide = parseInt(aPDTinDiagram[i].rtPdtWide); //ใช้กี่ช่อง
                var nDBDim = aPDTinDiagram[i].rtPdtDim; //ความลึก
                var nDBTempVD = aPDTinDiagram[i].rtPdtCookHeat; //อุณหภูมิในการอุ่น
                var nDBTimeVD = aPDTinDiagram[i].rtPdtCookTime; //เวลาในการอุ่น
                var nDBPdtCode = aPDTinDiagram[i].rtPdtCode; //รหัสสินค้า
                var tDBImage = aPDTinDiagram[i].rtPdtImage; //รูปภาพ
                var tDBPdtName = aPDTinDiagram[i].rtPdtName; //ชื่อสินค้า
                var tDBPdtBarCode = ''; //บาร์โค๊ดสินค้า
                var tDBPdtDetail = aPDTinDiagram[i].rtPdtRmk; //รายละเอียดสินค้า
                var tStatusSpring = aPDTinDiagram[i].FTLayStaCtrlXY; //สถานะหมุนเกลียว
                var nWahCode = aPDTinDiagram[i].FTWahCode; //รหัสคลังสินค้า

                var tImg = '';
                if (tDBImage != null) {
                    tImg += tDBImage.substr(0, 1)
                }

                if (nLastFloor != nDBFloor) { //ขึ้นชั้นใหม่
                    nUseColumn = 1;
                    if (parseInt(nDBColWide) > 1) {
                        nLastColumn = 1 + nDBColWide;
                        nEndColumn = nUseColumn + nDBColWide - 1;
                    } else {
                        nLastColumn = 1 + nUseColumn;
                        nEndColumn = nUseColumn;
                    }
                    nLastFloor = nDBFloor;
                    tType = 'NEWFLOOR';
                } else { //อยู่ชั้นเดิม
                    if (parseInt(nDBColWide) > 1) {
                        nUseColumn = nLastColumn;
                        nLastColumn = nUseColumn + nDBColWide;
                        nEndColumn = nUseColumn + nDBColWide - 1;
                    } else {
                        nUseColumn = nLastColumn;
                        nLastColumn = nLastColumn + nDBColWide;
                        nEndColumn = nUseColumn;
                    }
                    tType = 'OLDFLOOR';
                }

                // console.log(tType + ' ชั้น : ' + nDBFloor + ' ใช้ช่อง : ' + nUseColumn + ' ใช้ไป ' + nDBColWide + '(' + nUseColumn + '<->'+ nEndColumn + ')' + ' ช่องใหม่จะเริ่มที่ : ' + nLastColumn)

                if (nDBPdtCode != '' || nDBPdtCode == 'IMPORTFAIL') {
                    if (tDBImage == '' || tDBImage == null) {
                        var tPathImg = '<?= base_url() ?>' + 'application/modules/common/assets/images/imageItemVending.png';
                    // } else if (tImg == '#') {
                    //     var tPathImg = tDBImage;
                    } else {
                        // var aPathImg = tDBImage.split("/application/modules/");
                        // var tPathImg = '<?= base_url() ?>' + '/application/modules/' + aPathImg[1];
                        var tPathImg = tDBImage;
                    }

                    //STK Bal 
                    if(aPDTinDiagram[i].rtStkQty == null){
                        var nSTKBal = 0;
                    }else{
                        var nSTKBal = aPDTinDiagram[i].rtStkQty;
                    }

                    var oPackData = {
                        'nColumn'       : nUseColumn, //ช่องที่
                        'nFloor'        : parseInt(nDBFloor), //ชั้นที่
                        'nUseColumn'    : parseInt(nDBColWide), //ใช้กี่ช่อง
                        'nDim'          : parseInt(nDBDim), //ความลึก
                        'nTempVD'       : parseInt(nDBTempVD), //อุณหภูมิในการอุ่น
                        'nTimeVD'       : parseInt(nDBTimeVD), //เวลาในการอุ่น
                        'nPDTCode'      : nDBPdtCode, //รหัสสินค้า
                        'tImage'        : tPathImg, //รูปภาพ
                        'tPDTName'      : tDBPdtName + ' รหัส : ' + nDBPdtCode, //ชื่อสินค้า
                        'tPDTBarCode'   : tDBPdtBarCode, //บาร์โค๊ดสินค้า
                        'tPDTDetail'    : tDBPdtDetail, //รายละเอียดสินค้า
                        'tStatusSpring' : tStatusSpring, //สถานะหมุนเกลียว
                        'nWahCode'      : nWahCode, //รหัสคลังสินค้า,
                        'nSTKBal'       : nSTKBal //จำนวนคงเหลือในคลัง
                    };
                    var tPackData = JSON.stringify(oPackData);
                    if (parseInt(nDBColWide) > 1) {
                        var nWidthColumnEdit = $('#odvFloor' + nDBFloor + 'Column' + nUseColumn).width();
                        var nWidthColumnEditDefault = 0;
                        for (j = nUseColumn + 1; j <= nEndColumn; j++) {
                            nWidthColumnEditDefault += parseInt(nWidthColumnEdit) + 8;
                            $("#odvFloor" + nDBFloor + "Column" + j).remove();
                        }

                        var nHeightDivEdit = $('#odvFloor' + nDBFloor + 'Column' + nUseColumn).height() + 4;
                        var nWidthDivEdit = parseInt(nWidthColumnEditDefault) + parseInt(nWidthColumnEdit);

                        var nColumnPer = nWidthColumndefault.split("px");
                        var nWidthMergin = parseInt(nWidthDivEdit / nColumnPer[0]) * 2;
                        var nWidthDivEdit = nWidthDivEdit + nWidthMergin;

                        if (tImg != '#') {
                            tHTML = '<img style=" position: absolute; max-height: 90%; max-width: 90%; top: 0; bottom: 0; left: 0; right: 0; margin: auto;" src=' + tPathImg + '>';
                        } else {
                            tHTML = '<span style=" background-color:' + tPathImg + ' !important; position: absolute; max-height: 90%; max-width: 90%; top: 0; bottom: 0; left: 0; right: 0; margin: auto;"  />';
                        }

                        $('#odvFloor' + nDBFloor + 'Column' + nUseColumn).find('.wCNInnerPDT').addClass('xCNBackgroundwhite');
                        $('#odvFloor' + nDBFloor + 'Column' + nUseColumn).attr('data-info', tPackData);
                        $('#odvFloor' + nDBFloor + 'Column' + nUseColumn).attr('data-UseThisColumn', true);
                        $('#odvFloor' + nDBFloor + 'Column' + nUseColumn).children('.wCNInnerPDT').html(tHTML);
                        $('#odvFloor' + nDBFloor + 'Column' + nUseColumn).attr("style", 'max-width : ' + nWidthDivEdit + 'px !important; width: ' + nWidthDivEdit + 'px; height:' + nHeightDivEdit + 'px;');
                        $('#odvFloor' + nDBFloor + 'Column' + nUseColumn).attr('data-Merge', parseInt(nDBColWide));

                        //ชื่อสินค้า
                        if(nDBPdtCode == 'IMPORTFAIL'){
                            var tNameShort = 'สินค้าตัวนี้ไม่ตรงเงื่อนไข';
                        }else{
                            var tNameShort = tDBPdtName;
                            var tNameShort = tNameShort.substring(0, 20) + '...';
                        }

                        var tNameDescription = "ชั้นที่ : " + nDBFloor + ' ช่องที่ : ' + nUseColumn + '<br>' + tNameShort  + '<br>';
                        $('#odvFloor' + nDBFloor + 'Column' + nUseColumn + ' > .xCNDescription').html(tNameDescription);
                    } else {

                        //ชื่อสินค้า
                        if(nDBPdtCode == 'IMPORTFAIL'){
                            var tNameShort = 'สินค้าตัวนี้ไม่ตรงเงื่อนไข';
                        }else{
                            var tNameShort = tDBPdtName;
                            var tNameShort = tNameShort.substring(0, 20) + '...';
                        }

                        var tElementID = '#odvFloor' + nDBFloor + 'Column' + nUseColumn;
                        var tNameDescription = "ชั้นที่ : " + nDBFloor + ' ช่องที่ : ' + nUseColumn + '<br>' + tNameShort  + '<br>';
                        $(tElementID + ' > .xCNDescription').html(tNameDescription);

                        if (tImg != '#') {
                            tHTML = '<img style=" position: absolute; max-height: 90%; max-width: 90%; top: 0; bottom: 0; left: 0; right: 0; margin: auto;" src=' + tPathImg + '>';
                        } else {
                            tHTML = '<span style=" background-color:' + tPathImg + ' !important; position: absolute; max-height: 90%; max-width: 90%; top: 0; bottom: 0; left: 0; right: 0; margin: auto;"  />';

                        }
                        $('#odvFloor' + nDBFloor + 'Column' + nUseColumn).find('.wCNInnerPDT').addClass('xCNBackgroundwhite');
                        $('#odvFloor' + nDBFloor + 'Column' + nUseColumn).attr('data-info', tPackData);
                        $('#odvFloor' + nDBFloor + 'Column' + nUseColumn).attr('data-UseThisColumn', true);
                        $('#odvFloor' + nDBFloor + 'Column' + nUseColumn).children('.wCNInnerPDT').html(tHTML);
                    }
                }

            }
        }
    }

    //################################################################################################################ P R O C E S S - C A N C E L

    //ลบข้อมูล เพื่อจัดใหม่
    function JSxCancelDiagram() {
        $('#odvModalDeleteLayout').modal('show');
        $('#ocmCancelShopLayout').off('click').on('click', function() {
            //ยกเลิกสินค้า ที่ยังไม่ได้ save
            var nValueCabinet = $('#ohdCabinetValue').val();
            $("#osmSelectCabinet").val(nValueCabinet).change();
        });
    }

    //กดปุ่มพิมพ์
    function JSxPrintDiagram(){
        window.print();
    }

    //นำเข้า
    function JSxImportDiagram(){
        $('#odvModalVendingImport').modal('show');

        //ล้างค่าใหม่ทุกครั้งที่กดนำเข้า
        $('#oefFileVendingImport').val('');
        $('#oetFileNameVendingImport').val('');
        $('#odvContentVendingRenderHTMLImport').html('');
        $('#obtIMPVendingConfirm').hide();
    }

    //Import File
    function JSxCheckFileVendingImport(poElement, poEvent) {
        try {
            var oFile = $(poElement)[0].files[0];
            if(oFile == undefined){
                $("#oetFileNameVendingImport").val("");
            }else{
                $("#oetFileNameVendingImport").val(oFile.name);
            }
        } catch (err) {
            console.log("JSxCheckFileVendingImport Error: ", err);
        }
    }

    //Confrim File
    function JSxConfrimFileVendingImport(){
        var oFile = $('#oefFileVendingImport')[0].files[0];
        var reader      = new FileReader();
        reader.onload   = onReaderLoad;
        reader.readAsText(oFile);
    }

    var aPackdata = [];
    var aItemPDT  = [];
    function onReaderLoad(event){
        var obj = JSON.parse(event.target.result);
        if(typeof obj[0] === null || typeof obj[0] === 'undefined'){
            $('#odvContentVendingRenderHTMLImport').html('<span> รูปแบบไฟล์ไม่ถูกต้อง </span>');
        }else{

            for(w=0; w<obj.length; w++){
                if(obj[w].tTable == 'TVDMPdtLayout'){
                    var tHTML_Layout = '<div style="max-height: 500px; overflow: auto;">';
                        tHTML_Layout += '<span style="font-weight: bold;">รายละเอียด</span><br>';
                        tHTML_Layout += '<table class="table table-striped">';
                        tHTML_Layout += '<thead>';
                        tHTML_Layout += '<tr>';
                        tHTML_Layout += '<th>รหัสสินค้า</th>';
                        tHTML_Layout += '<th>ชื่อสินค้า</th>';
                        tHTML_Layout += '<th>ชื่อคลังสินค้า</th>';
                        tHTML_Layout += '<th>กลุ่มช่อง (Cabinet)</th>';
                        tHTML_Layout += '<th style="text-align: right;">จำนวนสินค้าในช่องนี้</th>';
                        tHTML_Layout += '<th style="text-align: right;">ชั้น</th>';
                        tHTML_Layout += '<th style="text-align: right;">ช่อง</th>';
                        tHTML_Layout += '<th>สถานะนำเข้า</th>';
                        tHTML_Layout += '</tr>';
                        tHTML_Layout += '</thead>';
                        tHTML_Layout += '<tbody>';

                        for(i=0; i<obj[w].tItem.length; i++){
                            var aItem       = obj[w].tItem;
                            var tItemName   = (aItem[i].FTPdtName == null) ? 'N/A' : aItem[i].FTPdtName;
                            var tItemCode   = (aItem[i].FTPdtCode == null) ? 'N/A' : aItem[i].FTPdtCode;
                            var tItemWah    = (aItem[i].FTWahName == null) ? 'N/A' : aItem[i].FTWahName;   
                            var tItemCabinet= aItem[i].FTCabName + ' (รหัส : ' + aItem[i].FNCabSeq + ')';   
                            var tClassPDT   = aItem[i].FNLayRow + '-' + aItem[i].FNLayCol + '-' + aItem[i].FNCabSeq;
                            if(tItemCode != 'N/A'){
                                aItemPDT.push({
                                    'ROW'       : aItem[i].FNLayRow,
                                    'COL'       : aItem[i].FNLayCol,
                                    'CABSEQ'    : aItem[i].FNCabSeq,
                                    'PDT'       : tItemCode
                                });
                            }

                            tHTML_Layout += '<tr class='+tClassPDT+'>';
                            tHTML_Layout += '<td>'+tItemCode+'</td>';
                            tHTML_Layout += '<td>'+tItemName+'</td>';
                            tHTML_Layout += '<td>'+tItemWah+'</td>';
                            tHTML_Layout += '<td style="font-weight: bold;">'+tItemCabinet+'</td>';
                            tHTML_Layout += '<td style="text-align: right;">'+aItem[i].FCLayDim+'</td>';
                            tHTML_Layout += '<td style="text-align: right;">'+aItem[i].FNLayRow+'</td>';
                            tHTML_Layout += '<td style="text-align: right;">'+aItem[i].FNLayCol+'</td>';
                            tHTML_Layout += '<td class="xCNTextStatus">'+'-'+'</td>';
                            tHTML_Layout += '</tr>';

                        }
                        tHTML_Layout += '</tbody>';
                        tHTML_Layout += '</table>';
                        tHTML_Layout += '<div><span style="color : #41B314 !important; font-weight : bold" > ผ่าน </span><span> : สินค้าผ่านการตรวจสอบแล้ว รอการนำเข้า , </span><span style="color : #F9354C !important; font-weight : bold"> สินค้าตัวนี้ไม่ตรงเงื่อนไข </span><span>: สินค้าตัวนี้ใช้เฉพาะร้านค้าที่ถูกส่งออกมาเท่านั้น </span>';
                        tHTML_Layout += '</div>';
                }
            }

            var tHTML        = tHTML_Layout;
            $('#odvContentVendingRenderHTMLImport').html(tHTML);
            $('#obtIMPVendingConfirm').show();

            //อัพเดทสถานะของสินค้า
            $.ajax({
                type    : "POST",
                url     : "VendingLayoutImportCheckPDT",
                cache   : false,
                data    : {
                    tBchCode    : $('#ohdBchCode').val(),
                    tShopCode   : $('#ohdShpCode').val(),
                    aItemPDT    : aItemPDT
                },
                timeout : 0,
                success : function(tResult) {
                    aItemPDT        = [];
                    var aResult     = JSON.parse(tResult);
                    for(w=0; w<aResult.length; w++){
                        var nCOL        = aResult[w].nCOL;
                        var nROW        = aResult[w].nROW;
                        var nSTATUS     = aResult[w].nSTATUS;
                        var nCABSEQ     = aResult[w].nCABSEQ;
                        if(nSTATUS == 1 || nSTATUS == '1'){
                            var tDETAIL     = 'ผ่าน';
                            $('.'+nROW+'-'+nCOL+'-'+nCABSEQ).find('.xCNTextStatus').attr('style' , "color : #41B314 !important; font-weight : bold");
                        }else{
                            var tDETAIL     = 'สินค้าตัวนี้ไม่ตรงเงื่อนไข';
                            $('.'+nROW+'-'+nCOL+'-'+nCABSEQ).find('.xCNTextStatus').attr('style' , "color : #F9354C !important; font-weight : bold");
                        }
                        $('.'+nROW+'-'+nCOL+'-'+nCABSEQ).find('.xCNTextStatus').text(tDETAIL);
                    }
                },
                error: function(data) {
                    console.log(data);
                }
            });
        }

        aPackdata = obj;
    }

    //ยืนยันการนำเข้า
    function JSxImportDiagramToDatabase(){
        JCNxOpenLoading();
        $.ajax({
            type    : "POST",
            url     : "VendingLayoutImport",
            cache   : false,
            data    : {
                tBchCode    : $('#ohdBchCode').val(),
                tShopCode   : $('#ohdShpCode').val(),
                aPackData   : aPackdata
            },
            timeout : 0,
            success : function(tResult) {
                var oResult         = JSON.parse(tResult);

                for(m=0; m<aPackdata.length; m++){
                    if(aPackdata[m].tTable == 'TVDMShopCabinet'){   
                        var nSeqCabinet     = parseInt(aPackdata[m].FNCabSeq);
                        var tNameCabinet    = aPackdata[m].FTCabName;
                        var tShopType       = aPackdata[m].tShopType;
                        var nCOL            = aPackdata[m].FNCabMaxCol;
                        var nROW            = aPackdata[m].FNCabMaxRow;
                        var nShowCabinet    = parseInt(aPackdata[m].FNCabSeq) + parseInt(1);
                        $('#osmSelectCabinet option[value='+nSeqCabinet+']').remove();
                        $('#osmSelectCabinet').append($("<option class='xCNOptionCabinet'></option>").attr("value", nSeqCabinet).text(tNameCabinet + ' กลุ่มช่องที่ : ' + nShowCabinet )); 
                        $('#osmSelectCabinet option[value='+nSeqCabinet+']').attr('data-row',nROW);
                        $('#osmSelectCabinet option[value='+nSeqCabinet+']').attr('data-col',nCOL);
                        $('#osmSelectCabinet option[value='+nSeqCabinet+']').attr('data-shoptype',tShopType);
                        $('#osmSelectCabinet option[value='+nSeqCabinet+']').attr('data-cabinet',nSeqCabinet);
                        $('#osmSelectCabinet option[value='+nSeqCabinet+']').attr('data-cabinetname',tNameCabinet);
                        $('#osmSelectCabinet option[value='+nSeqCabinet+']').attr('data-cabinetreason','');
                        $('#osmSelectCabinet option[value='+nSeqCabinet+']').attr('selected','selected');
                    }
                }

                $('.selectpicker').selectpicker('refresh');
                $('#osmSelectCabinet').trigger('change');
                JCNxCloseLoading();
            },
            error: function(data) {
                console.log(data);
            }
        });
    }

    //ส่งออก
    function JSxExportDiagram(){
        $.ajax({
            type    : "POST",
            url     : "VendingLayoutExport",
            cache   : false,
            data    : {
                tBchCode    : $('#ohdBchCode').val(),
                tShopCode   : $('#ohdShpCode').val(),
                nSeqCabinet : $('#ohdCabinetValue').val()
            },
            timeout : 0,
            success : function(tResult) {
                console.log(tResult);
                var aResult     = JSON.parse(tResult);
                var tStatus     = aResult.tStatusReturn;
                if(tStatus == '800' || tStatus == 800){
                    alert('ไม่พบรูปแบบตู้');
                }else{
                    var tFileName   = aResult.tFilename;
                    $('#ohdDowloadFile').attr("href","<?=base_url();?>"+"application/modules/vending/views/vendinglayout/wExportFile.php?ptFile="+tFileName+"");
                    $('#ohdDowloadFile')[0].click(); 
                }
            },
            error: function(data) {
                console.log(data);
            }
        });
    }
</script>