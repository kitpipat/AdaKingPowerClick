<style>
    #otbPromotionStep3PmtCGTable .xCNPromotionStep3PgtGetvalue,
    #otbPromotionStep3PmtCGTable .xCNPromotionPgtGetQty,
    #otbPromotionStep3PmtCGTable .xCNPromotionPgtPerAvgDisCG {
        min-width: 100px;
    }

    #otbPromotionStep3PmtCGTable .xCNPromotionStep3PgtStaGetType {
        min-width: 120px;
    }

    #otbPromotionStep3PmtCGTable .xCNPromotionStep3PriceGroup {
        min-width: 200px;
    }
</style>
<div class="table-responsive">
    <table class="table table-striped xWPdtTableFont" id="otbPromotionStep3PmtCGTable">
        <thead>
            <tr>
                <th width="5%" class="text-center"><?php echo language('document/promotion/promotion', 'tTBNo'); ?></th>
                <th nowrap width="27%" class="text-left"><?php echo language('document/promotion/promotion', 'tGroupName'); ?></th>
                <th width="17%" class="text-center"><?php echo language('document/promotion/promotion', 'tGetConditions'); ?></th>
                <th width="17%" class="text-right"><?php echo language('document/promotion/promotion', 'tValue_Number'); ?></th>
                <th width="17%" class="text-right"><?php echo language('document/promotion/promotion', 'tAmountToReceive'); ?></th>
                <?php if ($bIsAlwPmtDisAvg) { ?>
                    <th width="17%" class="text-right"><?php echo language('document/promotion/promotion', 'tAveragePercentDiscount'); ?></th>
                <?php } ?>
            </tr>
        </thead>
        <tbody>
            <?php if ($aDataList['rtCode'] == 1) { ?>
                <?php foreach ($aDataList['raItems'] as $key => $aValue) { ?>
                    <tr class="xCNTextDetail2 xCNPromotionStep3PmtCGRow" data-seq-no="<?php echo $aValue['FNPgtSeq']; ?>">
                        <td class="text-center"><?php echo $key + 1; ?></td>
                        <td nowrap class="text-left"><?php echo $aValue['FTPmdGrpName']; ?></td>
                        <td class="text-left">
                            <select class="selectpicker_ form-control xCNApvOrCanCelDisabledPmtCG xCNPromotionStep3PgtStaGetType">
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
                            <?php if ($tPgtStaGetType == '4') { // ใช้กลุ่มราคา 
                            ?>
                                <?php $tDisabledPgtGetQtyInput = "disabled"; ?>
                                <div class="input-group xCNPromotionStep3PriceGroup">
                                    <input name="oetPromotionStep3PriceGroupNameTmp<?php echo $aValue['FNPgtSeq']; ?>" id="oetPromotionStep3PriceGroupNameTmp<?php echo $aValue['FNPgtSeq']; ?>" class="xCNModelName xCNApvOrCanCelDisabledPmtCG xCNPromotionStep3PriceGroupName form-control" type="text" readonly value="<?php echo $aValue['FTPplName']; ?>" placeholder="<?= language('document/promotion/promotion', 'tPriceGroup') ?>">
                                    <input name="oetPromotionStep3PriceGroupCodeTmp<?php echo $aValue['FNPgtSeq']; ?>" id="oetPromotionStep3PriceGroupCodeTmp<?php echo $aValue['FNPgtSeq']; ?>" class="xCNModelCode xCNPromotionStep3PriceGroupCode form-control xCNHide" type="text" data-field-name="FTPplCode" data-format-type="T" value="<?php echo $aValue['FTPplCode']; ?>">
                                    <span class="input-group-btn">
                                        <button class="btn xCNBtnBrowseAddOn xCNApvOrCanCelDisabledPmtCG" id="obtPromotionStep3PmtCGBrowseModelPriList<?php echo $aValue['FNPgtSeq']; ?>" type="button">
                                            <img src="<?= base_url() . '/application/modules/common/assets/images/icons/find-24.png' ?>">
                                        </button>
                                    </span>
                                </div>
                                <script>
                                    $('#obtPromotionStep3PmtCGBrowseModelPriList<?php echo $aValue['FNPgtSeq']; ?>').on('click', function() {
                                        // option Model
                                        window.oPromotionBrowseModelPriList<?php echo $aValue['FNPgtSeq']; ?> = {
                                            Title: ['product/pdtpricelist/pdtpricelist', 'tPPLTitle'],
                                            Table: {
                                                Master: 'TCNMPdtPriList',
                                                PK: 'FTPplCode',
                                                PKName: 'FTPplName'
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
                                                Value: ["oetPromotionStep3PriceGroupCodeTmp<?php echo $aValue['FNPgtSeq']; ?>", "TCNMPdtPriList.FTPplCode"],
                                                Text: ["oetPromotionStep3PriceGroupNameTmp<?php echo $aValue['FNPgtSeq']; ?>", "TCNMPdtPriList_L.FTPplName"],
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
                            <?php } else { ?>
                            <?php
                                $tNumberFormatControl = "";
                                $tDisabledPgtGetvalueInput = "";
                                $tMaxValue = "";
                                $tLength = "";
                                // echo $tStaBuyCond;

                                switch ($tPgtStaGetType) {
                                    case "1": { // ลดบาท
                                            $tNumberFormatControl       = "xCNInputNumeric";
                                            $tDisabledPgtGetQtyInput    = "disabled";
                                            break;
                                        }
                                    case "2": { // ลด%
                                            $tNumberFormatControl       = "xCNInputNumeric";
                                            $tDisabledPgtGetQtyInput    = "disabled";
                                            $tMaxValue                  = "100";
                                            
                                            break;
                                        }
                                    case "3": { // ปรับราคา
                                            $tNumberFormatControl       = "xCNInputNumeric";
                                            $tDisabledPgtGetQtyInput    = "disabled";
                                            break;
                                        }
                                    case "5": { // แถม(Free)
                                            $tNumberFormatControl       = "xCNInputNumeric";
                                            $tDisabledPgtGetvalueInput  = "disabled";
                                            // if( $tStaBuyCond == '2' ){
                                                $tDisabledPgtGetQtyInput = "";
                                            // }else{
                                                // $tDisabledPgtGetQtyInput = "disabled";
                                            // }
                                            break;
                                        }
                                    case "6": { // ไม่กำหนด
                                            $tNumberFormatControl       = "xCNInputNumeric";
                                            $tDisabledPgtGetvalueInput  = "disabled";
                                            $tDisabledPgtGetQtyInput    = "disabled";
                                            break;
                                        }
                                }
                            ?>
                                <input <?php echo $tDisabledPgtGetvalueInput; ?> type="text" class="text-right form-control xCNApvOrCanCelDisabledPmtCG xCNPromotionStep3PgtGetvalue xCNInputMaxValue xCNInputLength <?php echo $tNumberFormatControl; ?>" data-length="14" maxlength="14" data-field-name="FCPgtGetvalue" data-format-type="C" data-max="<?php echo $tMaxValue; ?>" value="<?php echo number_format($aValue['FCPgtGetvalue'], $nOptDecimalShow); ?>">
                            <?php } ?>
                        </td>
                        <td>
                            <input <?php echo $tDisabledPgtGetQtyInput; ?> type="text" class="form-control text-right xCNPromotionPgtGetQty xCNInputNumeric xCNApvOrCanCelDisabledPmtCG xCNInputLength" maxlength="14" data-length="14" data-field-name="FCPgtGetQty" data-format-type="C" value="<?php echo number_format($aValue['FCPgtGetQty'], $nOptDecimalShow); ?>">
                        </td>
                        <?php if ($bIsAlwPmtDisAvg) { ?>
                            <td>
                                <input type="text" class="form-control text-right xCNPromotionPgtPerAvgDisCG xCNInputNumeric xCNApvOrCanCelDisabledPmtCG xCNInputMaxValue xCNInputLength" maxlength="5" data-length="5" data-max="100" data-field-name="FCPgtPerAvgDis" data-format-type="C" value="<?php echo number_format($aValue['FCPgtPerAvgDis'], $nOptDecimalShow); ?>">
                            </td>
                        <?php } ?>
                    </tr>
                <?php } ?>
            <?php } else { ?>
                <tr>
                    <td class='text-center xCNTextDetail2' colspan='100%'><?= language('common/main/main', 'tCMNNotFoundData') ?></td>
                </tr>
            <?php }; ?>
        </tbody>
    </table>
</div>

<?php if ($aDataList['rnAllPage'] > 1) { ?>
    <div class="row xCNPromotionPmtCGPage">
        <div class="col-md-6">
            <p><?= language('common/main/main', 'tResultTotalRecord') ?> <?= $aDataList['rnAllRow'] ?> <?= language('common/main/main', 'tRecord') ?> <?= language('common/main/main', 'tCurrentPage') ?> <?= $aDataList['rnCurrentPage'] ?> / <?= $aDataList['rnAllPage'] ?></p>
        </div>
        <div class="col-md-6">
            <div class="xWPage btn-toolbar pull-right">
                <?php if ($nPage == 1) {
                    $tDisabledLeft = 'disabled';
                } else {
                    $tDisabledLeft = '-';
                } ?>
                <button onclick="JSvPromotionStep3PmtCGDataTableClickPage('previous')" class="btn btn-white btn-sm" <?php echo $tDisabledLeft ?>>
                    <i class="fa fa-chevron-left f-s-14 t-plus-1"></i>
                </button>
                <?php for ($i = max($nPage - 2, 1); $i <= max(0, min($aDataList['rnAllPage'], $nPage + 2)); $i++) { ?>
                    <?php
                    if ($nPage == $i) {
                        $tActive = 'active';
                        $tDisPageNumber = 'disabled';
                    } else {
                        $tActive = '';
                        $tDisPageNumber = '';
                    }
                    ?>
                    <button onclick="JSvPromotionStep3PmtCGDataTableClickPage('<?php echo $i ?>')" type="button" class="btn xCNBTNNumPagenation <?php echo $tActive ?>" <?php echo $tDisPageNumber ?>><?php echo $i ?></button>
                <?php } ?>
                <?php if ($nPage >= $aDataList['rnAllPage']) {
                    $tDisabledRight = 'disabled';
                } else {
                    $tDisabledRight = '-';
                } ?>
                <button onclick="JSvPromotionStep3PmtCGDataTableClickPage('next')" class="btn btn-white btn-sm" <?php echo $tDisabledRight ?>>
                    <i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
                </button>
            </div>
        </div>
    </div>
<?php } ?>

<?php include('script/jStep3PmtCGTableTmp.php'); ?>