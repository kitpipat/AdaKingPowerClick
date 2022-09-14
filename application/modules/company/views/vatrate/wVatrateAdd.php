<style>
    .xWVat.active{
        border: 1px solid #cccccc;
    }
    .xWVat.active:focus{
        border: 1px solid #00a0f0 !important;
        -webkit-box-shadow: 0px 1px 2px 0 rgba(0, 0, 0, 0.2);
        box-shadow: 0px 1px 2px 0 rgba(0, 0, 0, 0.2);
    }
    .record-invalid{
        color: #a94442 !important;
    }
</style>
<?php 
if($aResult['rtCode'] == "1"){
    $tVatCode   = $aResult['raItems'][0]['rtVatCode'];   
    $tRoute     = 'vatrateEventEdit';
    $dGetData   = $dGetDataNow;
}else{
    $tRoute     = 'vatrateEventAdd';
    $tVatCode   = "";
    $dGetData   = $dGetDataNow;
}
?>


<input type="hidden" class="form-control" id="tBaseurl" name="tBaseurl" value='<?=base_url();?>'>

<form action="javascript:void(0)" method="post" enctype="multipart/form-data" autocomplete="off" id="ofmSaveVatRate">
    <button style="display:none" type="submit" id="obtSaveVatRate" onclick="JSxSaveVatRate('<?php echo $tRoute; ?>')"></button>
    <div style="margin-top:15px;"></div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label class="xCNLabelFrm"><span class="text-danger">*</span><?php echo language('company/vatrate/vatrate','tVATCode'); ?></label>
                        <div id="odvVatrateAutoGenCode" class="form-group">
                            <div class="validate-input">
                            <label class="fancy-checkbox">
                            <input type="checkbox" id="ocbVatrateAutoGenCode" name="ocbVatrateAutoGenCode" checked="true" value="1">
                            <span> <?php echo language('common/main/main', 'tGenerateAuto'); ?></span>
                        </label>
                    </div>
                </div>
                    <div id="odvVatrateCodeForm" class="form-group">
                        <input type="hidden" id="ohdCheckDuplicateVatCode" name="ohdCheckDuplicateVatCode" value="1"> 
                            <div class="validate-input">
                                <input 
                                type="text" 
                                class="form-control xCNInputWithoutSpcNotThai xCNInputWithoutSingleQuote" 
                                maxlength="5" 
                                id="oetVatCode" 
                                name="oetVatCode"
                                value="<?php echo $tVatCode ?>"
                                data-is-created="<?php echo $tVatCode ?>"
                                placeholder="<?php echo language('company/vatrate/vatrate','tVATRateCode'); ?>"
                                data-validate-required = "<?= language('company/vatrate/vatrate','tVATvalidateCode')?>"
                                data-validate-dublicateCode = "<?php echo language('company/vatrate/vatrate','tVATValidCheckCode'); ?>"
                                >
                            </div>
                        </div>
                    </div>

            </div>
        </div>
    </div>
</form>

