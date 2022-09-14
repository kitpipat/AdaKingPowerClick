<?php
    if($aDataList['rtCode'] == '1'){
        $nCurrentPage = $aDataList['rnCurrentPage'];
        $nAllRow      = $aDataList['rnAllRow'];
        $nAllPage     = $aDataList['rnAllPage'];
        $tBchCodeDel  = $aDataList['raItems']['0']['FTBchCode'];
        $tShpCodeDel  = $aDataList['raItems']['0']['FTShpCode'];
        $tSeq         = $aDataList['raItems']['0']['FNSgpSeq'];
    }else{
        $nCurrentPage = 1;
        $nAllRow      = 0;
        $nAllPage     = 0;
        $tBchCodeDel  = 0;
        $tShpCodeDel  = '';
        $tSeq         = '';
    }
 
?> 


<style>
    .xWInputEditInLine {
        margin: 0 !important;
    }
</style>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="table-responsive">
            <table id="otbShopGpByShpListTable" class="table table-striped">
                <thead>
                    <tr>
                        <?php if($aAlwEventGpShop['tAutStaFull'] == 1 || $aAlwEventGpShop['tAutStaDelete'] == 1) : ?>
                        <th nowrap class="text-center xCNTextBold" style="width:10%;"><?php echo  language('company/shopgpbyshp/shopgpbyshp','tSGPTBChoose')?></th>
                        <?php endif; ?>
                        <th nowrap class="text-center xCNTextBold" style="width:10%;"><?php echo  language('company/shopgpbyshp/shopgpbyshp','tSGPTBBrach');?></th>
                        <th nowrap class="text-center xCNTextBold" style="width:20%;"><?php echo  language('company/shopgpbyshp/shopgpbyshp','tSGPTBDateStart');?></th>
                        <th nowrap class="text-center xCNTextBold" style="width:15%;"><?php echo  language('company/shopgpbyshp/shopgpbyshp','tSGPTBProduct');?></th>
                        <th nowrap class="text-center xCNTextBold" style="width:5%;"><?php  echo  language('company/shopgpbyshp/shopgpbyshp','tSGPTBPerAvg');?></th>
                        <th nowrap class="text-center xCNTextBold" style="width:5%;"><?php  echo  language('company/shopgpbypdt/shopgpbypdt','tSGPPTableSpecial');?></th>
                     
                        <?php if($aAlwEventGpShop['tAutStaFull'] == 1 || $aAlwEventGpShop['tAutStaDelete'] == 1) : ?>
                        <th nowrap class="text-center xCNTextBold" style="width:5%;"><?php  echo  language('company/shopgpbyshp/shopgpbyshp','tSGPTBDel')?></th>
                        <?php endif; ?>

                        <?php if($aAlwEventGpShop['tAutStaFull'] == 1 || ($aAlwEventGpShop['tAutStaEdit'] == 1 || $aAlwEventGpShop['tAutStaRead'] == 1))  : ?>
                        <th nowrap class="text-center xCNTextBold" style="width:5%;"><?php  echo  language('company/shopgpbyshp/shopgpbyshp','tSGPTBEdit')?></th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody id="odvRGPList">
                    <?php if($aDataList['rtCode'] == '1'):?>
                        <?php foreach($aDataList['raItems'] AS $nKey => $aValue):?>
                        <tr class="text-center xCNTextDetail2 otrShopGpRow xWShpShopDataSource" id="otrShopGpRow<?=$nKey;?>"  data-code="<?= date("Y-m-d", strtotime($aValue['FDSgpStart']))?>"  data-name="<?= date("Y-m-d", strtotime($aValue['FDSgpStart']))?>" data-seq="otrShopGpRow<?=$nKey;?>">
                            <!-- <tr class="text-center xCNTextDetail2 xWShopGpRow" id="otrShopGpRow<?php echo $nKey?>"> -->
                                <?php if($aAlwEventGpShop['tAutStaFull'] == 1 || $aAlwEventGpShop['tAutStaDelete'] == 1) : ?>
                                <td class="text-center">
                                    <label class="fancy-checkbox">
                                        <input id="ocbListItem<?php echo $nKey?>" type="checkbox" class="ocbListItem" name="ocbListItem[]">
                                        <span>&nbsp;</span>
                                    </label>
                                </td>
                                <?php endif; ?>
            
                                <td nowrap class="text-left"><?php echo $aValue['FTBchName'] ?></td>
                                <td nowrap class="text-left"><?php echo date("d/m/Y", strtotime($aValue['FDSgpStart'])); ?></td>
                                <td nowrap class="text-left"><?php echo language('company/shopgpbyshp/shopgpbyshp','tSGPPdtAll'); ?></td>
                                <td nowrap class="text-left xCNFieldGPPerAvg">
                                    <!-- <input type="text" class="form-group xWInputEditInLine" id="oetShpGPPerAvg<?=$nKey?>" name="oetShpGPPerAvg" value="<?php echo number_format($aValue['FCSgpPerAvg'],2);?>" disabled> -->
                                    <?php echo number_format($aValue['FCSgpPerAvg'],2);?>
                                </td>
                              
                                <td nowrap class="text-left" style="cursor:pointer;" data-name="<?php echo $aValue['FTBchName']?>" data-Bch="<?php echo $aValue['FTBchCode']?>" data-ShpCode="<?php echo $aValue['FTShpCode']?>" data-dDateStar="<?php echo $aValue['FDSgpStart'];?>" onclick="JSxSetGPSpecial(this)"><?php  echo  language('company/shopgpbypdt/shopgpbypdt','tSGPPTableSpecial');?><img style="margin-left: 5px; width: 15px;" src="<?=base_url().'/application/modules/common/assets/images/icons/calendar.png'?>" ></td>
                                <?php if($aAlwEventGpShop['tAutStaFull'] == 1 || $aAlwEventGpShop['tAutStaDelete'] == 1) : ?>
                                <td nowrap class="text-center">
                                    <img class="xCNIconTable xCNIconDel" id="oimGpShopRowDel" src="<?php echo  base_url().'/application/modules/common/assets/images/icons/delete.png'?>" onClick="JSnShopGpByShpDel('<?=$aValue['FNSgpSeq'];?>','<?=$aValue['FTShpCode']?>','<?= date("Y-m-d", strtotime($aValue['FDSgpStart']))?>','<?=$nCurrentPage?>','<?=$tBchCodeDel?>','<?= language('common/main/main','tModalConfirmDeleteItemsYN')?>')">
                                </td>
                                <?php endif; ?>
                                <?php if($aAlwEventGpShop['tAutStaFull'] == 1 || ($aAlwEventGpShop['tAutStaEdit'] == 1 || $aAlwEventGpShop['tAutStaRead'] == 1)) : ?>
                                <td nowrap class="text-center">
                                <?php $dDateStr = date("Y-m-d", strtotime($aValue['FDSgpStart']));?>

                                    <img class="xCNIconTable xWIMGShpShopEdit" id="oimGpShopRowEdit"  src="<?=base_url().'/application/modules/common/assets/images/icons/edit.png'?>" onclick="JSvCallPageShopByGPEdit('<?=$aValue['FNSgpSeq'];?>','<?php echo $aValue['FDSgpStart'];?>','<?=$aValue['FTBchCode']?>','<?=$aValue['FTShpCode']?>')">
                                   
                                </td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td class='text-center xCNTextDetail2' colspan='99'><?php echo language('common/main/main','tCMNNotFoundData')?></td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <p><?= language('common/main/main','tResultTotalRecord')?> <?=$nAllRow ?> <?= language('common/main/main','tRecord')?> <?= language('common/main/main','tCurrentPage')?> <?php echo $nCurrentPage; ?> / <?php echo $nAllPage; ?> </p>
    </div>
    <div class="col-md-6">
        <div class="xWPagePsh btn-toolbar pull-right"> 
            <?php if($nPage == 1){ $tDisabledLeft = 'disabled'; }else{ $tDisabledLeft = '-';} ?>
            <button onclick="JSvPshClickPage('previous','<?=$tBchCodeDel?>')" class="btn btn-white btn-sm" <?php echo $tDisabledLeft ?>>
                <i class="fa fa-chevron-left f-s-14 t-plus-1"></i>
            </button>
            <?php for($i=max($nPage-2, 1); $i<=max(0, min($nAllPage,$nPage+2)); $i++){?>
                <?php 
                    if($nPage == $i){ 
                        $tActive = 'active'; 
                        $tDisPageNumber = 'disabled';
                    }else{ 
                        $tActive = '';
                        $tDisPageNumber = '';
                    }
                ?>
               
                <button onclick="JSvPshClickPage('<?php echo $i?>','<?=$tBchCodeDel?>')" type="button" class="btn xCNBTNNumPagenation <?php echo $tActive ?>" <?php echo $tDisPageNumber ?>><?php echo $i?></button>
            <?php } ?>
            <?php if($nPage >= $nAllPage){  $tDisabledRight = 'disabled'; }else{  $tDisabledRight = '-';  } ?>
            <button onclick="JSvPshClickPage('next','<?=$tBchCodeDel?>')" class="btn btn-white btn-sm" <?php echo $tDisabledRight ?>>
                <i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
            </button>
         
        </div>
    </div>
