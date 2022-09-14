<?php if (@$oLocList[0]->FNLocID != ""): ?>
    <style>
        #oBtnSaveShowtimeLoc {
            display: block !important;
        } 
    </style>
    <script>
        $('.selectpicker').selectpicker();
        // $(function () {
        //     $('#ocmFNPkgID').select2({
        //         placeholder: '<?= language('ticket/event/event', 'tSelectPackage') ?>'
        //     });
        // });
    </script>
    <form action="" method="post" id="ofmShowTimeAddLoc">
            <table class="table table-striped">
                <thead>
                    <tr></tr>
                        <th style="width: 50px; class="text-center"><?= language('common/main/main', 'tCMNChoose') ?></th>					
                        <th style="width: 100px;" class="text-center"><b>รูปภาพ</b></th>
                        <th class="text-center"><b>ชื่อสถานที่</b></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach (@$oLocList as $key => $tValue): ?>
                        <tr>
                            <td scope="row" style="vertical-align: middle;">
                                <label class="fancy-checkbox">
                                    <input type="checkbox" class="xWCBFNLocID" name="ocbFNLocID[]" id="oCBFNLocID<?= $tValue->FNLocID ?>" value="<?= $tValue->FNLocID ?>">
                                    <span>&nbsp;</span>
                                </label>
                                <input type="hidden" name="ohdFNEvnID" value="<?= $oEventId; ?>" />
                            </td>                       
                        <td>
                            <?php
                                if(isset($tValue->FTImgObj) && !empty($tValue->FTImgObj)){
                                    $tFullPatch = './application/modules/'.$tValue->FTImgObj;
                                        if (file_exists($tFullPatch)){
                                            $tPatchImg = base_url().'/application/modules/'.$tValue->FTImgObj;
                                        }else{
                                            $tPatchImg = base_url().'application/modules/common/assets/images/Noimage.png';
                                        }
                                    }else{
                                        $tPatchImg = base_url().'application/modules/common/assets/images/Noimage.png';
                                    }
                                ?>
                                <img class="img-reponsive" style="width: 100%;" src="<?= $tPatchImg ?>">
                            </td>
                            <td>
                                <p>
                                        <b>				
                                            <?php if ($tValue->FTLocName): ?>
                                                <?= $tValue->FTLocName ?>
                                            <?php else: ?>
                                                <?= language('ticket/zone/zone', 'tNoData') ?>
                                            <?php endif; ?>
                                        </b><br>
                                        <p class="xWLocation-Detail" style="min-height: auto !important;">
                                            <?= language('ticket/zone/zone', 'tAmountLimit') ?> <?= $tValue->FNLocLimit ?> <?= language('ticket/zone/zone', 'tPersons') ?><br>
                                        </p>
                                </p>		
                                <p>
                                    <?php
                                    $nLocID = $tValue->FNLocID;
                                    $oPkgList = $this->mShowTime->FSxMSHTPkgList($nLocID);
                                    ?>
                                    <?php if (@$oPkgList[0]->FNPkgID == ""): ?>					
                                    <?php else: ?>
                                        <div class="form-group">
                                            <!-- <div class="wrap-input100 input100-select validate-input"> -->
                                                <label class="xCNLabelFrm"><?= language('ticket/event/event', 'tSelectPackage') ?></label>
                                                 <div>
                                                    <select class="selectpicker form-control" name="ocmFNPkgID[]" onchange="FsSet(this.value, '#oCBFNLocID<?= $tValue->FNLocID ?>');" id="ocmFNPkgID" multiple="multiple" title="<?= language('ticket/event/event', 'tSelectPackage') ?>">
                                                        <option value=""><?= language('ticket/event/event', 'tSelectPackage') ?></option>
                                                        <?php foreach ($oPkgList as $key => $value): ?>
                                                            <option value="<?php echo $value->FNPkgID ?>"><?php echo $value->FTPkgName ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                                <!-- <span class="focus-input100"></span> -->
                                            <!-- </div> -->
                                        </div>	
                                    <?php endif; ?>					
                                </p>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
    </form>
<?php else: ?>            	
    <div style="text-align: center; padding: 10px;"> <?= language('ticket/user/user', 'tDataNotFound') ?> </div>
<?php endif ?>	

<script>
    function FsSet(oJ, tID) {
        if (oJ != '') {
            $(tID).prop('checked', true);
        } else {
            $(tID).prop('checked', false);
        }
    }
</script>