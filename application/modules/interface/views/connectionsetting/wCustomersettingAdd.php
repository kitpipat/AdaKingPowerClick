<?php
//Array ( [raItems] => Array ( [0] => Array ( [FTBchCode] => 00000 [FTCbrSoldTo] => CS00001 [FTCbrShipTo] => [FTCbrRemark] => [FTBchName] => King Power(HQ) ) ) [rtCode] => 1 [rtDesc] => success )
if($aCustomerLis['rtCode'] == "1"){
     $tBchCode          =   $aCustomerLis['raItems'][0]['FTBchCode'];
     $tCusCode          =   $aCustomerLis['raItems'][0]['FTCbrSoldTo'];
     $tBchName          =   $aCustomerLis['raItems'][0]['FTBchName'];
     $tChnCode          =   $aCustomerLis['raItems'][0]['FTChnCode'];
     $tChnName          =   $aCustomerLis['raItems'][0]['FTChnName'];
     $tRoute            = "connectionsettingEventEdit";
     $tSattusBrows      = "disabled";
     $tDisabledChn      = "disabled";
}else{
    $tBchCode           =  "";
    $tCusCode           =  "";
    $tBchName           =  "";
    $tChnCode           =  "";
    $tChnName           =  "";
  	$tRoute             = "connectionsettingEventAdd";
    $tSattusBrows       = "";
    $tDisabledChn       = "disabled";
}
?>


<div class="row">
    <!--ปุ่มตัวเลือก กับ ปุ่มเพิ่ม-->
    <div class="col-lg-12 col-md-12 col-xs-12   text-right">
        <button type="button" onclick="JSxCallGetContent();" id="obtGpShopCancel" class="btn" style="background-color: #D4D4D4; color: #000000;">
            <?php echo language('company/shopgpbypdt/shopgpbypdt', 'tSGPPBTNCancel')?>
        </button>
        <?php if($aAlwEvent['tAutStaFull'] == 1 || ($aAlwEvent['tAutStaAdd'] == 1 || $aAlwEvent['tAutStaEdit'] == 1)) : ?>
                <button type="submit" class="btn" style="background-color: rgb(23, 155, 253); color: white;"  onclick="$('#obtSubmitConnectionSetting').click()"> <?php echo  language('common/main/main', 'tSave')?></button>
        <?php endif; ?>
    </div>

<div class="col-lg-12 col-md-12 col-xs-12">
	<div class="col-xs-5 col-sm-5 col-md-5 col-lg-5">
        <form id="ofmAddConnectionSetting" class="validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data">
            <button style="display:none" type="submit" id="obtSubmitConnectionSetting" onclick="JSnAddEditConnectionSetting('<?php echo $tRoute; ?>')"></button>

                <div class="form-group">
                    <label class="xCNLabelFrm"><span style="color:red">*</span><?php echo language('company/branch/branch','tBCHTitle')?></label>
                    <div class="input-group">
                        <input
                            type="text"
                            class="form-control xCNHide xCNInputWithoutSpcNotThai xCNInputWithoutSingleQuote"
                            id="oetCssBchCode"
                            name="oetCssBchCode"
                            maxlength="5"
                            value="<?php echo $tBchCode; ?>">
                        <input
                            type="text"
                            class="form-control xWPointerEventNone"
                            id="oetCssBchName"
                            name="oetCssBchName"
                            maxlength="100"
                            placeholder="<?php echo language('interface/connectionsetting/connectionsetting','tTBBanch')?>" value="<?php echo $tBchName; ?>"
                            data-validate-required = "<?php echo language('interface/connectionsetting/connectionsetting','tValiBanch')?>"
                            readonly
                        >
                        <span class="input-group-btn">
                            <button id="oimBrowseBch" type="button" class="btn xCNBtnBrowseAddOn" <?php echo $tSattusBrows; ?>>
                                <img src="<?php echo  base_url().'/application/modules/common/assets/images/icons/find-24.png'?>">
                            </button>
                        </span>
                    </div>
                </div>

                <div class="form-group">
                    <label class="xCNLabelFrm"><span style="color:red">*</span><?php echo language('pos/poschannel/poschannel','tCHNTitle')?></label>
                    <div class="input-group">
                        <input
                            type="text"
                            class="form-control xCNHide xCNInputWithoutSpcNotThai xCNInputWithoutSingleQuote"
                            id="oetCssChnCode"
                            name="oetCssChnCode"
                            maxlength="5"
                            value="<?=$tChnCode?>">
                        <input
                            type="text"
                            class="form-control xWPointerEventNone"
                            id="oetCssChnName"
                            name="oetCssChnName"
                            maxlength="100"
                            placeholder="<?php echo language('pos/poschannel/poschannel','tCHNTitle')?>" value="<?=$tChnName?>"
                            data-validate-required = "กรุณาเลือกช่องทางการขาย"
                            readonly
                        >
                        <span class="input-group-btn">
                            <button id="obtBrowseChn" type="button" class="btn xCNBtnBrowseAddOn" <?php echo $tDisabledChn; ?>>
                                <img src="<?php echo  base_url().'/application/modules/common/assets/images/icons/find-24.png'?>">
                            </button>
                        </span>
                    </div>
                </div>

                <div class="form-group">
                    <label class="xCNLabelFrm"><span style="color:red">*</span><?php echo language('interface/connectionsetting/connectionsetting','tTABthCustomer')?></label>
                        <input type="text" class="form-control"
                        id="oetCssCustomer" name="oetCssCustomer" maxlength="100" value="<?=$tCusCode;?>"
                        data-validate-required = "<?php echo language('interface/connectionsetting/connectionsetting','tTABthCustomerrequired')?>"
                        >
                </div>

        </form>
    </div>
