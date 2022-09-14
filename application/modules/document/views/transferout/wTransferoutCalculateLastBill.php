<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 panel panel-default" style="background: white;height: 180px;">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding:15px;">
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-center">
            <label class="xCNLabelFrm"><?php echo language('document/transferout/transferout', 'tTXOTotalCash');?></label>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-center">
            <label class="xCNLabelFrm" id="olbFCXthTotal"><?php echo $cTXOTotal ?></label>
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding:15px;">
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-center">
            <label class="xCNLabelFrm"><?php echo language('document/transferout/transferout', 'tTXOVatRate');?></label>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-center">
            <label class="xCNLabelFrm" id="olaVatTotal"><?php echo $cTXOSumVat;?></label>
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding:15px;">
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-center">
            <label class="xCNLabelFrm"><?php echo language('document/transferout/transferout', 'tTXOGrandB4Wht'); ?></label>
        </div>
        <div class="col-lg-6 text-center">
            <label class="xCNLabelFrm" id="olaGrandB4Wht"><?php echo $cTXOTotal ?></label>
        </div>
    </div>
</div>