<?php 
    if($aPosDataList['rtCode'] == '1'){
        $nCurrentPage = $aPosDataList['rnCurrentPage'];
    }else{
        $nCurrentPage = '1';
    }
?>

<div class="row">
    <div class="col-md-12">
        <input type="hidden" id="nCurrentPageTBMain" value="<?php echo $nCurrentPage?>">
        <div class="table-responsive">
            <table id="otbPosDataList" class="table table-striped"> <!-- เปลี่ยน -->
                <thead>
                    <tr>
                        <th nowarp class="text-center xCNTextBold" style="width:10%;"><?php echo language('pos/salemachine/salemachine','tPOSChoose')?></th>
                        <th nowarp class="text-center xCNTextBold"><?php echo language('company/warehouse/warehouse','tBrowseBCHName')?></th>
                        <?php if(!FCNbGetIsShpEnabled()): ?>
                        <th nowarp class="text-center xCNTextBold"><?php echo language('company/warehouse/warehouse','tPOSShopRef')?></th>
                        <?php endif; ?>
                        <th nowarp class="text-center xCNTextBold"><?php echo language('pos/salemachine/salemachine','tPOSCode')?></th>
                        <th nowarp class="text-center xCNTextBold"><?php echo language('pos/salemachine/salemachine','tPOSName');?></th>
                        <th nowarp class="text-center xCNTextBold"><?php echo language('pos/salemachine/salemachine','tPOSRegNo')?></th>
                        <th nowarp class="text-center xCNTextBold"><?php echo language('pos/salemachine/salemachine','tPOSType')?></th>
                        <th nowarp class="text-center xCNTextBold"><?php echo language('pos/poschannel/poschannel','tCHNLabelTitle')?></th>
                        <th nowarp class="text-center xCNTextBold" style="width:10%;"><?php echo language('pos/salemachine/salemachine','tPOSDelete')?></th>
                        <th nowarp class="text-center xCNTextBold" style="width:10%;"><?php echo language('pos/salemachine/salemachine','tPOSEdit')?></th>
                    </tr>
                </thead>
                <tbody id="odvPOSList">
                    <?php 
                    if($aPosDataList['rtCode'] == 1 ):?>
                        <?php foreach($aPosDataList['raItems'] AS $nKey => $aValue):?> 
                            <?php 
                                // Create By : Napat(Jame) 04/12/2020
                                if( $aValue['FTVDPosShop'] != "" || $aValue['FTRTShopPos'] != "" ){
                                    $tOnClick       = "";
                                    $tClassDisabled = "xCNDocDisabled";
                                    $tAttrDisabled  = "disabled";
                                }else{
                                    $tPosName       = $aValue['rtPosName'];
                                    $tPosCode       = $aValue['rtPosCode'];
                                    $tBchCode       = $aValue['rtBchCode'];
                                    $tOnClick       = " onClick=\"JSoSaleMachineDel('$nCurrentPage','$tPosName','$tPosCode','$tBchCode')\" ";
                                    $tClassDisabled = "";
                                    $tAttrDisabled  = "";
                                }
                            ?>
                            <tr class="text-center xCNTextDetail2 otrSaleMachine" id="otrSaleMachine<?=$nKey?>" data-code="<?=$aValue['rtPosCode']?>" data-name="<?=$aValue['rtPosRegNo']?>"> 
                                <td class="text-center">
                                    <label class="fancy-checkbox">
                                        <input id="ocbListItem<?=$nKey;?>" type="checkbox" class="ocbListItem" name="ocbListItem[]" <?=$tAttrDisabled?> >
                                        <span>&nbsp;</span>
                                    </label>
                                </td>
                                <td class="text-left"><?=$aValue['rtBchName']?></td>
                                <?php if(!FCNbGetIsShpEnabled()): ?>
                                <td class="text-left">
                                    <?php if($aValue['rtShpName'] != ''){
                                        echo $aValue['rtShpName'];
                                    }else{
                                        echo "-";
                                    }?>
                                </td>
                                <?php endif; ?>
                                <td><?php echo $aValue['rtPosCode']?></td>
                                <td class="text-left"><?php echo $aValue['rtPosName']?></td>
                                <td class="text-left"><?php echo (!empty($aValue['rtPosRegNo']))? $aValue['rtPosRegNo'] : '-';?></td>
                                <?php
                                    if($aValue['rtPosType']=="1"){
                                        $tPosType  = language('pos/salemachine/salemachine','tPOSSalePoint');     
                                        //จุดขาย
                                    }elseif($aValue['rtPosType']=="2"){
                                        $tPosType  = language('pos/salemachine/salemachine','tPOSPrePaid'); 
                                        //จุดเติมเงิน
                                    }elseif($aValue['rtPosType']=="3"){
                                        $tPosType = language('pos/salemachine/salemachine','tPOSCheckPoint'); 
                                        //จุดตรวจสอบมูลค่า
                                    }elseif($aValue['rtPosType']=="4"){
                                        $tPosType = language('pos/salemachine/salemachine','tPOSVending'); 
                                        //จุดตรวจสอบมูลค่า
                                    } 
                                    elseif($aValue['rtPosType']=="5"){
                                        $tPosType = language('pos/salemachine/salemachine','tPOSSmartLoc'); 
                                        //จุดตรวจสอบมูลค่า
                                    }  
                                    elseif($aValue['rtPosType']=="6"){
                                        $tPosType = language('pos/salemachine/salemachine','tPOsVansale'); 
                                        //หน่วยรถ
                                    }   
                                    elseif($aValue['rtPosType']=="7"){
                                        $tPosType = language('pos/salemachine/salemachine','tPOSSCO'); 
                                        //จุดชำระเงินด้วยตัวเอง
                                    }    
                                ?>
                                <td class="text-left"><?php echo $tPosType; ?></td>
                                <td class="text-left"><?php echo $aValue['rtChnName']?></td>
                                <td>
                                    <img class="xCNIconTable <?=$tClassDisabled?>" src="<?php echo  base_url().'/application/modules/common/assets/images/icons/delete.png'?>" <?=$tOnClick?> >
                                </td>
                                <td>
                                    <img class="xCNIconTable" src="<?php echo  base_url().'/application/modules/common/assets/images/icons/edit.png'?>" onClick="JSvCallPageSaleMachineEdit('<?php echo $aValue['rtPosCode']?>','<?php echo  $aValue['rtPosType']?>','<?php echo  $aValue['rtBchCode']?>')">
                                </td>
                            </tr>
                        <?php endforeach;?>
                    <?php else:?>
                        <tr><td class='text-center xCNTextDetail2' colspan='99'><?php echo language('pos/salemachine/salemachine','tPOSNoData')?></td></tr>
                    <?php endif;?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php if( $aPosDataList['rtCode'] == '1' ){ ?>
<div class="row">
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
		<p><?php echo language('common/main/main','tResultTotalRecord')?> <?php echo $aPosDataList['rnAllRow']?> <?php echo language('common/main/main','tRecord')?> <?php echo language('common/main/main','tCurrentPage')?> <?php echo $aPosDataList['rnCurrentPage']?> / <?php echo $aPosDataList['rnAllPage']?></p>
    </div>
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        <div class="xWPageBank btn-toolbar pull-right">
			<?php if($nPage == 1){ $tDisabled = 'disabled'; }else{ $tDisabled = '-';} ?>
            <button onclick="JSvSaleMachineClickPage('previous')" class="btn btn-white btn-sm" <?php echo $tDisabled?>><i class="fa fa-chevron-left f-s-14 t-plus-1"></i></button>

			<?php for($i=max($nPage-2, 1); $i<=max(0, min($aPosDataList['rnAllPage'],$nPage+2)); $i++){?>
				<?php 
                    if($nPage == $i){ 
                        $tActive = 'active'; 
                        $tDisPageNumber = 'disabled';
                    }else{ 
                        $tActive = '';
                        $tDisPageNumber = '';
                    }
                ?>
            		<button onclick="JSvSaleMachineClickPage('<?php echo $i?>')" type="button" class="btn xCNBTNNumPagenation <?php echo $tActive?>" <?php echo $tDisPageNumber ?>><?php echo $i?></button>
			<?php } ?>

            <?php if($nPage >= $aPosDataList['rnAllPage']){ $tDisabled = 'disabled'; }else{ $tDisabled = '-'; } ?>
			<button onclick="JSvSaleMachineClickPage('next')" class="btn btn-white btn-sm" <?php echo $tDisabled?>><i class="fa fa-chevron-right f-s-14 t-plus-1"></i></button>
        </div>
    </div>
</div>
<?php } ?>

