<?php
    if($aPosSpcCatDataList['tCode'] == '1'){
        $nCurrentPage = $aPosSpcCatDataList['nCurrentPage'];
    }else{
        $nCurrentPage = '1';
    }
?>

<div class="row">
    <div class="col-md-12">
        <input type="hidden" id="nCurrentPageTB" value="<?=$nCurrentPage?>">
        <div class="table-responsive">
            <table id="otbPhwDataList" class="table table-striped">
                <thead>
                    <tr>
                        <th nowarp class="text-center xCNTextBold" ><?= language('pos/salemachine/salemachine','tPOSChooseDevice')?></th>
                        <th nowarp class="text-center xCNTextBold" ><?= language('pos/salemachine/salemachine','tTabPosSpcCat1')?></th>
                        <th nowarp class="text-center xCNTextBold" ><?= language('pos/salemachine/salemachine','tTabPosSpcCat2')?></th>
                        <th nowarp class="text-center xCNTextBold" ><?= language('pos/salemachine/salemachine','tTabPosSpcCat3')?></th>
                        <th nowarp class="text-center xCNTextBold" ><?= language('pos/salemachine/salemachine','tTabPosSpcCat4')?></th>
                        <th nowarp class="text-center xCNTextBold" ><?= language('pos/salemachine/salemachine','tTabPosSpcCat5')?></th>
                        <th nowarp class="text-center xCNTextBold" ><?= language('pos/salemachine/salemachine','tTabPosSpcCatPdtGrp')?></th>
                        <th nowarp class="text-center xCNTextBold" ><?= language('pos/salemachine/salemachine','tTabPosSpcCatPdtType')?></th>
                        <th nowarp class="text-center xCNTextBold" ><?= language('pos/salemachine/salemachine','tTabPosSpcCatPdtBrand')?></th>
                        <th nowarp class="text-center xCNTextBold" ><?= language('pos/salemachine/salemachine','tTabPosSpcCatPdtModel')?></th>
                        <th nowarp class="text-center xCNTextBold" ><?= language('pos/salemachine/salemachine','tTabPosSpcCatPdtTouchGrp')?></th>
                        <th nowarp class="text-center xCNTextBold" ><?= language('common/main/main','tDelete')?></th>
                        <th nowarp class="text-center xCNTextBold" ><?= language('common/main/main','tEdit')?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if($aPosSpcCatDataList['tCode'] == 1 ):?>
                        <?php foreach($aPosSpcCatDataList['aItems'] AS $nKey => $aValue):?>
                            <tr class="text-center xCNTextDetail2" id="otrPSCDataList<?=$nKey?>" data-seq="<?=$aValue['FNCatSeq']?>">
                                <td nowarp class="text-center">
                                    <label class="fancy-checkbox">
                                        <input id="ocbListItem<?=$nKey?>" type="checkbox" class="ocbListItem" name="ocbListItem[]">
                                        <span>&nbsp;</span>
                                    </label>
                                </td>
                                <td nowarp class="text-left"><?=(empty($aValue['FTPdtCatName1']) ? '-' : $aValue['FTPdtCatName1'])?></td>
                                <td nowarp class="text-left"><?=(empty($aValue['FTPdtCatName2']) ? '-' : $aValue['FTPdtCatName2'])?></td>
                                <td nowarp class="text-left"><?=(empty($aValue['FTPdtCatName3']) ? '-' : $aValue['FTPdtCatName3'])?></td>
                                <td nowarp class="text-left"><?=(empty($aValue['FTPdtCatName4']) ? '-' : $aValue['FTPdtCatName4'])?></td>
                                <td nowarp class="text-left"><?=(empty($aValue['FTPdtCatName5']) ? '-' : $aValue['FTPdtCatName5'])?></td>
                                <td nowarp class="text-left"><?=(empty($aValue['FTPgpName']) ? '-' : $aValue['FTPgpName'])?></td>
                                <td nowarp class="text-left"><?=(empty($aValue['FTPtyName']) ? '-' : $aValue['FTPtyName'])?></td>
                                <td nowarp class="text-left"><?=(empty($aValue['FTPbnName']) ? '-' : $aValue['FTPbnName'])?></td>
                                <td nowarp class="text-left"><?=(empty($aValue['FTPmoName']) ? '-' : $aValue['FTPmoName'])?></td>
                                <td nowarp class="text-left"><?=(empty($aValue['FTTcgName']) ? '-' : $aValue['FTTcgName'])?></td>
                                <td nowarp>
                                    <img class="xCNIconTable xWClickDel" src="<?php echo  base_url().'/application/modules/common/assets/images/icons/delete.png'?>">
                                </td>
                                <td nowarp>
                                    <img class="xCNIconTable xWClickEdit" src="<?php echo  base_url().'/application/modules/common/assets/images/icons/edit.png'?>">
                                </td>
                            </tr>
                        <?php endforeach;?>
                    <?php else:?>
                        <tr><td class='text-center xCNTextDetail2' colspan='100%'><?= language('pos/salemachine/salemachine','tPOSNoData')?></td></tr>
                    <?php endif;?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php if($aPosSpcCatDataList['tCode'] == 1 ):?>
