<style>
.bootstrap-select>.dropdown-toggle {
    padding: 3px;
}
</style>
<div class="panel panel-headline">
    <div class="panel-heading">
        <div class="row">

            <!-- START Agency -->
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2 <?php if( !FCNbGetIsAgnEnabled()) : echo 'xCNHide';  endif;?>">
                <div class="form-group">
                    <label class="xCNLabelFrm"><?php echo language('document/checkstatussale/checkstatussale','tCSSBrowseAgnTitle');?></label>
                    <div class="input-group">
                        <input type="text" class="form-control xCNHide" id="oetCSSAgnCode" name="oetCSSAgnCode">
                        <input type="text" class="form-control xWPointerEventNone" id="oetCSSAgnName" name="oetCSSAgnName" readonly placeholder="<?php echo language('document/checkstatussale/checkstatussale','tCSSBrowseAgnTitle');?>">
                        <span class="input-group-btn">
                            <button id="obtCSSBrowseAgency" type="button" class="btn xCNBtnBrowseAddOn"><img class="xCNIconFind"></button>
                        </span>
                    </div>
                </div>
            </div>
            <!-- END Agency -->

            <!-- START Branch -->
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                <div class="form-group">
                    <label class="xCNLabelFrm"><?php echo language('document/checkstatussale/checkstatussale','tCSSBrowseBchTitle');?></label>
                    <div class="input-group">
                        <input type="text" class="form-control xCNHide" id="oetCSSBchCode" name="oetCSSBchCode">
                        <input type="text" class="form-control xWPointerEventNone" id="oetCSSBchName" name="oetCSSBchName" readonly placeholder="<?php echo language('document/checkstatussale/checkstatussale','tCSSBrowseBchTitle');?>">
                        <span class="input-group-btn">
                            <button id="obtCSSBrowseBranch" type="button" class="btn xCNBtnBrowseAddOn"><img class="xCNIconFind"></button>
                        </span>
                    </div>
                </div>
            </div>
            <!-- END Branch -->

            <!-- START Doc Type -->
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                <div class="form-group">
                    <label class="xCNLabelFrm"><?=language('document/checkstatussale/checkstatussale','tCSSDocType');?></label>
                    <select class="selectpicker form-control" id="oetCSSDocType" name="oetCSSDocType">
                        <option value="1" selected><?=language('document/checkstatussale/checkstatussale','tCSSDocType1');?></option>
                        <option value="9"><?=language('document/checkstatussale/checkstatussale','tCSSDocType9');?></option>
                    </select>
                    <script>
                        $('.selectpicker').selectpicker('refresh');
                    </script>
                </div>
            </div>
            <!-- END Doc Type -->

            <!-- START Search Doc No. -->
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                <div class="form-group">
                    <label class="xCNLabelFrm"><?=language('document/checkstatussale/checkstatussale','ค้นหาเลขที่เอกสาร');?></label>
                    <input type="text" class="form-control xCNInputWithoutSingleQuote" id="oetCSSFilterDocNo" name="oetCSSFilterDocNo" autocomplete="off" placeholder="<?=language('document/checkstatussale/checkstatussale','ค้นหาเลขที่เอกสาร');?>">
                </div>
            </div>
            <!-- END Search Doc No. -->

            <!-- START Doc Date -->
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                <div class="form-group">
                    <label class="xCNLabelFrm"><?php echo language('document/checkstatussale/checkstatussale','tCSSDocDate');?></label>
                    <div class="input-group">
                        <input type="text" class="form-control xCNDatePicker xCNInputMaskDate text-left" id="oetCSSDocDate" name="oetCSSDocDate" value="" placeholder="YYYY-MM-DD"> 
                        <span class="input-group-btn">
                            <button id="obtCSSDocDate" type="button" class="btn xCNBtnDateTime"><img class="xCNIconCalendar"></button>
                        </span>
                    </div>
                </div>
            </div>
            <!-- END Doc Date -->

            <!-- START Channel -->
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                <div class="form-group">
                    <label class="xCNLabelFrm"><?=language('document/checkstatussale/checkstatussale','tCSSChannel');?></label>
                    <select class="selectpicker form-control" id="oetCSSChannel" name="oetCSSChannel">
                        <option value=""><?=language('common/main/main','tAll');?></option>
                        <?php
                            if( $aGetChnDelivery['tCode'] == '1' ){
                                foreach($aGetChnDelivery['aItems'] as $aValue){
                        ?>
                                   <option value="<?=$aValue['FNMapSeqNo']?>"><?=$aValue['FTMapName']?></option> 
                        <?php
                                }
                            }
                        ?>
                    </select>
                    <script>
                        $('.selectpicker').selectpicker('refresh');
                    </script>
                </div>
            </div>
            <!-- END Channel -->

            <!-- START Sta Apv -->
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                <div class="form-group">
                    <label class="xCNLabelFrm"><?=language('document/checkstatussale/checkstatussale','tCSSStaApv');?></label> 
                    <select class="selectpicker form-control" id="ocmCSSStaPrcDoc" name="ocmCSSStaPrcDoc"> <!-- FTXshStaPrcDoc 1:รออนุมัติ 2:รอจัดสินค้า 3:รอจัดส่ง 4:ยืนยันจัดส่ง -->
                        <option value=""><?=language('common/main/main','tAll');?></option>
                        <option value="1"><?=language('document/checkstatussale/checkstatussale', 'รอสร้างใบจัด');?></option>
                        <option value="2"><?=language('document/checkstatussale/checkstatussale', 'รอจัดสินค้า');?></option>
                        <option value="7"><?=language('document/checkstatussale/checkstatussale', 'รอสร้างใบส่ง');?></option>
                        <option value="3"><?=language('document/checkstatussale/checkstatussale', 'รอจัดส่ง');?></option>
                        <option value="4"><?=language('document/checkstatussale/checkstatussale', 'รอลูกค้ามารับ');?></option>
                        <option value="5"><?=language('document/checkstatussale/checkstatussale', 'ยืนยันจัดส่ง');?></option>
                        <option value="6"><?=language('document/checkstatussale/checkstatussale', 'ลูกค้าแจ้งยกเลิก');?></option>
                    </select>
                    <script>
                        $('.selectpicker').selectpicker('refresh');
                    </script>
                </div>
            </div>
            <!-- END Sta Apv -->
        </div>

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-10"></div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                <button id="obtCSSSearch" class="btn xCNBTNPrimery" type="button" style="width: 100%;"><?=language('common/main/main','tSearch');?></button>
            </div>

        </div>
    </div>
    <div class="panel-body">
        <section id="ostCSSContentDatatable"></section>
    </div>
</div>

<?php include('script/jCheckStatusSaleList.php') ?>