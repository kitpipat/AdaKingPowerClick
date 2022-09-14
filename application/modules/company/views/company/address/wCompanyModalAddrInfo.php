<?php
    if(isset($aDataAddress) && !empty($aDataAddress)){
        $tCmpAddrName       = $aDataAddress['FTAddName'];
        $tCmpAddrTaxNo      = $aDataAddress['FTAddTaxNo'];
        $tCmpAddrRmk        = $aDataAddress['FTAddRmk'];
        $tCmpAddrCountry    = $aDataAddress['FTAddCountry'];
        $tCmpAddrVersion    = $aDataAddress['FTAddVersion'];
        $tCmpAddrV1No       = $aDataAddress['FTAddV1No'];
        $tCmpAddrV1Soi      = $aDataAddress['FTAddV1Soi'];
        $tCmpAddrV1Village  = $aDataAddress['FTAddV1Village'];
        $tCmpAddrV1Road     = $aDataAddress['FTAddV1Road'];
        $tCmpAddrV1SudCode  = $aDataAddress['FTSudCode'];
        $tCmpAddrV1SudName  = $aDataAddress['FTSudName'];
        $tCmpAddrV1DstCode  = $aDataAddress['FTDstCode'];
        $tCmpAddrV1DstName  = $aDataAddress['FTDstName'];
        $tCmpAddrV1PvnCode  = $aDataAddress['FTPvnCode'];
        $tCmpAddrV1PvnName  = $aDataAddress['FTPvnName'];
        $tCmpAddrV1ZipCode  = $aDataAddress['FTAddV1PostCode'];
        $tCmpAddrV2Desc1    = $aDataAddress['FTAddV2Desc1'];
        $tCmpAddrV2Desc2    = $aDataAddress['FTAddV2Desc2'];
        $tCmpAddrWebsite    = $aDataAddress['FTAddWebsite'];
    }else{
        $tCmpAddrName       = "";
        $tCmpAddrTaxNo      = "";
        $tCmpAddrRmk        = "";
        $tCmpAddrCountry    = "";
        $tCmpAddrVersion    = "";
        $tCmpAddrV1No       = "";
        $tCmpAddrV1Soi      = "";
        $tCmpAddrV1Village  = "";
        $tCmpAddrV1Road     = "";
        $tCmpAddrV1SudCode  = "";
        $tCmpAddrV1SudName  = "";
        $tCmpAddrV1DstCode  = "";
        $tCmpAddrV1DstName  = "";
        $tCmpAddrV1PvnCode  = "";
        $tCmpAddrV1PvnName  = "";
        $tCmpAddrV1ZipCode  = "";
        $tCmpAddrV2Desc1    = "";
        $tCmpAddrV2Desc2    = "";
        $tCmpAddrWebsite    = "";
    }
