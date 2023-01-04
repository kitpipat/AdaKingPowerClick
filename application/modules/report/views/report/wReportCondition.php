<style>
    .fancy-checkbox {
        display: inline-block;
        font-weight: normal;
        width: 80px;
    }

    .xCNFontHead {
        font-weight: bold;
    }

    .xCNBTNConditionActive:hover,
    .xCNBTNConditionBetween:hover {
        background-color: transparent;
        color: #FFF;
        border-color: #0081c2;
    }
    .xCNBTNConditionClear:hover {
        background-color: transparent;
        color: red !important;
        border-color: red;
        font-weight: bold;
    }

    .xCNBTNExportExcel {
        background-color: transparent;
        border-color: #3ec73e;
        color: #3ec73e !important;
        font-weight: bold;
    }

    .xCNBTNConditionBetween {
        background-color: transparent;
        border-color: #d4d4d4;
        color: #666666 !important;
        font-weight: bold;
    }

    .xCNBTNConditionActive {
        background-color: transparent !important;
        border-color: #0081c2;
        color: #666666 !important;
        font-weight: bold;
    }

    .xCNPanalCondition {
        border-left: 1px solid #eeeeee !important;
        padding-left: 30px !important;
    }

    .xCNTextLabel {
        font-size: 17px !important;
        text-align: left;
    }

    .xCNTextTo {
        font-size: 17px !important;
        text-align: center;
        margin-top: 5px;
    }

    .xCNTextLabelMargin {
        margin: 5px 0px 22px 0px;
    }

    .xCNFontTDGroupFilter {
        font-size: 17px !important;
        font-weight: bold;
        text-align: left;
    }

    .xCNLabelTBText {
        padding-left: 50px !important;
    }

    .xWInputGrpPosType>.dropdown {
        width: 100% !important;
    }

    hr {
        margin: 10px;
        border-color: #dddddd;
        margin-left: 0px;
        margin-right: 0px;
    }

    .xCNTableBorderSub tbody .xCNNewGroup {
        border-top: 1px solid #e2e7eb !important;
    }

    .xCNTableBorderSub thead th,
    .xCNTableBorderSub>thead>tr>th,
    .xCNTableBorderSub tbody tr,
    .xCNTableBorderSub>tbody>tr>td {
        border: 0px solid #FFF !important;
        border-right: 1px solid #e2e7eb !important;
    }

    .xCNInputNewUI {
        background: transparent !important;
        border: 0px !important;
    }

    .xCNInputNewUI:focus {
        box-shadow: 0px 0px !important;
    }

    .xCNInputNewUIBrowseHover {
        background: #f6f5f5 !important;
        cursor: pointer !important;
    }

    .xCNButtonNewUI {
        background: transparent !important;
        border: 0px solid transparent !important;
        box-shadow: 0px 0px;
        display: none;
        left: 10px;
    }

    .xCNButtonNewUI:focus {
        box-shadow: 0px 0px !important;
    }

    .xCNButtonNewUI>.xCNIconFind,
    .xCNIconCalendar {
        width: 18px;
    }

    .xCNNewUISelectoption>.btn-default:hover {
        background: #f6f5f5 !important;
    }

    .xCNNewUISelectoption>.btn-default:focus {
        outline: 0px !important;
    }

    .xCNNewUISelectHover {
        background: #f6f5f5 !important;
    }

    .xCNNewUISelectoption {
        width: 100% !important;
        border: 0px solid transparent !important;
    }

    .xCNNewUISelectoption:focus {
        box-shadow: 0px 0px !important;
    }

    .xCNNewUISelectoption>.btn-default {
        border: 0px solid transparent !important;
        color: #000000 !important;
    }

    .fancy-checkbox input[type="checkbox"]+span:before {
        margin-right: 0px !important;
    }

    .xCNCheckboxBlockDefault:before {
        background-color: #ededed;
    }
</style>