</div>

    <div class="modal fade" id="odvModalDelShopGpByShp">
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
                    <button id="osmConfirm" type="button" class="btn xCNBTNPrimery"><?=language('common/main/main', 'tModalConfirm')?></button>
                    <button type="button" class="btn xCNBTNDefult" data-dismiss="modal"><?=language('common/main/main', 'tModalCancel')?></button>
                </div>
            </div>
        </div>
    </div>


    <div id="odvModalDelShopGpShp" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header xCNModalHead">
                    <label class="xCNTextModalHeard"><?php echo language('common/main/main', 'tModalDelete')?></label>
                </div>
                <div class="modal-body">
                    <span id="ospTextConfirmDelMultiple" class="xCNTextModal" style="display: inline-block; word-break:break-all"></span>
                    <input type='hidden' id="ohdConfirmIDDelMultiple">
                </div>
                <div class="modal-footer">
                    <button id="osmConfirmDelMultiple" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" type="button" onClick="JSnShopGpByShpDelChoose('<?=$tSeq?>','<?=$tShpCodeDel?>','<?=$nCurrentPage?>','<?= date("Y-m-d", strtotime($aValue['FDSgpStart']))?>','<?=$tBchCodeDel?>')"><?php echo language('common/main/main', 'tModalConfirm')?></button>
                    <button class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"  data-dismiss="modal"><?php echo language('common/main/main', 'tModalCancel')?></button>
                </div>
            </div>
        </div>
    </div> 

