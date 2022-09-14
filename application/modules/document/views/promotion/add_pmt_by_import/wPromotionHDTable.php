<div class="table-responsive">
    <table class="table table-striped xWPdtTableFont" id="otbPromotionImportExcelHDTable">
        <thead>
            <tr>
                <th nowrap width="auto" class="text-center"><?php echo language('document/promotion/promotion', 'tLabel34'); ?></th>
                <th nowrap width="auto" class="text-center"><?php echo language('document/promotion/promotion', 'tLabel35'); ?></th>
                <th nowrap width="auto" class="text-center"><?php echo language('document/promotion/promotion', 'tLabel36'); ?></th>
                <th nowrap width="auto" class="text-center"><?php echo language('document/promotion/promotion', 'tLabel37'); ?></th>
                <th nowrap width="auto" class="text-center"><?php echo language('document/promotion/promotion', 'tLabel38'); ?></th>
                <th nowrap width="auto" class="text-center"><?php echo language('document/promotion/promotion', 'tLabel39'); ?></th>
                <th nowrap width="auto" class="text-center"><?php echo language('document/promotion/promotion', 'tLabel40'); ?></th>
                <th nowrap width="auto" class="text-center"><?php echo language('document/promotion/promotion', 'tLabel41'); ?></th>
                <th nowrap width="auto" class="text-center"><?php echo language('document/promotion/promotion', 'tLabel42'); ?></th>
                <th nowrap width="auto" class="text-center"><?php echo language('document/promotion/promotion', 'tLabel43'); ?></th>
                <th nowrap width="auto" class="text-center"><?php echo language('document/promotion/promotion', 'tLabel44'); ?></th>
                <th nowrap width="auto" class="text-center"><?php echo language('document/promotion/promotion', 'tLabel45'); ?></th>
                <th nowrap width="auto" class="text-center"><?php echo language('document/promotion/promotion', 'tLabel46'); ?></th>
                <th nowrap width="auto" class="text-center"><?php echo language('document/promotion/promotion', 'tLabel47'); ?></th>
                <th nowrap width="auto" class="text-center"><?php echo language('document/promotion/promotion', 'tLabel48'); ?></th>
                <th nowrap width="auto" class="text-center"><?php echo language('document/promotion/promotion', 'tLabel49'); ?></th>
                <th nowrap class="xCNTextBold" style="width:15%;text-align:center;"><?php echo  language('common/main/main', 'tRemark'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php if ($aDataListHD['tCode'] == 1) { ?>
                <?php foreach ($aDataListHD['aResult'] as $key => $aValue) { ?>
                    <?php 
                        $tPmhName = $aValue['FTPmhName'];
                        $tPmhDStart = date('Y/m/d', strtotime($aValue['FDPmhDStart']));
                        $tPmhDStop = date('Y/m/d', strtotime($aValue['FDPmhDStop']));
                        $tPmhTStart = $aValue['FDPmhTStart'];
                        $tPmhTStop = $aValue['FDPmhTStop'];
                        $tPmhStaLimitCst = $aValue['FTPmhStaLimitCst'];
                        $tPbyStaBuyCond = $aValue['FTPbyStaBuyCond'];
                        $tPmhStaGrpPriority = $aValue['FTPmhStaGrpPriority'];
                        $tPmhStaGetPdt = $aValue['FTPmhStaGetPdt'];
                        $tPmhStaChkQuota = $aValue['FTPmhStaChkQuota'];
                        $tPmhStaGetPri = $aValue['FTPmhStaGetPri'];
                        $tPmhStaChkCst = $aValue['FTPmhStaChkCst'];
                        $tSpmMemAge = $aValue['FTSpmMemAge'];
                        $tSpmMemDOB = $aValue['FTSpmMemDOB'];
                        $tPbyStaCalSum = $aValue['FTPbyStaCalSum'];
                        $tPgtStaGetEffect = $aValue['FTPgtStaGetEffect'];

                        if(in_array($aValue['FTTmpStatus'], ["3","4","7"]) && explode("$&", $aValue['FTTmpRemark'])[0] == "[0]"){
                            $tPmhName = explode("$&", $aValue['FTTmpRemark'])[2];
                        }
                        if(in_array($aValue['FTTmpStatus'], ["3","4","7"]) && explode("$&", $aValue['FTTmpRemark'])[0] == "[1]"){
                            $tPmhDStart = explode("$&", $aValue['FTTmpRemark'])[2];
                        }
                        if(in_array($aValue['FTTmpStatus'], ["3","4","7"]) && explode("$&", $aValue['FTTmpRemark'])[0] == "[2]"){
                            $tPmhDStop = explode("$&", $aValue['FTTmpRemark'])[2];
                        }
                        if(in_array($aValue['FTTmpStatus'], ["3","4","7"]) && explode("$&", $aValue['FTTmpRemark'])[0] == "[3]"){
                            $tPmhTStart = explode("$&", $aValue['FTTmpRemark'])[2];
                        }
                        if(in_array($aValue['FTTmpStatus'], ["3","4","7"]) && explode("$&", $aValue['FTTmpRemark'])[0] == "[4]"){
                            $tPmhTStop = explode("$&", $aValue['FTTmpRemark'])[2];
                        }
                        if(in_array($aValue['FTTmpStatus'], ["3","4","7"]) && explode("$&", $aValue['FTTmpRemark'])[0] == "[5]"){
                            $tPmhStaLimitCst = explode("$&", $aValue['FTTmpRemark'])[2];
                        }
                        if(in_array($aValue['FTTmpStatus'], ["3","4","7"]) && explode("$&", $aValue['FTTmpRemark'])[0] == "[6]"){
                            $tPbyStaBuyCond = explode("$&", $aValue['FTTmpRemark'])[2];
                        }
                        if(in_array($aValue['FTTmpStatus'], ["3","4","7"]) && explode("$&", $aValue['FTTmpRemark'])[0] == "[7]"){
                            $tPmhStaGrpPriority = explode("$&", $aValue['FTTmpRemark'])[2];
                        }
                        if(in_array($aValue['FTTmpStatus'], ["3","4","7"]) && explode("$&", $aValue['FTTmpRemark'])[0] == "[8]"){
                            $tPmhStaGetPdt = explode("$&", $aValue['FTTmpRemark'])[2];
                        }
                        if(in_array($aValue['FTTmpStatus'], ["3","4","7"]) && explode("$&", $aValue['FTTmpRemark'])[0] == "[9]"){
                            $tPmhStaChkQuota = explode("$&", $aValue['FTTmpRemark'])[2];
                        }
                        if(in_array($aValue['FTTmpStatus'], ["3","4","7"]) && explode("$&", $aValue['FTTmpRemark'])[0] == "[10]"){
                            $tPmhStaGetPri = explode("$&", $aValue['FTTmpRemark'])[2];
                        }
                        if(in_array($aValue['FTTmpStatus'], ["3","4","7"]) && explode("$&", $aValue['FTTmpRemark'])[0] == "[11]"){
                            $tPmhStaChkCst = explode("$&", $aValue['FTTmpRemark'])[2];
                        }
                        if(in_array($aValue['FTTmpStatus'], ["3","4","7"]) && explode("$&", $aValue['FTTmpRemark'])[0] == "[12]"){
                            $tSpmMemAge = explode("$&", $aValue['FTTmpRemark'])[2];
                        }
                        if(in_array($aValue['FTTmpStatus'], ["3","4","7"]) && explode("$&", $aValue['FTTmpRemark'])[0] == "[13]"){
                            $tSpmMemDOB = explode("$&", $aValue['FTTmpRemark'])[2];
                        }
                        if(in_array($aValue['FTTmpStatus'], ["3","4","7"]) && explode("$&", $aValue['FTTmpRemark'])[0] == "[14]"){
                            $tPbyStaCalSum = explode("$&", $aValue['FTTmpRemark'])[2];
                        }
                        if(in_array($aValue['FTTmpStatus'], ["3","4","7"]) && explode("$&", $aValue['FTTmpRemark'])[0] == "[15]"){
                            $tPgtStaGetEffect = explode("$&", $aValue['FTTmpRemark'])[2];
                        }
                    ?>
                    <tr 
                    class="xCNTextDetail2 xCNPromotionImportExcelHDRow"
                    data-sta="<?php echo $aValue['FTTmpStatus']; ?>">
                        <td nowrap class="text-left"><?php echo $tPmhName; ?></td>
                        <td nowrap class="text-center"><?php echo $tPmhDStart; ?></td>
                        <td nowrap class="text-center"><?php echo $tPmhDStop; ?></td>
                        <td nowrap class="text-center"><?php echo $tPmhTStart; ?></td>
                        <td nowrap class="text-center"><?php echo $tPmhTStop; ?></td>
                        <td nowrap class="text-center"><?php echo $tPmhStaLimitCst; ?></td>
                        <td nowrap class="text-center"><?php echo $tPbyStaBuyCond; ?></td>
                        <td nowrap class="text-center"><?php echo $tPmhStaGrpPriority; ?></td>
                        <td nowrap class="text-center"><?php echo $tPmhStaGetPdt; ?></td>
                        <td nowrap class="text-center"><?php echo $tPmhStaChkQuota; ?></td>
                        <td nowrap class="text-center"><?php echo $tPmhStaGetPri; ?></td>
                        <td nowrap class="text-center"><?php echo $tPmhStaChkCst; ?></td>
                        <td nowrap class="text-center"><?php echo $tSpmMemAge; ?></td>
                        <td nowrap class="text-center"><?php echo $tSpmMemDOB; ?></td>
                        <td nowrap class="text-center"><?php echo $tPbyStaCalSum; ?></td>
                        <td nowrap class="text-center"><?php echo $tPgtStaGetEffect; ?></td>
                        <td nowrap class="text-center">
                            <label style="color:red !important; font-weight:bold;">
                                <?php 
                                    if(in_array($aValue['FTTmpStatus'], ["3","4","7"])){
                                        echo explode("$&", $aValue['FTTmpRemark'])[1]; 
                                    }else{
                                        echo $aValue['FTTmpRemark'];
                                    }
                                ?>
                            </label>
                        </td>
                    </tr>
                <?php } ?>
            <?php } else { ?>
                <tr>
                    <td class='text-center xCNTextDetail2' colspan='100%'><?= language('common/main/main', 'tCMNNotFoundData') ?></td>
                </tr>
            <?php }; ?>
        </tbody>
    </table>
</div>

<?php include('script/jPromotionHDTable.php'); ?>