<?php
//Decimal Show ลง 2 ตำแหน่ง
$nDecShow =  FCNxHGetOptionDecimalShow();
?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <table id="otbFhnPdtDataTable" class="table table-striped">
        <thead>
            <tr>
              <th nowrap class="text-center xCNTextBold" style="width:5%;"><?php echo language('product/product/product','tFhnPdtDataTableNo')?></th>
               <th nowrap class="text-center xCNTextBold" style="width:6%;"><?php echo language('product/product/product','tFhnPdtDataTableImage')?></th>
                <th nowrap class="text-center xCNTextBold" style="width:9%;"><?php echo language('product/product/product', 'tFhnPdtDataTableSeason') ?></th>
                <th nowrap class="text-center xCNTextBold" style="width:10%;"><?php echo language('product/product/product', 'tFhnPdtDataTableFabric') ?></th>
                <th nowrap class="text-center xCNTextBold" style="width:8%;"><?php echo language('product/product/product', 'tFhnPdtDataTableColor') ?></th>
                <th nowrap class="text-center xCNTextBold" style="width:8%;"><?php echo language('product/product/product', 'tFhnPdtDataTableSize') ?></th>
                <th nowrap class="text-center xCNTextBold" style="width:18%;"><?php echo language('product/product/product', 'tFhnPdtDataTableRefCode') ?></th>
                <th nowrap class="text-center xCNTextBold" style="width:20%;"><?php echo language('product/product/product', 'tPDTViewPackBarcode') ?></th>
                <th nowrap class="text-center xCNTextBold" style="width:6%;"><?php echo language('product/product/product', 'tFhnPdtDataTableStatus') ?></th>
                <th nowrap class="text-center xCNTextBold" style="width:5%;"><?php echo language('product/product/product', 'tFhnPdtDataTableDelete') ?></th>
                <th nowrap class="text-center xCNTextBold" style="width:5%;"><?php echo language('product/product/product', 'tFhnPdtDataTableEdit') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php if (isset($aMasterPdtClrPsz['raItems']) && is_array($aMasterPdtClrPsz['raItems']) && !empty($aMasterPdtClrPsz['raItems'])) : ?>
                <?php foreach ($aMasterPdtClrPsz['raItems'] as $key => $aValue) : ?>
                <?php
                            if($aValue['FTFhnStaActive']=='1'){
                                $tFhnStaActiveColor = 'green';
                            }else{
                                $tFhnStaActiveColor = 'red';
                            }
                ?>
                      <tr class="xWPdtFhnRow" >
                      <td nowrap class="text-center"><?php echo $key+1; ?></td>
                        <td nowrap class="text-center xCNBorderRight xWPdtImgtd"  style="padding-right:10px !important"><?php echo FCNtHGetImagePageList($aValue['FTImgObj'],'40px');?></td>
                        <td nowrap class="text-left"><?php echo $aValue['FTSeaName']; ?></td>
                        <td nowrap class="text-left"><?php echo $aValue['FTFabName']; ?></td>
                        <td nowrap class="text-left"><?php echo $aValue['FTClrName']; ?></td>
                        <td nowrap class="text-left"><?php echo $aValue['FTPszName']; ?></td>
                        <td nowrap class="text-left"><?php echo $aValue['FTFhnRefCode']; ?></td>
                        <td nowrap >
                            <div class="row">
                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 ">
                                <?php   
                                if($aValue['FTBarCode']!=''){
                                        echo $aValue['FTBarCode']; 
                                }else{
                                        echo language('product/product/product', 'tFhnPdtDataTableNoConfig');
                                }
                                ?> 
                                </div>

                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 ">
                                        <label style="float:right; margin-top:5;" 
                                        data-refcode="<?php echo $aValue['FTFhnRefCode']; ?>" 
                                        data-refseq="<?php echo $aValue['FNFhnSeq']; ?>" 
                                        data-fabname="<?php echo $aValue['FTFabName']; ?>"
                                        data-seaname="<?php echo $aValue['FTSeaName']; ?>"
                                        data-clrname="<?php echo $aValue['FTClrName']; ?>"  
                                        data-pszname="<?php echo $aValue['FTPszName']; ?>"
                                        onclick="JSxPdtFhnCallModalAddEditBardCode(this,'Add')" 
                                        class="xCNTextLink">
                                            <i class="fa fa-plus"></i> <?php echo language('product/product/product', 'tPDTViewPackMngBarCode'); ?>
                                        </label>
                                </div>
                            </div>
                        </td>
                        <td nowrap class="text-left" ><span style="color:<?=$tFhnStaActiveColor?>"><?php echo language('product/product/product', 'tFhnPdtDataTableUse'.$aValue['FTFhnStaActive']); ?></span></td>
                        <td nowrap class="text-center"><img class="xCNIconTable xWPdtSetDelete xCNIconDelete" onclick="JSvFhnPdtClrSzePageDelete('<?php echo $aValue['FTPdtCode']; ?>','<?php echo $aValue['FTFhnRefCode']; ?>','<?=$aValue['FNFhnSeq']?>')"></td>
                        <td nowrap class="text-center"><img class="xCNIconTable xWPdtSetEdit xCNIconEdit" onclick="JSvFhnPdtClrSzePageEdit('<?php echo $aValue['FTPdtCode']; ?>','<?php echo $aValue['FTFhnRefCode']; ?>','<?=$aValue['FNFhnSeq']?>')"></td>
                    </tr>
                <?php endforeach; ?>


            <?php else : ?>
                 <tr class="xWPdtSetNoData">
                    <td class="text-center xCNTextDetail2" colspan="99"><?php echo language('common/main/main', 'tCMNNotFoundData') ?></td>
                </tr> 
            <?php endif; ?>
        </tbody>


    </table>

    <div class="row">
    <div class="col-md-6">
        <p><?= language('common/main/main','tResultTotalRecord')?> <?=$aMasterPdtClrPsz['rnAllRow']?> <?= language('common/main/main','tRecord')?> <?= language('common/main/main','tCurrentPage')?> <?=$aMasterPdtClrPsz['rnCurrentPage']?> / <?=$aMasterPdtClrPsz['rnAllPage']?></p>
    </div>
    <div class="col-md-6">
        <div class="xWPageFhnPdt btn-toolbar pull-right">
            <?php if($nPage == 1){ $tDisabledLeft = 'disabled'; }else{ $tDisabledLeft = '-';} ?>
            <button onclick="JSvFhnPdtClickPage('previous')" class="btn btn-white btn-sm" <?php echo $tDisabledLeft ?>>
                <i class="fa fa-chevron-left f-s-14 t-plus-1"></i>
            </button>
            <?php for($i=max($nPage-2, 1); $i<=max(0, min($aMasterPdtClrPsz['rnAllPage'],$nPage+2)); $i++){?>
                <?php 
                    if($nPage == $i){ 
                        $tActive = 'active'; 
                        $tDisPageNumber = 'disabled';
                    }else{ 
                        $tActive = '';
                        $tDisPageNumber = '';
                    }
                ?>
                <button onclick="JSvFhnPdtClickPage('<?php echo $i?>')" type="button" class="btn xCNBTNNumPagenation <?php echo $tActive ?>" <?php echo $tDisPageNumber ?>><?php echo $i?></button>
            <?php } ?>
            <?php if($nPage >= $aMasterPdtClrPsz['rnAllPage']){  $tDisabledRight = 'disabled'; }else{  $tDisabledRight = '-';  } ?>
            <button onclick="JSvFhnPdtClickPage('next')" class="btn btn-white btn-sm" <?php echo $tDisabledRight ?>>
                <i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
            </button>
        </div>
    </div>
