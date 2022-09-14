

<div class="table-responsive">
    <input type="text" class="xCNHide" id="oetPTUStep2NumRow" value="<?=$aDataList['nNumRow']?>">
    <input type="text" class="xCNHide" id="oetPTUStep2DecimalShow" value="<?=$nOptDecimalShow?>">
    <input type="text" class="xCNHide" id="oetPTUStep2OnBrowseSeq" value="">
    <table class="table table-striped xWPdtTableFont" id="otbPTUStep2Table" w>
        <thead>
            <tr>
                <th nowrap class="text-center"><?php echo language('sale/promotiontopup/promotiontopup', 'tTBNo'); ?></th>
                <th nowrap class="text-center"><?php echo language('sale/promotiontopup/promotiontopup', 'tPTUPmcRefIn'); ?></th>
                <th nowrap class="text-center"><?php echo language('sale/promotiontopup/promotiontopup', 'tPTUPmcAmtPay'); ?></th>
                <th nowrap class="text-center" style="min-width: 150px;" ><?php echo language('sale/promotiontopup/promotiontopup', 'tPTUPmcCondition'); ?></th>
                <th nowrap class="text-center"><?php echo language('sale/promotiontopup/promotiontopup', 'tPTUPmcAmtGet'); ?></th>
                <th nowrap class="text-center"><?php echo language('sale/promotiontopup/promotiontopup', 'tPTUPmcRefEx'); ?></th>
                <th nowrap class="text-center xWPTUHideOnApvOrCancel"><?php echo language('sale/promotiontopup/promotiontopup', 'tTBDelete'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php if ($aDataList['tCode'] == 1) { ?>
                <?php 
                    foreach ($aDataList['aItems'] as $key => $aValue){ 
                        $tStaBrowseCoupon  = '';
                        $tStaInputAmtGet   = '';
                        if( $aValue['FCPmcAmtGet'] > 0 && $aValue['FTPmcRefIn'] == '' ){
                            $tConditionGet = '2';
                            $tStaBrowseCoupon = 'disabled';
                        }else if( $aValue['FCPmcAmtGet'] == 0 && $aValue['FTPmcRefIn'] != '' ){
                            $tConditionGet = '3';
                            $tStaInputAmtGet = 'disabled';
                        }else{
                            $tConditionGet = '1';
                        }
                ?>
                    <tr class="xCNTextDetail2 xWPTUStep2Tr" 
                        data-seq="<?php echo $aValue['FNPmdSeq']; ?>"
                    >
                        <td nowrap class="text-center"><?php echo $key+1; ?></td>
                        <td nowrap class="text-left">
                            <input
                                autocomplete="off"
                                type="text"
                                class="form-control text-left xCNApvOrCanCelDisabled xCNPdtEditInLine xWFTPmcRefEx"
                                id="oetPTUPmcRefEx<?php echo $aValue['FNPmdSeq'];?>"
                                name="oetPTUPmcRefEx<?php echo $aValue['FNPmdSeq'];?>"
                                value="<?php echo $aValue['FTPmcRefEx']; ?>"
                                data-field="FTPmcRefEx"
                                style=" background-color: transparent; box-shadow: 0px 0px 0px inset;
                                        border-top: 0px !important; border-left: 0px !important;
                                        border-right: 0px !important; padding: 5px !important;
                                      "
                            >
                        </td>
                        <td nowrap class="text-right">
                            <input
                                autocomplete="off"
                                type="text"
                                class="form-control text-right xCNApvOrCanCelDisabled xCNPdtEditInLine xWFCPmcAmtPay"
                                id="oetPTUPmcAmtPay<?php echo $aValue['FNPmdSeq'];?>"
                                name="oetPTUPmcAmtPay<?php echo $aValue['FNPmdSeq'];?>"
                                value="<?php echo number_format($aValue['FCPmcAmtPay'],$nOptDecimalShow); ?>"
                                data-field="FCPmcAmtPay"
                                style=" background-color: transparent; box-shadow: 0px 0px 0px inset;
                                        border-top: 0px !important; border-left: 0px !important;
                                        border-right: 0px !important; padding: 5px !important;
                                      "
                            >
                        </td>
                        <td nowrap class="text-left">
                            <select class="selectpicker form-control xWPTUStep2ConditionGet xCNApvOrCanCelDisabled" id="ocmPTUStep2ConditionGet<?php echo $aValue['FNPmdSeq'];?>" name="ocmPTUStep2ConditionGet<?php echo $aValue['FNPmdSeq'];?>" data-container="body">
                                <option <?php if($tConditionGet=='1'){ echo 'selected'; } ?> value="1"><?=language('sale/promotiontopup/promotiontopup', 'tPTUStep2ConGet1');?></option>
                                <option <?php if($tConditionGet=='2'){ echo 'selected'; } ?> value="2"><?=language('sale/promotiontopup/promotiontopup', 'tPTUStep2ConGet2');?></option>
                                <option <?php if($tConditionGet=='3'){ echo 'selected'; } ?> value="3"><?=language('sale/promotiontopup/promotiontopup', 'tPTUStep2ConGet3');?></option>
                            </select>
                        </td>
                        <td nowrap class="text-right">
                            <input
                                autocomplete="off"
                                type="text"
                                class="form-control text-right xCNApvOrCanCelDisabled xCNPdtEditInLine xWFCPmcAmtGet"
                                id="oetPTUPmcAmtGet<?php echo $aValue['FNPmdSeq'];?>"
                                name="oetPTUPmcAmtGet<?php echo $aValue['FNPmdSeq'];?>"
                                value="<?php echo number_format($aValue['FCPmcAmtGet'],$nOptDecimalShow); ?>"
                                data-field="FCPmcAmtGet"
                                <?php echo $tStaInputAmtGet; ?>
                                style=" background-color: transparent; box-shadow: 0px 0px 0px inset;
                                        border-top: 0px !important; border-left: 0px !important;
                                        border-right: 0px !important; padding: 5px !important;
                                      "
                            >
                        </td>
                        <td nowrap class="text-left">
                            <div class="input-group">
                                <input type="text" class="input100 xCNHide xWPTUStep2Coupon" id="oetPTUCphDocNo<?php echo $aValue['FNPmdSeq'];?>" name="oetPTUCphDocNo<?php echo $aValue['FNPmdSeq'];?>" value="<?php echo $aValue['FTPmcRefIn']; ?>">
                                <input class="form-control xWPointerEventNone" type="text" id="oetPTUCpnName<?php echo $aValue['FNPmdSeq'];?>" name="oetPTUCpnName<?php echo $aValue['FNPmdSeq'];?>" value="<?php echo $aValue['FTPmcRefInName']; ?>" readonly placeholder="<?php echo language('sale/promotiontopup/promotiontopup', 'tPTUTBCoupon'); ?>">
                                <span class="input-group-btn xWConditionSearchPdt">
                                    <button id="oetPTUBrowseCoupon<?php echo $aValue['FNPmdSeq'];?>" type="button" class="btn xCNBtnBrowseAddOn xWPTUBrowseCoupon" data-seq="<?php echo $aValue['FNPmdSeq'];?>" <?php echo $tStaBrowseCoupon; ?>>
                                        <img src="<?php echo  base_url().'application/modules/common/assets/images/icons/find-24.png'?>">
                                    </button>
                                </span>
                            </div>
                        </td>
                        <td nowrap class="text-center xWPTUHideOnApvOrCancel">
                            <img class="xCNIconTable xCNIconDel xWPTUStep2Del" src="<?= base_url('application/modules/common/assets/images/icons/delete.png') ?>">
                        </td>
                    </tr>
                <?php } ?>
            <?php } else { ?>
                <tr>
                    <td class='text-center xCNTextDetail2' colspan='100%'><?= language('common/main/main', 'tCMNNotFoundData') ?></td>
                </tr>
            <?php }; ?>
        </tbody>
    </table>
</div>
<script>
    $(document).ready(function(){
        $('.selectpicker').selectpicker('show');
        if(bIsApvOrCancel){
            $('.xWPTUHideOnApvOrCancel').hide();
            $('.xCNApvOrCanCelDisabled').attr('disabled',true);
        }
    });

    // Create By : Napat(Jame) 24/09/2020
    $('.xWPTUStep2Del').off('click');
    $('.xWPTUStep2Del').on('click',function(){
        JSxPTUEventStep2Delete($(this));
    });

    // Create By : Napat(Jame) 24/09/2020
    sessionStorage.removeItem("EditInLine");

    $('.xCNPdtEditInLine').off('keydown');
    $('.xCNPdtEditInLine').on('keydown',function(){
        if(event.keyCode == 13){
            if(sessionStorage.getItem("EditInLine") != "2"){
                sessionStorage.setItem("EditInLine", "1");
                JSxPTUEventStep2EditInLine($(this));
            }
        }
    });

    $('.xCNPdtEditInLine').off('focus');
    $('.xCNPdtEditInLine').on('focus',function(){
        this.select();
    });

    $('.xCNPdtEditInLine').off('change');
    $('.xCNPdtEditInLine').on('change',function(){
        if(sessionStorage.getItem("EditInLine") != "2"){
            sessionStorage.setItem("EditInLine", "1");
            JSxPTUEventStep2EditInLine($(this));
        }
    });

    // Create By : Napat(Jame) 24/09/2020
    $('.xWPTUBrowseCoupon').off('click');
    $('.xWPTUBrowseCoupon').on('click',function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            let nSeq = $(this).attr('data-seq');
            $('#oetPTUStep2OnBrowseSeq').val(nSeq);
            window.oOptionBrowsCoupon   = undefined;
            oOptionBrowsCoupon          = oPTUBrowseCoupon({
                'tReturnInputCode'  : 'oetPTUCphDocNo' + nSeq,
                'tReturnInputName'  : 'oetPTUCpnName' + nSeq,
                'tNextFuncName'     : 'JSxPTUBrowseNextFuncCoupon',
                'aArgReturn'        : ['FTCphDocNo']
            });
            JCNxBrowseData('oOptionBrowsCoupon');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    var oPTUBrowseCoupon  = function(poReturnInput){
        let tInputReturnCode = poReturnInput.tReturnInputCode;
        let tInputReturnName = poReturnInput.tReturnInputName;
        let tNextFuncName    = poReturnInput.tNextFuncName;
        let aArgReturn       = poReturnInput.aArgReturn;
        let tWhereSQL        = " AND TFNTCouponHD.FTCphStaApv = '1' ";
        let tLeftJoin        = "";

        let tSesUsrLevel     = '<?=$this->session->userdata("tSesUsrLevel")?>';

        var tAgenCode = '<?php echo $this->session->userdata('tSesUsrAgnCode'); ?>';

        var tWhereCardByAgenCode = "";


        if( tSesUsrLevel != "HQ" ){
            let tSesUsrBchCodeMulti = "<?=$this->session->userdata("tSesUsrBchCodeMulti")?>";
            let tSesUsrAgnCode      = '<?=$this->session->userdata("tSesUsrAgnCode")?>';
            // tWhereSQL += " AND BCH.FTAgnCode = '00038' OR ISNULL(BCH.FTAgnCode, '') = '' ";
            tLeftJoin += " LEFT JOIN TFNTCouponHDBch HDBCH ON TFNTCouponHD.FTCphDocNo = HDBCH.FTCphDocNo AND ( HDBCH.FTCphBchTo IN ("+tSesUsrBchCodeMulti+") OR HDBCH.FTCphAgnTo = '"+tSesUsrAgnCode+"' ) ";
            tLeftJoin += " LEFT JOIN TFNTCouponHDBch NOTHD ON NOTHD.FTCphDocNo = TFNTCouponHD.FTCphDocNo "
            tLeftJoin += " LEFT JOIN TCNMBranch BCH  ON TFNTCouponHD.FTBchCode = BCH.FTBchCode"
            
            tWhereCardByAgenCode = " AND (BCH.FTAgnCode = '" + tAgenCode + "' OR ISNULL(BCH.FTAgnCode, '') = '')";
            tWhereCardByAgenCode += " AND CONCAT(CONVERT(DATE, TFNTCouponHD.FDCphDateStop, 108), ' ', CONVERT(varchar, TFNTCouponHD.FTCphTimeStop, 8)) > CONVERT(varchar, GETDATE(), 20)";
        }

        let oBchOptionReturn    = {
            Title: ['coupon/coupon/coupon','tCPNTitle'],
            Table:{
                Master:'TFNTCouponHD',
                PK:'FTCphDocNo'},
            Join :{
                Table:	['TFNTCouponHD_L'],
                On:     ['TFNTCouponHD_L.FTCphDocNo = TFNTCouponHD.FTCphDocNo AND TFNTCouponHD_L.FNLngID = ' + nLangEdit + " " + tLeftJoin ]
            },
            Where:{
                Condition: [tWhereSQL + tWhereCardByAgenCode]
            },
            GrideView:{
                ColumnPathLang	: 'coupon/coupon/coupon',
                ColumnKeyLang	: ['tCPNTBCpnCode','tCPNTBCpnName'],
                ColumnsSize     : ['15%','75%'],
                WidthModal      : 50,
                DataColumns		: ['TFNTCouponHD.FTCphDocNo','TFNTCouponHD_L.FTCpnName'],
                DataColumnsFormat : ['',''],
                Perpage			: 10,
                OrderBy			: ['TFNTCouponHD.FDCreateOn DESC'],
            },
            CallBack:{
                ReturnType	: 'S',
                Value		: [tInputReturnCode,"TFNTCouponHD.FTCphDocNo"],
                Text		: [tInputReturnName,"TFNTCouponHD_L.FTCpnName"]
            },
            NextFunc : {
                FuncName    : tNextFuncName,
                ArgReturn   : aArgReturn
            },
            // DebugSQL: true
            // RouteAddNew: 'branch',
            // BrowseLev: 1
        }
        return oBchOptionReturn;
    }

    $('.xWPTUStep2ConditionGet').off('change');
    $('.xWPTUStep2ConditionGet').on('change',function(){
        let tType    = $(this).val();
        let nSeq     = $(this).parent().parent().parent().attr('data-seq');
        let nDecimal = $('#oetPTUStep2DecimalShow').val();
        
        switch(tType){
            case '1':
                $('#oetPTUPmcAmtGet' + nSeq).attr('disabled',false);
                $('#oetPTUBrowseCoupon' + nSeq).attr('disabled',false);
                break;
            case '2':
                $('#oetPTUPmcAmtGet' + nSeq).attr('disabled',false);
                $('#oetPTUBrowseCoupon' + nSeq).attr('disabled',true);
                $('#oetPTUCphDocNo' + nSeq).val('');
                $('#oetPTUCpnName' + nSeq).val('');
                JSxPTUEventStep2SetValue('FTPmcRefIn','FT',nSeq,'NULL');
                break;
            case '3':
                $('#oetPTUPmcAmtGet' + nSeq).attr('disabled',true);
                $('#oetPTUBrowseCoupon' + nSeq).attr('disabled',false);
                let nVal = 0;
                $('#oetPTUPmcAmtGet' + nSeq).val(nVal.toFixed(nDecimal));
                JSxPTUEventStep2SetValue('FCPmcAmtGet','FC',nSeq,0);
                break;
        }

        $('.selectpicker').selectpicker('refresh');
    });

</script>