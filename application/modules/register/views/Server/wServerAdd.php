<?php
    if(isset($nStaAddOrEdit) && $nStaAddOrEdit == 1){
        $tRoute     = "ServerEventEdit";
        $tSrvCode   = $aSrvData['raItems']['rtSrvCode'];
        $tSrvName   = $aSrvData['raItems']['rtSrvName'];
        $tSrvNameOth   = $aSrvData['raItems']['rtSrvNameOth'];
        $tSrvRefAPIMaste   = $aSrvData['raItems']['rtSrvRefAPIMaste'];
        $tSrvRefSBUrl   = $aSrvData['raItems']['rtSrvRefSBUrl'];
        $tSrvStaCenter   = $aSrvData['raItems']['rtSrvStaCenter'];
        $tSrvDBName   = $aSrvData['raItems']['rtSrvDBName'];
        $tSrvGroup   = $aSrvData['raItems']['rtSrvGroup'];
        $tSrvRmk   = $aSrvData['raItems']['rtSrvRmk'];

    }else{
        $tRoute     = "ServerEventAdd";
        $tSrvCode   = "";
        $tSrvName   = "";
        $tSrvNameOth   = "";
        $tSrvRefAPIMaste = "";
        $tSrvRefSBUrl = "";
        $tSrvStaCenter = "1";
        $tSrvDBName = "";
        $tSrvGroup = "1";
        $tSrvRmk   = "";
    }
?>
<form class="contact100-form validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" id="ofmAddServer">
    <button style="display:none" type="submit" id="obtSubmitServer" onclick="JSoAddEditServer('<?php echo $tRoute?>')"></button>
    <input type="hidden" id="ohdServerRoute" value="<?php echo $tRoute; ?>">
        <div class="panel-body" style="padding-top:20px !important;">
                <div class="col-xs-12 col-md-5 col-lg-5">
                    <input type="hidden" value="0" id="ohdCheckSrvClearValidate" name="ohdCheckSrvClearValidate"> 
                    <label class="xCNLabelFrm"><span style = "color:red">*</span><?= language('register/register','tSrvFrmSrvCode')?></label>
                    <?php
                    if($tRoute=="ServerEventAdd"){
                    ?>
                    <div class="form-group" id="odvSrvAutoGenCode">
                        <div class="validate-input">
                            <label class="fancy-checkbox">
                                <input type="checkbox" id="ocbSrvAutoGenCode" name="ocbSrvAutoGenCode" checked="true" value="1">
                                <span> <?php echo language('common/main/main', 'tGenerateAuto'); ?></span>
                            </label>
                        </div>
                    </div>

                    <div class="form-group" id="odvSrvCodeForm">
                        <input 
                            type="text" 
                            class="form-control xCNInputWithoutSpcNotThai xCNInputWithoutSingleQuote" 
                            maxlength="5" 
                            id="oetSrvCode" 
                            name="oetSrvCode"
                            data-is-created="<?php echo $tSrvCode; ?>"
                            placeholder="<?= language('register/register','tSrvFrmSrvCode')?>"
                            value="<?php echo $tSrvCode; ?>" 
                            data-validate-required="<?php echo language('register/register','tSrvVldCode')?>"
                            data-validate-dublicateCode="<?php echo language('register/register','tSrvVldCodeDuplicate')?>"
                            readonly
                            onfocus="this.blur()">
                        <input type="hidden" value="2" id="ohdCheckDuplicateSrvCode" name="ohdCheckDuplicateSrvCode"> 
                    </div>
                    <?php
                    }else{
                    ?>
                    
                    <div class="form-group" id="odvSrvCodeForm">
                        <input 
                            type="text" 
                            class="form-control xCNInputWithoutSpcNotThai xCNInputWithoutSingleQuote" 
                            maxlength="5" 
                            id="oetSrvCode" 
                            name="oetSrvCode"
                            data-is-created="<?php echo $tSrvCode; ?>"
                            placeholder="<?= language('register/register','tSrvFrmSrvCode')?>"
                            value="<?php echo $tSrvCode; ?>" 
                            data-validate-required="<?php echo language('register/register','tSrvVldCode')?>"
                            data-validate-dublicateCode="<?php echo language('register/register','tSrvVldCodeDuplicate')?>"
                            readonly
                            onfocus="this.blur()">
                        <input type="hidden" value="2" id="ohdCheckDuplicateSrvCode" name="ohdCheckDuplicateSrvCode"> 
                    </div>
                    <?php
                    }
                    ?>

    

                    <div class="form-group">
                        <label class="xCNLabelFrm"><span style="color:red">*</span><?php echo language('register/register','tSrvFrmSrvName')?></label>
                        <input type="text" class="form-control" maxlength="200" id="oetSrvName" name="oetSrvName" 
                        placeholder="<?php echo language('register/register','tSrvFrmSrvName')?>"
                        autocomplete="off"
                        data-validate-required="<?php echo language('register/register','tSrvVldName')?>" value="<?php echo $tSrvName ?>">
                    </div>


                    <div class="form-group">
                        <label class="xCNLabelFrm"><?php echo language('register/register','tSrvFrmSrvNameOth')?></label>
                        <input type="text" class="form-control" maxlength="200" id="oetSrvNameOth" name="oetSrvNameOth" 
                        placeholder="<?php echo language('register/register','tSrvFrmSrvNameOth')?>"
                        autocomplete="off"
                        value="<?php echo $tSrvNameOth ?>">
                    </div>


                    <div class="form-group">
                        <label class="xCNLabelFrm"><?php echo language('register/register','tSrvFrmSrvRefAPIMaste')?></label>
                        <input type="text" class="form-control" maxlength="200" id="oetSrvRefAPIMaste" name="oetSrvRefAPIMaste" 
                        placeholder="<?php echo language('register/register','tSrvFrmSrvRefAPIMaste')?>"
                        autocomplete="off"
                        value="<?php echo $tSrvRefAPIMaste ?>">
                    </div>

                    <div class="form-group">
                        <label class="xCNLabelFrm"><?php echo language('register/register','tSrvFrmSrvRefSBUrl')?></label>
                        <input type="text" class="form-control" maxlength="200" id="oetSrvRefSBUrl" name="oetSrvRefSBUrl" 
                        placeholder="<?php echo language('register/register','tSrvFrmSrvRefSBUrl')?>"
                        autocomplete="off"
                        value="<?php echo $tSrvRefSBUrl ?>">
                    </div>
                    
                    <div class="form-group">
                        <label class="xCNLabelFrm"><?php echo language('register/register','tSrvFrmSrvStaCenter')?></label>
                      <select class="form-control" name="ocmSrvStaCenter" id="ocmSrvStaCenter" >
                        <option value="1" <?php if($tSrvStaCenter=='1'){ echo 'selected'; } ?> ><?php echo language('register/register','tSrvFrmSrvStaCenter1')?></option>
                        <option value="2" <?php if($tSrvStaCenter=='2'){ echo 'selected'; } ?> ><?php echo language('register/register','tSrvFrmSrvStaCenter2')?></option>
                      </select>
                    </div>


                    <div class="form-group">
                        <label class="xCNLabelFrm"><?php echo language('register/register','tSrvFrmSrvDBName')?></label>
                        <input type="text" class="form-control" maxlength="200" id="oetSrvDBName" name="oetSrvDBName" 
                        placeholder="<?php echo language('register/register','tSrvFrmSrvDBName')?>"
                        autocomplete="off"
                        value="<?php echo $tSrvDBName ?>">
                    </div>

                  <div class="form-group">
                        <label class="xCNLabelFrm"><?php echo language('register/register','tSrvFrmSrvGroup')?></label>
                      <select class="form-control" name="ocmSrvGroup" id="ocmSrvGroup" >
                        <option value="1" <?php if($tSrvGroup=='1'){ echo 'selected'; } ?> ><?php echo language('register/register','tSrvFrmSrvGroup1')?></option>
                        <option value="2" <?php if($tSrvGroup=='2'){ echo 'selected'; } ?> ><?php echo language('register/register','tSrvFrmSrvGroup2')?></option>
                      </select>
                    </div>

                    <div class="form-group">
                        <label class="xCNLabelFrm"><?php echo language('register/register','tSrvFrmSrvRmk')?></label>
                        <textarea   name="otaSrvRmk" id="otaSrvRmk" rows="10"><?=$tSrvRmk?></textarea>
                    </div>


                </div>
            </div>
    </div>
