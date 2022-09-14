<style>

.xCNComboSelect{
    height: 33px !important;
}

.filter-option-inner-inner{
    margin-top : 0px;
}

.dropdown-toggle{
    height: 33px !important;
}
</style>


<div class="row">
    <div class="col-xs-8 col-md-4 col-lg-4">
        <div class="form-group">
            <div class="row">
                <div id="odvlevType" class="col-xs-12 col-sm-5 col-md-5 col-lg-5">
                    <div class="form-group">
                        <label class="xCNLabelFrm"><?=language('company/compsettingconnect/compsettingconnect','tCompSettingLevel')?></label>
                        <select class="selectpicker form-control xCNComboSelect" id="ocmlevType" style="height:33px !important;">
                        <option value="1"><?=language('company/compsettingconnect/compsettingconnect','tOptionCompany')?></option>
                            <option value="2"><?=language('company/compsettingconnect/compsettingconnect','tOptionBranch')?></option>
                        </select>
                    </div>
                </div>


                <!-- <div class="col-xs-12 col-sm-7 col-md-7 col-lg-7">
                    <label class="xCNLabelFrm" style="color : #FFF !important;">.</label>
                    <div class="input-group">
                        <input type="text" class="form-control xCNInputWithoutSingleQuote" id="oetSearchAll" name="oetSearchAll" onkeypress="Javascript:if(event.keyCode==13) JSvSettingConfigLoadTable()" autocomplete="off"  placeholder="<?=language('common/main/main','tPlaceholder'); ?>">
                        <span class="input-group-btn">
                            <button class="btn xCNBtnSearch" type="button" onclick="JSvSettingConfigLoadTable()">
                                <img class="xCNIconAddOn" src="<?//=base_url().'/application/modules/common/assets/images/icons/search-24.png'?>">
                            </button>
                        </span>
                    </div>
                </div> -->
            </div>
        </div>
    </div>
    <div class="col-xs-4 col-md-8 col-lg-8 text-right" style="margin-top:25px;">
        
    </div>

    <!-- CompanySetting -->
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div id="odvInforSettingConTab"></div>
    </div>

</div>

<script>
    //ใช้ selectpicker
    $('.selectpicker').selectpicker();
    $(document).ready(function(){
        JSxCompSettingConnect();
        $('#ocmlevType').on('change', function(){
            var tLevType = $(this).val();
            if(tLevType == 1){
                JSxCompSettingConnect();
            }else if(tLevType == 2){
                JSxBranchSetingConnection();
            }else{
                JSxCompSettingConnect();
            }
        });
        JCNxCloseLoading();
    });

    //Load 1 
    function JSxCompSettingConnect(){
        // Check Login Expried
        var nStaSession = JCNxFuncChkSessionExpired();
        //if have Session
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            $.ajax({
                type    : "POST",
                url     : "CompSettingCon",
                data    : {
                    tCompCode : '',
                },
                cache : false,
                timeout : 0,
                success : function (tResult){
                    $('#odvInforSettingConTab').html(tResult);
                    $('#odvlevType').show();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }else{
            JCNxShowMsgSessionExpired();
        }
    }

    //Load 2
    function JSxBranchSetingConnection(){
        // Check Login Expried
        var nStaSession = JCNxFuncChkSessionExpired();
        //if have Session 
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            $.ajax({
                type    : "POST",
                url     : 'BchSettingCon',
                data    : {
                    tBchCode    : '',
                },
                cache   : false,
                timeout : 0,
                success : function (tResult){
                    $('#odvInforSettingConTab').html(tResult);
                    $('#odvlevType').show();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }else{
            JCNxShowMsgSessionExpired();
        }
    }


</script>