?>
<?php if(isset($tCmpAddrVersion) &&  $tCmpAddrVersion == 1): ?>
    <div class="row">
        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
            <div class="form-group">
                <label class="xCNLabelFrm"><?php echo language('company/company/company','tCMPAddrName') ?></label>
                <p class="xCNTextDetail">
                    <?php
                        if(isset($tCmpAddrName) && !empty($tCmpAddrName)){
                            echo @$tCmpAddrName;
                        }else{
                            echo language('company/company/company','tCmpNotFoundData');
                        }
                    ?>
                </p>
            </div>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
            <div class="form-group">
                <label class="xCNLabelFrm"><?php echo language('company/company/company','tCMPTaxNo') ?></label>
                <p class="xCNTextDetail">
                    <?php
                        if(isset($tCmpAddrTaxNo) && !empty($tCmpAddrTaxNo)){
                            echo @$tCmpAddrTaxNo;
                        }else{
                            echo language('company/company/company','tCmpNotFoundData');
                        }
                    ?>
                </p>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
            <div class="form-group">
                <label class="xCNLabelFrm"><?php echo language('company/company/company','tCMPWebsite') ?></label>
                <p class="xCNTextDetail">
                    <?php
                        if(isset($tCmpAddrWebsite) && !empty($tCmpAddrWebsite)){
                            echo @$tCmpAddrWebsite;
                        }else{
                            echo language('company/company/company','tCmpNotFoundData');
                        }
                    ?>
                </p>
            </div>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
            <div class="form-group">
                <label class="xCNLabelFrm"><?php echo language('company/company/company','tCMPCountry') ?></label>
                <p class="xCNTextDetail">
                    <?php
                        if(isset($tCmpAddrCountry) && !empty($tCmpAddrCountry)){
                            echo @$tCmpAddrCountry;
                        }else{
                            echo language('company/company/company','tCmpNotFoundData');
                        }
                    ?>
                </p>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
            <div class="form-group">
                <label class="xCNLabelFrm"><?php echo language('company/company/company','tCMPAddressNo') ?></label>
                <p class="xCNTextDetail">
                    <?php
                        if(isset($tCmpAddrV1No) && !empty($tCmpAddrV1No)){
                            echo @$tCmpAddrV1No;
                        }else{
                            echo language('company/company/company','tCmpNotFoundData');
                        }
                    ?>
                </p>
            </div>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
            <div class="form-group">
                <label class="xCNLabelFrm"><?php echo language('company/company/company','tCMPSoi') ?></label>
                <p class="xCNTextDetail">
                    <?php
                        if(isset($tCmpAddrV1Soi) && !empty($tCmpAddrV1Soi)){
                            echo @$tCmpAddrV1Soi;
                        }else{
                            echo language('company/company/company','tCmpNotFoundData');
                        }
                    ?>
                </p>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
            <div class="form-group">
                <label class="xCNLabelFrm"><?php echo language('company/company/company','tCMPVillage') ?></label>
                <p class="xCNTextDetail">
                    <?php
                        if(isset($tCmpAddrV1Village) && !empty($tCmpAddrV1Village)){
                            echo @$tCmpAddrV1Village;
                        }else{
                            echo language('company/company/company','tCmpNotFoundData');
                        }
                    ?>
                </p>
            </div>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
            <div class="form-group">
                <label class="xCNLabelFrm"><?php echo language('company/company/company','tCMPRoad') ?></label>
                <p class="xCNTextDetail">
                    <?php
                        if(isset($tCmpAddrV1Road) && !empty($tCmpAddrV1Road)){
                            echo @$tCmpAddrV1Road;
                        }else{
                            echo language('company/company/company','tCmpNotFoundData');
                        }
                    ?>
                </p>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
            <div class="form-group">
                <label class="xCNLabelFrm"><?php echo language('company/company/company','tCMPSubDistrict') ?></label>
                <p class="xCNTextDetail">
                    <?php
                        if(isset($tCmpAddrV1SudName) && !empty($tCmpAddrV1SudName)){
                            echo @$tCmpAddrV1SudName;
                        }else{
                            echo language('company/company/company','tCmpNotFoundData');
                        }
                    ?>
                </p>
            </div>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
            <div class="form-group">
                <label class="xCNLabelFrm"><?php echo language('company/company/company','tCMPDistict') ?></label>
                <p class="xCNTextDetail">
                    <?php
                        if(isset($tCmpAddrV1DstName) && !empty($tCmpAddrV1DstName)){
                            echo @$tCmpAddrV1Road;
                        }else{
                            echo language('company/company/company','tCmpNotFoundData');
                        }
                    ?>
                </p>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
            <div class="form-group">
                <label class="xCNLabelFrm"><?php echo language('company/company/company','tCMPProvince') ?></label>
                <p class="xCNTextDetail">
                    <?php
                        if(isset($tCmpAddrV1PvnName) && !empty($tCmpAddrV1PvnName)){
                            echo @$tCmpAddrV1PvnName;
                        }else{
                            echo language('company/company/company','tCmpNotFoundData');
                        }
                    ?>
                </p>
            </div>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
            <div class="form-group">
                <label class="xCNLabelFrm"><?php echo language('company/company/company','tCMPZipCode') ?></label>
                <p class="xCNTextDetail">
                    <?php
                        if(isset($tCmpAddrV1ZipCode) && !empty($tCmpAddrV1ZipCode)){
                            echo @$tCmpAddrV1ZipCode;
                        }else{
                            echo language('company/company/company','tCmpNotFoundData');
                        }
                    ?>
                </p>
            </div>
        </div>
    </div>
<?php elseif(isset($tCmpAddrVersion) &&  $tCmpAddrVersion == 2): ?>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="form-group">
                <label class="xCNLabelFrm"><?php echo language('company/company/company','tCMPAddrName') ?></label>
                <p class="xCNTextDetail p-l-10">
                    <?php
                        if(isset($tCmpAddrName) && !empty($tCmpAddrName)){
                            echo @$tCmpAddrName;
                        }else{
                            echo language('company/company/company','tCmpNotFoundData');
                        }
                    ?>
                </p>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="form-group">
                <label class="xCNLabelFrm"><?php echo language('company/company/company','tCMPTaxNo') ?></label>
                <p class="xCNTextDetail p-l-10">
                    <?php
                        if(isset($tCmpAddrTaxNo) && !empty($tCmpAddrTaxNo)){
                            echo @$tCmpAddrTaxNo;
                        }else{
                            echo language('company/company/company','tCmpNotFoundData');
                        }
                    ?>
                </p>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="form-group">
                <label class="xCNLabelFrm"><?php echo language('company/company/company','tCMPWebsite') ?></label>
                <p class="xCNTextDetail p-l-10">
                    <?php
                        if(isset($tCmpAddrWebsite) && !empty($tCmpAddrWebsite)){
                            echo @$tCmpAddrWebsite;
                        }else{
                            echo language('company/company/company','tCmpNotFoundData');
                        }
                    ?>
                </p>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="form-group">
                <label class="xCNLabelFrm"><?php echo language('company/company/company','tCMPAddress1') ?></label>
                <p class="xCNTextDetail p-l-10">
                    <?php
                        if(isset($tCmpAddrV2Desc1) && !empty($tCmpAddrV2Desc1)){
                            echo @$tCmpAddrV2Desc1;
                        }else{
                            echo language('company/company/company','tCmpNotFoundData');
                        }
                    ?>
                </p>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="form-group">
                <label class="xCNLabelFrm"><?php echo language('company/company/company','tCMPAddress2') ?></label>
                <p class="xCNTextDetail p-l-20">
                    <?php
                        if(isset($tCmpAddrV2Desc2) && !empty($tCmpAddrV2Desc2)){
                            echo @$tCmpAddrV2Desc2;
                        }else{
                            echo language('company/company/company','tCmpNotFoundData');
                        }
                    ?>
                </p>
            </div>
        </div>
    </div>
<?php endif;?>