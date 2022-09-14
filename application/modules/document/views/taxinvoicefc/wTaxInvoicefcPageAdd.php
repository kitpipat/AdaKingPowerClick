<style>
    .modal-open {
        overflow: hidden !important;
    }
</style>

<form id="ofmTaxInvoice" class="validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data">

    <div class="row">
        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">

            <!-- Panel รหัสเอกสารและสถานะเอกสาร -->
            <div class="panel panel-default" style="margin-bottom: 25px;">
                <div id="odvHeadStatus" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
                    <label class="xCNTextDetail1"><?=language('document/taxinvoicefc/taxinvoicefc', 'tTitlePanelDocument'); ?></label>
                    <a class="xCNMenuplus" role="button" data-toggle="collapse" href="#odvTAXDataStatusInfo" aria-expanded="true">
                        <i class="fa fa-plus xCNPlus"></i>
                    </a>
                </div>
                <div id="odvTAXDataStatusInfo" class="panel-collapse collapse in" role="tabpanel">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <!-- เลขที่ใบกำกับภาษีเต็มรูป -->
                                <div class="form-group" style="cursor:not-allowed">
                                    <label class="xCNLabelFrm"><?= language('document/taxinvoicefc/taxinvoicefc', 'tTAXDocNo'); ?></label>
                                    <input 
                                        type="text"
                                        class="form-control xWTooltipsBT xCNInputWithoutSpcNotThai xCNInputWithoutSingleQuote"
                                        id="oetTAXDocNo"
                                        name="oetTAXDocNo"
                                        maxlength="20"
                                        value=""
                                        placeholder="<?=language('document/taxinvoicefc/taxinvoicefc','tTAXDocNo');?>"
                                        style="pointer-events:none"
                                        readonly
                                    >
                                    <input type="hidden" id="ohdBCHDocument" name="ohdBCHDocument">
                                </div>

                                <!-- วันที่ในการออกเอกสาร -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><span style="color:red">*</span><?=language('document/taxinvoicefc/taxinvoicefc','tTAXDocDate');?></label>
                                    <div class="input-group">
                                        <input
                                            type="text"
                                            class="form-control xCNDatePicker xCNInputMaskDate"
                                            id="oetTAXDocDate"
                                            name="oetTAXDocDate"
                                            value="<?=date('Y-m-d');?>"
                                            placeholder="YYYY-MM-DD"
                                        >
                                        <span class="input-group-btn">
                                            <button id="obtTAXDocDate" type="button" class="btn xCNBtnDateTime"><img class="xCNIconCalendar"></button>
                                        </span>
                                    </div>
                                </div>

                                <!-- เวลาในการออกเอกสาร -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><span style="color:red">*</span><?=language('document/taxinvoicefc/taxinvoicefc', 'tTAXDocTime');?></label>
                                    <div class="input-group">
                                        <input
                                            type="text"
                                            class="form-control xCNTimePicker"
                                            id="oetTAXDocTime"
                                            name="oetTAXDocTime"
                                            value=<?=date('H:i:s')?>
                                            placeholder="H:i:s"
                                        >
                                        <span class="input-group-btn">
                                            <button id="obtTAXDocTime" type="button" class="btn xCNBtnDateTime"><img class="xCNIconCalendar"></button>
                                        </span>
                                    </div>
                                </div>
                                
                                <!-- ผู้สร้างเอกสาร -->
                                <div class="form-group" style="margin:0">
                                    <div class="row">
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                            <label class="xCNLabelFrm"><?=language('document/taxinvoicefc/taxinvoicefc','tTAXCreateBy'); ?></label>
                                        </div>
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                                            <label id="olbCreateDocument"><?=$this->session->userdata('tSesUsrUsername');?></label>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- สถานะเอกสาร -->
                                <div class="form-group" style="margin:0">
                                    <div class="row">
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                            <label class="xCNLabelFrm"><?=language('document/taxinvoicefc/taxinvoicefc','tTAXStaApv');?></label>
                                        </div>
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                                            <label id="olbStatusDocument">ยังไม่อนุมัติ</label>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Panel อ้างอิง -->
            <div class="panel panel-default" style="margin-bottom: 25px;">
                <div class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
                    <label class="xCNTextDetail1"><?=language('document/taxinvoicefc/taxinvoicefc','tTitlePanelRef');?></label>
                    <a class="xCNMenuplus collapsed" role="button" data-toggle="collapse" href="#odvTWIDataConditionREF" aria-expanded="true">
                        <i class="fa fa-plus xCNPlus"></i>
                    </a>
                </div>
                <div id="odvTWIDataConditionREF" class="xCNMenuPanelData panel-collapse collapse" role="tabpanel">
                    <div class="panel-body">

                        <!-- อ้างอิงเลขที่เอกสารภายใน -->
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?=language('document/taxinvoicefc/taxinvoicefc','tTAXLabelFrmRefIntDoc');?></label>
                            <input
                                type="text"
                                class="form-control"
                                id="oetTAXRefIntDoc"
                                name="oetTAXRefIntDoc"
                                maxlength="20"
                                readonly
                                value=""
                            >
                        </div>

                        <!-- วันที่อ้างอิงเลขที่เอกสารภายใน -->
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?=language('document/taxinvoicefc/taxinvoicefc','tTAXLabelFrmRefIntDocDate');?></label>
                            <input
                                type="text"
                                class="form-control xCNDatePicker xCNInputMaskDate"
                                id="oetTAXRefIntDocDate"
                                name="oetTAXRefIntDocDate"
                                placeholder="YYYY-MM-DD"
                                readonly
                                value=""
                            >
                        </div>

                        <!-- อ้างอิงเลขที่เอกสารภายนอก -->
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?=language('document/taxinvoicefc/taxinvoicefc','tTAXLabelFrmRefExtDoc');?></label>
                            <input
                                type="text"
                                class="form-control"
                                id="oetTAXRefExtDoc"
                                name="oetTAXRefExtDoc"
                                readonly
                                value=""
                            >
                        </div>

                        <!-- วันที่เอกสารภายนอก -->
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?=language('document/taxinvoicefc/taxinvoicefc','tTAXLabelFrmRefExtDocDate');?></label>
                            <input
                                type="text"
                                class="form-control xCNDatePicker xCNInputMaskDate"
                                id="oetTAXRefExtDocDate"
                                name="oetTAXRefExtDocDate"
                                placeholder="YYYY-MM-DD"
                                readonly
                                value=""
                            >
                        </div>
                    </div>
                </div>
            </div>

             <!-- Panel อื่นๆ -->
             <div class="panel panel-default" style="margin-bottom: 25px;">
                <div class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
                    <label class="xCNTextDetail1"><?=language('document/taxinvoicefc/taxinvoicefc','tTitlePanelOther');?></label>
                    <a class="xCNMenuplus collapsed" role="button" data-toggle="collapse" href="#odvTWIDataConditionETC" aria-expanded="true">
                        <i class="fa fa-plus xCNPlus"></i>
                    </a>
                </div>
                <div id="odvTWIDataConditionETC" class="xCNMenuPanelData panel-collapse collapse" role="tabpanel">
                    <div class="panel-body">
                    <!-- nCmpRetInOrEx -->
                    <?php
                                $tCmpRetInOrEx = ($nCmpRetInOrEx=='1' ? language('document/taxinvoicefc/taxinvoicefc','tTAXVatInclude') : language('document/taxinvoicefc/taxinvoicefc','tTAXVatExclude'));

                        ?>
                        <!-- ประเภทภาษี -->
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?=language('document/taxinvoicefc/taxinvoicefc','tTAXLabelTypeVat');?></label>
                            <input type="text" class="form-control" id="oetTAXTypeVat" name="oetTAXTypeVat" value="<?=$tCmpRetInOrEx?>" readonly>
                        </div>

                        <!-- จำนวนครั้งที่พิมพ์ -->
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?=language('document/taxinvoicefc/taxinvoicefc','tTAXLabelCountPrint');?></label>
                            <input type="text" class="form-control" id="oetTAXCountPrint" name="oetTAXCountPrint" value="0" readonly style="text-align: right;">
                        </div>

                         <!-- ชำระเงินเป็นเงินสดหรือเครดิต -->
                         <div class="form-group">
                            <label class="xCNLabelFrm"><?=language('document/taxinvoicefc/taxinvoicefc','tTAXLabelTypePay');?></label>
                            <input type="text" class="form-control" id="oetTAXTypepay" name="oetTAXTypepay" value="<?=language('document/taxinvoicefc/taxinvoicefc','tTAXDebitShop')?>" readonly>
                        </div>

                         <!-- รหัสเครื่องจุดขาย -->
                         <!-- <div class="form-group">
                            <label class="xCNLabelFrm"><?=language('document/taxinvoicefc/taxinvoicefc','tTAXLabelPos');?></label>
                            <input type="text" class="form-control" id="oetTAXPos" name="oetTAXPos" value="" readonly>
                        </div> -->

                    </div>
                </div>
            </div>
        </div>       

        <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
            <div class="row">
                <!-- เนื้อหาของลูกค้า -->
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="panel panel-default" style="margin-bottom:25px;position:relative;min-height:200px;">
                        <div class="panel-collapse collapse in" role="tabpanel">
                            <div class="panel-body">
                                <div style="margin-top: 10px;">

                                    <!--เลขที่ใบกำกับภาษีอย่างย่อ-->
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-lg-3 col-md-12 col-sm-12 xCNSelectBCH">
                                                <!--สาขา-->
                                                <?php 
                                                $nSesUsrBchCount = $this->session->userdata("nSesUsrBchCount");
                                                if($nSesUsrBchCount == 1 ){ ?>
                                                    <?php $tInputBchCode    = $this->session->userdata("tSesUsrBchCodeDefault"); ?>
                                                    <?php $tInputBchName    = $this->session->userdata("tSesUsrBchNameDefault"); ?>
                                                    <input name="oetBrowseBchCode" id="oetBrowseBchCode" value="<?=$tInputBchCode?>" class="form-control xCNHide xCNClearValue" type="text">
                                                    <label class="xCNLabelFrm"><?=language('document/transferreceiptOut/transferreceiptOut', 'tTWITablePDTBch');?></label>
                                                    <div class="">
                                                        <input value="<?=$tInputBchName?>" class="form-control xCNClearValue" readonly type="text">
                                                    </div>
                                                <?php }else{ ?>
                                                    <!--เลือกสาขา-->
                                                    <?php $tInputBchCode    = $this->session->userdata("tSesUsrBchCodeDefault"); ?>
                                                    <?php $tInputBchName    = $this->session->userdata("tSesUsrBchNameDefault"); ?>
                                                    <div class="">
                                                        <label class="xCNLabelFrm"><?= language('document/transferreceiptOut/transferreceiptOut', 'tTWITablePDTBch'); ?></label>
                                                        <div class="input-group">
                                                            <input name="oetBrowseBchName" id="oetBrowseBchName" class="form-control" value="<?=$tInputBchName?>" type="text" readonly="" 
                                                                    placeholder="<?= language('document/transferreceiptOut/transferreceiptOut', 'tTWITablePDTBch') ?>">
                                                            <input name="oetBrowseBchCode" id="oetBrowseBchCode" value="<?=$tInputBchCode?>" class="form-control xCNHide xCNClearValue" type="text">
                                                            <span class="input-group-btn">
                                                                <button class="btn xCNBtnBrowseAddOn xCNApvOrCanCelDisabled" id="obtBrowseBCH" type="button">
                                                                    <img src="<?= base_url() . '/application/modules/common/assets/images/icons/find-24.png' ?>">
                                                                </button>
                                                            </span>
                                                        </div>
                                                    </div>
                                                <?php } ?>   
                                            </div>

                                            <div class="col-lg-8 col-md-10 col-sm-10 xCNSelectTaxABB">
                                                <label class="xCNLabelFrm"><span style = "color:red">*</span><?= language('document/taxinvoicefc/taxinvoicefc', 'tTAXABB'); ?></label>
                                                <div class="input-group">
                                                    <input name="oetTAXABBCode" maxlength="20" id="oetTAXABBCode" class="form-control xCNClearValue" type="text" placeholder="<?= language('document/taxinvoicefc/taxinvoicefc', 'tTAXABB') ?>" onkeypress="Javascript:if(event.keyCode==13) JSxSearchDocumentABB(event,this);">
                                                    <span class="input-group-btn">
                                                        <button class="btn xCNBtnBrowseAddOn xCNApvOrCanCelDisabled disabled" type="button">
                                                            <img src="<?= base_url() . '/application/modules/common/assets/images/icons/scanner2.png' ?>">
                                                        </button>
                                                    </span>
                                                    <input name="oetTAXABBTypeDocuement" id="oetTAXABBTypeDocuement" type="hidden">
                                                </div>
                                            </div>
                                            <div class="col-lg-1 col-md-2 col-sm-2">
                                                <span>
                                                    <button class="btn xCNBtnBrowseAddOn xCNApvOrCanCelDisabled" id="obtBrowseTaxABB" type="button" style="float: right; margin-top: 25px;">
                                                        <img src="<?= base_url() . '/application/modules/common/assets/images/icons/find-24.png' ?>">
                                                    </button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <!--ลูกค้า-->
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-lg-11 col-md-10 col-sm-10">
                                                <label class="xCNLabelFrm"><?= language('document/taxinvoicefc/taxinvoicefc', 'tTAXCustomer'); ?></label>
                                                <div class="input-group">
                                                    <input name="oetTAXCusName" id="oetTAXCusName" class="form-control xCNClearValue" value="" type="text" readonly="" placeholder="<?= language('document/taxinvoicefc/taxinvoicefc', 'tTAXCustomer') ?>" >
                                                    <input name="oetTAXCusCode" id="oetTAXCusCode" value="" class="form-control xCNHide xCNClearValue" type="text">
                                                    <span class="input-group-btn">
                                                        <button class="btn xCNBtnBrowseAddOn xCNApvOrCanCelDisabled" id="obtBrowseCus" type="button">
                                                            <img src="<?= base_url() . '/application/modules/common/assets/images/icons/find-24.png' ?>">
                                                        </button>
                                                    </span>
                                                </div>  
                                            </div>
                                            <div class="col-lg-1 col-md-2 col-sm-2">
                                                <span>
                                                    <button class="btn xCNBtnBrowseAddOn xCNApvOrCanCelDisabled" id="obtBrowseAddress" type="button" style="float: right; margin-top: 25px;">
                                                        <img src="<?= base_url() . '/application/modules/common/assets/images/icons/Home.png' ?>">
                                                    </button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <!--รายละเอียดที่อยู่-->
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-lg-12">

                                                <!--ชื่อลูกค้า-->
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label class="xCNLabelFrm"><span style = "color:red">*</span><?= language('document/taxinvoicefc/taxinvoicefc', 'tTAXCustomerName'); ?></label>
                                                            <input name="oetTAXCusNameCusABB"  autocomplete="off" id="oetTAXCusNameCusABB"  maxlength="255" class="form-control xCNClearValue" value="" type="text" placeholder="<?= language('document/taxinvoicefc/taxinvoicefc', 'tTAXCustomerName') ?>" >
                                                        </div>  
                                                    </div>
                                                    
                                                    <div class="col-lg-6">
                                                        <!--เลขที่ประจำตัวผู้เสียภาษี-->
                                                        <div class="form-group">
                                                            <div class="row">
                                                                <div class="col-lg-10 col-md-10 col-sm-10">
                                                                    <div>
                                                                        <label class="xCNLabelFrm"><span style = "color:red">*</span><?= language('document/taxinvoicefc/taxinvoicefc', 'tTAXNumber'); ?></label>
                                                                        <input name="oetTAXNumber" autocomplete="off" id="oetTAXNumber" maxlength="200" class="form-control xCNClearValue xCNInputNumericWithDecimal" value="" type="text" placeholder="<?= language('document/taxinvoicefc/taxinvoicefc', 'tTAXNumber') ?>" onkeypress="Javascript:if(event.keyCode==13) JSxSearchDocumentTAXCustomer(event,this);" >
                                                                        <input type="hidden" name="oetTAXNumberNew" id="oetTAXNumberNew"> 
                                                                        <input type="hidden" name="ohdSeqAddress" id="ohdSeqAddress">
                                                                        <input type="hidden" name="ohdSeqInTableAddress" id="ohdSeqInTableAddress" >
                                                                    </div>
                                                                </div>

                                                                <div class="col-lg-2 col-md-2 col-sm-2">
                                                                    <div>
                                                                        <span>
                                                                            <button class="btn xCNBtnBrowseAddOn xCNApvOrCanCelDisabled" id="obtBrowseTAXNumber" type="button" style="float: right; margin-top: 25px;">
                                                                                <img src="<?= base_url() . '/application/modules/common/assets/images/icons/find-24.png' ?>">
                                                                            </button>
                                                                        </span> 
                                                                    </div>
                                                                </div>  
                                                            </div>  
                                                        </div>  
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    

                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <!--ประเภทกิจการ-->
                                                        <div class="form-group">
                                                            <label class="xCNLabelFrm"><?= language('document/taxinvoicefc/taxinvoicefc', 'tTAXTypeBusiness'); ?></label>
                                                            <select class="selectpicker form-control" id="ocmTAXTypeBusiness" name="ocmTAXTypeBusiness" maxlength="1">
                                                                <option value="1"><?=language('document/taxinvoicefc/taxinvoicefc','tTAXTypeBusiness1')?></option>
                                                                <option value="2"><?=language('document/taxinvoicefc/taxinvoicefc','tTAXTypeBusiness2')?></option>
                                                            </select>
                                                        </div>  
                                                    </div> 

                                                    <div class="col-lg-3 col-md-3 col-sm-3">
                                                        <!--สถานประกอบการ-->
                                                        <div class="form-group">
                                                            <label class="xCNLabelFrm"><?= language('document/taxinvoicefc/taxinvoicefc', 'tTAXBusiness'); ?></label>
                                                            <select class="selectpicker form-control" id="ocmTAXBusiness" name="ocmTAXBusiness" maxlength="1">
                                                                <option value="1"><?=language('document/taxinvoicefc/taxinvoicefc','tTAXBusiness1')?></option>
                                                                <option value="2"><?=language('document/taxinvoicefc/taxinvoicefc','tTAXBusiness2')?></option>
                                                            </select>
                                                        </div>  
                                                    </div> 
                                                    <div class="col-lg-3 col-md-3 col-sm-3">
                                                        <!--รหัสสาขา-->
                                                        <div class="form-group">
                                                            <label class="xCNLabelFrm"><?= language('document/taxinvoicefc/taxinvoicefc', 'tTAXBranch'); ?></label>
                                                            <input name="oetTAXBranch" id="oetTAXBranch" maxlength="5" class="form-control xCNClearValue" value="" type="text" placeholder="<?= language('document/taxinvoicefc/taxinvoicefc', 'tTAXBranch') ?>" >
                                                        </div>    
                                                    </div>
                                                </div> 

                                                 

                                                <div class="row">
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <!--เบอร์โทรศัพท์-->
                                                        <div class="form-group">
                                                            <label class="xCNLabelFrm"><?= language('document/taxinvoicefc/taxinvoicefc', 'tTAXTelphone'); ?></label>
                                                            <input name="oetTAXTel" id="oetTAXTel"  maxlength="50" class="form-control xCNClearValue xCNInputNumericWithDecimal" value="" type="text" placeholder="<?= language('document/taxinvoicefc/taxinvoicefc', 'tTAXTelphone') ?>" >
                                                        </div>  
                                                    </div> 
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <!--เบอร์แฟ๊กซ์-->
                                                        <div class="form-group">
                                                            <label class="xCNLabelFrm"><?= language('document/taxinvoicefc/taxinvoicefc', 'tTAXFax'); ?></label>
                                                            <input name="oetTAXFax" id="oetTAXFax"  maxlength="50" class="form-control xCNClearValue" value="" type="text" placeholder="<?= language('document/taxinvoicefc/taxinvoicefc', 'tTAXFax') ?>" >
                                                        </div> 
                                                    </div>
                                                </div> 
                                            </div>

                                            <div class="col-lg-12">
                                                <div class="row">
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <!--ที่อยู่ 1 -->
                                                        <div class="form-group">
                                                            <label class="xCNLabelFrm"><?= language('document/taxinvoicefc/taxinvoicefc', 'tTAXAddress1'); ?></label>
                                                            <textarea id="otxAddress1" rows="2" style="resize: none;" maxlength="255"> </textarea>
                                                        </div> 
                                                    </div> 
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <!--ที่อยู่ 2 -->
                                                        <div class="form-group">
                                                            <label class="xCNLabelFrm"><?= language('document/taxinvoicefc/taxinvoicefc', 'tTAXAddress2'); ?></label>
                                                            <textarea id="otxAddress2" rows="2" style="resize: none;" maxlength="255"> </textarea>
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
                </div>

                <!-- เนื้อหาของสินค้า -->
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="panel panel-default" style="margin-bottom:25px;position:relative;min-height:200px;">
                        <div class="panel-collapse collapse in" role="tabpanel">
                            <div class="panel-body">
                                <div style="margin-top: 10px;">

                                    <!--ค้นหาสินค้า-->
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-lg-7">
                                                <div class="input-group">
                                                    <input
                                                        class="form-control xCNInpuTXOthoutSingleQuote"
                                                        type="text"
                                                        id="oetTAXSearchPDT"
                                                        name="oetTAXSearchPDT"
                                                        placeholder="<?=language('document/taxinvoicefc/taxinvoicefc','tTAXSearach')?>"
                                                        autocomplete="off"
                                                        onkeypress="Javascript:if(event.keyCode==13 ) JSxRanderHDDT('',1)">
                                                    <span class="input-group-btn">
                                                        <button id="obtTAXSerchAllDocument" type="button" class="btn xCNBtnDateTime" onclick="JSxRanderHDDT('',1)"><img class="xCNIconSearch"></button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>  

                                    <!--ตารางสินค้า-->
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div id="odvContentTAX"></div>
                                        </div>
                                        <div class="col-lg-6">

                                            <div class="panel panel-default" style="margin-top:10px;">
                                                <div class="panel-heading mark-font" style="padding: 0px  10px !important;">
                                                    <label class="mark-font" style="padding: 7px 10px;" id="olbGrandText">บาท</label>
                                                </div>
                                            </div>

                                            <div>
                                                <!--เหตุผล-->
                                                <div class="form-group" style="margin-top:10px;">
                                                    <label class="xCNLabelFrm"><?= language('document/taxinvoicefc/taxinvoicefc', 'tTAXReason'); ?></label>
                                                    <textarea id="otxReason" rows="6" style="resize: none;" maxlength="200"> </textarea>
                                                </div> 
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div id="odvContentSumFooterTAX"></div>
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
</form>

