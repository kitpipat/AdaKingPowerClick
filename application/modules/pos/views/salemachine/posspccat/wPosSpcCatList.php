
	
<!-- <label id="olaMachineDevice" name="olaMachineDevice"></label> -->
<div class="row">
    <div class="col-xs-12 col-md-4">
        <ol id="oliMenuNav" class="breadcrumb">
        <li id="oliPosSpcCatTitle" class="xCNLinkClick" onclick="JSxPosSpcCatGetContent();" style="cursor:pointer; font-size: 21px !important;"><?= language('pos/salemachine/salemachine','tPageAddTabPosSpcCat')?></li>
        <li id="oliPosSpcCatTitleNone" class="active" style="display:none;"><a>None</a></li>
        <li id="oliPosSpcCatTitleAdd"  class="active"><a><?= language('common/main/main','tAdd')?></a></li>
        <li id="oliPosSpcCatTitleEdit" class="active"><a><?= language('common/main/main','tEdit')?></a></li>
        </ol>
    </div>
    <div class="col-xs-12 col-md-8 text-right">
        <div id="odvBtnPosSpcCatInfo">
            <button class="xCNBTNPrimeryPlus" type="button" onclick="JSxPosSpcCatPageAdd();">+</button>
        </div>
        <div id="odvBtnPosSpcCatAddEdit">
            <button type="button" onclick="JSxPosSpcCatDataList();" class="btn" style="background-color: #D4D4D4; color: #000000;">
                <?php echo language('company/shopgpbypdt/shopgpbypdt', 'tSGPPBTNCancel')?>
            </button>
            <button type="submit" class="btn" style="background-color: rgb(23, 155, 253); color: white;" onclick="$('#obtPosSpcCatSubmit').click();"> 
                <?php echo  language('common/main/main', 'tSave')?>
            </button>
        </div>
    </div>
</div>

<div id="odvPSCSearchSection" class="row">
    <div class="col-xs-8 col-md-4 col-lg-4">
        <div class="form-group">
            <label class="xCNLabelFrm"><?php echo language('common/main/main','tSearchNew')?></label>
            <div class="input-group">
                <input type="text" class="form-control xCNInputWithoutSingleQuote" id="oetPSCSearch" name="oetPSCSearch" autocomplete="off"  placeholder="<?php echo language('common/main/main','tPlaceholder'); ?>">
                <span class="input-group-btn">
                    <button class="btn xCNBtnSearch" type="button" id="obtPSCSearch" name="obtPSCSearch">
                        <img class="xCNIconBrowse" src="<?php echo base_url().'/application/modules/common/assets/images/icons/search-24.png'?>">
                    </button>
                </span>
            </div>
        </div>
    </div>
    <div class="col-xs-4 col-md-8 col-lg-8 text-right" style="margin-top:25px;">
        <div id="odvMngTableList" class="btn-group xCNDropDrownGroup">
            <button type="button" class="btn xCNBTNMngTable" data-toggle="dropdown">
                <?= language('common/main/main','tCMNOption')?>
                <span class="caret"></span>
            </button>
            <ul class="dropdown-menu" role="menu">
                <li id="oliBtnDeleteAll" class="disabled">
                    <a data-toggle="modal" data-target="#odvPSCModalDel"><?= language('common/main/main','tDelAll')?></a>
                </li>
            </ul>
        </div>
    </div>
</div>

<div id="odvPosSpcCatData"></div>

<script>

	$('#obtPSCSearch').click(function(){
		JSxPosSpcCatDataList();
	});

	$('#oetPSCSearch').keypress(function(event){
		if(event.keyCode == 13){
			JSxPosSpcCatDataList();
		}
	});

	$( document ).ready(function(){
        JSxPosSpcCatDataList();
	});

    function JSxPosSpcCatControlButton(ptTypePage){
        switch(ptTypePage){
            case 'DataTable':
                $('#oliPosSpcCatTitleAdd').hide();
                $('#oliPosSpcCatTitleEdit').hide();
                $('#odvBtnPosSpcCatAddEdit').hide();
                $('#odvBtnPosSpcCatInfo').show();
                $('#odvPSCSearchSection').show();
                break;
            case 'PageAdd':
                $('#oliPosSpcCatTitleAdd').show();
                $('#oliPosSpcCatTitleEdit').hide();
                $('#odvBtnPosSpcCatAddEdit').show();
                $('#odvBtnPosSpcCatInfo').hide();
                $('#odvPSCSearchSection').hide();
                break;
            case 'PageEdit':
                $('#oliPosSpcCatTitleAdd').hide();
                $('#oliPosSpcCatTitleEdit').show();
                $('#odvBtnPosSpcCatAddEdit').show();
                $('#odvBtnPosSpcCatInfo').hide();
                $('#odvPSCSearchSection').hide();
                break;
        }
        $('#odvPosSpcCatData').html('');
    }

    // Create By : Napat(Jame) 05/05/2022
    function JSxPosSpcCatDataList(pnPage){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){

            JSxPosSpcCatControlButton('DataTable');

            var nPage       = 1;
            var tBchCode    = $('#ohdBchCode').val();
            var tShpCode    = $('#ohdShpCode').val();
            var tPosCode    = $('#oetPosCode').val();
            var tSearch     = $('#oetPSCSearch').val();

            if( pnPage != undefined ){
                nPage = pnPage;
            }

            JCNxOpenLoading();
            $.ajax({
                type: "POST",
                url: "masPOSSpcCatPageDataTable",
                data: {
                    tPosCode        : tPosCode,
                    tBchCode        : tBchCode,
                    tShpCode        : tShpCode,
                    tSearchAll      : tSearch,
                    nPageCurrent    : nPage
                },
                cache	: false,
                timeout	: 0,
                success	: function(tResult){
                    localStorage.removeItem('LocalItemData');
                    $('#odvPosSpcCatData').html(tResult);
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

    // Create By : Napat(Jame) 05/05/2022
    function JSxPosSpcCatPageAdd(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){

            JSxPosSpcCatControlButton('PageAdd');

            JCNxOpenLoading();
            $.ajax({
                type: "POST",
                url: "masPOSSpcCatPageAdd",
                data: {},
                cache	: false,
                timeout	: 0,
                success	: function(tResult){
                    $('#odvPosSpcCatData').html(tResult);
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
