<div class="text-right">
    <button id="obtPdtStockConditionsAdd" class="xCNBTNPrimeryPlus" style="margin-bottom:5px;" type="button" onclick="JSvPdtStockConditionsPageAdd()">+</button>
</div>
<table class="table xWTableListdataSpcWah" id="otbTableListdataSpcWah">
    <thead>
        <tr>

            <th nowrap="" class="text-center xCNTextBold" style="width:10%;"><?php echo language('product/product/product','tPdtStockConditionsBch')?></th>
            <th nowrap="" class="text-center xCNTextBold" style="width:10%;"><?php echo language('product/product/product','tPdtStockConditionsWah')?></th>
            <th nowrap="" class="text-center xCNTextBold" style="width:10%;"><?php echo language('product/product/product','tPdtStockConditionsMin')?></th>
            <th nowrap="" class="text-center xCNTextBold" style="width:10%;"><?php echo language('product/product/product','tPdtStockConditionsMax')?></th>
            <th nowrap="" class="text-center xCNTextBold" style="width:5%;"><?php echo language('product/product/product','tPdtStockConditionsDel')?></th>
            <th nowrap="" class="text-center xCNTextBold" style="width:5%;"><?php echo language('product/product/product','tPdtStockConditionsEdit')?></th>
                        
        </tr>   
</thead>
<tbody>
<?php if($rtCode == 1 ):?>
    <?php foreach($raItems AS $aValue){ ?>
        <tr>

           <td class="text-left"><?php echo $aValue['FTBchName'];?></td>
           <td class="text-left"><?php echo $aValue['FTWahName'];?></td>
           <td class="text-right"><?php echo $aValue['FCSpwQtyMin'];?></td>
           <td class="text-right"><?php echo $aValue['FCSpwQtyMax'];?></td>
           <td class="text-center"><img class="xCNIconTable" src="<?= base_url().'/application/modules/common/assets/images/icons/delete.png'?>" onClick="JSoPdtStockConditionsDelete('<?php echo $aValue['FTPdtCode'];?>','<?php echo $aValue['FTBchCode'];?>','<?php echo $aValue['FTWahCode'];?>','<?php echo $aValue['FTBchName']; ?>');"></td>
           <td class="text-center"><img class="xCNIconTable" src="<?= base_url().'/application/modules/common/assets/images/icons/edit.png'?>" onClick="JSvPdtStockConditionsPageEdit('<?php echo $aValue['FTPdtCode'];?>','<?php echo $aValue['FTBchCode'];?>','<?php echo $aValue['FTWahCode'];?>')"></td>

        </tr>   
    <?php } ?>
    <?php else:?>
        <tr><td class='text-center xCNTextDetail2' colspan='6'><?= language('common/main/main','tCMNNotFoundData')?></td></tr>
    <?php endif;?>
</tbody>
</table>


