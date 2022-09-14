<style>
.xCNMenuplusRedeemCR {
    float: left;
    margin-right: 10px;
    margin-top: -2px;
    cursor: pointer;
    display: inline-block;
    vertical-align: middle;
    -webkit-transform: perspective(1px) translateZ(0);
    transform: perspective(1px) translateZ(0);
    box-shadow: 0 0 1px rgba(0, 0, 0, 0);
    color:#fff;
}
</style>
<div id="odvTabConditionRedeemHDCR" >


<!-- <div class="col-md-12"> -->


<!-- panel panel-default -->
        <div class="panel panel-default" style="margin-bottom: 25px;">
                <div id="odvRDHHeadStatusInfoPpl" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
                    <label class="xCNTextDetail1"><?php echo language('document/conditionredeem/conditionredeem', 'tRdhCrNamePpl'); ?></label>
                    <a class="xCNMenuplusRedeemCR" role="button" data-toggle="collapse"  href="#odvRddConditionredeemCRCstPri" aria-expanded="true">
                        <i class="fa fa-plus xCNPlus"></i>
                    </a>
                </div>
                <!-- odvRddConditionredeemCRCstPri -->
                        <div id="odvRddConditionredeemCRCstPri" class=" panel-collapse collapse in" role="tabpanel">
                            <!--panel-body -->
                            <div class="panel-body">
                                <div class="col-md-12">
                                <!-- table-responsive -->
                                     <div class="table-responsive">
                                        <div  style="padding-bottom: 20px;">
                                        <?php if($tRDHStaApv!=1){ ?>
                                        <button id="obtTabConditionRedeemHDCRPpl"  class="xCNBTNPrimeryPlus hideCRNameColum" type="button">+</button>
                                        <?php } ?>
                                        </div>
                                        <div>
                                        <br>
                                        </div> 
                                    
                                        <table  class="table xWPdtTableFont">
                                                <thead>
                                                 <tr class="xCNCenter">
                                                        <th nowrap class="xCNTextBold" style="width:10%;"  ><?php echo language('document/conditionredeem/conditionredeem','tRdhNumberList')?></th>
                                                        <th nowrap class="xCNTextBold" style="width:20%;"><?php echo language('document/conditionredeem/conditionredeem','tRdhGroupName')?></th>
                                                        <th nowrap class="xCNTextBold" style="width:60%;"><?php echo language('document/conditionredeem/conditionredeem','tRdhGroupNamePpl')?></th>
                                                        <th nowrap class="xCNTextBold" style="width:10%;"><?php echo language('document/conditionredeem/conditionredeem','tRdhGroupDelete')?></th>
                                                    </tr>
                                                </thead>
                                                <tbody id="otbConditionRedeemHDCRPpl">
                                                <?php
                                            if(!empty($aDataDocCstPri)){
                                                    $aRdhStaTypeName = array(1=>language('document/conditionredeem/conditionredeem','tRdhGroupConditionRedeemTypeInclude') , 2=>language('document/conditionredeem/conditionredeem','tRdhGroupConditionRedeemTypeExclude'));
                                                    foreach($aDataDocCstPri as $nKey => $aData){

                                                            ?>
                                    <tr class='otrInclude' id='otrRddPPlRowID<?=$nKey?>'>
                                        <td align='center' id='otdColRowID_"+tRddPplCode+"'><?=($nKey+1)?></td>
                                        <td><input type='hidden' name='ohdRdhPplStaType[]' class='ohdRdhPplStaType' value='<?=$aData['FTRdhStaType']?>'><?=$aRdhStaTypeName[$aData['FTRdhStaType']]?></td>
                                        <td><input type='hidden' name='ohdRddPplCode[]' class='ohdRddPplCode' tRddPplname='<?=$aData['FTPplName']?>' value='<?=$aData['FTPplCode']?>'><?=$aData['FTPplName']?></td>
                                        <td align='center'><img onclick='JSxRddPplRemoveRow(<?=$nKey?>)' class='xCNIconTable xCNIconDel' src='<?php echo  base_url().'/application/modules/common/assets/images/icons/delete.png'?>' ></td>
                                    </tr>
                                                    <?php
                                                                }
                                                        }else{ ?>
                                                        <tr><td   id="otrRemoveTrCstPri" colspan="4" align="center"> <?php echo language('document/conditionredeem/conditionredeem','tRdhGroupNotFound')?> </td></tr>
                                                 <?php       }

                                                ?>
                                                </tbody>
                                            </table>
                                        </div>
                                <!-- table-responsive -->
                                </div>
                         </div>
                         <!--panel-body -->


                        </div>
                        <!-- odvRddConditionredeemCRCstPri -->
                     </div>
                     <!-- panel panel-default -->




                <div class="panel panel-default" style="margin-bottom: 25px;">
                <div id="odvRDHHeadStatusInfoBch" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
                    <label class="xCNTextDetail1"><?php echo language('document/conditionredeem/conditionredeem', 'tRdhCrNameBch'); ?></label>
                    <a class="xCNMenuplusRedeemCR" role="button" data-toggle="collapse"  href="#odvRddConditionredeemCRBch" aria-expanded="true">
                        <i class="fa fa-plus xCNPlus"></i>
                    </a>
                </div> 
                <div id="odvRddConditionredeemCRBch" class=" panel-collapse collapse in" role="tabpanel">
                    <div class="panel-body">
                        <div class="col-md-12">

                            <div class="table-responsive">

                            <div  style="padding-bottom: 20px;">    
                            <?php if($this->session->userdata('nSesUsrBchCount')!=1){ ?>
                                    <?php if($tRDHStaApv!=1){ ?>
                                <button id="obtTabConditionRedeemHDCRBch"  class="xCNBTNPrimeryPlus hideCRNameColum" type="button">+</button>
                                     <?php } ?>
                                     <?php } ?>
                                </div>
                            <div>
                            <br>
                            </div> 
                        
                                    <table  class="table xWPdtTableFont">
                                            <thead>
                                            <tr class="xCNCenter">
                                                    <th nowrap class="xCNTextBold" style="width:10%;"  ><?php echo language('document/conditionredeem/conditionredeem','tRdhNumberList')?></th>
                                                    <th nowrap class="xCNTextBold" style="width:10%;"><?php echo language('document/conditionredeem/conditionredeem','tRdhGroupName')?></th>
                                                    <th nowrap class="xCNTextBold" style="width:20%;"><?php echo language('document/conditionredeem/conditionredeem','tRDHAgency')?></th>
                                                    <th nowrap class="xCNTextBold" style="width:20%;"><?php echo language('document/conditionredeem/conditionredeem','tRdhBchName')?></th>
                                                    <th nowrap class="xCNTextBold" style="width:20%;"><?php echo language('document/conditionredeem/conditionredeem','tRdhMerName')?></th>
                                                    <th nowrap class="xCNTextBold" style="width:20%;"><?php echo language('document/conditionredeem/conditionredeem','tRdhShpName')?></th>
                                                    <th nowrap class="xCNTextBold" style="width:10%;"><?php echo language('document/conditionredeem/conditionredeem','tRdhGroupDelete')?></th>
                                                </tr>
                                            </thead>
                                            <tbody id="otbConditionRedeemHDCRBch">

                                            <?php
                                            //InClude Defalt Branch
                                        if($tRDHRoute == "dcmRDHEventAdd" && $this->session->userdata('tSesUsrLevel')!='HQ'){
                                            $aRdhStaTypeName = array(1=>language('document/conditionredeem/conditionredeem','tRdhGroupConditionRedeemTypeInclude') , 2=>language('document/conditionredeem/conditionredeem','tRdhGroupConditionRedeemTypeExclude'));
                                            $tSesUsrBchCodeMulti = str_replace("'","",$this->session->userdata('tSesUsrBchCodeMulti'));
                                            $tSesUsrBchNameMulti = str_replace("'","",$this->session->userdata('tSesUsrBchNameMulti'));
                                            $aBchCodeArray = explode(',',$tSesUsrBchCodeMulti);
                                            $aBchNameArray = explode(',',$tSesUsrBchNameMulti);
                                      
                                        $tSesUsrAgnCode = $this->session->userdata('tSesUsrAgnCode');
                                        $tSesUsrAgnName = $this->session->userdata('tSesUsrAgnName');
                                        if(!FCNbUsrIsAgnLevel()){

                                                if(!empty($aBchCodeArray)){
                                                    $nNum = 1;
                                                    foreach($aBchCodeArray as $nK => $tBchCode){
                                            ?>
                                            <tr class='otrInclude' id='otrRddBchRowID<?=$nK?>'>
                                            <td align='center' class='otdColRowID_Bch' ><?=$nNum?></td>
                                            <td ><?=$aRdhStaTypeName[1]?></td>
                                            <td>
                                            <input type='hidden' name='ohdRddConditionRedeemAgnCode[<?=$nK?>]' class='ohdRddConditionRedeemAgnCode' tRddAgnName='<?=$tSesUsrAgnName?>' value='<?=$tSesUsrAgnCode?>'>
                                            <input type='hidden' name='ohdRddConditionRedeemBchCode[<?=$nK?>]' class='ohdRddConditionRedeemBchCode' tRddBchName='<?=$aBchNameArray[$nK]?>' value='<?=$tBchCode?>'>
                                            <input type='hidden' name='ohdRddConditionRedeemMerCode[<?=$nK?>]' class='ohdRddConditionRedeemMerCode' tRddMerName='<?=$this->session->userdata('tSesUsrMerName')?>' value='<?=$this->session->userdata('tSesUsrMerCode')?>'>
                                            <input type='hidden' name='ohdRddConditionRedeemShpCode[<?=$nK?>]' class='ohdRddConditionRedeemShpCode' tRddShpName='<?=$this->session->userdata('tSesUsrShpNameDefault')?>' value='<?=$this->session->userdata('tSesUsrShpCodeDefault')?>'>
                                            <input type='hidden' name='ohdRddBchModalType[<?=$nK?>]' class='ohdRddBchModalType' value='1'>
                                            <?=$tSesUsrAgnName?></td>
                                            <td> <?=$aBchNameArray[$nK]?></td>
                                            <td><?=$this->session->userdata('tSesUsrMerName')?></td>
                                            <td><?=$this->session->userdata('tSesUsrShpNameDefault')?></td>
                                            <td align='center'>
                                            <?php if($this->session->userdata('nSesUsrBchCount')!=1){ ?>
                                            <img onclick='JSxRddBchRemoveRow(<?=$nK?>)' class='xCNIconTable xCNIconDel' src='<?php echo  base_url().'/application/modules/common/assets/images/icons/delete.png'?>' >
                                            <?php   } ?>
                                            </td>
                                        </tr>
                                        <?php 
                                          $nNum++;
                                                }
                                             
                                            }
                                        }else{ ?>

                                        <tr class='otrInclude' id='otrRddBchRowID0'>
                                            <td align='center' class='otdColRowID_Bch' >1</td>
                                            <td ><?=$aRdhStaTypeName[1]?></td>
                                            <td>
                                            <input type='hidden' name='ohdRddConditionRedeemAgnCode[0]' class='ohdRddConditionRedeemAgnCode' tRddAgnName='<?=$tSesUsrAgnName?>' value='<?=$tSesUsrAgnCode?>'>
                                            <input type='hidden' name='ohdRddConditionRedeemBchCode[0]' class='ohdRddConditionRedeemBchCode' tRddBchName='' value=''>
                                            <input type='hidden' name='ohdRddConditionRedeemMerCode[0]' class='ohdRddConditionRedeemMerCode' tRddMerName='' value=''>
                                            <input type='hidden' name='ohdRddConditionRedeemShpCode[0]' class='ohdRddConditionRedeemShpCode' tRddShpName='' value=''>
                                            <input type='hidden' name='ohdRddBchModalType[0]' class='ohdRddBchModalType' value='1'>
                                            <?=$tSesUsrAgnName?></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td align='center'>
                                            <?php if($this->session->userdata('nSesUsrBchCount')!=1){ ?>
                                            <img onclick='JSxRddBchRemoveRow(0)' class='xCNIconTable xCNIconDel' src='<?php echo  base_url().'/application/modules/common/assets/images/icons/delete.png'?>' >
                                            <?php   } ?>
                                            </td>
                                        </tr>

                                      <?php  }
                                    
                                    } ?>

                                        <?php
                                            if(!empty($aDataDocBch)){
                                                    $aRdhStaTypeName = array(1=>language('document/conditionredeem/conditionredeem','tRdhGroupConditionRedeemTypeInclude') , 2=>language('document/conditionredeem/conditionredeem','tRdhGroupConditionRedeemTypeExclude'));
                                                    foreach($aDataDocBch as $nKey => $aData){

                                                            ?>
                                                <tr class='otrInclude' id='otrRddBchRowID<?=$nKey?>'>
                                                    <td align='center' class='otdColRowID_Bch' ><?=($nKey+1)?></td>
                                                    <td ><?=$aRdhStaTypeName[$aData['FTRdhStaType']]?></td>
                                                    <td>
                                                    <input type='hidden' name='ohdRddConditionRedeemAgnCode[<?=$nKey?>]' class='ohdRddConditionRedeemAgnCode' tRddAgnName='<?=$aData['FTAgnName']?>' value='<?=$aData['FTRdhAgnTo']?>'>
                                                    <input type='hidden' name='ohdRddConditionRedeemMerCode[<?=$nKey?>]' class='ohdRddConditionRedeemMerCode' tRddMerName='<?=$aData['FTMerName']?>' value='<?=$aData['FTRdhMerTo']?>'>
                                                    <input type='hidden' name='ohdRddConditionRedeemBchCode[<?=$nKey?>]' class='ohdRddConditionRedeemBchCode' tRddBchName='<?=$aData['FTBchName']?>' value='<?=$aData['FTRdhBchTo']?>'>
                                                    <input type='hidden' name='ohdRddConditionRedeemShpCode[<?=$nKey?>]' class='ohdRddConditionRedeemShpCode' tRddShpName='<?=$aData['FTShpName']?>' value='<?=$aData['FTRdhShpTo']?>'>
                                                    <input type='hidden' name='ohdRddBchModalType[<?=$nKey?>]' class='ohdRddBchModalType' value='<?=$aData['FTRdhStaType']?>'>
                                                    <?=$aData['FTAgnName']?></td>
                                                    <td><?=$aData['FTBchName']?></td>
                                                    <td><?=$aData['FTMerName']?></td>
                                                    <td><?=$aData['FTShpName']?></td>
                                                    <td align='center'>
                                                    <?php if($this->session->userdata('nSesUsrBchCount')!=1){ ?>
                                                    <img onclick='JSxRddBchRemoveRow(<?=$nKey?>)' class='xCNIconTable xCNIconDel' src='<?php echo  base_url().'/application/modules/common/assets/images/icons/delete.png'?>' >
                                                    <?php   } ?>
                                                    </td>
                                                </tr>
                                                    <?php
                                                                }
                                                        }else{ 
                                                    
                                                            ?>
                                                              <?php if($this->session->userdata('nSesUsrBchCount')==0){ ?>
                                                       <tr id="otrRemoveTrBch"><td   colspan="7" align="center"> <?php echo language('document/conditionredeem/conditionredeem','tRdhGroupNotFound')?> </td></tr>
                                                 <?php    
                                                              }  
                                                                }

                                                ?>
                                            </tbody>
                                        </table>
                                </div>

                            </div>


                         </div>
                        </div>
                     </div>
              


