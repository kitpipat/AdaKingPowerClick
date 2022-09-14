<?php
    //Decimal Save
    $tDecSave   = FCNxHGetOptionDecimalSave();
    if(isset($nStaAddOrEdit) && $nStaAddOrEdit == 1){
        $tRoute             = "productEventEdit";
        $tMenuTabDisable    = "";
        $tMenuTabToggle     = "tab";
    }else{
        $tRoute             = "productEventAdd";
        $tMenuTabDisable    = " disabled xCNCloseTabNav";
        $tMenuTabToggle     = "false";
    }

    if(isset($aPdtRentalData) && $aPdtRentalData['rtCode'] == '1'){
        //Rental
        $tPdtRentType   = $aPdtRentalData['raItems']['FTPdtRentType'];
        $tPdtStaReqRet  = $aPdtRentalData['raItems']['FTPdtStaReqRet'];
        $tPdtStaPay     = $aPdtRentalData['raItems']['FTPdtStaPay'];
        $tPdtDeposit    = $aPdtRentalData['raItems']['FCPdtDeposit'];
        $tPdtRntShpCode = $aPdtRentalData['raItems']['FTShpCode'];
        $tPdtRntShpName = $aPdtRentalData['raItems']['FTShpName'];
    }else{
        //Rental
        $tPdtRentType   = "";
        $tPdtStaReqRet  = "";
        $tPdtStaPay     = "";
        $tPdtDeposit    = "";
        $tPdtRntShpCode = "";
        $tPdtRntShpName = "";
    }

    // Set Data Info Tab
    if(isset($aPdtInfoData) && $aPdtInfoData['rtCode'] == '1'){
        // TabInfo 1 
        $tPdtCode       = $aPdtInfoData['raItems']['FTPdtCode'];
        $tPdtName       = $aPdtInfoData['raItems']['FTPdtName'];
        $tPdtNameOth    = $aPdtInfoData['raItems']['FTPdtNameOth'];
        $tPdtNameABB    = $aPdtInfoData['raItems']['FTPdtNameABB'];
        $tVatCode       = $aPdtInfoData['raItems']['FTVatCode'];
        $tVatRate       = $aPdtInfoData['raItems']['FCVatRate']."%";
        $tStaVatBuy     = $aPdtInfoData['raItems']['FTPdtStaVatBuy'];
        $tStkControl    = $aPdtInfoData['raItems']['FTPdtStkControl'];
        $tStaVat        = $aPdtInfoData['raItems']['FTPdtStaVat'];
        $tStaAlwReturn  = $aPdtInfoData['raItems']['FTPdtStaAlwReturn'];
        $tStaPoint      = $aPdtInfoData['raItems']['FTPdtPoint'];
        $tStaAlwDis     = $aPdtInfoData['raItems']['FTPdtStaAlwDis'];
        $tStaActive     = $aPdtInfoData['raItems']['FTPdtStaActive'];

        //Napat(Jame) 10/09/2019
        $tPdtType       = $aPdtInfoData['raItems']['FTPdtType'];
        $tPdtSaleType   = $aPdtInfoData['raItems']['FTPdtSaleType'];

        //Napat(Jame) 13/11/2019
        $tPdtStaSetPri  = $aPdtInfoData['raItems']['FTPdtStaSetPri'];
        $tPdtStaSetShwDT = $aPdtInfoData['raItems']['FTPdtStaSetShwDT'];

        // TabInfo 2
        $tBchCode       = $aPdtInfoData['raItems']['FTBchCode'];
        $tBchName       = $aPdtInfoData['raItems']['FTBchName'];
        $tPdtMerCode    = $aPdtInfoData['raItems']['FTMerCode'];
        $tPdtMerName    = $aPdtInfoData['raItems']['FTMerName'];
        $tShpCode       = $aPdtInfoData['raItems']['FTShpCode'];
        $tShpName       = $aPdtInfoData['raItems']['FTShpName'];
        $tMgpCode       = $aPdtInfoData['raItems']['FTMgpCode'];
        $tMgpName       = $aPdtInfoData['raItems']['FTMgpName'];
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
        $tPdtForSystem  = $aPdtInfoData['raItems']['FTPdtForSystem'];
        $dGetDataNow    = "";
        $dGetDataFuture = "";
    }else{
        // TabInfo 1 
        $tPdtCode       = "";
        $tPdtName       = "";
        $tPdtNameOth    = "";
        $tPdtNameABB    = "";
        $tVatCode       = $tVatCompany['tVatCode'];
        $tVatRate       = $tVatCompany['tVatRate']." %";
        $tStaVatBuy     = "";
        $tStkControl    = "";
        $tStaVat        = "";
        $tStaAlwReturn  = "";
        $tStaPoint      = "";
        $tStaAlwDis     = "";
        $tStaActive     = "";

        $tMenuTabDisableForSystem    = "disabled xCNCloseTabNav";
        $tMenuTabToggleForSystem     = "false";

        //Napat(Jame) 10/09/2019
        $tPdtType       = "";
        $tPdtSaleType   = "";

        //Napat(Jame) 13/11/2019
        $tPdtStaSetPri      = "1";
        $tPdtStaSetShwDT    = "2";

        // TabInfo 2
        if($this->session->userdata("tSesUsrLevel") == "SHP" || $this->session->userdata("tSesUsrLevel") == "BCH"){
            $tBchCode       = $this->session->userdata("tSesUsrBchCode");
            $tBchName       = $this->session->userdata("tSesUsrBchName");
            if($this->session->userdata("tSesUsrLevel") == "SHP"){
                $tPdtMerCode    = $this->session->userdata('tSesUsrMerCode');
                $tPdtMerName    = $this->session->userdata('tSesUsrMerName');
                $tShpCode       = $this->session->userdata('tSesUsrShpCode');
                $tShpName       = $this->session->userdata('tSesUsrShpName');
            }else{
                $tPdtMerCode    = "";
                $tPdtMerName    = "";
                $tShpCode       = "";
                $tShpName       = "";
            }
        }else{
            $tBchCode       = "";
            $tBchName       = "";
            $tPdtMerCode    = "";
            $tPdtMerName    = "";
            $tShpCode       = "";
            $tShpName       = "";
        }
        $tMgpCode       = "";
        $tMgpName       = "";
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
        $tPdtPointTime  = 0;
        $tPdtQtyOrdBuy  = 0;
        $tPdtMax        = 0;
        $tPdtMin        = 0;
        $tPdtCostDef    = "";
        $tPdtCostOth    = "";
        $tPdtCostStd    = "";
        $tPdtRmk        = "";
        $tPdtForSystem  = "";
        $dGetDataNow    = $dGetDataNow ;
        $dGetDataFuture = $dGetDataFuture;
    }

    if($tPdtForSystem != '4'){
        $tMenuTabDisableForSystem    = "disabled xCNCloseTabNav";
        $tMenuTabToggleForSystem     = "false";
    }else{
        $tMenuTabDisableForSystem    = "";
        $tMenuTabToggleForSystem     = "tab";
    }

    if($tPdtType != '5'){
        $tMenuTabDisableForSystem1    = "disabled xCNCloseTabNav";
        $tMenuTabToggleForSystem1     = "false";
    }else{
        $tMenuTabDisableForSystem1    = "";
        $tMenuTabToggleForSystem1     = "tab";
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
<!-- Lang for JS -->
<input type="hidden" id="ohdErrMsgNotHasUnit" value="<?php echo language('product/product/product','tErrMsgNotHasUnit')?>">
<input type="hidden" id="ohdErrMsgNotHasBarCode" value="<?php echo language('product/product/product','tErrMsgNotHasBarCode')?>">
<input type="hidden" id="ohdErrMsgDupUnitFact" value="<?php echo language('product/product/product','tErrMsgDupUnitFact')?>">
<input type="hidden" id="ohdErrMsgNotHasUnitSmall" value="<?php echo language('product/product/product','ohdErrMsgNotHasUnitSmall')?>">
<input type="hidden" id="oetUseType" name="oetUseType" value="<?php echo $nUseType; ?>">
<input type="hidden" id="oetBchCode" name="oetBchCode" value="<?php echo $nUsrBchCode; ?>">
<input type="hidden" id="oetShpCode" name="oetShpCode" value="<?php echo $nUsrShpCode; ?>">

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
                        <li id="oliPdtDataAddInfo1" class="xWMenu active xCNStaHideShow" data-menutype="MN">
                            <a role="tab" data-toggle="tab" data-target="#odvPdtContentInfo1" aria-expanded="true"><?php echo language('product/product/product','tPDTTabInfo')?></a>
                        </li>
                        <!-- <li id="oliPdtDataAddInfo2" class="xWMenu" data-menutype="MN">
                            <a role="tab" data-toggle="tab" data-target="#odvPdtContentInfo2" aria-expanded="false"><?php //echo language('product/product/product','tPDTTabInfo2')?></a>
                        </li> -->

                        <li id="oliPdtDataAddRental" class="xWMenu xWSubTab xCNStaHideShow <?php echo $tMenuTabDisableForSystem;?>" data-menutype="RNT">
                            <a role="tab" data-toggle="<?php echo $tMenuTabToggleForSystem;?>" data-target="#odvPdtContentRental" aria-expanded="false"><?php echo language('product/product/product','tPDTTabRental')?></a>
                        </li>

                        <?php if(@$aChkChainPdtSet['tCode'] != "1"): ?>
                            <li id="oliPdtDataAddSet" class="xWMenu xWSubTab xCNStaHideShow <?php echo $tMenuTabDisable;?>" data-menutype="SET">
                                <a role="tab" data-toggle="<?php echo $tMenuTabToggle;?>" data-target="#odvPdtContentSet" aria-expanded="false"><?php echo language('product/product/product','tPDTTabSet')?></a>
                            </li>
                        <?php else: ?>
                            <li id="oliPdtDataAddSetDisable" class="xWMenu xWSubTab xCNStaHideShow<?php echo $tMenuTabDisable;?>" data-menutype="SET" data-pdtcode="<?=@$aChkChainPdtSet['aItems'][0]['FTPdtCode'];?>" data-pdtname="<?=@$aChkChainPdtSet['aItems'][0]['FTPdtName'];?>">
                                <a><?php echo language('product/product/product','tPDTTabSet')?></a>
                            </li>
                        <?php endif; ?>

                        <!-- Create BY Witsarut 16/01/2020 -->
                        <!-- Add  Tab Drug -->
                        <li id="oliPdtDataDrug" class="xWMenu xWSubTab <?php echo $tMenuTabDisableForSystem1 ?>" data-menutype="DRUG" onclick="JSxPdtGetContent();">
                            <a role="tab"  data-toggle="<?php echo $tMenuTabToggleForSystem1;?>" data-target="#odvPdtContentDrug" aria-expanded="false"><?php echo language('product/product/product','tPdtDrug')?></a>
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
                        <div class="col-xs-12 col-sm-5 col-md-4 col-lg-4">
                                <img id="oimImgMasterProduct" src="<?php echo base_url().'application/modules/common/assets/images/200x200.png';?>" class="img img-respornsive" style="width:100%;cursor:pointer">    
                                <div id="odvImageTumblr" style="padding-top:10px;overflow-x:auto;" class="table-responsive">
                                    <table id="otbImageListProduct">
                                        <tr>
                                            <?php if(isset($aPdtImgData) && $aPdtImgData['rtCode'] == 1):?>
                                                <?php foreach($aPdtImgData['raItems'] AS $nKey => $aValueImg):?>
                                                    <?php 
                                                        if(isset($aValueImg['FTImgObj']) && !empty($aValueImg['FTImgObj'])){

                                                            $aValueImgExplode = explode('/modules/',$aValueImg['FTImgObj']);
                                                            $tFullPatch = './application/modules/'.$aValueImgExplode[1];
                                                            if (file_exists($tFullPatch)){
                                                                $tPatchImg = base_url().'application/modules/'.$aValueImgExplode[1];
                                                            }else{
                                                                $tPatchImg = base_url().'application/modules/common/assets/images/200x200.png';
                                                            }
                                                        }else{
                                                               $tPatchImg = base_url().'application/modules/common/assets/images/200x200.png';
                                                        }
                                                        $aExplodeImg    = explode('/',$aValueImg['FTImgObj']);
                                                       
                                                        $tImageName = FCNnHSizeOf($aExplodeImg)-1;
                                                    ?>
                                                    <td id="otdTumblrProduct<?php echo $nKey;?>" class="xWTDImgDataItem">
                                                        <img 
                                                            id="oimTumblrProduct<?php echo $nKey;?>"
                                                            src="<?php echo $tPatchImg;?>"
                                                            data-img="<?php 
                                                            if(isset($aExplodeImg[$tImageName])){
                                                                echo trim($aExplodeImg[$tImageName]);
                                                            }
                                                            ?>"
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
                                            <td>
                                                <!-- <img id="oimAddImage" src="<?php echo base_url().'application/modules/common/assets/images/icons/plus-501.png';?>"class="img img-respornsive" style="cursor:pointer"> -->
                                                <input type="hidden" id="oetImgInputProduct" name="oetImgInputProduct">
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 co-lg-12" style="margin-top:15px; text-align:center;">
                                    <button type="button" class="btn xCNBTNDefult" onclick="JSvImageCallTempNEW('1','2','Product')"><i class="fa fa-picture-o xCNImgButton"></i> <?php echo  language('common/main/main','tSelectPic')?></button>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-7 col-md-8 col-lg-8">

                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('product/product/product','tPdtForSystemTitle');?></label>
                                    <select class="selectpicker form-control" id="ocmPdtForSystem" name="ocmPdtForSystem" maxlength="1" onchange="JSxPdtRentSelectType(this.value)">
                                        <!-- <option value=""><?php echo language('product/product/product','tPdtForSystemTitle')?></option> -->
                                        <option value="1" <?php echo $tPdtForSystem == "1" ? "selected" : "";?>><?php echo language('product/product/product','tPdtForSystem1')?></option>
                                        <option value="2" <?php echo $tPdtForSystem == "2" ? "selected" : "";?>><?php echo language('product/product/product','tPdtForSystem2')?></option>
                                        <option value="3" <?php echo $tPdtForSystem == "3" ? "selected" : "";?>><?php echo language('product/product/product','tPdtForSystem3')?></option>
                                        <option value="4" <?php echo $tPdtForSystem == "4" ? "selected" : "";?>><?php echo language('product/product/product','tPdtForSystem4')?></option>
                                    </select>
                                </div>

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
                                            class="form-control xCNGenarateCodeTextInputValidate" 
                                            maxlength="20" 
                                            id="oetPdtCode" 
                                            name="oetPdtCode"
                                            data-is-created="<?php echo $tPdtCode;?>"
                                            placeholder="<?php echo language('product/product/product','tPDTCode')?>"
                                            autocomplete="off"
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
                                        class="form-control"
                                        maxlength="100"
                                        id="oetPdtName"
                                        name="oetPdtName"
                                        value="<?php echo $tPdtName;?>"
                                        placeholder="<?php echo language('product/product/product','tPDTName');?>"
                                        autocomplete="off"
                                        data-validate-required = "<?php echo language('product/product/product','tPDTValidPdtName');?>"
                                    >
                                </div>
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('product/product/product','tPDTNameOth');?></label>
                                    <input type="text" id="oetPdtNameOth" class="form-control" maxlength="100"  name="oetPdtNameOth" 
                                    placeholder="<?php echo language('product/product/product','tPDTNameOth');?>"
                                    autocomplete="off"
                                    value="<?php echo $tPdtNameOth;?>">
                                </div>
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('product/product/product','tPDTNameABB');?></label>
                                    <input type="text" id="oetPdtNameABB" class="form-control" maxlength="100"  
                                    name="oetPdtNameABB"
                                    value="<?php echo $tPdtNameABB;?>"
                                    placeholder="<?php echo language('product/product/product','tPDTNameABB');?>"
                                    autocomplete="off"
                                    >
                                </div>
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('product/product/product','tPdtTypeTitle');?></label>
                                    <select class="selectpicker form-control" id="ocmPdtType" name="ocmPdtType" maxlength="1">
                                        <option value="1" <?php echo $tPdtType == "1" ? "selected" : "";?>><?php echo language('product/product/product','tPdtTypeTitle1')?></option>
                                        <option value="2" <?php echo $tPdtType == "2" ? "selected" : "";?>><?php echo language('product/product/product','tPdtTypeTitle2')?></option>
                                        <option value="3" <?php echo $tPdtType == "3" ? "selected" : "";?>><?php echo language('product/product/product','tPdtTypeTitle3')?></option>
                                        <option value="4" <?php echo $tPdtType == "4" ? "selected" : "";?>><?php echo language('product/product/product','tPdtTypeTitle4')?></option>
                                        <option value="5" <?php echo $tPdtType == "5" ? "selected" : "";?>><?php echo language('product/product/product','tPdtTypeTitle5')?></option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('product/product/product','tPdtSaleType');?></label>
                                    <select class="selectpicker form-control" id="ocmPdtSaleType" name="ocmPdtSaleType" maxlength="1" onchange="JSxPdtRentSelectType(this.value)">
                                        <option value="1" <?php echo $tPdtSaleType == "1" ? "selected" : "";?>><?php echo language('product/product/product','tPdtSaleType1')?></option>
                                        <option value="2" <?php echo $tPdtSaleType == "2" ? "selected" : "";?>><?php echo language('product/product/product','tPdtSaleType2')?></option>
                                        <option value="3" <?php echo $tPdtSaleType == "3" ? "selected" : "";?>><?php echo language('product/product/product','tPdtSaleType3')?></option>
                                        <option value="4" <?php echo $tPdtSaleType == "4" ? "selected" : "";?>><?php echo language('product/product/product','tPdtSaleType4')?></option>
                                    </select>
                                </div>

                                <div class="custom-tabs-line tabs-line-bottom left-aligned">
                                    <ul class="nav" role="tablist">
                                        <li id="oliPdtDataAddUnit" class="xWMenu active" data-menutype="MN">
                                            <a role="tab" data-toggle="tab" data-target="#odvPdtContentUnit" aria-expanded="true"><?php echo language('product/product/product','tPDTTabPackSizeUnit');?></a>
                                        </li>
                                        <li id="oliPdtDataAddOther" class="xWMenu" data-menutype="MN">
                                            <a role="tab" data-toggle="tab" data-target="#odvPdtContentOther" aria-expanded="false"><?php echo language('product/product/product','tPDTTabOther');?></a>
                                        </li>
                                        <li id="oliPdtDataHisPI" class="xWMenu<?php echo $tMenuTabDisable;?>" data-menutype="MN">
                                            <a role="tab" data-toggle="<?php echo $tMenuTabToggle;?>" data-target="#odvPdtContentHisPI" aria-expanded="false"><?php echo language('product/product/product','tPDTTabHisPI');?></a>
                                        </li>
                                    </ul>
                                </div>

                                <div class="tab-content">
                                    <div id="odvPdtContentUnit" class="tab-pane fade active in">
                                    
                                        <!-- หน่วยสินค้า -->
                                        <div class="row">
                                            <!-- <div id="odvPdtSetPackSizeMenu" class="col-xs-6 col-sm-6 col-md-6 col-lg-6 p-t-20 text-left">
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
                                            <?php endif; ?> -->
                                            
                                            <div id="odvPdtSetPackSizeAdd" class="col-xs-12 col-sm-12 col-md-12 col-lg-12 p-b-10 text-right" style="margin-top:-10px;">
                                              
                                                <button id="obtAddProductUnit" class="xCNBTNPrimeryPlus" type="button">+</button>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                <div id="odvPdtSetPackSizeTable" class="table-responsive"></div>
                                            </div>
                                        </div>
                                    </div>
                                   
                                    <div id="odvPdtContentOther" class="tab-pane fade">
                                        <!-- กำหนดอัตราภาษี -->
                                        <div class="panel panel-default" style="margin-bottom: 25px;">
                                            <div id="odvHead" style="padding-top: 6px !important;padding-bottom: 5px !important;position: relative; background-color: #eeeeee1c;" class="panel-heading xCNPanelHeadBGColor xWPanelHeadMenuRpt" role="tab">
                                                <label class="xCNTextDetail1"><?php echo language('product/product/product','tPDTSetVatrate');?></label>
                                                <a class="xCNMenuplus" role="button" data-toggle="collapse"  href="#odvRptData" aria-expanded="true">
                                                    <i class="fa fa-plus xCNPlus"></i>
                                                </a>
                                            </div>
                                            <div id="odvRptData" class="xCNMenuPanelData panel-collapse collapse in" role="tabpanel" aria-expanded="true">
                                                <div class="panel-body xCNPDModlue" style="padding:30px;">
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                    <div class="table-responsive xCNTableScrollY">
                                                        <div class="form-group">
                                                            <label class="xCNLabelFrm"><?php echo language('product/product/product','tPDTVatrate');?></label>
                                                            <div class="input-group">
                                                                <input type="text" id="ocmPdtVatCode" class="form-control xCNHide" name="ocmPdtVatCode" value="<?php echo $tVatCode?>">
                                                                <input type="text" id="ocmPdtVatName" class="form-control" name="ocmPdtVatName" value="<?php echo $tVatRate; ?>" readonly>
                                                                <span class="input-group-btn">
                                                                    <button id="obtBrowseVat" type="button" class="btn xCNBtnBrowseAddOn">
                                                                        <img class="xCNIconFind">
                                                                    </button>
                                                                </span>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                      
                                                                <label class="fancy-checkbox">
                                                                    <script>
                                                                        var tStaCheckVatBuy = "<?php echo $tStaVatBuy;?>";
                                                                        var tStaNewPdt      = "<?php echo $nStaAddOrEdit ?>";
                                                                        if(typeof(tStaCheckVatBuy) !== 'undefined' && tStaCheckVatBuy == '1' || tStaNewPdt == '99'){
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
                                                                        var tStaVat = "<?php echo $tStaVat;?>";
                                                                        if(typeof(tStaVat) !== 'undefined' && tStaVat == '1' || tStaNewPdt == '99'){
                                                                            $('#ocbPdtStaVat').prop("checked",true);
                                                                        }else{
                                                                            $('#ocbPdtStaVat').prop("checked",false);
                                                                        }
                                                                    </script>
                                                                    <input type="checkbox" id="ocbPdtStaVat" name="ocbPdtStaVat">
                                                                    <span><?php echo language('product/product/product','tPDTStaVat')?></span>
                                                                </label>
                                                          
                                        
                                                            </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- กำหนดสินค้าด่วน -->
                                        <div class="panel panel-default" style="margin-bottom: 25px;">
                                            <div id="odvHeadTcg"  style="padding-top: 6px !important;padding-bottom: 5px !important;position: relative; background-color: #eeeeee1c;" class="panel-heading xCNPanelHeadBGColor xWPanelHeadMenuRpt" class="panel-heading xCNPanelHeadBGColor xWPanelHeadMenuRpt" role="tab">
                                                <label class="xCNTextDetail1"><?php echo language('product/product/product','tPdtDefineExpressPdt');?></label>
                                                <a class="xCNMenuplus collapsed" role="button" data-toggle="collapse"  href="#odvRptDataTcg" aria-expanded="false">
                                                    <i class="fa fa-plus xCNPlus"></i>
                                                </a>
                                            </div>

                                            <div id="odvRptDataTcg" class="xCNMenuPanelData panel-collapse collapse" role="tabpanel" aria-expanded="false">
                                                <div class="panel-body xCNPDModlue" style="padding:25px;">
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                    <div class="table-responsive xCNTableScrollY">
                                                        <div class="form-group">
                                                            <label class="xCNLabelFrm"><?php echo language('product/product/product','tPdtExpressGroup');?></label>
                                                            <div class="input-group">
                                                                <input type="text" id="oetPdtTcgCode" name="oetPdtTcgCode" class="form-control xCNHide"  value="<?php echo $tTcgCode;?>">
                                                                <input type="text" id="oetPdtTcgName" name="oetPdtTcgName" class="form-control" value="<?php echo $tTcgName;?>" readonly>
                                                                <span class="input-group-btn">
                                                                    <button id="obtBrowsePdtTouchGrp" type="button" class="btn xCNBtnBrowseAddOn">
                                                                        <img class="xCNIconFind">
                                                                    </button>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                         </div>
                                        </div>
                                        </div>



                                        <!-- กำหนดข้อมูลเพิ่มเติมเกี่ยวกับสินค้า -->
                                        <div class="panel panel-default" style="margin-bottom: 25px;">
                                            <div id="odvHead2"  style="padding-top: 6px !important;padding-bottom: 5px !important;position: relative; background-color: #eeeeee1c;" class="panel-heading xCNPanelHeadBGColor xWPanelHeadMenuRpt" class="panel-heading xCNPanelHeadBGColor xWPanelHeadMenuRpt" role="tab">
                                                <label class="xCNTextDetail1"><?php echo language('product/product/product','tPdtAdditionalinfo');?></label>
                                                <a class="xCNMenuplus collapsed" role="button" data-toggle="collapse"  href="#odvPdtData2" aria-expanded="false">
                                                    <i class="fa fa-plus xCNPlus"></i>
                                                </a>
                                            </div>
                                            <div id="odvPdtData2" class="xCNMenuPanelData panel-collapse collapse" role="tabpanel" aria-expanded="false">
                                                <div class="panel-body xCNPDModlue" style="padding:25px;">
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                    <div class="table-responsive xCNTableScrollY">
                                                        <!-- Product Group -->
                                                        <div class="form-group">
                                                            <label class="xCNLabelFrm"><?php echo language('product/product/product','tPDTGroup')?></label>
                                                            <div class="input-group">
                                                                <input type="text" id="oetPdtPgpChain" class="form-control xCNHide" name="oetPdtPgpChain" value="<?php echo $tPgpChain;?>">
                                                                <input type="text" id="oetPdtPgpChainName" class="form-control" name="oetPdtPgpChainName" value="<?php echo $tPgpChainName;?>" readonly>
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
                                                                <input type="text" id="oetPdtPtyName" class="form-control" name="oetPdtPtyName" value="<?php echo $tPtyName;?>" readonly>
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
                                                                <input type="text" id="oetPdtPbnName" class="form-control" name="oetPdtPbnName" value="<?php echo $tPbnName;?>" readonly>
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
                                                                <input type="text" id="oetPdtPmoName" class="form-control" name="oetPdtPmoName" value="<?php echo $tPmoName;?>" readonly>
                                                                <span class="input-group-btn">
                                                                    <button id="obtBrowsePdtModel" type="button" class="btn xCNBtnBrowseAddOn">
                                                                        <img src="<?php echo base_url().'/application/modules/common/assets/images/icons/find-24.png'?>">
                                                                    </button>
                                                                </span>
                                                            </div>
                                                        </div>

                                                        <!-- Product Touch Group -->
                                                        <!-- <div class="form-group">
                                                            <label class="xCNLabelFrm"><?php echo language('product/product/product','tPDTTouchScreen');?></label>
                                                            <div class="input-group">
                                                                <input type="text" id="oetPdtTcgCode" class="form-control xCNHide" name="oetPdtTcgCode" value="<?php echo $tTcgCode;?>">
                                                                <input type="text" id="oetPdtTcgName" class="form-control"  name="oetPdtTcgName" value="<?php echo $tTcgName;?>" readonly>
                                                                <span class="input-group-btn">
                                                                    <button id="obtBrowsePdtTouchGrp" type="button" class="btn xCNBtnBrowseAddOn">
                                                                        <img class="xCNIconFind">
                                                                    </button>
                                                                </span>
                                                            </div>
                                                        </div> -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- กำหนดเงื่อนไขสินค้าใช้เฉพาะ -->
                                        <div class="panel panel-default" style="margin-bottom: 25px;">
                                            <div id="odvHead3"  style="padding-top: 6px !important;padding-bottom: 5px !important;position: relative; background-color: #eeeeee1c;" class="panel-heading xCNPanelHeadBGColor xWPanelHeadMenuRpt" class="panel-heading xCNPanelHeadBGColor xWPanelHeadMenuRpt" role="tab">
                                                <label class="xCNTextDetail1"><?php echo language('product/product/product','tPdtCondition');?></label>
                                                <a class="xCNMenuplus collapsed" role="button" data-toggle="collapse"  href="#odvPdtData3" aria-expanded="false">
                                                    <i class="fa fa-plus xCNPlus"></i>
                                                </a>
                                            </div>
                                            <div id="odvPdtData3" class="xCNMenuPanelData panel-collapse collapse" role="tabpanel" aria-expanded="false">
                                                <div class="panel-body xCNPDModlue" style="padding:25px;">
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                    <div class="table-responsive xCNTableScrollY">
                                                        <!-- Product Control Branch -->
                                                        <div class="form-group">
                                                            <label class="xCNLabelFrm"><?php echo language('product/product/product','tPDTBranch')?></label>
                                                            <div class="input-group">
                                                                <input type="text" id="oetPdtBchCode" class="form-control xCNHide" name="oetPdtBchCode" value="<?php echo @$tBchCode;?>">
                                                                <input type="text" id="oetPdtBchName" class="form-control" name="oetPdtBchName" value="<?php echo @$tBchName;?>" readonly>
                                                                <span class="input-group-btn">
                                                                    <?php
                                                                        // Last Update : 08/10/2019 Wasin(Yoshi)
                                                                        $tDisableBrowseBranch   = '';
                                                                        if($tRoute == 'productEventAdd'){
                                                                            // เข้ามาในกรณีที่เพิ่มสินค้าใหม่เท่านั้น
                                                                            if($this->session->userdata("tSesUsrLevel") == "BCH" || $this->session->userdata("tSesUsrLevel") == "SHP"){
                                                                                // เข้ามาในกรณีก็ต่อเมือ Session User Level เป็นระดับสาขา หรือ ระดับร้านค้า และ Session User Brach Code ต้องไม่เท่ากับค่าว่าง
                                                                                $tCheckBchCode    = $this->session->userdata('tSesUsrBchCode');
                                                                                if(isset($tCheckBchCode) && !empty($tCheckBchCode)){
                                                                                    $tDisableBrowseBranch   = ' disabled';
                                                                                }
                                                                            }
                                                                        }else{
                                                                            // เข้ามาในกรณีที่แก้ไขสินค้าใหม่เท่านั้น
                                                                            if($this->session->userdata("tSesUsrLevel") == "BCH" || $this->session->userdata("tSesUsrLevel") == "SHP"){
                                                                                // เข้ามาในกรณีก็ต่อเมือ Session User Level เป็นระดับสาขา หรือ ระดับร้านค้า และ Session User Brach Code และ ข้อมูลที่มาจาก DataBase ต้องไม่เท่ากับค่าว่าง
                                                                                $tCheckSessionBchCode   = $this->session->userdata('tSesUsrBchCode');
                                                                                $tCheckUserBchCode      = $tBchCode;
                                                                                if((isset($tCheckSessionBchCode) && !empty($tCheckSessionBchCode)) && (isset($tCheckUserBchCode) && !empty($tCheckUserBchCode))){
                                                                                    $tDisableBrowseBranch   = ' disabled';
                                                                                }
                                                                            }
                                                                        }
                                                                    ?>
                                                                    <button id="obtBrowseBranch" type="button" class="btn xCNBtnBrowseAddOn"<?php echo @$tDisableBrowseBranch;?>>
                                                                        <img class="xCNIconFind">
                                                                    </button>
                                                                </span>
                                                            </div>
                                                        </div> 

                                                         <!-- Product Merchant -->
                                                        <div class="form-group">
                                                            <label class="xCNLabelFrm"><?php echo language('product/product/product','tPDTMerchant')?></label>
                                                            <div class="input-group">
                                                                <input type="text" id="oetPdtMerCode" class="form-control xCNHide" name="oetPdtMerCode" value="<?php echo @$tPdtMerCode;?>">
                                                                <input type="text" id="oetPdtMerName" class="form-control" name="oetPdtMerName" value="<?php echo @$tPdtMerName;?>" readonly>
                                                                <span class="input-group-btn">
                                                                    <?php
                                                                        // Last Update : 08/10/2019 Wasin(Yoshi)
                                                                        $tDisableBrowseMechant  = '';
                                                                        if($tRoute == 'productEventAdd'){
                                                                            // เข้ามาในกรณีก็ต่อเมือ Session User Level เป็นระดับร้านค้า และ Session User Merchant Code ต้องไม่เท่ากับค่าว่าง
                                                                            if($this->session->userdata("tSesUsrLevel") == "SHP"){
                                                                                $tCheckMerCode    = $this->session->userdata('tSesUsrMerCode');
                                                                                if(isset($tCheckMerCode) && !empty($tCheckMerCode)){
                                                                                    $tDisableBrowseMechant  = ' disabled';
                                                                                }
                                                                            }
                                                                        }else{
                                                                            // เข้ามาในกรณีก็ต่อเมือ Session User Level ระดับร้านค้า และ Session User Merchant Code และ ข้อมูลที่มาจาก DataBase ต้องไม่เท่ากับค่าว่าง
                                                                            if($this->session->userdata("tSesUsrLevel") == "SHP"){
                                                                                $tCheckSessionMerCode   = $this->session->userdata('tSesUsrMerCode');
                                                                                $tCheckUserMerCode      = $tPdtMerCode;
                                                                                if((isset($tCheckSessionMerCode) && !empty($tCheckSessionMerCode)) && (isset($tCheckUserMerCode) && !empty($tCheckUserMerCode))){
                                                                                    $tDisableBrowseMechant  = ' disabled';
                                                                                }
                                                                            }
                                                                        }
                                                                    ?>
                                                                    <button id="obtBrowseMerchant" type="button" class="btn xCNBtnBrowseAddOn"<?php echo @$tDisableBrowseMechant;?>>
                                                                        <img class="xCNIconFind">
                                                                    </button>
                                                                </span>
                                                            </div>
                                                        </div>

                                                        <!-- Product Shop -->
                                                        <div class="form-group">
                                                            <label class="xCNLabelFrm"><?php echo language('product/product/product','tRETPDTSHP')?></label>
                                                            <div class="input-group">
                                                                <input type="text" id="oetPdtInfoShpCode" class="form-control xCNHide" name="oetPdtInfoShpCode" value="<?php echo @$tShpCode?>">
                                                                <input type="text" id="oetPdtInfoShpName" class="form-control" name="oetPdtInfoShpName" value="<?php echo @$tShpName?>" readonly>
                                                                <span class="input-group-btn">
                                                                    <?php
                                                                        // เช็คปิดปลุ่ม Browse Shop ในกรณีที่เข้ามาแบบ Add Page จะเช็คข้อมูลจาก Session Shop Code ว่ามีค่าเท่านั้นจึงจะปุ่ม แต่ถ้าเข้ามาแบบ Edit จะเช็คข้อมูลจาก Shop Type และ Session
                                                                        // Last Update : 08/10/2019 Wasin(Yoshi)
                                                                        $tDisableBrowseShop = '';
                                                                        if($tRoute == 'productEventAdd'){
                                                                            // Call In Event Add
                                                                            if($this->session->userdata("tSesUsrLevel") == "SHP"){
                                                                                $tCheckShpCode  = $this->session->userdata('tSesUsrShpCode');
                                                                                if(isset($tCheckShpCode) && !empty($tCheckShpCode)){
                                                                                    $tDisableBrowseShop = ' disabled';
                                                                                }
                                                                            }
                                                                        }else{
                                                                            // Call In Event Edit
                                                                            if($this->session->userdata("tSesUsrLevel") == "SHP"){
                                                                                $tCheckSessionShpCode   = $this->session->userdata('tSesUsrShpCode');
                                                                                $tCheckUserShpCode      = $tShpCode;
                                                                                if((isset($tCheckSessionShpCode) && !empty($tCheckSessionShpCode)) && (isset($tCheckUserShpCode) && !empty($tCheckUserShpCode))){
                                                                                    $tDisableBrowseShop  = ' disabled';
                                                                                }
                                                                            }else{
                                                                                if($tPdtForSystem == 4 && $tPdtRentType == 2){
                                                                                    $tDisableBrowseShop = ' disabled';
                                                                                }
                                                                            }
                                                                        }
                                                                    ?>
                                                                    <button id="obtBrowsePdtInfoShp" type="button" class="btn xCNBtnBrowseAddOn"<?php echo @$tDisableBrowseShop;?>>
                                                                        <img class="xCNIconFind">
                                                                    </button>
                                                                </span>
                                                            </div>
                                                        </div>
                                                        
                                                        <!-- Product Merchant -->
                                                        <div class="form-group">
                                                            <label class="xCNLabelFrm"><?php echo language('product/product/product','tRETPDTMGP')?></label>
                                                            <div class="input-group">
                                                                <input type="text" id="oetPdtInfoMgpCode" class="form-control xCNHide" name="oetPdtInfoMgpCode" value="<?php echo $tMgpCode?>">
                                                                <input type="text" id="oetPdtInfoMgpName" class="form-control" name="oetPdtInfoMgpName" value="<?php echo $tMgpName?>" readonly>
                                                                <span class="input-group-btn">
                                                                    <?php
                                                                        $tDisableBrowseMgp  = '';
                                                                        if($tRoute == 'productEventAdd'){
                                                                            if($this->session->userdata("tSesUsrLevel") == "BCH" || $this->session->userdata("tSesUsrLevel") == "SHP" ){
                                                                                $tCheckMerCode  = $this->session->userdata('tSesUsrMerCode');
                                                                                if(isset($tCheckMerCode) && empty($tCheckMerCode)){
                                                                                    $tDisableBrowseMgp  = ' disabled';
                                                                                }
                                                                            }
                                                                        }else{
                                                                            if($tPdtMerCode == ''){
                                                                                $tDisableBrowseMgp  = ' disabled';
                                                                            }
                                                                        }
                                                                    ?>
                                                                    <button id="obtBrowsePdtInfoMgp" type="button" class="btn xCNBtnBrowseAddOn"<?php echo @$tDisableBrowseMgp;?>>
                                                                        <img class="xCNIconFind">
                                                                    </button>
                                                                </span>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        </div>
                                        </div>

                                        <!-- กำหนดเงื่อนไขการควบคุมสต๊อก -->
                                        <div class="panel panel-default" style="margin-bottom: 25px;">
                                            <div id="odvHead4"  style="padding-top: 6px !important;padding-bottom: 5px !important;position: relative; background-color: #eeeeee1c;" class="panel-heading xCNPanelHeadBGColor xWPanelHeadMenuRpt" class="panel-heading xCNPanelHeadBGColor xWPanelHeadMenuRpt" role="tab">
                                                <label class="xCNTextDetail1"><?php echo language('product/product/product','tPdtConditionControlStk');?></label>
                                               <?php if($tRoute === "productEventEdit"):?>
                                                    <a class="xCNMenuplus collapsed" role="button" data-toggle="collapse"  href="#odvPdtData4" aria-expanded="false">
                                                        <i class="fa fa-plus xCNPlus"></i>
                                                    </a>
                                               <?php endif;?>
                                            </div>
                                            <div id="odvPdtData4" class="xCNMenuPanelData panel-collapse collapse" role="tabpanel" aria-expanded="false">
                                                <div class="panel-body xCNPDModlue" style="padding:25px;">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="table-responsive xCNTableScrollY">
                                                             <div id="odvStockConditions"></div>   
                                                        </div>
                                                    </div>
                                                </div>    
                                                </div>
                                            </div>
                                        </div>

                                        <!-- กำหนดเงื่อนไขการขาย  update(20/01/2020 :GolF)-->
                                        <div class="panel panel-default" style="margin-bottom: 25px;">
                                            <div id="odvHead5"  style="padding-top: 6px !important;padding-bottom: 5px !important;position: relative; background-color: #eeeeee1c;" class="panel-heading xCNPanelHeadBGColor xWPanelHeadMenuRpt" class="panel-heading xCNPanelHeadBGColor xWPanelHeadMenuRpt" role="tab">
                                                <label class="xCNTextDetail1"><?php echo language('product/product/product','tPdtConditionSale');?></label>
                                                <a class="xCNMenuplus collapsed" role="button" data-toggle="collapse"  href="#odvPdtData5" aria-expanded="false">
                                                    <i class="fa fa-plus xCNPlus"></i>
                                                </a>
                                            </div>

                                            <div id="odvPdtData5" class="xCNMenuPanelData panel-collapse collapse" role="tabpanel" aria-expanded="false">
                                                <div class="panel-body xCNPDModlue" style="padding:25px;">
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                    <div class="table-responsive xCNTableScrollY">

                                                    <!-- Product Date Sale Start -->
                                                    <div class="form-group">
                                                        <label class="xCNLabelFrm"><?php echo language('product/product/product','tPDTSaleStart');?></label>
                                                            <div class="input-group">
                                                                <input type="text" id="oetPdtSaleStart" class="form-control xCNDatePicker xCNInputMaskDate text-center" autocomplete="off" name="oetPdtSaleStart" value="<?php if($tPdtSaleStart != ""){ echo $tPdtSaleStart;}else{ echo $dGetDataNow; } ?> "> 
                                                                <span class="input-group-btn">
                                                                <button id="obtPdtSaleStart" type="button" class="btn xCNBtnDateTime">
                                                                    <img class="xCNIconFind">
                                                                </button>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <!-- end Product Date Sale Start -->
                                                    
                                                    <!-- Product Date Sale Stop -->
                                                    <div class="form-group">
                                                        <label class="xCNLabelFrm"><?php echo language('product/product/product','tPDTSaleStop');?></label>
                                                            <div class="input-group">
                                                                <input type="text" id="oetPdtSaleStop" class="form-control xCNDatePicker xCNInputMaskDate text-center" autocomplete="off" name="oetPdtSaleStop" value="<?php if($tPdtSaleStop != ""){ echo $tPdtSaleStop;}else{ echo $dGetDataFuture; } ?> ">
                                                                <span class="input-group-btn">
                                                                <button id="obtPdtSaleStop" type="button" class="btn xCNBtnDateTime">
                                                                    <img class="xCNIconFind">
                                                                </button>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <!-- end Product Date Sale Stop -->
                                                    
                                                    <!-- Product Product PointTime -->
                                                    <div class="form-group">
                                                        <label class="xCNLabelFrm"><?php echo language('product/product/product','tPDTPointTime');?></label>
                                                        <input type="text" id="oetPdtPointTime" class="form-control text-right xCNInputMaskCurrency" name="oetPdtPointTime" maxlength="18" placeholder="0" value="<?php echo number_format($tPdtPointTime,2);?>">
                                                    </div>
                                                    <!-- end Product Product PointTime -->

                                                    <!--ให้แต้ม -->
                                                    <div class="form-group">
                                                            <label class="fancy-checkbox">
                                                                <script>
                                                                    var tStaPoint = "<?php echo $tStaPoint;?>";
                                                                    if(typeof(tStaPoint) !== 'undefined' && tStaPoint == '1' || tStaNewPdt == '99'){
                                                                        $('#ocbPdtPoint').prop("checked",true);
                                                                    }else{
                                                                        $('#ocbPdtPoint').prop("checked",false);
                                                                    }
                                                                </script>
                                                        <input type="checkbox" id="ocbPdtPoint" name="ocbPdtPoint">
                                                        <span><?php echo language('product/product/product','tPDTGivePoint')?></span>
                                                    </label>
                                                    <!-- end ให้แต้ม -->    

                                                    <!-- เคลื่อนไหว -->
                                                    <label class="fancy-checkbox">
                                                            <script>
                                                                var tStaActive = "<?php echo $tStaActive;?>";
                                                                if(typeof(tStaActive) !== 'undefined' && tStaActive == '1' || tStaNewPdt == '99'){
                                                                    $('#ocbPdtStaActive').prop("checked",true);
                                                                }else{
                                                                    $('#ocbPdtStaActive').prop("checked",false);
                                                                }
                                                            </script>
                                                        <input type="checkbox" id="ocbPdtStaActive" name="ocbPdtStaActive">
                                                        <span><?php echo language('product/product/product','tPDTStaActive')?></span>
                                                    </label>
                                                    <!-- end เคลื่อนไหว -->

                                                    <!-- ตัดสต็อก -->
                                                    <label class="fancy-checkbox">
                                                            <script>
                                                                var tStaCheckStkControl = "<?php echo $tStkControl;?>";
                                                                if(typeof(tStaCheckStkControl) !== 'undefined' && tStaCheckStkControl == '1' || tStaNewPdt == '99'){
                                                                    $('#ocbPdtStkControl').prop("checked",true);
                                                                }else{
                                                                    $('#ocbPdtStkControl').prop("checked",false);
                                                                }
                                                            </script>
                                                            <input type="checkbox" id="ocbPdtStkControl" name="ocbPdtStkControl">
                                                        <span><?php echo language('product/product/product','tPDTStkControl')?></span>
                                                    </label>
                                                    <!-- end ตัดสต็อก -->

                                                    <!-- อนุญาติคืน -->
                                                    <label class="fancy-checkbox">
                                                            <script>
                                                                var tStaAlwReturn = "<?php echo $tStaAlwReturn;?>";
                                                                if(typeof(tStaAlwReturn) !== 'undefined' && tStaAlwReturn == '1' || tStaNewPdt == '99'){
                                                                    $('#ocbPdtStaAlwReturn').prop("checked",true);
                                                                }else{
                                                                    $('#ocbPdtStaAlwReturn').prop("checked",false);
                                                                }
                                                            </script>
                                                        <input type="checkbox" id="ocbPdtStaAlwReturn" name="ocbPdtStaAlwReturn">
                                                        <span><?php echo language('product/product/product','tPDTAlwReturn')?></span>
                                                    </label>
                                                    <!-- end อนุญาติคืน -->

                                                    <!-- ลดราคา -->
                                                    <label class="fancy-checkbox">
                                                            <script>
                                                                var tStaAlwDis = "<?php echo $tStaAlwDis;?>";
                                                                if(typeof(tStaAlwDis) !== 'undefined' && tStaAlwDis == '1' || tStaNewPdt == '99'){
                                                                    $('#ocbPdtStaAlwDis').prop("checked",true);
                                                                }else{
                                                                    $('#ocbPdtStaAlwDis').prop("checked",false);
                                                                }
                                                            </script>
                                                        <input type="checkbox" id="ocbPdtStaAlwDis" name="ocbPdtStaAlwDis">
                                                        <span><?php echo language('product/product/product','tPDTStaAlwDis')?></span>
                                                    </label> 
                                                    <!-- end ลดราคา -->

                                                            </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <!-- กำหนดเงื่อนไขต้นทุน -->
                                        <div class="panel panel-default" style="margin-bottom: 25px;">
                                            <div id="odvHead6"  style="padding-top: 6px !important;padding-bottom: 5px !important;position: relative; background-color: #eeeeee1c;" class="panel-heading xCNPanelHeadBGColor xWPanelHeadMenuRpt" class="panel-heading xCNPanelHeadBGColor xWPanelHeadMenuRpt" role="tab">
                                                <label class="xCNTextDetail1"><?php echo language('product/product/product','tPdtConditionCost');?></label>
                                                <a class="xCNMenuplus collapsed" role="button" data-toggle="collapse"  href="#odvPdtData6" aria-expanded="false">
                                                    <i class="fa fa-plus xCNPlus"></i>
                                                </a>
                                            </div>

                                            <div id="odvPdtData6" class="xCNMenuPanelData panel-collapse collapse" role="tabpanel" aria-expanded="false">
                                                <div class="panel-body xCNPDModlue" style="padding:25px;">
                                                <div class="row">
                                                    <div class="col-sm-8">
                                                        <div class="table-responsive xCNTableScrollY">

                                                        <!-- Product Product Cost Default -->
                                                        <div class="form-group">
                                                            <label class="xCNLabelFrm"><?php echo language('product/product/product','tPDTCostDef');?></label>
                                                            <input type="text" id="oetPdtCostDef" class="form-control text-right xCNInputMaskCurrency" name="oetPdtCostDef" maxlength="18" placeholder="0.00" value="<?php echo $tPdtCostDef;?>">
                                                        </div>
                                                        <!-- end Product Product Cost Default -->

                                                        <!-- Product Product Cost Other -->
                                                        <div class="form-group">
                                                            <label class="xCNLabelFrm"><?php echo language('product/product/product','tPDTCostOth');?></label>
                                                            <input type="text" id="oetPdtCostOth" class="form-control text-right xCNInputMaskCurrency" name="oetPdtCostOth" maxlength="18" placeholder="0.00" value="<?php echo $tPdtCostOth;?>">
                                                        </div>
                                                        <!-- end Product Product Cost Other -->
                                                        
                                                        <!-- Product Product Cost Standard -->
                                                        <div class="form-group">
                                                            <label class="xCNLabelFrm"><?php echo language('product/product/product','tPDTCostStd');?></label>
                                                            <input
                                                                type="text"
                                                                id="oetPdtCostStd"
                                                                class="form-control text-right xCNInputMaskCurrency"
                                                                name="oetPdtCostStd" maxlength="18" placeholder="0.00"
                                                                data-validate="<?php echo language('product/product/product','tPDTValidPdtCostStd');?>"
                                                                value="<?php echo $tPdtCostStd;?>">
                                                        </div>
                                                        <!-- end Product Product Cost Standard -->

                                                        <!-- Product Product Remark -->
                                                        <div class="form-group">
                                                            <label class="xCNLabelFrm"><?php echo language('product/product/product','tPDTRmk');?></label>
                                                            <textarea class="form-control" maxlength="200" rows="4" id="otaPdtRmk" name="otaPdtRmk"><?php echo $tPdtRmk;?></textarea>
                                                        </div> 
                                                         <!-- end Product Product Remark -->   
                                                        

                                                        </div>
                                                    </div>
                                                </div>


                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                   
                                    <div id="odvPdtContentHisPI" class="tab-pane fade">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                <div class="table-responsive">
                                                    <table id="otbPdtDataHisPI" class="table table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th nowrap class="text-center xCNTextBold" style="width:20%;"><?php echo language('product/product/product','tPDTHisPIDocNo');?></th>
                                                                <th nowrap class="text-center xCNTextBold"><?php echo language('product/product/product','tPDTHisPIDocDate');?></th>
                                                                <th nowrap class="text-center xCNTextBold"><?php echo language('product/product/product','tPDTHisPISupplier');?></th>
                                                                <th nowrap class="text-center xCNTextBold"><?php echo language('product/product/product','tPDTHisPIRef');?></th>
                                                                <th nowrap class="text-center xCNTextBold"><?php echo language('product/product/product','tPDTHisPIUnit');?></th>
                                                                <th nowrap class="text-center xCNTextBold"><?php echo language('product/product/product','tPDTHisPIQty');?></th>
                                                                <th nowrap class="text-center xCNTextBold"><?php echo language('product/product/product','tPDTHisPIQtyAll');?></th>
                                                                <th nowrap class="text-center xCNTextBold"><?php echo language('product/product/product','tPDTHisPISetPrice');?></th>
                                                                <th nowrap class="text-center xCNTextBold"><?php echo language('product/product/product','tPDTHisPIDis');?></th>
                                                                <th nowrap class="text-center xCNTextBold"><?php echo language('product/product/product','tPDTHisPIChg');?></th>
                                                                <th nowrap class="text-center xCNTextBold" style="width:10%;"><?php echo language('product/product/product','tPDTHisPINet');?></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php if(isset($aPdtHisPI) && !empty($aPdtHisPI)):?>
                                                                <?php foreach($aPdtHisPI AS $nKey => $aValue):?>
                                                                    <tr nowrap>
                                                                        <td class="text-center"><?php echo $aValue['FTXphDocNo'];?></td>
                                                                        <td class="text-center"><?php echo $aValue['FDXphDocDate'];?></td>
                                                                        <td class="text-left"><?php echo $aValue['FTSplName'];?></td>
                                                                        <td class="text-left"><?php echo $aValue['FTXphRefExt'];?></td>
                                                                        <td class="text-left"><?php echo $aValue['FTPunName'];?></td>
                                                                        <td class="text-center"><?php echo number_format($aValue['FCXpdQty'],0);?></td>
                                                                        <td class="text-center"><?php echo number_format($aValue['FCXpdQtyAll'],0);?></td>
                                                                        <td class="text-right"><?php echo number_format($aValue['FCXpdAmtB4DisChg'],2);?></td>
                                                                        <td class="text-right"><?php echo number_format($aValue['FCXpdDis'],2);?></td>
                                                                        <td class="text-right"><?php echo number_format($aValue['FCXpdChg'],2);?></td>
                                                                        <td class="text-right"><?php echo number_format($aValue['FCXpdNet'],2);?></td>
                                                                    </tr>
                                                                <?php endforeach;?>
                                                            <?php else:?>
                                                                <tr><td class='text-center xCNTextDetail2' colspan='100'><?php echo language('common/main/main', 'tCMNNotFoundData');?></td></tr>
                                                            <?php endif;?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>           
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tab Content Product Info 2 -->
                    <div id="odvPdtContentInfo2" class="tab-pane fade">
                        <div class="row">
                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                            </div>
                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                <!-- Product Product Qty Buy -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('product/product/product','tPDTQtyOrdBuy');?></label>
                                    <input type="text" id="oetPdtQtyOrdBuy" class="form-control text-right xCNInputNumericWithoutDecimal" name="oetPdtQtyOrdBuy" maxlength="18" placeholder="0" value="<?php echo number_format($tPdtQtyOrdBuy,2);?>">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                <!-- Product Product Max -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('product/product/product','tPDTMax');?></label>
                                    <input type="text" id="oetPdtMax" class="form-control text-right xCNInputNumericWithoutDecimal" name="oetPdtMax" maxlength="18" placeholder="0" value="<?php echo number_format($tPdtMax,2);?>">
                                </div>
                                <!-- Product Product Min -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('product/product/product','tPDTMin');?></label>
                                    <input type="text" id="oetPdtMin" class="form-control text-right xCNInputNumericWithoutDecimal" name="oetPdtMin" maxlength="18" placeholder="0" value="<?php echo number_format($tPdtMin,2);?>">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Create By Witsarut 16/01/2020 -->
                     <!-- Tab Content Drug -->
                     <div id="odvPdtContentDrug" class="tab-pane fade">
                        
                     </div>

                    <!-- Tab Content Product Rental -->
                    <div id="odvPdtContentRental" class="tab-pane fade">
                        <div class="row">
                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('product/product/product','tRETPDTType');?></label>
                                    <select class="selectpicker form-control" id="ocmRetPdtType" name="ocmRetPdtType" maxlength="1" onchange="JSxPdtRentSelectType(this.value)">
                                        <option value=""><?php echo language('product/product/product','tRETPDTType')?></option>
                                        <option value="1" <?php echo $tPdtRentType == "1" ? "selected" : "";?>><?php echo language('product/product/product','tRETPDTType1')?></option>
                                        <option value="2" <?php echo $tPdtRentType == "2" ? "selected" : "";?>><?php echo language('product/product/product','tRETPDTType2')?></option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('product/product/product','tRENPDTSta');?></label>
                                    <select class="selectpicker form-control" id="ocmRetPdtSta" name="ocmRetPdtSta" maxlength="1">
                                        <option value=""><?php echo language('product/product/product','tRENPDTSta')?></option>
                                        <option value="1" <?php echo $tPdtStaReqRet == "1" ? "selected" : "";?>><?php echo language('product/product/product','tRENPDTSta1')?></option>
                                        <option value="2" <?php echo $tPdtStaReqRet == "2" ? "selected" : "";?>><?php echo language('product/product/product','tRENPDTSta2')?></option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('product/product/product','tRENPDTStaPay');?></label>
                                    <select class="selectpicker form-control" id="ocmRetPdtStaPay" name="ocmRetPdtStaPay" maxlength="1">
                                        <option value=""><?php echo language('product/product/product','tRENPDTStaPay')?></option>
                                        <option value="1" <?php echo $tPdtStaPay == "1" ? "selected" : "";?>><?php echo language('product/product/product','tRENPDTStaPay1')?></option>
                                        <option value="2" <?php echo $tPdtStaPay == "2" ? "selected" : "";?>><?php echo language('product/product/product','tRENPDTStaPay2')?></option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('product/product/product','tRENPDTDeposit');?></label>
                                    <input type="text" id="oetRetPdtDeposit" class="form-control text-right xCNInputNumericWithoutDecimal" name="oetRetPdtDeposit" maxlength="18" placeholder="0" value="<?php echo $tPdtDeposit?>">
                                </div>

                                <div class="xWPdtRetBrwShp">
                                    <div class="form-group">
                                        <label class="xCNLabelFrm"><?php echo language('product/product/product','tRETPDTSHP')?></label>
                                        <div class="input-group">
                                            <input type="text" id="oetModalShopCode" class="form-control xCNHide" name="oetModalShpCode" value="<?php echo $tPdtRntShpCode?>">
                                            <input type="text" id="oetModalShopName" class="form-control xCNInputWithoutSpcNotThai" name="oetModalShpName" value="<?php echo $tPdtRntShpName?>" readonly>
                                            <span class="input-group-btn">
                                                <button id="obtBrowsePdtRetShop" type="button" class="btn xCNBtnBrowseAddOn">
                                                    <img class="xCNIconFind">
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tab Content Product Add Set -->
                    <div id="odvPdtContentSet" class="tab-pane fade">
                        <input id="oetPdtSetPdtCodeDup" class="xCNHide" value="">
                        <div id="odvPdtSetMenuSelectPdt" class="row">
                            <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9" style="margin-bottom:10px;">
                                <label id="olbPdtSetInfo" class="xCNLabelFrm xCNLinkClick"><?=language('product/product/product','tPDTTabSet')?></label>
                                <label id="olbPdtSetAdd" class="xCNLabelFrm xCNHide"> / <?=language('common/main/main','tAdd')?></label>
                                <label id="olbPdtSetEdit" class="xCNLabelFrm xCNHide"> / <?=language('common/main/main','tEdit')?></label>
                                <div id="odvPdtSetSubMenuSta" class="row" style="padding-left:15px;">
                                    <div class="col-xs-12 col-sm-5 col-md-5 col-lg-5 alert alert-info" style="padding:5px;margin-bottom:0px;padding-left:10px;margin-right:15px;">
                                        <label class="xCNLabelFrm" style="margin-right: 10px;"><?=language('product/product/product','tPdtStaSetPri')?> : </label>
                                        <label class="radio-inline"><input type="radio" name="orbPdtStaSetPri" class="xWPdtStaSetPri" value="1" <?php if($tPdtStaSetPri == '1'){ echo "checked"; } ?>><?=language('product/product/product','tPdtStaSetPri1')?></label>
                                        <label class="radio-inline"><input type="radio" name="orbPdtStaSetPri" class="xWPdtStaSetPri" value="2" <?php if($tPdtStaSetPri == '2'){ echo "checked"; } ?>><?=language('product/product/product','tPdtStaSetPri2')?></label>
                                    </div>

                                    <div class="col-xs-12 col-sm-5 col-md-5 col-lg-5 alert alert-info" style="padding:5px;margin-bottom:0px;padding-left:10px;">
                                        <label class="xCNLabelFrm" style="margin-right: 10px;"><?=language('product/product/product','tPdtStaSetShwDT')?> : </label>
                                        <label class="radio-inline"><input type="radio" name="orbPdtStaSetShwDT" class="xWPdtStaSetShwDT" value="1" <?php if($tPdtStaSetShwDT == '1'){ echo "checked"; } ?>><?=language('product/product/product','tPdtStaSetShwDT1')?></label>
                                        <label class="radio-inline"><input type="radio" name="orbPdtStaSetShwDT" class="xWPdtStaSetShwDT" value="2" <?php if($tPdtStaSetShwDT == '2'){ echo "checked"; } ?>><?=language('product/product/product','tPdtStaSetShwDT2')?></label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 text-right" style="margin-bottom:10px;">
                                <button id="obtPdtSetAdd" class="xCNBTNPrimeryPlus" type="button">+</button>
                                <button id="obtPdtSetBack" class="btn xCNHide" type="button" style="background-color: #D4D4D4; color: #000000;"><?=language('common/main/main','tCancel')?></button>
                                <button id="obtPdtSetSave" class="btn xCNHide" type="submit"  style="background-color: rgb(23, 155, 253); color: white;"><?=language('common/main/main','tSave')?></button>
                            </div>
                        </div>

                        <div id="odvPdtSetTable" class="row">
                            <!-- DataTable Product Set -->
                            <div id="odvPdtSetDataTable" class="table-responsive"></div>
                            <!-- End DataTable Product Set -->
                            
                            <input type="hidden" id="ohdPdtSetCode" name="ohdPdtSetCode" value="<?php echo substr(@$tTextPdtCodeSet,0,-1);?>">
                            <input type="hidden" id="ohdPdtSetName" name="ohdPdtSetName" value="<?php echo substr(@$tTextPdtNameSet,0,-1);?>">
                            <input type="hidden" id="ohdPdtSetStaEditInline" name="ohdPdtSetStaEditInline" value="0">
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
        <div class="modal-dialog modal-lg" role="document">
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
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <!-- Modal Manage PackSize Unit Fact -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('product/product/product','tPDTViewPackMDUnitFact');?></label>
                                    <input type="text" id="oetModalPszUnitFact" class="form-control text-right xCNInputNumericWithDecimal" maxlength="18" name="oetModalPszUnitFact">
                                </div>
                                <!-- Modal Manage PackSize Grade -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('product/product/product','tPDTViewPackMDGrade');?></label>
                                    <input type="text" id="oetModalPszGrade" class="form-control text-right xCNInputWithoutSpc" name="oetModalPszGrade">
                                </div>
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('product/product/product','tPDTViewPackMDWeight');?></label>
                                    <input type="text" id="oetModalPszWeight" class="form-control text-right xCNInputNumericWithDecimal" name="oetModalPszWeight">
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
                            
                        </div>
                        <div class="row">
                            
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <hr>
                                <!-- Modal Manage PackSize Unit Dim -->
                                <label class="xCNLabelFrm"><?php echo language('product/product/product','tPDTViewPackMDUnitDim');?></label>
                                <div class="form-group">
                                    <label class="xCNLabelFrm" style="font-size:18px !important"><?php echo language('product/product/product','tPDTViewPackMDWidth');?></label>
                                    <input type="text" id="oetModalPszUnitDimWidth" class="form-control" name="oetModalPszUnitDimWidth">
                                </div>
                                <div class="form-group">
                                    <label class="xCNLabelFrm" style="font-size:18px !important"><?php echo language('product/product/product','tPDTViewPackMDLength');?></label>
                                    <input type="text" id="oetModalPszUnitDimLength" class="form-control" name="oetModalPszUnitDimLength">
                                </div>
                                <div class="form-group">
                                    <label class="xCNLabelFrm" style="font-size:18px !important"><?php echo language('product/product/product','tPDTViewPackMDHeight');?></label>
                                    <input type="text" id="oetModalPszUnitDimHeight" class="form-control" name="oetModalPszUnitDimHeight">
                                </div>
                            
                                <hr>
                                <!-- Modal Manage PackSize Package Dim -->
                                <label class="xCNLabelFrm"><?php echo language('product/product/product','tPDTViewPackMDPkgDim');?></label>
                                    
                                <div class="form-group">
                                    <label class="xCNLabelFrm" style="font-size:18px !important"><?php echo language('product/product/product','tPDTViewPackMDWidth');?></label>
                                    <input type="text" id="oetModalPszPackageDimWidth" class="form-control" name="oetModalPszPackageDimWidth">
                                </div>
                                <div class="form-group">
                                    <label class="xCNLabelFrm" style="font-size:18px !important"><?php echo language('product/product/product','tPDTViewPackMDLength');?></label>
                                    <input type="text" id="oetModalPszPackageDimLength" class="form-control" name="oetModalPszPackageDimLength">
                                </div>
                                <div class="form-group">
                                    <label class="xCNLabelFrm" style="font-size:18px !important"><?php echo language('product/product/product','tPDTViewPackMDHeight');?></label>
                                    <input type="text" id="oetModalPszPackageDimHeight" class="form-control" name="oetModalPszPackageDimHeight">
                                </div>
                                    
                                
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                <!-- Modal Manage PackSize StaAlwPick -->
                                <label class="fancy-checkbox">
                                    <input type="checkbox" id="ocbModalPszStaAlwPick" name="ocbModalPszStaAlwPick">
                                    <span><?php echo language('product/product/product','tPDTViewPackMDStaAlwPick')?></span>
                                </label>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                <!-- Modal Manage PackSize StaAlwPoHQ -->
                                <label class="fancy-checkbox">
                                    <input type="checkbox" id="ocbModalPszStaAlwPoHQ" name="ocbModalPszStaAlwPoHQ">
                                    <span><?php echo language('product/product/product','tPDTViewPackMDStaAlwPoHQ')?></span>
                                </label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                <!-- Modal Manage PackSize StaAlwBuy -->
                                <label class="fancy-checkbox">
                                    <input type="checkbox" id="ocbModalPszStaAlwBuy" name="ocbModalPszStaAlwBuy">
                                    <span><?php echo language('product/product/product','tPDTViewPackMDStaAlwBuy')?></span>
                                </label>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
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
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header xCNModalHead">
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                            <label class="xCNTextModalHeard"><?php echo language('product/product/product','tPDTViewPackMngBarCode');?></label>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-right">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:#FFF;opacity:1;margin-top:-11px;">
                                <span aria-hidden="true" style="font-size: 30px !important;">×</span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="panel-body" style="padding:10px">
                        <div class="row">
                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                <form action="javascript:void(0);" id="ofmModalAebBarCode" class="validate-form">
                                    <button type="submit" id="obtModalAebBarCodeSubmit" class="xCNHide"></button>
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <!-- Modal Add/Edit BarCode -->
                                        <div class="form-group">
                                            <label class="xCNLabelFrm"><span style="color:red">*</span> <?php echo language('product/product/product','tPDTViewPackMDBarCode');?></label>
                                            <input type="text" id="oetModalAebOldBarCode" class="form-control xCNHide" name="oetModalAebOldBarCode">
                                            <input 
                                                type="text"
                                                id="oetModalAebBarCode"
                                                class="form-control xCNInputWithoutSpcNotThai xCNInputWithoutSingleQuote"
                                                name="oetModalAebBarCode"
                                                autocomplete="off"
                                                maxlength="25"
                                                placeholder = "<?php echo language('product/product/product','tPDTViewPackMDPachBarCode');?>"
                                                data-validate-required = "<?php echo language('product/product/product','tPDTViewPackMDPachBarCode');?>"
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
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
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
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <!-- Modal Add/Edit BarCode StaUse -->
                                        <label class="fancy-checkbox">
                                            <input type="checkbox" id="ocbModalAebBarStaUse" name="ocbModalAebBarStaUse">
                                            <span><?php echo language('product/product/product','tPDTViewPackMDBarStaUse')?></span>
                                        </label>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <!-- Modal Add/Edit BarCode StaUse -->
                                        <label class="fancy-checkbox">
                                            <input type="checkbox" id="ocbModalAebBarStaAlwSale" name="ocbModalAebBarStaAlwSale">
                                            <span><?php echo language('product/product/product','tPDTViewPackMDBarAlwSale')?></span>
                                        </label>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <!-- Modal Set Status Supplier Allow PO -->
                                        <label class="fancy-checkbox">
                                            <input type="checkbox" id="ocbModalAesSplStaAlwPO" name="ocbModalAesSplStaAlwPO">
                                            <span><?php echo language('product/product/product','tPDTViewPackMDSplStaAlwPO')?></span>
                                        </label>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-center" style="margin-top:15px;">
                                                <button onclick="JSxPdtModalBarCodeClear()" class="btn xCNBTNDefult xCNBTNDefult2Btn"><?php echo language('product/product/product','tPDTViewPackBTNReset');?></button>
                                            </div>
                                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-center" style="margin-top:15px;">
                                                <input type="hidden" name="oetEditData" id="oetEditData" value="0" />
                                                <button class="btn xCNBTNPrimery xCNBTNPrimery2Btn xWPDTSubmitAddBar"><?php echo language('product/product/product','tPDTViewPackSaveManage');?></button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                                <!-- <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <input type="hidden" id="ohdModalFTSplStaAlwPO" class="form-control">
                                        <input type="hidden" id="ohdModalAebStaCallAddOrEdit" class="form-control" name="ohdModalAebStaCallAddOrEdit">
                                        <input type="hidden" id="ohdModalAebUnitCode" class="form-control" name="ohdModalAebUnitCode">
                                        <input type="hidden" id="ohdModalAebUnitName" class="form-control" name="ohdModalAebUnitName">
                                        <label id="olbModalAebUnitTitle" class="xCNTitleFrom" data-puncode="" style="margin-bottom: 0px;">หน่วย : ชิ้น</label>
                                    </div>
                                </div> -->
                                    
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <input type="hidden" id="ohdModalFTPunCode" class="form-control">
                                        <input type="hidden" id="ohdModalFTPdtCode" class="form-control">

                                        <div class="alert alert-info" role="alert">
                                            <div class="row">
                                                <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3"><?php echo language('product/product/product','tPDTSetPdtCode')?></div>
                                                <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9"><span id="ospTxtPdtCode"></span></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3"><?php echo language('product/product/product','tPDTSetPdtName')?></div>
                                                <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9"><span id="ospTxtPdtName"></span></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3"><?php echo language('product/product/product','tPDTTitleUnit')?></div>
                                                <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9"><span id="ospTxtPunName"></span></div>
                                            </div>
                                        </div>

                                        <div class="xWModalBarCodeDataTable"></div>
                                    </div>
                                </div>

                                
                            </div>
                        </div>

                        <!-- <div class="row">
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
                                    
                                    <label class="fancy-checkbox">
                                        <input type="checkbox" id="ocbModalAebBarStaUse" name="ocbModalAebBarStaUse">
                                        <span><?php echo language('product/product/product','tPDTViewPackMDBarStaUse')?></span>
                                    </label>
                                </div>
                                <div class="col-xs-4 col-sm-3 col-md-3 col-lg-3">
                                    
                                    <label class="fancy-checkbox">
                                        <input type="checkbox" id="ocbModalAebBarStaAlwSale" name="ocbModalAebBarStaAlwSale">
                                        <span><?php echo language('product/product/product','tPDTViewPackMDBarAlwSale')?></span>
                                    </label>
                                </div>
                            </form>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<script src="<?php echo base_url(); ?>application/modules/common/assets/js/jquery.mask.js"></script>
<script src="<?php echo base_url(); ?>application/modules/common/assets/src/jFormValidate.js"></script>
<?php include "script/jProductAdd.php"; ?>

<script type="text/javascript">

  // เวลา Click Tab ให้ Button Show
   $('.xCNStaHideShow').click(function(){
        $('#odvBtnPdtAddEdit').show();
   });

   // เวลา Click Tab ให้ Button Show
    $('#obtBrowsePdtRetShop').click(function(){
      JCNxBrowseData('oCmpBrowseProduct');
    });
    var nLangEdits  = <?php echo $this->session->userdata("tLangEdit")?>;
    var nUseType = $('#oetUseType').val();
    var nShpCode = $('#oetShpCode').val();
    var nBchCode = $('#oetBchCode').val();
    
    //เช็คผู้ใช้
    switch (nUseType) {
        case  "HQ": 
            tWhereIn = " " 
        break;
        case  "BCH": 
            tWhereIn = "AND TCNMShop.FTBchCode = '"+nBchCode+"' "
        break;
        case  "SHP": 
            tWhereIn = "AND TCNMShop.FTBchCode = '"+nBchCode+"' AND TCNMShop.FTShpCode = '"+nShpCode+"' "
        break;
        default: 
            tWhereIn = " "
    }

    // //Option Product
    var oCmpBrowseProduct = {
        Title : ['company/shop/shop','tSHPTitle'],
        Table:{Master:'TCNMShop',PK:'FTShpCode'},
        Join :{
            Table:	['TCNMShop_L'],
            On:['TCNMShop_L.FTShpCode = TCNMShop.FTShpCode AND TCNMShop_L.FNLngID = '+nLangEdits,  ]
        },
        Where :{
                Condition : [" AND TCNMShop.FTShpType = '5' "+tWhereIn+" "]
            }, 
        GrideView:{
            ColumnPathLang	: 'company/shop/shop',
            ColumnKeyLang	: ['tShopCode','tShopName'],
            DataColumns		: ['TCNMShop.FTShpCode','TCNMShop_L.FTShpName'],
            Perpage			: 10,
            OrderBy			: ['TCNMShop.FTShpCode'],
            SourceOrder		: "ASC"
        },
        CallBack:{
            ReturnType	: 'S',
            Value		: ["oetModalShopCode","TCNMShop.FTShpCode"],
            Text		: ["oetModalShopName","TCNMShop_L.FTShpName"],
        },
        // RouteAddNew : 'shop',
        // BrowseLev : nStaCmpBrowseType
        //  DebugSQL : true
    }

    // Create By Witsarut 16/01/2020
    // Function CheckType = 5 (Drug)
    // $(function(){
    //     $('#ocmPdtType').change(function(){
    //         var nPdtType = $('#ocmPdtType').val();
    //         if(nPdtType == 5){
    //             $('#oliPdtDataDrug').removeClass('disabled ').removeClass('xCNCloseTabNav');
    //             $('#oliPdtDataDrug a').attr('data-toggle','tab');
    //             // $('#oliPdtDataDrug').addClass('disabled').addClass('xCNCloseTabNav');
    //             // $('#oliPdtDataDrug a').attr('data-toggle','');
    //         }
    //     });
    // });

    // Create By Witsarut 
    // Fucntion: Slide Panal
    $('.xCNMenuplus').unbind().click(function(){
        //เปิดแค่ panal เดียว
        if($(this).hasClass('collapsed')){
            $('.xCNMenuplus').removeClass('collapsed').addClass('collapsed');
            $('.xCNMenuPanelData').removeClass('in');
        }
    });

</script>

