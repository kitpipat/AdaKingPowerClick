<input id="oetRVDStaBrowse" type="hidden" value="<?=$nBrowseType?>">
<input id="oetRVDCallBackOption" type="hidden" value="<?=$tBrowseOption?>">

<div id="odvRVDMainMenu" class="main-menu">
    <div class="xCNMrgNavMenu">
        <div class="row xCNavRow" style="width:inherit;">
            <div class="col-xs-12 col-sm-5 col-md-5 col-lg-5">
                <ol id="oliRVDMenuNav" class="breadcrumb">
                    <?php FCNxHADDfavorite('docRVDRefillPDTVD/0/0');?> 
                    <li id="oliRVDTitle"        class="xCNLinkClick" onclick="JSvRVDCallPageList()" style="cursor:pointer;"><?=language('document/RefillProductVD/RefillProductVD','tTitle');?></li>
                    <li id="oliRVDTitleAdd"     class="active"><a><?=language('document/RefillProductVD/RefillProductVD','tRVDTitleAdd');?></a></li>
                    <li id="oliRVDTitleEdit"    class="active"><a><?=language('document/RefillProductVD/RefillProductVD','tRVDTitleEdit');?></a></li>
                </ol>
            </div>
            <div class="col-xs-12 col-sm-7 col-md-7 col-lg-7 text-right p-r-0">
                <div class="xCNBtngroup" style="width:100%;">
                    <div id="odvBtnRVDInfo">
                        <?php if($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaAdd'] == 1) : ?>
                            <button id="obtRVDCallPageAdd" class="xCNBTNPrimeryPlus" type="button" onclick="JSvRVDCallPageAdd()">+</button>
                        <?php endif; ?>
                    </div>
                    <div id="odvBtnAddEdit">
                        <div class="xCNBtngroup" style="width:100%;">
                            <button id="obtRVDCallBackPage" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button" onclick="JSvRVDCallPageList()"> <?=language('common/main/main', 'tBack')?></button>
                            <?php if($aAlwEvent['tAutStaFull'] == 1 || ($aAlwEvent['tAutStaAdd'] == 1 || $aAlwEvent['tAutStaEdit'] == 1)) : ?>
                                <button id="obtRVDPrint"   onclick="JSxRVDPrintDocument()"  class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"> <?=language('common/main/main', 'tCMNPrint')?></button>
                                <button id="obtRVDCancel"  onclick="JSvRVDCancleDocument(false)"  class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"> <?=language('common/main/main', 'tCancel')?></button>
                                <button id="obtRVDApprove" onclick="JSxRVDApprovedDocument(false,false)"  class="btn xCNBTNPrimery xCNBTNPrimery2Btn" type="button"> <?=language('common/main/main', 'tCMNApprove')?></button>
                                <div class="btn-group xCNRVDBtnSave">
                                    <button id="obtRVDSubmitFrom" type="button" class="btn xWBtnGrpSaveLeft" onclick="$('#obtSubmitRVD').click()"> <?=language('common/main/main', 'tSave')?></button>
                                    <?=$vBtnSave?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="xCNMenuCump xCNRVDBrowseLine" id="odvMenuCump">
    &nbsp;
</div>
<div class="main-content">
    <div id="odvContentPageRVD"></div>
</div>

<?php include('script/jRefillProductVD.php') ?>

