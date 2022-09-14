<?php
    if ( $aDataList['tCode'] == '1' ) {
        $nCurrentPage = $aDataList['nCurrentPage'];
    } else {
        $nCurrentPage = '1';
    }
?>

<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr class="xCNCenter">
                        <th nowrap class="xCNTextBold"><?= language('document/document/document', 'tDocNumber') ?></th>
                        <th nowrap class="xCNTextBold"><?= language('document/abbsalerefund/abbsalerefund', 'tABBBranch') ?></th>
                        <th nowrap class="xCNTextBold"><?= language('document/abbsalerefund/abbsalerefund', 'tABBDocType') ?></th>
                        <th nowrap class="xCNTextBold"><?= language('document/abbsalerefund/abbsalerefund', 'tABBApp') ?></th>
                        <th nowrap class="xCNTextBold"><?= language('document/abbsalerefund/abbsalerefund', 'tABBDocNo') ?></th>
                        <th nowrap class="xCNTextBold"><?= language('document/abbsalerefund/abbsalerefund', 'tABBDocDate') ?></th>
                        <th nowrap class="xCNTextBold"><?= language('document/abbsalerefund/abbsalerefund', 'tABBCustomer') ?></th>
                        <th nowrap class="xCNTextBold"><?= language('document/abbsalerefund/abbsalerefund', 'tABBChannel') ?></th>
                        <th nowrap class="xCNTextBold"><?= language('document/abbsalerefund/abbsalerefund', 'tABBStaApv') ?></th>
                        <th nowrap class="xCNTextBold"><?= language('document/checkstatussale/checkstatussale', 'tABBTBStaDownloadABB') ?></th>
                        <th nowrap class="xCNTextBold"><?= language('document/abbsalerefund/abbsalerefund', 'tABBUsrApv') ?></th>

                        <?php if ($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaRead'] == 1) : ?>
                            <th nowrap class="xCNTextBold"><?= language('document/abbsalerefund/abbsalerefund', 'tABBManage') ?></th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody id="odvRGPList">
                <?php 
                    if ($aDataList['tCode'] == 1) : 
                        if ( FCNnHSizeOf($aDataList['aItems']) > 0 ){
                            foreach ($aDataList['aItems'] as $nKey => $aValue) : 
                ?>
                                <tr class="text-center xCNTextDetail2">
                                    <td nowrap class="text-center"><?php echo $aValue['FNRowID']; ?></td>
                                    <td nowrap class="text-left"><?php echo (!empty($aValue['FTBchName'])) ? $aValue['FTBchName'] : '-' ?></td>
                                    <td nowrap class="text-left"><?php echo language('document/document/document', 'tABBDocType'.$aValue['FNXshDocType']); ?></td>
                                    <td nowrap class="text-left"><?php echo (!empty($aValue['FTAppName'])) ? $aValue['FTAppName'] : '-' ?></td>
                                    <td nowrap class="text-left"><?php echo (!empty($aValue['FTXshDocNo'])) ? $aValue['FTXshDocNo'] : '-' ?></td>
                                    <td nowrap class="text-center"><?php echo date_format(date_create($aValue['FDXshDocDate']),'d/m/Y'); ?></td>
                                    <td nowrap class="text-left"><?php echo (!empty($aValue['FTCstName'])) ? $aValue['FTCstName'] : language('document/document/document', 'tDocRegularCustomers') ?></td> 
                                    <td nowrap class="text-left"><?php echo (!empty($aValue['FTChnName'])) ? $aValue['FTChnName'] : '-' ?></td>
                                    <td nowrap class="text-left">
                                        <?php
                                            // switch($aValue['FTXshStaApv']){
                                            //     case '1':
                                            //         $tXshStaApvName = '<div class="xWABBDotStatus xWABBGreenBG"></div> <span class="xWSCCStatusColor xWABBGreenColor">'.language('document/document/document', 'tDocStaProApv1').'</span>'; 
                                            //         break;
                                            //     default:
                                            //         $tXshStaApvName = '<div class="xWABBDotStatus xWABBYellowBG"></div> <span class="xWSCCStatusColor xWABBYellowColor">'.language('document/abbsalerefund/abbsalerefund', 'tABBStaApv2').'</span>';
                                            // }
                                            // echo $tXshStaApvName;
                                        ?>
                                        <?php
                                            if( $aValue['FTXshStaPrcDoc'] == '5' ){
                                                $tDivClass  = "xWABBGreenBG";
                                                $tSpanClass = "xWABBGreenColor";
                                                $tLabel     = "อนุมัติแล้ว";
                                            }else{
                                                $tDivClass  = "xWABBGrayBG";
                                                $tSpanClass = "xWABBGrayColor";
                                                $tLabel     = "ยังไม่อนุมัติ";
                                            }
                                            // switch($aValue['FTXshStaPrcDoc']){
                                            //     case '5':
                                            //         $tDivClass  = "xWABBGreenBG";
                                            //         $tSpanClass = "xWABBGreenColor";
                                            //         $tLabel     = "ยืนยันจัดส่ง";
                                            //         break;
                                            //     case '4':
                                            //         $tDivClass  = "xWABBYellowBG";
                                            //         $tSpanClass = "xWABBYellowColor";
                                            //         $tLabel     = "รอลูกค้ามารับ";
                                            //         break;
                                            //     case '3':
                                            //         $tDivClass  = "xWABBYellowBG";
                                            //         $tSpanClass = "xWABBYellowColor";
                                            //         $tLabel     = "รอจัดส่ง";
                                            //         break;
                                            //     case '2':
                                            //         $tDivClass  = "xWABBYellowBG";
                                            //         $tSpanClass = "xWABBYellowColor";
                                            //         $tLabel     = "สร้างใบจัด";
                                            //         break;
                                            //     default:
                                            //         $tDivClass  = "xWABBGrayBG";
                                            //         $tSpanClass = "xWABBGrayColor";
                                            //         $tLabel     = "รอจัดสินค้า";
                                            // }
                                            echo '<div class="xWABBDotStatus '.$tDivClass.'"></div> <span class="xWABBStatusColor '.$tSpanClass.'">'.$tLabel.'</span>';
                                        ?>
                                    </td>
                                    <td nowrap class="text-left">
                                        <?php //พร้อมดาวน์โหลด E-Tax 2. ตรวจสอบสถานะ E-Tax 3. รออนุมัติ/ไม่สำเร็จ
                                            switch($aValue['FTXshETaxStatus']){
                                                case '1':
                                                    $tDivClass  = "xWABBGreenBG";
                                                    $tSpanClass = "xWABBGreenColor";
                                                    $tLabel     = "พร้อมดาวน์โหลด E-Tax";
                                                    break;
                                                case '2':
                                                    $tDivClass  = "xWABBYellowBG";
                                                    $tSpanClass = "xWABBYellowColor";
                                                    $tLabel     = "ตรวจสอบสถานะ E-Tax";
                                                    break;
                                                default:
                                                    $tDivClass  = "xWABBGrayBG";
                                                    $tSpanClass = "xWABBGrayColor";
                                                    $tLabel     = "รออนุมัติ";
                                            }
                                            echo '<div class="xWABBDotStatus '.$tDivClass.'"></div> <span class="xWABBStatusColor '.$tSpanClass.'">'.$tLabel.'</span>';
                                        ?>
                                    </td>
                                    <td nowrap class="text-left"><?php echo (!empty($aValue['FTXshApvName'])) ? $aValue['FTXshApvName'] : '-' ?></td>

                                    <?php if ($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaRead'] == 1) : ?>
                                        <td nowrap>
                                            <img class="xCNIconTable" style="width: 17px;" src="<?= base_url() . '/application/modules/common/assets/images/icons/view2.png' ?>" onClick="JSxABBPageEdit('<?= $aValue['FTXshDocNo'] ?>')">
                                        </td>
                                    <?php endif; ?>

                                </tr>
                            <?php endforeach;
                        } else { ?>
                            <tr>
                                <td nowrap class='text-center xCNTextDetail2' colspan='100%'><?php echo language('common/main/main', 'tCMNNotFoundData') ?></td>
                            </tr>
                        <?php } ?>
                    <?php else : ?>
                        <tr>
                            <td nowrap class='text-center xCNTextDetail2' colspan='100%'><?php echo language('common/main/main', 'tCMNNotFoundData') ?></td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
        <p><?php echo language('common/main/main', 'tResultTotalRecord') ?> <?php echo $aDataList['nAllRow'] ?> <?php echo language('common/main/main', 'tRecord') ?> <?php echo language('common/main/main', 'tCurrentPage') ?> <?php echo $aDataList['nCurrentPage'] ?> / <?php echo $aDataList['nAllPage'] ?></p>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
        <div class="xWPageABBPdt btn-toolbar pull-right">
            <?php if ($nPage == 1) {
                $tDisabledLeft = 'disabled';
            } else {
                $tDisabledLeft = '-';
            } ?>
            <button onclick="JSxABBEventClickPage('previous')" class="btn btn-white btn-sm" <?php echo $tDisabledLeft ?>>
                <i class="fa fa-chevron-left f-s-14 t-plus-1"></i>
            </button>

            <?php for ($i = max($nPage - 2, 1); $i <= max(0, min($aDataList['nAllPage'], $nPage + 2)); $i++) { ?>
                <?php
                if ($nPage == $i) {
                    $tActive = 'active';
                    $tDisPageNumber = 'disabled';
                } else {
                    $tActive = '';
                    $tDisPageNumber = '';
                }
                ?>
                <button onclick="JSxABBEventClickPage('<?php echo $i ?>')" type="button" class="btn xCNBTNNumPagenation <?php echo $tActive ?>" <?php echo $tDisPageNumber ?>><?php echo $i ?></button>
            <?php } ?>

            <?php if ($nPage >= $aDataList['nAllPage']) {
                $tDisabledRight = 'disabled';
            } else {
                $tDisabledRight = '-';
            } ?>
            <button onclick="JSxABBEventClickPage('next')" class="btn btn-white btn-sm" <?php echo $tDisabledRight ?>>
                <i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
            </button>
        </div>
    </div>
</div>