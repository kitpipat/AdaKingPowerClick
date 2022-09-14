<style type="text/css">
    .xCNAlignver {
        display: block;
        filter: flipv fliph;
        -webkit-transform: rotate(-90deg);
        -moz-transform: rotate(-90deg);
        transform: rotate(-90deg);
        position: relative;
        width: 8px;
        white-space: nowrap;
        margin-bottom: -8px;
    }

    .panel .table>thead>tr>td:last-child, 
    .panel .table>thead>tr>th:last-child, 
    .panel .table>tbody>tr>td:last-child, 
    .panel .table>tbody>tr>th:last-child {
        padding-left : 5px;
    }

    table {
        table-layout: fixed;
        width       : 100%;
    }

    td.xCNColumn , th.xCNColumn{
        vertical-align: top;
        padding     :   10px;
        width       :   155px !important;
        border      :   1px solid #dee2e6 !important;
    }

    .xCNFreezeOne {
        position    :   absolute;
        left        :   0; 
        width       :   50px;
        padding     :   10px !important;
    }

    .xCNFreezeTwo {
        position    :   absolute;
        left        :   50px; 
        width       :   200px;
        padding     :   10px !important;
    }

    .xCNFreezeThree{
        position    :   absolute;
        left        :   250px; 
        width       :   150px;
        padding     :   10px !important;
    }

    .xCNFreezeOne span , .xCNFreezeTwo span , .xCNFreezeThree span {
        text-align  : center;
    }

    .outer {
        position    :   relative
    }

    .xCNBorderSecond {
        overflow-x  :   scroll;
        overflow-y  :   visible; 
        margin-left :   400px;
    }
</style>