</div>


<script src="<?php echo base_url('application/modules/common/assets/js/jquery.mask.js')?>"></script>
<script src="<?php echo base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>
<script type="text/javascript">

    $('#obtBrowseChn').off('click').on('click',function(e){
        e.preventDefault();
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSxCheckPinMenuClose();
            window.oBrowseChannelOption = oBrowseChn({
                'tReturnInputCode'  : 'oetCssChnCode',
                'tReturnInputName'  : 'oetCssChnName',
                'tBchCondition'     : $('#oetCssBchCode').val()
            });
            JCNxBrowseData('oBrowseChannelOption');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    var oBrowseChn = function(poReturnInput){
        var tInputReturnCode    = poReturnInput.tReturnInputCode;
        var tInputReturnName    = poReturnInput.tReturnInputName;
        var tBchCode            = poReturnInput.tBchCondition;

        var oOptionReturn = {
            Title   : ['pos/poschannel/poschannel','tCHNTitle'],
            Table   :{Master:'TCNMChannel',PK:'FTChnCode'},
            Join :{
                Table   : ['TCNMChannel_L','TLKMMapping','TLKMCstBch'],
                On      : [
                    'TCNMChannel.FTChnCode = TCNMChannel_L.FTChnCode AND TCNMChannel_L.FNLngID = ' + nLangEdits,
                    'TCNMChannel.FTChnRefCode = TLKMMapping.FNMapSeqNo',
                    "TLKMCstBch.FTBchCode = '"+tBchCode+"' AND TLKMCstBch.FTChnCode = TCNMChannel.FTChnCode",
                ]
            },
            Where:{
                Condition : [" AND TLKMMapping.FTMapCode = 'tChnDelivery' AND TLKMMapping.FNMapSeqNo IS NOT NULL AND TLKMCstBch.FTBchCode IS NULL"]
            },
            GrideView:{
                ColumnPathLang	: 'pos/poschannel/poschannel',
                ColumnKeyLang	: ['tCHNLabelChannelCode','tCHNLabelChannelName'],
                ColumnsSize     : ['15%','75%'],
                DataColumns		: ['TCNMChannel.FTChnCode','TCNMChannel_L.FTChnName'],
                DataColumnsFormat : ['',''],
                // DisabledColumns: [2, 3],
                WidthModal      : 50,
                Perpage			: 10,
                OrderBy			: ['TCNMChannel.FDCreateOn DESC'],
            },
            CallBack:{
                ReturnType	: 'S',
                Value		: [tInputReturnCode,"TCNMChannel.FTChnCode"],
                Text		: [tInputReturnName,"TCNMChannel_L.FTChnName"],
            },
            // RouteAddNew : 'channel',
            // BrowseLev : 1
            // DebugSQL: true,
        }
        return oOptionReturn;
    }


  $('#oimBrowseBch').click(function(e){
      e.preventDefault();
      var nStaSession = JCNxFuncChkSessionExpired();
      if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
          JSxCheckPinMenuClose();
          window.oBrowseBranchOption = oBrowseBch({
              'tReturnInputCode'  : 'oetCssBchCode',
              'tReturnInputName'  : 'oetCssBchName',
              'tAgnCodeWhere'     : $('#oetCssAgnCode').val(),
          });
          JCNxBrowseData('oBrowseBranchOption');
      }else{
          JCNxShowMsgSessionExpired();
      }
  });
  var oBrowseBch       = function(poReturnInput){
      var tInputReturnCode    = poReturnInput.tReturnInputCode;
      var tInputReturnName    = poReturnInput.tReturnInputName;
      var tAgnCodeWhere       = poReturnInput.tAgnCodeWhere;

      $nCountBCH = '<?=$this->session->userdata('nSesUsrBchCount')?>';

      if($nCountBCH > 1){
          //ถ้าสาขามากกว่า 1
          tBCH        = "<?=$this->session->userdata('tSesUsrBchCodeMulti');?>";
          tWhereBCH   = " AND TCNMBranch.FTBchCode IN ( " + tBCH + " ) ";
      }else{
          tWhereBCH   = '';
      }

      if(tAgnCodeWhere == '' || tAgnCodeWhere == null){
          tWhereAgn   = '';
      }else{
          tWhereAgn   = " AND TCNMBranch.FTAgnCode = '"+tAgnCodeWhere+"'";
      }

    //   var tWhere   = "AND TLKMCstBch.FTBchCode IS NULL";
      var oOptionReturn       = {
          Title   : ['company/branch/branch','tBCHTitle'],
          Table   :{Master:'TCNMBranch',PK:'FTBchCode'},
          Join :{
              Table   :	['TCNMBranch_L','TCNMAgency_L'/*,'TLKMCstBch'*/],
              On      :   [
                  'TCNMBranch_L.FTBchCode = TCNMBranch.FTBchCode AND TCNMBranch_L.FNLngID = '+ nLangEdits,
                  'TCNMAgency_L.FTAgnCode = TCNMBranch.FTAgnCode AND TCNMAgency_L.FNLngID = '+ nLangEdits,
                  /*'TLKMCstBch.FTBchCode = TCNMBranch.FTBchCode AND TCNMBranch_L.FNLngID = '+ nLangEdits,*/
          ]
          },
          Where:{
              Condition : [tWhereBCH+tWhereAgn] /*tWhere*/
          },
          GrideView:{
              ColumnPathLang	: 'company/branch/branch',
              ColumnKeyLang	: ['tBCHCode','tBCHName'],
              ColumnsSize     : ['15%','75%'],
              DataColumns		: ['TCNMBranch.FTBchCode','TCNMBranch_L.FTBchName','TCNMAgency_L.FTAgnName','TCNMBranch.FTAgnCode'],
              DataColumnsFormat : ['','','',''],
              DisabledColumns: [2, 3],
              WidthModal      : 50,
              Perpage			: 10,
              OrderBy			: ['TCNMBranch.FDCreateOn DESC'],
          },
          CallBack:{
              ReturnType	: 'S',
              Value		: [tInputReturnCode,"TCNMBranch.FTBchCode"],
              Text		: [tInputReturnName,"TCNMBranch_L.FTBchName"],
          },
          NextFunc:{
              FuncName    : 'JSxCSTBranchNextFunc',
              ArgReturn   : ['FTBchCode']
          },
          RouteAddNew : 'branch',
          BrowseLev : 1
      }
      return oOptionReturn;
  }

  function JSxCSTBranchNextFunc(ptObj){
    if( ptObj != "NULL" ){
        $('#obtBrowseChn').attr('disabled',false);
    }else{
        $('#obtBrowseChn').attr('disabled',true);
    }
  }

  function JSnAddEditConnectionSetting(ptRoute) {
      var nStaSession = JCNxFuncChkSessionExpired();
      var tBchCode   = $('#oetCssBchCode').val();

      if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
          $('#ofmAddConnectionSetting').validate().destroy();
          $('#ofmAddConnectionSetting').validate({
              rules: {

                  oetCssCustomer    : { "required": {} },
                  oetCssBchName     : { "required": {} },
                  oetCssChnName     : { "required": {} },

              },
              messages: {
                  oetCssCustomer: {
                      "required"      :      $('#oetCssCustomer').attr('data-validate-required'),
                  },
                  oetCssBchName: {
                      "required"      :      $('#oetCssBchName').attr('data-validate-required'),
                  },
                  oetCssChnName: {
                        "required"    :      $('#oetCssChnName').attr('data-validate-required'),
                  },
              },
              errorElement: "em",
              errorPlacement: function(error, element) {
                  error.addClass("help-block");
                  if (element.prop("type") === "checkbox") {
                      error.appendTo(element.parent("label"));
                  } else {
                      var tCheck = $(element.closest('.form-group')).find('.help-block').length;
                      if (tCheck == 0) {
                          error.appendTo(element.closest('.form-group')).trigger('change');
                      }
                  }
              },
              highlight: function(element, errorClass, validClass) {
                  $(element).closest('.form-group').addClass("has-error").removeClass("has-success");
              },
              unhighlight: function(element, errorClass, validClass) {
                  $(element).closest('.form-group').addClass("has-success").removeClass("has-error");
              },
              submitHandler: function(form) {
                  $.ajax({
                      type: "POST",
                      url: "CustomernSettingEventAdd",
                      data: $('#ofmAddConnectionSetting').serialize(),
                      cache: false,
                      timeout: 0,
                      success: function(tResult) {
                          JSxCallGetContent();
                      },
                      error: function(jqXHR, textStatus, errorThrown) {
                          JCNxResponseError(jqXHR, textStatus, errorThrown);
                      }
                  });
              },
          });
      }
  }
</script>
