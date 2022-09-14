<?php
    //Decimal Save
    $tDecSave   = FCNxHGetOptionDecimalSave();
    
    if(isset($nStaAddOrEdit) && $nStaAddOrEdit == 1){
        $tRoute             = "productEventEdit";
        $tMenuTabDisable    = "";
        $tMenuTabToggle     = "tab";
    }else{
        $tRoute             = "productEventAdd";
        $tMenuTabDisable    = "disabled xWCloseTab";
        $tMenuTabToggle     = "false";
    }

    // Set Data Info Tab
    if(isset($aPdtInfoData) && $aPdtInfoData['rtCode'] == '1'){
        // TabInfo 1 
        $tPdtCode       = $aPdtInfoData['raItems']['FTPdtCode'];
        $tPdtName       = $aPdtInfoData['raItems']['FTPdtName'];
        $tPdtNameOth    = $aPdtInfoData['raItems']['FTPdtNameOth'];
        $tPdtNameABB    = $aPdtInfoData['raItems']['FTPdtNameABB'];
        $tVatCode       = $aPdtInfoData['raItems']['FTVatCode'];
        $tStaVatBuy     = $aPdtInfoData['raItems']['FTPdtStaVatBuy'];
        $tStkControl    = $aPdtInfoData['raItems']['FTPdtStkControl'];
        $tStaVat        = $aPdtInfoData['raItems']['FTPdtStaVat'];
        $tStaAlwReturn  = $aPdtInfoData['raItems']['FTPdtStaAlwReturn'];
        $tStaPoint      = $aPdtInfoData['raItems']['FTPdtPoint'];
        $tStaAlwDis     = $aPdtInfoData['raItems']['FTPdtStaAlwDis'];
        $tStaActive     = $aPdtInfoData['raItems']['FTPdtStaActive'];
        // TabInfo 2
        // $tBchCode       = $aPdtInfoData['raItems']['FTBchCode'];
        // $tBchName       = $aPdtInfoData['raItems']['FTBchName'];
        // $tPdtMerCode    = $aPdtInfoData['raItems']['FTPdtRefShop'];
        // $tPdtMerName    = $aPdtInfoData['raItems']['FTMerName'];
        $tPgpChain      = $aPdtInfoData['raItems']['FTPgpChain'];
        $tPgpChainName  = $aPdtInfoData['raItems']['FTPgpChainName'];
        $tPtyCode       = $aPdtInfoData['raItems']['FTPtyCode'];
        $tPtyName       = $aPdtInfoData['raItems']['FTPtyName'];
        $tPbnCode       = $aPdtInfoData['raItems']['FTPbnCode'];
        $tPbnName       = $aPdtInfoData['raItems']['FTPbnName'];
        $tPmoCode       = $aPdtInfoData['raItems']['FTPmoCode'];
        $tPmoName       = $aPdtInfoData['raItems']['FTPmoName'];
        $tTcgCode       = $aPdtInfoData['raItems']['FTTcgCode'];
        $tTcgName       = $aPdtInfoData['raItems']['FTTcgName'];
        $tPdtSaleStart  = $aPdtInfoData['raItems']['FDPdtSaleStart'];
        $tPdtSaleStop   = $aPdtInfoData['raItems']['FDPdtSaleStop'];
        $tPdtPointTime  = $aPdtInfoData['raItems']['FCPdtPointTime'];
        $tPdtQtyOrdBuy  = $aPdtInfoData['raItems']['FCPdtQtyOrdBuy'];
        $tPdtMax        = $aPdtInfoData['raItems']['FCPdtMax'];
        $tPdtMin        = $aPdtInfoData['raItems']['FCPdtMin'];
        $tPdtCostDef    = number_format($aPdtInfoData['raItems']['FCPdtCostDef'],$tDecSave);
        $tPdtCostOth    = number_format($aPdtInfoData['raItems']['FCPdtCostOth'],$tDecSave);
        $tPdtCostStd    = number_format($aPdtInfoData['raItems']['FCPdtCostStd'],$tDecSave);
        $tPdtRmk        = $aPdtInfoData['raItems']['FTPdtRmk'];
    }else{
        // TabInfo 1 
        $tPdtCode       = "";
        $tPdtName       = "";
        $tPdtNameOth    = "";
        $tPdtNameABB    = "";
        $tVatCode       = "";
        $tStaVatBuy     = "";
        $tStkControl    = "";
        $tStaVat        = "";
        $tStaAlwReturn  = "";
        $tStaPoint      = "";
        $tStaAlwDis     = "";
        $tStaActive     = "";
        // TabInfo 2
        // $tBchCode       = "";
        // $tBchName       = "";
        // $tPdtMerCode    = "";
        // $tPdtMerName    = "";
        $tPgpChain      = "";
        $tPgpChainName  = "";
        $tPtyCode       = "";
        $tPtyName       = "";
        $tPbnCode       = "";
        $tPbnName       = "";
        $tPmoCode       = "";
        $tPmoName       = "";
        $tTcgCode       = "";
        $tTcgName       = "";
        $tPdtSaleStart  = "";
        $tPdtSaleStop   = "";
        $tPdtPointTime  = "";
        $tPdtQtyOrdBuy  = "";
        $tPdtMax        = "";
        $tPdtMin        = "";
        $tPdtCostDef    = "";
        $tPdtCostOth    = "";
        $tPdtCostStd    = "";
        $tPdtRmk        = "";
    }
?>
<style>
    .xWCloseTab{
        color:#cecece;
    }

    .xWMenu{
        cursor:pointer;
    }

    .xWPdtModalTextFrm{
        font-family: THSarabunNew;
        font-size: 20px !important;
        font-weight: bold !important;
    }

    .xWPdtModalTextFrmDt{
        font-family: THSarabunNew;
        font-size: 20px !important;
        font-weight: 500px !important;
    }
    