<!--- ============================================================== เลือกใบกำกับภาษี ============================================================ -->
<div id="odvTAXModalSelectABB" class="modal fade" tabindex="-1" role="dialog" data-toggle="modal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" style="min-width: 75%;margin: 1.75rem auto;">
		<div class="modal-content">
			<div class="modal-header xCNModalHead">
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <label class="xCNTextModalHeard" style="font-weight: bold; font-size: 20px;"><?=language('document/taxinvoicefc/taxinvoicefc', 'tTAXShow')?><?=language('document/taxinvoicefc/taxinvoicefc', 'tTAXABB')?></label>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-right">
                        <button type="button" class="btn xCNBTNPrimery xCNBTNPrimery2Btn xCNConfrimABB" data-dismiss="modal" onclick="JSxSelectABB('SELECT','','')"><?=language('common/main/main', 'tModalConfirm'); ?></button>
                        <button type="button" class="btn xCNBTNDefult xCNBTNDefult2Btn" data-dismiss="modal"><?=language('common/main/main', 'tModalCancel'); ?></button>
                    </div>
                </div>
			</div>
			<div class="modal-body">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?= language('document/taxinvoicefc/taxinvoicefc', 'tTAXFilterAdv'); ?></label>
                            <select class="selectpicker form-control" id="ocmTAXAdvSearch" name="ocmTAXAdvSearch" maxlength="1">
                                <option value="2"><?=language('document/taxinvoicefc/taxinvoicefc','tTAXFilterAdv2')?></option>
                                <option value="3"><?=language('document/taxinvoicefc/taxinvoicefc','tTAXFilterAdv3')?></option>
                            </select>
                        </div> 
                    </div>
                    <div class="col-lg-5">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-lg-5">
                                    <label class="xCNLabelFrm"><?= language('document/taxinvoicefc/taxinvoicefc', 'tTAXFilterAdv1'); ?></label>
                                    <div class="xCNFilterDate">
                                        <input class="form-control xCNDatePicker xCNInputMaskDate" id="oetTaxDateABB" type="text" value="<?=date('Y-m-d')?>" autocomplete="off" placeholder="">
                                    </div>  
                                </div>
                                <div class="col-lg-7">
                                    <label class="xCNLabelFrm"></label>
                                    <div class="xCNFilterOther input-group">
                                        <input class="form-control" id="oetTextFilter" maxlength="100" type="text" value="" onkeypress="Javascript:if(event.keyCode==13 ) JCNxSearchBrowseABB(1)" autocomplete="off" placeholder="<?=language('document/taxinvoicefc/taxinvoicefc', 'tTAXSearach')?>">
                                        <span class="input-group-btn">
                                            <button class="btn xCNBtnSearch" type="button" onclick="JCNxSearchBrowseABB(1)"><i class="fa fa-search"></i></button>
                                        </span>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div id="odvContentSelectABB"></div>
                    </div>
                </div>
			</div>
		</div>
	</div>
