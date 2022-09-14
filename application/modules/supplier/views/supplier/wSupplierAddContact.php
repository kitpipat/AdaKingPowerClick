<?php
if($nStaAddOrEdit==1){
    $tRout                ="supplierEventEditContact";
    $tFTSplCode           = $aSplContactData['raItems']['FTSplCode'];//
    $nFNCtrSeqNo          = $aSplContactData['raItems']['FNCtrSeq'];
    $tFTCtrAddName        = $aSplContactData['raItems']['FTCtrName'];
    $tFTCtrAddEmail       = $aSplContactData['raItems']['FTCtrEmail'];
    $tFTCtrAddTel         = $aSplContactData['raItems']['FTCtrTel'];
    $tFTCtrAddFax         = $aSplContactData['raItems']['FTCtrFax'];
    $tCtrFTAddRmk         = $aSplContactData['raItems']['FTCtrRmk'];
    
}else{
    $tRout             ="supplierEventAddContact";
    $tFTSplCode        = "";
    $nFNCtrSeqNo       = "";
    $tFTCtrAddName     = "";
    $tFTCtrAddEmail    = "";
    $tFTCtrAddTel      = "";
    $tFTCtrAddFax      = "";
    $tCtrFTAddRmk      = "";
    
}
// print_r($aData);
?>
<br> 
<form class="contact100-form validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" id="ofmAddContact">
                <div class="demo-button xCNBtngroup" style="width:100%;" align="right">
                    <button class="btn" type="reset"   style="background-color: #D4D4D4; color: #000000;" onclick="JSxContactDatatable($('#ohdSupcode').val())" ><?php echo language('supplier/supplier/supplier','tSPLTBReset')?></button>
                    <button type="submit" class="btn" onclick="JSoAddEditSupplierContact('<?php echo $tRout;?>', $('#ohdSupcode').val(), $('#ohdSeqNo').val())" style="background-color:#179BFD; color:white;"><?php echo language('common/main/main', 'tSave')?></button>
                </div>
    <input type="hidden" class="form-control" id="ohdSeqNo" name="ohdSeqNo" value="<?php echo $nFNCtrSeqNo ; ?>">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-8 col-md-8">
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <div  class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('supplier/supplier/supplier','tContactName')?></label>
                            <div class="form-group">
                                <input type="text"
                                class="form-control"
                                maxlength="200" id="oetCtrAddName" name="oetCtrAddName" 
                                data-is-created=""
                                value="<?php echo $tFTCtrAddName ; ?>">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <div  class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('supplier/supplier/supplier','tAddContactmail')?></label>
                            <div class="form-group">
                                <input type="text"
                                class="form-control"
                                maxlength="50" id="oetCtrAddEmail" name="oetCtrAddEmail" 
                                data-is-created=""
                                value="<?php echo $tFTCtrAddEmail ; ?>">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <div  class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('supplier/supplier/supplier','tAddContactTel')?></label>
                            <div class="form-group">
                                <input type="text"
                                class="form-control xCNInputNumericWithoutDecimal"
                                maxlength="50" id="oetCtrAddTel" name="oetCtrAddTel" 
                                data-is-created=""
                                value="<?php echo $tFTCtrAddTel ; ?>">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <div  class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('supplier/supplier/supplier','tAddContactFax')?></label>
                            <div class="form-group">
                                <input type="text"
                                class="form-control xCNInputNumericWithoutDecimal"
                                maxlength="50" id="oetCtrAddFax" name="oetCtrAddFax" 
                                data-is-created=""
                                value="<?php echo $tFTCtrAddFax ; ?>">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <div  class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('supplier/supplier/supplier','tCtrRmk')?></label>
                            <div class="form-group">
                                <textarea class="form-group" rows="4" maxlength="100" id="oetCtrAddNote" name="oetCtrAddNote"><?php echo $tCtrFTAddRmk ; ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-6 col-md-6">
            <br>
                <div class="form-group">
                    <div id="odvMapEdit" class="xCNMapShow"></div>
                </div>
             </div>
        </div>
    </div>
</form>
<script src="<?= base_url('application/modules/common/assets/js/jquery.mask.js')?>"></script>
<script src="<?= base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>