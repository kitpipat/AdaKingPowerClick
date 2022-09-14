<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th nowrap class="text-center" width="200"><?= language('tool/loghistory','tLGHFilterBch')?></th>
                <th nowrap class="text-center" width="200"><?= language('tool/loghistory','tLGHFilterPos')?></th>
                <th nowrap class="text-center" width="100"><?= language('tool/loghistory','tLGHFilterType')?></th>
                <th nowrap class="text-center" width="120"><?= language('tool/loghistory','tLGHTableDateReq')?></th>
                <th nowrap class="text-center" width="80"><?= language('tool/loghistory','tLGHTableDateFile')?></th>
                <th nowrap class="text-center" width="80"><?= language('tool/loghistory','tLGHFilterStatus')?></th>
                <th nowrap class="text-center"><?= language('tool/loghistory','tLGHTableLogRnk')?></th>
                <th nowrap class="text-center" width="140"><?= language('tool/loghistory','tLGHTableDownload')?></th>
            </tr>
        </thead>
        <tbody>
            <?php if ( isset($aLGHDataList['aItems']) ){ ?>
                <?php foreach ($aLGHDataList['aItems'] as $nKey => $aValue) { ?>
                <tr>
                    <td nowrap class="text-left" style="vertical-align: middle;"><?=$aValue['FTBchName']?></td>
                    <td nowrap class="text-left" style="vertical-align: middle;"><?=$aValue['FTPosName']?></td>
                    <td nowrap class="text-center" style="vertical-align: middle;">
                        <?php
                            switch($aValue['FTLogType']){
                                case '1':
                                    echo language('tool/loghistory', 'tLGHFilterType1');
                                    break;
                                case '2':
                                    echo language('tool/loghistory', 'tLGHFilterType2');
                                    break;
                            }
                        ?>
                    </td>
                    <td nowrap class="text-center" style="vertical-align: middle;"><?=date_format(new DateTime($aValue['FDLogDateReq']),"d/m/Y H:i")?></td>
                    <td nowrap class="text-center" style="vertical-align: middle;"><?=date_format(new DateTime($aValue['FDLogFileDate']),"d/m/Y")?></td>
                    <td nowrap class="text-center" style="vertical-align: middle;">
                        <?php
                            switch($aValue['FTLogStatus']){
                                case '1':
                                    echo '<lable class="xCNTDTextStatus text-success">'.language('tool/loghistory', 'tLGHFilterStatus1').'</lable>';
                                    break;
                                case '2':
                                    echo '<lable class="xCNTDTextStatus text-danger">'.language('tool/loghistory', 'tLGHFilterStatus2').'</lable>';
                                    break;
                            }
                        ?>
                    </td>
                    <td nowrap class="text-left" style="vertical-align: middle;"><?=$aValue['FTLogRmk']?></td>
                    <td nowrap class="text-center" style="vertical-align: middle;">
                        <?php if( $aValue['FTLogStatus'] == '1' && substr($aValue['FTLogUrlFile'],0,4) == 'http' ){ ?>
                            <!-- <a href="<?=base_url('application\modules\tool\views\loghistory\wLogHistoryDownload.php?ptFile='.base64_encode($aValue['FTLogUrlFile']))?>"> -->
                            <a href="<?=$aValue['FTLogUrlFile']?>">
                                <button type="button" class="btn btn-primary"><?php echo language('tool/loghistory', 'tLGHBtnDownload'); ?></button>
                            </a>
                        <?php }else{ ?>
                            <button type="button" class="btn btn-primary" disabled><?php echo language('tool/loghistory', 'tLGHBtnDownload'); ?></button>
                        <?php } ?>
                    </td>
                </tr>
                <?php } ?>
            <?php } else { ?>
                <tr>
                    <td colspan="100%" class="text-center"><?php echo language('bank/bank/bank','tBnkNoData'); ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<div class="row">
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
        <p><?php echo language('common/main/main','tResultTotalRecord')?> <?php echo $aLGHDataList['nAllRow']?> <?php echo language('common/main/main','tRecord')?> <?php echo language('common/main/main','tCurrentPage')?> <?php echo $aLGHDataList['nCurrentPage']?> / <?php echo $aLGHDataList['nAllPage']?></p>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
        <div class="xWLGHPageDataTable btn-toolbar pull-right">
            <?php if($nPage == 1){ $tDisabledLeft = 'disabled'; }else{ $tDisabledLeft = '-';} ?>
            <button onclick="JSvLGHClickPageList('previous')" class="btn btn-white btn-sm" <?php echo $tDisabledLeft ?>>
                <i class="fa fa-chevron-left f-s-14 t-plus-1"></i>
            </button>

            <?php for($i=max($nPage-2, 1); $i<=max(0, min($aLGHDataList['nAllPage'],$nPage+2)); $i++){?>
                <?php 
                    if($nPage == $i){ 
                        $tActive = 'active'; 
                        $tDisPageNumber = 'disabled';
                    }else{ 
                        $tActive = '';
                        $tDisPageNumber = '';
                    }
                ?>
                <button onclick="JSvLGHClickPageList('<?php echo $i?>')" type="button" class="btn xCNBTNNumPagenation <?php echo $tActive ?>" <?php echo $tDisPageNumber ?>><?php echo $i?></button>
            <?php } ?>

            <?php if($nPage >= $aLGHDataList['nAllPage']){  $tDisabledRight = 'disabled'; }else{  $tDisabledRight = '-';  } ?>
            <button onclick="JSvLGHClickPageList('next')" class="btn btn-white btn-sm" <?php echo $tDisabledRight ?>>
                <i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
            </button>
        </div>
    </div>
</div>