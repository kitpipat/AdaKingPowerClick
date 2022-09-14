<!-- แสดงแพ็คเกจ -->
<div id="oResultPackageList">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th class="xCNTextBold" style="width:10%;text-align:center;"><?= language('common/main/main','tCMNChoose')?></th>
                        <th class="xCNTextBold" style="width:10%;text-align:center;">รูปภาพ</th>
                        <th class="xCNTextBold" style="width:50%;text-align:center;">ชื่อแพ็คเกจ</th>
                        <th class="xCNTextBold" style="width:10%;text-align:center;">ประเภท</th>
                        <th class="xCNTextBold" style="width:10%;text-align:center;">สถานะ</th>
                        <th class="xCNTextBold" style="width:5%;text-align:center;">ลบ</th>
                        <th class="xCNTextBold" style="width:5%;text-align:center;">แก้ไข</th>
                    </tr>
                </thead>
                <tbody id="odvRGPList">
                <?php if (@$oPkgList[0]->FNPkgID != ''): ?>
                <?php foreach ($oPkgList AS $key => $aValue): ?>	

                    <tr class="text-center xCNTextDetail2 otrDistrict"  data-name="<?= $aValue->FTPkgName ?>" data-code="<?=$aValue->FNPkgID;?>">
                        <td>
                            <label class="fancy-checkbox">
                                <input id="ocbListItem<?=$key?>" type="checkbox" class="ocbListItem" name="ocbListItem[]" data-name="<?= $aValue->FTPkgName ?>" value="<?=$aValue->FNPkgID;?>">
                                <span>&nbsp;</span>
                            </label>
                        </td>
                        <td class="">
                            <?php
                                if(isset($aValue->FTImgObj) && !empty($aValue->FTImgObj)){
                                    $tFullPatch = './application/modules/'.$aValue->FTImgObj;
                                    if (file_exists($tFullPatch)){
                                        $tPatchImg = base_url().'/application/modules/'.$aValue->FTImgObj;
                                    }else{
                                        $tPatchImg = base_url().'application/modules/common/assets/images/Noimage.png';
                                    }
                                }else{
                                    $tPatchImg = base_url().'application/modules/common/assets/images/Noimage.png';
                                }
                            ?>
                            <img class="" src="<?=$tPatchImg?>" style="width:70%;">
                        </td>
                        <td class="text-left">
                            <span style="color: #676a6d; font-size: 16px;">
                                <?php if ($aValue->FTPkgName): ?>
                                <?= $aValue->FTPkgName ?>
                                <?php else: ?>
                                    <?= language('ticket/zone/zone', 'tNoData') ?>
                                <?php endif; ?>						                        			 
                                <br>
                            </span>
                            <p style="color: #aba9a9!important; font-size: 13px;"><?= language('ticket/package/package', 'tPkg_DateUse') ?> : <?= date("d-m-Y", strtotime($aValue->FDPkgStartChkIn)) ?> <?= $aValue->FTPkgStartChkIn ?> - <?= date("d-m-Y", strtotime($aValue->FDPkgStopChkIn)) ?> <?= $aValue->FTPkgStopChkIn ?><br>
                                <?= language('ticket/package/package', 'tPkg_MaxPark') ?>  <?= $aValue->FNPkgMaxPark ?> <?= language('ticket/package/package', 'tPkg_Model') ?><br>
                                <?= language('ticket/package/package', 'tPkg_CanChkIn') ?>  <?= $aValue->FNPkgMaxChkIn ?> <?= language('ticket/package/package', 'tPkg_Times') ?><br>
                                <?= language('ticket/package/package', 'tPkg_ProductGroup') ?> : <?= $aValue->FTTcgName ?><br>
                            </p>
                        </td>
                        <td class="text-left">
                            <p style="color: #aba9a9!important; font-size: 13px;"><?= language('ticket/package/package', 'tPkg_PriceBy') ?> : <?= language('ticket/package/package', 'tPkg_PackagePkgType' . $aValue->FTPkgType) ?><br>
                                <?= language('ticket/package/package', 'tPkg_Type') ?> : <?= $aValue->FTPkgStaLimitType ?><br>
                            </p> 
                        </td>

                        <td class="text-left">
                        <?php if ($aValue->FTPkgStaPrcDoc == ''): ?>
                            <span style="color: #f60!important; font-size: 13px;"><?= language('ticket/package/package', 'tPkg_NotApproved') ?></span>
                        <?php else : ?>
                            <span style="color: #0e9e0e!important; font-size: 13px;"><?= language('ticket/package/package', 'tPkg_Approved') ?></span>
                        <?php endif; ?>	
                        </td>

                        <td class="text-center">
                            <?php if ($oAuthen['tAutStaDelete'] == '1'): ?>					                        	
                                <img class="xCNIconTable" src="<?=base_url();?>application/modules/common/assets/images/icons/delete.png" onclick="JSxDeletePkgNoPdt('<?= $nPageNo ?>','<?= $aValue->FNPkgID ?>','<?=$aValue->FTPkgName?>')">
                            <?php endif; ?>
                        </td>

                        <td class="text-center">
                            <?php if ($oAuthen['tAutStaEdit'] == '1'): ?>
                                <!-- <div class="<?php if ($oAuthen['tAutStaDelete'] == '1') {
                                    echo 'col-md-2 text-right';
                                    } else {
                                        echo 'col-md-4 text-right';
                                    }?> col-sm-12 col-xs-12 xCNRemovePadding text-right">
                                        <a href="javascript:void(0)" data-toggle="modal" style="color: #aba9a9!important; font-size: 13px;" onclick="JSxCallPageEditPkg('<?= $aValue->FNPkgID ?>')">
                                        <?php if ($aValue->FTPkgStaPrcDoc == ''): ?>
                                            <i class="fa fa-pencil-square-o fa-lg" aria-hidden="true"></i> 
                                            <span style="font-size:13px;"><?= language('ticket/package/package', 'tPkg_Edit') ?></span>
                                            <?php else : ?>
                                                <i class="fa fa-pencil-square-o fa-lg" aria-hidden="true"></i> 
                                                <span style="font-size:13px;"><?= language('ticket/package/package', 'tPkg_PackageDesc') ?></span>
                                            <?php endif; ?>
                                        </a> 
                                        <img class="xCNIconTable" src="<?=base_url();?>application/modules/common/assets/images/icons/edit.png" onclick="JSxCallPageEditPkg('<?= $aValue->FNPkgID ?>')">
                                    </div> -->
                                <img class="xCNIconTable" src="<?=base_url();?>application/modules/common/assets/images/icons/edit.png" onclick="JSxCallPageEditPkg('<?= $aValue->FNPkgID ?>')">
                            <?php endif; ?>		
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php else: ?>
                    <tr><td class='text-center xCNTextDetail2' colspan='100%'><?=language('common/main/main', 'tCMNNotFoundData')?></td></tr>
                <?php endif ?>
                </tbody>
            </table>
        </div>

        <?php if (isset($oPkgList[0]->counts)): ?>
            <input type="hidden" class="hide" id="ohdPkgRowRecord" value="<?= $oPkgList[0]->counts ?>">
        <?php else: ?>
            <input type="hidden" class="hide" id="ohdPkgRowRecord" value="0">
        <?php endif; ?>