</style>
<link rel="stylesheet" href="<?php echo base_url();?>application/modules/product/assets/css/product/ada.product.css"> 
<form action="javascript:void(0);" class="validate-form" method="post" id="ofmAddEditProduct">
    <button type="submit" id="obtSubmitProduct" class="btn btn-primary xCNHide"></button>
    <input type="hidden" id="ohdStaAddOrEdit" class="form-control" value="<?php echo $nStaAddOrEdit;?>">
    <div class="panel-body" style="padding-top:20px !important;">
        <!-- Nav Tab Add Product -->
        <div id="odvPdtRowNavMenu" class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="custom-tabs-line tabs-line-bottom left-aligned">
                    <ul class="nav" role="tablist">
                        <li id="oliPdtDataAddInfo1" class="xWMenu active" data-menutype="MN">
                            <a role="tab" data-toggle="tab" data-target="#odvPdtContentInfo1" aria-expanded="true"><?php echo language('product/product/product','tPDTTabInfo')?></a>
                        </li>
                        <li id="oliPdtDataAddInfo2" class="xWMenu" data-menutype="MN">
                            <a role="tab" data-toggle="tab" data-target="#odvPdtContentInfo2" aria-expanded="false"><?php echo language('product/product/product','tPDTTabInfo2')?></a>
                        </li>
                        <li id="oliPdtDataAddSet" class="xWMenu xWSubTab <?php echo $tMenuTabDisable;?>" data-menutype="SET">
                            <a role="tab" data-toggle="<?php echo $tMenuTabToggle;?>" data-target="#odvPdtContentSet" aria-expanded="false"><?php echo language('product/product/product','tPDTTabSet')?></a>
                        </li>
                        <li id="oliPdtDataAddEvnNotSale" class="xWMenu xWSubTab <?php echo $tMenuTabDisable;?>" data-menutype="EVN">
                            <a role="tab" data-toggle="<?php echo $tMenuTabToggle;?>" data-target="#odvPdtContentEvnNotSale" aria-expanded="false"><?php echo language('product/product/product','tPDTTabAlowEvn')?></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- Content tab Add Product -->
        <div id="odvPdtRowContentMenu" class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="tab-content">
                    <!-- Tab Content Product Info 1 -->
                    <div id="odvPdtContentInfo1" class="tab-pane fade active in">
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-5 col-lg-5">
                                <label class="xCNLabelFrm"><span style = "color:red">*</span> <?php echo language('product/product/product','tPDTCode');?></label>
                                <div id="odvProductAutoGenCode" class="form-group">
                                    <div class="validate-input">
                                        <label class="fancy-checkbox">
                                            <input type="checkbox" id="ocbProductAutoGenCode" name="ocbProductAutoGenCode" checked="true" value="1">
                                            <span> <?php echo language('common/main/main', 'tGenerateAuto'); ?></span>
                                        </label>
                                    </div>
                                </div>
                                <div id="odvProductCodeForm" class="form-group">
                                    <input type="hidden" id="ohdCheckDuplicatePdtCode" name="ohdCheckDuplicatePdtCode" value="1"> 
                                    <div class="validate-input">
                                        <input 
                                            type="text" 
                                            class="form-control xCNInputWithoutSpcNotThai" 
                                            maxlength="5" 
                                            id="oetPdtCode" 
                                            name="oetPdtCode"
                                            data-is-created="<?php echo $tPdtCode;?>"
                                            placeholder="<?php echo language('product/product/product','tPDTCode')?>"
                                            value="<?php echo $tPdtCode; ?>" 
                                            data-validate-required = "<?php echo language('product/product/product','tPDTValidPdtCode');?>"
                                            data-validate-dublicateCode = "<?php echo language('product/product/product','tPDTValidPdtCodeDup');?>"
                                        >
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><span style = "color:red">*</span> <?php echo language('product/product/product','tPDTName');?></label>
                                    <input 
                                        type="text"
                                        class="form-control xCNInputWithoutSpc"
                                        maxlength="100"
                                        id="oetPdtName"
                                        name="oetPdtName"
                                        value="<?php echo $tPdtName;?>"
                                        data-validate-required = "<?php echo language('product/product/product','tPDTValidPdtName');?>"
                                    >
                                </div>
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('product/product/product','tPDTNameOth');?></label>
                                    <input type="text" id="oetPdtNameOth" class="form-control xCNInputWithoutSpc" maxlength="100"  name="oetPdtNameOth" value="<?php echo $tPdtNameOth;?>">
                                </div>
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('product/product/product','tPDTNameABB');?></label>
                                    <input type="text" id="oetPdtNameABB" class="form-control xCNInputWithoutSpc" maxlength="100"  name="oetPdtNameABB" value="<?php echo $tPdtNameABB;?>">
                                </div>
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('product/product/product','tPDTVatrate');?></label>
                                    <select id="ocmPdtVatCode" class="selectpicker form-control xWPdtSelectBox" data-live-search="true" name="ocmPdtVatCode">
                                        <option value=""><?php echo language('common/main/main', 'tCMNBlank-NA');?></option>
                                        <?php for($i=0; $i<FCNnHSizeOf($aVatRate['FTVatCode']); $i++): ?>
                                            <option value="<?php echo $aVatRate['FTVatCode'][$i]?>" <?php echo ($aVatRate['FTVatCode'][$i] == $tVatCode)? 'selected':''?>>
                                                [<?php echo $aVatRate['FTVatCode'][$i]?>] <?php echo number_format($aVatRate['FCVatRate'][$i],0).'%'?>
                                            </option>
                                        <?php endfor;?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-xs-4 col-sm-3 col-md-3 col-lg-3">
                                            <label class="fancy-checkbox">
                                                <script>
                                                    var tStaCheckVatBuy = "<?php echo $tStaVatBuy;?>";
                                                    if(typeof(tStaCheckVatBuy) !== 'undefined' && tStaCheckVatBuy == '1'){
                                                        $('#ocbPdtStaVatBuy').prop("checked",true);
                                                    }else{
                                                        $('#ocbPdtStaVatBuy').prop("checked",false);
                                                    }
                                                </script>
                                                <input type="checkbox" id="ocbPdtStaVatBuy" name="ocbPdtStaVatBuy">
                                                <span><?php echo language('product/product/product','tPDTStaVatBuy')?></span>
                                            </label>
                                            <label class="fancy-checkbox">
                                                <script>
                                                    var tStaCheckStkControl = "<?php echo $tStkControl;?>";
                                                    if(typeof(tStaCheckStkControl) !== 'undefined' && tStaCheckStkControl == '1'){
                                                        $('#ocbPdtStkControl').prop("checked",true);
                                                    }else{
                                                        $('#ocbPdtStkControl').prop("checked",false);
                                                    }
                                                </script>
                                                <input type="checkbox" id="ocbPdtStkControl" name="ocbPdtStkControl">
                                                <span><?php echo language('product/product/product','tPDTStkControl')?></span>
                                            </label>
                                        </div>
                                        <div class="col-xs-4 col-sm-3 col-md-3 col-lg-3">
                                            <label class="fancy-checkbox">
                                                <script>
                                                    var tStaVat = "<?php echo $tStaVat;?>";
                                                    if(typeof(tStaVat) !== 'undefined' && tStaVat == '1'){
                                                        $('#ocbPdtStaVat').prop("checked",true);
                                                    }else{
                                                        $('#ocbPdtStaVat').prop("checked",false);
                                                    }
                                                </script>
                                                <input type="checkbox" id="ocbPdtStaVat" name="ocbPdtStaVat">
                                                <span><?php echo language('product/product/product','tPDTStaVat')?></span>
                                            </label>
                                            <label class="fancy-checkbox">
                                                <script>
                                                    var tStaAlwReturn = "<?php echo $tStaAlwReturn;?>";
                                                    if(typeof(tStaAlwReturn) !== 'undefined' && tStaAlwReturn == '1'){
                                                        $('#ocbPdtStaAlwReturn').prop("checked",true);
                                                    }else{
                                                        $('#ocbPdtStaAlwReturn').prop("checked",false);
                                                    }
                                                </script>
                                                <input type="checkbox" id="ocbPdtStaAlwReturn" name="ocbPdtStaAlwReturn">
                                                <span><?php echo language('product/product/product','tPDTAlwReturn')?></span>
                                            </label>
                                        </div>
                                        <div class="col-xs-4 col-sm-3 col-md-3 col-lg-3">
                                            <label class="fancy-checkbox">
                                                <script>
                                                    var tStaPoint = "<?php echo $tStaPoint;?>";
                                                    if(typeof(tStaPoint) !== 'undefined' && tStaPoint == '1'){
                                                        $('#ocbPdtPoint').prop("checked",true);
                                                    }else{
                                                        $('#ocbPdtPoint').prop("checked",false);
                                                    }
                                                </script>
                                                <input type="checkbox" id="ocbPdtPoint" name="ocbPdtPoint">
                                                <span><?php echo language('product/product/product','tPDTGivePoint')?></span>
                                            </label>
                                            <label class="fancy-checkbox">
                                                <script>
                                                    var tStaAlwDis = "<?php echo $tStaAlwDis;?>";
                                                    if(typeof(tStaAlwDis) !== 'undefined' && tStaAlwDis == '1'){
                                                        $('#ocbPdtStaAlwDis').prop("checked",true);
                                                    }else{
                                                        $('#ocbPdtStaAlwDis').prop("checked",false);
                                                    }
                                                </script>
                                                <input type="checkbox" id="ocbPdtStaAlwDis" name="ocbPdtStaAlwDis">
                                                <span><?php echo language('product/product/product','tPDTStaAlwDis')?></span>
                                            </label> 
                                        </div>
                                        <div class="col-xs-4 col-sm-3 col-md-3 col-lg-3">
                                            <label class="fancy-checkbox">
                                                <script>
                                                    var tStaActive = "<?php echo $tStaActive;?>";
                                                    if(typeof(tStaActive) !== 'undefined' && tStaActive == '1'){
                                                        $('#ocbPdtStaActive').prop("checked",true);
                                                    }else{
                                                        $('#ocbPdtStaActive').prop("checked",false);
                                                    }
                                                </script>
                                                <input type="checkbox" id="ocbPdtStaActive" name="ocbPdtStaActive">
                                                <span><?php echo language('product/product/product','tPDTStaActive')?></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-7 col-lg-7">
                                <img id="oimImgMasterProduct" src="<?php echo base_url().'application/modules/common/assets/images/NoPic.png';?>" class="img img-respornsive" style="width:100%;cursor:pointer">    
                                <div id="odvImageTumblr" style="padding-top:10px;overflow-x:auto;" class="table-responsive">
                                    <table id="otbImageListProduct">
                                        <tr>
                                            <td>
                                                <img id="oimAddImage" src="<?php echo base_url().'application/modules/common/assets/images/icons/plus-501.png';?>"class="img img-respornsive" style="cursor:pointer">
                                            </td>
                                            <?php if(isset($aPdtImgData) && $aPdtImgData['rtCode'] == 1):?>
                                                <?php foreach($aPdtImgData['raItems'] AS $nKey => $aValueImg):?>
                                                    <?php 
                                                        if(isset($aValueImg['FTImgObj']) && !empty($aValueImg['FTImgObj'])){
                                                            $tFullPatch = './application/modules/'.$aValueImg['FTImgObj'];
                                                            if (file_exists($tFullPatch)){
                                                                $tPatchImg = base_url().'application/modules/'.$aValueImg['FTImgObj'];
                                                            }else{
                                                                $tPatchImg = base_url().'application/modules/common/assets/images/200x200.png';
                                                            }
                                                        }else{
                                                            $tPatchImg  =   base_url().'application/modules/common/assets/images/200x200.png';
                                                        }
                                                        $aExplodeImg    = explode('/',$aValueImg['FTImgObj']);
                                                    ?>
                                                    <td id="otdTumblrProduct<?php echo $nKey;?>" class="xWTDImgDataItem">
                                                        <img 
                                                            id="oimTumblrProduct<?php echo $nKey;?>"
                                                            src="<?php echo $tPatchImg;?>"
                                                            data-img="<?php echo trim($aExplodeImg[5]);?>"
                                                            data-tumblr="<?php echo $nKey;?>"
                                                            class="xCNImgTumblr img img-respornsive"
                                                            style="z-index:100;width:106px;height:67px;"
                                                        >
                                                        <div class="xCNImgDelIcon" id="odvImgDelBntProduct<?php echo $nKey;?>" data-id="<?php echo $nKey;?>" style="z-index:500;cursor:pointer;text-align:center;display:none;">
                                                            <i class="fa fa-times" aria-hidden="true"></i> ลบรูป
                                                        </div>
                                                        <script type="text/javascript">
                                                            $('#oimTumblrProduct<?php echo $nKey;?>').click(function(){
                                                                $('#oimImgMasterProduct').attr('src',$(this).attr('src'));
                                                                return false;
                                                            });
                                                            $('#oimTumblrProduct<?php echo $nKey;?>').hover(function(){
                                                                $('#odvImgDelBntProduct<?php echo $nKey;?>').show();

                                                            });
                                                            $('#oimTumblrProduct<?php echo $nKey;?>').mouseleave(function(){
                                                                $('#odvImgDelBntProduct<?php echo $nKey;?>').hide();
                                                            });

                                                            $('#odvImgDelBntProduct<?php echo $nKey;?>').hover(function(){
                                                                $(this).show();
                                                                $('#<?php echo $nKey;?>').addClass('xCNImgHover');
                                                            });

                                                            $('#odvImgDelBntProduct<?php echo $nKey;?>').mouseleave(function () {
                                                                $(this).hide();
                                                            })

                                                            $('#odvImgDelBntProduct<?php echo $nKey;?>').click(function(){
                                                                JCNxRemoveImgTumblrNEW(this,'Product');
                                                            });
                                                            
                                                        </script>
                                                    </td>
                                                <?php endforeach;?>
                                            <?php endif;?>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div id="odvPdtSetPackSizeMenu" class="col-xs-6 col-sm-6 col-md-6 col-lg-6 p-t-20 text-left">
                                <label id="olbAddProductUnit" class="xCNTextBold xWPdtTextLink">
                                    <i class="fa fa-plus"></i> <?php echo language('product/product/product','tPDTViewPackAddUnit')?>
                                </label>
                            </div>
                            <?php if(isset($nStaAddOrEdit) && $nStaAddOrEdit == 1):?>
                                <div id="odvPdtPriceAllDataMenu" class="col-xs-6 col-sm-6 col-md-6 col-lg-6 p-t-20 text-right">
                                    <label id="olbPdtPriceAllData" class="xCNTextBold xWPdtTextLink">
                                        <i class="fa fa-eye"></i> <?php echo language('product/product/product','tPDTViewPackPriceAllData')?>
                                    </label>
                                </div>
                            <?php endif; ?>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div id="odvPdtSetPackSizeTable" class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th nowrap class="text-center xCNTextBold" style="width:15%;"><?php echo language('product/product/product','tPDTViewPackUnit')?></th>

                                                <th nowrap class="text-center xCNTextBold" style="width:15%;"><?php echo language('product/product/product','tPDTViewPackBarcode')?></th>
                                                <?php if($aAlwEventPdt['tAutStaFull'] == 1 || $aAlwEventPdt['tAutStaDelete'] == 1) : ?>
                                                <th nowrap class="text-center xCNTextBold" style="width:5%;"><?php echo language('product/product/product','tPDTViewPackDelete')?></th>
                                                <?php endif; ?>

                                                <th nowrap class="text-center xCNTextBold" style="width:15%;"><?php echo language('product/product/product','tPDTViewPackSupplier')?></th>
                                                <?php if($aAlwEventPdt['tAutStaFull'] == 1 || $aAlwEventPdt['tAutStaDelete'] == 1) : ?>
                                                <th nowrap class="text-center xCNTextBold" style="width:5%;"><?php echo language('product/product/product','tPDTViewPackDelete')?></th>
                                                <?php endif; ?>

                                                <th nowrap class="text-center xCNTextBold" style="width:10%;"><?php echo language('product/product/product','tPDTViewPackPriRet')?></th>
                                                <th nowrap class="text-center xCNTextBold" style="width:10%;"><?php echo language('product/product/product','tPDTViewPackPriWhs')?></th>
                                                <th nowrap class="text-center xCNTextBold" style="width:10%;"><?php echo language('product/product/product','tPDTViewPackPriNet')?></th>

                                                <?php if($aAlwEventPdt['tAutStaFull'] == 1 || $aAlwEventPdt['tAutStaDelete'] == 1) : ?>
                                                <th nowrap class="text-center xCNTextBold" style="width:5%;"><?php echo language('product/product/product','tPDTViewPackDelUnit')?></th>
                                                <?php endif; ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if(isset($aPdtInfoPackSize) && $aPdtInfoPackSize['rtCode'] == '1'): ?>
                                                <?php $tTextPunCode = ""; $tTextPunName = ""; $tPszPunCode = ""; ?>
                                                <?php foreach($aPdtInfoPackSize['raItems'] AS $nKey => $aPszValue):?>
                                                    <?php if($tPszPunCode != $aPszValue['FTPunCode']): ?>
                                                    <?php 
                                                        $tTextPunCode .= $aPszValue['FTPunCode'].','; 
                                                        $tTextPunName .= $aPszValue['FTPunName'].',';
                                                    ?>
                                                        <tr id="otrPdtDataUnitRow<?php echo $aPszValue['FTPunCode']?>" class="xWPdtPackSizeRow xWPdtDataUnitRow" data-puncode="<?php echo $aPszValue['FTPunCode'];?>" data-punname="<?php echo $aPszValue['FTPunName'];?>">
                                                            <td nowrap class="xCNBorderRight">
                                                                <input 
                                                                    type="hidden"
                                                                    id="ohdPdtPunCodeRow<?php echo $aPszValue['FTPunCode'];?>"
                                                                    class="form-control xWPdtPunCode" value="<?php echo $aPszValue['FTPunCode'];?>"
                                                                >
                                                                <input
                                                                    type="hidden"
                                                                    id="ohdPdtGrandRow<?php echo $aPszValue['FTPunCode'];?>"
                                                                    class="form-control xWPdtGrade" value="<?php echo $aPszValue['FTPdtGrade'];?>"
                                                                >
                                                                <input 
                                                                    type="hidden"
                                                                    id="ohdPdtWeightRow<?php echo $aPszValue['FTPunCode'];?>"
                                                                    class="form-control xWPdtWeight" value="<?php echo number_format($aPszValue['FCPdtWeight'],$tDecSave);?>"
                                                                >
                                                                <input 
                                                                    type="hidden"
                                                                    id="ohdPdtClrCodeRow<?php echo $aPszValue['FTPunCode'];?>"
                                                                    class="form-control xWPdtClrCode" value="<?php echo $aPszValue['FTClrCode'];?>"
                                                                >
                                                                <input 
                                                                    type="hidden"
                                                                    id="ohdPdtClrNameRow<?php echo $aPszValue['FTPunCode'];?>"
                                                                    class="form-control xWPdtClrName" value="<?php echo $aPszValue['FTClrName'];?>"
                                                                >
                                                                <input 
                                                                    type="hidden"
                                                                    id="ohdPdtSizeCodeRow<?php echo $aPszValue['FTPunCode'];?>"
                                                                    class="form-control xWPdtSizeCode" value="<?php echo $aPszValue['FTPszCode'];?>"
                                                                >
                                                                <input 
                                                                    type="hidden"
                                                                    id="ohdPdtSizeNameRow<?php echo $aPszValue['FTPunCode'];?>"
                                                                    class="form-control xWPdtSizeName" value="<?php echo $aPszValue['FTPszName'];?>"
                                                                >
                                                                <input 
                                                                    type="hidden"
                                                                    id="ohdPdtUnitDimRow<?php echo $aPszValue['FTPunCode'];?>"
                                                                    class="form-control xWPdtUnitDim" value="<?php echo $aPszValue['FTPdtUnitDim'];?>"
                                                                >
                                                                <input 
                                                                    type="hidden"
                                                                    id="ohdPdtPkgDimRow<?php echo $aPszValue['FTPunCode'];?>"
                                                                    class="form-control xWPdtPkgDim" value="<?php echo $aPszValue['FTPdtPkgDim'];?>"
                                                                >
                                                                <input 
                                                                    type="hidden"
                                                                    id="ohdPdtStaAlwPickRow<?php echo $aPszValue['FTPunCode'];?>"
                                                                    class="form-control xWPdtStaAlwPick" value="<?php echo $aPszValue['FTPdtStaAlwPick'];?>"
                                                                >
                                                                <input 
                                                                    type="hidden"
                                                                    id="ohdPdtStaAlwPoHQRow<?php echo $aPszValue['FTPunCode'];?>"
                                                                    class="form-control xWPdtStaAlwPoHQ" value="<?php echo $aPszValue['FTPdtStaAlwPoHQ'];?>"
                                                                >
                                                                <input 
                                                                    type="hidden"
                                                                    id="ohdPdtStaAlwBuyRow<?php echo $aPszValue['FTPunCode'];?>"
                                                                    class="form-control xWPdtStaAlwBuy" value="<?php echo $aPszValue['FTPdtStaAlwBuy'];?>"
                                                                >
                                                                <input 
                                                                    type="hidden"
                                                                    id="ohdPdtStaAlwSaleRow<?php echo $aPszValue['FTPunCode'];?>"
                                                                    class="form-control xPdtStaAlwSale" value="<?php echo $aPszValue['FTPdtStaAlwSale'];?>"
                                                                >
                                                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-left">
                                                                    <label><?php echo $aPszValue['FTPunName'];?></label>
                                                                </div>
                                                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-right">
                                                                    <label onclick="JSxPdtMngPszUnitInTable(this)" class="xCNTextLink xWMngPackSizeUnit"><i class="fa fa-cogs"></i> <?php echo language('product/product/product','tPDTViewPackMngUnit');?></label>
                                                                </div>
                                                            </td>
                                                            <td nowrap>
                                                                <label onclick="JSxPdtCallModalAddEditBardCode(this,'Add')" class="xCNTextLink xWAddBarPszUnit">
                                                                    <i class="fa fa-plus"></i> <?php echo language('product/product/product','tPDTViewPackAddBarCode');?>
                                                                </label>
                                                            </td>
                                                            <td nowrap>
                                                            </td>
                                                            <td nowrap>
                                                                <label onclick="JSxPdtCallModalAddEditSupplier(this,'Add')" class="xCNTextLink xWAddSplPszUnit">
                                                                    <i class="fa fa-plus"></i> <?php echo language('product/product/product','tPDTViewPackAddSupplier');?>
                                                                </label>
                                                            </td>
                                                            <td nowrap>
                                                            </td>
                                                            <td nowrap class="xWTdPdtPriceRet text-right">
                                                                <label><?php echo number_format($aPszValue['FCPgdPriceRet'],2);?></label>
                                                            </td>
                                                            <td nowrap class="xWTdPdtPriceWhs text-right">
                                                                <label><?php echo number_format($aPszValue['FCPgdPriceWhs'],2);?></label>
                                                            </td>
                                                            <td nowrap class="xWTdPdtPriceWhs text-right">
                                                                <label><?php echo number_format($aPszValue['FCPgdPriceNet'],2);?></label>
                                                            </td>
                                                            <td nowrap class="text-center">
                                                                <img onclick="JSxPdtDelPszUnitInTable(this)" class="xCNIconTable xWPdtDelUnitPackSize xCNIconDelete">
                                                            </td>
                                                        </tr>
                                                        <tr id="otrPdtUnitBarCodeRow<?php echo $aPszValue['FTPunCode']?>" class="xWPdtPackSizeRow xWPdtUnitBarCodeRow" data-puncode="<?php echo $aPszValue['FTPunCode'];?>" data-punname="<?php echo $aPszValue['FTPunName'];?>">
                                                            <td nowrap>
                                                                <input 
                                                                    type="text"
                                                                    class="form-control text-right xCNInputNumericWithoutDecimal"
                                                                    id="oetPdtUnitFact<?php echo $aPszValue['FTPunCode'];?>"
                                                                    placeholder="<?php echo language('product/product/product','tPDTViewPackUnitFact');?>"
                                                                    value="<?php echo number_format($aPszValue['FCPdtUnitFact'],0);?>"
                                                                >
                                                            </td>
                                                            <td nowrap class="xWPdtUnitDataBarCode">
                                                                <?php if(isset($aPdtInfoBarCode) && $aPdtInfoBarCode['rtCode'] == '1'):?>
                                                                    <?php foreach($aPdtInfoBarCode['raItems'] AS $nKey => $aBarValue):?>
                                                                        <?php if($aPszValue['FTPunCode'] == $aBarValue['FTPunCode']):?>
                                                                            <div class="text-right xWBarCodeItem xWBarCodeRow<?php echo $aBarValue['FTBarCode'];?>">
                                                                                <input type="hidden" class="form-control xWPdtAebBarCodeItem" value="<?php echo $aBarValue['FTBarCode'];?>">
                                                                                <input type="hidden" class="form-control xWPdtAebPlcCodeItem" value="<?php echo $aBarValue['FTPlcCode'];?>">
                                                                                <input type="hidden" class="form-control xWPdtAebPlcNameItem" value="<?php echo $aBarValue['FTPlcName'];?>">
                                                                                <input type="hidden" class="form-control xWPdtAebBarStaUseItem" value="<?php echo $aBarValue['FTBarStaUse'];?>">
                                                                                <input type="hidden" class="form-control xWPdtAebBarStaAlwSaleItem" value="<?php echo $aBarValue['FTBarStaAlwSale'];?>">
                                                                                <label onclick="JSxPdtCallModalAddEditBardCode(this,'Edit');" class="xCNTextLink xWPdtBarCodeDetail">
                                                                                    <i class="fa fa-barcode"> <?php echo $aBarValue['FTBarCode'];?></i>
                                                                                </label>
                                                                            </div>
                                                                        <?php endif; ?>
                                                                    <?php endforeach; ?>
                                                                <?php endif; ?>
                                                            </td>
                                                            <td nowrap class="xWPdtDelUnitBarCode">
                                                                <?php if(isset($aPdtInfoBarCode) && $aPdtInfoBarCode['rtCode'] == '1'):?>
                                                                    <?php foreach($aPdtInfoBarCode['raItems'] AS $nKey => $aBarValue):?>
                                                                        <?php if($aPszValue['FTPunCode'] == $aBarValue['FTPunCode']):?>
                                                                            <div class="text-center xWDelBarCodeItem xWBarCodeRow<?php echo $aBarValue['FTBarCode'];?>" data-barcode="<?php echo $aBarValue['FTBarCode'];?>">
                                                                                <img onclick="JSxPdtDelBarCodeInTable(this)" class="xCNIconTable xWPdtDelBarCodeItem xCNIconDelete">
                                                                            </div>
                                                                        <?php endif;?>
                                                                    <?php endforeach;?>
                                                                <?php endif;?>
                                                            </td>
                                                            <td nowrap class="xWPdtUnitDataSupplier">
                                                                <?php if(isset($aPdtInfoSupplier) && $aPdtInfoSupplier['rtCode'] == '1'):?>
                                                                    <?php foreach($aPdtInfoSupplier['raItems'] AS $nKey => $aSplValue):?>
                                                                        <?php if($aPszValue['FTPunCode'] == $aSplValue['FTPunCode']):?>
                                                                                <div class="text-right xWSupplierDt xWAddSupplierItem" data-barcode="<?php echo $aSplValue['FTBarCode'];?>">
                                                                                    <?php if(isset($aSplValue['FTSplCode']) && !empty($aSplValue['FTSplCode'])):?>
                                                                                        <input type="hidden" class="form-control xWPdtAesBarCodeItem" value="<?php echo $aSplValue['FTBarCode'];?>">
                                                                                        <input type="hidden" class="form-control xWPdtAesSplCodeItem" value="<?php echo $aSplValue['FTSplCode'];?>">
                                                                                        <input type="hidden" class="form-control xWPdtAesSplNameItem" value="<?php echo $aSplValue['FTSplName'];?>">
                                                                                        <input type="hidden" class="form-control xWPdtAesSplStaAlwPOItem" value="<?php echo $aSplValue['FTSplStaAlwPO'];?>">
                                                                                        <label onclick="JSxPdtCallModalAddEditSupplier(this,'Edit');" class="xCNTextLink xWPdtSplDetail">
                                                                                            <i class="fa fa-users"> <?php echo  $aSplValue['FTSplName'];?></i>
                                                                                        </label>
                                                                                    <?php else:?>
                                                                                        &nbsp;
                                                                                    <?php endif;?>
                                                                                </div>
                                                                        <?php endif;?>
                                                                    <?php endforeach;?>
                                                                <?php endif;?>
                                                            </td>
                                                            <td nowrap class="xWPdtDelUnitSupplier">
                                                                <?php if(isset($aPdtInfoSupplier) && $aPdtInfoSupplier['rtCode'] == '1'):?>
                                                                    <?php foreach($aPdtInfoSupplier['raItems'] AS $nKey => $aSplValue):?>
                                                                        <?php if($aPszValue['FTPunCode'] == $aSplValue['FTPunCode']):?>
                                                                                <div class="text-center xWSupplierDt xWDelSupplierItem" data-barcode="<?php echo $aSplValue['FTBarCode']?>">
                                                                                <?php if(isset($aSplValue['FTSplCode']) && !empty($aSplValue['FTSplCode'])):?>
                                                                                    <img onclick="JSxPdtDelSupplierInTable(this)" class="xCNIconTable xWPdtDelSupplierItem xCNIconDelete">
                                                                                <?php else:?>
                                                                                    &nbsp;
                                                                                <?php endif;?>
                                                                                </div>
                                                                        <?php endif;?>
                                                                    <?php endforeach;?>
                                                                <?php endif;?>
                                                            </td>
                                                            <td nowrap>
                                                            </td>
                                                            <td nowrap>
                                                            </td>
                                                            <td nowrap>
                                                            </td>
                                                            <td nowrap>
                                                            </td>
                                                        </tr>
                                                    <?php endif; ?>
                                                    <?php $tPszPunCode = $aPszValue['FTPunCode'];?>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <tr class="xWPdtPackSizeNoData"><td class="text-center xCNTextDetail2" colspan="99"><?php echo language('common/main/main','tCMNNotFoundData')?></td></tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                                <input type="hidden" id="ohdPdtUnitCode" class="form-control" value="<?php echo substr(@$tTextPunCode,0,-1);?>">
                                <input type="hidden" id="ohdPdtUnitName" class="form-control" value="<?php echo substr(@$tTextPunName,0,-1);?>">
                            </div>
                        </div>
                    </div>

                    <!-- Tab Content Product Info 2 -->
                    <div id="odvPdtContentInfo2" class="tab-pane fade">
                        <div class="row">
                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                <!-- Product Branch -->
                                <!-- <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('product/product/product','tPDTBranch')?></label>
                                    <div class="input-group">
                                        <input type="text" id="oetPdtBchCode" class="form-control xCNHide" name="oetPdtBchCode" value="<?php echo $tBchCode;?>">
                                        <input type="text" id="oetPdtBchName" class="form-control xCNInputWithoutSpcNotThai" name="oetPdtBchName" value="<?php echo $tBchName;?>" readonly>
                                        <span class="input-group-btn">
                                            <button id="obtBrowseBranch" type="button" class="btn xCNBtnBrowseAddOn">
                                                <img class="xCNIconFind">
                                            </button>
                                        </span>
                                    </div>
                                </div>  -->
                                <!-- Product Merchant -->
                                <!-- <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('product/product/product','tPDTMerchant')?></label>
                                    <div class="input-group">
                                        <input type="text" id="oetPdtMerCode" class="form-control xCNHide" name="oetPdtMerCode" value="<?php echo $tPdtMerCode;?>">
                                        <input type="text" id="oetPdtMerName" class="form-control xCNInputWithoutSpcNotThai" name="oetPdtMerName" value="<?php echo $tPdtMerName;?>" readonly>
                                        <span class="input-group-btn">
                                            <button id="obtBrowseMerchant" type="button" class="btn xCNBtnBrowseAddOn">
                                                <img class="xCNIconFind">
                                            </button>
                                        </span>
                                    </div>
                                </div> -->
                                <!-- Product Group -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('product/product/product','tPDTGroup')?></label>
                                    <div class="input-group">
                                        <input type="text" id="oetPdtPgpChain" class="form-control xCNHide" name="oetPdtPgpChain" value="<?php echo $tPgpChain;?>">
                                        <input type="text" id="oetPdtPgpChainName" class="form-control xCNInputWithoutSpcNotThai" name="oetPdtPgpChainName" value="<?php echo $tPgpChainName;?>" readonly>
                                        <span class="input-group-btn">
                                            <button id="obtBrowsePdtGrp" type="button" class="btn xCNBtnBrowseAddOn">
                                                <img class="xCNIconFind">
                                            </button>
                                        </span>
                                    </div>
                                </div>
                                <!-- Product Type -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('product/product/product','tPDTType')?></label>
                                    <div class="input-group">
                                        <input type="text" id="oetPdtPtyCode" class="form-control xCNHide" name="oetPdtPtyCode" value="<?php echo $tPtyCode;?>">
                                        <input type="text" id="oetPdtPtyName" class="form-control xCNInputWithoutSpcNotThai" name="oetPdtPtyName" value="<?php echo $tPtyName;?>" readonly>
                                        <span class="input-group-btn">
                                            <button id="obtBrowsePdtType" type="button" class="btn xCNBtnBrowseAddOn">
                                                <img class="xCNIconFind">
                                            </button>
                                        </span>
                                    </div>
                                </div>
                                <!-- Product Brand -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('product/product/product','tPDTBrand')?></label>
                                    <div class="input-group">   
                                        <input type="text" id="oetPdtPbnCode" class="form-control xCNHide" name="oetPdtPbnCode" value="<?php echo $tPbnCode;?>">
                                        <input type="text" id="oetPdtPbnName" class="form-control xCNInputWithoutSpcNotThai" name="oetPdtPbnName" value="<?php echo $tPbnName;?>" readonly>
                                        <span class="input-group-btn">
                                            <button id="obtBrowsePdtBrand" type="button" class="btn xCNBtnBrowseAddOn">
                                                <img src="<?php echo base_url().'/application/modules/common/assets/images/icons/find-24.png'?>">
                                            </button>
                                        </span>
                                    </div>
                                </div>
                                <!-- Product Modal -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('product/product/product','tPDTModal');?></label>
                                    <div class="input-group">
                                        <input type="text" id="oetPdtPmoCode" class="form-control xCNHide" name="oetPdtPmoCode" value="<?php echo $tPmoCode;?>">
                                        <input type="text" id="oetPdtPmoName" class="form-control xCNInputWithoutSpcNotThai" name="oetPdtPmoName" value="<?php echo $tPmoName;?>" readonly>
                                        <span class="input-group-btn">
                                            <button id="obtBrowsePdtModel" type="button" class="btn xCNBtnBrowseAddOn">
                                                <img src="<?php echo base_url().'/application/modules/common/assets/images/icons/find-24.png'?>">
                                            </button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                <!-- Product Touch Group -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('product/product/product','tPDTTouchScreen');?></label>
                                    <div class="input-group">
                                        <input type="text" id="oetPdtTcgCode" class="form-control xCNHide" name="oetPdtTcgCode" value="<?php echo $tTcgCode;?>">
                                        <input type="text" id="oetPdtTcgName" class="form-control xCNInputWithoutSpcNotThai"  name="oetPdtTcgName" value="<?php echo $tTcgName;?>" readonly>
                                        <span class="input-group-btn">
                                            <button id="obtBrowsePdtTouchGrp" type="button" class="btn xCNBtnBrowseAddOn">
                                                <img class="xCNIconFind">
                                            </button>
                                        </span>
                                    </div>
                                </div>
                                <!-- Product Date Sale Start -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('product/product/product','tPDTSaleStart');?></label>
                                    <div class="input-group">
                                        <input type="text" id="oetPdtSaleStart" class="form-control xCNDatePicker xCNInputMaskDate" name="oetPdtSaleStart" value="<?php echo $tPdtSaleStart;?>">
                                        <span class="input-group-btn">
                                            <button id="obtPdtSaleStart" type="button" class="btn xCNBtnDateTime">
                                                <img class="xCNIconFind">
                                            </button>
                                        </span>
                                    </div>
                                </div>
                                <!-- Product Date Sale End -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('product/product/product','tPDTSaleStop');?></label>
                                    <div class="input-group">
                                        <input type="text" id="oetPdtSaleStop" class="form-control xCNDatePicker xCNInputMaskDate" name="oetPdtSaleStop" value="<?php echo $tPdtSaleStop;?>">
                                        <span class="input-group-btn">
                                            <button id="obtPdtSaleStop" type="button" class="btn xCNBtnDateTime">
                                                <img class="xCNIconFind">
                                            </button>
                                        </span>
                                    </div>
                                </div>
                                <!-- Product Product PointTime -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('product/product/product','tPDTPointTime');?></label>
                                    <input type="text" id="oetPdtPointTime" class="form-control text-right xCNInputMaskCurrency" name="oetPdtPointTime" maxlength="18" placeholder="0" value="<?php echo $tPdtPointTime;?>">
                                </div>
                                <!-- Product Product Qty Buy -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('product/product/product','tPDTQtyOrdBuy');?></label>
                                    <input type="text" id="oetPdtQtyOrdBuy" class="form-control text-right xCNInputNumericWithoutDecimal" name="oetPdtQtyOrdBuy" maxlength="18" placeholder="0" value="<?php echo $tPdtQtyOrdBuy;?>">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                <!-- Product Product Max -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('product/product/product','tPDTMax');?></label>
                                    <input type="text" id="oetPdtMax" class="form-control text-right xCNInputNumericWithoutDecimal" name="oetPdtMax" maxlength="18" placeholder="0" value="<?php echo $tPdtMax; ?>">
                                </div>
                                <!-- Product Product Min -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('product/product/product','tPDTMin');?></label>
                                    <input type="text" id="oetPdtMin" class="form-control text-right xCNInputNumericWithoutDecimal" name="oetPdtMin" maxlength="18" placeholder="0" value="<?php echo $tPdtMin;?>">
                                </div>
                                <!-- Product Product Cost Default -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('product/product/product','tPDTCostDef');?></label>
                                    <input type="text" id="oetPdtCostDef" class="form-control text-right xCNInputMaskCurrency" name="oetPdtCostDef" maxlength="18" placeholder="0.00" value="<?php echo $tPdtCostDef;?>">
                                </div>
                                <!-- Product Product Cost Other -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('product/product/product','tPDTCostOth');?></label>
                                    <input type="text" id="oetPdtCostOth" class="form-control text-right xCNInputMaskCurrency" name="oetPdtCostOth" maxlength="18" placeholder="0.00" value="<?php echo $tPdtCostOth;?>">
                                </div>
                                <!-- Product Product Cost Standard -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('product/product/product','tPDTCostStd');?></label>
                                    <input
                                        type="text"
                                        id="oetPdtCostStd"
                                        class="form-control text-right xCNInputMaskCurrency"
                                        name="oetPdtCostStd" maxlength="18" placeholder="0.00"
                                        data-validate="<?php echo language('product/product/product','tPDTValidPdtCostStd');?>"
                                        value="<?php echo $tPdtCostStd;?>"
                                    >
                                </div>
                                <!-- Product Product Remark -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('product/product/product','tPDTRmk');?></label>
                                    <textarea class="form-control" maxlength="200" rows="4" id="otaPdtRmk" name="otaPdtRmk"><?php echo $tPdtRmk;?></textarea>
                                </div>
                   
                            
                            </div>
                        </div>
                    </div>

                    <!-- Tab Content Product Add Set -->
                    <div id="odvPdtContentSet" class="tab-pane fade">
                        <div id="odvPdtSetMenuSelectPdt" class="row text-right">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <label id="olbAddPdtSet" class="xCNTextBold xWPdtTextLink"> 
                                    <i class="fa fa-plus"></i> <?php echo language('product/product/product','tPDTSetAddPdt');?>
                                </label>
                            </div>
                        </div>
                        <div id="odvPdtSetTable" class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div id="odvPdtSetDataTable" class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th nowrap class="text-center xCNTextBold" style="width:10%;"><?php echo language('product/product/product','tPDTSetPdtCode')?></th>
                                                <th nowrap class="text-center xCNTextBold" style="width:30%;"><?php echo language('product/product/product','tPDTSetPdtName')?></th>
                                                <th nowrap class="text-center xCNTextBold" style="width:10%;"><?php echo language('product/product/product','tPDTSetPdtPriRet')?></th>
                                                <th nowrap class="text-center xCNTextBold" style="width:10%;"><?php echo language('product/product/product','tPDTSetPdtPriWhs')?></th>
                                                <th nowrap class="text-center xCNTextBold" style="width:10%;"><?php echo language('product/product/product','tPDTSetPdtPriNet')?></th>
                                                <th nowrap class="text-center xCNTextBold" style="width:10%;"><?php echo language('product/product/product','tPDTSetPstQty')?></th>
                                                <th nowrap class="text-center xCNTextBold" style="width:10%;"><?php echo language('product/product/product','tPDTSetPstEdit')?></th>
                                                <th nowrap class="text-center xCNTextBold" style="width:10%;"><?php echo language('product/product/product','tPDTSetPstDel')?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if(isset($aPdtInfoPdtSet) && $aPdtInfoPdtSet['rtCode'] == '1'): ?>
                                                <?php $tPdtCodeSet = ""; $tTextPdtCodeSet = ""; $tTextPdtNameSet = "";?>
                                                <?php foreach($aPdtInfoPdtSet['raDataPdtDT'] AS $key => $aPdtDtValue):?>
                                                    <?php if($tPdtCodeSet != $aPdtDtValue['FTPdtCodeSet']): ?>
                                                        <tr id="otrPdtSetRow<?php echo $aPdtDtValue['FTPdtCodeSet'];?>" class="xWPdtSetRow" data-pdtcode="<?php echo $aPdtDtValue['FTPdtCodeSet'];?>" data-pdtname="<?php echo $aPdtDtValue['FTPdtNameSet'];?>">          
                                                            <td nowrap class="text-center"><?php echo $aPdtDtValue['FTPdtCodeSet']?></td>
                                                            <td nowrap class="text-center"><?php echo $aPdtDtValue['FTPdtNameSet']?></td>
                                                            <td nowrap class="text-right"><?php echo number_format($aPdtDtValue['FCPgdPriceRet'],2);?></td>
                                                            <td nowrap class="text-right"><?php echo number_format($aPdtDtValue['FCPgdPriceWhs'],2);?></td>
                                                            <td nowrap class="text-right"><?php echo number_format($aPdtDtValue['FCPgdPriceNet'],2);?></td>
                                                            <td nowrap>
                                                                <input type="text" class="form-control text-right xCNInputNumericWithoutDecimal xCNPdtSetQty" value="<?php echo number_format($aPdtDtValue['FCPstQty'],0)?>" readonly>
                                                            </td>
                                                            <td nowrap class="text-center">
                                                                <img class="xCNIconTable xWPdtSetEditInLine xCNIconEdit">
                                                                <img class="xCNIconTable xWPdtSetSaveInLine xCNIconSave xCNHide">
                                                                <img class="xCNIconTable xWPdtSetCancelInLine xCNIconReback xCNHide">
                                                            </td>
                                                            <td nowrap class="text-center">
                                                                <img class="xCNIconTable xWPdtSetDeleteInLine" src="<?php echo  base_url().'/application/modules/common/assets/images/icons/delete.png'?>">
                                                            </td>
                                                        </tr>
                                                        <?php 
                                                            $tTextPdtCodeSet .= $aPdtDtValue['FTPdtCodeSet'].','; 
                                                            $tTextPdtNameSet .= $aPdtDtValue['FTPdtNameSet'].',';
                                                        ?>
                                                    <?php endif;?>
                                                    <?php $tPdtCodeSet = $aPdtDtValue['FTPdtCodeSet']?>
                                                <?php endforeach; ?>
                                                <?php include "script/jProductSetDataTable.php"; ?>
                                            <?php else:?>
                                                <tr class="xWPdtSetNoData"><td class="text-center xCNTextDetail2" colspan="99"><?php echo language('common/main/main','tCMNNotFoundData')?></td></tr>
                                            <?php endif;?>
                                        </tbody>
                                    </table>
                                </div>
                                <input type="hidden" id="ohdPdtSetCode" name="ohdPdtSetCode" value="<?php echo substr(@$tTextPdtCodeSet,0,-1);?>">
                                <input type="hidden" id="ohdPdtSetName" name="ohdPdtSetName" value="<?php echo substr(@$tTextPdtNameSet,0,-1);?>">
                                <input type="hidden" id="ohdPdtSetStaEditInline" name="ohdPdtSetStaEditInline" value="0">
                            </div>
                        </div>
                        <div id="odvPdtSetConfig" class="row">
                            <?php if(isset($aPdtInfoPdtSet) && $aPdtInfoPdtSet['rtCode'] == '1'): ?>
                                <?php foreach($aPdtInfoPdtSet['raDataPdtHD'] AS $key => $aPdtHDValue):?>
                                    <div id="odvPdtSetChackBoxSta" class="col-xs-12 col-sm-12 col-md-12 col-lg-12 xWPDTSetConfig">
                                        <div class="row">
                                        <!-- Div แสดงรายการย่อย -->
                                            <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                                                <div class="form-group">
                                                    <label class="fancy-checkbox">
                                                        <input type="checkbox" id="ocbPdtStaSetShwDT">
                                                        <span>
                                                            <?php echo language("product/product/product","tPDTSetStaSetShwDT");?>
                                                        </span>
                                                    </label>
                                                </div>
                                            </div>
                                            <script type="text/javascript">
                                                var tPdtStaSetShwDT =   "<?php echo $aPdtHDValue['FTPdtStaSetShwDT'];?>";
                                                if(tPdtStaSetShwDT != "" && tPdtStaSetShwDT == 1){
                                                    $('#ocbPdtStaSetShwDT').prop('checked',true);
                                                }else if(tPdtStaSetShwDT != "" && tPdtStaSetShwDT == 2){
                                                    $('#ocbPdtStaSetShwDT').prop('checked',false);
                                                }else{
                                                    $('#ocbPdtStaSetShwDT').prop('checked',false);
                                                    $('#ocbPdtStaSetShwDT').prop('checked',false);
                                                }
                                            </script>
                                        <!-- End แสดงรายการย่อย -->
                                        
                                        <!-- Div สถานะการใช้ราคา -->
                                            <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                                                <div class="form-group">
                                                    <label class="fancy-checkbox">
                                                        <input onclick="JSxClickEvnPdtSetSubPrice(this)" type="checkbox" id="ocbPdtSubPrice">
                                                        <span>
                                                            <?php echo language("product/product/product","tPDTSetStaSetSubPri")?>
                                                        </span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                                                <div class="form-group">
                                                    <label class="fancy-checkbox">
                                                        <input onclick="JSxClickEvnPdtSetPriceSet(this)" type="checkbox" id="ocbPdtSetPrice">
                                                        <span>
                                                            <?php echo language("product/product/product","tPDTSetStaSetPriSet")?>
                                                        </span>
                                                    </label>
                                                </div>
                                            </div>
                                            <script type="text/javascript">
                                                var tPdtStaSetPri =   "<?php echo $aPdtHDValue['FTPdtStaSetPri'];?>";
                                                if(tPdtStaSetPri != "" && tPdtStaSetPri == 1){
                                                    $('#ocbPdtSetPrice').prop('checked',true);
                                                    $('#ocbPdtSetPrice').parents('.fancy-checkbox').css('pointer-events','none');
                                                    $('#ocbPdtSubPrice').prop('checked',false);
                                                }else if(tPdtStaSetPri != "" && tPdtStaSetPri == 2){
                                                    $('#ocbPdtSubPrice').prop('checked',true);
                                                    $('#ocbPdtSubPrice').parents('.fancy-checkbox').css('pointer-events','none');
                                                    $('#ocbPdtSetPrice').prop('checked',false);
                                                }else{
                                                    $('#ocbPdtSubPrice').prop('checked',true);
                                                    $('#ocbPdtSubPrice').parents('.fancy-checkbox').css('pointer-events','none');
                                                    $('#ocbPdtSetPrice').prop('checked',false);
                                                }
                                            </script>
                                        <!-- End สถานะการใช้ราคา -->
                                        </div>
                                    </div>
                                <?php endforeach; ?>     
                            <?php endif;?>
                        </div>
                    </div>

                    <!-- Tab Content Product Add Event Not Sale -->
                    <div id="odvPdtContentEvnNotSale" class="tab-pane fade">
                        <div id="odvPdtEvnNotSaleMenu" class="row text-right">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <label id="olbDelAllPdtEvnNotSale" class="xCNTextBold xWPdtTextLink text-right" style="padding-right:20px">
                                    <i class="fa fa-trash-o"></i> <?php echo language('product/product/product','tPDTDelAllEventNoSle')?>
                                </label>
                                <label id="olbAddPdtEvnNotSale" class="xCNTextBold xWPdtTextLink">
                                    <i class="fa fa-plus"></i> <?php echo language('product/product/product','tPDTAddEventNoSle');?>
                                </label>
                            </div>
                        </div>
                        <div id="odvPdtEvnNotSaleTable" class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div id="odvPdtEvnNotSaleDataTable" class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th nowrap class="text-center xCNTextBold" style="width:10%;"><?php echo language('product/product/product','tPDTEvnCode')?></th>
                                                <th nowrap class="text-center xCNTextBold" style="width:10%;"><?php echo language('product/product/product','tPDTEvnType')?></th>
                                                <th nowrap class="text-center xCNTextBold" style="width:20%;"><?php echo language('product/product/product','tPDTEvnName')?></th>
                                                <th nowrap class="text-center xCNTextBold" style="width:15%;"><?php echo language('product/product/product','tPDTEvnDateStart')?></th>
                                                <th nowrap class="text-center xCNTextBold" style="width:15%;"><?php echo language('product/product/product','tPDTEvnTimeStart')?></th>
                                                <th nowrap class="text-center xCNTextBold" style="width:15%;"><?php echo language('product/product/product','tPDTEvnDateStop')?></th>
                                                <th nowrap class="text-center xCNTextBold" style="width:15%;"><?php echo language('product/product/product','tPDTEvnTimeStop')?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if(isset($aPdtInfoGetEvnNoSale) && $aPdtInfoGetEvnNoSale['rtCode'] == '1'): ?>
                                                <?php $tEvnCode = ""; $tTextEvnCode = ""; $tTextEvnName = "";?>
                                                <?php foreach($aPdtInfoGetEvnNoSale['raItems'] AS $key => $aPdtEvnValue):?>
                                                    <?php if($tEvnCode != $aPdtEvnValue['FTEvnCode']): ?>
                                                        <tr class="xWEvnNotSaleRow">
                                                            <td nowrap class="text-center"><?php echo $aPdtEvnValue['FTEvnCode']?></td>
                                                            <td nowrap class="text-center">
                                                                <?php echo ($aPdtEvnValue['FTEvnType'] == 1)? language('product/product/product','tPDTEvnNotSaleLangTime') : language('product/product/product','tPDTEvnNotSaleLangDate') ?>
                                                            </td>
                                                            <td nowrap class="text-left"><?php echo $aPdtEvnValue['FTEvnName']?></td>
                                                            <td nowrap class="text-center"><?php echo ($aPdtEvnValue['FTEvnType'] == 1)? '-' : date("Y-m-d",strtotime($aPdtEvnValue['FDEvnDStart']))?></td>
                                                            <td nowrap class="text-center"><?php echo ($aPdtEvnValue['FTEvnType'] == 1)? date("H:i:s",strtotime($aPdtEvnValue['FTEvnTStart'])) : '-'?></td>
                                                            <td nowrap class="text-center"><?php echo ($aPdtEvnValue['FTEvnType'] == 1)? '-' : date("Y-m-d",strtotime($aPdtEvnValue['FDEvnDFinish']))?></td>
                                                            <td nowrap class="text-center"><?php echo ($aPdtEvnValue['FTEvnType'] == 1)? date("H:i:s",strtotime($aPdtEvnValue['FTEvnTFinish'])) : '-'?></td>
                                                        </tr>
                                                        <?php 
                                                            $tTextEvnCode .= $aPdtEvnValue['FTEvnCode'].','; 
                                                            $tTextEvnName .= $aPdtEvnValue['FTEvnName'].',';
                                                        ?>
                                                    <?php else: ?>
                                                        <tr class="xWEvnNotSaleRow">
                                                            <td nowrap class="text-center"></td>
                                                            <td nowrap class="text-center">
                                                                <?php echo ($aPdtEvnValue['FTEvnType'] == 1)? language('product/product/product','tPDTEvnNotSaleLangTime') : language('product/product/product','tPDTEvnNotSaleLangDate') ?>
                                                            </td>
                                                            <td nowrap class="text-left"><?php echo $aPdtEvnValue['FTEvnName']?></td>
                                                            <td nowrap class="text-center"><?php echo ($aPdtEvnValue['FTEvnType'] == 1)? '-' : date("Y-m-d",strtotime($aPdtEvnValue['FDEvnDStart']))?></td>
                                                            <td nowrap class="text-center"><?php echo ($aPdtEvnValue['FTEvnType'] == 1)? date("H:i:s",strtotime($aPdtEvnValue['FTEvnTStart'])) : '-'?></td>
                                                            <td nowrap class="text-center"><?php echo ($aPdtEvnValue['FTEvnType'] == 1)? '-' : date("Y-m-d",strtotime($aPdtEvnValue['FDEvnDFinish']))?></td>
                                                            <td nowrap class="text-center"><?php echo ($aPdtEvnValue['FTEvnType'] == 1)? date("H:i:s",strtotime($aPdtEvnValue['FTEvnTFinish'])) : '-'?></td>
                                                        </tr>
                                                    <?php endif; ?>
                                                    <?php $tEvnCode = $aPdtEvnValue['FTEvnCode'];?>
                                                <?php endforeach;?>
                                            <?php else: ?>
                                                <tr class="xWPdtEvnNoSaleNoData"><td class="text-center xCNTextDetail2" colspan="99"><?php echo language('common/main/main','tCMNNotFoundData')?></td></tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                                <input type="hidden" id="ohdPdtEvnNoSleCode" name="ohdEvnNoSleCode" value="<?php echo substr(@$tTextEvnCode,0,-1);?>">
                                <input type="hidden" id="ohdPdtEvnNoSleName" name="ohdEvnNoSleName" value="<?php echo substr(@$tTextEvnName,0,-1);?>">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<div id="odvModallAllPriceList">
