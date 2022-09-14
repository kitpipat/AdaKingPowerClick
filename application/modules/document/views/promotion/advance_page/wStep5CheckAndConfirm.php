<style>
    .xCNPromotionStep4TablePriceGroupConditionContainer .popover {
        max-width: 600px !important;
    }
</style>
<div class="row">
    <div class="col-md-12 xCNPromotionStep4TablePriceGroupConditionContainer">
        <!--Section : เงื่อนไขการคำนวน-->
        <div class="panel panel-default" style="margin-bottom: 10px;">
            <div id="odvHeadAllow" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
                <label class="xCNTextDetail1"><?php echo language('document/promotion/promotion', 'tCalculationConditions'); ?></label>
            </div>

            <div class="panel-collapse collapse in" role="tabpanel">
                <div class="panel-body xCNPDModlue">
                    <div class="table-responsive">
                        <table class="table table-striped xWPdtTableFont" id="otbPromotionStep5CheckAndConfirm">
                            <thead style="visibility: hidden;">
                                <tr>
                                    <th width="10%" class="text-center"></th>
                                    <th width="90%" class="text-left"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-center"><?php echo language('document/promotion/promotion', 'tBuy'); ?></td>
                                    <td>
                                        <div class="row">
                                            <?php $bIsBuyGroupMore = FCNnHSizeOf($aPmtCBInTmp) > 1; ?>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <select class="selectpicker form-control xCNApvOrCanCelDisabledCheckAndConfirm" onchange="JSvPromotionStep5UpdatePmtCBStaCalSumInTemp(false, true)" id="ocmPromotionStep5BuyPbyStaCalSum" name="ocmPromotionStep5BuyPbyStaCalSum">
                                                        <?php if ($bConditionBuyIsRange) { ?>
                                                            <option value='1' <?php echo ($tPbyStaCalSum == "1") ? 'selected' : ''; ?>><?php echo language('document/promotion/promotion', 'tSeparateCount'); ?></option>
                                                        <?php } else { ?>
                                                            <option value='1' <?php echo ($tPbyStaCalSum == "1") ? 'selected' : ''; ?>><?php echo language('document/promotion/promotion', 'tSeparateCount'); ?></option>
                                                            <?php if ($bIsBuyGroupMore) { ?>
                                                                <option value='2' <?php echo ($tPbyStaCalSum == "2") ? 'selected' : ''; ?>><?php echo language('document/promotion/promotion', 'tTotalCount'); ?></option>
                                                            <?php } ?>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <col-md-2>
                                                <a tabindex="0" role="button" data-html="true" data-toggle="popover" data-trigger="focus" title="การกำหนดเงื่อนไข" data-content="
                                                    <p><b>นับแยก</b> นับจำนวน/มูลค่า ให้ครบเงื่อนไขแต่ละกลุ่ม เช่นกำหนดซื้อกลุ่ม A 2 ชิ้น ร่วมกับกลุ่ม B 3 ชิ้น กลุ่ม B จะได้รับส่วนลด 5% แสดงว่าต้องซื้อกลุ่ม A อย่างน้อย 2 ชิ้น และกลุ่ม B อย่างน้อย 3 ชิ้น จึงจะได้รับส่วนลด</p>
                                                    <hr>
                                                    <p><b>นับรวม</b> นับจำนวน/มูลค่า ให้ครบโดยใช้ยอดรวมทุกกลุ่ม เช่นกำหนดซื้อสินค้ากลุ่ม A และกลุ่ม B รวมกันครบ 1,000 บาท จะได้รับส่วนลด 10% แสดงว่าต้อง ซื้อสินค้ากลุ่ม A และกลุ่ม B สัดส่วนใดๆ โดยยอดรวมกันต้องไม่ต่ำกว่า 1,000 บาทจึงจะได้รับส่วนลด</p>">
                                                    <i class="fa fa-info-circle" style="margin-top:10px;"></i>
                                                </a>
                                            </col-md-2>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <?php foreach ($aPmtCBInTmp as $aItemCB) { ?>
                                                    <?php
                                                    $tPbyStaBuyCond = $aItemCB['FTPbyStaBuyCond']; // 1:ครบจำนวน 2:ครบมูลค่า 3:ตามช่วงจำนวน 4:ตามช่วงมูลค่า 5:ตามช่วงเวลา ครบจำนวน 6:ตามช่วงเวลา ครบมูลค่า
                                                    $tTimeRange = "";
                                                    $tUnitText = "";
                                                    if (in_array($tPbyStaBuyCond, ["1", "3"])) {
                                                        $tUnitText = language('document/promotion/promotion', 'tPiece');
                                                    }
                                                    if (in_array($tPbyStaBuyCond, ["5", "6"])) {
                                                        $tTimeRange = (empty($aItemCB['FTPbyMinTime']) || empty($aItemCB['FTPbyMaxTime'])) ? "" : $aItemCB['FTPbyMinTime'] . ' - ' . $aItemCB['FTPbyMaxTime'];
                                                        if ($tPbyStaBuyCond == "5") {
                                                            $tUnitText = language('document/promotion/promotion', 'tPiece');
                                                        }
                                                    }
                                                    ?>
                                                    <label>
                                                        <?php echo language('document/promotion/promotion', 'tBuyProduct'); ?>
                                                        <b>
                                                            <?php echo $aItemCB['FTPmdGrpName']; ?>

                                                            <?php if (in_array($tPbyStaBuyCond, ["5", "6"])) { // 5:ตามช่วงเวลา ครบจำนวน 6:ตามช่วงเวลา ครบมูลค่า 
                                                            ?>
                                                                <?php echo language('document/promotion/promotion', 'tByTimeRange'); ?>
                                                            <?php } else { ?>
                                                                <?php echo language('document/promotion/promotion', 'tBuyCondition' . $aItemCB['FTPbyStaBuyCond']); ?>
                                                            <?php } ?>

                                                            <?php echo $tTimeRange; ?>

                                                            <?php if (in_array($tPbyStaBuyCond, ["5", "6"])) { // 6:ตามช่วงเวลา ครบจำนวน 7:ตามช่วงเวลา ครบมูลค่า 
                                                            ?>
                                                                <?php if ($tPbyStaBuyCond == "5") { // 5:ตามช่วงเวลา ครบจำนวน 
                                                                ?>
                                                                    <?php echo ($aItemCB['FCPbyMinValue'] > 0) ? language('document/promotion/promotion', 'tBuyCondition1') : ''; ?>
                                                                <?php } ?>
                                                                <?php if ($tPbyStaBuyCond == "6") { // 6:ตามช่วงเวลา ครบมูลค่า 
                                                                ?>
                                                                    <?php echo ($aItemCB['FCPbyMinValue'] > 0) ? language('document/promotion/promotion', 'tBuyCondition2') : ''; ?>
                                                                <?php } ?>
                                                            <?php } ?>

                                                            <?php echo ($aItemCB['FCPbyMinValue'] > 0) ? number_format($aItemCB['FCPbyMinValue'], $nOptionDecimalShow) : ''; ?>
                                                            <?php echo ($aItemCB['FCPbyMinValue'] > 0) ? $tUnitText : ''; ?>
                                                            <?php echo ($aItemCB['FCPbyMaxValue'] > 0) ? language('document/promotion/promotion', 'tNotOver') . ' ' . number_format($aItemCB['FCPbyMaxValue'], $nOptionDecimalShow) . ' ' . $tUnitText : ''; ?>
                                                            <?php echo ($aItemCB['FCPbyMinSetPri'] > 0) ? language('document/promotion/promotion', 'tMinimumPricePerUnit') . ' ' . number_format($aItemCB['FCPbyMinSetPri'], $nOptionDecimalShow) : ''; ?>
                                                        </b>
                                                    </label>
                                                    <br>
                                                <?php } ?>
                                                <?php // echo '<pre>'; var_dump($aPmtCBInTmp); echo '</pre>'; 
                                                ?>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center"><?php echo language('document/promotion/promotion', 'tGet'); ?></td>
                                    <td>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <select class="selectpicker form-control xCNApvOrCanCelDisabledCheckAndConfirm" onchange="JSvPromotionStep5UpdatePmtCGPgtStaGetEffectInTemp(false, true)" id="ocmPromotionStep5GetPgtStaGetEffect" name="ocmPromotionStep5GetPgtStaGetEffect">
                                                        <?php if ($bConditionBuyIsRange) { ?>
                                                            <option value='3' <?php echo ($tPgtStaGetEffect == "3") ? 'selected' : ''; ?>><?php echo language('document/promotion/promotion', 'tByRange'); ?></option>
                                                        <?php } else { ?>
                                                            <?php if ($tPgtStaGetType == "4") { ?>
                                                                <option value='2' <?php echo ($tPgtStaGetEffect == "2") ? 'selected' : ''; ?>><?php echo language('document/promotion/promotion', 'tAllGroup'); ?></option>
                                                            <?php } else { ?>
                                                                <option value='1' <?php echo ($tPgtStaGetEffect == "1") ? 'selected' : ''; ?>><?php echo language('document/promotion/promotion', 'tByCalculated'); ?></option>
                                                                <option value='2' <?php echo ($tPgtStaGetEffect == "2") ? 'selected' : ''; ?>><?php echo language('document/promotion/promotion', 'tAllGroup'); ?></option>
                                                            <?php } ?>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <?php if (!$bConditionBuyIsRange) { ?>
                                                <col-md-2>
                                                    <a tabindex="0" role="button" data-html="true" data-toggle="popover" data-trigger="focus" title="การกำหนดเงื่อนไข" data-content="
                                                        <p><b>ตามคำนวน</b> ส่วนลดที่จะได้รับคิดตามอัตราส่วนเฉพาะเงื่อนไขที่เข้าโปรโมชั่น (ส่วนเกินจะได้ราคาปกติ) เช่นกำหนดกลุ่มซื้อ กลุ่ม A 2 ชิ้น ร่วมกับ กลุ่ม B 3 ชิ้น จะได้รับส่วนลดกลุ่ม B ชิ้นละ 5% บิลขาย ซื้อกลุ่ม A 4 ชิ้น และกลุ่ม B 7 ชิ้น = ได้สิทธิ์โปรโมชั่น 2 ชุด แสดงว่า ส่วนลด 5% จะมีผลเฉพาะ สินค้า B 3 ชิ้น x 2 ชุด = 6 รายการเท่านั้น (อีก 1 ชิ้นได้ราคาปกติ)</p>
                                                        <hr>
                                                        <p><b>ทั้งกลุ่ม</b> ส่วนลดที่จะได้รับมีผลกับสินค้ากลุ่มรับทุกรายการ เช่น กำหนดซื้อสินค้า กลุ่ม A และกลุ่ม B รวมกันครบ 1,000 บาท จะได้รับส่วนลด 10% ทั้งกลุ่ม A และกลุ่ม B บิลขาย ซื้อกลุ่ม A และกลุ่ม B รวมกันยอด 2,500 บาท แสดงว่า ส่วนลดที่จะได้ รับ คำนวน 10% จากยอด 2,500 บาท</p>
                                                    ">
                                                        <i class="fa fa-info-circle" style="margin-top:10px;"></i>
                                                    </a>
                                                </col-md-2>
                                            <?php } ?>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <?php foreach ($aPmtCGInTmp as $aItemCG) { ?>
                                                    <?php
                                                    $tPgtStaGetType = $aItemCG['FTPgtStaGetType']; // 1:ลดบาท 2:ลด% 3:ปรับราคา 4:.ใช้กลุ่มราคา 5:แถม(Free) 6:ไม่กำหนด
                                                    $tStaGetTypeLabel = "";
                                                    $tsign = "";
                                                    $tPmdGrpName = "";
                                                    $tPriGrpName = "";
                                                    $tN = "";
                                                    $tValueText = "";
                                                    if ($tPgtStaGetType == "1") {
                                                        $tPmdGrpName = $aItemCG['FTPmdGrpName'];
                                                        $tStaGetTypeLabel = language('document/promotion/promotion', 'tDiscount');
                                                        $tValueText = language('document/promotion/promotion', 'tValue');
                                                    }
                                                    if ($tPgtStaGetType == "2") {
                                                        $tPmdGrpName = $aItemCG['FTPmdGrpName'];
                                                        $tStaGetTypeLabel = language('document/promotion/promotion', 'tDiscount');
                                                        $tValueText = language('document/promotion/promotion', 'tValue');
                                                        $tsign = "%";
                                                    }
                                                    if ($tPgtStaGetType == "3") {
                                                        $tPmdGrpName = $aItemCG['FTPmdGrpName'];
                                                        $tStaGetTypeLabel = language('document/promotion/promotion', 'tAdjustThePrice');
                                                    }
                                                    if ($tPgtStaGetType == "4") {
                                                        $tPriGrpName = $aItemCG['FTPplName'];
                                                        $tStaGetTypeLabel = language('document/promotion/promotion', 'tPriceGroup');
                                                    }
                                                    if ($tPgtStaGetType == "5") {
                                                        $tPmdGrpName = $aItemCG['FTPmdGrpName'];
                                                        $tStaGetTypeLabel = language('document/promotion/promotion', 'tFree');
                                                        $tN = number_format($aItemCG['FCPgtGetQty'], 0);
                                                    }
                                                    if ($tPgtStaGetType == "6") {
                                                        $tPmdGrpName = $aItemCG['FTPmdGrpName'];
                                                    }
                                                    ?>

                                                    <label>
                                                        <?php echo language('document/promotion/promotion', 'tGets'); ?>
                                                        <b>
                                                            <?php echo $tStaGetTypeLabel; ?>
                                                            <?php echo $tValueText; ?>
                                                            <?php echo ($aItemCG['FCPgtGetvalue'] > 0) ? number_format($aItemCG['FCPgtGetvalue'], $nOptionDecimalShow) . $tsign : ''; ?>
                                                            <?php echo $tN; ?>
                                                            <?php echo $tPmdGrpName; ?>
                                                            <?php echo $tPriGrpName; ?>
                                                        </b>
                                                    </label>
                                                    <br>
                                                <?php } ?>
                                                <?php // echo '<pre>'; var_dump($aPmtCGInTmp); echo '</pre>'; 
                                                ?>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center"><?php echo language('document/promotion/promotion', 'tCoupon'); ?></td>
                                    <td>
                                        <?php foreach ($aCouponInTmp as $aItemCoupon) { ?>
                                            <?php
                                            $tPgtStaCoupon = $aItemCoupon['FTPgtStaCoupon']; // การให้สิทธิ์ 1:ไม่กำหนด 2:.ให้สิทธิ์คูปอง 3:ข้อความ
                                            $tGetLabel = "";
                                            $tName = "";
                                            $tGetText = "";
                                            if ($tPgtStaCoupon == "1") {
                                                $tGetText = language('document/promotion/promotion', 'tN_Right');
                                                $tName = $aItemCoupon['FTCphDocName'];
                                                $tGetLabel = language('document/promotion/promotion', 'tGetCoupons');
                                            }
                                            if ($tPgtStaCoupon == "2") {
                                                $tGetText = language('document/promotion/promotion', 'tN_Right');
                                                $tName = $aItemCoupon['FTCphDocName'];
                                                $tGetLabel = language('document/promotion/promotion', 'tGetCoupons');
                                            }
                                            if ($tPgtStaCoupon == "3") {
                                                $tGetText = language('document/promotion/promotion', 'tN_Right');
                                                $tName = $aItemCoupon['FTPgtCpnText'];
                                                $tGetLabel = language('document/promotion/promotion', 'tGets');
                                            }
                                            ?>
                                            <label><?php echo $tGetLabel; ?> <b><?php echo $tName; ?> <?php echo $tGetText; ?></b></label> <br>
                                        <?php } ?>
                                        <?php // echo '<pre>'; var_dump($aCouponInTmp); echo '</pre>'; 
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center"><?php echo language('document/promotion/promotion', 'tPoints'); ?></td>
                                    <td>
                                        <?php foreach ($aPointInTmp as $aItemPoint) {
                                        ?>
                                            <?php if ($aItemPoint['FNPgtPntGet'] > 0) { ?>
                                                <label><?php echo language('document/promotion/promotion', 'tGets'); ?> <b><?php echo $aItemPoint['FNPgtPntGet']; ?> <?php echo language('document/promotion/promotion', 'tPoints'); ?></b></label> <br>
                                            <?php } ?>
                                        <?php } ?>
                                        <?php // echo '<pre>'; var_dump($aPointInTmp); echo '</pre>'; 
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center"><?php echo language('document/promotion/promotion', 'tExclude'); ?></td>
                                    <td>
                                        <?php foreach ($aPmtDTExceptInTmp as $nIndex => $aItemExcept) { ?>
                                            <?php
                                            $tComma = ", ";
                                            if (FCNnHSizeOf($aPmtDTExceptInTmp) == 1 || FCNnHSizeOf($aPmtDTExceptInTmp) == ($nIndex + 1)) {
                                                $tComma = "";
                                            }
                                            ?>
                                            <label><b><?php echo $aItemExcept['FTPmdGrpName'] . $tComma; ?></b></label>
                                        <?php } ?>
                                        <?php // echo '<pre>'; var_dump($aPmtDTExceptInTmp); echo '</pre>'; 
                                        ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <!--Section : กำหนดเงื่อนไขเฉพาะ -->
        <div class="panel panel-default" style="margin-bottom: 10px;">
            <div id="odvHeadAllow" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
                <label class="xCNTextDetail1"><?php echo language('document/promotion/promotion', 'tDefineSpecificConditions'); ?></label>
            </div>

            <div class="panel-collapse collapse in" role="tabpanel">
                <div class="panel-body xCNPDModlue">
                    <div class="table-responsive">
                        <table class="table table-striped xWPdtTableFont" id="otbPromotionStep5CheckAndConfirm">
                            <thead>
                                <tr>
                                    <th width="10%" class="text-center"><?php echo language('document/promotion/promotion', 'tLabel21'); ?></th>
                                    <th width="45%" class="text-left"><?php echo language('document/promotion/promotion', 'tJoining'); ?></th>
                                    <th width="45%" class="text-left"><?php echo language('document/promotion/promotion', 'tExclude'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-center"><?php echo language('document/promotion/promotion', 'tPriceGroup'); ?></td>
                                    <td class="text-left">
                                        <?php if (empty($aPdtPmtHDCstPriInTmp)) { ?>
                                            <label><?php echo language('document/promotion/promotion', 'tLabel22'); ?></label>
                                        <?php } ?>

                                        <?php foreach ($aPdtPmtHDCstPriInTmp as $aCstPri) { ?>
                                            <?php if ($aCstPri['FTPmhStaType'] != "1") {
                                                continue;
                                            } ?>
                                            <label><?php echo $aCstPri['FTPplName']; ?></label><br>
                                        <?php } ?>
                                    </td>
                                    <td class="text-left">
                                        <?php foreach ($aPdtPmtHDCstPriInTmp as $aCstPri) { ?>
                                            <?php if ($aCstPri['FTPmhStaType'] != "2") {
                                                continue;
                                            } ?>
                                            <label><?php echo $aCstPri['FTPplName']; ?></label><br>
                                        <?php } ?>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="text-center"><?php echo language('document/promotion/promotion', 'tBranch'); ?></td>
                                    <td class="text-left">
                                        <?php if (empty($aPdtPmtHDBchInTmp)) { ?>
                                            <label><?php echo language('document/promotion/promotion', 'tLabel23'); ?></label>
                                        <?php } ?>

                                        <?php foreach ($aPdtPmtHDBchInTmp as $aBch) { ?>
                                            <?php if ($aBch['FTPmhStaType'] != "1") {
                                                continue;
                                            } ?>
                                            <label><?php echo $aBch['FTPmhAgnToName'] . ' ' . $aBch['FTPmhBchToName']; ?></label><br>
                                        <?php } ?>
                                    </td>
                                    <td class="text-left">
                                        <?php foreach ($aPdtPmtHDBchInTmp as $aBch) { ?>
                                            <?php if ($aBch['FTPmhStaType'] != "2") {
                                                continue;
                                            } ?>
                                            <label><?php echo $aBch['FTPmhAgnToName'] . ' ' . $aBch['FTPmhBchToName']; ?></label><br>
                                        <?php } ?>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="text-center"><?php echo language('pos/poschannel/poschannel', 'tCHNLabelTitle'); ?></td>
                                    <td class="text-left">
                                        <?php if (empty($aPdtPmtHDChnInTmp)) { ?>
                                            <label><?php echo language('document/promotion/promotion', 'tLabel60'); ?></label>
                                        <?php } ?>

                                        <?php foreach ($aPdtPmtHDChnInTmp as $aChn) { ?>
                                            <?php if ($aChn['FTPmhStaType'] != "1") {
                                                continue;
                                            } ?>
                                            <label><?php echo $aChn['FTChnName']; ?></label><br>
                                        <?php } ?>
                                    </td>
                                    <td class="text-left">
                                        <?php foreach ($aPdtPmtHDChnInTmp as $aChn) { ?>
                                            <?php if ($aChn['FTPmhStaType'] != "2") {
                                                continue;
                                            } ?>
                                            <label><?php echo $aChn['FTChnName']; ?></label><br>
                                        <?php } ?>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="text-center"><?php echo language('pos/poschannel/poschannel', 'ระดับลูกค้า'); ?></td>
                                    <td class="text-left">
                                        <?php if (empty($aPdtPmtHDCstLevInTmp)) { ?>
                                            <label><?php echo language('document/promotion/promotion', 'tLabel59'); ?></label>
                                        <?php } ?>

                                        <?php foreach ($aPdtPmtHDCstLevInTmp as $aCstLev) { ?>
                                            <?php if ($aCstLev['FTPmhStaType'] != "1") {
                                                continue;
                                            } ?>
                                            <label><?php echo $aCstLev['FTClvName']; ?></label><br>
                                        <?php } ?>
                                    </td>
                                    <td class="text-left">
                                        <?php foreach ($aPdtPmtHDCstLevInTmp as $aCstLev) { ?>
                                            <?php if ($aCstLev['FTPmhStaType'] != "2") {
                                                continue;
                                            } ?>
                                            <label><?php echo $aCstLev['FTClvName']; ?></label><br>
                                        <?php } ?>
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <!--Section : ตัวอย่างการได้รับโปรโมชั่น-->
        <!-- <div class="panel panel-default" style="margin-bottom: 10px;">
            <div id="odvHeadAllow" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
                <label class="xCNTextDetail1"><?php echo language('document/promotion/promotion', 'ตัวอย่างการได้รับโปรโมชั่น'); ?></label>
            </div>

            <div class="panel-collapse collapse in" role="tabpanel">
                <div class="panel-body xCNPDModlue">
                </div>
            </div>
        </div> -->
    </div>
</div>

<script>
    $(document).ready(function() {
        $('[data-toggle="popover"]').popover();
        $('.selectpicker').selectpicker();

        if (bIsApvOrCancel) {
            $('.xCNApvOrCanCelDisabledCheckAndConfirm').attr('disabled', true);
            $('.xCNApvOrCanCelDisabledCheckAndConfirm').selectpicker('refresh');
        } else {
            $('.xCNApvOrCanCelDisabledCheckAndConfirm').attr('disabled', false);
            $('.xCNApvOrCanCelDisabledCheckAndConfirm').selectpicker('refresh');
        }
    });
</script>