</div>  

<!--- ============================================================== ไม่พบรหัสเลขที่ใบกับกำภาษีแบบ KEY ============================================= -->
<div id="odvTAXModalNotFoundABB" class="modal fade" tabindex="-1" role="dialog" data-toggle="modal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" style="margin: 1.75rem auto;">
		<div class="modal-content">
			<div class="modal-header xCNModalHead">
                <label class="xCNTextModalHeard" style="font-weight: bold; font-size: 20px;"><?=language('document/taxinvoicefc/taxinvoicefc', 'tTAXwarning')?></label>
			</div>
			<div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
						<span><?=language('document/taxinvoicefc/taxinvoicefc', 'tTAXABBNotFound')?></span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
				<button id="osmConfirmNotFoundABB" type="button" class="btn xCNBTNPrimery" data-dismiss="modal">
					<?=language('common/main/main', 'tModalConfirm'); ?>
				</button>
			</div>
		</div>
	</div>
</div>  

<!--- ============================================================== ไม่พบเลขที่ประจำตัวผู้เสียภาษี KEY =============================================== -->
<div id="odvTAXModalNotFoundTaxNo" class="modal fade" tabindex="-1" role="dialog" data-toggle="modal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" style="margin: 1.75rem auto;">
		<div class="modal-content">
			<div class="modal-header xCNModalHead">
                <label class="xCNTextModalHeard" style="font-weight: bold; font-size: 20px;"><?=language('document/taxinvoicefc/taxinvoicefc', 'tTAXwarning')?></label>
			</div>
			<div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
						<span><?=language('document/taxinvoicefc/taxinvoicefc', 'tTAXNoNotFound')?></span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
				<button id="osmConfirmNotFoundTaxNo" type="button" class="btn xCNBTNPrimery" data-dismiss="modal">
					<?=language('common/main/main', 'tModalConfirm'); ?>
				</button>
			</div>
		</div>
	</div>
