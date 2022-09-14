<input type="hidden" id="oetPosRegStaBrowse" value="<?php echo $nPosRegBrowseType;?>">
<input type="hidden" id="oetPosRegCallBackOption" value="<?php echo $tPosRegBrowseOption;?>">

<div id="odvPosRegisterMainMenu" class="main-menu">
    <div class="xCNMrgNavMenu">
        <div class="row xCNavRow" style="width:inherit;">
            <div class="xCNPosRegisterVMaster">
                <div class="col-xs-12 col-md-8">
                    <ol id="oliMenuNav" class="breadcrumb">
                        <?php FCNxHADDfavorite('posreg/0/0');?>
                        <li id="oliPosRegisterTitle" class="xCNLinkClick" onclick="JSvPosRegisterCallPageList()"><?php echo language('pos/posreg/posreg', 'tPosRegTitle'); ?></li>
                    </ol>
                </div>
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 text-right p-r-0"> 
                    <div id="odvBtnAddEdit" style="display: block;">
                        <div class="btn-group">
                            <button onclick="JSxPosRegisterSave()" type="button" class="btn xCNBTNPrimery xCNBTNPrimery2Btn xCNBTNSave" style="margin-left: 5px;" style="display: block;"><?php echo language('pos/posreg/posreg', 'tStaApprove'); ?></button>
                            <button onclick="JSxPosRegisterCancel()"  type="button" class="btn xCNBTNPrimery xCNBTNPrimery2Btn xCNBTNCancel" style="margin-left: 5px;" style="display: block;"><?php echo language('pos/posreg/posreg', 'tStaCancel'); ?></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="xCNMenuCump" id="odvMenuCump">&nbsp;</div>

<div class="main-content">
    <div id="odvContentPagePosRegister"></div>
</div>

<!--MODAL กดยกเลิก-->
<div class="modal fade" id="odvModalConCancel">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="xCNHeardModal modal-title" style="display:inline-block"><?=language('common/main/main', 'tModalConfirm'); ?></h5>
            </div>
            <div class="modal-body">
                <p><b><?=language('pos/posreg/posreg', 'tModalShow'); ?></b></p>
                <p><?=language('pos/posreg/posreg', 'tModalShow1'); ?></p>
                <p><?=language('pos/posreg/posreg', 'tModalShow2'); ?></p>
                <p><b><?=language('pos/posreg/posreg', 'tModalShow3'); ?></b></p>
            </div>
            <div class="modal-footer">
                <button onclick="JSxPosRegModalConfirm()" type="button" class="btn xCNBTNPrimery">
                    <?=language('common/main/main', 'tModalConfirm'); ?>
                </button>
                <button type="button" class="btn xCNBTNDefult" data-dismiss="modal">
                    <?=language('common/main/main', 'tModalCancel'); ?>
                </button>
            </div>
        </div>
    </div>
</div>


<script src="<?php echo base_url('application/modules/pos/assets/src/posregister/jPosRegister.js')?>"></script>