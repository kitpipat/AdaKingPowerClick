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
                    <label class="xCNLabelFrm"><?php echo language('document/abbsalerefund/abbsalerefund','tABBBrowseAgnTitle');?></label>
                    <div class="input-group">
                        <input type="text" class="form-control xCNHide" id="oetABBAgnCode" name="oetABBAgnCode">
                        <input type="text" class="form-control xWPointerEventNone" id="oetABBAgnName" name="oetABBAgnName" readonly placeholder="<?php echo language('document/abbsalerefund/abbsalerefund','tABBBrowseAgnTitle');?>">
                        <span class="input-group-btn">
                            <button id="obtABBBrowseAgency" type="button" class="btn xCNBtnBrowseAddOn"><img class="xCNIconFind"></button>
                        </span>
                    </div>
                </div>
            </div>
            <!-- END Agency -->

            <!-- START Branch -->
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                <div class="form-group">
                    <label class="xCNLabelFrm"><?php echo language('document/abbsalerefund/abbsalerefund','tABBBrowseBchTitle');?></label>
                    <div class="input-group">
                        <input type="text" class="form-control xCNHide" id="oetABBBchCode" name="oetABBBchCode">
                        <input type="text" class="form-control xWPointerEventNone" id="oetABBBchName" name="oetABBBchName" readonly placeholder="<?php echo language('document/abbsalerefund/abbsalerefund','tABBBrowseBchTitle');?>">
                        <span class="input-group-btn">
                            <button id="obtABBBrowseBranch" type="button" class="btn xCNBtnBrowseAddOn"><img class="xCNIconFind"></button>
                        </span>
                    </div>
                </div>
            </div>
            <!-- END Branch -->

            <!-- START Doc Type -->
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                <div class="form-group">
                    <label class="xCNLabelFrm"><?=language('document/abbsalerefund/abbsalerefund','tABBDocType');?></label>
                    <select class="selectpicker form-control" id="oetABBDocType" name="oetABBDocType">
                        <option value="ALL"><?=language('common/main/main','tAll');?></option>
                        <option value="1"><?=language('document/abbsalerefund/abbsalerefund', 'tABBDocType1');?></option>
                        <option value="9"><?=language('document/abbsalerefund/abbsalerefund','tABBDocType9');?></option>
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
                    <label class="xCNLabelFrm"><?=language('document/abbsalerefund/abbsalerefund','ค้นหาเลขที่เอกสาร');?></label>
                    <input type="text" class="form-control xCNInputWithoutSingleQuote" id="oetABBFilterDocNo" name="oetABBFilterDocNo" autocomplete="off" placeholder="<?=language('document/abbsalerefund/abbsalerefund','ค้นหาเลขที่เอกสาร');?>">
                </div>
            </div>
            <!-- END Search Doc No. -->

            <!-- START Channel -->
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                <div class="form-group">
                    <label class="xCNLabelFrm"><?=language('document/abbsalerefund/abbsalerefund','tABBChannel');?></label>
                    <select class="selectpicker form-control" id="oetABBChannel" name="oetABBChannel">
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

            <!-- START Doc Date -->
            <!-- <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                <div class="form-group">
                    <label class="xCNLabelFrm"><?php echo language('document/abbsalerefund/abbsalerefund','tABBDocDate');?></label>
                    <div class="input-group">
                        <input type="text" class="form-control xCNDatePicker xCNInputMaskDate text-left" id="oetABBDocDate" name="oetABBDocDate" value="" placeholder="YYYY-MM-DD">
                        <span class="input-group-btn">
                            <button id="obtABBDocDate" type="button" class="btn xCNBtnDateTime"><img class="xCNIconCalendar"></button>
                        </span>
                    </div>
                </div>
            </div> -->
            <!-- END Doc Date -->

            <!-- START Sta Apv -->
            <!-- <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                <div class="form-group">
                    <label class="xCNLabelFrm"><?=language('document/abbsalerefund/abbsalerefund','tABBStaApv');?></label>
                    <select class="selectpicker form-control" id="ocmABBStaApv" name="ocmABBStaApv">
                        <option value=""><?=language('common/main/main','tAll');?></option>
                        <option value="1"><?=language('document/document/document', 'tDocStaProApv1');?></option>
                        <option value="2"><?=language('document/abbsalerefund/abbsalerefund', 'tABBStaApv2');?></option>
                        <option value="3"><?=language('document/abbsalerefund/abbsalerefund', 'tABBStaApv3');?></option>
                    </select>
                    <script>
                        $('.selectpicker').selectpicker('refresh');
                    </script>
                </div>
            </div> -->
            <!-- END Sta Apv -->

            <!-- START Sta Apv -->
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                <div class="form-group">
                    <label class="xCNLabelFrm"><?=language('document/abbsalerefund/abbsalerefund','tABBStaApv');?></label> 
                    <select class="selectpicker form-control" id="ocmABBStaPrcDoc" name="ocmABBStaPrcDoc"> <!-- FTXshStaPrcDoc 1:รออนุมัติ 2:รอจัดสินค้า 3:รอจัดส่ง 4:ยืนยันจัดส่ง -->
                        <option value=""><?=language('common/main/main','tAll');?></option>
                        <option value="5"><?=language('document/checkstatussale/checkstatussale', 'อนุมัติแล้ว');?></option>
                        <option value="1-4"><?=language('document/checkstatussale/checkstatussale', 'ยังไม่อนุมัติ');?></option>
                    </select>
                    <script>
                        $('.selectpicker').selectpicker('refresh');
                    </script>
                </div>
            </div>
            <!-- END Sta Apv -->

            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                <button id="obtABBSearch" class="btn xCNBTNPrimery" type="button" style="margin-top: 25px;width: 100%;"><?=language('common/main/main','tSearch');?></button>
            </div>

        </div>
    </div>
    <div class="panel-body">
        <section id="ostABBContentDatatable"></section>
    </div>
</div>

<?php include('script/jABBSaleRefundList.php') ?>