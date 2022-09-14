<style>
    .modal-open {
        overflow: hidden !important;
    }
</style>
<input type="hidden" name="ohdTAXApvType"  id="ohdTAXApvType" value="1"> <!-- 1.อนุมัติปกติ ใบลดหนี้/ใบเต็มรูป 2.อนุมัติใบยกเลิก ใบลดหนี้/ใบเต็มรูป -->
<input type="hidden" name="ohdTAXBrowseCusAddrType" id="ohdTAXBrowseCusAddrType" value="1"> <!-- 1.Browse ลูกค้าปกติ 2.Browse ลูกค้าจาก Modal Cancel Document -->
<input type="hidden" name="ohdTAXStaDoc" id="ohdTAXStaDoc" value="">
<input type="hidden" name="ohdDocBchCode"  id="ohdDocBchCode">
<input type="hidden" name="ohdDocType"  id="ohdDocType">
<form id="ofmTaxInvoice" class="validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data">
    <input type="text" class="xCNHide" id="oetTXIStaETax" name="oetTXIStaETax" value="">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">

            <!-- Panel รหัสเอกสารและสถานะเอกสาร -->
            <div class="panel panel-default" style="margin-bottom: 25px;">
                <div id="odvHeadStatus" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
                    <label class="xCNTextDetail1"><?=language('document/taxinvoice/taxinvoice', 'tTitlePanelDocument'); ?></label>
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
                                    <label class="xCNLabelFrm"><?= language('document/taxinvoice/taxinvoice', 'tTAXDocNoNew'); ?></label>
                                    <input 
                                        type="text"
                                        class="form-control xWTooltipsBT xCNInputWithoutSpcNotThai xCNInputWithoutSingleQuote"
                                        id="oetTAXDocNo"
                                        name="oetTAXDocNo"
                                        maxlength="20"
                                        value=""
                                        placeholder="<?=language('document/taxinvoice/taxinvoice','tTAXDocNoNew');?>"
                                        style="pointer-events:none"
                                        readonly
                                    >
                                    <input type="hidden" id="ohdBCHDocument" name="ohdBCHDocument">
                                </div>

                                <!-- วันที่ในการออกเอกสาร -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><span style="color:red">*</span><?=language('document/taxinvoice/taxinvoice','tTAXDocDate');?></label>
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
                                    <label class="xCNLabelFrm"><span style="color:red">*</span><?=language('document/taxinvoice/taxinvoice', 'tTAXDocTime');?></label>
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
                                            <label class="xCNLabelFrm"><?=language('document/taxinvoice/taxinvoice','tTAXCreateBy'); ?></label>
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
                                            <label class="xCNLabelFrm"><?=language('document/taxinvoice/taxinvoice','tTAXStaApv');?></label>
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
                    <label class="xCNTextDetail1"><?=language('document/taxinvoice/taxinvoice','tTitlePanelRef');?></label>
                    <a class="xCNMenuplus" role="button" data-toggle="collapse" href="#odvTWIDataConditionREF" aria-expanded="true">
                        <i class="fa fa-plus xCNPlus"></i>
                    </a>
                </div>
                <div id="odvTWIDataConditionREF" class="xCNMenuPanelData panel-collapse collapse in" role="tabpanel">
                    <div class="panel-body">

                        <!-- อ้างอิงเลขที่เอกสารภายต้นฉบับ กรณียกเลิกเอกสารกำกับภาษี -->
                        <div class="form-group xWTaxRefAE">
                            <label class="xCNLabelFrm"><?=language('document/taxinvoice/taxinvoice','อ้างอิงเอกสารต้นฉบับ');?></label>
                            <input type="text" class="form-control" id="oetTAXRefAE" name="oetTAXRefAE" readonly value="">
                        </div>

                        <!-- อ้างอิงเลขที่เอกสารภายใน -->
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?=language('document/taxinvoice/taxinvoice','tTAXLabelFrmRefIntDoc');?></label>
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
                            <label class="xCNLabelFrm"><?=language('document/taxinvoice/taxinvoice','tTAXLabelFrmRefIntDocDate');?></label>
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
                            <label class="xCNLabelFrm"><?=language('document/taxinvoice/taxinvoice','tTAXLabelFrmRefExtDoc');?></label>
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
                            <label class="xCNLabelFrm"><?=language('document/taxinvoice/taxinvoice','tTAXLabelFrmRefExtDocDate');?></label>
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
                    <label class="xCNTextDetail1"><?=language('document/taxinvoice/taxinvoice','tTitlePanelOther');?></label>
                    <a class="xCNMenuplus" role="button" data-toggle="collapse" href="#odvTWIDataConditionETC" aria-expanded="true">
                        <i class="fa fa-plus xCNPlus"></i>
                    </a>
                </div>
                <div id="odvTWIDataConditionETC" class="xCNMenuPanelData panel-collapse collapse in" role="tabpanel">
                    <div class="panel-body">

                        <!-- เหตุผล -->
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?= language('document/taxinvoice/taxinvoice', 'เหตุผล'); ?></label>
                            <div class="input-group">
                                <input id="oetTAXRsnName" name="oetTAXRsnName" class="form-control xCNClearValue" readonly type="text" value="" placeholder="<?= language('document/taxinvoice/taxinvoice', 'เหตุผล') ?>" >
                                <input id="oetTAXRsnCode" name="oetTAXRsnCode" value="" class="form-control xCNHide xCNClearValue" type="text">
                                <span class="input-group-btn">
                                    <button class="btn xCNBtnBrowseAddOn xCNApvOrCanCelDisabled xWETaxDisabled" id="obtTAXBrowseRsn" type="button">
                                        <img src="<?= base_url() . '/application/modules/common/assets/images/icons/find-24.png' ?>">
                                    </button>
                                </span>
                            </div>
                        </div>

                        <!-- ประเภทภาษี -->
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?=language('document/taxinvoice/taxinvoice','tTAXLabelTypeVat');?></label>
                            <input type="text" class="form-control" id="oetTAXTypeVat" name="oetTAXTypeVat" value="" readonly>
                        </div>

                        <!-- จำนวนครั้งที่พิมพ์ -->
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?=language('document/taxinvoice/taxinvoice','tTAXLabelCountPrint');?></label>
                            <input type="text" class="form-control" id="oetTAXCountPrint" name="oetTAXCountPrint" value="0" readonly style="text-align: right;">
                        </div>

                         <!-- ชำระเงินเป็นเงินสดหรือเครดิต -->
                         <div class="form-group">
                            <label class="xCNLabelFrm"><?=language('document/taxinvoice/taxinvoice','tTAXLabelTypePay');?></label>
                            <input type="text" class="form-control" id="oetTAXTypepay" name="oetTAXTypepay" value="" readonly>
                        </div>

                         <!-- รหัสเครื่องจุดขาย -->
                         <div class="form-group">
                            <label class="xCNLabelFrm"><?=language('document/taxinvoice/taxinvoice','tTAXLabelPos');?></label>
                            <input type="text" class="form-control" id="oetTAXPos" name="oetTAXPos" value="" readonly>
                        </div>

                    </div>
                </div>
            </div>
        </div>       

        <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9">
            <div class="row">
                <!-- เนื้อหาของลูกค้า -->
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="panel panel-default" style="margin-bottom:25px;position:relative;min-height:200px;">
                        <div class="panel-collapse collapse in" role="tabpanel">
                            <div class="panel-body">
                                <div style="margin-top: 10px;">

                                    <!--เลขที่ใบกำกับภาษีอย่างย่อ-->
                                    
                                        <div class="row">

                                            <!-- <div class="col-lg-3 col-md-12 col-sm-12 xCNSelecteTax">
                                                <div class="form-group">
                                                    <label class="xCNLabelFrm"><?=language('document/taxinvoice/taxinvoice','tTAXDocumentType');?></label>
                                                    <input type="hidden" id="ohdTAXRsnName" name="ohdTAXRsnName" value="">
                                                    <select class="selectpicker form-control xWETaxDisabled" id="oetTXIStaETax" name="oetTXIStaETax">
                                                        <option value="1"><?=language('document/taxinvoice/taxinvoice','tTAXDocTypeETax');?></option>
                                                        <option value="2"><?=language('document/taxinvoice/taxinvoice','tTAXDocType4');?></option>
                                                    </select>
                                                </div>
                                            </div> -->

                                            <div class="col-lg-3 col-md-12 col-sm-12 xCNSelectBCH">
                                                <!--สาขา-->
                                                <?php 
                                                    $nSesUsrBchCount  = $this->session->userdata("nSesUsrBchCount");
                                                    $tInputBchCode    = $this->session->userdata("tSesUsrBchCodeDefault");
                                                    $tInputBchName    = $this->session->userdata("tSesUsrBchNameDefault");
                                                    if($nSesUsrBchCount == 1 ){ 
                                                        $tDisabled = "disabled";
                                                    }else{
                                                        $tDisabled = "";
                                                    }
                                                ?>
                                                <div class="form-group">
                                                    <label class="xCNLabelFrm"><?= language('document/transferreceiptOut/transferreceiptOut', 'tTWITablePDTBch'); ?></label>
                                                    <div class="input-group">
                                                        <input name="oetBrowseBchName" id="oetBrowseBchName" class="form-control" value="<?=$tInputBchName?>" type="text" readonly=""  placeholder="<?= language('document/transferreceiptOut/transferreceiptOut', 'tTWITablePDTBch') ?>">
                                                        <input name="oetBrowseBchCode" id="oetBrowseBchCode" value="<?=$tInputBchCode?>" class="form-control xCNHide xCNClearValue" type="text">
                                                        <span class="input-group-btn">
                                                            <button class="btn xCNBtnBrowseAddOn xCNApvOrCanCelDisabled" id="obtBrowseBCH" type="button" <?=$tDisabled?> >
                                                                <img src="<?= base_url() . '/application/modules/common/assets/images/icons/find-24.png' ?>">
                                                            </button>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-9 col-md-12 col-sm-12 xCNSelectTaxABB">
                                                <div class="form-group">
                                                    <label class="xCNLabelFrm"><span style = "color:red">*</span><?= language('document/taxinvoice/taxinvoice', 'tTAXABB'); ?></label>
                                                    <div class="input-group">
                                                        <input name="oetTAXABBCode" maxlength="20" id="oetTAXABBCode" class="form-control xCNClearValue" type="text" placeholder="<?= language('document/taxinvoice/taxinvoice', 'tTAXABB') ?>" onchange="JSxSearchDocumentABB(event,this)" > <!-- onkeypress="Javascript:if(event.keyCode==13) JSxSearchDocumentABB(event,this);" -->
                                                        <span class="input-group-btn">
                                                            <button class="btn xCNBtnBrowseAddOn xCNApvOrCanCelDisabled disabled" type="button">
                                                                <img src="<?= base_url() . '/application/modules/common/assets/images/icons/scanner2.png' ?>">
                                                            </button>
                                                        </span>
                                                        <span class="input-group-btn">
                                                            <button class="btn xCNBtnBrowseAddOn xCNApvOrCanCelDisabled" id="obtBrowseTaxABB" type="button">
                                                                <img src="<?= base_url() . '/application/modules/common/assets/images/icons/find-24.png' ?>">
                                                            </button>
                                                        </span>
                                                        <input name="oetTAXABBTypeDocuement" id="oetTAXABBTypeDocuement" type="hidden">
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- <div class="col-lg-1 col-md-2 col-sm-2">
                                                <span>
                                                    <button class="btn xCNBtnBrowseAddOn xCNApvOrCanCelDisabled" id="obtBrowseTaxABB" type="button" style="float: right; margin-top: 25px;">
                                                        <img src="<?= base_url() . '/application/modules/common/assets/images/icons/find-24.png' ?>">
                                                    </button>
                                                </span>
                                            </div> -->
                                        </div>
                                    

                                    <!--ลูกค้า-->
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <label class="xCNLabelFrm"><?= language('document/taxinvoice/taxinvoice', 'tTAXCustomerName'); ?></label>
                                                <div class="input-group">
                                                    <input name="oetTAXCusNameCusABB" id="oetTAXCusNameCusABB" class="form-control xCNClearValue xWETaxDisabled xWETaxEnabledOniNetError" value="" type="text" placeholder="<?= language('document/taxinvoice/taxinvoice', 'tTAXCustomer') ?>" >
                                                    <input name="oetTAXCusCode" id="oetTAXCusCode" value="" class="form-control xCNHide xCNClearValue" type="text">
                                                    <span class="input-group-btn">
                                                        <button class="btn xCNBtnBrowseAddOn xCNApvOrCanCelDisabled xWETaxDisabled xWETaxEnabledOniNetError" id="obtBrowseCus" type="button">
                                                            <img src="<?= base_url() . '/application/modules/common/assets/images/icons/find-24.png' ?>">
                                                        </button>
                                                    </span>
                                                    <span class="input-group-btn">
                                                        <button class="btn xCNBtnBrowseAddOn xCNApvOrCanCelDisabled" id="obtBrowseAddress" type="button">
                                                            <img src="<?= base_url() . '/application/modules/common/assets/images/icons/Home.png' ?>">
                                                        </button>
                                                    </span>
                                                </div>  
                                            </div>
                                            <!-- <div class="col-lg-1 col-md-2 col-sm-2">
                                                <span>
                                                    <button class="btn xCNBtnBrowseAddOn xCNApvOrCanCelDisabled" id="obtBrowseAddress" type="button" style="float: right; margin-top: 25px;">
                                                        <img src="<?= base_url() . '/application/modules/common/assets/images/icons/Home.png' ?>">
                                                    </button>
                                                </span>
                                            </div> -->
                                        </div>
                                    </div>

                                    <!--รายละเอียดที่อยู่-->
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-lg-12">

                                                <!--ชื่อลูกค้า-->
                                                <div class="row">
                                                    <!-- <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label class="xCNLabelFrm"><span style = "color:red">*</span><?= language('document/taxinvoice/taxinvoice', 'tTAXCustomerName'); ?></label>
                                                            <input name="oetTAXCusNameCusABB"  autocomplete="off" id="oetTAXCusNameCusABB"  maxlength="255" class="form-control xCNClearValue" value="" type="text" placeholder="<?= language('document/taxinvoice/taxinvoice', 'tTAXCustomerName') ?>" >
                                                        </div>  
                                                    </div> -->
                                                    
                                                    <div class="col-lg-6">
                                                        <!--เลขที่ประจำตัวผู้เสียภาษี-->
                                                        <div class="form-group">
                                                            <label class="xCNLabelFrm"><span style = "color:red">*</span><?= language('document/taxinvoice/taxinvoice', 'tTAXNumber'); ?></label>
                                                            <div class="input-group">
                                                                <input name="oetTAXNumber" id="oetTAXNumber" autocomplete="off"  maxlength="20" class="form-control xCNClearValue xCNInputWithoutSpcNotThai xWETaxDisabled xWETaxEnabledOniNetError" value="" type="text" placeholder="<?= language('document/taxinvoice/taxinvoice', 'tTAXNumber') ?>" onkeypress="Javascript:if(event.keyCode==13) JSxSearchDocumentTAXCustomer(event,this);" >
                                                                <span class="input-group-btn">
                                                                    <button class="btn xCNBtnBrowseAddOn xCNApvOrCanCelDisabled xWETaxDisabled xWETaxEnabledOniNetError" id="obtBrowseTAXNumber" type="button">
                                                                        <img src="<?= base_url() . '/application/modules/common/assets/images/icons/find-24.png' ?>">
                                                                    </button>
                                                                </span> 

                                                                <input type="hidden" name="oetTAXNumberNew" id="oetTAXNumberNew"> 
                                                                <input type="hidden" name="ohdSeqAddress" id="ohdSeqAddress">
                                                                <input type="hidden" name="ohdSeqInTableAddress" id="ohdSeqInTableAddress" >
                                                            </div>
                                                        

                                                        <!-- <div class="col-lg-2 col-md-2 col-sm-2">
                                                            <div>
                                                                <span>
                                                                    <button class="btn xCNBtnBrowseAddOn xCNApvOrCanCelDisabled" id="obtBrowseTAXNumber" type="button" style="float: right; margin-top: 25px;">
                                                                        <img src="<?= base_url() . '/application/modules/common/assets/images/icons/find-24.png' ?>">
                                                                    </button>
                                                                </span> 
                                                            </div>
                                                        </div>   -->
                                                              
                                                        </div>  
                                                    </div>

                                                    <div class="col-lg-6">
                                                        <!--ประเภทกิจการ-->
                                                        <div class="form-group">
                                                            <label class="xCNLabelFrm"><?= language('document/taxinvoice/taxinvoice', 'tTAXTypeBusiness'); ?></label>
                                                            <select class="selectpicker form-control xWETaxDisabled" id="ocmTAXTypeBusiness" name="ocmTAXTypeBusiness" maxlength="1">
                                                                <option value="1"><?=language('document/taxinvoice/taxinvoice','tTAXTypeBusiness1')?></option>
                                                                <option value="2"><?=language('document/taxinvoice/taxinvoice','tTAXTypeBusiness2')?></option>
                                                            </select>
                                                        </div>  
                                                    </div> 

                                                </div>

                                                <div class="row xWTaxBusiness">
                                                    <div class="col-lg-6">
                                                        <!--สถานประกอบการ-->
                                                        <div class="form-group">
                                                            <label class="xCNLabelFrm"><?= language('document/taxinvoice/taxinvoice', 'tTAXBusiness'); ?></label>
                                                            <select class="selectpicker form-control xWETaxDisabled" id="ocmTAXBusiness" name="ocmTAXBusiness" maxlength="1">
                                                                <option value="1"><?=language('document/taxinvoice/taxinvoice','tTAXBusiness1')?></option>
                                                                <option value="2"><?=language('document/taxinvoice/taxinvoice','tTAXBusiness2')?></option>
                                                            </select>
                                                        </div>  
                                                    </div> 
                                                    <div class="col-lg-6">
                                                        <!--รหัสสาขา-->
                                                        <div class="form-group">
                                                            <label class="xCNLabelFrm"><?= language('document/taxinvoice/taxinvoice', 'tTAXBranch'); ?></label>
                                                            <input name="oetTAXBranch" id="oetTAXBranch" maxlength="5" class="form-control xCNClearValue xWETaxDisabled" value="" type="text" placeholder="<?= language('document/taxinvoice/taxinvoice', 'tTAXBranch') ?>" >
                                                        </div>    
                                                    </div>
                                                </div>  

                                                <hr>

                                            </div>

                                            <div class="col-lg-12">

                                                <div id="odvTAXAddress2" class="row">
                                                    <div class="col-lg-6">
                                                        <!--ที่อยู่ 1 -->
                                                        <div class="form-group">
                                                            <label class="xCNLabelFrm"><span style = "color:red">*</span><?= language('document/taxinvoice/taxinvoice', 'tTAXAddress1'); ?></label>
                                                            <textarea id="otxAddress1" class="xWETaxDisabled xWETaxEnabledOniNetError" rows="2" style="resize: none;" maxlength="255"> </textarea>
                                                        </div> 
                                                    </div> 
                                                    <div class="col-lg-6">
                                                        <!--ที่อยู่ 2 -->
                                                        <div class="form-group">
                                                            <label class="xCNLabelFrm"><?= language('document/taxinvoice/taxinvoice', 'tTAXAddress2'); ?></label>
                                                            <textarea id="otxAddress2" class="xWETaxDisabled xWETaxEnabledOniNetError" rows="2" style="resize: none;" maxlength="255"> </textarea>
                                                        </div> 
                                                    </div> 
                                                </div>
                                                
                                                <div id="odvTAXAddress1" class="row">
                                                    <div class="col-lg-6"><!--จังหวัด-->
                                                        <div class="form-group">
                                                            <label class="xCNLabelFrm"><span style = "color:red">*</span><?= language('document/taxinvoice/taxinvoice', 'จังหวัด'); ?></label>
                                                            <div class="input-group">
                                                                <input name="oetFTAddV1PvnName" id="oetFTAddV1PvnName" class="form-control xCNClearValue xWETaxDisabled xWETaxEnabledOniNetError" readonly type="text" value="" placeholder="<?= language('document/taxinvoice/taxinvoice', 'จังหวัด') ?>" >
                                                                <input name="oetFTAddV1PvnCode" id="oetFTAddV1PvnCode" value="" class="form-control xCNHide xCNClearValue" type="text">
                                                                <span class="input-group-btn">
                                                                    <button class="btn xCNBtnBrowseAddOn xCNApvOrCanCelDisabled xWETaxDisabled xWETaxEnabledOniNetError" id="obtBrowsePvn" type="button">
                                                                        <img src="<?= base_url() . '/application/modules/common/assets/images/icons/find-24.png' ?>">
                                                                    </button>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6"><!--อำเภอ/เขต-->
                                                        <div class="form-group">
                                                            <label class="xCNLabelFrm"><span style = "color:red">*</span><?= language('document/taxinvoice/taxinvoice', 'อำเภอ/เขต'); ?></label>
                                                            <div class="input-group">
                                                                <input name="oetFTAddV1DstName" id="oetFTAddV1DstName" class="form-control xCNClearValue xWETaxDisabled xWETaxEnabledOniNetError" readonly type="text" value="" placeholder="<?= language('document/taxinvoice/taxinvoice', 'อำเภอ/เขต') ?>" >
                                                                <input name="oetFTAddV1DstCode" id="oetFTAddV1DstCode" value="" class="form-control xCNHide xCNClearValue" type="text">
                                                                <span class="input-group-btn">
                                                                    <button class="btn xCNBtnBrowseAddOn xCNApvOrCanCelDisabled xWETaxDisabled xWETaxEnabledOniNetError" id="obtBrowseDst" type="button">
                                                                        <img src="<?= base_url() . '/application/modules/common/assets/images/icons/find-24.png' ?>">
                                                                    </button>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6"><!--ตำบล/แขวง-->
                                                        <div class="form-group">
                                                            <label class="xCNLabelFrm"><span style = "color:red">*</span><?= language('document/taxinvoice/taxinvoice', 'ตำบล/แขวง'); ?></label>
                                                            <div class="input-group">
                                                                <input name="oetFTAddV1SubDistName" id="oetFTAddV1SubDistName" class="form-control xCNClearValue xWETaxDisabled xWETaxEnabledOniNetError" readonly type="text" value="" placeholder="<?= language('document/taxinvoice/taxinvoice', 'ตำบล/แขวง') ?>" >
                                                                <input name="oetFTAddV1SubDistCode" id="oetFTAddV1SubDistCode" value="" class="form-control xCNHide xCNClearValue" type="text">
                                                                <span class="input-group-btn">
                                                                    <button class="btn xCNBtnBrowseAddOn xCNApvOrCanCelDisabled xWETaxDisabled xWETaxEnabledOniNetError" id="obtBrowseSubDist" type="button">
                                                                        <img src="<?= base_url() . '/application/modules/common/assets/images/icons/find-24.png' ?>">
                                                                    </button>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6"><!--รหัสไปรษณีย์-->
                                                        <div class="form-group">
                                                            <label class="xCNLabelFrm"><span style = "color:red">*</span><?= language('document/taxinvoice/taxinvoice', 'รหัสไปรษณีย์'); ?></label>
                                                            <input name="oetFTAddV1PostCode" id="oetFTAddV1PostCode"  maxlength="5" class="form-control xCNClearValue xWETaxDisabled xWETaxEnabledOniNetError" type="text" placeholder="<?= language('document/taxinvoice/taxinvoice', 'รหัสไปรษณีย์') ?>" >
                                                        </div>  
                                                    </div>
                                                    
                                                </div>

                                            </div>

                                            <div class="col-lg-12">
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <!--เบอร์โทรศัพท์-->
                                                        <div class="form-group">
                                                            <label class="xCNLabelFrm"><?= language('document/taxinvoice/taxinvoice', 'tTAXTelphone'); ?></label>
                                                            <input name="oetTAXTel" id="oetTAXTel"  maxlength="50" class="form-control xCNClearValue xCNInputNumericWithDecimal xWETaxDisabled xWETaxEnabledOniNetError" value="" type="text" placeholder="<?= language('document/taxinvoice/taxinvoice', 'tTAXTelphone') ?>" >
                                                        </div>  
                                                    </div> 
                                                    <div class="col-lg-6">
                                                        <!--เบอร์แฟ๊กซ์-->
                                                        <div class="form-group">
                                                            <label class="xCNLabelFrm"><?= language('document/taxinvoice/taxinvoice', 'tTAXFax'); ?></label>
                                                            <input name="oetTAXFax" id="oetTAXFax"  maxlength="50" class="form-control xCNClearValue xWETaxDisabled xWETaxEnabledOniNetError" value="" type="text" placeholder="<?= language('document/taxinvoice/taxinvoice', 'tTAXFax') ?>" >
                                                        </div> 
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-12">
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <!--อีเมล-->
                                                        <div class="form-group">
                                                            <label class="xCNLabelFrm"><?= language('document/taxinvoice/taxinvoice', 'tTAXEmail'); ?></label>
                                                            <input name="oetTAXEmail" id="oetTAXEmail"  maxlength="100" class="form-control xCNClearValue xWETaxDisabled xWETaxEnabledOniNetError" value="" type="text" placeholder="<?= language('document/taxinvoice/taxinvoice', 'tTAXEmail') ?>" >
                                                        </div>  
                                                    </div> 
                                                    <div class="col-lg-6"></div>
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
                                                        placeholder="<?=language('document/taxinvoice/taxinvoice','tTAXSearach')?>"
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
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                            <div id="odvContentTAX"></div>
                                        </div>
                                    </div>

                                    <style>
                                        #odvTAXRowDataEndOfBill .panel-heading{
                                            padding-top: 10px !important;
                                            padding-bottom: 10px !important;
                                        }
                                        #odvTAXRowDataEndOfBill .panel-body{
                                            padding-top: 0px !important;
                                            padding-bottom: 0px !important;
                                        }
                                        #odvTAXRowDataEndOfBill .list-group-item {
                                            padding-left: 0px !important;
                                            padding-right: 0px !important;
                                            border: 0px solid #ddd;
                                        }
                                        .mark-font, .panel-default > .panel-heading.mark-font{
                                            color: #232C3D !important;
                                            font-weight: 900;
                                        }
                                    </style>

                                    <div id="odvTAXRowDataEndOfBill" class="row p-t-10">
                                        <!-- End of Bill ฝั่งซ้าย -->
                                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                            <div class="panel panel-default">
                                                <!-- หมายเหตุ -->
                                                <div class="panel-heading">
                                                    <div class="pull-left mark-font"><?=language('document/saleorder/saleorder','หมายเหตุ');?></div>
                                                    <div class="clearfix"></div>
                                                </div>
                                                <div class="panel-body">
                                                    <div class="form-group m-t-10 m-b-10">
                                                        <textarea id="otaTAXRemark" name="otaTAXRemark" style="resize: none;" maxlength="200"> </textarea>
                                                    </div> 
                                                </div>
                                                <!-- หมายเหตุ -->
                                                
                                                <!-- ภาษีมูลค่าเพิ่ม -->
                                                <div class="panel-heading">
                                                    <div class="pull-left mark-font"><?=language('document/saleorder/saleorder','tSOTBVatRate');?></div>
                                                    <div class="pull-right mark-font"><?=language('document/saleorder/saleorder','tSOTBAmountVat');?></div>
                                                    <div class="clearfix"></div>
                                                </div>
                                                <div class="panel-body">
                                                    <ul class="list-group" id="oulTAXDataListVat" style="margin-bottom: 0px;margin-top: 10px;"></ul>
                                                    <ul class="list-group" style="margin-bottom: 0px;">
                                                        <li class="list-group-item">
                                                            <label class="pull-left mark-font"><?=language('document/saleorder/saleorder','tSOTBTotalValVat');?></label>
                                                            <label class="pull-right mark-font" id="olbTAXVatSum">0.00</label>
                                                            <div class="clearfix"></div>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <!-- <div class="panel-heading">
                                                    <label class="pull-left mark-font"><?=language('document/saleorder/saleorder','tSOTBTotalValVat');?></label>
                                                    <label class="pull-right mark-font" id="olbTAXVatSum">0.00</label>
                                                    <div class="clearfix"></div>
                                                </div> -->
                                                <!-- ภาษีมูลค่าเพิ่ม -->

                                                <!-- ข้อมูลการชำระเงิน -->
                                                <div class="panel-heading">
                                                    <div class="pull-left mark-font"><?=language('document/document/document','tDocPayInfo');?></div>
                                                    <div class="pull-right mark-font"></div>
                                                    <div class="clearfix"></div>
                                                </div>
                                                <div class="panel-body">
                                                    <ul class="list-group" id="oulTAXDataListPayment" style="margin-bottom: 0px;margin-top: 10px;"></ul>
                                                </div>
                                                <div class="panel-heading">
                                                    <label class="pull-left mark-font"><?=language('document/document/document','tDocPayGrand');?></label>
                                                    <label class="pull-right mark-font" id="olbTAXPaymentSum">0.00</label>
                                                    <div class="clearfix"></div>
                                                </div>
                                                <!-- ข้อมูลการชำระเงิน -->

                                            </div>
                                        </div>
                                        <!-- End of Bill ฝั่งซ้าย -->
                                        
                                        <!-- End of Bill ฝั่งขวา -->
                                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                            <!-- ส่วนลดโปรโมชั่น -->
                                            <div class="panel panel-default" style="margin-bottom: 20px;">
                                                <div class="panel-heading">
                                                    <div class="pull-left mark-font"><?=language('document/document/document','tDocDisPromotions');?></div>
                                                    <div class="pull-right mark-font"><?=language('document/document/document','tDocTotalDisPro');?></div>
                                                    <div class="clearfix"></div>
                                                </div>
                                                <div class="panel-body">
                                                    <ul class="list-group" id="oulTAXDataListPromotions" style="margin-bottom: 0px;margin-top: 10px;"></ul>
                                                    <ul class="list-group" style="margin-bottom: 0px;">
                                                        <li class="list-group-item">
                                                            <label class="pull-left mark-font"><?=language('document/document/document','tDocGrandDisPro');?></label>
                                                            <label class="pull-right mark-font" id="olbTAXPromotionsSum">0.00</label>
                                                            <div class="clearfix"></div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <!-- ส่วนลดโปรโมชั่น -->

                                            <div id="odvContentSumFooterTAX"></div> <!--wTaxInvoiceSumFooter.php -->
                                        </div>
                                        <!-- End of Bill ฝั่งขวา -->

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
                        <label class="xCNTextModalHeard" style="font-weight: bold; font-size: 20px;"><?=language('document/taxinvoice/taxinvoice', 'tTAXShow')?><?=language('document/taxinvoice/taxinvoice', 'tTAXABB')?></label>
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
                            <label class="xCNLabelFrm"><?= language('document/taxinvoice/taxinvoice', 'tTAXFilterAdv'); ?></label>
                            <select class="selectpicker form-control" id="ocmTAXAdvSearch" name="ocmTAXAdvSearch" maxlength="1">
                                <option value="2"><?=language('document/taxinvoice/taxinvoice','tTAXFilterAdv2')?></option>
                                <option value="3"><?=language('document/taxinvoice/taxinvoice','tTAXFilterAdv3')?></option>
                            </select>
                        </div> 
                    </div>
                    <div class="col-lg-5">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-lg-5">
                                    <label class="xCNLabelFrm"><?= language('document/taxinvoice/taxinvoice', 'tTAXFilterAdv1'); ?></label>
                                    <div class="xCNFilterDate">
                                        <input class="form-control xCNDatePicker xCNInputMaskDate" id="oetTaxDateABB" type="text" value="<?=date('Y-m-d')?>" autocomplete="off" placeholder="">
                                    </div>  
                                </div>
                                <div class="col-lg-7">
                                    <label class="xCNLabelFrm"></label>
                                    <div class="xCNFilterOther input-group">
                                        <input class="form-control" id="oetTextFilter" maxlength="100" type="text" value="" onkeypress="Javascript:if(event.keyCode==13 ) JCNxSearchBrowseABB(1)" autocomplete="off" placeholder="<?=language('document/taxinvoice/taxinvoice', 'tTAXSearach')?>">
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
                <label class="xCNTextModalHeard" style="font-weight: bold; font-size: 20px;"><?=language('document/taxinvoice/taxinvoice', 'tTAXwarning')?></label>
			</div>
			<div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
						<span><?=language('document/taxinvoice/taxinvoice', 'tTAXABBNotFound')?></span>
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
                <label class="xCNTextModalHeard" style="font-weight: bold; font-size: 20px;"><?=language('document/taxinvoice/taxinvoice', 'tTAXwarning')?></label>
			</div>
			<div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
						<span><?=language('document/taxinvoice/taxinvoice', 'tTAXNoNotFound')?></span>
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
                        <label class="xCNTextModalHeard" style="font-weight: bold; font-size: 20px;"><?=language('document/taxinvoice/taxinvoice', 'tTAXwarningAddress')?></label>
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
                            <th class="xCNTextBold" style="text-align:center; width:120px;"><?=language('document/taxinvoice/taxinvoice', 'tTAXCustomerName')?></th>
                            <th class="xCNTextBold" style="text-align:center; width:160px;"><?=language('document/taxinvoice/taxinvoice', 'tTAXAddress1')?></th>
                            <th class="xCNTextBold" style="text-align:center; width:120px;"><?=language('document/taxinvoice/taxinvoice', 'tTAXAddress2')?></th>
                            <th class="xCNTextBold" style="text-align:center; width:80px;"><?=language('document/taxinvoice/taxinvoice', 'tTAXTelphone')?></th>
                            <th class="xCNTextBold" style="text-align:center; width:80px;"><?=language('document/taxinvoice/taxinvoice', 'tTAXFax')?></th>
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
                        <label class="xCNTextModalHeard" style="font-weight: bold; font-size: 20px;"><?=language('document/taxinvoice/taxinvoice', 'tTAXShow')?><?=language('document/taxinvoice/taxinvoice', 'tTAXNumber')?></label>
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
                            <label class="xCNLabelFrm"><?= language('document/taxinvoice/taxinvoice', 'tTAXFilterAdv'); ?></label>
                            <div class="input-group">
                                <input class="form-control" id="oetTextSearchTaxno" type="text" value="" onkeypress="Javascript:if(event.keyCode==13 ) JCNxSearchBrowseTaxno(1)" autocomplete="off" placeholder="<?=language('document/taxinvoice/taxinvoice', 'tTAXSearach')?>">
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
                        <label class="xCNTextModalHeard" style="font-weight: bold; font-size: 20px;"><?=language('document/taxinvoice/taxinvoice', 'tTAXShow')?><?=language('document/taxinvoice/taxinvoice', 'tTAXNoCustomerModal')?></label>
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
                            <label class="xCNLabelFrm"><?= language('document/taxinvoice/taxinvoice', 'tTAXFilterAdv'); ?></label>
                            <div class="input-group">
                                <input class="form-control" id="oetTextCustomerAddress" type="text" value="" onkeypress="Javascript:if(event.keyCode==13 ) JCNxSearchBrowseSelectAddressCustomer(1)" autocomplete="off" placeholder="<?=language('document/taxinvoice/taxinvoice', 'tTAXSearach')?>">
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

