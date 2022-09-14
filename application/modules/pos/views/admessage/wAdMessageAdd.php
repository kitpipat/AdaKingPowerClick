<?php
if($aResult['rtCode'] == "1"){



    // Data
    $tAdvCode       = $aResult['raItems']['rtAdvCode'];
    $tAdvName       = $aResult['raItems']['rtAdvName'];
    $tAdvMsg        = $aResult['raItems']['rtAdvMsg'];
    $tAdvRmk        = $aResult['raItems']['rtAdvRmk'];
    $tAdvType       = $aResult['raItems']['rtAdvType'];
    $tAdvStaUse     = $aResult['raItems']['rtAdvStaUse'];
    $tAdvSeqNo      = $aResult['raItems']['rtAdvSeqNo'];
    $tAvdStart      = $aResult['raItems']['rtAdvStart'];
    $tAdvStop       = $aResult['raItems']['rtAdvStop'];
    $aAdvMediaItems = $aResult['raMediaItems'];
    $aAdvImageItems = $aResult['raImageItems'];

    $tAdvAgnCode       = $aResult['raItems']['rtAgnCode'];
    $tAdvAgnName       = $aResult['raItems']['rtAgnName'];


    $tRoute         = "adMessageEventEdit";

    //Event Control
	if(isset($aAlwEventAdMessage)){
		if($aAlwEventAdMessage['tAutStaFull'] == 1 || $aAlwEventAdMessage['tAutStaEdit'] == 1){
			$nAutStaEdit = 1;
		}else{
			$nAutStaEdit = 0;
		}
	}else{
		$nAutStaEdit = 0;
	}
	//Event Control

}else{
    // Defualt
    $tAdvCode       = "";
    $aAdvMediaItems = [];
    $aAdvImageItems = [];
    $aAdvEndItems   = [];
    $tAdvName       = "";
    $tAdvMsg        = "";
    $tAdvRmk        = "";
    // $tAvdStart      = "";
    // $tAdvStop       = "";
    $tAdvSeqNo      = "";
    $tAdvType       = 1;
    $tAdvStaUse     = 1;
    $tRoute         = "adMessageEventAdd";

    $tAvdStart      = $dGetDataNow;
    $tAdvStop       = $dGetDataFuture;

    $nAutStaEdit    = 0; //Event Control

    $tAdvAgnCode       = $tSesAgnCode;
    $tAdvAgnName       = $tSesAgnName;

}
?>

<?php

//ประเภท 1:ข้อความต้อนรับ  2:ข้อความประชาสัมพันธ์  3:ภาพเคลื่อนไหว 4.ข้อความขอบคุณ 5:เสียงประชาสัมพันธ์ 6:รูปภาพ

$aAdTypeItems = [
    [
        'value' => 1,
        'text' => language('pos/admessage/admessage', 'tADVWelcomeMessage')
    ],
    [
        'value' => 2,
        'text' => language('pos/admessage/admessage', 'tADVPromotionMessage')
    ],
    [
        'value' => 3,
        'text' => language('pos/admessage/admessage', 'tADVVideo')
    ],
    [
        'value' => 4,
        'text' => language('pos/admessage/admessage', 'tADVThankyou')
    ],
    [
        'value' => 5,
        'text' => language('pos/admessage/admessage', 'tADVSound')
    ],
    [
        'value' => 6,
        'text' => language('pos/admessage/admessage', 'tADVPicture')
    ],

];

$aStaUseItems = [
    [
        'value' => 1,
        'text' => language('pos/admessage/admessage', 'tADVEnabled')
    ],
    [
        'value' => 2,
        'text' => language('pos/admessage/admessage', 'tADVDisabled')
    ]
];

?>

