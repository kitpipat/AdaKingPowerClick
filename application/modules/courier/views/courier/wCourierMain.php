<div class="panel-heading">
	<div class="row">
        <div class="col-xs-8 col-md-4 col-lg-4">
            <div class="form-group">
                <label class="xCNLabelFrm"><?php echo language('common/main/main','tSearch')?></label>
                <div class="input-group">
                    <input type="text" class="form-control xCNInputWithoutSingleQuote" id="oetSearchAll" name="oetSearchAll" autocomplete="off"  placeholder="<?php echo language('common/main/main','tPlaceholder'); ?>">
                    <span class="input-group-btn">
                        <button class="btn xCNBtnSearch" type="button">
                            <img class="xCNIconAddOn" src="<?php echo base_url().'/application/modules/common/assets/images/icons/search-24.png'?>">
                        </button>
                    </span>
                </div>
            </div>
        </div>
        <div class="col-xs-4 col-md-8 col-lg-8 text-right" style="margin-top:34px;">
            <?php if($aAlwEventCourier['tAutStaFull'] == 1 || $aAlwEventCourier['tAutStaDelete'] == 1 ) : ?>
            <div id="odvMngTableList" class="btn-group xCNDropDrownGroup">
                <button type="button" class="btn xCNBTNMngTable" data-toggle="dropdown">
                    <?php echo language('common/main/main','tCMNOption')?>
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu" role="menu">
                    <li id="oliBtnDeleteAll" class="disabled">
                        <a data-toggle="modal" data-target="#odvModalDelCourier"><?php echo language('common/main/main','tDelAll')?></a>
                    </li>
                </ul>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<div class="panel-body">
	<div id="odvContentCourierData"></div>
</div>

<script>
    $('#oetSearchAll').on('keypress',function(){
        if(event.keyCode==13){
            JSvCallPageCourierDataTable();
        }
    });
    $('.xCNBtnSearch').click(function(){
        JSvCallPageCourierDataTable();
    });
</script>