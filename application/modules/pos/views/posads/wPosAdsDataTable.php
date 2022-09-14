<?php 
    if($aAdsDataList['rtCode'] == '1'){
        $nCurrentPage = $aAdsDataList['rnCurrentPage'];
    }else{
        $nCurrentPage = '1';
    }

?>
<style>
    #odvModalPosAdsShowAds{
        overflow: hidden auto;
        display: none;
    }

    #odvModalPosAdsShowAds .modal-dialog{
        min-width: 50%;
        margin: 1.75rem auto;
    }

    #odvModalPosAdsShowAds .modal-body{
        min-height: 500px;
        overflow: auto;
    }

    /* modal for position */
    #odvModalPosAdsShowPosition{
        overflow: hidden auto;
        display: none;
    }

    #odvModalPosAdsShowPosition .modal-dialog{
        min-width: 50%;
        margin: 1.75rem auto;
    }

    #odvModalPosAdsShowPosition .modal-body{
        min-height: 500px;
        overflow: auto;
    }

</style>
<div class="row">
    <div class="col-xs-12 col-md-12">
        <div class="table-responsive">
            <table id="otbAdsDataList" class="table table-striped">
                <thead>
                    <tr>
                        <th nowrap class="text-center xCNTextBold" style="width:100px;"><?= language('pos/posads/posads','tAdsChoose');?></th>
                        <th nowrap class="text-center xCNTextBold" ><?= language('pos/posads/posads','tAdsAdvertise');?></th>
                        <!-- <th nowrap class="text-center xCNTextBold" style="width:10%;"><?= language('pos/posads/posads','tAdsPosition');?></th>                         -->
                        <th nowrap class="text-center xCNTextBold" ><?= language('pos/posads/posads','tAdsWidtht');?></th>
                        <th nowrap class="text-center xCNTextBold" ><?= language('pos/posads/posads','tAdsHeight');?></th>
                        <th nowrap class="text-center xCNTextBold" style="width:100px;"><?= language('pos/posads/posads','tAdsDelete');?></th>                
                        <th nowrap class="text-center xCNTextBold" style="width:100px;"><?= language('pos/posads/posads','tAdsEdit');?></th>   
                    </tr>
                </thead>
                <tbody id="odvPDSList">
                    <?php if($aAdsDataList['rtCode'] == '1'):?>
                        <?php foreach($aAdsDataList['raItems'] AS $nKey => $aValue):?>     
                            <tr class="text-center xCNTextDetail2 xWPosAdsDataSource" id="otrPosAds<?=$nKey?>"   
                                data-bch="<?=$aValue['rtBchCode'];?>" 
                                data-shp="<?=$aValue['rtShpCode'];?>" 
                                data-pos="<?=$aValue['rtPosCode'];?>"  
                                data-seq="<?=$aValue['rtPsdSeq'];?>" 
                            >   
                                <td class="text-center">
                                    <label class="fancy-checkbox">
                                        <input id="ocbListItemAds<?php echo $nKey?>" type="checkbox" class="ocbListItemAds" name="ocbListItem[]">
                                        <span>&nbsp;</span>
                                    </label>
                                </td>
                                <!-- BCH -->
                                <!-- <td class="xWPosAdsPosBch text-left">
                                    <?php echo $aValue['rtBchName'];?>
                                    <input id="oetPosAdsPosBchCode<?=$nKey;?>" type="hidden" value="<?=$aValue['rtBchCode'];?>">
                                </td> -->

                                <!-- SHP -->
                                <!-- <td class="xWPosAdsPosShp text-left">
                                    <?php echo $aValue['rtShpName'];?>
                                    <input id="oetPosAdsPosShpCode<?=$nKey;?>" type="hidden" value="<?=$aValue['rtShpCode'];?>">
                                </td> -->

                                <!-- Pos -->
                                <!-- <td class="xWPosAdsPos text-left" >
                                    <?php echo $aValue['rtPosComName'];?>
                                    <input id="oetPosAdsPosCode<?=$nKey;?>" type="hidden" value="<?=$aValue['rtPosCode'];?>">
                                </td> -->

                                <td class="xWPosAdsPosSeq xCNHide">
                                    <input id="oetPosAdsPosSeq<?=$nKey;?>" type="hidden" value="<?=$aValue['rtPsdSeq'];?>">
                                </td>

                              <!-- POSVD -->
                                <td class="xWPosAdsPosVD">
                                    <div class="input-group">
                                        <input id="oetPosAdsPosVDName<?=$nKey;?>" class="form-control xWPosAdsPosVDInLine" data-typemedia="<?=$aValue['rtAdvType'];?>" name="oetPosAdsPosVDName<?=$nKey;?>" type="text" value="<?=$aValue['rtAdsName']; ?>" disabled>
                                        <input id="oetPosAdsPosVDCode<?=$nKey;?>" type="hidden" value="<?=$aValue['rtAdvCode'];?>">
                                        <input id="oetPosAdsPosVDTypeMeidaCode<?=$nKey;?>" type="hidden" value="<?=$aValue['rtAdvType'];?>">
                                        <span class="input-group-btn">
                                            <button type="button" class="btn xCNBtnBrowseAddOn xWBtnShowPosAds">
                                                <img src="<?php echo base_url().'/application/modules/common/assets/images/icons/View20.png'?>">
                                            </button>
                                        </span>
                                    </div>
                                </td>

                                
                                <!-- Position -->
                                <!-- <td class="xWPosAdsPosition">
                                    <input type="hidden" name="ohdPosAdsPositionSelect[]" value="<?php echo $aValue['rtPsdPosition'];?>">
                                    <div class="col-lg-8" style="padding: 0px;">
                                    <select class="selectpicker form-control xWPosAdsPosition" data-size="5" id="ocmPosition<?=$nKey;?>" name="ocmPosition<?=$nKey;?>" maxlength="1" disabled>
                                        <option value = ''><?php echo language('pos/posads/posads','N/A'); ?></option>
                                        <option value = 'TL'<?php echo ($aValue['rtPsdPosition'] == 'TL')? 'selected':''?>><?php echo language('pos/posads/posads','tAdsPositionTL');?></option>
                                        <option value = 'TM'<?php echo ($aValue['rtPsdPosition'] == 'TM')? 'selected':''?>><?php echo language('pos/posads/posads','tAdsPositionTM');?></option>
                                        <option value = 'TR'<?php echo ($aValue['rtPsdPosition'] == 'TR')? 'selected':''?>><?php echo language('pos/posads/posads','tAdsPositionTR');?></option>
                                        <option value = 'ML'<?php echo ($aValue['rtPsdPosition'] == 'ML')? 'selected':''?>><?php echo language('pos/posads/posads','tAdsPositionML');?></option>
                                        <option value = 'MM'<?php echo ($aValue['rtPsdPosition'] == 'MM')? 'selected':''?>><?php echo language('pos/posads/posads','tAdsPositionMM');?></option>
                                        <option value = 'MR'<?php echo ($aValue['rtPsdPosition'] == 'MR')? 'selected':''?>><?php echo language('pos/posads/posads','tAdsPositionMR');?></option>
                                        <option value = 'BL'<?php echo ($aValue['rtPsdPosition'] == 'BL')? 'selected':''?>><?php echo language('pos/posads/posads','tAdsPositionBL');?></option>
                                        <option value = 'BM'<?php echo ($aValue['rtPsdPosition'] == 'BM')? 'selected':''?>><?php echo language('pos/posads/posads','tAdsPositionBM');?></option>
                                        <option value = 'BR'<?php echo ($aValue['rtPsdPosition'] == 'BR')? 'selected':''?>><?php echo language('pos/posads/posads','tAdsPositionBR');?></option>
                                        <option value = 'AL'<?php echo ($aValue['rtPsdPosition'] == 'AL')? 'selected':''?>><?php echo language('pos/posads/posads','tAdsPositionAL');?></option>
                                    </select>
                                    </div>
                                    <div class="col-lg-4" style="padding: 0px;">
                                        <button type="button" class="btn xCNBtnBrowseAddOn xWBtnShowPic" style="width:100%;">
                                            <img src="<?php echo base_url().'/application/modules/common/assets/images/icons/View20.png'?>">
                                        </button>
                                    </div>
                                </td> -->

            
                                <!-- Width -->
                                <td class="xWPosAdsWidth">
                                    <input type="hidden" name="ohdPosAdsWidthSelect[]" value="<?php echo $aValue['rtPsdWide'];?>">
                                    <select class="selectpicker form-control xWPosAdsWidth" data-size="5" id="ocmPosWidth<?=$nKey;?>" name="ocmPosWidth<?=$nKey;?>" maxlength="1" disabled>
                                        <option value= ''><?php echo language('pos/posads/posads','N/A') ?></option>
                                        <option value= '1'<?php echo ($aValue['rtPsdWide'] == '1')? 'selected':''?>><?php echo language('pos/posads/posads','tAdsWidth1') ?></option>
                                        <option value= '2'<?php echo ($aValue['rtPsdWide'] == '2')? 'selected':''?>><?php echo language('pos/posads/posads','tAdsWidth2') ?></option>
                                        <option value= '3'<?php echo ($aValue['rtPsdWide'] == '3')? 'selected':''?>><?php echo language('pos/posads/posads','tAdsWidth3') ?></option>
                                        <option value= '4'<?php echo ($aValue['rtPsdWide'] == '4')? 'selected':''?>><?php echo language('pos/posads/posads','tAdsWidth4') ?></option>
                                        <option value= '5'<?php echo ($aValue['rtPsdWide'] == '5')? 'selected':''?>><?php echo language('pos/posads/posads','tAdsWidth5') ?></option>
                                        <option value= '6'<?php echo ($aValue['rtPsdWide'] == '6')? 'selected':''?>><?php echo language('pos/posads/posads','tAdsWidth6') ?></option>
                                        <option value= '7'<?php echo ($aValue['rtPsdWide'] == '7')? 'selected':''?>><?php echo language('pos/posads/posads','tAdsWidth7') ?></option>
                                        <option value= '8'<?php echo ($aValue['rtPsdWide'] == '8')? 'selected':''?>><?php echo language('pos/posads/posads','tAdsWidth8') ?></option>
                                    </select>
                                </td>

                                <!-- higth -->
                                <td class="xWPosAdsHigth">
                                    <input type="hidden"  name="ohdPosAdsHigthSelect[]" value="<?php echo $aValue['rtPsdHigh'];?>">
                                    <select class="selectpicker form-control xWPosAdsHigth" data-size="5" id="ocmPosHeigh<?=$nKey;?>" name="ocmPosHeigh<?=$nKey;?>" maxlength="1" disabled>
                                        <option value= ''><?php echo language('pos/posads/posads','N/A') ?></option>
                                        <option value= '1'<?php echo ($aValue['rtPsdHigh'] == '1')? 'selected':''?>><?php echo language('pos/posads/posads','tAdsHeigh1') ?></option>
                                        <option value= '2'<?php echo ($aValue['rtPsdHigh'] == '2')? 'selected':''?>><?php echo language('pos/posads/posads','tAdsHeigh2') ?></option>
                                        <option value= '3'<?php echo ($aValue['rtPsdHigh'] == '3')? 'selected':''?>><?php echo language('pos/posads/posads','tAdsHeigh3') ?></option>
                                        <option value= '4'<?php echo ($aValue['rtPsdHigh'] == '4')? 'selected':''?>><?php echo language('pos/posads/posads','tAdsHeigh4') ?></option>
                                        <option value= '5'<?php echo ($aValue['rtPsdHigh'] == '5')? 'selected':''?>><?php echo language('pos/posads/posads','tAdsHeigh5') ?></option>
                                        <option value= '6'<?php echo ($aValue['rtPsdHigh'] == '6')? 'selected':''?>><?php echo language('pos/posads/posads','tAdsHeigh6') ?></option>
                                        <option value= '7'<?php echo ($aValue['rtPsdHigh'] == '7')? 'selected':''?>><?php echo language('pos/posads/posads','tAdsHeigh7') ?></option>
                                        <option value= '8'<?php echo ($aValue['rtPsdHigh'] == '8')? 'selected':''?>><?php echo language('pos/posads/posads','tAdsHeigh8') ?></option>
                                    </select>
                                </td>

                                <td>
                                    <img class="xCNIconTable" src="<?php echo  base_url().'/application/modules/common/assets/images/icons/delete.png'?>" onClick="JSoPosAdsDel('<?php echo $aValue['rtAdsName']?>','<?php echo $aValue['rtPsdSeq']?>','<?php echo language('common/main/main','tBCHYesOnNo')?>','<?php echo $aValue['rtBchCode']?>','<?php echo $aValue['rtShpCode']?>','<?php echo $aValue['rtPosCode']?>')">
                                </td>    
                                <td>
                                    <img class="xCNIconTable"  src="<?php echo  base_url().'/application/modules/common/assets/images/icons/edit.png'?>" onclick="JSvCallPagePosAdsEdit('<?php echo $aValue['rtBchCode']?>','<?php echo $aValue['rtShpCode']?>','<?php echo $aValue['rtPosCode']?>','<?php echo $aValue['rtPsdSeq']?>');">
                                    <img class="xCNIconTable xWPosAdsSave hidden" src="<?php echo  base_url(); ?>/application/modules/common/assets/images/icons/save.png">
                                    <img class="xCNIconTable xWPosAdsCancel hidden" src="<?php echo  base_url(); ?>/application/modules/common/assets/images/icons/reply_new.png">
                                </td>      

                            </tr>
                        <?php endforeach;?>
                    <?php else:?>
                        <tr><td class='text-center xCNTextDetail2' colspan='99'><?php echo language('common/main/main','tCMNNotFoundData')?></td></tr>
                    <?php endif;?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        <p><?php echo language('common/main/main','tResultTotalRecord')?> <?php echo $aAdsDataList['rnAllRow']?> <?php echo language('common/main/main','tRecord')?> <?php echo language('common/main/main','tCurrentPage')?> <?php echo $aAdsDataList['rnCurrentPage']?> / <?php echo $aAdsDataList['rnAllPage']?></p>
    </div>
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        <div class="xWPagePosAds btn-toolbar pull-right">
            <?php if($nPage == 1){ $tDisabledLeft = 'disabled'; }else{ $tDisabledLeft = '-';} ?>
            <button onclick="JSvPosAdsClickPage('previous')" class="btn btn-white btn-sm" <?php echo $tDisabledLeft ?>>
                <i class="fa fa-chevron-left f-s-14 t-plus-1"></i>
            </button>
                <?php for($i=max($nPage-2, 1); $i<=max(0, min($aAdsDataList['rnAllPage'],$nPage+2)); $i++){?>
                <?php 
                    if($nPage == $i){ 
                        $tActive = 'active'; 
                        $tDisPageNumber = 'disabled';
                    }else{ 
                        $tActive = '';
                        $tDisPageNumber = '';
                    }
                ?>
                <button onclick="JSvPosAdsClickPage('<?php echo $i?>')" type="button" class="btn xCNBTNNumPagenation <?php echo $tActive ?>" <?php echo $tDisPageNumber ?>><?php echo $i?></button>
            <?php } ?>
            <?php if($nPage >= $aAdsDataList['rnAllPage']){  $tDisabledRight = 'disabled'; }else{  $tDisabledRight = '-';  } ?>
            <button onclick="JSvPosAdsClickPage('next')" class="btn btn-white btn-sm" <?php echo $tDisabledRight ?>>
                <i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
            </button>
        </div>
    </div>
