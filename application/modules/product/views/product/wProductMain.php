<div class="panel-heading">
    <div class="row">
        <div class="col-xs-12 cols-sm-2 col-md-2 col-lg-2">

            <script>
                    $('document').ready(function(){
                        var tStaPdtForSystem = $('#ohdPdtforSystemDataTable').val();
                        $('.xWPdtForSystem' + tStaPdtForSystem).prop("selected",true);
                    });
            </script>

            <div class="form-group">
                <label class="xCNLabelFrm"><?=language('product/product/product','tPdtForSystemTitle');?></label>
                <select class="selectpicker form-control" id="ocmPdtForSystem" name="ocmPdtForSystem" maxlength="1" onchange="JSxSelectPdtForSystem(this.value)">
                    <option class="xWPdtForSystem1" value="1"><?=language('product/product/product','tPdtForSystem1')?></option>
                    <option class="xWPdtForSystem2" value="2"><?=language('product/product/product','tPdtForSystem2')?></option>
                    <option class="xWPdtForSystem3" value="3"><?=language('product/product/product','tPdtForSystem3')?></option>
                    <option class="xWPdtForSystem4" value="4"><?=language('product/product/product','tPdtForSystem4')?></option>
                    <option class="xWPdtForSystem5" value="5"><?=language('product/product/product','tPdtForSystem5')?></option>
                    <option class="xWPdtForSystem" value=""><?=language('product/product/product','tPdtForSystem0')?></option>
                </select>
            </div>
        </div>

        <div class="col-xs-12 cols-sm-2 col-md-2 col-lg-2">
            <script>
                $('document').ready(function(){
                    var tStaPdtForSystem = $('#ohdPdtforSystemDataTable').val();
                    $('.xWPdtForSystem' + tStaPdtForSystem).prop("selected",true);
                });
            </script>

            <div class="form-group">
                <label class="xCNLabelFrm"><?=language('product/product/product','tPdtSreachTypeName');?></label>
                <select class="selectpicker form-control" id="ocmSearchProductType" name="ocmSearchProductType" maxlength="1" >
                    <option class="" value="1"><?=language('product/product/product','tPdtSreachType1')?></option>
                    <option class="" value="2" selected><?=language('product/product/product','tPdtSreachType2')?></option>
                    <option class="" value="3"><?=language('product/product/product','tPdtSreachType3')?></option>
                    <option class="" value="4"><?=language('product/product/product','tPdtSreachType4')?></option>
                    <option class="" value="5"><?=language('product/product/product','tPdtSreachType5')?></option>
                    <option class="" value="6"><?=language('product/product/product','tPdtSreachType6')?></option>
                </select>
            </div>
        </div>

        <div class="col-xs-12 cols-sm-4 col-md-4 col-lg-4">
            <div class="form-group">
                <label class="xCNLabelFrm"><?php echo language('common/main/main','tSearch')?></label>
                <div class="input-group">
                    <input type="text" class="form-control xCNInputWithoutSingleQuote" id="oetSearchProduct" name="oetSearchProduct" placeholder="<?php echo language('common/main/main','tPlaceholder');?>">
                    <span class="input-group-btn">
                        <button id="obtSearchProduct" class="btn xCNBtnSearch" type="button">
                            <img class="xCNIconBrowse" src="<?php echo base_url().'/application/modules/common/assets/images/icons/search-24.png'?>">
                        </button>
                    </span>
                </div>
            </div>
        </div>

        <?php if($aAlwEventPdt['tAutStaFull'] == 1 || $aAlwEventPdt['tAutStaDelete'] == 1 ) : ?>
            <div class="col-lg-4 col-md-4 col-xs-12 col-sm-4 text-right">
                <div class="form-group">
                    <label class="xCNLabelFrm hidden-xs"></label>
                    <div >
                        <?php if($aAlwEventPdt['tAutStaFull'] == 1 || ($aAlwEventPdt['tAutStaAdd'] == 1)){ ?>
                            <button type="button" id="odvEventImportFilePDT" class="btn xCNBTNImportFile"><?= language('common/main/main','tImport')?></button>
                        <?php } ?>

                        <div id="odvMngTableList" class="btn-group xCNDropDrownGroup">
                            <button type="button" class="btn xCNBTNMngTable" data-toggle="dropdown">
                            <?php echo language('common/main/main','tCMNOption')?>
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu" role="menu">
                                <li id="oliBtnDeleteAll" class="disabled">
                                    <a data-toggle="modal" data-target="#odvModalDeletePdtMultiple"><?php echo language('common/main/main','tDelAll')?></a>
                                </li>
                                <li id="oliCallPageAdjustProduct" onclick="FSxPdtCallPageAdjust()" >
                                    <a data-toggle="modal" data-target="#odvCallPageAdjustProduct"><?php echo language('product/product/product','tAdjPdtTitle')?></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
