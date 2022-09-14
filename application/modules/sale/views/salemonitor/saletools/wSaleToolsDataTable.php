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
$tButtonSortSignIn = "<span style='float: right;''><i class='fa fa-sort-desc' aria-hidden='true'></i></span>";
$tButtonSortSignOut = "<span style='float: right;''><i class='fa fa-sort-desc' aria-hidden='true'></i></span>";
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
    } else if ($tfild == 'FDShdSignIn') {
        $tButtonSortSignIn = "<span style='float: right;''><i class='fa fa-sort-asc' aria-hidden='true'></i></span>";
    } else if ($tfild == 'FDShdSignOut') {
        $tButtonSortSignOut = "<span style='float: right;''><i class='fa fa-sort-asc' aria-hidden='true'></i></span>";
    } else if ($tfild == 'BillQty') {
        $tButtonSortBillQty = "<span style='float: right;''><i class='fa fa-sort-asc' aria-hidden='true'></i></span>";
    } else if ($tfild == 'BillAmt') {
        $tButtonSortBillAmt = "<span style='float: right;''><i class='fa fa-sort-asc' aria-hidden='true'></i></span>";
    } else if ($tfild == 'FNShdQtyBill') {
        $tButtonSortBillChk = "<span style='float: right;''><i class='fa fa-sort-asc' aria-hidden='true'></i></span>";
    } else if ($tfild == 'BillDiff') {
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
    } else if ($tfild == 'FDShdSignIn') {
        $tButtonSortSignIn = "<span style='float: right;''><i class='fa fa-sort-asc' aria-hidden='true'></i></span>";
    } else if ($tfild == 'FDShdSignOut') {
        $tButtonSortSignOut = "<span style='float: right;''><i class='fa fa-sort-asc' aria-hidden='true'></i></span>";
    } else if ($tfild == 'BillQty') {
        $tButtonSortBillQty = "<span style='float: right;''><i class='fa fa-sort-asc' aria-hidden='true'></i></span>";
    } else if ($tfild == 'BillAmt') {
        $tButtonSortBillAmt = "<span style='float: right;''><i class='fa fa-sort-asc' aria-hidden='true'></i></span>";
    } else if ($tfild == 'FNShdQtyBill') {
        $tButtonSortBillChk = "<span style='float: right;''><i class='fa fa-sort-asc' aria-hidden='true'></i></span>";
    } else if ($tfild == 'BillDiff') {
        $tButtonSortBillDiff = "<span style='float: right;''><i class='fa fa-sort-asc' aria-hidden='true'></i></span>";
    }
}
?> <div class="table-responsive ">
    <table id="otbSplDataList" class="table table-striped">
        <thead>
            <tr>
                 <th nowarp class="text-center xCNTextBold ">     
                      <label class="fancy-checkbox ">
                        <input type="checkbox" class="" id="ocbSTLListItemAll" name="ocbSTLListItemAll">
                        <span class="">&nbsp;</span>
                    </label> 
                    </th>
                <th nowarp class="text-center xCNTextBold xWRowSort" onclick="JSvSTLTotalByBranchSort('FTBchName')"><?php echo $aTextLangTotalByBranchShow['tDSHSALModalBranch']; ?><?php echo $tButtonSortFTBchName ?></th>
                <th nowarp class="text-center xCNTextBold xWRowSort" onclick="JSvSTLTotalByBranchSort('FTPosCode')"><?php echo $aTextLangTotalByBranchShow['tDSHSALModalPos']; ?><?php echo $tButtonSortFTPosCode ?></th>
                <th nowarp class="text-center xCNTextBold xWRowSort" onclick="JSvSTLTotalByBranchSort('FDShdSaleDate')"><?php echo $aTextLangTotalByBranchShow['tDSHSALDateTBB']; ?><?php echo $tButtonSortFDXshDocDate ?></th>
                <th nowarp class="text-center xCNTextBold xWRowSort" onclick="JSvSTLTotalByBranchSort('FTShfCode')"><?php echo $aTextLangTotalByBranchShow['tDSHSALSalesCycle']; ?><?php echo $tButtonSortFTShfCode ?></th>
                <th nowarp class="text-center xCNTextBold xWRowSort" onclick="JSvSTLTotalByBranchSort('FDShdSignIn')"><?php echo $aTextLangTotalByBranchShow['tSMTSign-in']; ?><?php echo $tButtonSortSignIn ?>
                <th nowarp class="text-center xCNTextBold xWRowSort" onclick="JSvSTLTotalByBranchSort('FDShdSignOut')"><?php echo $aTextLangTotalByBranchShow['tSMTSign-out']; ?><?php echo $tButtonSortSignOut ?>
                <th nowarp class="text-center xCNTextBold xWRowSort" onclick="JSvSTLTotalByBranchSort('BillQty')"><?php echo $aTextLangTotalByBranchShow['tDSHSALQtyBill']; ?><?php echo $tButtonSortBillQty ?></th>
               
                <th nowarp class="text-center xCNTextBold xWRowSort" onclick="JSvSTLTotalByBranchSort('FNShdQtyBill')"><?php echo $aTextLangTotalByBranchShow['tDSHSALCheckOut']; ?><?php echo $tButtonSortBillChk ?></th>
                <th nowarp class="text-center xCNTextBold xWRowSort" onclick="JSvSTLTotalByBranchSort('BillDiff')"><?php echo $aTextLangTotalByBranchShow['tDSHSALDiff']; ?><?php echo $tButtonSortBillDiff ?>
                </th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($aTotalSaleByBranchData['raItems'])) { ?>
                <?php foreach ($aTotalSaleByBranchData['raItems'] as $nKey => $aValue) :
                    // $nDiff =  $aValue['BillQty'] - $aValue['BillChk']
                ?>
                    <tr>   
                    <td nowarp  class="text-center">
                            <label class="fancy-checkbox ">
                              <input  type="checkbox" class="ocbSTLListItem" name="ocbSTLListItem[]"  data-routing="<?php echo $aValue['FTBchCode'].$aValue['FTPosCode'] ?>" value="<?php echo $aValue['FTShfCode'] ?>">
                                 <span class="">&nbsp;</span>
                            </label>
                        </td>
                        <td nowarp><?php echo $aValue['FTBchName'] ?></td>
                        <td nowarp class="text-center"><?php echo $aValue['FTPosCode'] ?></td>
                        <td nowarp class="text-center"><?php echo $aValue['FDShdSaleDate'] ?></td>
                        <td nowarp class="text-center"><?php echo $aValue['FTShfCode'] ?></td>
                        <td nowarp class="text-center"><?php echo $aValue['FDShdSignIn'] ?></td>
                        <td nowarp class="text-center"><?php echo $aValue['FDShdSignOut'] ?></td>
                        <td nowarp class="text-right"><?php echo number_format($aValue['BillQty']) ?></td>
                        <td nowarp class="text-right"><?php echo number_format($aValue['FNShdQtyBill']) ?></td>
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
            <button onclick="JSvSaleToolsClickPage('previous')" class="btn btn-white btn-sm" <?php echo $tDisabledLeft ?>>
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
                <button onclick="JSvSaleToolsClickPage('<?php echo $i ?>')" type="button" class="btn xCNBTNNumPagenation <?php echo $tActive ?>" <?php echo $tDisPageNumber ?>><?php echo $i ?></button>
            <?php } ?>
            <?php if ($nPage >= $aTotalSaleByBranchData['rnAllPage']) {
                $tDisabledRight = 'disabled';
            } else {
                $tDisabledRight = '-';
            } ?>
            <button onclick="JSvSaleToolsClickPage('next')" class="btn btn-white btn-sm" <?php echo $tDisabledRight ?>>
                <i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
            </button>
        </div>
    </div>
</div>

<script type="text/javascript">

//Functionality : เปลี่ยนหน้า pagenation
    //Parameters : Event Click Pagenation
    //Creator : 06/10/2020 Worakorn
    //Return : View
    //Return Type : View
    function JSvSaleToolsClickPage(ptPage) {
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
        JCNxSTLCallDataTable(nPageCurrent);
    }


    $('#ocbSTLListItemAll').click(function(){
            if($(this).prop('checked')==true){
                $('.ocbSTLListItem').prop('checked',true);
            }else{
                $('.ocbSTLListItem').prop('checked',false);
            }
    });


</script>