<!--- ============================================================== ยกเลิกใบกำกับภาษี =============================================== -->
<div id="odvTAXModalCancelETax" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true"> <!-- data-toggle="modal" data-backdrop="static" data-keyboard="false"-->
    <form id="ofmTaxCancel">
        <div class="modal-dialog modal-dialog-scrollable" style="margin: 1.75rem auto;">
            <div class="modal-content">
                <div class="modal-header xCNModalHead">
                    <label class="xCNTextModalHeard" style="font-weight: bold; font-size: 20px;"><?=language('document/taxinvoice/taxinvoice', 'ยกเลิกใบกำกับภาษี')?></label>
                </div>
                <div class="modal-body">
                    
                    <div class="row">

                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="row">
                                <div class="col-lg-6"><!--เลขที่ใบกำกับภาษี-->
                                    <div class="form-group">
                                        <label class="xCNLabelFrm"><?= language('document/taxinvoice/taxinvoice', 'เลขที่ใบกำกับภาษี'); ?></label>
                                        <input id="oetTAXModalCancelDocNo" readonly class="form-control xCNClearValue xWDisabledForCN" type="text" placeholder="<?= language('document/taxinvoice/taxinvoice', 'เลขที่ใบกำกับภาษี') ?>" >
                                    </div>
                                </div>
                                <div class="col-lg-6"><!--เหตุผลการยกเลิก-->
                                    <div class="form-group">
                                        <label class="xCNLabelFrm"><span style = "color:red">*</span><?= language('document/taxinvoice/taxinvoice', 'เหตุผลการยกเลิก'); ?></label>
                                        <div class="input-group">
                                            <input id="oetTAXModalCancelRsnName" name="oetTAXModalCancelRsnName" class="form-control xCNClearValue" readonly type="text" value="" placeholder="<?= language('document/taxinvoice/taxinvoice', 'เหตุผลการยกเลิก') ?>" >
                                            <input id="oetTAXModalCancelRsnCode" name="oetTAXModalCancelRsnCode" value="" class="form-control xCNHide xCNClearValue" type="text">
                                            <span class="input-group-btn">
                                                <button class="btn xCNBtnBrowseAddOn " id="obtTAXModalCancelBrowseRsn" type="button">
                                                    <img src="<?= base_url() . '/application/modules/common/assets/images/icons/find-24.png' ?>">
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label class="xCNLabelFrm"><span style = "color:red">*</span><?= language('document/taxinvoice/taxinvoice', 'tTAXCustomerName'); ?></label>
                                <div class="input-group">
                                    <input name="oetTAXModalCancelCstName" id="oetTAXModalCancelCstName" class="form-control xCNClearValue xWDisabledForCN" value="" type="text" placeholder="<?= language('document/taxinvoice/taxinvoice', 'tTAXCustomer') ?>" >
                                    <input name="oetTAXModalCancelCstCode" id="oetTAXModalCancelCstCode" value="" class="form-control xCNHide xCNClearValue" type="text">
                                    <span class="input-group-btn">
                                        <button class="btn xCNBtnBrowseAddOn xWDisabledForCN" id="obtTAXModalCancelBrowseCus" type="button">
                                            <img src="<?= base_url() . '/application/modules/common/assets/images/icons/find-24.png' ?>">
                                        </button>
                                    </span>
                                    <span class="input-group-btn">
                                        <button class="btn xCNBtnBrowseAddOn xWDisabledForCN" id="obtTAXModalCancelBrowseAddress" type="button">
                                            <img src="<?= base_url() . '/application/modules/common/assets/images/icons/Home.png' ?>">
                                        </button>
                                    </span>
                                </div>  
                            </div>
                        </div>

                        <div class="col-lg-12">

                            <div id="odvModalCancelddress2" class="row">
                                <div class="col-lg-6">
                                    <!--ที่อยู่ 1 -->
                                    <div class="form-group">
                                        <label class="xCNLabelFrm"><span style = "color:red">*</span><?= language('document/taxinvoice/taxinvoice', 'tTAXAddress1'); ?></label>
                                        <textarea id="otxTAXModalCancelAddress1" name="otxTAXModalCancelAddress1" class="form-control xWDisabledForCN" rows="2" style="resize: none;" maxlength="255"> </textarea>
                                    </div> 
                                </div> 
                                <div class="col-lg-6">
                                    <!--ที่อยู่ 2 -->
                                    <div class="form-group">
                                        <label class="xCNLabelFrm"><?= language('document/taxinvoice/taxinvoice', 'tTAXAddress2'); ?></label>
                                        <textarea id="otxTAXModalCancelAddress2" name="otxTAXModalCancelAddress2" class="form-control xWDisabledForCN" rows="2" style="resize: none;" maxlength="255"> </textarea>
                                    </div> 
                                </div> 
                            </div>

                            <div id="odvModalCancelAddress1" class="row">
                                <div class="col-lg-6"><!--จังหวัด-->
                                    <div class="form-group">
                                        <label class="xCNLabelFrm"><span style = "color:red">*</span><?= language('document/taxinvoice/taxinvoice', 'จังหวัด'); ?></label>
                                        <div class="input-group">
                                            <input id="oetTAXModalCancelPvnName" name="oetTAXModalCancelPvnName" class="form-control xCNClearValue xWDisabledForCN" readonly type="text" value="" placeholder="<?= language('document/taxinvoice/taxinvoice', 'จังหวัด') ?>" >
                                            <input id="oetTAXModalCancelPvnCode" name="oetTAXModalCancelPvnCode" value="" class="form-control xCNHide xCNClearValue" type="text">
                                            <span class="input-group-btn">
                                                <button class="btn xCNBtnBrowseAddOn xWDisabledForCN" id="obtTAXModalBrowsePvn" type="button">
                                                    <img src="<?= base_url() . '/application/modules/common/assets/images/icons/find-24.png' ?>">
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6"><!--อำเภอ/เขต-->
                                    <div class="form-group">
                                        <label class="xCNLabelFrm"><span style = "color:red">*</span><?= language('document/taxinvoice/taxinvoice', 'อำเภอ/เขต'); ?></label>
                                        <div class="input-group">
                                            <input id="oetTAXModalCancelDstName" name="oetTAXModalCancelDstName" class="form-control xCNClearValue xWDisabledForCN" readonly type="text" value="" placeholder="<?= language('document/taxinvoice/taxinvoice', 'อำเภอ/เขต') ?>" >
                                            <input id="oetTAXModalCancelDstCode" name="oetTAXModalCancelDstCode" value="" class="form-control xCNHide xCNClearValue" type="text">
                                            <span class="input-group-btn">
                                                <button class="btn xCNBtnBrowseAddOn xWDisabledForCN" id="obtTAXModalBrowseDst" type="button">
                                                    <img src="<?= base_url() . '/application/modules/common/assets/images/icons/find-24.png' ?>">
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6"><!--ตำบล/แขวง-->
                                    <div class="form-group">
                                        <label class="xCNLabelFrm"><span style = "color:red">*</span><?= language('document/taxinvoice/taxinvoice', 'ตำบล/แขวง'); ?></label>
                                        <div class="input-group">
                                            <input id="oetTAXModalCancelSubDistName" name="oetTAXModalCancelSubDistName" class="form-control xCNClearValue xWDisabledForCN" readonly type="text" value="" placeholder="<?= language('document/taxinvoice/taxinvoice', 'ตำบล/แขวง') ?>" >
                                            <input id="oetTAXModalCancelSubDistCode" name="oetTAXModalCancelSubDistCode" value="" class="form-control xCNHide xCNClearValue" type="text">
                                            <span class="input-group-btn">
                                                <button class="btn xCNBtnBrowseAddOn xWDisabledForCN" id="obtTAXModalBrowseSubDist" type="button">
                                                    <img src="<?= base_url() . '/application/modules/common/assets/images/icons/find-24.png' ?>">
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6"><!--รหัสไปรษณีย์-->
                                    <div class="form-group">
                                        <label class="xCNLabelFrm"><span style = "color:red">*</span><?= language('document/taxinvoice/taxinvoice', 'รหัสไปรษณีย์'); ?></label>
                                        <input id="oetTAXModalCancelPostCode" name="oetTAXModalCancelPostCode"  maxlength="5" class="form-control xCNClearValue xWDisabledForCN" type="text" placeholder="<?= language('document/taxinvoice/taxinvoice', 'รหัสไปรษณีย์') ?>" >
                                    </div>  
                                </div>
                            </div>

                        </div>
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <div class="row">
                        <div class="col-lg-8 col-md-12 col-sm-12 text-left text-danger">
                            <span id="ospTAXWarningMsgCancelCNFullTax" style="font-weight: bold;">กรณีชื่อ/ที่อยู่ไม่ถูกต้อง รบกวนดำเนินการแก้ไขที่ใบกำกับภาษีเต็มรูป</span>
                        </div>
                        <div class="col-lg-4 col-md-12 col-sm-12">
                            <button id="osmTAXModalConfirm" type="submit" class="btn xCNBTNPrimery">
                                <?=language('common/main/main', 'tModalConfirm'); ?>
                            </button>
                            <button type="button" class="btn xCNBTNDefult xCNBTNDefult2Btn" data-dismiss="modal">
                                <?=language('common/main/main', 'tCMNClose'); ?>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
                
    <!-- Input เก็บรหัส/ชื่อลูกค้า กรณี Browse ที่อยู่ลูกค้า -->
    <input type="text" class="xCNHide" id="oetTAXBrowseCstCode">
    <input type="text" class="xCNHide" id="oetTAXBrowseCstName">
