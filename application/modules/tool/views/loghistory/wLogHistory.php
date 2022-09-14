<div id="odvLGHMainMenu" class="main-menu">
    <div class="xCNMrgNavMenu">
        <div class="row xCNavRow" style="width:inherit;">
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                <ol id="oliLGHMenuNav" class="breadcrumb">
                    <?php FCNxHADDfavorite('toolLogHistory');?>
                    <li id="oliLGHTitle" style="cursor:pointer;"><?php echo language('tool/loghistory','tLGHTitleMenu');?></li>
                </ol>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-right p-r-0">
                <div class="demo-button xCNBtngroup" style="width:100%;">
                    <div id="odvLGHBtnGrpInfo">
                        <div class="demo-button xCNBtngroup" style="width:100%;">
                            <input id="ohdLGHAgnCode" type="hidden" value="<?=$this->session->userdata("tSesUsrAgnCode")?>">
                            <input id="ohdLGHUsrCode" type="hidden" value="<?=$this->session->userdata("tSesUsername")?>">
                            <button id="obtLGHRequest" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" type="button"> <?php echo language('tool/loghistory', 'tLGHBtnRequest'); ?></button>  
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="main-content">
    <div id="odvLGHContentPageDocument"></div>
</div>

<div id="odvLGHModalRequestFile" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header xCNModalHead">
                <label class="xCNTextModalHeard"><?php echo language('tool/loghistory', 'tLGHModalTitle')?></label>
            </div>
            <div class="modal-body">
                <div class="panel-body" style="padding:10px">
                    <form action="javascript:void(0)" method="post" enctype="multipart/form-data" id="ofmLGHRequestData">
                        <!-- สาขา -->
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?= language('tool/loghistory','tLGHFilterBch')?></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control xCNHide xWRptAllInput" id="oetLGHReqBchCode" name="oetLGHReqBchCode" maxlength="5" value="">
                                        <input type="text" class="form-control xWPointerEventNone xWRptAllInput xCNInputNewUI" value="" id="oetLGHReqBchName" name="oetLGHReqBchName" readonly placeholder="<?= language('tool/loghistory','tLGHFilterBch')?>">
                                        <span class="input-group-btn">
                                            <button id="obtLGHReqBrowseBch" type="button" class="btn xCNBtnBrowseAddOn">
                                                <img src="<?php echo  base_url().'/application/modules/common/assets/images/icons/find-24.png'?>">
                                            </button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- สาขา -->

                        <!-- ประเภทจุดขาย -->
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('tool/loghistory', 'tLGHModalPosType'); ?></label>
                                    <select class="selectpicker form-control" id="ocmLGHReqPosType" name="ocmLGHReqPosType">
                                        <option value='' selected><?php echo language('common/main/main', 'tAll'); ?></option>
                                        <option value='1'><?php echo language('tool/loghistory', 'tLGHModalPosType1'); ?></option>
                                        <option value='4'><?php echo language('tool/loghistory', 'tLGHModalPosType4'); ?></option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- ประเภทจุดขาย -->
                                
                        <!-- เครื่องจุดขาย -->
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?= language('tool/loghistory','tLGHFilterPos')?></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control xCNHide xWRptAllInput" id="oetLGHReqPosCode" name="oetLGHReqPosCode" maxlength="5" value="">
                                        <input type="text" class="form-control xWPointerEventNone xWRptAllInput xCNInputNewUI" value="" id="oetLGHReqPosName" name="oetLGHReqPosName" readonly placeholder="<?= language('tool/loghistory','tLGHFilterPos')?>">
                                        <span class="input-group-btn">
                                            <button id="obtLGHReqBrowsePos" type="button" class="btn xCNBtnBrowseAddOn">
                                                <img src="<?php echo  base_url().'/application/modules/common/assets/images/icons/find-24.png'?>">
                                            </button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- เครื่องจุดขาย -->

                        <!-- ประเภท -->
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('tool/loghistory', 'tLGHFilterType'); ?></label>
                                    <select class="selectpicker form-control" id="ocmLGHReqType" name="ocmLGHReqType">
                                        <option value='1'><?php echo language('tool/loghistory', 'tLGHFilterType1'); ?></option>
                                        <option value='2'><?php echo language('tool/loghistory', 'tLGHFilterType2'); ?></option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- ประเภท -->

                        <!-- วันที่ข้อมูล -->
                        <div id="odvLGHDateFile" class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><span class="text-danger">*</span> <?php echo language('tool/loghistory','tLGHTableDateFile'); ?></label>
                                    <div class="input-group">
                                        <input
                                            class="form-control xCNDatePicker"
                                            type="text"
                                            id="oetLGHReqDateFile"
                                            name="oetLGHReqDateFile"
                                            placeholder="<?php echo language('tool/loghistory', 'tLGHTableDateFile'); ?>"
                                            max-length="10"
                                            autocomplete="off"
                                            value="<?=date('Y-m-d')?>"
                                        >
                                        <span class="input-group-btn" >
                                            <button id="obtLGHReqDateFile" type="button" class="btn xCNBtnDateTime"><img class="xCNIconCalendar"></button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- วันที่ข้อมูล -->

                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button id="obtLGHConfirm" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" type="button"><?php echo language('common/main/main', 'tModalConfirm')?></button>
                <button class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button" data-dismiss="modal"><?php echo language('common/main/main', 'tModalCancel')?></button>
            </div>
        </div>
    </div>
</div>

<?php include('script/jLogHistory.php')?>