<form class="validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" id="ofmAddAdMessage">
	<button style="display:none" type="submit" id="obtSubmitAdMessage" onclick="JSnAddEditAdMessage('<?php echo $tRoute?>')"></button>
    <div class="panel-body" style="padding-top:20px !important;">
        <div class="row">
            <div class="col-xs-12 col-md-5 col-lg-5">
                <label class="xCNLabelFrm"><span class="text-danger">*</span> <?= language('pos/admessage/admessage','tADVTBCode')?></label>
                <div id="odvAdvAutoGenCode" class="form-group">
                    <div class="validate-input">
                        <label class="fancy-checkbox">
                            <input type="checkbox" id="ocbAdvAutoGenCode" name="ocbAdvAutoGenCode" checked="true" value="1">
                            <span> <?php echo language('common/main/main', 'tGenerateAuto'); ?></span>
                        </label>
                    </div>
                </div>

                <div class="form-group" id="odvAdvCodeForm">
                    <input type="hidden" id="ohdCheckDuplicateAdvCode" name="ohdCheckDuplicateAdvCode" value="1">
                    <div class="validate-input">
						<input
							type="text"
							class="form-control xCNInputWithoutSpcNotThai"
							maxlength="5"
							id="oetAdvCode"
							name="oetAdvCode"
							data-is-created="<?php echo $tAdvCode; ?>"
							placeholder="<?= language('pos/admessage/admessage','tADVTBCode')?>"
							value="<?php echo $tAdvCode; ?>"
							data-validate-required = "<?php echo language('pos/admessage/admessage','tRCVValidCode')?>"
							data-validate-dublicateCode = "<?php echo language('pos/admessage/admessage','tRCVValidCodeDup')?>"
						>
					</div>
                </div>

                <?php
                    // $tAdvAgnCode       = "";
                    // $tAdvAgnName       = "";

                    if($tRoute == "adMessageEventAdd"){
                        $tAdvAgnCode   = $tSesAgnCode;
                        $tAdvAgnName   = $tSesAgnName;
                        $tDisabled     = '';
                        $tNameElmIDAgn = 'oimBrowseAgn';
                    }else{

                        $tAdvAgnCode    = $tAdvAgnCode;
                        $tAdvAgnName    = $tAdvAgnName;
                        $tDisabled      = '';
                        $tNameElmIDAgn  = 'oimBrowseAgn';
                    }

                ?>


                <!-- เพิ่ม AD Browser -->
                <div class="form-group  <?php if( !FCNbGetIsAgnEnabled()) : echo 'xCNHide';  endif;?>">
                    <label class="xCNLabelFrm"><span style="color:red">*</span><?php echo language('pos/admessage/admessage','tADVAgency')?></label>
                    <div class="input-group"><input type="text" class="form-control xCNHide" id="oetAdvAgnCode" name="oetAdvAgnCode" maxlength="5" value="<?=$tAdvAgnCode;?>">
                    <input type="text" class="form-control xWPointerEventNone" id="oetAdvAgnName" name="oetAdvAgnName"
                        maxlength="100" placeholder="<?php echo language('interface/connectionsetting/connectionsetting','tTBAgency')?>" value="<?=$tAdvAgnName;?>"
                        data-validate-required = "<?php echo language('interface/connectionsetting/connectionsetting','tValiAgency')?>"
                        readonly>
                        <span class="input-group-btn">
                            <button id="<?=@$tNameElmIDAgn;?>" type="button" class="btn xCNBtnBrowseAddOn <?=@$tDisabled?>">
                                <img src="<?php echo  base_url().'/application/modules/common/assets/images/icons/find-24.png'?>">
                            </button>
                        </span>
                    </div>
                </div>

				<div class="form-group">
					<div class="validate-input">
						<label class="xCNLabelFrm"><span style="color:red">*</span><?php echo language('pos/admessage/admessage','tADVTBName')?></label>
						<input
							type="text"
							class="form-control"
							maxlength="200"
							id="oetAdvName"
							name="oetAdvName"
                            placeholder="<?= language('pos/admessage/admessage','tADVTBName')?>"
							value="<?php echo $tAdvName?>"
							data-validate-required="<?php echo language('pos/admessage/admessage','tRCVValidName')?>"
						>
					</div>
				</div>

                <div id="odvAdTypeContainer">
                    <div class="form-group">
                        <label class="xCNLabelFrm"><?= language('pos/admessage/admessage','tADVType')?></label>
                        <?php if($aResult['rtCode'] == 1) : ?>
                        <!-- หน้าแก้ไขข้อมูล -->
                        <select class="selectpicker form-control" id="oetAdvMediaType" name="oetAdvMediaType" onchange="JSxSelectAdType(this, event)" readonly="readonly">
                            <?php foreach($aAdTypeItems as $aAdTypeItem) : ?>
                                <?php if($aAdTypeItem['value'] == $tAdvType) : ?>
                                    <option  value="<?=$aAdTypeItem['value']?>" selected="true"><?=$aAdTypeItem['text']?></option>
                                <?php else : ?>
                                    <option  disabled value="<?=$aAdTypeItem['value']?>"><?=$aAdTypeItem['text']?></option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                    <?php else:?>
                    <!-- หน้าเพิ่มข้อมูล -->
                        <select class="selectpicker form-control" id="oetAdvMediaType" name="oetAdvMediaType" onchange="JSxSelectAdType(this, event)" readonly="readonly">
                            <?php foreach($aAdTypeItems as $aAdTypeItem) : ?>
                                <?php if($aAdTypeItem['value'] == $tAdvType) : ?>
                                    <option  value="<?=$aAdTypeItem['value']?>" selected="true"><?=$aAdTypeItem['text']?></option>
                                <?php else : ?>
                                    <option  value="<?=$aAdTypeItem['value']?>"><?=$aAdTypeItem['text']?></option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>

                    <?php endif; ?>
                </div>
            </div>

                <!------------------------------------------- เพิ่มช่วงว ัน-เวลา ----------------------------------------------->

                <!-- <div class="form-group row">        -->
                <div class="form-group row">
                    <div class ="col-md-6">
                        <div class="validate-input">
                            <label class="xCNLabelFrm"><?php echo language('product/pdtnoslebyevn/pdtnoslebyevn','tEVNFrmDStart')?></label>
                            <div class="input-group">
                                <input type="text" class="form-control xCNDatePicker xCNInputMaskDate" id="oetAdvStart" name="oetAdvStart" autocomplete="off"
                                value="<?php if($tAvdStart != ""){ echo $tAvdStart;}else{echo $tAvdStart;}?>"
                                data-validate="<?php echo language('product/pdtnoslebyevn/pdtnoslebyevn','tEVNValidDStart')?>">
                                <span class="input-group-btn">
                                    <button id="obtAdvStartDate" type="button" class="btn xCNBtnDateTime">
                                        <img src="<?php echo base_url().'/application/modules/common/assets/images/icons/icons8-Calendar-100.png'?>">
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="validate-input">
                            <label class="xCNLabelFrm"><?php echo language('product/pdtnoslebyevn/pdtnoslebyevn','tEVNFrmDFinish')?></label>
                            <div class="input-group">
                                <input type="text" class="form-control xCNDatePicker xCNInputMaskDate" id="oetAdvFinish" name="oetAdvFinish" autocomplete="off"
                                value="<?php if($tAdvStop != ""){ echo $tAdvStop;}else{echo $tAdvStop;}?>"
                                data-validate="<?php echo language('product/pdtnoslebyevn/pdtnoslebyevn','tEVNValidDFinish')?>">
                                <span class="input-group-btn">
                                    <button id="obtAdvFinishDate" type="button" class="btn xCNBtnDateTime">
                                        <img src="<?php echo base_url().'/application/modules/common/assets/images/icons/icons8-Calendar-100.png'?>">
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- <div class="form-group row">
                    <div class="col-md-6">
                        <div class="wrap-input100 validate-input" data-validate="<?= language('product/pdtnoslebyevn/pdtnoslebyevn','tEVNValidTStart')?>">
                            <label class="xCNLabelFrm"><?= language('product/pdtnoslebyevn/pdtnoslebyevn','tEVNFrmTStart')?></label>
                            <input type="text" class="input100 xCNTimePicker xCNInputMaskTime" id="oetEvnTStart" name="oetEvnTStart" value="<?php echo $tAvdStart;?> ">
                            <span class="focus-input100"></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="wrap-input100 validate-input" data-validate="<?= language('product/pdtnoslebyevn/pdtnoslebyevn','tEVNValidTFinish')?>">
                            <label class="xCNLabelFrm"><?= language('product/pdtnoslebyevn/pdtnoslebyevn','tEVNFrmTFinish')?></label>
                            <input type="text" class="input100 xCNTimePicker xCNInputMaskTime" id="oetEvnTFinish" name="oetEvnTFinish" value="<?php echo $tAdvStop;?>">
                            <span class="focus-input100"></span>
                        </div>
                    </div>
                </div> -->

            <!-- ------------------------------------------------------------------------------------- -->
                <div class="form-group">
					<label class="xCNLabelFrm"><?= language('pos/admessage/admessage','tADVStatus')?></label>
					<select class="selectpicker form-control" id="ocmAdvStatus" name="ocmAdvStatus" maxlength="1">
                        <?php foreach($aStaUseItems as $aStaUseItem) : ?>
                            <?php if($tAdvStaUse == $aStaUseItem['value']) : ?>
                                <option value="<?=$aStaUseItem['value']?>" checked><?=$aStaUseItem['text']?></option>
                            <?php else : ?>
                                <option value="<?=$aStaUseItem['value']?>"><?=$aStaUseItem['text']?></option>
                            <?php endif; ?>
                        <?php endforeach; ?>
					</select>
				</div>

                <div class="form-group">
                    <label class="xCNLabelFrm"><?= language('pos/admessage/admessage','tADVRemark')?></label>
                    <textarea class="form-control" maxlength="100" rows="4" id="otaAdvRemark" name="otaAdvRemark"><?= $tAdvRmk?></textarea>
                </div>

            </div>

            <div class="col-xs-12 col-md-7 col-lg-7">

                <!-- input message -->
                <div id="odvTextTypeContainer">
                    <div class="form-group">
                        <label class="xCNLabelFrm"><span class="text-danger">*</span> <?= language('pos/admessage/admessage','tADVMessage')?></label>
                        <input type="text" class="form-control" maxlength="100" id="oetAdvMsg" name="oetAdvMsg" value="<?= $tAdvMsg?>" data-validate="<?= language('pos/admessage/admessage','tRCVValidName')?>">
                    </div>
                </div>

                <!-- input media -->
                <div id="odvMediaTypeContainer" style="display: none;">

                    <div class="col-xs-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            <button id="xWAdvAddHeadRow" onclick="JSxAddMediaRow()" class="btn pull-right xCNBTNDefult xCNBTNDefult2Btn xWAdvBtn xWAdvBtnAdd" style="margin-bottom:10px;" type="button"><i class="fa fa-plus"></i> <?= language('pos/admessage/admessage','tADVAddRow')?></button>
                            <!-- <a href="javascipt:;" class="btn pull-right xWAdvBtn xWAdvBtnAdd" id="xWAdvAddHeadRow" onclick="JSxAddMediaRow()"><i class="fa fa-plus"></i> <?= language('pos/admessage/admessage','tADVAddRow')?></a> -->
                        </div>
                    </div>

                    <style>
                        .xWAdvSortContainer { list-style-type: none; margin: 0; padding: 10; width: 100%; }
                        .xWAdvSortContainer li { float: left; padding: 5px; margin: 0;}
                    </style>

                    <div class="col-xs-12 col-md-12 col-lg-12" style="overflow-x:hidden;overflow-y:auto;" data-validate="Please Insert Media"> <!--height:300px;-->
                        <label class="xCNLabelFrm"><?= language('pos/admessage/admessage','tFileMaxValue')?></label>
                        <ul class="xWAdvSortContainer" id="odvAdvMediaContainer">
                                <?php foreach($aAdvMediaItems as $nMediaIndex => $oMediaItem) : $nMediaIndex++; ?>
                                    <li class="ui-state-default xWAdvItemSelect" style="width: <?php if($tAdvType == '3'){ echo '50%'; }else if($tAdvType == '5'){ echo '100%'; }?>">
                                        <div class="well well-sm" style="margin:0px;">
                                            <div class="xWMediaDisplay">
                                                <?php
                                                    // if(isset($oMediaItem['FTMedPath']) && !empty($oMediaItem['FTMedPath'])){

                                                    //     $aValueImgExplode = explode('/modules/',$oMediaItem['FTMedPath']);
                                                    //     $tFullPatch = './application/modules/'.$aValueImgExplode[1];
                                                    //     if (file_exists($tFullPatch)){
                                                    //         $tPatchFile = base_url().'application/modules/'.$aValueImgExplode[1];
                                                    //     }else{
                                                    //         $tPatchFile = base_url().'application/modules/common/assets/images/200x200.png';
                                                    //     }
                                                    // }else{
                                                    //     $tPatchFile  =   base_url().'application/modules/common/assets/images/200x200.png';
                                                    // }
                                                    // $aExplodeImg    = explode('/',$oMediaItem['FTMedPath']);

                                                    $tPatchFile = $oMediaItem['FTMedPath'];
                                                ?>

                                                <?php if(isset($tAdvType) && $tAdvType == '3'){ ?>
                                                    <video controls style="width:100%;">
                                                        <source src="<?=$tPatchFile?>" type="video/mp4">
                                                    </video>
                                                <?php }else if(isset($tAdvType) && $tAdvType == '5'){ ?>
                                                    <audio controls style="width:100%;">
                                                        <source src="<?=$tPatchFile?>" type="audio/mpeg">
                                                    </audio>
                                                <?php } ?>
                                            </div>

                                            <div class="input-group xWAdvItem old" id="<?=$nMediaIndex?>">
                                                <span class="input-group-btn">
                                                    <div class="btn xCNBtnGenCode xWAdvMoveIcon">
                                                        <i class="icon-move fa fa-arrows"></i>
                                                    </div>
                                                </span>
                                                <input type="text" class="form-control xWAdvFile" readonly="" value="<?php if(isset($oMediaItem['FTMedPath'])){ print_r($oMediaItem['FTMedPath']); } ?>">
                                                <label class="input-group-btn">
                                                    <div class="btn xCNBtnPrimeryAddOn" style="font-size:18px;">
                                                        <input
                                                                accesskey=""
                                                                type="file"
                                                                seq="<?=$nMediaIndex?>"
                                                                media-id="<?=$oMediaItem['FNMedID']?>"
                                                                id="oetAdvMedia<?=$nMediaIndex?>"
                                                                class="xWAdvMedia"
                                                                data-key="<?=$oMediaItem['FTMedKey']?>"
                                                                name="oetAdvMedia[<?=$nMediaIndex?>]"
                                                                style="position: absolute;clip: rect(0px, 0px, 0px, 0px);"
                                                                onchange="JSxChangedFile(this, event)"> <?= language('pos/admessage/admessage','tSelectFile')?>
                                                    </div>
                                                </label>
                                                <span class="input-group-btn">
                                                    <button class="btn xCNBtnGenCode" style="font-size:18px;" type="button" onclick="JSxDeleteMediaRow(this, event)">
                                                        <?= language('pos/admessage/admessage','tADVDeleteRow')?>
                                                    </button>
                                                </span>
                                            </div>
                                        </div>
                                    </li>
                                <?php endforeach; ?>
                        </ul>
                        <span class="focus-input100"></span>

                    </div>
                </div>

                <!-- input Image -->
                <div id="odvImageTypeContainer" style="display: none;">

                    <style>
                        .xWADMImgParent{
                            position : relative;
                            float: left;
                            margin-right:10px;
                            margin-bottom:10px;
                            width : 300px;
                            height: 300px;
                        }

                        .xWADMImgChild{
                            position : absolute;

                            top: 0 ;
                            right: 0 ;
                            bottom : 0 ;
                            left : 0 ;

                            margin : auto;

                            width:150px;
                            height:150px;

                            text-align:center;
                            line-height:150px;
                        }
                        .xWADMImgStyle{
                            width: 100%;
                            height: 100%;
                            background-size:contain;
                            background-repeat:no-repeat;
                            background-position:center;
                            display:block;
                            margin:0px auto;
                        }
                    </style>

                    <div class="col-xs-12 col-md-12 col-lg-12" style="margin-bottom:15px;">
                        <div class="form-group">
                            <?php echo FCNtHGetContentUploadImage('','Product','3'); ?>
                            <!-- <div class="xCNUplodeImage">	<input type="text" class="xCNHide" id="ohdRetionCropper" name="ohdRetionCropper" value="16/9"> 	<input type="text" class="xCNHide" id="oetImgInputProductOld" name="oetImgInputProductOld" value=""> 	<input type="text" class="xCNHide" id="oetImgInputProduct" name="oetImgInputProduct" value=""> 	<input style="display:none;" type="file" id="oetInputUplodeProduct" onchange="JSxImageUplodeResizeNEW(this,'','Product','3')" accept="image/*"> 	<button class="btn xCNBTNDefult" type="button" onclick="$('#oetInputUplodeProduct').click()"><i class="fa fa-picture-o xCNImgButton"></i> เลือกรูป</button> </div>
                            <div id="odvModalCropProduct"></div> -->
                            <!-- <button type="button" class="btn xCNBTNDefult pull-right xWChangImgSize" onclick="JSxImageUplodeResizeNEW(this,'','Product','')"><i class="fa fa-camera"></i> <?= language('common/main/main','tSelectPic')?></button> -->

                            <!-- <button type="button" class="btn xCNBTNDefult pull-right xWChangImgSize" onclick="JSvImageCallTempNEW('1','3','Product')"><i class="fa fa-camera"></i> <?= language('common/main/main','tSelectPic')?></button> -->
                        </div>
                    </div>

                    <div id="odvImageListProduct">
                        <?php foreach($aAdvImageItems as $nImageIndex => $oImageItem) : $nImageIndex++; ?>
                            <?php
                                // if(isset($oImageItem['FTImgObj']) && !empty($oImageItem['FTImgObj'])){

                                //     $aValueImgExplode = explode('/modules/',$oImageItem['FTImgObj']);
                                //     $tFullPatch = './application/modules/'.$aValueImgExplode[1];
                                //     if (file_exists($tFullPatch)){
                                //         $tPatchImg = base_url().'application/modules/'.$aValueImgExplode[1];
                                //     }else{
                                //         $tPatchImg = base_url().'application/modules/common/assets/images/200x200.png';
                                //     }
                                // }else{
                                //     $tPatchImg  =   base_url().'application/modules/common/assets/images/200x200.png';
                                // }
                                // $aExplodeImg    = explode('/',$oImageItem['FTImgObj']);
                                // print_r(substr($oImageItem['FTImgObj'],0,1));
                                // var_dump($oImageItem['FTImgObj']);
                                // $tImage = $oImageItem['FTImgObj'];
                                $tPatchImg = FCNtHChkImgColor($oImageItem['FTImgObj']);
                            ?>

                            <!-- <div id="odvADMTumblrProduct<?=$nImageIndex?>" class="xWADMImgDataItem xWADMImgParent">
                                <div id="odvTumblrProduct<?=$nImageIndex?>"
                                    class="thumbnail xWADMImg xWADMImgStyle"
                                    data-tumblr="<?=$nImageIndex?>"
                                    style="background-image:url(<?=$tPatchImg?>);"></div>
                                <div class="xWADMImgChild xWADMImgDel" style="display:none;">
                                    <button type="button" class="btn xCNBTNDefult xCNBTNDefult2Btn xWADMBtnImgDel"><?php echo language('common/main/main', 'tDelMutiImg');?></button>
                                </div>
                            </div> -->

                            <div id="odvADMTumblrProduct<?=$nImageIndex?>" class="xWADMImgDataItem xWADMImgParent">
                            <div id="oimTumblrProduct<?=$nImageIndex?>" class="thumbnail xWADMImg xWADMImgStyle" data-tumblr="<?=$nImageIndex?>" style="background-image: url('<?=$tPatchImg?>');"></div>
                            <input type="hidden" id="oetTumblrProduct<?=$nImageIndex?>" name="oetTumblrProduct<?=$nImageIndex?>" class="xWImgCanvas" value="<?=$tPatchImg?>">
                            <div class="xWADMImgChild xWADMImgDel" style="display: block;">
                                <button class="btn xCNBTNDefult xCNBTNDefult2Btn xWADMBtnImgDel" type="button"><?php echo language('common/main/main', 'tDelMutiImg');?></button>
                            </div>
                        </div>

                        <?php endforeach; ?>


                    </div>

                    <!-- <div style="clear:both"></div> -->

                    <!-- <table id="otbImageListProduct">
                        <tr>
                            <td>
                                <input type="hidden" id="oetImgInputProduct" name="oetImgInputProduct">
                            </td>
                        </tr>
                    </table> -->
                </div>

            </div>
        </div>
    </div>
