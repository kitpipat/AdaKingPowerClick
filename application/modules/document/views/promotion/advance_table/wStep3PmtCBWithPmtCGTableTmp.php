<style>
    .xCNPromotionStep3TimeContainer {
        background-color: white;
        display: inline-flex;
        border: 1px solid #ccc;
        color: #555;
    }
    .xCNPromotionStep3TimeContainer input{
        border: none;
        color: #555;
        text-align: center;
        min-width: 60px;
        padding: 0px !important;
    }
    #otbPromotionStep3PmtCBWithPmtCGTable .xCNPromotionCBPbyMinValue, 
    #otbPromotionStep3PmtCBWithPmtCGTable .xCNPromotionCBPbyMaxValue, 
    #otbPromotionStep3PmtCBWithPmtCGTable .xCNPromotionCBPbyMinSetPri,
    #otbPromotionStep3PmtCBWithPmtCGTable .xCNPromotionStep3PgtGetvalue,
    #otbPromotionStep3PmtCBWithPmtCGTable .xCNPromotionPgtGetQty,
    #otbPromotionStep3PmtCBWithPmtCGTable .xCNPromotionPgtPerAvgDisCBWithCG{
        min-width: 100px;
    }
    #otbPromotionStep3PmtCBWithPmtCGTable .xCNPromotionStep3CGPgtStaGetType{
        min-width: 120px;
    }
    #otbPromotionStep3PmtCBWithPmtCGTable .xCNPromotionStep3PriceGroup{
        min-width: 200px;
    }