<!--Modal GP special-->
<div class="modal fade" id="odvModalGPSpecial">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header xCNModalHead">
				<label class="xCNTextModalHeard"><?= language('company/shopgpbypdt/shopgpbypdt', 'tModalGPSpecial')?></label>
			</div>
			<div class="modal-body">
                <div class="row">
                    <div class="col-lg-2"><label style="font-weight: bold;"><?=language('company/shopgpbypdt/shopgpbypdt','tSGPPTableBch');?></label></div>
                    <div class="col-lg-10"><span id="ospGPSpecialBCH"></span></div>
                </div>
                <div class="row">
                    <div class="col-lg-2"><label style="font-weight: bold;"><?=language('company/shopgpbypdt/shopgpbypdt','tSGPSDateStart');?></label></div>
                    <div class="col-lg-10">  <span id="ospGPSpecialDate"></span></div>
                </div>
                <input type="hidden" id="ohdGPSpecialSHPBchCode" name="ohdGPSpecialSHPBchCode">
                <input type="hidden" id="ohdGPSpecialSHPShpCode" name="ohdGPSpecialSHPShpCode">
                <input type="hidden" id="ohdGPSpecialSHPDate"    name="ohdGPSpecialSHPDate">
                <table id="otbShopGPSpecial" class="table table-striped">
                    <thead>
                        <tr>
                            <th nowrap class="text-center xCNTextBold" style="width:10%;"><?=language('company/shopgpbypdt/shopgpbypdt','tTableGPNumber')?></th>
                            <th nowrap class="text-center xCNTextBold" style="width:70%;"><?=language('company/shopgpbypdt/shopgpbypdt','tTableGPDay')?></th>
                            <th nowrap class="text-center xCNTextBold" style="width:25%;"><?=language('company/shopgpbypdt/shopgpbypdt','%GP')?></th>
                            <th nowrap class="xWDeleteBtnEditButton" style="display:none;"></th>
                        </tr>
                    </thead>
                    <tbody id="odvRGPList">
                        <tr>
                            <td>1</td>
                            <td><?=language('company/shopgpbypdt/shopgpbypdt','tSGPPTBPerMon')?></td>
                            <td>
                                <label class="xWShowInLine xCNInputNumericWithDecimal xGPSpacMon">0.00</label>
                                <div class="xCNHide xWEditInLine"> 
                                    <input type="text" class="form-control xCNInputNumericWithDecimal xCNPdtEditInLine xCNInputWithoutSpc xCNValueMon">
                                </div>
                            </td>
       
                        </tr>
                        <tr>
                            <td>2</td>
                            <td><?=language('company/shopgpbypdt/shopgpbypdt','tSGPPTBPerTue')?></td>
                            <td>
                                <label class="xWShowInLine xCNInputNumericWithDecimal xGPSpacTue">0.00</label>
                                <div class="xCNHide xWEditInLine">
                                    <input type="text" class="form-control xCNInputNumericWithDecimal xCNPdtEditInLine xCNInputWithoutSpc xCNValueTue">
                                </div>
                            </td>
               
                        </tr>
                        <tr>
                            <td>3</td>
                            <td><?=language('company/shopgpbypdt/shopgpbypdt','tSGPPTBPerWed')?></td>
                            <td>
                                <label class="xWShowInLine xCNInputNumericWithDecimal xGPSpacWed">0.00</label>
                                <div class="xCNHide xWEditInLine">
                                    <input type="text" class="form-control xCNInputNumericWithDecimal xCNPdtEditInLine xCNInputWithoutSpc xCNValueWed">
                                </div>
                            </td>
                  
                        </tr>
                        <tr>
                            <td>4</td>
                            <td><?=language('company/shopgpbypdt/shopgpbypdt','tSGPPTBPerThu')?></td>
                            <td>
                                <label class="xWShowInLine xCNInputNumericWithDecimal xGPSpacThu">0.00</label>
                                <div class="xCNHide xWEditInLine">
                                    <input type="text" class="form-control xCNInputNumericWithDecimal xCNPdtEditInLine xCNInputWithoutSpc xCNValueThu">
                                </div>
                            </td>
                  
                        </tr>
                        <tr>
                            <td>5</td>
                            <td><?=language('company/shopgpbypdt/shopgpbypdt','tSGPPTBPerFri')?></td>
                            <td>
                                <label class="xWShowInLine xCNInputNumericWithDecimal xGPSpacFri">0.00</label>
                                <div class="xCNHide xWEditInLine">
                                    <input type="text" class="form-control xCNInputNumericWithDecimal xCNPdtEditInLine xCNInputWithoutSpc xCNValueFri">
                                </div>
                            </td>
                         
                        </tr>
                        <tr>
                            <td>6</td>
                            <td><?=language('company/shopgpbypdt/shopgpbypdt','tSGPPTBPerSat')?></td>
                            <td>
                                <label class="xWShowInLine xCNInputNumericWithDecimal xGPSpacSat">0.00</label>
                                <div class="xCNHide xWEditInLine">
                                    <input type="text" class="form-control xCNInputNumericWithDecimal xCNPdtEditInLine xCNInputWithoutSpc xCNValueSat">
                                </div>
                            </td>
                  
                        </tr>
                        <tr>
                            <td>7</td>
                            <td><?=language('company/shopgpbypdt/shopgpbypdt','tSGPPTBPerSun')?></td>
                            <td>
                                <label class="xWShowInLine xCNInputNumericWithDecimal xGPSpacSun">0.00</label>
                                <div class="xCNHide xWEditInLine">
                                    <input type="text" class="form-control xCNInputNumericWithDecimal xCNPdtEditInLine xCNInputWithoutSpc xCNValueSun">
                                </div>
                            </td>
               
                        </tr>
                    </tbody>
                </table>
			</div>
			<div class="modal-footer">
				<button id="osmConfirm" type="button" class="btn xCNBTNPrimery" data-dismiss="modal" onclick="JSxSaveGPSpecial()">
					<?= language('company/shopgpbypdt/shopgpbypdt', 'tSGPPBTNSave'); ?>
				</button>
				<button type="button" class="btn xCNBTNDefult" data-dismiss="modal">
					<?= language('common/main/main', 'tModalCancel'); ?>
				</button>
			</div>
		</div>
	</div>