</form>

<script src="<?= base_url('application/modules/common/assets/js/jquery.mask.js')?>"></script>
<script src="<?= base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>
<?php  include 'script/jAdMessageAdd.php';?>

<script type="text/html" id="oscAdvMediaTemplate">
    <li class="ui-state-default xWAdvItemSelect">
        <div class="form-group well well-sm" style="margin:0px;">
            <div class="input-group xWAdvItem change-file" id="{0}">
                <span class="input-group-btn">
                    <div class="btn xCNBtnGenCode xWAdvMoveIcon">
                        <i class="icon-move fa fa-arrows"></i>
                    </div>
                </span>
                <input type="text" class="form-control xWAdvFile" readonly="">
                <label class="input-group-btn">
                    <div class="btn xCNBtnPrimeryAddOn" style="font-size:18px;">
                    <!--accept="audio/mp3,audio/*;"-->
                    <!-- accept="video/mp4,video/x-m4v,video/*;" -->
                        <input
                                accesskey=""
                                type="file"
                                id="oetAdvMedia{0}"
                                class="xWAdvMedia"
                                name="oetAdvMedia[{0}]"
                                multiple=""
                                data-key=""
                                style="position: absolute;clip: rect(0px, 0px, 0px, 0px);"
                                onchange="JSxChangedFile(this, event)"> <?= language('pos/admessage/admessage','tSelectFile')?>
                    </div>
                </label>
                <span class="input-group-btn">
                    <button class="btn xCNBtnGenCode" style="font-size:18px;" type="button" onclick="JSxDeleteMediaRow(this, event)">
                        <?= language('pos/admessage/admessage','tADVDeleteRow')?>
                    </button>
                </span>
            </div>
        </div>
    </li>
