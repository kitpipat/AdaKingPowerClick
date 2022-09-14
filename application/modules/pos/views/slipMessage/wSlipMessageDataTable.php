<?php
    if($aDataList['rtCode'] == '1'){
        $nCurrentPage = $aDataList['rnCurrentPage'];
    }else{
        $nCurrentPage = '1';
    }
?>

<style>
.table > tbody > tr > td {
    vertical-align: middle !important;
}

    .xWTdDisable {
        cursor: not-allowed !important;
        opacity: 0.4 !important;
    }

    .xWImgDisable {
        pointer-events: none;
    }
</style>
<div class="row">
    <div class="col-md-12">
        <input type="hidden" id="nCurrentPageTB" value="<?=$nCurrentPage;?>">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th nowrap class="xCNTextBold text-center" style="width:5%;">
                            <label class="fancy-checkbox">
                                <input type="checkbox" class="ocmCENCheckDeleteAll" id="ocmCENCheckDeleteAll" >
                                <span class="ospListItem">&nbsp;</span>
                            </label>
                        </th>
                        <th class="xCNTextBold text-center" style="width:7%;"><?php echo language('pos/slipMessage/slipmessage','tSMGTBImage'); ?></th>
                        <th class="xCNTextBold text-center" style="width:10%;"><?php echo language('pos/slipMessage/slipmessage','tSMGTBCode'); ?></th>
                        <th class="xCNTextBold text-center" ><?php echo language('pos/slipMessage/slipmessage','tSMGTBName'); ?></th>
                        <th class="xCNTextBold text-center" style="width:7%;"><?php echo language('pos/slipMessage/slipmessage','tSMGTBDelete'); ?></th>
                        <th class="xCNTextBold text-center" style="width:7%;"><?php echo language('pos/slipMessage/slipmessage','tSMGTBEdit'); ?></th>
                    </tr>
                </thead>
                <tbody id="odvRGPList">
                <?php if($aDataList['rtCode'] == 1 ):?>
                    <?php foreach($aDataList['raItems'] AS $key => $aValue){ ?>
                        <tr class="text-center xCNTextDetail2 otrSlipMessage" id="otrSlipMessage<?php echo $key; ?>" data-code="<?php echo $aValue['rtSmgCode']; ?>" data-name="<?php echo $aValue['rtSmgTitle']; ?>">
                          <?php

                              if($aValue['rtPosCode'] != ''){
                                  $tDisableTD     = "xWTdDisable";
                                  $tDisableImg    = "xWImgDisable";
                                  $tDisabledItem  = "disabled ";
                                  $tDisabledItem2  = "xCNDisabled ";
                                  $tDisabledcheckrow  = "true";
                              }else{
                                  $tDisableTD     = "";
                                  $tDisableImg    = "";
                                  $tDisabledItem  = "";
                                  $tDisabledItem2  = " ";
                                  $tDisabledcheckrow  = "false";
                              }
                          ?>
                            <td class="text-center">
              								<label class="fancy-checkbox">
              									<input id="ocbListItem<?php echo $key; ?>" type="checkbox"
                                <?php echo $tDisabledItem; ?>
                                data-checkrow="<?php echo $tDisabledcheckrow; ?>"
                                data-checkrowid="<?php echo $aValue['rtSmgCode']?>" checked="false"  class="ocbListItem" name="ocbListItem[]">
              									<span class="<?php echo $tDisabledItem2; ?>">&nbsp;</span>
              								</label>
              							</td>
                            <td class="text-center" style="padding-right: 10px !important;">
                                <?php echo FCNtHGetImagePageList($aValue['FTImgObj']); ?>

                                <?php
                                    // $aValue['FTImgObj'];
                                    // $tImgObj = substr($aValue['FTImgObj'], 0, 1);

                                    // if( $aValue['FTImgObj'] != "" ){
                                    //     $tImgObj = substr($aValue['FTImgObj'], 0, 1);
                                    //     if ($tImgObj != '#') {
                                    //         // $aValueImg = $aResult['aImgItems'][0];
                                    //         $aValue['FTImgObj'] = str_replace('\\','/',$aValue['FTImgObj']);
                                    //         $aValueImgExplode = explode('/modules/', $aValue['FTImgObj']);
                                    //         $tFullPatch = './application/modules/' . $aValueImgExplode[1];
                                    //         if( file_exists($tFullPatch) ){
                                    //             $tPatchImg = base_url() . 'application/modules/' . $aValueImgExplode[1];
                                    //         } else {
                                    //             $tPatchImg = base_url() . 'application/modules/common/assets/images/Noimage.png';
                                    //         }
                                    //     }else{
                                    //         $tColorCode = $aValue['FTImgObj'];
                                    //     }
                                    // }else{
                                    //     $tPatchImg = base_url() . 'application/modules/common/assets/images/Noimage.png';
                                    // }
                                ?>
                                <!-- <?php if( isset($tPatchImg) ){ ?>
                                        <img src="<?=$tPatchImg?>" class="img img-respornsive" style="width: 100%">
                                <?php }else{ ?>
                                        <span style="height:40px;width:100%;background-color:<?=$tColorCode?>;display:inline-block;"></span>
                                <?php } ?>
                                <?php unset($tPatchImg); unset($tColorCode); ?> -->
                            </td>
                            <td class="text-left otdSmgCode"><?php echo $aValue['rtSmgCode']; ?></td>
                            <td class="text-left"><?php echo $aValue['rtSmgTitle']; ?></td>
                            <td class="<?=$tDisableTD?>" id="otdDel<?php echo $aValue['rtSmgCode']?>">
                                <img id="oimDel<?php echo $aValue['rtSmgCode']; ?>" class="xCNIconTable <?php echo $tDisableImg; ?>" src="<?php echo  base_url().'/application/modules/common/assets/images/icons/delete.png'?>" onClick="JSaSlipMessageDelete('<?=$nCurrentPage?>','<?=$aValue['rtSmgTitle']?>','<?=$aValue['rtSmgCode']?>')" title="<?php echo language('pos/slipMessage/slipmessage', 'tSMGTBDelete'); ?>">
                            </td>
                            <td>
                                <img class="xCNIconTable" src="<?php echo  base_url().'/application/modules/common/assets/images/icons/edit.png'?>" onClick="JSvCallPageSlipMessageEdit('<?php echo $aValue['rtSmgCode']; ?>')" title="<?php echo language('pos/slipMessage/slipmessage', 'tSMGTBEdit'); ?>">
                            </td>
                        </tr>
                    <?php } ?>
                <?php else:?>
                    <tr><td class='text-center xCNTextDetail2' colspan='6'>ไม่พบข้อมูล</td></tr>
                <?php endif;?>
                </tbody>
			</table>
        </div>
    </div>
