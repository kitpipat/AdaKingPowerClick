<?php
if($aResult['rtCode'] == "1"){
    $tSmgCode       = $aResult['raHDItems']['rtSmgCode'];
    $tSmgTitle      = $aResult['raHDItems']['rtSmgTitle'];
    $aSmgHeadItems  = $aResult['raDTHeadItems'];
    $aSmgEndItems   = $aResult['raDTEndItems'];
    $tRoute         = "slipMessageEventEdit";

    $tUsrAgnCode    = $aResult['raHDItems']['rtAgnCode'];
    $tUsrAgnName    = $aResult['raHDItems']['rtAgnName'];

    $tSMGSpecialCode       = "";
    $tSmgSpecialName      = "";

}else{
    $tSmgCode       = "";
    $tSmgTitle      = "";
    $aSmgHeadItems  = [];
    $aSmgEndItems   = [];
    $tSMGSpecialCode       = "";
    $tSmgSpecialName       = "";
    $tRoute         = "slipMessageEventAdd";

    $tUsrAgnCode    = $this->session->userdata("tSesUsrAgnCode");
    $tUsrAgnName    = $this->session->userdata("tSesUsrAgnName");

}

$tHeadReceiptPlaceholder    = "Head of Receipt";
$tEndReceiptPlaceholder     = "End of Receipt";

