
<div class="col-md-12 col-sm-12">
    <br>
    <table id="otbSplDataList" class="table table-striped">
        <thead>
            <tr>
                <th nowarp class="text-center xCNTextBold" width="10%"><?php echo  language('merchant/merchant/merchant','tMCNAddressTblHeadNo');?></th>
                <th nowarp class="text-center xCNTextBold"><?php echo  language('merchant/merchant/merchant','tMCNAddressTblHeadAddrName');?></th>
                <th nowarp class="text-center xCNTextBold"><?php echo  language('merchant/merchant/merchant','tMCNAddressTblHeadAddrTaxNo');?></th>
                <th nowarp class="text-center xCNTextBold"><?php echo  language('merchant/merchant/merchant','tMCNAddressTblHeadAddrRmk');?></th>
                <th nowarp class="text-center xCNTextBold" width="10%"><?php echo  language('merchant/merchant/merchant','tMCNAddressTblHeadAddrDelete');?></th>
                <th nowarp class="text-center xCNTextBold" width="10%"><?php echo  language('merchant/merchant/merchant','tMCNAddressTblHeadAddrEdit');?></th>
            </tr>
        </thead>
        <tbody> 
            <?php 
            $tNum=0;
            if(@$aMerchantAddress['raItems']!=""){
                foreach($aMerchantAddress['raItems'] as $aDataAddrrss){ ?>
                    <tr 
                        class="xCNTextDetail2 xWMerchantAddress"
                        data-lngid="<?php echo $aDataAddrrss['FNLngID'];?>"
                        data-addgrptype="<?php echo $aDataAddrrss['FTAddGrpType'];?>"
                        data-addrefcode="<?php echo $aDataAddrrss['FTAddRefCode'];?>"
                        data-addseqno="<?php echo $aDataAddrrss['FNAddSeqNo'];?>"
                    >
                        <td  nowarp class="text-center"><?php echo ++$tNum; ?></td>
                        <td nowarp><?php echo $aDataAddrrss['FTAddName'];?></td>
                        <td nowarp><?php echo $aDataAddrrss['FTAddTaxNo'];?></td>
                        <td nowarp><?php echo $aDataAddrrss['FTAddRmk'];?></td>
                        <td nowarp class="text-center">
                            <img class="xCNIconTable xWMerAddrDelete" src="<?php echo  base_url().'/application/modules/common/assets/images/icons/delete.png'?>">
                        </td>
                        <td nowarp class="text-center">
                            <img class="xCNIconTable xWMerAddrEdit" src="<?php echo  base_url().'/application/modules/common/assets/images/icons/edit.png'?>">
                        </td>
                    </tr>
            <?php }
            }else{?>
                        <tr class=" xCNTextDetail2 otrSupplier" id="otrSupplier" data-code="" data-name="">
                        <td  nowarp class="text-center" colspan="100"><?php echo  language('supplier/supplier/supplier','tSPLTBInvalidAdd')?></td>
                    </tr>
            <?php }?>
            <input type="hidden" name="ohdDeleteconfirm" id="ohdDeleteconfirm" value="<?php echo language('common/main/main', 'tModalConfirmDeleteItems') ?>">
            <input type="hidden" name="ohdDeleteconfirmYN" id="ohdDeleteconfirmYN" value="<?php echo language('common/main/main', 'tModalConfirmDeleteItemsYN') ?>">
        </tbody>
        
    </table>
</div>
<script type="text/javascript">

    // Event Click Delete
    $('.xWMerAddrDelete').click(function(){
        poElement = this;
        if (poElement.getAttribute("data-dblclick") == null) {
            poElement.setAttribute("data-dblclick", 1);
            $(poElement).select();
            setTimeout(function () {
                if(poElement.getAttribute("data-dblclick") == 1) {
                    var nStaSession = JCNxFuncChkSessionExpired();
                    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                        let aMerchantAddressData    = {
                            'FNLngID'       : $(poElement).parents('.xWMerchantAddress').data('lngid'),
                            'FTAddGrpType'  : $(poElement).parents('.xWMerchantAddress').data('addgrptype'),
                            'FTAddRefCode'  : $(poElement).parents('.xWMerchantAddress').data('addrefcode'),
                            'FNAddSeqNo'    : $(poElement).parents('.xWMerchantAddress').data('addseqno'),
                        }
                        JSoDeletDataMerchantAddress(aMerchantAddressData);
                    }else{
                        JCNxShowMsgSessionExpired();
                    }
                }
                poElement.removeAttribute("data-dblclick");
            }, 300);
        }
    });

    // Event Click Edits
    $('.xWMerAddrEdit').click(function(){
        poElement = this;
        if (poElement.getAttribute("data-dblclick") == null) {
            poElement.setAttribute("data-dblclick", 1);
            $(poElement).select();
            setTimeout(function () {
                if(poElement.getAttribute("data-dblclick") == 1) {
                    var nStaSession = JCNxFuncChkSessionExpired();
                    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                        let aMerchantAddressData    = {
                            'FNLngID'       : $(poElement).parents('.xWMerchantAddress').data('lngid'),
                            'FTAddGrpType'  : $(poElement).parents('.xWMerchantAddress').data('addgrptype'),
                            'FTAddRefCode'  : $(poElement).parents('.xWMerchantAddress').data('addrefcode'),
                            'FNAddSeqNo'    : $(poElement).parents('.xWMerchantAddress').data('addseqno'),
                        }
                        JSvCallPageMerchantEditAddress(aMerchantAddressData);
                    }else{
                        JCNxShowMsgSessionExpired();
                    }
                }
                poElement.removeAttribute("data-dblclick");
            }, 300);
        }
    });



</script>