<!--เงือนไขการค้นหาส่วนบน-->
<?php if (isset($aRptFilterData) && $aRptFilterData['rtCode'] == 1) : ?>
    <div id="odvConditionNewUISestionUp<?= $aRptFilterData['raItems']['rtRptCode'] ?>">
        <div class="row">

            <!-- เงือนไขฟิวส์เตอร์ทั้งหมด -->

            <?php

            $tDateNow               = date("Y-m-d");
            $tCoditionLabelReport   = "";
            $tCoditionReport        = "";
            $bIsFristDisplay        = true;

            if( !FCNbGetIsAgnEnabled() ){
                $tStaAgnEnabled = 'xCNHide';
            }else{
                $tStaAgnEnabled = '';
            }

            $tCoditionLabelReport   .= "<div class='$tStaAgnEnabled'><p class='xCNTextLabel xCNTextLabelMargin'>" . language('ticket/agency/agency', 'tAggTitle') . "</p></div>";
            $tCoditionReport        .= "<div class='xCNFilterBox $tStaAgnEnabled'>";
            /*===== Begin เลือก AD ==========================================*/
            $tUsrLevel          = $this->session->userdata("tSesUsrLevel");
            $tUsrAgnCode        = $this->session->userdata("tSesUsrAgnCode");
            $tUsrAgnName        = $this->session->userdata("tSesUsrAgnName");
            $tUsrBchCodeMulti   = $this->session->userdata("tSesUsrBchCodeMulti");
            $tUsrBchNameMulti   = $this->session->userdata("tSesUsrBchNameMulti");

            $tDisAD         = '';
            $tDisCalssAD    = '';
            $tValAD         = '';
            $tNameAD        = '';
            $tNameBch       = '';
            $tValBch        = '';

            if ($tUsrLevel != 'HQ') {
                $tDisAD         = 'disabled';
                $tDisCalssAD    = 'xCNDisabled';
                $tValAD         = $tUsrAgnCode;
                $tNameAD        = $tUsrAgnName;
                $tNameBch       = str_replace("'",'',$tUsrBchNameMulti);
                $tValBch        = str_replace("'",'',$tUsrBchCodeMulti);
            }

            $tCoditionReport .= "<div id='odvConditionSelect' class='row xCNFilterSelectMode'>";
            // if ($aRptFilValue['FTRptFltStaFrm'] == '1') {

            $tCoditionReport .= "
                <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                    <div class='form-group'>
                        <div class='input-group'>
                            <input type='text' class='form-control xCNHide' id='oetSpcAgncyCode' name='oetSpcAgncyCode' value='$tValAD' maxlength='5'>
                            <input type='text' class='form-control xWPointerEventNone' id='oetSpcAgncyName' name='oetSpcAgncyName' maxlength='100' value='$tNameAD'  readonly>
                            <span class='input-group-btn'>
                                <button id='oimBrowseSpcAgncy' type='button' class='btn xCNBtnBrowseAddOn $tDisCalssAD' $tDisAD  ><img class='xCNIconFind'></button>
                            </span>
                        </div>
                    </div>
                </div>
            ";
            // }
            $tCoditionReport .= "</div>";
            /*===== End แบบเลือก ============================================*/

            $tCoditionReport .= "</div>"; // End xCNFilterBox

            foreach ($aRptFilterData['raItems']['raRptFilterCol'] as $nKey => $aRptFilValue) : ?>
                <?php
                $tNameRoute = $aRptFilterData['raItems']['rtRptRoute'];
                switch ($aRptFilValue['FTRptFltCode']) {
                    case '1': { // Filter Branch (ค้นหาข้อมูลสาขา)

                            //ถ้าเป็นรายงานข้อมูลบัตร (master) จะไม่มีการกรองข้อมูลสาขา
                            //รายงานตรวจสอบสถานะบัตร , รายงานโอนข้อมูลบัตร , รายงานบัตรคงเหลือ , รายงานยอดสะสมบัตรหมดอายุ
                            //รายงานรายการต้นงวดบัตรและเงินสด , รายงานข้อมูลบัตร
                            if( $tNameRoute == 'rptCrdCheckStatusCard' ||
                                //$tNameRoute == 'rptCrdTransferCardInfo' ||
                                $tNameRoute == 'rptCrdCardTimesUsed' ||
                                $tNameRoute == 'rptCrdClearCardValueForReuse' ||
                                $tNameRoute == 'rptCrdCardBalance' ||
                                $tNameRoute == 'rptCrdCollectExpireCard' ||
                                $tNameRoute == 'rptCrdCardPrinciple' ||
                                $tNameRoute == 'rptCrdCardDetail'){

                            }else{
                                $tCoditionLabelReport   .= "<div><p class='xCNTextLabel xCNTextLabelMargin'>" . language('report/report/report', 'tRptBarchName') . "</p></div>";
                                $tCoditionReport        .= "<div class='xCNFilterBox'>";

                                /*===== Begin แบบช่วง ===========================================*/
                                $tCoditionReport .= "<div id='odvCondition" . $aRptFilValue['FTRptFltCode'] . "' class='row xCNFilterRangeMode'>";
                                if ($aRptFilValue['FTRptFltStaFrm'] == '1') {
                                    $tCoditionReport .= "
                                            <div class=''>
                                                <div class='col-lg-6'>
                                                    <div class='form-group'>
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
                                                <div class='col-lg-1'>
                                                    <p class='xCNTextTo'>" . language('report/report/report', 'tRptCoditionTo') . "</p>
                                                </div>
                                                <div class='col-lg-5'>
                                                    <div class='form-group'>
                                                        <div class='input-group'>
                                                            <input type='text' class='form-control xCNHide xWRptAllInput' id='oetRptBchCodeTo' name='oetRptBchCodeTo' maxlength='5'>
                                                            <input type='text' class='form-control xWPointerEventNone xWRptAllInput' id='oetRptBchNameTo' name='oetRptBchNameTo' readonly>
                                                            <span class='input-group-btn'>
                                                                <button id='obtRptBrowseBchTo' type='button' class='btn xCNBtnBrowseAddOn'><img class='xCNIconFind'></button>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        ";
                                }
                                $tCoditionReport .= "</div>";
                                /*===== End แบบช่วง =============================================*/

                                /*===== Begin แบบเลือก ==========================================*/

                                $tCoditionReport .= "<div id='odvConditionSelect" . $aRptFilValue['FTRptFltCode'] . "' class='row xCNFilterSelectMode'>";
                                if ($aRptFilValue['FTRptFltStaFrm'] == '1') {
                                    $tCoditionReport .= "
                                            <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                                                <div class='form-group'>
                                                    <div class='input-group'>
                                                        <input type='text' class='form-control xCNHide xWRptAllInput' id='oetRptBchStaSelectAll' name='oetRptBchStaSelectAll'>
                                                        <input type='text' class='form-control xCNHide xWRptAllInput' id='oetRptBchCodeSelect' name='oetRptBchCodeSelect' value='".$tValBch."'  >
                                                        <input type='text' class='form-control xWPointerEventNone xWRptAllInput' id='oetRptBchNameSelect' name='oetRptBchNameSelect'   readonly>
                                                        <span class='input-group-btn'>
                                                            <button id='obtRptMultiBrowseBranch' type='button' class='btn xCNBtnBrowseAddOn'><img class='xCNIconFind'></button>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        ";
                                }
                                $tCoditionReport .= "</div>";
                                /*===== End แบบเลือก ============================================*/

                                $tCoditionReport .= "</div>";
                            }
                            break;
                        }
                    case '2': { // Filter Shop (ค้นหาข้อมูลร้านค้า)
                            if (FCNbGetIsShpEnabled()) {
                                $tCoditionLabelReport   .= "<div><p class='xCNTextLabel xCNTextLabelMargin'>" . language('report/report/report', 'tRptMultiSelectShp') . "</p></div>";
                                $tCoditionReport        .= "<div class='xCNFilterBox'>";

                                /*===== Begin แบบช่วง ===========================================*/
                                $tCoditionReport .= "<div id='odvCondition" . $aRptFilValue['FTRptFltCode'] . "' class='row xCNFilterRangeMode'>";
                                if ($aRptFilValue['FTRptFltStaFrm'] == '1') {
                                    $tCoditionReport .= "
                                    <div class=''>
                                        <div class='col-lg-6'>
                                            <div class='form-group'>
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
                                            <div class='col-lg-1'>
                                                <p class='xCNTextTo'>" . language('report/report/report', 'tRptCoditionTo') . "</p>
                                            </div>
                                            <div class='col-lg-5'>
                                                <div class='form-group'>
                                                    <div class='input-group'>
                                                        <input type='text' class='form-control xCNHide xWRptAllInput' id='oetRptShpCodeTo' name='oetRptShpCodeTo' maxlength='5'>
                                                        <input type='text' class='form-control xWPointerEventNone xWRptAllInput' id='oetRptShpNameTo' name='oetRptShpNameTo' readonly>
                                                        <span class='input-group-btn'>
                                                            <button id='obtRptBrowseShpTo' type='button' class='btn xCNBtnBrowseAddOn'><img class='xCNIconFind'></button>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    ";
                                }
                                $tCoditionReport .= "</div>";
                                /*===== End แบบช่วง =============================================*/

                                /*===== Begin แบบเลือก ==========================================*/
                                $tCoditionReport .= "<div id='odvConditionSelect" . $aRptFilValue['FTRptFltCode'] . "' class='row xCNFilterSelectMode'>";
                                if ($aRptFilValue['FTRptFltStaFrm'] == '1') {
                                    $tCoditionReport .= "
                                        <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                                            <div class='form-group'>
                                                <div class='input-group'>
                                                    <input type='text' class='form-control xCNHide xWRptAllInput' id='oetRptShpStaSelectAll' name='oetRptShpStaSelectAll'>
                                                    <input type='text' class='form-control xCNHide xWRptAllInput' id='oetRptShpCodeSelect' name='oetRptShpCodeSelect'>
                                                    <input type='text' class='form-control xWPointerEventNone xWRptAllInput' id='oetRptShpNameSelect' name='oetRptShpNameSelect' readonly>
                                                    <span class='input-group-btn'>
                                                        <button id='obtRptMultiBrowseShop' type='button' class='btn xCNBtnBrowseAddOn'><img class='xCNIconFind'></button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    ";
                                }
                                $tCoditionReport .= "</div>";
                                /*===== End แบบเลือก ============================================*/

                                $tCoditionReport .= "</div>"; // End xCNFilterBox
                            } else {
                                echo "<input type='text' class='form-control xCNHide xWRptAllInput' id='oetRptShpStaSelectAll' name='oetRptShpStaSelectAll'>
                                    <input type='text' class='form-control xCNHide xWRptAllInput' id='oetRptShpCodeSelect' name='oetRptShpCodeSelect'>
                                    <input type='text' class='form-control xCNHide xWPointerEventNone xWRptAllInput' id='oetRptShpNameSelect' name='oetRptShpNameSelect' readonly>";
                            }
                            break;
                        }
                    case '200': { // Filter Shop (ค้นหาข้อมูลร้านค้า)
                        if (FCNbGetIsShpEnabled()) {
                            $tCoditionLabelReport   .= "<div><p class='xCNTextLabel xCNTextLabelMargin'>" . language('report/report/report', 'tRptShpVending') . "</p></div>";
                            $tCoditionReport        .= "<div class='xCNFilterBox'>";

                            /*===== Begin แบบเลือก ==========================================*/
                            $tCoditionReport .= "<div id='odvConditionSelect" . $aRptFilValue['FTRptFltCode'] . "' class='row xCNFilterSelectMode'>";
                            if ($aRptFilValue['FTRptFltStaFrm'] == '1') {
                                $tCoditionReport .= "
                                    <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                                        <div class='form-group'>
                                            <div class='input-group'>
                                                <input type='text' class='form-control xCNHide xWRptAllInput' id='oetRptShpType' name='oetRptShpType'>
                                                <input type='text' class='form-control xCNHide xWRptAllInput' id='oetRptShpStaSelectAll' name='oetRptShpStaSelectAll'>
                                                <input type='text' class='form-control xCNHide xWRptAllInput' id='oetRptShpCodeSelect' name='oetRptShpCodeSelect'>
                                                <input type='text' class='form-control xWPointerEventNone xWRptAllInput' id='oetRptShpNameSelect' name='oetRptShpNameSelect' readonly>
                                                <span class='input-group-btn'>
                                                    <button id='obtRptMultiBrowseShop' type='button' class='btn xCNBtnBrowseAddOn'><img class='xCNIconFind'></button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                ";
                            }
                            $tCoditionReport .= "</div>";
                            /*===== End แบบเลือก ============================================*/

                            $tCoditionReport .= "</div>"; // End xCNFilterBox
                        } else {
                            echo "<input type='text' class='form-control xCNHide xWRptAllInput' id='oetRptShpStaSelectAll' name='oetRptShpStaSelectAll'>
                                <input type='text' class='form-control xCNHide xWRptAllInput' id='oetRptShpCodeSelect' name='oetRptShpCodeSelect'>
                                <input type='text' class='form-control xCNHide xWPointerEventNone xWRptAllInput' id='oetRptShpNameSelect' name='oetRptShpNameSelect' readonly>";
                        }
                        break;
                    }
                    case '3': { // Filter Pos (ค้นหาข้อมูลเครื่องจุดขาย)
                            $tCoditionLabelReport   .= "<div><p class='xCNTextLabel xCNTextLabelMargin'>" . language('report/report/report', 'tRPC12TBPosCode') . "</p></div>";
                            $tCoditionReport        .= "<div class='xCNFilterBox'>";

                            /*===== Begin แบบช่วง ===========================================*/
                            $tCoditionReport .= "<div id='odvCondition" . $aRptFilValue['FTRptFltCode'] . "' class='row xCNFilterRangeMode'>";
                            if ($aRptFilValue['FTRptFltStaFrm'] == '1') {
                                $tCoditionReport .= "
                                        <div class=''>
                                            <div class='col-lg-6'>
                                                <div class='form-group'>
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
                                            <div class='col-lg-1'>
                                                <p class='xCNTextTo'>" . language('report/report/report', 'tRptCoditionTo') . "</p>
                                            </div>
                                            <div class='col-lg-5'>
                                                <div class='form-group'>
                                                    <div class='input-group'>
                                                        <input type='text' class='form-control xCNHide xWRptAllInput' id='oetRptPosCodeTo' name='oetRptPosCodeTo' maxlength='5'>
                                                        <input type='text' class='form-control xWPointerEventNone xWRptAllInput' id='oetRptPosNameTo' name='oetRptPosNameTo' readonly>
                                                        <span class='input-group-btn'>
                                                            <button id='obtRptBrowsePosTo' type='button' class='btn xCNBtnBrowseAddOn'><img class='xCNIconFind'></button>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    ";
                            }
                            $tCoditionReport .= "</div>";
                            /*===== End แบบช่วง =============================================*/

                            /*===== Begin แบบเลือก ==========================================*/
                            $tCoditionReport .= "<div id='odvConditionSelect" . $aRptFilValue['FTRptFltCode'] . "' class='row xCNFilterSelectMode'>";
                            if ($aRptFilValue['FTRptFltStaFrm'] == '1') {
                                $tCoditionReport .= "
                                        <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                                            <div class='form-group'>
                                                <div class='input-group'>
                                                    <input type='text' class='form-control xCNHide xWRptAllInput' id='oetRptPosType' name='oetRptPosType' value=''>
                                                    <input type='text' class='form-control xCNHide xWRptAllInput' id='oetRptPosStaSelectAll' name='oetRptPosStaSelectAll'>
                                                    <input type='text' class='form-control xCNHide xWRptAllInput' id='oetRptPosCodeSelect' name='oetRptPosCodeSelect'>
                                                    <input type='text' class='form-control xWPointerEventNone xWRptAllInput' id='oetRptPosNameSelect' name='oetRptPosNameSelect' readonly>
                                                    <span class='input-group-btn'>
                                                        <button id='obtRptMultiBrowsePos' type='button' class='btn xCNBtnBrowseAddOn'><img class='xCNIconFind'></button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    ";
                            }
                            $tCoditionReport .= "</div>";
                            /*===== End แบบเลือก ============================================*/

                            $tCoditionReport .= "</div>"; // End xCNFilterBox
                            break;
                        }
                    case '201': { // Filter Pos (ค้นหาข้อมูลเครื่องจุดขาย)
                            $tCoditionLabelReport   .= "<div><p class='xCNTextLabel xCNTextLabelMargin'>" . language('report/report/report', 'tRptVending') . "</p></div>";
                            $tCoditionReport        .= "<div class='xCNFilterBox'>";

                            /*===== Begin แบบเลือก ==========================================*/
                            $tCoditionReport .= "<div id='odvConditionSelect" . $aRptFilValue['FTRptFltCode'] . "' class='row xCNFilterSelectMode'>";
                            if ($aRptFilValue['FTRptFltStaFrm'] == '1') {
                                $tCoditionReport .= "
                                        <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                                            <div class='form-group'>
                                                <div class='input-group'>
                                                    <input type='text' class='form-control xCNHide xWRptAllInput' id='oetRptPosType' name='oetRptPosType' value='4'>
                                                    <input type='text' class='form-control xCNHide xWRptAllInput' id='oetRptPosStaSelectAll' name='oetRptPosStaSelectAll'>
                                                    <input type='text' class='form-control xCNHide xWRptAllInput' id='oetRptPosCodeSelect' name='oetRptPosCodeSelect'>
                                                    <input type='text' class='form-control xWPointerEventNone xWRptAllInput' id='oetRptPosNameSelect' name='oetRptPosNameSelect' readonly>
                                                    <span class='input-group-btn'>
                                                        <button id='obtRptMultiBrowsePos' type='button' class='btn xCNBtnBrowseAddOn'><img class='xCNIconFind'></button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    ";
                            }
                            $tCoditionReport .= "</div>";
                            /*===== End แบบเลือก ============================================*/

                            $tCoditionReport .= "</div>"; // End xCNFilterBox
                            break;
                        }
                    case '6': { // From - To MerChant Group (ค้นหาข้อมูลกลุ่มธุรกิจ จาก - ถึง)
                            if (FCNbGetIsShpEnabled()) {
                                $tCoditionLabelReport   .= "<div><p class='xCNTextLabel xCNTextLabelMargin'>" . language('report/report/report', 'tRptMultiMerchant') . "</p></div>";
                                $tCoditionReport        .= "<div class='xCNFilterBox'>";
                                /*===== Begin แบบช่วง ===========================================*/
                                $tCoditionReport .= "<div id='odvCondition" . $aRptFilValue['FTRptFltCode'] . "' class='row xCNFilterRangeMode'>";
                                if ($aRptFilValue['FTRptFltStaFrm'] == '1') {
                                    $tCoditionReport .= "
                                        <div class=''>
                                            <div class='col-lg-6'>
                                                <div class='form-group'>
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
                                            <div class='col-lg-1'>
                                                <p class='xCNTextTo'>" . language('report/report/report', 'tRptCoditionTo') . "</p>
                                            </div>
                                            <div class='col-lg-5'>
                                                <div class='form-group'>
                                                    <div class='input-group'>
                                                        <input type='text' class='form-control xCNHide xWRptAllInput' id='oetRptMerCodeTo' name='oetRptMerCodeTo' maxlength='5'>
                                                        <input type='text' class='form-control xWPointerEventNone xWRptAllInput' id='oetRptMerNameTo' name='oetRptMerNameTo' readonly>
                                                        <span class='input-group-btn'>
                                                            <button id='obtRptBrowseMerTo' type='button' class='btn xCNBtnBrowseAddOn'><img class='xCNIconFind'></button>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    ";
                                }
                                $tCoditionReport .= "</div>";
                                /*===== End แบบช่วง =============================================*/

                                /*===== Begin แบบเลือก ==========================================*/
                                $tCoditionReport .= "<div id='odvConditionSelect" . $aRptFilValue['FTRptFltCode'] . "' class='row xCNFilterSelectMode'>";
                                if ($aRptFilValue['FTRptFltStaFrm'] == '1') {
                                    $tCoditionReport .= "
                                        <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                                            <div class='form-group'>
                                                <div class='input-group'>
                                                    <input type='text' class='form-control xCNHide xWRptAllInput' id='oetRptMerStaSelectAll' name='oetRptMerStaSelectAll'>
                                                    <input type='text' class='form-control xCNHide xWRptAllInput' id='oetRptMerCodeSelect' name='oetRptMerCodeSelect'>
                                                    <input type='text' class='form-control xWPointerEventNone xWRptAllInput' id='oetRptMerNameSelect' name='oetRptMerNameSelect' readonly>
                                                    <span class='input-group-btn'>
                                                        <button id='obtRptMultiBrowseMerchant' type='button' class='btn xCNBtnBrowseAddOn'><img class='xCNIconFind'></button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    ";
                                }
                                $tCoditionReport .= "</div>";
                                /*===== End แบบเลือก ============================================*/

                                $tCoditionReport .= "</div>"; // End xCNFilterBox
                            } else {
                                echo "<input type='text' class='form-control xCNHide xWRptAllInput' id='oetRptMerStaSelectAll' name='oetRptMerStaSelectAll'>
                                    <input type='text' class='form-control xCNHide xWRptAllInput' id='oetRptMerCodeSelect' name='oetRptMerCodeSelect'>
                                    <input type='text' class='form-control xCNHide xWPointerEventNone xWRptAllInput' id='oetRptMerNameSelect' name='oetRptMerNameSelect' readonly>";
                            }
                            break;
                        }
                    case '4': { // Filter Doc Date (วันที่สร้างเอกสาร)

                            if ($aRptFilterData['raItems']['rtRptCode'] == '001003002') {
                                //รายงานภาษีขายรายวัน จะใช้คำว่าวันที่
                                $tCoditionLabelReport   .= "<div><p class='xCNTextLabel xCNTextLabelMargin'>" . language('report/report/report', 'tRptDate') . "</p></div>";
                            } else {
                                //รายงานอื่นๆ จะใช้คำว่าวันที่เอกสาร
                                $tCoditionLabelReport   .= "<div><p class='xCNTextLabel xCNTextLabelMargin'>" . language('report/report/report', 'tRptDateDocument') . "</p></div>";
                            }

                            $tCoditionReport        .= "<div id='odvCondition" . $aRptFilValue['FTRptFltCode'] . "' class='row'>";
                            if ($aRptFilValue['FTRptFltStaFrm'] == '1') {
                                $tCoditionReport .= "
                                        <div class=''>
                                            <div class='col-lg-6'>
                                                <div class='form-group'>
                                                    <div class='input-group'>
                                                        <input type='text' class='form-control xCNDatePicker xCNDatePickerStart xCNInputMaskDate xWRptAllInput' autocomplete='off' id='oetRptDocDateFrom' name='oetRptDocDateFrom'>
                                                        <span class='input-group-btn'>
                                                            <button id='obtRptBrowseDocDateFrom' type='button' class='btn xCNBtnDateTime'><img class='xCNIconCalendar'></button>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                    ";
                            }
                            if ($aRptFilValue['FTRptFltStaTo'] == '1') {
                                if ($aRptFilterData['raItems']['rtRptCode'] == '001003002') {
                                    //รายงานภาษีขายรายวัน จะไม่มี วันที่ถึง
                                    $tCoditionReport .= "";
                                } else {
                                    //รายงานอื่นๆ จะมี วันที่ถึง
                                    $tCoditionReport .= "
                                                <div class='col-lg-1'>
                                                    <p class='xCNTextTo'>" . language('report/report/report', 'tRptCoditionTo') . "</p>
                                                </div>
                                                <div class='col-lg-5'>
                                                    <div class='form-group'>
                                                        <div class='input-group'>
                                                            <input type='text' class='form-control xCNDatePicker xCNDatePickerEnd xCNInputMaskDate xWRptAllInput' autocomplete='off' id='oetRptDocDateTo' name='oetRptDocDateTo'>
                                                            <span class='input-group-btn'>
                                                                <button id='obtRptBrowseDocDateTo' type='button' class='btn xCNBtnDateTime'><img class='xCNIconCalendar'></button>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        ";
                                }
                            }
                            $tCoditionReport .= "</div>"; ?>

                            <?php
                            //รายงานภาษีขาย(รายเดือน) จะมีเงื่อนไขคือ จะเลือกได้เฉพาะวันที่ภายในเดือนของตัวเองเท่านั้น
                            if ($aRptFilterData['raItems']['rtRptCode'] == '001003010') { ?>
                                <script>
                                    var dDate = new Date();
                                    var dFirstDay = new Date(dDate.getFullYear(), dDate.getMonth(), 1);
                                    var dLastDay = new Date(dDate.getFullYear(), dDate.getMonth() + 1, 0);
                                    var dMonth = 0;
                                    var dYear = 2019;

                                    $(".xCNDatePickerStart").datepicker({
                                        format: 'yyyy-mm-dd',
                                        autoclose: true,
                                        todayHighlight: true
                                    });

                                    $('.xCNDatePickerStart').datepicker().on('changeDate', function(ev) {
                                        $(".xCNDatePickerEnd").datepicker("destroy");

                                        var dDateStart = $(".xCNDatePickerStart").val();
                                        $('#oetRptDocDateTo').val(dDateStart);

                                        if (dDateStart == '' || dDateStart == null) {
                                            var dMonth = dDate.getMonth();
                                            var dYear = dDate.getFullYear();
                                        } else {
                                            var aSplitDate = dDateStart.split("-");
                                            var aMonth = aSplitDate[1];
                                            var dYear = aSplitDate[0];
                                            var dMonth = aMonth
                                        }

                                        $(".xCNDatePickerEnd").datepicker({
                                            format: 'yyyy-mm-dd',
                                            autoclose: true,
                                            startDate: new Date(dYear, dMonth - 1, 1),
                                            endDate: new Date(dYear, dMonth, 0)
                                        });

                                        $(".xCNDatePickerEnd").datepicker("refresh");
                                    });
                                </script>
                <?php }
                            break;
                        }
                    case '38': { // Filter ตู้(Locker)
                            $tCoditionLabelReport   .= "<div><p class='xCNTextLabel xCNTextLabelMargin'>" . language('report/report/report', 'tRptSaleByPaymentDetailRack') . "</p></div>";
                            $tCoditionReport        .= "<div class='xCNFilterBox'>";

                            /*===== Begin แบบช่วง ===========================================*/
                            $tCoditionReport    .= "<div id='odvCondition" . $aRptFilValue['FTRptFltCode'] . "' class='row xCNFilterRangeMode'>";
                            if ($aRptFilValue['FTRptFltStaFrm'] == '1') {
                                $tCoditionReport .= "
                                    <div class=''>
                                        <div class='col-lg-6'>
                                            <div class='form-group'>
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
                                            <div class='col-lg-1'>
                                                <p class='xCNTextTo'>" . language('report/report/report', 'tRptCoditionTo') . "</p>
                                            </div>
                                            <div class='col-lg-5'>
                                                <div class='form-group'>
                                                    <div class='input-group'>
                                                        <input type='text' class='form-control xCNHide xWRptAllInput' id='oetRptLockerCodeTo' name='oetRptLockerCodeTo' maxlength='5'>
                                                        <input type='text' class='form-control xWPointerEventNone xWRptAllInput' id='oetRptLockerNameTo' name='oetRptLockerNameTo' readonly>
                                                        <span class='input-group-btn'>
                                                            <button id='obtRptBrowseLockerTo' type='button' class='btn xCNBtnBrowseAddOn'><img class='xCNIconFind'></button>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    ";
                            }
                            $tCoditionReport    .= "</div>";
                            /*===== End แบบช่วง =============================================*/

                            /*===== Begin แบบเลือก ==========================================*/
                            $tCoditionReport .= "<div id='odvConditionSelect" . $aRptFilValue['FTRptFltCode'] . "' class='row xCNFilterSelectMode'>";
                            if ($aRptFilValue['FTRptFltStaFrm'] == '1') {
                                $tCoditionReport .= "
                                        <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                                            <div class='form-group'>
                                                <div class='input-group'>
                                                    <input type='text' class='form-control xCNHide xWRptAllInput' id='oetRptLockerStaSelectAll' name='oetRptLockerStaSelectAll'>
                                                    <input type='text' class='form-control xCNHide xWRptAllInput' id='oetRptLockerCodeSelect' name='oetRptLockerCodeSelect'>
                                                    <input type='text' class='form-control xWPointerEventNone xWRptAllInput' id='oetRptLockerNameSelect' name='oetRptLockerNameSelect' readonly>
                                                    <span class='input-group-btn'>
                                                        <button id='obtRptMultiBrowseLockerPos' type='button' class='btn xCNBtnBrowseAddOn'><img class='xCNIconFind'></button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    ";
                            }
                            $tCoditionReport .= "</div>";
                            /*===== End แบบเลือก ============================================*/

                            $tCoditionReport .= "</div>"; // End xCNFilterBox
                            break;
                        }
                }

                if (in_array($aRptFilterData['raItems']['rtGrpRptCode'], ["001001", "001002", "001003", "0003001"])) {
                    $tAlwBTN = true;
                } else {
                    $tAlwBTN = false;
                }
                ?>
            <?php endforeach; ?>

            <!--ชื่อหัวข้อฟิวส์เตอร์-->
            <div class="col-lg-3">
                <div class="row">
                    <div class="col-lg-12">
                        <p class="xCNFontHead"><?= language('report/report/report', 'tRptHeadConditionReport') ?></p>
                    </div>
                    <div class="col-lg-12"  id='odvFontHead'>
                        <hr>
                    </div>
                    <div class="col-lg-12"  id='odvConditionLabelReport'>
                        <?= $tCoditionLabelReport ?>
                    </div>
                </div>
            </div>

            <!--รายละเอียดฟิวส์เตอร์-->
            <div class="col-lg-9 xCNPanalCondition">

                <!-- ปุ่มเลือกตามข้อมูล , ปุ่มเลือกตามช่วง , ปุ่มล้างข้อมูล -->
                <div class="row">
                    <div class="col-lg-3 col-md-3 col-sm-4">
                        <!-- <button id="obtRptSelectCondition" class="btn xCNBTNConditionActive xCNClickConditionSelect xCNBTNReport" style="font-size:16px; min-width: 100%;"><?//=language('report/report/report', 'tRptBTNSelectRange')?></button> -->
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-4">
                        <?php if ($tAlwBTN == true) { ?>
                            <!-- <button id="obtRptBetweenCondition" class="btn xCNBTNConditionBetween xCNClickConditionBetween xCNBTNReport" style="font-size:16px; min-width: 100%;"><?//=language('report/report/report', 'tRptBTNSelectData')?></button> -->
                        <?php } ?>
                    </div>
                    <!-- <input type="hidden" id="ohdTypeDataCondition" name="ohdTypeDataCondition" value="1"> -->
                    <input type="hidden" id="ohdTypeDataCondition" name="ohdTypeDataCondition" value="2">
                    <div class="col-lg-4 col-md-4 col-sm-4 col-md-offset-2 text-right">
                        <button id="obtRptClearCondition" class="btn xCNBTNConditionClear xCNBTNReport" style="font-weight: bold; font-size:16px; width:100%;"><?= language('report/report/report', 'tRptClearCondition') ?></button>
                    </div>
                </div>

                <!-- ฟิวส์เตอร์เอามาโชว์ -->
                <div class="row">
                    <div class="col-lg-12" style="margin-top:20px;">
                        <?= $tCoditionReport; ?>
                    </div>
                </div>
            </div>

        </div>
    </div>
<?php endif; ?>
<!--จบเงือนไขการค้นหาส่วนบน-->