?>
<style>
.xWSmgMoveIcon {
    cursor: move !important;
    border-radius: 0px;
    box-shadow: none;
    padding: 0px 10px;
}
.dragged {
    position: absolute;
    opacity: 0.5;
    z-index: 2000;
}
.xWSmgDyForm {
    border-radius: 0px;
    border: 0px;
}
.xWSmgBtn {
    box-shadow: none;
}
.xWSmgItemSelect {
    margin-bottom: 5px;
}
.alert-validate::before,
.alert-validate::after{
    z-index: 100;
}
</style>
<div class="panel panel-headline">
    <div class="panel-body">
        <form class="validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" autocorrect="off" autocapitalize="off" autocomplete="off" id="ofmAddSlipMessage">
            <button style="display:none" type="submit" id="obtSubmitSlipMessage" onclick="JSnAddEditSlipMessage('<?= $tRoute?>')"></button>
            <div class="panel-body"  style="padding-top:20px !important;">

                <div class="row">
                    <!-- อัพโหลดรูปภาพ + เลือกสี Create By : Napat(Jame) 03/12/2020 -->
                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">

                        <!-- <div class="text-center"> -->
                            <?php
                                $tFirtImage = "";
                                if( isset($aResult['aImgItems']) && FCNnHSizeOf($aResult['aImgItems']) > 0 ){
                                    if (!is_null($aResult['aImgItems'][0]['FTImgObj'])) {
                                        $tFirtImage = $aResult['aImgItems'][0]['FTImgObj'];
                                    //   $tImgObj = substr($aResult['aImgItems'][0]['FTImgObj'], 0, 1);
                                    //   if ($tImgObj != '#') {

                                    //       $aValueImg = $aResult['aImgItems'][0];
                                    //       $aValueImg['FTImgObj'] = str_replace('\\','/',$aValueImg['FTImgObj']);
                                    //       $aValueImgExplode = explode('/modules/', $aValueImg['FTImgObj']);
                                    //       $tFullPatch = './application/modules/' . $aValueImgExplode[1];
                                    //       if( file_exists($tFullPatch) ){
                                    //           $tPatchImg = base_url() . 'application/modules/' . $aValueImgExplode[1];
                                    //       } else {
                                    //           $tPatchImg = base_url() . 'application/modules/common/assets/images/200x200.png';
                                    //       }
                                    //   }else{
                                    //       $tPatchImg = base_url() . 'application/modules/common/assets/images/200x200.png';
                                    //   }
                                    }
                                }

                                // echo FCNtHChkImgColor(@$tFirtImage);
                                echo FCNtHGetContentUploadImage(@$tFirtImage,'slipMessage','2');
                                echo FCNtHGetContentTumblrImage(@$aResult['aImgItems'],'slipMessage');
                                echo FCNtHGetContentChooseColor(@$tFirtImage,'slipMessage');

                            ?>
                            <!-- <img id="oimImgMasterslipMessage" src="<?php echo $tPatchImg; ?>" class="img img-respornsive" style="width:100%;cursor:pointer"> -->
                            <!-- <span class="xCNColorslipMessage" style="width:100%;cursor:pointer"></span> -->
                        <!-- </div> -->
                        <!-- <div id="odvImageTumblr" style="padding-top:10px;overflow-x:auto;" class="table-responsive">
                            <table id="otbImageListslipMessage">
                                <tr>
                                    <?php if ( isset($aResult['aImgItems']) && FCNnHSizeOf($aResult['aImgItems']) > 0 ) : ?>
                                        <?php 
                                        foreach ($aResult['aImgItems'] as $nKey => $aValueImg) :
                                            if (isset($aValueImg['FTImgObj']) && !empty($aValueImg['FTImgObj'])) {
                                                $tImgObj = substr($aValueImg['FTImgObj'], 0, 1);
                                        ?>
                                                <input type="hidden" id="ohdImgObj" name="ohdImgObj" data-color="<?php echo $tImgObj; ?>" value="<?php echo $aValueImg['FTImgObj']; ?>">
                                                <input type="hidden" id="ohdImgObjOld" name="ohdImgObjOld" value="">
                                            <?php
                                                if ($tImgObj != '#') {
                                                    $aValueImg['FTImgObj'] = str_replace('\\','/',$aValueImg['FTImgObj']);
                                                    $aValueImgExplode = explode('/modules/', $aValueImg['FTImgObj']);
                                                    $tFullPatch = './application/modules/' . $aValueImgExplode[1];
                                                    if (file_exists($tFullPatch)) {
                                                        $tPatchImg = base_url() . 'application/modules/' . $aValueImgExplode[1];
                                                    } else {
                                                        $tPatchImg = base_url() . 'application/modules/common/assets/images/200x200.png';
                                                    }
                                                } else {
                                                    $tPatchImg = base_url() . 'application/modules/common/assets/images/200x200.png';
                                                }
                                                $aExplodeImg    = explode('/', $aValueImg['FTImgObj']);

                                                $tImageName = FCNnHSizeOf($aExplodeImg) - 1;
                                            ?>
                                            
                                            <td id="otdTumblrslipMessage<?php echo $nKey; ?>" class="xWTDImgDataItem">
                                                <img id="oimTumblrslipMessage<?php echo $nKey; ?>"
                                                     src="<?php echo $tPatchImg; ?>"
                                                     data-img="<?php if (isset($aExplodeImg[$tImageName]) ) { echo trim($aExplodeImg[$tImageName]); } ?>"
                                                     data-tumblr="<?php echo $nKey; ?>"
                                                     class="xCNImgTumblr img img-respornsive"
                                                     style="z-index:100;width:106px;height:67px;"
                                                >
                                                <div class="xCNImgDelIcon" id="odvImgDelBntslipMessage<?php echo $nKey; ?>" data-id="<?php echo $nKey; ?>" style="z-index:500;cursor:pointer;text-align:center;display:none;">
                                                    <i class="fa fa-times" aria-hidden="true"></i> ลบรูป
                                                </div>
                                                <script type="text/javascript">
                                                    $('#oimTumblrslipMessage<?php echo $nKey; ?>').click(function() {
                                                        $('#oimImgMasterslipMessage').attr('src', $(this).attr('src'));
                                                        return false;
                                                    });
                                                    $('#oimTumblrslipMessage<?php echo $nKey; ?>').hover(function() {
                                                        $('#odvImgDelBntslipMessage<?php echo $nKey; ?>').show();

                                                    });
                                                    $('#oimTumblrslipMessage<?php echo $nKey; ?>').mouseleave(function() {
                                                        $('#odvImgDelBntslipMessage<?php echo $nKey; ?>').hide();
                                                    });

                                                    $('#odvImgDelBntslipMessage<?php echo $nKey; ?>').hover(function() {
                                                        $(this).show();
                                                        $('#<?php echo $nKey; ?>').addClass('xCNImgHover');
                                                    });

                                                    $('#odvImgDelBntslipMessage<?php echo $nKey; ?>').mouseleave(function() {
                                                        $(this).hide();
                                                    });

                                                    $('#odvImgDelBntslipMessage<?php echo $nKey; ?>').click(function() {
                                                        JCNxRemoveImgTumblrNEW(this, 'slipMessage');
                                                    });
                                                </script>
                                            </td>
                                            <?php } ?>
                                        
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                    <td>
                                        <input type="hidden" id="oetImgInputslipMessage" name="oetImgInputslipMessage">
                                    </td>
                                </tr>
                            </table>
                        </div> -->
                        <!-- <div class="col-xs-12 col-sm-12 col-md-12 co-lg-12" style="margin-top:15px; text-align:center;">
                            <button type="button" class="btn xCNBTNDefult" id="oimImgInputslipMessage" onclick="JSvImageCallTempNEW('1','2','slipMessage')"><i class="fa fa-picture-o xCNImgButton"></i> <?php echo  language('common/main/main', 'tSelectPic') ?></button>
                        </div> -->

                        <!-- เลือกสี กรณีไม่เลือกรูป default -->
                        <!-- <div class="col-xs-12 col-sm-12" style="margin-top:10%;">
                            <label class="xCNLabelFrm"><span class="text-danger">*</span> <?= language('creditcard/creditcard/creditcard', 'tCDCTBONIMG') ?></label>
                            <div class="xCNCustomRadios">

                                <?php
                                    $aColorStarter = array(
                                        '01' => [ 'RGB' => '#2184c7', 'Title' => 'Blue Light' ],
                                        '02' => [ 'RGB' => '#2f499e', 'Title' => 'Blue' ],
                                        '03' => [ 'RGB' => '#9d4c2e', 'Title' => 'Brown' ],
                                        '04' => [ 'RGB' => '#319845', 'Title' => 'Green' ],
                                        '05' => [ 'RGB' => '#e45b25', 'Title' => 'Orange' ],
                                        '06' => [ 'RGB' => '#582979', 'Title' => 'Purple' ],
                                        '07' => [ 'RGB' => '#ee2d24', 'Title' => 'Red' ],
                                        '08' => [ 'RGB' => '#000000', 'Title' => 'Black' ]
                                    );
                                    foreach($aColorStarter as $nKey => $tValue){
                                ?>
                                    <div title="<?=$tValue['Title']?>">
                                        <input type="radio" id="orbChecked<?=$nKey?>" class="xCNCheckedORB" name="orbChecked" value="<?=$tValue['RGB']?>" data-name="<?=$tValue['RGB']?>">
                                        <label for="orbChecked<?=$nKey?>">
                                            <span style="background-color: <?=$tValue['RGB']?>;">
                                                <img src="<?php echo base_url() . 'application/modules/common/assets/images/icons/check.png'; ?>" alt="Checked Icon" height="20" width="20" />
                                            </span>
                                        </label>
                                    </div>
                                <?php
                                    }
                                ?>

                            </div>
                        </div> -->
                        <!-- end เลือกสี กรณีไม่เลือกรูป default -->

                        <!-- เลือกสี กรณีไม่เลือกรูป -->
                        <!-- <div class="col-xs-12 col-sm-12" style="margin-top:1%;">>
                            <div class="input-group colorpicker-component xCNSltColor">
                                <input class="form-control" type="hidden" id="oetSmgImgColor" name="oetSmgImgColor" maxlength="7" value="#">
                                <span class="input-group-addon" id="ospCiolor"></span>
                                <label class="xCNLabelFrm" style="margin-left: 10px;"><?= language('creditcard/creditcard/creditcard', 'เลือกสีแบบกำหนดเอง') ?></label>
                            </div>
                        </div> -->
                        <!-- end เลือกสี กรณีไม่เลือกรูป  -->

                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-6">


                        <label class="xCNLabelFrm"><span style="color:red">*</span><?php echo language('pos/slipMessage/slipmessage','tSMGCode'); ?></label>
                        <div class="form-group" id="odvSlipmessageAutoGenCode">
                            <div class="validate-input">
                                <label class="fancy-checkbox">
                                    <input type="checkbox" id="ocbSlipmessageAutoGenCode" name="ocbSlipmessageAutoGenCode" checked="true" value="1">
                                    <span><?php echo language('common/main/main', 'tGenerateAuto');?></span>
                                </label>
                            </div>
                        </div>

                        <div class="form-group" id="odvSlipmessageCodeForm">
                            <input type="hidden" id="ohdCheckDuplicateSmgCode" name="ohdCheckDuplicateSmgCode" value="1">
                            <div class="validate-input">
                                <input
                                    type="text"
                                    class="form-control xCNInputWithoutSpcNotThai"
                                    maxlength ="5"
                                    id="oetSmgCode"
                                    name="oetSmgCode"
                                    data-is-created="<?php echo $tSmgCode; ?>"
                                    placeholder ="<?php echo language('pos/slipMessage/slipmessage','tSMGCode'); ?>"
                                    autocomplete="off"
                                    value="<?php echo $tSmgCode;?>"
                                    data-validate-required = "<?php echo language('pos/slipMessage/slipmessage','tSMGValidCode')?>"
                                    data-validate-dublicateCode ="<?php echo language('pos/slipMessage/slipmessage','tSMGValidCodeDup');?>"
                                >
                            </div>
                        </div>

                        <!-- Agency -->
                        <div class="<?php if( !FCNbGetIsAgnEnabled()) : echo 'xCNHide';  endif;?>">
                            <div class="form-group">
                                <label
                                    class="xCNLabelFrm"><?php echo language('common/main/main','tAgency')?></label>
                                <div class="input-group">
                                    <input type="text" class="form-control xCNHide" id="oetSMGUsrAgnCode"
                                        name="oetSMGUsrAgnCode" value="<?=@$tUsrAgnCode?>">
                                    <input type="text" class="form-control xWPointerEventNone" id="oetSMGUsrAgnName"
                                        name="oetSMGUsrAgnName"
                                        placeholder="<?php echo language('common/main/main','tAgency')?>"
                                        value="<?=@$tUsrAgnName?>" readonly>
                                    <span class="input-group-btn">
                                        <button id="obtSMGUsrBrowseAgency" type="button" class="btn xCNBtnBrowseAddOn">
                                            <img
                                                src="<?php echo  base_url().'/application/modules/common/assets/images/icons/find-24.png'?>">
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <!-- end Agency -->

                        <!-- Special message at the end of the bill -->            
                        <div class="form-group xCNHide">
                        <label class="xCNLabelFrm"><span class="text-danger"></span><?php echo language('pos/slipMessage/slipmessage','tSMGSpecialMessage')?></label>
                            <div class="input-group">
                                <input type="text" class="form-control xCNHide" id="oetSMGSpecialCode" name="oetSMGSpecialCode" value="<?=@$tSMGSpecialCode?>">    
                                <input type="text" class="form-control xWPointerEventNone" id="oetSmgSpecialName" name="oetSmgSpecialName" value="<?=@$tSmgSpecialName?>"  readonly>
                            <span class="input-group-btn">
                                <button id="obtSMGBrowseSpecialM" type="button" class="btn xCNBtnBrowseAddOn">
                                    <img src="<?php echo  base_url().'/application/modules/common/assets/images/icons/find-24.png'?>">
                                </button>
                            </span>
                        </div>
                    </div>

                    <!-- End Special message at the end of the bill -->    

                        <div class="form-group">
                            <div class="validate-input">
                            <label class="xCNLabelFrm"><span style="color:red">*</span><?php echo language('pos/slipMessage/slipmessage','tSMGName'); ?></label>
                                <input
                                    type="text"
                                    class="form-control"
                                    maxlength="50"
                                    id="oetSmgTitle"
                                    name="oetSmgTitle"
                                    autocomplete="off"
                                    placeholder ="<?php echo language('pos/slipMessage/slipmessage','tSMGName'); ?>"
                                    value="<?php echo $tSmgTitle;?>"
                                    data-validate-required="<?php echo language('pos/slipMessage/slipmessage','tSMGValidMain');?>"
                                >
                            </div>
                        </div>
                        <label class="xCNLabelFrm"><span style="color:red">*</span><?php echo language('pos/slipMessage/slipmessage','tSMGSlipHead'); ?></label>
                        <div class="xWSmgSortContainer" id="odvSmgSlipHeadContainer">

                            <?php foreach($aSmgHeadItems as $nHIndex => $oHeadItem) : $nHIndex++; ?>
                                <div class="form-group xWSmgItemSelect" id="<?php echo $nHIndex; ?>">
                                    <div class="input-group validate-input">
                                        <span class="input-group-btn">
                                            <div class="btn xWSmgMoveIcon" type="button"><i class="icon-move fa fa-arrows"></i></div>
                                        </span>
                                        <input type="text"
                                               class="form-control xWSmgValidateHead" 
                                               maxlength="50" 
                                               id="oetSmgSlipHead<?php echo $nHIndex; ?>" 
                                               name="oetSmgSlipHead[<?php echo $nHIndex; ?>]" 
                                               value="<?php echo $oHeadItem; ?>" 
                                               placeholder="<?php echo $tHeadReceiptPlaceholder; ?> <?php echo $nHIndex; ?>" >
                                        <span class="input-group-btn">
                                            <img class="xCNIconTable xWIconDelete" src="<?php echo  base_url().'/application/modules/common/assets/images/icons/delete.png'?>" onclick="JSxSlipMessageDeleteRowHead(this, event, <?php echo $nHIndex; ?>)" title="<?php echo language('pos/slipMessage/slipmessage', 'tSMGTBDelete'); ?>">
                                            <!-- <button class="btn pull-right xWSmgBtn xWSmgBtnDelete" onclick="JSxSlipMessageDeleteRowHead(this, event)"><?php echo language('pos/slipMessage/slipmessage','tSMGDeleteRow'); ?></button> -->
                                        </span>
                                    </div>
                                </div>
                            <?php endforeach; ?>

                        </div>
                        <div class="wrap-input100">
                            <p class="text-primary text-right" onclick="JSxSlipMessageAddHeadReceiptRow()" style="margin-right: 25px;cursor: pointer;"><i class="fa fa-plus" style="font-size: 15px;"></i> <strong><?php echo language('pos/slipMessage/slipmessage','tSMGAddRow'); ?></strong></p>
                            <!-- <button type="button" class="btn pull-right xWSmgBtn xWSmgBtnAdd" id="xWSmgAddHeadRow" onclick="JSxSlipMessageAddHeadReceiptRow()"><i class="fa fa-plus"></i> <?php echo language('pos/slipMessage/slipmessage','tSMGAddRow'); ?></button> -->
                        </div>



                        <label class="xCNLabelFrm"><span style="color:red">*</span><?php echo language('pos/slipMessage/slipmessage','tSMGSlipEnd'); ?></label>
                        <div class="xWSmgSortContainer" id="odvSmgSlipEndContainer">

                            <?php foreach($aSmgEndItems as $nEIndex => $oEndItem) : $nEIndex++ ?>
                                <div class="form-group xWSmgItemSelect" id="<?php echo $nEIndex; ?>">
                                    <div class="input-group validate-input">
                                        <span class="input-group-btn">
                                            <div class="btn xWSmgMoveIcon" type="button"><i class="icon-move fa fa-arrows"></i></div>
                                        </span>
                                        <input type="text" 
                                        class="form-control xWSmgValidateDown" 
                                        maxlength="50" id="oetSmgSlipEnd<?php echo $nEIndex; ?>" 
                                        name="oetSmgSlipEnd[<?php echo $nEIndex; ?>]" 
                                        value="<?php echo $oEndItem; ?>" 
                                        placeholder="<?php echo $tEndReceiptPlaceholder; ?> <?php echo $nEIndex; ?>" >
                                        <span class="input-group-btn">
                                            <img class="xCNIconTable xWIconDelete" src="<?php echo  base_url().'/application/modules/common/assets/images/icons/delete.png'?>" onclick="JSxSlipMessageDeleteRowEnd(this, event, <?php echo $nHIndex; ?>)" title="<?php echo language('pos/slipMessage/slipmessage', 'tSMGTBDelete'); ?>">
                                            <!-- <button class="btn pull-right xWSmgBtn xWSmgBtnDelete" onclick="JSxSlipMessageDeleteRowEnd(this, event)"><?= language('pos/slipMessage/slipmessage','tSMGDeleteRow')?></button> -->
                                        </span>
                                    </div>
                                </div>
                            <?php endforeach; ?>

                        </div>
                        <div class="wrap-input100">
                            <p class="text-primary text-right" onclick="JSxSlipMessageAddEndReceiptRow()" style="margin-right: 25px;cursor: pointer;"><i class="fa fa-plus" style="font-size: 15px;"></i> <strong><?php echo language('pos/slipMessage/slipmessage','tSMGAddRow'); ?></strong></p>
                            <!-- <button type="button" class="btn pull-right xWSmgBtn xWSmgBtnAdd" id="xWSmgAddEndRow" onclick="JSxSlipMessageAddEndReceiptRow()"><i class="fa fa-plus"></i> <?php echo language('pos/slipMessage/slipmessage','tSMGAddRow'); ?></button> -->
                        </div>


                    </div>

                </div>

            </div>
        </form>
    </div>
