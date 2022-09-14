<input id="oetPCPPdtForSys" type="hidden" value="<?php echo $tPdtForSys;?>">
<input id="oetPCPPage" type="hidden" value="<?php echo $nPage;?>">
<input type="hidden" id="ohdPCPProductAllRow" name="ohdProductAllRow" value="<?=$aDataList['rnAllRow']?>">
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div id="odvPCPDataTableProduct" class="table-responsive">
            <table id="otbPCPCheckPriceTable" class="table" border="1" cellspacing="0">
                <thead>
                    <tr>
                        <?php if($tDisplayType == '2'){ echo "<th class='text-center'>".language('product/pdtcheckprice/pdtcheckprice', 'tPCPPplName')."</th>"; } ?>
                        <th class="text-center"><?php echo language('product/pdtcheckprice/pdtcheckprice', 'tPCPPdtCode'); ?></th>
                        <th class="text-center"><?php echo language('product/pdtcheckprice/pdtcheckprice', 'tPCPPdtName'); ?></th>
                        <th class="text-center"><?php echo language('product/pdtcheckprice/pdtcheckprice', 'tPCPPdtUnit'); ?></th>
                        <th class="text-center"><?php echo language('product/pdtcheckprice/pdtcheckprice', 'ประเภทราคา'); ?></th>
                        <th class="text-center"><?php echo language('product/pdtcheckprice/pdtcheckprice', 'tPCPPdtDateStart'); ?></th>
                        <th class="text-center"><?php echo language('product/pdtcheckprice/pdtcheckprice', 'tPCPPdtDateStop'); ?></th>
                        <th class="text-center"><?php echo language('product/pdtcheckprice/pdtcheckprice', 'tPCPPdtTimeStart'); ?></th>
                        <th class="text-center"><?php echo language('product/pdtcheckprice/pdtcheckprice', 'tPCPPdtTimeStop'); ?></th>
                        <th class="text-center"><?php echo language('product/pdtcheckprice/pdtcheckprice', 'tPCPPdtDocNo'); ?></th>
                        <th class="text-center"><?php echo language('product/pdtcheckprice/pdtcheckprice', 'tPCPPdtPrice'); ?></th>
                        <?php if($tDisplayType == '1'){ echo "<th class='text-center'>".language('product/pdtcheckprice/pdtcheckprice', 'tPCPPplName')."</th>"; } ?>
                    </tr>
                </thead>
                <tbody>
                    <?php if($aDataList['rtCode'] == '1'){ ?>
                    <?php foreach($aDataList['raItems'] AS $key => $aValue): ?>
                        <?php 
                            if($aValue['FTPplName'] == NULL ||$aValue['FTPplName'] == ''){
                                $FTPplName = language('product/pdtcheckprice/pdtcheckprice', 'tPCPPplNameAll');;
                            }else{
                                $FTPplName = $aValue['FTPplName'];
                            }
                        ?>
                    <tr>
                        <?php if($tDisplayType == '2'){ echo "<td>".$FTPplName."</td>"; } ?>
                        <td><?php echo $aValue['FTPdtCode'];?></td>
                        <td><?php echo $aValue['FTPdtName'];?></td>
                        <td><?php echo $aValue['FTPunName'];?></td>
                        <td><?php if( $aValue['FTXphDocType'] == '1' ){ echo "BasePrice"; }else{ echo "Price Off"; } ?></td>
                        <td class="text-center"><?php echo $aValue['FDXphDStart'];?></td>
                        <td class="text-center"><?php echo $aValue['FDXphDStop'];?></td>
                        <td class="text-center"><?php echo $aValue['FTXphTStart'];?></td>
                        <td class="text-center"><?php echo $aValue['FTXphTStop'];?></td>
                        <td><?php echo $aValue['FTXphDocNo'];?></td>
                        <td class="text-right"><?php  echo number_format($aValue['FCXpdPriceRet'],$nOptDecimalShow);?></td>
                        <?php if($tDisplayType == '1'){ echo "<td>".$FTPplName."</td>"; } ?>
                    </tr>
                    <?php endforeach;?>
                    <?php }else{?>
                    <tr>
                        <td class='text-center xCNTextDetail2' colspan='12'>
                            <?php echo language('common/main/main','tCMNNotFoundData')?></td>
                    </tr>
                    <?php } ?>
                    <tr class="hidden">
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
        <p><?php echo language('common/main/main','tResultTotalRecord')?> <?php echo $aDataList['rnAllRow']?>
            <?php echo language('common/main/main','tRecord')?> <?php echo language('common/main/main','tCurrentPage')?>
            <?php echo $aDataList['rnCurrentPage']?> / <?php echo $aDataList['rnAllPage']?></p>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
        <div class="xWPIPageDataTable btn-toolbar pull-right">
            <?php if($nPage == 1){ $tDisabledLeft = 'disabled'; }else{ $tDisabledLeft = '-';} ?>
            <button onclick="JSxPCPClickPageList('previous')" class="btn btn-white btn-sm" <?php echo $tDisabledLeft ?>>
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
            <button onclick="JSxPCPClickPageList('<?php echo $i?>')" type="button"
                class="btn xCNBTNNumPagenation <?php echo $tActive ?>"
                <?php echo $tDisPageNumber ?>><?php echo $i?></button>
            <?php } ?>

            <?php if($nPage >= $aDataList['rnAllPage']){  $tDisabledRight = 'disabled'; }else{  $tDisabledRight = '-';  } ?>
            <button onclick="JSxPCPClickPageList('next')" class="btn btn-white btn-sm" <?php echo $tDisabledRight ?>>
                <i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
            </button>
        </div>
    </div>
</div>

