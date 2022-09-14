<?php
    if($aDataList['rtCode'] == '1'){
        $nCurrentPage = $aDataList['rnCurrentPage'];
    }else{
        $nCurrentPage = '1';
    }
?>

<div class="row">
    <div class="col-md-12">
        <input type="hidden" id="nCurrentPageTB" value="$nCurrentPage">
        <div class="table-responsive">
            <table class="table table-striped" style="width:100%">
                <thead>
                    <tr>
                        <?php if($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaDelete'] == 1) : ?>
                            <th nowrap class="xCNTextBold text-center" style="width:5%;">
                                <label class="fancy-checkbox">
                                    <input type="checkbox" class="ocmCENCheckDeleteAll" id="ocmCENCheckDeleteAll" >
                                    <span class="ospListItem">&nbsp;</span>
                                </label>
                            </th>
                        <?php endif; ?>
                        <th nowrap class="xCNTextBold" style="width:10%;text-align:center;"><?php echo language('authen/role/role','tImglogo')?></th>
                        <th nowrap class="xCNTextBold" style="width:10%;text-align:center;"><?php echo language('authen/role/role','tROLTBCode')?></th>
                        <th nowrap class="xCNTextBold" style="width:50%;text-align:center;"><?php echo language('authen/role/role','tROLTBName')?></th>
                        <th nowrap class="xCNTextBold" style="width:10%;text-align:center;"><?php echo language('authen/role/role','tROLTBLevel')?></th>
                        <?php if($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaDelete'] == 1) : ?>
                        <th nowrap class="xCNTextBold" style="width:7%;text-align:center;"><?php echo language('authen/role/role','tROLTBDelete')?></th>
                        <?php endif; ?>
                        <?php if($aAlwEvent['tAutStaFull'] == 1 || ($aAlwEvent['tAutStaEdit'] == 1 || $aAlwEvent['tAutStaRead'] == 1))  : ?>
                        <th nowrap class="xCNTextBold" style="width:7%;text-align:center;"><?php echo language('authen/role/role','tROLTBEdit')?></th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody id="odvRGPList">
                    <?php if(isset($aDataList) && $aDataList['rtCode'] == 1):?>
                        <?php foreach($aDataList['raItems'] AS $key=>$aValue):?>
                            <tr class="xCNTextDetail2 otrRole" id="otrRole<?php echo $key?>" data-code="<?php echo $aValue['FTRolCode']?>" data-name="<?php echo $aValue['FTRolName']?>">
                                <?php if($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaDelete'] == 1) : ?>
                                <td class="text-center">
                                    <label class="fancy-checkbox">
                                        <?php if(!FCNbIsHaveUserInRole($aValue['FTRolCode'])) : // No have user in role ?>
                                            <input id="ocbListItem<?php echo $key?>" name="ocbListItem[]" type="checkbox" class="ocbListItem">
                                            <span>&nbsp;</span>
                                        <?php else : // have user in role?>
                                            <input type="checkbox" class="ocbListItem" disabled="true">
                                            <span class="xCNDocDisabled">&nbsp;</span>
                                        <?php endif; ?>

                                    </label>
                                </td>
                                <?php endif; ?>

                                <td class="text-center">
                                    <?php echo  FCNtHGetImagePageList($aValue['FTImgObj'], '38px'); ?>
                                </td>

                                <td class="text-left"><?php echo $aValue['FTRolCode']?></td>
                                <td><?php echo $aValue['FTRolName']?></td>
                                <td class="text-center"><?php echo $aValue['FNRolLevel']?></td>

                                <?php if($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaDelete'] == 1) : ?>
                                <td style="text-align: center;">
                                    <?php if(!FCNbIsHaveUserInRole($aValue['FTRolCode'])) : // No have user in role ?>
                                        <img class="xCNIconTable" src="<?php echo base_url().'/application/modules/common/assets/images/icons/delete.png'?>" onClick="JSnRoleDel('<?php $nCurrentPage; ?>','<?php echo $aValue['FTRolName']?>','<?php echo $aValue['FTRolCode']?>','<?= language('common/main/main','tModalConfirmDeleteItemsYN')?>')">
                                    <?php else : // have user in role?>
                                        <img class="xCNIconTable xCNDocDisabled" src="<?php echo base_url().'/application/modules/common/assets/images/icons/delete.png'?>">
                                    <?php endif; ?>
                                </td>
                                <?php endif; ?>

                                <?php
                                    $tUserMonitorlogin =  $this->session->userdata('tSesUsrRoleCodeMulti');
                                    $tRoleCode   = str_replace("'","",$tUserMonitorlogin);
                                    $aRoleCode   = explode(",",$tRoleCode);
                                    $nLoopCheckRole = 0;
                                    if($this->session->userdata('tSesUsrLevel')!='HQ'){
                                        if(!empty($aRoleCode)){
                                            foreach($aRoleCode as $tRoleCodeValue){
                                                if($aValue['FTRolCode'] == $tRoleCodeValue){
                                                    $nLoopCheckRole++;
                                                }
                                            }
                                        }
                                    }

                                if($nLoopCheckRole==0){
                                if($aAlwEvent['tAutStaFull'] == 1 || ($aAlwEvent['tAutStaEdit'] == 1 || $aAlwEvent['tAutStaRead'] == 1)) :
                                ?>
                                        <?php $tImagIcon =  ($aAlwEvent['tAutStaEdit']==1)?  'edit.png' :  'view2.png' ;  ?>
                                <td style="text-align: center;"><img class="xCNIconTable" src="<?php echo  base_url().'/application/modules/common/assets/images/icons/'.$tImagIcon?>" onClick="JSvCallPageRoleEdit('<?php echo $aValue['FTRolCode']?>')"></td>
                                <?php
                                    endif;
                                }else{ ?>
                                    <td style="text-align: center;"><img class="xCNIconTable" src="<?php echo  base_url().'/application/modules/common/assets/images/icons/view2.png'?>" onClick="JSvCallPageRoleEdit('<?php echo $aValue['FTRolCode']?>')"></td>
                                <?php }
                            ?>
                            </tr>
                        <?php endforeach; ?>
                    <?php else:?>
                        <tr><td class='text-center xCNTextDetail2' colspan='6'><?php echo language('common/main/main', 'tCMNNotFoundData')?></td></tr>
                    <?php endif;?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <p><?php echo language('common/main/main','tResultTotalRecord')?> <?php echo $aDataList['rnAllRow']?> <?php echo language('common/main/main','tRecord')?> <?php echo language('common/main/main','tCurrentPage')?> <?php echo $aDataList['rnCurrentPage']?> / <?php echo $aDataList['rnAllPage']?></p>
    </div>

    <div class="col-md-6">
        <div class="xWPageRoleGrp btn-toolbar pull-right"> <!-- เปลี่ยนชื่อ Class เป็นของเรื่องนั้นๆ -->
            <?php if($nPage == 1){ $tDisabledLeft = 'disabled'; }else{ $tDisabledLeft = '-';} ?>
            <button onclick="JSvRoleClickPage('previous')" class="btn btn-white btn-sm" <?php echo $tDisabledLeft ?>> <!-- เปลี่ยนชื่อ Onclick เป็นของเรื่องนั้นๆ -->
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
                <button onclick="JSvRoleClickPage('<?php echo $i?>')" type="button" class="btn xCNBTNNumPagenation <?php echo $tActive ?>" <?php echo $tDisPageNumber ?>><?php echo $i?></button>
            <?php } ?>
            <?php if($nPage >= $aDataList['rnAllPage']){  $tDisabledRight = 'disabled'; }else{  $tDisabledRight = '-';  } ?>
            <button onclick="JSvRoleClickPage('next')" class="btn btn-white btn-sm" <?php echo $tDisabledRight ?>> <!-- เปลี่ยนชื่อ Onclick เป็นของเรื่องนั้นๆ -->
                <i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
            </button>
        </div>
    </div>
</div>

<div class="modal fade" id="odvModalDelRole">
    <div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header xCNModalHead">
                <label class="xCNTextModalHeard"><?php echo language('common/main/main', 'tModalDelete')?></label>
			</div>
            <div class="modal-body">
				<span id="ospConfirmDelete" class="xCNTextModal" style="display: inline-block; word-break:break-all"></span>
				<input type='hidden' id="ohdConfirmIDDelete">
			</div>
			<div class="modal-footer">
				<button id="osmConfirm" type="button" class="btn xCNBTNPrimery" onClick="JSaRoleDelChoose('<?php echo $nCurrentPage?>')">
					<?php echo language('common/main/main', 'tModalConfirm')?>
				</button>
				<button type="button" class="btn xCNBTNDefult" data-dismiss="modal">
					<?php echo language('common/main/main', 'tModalCancel')?>
				</button>
			</div>
		</div>
	</div>
</div>

<script type="text/Javascript">
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
            JCNxRoleTextInModal();
        }else{
            var aReturnRepeat = JCNxRoleFindObjectByKey(aArrayConvert[0],'nCode',nCode);
            if(aReturnRepeat == 'None' ){           //ยังไม่ถูกเลือก
                obj.push({"nCode": nCode, "tName": tName });
                localStorage.setItem("LocalItemData",JSON.stringify(obj));
                JCNxRoleTextInModal();
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
                JCNxRoleTextInModal();
            }
        }
        JCNxRoleShowBtnChoose();
    })
</script>
