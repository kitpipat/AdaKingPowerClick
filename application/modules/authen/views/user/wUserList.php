<div class="panel panel-headline">
    <div class="panel-heading">
        <div id="ostSearchUser">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-xs-12 col-sm-12">
                    <div class="form-group"> 
                        <label class="xCNLabelFrm"><?php echo language('common/main/main', 'tSearchNew') ?></label>
                        <div class="input-group">
                            <input type="text" class="form-control xCNInputWithoutSingleQuote" id="oetSearchAll" name="oetSearchAll" placeholder="<?php echo language('common/main/main','tPlaceholder')?>">
                            <span class="input-group-btn">
                                <button id="oimSearchUser" class="btn xCNBtnGenCode" type="button">
                                    <img class="xCNIconAddOn" src="<?php echo base_url() . '/application/modules/common/assets/images/icons/search-24.png' ?>">
                                </button>
                            </span>
                        </div>
                    </div>
                </div>
                <?php if($aAlwEventUser['tAutStaFull'] == 1 || $aAlwEventUser['tAutStaDelete'] == 1 ) : ?>
                    <div class="col-lg-6 col-md-6 col-xs-12 col-sm-12 text-right">
                        <div class="form-group"> 
                            <label class="xCNLabelFrm hidden-xs hidden-sm"></label>
                            <div >
                                <?php if($aAlwEventUser['tAutStaFull'] == 1 || ($aAlwEventUser['tAutStaAdd'] == 1)){ ?>
                                    <button type="submit" id="oimExportExcelURS" name="oimExportExcelURS" class="btn xCNBTNImportFile" data-toggle="modal" data-target="#odvModalExcelUrs">
                                        <?php echo language('authen/user/user', 'tUsrImport'); ?>
                                    </button>


                                    <button type="button" id="odvEventImportFileUSR" class="btn xCNBTNImportFile"><?= language('common/main/main','tImport')?></button>
                                <?php } ?>

                                <div id="odvMngTableList" class="btn-group xCNDropDrownGroup">
                                    <button type="button" class="btn xCNBTNMngTable" data-toggle="dropdown">
                                        <?php echo language('common/main/main', 'tCMNOption') ?>
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu" role="menu">
                                        <li id="oliBtnDeleteAll" class="disabled">
                                            <a data-toggle="modal" data-target="#odvModalDelUser"><?php echo language('common/main/main', 'tDelAll') ?></a>
                                        </li>
                                        <li id="oliBtnCondition">
                                            <a data-toggle="modal" data-target="#odvModalCondition"><?php echo language('authen/user/user', 'tUsrCreateCondit') ?></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="panel-body">
        <section id="ostDataUser"></section>
    </div>
</div>
<script src="<?php echo base_url(); ?>application/modules/common/assets/js/jquery.mask.js"></script>
<script src="<?php echo base_url(); ?>application/modules/common/assets/src/jFormValidate.js"></script>
<script>
    $('#oimSearchUser').click(function(){
            JCNxOpenLoading();
            JSvUserDataTable();
    });

    $('#oetSearchAll').keypress(function(event){
        if(event.keyCode == 13){
            JCNxOpenLoading();
            JSvUserDataTable();
        }
    });

    //supawat 13/07/2020
	//กดนำเข้า จะวิ่งไป Modal popup ที่ center
	$('#odvEventImportFileUSR').click(function() {
		var tNameModule = 'User';
		var tTypeModule = 'master';
		var tAfterRoute = 'userPageImportDataTable';

		var aPackdata = {
			'tNameModule' : tNameModule,
			'tTypeModule' : tTypeModule,
			'tAfterRoute' : tAfterRoute
		};
		JSxImportPopUp(aPackdata);
	});
</script>