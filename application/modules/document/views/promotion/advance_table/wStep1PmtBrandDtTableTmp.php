<?php 
// echo '</pre>'; var_dump($aPdtCond); 
$bIsUseSubRef = !empty($aPdtCond['tSubTable']);
?>
<div class="table-responsive">
    <table class="table table-striped xWPdtTableFont" id="otbPromotionStep1PmtBrandDtTable">
        <thead>
            <tr>
                <th width="2%" class="text-center">
                    <label class="fancy-checkbox">
                        <input type="checkbox" class="xCNListItemAll xCNApvOrCanCelDisabledPmtBrandDt">
                        <span>&nbsp;</span>
                    </label>
                </th>
                <th width="5%" class="text-center"><?php echo language('document/promotion/promotion', 'tTBNo'); ?></th>
                <th width="20%" class="text-left"><?php echo $aPdtCond['tFieldCodeLabel']; ?></th>
                <th width="40%" class="text-left"><?php echo $aPdtCond['tFieldNameLabel']; ?></th>
                <?php if($bIsUseSubRef) { ?>
                <th width="30%" class="text-left"><?php echo $aPdtCond['tSubRefNTitle']; ?></th>
                <?php } ?>
                <th width="5%" class="text-center"><?php echo language('document/promotion/promotion', 'tTBDelete'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php if ($aDataList['rtCode'] == 1) { ?>
                <?php foreach ($aDataList['raItems'] as $key => $aValue) { ?>
                    <?php $bIsShopAll = (empty($aValue['FTPmdRefCode']) && empty($aValue['FTPmdRefName']) && empty($aValue['FTPmdSubRefName']) && empty($aValue['FTPmdBarCode'])); ?>
                    <?php if(!$bIsShopAll) { ?>
                        <tr class="xCNTextDetail2 xCNPromotionPmtBrandDtRow" data-seq-no="<?php echo $aValue['FNPmdSeq']; ?>">
                            <td class="text-center">
                                <label class="fancy-checkbox">
                                    <input type="checkbox" class="xCNListItem xCNApvOrCanCelDisabledPmtBrandDt" name="ocbListItem[]">
                                    <span>&nbsp;</span>
                                </label>
                            </td>
                            <td class="text-center"><?php echo $key+1; ?></td>
                            <td class="text-left"><?php echo $aValue['FTPmdRefCode']; ?></td>
                            <td class="text-left"><?php echo $aValue['FTPmdRefName']; ?></td>
                            <?php if($bIsUseSubRef) { ?>
                            <td class="text-left">
                                <div class="input-group">
                                    <input 
                                    name="oetPromotionPmtModelName<?php echo $aValue['FNPmdSeq']; ?>" 
                                    id="oetPromotionPmtModelName<?php echo $aValue['FNPmdSeq']; ?>" 
                                    class="xCNModelName form-control"
                                    type="text" 
                                    readonly 
                                    value="<?php echo $aValue['FTPmdSubRefName']; ?>"
                                    placeholder="<?php echo $aPdtCond['tSubRefNTitle']; ?>"
                                    data-validate-required="<?= language('document/promotion/promotion', 'tTopUpVendingMerValidate') ?>">
                                    <input 
                                    name="oetPromotionPmtModelCode<?php echo $aValue['FNPmdSeq']; ?>" 
                                    id="oetPromotionPmtModelCode<?php echo $aValue['FNPmdSeq']; ?>" 
                                    class="xCNModelCode form-control xCNHide" 
                                    type="text" 
                                    value="<?php echo $aValue['FTPmdSubRef']; ?>"
                                    onchange="JSxPromotionStep1PmtBrandDtDataTableUpdateBySeq(this)">
                                    <span class="input-group-btn">
                                        <button class="btn xCNBtnBrowseAddOn xCNApvOrCanCelDisabledPmtBrandDt" id="obtPromotionBrowseModel<?php echo $aValue['FNPmdSeq']; ?>" type="button">
                                            <img src="<?= base_url('application/modules/common/assets/images/icons/find-24.png') ?>">
                                        </button>
                                    </span>
                                </div>
                                <script>
                                    $('#obtPromotionBrowseModel<?php echo $aValue['FNPmdSeq']; ?>').on('click', function(){
                                        // Option
                                        var tSqlView = '<?php echo $aPdtCond['tSubRef']; ?>';
                                        var tTable = '<?php echo $aPdtCond['tSubTable']; ?>';
                                        var tTableL = '<?php echo $aPdtCond['tSubTableL']; ?>';

                                        if(tTable == "TCNMPdtSpl"){
                                            tTableL = "TCNMSpl_L";
                                        }
                                        var tFieldCode = '<?php echo $aPdtCond['tSubFieldCode']; ?>';
                                        var tFieldName = '<?php echo $aPdtCond['tSubFieldName']; ?>';
                                        var tTitle = '<?php echo $aPdtCond['tSubRefNTitle']; ?>';
                                        var tFieldCodeLabel = '<?php echo $aPdtCond['tSubFieldCodeLabel']; ?>';
                                        var tFieldNameLabel = '<?php echo $aPdtCond['tSubFieldNameLabel']; ?>';

                                        window.oPromotionBrowseModel<?php echo $aValue['FNPmdSeq']; ?> = {
                                            // Option
                                            Title: ['', tTitle],
                                            Table: {
                                                Master: tSqlView,
                                                PK: tFieldCode,
                                                PKName: tFieldName
                                            },
                                            Where: {
                                                Condition: [
                                                    function() {
                                                        return " AND " + tSqlView + ".FNLngID = " + nLangEdits;
                                                    }
                                                ]
                                            },
                                            GrideView: {
                                                ColumnPathLang: '',
                                                ColumnKeyLang: [tFieldCodeLabel, tFieldNameLabel],
                                                ColumnLang: ['', ''],
                                                ColumnsSize: ['15%', '75%'],
                                                WidthModal: 50,
                                                DataColumns: [tSqlView+"."+tFieldCode, tSqlView+"."+tFieldName],
                                                DataColumnsFormat: ['', ''],
                                                Perpage: 5,
                                                OrderBy: [tSqlView+"."+tFieldCode],
                                                SourceOrder: "ASC"
                                            },
                                            CallBack: {
                                                ReturnType: 'S',
                                                Value: ["oetPromotionPmtModelCode<?php echo $aValue['FNPmdSeq']; ?>", tSqlView+"."+tFieldCode],
                                                Text: ["oetPromotionPmtModelName<?php echo $aValue['FNPmdSeq']; ?>", tSqlView+"."+tFieldName],
                                            },
                                            NextFunc: {
                                                FuncName: 'JSvPromotionStep1InsertPmtBrandDtToTemp',
                                                ArgReturn: [tFieldCode, tFieldName]
                                            },
                                            BrowseLev: 1,
                                            // DebugSQL : true
                                        }
                                        JCNxBrowseData("oPromotionBrowseModel<?php echo $aValue['FNPmdSeq']; ?>");
                                    });
                                </script>
                            </td>
                            <?php } ?>
                            <td class="text-center">
                                <img class="xCNIconTable xCNIconDel" src="<?= base_url('application/modules/common/assets/images/icons/delete.png') ?>">
                            </td>
                        </tr>
                    <?php }else{ ?>
                        <tr>
                            <td class='text-center xCNTextDetail2 xCNPromotionStep1PmtDtShopAll' data-status="1" colspan='100%'><?= language('common/main/main', 'ทั้งร้าน') ?></td>
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
    <div class="row xCNPromotionPmtBrandDtPage">
        <div class="col-md-6">
            <p><?= language('common/main/main','tResultTotalRecord')?> <?=$aDataList['rnAllRow']?> <?= language('common/main/main','tRecord')?> <?= language('common/main/main','tCurrentPage')?> <?=$aDataList['rnCurrentPage']?> / <?=$aDataList['rnAllPage']?></p>
        </div>
        <div class="col-md-6">
            <div class="xWPage btn-toolbar pull-right">
                <?php if($nPage == 1){ $tDisabledLeft = 'disabled'; }else{ $tDisabledLeft = '-';} ?>
                <button onclick="JSvPromotionStep1PmtBrandDtDataTableClickPage('previous')" class="btn btn-white btn-sm" <?php echo $tDisabledLeft ?>>
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
                    <button onclick="JSvPromotionStep1PmtBrandDtDataTableClickPage('<?php echo $i?>')" type="button" class="btn xCNBTNNumPagenation <?php echo $tActive ?>" <?php echo $tDisPageNumber ?>><?php echo $i?></button>
                <?php } ?>
                <?php if($nPage >= $aDataList['rnAllPage']){  $tDisabledRight = 'disabled'; }else{  $tDisabledRight = '-';  } ?>
                <button onclick="JSvPromotionStep1PmtBrandDtDataTableClickPage('next')" class="btn btn-white btn-sm" <?php echo $tDisabledRight ?>>
                    <i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
                </button>
            </div>
        </div>
    </div>
<?php } ?>

<?php include('script/jStep1PmtBrandDtTableTmp.php'); ?>