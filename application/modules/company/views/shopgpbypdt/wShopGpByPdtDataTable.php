<!--Lang Modal Delete-->
<input type="hidden" name="ohdDeleteconfirm" id="ohdDeleteconfirm" value="<?=language('common/main/main', 'tModalConfirmDeleteItems') ?>">
<input type="hidden" name="ohdDeleteconfirmYN" id="ohdDeleteconfirmYN" value="<?=language('common/main/main', 'tModalConfirmDeleteItemsYN') ?>">

<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="table-responsive">
            <table id="otbShopGpByShpListTable" class="table table-striped">
                <thead>
                    <tr>
                        <?php if($aAlwEventGpShop['tAutStaFull'] == 1 || $aAlwEventGpShop['tAutStaDelete'] == 1) : ?>
                        <th nowrap class="text-center xCNTextBold" style="width:10%;"><?php echo  language('company/shopgpbypdt/shopgpbypdt','tSGPPTableChoose')?></th>
                        <?php endif; ?>

                        <?php 
                        $tSesUserLevel = $this->session->userdata("tSesUsrLevel");
                        if($tSesUserLevel == 'HQ'){ ?>
                            <th nowrap class="text-left xCNTextBold" style="width:200px;"><?php echo  language('company/shopgpbypdt/shopgpbypdt','tSGPPTableBch');?></th>
                            <th nowrap class="text-left xCNTextBold" style="width:200px;"><?php echo  language('company/shopgpbypdt/shopgpbypdt','tSGPPTableShop');?></th>
                        <?php } ?>

                        <th nowrap class="text-left xCNTextBold" style="width:70%;"><?php echo  language('company/shopgpbypdt/shopgpbypdt','tSGPPTableDateStart');?></th>

                        <?php if($aAlwEventGpShop['tAutStaFull'] == 1 || $aAlwEventGpShop['tAutStaDelete'] == 1) : ?>
                        <th nowrap class="text-center xCNTextBold" style="width:10%;"><?php  echo  language('company/shopgpbypdt/shopgpbypdt','tSGPPTableDel')?></th>
                        <?php endif; ?>

                        <?php if($aAlwEventGpShop['tAutStaFull'] == 1 || ($aAlwEventGpShop['tAutStaEdit'] == 1 || $aAlwEventGpShop['tAutStaRead'] == 1))  : ?>
                        <th nowrap class="text-center xCNTextBold" style="width:10%;"><?php  echo  language('company/shopgpbypdt/shopgpbypdt','tSGPPTableEdit')?></th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody id="odvRGPList">
                    <?php if($aDataList['rtCode'] == '1'):?>
                        <?php foreach($aDataList['raItems'] AS $nKey => $aValue):?>
                            <tr data-code="<?=date("Y-m-d", strtotime($aValue['FDSgpStart'])); ?>" 
                                data-name="<?=$aValue['FTBchCode']?>"
                                data-seq="<?=$aValue['FNSgpSeq']?>">
                                <!--เลือก-->
                                <?php if($aAlwEventGpShop['tAutStaFull'] == 1 || $aAlwEventGpShop['tAutStaDelete'] == 1) : ?>
                                    <td class="text-center">
                                        <label class="fancy-checkbox">
                                            <input id="ocbListItemMainGP<?php echo $nKey?>" type="checkbox" class="ocbListItemMainGP" name="ocbListItemMainGP[]">
                                            <span>&nbsp;</span>
                                        </label>
                                    </td>
                                <?php endif; ?>

                                <?php 
                                $tSesUserLevel = $this->session->userdata("tSesUsrLevel");
                                if($tSesUserLevel == 'HQ'){ ?>
                                    <td nowrap class="text-left"><?=$aValue['FTBchName']?></td>
                                    <td nowrap class="text-left"><?=$aValue['FTShpName']?></td>
                                <?php } ?>


                                <!--วันที่มีผล-->
                                <td nowrap class="text-left"><?=date("d/m/Y", strtotime($aValue['FDSgpStart'])); ?></td>
                                
                                <!--ปุ่มลบ-->
                                <?php if($aAlwEventGpShop['tAutStaFull'] == 1 || $aAlwEventGpShop['tAutStaDelete'] == 1) : ?>
                                    <td nowrap class="text-center">
                                        <img class="xCNIconTable" id="oimGpShopRowDel" src="<?=base_url().'/application/modules/common/assets/images/icons/delete.png'?>"  onClick="JSxShopGPDeleteMainRecord('<?=$aValue['FNSgpSeq']?>','<?=date("Y-m-d", strtotime($aValue['FDSgpStart']))?>','<?=$aValue['FTBchCode']?>','<?=$aValue['FTShpCode']?>')">
                                    </td>
                                <?php endif; ?>

                                <!--ปุ่มแก้ไข-->
                                <?php if($aAlwEventGpShop['tAutStaFull'] == 1 || ($aAlwEventGpShop['tAutStaEdit'] == 1 || $aAlwEventGpShop['tAutStaRead'] == 1)) : ?>
                                    <td nowrap class="text-center">
                                        <?php $dDateStr = date("Y-m-d", strtotime($aValue['FDSgpStart']));?>
                                        <img class="xCNIconTable xWIMGShpShopEdit" id="oimGpShopRowEdit"  src="<?=base_url().'/application/modules/common/assets/images/icons/edit.png'?>" onclick="JSvCallPageGpShopClickEdit('<?=$aValue['FNSgpSeq']?>','<?=$dDateStr?>','<?=$aValue['FTBchCode']?>')">
                                    </td>
                                <?php endif; ?>
                            </tr>

                        <?php endforeach; ?>
                    <?php else: ?>
                        <!--case ไม่พบข้อมูล-->
                        <tr><td class='text-center xCNTextDetail2' colspan='99'><?php echo language('common/main/main','tCMNNotFoundData')?></td></tr>
                        <!--end case ไม่พบข้อมูล-->
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!--Pagination-->
<div class="row">
	<div class="col-md-6">
        <p><?= language('common/main/main','tResultTotalRecord')?> <?=$aDataList['rnAllRow']?> <?= language('common/main/main','tRecord')?> <?= language('common/main/main','tCurrentPage')?> <?=$aDataList['rnCurrentPage']?> / <?=$aDataList['rnAllPage']?></p>
    </div>
    <div class="col-md-6">
        <div class="xWPageShopGPBYPDT btn-toolbar pull-right"> <!-- เปลี่ยนชื่อ Class เป็นของเรื่องนั้นๆ --> 
            <?php if($nPage == 1){ $tDisabledLeft = 'disabled'; }else{ $tDisabledLeft = '-';} ?>
            <button onclick="JSvClickPageShopPDT('previous')" class="btn btn-white btn-sm" <?php echo $tDisabledLeft ?>> <!-- เปลี่ยนชื่อ Onclick เป็นของเรื่องนั้นๆ --> 
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
                <button onclick="JSvClickPageShopPDT('<?php echo $i?>')" type="button" class="btn xCNBTNNumPagenation <?php echo $tActive ?>" <?php echo $tDisPageNumber ?>><?php echo $i?></button>
            <?php } ?>
            <?php if($nPage >= $aDataList['rnAllPage']){  $tDisabledRight = 'disabled'; }else{  $tDisabledRight = '-';  } ?>
            <button onclick="JSvClickPageShopPDT('next')" class="btn btn-white btn-sm" <?php echo $tDisabledRight ?>> <!-- เปลี่ยนชื่อ Onclick เป็นของเรื่องนั้นๆ --> 
                <i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
            </button>
        </div>
    </div>