</div>  

<!-- ============================================================== พบที่อยู่มากกว่าหนึ่งที่ ========================================================== -->
<div id="odvTAXModalAddressMoreOne" class="modal fade" tabindex="-1" role="dialog" data-toggle="modal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document" style="width: 85%; margin: 1.75rem auto;">
        <div class="modal-content">
            <div class="modal-header">
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <label class="xCNTextModalHeard" style="font-weight: bold; font-size: 20px;"><?=language('document/taxinvoicefc/taxinvoicefc', 'tTAXwarningAddress')?></label>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-right">
                        <button class="btn xCNBTNPrimery xCNBTNPrimery2Btn" onclick="JCNxConfirmAddressMoreOne()" data-dismiss="modal">เลือก</button>
                        <button class="btn xCNBTNDefult xCNBTNDefult2Btn" data-dismiss="modal">ปิด</button>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <table class="table table-striped xCNTableAddressMoreOne">
                    <thead>
                        <tr>
                            <th class="xCNTextBold" style="text-align:center; width:120px;"><?=language('document/taxinvoicefc/taxinvoicefc', 'tTAXCustomerName')?></th>
                            <th class="xCNTextBold" style="text-align:center; width:160px;"><?=language('document/taxinvoicefc/taxinvoicefc', 'tTAXAddress1')?></th>
                            <th class="xCNTextBold" style="text-align:center; width:120px;"><?=language('document/taxinvoicefc/taxinvoicefc', 'tTAXAddress2')?></th>
                            <th class="xCNTextBold" style="text-align:center; width:80px;"><?=language('document/taxinvoicefc/taxinvoicefc', 'tTAXTelphone')?></th>
                            <th class="xCNTextBold" style="text-align:center; width:80px;"><?=language('document/taxinvoicefc/taxinvoicefc', 'tTAXFax')?></th>
                        </tr>
                    </thead>
                    <tbody>
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!--- ======================================================= เลือกเลขที่ประจำตัวผู้เสียภาษี =========================================================== -->
<div id="odvTAXModalSelectTaxNo" class="modal fade" tabindex="-1" role="dialog" data-toggle="modal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" style="min-width: 75%;margin: 1.75rem auto;">
		<div class="modal-content">
			<div class="modal-header xCNModalHead">
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <label class="xCNTextModalHeard" style="font-weight: bold; font-size: 20px;"><?=language('document/taxinvoicefc/taxinvoicefc', 'tTAXShow')?><?=language('document/taxinvoicefc/taxinvoicefc', 'tTAXNumber')?></label>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-right">
                        <button type="button" class="btn xCNBTNPrimery xCNBTNPrimery2Btn xCNConfirmTaxno" data-dismiss="modal" onclick="JSxSelectTaxno()"><?=language('common/main/main', 'tModalConfirm'); ?></button>
                        <button type="button" class="btn xCNBTNDefult xCNBTNDefult2Btn" data-dismiss="modal"><?=language('common/main/main', 'tModalCancel'); ?></button>
                    </div>
                </div>
			</div>
			<div class="modal-body">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?= language('document/taxinvoicefc/taxinvoicefc', 'tTAXFilterAdv'); ?></label>
                            <div class="input-group">
                                <input class="form-control" id="oetTextSearchTaxno" type="text" value="" onkeypress="Javascript:if(event.keyCode==13 ) JCNxSearchBrowseTaxno(1)" autocomplete="off" placeholder="<?=language('document/taxinvoicefc/taxinvoicefc', 'tTAXSearach')?>">
                                <span class="input-group-btn">
                                    <button class="btn xCNBtnSearch" type="button" onclick="JCNxSearchBrowseTaxno(1)"><i class="fa fa-search"></i></button>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div id="odvContentSelectTaxno"></div>
                    </div>
                </div>
			</div>
		</div>
	</div>
</div>  

<!--- ============================================================== เลือกที่อยู่ลูกค้า ============================================================ -->
<div id="odvTAXModalSelectAddressCustomer" class="modal fade" tabindex="-1" role="dialog" data-toggle="modal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" style="min-width: 75%;margin: 1.75rem auto;">
		<div class="modal-content">
			<div class="modal-header xCNModalHead">
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <label class="xCNTextModalHeard" style="font-weight: bold; font-size: 20px;"><?=language('document/taxinvoicefc/taxinvoicefc', 'tTAXShow')?><?=language('document/taxinvoicefc/taxinvoicefc', 'tTAXNoCustomerModal')?></label>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-right">
                        <button type="button" class="btn xCNBTNPrimery xCNBTNPrimery2Btn xCNComfirmAddressCustomer" data-dismiss="modal" onclick="JSxSelectCustomerAddress()"><?=language('common/main/main', 'tModalConfirm'); ?></button>
                        <button type="button" class="btn xCNBTNDefult xCNBTNDefult2Btn" data-dismiss="modal"><?=language('common/main/main', 'tModalCancel'); ?></button>
                    </div>
                </div>
			</div>
			<div class="modal-body">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?= language('document/taxinvoicefc/taxinvoicefc', 'tTAXFilterAdv'); ?></label>
                            <div class="input-group">
                                <input class="form-control" id="oetTextCustomerAddress" type="text" value="" onkeypress="Javascript:if(event.keyCode==13 ) JCNxSearchBrowseSelectAddressCustomer(1)" autocomplete="off" placeholder="<?=language('document/taxinvoicefc/taxinvoicefc', 'tTAXSearach')?>">
                                <span class="input-group-btn">
                                    <button class="btn xCNBtnSearch" type="button" onclick="JCNxSearchBrowseSelectAddressCustomer(1)"><i class="fa fa-search"></i></button>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div id="odvContentSelectCustomerAddress"></div>
                    </div>
                </div>
			</div>
		</div>
	</div>
</div>  


<script src="<?=base_url('application/modules/common/assets/js/jquery.mask.js')?>"></script>
<script src="<?=base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>

