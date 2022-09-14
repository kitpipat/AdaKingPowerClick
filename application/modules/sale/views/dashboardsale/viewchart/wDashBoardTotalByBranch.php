<?php
if ($aTotalSaleByBranchData['rtCode'] == '1') {
    $nCurrentPage = $aTotalSaleByBranchData['rnCurrentPage'];
} else {
    $nCurrentPage = '1';
}
?>
<style>
    .xWRowSort {
        cursor: pointer;
    }

    .xWSpanSort {
        cursor: pointer;
    }
</style>

<?php
$tButtonSortFTBchName = "<span style='float: right;''><i class='fa fa-sort-desc' aria-hidden='true'></i></span>";
$tButtonSortFTPosCode = "<span style='float: right;''><i class='fa fa-sort-desc' aria-hidden='true'></i></span>";
$tButtonSortFDXshDocDate = "<span style='float: right;''><i class='fa fa-sort-desc' aria-hidden='true'></i></span>";
$tButtonSortFTShfCode = "<span style='float: right;''><i class='fa fa-sort-desc' aria-hidden='true'></i></span>";
$tButtonSortFNXshDocType = "<span style='float: right;''><i class='fa fa-sort-desc' aria-hidden='true'></i></span>";
$tButtonSortBillMin = "<span style='float: right;''><i class='fa fa-sort-desc' aria-hidden='true'></i></span>";
$tButtonSortBillMax = "<span style='float: right;''><i class='fa fa-sort-desc' aria-hidden='true'></i></span>";
$tButtonSortBillQty = "<span style='float: right;''><i class='fa fa-sort-desc' aria-hidden='true'></i></span>";
$tButtonSortBillAmt = "<span style='float: right;''><i class='fa fa-sort-desc' aria-hidden='true'></i></span>";
$tButtonSortBillChk = "<span style='float: right;''><i class='fa fa-sort-desc' aria-hidden='true'></i></span>";
$tButtonSortBillDiff = "<span style='float: right;''><i class='fa fa-sort-desc' aria-hidden='true'></i></span>";