<!--เงือนไขเพิ่มเติมส่วนล่าง-->
<?php
//ตรวจสอบว่ามีฟิวส์เตอร์ อันอื่นไหม ที่นอกจาก 6 ตัวบน
$aCheckFltGroup = array();
foreach ($aRptFilterData['raItems']['raRptFilterCol'] as $nKey => $aRptFilValue) {
    if (!in_array($aRptFilValue['FTRptFltCode'], ["1", "2", "3", "4", "6", "38", "200", "201"])) {
        array_push($aCheckFltGroup, "true");
    }
}

if (FCNnHSizeOf($aCheckFltGroup) == 0) {
    $bSesstionDown = false;
} else {
    $bSesstionDown = true;
}
?>
<?php if (isset($aRptFilterData) && $aRptFilterData['rtCode'] == 1 && $bSesstionDown == true) : ?>
    <div id="odvConditionNewUISestionDown<?= $aRptFilterData['raItems']['rtRptCode'] ?>">
        <div class="row">

            <!--ชื่อหัวข้อฟิวส์เตอร์-->
            <div class="col-lg-3">
                <div class="row">
                    <br>
                </div>
            </div>

            <!--รายละเอียดฟิวส์เตอร์-->
            <div class="col-lg-12">
                <table class="table table-bordered xCNTableBorderSub">
                    <thead>
                        <tr>
                            <th style="width: 21.25%;">
                                <p class="xCNFontTDGroupFilter"><?= language('report/report/report', 'tRptHeadConditionReportETC') ?></p>
                            </th>
                            <th style="width: 5%;">
                                <p class="xCNFontTDGroupFilter" style="text-align: center;"><?= language('report/report/report', 'tRptAll') ?></p>
                            </th>
                            <th style="width: 30%;">
                                <p class="xCNFontTDGroupFilter"><?= language('report/report/report', 'tRptCoditionFrom') ?></p>
                            </th>
                            <th style="width: 30%;">
                                <p class="xCNFontTDGroupFilter"><?= language('report/report/report', 'tRptCoditionTo') ?></p>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $tGroupFilter           = '';
                        $tCoditionReportFrom    = '';
                        $tCoditionReportTo      = '';
                        asort($aRptFilterData['raItems']['raRptFilterCol']);
                        foreach ($aRptFilterData['raItems']['raRptFilterCol'] as $nKey => $aRptFilValue) : ?>

                            <?php
                            switch ($aRptFilValue['FTRptFltCode']) {
                                case '5': { // Filter Year (ปี)
                                        $dDateDefult    = date("Y");
                                        if ($aRptFilValue['FTRptFltStaFrm'] == '1' || $aRptFilValue['FTRptFltStaTo'] == '1') {
                                            $tCoditionReportFrom .= "
                                                <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                                                    <div class='xCNInputNewUIBrowse'>
                                                        <div class='input-group'>
                                                            <input type='text' class='form-control xCNYearPicker xWRptAllInput xCNInputNewUI' id='oetRptYear' name='oetRptYear' value='" . $dDateDefult . "'>
                                                            <span class='input-group-btn'>
                                                                <button id='obtRptBrowseYear' type='button' class='btn xCNButtonNewUI'><img class='xCNIconCalendar'></button>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            ";
                                        }
                                        break;
                                    }
                                case '7': { // From - To PaymentType Group (ค้นหาข้อมูลประเภทการชำระ จาก - ถึง)
                                        /*===== Begin แบบช่วง ===========================================*/
                                        if ($aRptFilValue['FTRptFltStaFrm'] == '1') {
                                            $tCoditionReportFrom .= "
                                                <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                                                    <div class='xCNInputNewUIBrowse'>
                                                        <div class='input-group' style='width: 100%;'>
                                                            <input type='text' class='form-control xCNHide xWRptAllInput' id='oetRptRcvCodeFrom' name='oetRptRcvCodeFrom' maxlength='5'>
                                                            <input type='text' class='form-control xWPointerEventNone xWRptAllInput xCNInputNewUI' id='oetRptRcvNameFrom' name='oetRptRcvNameFrom' readonly>
                                                            <span class='input-group-btn'>
                                                                <button id='obtRptBrowseRcvFrom' type='button' class='btn xCNButtonNewUI'> <img class='xCNIconFind'></button>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            ";
                                        }
                                        if ($aRptFilValue['FTRptFltStaTo'] == '1') {
                                            $tCoditionReportTo .= "
                                                <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                                                    <div class='xCNInputNewUIBrowse'>
                                                        <div class='input-group' style='width: 100%;'>
                                                            <input type='text' class='form-control xCNHide xWRptAllInput' id='oetRptRcvCodeTo' name='oetRptRcvCodeTo' maxlength='5'>
                                                            <input type='text' class='form-control xWPointerEventNone xWRptAllInput xCNInputNewUI' id='oetRptRcvNameTo' name='oetRptRcvNameTo' readonly>
                                                            <span class='input-group-btn'>
                                                                <button id='obtRptBrowseRcvTo' type='button' class='btn xCNButtonNewUI'><img class='xCNIconFind'></button>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            ";
                                        }

                                        /*===== End แบบช่วง =============================================*/
                                        break;
                                    }
                                case '8': { // From - To Product  Group (ค้นหาข้อมูลกลุ่มสินค้า จาก - ถึง)
                                        /*===== Begin แบบช่วง ===========================================*/
                                        if ($aRptFilValue['FTRptFltStaFrm'] == '1') {
                                            $tCoditionReportFrom .= "
                                                <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                                                    <div class='xCNInputNewUIBrowse'>
                                                        <div class='input-group' style='width: 100%;'>
                                                            <input type='text' class='form-control xCNHide xWRptAllInput' id='oetRptPdtGrpCodeFrom' name='oetRptPdtGrpCodeFrom' maxlength='5'>
                                                            <input type='text' class='form-control xWPointerEventNone xWRptAllInput xCNInputNewUI' id='oetRptPdtGrpNameFrom' name='oetRptPdtGrpNameFrom' readonly>
                                                            <span class='input-group-btn'>
                                                                <button id='obtRptBrowsePdtGrpFrom' type='button' class='btn xCNButtonNewUI'> <img class='xCNIconFind'></button>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            ";
                                        }
                                        if ($aRptFilValue['FTRptFltStaTo'] == '1') {
                                            $tCoditionReportTo .= "
                                                <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                                                    <div class='xCNInputNewUIBrowse'>
                                                        <div class='input-group' style='width: 100%;'>
                                                            <input type='text' class='form-control xCNHide xWRptAllInput' id='oetRptPdtGrpCodeTo' name='oetRptPdtGrpCodeTo' maxlength='5'>
                                                            <input type='text' class='form-control xWPointerEventNone xWRptAllInput xCNInputNewUI' id='oetRptPdtGrpNameTo' name='oetRptPdtGrpNameTo' readonly>
                                                            <span class='input-group-btn'>
                                                                <button id='obtRptBrowsePdtGrpTo' type='button' class='btn xCNButtonNewUI'><img class='xCNIconFind'></button>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            ";
                                        }
                                        /*===== End แบบช่วง =============================================*/
                                        break;
                                    }
                                case '9': { // From - To Product Type (ค้นหาข้อมูลประเภทสินค้า จาก - ถึง)
                                        /*===== Begin แบบช่วง ===========================================*/
                                        if ($aRptFilValue['FTRptFltStaFrm'] == '1') {
                                            $tCoditionReportFrom .= "
                                                <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                                                    <div class='xCNInputNewUIBrowse'>
                                                        <div class='input-group' style='width: 100%;'>
                                                            <input type='text' class='form-control xCNHide xWRptAllInput' id='oetRptPdtTypeCodeFrom' name='oetRptPdtTypeCodeFrom' maxlength='5'>
                                                            <input type='text' class='form-control xWPointerEventNone xWRptAllInput xCNInputNewUI' id='oetRptPdtTypeNameFrom' name='oetRptPdtTypeNameFrom' readonly>
                                                            <span class='input-group-btn'>
                                                                <button id='obtRptBrowsePdtTypeFrom' type='button' class='btn xCNButtonNewUI'> <img class='xCNIconFind'></button>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            ";
                                        }
                                        if ($aRptFilValue['FTRptFltStaTo'] == '1') {
                                            $tCoditionReportTo .= "
                                                <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                                                    <div class='xCNInputNewUIBrowse'>
                                                        <div class='input-group' style='width: 100%;'>
                                                            <input type='text' class='form-control xCNHide xWRptAllInput' id='oetRptPdtTypeCodeTo' name='oetRptPdtTypeCodeTo' maxlength='5'>
                                                            <input type='text' class='form-control xWPointerEventNone xWRptAllInput xCNInputNewUI' id='oetRptPdtTypeNameTo' name='oetRptPdtTypeNameTo' readonly>
                                                            <span class='input-group-btn'>
                                                                <button id='obtRptBrowsePdtTypeTo' type='button' class='btn xCNButtonNewUI'><img class='xCNIconFind'></button>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            ";
                                        }
                                        /*===== End แบบช่วง =============================================*/
                                        break;
                                    }
                                case '10': { // อันดับสูงสุด
                                        if ($aRptFilValue['FTRptFltStaFrm'] == '1' || $aRptFilValue['FTRptFltStaTo'] == '1') {
                                            $tCoditionReportFrom    .= "
                                                <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                                                    <div class=''>
                                                        <div class='input-group xWInputGrpPriority xCNNewUISelect' style='width:100%'>
                                                            <select class='selectpicker xCNNewUISelectoption' id='ocmBchPriority' name='ocmBchPriority'>
                                                                <option value='5'>5</option>
                                                                <option value='10'>10</option>
                                                                <option value='20'>20</option>
                                                                <option value='50'>50</option>
                                                                <option value='100'>100</option>
                                                                <option value='200'>200</option>
                                                                <option value='500'>500</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            ";
                                        }
                                        break;
                                    }
                                case '11': { // Merchant (ค้นหาข้อมูลกลุ่มธุรกิจ) เดี่ยว ไม่มี จาก - ถึง
                                        // $tCoditionReport    .= "<div id='odvCondition".$aRptFilValue['FTRptFltCode']."' class='row'>";
                                        // if (($aRptFilValue['FTRptFltStaFrm'] == '1' && $aRptFilValue['FTRptFltStaTo'] == '0') || ($aRptFilValue['FTRptFltStaFrm'] == '0' && $aRptFilValue['FTRptFltStaTo'] == '1')) {
                                        //     $tCoditionReport    .= "
                                        //         <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                                        //             <div class='form-group'>
                                        //                 <label class='xCNLabelFrm'>".$aRptFilValue['FTRptFltName']."</label>
                                        //                 <div class='input-group'>
                                        //                     <input type='text' class='form-control xCNHide xWRptAllInput' id='oetRptMerchantCode' name='oetRptMerchantCode' maxlength='5'>
                                        //                     <input type='text' class='form-control xWPointerEventNone xWRptAllInput' id='oetRptMerchantName' name='oetRptMerchantName' readonly>
                                        //                     <span class='input-group-btn'>
                                        //                         <button id='obtRptBrowseMerchant' type='button' class='btn xCNBtnBrowseAddOn'> <img class='xCNIconFind'></button>
                                        //                     </span>
                                        //                 </div>
                                        //             </div>
                                        //         </div>
                                        //     ";
                                        // }
                                        // $tCoditionReport .= "</div>";
                                        break;
                                    }
                                case '12': { // WareHouse (ค้นหาข้อมูลคลังสินค้า)
                                        /*===== Begin แบบช่วง ===========================================*/
                                        $tCoditionReport .= "<div id='odvCondition" . $aRptFilValue['FTRptFltCode'] . "' class='row xCNFilterRangeMode-'>";
                                        if ($aRptFilValue['FTRptFltStaFrm'] == '1') {
                                            $tCoditionReportFrom .= "
                                                <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                                                    <div class='xCNInputNewUIBrowse'>
                                                        <div class='input-group' style='width: 100%;'>
                                                            <input type='text' class='form-control xCNHide xWRptAllInput' id='oetRptWahCodeFrom' name='oetRptWahCodeFrom' maxlength='5'>
                                                            <input type='text' class='form-control xWPointerEventNone xWRptAllInput xCNInputNewUI' id='oetRptWahNameFrom' name='oetRptWahNameFrom' readonly>
                                                            <span class='input-group-btn'>
                                                                <button id='obtRptBrowseWahFrom' type='button' class='btn xCNButtonNewUI'> <img class='xCNIconFind'></button>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            ";
                                        }
                                        if ($aRptFilValue['FTRptFltStaTo'] == '1') {
                                            $tCoditionReportTo .= "
                                                <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                                                    <div class='xCNInputNewUIBrowse'>
                                                        <div class='input-group' style='width: 100%;'>
                                                            <input type='text' class='form-control xCNHide xWRptAllInput' id='oetRptWahCodeTo' name='oetRptWahCodeTo' maxlength='5'>
                                                            <input type='text' class='form-control xWPointerEventNone xWRptAllInput xCNInputNewUI' id='oetRptWahNameTo' name='oetRptWahNameTo' readonly>
                                                            <span class='input-group-btn'>
                                                                <button id='obtRptBrowseWahTo' type='button' class='btn xCNButtonNewUI'><img class='xCNIconFind'></button>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            ";
                                        }
                                        /*===== End แบบช่วง =============================================*/
                                        break;
                                    }
                                case '13': { // Product (ค้นหาข้อมูลสินค้า)
                                        /*===== Begin แบบช่วง ===========================================*/
                                        if ($aRptFilValue['FTRptFltStaFrm'] == '1') {
                                            $tCoditionReportFrom .= "
                                                <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                                                    <div class='xCNInputNewUIBrowse'>
                                                        <div class='input-group' style='width: 100%;'>
                                                            <input type='text' class='form-control xCNHide xWRptAllInput' id='oetRptPdtCodeFrom' name='oetRptPdtCodeFrom' maxlength='5'>
                                                            <input type='text' class='form-control xWPointerEventNone xWRptAllInput xCNInputNewUI' id='oetRptPdtNameFrom' name='oetRptPdtNameFrom' readonly>
                                                            <span class='input-group-btn'>
                                                                <button id='obtRptBrowsePdtFrom' type='button' class='btn xCNButtonNewUI'> <img class='xCNIconFind'></button>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            ";
                                        }
                                        if ($aRptFilValue['FTRptFltStaTo'] == '1') {
                                            $tCoditionReportTo .= "
                                                <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                                                    <div class='xCNInputNewUIBrowse'>
                                                        <div class='input-group' style='width: 100%;'>
                                                            <input type='text' class='form-control xCNHide xWRptAllInput' id='oetRptPdtCodeTo' name='oetRptPdtCodeTo' maxlength='5'>
                                                            <input type='text' class='form-control xWPointerEventNone xWRptAllInput xCNInputNewUI' id='oetRptPdtNameTo' name='oetRptPdtNameTo' readonly>
                                                            <span class='input-group-btn'>
                                                                <button id='obtRptBrowsePdtTo' type='button' class='btn xCNButtonNewUI'><img class='xCNIconFind'></button>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            ";
                                        }
                                        /*===== End แบบช่วง =============================================*/
                                        break;
                                    }
                                case '14': { // บริษัท ขนส่ง
                                        /*===== Begin แบบช่วง ===========================================*/
                                        if ($aRptFilValue['FTRptFltStaFrm'] == '1') {
                                            $tCoditionReportFrom .= "
                                                <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                                                    <div class='xCNInputNewUIBrowse'>
                                                        <div class='input-group' style='width: 100%;'>
                                                            <input type='text' class='form-control xCNHide xWRptAllInput' id='oetRptCourierCodeFrom' name='oetRptCourierCodeFrom' maxlength='5'>
                                                            <input type='text' class='form-control xWPointerEventNone xWRptAllInput xCNInputNewUI' id='oetRptCourierNameFrom' name='oetRptCourierNameFrom' readonly>
                                                            <span class='input-group-btn'>
                                                                <button id='obtRptBrowseCourierFrom' type='button' class='btn xCNButtonNewUI'> <img class='xCNIconFind'></button>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            ";
                                        }
                                        if ($aRptFilValue['FTRptFltStaTo'] == '1') {
                                            $tCoditionReportTo .= "
                                                <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                                                    <div class='xCNInputNewUIBrowse'>
                                                        <div class='input-group' style='width: 100%;'>
                                                            <input type='text' class='form-control xCNHide xWRptAllInput' id='oetRptCourierCodeTo' name='oetRptCourierCodeTo' maxlength='5'>
                                                            <input type='text' class='form-control xWPointerEventNone xWRptAllInput xCNInputNewUI' id='oetRptCourierNameTo' name='oetRptCourierNameTo' readonly>
                                                            <span class='input-group-btn'>
                                                                <button id='obtRptBrowseCourierTo' type='button' class='btn xCNButtonNewUI'><img class='xCNIconFind'></button>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            ";
                                        }
                                        /*===== End แบบช่วง =============================================*/
                                        break;
                                    }
                                case '15': { // กลุ่มช่อง
                                        /*===== Begin แบบช่วง ===========================================*/
                                        if ($aRptFilValue['FTRptFltStaFrm'] == '1') {
                                            $tCoditionReportFrom .= "
                                                <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                                                    <div class='xCNInputNewUIBrowse'>
                                                        <div class='input-group' style='width: 100%;'>
                                                            <input type='text' class='form-control xCNHide xWRptAllInput' id='oetSMLBrowseGroupCodeFrom' name='oetSMLBrowseGroupCodeFrom' maxlength='5'>
                                                            <input type='text' class='form-control xWPointerEventNone xWRptAllInput xCNInputNewUI' id='oetSMLBrowseGroupNameFrom' name='oetSMLBrowseGroupNameFrom' readonly>
                                                            <span class='input-group-btn'>
                                                                <button id='obtSMLBrowseGroupFrom' type='button' class='btn xCNButtonNewUI'> <img class='xCNIconFind'></button>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            ";
                                        }
                                        if ($aRptFilValue['FTRptFltStaTo'] == '1') {
                                            $tCoditionReportTo .= "
                                                <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                                                    <div class='xCNInputNewUIBrowse'>
                                                        <div class='input-group' style='width: 100%;'>
                                                            <input type='text' class='form-control xCNHide xWRptAllInput' id='oetSMLBrowseGroupCodeTo' name='oetSMLBrowseGroupCodeTo' maxlength='5'>
                                                            <input type='text' class='form-control xWPointerEventNone xWRptAllInput xCNInputNewUI' id='oetSMLBrowseGroupNameTo' name='oetSMLBrowseGroupNameTo' readonly>
                                                            <span class='input-group-btn'>
                                                                <button id='obtSMLBrowseGroupTo' type='button' class='btn xCNButtonNewUI'><img class='xCNIconFind'></button>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            ";
                                        }
                                        /*===== End แบบช่วง =============================================*/
                                        break;
                                    }
                                case '16': { // หมายเลขบัตร
                                        /*===== Begin แบบช่วง ===========================================*/
                                        $tCoditionReport .= "<div id='odvCondition" . $aRptFilValue['FTRptFltCode'] . "' class='row xCNFilterRangeMode-'>";
                                        if ($aRptFilValue['FTRptFltStaFrm'] == '1') {
                                            $tCoditionReportFrom .= "
                                                <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                                                    <div class='xCNInputNewUIBrowse'>
                                                        <div class='input-group' style='width: 100%;'>
                                                            <input type='text' class='form-control xCNHide xWRptAllInput' id='oetRptCardCodeFrom' name='oetRptCardCodeFrom' maxlength='5'>
                                                            <input type='text' class='form-control xWPointerEventNone xWRptAllInput xCNInputNewUI' id='oetRptCardNameFrom' name='oetRptCardNameFrom' readonly>
                                                            <span class='input-group-btn'>
                                                                <button id='obtRPCBrowseCardFrom' type='button' class='btn xCNButtonNewUI'> <img class='xCNIconFind'></button>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            ";
                                        }
                                        // ถึงหมายเลขบัตร
                                        if ($aRptFilValue['FTRptFltStaTo'] == '1') {
                                            $tCoditionReportTo .= "
                                                <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                                                    <div class='xCNInputNewUIBrowse'>
                                                        <div class='input-group' style='width: 100%;'>
                                                            <input type='text' class='form-control xCNHide xWRptAllInput' id='oetRptCardCodeTo' name='oetRptCardCodeTo' maxlength='5'>
                                                            <input type='text' class='form-control xWPointerEventNone xWRptAllInput xCNInputNewUI' id='oetRptCardNameTo' name='oetRptCardNameTo' readonly>
                                                            <span class='input-group-btn'>
                                                                <button id='obtRPCBrowseCardTo' type='button' class='btn xCNButtonNewUI'><img class='xCNIconFind'></button>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            ";
                                        }
                                        /*===== End แบบช่วง =============================================*/

                                        break;
                                    }
                                case '17': { // ประเภทบัตร
                                        /*===== Begin แบบช่วง ===========================================*/
                                        if ($aRptFilValue['FTRptFltStaFrm'] == '1') {
                                            $tCoditionReportFrom .= "
                                                <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                                                    <div class='xCNInputNewUIBrowse'>
                                                        <div class='input-group' style='width: 100%;'>
                                                            <input class='form-control xCNHide xWRptConsCrdInput' id='oetRptCardTypeCodeFrom' name='oetRptCardTypeCodeFrom' maxlength='5' value=''>
                                                            <input class='form-control xWPointerEventNone xWRptConsCrdInput xCNInputNewUI' type='text' id='oetRptCardTypeNameFrom' name='oetRptCardTypeNameFrom' value='' readonly=''>
                                                            <span class='input-group-btn'>
                                                                <button id='obtRPCBrowseCardTypeFrom' type='button' class='btn xCNButtonNewUI'><img class='xCNIconFind'></button>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            ";
                                        }
                                        // ถึงประเภทบัตร
                                        if ($aRptFilValue['FTRptFltStaTo'] == '1') {
                                            $tCoditionReportTo .= "
                                                <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                                                    <div class='xCNInputNewUIBrowse'>
                                                        <div class='input-group' style='width: 100%;'>
                                                            <input class='form-control xCNHide xWRptConsCrdInput' id='oetRptCardTypeCodeTo' name='oetRptCardTypeCodeTo' maxlength='5' value=''>
                                                            <input class='form-control xWPointerEventNone xWRptConsCrdInput xCNInputNewUI' type='text' id='oetRptCardTypeNameTo' name='oetRptCardTypeNameTo' value='' readonly=''>
                                                            <span class='input-group-btn'>
                                                                <button id='obtRPCBrowseCardTypeTo' type='button' class='btn xCNButtonNewUI'><img class='xCNIconFind'></button>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            ";
                                        }
                                        /*===== End แบบช่วง =============================================*/
                                        break;
                                    }
                                case '18': { // สถานะบัตร
                                        if ($aRptFilValue['FTRptFltStaFrm'] == '1') {
                                            $tCoditionReportFrom .= "
                                                <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                                                    <div class=''>
                                                        <input type='hidden' name='ohdRptStaCardNameFrom' id='ohdRptStaCardNameFrom' value=''/>
                                                        <div class='input-group xCNNewUISelect' style='width:100%'>
                                                            <select class='selectpicker-crd-sta-from form-control xCNNewUISelectoption' id='ocmRptStaCardFrom' name='ocmRptStaCardFrom' maxlength='1'>
                                                                <option value=''>" . language('report/report/report', 'tCMNBlank-NA') . "</option>
                                                                <option value='1'>" . language('report/report/report', 'tRPCCardDetailStaActive1') . "</option>
                                                                <option value='2'>" . language('report/report/report', 'tRPCCardDetailStaActive2') . "</option>
                                                                <option value='3'>" . language('report/report/report', 'tRPCCardDetailStaActive3') . "</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            ";
                                        }
                                        // ถึงสถานะบัตร
                                        if ($aRptFilValue['FTRptFltStaTo'] == '1') {
                                            $tCoditionReportTo .= "
                                                <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                                                    <div class=''>
                                                        <input type='hidden' name='ohdRptStaCardNameTo' id='ohdRptStaCardNameTo' value=''/>
                                                        <div class='input-group xCNNewUISelect' style='width:100%'>
                                                            <select class='selectpicker-crd-sta-to form-control xCNNewUISelectoption' id='ocmRptStaCardTo' name='ocmRptStaCardTo' maxlength='1'>
                                                                <option value=''>" . language('report/report/report', 'tCMNBlank-NA') . "</option>
                                                                <option value='1'>" . language('report/report/report', 'tRPCCardDetailStaActive1') . "</option>
                                                                <option value='2'>" . language('report/report/report', 'tRPCCardDetailStaActive2') . "</option>
                                                                <option value='3'>" . language('report/report/report', 'tRPCCardDetailStaActive3') . "</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            ";
                                        }
                                        /*===== End แบบช่วง =============================================*/
                                        break;
                                    }
                                case '19': { // รหัสพนักงาน
                                        /*===== Begin แบบช่วง ===========================================*/
                                        if ($aRptFilValue['FTRptFltStaFrm'] == '1') {
                                            $tCoditionReportFrom .= "
                                                <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                                                    <div class='xCNInputNewUIBrowse'>
                                                        <div class='input-group' style='width: 100%;'>
                                                            <input type='text' class='form-control xCNHide xWRptAllInput' id='oetRptEmpCodeFrom' name='oetRptEmpCodeFrom' maxlength='5' value=''>
                                                            <input type='text' class='form-control xWPointerEventNone xWRptConsCrdInput xCNInputNewUI' id='oetRptEmpNameFrom' name='oetRptEmpNameFrom' value='' readonly=''>
                                                            <span class='input-group-btn'>
                                                                <button id='oimRPCBrowseEmp' type='button' class='btn xCNButtonNewUI'><img class='xCNIconFind'></button>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            ";
                                        }
                                        // ถึงรหัสพนักงาน
                                        if ($aRptFilValue['FTRptFltStaTo'] == '1') {
                                            $tCoditionReportTo .= "
                                                <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                                                    <div class='xCNInputNewUIBrowse'>
                                                        <div class='input-group' style='width: 100%;'>
                                                            <input type='text' class='form-control xCNHide xWRptAllInput' id='oetRptEmpCodeTo' name='oetRptEmpCodeTo' maxlength='5' value=''>
                                                            <input type='text' class='form-control xWPointerEventNone xWRptConsCrdInput xCNInputNewUI' id='oetRptEmpNameTo' name='oetRptEmpNameTo' value='' readonly=''>
                                                            <span class='input-group-btn'>
                                                                <button id='oimRPCBrowseEmpTo' type='button' class='btn xCNButtonNewUI'><img class='xCNIconFind'></button>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            ";
                                        }
                                        /*===== End แบบช่วง =============================================*/
                                        break;
                                    }
                                case '20': { // วันที่เริ่มใช้งานบัตร
                                        /*===== Begin แบบช่วง ===========================================*/
                                        if ($aRptFilValue['FTRptFltStaFrm'] == '1') {
                                            $tCoditionReportFrom .= "
                                                <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                                                    <div class='xCNInputNewUIBrowse'>
                                                        <div class='input-group'>
                                                            <input type='text' class='form-control xCNDatePicker xCNInputMaskDate xWRptAllInput xCNInputNewUI' id='oetRptDateStartFrom' name='oetRptDateStartFrom'>
                                                            <span class='input-group-btn'>
                                                                <button id='obtRptBrowseDateStartFrom' type='button' class='btn xCNButtonNewUI'><img class='xCNIconCalendar'></button>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                        ";
                                        }
                                        if ($aRptFilValue['FTRptFltStaTo'] == '1') {
                                            $tCoditionReportTo .= "
                                                <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                                                    <div class='xCNInputNewUIBrowse'>
                                                        <div class='input-group'>
                                                            <input type='text' class='form-control xCNDatePicker xCNInputMaskDate xWRptAllInput xCNInputNewUI' id='oetRptDateStartTo' name='oetRptDateStartTo'>
                                                            <span class='input-group-btn'>
                                                                <button id='obtRptBrowseDateStartTo' type='button' class='btn xCNButtonNewUI'><img class='xCNIconCalendar'></button>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                        ";
                                        }
                                        /*===== End แบบช่วง =============================================*/
                                        break;
                                    }
                                case '21': { // วันที่บัตรหมดอายุ
                                        /*===== Begin แบบช่วง ===========================================*/
                                        if ($aRptFilValue['FTRptFltStaFrm'] == '1') {
                                            $tCoditionReportFrom .= "
                                                <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                                                    <div class='xCNInputNewUIBrowse'>
                                                        <div class='input-group'>
                                                            <input type='text' class='form-control xCNDatePicker xCNInputMaskDate xWRptAllInput xCNInputNewUI' id='oetRptDateExpireFrom' name='oetRptDateExpireFrom'>
                                                            <span class='input-group-btn'>
                                                                <button id='obtRptBrowseDateExpireFrom' type='button' class='btn xCNButtonNewUI'><img class='xCNIconCalendar'></button>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                        ";
                                        }
                                        if ($aRptFilValue['FTRptFltStaTo'] == '1') {
                                            $tCoditionReportTo .= "
                                                <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                                                    <div class='xCNInputNewUIBrowse'>
                                                        <div class='input-group'>
                                                            <input type='text' class='form-control xCNDatePicker xCNInputMaskDate xWRptAllInput xCNInputNewUI' id='oetRptDateExpireTo' name='oetRptDateExpireTo'>
                                                            <span class='input-group-btn'>
                                                                <button id='obtRptBrowseDateExpireTo' type='button' class='btn xCNButtonNewUI'><img class='xCNIconCalendar'></button>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                        ";
                                        }
                                        /*===== End แบบช่วง =============================================*/
                                        break;
                                    }
                                case '22': { // ประเภทบัตรเดิม
                                        /*===== Begin แบบช่วง ===========================================*/
                                        if ($aRptFilValue['FTRptFltStaFrm'] == '1') {
                                            $tCoditionReportFrom .= "
                                                <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                                                    <div class='xCNInputNewUIBrowse'>
                                                        <div class='input-group' style='width: 100%;'>
                                                            <input class='form-control xCNHide xWRptConsCrdInput' id='oetRptCardTypeCodeOldFrom' name='oetRptCardTypeCodeOldFrom' maxlength='5' value=''>
                                                            <input class='form-control xWPointerEventNone xWRptConsCrdInput xCNInputNewUI' type='text' id='oetRptCardTypeNameOldFrom' name='oetRptCardTypeNameOldFrom' value='' readonly=''>
                                                            <span class='input-group-btn'>
                                                            <button id='obtRPCBrowseCardTypeOldFrom' type='button' class='btn xCNButtonNewUI'><img class='xCNIconFind'></button>
                                                        </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            ";
                                        }
                                        // ถึงประเภทบัตรเดิม
                                        if ($aRptFilValue['FTRptFltStaTo'] == '1') {
                                            $tCoditionReportTo .= "
                                                <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                                                    <div class='xCNInputNewUIBrowse'>
                                                        <div class='input-group' style='width: 100%;'>
                                                            <input class='form-control xCNHide xWRptConsCrdInput' id='oetRptCardTypeCodeOldTo' name='oetRptCardTypeCodeOldTo' maxlength='5' value=''>
                                                            <input class='form-control xWPointerEventNone xWRptConsCrdInput xCNInputNewUI' type='text' id='oetRptCardTypeNameOldTo' name='oetRptCardTypeNameOldTo' value='' readonly=''>
                                                            <span class='input-group-btn'>
                                                                <button id='obtRPCBrowseCardTypeOldTo' type='button' class='btn xCNButtonNewUI'><img class='xCNIconFind'></button>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            ";
                                        }
                                        /*===== End แบบช่วง =============================================*/
                                        break;
                                    }
                                case '23': { // ประเภทบัตรใหม่
                                        /*===== Begin แบบช่วง ===========================================*/
                                        if ($aRptFilValue['FTRptFltStaFrm'] == '1') {
                                            $tCoditionReportFrom .= "
                                                <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                                                    <div class='xCNInputNewUIBrowse'>
                                                        <div class='input-group'  style='width: 100%;'>
                                                            <input class='form-control xCNHide xWRptConsCrdInput' id='oetRptCardTypeCodeNewFrom' name='oetRptCardTypeCodeNewFrom' maxlength='5' value=''>
                                                            <input class='form-control xWPointerEventNone xWRptConsCrdInput xCNInputNewUI' type='text' id='oetRptCardTypeNameNewFrom' name='oetRptCardTypeNameNewFrom' value='' readonly=''>
                                                            <span class='input-group-btn'>
                                                                <button id='obtRPCBrowseCardTypeNewFrom' type='button' class='btn xCNButtonNewUI'><img class='xCNIconFind'></button>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            ";
                                        }
                                        // ถึงประเภทบัตรใหม่
                                        if ($aRptFilValue['FTRptFltStaTo'] == '1') {
                                            $tCoditionReportTo .= "
                                                <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                                                    <div class='xCNInputNewUIBrowse'>
                                                        <div class='input-group' style='width: 100%;'>
                                                            <input class='form-control xCNHide xWRptConsCrdInput' id='oetRptCardTypeCodeNewTo' name='oetRptCardTypeCodeNewTo' maxlength='5' value=''>
                                                            <input class='form-control xWPointerEventNone xWRptConsCrdInput xCNInputNewUI' type='text' id='oetRptCardTypeNameNewTo' name='oetRptCardTypeNameNewTo' value='' readonly=''>
                                                            <span class='input-group-btn'>
                                                                <button id='obtRPCBrowseCardTypeNewTo' type='button' class='btn xCNButtonNewUI'><img class='xCNIconFind'></button>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            ";
                                        }
                                        /*===== End แบบช่วง =============================================*/
                                        break;
                                    }
                                case '24': { // หมายเลขบัตรเดิม
                                        /*===== Begin แบบช่วง ===========================================*/
                                        if ($aRptFilValue['FTRptFltStaFrm'] == '1') {
                                            $tCoditionReportFrom .= "
                                                <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                                                    <div class='xCNInputNewUIBrowse'>
                                                        <div class='input-group' style='width: 100%;'>
                                                            <input type='text' class='form-control xCNHide xWRptAllInput' id='oetRptCardCodeOldFrom' name='oetRptCardCodeOldFrom' maxlength='5'>
                                                            <input type='text' class='form-control xWPointerEventNone xWRptAllInput xCNInputNewUI' id='oetRptCardNameOldFrom' name='oetRptCardNameOldFrom' readonly>
                                                            <span class='input-group-btn'>
                                                                <button id='obtRPCBrowseCardOldFrom' type='button' class='btn xCNButtonNewUI'> <img class='xCNIconFind'></button>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            ";
                                        }
                                        // ถึงหมายเลขบัตรเดิม
                                        if ($aRptFilValue['FTRptFltStaTo'] == '1') {
                                            $tCoditionReportTo .= "
                                                <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                                                    <div class='xCNInputNewUIBrowse'>
                                                        <div class='input-group' style='width: 100%;'>
                                                            <input type='text' class='form-control xCNHide xWRptAllInput' id='oetRptCardCodeOldTo' name='oetRptCardCodeOldTo' maxlength='5'>
                                                            <input type='text' class='form-control xWPointerEventNone xWRptAllInput xCNInputNewUI' id='oetRptCardNameOldTo' name='oetRptCardNameOldTo' readonly>
                                                            <span class='input-group-btn'>
                                                                <button id='obtRPCBrowseCardOldTo' type='button' class='btn xCNButtonNewUI'><img class='xCNIconFind'></button>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            ";
                                        }
                                        /*===== End แบบช่วง =============================================*/
                                        break;
                                    }
                                case '25': { // หมายเลขบัตรใหม่
                                        /*===== Begin แบบช่วง ===========================================*/
                                        if ($aRptFilValue['FTRptFltStaFrm'] == '1') {
                                            $tCoditionReportFrom .= "
                                                <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                                                    <div class='xCNInputNewUIBrowse'>
                                                        <div class='input-group' style='width: 100%;'>
                                                            <input type='text' class='form-control xCNHide xWRptAllInput' id='oetRptCardCodeNewFrom' name='oetRptCardCodeNewFrom' maxlength='5'>
                                                            <input type='text' class='form-control xWPointerEventNone xWRptAllInput xCNInputNewUI' id='oetRptCardNameNewFrom' name='oetRptCardNameNewFrom' readonly>
                                                            <span class='input-group-btn'>
                                                                <button id='obtRPCBrowseCardNewFrom' type='button' class='btn xCNButtonNewUI'> <img class='xCNIconFind'></button>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            ";
                                        }
                                        // ถึงหมายเลขบัตรใหม่
                                        if ($aRptFilValue['FTRptFltStaTo'] == '1') {
                                            $tCoditionReportTo .= "
                                                <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                                                    <div class='xCNInputNewUIBrowse'>
                                                        <div class='input-group' style='width: 100%;'>
                                                            <input type='text' class='form-control xCNHide xWRptAllInput' id='oetRptCardCodeNewTo' name='oetRptCardCodeNewTo' maxlength='5'>
                                                            <input type='text' class='form-control xWPointerEventNone xWRptAllInput xCNInputNewUI' id='oetRptCardNameNewTo' name='oetRptCardNameNewTo' readonly>
                                                            <span class='input-group-btn'>
                                                                <button id='obtRPCBrowseCardNewTo' type='button' class='btn xCNButtonNewUI'><img class='xCNIconFind'></button>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            ";
                                        }
                                        /*===== End แบบช่วง =============================================*/
                                        break;
                                    }
                                case '26': { // ประเภทเครื่องจุดขาย
                                        if ($aRptFilValue['FTRptFltStaFrm'] == '1') {
                                            $tCoditionReportFrom    .= "
                                                <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                                                    <div class=''>
                                                        <div class='input-group xWInputGrpPosType xCNNewUISelect' style='width:100%'>
                                                            <select class='selectpicker xCNNewUISelectoption' id='ocmPosType' name='ocmPosType'>
                                                                <option value=''>" . language('report/report/report', 'tRptPosType') . "</option>
                                                                <option value='1'>" . language('report/report/report', 'tRptPosType1') . "</option>
                                                                <option value='2'>" . language('report/report/report', 'tRptPosType2') . "</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            ";
                                        }
                                        $tCoditionReportTo   .= '';
                                        break;
                                    }
                                case '27': { // ลูกค้า
                                        /*===== Begin แบบช่วง ===========================================*/
                                        if ($aRptFilValue['FTRptFltStaFrm'] == '1') {
                                            $tCoditionReportFrom .= "
                                                <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                                                    <div class='xCNInputNewUIBrowse'>
                                                        <div class='input-group' style='width: 100%;'>
                                                            <input type='text' class='form-control xCNHide xWRptAllInput' id='oetRptCstCodeFrom' name='oetRptCstCodeFrom' maxlength='5'>
                                                            <input type='text' class='form-control xWRptAllInput xCNInputNewUI' id='oetRptCstNameFrom' name='oetRptCstNameFrom' readonly>
                                                            <span class='input-group-btn'>
                                                                <button id='obtRPCBrowseCstFrom' type='button' class='btn xCNButtonNewUI'> <img class='xCNIconFind'></button>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            ";
                                        }
                                        // ถึงลูกค้า
                                        if ($aRptFilValue['FTRptFltStaTo'] == '1') {
                                            $tCoditionReportTo .= "
                                                <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                                                    <div class='xCNInputNewUIBrowse'>
                                                        <div class='input-group' style='width: 100%;'>
                                                            <input type='text' class='form-control xCNHide xWRptAllInput' id='oetRptCstCodeTo' name='oetRptCstCodeTo' maxlength='5'>
                                                            <input type='text' class='form-control xWRptAllInput xCNInputNewUI' id='oetRptCstNameTo' name='oetRptCstNameTo' readonly>
                                                            <span class='input-group-btn'>
                                                                <button id='obtRPCBrowseCstTo' type='button' class='btn xCNButtonNewUI'><img class='xCNIconFind'></button>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            ";
                                        }
                                        /*===== End แบบช่วง =============================================*/
                                        break;
                                    }
                                case '28': { // เดือน
                                        if ($aRptFilValue['FTRptFltStaFrm'] == '1' || $aRptFilValue['FTRptFltStaTo'] == '1') {
                                            $tCoditionReportFrom    .= "
                                                <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                                                    <div class=''>
                                                        <div class='input-group xWInputGrpMonthFilter xCNNewUISelect' style='width:100%'>
                                                            <select class='selectpicker xCNNewUISelectoption' id='ocmRptMonth' name='ocmRptMonth'>
                                                                <option value='01'>" . language('report/report/report', 'tRptMonth1') . "</option>
                                                                <option value='02'>" . language('report/report/report', 'tRptMonth2') . "</option>
                                                                <option value='03'>" . language('report/report/report', 'tRptMonth3') . "</option>
                                                                <option value='04'>" . language('report/report/report', 'tRptMonth4') . "</option>
                                                                <option value='05'>" . language('report/report/report', 'tRptMonth5') . "</option>
                                                                <option value='06'>" . language('report/report/report', 'tRptMonth6') . "</option>
                                                                <option value='07'>" . language('report/report/report', 'tRptMonth7') . "</option>
                                                                <option value='08'>" . language('report/report/report', 'tRptMonth8') . "</option>
                                                                <option value='09'>" . language('report/report/report', 'tRptMonth9') . "</option>
                                                                <option value='10'>" . language('report/report/report', 'tRptMonth10') . "</option>
                                                                <option value='11'>" . language('report/report/report', 'tRptMonth11') . "</option>
                                                                <option value='12'>" . language('report/report/report', 'tRptMonth12') . "</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            ";
                                        }
                                        break;
                                    }
                                case '29': { // ร้านค้าที่โอน
                                        /*===== Begin แบบช่วง ===========================================*/
                                        if ($aRptFilValue['FTRptFltStaFrm'] == '1') {
                                            $tCoditionReportFrom .= "
                                                <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                                                    <div class='xCNInputNewUIBrowse'>
                                                        <div class='input-group' style='width: 100%;'>
                                                            <input type='text' class='form-control xCNHide xWRptAllInput' id='oetRptShpTCodeFrom' name='oetRptShpTCodeFrom' maxlength='5'>
                                                            <input type='text' class='form-control xWPointerEventNone xWRptAllInput xCNInputNewUI' id='oetRptShpTNameFrom' name='oetRptShpTNameFrom' readonly>
                                                            <span class='input-group-btn'>
                                                                <button id='obtRptBrowseShpTFrom' type='button' class='btn xCNButtonNewUI'><img class='xCNIconFind'></button>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            ";
                                        }
                                        if ($aRptFilValue['FTRptFltStaTo'] == '1') {
                                            $tCoditionReportTo .= "
                                                <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                                                    <div class='xCNInputNewUIBrowse'>
                                                        <div class='input-group' style='width: 100%;'>
                                                            <input type='text' class='form-control xCNHide xWRptAllInput' id='oetRptShpTCodeTo' name='oetRptShpTCodeTo' maxlength='5'>
                                                            <input type='text' class='form-control xWPointerEventNone xWRptAllInput xCNInputNewUI' id='oetRptShpTNameTo' name='oetRptShpTNameTo' readonly>
                                                            <span class='input-group-btn'>
                                                                <button id='obtRptBrowseShpTTo' type='button' class='btn xCNButtonNewUI'><img class='xCNIconFind'></button>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            ";
                                        }
                                        /*===== End แบบช่วง =============================================*/
                                        break;
                                    }
                                case '30': { // ร้านค้าที่รับโอน
                                        /*===== Begin แบบช่วง ===========================================*/
                                        if ($aRptFilValue['FTRptFltStaFrm'] == '1') {
                                            $tCoditionReportFrom .= "
                                                <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                                                    <div class='xCNInputNewUIBrowse'>
                                                        <div class='input-group' style='width: 100%;'>
                                                            <input type='text' class='form-control xCNHide xWRptAllInput' id='oetRptShpRCodeFrom' name='oetRptShpRCodeFrom' maxlength='5'>
                                                            <input type='text' class='form-control xWPointerEventNone xWRptAllInput xCNInputNewUI' id='oetRptShpRNameFrom' name='oetRptShpRNameFrom' readonly>
                                                            <span class='input-group-btn'>
                                                                <button id='obtRptBrowseShpRFrom' type='button' class='btn xCNButtonNewUI'><img class='xCNIconFind'></button>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            ";
                                        }
                                        if ($aRptFilValue['FTRptFltStaTo'] == '1') {
                                            $tCoditionReportTo .= "
                                                <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                                                    <div class='xCNInputNewUIBrowse'>
                                                        <div class='input-group' style='width: 100%;'>
                                                            <input type='text' class='form-control xCNHide xWRptAllInput' id='oetRptShpRCodeTo' name='oetRptShpRCodeTo' maxlength='5'>
                                                            <input type='text' class='form-control xWPointerEventNone xWRptAllInput xCNInputNewUI' id='oetRptShpRNameTo' name='oetRptShpRNameTo' readonly>
                                                            <span class='input-group-btn'>
                                                                <button id='obtRptBrowseShpRTo' type='button' class='btn xCNButtonNewUI'><img class='xCNIconFind'></button>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            ";
                                        }
                                        /*===== End แบบช่วง =============================================*/
                                        break;
                                    }
                                case '31': { // ตู้ที่โอน
                                        /*===== Begin แบบช่วง ===========================================*/
                                        if ($aRptFilValue['FTRptFltStaFrm'] == '1') {
                                            $tCoditionReportFrom .= "
                                                <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                                                    <div class='xCNInputNewUIBrowse'>
                                                        <div class='input-group' style='width: 100%;'>
                                                            <input type='text' class='form-control xCNHide xWRptAllInput' id='oetRptPosTCodeFrom' name='oetRptPosTCodeFrom' maxlength='5'>
                                                            <input type='text' class='form-control xWPointerEventNone xWRptAllInput xCNInputNewUI' id='oetRptPosTNameFrom' name='oetRptPosTNameFrom' readonly>
                                                            <span class='input-group-btn'>
                                                                <button id='obtRptBrowsePosTFrom' type='button' class='btn xCNButtonNewUI'><img class='xCNIconFind'></button>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            ";
                                        }
                                        if ($aRptFilValue['FTRptFltStaTo'] == '1') {
                                            $tCoditionReportTo .= "
                                                <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                                                    <div class='xCNInputNewUIBrowse'>
                                                        <div class='input-group' style='width: 100%;'>
                                                            <input type='text' class='form-control xCNHide xWRptAllInput' id='oetRptPosTCodeTo' name='oetRptPosTCodeTo' maxlength='5'>
                                                            <input type='text' class='form-control xWPointerEventNone xWRptAllInput xCNInputNewUI' id='oetRptPosTNameTo' name='oetRptPosTNameTo' readonly>
                                                            <span class='input-group-btn'>
                                                                <button id='obtRptBrowsePosTTo' type='button' class='btn xCNButtonNewUI'><img class='xCNIconFind'></button>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            ";
                                        }
                                        /*===== End แบบช่วง =============================================*/
                                        break;
                                    }
                                case '32': { // ตู้ที่รับโอน
                                        /*===== Begin แบบช่วง ===========================================*/
                                        if ($aRptFilValue['FTRptFltStaFrm'] == '1') {
                                            $tCoditionReportFrom .= "
                                                <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                                                    <div class='xCNInputNewUIBrowse'>
                                                        <div class='input-group' style='width: 100%;'>
                                                            <input type='text' class='form-control xCNHide xWRptAllInput' id='oetRptPosRCodeFrom' name='oetRptPosRCodeFrom' maxlength='5'>
                                                            <input type='text' class='form-control xWPointerEventNone xWRptAllInput xCNInputNewUI' id='oetRptPosRNameFrom' name='oetRptPosRNameFrom' readonly>
                                                            <span class='input-group-btn'>
                                                                <button id='obtRptBrowsePosRFrom' type='button' class='btn xCNButtonNewUI'><img class='xCNIconFind'></button>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            ";
                                        }
                                        if ($aRptFilValue['FTRptFltStaTo'] == '1') {
                                            $tCoditionReportTo .= "
                                                <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                                                    <div class='xCNInputNewUIBrowse'>
                                                        <div class='input-group' style='width: 100%;'>
                                                            <input type='text' class='form-control xCNHide xWRptAllInput' id='oetRptPosRCodeTo' name='oetRptPosRCodeTo' maxlength='5'>
                                                            <input type='text' class='form-control xWPointerEventNone xWRptAllInput xCNInputNewUI' id='oetRptPosRNameTo' name='oetRptPosRNameTo' readonly>
                                                            <span class='input-group-btn'>
                                                                <button id='obtRptBrowsePosRTo' type='button' class='btn xCNButtonNewUI'><img class='xCNIconFind'></button>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            ";
                                        }
                                        /*===== End แบบช่วง =============================================*/
                                        break;
                                    }
                                case '33': { // คลังสินค้าที่โอน
                                        /*===== Begin แบบช่วง ===========================================*/
                                        if ($aRptFilValue['FTRptFltStaFrm'] == '1') {
                                            $tCoditionReportFrom .= "
                                                <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                                                    <div class='xCNInputNewUIBrowse'>
                                                        <div class='input-group' style='width: 100%;'>
                                                            <input type='text' class='form-control xCNHide xWRptAllInput' id='oetRptWahTCodeFrom' name='oetRptWahTCodeFrom' maxlength='5'>
                                                            <input type='text' class='form-control xWPointerEventNone xWRptAllInput xCNInputNewUI' id='oetRptWahTNameFrom' name='oetRptWahTNameFrom' readonly>
                                                            <span class='input-group-btn'>
                                                                <button id='obtRptBrowseWahTFrom' type='button' class='btn xCNButtonNewUI'> <img class='xCNIconFind'></button>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            ";
                                        }
                                        if ($aRptFilValue['FTRptFltStaTo'] == '1') {
                                            $tCoditionReportTo .= "
                                                <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                                                    <div class='xCNInputNewUIBrowse'>
                                                        <div class='input-group' style='width: 100%;'>
                                                            <input type='text' class='form-control xCNHide xWRptAllInput' id='oetRptWahTCodeTo' name='oetRptWahTCodeTo' maxlength='5'>
                                                            <input type='text' class='form-control xWPointerEventNone xWRptAllInput xCNInputNewUI' id='oetRptWahTNameTo' name='oetRptWahTNameTo' readonly>
                                                            <span class='input-group-btn'>
                                                                <button id='obtRptBrowseWahTTo' type='button' class='btn xCNButtonNewUI'><img class='xCNIconFind'></button>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            ";
                                        }
                                        /*===== End แบบช่วง =============================================*/
                                        break;
                                    }
                                case '34': { // คลังสินค้าที่รับโอน
                                    /*===== Begin แบบช่วง ===========================================*/
                                    if ($aRptFilValue['FTRptFltStaFrm'] == '1') {
                                        $tCoditionReportFrom .= "
                                            <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                                                <div class='xCNInputNewUIBrowse'>
                                                    <div class='input-group' style='width: 100%;'>
                                                        <input type='text' class='form-control xCNHide xWRptAllInput' id='oetRptWahRCodeFrom' name='oetRptWahRCodeFrom' maxlength='5'>
                                                        <input type='text' class='form-control xWPointerEventNone xWRptAllInput xCNInputNewUI' id='oetRptWahRNameFrom' name='oetRptWahRNameFrom' readonly>
                                                        <span class='input-group-btn'>
                                                            <button id='obtRptBrowseWahRFrom' type='button' class='btn xCNButtonNewUI'> <img class='xCNIconFind'></button>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        ";
                                    }
                                    if ($aRptFilValue['FTRptFltStaTo'] == '1') {
                                        $tCoditionReportTo .= "
                                            <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                                                <div class='xCNInputNewUIBrowse'>
                                                    <div class='input-group' style='width: 100%;'>
                                                        <input type='text' class='form-control xCNHide xWRptAllInput' id='oetRptWahRCodeTo' name='oetRptWahRCodeTo' maxlength='5'>
                                                        <input type='text' class='form-control xWPointerEventNone xWRptAllInput xCNInputNewUI' id='oetRptWahRNameTo' name='oetRptWahRNameTo' readonly>
                                                        <span class='input-group-btn'>
                                                            <button id='obtRptBrowseWahRTo' type='button' class='btn xCNButtonNewUI'><img class='xCNIconFind'></button>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        ";
                                    }
                                    /*===== End แบบช่วง =============================================*/
                                    break;
                                }
                                case '35': {  // สถานะการจอง
                                    if ($aRptFilValue['FTRptFltStaFrm'] == '1' && $aRptFilValue['FTRptFltStaTo'] == '1') {
                                        $tCoditionReportFrom    .= "
                                            <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                                                <div class=''>
                                                    <div class='input-group xCNNewUISelect' style='width:100%'>
                                                        <select class='selectpicker xCNNewUISelectoption' id='ocmRptStaBooking' name='ocmRptStaBooking'>
                                                            <option value=''>" . language('report/report/report', 'tRptStaBookingAll') . "</option>
                                                            <option value='1'>" . language('report/report/report', 'tRptStaBooking1') . "</option>
                                                            <option value='2'>" . language('report/report/report', 'tRptStaBooking2') . "</option>
                                                            <option value='3'>" . language('report/report/report', 'tRptStaBooking3') . "</option>
                                                            <option value='4'>" . language('report/report/report', 'tRptStaBooking4') . "</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        ";
                                    }
                                    break;
                                }
                                case '36': { // ระบบการจอง
                                    if ($aRptFilValue['FTRptFltStaFrm'] == '1' && $aRptFilValue['FTRptFltStaTo'] == '1') {
                                        $tCoditionReportFrom    .= "
                                            <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                                                <div class=''>
                                                    <div class='input-group xCNNewUISelect' style='width:100%'>
                                                        <select class='selectpicker xCNNewUISelectoption' id='ocmRptStaProducer' name='ocmRptStaProducer'>
                                                            <option value=''>" . language('report/report/report', 'tRptStaProducerAll') . "</option>
                                                            <option value='" . language('report/report/report', 'tRptStaProducer1') . "'>" . language('report/report/report', 'tRptStaProducer1') . "</option>
                                                            <option value='" . language('report/report/report', 'tRptStaProducer2') . "'>" . language('report/report/report', 'tRptStaProducer2') . "</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        ";
                                    }
                                    break;
                                }
                                case '37': { // ขนาดช่องฝาก(Locker)
                                    /*===== Begin แบบช่วง ===========================================*/
                                    if ($aRptFilValue['FTRptFltStaFrm'] == '1') {
                                        $tCoditionReportFrom .= "
                                            <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                                                <div class='xCNInputNewUIBrowse'>
                                                    <div class='input-group' style='width: 100%;'>
                                                        <input type='text' class='form-control xCNHide xWRptAllInput' id='oetRptPzeCodeFrom' name='oetRptPzeCodeFrom' maxlength='5'>
                                                        <input type='text' class='form-control xWPointerEventNone xWRptAllInput xCNInputNewUI' id='oetRptPzeNameFrom' name='oetRptPzeNameFrom' readonly>
                                                        <span class='input-group-btn'>
                                                            <button id='obtRptBrowseShpSizeFrom' type='button' class='btn xCNButtonNewUI'> <img class='xCNIconFind'></button>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        ";
                                    }
                                    if ($aRptFilValue['FTRptFltStaTo'] == '1') {
                                        $tCoditionReportTo .= "
                                            <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                                                <div class='xCNInputNewUIBrowse'>
                                                    <div class='input-group' style='width: 100%;'>
                                                        <input type='text' class='form-control xCNHide xWRptAllInput' id='oetRptPzeCodeTo' name='oetRptPzeCodeTo' maxlength='5'>
                                                        <input type='text' class='form-control xWPointerEventNone xWRptAllInput xCNInputNewUI' id='oetRptPzeNameTo' name='oetRptPzeNameTo' readonly>
                                                        <span class='input-group-btn'>
                                                            <button id='obtRptBrowseShpSizeTo' type='button' class='btn xCNButtonNewUI'> <img class='xCNIconFind'></button>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        ";
                                    }
                                    /*===== End แบบช่วง =============================================*/
                                    break;
                                }
                                case '39': { // ช่องฝาก(Locker)
                                    /*===== Begin แบบช่วง ===========================================*/
                                    if ($aRptFilValue['FTRptFltStaFrm'] == '1') {
                                        $tCoditionReportFrom .= "
                                            <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                                                <div class='xCNInputNewUIBrowse'>
                                                    <div class='input-group' style='width: 100%;'>
                                                        <input type='text' class='form-control xCNInputNumericWithDecimal xCNInputLength xCNInputNewUI' data-length='3' id='oetRptLockerChanelFrom' name='oetRptLockerChanelFrom'>
                                                    </div>
                                                </div>
                                            </div>
                                        ";
                                    }
                                    if ($aRptFilValue['FTRptFltStaTo'] == '1') {
                                        $tCoditionReportTo .= "
                                            <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                                                <div class='xCNInputNewUIBrowse'>
                                                    <div class='input-group' style='width: 100%;'>
                                                        <input type='text' class='form-control xCNInputNumericWithDecimal xCNInputLength xCNInputNewUI' data-length='3' id='oetRptLockerChanelTo' name='oetRptLockerChanelTo'>
                                                    </div>
                                                </div>
                                            </div>
                                        ";
                                    }
                                    /*===== End แบบช่วง =============================================*/
                                    break;
                                }
                                case '41': { // ประเภทการชำระเงิน
                                    if ($aRptFilValue['FTRptFltStaFrm'] == '1') {
                                        $tCoditionReportFrom    .= "
                                            <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                                                <div class=''>
                                                    <div class='input-group xWInputGrpPosType xCNNewUISelect' style='width:100%'>
                                                        <select class='selectpicker xCNNewUISelectoption' id='ocmPosTypeFrom' name='ocmPosTypeFrom'>
                                                            <option value=''>" . language('report/report/report', 'tRptAll') . "</option>
                                                            <option value='1'>Vending QR</option>
                                                            <option value='2'>POS Cash</option>
                                                            <option value='3'>POS QR</option>
                                                            <option value='4'>POS EDC</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        ";
                                    }

                                    if ($aRptFilValue['FTRptFltStaTo'] == '1') {
                                        $tCoditionReportTo    .= "
                                            <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                                                <div class=''>
                                                    <div class='input-group xWInputGrpPosType xCNNewUISelect' style='width:100%'>
                                                        <select class='selectpicker xCNNewUISelectoption' id='ocmPosTypeTo' name='ocmPosTypeTo'>
                                                            <option value=''>" . language('report/report/report', 'tRptAll') . "</option>
                                                            <option value='1'>Vending QR</option>
                                                            <option value='2'>POS Cash</option>
                                                            <option value='3'>POS QR</option>
                                                            <option value='4'>POS EDC</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        ";
                                    }

                                    break;
                                }
                                case '45': { // แคชเชียร์ - Added By Napat(Jame) 09/03/2563
                                    if ($aRptFilValue['FTRptFltStaFrm'] == '1') {
                                        $tCoditionReportFrom    .= "
                                            <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                                                <div class='xCNInputNewUIBrowse'>
                                                    <div class='input-group' style='width: 100%;'>
                                                        <input type='text' class='form-control xCNHide xWRptAllInput' id='oetRptCashierCodeFrom' name='oetRptCashierCodeFrom' maxlength='5' value=''>
                                                        <input type='text' class='form-control xWPointerEventNone xWRptConsCrdInput xCNInputNewUI' id='oetRptCashierNameFrom' name='oetRptCashierNameFrom' value='' readonly=''>
                                                        <span class='input-group-btn'>
                                                            <button id='obtBrowseCashierFrom' type='button' class='btn xCNButtonNewUI'><img class='xCNIconFind'></button>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        ";
                                    }

                                    if ($aRptFilValue['FTRptFltStaTo'] == '1') {
                                        $tCoditionReportTo    .= "
                                            <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                                                <div class='xCNInputNewUIBrowse'>
                                                    <div class='input-group' style='width: 100%;'>
                                                        <input type='text' class='form-control xCNHide xWRptAllInput' id='oetRptCashierCodeTo' name='oetRptCashierCodeTo' maxlength='5' value=''>
                                                        <input type='text' class='form-control xWPointerEventNone xWRptConsCrdInput xCNInputNewUI' id='oetRptCashierNameTo' name='oetRptCashierNameTo' value='' readonly=''>
                                                        <span class='input-group-btn'>
                                                            <button id='obtBrowseCashierTo' type='button' class='btn xCNButtonNewUI'><img class='xCNIconFind'></button>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        ";
                                    }

                                    break;
                                }
                                case '42': { // ช่วงเดือน
                                    /*===== Begin แบบช่วง ===========================================*/
                                    if ($aRptFilValue['FTRptFltStaFrm'] == '1') {
                                        $tCoditionReportFrom    .= "
                                            <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                                                <div class=''>
                                                    <div class='input-group xWInputGrpMonthFilter xCNNewUISelect' style='width:100%'>
                                                        <select class='selectpicker xCNNewUISelectoption' id='ocmRptMonthFrom' name='ocmRptMonthFrom'>
                                                            <option value='01'>" . language('report/report/report', 'tRptMonth1') . "</option>
                                                            <option value='02'>" . language('report/report/report', 'tRptMonth2') . "</option>
                                                            <option value='03'>" . language('report/report/report', 'tRptMonth3') . "</option>
                                                            <option value='04'>" . language('report/report/report', 'tRptMonth4') . "</option>
                                                            <option value='05'>" . language('report/report/report', 'tRptMonth5') . "</option>
                                                            <option value='06'>" . language('report/report/report', 'tRptMonth6') . "</option>
                                                            <option value='07'>" . language('report/report/report', 'tRptMonth7') . "</option>
                                                            <option value='08'>" . language('report/report/report', 'tRptMonth8') . "</option>
                                                            <option value='09'>" . language('report/report/report', 'tRptMonth9') . "</option>
                                                            <option value='10'>" . language('report/report/report', 'tRptMonth10') . "</option>
                                                            <option value='11'>" . language('report/report/report', 'tRptMonth11') . "</option>
                                                            <option value='12'>" . language('report/report/report', 'tRptMonth12') . "</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        ";
                                    }

                                    if ($aRptFilValue['FTRptFltStaTo'] == '1') {
                                        $tCoditionReportTo   .= "
                                            <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                                                <div class=''>
                                                    <div class='input-group xWInputGrpMonthFilter xCNNewUISelect' style='width:100%'>
                                                        <select class='selectpicker xCNNewUISelectoption' id='ocmRptMonthTo' name='ocmRptMonthTo'>
                                                            <option value='01'>" . language('report/report/report', 'tRptMonth1') . "</option>
                                                            <option value='02'>" . language('report/report/report', 'tRptMonth2') . "</option>
                                                            <option value='03'>" . language('report/report/report', 'tRptMonth3') . "</option>
                                                            <option value='04'>" . language('report/report/report', 'tRptMonth4') . "</option>
                                                            <option value='05'>" . language('report/report/report', 'tRptMonth5') . "</option>
                                                            <option value='06'>" . language('report/report/report', 'tRptMonth6') . "</option>
                                                            <option value='07'>" . language('report/report/report', 'tRptMonth7') . "</option>
                                                            <option value='08'>" . language('report/report/report', 'tRptMonth8') . "</option>
                                                            <option value='09'>" . language('report/report/report', 'tRptMonth9') . "</option>
                                                            <option value='10'>" . language('report/report/report', 'tRptMonth10') . "</option>
                                                            <option value='11'>" . language('report/report/report', 'tRptMonth11') . "</option>
                                                            <option value='12'>" . language('report/report/report', 'tRptMonth12') . "</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        ";
                                    }
                                    /*===== End แบบช่วง =============================================*/
                                    break;
                                }

                                case '44': { // หมายเลข บช
                                    /*===== Begin แบบช่วง ===========================================*/
                                    if ($aRptFilValue['FTRptFltStaFrm'] == '1') {
                                        $tCoditionReportFrom .= "
                                            <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                                                <div class='xCNInputNewUIBrowse'>
                                                    <div class='input-group' style='width: 100%;'>
                                                        <input type='text' class='form-control xCNHide xWRptAllInput' id='oetRptBbkAccNoFrom' name='oetRptBbkAccNoFrom' maxlength='5' value=''>
                                                        <input type='text' class='form-control xWPointerEventNone xWRptConsCrdInput xCNInputNewUI' id='oetRptBbkAccNameFrom' name='oetRptBbkAccNameFrom' value='' readonly=''>
                                                        <span class='input-group-btn'>
                                                            <button id='obtDepositBrowseAccount' type='button' class='btn xCNButtonNewUI'><img class='xCNIconFind'></button>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        ";
                                    }
                                    // หมายเลข บช
                                    if ($aRptFilValue['FTRptFltStaTo'] == '1') {
                                        $tCoditionReportTo .= "
                                            <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                                                <div class='xCNInputNewUIBrowse'>
                                                    <div class='input-group' style='width: 100%;'>
                                                        <input type='text' class='form-control xCNHide xWRptAllInput' id='oetRptBbkAccNoTo' name='oetRptBbkAccNoTo' maxlength='5' value=''>
                                                        <input type='text' class='form-control xWPointerEventNone xWRptConsCrdInput xCNInputNewUI' id='oetRptBbkAccNameTo' name='oetRptBbkAccNameTo' value='' readonly=''>
                                                        <span class='input-group-btn'>
                                                            <button id='obtDepositBrowseAccountTo' type='button' class='btn xCNButtonNewUI'><img class='xCNIconFind'></button>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        ";
                                    }
                                    /*===== End แบบช่วง =============================================*/
                                    break;
                                }
                                case '46': { // หน่วยสินค้า
                                    /*===== Begin แบบช่วง ===========================================*/
                                    if ($aRptFilValue['FTRptFltStaFrm'] == '1') {
                                        $tCoditionReportFrom .= "
                                            <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                                                <div class='xCNInputNewUIBrowse'>
                                                    <div class='input-group' style='width: 100%;'>
                                                        <input type='text' class='form-control xCNHide xWRptAllInput' id='oetRptPdtUnitCodeFrom' name='oetRptPdtUnitCodeFrom' maxlength='5'>
                                                        <input type='text' class='form-control xWRptAllInput xCNInputNewUI' id='oetRptPdtUnitNameFrom' name='oetRptPdtUnitNameFrom' readonly>
                                                        <span class='input-group-btn'>
                                                            <button id='obtRPCBrowsePdtUnitFrom' type='button' class='btn xCNButtonNewUI'> <img class='xCNIconFind'></button>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        ";
                                    }
                                    if ($aRptFilValue['FTRptFltStaTo'] == '1') {
                                        $tCoditionReportTo .= "
                                            <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                                                <div class='xCNInputNewUIBrowse'>
                                                    <div class='input-group' style='width: 100%;'>
                                                        <input type='text' class='form-control xCNHide xWRptAllInput' id='oetRptPdtUnitCodeTo' name='oetRptPdtUnitCodeTo' maxlength='5'>
                                                        <input type='text' class='form-control xWRptAllInput xCNInputNewUI' id='oetRptPdtUnitNameTo' name='oetRptPdtUnitNameTo' readonly>
                                                        <span class='input-group-btn'>
                                                            <button id='obtRPCBrowsePdtUnitTo' type='button' class='btn xCNButtonNewUI'><img class='xCNIconFind'></button>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        ";
                                    }
                                    /*===== End แบบช่วง =============================================*/
                                    break;
                                }
                                case '47': { // วันที่มีผล
                                    /*===== Begin แบบช่วง ===========================================*/
                                    if ($aRptFilValue['FTRptFltStaFrm'] == '1') {
                                        $tCoditionReportFrom .= "
                                            <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                                                <div class='xCNInputNewUIBrowse'>
                                                    <div class='input-group'>
                                                        <input type='text' class='form-control xCNDatePicker xCNInputMaskDate xWRptAllInput xCNInputNewUI' id='oetRptEffectiveDateFrom' name='oetRptEffectiveDateFrom'>
                                                        <span class='input-group-btn'>
                                                            <button id='obtRptBrowseEffectiveDateFrom' type='button' class='btn xCNButtonNewUI'><img class='xCNIconCalendar'></button>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        ";
                                    }
                                    if ($aRptFilValue['FTRptFltStaTo'] == '1') {
                                        $tCoditionReportTo .= "
                                            <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                                                <div class='xCNInputNewUIBrowse'>
                                                    <div class='input-group'>
                                                        <input type='text' class='form-control xCNDatePicker xCNInputMaskDate xWRptAllInput xCNInputNewUI' id='oetRptEffectiveDateTo' name='oetRptEffectiveDateTo'>
                                                        <span class='input-group-btn'>
                                                            <button id='obtRptBrowseEffectiveDateTo' type='button' class='btn xCNButtonNewUI'><img class='xCNIconCalendar'></button>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        ";
                                    }
                                    /*===== End แบบช่วง =============================================*/
                                    break;
                                }
                                case '48': { // กลุ่มราคาที่มีผล
                                    /*===== Begin แบบช่วง ===========================================*/
                                    if ($aRptFilValue['FTRptFltStaFrm'] == '1') {
                                        $tCoditionReportFrom .= "
                                            <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                                                <div class='xCNInputNewUIBrowse'>
                                                    <div class='input-group' style='width: 100%;'>
                                                        <input type='text' class='form-control xCNHide xWRptAllInput' id='oetRptEffectivePriceGroupCodeFrom' name='oetRptEffectivePriceGroupCodeFrom' maxlength='5'>
                                                        <input type='text' class='form-control xWRptAllInput xCNInputNewUI' id='oetRptEffectivePriceGroupNameFrom' name='oetRptEffectivePriceGroupNameFrom' readonly>
                                                        <span class='input-group-btn'>
                                                            <button id='obtRPCBrowseEffectivePriceGroupFrom' type='button' class='btn xCNButtonNewUI'> <img class='xCNIconFind'></button>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        ";
                                    }
                                    if ($aRptFilValue['FTRptFltStaTo'] == '1') {
                                        $tCoditionReportTo .= "
                                            <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                                                <div class='xCNInputNewUIBrowse'>
                                                    <div class='input-group' style='width: 100%;'>
                                                        <input type='text' class='form-control xCNHide xWRptAllInput' id='oetRptEffectivePriceGroupCodeTo' name='oetRptEffectivePriceGroupCodeTo' maxlength='5'>
                                                        <input type='text' class='form-control xWRptAllInput xCNInputNewUI' id='oetRptEffectivePriceGroupNameTo' name='oetRptEffectivePriceGroupNameTo' readonly>
                                                        <span class='input-group-btn'>
                                                            <button id='obtRPCBrowseEffectivePriceGroupTo' type='button' class='btn xCNButtonNewUI'><img class='xCNIconFind'></button>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        ";
                                    }
                                    /*===== End แบบช่วง =============================================*/
                                    break;
                                }
                                case '49': { // สถานะเคลื่อนไหว - Create by Napat(Jame) 23/11/2020
                                    if ($aRptFilValue['FTRptFltStaFrm'] == '1' || $aRptFilValue['FTRptFltStaTo'] == '1') {
                                        $tCoditionReportFrom    .= "
                                            <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                                                <div class=''>
                                                    <div class='input-group xWInputGrpMonthFilter xCNNewUISelect' style='width:100%'>
                                                        <select class='selectpicker xCNNewUISelectoption' id='ocmRptPdtStaActive' name='ocmRptPdtStaActive'>
                                                            <option value=''>" . language('report/report/report', 'tRptAll') . "</option>
                                                            <option value='1' selected>" . language('report/report/report', 'tRptPdtMoving1') . "</option>
                                                            <option value='2'>" . language('report/report/report', 'tRptPdtMoving2') . "</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        ";
                                    }
                                    break;
                                }

                                case '50': { // ผู้จำหน่าย - Modify by Bell
                                    /*===== Begin แบบช่วง ===========================================*/
                                    if ($aRptFilValue['FTRptFltStaFrm'] == '1') {
                                        $tCoditionReportFrom .= "
                                            <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                                                <div class='xCNInputNewUIBrowse'>
                                                    <div class='input-group' style='width: 100%;'>
                                                        <input type='text' class='form-control xCNHide xWRptAllInput' id='oetRptSupplierCodeFrom' name='oetRptSupplierCodeFrom' maxlength='5'>
                                                        <input type='text' class='form-control xWPointerEventNone xWRptAllInput xCNInputNewUI' id='oetRptSupplierNameFrom' name='oetRptSupplierNameFrom' readonly>
                                                        <span class='input-group-btn'>
                                                            <button id='obtRptBrowseSupplierFrom' type='button' class='btn xCNButtonNewUI'> <img class='xCNIconFind'></button>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        ";
                                    }
                                    if ($aRptFilValue['FTRptFltStaTo'] == '1') {
                                        $tCoditionReportTo .= "
                                            <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                                                <div class='xCNInputNewUIBrowse'>
                                                    <div class='input-group' style='width: 100%;'>
                                                        <input type='text' class='form-control xCNHide xWRptAllInput' id='oetRptSupplierCodeTo' name='oetRptSupplierCodeTo' maxlength='5'>
                                                        <input type='text' class='form-control xWPointerEventNone xWRptAllInput xCNInputNewUI' id='oetRptSupplierNameTo' name='oetRptSupplierNameTo' readonly>
                                                        <span class='input-group-btn'>
                                                            <button id='obtRptBrowseSupplierTo' type='button' class='btn xCNButtonNewUI'> <img class='xCNIconFind'></button>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        ";
                                    }
                                    /*===== End แบบช่วง =============================================*/
                                    break;
                                }

                                case '51': { // เดือน - Modify by Bell
                                    if ($aRptFilValue['FTRptFltStaFrm'] == '1' || $aRptFilValue['FTRptFltStaTo'] == '1') {
                                        $tCoditionReportFrom    .= "
                                            <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                                                <div class=''>
                                                    <div class='input-group xWInputGrpMonthFilter xCNNewUISelect' style='width:100%'>
                                                        <select class='selectpicker xCNNewUISelectoption' id='ocmGroupReport' name='ocmGroupReport'>
                                                            <option value='01'>" . language('report/report/report', 'tRptGrpBranch') . "</option>
                                                            <option value='02'>" . language('report/report/report', 'tRptGrpAgency') . "</option>
                                                            <option value='03'>" . language('report/report/report', 'tRptGrpShop') . "</option>
                                                            <option value='04'>" . language('report/report/report', 'tRptProduct') . "</option>
                                                            <option value='05'>" . language('report/report/report', 'tRptGrpPdtType') . "</option>
                                                            <option value='06'>" . language('report/report/report', 'tRptGrpPdtGroup') . "</option>
                                                            <option value='07'>" . language('report/report/report', 'tRptGrpPdtBrand') . "</option>
                                                            <option value='08'>" . language('report/report/report', 'tRptGrpPdtModel') . "</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        ";
                                    }
                                    break;
                                }
                                case '52' : {  // เลือก วันที่ แบบ From อย่างเดี่ยว
                                    if ($aRptFilValue['FTRptFltStaFrm'] == '1' || $aRptFilValue['FTRptFltStaTo'] == '1') {
                                            $tCoditionReportFrom    .= "
                                                <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                                                    <div class='form-group'>
                                                        <div class='input-group'>
                                                            <input type='text' class='form-control xCNDatePicker xCNDatePickerStart xCNInputMaskDate xWRptAllInput' id='oetRptOneDateFrom' name='oetRptOneDateFrom' value='$tDateNow'>
                                                            <span class='input-group-btn'>
                                                                <button id='obtRptBrowseOneDateFrom' type='button' class='btn xCNBtnDateTime'><img class='xCNIconCalendar'></button>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            ";
                                    }
                                    break;
                                }

                                case '53': { // ยี่ห้อ - Modify by Bell
                                    /*===== Begin แบบช่วง ===========================================*/
                                    if ($aRptFilValue['FTRptFltStaFrm'] == '1') {
                                        $tCoditionReportFrom .= "
                                            <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                                                <div class='xCNInputNewUIBrowse'>
                                                    <div class='input-group' style='width: 100%;'>
                                                        <input type='text' class='form-control xCNHide xWRptAllInput' id='oetRptBrandCodeFrom' name='oetRptBrandCodeFrom' maxlength='5'>
                                                        <input type='text' class='form-control xWPointerEventNone xWRptAllInput xCNInputNewUI' id='oetRptBrandNameFrom' name='oetRptBrandNameFrom' readonly>
                                                        <span class='input-group-btn'>
                                                            <button id='obtRptBrowseBrandFrom' type='button' class='btn xCNButtonNewUI'> <img class='xCNIconFind'></button>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        ";
                                    }
                                    if ($aRptFilValue['FTRptFltStaTo'] == '1') {
                                        $tCoditionReportTo .= "
                                            <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                                                <div class='xCNInputNewUIBrowse'>
                                                    <div class='input-group' style='width: 100%;'>
                                                        <input type='text' class='form-control xCNHide xWRptAllInput' id='oetRptBrandCodeTo' name='oetRptBrandCodeTo' maxlength='5'>
                                                        <input type='text' class='form-control xWPointerEventNone xWRptAllInput xCNInputNewUI' id='oetRptBrandNameTo' name='oetRptBrandNameTo' readonly>
                                                        <span class='input-group-btn'>
                                                            <button id='obtRptBrowseBrandTo' type='button' class='btn xCNButtonNewUI'> <img class='xCNIconFind'></button>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        ";
                                    }
                                    /*===== End แบบช่วง =============================================*/
                                    break;
                                }

                                case '54': { // รุ่น - Modify by Bell
                                    /*===== Begin แบบช่วง ===========================================*/
                                    if ($aRptFilValue['FTRptFltStaFrm'] == '1') {
                                        $tCoditionReportFrom .= "
                                            <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                                                <div class='xCNInputNewUIBrowse'>
                                                    <div class='input-group' style='width: 100%;'>
                                                        <input type='text' class='form-control xCNHide xWRptAllInput' id='oetRptModelCodeFrom' name='oetRptModelCodeFrom' maxlength='5'>
                                                        <input type='text' class='form-control xWPointerEventNone xWRptAllInput xCNInputNewUI' id='oetRptModelNameFrom' name='oetRptModelNameFrom' readonly>
                                                        <span class='input-group-btn'>
                                                            <button id='obtRptBrowseModelFrom' type='button' class='btn xCNButtonNewUI'> <img class='xCNIconFind'></button>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        ";
                                    }
                                    if ($aRptFilValue['FTRptFltStaTo'] == '1') {
                                        $tCoditionReportTo .= "
                                            <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                                                <div class='xCNInputNewUIBrowse'>
                                                    <div class='input-group' style='width: 100%;'>
                                                        <input type='text' class='form-control xCNHide xWRptAllInput' id='oetRptModelCodeTo' name='oetRptModelCodeTo' maxlength='5'>
                                                        <input type='text' class='form-control xWPointerEventNone xWRptAllInput xCNInputNewUI' id='oetRptModelNameTo' name='oetRptModelNameTo' readonly>
                                                        <span class='input-group-btn'>
                                                            <button id='obtRptBrowseModelTo' type='button' class='btn xCNButtonNewUI'> <img class='xCNIconFind'></button>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        ";
                                    }
                                    /*===== End แบบช่วง =============================================*/
                                    break;
                                }
                                case '55': { // เดือน
                                    if ($aRptFilValue['FTRptFltStaFrm'] == '1' || $aRptFilValue['FTRptFltStaTo'] == '1') {
                                        $tCoditionReportFrom    .= "
                                            <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                                                <div class=''>
                                                    <div class='input-group xWInputGrpMonthFilter xCNNewUISelect' style='width:100%'>
                                                        <select class='selectpicker xCNNewUISelectoption' id='ocmRptExpMonth' name='ocmRptExpMonth'>
                                                            <option value='1'>" . language('report/report/report', 'tRptExpMonth1') . "</option>
                                                            <option value='2'>" . language('report/report/report', 'tRptExpMonth2') . "</option>
                                                            <option value='3'>" . language('report/report/report', 'tRptExpMonth3') . "</option>
                                                            <option value='4'>" . language('report/report/report', 'tRptExpMonth4') . "</option>
                                                            <option value='5'>" . language('report/report/report', 'tRptExpMonth5') . "</option>
                                                            <option value='6'>" . language('report/report/report', 'tRptExpMonth6') . "</option>
                                                            <option value='7'>" . language('report/report/report', 'tRptExpMonth7') . "</option>
                                                            <option value='8'>" . language('report/report/report', 'tRptExpMonth8') . "</option>
                                                            <option value='9'>" . language('report/report/report', 'tRptExpMonth9') . "</option>
                                                            <option value='10'>" . language('report/report/report', 'tRptExpMonth10') . "</option>
                                                            <option value='11'>" . language('report/report/report', 'tRptExpMonth11') . "</option>
                                                            <option value='12'>" . language('report/report/report', 'tRptExpMonth12') . "</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        ";
                                    }
                                    break;
                                }
                                //1:บังคับ, 2:แก้ไข, 3:เครื่องชั่ง, 4:น้ำหนัก 6:สินค้ารายการซ่อม
                                case '56': { // ใช้ราคาขาย
                                    if ($aRptFilValue['FTRptFltStaFrm'] == '1' || $aRptFilValue['FTRptFltStaTo'] == '1') {
                                        $tCoditionReportFrom    .= "
                                            <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                                                <div class=''>
                                                    <div class='input-group xWInputGrpMonthFilter xCNNewUISelect' style='width:100%'>
                                                        <select class='selectpicker xCNNewUISelectoption' id='ocmRptPdtType' name='ocmRptPdtType'>
                                                            <option value='0'>" . language('report/report/report', 'tRptPdtType0') . "</option>
                                                            <option value='1'>" . language('report/report/report', 'tRptPdtType1') . "</option>
                                                            <option value='2'>" . language('report/report/report', 'tRptPdtType2') . "</option>
                                                            <option value='3'>" . language('report/report/report', 'tRptPdtType3') . "</option>
                                                            <option value='4'>" . language('report/report/report', 'tRptPdtType4') . "</option>
                                                            <option value='6'>" . language('report/report/report', 'tRptPdtType6') . "</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        ";
                                    }
                                    break;
                                }
                                case '57': { // สถานะภาษีขาย 1:มีภาษี 2:ไม่มีภาษี
                                    if ($aRptFilValue['FTRptFltStaFrm'] == '1' || $aRptFilValue['FTRptFltStaTo'] == '1') {
                                        $tCoditionReportFrom    .= "
                                            <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                                                <div class=''>
                                                    <div class='input-group xWInputGrpMonthFilter xCNNewUISelect' style='width:100%'>
                                                        <select class='selectpicker xCNNewUISelectoption' id='ocmRptStaVat' name='ocmRptStaVat'>
                                                            <option value='0'>" . language('report/report/report', 'tRptStaVa0') . "</option>
                                                            <option value='1' selected>" . language('report/report/report', 'tRptStaVa1') . "</option>
                                                            <option value='2'>" . language('report/report/report', 'tRptStaVa2') . "</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        ";
                                    }
                                    break;
                                }
                                case '58': { // รหัสควบคุมสต็อกสินค้า
                                    /*===== Begin แบบช่วง ===========================================*/
                                    if ($aRptFilValue['FTRptFltStaFrm'] == '1') {
                                        $tCoditionReportFrom .= "
                                            <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                                                <div class='xCNInputNewUIBrowse'>
                                                    <div class='input-group' style='width: 100%;'>
                                                        <input type='text' class='form-control xCNHide xWRptAllInput' id='oetRptPdtRefCodeFrom' name='oetRptPdtRefCodeFrom' maxlength='5'>
                                                        <input type='text' class='form-control xWPointerEventNone xWRptAllInput xCNInputNewUI' id='oetRptPdtRefNameFrom' name='oetRptPdtRefNameFrom' readonly>
                                                        <span class='input-group-btn'>
                                                            <button id='obtRptBrowseRefCodeFrom' type='button' class='btn xCNButtonNewUI'> <img class='xCNIconFind'></button>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        ";
                                    }
                                    if ($aRptFilValue['FTRptFltStaTo'] == '1') {
                                        $tCoditionReportTo .= "
                                            <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                                                <div class='xCNInputNewUIBrowse'>
                                                    <div class='input-group' style='width: 100%;'>
                                                        <input type='text' class='form-control xCNHide xWRptAllInput' id='oetRptPdtRefCodeTo' name='oetRptPdtRefCodeTo' maxlength='5'>
                                                        <input type='text' class='form-control xWPointerEventNone xWRptAllInput xCNInputNewUI' id='oetRptPdtRefNameTo' name='oetRptPdtRefNameTo' readonly>
                                                        <span class='input-group-btn'>
                                                            <button id='obtRptBrowseRefCodeTo' type='button' class='btn xCNButtonNewUI'><img class='xCNIconFind'></button>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        ";
                                    }
                                    /*===== End แบบช่วง =============================================*/
                                    break;
                                }
                                case '59': { // ฤดูกาล
                                    /*===== Begin แบบช่วง ===========================================*/
                                    if ($aRptFilValue['FTRptFltStaFrm'] == '1') {
                                        $tCoditionReportFrom .= "
                                            <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                                                <div class='xCNInputNewUIBrowse'>
                                                    <div class='input-group' style='width: 100%;'>
                                                        <input type='text' class='form-control xCNHide xWRptAllInput' id='oetRptPdtSeaCodeFrom' name='oetRptPdtSeaCodeFrom' maxlength='5'>
                                                        <input type='text' class='form-control xWPointerEventNone xWRptAllInput xCNInputNewUI' id='oetRptPdtSeaNameFrom' name='oetRptPdtSeaNameFrom' readonly>
                                                        <span class='input-group-btn'>
                                                            <button id='obtRpFhnPdtSeasonBrowsFrom' type='button' class='btn xCNButtonNewUI'> <img class='xCNIconFind'></button>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        ";
                                    }
                                    if ($aRptFilValue['FTRptFltStaTo'] == '1') {
                                        $tCoditionReportTo .= "
                                            <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                                                <div class='xCNInputNewUIBrowse'>
                                                    <div class='input-group' style='width: 100%;'>
                                                        <input type='text' class='form-control xCNHide xWRptAllInput' id='oetRptPdtSeaCodeTo' name='oetRptPdtSeaCodeTo' maxlength='5'>
                                                        <input type='text' class='form-control xWPointerEventNone xWRptAllInput xCNInputNewUI' id='oetRptPdtSeaNameTo' name='oetRptPdtSeaNameTo' readonly>
                                                        <span class='input-group-btn'>
                                                            <button id='obtRpFhnPdtSeasonBrowsTo' type='button' class='btn xCNButtonNewUI'> <img class='xCNIconFind'></button>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        ";
                                    }
                                    /*===== End แบบช่วง =============================================*/
                                    break;
                                }
                                case '60': { // เนื้อผ้า
                                    /*===== Begin แบบช่วง ===========================================*/
                                    if ($aRptFilValue['FTRptFltStaFrm'] == '1') {
                                        $tCoditionReportFrom .= "
                                            <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                                                <div class='xCNInputNewUIBrowse'>
                                                    <div class='input-group' style='width: 100%;'>
                                                        <input type='text' class='form-control xCNHide xWRptAllInput' id='oetRptPdtFabCodeFrom' name='oetRptPdtFabCodeFrom' maxlength='5'>
                                                        <input type='text' class='form-control xWPointerEventNone xWRptAllInput xCNInputNewUI' id='oetRptPdtFabNameFrom' name='oetRptPdtFabNameFrom' readonly>
                                                        <span class='input-group-btn'>
                                                            <button id='obtRpFhnPdtFabricBrowsFrom' type='button' class='btn xCNButtonNewUI'> <img class='xCNIconFind'></button>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        ";
                                    }
                                    if ($aRptFilValue['FTRptFltStaTo'] == '1') {
                                        $tCoditionReportTo .= "
                                            <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                                                <div class='xCNInputNewUIBrowse'>
                                                    <div class='input-group' style='width: 100%;'>
                                                        <input type='text' class='form-control xCNHide xWRptAllInput' id='oetRptPdtFabCodeTo' name='oetRptPdtFabCodeTo' maxlength='5'>
                                                        <input type='text' class='form-control xWPointerEventNone xWRptAllInput xCNInputNewUI' id='oetRptPdtFabNameTo' name='oetRptPdtFabNameTo' readonly>
                                                        <span class='input-group-btn'>
                                                            <button id='obtRpFhnPdtFabricBrowsTo' type='button' class='btn xCNButtonNewUI'> <img class='xCNIconFind'></button>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        ";
                                    }
                                    /*===== End แบบช่วง =============================================*/
                                    break;
                                }
                                case '61': { // สี
                                    /*===== Begin แบบช่วง ===========================================*/
                                    if ($aRptFilValue['FTRptFltStaFrm'] == '1') {
                                        $tCoditionReportFrom .= "
                                            <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                                                <div class='xCNInputNewUIBrowse'>
                                                    <div class='input-group' style='width: 100%;'>
                                                        <input type='text' class='form-control xCNHide xWRptAllInput' id='oetRptPdtClrCodeFrom' name='oetRptPdtClrCodeFrom' maxlength='5'>
                                                        <input type='text' class='form-control xWPointerEventNone xWRptAllInput xCNInputNewUI' id='oetRptPdtClrNameFrom' name='oetRptPdtClrNameFrom' readonly>
                                                        <span class='input-group-btn'>
                                                            <button id='obtRpFhnPdtColorBrowsFrom' type='button' class='btn xCNButtonNewUI'> <img class='xCNIconFind'></button>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        ";
                                    }
                                    if ($aRptFilValue['FTRptFltStaTo'] == '1') {
                                        $tCoditionReportTo .= "
                                            <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                                                <div class='xCNInputNewUIBrowse'>
                                                    <div class='input-group' style='width: 100%;'>
                                                        <input type='text' class='form-control xCNHide xWRptAllInput' id='oetRptPdtClrCodeTo' name='oetRptPdtClrCodeTo' maxlength='5'>
                                                        <input type='text' class='form-control xWPointerEventNone xWRptAllInput xCNInputNewUI' id='oetRptPdtClrNameTo' name='oetRptPdtClrNameTo' readonly>
                                                        <span class='input-group-btn'>
                                                            <button id='obtRpFhnPdtColorBrowsTo' type='button' class='btn xCNButtonNewUI'> <img class='xCNIconFind'></button>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        ";
                                    }
                                    /*===== End แบบช่วง =============================================*/
                                    break;
                                }
                                case '62': { // ไซต์
                                    /*===== Begin แบบช่วง ===========================================*/
                                    if ($aRptFilValue['FTRptFltStaFrm'] == '1') {
                                        $tCoditionReportFrom .= "
                                            <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                                                <div class='xCNInputNewUIBrowse'>
                                                    <div class='input-group' style='width: 100%;'>
                                                        <input type='text' class='form-control xCNHide xWRptAllInput' id='oetRptPdtPszCodeFrom' name='oetRptPdtPszCodeFrom' maxlength='5'>
                                                        <input type='text' class='form-control xWPointerEventNone xWRptAllInput xCNInputNewUI' id='oetRptPdtPszNameFrom' name='oetRptPdtPszNameFrom' readonly>
                                                        <span class='input-group-btn'>
                                                            <button id='obtRpFhnPdtSizeBrowsFrom' type='button' class='btn xCNButtonNewUI'> <img class='xCNIconFind'></button>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        ";
                                    }
                                    if ($aRptFilValue['FTRptFltStaTo'] == '1') {
                                        $tCoditionReportTo .= "
                                            <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                                                <div class='xCNInputNewUIBrowse'>
                                                    <div class='input-group' style='width: 100%;'>
                                                        <input type='text' class='form-control xCNHide xWRptAllInput' id='oetRptPdtPszCodeTo' name='oetRptPdtPszCodeTo' maxlength='5'>
                                                        <input type='text' class='form-control xWPointerEventNone xWRptAllInput xCNInputNewUI' id='oetRptPdtPszNameTo' name='oetRptPdtPszNameTo' readonly>
                                                        <span class='input-group-btn'>
                                                            <button id='obtRpFhnPdtSizeBrowsTo' type='button' class='btn xCNButtonNewUI'> <img class='xCNIconFind'></button>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        ";
                                    }
                                    /*===== End แบบช่วง =============================================*/
                                    break;
                                }
                                case '63': { // ช่องทางการขาย(Sale channel)
                                        /*===== Begin แบบช่วง ===========================================*/
                                        if ($aRptFilValue['FTRptFltStaFrm'] == '1') {
                                            $tCoditionReportFrom .= "
                                                <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                                                    <div class='xCNInputNewUIBrowse'>
                                                        <div class='input-group' style='width: 100%;'>
                                                            <input type='text' class='form-control xCNHide xWRptAllInput' id='oetRptSalesChanelCodeFrom' name='oetRptSalesChanelCodeFrom' maxlength='5'>
                                                            <input type='text' class='form-control xWPointerEventNone xWRptAllInput xCNInputNewUI' id='oetRptSalesChanelNameFrom' name='oetRptSalesChanelNameFrom' readonly>
                                                            <span class='input-group-btn'>
                                                                <button id='obtSMLBrowseSalesChanelFrom' type='button' class='btn xCNButtonNewUI'> <img class='xCNIconFind'></button>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            ";
                                        }
                                        if ($aRptFilValue['FTRptFltStaTo'] == '1') {
                                            $tCoditionReportTo .= "
                                                <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                                                    <div class='xCNInputNewUIBrowse'>
                                                        <div class='input-group' style='width: 100%;'>
                                                            <input type='text' class='form-control xCNHide xWRptAllInput' id='oetRptSalesChanelCodeTo' name='oetRptSalesChanelCodeTo' maxlength='5'>
                                                            <input type='text' class='form-control xWPointerEventNone xWRptAllInput xCNInputNewUI' id='oetRptSalesChanelNameTo' name='oetRptSalesChanelNameTo' readonly>
                                                            <span class='input-group-btn'>
                                                                <button id='obtSMLBrowseSalesChanelTo' type='button' class='btn xCNButtonNewUI'><img class='xCNIconFind'></button>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            ";
                                        }
                                        /*===== End แบบช่วง =============================================*/
                                        break;
                                    }

                                case '202': { // ประเภท (คูปอง/บัตรกำนัล)
                                    if ($aRptFilValue['FTRptFltStaFrm'] == '1') {
                                        $tCoditionReportFrom    .= "
                                            <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                                                <div class=''>
                                                    <div class='input-group xCNNewUISelect' style='width:100%'>
                                                        <select class='selectpicker xCNNewUISelectoption' id='ocmRptCouponType' name='ocmRptCouponType'>
                                                            <option value=''>" . language('report/report/report', 'tRptAll') . "</option>
                                                            <option value='1'>" . language('report/report/report', 'tRptCoponType1') . "</option>
                                                            <option value='2'>" . language('report/report/report', 'tRptCoponType2') . "</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        ";
                                    }
                                    break;
                                }
                                case '203': { // สถานะ (คูปอง/บัตรกำนัล)
                                    if ($aRptFilValue['FTRptFltStaFrm'] == '1') {
                                        $tCoditionReportFrom    .= "
                                            <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                                                <div class=''>
                                                    <div class='input-group xCNNewUISelect' style='width:100%'>
                                                        <select class='selectpicker xCNNewUISelectoption' id='ocmRptCouponStatus' name='ocmRptCouponStatus'>
                                                            <option value=''>" . language('report/report/report', 'tRptAll') . "</option>
                                                            <option value='1'>" . language('report/report/report', 'tRptCoponStatus1') . "</option>
                                                            <option value='2'>" . language('report/report/report', 'tRptCoponStatus2') . "</option>
                                                            <option value='3'>" . language('report/report/report', 'tRptCoponStatus3') . "</option>
                                                            <option value='4'>" . language('report/report/report', 'tRptCoponStatus4') . "</option>
                                                            <option value='5'>" . language('report/report/report', 'tRptCoponStatus5') . "</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        ";
                                    }
                                    break;
                                }
                                case '204': { // ประเภทราคา
                                    if ($aRptFilValue['FTRptFltStaFrm'] == '1') {
                                        $tCoditionReportFrom    .= "
                                            <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                                                <div class=''>
                                                    <div class='input-group xCNNewUISelect' style='width:100%'>
                                                        <select class='selectpicker xCNNewUISelectoption' id='ocmRptPriceType' name='ocmRptPriceType'>
                                                            <option value=''>" . language('report/report/report', 'tRptAll') . "</option>
                                                            <option value='1'>" . language('report/report/report', 'tRptPriceType1') . "</option>
                                                            <option value='2'>" . language('report/report/report', 'tRptPriceType2') . "</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        ";
                                    }
                                    break;
                                }
                            }
                            ?>

                            <?php if (!in_array($aRptFilValue['FTRptFltCode'], ["1", "2", "3", "6", "4", "38", "200", "201"])) { ?>
                                <!--Loop เอาชื่อมาแสดง-->
                                <?php if ($tGroupFilter != $aRptFilValue['FTRptGrpFlt']) { ?>
                                    <?php
                                    switch ($aRptFilValue['FTRptGrpFlt']) {
                                        case 'G1':
                                            $tTextGroup = language('report/report/report', 'tRptFilterGroup1');
                                            break;
                                        case 'G2':
                                            $tTextGroup = language('report/report/report', 'tRptFilterGroup2');
                                            break;
                                        case 'G3':
                                            $tTextGroup = language('report/report/report', 'tRptFilterGroup3');
                                            break;
                                        case 'G4':
                                            $tTextGroup = language('report/report/report', 'tRptFilterGroup4');
                                            break;
                                        case 'G5':
                                            $tTextGroup = language('report/report/report', 'tRptFilterGroup5');
                                            break;
                                        case 'G6':
                                            $tTextGroup = language('report/report/report', 'tRptFilterGroup6');
                                            break;
                                        case 'G7':
                                            $tTextGroup = language('report/report/report', 'tRptFilterGroup7');
                                            break;
                                        case 'G8':
                                            $tTextGroup = language('report/report/report', 'tRptFilterGroup8');
                                            break;
                                        default: {
                                                $tTextGroup = '-';
                                            }
                                    }
                                    ?>
                                    <tr class="xCNNewGroup xCNNewGroupTR<?=$aRptFilValue['FTRptGrpFlt']; ?>">
                                        <td>
                                            <p class="xCNFontTDGroupFilter"><?= $tTextGroup; ?></p>
                                        </td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <?php $tGroupFilter = $aRptFilValue['FTRptGrpFlt']; ?>
                                <?php } ?>

                                <!--Loop ข้อมูล-->
                                <tr class='xCNDataCondition xCNFillterShw<?= $aRptFilValue['FTRptFltCode'] ?>'>
                                    <td>
                                        <p class='xCNLabelTBText'><?= $aRptFilValue['FTRptFltName']; ?></p>
                                    </td>
                                    <td>
                                        <?php if (!in_array($aRptFilValue['FTRptFltCode'], ["26", "18", "28", "5", "10", "35", "36", "39", "41", "42", "49","55"])) {  ?>
                                            <label class="fancy-checkbox text-center" style="width : 50px; margin-top: 3px;">
                                                <input type="checkbox" class='xCNCheckboxValue' id="ocbCondition<?= $aRptFilValue['FTRptFltCode'] ?><?= $aRptFilValue['FTRptGrpFlt'] ?>" checked><span></span>
                                            </label>
                                        <?php } else { ?>
                                            <label class="fancy-checkbox text-center" style="width : 50px; margin-top: 3px; ">
                                                <input type="checkbox" disabled><span class="xCNCheckboxBlockDefault"></span>
                                            </label>
                                        <?php } ?>
                                    </td>
                                    <td><?= $tCoditionReportFrom; ?></td>
                                    <td><?= $tCoditionReportTo; ?></td>
                                </tr>

                                <?php
                                $tCoditionReportFrom    = '';
                                $tCoditionReportTo      = '';
                                ?>
                            <?php } ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
