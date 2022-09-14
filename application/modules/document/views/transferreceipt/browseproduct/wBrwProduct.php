            <style>
				.xCNTbodyodd > .panel-heading{
					background : #f5f5f5 !important;
				}

				.xCNTbodyeven > .panel-heading{
					background : #FFF !important;
				}

				#otbBrowserListPDT .xCNActivePDT > td{
					background-color: #179bfd !important;
					color : #FFF !important;
				}

				.xCNPDT{
					margin-bottom   : 5px;
				}
			</style>

			<!-- element name and value -->
			<input type="hidden" name="odhEleNamePDT" id="odhEleNamePDT" value="">
			<input type="hidden" name="odhEleValuePDT" id="odhEleValuePDT" value="">
			<input type="hidden" name="odhEleNameNextFunc" id="odhEleNameNextFunc" value="<?= $tNextFunc ?>">
			<input type="hidden" name="odhEleReturnType" id="odhEleReturnType" value="M">
			<input type="hidden" name="odhSelectTier" id="odhEleSelectTier" value="Barcode">
			<input type="hidden" name="odhTimeStorage" id="odhTimeStorage" value="">

            <!-- Element จากหน้า Add ที่ส่งมาใช้ในการ Waere Modal -->
            <input type="hidden" id="ohdBrowseTXIPDTBchCode" value="<?= $nFromToBCH ?>">
            <input type="hidden" id="ohdBrowseTXIRefInt" value="<?= $tRefInt ?>">

			<div class="row">
				<!--layout search-->
				<div id="odvPanalSearchTXIPDT" class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                    <!--header tab-->
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="custom-tabs-line tabs-line-bottom left-aligned">
                                <ul class="nav" role="tablist">
                                    <!--ทั่วไป-->
                                    <li id="oliBrowsePDTDetail" class="xWMenu active">
                                        <a role="tab" data-toggle="tab" data-target="#odvBrowsePDTDetail" aria-expanded="true"><?= language('common/main/main','tCenterModalPDTGeneral')?></a>
                                    </li>
                                    <!--สาขา-->
                                    <?php if(($nFromToBCH == '' || $nFromToBCH == null) || ($nFromToSHP == '' || $nFromToSHP == null)){ ?>
                                    <li id="oliBrowsePDTBranch" class="xWMenu xWSubTab">
                                        <a role="tab" data-toggle="tab" data-target="#odvBrowsePDTBranch" aria-expanded="false"><?= language('common/main/main','tCenterModalPDTBranch')?></a>
                                    </li>
                                    <?php } ?>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="tab-content">
                                <div id="odvBrowsePDTDetail" class="tab-pane fade active in">
                                    <?php //echo "nFromToBCH : ".$nFromToBCH; ?>
                                    <?php //echo "nFromToSHP : ".$nFromToSHP; ?>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group xCNPDT">
                                                <label class="xCNLabelFrm"><?= language('common/main/main','tCenterModalPDTNamePDT')?></label>
                                                <input class="form-control" type="text" id="oetBrowsePDTNamepdt" name="oetBrowsePDTNamepdt" value="" autocomplete="off" placeholder="Search">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group xCNPDT">
                                                <label class="xCNLabelFrm"><?= language('common/main/main','tCenterModalPDTCodePDT')?></label>
                                                <input class="form-control" type="text" id="oetBrowsePDTCodepdt" name="oetBrowsePDTCodepdt" value="" autocomplete="off" placeholder="Search">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group xCNPDT">
                                                <label class="xCNLabelFrm"><?= language('common/main/main','tCenterModalPDTBarcode')?></label>
                                                <input class="form-control" type="text" id="oetBrowsePDTBarCode" name="oetBrowsePDTBarCode" value="" autocomplete="off" placeholder="Search">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="odvBrowsePDTBranch" class="tab-pane fade">
                                    <?php if($nFromToBCH == ""){ ?>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-lg-6"> 
                                                    <div class="form-group xCNPDT">
                                                        <label class="xCNLabelFrm"><?= language('common/main/main','tCenterModalPDTBranch')?></label>
                                                        <div class="input-group">
                                                            <input class="form-control xCNHide" id="oetBrowsePDTCodebchfrom" name="oetBrowsePDTCodebchfrom" maxlength="5" value="">
                                                            <input class="form-control" type="text" id="oetBrowsePDTNamebchfrom" name="oetBrowsePDTNamebchfrom" value="" readonly="">
                                                            <span class="input-group-btn">
                                                                <button id="obtPDTbchBrowsefrom" type="button" class="btn xCNBtnBrowseAddOn">
                                                                    <img src='<?=base_url()?>/application/modules/common/assets/images/icons/find-24.png'>
                                                                </button>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6"> 
                                                    <div class="form-group xCNPDT">
                                                        <label class="xCNLabelFrm"><?= language('common/main/main','tCenterModalPDTBCHTo')?></label>
                                                        <div class="input-group">
                                                            <input class="form-control xCNHide" id="oetBrowsePDTCodebchto" name="oetBrowsePDTCodebchto" maxlength="5" value="">
                                                            <input class="form-control" type="text" id="oetBrowsePDTNamebchto" name="oetBrowsePDTNamebchto" value="" readonly="">
                                                            <span class="input-group-btn">
                                                                <button id="obtPDTbchBrowseto" type="button" class="btn xCNBtnBrowseAddOn">
                                                                    <img src='<?=base_url()?>/application/modules/common/assets/images/icons/find-24.png'>
                                                                </button>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php }else{ ?>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-lg-12"> 
                                                    <div class="form-group">
                                                        
                                                        <label class="xCNLabelFrm"><?= language('common/main/main','tCenterModalPDTBranch')?> : <?= $nFromToBCH ?> (<?= $nFromToBCHName ?>)</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php } ?>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class='form-group xCNPDT'>
                                                <label class='xCNLabelFrm'><?= language('common/main/main','tCenterModalPDTMerchant')?></label>
                                                <div class='input-group'>
                                                    <input class='form-control xCNHide' id='oetBrowsePDTCodeMerchant' name='oetBrowsePDTCodeMerchant' maxlength='5' value=''>
                                                    <input class='form-control' type='text' id='oetBrowsePDTNameMerchant' name='oetBrowsePDTNameMerchant' value='' readonly=''>
                                                    <span  class='input-group-btn'>
                                                        <button id='obtPDTMerchantBrowse' type='button' class='btn xCNBtnBrowseAddOn'>
                                                            <img src='<?=base_url()?>/application/modules/common/assets/images/icons/find-24.png'>
                                                        </button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    
                                    <?php if($nFromToSHP == ""){ ?>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-lg-6"> 
                                                    <div class="form-group xCNPDT">
                                                        <label class="xCNLabelFrm"><?= language('common/main/main','tCenterModalPDTShopFrom')?></label>
                                                        <div class="input-group">
                                                            <input class="form-control xCNHide" id="oetBrowsePDTCodeshpfrom" name="oetBrowsePDTCodeshpfrom" maxlength="5" value="">
                                                            <input class="form-control" type="text" id="oetBrowsePDTNameshpfrom" name="oetBrowsePDTNameshpfrom" value="" readonly="">
                                                            <span class="input-group-btn">
                                                                <button id="obtPDTshpBrowsefrom" type="button" class="btn xCNBtnBrowseAddOn">
                                                                    <img src='<?=base_url()?>/application/modules/common/assets/images/icons/find-24.png'>
                                                                </button>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6"> 
                                                    <div class="form-group xCNPDT">
                                                        <label class="xCNLabelFrm"><?= language('common/main/main','tCenterModalPDTShopTo')?></label>
                                                        <div class="input-group">
                                                            <input class="form-control xCNHide" id="oetBrowsePDTCodeshpto" name="oetBrowsePDTCodeshpto" maxlength="5" value="">
                                                            <input class="form-control" type="text" id="oetBrowsePDTNameshpto" name="oetBrowsePDTNameshpto" value="" readonly="">
                                                            <span class="input-group-btn">
                                                                <button id="obtPDTshpBrowseto" type="button" class="btn xCNBtnBrowseAddOn">
                                                                    <img src='<?=base_url()?>/application/modules/common/assets/images/icons/find-24.png'>
                                                                </button>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php } ?>
                                </div>

                                <!--BTN reset-->
                                <div class='col-md-6' style='float: left;'>
                                    <div class='form-group xCNPDT'>
                                        <div class='input-group' style='width: 100%;'>
                                            <button class='btn xCNBTNDefult' onclick='JSxTXIResetDataFrom()' style='width: 100%; border-radius: 0px !important; margin-top: 10px; float: right;'>ล้างข้อมูล</button>
                                        </div>
                                    </div>
                                </div>

                                <!--BTN search-->
                                <div class='col-md-6' style='float: left;'>
                                    <div class='form-group xCNPDT'>
                                        <div class='input-group' style='width: 100%;'>
                                            <button class='btn xCNBTNPrimery xCNBTNPrimery2Btn' onclick='JSxGetPDTTable()' style='width: 100%; border-radius: 0px !important; margin-top: 10px; float: right;'>กรองข้อมูล</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
				<!--end layout search-->

				<!--layout table-->
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-8">
					<div id="odvTableContentTXIPDT">
						<style>
							.xCNClickforModalPDT{
								cursor: pointer;
							}

							.xCNActivePDT > td{
								background-color: #179bfd !important;
								color : #FFF !important;
							}
						</style>
						<!--layout table-->
						<table id="otbBrowserListPDT" class="table table-striped" style="width:100%"></table>
						<!--end table-->
					</div>
				</div>
				<!--end layout table-->
			</div>

