<div class="row p-t-20">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="table-responsive">
            <table id="otbCourierAddressTableList" class="table table-striped">
                <thead>
                    <tr>
                        <th nowarp class="text-center xCNTextBold" width="10%"><?php echo language('courier/courier/courier','tCRYAddressTblHeadNo');?></th>
                        <th nowarp class="text-center xCNTextBold"><?php echo language('courier/courier/courier','tCRYAddressTblHeadAddrName');?></th>
                        <th nowarp class="text-center xCNTextBold"><?php echo language('courier/courier/courier','tCRYAddressTblHeadAddrTaxNo');?></th>
                        <th nowarp class="text-center xCNTextBold"><?php echo language('courier/courier/courier','tCRYAddressTblHeadAddrRmk');?></th>
                        <th nowarp class="text-center xCNTextBold" width="10%"><?php echo language('courier/courier/courier','tCRYAddressTblHeadAddrDelete')?></th>
                        <th nowarp class="text-center xCNTextBold" width="10%"><?php echo language('courier/courier/courier','tCRYAddressTblHeadAddrEdit')?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(isset($aCourierDataAddress) && !empty($aCourierDataAddress)):?>
                        <?php foreach($aCourierDataAddress AS $nNum => $aDataAddress):?>
                            <tr 
                                class="xCNTextDetail2 xWCourierAddress"
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
                                    <img class="xCNIconTable xCNIconDelete xWCryAddrDelete">
                                </td>
                                <td nowarp class="text-center">
                                    <img class="xCNIconTable xCNIconEdit xWCryAddrEdit">
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
    $('.xWCryAddrDelete').click(function(){
        poElement = this;
        if (poElement.getAttribute("data-dblclick") == null) {
            poElement.setAttribute("data-dblclick", 1);
            $(poElement).select();
            setTimeout(function () {
                if(poElement.getAttribute("data-dblclick") == 1) {
                    var nStaSession = JCNxFuncChkSessionExpired();
                    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                        let oCourierAddressData    = {
                            'FNLngID'       : $(poElement).parents('.xWCourierAddress').data('lngid'),
                            'FTAddGrpType'  : $(poElement).parents('.xWCourierAddress').data('addgrptype'),
                            'FTAddRefCode'  : $(poElement).parents('.xWCourierAddress').data('addrefcode'),
                            'FNAddSeqNo'    : $(poElement).parents('.xWCourierAddress').data('addseqno'),
                        }
                        JSoCourierAddressDeleteData(oCourierAddressData);
                    }else{
                        JCNxShowMsgSessionExpired();
                    }
                }
                poElement.removeAttribute("data-dblclick");
            }, 300);
        }
    });

    // Event Click Edits
    $('.xWCryAddrEdit').click(function(){
        poElement = this;
        if (poElement.getAttribute("data-dblclick") == null) {
            poElement.setAttribute("data-dblclick", 1);
            $(poElement).select();
            setTimeout(function () {
                if(poElement.getAttribute("data-dblclick") == 1) {
                    var nStaSession = JCNxFuncChkSessionExpired();
                    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                        let oCourierAddressData    = {
                            'FNLngID'       : $(poElement).parents('.xWCourierAddress').data('lngid'),
                            'FTAddGrpType'  : $(poElement).parents('.xWCourierAddress').data('addgrptype'),
                            'FTAddRefCode'  : $(poElement).parents('.xWCourierAddress').data('addrefcode'),
                            'FNAddSeqNo'    : $(poElement).parents('.xWCourierAddress').data('addseqno'),
                        }
                        JSvCallPageEditCourierAddress(oCourierAddressData);
                    }else{
                        JCNxShowMsgSessionExpired();
                    }
                }
                poElement.removeAttribute("data-dblclick");
            }, 300);
        }
    });
</script>