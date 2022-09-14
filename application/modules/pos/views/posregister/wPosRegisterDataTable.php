<style>

    .xWCurStatusApv {
        color: #2a8e2a !important;
        font-weight: bold;
        font-size: 10px;
        cursor: default;
    }
    .xWCurStatusCancel {
        color: #f50606 !important;
        font-weight: bold;
        cursor: default;
        font-size: 10px;
    }

    .xWCurStatusNotApv {
        color: #7b7f7b !important;
        font-weight: bold;
        cursor: default;
        font-size: 10px;
    }

</style>


<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="table-responsive">
            <table id="otbCrdDataList" class="table table-striped">
                <thead>
                    <tr class="xCNCenter">
                        <th width="5%" class="xCNTextBold">
                            <!-- <label class="fancy-checkbox"> -->
                                <input class="xCNFuncPosRegUsedAll" style="width: 30px;" type="checkbox" class="ocbHeadCheckBox" name="oetAllCheck" id="oetAllCheck">
                                <!-- <span></span>
                            </label> -->
                        </th>  
                        <th width="10%" class="xCNTextBold"><?php echo language('pos/posreg/posreg', 'tPRGBranch'); ?></th>
                        <th width="10%" class="xCNTextBold"><?php echo language('pos/posreg/posreg', 'tPRGPosCode'); ?></th>
                        <th width="15%" class="xCNTextBold"><?php echo language('pos/posreg/posreg', 'tPRGPosName'); ?></th>
                        <th width="10%" class="xCNTextBold"><?php echo language('pos/posreg/posreg', 'tPRGMacAddress'); ?></th>
                        <th width="10%" class="xCNTextBold"><?php echo language('pos/posreg/posreg', 'tPRGStatus'); ?></th>
                        <th width="10%" class="xCNTextBold"><?php echo language('pos/posreg/posreg', 'tPRGDateExpire'); ?></th>
                        <th width="10%" class="xCNTextBold"><?php echo language('pos/posreg/posreg', 'tPRGUsrApprove'); ?></th>
                    </tr>                
                </thead>
                <tbody>
                    <?php if($aResultDatatable['rtCode'] == 1):?> 
                        <?php foreach($aResultDatatable['raItems'] AS $key=>$aValue){?>
                            <tr class="text-cengter xCNTextDetail2" data-code="<?=$aValue['FTBchCode']?>,<?=$aValue['FTPrgMacAddr']?>">
                                <td class="text-center">
                                    <!-- <label class="fancy-checkbox"> -->
                                        <input id="ocbListItem<?=$key?>" type="checkbox" class="ocbListItem" name="ocbListItem[]"
                                            <?php if($aValue['FTPrgStaApv'] == '1' || $aValue['FTPrgStaApv'] == '3'){ echo "disabled"; }else{ echo ""; } ?>
                                            ohdBchCode="<?=$aValue['FTBchCode'];?>"
                                            ohdPosCode="<?=$aValue['FTPosCode'];?>"
                                            ohdPrgDate="<?=$aValue['FDPrgDate'];?>"
                                            ohdMacAddr="<?=$aValue['FTPrgMacAddr'];?>"
                                            ohdPrgExp="<?=$aValue['FDPrgExpire'];?>"
                                            ohdPrivateKey="KzYiHK4Z4B">  <!--default private key -->
                                        <!-- <span>&nbsp;</span>
                                    </label> -->
                                </td>
                                <td class="text-left"><?=$aValue['FTBchName'];?></td>
                                <td class="text-left"><?=$aValue['FTPosCode'];?></td>
                                <td class="text-left"><?=$aValue['FTPosName'];?></td>
                                <td class="text-left"><?=$aValue['FTPrgMacAddr'];?></td>
                                <?php
                                    switch ($aValue['FTPrgStaApv']) {
                                        case "1":
                                            $tStaApv = language('pos/posreg/posreg','tOption1');
                                            $tClassStaApprove   = 'xWCurStatusApv';
                                        break;
                                        case "2":
                                            $tStaApv  = language('pos/posreg/posreg','tOption2'); 
                                            $tClassStaApprove   = 'xWCurStatusNotApv';
                                        break;
                                        case "3":
                                            $tStaApv  = language('pos/posreg/posreg','tOption3'); 
                                            $tClassStaApprove   = 'xWCurStatusCancel';
                                        break;
                                    }
                                ?>
                                <td nowrap class="text-left"><a class="<?php echo $tClassStaApprove?>"><?php echo $tStaApv;?></a></td>
                                <td class="text-center"><?=$aValue['FDPrgExpire'];?></td>
                                <td class="text-left"><?=$aValue['FTUsrName'];?></td>
                            </tr>
                        <?php } ?>
                    <?php else:?>
                        <tr><td class='text-center xCNTextDetail2' colspan='99'><?= language('common/main/main','tCMNNotFoundData')?></td></tr>
                    <?php endif;?>
                </tbody>
            </table>        
        </div>
    </div>
</div>


<?php include_once('script/jPosRegisterDataTable.php'); ?>
