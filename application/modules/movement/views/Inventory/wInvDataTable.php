<?php 
    if($aDataList['rtCode'] == '1'){
        $nCurrentPage = $aDataList['rnCurrentPage'];
    }else{
        $nCurrentPage = '1';
    }
?>


<div class="row">
    <div class="col-md-12">
        <!-- <input type="hidden" id="nCurrentPageTB" value="<?=$nCurrentPage;?>"> -->
        <div class="table-responsive">
             <table class="table table-striped" style="width:100%">
					<thead>
						<tr>
							<th nowrap class="xCNTextBold" style="width:2%;text-align:center;"><?= language('movement/movement/movement','tMMTBOrder')?></th>
							<th nowrap class="xCNTextBold" style="width:5%;text-align:center;"><?= language('movement/movement/movement','tMMTBPdtCode')?></th>
                            <th nowrap class="xCNTextBold" style="width:15%;text-align:center;"><?= language('movement/movement/movement','tMMTBPdtName')?></th>
                            <?php if($this->session->userdata("tSesUsrLevel") == 'HQ'): ?>
                            <th nowrap class="xCNTextBold" style="width:15%;text-align:center;"><?= language('movement/movement/movement','tMMTListBanch')?></th>
                            <?php endif; ?>
                            <th nowrap class="xCNTextBold" style="width:5%;text-align:center;"><?= language('movement/movement/movement','tINVInventoryWarehouse')?></th>
                            <th nowrap class="xCNTextBold" style="width:5%;text-align:center;"><?= language('movement/movement/movement','tINVInventoryAmount')?></th>
                            <th nowrap class="xCNTextBold" style="width:5%;text-align:center;"><?= language('movement/movement/movement','tINVInventoryTemporaryWarehouse')?></th>
                            <th nowrap class="xCNTextBold" style="width:5%;text-align:center;"><?= language('movement/movement/movement','tINVInventoryTotal')?></th>
                        </tr>
					</thead>
					<tbody id="odvRGPList">
                        <?php if($aDataList['rtCode'] == 1 ):?>
                            <?php foreach($aDataList['raItems'] AS $key=>$aValue){  ?>
                                <tr class="xCNTextDetail2 otrReason" id="otrReason<?=$key?>" data-code="<?=$aValue['FTPdtCode']?>" data-name="<?=$aValue['FTPdtName']?>"  data-bchcode="<?=$aValue['FTBchCode']?>" data-bchname="<?=$aValue['FTBchName']?>" data-wahcode="<?=$aValue['FTWahCode']?>" data-wahname="<?=$aValue['FTWahName']?>"  >
                                    <td nowrap class="text-center" style="text-align: center;"><?=$key + 1 + ( ($nCurrentPage - 1) * $nRow ) ?></td>
                                    <td nowrap class="text-left"><?=$aValue['FTPdtCode']?></td>
                                    <td nowrap class="text-left">
                                    <?=$aValue['FTPdtName']?>
                                    <?php if($aValue['FTPdtForSystem']==5){ ?>
                                        <br><label class="xCNTextLink" onclick="JSvInvMmtPdtFhnDetail(<?=$key?>)" ><?= language('movement/movement/movement','tMMTCheckPdtFasion')?></label>
                                    <?php } ?>
                                    </td>
                                    <?php if($this->session->userdata("tSesUsrLevel") == 'HQ'): ?>
                                        <td nowrap class="text-left"><?= !empty($aValue['FTBchName']) ? $aValue['FTBchName']: ''; ?></td>
                                    <?php endif; ?>
                                    <td nowrap class="text-left"><?=$aValue['FTWahName']?></td>
                                    <td nowrap class="text-right"><?php echo number_format($aValue['FCStkQty'], $nOptDecimalShow);?></td>
                                    <td nowrap class="text-right"><?php echo number_format($aValue['FCXtdQtyInt'], $nOptDecimalShow);?></td>
                                    <td nowrap class="text-right"><?php echo number_format($aValue['FCXtdQtyBal'], $nOptDecimalShow);?></td>
                                </tr>
                            <?php } ?>
                        <?php else:?>
                            <tr><td class='text-center xCNTextDetail2' colspan='12' style="text-align: center;"><?= language('common/main/main','tCMNNotFoundData')?></td></tr>
                        <?php endif;?>
					</tbody>
			</table>
        </div>
    </div>
</div>