<div class="row">
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
		<p><?= language('common/main/main','tResultTotalRecord')?> <?=$aPosSpcCatDataList['nAllRow']?> <?= language('common/main/main','tRecord')?> <?= language('common/main/main','tCurrentPage')?> <?=$aPosSpcCatDataList['nCurrentPage']?> / <?=$aPosSpcCatDataList['nAllPage']?></p>
    </div>
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        <div class="xWPageSaleMachineDevice btn-toolbar pull-right">
			<?php if($nPage == 1){ $tDisabled = 'disabled'; }else{ $tDisabled = '-';} ?>
            <button onclick="JSvSaleMachineDeviceClickPage('previous')" class="btn btn-white btn-sm" <?=$tDisabled?>><i class="fa fa-chevron-left f-s-14 t-plus-1"></i></button>

			<?php for($i=max($nPage-2, 1); $i<=max(0, min($aPosSpcCatDataList['nAllPage'],$nPage+2)); $i++){?>
				<?php
                    if($nPage == $i){
                        $tActive = 'active';
                        $tDisPageNumber = 'disabled';
                    }else{
                        $tActive = '';
                        $tDisPageNumber = '';
                    }
                ?>
            		<button onclick="JSvSaleMachineDeviceClickPage('<?=$i?>')" type="button" class="btn xCNBTNNumPagenation <?=$tActive?>" <?=$tDisPageNumber ?>><?=$i?></button>
			<?php } ?>

            <?php if($nPage >= $aPosSpcCatDataList['nAllPage']){ $tDisabled = 'disabled'; }else{ $tDisabled = '-'; } ?>
			<button onclick="JSvSaleMachineDeviceClickPage('next')" class="btn btn-white btn-sm" <?=$tDisabled?>><i class="fa fa-chevron-right f-s-14 t-plus-1"></i></button>
        </div>
    </div>
</div>
<?php endif;?>

