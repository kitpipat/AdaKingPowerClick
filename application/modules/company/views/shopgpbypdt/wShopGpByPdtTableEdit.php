<div class="row">
    <!--ปุ่มค้นหา-->
    <div class="col-xs-10 cols-sm-6 col-md-6 col-lg-6">

        <div class="row">
            <div class="col-lg-6 col-md-6 col-xs-7">
                <div class="form-group">
                    <label class="xCNLabelFrm"><?php echo language('common/main/main','tSearchNew')?></label>
                    <div class="input-group">
                        <input type="text" class="form-control xCNInputWithoutSingleQuote" id="oetSearchPDTinGP" name="oetSearchPDTinGP" placeholder="<?php echo language('common/main/main','tPlaceholder');?>">
                        <span class="input-group-btn">
                            <button id="obtSearchPDTinGP" class="btn xCNBtnSearch" type="button">
                                <img class="xCNIconBrowse" src="<?php echo base_url().'/application/modules/common/assets/images/icons/search-24.png'?>">
                            </button>
                        </span>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 col-md-6 col-xs-5">
                <div class="form-group">
                    <label class="xCNLabelFrm" style="color:#FFF !important; width:100%;">.</label>
                    <?php if($aAlwEventShopGpByPdt['tAutStaFull'] == 1 || $aAlwEventShopGpByPdt['tAutStaDelete'] == 1 ) : ?>
                        <div id="odvMngTableList" class="btn-group xCNDropDrownGroup">
                            <button type="button" class="btn xCNBTNMngTable" data-toggle="dropdown">
                                <?=language('common/main/main','tCMNOption')?>
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu" role="menu">
                                <li id="oliBtnDeleteAll" class="disabled">
                                    <a data-toggle="modal" data-target="#odvModalDelShopGPPDT"><?=language('common/main/main','tDelAll')?></a>
                                </li>
                            </ul>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

        </div>

    </div>

    <!--ปุ่มตัวเลือก กับ ปุ่มเพิ่ม-->
    <div class="col-xs-2 col-md-6 col-lg-6 text-right">
        <label class="xCNLabelFrm" style="color:#FFF !important; width:100%;">.</label>
        <button id="obtBrowseShopGpByPdt" name="obtBrowseShopGpByPdt" class="xCNBTNPrimeryPlus" type="button" style="margin-left: 20px; margin-top: 0px;">+</button>
    </div>

    <div class="col-lg-12">
        <table id="otbShopGpByPDTTableEdit" class="table table-striped"></table>
    </div>
</div>

<!--Modal Delete Product-->
<div class="modal fade" id="odvModalDelShopGPPDT">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header xCNModalHead">
				<label class="xCNTextModalHeard"><?= language('common/main/main', 'tModalDelete')?></label>
			</div>
			<div class="modal-body">
				<span id="ospConfirmDelete" class="xCNTextModal" style="display: inline-block; word-break:break-all"></span>
				<input type='hidden' id="ohdConfirmIDDelete">
			</div>
			<div class="modal-footer">
				<button id="osmConfirm" type="button" class="btn xCNBTNPrimery" data-dismiss="modal" onclick="JSxDeletePDTinTableShopGP();">
					<?= language('common/main/main', 'tModalConfirm'); ?>
				</button>
				<button type="button" class="btn xCNBTNDefult" data-dismiss="modal">
					<?= language('common/main/main', 'tModalCancel'); ?>
				</button>
			</div>
		</div>
	</div>
</div>

<!--Modal Insert Product-->
<div class="modal fade" id="odvModalPleaseInsertPDT">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header xCNModalHead">
				<label class="xCNTextModalHeard">
                    <?= language('company/shopgpbypdt/shopgpbypdt', 'tModalHeadPleaseInsertPDT')?>
                </label>
			</div>
			<div class="modal-body">
				<span class="xCNTextModal" style="display: inline-block; word-break:break-all">
                    <?= language('company/shopgpbypdt/shopgpbypdt', 'tModalTextPleaseInsertPDT')?>
                </span>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn xCNBTNPrimery" data-dismiss="modal">
					<?= language('common/main/main', 'tModalConfirm'); ?>
				</button>
				<button type="button" class="btn xCNBTNDefult" data-dismiss="modal">
					<?= language('common/main/main', 'tModalCancel'); ?>
				</button>
			</div>
		</div>
	</div>