<script>

    //ONLOAD 
    JSxGetPDTTable(); /* GetData */

    function JSxGetPDTTable(pnPage){
        console.log('Function : JSxGetPDTTable');
        
        if(pnPage == '' || pnPage == null){ pnPage = 1; }else{ pnPage = pnPage; }
        
        $.ajax({
            type    : "POST",
            url     : "dcmTXIBrowseDataPDTTable",
            data    : {
                'nPage'         : pnPage,
                'nRow'          : '<?=$nShowCountRecord?>',
                'tNamePDT'      : $('#oetBrowsePDTNamepdt').val(),
                'tCodePDT'      : $('#oetBrowsePDTCodepdt').val(),
                'tBarcode'      : $('#oetBrowsePDTBarCode').val(),
                'tBCH'          : $('#ohdBrowseTXIPDTBchCode').val(),
                'tMerchant'     : $('#oetBrowsePDTCodeMerchant').val(),
                'tSHP'          : [$('#oetBrowsePDTCodeshpfrom').val(),$('#oetBrowsePDTCodeshpto').val()],
                'tRefInt'       : $('#ohdBrowseTXIRefInt').val(),
                'tViaCode'      : '<?= $tViaCode ?>'
            },
            cache   : false,
            timeout : 0,
            success : function(tResult){
                $('#odvTableContentTXIPDT').html(tResult);
            },
            error: function(data) {
                console.log(data);
            }
        });
    }


    //Browse BCH From
    var oCmpBrowseBCHFrom   = {
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
            Perpage			: 5,
            OrderBy			: ['TCNMBranch_L.FTBchName'],
            SourceOrder		: "ASC"
        },
        CallBack:{
            ReturnType	: 'S',
            Value		: ["oetBrowsePDTCodebchfrom","TCNMBranch.FTBchCode"],
            Text		: ["oetBrowsePDTNamebchfrom","TCNMBranch_L.FTBchName"],
        },
        NextFunc:{
            FuncName    : 'JSxModalShow',
            ArgReturn   : []
        }
    }
    $('#obtPDTbchBrowsefrom').click(function(){
        $('#odvModalTXIPDT').modal('toggle');
        JCNxBrowseData('oCmpBrowseBCHFrom');
        $('#myModal').modal({ backdrop: "static", keyboard: false });
        setTimeout(() => {
            $('#myModal #odvModalContent .xCNModalHead .xCNBTNDefult2Btn').attr('onclick','JCNxCloseTXIPDT()');
        }, 500);
    });


    //Browse BCH To
    var oCmpBrowseBCHTo  = {
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
            Perpage			: 5,
            OrderBy			: ['TCNMBranch_L.FTBchName'],
            SourceOrder		: "ASC"
        },
        CallBack:{
            ReturnType	: 'S',
            Value		: ["oetBrowsePDTCodebchto","TCNMBranch.FTBchCode"],
            Text		: ["oetBrowsePDTNamebchto","TCNMBranch_L.FTBchName"],
        },
        NextFunc:{
            FuncName    : 'JSxModalShow',
            ArgReturn   : []
        }
    }
    $('#obtPDTbchBrowseto').click(function(){
        $('#odvModalTXIPDT').modal('toggle');
        JCNxBrowseData('oCmpBrowseBCHTo');
        $('#myModal').modal({ backdrop: "static", keyboard: false });
        setTimeout(() => {
            $('#myModal #odvModalContent .xCNModalHead .xCNBTNDefult2Btn').attr('onclick','JCNxCloseTXIPDT()');
        }, 500);
    });


    //Browse Merchant
    var oCmpBrowseProductMerchant = {
        Title   :   ['company/merchant/merchant','tMerchantTitle'],
        Table   :   {Master:'TCNMShop',PK:'FTMerCode'},
        Join    :   {
            Table       :	['TCNMMerchant'],
            SpecialJoin :   ['RIGHT JOIN'],
            On          :   ['TCNMShop.FTMerCode = TCNMMerchant.FTMerCode LEFT JOIN TCNMMerchant_L ON TCNMMerchant_L.FTMerCode = TCNMMerchant.FTMerCode AND TCNMMerchant_L.FNLngID = '+nLangEdits,]
        },
        GrideView   :   {
            ColumnPathLang	: 'company/merchant/merchant',
            ColumnKeyLang	: ['tMerCode','tMerName'],
            ColumnsSize     : ['10%','75%'],
            DataColumns		: ['TCNMMerchant.FTMerCode','TCNMMerchant_L.FTMerName'],
            DistinctField   : [0],
            DataColumnsFormat : ['',''],
            WidthModal      : 50,
            Perpage			: 10,
            OrderBy			: ['TCNMMerchant.FTMerCode'],
            SourceOrder		: "ASC"
        },
        CallBack    :   {
            ReturnType	: 'S',
            Value       : ["oetBrowsePDTCodeMerchant","TCNMMerchant.FTMerCode"],
            Text		: ["oetBrowsePDTNameMerchant","TCNMMerchant_L.FTMerName"],
        },
        NextFunc    :   {
            FuncName    : 'JSxTXIControlMerChant',
            ArgReturn   : ['FTMerCode']
        },
        //DebugSQL : true
    } 
    $('#obtPDTMerchantBrowse').click(function(){
        $('#odvModalTXIPDT').modal('toggle');
        JCNxBrowseData('oCmpBrowseProductMerchant');
        $('#myModal').modal({ backdrop: "static", keyboard: false });
        setTimeout(() => {
            $('#myModal #odvModalContent .xCNModalHead .xCNBTNDefult2Btn').attr('onclick','JCNxCloseTXIPDT()');
        }, 500);
    });

    	//กลุ่มร้านค้า
	function JSxTXIControlMerChant(poJsonData) {
        if (poJsonData != "NULL") {
            aData = JSON.parse(poJsonData);
            tOldMchCode = $("#oetBrowsePDTCodeMerchant").data("oldval");
            tNewMchCode = aData[0];
            console.log(tOldMchCode + "::" + tNewMchCode);

            if (tOldMchCode != tNewMchCode) {
                //Set ค่าใหม่แทนที่ค่าเก่า ใน Iput
                $("#oetBrowsePDTCodeMerchant").data("oldval", tNewMchCode);

                //From
                $("#oetBrowsePDTCodeshpfrom").val('');
                $("#oetBrowsePDTNameshpfrom").val('');
                //To
                $("#oetBrowsePDTCodeshpto").val('');
                $("#oetBrowsePDTNameshpto").val('');

            } else {
                console.log('Merchant Not Change');
            }

        } else {

            if ($("#oetBrowsePDTCodeMerchant").data("oldval") != "") {
                $("#oetBrowsePDTCodeMerchant").data("oldval", "");

                //From
                $("#oetBrowsePDTCodeshpfrom").val('');
                $("#oetBrowsePDTNameshpfrom").val('');
                //To
                $("#oetBrowsePDTCodeshpto").val('');
                $("#oetBrowsePDTNameshpto").val('');
            }
        }
        $('#odvModalTXIPDT').modal('toggle');
    }

    //Browse SHP From
    var oCmpBrowseSHPFrom   = {
        Title : ['authen/user/user','tBrowseSHPTitle'],
        Table:{Master:'TCNMShop',PK:'FTShpCode'},
        Join : {
            Table   :	['TCNMShop_L'],
            On      :   ['TCNMShop_L.FTShpCode = TCNMShop.FTShpCode AND TCNMShop_L.FNLngID = '+nLangEdits,]
        },
        GrideView:{
            ColumnPathLang	: 'authen/user/user',
            ColumnKeyLang	: ['tBrowseSHPCode','tBrowseSHPName'],
            ColumnsSize     : ['10%','75%'],
            WidthModal      : 50,
            DataColumns		: ['TCNMShop.FTShpCode','TCNMShop_L.FTShpName'],
            DistinctField   : [0],
            DataColumnsFormat : ['',''],
            Perpage			: 10,
            OrderBy			: ['TCNMShop.FTShpCode'],
            SourceOrder		: "ASC"
        },
        Where :{
            Condition : [
                    function() {
                        var tSQL = "";
                        tBchCode = $("#ohdBrowseTXIPDTBchCode").val();
                        if (tBchCode != "") {
                            tSQL += " AND TCNMShop.FTBchCode = '"+tBchCode+"' ";
                        }else{
                            tSQL += "";
                        }
                        return tSQL;
                    }
                ]
        },
        CallBack:{
            ReturnType	: 'S',
            Value		: ["oetBrowsePDTCodeshpfrom","TCNMShop.FTShpCode"],
            Text		: ["oetBrowsePDTNameshpfrom","TCNMShop_L.FTShpName"],
        },
        NextFunc:{
            FuncName    : 'JSxModalShow',
            ArgReturn   : []
        },
        //DebugSQL : true
    }
    $('#obtPDTshpBrowsefrom').click(function(){
        $('#odvModalTXIPDT').modal('toggle');
        JCNxBrowseData('oCmpBrowseSHPFrom');
        $('#myModal').modal({ backdrop: "static", keyboard: false });
        setTimeout(() => {
            $('#myModal #odvModalContent .xCNModalHead .xCNBTNDefult2Btn').attr('onclick','JCNxCloseTXIPDT()');
        }, 500);
    });


    //Browse SHP To
    var oCmpBrowseSHPTo  = {
        Title : ['authen/user/user','tBrowseSHPTitle'],
        Table:{Master:'TCNMShop',PK:'FTShpCode'},
        Join :{
            Table   :	['TCNMShop_L'],
            On      :   ['TCNMShop_L.FTShpCode = TCNMShop.FTShpCode AND TCNMShop_L.FNLngID = '+nLangEdits,]
        },
        GrideView:{
            ColumnPathLang	: 'authen/user/user',
            ColumnKeyLang	: ['tBrowseSHPCode','tBrowseSHPName'],
            ColumnsSize     : ['10%','75%'],
            WidthModal      : 50,
            DataColumns		: ['TCNMShop.FTShpCode','TCNMShop_L.FTShpName'],
            DistinctField   : [0],
            DataColumnsFormat : ['',''],
            Perpage			: 10,
            OrderBy			: ['TCNMShop.FTShpCode'],
            SourceOrder		: "ASC"
        },
        Where :{
            Condition : [
                    function() {
                        var tSQL = "";
                        tBchCode = $("#ohdBrowseTXIPDTBchCode").val();
                        if (tBchCode != "") {
                            tSQL += " AND TCNMShop.FTBchCode = '"+tBchCode+"' ";
                        }else{
                            tSQL += "";
                        }
                        return tSQL;
                    }
                ]
        },
        CallBack:{
            ReturnType	: 'S',
            Value		: ["oetBrowsePDTCodeshpto","TCNMShop.FTShpCode"],
            Text		: ["oetBrowsePDTNameshpto","TCNMShop_L.FTShpName"],
        },
        NextFunc:{
            FuncName    : 'JSxModalShow',
            ArgReturn   : []
        }
    }
    $('#obtPDTshpBrowseto').click(function(){
        $('#odvModalTXIPDT').modal('toggle');
        JCNxBrowseData('oCmpBrowseSHPTo');
        $('#myModal').modal({ backdrop: "static", keyboard: false });
        setTimeout(() => {
            $('#myModal #odvModalContent .xCNModalHead .xCNBTNDefult2Btn').attr('onclick','JCNxCloseTXIPDT()');
        }, 500);
    });


    function JSxModalShow(){
        $('#odvModalTXIPDT').modal('toggle');
        // $('body').append('<div class="odvModalBackdropPDT modal-backdrop fade in"></div>');
    }

    //Reset Date
    function JSxTXIResetDataFrom(){
        $('#odvPanalSearchTXIPDT').find('input').val('');
        JSxGetPDTTable();
    }

</script>

