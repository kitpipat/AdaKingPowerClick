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
                        <th nowrap class="xCNTextBold"><?= language('document/checkstatussale/checkstatussale', 'tCSSBranch') ?></th>
                        <th nowrap class="xCNTextBold"><?= language('document/checkstatussale/checkstatussale', 'tCSSApp') ?></th>
                        <th nowrap class="xCNTextBold"><?= language('document/checkstatussale/checkstatussale', 'tCSSDocNo') ?></th>
                        <th nowrap class="xCNTextBold"><?= language('document/checkstatussale/checkstatussale', 'เลขที่อ้างอิงเอกสารภายนอก') ?></th>
                        <th nowrap class="xCNTextBold"><?= language('document/checkstatussale/checkstatussale', 'tCSSDocDate') ?></th>
                        <th nowrap class="xCNTextBold"><?= language('document/checkstatussale/checkstatussale', 'tCSSCustomer') ?></th>
                        <th nowrap class="xCNTextBold"><?= language('document/checkstatussale/checkstatussale', 'tCSSChannel') ?></th>
                        <th nowrap class="xCNTextBold"><?= language('document/checkstatussale/checkstatussale', 'tCSSStaApv') ?></th>
                        <th nowrap class="xCNTextBold"><?= language('document/checkstatussale/checkstatussale', 'สถานะดาวน์โหลดอย่างย่อ') ?></th>
                        <th nowrap class="xCNTextBold"><?= language('document/checkstatussale/checkstatussale', 'tCSSUsrApv') ?></th>

                        <?php if ($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaRead'] == 1) : ?>
                            <th nowrap class="xCNTextBold"><?= language('document/checkstatussale/checkstatussale', 'tCSSManage') ?></th>
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
                                    <td nowrap class="text-left"><?php echo (!empty($aValue['FTAppName'])) ? $aValue['FTAppName'] : '-' ?></td>
                                    <td nowrap class="text-left"><?php echo (!empty($aValue['FTXshDocNo'])) ? $aValue['FTXshDocNo'] : '-' ?></td>
                                    <td nowrap class="text-left"><?php echo (!empty($aValue['FTXshRefExt'])) ? $aValue['FTXshRefExt'] : '-' ?></td>
                                    <td nowrap class="text-center"><?php echo date_format(date_create($aValue['FDXshDocDate']),'d/m/Y'); ?></td>
                                    <td nowrap class="text-left"><?php echo (!empty($aValue['FTCstName'])) ? $aValue['FTCstName'] : language('document/document/document', 'tDocRegularCustomers') ?></td> 
                                    <td nowrap class="text-left"><?php echo (!empty($aValue['FTChnName'])) ? $aValue['FTChnName'] : '-' ?></td> <!--language('document/checkstatussale/checkstatussale', 'tCSSDocAct'.$aValue['FNXshStaDocAct']);-->
                                    <td nowrap class="text-left">
                                        <?php //1:รออนุมัติ 2:รอจัดสินค้า 3:รอจัดส่ง 4:ยืนยันจัดส่ง
                                            switch($aValue['FTXshStaPrcDoc']){
                                                case '7':
                                                    $tDivClass  = "xWCSSYellowBG";
                                                    $tSpanClass = "xWCSSYellowColor";
                                                    $tLabel     = "รอสร้างใบส่ง";
                                                    break;
                                                case '6':
                                                    $tDivClass  = "xWCSSRedBG";
                                                    $tSpanClass = "xWCSSRedColor";
                                                    $tLabel     = "ลูกค้าแจ้งยกเลิก";
                                                    break;
                                                case '5':
                                                    $tDivClass  = "xWCSSGreenBG";
                                                    $tSpanClass = "xWCSSGreenColor";
                                                    $tLabel     = "ยืนยันจัดส่ง";
                                                    break;
                                                case '4':
                                                    $tDivClass  = "xWCSSYellowBG";
                                                    $tSpanClass = "xWCSSYellowColor";
                                                    $tLabel     = "รอลูกค้ามารับ";
                                                    break;
                                                case '3':
                                                    $tDivClass  = "xWCSSYellowBG";
                                                    $tSpanClass = "xWCSSYellowColor";
                                                    $tLabel     = "รอจัดส่ง";
                                                    break;
                                                case '2':
                                                    $tDivClass  = "xWCSSYellowBG";
                                                    $tSpanClass = "xWCSSYellowColor";
                                                    $tLabel     = "รอจัดสินค้า";
                                                    break;
                                                default:
                                                    $tDivClass  = "xWCSSGrayBG";
                                                    $tSpanClass = "xWCSSGrayColor";
                                                    $tLabel     = "รอสร้างใบจัด";
                                            }
                                            echo '<div class="xWCSSDotStatus '.$tDivClass.'"></div> <span class="xWSCCStatusColor '.$tSpanClass.'">'.$tLabel.'</span>';
                                        ?>
                                    </td>
                                    <td nowrap class="text-left">
                                        <?php //พร้อมดาวน์โหลด E-Tax 2. ตรวจสอบสถานะ E-Tax 3. รออนุมัติ/ไม่สำเร็จ
                                            switch($aValue['FTXshETaxStatus']){
                                                case '1':
                                                    $tDivClass  = "xWCSSGreenBG";
                                                    $tSpanClass = "xWCSSGreenColor";
                                                    $tLabel     = "พร้อมดาวน์โหลด E-Tax";
                                                    break;
                                                case '2':
                                                    $tDivClass  = "xWCSSYellowBG";
                                                    $tSpanClass = "xWCSSYellowColor";
                                                    $tLabel     = "ตรวจสอบสถานะ E-Tax";
                                                    break;
                                                default:
                                                    $tDivClass  = "xWCSSGrayBG";
                                                    $tSpanClass = "xWCSSGrayColor";
                                                    $tLabel     = "รออนุมัติ";
                                            }
                                            echo '<div class="xWCSSDotStatus '.$tDivClass.'"></div> <span class="xWSCCStatusColor '.$tSpanClass.'">'.$tLabel.'</span>';
                                        ?>
                                    </td>
                                    <td nowrap class="text-left"><?php echo (!empty($aValue['FTXshApvName'])) ? $aValue['FTXshApvName'] : '-' ?></td>

                                    <?php if ($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaRead'] == 1) : ?>
                                        <td nowrap>
                                            <?php if ( $aValue['FTXshStaPrcDoc'] == '5' || $aValue['FTXshStaPrcDoc'] == '6' ) { ?>
                                                <img class="xCNIconTable" style="width: 17px;" src="<?= base_url() . '/application/modules/common/assets/images/icons/view2.png' ?>" onClick="JSxCSSPageEdit('<?= $aValue['FTXshDocNo'] ?>')">
                                            <?php } else { ?>
                                                <img class="xCNIconTable" src="<?= base_url() . '/application/modules/common/assets/images/icons/edit.png' ?>" onClick="JSxCSSPageEdit('<?= $aValue['FTXshDocNo'] ?>')">
                                            <?php } ?>
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
        <div class="xWPageCSSPdt btn-toolbar pull-right">
            <?php if ($nPage == 1) {
                $tDisabledLeft = 'disabled';
            } else {
                $tDisabledLeft = '-';
            } ?>
            <button onclick="JSxCSSEventClickPage('previous')" class="btn btn-white btn-sm" <?php echo $tDisabledLeft ?>>
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
                <button onclick="JSxCSSEventClickPage('<?php echo $i ?>')" type="button" class="btn xCNBTNNumPagenation <?php echo $tActive ?>" <?php echo $tDisPageNumber ?>><?php echo $i ?></button>
            <?php } ?>

            <?php if ($nPage >= $aDataList['nAllPage']) {
                $tDisabledRight = 'disabled';
            } else {
                $tDisabledRight = '-';
            } ?>
            <button onclick="JSxCSSEventClickPage('next')" class="btn btn-white btn-sm" <?php echo $tDisabledRight ?>>
                <i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
            </button>
        </div>
    </div>
</div>