</style>
<div class="table-responsive">
    <table class="table table-striped xWPdtTableFont" id="otbPromotionStep3PmtCBWithPmtCGTable">
        <thead>
            <tr>
                <th width="2%" class="text-center"><?php echo language('document/promotion/promotion', 'tTBNo'); ?></th>
                <th nowrap width="8%" class="text-left"><?php echo language('document/promotion/promotion', 'tListGroupName'); ?></th>
                <th nowrap width="5%" class="text-center"><?php echo language('document/promotion/promotion', 'tBuyConditions'); ?></th>

                <?php if($tPbyStaBuyCond == "5" || $tPbyStaBuyCond == "6"){ // 5:ตามช่วงเวลา ครบจำนวน 6:ตามช่วงเวลา ครบมูลค่า ?>
                    <th width="10%" class="text-left"><?php echo language('document/promotion/promotion', 'tFromTime'); ?></th>
                    <th width="10%" class="text-left"><?php echo language('document/promotion/promotion', 'tToTime'); ?></th>  
                    <th width="12%" class="text-right"><?php echo language('document/promotion/promotion', 'tBuyConditionCol'.$tPbyStaBuyCond); ?></th>
                    <th width="12%" class="text-right xCNHide"><?php echo language('document/promotion/promotion', 'tNotOver'); ?></th>
                <?php }else{ ?>
                    <th width="12%" class="text-right"><?php echo language('document/promotion/promotion', 'tBuyConditionCol'.$tPbyStaBuyCond); ?></th>
                    <th width="12%" class="text-right"><?php echo language('document/promotion/promotion', 'tNotOver'); ?></th>
                    <th width="12%" class="text-right"><?php echo language('document/promotion/promotion', 'tMinimumPrice_Unit'); ?></th>
                <?php } ?>
                
                <th width="10%" class="text-left"><?php echo language('document/promotion/promotion', 'tGetConditions'); ?></th>
                <th width="12%" class="text-right"><?php echo language('document/promotion/promotion', 'tValue'); ?></th>
                <th width="12%" class="text-right"><?php echo language('document/promotion/promotion', 'tAmountToReceive'); ?></th>
                <?php if($bIsAlwPmtDisAvg) { ?>
                <th width="12%" class="text-right"><?php echo language('document/promotion/promotion', 'tAveragePercentDiscount'); ?></th>
                <?php } ?>
                <th width="2%" class="text-center"><?php echo language('document/promotion/promotion', 'tTBDelete'); ?></th>
            </tr>
        </thead>
        <tbody class="xCNPromotionStep3RangeTbody">
            <?php if ($aDataList['rtCode'] == 1) { ?>
                <?php foreach ($aDataList['raItems'] as $key => $aValue) { ?>
                    <tr 
                    class="xCNTextDetail2 xCNPromotionStep3PmtCBWithPmtCGRow <?php echo str_replace(" ","",$aValue['FTPmdGrpName']); ?>" 
                    data-cb-seq-no="<?php echo $aValue['FNPbySeq']; ?>" 
                    data-cg-seq-no="<?php echo $aValue['FNPgtSeq']; ?>"
                    data-grp-name="<?php echo $aValue['FTPmdGrpName']; ?>">
                        <td class="text-center"><?php echo $key+1; ?></td>
                        <td nowrap class="text-left"><?php echo $aValue['FTPmdGrpName']; ?></td>
                        <td nowrap class="text-center"><?php echo language('document/promotion/promotion', 'tBuyCondition' . $aValue['FTPbyStaBuyCond']); ?></td>

                        <?php if($tPbyStaBuyCond == "5" || $tPbyStaBuyCond == "6"){ // 5:ตามช่วงเวลา ครบจำนวน 6:ตามช่วงเวลา ครบมูลค่า ?>
                            <td class="text-left">
                                <div class="xCNPromotionStep3TimeContainer">
                                    <?php 
                                        // $aTime = explode(':', $aValue['FTPbyMinTime']);
                                        // $tHr = isset($aTime[0]) && !empty($aTime[0])?$aTime[0]:"";
                                        // $tMin = isset($aTime[1]) && !empty($aTime[0])?$aTime[1]:"";
                                    ?>
                                    <input 
                                    type="text" 
                                    data-field-name="FTPbyMinTime"
                                    data-format-type="D"
                                    class="form-control xCNTimePickerMinTime<?php echo $aValue['FNPgtSeq']; ?> xCNApvOrCanCelDisabledPmtCBWithPmtCG xCNPromotionStep3PbyMinTime"
                                    value="<?php echo $aValue['FTPbyMinTime']; ?>">
                                    <script>
                                        var tOldTimeMin<?php echo $aValue['FNPgtSeq']; ?> = "";
                                        $('.xCNTimePickerMinTime<?php echo $aValue['FNPgtSeq']; ?>').datetimepicker({
                                            format: 'HH:mm'
                                        }).on("blur", function(e){
                                            var tValueMin<?php echo $aValue['FNPgtSeq']; ?> = $(this).val();
                                            if(tValueMin<?php echo $aValue['FNPgtSeq']; ?> != tOldTimeMin<?php echo $aValue['FNPgtSeq']; ?>){
                                                tOldTimeMin<?php echo $aValue['FNPgtSeq']; ?> = tValueMin<?php echo $aValue['FNPgtSeq']; ?>;
                                                JSxPromotionStep3PmtCBRangeDataTableEditInline(this);
                                            }
                                        });
                                    </script>
                                    <!-- <input 
                                    class="form-control xCNInputMaxValue xCNInputMinValue xCNInputLength xCNInputNumericWithoutDecimal xCNApvOrCanCelDisabledPmtCBWithPmtCG xCNPromotionStep3PbyMinTimeHr" 
                                    data-length="2" 
                                    data-max="23" 
                                    data-min="0" 
                                    type="text" 
                                    min="0" 
                                    max="23"
                                    data-field-name="FTPbyMinTime"
                                    data-format-type="D" 
                                    placeholder="--" 
                                    value="<?php // echo $tHr; ?>">:
                                    <input 
                                    class="form-control xCNInputMaxValue xCNInputMinValue xCNInputLength xCNInputNumericWithoutDecimal xCNApvOrCanCelDisabledPmtCBWithPmtCG xCNPromotionStep3PbyMinTimeMin" 
                                    data-length="2" 
                                    data-max="59" 
                                    data-min="0" 
                                    type="text" 
                                    min="0" 
                                    max="59" 
                                    data-field-name="FTPbyMinTime"
                                    data-format-type="D"
                                    placeholder="--" 
                                    value="<?php // echo $tMin; ?>"> -->
                                </div>
                            </td>
                            <td>
                                <div class="xCNPromotionStep3TimeContainer">
                                    <?php 
                                        // $aTime = explode(':', $aValue['FTPbyMaxTime']);
                                        // $tHr = isset($aTime[0]) && !empty($aTime[0])?$aTime[0]:"";
                                        // $tMin = isset($aTime[1]) && !empty($aTime[0])?$aTime[1]:"";
                                    ?>
                                    <input 
                                    type="text" 
                                    data-field-name="FTPbyMaxTime"
                                    data-format-type="D"
                                    class="form-control xCNTimePickerMaxTime<?php echo $aValue['FNPgtSeq']; ?> xCNApvOrCanCelDisabledPmtCBWithPmtCG xCNPromotionStep3PbyMaxTime"
                                    value="<?php echo $aValue['FTPbyMaxTime']; ?>">
                                    <script>
                                        var tOldTimeMax<?php echo $aValue['FNPgtSeq']; ?> = "";
                                        $('.xCNTimePickerMaxTime<?php echo $aValue['FNPgtSeq']; ?>').datetimepicker({
                                            format: 'HH:mm'
                                        }).on("blur", function(e){
                                            var tValueMax<?php echo $aValue['FNPgtSeq']; ?> = $(this).val();
                                            if(tValueMax<?php echo $aValue['FNPgtSeq']; ?> != tOldTimeMax<?php echo $aValue['FNPgtSeq']; ?>){
                                                tOldTimeMax<?php echo $aValue['FNPgtSeq']; ?> = tValueMax<?php echo $aValue['FNPgtSeq']; ?>;
                                                JSxPromotionStep3PmtCBRangeDataTableEditInline(this);
                                            }
                                        });
                                    </script>
                                    <!-- <input 
                                    class="form-control xCNInputMaxValue xCNInputMinValue xCNInputLength xCNInputNumericWithoutDecimal xCNApvOrCanCelDisabledPmtCBWithPmtCG xCNPromotionStep3PbyMaxTimeHr" 
                                    data-length="2" 
                                    data-max="23" 
                                    data-min="0" 
                                    type="text" 
                                    min="0" 
                                    max="23"
                                    data-field-name="FTPbyMaxTime"
                                    data-format-type="D" 
                                    placeholder="--" 
                                    value="<?php // echo $tHr; ?>">:
                                    <input 
                                    class="form-control xCNInputMaxValue xCNInputMinValue xCNInputLength xCNInputNumericWithoutDecimal xCNApvOrCanCelDisabledPmtCBWithPmtCG xCNPromotionStep3PbyMaxTimeMin" 
                                    data-length="2" 
                                    data-max="59" 
                                    data-min="0" 
                                    type="text" 
                                    min="0" 
                                    max="59" 
                                    data-field-name="FTPbyMaxTime"
                                    data-format-type="D"
                                    placeholder="--" 
                                    value="<?php // echo $tMin; ?>"> -->
                                </div>
                            </td>
                            <?php if($tPbyStaBuyCond == "5" || $tPbyStaBuyCond == "6"){ // 5:ตามช่วงเวลา ครบจำนวน 6:ตามช่วงเวลา ครบมูลค่า ?>
                                <td class="text-left">
                                    <input 
                                    type="text" 
                                    class="form-control text-right xCNInputNumericWithDecimal xCNApvOrCanCelDisabledPmtCBWithPmtCG xCNPromotionCBPbyMinValue"
                                    maxlength="14"
                                    data-field-name="FCPbyMinValue"
                                    data-format-type="C" 
                                    value="<?php echo number_format($aValue['FCPbyMinValue'], $nOptDecimalShow); ?>">
                                </td>
                                <td class="text-left xCNHide">
                                    <input 
                                    type="text" 
                                    class="form-control text-right xCNInputNumericWithDecimal xCNApvOrCanCelDisabledPmtCBWithPmtCG xCNPromotionCBPbyMaxValue"  
                                    maxlength="14" 
                                    value="0">
                                </td>
                            <?php } ?>
                        <?php }else{ ?>
                            <td class="text-left">
                                <input 
                                type="text" 
                                class="form-control text-right xCNInputNumericWithDecimal xCNApvOrCanCelDisabledPmtCBWithPmtCG xCNPromotionCBPbyMinValue"
                                maxlength="14" 
                                data-field-name="FCPbyMinValue"
                                data-format-type="C"
                                value="<?php echo number_format($aValue['FCPbyMinValue'], $nOptDecimalShow); ?>">
                            </td>
                            <td class="text-left">
                                <input 
                                type="text" 
                                class="form-control text-right xCNInputNumericWithDecimal xCNApvOrCanCelDisabledPmtCBWithPmtCG xCNPromotionCBPbyMaxValue"  
                                maxlength="14" 
                                data-field-name="FCPbyMaxValue"
                                data-format-type="C" 
                                value="<?php echo number_format($aValue['FCPbyMaxValue'], $nOptDecimalShow); ?>">
                            </td>
                            <td class="text-left">
                                <input 
                                type="text" 
                                class="form-control text-right xCNInputNumericWithDecimal xCNApvOrCanCelDisabledPmtCBWithPmtCG xCNPromotionCBPbyMinSetPri"  
                                maxlength="14"
                                data-field-name="FCPbyMinSetPri"
                                data-format-type="C" 
                                value="<?php echo number_format($aValue['FCPbyMinSetPri'], $nOptDecimalShow); ?>">
                            </td>
                        <?php } ?>

                        <td class="text-left">
                            <select class="xCNApvOrCanCelDisabledPmtCBWithPmtCG form-control xCNPromotionStep3CGPgtStaGetType">
                                <option class="1" value='1' <?php echo ($aValue['FTPgtStaGetType'] == '1') ? 'selected' : ''; ?>><?php echo language('document/promotion/promotion', 'tBahtDiscount'); ?></option>
                                <option class="2" value='2' <?php echo ($aValue['FTPgtStaGetType'] == '2') ? 'selected' : ''; ?>><?php echo language('document/promotion/promotion', 'tPercentDiscount'); ?></option>
                                <option class="3" value='3' <?php echo ($aValue['FTPgtStaGetType'] == '3') ? 'selected' : ''; ?>><?php echo language('document/promotion/promotion', 'tAdjustThePrice'); ?></option>
                                <option class="4" value='4' <?php echo ($aValue['FTPgtStaGetType'] == '4') ? 'selected' : ''; ?>><?php echo language('document/promotion/promotion', 'tUsePriceGroup'); ?></option>
                                <option class="5" value='5' <?php echo ($aValue['FTPgtStaGetType'] == '5') ? 'selected' : ''; ?>><?php echo language('document/promotion/promotion', 'tFree'); ?></option>
                                <!-- <option class="6" value='6' <?php echo ($aValue['FTPgtStaGetType'] == '6') ? 'selected' : ''; ?>><?php echo language('document/promotion/promotion', 'tIndeterminate'); ?></option> -->
                            </select>
                        </td>
                        <td class="text-left">
                            <?php $tPgtStaGetType = $aValue['FTPgtStaGetType']; ?>
                            <?php $tDisabledPgtGetQtyInput = ""; ?>
                            <?php if($tPgtStaGetType == '4') { // ใช้กลุ่มราคา ?>
                                <?php $tDisabledPgtGetQtyInput = "disabled"; ?>
                                <div class="input-group xCNPromotionStep3PriceGroup">
                                    <input 
                                    name="oetPromotionStep3PmtCBWithPmtCGPriceGroupNameTmp<?php echo $aValue['FNPgtSeq']; ?>" 
                                    id="oetPromotionStep3PmtCBWithPmtCGPriceGroupNameTmp<?php echo $aValue['FNPgtSeq']; ?>" 
                                    class="xCNModelName xCNPromotionStep3PriceGroupName form-control xCNApvOrCanCelDisabledPmtCBWithPmtCG"
                                    type="text" 
                                    readonly 
                                    value="<?php echo $aValue['FTPplName']; ?>"
                                    placeholder="<?= language('document/promotion/promotion', 'tPriceGroup') ?>">
                                    <input 
                                    name="oetPromotionStep3PmtCGWithPtCGPriceGroupCodeTmp<?php echo $aValue['FNPgtSeq']; ?>" 
                                    id="oetPromotionStep3PmtCGWithPtCGPriceGroupCodeTmp<?php echo $aValue['FNPgtSeq']; ?>" 
                                    class="xCNModelCode xCNPromotionStep3PriceGroupCode form-control xCNHide" 
                                    type="text" 
                                    data-field-name="FTPplCode"
                                    data-format-type="T"
                                    value="<?php echo $aValue['FTPplCode']; ?>">
                                    <span class="input-group-btn">
                                        <button class="btn xCNBtnBrowseAddOn xCNApvOrCanCelDisabledPmtCBWithPmtCG" id="obtPromotionStep3PmtCBWithPmtCGBrowseModelPriList<?php echo $aValue['FNPgtSeq']; ?>" type="button">
                                            <img src="<?= base_url() . '/application/modules/common/assets/images/icons/find-24.png' ?>">
                                        </button>
                                    </span>
                                </div>
                                <script>
                                    $('#obtPromotionStep3PmtCBWithPmtCGBrowseModelPriList<?php echo $aValue['FNPgtSeq']; ?>').on('click', function(){
                                        // option Model
                                        window.oPromotionBrowseModelPriList<?php echo $aValue['FNPgtSeq']; ?> = {
                                            Title: ['product/pdtpricelist/pdtpricelist', 'tPPLTitle'],
                                            Table: {
                                                Master: 'TCNMPdtPriList',
                                                PK: 'FTPplCode',
                                                PKName:'FTPplName'
                                            },
                                            Join: {
                                                Table: ['TCNMPdtPriList_L'],
                                                On: ['TCNMPdtPriList.FTPplCode = TCNMPdtPriList_L.FTPplCode AND TCNMPdtPriList_L.FNLngID = ' + nLangEdits]
                                            },
                                            Where: {
                                                Condition: [
                                                    function() {
                                                        return " AND TCNMPdtPriList.FTPplCode NOT IN (SELECT FTPplCode FROM TCNTPdtPmtHDCstPri_Tmp WHERE FTSessionID = '<?php echo $this->session->userdata("tSesSessionID"); ?>')";
                                                    }
                                                ]
                                            },
                                            GrideView: {
                                                ColumnPathLang: 'product/pdtpricelist/pdtpricelist',
                                                ColumnKeyLang: ['tPPLTBCode', 'tPPLTBName'],
                                                ColumnsSize: ['15%', '75%'],
                                                WidthModal: 50,
                                                DataColumns: ['TCNMPdtPriList.FTPplCode', 'TCNMPdtPriList_L.FTPplName'],
                                                DataColumnsFormat: ['', ''],
                                                Perpage: 5,
                                                OrderBy: ['TCNMPdtPriList.FTPplCode'],
                                                SourceOrder: "ASC"
                                            },
                                            CallBack: {
                                                ReturnType: 'S',
                                                Value: ["oetPromotionStep3PmtCGWithPtCGPriceGroupCodeTmp<?php echo $aValue['FNPgtSeq']; ?>", "TCNMPdtPriList.FTPplCode"],
                                                Text: ["oetPromotionStep3PmtCBWithPmtCGPriceGroupNameTmp<?php echo $aValue['FNPgtSeq']; ?>", "TCNMPdtPriList_L.FTPplName"],
                                            },
                                            /* NextFunc: {
                                                FuncName: 'JSvPromotionStep4InsertPdtPmtHDCstPriToTemp',
                                                ArgReturn: ['FTPplCode', 'FTPplName']
                                            }, */
                                            BrowseLev: 1,
                                            // DebugSQL : true
                                        }
                                        JCNxBrowseData("oPromotionBrowseModelPriList<?php echo $aValue['FNPgtSeq']; ?>");
                                    });
                                </script>
                            <?php }else{ ?>
                                <?php
                                    $tNumberFormatControl = "";
                                    $tDisabledPgtGetvalueInput = "";
                                    $tMaxValue = "";
                                    $tLength = "";
                                    
                                    switch($tPgtStaGetType){
                                        case "1" : { // ลดบาท
                                            $tNumberFormatControl = "xCNInputNumericWithDecimal";
                                            $tDisabledPgtGetQtyInput = "disabled";    
                                            break;
                                        }
                                        case "2" : { // ลด%
                                            $tNumberFormatControl = "xCNInputNumericWithDecimal";
                                            $tMaxValue = "100";
                                            $tDisabledPgtGetQtyInput = "disabled";
                                            break;
                                        }
                                        case "3" : { // ปรับราคา
                                            $tNumberFormatControl = "xCNInputNumericWithDecimal";
                                            $tDisabledPgtGetQtyInput = "disabled";
                                            break;
                                        }
                                        case "5" : { // แถม(Free)
                                            $tNumberFormatControl = "xCNInputNumericWithDecimal";
                                            $tDisabledPgtGetvalueInput = "disabled";
                                            break;
                                        }
                                        case "6" : { // ไม่กำหนด
                                            $tNumberFormatControl = "xCNInputNumericWithDecimal";
                                            $tDisabledPgtGetvalueInput = "disabled";
                                            $tDisabledPgtGetQtyInput = "disabled";
                                            break;
                                        }
                                    } 
                                ?>
                                <input 
                                <?php echo $tDisabledPgtGetvalueInput; ?>
                                type="text"
                                class="text-right form-control xCNApvOrCanCelDisabledPmtCBWithPmtCG xCNPromotionStep3PgtGetvalue xCNInputMaxValue xCNInputLength <?php echo $tNumberFormatControl; ?>"  
                                maxlength="14"
                                data-length="14"
                                data-max="<?php echo $tMaxValue; ?>" 
                                data-field-name="FCPgtGetvalue"
                                data-format-type="C"
                                value="<?php echo number_format($aValue['FCPgtGetvalue'], $nOptDecimalShow); ?>">
                            <?php } ?>
                        </td>
                        <td>
                            <input 
                            <?php echo $tDisabledPgtGetQtyInput; ?>
                            type="text" 
                            class="form-control text-right xCNInputNumeric xCNInputLength xCNApvOrCanCelDisabledPmtCBWithPmtCG xCNPromotionPgtGetQty"  
                            maxlength="14"
                            data-length="14"
                            data-field-name="FCPgtGetQty"
                            data-format-type="C"
                            value="<?php echo number_format($aValue['FCPgtGetQty'], $nOptDecimalShow); ?>">
                        </td>
                        <?php if($bIsAlwPmtDisAvg) { ?>
                        <td>
                            <input 
                            type="text" 
                            class="form-control text-right xCNInputNumeric xCNInputMaxValue xCNInputLength xCNApvOrCanCelDisabledPmtCBWithPmtCG xCNPromotionPgtPerAvgDisCBWithCG"  
                            maxlength="5"
                            data-length="5" 
                            data-max="100"
                            data-field-name="FCPgtPerAvgDis"
                            data-format-type="C"
                            value="<?php echo number_format($aValue['FCPgtPerAvgDis'], $nOptDecimalShow); ?>">
                        </td>
                        <?php } ?>
                        <td class="text-c_enter">
                            <img class="xCNIconTable xCNIconDel" src="<?= base_url('application/modules/common/assets/images/icons/delete.png') ?>">
                        </td>
                    </tr>
                    <?php if($aValue['FNRowPartID'] == $aValue['FNCountGroupName']) { ?>
                        <tr>
                            <td colspan='100%'>
                                <button
                                data-grpname="<?php echo $aValue['FTPmdGrpName']; ?>" 
                                class="xCNBTNPrimeryPlus pull-right xCNPromotionStep3RangeAddItemRowBtn"
                                type="button"
                                style="margin-bottom: 10px;">+</button>
                            </td>
                        </tr>
                    <?php } ?>
                <?php } ?>
            <?php } else { ?>
                <tr>
                    <td class='text-center xCNTextDetail2' colspan='100%'><?= language('common/main/main', 'tCMNNotFoundData') ?></td>
                </tr>
            <?php }; ?>
        </tbody>
    </table>