</div>


<!--Modal Delete Single-->
<div class="modal fade" id="odvModalDelPosAds">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header xCNModalHead">
                <label class="xCNTextModalHeard"><?php echo language('common/main/main', 'tModalDelete')?></label>
            </div>
            <div class="modal-body">
                    <span class="ospConfirmDelete"></span>
                    <input type='hidden' id="ohdConfirmIDDelete">
            </div>
            <div class="modal-footer">
				<button id="osmConfirmDelete" type="button" class="btn xCNBTNPrimery"><?=language('common/main/main', 'tModalConfirm')?></button>
        		<button type="button" class="btn xCNBTNDefult" data-dismiss="modal"><?=language('common/main/main', 'tModalCancel')?></button>
			</div>
        </div>
     </div>
</div>
<!--Modal Delete Single-->


<!--Modal Delete Mutirecord-->
<div id="odvModalDeleteMutirecord" class="modal fade" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" style="overflow: hidden auto; z-index: 7000; display: none;">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header xCNModalHead">
				<label class="xCNTextModalHeard"><?=language('common/main/main', 'tModalDelete')?></label>
			</div>
			<div class="modal-body">
            <span id="ospConfirmDelete"></span>
            <input type='hidden' id="ohdConfirmIDDeleteMutirecordBch"> 
            <input type='hidden' id="ohdConfirmIDDeleteMutirecordShp"> 
            <input type='hidden' id="ohdConfirmIDDeleteMutirecordPos">
             
            <input type='hidden' id="ohdConfirmIDDeleteMutirecordSeq">    
			</div>
			<div class="modal-footer">
				<button id="osmConfirm" type="button" class="btn xCNBTNPrimery" onClick="JSxPosAdsDeleteMutirecord('<?=$nCurrentPage?>')"><?=language('common/main/main', 'tModalConfirm')?></button>
        		<button type="button" class="btn xCNBTNDefult" data-dismiss="modal"><?=language('common/main/main', 'tModalCancel')?></button>
			</div>
		</div>
	</div>
