<?php
    if($aDataList['rtCode'] == '1'){
        $nCurrentPage   = $aDataList['rnCurrentPage'];
    }else{
        $nCurrentPage   = '1';
    }
?>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="table-responsive">
            <table id="otbTCGTblDataDocHDList" class="table table-striped">
                <thead>
                    <tr class="xCNCenter">
                        <?php if($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaDelete'] == 1) : ?>
                            <th nowrap class="xCNTextBold" style="width:5%;"><?php echo @$aTextLang['tTCGTBChoose'];?></th>
                        <?php endif; ?>
                        <th nowrap class="xCNTextBold" style="width:10%;text-align:center;"><?php echo $aTextLang['tTCGLogo'];?></th>
                        <th nowrap class="xCNTextBold" style="width:10%;"><?php echo @$aTextLang['tTCGTBCode'];?></th>
                        <th nowrap class="xCNTextBold"><?php echo @$aTextLang['tTCGTBName'];?></th>
                        <th nowrap class="xCNTextBold" style="width:10%;"><?php echo @$aTextLang['tTCGTBStatus'];?></th>
                        <?php if($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaDelete'] == 1) : ?>
                            <th nowrap class="xCNTextBold" style="width:5%;"><?php echo @$aTextLang['tCMNActionDelete'];?></th>
                        <?php endif; ?>
                        <?php if($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaRead'] == 1 || $aAlwEvent['tAutStaEdit'] == 1) : ?>
                            <th nowrap class="xCNTextBold" style="width:5%;"><?php echo @$aTextLang['tCMNActionEdit'];?></th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php if($aDataList['rtCode'] == 1 ): ?>
                        <?php foreach($aDataList['raItems'] AS $nKey => $aValue): ?>
                            <?php
                                // Status Use
                                $tTextStatusUse     = '';
                                $tClassStatusUse    = '';
                                if($aValue['FTTcgStaUse'] == 1){
                                    $tTextStatusUse     = $aTextLang['tTCGTBStatus1'];
                                    $tClassStatusUse    = 'text-success';
                                }else if($aValue['FTTcgStaUse'] == 2){
                                    $tTextStatusUse = $aTextLang['tTCGTBStatus2'];
                                    $tClassStatusUse    = 'text-danger';
                                }else{
                                    $tTextStatusUse = $aTextLang['tTCGTBStatus1'];
                                    $tClassStatusUse    = 'text-success';
                                }
                            ?>
                            <tr
                                class="text-center xCNTextDetail2 xWTCGItems"
                                id="otrTouchGroup<?php echo $nKey?>"
                                data-code="<?php echo $aValue['FTTcgCode'];?>"
                                data-name="<?php echo $aValue['FTTcgName'];?>"
                                data-page="<?php echo $nCurrentPage;?>"
                            >
                                <?php if($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaDelete'] == 1) : ?>
                                    <td nowrap class="text-center">
                                        <label class="fancy-checkbox ">
                                            <input id="ocbListItem<?php echo $nKey?>" type="checkbox" class="ocbListItem" name="ocbListItem[]">
                                            <span>&nbsp;</span>
                                        </label>
                                    </td>
                                <?php endif; ?>
                                <!-- เพิ่มรูปภาพหน้ากลุ่มสินค้าด่วน -->
                                <td class="text-center">
                                    <?php echo FCNtHGetImagePageList($aValue['FTImgObj'], '38px');?>
                                </td>

                                <td nowrap class="text-left"><?php echo (!empty($aValue['FTTcgCode'])) ? $aValue['FTTcgCode'] : '-' ?></td>
                                <td nowrap class="text-left"><?php echo (!empty($aValue['FTTcgName'])) ? $aValue['FTTcgName'] : '-' ?></td>
                                <td nowrap class="text-center"><label class="xCNTDTextStatus <?php echo $tClassStatusUse;?>"><?php echo @$tTextStatusUse;?></label></td>
                                <?php if($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaDelete'] == 1): ?>
                                    <td nowrap >
                                        <img
                                            class="xCNIconTable xCNIconDel xWTCGDeleteSingle"
                                            src="<?php echo  base_url().'/application/modules/common/assets/images/icons/delete.png'?>"
                                        >
                                    </td>
                                <?php endif; ?>
                                <?php if($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaRead'] == 1 || $aAlwEvent['tAutStaEdit'] == 1): ?>
                                    <td nowrap>
                                        <img class="xCNIconTable xCNIconEdit" onClick="JSvTCGCallPageEditForm('<?php echo $aValue['FTTcgCode']?>')">
                                    </td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td class='text-center xCNTextDetail2' colspan='100%'><?php echo @$aTextLang['tCMNNotFoundData'];?></td></tr>
                    <?php endif;?>
                </tbody>
            </table>
        </div>    
    </div>
</div>
<div class="row">
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
        <p><?php echo @$aTextLang['tResultTotalRecord'];?> <?php echo $aDataList['rnAllRow']?> <?php echo @$aTextLang['tRecord'];?> <?php echo @$aTextLang['tCurrentPage'];?> <?php echo $aDataList['rnCurrentPage']?> / <?php echo $aDataList['rnAllPage']?></p>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
        <div class="xWTCGPageDataTable btn-toolbar pull-right">
            <?php if($nPage == 1){ $tDisabledLeft = 'disabled'; }else{ $tDisabledLeft = '-';} ?>
            <button onclick="JSvTCGClickPageList('previous')" class="btn btn-white btn-sm" <?php echo $tDisabledLeft ?>>
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
                <button onclick="JSvTCGClickPageList('<?php echo $i?>')" type="button" class="btn xCNBTNNumPagenation <?php echo $tActive ?>" <?php echo $tDisPageNumber ?>><?php echo $i?></button>
            <?php } ?>

            <?php if($nPage >= $aDataList['rnAllPage']){  $tDisabledRight = 'disabled'; }else{  $tDisabledRight = '-';  } ?>
            <button onclick="JSvTCGClickPageList('next')" class="btn btn-white btn-sm" <?php echo $tDisabledRight ?>>
                <i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
            </button>
        </div>
    </div>
</div>

<!-- ===================================================== Modal Delete Document Single ===================================================== -->
<div id="odvTCGModalDelDocSingle" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header xCNModalHead">
                    <label class="xCNTextModalHeard"><?php echo @$aTextLang['tModalDelete'];?></label>
                </div>
                <div class="modal-body">
                    <span id="ospTextConfirmDelSingle" class="xCNTextModal" style="display: inline-block; word-break:break-all"></span>
                </div>
                <div class="modal-footer">
                    <button id="osmConfirmDelSingle" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" type="button"><?php echo @$aTextLang['tModalConfirm'];?></button>
                    <button class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"  data-dismiss="modal"><?php echo @$aTextLang['tModalCancel'];?></button>
                </div>
            </div>
        </div>
    </div>
<!-- ======================================================================================================================================== -->
<!-- ===================================================== Modal Delete Document Multiple =================================================== -->
<div id="odvTCGModalDelDocMultiple" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header xCNModalHead">
                    <label class="xCNTextModalHeard"><?php echo @$aTextLang['tModalDelete'];?></label>
                </div>
                <div class="modal-body">
                    <span id="ospTextConfirmDelMultiple" class="xCNTextModal" style="display: inline-block; word-break:break-all"></span>
                    <input type='hidden' id="ohdConfirmIDDelMultiple">
                </div>
                <div class="modal-footer">
                    <button id="osmConfirmDelMultiple" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" type="button"><?php echo @$aTextLang['tModalConfirm'];?></button>
                    <button class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"  data-dismiss="modal"><?php echo @$aTextLang['tModalCancel'];?></button>
                </div>
            </div>
        </div>
    </div>
<!-- ======================================================================================================================================== -->
<?php include('script/jPdtTouchGroupDataTable.php')?>
