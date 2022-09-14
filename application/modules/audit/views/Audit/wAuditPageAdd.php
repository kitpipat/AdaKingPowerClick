<?php
if (isset($aData) && count($aData)>0) {
  $tAudCodeFrm = $aData[0]['FTAgnFrm'];
  $tAudNameFrm = $aData[0]['FTAgnNameFrm'];
  $tAudCodeTo = $aData[0]['FTAgnTo'];
  $tAudNameTo = $aData[0]['FTAgnNameTo'];
  $tFTAgnRefCode = $aData[0]['FTAgnRefCode'];
  $tStatusBro = "hidden";
}else {
  $tAudCodeFrm = "";
  $tAudNameFrm = "";
  $tAudCodeTo = "";
  $tAudNameTo = "";
  $tStatusBro = "";
  $tFTAgnRefCode = "";
}
if ($this->session->userdata('tSesUsrLevel') != "HQ") {
   $tAudCodeFrm =$this->session->userdata('tSesUsrAgnCode');
   $tAudNameFrm = $this->session->userdata('tSesUsrAgnName');
}

?>
<input type="hidden" name="oetFTAgnRefCode"  id="oetFTAgnRefCode" value="<?php echo $tFTAgnRefCode; ?>">
<div class="panel panel-headline">
  <div class="panel-body">
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
      <div class="row">
        <div class="form-group" >
         <label class="xCNLabelFrm"><?= language('audit/audit/audit','tAUDTitleBankForm')?></label>
         <?php if ($this->session->userdata('tSesUsrLevel') != "HQ") {  ?>
             <input type="text" class="form-control xCNHide" id="oetAudCode" name="oetAudCode" value="<?php echo $tAudCodeFrm; ?>">
             <input type="text" class="form-control xWPointerEventNone" readonly id="oetAudName" name="oetAudName" value="<?php echo $tAudNameFrm; ?>"  placeholder="<?= language('audit/audit/audit','tAUDTitleBankForm')?>">
         <?php }else{ ?>

           <?php if ($tAudCodeFrm=="") { ?>
             <div class="input-group">
               <input type="text" class="form-control xCNHide" id="oetAudCode" name="oetAudCode" value="<?php echo $tAudCodeFrm; ?>">
               <input type="text" class="form-control xWPointerEventNone" readonly id="oetAudName" name="oetAudName"  value="<?php echo $tAudNameFrm; ?>"  placeholder="<?= language('audit/audit/audit','tAUDTitleBankForm')?>">
               <span class="input-group-btn">
                <button  id="oimAUDBrowseF" type="button" class="btn xCNBtnBrowseAddOn"><img class="xCNIconFind"></button>
               </span>
             </div>
           <?php }else { ?>
             <input type="text" class="form-control xCNHide" id="oetAudCode" name="oetAudCode" value="<?php echo $tAudCodeFrm; ?>">
             <input type="text" class="form-control xWPointerEventNone" id="oetAudName" name="oetAudName"  value="<?php echo $tAudNameFrm; ?>"  readonly="" placeholder="<?= language('audit/audit/audit','tAUDTitleBankForm')?>">
           <?php } ?>
         <?php } ?>
        </div>
      </div>
      <div class="row">
        <div class="form-group">
         <label class="xCNLabelFrm"><?= language('audit/audit/audit','tAUDTitleBankTo')?></label>
          <div class="input-group">
            <input type="text" class="form-control xCNHide" id="oetAudCodeT" name="" value="<?php echo $tAudCodeTo; ?>">
            <input type="text" class="form-control xWPointerEventNone" id="oetAudNameT" name="" value="<?php echo $tAudNameTo; ?>" readonly="" placeholder="<?= language('audit/audit/audit','tAUDTitleBankTo')?>">
            <span class="input-group-btn">
              <button id="oimAUDBrowseT" type="button" class="btn xCNBtnBrowseAddOn"><img class="xCNIconFind"></button>
            </span>
          </div>
        </div>
      </div>
  	</div>
  </div>
