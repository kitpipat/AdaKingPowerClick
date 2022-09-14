<?php
    if(isset($aDataModaDetail) && !empty($aDataModaDetail)){
        // Data Rack
        $tBKLLayNo          = $aDataModaDetail['FNLayNo'];
        $tBKLBchCode        = $aDataModaDetail['FTBchCode'];
        $tBKLBchName        = $aDataModaDetail['FTBchName'];
        $tBKLShpCode        = $aDataModaDetail['FTShpCode'];
        $tBKLShpName        = $aDataModaDetail['FTShpName'];
        $tBKLPosCode        = $aDataModaDetail['FTPosCode'];
        $tBKLRakCode        = $aDataModaDetail['FTRakCode'];
        $tBKLRakName        = trim($aDataModaDetail['FTRakName']);
        $tBKLPzeCode        = $aDataModaDetail['FTPzeCode'];
        $tBKLPzeName        = $aDataModaDetail['FTSizName'];
        // Data Booking
        $tBKLBkgDocID       = !empty($aDataModaDetail['FNBkgDocID']) ? $aDataModaDetail['FNBkgDocID'] : "N/A";
        $tBKLBkgToStart     = !empty($aDataModaDetail['FDBkgToStart']) ? $aDataModaDetail['FDBkgToStart'] : date("Y-m-d");
        $tBKLBkgUsrName     = !empty($aDataModaDetail['FTUsrName']) ? $aDataModaDetail['FTUsrName'] : $this->session->userdata('tSesUsername');
        $tBKLBkgStaBook     = !empty($aDataModaDetail['FTBkgStaBook']) ? $aDataModaDetail['FTBkgStaBook'] : "N/A";
        $tBKLBkgBooking     = 'AdaStoreBack';
        // Data Form Booking
        $tBkgRthCode        = !empty($aDataModaDetail['FTBkgToRate']) ? $aDataModaDetail['FTBkgToRate'] : "";
        $tBkgRthName        = !empty($aDataModaDetail['FTRthName']) ? $aDataModaDetail['FTRthName'] : "";
        $tBKLBkgRefCst      = !empty($aDataModaDetail['FTBkgRefCst']) ? $aDataModaDetail['FTBkgRefCst'] : "";
        $tBKLBkgRefCstLogin = !empty($aDataModaDetail['FTBkgRefCstLogin']) ? $aDataModaDetail['FTBkgRefCstLogin'] : "";
        $tBKLBkgRefCstDoc   = !empty($aDataModaDetail['FTBkgRefCstDoc']) ? $aDataModaDetail['FTBkgRefCstDoc'] : "";
    }else{
        // Data Rack
        $tBKLLayNo      = 0;
        $tBKLBchCode    = "";
        $tBKLBchName    = "";
        $tBKLShpCode    = "";
        $tBKLShpName    = "";
        $tBKLPosCode    = "";
        $tBKLRakCode    = "";
        $tBKLRakName    = "";
        $tBKLPzeCode    = "";
        $tBKLPzeName    = "";
        // Data Booking
        $tBKLBkgDocID   = "N/A";
        $tBKLBkgToStart = date("d/m/Y");
        $tBKLBkgUsrName = $this->session->user_data('tSesUsername');
        $tBKLBkgStaBook = "N/A";
        $tBKLBkgBooking = 'AdaStoreBack';
        // Data Form Booking
        $tBkgRthCode        = "";
        $tBkgRthName        = "";
        $tBKLBkgRefCst      = "";
        $tBKLBkgRefCstLogin = "";
        $tBKLBkgRefCstDoc   = "";
    }
    // Disable 
    $tBKLDisableRth = "";
    if($nStaEventCallPage == "CANCELBOOKING"){
        $tBKLDisableBrowse  = "disabled";
        $tBKLDisableInput   = "readonly";
    }else{
        $tBKLDisableBrowse  = "";
        $tBKLDisableInput   = "";
    }
