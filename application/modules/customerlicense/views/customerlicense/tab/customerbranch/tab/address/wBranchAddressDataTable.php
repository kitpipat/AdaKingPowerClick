<div class="row p-t-20">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="table-responsive">
            <table id="otbBranchAddressTableList" class="table table-striped">
                <thead>
                    <tr>
                        <th nowarp class="text-center xCNTextBold" width="10%"><?php echo language('company/branch/branch','tBCHAddressTblHeadNo');?></th>
                        <th nowarp class="text-center xCNTextBold" width="35%"><?php echo language('company/branch/branch','tBCHAddressTblHeadAddrName');?></th>
                        <th nowarp class="text-center xCNTextBold" width="35%"><?php echo language('company/branch/branch','tBCHAddressTblHeadAddrRmk');?></th>
                        <th nowarp class="text-center xCNTextBold" width="10%"><?php echo language('company/branch/branch','tBCHAddressTblHeadAddrDelete')?></th>
                        <th nowarp class="text-center xCNTextBold" width="10%"><?php echo language('company/branch/branch','tBCHAddressTblHeadAddrEdit')?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(isset($aBranchDataAddress) && !empty($aBranchDataAddress)):?>
                        <?php foreach($aBranchDataAddress AS $nNum => $aDataAddress):?>
                            <tr 
                                class="xCNTextDetail2 xWBranchAddress"
                                data-lngid="<?php echo $aDataAddress['FNLngID'];?>"
                                data-addgrptype="<?php echo $aDataAddress['FTAddGrpType'];?>"
                                data-addrefcode="<?php echo $aDataAddress['FTAddRefNo'];?>"
                                data-addseqno="<?php echo $aDataAddress['FNAddSeqNo'];?>"
                            >
                                <td nowarp class="text-center"><?php echo ($nNum+1);?></td>
                                <td nowarp class="text-left"><?php echo $aDataAddress['FTAddName'];?></td>
                                <td nowarp class="text-left"><?php echo $aDataAddress['FTAddRmk'];?></td>
                                <td nowarp class="text-center">
                                    <img class="xCNIconTable xCNIconDelete xWBchAddrDelete">
                                </td>
                                <td nowarp class="text-center">
                                    <img class="xCNIconTable xCNIconEdit xWBchAddrEdit">
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
    // Event Click Delete
    $('.xWBchAddrDelete').click(function(){
        poElement = this;
        if (poElement.getAttribute("data-dblclick") == null) {
            poElement.setAttribute("data-dblclick", 1);
            $(poElement).select();
            setTimeout(function () {
                if(poElement.getAttribute("data-dblclick") == 1) {
                    var nStaSession = JCNxFuncChkSessionExpired();
                    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                        let oBranchAddressData    = {
                            'FNLngID'       : $(poElement).parents('.xWBranchAddress').data('lngid'),
                            'FTAddGrpType'  : $(poElement).parents('.xWBranchAddress').data('addgrptype'),
                            'FTAddRefNo'  : $(poElement).parents('.xWBranchAddress').data('addrefcode'),
                            'FNAddSeqNo'    : $(poElement).parents('.xWBranchAddress').data('addseqno'),
                            'FTCstCode'    : $('#oetCstCode').val() ,
                        }
                        JSaTBABchAddrDelete(oBranchAddressData);
                    }else{
                        JCNxShowMsgSessionExpired();
                    }
                }
                poElement.removeAttribute("data-dblclick");
            }, 300);
        }
    });
    // Event Click Edits
    $('.xWBchAddrEdit').click(function(){
        poElement = this;
        if (poElement.getAttribute("data-dblclick") == null) {
            poElement.setAttribute("data-dblclick", 1);
            $(poElement).select();
            setTimeout(function () {
                if(poElement.getAttribute("data-dblclick") == 1) {
                    var nStaSession = JCNxFuncChkSessionExpired();
                    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                        let oBranchAddressData    = {
                            'FNLngID'       : $(poElement).parents('.xWBranchAddress').data('lngid'),
                            'FTAddGrpType'  : $(poElement).parents('.xWBranchAddress').data('addgrptype'),
                            'FTAddRefNo'  : $(poElement).parents('.xWBranchAddress').data('addrefcode'),
                            'FNAddSeqNo'    : $(poElement).parents('.xWBranchAddress').data('addseqno'),
                            'FTCstCode'    : $('#oetCstCode').val() ,
                            'FTCbrRefBch'    : $('#oetCbrRefBch').val() ,
                        }
                        JSvTBACallPageBchAddrEdit(oBranchAddressData);
                    }else{
                        JCNxShowMsgSessionExpired();
                    }
                }
                poElement.removeAttribute("data-dblclick");
            }, 300);
        }
    });
</script>