</div>
<!--End Pagination-->

<!--Modal Delete GP Mutirecord-->
<div class="modal fade" id="odvModalDelMainGP">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header xCNModalHead">
				<label class="xCNTextModalHeard"><?= language('common/main/main', 'tModalDelete')?></label>
			</div>
			<div class="modal-body">
				<span id="ospConfirmDelete" class="xCNTextModal" style="display: inline-block; word-break:break-all"></span>
				<input type='hidden' id="ohdConfirmIDDeleteMainGP">
                <input type='hidden' id="ohdConfirmIDDeleteMainGPBch">
			</div>
			<div class="modal-footer">
				<button id="osmConfirm" type="button" class="btn xCNBTNPrimery" data-dismiss="modal" onclick="JSxDeletePDTinTableGPMainGP();">
					<?= language('common/main/main', 'tModalConfirm'); ?>
				</button>
				<button type="button" class="btn xCNBTNDefult" data-dismiss="modal">
					<?= language('common/main/main', 'tModalCancel'); ?>
				</button>
			</div>
		</div>
	</div>
</div>
<!--End Modal Delete GP Mutirecord-->

<!--Modal Delete GP Byrecord-->
<div id="odvModalDeleteGPMainSingle" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header xCNModalHead">
                <label class="xCNTextModalHeard"><?php echo language('common/main/main', 'tModalDelete')?></label>
            </div>
            <div class="modal-body">
                <span id="ospTextConfirmDelSingle" class="xCNTextModal" style="display: inline-block; word-break:break-all"></span>
            </div>
            <div class="modal-footer">
                <button id="osmConfirmDelSingle" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" data-dismiss="modal" type="button"><?php echo language('common/main/main', 'tModalConfirm')?></button>
                <button class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"  data-dismiss="modal"><?php echo language('common/main/main', 'tModalCancel')?></button>
            </div>
        </div>
    </div>