?>
<style>
    .xWBKLBoxFilter {
        border:1px solid #ccc !important;
        position:relative !important;
    }

    .xCNBorderRight{
        border-right: 1px solid #ccc !important;
    }
 
    #odvBKLDetailRack .xWBKLBoxFilter .form-group{
        margin-bottom: 5px !important;
    }

    #odvBKLDetailBooking .xWBKLBoxFilter .form-group{
        margin-bottom: 5px !important;
    }

    #odvBKLDetailBooking .xWBKLBoxFilter{
        background-color: blanchedalmond;
    }

    #odvBKLModalStatusResponse .xCNModalHead i{
        color: #08f93e !important;
    }

    #odvBKLModalStatusResponse .xCNModalHead #ospBKLBookingHeader{
        font-size: 23px !important;
        font-weight: bold !important;
        color: #08f93e !important;
    }

    #odvBKLModalStatusResponse .xCNMessage{
        font-size: 22px !important;
        font-weight: bold !important;
    }
</style>
<!-- Modal Booking Form Detail -->
<div id="odvBKLModalBooking" class="modal fade in" style="overflow: hidden auto; z-index: 3000;">
    <div class="modal-dialog" id="modal-customsWanning" role="document" style="width: 85%; margin: 1.75rem auto;top:0%;">
        <div class="modal-content">
            <div class="modal-header xCNModalHead">
                <label class="xCNTextModalHeard"><?php echo language('sale/bookingLocker/bookingLocker','tBKLModalTitleDetail')?></label>
            </div>
            <div class="modal-body">
                <form id="ofmBKLModalFormAddCancelBooking" class="validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data">
                    <input type="hidden" id="ohdBKLModalCallType"   name="ohdBKLModalCallType"  value="<?php echo @$nStaEventCallPage;?>">
                    <input type="hidden" id="ohdBKLModalLayNo"      name="ohdBKLModalLayNo"     value="<?php echo @$tBKLLayNo;?>">
                    <input type="hidden" id="ohdBKLModalBchCode"    name="ohdBKLModalBchCode"   value="<?php echo @$tBKLBchCode;?>">
                    <input type="hidden" id="ohdBKLModalShpCode"    name="ohdBKLModalShpCode"   value="<?php echo @$tBKLShpCode;?>">
                    <input type="hidden" id="ohdBKLModalPosCode"    name="ohdBKLModalPosCode"   value="<?php echo @$tBKLPosCode;?>">
                    <input type="hidden" id="ohdBKLModalRakCode"    name="ohdBKLModalRakCode"   value="<?php echo @$tBKLRakCode;?>">
                    <input type="hidden" id="ohdBKLModalPzeCode"    name="ohdBKLModalPzeCode"   value="<?php echo @$tBKLPzeCode;?>">
                    <div class="row p-b-10">
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-right">
                            <div class="demo-button xCNBtngroup" style="width:100%;">
                                <?php if($nStaEventCallPage == "ADDBOOKING"):?>
                                    <button id="obtBKLModalBtnAddBooking" type="button" class="btn btn-primary">
                                        <?php echo language('sale/bookinglocker/bookinglocker','tBKLModalBtnSaveBooking');?>
                                    </button>
                                <?php endif;?>
                                <?php if($nStaEventCallPage == "CANCELBOOKING"):?>
                                    <button id="obtBKLModalBtnCancelBooking" type="button" class="btn btn-danger">
                                        <?php echo language('sale/bookinglocker/bookinglocker','tBKLModalBtnCancelBooking');?>
                                    </button>
                                <?php endif;?>
                                <button id="obtBKLModalBtnCancle" type="button" class="btn btn-default">
                                    <?php echo language('sale/bookinglocker/bookinglocker','tBKLModalBtnCancel');?>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                            <div class="panel panel-default">
                                <div class="panel-heading xCNPanelHeadColor">
                                    <label class="xCNTextDetail1"><?php echo language('sale/bookinglocker/bookinglocker','tBKLModalLayNoBooking');?></label>
                                </div>
                                <div class="panel-collapse collapse in" role="tabpanel">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                <div id="odvModalDataNumberLocker">
                                                    <label class="xCNLabelFrm" style="text-align: center; width: 100%; font-size:8rem !important;"><?php echo @$tBKLLayNo;?></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-8 col-lg-8">
                            <div class="panel panel-default">
                                <div class="panel-heading xCNPanelHeadColor">
                                    <label class="xCNTextDetail1"><?php echo language('sale/bookinglocker/bookinglocker','tBKLModalBookingDetail');?></label>
                                </div>
                                <div class="panel-collapse collapse in" role="tabpanel">
                                    <div class="panel-body">
                                        <div class="row p-b-5">
                                            <div id="odvBKLDetailRack" class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <div class="panel-body xWBKLBoxFilter">
                                                    <div class="row">
                                                        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 xCNBorderRight">
                                                            <div class="form-group">
                                                                <label class='xCNLabelFrm'><?php echo language('sale/bookinglocker/bookinglocker','tBKLModalLableBranch');?></label>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class='xCNLabelFrm'><?php echo language('sale/bookinglocker/bookinglocker','tBKLModalLableShop');?></label>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class='xCNLabelFrm'><?php echo language('sale/bookinglocker/bookinglocker','tBKLModalLableRack');?></label>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class='xCNLabelFrm'><?php echo language('sale/bookinglocker/bookinglocker','tBKLModalLableLayNo');?></label>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class='xCNLabelFrm'><?php echo language('sale/bookinglocker/bookinglocker','tBKLModalLableSize');?></label>
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                                                            <div class="form-group">
                                                                <label class="m-b-0"><?php echo @$tBKLBchName;?></label>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="m-b-0"><?php echo @$tBKLShpName;?></label>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="m-b-0"><?php echo @$tBKLRakName;?></label>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="m-b-0"><?php echo @$tBKLLayNo;?></label>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="m-b-0"><?php echo @$tBKLPzeName;?></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="odvBKLDetailBooking" class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <div class="panel-body xWBKLBoxFilter">
                                                    <div class="row">
                                                        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 xCNBorderRight">
                                                            <div class="form-group">
                                                                <label class='xCNLabelFrm'><?php echo language('sale/bookinglocker/bookinglocker','tBKLModalLableBkgDocID');?></label>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class='xCNLabelFrm'><?php echo language('sale/bookinglocker/bookinglocker','tBKLModalLableBkgToStart');?></label>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class='xCNLabelFrm'><?php echo language('sale/bookinglocker/bookinglocker','tBKLModalLableBkgUser');?></label>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class='xCNLabelFrm'><?php echo language('sale/bookinglocker/bookinglocker','tBKLModalLableBkgฺBooking');?></label>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class='xCNLabelFrm'><?php echo language('sale/bookinglocker/bookinglocker','tBKLModalLableBkgฺStaBooking');?></label>
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                                                            <div class="form-group">
                                                                <label class="m-b-0"><?php echo @$tBKLBkgDocID;?></label>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="m-b-0"><?php echo @$tBKLBkgToStart;?></label>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="m-b-0"><?php echo @$tBKLBkgUsrName;?></label>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="m-b-0"><?php echo @$tBKLBkgBooking;?></label>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="m-b-0"><?php echo @$tBKLBkgStaBook;?></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row p-t-5">
                                            <div id="odvBKLModalFormBooking" class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                                <!-- Input Form Rental Rate -->
                                                <div class="form-group">
                                                    <label class='xCNLabelFrm'><?php echo language('sale/bookinglocker/bookinglocker','tBKLModalLableRateRetailSize');?></label>
                                                    <div class='input-group'>
                                                        <input type="text" class="form-control xCNHide" id="oetBKLRthCode" name="oetBKLRthCode" maxlength="5" value="<?php echo @$tBkgRthCode;?>">
                                                        <input
                                                            type="text"
                                                            class="form-control xWPointerEventNone"
                                                            id="oetBKLRthName"
                                                            name="oetBKLRthName"
                                                            placeholder="<?php echo language('sale/bookinglocker/bookinglocker','tBKLModalLableRateRetailSizePCH');?>"
                                                            data-validate-required="<?php echo language('sale/bookinglocker/bookinglocker','tBKLModalLableRateRetailSizeValidate');?>"
                                                            value="<?php echo @$tBkgRthName;?>"
                                                            readonly
                                                        >
                                                        <span class='input-group-btn <?php echo $tBKLDisableBrowse;?>'>
                                                            <button id='obtBKLBrowseRentalRate' type='button' class='btn xCNBtnBrowseAddOn <?php echo $tBKLDisableBrowse;?>'>
                                                                <img class='xCNIconFind'>
                                                            </button>
                                                        </span>
                                                    </div>
                                                </div>
                                                <!-- Input Form Cst Refferent -->
                                                <div class="form-group">
                                                    <label class='xCNLabelFrm'><?php echo language('sale/bookinglocker/bookinglocker','tBKLModalLableBkgRefCst');?></label>
                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        id="oetBKLBkgRefCst"
                                                        name="oetBKLBkgRefCst"
                                                        placeholder="<?php echo language('sale/bookinglocker/bookinglocker','tBKLModalLableBkgRefCstPCH');?>"
                                                        data-validate-required="<?php echo language('sale/bookinglocker/bookinglocker','tBKLModalLableBkgRefCstValidate');?>"
                                                        maxlength="20"
                                                        value="<?php echo @$tBKLBkgRefCst;?>"
                                                        <?php echo $tBKLDisableInput;?>
                                                    >
                                                </div>
                                                <!-- Input Form Cst Refferent Document -->
                                                <div class="form-group">
                                                    <label class='xCNLabelFrm'><?php echo language('sale/bookinglocker/bookinglocker','tBKLModalLableBkgRefCstDoc');?></label>
                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        id="oetBKLBkgRefCstDoc"
                                                        name="oetBKLBkgRefCstDoc"
                                                        placeholder="<?php echo language('sale/bookinglocker/bookinglocker','tBKLModalLableBkgRefCstDocPCH');?>"
                                                        data-validate-required="<?php echo language('sale/bookinglocker/bookinglocker','tBKLModalLableBkgRefCstDocValidate');?>"
                                                        maxlength="20"
                                                        value="<?php echo @$tBKLBkgRefCstDoc;?>"
                                                        <?php echo $tBKLDisableInput;?>
                                                    >
                                                </div>
                                                <!-- Input Form Cst Refferent Document -->
                                                <div class="form-group">
                                                    <label class='xCNLabelFrm'><?php echo language('sale/bookinglocker/bookinglocker','tBKLModalLableBkgRefCstLogin');?></label>
                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        id="oetBKLBkgRefCstLogin"
                                                        name="oetBKLBkgRefCstLogin"
                                                        placeholder="<?php echo language('sale/bookinglocker/bookinglocker','tBKLModalLableBkgRefCstLoginPCH');?>"
                                                        data-validate-required="<?php echo language('sale/bookinglocker/bookinglocker','tBKLModalLableBkgRefCstLoginValidate');?>"
                                                        maxlength="50"
                                                        value="<?php echo @$tBKLBkgRefCstLogin;?>"
                                                        <?php echo $tBKLDisableInput;?>
                                                    >
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Modal Response SubScript Booking -->
<div id="odvBKLModalStatusResponse" class="modal fade in" style="overflow: hidden auto; z-index: 3000;">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header xCNModalHead">
                <h3><i class="fa fa-info"></i> <span id="ospBKLBookingHeader"></span></h3>
            </div>
            <div class="modal-body">
                <div class="xCNMessage"></div>
                <div class="clearfix"></div>
                <div class="progress">
                    <div 
                        id="odvBKLLoadingBar"
                        class="progress-bar progress-bar-striped active"
                        role="progressbar"
                        aria-valuenow="100"
                        aria-valuemin="0"
                        aria-valuemax="100"
                        style="width:100%;"
                    >
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include "script/jBookingLockerModalDetail.php";?>