</form>
<script src="<?= base_url('application/modules/common/assets/js/jquery.mask.js')?>"></script>
<script src="<?= base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>
<script>
    $('#obtGenCodeServer').click(function(){
        JStGenerateServerCode();
    });

    //BrowseAgn 
    $('#oimBrowseAgn').click(function(e){
        e.preventDefault();
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSxCheckPinMenuClose();
            window.oPdtBrowseAgencyOption = oBrowseAgn({
                'tReturnInputCode'  : 'oetSrvAgnCode',
                'tReturnInputName'  : 'oetSrvAgnName',
            });
            JCNxBrowseData('oPdtBrowseAgencyOption');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    var nLangEdits  = <?php echo $this->session->userdata("tLangEdit")?>;

    //Option Agn
    var oBrowseAgn =   function(poReturnInput){
        var tInputReturnCode    = poReturnInput.tReturnInputCode;
        var tInputReturnName    = poReturnInput.tReturnInputName;

        var oOptionReturn       = {
            Title : ['ticket/agency/agency', 'tAggTitle'],
            Table:{Master:'TCNMAgency', PK:'FTAgnCode'},
            Join :{
            Table: ['TCNMAgency_L'],
                On: ['TCNMAgency_L.FTAgnCode = TCNMAgency.FTAgnCode AND TCNMAgency_L.FNLngID = '+nLangEdits]
            },
            GrideView:{
                ColumnPathLang	: 'ticket/agency/agency',
                ColumnKeyLang	: ['tAggCode', 'tAggName'],
                ColumnsSize     : ['15%', '85%'],
                WidthModal      : 50,
                DataColumns		: ['TCNMAgency.FTAgnCode', 'TCNMAgency_L.FTAgnName'],
                DataColumnsFormat : ['', ''],
                Perpage			: 10,
                OrderBy			: ['TCNMAgency.FDCreateOn DESC'],
            },
            CallBack:{
                ReturnType	: 'S',
                Value		: [tInputReturnCode,"TCNMAgency.FTAgnCode"],
                Text		: [tInputReturnName,"TCNMAgency_L.FTAgnName"],
            },
            RouteAddNew : 'agency',
            BrowseLev : 1,
        }
        return oOptionReturn;
    }

    var tStaUsrLevel    = '<?php  echo $this->session->userdata("tSesUsrLevel"); ?>';

    if(tStaUsrLevel == 'BCH' || tStaUsrLevel == 'SHP'){
        $('#oimBrowseAgn').attr("disabled", true);
    }

</script>

