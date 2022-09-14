<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            <table id="otbStmDataList" class="table table-striped"> <!-- เปลี่ยน -->
                <thead>
                    <tr>
                        <th nowrap class="text-center xCNTextBold" style="width:15%;"><?= language('payment/installmentterms/installmentterms','tSTMCrdCode')?></th>
                        <th nowrap class="text-center xCNTextBold"><?= language('payment/installmentterms/installmentterms','tSTMCrdName')?></th>
                        <th nowrap class="text-center xCNTextBold" style="width:20%;"><?= language('payment/installmentterms/installmentterms','tSTMBnkName')?></th>
                        <th nowrap class="text-center xCNTextBold" style="width:7%;"><?= language('payment/installmentterms/installmentterms','tSTMDelete')?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if($aStmSubDataList['rtCode'] == 1 ):?>
                        <?php foreach($aStmSubDataList['raItems'] AS $nKey => $aValue):?>
                            <tr class="text-left xCNTextDetail2" data-code="<?=$aValue['FTCrdCode']?>" data-name="<?=$aValue['FTCrdName']?>">
                                <td nowrap class="text-left"><?=$aValue['FTCrdCode']?></td>
                                <td nowrap class="text-left"><?=$aValue['FTCrdName']?></td>
                                <td nowrap class="text-left"><?=$aValue['FTBnkName']?></td>
                                <td nowrap class="text-center">
                                    <img class="xCNIconTable xWStmSubDelete" src="<?php echo  base_url().'/application/modules/common/assets/images/icons/delete.png'?>">
                                </td>
                            </tr>
                        <?php endforeach;?>
                    <?php else:?>
                        <tr><td class='text-center xCNTextDetail2' colspan='5'><?= language('payment/installmentterms/installmentterms','tSTMNoData')?></td></tr>
                    <?php endif;?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    $('.xWStmSubDelete').off('click').on('click',function(){
        var tCrdCode = $(this).parent().parent().attr('data-code');
        var tCrdName = $(this).parent().parent().attr('data-name');
        FSvCMNSetMsgWarningDialog('ยืนยันการลบข้อมูล : '+tCrdCode+' ('+tCrdName+') ใช่หรือไม่ ?','JSxStmSubDelete','',tCrdCode);
    });

    function JSxStmSubDelete(ptCrdCode){
        JCNxOpenLoading();
        $.ajax({
            type: "POST",
            url: "masInstallmentTermsSubEventDelete",
            data: {
                oetStmAgnCode     : $('#oetStmAgnCode').val(),
                oetStmCode        : $('#oetStmCode').val(),
                oetStmCrdCode     : ptCrdCode
            },
            cache: false,
            Timeout: 0,
            success: function(oResult) {
                var aReturnData = JSON.parse(oResult);
                if( aReturnData['nStaEvent'] == 1 ){
                    JSxStmSubPageDataTable();
                }else{
                    alert(aReturnData['tStaMessg']);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }
</script>