<div class="row" style="margin-bottom:10px;">
	<!-- เปลี่ยน -->
	<div class="col-md-6">
        <p><?= language('common/main/main','tResultTotalRecord')?> <?=$aDataList['rnAllRow']?> <?= language('common/main/main','tRecord')?> <?= language('common/main/main','tCurrentPage')?> <?=$aDataList['rnCurrentPage']?> / <?=$aDataList['rnAllPage']?></p>
    </div>
	<!-- เปลี่ยน -->
    <div class="col-md-6">
        <div class="xWPageReasonGrp btn-toolbar pull-right"> <!-- เปลี่ยนชื่อ Class เป็นของเรื่องนั้นๆ --> 
            <?php if($nPage == 1){ $tDisabledLeft = 'disabled'; }else{ $tDisabledLeft = '-';} ?>
            <button id="obtInvFristPage" data-ngotopage="1"  onclick="JSxInvClickPage(1)" class="btn btn-white btn-sm" <?php echo $tDisabledLeft ?>> <!-- เปลี่ยนชื่อ Onclick เป็นของเรื่องนั้นๆ --> 
                <i class="fa fa-chevron-left f-s-14 t-plus-1"></i><i class="fa fa-chevron-left f-s-14 t-plus-1"></i>
            </button>
            <button id="obtInvPreviousPage" data-ngotopage="<?=$nCurrentPage - 1;?>"  onclick="JSxInvClickPage('previous')" class="btn btn-white btn-sm" <?php echo $tDisabledLeft ?>> <!-- เปลี่ยนชื่อ Onclick เป็นของเรื่องนั้นๆ --> 
                <i class="fa fa-chevron-left f-s-14 t-plus-1"></i>
            </button>
            <?php for($i=max($nPage-2, 1); $i<=max(0, min($aDataList['rnAllPage'],$nPage+2)); $i++){?> <!-- เปลี่ยนชื่อ Parameter Loop เป็นของเรื่องนั้นๆ --> 
                <?php 
                    if($nPage == $i){ 
                        $tActive = 'active'; 
                        $tDisPageNumber = 'disabled';
                    }else{ 
                        $tActive = '';
                        $tDisPageNumber = '';
                    }
                ?>
                <!-- เปลี่ยนชื่อ Onclick เป็นของเรื่องนั้นๆ --> 
                <button id="obtInvPageNumber<?php echo $i?>" data-npagenumber="<?php echo $i?>" onclick="JSxInvClickPage('<?php echo $i?>')" type="button" class="btn xCNBTNNumPagenation <?php echo $tActive ?>" <?php echo $tDisPageNumber ?>><?php echo $i?></button>
            <?php } ?>
            <?php if($nPage >= $aDataList['rnAllPage']){  $tDisabledRight = 'disabled'; }else{  $tDisabledRight = '-';  } ?>
            <button id="obtInvNextPage"  data-ngotopage="<?=$nCurrentPage + 1;?>" onclick="JSxInvClickPage('next')" class="btn btn-white btn-sm" <?php echo $tDisabledRight ?>> <!-- เปลี่ยนชื่อ Onclick เป็นของเรื่องนั้นๆ --> 
                <i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
            </button>
            <button id="obtInvLastPage"  data-ngotopage="<?=$aDataList['rnAllPage']?>" onclick="JSxInvClickPage(<?=$aDataList['rnAllPage']?>)" class="btn btn-white btn-sm" <?php echo $tDisabledRight ?>> <!-- เปลี่ยนชื่อ Onclick เป็นของเรื่องนั้นๆ --> 
                <i class="fa fa-chevron-right f-s-14 t-plus-1"></i><i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
            </button>
        </div>
    </div>
</div>