</script>

<script type="text/javascript">

$('.selectpicker').selectpicker();
$(function() {

    if(!JCNbIsCreatePage()){ // Update page, Disabled select adtype
        // $('#odvAdTypeContainer select').prop('disabled', true);
        if(JCNbIsTextType()){ // 1:Welcome Message, 2:Promotion Message, 4:Thank You
            JSxVisibledTextType(true);
            JSxVisibledMediaType(false);
            JSxVisibledImageType(false);
        }
        if(JCNbIsMediaType()){ // 3:Video, 5:Sound
            JSxVisibledMediaType(true);
            JSxVisibledTextType(false);
            JSxVisibledImageType(false);
        }
        if(JCNbIsImageType()){
            JSxVisibledImageType(true);
            JSxVisibledMediaType(false);
            JSxVisibledTextType(false);
        }
        if(JCNnCountMediaRow() <= 0){
            JSxMediaRowDefualt(1);
        }
    }

    $('#odvAdvMediaContainer').sortable({
        // items: '.xWAdvItemSelect',
        // opacity: 0.7,
        // axis: 'y',
        // handle: '.xWAdvMoveIcon, .well', //, #xWAdvAddHeadRow
        connectWith: "li",
        update: function(event, ui) {
            // console.log('sortable');
            var aToArray    = $(this).sortable('toArray');
            var aSerialize  = $(this).sortable('serialize', {key:".sort"});

            // console.log('aToArray : ');
            // console.log(aToArray);
            // console.log('aSerialize : ');
            // console.log(aSerialize);

            JSoMediaSortabled(true);
        }
    }).disableSelection();

    $('.xWTooltipsBT').tooltip({'placement': 'bottom'});
    $('[data-toggle="tooltip"]').tooltip({'placement': 'top'});

    $('#oimAdvBrowseProvince').click(function(){
        JCNxBrowseData('oPvnOption');
    });

});


