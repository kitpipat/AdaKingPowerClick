
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                <!-- Panel Condition -->
                <div class="panel panel-default" style="margin-bottom: 25px;">
                    <div id="odvPAMInfoOther" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
                        <label class="xCNTextDetail1"><?php echo language('document/productarrangement/productarrangement','tPAMCondition')?></label>
                        <a class="xCNMenuplus" role="button" data-toggle="collapse" href="#odvPAMConditionSearch" aria-expanded="true">
                            <i class="fa fa-plus xCNPlus"></i>
                        </a>
                    </div>
                    <div id="odvPAMConditionSearch" class="xCNMenuPanelData panel-collapse collapse in" role="tabpanel">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <form id="ofmPAMSearchAdv">

                                        <!-- สาขาที่สร้าง -->
                                        <?php
                                            $tSesUsrLevel = $this->session->userdata("tSesUsrLevel");
                                            if( $tSesUsrLevel != "HQ" ){
                                                $tBchCodeDefault    = $this->session->userdata("tSesUsrBchCodeDefault");
                                                $tBchNameDefault    = $this->session->userdata("tSesUsrBchNameDefault");

                                                $nSesUsrBchCount    = $this->session->userdata("nSesUsrBchCount");
                                                if( $nSesUsrBchCount == 1 ){
                                                    $tDisabledBch = "disabled";
                                                }else{
                                                    $tDisabledBch = "";
                                                }
                                                
                                            }else{
                                                $tBchCodeDefault    = "";
                                                $tBchNameDefault    = "";
                                                $tDisabledBch       = "";
                                            }
                                        ?>
                                        <div class="form-group">
                                            <label class="xCNLabelFrm"><?php echo language('document/document/document', 'tDocBchCreate') ?></label>
                                            <div class="input-group"><input type="text" class="form-control xControlForm xCNHide" id="oetPAMBchCode" name="oetPAMBchCode" maxlength="5" value="<?=$tBchCodeDefault?>">
                                                <input type="text" class="form-control xControlForm xWPointerEventNone" id="oetPAMBchName" name="oetPAMBchName" maxlength="100" placeholder="<?php echo language('document/document/document', 'tDocBchCreate') ?>" value="<?=$tBchNameDefault?>" readonly>
                                                <span class="input-group-btn">
                                                    <button id="obtPAMBrowseBch" type="button" class="btn xCNBtnBrowseAddOn" <?=$tDisabledBch?> >
                                                        <img src="<?php echo  base_url() . '/application/modules/common/assets/images/icons/find-24.png' ?>">
                                                    </button>
                                                </span>
                                            </div>
                                        </div>
                                        <!-- สาขาที่สร้าง -->

                                        <!-- ที่เก็บ -->
                                        <div class="form-group">
                                            <label class="xCNLabelFrm"><?php echo language('document/productarrangement/productarrangement', 'tPAMLocation') ?></label>
                                            <div class="input-group"><input type="text" class="form-control xControlForm xCNHide" id="oetPAMPlcCode" name="oetPAMPlcCode" maxlength="5" value="">
                                                <input type="text" class="form-control xControlForm xWPointerEventNone" id="oetPAMPlcName" name="oetPAMPlcName" maxlength="100" placeholder="<?php echo language('document/productarrangement/productarrangement', 'tPAMLocation') ?>" value="" readonly>
                                                <span class="input-group-btn">
                                                    <button id="obtPAMBrowsePlc" type="button" class="btn xCNBtnBrowseAddOn">
                                                        <img src="<?php echo  base_url() . '/application/modules/common/assets/images/icons/find-24.png' ?>">
                                                    </button>
                                                </span>
                                            </div>
                                        </div>
                                        <!-- ที่เก็บ -->

                                        <!-- หมวดสินค้า 1-5 -->
                                        <?php for($i=1;$i<=5;$i++){ ?>
                                        <div class="form-group">
                                            <label class="xCNLabelFrm"><?php echo language('document/productarrangement/productarrangement', 'tPAMCat'.$i) ?></label>
                                            <div class="input-group"><input type="text" class="form-control xControlForm xCNHide" id="oetPAMCat<?=$i?>Code" name="oetPAMCat<?=$i?>Code" maxlength="10" value="">
                                                <input type="text" class="form-control xControlForm xWPointerEventNone" id="oetPAMCat<?=$i?>Name" name="oetPAMCat<?=$i?>Name" maxlength="100" placeholder="<?php echo language('document/productarrangement/productarrangement', 'tPAMCat'.$i) ?>" value="" readonly>
                                                <span class="input-group-btn">
                                                    <button id="obtPAMBrowseCat<?=$i?>" type="button" class="btn xCNBtnBrowseAddOn">
                                                        <img src="<?php echo  base_url() . '/application/modules/common/assets/images/icons/find-24.png' ?>">
                                                    </button>
                                                </span>
                                            </div>
                                        </div>
                                        <?php } ?>
                                        <!-- หมวดสินค้า 1-5 -->

                                        <!-- จากวันที่เอกสาร -->
                                        <div class="form-group">
                                            <label class="xCNLabelFrm"><?php echo language('document/document/document', 'tDocDateFrom'); ?></label>
                                            <div class="input-group">
                                                <input type="text" class="form-control xControlForm xCNDatePicker xCNInputMaskDate" id="oetPAMDocDateFrm" name="oetPAMDocDateFrm" value="" placeholder="<?php echo language('document/document/document', 'tDocDateFrom') ?>">
                                                <span class="input-group-btn">
                                                    <button id="obtPAMDocDateFrm" type="button" class="btn xCNBtnDateTime"><img class="xCNIconCalendar"></button>
                                                </span>
                                            </div>
                                        </div>
                                        <!-- จากวันที่เอกสาร -->

                                        <!-- ถึงวันที่เอกสาร -->
                                        <div class="form-group">
                                            <label class="xCNLabelFrm"><?php echo language('document/document/document', 'tDocDateTo'); ?></label>
                                            <div class="input-group">
                                                <input type="text" class="form-control xControlForm xCNDatePicker xCNInputMaskDate" id="oetPAMDocDateTo" name="oetPAMDocDateTo" value="" placeholder="<?php echo language('document/document/document', 'tDocDateTo') ?>">
                                                <span class="input-group-btn">
                                                    <button id="obtPAMDocDateTo" type="button" class="btn xCNBtnDateTime"><img class="xCNIconCalendar"></button>
                                                </span>
                                            </div>
                                        </div>
                                        <!-- ถึงวันที่เอกสาร -->

                                        <!-- ประเภทใบจัด -->
                                        <div class="form-group">
                                            <label class="xCNLabelFrm"><?php echo language('document/productarrangement/productarrangement', 'tPAMPackingType'); ?></label>
                                            <select class="selectpicker xWPAMDisabledOnApv form-control xControlForm" id="ocmPAMPackType" name="ocmPAMPackType" maxlength="1">
                                                <option value="" selected><?php echo language('common/main/main', 'tAll'); ?></option>
                                                <option value="1"><?php echo language('document/productarrangement/productarrangement', 'tPAMDocType1'); ?></option>
                                                <option value="2"><?php echo language('document/productarrangement/productarrangement', 'tPAMDocType2'); ?></option>
                                            </select>
                                        </div>
                                        <!-- ประเภทใบจัด -->

                                        <!-- สถานะเอกสาร -->
                                        <div class="form-group">
                                            <label class="xCNLabelFrm"><?php echo language('document/document/document', 'tDocStaDoc'); ?></label>
                                            <select class="selectpicker xWPAMDisabledOnApv form-control xControlForm" id="ocmPAMStaDoc" name="ocmPAMStaDoc" maxlength="1">
                                                <option value="" selected><?php echo language('common/main/main', 'tAll'); ?></option>
                                                <option value="2"><?php echo language('document/document/document', 'tDocStaProApv'); ?></option>
                                                <option value="1"><?php echo language('document/document/document', 'tDocStaProApv1'); ?></option>
                                                <option value="3"><?php echo language('document/document/document', 'tDocStaProDoc3'); ?></option>
                                            </select>
                                        </div>
                                        <!-- สถานะเอกสาร -->

                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                <button id="obtPAMClearSearch" class="btn xCNBTNDefult xCNBTNDefult1Btn" style="border-radius: 0px !important;width: 100%;" type="button"><?php echo language('common/main/main', 'tClearSearch'); ?></button>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                <button id="obtPAMConfirmSearch" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" style="border-radius: 0px !important;width: 100%;" type="button"><?php echo language('common/main/main', 'tAdvanceFillter'); ?></button>                                  
                                            </div>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9">
                <div class="panel panel-headline">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-6 col-sm-5 col-md-5 col-lg-5">
                                <div class="form-group">
                                    <div class="input-group">
                                        <input type="text" class="form-control xCNInputWithoutSingleQuote" id="oetPAMSearchAllDocument" name="oetPAMSearchAllDocument" onkeyup="Javascript:if(event.keyCode==13) JSvPAMCallPageDataTable()" placeholder="<?= language('common/main/main', 'tPlaceholder'); ?>">
                                        <span class="input-group-btn">
                                            <button class="btn xCNBtnSearch" type="button" onclick="JSvPAMCallPageDataTable()">
                                                <img class="xCNIconBrowse" src="<?php echo base_url() . '/application/modules/common/assets/images/icons/search-24.png' ?>">
                                            </button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-7 col-md-7 col-lg-7 text-right">
                                <?php if ( $aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaDelete'] == 1 ) : ?>
                                    <div id="odvPAMMngTableList" class="btn-group xCNDropDrownGroup">
                                        <button type="button" class="btn xCNBTNMngTable" data-toggle="dropdown">
                                            <?php echo language('common/main/main','tCMNOption')?>
                                            <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu" role="menu">
                                            <li id="oliPAMBtnDeleteAll">
                                                <a data-toggle="modal" data-target="#odvPAMModalDelDocMultiple"><?php echo language('common/main/main','tCMNDeleteAll')?></a>
                                            </li>
                                        </ul>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <section id="ostPAMDataTableDocument" style="margin-bottom:15px;"></section>
                    </div>
                </div>
            </div>
        </div>




<script src="<?php echo  base_url('application/modules/common/assets/js/jquery.mask.js')?>"></script>
<script src="<?php echo  base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>
<?php include('script/jProductArrangementFormSearchList.php')?>