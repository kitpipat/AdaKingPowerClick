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
                <div class="col-xs-12 col-sm-7 col-md-7 col-lg-7">
                    <label class="xCNLabelFrm"><?=language('common/main/main','tSearchNew')?></label>
                    <div class="input-group">
                        <input type="text" class="form-control xCNInputWithoutSingleQuote" id="oetSearchAllAutoNumber" name="oetSearchAllAutoNumber" onkeypress="Javascript:if(event.keyCode==13) JSvSettingAutoNumberLoadTable()" autocomplete="off"  placeholder="<?=language('common/main/main','tPlaceholder'); ?>">
                        <span class="input-group-btn">
                            <button class="btn xCNBtnSearch" type="button" onclick="JSvSettingAutoNumberLoadTable()">
                                <img class="xCNIconAddOn" src="<?=base_url().'/application/modules/common/assets/images/icons/search-24.png'?>">
                            </button>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="odvContentAutoNumber"></div>

<script>
    //ใช้ selectpicker
    $('.selectpicker').selectpicker();	

    //LoadTable
    JSvSettingAutoNumberLoadTable();

    //ทุกครั้งที่เปลี่ยน Type
    $('#ocmAppTypeAutoNumber').change(function() {
        JSvSettingAutoNumberLoadTable();
    });
</script>