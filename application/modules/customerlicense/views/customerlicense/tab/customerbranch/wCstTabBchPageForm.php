
<?php


if($aResult['rtCode']=='1'){
	$tRoute = "customerbranchEventEdit";
	$nCbrSeq =	$aResult['raItems']['rnCbrSeq'];
	$tCbrRefBch =	$aResult['raItems']['rtCbrRefBch'];
	$tCbrRefBchName =	$aResult['raItems']['rtCbrRefBchName'];
	$nCbrQtyPos =	$aResult['raItems']['rnCbrQtyPos'];
	$tSrvCode =	$aResult['raItems']['rtSrvCode'];
	$tSrvName =	$aResult['raItems']['rtSrvName'];
	$tPageEvent =	language('customerlicense/customerlicense/customerlicense','tCLBPageEdit');
	if($tCbrRefBch!=''){
	  $tabDisabled = '';
	  $dataToggle = 'tab';  
	}else{
	  $tabDisabled = 'disabled';
	  $tServerDisabled = 'disabled';
	  $dataToggle = 'false';  
	}
}else{

	$tRoute = "customerbranchEventAdd";
	$nCbrSeq =	'';
	$tCbrRefBch =	'';
	$tCbrRefBchName =	'';
	$nCbrQtyPos =	1;
	$tSrvCode =	'';
	$tSrvName =	'';
	$tPageEvent =	language('customerlicense/customerlicense/customerlicense','tCLBPageAdd');
	$tabDisabled = 'disabled';
	$tServerDisabled = '';
	$dataToggle = 'false';  
}

?>
<div class="row">
<div class="col-xl-12 col-lg-12">
                    <div class="custom-tabs-line tabs-line-bottom left-aligned">
                        <div class="row">
                            <div id="odvNavMenuTab" class="col-xl-12 col-lg-12">
                     
                                <input type="hidden" id="ohdNavActiveTab" value="oliBchInfo1">
                                <ul class="nav" role="tablist" data-typetab="main" data-tabtitle="Bchinfo">
                                    <li id="oliBchInfo1" class="xWMenu active">
                                        <a 
                                            role="tab" 
                                            data-toggle="tab" 
                                            data-target="#odvTabBchInfo1"
                                            aria-expanded="true"><b><?php echo language('customerlicense/customerlicense/customerlicense','tCLNCstBchTitle')?></b></span> / <?=$tPageEvent?></a>
                                    </li>
                                    <li id="oliBchAddr" class="xWMenu <?=$tabDisabled?>" data-typetab="main" data-tabtitle="bchaddr">
                                        <a  
                                            role="tab" 
                                            data-toggle="<?=$dataToggle?>" 
                                            data-target="#odvTabBchAddr"
                                            aria-expanded="false"><?php echo language('customerlicense/customerlicense/customerlicense','tCBLBchAddr')?></a>
                                    </li>

    

                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
</div>


<input type="hidden" name="ohdCbrSeq" id="ohdCbrSeq" value="<?=$nCbrSeq?>" >
<input type="hidden" name="ohdCbrRoute" id="ohdCbrRoute" value="<?=$tRoute?>" >
<input type="hidden" name="ohdRegLicType" id="ohdRegLicType" value="<?=$tRegLicType?>" >

<div class="tab-content">
<div id="odvTabBchInfo1" class="tab-pane fade active in">
    <div class="">


        <div class="row">

			<div class="col-xs-8 col-md-6 col-lg-6">

				<div class="form-group"> 
					<label class="xCNLabelFrm"><?= language('customerlicense/customerlicense/customerlicense','tCLBCstBchCode')?></label>
						<input type="text" name="oetCbrRefBch" id="oetCbrRefBch" class="form-control"  maxlength="5" autocomplete="off"  value="<?=$tCbrRefBch?>">
				</div>

				<div class="form-group"> 
					<label class="xCNLabelFrm"><?= language('customerlicense/customerlicense/customerlicense','tCLBCstBchName')?></label>
				
						<input type="text" name="oetCbrRefBchName" id="oetCbrRefBchName" autocomplete="off" class="form-control" value="<?=$tCbrRefBchName?>">
					
				</div>
	

				<div class="form-group">
					<label class="xCNLabelFrm"><?= language('customerlicense/customerlicense/customerlicense','tCLBCstBcServer')?></label>
					<div class="input-group">
						<input type="text" id="oetSrvCode" class="form-control xCNHide" name="oetSrvCode" value="<?=$tSrvCode?>">
						<input type="text" id="oetSrvName" class="form-control" name="oetSrvName" value="<?=$tSrvName?>" readonly>
						<span class="input-group-btn">
							<button id="obtBrowseSrvCode" type="button" class="btn xCNBtnBrowseAddOn" <?=$tServerDisabled?>>
								<img class="xCNIconFind">
							</button>
						</span>
					</div>
				</div>


				<div class="form-group"> 
					<label class="xCNLabelFrm"><?= language('customerlicense/customerlicense/customerlicense','tCLBCbrQtyPos')?></label>
					
						<input type="number" name="oenCbrQtyPos" id="oenCbrQtyPos" class="form-control" value="<?=$nCbrQtyPos?>">
					
				</div>

			</div>

			<div class="col-xs-6 col-md-6 col-lg-6">
					<button type="button" class="btn btn-default" onclick="JSvCLNCshBchGetPageList();" >ยกเลิก</button>  <button type="button" class="btn btn-primary" onclick="JSxCLBCstBchAddUpdateEvent()" >บันทึก</button>
			</div>

		</div>
    </div>
</div>
 
  <?php include "tab/address/wBranchAddress.php"; ?>

</div>
<?php Include 'script/jCstScriptBchPageForm.php'; ?>
<?php Include 'tab/address/script/jBranchAddress.php'; ?>