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

<?php
    // /Date Current
    $dPosRegDate = date('Y-m-d', strtotime('+10 year'));
?>

<div id="odvPosRegister" class="panel panel-headline">
	<div class="panel-body" style="padding-top:20px !important;">
        <div class="row">
            <div class="col-xs-12 col-md-9 col-lg-9">
                <div class="form-group">
                    <div class="row">
                        <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                            <div class="form-group">
                                <label class="xCNLabelFrm"><?=language('common/main/main','tSearchNew')?></label>
                                <select class="selectpicker form-control xCNComboSelect" id="ocmStaApv" style="height:33px !important;">
                                    <option value="2"><?=language('pos/posreg/posreg','tOption2')?></option>
                                    <option value="0"><?=language('pos/posreg/posreg','tOptionALL')?></option>
                                    <option value="1"><?=language('pos/posreg/posreg','tOption1')?></option>
                                    <option value="3"><?=language('pos/posreg/posreg','tOption3')?></option>
                                </select>
                                <?php //foreach($aOption['raItems'] AS $key=>$aValue){ ?>
                                    <?php //$tTextOption = 'tOption'.$aValue['FTPrgStaApv']; ?>
                                    <!-- <option value="<?//=$aValue['FTPrgStaApv'];?>"><?//=language('pos/posreg/posreg',$tTextOption)?></option> -->
                                <?php //} ?>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-5 col-md-5 col-lg-5">
                            <label class="xCNLabelFrm" style="color : #FFF !important;">.</label>
                            <div class="input-group">
                                <input type="text" class="form-control xCNInputWithoutSingleQuote" id="oetSearchAll" name="oetSearchAll" onkeypress="Javascript:if(event.keyCode==13) JSvPosRegisterLoadTable()" autocomplete="off"  placeholder="<?=language('common/main/main','tPlaceholder'); ?>">
                                <span class="input-group-btn">
                                    <button class="btn xCNBtnSearch" type="button" onclick="JSvPosRegisterLoadTable()">
                                        <img class="xCNIconAddOn" src="<?=base_url().'/application/modules/common/assets/images/icons/search-24.png'?>">
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-md-3 col-lg-3">
                <div class="form-group">
                    <label class="xCNLabelFrm XCNLabelHide"><?=language('pos/posreg/posreg','tPRGDateExpire')?></label>
                    <div class="input-group XCNhideDatePic">
                        <input
                            type="text"
                            class="form-control xCNDatePicker xCNInputMaskDate text-center"
                            id="oetPosRegDate"
                            name="oetPosRegDate"
                            value="<?php echo date_format(date_create($dPosRegDate),"Y-m-d");?>"
                        >
                        <span class="input-group-btn">
                            <button id="obtPosRegDate" type="button" class="btn xCNBtnDateTime"><img class="xCNIconCalendar"></button>
                        </span>
                    </div>             
                </div>
            </div>
        </div>
        <div id="odvContentPosRegisterTable"></div>
	</div>
</div>
<?php include "script/jPosRegisterAdd.php";?>

<script>
    $('.xCNDatePicker').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true,
        startDate: new Date()
    });

    //ใช้ selectpicker
    $('.selectpicker').selectpicker();	

    //LoadTable
    JSvPosRegisterLoadTable();

    //ทุกครั้งที่เปลี่ยน Type
    $('#ocmStaApv').change(function() {
        JSvPosRegisterLoadTable();
    });


</script>