</div>

<div id="odvSmgModalDelTextHead" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header xCNModalHead">
                <label class="xCNTextModalHeard"><?php echo language('common/main/main', 'tModalDelete')?></label>
            </div>
            <div class="modal-body">
                <label style="display: inline-block; word-break:break-all"><?php echo language('pos/slipMessage/slipmessage', 'tSMGconfirmDelTextHead')?> <span id="ospRowDel"></span> ?</label>
            </div>
            <div class="modal-footer">
                <button id="osmConfirmDelSingleHead" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" type="button"><?php echo language('common/main/main', 'tModalConfirm')?></button>
                <button class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"  data-dismiss="modal"><?php echo language('common/main/main', 'tModalCancel')?></button>
            </div>
        </div>
    </div>
</div>

<div id="odvSmgModalDelTextEnd" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header xCNModalHead">
                <label class="xCNTextModalHeard"><?php echo language('common/main/main', 'tModalDelete')?></label>
            </div>
            <div class="modal-body">
                <label style="display: inline-block; word-break:break-all"><?php echo language('pos/slipMessage/slipmessage', 'tSMGconfirmDelTextEnd')?> <span id="ospRowDel"></span> ?</label>
            </div>
            <div class="modal-footer">
                <button id="osmConfirmDelSingleEnd" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" type="button"><?php echo language('common/main/main', 'tModalConfirm')?></button>
                <button class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"  data-dismiss="modal"><?php echo language('common/main/main', 'tModalCancel')?></button>
            </div>
        </div>
    </div>