<!-- </div> -->

</div>

<div  class="modal fade" id="odvRddConditionRedeemCRModalCstPri" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
    <div class="modal-header">
                <h5 class="xCNHeardModal modal-title" style="display:inline-block"><?=language('document/conditionredeem/conditionredeem','tRdhCreateGroupCrPpl')?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
      <div class="modal-body">
 
        <div class='row'>
                <div class='col-lg-12'>
                        <div class='form-group'>
                            <label class="xCNLabelFrm"><?php echo language('document/conditionredeem/conditionredeem','tRdhCreateGroupCrPplName')?></label>
                            <div class='input-group'>
                                <input type='text' class='form-control xCNHide xWRddAllInput' id='oetRddPplCode' name='oetRddPplCode' maxlength='5'>
                                <input type='text' class='form-control xWPointerEventNone xWCPHAllInput' id='oetRddPplName' name='oetRddPplName' readonly>
                                <span class='input-group-btn'>
                                    <button id='obtRddBrowsePpl' type='button' class='btn xCNBtnBrowseAddOn'><img class='xCNIconFind'></button>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class='col-lg-12'>
                        <div class='form-group'>
                        <label class="xCNLabelFrm"><?php echo language('document/conditionredeem/conditionredeem','tRdhGroupConditionRedeemGroupType')?></label>
                      
                                        <select class="form-control" name="ocmRddPplModalType" id="ocmRddPplModalType">
                                        <option value="1"><?php echo language('document/conditionredeem/conditionredeem','tRdhGroupConditionRedeemTypeInclude')?></optoion>
                                        <option value="2"><?php echo language('document/conditionredeem/conditionredeem','tRdhGroupConditionRedeemTypeExclude')?></optoion>
                                        </select>
                           
                        </div>
                    </div>


            </div>
    
      </div>
      <div class="modal-footer">
        <button type="button"  class="btn xCNBTNPrimery" id="obtRddCreatePpl" ><?=language('document/conditionredeem/conditionredeem','tRdhCreateGroupCrPplAdd')?></button>
        <button type="button" class="btn xCNBTNDefult" data-dismiss="modal"><?=language('document/conditionredeem/conditionredeem','tRdhCreateGroupCrPplClose')?></button>
      </div>
    </div>
  </div>
