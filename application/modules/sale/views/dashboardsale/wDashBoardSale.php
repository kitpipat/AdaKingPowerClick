<input type="hidden" id="ohdDSHSALBrowseType" value="<?php echo $nDSHSALBrowseType; ?>">
<input type="hidden" id="ohdDSHSALBrowseOption" value="<?php echo $tDSHSALBrowseOption; ?>">
<?php
$dDateToday         = date("Y-m-d");
$dFirstDateOfMonth  = $dDateToday;
$dLastDateOfMonth   = $dDateToday;

$aAlwDashboard      = $this->config->item('AlwDashBoard');

?>
<?php if (isset($nDSHSALBrowseType) && $nDSHSALBrowseType == 0) : ?>
    <div id="odvDSHSALMainMenu" class="main-menu">
        <div class="xCNMrgNavMenu">
            <div class="row xCNavRow" style="width:inherit;">
                <div class="col-xs-12 col-sm-12 col-md-2 col-lg-3">
                    <ol id="oliDSHSALMenuNav" class="breadcrumb">
                        <?php FCNxHADDfavorite('dashboardsale/0/0'); ?>
                        <li id="oliDSHSALTitle" style="cursor:pointer;"><?php echo @$aTextLang['tDSHSALTitleMenu']; ?></li>
                    </ol>
                </div>
                <div class="col-xs-12 col-sm-1 col-md-1 col-lg-1 text-right" style="padding:0px;margin-top:0.3rem;">
                    <label class="xCNLabelFrm"><?php echo @$aTextLang['tDSHSALDateDataFrom']; ?></label>
                </div>
                <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 p-r-0 text-right">
                    <div class="form-group">
                        <div class="input-group">
                            <input type="text" class="form-control text-center xCNDatePicker xWPointerEventNone" id="oetDSHSALDateDataForm" name="oetDSHSALDateDataForm" value="<?php echo @$dFirstDateOfMonth; ?>">
                            <span class="input-group-btn">
                                <button id="obtDSHSALDateDataForm" type="button" class="btn xCNBtnBrowseAddOn"><img class="xCNIconCalendar"></button>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-1 col-md-1 col-lg-1 text-right" style="padding:0px;margin-top:0.3rem;">
                    <label class="xCNLabelFrm"><?php echo @$aTextLang['tDSHSALDateDataTo']; ?></label>
                </div>
                <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 p-r-0 text-right">
                    <div class="form-group">
                        <div class="input-group">
                            <input type="text" class="form-control text-center xCNDatePicker xWPointerEventNone" id="oetDSHSALDateDataTo" name="oetDSHSALDateDataTo" value="<?php echo @$dLastDateOfMonth; ?>">
                            <span class="input-group-btn">
                                <button id="obtDSHSALDateDataTo" type="button" class="btn xCNBtnBrowseAddOn"><img class="xCNIconCalendar"></button>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 p-r-0 text-right">
                    <div class="form-group">
                        <select class="selectpicker form-control" tabindex="-98" id="ocmDSHSALAllows" name="ocmDSHSALAllows" readonly>
                            <?php 
                                if( FCNnHSizeOf($aAlwDashboard) > 1 ){ 
                                    $nCount = 0;
                                    $tValueAllAlw = "";
                                    foreach($aAlwDashboard as $nKey => $tValue){
                                        if( $nCount > 0 ){
                                            $tValueAllAlw .= $nKey;
                                        }else{
                                            $tValueAllAlw .= $nKey.",";
                                        }
                                        $nCount++;
                                    }
                            ?>
                            <option value="<?=$tValueAllAlw;?>"><?php echo language('dashboard/dashboard','tAlwDashboardAll');?></option>
                            <?php } ?>

                            <?php foreach($aAlwDashboard as $nKey => $tValue){ ?>
                                    <option value="<?=$nKey;?>"><?php echo language('dashboard/dashboard','tAlwDashboard'.$tValue);?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <div class="col-xs-12 col-sm-2 col-md-2 col-lg-1 p-r-0 text-right">
                    <button id="obtDSHSALConfigPage" type="button" class="btn xCNBTNPrimery xCNLabelFrm" data-dismiss="modal" style="width: 100%; margin-top: 3px;"><?= language('movement/movement/movement','tMMTListSearch')?></button>
                </div>



            </div>
        </div>
    </div>
    <div class="xCNMenuCump xCNDSHSALBrowseLine" id="odvMenuCump">&nbsp;</div>
    <div class="main-content">
        <div id="odvDSHSALContentPage">
        </div>
    </div>
    <div id="odvDSHSALModalConfigPageHTML"></div>
<?php endif; ?>
<script type="text/javascript" src="<?php echo base_url(); ?>application/modules/sale/assets/src/dashboardsale/jDashBoardSale.js"></script>


<script type="text/javascript">
    $(document).ready(function() {

        $('.selectpicker').selectpicker();

        $('#ocmDSHSALAllows').off('change');
        $('#ocmDSHSALAllows').on('change',function(){
            JSvDSHSALPageDashBoardMain();
            $('.selectpicker').selectpicker('refresh');
        });

        $('#obtDSHSALConfigPage').click(function() {
            $.ajax({
                type: "POST",
                url: "dashboardsaleCallModalConfigPage",
                cache: false,
                timeout: 0,
                success: function(ptViewModalHtml) {
                    $('#odvDSHSALModalConfigPageHTML').html(ptViewModalHtml);
                    $('#odvDSHSALModalConfigPage').modal({
                        backdrop: 'static',
                        keyboard: false
                    })
                    $('#odvDSHSALModalConfigPage').modal('show');
                },
                error: function(xhr, status, error) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        });
    });
</script>