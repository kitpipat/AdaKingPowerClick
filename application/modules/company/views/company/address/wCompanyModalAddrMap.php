<?php
    if(isset($aDataAddress) && !empty($aDataAddress)){
        $tCmpAddrLongitude  = $aDataAddress['FTAddLongitude'];
        $tCmpAddrLatitude   = $aDataAddress['FTAddLatitude'];
    }else{
        $tCmpAddrLongitude  = '100.50182294100522';
        $tCmpAddrLatitude   = '13.757309968845291';
    }
?>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <input type="hidden" id="oetCmpMapLong" name="oetCmpMapLong" value="<?php echo floatval($tCmpAddrLongitude);?>">
        <input type="hidden" id="oetCmpMapLat" name="oetCmpMapLat" value="<?php echo floatval($tCmpAddrLatitude);?>">
        <label class="xCNLabelFrm"><?php echo language('company/company/company','tCMPMap') ?></label>
        <div id="odvCmpMapShow" class="xCNMapShow" style="height:400px;width:100%;margind:0;padding:0px">
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        var oMapCompany = {
            tDivShowMap	:'odvCmpMapShow',
            cLongitude	: <?php echo (isset($tCmpAddrLongitude)&&!empty($tCmpAddrLongitude))? floatval($tCmpAddrLongitude):floatval('100.50182294100522')?>,
            cLatitude	: <?php echo (isset($tCmpAddrLatitude)&&!empty($tCmpAddrLatitude))? floatval($tCmpAddrLatitude):floatval('13.757309968845291')?>,
            tInputLong	: 'oetCmpMapLong',
            tInputLat	: 'oetCmpMapLat',
            tIcon		: '<?php echo base_url().'application/modules/common/assets/images/icons/icon_mark.png';?>',
            tStatus		: '1'	
        }
        JSxMapAddEdit(oMapCompany);
    });
</script>