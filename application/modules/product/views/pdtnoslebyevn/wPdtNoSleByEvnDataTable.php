<style>
    .table > tbody > tr > td > i {
        display : block;
    }
    .xCNBorderRight{
        border-right:1px solid #cccccc;
    }
    .xCNNonBorder{
        border-top:0px!important;
    }
    .xCNBorderBottom{
        border-bottom:1px solid #cccccc;
    }
    .xWFirtRowData{
        border-top:1px!important;
    }
</style>

<?php 
    if($aEvnDataList['rtCode'] == '1'){
        $nCurrentPage =  $aEvnDataList['rnCurrentPage'];
    }else{
        $nCurrentPage = '1';
    }
?>


<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            <table id="otbEvnDataList" class="table table-striped">
                <thead>
                    <tr>
                        <?php if($aAlwEventPdtNoSieByEvn['tAutStaFull'] == 1 || $aAlwEventPdtNoSieByEvn['tAutStaDelete'] == 1) : ?>
                        <th class="text-center xCNTextBold" style="width:10%;"><?= language('product/pdtnoslebyevn/pdtnoslebyevn','tEVNTBChoose')?></th>
                        <?php endif; ?>
                        <th class="text-center xCNTextBold"><?= language('product/pdtnoslebyevn/pdtnoslebyevn','tEVNTBCode')?></th>
                        <th class="text-center xCNTextBold"><?= language('product/pdtnoslebyevn/pdtnoslebyevn','tEVNTBName')?></th>
                        <th class="text-center xCNTextBold"><?= language('product/pdtnoslebyevn/pdtnoslebyevn','tEVNTBType')?></th>
                        <th class="text-center xCNTextBold"><?= language('product/pdtnoslebyevn/pdtnoslebyevn','tEVNTBDStart')?></th>
                        <th class="text-center xCNTextBold"><?= language('product/pdtnoslebyevn/pdtnoslebyevn','tEVNTBTStart')?></th>
                        <th class="text-center xCNTextBold"><?= language('product/pdtnoslebyevn/pdtnoslebyevn','tEVNTBDFinish')?></th>
                        <th class="text-center xCNTextBold"><?= language('product/pdtnoslebyevn/pdtnoslebyevn','tEVNTBTFinish')?></th>
                        <?php if($aAlwEventPdtNoSieByEvn['tAutStaFull'] == 1 || $aAlwEventPdtNoSieByEvn['tAutStaDelete'] == 1) : ?>
                        <th class="text-center xCNTextBold" style="width:5%;"><?= language('product/pdtnoslebyevn/pdtnoslebyevn','tEVNTBDelete')?></th>
                        <?php endif; ?>
                        <?php if($aAlwEventPdtNoSieByEvn['tAutStaFull'] == 1 || ($aAlwEventPdtNoSieByEvn['tAutStaEdit'] == 1 || $aAlwEventPdtNoSieByEvn['tAutStaRead'] == 1))  : ?>
                        <th class="text-center xCNTextBold" style="width:5%;"><?= language('product/pdtnoslebyevn/pdtnoslebyevn','tEVNTBEdit')?></th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php if(isset($aEvnDataList) && $aEvnDataList['rtCode'] == 1):?>
                        <?php 
                            $tEvnCode = "";
                            $nI = 0;
                        ?>
                        <?php foreach($aEvnDataList['raItems'] AS $nKey => $aValue):?>
                            <?php 
                                if($tEvnCode != $aValue['rtEvnCode']):  $tEvnCode = $aValue['rtEvnCode'];?>
                                <tr class="text-center xCNTextDetail2 otrPdtEvn" id="otrPdtEvn<?=$nKey?>" data-code="<?=$aValue['rtEvnCode']?>" data-name="<?=$aValue['rtEvnName']?>">
                                    <?php 
                                    if($aValue['rtEvnSeqNo']==1){
                                    ?>
                                        <td class="text-center" rowspan="<?php 
                                        if(($aValue['rtEvnMaxSeqNo']-($aValue['rtEvnSeqNo']-1))<=(10-$nI)){
                                            echo $aValue['rtEvnMaxSeqNo']; 
                                        }else{
                                            echo (10-$nI);
                                        }
                                        ?>">
                                        <?php if($aAlwEventPdtNoSieByEvn['tAutStaFull'] == 1 || $aAlwEventPdtNoSieByEvn['tAutStaDelete'] == 1) : ?>
                                            <label class="fancy-checkbox">
                                                <input id="ocbListItem<?=$nKey?>" type="checkbox" class="ocbListItem" name="ocbListItem[]">
                                                <span>&nbsp;</span>
                                            </label>
                                        <?php endif; ?>
                                        </td>
                                        <td rowspan="<?php 
                                        if(($aValue['rtEvnMaxSeqNo']-($aValue['rtEvnSeqNo']-1))<=(10-$nI)){
                                            echo $aValue['rtEvnMaxSeqNo']; 
                                        }else{
                                            echo (10-$nI);
                                        }
                                        ?>"><?=$aValue['rtEvnCode']?></td>
                                        <td class="text-left" rowspan="<?php 
                                        if(($aValue['rtEvnMaxSeqNo']-($aValue['rtEvnSeqNo']-1))<=(10-$nI)){
                                            echo $aValue['rtEvnMaxSeqNo']; 
                                        }else{
                                            echo (10-$nI);
                                        }
                                        ?>"><?=$aValue['rtEvnName']?></td>
                                    <?php
                                    }else{
                                        if($nI==0){
                                    ?>
                                            <td class="text-center" rowspan="<?php 
                                            if(($aValue['rtEvnMaxSeqNo']-($aValue['rtEvnSeqNo']-1))<=(10-$nI)){
                                                echo $aValue['rtEvnMaxSeqNo']; 
                                            }else{
                                                echo (10-$nI);
                                            }
                                            ?>">
                                            <?php if($aAlwEventPdtNoSieByEvn['tAutStaFull'] == 1 || $aAlwEventPdtNoSieByEvn['tAutStaDelete'] == 1) : ?>
                                                <label class="fancy-checkbox">
                                                    <input id="ocbListItem<?=$nKey?>" type="checkbox" class="ocbListItem" name="ocbListItem[]">
                                                    <span>&nbsp;</span>
                                                </label>
                                            <?php endif; ?>
                                            </td>
                                            <td rowspan="<?php 
                                            if(($aValue['rtEvnMaxSeqNo']-($aValue['rtEvnSeqNo']-1))<=(10-$nI)){
                                                echo $aValue['rtEvnMaxSeqNo']; 
                                            }else{
                                                echo (10-$nI);
                                            }
                                            ?>"><?=$aValue['rtEvnCode']?></td>
                                            <td class="text-left" rowspan="<?php 
                                            if(($aValue['rtEvnMaxSeqNo']-($aValue['rtEvnSeqNo']-1))<=(10-$nI)){
                                                echo $aValue['rtEvnMaxSeqNo']; 
                                            }else{
                                                echo (10-$nI);
                                            }
                                            ?>"><?=$aValue['rtEvnName']?></td>
                                    <?php        
                                        }
                                    }
                                    ?>
                                    
                                    
                                    
                                    
                                    
                                    <?php 
                                        if($aValue['rtEvnType'] == 1){
                                            $tEvnType = language('product/pdtnoslebyevn/pdtnoslebyevn','tEVNTBTypeTime');
                                        }else{
                                            $tEvnType = language('product/pdtnoslebyevn/pdtnoslebyevn','tEVNTBTypeDay');
                                        }                                  
                                    ?>
                                    <td><?=$tEvnType;?></td>
                                    <td><?=(!empty($aValue['rtEvnDStart']))?   date("Y-m-d",strtotime($aValue['rtEvnDStart']))     : '-' ?></td>
                                    <td><?=(!empty($aValue['rtEvnTStart']))?   date("H:i:s",strtotime($aValue['rtEvnTStart']))     : '-' ?></td>
                                    <td><?=(!empty($aValue['rtEvnDFinish']))?  date("Y-m-d",strtotime($aValue['rtEvnDFinish']))    : '-' ?></td>
                                    <td><?=(!empty($aValue['rtEvnTFinish']))?  date("H:i:s",strtotime($aValue['rtEvnTFinish']))    : '-' ?></td>
                                    <?php 
                                    if($aValue['rtEvnSeqNo']==1){
                                    ?>
                                    <?php if($aAlwEventPdtNoSieByEvn['tAutStaFull'] == 1 || $aAlwEventPdtNoSieByEvn['tAutStaDelete'] == 1) : ?>
                                    <td rowspan="<?php 
                                        if(($aValue['rtEvnMaxSeqNo']-($aValue['rtEvnSeqNo']-1))<=(10-$nI)){
                                            echo $aValue['rtEvnMaxSeqNo']; 
                                        }else{
                                            echo (10-$nI);
                                        }
                                        ?>">
                                        <img class="xCNIconTable" src="<?php echo  base_url().'/application/modules/common/assets/images/icons/delete.png'?>" onClick="JSoPdtNoSleByEvnDel('<?=$nCurrentPage?>','<?=$aValue['rtEvnName']?>','<?php echo $aValue['rtEvnCode']?>')">
                                    </td>
                                    <?php endif; ?>
                                    <?php if($aAlwEventPdtNoSieByEvn['tAutStaFull'] == 1 || ($aAlwEventPdtNoSieByEvn['tAutStaEdit'] == 1 || $aAlwEventPdtNoSieByEvn['tAutStaRead'] == 1)) : ?>
                                    <td rowspan="<?php 
                                        if(($aValue['rtEvnMaxSeqNo']-($aValue['rtEvnSeqNo']-1))<=(10-$nI)){
                                            echo $aValue['rtEvnMaxSeqNo']; 
                                        }else{
                                            echo (10-$nI);
                                        }
                                        ?>">
                                        <img class="xCNIconTable" src="<?php echo  base_url().'/application/modules/common/assets/images/icons/edit.png'?>" onClick="JSvCallPagePdtNoSleByEvnEdit('<?php echo $aValue['rtEvnCode']?>')">
                                    </td>
                                    <?php endif; ?>
                                    <?php
                                    }else{
                                        if($nI==0){
                                            ?>
                                            <?php if($aAlwEventPdtNoSieByEvn['tAutStaFull'] == 1 || $aAlwEventPdtNoSieByEvn['tAutStaDelete'] == 1) : ?>
                                            <td rowspan="<?php 
                                                if(($aValue['rtEvnMaxSeqNo']-($aValue['rtEvnSeqNo']-1))<=(10-$nI)){
                                                    echo $aValue['rtEvnMaxSeqNo']; 
                                                }else{
                                                    echo (10-$nI);
                                                }
                                                ?>">
                                                <img class="xCNIconTable" src="<?php echo  base_url().'/application/modules/common/assets/images/icons/delete.png'?>" onClick="JSoPdtNoSleByEvnDel('<?=$nCurrentPage?>','<?=$aValue['rtEvnName']?>','<?php echo $aValue['rtEvnCode']?>')">
                                            </td>
                                            <?php endif; ?>
                                            <?php if($aAlwEventPdtNoSieByEvn['tAutStaFull'] == 1 || ($aAlwEventPdtNoSieByEvn['tAutStaEdit'] == 1 || $aAlwEventPdtNoSieByEvn['tAutStaRead'] == 1)) : ?>
                                            <td rowspan="<?php 
                                                if(($aValue['rtEvnMaxSeqNo']-($aValue['rtEvnSeqNo']-1))<=(10-$nI)){
                                                    echo $aValue['rtEvnMaxSeqNo']; 
                                                }else{
                                                    echo (10-$nI);
                                                }
                                                ?>">
                                                <img class="xCNIconTable" src="<?php echo  base_url().'/application/modules/common/assets/images/icons/edit.png'?>" onClick="JSvCallPagePdtNoSleByEvnEdit('<?php echo $aValue['rtEvnCode']?>')">
                                            </td>
                                            <?php endif; ?>
                                            <?php    
                                        }
                                    }
                                    ?>
                                </tr>
                            <?php else: ?>
                                <tr class="text-center xCNTextDetail2 xWNoSaleEvn<?=$aValue['rtEvnCode']?>">
                                    <?php 
                                    if($aValue['rtEvnSeqNo']==1){
                                    ?>
                                    <td class="xCNNonBorder" rowspan="<?php 
                                        if(($aValue['rtEvnMaxSeqNo']-($aValue['rtEvnSeqNo']-1))<=(10-$nI)){
                                            echo $aValue['rtEvnMaxSeqNo']; 
                                        }else{
                                            echo (10-$nI);
                                        }
                                        ?>"></td>
                                    <td class="xCNNonBorder" rowspan="<?php 
                                        if(($aValue['rtEvnMaxSeqNo']-($aValue['rtEvnSeqNo']-1))<=(10-$nI)){
                                            echo $aValue['rtEvnMaxSeqNo']; 
                                        }else{
                                            echo (10-$nI);
                                        }
                                        ?>"></td>
                                    <td class="xCNNonBorder" rowspan="<?php 
                                        if(($aValue['rtEvnMaxSeqNo']-($aValue['rtEvnSeqNo']-1))<=(10-$nI)){
                                            echo $aValue['rtEvnMaxSeqNo']; 
                                        }else{
                                            echo (10-$nI);
                                        }
                                        ?>"></td>
                                    <?php
                                    }else{
                                        if($nI==0){
                                    ?>
                                    <td class="xCNNonBorder" rowspan="<?php 
                                        if(($aValue['rtEvnMaxSeqNo']-($aValue['rtEvnSeqNo']-1))<=(10-$nI)){
                                            echo $aValue['rtEvnMaxSeqNo']; 
                                        }else{
                                            echo (10-$nI);
                                        }
                                        ?>"></td>
                                    <td class="xCNNonBorder" rowspan="<?php 
                                        if(($aValue['rtEvnMaxSeqNo']-($aValue['rtEvnSeqNo']-1))<=(10-$nI)){
                                            echo $aValue['rtEvnMaxSeqNo']; 
                                        }else{
                                            echo (10-$nI);
                                        }
                                        ?>"></td>
                                    <td class="xCNNonBorder" rowspan="<?php 
                                        if(($aValue['rtEvnMaxSeqNo']-($aValue['rtEvnSeqNo']-1))<=(10-$nI)){
                                            echo $aValue['rtEvnMaxSeqNo']; 
                                        }else{
                                            echo (10-$nI);
                                        }
                                        ?>"></td>
                                    <?php
                                        }
                                    }
                                    ?>
                                    
                                   
                                    <?php 
                                        if($aValue['rtEvnType'] == 1){
                                            $tEvnType = language('product/pdtnoslebyevn/pdtnoslebyevn','tEVNTBTypeTime');
                                        }else{
                                            $tEvnType = language('product/pdtnoslebyevn/pdtnoslebyevn','tEVNTBTypeDay');
                                        }                                  
                                    ?>
                                    <td class="xCNNonBorder"><?=$tEvnType;?></td>
                                    <td class="xCNNonBorder"><?=(!empty($aValue['rtEvnDStart']))?   date("Y-m-d",strtotime($aValue['rtEvnDStart']))     : '-' ?></td>
                                    <td class="xCNNonBorder"><?=(!empty($aValue['rtEvnTStart']))?   date("H:i:s",strtotime($aValue['rtEvnTStart']))     : '-' ?></td>
                                    <td class="xCNNonBorder"><?=(!empty($aValue['rtEvnDFinish']))?  date("Y-m-d",strtotime($aValue['rtEvnDFinish']))    : '-' ?></td>
                                    <td class="xCNNonBorder"><?=(!empty($aValue['rtEvnTFinish']))?  date("H:i:s",strtotime($aValue['rtEvnTFinish']))    : '-' ?></td>
                                    <?php 
                                    if($aValue['rtEvnSeqNo']==1){
                                    ?>
                                    <td class="xCNNonBorder" rowspan="<?php 
                                        if(($aValue['rtEvnMaxSeqNo']-($aValue['rtEvnSeqNo']-1))<=(10-$nI)){
                                            echo $aValue['rtEvnMaxSeqNo']; 
                                        }else{
                                            echo (10-$nI);
                                        }
                                        ?>"></td>
                                    <td class="xCNNonBorder" rowspan="<?php 
                                        if(($aValue['rtEvnMaxSeqNo']-($aValue['rtEvnSeqNo']-1))<=(10-$nI)){
                                            echo $aValue['rtEvnMaxSeqNo']; 
                                        }else{
                                            echo (10-$nI);
                                        }
                                        ?>"></td>
                                    <?php
                                    }else{
                                        if($nI==0){
                                            ?>
                                            <td class="xCNNonBorder" rowspan="<?php 
                                                if(($aValue['rtEvnMaxSeqNo']-($aValue['rtEvnSeqNo']-1))<=(10-$nI)){
                                                    echo $aValue['rtEvnMaxSeqNo']; 
                                                }else{
                                                    echo (10-$nI);
                                                }
                                                ?>"></td>
                                            <td class="xCNNonBorder" rowspan="<?php 
                                                if(($aValue['rtEvnMaxSeqNo']-($aValue['rtEvnSeqNo']-1))<=(10-$nI)){
                                                    echo $aValue['rtEvnMaxSeqNo']; 
                                                }else{
                                                    echo (10-$nI);
                                                }
                                                ?>"></td>
                                            <?php    
                                        }
                                    }
                                    ?>
                                </tr>
                            <?php endif;?>
                        <?php 
                            $nI++;
                            endforeach;
                        ?>
                    <?php else:?>
                        <tr><td class='text-center xCNTextDetail2' colspan='10'><?= language('product/pdtnoslebyevn/pdtnoslebyevn','tEVNTBNoData')?></td></tr>
                    <?php endif;?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="row">
	<!-- เปลี่ยน -->
	<div class="col-md-6">
        <p><?= language('common/main/main','tResultTotalRecord')?> <?=$aEvnDataList['rnAllRow']?> <?= language('common/main/main','tRecord')?> <?= language('common/main/main','tCurrentPage')?> <?=$aEvnDataList['rnCurrentPage']?> / <?=$aEvnDataList['rnAllPage']?></p>
    </div>
	<!-- เปลี่ยน -->
    <div class="col-md-6">
        <div class="xWPagePdtNoSleByEvn btn-toolbar pull-right"> <!-- เปลี่ยนชื่อ Class เป็นของเรื่องนั้นๆ --> 
            <?php if($nPage == 1){ $tDisabledLeft = 'disabled'; }else{ $tDisabledLeft = '-';} ?>
            <button onclick="JSvClickPage('previous')" class="btn btn-white btn-sm" <?php echo $tDisabledLeft ?>> <!-- เปลี่ยนชื่อ Onclick เป็นของเรื่องนั้นๆ --> 
                <i class="fa fa-chevron-left f-s-14 t-plus-1"></i>
            </button>
            <?php for($i=max($nPage-2, 1); $i<=max(0, min($aEvnDataList['rnAllPage'],$nPage+2)); $i++){?> <!-- เปลี่ยนชื่อ Parameter Loop เป็นของเรื่องนั้นๆ --> 
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
                <button onclick="JSvClickPage('<?php echo $i?>')" type="button" class="btn xCNBTNNumPagenation <?php echo $tActive ?>" <?php echo $tDisPageNumber ?>><?php echo $i?></button>
            <?php } ?>
            <?php if($nPage >= $aEvnDataList['rnAllPage']){  $tDisabledRight = 'disabled'; }else{  $tDisabledRight = '-';  } ?>
            <button onclick="JSvClickPage('next')" class="btn btn-white btn-sm" <?php echo $tDisabledRight ?>> <!-- เปลี่ยนชื่อ Onclick เป็นของเรื่องนั้นๆ --> 
                <i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
            </button>
        </div>
    </div>
