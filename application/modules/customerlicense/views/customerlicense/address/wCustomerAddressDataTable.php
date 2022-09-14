<div class="row p-t-20">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="table-responsive">
            <table id="otbCustomerAddressTableList" class="table table-striped">
                <thead>
                    <tr>
                        <th nowarp class="text-center xCNTextBold" width="10%"><?php echo language('customer/customer/customer','tCSTAddressTblHeadNo');?></th>
                        <th nowarp class="text-center xCNTextBold"><?php echo language('customer/customer/customer','tCSTAddressTblHeadAddrName');?></th>
                        <th nowarp class="text-center xCNTextBold"><?php echo language('customer/customer/customer','tCSTAddressTblHeadAddrRmk');?></th>
                        <th nowarp class="text-center xCNTextBold" width="10%"><?php echo language('customer/customer/customer','tCSTAddressTblHeadAddrDelete')?></th>
                        <th nowarp class="text-center xCNTextBold" width="10%"><?php echo language('customer/customer/customer','tCSTAddressTblHeadAddrEdit')?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(isset($aCustomerDataAddress) && !empty($aCustomerDataAddress)):?>
                        <?php foreach($aCustomerDataAddress AS $nNum => $aDataAddress):?>
                            <tr
                                class="xCNTextDetail2 xWCustomerAddress"
                                data-addcstcode="<?php echo $aDataAddress['FTCstCode'];?>"
                                data-lngid="<?php echo $aDataAddress['FNLngID'];?>"
                                data-addgrptype="<?php echo $aDataAddress['FTAddGrpType'];?>"
                                data-addseqno="<?php echo $aDataAddress['FNAddSeqNo'];?>"
                            >
                                <td nowarp class="text-center"><?php echo $aDataAddress['FTAddRefNo'];?></td>
                                <td nowarp class="text-left"><?php echo $aDataAddress['FTAddName'];?></td>
                                <td nowarp class="text-left"><?php echo $aDataAddress['FTAddRmk'];?></td>
                                <td nowarp class="text-center">
                                    <img class="xCNIconTable xCNIconDelete xWCstAddrDelete">
                                </td>
                                <td nowarp class="text-center">
                                    <img class="xCNIconTable xCNIconEdit xWCstAddrEdit">
                                </td>
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
    // Event Click Delete Customer
    $('#otbCustomerAddressTableList .xWCstAddrDelete').click(function(){
        poElement = this;
        if (poElement.getAttribute("data-dblclick") == null) {
            poElement.setAttribute("data-dblclick", 1);
            $(poElement).select();
            setTimeout(function () {
                if(poElement.getAttribute("data-dblclick") == 1) {
                    let nStaSession = JCNxFuncChkSessionExpired();
                    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                        let oCustomerAddressData    = {
                            'FTCstCode'     : $(poElement).parents('.xWCustomerAddress').data('addcstcode'),
                            'FNLngID'       : $(poElement).parents('.xWCustomerAddress').data('lngid'),
                            'FTAddGrpType'  : $(poElement).parents('.xWCustomerAddress').data('addgrptype'),
                            'FNAddSeqNo'    : $(poElement).parents('.xWCustomerAddress').data('addseqno'), 
                        };
                        JSoCustomerAddressDeleteData(oCustomerAddressData);
                    }else{
                        JCNxShowMsgSessionExpired();
                    }
                }
            },300);
        }
    });

    // Event Click Edits Customer
    $('#otbCustomerAddressTableList .xWCstAddrEdit').click(function(){
        poElement = this;
        if (poElement.getAttribute("data-dblclick") == null) {
            poElement.setAttribute("data-dblclick", 1);
            $(poElement).select();
            setTimeout(function () {
                if(poElement.getAttribute("data-dblclick") == 1) {
                    let nStaSession = JCNxFuncChkSessionExpired();
                    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                        let oCustomerAddressData    = {
                            'FTCstCode'     : $(poElement).parents('.xWCustomerAddress').data('addcstcode'),
                            'FNLngID'       : $(poElement).parents('.xWCustomerAddress').data('lngid'),
                            'FTAddGrpType'  : $(poElement).parents('.xWCustomerAddress').data('addgrptype'),
                            'FNAddSeqNo'    : $(poElement).parents('.xWCustomerAddress').data('addseqno'), 
                        };
                        JSvCallPageEditCustomerAddress(oCustomerAddressData);
                    }else{
                        JCNxShowMsgSessionExpired();
                    }
                }
                poElement.removeAttribute("data-dblclick");
            }, 300);
        }
    });


</script>