<?php 
    if($aDataList['rtCode'] == '1'){
        $nCurrentPage = $aDataList['rnCurrentPage'];
    }else{
        $nCurrentPage = '1';
    }
?>
<input id="oetPshPSHShpType" name="oetPshPSHShpCode"  type="hidden" value="<?php echo $tShpCode?>">
<input id="oetPshPSHBchCode" name="oetPshPSHBchCode"  type="hidden" value="<?php echo $tShpCode?>">
<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-striped" style="width:100%">
                <thead>
                    <tr>
                        <th nowrap class="xCNTextBold" style="width:10%;text-align:center;"><?php echo language('pos/posshop/posshop','tPSHNoGroup')?></th>
                        <th nowrap class="xCNTextBold" style="width:5%;text-align:center;"><?php echo language('pos/posshop/posshop','tPSHNoChannel')?></th>
						<th nowrap class="xCNTextBold" style="width:5%;text-align:center;"><?php echo language('pos/posshop/posshop','tPSHNoSize')?></th>
                        <th nowrap class="xCNTextBold" style="width:5%;text-align:center;"><?php echo language('pos/posshop/posshop','tPSHNoRow')?></th>
                        <th nowrap class="xCNTextBold" style="width:5%;text-align:center;"><?php echo language('pos/posshop/posshop','tPSHNoColumn')?></th>
                        <th nowrap class="xCNTextBold" style="width:5%;text-align:center;"><?php echo language('pos/posshop/posshop','tPSHNoBoard')?></th>
                        <th nowrap class="xCNTextBold" style="width:5%;text-align:center;"><?php echo language('pos/posshop/posshop','tPSHNoChannelCode')?></th>
                        <th nowrap class="xCNTextBold" style="width:5%;text-align:center;"><?php echo language('pos/posshop/posshop','tPSHNoStatus')?></th>
                        <th nowrap class="xCNTextBold" style="width:5%;text-align:center;"><?php echo language('pos/posshop/posshop','tPSHNoSetting')?></th>
                    </tr>
                </thead>
                <tbody id="odvRGPList">
                <?php if($aDataList['rtCode'] == 1 ):?>
                    <?php foreach($aDataList['raItems'] AS $key=>$aValue){ ?>
                        <tr class="text-center xCNTextDetail2" data-code="<?=$aValue['FTPzeCode']?>" data-name="<?=$aValue['FTSizName']?>"">
                            <td nowrap class="text-left xWTdBody"><?=$aValue['FTRakName'] ?></td>
                            <td nowrap class="text-right"><?=$aValue['FNLayNo'] ?></td>
                            <td nowrap class="text-left"><?=$aValue['FTSizName'] ?></td>
                            <td nowrap class="text-right"><?=$aValue['FNLayRow'] ?></td>
                            <td nowrap class="text-right"><?=$aValue['FNLayCol'] ?></td>
                            <td nowrap class="text-right"><?=$aValue['FNLayBoardNo'] ?></td>
                            <td nowrap class="text-right"><?=$aValue['FTLayBoxNo'] ?></td>
                            <td nowrap class="text-left">
                            <?php if($aValue['FTLayStaUse']  == 1) : ?> 
                                <?php echo language('pos/posshop/posshop','tPshStaActive')?>
                            <?php else:?>
                                <?php echo language('pos/posshop/posshop','tPshStaNotActive')?>
                            <?php endif;?>
                            </td>
                            <td nowrap class="text-center"><img class="xCNIconTable"  data-lcol="<?php echo $aValue['FNLayCol'];?>" data-lrow="<?php echo $aValue['FNLayRow'];?>" data-rname="<?php echo $aValue['FTRakName'];?>" data-lno="<?php echo $aValue['FNLayNo'] ?>" data-bch="<?php echo $aValue['FTBchCode'];?>"  data-shp="<?php echo $aValue['FTShpCode'];?>" src="<?php echo  base_url().'/application/modules/common/assets/images/icons/Settings.png'?>" onClick="FSaPSHSettingChannel(this)"></td>
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
        <p><?=language('common/main/main','tResultTotalRecord')?> <?=$aDataList['rnAllRow']?> <?=language('common/main/main','tRecord')?> <?=language('common/main/main','tCurrentPage')?> <?=$aDataList['rnCurrentPage']?> / <?=$aDataList['rnAllPage']?></p>
    </div>
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        <div class="xWPSHPaging btn-toolbar pull-right">
            <?php if($nPage == 1){ $tDisabledLeft = 'disabled'; }else{ $tDisabledLeft = '-';} ?>
            <button onclick="JSvPshClickPage('previous')" class="btn btn-white btn-sm" <?=$tDisabledLeft ?>> 
                <i class="fa fa-chevron-left f-s-14 t-plus-1"></i>
            </button>
            <?php for($i=max($nPage-2, 1); $i<=max(0, min($aDataList['rnAllPage'],$nPage+2)); $i++){?> 
                <?php 
                    if($nPage == $i){ 
                        $tActive = 'active'; 
                        $tDisPageNumber = 'disabled';
                    }else{ 
                        $tActive = '';
                        $tDisPageNumber = '';
                    }
                ?>
                <button onclick="JSvPshClickPage('<?=$i?>')" type="button" class="btn xCNBTNNumPagenation <?=$tActive ?>" <?=$tDisPageNumber ?>><?=$i?></button>
            <?php } ?>
            <?php if($nPage >= $aDataList['rnAllPage']){  $tDisabledRight = 'disabled'; }else{  $tDisabledRight = '-';  } ?>
            <button onclick="JSvPshClickPage('next')" class="btn btn-white btn-sm" <?=$tDisabledRight ?>>
                <i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
            </button>
        </div>
    </div>
</div>

<!--Modal Delete Mutirecord-->
<div class="modal fade" id="odvModalDeleteMutirecord">
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
				<button id="osmConfirm" type="button" class="btn xCNBTNPrimery" onClick="JSxSMSDeleteMutirecord()"><?=language('common/main/main', 'tModalConfirm')?></button>
        		<button type="button" class="btn xCNBTNDefult" data-dismiss="modal"><?=language('common/main/main', 'tModalCancel')?></button>
			</div>
		</div>
	</div>
</div>
<!--End modal Delete Mutirecord-->

<!--Modal Setting Channel-->
<div class="modal fade" id="odvModalSettingChannel">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header xCNModalHead">
				<label class="xCNTextModalHeard"><?= language('pos/posshop/posshop', 'tPSHNoChannelSetting')?></label>
			</div>
			<div class="modal-body">
            <div class="well well-lg">
                <div class="row">
                    <div class="col-lg-2"><label style="font-weight: bold;"><?=language('pos/posshop/posshop','tPSHNoGroup');?></label></div>
                    <div class="col-lg-10"><span id="ospPSHGroup"></span></div>
                </div>
                <div class="row">
                    <div class="col-lg-2"><label style="font-weight: bold;"><?=language('pos/posshop/posshop','tPSHNoChannel');?></label></div>
                    <div class="col-lg-10"><span id="ospPSHNoChannel"></span></div>
                </div>
                <div class="row">
                    <div class="col-lg-2"><label style="font-weight: bold;"><?=language('pos/posshop/posshop','tPSHNoRow');?></label></div>
                    <div class="col-lg-10"><span id="ospPSHNoNoRow"></span></div>
                </div>
                <div class="row">
                    <div class="col-lg-2"><label style="font-weight: bold;"><?=language('pos/posshop/posshop','tPSHNoColumn');?></label></div>
                    <div class="col-lg-10"><span id="ospPSHNoNoCol"></span></div>
                </div>
                <input type="hidden" id="oetBchCode">
                <input type="hidden" id="oetShpCode">
                <input type="hidden" id="oetLayNoCode">
            </div>

            <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="row">
                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                    <label class="xCNLabelFrm"><?= language('pos/posshop/posshop','tPSHNoBoardnum'); ?></label>
                    <input class="form-control xCNInputWithoutSpcNotThai xCNInputNumericWithDecimal xCNInputWithoutSingleQuote text-right" maxlength="1" type="text" id="oetPSHBoardnum"   autocomplete="off" placeholder="<?php echo language('pos/posshop/posshop','tPSHNoBoardnum')?>"/>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                    <label class="xCNLabelFrm"><?= language('pos/posshop/posshop','tPSHNoChannelCode'); ?></label>
                    <input class="form-control xCNInputWithoutSpcNotThai text-right" type="text" id="oetPSHChannelCode" autocomplete="off"  maxlength="5" placeholder="<?php echo language('pos/posshop/posshop','tPSHNoChannelCode')?>"/>
                </div>
                </div>
            </div>
            </div>

			</div>
			<div class="modal-footer">
				<button id="osmConfirm" type="button" class="btn xCNBTNPrimery" data-dismiss="modal" onclick="JSxSaveSettingChannel()">
					<?= language('company/shopgpbypdt/shopgpbypdt', 'tSGPPBTNSave'); ?>
				</button>
				<button type="button" class="btn xCNBTNDefult" data-dismiss="modal">
					<?= language('common/main/main', 'tModalCancel'); ?>
				</button>
			</div>
		</div>
	</div>
</div>
<!--Modal End Setting Channel-->
<script src="<?php echo base_url('application/modules/common/assets/js/jquery.mask.js')?>"></script>
<script src="<?php echo base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>
<script>

    // Select List ShopSize Table Item
    $(function() {
    $('.ocbListItem').click(function(){
        var nCode = $(this).parent().parent().parent().data('code');  //code
        var tName = $(this).parent().parent().parent().data('name');  //code
        $(this).prop('checked', true);
        var LocalItemData = localStorage.getItem("LocalItemData");
        var obj = [];
        if(LocalItemData){
            obj = JSON.parse(LocalItemData);
        }else{ }
        var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
        if(aArrayConvert == '' || aArrayConvert == null){
            obj.push({"nCode": nCode, "tName": tName });
            localStorage.setItem("LocalItemData",JSON.stringify(obj));
            JSxSMSPaseCodeDelInModal();

        }else{
            var aReturnRepeat = findObjectByKey(aArrayConvert[0],'nCode',nCode);
            if(aReturnRepeat == 'None' ){           //ยังไม่ถูกเลือก
                obj.push({"nCode": nCode, "tName": tName });
                localStorage.setItem("LocalItemData",JSON.stringify(obj));
                JSxSMSPaseCodeDelInModal();

            }else if(aReturnRepeat == 'Dupilcate'){	//เคยเลือกไว้แล้ว
                localStorage.removeItem("LocalItemData");
                $(this).prop('checked', false);
                var nLength = aArrayConvert[0].length;
                for($i=0; $i<nLength; $i++){
                    if(aArrayConvert[0][$i].nCode == nCode){
                        delete aArrayConvert[0][$i];
                    }
                }
                var aNewarraydata = [];
                for($i=0; $i<nLength; $i++){
                    if(aArrayConvert[0][$i] != undefined){
                        aNewarraydata.push(aArrayConvert[0][$i]);
                    }
                }
                localStorage.setItem("LocalItemData",JSON.stringify(aNewarraydata));
                JSxSMSPaseCodeDelInModal();
                }
            }
            JSxSMSShowButtonChoose();
        });
    });

    //Show modal
    function FSaPSHSettingChannel(element){
        var tBchCode   = $(element).attr('data-bch');
        var tShpCode   = $(element).attr('data-shp');
        var tLayNoCode = $(element).attr('data-lNo');
        var tLayCol    = $(element).attr('data-lcol');
        var tLayRow    = $(element).attr('data-lrow');
        var tRakName   = $(element).attr('data-rname');
        var tPosCode   = $('#oetPshPSHPosCode').val();
        $.ajax({
        type: "POST",
        url: "PSHSmartLockerShopPosEventcheckData",
        data: {
            tBchCode       : tBchCode,
            tShpCode       : tShpCode,
            tLayNoCode     : tLayNoCode,
            tPosCode       : tPosCode
        },
        success: function (oResult) {
                var tResult = JSON.parse(oResult);
                    $('#ospPSHGroup').text(' : '  + tRakName);
                    $('#ospPSHNoChannel').text(' : '  + tLayNoCode);
                    $('#ospPSHNoNoRow').text(' : '  + tLayRow);
                    $('#ospPSHNoNoCol').text(' : '  + tLayCol);
                    $('#oetBchCode').val(tBchCode);
                    $('#oetShpCode').val(tShpCode);
                    $('#oetLayNoCode').val(tLayNoCode);
                    if(tResult['rtCode'] == 1){
                        if(tResult.raItems.FNLayBoardNo != ''){
                            $('#oetPSHBoardnum').val(tResult.raItems.FNLayBoardNo);
                        }
                        //return เป็น0  
                        if(tResult.raItems.FNLayBoardNo == 0){
                            $('#oetPSHBoardnum').val(0);
                        }
                        if(tResult.raItems.FTLayBoxNo != ''){
                            $('#oetPSHChannelCode').val(tResult.raItems.FTLayBoxNo);
                        }
                    }
                    //เปิด Modal                    
                    $('#odvModalSettingChannel').modal('show');

                    //ปิด Modal
                    $('#odvModalSettingChannel').on('hidden.bs.modal', function () {
                        $('#oetPSHChannelCode').val('');
                        $('#oetPSHBoardnum').val('');
                    });

                },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }

    //Save Data
    function JSxSaveSettingChannel(){
        var tBoardnum    = $('#oetPSHBoardnum').val();
        var tChannelCode = $('#oetPSHChannelCode').val();
        var tBchCode = $('#oetBchCode').val();
        var tShpCode = $('#oetShpCode').val();
        var tLnoCode = $('#oetLayNoCode').val();
        var tPosCode = $('#oetPshPSHPosCode').val();

        
  
        $.ajax({
            type: "POST",
            url: "PSHSmartLockerShopPosEventinset",
            data: {
                tBoardnum       : tBoardnum,
                tChannelCode    : tChannelCode,
                tBchCode        : tBchCode,
                tShpCode        : tShpCode,
                tLnoCode        : tLnoCode,
                tPosCode        : tPosCode
            },
            success: function (oResult) {
                    var tResult = JSON.parse(oResult);
                    if(tResult.rtCode == 1){
                        JSvPSHDataTable(tResult.FTBchCode,tShpCode)
                    }else{
                        alert(tResult.rtDesc);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }

</script>