</div>
</div>

<!-- ===================================================== Modal Delete Product Set ===================================================== -->
<div id="odvModalDeletePdtFashion" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header xCNModalHead">
                <label class="xCNTextModalHeard"><?php echo language('common/main/main', 'tModalDelete') ?></label>
            </div>
            <div class="modal-body">
                <span id="ospTextConfirmDelPdtFashion" class="xCNTextModal" style="display: inline-block; word-break:break-all"></span>
            </div>
            <div class="modal-footer">
                <button id="osmConfirmDelPdtFashion" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" type="button"><?php echo language('common/main/main', 'tModalConfirm') ?></button>
                <button class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button" data-dismiss="modal"><?php echo language('common/main/main', 'tModalCancel') ?></button>
            </div>
        </div>
    </div>
</div>
<!-- ====================================================== End Modal Delete Product Set ======================================================= -->




<div id="odvModalPdtFashionAddEditBarCode" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header xCNModalHead">
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                            <label class="xCNTextModalHeard"><?php echo language('product/product/product', 'tPDTViewPackMngBarCode'); ?></label>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-right">
                        <button class="btn xCNBTNDefult xCNBTNDefult2Btn" id="obtModalPdtFashionAddEditBarCodeClose" type="button" data-dismiss="modal"><?php echo language('common/main/main', 'tModalCancel') ?></button>
                        </div>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="panel-body" style="padding:10px">
                        <div class="row">
                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                <form action="javascript:void(0);" id="ofmFhnModalAebBarCode" class="validate-form">
                                    <button type="submit" id="obtFhnModalAebBarCodeSubmit" class="xCNHide"></button>
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <!-- Modal Add/Edit BarCode -->
                                        <div class="form-group">
                                            <label class="xCNLabelFrm"><span style="color:red">*</span> <?php echo language('product/product/product', 'tPDTViewPackMDBarCode'); ?></label>
                                            <input type="text" id="oetFhnModalAebOldBarCode" class="form-control xCNHide" name="oetFhnModalAebOldBarCode">
                                            <input type="text" id="oetFhnModalAebBarCode" class="form-control" name="oetFhnModalAebBarCode" autocomplete="off" maxlength="25" placeholder="<?php echo language('product/product/product', 'tPDTViewPackMDPachBarCode'); ?>" data-validate-required="<?php echo language('product/product/product', 'tPDTViewPackMDPachBarCode'); ?>"> <!-- xCNInputWithoutSpcNotThai xCNInputWithoutSingleQuote -->
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <!-- Modal Add/Edit BarCode PackSize -->
                                        <div class="form-group">
                                            <label class="xCNLabelFrm"><span style="color:red">*</span> <?php echo language('product/product/product', 'tPDTTabPackSizeUnit'); ?></label>
                                            <div class="input-group">
                                                <input type="text" id="oetFhnModalAebPunCode" class="form-control xCNHide" name="oetFhnModalAebPunCode">
                                                <input type="text" id="oetFhnModalAebPunName" class="form-control" name="oetFhnModalAebPunName" data-validate-required="<?php echo language('product/product/product', 'tPDTValidPdtPsz') ?>" readonly="">
                                                <span class="input-group-btn">
                                                    <button id="obtFhnModalAebBrowsePdtPackSize" type="button" class="btn xCNBtnBrowseAddOn">
                                                        <img src="<?php echo base_url() . '/application/modules/common/assets/images/icons/find-24.png' ?>">
                                                    </button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"> -->
                                        <!-- Modal Add/Edit Factor -->
                                        <!-- <div class="form-group">
                                            <label class="xCNLabelFrm"><span style="color:red">*</span> <?php echo language('product/product/product', 'tPDTUnitFact'); ?></label>
                                                <input type="text" id="oetFhnModalAebUnitFact" name="oetFhnModalAebUnitFact" class="form-control  xCNInputMaskCurrency  text-right" autocomplete="off"  maxlength="18" data-validate-required="<?php echo language('product/product/product', 'tFhnPdtValidateFactor') ?>">
                                        </div>
                                    </div> -->
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <!-- Modal Add/Edit BarCode Loacation -->
                                        <div class="form-group">
                                            <label class="xCNLabelFrm"><?php echo language('product/product/product', 'tPDTViewPackMDBarLocation'); ?></label>
                                            <div class="input-group">
                                                <input type="text" id="oetFhnModalAebPlcCode" class="form-control xCNHide" name="oetFhnModalAebPlcCode">
                                                <input type="text" id="oetFhnModalAebPlcName" class="form-control" name="oetFhnModalAebPlcName" data-validate-required="<?php echo language('product/product/product', 'tPDTViewPackMDPachBarLocation') ?>" readonly="">
                                                <span class="input-group-btn">
                                                    <button id="obtFhnModalAebBrowsePdtLocation" type="button" class="btn xCNBtnBrowseAddOn">
                                                        <img src="<?php echo base_url() . '/application/modules/common/assets/images/icons/find-24.png' ?>">
                                                    </button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <!-- Modal Selected Supplier -->
                                        <div id="odvFhnMdAesSelectSupplier" class="form-group">
                                            <label class="xCNLabelFrm"><?php echo language('product/product/product', 'tPDTViewPackMDSplSupplier'); ?></label>
                                            <div class="input-group">
                                                <input type="text" id="oetFhnModalAesSplCode" class="form-control xCNHide" name="oetFhnModalAesSplCode">
                                                <input type="text" id="oetFhnModalAesSplName" class="form-control" name="oetFhnModalAesSplName" data-validate="<?php echo language('product/product/product', 'tPDTViewPackMDMsgSplNotSltSupplier') ?>"" readonly="">
                                                <span class="input-group-btn">
                                                    <button id="obtFhnModalAebBrowsePdtSupplier" type="button" class="btn xCNBtnBrowseAddOn">
                                                        <img src="<?php echo base_url() . '/application/modules/common/assets/images/icons/find-24.png' ?>">
                                                    </button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <!-- Modal Add/Edit BarCode StaUse -->
                                        <label class="fancy-checkbox">
                                            <input type="checkbox" id="ocbFhnModalAebBarStaUse" name="ocbFhnModalAebBarStaUse">
                                            <span><?php echo language('product/product/product', 'tPDTViewPackMDBarStaUse') ?></span>
                                        </label>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <!-- Modal Add/Edit BarCode StaUse -->
                                        <label class="fancy-checkbox">
                                            <input type="checkbox" id="ocbFhnModalAebBarStaAlwSale" name="ocbFhnModalAebBarStaAlwSale">
                                            <span><?php echo language('product/product/product', 'tPDTViewPackMDBarAlwSale') ?></span>
                                        </label>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <!-- Modal Set Status Supplier Allow PO -->
                                        <label class="fancy-checkbox">
                                            <input type="checkbox" id="ocbFhnModalAesSplStaAlwPO" name="ocbFhnModalAesSplStaAlwPO">
                                            <span><?php echo language('product/product/product', 'tPDTViewPackMDSplStaAlwPO') ?></span>
                                        </label>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-center" style="margin-top:15px;">
                                                <button onclick="JSxFhnPdtModalBarCodeClear()" class="btn xCNBTNDefult xCNBTNDefult2Btn"><?php echo language('product/product/product', 'tPDTViewPackBTNReset'); ?></button>
                                            </div>
                                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-center" style="margin-top:15px;">
                                                <input type="hidden" name="oetFhnEditData" id="oetFhnEditData" value="0">
                                                <button class="btn xCNBTNPrimery xCNBTNPrimery2Btn xWFhnPDTSubmitAddBar"><?php echo language('product/product/product', 'tPDTViewPackSaveManage'); ?></button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">

                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <input type="hidden" id="ohdFhnModalFTRefCode" class="form-control" value="">
                                        <input type="hidden" id="ohdFhnModalFTPdtCode" class="form-control" value="">
                                        <input type="hidden" id="ohdFhnModalFTRefSeq" class="form-control" value="">
                                        <div class="alert alert-info" role="alert">
                                            <div class="row">
                                                <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3"><?= language('product/product/product', 'tFhnPdtName') ?></div>
                                                <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9"><span id="ospFhnTxtPdtName"></span></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3"><?php echo language('product/product/product', 'tFhnPdtDataTableSeason') ?></div>
                                                <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9"><span id="ospFhnTxtPdtSeason"></span></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3"><?php echo language('product/product/product', 'tFhnPdtDataTableFabric') ?></div>
                                                <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9"><span id="ospFhnTxtPdtFabric"></span></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3"><?php echo language('product/product/product', 'tFhnPdtDataTableColor') ?></div>
                                                <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9"><span id="ospFhnTxtPdtColor"></span></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3"><?php echo language('product/product/product', 'tFhnPdtDataTableSize') ?></div>
                                                <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9"><span id="ospFhnTxtPdtSize"></span></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3"><?php echo language('product/product/product', 'tFhnPdtDataTableRefCode') ?></div>
                                                <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9"><span id="ospFhnTxtRefCode"></span></div>
                                            </div>
                                        </div>

                                        <div class="xWModalBarCodeDataTable">

                                      
                                        
                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>

<?php include "script/jPdtfashionDataTable.php"; ?>