</div>

<?php include "script/jPosAdsDataTable.php"; ?>

<!-- view modal for VDO And Pic -->
<div class="modal fade" id="odvModalPosAdsShowAds" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document"> 
    <div class="modal-content">
      <div class="modal-header xCNModalHead">
        <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                <label class="xCNTextModalHeard"><?php echo language('pos/posads/posads','tPosAdsViewMedia');?></label>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-right">
                <button class="btn xCNBTNDefult xCNBTNDefult2Btn" data-dismiss="modal"><?php echo language('pos/posads/posads','tPosAdsCancel');?></button>
            </div>
        </div>  
      </div>
        <div class="modal-body">

        </div>
    </div>
  </div>
</div>

<!-- view modal Position Pic -->
<div class="modal fade" id="odvModalPosAdsShowPosition" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document"> 
    <div class="modal-content">
      <div class="modal-header xCNModalHead">
        <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                <label class="xCNTextModalHeard"><?php echo language('pos/posads/posads','tPosAdsViewPosition');?></label>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-right">
                <button class="btn xCNBTNDefult xCNBTNDefult2Btn" data-dismiss="modal"><?php echo language('pos/posads/posads','tPosAdsCancel');?></button>
            </div>
        </div>  
      </div>
        <div class="modal-body">
        </div>
    </div>
  </div>
