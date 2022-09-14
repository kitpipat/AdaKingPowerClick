<div class="row">
    <div class="xCNBCMenu xWHeaderMenu">
        <div class="row">
            <div class="col-md-8">
                <span><?= language('ticket/park/park', 'tBranchInformation') ?></span>
            </div>
            <div class="col-md-4 text-right">
                <?php if ($oAuthen['tAutStaAdd'] == '1'): ?>					
                    <button onclick="JSxCallPage('<?= base_url() ?>EticketAddBranch')" class="btn btn-default xCNBTNPrimery" type="submit"><?= language('common/main/main', 'tAdd') ?></button>
                <?php endif; ?>
            </div>
        </div>
    </div>	
    <div class="main-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <div class="wrap-input100">
                            <span class="label-input100"><?= language('common/main/main', 'tSearch') ?></span>
                            <input class="input100" type="text" id="oetFTPmoName" name="oetFTPmoName" onkeyup="javascript: if (event.keyCode == 13) {
                                        event.preventDefault();
                                        JSxPRKCountSearch();
                                    }">
                            <span class="focus-input100"></span>
                            <img onclick="JSxPRKCountSearch();" class="xCNIconBrowse" src="<?= base_url(); ?>application/modules/common/assets/images/icons/search-24.png">								
                        </div>
                    </div>
                </div>
                <div class="col-md-4"></div>
                <div class="col-md-4"></div>				
            </div>
            <div class="row">
                <div id="oResultPark"></div>			
                <div class="row"> 	  
                    <div class="col-md-4 text-left grid-resultpage"><?= language('ticket/zone/zone', 'tFound') ?> <span id="ospTotalRecord"><?= $aPark[0]->counts ?></span> <?= language('ticket/zone/zone', 'tList') ?> <a class="xWBoxLocPark" style="color: #333; text-decoration: none;"><?= language('ticket/zone/zone', 'tShowpage') ?> <span id="ospPageActive">1</span> / <span id="ospTotalPage"><?= ceil($aPark[0]->counts / 8) ?></span></a></div>                   
                    <div class="col-md-8 text-right xWGridFooter xWBoxLocPark"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="<?php echo base_url() ?>application/modules/ticket/assets/src/branch/jParkNew.js"></script>
<script>
window.onload = JSxPRKCountSearch();
</script>