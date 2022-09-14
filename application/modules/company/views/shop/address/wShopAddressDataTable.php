<div class="row p-t-20">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="table-responsive">
            <table id="otbShopAddressTableList" class="table table-striped">
                <thead>
                    <tr>
                        <th nowarp class="text-center xCNTextBold" width="10%"><?php echo language('company/shop/shop','tSHPAddressTblHeadNo');?></th>
                        <th nowarp class="text-center xCNTextBold"><?php echo language('company/shop/shop','tSHPAddressTblHeadAddrName');?></th>
                        <th nowarp class="text-center xCNTextBold"><?php echo language('company/shop/shop','tSHPAddressTblHeadAddrTaxNo');?></th>
                        <th nowarp class="text-center xCNTextBold"><?php echo language('company/shop/shop','tSHPAddressTblHeadAddrRmk');?></th>
                        <th nowarp class="text-center xCNTextBold" width="10%"><?php echo language('company/shop/shop','tSHPAddressTblHeadAddrDelete')?></th>
                        <th nowarp class="text-center xCNTextBold" width="10%"><?php echo language('company/shop/shop','tSHPAddressTblHeadAddrEdit')?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(isset($aShopDataAddress) && !empty($aShopDataAddress)):?>
                        <?php foreach($aShopDataAddress AS $nNum => $aDataAddress):?>
                            <tr 
                                class="xCNTextDetail2 xWShopAddress"
                                data-lngid="<?php echo $aDataAddress['FNLngID'];?>"
                                data-addgrptype="<?php echo $aDataAddress['FTAddGrpType'];?>"
                                data-addrefcode="<?php echo $aDataAddress['FTAddRefCode'];?>"
                                data-addseqno="<?php echo $aDataAddress['FNAddSeqNo'];?>"
                            >
                                <td nowarp class="text-center"><?php echo $aDataAddress['FTAddRefNo'];?></td>
                                <td nowarp class="text-left"><?php echo $aDataAddress['FTAddName'];?></td>
                                <td nowarp class="text-left"><?php echo $aDataAddress['FTAddTaxNo'];?></td>
                                <td nowarp class="text-left"><?php echo $aDataAddress['FTAddRmk'];?></td>
                                <td nowarp class="text-center">
                                    <img class="xCNIconTable xCNIconDelete xWShpAddrDelete">
                                </td>
                                <td nowarp class="text-center">
                                    <img class="xCNIconTable xCNIconEdit xWShpAddrEdit">
                                </td>
                            </tr>
                        <?php endforeach;?>
                    <?php else:?>
                        <tr><td class='text-center xCNTextDetail2' colspan='100'><?= language('common/main/main','tCMNNotFoundData')?></td></tr>
                    <?php endif;?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script type="text/javascript">

    // Event Click Delete
    $('.xWShpAddrDelete').click(function(){
        poElement = this;
        if (poElement.getAttribute("data-dblclick") == null) {
            poElement.setAttribute("data-dblclick", 1);
            $(poElement).select();
            setTimeout(function () {
                if(poElement.getAttribute("data-dblclick") == 1) {
                    var nStaSession = JCNxFuncChkSessionExpired();
                    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                        let oShopAddressData    = {
                            'FNLngID'       : $(poElement).parents('.xWShopAddress').data('lngid'),
                            'FTAddGrpType'  : $(poElement).parents('.xWShopAddress').data('addgrptype'),
                            'FTAddRefCode'  : $(poElement).parents('.xWShopAddress').data('addrefcode'),
                            'FNAddSeqNo'    : $(poElement).parents('.xWShopAddress').data('addseqno'),
                        }
                        JSoShopAddressDeleteData(oShopAddressData);
                    }else{
                        JCNxShowMsgSessionExpired();
                    }
                }
                poElement.removeAttribute("data-dblclick");
            }, 300);
        }
    });

    // Event Click Edits
    $('.xWShpAddrEdit').click(function(){
        poElement = this;
        if (poElement.getAttribute("data-dblclick") == null) {
            poElement.setAttribute("data-dblclick", 1);
            $(poElement).select();
            setTimeout(function () {
                if(poElement.getAttribute("data-dblclick") == 1) {
                    var nStaSession = JCNxFuncChkSessionExpired();
                    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                        let oShopAddressData    = {
                            'FNLngID'       : $(poElement).parents('.xWShopAddress').data('lngid'),
                            'FTAddGrpType'  : $(poElement).parents('.xWShopAddress').data('addgrptype'),
                            'FTAddRefCode'  : $(poElement).parents('.xWShopAddress').data('addrefcode'),
                            'FNAddSeqNo'    : $(poElement).parents('.xWShopAddress').data('addseqno'),
                        }
                        JSvCallPageEditShopAddress(oShopAddressData);
                    }else{
                        JCNxShowMsgSessionExpired();
                    }
                }
                poElement.removeAttribute("data-dblclick");
            }, 300);
        }
    });

</script>