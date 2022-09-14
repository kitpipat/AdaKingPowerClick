   <?php //print_r($aColumnShow);?>
  <div class="row">
    <div class="col-md-12">
        <div class="text-right"><label onclick="JSxOpenColumnFormSet()" style="cursor:pointer"><?= language('common/main/main','tModalAdvTable')?></label></div>
    </div>
  </div>
  <div class="table-responsive">
<?php //echo "<pre>"; ?>
<?php //print_r($aDataFile); ?>
<?php //echo "</pre>"; ?>
      <input type="text" class="xCNHide" id="ohdBrowseDataPdtCode" value="">
      <input type="text" class="xCNHide" id="ohdBrowseDataPunCode" value="">

      <input type="text" class="xCNHide" id="ohdEditInlinePdtCode" value="<?php echo $tPdtCode?>">
      <input type="text" class="xCNHide" id="ohdEditInlinePunCode" value="<?php echo $tPunCode?>">
      
      <table class="table table-striped xWPdtTableFont" id="otbDOCCashTable">
        <thead>
          <tr class="xCNCenter">
            <th><?= language('document/purchaseorder/purchaseorder','tPOTBChoose')?></th>
            <?php foreach($aColumnShow as $HeaderColKey=>$HeaderColVal){?>
            <th nowrap title="<?php echo iconv_substr($HeaderColVal->FTShwNameUsr, 0,30, "UTF-8");?>">
                <?php echo iconv_substr($HeaderColVal->FTShwNameUsr, 0,30, "UTF-8");?>
            </th>
            <?php }?>
            <?php if($tXphStaApv != 1 && $tXphStaDoc != 3){?>
              <th><?= language('document/purchaseorder/purchaseorder','tPOTBDelete')?></th>
              <th><?= language('document/purchaseorder/purchaseorder','tPOTBEdit')?></th>
            <?php } ?>
          </tr>
        </thead>
        <tbody id="odvTBodyPOPdt">
        <?php $nNumSeq = 0; ?>

        <?php if(FCNnHSizeOf($aDataFile['DTData']) > 0):?>
              
              <?php foreach($aDataFile['DTData'] as $DataTableKey=>$DataTableVal){?>
      
                    <tr class="text-center xCNTextDetail2 xCNDOCPdtItem nItem<?=$nNumSeq?>"  data-index="<?=$DataTableKey?>" data-pdtname="<?=$DataTableVal['FTXpdPdtName']?>" data-pdtcode="<?=$DataTableVal['FTPdtCode']?>" data-puncode="<?=$DataTableVal['FTPunCode']?>" data-seqno="<?=$DataTableVal['FNXpdSeqNo']?>">
                      <td class="" ><?=$nNumSeq+1?></td>
                      <?php foreach($aColumnShow as $DataKey=>$DataVal){

                            $tColumnName = $DataVal->FTShwFedShw;
                            $nColWidth = $DataVal->FNShwColWidth;

                            $tColumnDataType = substr($tColumnName,0,2);

                            if($tColumnDataType == 'FC'){
                                $tMaxlength = '11';
                                $tAlignFormat = 'text-right';
                                $tDataCol =  $DataTableVal[$tColumnName] != '' ? number_format($DataTableVal[$tColumnName], $nOptDecimalShow, '.', ',') : number_format(0, $nOptDecimalShow,'.',',');
                                $InputType = 'text';
                                $tValidateType = 'xCNInputNumericWithDecimal';
                            }elseif($tColumnDataType == 'FN'){
                                $tMaxlength = '';
                                $tAlignFormat = 'text-right';
                                $tDataCol = $DataTableVal[$tColumnName] != '' ? number_format($DataTableVal[$tColumnName], $nOptDecimalShow, '.', ',') : number_format(0, $nOptDecimalShow,'.',',');
                                $InputType = 'number';
                                $tValidateType = '';
                            }else{
                                $tMaxlength = '';
                                $tAlignFormat = 'text-left';
                                $tDataCol = $DataTableVal[$tColumnName];
                                $InputType = 'text';
                                $tValidateType = '';
                            }
                            
                            //หาว่ามีส่วนลดหรือไม่
                            if($DataTableVal['FTXpdDisChgTxt'] != ''){
                              $tDisabledQtyAndSetPrice = 'disabled';
                            }else{
                              $tDisabledQtyAndSetPrice = '';
                            }

                      ?>
                          <td nowrap class="<?=$tAlignFormat?>">
                              <?php if($DataVal->FTShwStaAlwEdit == 1){ ?>
                                      <label class="xCNPdtFont xWShowInLine<?=$DataTableVal['FNXpdSeqNo']?> xWShowValue<?=$tColumnName?><?=$DataTableVal['FNXpdSeqNo']?>"><?= $DataTableVal[$tColumnName] != '' ? "".$DataTableVal[$tColumnName] : '-'; ?></label>
                                      <div class="xCNHide xWEditInLine<?=$DataTableVal['FNXpdSeqNo']?>">
                                          <!-- Check Show Button Edit Discount -->
                                          <!-- เช็คว่า Field เป็น FTXpdDisChgTxt คือ Field ลด -->
                                          <?php if($tColumnName == 'FTXpdDisChgTxt'):?>
                                            <?php if($DataTableVal['FTXpdStaAlwDis'] == '1'):?>
                                              <div class="input-group">
                                                <input type="<?=$InputType?>" class="form-control xCNPdtEditInLine xWValueEditInLine<?=$DataTableVal['FNXpdSeqNo']?> <?=$tValidateType?>" id="ohd<?=$tColumnName?><?=$DataTableVal['FNXpdSeqNo']?>" name="ohd<?=$tColumnName?><?=$DataTableVal['FNXpdSeqNo']?>" value="<?= $DataTableVal[$tColumnName] ?>" onfocus="JSxEditInLineSetInputCurrent(this)" data-field="<?=$tColumnName?>"  <?= $tColumnName == 'FTXpdDisChgTxt' ? 'readonly' : '' ?>>
                                                <span class="input-group-btn">
                                                  <button id="oimPOBrowseDisType<?=$DataTableVal['FNXpdSeqNo']?>" type="button" class="btn xCNBtnBrowseAddOn xWPOBrowseDisType">
                                                    <img src="<?php echo  base_url().'/application/modules/common/assets/images/icons/find-24.png'?>">
                                                  </button>
                                                </span>
                                                </div>
                                            <?php endif; ?>
                                          <?php else: ?>
                                              <input type="<?=$InputType?>" class="form-control xCNPdtEditInLine xWValueEditInLine<?=$DataTableVal['FNXpdSeqNo']?> <?=$tValidateType?>" id="ohd<?=$tColumnName?><?=$DataTableVal['FNXpdSeqNo']?>" name="ohd<?=$tColumnName?><?=$DataTableVal['FNXpdSeqNo']?>" maxlength="<?=$tMaxlength?>" value="<?=$DataTableVal[$tColumnName]?>" onfocus="JSxEditInLineSetInputCurrent(this)" onfocusout="JSxEditInLinePdt(this)" data-field="<?=$tColumnName?>"  <?= $tColumnName == 'FTXpdDisChgTxt' ? 'readonly' : '' ?> <?= $tColumnName  == 'FCXpdQty' ||  $tColumnName  == 'FCXpdSetPrice' ? $tDisabledQtyAndSetPrice : '' ?>>
                                              </div>
                                          <?php endif; ?>
                              <?php }else{   ?>
                                      <label class="xCNPdtFont xWShowValue<?=$tColumnName?><?=$DataTableVal['FNXpdSeqNo']?>"><?=$tDataCol?></label>
                                      <input type="<?=$InputType?>" class="xCNHide xWValueEditInLine<?=$DataTableVal['FNXpdSeqNo']?>" id="ohd<?=$tColumnName?><?=$DataTableVal['FNXpdSeqNo']?>" name="ohd<?=$tColumnName?><?=$DataTableVal['FNXpdSeqNo']?>" value="<?=$DataTableVal[$tColumnName]?>" data-field="<?=$tColumnName?>">
                              <?php } ?>
                              
                          </td>
                          
                    <?php } ?>
                    <?php if($tXphStaApv != 1 && $tXphStaDoc != 3){?>
                      <td nowrap class="text-center">
                        <lable class="xCNTextLink">
                          <img class="xCNIconTable" src="<?php echo  base_url().'/application/modules/common/assets/images/icons/delete.png'?>" title="Remove" onclick="JSnRemoveDTRow(this)">
                        </lable>
                      </td>
                      <td nowrap class="text-center">
                        <lable class="xCNTextLink">
                          <img class="xCNIconTable" src="<?php echo  base_url().'/application/modules/common/assets/images/icons/edit.png'?>" title="Edit" onclick="JSnEditDTRow(this)">
                        </lable>
                      </td>
                    <?php } ?>
                    </tr>
                    <?php $nNumSeq++; ?>
                <?php }?>
         <?php else: ?>
                <tr><td class='text-center xCNTextDetail2' colspan='100%'><?= language('common/main/main','tCMNNotFoundData')?></td></tr>
         <?php endif; ?>
         
        </tbody>
      </table>
  </div>


