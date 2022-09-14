<style>
.xPadding30 {
    padding-left: 30px;
    padding-right: 30px;
    padding-bottom: 30px;
}
.xPaddingTop15 {
    padding-top: 15px;
}
.xPaddingTop25 {
    padding-top: 25px;
}
</style>
<div class="row">
<form  action="javascript:void(0)" method="post" enctype="multipart/form-data" id="ofmAdjustProduct">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 xPadding30">

        <div class="xCNTabCondition"><label class="xCNTabConditionHeader xCNLabelFrm"><h3><?= language('product/product/product','tAdjPdtCondition')?></h3></label>
                     
                        <div class="row xPaddingTop30" >

                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?= language('product/product/product','tAdjPdtTable')?></label>
                                    <!-- <div class="input-group"> -->
                                        <select class="selectpicker form-control" name="ocmAJPSelectTable" id="ocmAJPSelectTable">
                                            <option value="TCNMPdt"><?= language('product/product/product','tAdjPdtLevel1')?></option>
                                            <option value="TCNMPdtPackSize"><?= language('product/product/product','tAdjPdtLevel2')?></option>
                                            <option value="TCNMPdtBar"><?= language('product/product/product','tAdjPdtLevel3')?></option>
                                        </select>
                                    <!-- </div> -->
                                </div>
                            </div>

                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?= language('product/product/product','tAdjPdtField')?></label>
                                    <select class="selectpicker form-control" name="ocmAJPSelectField" id="ocmAJPSelectField"></select>
                                </div>
                            </div>

                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?= language('product/product/product','tAdjPdtValue')?></label>
                                    <select class="selectpicker form-control" name="ocmAJPSelectValue" id="ocmAJPSelectValue"></select>
                                </div>
                            </div>

                        </div>
                       
         </div>


         <div class="row xPaddingTop15">

                <div class="col-xs-12 col-sm-6 col-md-2 col-lg-2">
                    <div class="form-group">
                        <label class="xCNLabelFrm"><?= language('product/product/product','tAdjPdtFilAgency')?></label>
                        <div class="input-group">
                            <input class="form-control xCNHide" id="oetAJPAgnCode" name="oetAJPAgnCode" value="<?=$this->session->userdata('tSesUsrAgnCode')?>" >
                            <input
                                class="form-control xWPointerEventNone"
                                type="text"
                                id="oetAJPAgnName"
                                name="oetAJPAgnName"
                                value="<?=$this->session->userdata('tSesUsrAgnName')?>"
                                placeholder="<?= language('product/product/product','tAdjPdtFilAgency')?>"
                                readonly
                            >
                            <span class="input-group-btn">
                                <button id="obtAJPBrowsAgn" type="button" class="btn xCNBtnBrowseAddOn" <?php if($this->session->userdata('tSesUsrAgnName')!=''){ echo 'disabled'; } ?>><img class="xCNIconFind"></button>
                            </span>
                        </div>
                    </div>
                </div>
                <?php 
                if(!FCNbUsrIsAgnLevel() && $this->session->userdata('tSesUsrLevel')!='HQ'){
                    $tBchCode       = $this->session->userdata("tSesUsrBchCodeDefault");
                    $tBchName       = $this->session->userdata("tSesUsrBchNameDefault");
                    }else{
                    $tBchCode       = '';
                    $tBchName       = '';
                }
                ?>
                <div class="col-xs-12 col-sm-6 col-md-2 col-lg-2">
                    <div class="form-group">
                        <label class="xCNLabelFrm"><?= language('product/product/product','tAdjPdtFilBranch')?></label>
                        <div class="input-group">
                            <input class="form-control xCNHide" id="oetAJPBchCode" name="oetAJPBchCode" value="<?=$tBchCode?>" >
                            <input
                                class="form-control xWPointerEventNone"
                                type="text"
                                id="oetAJPBchName"
                                name="oetAJPBchName"
                                value="<?=$tBchName?>"
                                placeholder="<?= language('product/product/product','tAdjPdtFilBranch')?>"
                                readonly
                            >
                            <span class="input-group-btn">
                                <button id="obtAJPBrowsBch" type="button" class="btn xCNBtnBrowseAddOn" ><img class="xCNIconFind"></button>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="col-xs-12 col-sm-6 col-md-2 col-lg-2">
                    <div class="form-group">
                        <label class="xCNLabelFrm"><?= language('product/product/product','tAdjPdtFilFrom')?></label>
                        <div class="input-group">
                            <input class="form-control xCNHide" id="oetAJPPdtCodeFrom" name="oetAJPPdtCodeFrom" >
                            <input
                                class="form-control xWPointerEventNone"
                                type="text"
                                id="oetAJPPdtNameFrom"
                                name="oetAJPPdtNameFrom"
                                placeholder="<?= language('product/product/product','tAdjPdtFilFrom')?>"
                                readonly
                            >
                            <span class="input-group-btn">
                                <button id="obtAJPBrowsPdtFrom" type="button" class="btn xCNBtnBrowseAddOn" ><img class="xCNIconFind"></button>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="col-xs-12 col-sm-6 col-md-2 col-lg-2">
                    <div class="form-group">
                        <label class="xCNLabelFrm"><?= language('product/product/product','tAdjPdtFilTo')?></label>
                        <div class="input-group">
                            <input class="form-control xCNHide" id="oetAJPPdtCodeTo" name="oetAJPPdtCodeTo" >
                            <input
                                class="form-control xWPointerEventNone"
                                type="text"
                                id="oetAJPPdtNameTo"
                                name="oetAJPPdtNameTo"
                                placeholder="<?= language('product/product/product','tAdjPdtFilTo')?>"
                                readonly
                            >
                            <span class="input-group-btn">
                                <button id="obtAJPBrowsPdtTo" type="button" class="btn xCNBtnBrowseAddOn" ><img class="xCNIconFind"></button>
                            </span>
                        </div>
                    </div>
                </div>
                

                <div class="col-xs-12 col-sm-6 col-md-2 col-lg-2">
                    <div class="form-group">
                        <label class="xCNLabelFrm"><?= language('product/product/product','tAdjPdtFilGroup')?></label>
                        <div class="input-group">
                            <input class="form-control xCNHide" id="oetAJPPgpCode" name="oetAJPPgpCode" >
                            <input
                                class="form-control xWPointerEventNone"
                                type="text"
                                id="oetAJPPgpName"
                                name="oetAJPPgpName"
                                placeholder="<?= language('product/product/product','tAdjPdtFilGroup')?>"
                                readonly
                            >
                            <span class="input-group-btn">
                                <button id="obtAJPBrowsPgp" type="button" class="btn xCNBtnBrowseAddOn" ><img class="xCNIconFind"></button>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="col-xs-12 col-sm-6 col-md-2 col-lg-2">
                    <div class="form-group">
                        <label class="xCNLabelFrm"><?= language('product/product/product','tAdjPdtFilBrand')?></label>
                        <div class="input-group">
                            <input class="form-control xCNHide" id="oetAJPPbnCode" name="oetAJPPbnCode" >
                            <input
                                class="form-control xWPointerEventNone"
                                type="text"
                                id="oetAJPPbnName"
                                name="oetAJPPbnName"
                                placeholder="<?= language('product/product/product','tAdjPdtFilBrand')?>"
                                readonly
                            >
                            <span class="input-group-btn">
                                <button id="obtAJPBrowsPbn" type="button" class="btn xCNBtnBrowseAddOn" ><img class="xCNIconFind"></button>
                            </span>
                        </div>
                    </div>
                </div>


                <div class="col-xs-12 col-sm-6 col-md-2 col-lg-2">
                    <div class="form-group">
                        <label class="xCNLabelFrm"><?= language('product/product/product','tAdjPdtFilModel')?></label>
                        <div class="input-group">
                            <input class="form-control xCNHide" id="oetAJPPmoCode" name="oetAJPPmoCode" >
                            <input
                                class="form-control xWPointerEventNone"
                                type="text"
                                id="oetAJPPmoName"
                                name="oetAJPPmoName"
                                placeholder="<?= language('product/product/product','tAdjPdtFilModel')?>"
                                readonly
                            >
                            <span class="input-group-btn">
                                <button id="obtAJPBrowsPmo" type="button" class="btn xCNBtnBrowseAddOn" ><img class="xCNIconFind"></button>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="col-xs-12 col-sm-6 col-md-2 col-lg-2">
                    <div class="form-group">
                        <label class="xCNLabelFrm"><?= language('product/product/product','tAdjPdtFilType')?></label>
                        <div class="input-group">
                            <input class="form-control xCNHide" id="oetAJPPtyCode" name="oetAJPPtyCode" >
                            <input
                                class="form-control xWPointerEventNone"
                                type="text"
                                id="oetAJPPtyName"
                                name="oetAJPPtyName"
                                placeholder="<?= language('product/product/product','tAdjPdtFilType')?>"
                                readonly
                            >
                            <span class="input-group-btn">
                                <button id="obtAJPBrowsPty" type="button" class="btn xCNBtnBrowseAddOn" ><img class="xCNIconFind"></button>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="col-xs-12 col-sm-6 col-md-2 col-lg-2">
                    <div class="form-group">
                        <label class="xCNLabelFrm"><?= language('product/product/product','tAdjPdtFilStaAlwHQ')?></label>
                        <select class="selectpicker form-control" name="ocmAJPStaAlwPoHQ" id="ocmAJPStaAlwPoHQ">
                            <option value=""><?= language('product/product/product','tAdjPdtFilStaAlwHQ1')?></option>
                            <option value="1"><?= language('product/product/product','tAdjPdtFilStaAlwHQ2')?></option>
                            <option value="2"><?= language('product/product/product','tAdjPdtFilStaAlwHQ3')?></option>
                        </select>
                    </div>
                </div>

                <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 xPaddingTop25" >
                    <button  class="btn xCNBTNDefult xCNBTNDefult2Btn" style="width:30%" type="button" onclick="JSxClearConditionAll()"> <?= language('product/product/product','tAdjPdtClearFilter')?></button>
                    <button id="obtMainAdjustProductFilter" type="button"  style="width:30%" class="btn btn xCNBTNPrimery xCNBTNPrimery2Btn"> <?= language('product/product/product','tAdjPdtFilter')?></button>
                </div>
         </div>

        <hr>

        <div class="row xPaddingTop15" id="odvAJPDataTable">
                    
        </div>  


    </div>
</form>
</div>
<?php include "script/jAdjustProductPageFrom.php"; ?>