</div>

<?php if($aDataList['rnAllPage'] > 1) { ?>
    <div class="row xCNPromotionPmtCBPage">
        <div class="col-md-6">
            <p><?= language('common/main/main','tResultTotalRecord')?> <?=$aDataList['rnAllRow']?> <?= language('common/main/main','tRecord')?> <?= language('common/main/main','tCurrentPage')?> <?=$aDataList['rnCurrentPage']?> / <?=$aDataList['rnAllPage']?></p>
        </div>
        <div class="col-md-6">
            <div class="xWPage btn-toolbar pull-right">
                <?php if($nPage == 1){ $tDisabledLeft = 'disabled'; }else{ $tDisabledLeft = '-';} ?>
                <button onclick="JSvPromotionStep3PmtCBWithPmtCGDataTableClickPage('previous')" class="btn btn-white btn-sm" <?php echo $tDisabledLeft ?>>
                    <i class="fa fa-chevron-left f-s-14 t-plus-1"></i>
                </button>
                <?php for($i=max($nPage-2, 1); $i<=max(0, min($aDataList['rnAllPage'],$nPage+2)); $i++){?>
                    <?php 
                        if($nPage == $i){ 
                            $tActive = 'active'; 
                            $tDisPageNumber = 'disabled';
                        }else{ 
                            $tActive = '';
                            $tDisPageNumber = '';
                        }
                    ?>
                    <button onclick="JSvPromotionStep3PmtCBWithPmtCGDataTableClickPage('<?php echo $i?>')" type="button" class="btn xCNBTNNumPagenation <?php echo $tActive ?>" <?php echo $tDisPageNumber ?>><?php echo $i?></button>
                <?php } ?>
                <?php if($nPage >= $aDataList['rnAllPage']){  $tDisabledRight = 'disabled'; }else{  $tDisabledRight = '-';  } ?>
                <button onclick="JSvPromotionStep3PmtCBWithPmtCGDataTableClickPage('next')" class="btn btn-white btn-sm" <?php echo $tDisabledRight ?>>
                    <i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
                </button>
            </div>
        </div>
    </div>
<?php } ?>

<?php include('script/jStep3PmtCBWithPmtCGTableTmp.php'); ?>