</div>

<script>

    $('.selectpicker').selectpicker();
  
    // Modal Show VDO/PIC
    $('.xWBtnShowPosAds').click(function(e){
        e.preventDefault();
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSvCallModalPosAdsShowAds(this);
        }else{
            JCNxShowMsgSessionExpired();
        }
    });


    // Modal Show PIC
    $('.xWBtnShowPic').click(function(e){
        e.preventDefault();
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSvCallModalPosAdsShowPosition(this);
        }else{
            JCNxShowMsgSessionExpired();
        }
    });



    function JSvCallModalPosAdsShowAds(poEvent){
        var tPosAdsVD = $(poEvent).parents('.xWPosAdsDataSource').find('.xWPosAdsPosVD input[type=hidden]').val();
        var tTypemedia = $(poEvent).parents('.xWPosAdsDataSource').find('.xWPosAdsPosVD').find('.xWPosAdsPosVDInLine').data('typemedia');
    
        $.ajax({
            type: "POST",
            url: "posAdsViewMedia",
            data: { tPosAdsVDCode: tPosAdsVD , tTypemedia : tTypemedia },
            cache: false,
            timeout: 0,
            success: function(oResult){
                var aDataReturn = JSON.parse(oResult);
                switch(aDataReturn['nStaEvent']){
                    case '1':
                        $('#odvModalPosAdsShowAds .modal-body').html(aDataReturn['tViewPosAdsMedia']);
                        // $.getScript("application/modules/common/assets/vendor/bootstrap/css/bootstrap.min.css");
                        // $.getScript("application/modules/common/assets/vendor/bootstrap/js/bootstrap.min.js");
                        $('#odvModalPosAdsShowAds').modal({backdrop: 'static', keyboard: false});
                        $('#odvModalPosAdsShowAds').modal('show');
                    break;
                    case '800':
                        var tMsgPosAdsMediaNotFound = aDataReturn['tStaMessg'];
                        FSvCMNSetMsgWarningDialog(tMsgPosAdsMediaNotFound);
                    break;
                    case '500':
                        var tMsgPosAdsMediaErr  = aDataReturn['tStaMessg'];
                        FSvCMNSetMsgErrorDialog(tMsgPosAdsMediaErr);
                    break;
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }



    function JSvCallModalPosAdsShowPosition(poEvent){
       var tPosAdsPositionSlt  = $(poEvent).parents('.xWPosAdsDataSource').find('.xWPosAdsPosition  input[type=hidden]').val();
       $.ajax({
            type:   "POST",
            url:    "posAdsViewPosition",
            data:   {tPosAdsPositionSlt : tPosAdsPositionSlt },
            cache:  false,
            timeout: 0,
            success: function(tResult){
                $('#odvModalPosAdsShowPosition .modal-body').html(tResult);
                $('#odvModalPosAdsShowPosition').modal({backdrop: 'static', keyboard: false});
                $('#odvModalPosAdsShowPosition').modal('show');
            },
            error: function(jqxHR,textStatus, errorThrown)  {
                JCNxResponseError(jqxHR,textStatus, errorThrown);
            }
        });
    }


$('ducument').ready(function() {
    JSxShowButtonChoose();
	var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemDataAds"))];
	var nlength = $('#odvPDSList').children('tr').length;
	for($i=0; $i < nlength; $i++){
		var tDataCode = $('#otrPosAds'+$i).data('nSeq')
		if(aArrayConvert == null || aArrayConvert == ''){
		}else{
			var aReturnRepeat = findObjectByKey(aArrayConvert[0],'nSeq',tDataCode);
			if(aReturnRepeat == 'Dupilcate'){
				$('#ocbListItemAds'+$i).prop('checked', true);
			}else{ }
		}
	}

	$('.ocbListItemAds').click(function(){
        var nBch = $(this).parent().parent().parent().data('bch');
        var nShp = $(this).parent().parent().parent().data('shp');
        var nPos = $(this).parent().parent().parent().data('pos');  //codeposcode
        var nSeq = $(this).parent().parent().parent().data('seq');  //codeseq

        $(this).prop('checked', true);
        var LocalItemData = localStorage.getItem("LocalItemDataAds");
        var obj = [];
        if(LocalItemData){
            obj = JSON.parse(LocalItemData);
        }else{ }
        var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemDataAds"))];
        if(aArrayConvert == '' || aArrayConvert == null){
            obj.push({"nBch": nBch,"nShp": nShp, "nPos": nPos, "nSeq": nSeq });
            localStorage.setItem("LocalItemDataAds",JSON.stringify(obj));
            JSxPaseCodeDelInModal();
        }else{
            var aReturnRepeat = findObjectByKey(aArrayConvert[0],'nSeq',nSeq);
            if(aReturnRepeat == 'None' ){           //ยังไม่ถูกเลือก
                obj.push({"nBch": nBch,"nShp": nShp, "nPos": nPos, "nSeq": nSeq });
                localStorage.setItem("LocalItemDataAds",JSON.stringify(obj));
                JSxPaseCodeDelInModal();
            }else if(aReturnRepeat == 'Dupilcate'){	//เคยเลือกไว้แล้ว
                localStorage.removeItem("LocalItemDataAds");
                $(this).prop('checked', false);
                var nLength = aArrayConvert[0].length;
                for($i=0; $i<nLength; $i++){
                    if(aArrayConvert[0][$i].nSeq == nSeq){
                        delete aArrayConvert[0][$i];
                    }
                }
                var aNewarraydata = [];
                for($i=0; $i<nLength; $i++){
                    if(aArrayConvert[0][$i] != undefined){
                        aNewarraydata.push(aArrayConvert[0][$i]);
                    }
                }
                localStorage.setItem("LocalItemDataAds",JSON.stringify(aNewarraydata));
                JSxPaseCodeDelInModal();
            }
        }
        JSxShowButtonChoose();
    })
});
</script>


