<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" id="">
<div class="table-responsive">
            <table id="otbMNTDataList" class="table table-striped"> <!-- เปลี่ยน -->
                <thead>
                    <tr>
                        <th class="text-center xCNTextBold" ><?= language('checkdocument/checkdocument','tChkDocTbNo')?></th>
                        <th class="text-center xCNTextBold" ><?= language('checkdocument/checkdocument','tChkDocTbDocType')?></th>
                        <th class="text-center xCNTextBold" ><?= language('checkdocument/checkdocument','tChkDocTbDocNo')?></th>
                        <th class="text-center xCNTextBold" ><?= language('checkdocument/checkdocument','tChkDocTbDocDate')?></th>
                        <th class="text-center xCNTextBold" ><?= language('checkdocument/checkdocument','tChkDocTbBchFrm')?></th>
                        <th class="text-center xCNTextBold" ><?= language('checkdocument/checkdocument','tChkDocTbBchTo')?></th>
                        <th class="text-center xCNTextBold" ><?= language('checkdocument/checkdocument','tChkDocTbRmk')?></th>
                        <th class="text-center xCNTextBold" ><?= language('checkdocument/checkdocument','tChkDocTbDetail')?></th>
                    </tr>
                </thead>
                <tbody>
                        <?php if(!empty($aDataNotiDoc)){
                                foreach($aDataNotiDoc as $nKey => $aData){ 

                                    if($aData['FTStaRead']=='2'){
                                            $tStaRead = 'background:#f2f4ff';
                                        }else{
                                            $tStaRead = '';
                                        }
                                
                                ?>
                            <tr style="<?=$tStaRead?>">
                                <td class='text-center xCNTextDetail2'><?=($nKey+1)?></td>
                                <td class='text-left xCNTextDetail2'><?=$aData['FTNotTypeName']?></td>
                                <td class='text-center xCNTextDetail2'><?=$aData['FTNotDocRef']?></td>
                                <td class='text-center xCNTextDetail2'><?=date('d/m/Y H:i',strtotime($aData['FDNotDate']))?></td>
                                <td class='text-left xCNTextDetail2'>
                                <?php if(!empty($aDataNotiDoc)){ ?>
                                    <?php foreach($aData['oBchCodeFrm'] as $nKey1 => $aData1){ 
                                            if($nKey1==0){
                                                $tChkBchCode = $aData1['FTBchCode'];
                                                $tChkBchName = $aData1['FTBchName'];
                                            }
                                        ?>  
                                                <?=$tChkBchName?><br>
                                                <!-- <hr> -->
                                    <?php } ?>
                                <?php } ?>
                                </td>
                                <td class='text-left xCNTextDetail2'>
                                <?php if(!empty($aDataNotiDoc)){ ?>
                                    <?php foreach($aData['oBchCodeTo'] as $nKey1 => $aData1){
                                            if(FCNnHSizeOf($aData['oBchCodeTo'])>1){
                                                if($tChkBchCode==$aData1['FTBchCode']){
                                                    continue;
                                                }
                                            }
                                            
                                            $tNotTypeName = '';
                                            if($aData1['FTNotStaType']=='2'){
                                                    $tNotTypeName= language('checkdocument/checkdocument','tMntGroupConditionChkDocTypeExclude');
                                            }else{
                                                    $tNotTypeName= language('checkdocument/checkdocument','tMntGroupConditionChkDocTypeInclude');
                                            }
                                        ?>  
                                                <?=$tNotTypeName.' '.$aData1['FTBchName']?><br>
                                                <!-- <hr> -->
                                    <?php } ?>
                                <?php } ?>
                                </td>
                                <td class='text-left xCNTextDetail2'>
                                <?php if(!empty($aDataNotiDoc)){ ?>
                                    <?php foreach($aData['oNotiAction'] as $nKey1 => $aData1){ 
                                        ?>  
                                                <?=date('d/m/Y H:i',strtotime($aData1['FDNoaDateInsert']))?> <?=$aData1['FTNoaDesc']?><br>
                                                <!-- <hr> -->
                                    <?php } ?>
                                <?php } ?>
                            </td>
                                <td class='text-center xCNTextDetail2'>
                                <?php if($aData['FNNotUrlType']==1){ ?>
                                <img class="xCNIconTable" style="width: 17px;" src="<?= base_url('application/modules/common/assets/images/icons/view2.png'); ?>"
                                 onclick="JCNxNFTReadNotID('<?=$aData['FTNotID']?>',1);JCNxNTFJumpDocPageEdit('<?=$aData['FTNotDocRef']?>','<?=$aData['FTNotUrlRef']?>','<?=$aData['FTAgnCode']?>','<?=$aData['FTNotBchRef']?>')">
                                 <?php }else if($aData['FNNotUrlType']==2){ ?>
                                    <img class="xCNIconTable" style="width: 17px;" src="<?= base_url('application/modules/common/assets/images/icons/view2.png'); ?>"
                                 onclick="JCNxNFTReadNotID('<?=$aData['FTNotID']?>',1);JCNxNTFOpenUrl('<?=$aData['FTNotUrlRef']?>')">
                                <?php }else if($aData['FNNotUrlType']==3){ ?>
                                    <img class="xCNIconTable" style="width: 17px;" src="<?= base_url('application/modules/common/assets/images/icons/view2.png'); ?>"
                                 onclick="JCNxNFTReadNotID('<?=$aData['FTNotID']?>',1);JCNxNTFPopUpNew(this)"
                                 data-desc1="<?=$aData['FTNotDesc1']?>"
                                 data-desc2="<?=$aData['FTNotDesc2']?>"
                                 data-date="<?=date('d/m/Y H:i',strtotime($aData['FDNotDate']))?>"
                                 >
                                <?php } ?>
                                </td>
                            </tr>
                        <?php  }
                             }else{ ?>
                         <tr><td class='text-center xCNTextDetail2' colspan='8'><?= language('checkdocument/checkdocument','tChkDocTbNoData')?></td></tr>
                         <?php } ?>
                </tbody>
            </table>
        </div>
</div>

<script>
    //   $(document).ready(function () {
    //         // $("#otbMNTDataList").DataTable();
    //         $oNewJqueryVersion('#otbMNTDataList').DataTable({
    //         ordering: false,
    //         searching: false,
    //         lengthChange: false,
    //         bInfo: false,
    //         });
    //     });
</script>