<div id="odvInvMmtModalPdtFhn" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document" style="width: 1100px;">
        <input type='text' class='form-control xCNHide' id='oetInvPdtFhnPdtCode' name='oetInvPdtFhnPdtCode' value="" >
            <div class="modal-content">
                <div class="modal-header xCNModalHead">
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                            <label class="xCNTextModalHeard"><?php echo language('movement/movement/movement', 'tMMTCheckPdtFasionModal')?></label>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-right">
                            <button class="btn xCNBTNDefult xCNBTNDefult2Btn" data-dismiss="modal" ><?php echo language('common/main/main', 'tModalCancel')?></button>
                        </div>
                    </div>
                </div>
                
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-2 col-sm-2 col-xs-6"><?= language('movement/movement/movement','tMMTBPdtCode')?> :</div><div class="col-md-10 col-sm-10 col-xs-6"><label class="" id="olbPdtFhnPdtCode"><b><?= language('movement/movement/movement','tMMTBPdtCode')?></b></label></div>
                        <div class="col-md-2 col-sm-2 col-xs-6"><?= language('movement/movement/movement','tMMTBPdtName')?> :</div><div class="col-md-10 col-sm-10 col-xs-6"><label class="" id="olbPdtFhnPdtName"><b><?= language('movement/movement/movement','tMMTBPdtCode')?></b></label></div>
                    </div>
                    <hr>


                    
                        <div class="row">
                             <!-- Browse สาขา -->
                            <div class="col-md-3 col-sm-3 col-xs-6">
                                <?php 
                                    $tBCHCode = $this->session->userdata("tSesUsrBchCodeDefault");
                                    $tBCHName = $this->session->userdata("tSesUsrBchNameDefault");
                                ?>
                                <div class="form-group">
                                    <div class="input-group">
                                        <input type='text' class='form-control xCNHide xWRptAllInput' id='oetInvPdtFhnBchStaSelectAll' name='oetInvPdtFhnBchStaSelectAll' value=<?=$tBCHCode?>>
                                        <input type='text' class='form-control xCNHide xWRptAllInput' id='oetInvPdtFhnBchCodeSelect'   name='oetInvPdtFhnBchCodeSelect' value=<?=$tBCHCode?>>
                                        <input type='text' class='form-control xWPointerEventNone xWRptAllInput' id='oetInvPdtFhnBchNameSelect' name='oetInvPdtFhnBchNameSelect' placeholder="<?= language('movement/movement/movement','tMMTListBanch')?>" autocomplete="off" readonly value='<?=$tBCHName?>'>
                                        <span class="input-group-btn">
                                            
                                            <?php 
                                                if($this->session->userdata("tSesUsrLevel") == "HQ"){
                                                    $tDisabled = "";
                                                }else{
                                                    $nCountBch = $this->session->userdata("nSesUsrBchCount");
                                                    if($nCountBch == 1){
                                                        $tDisabled = "disabled";
                                                    }else{
                                                        $tDisabled = "";
                                                    }
                                                }
                                            ?>
                                            <button id="obtInvPdtFhnBrowseBranch" type="button" <?=$tDisabled?> class="btn xCNBtnDateTime">      
                                                <img  src="<?=base_url().'application/modules/common/assets/images/icons/find-24.png'?>">
                                            </button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                                 <!-- Browse สาขา -->

                         <!-- Browse คลังสินค้า -->
                        <div class="col-md-4 col-sm-4 col-xs-6">
                                    <?php 
                                        $tWahCode = $this->session->userdata("tSesUsrWahCode");
                                        $tWahName = $this->session->userdata("tSesUsrWahName");
                                    ?>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <input type='text' class='form-control xCNHide xWRptAllInput' id='oetInvPdtFhnWahStaSelectAll' name='oetInvPdtFhnWahStaSelectAll' value="<?=$tWahCode?>">
                                            <input type='text' class='form-control xCNHide xWRptAllInput' id='oetInvPdtFhnWahCodeSelect'   name='oetInvPdtFhnWahCodeSelect' value="<?=$tWahCode?>">
                                            <input type='text' class='form-control xWPointerEventNone xWRptAllInput' id='oetInvPdtFhnWahNameSelect' name='oetInvPdtFhnWahNameSelect' value="<?=$tWahName?>" placeholder="<?= language('movement/movement/movement','tMMTListWaHouse')?>" autocomplete="off" readonly>
                                            <span class="input-group-btn">
                                                <button id="obtInvPdtFhnBrowseWaHouse" type="button" class="btn xCNBtnDateTime">
                                                    <img  src="<?=base_url().'application/modules/common/assets/images/icons/find-24.png'?>">
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                            </div>
                             <!-- Browse คลังสินค้า -->

                            <!-- Browse รหัสควบคุมสต็อก -->
                             <div class="col-md-3 col-sm-3 col-xs-6">
                                <div class="form-group">
                                        <input class="form-control" name="oetInvPdtFhnRefCode" id="oetInvPdtFhnRefCode" value="" placeholder="<?= language('movement/movement/movement','รหัสควบคุมสต็อก')?>">
                                </div>
                             </div>         
                             <!-- กรองข้อมูล -->
                             <div class="col-md-2 col-sm-2 col-xs-6">
                                   <button id="" onclick="JSvMmtPDtFashionDataTable();" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" type="button"><?php echo language('common/main/main', 'tAdvanceFillter')?></button>
                             </div>  
                        </div>

                        <div class="row" >
                         <!-- Browse ฤดูกาล -->
                         <div class="col-md-3 col-sm-3 col-xs-6">
                        
                                    <div class="form-group">
                                        <div class="input-group">
                                            <input type='text' class='form-control xCNHide xWRptAllInput' id='oetInvFhnPdtSeasonCode'   name='oetInvFhnPdtSeasonCode' value="">
                                            <input type='text' class='form-control xWPointerEventNone xWRptAllInput' id='oetInvFhnPdtSeasonName' name='oetInvFhnPdtSeasonName' value="" placeholder="<?= language('product/product/product','tFhnPdtDataTableSeason')?>" autocomplete="off" readonly>
                                            <span class="input-group-btn">
                                                <button id="obInvFhnPdtSeasonBrows" type="button" class="btn xCNBtnDateTime">
                                                    <img  src="<?=base_url().'application/modules/common/assets/images/icons/find-24.png'?>">
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                            </div>
                             <!-- Browse ฤดูกาล -->


                         <!-- Browse สี -->
                         <div class="col-md-2 col-sm-2 col-xs-6">
                        
                                    <div class="form-group">
                                        <div class="input-group">
                                            <input type='text' class='form-control xCNHide xWRptAllInput' id='oetInvFhnPdtColorCode'   name='oetInvFhnPdtColorCode' value="">
                                            <input type='text' class='form-control xWPointerEventNone xWRptAllInput' id='oetInvFhnPdtColorName' name='oetInvFhnPdtColorName' value="" placeholder="<?= language('product/product/product','tFhnPdtDataTableColor')?>" autocomplete="off" readonly>
                                            <span class="input-group-btn">
                                                <button id="obInvFhnPdtColorBrows" type="button" class="btn xCNBtnDateTime">
                                                    <img  src="<?=base_url().'application/modules/common/assets/images/icons/find-24.png'?>">
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                            </div>
                             <!-- Browse สี -->

                       <!-- Browse ขนาด -->
                       <div class="col-md-2 col-sm-2 col-xs-6">
                        
                            <div class="form-group">
                                <div class="input-group">
                                    <input type='text' class='form-control xCNHide xWRptAllInput' id='oetInvFhnPdtSizeCode'   name='oetInvFhnPdtSizeCode' value="">
                                    <input type='text' class='form-control xWPointerEventNone xWRptAllInput' id='oetInvFhnPdtSizeName' name='oetInvFhnPdtSizeName' value="" placeholder="<?= language('product/product/product','tFhnPdtDataTableSize')?>" autocomplete="off" readonly>
                                    <span class="input-group-btn">
                                        <button id="obInvFhnPdtSizeBrows" type="button" class="btn xCNBtnDateTime">
                                            <img  src="<?=base_url().'application/modules/common/assets/images/icons/find-24.png'?>">
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <!-- Browse ขนาด -->

                         <!-- Browse เนื้อผ้า -->
                         <div class="col-md-3 col-sm-3 col-xs-6">
                        
                                    <div class="form-group">
                                        <div class="input-group">
                                            <input type='text' class='form-control xCNHide xWRptAllInput' id='oetInvFhnPdtFabricCode'   name='oetInvFhnPdtFabricCode' value="">
                                            <input type='text' class='form-control xWPointerEventNone xWRptAllInput' id='oetInvFhnPdtFabricName' name='oetInvFhnPdtFabricName' value="" placeholder="<?= language('product/product/product','tFhnPdtDataTableFabric')?>" autocomplete="off" readonly>
                                            <span class="input-group-btn">
                                                <button id="obInvFhnPdtFabricBrows" type="button" class="btn xCNBtnDateTime">
                                                    <img  src="<?=base_url().'application/modules/common/assets/images/icons/find-24.png'?>">
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                            </div>
                         <!-- Browse เนื้อผ้า -->

                        <!-- ใช้งาน -->
                        <div class="col-md-2 col-sm-2 col-xs-6">
                                <label class="fancy-checkbox">
                                    <input id="ocbPdtFhnStaUse" type="checkbox" class="ocbListItem" name="ocbPdtFhnStaUse" value="1" checked>
                                    <span>&nbsp;<?php echo language('product/product/product', 'tFhnPdtDataTableUse1'); ?></span>
                                </label>
                        </div> 

                        </div>


                </div>

         
                  <div  id="odvPdtFhnDataTable"></div>
           

              
            </div>
        </div>
    </div>


    <?php include 'script/jInvDataTable.php'; ?>