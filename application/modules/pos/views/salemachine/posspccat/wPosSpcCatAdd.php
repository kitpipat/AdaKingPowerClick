<?php
    if( $aPosSpcCatData['tCode'] == "1" ){

        $nCatSeq            = $aPosSpcCatData['aItems']['FNCatSeq'];
        $tPgpCode           = $aPosSpcCatData['aItems']['FTPgpChain'];
        $tPgpName           = $aPosSpcCatData['aItems']['FTPgpName'];
        $tPtyCode           = $aPosSpcCatData['aItems']['FTPtyCode'];
        $tPtyName           = $aPosSpcCatData['aItems']['FTPtyName'];
        $tPbnCode           = $aPosSpcCatData['aItems']['FTPbnCode'];
        $tPbnName           = $aPosSpcCatData['aItems']['FTPbnName'];
        $tPmoCode           = $aPosSpcCatData['aItems']['FTPmoCode'];
        $tPmoName           = $aPosSpcCatData['aItems']['FTPmoName'];
        $tTcgCode           = $aPosSpcCatData['aItems']['FTTcgCode'];
        $tTcgName           = $aPosSpcCatData['aItems']['FTTcgName'];

        $aCatCodeInfo = array(
            1 => $aPosSpcCatData['aItems']['FTPdtCat1'],
            2 => $aPosSpcCatData['aItems']['FTPdtCat2'],
            3 => $aPosSpcCatData['aItems']['FTPdtCat3'],
            4 => $aPosSpcCatData['aItems']['FTPdtCat4'],
            5 => $aPosSpcCatData['aItems']['FTPdtCat5']
        );

        $aCatNameInfo = array(
            1 => $aPosSpcCatData['aItems']['FTPdtCatName1'],
            2 => $aPosSpcCatData['aItems']['FTPdtCatName2'],
            3 => $aPosSpcCatData['aItems']['FTPdtCatName3'],
            4 => $aPosSpcCatData['aItems']['FTPdtCatName4'],
            5 => $aPosSpcCatData['aItems']['FTPdtCatName5']
        );

        $tRoute         	= "masPOSSpcCatEventEdit";

    }else{

        $nCatSeq            = 0;
        $tPgpCode           = "";
        $tPgpName           = "";
        $tPtyCode           = "";
        $tPtyName           = "";
        $tPbnCode           = "";
        $tPbnName           = "";
        $tPmoCode           = "";
        $tPmoName           = "";
        $tTcgCode           = "";
        $tTcgName           = "";

        $aCatCodeInfo = array(
            1 => "",
            2 => "",
            3 => "",
            4 => "",
            5 => ""
        );

        $aCatNameInfo = array(
            1 => "",
            2 => "",
            3 => "",
            4 => "",
            5 => ""
        );

        $tRoute            = "masPOSSpcCatEventAdd";
    }
?>