if ($tfild == 'ASC') {
    if ($tfild == 'FTBchName') {
        $tButtonSortFTBchName = "<span style='float: right;''><i class='fa fa-sort-asc' aria-hidden='true'></i></span>";
    } else if ($tfild == 'FTPosCode') {
        $tButtonSortFTPosCode = "<span style='float: right;''><i class='fa fa-sort-asc' aria-hidden='true'></i></span>";
    } else if ($tfild == 'FDXshDocDate') {
        $tButtonSortFDXshDocDate = "<span style='float: right;''><i class='fa fa-sort-asc' aria-hidden='true'></i></span>";
    } else if ($tfild == 'FTShfCode') {
        $tButtonSortFTShfCode = "<span style='float: right;''><i class='fa fa-sort-asc' aria-hidden='true'></i></span>";
    } else if ($tfild == 'FNXshDocType') {
        $tButtonSortFNXshDocType = "<span style='float: right;''><i class='fa fa-sort-asc' aria-hidden='true'></i></span>";
    } else if ($tfild == 'BillMin') {
        $tButtonSortBillMin = "<span style='float: right;''><i class='fa fa-sort-asc' aria-hidden='true'></i></span>";
    } else if ($tfild == 'BillMax') {
        $tButtonSortBillMax = "<span style='float: right;''><i class='fa fa-sort-asc' aria-hidden='true'></i></span>";
    } else if ($tfild == 'BillQty') {
        $tButtonSortBillQty = "<span style='float: right;''><i class='fa fa-sort-asc' aria-hidden='true'></i></span>";
    } else if ($tfild == 'BillAmt') {
        $tButtonSortBillAmt = "<span style='float: right;''><i class='fa fa-sort-asc' aria-hidden='true'></i></span>";
    } else if ($tfild == 'BillChk') {
        $tButtonSortBillChk = "<span style='float: right;''><i class='fa fa-sort-asc' aria-hidden='true'></i></span>";
    } else if ($tfild == 'ISNULL((CONVERT(bigint, RIGHT(BillQty,7))-CONVERT(bigint, RIGHT(BillChk,7))),0)') {
        $tButtonSortBillDiff = "<span style='float: right;''><i class='fa fa-sort-asc' aria-hidden='true'></i></span>";
    }
} else if ($tSort == 'DESC') {
    if ($tfild == 'FTBchName') {
        $tButtonSortFTBchName = "<span style='float: right;''><i class='fa fa-sort-asc' aria-hidden='true'></i></span>";
    } else if ($tfild == 'FTPosCode') {
        $tButtonSortFTPosCode = "<span style='float: right;''><i class='fa fa-sort-asc' aria-hidden='true'></i></span>";
    } else if ($tfild == 'FDXshDocDate') {
        $tButtonSortFDXshDocDate = "<span style='float: right;''><i class='fa fa-sort-asc' aria-hidden='true'></i></span>";
    } else if ($tfild == 'FTShfCode') {
        $tButtonSortFTShfCode = "<span style='float: right;''><i class='fa fa-sort-asc' aria-hidden='true'></i></span>";
    } else if ($tfild == 'FNXshDocType') {
        $tButtonSortFNXshDocType = "<span style='float: right;''><i class='fa fa-sort-asc' aria-hidden='true'></i></span>";
    } else if ($tfild == 'BillMin') {
        $tButtonSortBillMin = "<span style='float: right;''><i class='fa fa-sort-asc' aria-hidden='true'></i></span>";
    } else if ($tfild == 'BillMax') {
        $tButtonSortBillMax = "<span style='float: right;''><i class='fa fa-sort-asc' aria-hidden='true'></i></span>";
    } else if ($tfild == 'BillQty') {
        $tButtonSortBillQty = "<span style='float: right;''><i class='fa fa-sort-asc' aria-hidden='true'></i></span>";
    } else if ($tfild == 'BillAmt') {
        $tButtonSortBillAmt = "<span style='float: right;''><i class='fa fa-sort-asc' aria-hidden='true'></i></span>";
    } else if ($tfild == 'BillChk') {
        $tButtonSortBillChk = "<span style='float: right;''><i class='fa fa-sort-asc' aria-hidden='true'></i></span>";
    } else if ($tfild == 'ISNULL((CONVERT(bigint, RIGHT(BillQty,7))-CONVERT(bigint, RIGHT(BillChk,7))),0)') {
        $tButtonSortBillDiff = "<span style='float: right;''><i class='fa fa-sort-asc' aria-hidden='true'></i></span>";
    }
}
?> <div class="table-responsive ">
    <table id="otbSplDataList" class="table table-striped">
        <thead>
            <tr>
                <th nowarp class="text-center xCNTextBold xWRowSort" onclick="JSvTotalByBranchSort('FTBchName')"><?php echo $aTextLangTotalByBranchShow['tDSHSALModalBranch']; ?><?php echo $tButtonSortFTBchName ?></th>
                <th nowarp class="text-center xCNTextBold xWRowSort" onclick="JSvTotalByBranchSort('FTPosCode')"><?php echo $aTextLangTotalByBranchShow['tDSHSALModalPos']; ?><?php echo $tButtonSortFTPosCode ?></th>
                <th nowarp class="text-center xCNTextBold xWRowSort" onclick="JSvTotalByBranchSort('FDXshDocDate')"><?php echo $aTextLangTotalByBranchShow['tDSHSALDateTBB']; ?><?php echo $tButtonSortFDXshDocDate ?></th>
                <th nowarp class="text-center xCNTextBold xWRowSort" onclick="JSvTotalByBranchSort('FTShfCode')"><?php echo $aTextLangTotalByBranchShow['tDSHSALSalesCycle']; ?><?php echo $tButtonSortFTShfCode ?></th>
                <th nowarp class="text-center xCNTextBold xWRowSort" onclick="JSvTotalByBranchSort('FNXshDocType')"><?php echo $aTextLangTotalByBranchShow['tDSHSALType']; ?><?php echo $tButtonSortFNXshDocType ?></th>
                <th nowarp class="text-center xCNTextBold xWRowSort" onclick="JSvTotalByBranchSort('BillMin')"><?php echo $aTextLangTotalByBranchShow['tDSHSALFromBill']; ?><?php echo $tButtonSortBillMin ?></th>
                <th nowarp class="text-center xCNTextBold xWRowSort" onclick="JSvTotalByBranchSort('BillMax')"><?php echo $aTextLangTotalByBranchShow['tDSHSALToBill']; ?><?php echo $tButtonSortBillMax ?></th>
                <th nowarp class="text-center xCNTextBold xWRowSort" onclick="JSvTotalByBranchSort('BillQty')"><?php echo $aTextLangTotalByBranchShow['tDSHSALQtyBill']; ?><?php echo $tButtonSortBillQty ?></th>
                <!-- <th nowarp class="text-center xCNTextBold xWRowSort" onclick="JSvTotalByBranchSort('BillAmt')"><?php echo $aTextLangTotalByBranchShow['tDSHSALValue']; ?><?php echo $tButtonSortBillAmt ?></th> -->
                <th nowarp class="text-center xCNTextBold xWRowSort" onclick="JSvTotalByBranchSort('BillChk')"><?php echo $aTextLangTotalByBranchShow['tDSHSALCheckOut']; ?><?php echo $tButtonSortBillChk ?></th>
                <th nowarp class="text-center xCNTextBold xWRowSort" onclick="JSvTotalByBranchSort('ISNULL((CONVERT(bigint, RIGHT(BillQty,7))-CONVERT(bigint, RIGHT(BillChk,7))),0)')"><?php echo $aTextLangTotalByBranchShow['tDSHSALDiff']; ?><?php echo $tButtonSortBillDiff ?>
                </th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($aTotalSaleByBranchData['raItems'])) { ?>
                <?php foreach ($aTotalSaleByBranchData['raItems'] as $nKey => $aValue) :
                    // $nDiff =  $aValue['BillQty'] - $aValue['BillChk']
                ?>
                    <tr>
                        <td nowarp><?php echo $aValue['FTBchName'] ?></td>
                        <td nowarp class="text-center"><?php echo $aValue['FTPosCode'] ?></td>
                        <td nowarp class="text-center"><?php echo $aValue['FDXshDocDate'] ?></td>
                        <td nowarp class="text-center"><?php echo $aValue['FTShfCode'] ?></td>
                        <?php
                        if ($aValue['FNXshDocType'] == 1) {
                            $tFNXshDocType = $aTextLangTotalByBranchShow['tDSHSALSale'];
                        } else if ($aValue['FNXshDocType'] == 9) {
                            $tFNXshDocType = $aTextLangTotalByBranchShow['tDSHSALReturn'];
                        }
                        ?>
                        <td nowarp class="text-center"><?php echo $tFNXshDocType ?></td>
                        <td nowarp class="text-center"><?php echo $aValue['BillMin'] ?></td>
                        <td nowarp class="text-center"><?php echo $aValue['BillMax'] ?></td>
                        <td nowarp class="text-right"><?php echo number_format($aValue['BillQty']) ?></td>
                        <!-- <td nowarp class="text-right"><?php echo number_format($aValue['BillAmt'], 2) ?></td> -->
                        <td nowarp class="text-right"><?php echo number_format($aValue['BillChk']) ?></td>
                        <td nowarp class="text-right"><?php echo number_format($aValue['BillDiff']) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php } ?>
        </tbody>
    </table>