<!-- Modal -->
<div class="modal fade" id="odvShowOrderColumn" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><?= language('common/main/main','tModalAdvTable')?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="odvOderDetailShowColumn">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= language('common/main/main','tModalAdvClose')?></button>
        <button type="button" class="btn btn-primary" onclick="JSxSaveColumnShow()"><?= language('common/main/main','tModalAdvSave')?></button>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="odvModalEditPODisDT">
	<div class="modal-dialog xCNDisModal" style="width:900px;">
		<div class="modal-content">
			<div class="modal-header">

				<!-- <h5 class="modal-title xCNLabelFrm" style="display:inline-block"><label class="xCNLabelFrm"><?= language('document/purchaseorder/purchaseorder','tPODiscount')?></label>  [<label class="xCNLabelFrm" id="ospShowPdtName"> - </label>]</h5> -->
        <label class="xCNTextModalHeard" style="font-weight: bold; font-size: 20px;"><?= language('document/purchaseorder/purchaseorder','tPODiscount')?>[<label class="xCNTextModalHeard" id="ospShowPdtName"> - </label>]</label>

				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                  <label class="xCNLabelFrm"><?= language('document/purchaseorder/purchaseorder','tPODisType')?></label>
                  <select class="selectpicker form-control" id="ostXphDisChgText" name="ostXphDisChgText">
                    <option value="3"><?= language('document/purchaseorder/purchaseorder','tDisChgTxt3')?></option>
                    <option value="4"><?= language('document/purchaseorder/purchaseorder','tDisChgTxt4')?></option>
                    <option value="1"><?= language('document/purchaseorder/purchaseorder','tDisChgTxt1')?></option>
                    <option value="2"><?= language('document/purchaseorder/purchaseorder','tDisChgTxt2')?></option>
                  </select> 
              </div>
            </div>
            <div class="col-md-4">
              <label class="xCNLabelFrm"><?= language('document/purchaseorder/purchaseorder','tPOValue')?></label>
              <input type="text" class="form-control xCNInputNumericWithDecimal" id="oetXddDis" name="oetXddDis" maxlength="11" placeholder="">
            </div>
            <div class="col-md-2">
              <div class="form-group">
                <button type="button" class="btn btn-primary xCNBtnAddDis" onclick="FSvPOAddDTDis();">
                  <label class="xCNLabelAddDis">+</label>
                </button>
              </div>
            </div>
          </div>
        <div id="odvPdtDisListPanal"></div>
				<input type='hidden' id="ohdConfirmIDDelete">
			</div>
		</div>
	</div>
