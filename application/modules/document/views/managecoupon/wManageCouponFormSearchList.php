<div class="panel panel-headline">
    <div class="panel-heading">        
        <form id="ofmMCPFromSerchAdv" class="validate-form" action="javascript:void(0)" method="post">
            <div class="row">
                <!-- Search Advanced Branch -->
                <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                    <div class="form-group">
                        <?php
                            if ( $this->session->userdata("tSesUsrLevel") != "HQ" ){
                                if( $this->session->userdata("nSesUsrBchCount") <= 1 ){ //ค้นหาขั้นสูง
                                    $tBCHCode 	    = $this->session->userdata("tSesUsrBchCodeDefault");
                                    $tBCHName 	    = $this->session->userdata("tSesUsrBchNameDefault");
                                    $tDisableBtn    = "disabled";
                                }else{
                                    $tBCHCode 	    = '';
                                    $tBCHName 	    = '';
                                    $tDisableBtn    = '';
                                }
                            }else{
                                $tBCHCode 		= '';
                                $tBCHName 		= '';
                                $tDisableBtn    = '';
                            }
                        ?>
                        <label class="xCNLabelFrm"><?php echo language('document/managecoupon/managecoupon', 'tMCPTBBchCreate'); ?></label>
                        <div class="input-group">
                            <input class="form-control xWNotClearInUsrBch xCNHide" type="text" id="oetMCPAdvSearchBchCode" name="oetMCPAdvSearchBchCode" maxlength="5" value="<?= $tBCHCode; ?>">
                            <input
                                class="form-control xWPointerEventNone xWNotClearInUsrBch"
                                type="text"
                                id="oetMCPAdvSearchBchName"
                                name="oetMCPAdvSearchBchName"
                                placeholder="<?php echo language('document/managecoupon/managecoupon','tMCPTBBchCreate'); ?>"
                                readonly
                                value="<?= $tBCHName; ?>" 
                            >
                            <span class="input-group-btn">
                                <button id="obtMCPAdvSearchBrowseBch" type="button" class="btn xCNBtnBrowseAddOn" <?=$tDisableBtn?> ><img class="xCNIconFind"></button>
                            </span>
                        </div>
                    </div>
                </div>
                <!-- Search Advanced Branch -->

                <!-- From-To Search Advanced  DocDate -->
                <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                    <div class="form-group">
                        <label class="xCNLabelFrm"><?php echo language('document/managecoupon/managecoupon','tMCPAdvSearchDateFrom'); ?></label>
                        <div class="input-group">
                            <input
                                class="form-control xCNDatePicker"
                                type="text"
                                id="oetMCPAdvSearcDocDateFrom"
                                name="oetMCPAdvSearcDocDateFrom"
                                placeholder="<?php echo language('document/managecoupon/managecoupon', 'tMCPAdvSearchDateFrom'); ?>"
                                autocomplete="off"
                            >
                            <span class="input-group-btn" >
                                <button id="obtMCPAdvSearchDocDateForm" type="button" class="btn xCNBtnDateTime"><img class="xCNIconCalendar"></button>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                    <label class="xCNLabelFrm"><?php echo language('document/managecoupon/managecoupon','tMCPAdvSearchDateTo'); ?></label>
                    <div class="input-group">
                        <input
                            class="form-control xCNDatePicker"
                            type="text"
                            id="oetMCPAdvSearcDocDateTo"
                            name="oetMCPAdvSearcDocDateTo"
                            placeholder="<?php echo language('document/managecoupon/managecoupon', 'tMCPAdvSearchDateTo'); ?>"
                            autocomplete="off"
                        >
                        <span class="input-group-btn" >
                            <button id="obtMCPAdvSearchDocDateTo" type="button" class="btn xCNBtnDateTime"><img class="xCNIconCalendar"></button>
                        </span>
                    </div>
                </div>
                <!-- From-To Search Advanced  DocDate -->

                <!-- Search Advanced Status Doc -->
                <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                    <div class="form-group">
                        <label class="xCNLabelFrm"><?php echo language('document/managecoupon/managecoupon','tMCPTBStatus'); ?></label>
                        <select class="selectpicker form-control" id="ocmMCPAdvSearchStaDoc" name="ocmMCPAdvSearchStaDoc">
                            <option value='0'><?php echo language('common/main/main','tAll'); ?></option>
                            <option value='1'><?php echo language('document/managecoupon/managecoupon','tMCPStatus1'); ?></option>
                            <option value='2'><?php echo language('document/managecoupon/managecoupon','tMCPStatus2'); ?></option>
                            <option value='3'><?php echo language('document/managecoupon/managecoupon','tMCPStatus3'); ?></option>
                            <option value='4'><?php echo language('document/managecoupon/managecoupon','tMCPStatus4'); ?></option>
                            <option value='EXP'><?php echo language('document/managecoupon/managecoupon','tMCPStatusExpire'); ?></option>
                        </select>
                    </div>
                </div>
                <!-- Search Advanced Status Doc -->
            </div>

            <div class="row">
                
                <!-- Search Advanced Doc Type -->
                <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                    <div class="form-group">
                        <label class="xCNLabelFrm"><?php echo language('document/managecoupon/managecoupon','tMCPTBType'); ?></label>
                        <select class="selectpicker form-control" id="ocmMCPAdvSearchDocType" name="ocmMCPAdvSearchDocType">
                            <option value='0'><?php echo language('common/main/main','tAll'); ?></option>
                            <option value='2'><?php echo language('document/managecoupon/managecoupon','tMCPType1'); ?></option>
                            <option value='1'><?php echo language('document/managecoupon/managecoupon','tMCPType2'); ?></option>
                        </select>
                    </div>
                </div>
                <!-- Search Advanced Doc Type -->

                <!-- Search Advanced DocNo -->
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                    <div class="form-group">
                        <label class="xCNLabelFrm"><?php echo language('document/managecoupon/managecoupon','tMCPTBDocNo'); ?></label>
                        <input
                            class="form-control xCNInpuTXOthoutSingleQuote"
                            type="text"
                            id="oetMCPSearchAllDocument"
                            name="oetMCPSearchAllDocument"
                            placeholder="<?php echo language('document/managecoupon/managecoupon','tMCPTBDocNo')?>"
                            autocomplete="off"
                        >
                    </div>
                </div>
                <!-- Search Advanced DocNo -->

                <!-- Button Form Search Advanced -->
                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                    <div class="form-group" style="margin-top:25px;">
                        <label class="xCNLabelFrm">&nbsp;</label>
                        <button id="obtMCPAdvSearchSubmitForm" class="btn xCNBTNPrimery"><?php echo language('common/main/main', 'tSearch'); ?></button>
                        <button id="obtMCPSearchReset" class="btn xCNBTNDefult xCNBTNDefult1Btn"><?php echo language('common/main/main', 'tClearSearch'); ?></button>
                    </div>
                </div>
                <!-- Button Form Search Advanced -->
                
            </div>    
        </form>
        
    </div>
    <div class="panel-body">
        <section id="ostMCPDataTableDocument"></section>
    </div>
</div>
<script src="<?php echo  base_url('application/modules/common/assets/js/jquery.mask.js')?>"></script>
<script src="<?php echo  base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>
<?php include('script/jManageCouponFormSearchList.php')?>