<form id="ofmAddEditPDCDis">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="outer">
                <div class="xCNBorderSecond">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th height="50px;"class="text-center xCNFreezeOne" valign="bottom"><span><?php echo language('settingconfig/discountpolicy/discountpolicy', 'tDpcSeq'); ?></span></th>
                                        <th height="50px;"class="text-center xCNFreezeTwo" valign="bottom"><span><?php echo language('settingconfig/discountpolicy/discountpolicy', 'tDpcTypeDiscount'); ?></span></th>
                                        <th height="50px;"class="text-center xCNFreezeThree" valign="bottom"><span><?php echo language('settingconfig/discountpolicy/discountpolicy', 'tDpcGroup'); ?></span></th>
                                        <!-- <th height="150px;" width="5%" class="text-center" valign="bottom"><span><?php //echo language('settingconfig/discountpolicy/discountpolicy', 'tDpcPriceCal');  ?></span></th> -->
                                                                                                                    
                                        <?php
                                        // print_r($aDatatableHeader);
                                        if ($aDatatableHeader['rtCode'] == 1) : ?>
                                            <?php foreach ($aDatatableHeader['raItems'] as $key => $aValue) { ?>
                                                <?php if($aValue['FTDisStaUse'] == 1) : ?>
                                                    <th height="50px;"class="text-center xCNColumn" valign="bottom"><span><?= $aValue['FTDisName']; ?></span></th>
                                                <?php endif; ?> 
                                            <?php } ?>
                                        <?php endif; ?>
                                    </tr>
                                </thead>
                               
                                <tbody >
                                    <?php if ($aDatatable['rtCode'] == 1) : ?>
                                        <?php foreach ($aDatatable['raItems'] as $key => $aValue) { ?>
                                            <tr>
                                                <td style="text-align:center" class="xCNFreezeOne"><?php echo ($key + 1); ?></td>
                                                <td class="text-left xCNFreezeTwo"><?= $aValue['FTDisName']; ?></td>
                                                <td class="text-left xCNFreezeThree"><?= $aValue['FTDisGroup']; ?></td>
                                                <!-- <td class="text-left"><?//=$aValue['FTDisStaPrice'];?></td> -->
                                                <?php if ($aDatatableHeader['rtCode'] == 1) : ?>
                                                    <?php foreach ($aDatatableHeader['raItems'] as $key2 => $aValue2) { ?>
                                                        <?php if($aValue2['FTDisStaUse'] == 1) : ?>
                                                            <?php $iID = 'FTDpcStaAlw' . ($key2 + 1); ?>

                                                            <td class="text-center xCNColumn" valign="bottom">
                                                                <?php $tIDControl = 'Column_YN' . ($key2 + 1);?>
                                                                <?php $tIDControlAlwB = 'Column_B' . ($key2 + 1); ?>

                                                                <select class="selectpicker form-control xCNComboSelect" name="ocmStaAlw_<?= $aValue['FTDpcDisCodeX'] ?>_<?= $aValue2['FTDpcDisCodeY']; ?>" style="height:33px !important;" 
                                                                    <?php if($aValue[$tIDControl] == '0' && $aValue[$tIDControlAlwB] == '0'){ echo 'disabled'; }  ?>>
                                                                    <?php if($aValue[$tIDControl] == '1' && $aValue[$tIDControlAlwB] == '0')  {  ?>
                                                                        <option value="1" <?= ($aValue[$iID] == 1) ? 'selected' : ''; ?>><?= language('settingconfig/discountpolicy/discountpolicy', 'tOption1') ?></option>
                                                                        <option value="2" <?= ($aValue[$iID] == 2) ? 'selected' : ''; ?>><?= language('settingconfig/discountpolicy/discountpolicy', 'tOption2') ?></option>
                                                                   
                                                                    <?php }else if($aValue[$tIDControl] == '0' && $aValue[$tIDControlAlwB] == '1') { /*TB*/ ?>
                                                                        <option value="3" <?= ($aValue[$iID] == 3) ? 'selected' : ''; ?>><?= language('settingconfig/discountpolicy/discountpolicy', 'tOption3') ?></option>
                                                                        <!-- ส่วนของ Promotion เอา N ออก -->
                                                                        <!-- <option value="2" <?//= ($aValue[$iID] == 2) ? 'selected' : ''; ?>><?//= language('settingconfig/discountpolicy/discountpolicy', 'tOption2') ?></option> -->
                                                                    <?php }else if($aValue[$tIDControl] == '1' && $aValue[$tIDControlAlwB] == '1') { /*TB*/ ?>
                                                                        <option value="1" <?= ($aValue[$iID] == 1) ? 'selected' : ''; ?>><?= language('settingconfig/discountpolicy/discountpolicy', 'tOption1') ?></option>
                                                                        <option value="2" <?= ($aValue[$iID] == 2) ? 'selected' : ''; ?>><?= language('settingconfig/discountpolicy/discountpolicy', 'tOption2') ?></option>
                                                                        <option value="3" <?= ($aValue[$iID] == 3) ? 'selected' : ''; ?>><?= language('settingconfig/discountpolicy/discountpolicy', 'tOption3') ?></option>
                                                                    <?php }else if($aValue[$tIDControl] == '0' && $aValue[$tIDControlAlwB] == '0'){ /*NULL*/ ?>
                                                                        <option value="2">N/A</option>
                                                                    <?php }else { /*NULL*/ ?> 
                                                                        <option>ไม่ตรงเงื่อนไข</option>
                                                                    <?php } ?>
                                                                </select>

                                                            </td>
                                                        <?php endif; ?> 
                                                    <?php } ?>
                                                <?php endif; ?>
                                            </tr>
                                        <?php } ?>
                                    <?php else : ?>
                                        <tr>
                                            <td class='text-center xCNTextDetail2' colspan='99'><?= language('common/main/main', 'tCMNNotFoundData') ?></td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<script>

    $('.selectpicker').selectpicker('refresh');

    //ใช้ selectpicker
    $('.selectpicker').selectpicker();
                                        
    var tWidth       = $('#ofmAddEditPDCDis').width() - 400;
    var nWidth       = 0;
    var nTableColumn = $('thead th.xCNColumn').length;

    for(i=1; i<=nTableColumn; i++){
        nWidth += $('thead th.xCNColumn').width() + 10;
    }       

    var nNewWidth = nWidth;
    if(nNewWidth > tWidth){
        $('.xCNBorderSecond').css('width','auto');
    }else{
        var nNewWidth = nNewWidth+'px';
        $('.xCNBorderSecond').css('width',nNewWidth);
    }
</script>