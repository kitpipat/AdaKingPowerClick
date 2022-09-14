<div id="odvDSHSALModalConfigPage" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" style="width:50%;margin:1.75rem auto;left:2%;">
        <div class="modal-content">
            <div class="modal-header">
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <label class="xCNTextModalHeard" style="font-weight:bold;font-size:20px;"><?php echo @$aTextLang['tDSHSALConfigPage'];?></label>
                    </div>
                </div>
            </div>
            <div class="modal-body">


                <div class="container">
                    <div class="row">
                        <div class="new">
                            <form>

                                <?php $tValueCookie = $this->input->cookie("Cookie_SKC" . $this->session->userdata("tSesUserCode"), true);
                                $tValCheck = json_decode($tValueCookie);
                                // print_r($tValCheck);
                                $tCheckboxDef = '';
                                if(empty($tValueCookie)){
                                      $tCheckboxDef = 'checked';
                                    }
                                ?>

                                <!-- Page Left -->
                             <?php
                                     $aIsAlwFuncInRoleParams = ["tUfrGrpRef" => "053", "tUfrRef" => "DSB01", "tGhdApp" => "SB"];
                                     $bChkRoleBillTotalAll = FCNbIsAlwFuncInRole($aIsAlwFuncInRoleParams);
                            ?>
                            <?php if ($bChkRoleBillTotalAll) { ?>
                                <div class="form-group">
                                    <input name="ocbCheckbox" type="checkbox" value="1" <?php if($tValCheck[0] != 0){ $tCheckbox = 'checked'; echo $tCheckbox; }else{echo $tCheckboxDef; } ?>>
                                    <label for="olaDSHSALBillQty"><?php echo @$aTextLang['tDSHSALBillQty'] .' | '. @$aTextLang['tDSHSALBillTotalAll'];?></label>
                                </div>
                            <?php }else{
                            ?>
                                    <input name="ocbCheckbox" type="hidden" value="1" >
                            <?php } ?>


                            <?php
                                     $aIsAlwFuncInRoleParams = ["tUfrGrpRef" => "053", "tUfrRef" => "DSB02", "tGhdApp" => "SB"];
                                     $bChkRoleTotalSaleByPayment = FCNbIsAlwFuncInRole($aIsAlwFuncInRoleParams);
                            ?>
                            <?php if ($bChkRoleTotalSaleByPayment) { ?>
                                <div class="form-group">
                                    <input name="ocbCheckbox" type="checkbox" value="2" <?php if($tValCheck[1] != 0){ $tCheckbox = 'checked'; echo $tCheckbox; }else{echo $tCheckboxDef; } ?>>
                                    <label for="olaDSHSALTotalSaleByPayment"><?php echo @$aTextLang['tDSHSALTotalSaleByPayment'];?></label>
                                </div>
                            <?php }else{
                            ?>
                                    <input name="ocbCheckbox" type="hidden" value="2" >
                            <?php } ?>
                                

                            <?php
                                     $aIsAlwFuncInRoleParams = ["tUfrGrpRef" => "053", "tUfrRef" => "DSB03", "tGhdApp" => "SB"];
                                     $bChkRoleNewProductTopTen = FCNbIsAlwFuncInRole($aIsAlwFuncInRoleParams);
                            ?>
                            <?php if ($bChkRoleNewProductTopTen) { ?>
                                <div class="form-group">
                                    <input name="ocbCheckbox" type="checkbox" value="3" <?php if($tValCheck[2] != 0){ $tCheckbox = 'checked'; echo $tCheckbox; }else{echo $tCheckboxDef; }?>>
                                    <label for="olaDSHSALNewProductTopTen"><?php echo @$aTextLang['tDSHSALNewProductTopTen'];?></label>
                                </div>
                            <?php }else{
                            ?>
                                    <input name="ocbCheckbox" type="hidden" value="3" >
                            <?php } ?>

                            <!-- Page Right -->
                            <?php
                                     $aIsAlwFuncInRoleParams = ["tUfrGrpRef" => "053", "tUfrRef" => "DSB04", "tGhdApp" => "SB"];
                                     $bChkRoleTotalSaleByPdtGrp = FCNbIsAlwFuncInRole($aIsAlwFuncInRoleParams);
                            ?>
                            <?php if ($bChkRoleTotalSaleByPdtGrp) { ?>
                                <div class="form-group">
                                    <input name="ocbCheckbox" type="checkbox" value="4" <?php if($tValCheck[3] != 0){ $tCheckbox = 'checked'; echo $tCheckbox; }else{echo $tCheckboxDef; } ?>>
                                    <label for="olaDSHSALTotalSaleByPdtGrp"><?php echo @$aTextLang['tDSHSALTotalSaleByPdtGrp'];?></label>
                                </div>
                            <?php }else{
                            ?>
                                    <input name="ocbCheckbox" type="hidden" value="4" >
                            <?php } ?>

                            <?php
                                     $aIsAlwFuncInRoleParams = ["tUfrGrpRef" => "053", "tUfrRef" => "DSB05", "tGhdApp" => "SB"];
                                     $bChkRoleTotalSaleByPdtType = FCNbIsAlwFuncInRole($aIsAlwFuncInRoleParams);
                            ?>
                            <?php if ($bChkRoleTotalSaleByPdtType) { ?>
                                <div class="form-group">
                                    <input name="ocbCheckbox" type="checkbox" value="5" <?php if($tValCheck[4] != 0){ $tCheckbox = 'checked'; echo $tCheckbox; }else{echo $tCheckboxDef; } ?>>
                                    <label for="olaDSHSALTotalSaleByPdtType"><?php echo @$aTextLang['tDSHSALTotalSaleByPdtType'];?></label>
                                </div>
                            <?php }else{
                            ?>
                                    <input name="ocbCheckbox" type="hidden" value="5" >
                            <?php } ?>

                            <?php
                                     $aIsAlwFuncInRoleParams = ["tUfrGrpRef" => "053", "tUfrRef" => "DSB06", "tGhdApp" => "SB"];
                                     $bChkRoleBestSaleProductTopTen = FCNbIsAlwFuncInRole($aIsAlwFuncInRoleParams);
                            ?>
                            <?php if ($bChkRoleBestSaleProductTopTen) { ?>
                                <div class="form-group">
                                    <input name="ocbCheckbox" type="checkbox" value="6" <?php if($tValCheck[5] != 0){ $tCheckbox = 'checked'; echo $tCheckbox; }else{echo $tCheckboxDef; } ?>>
                                    <label for="olaDSHSALBestSaleProductTopTen"><?php echo @$aTextLang['tDSHSALBestSaleProductTopTen'];?></label>
                                </div>
                            <?php }else{
                            ?>
                                    <input name="ocbCheckbox" type="hidden" value="6" >
                            <?php } ?>

                            <!-- <?php
                                     $aIsAlwFuncInRoleParams = ["tUfrGrpRef" => "053", "tUfrRef" => "DSB07", "tGhdApp" => "SB"];
                                     $bChkRoleTotalByBranch = FCNbIsAlwFuncInRole($aIsAlwFuncInRoleParams);
                            ?>
                            <?php if ($bChkRoleTotalByBranch) { ?>
                                <div class="form-group">
                                    <input name="ocbCheckbox" type="checkbox" value="7" <?php if($tValCheck[6] != 0){ $tCheckbox = 'checked'; echo $tCheckbox; }else{echo $tCheckboxDef; } ?>>
                                    <label for="olaDSHSALTotalByBranch"><?php echo @$aTextLang['tDSHSALTotalByBranch'];?></label>
                                </div>
                            <?php }else{
                            ?>
                                    <input name="ocbCheckbox" type="hidden" value="7" >
                            <?php } ?> -->

                            <?php
                                     $aIsAlwFuncInRoleParams = ["tUfrGrpRef" => "053", "tUfrRef" => "DSB08", "tGhdApp" => "SB"];
                                     $bChkRoleBestSaleProductTopTenByValue = FCNbIsAlwFuncInRole($aIsAlwFuncInRoleParams);
                            ?>
                            <?php if ($bChkRoleBestSaleProductTopTenByValue) { ?>
                                <div class="form-group">
                                    <input name="ocbCheckbox" type="checkbox" value="8" <?php if($tValCheck[6] != 0){ $tCheckbox = 'checked'; echo $tCheckbox; }else{echo $tCheckboxDef; } ?>>
                                    <label for="olaDSHSALBestSaleProductTopTenByValue"><?php echo @$aTextLang['tDSHSALBestSaleProductTopTenByValue'];?></label>
                                </div>
                            <?php }else{
                            ?>
                                    <input name="ocbCheckbox" type="hidden" value="8" >
                            <?php } ?>

                            <?php
                                     $aIsAlwFuncInRoleParams = ["tUfrGrpRef" => "053", "tUfrRef" => "DSB09", "tGhdApp" => "SB"];
                                     $bChkRoleSalesComparisonChartbyYTD = FCNbIsAlwFuncInRole($aIsAlwFuncInRoleParams);
                            ?>
                            <?php if ($bChkRoleSalesComparisonChartbyYTD) { ?>
                                <div class="form-group">
                                    <input name="ocbCheckbox" type="checkbox" value="9" <?php if($tValCheck[7] != 0){ $tCheckbox = 'checked'; echo $tCheckbox; }else{echo $tCheckboxDef; } ?>>
                                    <label for="olaDSHSALSalesComparisonChartbyYTD"><?php echo @$aTextLang['tDSHSALSalesComparisonChartbyYTD'];?></label>
                                </div>
                            <?php }else{
                            ?>
                                    <input name="ocbCheckbox" type="hidden" value="9" >
                            <?php } ?>

                            <?php
                                     $aIsAlwFuncInRoleParams = ["tUfrGrpRef" => "053", "tUfrRef" => "DSB09", "tGhdApp" => "SB"];
                                     $bChkRoleSalesComparisonChartbyMTD = FCNbIsAlwFuncInRole($aIsAlwFuncInRoleParams);
                            ?>
                            <?php if ($bChkRoleSalesComparisonChartbyMTD) { ?>
                                <div class="form-group">
                                    <input name="ocbCheckbox" type="checkbox" value="10" <?php if($tValCheck[8] != 0){ $tCheckbox = 'checked'; echo $tCheckbox; }else{echo $tCheckboxDef; } ?>>
                                    <label for="olaDSHSALSalesComparisonChartbyMTD"><?php echo @$aTextLang['tDSHSALSalesComparisonChartbyMTD'];?></label>
                                </div>
                            <?php }else{
                            ?>
                                    <input name="ocbCheckbox" type="hidden" value="10" >
                            <?php } ?>



                            
                            </form>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <button id="obtDSHSALCloseConfigPage" type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo @$aTextLang['tDSHSALModalBtnCancel'];?></button>
                            <button id="obtDSHSALConfirmConfigPage" type="button" class="btn btn-primary" onclick="JSvDSHSALCheckConfigPage()"><?php echo @$aTextLang['tDSHSALModalBtnSave'];?></button>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
</div>



<script>
    function JSvDSHSALCheckConfigPage() {
        var result = $('input[name="ocbCheckbox"]');
        if (result.length > 0) {
            var aResultString = new Array();

            result.each(function() {
                aResultString.push(this.checked ? 1 : 0);
            });
          
        }

        // console.log('aResultString: '+aResultString);

        $.ajax({
            type: "POST",
            url: "dashboardsaleCallModalConfigPageSaveCookie",
            cache: false,
            data: {
                'aResultString': aResultString,
            },
            timeout: 0,
            success: function(ptViewModalHtml) {
                $('#odvDSHSALModalConfigPage').modal('hide');         
                JSvDSHSALPageDashBoardMain();
            },
            error: function(xhr, status, error) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });

    }
</script>