</div>




<div  class="modal fade" id="odvRddConditionRedeemCRModalBch" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
    <div class="modal-header">
        <h5 class="xCNHeardModal modal-title" style="display:inline-block"><?=language('document/conditionredeem/conditionredeem','tRdhCreateGroupCrBch')?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class='row'>

            <div class='col-lg-12'>
                <div class='form-group'>
                    <label class="xCNLabelFrm"><?=language('document/couponsetup/couponsetup','tCPHAgency')?></label>
                    <div class='input-group'>
                        <input type='text' class='form-control xCNHide xWCPHAllInput' id='oetRddAgnCodeTo' name='oetRddAgnCodeTo' value="<?=$this->session->userdata('tSesUsrAgnCode')?>" maxlength='5'>
                        <input type='text' class='form-control xWPointerEventNone xWCPHAllInput' id='oetRddAgnNameTo' name='oetRddAgnNameTo'  value="<?=$this->session->userdata('tSesUsrAgnName')?>" readonly>
                        <span class='input-group-btn'>
                            <button id='obtCPHBrowseAgnTo' type='button' class='btn xCNBtnBrowseAddOn' <?php    if($this->session->userdata('tSesUsrLevel')!='HQ'){ echo 'disabled'; } ?>><img class='xCNIconFind'></button>
                        </span>
                    </div>
                </div>
            </div>

            <div class='col-lg-12'>
                <div class='form-group'>
                    <label class="xCNLabelFrm"><?=language('company/branch/branch','tBCHTitle')?></label>
                    <div class='input-group'>
                        <input type='text' class='form-control xCNHide xWRddAllInput' id='oetRddBchCodeTo' name='oetRddBchCodeTo' maxlength='5'>
                        <input type='text' class='form-control xWPointerEventNone xWRddAllInput' id='oetRddBchNameTo' name='oetRddBchNameTo' readonly>
                        <span class='input-group-btn'>
                            <button id='obtRddBrowseBchTo' type='button' class='btn xCNBtnBrowseAddOn'><img class='xCNIconFind'></button>
                        </span>
                    </div>
                </div>
            </div>

            <div class='col-lg-12' >
                <div class='form-group'>
                <label class="xCNLabelFrm"><?=language('company/merchant/merchant','tMerchantTitle')?></label>
                    <div class='input-group'>
                        <input type='text' class='form-control xCNHide xWRddAllInput' id='oetRddMerCodeTo' name='oetRddMerCodeTo' maxlength='5'>
                        <input type='text' class='form-control xWPointerEventNone xWRddAllInput' id='oetRddMerNameTo' name='oetRddMerNameTo' readonly>
                        <span class='input-group-btn'>
                            <button id='obtRddBrowseMerTo' type='button' class='btn xCNBtnBrowseAddOn'><img class='xCNIconFind'></button>
                        </span>
                    </div>
                </div>
            </div>

            <div class='col-lg-12' >
                <div class='form-group'>
                <label class="xCNLabelFrm"><?=language('company/shop/shop','tSHPTitle')?></label>
                    <div class='input-group'>
                        <input type='text' class='form-control xCNHide xWRddAllInput' id='oetRddShpCodeTo' name='oetRddShpCodeTo' maxlength='5'>
                        <input type='text' class='form-control xWPointerEventNone xWRddAllInput' id='oetRddShpNameTo' name='oetRddShpNameTo' readonly>
                        <span class='input-group-btn'>
                            <button id='obtRddBrowseShpTo' type='button' class='btn xCNBtnBrowseAddOn'><img class='xCNIconFind'></button>
                        </span>
                    </div>
                </div>
            </div>

            <div class='col-lg-12'>
                <div class='form-group'>
                    <label class="xCNLabelFrm"><?php echo language('document/conditionredeem/conditionredeem','tRdhGroupConditionRedeemGroupType')?></label>
                    <select class="form-control" name="ocmRddBchModalType" id="ocmRddBchModalType">
                        <option value="1"><?php echo language('document/conditionredeem/conditionredeem','tRdhGroupConditionRedeemTypeInclude')?></optoion>
                        <option value="2"><?php echo language('document/conditionredeem/conditionredeem','tRdhGroupConditionRedeemTypeExclude')?></optoion>
                    </select>
                </div>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button"  class="btn xCNBTNPrimery" id="obtRddCreateBch" ><?=language('common/main/main','เพิ่ม')?></button>
        <button type="button" class="btn xCNBTNDefult" data-dismiss="modal"><?=language('common/main/main','ปิด')?></button>
      </div>
    </div>
  </div>
</div>


