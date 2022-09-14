<?php
    if($aResult['rtCode'] == 1){
        $tAPICode     = $aResult['raItems']['FTApiCode'];
        $tApiGrpSeq   = $aResult['raItems']['FNApiGrpSeq'];
        $tApiGrpPro   = $aResult['raItems']['FTApiGrpPrc'];
        $tApiName     = $aResult['raItems']['FTApiName'];
        $tApiURL      = $aResult['raItems']['FTApiURL'];
        $tApiFmtCode  = $aResult['raItems']['FTApiFmtCode'];

        $tRoute       = "ConnSetGenEventEdit";
    }else{

        $tAPICode    = "";
        $tApiGrpPro  = "";
        $tApiName    = "";
        $tApiURL     = "";
        $tApiFmtCode = "";

        $tRoute      = "ConnSetGenEventAdd";
    }
?>

<div class="row">
    <div class="col-xs-8 col-md-4 col-lg-4" style="padding:0px;margin-bottom:0px;padding-left:0px;margin-right:0px;">
        <label class="xCNLabelFrm" style="color: #179bfd !important; cursor:pointer;" onclick="JSxCallGetConGeneral();" ><?php echo language('interface/conSettingGenaral/consettinggenaral','tConditionAPI')?></label>
        <label class="xCNLabelFrm">
        <label class="xCNLabelFrm xWPageAdd" style="color: #aba9a9 !important;"> / <?php echo language('interface/conSettingGenaral/consettinggenaral','tGenaralAuthor')?> </label> 
    </div>
</div><br>

<!-- Panel Show -->
<div id="odvSetGenMenuShow" class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 alert alert-info" style="padding:30px;margin-bottom:0px;padding-left:10px;margin-right:15px;">
        <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
            <label class="xCNLabelFrm"><?=language('interface/conSettingGenaral/consettinggenaral','tConSetGenGroup')?> : </label>
            <label class="radio-inline"><?=$tApiGrpPro;?></label>
        </div>
        <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
            <label class="xCNLabelFrm"><?=language('interface/conSettingGenaral/consettinggenaral','tConSetGenDetail')?> : </label>
            <label class="radio-inline"><?=$tApiName;?></label>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <label class="xCNLabelFrm"><?=language('interface/conSettingGenaral/consettinggenaral','tConSetGenAPIURL')?> : </label>
            <label class="radio-inline"><?=@$tApiURL;?></label>
        </div>

        <input type="hidden" id="oetApiCode" name="oetApiCode" value="<?=@$tAPICode;?>">
        <input type="hidden" id="oetApiSeq" name="oetApiSeq" value="<?=@$tApiGrpSeq;?>">
        <input type="hidden" id="oetApiUrl" name="oetApiUrl" value="<?=@$tApiURL;?>">
        <input type="hidden" id="oetFmtCode" name="oetFmtCode" value="<?=@$tApiFmtCode;?>">

    </div>
</div><br>

<!-- TABLE สำหรับ checkbox -->
<div class="row">
    <div class="col-xs-8 col-md-4 col-lg-4" style="padding:0px;margin-bottom:0px;padding-left:0px;margin-right:0px;">
        <label></label>
        <div class="form-group"> <!-- เปลี่ยน From Imput Class -->
            <div class="input-group">
                <input type="text" 
                    class="form-control xCNInputWithoutSingleQuote" 
                    id="oetSearchAllGanPage" 
                    name="oetSearchAllGanPage" 
                    placeholder="<?php echo language('interface/connectionsetting/connectionsetting','tSearch')?>"
                    value="<?=$tSearchApiAuthor;?>">
                <span class="input-group-btn">
                    <button id="oimSearchSetGenPage" class="btn xCNBtnSearch" type="button">
                        <img class="xCNIconAddOn" src="<?php echo base_url().'/application/modules/common/assets/images/icons/search-24.png'?>">
                    </button>
                </span>
            </div>
        </div>
    </div><br>

    <div class="col-md-8 text-right">                    
        <button id="obtSetGanPage" name="obtSetGanPage" class="xCNBTNPrimeryPlus" type="button" style="margin-left: 20px; margin-top: 0px;" onclick="JSvCallPageAddSetGanaral()">+</button>
    </div>
</div>