</div>

<!-- <div class="modal fade" id="odvModalDelPdtNoSleByEvn">
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
            <button id="osmConfirm" type="button" class="btn xCNBTNPrimery" onClick="JSoPdtNoSleByEvnDelChoose()">
                <?=language('common/main/main', 'tModalConfirm')?> 
                    </button>
                        <button type="button" class="btn xCNBTNDefult" data-dismiss="modal">
                    <?=language('common/main/main', 'tModalCancel')?> 
                </button>
            </div>
        </div>
    </div>
</div> -->

<div class="modal fade" id="odvModalDelPdtNoSleByEvn">
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
				<button id="osmConfirm" type="button" class="btn xCNBTNPrimery" onClick="JSoPdtNoSleByEvnDelChoose('<?=$nCurrentPage?>')"><?=language('common/main/main', 'tModalConfirm')?></button>
        		<button type="button" class="btn xCNBTNDefult" data-dismiss="modal"><?=language('common/main/main', 'tModalCancel')?></button>
			</div>
		</div>
	</div>
</div>

<!-- <div class="row">
</div> -->
<script type="text/javascript">
$('ducument').ready(function(){
    JSxShowButtonChoose();
	var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
	var nlength = $('#odvRGPList').children('tr').length;
	for($i=0; $i < nlength; $i++){
		var tDataCode = $('#otrPdtEvn'+$i).data('code')
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
            JSxTextinModal();
        }else{
            var aReturnRepeat = findObjectByKey(aArrayConvert[0],'nCode',nCode);
            if(aReturnRepeat == 'None' ){           //ยังไม่ถูกเลือก
                obj.push({"nCode": nCode, "tName": tName });
                localStorage.setItem("LocalItemData",JSON.stringify(obj));
                JSxTextinModal();
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
                JSxTextinModal();
            }
        }
        JSxShowButtonChoose();
    })
});
    // $('.ocbListItem').click(function(){
    //     var nCode = $(this).parent().parent().parent().data('code');  //code
    //     var tName = $(this).parent().parent().parent().data('name');  //code
    //     $(this).prop('checked', true);
    //     var LocalItemData = localStorage.getItem("LocalItemData");
    //     var obj = [];
    //     if(LocalItemData){
    //         obj = JSON.parse(LocalItemData);
    //     }else{ }
    //     var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
    //     if(aArrayConvert == '' || aArrayConvert == null){
    //         obj.push({"nCode": nCode, "tName": tName });
    //         localStorage.setItem("LocalItemData",JSON.stringify(obj));
    //         JSxTextinModal();
    //     }else{
    //         var aReturnRepeat = findObjectByKey(aArrayConvert[0],'nCode',nCode);
    //         if(aReturnRepeat == 'None' ){           //ยังไม่ถูกเลือก
    //             obj.push({"nCode": nCode, "tName": tName });
    //             localStorage.setItem("LocalItemData",JSON.stringify(obj));
    //             JSxTextinModal();
    //         }else if(aReturnRepeat == 'Dupilcate'){	//เคยเลือกไว้แล้ว
    //             localStorage.removeItem("LocalItemData");
    //             $(this).prop('checked', false);
    //             var nLength = aArrayConvert[0].length;
    //             for($i=0; $i<nLength; $i++){
    //                 if(aArrayConvert[0][$i].nCode == nCode){
    //                     delete aArrayConvert[0][$i];
    //                 }
    //             }
    //             var aNewarraydata = [];
    //             for($i=0; $i<nLength; $i++){
    //                 if(aArrayConvert[0][$i] != undefined){
    //                     aNewarraydata.push(aArrayConvert[0][$i]);
    //                 }
    //             }
    //             localStorage.setItem("LocalItemData",JSON.stringify(aNewarraydata));
    //             JSxTextinModal();
    //         }
    //     }
    //     JSxShowButtonChoose();
    // });
</script>
