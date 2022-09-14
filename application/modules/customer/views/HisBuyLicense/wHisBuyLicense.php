<div class="main-menu">
    <div class="xCNMrgNavMenu">
        <div class="row xCNavRow" style="width:inherit;">
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                <ol id="oliMenuNav" class="breadcrumb">
                    <?php FCNxHADDfavorite('HisBuyLicense');?> 
                    <li id="oliHisBuyLicenseTitle" class="xCNLinkClick" onclick="JSvCallPageHisBuyLicesnse('')" style="cursor:pointer">
                        <?=language('customer/HisBuyLicense/HisBuyLicense','tHisBuyTitle'); ?>
                    </li>
                    <li id="oliHisBuyLicenseTitleReview" class="active">
                        <a><?=language('customer/HisBuyLicense/HisBuyLicense','tHisTitleReviwe')?></a>
                    </li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="xCNMenuCump" id="odvMenuCump">&nbsp;</div>
<div class="main-content">
    <div id="odvContentPageHisBuyLicense" class="panel panel-headline"></div>
</div>

<?php include "script/jHisBuyLicense.php"; ?>