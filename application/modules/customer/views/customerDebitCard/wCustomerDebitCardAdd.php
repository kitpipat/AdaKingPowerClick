<?php
   if($aResult['rtCode'] == 1){

        $tCstDisabled = "";
        $tRoute      = "DebitCardEventEdit";
    }else{
    
        $tCstDisabled = "Disabled";
        $tRoute      = "DebitCardEventAdd";
   }
    
?>

<form class="validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" id="ofmAddEditCustomerDebitCard">
    <input type="hidden" id="ohdTRoute" value="<?php echo $tRoute;?>">

    <div class="row">
        <!--ปุ่มเพิ่ม-->
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12  text-right">
            <button type="button" onclick="JSvCustomerDebitCardList();" class="btn" style="background-color: #D4D4D4; color: #000000;">
                <?php echo language('common/main/main', 'tCancel')?>
            </button>
            <input id="ohdTypeCstDebitCardData" type="hidden" value="normal" >
            <button type="submit" class="btn" style="background-color: rgb(23, 155, 253); color: white;" onclick="JSxCstDebitCardSaveAddEdit('<?=$tRoute?>')"> <?php echo  language('common/main/main', 'tSave')?></button>
        </div>
    
        <!-- ประเภทบัตร -->
        <div class="col-xl-5 col-lg-5 col-md-5">
            <div class="form-group">
                <label class="xCNLabelFrm"><?php echo language('customer/customer/customer','tCstDebitCardType')?></label>
                <div class="input-group">
                    <input type="text" class="form-control xCNHide" id="oetCstCrdCtyCode" name="oetCstCrdCtyCode" value="<?php echo @$tCrdCtyCode; ?>" data-validate="<?php echo  language('payment/card/card','tCRDValidCardTypeCode');?>">
                    <input 
                        type="text" 
                        class="form-control xCNInputWithoutSpcNotThai" id="oetCstCrdCtyName" name="oetCstCrdCtyName" value="<?php echo @$tCrdCtyName ?>" data-validate="<?php echo  language('payment/card/card','tCRDValidCardTypeName');?>" readonly>
                    <span class="input-group-btn">
                        <button id="obtBrowseCardType" type="button" class="btn xCNBtnBrowseAddOn">
                            <img src="<?php echo base_url().'/application/modules/common/assets/images/icons/find-24.png'?>">
                        </button>
                    </span>
                </div>
            </div>
        </div>
        <input type="hidden" id="ohdCstCardType" >


        <!-- บัตรริส-แบน -->
        <div class="col-xl-5 col-lg-5 col-md-5">
            <div class="form-group">
                <label class="xCNLabelFrm"><?php echo language('customer/customer/customer','tCstDebitCardCode')?></label>
                <div class="input-group">
                    <input type="text" class="form-control xCNHide" id="oetCstCrdCode" name="oetCstCrdCode" value="<?php echo @$tCstCrdCode; ?>" data-validate="<?php echo  language('payment/card/card','tCRDValidCardTypeCode');?>">
                    <input type="text" class="form-control xCNInputWithoutSpcNotThai" id="oetCstCrdName" name="oetCstCrdName" value="<?php echo @$tCstCrdName ?>" data-validate="<?php echo  language('payment/card/card','tCRDValidCardName');?>" readonly>
                    <span class="input-group-btn">
                        <button id="obtBrowseCardCode" type="button" <?php echo $tCstDisabled;?> class="btn xCNBtnBrowseAddOn">
                            <img src="<?php echo base_url().'/application/modules/common/assets/images/icons/find-24.png'?>">
                        </button>
                    </span>
                </div>
            </div>
        </div>
    </div>
    <?php
      $tCstCode  =  $aCustomerDebitCard['tCstCode']; 
    ?>
    <input type="hidden" id="ohdCstCode" name="ohdCstCode" value="<?php echo $tCstCode;?>">
    <input type="hidden" id="ohdValidateDuplicate" name="ohdValidateDuplicate" value="0"><!-- 0 คือ ไม่เกิด validate  และ 1 เกิด validate -->
</form>
<script src="<?php echo base_url('application/modules/common/assets/js/jquery.mask.js')?>"></script>
<script src="<?php echo base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>