</div>


    <script src="<?php echo  base_url('application/modules/company/assets/src/shopgpbyshp/jShopGpByShp.js'); ?>"></script>
    <script type="text/javascript">
    $('ducument').ready(function(){
        JSxShowButtonChoose();
        var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
        var nlength = $('#odvRGPList').children('tr').length;
        for($i=0; $i < nlength; $i++){
            var tDataCode = $('#otrShopGpRow'+$i).data('code')
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
                JSxSHPPaseCodeDelInModal();
            }else{
                var aReturnRepeat = findObjectByKey(aArrayConvert[0],'nCode',nCode);
                if(aReturnRepeat == 'None' ){           //ยังไม่ถูกเลือก
                    obj.push({"nCode": nCode, "tName": tName });
                    localStorage.setItem("LocalItemData",JSON.stringify(obj));
                    JSxSHPPaseCodeDelInModal();
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
                    JSxSHPPaseCodeDelInModal();
                }
            }
            JSxShowButtonChoose();
        })
    });
    </script>
<script type="text/javascript">
    //ปุ่ม set gp special
    function JSxSetGPSpecial(element){
            var tBchCode    = $(element).attr('data-Bch');
            var tShpCode    = $(element).attr('data-ShpCode');
            var dDateStar   = $(element).attr('data-dDateStar');
            var tBchname    = $(element).attr('data-name');
        $.ajax({
            type: "POST",
            url: "CmpShopGpByShopEventcheckData",
            data: {
                tOldStartDate       : dDateStar,
                tBchCode            : tBchCode,
                tShpCode            : $('#ohdShopGpByShpShpCode').val()
            },
            success: function (oResult) {
                JCNxCloseLoading();
                var tResult = JSON.parse(oResult);
                $('#ospGPSpecialBCH').text(' : '  + tBchname);
                $('#ospGPSpecialDate').text(' : ' + dDateStar);
                $('#odvModalGPSpecial').modal('show');
                if(tResult.rtCode == 1){

                    $('.xGPSpacMon').val(Number(tResult.FCSgpPerMon).toFixed(2));
                    $('.xGPSpacTue').val(Number(tResult.FCSgpPerTue).toFixed(2));
                    $('.xGPSpacWed').val(Number(tResult.FCSgpPerWed).toFixed(2));
                    $('.xGPSpacThu').val(Number(tResult.FCSgpPerThu).toFixed(2));
                    $('.xGPSpacFri').val(Number(tResult.FCSgpPerFri).toFixed(2));
                    $('.xGPSpacSat').val(Number(tResult.FCSgpPerSat).toFixed(2));
                    $('.xGPSpacSun').val(Number(tResult.FCSgpPerSun).toFixed(2)); 
                     
                    $('#ohdGPSpecialSHPBchCode').val(tResult.FTBchCode);  
                    $('#ohdGPSpecialSHPShpCode').val(tResult.FTShpCode);  
                    $('#ohdGPSpecialSHPDate').val(tResult.FDSgpStart);  
                    
                }else{
                    alert(tResult.rtDesc);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
        //maxlength
        $('.xWShowInLine').attr('maxlength','5');
    }


    //ปุ่ม save gp special
    function JSxSaveGPSpecial(){
       $.ajax({
            type: "POST",
            url: "CmpShopGpByShopEventInsertData",
            data: {
                tOldStartDate   : $('#ohdGPSpecialSHPDate').val(),
                tBch            : $('#ohdGPSpecialSHPBchCode').val(),
                tShp            : $('#ohdGPSpecialSHPShpCode').val(),
                nMon            : $('.xGPSpacMon').val(),
                nTue            : $('.xGPSpacTue').val(),
                nWed            : $('.xGPSpacWed').val(),
                nThu            : $('.xGPSpacThu').val(),
                nFri            : $('.xGPSpacFri').val(),
                nSat            : $('.xGPSpacSat').val(), 
                nSun            : $('.xGPSpacSun').val()
            },
            success: function (oResult) {
                JCNxCloseLoading();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }


    //Edit inline 
    var oParameterSend =  {
                            "FunctionName"                  : "",
                            "DataAttribute"                 : [],
                            "TableID"                       : "otbShopGPSpecial",
                            "NotFoundDataRowClass"          : "xWTextNotfoundDataTablePdt",
                            "EditInLineButtonDeleteClass"   : "xWDeleteBtnEditButton",
                            "LabelShowDataClass"            : "xWShowInLine",
                            "DivHiddenDataEditClass"        : "xWEditInLine"
                        };
    JCNxSetNewEditInline(oParameterSend);
    $(".xWEditInlineElement").eq(nIndexInputEditInline).focus(function(){
        this.select(); 
    }); 
    setTimeout(function(){
        $(".xWEditInlineElement").eq(nIndexInputEditInline).focus();
    }, 300);
    $(".xWEditInlineElement").removeAttr("disabled");

    //input number only
    $(".xCNInputNumericWithDecimal").on("keypress keyup blur", function (event) {
        $(this).val($(this).val().replace(/[^0-9\.]/g, ''));
        if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
            event.preventDefault();
        }
    });
        
</script>