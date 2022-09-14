<input id="oetChkSoBrowseType" type="hidden" value="<?php echo @$nChkSoBrowseType;?>">
<input id="oetChkSoCallBackOption" type="hidden" value="<?php echo @$tChkSoBrowseOption;?>">
<input type="hidden" name="ohdPageMnitor" id="ohdPageMnitor" value="1" >
<div id="odvChkSoMainMenu" class="main-menu">
    <div class="xCNMrgNavMenu">
        <div class="row xCNavRow" style="width:inherit;">
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                <ol id="oliCHKSaleMenuNav" class="breadcrumb">
                    <?php FCNxHADDfavorite('dcmCheckSO/0/0');?>
                    <li id="obtSOCallBackPage1" style="cursor:pointer;" onclick="JSvCHKSoCallPageMain()"><?php echo language('sale/checksaleorderapprove/chksaleorder','tCHKSALOrderTitleMenu');?></li>
                    <li id="oliSOTitleAprove" class="active"><a><?php echo language('document/saleorder/saleorder', 'tSOTitleAprove'); ?></a></li>
                    <li id="oliSOTitleConimg" class="active"><a><?php echo language('document/saleorder/saleorder', 'tSOTitleConimg'); ?></a></li>
                </ol>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-right p-r-0">
                <div class="demo-button xCNBtngroup" style="width:100%;">
                    <button id="obtPdtWaitReturn" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" onclick="JSxSOPdtReturn()"><?php echo language('sale/checksaleorderapprove/chksaleorder','tCHKBtnPdtReturn'); ?></button>                    <button id="obtSOCallBackPage" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"> <?php echo language('common/main/main', 'tBack'); ?></button>
                    <button id="obtSORejectAprove" style="display:none" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"> <?php echo language('common/main/main', 'tSODoctReject'); ?></button>
                    <button id="obtSOPrintDoc" onclick="JSxSOPrintDoc()" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"> <?php echo language('common/main/main', 'tCMNPrint'); ?></button>
                    <button id="obtSOCancelDoc" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"> <?php echo language('common/main/main', 'tCancel'); ?></button>
                    <button id="obtSOApproveDocTxn" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" type="button">อนุมัติ</button>                                  
                    <div  id="odvSOBtnGrpSave" class="btn-group ">
                        <button id="obtSOSubmitFromDoc" type="button" class="btn xWBtnGrpSaveLeft"> <?php echo language('common/main/main', 'tSave'); ?></button>
                        <?php echo $vBtnSave ?>
                    </div>
                    <button id="obtCHKAdvanceSearch" type="button" class="btn xCNBTNDefult xCNBTNDefult1Btn"><i class="fa fa-filter" style="width:20px;"></i><?php echo language('common/main/main', 'tAdvanceFillter'); ?></button>
                    <button id="obtCHKSearchReset" class="btn xCNBTNDefult xCNBTNDefult1Btn"><?php echo language('common/main/main', 'tClearSearch'); ?></button>
                </div>
            </div>
        </div>

       <div style="margin-right: -15px;">
            <div id="odvCPHAdvanceSearchContainer"  class="col-lg-12 hidden panel" style="margin-bottom:20px; padding: 10px 10px;">
                <form id="ofmCHKFromSerchAdv" class="validate-form" action="javascript:void(0)" method="post">
                    <div class="row">
                        <!-- From Search Branch MultiSelect-->
                        <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                            <div class="form-group">
                                <label class="xCNLabelFrm"><?php echo language('sale/checksaleorderapprove/chksaleorder','tCHKAdvSearchBranch'); ?></label>
                                <div class="input-group">
                                    <input type='text' class='form-control xCNHide xWRptAllInput' id='oetChkBchStaSelectAll' name='oetChkBchStaSelectAll'>
                                    <input type='text' class='form-control xCNHide xWRptAllInput' id='oetChkBchCodeSelect' name='oetChkBchCodeSelect'>
                                    <input type='text' class='form-control xWPointerEventNone xWRptAllInput' id='oetChkBchNameSelect' name='oetChkBchNameSelect' readonly>
                                    <span class='input-group-btn'>
                                        <button id='obtChkMultiBrowseBranch' type='button' class='btn xCNBtnBrowseAddOn'><img class='xCNIconFind'></button>
                                    </span>
                                </div>
                            </div>
                        </div>
                
                        <!-- From Search MerChant MultiSelect-->
                        <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                            <div class="form-group">
                                <label class="xCNLabelFrm"><?php echo language('sale/checksaleorderapprove/chksaleorder','tCHKAdvSearchMerchant'); ?></label>
                                <div class="input-group">
                                    <input type='text' class='form-control xCNHide xWRptAllInput' id='oetChkMerStaSelectAll' name='oetChkMerStaSelectAll'>
                                    <input type='text' class='form-control xCNHide xWRptAllInput' id='oetChkMerCodeSelect' name='oetChkMerCodeSelect'>
                                    <input type='text' class='form-control xWPointerEventNone xWRptAllInput' id='oetChkMerNameSelect' name='oetChkMerNameSelect' readonly>
                                    <span class='input-group-btn'>
                                        <button id='obtChkMultiBrowseMerchant' type='button' class='btn xCNBtnBrowseAddOn'><img class='xCNIconFind'></button>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- From Search Advanced  Shop -->
                        <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                            <div class="form-group">
                                <label class="xCNLabelFrm"><?php echo language('sale/checksaleorderapprove/chksaleorder','tCHKAdvSearchShop');?></label>
                                <div class="input-group">
                                    <input type='text' class='form-control xCNHide xWRptAllInput' id='oetChkShpStaSelectAll' name='oetChkShpStaSelectAll'>
                                    <input type='text' class='form-control xCNHide xWRptAllInput' id='oetChkShpCodeSelect' name='oetChkShpCodeSelect'>
                                    <input type='text' class='form-control xWPointerEventNone xWRptAllInput' id='oetChkShpNameSelect' name='oetChkShpNameSelect' readonly>
                                    <span class='input-group-btn'>
                                        <button id='obtChkMultiBrowseShop' type='button' class='btn xCNBtnBrowseAddOn'><img class='xCNIconFind'></button>
                                    </span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- From Search Advanced  Wah -->
                        <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                            <div class="form-group">
                                <label class="xCNLabelFrm"><?php echo language('sale/checksaleorderapprove/chksaleorder','tCHKAdvSearchWah');?>ปลายทาง</label>
                                <div class="input-group">
                                    <input type='text' class="form-control xCNHide xWRptAllInput" id='oetChkWahStaSelectAll' name='oetChkWahStaSelectAll'>
                                    <input type='text' class='form-control xCNHide xWRptAllInput' id='oetChkWahCodeSelect' name='oetChkWahCodeSelect'>
                                    <input type='text' class='form-control xWPointerEventNone xWRptAllInput' id='oetChkWahNameSelect' name='oetChkWahNameSelect' readonly>
                                    <span class="input-group-btn">
                                        <button id='obtChkMultiBrowseWah' type='button' class='btn xCNBtnBrowseAddOn'><img class='xCNIconFind'></button>
                                    </span>
                                </div>
                            </div>

                            <!-- Button Form Search Advanced -->
                            <div class="form-group" style="width:60%;float:right;">
                                <label class="xCNLabelFrm">&nbsp;</label>
                                <button id="obtCHKAdvSearchSubmitForm" class="btn xCNBTNPrimery" style="width:100%"><?php echo language('common/main/main', 'tSearch'); ?></button>
                            </div>

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="xCNMenuCump xCNBKLBrowseLine" id="odvMenuCump">&nbsp;</div>
<div class="main-content">
    <div id="odvContentPageChkSale"></div>
</div>
<?php include('script/jChkSaleOrderApproveFormSearchList.php')?>
<script type="text/javascript" src="<?php echo base_url(); ?>application/modules/document/assets/src/checksaleorderapprove/jChksaleApprove.js"></script>
<script src="<?php echo  base_url('application/modules/common/assets/js/jquery.mask.js')?>"></script>
<script src="<?php echo  base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>