</div>

<div class="row">
    <!-- เปลี่ยน -->
    <div class="col-md-6">
        <p><?php echo language('common/main/main','tResultTotalRecord')?> <?=$aDataList['rnAllRow']?> <?php echo language('common/main/main','tRecord')?> <?php echo $aDataList['rnCurrentPage']; ?> / <?php echo $aDataList['rnAllPage']; ?></p>
    </div>
    <!-- เปลี่ยน -->
    <div class="col-md-6">
        <div class="xWPageGrp btn-toolbar pull-right"> <!-- เปลี่ยนชื่อ Class เป็นของเรื่องนั้นๆ -->
            <?php if($nPage == 1){ $tDisabledLeft = 'disabled'; }else{ $tDisabledLeft = '-';} ?>
            <button onclick="JSvSlipMessageClickPage('previous')" class="btn btn-white btn-sm" <?php echo $tDisabledLeft ?>> <!-- เปลี่ยนชื่อ Onclick เป็นของเรื่องนั้นๆ -->
                <i class="fa fa-chevron-left f-s-14 t-plus-1"></i>
            </button>
            <?php for($i=max($nPage-2, 1); $i<=max(0, min($aDataList['rnAllPage'],$nPage+2)); $i++){?> <!-- เปลี่ยนชื่อ Parameter Loop เป็นของเรื่องนั้นๆ -->
                <?php
                    if($nPage == $i){
                        $tActive = 'active';
                        $tDisPageNumber = 'disabled';
                    }else{
                        $tActive = '';
                        $tDisPageNumber = '';
                    }
                ?>
                <!-- เปลี่ยนชื่อ Onclick เป็นของเรื่องนั้นๆ -->
                <button onclick="JSvSlipMessageClickPage('<?php echo $i?>')" type="button" class="btn xCNBTNNumPagenation <?php echo $tActive ?>" <?php echo $tDisPageNumber ?>><?php echo $i?></button>
            <?php } ?>
            <?php if($nPage >= $aDataList['rnAllPage']){  $tDisabledRight = 'disabled'; }else{  $tDisabledRight = '-';  } ?>
            <button onclick="JSvSlipMessageClickPage('next')" class="btn btn-white btn-sm" <?php echo $tDisabledRight ?>> <!-- เปลี่ยนชื่อ Onclick เป็นของเรื่องนั้นๆ -->
                <i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
            </button>
        </div>
    </div>
</div>

<div class="modal fade" id="odvModalDelSlipMessage">
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
				<button id="osmConfirm" type="button" class="btn xCNBTNPrimery" onClick="JSnSlipMessageDelChoose('<?=$nCurrentPage?>')"><?=language('common/main/main', 'tModalConfirm')?></button>
        		<button type="button" class="btn xCNBTNDefult" data-dismiss="modal"><?=language('common/main/main', 'tModalCancel')?></button>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
$('ducument').ready(function(){
    JSxShowButtonChoose();
  $('.ocbListItem').prop('checked',false);
	var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
	var nlength = $('#odvRGPList').children('tr').length;
	for($i=0; $i < nlength; $i++){
		var tDataCode = $('#otrSlipMessage'+$i).data('code')
		if(aArrayConvert == null || aArrayConvert == ''){
		}else{
			var aReturnRepeat = findObjectByKey(aArrayConvert[0],'nCode',tDataCode);
			// if(aReturnRepeat == 'Dupilcate'){
			// 	$('#ocbListItem'+$i).prop('checked', true);
			// }else{ }
		}
	}

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
            JSxPaseCodeDelInModal();
        }else{
            var aReturnRepeat = findObjectByKey(aArrayConvert[0],'nCode',nCode);
            if(aReturnRepeat == 'None' ){           //ยังไม่ถูกเลือก
                obj.push({"nCode": nCode, "tName": tName });
                localStorage.setItem("LocalItemData",JSON.stringify(obj));
                JSxPaseCodeDelInModal();
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
                JSxPaseCodeDelInModal();
            }
        }
        JSxShowButtonChoose();
    })
});
</script>