<script>

   /*===== Begin Browse Option ======================================================= */
   var oRptCstPriOption = function(poReturnInputCstPri){
   
        let aArgReturnCstPri       = poReturnInputCstPri.aArgReturn;
        let tInputReturnCodeCstPri = poReturnInputCstPri.tReturnInputCode;
        let tInputReturnNameCstPri = poReturnInputCstPri.tReturnInputName;
        let oOptionReturnCstPri    = {
            Title: ['product/pdtpricelist/pdtpricelist','tPPLTitle'],
            Table:{Master:'TCNMPdtPriList',PK:'FTPplCode',PKName:'FTPplName'},
            Join :{
                Table:	['TCNMPdtPriList_L'],
                On:['TCNMPdtPriList_L.FTPplCode = TCNMPdtPriList.FTPplCode AND TCNMPdtPriList_L.FNLngID = '+nLangEdits]
            },
            GrideView:{
                ColumnPathLang	: 'product/pdtpricelist/pdtpricelist',
                ColumnKeyLang	: ['tPPLTBCode','tPPLTBName'],
                ColumnsSize     : ['15%','75%'],
                WidthModal      : 50,
                DataColumns		: ['TCNMPdtPriList.FTPplCode','TCNMPdtPriList_L.FTPplName'],
                DataColumnsFormat : ['',''],
                Perpage			: 10,
                OrderBy			: ['TCNMPdtPriList_L.FTPplCode ASC'],
            },
            CallBack:{
                ReturnType	: 'S',
                Value		: [tInputReturnCodeCstPri,"TCNMPdtPriList.FTPplCode"],
                Text		: [tInputReturnNameCstPri,"TCNMPdtPriList_L.FTPplName"]
            },
         
            RouteAddNew: 'pdtpricelist',
            BrowseLev: 0
        };
        return oOptionReturnCstPri;
    };

$('#obtTabConditionRedeemHDCRPpl').unbind().click(function(){
    var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                $('#oetRddPplCode').val('');
                $('#oetRddPplName').val('');
                $("#odvRddConditionRedeemCRModalCstPri").modal({backdrop: "static", keyboard: false});
                $("#odvRddConditionRedeemCRModalCstPri").modal({show: true});
        }else{
            JCNxShowMsgSessionExpired();
        }
});

$('#obtRddCreatePpl').unbind().click(function(){
    var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSxConsAppendRowAndCheckDuplicateDataPpl();
       

        }else{
            JCNxShowMsgSessionExpired();
        }
});

  $('#obtRddBrowsePpl').unbind().click(function(){
    var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSxCheckPinMenuClose(); // Hidden Pin Menu
            window.oRptRddCstPriOptionFrom = undefined;
            oRptRddCstPriOptionFrom        = oRptCstPriOption({
                'tReturnInputCode'  : 'oetRddPplCode',
                'tReturnInputName'  : 'oetRddPplName',
      
                'aArgReturn'        : ['FTPplCode','FTPplName']
            });
            JCNxBrowseData('oRptRddCstPriOptionFrom');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });



function JSnRddConditionRedeemPplDuplicate(paData){

    let nLenIn = $('input[name^="ohdRddPplCode["]').length
    let aEchDataIn = JSxCreateArray(nLenIn,1);
    //Include
    $('input[name^="ohdRddPplCode["]').each(function(index){
        let tCstPriCod = $(this).val();
        aEchDataIn[index]=tCstPriCod;
    });

    // console.log("aEchDataIn",aEchDataIn);
    // console.log("aEchDataEx",aEchDataEx);

    let nAproveAppend = 0;
    for(i=0;i<aEchDataIn.length;i++){
        if(aEchDataIn[i]==paData.tCstPriCode){
            nAproveAppend++;
        }
    }
 
    // console.log(nAproveAppend);
    return nAproveAppend;
}


        /*===== Begin Event Next Function Browse ========================================== */
    // Functionality : 
    // Parameter : Event Next Func Modal
    // Create : 11/02/2020 Nattakit(Nale)
    // Return : Set Element And value
    // Return Type : -
    function JSxConsAppendRowAndCheckDuplicateDataPpl(){
        if($('#oetRddPplCode').val()!='' && $('#oetRddPplCode').val() != "NULL"){
            let nRddPplModalType = $('#ocmRddPplModalType').val();
            let tRddPplCode      = $('#oetRddPplCode').val();
            let tRddPplName      = $('#oetRddPplName').val();
            var tRddPplModalTypeText = $("#ocmRddPplModalType option:selected").html();
            // console.log(aData);
            let aDataApr = { 
                tCstPriCode: tRddPplCode
            }
         
          let nAproveSta = JSnRddConditionRedeemPplDuplicate(aDataApr);
          let nLenIn = $('input[name^="ohdRddPplCode["]').length + 1;
         if(nAproveSta==0){
            $('#otrRemoveTrCstPri').remove();
          var i = Date.now();
          var tMarkUp ="";
                    tMarkUp +="<tr class='otrInclude' id='otrRddPPlRowID"+i+"'>";
                    tMarkUp +="<td align='center' id='otdColRowID_"+tRddPplCode+"'>"+nLenIn+"</td>";
                    tMarkUp +="<td><input type='hidden' name='ohdRdhPplStaType[]' class='ohdRdhPplStaType' value='"+nRddPplModalType+"'>"+tRddPplModalTypeText+"</td>";
                    tMarkUp +="<td><input type='hidden' name='ohdRddPplCode[]' class='ohdRddPplCode' tRddPplname='"+tRddPplName+"' value='"+tRddPplCode+"'>"+tRddPplName+"</td>";
                    tMarkUp +="<td align='center'><img onclick='JSxRddPplRemoveRow("+i+")' class='xCNIconTable xCNIconDel' src='<?php echo  base_url().'/application/modules/common/assets/images/icons/delete.png'?>' ></td>";
                    tMarkUp +="</tr>";
                $('#otbConditionRedeemHDCRPpl').append(tMarkUp);
                $('#odvRddConditionRedeemCRModalCstPri').modal('hide');
            }else{

             alert('Data Select Duplicate.');

            }

        }else{

            alert('กรุณาเลือกกลุ่มราคา');

        }
    }

    function JSxRddPplRemoveRow(ptCode){

        $('#otrRddPPlRowID'+ptCode).remove();

        $('input[name^="ohdRddPplCode["]').each(function(index){
            let tCstPriCod = $(this).val();
        $('#otdColRowID_'+tCstPriCod).text(index+1);
        });


    }



    /////----------------------------ฺBRANCH---///--------------------------------------------------------------




    $('#obtTabConditionRedeemHDCRBch').unbind().click(function(){
    var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                $('#oetRddBchCodeTo').val('');
                $('#oetRddBchNameTo').val('');
                $('#oetRddMerCodeTo').val('');
                $('#oetRddMerNameTo').val('');
                $('#oetRddShpCodeTo').val('');
                $('#oetRddShpNameTo').val('');
                $("#odvRddConditionRedeemCRModalBch").modal({backdrop: "static", keyboard: false});
                $("#odvRddConditionRedeemCRModalBch").modal({show: true});
        }else{
            JCNxShowMsgSessionExpired();
        }
});

$('#obtRddCreateBch').unbind().click(function(){
    var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSxConsAppendRowAndCheckDuplicateDataBch();
        }else{
            JCNxShowMsgSessionExpired();
        }
});

  $('#obtRddBrowsePpl').unbind().click(function(){
    var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSxCheckPinMenuClose(); // Hidden Pin Menu
            window.oRptRddCstPriOptionFrom = undefined;
            oRptRddCstPriOptionFrom        = oRptCstPriOption({
                'tReturnInputCode'  : 'oetRddPplCode',
                'tReturnInputName'  : 'oetRddPplName',

                'aArgReturn'        : ['FTPplCode','FTPplName']
            });
            JCNxBrowseData('oRptRddCstPriOptionFrom');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });



function JSnRddConditionRedeemBchDuplicate(paData){


    let nLenIn = $('input[name^="ohdRddConditionRedeemBchCode["]').length
    let aEchDataIn = JSxCreateArray(nLenIn,4);
    //Include
    $('input[name^="ohdRddConditionRedeemAgnCode["]').each(function(index){
        let tAgnCode = $(this).val();
        aEchDataIn[index][0]=tAgnCode;
    });
    $('input[name^="ohdRddConditionRedeemBchCode["]').each(function(index){
        let tBchCode = $(this).val();
        aEchDataIn[index][1]=tBchCode;
    });
    $('input[name^="ohdRddConditionRedeemMerCode["]').each(function(index){
        let tMerCode = $(this).val();
        aEchDataIn[index][2]=tMerCode;
    });
    $('input[name^="ohdRddConditionRedeemShpCode["]').each(function(index){
        let tShpCode = $(this).val();
        aEchDataIn[index][3]=tShpCode;
    });


    // console.log("aEchDataIn",aEchDataIn);
    // console.log("aEchDataEx",aEchDataEx);

    let nAproveAppend = 0;
    for(i=0;i<aEchDataIn.length;i++){
        if(aEchDataIn[i][0]==paData.tRddAgnCodeTo && aEchDataIn[i][1]==paData.tRddBchCodeTo && aEchDataIn[i][2]==paData.tRddMerCodeTo && aEchDataIn[i][3]==paData.tRddShpCodeTo){
            nAproveAppend++;
        }
    }

    // console.log(nAproveAppend);
    return nAproveAppend;
}


        /*===== Begin Event Next Function Browse ========================================== */
    // Functionality : 
    // Parameter : Event Next Func Modal
    // Create : 11/02/2020 Nattakit(Nale)
    // Return : Set Element And value
    // Return Type : -
    function JSxConsAppendRowAndCheckDuplicateDataBch(){

        var nRDHUsrIsAgnLevel = $('#ohdRDHUsrIsAgnLevel').val();
        var tSesUsrLevel = $('#ohdRDHSesUsrLevel').val();
        
        // if(nRDHUsrIsAgnLevel==1 || tSesUsrLevel=='HQ'){ //กรณีเป็นผู้ใช้ AD
        //    var tValidateElement =  $('#oetRddAgnCodeTo').val();
        // }else{
        //     var tValidateElement =  $('#oetRddBchCodeTo').val();
        // }

        var tRddAgnCodeTo      = $('#oetRddAgnCodeTo').val();
        var tRddBchCodeTo      = $('#oetRddBchCodeTo').val();

        // alert(tValidateElement);
        if( tRddAgnCodeTo != "" || tRddBchCodeTo != "" ){
            let nRddBchModalType = $('#ocmRddBchModalType').val();
            var tRddBchModalTypeText = $("#ocmRddBchModalType option:selected").html();
            let tRddAgnNameTo      = $('#oetRddAgnNameTo').val();
            let tRddBchNameTo      = $('#oetRddBchNameTo').val();
            let tRddMerCodeTo      = $('#oetRddMerCodeTo').val();
            let tRddMerNameTo      = $('#oetRddMerNameTo').val();
            let tRddShpCodeTo      = $('#oetRddShpCodeTo').val();
            let tRddShpNameTo      = $('#oetRddShpNameTo').val();
            // console.log(aData);
            let aDataApr = { 
                tRddAgnCodeTo:tRddAgnCodeTo,
                tRddAgnNameTo:tRddAgnNameTo,
                tRddBchCodeTo:tRddBchCodeTo,
                tRddBchNameTo:tRddBchNameTo,
                tRddMerCodeTo:tRddMerCodeTo,
                tRddMerNameTo:tRddMerNameTo,
                tRddShpCodeTo:tRddShpCodeTo,
                tRddShpNameTo:tRddShpNameTo,
            }

            let nAproveSta = JSnRddConditionRedeemBchDuplicate(aDataApr);
            let nLenIn = $('input[name^="ohdRddConditionRedeemBchCode["]').length + 1;
            if(nAproveSta==0){
                $('#otrRemoveTrBch').remove();
                var tMarkUp =  '';
                var i = Date.now();
                tMarkUp +="<tr class='otrInclude' id='otrRddBchRowID"+i+"'>";
                tMarkUp +="<td align='center' class='otdColRowID_Bch' >"+nLenIn+"</td>";
                tMarkUp +="<td >"+tRddBchModalTypeText+"</td>";
                tMarkUp +="<td>";
                tMarkUp +="<input type='hidden' name='ohdRddConditionRedeemAgnCode["+i+"]' class='ohdRddConditionRedeemAgnCode' tRddAgnName='"+aDataApr.tRddAgnNameTo+"' value='"+aDataApr.tRddAgnCodeTo+"'>";
                tMarkUp +="<input type='hidden' name='ohdRddConditionRedeemBchCode["+i+"]' class='ohdRddConditionRedeemBchCode' tRddBchName='"+aDataApr.tRddBchNameTo+"' value='"+aDataApr.tRddBchCodeTo+"'>";
                tMarkUp +="<input type='hidden' name='ohdRddConditionRedeemMerCode["+i+"]' class='ohdRddConditionRedeemMerCode' tRddMerName='"+aDataApr.tRddMerNameTo+"' value='"+aDataApr.tRddMerCodeTo+"'>";
                tMarkUp +="<input type='hidden' name='ohdRddConditionRedeemShpCode["+i+"]' class='ohdRddConditionRedeemShpCode' tRddShpName='"+aDataApr.tRddShpNameTo+"' value='"+aDataApr.tRddShpCodeTo+"'>";
                tMarkUp +="<input type='hidden' name='ohdRddBchModalType["+i+"]' class='ohdRddBchModalType' value='"+nRddBchModalType+"'>";
                tMarkUp +=aDataApr.tRddAgnNameTo+"</td>";
                tMarkUp +="<td>"+aDataApr.tRddBchNameTo+"</td>";
                tMarkUp +="<td>"+aDataApr.tRddMerNameTo+"</td>";
                tMarkUp +="<td>"+aDataApr.tRddShpNameTo+"</td>";
                tMarkUp +="<td align='center'><img onclick='JSxRddBchRemoveRow("+i+")' class='xCNIconTable xCNIconDel' src='<?php echo  base_url().'/application/modules/common/assets/images/icons/delete.png'?>' ></td>";
                tMarkUp +="</tr>";

                $('#otbConditionRedeemHDCRBch').append(tMarkUp);
                $('#odvRddConditionRedeemCRModalBch').modal('hide');
            }else{
                FSvCMNSetMsgWarningDialog('Data Select Duplicate.');
            }
        }else{
            FSvCMNSetMsgWarningDialog('กรุณาเลือกเงื่อนไข');
        }
    }

    function JSxRddBchRemoveRow(ptCode){

        $('#otrRddBchRowID'+ptCode).remove();

        $('.otdColRowID_Bch').each(function(index){
        
         $(this).text(index+1);

        });


    }



$('#obtCPHBrowseAgnTo').unbind().click(function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSxCheckPinMenuClose(); // Hidden Pin Menu
            window.oRddAgencyOptionTo   = undefined;
            oRddAgencyOptionTo          = oRddAgencyOption({
                'tReturnInputCode'  : 'oetRddAgnCodeTo',
                'tReturnInputName'  : 'oetRddAgnNameTo',
        
            });
            JCNxBrowseData('oRddAgencyOptionTo');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });


