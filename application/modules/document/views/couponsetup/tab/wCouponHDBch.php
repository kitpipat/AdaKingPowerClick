
<div id="odvTabCouponHDBch" class="tab-pane fade active in">
        <div class="row">
            <div class="table-responsive">

              <div  style="padding-bottom: 20px;">
                    <?php  if($this->session->userdata('nSesUsrBchCount')!=1){ ?>
                  <button id="obtTabCouponHDBchInclude" class="xCNBTNPrimeryPlus xCNInputWhenStaCancelDoc" type="button">+</button>
                    <?php } ?>
                </div>
               <div>
                 <label  class="xCNLabelFrm"><?php echo language('document/couponsetup/couponsetup','tCPHTabCouponHDBchInclude')?></label>
               </div> 
        
             <table  class="table xWPdtTableFont">
                    <thead>
                        <tr class="xCNCenter">
                            <th nowrap class="xCNTextBold" style="width:10%;"><?php echo language('document/couponsetup/couponsetup','tCPHAgency')?></th>
                            <th nowrap class="xCNTextBold" style="width:80%;"><?php echo language('document/couponsetup/couponsetup','tCPHTabCouponHDBchName')?></th>
                            <th nowrap class="xCNTextBold" style="width:30%;"><?php echo language('company/merchant/merchant','tMerchantTitle')?></th>
                            <th nowrap class="xCNTextBold" style="width:30%;"><?php echo language('company/shop/shop','tSHPTitle')?></th>
                            <th  style="width:10%;"></th>
                        </tr >
                    </thead>
                    <tbody id="otbCouponHDBchInclude">
                    <?php 
                            if($tCPHRoute == "dcmCouponSetupEventAdd" && $this->session->userdata('tSesUsrLevel')!='HQ'){ 
                              $tSesUsrAgnCode = $this->session->userdata('tSesUsrAgnCode');
                              $tSesUsrAgnName = $this->session->userdata('tSesUsrAgnName');
                              if(!FCNbUsrIsAgnLevel()){

                                $tSesUsrBchCodeMulti = str_replace("'","",$this->session->userdata('tSesUsrBchCodeMulti'));
                                $tSesUsrBchNameMulti = str_replace("'","",$this->session->userdata('tSesUsrBchNameMulti'));
                                $aBchCodeArray = explode(',',$tSesUsrBchCodeMulti);
                                $aBchNameArray = explode(',',$tSesUsrBchNameMulti);
                                if(!empty($aBchCodeArray)){
                                    $nNum = 1;
                                    foreach($aBchCodeArray as $nK => $tBchCode){
                                ?>
                                <tr class='otrInclude' id='otrCPHcouponIncludeBch<?=$nK?>'>
                                <td>
                                <input type='hidden' name='ohdCPHCouponIncludeAgnCode[<?=$nK?>]' class='ohdCPHCouponIncludeAgnCode' value='<?=$tSesUsrAgnCode?>'>
                                <input type='hidden' name='ohdCPHCouponIncludeBchCode[<?=$nK?>]' class='ohdCPHCouponIncludeBchCode' value='<?=$tBchCode?>'>
                                <input type='hidden' name='ohdCPHCouponIncludeMerCode[<?=$nK?>]' class='ohdCPHCouponIncludeMerCode' value='<?=$this->session->userdata('tSesUsrMerCode')?>'>
                                <input type='hidden' name='ohdCPHCouponIncludeShpCode[<?=$nK?>]' class='ohdCPHCouponIncludeShpCode' value='<?=$this->session->userdata('tSesUsrShpCodeDefault')?>'>
                                <?=$tSesUsrAgnName?>
                                </td>
                                <td><?=$aBchNameArray[$nK]?></td>
                                <td><?=$this->session->userdata('tSesUsrMerName')?></td>
                                <td><?=$this->session->userdata('tSesUsrShpNameDefault')?></td>
                                <td align='center'>
                                <?php  if($this->session->userdata('nSesUsrBchCount')!=1){ ?>
                                <img onclick='JSxCPHcouponRemoveTRIncludeBch(<?=$nK?>)' class='xCNIconTable xCNIconDel' src='<?php echo  base_url().'/application/modules/common/assets/images/icons/delete.png'?>' >
                                <?php } ?>
                                </td>
                                </tr>
                       <?php    
                                    }
                                    $nNum++;
                                }
                              }else{
                     
                                ?>

                                <tr class='otrInclude' id='otrCPHcouponIncludeBch0'>
                                <td>
                                <input type='hidden' name='ohdCPHCouponIncludeAgnCode[0]' class='ohdCPHCouponIncludeAgnCode' value='<?=$tSesUsrAgnCode?>'>
                                <input type='hidden' name='ohdCPHCouponIncludeBchCode[0]' class='ohdCPHCouponIncludeBchCode' value=''>
                                <input type='hidden' name='ohdCPHCouponIncludeMerCode[0]' class='ohdCPHCouponIncludeMerCode' value=''>
                                <input type='hidden' name='ohdCPHCouponIncludeShpCode[0]' class='ohdCPHCouponIncludeShpCode' value=''>
                                <?=$tSesUsrAgnName?>
                                </td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td align='center'>
                                <?php  if($this->session->userdata('nSesUsrBchCount')!=1){ ?>
                                <img onclick='JSxCPHcouponRemoveTRIncludeBch(0)' class='xCNIconTable xCNIconDel' src='<?php echo  base_url().'/application/modules/common/assets/images/icons/delete.png'?>' >
                                <?php } ?>
                                </td>



                           <?php
                              }


                        }
                    ?>
                    <?php if(!empty($aDataDocHD['raCouponDetailInOrEx']['aCouponHDBch'][1])){
                                  foreach($aDataDocHD['raCouponDetailInOrEx']['aCouponHDBch'][1] AS $nKey => $aValue){ 
                                     $nI=strtotime(date('Y-m-d H:i:s')).$nKey;
                                ?>
                           <tr class='otrInclude' id='otrCPHcouponIncludeBch<?=$nI?>'>
                            <td>
                            <input type='hidden' name='ohdCPHCouponIncludeAgnCode[<?=$nI?>]' class='ohdCPHCouponIncludeAgnCode' value='<?=$aValue['FTCphAgnTo']?>'>
                            <input type='hidden' name='ohdCPHCouponIncludeBchCode[<?=$nI?>]' class='ohdCPHCouponIncludeBchCode' value='<?=$aValue['FTCphBchTo']?>'>
                            <input type='hidden' name='ohdCPHCouponIncludeMerCode[<?=$nI?>]' class='ohdCPHCouponIncludeMerCode' value='<?=$aValue['FTCphMerTo']?>'>
                            <input type='hidden' name='ohdCPHCouponIncludeShpCode[<?=$nI?>]' class='ohdCPHCouponIncludeShpCode' value='<?=$aValue['FTCphShpTo']?>'>
                            <?=$aValue['FTAgnName']?>
                            </td>
                            <td><?=$aValue['FTBchName']?></td>
                            <td><?=$aValue['FTMerName']?></td>
                            <td><?=$aValue['FTShpName']?></td>
                            <td align='center'>
                            <?php  if($this->session->userdata('nSesUsrBchCount')!=1){ ?>
                            <img onclick='JSxCPHcouponRemoveTRIncludeBch(<?=$nI?>)' class='xCNIconTable xCNIconDel' src='<?php echo  base_url().'/application/modules/common/assets/images/icons/delete.png'?>' ></td>
                            <?php } ?>
                            </tr>
                        <?php } 
                             } ?>
                    </tbody>
                </table>
                </div>

                <div class="table-responsive">
                <div  style="padding-bottom: 20px;">
                <?php  if($this->session->userdata('nSesUsrBchCount')!=1){ ?>
                  <button id="obtTabCouponHDBchExclude" class="xCNBTNPrimeryPlus xCNInputWhenStaCancelDoc" type="button">+</button>
                  <?php } ?>
                </div>
               <div>
                 <label  class="xCNLabelFrm"><?php echo language('document/couponsetup/couponsetup','tCPHTabCouponHDBchExclude')?></label>
               </div> 
             <table  class="table xWPdtTableFont">
                    <thead>
                        <tr class="xCNCenter">
                            <th nowrap class="xCNTextBold" style="width:10%;"><?php echo language('document/couponsetup/couponsetup','tCPHAgency')?></th>
                            <th nowrap class="xCNTextBold" style="width:80%;"><?php echo language('document/couponsetup/couponsetup','tCPHTabCouponHDBchName')?></th>
                             <th nowrap class="xCNTextBold" style="width:30%;"><?php echo language('company/merchant/merchant','tMerchantTitle')?></th>
                            <th nowrap class="xCNTextBold" style="width:30%;"><?php echo language('company/shop/shop','tSHPTitle')?></th> 
                            <th  style="width:10%;"></th>
                        </tr>
                    </thead>
                    <tbody id="otbCouponHDBchExclude">
                    <?php if(!empty($aDataDocHD['raCouponDetailInOrEx']['aCouponHDBch'][2])){
                                  foreach($aDataDocHD['raCouponDetailInOrEx']['aCouponHDBch'][2] AS $nKey => $aValue){ 
                                     $nI=strtotime(date('Y-m-d H:i:s')).$nKey;
                                ?>
                           <tr class='otrExclude' id='otrCPHcouponExcludeBch<?=$nI?>'>
                            <td>
                            <input type='hidden' name='ohdCPHCouponExcludeAgnCode[<?=$nI?>]' class='ohdCPHCouponExcludeAgnCode' value='<?=$aValue['FTCphAgnTo']?>'>
                            <input type='hidden' name='ohdCPHCouponExcludeBchCode[<?=$nI?>]' class='ohdCPHCouponExcludeBchCode' value='<?=$aValue['FTCphBchTo']?>'>
                            <input type='hidden' name='ohdCPHCouponExcludeMerCode[<?=$nI?>]' class='ohdCPHCouponExcludeMerCode' value='<?=$aValue['FTCphMerTo']?>'>
                            <input type='hidden' name='ohdCPHCouponExcludeShpCode[<?=$nI?>]' class='ohdCPHCouponExcludeShpCode' value='<?=$aValue['FTCphShpTo']?>'>
                            <?=$aValue['FTAgnName']?>
                            </td>
                            <td><?=$aValue['FTBchName']?></td>
                             <td><?=$aValue['FTMerName']?></td>
                            <td><?=$aValue['FTShpName']?></td> 
                            <td align='center'><img onclick='JSxCPHcouponRemoveTRExcludeBch(<?=$nI?>)' class='xCNIconTable xCNIconDel' src='<?php echo  base_url().'/application/modules/common/assets/images/icons/delete.png'?>' ></td>
                            </tr>
                        <?php } 
                             } ?>
                    </tbody>
                </table>
                </div>

            </div>
</div>



