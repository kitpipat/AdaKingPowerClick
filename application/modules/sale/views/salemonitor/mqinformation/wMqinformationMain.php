<style>
    .xWMQISALHeadPanel{
        border-bottom:1px solid #cfcbcb8a !important;
        padding-bottom:0px !important;
    }

    .xWMQISALTextNumber{
        font-size: 25px !important;
        font-weight: bold;
    }
    
    .xWMQISALPanelMainRight{
        padding-bottom:0px;
        min-height:300px;
        overflow-x: auto;
    }

    .xWMQISALFilter{
        cursor: pointer;
    }

    .xWMQISALRequest{
        cursor: pointer;
    }
    .xWOverlayLodingChart{
        position: absolute;
	    min-width: 100%;
	    min-height: 100%;
	    width: 100%;
	    background: #FFFFFF;
	    z-index: 2500;
	    display: none;
	    top: 0%;
        margin-left: 0px;
        left: 0%;
    }
</style>

<div class="row">
  
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <!-- Tab MQInformation -->
        <div id="odvMQISALPanelRight1" class="">
            <div class="panel-collapse collapse in" role="tabpanel">
                <div class="panel-body xWMQISALPanelMainRight">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div style="padding-bottom:0px;">
                            <div class="col-xs-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label class="xCNLabelFrm"><?=language('sale/salemonitor/salemonitor', 'tMQISearch')?></label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="oetMQISearch" name="oetMQISearch" placeholder="<?=language('sale/salemonitor/salemonitor', 'tMQISearchKey')?>">
                                            <span class="input-group-btn">
                                                <button id="obtMQISearch" class="btn xCNBtnSearch" type="button">
                                                    <img class="xCNIconAddOn" src="<?=base_url('/')?>/application/modules/common/assets/images/icons/search-24.png">
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-1 col-lg-1"  style="margin-top:25px;">
                                <button id="obtMQIReload" class="btn btn-info" type="button">
                                <i class="fa fa-refresh" aria-hidden="true"></i> &nbsp; <?=language('sale/salemonitor/salemonitor', 'tSMTReload')?>
                                </button>
                                </div>
                                <div class="col-xs-12 col-md-5 col-lg-5 text-right" style="margin-top:25px;">   
                                        <?php if($bChkRoleButton==1){?>
                                        <button type="button" id="obtFroceReProcess" class="btn btn-primary xCNBTNMngTable" data-toggle="dropdown">
                                        <i class="fa fa-retweet" aria-hidden="true"></i>  &nbsp;<?=language('sale/salemonitor/salemonitor', 'tMQIRestartBackground')?>				
                                        </button>
                                        <?php } ?>
                                </div>
                                   
                                        <div class="col-md-12 xWMQIDataTable"  id="odvMQIDataTable">

                                        </div>
                                  
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>

 
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){


        JCNxMQICallDataTable();
    });


    $('#obtMQIReload').click(function(){
        JCNxMQICallDataTable();
    });

            // Function: Confirm Filter DashBoard
            // Parameters: Document Ready Or Parameter Event
            // Creator: 06/02/2020 Nattakit
            // Return: View Data Table
            // ReturnType: View
            function JCNxMQICallDataTable(nPageCurrent){
                JCNxOpenLoading();
                    var tMQISearch = $('#oetMQISearch').val();
                $.ajax({
                    type: "POST",
                    url: "dasMQICallDataTable",
                    data: {tMQISearch:tMQISearch},
                    cache: false,
                    timeout: 0,
                    success : function(paDataReturn){
                        $('#odvMQIDataTable').html(paDataReturn);
    
                        JCNxCloseLoading();
                    },
                    error : function (jqXHR, textStatus, errorThrown) {
                        JCNxResponseError(jqXHR,textStatus,errorThrown);
                    }
                });
            }


$('#obtFroceReProcess').click(function(){
        if(confirm('<?=language('sale/salemonitor/salemonitor', 'tMQConfirmConsumer')?>')==true){
            JCNxOpenLoading();
            var oListItem = $(".ocbListItem:checkbox:checked").map(function(){
                return $(this).val();
                }).get(); 
                // console.log(ocbListItem);
            $.ajax({
                    type: "POST",
                    url: "dasMQIEventReConsumer",
                    data: {oListItem:oListItem},
                    cache: false,
                    timeout: 0,
                    success : function(paDataReturn){
                        var paDataReturn = JSON.parse(paDataReturn);
                        if(paDataReturn['nStaEvent']==1){
                         JCNxCloseLoading();
                         FSvCMNSetMsgSucessDialog('<?=language('sale/salemonitor/salemonitor', 'tMQReStratConsumerSuccess')?>');
                         JCNxMQICallDataTable();
                        }else{
                        JCNxCloseLoading();
                         FSvCMNSetMsgErrorDialog(paDataReturn['tStaMessg']);
                        }
                    },
                    error : function (jqXHR, textStatus, errorThrown) {
                        JCNxResponseError(jqXHR,textStatus,errorThrown);
                    }
                });

        }
})
</script>