</div>
<!--End Modal Delete GP Byrecord-->


<script>

    //ลบข้อมูลทั้งหมด
    localStorage.removeItem("LocalItemDataMainGP");
    $('.ocbListItemMainGP').unbind().click(function(){
        var nCode   = $(this).parent().parent().parent().data('code');  //code
        var tBCH   = $(this).parent().parent().parent().data('name');  //Name
        $(this).prop('checked', true);
        var LocalItemData   = localStorage.getItem("LocalItemDataMainGP");
        var obj = [];
        if(LocalItemData){
            obj = JSON.parse(LocalItemData);
        }else{}
        var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemDataMainGP"))];
        if(aArrayConvert == '' || aArrayConvert == null){
            obj.push({"nCode": nCode, "tBCH": tBCH });
            localStorage.setItem("LocalItemDataMainGP",JSON.stringify(obj));
            JSxShopPaseCodeDelInModal();
        }else{
            var aReturnRepeat   = findObjectByKey(aArrayConvert[0],'nCode',nCode);
            if(aReturnRepeat == 'None' ){           //ยังไม่ถูกเลือก
                obj.push({"nCode": nCode, "tBCH": tBCH });
                localStorage.setItem("LocalItemDataMainGP",JSON.stringify(obj));
                JSxShopPaseCodeDelInModal();
            }else if(aReturnRepeat == 'Dupilcate'){	//เคยเลือกไว้แล้ว
                localStorage.removeItem("LocalItemDataMainGP");
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
                localStorage.setItem("LocalItemDataMainGP",JSON.stringify(aNewarraydata));
                JSxShopPaseCodeDelInModal();
            }
        }
        JSxShopShowButtonChooseMainGP();
    });

    //set Text ลบทั้งหมด
    function JSxShopPaseCodeDelInModal() {
        var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemDataMainGP"))];
   
        if (aArrayConvert[0] == null || aArrayConvert[0] == '') {} else {
            var tBCHCode = '';
            var nCode = '';
            for ($i = 0; $i < aArrayConvert[0].length; $i++) {
                tBCHCode += aArrayConvert[0][$i].tBCH;
                tBCHCode += ',';

                nCode += aArrayConvert[0][$i].nCode;
                nCode += ',';
            }
            $('#ospConfirmDelete').text($('#oetTextComfirmDeleteMulti').val());
            //เก็บวัน
            $('#ohdConfirmIDDeleteMainGP').val(nCode);

            //เก็บสาขา
            $('#ohdConfirmIDDeleteMainGPBch').val(tBCHCode);
        }
    }

    //Show ปุ่มลบ
    function JSxShopShowButtonChooseMainGP() {
        var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemDataMainGP"))];
        if (aArrayConvert[0] == null || aArrayConvert[0] == "") {
            $("#odvMngTableList #oliBtnDeleteAll").addClass("disabled");
        } else {
            nNumOfArr = aArrayConvert[0].length;
            if (nNumOfArr > 1) {
                $("#odvMngTableList #oliBtnDeleteAll").removeClass("disabled");
            } else {
                $("#odvMngTableList #oliBtnDeleteAll").addClass("disabled");
            }
        }
    }

    //Event Delete mutirecord
    function JSxDeletePDTinTableGPMainGP(){
        var tHiddenDATE     = $('#ohdConfirmIDDeleteMainGP').val();
        var tHiddenBCH      = $('#ohdConfirmIDDeleteMainGPBch').val();
        var tHiddenSHP      = $('#ohdShopGPPDTShp').val();

        //Pack Date
        var aTextsDelDATE   = tHiddenDATE.substring(0,tHiddenDATE.length - 1);
        var aDataSplitDATE  = aTextsDelDATE.split(",");

        //Pack BCH
        var aTextsDelBCH   = tHiddenBCH.substring(0,tHiddenBCH.length - 1);
        var aDataSplitBCH  = aTextsDelBCH.split(",");

        //Count
        var nSplit         = aTextsDelBCH.split(",");
        var aNewIdDelete        = [];
        for ($i = 0; $i <nSplit.length; $i++) {
            aNewIdDelete.push([  aDataSplitDATE[$i],aDataSplitBCH[$i],tHiddenSHP ]);
        }

        $.ajax({
            type: "POST",
            url: "CmpShopGpByProductEventDeleteMutirecord",
            data: {
                aPackData : aNewIdDelete
            },
            success: function (oResult) {
                var tBCH = $('#ohdShopGPPDTBch').val();
                var tSHP = $('#ohdShopGPPDTShp').val();
                JSvCallPageShopGpByPdtMain(tBCH,tSHP,1);
                JCNxCloseLoading();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }

    //call page edit
    function JSvCallPageGpShopClickEdit(pnSeq,ptDateStart,ptBchCode){
        JCNxOpenLoading();
        $.ajax({
            type: "POST",
            url: "CmpShopGpByProductPageEdit",
            data: {
                tBchCode           : ptBchCode,
                tShpCode           : $('#ohdShopGPPDTShp').val(),
                tDateStart         : ptDateStart,
                tPageEvent         : 'PageEdit',
                pnSeq              : pnSeq
            },
            success: function (oResult) {
                $('#odvSetionShopGPByPDT').html();
                $('#odvSetionShopGPByPDT').html(oResult);
                JCNxCloseLoading();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }

    //Delete by record
    function JSxShopGPDeleteMainRecord(pnSeq,ptDateStart,ptBchCode,ptShpCode){
        $('#odvModalDeleteGPMainSingle').modal('show');

        var tConfirm    = $('#ohdDeleteconfirm').val();
        var tConfirmYN  = $('#ohdDeleteconfirmYN').val();
        $('#ospTextConfirmDelSingle').text(tConfirm + ' ' + ptDateStart +" ("+ptShpCode+")" +tConfirmYN);

        $("#odvModalDeleteGPMainSingle #osmConfirmDelSingle").unbind().click(function() {
            $.ajax({
                type    : "POST",
                url     : "CmpShopGpByProductEventDeletelist",
                data    : {
                    pnSeq              : pnSeq,
                    tBchCode           : ptBchCode,
                    tShpCode           : ptShpCode,
                    tDateStart         : ptDateStart
                },
                success: function (oResult) {
                    var tBCH = $('#ohdShopGPPDTBch').val();
                    var tSHP = $('#ohdShopGPPDTShp').val();
                    JSvCallPageShopGpByPdtMain(tBCH,tSHP,1);
                    JCNxCloseLoading();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        });
    }
</script>