<?php endif; ?>
<!--จบเงือนไขเพิ่มเติมส่วนล่าง-->

<!--ปุ่ม-->
<div id="odvBtnRptProcessGrp" class="row">

    <!-- <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
        <button type="button" id="obtRptDownloadPdf" data-rpccode="" class="btn btn-primary" style="font-size:17px;width:100%;">
            <?php echo language('report/report/report', 'tRptDownloadPDF') ?>
        </button>
    </div> -->

    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"></div>
    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
        <button type="button" id="obtRptExportExcel" data-rpccode="" class="btn xCNBTNExportExcel" style="font-size: 17px; width:100%;">
            <?php echo language('report/report/report', 'tRptExportExcel') ?>
        </button>
    </div>
    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
        <button type="button" id="obtRptViewBeforePrint" data-rpccode="" class="btn btn-primary" style="font-size: 17px; width:100%;">
            <?php echo language('report/report/report', 'tRptViewBeforePrint') ?>
        </button>
    </div>
</div>
<!--จบปุ่ม-->

<?php include "script/jReportCondition.php"; ?>

<!-- Create By Witsarut 28012021 -->
<input type ="hidden" id="oetChkRptCode" name="oetChkRptCode" value ="<?php echo $aRptFilterData['raItems']['rtRptCode'];?>">

