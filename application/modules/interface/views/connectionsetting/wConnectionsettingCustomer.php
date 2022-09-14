
<style>
    .xCNIconContentAPI  {  width:15px; height:15px; background-color:#e84393; display: inline-block; margin-right: 10px; margin-top: 0px; }
    .xCNIconContentDOC  {  width:15px; height:15px; background-color:#ffca28; display: inline-block; margin-right: 10px; margin-top: 0px; }
    .xCNIconContentPOS  {  width:15px; height:15px; background-color:#42a5f5; display: inline-block; margin-right: 10px; margin-top: 0px; }
    .xCNIconContentSL   {  width:15px; height:15px; background-color:#ff9030; display: inline-block; margin-right: 10px; margin-top: 0px; }
    .xCNIconContentWEB  {  width:15px; height:15px; background-color:#99cc33; display: inline-block; margin-right: 10px; margin-top: 0px; }
    .xCNIconContentVD   {  width:15px; height:15px; background-color:#dbc559; display: inline-block; margin-right: 10px; margin-top: 0px; }
    .xCNIconContentALL  {  width:15px; height:15px; background-color:#ff5733; display: inline-block; margin-right: 10px; margin-top: 0px; }
    .xCNIconContentETC  {  width:15px; height:15px; background-color:#92918c; display: inline-block; margin-right: 10px; margin-top: 0px; }

    .xCNTableScrollY{
        overflow-y      : auto;
    }

    .xCNCheckboxBlockDefault:before{
        background      : #ededed !important;
    }

    .xCNInputBlock{
        background      : #ededed !important;
        pointer-events  : none;
    }

    #ospDetailFooter{
        font-weight     : bold;
    }

</style>
<!-- TABLE สำหรับ checkbox -->
<div class="row" id="odvICTCustomerTop">
    <div class="col-xs-12 col-md-4 col-lg-4">
        <label class="xCNLabelFrm"><?php echo language('interface/connectionsetting/connectionsetting','tTABCustomer')?></label>
        <div class="form-group"> <!-- เปลี่ยน From Imput Class -->
            <div class="input-group">
                <input type="text"
                    class="form-control xCNInputWithoutSingleQuote"
                    id="oetSearchAllSetCus"
                    name="oetSearchAllSetCus"
                    placeholder="<?php echo language('interface/connectionsetting/connectionsetting','tSearch')?>"
                    value="<?php //$tSearchAllSetUp;?>">
                <span class="input-group-btn">
                    <button id="oimSearchSetCus" class="btn xCNBtnSearch" type="button">
                        <img class="xCNIconAddOn" src="<?php echo base_url().'/application/modules/common/assets/images/icons/search-24.png'?>">
                    </button>
                </span>
            </div>
        </div>
    </div><br>

    <div class="col-xs-12 col-md-8 col-lg-8 text-right form-group">
        <div id="odvMngTableList" class="btn-group xCNDropDrownGroup">
            <button type="button" class="btn xCNBTNMngTable" data-toggle="dropdown">
                <?=language('common/main/main','tCMNOption')?>
                <span class="caret"></span>
            </button>
            <ul class="dropdown-menu" role="menu">
                <li id="oliBtnDeleteAll" class="disabled">
                    <a data-toggle="modal" data-target="#odvModalDeleteMutirecordCus"><?=language('common/main/main','tDelAll')?></a>
                </li>
            </ul>
        </div>
        <button id="obtSMLLayout" name="obtSMLLayout" class="xCNBTNPrimeryPlus" type="button" style="margin-left: 20px; margin-top: 0px;" onclick="JSvCallPageAddCustomer()">+</button>
    </div>
</div>

<div class="row">
    <div class="col-md-12" id="odvICTCustomerContent">

    </div>
</div>

<!--Modal Delete Single-->
<div id="odvModalDeleteSingleCus" class="modal fade" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" style="overflow: hidden auto; z-index: 7000; display: none;">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header xCNModalHead">
				<label class="xCNTextModalHeard"><?=language('common/main/main', 'tModalDelete')?></label>
			</div>
			<div class="modal-body">
				<span id="ospConfirmDelete"> - </span>
				<input type='hidden' id="ohdConfirmIDDelete">
			</div>
			<div class="modal-footer">
				<button id="osmConfirmDelete" type="button" class="btn xCNBTNPrimery"><?=language('common/main/main', 'tModalConfirm')?></button>
        		<button type="button" class="btn xCNBTNDefult" data-dismiss="modal"><?=language('common/main/main', 'tModalCancel')?></button>
			</div>
		</div>
	</div>
</div>
<!--Modal Delete Mutirecord-->
<div class="modal fade" id="odvModalDeleteMutirecordCus">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header xCNModalHead">
				<label class="xCNTextModalHeard"><?=language('common/main/main', 'tModalDelete')?></label>
			</div>
			<div class="modal-body">
                <span id="ospConfirmDelete"><?=language('common/main/main', 'tModalDeleteMulti')?></span>
			</div>
			<div class="modal-footer">
				<button id="osmConfirm" type="button" class="btn xCNBTNPrimery" onClick="JSxDeleteMutirecord()"><?=language('common/main/main', 'tModalConfirm')?></button>
        		<button type="button" class="btn xCNBTNDefult" data-dismiss="modal"><?=language('common/main/main', 'tModalCancel')?></button>
			</div>
		</div>
	</div>
</div>
<script>
  $( document ).ready(function() {
    $.ajax({
        type    : "POST",
        url     : "masCustomersettingDataTable",
        cache   : false,
        timeout : 0,
        async   : false,
        success : function(tResult){
            $('#odvICTCustomerContent').html(tResult);
            JSxControlScroll();
            JCNxCloseLoading();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
    $('.ocbListItem').click(function(){
        var nCode = $(this).parent().parent().parent().data('code');  //code
        var tName = $(this).parent().parent().parent().data('name');  //code
        $(this).prop('checked', true);
        var LocalItemData = localStorage.getItem("LocalItemData");
        var obj = [];
        if(LocalItemData){
            obj = JSON.parse(LocalItemData);
        }else{ }
        var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
        if(aArrayConvert == '' || aArrayConvert == null){
            obj.push({"nCode": nCode, "tName": tName });
            localStorage.setItem("LocalItemData",JSON.stringify(obj));
            JSxPaseCodeDelInModal();

        }else{
            var aReturnRepeat = findObjectByKey(aArrayConvert[0],'nCode',nCode);
            if(aReturnRepeat == 'None' ){           //ยังไม่ถูกเลือก
                obj.push({"nCode": nCode, "tName": tName });
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
  });
  $("#oimSearchSetCus").click(function(event) {
    JSxCallGetContent();
    // var tKeyword = $("#oetSearchAllSetCus").val();
    // $.ajax({
    //     type    : "POST",
    //     url     : "masCustomersettingDataTableSearch",
    //     data    :{
    //         tKeyword:tKeyword
    //     },
    //     cache   : false,
    //     timeout : 0,
    //     async   : false,
    //     success : function(tResult){
    //         $('#odvICTCustomerContent').html(tResult);
    //         JSxControlScroll();
    //         JCNxCloseLoading();
    //     },
    //     error: function(jqXHR, textStatus, errorThrown) {
    //         JCNxResponseError(jqXHR, textStatus, errorThrown);
    //     }
    // });
  });
  // Function delete sigle
  // Create witsarut 21/05/2020
  function JSxConSetDelete(ptBchCode, ptCbrSoldTo, tYesOnNo){
       $('#odvModalDeleteSingleCus').modal('show');
       $('#odvModalDeleteSingleCus #ospConfirmDelete').html($('#oetTextComfirmDeleteSingle').val() + ptCbrSoldTo + ' '+ tYesOnNo );
       $('#odvModalDeleteSingleCus #osmConfirmDelete').on('click', function(evt){

            $.ajax({
                type  : "POST",
                url:  "CustomersettingEventDelete",
                data : {
                    tBchCode : ptBchCode,
                    tCbrSoldTo : ptCbrSoldTo
                },
                cache: false,
                success: function(tResult){
                    $('#odvModalDeleteSingleCus').modal('hide');
                    setTimeout(function(){
                        JSxCallGetContent();
                    }, 500);
                },

            });
        });
  }
  function JSvCallPageAddCustomer() {
    $.ajax({
        type    : "POST",
        url     : "masCustomernSettingGanPageAdd",
        cache   : false,
        timeout : 0,
        async   : false,
        success : function(tResult){
            $("#odvICTCustomerTop").hide();
            $('#odvICTCustomerContent').html(tResult);
            JSxControlScroll();
            JCNxCloseLoading();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
  }
  function JSxCallGetContent() {
    var tKeyword = $("#oetSearchAllSetCus").val();
    $.ajax({
        type    : "POST",
        url     : "masCustomersettingDataTable",
        data    : {
            tKeyword    : tKeyword
        },
        cache   : false,
        timeout : 0,
        async   : false,
        success : function(tResult){
            $("#odvICTCustomerTop").show();
            $('#odvICTCustomerContent').html(tResult);
            JSxControlScroll();
            JCNxCloseLoading();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
  }

  function JSvCallPageEditConnectionSetting(ptBchCode,ptCbrSoldTo,ptChnCode) {
    $.ajax({
        type    : "POST",
        url     : "masCustomernSettingGanPageAdd",
        data    : {
            tBchCode    : ptBchCode,
            tCbrSoldTo  : ptCbrSoldTo,
            tChnCode    : ptChnCode
        },
        cache   : false,
        timeout : 0,
        async   : false,
        success : function(tResult){
            $("#odvICTCustomerTop").hide();
            $('#odvICTCustomerContent').html(tResult);
            JSxControlScroll();
            JCNxCloseLoading();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
  }

  //Functionality : (event) Delete All
  //Parameters :
  //Creator : 11/06/2019 Witsarut (Bell)
  //Return :
  //Return Type :
  function  JSxDeleteMutirecord(){
      var nStaSession = JCNxFuncChkSessionExpired();
      if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
          JCNxOpenLoading();
          var aDataBchCode    =[];
          var aDataCusCode    =[];
          var ocbListItem     = $(".ocbListItem");
          for(var nI = 0;nI<ocbListItem.length;nI++){
              if($($(".ocbListItem").eq(nI)).prop('checked')){

                  aDataBchCode.push($($(".ocbListItem").eq(nI)).attr("ohdConfirmBchDelete"));
                  aDataCusCode.push($($(".ocbListItem").eq(nI)).attr("ohdConfirmCusDelete"));

              }
          }

          $.ajax({
              type: "POST",
              url:  "CustomerEventDeleteMultiple",
              data: {
                  'paDataCusCode'   : aDataCusCode,
                  'paDataBchCode'   : aDataBchCode,
              },
              cache: false,
              success: function (tResult){
                  tResult = tResult.trim();
                  var aReturn = $.parseJSON(tResult);
                  if(aReturn['nStaEvent'] == '1'){
                      $('#odvModalDeleteMutirecordCus').modal('hide');
                      $('#ospConfirmDelete').empty();
                      localStorage.removeItem('LocalItemData');
                      setTimeout(function(){
                          JSxCallGetContent();
                      }, 500);
                  }else{
                      alert(aReturn['tStaMessg']);
                  }
                  JCNxCloseLoading();
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
