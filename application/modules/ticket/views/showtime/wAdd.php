<div class="main-content">
    <div class="panel panel-headline">
        <div class="panel-heading">
            <div class="row">
                <div class="col-md-12">
                    <div class="row" style="margin-left: -15px; margin-right: -15px;">
                        <div class="col-md-12">
                            <button type="button" class="btn btn-default xCNBTNPrimery pull-right" id="oBtnSaveShowtimeLoc" onclick="JSxSHTAddLoc();" style="display: none;"><?= language('ticket/user/user', 'tSave') ?></button>
                            <h3><?= language('ticket/event/event', 'tAddLocationShow') ?></h3>
                        </div>
                    </div>
                <div class="row">
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-md-6 col-sm-6 padding-right5">
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?= language('ticket/product/product', 'tSelectBranch') ?></label>
                                        <select class="selectpicker form-control" id="ocmPrkPmoID" onchange="javascript: JSxSHTSearch();" style="width: 100%">
                                            <option value=""><?= language('ticket/product/product', 'tSelectBranch') ?></option>
                                            <?php foreach ($oPrk AS $oValue): ?>							
                                                <option value="<?= $oValue->FNPmoID ?>"><?= $oValue->FTPmoName ?></option>
                                            <?php endforeach; ?>			       
                                        </select>
                                    </div>
                                </div>				
                            <div class="col-md-6 col-sm-6 padding-left5 padding-right5">
                                <div class="form-group"> <!-- เปลี่ยน From Imput Class -->
                                    <label class="xCNLabelFrm"><?= language('ticket/location/location', 'tSearchLocation') ?></label>
                                        <div class="input-group">
                                            <input type="text" class="form-control xCNInputWithoutSingleQuote" id="oetLocName" name="oetLocName" onkeyup="Javascript:if(event.keyCode==13) JSxSHTSearch()">
                                                <span class="input-group-btn">
                                                    <button class="btn xCNBtnSearch" type="button" onclick="JSxSHTSearch()" >
                                                    <img class="xCNIconAddOn" src="<?php echo base_url().'application/modules/common/assets/images/icons/search-24.png'?>">
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                </div>				
                            </div>			
                        </div>
                    <div class="col-md-4"></div>
                </div>
            <div class="row">
                <div class="col-md-12">
                    <div id="oResultLocShowTime">
                        <div style="text-align: center; padding: 10px;"> <?= language('ticket/user/user', 'tDataNotFound') ?> </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- 
<hr style="border-bottom: 1px solid #eee; background-image: none;">
<div class="main-content">
    <div class="container-fluid">
        <div id="oResultLocShowTime">
            <div style="text-align: center; padding: 10px;"> <?= language('ticket/user/user', 'tDataNotFound') ?> </div>
        </div>
    </div>
</div> -->
<script type="text/javascript">

    $('.selectpicker').selectpicker();

    $(function () {
        $('[title]').tooltip();
    });
</script>