</div> 


<script src="<?=base_url('application/modules/common/assets/js/jquery.mask.js')?>"></script>
<script src="<?=base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>

<!--- PAGE - INSERT -->
<script>

    if('<?=$tTypePage?>' == 'Insert'){
        //ปิดปุ่มอนุมัติ + ปุ่มตรวจสอบ
        $('#obtCancleDocument').removeClass('xCNHide');
        $('#obtApproveDocument').removeClass('xCNHide');
        $('#obtPrintPreviewDocumentABB').addClass('xCNHide');
        $('#obtPrintDocument').addClass('xCNHide');
        $('#obtPrintPreviewDocument').addClass('xCNHide');
        $('#obtSaveDocument').addClass('xCNHide');


         //Load หน้าตารางสินค้า
        JSxRanderHDDT('',1);
    }
    
    $('.xCNCreate a').text('<?= language('document/taxinvoice/taxinvoice', 'tCreate'); ?>');
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

        if( tValue == "" ){
            JSxRanderHDDT('',1); //Load ข้อมูลใหม่
        }else{
            $.ajax({
                type    : "POST",
                url     : "dcmTXINCheckABB",
                data    : { 'DocumentNumber' : tValue , 'tBCH' : tBCH },
                cache   : false,
                Timeout : 0,
                success : function (oResult) {
                    var aResult = JSON.parse(oResult);
                    if( aResult['tStatus'] != '1' ){
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
                        JSxSelectABB('KEY',tValue,aResult['tCuscode'],aResult['tCusname']);
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }
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
            url     : "dcmTXINLoadDatatableABB",
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
            var tDocumentABB    = ptDocument;
            var tCustomerName   = ptCusName;
        }else{
            var tCustomer       = $('#otbSelectABB tbody tr.xCNActive').attr('data-customer');
            var tDocumentABB    = $('#otbSelectABB tbody tr.xCNActive').attr('data-documentabb');
            var tCustomerName   = $('#otbSelectABB tbody tr.xCNActive').attr('data-customername');
            $('#oetTAXABBCode').val(tDocumentABB);
        }

        JSxRanderHDDT(tDocumentABB,1);
        JSxRanderAddress(tDocumentABB,tCustomer,tCustomerName);
    }

    //rander view - HD DT (รายละเอียด)
    function JSxRanderHDDT(ptDocumentNumber,pnPage){
        if('<?=$tTypePage?>' == 'Preview'){
            JSxRanderDTPreview(1);
            return;
        }

        JCNxOpenLoading();

        var tSearchPDT = $('#oetTAXSearchPDT').val();
        var tBrowseBchCode = $('#oetBrowseBchCode').val();
        if(ptDocumentNumber == ''){
            var tDocumentNumber = $('#oetTAXABBCode').val();
        }else{
            var tDocumentNumber = ptDocumentNumber;
        }

        $.ajax({
            type    : "POST",
            url     : "dcmTXINLoadDatatable",
            data    : { 'tDocumentNumber' : tDocumentNumber , 'tBrowseBchCode' : tBrowseBchCode , 'tSearchPDT' : tSearchPDT , 'nPage' : pnPage },
            cache   : false,
            Timeout : 0,
            success : function (oResult) {
                var tHTML = JSON.parse(oResult);
                $('#odvContentTAX').html(tHTML['tContentPDT']);
                $('#odvContentSumFooterTAX').html(tHTML['tContentSumFooter']);
                // console.log(tHTML);
                let aDataDisPro         = tHTML['aDataDisPro'];
                let aDataEndBillVat     = tHTML['aDataEndBillVat'];
                let aDataDocRC          = tHTML['aDataDocRC'];
                let nOptDecimalShow     = '<?=FCNxHGetOptionDecimalShow()?>';

                // ข้อมูลการชำระเงิน
                let tRenderRC = "";
                if( aDataDocRC['tCode'] == '1' ){
                    let cSumRC = 0;
                    for(let i=0; i<aDataDocRC['aItems'].length; i++){
                        console.log(i);
                        cSumRC += aDataDocRC['aItems'][i]['FCXrcNet'];
                        tRenderRC += '<tr class="text-center xCNTextDetail2 xWPdtItem">';
                        tRenderRC += '  <td nowrap  class="text-center">'+(i+1)+'</td>';
                        tRenderRC += '  <td nowrap  class="text-left">('+aDataDocRC['aItems'][i]['FTRcvCode']+') '+aDataDocRC['aItems'][i]['FTRcvName']+'</td>';
                        tRenderRC += '  <td nowrap  class="text-left">'+aDataDocRC['aItems'][i]['FTXrcRefNo1']+'</td>';
                        tRenderRC += '  <td nowrap  class="text-right">'+parseFloat(aDataDocRC['aItems'][i]['FCXrcNet']).toFixed(nOptDecimalShow)+'</td>';
                        tRenderRC += '</tr>';
                    }
                    tRenderRC += '<tr class="text-center xCNTextDetail2 xWPdtItem">';
                    tRenderRC += '  <td nowrap class="text-right" colspan="3"><strong><?=language('document/document/document','tDocPayGrand')?></strong></td>';
                    tRenderRC += '  <td nowrap class="text-right"><strong>'+parseFloat(cSumRC).toFixed(nOptDecimalShow)+'</strong></td>';
                    tRenderRC += '</tr>';
                }else{
                    tRenderRC += '<tr><td class="text-center xCNTextDetail2 xWTWITextNotfoundDataPdtTable" colspan="100%"><?=language('common/main/main','tCMNNotFoundData')?></td></tr>';
                }
                $('#odvTAXReceiveInfo tbody').html(tRenderRC);

                //รายการส่วนลดโปรโมชั่น
                if( aDataDisPro['tCode'] == '1' ){
                    let aDisProItems    = aDataDisPro['aItems'];
                    let tDisProList     = "";
                    if( aDisProItems.length > 0 ){
                        for(let i = 0; i < aDisProItems.length; i++){
                            let tDisProValue = parseFloat(aDisProItems[i]['FCXddValue']).toFixed(nOptDecimalShow) == 0 ? '0.00' : parseFloat(aDisProItems[i]['FCXddValue']).toFixed(nOptDecimalShow);
                            tDisProList += '<li class="list-group-item" style="padding-top: 1px;padding-bottom: 1px;"><label class="pull-left">'+ aDisProItems[i]['FTPmhName'] + '</label><label class="pull-right">' + tDisProValue + '</label><div class="clearfix"></div></li>';
                        }
                        
                        $('#oulTAXDataListPromotions').html(tDisProList);

                        // ยอดรวมภาษีมูลค่าเพิ่ม
                        let cDisProSumValue = parseFloat(aDisProItems[0]['FCXddSumValue']).toFixed(nOptDecimalShow);
                        $('#olbTAXPromotionsSum').text(cDisProSumValue);
                        
                    }
                }

                // รายการ vat
                var aVatItems   = aDataEndBillVat['aItems'];
                var tVatList    = "";
                if(aVatItems.length > 0){
                    let tSumVatTotal = 0;
                    for(var i = 0; i < aVatItems.length; i++){
                        var tVatRate    = parseFloat(aVatItems[i]['FCXtdVatRate']).toFixed(0);
                        // var tSumVat = parseFloat(aVatItems[i]['FCXtdVat']).toFixed(0) == 0 ? '0.00' : parseFloat(aVatItems[i]['FCXtdVat']).toFixed(2);
                        var tVatValue   = parseFloat(aVatItems[i]['FCXtdVat']).toFixed(nOptDecimalShow) == 0 ? '0.00' : parseFloat(aVatItems[i]['FCXtdVat']).toFixed(nOptDecimalShow);
                        tSumVatTotal += tVatValue;
                        tVatList += '<li class="list-group-item" style="padding-top: 1px;padding-bottom: 1px;"><label class="pull-left">'+ tVatRate + '%</label><label class="pull-right">' + tVatValue + '</label><div class="clearfix"></div></li>';
                    }

                    // ยอดรวมภาษีมูลค่าเพิ่ม
                    var cSumVat     = parseFloat(tSumVatTotal).toFixed(nOptDecimalShow); /*aDataEndBillVat['cVatSum'];*/
                    $('#olbTAXVatSum').text(cSumVat);
                }
                $('#oulTAXDataListVat').html(tVatList);

                //เอาข้อมูล HD มาลง
                var aHD = tHTML['aDetailHD'];
                if(aHD.rtCode == '800'){
                    //ไม่พบข้อมูล
                    $('#oetTAXTypeVat').val('');
                    $('#oetTAXCountPrint').val(0);
                    $('#oetTAXTypepay').val('');
                    $('#oetTAXPos').val('');
                    $('#oetTAXRefIntDoc').val('');
                    $('#oetTAXRefIntDocDate').val('');
                    $('#oetTAXRefExtDoc').val('');
                    $('#oetTAXRefExtDocDate').val('');
                    $('#otaTAXRemark').text('');

                    //ข้อมูลส่วนที่อยู่
                    $('#oetTAXCusNameCusABB').val('');
                    $('#oetTAXNumber').val('');
                    $('#otxAddress1').val('');
                    $('#otxAddress2').val('');
                    $('#oetTAXTel').val('');
                    $('#oetTAXFax').val('');
                    $('#oetTAXBranch').val('');
                    // $('#ocmTAXTypeBusiness option[value=1]').attr('selected','selected');
                    $('#ocmTAXTypeBusiness').selectpicker('val', 1);
                    JSxTAXChangeTypeBusiness();
                    $('#ocmTAXBusiness option[value=1]').attr('selected','selected');
                    $('.selectpicker').selectpicker('refresh');

                    $('#ohdDocBchCode').val('');
                    $('#ohdDocType').val('');

                    $('#obtTAXApvETax').addClass('xCNHide');
                    $('#obtTAXCancleETax').addClass('xCNHide');
                    $('.xWTaxRefAE').hide();

                }else{
                    var tTypeVAT    = aHD.raItems[0].FTXshVATInOrEx //ประเภท
                    var tPrintCount = aHD.raItems[0].FNXshDocPrint //ปริ้น 
                    var tTypePay    = aHD.raItems[0].FTXshCshOrCrd //ชำระโดย
                    var tPoscode    = aHD.raItems[0].FTPosCode //รหัสเครื่องจุดขาย
                    var tRefExt     = (aHD.raItems[0].FTXshRefExt == null ) ? '-' : aHD.raItems[0].FTXshRefExt; //อ้างอิงเอกสารภายนอก
                    var tRefExtDate = (aHD.raItems[0].FDXshRefExtDate == null ) ? '-' : aHD.raItems[0].FDXshRefExtDate; //วันที่เอกสารภายนอก
                    var tRefInt     = (aHD.raItems[0].FTXshRefInt == null ) ? '-' : aHD.raItems[0].FTXshRefInt; //เลขที่ภายใน
                    var tRefIntDate = (aHD.raItems[0].FDXshRefIntDate == null ) ? '-' : aHD.raItems[0].FDXshRefIntDate; //วันภายใน
                    var tRemark     = aHD.raItems[0].FTXshRmk; //หมายเหตุ
                    var tHDCstEmail = aHD.raItems[0].FTXshCstEmail;
                    var tHDCstTel   = aHD.raItems[0].FTXshCstTel;
                    var tStaETax    = aHD.raItems[0].FTXshStaETax;

                    var tDocBchCode = aHD.raItems[0].FTBchCode;
                    var tDocType = (aHD.raItems[0].FNXshDocType == 9 ) ? 'R' : 'S'; //ขาย/คืน
                    // console.log(aHD.raItems[0]);

                    if( aHD.raItems[0].FNXshDocType == 9 ){
                        $('#obtTAXBrowseRsn').attr('disabled',false);
                    }else{
                        $('#obtTAXBrowseRsn').attr('disabled',true);
                    }

                    if(tTypeVAT == 1){ var tTypeVAT = 'รวมใน' }else{ var tTypeVAT = 'แยกนอก' }
                    $('#oetTAXTypeVat').val(tTypeVAT);
                    $('#oetTAXCountPrint').val(tPrintCount);
                    if(tTypePay == 1){ var tTypePay = 'เงินสด' }else{ var tTypePay = 'เครดิต' }
                    $('#oetTAXTypepay').val(tTypePay);
                    $('#oetTAXPos').val(tPoscode);
                    $('#oetTAXRefAE').val('');
                    $('#oetTAXRefIntDoc').val(tRefInt);
                    $('#oetTAXRefIntDocDate').val(tRefIntDate.substr(0, 10));
                    $('#oetTAXRefExtDoc').val(tRefExt);
                    $('#oetTAXRefExtDocDate').val(tRefExtDate.substr(0, 10));
                    $('#otaTAXRemark').text(tRemark);

                    $('#ohdDocBchCode').val(tDocBchCode);
                    $('#ohdDocType').val(tDocType);
                    $("#oetTAXABBTypeDocuement").val(aHD.raItems[0].FNXshDocType);

                    $('#oetTAXTel').val(tHDCstTel);
                    $('#oetTAXEmail').val(tHDCstEmail);

                    $('#oetTXIStaETax').val(tStaETax);
                    
                }

                JCNxCloseLoading();

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
            url     : "dcmTXINLoadAddress",
            data    : { 'tDocumentNumber' : ptDocumentABB , 'tCustomer' : ptCustomer },
            cache   : false,
            Timeout : 0,
            success : function (oResult) {
                var tTAXBrowseCusAddrType   = $('#ohdTAXBrowseCusAddrType').val();
                var aPackData               = JSON.parse(oResult);
                if(aPackData.tStatus == 'null'){
                    console.log('ไม่พบข้อมูลที่อยู่');

                    if( tTAXBrowseCusAddrType == '1' ){
                        $('#oetTAXCusNameCusABB').val('');
                        $('#otxAddress1').val('');
                        $('#otxAddress2').val('');
                        $('#oetTAXTel').val('');
                        $('#oetTAXFax').val('');
                        $('#oetTAXBranch').val('');
                        // $('#ocmTAXTypeBusiness option[value=1]').attr('selected','selected');
                        $('#ocmTAXTypeBusiness').selectpicker('val', 1);
                        JSxTAXChangeTypeBusiness();
                        $('#ocmTAXBusiness option[value=1]').attr('selected','selected');
                        $('.selectpicker').selectpicker('refresh');

                        if(ptCustomer != '' || ptCustomer != null){
                            $('#oetTAXCusNameCusABB').val(ptNameCustomer);/*$('#oetTAXCusName').val(ptNameCustomer);*/
                            $('#oetTAXCusCode').val(ptCustomer);
                        }
                    }else{
                        $('#oetTAXModalCancelCstName').val(ptNameCustomer);
                        $('#oetTAXModalCancelCstCode').val(ptCustomer);
                    }

                }else if(aPackData.tStatus == 'passABB'){
                    console.log('ใช้ที่อยู่ ของ TCNMTaxAddress_L');
                    if( tTAXBrowseCusAddrType == '1' ){
                        $('#obtBrowseAddress').attr('disabled',false);
                    }else{
                        $('#obtTAXModalCancelBrowseAddress').attr('disabled',false);
                    }
                    JSvRanderAddressMoreOne(aPackData.aList,'TaxADD');
                }else if(aPackData.tStatus == 'passCst'){
                    console.log('ใช้ที่อยู่ ของ TCNMCstAddress_L');
                    if( tTAXBrowseCusAddrType == '1' ){
                        $('#obtBrowseAddress').attr('disabled',false);
                    }else{
                        $('#obtTAXModalCancelBrowseAddress').attr('disabled',false);
                    }
                    JSvRanderAddressMoreOne(aPackData.aList,'CstADD');
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

            // console.log(oText[0]['FTCstCode']);
            // return;
            if( ptType == 'CstADD' ){
                oTAXBrowseCstAddrOption = oTAXCstAddrOption({
                    'tCstCode'          : oText[0]['FTCstCode'],
                    'tReturnInputCode'  : 'oetTAXBrowseCstCode',
                    'tReturnInputName'  : 'oetTAXBrowseCstName',
                    'tNextFuncName'     : 'FSvPushDataInforToView',
                    'aArgReturn'        : [
                        'FTCstCode','FTCstName','FTAddTaxNo','FTAddName','FTSudCode','FTSudName','FTDstCode','FTDstName','FTPvnCode','FTPvnName',
                        'FTAddV2Desc1','FTAddV2Desc2','FTAddV1PostCode','FTAddTel','FTAddFax','FTAddStaBusiness','FTAddStaHQ','FTAddStaBchCode'
                    ]
                });
                JCNxBrowseData('oTAXBrowseCstAddrOption');
            }else if( ptType == 'TaxADD' ){
                oTAXBrowseAddrOption = oTAXAddrOption({
                    'tCstCode'          : oText[0]['FTCstCode'],
                    'tReturnInputCode'  : 'oetTAXBrowseCstCode',
                    'tReturnInputName'  : 'oetTAXBrowseCstName',
                    'tNextFuncName'     : 'FSvPushDataInforToView',
                    'aArgReturn'        : [
                        'FTCstCode','FTCstName','FTAddTaxNo','FTAddName','FTSudCode','FTSudName','FTDstCode','FTDstName','FTPvnCode','FTPvnName',
                        'FTAddV2Desc1','FTAddV2Desc2','FTAddV1PostCode','FTAddTel','FTAddFax','FTAddStaBusiness','FTAddStaHQ','FTAddStaBchCode'
                    ]
                });
                JCNxBrowseData('oTAXBrowseAddrOption');
            }

            // $('#odvTAXModalAddressMoreOne').modal('show');
            // $('#odvTAXModalAddressMoreOne .xCNTableAddressMoreOne tbody').html('');
            // for(i=0; i<oText.length; i++){
            //     var aNewReturn  = JSON.stringify(oText[i]);

            //     //ที่อยู่ของลูกค้าที่เคยออกเเล้ว 
            //     if(ptType == 'TaxADD'){
            //         var tName = oText[i].FTAddName;
            //         if(oText[i].FTAddFax == ''){ var tFTAddFax = '-'; }else{ var tFTAddFax = oText[i].FTAddFax; }
            //         if(oText[i].FTAddTel == ''){ var FTAddTel = '-';  }else{ var FTAddTel = oText[i].FTAddTel; }
            //         if(oText[i].FTAddV2Desc2 == ''){ var tFTAddV2Desc2 = '-'; }else{ var tFTAddV2Desc2 = oText[i].FTAddV2Desc2; }
            //         if(oText[i].FTAddV2Desc1 == ''){ var tFTAddV2Desc1 = '-'; }else{ var tFTAddV2Desc1 = oText[i].FTAddV2Desc1; }
            //     }

            //     //ที่อยู่ของลูกค้า
            //     if(ptType == 'CstADD'){
            //         var tName       = oText[i].FTAddName;
            //         var tFTAddFax   = '-'; 
            //         var FTAddTel    = '-'; 
            //         if(oText[i].FTAddV2Desc2 == ''){ var tFTAddV2Desc2 = '-'; }else{ var tFTAddV2Desc2 = oText[i].FTAddV2Desc2; }
            //         if(oText[i].FTAddV2Desc1 == ''){ var tFTAddV2Desc1 = '-'; }else{ var tFTAddV2Desc1 = oText[i].FTAddV2Desc1; }
            //     }

            //     var tClassName = 'xCNColumnAddressMoreOne' + i;
            //     var tHTML = "<tr class='"+tClassName+" xCNColumnAddressMoreOne' data-information='["+aNewReturn+"]' style='cursor: pointer;'>";
            //         tHTML += "<td>"+tName+"</td>";
            //         tHTML += "<td>"+tFTAddV2Desc1+"</td>";
            //         tHTML += "<td>"+tFTAddV2Desc2+"</td>";
            //         tHTML += "<td>"+FTAddTel+"</td>";
            //         tHTML += "<td>"+tFTAddFax+"</td>";
            //         tHTML += "</tr>";
            //     $('#odvTAXModalAddressMoreOne .xCNTableAddressMoreOne tbody').append(tHTML);
            // }

            // //เลือกที่อยู่
            // $('.xCNColumnAddressMoreOne').off();

            // //ดับเบิ้ลคลิก
            // $('.xCNColumnAddressMoreOne').on('dblclick',function(e){
            //     $('#odvTAXModalAddressMoreOne').modal('hide');
            //     var tJSON       = $(this).attr('data-information');
            //     FSvPushDataInforToView(tJSON);
            // });

            // //คลิกได้เลย
            // $('.xCNColumnAddressMoreOne').on('click',function(e){
            //     //เลือกที่อยู่แบบตัวเดียว
            //     $('.xCNColumnAddressMoreOne').removeClass('xCNActiveAddress');
            //     $('.xCNColumnAddressMoreOne').children().attr('style', 'background-color:transparent !important; color:#232C3D !important;');

            //     $(this).addClass('xCNActiveAddress');
            //     $(this).children().attr('style', 'background-color:#179bfd !important; color:#FFF !important;');
            // });
        }else{
            //มีที่อยู่ตัวเดียว
            var aNewReturn  = JSON.stringify(oText);
            FSvPushDataInforToView(aNewReturn);
        }
    }

    var oTAXCstAddrOption = function(poDataFnc){
        var nLangEdits          = '<?=$this->session->userdata("tLangEdit");?>';
        var tInputReturnCode    = poDataFnc.tReturnInputCode;
        var tInputReturnName    = poDataFnc.tReturnInputName;
        var tNextFuncName       = poDataFnc.tNextFuncName;
        var aArgReturn          = poDataFnc.aArgReturn;

        var tCstCode            = poDataFnc.tCstCode;
        var tWhereCondition     = " AND TCNMCstAddress_L.FTCstCode = '"+tCstCode+"' ";
        
        var oOptionReturn       = {
            Title   : ['document/taxinvoice/taxinvoice', 'ที่อยู่ลูกค้า'],
            Table   : { Master:'TCNMCstAddress_L', PK:'FNAddSeqNo' },
            Join    : {
                Table   : [
                    'TCNMCst_L','TCNMCst','TCNMDistrict_L','TCNMSubDistrict_L','TCNMProvince_L'
                ],
                On      : [
                    'TCNMCst_L.FTCstCode = TCNMCstAddress_L.FTCstCode AND TCNMCst_L.FNLngID = '+nLangEdits,
                    'TCNMCst.FTCstCode = TCNMCstAddress_L.FTCstCode',
                    'TCNMDistrict_L.FTDstCode = TCNMCstAddress_L.FTAddV1DstCode AND TCNMDistrict_L.FNLngID = '+nLangEdits,
                    'TCNMSubDistrict_L.FTSudCode = TCNMCstAddress_L.FTAddV1SubDist AND TCNMSubDistrict_L.FNLngID = '+nLangEdits,
                    'TCNMProvince_L.FTPvnCode = TCNMCstAddress_L.FTAddV1PvnCode AND TCNMProvince_L.FNLngID = '+nLangEdits,
                ]
            },
            Where:{
                Condition : [ tWhereCondition ]
            },
            GrideView:{
                ColumnPathLang      : 'document/taxinvoice/taxinvoice',
                ColumnKeyLang       : [
                    'ชื่อลูกค้า / ชื่อออกใบกำกับภาษี', 'ที่อยู่ 1 สำหรับออกใบกำกับภาษี','ที่อยู่ 2 สำหรับออกใบกำกับภาษี (ที่อยู่เพิ่มเติม)',
                    'เบอร์โทรศัพท์','เบอร์แฟ็กซ์'
                ],
                ColumnsSize         : ['15%','32%','32%','10%','10%'],
                WidthModal          : 70,
                DataColumns         : [
                    'TCNMCstAddress_L.FTAddName','TCNMCstAddress_L.FTAddV2Desc1','TCNMCstAddress_L.FTAddV2Desc2','TCNMCstAddress_L.FTAddTel','TCNMCstAddress_L.FTAddFax',
                    
                    'TCNMCstAddress_L.FTCstCode','TCNMCst_L.FTCstName',
                    'TCNMCstAddress_L.FTAddV1SubDist AS FTSudCode','TCNMSubDistrict_L.FTSudName',
                    'TCNMCstAddress_L.FTAddV1DstCode AS FTDstCode','TCNMDistrict_L.FTDstName',
                    'TCNMCstAddress_L.FTAddV1PvnCode AS FTPvnCode','TCNMProvince_L.FTPvnName',
                    'TCNMCstAddress_L.FTAddV1PostCode','TCNMCst.FTCstTaxNo AS FTAddTaxNo',
                    'NULL AS FTAddStaBusiness','NULL AS FTAddStaHQ','NULL AS FTAddStaBchCode',
                    'TCNMCstAddress_L.FNAddSeqNo'
                ],
                DisabledColumns     : [5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20],
                // DataColumnsFormat   : ['','','','','',''],
                Perpage             : 10,
                OrderBy             : ['TCNMCstAddress_L.FDCreateOn DESC']
            },
            CallBack:{
                ReturnType  : 'S',
                Value       : [tInputReturnCode, "TCNMCstAddress_L.FTCstCode"],
                Text        : [tInputReturnName, "TCNMCstAddress_L.FTAddName"]
            },
            NextFunc:{
                FuncName    : tNextFuncName,
                ArgReturn   : aArgReturn
            },
            // DebugSQL: true
        };
        return oOptionReturn;
    }

    var oTAXAddrOption = function(poDataFnc){
        var nLangEdits          = '<?=$this->session->userdata("tLangEdit");?>';
        var tInputReturnCode    = poDataFnc.tReturnInputCode;
        var tInputReturnName    = poDataFnc.tReturnInputName;
        var tNextFuncName       = poDataFnc.tNextFuncName;
        var aArgReturn          = poDataFnc.aArgReturn;

        var tCstCode            = poDataFnc.tCstCode;
        var tWhereCondition     = " AND TCNMTaxAddress_L.FTCstCode = '"+tCstCode+"' ";
        
        var oOptionReturn       = {
            Title   : ['document/taxinvoice/taxinvoice', 'ที่อยู่ลูกค้า'],
            Table   : { Master:'TCNMTaxAddress_L', PK:'FTAddTaxNo' },
            Join    : {
                Table   : [
                    'TCNMCst_L','TCNMCst','TCNMDistrict_L','TCNMSubDistrict_L','TCNMProvince_L'
                ],
                On      : [
                    'TCNMCst_L.FTCstCode = TCNMTaxAddress_L.FTCstCode AND TCNMCst_L.FNLngID = '+nLangEdits,
                    'TCNMCst.FTCstCode = TCNMTaxAddress_L.FTCstCode',
                    'TCNMDistrict_L.FTDstCode = TCNMTaxAddress_L.FTAddV1DstCode AND TCNMDistrict_L.FNLngID = '+nLangEdits,
                    'TCNMSubDistrict_L.FTSudCode = TCNMTaxAddress_L.FTAddV1SubDist AND TCNMSubDistrict_L.FNLngID = '+nLangEdits,
                    'TCNMProvince_L.FTPvnCode = TCNMTaxAddress_L.FTAddV1PvnCode AND TCNMProvince_L.FNLngID = '+nLangEdits,
                ]
            },
            Where:{
                Condition : [ tWhereCondition ]
            },
            GrideView:{
                ColumnPathLang      : 'document/taxinvoice/taxinvoice',
                ColumnKeyLang       : [
                    'ชื่อลูกค้า / ชื่อออกใบกำกับภาษี', 'ที่อยู่ 1 สำหรับออกใบกำกับภาษี','ที่อยู่ 2 สำหรับออกใบกำกับภาษี (ที่อยู่เพิ่มเติม)',
                    'เบอร์โทรศัพท์','เบอร์แฟ็กซ์'
                ],
                ColumnsSize         : ['15%','32%','32%','10%','10%'],
                WidthModal          : 70,
                DataColumns         : [
                    'TCNMTaxAddress_L.FTAddName','TCNMTaxAddress_L.FTAddV2Desc1','TCNMTaxAddress_L.FTAddV2Desc2','TCNMTaxAddress_L.FTAddTel','TCNMTaxAddress_L.FTAddFax',
                    
                    'TCNMTaxAddress_L.FTCstCode','TCNMCst_L.FTCstName',
                    'TCNMTaxAddress_L.FTAddV1SubDist AS FTSudCode','TCNMSubDistrict_L.FTSudName',
                    'TCNMTaxAddress_L.FTAddV1DstCode AS FTDstCode','TCNMDistrict_L.FTDstName',
                    'TCNMTaxAddress_L.FTAddV1PvnCode AS FTPvnCode','TCNMProvince_L.FTPvnName',
                    'TCNMTaxAddress_L.FTAddV1PostCode','TCNMTaxAddress_L.FTAddTaxNo',
                    'TCNMTaxAddress_L.FTAddStaBusiness','TCNMTaxAddress_L.FTAddStaHQ','TCNMTaxAddress_L.FTAddStaBchCode'
                ],
                DisabledColumns     : [5,6,7,8,9,10,11,12,13,14,15,16,17,18,19],
                // DataColumnsFormat   : ['','','','','',''],
                Perpage             : 10,
                OrderBy             : ['TCNMTaxAddress_L.FDCreateOn DESC']
            },
            CallBack:{
                ReturnType  : 'S',
                Value       : [tInputReturnCode, "TCNMTaxAddress_L.FTCstCode"],
                Text        : [tInputReturnName, "TCNMTaxAddress_L.FTAddName"]
            },
            NextFunc:{
                FuncName    : tNextFuncName,
                ArgReturn   : aArgReturn
            },
            // DebugSQL: true
        };
        return oOptionReturn;
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

            var tTAXBrowseCusAddrType   = $('#ohdTAXBrowseCusAddrType').val();
            var oAddress                = JSON.parse(ptAddress);

            console.log(oAddress);
            console.log(oAddress.length);

            if( oAddress.length > 2 ){                          // กรณีพบที่อยู่มากกว่า 1 และเลือกมาจาก Browse
                var FTCstCode = oAddress[0];
                var FTCstName = oAddress[1];
                var FTAddTaxNo = oAddress[2];
                var FTAddName = oAddress[3];
                var FTSudCode = oAddress[4];
                var FTSudName = oAddress[5];
                var FTDstCode = oAddress[6];
                var FTDstName = oAddress[7];
                var FTPvnCode = oAddress[8];
                var FTPvnName = oAddress[9];
                var FTAddV2Desc1 = oAddress[10];
                var FTAddV2Desc2 = oAddress[11];
                var FTAddV1PostCode = oAddress[12];
                var FTAddTel = oAddress[13];
                var FTAddFax = oAddress[14];
                var FTAddStaBusiness = oAddress[15];
                var FTAddStaHQ = oAddress[16];
                var FTAddStaBchCode = oAddress[17];
            }else{                                              // กรณีรายการเดียว
                var FTCstCode = oAddress[0]['FTCstCode'];
                var FTCstName = oAddress[0]['FTCstName'];
                var FTAddTaxNo = oAddress[0]['FTAddTaxNo'];
                var FTAddName = oAddress[0]['FTAddName'];
                var FTSudCode = oAddress[0]['FTSudCode'];
                var FTSudName = oAddress[0]['FTSudName'];
                var FTDstCode = oAddress[0]['FTDstCode'];
                var FTDstName = oAddress[0]['FTDstName'];
                var FTPvnCode = oAddress[0]['FTPvnCode'];
                var FTPvnName = oAddress[0]['FTPvnName'];
                var FTAddV2Desc1 = oAddress[0]['FTAddV2Desc1'];
                var FTAddV2Desc2 = oAddress[0]['FTAddV2Desc2'];
                var FTAddV1PostCode = oAddress[0]['FTAddV1PostCode'];
                var FTAddTel = oAddress[0]['FTAddTel'];
                var FTAddFax = oAddress[0]['FTAddFax'];
                var FTAddStaBusiness = oAddress[0]['FTAddStaBusiness'];
                var FTAddStaHQ = oAddress[0]['FTAddStaHQ'];
                var FTAddStaBchCode = oAddress[0]['FTAddStaBchCode'];
            }

            // console.log(oAddress);
            // return;

            // var oAddress        = oAddress[0];
            // var tCustomerName   = oAddress.FTCstName;
            // var tAddressName    = oAddress.FTAddName;
            // var tAddressCode    = oAddress.FTCstCode;

            if( tTAXBrowseCusAddrType == '1' ){

                $('#oetFTAddV1SubDistCode').val(FTSudCode);
                $('#oetFTAddV1SubDistName').val(FTSudName);
                $('#oetFTAddV1DstCode').val(FTDstCode);
                $('#oetFTAddV1DstName').val(FTDstName);
                $('#oetFTAddV1PvnCode').val(FTPvnCode);
                $('#oetFTAddV1PvnName').val(FTPvnName);
                $('#oetFTAddV1PostCode').val(FTAddV1PostCode);

                $('#otxAddress1').val(FTAddV2Desc1);
                $('#otxAddress2').val(FTAddV2Desc2);


                // var tAddressTel     = oAddress.FTAddTel;
                // var tAddressTaxNo   = oAddress.FTAddTaxNo;
                // var tAddressFax     = oAddress.FTAddFax;

                // if(tCustomerName == '' || tAddressCode == '' || tAddressCode == null || tCustomerName == null ){

                // }else{
                //     $('#oetTAXCusName').val(tCustomerName);
                //     $('#oetTAXCusCode').val(tAddressCode);
                // }

                $('#oetTAXCusCode').val(FTCstCode);
                $('#oetTAXCusNameCusABB').val(FTAddName);
                $('#oetTAXNumber').val(FTAddTaxNo);
                $('#oetTAXTel').val(FTAddTel);
                $('#oetTAXFax').val(FTAddFax);

                //ประเภทกิจการ
                // var tBusiness = FTAddStaBusiness;
                if( FTAddStaBusiness == "" || FTAddStaBusiness == null ){
                    FTAddStaBusiness = '1';
                }

                $('#ocmTAXTypeBusiness').selectpicker('val', FTAddStaBusiness);
                JSxTAXChangeTypeBusiness();

                //สถานประกอบการ
                var tStaHQ = '2'; 
                if( FTAddStaHQ == '1' ){
                    tStaHQ = '1';
                }
                $('#ocmTAXBusiness option[value='+tStaHQ+']').attr('selected','selected');

                //รหัสสาขา
                // var tBCHCode = oAddress.FTAddStaBchCode;
                $('#oetTAXBranch').val(FTAddStaBchCode);
                $('.selectpicker').selectpicker('refresh');

                // $('#ohdSeqAddress').val(oAddress.FNAddSeqNo);
            }else{
                $('#oetTAXModalCancelSubDistCode').val(FTSudCode);
                $('#oetTAXModalCancelSubDistName').val(FTSudName);
                $('#oetTAXModalCancelDstCode').val(FTDstCode);
                $('#oetTAXModalCancelDstName').val(FTDstName);
                $('#oetTAXModalCancelPvnCode').val(FTPvnCode);
                $('#oetTAXModalCancelPvnName').val(FTPvnName);
                $('#oetTAXModalCancelPostCode').val(FTAddV1PostCode);

                $('#otxTAXModalCancelAddress1').val(FTAddV2Desc1);
                $('#otxTAXModalCancelAddress2').val(FTAddV2Desc2);

                $('#oetTAXModalCancelCstName').val(FTAddName);
                $('#oetTAXModalCancelCstCode').val(FTCstCode);

                $('#odvTAXModalCancelETax').modal('show');
            }

            JCNxCloseLoading();
        }else{
            JCNxShowMsgSessionExpired();
        }
    }   

    /********************************************************************************************/// ส า ข า

    $('#obtBrowseBCH').click(function(){ JCNxBrowseData('oBrowse_BCH'); });
    var nLangEdits 	= <?php echo $this->session->userdata("tLangEdit"); ?>;
    var tUsrLevel = "<?=$this->session->userdata('tSesUsrLevel')?>";
    var tBchMulti = "<?=$this->session->userdata("tSesUsrBchCodeMulti"); ?>";
    var tSQLWhere = "";
            if(tUsrLevel != "HQ"){
                tSQLWhere = " AND TCNMBranch.FTBchCode IN ("+tBchMulti+") ";
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
        Where : {
                    Condition : [tSQLWhere]
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
        $('#ohdTAXBrowseCusAddrType').val('1');
        oSOBrowseCstOption      = oCstOption({
            'tReturnInputCode'  : 'oetTAXCusCode',
            'tReturnInputName'  : 'oetTAXCusNameCusABB',
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
            Title   : ['document/taxinvoice/taxinvoice', 'tTAXCustomer'],
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
                ColumnPathLang      : 'document/taxinvoice/taxinvoice',
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
        var tTAXBrowseCusAddrType   = $('#ohdTAXBrowseCusAddrType').val();
        var tData                   = JSON.parse(ptParam);
        var tDocumentABB            = $('#oetTAXABBCode').val();
        var tCustomer               = tData[0];
        var tTaxno                  = tData[1];
        var tCardID                 = tData[2];
        var tNameCustomer           = tData[3];

        if( tTAXBrowseCusAddrType == '1' ){
            if(ptParam == 'NULL'){
                $('#obtBrowseAddress').attr('disabled',true);
                return;
            }else{
                $('#obtBrowseAddress').attr('disabled',false);
            }

            if(tTaxno == '' || tTaxno == null){
                $('#oetTAXNumber').val(tCardID);
            }else{
                $('#oetTAXNumber').val(tTaxno);
            }
        }else{
            if(ptParam == 'NULL'){
                $('#obtTAXModalCancelBrowseAddress').attr('disabled',true);
                return;
            }else{
                $('#obtTAXModalCancelBrowseAddress').attr('disabled',false);
            }
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
    function JCNxSearchBrowseSelectAddressCustomer(pnType){
        // var tSearchAddress  = $('#oetTextCustomerAddress').val();
        // var nPage           = pnPage;
        
        $('#ohdTAXBrowseCusAddrType').val(pnType);

        if( pnType == 2 ){
            var tCustomerCode   = $('#oetTAXModalCancelCstCode').val();
        }else{
            var tCustomerCode   = $('#oetTAXCusCode').val();
        }

        oTAXBrowseCstAddrOption = oTAXCstAddrOption({
            'tCstCode'          : tCustomerCode,
            'tReturnInputCode'  : 'oetTAXBrowseCstCode',
            'tReturnInputName'  : 'oetTAXBrowseCstName',
            'tNextFuncName'     : 'FSvPushDataInforToView',
            'aArgReturn'        : [
                'FTCstCode','FTCstName','FTAddTaxNo','FTAddName','FTSudCode','FTSudName','FTDstCode','FTDstName','FTPvnCode','FTPvnName',
                'FTAddV2Desc1','FTAddV2Desc2','FTAddV1PostCode','FTAddTel','FTAddFax','FTAddStaBusiness','FTAddStaHQ','FTAddStaBchCode'
            ]
        });
        JCNxBrowseData('oTAXBrowseCstAddrOption');

        // $.ajax({
        //     type    : "POST",
        //     url     : "dcmTXINLoadDatatableCustomerAddress",
        //     data    : { 'tSearchAddress' : tSearchAddress , 'nPage' : nPage , 'tCustomerCode' : tCustomerCode },
        //     cache   : false,
        //     Timeout : 0,
        //     success : function (oResult) {
        //         var tHTML = JSON.parse(oResult);
        //         $('#odvContentSelectCustomerAddress').html(tHTML['tTableCustomerAddressHtml']);
        //         JCNxCloseLoading();
        //     },
        //     error: function (jqXHR, textStatus, errorThrown) {
        //         JCNxResponseError(jqXHR, textStatus, errorThrown);
        //     }
        // });
    }

    //เลือก
    function JSxSelectCustomerAddress(){
        var tCustomercode       = $('#otbSelectCustomerAddress tbody tr.xCNActive').attr('data-cstcode');
        var tSeqno              = $('#otbSelectCustomerAddress tbody tr.xCNActive').attr('data-seqno');

        $.ajax({
            type    : "POST",
            url     : "dcmTXINCustomerAddress",
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
            url     : "dcmTXINCheckTaxNO",
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
            url     : "dcmTXINLoadDatatableTaxNO",
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
            url     : "dcmTXINCheckTaxNO",
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
        $('.xCNCreate a').text('<?=language('document/taxinvoice/taxinvoice', 'tTAXPreview');?>');

        //เปิดปุ่มอนุมัติ + ปุ่มตรวจสอบ
        $('#obtCancleDocument').addClass('xCNHide');
        $('#obtApproveDocument').addClass('xCNHide');
        
        $('#obtPrintPreviewDocumentABB').removeClass('xCNHide');
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
        $('#otaTAXRemark').attr('disabled',true);

        $('#obtBrowseBCH').attr('disabled',true);
    }

    //Rander Preview
    function JSxRanderHDDTPreview(){
        var tDocumentNumber = '<?=$tDocumentNumber?>';
        var tBrowseBchCode = '<?=$tDocumentBchCode?>';
        $.ajax({
            type    : "POST",
            url     : "dcmTXINLoadDatatableTax",
            data    : { 'tDocumentNumber' : tDocumentNumber , 'tBrowseBchCode':tBrowseBchCode },
            cache   : false,
            Timeout : 0,
            success : function (oResult) {
                var tHTML = JSON.parse(oResult);

                $('#odvContentSumFooterTAX').html(tHTML['tContentSumFooter']);

                // console.log(tHTML.aDataDocRC);

                //HD
                var aHD             = tHTML.aDetailHD;
                var aHD             = aHD.raItems[0];
                let aDataDisPro     = tHTML.aDataDisPro;
                let aDataEndBillVat = tHTML.aDataEndBillVat;
                let aDataDocRC      = tHTML.aDataDocRC;
                let nOptDecimalShow = '<?=FCNxHGetOptionDecimalShow()?>';
                // console.log(aDataEndBillVat);

                // ข้อมูลการชำระเงิน
                // รายการข้อมูลการชำระเงิน
                if( aDataDocRC['tCode'] == '1' ){
                    let tRCRender = '';
                    let cRcSum    = 0;
                    for(let i = 0; i < aDataDocRC['aItems'].length; i++){
                        cRcSum += parseFloat(aDataDocRC['aItems'][i]['FCXrcNet']);
                        tRCRender += '<li class="list-group-item" style="padding-top: 1px;padding-bottom: 1px;">';
                        tRCRender += '    <label class="pull-left">';
                        tRCRender += '      <div>('+aDataDocRC['aItems'][i]['FTRcvCode']+') '+aDataDocRC['aItems'][i]['FTRcvName']+'</div>';
                        if( aDataDocRC['aItems'][i]['FTXrcRefNo1'] != "" ){
                            tRCRender += '  <div style="padding-left: 32px;">'+aDataDocRC['aItems'][i]['FTXrcRefNo1']+'</div>';
                        }
                        tRCRender += '    </label>';
                        tRCRender += '    <label class="pull-right">'+accounting.formatNumber(aDataDocRC['aItems'][i]['FCXrcNet'], nOptDecimalShow, ',')+'</label>';
                        tRCRender += '    <div class="clearfix"></div>';
                        tRCRender += '</li>';
                    }
                    $('#oulTAXDataListPayment').html(tRCRender);
                    $('#olbTAXPaymentSum').html(accounting.formatNumber(cRcSum, nOptDecimalShow, ','));
                }

                //รายการส่วนลดโปรโมชั่น
                if( aDataDisPro['tCode'] == '1' ){
                    let aDisProItems    = aDataDisPro['aItems'];
                    let tDisProList     = "";
                    if( aDisProItems.length > 0 ){
                        for(let i = 0; i < aDisProItems.length; i++){
                            let tDisProValue = parseFloat(aDisProItems[i]['FCXddValue']).toFixed(nOptDecimalShow) == 0 ? '0.00' : parseFloat(aDisProItems[i]['FCXddValue']).toFixed(nOptDecimalShow);
                            tDisProList += '<li class="list-group-item" style="padding-top: 1px;padding-bottom: 1px;"><label class="pull-left">'+ aDisProItems[i]['FTPmhName'] + '</label><label class="pull-right">' + tDisProValue + '</label><div class="clearfix"></div></li>';
                        }
                        
                        $('#oulTAXDataListPromotions').html(tDisProList);

                        // ยอดรวมภาษีมูลค่าเพิ่ม
                        let cDisProSumValue = parseFloat(aDisProItems[0]['FCXddSumValue']).toFixed(nOptDecimalShow);
                        $('#olbTAXPromotionsSum').text(cDisProSumValue);
                        
                    }
                }

                // รายการ vat
                var aVatItems   = aDataEndBillVat['aItems'];
                var tVatList    = "";
                if(aVatItems.length > 0){
                    let tSumVatTotal = 0;
                    for(var i = 0; i < aVatItems.length; i++){
                        var tVatRate    = parseFloat(aVatItems[i]['FCXtdVatRate']).toFixed(0);
                        // var tSumVat = parseFloat(aVatItems[i]['FCXtdVat']).toFixed(0) == 0 ? '0.00' : parseFloat(aVatItems[i]['FCXtdVat']).toFixed(2);
                        var tVatValue   = parseFloat(aVatItems[i]['FCXtdVat']).toFixed(nOptDecimalShow) == 0 ? '0.00' : parseFloat(aVatItems[i]['FCXtdVat']).toFixed(nOptDecimalShow);
                        tSumVatTotal += tVatValue;
                        tVatList += '<li class="list-group-item" style="padding-top: 1px;padding-bottom: 1px;"><label class="pull-left">'+ tVatRate + '%</label><label class="pull-right">' + tVatValue + '</label><div class="clearfix"></div></li>';
                    }

                    // ยอดรวมภาษีมูลค่าเพิ่ม
                    var cSumVat     = parseFloat(tSumVatTotal).toFixed(nOptDecimalShow); /*aDataEndBillVat['cVatSum'];*/
                    $('#olbTAXVatSum').text(cSumVat);
                }
                $('#oulTAXDataListVat').html(tVatList);
                
                

                // console.log( aHD.FNXshDocType );
                var tXshStaETax = ( aHD.FTXshStaETax == "" ? '2' : aHD.FTXshStaETax );
                // console.log(tXshStaETax);

                switch(tXshStaETax){
                    case '1':
                        $('.xWETaxDisabled').attr('disabled',true);
                        $('#obtSaveDocument').addClass('xCNHide');
                        $('#obtPrintPreviewDocument').addClass('xCNHide');

                        var nXshDocType = aHD.FNXshDocType;
                        if( nXshDocType == 4 ){
                            var tFullTaxBtnText = '<?=language('document/taxinvoice/taxinvoice', 'tTAXDownloadFullTax'); ?>';
                            var tABBBtnText     = '<?=language('document/taxinvoice/taxinvoice', 'tTAXDownloadABB'); ?>';
                        }else{
                            var tFullTaxBtnText = '<?=language('document/taxinvoice/taxinvoice', 'tTAXDownloadCNFullTax'); ?>';
                            var tABBBtnText     = '<?=language('document/taxinvoice/taxinvoice', 'tTAXDownloadCNABB'); ?>';
                        }

                        var tStaRcv         = '1';
                        var tXshStaApv = aHD.FTXshStaApv;
                        if( tXshStaApv == '1' ){
                            $('#olbStatusDocument').text('อนุมัติแล้ว');
                            $('#obtApproveDocument').addClass('xCNHide');
                        }else{
                            $('#olbStatusDocument').text('รออนุมัติ');
                        }

                        var tXshETaxStatus = aHD.FTXshETaxStatus;
                        if( tXshETaxStatus == '1' ){
                            $('#obtPrintPreviewDocumentABB').removeClass('xCNHide');        // SHOW download abb
                            $('#obtPrintDocument').removeClass('xCNHide');                  // SHOW download full tax
                            $('#obtTAXApvETax').addClass('xCNHide');                        // HIDE apv e-tax
                        }else if( tXshETaxStatus == '2' ){
                            if( nXshDocType == 4 ){                                         // SHOW apv download
                                var tFullTaxBtnText = '<?=language('document/taxinvoice/taxinvoice', 'ตรวจสอบใบเต็มรูปอีกครั้ง'); ?>';
                            }else{
                                var tFullTaxBtnText = '<?=language('document/taxinvoice/taxinvoice', 'ตรวจสอบใบลดหนี้อีกครั้ง'); ?>';
                            }
                            $('#obtTAXApvETax').addClass('xCNHide');                        // HIDE apv e-tax
                        }else{
                            $('#obtPrintPreviewDocumentABB').addClass('xCNHide');           // HIDE download abb
                            $('#obtPrintDocument').addClass('xCNHide');                     // HIDE download full tax
                            $('#obtTAXApvETax').removeClass('xCNHide');                     // SHOW apv e-tax
                            $('.xWETaxEnabledOniNetError').attr('disabled',false);           // Enabled Input Address
                        }

                        var tXshStaDoc = aHD.FTXshStaDoc;
                        if( tXshETaxStatus == '1' ){
                            // เปิด/ปิด ปุ่มยกเลิกเอกสาร
                            if( tXshStaDoc == '1' || tXshStaDoc == '4' ){
                                $('#obtTAXCancleETax').removeClass('xCNHide');
                            }else{
                                $('#obtTAXCancleETax').addClass('xCNHide');
                            }
                        }else{
                            $('#obtTAXCancleETax').addClass('xCNHide');
                        }

                        // เปิด/ปิด Input เอกสารอ้างอิงต้นฉบับ
                        if( tXshStaDoc != '3' && tXshStaDoc != '4' ){
                            $('.xWTaxRefAE').hide();
                        }else{
                            $('.xWTaxRefAE').show();
                        }

                        

                        break;
                    default:
                        var tFullTaxBtnText = '<?=language('document/taxinvoice/taxinvoice', 'tTAXPrint'); ?>';
                        var tABBBtnText     = '<?=language('document/taxinvoice/taxinvoice', 'tTAXPrintABB'); ?>';
                        var tStaRcv         = '2';
                        $('#olbStatusDocument').text('อนุมัติแล้ว');
                }

                $('#ohdTAXStaDoc').val(aHD.FTXshStaDoc);
                $('#oetTXIStaETax').val(aHD.FTXshStaETax);
                // $('#oetTXIStaETax').selectpicker('refresh');

                $('#obtPrintPreviewDocumentABB').text(tABBBtnText);
                $('#obtPrintPreviewDocumentABB').attr('data-staetax',tStaRcv);

                $('#obtPrintDocument').text(tFullTaxBtnText);
                $('#obtPrintDocument').attr('data-staetax',tStaRcv);

                var tDocTime    = aHD.FDXshDocDate;
                var aSplitTime  = tDocTime.split(" ");
                $('#oetTAXDocDate').val(aSplitTime[0]);
                $('#oetTAXDocTime').val(aSplitTime[1]);
                $('#oetTAXABBCode').val(aHD.FTXshRefExt);
                $('#oetTAXCusName').val('');
                $('#oetTAXCusCode').val('');
                $('#otaTAXRemark').text('');

                // console.log(aHD);
                
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
                $('#oetTAXRefAE').val(aHD.FTXshRefAE);
                $('#oetTAXRefIntDoc').val(tRefInt);
                $('#oetTAXRefIntDocDate').val(tRefIntDate.substr(0, 10));
                $('#oetTAXRefExtDoc').val(tRefExt);
                $('#oetTAXRefExtDocDate').val(tRefExtDate.substr(0, 10));
                $('#otaTAXRemark').text(tRemark);
                $('#oetTAXDocNo').val(FTXshDocNo);
                $('#olbCreateDocument').text(aHD.FTCreateName);
                $('#oetTAXABBCode').val(aHD.FTXshRefExt);
                $('#ohdBCHDocument').val(aHD.FTBchCode);
                $('#oetTAXRsnName').val(aHD.FTRsnName);
                $('#oetTAXRsnCode').val(aHD.FTRsnCode);
                $('#oetBrowseBchCode').val(aHD.FTBchCode);
                // console.log(aHD);

                //ประเภทของเอกสาร
                $('#oetTAXABBTypeDocuement').val(aHD.FNXshDocType);

                //ที่อยู่
                if(tHTML.aDetailAddress != false){
                    var aAddresss = tHTML.aDetailAddress[0];
                    // console.log(aAddresss);
                    $('#oetTAXCusName').val(aAddresss.FTXshCstName);
                    $('#ohdSeqInTableAddress').val(aAddresss.FNAddSeqNo);
                    $('#ohdSeqAddress').val(aAddresss.FNAddSeqNo);
                    $('#oetTAXCusCode').val(aAddresss.FTXshCstCode);
                    $('#oetTAXCusNameCusABB').val(aAddresss.FTXshCstName);
                    $('#oetTAXNumber').val(aAddresss.FTXshAddrTax);
                    $('#oetTAXNumberNew').val(aAddresss.FTXshAddrTax);
                    if( aAddresss.FTAddStaBusiness == "" || aAddresss.FTAddStaBusiness == null ){
                        aAddresss.FTAddStaBusiness = '1';
                    }
                    // $('#ocmTAXTypeBusiness option[value='+aAddresss.FTAddStaBusiness+']').attr('selected','selected');
                    $('#ocmTAXTypeBusiness').selectpicker('val', aAddresss.FTAddStaBusiness);
                    JSxTAXChangeTypeBusiness();
                    var tAddStaHQ = '2'; 
                    if( aAddresss.FTAddStaHQ == '1' ){
                        tAddStaHQ = '1';
                    }
                    $('#ocmTAXBusiness option[value='+tAddStaHQ+']').attr('selected','selected');
                    $('.selectpicker').selectpicker('refresh');
                    $('#oetTAXBranch').val(aAddresss.FTAddStaBchCode);
                    $('#oetTAXTel').val(aAddresss.FTXshCstTel);
                    $('#oetTAXFax').val(aAddresss.FTXshFax);
                    $('#oetTAXEmail').val(aAddresss.FTXshCstEmail);

                    // if( aAddresss.FTAddVersion = '1' ){
                        // $("#orbTAXAddVersion1").prop("checked", true);
                        // $('#odvTAXAddress1').show();
                        // $('#odvTAXAddress2').hide();

                        // $('#oetFTAddV1No').val(aAddresss.FTAddV1No);
                        // $('#oetFTAddV1Soi').val(aAddresss.FTAddV1Soi);
                        // $('#oetFTAddV1Village').val(aAddresss.FTAddV1Village);
                        // $('#oetFTAddV1Road').val(aAddresss.FTAddV1Road);
                        $('#oetFTAddV1SubDistCode').val(aAddresss.FTSudCode);
                        $('#oetFTAddV1SubDistName').val(aAddresss.FTSudName);
                        $('#oetFTAddV1DstCode').val(aAddresss.FTDstCode);
                        $('#oetFTAddV1DstName').val(aAddresss.FTDstName);
                        $('#oetFTAddV1PvnCode').val(aAddresss.FTPvnCode);
                        $('#oetFTAddV1PvnName').val(aAddresss.FTPvnName);
                        $('#oetFTAddV1PostCode').val(aAddresss.FTXshPostCode);

                        // JSxTAXClearInputAddr('2');

                    // }else{
                        // $("#orbTAXAddVersion2").prop("checked", true);
                        // $('#odvTAXAddress2').show();
                        // $('#odvTAXAddress1').hide();

                        $('#otxAddress1').text(aAddresss.FTXshDesc1);
                        $('#otxAddress2').text(aAddresss.FTXshDesc2);

                        // JSxTAXClearInputAddr('1');

                    // }

                    // ถ้าเป็นประเภท E-Tax จะกรอกได้เฉพาะที่อยู่แยก
                    // var tStaETax = $('#oetTXIStaETax').val();
                    // if( tStaETax == '1' ){
                    //     $("#orbTAXAddVersion1").prop("checked", true);
                    //     $('.xWTAxAddVersion').attr('disabled',true);
                    //     $('#odvTAXAddress1').show();
                    //     $('#odvTAXAddress2').hide();
                    // }

                    // Modal Cancel Tax
                    $('#oetFTAddV1SubDistCode').val(aAddresss.FTSudCode);
                    $('#oetFTAddV1SubDistName').val(aAddresss.FTSudName);
                    $('#oetFTAddV1DstCode').val(aAddresss.FTDstCode);
                    $('#oetFTAddV1DstName').val(aAddresss.FTDstName);
                    $('#oetFTAddV1PvnCode').val(aAddresss.FTPvnCode);
                    $('#oetFTAddV1PvnName').val(aAddresss.FTPvnName);
                    $('#oetFTAddV1PostCode').val(aAddresss.FTXshPostCode);
                    $('#otxAddress1').text(aAddresss.FTXshDesc1);
                    $('#otxAddress2').text(aAddresss.FTXshDesc2);

                    
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
            url     : "dcmTXINLoadDatatableDTTax",
            data    : { 'tDocumentNumber' : tDocumentNumber , 'tBrowseBchCode':tBrowseBchCode, 'tSearchPDT' : tSearchPDT , 'nPage' : pnPage },
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
        $('.xCNSelectTaxABB').removeClass('col-lg-9').addClass('col-lg-12');
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
        var tCstName        = $('#oetTAXCusNameCusABB').val()/*$('#oetTAXCusName').val()*/;

        $.ajax({
            type    : "POST",
            url     : "dcmTXINUpdateWhenApprove",
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

    $('#obtPrintPreviewDocumentABB').off('click').on('click',function(){
    
        var oPackData = JSON.stringify({
            ptType      : 'ABB',
            ptStaETax   : $(this).attr('data-staetax')
        });

        var tTAXStaDoc = $('#ohdTAXStaDoc').val();
        if( tTAXStaDoc == '3' || tTAXStaDoc == '5' ){
            FSvCMNSetMsgWarningDialog('เอกสารใบกำกับภาษีฉบับนี้ได้ถูกยกเลิกแล้ว ต้องการดาวน์โหลดเอกสารใบกำกับภาษี','JSxTAXPrintOrDownload','',oPackData);
        }else{
            JSxTAXPrintOrDownload(oPackData);
        }
    });

    function JSxTAXPrintOrDownload(oPackData){

        var aPackData = JSON.parse(oPackData);
        var tStaETax  = aPackData['ptStaETax'];
        var tType     = aPackData['ptType'];

        if( tType == 'ABB' ){
            switch(tStaETax){
                case '1':
                    JSxTaxDownloadETax('ABB');
                    break;
                default:
                    JSxTaxPrintPreviewDocABB();
            }
        }else{
            switch(tStaETax){
                case '1':
                    JSxTaxDownloadETax('FullTax');
                    break;
                default:
                    JSxTaxPrintDoc();
            }
        }
    }

    function JSxTaxDownloadETax(ptTypeTax){
        JCNxOpenLoading();

        if( ptTypeTax == 'ABB' ){
            tTaxDocNo = $('#oetTAXABBCode').val();
        }else{
            tTaxDocNo = $('#oetTAXDocNo').val();
        }

        $.ajax({
            type: "POST",
            url: "cenEventCallApiETAX",
            data: {
                ptTaxDocNo : tTaxDocNo,
                ptTaxType  : ptTypeTax
            },
            cache: false,
            timeout: 0,
            success: function(oResult) {
                var aReturnData = JSON.parse(oResult);
                var tDocType = $('#oetTAXABBTypeDocuement').val();

                if ( aReturnData['tReturnCode'] == '1' ) {

                    if( ptTypeTax == 'ABB' ){
                        var tPDFURL         = aReturnData['tReturnData']['urlPdf'];
                        if( tDocType == '4' ){
                            var tABBBtnText     = '<?=language('document/taxinvoice/taxinvoice', 'tTAXDownloadABB'); ?>';
                        }else{
                            var tABBBtnText     = '<?=language('document/taxinvoice/taxinvoice', 'tTAXDownloadCNABB'); ?>';
                        }
                    }else{
                        var tPDFURL         = aReturnData['tReturnData']['pdfURL'];
                        if( tDocType == '4' ){
                            var tFullTaxBtnText = '<?=language('document/taxinvoice/taxinvoice', 'tTAXDownloadFullTax'); ?>';
                        }else{
                            var tFullTaxBtnText = '<?=language('document/taxinvoice/taxinvoice', 'tTAXDownloadCNFullTax'); ?>';
                        }
                    }

                    $('.xWETaxOnDownload').attr('href',tPDFURL);
                    $('.xWETaxOnDownload').attr('download',tPDFURL);
                    $('.xWETaxOnDownload')[0].click();
                }else{

                    if( ptTypeTax == 'ABB' ){
                        if( tDocType == '4' ){
                            var tABBBtnText     = '<?=language('document/taxinvoice/taxinvoice', 'ตรวจสอบใบอย่างย่ออีกครั้ง'); ?>';
                        }else{
                            var tABBBtnText     = '<?=language('document/taxinvoice/taxinvoice', 'ตรวจสอบใบคืนอีกครั้ง'); ?>';
                        }
                    }else{
                        if( tDocType == '4' ){
                            var tFullTaxBtnText = '<?=language('document/taxinvoice/taxinvoice', 'ตรวจสอบใบเต็มรูปอีกครั้ง'); ?>';
                        }else{
                            var tFullTaxBtnText = '<?=language('document/taxinvoice/taxinvoice', 'ตรวจสอบใบลดหนี้อีกครั้ง'); ?>';
                        }
                    }

                    var tMsgError = "(" + aReturnData['tReturnCode'] + ") " + aReturnData['tReturnMsg'];
                    FSvCMNSetMsgWarningDialog(tMsgError);
                }

                $('#obtPrintPreviewDocumentABB').text(tABBBtnText);
                $('#obtPrintDocument').text(tFullTaxBtnText);

                JCNxCloseLoading();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }

    $('#obtPrintDocument').off('click').on('click',function(){

        var oPackData = JSON.stringify({
            ptType      : 'FullTax',
            ptStaETax   : $(this).attr('data-staetax')
        });

        var tTAXStaDoc = $('#ohdTAXStaDoc').val();
        if( tTAXStaDoc == '3' || tTAXStaDoc == '5' ){
            FSvCMNSetMsgWarningDialog('เอกสารใบกำกับภาษีฉบับนี้ได้ถูกยกเลิกแล้ว ต้องการดาวน์โหลดเอกสารใบกำกับภาษี','JSxTAXPrintOrDownload','',oPackData);
        }else{
            JSxTAXPrintOrDownload(oPackData);
        }
    });

    $('#obtTAXApvETax').off('click').on('click',function(){

        $('.form-group').removeClass("has-success").removeClass("has-error");

        var nCountValidate = 0;
        nCountValidate = JSxTAXValidateInput('#oetTAXDocDate',nCountValidate);
        nCountValidate = JSxTAXValidateInput('#oetTAXDocTime',nCountValidate);
        nCountValidate = JSxTAXValidateInput('#oetTAXABBCode',nCountValidate);
        nCountValidate = JSxTAXValidateInput('#oetTAXCusNameCusABB',nCountValidate);
        nCountValidate = JSxTAXValidateInput('#oetTAXNumber',nCountValidate);

        nCountValidate = JSxTAXValidateInput('#otxAddress1',nCountValidate);
        nCountValidate = JSxTAXValidateInput('#oetFTAddV1PvnName',nCountValidate);
        nCountValidate = JSxTAXValidateInput('#oetFTAddV1DstName',nCountValidate);
        nCountValidate = JSxTAXValidateInput('#oetFTAddV1SubDistName',nCountValidate);
        nCountValidate = JSxTAXValidateInput('#oetFTAddV1PostCode',nCountValidate);

        var tTaxABBType = $("#oetTAXABBTypeDocuement").val();
        if( tTaxABBType == '9' ){  // CN-ABB
            nCountValidate = JSxTAXValidateInput('#oetTAXRsnName',nCountValidate);
        }
        
        if( nCountValidate > 0 ){
            return;
        }else{
            var tTaxDocNo = $('#oetTAXDocNo').val();
            $('#odvModalAproveDocument').modal('show');
            $('#obtConfirmApprDoc').off('click').on('click',function(){
                $('#odvModalAproveDocument').modal('hide');

                var aDataHDAddress = {
                    FTAddTel            : $('#oetTAXTel').val(),
                    FTAddFax            : $('#oetTAXFax').val(),
                    FTAddV2Desc1        : $('#otxAddress1').val(),
                    FTAddV2Desc2        : $('#otxAddress2').val(),
                    FTAddTaxNo          : $('#oetTAXNumber').val(),
                    FTAddName           : $('#oetTAXCusNameCusABB').val(),
                    FTAddV1PvnCode      : $('#oetFTAddV1PvnCode').val(),
                    FTAddV1DstCode      : $('#oetFTAddV1DstCode').val(),
                    FTAddV1SubDist      : $('#oetFTAddV1SubDistCode').val(),
                    FTAddV1PostCode     : $('#oetFTAddV1PostCode').val(),
                };

                var aDataHDCst = {
                    FTXshCstTel         : $('#oetTAXTel').val(),
                    FTXshAddrTax        : $('#oetTAXNumber').val(),
                    FTXshCstName        : $('#oetTAXCusNameCusABB').val(),
                    FTXshCstEmail       : $('#oetTAXEmail').val(),
                };

                $.ajax({
                    type: "POST",
                    url: "docTAXEventApvETax",
                    data: {
                        ptABBDocNo          : $('#oetTAXABBCode').val(),
                        ptTaxDocNo          : tTaxDocNo,
                        ptPosCode           : $('#oetTAXPos').val(),
                        ptBchCode           : $('#ohdBCHDocument').val(),
                        ptDocType           : $('#oetTAXABBTypeDocuement').val(),
                        paDataHDAddress     : aDataHDAddress,
                        paDataHDCst         : aDataHDCst
                    },
                    cache: false,
                    timeout: 0,
                    success: function(oResult) {
                        var aReturnData = JSON.parse(oResult);
                        console.log(aReturnData);
                        if ( aReturnData['nStaEvent'] == '1' ) {
                            JSxTAXSubscribeMQ(tTaxDocNo);
                        }else{
                            var tMsgError = aReturnData['tStaMessg'];
                            FSvCMNSetMsgWarningDialog(tMsgError);
                        }
                        // JCNxCloseLoading();
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            });
        }
        
    });

    // KPC Default ที่อยู่แบบแยก
    // $("#orbTAXAddVersion1").prop("checked", true);
    // $('#odvTAXAddress1').show();
    // $('#odvTAXAddress2').hide();

    // ถ้าเป็นประเภท E-Tax จะกรอกได้เฉพาะที่อยู่แยก
    // var tStaETax = $('#oetTXIStaETax').val();
    // if( tStaETax == '1' ){
    //     $('.xWTAxAddVersion').attr('disabled',true);
    // }

    // $('#oetTXIStaETax').off('change').on('change',function(){
    //     var tStaETax = $(this).val();
    //     if( tStaETax == '1' ){
    //         $("#orbTAXAddVersion1").prop("checked", true);
    //         $('.xWTAxAddVersion').attr('disabled',true);
    //         $('#odvTAXAddress1').show();
    //         $('#odvTAXAddress2').hide();
    //     }else{
    //         $('.xWTAxAddVersion').attr('disabled',false);
    //     }
    // });

    

    // $('.xWTAxAddVersion').off('change').on('change',function(){
    //     var tAddVersion = $(this).val();
    //     if( tAddVersion == '1' ){
    //         $('#odvTAXAddress1').show();
    //         $('#odvTAXAddress2').hide();
    //     }else{
    //         $('#odvTAXAddress1').hide();
    //         $('#odvTAXAddress2').show();
    //     }
    // });

    $('#obtBrowsePvn').off('click').on('click',function(){
        oTAXBrowsePvnOption = oTAXPvnOption({
            'tReturnInputCode'  : 'oetFTAddV1PvnCode',
            'tReturnInputName'  : 'oetFTAddV1PvnName',
            // 'tNextFuncName'     : 'JSxFindAddressByCustomer',
            // 'aArgReturn'        : ['FTCstCode','FTCstTaxNo','FTCstCardID','FTCstName']
        });
        JCNxBrowseData('oTAXBrowsePvnOption');
    });

    var oTAXPvnOption = function(poDataFnc){
        var nLangEdits          = '<?=$this->session->userdata("tLangEdit");?>';
        var tInputReturnCode    = poDataFnc.tReturnInputCode;
        var tInputReturnName    = poDataFnc.tReturnInputName;
        // var tNextFuncName       = poDataFnc.tNextFuncName;
        // var aArgReturn          = poDataFnc.aArgReturn;
        
        var oOptionReturn       = {
            Title   : ['document/taxinvoice/taxinvoice', 'จังหวัด'],
            Table   : {Master:'TCNMProvince', PK:'FTPvnCode'},
            Join    : {
                Table   : ['TCNMProvince_L'],
                On      : ['TCNMProvince_L.FTPvnCode = TCNMProvince.FTPvnCode AND TCNMProvince_L.FNLngID = '+nLangEdits]
            },
            // Where:{
            //     Condition : [ tWhereCondition ]
            // },
            GrideView:{
                ColumnPathLang      : 'document/taxinvoice/taxinvoice',
                ColumnKeyLang       : ['รหัสจังหวัด', 'ชื่อจังหวัด'],
                ColumnsSize         : ['15%', '85%'],
                WidthModal          : 50,
                DataColumns         : ['TCNMProvince.FTPvnCode', 'TCNMProvince_L.FTPvnName'],
                // DisabledColumns     : [5],
                DataColumnsFormat   : ['',''],
                Perpage             : 10,
                OrderBy             : ['TCNMProvince_L.FTPvnName ASC']
            },
            CallBack:{
                ReturnType  : 'S',
                Value       : [tInputReturnCode,"TCNMProvince.FTPvnCode"],
                Text        : [tInputReturnName,"TCNMProvince_L.FTPvnName"]
            },
            // NextFunc:{
            //     FuncName    : tNextFuncName,
            //     ArgReturn   : aArgReturn
            // }
        };
        return oOptionReturn;
    }

    
    $('#obtBrowseDst').off('click').on('click',function(){
        oTAXBrowseDstOption = oTAXDstOption({
            'tReturnInputCode'  : 'oetFTAddV1DstCode',
            'tReturnInputName'  : 'oetFTAddV1DstName',
            'tPvnCode'          : $('#oetFTAddV1PvnCode').val(),
            // 'tNextFuncName'     : 'JSxFindAddressByCustomer',
            // 'aArgReturn'        : ['FTCstCode','FTCstTaxNo','FTCstCardID','FTCstName']
        });
        JCNxBrowseData('oTAXBrowseDstOption');
    });

    var oTAXDstOption = function(poDataFnc){
        var nLangEdits          = '<?=$this->session->userdata("tLangEdit");?>';
        var tInputReturnCode    = poDataFnc.tReturnInputCode;
        var tInputReturnName    = poDataFnc.tReturnInputName;
        var tPvnCode            = poDataFnc.tPvnCode;
        var tWhereCondition     = "";
        // var tNextFuncName       = poDataFnc.tNextFuncName;
        // var aArgReturn          = poDataFnc.aArgReturn;

        if( tPvnCode != "" ){
            tWhereCondition += " AND TCNMDistrict.FTPvnCode = '"+tPvnCode+"' ";
        }
        
        var oOptionReturn       = {
            Title   : ['document/taxinvoice/taxinvoice', 'อำเภอ/เขต'],
            Table   : {Master:'TCNMDistrict', PK:'FTDstCode'},
            Join    : {
                Table   : ['TCNMDistrict_L'],
                On      : ['TCNMDistrict_L.FTDstCode = TCNMDistrict.FTDstCode AND TCNMDistrict_L.FNLngID = '+nLangEdits]
            },
            Where:{
                Condition : [ tWhereCondition ]
            },
            GrideView:{
                ColumnPathLang      : 'document/taxinvoice/taxinvoice',
                ColumnKeyLang       : ['รหัสอำเภอ/เขต', 'ชื่ออำเภอ/เขต', 'รหัสไปรษณีย์'],
                ColumnsSize         : ['15%', '70%', '15%'],
                WidthModal          : 50,
                DataColumns         : ['TCNMDistrict.FTDstCode', 'TCNMDistrict_L.FTDstName', 'TCNMDistrict.FTDstPost'],
                // DisabledColumns     : [5],
                DataColumnsFormat   : ['','',''],
                Perpage             : 10,
                OrderBy             : ['TCNMDistrict_L.FTDstName ASC']
            },
            CallBack:{
                ReturnType  : 'S',
                Value       : [tInputReturnCode,"TCNMDistrict.FTDstCode"],
                Text        : [tInputReturnName,"TCNMDistrict_L.FTDstName"]
            },
            NextFunc:{
                FuncName    : 'JSxTAXBrowseDstCallBack',
                ArgReturn   : ['FTDstPost']
            }
        };
        return oOptionReturn;
    }

    function JSxTAXBrowseDstCallBack(poData){
        if( poData != "NULL" ){
            var paData = JSON.parse(poData);
            $('#oetFTAddV1PostCode').val(paData[0]);
        }
    }
    
    $('#obtBrowseSubDist').off('click').on('click',function(){
        oTAXBrowseSubDistOption = oTAXSubDistOption({
            'tReturnInputCode'  : 'oetFTAddV1SubDistCode',
            'tReturnInputName'  : 'oetFTAddV1SubDistName',
            'tDstCode'          : $('#oetFTAddV1DstCode').val(),
            // 'tNextFuncName'     : 'JSxFindAddressByCustomer',
            // 'aArgReturn'        : ['FTCstCode','FTCstTaxNo','FTCstCardID','FTCstName']
        });
        JCNxBrowseData('oTAXBrowseSubDistOption');
    });

    var oTAXSubDistOption = function(poDataFnc){
        var nLangEdits          = '<?=$this->session->userdata("tLangEdit");?>';
        var tInputReturnCode    = poDataFnc.tReturnInputCode;
        var tInputReturnName    = poDataFnc.tReturnInputName;
        var tDstCode            = poDataFnc.tDstCode;
        var tWhereCondition     = "";
        // var tNextFuncName       = poDataFnc.tNextFuncName;
        // var aArgReturn          = poDataFnc.aArgReturn;

        if( tDstCode != "" ){
            tWhereCondition += " AND TCNMSubDistrict.FTDstCode = '"+tDstCode+"' ";
        }
        
        var oOptionReturn       = {
            Title   : ['document/taxinvoice/taxinvoice', 'ตำบล/แขวง'],
            Table   : {Master:'TCNMSubDistrict', PK:'FTSudCode'},
            Join    : {
                Table   : ['TCNMSubDistrict_L'],
                On      : ['TCNMSubDistrict_L.FTSudCode = TCNMSubDistrict.FTSudCode AND TCNMSubDistrict_L.FNLngID = '+nLangEdits]
            },
            Where:{
                Condition : [ tWhereCondition ]
            },
            GrideView:{
                ColumnPathLang      : 'document/taxinvoice/taxinvoice',
                ColumnKeyLang       : ['รหัสตำบล/แขวง', 'ชื่อตำบล/แขวง'],
                ColumnsSize         : ['15%', '85%'],
                WidthModal          : 50,
                DataColumns         : ['TCNMSubDistrict.FTSudCode', 'TCNMSubDistrict_L.FTSudName'],
                // DisabledColumns     : [5],
                DataColumnsFormat   : ['',''],
                Perpage             : 10,
                OrderBy             : ['TCNMSubDistrict_L.FTSudName ASC']
            },
            CallBack:{
                ReturnType  : 'S',
                Value       : [tInputReturnCode,"TCNMSubDistrict.FTSudCode"],
                Text        : [tInputReturnName,"TCNMSubDistrict_L.FTSudName"]
            },
            // NextFunc:{
            //     FuncName    : tNextFuncName,
            //     ArgReturn   : aArgReturn
            // }
        };
        return oOptionReturn;
    }

    function JSxTAXClearInputAddr($ptAddrVersion){
        if( $ptAddrVersion == '1' ){
            $('#oetFTAddV1No').val('');
            $('#oetFTAddV1Soi').val('');
            $('#oetFTAddV1Village').val('');
            $('#oetFTAddV1Road').val('');
            $('#oetFTAddV1SubDistCode').val('');
            $('#oetFTAddV1SubDistName').val('');
            $('#oetFTAddV1DstCode').val('');
            $('#oetFTAddV1DstName').val('');
            $('#oetFTAddV1PvnCode').val('');
            $('#oetFTAddV1PvnName').val('');
            $('#oetFTAddV1PostCode').val('');
        }else{
            $('#otxAddress1').text('');
            $('#otxAddress2').text('');
        }
    }

    $('#ocmTAXTypeBusiness').off('change').on('change',function(){
        JSxTAXChangeTypeBusiness();
    });

    function JSxTAXChangeTypeBusiness(){
        $('#ocmTAXTypeBusiness').selectpicker('refresh');
        var tTaxTypeBusiness = $('#ocmTAXTypeBusiness option:selected').val();
        if( tTaxTypeBusiness == '2' ){
            $('.xWTaxBusiness').hide();
        }else{
            $('.xWTaxBusiness').show();
        }
    }

    //------------------------------------------------------------------------- Event Cancel E-Tax

    $('#obtTAXCancleETax').off('click').on('click',function(){

        $("#ofmTaxCancel").validate().resetForm();
        $("#ofmTaxCancel").find('.has-error').removeClass("has-error");
        $("#ofmTaxCancel").find('.has-success').removeClass("has-success");
        $('#ofmTaxCancel').find('.form-control-feedback').remove();

        // เตรียมข้อมูล
        var tTAXDocNo       = $('#oetTAXDocNo').val();
        var tTAXCstName     = $('#oetTAXCusNameCusABB').val();
        var tTAXCstCode     = $('#oetTAXCusCode').val();
        var tAddress1       = $('#otxAddress1').val();
        var tAddress2       = $('#otxAddress2').val();
        var tPvnName        = $('#oetFTAddV1PvnName').val();
        var tPvnCode        = $('#oetFTAddV1PvnCode').val();
        var tDstName        = $('#oetFTAddV1DstName').val();
        var tDstCode        = $('#oetFTAddV1DstCode').val();
        var tSubDistName    = $('#oetFTAddV1SubDistName').val();
        var tSubDistCode    = $('#oetFTAddV1SubDistCode').val();
        var tPostCode       = $('#oetFTAddV1PostCode').val();


        $('#oetTAXModalCancelDocNo').val(tTAXDocNo);
        $('#oetTAXModalCancelCstName').val(tTAXCstName);
        $('#oetTAXModalCancelCstCode').val(tTAXCstCode);
        $('#otxTAXModalCancelAddress1').val(tAddress1);
        $('#otxTAXModalCancelAddress2').val(tAddress2);
        $('#oetTAXModalCancelPvnName').val(tPvnName);
        $('#oetTAXModalCancelPvnCode').val(tPvnCode);
        $('#oetTAXModalCancelDstName').val(tDstName);
        $('#oetTAXModalCancelDstCode').val(tDstCode);
        $('#oetTAXModalCancelSubDistName').val(tSubDistName);
        $('#oetTAXModalCancelSubDistCode').val(tSubDistCode);
        $('#oetTAXModalCancelPostCode').val(tPostCode);

        var tTaxABBType = $("#oetTAXABBTypeDocuement").val();
        if( tTaxABBType == '5' ){  // CN-ABB
            $('.xWDisabledForCN').attr('disabled',true);
            $('#ospTAXWarningMsgCancelCNFullTax').show();
        }else{
            $('.xWDisabledForCN').attr('disabled',false);
            $('#ospTAXWarningMsgCancelCNFullTax').hide();
        }

        // $('#obtTAXModalCancelBrowseAddress').attr('disabled',true);

        $('#odvTAXModalCancelETax').modal('show');
    });

    $('#obtTAXModalBrowsePvn').off('click').on('click',function(){
        oTAXModalBrowsePvnOption = oTAXPvnOption({
            'tReturnInputCode'  : 'oetTAXModalCancelPvnCode',
            'tReturnInputName'  : 'oetTAXModalCancelPvnName',
        });
        JCNxBrowseData('oTAXModalBrowsePvnOption');
    });

    $('#obtTAXModalBrowseDst').off('click').on('click',function(){
        oTAXModalBrowseDstOption = oTAXDstOption({
            'tReturnInputCode'  : 'oetTAXModalCancelDstCode',
            'tReturnInputName'  : 'oetTAXModalCancelDstName',
            'tPvnCode'          : $('#oetTAXModalCancelPvnCode').val()
        });
        JCNxBrowseData('oTAXModalBrowseDstOption');
    });

    $('#obtTAXModalBrowseSubDist').off('click').on('click',function(){
        oTAXModalBrowseSubDistOption = oTAXSubDistOption({
            'tReturnInputCode'  : 'oetTAXModalCancelSubDistCode',
            'tReturnInputName'  : 'oetTAXModalCancelSubDistName',
            'tDstCode'          : $('#oetTAXModalCancelDstCode').val()
        });
        JCNxBrowseData('oTAXModalBrowseSubDistOption');
    });

    $('#obtTAXModalCancelBrowseRsn').off('click').on('click',function(){

        var tDocType = $('#oetTAXABBTypeDocuement').val();
        var tRsnGrp  = '017';
        if( tDocType == '5' ){
            tRsnGrp = '018';
        }

        oTAXModalBrowseReasonOption = oTAXReasonOption({
            'tTitleModal'       : 'เหตุผลการยกเลิก',
            'tReturnInputCode'  : 'oetTAXModalCancelRsnCode',
            'tReturnInputName'  : 'oetTAXModalCancelRsnName',
            'tRsnGrp'           : tRsnGrp
        });
        JCNxBrowseData('oTAXModalBrowseReasonOption');
    });

    $('#obtTAXBrowseRsn').off('click').on('click',function(){
        oTAXBrowseReasonOption = oTAXReasonOption({
            'tTitleModal'       : 'เหตุผล',
            'tReturnInputCode'  : 'oetTAXRsnCode',
            'tReturnInputName'  : 'oetTAXRsnName',
            'tRsnGrp'           : '018'
        });
        JCNxBrowseData('oTAXBrowseReasonOption');
    });

    var oTAXReasonOption = function(poDataFnc){
        var nLangEdits          = '<?=$this->session->userdata("tLangEdit");?>';
        var tTitleModal         = poDataFnc.tTitleModal;
        var tInputReturnCode    = poDataFnc.tReturnInputCode;
        var tInputReturnName    = poDataFnc.tReturnInputName;
        var tRsnGrp             = poDataFnc.tRsnGrp;

        var tWhereCondition     = "";
        var tSesUsrAgnCode      = '<?=$this->session->userdata("tSesUsrAgnCode");?>';
        var tSesUsrLevel        = '<?=$this->session->userdata("tSesUsrLevel");?>';

        
        if( tSesUsrLevel != "HQ" && tSesUsrAgnCode != "" ){
            tWhereCondition += " AND TCNMRsn.FTAgnCode = '"+tSesUsrAgnCode+"' ";
        }

        if( tRsnGrp != "" ){
            tWhereCondition += " AND TCNMRsn.FTRsgCode = '"+tRsnGrp+"' ";
        }
        
        var oOptionReturn       = {
            Title   : ['document/taxinvoice/taxinvoice', tTitleModal],
            Table   : {Master:'TCNMRsn', PK:'FTRsnCode'},
            Join    : {
                Table   : ['TCNMRsn_L'],
                On      : ['TCNMRsn_L.FTRsnCode = TCNMRsn.FTRsnCode AND TCNMRsn_L.FNLngID = '+nLangEdits]
            },
            Where:{
                Condition : [ tWhereCondition ]
            },
            GrideView:{
                ColumnPathLang      : 'document/taxinvoice/taxinvoice',
                ColumnKeyLang       : ['รหัสเหตุผล', 'ชื่อเหตุผล'],
                ColumnsSize         : ['15%', '85%'],
                WidthModal          : 50,
                DataColumns         : ['TCNMRsn.FTRsnCode', 'TCNMRsn_L.FTRsnName'],
                // DisabledColumns     : [5],
                DataColumnsFormat   : ['',''],
                Perpage             : 10,
                OrderBy             : ['TCNMRsn.FDCreateOn DESC']
            },
            CallBack:{
                ReturnType  : 'S',
                Value       : [tInputReturnCode,"TCNMRsn.FTRsnCode"],
                Text        : [tInputReturnName,"TCNMRsn_L.FTRsnName"]
            },
            // NextFunc:{
            //     FuncName    : tNextFuncName,
            //     ArgReturn   : aArgReturn
            // }
        };
        return oOptionReturn;
    }
    
    $('#osmTAXModalConfirm').off('click').on('click',function(){
        $('#ofmTaxCancel').validate().destroy();
        $('#ofmTaxCancel').validate({
            rules: {
                oetTAXModalCancelRsnName        : "required",
                oetTAXModalCancelCstName        : "required",
                otxTAXModalCancelAddress1       : "required",
                oetTAXModalCancelPvnName        : "required",
                oetTAXModalCancelDstName        : "required",
                oetTAXModalCancelSubDistName    : "required",
                oetTAXModalCancelPostCode       : "required",
            },
            messages: {
                oetTAXModalCancelRsnName        : 'กรุณาเลือก เหตุผลการยกเลิก',
                oetTAXModalCancelCstName        : 'กรุณากรอก ชื่อลูกค้า / ชื่อออกใบกำกับภาษี',
                otxTAXModalCancelAddress1       : 'กรุณากรอก ที่อยู่ 1 สำหรับออกใบกำกับภาษี',
                oetTAXModalCancelPvnName        : 'กรุณาเลือก จังหวัด',
                oetTAXModalCancelDstName        : 'กรุณาเลือก อำเภอ/เขต',
                oetTAXModalCancelSubDistName    : 'กรุณาเลือก ตำบล/แขวง',
                oetTAXModalCancelPostCode       : 'กรุณากรอก รหัสไปรษณีย์',
            },
            errorElement: "em",
            errorPlacement: function (error, element ) {
                error.addClass( "help-block" );
                if ( element.prop( "type" ) === "checkbox" ) {
                    error.appendTo( element.parent( "label" ) );
                } else {
                    var tCheck = $(element.closest('.form-group')).find('.help-block').length;
                    if(tCheck == 0){
                        error.appendTo(element.closest('.form-group')).trigger('change');
                    }
                }
            },
            highlight: function(element, errorClass, validClass) {
                $( element ).closest('.form-group').addClass( "has-error" ).removeClass( "has-success" );
            },
            unhighlight: function(element, errorClass, validClass) {
                $( element ).closest('.form-group').addClass( "has-success" ).removeClass( "has-error" );
            },
            submitHandler: function(form){
                $('#ohdTAXApvType').val('2');
                $('#odvTAXModalCancelETax').modal('hide');
                JSxTAXComfirmApprove();
            },
        });
    });

    $('#obtTAXModalCancelBrowseCus').off('click').on('click',function(){
        $('#ohdTAXBrowseCusAddrType').val('2');
        oTAXBrowseCstOption      = oCstOption({
            'tReturnInputCode'  : 'oetTAXModalCancelCstCode',
            'tReturnInputName'  : 'oetTAXModalCancelCstName',
            'tNextFuncName'     : 'JSxFindAddressByCustomer',
            'aArgReturn'        : ['FTCstCode','FTCstTaxNo','FTCstCardID','FTCstName']
        });
        JCNxBrowseData('oTAXBrowseCstOption');
    });

    $('#obtTAXModalCancelBrowseAddress').off('click').on('click',function(){
        $('#odvTAXModalCancelETax').modal('hide');
        $('#odvTAXModalSelectAddressCustomer').modal('show');
        JCNxSearchBrowseSelectAddressCustomer(2);
    });

    //------------------------------------------------------------------------- End Event Cancel E-Tax

    

</script>