</div>
<script type="text/javascript">
var nLang = '<?php echo $this->session->userdata("tLangID");?>';
var oAudBrowsePplF = {
    Title : ['audit/audit/audit', 'tAUDTitleBrowse'],
    Table:{Master:'TCNMAgency', PK:'FTAgnCode'},
    Join :{
        Table:	['TCNMAgency_L'],
        On:[' TCNMAgency.FTAgnCode = TCNMAgency_L.FTAgnCode AND TCNMAgency_L.FNLngID = ' + nLang]
    },
    Where :{
         Condition : ["AND TCNMAgency.FTAgnRefCode !='' "]
    },
    GrideView:{
        ColumnPathLang	: 'audit/audit/audit',
        ColumnKeyLang	: ['tFTAgnCodeBrowse', 'tFTAgnNameBrowse', 'tAudAgnRefCode'],
        ColumnsSize     : ['15%', '70%', '15%'],
        WidthModal      : 50,
        DataColumns		: ['TCNMAgency.FTAgnCode', 'TCNMAgency_L.FTAgnName','TCNMAgency.FTAgnRefCode'],
        DataColumnsFormat : ['', '', ''],
        Perpage			: 10,
        OrderBy			: ['TCNMAgency.FTAgnCode DESC'],
    },
    CallBack:{
        ReturnType	: 'S', //S singel //m multi
        Value		: ["oetAudCode", "TCNMAgency.FTAgnCode"],
        Text		: ["oetAudName", "TCNMAgency_L.FTAgnName"]
    },
    NextFunc:{
        FuncName:'JSxAUDBrowseB',
        ArgReturn:['FTAgnRefCode']
    },
};
//var tFTAgnRefCode = $("#oetFTAgnRefCode").val();

var oAudBrowsePplT = function(poReturninput){
  let tRefCode = poReturninput.tFTAgnRefCode;
  let tAgnCode = poReturninput.tFTAgnCode;
  let oBrowsePplTReturn = {
      Title : ['audit/audit/audit', 'tAUDTitleBrowse'],
      Table:{Master:'TCNMAgency', PK:'FTAgnCode'},
      Join :{
          Table:	['TCNMAgency_L'],
          On:[' TCNMAgency.FTAgnCode = TCNMAgency_L.FTAgnCode AND TCNMAgency_L.FNLngID = ' + nLang]
      },
      Where :{
           Condition : ["AND TCNMAgency.FTAgnRefCode ='"+tRefCode+"' AND TCNMAgency.FTAgnRefCode !=''  AND TCNMAgency.FTAgnCode != '"+tAgnCode+"'"]
      },
      GrideView:{
          ColumnPathLang	: 'audit/audit/audit',
          ColumnKeyLang	: ['tFTAgnCodeBrowse', 'tFTAgnNameBrowse'],
          ColumnsSize     : ['15%', '85%'],
          WidthModal      : 50,
          DataColumns		: ['TCNMAgency.FTAgnCode', 'TCNMAgency_L.FTAgnName'],
          DataColumnsFormat : ['', ''],
          Perpage			: 10,
          OrderBy			: ['TCNMAgency.FTAgnCode DESC'],
      },
      CallBack:{
          ReturnType	: 'S', //S singel //m multi
          Value		: ["oetAudCodeT", "TCNMAgency.FTAgnCode"],
          Text		: ["oetAudNameT", "TCNMAgency_L.FTAgnName"]
      }
  }
  return oBrowsePplTReturn;
}
function JSxAUDBrowseB(paData) {
  $("#oetAudCodeT").val("");
  $("#oetAudNameT").val("");
  var tAgnRefCode = "";
  if (typeof(paData) != 'undefined' && paData != "NULL") {
    var aDataNextFunc = JSON.parse(paData);
    tAgnRefCode = aDataNextFunc[0];
  }
  $("#oetFTAgnRefCode").val(tAgnRefCode);
}
$('#oimAUDBrowseF').click(function(){
    JSxCheckPinMenuClose();
    JCNxBrowseData('oAudBrowsePplF');
});
$('#oimAUDBrowseT').click(function(){
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
      window.oAudBrowsePplTOption = undefined;
      oAudBrowsePplTOption = oAudBrowsePplT({
         'tFTAgnRefCode' : $("#oetFTAgnRefCode").val(),
         'tFTAgnCode' : $("#oetAudCode").val()
      });
      var tAudCode = $("#oetAudCode").val();
      if (tAudCode=="") {
         alert('เลือกบัญชีต้นทางก่อน');
      }else {
         JCNxBrowseData('oAudBrowsePplTOption');
      }
    }else {
      JCNxShowMsgSessionExpired();
    }
});

</script>