<form class="validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" id="ofmPosSpcCat">
    <button style="display:none" type="submit" id="obtPosSpcCatSubmit" onclick="JSxPSCEventAddEdit('<?=$tRoute;?>')"></button>
    <input type="hidden" id="ohdPSCCatSeq" name="ohdPSCCatSeq" value="<?=$nCatSeq?>">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-xs-5 col-sm-5">

                    <?php for($i=1;$i<=5;$i++){ ?>
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('pos/salemachine/salemachine', 'tTabPosSpcCat'.$i) ?></label>
                            <div class="input-group">
                                <input type="text" class="form-control xWCode xCNHide" id="oetPSCCatCode<?=$i?>" name="oetPSCCatCode<?=$i?>" value="<?=$aCatCodeInfo[$i];?>">
                                <input type="text" class="form-control xWName" id="oetPSCCatName<?=$i?>" name="oetPSCCatName<?=$i?>" value="<?=$aCatNameInfo[$i];?>" readonly>
                                <span class="input-group-btn">
                                    <button id="obtPSCBrowseCat<?=$i?>" type="button" class="btn xCNBtnBrowseAddOn xWClickBrowseCategory" data-code="oetPSCCatCode<?=$i?>" data-name="oetPSCCatName<?=$i?>" data-level="<?=$i?>">
                                        <img src="<?= base_url() . '/application/modules/common/assets/images/icons/find-24.png' ?>">
                                    </button>
                                </span>
                            </div>
                        </div>
                    <?php } ?>

                    <!-- กลุ่มสินค้า -->
                    <div class="form-group">
                        <label class="xCNLabelFrm"><?php echo language('pos/salemachine/salemachine', 'tTabPosSpcCatPdtGrp') ?></label>
                        <div class="input-group">
                            <input type="text" class="form-control xCNHide" id="oetPSCPgpCode" name="oetPSCPgpCode" value="<?=$tPgpCode;?>">
                            <input type="text" class="form-control" id="oetPSCPgpName" name="oetPSCPgpName" value="<?=$tPgpName;?>" readonly>
                            <span class="input-group-btn">
                                <button id="obtPSCBrowsePdtGrp" type="button" class="btn xCNBtnBrowseAddOn">
                                    <img src="<?= base_url() . '/application/modules/common/assets/images/icons/find-24.png' ?>">
                                </button>
                            </span>
                        </div>
                    </div>
                    <!-- กลุ่มสินค้า -->

                    <!-- ประเภทสินค้า -->
                    <div class="form-group">
                        <label class="xCNLabelFrm"><?php echo language('pos/salemachine/salemachine', 'tTabPosSpcCatPdtType') ?></label>
                        <div class="input-group">
                            <input type="text" class="form-control xCNHide" id="oetPSCPtyCode" name="oetPSCPtyCode" value="<?=$tPtyCode;?>">
                            <input type="text" class="form-control" id="oetPSCPtyName" name="oetPSCPtyName" value="<?=$tPtyName;?>" readonly>
                            <span class="input-group-btn">
                                <button id="obtPSCBrowsePdtType" type="button" class="btn xCNBtnBrowseAddOn">
                                    <img src="<?= base_url() . '/application/modules/common/assets/images/icons/find-24.png' ?>">
                                </button>
                            </span>
                        </div>
                    </div>
                    <!-- ประเภทสินค้า -->

                    <!-- ยี่ห้อ -->
                    <div class="form-group">
                        <label class="xCNLabelFrm"><?php echo language('pos/salemachine/salemachine', 'tTabPosSpcCatPdtBrand') ?></label>
                        <div class="input-group">
                            <input type="text" class="form-control xCNHide" id="oetPSCPbnCode" name="oetPSCPbnCode" value="<?=$tPbnCode;?>">
                            <input type="text" class="form-control" id="oetPSCPbnName" name="oetPSCPbnName" value="<?=$tPbnName;?>" readonly>
                            <span class="input-group-btn">
                                <button id="obtPSCBrowsePdtBrand" type="button" class="btn xCNBtnBrowseAddOn">
                                    <img src="<?= base_url() . '/application/modules/common/assets/images/icons/find-24.png' ?>">
                                </button>
                            </span>
                        </div>
                    </div>
                    <!-- ยี่ห้อ -->

                    <!-- รุ่น -->
                    <div class="form-group">
                        <label class="xCNLabelFrm"><?php echo language('pos/salemachine/salemachine', 'tTabPosSpcCatPdtModel') ?></label>
                        <div class="input-group">
                            <input type="text" class="form-control xCNHide" id="oetPSCPmoCode" name="oetPSCPmoCode" value="<?=$tPmoCode;?>">
                            <input type="text" class="form-control" id="oetPSCPmoName" name="oetPSCPmoName" value="<?=$tPmoName;?>" readonly>
                            <span class="input-group-btn">
                                <button id="obtPSCBrowsePdtModel" type="button" class="btn xCNBtnBrowseAddOn">
                                    <img src="<?= base_url() . '/application/modules/common/assets/images/icons/find-24.png' ?>">
                                </button>
                            </span>
                        </div>
                    </div>
                    <!-- รุ่น -->

                    <!-- กลุ่มสินค้าด่วน -->
                    <div class="form-group">
                        <label class="xCNLabelFrm"><?php echo language('pos/salemachine/salemachine', 'tTabPosSpcCatPdtTouchGrp') ?></label>
                        <div class="input-group">
                            <input type="text" class="form-control xCNHide" id="oetPSCTcgCode" name="oetPSCTcgCode" value="<?=$tTcgCode;?>">
                            <input type="text" class="form-control" id="oetPSCTcgName" name="oetPSCTcgName" value="<?=$tTcgName;?>" readonly>
                            <span class="input-group-btn">
                                <button id="obtPSCBrowsePdtTouchGrp" type="button" class="btn xCNBtnBrowseAddOn">
                                    <img src="<?= base_url() . '/application/modules/common/assets/images/icons/find-24.png' ?>">
                                </button>
                            </span>
                        </div>
                    </div>
                    <!-- กลุ่มสินค้าด่วน -->

                </div>
                <div class="col-xs-5 col-sm-5"></div>
            </div>
        </div>
    </div>  