</div>

<!--Modal GP special-->
<div class="modal fade" id="odvModalGPSpecial">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header xCNModalHead">
				<label class="xCNTextModalHeard"><?= language('company/shopgpbypdt/shopgpbypdt', 'tModalGPSpecial')?></label>
			</div>
			<div class="modal-body">
                <div class="row">
                    <div class="col-lg-2"><label style="font-weight: bold;"><?=language('company/shopgpbypdt/shopgpbypdt','tSGPPTableBch');?></label></div>
                    <div class="col-lg-10"><span id="ospGPSpecialBCH"></span></div>
                </div>
                <div class="row">
                    <div class="col-lg-2"><label style="font-weight: bold;"><?=language('company/shopgpbypdt/shopgpbypdt','tSGPPTableShop');?></label></div>
                    <div class="col-lg-10"><span id="ospGPSpecialSHP"></span></div>
                </div>
                <div class="row">
                    <div class="col-lg-2"><label style="font-weight: bold;"><?=language('company/shopgpbypdt/shopgpbypdt','tSGPPTableNameProduct');?></label></div>
                    <div class="col-lg-10">  <span id="ospGPSpecialPDTName"></span></div>
                </div>
                <input type="hidden" id="ohdGPSpecialPDTCode" name="ohdGPSpecialPDTCode">
                <table id="otbShopGPSpecial" class="table table-striped">
                    <thead>
                        <tr>
                            <th nowrap class="text-center xCNTextBold" style="width:10%;"><?=language('company/shopgpbypdt/shopgpbypdt','tTableGPNumber')?></th>
                            <th nowrap class="text-center xCNTextBold" style="width:70%;"><?=language('company/shopgpbypdt/shopgpbypdt','tTableGPDay')?></th>
                            <th nowrap class="text-center xCNTextBold" style="width:25%;"><?=language('company/shopgpbypdt/shopgpbypdt','%GP')?></th>
                            <th nowrap class="xWDeleteBtnEditButton" style="display:none;"></th>
                        </tr>
                    </thead>
                    <tbody id="odvRGPList">
                        <tr>
                            <td>1</td>
                            <td><?=language('company/shopgpbypdt/shopgpbypdt','tSGPPTBPerMon')?></td>
                            <td>
                                <label class="xWShowInLine xCNInputNumericWithDecimal xGPSpacMon">0.00</label>
                                <div class="xCNHide xWEditInLine"> 
                                    <input type="text" class="form-control xCNInputNumericWithDecimal xCNPdtEditInLine xCNInputWithoutSpc xCNValueMon">
                                </div>
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td><?=language('company/shopgpbypdt/shopgpbypdt','tSGPPTBPerTue')?></td>
                            <td>
                                <label class="xWShowInLine xCNInputNumericWithDecimal xGPSpacTue">0.00</label>
                                <div class="xCNHide xWEditInLine">
                                    <input type="text" class="form-control xCNInputNumericWithDecimal xCNPdtEditInLine xCNInputWithoutSpc xCNValueTue">
                                </div>
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td><?=language('company/shopgpbypdt/shopgpbypdt','tSGPPTBPerWed')?></td>
                            <td>
                                <label class="xWShowInLine xCNInputNumericWithDecimal xGPSpacWed">0.00</label>
                                <div class="xCNHide xWEditInLine">
                                    <input type="text" class="form-control xCNInputNumericWithDecimal xCNPdtEditInLine xCNInputWithoutSpc xCNValueWed">
                                </div>
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td><?=language('company/shopgpbypdt/shopgpbypdt','tSGPPTBPerThu')?></td>
                            <td>
                                <label class="xWShowInLine xCNInputNumericWithDecimal xGPSpacThu">0.00</label>
                                <div class="xCNHide xWEditInLine">
                                    <input type="text" class="form-control xCNInputNumericWithDecimal xCNPdtEditInLine xCNInputWithoutSpc xCNValueThu">
                                </div>
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td><?=language('company/shopgpbypdt/shopgpbypdt','tSGPPTBPerFri')?></td>
                            <td>
                                <label class="xWShowInLine xCNInputNumericWithDecimal xGPSpacFri">0.00</label>
                                <div class="xCNHide xWEditInLine">
                                    <input type="text" class="form-control xCNInputNumericWithDecimal xCNPdtEditInLine xCNInputWithoutSpc xCNValueFri">
                                </div>
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>6</td>
                            <td><?=language('company/shopgpbypdt/shopgpbypdt','tSGPPTBPerSat')?></td>
                            <td>
                                <label class="xWShowInLine xCNInputNumericWithDecimal xGPSpacSat">0.00</label>
                                <div class="xCNHide xWEditInLine">
                                    <input type="text" class="form-control xCNInputNumericWithDecimal xCNPdtEditInLine xCNInputWithoutSpc xCNValueSat">
                                </div>
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>7</td>
                            <td><?=language('company/shopgpbypdt/shopgpbypdt','tSGPPTBPerSun')?></td>
                            <td>
                                <label class="xWShowInLine xCNInputNumericWithDecimal xGPSpacSun">0.00</label>
                                <div class="xCNHide xWEditInLine">
                                    <input type="text" class="form-control xCNInputNumericWithDecimal xCNPdtEditInLine xCNInputWithoutSpc xCNValueSun">
                                </div>
                            </td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
			</div>
			<div class="modal-footer">
				<button id="osmConfirm" type="button" class="btn xCNBTNPrimery" data-dismiss="modal" onclick="JSxSaveGPSpecial()">
					<?= language('company/shopgpbypdt/shopgpbypdt', 'tSGPPBTNSave'); ?>
				</button>
				<button type="button" class="btn xCNBTNDefult" data-dismiss="modal">
					<?= language('common/main/main', 'tModalCancel'); ?>
				</button>
			</div>
		</div>
	</div>