</div>


<div class="row">
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        <p><?php echo language('common/main/main', 'tResultTotalRecord') ?> <?php echo $aTotalSaleByBranchData['rnAllRow'] ?> <?php echo language('common/main/main', 'tRecord') ?> <?php echo $aTotalSaleByBranchData['rnCurrentPage'] ?> / <?php echo $aTotalSaleByBranchData['rnAllPage'] ?></p>
    </div>
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        <div class="xWPageTotalByBranch btn-toolbar pull-right">
            <?php if ($nPage == 1) {
                $tDisabledLeft = 'disabled';
            } else {
                $tDisabledLeft = '-';
            } ?>
            <button onclick="JSvSupplierClickPage('previous')" class="btn btn-white btn-sm" <?php echo $tDisabledLeft ?>>
                <i class="fa fa-chevron-left f-s-14 t-plus-1"></i>
            </button>
            <?php for ($i = max($nPage - 2, 1); $i <= max(0, min($aTotalSaleByBranchData['rnAllPage'], $nPage + 2)); $i++) { ?>
                <?php
                if ($nPage == $i) {
                    $tActive = 'active';
                    $tDisPageNumber = 'disabled';
                } else {
                    $tActive = '';
                    $tDisPageNumber = '';
                }
                ?>
                <button onclick="JSvSupplierClickPage('<?php echo $i ?>')" type="button" class="btn xCNBTNNumPagenation <?php echo $tActive ?>" <?php echo $tDisPageNumber ?>><?php echo $i ?></button>
            <?php } ?>
            <?php if ($nPage >= $aTotalSaleByBranchData['rnAllPage']) {
                $tDisabledRight = 'disabled';
            } else {
                $tDisabledRight = '-';
            } ?>
            <button onclick="JSvSupplierClickPage('next')" class="btn btn-white btn-sm" <?php echo $tDisabledRight ?>>
                <i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
            </button>
        </div>
    </div>
</div>




<script>
    //Functionality : เปลี่ยนหน้า pagenation
    //Parameters : Event Click Pagenation
    //Creator : 06/10/2020 Worakorn
    //Return : View
    //Return Type : View
    function JSvSupplierClickPage(ptPage) {
        var nPageCurrent = '';
        switch (ptPage) {
            case 'next': //กดปุ่ม Next
                $('.xWBtnNext').addClass('disabled');
                nPageOld = $('.xWPageTotalByBranch .active').text(); // Get เลขก่อนหน้า
                nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
                nPageCurrent = nPageNew
                break;
            case 'previous': //กดปุ่ม Previous
                nPageOld = $('.xWPageTotalByBranch .active').text(); // Get เลขก่อนหน้า
                nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
                nPageCurrent = nPageNew
                break;
            default:
                nPageCurrent = ptPage
        }

        const ptFSort = '';
        JSvTotalByBranchDataTable(nPageCurrent);
    }
</script>