</form>    
<script src="<?php echo base_url('application/modules/common/assets/js/jquery.mask.js')?>"></script>
<script src="<?php echo base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>

<script>
    $('.xWClickBrowseCategory').off('click').on('click',function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSxCheckPinMenuClose();
            var tCodeReturn = $(this).attr('data-code');
            var tNameReturn = $(this).attr('data-name');
            var tLevel = $(this).attr('data-level');
            window.oPSCBrowseCategoryOption  = oPSCBrowseCategory({
                'tReturnInputCode'  : tCodeReturn,
                'tReturnInputName'  : tNameReturn,
                'tLevel'            : tLevel
            });
            JCNxBrowseData('oPSCBrowseCategoryOption');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    // Option Category
    var oPSCBrowseCategory = function(poReturnInput){
        var tInputReturnCode    = poReturnInput.tReturnInputCode;
        var tInputReturnName    = poReturnInput.tReturnInputName;
        var tLevel              = poReturnInput.tLevel;
        var oOptionReturn       = {
            Title : ['product/pdtcat/pdtcat','tCATTitle'],
            Table : {Master:'TCNMPdtCatInfo',PK:'FTCatCode'},
            Join :{
                Table : ['TCNMPdtCatInfo_L'],
                On : ['TCNMPdtCatInfo_L.FTCatCode = TCNMPdtCatInfo.FTCatCode AND TCNMPdtCatInfo_L.FNCatLevel = TCNMPdtCatInfo.FNCatLevel AND TCNMPdtCatInfo_L.FNLngID = '+nLangEdits,]
            },
            Where   : {
                Condition : [" AND TCNMPdtCatInfo.FNCatLevel = '"+tLevel+"' AND TCNMPdtCatInfo.FTCatStaUse = '1' "]
            },
            GrideView:{
                ColumnPathLang      : 'product/pdtcat/pdtcat',
                ColumnKeyLang       : ['tCATTBCode','tCATTBName'],
                ColumnsSize         : ['15%','75%'],
                WidthModal          : 50,
                DataColumns         : ['TCNMPdtCatInfo.FTCatCode','TCNMPdtCatInfo_L.FTCatName'],
                DataColumnsFormat   : ['',''],
                Perpage             : 20,
                OrderBy             : ['TCNMPdtCatInfo.FDCreateOn DESC'],
            },
            CallBack:{
                ReturnType	: 'S',
                Value		: [tInputReturnCode,"TCNMPdtCatInfo.FTCatCode"],
                Text		: [tInputReturnName,"TCNMPdtCatInfo_L.FTCatName"],
            },
        }
        return oOptionReturn;
    };

    $('#obtPSCBrowsePdtGrp').off('click').on('click',function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSxCheckPinMenuClose();
            window.oPSCBrowsePdtGrpOption  = oPSCBrowsePdtGrp({
                'tReturnInputCode'  : 'oetPSCPgpCode',
                'tReturnInputName'  : 'oetPSCPgpName'
            });
            JCNxBrowseData('oPSCBrowsePdtGrpOption');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    var oPSCBrowsePdtGrp = function(poReturnInput){
        var tInputReturnCode    = poReturnInput.tReturnInputCode;
        var tInputReturnName    = poReturnInput.tReturnInputName;
        var oOptionReturn       = {
            Title : ['product/pdtgroup/pdtgroup','tPGPTitle'],
            Table : {Master:'TCNMPdtGrp',PK:'FTPgpChain'},
            Join :{
                Table : ['TCNMPdtGrp_L'],
                On : ['TCNMPdtGrp_L.FTPgpChain = TCNMPdtGrp.FTPgpChain AND TCNMPdtGrp_L.FNLngID = '+nLangEdits,]
            },
            GrideView:{
                ColumnPathLang      : 'product/pdtgroup/pdtgroup',
                ColumnKeyLang       : ['tPGPChainCode','tPGPChain'],
                ColumnsSize         : ['15%','75%'],
                WidthModal          : 50,
                DataColumns         : ['TCNMPdtGrp.FTPgpChain','TCNMPdtGrp_L.FTPgpName'],
                DataColumnsFormat   : ['',''],
                Perpage             : 20,
                OrderBy             : ['TCNMPdtGrp.FDCreateOn DESC'],
            },
            CallBack:{
                ReturnType	: 'S',
                Value		: [tInputReturnCode,"TCNMPdtGrp.FTPgpChain"],
                Text		: [tInputReturnName,"TCNMPdtGrp_L.FTPgpName"],
            },
        }
        return oOptionReturn;
    };

    $('#obtPSCBrowsePdtType').off('click').on('click',function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSxCheckPinMenuClose();
            window.oPSCBrowsePdtTypeOption  = oPSCBrowsePdtType({
                'tReturnInputCode'  : 'oetPSCPtyCode',
                'tReturnInputName'  : 'oetPSCPtyName'
            });
            JCNxBrowseData('oPSCBrowsePdtTypeOption');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    var oPSCBrowsePdtType = function(poReturnInput){
        var tInputReturnCode    = poReturnInput.tReturnInputCode;
        var tInputReturnName    = poReturnInput.tReturnInputName;
        var oOptionReturn       = {
            Title : ['product/pdttype/pdttype','tPTYTitle'],
            Table : {Master:'TCNMPdtType',PK:'FTPtyCode'},
            Join :{
                Table : ['TCNMPdtType_L'],
                On : ['TCNMPdtType_L.FTPtyCode = TCNMPdtType.FTPtyCode AND TCNMPdtType_L.FNLngID = '+nLangEdits,]
            },
            GrideView:{
                ColumnPathLang      : 'product/pdttype/pdttype',
                ColumnKeyLang       : ['tPTYTBCode','tPTYTBName'],
                ColumnsSize         : ['15%','75%'],
                WidthModal          : 50,
                DataColumns         : ['TCNMPdtType.FTPtyCode','TCNMPdtType_L.FTPtyName'],
                DataColumnsFormat   : ['',''],
                Perpage             : 20,
                OrderBy             : ['TCNMPdtType.FDCreateOn DESC'],
            },
            CallBack:{
                ReturnType	: 'S',
                Value		: [tInputReturnCode,"TCNMPdtType.FTPtyCode"],
                Text		: [tInputReturnName,"TCNMPdtType_L.FTPtyName"],
            },
        }
        return oOptionReturn;
    };

    $('#obtPSCBrowsePdtBrand').off('click').on('click',function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSxCheckPinMenuClose();
            window.oPSCBrowsePdtBrandOption  = oPSCBrowsePdtBrand({
                'tReturnInputCode'  : 'oetPSCPbnCode',
                'tReturnInputName'  : 'oetPSCPbnName'
            });
            JCNxBrowseData('oPSCBrowsePdtBrandOption');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    var oPSCBrowsePdtBrand = function(poReturnInput){
        var tInputReturnCode    = poReturnInput.tReturnInputCode;
        var tInputReturnName    = poReturnInput.tReturnInputName;
        var oOptionReturn       = {
            Title : ['product/pdtbrand/pdtbrand','tPBNTitle'],
            Table : {Master:'TCNMPdtBrand',PK:'FTPbnCode'},
            Join :{
                Table : ['TCNMPdtBrand_L'],
                On : ['TCNMPdtBrand_L.FTPbnCode = TCNMPdtBrand.FTPbnCode AND TCNMPdtBrand_L.FNLngID = '+nLangEdits,]
            },
            GrideView:{
                ColumnPathLang      : 'product/pdtbrand/pdtbrand',
                ColumnKeyLang       : ['tPBNCode','tPBNName'],
                ColumnsSize         : ['15%','75%'],
                WidthModal          : 50,
                DataColumns         : ['TCNMPdtBrand.FTPbnCode','TCNMPdtBrand_L.FTPbnName'],
                DataColumnsFormat   : ['',''],
                Perpage             : 20,
                OrderBy             : ['TCNMPdtBrand.FDCreateOn DESC'],
            },
            CallBack:{
                ReturnType	: 'S',
                Value		: [tInputReturnCode,"TCNMPdtBrand.FTPbnCode"],
                Text		: [tInputReturnName,"TCNMPdtBrand_L.FTPbnName"],
            },
        }
        return oOptionReturn;
    };

    $('#obtPSCBrowsePdtModel').off('click').on('click',function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSxCheckPinMenuClose();
            window.oPSCBrowsePdtModelOption  = oPSCBrowsePdtModel({
                'tReturnInputCode'  : 'oetPSCPmoCode',
                'tReturnInputName'  : 'oetPSCPmoName'
            });
            JCNxBrowseData('oPSCBrowsePdtModelOption');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    var oPSCBrowsePdtModel = function(poReturnInput){
        var tInputReturnCode    = poReturnInput.tReturnInputCode;
        var tInputReturnName    = poReturnInput.tReturnInputName;
        var oOptionReturn       = {
            Title : ['product/pdtmodel/pdtmodel','tPMOTitle'],
            Table : {Master:'TCNMPdtModel',PK:'FTPmoCode'},
            Join :{
                Table : ['TCNMPdtModel_L'],
                On : ['TCNMPdtModel_L.FTPmoCode = TCNMPdtModel.FTPmoCode AND TCNMPdtModel_L.FNLngID = '+nLangEdits,]
            },
            GrideView:{
                ColumnPathLang      : 'product/pdtmodel/pdtmodel',
                ColumnKeyLang       : ['tPMOCode','tPMOName'],
                ColumnsSize         : ['15%','75%'],
                WidthModal          : 50,
                DataColumns         : ['TCNMPdtModel.FTPmoCode','TCNMPdtModel_L.FTPmoName'],
                DataColumnsFormat   : ['',''],
                Perpage             : 20,
                OrderBy             : ['TCNMPdtModel.FDCreateOn DESC'],
            },
            CallBack:{
                ReturnType	: 'S',
                Value		: [tInputReturnCode,"TCNMPdtModel.FTPmoCode"],
                Text		: [tInputReturnName,"TCNMPdtModel_L.FTPmoName"],
            },
        }
        return oOptionReturn;
    };

    $('#obtPSCBrowsePdtTouchGrp').off('click').on('click',function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSxCheckPinMenuClose();
            window.oPSCBrowsePdtTouchGrpOption  = oPSCBrowsePdtTouchGrp({
                'tReturnInputCode'  : 'oetPSCTcgCode',
                'tReturnInputName'  : 'oetPSCTcgName'
            });
            JCNxBrowseData('oPSCBrowsePdtTouchGrpOption');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });
    
    var oPSCBrowsePdtTouchGrp = function(poReturnInput){
        var tInputReturnCode    = poReturnInput.tReturnInputCode;
        var tInputReturnName    = poReturnInput.tReturnInputName;
        var oOptionReturn       = {
            Title : ['product/pdttouchgroup/pdttouchgroup','tTCGTitle'],
            Table : {Master:'TCNMPdtTouchGrp',PK:'FTTcgCode'},
            Join :{
                Table : ['TCNMPdtTouchGrp_L'],
                On : ['TCNMPdtTouchGrp_L.FTTcgCode = TCNMPdtTouchGrp.FTTcgCode AND TCNMPdtTouchGrp_L.FNLngID = '+nLangEdits,]
            },
            Where   : {
                Condition : [" AND TCNMPdtTouchGrp.FTTcgStaUse = '1' "]
            },
            GrideView:{
                ColumnPathLang      : 'product/pdttouchgroup/pdttouchgroup',
                ColumnKeyLang       : ['tTCGCode','tTCGName'],
                ColumnsSize         : ['15%','75%'],
                WidthModal          : 50,
                DataColumns         : ['TCNMPdtTouchGrp.FTTcgCode','TCNMPdtTouchGrp_L.FTTcgName'],
                DataColumnsFormat   : ['',''],
                Perpage             : 20,
                OrderBy             : ['TCNMPdtTouchGrp.FDCreateOn DESC'],
            },
            CallBack:{
                ReturnType	: 'S',
                Value		: [tInputReturnCode,"TCNMPdtTouchGrp.FTTcgCode"],
                Text		: [tInputReturnName,"TCNMPdtTouchGrp_L.FTTcgName"],
            },
        }
        return oOptionReturn;
    };

    // Create By : Napat(Jame) 06/05/2022
    function JSxPSCEventAddEdit(ptRoute){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){

            var tCat1 = $('#oetPSCCatCode1').val();
            var tCat2 = $('#oetPSCCatCode2').val();
            var tCat3 = $('#oetPSCCatCode3').val();
            var tCat4 = $('#oetPSCCatCode4').val();
            var tCat5 = $('#oetPSCCatCode5').val();
            var tPgp  = $('#oetPSCPgpCode').val();
            var tPty  = $('#oetPSCPtyCode').val();
            var tPbn  = $('#oetPSCPbnCode').val();
            var tPmo  = $('#oetPSCPmoCode').val();
            var tTcg  = $('#oetPSCTcgCode').val();

            if(tCat1==''&&tCat2==''&&tCat3==''&&tCat4==''&&tCat5==''&&tPgp==''&&tPty==''&&tPbn==''&&tPmo==''&&tTcg==''){
                FSvCMNSetMsgWarningDialog('กรุณาเลือกอย่างน้อย 1 รายการ');
                return false;
            }
            
            var tBchCode    = $('#ohdBchCode').val();
            var tShpCode    = $('#ohdShpCode').val();
            var tPosCode    = $('#oetPosCode').val();

            var tPackData = '&tBchCode='+tBchCode+'&tShpCode='+tShpCode+'&tPosCode='+tPosCode;

            JCNxOpenLoading();
            $.ajax({
                type    : "POST",
                url     : ptRoute,
                data    : $('#ofmPosSpcCat').serialize() + tPackData,
                cache	: false,
                timeout	: 0,
                success	: function(oResult){
                    var aReturn = JSON.parse(oResult);
                    // console.log(aReturn);
                    if( aReturn['nStaEvent'] == '1' ){
                        JSxPosSpcCatDataList();
                    }else{
                        FSvCMNSetMsgWarningDialog(aReturn['tStaMessg']);
                        JCNxCloseLoading();
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }else{
            JCNxShowMsgSessionExpired();
        }
    }

</script>