<form action="javascript:void(0)" method="post" enctype="multipart/form-data" autocomplete="off" id="ofmAddVatRate">
    <div style="margin-top:15px;"></div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <div class="validate-input" data-validated="Plese Insert VatRate">
                        <label class="xCNLabelFrm"><span style="color:red">*</span><?php echo language('company/vatrate/vatrate','tVATRate'); ?></label>
                        <input type="text" class="form-control xCNInputNumericWithoutDecimal text-right" id="oetAddVatRate" name="oetAddVatRate" maxlength='2' placeholder="<?=language('company/vatrate/vatrate', 'tVATPleaseInsertVatRate')?>">
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="xCNLabelFrm"><?php echo language('company/shop/shop','tShpStart')?></label>
                        <div class="input-group">
                            <input type="text" class="form-control xCNDatePicker xCNInputMaskDate text-center" id="oetAddVatStart" name="oetAddVatStart" value="<?php echo $dGetData;?>" >
                            <span class="input-group-btn">
                                <button id="obtVatStart" type="button" class="btn xCNBtnDateTime">
                                    <img src="<?php echo  base_url().'application/modules/common/assets/images/icons/icons8-Calendar-100.png'?>">
                                </button>
                            </span>
                        </div>
                    </div>
                </div>
            <div class="col-md-4">
                <div class="from-group" style="margin-top:27px">
                    <button onclick="JSxFormValidate()" type="submit" class="btn xCNBTNPrimery"><?php echo language('company/vatrate/vatrate','tVATAddRate'); ?></button>
                </div>
            </div>
        </div>
        <div class="row">
            <input type="hidden" id="oetInputStaEdit" name="oetInputStaEdit"> 
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table" style="width:100%">
                        <thead>
                            <tr>
                                <th nowrap class="xCNTextBold text-center" style="width:10%;"> <?php echo language('company/vatrate/vatrate','tVATTBNo'); ?></th>
                                <th nowrap class="xCNTextBold text-center" style="width:25%;"><?php echo language('company/vatrate/vatrate','tVATTBRate'); ?></th>
                                <th nowrap class="xCNTextBold text-center" style="width:35%;"><?php echo language('company/vatrate/vatrate','tVATTBDateStart'); ?></th>
                                <th nowrap class="xCNTextBold text-center" style="width:10%;"><?php echo language('company/vatrate/vatrate','tVATTBStatus'); ?></th>
                                <th nowrap class="xCNTextBold text-center" style="width:10%;"> <?php echo language('company/vatrate/vatrate','tVATTBDelete'); ?></th>
                                <th nowrap class="xCNTextBold text-center" style="width:10%;"> <?php echo language('company/vatrate/vatrate','tVATTBEdit'); ?></th>
                            </tr>
                        </thead>
                        <tbody id="otbRateList">
                            <?php if($aResult['rtCode'] == "1") : ?>
                                <?php $key = 1; foreach ($aResult['raItems'] as $aValue) : ?>
                                    <tr class="text-center xCNTextDetail2 otrVRate xWOriRec" id="otrVRate<?php echo $key; ?>" data-code="<?php echo $aValue['rtVatCode']; ?>" data-start="<?php echo date('Y-m-d',strtotime($aValue['rtVatStart'])); ?>">
                                        <td class="text-center xWIndex"><?php echo $aValue['rtRowID']; ?></td>
                                        <td class="text-left">
                                            <div class="validate-input" data-validated="Plese Insert VatRate">
                                                <input name="oetVatRate<?php echo $key; ?>" type="text" class="xWVat xCNTextDetail2 xCNInputNumericWithoutDecimal text-right" value="<?php echo number_format($aValue['rtVatRate'], 0).' %';?>" disabled="true">
                                            </div>
                                        </td>
                                        <td class="text-left">
                                            <div class="validate-input" data-validated="Plese Select VatStart">
                                                <input name="oetVatStrat<?php echo $key; ?>" type="text" class="xWVatStart xCNTextDetail2 xCNDatePicker text-center" value="<?php echo date('Y-m-d',strtotime($aValue['rtVatStart'])); ?>" disabled="true" onchange="JSxVatStartRecordValidate(this, event)">
                                            </div>
                                        </td>
                                        <?php 
                                        $tStaVatActive = '';
                                        if(!empty($aVatActive)){
                                            if($aValue['rtVatCode'] == $aVatActive['rtVatCode']){
                                                $tStaVatActive = ($aValue['rtVatStart'] == $aVatActive['rtVatStart'])? language('company/vatrate/vatrate','tVatStaActive') : '';
                                            }
                                        }
                                        ?>
                                        <td style="color:green !important;font-size:20px !important;font-weight:bold !important;" class="text-center">
                                            <?php echo $tStaVatActive ?>
                                        </td>                                        
                                        <td>
                                            <img class="xCNIconTable xWVatDelete" src="<?php echo base_url(); ?>/application/modules/common/assets/images/icons/delete.png" onClick="JSxDeleteOperator(this, event)">
                                        </td>
                                        <td> 
                                            <img class="xCNIconTable xWVatEdit" src="<?php echo  base_url(); ?>/application/modules/common/assets/images/icons/edit.png" onclick="JSxEditOperator(this, event)">
                                            <img class="xCNIconTable xWVatSave hidden" src="<?php echo  base_url(); ?>/application/modules/common/assets/images/icons/save.png" onclick="JSxSaveOperator(this, event)">
                                            <img class="xCNIconTable xWVatCancel hidden" src="<?php echo  base_url(); ?>/application/modules/common/assets/images/icons/reply_new.png" onclick="JSxCancelOperator(this, event)">
                                        </td>
                                    </tr>
                                <?php $key++; endforeach; ?>
                                <span id="ospRow"></span>
                            <?php else: ?>
                                <tr id="otrNoVatData"><td class='text-center xCNTextDetail2' colspan='6'><?php echo language('common/main/main','tCMNNotFoundData'); ?></td></tr>
                            <?php  endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</form>
<div class="modal fade" id="odvModalComfirmDelVatrate">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header xCNModalHead">
                <label class="xCNTextModalHeard"><?php echo language('common/main/main', 'tModalDelete') ?></label>
            </div>
            <div class="modal-body">
                <span id="ospComfirmDelete" class="xCNTextModal" style="display: inline-block; word-break:break-all"></span>
            </div>
            <div class="modal-footer">
                <button id="osmConfirmDelete" type="button" class="btn xCNBTNPrimery">
                    <?php echo language('common/main/main', 'tModalConfirm'); ?>
                </button>
                <button type="button" class="btn xCNBTNDefult" data-dismiss="modal">
                    <?php echo language('common/main/main', 'tModalCancel'); ?>
                </button>
            </div>
        </div>
    </div>
</div> 

<div class="modal fade" id="odvModalNotifications">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header xCNModalHead">
                <label class="xCNTextModalHeard"><?php echo language('common/main/main', 'tModalError') ?></label>
            </div>
            <div class="modal-body">
                <span id="ospNotifications" class="xCNTextModal" style="display: inline-block; word-break:break-all">
                    <?php echo language('common/main/main', 'tVatEmpty') ?>
                </span>
            </div>
            <div class="modal-footer">
                <div class="text-center">
                    <button type="button" class="btn xCNBTNDefult" data-dismiss="modal">
                        <?php echo language('common/main/main', 'tCMNOK'); ?>
                    </button>
                </div>
            </div>    
        </div>
    </div>
</div> 


<script src="<?= base_url('application/modules/common/assets/js/jquery.mask.js')?>"></script>
<script src="<?= base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>
<?php include 'script/jVatrateAdd.php'; ?>






