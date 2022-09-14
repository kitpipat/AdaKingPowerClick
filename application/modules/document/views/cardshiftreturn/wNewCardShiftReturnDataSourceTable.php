<?php 
    if($aDataList['rtCode'] == '1'){
        $nCurrentPage = $aDataList['rnCurrentPage'];
    }else{
        $nCurrentPage = '1';
    }
?>

<style>
    .xWImpStaSuccess {
        color: #007b00 !important;
        font-size: 18px !important;
        font-weight: bold;
    }
    .xWImpStaInProcess {
        color: #7b7f7b !important;
        font-size: 18px !important;
        font-weight: bold;
    }
    .xWImpStaUnsuccess {
        color: #f60a0a !important;
        font-size: 18px !important;
        font-weight: bold;
    }
</style>
<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
             <table class="table table-striped" style="width:100%">
					<thead>
						<tr>
							<th nowrap class="xCNTextBold" style="width:5%;text-align:left;"><?= language('document/card/main','tMainNumber')?></th>
							<th nowrap class="xCNTextBold" style="width:30%;text-align:left;"><?= language('document/card/main','tExcelcardShiftOutCode')?></th>
							<th nowrap class="xCNTextBold" style="text-align:left;"><?= language('document/card/main','tExcelcardShiftOutStatus')?></th>
							<th nowrap class="xCNTextBold" style="text-align:left;"><?= language('document/card/main','tExcelcardShiftOutProcessStatus')?></th>
							<th nowrap class="xCNTextBold" style="text-align:left;"><?= language('document/card/main','tExcelcardShiftOutRemark')?></th>
                            <th nowrap class="xCNTextBold" style="width:10%;text-align:center;"><?= language('document/card/main','tMainEdit')?></th>
							<th nowrap class="xCNTextBold" style="width:10%;text-align:center;"><?= language('document/card/main','tMainDelete')?></th>
						</tr>
					</thead>
					<tbody id="odvRGPList">
                        <?php if($aDataList['rtCode'] == 1 ):?>
                            <?php foreach($aDataList['raItems'] AS $key=>$aValue){ ?>
                                <tr class="text-center xCNTextDetail2">

                                    <?php
                                        $tFNSeq = $aValue['FNXsdSeqNo'];

                                        if($aValue['FTXsdStaCrd'] == '1'){
                                            $tClassSta   = "xWImpStaSuccess";
                                            $tTextStaCrd    = language('document/card/main','tMainSuccess');
                                            $tStatusCard    = '<img class="xCNIconTable" src="' . base_url() . 'application/modules/common/assets/images/icons/OK-Approve.png"> <span class="text-success">' . $tTextStaCrd . '</span>';
                                        }else{
                                            $tClassSta   = "xWImpStaUnsuccess";
                                            $tTextStaCrd    = language('document/card/main','tMainUnSuccess');
                                            $tStatusCard    = '<img class="xCNIconTable" src="' . base_url() . 'application/modules/common/assets/images/icons/cancel.png"> <span class="text-danger">' . $tTextStaCrd . '</span>';
                                        }

                                        //ประมวลผล
                                        if($aValue['FTXsdStaPrc'] == '' || $aValue['FTXsdStaPrc'] == null){
                                            $tProcess = 'N/A';
                                        }else{
                                            $tProcess = $aValue['FTXsdStaPrc'];
                                        }
                                    ?>

                                    <td nowrap class="text-center"> <?=  $aValue['rtRowID'] ?></td>
                                    <td nowrap class="text-left">   <?= ($aValue['FTXsdStaCrd'] != '1' ) ? '<del>'. $aValue['FTCrdCode'].           '</del>'  :$aValue['FTCrdCode']?></td>
                                    <td nowrap class="text-center   <?=$tClassSta?>"> <?= $tStatusCard?></td>
                                    <td nowrap class="text-center   <?=$tClassSta?>"> <?= $tProcess?></td>
                                    <td nowrap class="text-left     <?=$tClassSta?>"> <?= $aValue['FTXsdRmk']?></td>
                                    <td>     
                                        <img class="xCNIconTable" src="<?php echo  base_url('application/modules/common/assets/images/icons/edit.png'); ?>" onClick="JSnCallPageExcelHelperEdit('<?=$nPage?>','<?=$ptDocType?>','<?=$aValue['FNXsdSeqNo'];?>')" 
                                            title="<?php echo language('pos5/department', 'tDPTTBEdit'); ?>">      
									</td>
									<td>
                                        <img class="xCNIconTable" src="<?php echo  base_url('application/modules/common/assets/images/icons/delete.png'); ?>" onClick="JSnCallPageExcelHelperDel('<?=$nPage?>','<?=$ptDocType?>','<?=$aValue['FNXsdSeqNo']?>','<?=$aValue['FTCrdCode']?>','<?=$tIDElement?>')" 
                                            title="<?php echo language('pos5/customerGroup', 'tCstGrpTBDelete'); ?>">
									</td>
                                </tr>
                            <?php } ?>
                        <?php else:?>
                            <tr><td class='text-center xCNTextDetail2' colspan='99'><?= language('common/main/main','tCMNNotFoundData')?></td></tr>
                        <?php endif;?>
					</tbody>
			</table>
        </div>
    </div>
</div>

<div class="row">
	<!-- เปลี่ยน -->
	<div class="col-md-6">
        <p><?= language('common/main/main','tResultTotalRecord')?> <?=$aDataList['rnAllRow']?> <?= language('common/main/main','tRecord')?> <?= language('common/main/main','tCurrentPage')?> <?=$aDataList['rnCurrentPage']?> / <?=$aDataList['rnAllPage']?></p>
    </div>
	<!-- เปลี่ยน -->
    <div class="col-md-6">
        <div class="xWPageCardHelper btn-toolbar pull-right"> <!-- เปลี่ยนชื่อ Class เป็นของเรื่องนั้นๆ --> 
            <?php if($nPage == 1){ $tDisabledLeft = 'disabled'; }else{ $tDisabledLeft = '-';} ?>
            <button onclick="JSvClickPageINHelper('previous','<?=$ptDocType?>','<?=$tIDElement?>')" class="btn btn-white btn-sm" <?php echo $tDisabledLeft ?>> <!-- เปลี่ยนชื่อ Onclick เป็นของเรื่องนั้นๆ --> 
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
                <button onclick="JSvClickPageINHelper('<?php echo $i?>','<?=$ptDocType?>','<?=$tIDElement?>')" type="button" class="btn xCNBTNNumPagenation <?php echo $tActive ?>" <?php echo $tDisPageNumber ?>><?php echo $i?></button>
            <?php } ?>
            <?php if($nPage >= $aDataList['rnAllPage']){  $tDisabledRight = 'disabled'; }else{  $tDisabledRight = '-';  } ?>
            <button onclick="JSvClickPageINHelper('next','<?=$ptDocType?>','<?=$tIDElement?>')" class="btn btn-white btn-sm" <?php echo $tDisabledRight ?>> <!-- เปลี่ยนชื่อ Onclick เป็นของเรื่องนั้นๆ --> 
                <i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
            </button>
        </div>
    </div>
</div>


<script>
    var tCount = ' <?=$aDataList['rnAllRow']?>';
    $('#oetCardShiftReturnCountNumber').val(tCount);
</script>