</div>

<script type="text/html" id="oscSlipHeadRowTemplate">
    <div class="form-group xWSmgItemSelect" id="{0}">
        <div class="input-group validate-input">
            <span class="input-group-btn">
                <div class="btn xWSmgMoveIcon" type="button"><i class="icon-move fa fa-arrows"></i></div>
            </span>
            <input type="text" 
            class="form-control xWSmgValidateHead" 
            maxlength="50" id="oetSmgSlipHead{0}" 
            name="oetSmgSlipHead[{0}]" 
            value="" placeholder="<?php echo 
            $tHeadReceiptPlaceholder; ?> {0}">
            <span class="input-group-btn">
                <img class="xCNIconTable xWIconDelete" src="<?php echo  base_url().'/application/modules/common/assets/images/icons/delete.png'?>" onclick="JSxSlipMessageDeleteRowHead(this, event, {0})" title="<?php echo language('pos/slipMessage/slipmessage', 'tSMGTBDelete'); ?>">
                <!-- <button class="btn pull-right xWSmgBtn xWSmgBtnDelete" onclick="JSxSlipMessageDeleteRowHead(this, event)"><?php echo language('pos/slipMessage/slipmessage','tSMGDeleteRow'); ?></button> -->
            </span>
        </div>
    </div>
</script>
<script type="text/html" id="oscSlipEndRowTemplate">
    <div class="form-group xWSmgItemSelect" id="{0}">
        <div class="input-group validate-input">
            <span class="input-group-btn">
                <div class="btn xWSmgMoveIcon" type="button"><i class="icon-move fa fa-arrows"></i></div>
            </span>
            <input type="text" 
            class="form-control xWSmgValidateDown" 
            maxlength="50" 
            id="oetSmgSlipEnd{0}" 
            name="oetSmgSlipEnd[{0}]" 
            value="" 
            placeholder="<?php echo $tEndReceiptPlaceholder; ?> {0}">
            <span class="input-group-btn">
                <img class="xCNIconTable xWIconDelete" src="<?php echo  base_url().'/application/modules/common/assets/images/icons/delete.png'?>" onclick="JSxSlipMessageDeleteRowEnd(this, event, {0})" title="<?php echo language('pos/slipMessage/slipmessage', 'tSMGTBDelete'); ?>">
                <!-- <button class="btn pull-right xWSmgBtn xWSmgBtnDelete" onclick="JSxSlipMessageDeleteRowEnd(this, event)"><?php echo language('pos/slipMessage/slipmessage','tSMGDeleteRow'); ?></button> -->
            </span>
        </div>
    </div>