// ***************
    $(document).on('hide.bs.modal','#odlModalTempImgProduct', function () {
        FSxADMImgHoverEvent();
    });

    $(document).ready(function(){

        let tTypeMedia = $('#oetAdvMediaType').val();
        switch (tTypeMedia) {
            case '3':
                $('.xWAdvMedia').attr('accept', 'video/mp4,video/x-m4v,video/*;');
                break;
            case '5':
                $('.xWAdvMedia').attr('accept', 'audio/mp3,audio/*;');
                break;
        }

        FSxADMImgHoverEvent();

        $('.xCNSelectBox').selectpicker();

         $('#obtAdvStartDate').click(function(event){
            $('#oetAdvStart').datepicker({
                format: "yyyy-mm-dd",
                todayHighlight: true,
                enableOnReadonly: false,
                startDate :'1900-01-01',
                disableTouchKeyboard : true,
                autoclose: true,
            });
            $('#oetAdvStart').datepicker('show');
            event.preventDefault();
        });

        $('.xCNDatePicker').datepicker({
            format                  : "yyyy-mm-dd",
            enableOnReadonly        : false,
            startDate               : $('#oetAdvStart').val(),
            minDate                 : $('#oetAdvStart').val(),
            disableTouchKeyboard    : true,
            autoclose               : true
        });

        $('#obtAdvStartDate').click(function(event){
            $('#oetAdvStart').datepicker('show');
            event.preventDefault();
        });

        $('#obtAdvFinishDate').click(function(event){
            $('#oetAdvFinish').datepicker('show');
            event.preventDefault();
        });
    });

    function FSxADMImgHoverEvent(){
        $('.xWADMImgDataItem').off();
        $('.xWADMImgDataItem').hover(
            function() {
                $(this).find('.xWADMImg').fadeTo("fast", 0.33);
                $(this).find('.xWADMImgDel').css('display','block');
            }, function() {
                $(this).find('.xWADMImg').fadeTo("fast", 1);
                $(this).find('.xWADMImgDel').css('display','none');
            }
        );
        $('.xWADMBtnImgDel').off();
        $('.xWADMBtnImgDel').click(function(){
            var aPdtImg = [];
            // $('.xWADMImg').each(function(){
            //     aPdtImg.push($(this).data('img'));
            // });
            $('.xWImgCanvas').each(function(){
                aPdtImg.push($(this).val());
            });

            if(aPdtImg.length > 1){
                if(confirm('Delete ?')){
                    $('#odvADMTumblrProduct'+$(this).parent().parent().find('.xWADMImg').data('tumblr')).remove();
                }
            }
        });
    }


    $('.xCNTimePicker').datetimepicker({
        format: 'HH:mm:ss'
    });


</script>