</div>

<div class="modal fade" id="odvmodaldelete">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header xCNModalHead">
				<label class="xCNTextModalHeard"><?=language('common/main/main', 'tModalDelete')?>555+</label>
			</div>
			<div class="modal-body">
				<span id="ospConfirmDelete" class="xCNTextModal"> - </span>
				<input type='hidden' id="ospConfirmIDDelete">
			</div>
			<div class="modal-footer">
				<!-- แก้ -->
				<button id="osmConfirm" onClick="FSxDelAllOnCheck('<?= $nPageNo ?>')" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" type="button">
					<?php echo language('common/main/main', 'tModalConfirm')?>
				</button>
				<!-- แก้ -->
				<button class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"  data-dismiss="modal">
					<?php echo language('common/main/main', 'tModalCancel')?>
				</button>
			</div>
		</div>
	</div>
</div>

<script>
    nRowRecord = $('#ohdPkgRowRecord').val();
    $('#ospPkgTotalRecord').text(" " + nRowRecord);
    $('#ospTotalPage').text(Math.ceil(parseInt(nRowRecord) / 5));
    var nRecord = $('#ohdPkgRowRecord').val();
    if (nRecord.trim() == '0') {
        $('.xWGridFooter').hide();
        $('.grid-resultpage').hide();
    } else {
        $('.xWGridFooter').show();
        $('.grid-resultpage').show();
    }
</script>
<script type="text/javascript">
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
        });
    });
</script>