<!--- PAGE - INSERT -->
<script>

    if('<?=$tTypePage?>' == 'Insert'){
        //ปิดปุ่มอนุมัติ + ปุ่มตรวจสอบ
        $('#obtCancleDocument').removeClass('xCNHide');
        $('#obtApproveDocument').removeClass('xCNHide');
        $('#obtPrintDocument').addClass('xCNHide');
        $('#obtPrintPreviewDocument').addClass('xCNHide');
        $('#obtSaveDocument').addClass('xCNHide');


         //Load หน้าตารางสินค้า
        JSxRanderHDDT('',1);
    }
    
    $('.xCNCreate a').text('<?= language('document/taxinvoicefc/taxinvoicefc', 'tCreate'); ?>');
    $('.xCNCreate').removeClass('xCNHide');

    $('.xCNBtngroup').show();
    $('.xCNBtnInsert').hide();
    $('#oetTAXABBCode').focus();
    $('.selectpicker').selectpicker();

    //ใช้ datepicker
    $('#obtTAXDocDate').unbind().click(function(){
        $('#oetTAXDocDate').datepicker('show');
    });

    $('.xCNDatePicker').datepicker({
        format: "yyyy-mm-dd",
        todayHighlight: true,
        enableOnReadonly: false,
        disableTouchKeyboard : true,
        autoclose: true
    });

    //ใช้ time
    $('#obtTAXDocTime').unbind().click(function(){
        $('#oetTAXDocTime').datetimepicker('show');
    });

    $('.xCNTimePicker').datetimepicker({
        format: 'HH:mm'
    });

    /**********************************************************************************************/// ใ บ ก ำ กั บ ภ า ษี 

    //ค้นหาเลขที่ใบกำกับภาษีอย่างย่อ แบบคีย์
    function JSxSearchDocumentABB(e,elem){
        var tValue = $(elem).val();
        var tBCH   = $('#oetBrowseBchCode').val();
        $.ajax({
            type    : "POST",
            url     : "dcmTXFCCheckABB",
            data    : { 'DocumentNumber' : tValue , 'tBCH' : tBCH },
            cache   : false,
            Timeout : 0,
            success : function (oResult) {
                var aResult = JSON.parse(oResult);
                if(aResult.tStatus == 'not found'){
                    $('#odvTAXModalNotFoundABB').modal('show');
                    $('#osmConfirmNotFoundABB').off();
                    $('#osmConfirmNotFoundABB').on('click',function(){
                        setTimeout(function(){ 
                            $('#oetTAXABBCode').focus();
                            $('#oetTAXABBCode').val(''); 
                            //Load ข้อมูลใหม่
                            JSxRanderHDDT('',1);
                        }, 100);
                    });
                }else{
                    JSxSelectABB('KEY',tValue,aResult.tCuscode,aResult.tCusname);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
        e.preventDefault();
    }

    //ค้นหาเลขที่ใบกำกับภาษีอย่างย่อแบบเลือก
    $('#obtBrowseTaxABB').on('click',function(){
        $('#odvTAXModalSelectABB').modal('show');
        JCNxSearchBrowseABB(1);
    });

    //ค้นหาใบกำกับภาษี
    function JCNxSearchBrowseABB(pnPage){
        var tFilter         = $('#ocmTAXAdvSearch option:selected').val();
        var tSearchABB      = $('#oetTextFilter').val();
        var tTextDateABB    = $('#oetTaxDateABB').val();
        var nPage           = pnPage;
        var tBCH            = $('#oetBrowseBchCode').val();
        $.ajax({
            type    : "POST",
            url     : "dcmTXFCLoadDatatableABB",
            data    : { 'tFilter' : tFilter , 'tSearchABB' : tSearchABB , 'nPage' : nPage , 'tTextDateABB' : tTextDateABB , 'tBCH' : tBCH},
            cache   : false,
            Timeout : 0,
            success : function (oResult) {
                var tHTML = JSON.parse(oResult);
                $('#odvContentSelectABB').html(tHTML['tTableABBHtml']);
                JCNxCloseLoading();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }

    //เลือกใบกำกับภาษี
    function JSxSelectABB(ptType,ptDocument,ptCustomer,ptCusName){
        if(ptType == 'KEY'){
            var tCustomer       = ptCustomer;
            var tDocumentTopUp    = ptDocument;
            var tCustomerName   = ptCusName;
        }else{
            var tCustomer       = '';
            var tDocumentTopUp    = $('#otbSelectABB tbody tr.xCNActive').attr('data-documenttopup');
            var tCustomerName   = '';
            $('#oetTAXABBCode').val(tDocumentTopUp);
        }
             JSxRanderHDDT(tDocumentTopUp,1);
             JSxRanderAddress(tDocumentTopUp,tCustomer,tCustomerName);
        // $.ajax({
        //     type    : "POST",
        //     url     : "dcmTXFCFindABB",
        //     data    : { 'tDocumentTopUp' : tDocumentTopUp },
        //     cache   : false,
        //     Timeout : 0,
        //     success : function (oResult) {

        //         console.log();
        //         // JSxRanderHDDT(tDocumentTopUp,1);
        //         // JSxRanderAddress(tDocumentTopUp,tCustomer,tCustomerName);
        //     },
        //     error: function (jqXHR, textStatus, errorThrown) {
        //         JCNxResponseError(jqXHR, textStatus, errorThrown);
        //     }
        // });

    }

    //rander view - HD DT (รายละเอียด)
    function JSxRanderHDDT(ptDocumentNumber,pnPage){
        if('<?=$tTypePage?>' == 'Preview'){
            JSxRanderDTPreview(1);
            return;
        }

        JCNxOpenLoading();

        var tSearchPDT = $('#oetTAXSearchPDT').val();
        if(ptDocumentNumber == ''){
            var tDocumentNumber = $('#oetTAXABBCode').val();
        }else{
            var tDocumentNumber = ptDocumentNumber;
        }
        var tBrowseBchCode = $('#oetBrowseBchCode').val();
        
        $.ajax({
            type    : "POST",
            url     : "dcmTXFCLoadDatatable",
            data    : { 'tDocumentNumber' : tDocumentNumber ,'tBrowseBchCode':tBrowseBchCode, 'tSearchPDT' : tSearchPDT , 'nPage' : pnPage },
            cache   : false,
            Timeout : 0,
            success : function (oResult) {
                var tHTML = JSON.parse(oResult);
                $('#odvContentTAX').html(tHTML['tContentPDT']);
                $('#odvContentSumFooterTAX').html(tHTML['tContentSumFooter']);
                JCNxCloseLoading();

                //เอาข้อมูล HD มาลง
                var aHD = tHTML['aDetailHD'];
                if(aHD.rtCode == '800'){
                    //ไม่พบข้อมูล
                    // $('#oetTAXTypeVat').val('');
                    $('#oetTAXCountPrint').val(0);
                    // $('#oetTAXTypepay').val('');
                    $('#oetTAXPos').val('');
                    $('#oetTAXRefIntDoc').val('');
                    $('#oetTAXRefIntDocDate').val('');
                    $('#oetTAXRefExtDoc').val('');
                    $('#oetTAXRefExtDocDate').val('');
                    $('#otxReason').text('');

                    //ข้อมูลส่วนที่อยู่
                    $('#oetTAXCusNameCusABB').val('');
                    $('#oetTAXNumber').val('');
                    $('#otxAddress1').val('');
                    $('#otxAddress2').val('');
                    $('#oetTAXTel').val('');
                    $('#oetTAXFax').val('');
                    $('#oetTAXBranch').val('');
                    $('#ocmTAXTypeBusiness option[value=1]').attr('selected','selected');
                    $('#ocmTAXBusiness option[value=1]').attr('selected','selected');
                    $('.selectpicker').selectpicker('refresh');
                }else{
                    var tTypeVAT    = aHD.raItems[0].FTXshVATInOrEx //ประเภท
                    var tPrintCount = aHD.raItems[0].FNXshDocPrint //ปริ้น 
                    var tTypePay    = aHD.raItems[0].FTXshCshOrCrd //ชำระโดย
                    var tPoscode    = aHD.raItems[0].FTPosCode //รหัสเครื่องจุดขาย
                    var tRefExt     = (aHD.raItems[0].FTXshRefExt == null ) ? '-' : aHD.raItems[0].FTXshRefExt; //อ้างอิงเอกสารภายนอก
                    var tRefExtDate = (aHD.raItems[0].FDXshRefExtDate == null ) ? '-' : aHD.raItems[0].FDXshRefExtDate; //วันที่เอกสารภายนอก
                    var tRefInt     = (aHD.raItems[0].FTXshRefInt == null ) ? '-' : aHD.raItems[0].FTXshRefInt; //เลขที่ภายใน
                    var tRefIntDate = (aHD.raItems[0].FDXshRefIntDate == null ) ? '-' : aHD.raItems[0].FDXshRefIntDate; //วันภายใน
                    var tRemark     = aHD.raItems[0].FTXshRmk //หมายเหตุ

                    if(tTypeVAT == 1){ var tTypeVAT = 'รวมใน' }else{ var tTypeVAT = 'แยกนอก' }
                    // $('#oetTAXTypeVat').val(tTypeVAT);
                    $('#oetTAXCountPrint').val(tPrintCount);
                    if(tTypePay == 1){ var tTypePay = 'เงินสด' }else{ var tTypePay = 'เครดิต' }
                    // $('#oetTAXTypepay').val(tTypePay);
                    // $('#oetTAXPos').val(tPoscode);
                    $('#oetTAXRefIntDoc').val(tRefInt);
                    $('#oetTAXRefIntDocDate').val(tRefIntDate);
                    $('#oetTAXRefExtDoc').val(tRefExt);
                    $('#oetTAXRefExtDocDate').val(tRefExtDate);
                    $('#otxReason').text(tRemark);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }

    //rander view - address (ที่อยู่)
    function JSxRanderAddress(ptDocumentABB,ptCustomer,ptNameCustomer){
        $.ajax({
            type    : "POST",
            url     : "dcmTXFCLoadAddress",
            data    : { 'tDocumentNumber' : ptDocumentABB , 'tCustomer' : ptCustomer },
            cache   : false,
            Timeout : 0,
            success : function (oResult) {
                var aPackData = JSON.parse(oResult);
                if(aPackData.tStatus == 'null'){
                    console.log('ไม่พบข้อมูลที่อยู่');

                    $('#oetTAXCusNameCusABB').val('');
                    $('#otxAddress1').val('');
                    $('#otxAddress2').val('');
                    $('#oetTAXTel').val('');
                    $('#oetTAXFax').val('');
                    $('#oetTAXBranch').val('');
                    $('#ocmTAXTypeBusiness option[value=1]').attr('selected','selected');
                    $('#ocmTAXBusiness option[value=1]').attr('selected','selected');
                    $('.selectpicker').selectpicker('refresh');

                    if(ptCustomer != '' || ptCustomer != null){
                        $('#oetTAXCusName').val(ptNameCustomer);
                        $('#oetTAXCusCode').val(ptCustomer);
                    }

                }else if(aPackData.tStatus == 'passABB'){
                    console.log('ใช้ที่อยู่ ของ TCNMTaxAddress_L');
                    JSvRanderAddressMoreOne(aPackData.aList,'TaxADD');
                    $('#obtBrowseAddress').attr('disabled',false);
                }else if(aPackData.tStatus == 'passCst'){
                    console.log('ใช้ที่อยู่ ของ TCNMCstAddress_L');
                    JSvRanderAddressMoreOne(aPackData.aList,'CstADD');
                    $('#obtBrowseAddress').attr('disabled',false);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }

    //กรณีที่อยู่มากกว่า 1 
    function JSvRanderAddressMoreOne(oText,ptType){
        //มีที่อยู่มากกว่า 1
        if(oText.length > 1){
            $('#odvTAXModalAddressMoreOne').modal('show');
                $('#odvTAXModalAddressMoreOne .xCNTableAddressMoreOne tbody').html('');
                for(i=0; i<oText.length; i++){
                    var aNewReturn  = JSON.stringify(oText[i]);

                    //ที่อยู่ของลูกค้าที่เคยออกเเล้ว 
                    if(ptType == 'TaxADD'){
                        var tName = oText[i].FTAddName;
                        if(oText[i].FTAddFax == ''){ var tFTAddFax = '-'; }else{ var tFTAddFax = oText[i].FTAddFax; }
                        if(oText[i].FTAddTel == ''){ var FTAddTel = '-';  }else{ var FTAddTel = oText[i].FTAddTel; }
                        if(oText[i].FTAddV2Desc2 == ''){ var tFTAddV2Desc2 = '-'; }else{ var tFTAddV2Desc2 = oText[i].FTAddV2Desc2; }
                        if(oText[i].FTAddV2Desc1 == ''){ var tFTAddV2Desc1 = '-'; }else{ var tFTAddV2Desc1 = oText[i].FTAddV2Desc1; }
                    }

                    //ที่อยู่ของลูกค้า
                    if(ptType == 'CstADD'){
                        var tName       = oText[i].FTAddName;
                        var tFTAddFax   = '-'; 
                        var FTAddTel    = '-'; 
                        if(oText[i].FTAddV2Desc2 == ''){ var tFTAddV2Desc2 = '-'; }else{ var tFTAddV2Desc2 = oText[i].FTAddV2Desc2; }
                        if(oText[i].FTAddV2Desc1 == ''){ var tFTAddV2Desc1 = '-'; }else{ var tFTAddV2Desc1 = oText[i].FTAddV2Desc1; }
                    }

                    var tClassName = 'xCNColumnAddressMoreOne' + i;
                    var tHTML = "<tr class='"+tClassName+" xCNColumnAddressMoreOne' data-information='["+aNewReturn+"]' style='cursor: pointer;'>";
                        tHTML += "<td>"+tName+"</td>";
                        tHTML += "<td>"+tFTAddV2Desc1+"</td>";
                        tHTML += "<td>"+tFTAddV2Desc2+"</td>";
                        tHTML += "<td>"+FTAddTel+"</td>";
                        tHTML += "<td>"+tFTAddFax+"</td>";
                        tHTML += "</tr>";
                    $('#odvTAXModalAddressMoreOne .xCNTableAddressMoreOne tbody').append(tHTML);
                }

                //เลือกที่อยู่
                $('.xCNColumnAddressMoreOne').off();

                //ดับเบิ้ลคลิก
                $('.xCNColumnAddressMoreOne').on('dblclick',function(e){
                    $('#odvTAXModalAddressMoreOne').modal('hide');
                    var tJSON       = $(this).attr('data-information');
                    FSvPushDataInforToView(tJSON);
                });

                //คลิกได้เลย
                $('.xCNColumnAddressMoreOne').on('click',function(e){
                    //เลือกที่อยู่แบบตัวเดียว
                    $('.xCNColumnAddressMoreOne').removeClass('xCNActiveAddress');
                    $('.xCNColumnAddressMoreOne').children().attr('style', 'background-color:transparent !important; color:#232C3D !important;');

                    $(this).addClass('xCNActiveAddress');
                    $(this).children().attr('style', 'background-color:#179bfd !important; color:#FFF !important;');
                });
        }else{
            //มีที่อยู่ตัวเดียว
            var aNewReturn  = JSON.stringify(oText);
            FSvPushDataInforToView(aNewReturn);
        }
    }

    //เลือกที่อยู่ กรณีพบมากกว่าหนึ่งตัว
    function JCNxConfirmAddressMoreOne(){  
        $("#odvTAXModalAddressMoreOne .xCNTableAddressMoreOne tbody .xCNActiveAddress").each(function( index ) {
            var tJSON       = $(this).attr('data-information');
            FSvPushDataInforToView(tJSON);
        });
    }

    //หลังจากค้นหาเสร็จแล้ว หรือ กดเลือกที่อยู่เเล้ว
    function FSvPushDataInforToView(ptAddress){
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1){
            JCNxOpenLoading();

            var oAddress        = JSON.parse(ptAddress);
            var oAddress        = oAddress[0];
            var tCustomerName   = oAddress.FTCstName;
            var tAddressName    = oAddress.FTAddName;
            var tAddressCode    = oAddress.FTCstCode;
            var tAddress1       = oAddress.FTAddV2Desc1;
            var tAddress2       = oAddress.FTAddV2Desc2;
            var tAddressTel     = oAddress.FTAddTel;
            var tAddressTaxNo   = oAddress.FTAddTaxNo;
            var tAddressFax     = oAddress.FTAddFax;

            if(tCustomerName == '' || tAddressCode == '' || tAddressCode == null || tCustomerName == null ){

            }else{
                $('#oetTAXCusName').val(tCustomerName);
                $('#oetTAXCusCode').val(tAddressCode);
            }

            $('#oetTAXCusNameCusABB').val(tAddressName);
            $('#otxAddress1').val(tAddress1);
            $('#otxAddress2').val(tAddress2);
            $('#oetTAXNumber').val(tAddressTaxNo);
            $('#oetTAXTel').val(tAddressTel);
            $('#oetTAXFax').val(tAddressFax);

            //ประเภทกิจการ
            var tBusiness = oAddress.FTAddStaBusiness;
            $('#ocmTAXTypeBusiness option[value='+tBusiness+']').attr('selected','selected');

            //สถานประกอบการ
            var tStaHQ = oAddress.FTAddStaHQ;
            $('#ocmTAXBusiness option[value='+tStaHQ+']').attr('selected','selected');

            //รหัสสาขา
            var tBCHCode = oAddress.FTAddStaBchCode;
            $('#oetTAXBranch').val(tBCHCode);
            $('.selectpicker').selectpicker('refresh');

            $('#ohdSeqAddress').val(oAddress.FNAddSeqNo);

            JCNxCloseLoading();
        }else{
            JCNxShowMsgSessionExpired();
        }
    }   

    /********************************************************************************************/// ส า ข า

    $('#obtBrowseBCH').click(function(){ JCNxBrowseData('oBrowse_BCH'); });
    var nLangEdits 	= <?php echo $this->session->userdata("tLangEdit"); ?>;
    // var tSessionMultiBchCode = "<?=$this->session->userdata("tSesUsrBchCodeMulti")?>";

    // var tWhereBch = '';
    //     if(tSessionMultiBchCode!=''){
    //         tWhereBch += "  AND TCNMBranch.FTBchCode IN ("+tSessionMultiBchCode+") ";
    //     }

    var tUsrLevel = "<?php echo $this->session->userdata("tSesUsrLevel"); ?>";
    var tBchCodeMulti = "<?php echo $this->session->userdata("tSesUsrBchCodeMulti"); ?>";
    var nCountBch = "<?php echo $this->session->userdata("nSesUsrBchCount"); ?>";
    var tWhere = "";

    if(nCountBch == 1){
        $('#obtBrowseBCH').attr('disabled',true);
    }
    if(tUsrLevel != "HQ"){
        tWhere = " AND TCNMBranch.FTBchCode IN ("+tBchCodeMulti+") ";
    }else{
        tWhere = "";
    }


    var oBrowse_BCH = {
        Title   : ['company/branch/branch','tBCHTitle'],
        Table   : {Master:'TCNMBranch',PK:'FTBchCode',PKName:'FTBchName'},
        Join    : {
            Table   : ['TCNMBranch_L','TCNMWaHouse_L'],
            On      : ['TCNMBranch_L.FTBchCode = TCNMBranch.FTBchCode AND TCNMBranch_L.FNLngID ='+nLangEdits,
                        'TCNMBranch.FTWahCode = TCNMWaHouse_L.FTWahCode AND TCNMBranch.FTBchCode = TCNMWaHouse_L.FTBchCode AND TCNMWaHouse_L.FNLngID ='+nLangEdits,
            ]
        },
        Where:{
            Condition : [tWhere]
        },
        GrideView:{
            ColumnPathLang      : 'company/branch/branch',
            ColumnKeyLang       : ['tBCHCode','tBCHName',''],
            ColumnsSize         : ['15%','75%',''],
            WidthModal          : 50,
            DataColumns         : ['TCNMBranch.FTBchCode','TCNMBranch_L.FTBchName','TCNMWaHouse_L.FTWahCode','TCNMWaHouse_L.FTWahName'],
            DataColumnsFormat   : ['',''],
            DisabledColumns     : [2,3],
            Perpage             : 10,
            OrderBy             : ['TCNMBranch_L.FTBchName'],
            SourceOrder         : "ASC"
        },
        CallBack:{
            ReturnType  : 'S',
            Value       : ["oetBrowseBchCode","TCNMBranch.FTBchCode"],
            Text        : ["oetBrowseBchName","TCNMBranch_L.FTBchName"],
        },
        // DebugSQL : true,
    }

    /********************************************************************************************/// ลู ก ค้ า 

    //ค้นหาลูกค้า
    $('#obtBrowseCus').on('click',function(){
        oSOBrowseCstOption      = oCstOption({
            'tReturnInputCode'  : 'oetTAXCusCode',
            'tReturnInputName'  : 'oetTAXCusName',
            'tNextFuncName'     : 'JSxFindAddressByCustomer',
            'aArgReturn'        : ['FTCstCode','FTCstTaxNo','FTCstCardID','FTCstName']
        });
        JCNxBrowseData('oSOBrowseCstOption');
    });

    var oCstOption      = function(poDataFnc){
        var nLangEdits          = '<?=$this->session->userdata("tLangEdit");?>';
        var tInputReturnCode    = poDataFnc.tReturnInputCode;
        var tInputReturnName    = poDataFnc.tReturnInputName;
        var tNextFuncName       = poDataFnc.tNextFuncName;
        var aArgReturn          = poDataFnc.aArgReturn;

        $tAgnCode = '<?=$this->session->userdata("tSesUsrAgnCode")?>';
        if($tAgnCode != ""){
            $tWhereAGN = "AND TCNMCst.FTAgnCode = " + $tAgnCode;
        }else{
            $tWhereAGN = '';
        }

        var oOptionReturn       = {
            Title   : ['document/taxinvoicefc/taxinvoicefc', 'tTAXCustomer'],
            Table   : {Master:'TCNMCst', PK:'FTCstCode'},
            Join    : {
                Table   : ['TCNMCst_L'],
                On      : [
                    'TCNMCst_L.FTCstCode    = TCNMCst.FTCstCode AND TCNMCst_L.FNLngID = '+nLangEdits
                ]
            },
            Where:{
                Condition : ["AND TCNMCst.FTCstStaActive = '1' " + $tWhereAGN]
            },
            GrideView:{
                ColumnPathLang      : 'document/taxinvoicefc/taxinvoicefc',
                ColumnKeyLang       : ['tTAXNoCustomer', 'tTAXNoCustomerName','tTAXTelphone','tTAXNumber','หมายเลขบัตรประชาชน'],
                ColumnsSize         : ['15%', '30%','20%','20%','20%'],
                WidthModal          : 50,
                DataColumns         : ['TCNMCst.FTCstCode', 'TCNMCst_L.FTCstName','TCNMCst.FTCstTel','TCNMCst.FTCstTaxNo','TCNMCst.FTCstCardID'],
                // DisabledColumns     : [5],
                DataColumnsFormat   : ['','','','',''],
                Perpage             : 10,
                OrderBy             : ['TCNMCst.FTCstCode ASC']
            },
            CallBack:{
                ReturnType  : 'S',
                Value       : [tInputReturnCode,"TCNMCst.FTCstCode"],
                Text        : [tInputReturnName,"TCNMCst_L.FTCstName"]
            },
            NextFunc:{
                FuncName    : tNextFuncName,
                ArgReturn   : aArgReturn
            }
        };
        return oOptionReturn;
    }

    //หลังจากกดเลือกลูกค้า จะไปค้นหาที่อยู่ของลูกค้า
    function JSxFindAddressByCustomer(ptParam){
        if(ptParam == 'NULL'){
            $('#obtBrowseAddress').attr('disabled',true);
            return;
        }else{
            $('#obtBrowseAddress').attr('disabled',false);
        }

        var tData           = JSON.parse(ptParam);
        var tDocumentABB    = $('#oetTAXABBCode').val();
        var tCustomer       = tData[0];
        var tTaxno          = tData[1];
        var tCardID         = tData[2];
        var tNameCustomer   = tData[3];

        if(tTaxno == '' || tTaxno == null){
            $('#oetTAXNumber').val(tCardID);
        }else{
            $('#oetTAXNumber').val(tTaxno);
        }

        JSxRanderAddress(tDocumentABB,tCustomer,tNameCustomer);
    }

    //ค้นหาที่อยุ่ของลูกค้าโดยตรง
    $('#obtBrowseAddress').attr('disabled',true);
    $('#obtBrowseAddress').on('click',function(){
        $('#odvTAXModalSelectAddressCustomer').modal('show');
        JCNxSearchBrowseSelectAddressCustomer(1);
    });

    //ค้นหาที่อยุ่ของลูกค้าโดยตรง
    function JCNxSearchBrowseSelectAddressCustomer(pnPage){
        var tSearchAddress  = $('#oetTextCustomerAddress').val();
        var nPage           = pnPage;
        var tCustomerCode   = $('#oetTAXCusCode').val();

        $.ajax({
            type    : "POST",
            url     : "dcmTXFCLoadDatatableCustomerAddress",
            data    : { 'tSearchAddress' : tSearchAddress , 'nPage' : nPage , 'tCustomerCode' : tCustomerCode },
            cache   : false,
            Timeout : 0,
            success : function (oResult) {
                var tHTML = JSON.parse(oResult);
                $('#odvContentSelectCustomerAddress').html(tHTML['tTableCustomerAddressHtml']);
                JCNxCloseLoading();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }

    //เลือก
    function JSxSelectCustomerAddress(){
        var tCustomercode       = $('#otbSelectCustomerAddress tbody tr.xCNActive').attr('data-cstcode');
        var tSeqno              = $('#otbSelectCustomerAddress tbody tr.xCNActive').attr('data-seqno');

        $.ajax({
            type    : "POST",
            url     : "dcmTXFCCustomerAddress",
            data    : { 'tDocumentNumber' : '' , 'tCustomer' : tCustomercode , 'tSeqno' : tSeqno },
            cache   : false,
            Timeout : 0,
            success : function (oResult) {
                var aPackData = JSON.parse(oResult);
                JSvRanderAddressMoreOne(aPackData.aList,'CstADD');
            },
            error: function (jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }

    /********************************************************************************************/// เ ล ข ที่ ป ร ะ จำ ตั ว ผู้ เ สี ย ภ า ษี

    //เลขที่ประจำตัวผู้เสียภาษี แบบคีย์
    function JSxSearchDocumentTAXCustomer(e,elem){
        var tValue = $(elem).val();
        $.ajax({
            type    : "POST",
            url     : "dcmTXFCCheckTaxNO",
            data    : { 'tTaxno' : tValue },
            cache   : false,
            Timeout : 0,
            success : function (oResult) {
                var aResult = JSON.parse(oResult);
                if(aResult.tStatus == 'not found'){
                    $('#odvTAXModalNotFoundTaxNo').modal('show');
                    $('#osmConfirmNotFoundTaxNo').off();
                    $('#osmConfirmNotFoundTaxNo').on('click',function(){
                        setTimeout(function(){ 
                            $('#oetTAXNumber').focus();
                            $('#oetTAXNumber').val(''); 
                        }, 100);
                    });
                }else{
                    JCNxOpenLoading();
                    JSvRanderAddressMoreOne(aResult.aAddress,'TaxADD');
                    JCNxCloseLoading();
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
        e.preventDefault();
    }

    //เลขที่ประจำตัวผู้เสียภาษี แบบเลือก
    $('#obtBrowseTAXNumber').on('click',function(){
        $('#odvTAXModalSelectTaxNo').modal('show');
        JCNxSearchBrowseTaxno(1);
    });

    //ค้นหาเลขที่ประจำตัวผู้เสียภาษี
    function JCNxSearchBrowseTaxno(pnPage){
        var tSearchTaxno      = $('#oetTextSearchTaxno').val();
        var nPage           = pnPage;
        $.ajax({
            type    : "POST",
            url     : "dcmTXFCLoadDatatableTaxNO",
            data    : { 'tSearchTaxno' : tSearchTaxno , 'nPage' : nPage },
            cache   : false,
            Timeout : 0,
            success : function (oResult) {
                var tHTML = JSON.parse(oResult);
                $('#odvContentSelectTaxno').html(tHTML['tTableTaxnoHtml']);
                JCNxCloseLoading();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }

    //เลือกใบกำกับภาษี
    function JSxSelectTaxno(){
        var tTaxno       = $('#otbSelectTaxno tbody tr.xCNActive').attr('data-taxno');
        var nSeq         = $('#otbSelectTaxno tbody tr.xCNActive').attr('data-seqno');
        $.ajax({
            type    : "POST",
            url     : "dcmTXFCCheckTaxNO",
            data    : { 'tTaxno' : tTaxno , 'nSeq' : nSeq },
            cache   : false,
            Timeout : 0,
            success : function (oResult) {
                var aResult = JSON.parse(oResult);
                JSvRanderAddressMoreOne(aResult.aAddress,'TaxADD');
            },
            error: function (jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }
</script>

<!--- PAGE - PREVIEW -->
<script>
    if('<?=$tTypePage?>' == 'Preview'){
        $('.selectpicker').selectpicker();

        //Block ปุ๊ป หลังจากอนุมัติเเล้ว
        $('.xCNCreate a').text('<?=language('document/taxinvoicefc/taxinvoicefc', 'tTAXPreview');?>');

        //เปิดปุ่มอนุมัติ + ปุ่มตรวจสอบ
        $('#obtCancleDocument').addClass('xCNHide');
        $('#obtApproveDocument').addClass('xCNHide');
        $('#obtPrintDocument').removeClass('xCNHide');
        $('#obtPrintPreviewDocument').removeClass('xCNHide');
        $('#obtSaveDocument').removeClass('xCNHide');

        JSxDisableInput();
        JSxRanderHDDTPreview();
        JSxInputCanEdit();
        JCNxOpenLoading();
    }

    //Block ปุ๊ป
    function JSxDisableInput(){
        $('#oetTAXDocDate').attr('disabled',true);
        $('#oetTAXDocTime').attr('disabled',true);

        $('#oetTAXABBCode').attr('disabled',true);
        $('#obtBrowseTaxABB').attr('disabled',true);

        // $('#obtBrowseCus').attr('disabled',true);
        // $('#obtBrowseAddress').attr('disabled',true);

        $('#oetTAXCusNameCusABB').attr('disabled',true);
        // $('#oetTAXNumber').attr('disabled',true);
        // $('#obtBrowseTAXNumber').attr('disabled',true);

        // $('#ocmTAXTypeBusiness').attr('disabled',true);
        // $('#ocmTAXBusiness').attr('disabled',true);

        // $('#oetTAXBranch').attr('disabled',true);
        $('#oetTAXTel').attr('disabled',true);
        $('#oetTAXFax').attr('disabled',true);

        $('#otxAddress1').attr('disabled',true);
        $('#otxAddress2').attr('disabled',true);
        $('#otxReason').attr('disabled',true);

        $('#obtBrowseBCH').attr('disabled',true);
    }

    //Rander Preview
    function JSxRanderHDDTPreview(){
        var tDocumentNumber = '<?=$tDocumentNumber?>';
        var tBrowseBchCode =  '<?=$tDocumentBchCode?>';
        $.ajax({
            type    : "POST",
            url     : "dcmTXFCLoadDatatableTax",
            data    : { 'tDocumentNumber' : tDocumentNumber , 'tBrowseBchCode':tBrowseBchCode },
            cache   : false,
            Timeout : 0,
            success : function (oResult) {
                var tHTML = JSON.parse(oResult);

                $('#odvContentSumFooterTAX').html(tHTML['tContentSumFooter']);

                //HD
                var aHD         = tHTML.aDetailHD;
                var aHD         = aHD.raItems[0];

                var tDocTime    = aHD.FDXshDocDate;
                var aSplitTime  = tDocTime.split(" ");
                $('#oetTAXDocDate').val(aSplitTime[0]);
                $('#oetTAXDocTime').val(aSplitTime[1]);
                $('#oetTAXABBCode').val(aHD.FTXshRefExt);
                $('#oetTAXCusName').val('');
                $('#oetTAXCusCode').val('');
                $('#otxReason').text('');
                $('#olbStatusDocument').text('อนุมัติแล้ว');
                var FTXshDocNo  = aHD.FTXshDocNo //ประเภท
                var tTypeVAT    = aHD.FTXshVATInOrEx //ประเภท
                var tPrintCount = aHD.FNXshDocPrint //ปริ้น 
                var tTypePay    = aHD.FTXshCshOrCrd //ชำระโดย
                var tPoscode    = aHD.FTPosCode //รหัสเครื่องจุดขาย
                var tRefExt     = (aHD.FTXshRefExt == null ) ? '-' : aHD.FTXshRefExt; //อ้างอิงเอกสารภายนอก
                var tRefExtDate = (aHD.FDXshRefExtDate == null ) ? '-' : aHD.FDXshRefExtDate; //วันที่เอกสารภายนอก
                var tRefInt     = (aHD.FTXshRefInt == null ) ? '-' : aHD.FTXshRefInt; //เลขที่ภายใน
                var tRefIntDate = (aHD.FDXshRefIntDate == null ) ? '-' : aHD.FDXshRefIntDate; //วันภายใน
                var tRemark     = aHD.FTXshRmk //หมายเหตุ
                if(tTypeVAT == 1){ var tTypeVAT = 'รวมใน' }else{ var tTypeVAT = 'แยกนอก' }
                $('#oetTAXTypeVat').val(tTypeVAT);
                $('#oetTAXCountPrint').val(tPrintCount);
                if(tTypePay == 1){ var tTypePay = 'เงินสด' }else{ var tTypePay = 'เครดิต' }
                $('#oetTAXTypepay').val(tTypePay);
                $('#oetTAXPos').val(tPoscode);
                $('#oetTAXRefIntDoc').val(tRefInt);
                $('#oetTAXRefIntDocDate').val(tRefIntDate);
                $('#oetTAXRefExtDoc').val(tRefExt);
                $('#oetTAXRefExtDocDate').val(tRefExtDate);
                $('#otxReason').text(tRemark);
                $('#oetTAXDocNo').val(FTXshDocNo);
                $('#oetTAXABBCode').val(aHD.FTXshRefExt);
                $('#ohdBCHDocument').val(aHD.FTBchCode);

                //ประเภทของเอกสาร
                $('#oetTAXABBTypeDocuement').val(aHD.FNXshDocType);

                //ที่อยู่
                if(tHTML.aDetailAddress != false){
                    var aAddresss = tHTML.aDetailAddress[0];
                    $('#oetTAXCusName').val(aAddresss.FTXshCstName);
                    $('#ohdSeqInTableAddress').val(aAddresss.FNAddSeqNo);
                    $('#ohdSeqAddress').val(aAddresss.FNAddSeqNo);
                    $('#oetTAXCusNameCusABB').val(aAddresss.FTAddName);
                    $('#oetTAXNumber').val(aAddresss.FTAddTaxNo);
                    $('#oetTAXNumberNew').val(aAddresss.FTAddTaxNo);
                    $('#ocmTAXTypeBusiness option[value='+aAddresss.FTAddStaBusiness+']').attr('selected','selected');
                    $('#ocmTAXBusiness option[value='+aAddresss.FTAddStaHQ+']').attr('selected','selected');
                    $('.selectpicker').selectpicker('refresh');
                    $('#oetTAXBranch').val(aAddresss.FTAddStaBchCode);
                    $('#oetTAXTel').val(aAddresss.FTAddTel);
                    $('#oetTAXFax').val(aAddresss.FTAddFax);
                    $('#otxAddress1').text(aAddresss.FTAddV2Desc1);
                    $('#otxAddress2').text(aAddresss.FTAddV2Desc2);
                }

                JSxRanderDTPreview(1);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }

    //rander view
    function  JSxRanderDTPreview(pnPage){
        var tDocumentNumber = '<?=$tDocumentNumber?>';
        var tBrowseBchCode =  '<?=$tDocumentBchCode?>';
        var tSearchPDT      = $('#oetTAXSearchPDT').val();
        $.ajax({
            type    : "POST",
            url     : "dcmTXFCLoadDatatableDTTax",
            data    : { 'tDocumentNumber' : tDocumentNumber ,'tBrowseBchCode':tBrowseBchCode, 'tSearchPDT' : tSearchPDT , 'nPage' : pnPage },
            cache   : false,
            Timeout : 0,
            success : function (oResult) {
                var tHTML = JSON.parse(oResult);
                $('#odvContentTAX').html(tHTML['tContentPDT']);
                JCNxCloseLoading();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }

    //เปิดให้ input เเก้ไขได้
    function JSxInputCanEdit(){
        $('#oetTAXCusNameCusABB').attr('disabled',false);
        $('#oetTAXTel').attr('disabled',false);
        $('#oetTAXFax').attr('disabled',false);
        $('#otxAddress1').attr('disabled',false);
        $('#otxAddress2').attr('disabled',false);

        //ปิด input สาขา
        $('.xCNSelectBCH').removeClass('col-lg-3').addClass('xCNHide');
        $('.xCNSelectTaxABB').removeClass('col-lg-8').addClass('col-lg-11');
    }

    $('#obtSaveDocument').off();
    $('#obtSaveDocument').on('click',function(){
        var tCusNameABB     = $('#oetTAXCusNameCusABB').val();
        var tBrowseBchCode  = $('#oetBrowseBchCode').val();
        var tTel            = $('#oetTAXTel').val();
        var tFax            = $('#oetTAXFax').val();
        var tAddress1       = $('#otxAddress1').val();
        var tAddress2       = $('#otxAddress2').val();
        var ptTaxNumberFull = $('#oetTAXDocNo').val();
        var tSeq            = $('#ohdSeqInTableAddress').val();
        var tNumberTax      = $('#oetTAXNumber').val();
        var tNumberTaxNew   = $('#oetTAXNumberNew').val();

        var tTypeBusiness   = $('#ocmTAXTypeBusiness option:selected').val();
        var tBusiness       = $('#ocmTAXBusiness option:selected').val();
        var tBchCode        = $('#oetTAXBranch').val();
        var tCstCode        = $('#oetTAXCusCode').val();
        var tCstName        = $('#oetTAXCusName').val();

        $.ajax({
            type    : "POST",
            url     : "dcmTXFCUpdateWhenApprove",
            data    : { 
                        'tDocumentNo'   : ptTaxNumberFull ,
                        'tBrowseBchCode': tBrowseBchCode,
                        'tCusNameABB'   : tCusNameABB , 
                        'tNumberTax'    : tNumberTax,
                        'tNumberTaxNew' : tNumberTaxNew,
                        'tTel'          : tTel , 
                        'tFax'          : tFax ,
                        'tAddress1'     : tAddress1,
                        'tAddress2'     : tAddress2,
                        'tSeq'          : tSeq,
                        'tSeqNew'       : $('#ohdSeqAddress').val(),
                        'tTypeBusiness' : tTypeBusiness,
                        'tBusiness'     : tBusiness,
                        'tBchCode'      : tBchCode,
                        'tCstCode'      : tCstCode,
                        'tCstName'      : tCstName
                    },
            cache   : false,
            Timeout : 0,
            success : function (oResult) {
                console.log(oResult);
                JSvTAXLoadPageAddOrPreview(tBrowseBchCode,ptTaxNumberFull);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    });
</script>