<div class="modal fade" id="odvModalStockConditions">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header xCNModalHead">
                <label class="xCNTextModalHeard"><?php echo language('product/product/product', 'tPdtStockConditions'); ?></label>
            </div>
            <div class="modal-body">
            <form class="validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" id="ofmAddStockConditions">
            <input type="text" class="form-control xCNHide" id="oetStockConditionPdtCode" name="oetStockConditionPdtCode">
            <input type="text" class="form-control xCNHide" id="oetStockConditionBchCodeOld" name="oetStockConditionBchCodeOld">
            <input type="text" class="form-control xCNHide" id="oetStockConditionWahCodeOld" name="oetStockConditionWahCodeOld">
            <input type="text" class="form-control xCNHide" id="oetStockConditionRoute" name="oetStockConditionRoute">
                <div class="text-right">
                    <button type="button" class="btn" style="background-color: #D4D4D4; color: #000000;" data-dismiss="modal">
                        <?php echo language('product/product/product', 'tPdtStockConditionsCancel')?>
                    </button>
                    <button type="submit" class="btn" style="background-color: rgb(23, 155, 253); color: white;"  onclick="JSvPdtStockConditionsEventAddEdit()"> 
                        <?php echo  language('product/product/product', 'tPdtStockConditionsSave')?>
                    </button>
                </div>

                    <!-- Berowse Branch -->
                    <div class="form-group">
                        <label class="xCNLabelFrm"><span class="text-danger">*</span><?php echo language('product/product/product','tPdtStockConditionsBch')?></label>
                            <div class="input-group">
                                <input type="text" class="form-control xCNHide" id="oetStockConditionBchCode" name="oetStockConditionBchCode"  value="<?=$_SESSION['tSesUsrBchCodeDefault']?>" >
                                <input type="text" class="form-control xWPointerEventNone" id="oetStockConditionhBchName" name="oetStockConditionhBchName" value="<?=$_SESSION['tSesUsrBchNameDefault']?>"
                                data-validate-required="<?php echo language('product/product/product','tPdtStockConditionsValidBch');?>" readonly>
                            <span class="input-group-btn">
                                <button id="oimPscBrowseBch" type="button" class="btn xCNBtnBrowseAddOn">
                                    <img src="<?php echo  base_url().'/application/modules/common/assets/images/icons/find-24.png'?>">
                                </button>
                            </span>
                        </div>
                    </div>
                    <!-- end Berowse Branch -->

                    <!-- Berowse warehouse -->
                    <div class="form-group">
                        <label class="xCNLabelFrm"><span class="text-danger">*</span><?php echo language('product/product/product','tPdtStockConditionsWah')?></label>
                            <div class="input-group">
                                <input type="text" class="form-control xCNHide" id="oetStockConditionWahCode" name="oetStockConditionWahCode" >
                                <input type="text" class="form-control xWPointerEventNone" id="oetStockConditionhWahName" name="oetStockConditionhWahName"
                                data-validate-required="<?php echo language('product/product/product','tPdtStockConditionsValidWah');?>" readonly>
                            <span class="input-group-btn">
                                <button id="oimPscBrowseWah" type="button" class="btn xCNBtnBrowseAddOn">
                                    <img src="<?php echo  base_url().'/application/modules/common/assets/images/icons/find-24.png'?>">
                                </button>
                            </span>
                        </div>
                    </div>
                    <!-- end Berowse warehouse -->
                    
                    <!-- จำนวนต่ำสุด -->
                    <div class="row">
                        <div class="col-xs-4 col-md-4">
                            <div class="form-group">
                                <label class="xCNLabelFrm"><span class="text-danger">*</span><?php echo language('product/product/product','tPdtStockConditionsMin')?></label>
                                <input type="text" class="form-control text-right xCNInputNumericWithDecimal" id="oetStockConditionsMin" name="oetStockConditionsMin" maxlength="13" 
                                data-validate-required="<?php echo language('product/product/product','tPdtStockConditionsValidMin');?>"
                                >
                            </div>
                        </div>
                    </div>
                    <!-- end จำนวนต่ำสุด -->

                    <!-- จำนวนสูงสุด -->
                    <div class="row">
                        <div class="col-xs-4 col-md-4">
                            <div class="form-group">
                                <label class="xCNLabelFrm"><span class="text-danger">*</span><?php echo language('product/product/product','tPdtStockConditionsMax')?></label>
                                <input type="text" class="form-control text-right xCNInputNumericWithDecimal" id="oetStockConditionsMax" name="oetStockConditionsMax" maxlength="13"
                                data-validate-required="<?php echo language('product/product/product','tPdtStockConditionsValidMax');?>"
                                >
                            </div>
                        </div>
                    </div>
                    <!-- end จำนวนสูงสุด -->
                    
                    <!-- เหตุผล -->
                    <div class="form-group">
                        <label class="xCNLabelFrm"><?php echo language('product/product/product','tPdtStockConditionsRemark')?></label>
                        <textarea class="form-control" name="oetStockConditionsRemark" id="oetStockConditionsRemark" rows="3"></textarea>
					</div>
                    <!-- end เหตุผล -->
                </form>
            </div>
        </div>
    </div>
</div>

<div id="odvModalDeleteStockConditions" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header xCNModalHead">
                <label class="xCNTextModalHeard"><?php echo language('common/main/main', 'tModalDelete')?></label>
            </div>
            <div class="modal-body">
                <span id="ospTextConfirmDelSingle" class="xCNTextModal" style="display: inline-block; word-break:break-all"></span>
            </div>
            <div class="modal-footer">
                <button id="osmConfirmDelSingle" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" type="button"><?php echo language('common/main/main', 'tModalConfirm')?></button>
                <button class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"  data-dismiss="modal"><?php echo language('common/main/main', 'tModalCancel')?></button>
            </div>
        </div>
    </div>
</div>