</script>

<script src="<?= base_url('application/modules/common/assets/js/jquery.mask.js')?>"></script>
<script src="<?= base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>
<!-- <script src="<?= base_url('application/modules/common/assets/js/bootstrap-colorpicker.min.js') ?>"></script> -->
<?php include 'script/jSlipMessageAdd.php';?>

<script type="text/javascript">
$(function() {
    if(JCNbSlipMessageIsCreatePage()){ // For create page

        // Set head of receipt default
        JSxSlipMessageRowDefualt('head', 1);
        // Set end of receipt default
        JSxSlipMessageRowDefualt('end', 1);

    }else{ // for update page

        if(JCNnSlipMessageCountRow('head') <= 0){
            // Set head of receipt default
            JSxSlipMessageRowDefualt('head', 1);
        }
        if(JCNnSlipMessageCountRow('end') <= 0){
            // Set end of receipt default
            JSxSlipMessageRowDefualt('end', 1);
        }

    }
    JSaSlipMessageGetSortData('head');
    // Remove sort data
    JSxSlipMessageRemoveSortData('all');

    $('#odvSmgSlipHeadContainer').sortable({
        items: '.xWSmgItemSelect',
        opacity: 0.7,
        axis: 'y',
        handle: '.xWSmgMoveIcon',
        update: function(event, ui) {
            var aToArray = $(this).sortable('toArray');
            var aSerialize = $(this).sortable('serialize', {key:".sort"});
            // JSxSlipMessageSetRowSortData('head', aToArray);
            // JSoSlipMessageSortabled('head', true);
        }
    });

    $('#odvSmgSlipEndContainer').sortable({
        items: '.xWSmgItemSelect',
        opacity: 0.7,
        axis: 'y',
        handle: '.xWSmgMoveIcon',
        update: function(event, ui) {
            var aToArray = $(this).sortable('toArray');
            var aSerialize = $(this).sortable('serialize', {key:".sort"});
            // JSxSlipMessageSetRowSortData('end', aToArray);
            // JSoSlipMessageSortabled('end', true);
        }
    });

    $('.xWTooltipsBT').tooltip({'placement': 'bottom'});
    $('[data-toggle="tooltip"]').tooltip({'placement': 'top'});

    $('#oimSmgBrowseProvince').click(function(){
        JCNxBrowseData('oPvnOption');
    });

    if(JCNbSlipMessageIsUpdatePage()){
        $("#obtGenCodeSlipMessage").attr("disabled", true);
    }
});
</script>
<script type="text/javascript">
    // $(document).ready(function() {
    //     $(function() {
    //         $('.xCNSltColor').colorpicker({
    //             align       : 'left',
    //             customClass : 'colorpicker-2x',
    //         });
    //         $('.colorpicker-alpha').remove();
    //     });

    //     $('#oetSmgImgColor').attr("disabled", true);
    //     let tImgObj = $('#ohdImgObj').val();
    //     let tcolor  = $('#ohdImgObj').data('color');
    //     //ตรวจสอบว่าเป็นสีหรือเปล่า
    //     if (tcolor == "#") {
    //         $(".xWTDImgDataItem").remove();
    //         $('#ohdImgObjOld').val(tImgObj);
    //         $('#oimImgMasterslipMessage').removeAttr('src');
    //         $(".xCNColorslipMessage").css({
    //             'height': '230px',
    //             'width': '100%',
    //             'background-color': tImgObj,
    //             'display': 'inline-block'
    //         });

    //         // ตรวจสอบค่า checked ของสี default
    //         switch (tImgObj) {
    //             case '#2184c7': //ฟ้า
    //                 $('#orbChecked01').attr("checked", true);
    //                 break;
    //             case '#2f499e': //น้ำเงิน
    //                 $('#orbChecked02').attr("checked", true);
    //                 break;
    //             case '#9d4c2e': // น้ำตาล
    //                 $('#orbChecked03').attr("checked", true);
    //                 break;
    //             case '#319845': // เขียว
    //                 $('#orbChecked04').attr("checked", true);
    //                 break;
    //             case '#e45b25': // ส้ม
    //                 $('#orbChecked05').attr("checked", true);
    //                 break;
    //             case '#582979': // ม่วง
    //                 $('#orbChecked06').attr("checked", true);
    //                 break;
    //             case '#ee2d24': // แดง
    //                 $('#orbChecked07').attr("checked", true);
    //                 break;
    //             case '#000000': // ดำ
    //                 $('#orbChecked08').attr("checked", true);
    //                 break;
    //             default:
    //                 $('#oetSmgImgColor').val(tImgObj);
    //                 $('#oetSmgImgColor').attr("disabled", true);
    //         }
    //     }

    // });

    // // ยกเลิก checked
    // $("#ospCiolor").click(function() {
    //     $('.xCNCheckedORB').prop('checked', false);
    //     $('#oetSmgImgColor').attr("disabled", false);
    // });

    // //
    // $("#oimImgMasterslipMessage").change(function() {
    //     $("#oimImgMasterslipMessage").css({
    //         'width': ''
    //     });
    // });

    // $("#oetSmgImgColor").change(function() {
    //     let tCodeColor = $(this).val();
    //     $('#oimImgMasterslipMessage').removeAttr('src');
    //     $(".xCNColorslipMessage").css({
    //         'height': '230px',
    //         'width': '100%',
    //         'background-color': tCodeColor,
    //         'display': 'inline-block'
    //     });
    //     $(".xWTDImgDataItem").remove();
    // });

    // //เซต แสดงรูป
    // $("#oimTumblrslipMessage").change(function() {
    //     $("#oimImgMasterslipMessage").css({
    //         'width': ''
    //     });
    // });

    // //แสดงสีแทนรูป เมื่อ Checked
    // $(".xCNCheckedORB").change(function() {
    //     let tNameColor = $(this).data('name');
    //     $(".xCNColorslipMessage").hide();
    //     $(".xWTDImgDataItem").remove();
    //     $("#oimImgMasterslipMessage").css({
    //         'width': ''
    //     });
    //     $("#oimImgMasterslipMessage").css({
    //         'width': '50%'
    //     });
    //     $('#oimImgMasterslipMessage').removeAttr('src');
    //     $(".xCNColorslipMessage").css({
    //         'height': '230px',
    //         'width': '100%',
    //         'background-color': tNameColor,
    //         'display': 'inline-block'
    //     });

    //     $('#oetSmgImgColor').val('#000000');
    //     $('#oetSmgImgColor').attr("disabled", true);
    // });



</script>
<?php include 'script/wSlipMessageScript.php'; ?>