<script>

    //กดปุ่มเลือกตามข้อมูล (เงือนไขการค้นหาส่วนบน)
    $('.xCNClickConditionSelect').click(function() {
        $('.xCNFilterRangeMode').show();
        $('.xCNFilterSelectMode').hide();

        $('.xCNBTNReport').removeClass('xCNBTNConditionActive');
        $(this).addClass('xCNBTNConditionActive');
        $('.xCNTextLabelMargin').css({
            "margin": "5px 0px 22px 0px"
        });
        $('#ohdTypeDataCondition').val(1);
        $('#obtRptClearCondition').click();
    });

    //กดปุ่มเลือกตามช่วง (เงือนไขการค้นหาส่วนบน)
    $('.xCNClickConditionBetween').click(function() {
        $('.xCNFilterRangeMode').hide();
        $('.xCNFilterSelectMode').show();

        $('.xCNBTNReport').removeClass('xCNBTNConditionActive');
        $('.xCNBTNReport').addClass('xCNBTNConditionBetween');
        $(this).addClass('xCNBTNConditionActive');
        $('.xCNTextLabelMargin').css({
            "margin": "5px 0px 22px 0px"
        });
        $('#ohdTypeDataCondition').val(2);
        $('#obtRptClearCondition').click();
    });

    //ohdTypeDataCondition : 1 เลือกแบบช่วง , 2 เลือกตามข้อมูล


    $('.xCNInputNewUIBrowse').hover(
        function() {
            $(this).addClass("xCNInputNewUIBrowseHover");
            $(this).find('.xCNButtonNewUI').css('display', 'block');
        },
        function() {
            $(this).removeClass("xCNInputNewUIBrowseHover");
            $(this).find('.xCNButtonNewUI').css('display', 'none');
        }
    );

    // ---------------------------------------------------------------------------------------

    //เข้ามารายงานปรียบเทียบยอด ให้เข้าเงื่อนงไขนี้ก่อน (เฉพาะ 2 รายงาน)
    tChkRptCode   = $('#oetChkRptCode').val();

    // if(tChkRptCode == '001001034' || tChkRptCode == '001001035'){
    //     $('.xCNFillterShw'+'52').show();
    // }

    //ถ้าเป็นรายงาน
    if('<?=$aRptFilterData['raItems']['rtRptRoute']?>' == 'rptCompareSaleByPdt' || '<?=$aRptFilterData['raItems']['rtRptRoute']?>' == 'rptCompareSaleByPdtType'){
        $('.xCNNewGroupTRG4').hide();
        $('.xCNFillterShw8').hide();
        $('.xCNFillterShw9').hide();
        $('.xCNFillterShw13').hide();
        $('.xCNFillterShw53').hide();
        $('.xCNFillterShw54').hide();
    }

    if('<?=$aRptFilterData['raItems']['rtRptRoute']?>' == 'rptLicClosetExpir'){
        $('#odvConditionSelect').hide();
        $('#odvFontHead').hide();
        $('#odvConditionLabelReport').hide();
        $('.xCNPanalCondition').attr('style', 'border-left: 0 !important');
    }

    //ปิดก่อน
    function JSxCloseFilterProduct(){
        $('.xCNFillterShw52').show();
        $('.xCNFillterShw8').hide();
        $('.xCNFillterShw9').hide();
        $('.xCNFillterShw13').hide();
        $('.xCNFillterShw53').hide();
        $('.xCNFillterShw54').hide();
    }

    $("#ocmGroupReport").change(function(){
        $('.xCNFillterShw'+'52').show();
        var nGrpType = this.value;
        switch (nGrpType) {
            case '01':
            case '02':
            case '03':
                JSxCloseFilterProduct();
                $('.xCNNewGroupTRG4').hide();
            break;
            case '04':
                JSxCloseFilterProduct();
                $('.xCNNewGroupTRG4').show();
                $('.xCNFillterShw'+'13').show();
            break;
            case '05':
                JSxCloseFilterProduct();
                $('.xCNNewGroupTRG4').show();
                $('.xCNFillterShw'+'9').show();
            break;
            case '06':
                JSxCloseFilterProduct();
                $('.xCNNewGroupTRG4').show();
                $('.xCNFillterShw'+'8').show();
            break;
            case '07':
                JSxCloseFilterProduct();
                $('.xCNNewGroupTRG4').show();
                $('.xCNFillterShw'+'53').show();
            break;
            case '08':
                JSxCloseFilterProduct();
                $('.xCNNewGroupTRG4').show();
                $('.xCNFillterShw'+'54').show();
            break;
        }
    });

    // ---------------------------------------------------------------------------------------

</script>
