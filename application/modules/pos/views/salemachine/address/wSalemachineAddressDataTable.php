<div class="row p-t-20">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="table-responsive">
            <table id="otbSalemachineAddressTableList" class="table table-striped">
                <thead>
                    <tr>
                        <th nowarp class="text-center xCNTextBold" width="10%"><?php echo language('pos/salemachine/salemachine','tPOSAddressTblHeadNo');?></th>
                        <th nowarp class="text-center xCNTextBold"><?php echo language('pos/salemachine/salemachine','tPOSAddressTblHeadAddrName');?></th>
                        <th nowarp class="text-center xCNTextBold"><?php echo language('pos/salemachine/salemachine','tPOSAddressTblHeadAddrTaxNo');?></th>
                        <th nowarp class="text-center xCNTextBold"><?php echo language('pos/salemachine/salemachine','tPOSAddressTblHeadAddrRmk');?></th>
                        <th nowarp class="text-center xCNTextBold" width="10%"><?php echo language('pos/salemachine/salemachine','tPOSAddressTblHeadAddrDelete')?></th>
                        <th nowarp class="text-center xCNTextBold" width="10%"><?php echo language('pos/salemachine/salemachine','tPOSAddressTblHeadAddrEdit')?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(isset($aSalemachineDataAddress) && !empty($aSalemachineDataAddress)):?>
                        <?php foreach($aSalemachineDataAddress AS $nNum => $aDataAddress):?>
                            <tr 
                                class="xCNTextDetail2 xWSalemachineAddress"
                                data-lngid="<?php echo $aDataAddress['FNLngID'];?>"
                                data-addgrptype="<?php echo $aDataAddress['FTAddGrpType'];?>"
                                data-addrefcode="<?php echo $aDataAddress['FTAddRefCode'];?>"
                                data-addseqno="<?php echo $aDataAddress['FNAddSeqNo'];?>"
                            >
                                <td nowarp class="text-center"><?php echo $aDataAddress['FTAddRefNo'];?></td>
                                <td nowarp class="text-left"><?php echo $aDataAddress['FTAddName'];?></td>
                                <td nowarp class="text-left"><?php echo $aDataAddress['FTAddTaxNo'];?></td>
                                <td nowarp class="text-left"><?php echo $aDataAddress['FTAddRmk'];?></td>
                                <td nowarp class="text-center"><img class="xCNIconTable xCNIconDelete xWPosAddrDelete"></td>
                                <td nowarp class="text-center"><img class="xCNIconTable xCNIconEdit xWPosAddrEdit"></td>
                            </tr>
                        <?php endforeach;?>
                    <?php else:?>
                        <tr><td class='text-center xCNTextDetail2' colspan='100'><?php echo language('common/main/main','tCMNNotFoundData')?></td></tr>
                    <?php endif;?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script type="text/javascript">
    // Event Click Delete
    $('.xWPosAddrDelete').click(function(){
        poElement = this;
        if (poElement.getAttribute("data-dblclick") == null) {
            poElement.setAttribute("data-dblclick", 1);
            $(poElement).select();
            setTimeout(function () {
                if(poElement.getAttribute("data-dblclick") == 1) {
                    var nStaSession = JCNxFuncChkSessionExpired();
                    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                        let oSalemachineAddressData    = {
                            'FNLngID'       : $(poElement).parents('.xWSalemachineAddress').data('lngid'),
                            'FTAddGrpType'  : $(poElement).parents('.xWSalemachineAddress').data('addgrptype'),
                            'FTAddRefCode'  : $(poElement).parents('.xWSalemachineAddress').data('addrefcode'),
                            'FNAddSeqNo'    : $(poElement).parents('.xWSalemachineAddress').data('addseqno'),
                        }
                        JSoSalemachineAddressDeleteData(oSalemachineAddressData);
                    }else{
                        JCNxShowMsgSessionExpired();
                    }
                }
                poElement.removeAttribute("data-dblclick");
            }, 300);
        }
    });

    // Event Click Edits
    $('.xWPosAddrEdit').click(function(){
        poElement = this;
        if (poElement.getAttribute("data-dblclick") == null) {
            poElement.setAttribute("data-dblclick", 1);
            $(poElement).select();
            setTimeout(function () {
                if(poElement.getAttribute("data-dblclick") == 1) {
                    var nStaSession = JCNxFuncChkSessionExpired();
                    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                        let oSalemachineAddressData    = {
                            'FNLngID'       : $(poElement).parents('.xWSalemachineAddress').data('lngid'),
                            'FTAddGrpType'  : $(poElement).parents('.xWSalemachineAddress').data('addgrptype'),
                            'FTAddRefCode'  : $(poElement).parents('.xWSalemachineAddress').data('addrefcode'),
                            'FNAddSeqNo'    : $(poElement).parents('.xWSalemachineAddress').data('addseqno'),
                        }
                        JSvCallPageEditSalemachineAddress(oSalemachineAddressData);
                    }else{
                        JCNxShowMsgSessionExpired();
                    }
                }
                poElement.removeAttribute("data-dblclick");
            }, 300);
        }
    });
</script>