</div>
<div id="odvModallAllData">
    <!-- View Modal Manage Pack Size -->
    <div id="odvModalMngUnitPackSize" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header xCNModalHead">
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                            <label class="xCNTextModalHeard"><?php echo language('product/product/product','tPDTViewPackManage');?></label>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-right">
                            <button onclick="JSxPdtSaveMngPszUnitInTable()" class="btn xCNBTNPrimery xCNBTNPrimery2Btn"><?php echo language('product/product/product','tPDTViewPackSaveManage');?></button>
                            <button class="btn xCNBTNDefult xCNBTNDefult2Btn" data-dismiss="modal"><?php echo language('product/product/product','tPDTViewPackCancelManage');?></button>
                        </div>
                    </div>    
                </div>
                <div class="modal-body">
                    <div class="panel-body" style="padding:10px">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <!-- Modal Manage PackSize Title Unit -->
                                <div class="form-group text-right">
                                    <input type="hidden" id="ohdModalPszUnitCode" class="form-control" name="ohdModalPszUnitCode">
                                    <input type="hidden" id="ohdModalPszUnitName" class="form-control" name="ohdModalPszUnitName">
                                    <label id="olbModalPszUnitTitle" class="xCNTitleFrom" data-puncode="" style="margin-bottom: 0px;"></label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                <!-- Modal Manage PackSize Unit Fact -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('product/product/product','tPDTViewPackMDUnitFact');?></label>
                                    <input type="text" id="oetModalPszUnitFact" class="form-control text-right xCNInputNumericWithDecimal" maxlength="18" name="oetModalPszUnitFact">
                                </div>
                                <!-- Modal Manage PackSize Browse Color -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('product/product/product','tPDTViewPackMDColor');?></label>
                                    <div class="input-group">
                                        <input type="text" id="oetModalPszClrCode" class="form-control xCNHide" name="oetModalPszClrCode">
                                        <input type="text" id="oetModalPszClrName" class="form-control" name="oetModalPszClrName" readonly>
                                        <span class="input-group-btn">
                                            <button id="obtModalPszBrowseColor" type="button" class="btn xCNBtnBrowseAddOn">
                                                <img src="<?php echo base_url().'/application/modules/common/assets/images/icons/find-24.png'?>">
                                            </button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                <!-- Modal Manage PackSize Grade -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('product/product/product','tPDTViewPackMDGrade');?></label>
                                    <input type="text" id="oetModalPszGrade" class="form-control text-right xCNInputWithoutSpc" name="oetModalPszGrade">
                                </div>
                                <!-- Modal Manage PackSize Browse Size -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('product/product/product','tPDTViewPackMDSize');?></label>
                                    <div class="input-group">
                                        <input type="text" id="oetModalPszSizeCode" class="form-control xCNHide" name="oetModalPszSizeCode">
                                        <input type="text" id="oetModalPszSizeName" class="form-control" name="oetModalPszSizeName" readonly>
                                        <span class="input-group-btn">
                                            <button id="obtModalPszBrowseSize" type="button" class="btn xCNBtnBrowseAddOn">
                                                <img src="<?php echo base_url().'/application/modules/common/assets/images/icons/find-24.png'?>">
                                            </button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                <!-- Modal Manage PackSize Weight -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('product/product/product','tPDTViewPackMDWeight');?></label>
                                    <input type="text" id="oetModalPszWeight" class="form-control text-right xCNInputNumericWithDecimal" name="oetModalPszWeight">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <!-- Modal Manage PackSize Unit Dim -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('product/product/product','tPDTViewPackMDUnitDim');?></label>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                            <label class="xCNLabelFrm" style="font-size:18px !important"><?php echo language('product/product/product','tPDTViewPackMDWidth');?></label>
                                            <input type="text" id="oetModalPszUnitDimWidth" class="form-control" name="oetModalPszUnitDimWidth">
                                        </div>
                                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                            <label class="xCNLabelFrm" style="font-size:18px !important"><?php echo language('product/product/product','tPDTViewPackMDLength');?></label>
                                            <input type="text" id="oetModalPszUnitDimLength" class="form-control" name="oetModalPszUnitDimLength">
                                        </div>
                                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                            <label class="xCNLabelFrm" style="font-size:18px !important"><?php echo language('product/product/product','tPDTViewPackMDHeight');?></label>
                                            <input type="text" id="oetModalPszUnitDimHeight" class="form-control" name="oetModalPszUnitDimHeight">
                                        </div>
                                    </div>
                                </div>
                                <!-- Modal Manage PackSize Package Dim -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('product/product/product','tPDTViewPackMDPkgDim');?></label>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                            <label class="xCNLabelFrm" style="font-size:18px !important"><?php echo language('product/product/product','tPDTViewPackMDWidth');?></label>
                                            <input type="text" id="oetModalPszPackageDimWidth" class="form-control" name="oetModalPszPackageDimWidth">
                                        </div>
                                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                            <label class="xCNLabelFrm" style="font-size:18px !important"><?php echo language('product/product/product','tPDTViewPackMDLength');?></label>
                                            <input type="text" id="oetModalPszPackageDimLength" class="form-control" name="oetModalPszPackageDimLength">
                                        </div>
                                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                            <label class="xCNLabelFrm" style="font-size:18px !important"><?php echo language('product/product/product','tPDTViewPackMDHeight');?></label>
                                            <input type="text" id="oetModalPszPackageDimHeight" class="form-control" name="oetModalPszPackageDimHeight">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-4 col-sm-3 col-md-3 col-lg-3">
                                <!-- Modal Manage PackSize StaAlwPick -->
                                <label class="fancy-checkbox">
                                    <input type="checkbox" id="ocbModalPszStaAlwPick" name="ocbModalPszStaAlwPick">
                                    <span><?php echo language('product/product/product','tPDTViewPackMDStaAlwPick')?></span>
                                </label>
                            </div>
                            <div class="col-xs-4 col-sm-3 col-md-3 col-lg-3">
                                <!-- Modal Manage PackSize StaAlwPoHQ -->
                                <label class="fancy-checkbox">
                                    <input type="checkbox" id="ocbModalPszStaAlwPoHQ" name="ocbModalPszStaAlwPoHQ">
                                    <span><?php echo language('product/product/product','tPDTViewPackMDStaAlwPoHQ')?></span>
                                </label>
                            </div>
                            <div class="col-xs-4 col-sm-3 col-md-3 col-lg-3">
                                <!-- Modal Manage PackSize StaAlwBuy -->
                                <label class="fancy-checkbox">
                                    <input type="checkbox" id="ocbModalPszStaAlwBuy" name="ocbModalPszStaAlwBuy">
                                    <span><?php echo language('product/product/product','tPDTViewPackMDStaAlwBuy')?></span>
                                </label>
                            </div>
                            <div class="col-xs-4 col-sm-3 col-md-3 col-lg-3">
                                <!-- Modal Manage PackSize StaAlwSale -->
                                <label class="fancy-checkbox">
                                    <input type="checkbox" id="ocbModalPszStaAlwSale" name="ocbModalPszStaAlwSale">
                                    <span><?php echo language('product/product/product','tPDTViewPackMDStaAlwSale')?></span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- View Modal Add/Edit BarCode -->
    <div id="odvModalAddEditBarCode" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header xCNModalHead">
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                            <label class="xCNTextModalHeard"><?php echo language('product/product/product','tPDTViewPackMngBarCode');?></label>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-right">
                            <button onclick="$('#obtModalAebBarCodeSubmit').click();" class="btn xCNBTNPrimery xCNBTNPrimery2Btn"><?php echo language('product/product/product','tPDTViewPackSaveManage');?></button>
                            <button class="btn xCNBTNDefult xCNBTNDefult2Btn" data-dismiss="modal"><?php echo language('product/product/product','tPDTViewPackCancelManage');?></button>
                        </div>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="panel-body" style="padding:10px">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group text-right">
                                    <input type="hidden" id="ohdModalAebStaCallAddOrEdit" class="form-control" name="ohdModalAebStaCallAddOrEdit">
                                    <input type="hidden" id="ohdModalAebUnitCode" class="form-control" name="ohdModalAebUnitCode">
                                    <input type="hidden" id="ohdModalAebUnitName" class="form-control" name="ohdModalAebUnitName">
                                    <label id="olbModalAebUnitTitle" class="xCNTitleFrom" data-puncode="" style="margin-bottom: 0px;">หน่วย : ชิ้น</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <form action="javascript:void(0);" id="ofmModalAebBarCode" class="validate-form">
                                <button type="submit" id="obtModalAebBarCodeSubmit" class="xCNHide"></button>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <!-- Modal Add/Edit BarCode -->
                                    <div class="form-group">
                                        <label class="xCNLabelFrm"><span style="color:red">*</span> <?php echo language('product/product/product','tPDTViewPackMDBarCode');?></label>
                                        <input 
                                            type="text"
                                            id="oetModalAebBarCode"
                                            class="form-control xCNInputWithoutSpcNotThai xCNInputWithoutSingleQuote"
                                            name="oetModalAebBarCode"
                                            maxlength="25"
                                            placeholder = "<?php echo language('product/product/product','tPDTViewPackMDPachBarCode');?>"
                                            data-validate-required = "<?php echo language('product/product/product','tPDTViewPackMDPachBarCode');?>";
                                        >
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <!-- Modal Add/Edit BarCode Loacation -->
                                    <div class="form-group">
                                        <label class="xCNLabelFrm"><?php echo language('product/product/product','tPDTViewPackMDBarLocation');?></label>
                                        <div class="input-group">
                                            <input type="text" id="oetModalAebPlcCode" class="form-control xCNHide" name="oetModalAebPlcCode">
                                            <input 
                                                type="text"
                                                id="oetModalAebPlcName"
                                                class="form-control"
                                                name="oetModalAebPlcName"
                                                data-validate-required = "<?php echo language('product/product/product','tPDTViewPackMDPachBarLocation') ?>" 
                                                readonly>
                                            <span class="input-group-btn">
                                                <button id="obtModalAebBrowsePdtLocation" type="button" class="btn xCNBtnBrowseAddOn">
                                                    <img src="<?php echo base_url().'/application/modules/common/assets/images/icons/find-24.png'?>">
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-4 col-sm-3 col-md-3 col-lg-3">
                                    <!-- Modal Add/Edit BarCode StaUse -->
                                    <label class="fancy-checkbox">
                                        <input type="checkbox" id="ocbModalAebBarStaUse" name="ocbModalAebBarStaUse">
                                        <span><?php echo language('product/product/product','tPDTViewPackMDBarStaUse')?></span>
                                    </label>
                                </div>
                                <div class="col-xs-4 col-sm-3 col-md-3 col-lg-3">
                                    <!-- Modal Add/Edit BarCode StaUse -->
                                    <label class="fancy-checkbox">
                                        <input type="checkbox" id="ocbModalAebBarStaAlwSale" name="ocbModalAebBarStaAlwSale">
                                        <span><?php echo language('product/product/product','tPDTViewPackMDBarAlwSale')?></span>
                                    </label>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- View Modal Add/Edit Supplier -->
    <div id="odvModalAddEditSupplier" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header xCNModalHead">
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                            <label class="xCNTextModalHeard"><?php echo language('product/product/product','tPDTViewPackMngSupplier');?></label>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-right">
                            <button onclick="$('#obtModalAesSupplierSubmit').click();" id="obtModalAddSupplierSubmit" class="btn xCNBTNPrimery xCNBTNPrimery2Btn"><?php echo language('product/product/product','tPDTViewPackSaveManage');?></button>
                            <button class="btn xCNBTNDefult xCNBTNDefult2Btn" data-dismiss="modal"><?php echo language('product/product/product','tPDTViewPackCancelManage');?></button>
                        </div>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="panel-body" style="padding:10px">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group text-right">
                                    <input type="hidden" id="ohdModalAesStaCallAddOrEdit" class="form-control" name="ohdModalAesStaCallAddOrEdit">
                                    <input type="hidden" id="ohdModalAesUnitCode" class="form-control" name="ohdModalAesUnitCode">
                                    <input type="hidden" id="ohdModalAesUnitName" class="form-control" name="ohdModalAesUnitName">
                                    <label id="olbModalAesUnitTitle" class="xCNTitleFrom" data-puncode="" style="margin-bottom: 0px;">หน่วย : ชิ้น</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <form action="javascript:void(0);" id="ofmModalAesSupplier" class="validate-form">
                                <button type="submit" id="obtModalAesSupplierSubmit" class="xCNHide"></button>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <!-- Modal Selected BarCode -->
                                    <div id="odvMdAesSelectBarCode" class="form-group">
                                    </div>
                                    <!-- Modal Selected Supplier -->
                                    <div id="odvMdAesSelectSupplier" class="form-group">
                                        <label class="xCNLabelFrm"><?php echo language('product/product/product','tPDTViewPackMDSplSupplier');?></label>
                                        <div class="input-group">
                                            <input type="text" id="oetModalAesSplCode" class="form-control xCNHide" name="oetModalAesSplCode">
                                            <input type="text" id="oetModalAesSplName" class="form-control" name="oetModalAesSplName" data-validate="<?php echo language('product/product/product','tPDTViewPackMDMsgSplNotSltSupplier') ?>" readonly>
                                            <span class="input-group-btn">
                                                <button id="obtModalAebBrowsePdtSupplier" type="button" class="btn xCNBtnBrowseAddOn">
                                                    <img src="<?php echo base_url().'/application/modules/common/assets/images/icons/find-24.png'?>">
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                    <!-- Modal Set Status Supplier Allow PO -->
                                    <label class="fancy-checkbox">
                                        <input type="checkbox" id="ocbModalAesSplStaAlwPO" name="ocbModalAesSplStaAlwPO">
                                        <span><?php echo language('product/product/product','tPDTViewPackMDSplStaAlwPO')?></span>
                                    </label>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo base_url(); ?>application/modules/common/assets/js/jquery.mask.js"></script>
<script src="<?php echo base_url(); ?>application/modules/common/assets/src/jFormValidate.js"></script>
<?php include "script/jProductAdd.php"; ?>