$('#obtRddBrowseBchTo').unbind().click(function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSxCheckPinMenuClose(); // Hidden Pin Menu
            window.oRddBranchOptionTo   = undefined;
            oRddBranchOptionTo          = oRddBranchOption({
                'tReturnInputCode'  : 'oetRddBchCodeTo',
                'tReturnInputName'  : 'oetRddBchNameTo',
                'tNextFuncName'     : 'JSxRddConsNextFuncBrowseBch',
            });
            JCNxBrowseData('oRddBranchOptionTo');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });


    $('#obtRddBrowseMerTo').unbind().click(function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSxCheckPinMenuClose(); // Hidden Pin Menu
            window.oRddMerChantOptionTo = undefined;
            oRddMerChantOptionTo        = oRddMerChantOption({
                'tReturnInputCode'  : 'oetRddMerCodeTo',
                'tReturnInputName'  : 'oetRddMerNameTo',
                'tNextFuncName'     : 'JSxRddConsNextFuncBrowseMerChant',
                // 'aArgReturn'        : ['FTMerCode','FTMerName']
            });
            JCNxBrowseData('oRddMerChantOptionTo');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });


    $('#obtRddBrowseShpTo').unbind().click(function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSxCheckPinMenuClose(); // Hidden Pin Menu
  
            let tRddBranchForm  = $('#oetRddBchCodeTo').val();
            let tRddBranchTo    = $('#oetRddBchCodeTo').val();
            window.oRddShopOptionTo = undefined;
            oRddShopOptionTo        = oRddShopOption({
                'tReturnInputCode'  : 'oetRddShpCodeTo',
                'tReturnInputName'  : 'oetRddShpNameTo',
                'tRddBranchForm'    : tRddBranchForm,
                'tRddBranchTo'      : tRddBranchTo,
                'tNextFuncName'     : 'JSxRddConsNextFuncBrowseShp',
     
            });
            JCNxBrowseData('oRddShopOptionTo');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });



          
    //เลือกสาขา
    var oRddAgencyOption = function(poReturnInput) {
        var tInputReturnCode = poReturnInput.tReturnInputCode;
        var tInputReturnName = poReturnInput.tReturnInputName;
        var tBchCodeWhere = poReturnInput.tBchCodeWhere;

        var oOptionReturn = {
            Title: ['ticket/agency/agency', 'tAggTitle'],
            Table: {
                Master: 'TCNMAgency',
                PK: 'FTAgnCode'
            },
            Join: {
                Table: ['TCNMAgency_L'],
                On: ['TCNMAgency_L.FTAgnCode = TCNMAgency.FTAgnCode AND TCNMAgency_L.FNLngID = ' + nLangEdits]
            },
            GrideView: {
                ColumnPathLang: 'ticket/agency/agency',
                ColumnKeyLang: ['tAggCode', 'tAggName'],
                ColumnsSize: ['15%', '85%'],
                WidthModal: 50,
                DataColumns: ['TCNMAgency.FTAgnCode', 'TCNMAgency_L.FTAgnName'],
                DataColumnsFormat: ['', ''],
                Perpage: 10,
                OrderBy: ['TCNMAgency.FDCreateOn DESC'],
            },
            CallBack: {
                ReturnType: 'S',
                Value: [tInputReturnCode, "TCNMAgency.FTAgnCode"],
                Text: [tInputReturnName, "TCNMAgency_L.FTAgnName"],
            },
            RouteAddNew: 'agency',
            BrowseLev: 0,
            NextFunc: {
                FuncName: 'JSxClearBrowseConditionAgn',
                ArgReturn: ['FTAgnCode']
            }
        }
        return oOptionReturn;
    }

    function JSxClearBrowseConditionAgn(ptData) {
        // aData = JSON.parse(ptData);
        if (ptData != '' || ptData != 'NULL') {

            $('#oetRddBchCodeTo').val('');
            $('#oetRddBchNameTo').val('');
            $('#oetRddShpCodeTo').val('');
            $('#oetRddShpNameTo').val('');
            $('#oetRddMerCodeTo').val('');
            $('#oetRddMerNameTo').val('');

        }
    }



      /*===== Begin Browse Option ======================================================= */
      var oRddBranchOption = function(poRddReturnInputBch){
        let tRddNextFuncNameBch    = poRddReturnInputBch.tNextFuncName;
        let aRddArgReturnBch       = poRddReturnInputBch.aArgReturn;
        let tRddInputReturnCodeBch = poRddReturnInputBch.tReturnInputCode;
        let tRddInputReturnNameBch = poRddReturnInputBch.tReturnInputName;

        var tUsrLevel     = "<?php echo $this->session->userdata("tSesUsrLevel"); ?>";
        var tBchCodeMulti = "<?php echo $this->session->userdata("tSesUsrBchCodeMulti"); ?>";
        var nCountBch     = "<?php echo $this->session->userdata("nSesUsrBchCount"); ?>";
        var tMerCode = $('#oetRddMerCodeTo').val();
        var tWhere = "";

        if(nCountBch == 1){
            $('#obtRddBrowseBchTo').attr('disabled',true);
        }
        // if(tUsrLevel != "HQ"){
        //     tWhere += " AND TCNMBranch.FTBchCode IN ("+tBchCodeMulti+") ";
        // }else{
        //     tWhere += "";
        // }

       var tRddAgnCodeTo =  $('#oetRddAgnCodeTo').val();
       if(tRddAgnCodeTo!=''){
             tWhere += " AND TCNMBranch.FTAgnCode ='"+tRddAgnCodeTo+"' ";
       }
        // if(tMerCode!=''){
        //     tWhere += " AND TCNMBranch.FTMerCode = '"+tMerCode+"' ";
        // }

        let oRddOptionReturnBch    = {
            Title: ['company/branch/branch','tBCHTitle'],
            Table:{Master:'TCNMBranch',PK:'FTBchCode'},
            Join :{
                Table:	['TCNMBranch_L'],
                On:['TCNMBranch_L.FTBchCode = TCNMBranch.FTBchCode AND TCNMBranch_L.FNLngID = '+nLangEdits]
            },
            Where : {
                        Condition : [tWhere]
                    },
            GrideView:{
                ColumnPathLang	: 'company/branch/branch',
                ColumnKeyLang	: ['tBCHCode','tBCHName'],
                ColumnsSize     : ['15%','75%'],
                WidthModal      : 50,
                DataColumns		: ['TCNMBranch.FTBchCode','TCNMBranch_L.FTBchName'],
                DataColumnsFormat : ['',''],
                Perpage			: 10,
                OrderBy			: ['TCNMBranch_L.FTBchCode ASC'],
            },
            CallBack:{
                ReturnType	: 'S',
                Value		: [tRddInputReturnCodeBch,"TCNMBranch.FTBchCode"],
                Text		: [tRddInputReturnNameBch,"TCNMBranch_L.FTBchName"]
            },
            NextFunc : {
                FuncName    : tRddNextFuncNameBch,
                // ArgReturn   : aMerArgReturn
            },
            RouteAddNew: 'branch',
            BrowseLev: 0
        };
        return oRddOptionReturnBch;
    };


    // Browse Merchant Option
    var oRddMerChantOption  = function(poReturnInputMer){
        let tMerInputReturnCode = poReturnInputMer.tReturnInputCode;
        let tMerInputReturnName = poReturnInputMer.tReturnInputName;
        let tMerNextFuncName    = poReturnInputMer.tNextFuncName;
        let aMerArgReturn       = poReturnInputMer.aArgReturn;
        let oMerOptionReturn    = {
            Title: ['company/merchant/merchant','tMerchantTitle'],
            Table: {Master:'TCNMMerchant',PK:'FTMerCode'},
            Join: {
                Table: ['TCNMMerchant_L'],
                On: ['TCNMMerchant.FTMerCode = TCNMMerchant_L.FTMerCode AND TCNMMerchant_L.FNLngID = '+nLangEdits]
            },
            GrideView: {
                ColumnPathLang	: 'company/merchant/merchant',
                ColumnKeyLang	: ['tMerCode','tMerName'],
                ColumnsSize     : ['15%','75%'],
                WidthModal      : 50,
                DataColumns		: ['TCNMMerchant.FTMerCode','TCNMMerchant_L.FTMerName'],
                DataColumnsFormat : ['',''],
                Perpage			: 5,
                OrderBy			: ['TCNMMerchant.FTMerCode ASC'],
            },
            CallBack: {
                ReturnType	: 'S',
                Value		: [tMerInputReturnCode,"TCNMMerchant.FTMerCode"],
                Text		: [tMerInputReturnName,"TCNMMerchant_L.FTMerName"],
            },
            NextFunc : {
                FuncName    : tMerNextFuncName,
                // ArgReturn   : aMerArgReturn
            },
            RouteAddNew: 'merchant',
            BrowseLev: 0,
        };
        return oMerOptionReturn;
    }


 
 // Browse Shop Option
 var oRddShopOption = function(poReturnInputShp){
        let tShpNextFuncName        = poReturnInputShp.tNextFuncName;
        let aShpArgReturn           = poReturnInputShp.aArgReturn;
        let tShpInputReturnCode     = poReturnInputShp.tReturnInputCode;
        let tShpInputReturnName     = poReturnInputShp.tReturnInputName;
       
        let tShpRddBranchForm       = poReturnInputShp.tRddBranchForm;
        let tShpRddBranchTo         = poReturnInputShp.tRddBranchTo;
        let tShpWhereShop           = "";
        let tShpWhereShopAndBch     = "";

        // Case Report Type POS,VD,LK
      
                // Report Pos (รานงานการขาย)
                // tShpWhereShop       = " AND (TCNMShop.FTShpStaActive = 1) AND (TCNMShop.FTShpType = 1)";
                // tShpWhereShopAndBch = " AND ((TCNMShop.FTBchCode BETWEEN "+tShpRddBranchForm+" AND "+tShpRddBranchTo+") OR (TCNMShop.FTBchCode BETWEEN "+tShpRddBranchTo+" AND "+tShpRddBranchForm+"))";
                
                // Report Pos (รานงานการขาย) + Report Vending (รานงานตู้ขายสินค้า)
                tShpWhereShop       = " AND (TCNMShop.FTShpStaActive = 1)";
                tShpWhereShopAndBch = " AND ((TCNMShop.FTBchCode BETWEEN "+tShpRddBranchForm+" AND "+tShpRddBranchTo+") OR (TCNMShop.FTBchCode BETWEEN "+tShpRddBranchTo+" AND "+tShpRddBranchForm+"))";
   
        if(typeof tShpRddBranchForm === 'undefined'  && typeof tShpRddBranchTo === 'undefined'){
            // แสดงข้อมูล ร้านค้าทั้งหมดตามประเภทของรายงาน
            var oShopOptionReturn       = {
                Title   : ['company/shop/shop','tSHPTitle'],
                Table   : {Master:'TCNMShop', PK:'FTShpCode'},
                Join    : {
                    Table   : ['TCNMShop_L', 'TCNMBranch_L'],
                    On      : [
                        'TCNMShop.FTBchCode = TCNMShop_L.FTBchCode      AND TCNMShop.FTShpCode = TCNMShop_L.FTShpCode AND TCNMShop_L.FNLngID = '+nLangEdits,
                        'TCNMShop.FTBchCode = TCNMBranch_L.FTBchCode    AND TCNMBranch_L.FNLngID = '+nLangEdits
                    ]
                },
                Where :{
                    Condition : [tShpWhereShop]
                },
                GrideView:{
                    ColumnPathLang	: 'company/shop/shop',
                    ColumnKeyLang	: ['tSHPTBBranch','tSHPTBCode','tSHPTBName'],
                    ColumnsSize     : ['15%','15%','75%'],
                    WidthModal      : 50,
                    DataColumns		: ['TCNMBranch_L.FTBchName', 'TCNMShop.FTShpCode', 'TCNMShop_L.FTShpName'],
                    DataColumnsFormat : ['','',''],
                    Perpage			: 10,
                    OrderBy			: ['TCNMShop.FTBchCode ASC,TCNMShop.FTShpCode ASC'],
                },
                CallBack:{
                    ReturnType	: 'S',
                    Value		: [tShpInputReturnCode,"TCNMShop.FTShpCode"],
                    Text		: [tShpInputReturnName,"TCNMShop_L.FTShpName"]
                },
                NextFunc : {
                    FuncName    : tShpNextFuncName,
                    // ArgReturn   : aShpArgReturn
                },
                RouteAddNew: 'shop',
                BrowseLev: 0
            };
        }else{
            if(tShpRddBranchForm == "" && tShpRddBranchTo == ""){
                // แสดงข้อมูล ร้านค้าทั้งหมดตามประเภทของรายงาน
                var oShopOptionReturn   = {
                    Title   : ['company/shop/shop','tSHPTitle'],
                    Table   : {Master:'TCNMShop', PK:'FTShpCode'},
                    Join    : {
                        Table   : ['TCNMShop_L', 'TCNMBranch_L'],
                        On      : [
                            'TCNMShop.FTBchCode = TCNMShop_L.FTBchCode      AND TCNMShop.FTShpCode = TCNMShop_L.FTShpCode AND TCNMShop_L.FNLngID = '+nLangEdits,
                            'TCNMShop.FTBchCode = TCNMBranch_L.FTBchCode    AND TCNMBranch_L.FNLngID = '+nLangEdits
                        ]
                    },
                    Where :{
                        Condition : [tShpWhereShop]
                    },
                    GrideView:{
                        ColumnPathLang	: 'company/shop/shop',
                        ColumnKeyLang	: ['tSHPTBBranch','tSHPTBCode','tSHPTBName'],
                        ColumnsSize     : ['15%','15%','75%'],
                        WidthModal      : 50,
                        DataColumns		: ['TCNMBranch_L.FTBchName', 'TCNMShop.FTShpCode', 'TCNMShop_L.FTShpName'],
                        DataColumnsFormat : ['','',''],
                        Perpage			: 10,
                        OrderBy			: ['TCNMShop.FTBchCode ASC,TCNMShop.FTShpCode ASC'],
                    },
                    CallBack:{
                        ReturnType	: 'S',
                        Value		: [tShpInputReturnCode,"TCNMShop.FTShpCode"],
                        Text		: [tShpInputReturnName,"TCNMShop_L.FTShpName"]
                    },
                    NextFunc : {
                        FuncName    : tShpNextFuncName,
                        ArgReturn   : aShpArgReturn
                    },
                    RouteAddNew: 'shop',
                    BrowseLev: 0
                };
            }else{
                // แสดงข้อมูลร้านค้า ตามสาขาที่เลือกไว้
                var oShopOptionReturn   = {
                    Title   : ['company/shop/shop','tSHPTitle'],
                    Table   : {Master:'TCNMShop', PK:'FTShpCode'},
                    Join    : {
                        Table   : ['TCNMShop_L', 'TCNMBranch_L'],
                        On      : [
                            'TCNMShop.FTBchCode = TCNMShop_L.FTBchCode      AND TCNMShop.FTShpCode = TCNMShop_L.FTShpCode AND TCNMShop_L.FNLngID = '+nLangEdits,
                            'TCNMShop.FTBchCode = TCNMBranch_L.FTBchCode    AND TCNMBranch_L.FNLngID = '+nLangEdits
                        ]
                    },
                    Where :{
                        Condition : [tShpWhereShop+tShpWhereShopAndBch]
                    },
                    GrideView:{
                        ColumnPathLang	: 'company/shop/shop',
                        ColumnKeyLang	: ['tSHPTBBranch','tSHPTBCode','tSHPTBName'],
                        ColumnsSize     : ['15%','15%','75%'],
                        WidthModal      : 50,
                        DataColumns		: ['TCNMBranch_L.FTBchName', 'TCNMShop.FTShpCode', 'TCNMShop_L.FTShpName'],
                        DataColumnsFormat : ['','',''],
                        Perpage			: 10,
                        OrderBy			: ['TCNMShop.FTBchCode ASC,TCNMShop.FTShpCode ASC'],
                    },
                    CallBack:{
                        ReturnType	: 'S',
                        Value		: [tShpInputReturnCode,"TCNMShop.FTShpCode"],
                        Text		: [tShpInputReturnName,"TCNMShop_L.FTShpName"]
                    },
                    NextFunc : {
                        FuncName    : tShpNextFuncName,
                        ArgReturn   : aShpArgReturn
                    },
                    RouteAddNew: 'shop',
                    BrowseLev: 0
                }
            }
        }
        return oShopOptionReturn;
    };


     
    /*===== Begin Event Next Function Browse ========================================== */
    // Functionality : Next Function Branch And Check Data Shop And Clear Data
    // Parameter : Event Next Func Modal
    // Create : 30/09/2019 Wasin(Yoshi)
    // update : 03/10/2019 Saharat(Golf)
    // Return : Clear Velues Data
    // Return Type : -
    function JSxRddConsNextFuncBrowseBch(poDataNextFunc){
        // if(typeof(poDataNextFunc) != 'undefined' && poDataNextFunc != "NULL"){
        //     let aDataNextFunc   = JSON.parse(poDataNextFunc);
        //     tBchCode      = aDataNextFunc[0];
        //     tBchName      = aDataNextFunc[1];
        // }

        // // ประกาศตัวแปร สาขา
        // var tRddBchCodeTo,tRddBchNameTo
        // tRddBchCodeTo   = $('#oetRddBchCodeTo').val();
        // tRddBchNameTo   = $('#oetRddBchNameTo').val();

        // // เช็คข้อมูลถ้ามีการ Browse จากสาขา ให้ default ถึงสาขา เป็นข้อมูลเดียวกัน 
        // if((typeof(tRddBchCodeTo) !== 'undefined' && tRddBchCodeTo == "")){
        //     $('#oetRddBchCodeTo').val(tBchCode);
        //     $('#oetRddBchNameTo').val(tBchName);
        // } 


        var tRddShopCodeTo
        tRddShopCodeTo      = $('#oetRddShpCodeTo').val();
        if( (typeof(tRddShopCodeTo) !== 'undefined' && tRddShopCodeTo != "")){
            $('#oetRddShpCodeTo').val('');
            $('#oetRddShpNameTo').val('');
        }
    }





    // Functionality : Next Function Shop And Check Data Pos And Clear Data
    // Parameter : Event Next Func Modal
    // Create : 30/09/2019 Wasin(Yoshi)
    // update : 03/10/2019 Sahart(Golf)
    // Return : Clear Velues Data
    // Return Type : -
    function JSxRddConsNextFuncBrowseShp(poDataNextFunc){

        // if(typeof(poDataNextFunc) != 'undefined' && poDataNextFunc != "NULL"){
        //     let aDataNextFunc   = JSON.parse(poDataNextFunc);
        //     tShpCode = aDataNextFunc[0];
        //     tShpName = aDataNextFunc[1];
        // }

        // // ประกาศตัวแปร ร้านค้า
        // var tRddShpCodeTo,tRddShpNameTo

        // tRddShpCodeTo   = $('#oetRddShpCodeTo').val();
        // tRddShpNameTo   = $('#oetRddShpNameTo').val();

        // // เช็คข้อมูลถ้ามีการ Browse จากร้านค้า ให้ default ถึงร้านค้า เป็นข้อมูลเดียวกัน 
        // if((typeof(tRddShpCodeTo) !== 'undefined' && tRddShpCodeTo == "")){
        //     $('#oetRddShpCodeTo').val(tShpCode);
        //     $('#oetRddShpNameTo').val(tShpName);
        // } 

 

        // var tRddPosCodeTo

        // tRddPosCodeTo   = $('#oetRddPosCodeTo').val();
        // if((typeof(tRddPosCodeTo) !== 'undefined' && tRddPosCodeTo != "")){

        //     $('#oetRddPosCodeTo').val('');
        //     $('#oetRddPosNameTo').val('');
        // }


        // // ประกาศตัวแปร ร้านค้าที่โอน
        // var tRddShpTCodeTo   = $('#oetRddShpTCodeTo').val();
        // var tRddShpTNameTo   = $('#oetRddShpTNameTo').val();

        // // เช็คข้อมูลถ้ามีการ Browse จากร้านค้าที่โอน ให้ default ถึงร้านค้าที่โอน เป็นข้อมูลเดียวกัน 
        // if((typeof(tRddShpTCodeTo) !== 'undefined' && tRddShpTCodeTo == "")){
        //     $('#oetRddShpTCodeTo').val(tShpCode);
        //     $('#oetRddShpTNameTo').val(tShpName);
        // } 

   

        // // ประกาศตัวแปร ร้านค้าที่รับโอน
        // var tRddShpRCodeTo   = $('#oetRddShpRCodeTo').val();
        // var tRddShpRNameTo   = $('#oetRddShpRNameTo').val();

        // // เช็คข้อมูลถ้ามีการ Browse จากร้านค้าที่รับโอน ให้ default ถึงร้านค้าที่รับโอน เป็นข้อมูลเดียวกัน 
        // if((typeof(tRddShpRCodeTo) !== 'undefined' && tRddShpRCodeTo == "")){
        //     $('#oetRddShpRCodeTo').val(tShpCode);
        //     $('#oetRddShpRNameTo').val(tShpName);
        // } 


    }


     // Functionality : Next Function MerChant And Check Data 
    // Parameter : Event Next Func Modal
    // Create : 04/10/2019 Saharat(Golf)
    // Return : Clear Velues Data
    // Return Type : -
    function  JSxRddConsNextFuncBrowseMerChant(poDataNextFunc){

        // if(typeof(poDataNextFunc) != 'undefined' && poDataNextFunc != "NULL"){
        //     let aDataNextFunc   = JSON.parse(poDataNextFunc);
        //     tMerCode      = aDataNextFunc[0];
        //     tMerName      = aDataNextFunc[1];
        // }


        // if((typeof(tMerCode) !== 'undefined' && tMerCode == "")){
        //    $('#oetRddMerCodeTo').val('');
        //    $('#oetRddMerNameTo').val('');  
        // }

        // ประกาศตัวแปร กลุ่มธุรกิจ
        var tRddMerCodeTo,tRddPdtNameTo
        tRddMerCodeTo   = $('#oetRddMerCodeTo').val();
        tRddMerNameTo   = $('#oetRddMerNameTo').val();

        // เช็คข้อมูลถ้ามีการ Browse จากกลุ่มธุรกิจ ให้ default ถึงกลุ่มธุรกิจ เป็นข้อมูลเดียวกัน 
        if( (typeof(tRddMerCodeTo) !== 'undefined' && tRddMerCodeTo == "")){
            $('#oetRddMerCodeTo').val(tMerCode);
            $('#oetRddMerNameTo').val(tMerName);
            $('#oetRddBchCodeTo').val('');
            $('#oetRddBchNameTo').val('');
            $('#oetRddShpCodeTo').val('');
            $('#oetRddShpNameTo').val('');
        }

   
}   


     
</script>