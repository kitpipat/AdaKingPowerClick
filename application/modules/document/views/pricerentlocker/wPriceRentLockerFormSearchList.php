<div class="panel panel-headline">
    <div class="panel-heading">
        <div class="row">
            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="xCNLabelFrm"><?php echo language('common/main/main','tSearchNew');?></label>
                    <div class="input-group">
                        <input
                            class="form-control xCNInputWithoutSingleQuote"
                            type="text"
                            id="oetPriRntLkSearchAll"
                            name="oetPriRntLkSearchAll"
                            onkeyup="javascript:if(event.keyCode==13) JSvPriRntLkCallPageDataTable()"
                            placeholder="<?php echo language('document/pricerentlocker/pricerentlocker','tPriRntLkFillTextSearch')?>"
                            autocomplete="off"
                        >
                        <span class="input-group-btn">
                            <button id="obtPriRntLkSerchAll" type="button" class="btn xCNBtnDateTime"><img class="xCNIconSearch"></button>
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-md-8 col-lg-8 text-right" style="margin-top:34px;">
                <div id="odvPriRntLkMngTableList" class="btn-group xCNDropDrownGroup">
                    <button type="button" class="btn xCNBTNMngTable" data-toggle="dropdown">
                        <?php echo language('common/main/main','tCMNOption')?>
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu" role="menu">
						<li id="oliPriRntLkBtnDeleteAll" class="disabled">
							<a data-toggle="modal" data-target="#odvPriRntLkModalDelDocMultiple"><?php echo language('common/main/main','tCMNDeleteAll')?></a>
						</li>
					</ul>
                </div>
            </div>
        </div>
    </div>
    <div class="panel-body">
        <section id="ostPriRntLkDataTableDocument"></section>
    </div>
</div>
<script src="<?php echo  base_url('application/modules/common/assets/js/jquery.mask.js')?>"></script>
<script src="<?php echo  base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>