<div id="odvModalStockConditionsAlert" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" style="margin-top:10%;">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <label class="xCNTextModalHeard  text-center"><?php echo language('product/product/product', 'tPdtStockConditionswarning')?></label>
        </div>
        <div class="modal-body">
            <div style="margin-top:10px;margin-bottom:10px;">
                <label><?php echo language('product/product/product', 'tPdtStockConditionswarningBch')?></label>
            </div>
        
            <div class="text-center" style="margin-top:10px;margin-bottom:10px;">
                <button  type="button" class="btn" style="background-color: #D4D4D4; color: #000000;" data-dismiss="modal"><?php echo language('common/main/main', 'tModalCancel')?></button>
            </div>

            </div>
        </div>
    </div>
</div>

<script>
        // Berowse
        $('#oimPscBrowseBch').click(function(){JCNxBrowseData('oBrowseBch')});
        $('#oimPscBrowseWah').click(function(){

            
                    JSxCheckPinMenuClose();
        
            var StockConditionBchCode = $('#oetStockConditionBchCode').val();
            window.oBrowseWahOption   = undefined;
            oBrowseWahOption          = oBrowseWah({
                'tStockConditionBchCode'  : StockConditionBchCode
            });
            JCNxBrowseData('oBrowseWahOption');
            
            // JCNxBrowseData('oBrowseWah')
        });

        JSxPscSetConditionWah();

        // Option Branch
    var oBrowseBch = {
        
        Title : ['company/branch/branch','tBCHTitle'],
        Table:{Master:'TCNMBranch',PK:'FTBchCode',PKName:'FTBchName'},
        Join :{
            Table:	['TCNMBranch_L'],
            On:['TCNMBranch_L.FTBchCode = TCNMBranch.FTBchCode AND TCNMBranch_L.FNLngID = '+nLangEdits,]
        },
        GrideView:{
            ColumnPathLang	: 'company/branch/branch',
            ColumnKeyLang	: ['tBCHCode','tBCHName'],
            ColumnsSize     : ['15%','75%'],
            WidthModal      : 50,
            DataColumns		: ['TCNMBranch.FTBchCode','TCNMBranch_L.FTBchName'],
            DataColumnsFormat : ['',''],
            Perpage			: 10,
            OrderBy			: ['TCNMBranch.FDCreateOn DESC'],
            // SourceOrder		: "ASC"
        },
        NextFunc : {
                    FuncName  : 'JSxPscSetConditionWah'
                },
        CallBack:{
            ReturnType	: 'S',
            Value		: ["oetStockConditionBchCode","TCNMBranch.FTBchCode"],
            Text		: ["oetStockConditionhBchName","TCNMBranch_L.FTBchName"],
        },
        RouteAddNew : 'branch',
        BrowseLev : 1

    }


    function JSxPscSetConditionWah(){
        
      var StockConditionBchCode = $('#oetStockConditionBchCode').val();

            if(StockConditionBchCode==''){
                 $('#oimPscBrowseWah').attr('disabled',true);
            }else{
                $('#oimPscBrowseWah').attr('disabled',false);
            }
    }
    // Option Wah

    var oBrowseWah    = function(poDataFnc){
        var tStockConditionBchCode    = poDataFnc.tStockConditionBchCode;
     
    var oOptionReturn = {
        Title : ['company/warehouse/warehouse','tWAHTitle'],
        Table:{Master:'TCNMWaHouse',PK:'FTWahCode'},
        Join :{
            Table:	['TCNMWaHouse_L'],
            On:['TCNMWaHouse_L.FTWahCode = TCNMWaHouse.FTWahCode AND TCNMWaHouse_L.FTBchCode = TCNMWaHouse.FTBchCode  AND TCNMWaHouse_L.FNLngID = '+nLangEdits,]
        },
        Where   : {
            Condition : [" AND TCNMWaHouse.FTBchCode = '"+tStockConditionBchCode+"' "]
        },
        GrideView:{
            ColumnPathLang	: 'company/warehouse/warehouse',
            ColumnKeyLang	: ['tWahCode','tWahName'],
            ColumnsSize     : ['15%','75%'],
            WidthModal      : 50,
            DataColumns		: ['TCNMWaHouse.FTWahCode','TCNMWaHouse_L.FTWahName'],
            DataColumnsFormat : ['',''],
            Perpage			: 10,
            OrderBy			: ['TCNMWaHouse.FDCreateOn DESC'],
            // SourceOrder		: "ASC"
        },
        CallBack:{
            ReturnType	: 'S',
            Value		: ["oetStockConditionWahCode","TCNMWaHouse.FTWahCode"],
            Text		: ["oetStockConditionhWahName","TCNMWaHouse_L.FTWahName"],
        },
        RouteAddNew : 'warehouse',
        BrowseLev : 1
    }
    return oOptionReturn;
    }

</script>