<div class="modal fade" id="odvModalDelSaleMachine">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header xCNModalHead">
				<label class="xCNTextModalHeard"><?php echo language('common/main/main', 'tModalDelete')?></label>
			</div>
			<div class="modal-body">
				<span id="ospConfirmDelete"> - </span>
				<input type='hidden' id="ohdConfirmIDDelete">
			</div>
			<div class="modal-footer">
				<button id="osmConfirm" type="button" class="btn xCNBTNPrimery" onClick="JSoSaleMachineDelChoose('<?php echo $nCurrentPage?>')"><?php echo language('common/main/main', 'tModalConfirm')?></button>
        		<button type="button" class="btn xCNBTNDefult" data-dismiss="modal"><?php echo language('common/main/main', 'tModalCancel')?></button>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
$('ducument').ready(function(){
    JSxSaleMachineShowButtonChoose();
	var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
    var nlength = $('#odvPOSList').children('tr').length;
	for($i=0; $i < nlength; $i++){
        var tDataCode = $('#otrSaleMachine'+$i).data('code')
		if(aArrayConvert == null || aArrayConvert == ''){
		}else{
			var aReturnRepeat = findObjectByKey(aArrayConvert[0],'nCode',tDataCode);
			if(aReturnRepeat == 'Dupilcate'){
				$('#ocbListItem'+$i).prop('checked', true);
			}else{ }
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
                JSxSaleMachinePaseCodeDelInModal();
        }else{
            var aReturnRepeat = findObjectByKey(aArrayConvert[0],'nCode',nCode);
            if(aReturnRepeat == 'None' ){           //ยังไม่ถูกเลือก
                obj.push({"nCode": nCode, "tName": tName });
                localStorage.setItem("LocalItemData",JSON.stringify(obj));
                JSxSaleMachinePaseCodeDelInModal();
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
                JSxSaleMachinePaseCodeDelInModal();
            }
        }
        JSxSaleMachineShowButtonChoose();
    })
});
</script>


