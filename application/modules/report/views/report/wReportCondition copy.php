<?php if (isset($aRptFilterData) && $aRptFilterData['rtCode'] == 1):?>
    <div id="odvCondition<?php echo $aRptFilterData['raItems']['rtRptCode'];?>">
        <div id="odvRptClearCondition" class="row" style="padding-bottom:15px">
            <div class="col-xs-12 col-smd-9 col-md-9 col-lg-9"></div>
            <div class="col-md-3 text-right">
                <button id="obtRptClearCondition" class="btn btn-primary" style="font-size:17px;width:100%;"><?php echo language('report/report/report', 'tRptClearCondition')?></button>
            </div>
        </div>
        <?php $tCoditionReport = "";?>
        <?php foreach ($aRptFilterData['raItems']['raRptFilterCol'] as $nKey => $aRptFilValue):?>
            <?php
                switch ($aRptFilValue['FTRptFltCode']) {
                    case '1': { // Filter Branch (ค้นหาข้อมูลสาขา)
                        $tCoditionReport .= "<div id='odvCondition".$aRptFilValue['FTRptFltCode']."' class='row'>";
                        if ($aRptFilValue['FTRptFltStaFrm'] == '1') {
                            $tCoditionReport .= "
                                <div class='col-xs-12 col-sm-6 col-md-6 col-lg-6'>
                                    <div class='form-group'>
                                        <label class='xCNLabelFrm'>".language('report/report/report', 'tRptCoditionFrom').$aRptFilValue['FTRptFltName']."</label>
                                        <div class='input-group'>
                                            <input type='text' class='form-control xCNHide xWRptAllInput' id='oetRptBchCodeFrom' name='oetRptBchCodeFrom' maxlength='5'>
                                            <input type='text' class='form-control xWPointerEventNone xWRptAllInput' id='oetRptBchNameFrom' name='oetRptBchNameFrom' readonly>
                                            <span class='input-group-btn'>
                                                <button id='obtRptBrowseBchFrom' type='button' class='btn xCNBtnBrowseAddOn'><img class='xCNIconFind'></button>
                                            </span>
                                        </div>
                                    </div>
                                </div> 
                            ";
                        }
                        if ($aRptFilValue['FTRptFltStaTo'] == '1') {
                            $tCoditionReport .= "
                                <div class='col-xs-12 col-sm-6 col-md-6 col-lg-6'>
                                    <div class='form-group'>
                                        <label class='xCNLabelFrm'>".language('report/report/report', 'tRptCoditionTo').$aRptFilValue['FTRptFltName']."</label>
                                        <div class='input-group'>
                                            <input type='text' class='form-control xCNHide xWRptAllInput' id='oetRptBchCodeTo' name='oetRptBchCodeTo' maxlength='5'>
                                            <input type='text' class='form-control xWPointerEventNone xWRptAllInput' id='oetRptBchNameTo' name='oetRptBchNameTo' readonly>
                                            <span class='input-group-btn'>
                                                <button id='obtRptBrowseBchTo' type='button' class='btn xCNBtnBrowseAddOn'><img class='xCNIconFind'></button>
                                            </span>
                                        </div>
                                    </div>
                                </div> 
                            ";
                        }
                        $tCoditionReport .= "</div>";
                        break;
                    }
                    case '2': { // Filter Shop (ค้นหาข้อมูลร้านค้า)
                        $tCoditionReport .= "<div id='odvCondition".$aRptFilValue['FTRptFltCode']."' class='row'>";
                        if ($aRptFilValue['FTRptFltStaFrm'] == '1') {
                            $tCoditionReport .= "
                                <div class='col-xs-12 col-sm-6 col-md-6 col-lg-6'>
                                    <div class='form-group'>
                                        <label class='xCNLabelFrm'>".language('report/report/report', 'tRptCoditionFrom').$aRptFilValue['FTRptFltName']."</label>
                                        <div class='input-group'>
                                            <input type='text' class='form-control xCNHide xWRptAllInput' id='oetRptShpCodeFrom' name='oetRptShpCodeFrom' maxlength='5'>
                                            <input type='text' class='form-control xWPointerEventNone xWRptAllInput' id='oetRptShpNameFrom' name='oetRptShpNameFrom' readonly>
                                            <span class='input-group-btn'>
                                                <button id='obtRptBrowseShpFrom' type='button' class='btn xCNBtnBrowseAddOn'><img class='xCNIconFind'></button>
                                            </span>
                                        </div>
                                    </div>
                                </div> 
                            ";
                        }
                        if ($aRptFilValue['FTRptFltStaTo'] == '1') {
                            $tCoditionReport .= "
                                <div class='col-xs-12 col-sm-6 col-md-6 col-lg-6'>
                                    <div class='form-group'>
                                        <label class='xCNLabelFrm'>".language('report/report/report', 'tRptCoditionTo').$aRptFilValue['FTRptFltName']."</label>
                                        <div class='input-group'>
                                            <input type='text' class='form-control xCNHide xWRptAllInput' id='oetRptShpCodeTo' name='oetRptShpCodeTo' maxlength='5'>
                                            <input type='text' class='form-control xWPointerEventNone xWRptAllInput' id='oetRptShpNameTo' name='oetRptShpNameTo' readonly>
                                            <span class='input-group-btn'>
                                                <button id='obtRptBrowseShpTo' type='button' class='btn xCNBtnBrowseAddOn'><img class='xCNIconFind'></button>
                                            </span>
                                        </div>
                                    </div>
                                </div> 
                            ";
                        }
                        $tCoditionReport .= "</div>";
                        break;
                    }
                    case '3': { // Filter Pos (ค้นหาข้อมูลเครื่องจุดขาย)
                        $tCoditionReport .= "<div id='odvCondition".$aRptFilValue['FTRptFltCode']."' class='row'>";
                        if ($aRptFilValue['FTRptFltStaFrm'] == '1') {
                            $tCoditionReport .= "
                                <div class='col-xs-12 col-sm-6 col-md-6 col-lg-6'>
                                    <div class='form-group'>
                                        <label class='xCNLabelFrm'>".language('report/report/report', 'tRptCoditionFrom').$aRptFilValue['FTRptFltName']."</label>
                                        <div class='input-group'>
                                            <input type='text' class='form-control xCNHide xWRptAllInput' id='oetRptPosCodeFrom' name='oetRptPosCodeFrom' maxlength='5'>
                                            <input type='text' class='form-control xWPointerEventNone xWRptAllInput' id='oetRptPosNameFrom' name='oetRptPosNameFrom' readonly>
                                            <span class='input-group-btn'>
                                                <button id='obtRptBrowsePosFrom' type='button' class='btn xCNBtnBrowseAddOn'><img class='xCNIconFind'></button>
                                            </span>
                                        </div>
                                    </div>
                                </div> 
                            ";
                        }
                        if ($aRptFilValue['FTRptFltStaTo'] == '1') {
                            $tCoditionReport .= "
                                <div class='col-xs-12 col-sm-6 col-md-6 col-lg-6'>
                                    <div class='form-group'>
                                        <label class='xCNLabelFrm'>".language('report/report/report', 'tRptCoditionTo').$aRptFilValue['FTRptFltName']."</label>
                                        <div class='input-group'>
                                            <input type='text' class='form-control xCNHide xWRptAllInput' id='oetRptPosCodeTo' name='oetRptPosCodeTo' maxlength='5'>
                                            <input type='text' class='form-control xWPointerEventNone xWRptAllInput' id='oetRptPosNameTo' name='oetRptPosNameTo' readonly>
                                            <span class='input-group-btn'>
                                                <button id='obtRptBrowsePosTo' type='button' class='btn xCNBtnBrowseAddOn'><img class='xCNIconFind'></button>
                                            </span>
                                        </div>
                                    </div>
                                </div> 
                            ";
                        }
                        $tCoditionReport .= "</div>";
                        break;
                    }
                    case '4': { // Filter Doc Date (วันที่สร้างเอกสาร)
                        $tCoditionReport .= "<div id='odvCondition".$aRptFilValue['FTRptFltCode']."' class='row'>";
                        if ($aRptFilValue['FTRptFltStaFrm'] == '1') {
                            $tCoditionReport .= "
                                <div class='col-xs-12 col-sm-6 col-md-6 col-lg-6'>
                                    <div class='form-group'>
                                        <label class='xCNLabelFrm'>".language('report/report/report', 'tRptCoditionFrom').$aRptFilValue['FTRptFltName']."</label>
                                        <div class='input-group'>
                                            <input type='text' class='form-control xCNDatePicker xCNInputMaskDate xWRptAllInput' id='oetRptDocDateFrom' name='oetRptDocDateFrom'>
                                            <span class='input-group-btn'>
                                                <button id='obtRptBrowseDocDateFrom' type='button' class='btn xCNBtnDateTime'><img class='xCNIconCalendar'></button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            ";
                        }
                        if ($aRptFilValue['FTRptFltStaTo'] == '1') {
                            $tCoditionReport .= "
                                <div class='col-xs-12 col-sm-6 col-md-6 col-lg-6'>
                                    <div class='form-group'>
                                        <label class='xCNLabelFrm'>".language('report/report/report', 'tRptCoditionTo').$aRptFilValue['FTRptFltName']."</label>
                                        <div class='input-group'>
                                            <input type='text' class='form-control xCNDatePicker xCNInputMaskDate xWRptAllInput' id='oetRptDocDateTo' name='oetRptDocDateTo'>
                                            <span class='input-group-btn'>
                                                <button id='obtRptBrowseDocDateTo' type='button' class='btn xCNBtnDateTime'><img class='xCNIconCalendar'></button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            ";
                        }
                        $tCoditionReport .= "</div>";
                        break;
                    }
                    case '5': { // Filter Year (ปี)
                        $dDateDefult    = date("Y");
                        $tCoditionReport .= "<div id='odvCondition".$aRptFilValue['FTRptFltCode']."' class='row'>";
                        if ($aRptFilValue['FTRptFltStaFrm'] == '1' || $aRptFilValue['FTRptFltStaTo'] == '1'){
                            $tCoditionReport .= "
                                <div class='col-xs-12 col-sm-6 col-md-6 col-lg-6'>
                                    <div class='form-group'>
                                        <label class='xCNLabelFrm'>".$aRptFilValue['FTRptFltName']."</label>
                                        <div class='input-group'>
                                            <input type='text' class='form-control xCNYearPicker xWRptAllInput' id='oetRptYear' name='oetRptYear' value='".$dDateDefult."'>
                                            <span class='input-group-btn'>
                                                <button id='obtRptBrowseYear' type='button' class='btn xCNBtnDateTime'><img class='xCNIconCalendar'></button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            ";
                        }
                        $tCoditionReport .= "</div>";
                        break;
                    }
                    case '6': { // From - To MerChant Group (ค้นหาข้อมูลกลุ่มธุรกิจ จาก - ถึง)
                        $tCoditionReport .= "<div id='odvCondition".$aRptFilValue['FTRptFltCode']."' class='row'>";
                        if ($aRptFilValue['FTRptFltStaFrm'] == '1') {
                            $tCoditionReport .= "
                                <div class='col-xs-12 col-sm-6 col-md-6 col-lg-6'>
                                    <div class='form-group'>
                                        <label class='xCNLabelFrm'>".language('report/report/report', 'tRptCoditionFrom').$aRptFilValue['FTRptFltName']."</label>
                                        <div class='input-group'>
                                            <input type='text' class='form-control xCNHide xWRptAllInput' id='oetRptMerCodeFrom' name='oetRptMerCodeFrom' maxlength='5'>
                                            <input type='text' class='form-control xWPointerEventNone xWRptAllInput' id='oetRptMerNameFrom' name='oetRptMerNameFrom' readonly>
                                            <span class='input-group-btn'>
                                                <button id='obtRptBrowseMerFrom' type='button' class='btn xCNBtnBrowseAddOn'> <img class='xCNIconFind'></button>
                                            </span>
                                        </div>
                                    </div>
                                </div> 
                            ";
                        }
                        if ($aRptFilValue['FTRptFltStaTo'] == '1') {
                            $tCoditionReport .= "
                                <div class='col-xs-12 col-sm-6 col-md-6 col-lg-6'>
                                    <div class='form-group'>
                                        <label class='xCNLabelFrm'>".language('report/report/report', 'tRptCoditionTo').$aRptFilValue['FTRptFltName']."</label>
                                        <div class='input-group'>
                                            <input type='text' class='form-control xCNHide xWRptAllInput' id='oetRptMerCodeTo' name='oetRptMerCodeTo' maxlength='5'>
                                            <input type='text' class='form-control xWPointerEventNone xWRptAllInput' id='oetRptMerNameTo' name='oetRptMerNameTo' readonly>
                                            <span class='input-group-btn'>
                                                <button id='obtRptBrowseMerTo' type='button' class='btn xCNBtnBrowseAddOn'><img class='xCNIconFind'></button>
                                            </span>
                                        </div>
                                    </div>
                                </div> 
                            ";
                        }
                        $tCoditionReport .= "</div>";
                        break;
                    }
                    case '7': { // From - To PaymentType Group (ค้นหาข้อมูลประเภทการชำระ จาก - ถึง)
                        $tCoditionReport .= "<div id='odvCondition".$aRptFilValue['FTRptFltCode']."' class='row'>";
                        if ($aRptFilValue['FTRptFltStaFrm'] == '1') {
                            $tCoditionReport .= "
                                <div class='col-xs-12 col-sm-6 col-md-6 col-lg-6'>
                                    <div class='form-group'>
                                        <label class='xCNLabelFrm'>".language('report/report/report', 'tRptCoditionFrom').$aRptFilValue['FTRptFltName']."</label>
                                        <div class='input-group'>
                                            <input type='text' class='form-control xCNHide xWRptAllInput' id='oetRptRcvCodeFrom' name='oetRptRcvCodeFrom' maxlength='5'>
                                            <input type='text' class='form-control xWPointerEventNone xWRptAllInput' id='oetRptRcvNameFrom' name='oetRptRcvNameFrom' readonly>
                                            <span class='input-group-btn'>
                                                <button id='obtRptBrowseRcvFrom' type='button' class='btn xCNBtnBrowseAddOn'> <img class='xCNIconFind'></button>
                                            </span>
                                        </div>
                                    </div>
                                </div> 
                            ";
                        }
                        if ($aRptFilValue['FTRptFltStaTo'] == '1') {
                            $tCoditionReport .= "
                                <div class='col-xs-12 col-sm-6 col-md-6 col-lg-6'>
                                    <div class='form-group'>
                                        <label class='xCNLabelFrm'>".language('report/report/report', 'tRptCoditionTo').$aRptFilValue['FTRptFltName']."</label>
                                        <div class='input-group'>
                                            <input type='text' class='form-control xCNHide xWRptAllInput' id='oetRptRcvCodeTo' name='oetRptRcvCodeTo' maxlength='5'>
                                            <input type='text' class='form-control xWPointerEventNone xWRptAllInput' id='oetRptRcvNameTo' name='oetRptRcvNameTo' readonly>
                                            <span class='input-group-btn'>
                                                <button id='obtRptBrowseRcvTo' type='button' class='btn xCNBtnBrowseAddOn'><img class='xCNIconFind'></button>
                                            </span>
                                        </div>
                                    </div>
                                </div> 
                            ";
                        }
                        $tCoditionReport .= "</div>";
                        break;
                    }
                    case '8': { // From - To Product  Group (ค้นหาข้อมูลกลุ่มสินค้า จาก - ถึง)
                        $tCoditionReport .= "<div id='odvCondition".$aRptFilValue['FTRptFltCode']."' class='row'>";
                        if ($aRptFilValue['FTRptFltStaFrm'] == '1') {
                            $tCoditionReport .= "
                                <div class='col-xs-12 col-sm-6 col-md-6 col-lg-6'>
                                    <div class='form-group'>
                                        <label class='xCNLabelFrm'>".language('report/report/report', 'tRptCoditionFrom').$aRptFilValue['FTRptFltName']."</label>
                                        <div class='input-group'>
                                            <input type='text' class='form-control xCNHide xWRptAllInput' id='oetRptPdtGrpCodeFrom' name='oetRptPdtGrpCodeFrom' maxlength='5'>
                                            <input type='text' class='form-control xWPointerEventNone xWRptAllInput' id='oetRptPdtGrpNameFrom' name='oetRptPdtGrpNameFrom' readonly>
                                            <span class='input-group-btn'>
                                                <button id='obtRptBrowsePdtGrpFrom' type='button' class='btn xCNBtnBrowseAddOn'> <img class='xCNIconFind'></button>
                                            </span>
                                        </div>
                                    </div>
                                </div> 
                            ";
                        }
                        if ($aRptFilValue['FTRptFltStaTo'] == '1') {
                            $tCoditionReport .= "
                                <div class='col-xs-12 col-sm-6 col-md-6 col-lg-6'>
                                    <div class='form-group'>
                                        <label class='xCNLabelFrm'>".language('report/report/report', 'tRptCoditionTo').$aRptFilValue['FTRptFltName']."</label>
                                        <div class='input-group'>
                                            <input type='text' class='form-control xCNHide xWRptAllInput' id='oetRptPdtGrpCodeTo' name='oetRptPdtGrpCodeTo' maxlength='5'>
                                            <input type='text' class='form-control xWPointerEventNone xWRptAllInput' id='oetRptPdtGrpNameTo' name='oetRptPdtGrpNameTo' readonly>
                                            <span class='input-group-btn'>
                                                <button id='obtRptBrowsePdtGrpTo' type='button' class='btn xCNBtnBrowseAddOn'><img class='xCNIconFind'></button>
                                            </span>
                                        </div>
                                    </div>
                                </div> 
                            ";
                        }
                        $tCoditionReport .= "</div>";
                        break;
                    }
                    case '9': { // From - To Product Type (ค้นหาข้อมูลประเภทสินค้า จาก - ถึง)
                        $tCoditionReport .= "<div id='odvCondition".$aRptFilValue['FTRptFltCode']."' class='row'>";
                        if ($aRptFilValue['FTRptFltStaFrm'] == '1') {
                            $tCoditionReport .= "
                                <div class='col-xs-12 col-sm-6 col-md-6 col-lg-6'>
                                    <div class='form-group'>
                                        <label class='xCNLabelFrm'>".language('report/report/report', 'tRptCoditionFrom').$aRptFilValue['FTRptFltName']."</label>
                                        <div class='input-group'>
                                            <input type='text' class='form-control xCNHide xWRptAllInput' id='oetRptPdtTypeCodeFrom' name='oetRptPdtTypeCodeFrom' maxlength='5'>
                                            <input type='text' class='form-control xWPointerEventNone xWRptAllInput' id='oetRptPdtTypeNameFrom' name='oetRptPdtTypeNameFrom' readonly>
                                            <span class='input-group-btn'>
                                                <button id='obtRptBrowsePdtTypeFrom' type='button' class='btn xCNBtnBrowseAddOn'> <img class='xCNIconFind'></button>
                                            </span>
                                        </div>
                                    </div>
                                </div> 
                            ";
                        }
                        if ($aRptFilValue['FTRptFltStaTo'] == '1') {
                            $tCoditionReport .= "
                                <div class='col-xs-12 col-sm-6 col-md-6 col-lg-6'>
                                    <div class='form-group'>
                                        <label class='xCNLabelFrm'>".language('report/report/report', 'tRptCoditionTo').$aRptFilValue['FTRptFltName']."</label>
                                        <div class='input-group'>
                                            <input type='text' class='form-control xCNHide xWRptAllInput' id='oetRptPdtTypeCodeTo' name='oetRptPdtTypeCodeTo' maxlength='5'>
                                            <input type='text' class='form-control xWPointerEventNone xWRptAllInput' id='oetRptPdtTypeNameTo' name='oetRptPdtTypeNameTo' readonly>
                                            <span class='input-group-btn'>
                                                <button id='obtRptBrowsePdtTypeTo' type='button' class='btn xCNBtnBrowseAddOn'><img class='xCNIconFind'></button>
                                            </span>
                                        </div>
                                    </div>
                                </div> 
                            ";
                        }
                        $tCoditionReport .= "</div>";
                        break;
                    }
                    case '10': { // Product Type (ค้นหาข้อมูลประเภทสินค้า)
                        $tCoditionReport .= "<div id='odvCondition".$aRptFilValue['FTRptFltCode']."' class='row'>";
                        if ($aRptFilValue['FTRptFltStaFrm'] == '1' || $aRptFilValue['FTRptFltStaTo'] == '1' ) {
                            $tCoditionReport    .= "
                                <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                                    <div class='form-group'>
                                        <label class='xCNLabelFrm'>".language('product/pdttype/pdttype', 'tPGPPdttypeFrom').$aRptFilValue['FTRptFltName']."</label>
                                        <div class='input-group xWInputGrpPriority' style='width:100%'>
                                        <select class='selectpicker ' id='ocmBchPriority' name='ocmBchPriority'>
                                            <option value='5'>5</option>
                                            <option value='10'>10</option>
                                            <option value='20'>20</option>
                                            <option value='50'>50</option>
                                            <option value='10'>100</option>
                                            <option value='200'>200</option>
                                            <option value='500'>500</option>
                                        </select>                                       
                                        </div>
                                    </div>
                                </div> 
                            ";
                        }
                        $tCoditionReport .= "</div>";
                        break;
                    }
                    case '11': { // Merchant (ค้นหาข้อมูลกลุ่มธุรกิจ) เดี่ยว ไม่มี จาก - ถึง
                        $tCoditionReport    .= "<div id='odvCondition".$aRptFilValue['FTRptFltCode']."' class='row'>";
                        if (($aRptFilValue['FTRptFltStaFrm'] == '1' && $aRptFilValue['FTRptFltStaTo'] == '0') || ($aRptFilValue['FTRptFltStaFrm'] == '0' && $aRptFilValue['FTRptFltStaTo'] == '1')) {
                            $tCoditionReport    .= "
                                <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                                    <div class='form-group'>
                                        <label class='xCNLabelFrm'>".$aRptFilValue['FTRptFltName']."</label>
                                        <div class='input-group'>
                                            <input type='text' class='form-control xCNHide xWRptAllInput' id='oetRptMerchantCode' name='oetRptMerchantCode' maxlength='5'>
                                            <input type='text' class='form-control xWPointerEventNone xWRptAllInput' id='oetRptMerchantName' name='oetRptMerchantName' readonly>
                                            <span class='input-group-btn'>
                                                <button id='obtRptBrowseMerchant' type='button' class='btn xCNBtnBrowseAddOn'> <img class='xCNIconFind'></button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            ";
                        }
                        $tCoditionReport .= "</div>";
                        break;
                    }
                    case '12': { // WareHouse (ค้นหาข้อมูลคลังสินค้า)
                        $tCoditionReport .= "<div id='odvCondition".$aRptFilValue['FTRptFltCode']."' class='row'>";
                        if ($aRptFilValue['FTRptFltStaFrm'] == '1') {
                            $tCoditionReport .= "
                                <div class='col-xs-12 col-sm-6 col-md-6 col-lg-6'>
                                    <div class='form-group'>
                                        <label class='xCNLabelFrm'>".language('report/report/report', 'tRptCoditionFrom').$aRptFilValue['FTRptFltName']."</label>
                                        <div class='input-group'>
                                            <input type='text' class='form-control xCNHide xWRptAllInput' id='oetRptWahCodeFrom' name='oetRptWahCodeFrom' maxlength='5'>
                                            <input type='text' class='form-control xWPointerEventNone xWRptAllInput' id='oetRptWahNameFrom' name='oetRptWahNameFrom' readonly>
                                            <span class='input-group-btn'>
                                                <button id='obtRptBrowseWahFrom' type='button' class='btn xCNBtnBrowseAddOn'> <img class='xCNIconFind'></button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            ";
                        }
                        if ($aRptFilValue['FTRptFltStaTo'] == '1') {
                            $tCoditionReport .= "
                                <div class='col-xs-12 col-sm-6 col-md-6 col-lg-6'>
                                    <div class='form-group'>
                                        <label class='xCNLabelFrm'>".language('report/report/report', 'tRptCoditionTo').$aRptFilValue['FTRptFltName']."</label>
                                        <div class='input-group'>
                                            <input type='text' class='form-control xCNHide xWRptAllInput' id='oetRptWahCodeTo' name='oetRptWahCodeTo' maxlength='5'>
                                            <input type='text' class='form-control xWPointerEventNone xWRptAllInput' id='oetRptWahNameTo' name='oetRptWahNameTo' readonly>
                                            <span class='input-group-btn'>
                                                <button id='obtRptBrowseWahTo' type='button' class='btn xCNBtnBrowseAddOn'><img class='xCNIconFind'></button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            ";
                        }
                        $tCoditionReport .= "</div>";
                        break;
                    }
                    case '13': { // Product (ค้นหาข้อมูลสินค้า)
                        $tCoditionReport .= "<div id='odvCondition".$aRptFilValue['FTRptFltCode']."' class='row'>";
                        if ($aRptFilValue['FTRptFltStaFrm'] == '1') {
                            $tCoditionReport .= "
                                <div class='col-xs-12 col-sm-6 col-md-6 col-lg-6'>
                                    <div class='form-group'>
                                        <label class='xCNLabelFrm'>".language('report/report/report', 'tRptCoditionFrom').$aRptFilValue['FTRptFltName']."</label>
                                        <div class='input-group'>
                                            <input type='text' class='form-control xCNHide xWRptAllInput' id='oetRptPdtCodeFrom' name='oetRptPdtCodeFrom' maxlength='5'>
                                            <input type='text' class='form-control xWPointerEventNone xWRptAllInput' id='oetRptPdtNameFrom' name='oetRptPdtNameFrom' readonly>
                                            <span class='input-group-btn'>
                                                <button id='obtRptBrowsePdtFrom' type='button' class='btn xCNBtnBrowseAddOn'> <img class='xCNIconFind'></button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            ";
                        }
                        if ($aRptFilValue['FTRptFltStaTo'] == '1') {
                            $tCoditionReport .= "
                                <div class='col-xs-12 col-sm-6 col-md-6 col-lg-6'>
                                    <div class='form-group'>
                                        <label class='xCNLabelFrm'>".language('report/report/report', 'tRptCoditionTo').$aRptFilValue['FTRptFltName']."</label>
                                        <div class='input-group'>
                                            <input type='text' class='form-control xCNHide xWRptAllInput' id='oetRptPdtCodeTo' name='oetRptPdtCodeTo' maxlength='5'>
                                            <input type='text' class='form-control xWPointerEventNone xWRptAllInput' id='oetRptPdtNameTo' name='oetRptPdtNameTo' readonly>
                                            <span class='input-group-btn'>
                                                <button id='obtRptBrowsePdtTo' type='button' class='btn xCNBtnBrowseAddOn'><img class='xCNIconFind'></button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            ";
                        }
                        $tCoditionReport .= "</div>";
                        break;
                    }
                    case '14': { // บริษัท ขนส่ง
                        $tCoditionReport .= "<div id='odvCondition".$aRptFilValue['FTRptFltCode']."' class='row'>";
                        if ($aRptFilValue['FTRptFltStaFrm'] == '1') {
                            $tCoditionReport .= "
                                <div class='col-xs-12 col-sm-6 col-md-6 col-lg-6'>
                                    <div class='form-group'>
                                        <label class='xCNLabelFrm'>".language('report/report/report', 'tRptCoditionFrom').$aRptFilValue['FTRptFltName']."</label>
                                        <div class='input-group'>
                                            <input type='text' class='form-control xCNHide xWRptAllInput' id='oetRptCourierCodeFrom' name='oetRptCourierCodeFrom' maxlength='5'>
                                            <input type='text' class='form-control xWPointerEventNone xWRptAllInput' id='oetRptCourierNameFrom' name='oetRptCourierNameFrom' readonly>
                                            <span class='input-group-btn'>
                                                <button id='obtRptBrowseCourierFrom' type='button' class='btn xCNBtnBrowseAddOn'> <img class='xCNIconFind'></button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            ";
                        }
                        if ($aRptFilValue['FTRptFltStaTo'] == '1') {
                            $tCoditionReport .= "
                                <div class='col-xs-12 col-sm-6 col-md-6 col-lg-6'>
                                    <div class='form-group'>
                                        <label class='xCNLabelFrm'>".language('report/report/report', 'tRptCoditionTo').$aRptFilValue['FTRptFltName']."</label>
                                        <div class='input-group'>
                                            <input type='text' class='form-control xCNHide xWRptAllInput' id='oetRptCourierCodeTo' name='oetRptCourierCodeTo' maxlength='5'>
                                            <input type='text' class='form-control xWPointerEventNone xWRptAllInput' id='oetRptCourierNameTo' name='oetRptCourierNameTo' readonly>
                                            <span class='input-group-btn'>
                                                <button id='obtRptBrowseCourierTo' type='button' class='btn xCNBtnBrowseAddOn'><img class='xCNIconFind'></button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            ";
                        }
                        $tCoditionReport .= "</div>";
                        break;
                    }
                    case '15': { // ตู้ฝากของ Rack
                        $tCoditionReport .= "<div id='odvCondition".$aRptFilValue['FTRptFltCode']."' class='row'>";
                        if ($aRptFilValue['FTRptFltStaFrm'] == '1') {
                            $tCoditionReport .= "
                                <div class='col-xs-12 col-sm-6 col-md-6 col-lg-6'>
                                    <div class='form-group'>
                                        <label class='xCNLabelFrm'>".language('report/report/report', 'tRptCoditionFrom').$aRptFilValue['FTRptFltName']."</label>
                                        <div class='input-group'>
                                            <input type='text' class='form-control xCNHide xWRptAllInput' id='oetSMLBrowseGroupCodeFrom' name='oetSMLBrowseGroupCodeFrom' maxlength='5'>
                                            <input type='text' class='form-control xWPointerEventNone xWRptAllInput' id='oetSMLBrowseGroupNameFrom' name='oetSMLBrowseGroupNameFrom' readonly>
                                            <span class='input-group-btn'>
                                                <button id='obtSMLBrowseGroupFrom' type='button' class='btn xCNBtnBrowseAddOn'> <img class='xCNIconFind'></button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            ";
                        }
                        if ($aRptFilValue['FTRptFltStaTo'] == '1') {
                            $tCoditionReport .= "
                                <div class='col-xs-12 col-sm-6 col-md-6 col-lg-6'>
                                    <div class='form-group'>
                                        <label class='xCNLabelFrm'>".language('report/report/report', 'tRptCoditionTo').$aRptFilValue['FTRptFltName']."</label>
                                        <div class='input-group'>
                                            <input type='text' class='form-control xCNHide xWRptAllInput' id='oetSMLBrowseGroupCodeTo' name='oetSMLBrowseGroupCodeTo' maxlength='5'>
                                            <input type='text' class='form-control xWPointerEventNone xWRptAllInput' id='oetSMLBrowseGroupNameTo' name='oetSMLBrowseGroupNameTo' readonly>
                                            <span class='input-group-btn'>
                                                <button id='obtSMLBrowseGroupTo' type='button' class='btn xCNBtnBrowseAddOn'><img class='xCNIconFind'></button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            ";
                        }
                        $tCoditionReport .= "</div>";
                        break;
                    }
                    // ยกมาจาก Pandora
                    // Create By Witsarut 24/10/2019
                    case '16': { // หมายเลขบัตร
                        // จากหมายเลขบัตร
                        $tCoditionReport .= "<div id='odvCondition".$aRptFilValue['FTRptFltCode']."' class='row'>";
                        if ($aRptFilValue['FTRptFltStaFrm'] == '1') {
                            $tCoditionReport .= "
                                <div class='col-xs-12 col-sm-6 col-md-6 col-lg-6'>
                                    <div class='form-group'>
                                        <label class='xCNLabelFrm'>".language('report/report/report', 'tRptCoditionFrom').$aRptFilValue['FTRptFltName']."</label>
                                        <div class='input-group'>
                                            <input type='text' class='form-control xCNHide xWRptAllInput' id='oetRptCardCodeFrom' name='oetRptCardCodeFrom' maxlength='5'>
                                            <input type='text' class='form-control xWPointerEventNone xWRptAllInput' id='oetRptCardNameFrom' name='oetRptCardNameFrom' readonly>
                                            <span class='input-group-btn'>
                                                <button id='obtRPCBrowseCardFrom' type='button' class='btn xCNBtnBrowseAddOn'> <img class='xCNIconFind'></button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            ";
                        }
                        // ถึงหมายเลขบัตร
                        if ($aRptFilValue['FTRptFltStaTo'] == '1') {
                            $tCoditionReport .= "  
                                <div class='col-xs-12 col-sm-6 col-md-6 col-lg-6'>
                                    <div class='form-group'>
                                        <label class='xCNLabelFrm'>".language('report/report/report', 'tRptCoditionTo').$aRptFilValue['FTRptFltName']."</label>
                                        <div class='input-group'>
                                            <input type='text' class='form-control xCNHide xWRptAllInput' id='oetRptCardCodeTo' name='oetRptCardCodeTo' maxlength='5'>
                                            <input type='text' class='form-control xWPointerEventNone xWRptAllInput' id='oetRptCardNameTo' name='oetRptCardNameTo' readonly>
                                            <span class='input-group-btn'>
                                                <button id='obtRPCBrowseCardTo' type='button' class='btn xCNBtnBrowseAddOn'><img class='xCNIconFind'></button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            ";
                        }
                        $tCoditionReport .= "</div>";
                        break;
                    }
                    // ยกมาจาก Pandora
                    // Create By saharat(GolF) 25/10/2019
                    case '17': { // ประเภทบัตร
                        // จากประเภทบัตร
                        $tCoditionReport .= "<div id='odvCondition".$aRptFilValue['FTRptFltCode']."' class='row'>";
                        if ($aRptFilValue['FTRptFltStaFrm'] == '1') {
                            $tCoditionReport .= "
                                <div class='col-xs-12 col-sm-6 col-md-6 col-lg-6'>
                                    <div class='form-group'>
                                        <label class='xCNLabelFrm'>".language('report/report/report', 'tRptCoditionFrom').$aRptFilValue['FTRptFltName']."</label>
                                        <div class='input-group'>
                                            <input class='form-control xCNHide xWRptConsCrdInput' id='oetRptCardTypeCodeFrom' name='oetRptCardTypeCodeFrom' maxlength='5' value=''>
                                            <input class='form-control xWPointerEventNone xWRptConsCrdInput' type='text' id='oetRptCardTypeNameFrom' name='oetRptCardTypeNameFrom' value='' readonly=''>
                                            <span class='input-group-btn'>
                                            <button id='obtRPCBrowseCardTypeFrom' type='button' class='btn xCNBtnBrowseAddOn'>
                                                <img class='xCNIconFind'>
                                            </button>
                                        </span>
                                        </div>
                                    </div>
                                </div>
                            ";
                        }
                        // ถึงประเภทบัตร
                        if ($aRptFilValue['FTRptFltStaTo'] == '1') {
                            $tCoditionReport .= "  
                                <div class='col-xs-12 col-sm-6 col-md-6 col-lg-6'>
                                    <div class='form-group'>
                                        <label class='xCNLabelFrm'>".language('report/report/report', 'tRptCoditionTo').$aRptFilValue['FTRptFltName']."</label>
                                        <div class='input-group'>
                                        <input class='form-control xCNHide xWRptConsCrdInput' id='oetRptCardTypeCodeTo' name='oetRptCardTypeCodeTo' maxlength='5' value=''>
                                        <input class='form-control xWPointerEventNone xWRptConsCrdInput' type='text' id='oetRptCardTypeNameTo' name='oetRptCardTypeNameTo' value='' readonly=''>
                                        <span class='input-group-btn'>
                                            <button id='obtRPCBrowseCardTypeTo' type='button' class='btn xCNBtnBrowseAddOn'>
                                                <img class='xCNIconFind'>
                                            </button>
                                        </span>
                                        </div>
                                    </div>
                                </div>
                            ";
                        }
                        $tCoditionReport .= "</div>";
                        break;
                    }
                    // Create By saharat(GolF) 28/10/2019
                    case '18': { // สถานะบัตร
                        // จากสถานะบัตร
                        $tCoditionReport .= "<div id='odvCondition".$aRptFilValue['FTRptFltCode']."' class='row'>";
                        if ($aRptFilValue['FTRptFltStaFrm'] == '1') {
                            $tCoditionReport .= "
                                    <div class='col-xs-12 col-sm-6 col-md-6 col-lg-6'>
                                        <div class='form-group'>
                                            <input type='hidden' name='ohdRptStaCardNameFrom' id='ohdRptStaCardNameFrom' value=''/>
                                            <label class='xCNLabelFrm'>".language('report/report/report', 'tRptCoditionFrom').$aRptFilValue['FTRptFltName']."</label>
                                            <select class='selectpicker-crd-sta-from form-control' id='ocmRptStaCardFrom' name='ocmRptStaCardFrom' maxlength='1'>
                                                <option value=''>".language('report/report/report', 'tCMNBlank-NA')."</option>
                                                <option value='1'>".language('report/report/report', 'tRPCCardDetailStaActive1')."</option>
                                                <option value='2'>".language('report/report/report', 'tRPCCardDetailStaActive2')."</option>
                                                <option value='3'>".language('report/report/report', 'tRPCCardDetailStaActive3')."</option>
                                            </select>
                                        </div>
                                    </div>
                                ";
                        }
                        // ถึงสถานะบัตร
                        if ($aRptFilValue['FTRptFltStaTo'] == '1') {
                            $tCoditionReport .= "  
                                    <div class='col-xs-12 col-sm-6 col-md-6 col-lg-6'>
                                        <div class='form-group'>
                                            <input type='hidden' name='ohdRptStaCardNameTo' id='ohdRptStaCardNameTo' value=''/>
                                            <label class='xCNLabelFrm'>".language('report/report/report', 'tRptCoditionTo').$aRptFilValue['FTRptFltName']."</label>
                                            <select class='selectpicker-crd-sta-to form-control' id='ocmRptStaCardTo' name='ocmRptStaCardTo' maxlength='1'>
                                                <option value=''>".language('report/report/report', 'tCMNBlank-NA')."</option>
                                                <option value='1'>".language('report/report/report', 'tRPCCardDetailStaActive1')."</option>
                                                <option value='2'>".language('report/report/report', 'tRPCCardDetailStaActive2')."</option>
                                                <option value='3'>".language('report/report/report', 'tRPCCardDetailStaActive3')."</option>
                                            </select>
                                        </div>
                                    </div>
                                ";
                        }
                        $tCoditionReport .= "</div>";
                        break;
                    }
                    // Create By saharat(GolF) 28/10/2019
                    case '19': { // รหัสพนักงาน
                        // จากรหัสพนักงาน
                        $tCoditionReport .= "<div id='odvCondition".$aRptFilValue['FTRptFltCode']."' class='row'>";
                        if ($aRptFilValue['FTRptFltStaFrm'] == '1') {
                            $tCoditionReport .= "
                                <div class='col-xs-12 col-sm-6 col-md-6 col-lg-6'>
                                    <div class='form-group'>
                                        <label class='xCNLabelFrm'>".language('report/report/report', 'tRPC13TBCardHolderID').$aRptFilValue['FTRptFltName']."</label>
                                        <div class='input-group'>
                                            <input type='text' class='form-control xCNHide xWRptAllInput' id='oetRptEmpCodeFrom' name='oetRptEmpCodeFrom' maxlength='5' value=''>
                                            <input type='text' class='form-control xWPointerEventNone xWRptConsCrdInput' id='oetRptEmpNameFrom' name='oetRptEmpNameFrom' value='' readonly=''>
                                            <span class='input-group-btn'>
                                            <button id='oimRPCBrowseEmp' type='button' class='btn xCNBtnBrowseAddOn'>
                                                <img class='xCNIconFind'>
                                            </button>
                                        </span>
                                    </div>
                                    </div>
                                </div>
                            ";
                        }
                        // ถึงรหัสพนักงาน
                        if ($aRptFilValue['FTRptFltStaTo'] == '1') {
                            $tCoditionReport .= "  
                                <div class='col-xs-12 col-sm-6 col-md-6 col-lg-6'>
                                    <div class='form-group'>
                                        <label class='xCNLabelFrm'>".language('report/report/report', 'tRPC13TBCardHolderID').$aRptFilValue['FTRptFltName']."</label>
                                        <div class='input-group'>
                                            <input type='text' class='form-control xCNHide xWRptAllInput' id='oetRptEmpCodeTo' name='oetRptEmpCodeTo' maxlength='5' value=''>
                                            <input type='text' class='form-control xWPointerEventNone xWRptConsCrdInput' id='oetRptEmpNameTo' name='oetRptEmpNameTo' value='' readonly=''>
                                            <span class='input-group-btn'>
                                            <button id='oimRPCBrowseEmpTo' type='button' class='btn xCNBtnBrowseAddOn'>
                                                <img class='xCNIconFind'>
                                            </button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            ";
                        }
                        $tCoditionReport .= "</div>";
                        break;
                    }  
                    case '20': { // วันที่เริ่มใช้งานบัตร
                        $tCoditionReport .= "<div id='odvCondition".$aRptFilValue['FTRptFltCode']."' class='row'>";
                        if ($aRptFilValue['FTRptFltStaFrm'] == '1') {
                            $tCoditionReport .= "
                            <div class='col-xs-12 col-sm-6 col-md-6 col-lg-6'>
                                <div class='form-group'>
                                    <label class='xCNLabelFrm'>".language('report/report/report', 'tRptCoditionFrom').$aRptFilValue['FTRptFltName']."</label>
                                    <div class='input-group'>
                                        <input type='text' class='form-control xCNDatePicker xCNInputMaskDate xWRptAllInput' id='oetRptDateStartFrom' name='oetRptDateStartFrom'>
                                        <span class='input-group-btn'>
                                            <button id='obtRptBrowseDateStartFrom' type='button' class='btn xCNBtnDateTime'><img class='xCNIconCalendar'></button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        ";
                        }
                        if ($aRptFilValue['FTRptFltStaTo'] == '1') {
                            $tCoditionReport .= "
                            <div class='col-xs-12 col-sm-6 col-md-6 col-lg-6'>
                                <div class='form-group'>
                                    <label class='xCNLabelFrm'>".language('report/report/report', 'tRptCoditionTo').$aRptFilValue['FTRptFltName']."</label>
                                    <div class='input-group'>
                                        <input type='text' class='form-control xCNDatePicker xCNInputMaskDate xWRptAllInput' id='oetRptDateStartTo' name='oetRptDateStartTo'>
                                        <span class='input-group-btn'>
                                            <button id='obtRptBrowseDateStartTo' type='button' class='btn xCNBtnDateTime'><img class='xCNIconCalendar'></button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        ";
                        }
                        $tCoditionReport .= "</div>";
                        break;
                    }
                    case '21': { // วันที่บัตรหมดอายุ
                        $tCoditionReport .= "<div id='odvCondition".$aRptFilValue['FTRptFltCode']."' class='row'>";
                        if ($aRptFilValue['FTRptFltStaFrm'] == '1') {
                            $tCoditionReport .= "
                            <div class='col-xs-12 col-sm-6 col-md-6 col-lg-6'>
                                <div class='form-group'>
                                    <label class='xCNLabelFrm'>".language('report/report/report', 'tRptCoditionFrom').$aRptFilValue['FTRptFltName']."</label>
                                    <div class='input-group'>
                                        <input type='text' class='form-control xCNDatePicker xCNInputMaskDate xWRptAllInput' id='oetRptDateExpireFrom' name='oetRptDateExpireFrom'>
                                        <span class='input-group-btn'>
                                            <button id='obtRptBrowseDateExpireFrom' type='button' class='btn xCNBtnDateTime'><img class='xCNIconCalendar'></button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        ";
                        }
                        if ($aRptFilValue['FTRptFltStaTo'] == '1') {
                            $tCoditionReport .= "
                            <div class='col-xs-12 col-sm-6 col-md-6 col-lg-6'>
                                <div class='form-group'>
                                    <label class='xCNLabelFrm'>".language('report/report/report', 'tRptCoditionTo').$aRptFilValue['FTRptFltName']."</label>
                                    <div class='input-group'>
                                        <input type='text' class='form-control xCNDatePicker xCNInputMaskDate xWRptAllInput' id='oetRptDateExpireTo' name='oetRptDateExpireTo'>
                                        <span class='input-group-btn'>
                                            <button id='obtRptBrowseDateExpireTo' type='button' class='btn xCNBtnDateTime'><img class='xCNIconCalendar'></button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        ";
                        }
                        $tCoditionReport .= "</div>";
                        break;
                    }
                    case '22': { // ประเภทบัตรเดิม
                        // จากประเภทบัตรเดิม
                        $tCoditionReport .= "<div id='odvCondition".$aRptFilValue['FTRptFltCode']."' class='row'>";
                        if ($aRptFilValue['FTRptFltStaFrm'] == '1') {
                            $tCoditionReport .= "
                                <div class='col-xs-12 col-sm-6 col-md-6 col-lg-6'>
                                    <div class='form-group'>
                                        <label class='xCNLabelFrm'>".language('report/report/report', 'tRptCoditionFrom').$aRptFilValue['FTRptFltName']."</label>
                                        <div class='input-group'>
                                            <input class='form-control xCNHide xWRptConsCrdInput' id='oetRptCardTypeCodeOldFrom' name='oetRptCardTypeCodeOldFrom' maxlength='5' value=''>
                                            <input class='form-control xWPointerEventNone xWRptConsCrdInput' type='text' id='oetRptCardTypeNameOldFrom' name='oetRptCardTypeNameOldFrom' value='' readonly=''>
                                            <span class='input-group-btn'>
                                            <button id='obtRPCBrowseCardTypeOldFrom' type='button' class='btn xCNBtnBrowseAddOn'>
                                                <img class='xCNIconFind'>
                                            </button>
                                        </span>
                                        </div>
                                    </div>
                                </div>
                            ";
                        }
                        // ถึงประเภทบัตรเดิม
                        if ($aRptFilValue['FTRptFltStaTo'] == '1') {
                            $tCoditionReport .= "  
                                <div class='col-xs-12 col-sm-6 col-md-6 col-lg-6'>
                                    <div class='form-group'>
                                        <label class='xCNLabelFrm'>".language('report/report/report', 'tRptCoditionTo').$aRptFilValue['FTRptFltName']."</label>
                                        <div class='input-group'>
                                        <input class='form-control xCNHide xWRptConsCrdInput' id='oetRptCardTypeCodeOldTo' name='oetRptCardTypeCodeOldTo' maxlength='5' value=''>
                                        <input class='form-control xWPointerEventNone xWRptConsCrdInput' type='text' id='oetRptCardTypeNameOldTo' name='oetRptCardTypeNameOldTo' value='' readonly=''>
                                        <span class='input-group-btn'>
                                            <button id='obtRPCBrowseCardTypeOldTo' type='button' class='btn xCNBtnBrowseAddOn'>
                                                <img class='xCNIconFind'>
                                            </button>
                                        </span>
                                        </div>
                                    </div>
                                </div>
                            ";
                        }
                        $tCoditionReport .= "</div>";
                        break;
                    }
                    case '23': { // ประเภทบัตรใหม่
                        // จากประเภทบัตรใหม่
                        $tCoditionReport .= "<div id='odvCondition".$aRptFilValue['FTRptFltCode']."' class='row'>";
                        if ($aRptFilValue['FTRptFltStaFrm'] == '1') {
                            $tCoditionReport .= "
                                <div class='col-xs-12 col-sm-6 col-md-6 col-lg-6'>
                                    <div class='form-group'>
                                        <label class='xCNLabelFrm'>".language('report/report/report', 'tRptCoditionFrom').$aRptFilValue['FTRptFltName']."</label>
                                        <div class='input-group'>
                                            <input class='form-control xCNHide xWRptConsCrdInput' id='oetRptCardTypeCodeNewFrom' name='oetRptCardTypeCodeNewFrom' maxlength='5' value=''>
                                            <input class='form-control xWPointerEventNone xWRptConsCrdInput' type='text' id='oetRptCardTypeNameNewFrom' name='oetRptCardTypeNameNewFrom' value='' readonly=''>
                                            <span class='input-group-btn'>
                                            <button id='obtRPCBrowseCardTypeNewFrom' type='button' class='btn xCNBtnBrowseAddOn'>
                                                <img class='xCNIconFind'>
                                            </button>
                                        </span>
                                        </div>
                                    </div>
                                </div>
                            ";
                        }
                        // ถึงประเภทบัตรใหม่
                        if ($aRptFilValue['FTRptFltStaTo'] == '1') {
                            $tCoditionReport .= "  
                                <div class='col-xs-12 col-sm-6 col-md-6 col-lg-6'>
                                    <div class='form-group'>
                                        <label class='xCNLabelFrm'>".language('report/report/report', 'tRptCoditionTo').$aRptFilValue['FTRptFltName']."</label>
                                        <div class='input-group'>
                                        <input class='form-control xCNHide xWRptConsCrdInput' id='oetRptCardTypeCodeNewTo' name='oetRptCardTypeCodeNewTo' maxlength='5' value=''>
                                        <input class='form-control xWPointerEventNone xWRptConsCrdInput' type='text' id='oetRptCardTypeNameNewTo' name='oetRptCardTypeNameNewTo' value='' readonly=''>
                                        <span class='input-group-btn'>
                                            <button id='obtRPCBrowseCardTypeNewTo' type='button' class='btn xCNBtnBrowseAddOn'>
                                                <img class='xCNIconFind'>
                                            </button>
                                        </span>
                                        </div>
                                    </div>
                                </div>
                            ";
                        }
                        $tCoditionReport .= "</div>";
                        break;
                    }
                    case '24': { // หมายเลขบัตรเดิม
                        // จากหมายเลขบัตรเดิม
                        $tCoditionReport .= "<div id='odvCondition".$aRptFilValue['FTRptFltCode']."' class='row'>";
                        if ($aRptFilValue['FTRptFltStaFrm'] == '1') {
                            $tCoditionReport .= "
                                <div class='col-xs-12 col-sm-6 col-md-6 col-lg-6'>
                                    <div class='form-group'>
                                        <label class='xCNLabelFrm'>".language('report/report/report', 'tRPCCrdFrom').$aRptFilValue['FTRptFltName']."</label>
                                        <div class='input-group'>
                                            <input type='text' class='form-control xCNHide xWRptAllInput' id='oetRptCardCodeOldFrom' name='oetRptCardCodeOldFrom' maxlength='5'>
                                            <input type='text' class='form-control xWPointerEventNone xWRptAllInput' id='oetRptCardNameOldFrom' name='oetRptCardNameOldFrom' readonly>
                                            <span class='input-group-btn'>
                                                <button id='obtRPCBrowseCardOldFrom' type='button' class='btn xCNBtnBrowseAddOn'> <img class='xCNIconFind'></button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            ";
                        }
                        // ถึงหมายเลขบัตรเดิม
                        if ($aRptFilValue['FTRptFltStaTo'] == '1') {
                            $tCoditionReport .= "  
                                <div class='col-xs-12 col-sm-6 col-md-6 col-lg-6'>
                                    <div class='form-group'>
                                        <label class='xCNLabelFrm'>".language('report/report/report', 'tRPCCrdTo').$aRptFilValue['FTRptFltName']."</label>
                                        <div class='input-group'>
                                            <input type='text' class='form-control xCNHide xWRptAllInput' id='oetRptCardCodeOldTo' name='oetRptCardCodeOldTo' maxlength='5'>
                                            <input type='text' class='form-control xWPointerEventNone xWRptAllInput' id='oetRptCardNameOldTo' name='oetRptCardNameOldTo' readonly>
                                            <span class='input-group-btn'>
                                                <button id='obtRPCBrowseCardOldTo' type='button' class='btn xCNBtnBrowseAddOn'><img class='xCNIconFind'></button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            ";
                        }
                        $tCoditionReport .= "</div>";
                        break;
                    }
                    case '25': { // หมายเลขบัตรใหม่
                        // จากหมายเลขบัตรใหม่
                        $tCoditionReport .= "<div id='odvCondition".$aRptFilValue['FTRptFltCode']."' class='row'>";
                        if ($aRptFilValue['FTRptFltStaFrm'] == '1') {
                            $tCoditionReport .= "
                                <div class='col-xs-12 col-sm-6 col-md-6 col-lg-6'>
                                    <div class='form-group'>
                                        <label class='xCNLabelFrm'>".language('report/report/report', 'tRPCCrdFrom').$aRptFilValue['FTRptFltName']."</label>
                                        <div class='input-group'>
                                            <input type='text' class='form-control xCNHide xWRptAllInput' id='oetRptCardCodeNewFrom' name='oetRptCardCodeNewFrom' maxlength='5'>
                                            <input type='text' class='form-control xWPointerEventNone xWRptAllInput' id='oetRptCardNameNewFrom' name='oetRptCardNameNewFrom' readonly>
                                            <span class='input-group-btn'>
                                                <button id='obtRPCBrowseCardNewFrom' type='button' class='btn xCNBtnBrowseAddOn'> <img class='xCNIconFind'></button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            ";
                        }
                        // ถึงหมายเลขบัตรใหม่
                        if ($aRptFilValue['FTRptFltStaTo'] == '1') {
                            $tCoditionReport .= "  
                                <div class='col-xs-12 col-sm-6 col-md-6 col-lg-6'>
                                    <div class='form-group'>
                                        <label class='xCNLabelFrm'>".language('report/report/report', 'tRPCCrdTo').$aRptFilValue['FTRptFltName']."</label>
                                        <div class='input-group'>
                                            <input type='text' class='form-control xCNHide xWRptAllInput' id='oetRptCardCodeNewTo' name='oetRptCardCodeNewTo' maxlength='5'>
                                            <input type='text' class='form-control xWPointerEventNone xWRptAllInput' id='oetRptCardNameNewTo' name='oetRptCardNameNewTo' readonly>
                                            <span class='input-group-btn'>
                                                <button id='obtRPCBrowseCardNewTo' type='button' class='btn xCNBtnBrowseAddOn'><img class='xCNIconFind'></button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            ";
                        }
                        $tCoditionReport .= "</div>";
                        break;
                    }
                    case '26': { // Pos Type (ประเภทเครื่องจุดขาย)
                        $tCoditionReport .= "<div id='odvCondition".$aRptFilValue['FTRptFltCode']."' class='row'>";
                        if ($aRptFilValue['FTRptFltStaFrm'] == '1') {
                            $tCoditionReport    .= "
                                <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                                    <div class='form-group'>
                                        <label class='xCNLabelFrm'>".$aRptFilValue['FTRptFltName']."</label>
                                        <div class='input-group xWInputGrpPosType' style='width:100%'>
                                            <select class='selectpicker ' id='ocmPosType' name='ocmPosType'>
                                                <option value=''>".language('report/report/report', 'tRptPosType')."</option>
                                                <option value='1'>".language('report/report/report', 'tRptPosType1')."</option>
                                                <option value='2'>".language('report/report/report', 'tRptPosType2')."</option>
                                            </select>                                       
                                        </div>
                                    </div>
                                </div>
                            ";
                        }
                        $tCoditionReport .= "</div>";
                        break;
                    } 
                    case '27': { // ลูกค้า
                        // จากลูกค้า
                        $tCoditionReport .= "<div id='odvCondition".$aRptFilValue['FTRptFltCode']."' class='row'>";
                        if ($aRptFilValue['FTRptFltStaFrm'] == '1') {
                            $tCoditionReport .= "
                                <div class='col-xs-12 col-sm-6 col-md-6 col-lg-6'>
                                    <div class='form-group'>
                                        <label class='xCNLabelFrm'>".language('report/report/report', 'tRptCoditionFrom').$aRptFilValue['FTRptFltName']."</label>
                                        <div class='input-group'>
                                            <input type='text' class='form-control xCNHide xWRptAllInput' id='oetRptCstCodeFrom' name='oetRptCstCodeFrom' maxlength='5'>
                                            <input type='text' class='form-control xWRptAllInput' id='oetRptCstNameFrom' name='oetRptCstNameFrom'>
                                            <span class='input-group-btn'>
                                                <button id='obtRPCBrowseCstFrom' type='button' class='btn xCNBtnBrowseAddOn'> <img class='xCNIconFind'></button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            ";
                        }
                        // ถึงลูกค้า
                        if ($aRptFilValue['FTRptFltStaTo'] == '1') {
                            $tCoditionReport .= "  
                                <div class='col-xs-12 col-sm-6 col-md-6 col-lg-6'>
                                    <div class='form-group'>
                                        <label class='xCNLabelFrm'>".language('report/report/report', 'tRptCoditionTo').$aRptFilValue['FTRptFltName']."</label>
                                        <div class='input-group'>
                                            <input type='text' class='form-control xCNHide xWRptAllInput' id='oetRptCstCodeTo' name='oetRptCstCodeTo' maxlength='5'>
                                            <input type='text' class='form-control xWRptAllInput' id='oetRptCstNameTo' name='oetRptCstNameTo'>
                                            <span class='input-group-btn'>
                                                <button id='obtRPCBrowseCstTo' type='button' class='btn xCNBtnBrowseAddOn'><img class='xCNIconFind'></button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            ";
                        }
                        $tCoditionReport .= "</div>";
                        break;
                    }
                    case '28': { // เดือน
                        $tCoditionReport .= "<div id='odvCondition".$aRptFilValue['FTRptFltCode']."' class='row'>";
                        if($aRptFilValue['FTRptFltStaFrm'] == '1' || $aRptFilValue['FTRptFltStaTo'] == '1') {
                            $tCoditionReport    .= "
                                <div class='col-xs-12 col-sm-6 col-md-6 col-lg-6'>
                                    <div class='form-group'>
                                        <label class='xCNLabelFrm'>".language('report/report/report', 'tRptCoditionFrom').$aRptFilValue['FTRptFltName']."</label>
                                        <div class='input-group xWInputGrpMonthFilter' style='width:100%'>
                                            <select class='selectpicker' id='ocmRptMonth' name='ocmRptMonth'>
                                                <option value='01'>".language('report/report/report','tRptMonth1')."</option>
                                                <option value='02'>".language('report/report/report','tRptMonth2')."</option>
                                                <option value='03'>".language('report/report/report','tRptMonth3')."</option>
                                                <option value='04'>".language('report/report/report','tRptMonth4')."</option>
                                                <option value='05'>".language('report/report/report','tRptMonth5')."</option>
                                                <option value='06'>".language('report/report/report','tRptMonth6')."</option>
                                                <option value='07'>".language('report/report/report','tRptMonth7')."</option>
                                                <option value='08'>".language('report/report/report','tRptMonth8')."</option>
                                                <option value='09'>".language('report/report/report','tRptMonth9')."</option>
                                                <option value='10'>".language('report/report/report','tRptMonth10')."</option>
                                                <option value='11'>".language('report/report/report','tRptMonth11')."</option>
                                                <option value='12'>".language('report/report/report','tRptMonth12')."</option>
                                            </select>      
                                        </div>
                                    </div>
                                </div>
                            ";
                        }
                        
                        $tCoditionReport .= "</div>";
                        break;
                    }
                    case '29': { // ร้านค้าที่โอน
                        $tCoditionReport .= "<div id='odvCondition".$aRptFilValue['FTRptFltCode']."' class='row'>";
                        if ($aRptFilValue['FTRptFltStaFrm'] == '1') {
                            $tCoditionReport .= "
                                <div class='col-xs-12 col-sm-6 col-md-6 col-lg-6'>
                                    <div class='form-group'>
                                        <label class='xCNLabelFrm'>".language('report/report/report', 'tRptCoditionFrom').$aRptFilValue['FTRptFltName']."</label>
                                        <div class='input-group'>
                                            <input type='text' class='form-control xCNHide xWRptAllInput' id='oetRptShpTCodeFrom' name='oetRptShpTCodeFrom' maxlength='5'>
                                            <input type='text' class='form-control xWPointerEventNone xWRptAllInput' id='oetRptShpTNameFrom' name='oetRptShpTNameFrom' readonly>
                                            <span class='input-group-btn'>
                                                <button id='obtRptBrowseShpTFrom' type='button' class='btn xCNBtnBrowseAddOn'><img class='xCNIconFind'></button>
                                            </span>
                                        </div>
                                    </div>
                                </div> 
                            ";
                        }
                        if ($aRptFilValue['FTRptFltStaTo'] == '1') {
                            $tCoditionReport .= "
                                <div class='col-xs-12 col-sm-6 col-md-6 col-lg-6'>
                                    <div class='form-group'>
                                        <label class='xCNLabelFrm'>".language('report/report/report', 'tRptCoditionTo').$aRptFilValue['FTRptFltName']."</label>
                                        <div class='input-group'>
                                            <input type='text' class='form-control xCNHide xWRptAllInput' id='oetRptShpTCodeTo' name='oetRptShpTCodeTo' maxlength='5'>
                                            <input type='text' class='form-control xWPointerEventNone xWRptAllInput' id='oetRptShpTNameTo' name='oetRptShpTNameTo' readonly>
                                            <span class='input-group-btn'>
                                                <button id='obtRptBrowseShpTTo' type='button' class='btn xCNBtnBrowseAddOn'><img class='xCNIconFind'></button>
                                            </span>
                                        </div>
                                    </div>
                                </div> 
                            ";
                        }
                        $tCoditionReport .= "</div>";
                        break;
                    }
                    case '30': { // ร้านค้าที่รับโอน
                        $tCoditionReport .= "<div id='odvCondition".$aRptFilValue['FTRptFltCode']."' class='row'>";
                        if ($aRptFilValue['FTRptFltStaFrm'] == '1') {
                            $tCoditionReport .= "
                                <div class='col-xs-12 col-sm-6 col-md-6 col-lg-6'>
                                    <div class='form-group'>
                                        <label class='xCNLabelFrm'>".language('report/report/report', 'tRptCoditionFrom').$aRptFilValue['FTRptFltName']."</label>
                                        <div class='input-group'>
                                            <input type='text' class='form-control xCNHide xWRptAllInput' id='oetRptShpRCodeFrom' name='oetRptShpRCodeFrom' maxlength='5'>
                                            <input type='text' class='form-control xWPointerEventNone xWRptAllInput' id='oetRptShpRNameFrom' name='oetRptShpRNameFrom' readonly>
                                            <span class='input-group-btn'>
                                                <button id='obtRptBrowseShpRFrom' type='button' class='btn xCNBtnBrowseAddOn'><img class='xCNIconFind'></button>
                                            </span>
                                        </div>
                                    </div>
                                </div> 
                            ";
                        }
                        if ($aRptFilValue['FTRptFltStaTo'] == '1') {
                            $tCoditionReport .= "
                                <div class='col-xs-12 col-sm-6 col-md-6 col-lg-6'>
                                    <div class='form-group'>
                                        <label class='xCNLabelFrm'>".language('report/report/report', 'tRptCoditionTo').$aRptFilValue['FTRptFltName']."</label>
                                        <div class='input-group'>
                                            <input type='text' class='form-control xCNHide xWRptAllInput' id='oetRptShpRCodeTo' name='oetRptShpRCodeTo' maxlength='5'>
                                            <input type='text' class='form-control xWPointerEventNone xWRptAllInput' id='oetRptShpRNameTo' name='oetRptShpRNameTo' readonly>
                                            <span class='input-group-btn'>
                                                <button id='obtRptBrowseShpRTo' type='button' class='btn xCNBtnBrowseAddOn'><img class='xCNIconFind'></button>
                                            </span>
                                        </div>
                                    </div>
                                </div> 
                            ";
                        }
                        $tCoditionReport .= "</div>";
                        break;
                    }
                    case '31': { // ตู้ที่โอน
                        $tCoditionReport .= "<div id='odvCondition".$aRptFilValue['FTRptFltCode']."' class='row'>";
                        if ($aRptFilValue['FTRptFltStaFrm'] == '1') {
                            $tCoditionReport .= "
                                <div class='col-xs-12 col-sm-6 col-md-6 col-lg-6'>
                                    <div class='form-group'>
                                        <label class='xCNLabelFrm'>".language('report/report/report', 'tRptCoditionFrom').$aRptFilValue['FTRptFltName']."</label>
                                        <div class='input-group'>
                                            <input type='text' class='form-control xCNHide xWRptAllInput' id='oetRptPosTCodeFrom' name='oetRptPosTCodeFrom' maxlength='5'>
                                            <input type='text' class='form-control xWPointerEventNone xWRptAllInput' id='oetRptPosTNameFrom' name='oetRptPosTNameFrom' readonly>
                                            <span class='input-group-btn'>
                                                <button id='obtRptBrowsePosTFrom' type='button' class='btn xCNBtnBrowseAddOn'><img class='xCNIconFind'></button>
                                            </span>
                                        </div>
                                    </div>
                                </div> 
                            ";
                        }
                        if ($aRptFilValue['FTRptFltStaTo'] == '1') {
                            $tCoditionReport .= "
                                <div class='col-xs-12 col-sm-6 col-md-6 col-lg-6'>
                                    <div class='form-group'>
                                        <label class='xCNLabelFrm'>".language('report/report/report', 'tRptCoditionTo').$aRptFilValue['FTRptFltName']."</label>
                                        <div class='input-group'>
                                            <input type='text' class='form-control xCNHide xWRptAllInput' id='oetRptPosTCodeTo' name='oetRptPosTCodeTo' maxlength='5'>
                                            <input type='text' class='form-control xWPointerEventNone xWRptAllInput' id='oetRptPosTNameTo' name='oetRptPosTNameTo' readonly>
                                            <span class='input-group-btn'>
                                                <button id='obtRptBrowsePosTTo' type='button' class='btn xCNBtnBrowseAddOn'><img class='xCNIconFind'></button>
                                            </span>
                                        </div>
                                    </div>
                                </div> 
                            ";
                        }
                        $tCoditionReport .= "</div>";
                        break;
                    }
                    case '32': { // ตู้ที่รับโอน
                        $tCoditionReport .= "<div id='odvCondition".$aRptFilValue['FTRptFltCode']."' class='row'>";
                        if ($aRptFilValue['FTRptFltStaFrm'] == '1') {
                            $tCoditionReport .= "
                                <div class='col-xs-12 col-sm-6 col-md-6 col-lg-6'>
                                    <div class='form-group'>
                                        <label class='xCNLabelFrm'>".language('report/report/report', 'tRptCoditionFrom').$aRptFilValue['FTRptFltName']."</label>
                                        <div class='input-group'>
                                            <input type='text' class='form-control xCNHide xWRptAllInput' id='oetRptPosRCodeFrom' name='oetRptPosRCodeFrom' maxlength='5'>
                                            <input type='text' class='form-control xWPointerEventNone xWRptAllInput' id='oetRptPosRNameFrom' name='oetRptPosRNameFrom' readonly>
                                            <span class='input-group-btn'>
                                                <button id='obtRptBrowsePosRFrom' type='button' class='btn xCNBtnBrowseAddOn'><img class='xCNIconFind'></button>
                                            </span>
                                        </div>
                                    </div>
                                </div> 
                            ";
                        }
                        if ($aRptFilValue['FTRptFltStaTo'] == '1') {
                            $tCoditionReport .= "
                                <div class='col-xs-12 col-sm-6 col-md-6 col-lg-6'>
                                    <div class='form-group'>
                                        <label class='xCNLabelFrm'>".language('report/report/report', 'tRptCoditionTo').$aRptFilValue['FTRptFltName']."</label>
                                        <div class='input-group'>
                                            <input type='text' class='form-control xCNHide xWRptAllInput' id='oetRptPosRCodeTo' name='oetRptPosRCodeTo' maxlength='5'>
                                            <input type='text' class='form-control xWPointerEventNone xWRptAllInput' id='oetRptPosRNameTo' name='oetRptPosRNameTo' readonly>
                                            <span class='input-group-btn'>
                                                <button id='obtRptBrowsePosRTo' type='button' class='btn xCNBtnBrowseAddOn'><img class='xCNIconFind'></button>
                                            </span>
                                        </div>
                                    </div>
                                </div> 
                            ";
                        }
                        $tCoditionReport .= "</div>";
                        break;
                    }
                    case '33': { // คลังสินค้าที่โอน
                        $tCoditionReport .= "<div id='odvCondition".$aRptFilValue['FTRptFltCode']."' class='row'>";
                        if ($aRptFilValue['FTRptFltStaFrm'] == '1') {
                            $tCoditionReport .= "
                                <div class='col-xs-12 col-sm-6 col-md-6 col-lg-6'>
                                    <div class='form-group'>
                                        <label class='xCNLabelFrm'>".language('report/report/report', 'tRptCoditionFrom').$aRptFilValue['FTRptFltName']."</label>
                                        <div class='input-group'>
                                            <input type='text' class='form-control xCNHide xWRptAllInput' id='oetRptWahTCodeFrom' name='oetRptWahTCodeFrom' maxlength='5'>
                                            <input type='text' class='form-control xWPointerEventNone xWRptAllInput' id='oetRptWahTNameFrom' name='oetRptWahTNameFrom' readonly>
                                            <span class='input-group-btn'>
                                                <button id='obtRptBrowseWahTFrom' type='button' class='btn xCNBtnBrowseAddOn'> <img class='xCNIconFind'></button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            ";
                        }
                        if ($aRptFilValue['FTRptFltStaTo'] == '1') {
                            $tCoditionReport .= "
                                <div class='col-xs-12 col-sm-6 col-md-6 col-lg-6'>
                                    <div class='form-group'>
                                        <label class='xCNLabelFrm'>".language('report/report/report', 'tRptCoditionTo').$aRptFilValue['FTRptFltName']."</label>
                                        <div class='input-group'>
                                            <input type='text' class='form-control xCNHide xWRptAllInput' id='oetRptWahTCodeTo' name='oetRptWahTCodeTo' maxlength='5'>
                                            <input type='text' class='form-control xWPointerEventNone xWRptAllInput' id='oetRptWahTNameTo' name='oetRptWahTNameTo' readonly>
                                            <span class='input-group-btn'>
                                                <button id='obtRptBrowseWahTTo' type='button' class='btn xCNBtnBrowseAddOn'><img class='xCNIconFind'></button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            ";
                        }
                        $tCoditionReport .= "</div>";
                        break;
                    }
                    case '34': { // คลังสินค้าที่รับโอน
                        $tCoditionReport .= "<div id='odvCondition".$aRptFilValue['FTRptFltCode']."' class='row'>";
                        if ($aRptFilValue['FTRptFltStaFrm'] == '1') {
                            $tCoditionReport .= "
                                <div class='col-xs-12 col-sm-6 col-md-6 col-lg-6'>
                                    <div class='form-group'>
                                        <label class='xCNLabelFrm'>".language('report/report/report', 'tRptCoditionFrom').$aRptFilValue['FTRptFltName']."</label>
                                        <div class='input-group'>
                                            <input type='text' class='form-control xCNHide xWRptAllInput' id='oetRptWahRCodeFrom' name='oetRptWahRCodeFrom' maxlength='5'>
                                            <input type='text' class='form-control xWPointerEventNone xWRptAllInput' id='oetRptWahRNameFrom' name='oetRptWahRNameFrom' readonly>
                                            <span class='input-group-btn'>
                                                <button id='obtRptBrowseWahRFrom' type='button' class='btn xCNBtnBrowseAddOn'> <img class='xCNIconFind'></button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            ";
                        }
                        if ($aRptFilValue['FTRptFltStaTo'] == '1') {
                            $tCoditionReport .= "
                                <div class='col-xs-12 col-sm-6 col-md-6 col-lg-6'>
                                    <div class='form-group'>
                                        <label class='xCNLabelFrm'>".language('report/report/report', 'tRptCoditionTo').$aRptFilValue['FTRptFltName']."</label>
                                        <div class='input-group'>
                                            <input type='text' class='form-control xCNHide xWRptAllInput' id='oetRptWahRCodeTo' name='oetRptWahRCodeTo' maxlength='5'>
                                            <input type='text' class='form-control xWPointerEventNone xWRptAllInput' id='oetRptWahRNameTo' name='oetRptWahRNameTo' readonly>
                                            <span class='input-group-btn'>
                                                <button id='obtRptBrowseWahRTo' type='button' class='btn xCNBtnBrowseAddOn'><img class='xCNIconFind'></button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            ";
                        }
                        $tCoditionReport .= "</div>";
                        break;
                    }
                    case '35': {  // สถานะการจอง
                        $tCoditionReport .= "<div id='odvCondition".$aRptFilValue['FTRptFltCode']."' class='row'>";
                        if ($aRptFilValue['FTRptFltStaFrm'] == '1' && $aRptFilValue['FTRptFltStaTo'] == '1') {
                            $tCoditionReport    .= "
                                <div class='col-xs-12 col-sm-6 col-md-6 col-lg-6'>
                                    <div class='form-group'>
                                        <label class='xCNLabelFrm'>".$aRptFilValue['FTRptFltName']."</label>
                                        <div class='input-group' style='width:100%'>
                                            <select class='selectpicker' id='ocmRptStaBooking' name='ocmRptStaBooking'>
                                                <option value=''>".language('report/report/report','tRptStaBookingAll')."</option>
                                                <option value='1'>".language('report/report/report','tRptStaBooking1')."</option>
                                                <option value='2'>".language('report/report/report','tRptStaBooking2')."</option>
                                                <option value='3'>".language('report/report/report','tRptStaBooking3')."</option>
                                                <option value='4'>".language('report/report/report','tRptStaBooking4')."</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            ";
                        }
                        $tCoditionReport .= "</div>";
                        break;
                    }
                    case '36': { // ระบบการจอง
                        $tCoditionReport .= "<div id='odvCondition".$aRptFilValue['FTRptFltCode']."' class='row'>";
                        if ($aRptFilValue['FTRptFltStaFrm'] == '1' && $aRptFilValue['FTRptFltStaTo'] == '1') {
                            $tCoditionReport    .= "
                                <div class='col-xs-12 col-sm-6 col-md-6 col-lg-6'>
                                    <div class='form-group'>
                                        <label class='xCNLabelFrm'>".$aRptFilValue['FTRptFltName']."</label>
                                        <div class='input-group' style='width:100%'>
                                            <select class='selectpicker' id='ocmRptStaProducer' name='ocmRptStaProducer'>
                                                <option value=''>".language('report/report/report','tRptStaProducerAll')."</option>
                                                <option value='".language('report/report/report','tRptStaProducer1')."'>".language('report/report/report','tRptStaProducer1')."</option>
                                                <option value='".language('report/report/report','tRptStaProducer2')."'>".language('report/report/report','tRptStaProducer2')."</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            ";
                        }
                        $tCoditionReport .= "</div>";
                        break;
                    }
                    case '37': { // ขนาดช่องฝาก(Locker)
                        $tCoditionReport .= "<div id='odvCondition".$aRptFilValue['FTRptFltCode']."' class='row'>";
                        if($aRptFilValue['FTRptFltStaFrm'] == '1'){
                            $tCoditionReport .= "
                                <div class='col-xs-12 col-sm-6 col-md-6 col-lg-6'>
                                    <div class='form-group'>
                                        <label class='xCNLabelFrm'>".language('report/report/report','tRptCoditionFrom').$aRptFilValue['FTRptFltName']."</label>
                                        <div class='input-group'>
                                            <input type='text' class='form-control xCNHide xWRptAllInput' id='oetRptPzeCodeFrom' name='oetRptPzeCodeFrom' maxlength='5'>
                                            <input type='text' class='form-control xWPointerEventNone xWRptAllInput' id='oetRptPzeNameFrom' name='oetRptPzeNameFrom' readonly>
                                            <span class='input-group-btn'>
                                                <button id='obtRptBrowseShpSizeFrom' type='button' class='btn xCNBtnBrowseAddOn'> <img class='xCNIconFind'></button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            ";
                        }
                        if($aRptFilValue['FTRptFltStaTo'] == '1'){
                            $tCoditionReport .= "
                                <div class='col-xs-12 col-sm-6 col-md-6 col-lg-6'>
                                    <div class='form-group'>
                                        <label class='xCNLabelFrm'>".language('report/report/report','tRptCoditionTo').$aRptFilValue['FTRptFltName']."</label>
                                        <div class='input-group'>
                                            <input type='text' class='form-control xCNHide xWRptAllInput' id='oetRptPzeCodeTo' name='oetRptPzeCodeTo' maxlength='5'>
                                            <input type='text' class='form-control xWPointerEventNone xWRptAllInput' id='oetRptPzeNameTo' name='oetRptPzeNameTo' readonly>
                                            <span class='input-group-btn'>
                                                <button id='obtRptBrowseShpSizeTo' type='button' class='btn xCNBtnBrowseAddOn'> <img class='xCNIconFind'></button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            ";
                        }
                        $tCoditionReport .= "</div>";
                        break;
                    }
                    case '38': { // Filter ตู้(Locker)
                        $tCoditionReport .= "<div id='odvCondition".$aRptFilValue['FTRptFltCode']."' class='row'>";
                        if ($aRptFilValue['FTRptFltStaFrm'] == '1') {
                            $tCoditionReport .= "
                                <div class='col-xs-12 col-sm-6 col-md-6 col-lg-6'>
                                    <div class='form-group'>
                                        <label class='xCNLabelFrm'>".language('report/report/report', 'tRptCoditionFrom').$aRptFilValue['FTRptFltName']."</label>
                                        <div class='input-group'>
                                            <input type='text' class='form-control xCNHide xWRptAllInput' id='oetRptLockerCodeFrom' name='oetRptLockerCodeFrom' maxlength='5'>
                                            <input type='text' class='form-control xWPointerEventNone xWRptAllInput' id='oetRptLockerNameFrom' name='oetRptLockerNameFrom' readonly>
                                            <span class='input-group-btn'>
                                                <button id='obtRptBrowseLockerFrom' type='button' class='btn xCNBtnBrowseAddOn'><img class='xCNIconFind'></button>
                                            </span>
                                        </div>
                                    </div>
                                </div> 
                            ";
                        }
                        if ($aRptFilValue['FTRptFltStaTo'] == '1') {
                            $tCoditionReport .= "
                                <div class='col-xs-12 col-sm-6 col-md-6 col-lg-6'>
                                    <div class='form-group'>
                                        <label class='xCNLabelFrm'>".language('report/report/report', 'tRptCoditionTo').$aRptFilValue['FTRptFltName']."</label>
                                        <div class='input-group'>
                                            <input type='text' class='form-control xCNHide xWRptAllInput' id='oetRptLockerCodeTo' name='oetRptLockerCodeTo' maxlength='5'>
                                            <input type='text' class='form-control xWPointerEventNone xWRptAllInput' id='oetRptLockerNameTo' name='oetRptLockerNameTo' readonly>
                                            <span class='input-group-btn'>
                                                <button id='obtRptBrowseLockerTo' type='button' class='btn xCNBtnBrowseAddOn'><img class='xCNIconFind'></button>
                                            </span>
                                        </div>
                                    </div>
                                </div> 
                            ";
                        }
                        $tCoditionReport .= "</div>";
                        break;
                    }
                    case '39': { // Filter ช่องฝาก(Locker)
                        $tCoditionReport .= "<div id='odvCondition".$aRptFilValue['FTRptFltCode']."' class='row'>";
                        if ($aRptFilValue['FTRptFltStaFrm'] == '1') {
                            $tCoditionReport .= "
                                <div class='col-xs-12 col-sm-6 col-md-6 col-lg-6'>
                                    <div class=''>
                                        <label class='xCNLabelFrm'>".language('report/report/report', 'tRptCoditionFrom').$aRptFilValue['FTRptFltName']."</label>
                                        <input type='text' class='form-control xCNInputNumericWithDecimal xCNInputLength' data-length='3' id='oetRptLockerChanelFrom' name='oetRptLockerChanelFrom'>
                                    </div>
                                </div> 
                            ";
                        }
                        if ($aRptFilValue['FTRptFltStaTo'] == '1') {
                            $tCoditionReport .= "
                                <div class='col-xs-12 col-sm-6 col-md-6 col-lg-6'>
                                    <div class=''>
                                        <label class='xCNLabelFrm'>".language('report/report/report', 'tRptCoditionTo').$aRptFilValue['FTRptFltName']."</label>
                                        <input type='text' class='form-control xCNInputNumericWithDecimal xCNInputLength' data-length='3' id='oetRptLockerChanelTo' name='oetRptLockerChanelTo'>
                                    </div>
                                </div> 
                            ";
                        }
                        $tCoditionReport .= "</div>";
                        break;
                    }
                }
            ?>
        <?php endforeach; ?>
        <br> 
        <?php echo $tCoditionReport;?>
        <div id="odvBtnRptProcessGrp" class="row" style="padding-top:20px">
            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                <button type="button" id="obtRptExportExcel" data-rpccode="" class="btn btn-primary" style="font-size: 17px;width: 100%;">
                    <?php echo language('report/report/report', 'tRptExportExcel') ?>
                </button>
            </div>
            
            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                <!-- <button type="button" id="obtRptDownloadPdf" data-rpccode="" class="btn btn-primary" style="font-size:17px;width:100%;">
                    <?php echo language('report/report/report', 'tRptDownloadPDF') ?>
                </button> -->
            </div>

            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2"></div>
            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                <button type="button" id="obtRptViewBeforePrint" data-rpccode="" class="btn btn-primary" style="font-size: 17px;width: 100%;">
                    <?php echo language('report/report/report', 'tRptViewBeforePrint') ?>
                </button>
            </div>
        </div>
        <?php include "script/jReportCondition.php"; ?>
    </div>
<?php endif; ?>