</div>

<!-- div Dropdownbox -->
<div id="dropDownSelect1"></div>
  
<script src="<?php echo  base_url('application/modules/common/assets/js/jquery.mask.js')?>"></script>
<script src="<?php echo  base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>

<script>

  $(document).ready(function(){
      $('.selectpicker').selectpicker();

      $('.xCNDOCPdtItem').click(function(ele){
          tPdtCode = $(this).data('pdtcode');

          $('.xCNDOCPdtItem').removeClass('active');
          $(this).addClass('active');

          JMvDOCGetPdtImgScan(tPdtCode)
      });
  });


  function JSxEditInLineSetInputCurrent(event){
    tPdtCode = $(event).attr('id');
    localStorage.tObjPdtFocus = tPdtCode
    console.log('sss:'+localStorage.tObjPdtFocus)
  }


  function JSxEditInLinePdt(event){

      var tEditSeqNo = $(event).parents().eq(2).attr('data-seqno');
      var tEditPdtCode = $(event).parents().eq(2).attr('data-pdtcode');
      var tEditPunCode = $(event).parents().eq(2).attr('data-puncode');

      var aField = [];
      var aValue = [];

      $(".xWValueEditInLine"+tEditSeqNo).each(function(index){
        tValue = $(this).val();
        tField = $(this).attr('data-field');
        $('.xWShowValue'+tField+tEditSeqNo).text(tValue);
        aField.push(tField);
        aValue.push(tValue);
      });

      FSvPOEditInLinePdtDT(tEditSeqNo,aField,aValue);

  }

  //Function : เพิ่มสินค้าจาก ลง Table ฝั่ง Client
  //Create : 2018-08-28 Krit(Copter)
  function FSvPOEditInLinePdtDT(ptEditSeqNo,paField,paValue){

    ptXphDocNo = $('#oetXphDocNo').val();

    $.ajax({
        type: "POST",
        url: "POEditPdtIntoTableDT",
        data: { 
                ptXphDocNo : ptXphDocNo,
                ptEditSeqNo : ptEditSeqNo,
                paField     : paField,
                paValue     : paValue
        },
        cache: false,
        timeout: 5000,
        success: function(tResult){

          JSvPOLoadEditInLinePdtDT(ptEditSeqNo);

        },
        error: function(data) {
            console.log(data);
        }
    });
  }


  	//Function : Gen  Html มาแปะ ในหน้า App Po
	function JSvPOLoadEditInLinePdtDT(ptEditSeqNo){

    tXphDocNo = $('#oetXphDocNo').val();

    $.ajax({
        type: "POST",
        url: "POPdtAdvanceTableLoadData",
        data: { 
                tXphDocNo : tXphDocNo,
                ptEditSeqNo:ptEditSeqNo
              },
        cache: false,
        Timeout: 0,
        success: function(tResult) {
            //GET Value New
            $('#odvPdtTablePanalDataHide').html(tResult);
            FCXpdCostEx     = $('#odvPdtTablePanalDataHide #ohdFCXpdCostEx'+ptEditSeqNo).val();
            FCXpdCostIn     = $('#odvPdtTablePanalDataHide #ohdFCXpdCostIn'+ptEditSeqNo).val();
            FCXpdFactor     = $('#odvPdtTablePanalDataHide #ohdFCXpdFactor'+ptEditSeqNo).val();
            FCXpdNet        = $('#odvPdtTablePanalDataHide #ohdFCXpdNet'+ptEditSeqNo).val();
            FCXpdAmt        = $('#odvPdtTablePanalDataHide #ohdFCXpdAmt'+ptEditSeqNo).val();
            FCXpdDisChgAvi  = $('#odvPdtTablePanalDataHide #ohdFCXpdDisChgAvi'+ptEditSeqNo).val();
            FCXpdNetAfHD    = $('#odvPdtTablePanalDataHide #ohdFCXpdNetAfHD'+ptEditSeqNo).val();
            FCXpdNetEx      = $('#odvPdtTablePanalDataHide #ohdFCXpdNetEx'+ptEditSeqNo).val();
            FCXpdQtyAll     = $('#odvPdtTablePanalDataHide #ohdFCXpdQtyAll'+ptEditSeqNo).val();
            FCXpdQtyLef     = $('#odvPdtTablePanalDataHide #ohdFCXpdQtyLef'+ptEditSeqNo).val();
            FCXpdQtyRfn     = $('#odvPdtTablePanalDataHide #ohdFCXpdQtyRfn'+ptEditSeqNo).val();
            FCXpdSalePrice  = $('#odvPdtTablePanalDataHide #ohdFCXpdSalePrice'+ptEditSeqNo).val();
            FCXpdStkFac     = $('#odvPdtTablePanalDataHide #ohdFCXpdStkFac'+ptEditSeqNo).val();
            FCXpdVatable    = $('#odvPdtTablePanalDataHide #ohdFCXpdVatable'+ptEditSeqNo).val();
            FCXpdVatRate    = $('#odvPdtTablePanalDataHide #ohdFCXpdVatRate'+ptEditSeqNo).val();
            FCXpdVat        = $('#odvPdtTablePanalDataHide #ohdFCXpdVat'+ptEditSeqNo).val();
            FCXpdWhtRate    = $('#odvPdtTablePanalDataHide #ohdFCXpdWhtRate'+ptEditSeqNo).val();
            FCXpdWhtAmt     = $('#odvPdtTablePanalDataHide #ohdFCXpdWhtAmt'+ptEditSeqNo).val();
            FTPunCode       = $('#odvPdtTablePanalDataHide #ohdFTPunCode'+ptEditSeqNo).val();
            FTSrnCode       = $('#odvPdtTablePanalDataHide #ohdFTSrnCode'+ptEditSeqNo).val();
            FTVatCode       = $('#odvPdtTablePanalDataHide #ohdFTVatCode'+ptEditSeqNo).val();
            FTXpdRmk        = $('#odvPdtTablePanalDataHide #ohdFTXpdRmk'+ptEditSeqNo).val();
            FTXpdStkCode    = $('#odvPdtTablePanalDataHide #ohdFTXpdStkCode'+ptEditSeqNo).val();
            FTXpdVatType    = $('#odvPdtTablePanalDataHide #ohdFTXpdVatType'+ptEditSeqNo).val();
            FTXpdWhtCode    = $('#odvPdtTablePanalDataHide #ohdFTXpdWhtCode'+ptEditSeqNo).val();

            $('#odvPdtTablePanalDataHide').html('');

            //Set New Value
            //FCXpdCostEx
            $('.xWShowValueFCXpdCostEx'+ptEditSeqNo).text(FCXpdCostEx);
            $('#ohdFCXpdCostEx'+ptEditSeqNo).val(FCXpdCostEx);
            //FCXpdCostIn
            $('.xWShowValueFCXpdCostIn'+ptEditSeqNo).text(FCXpdCostIn);
            $('#ohdFCXpdCostIn'+ptEditSeqNo).val(FCXpdCostIn);
            //FCXpdFactor
            $('.xWShowValueFCXpdFactor'+ptEditSeqNo).text(FCXpdFactor);
            $('#ohdFCXpdFactor'+ptEditSeqNo).val(FCXpdFactor);
            //FCXpdNet
            $('.xWShowValueFCXpdNet'+ptEditSeqNo).text(FCXpdNet);
            $('#ohdFCXpdNet'+ptEditSeqNo).val(FCXpdNet);
            //FCXpdAmt
            $('.xWShowValueFCXpdAmt'+ptEditSeqNo).text(FCXpdAmt);
            $('#ohdFCXpdAmt'+ptEditSeqNo).val(FCXpdAmt);
            //FCXpdDisChgAvi
            $('.xWShowValueFCXpdDisChgAvi'+ptEditSeqNo).text(FCXpdDisChgAvi);
            $('#ohdFCXpdDisChgAvi'+ptEditSeqNo).val(FCXpdDisChgAvi);
            //FCXpdNetAfHD
            $('.xWShowValueFCXpdNetAfHD'+ptEditSeqNo).text(FCXpdNetAfHD);
            $('#ohdFCXpdNetAfHD'+ptEditSeqNo).val(FCXpdNetAfHD);
            //FCXpdNetEx
            $('.xWShowValueFCXpdNetEx'+ptEditSeqNo).text(FCXpdNetEx);
            $('#ohdFCXpdNetEx'+ptEditSeqNo).val(FCXpdNetEx);
            //FCXpdQtyAll
            $('.xWShowValueFCXpdQtyAll'+ptEditSeqNo).text(FCXpdQtyAll);
            $('#ohdFCXpdQtyAll'+ptEditSeqNo).val(FCXpdQtyAll);
            //FCXpdQtyLef
            $('.xWShowValueFCXpdQtyLef'+ptEditSeqNo).text(FCXpdQtyLef);
            $('#ohdFCXpdQtyLef'+ptEditSeqNo).val(FCXpdQtyLef);
            //FCXpdQtyRfn
            $('.xWShowValueFCXpdQtyRfn'+ptEditSeqNo).text(FCXpdQtyRfn);
            $('#ohdFCXpdQtyRfn'+ptEditSeqNo).val(FCXpdQtyRfn);
            //FCXpdSalePrice
            $('.xWShowValueFCXpdSalePrice'+ptEditSeqNo).text(FCXpdSalePrice);
            $('#ohdFCXpdSalePrice'+ptEditSeqNo).val(FCXpdSalePrice);
            //FCXpdStkFac
            $('.xWShowValueFCXpdStkFac'+ptEditSeqNo).text(FCXpdStkFac);
            $('#ohdFCXpdStkFac'+ptEditSeqNo).val(FCXpdStkFac);
            //FCXpdVatable
            $('.xWShowValueFCXpdVatable'+ptEditSeqNo).text(FCXpdVatable);
            $('#ohdFCXpdVatable'+ptEditSeqNo).val(FCXpdVatable);
            //FCXpdVatRate
            $('.xWShowValueFCXpdVatRate'+ptEditSeqNo).text(FCXpdVatRate);
            $('#ohdFCXpdVatRate'+ptEditSeqNo).val(FCXpdVatRate);
            //FCXpdVat
            $('.xWShowValueFCXpdVat'+ptEditSeqNo).text(FCXpdVat);
            $('#ohdFCXpdVat'+ptEditSeqNo).val(FCXpdVat);
            //FCXpdWhtRate
            $('.xWShowValueFCXpdWhtRate'+ptEditSeqNo).text(FCXpdWhtRate);
            $('#ohdFCXpdWhtRate'+ptEditSeqNo).val(FCXpdWhtRate);
            //FCXpdWhtAmt
            $('.xWShowValueFCXpdWhtAmt'+ptEditSeqNo).text(FCXpdWhtAmt);
            $('#ohdFCXpdWhtAmt'+ptEditSeqNo).val(FCXpdWhtAmt);
            //FTPunCode
            $('.xWShowValueFTPunCode'+ptEditSeqNo).text(FTPunCode);
            $('#ohdFTPunCode'+ptEditSeqNo).val(FTPunCode);
            //FTSrnCode
            $('.xWShowValueFTSrnCode'+ptEditSeqNo).text(FTSrnCode);
            $('#ohdFTSrnCode'+ptEditSeqNo).val(FTSrnCode);
            //FTVatCode
            $('.xWShowValueFTVatCode'+ptEditSeqNo).text(FTVatCode);
            $('#ohdFTVatCode'+ptEditSeqNo).val(FTVatCode);
            //FTXpdRmk
            $('.xWShowValueFTXpdRmk'+ptEditSeqNo).text(FTXpdRmk);
            $('#ohdFTXpdRmk'+ptEditSeqNo).val(FTXpdRmk);
            //FTXpdStkCode
            $('.xWShowValueFTXpdStkCode'+ptEditSeqNo).text(FTXpdStkCode);
            $('#ohdFTXpdStkCode'+ptEditSeqNo).val(FTXpdStkCode);
            //FTXpdVatType
            $('.xWShowValueFTXpdVatType'+ptEditSeqNo).text(FTXpdVatType);
            $('#ohdFTXpdVatType'+ptEditSeqNo).val(FTXpdVatType);
            //FTXpdWhtCode
            $('.xWShowValueFTXpdWhtCode'+ptEditSeqNo).text(FTXpdWhtCode);
            $('#ohdFTXpdWhtCode'+ptEditSeqNo).val(FTXpdWhtCode);

            //Load HDDis Table Panal และ Modal
            JSvPOCallGetHDDisTableData();

            JCNxCloseLoading();
        },
        error: function(jqXHR, textStatus, errorThrown) {
        }
    });

  }

  $('.xWPOBrowseDisType').click(function(ele){

        var nKey   = $(this).parents().eq(4).attr('data-index');
        var tDocNo   = $('#oetXphDocNo').val();
        var tPdtName = $(this).parents().eq(4).attr('data-pdtname');
        var nSeqNo = $(this).parents().eq(4).attr('data-seqno');


            $('#ospShowPdtName').text(tPdtName);
            $('#odvModalEditPODisDT').modal('show');
        
        JSvPOCallGetDTDisTableData(nKey,tDocNo,nSeqNo);

  });

  function JSvPOCallGetDTDisTableData(pnKey,ptDocNo,pnSeqNo){
    
                $.ajax({
                type: "POST",
                url: "POGetDTDisTableData",
                data: { 'nKey'    : pnKey,
                        'tDocNo'  : ptDocNo,
                        'nSeqNo'  : pnSeqNo
                },
                cache: false,
                success: function(tResult) {
                  
                  $('#odvPdtDisListPanal').html(tResult);

                  //Load HDDis Table Panal แลt Modal
                  JSvPOCallGetHDDisTableData();

                },
                error: function(jqXHR, textStatus, errorThrown) {
                    (jqXHR, textStatus, errorThrown);
                }
            });

  }

  function FSvPOAddDTDis(){

    tDisChgText = $('#ostXphDisChgText').val();
    cXddDis     = $('#oetXddDis').val();
    ptXphDocNo  = $('#oetXphDocNo').val();
    ptBchCode   = $('#ohdSesUsrBchCode').val();
    pnKey       = $('#ohdnKey').val();
    ptSeqNo     = $('#ohdSeqNo').val();
    ptXpdSeqNo  = $('#ohdXpdSeqNo').val();
    
    ptXpdDisChgAvi   = $('#ohdXpdDisChgAvi').val();

    nPlusOld = '';
    nPercentOld = '';
    tPlusNew = '';
    nPercentNew = '';
    tOldDisDTChgLength = '';

    if(tDisChgText == 1 || tDisChgText == 2){
      tPlusNew = '+';
    }
    if(tDisChgText == 2 || tDisChgText == 4){
		  nPercentNew = '%';
	  }

    //หา length ที่มีอยู่ ของ HD
    $('.xWAlwEditXpdDTDisChgValue').each(function(e){
      nDistypeOld = $(this).data('distype');
      if(nDistypeOld == 1 || nDistypeOld == 2){
        nPlusOld = '+';
      }
      if(nDistypeOld == 2 || nDistypeOld == 4){
        nPercentOld = '%';
      }
      tOldDisDTChgLength += nPlusOld+$(this).text()+nPercentOld+','
    });
    tNewDisDTChgLength = tPlusNew+accounting.formatNumber(cXddDis, nOptDecimalSave,"")+nPercentNew;
    //เอาทั้งสองมาต่อกัน
    tCurDisDTChgLength = tOldDisDTChgLength+tNewDisDTChgLength
    //หาจำนวนตัวอักษร
    nCurDisDTChgLength = tCurDisDTChgLength.length;

    if(cXddDis == ''){
      $('#oetXddDis').focus();
    }else{
      //Check ขนาดของ Text DisChgText
      if(nCurDisDTChgLength <= 20){
        $.ajax({
          type: "POST",
          url: "POAddDTDisIntoTable",
          data: {
                  ptXphDocNo  : ptXphDocNo,
                  ptBchCode   : ptBchCode,
                  pnKey       : pnKey,
                  ptXpdSeqNo  : ptXpdSeqNo,
                  ptXpdDisChgAvi : ptXpdDisChgAvi,
                  tDisChgText : tDisChgText,
                  cXddDis     : cXddDis
          },
          cache: false,
          timeout: 5000,
          success: function(tResult){
              
              JSvPOCallGetDTDisTableData(pnKey,ptXphDocNo,ptSeqNo);

          },
          error: function(data) {
              console.log(data);
          }
        });
      }else{
        alert('ไม่สามารถเพิ่มได้ จำนวนขนาดเกิน 20');
      }
    }


    
  }

  
</script>