<div class="modal fade" id="odvPSCModalDel">
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
				<button id="osmConfirm" type="button" class="btn xCNBTNPrimery" onClick="JSxPSCDeleteMulti()"><?=language('common/main/main', 'tModalConfirm')?></button>
        		<button type="button" class="btn xCNBTNDefult" data-dismiss="modal"><?=language('common/main/main', 'tModalCancel')?></button>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">

    $('ducument').ready(function(){

        JSxShowButtonChoose();
        var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
        var nlength = $('#odvRGPList').children('tr').length;
        for($i=0; $i < nlength; $i++){
            var tDataCode = $('#otrPSCDataList'+$i).data('code')
            if(aArrayConvert == null || aArrayConvert == ''){
            }else{
                var aReturnRepeat = findObjectByKey(aArrayConvert[0],'nCode',tDataCode);
                if(aReturnRepeat == 'Dupilcate'){
                    $('#ocbListItem'+$i).prop('checked', true);
                }else{ }
            }
        }

        $('.ocbListItem').click(function(){
            var nCode = $(this).parent().parent().parent().data('seq');  //code
            var tName = $(this).parent().parent().parent().data('seq');  //code
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

    function JSxPaseCodeDelInModal() {
        var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
        if (aArrayConvert[0] == null || aArrayConvert[0] == '') {} else {
            var tTextCode = '';
            for ($i = 0; $i < aArrayConvert[0].length; $i++) {
                tTextCode += aArrayConvert[0][$i].nCode;
                tTextCode += ',';
            }
            $('#odvPSCModalDel #ospConfirmDelete').text($('#oetTextComfirmDeleteMulti').val());
            $('#odvPSCModalDel #ohdConfirmIDDelete').val(tTextCode);
        }
    }

    function JSxShowButtonChoose() {
        var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
        if (aArrayConvert[0] == null || aArrayConvert[0] == '') {
            $('#odvMngTableList #oliBtnDeleteAll').addClass('disabled');
        } else {
            nNumOfArr = aArrayConvert[0].length;
            if (nNumOfArr > 1) {
                $('#odvMngTableList #oliBtnDeleteAll').removeClass('disabled');
            } else {
                $('#odvMngTableList #oliBtnDeleteAll').addClass('disabled');
            }
        }
    }

    function findObjectByKey(array, key, value) {
        for (var i = 0; i < array.length; i++) {
            if (array[i][key] === value) {
                return 'Dupilcate';
            }
        }
        return 'None';
    }

    function JSxPSCDeleteMulti() {
        JCNxOpenLoading();
        $('#odvPSCModalDel').modal('hide');
        var tCurrentPage        = $("#nCurrentPageTB").val();
        var aData               = $('#odvPSCModalDel #ohdConfirmIDDelete').val();
        var aTexts              = aData.substring(0, aData.length - 1);
        var aDataSplit          = aTexts.split(",");
        var aDataSplitlength    = aDataSplit.length;
        var aNewIdDelete        = [];

        for ($i = 0; $i < aDataSplitlength; $i++) {
            aNewIdDelete.push(aDataSplit[$i]);
        }

        if( aDataSplitlength > 1 ){

            var tBchCode    = $('#ohdBchCode').val();
            var tShpCode    = $('#ohdShpCode').val();
            var tPosCode    = $('#oetPosCode').val();

            $.ajax({
                type: "POST",
                url: "masPOSSpcCatEventDelete",
                data: {
                    'aCatSeq'       : aNewIdDelete,
                    'tBchCode'      : tBchCode,
                    'tShpCode'      : tShpCode,
                    'tPosCode'      : tPosCode
                },
                success: function(tResult) {
                    var aReturn = JSON.parse(tResult);
                    if (aReturn['nStaEvent'] == '1') {
                        $('#odvPSCModalDel #ospConfirmDelete').empty();
                        localStorage.removeItem('LocalItemData');
                        $('#odvPSCModalDel #ohdConfirmIDDelete').val('');
                        $('#odvPSCModalDel #ospConfirmIDDelete').val('');
                        setTimeout(function() {
                            JSxPosSpcCatDataList();
                        }, 500);
                    } else {
                        FSvCMNSetMsgWarningDialog(aReturn['tStaMessg']);
                        JCNxCloseLoading();
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }else{
            return false;
        }
    }

    
    $('.xWClickDel').off('click').on('click',function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){

            var tBchCode        = $('#ohdBchCode').val();
            var tShpCode        = $('#ohdShpCode').val();
            var tPosCode        = $('#oetPosCode').val();
            var aNewIdDelete    = [];
            var nSeq            = $(this).parents().parents().attr('data-seq');
            var tConfirm        = $('#oetTextComfirmDeleteSingle').val();
            var tConfirmYN      = $('#oetTextComfirmDeleteYesOrNot').val();

            aNewIdDelete.push(nSeq);

            $('#odvPSCModalDel').modal('show');
            $('#odvPSCModalDel #ospConfirmDelete').text(tConfirm + ' ลำดับที่ ' + nSeq + ' ' + tConfirmYN);
            $('#odvPSCModalDel #osmConfirm').off('click').on('click', function() {
                JCNxOpenLoading();
                $.ajax({
                    type: "POST",
                    url: "masPOSSpcCatEventDelete",
                    data: {
                        'aCatSeq'       : aNewIdDelete,
                        'tBchCode'      : tBchCode,
                        'tShpCode'      : tShpCode,
                        'tPosCode'      : tPosCode
                    },
                    success: function(tResult) {
                        var aReturn = JSON.parse(tResult);
                        if (aReturn['nStaEvent'] == '1') {
                            JSxPosSpcCatDataList();
                        } else {
                            FSvCMNSetMsgWarningDialog(aReturn['tStaMessg']);
                            JCNxCloseLoading();
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            });
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    $('.xWClickEdit').off('click').on('click',function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            var tBchCode    = $('#ohdBchCode').val();
            var tShpCode    = $('#ohdShpCode').val();
            var tPosCode    = $('#oetPosCode').val();
            var nSeq        = $(this).parents().parents().attr('data-seq');

            JSxPosSpcCatControlButton('PageEdit');

            JCNxOpenLoading();
            $.ajax({
                type: "POST",
                url: "masPOSSpcCatPageEdit",
                data: {
                    tBchCode : tBchCode,
                    tShpCode : tShpCode,
                    tPosCode : tPosCode,
                    nSeq     : nSeq
                },
                cache	: false,
                timeout	: 0,
                success	: function(tResult){
                    $('#odvPosSpcCatData').html(tResult);
                    JCNxCloseLoading();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

</script>