</div>

<script src="<?php echo base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>
<script>
    $('ducument').ready(function() {

        //ค้นหา
        $("#oetSearchPDTinGP").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#otbShopGpByPDTTableEdit tbody tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });


        //Set GP ALL
        $('#obtUseGPAll').click(function(){
            if($('#oetShopGpByPDTPercent').val() == ''){
                $('#oetShopGpByPDTPercent').focus();
            }else{
                var tGPAll = $('#oetShopGpByPDTPercent').val();
                $('.xWShowInLine').val(tGPAll);
                $('.xCNPdtEditInLine').val(tGPAll);
            }
        });

        //ปุ่ม save
        $('#obtGpShopByPDTSave').click(function(){
            if($('#oetShopGpByPDTInsertDateStart').val() == ''){
                //ห้ามปฎิทินค่าว่าง
                $('#obtShopGpByPDTInsertDateStart').click();
            }else if($('#oetInputBchCode').val() == ''){
                //ห้ามสาขาว่าง
                $('#oetInputBchName').focus();
            }else{
                var nLenRecord = $("#otbShopGpByPDTTableEdit tbody tr").hasClass("otrNoData");
                if(nLenRecord == true){
                    $('#odvModalPleaseInsertPDT').modal('show');
                }else{
                    //insert
                    //Get GP ALL
                    var aGP = [];
                    for(i=0; i<aDataItem.length; i++){
                        var nGP = $('.xWValueGPEditInLine'+aDataItem[i].KEY).val();
                        aGP.push(nGP);
                    }

                    $.ajax({
                        type    : "POST",
                        url     : "CmpShopGpByProductEventEdit",
                        data: {
                            tBCH                : $('#oetInputBchCode').val(),
                            tSHP                : $('#ohdShopGPPDTShp').val(),
                            tOldDataStart       : $('#ohdOldStartDate').val(),
                            tDataStart          : $('#oetShopGpByPDTInsertDateStart').val(),
                            aGP                 : aGP,
                            aDataItem           : aDataItem,
                            pnSeq               : '<?=$pnSeq;?>'
                        },
                        success: function (oResult) {
                            var aReturnData = JSON.parse(oResult);
                            if(aReturnData['nStaProcess'] == 'DateDuplicate'){
                                alert('วันที่ซ้ำ');
                            }else{
                                if(aReturnData["nStaCallBack"] == 1){
                                    //บันทึกและดู
                                    var tDate   = $('#oetShopGpByPDTInsertDateStart').val();
                                    var tBch    = $('#oetInputBchCode').val();
                                    JSvCallPageGpShopClickEdit(tDate,tBch);
                                }else if(aReturnData["nStaCallBack"] == 2){
                                    //บันทึกและเพิ่มใหม่
                                    var tBCH = $('#ohdShopGPPDTBch').val();
                                    var tSHP = $('#ohdShopGPPDTShp').val();
                                    JSvCallPageShopGpByPdtMain(tBCH,tSHP,1);
                                    $('#odvSetionShopGPByPDT').html();
                                    $.ajax({
                                        type: "POST",
                                        url: "CmpShopGpByProductPageAdd",
                                        data: {
                                            tBchCode           : $('#ohdShopGPPDTBch').val(),
                                            tShpCode           : $('#ohdShopGPPDTShp').val(),
                                            tPageEvent         : 'PageAdd'
                                        },
                                        success: function (oResult) {
                                            JCNxCloseLoading();
                                            $('#odvSetionShopGPByPDT').html(oResult);
                                        },
                                        error: function(jqXHR, textStatus, errorThrown) {
                                            JCNxResponseError(jqXHR, textStatus, errorThrown);
                                        }
                                    });
                                }else if(aReturnData["nStaCallBack"] == 3){
                                    //บันทึกแล้วย้อนกลับ
                                    var tBCH = $('#ohdShopGPPDTBch').val();
                                    var tSHP = $('#ohdShopGPPDTShp').val();
                                    JSvCallPageShopGpByPdtMain(tBCH,tSHP,1);
                                }else{
                                    //บันทึกและดู
                                    var tDate   = $('#oetShopGpByPDTInsertDateStart').val();
                                    var tBch    = $('#oetInputBchCode').val();
                                    JSvCallPageGpShopClickEdit(tDate,tBch);
                                }
                            }

                            JCNxCloseLoading();
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            JCNxResponseError(jqXHR, textStatus, errorThrown);
                        }
                    });
                }
            }
        });

        //Edit inline 
            var oParameterSend =  {
                                    "FunctionName"                  : "",
                                    "DataAttribute"                 : [],
                                    "TableID"                       : "otbShopGPSpecial",
                                    "NotFoundDataRowClass"          : "xWTextNotfoundDataTablePdt",
                                    "EditInLineButtonDeleteClass"   : "xWDeleteBtnEditButton",
                                    "LabelShowDataClass"            : "xWShowInLine",
                                    "DivHiddenDataEditClass"        : "xWEditInLine"
                                };
            JCNxSetNewEditInline(oParameterSend);
            $(".xWEditInlineElement").eq(nIndexInputEditInline).focus(function(){
                this.select(); 
            }); 
            setTimeout(function(){
                $(".xWEditInlineElement").eq(nIndexInputEditInline).focus();
            }, 300);
            $(".xWEditInlineElement").removeAttr("disabled");

            //input number only
            $(".xCNInputNumericWithDecimal").on("keypress keyup blur", function (event) {
                $(this).val($(this).val().replace(/[^0-9\.]/g, ''));
                if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
                    event.preventDefault();
                }
            });

    });

    //Browse PDT
    $('#obtBrowseShopGpByPdt').click(function(){
        var dTime = new Date();
        var dTimelocalStorage = dTime.getTime();

        aMulti = [];
        $.ajax({
            type    : "POST",
            url     : "BrowseDataPDT",
            data    : {
                Qualitysearch: [
                    /*"SUP",
                    "PurchasingManager",
                    "NAMEPDT",
                    "CODEPDT",
                    "BARCODE",
                    'LOC',
                    "FromToBCH",
                    "Merchant",
                    "GroupMerchant",
                    "FromToSHP",
                    "FromToPGP",
                    "FromToPTY"*/
                ],
                PriceType       : ["Pricesell"],
                SelectTier      : ["PDT"],
                ShowCountRecord : 10,
                NextFunc        : "JSxGenTableCaseEdit",
                ReturnType      : "M",
                SPL             : ["", ""],
                BCH             : [$('#ohdShopGPPDTBch').val(),$('#ohdShopGPPDTBch').val()],
                SHP             : [$('#ohdShopGPPDTShp').val(),$('#ohdShopGPPDTShp').val()],
                TimeLocalstorage: dTimelocalStorage
            },
            cache   : false,
            timeout : 5000,
            success : function (tResult) {
                $("#odvModalDOCPDT").modal({ backdrop: "static", keyboard: false });
                $("#odvModalDOCPDT").modal({ show: true });

                //remove localstorage
                localStorage.removeItem("LocalItemDataPDT");
                localStorage.removeItem("LocalItemDataPDT" + dTimelocalStorage);
                $("#odvModalsectionBodyPDT").html(tResult);
            },
            error: function (data) {
                console.log(data);
            }
        });
    });

    var tItem = '<?=$aDataItem?>';
    var aItem = JSON.parse(tItem);
    var aItem = aItem.raItems;

    var tHTMLs;
    var aDataItem   = [];
    var nKeyLast    = 0;
    var ptType      = 'Edit';
    for(k=0; k<aItem.length; k++){
        aDataItem.push({'KEY': nKeyLast , 'PDTCODE' : aItem[k].FTPdtCode , 'PDTNAME' : aItem[k].FTPdtName , 'GP' : aItem[k].FCSgpPerAvg });
        nKeyLast++;
    }
    JSxGenTableCaseEdit('load',ptType);

    //Gen Table
    function JSxGenTableCaseEdit(elem,ptType){

        var tWaring;
        var tProductDuplicate;
        if(ptType != 'Edit'){
            var aData = JSON.parse(elem);
            for($i=0; $i<aData.length; $i++){
                var tFindProductDuplicate = $('#otbShopGpByPDTTableEdit tbody').find("[data-code='" +aData[$i].pnPdtCode+ "']");
                if(tFindProductDuplicate.length == 1){
                    var tWaring           = 1;
                    var tProductDuplicate = aData[$i].packData.PDTName;
                }else{
                    aDataItem.push({'KEY': nKeyLast , 'PDTCODE' : aData[$i].pnPdtCode , 'PDTNAME' : aData[$i].packData.PDTName , 'GP' : '0.00' });
                    nKeyLast++;
                }
            }
        }

        if(tWaring == 1){
            alert('พบข้อมูลซ้ำ : ' + tProductDuplicate);
        }

        //ห้ามค่าซ้ำ
        //Step ลบจาก array ที่เลือกก่อน
        function getUnique(arr, comp) {
            const unique = arr.map(e => e[comp]).map((e, i, final) => final.indexOf(e) === i && i).filter(e => arr[e]).map(e => arr[e]);
            return unique;
        }
        aDataItem = getUnique(aDataItem,'PDTCODE');
        
        $("#otbShopGpByPDTTableEdit").html('');  
        var tHTML = '<thead>';
            tHTML += '<tr>';
            tHTML += '<th nowrap class="text-center xCNTextBold" style="width:10%;"><?=language('company/shopgpbypdt/shopgpbypdt','tSGPPTableChoose')?></th>';
            tHTML += '<th nowrap class="text-center xCNTextBold" style="width:20%;"><?=language('company/shopgpbypdt/shopgpbypdt','tSGPPTableCodeProduct');?></th>';
            tHTML += '<th nowrap class="text-center xCNTextBold" ><?=language('company/shopgpbypdt/shopgpbypdt','tSGPPTableNameProduct');?></th>';
            tHTML += '<th nowrap class="text-center xCNTextBold" style="width:10%;"><?=language('company/shopgpbypdt/shopgpbypdt','%GP');?></th>';
            tHTML += '<th nowrap class="text-center xCNTextBold" style="width:10%;"><?=language('company/shopgpbypdt/shopgpbypdt','tSGPPTableSpecial');?></th>';
            tHTML += '<th nowrap class="text-center xCNTextBold" style="width:10%;"><?=language('company/shopgpbypdt/shopgpbypdt','tSGPPTableDel');?></th>';
            tHTML += '<th nowrap class="xWDeleteBtnEditButton" style="display:none;"></th>';
            tHTML += '</tr>';
            tHTML += '</thead>';
            tHTML += '<tbody id="odvRGPList">';

            for($j=0; $j<aDataItem.length; $j++){
                tHTMLs += '<tr data-key="'+aDataItem[$j].KEY+'" data-code="'+aDataItem[$j].PDTCODE+'" data-name="'+aDataItem[$j].PDTNAME+'">'; 

                //Choose Select
                tHTMLs += '<td class="text-center">';
                tHTMLs += '<label class="fancy-checkbox">';
                tHTMLs += '<input id="ocbListTablePDTItem'+$j+'" type="checkbox" class="ocbListTablePDTItem" name="ocbListTablePDTItem[]" onChange="JSxShopGPByPDTVisibledDelAllBtn(this,event)">';
                tHTMLs += '<span>&nbsp;</span>';
                tHTMLs += '</label>';
                tHTMLs += '</td>';
                //End Choose Select

                //Code product
                tHTMLs += '<td nowrap class="text-left">';
                tHTMLs += '<label>' + aDataItem[$j].PDTCODE + '</label>';
                tHTMLs += '</td>';
                //End Code product

                //Name product
                tHTMLs += '<td nowrap class="text-left">';
                tHTMLs += '<label>' + aDataItem[$j].PDTNAME + '</label>';
                tHTMLs += '</td>';
                //End Name product

                //GP product
                if(aDataItem[$j].GP == '' || aDataItem[$j].GP == null){
                    nGP = 0.00;
                }else{
                    nGP = aDataItem[$j].GP;
                }
                tHTMLs += '<td nowrap class="text-right">';
                tHTMLs += '<label class="xWShowInLine xCNInputNumericWithDecimal xWValueGPEditInLine'+aDataItem[$j].KEY+'">'+nGP+'</label>';
                tHTMLs += '<div class="xCNHide xWEditInLine">';
                tHTMLs += '<input type="text" class="form-control xCNInputNumericWithDecimal xCNPdtEditInLine xCNInputWithoutSpc"';
                tHTMLs += 'value="0.00" />';
                tHTMLs += '</div>';
                tHTMLs += '</td>';
                //End GP

                //GP Special
                tHTMLs += '<td nowrap class="text-center">';
                tHTMLs += '<label style="cursor:pointer;" data-KEY="'+aDataItem[$j].KEY+'" data-PDTName="'+aDataItem[$j].PDTNAME+'" data-PDTCode="'+aDataItem[$j].PDTCODE+'" onClick="JSxSetGPSpecial(this)">'+'<?=language('company/shopgpbypdt/shopgpbypdt','tSGPPTableSpecial');?>'+'';
                tHTMLs += '<img style="margin-left: 5px; width: 15px;" src="<?=base_url().'/application/modules/common/assets/images/icons/calendar.png'?>" ></label>';
                tHTMLs += '</td>';
                //End GP Special

                //BTN Delete
                tHTMLs += '<td nowrap class="text-center">';
                tHTMLs += '<img class="xCNIconTable" id="oimGpShopRowDel" src="<?=base_url().'/application/modules/common/assets/images/icons/delete.png'?>" onClick="JSnShopGpByPDTTable(this,'+aDataItem[$j].KEY+')">';
                tHTMLs += '</td>';
                //End BTN Delete

                //BTN Edit
                tHTMLs += '<td>';
                tHTMLs += '</td>';
                //End BTN Edit
                
                tHTMLs += '</tr>';
            }

            tHTML += tHTMLs;
            tHTML += '</tbody>';
            tHTML += '</table>';
        
            $("#otbShopGpByPDTTableEdit").html(tHTML);
            tHTMLs = '';
            JSCallFunctionEditinline();
    }  

    //Edit inline
    function JSCallFunctionEditinline(){
        var oParameterSend =  {
                                "FunctionName"                  : "",
                                "DataAttribute"                 : [],
                                "TableID"                       : "otbShopGpByPDTTableEdit",
                                "NotFoundDataRowClass"          : "xWTextNotfoundDataTablePdt",
                                "EditInLineButtonDeleteClass"   : "xWDeleteBtnEditButton",
                                "LabelShowDataClass"            : "xWShowInLine",
                                "DivHiddenDataEditClass"        : "xWEditInLine"
                            };
        JCNxSetNewEditInline(oParameterSend);
        $(".xWEditInlineElement").eq(nIndexInputEditInline).focus(function(){
            this.select(); 
        }); 
        setTimeout(function(){
            $(".xWEditInlineElement").eq(nIndexInputEditInline).focus();
        }, 300);
        $(".xWEditInlineElement").removeAttr("disabled");

        //input number only
        $(".xCNInputNumericWithDecimal").on("keypress keyup blur", function (event) {
            $(this).val($(this).val().replace(/[^0-9\.]/g, ''));
            if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
                event.preventDefault();
            }
        });

        //maxlength
        $('.xWShowInLine').attr('maxlength','5');

        //ปุ่มลบ
        localStorage.removeItem("LocalItemData");
        $('.ocbListTablePDTItem').click(function(){
            var nCode   = $(this).parent().parent().parent().data('code');  //code
            var tName   = $(this).parent().parent().parent().data('name');  //name
            var tKey    = $(this).parent().parent().parent().data('key');  //name
            $(this).prop('checked', true);
            var LocalItemData = localStorage.getItem("LocalItemData");
            var obj = [];
            if(LocalItemData){
                obj = JSON.parse(LocalItemData);
            }else{ }
            var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
            if(aArrayConvert == '' || aArrayConvert == null){
                obj.push({"nCode": nCode, "tName": tName , "tKey" : tKey});
                localStorage.setItem("LocalItemData",JSON.stringify(obj));
                JSxPaseCodeDelInModal();
            }else{
                var aReturnRepeat = findObjectByKey(aArrayConvert[0],'nCode',nCode);
                if(aReturnRepeat == 'None' ){           //ยังไม่ถูกเลือก
                    obj.push({"nCode": nCode, "tName": tName , "tKey" : tKey});
                    localStorage.setItem("LocalItemData",JSON.stringify(obj));
                    JSxPaseCodeDelInModal();
                }else if(aReturnRepeat == 'Dupilcate'){	//เคยเลือกไว้แล้ว
                    localStorage.removeItem("LocalItemData");
                    $(this).prop('checked', false);
                    var nLength = aArrayConvert[0].length;
                    for($i=0; $i<nLength; $i++){
                        if(aArrayConvert[0][$i].nCode == nCode){
                            delete aArrayConvert[0][$i];
                        }
                    }
                    var aNewarraydata = [];
                    for($i=0; $i<nLength; $i++){
                        if(aArrayConvert[0][$i] != undefined){
                            aNewarraydata.push(aArrayConvert[0][$i]);
                        }
                    }
                    localStorage.setItem("LocalItemData",JSON.stringify(aNewarraydata));
                    JSxPaseCodeDelInModal();
                }
            }
            JSxShowButtonChoose();
        });
    }

    //ปุ่ม save gp special
    function JSxSaveGPSpecial(){
       //Insert ลง temp
       $.ajax({
            type: "POST",
            url: "CmpShopGpByProductEventInsertGPToTemp",
            data: {
                tType           : 'Insert',
                tOldStartDate   : $('#ohdOldStartDate').val(),
                tBch            : $('#ohdOldBch').val(),
                tShp            : $('#ohdOldShp').val(),
                tPDTCode        : $('#ohdGPSpecialPDTCode').val(),
                nMon            : $('.xGPSpacMon').val(),
                nTue            : $('.xGPSpacTue').val(),
                nWed            : $('.xGPSpacWed').val(),
                nThu            : $('.xGPSpacThu').val(),
                nFri            : $('.xGPSpacFri').val(),
                nSat            : $('.xGPSpacSat').val(), 
                nSun            : $('.xGPSpacSun').val()
            },
            success: function (oResult) {
                JCNxCloseLoading();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }

    //ปุ่ม set gp special
    function JSxSetGPSpecial(element){
        var tNamePDT    = $(element).attr('data-PDTName');
        var tKEYPDT     = $(element).attr('data-KEY');
        var tCodePDT    = $(element).attr('data-PDTCode');

        $('#ospGPSpecialBCH').text(' : ' + $('#oetGPEBchcode').val());
        $('#ospGPSpecialSHP').text(' : ' + $('#oetGPEShpcode').val());
        $('#ospGPSpecialPDTName').text(' : ' + tNamePDT);
        $('#ohdGPSpecialPDTCode').val(tCodePDT);
        $('#odvModalGPSpecial').modal('show');

        $.ajax({
            type: "POST",
            url: "CmpShopGpByProductEventInsertGPToTemp",
            data: {
                tType           : 'Edit',
                tOldStartDate   : $('#ohdOldStartDate').val(),
                tBch            : $('#ohdOldBch').val(),
                tShp            : $('#ohdOldShp').val(),
                tPDTCode        : tCodePDT
            },
            success: function (oResult) {
                JCNxCloseLoading();
                var tResult = JSON.parse(oResult);
                if(tResult['rtCode'] == 1){
                    $('.xGPSpacMon').val(tResult['raItem'].FCSgpPerMon);
                    $('.xGPSpacTue').val(tResult['raItem'].FCSgpPerTue);
                    $('.xGPSpacWed').val(tResult['raItem'].FCSgpPerWed);
                    $('.xGPSpacThu').val(tResult['raItem'].FCSgpPerThu);
                    $('.xGPSpacFri').val(tResult['raItem'].FCSgpPerFri);
                    $('.xGPSpacSat').val(tResult['raItem'].FCSgpPerSat);
                    $('.xGPSpacSun').val(tResult['raItem'].FCSgpPerSun);
                }else{
                    $('.xGPSpacMon').val("0.00");
                    $('.xGPSpacTue').val("0.00");
                    $('.xGPSpacWed').val("0.00");
                    $('.xGPSpacThu').val("0.00");
                    $('.xGPSpacFri').val("0.00");
                    $('.xGPSpacSat').val("0.00");
                    $('.xGPSpacSun').val("0.00");
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });

        //maxlength
        $('.xWShowInLine').attr('maxlength','5');
    }

    //Delete By record
    function JSnShopGpByPDTTable(element,pnKey){
        tHTMLs = '';
        for(i=0; i <aDataItem.length; i++){ 
            if( aDataItem[i].KEY == pnKey){
                aDataItem.splice(i, 1); 
            }
        }
        $(element).parent().parent().remove();
        JSxCheckRecordinTable();
    }

    //เปิดปุ่ม ลบทั้งหมด
    function JSxShopGPByPDTVisibledDelAllBtn(poElement,poEvent){
        var nCheckedCount = $('#odvRGPList td input:checked').length;
        if(nCheckedCount > 1){
            $('#oliBtnDeleteAll').removeClass("disabled");
        }else{
            $('#oliBtnDeleteAll').addClass("disabled");
        }
    }

    //Text Delete หลาย record
    function JSxPaseCodeDelInModal() {
        var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
        if (aArrayConvert[0] == null || aArrayConvert[0] == '') {} else {
            var tTextCode = '';
            for ($i = 0; $i < aArrayConvert[0].length; $i++) {
                tTextCode += aArrayConvert[0][$i].tKey;
                tTextCode += ',';
            }
            $('#ospConfirmDelete').text($('#oetTextComfirmDeleteMulti').val());
            $('#ohdConfirmIDDelete').val(tTextCode);
        }
    }

    //Function Show Button Delete All
    function JSxShowButtonChoose() {
        var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
        if (aArrayConvert[0] == null || aArrayConvert[0] == '') {
            $('.obtChoose').hide();
        } else {
            nNumOfArr = aArrayConvert[0].length;
            if (nNumOfArr > 1) {
                $('.obtChoose').fadeIn(300);
            } else {
                $('.obtChoose').fadeOut(300);
            }
        }
    }

    //Event Delete All Product
    function JSxDeletePDTinTableShopGP(){
        var tValue = $('#ohdConfirmIDDelete').val();
        var tValue = tValue.substring(0,tValue.length-1);
        var aValue = tValue.split(",");

        tHTMLs = '';
        for(j=0; j<aValue.length; j++){
            for(i=0; i<aDataItem.length; i++){ 
                // console.log('KEY : ' + aValue[j] + ' ,,,,, ' + ' Array : ' + aDataItem[i].KEY);
                if( aDataItem[i].KEY == aValue[j]){
                    aDataItem.splice(i, 1); 
                    $('#otbShopGpByPDTTableEdit tbody').find("[data-key='" + aValue[j] + "']").remove();
                }
            }
        }

        JSxCheckRecordinTable();
    }

    //ถ้าลบจนข้อมูลไม่เหลืออะไรเลย
    function JSxCheckRecordinTable(){
        var nLenRecord = $("#otbShopGpByPDTTableEdit tbody tr").length;
        if(nLenRecord == 0){
            $("#otbShopGpByPDTTableEdit tbody").append("<tr class='otrNoData'><td colspan='6' class='text-center xWTextNotfoundDataTablePdt'> กรุณาเพิ่มข้อมูล </td></tr>");
        }

        $('#oliBtnDeleteAll').addClass("disabled");
    }
</script>