<script type="text/javascript">
    // Browse CardType
    $('#obtBrowseCardType').click(function(){
        oOptionReturnCardType = oCrdBrwCardType();
        JCNxBrowseData('oOptionReturnCardType');
    });

    // Browse Card
    $('#obtBrowseCardCode').click(function(){
        // window.oASTBrowseShopOption = undefined;
        oCrdBrwCardCodeOption     = oCrdBrwCardCode({
            'tHiddenTypeCard'       : $('#ohdCstCardType').val()
        });
        JCNxBrowseData('oCrdBrwCardCodeOption');        
    });

    //Browse Card Type
    var oCrdBrwCardType = function(){
        var tCondition = '';
        var tStaUsrLevel = '<?= $this->session->userdata("tSesUsrLevel"); ?>';
        var tAgnCode  = '<?= $this->session->userdata("tSesUsrAgnCode") ?>';
        if(tStaUsrLevel != 'HQ'){
            if( tAgnCode != ''  && tAgnCode != undefined){
                tCondition += " AND TFNMCardType.FTAgnCode = '"+tAgnCode+"' OR ISNULL(TFNMCardType.FTAgnCode,'') ='' ";
            }		
        }
        var oCrdBrwCardTypeReturn = {
            Title : ['payment/cardtype/cardtype','tCTYTitle'],
            Table:{Master:'TFNMCardType',PK:'FTCtyCode'},
            Join :{
                Table:	['TFNMCardType_L'],
                On:['TFNMCardType_L.FTCtyCode = TFNMCardType.FTCtyCode AND TFNMCardType_L.FNLngID = '+nLangEdits,]
            },
            Where :{
			    Condition : [tCondition]
		    },
            GrideView:{
                ColumnPathLang	: 'payment/cardtype/cardtype',
                ColumnKeyLang	: ['tCTYCode','tCTYName','tCRDFrmCrdDeposit'],
                DataColumns		: ['TFNMCardType.FTCtyCode','TFNMCardType_L.FTCtyName','TFNMCardType.FCCtyDeposit'],
                DisabledColumns : [2],
                Perpage			: 10,
                OrderBy			: ['TFNMCardType.FDCreateOn DESC'],
            },
            CallBack:{
                ReturnType	: 'S',
                Value		: ["oetCstCrdCtyCode","TFNMCardType.FTCtyCode"],
                Text		: ["oetCstCrdCtyName","TFNMCardType_L.FTCtyName"],
            },
            NextFunc:{
                FuncName:'JSxNextFuncCstCrdType',
                ArgReturn:['FTCtyCode']
            },
            RouteAddNew : 'cardtype',
            // BrowseLev : nStaCrdBrowseType
        }
        return oCrdBrwCardTypeReturn;
    }


    function JSxNextFuncCstCrdType(paDataReturn){
        // tCstDebitCardType = '';
        var aCstCardType = JSON.parse(paDataReturn);
        $("#obtBrowseCardCode").attr("disabled",false);
        $('#ohdCstCardType').val(aCstCardType[0]);

        $('#oetCstCrdCode').val('');
        $('#oetCstCrdName').val('');
        // console.log($('#ohdCstCardType').val());
    }

    //Browse Card
    var oCrdBrwCardCode      = function(poDataFnc){
        var tWhereModal         = poDataFnc.tHiddenTypeCard;
        var tCondition = '';
        var tStaUsrLevel = '<?= $this->session->userdata("tSesUsrLevel"); ?>';
        var tAgnCode  = '<?= $this->session->userdata("tSesUsrAgnCode") ?>';
        if(tStaUsrLevel != 'HQ'){
            if( tAgnCode != ''  && tAgnCode != undefined){
                tCondition += " AND TFNMCard.FTAgnCode = '"+tAgnCode+"' OR ISNULL(TFNMCard.FTAgnCode,'') ='' ";
            }		
        }

        var oOptionReturn       = {
            Title : ['payment/card/card','tCRDTitle'],
            Table:{Master:'TFNMCard',PK:'FTCrdCode'},
            Join :{
                Table:	['TFNMCard_L'],
                On:['TFNMCard_L.FTCrdCode = TFNMCard.FTCrdCode AND TFNMCard_L.FNLngID = '+nLangEdits +' LEFT JOIN TFNMCardMan ON TFNMCardMan.FTCrdCode = TFNMCard.FTCrdCode',]

            },
            Where: {
                    Condition: ['AND TFNMCardMan.FTCrdCode IS NULL AND FTCtyCode = '+tWhereModal+tCondition]
                },
            GrideView:{
                ColumnPathLang	: 'payment/card/card',
                ColumnKeyLang	: ['tCRDTBCode','tCRDTBName','tCRDFrmCrdDeposit'],
                DataColumns		: ['TFNMCard.FTCrdCode','TFNMCard_L.FTCrdName'],
                DisabledColumns : [2],
                Perpage			: 10,
                OrderBy			: ['TFNMCard.FDCreateOn DESC'],
            },
            CallBack:{
                ReturnType	: 'S',
                Value		: ["oetCstCrdCode","TFNMCard.FTCrdCode"],
                Text		: ["oetCstCrdName","TFNMCard_L.FTCrdName"],
            },
            RouteAddNew : 'cardtype',
            // DebugSQL : true
        };
        return oOptionReturn; 
    }

</script> 
