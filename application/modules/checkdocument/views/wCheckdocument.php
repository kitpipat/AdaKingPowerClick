<style>
    .xCNHederMenuWithoutFav{
        font-family : THSarabunNew-Bold;
        font-size   : 21px !important;
        line-height : 32px;
        font-weight : 500;
        color       : #1866ae !important;
    }
</style>

<div id="odvCpnMainMenu" class="main-menu clearfix">
	<div class="xCNMrgNavMenu">
		<div class="row xCNavRow" style="width:inherit;">

            <div class="col-xs-6 col-sm-8 col-md-8 col-lg-8">      
                <ol id="oliMenuNav" class="breadcrumb">
                    <li id="oliMNTTitle" class="xCNLinkClick xCNHederMenuWithoutFav" onclick="JSxMNTGetPageForm()" style="curMNTr:pointer">
                        <?php $tLangName = language('checkdocument/checkdocument','tChkDocTitle'); ?>
                        <?= $tLangName ?>
                    </li>
                    <!-- <li id="oliMNTTitleAdd" class="active"><a><?php echo language('checkdocument/checkdocument','tChkDocAddPage')?></a></li>
                    <li id="oliMNTTitleEdit" class="active"><a><?php echo language('checkdocument/checkdocument','tChkDocAddView')?></a></li> -->
                </ol>
            </div>
			
			<div class="col-xs-6 col-sm-4 col-md-4 col-lg-4 text-right p-r-0">
                     <!-- <button id="obtMNTCallPageAdd" class="xCNBTNPrimeryPlus" type="button">+</button> -->
                     <!-- <div id="odvMNTBtnGrpAddEdit">
                            <div class="demo-button xCNBtngroup" style="width:100%;">
                                <button id="obtMNTCallBackPage"  class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"> <?php echo language('common/main/main','tBack');?></button>
                                    <div class="btn-group odvMNTBtnGrpSave">
                                        <button id="obtMntSendNoti" type="button" class="btn btn xCNBTNPrimery xCNBTNPrimery2Btn"> <?php echo language('checkdocument/checkdocument','tMntBtnSend');?></button>
                                     
                                    </div>
                            </div>
                        </div> -->
			</div>
		</div>
	</div>
</div>
<form class="contact100-form validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" id="ofmCheckdocument">
<input type="hidden" name="ohdMNTTypePage" id="ohdMNTTypePage" value="<?=$nType?>">
<div id="odvMNTPageFrom"></div>
</form>



<script src="<?php echo base_url('application/modules/checkdocument/assets/src/jCheckdocument.js')?>"></script>