<div class="panel-body">
    <section id="ostDataProduct"></section>
</div>

<!-- ===================================================== Modal Delete Product Single ===================================================== -->
    <div id="odvModalDeletePdtSingle" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header xCNModalHead">
                    <label class="xCNTextModalHeard"><?php echo language('common/main/main', 'tModalDelete')?></label>
                </div>
                <div class="modal-body">
                    <span id="ospTextConfirmDelSingle" class="xCNTextModal" style="display: inline-block; word-break:break-all"></span>
                </div>
                <div class="modal-footer">
                    <button id="osmConfirmDelSingle" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" type="button"><?php echo language('common/main/main', 'tModalConfirm')?></button>
                    <button class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"  data-dismiss="modal"><?php echo language('common/main/main', 'tModalCancel')?></button>
                </div>
            </div>
        </div>
    </div>
<!-- ====================================================== End Modal Delete Product ======================================================= -->



<!-- Modal Advance Table -->
<div class="modal fade" id="odvPdtShowOrderColumn" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <label class="xCNTextModalHeard" style="font-weight: bold; font-size: 20px;"><?php echo language('common/main/main','tModalAdvTable')?></label>
            </div>
            <div id="odvPdtDetailShowColumn" class="modal-body">
                <div style="height:350px;overflow:auto;">
                    <table id="otbPdtOrderListDetail" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th nowrap class="text-center xCNTextBold" style="width:10%"><?php echo language("common/main/main","tModalAdvNo");?></th>
                                <th nowrap class="text-center xCNTextBold" style="width:20%"><?php echo language("common/main/main","tModalAdvChoose");?></th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <div style="padding:10px 0px">
                    <label class="fancy-checkbox">
                        <input type="checkbox" id="ocbPdtSetColDef">
                        <span><?php echo language("common/main/main","tModalAdvUseDefOption");?></span>
                    </label>
                </div>
            </div>
            <div class="modal-footer">
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                    <button type="button" class="btn btn-danger" data-dismiss="modal" style="font-size:17px;"><?php echo language('common/main/main', 'tModalAdvClose')?></button>
                    <button type="button" id="obtPdtSaveMngTable" class="btn btn-primary" style="font-size:17px;"><?php echo language('common/main/main', 'tModalAdvSave')?></button>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo base_url(); ?>application/modules/common/assets/js/jquery.mask.js"></script>
<script src="<?php echo base_url(); ?>application/modules/common/assets/src/jFormValidate.js"></script>
<script type="text"></script>
<?php include "script/jProductMain.php"; ?>

<script>

    //supawat 13/07/2020
	//กดนำเข้า จะวิ่งไป Modal popup ที่ center
	$('#odvEventImportFilePDT').click(function() {
		var tNameModule = 'Product';
		var tTypeModule = 'master';
		var tAfterRoute = 'productPageImportDataTable';

		var aPackdata = {
			'tNameModule' : tNameModule,
			'tTypeModule' : tTypeModule,
			'tAfterRoute' : tAfterRoute
		};
		JSxImportPopUp(aPackdata);
	});

</script>