<div class="row">
    <div class="col-md-12" style="padding:0px;margin-bottom:0px;padding-left:0px;margin-right:0px;">
        <input type="hidden" id="nCurrentPageTB" value="<?=@$nCurrentPage;?>">
        <div class="table-responsive">
            <table id="otbDataList" class="table table-striped">
                <thead>
                    <tr>
                        <th nowrap class="xCNTextBold text-center" style="width:3%;"><?php echo language('interface/conSettingGenaral/consettinggenaral','tGenaralSeq'); ?></th>
                        <th nowrap class="xCNTextBold text-center" style="width:10%;"><?php echo language('interface/conSettingGenaral/consettinggenaral','tGanAgancy'); ?></th>
                        <th nowrap class="xCNTextBold text-center" style="width:10%;"><?php echo language('interface/conSettingGenaral/consettinggenaral','tGanBranch'); ?></th>
                        <th nowrap class="xCNTextBold text-center" style="width:10%;"><?php echo language('interface/conSettingGenaral/consettinggenaral','tGanApiUserName'); ?></th>
                        <th nowrap class="xCNTextBold text-center" style="width:10%;"><?php echo language('interface/conSettingGenaral/consettinggenaral','tGanApiUserPw'); ?></th>
                        <th nowrap class="xCNTextBold text-center" style="width:10%;"><?php echo language('interface/conSettingGenaral/consettinggenaral','tGanApiKey'); ?></th>
                        <th nowrap class="xCNTextBold text-center" style="width:5%;"><?php echo language('interface/conSettingGenaral/consettinggenaral','tGanDelete'); ?></th>
                        <th nowrap class="xCNTextBold text-center" style="width:5%;"><?php echo language('interface/conSettingGenaral/consettinggenaral','tGanEdit'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if($aDataApi['rtCode'] == 1 ):?>
                        <?php foreach($aDataApi['raItems'] AS $key=>$aValue){ ?>
                            <tr>
                                <td class="text-center"><?php echo ($key+1);?></td>
                                <td class="text-left"><?php echo $aValue['FTAgnName'];?></td>
                                <td class="text-left"><?php echo $aValue['FTBchName'];?></td>
                                <td class="text-left"><?php echo $aValue['FTSpaUsrCode'];?></td>
                                <td class="text-left">*************</td>
                                <td class="text-left"><?php echo $aValue['FTSpaApiKey'];?></td>
                                <td class="text-center">
                                    <img class="xCNIconTable" src="<?php echo  base_url().'/application/modules/common/assets/images/icons/delete.png'?>" onClick="JSoConSetGanDel('<?php echo $aValue['FTApiCode'];?>','<?php echo $aValue['FTAgnCode'];?>','<?php echo $aValue['FTBchCode'];?>','<?php echo ($tApiGrpSeq);?>','<?=$aValue['FTSpaUsrCode'];?>','<?= language('common/main/main','tModalConfirmDeleteItemsYN')?>')">                  
                                </td>
                                <td class="text-center">
                                    <img class="xCNIconTable" src="<?php echo  base_url().'/application/modules/common/assets/images/icons/edit.png'?>" onClick="JSvCallPageEditApiAuth('<?php echo ($key+1);?>','<?php echo $aValue['FTApiCode'];?>','<?php echo $aValue['FTAgnCode'];?>','<?php echo $aValue['FTBchCode'];?>')">
                                </td>

                            </tr>
                        <?php } ?>
                    <?php else:?>
                        <tr><td class='text-center xCNTextDetail2' colspan='12'><?=language('common/main/main','tCMNNotFoundData')?></td></tr>
                    <?php endif;?>
                </tbody>
            </table>
        </div>
    </div>
</div>


<div class="row">
	<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        <p><?=language('common/main/main','tResultTotalRecord')?> <?=$aDataApi['rnAllRow']?> <?=language('common/main/main','tRecord')?> <?=language('common/main/main','tCurrentPage')?> <?=$aDataApi['rnCurrentPage']?> / <?=$aDataApi['rnAllPage']?></p>
    </div>
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        <div class="xWSETPaging btn-toolbar pull-right">
            <?php if($nPage == 1){ $tDisabledLeft = 'disabled'; }else{ $tDisabledLeft = '-';} ?>
            <button onclick="JSvConSetClickPage('previous')" class="btn btn-white btn-sm" <?=$tDisabledLeft ?>> 
                <i class="fa fa-chevron-left f-s-14 t-plus-1"></i>
            </button>
            <?php for($i=max($nPage-2, 1); $i<=max(0, min($aDataApi['rnAllPage'],$nPage+2)); $i++){?> 
                <?php 
                    if($nPage == $i){ 
                        $tActive = 'active'; 
                        $tDisPageNumber = 'disabled';
                    }else{ 
                        $tActive = '';
                        $tDisPageNumber = '';
                    }
                ?>
                <button onclick="JSvConSetClickPage('<?=$i?>')" type="button" class="btn xCNBTNNumPagenation <?=$tActive ?>" <?=$tDisPageNumber ?>><?=$i?></button>
            <?php } ?>
            <?php if($nPage >= $aDataApi['rnAllPage']){  $tDisabledRight = 'disabled'; }else{  $tDisabledRight = '-';  } ?>
            <button onclick="JSvConSetClickPage('next')" class="btn btn-white btn-sm" <?=$tDisabledRight ?>>
                <i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
            </button>
        </div>
    </div>
</div>



<!--Modal Delete Single-->
<div id="odvModalDeleteSingle" class="modal fade" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" style="overflow: hidden auto; z-index: 7000; display: none;">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header xCNModalHead">
				<label class="xCNTextModalHeard"><?=language('common/main/main', 'tModalDelete')?></label>
			</div>
			<div class="modal-body">
				<span id="ospConfirmDelete"> - </span>
				<input type='hidden' id="ohdConfirmIDDelete">
			</div>
			<div class="modal-footer">
				<button id="osmConfirmDelete" type="button" class="btn xCNBTNPrimery"><?=language('common/main/main', 'tModalConfirm')?></button>
        		<button type="button" class="btn xCNBTNDefult" data-dismiss="modal"><?=language('common/main/main', 'tModalCancel')?></button>
			</div>
		</div>
	</div>
</div>
<!--End modal Delete Single-->

<script>
    $('#oimSearchSetGenPage').click(function(){
        JCNxOpenLoading();
        JSvCallPageSetEdit('<?=$tApiGrpSeq;?>','<?=$tAPICode?>');
    });

    $('#oetSearchAllGanPage').keypress(function(event){
        if(event.keyCode == 13){
            JCNxOpenLoading();
            JSvCallPageSetEdit('<?=$tApiGrpSeq;?>','<?=$tAPICode?>');
        }
    });
</script>

