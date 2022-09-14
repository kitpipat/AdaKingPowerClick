<style>
    #obtSearchDataTimeStamp{
        margin-top  : 28px;
        padding     : 5px;
        width       : 65px;
    }

</style>

<div class="panel panel-headline">
    <div class="panel-heading">

        <!--input layout search-->
        <div class="col-lg-2">
            <div class="form-group">
                <label class="xCNLabelFrm"><?php echo language('time/timeStamp/timeStamp','tMsgTimeStampBranch')?></label>
                <div class="input-group">
                    <input type="text" class="form-control xCNHide" id="oetTimeStampBranch" name="oetTimeStampBranch" value="" >
                    <input type="text" class="form-control xCNInputWithoutSpcNotThai" id="oetTimeStampBranchName" name="oetTimeStampBranchName" value="" required readonly>
                    <span class="input-group-btn">
                        <button id="obtBrowseBranch" type="button" class="btn xCNBtnBrowseAddOn">
                            <img src="<?= base_url().'/application/modules/common/assets/images/icons/find-24.png'?>">
                        </button>
                    </span>
                </div>
            </div>
        </div>

        <div class="col-lg-2">
            <div class="form-group">
                <label class="xCNLabelFrm"><?php echo language('time/timeStamp/timeStamp','tMsgTimeStampDateInput')?></label>
                <div class="input-group">
                    <input type="text" class="form-control xCNDatePicker xCNInputMaskDate" id="oetTimeStampStartDate" name="oetTimeStampStartDate" autocomplete="off" value="">
                    <span class="input-group-btn">
                        <button id="obtStartDate" type="button" class="btn xCNBtnDateTime">
                            <img src="<?php echo base_url().'/application/modules/common/assets/images/icons/icons8-Calendar-100.png'?>">
                        </button>
                    </span>
                </div>
            </div>
        </div>

        <div class="col-lg-2">
            <div class="form-group">
                <label class="xCNLabelFrm"><?php echo language('time/timeStamp/timeStamp','tMsgTimeStampDateOutput')?></label>
                <div class="input-group">
                    <input type="text" class="form-control xCNDatePicker xCNInputMaskDate" id="oetTimeStampEndDate" name="oetTimeStampEndDate" autocomplete="off" value="">
                    <span class="input-group-btn">
                        <button id="obtEndDate" type="button" class="btn xCNBtnDateTime">
                            <img src="<?php echo base_url().'/application/modules/common/assets/images/icons/icons8-Calendar-100.png'?>">
                        </button>
                    </span>
                </div>
            </div>
        </div>

        <div class="col-lg-2">
            <div class="form-group">
                <label class="xCNLabelFrm"><?php echo language('time/timeStamp/timeStamp','tMsgTimeStampTypeSearch')?></label>
                <select class="selectpicker form-control" id="ocmSelectTypeTimestamp" name="ocmSelectTypeTimestamp" maxlength="1">
                    <option value="0"><?= language('time/timeStamp/timeStamp', 'tMsgTimeStampSearchAll')?></option>
                    <option value="1"><?= language('time/timeStamp/timeStamp', 'tMsgTimeStampSearchTypeCheckin')?></option>
                    <option value="2"><?= language('time/timeStamp/timeStamp', 'tMsgTimeStampSearchTypeCheckout') ?></option>
                </select>
            </div>
        </div>
        
        <div class="col-lg-3">
            <div class="form-group">
                <label class="xCNLabelFrm"><?php echo language('time/timeStamp/timeStamp','tMsgTimeStampUsername')?></label>
                <input type="text" class="form-control xCNInputWithoutSpc" maxlength="50" id="oetTimeStampUsername" name="oetTimeStampUsername" value="">
            </div>
        </div>
        <div class="col-lg-1 col-sm-12">
            <div>
                <button type="button" class="btn" id="obtSearchDataTimeStamp">
                    <img class="xCNIconAddOn" src="<?php echo base_url().'/application/modules/common/assets/images/icons/search-24.png'?>" style="float: none;">
                </button>
            </div>
        </div>
        <!--end input layout search-->

    </div>
    <div class="panel-body">
        <section id="ostContentTimeStampDataTable"></section>
    </div>
</div>


<script>

    //Input Start
    $('#obtStartDate').click(function(event){
        $('#oetTimeStampStartDate').datepicker({
            format: "yyyy-mm-dd",
            todayHighlight: true,
            enableOnReadonly: false,
            startDate :'1900-01-01',
            disableTouchKeyboard : true,
            autoclose: true,
        });
        $('#oetTimeStampStartDate').datepicker('show');
        event.preventDefault();
    });

    //Input Start
    $('#obtStartDate').click(function(event){
        $('#oetTimeStampStartDate').datepicker('show');
        event.preventDefault();
    });

    //Input End
    $('#obtEndDate').click(function(event){
        $('#oetTimeStampEndDate').datepicker({
            format: "yyyy-mm-dd",
            todayHighlight: true,
            enableOnReadonly: false,
            startDate :'1900-01-01',
            disableTouchKeyboard : true,
            autoclose: true,
        });
        $('#oetTimeStampEndDate').datepicker('show');
        event.preventDefault();
    });

    //Input End
    $('#obtEndDate').click(function(event){
        $('#oetTimeStampEndDate').datepicker('show');
        event.preventDefault();
    });

    //Select2
    $('.selectpicker').selectpicker();

    //Option Branch
    var nLangEdits      = <?php echo $this->session->userdata("tLangEdit");?>;
    var oCmpBrowseBranch = {
        FormName : "Branch",
        AddNewRouteName : "branch",
        Title : ['authen/user/user','tBrowseBCHTitle'],
        Table:{Master:'TCNMBranch',PK:'FTBchCode'},
        Join :{
            Table:	['TCNMBranch_L'],
            On:['TCNMBranch_L.FTBchCode = TCNMBranch.FTBchCode AND TCNMBranch_L.FNLngID = '+nLangEdits,]
        },
        GrideView:{
            ColumnPathLang	: 'authen/user/user',
            ColumnKeyLang	: ['tBrowseBCHCode','tBrowseBCHName'],
            ColumnsSize     : ['10%','75%'],
            DataColumns		: ['TCNMBranch.FTBchCode','TCNMBranch_L.FTBchName'],
            DataColumnsFormat : ['',''],
            WidthModal      : 50,
            Perpage			: 10,
            OrderBy			: ['TCNMBranch.FTBchCode'],
            SourceOrder		: "ASC"
        },
        CallBack:{
            ReturnType	: 'S',
            Value		: ["oetTimeStampBranch","TCNMBranch.FTBchCode"],
            Text		: ["oetTimeStampBranchName","TCNMBranch_L.FTBchName"],
        },
        RouteAddNew : 'branch',
        BrowseLev : 0
    }

    //Browse Branch
    $('#obtBrowseBranch').click(function(){JCNxBrowseData('oCmpBrowseBranch');});

    //Get DataTable
    JSxCallDataTableDetailAll(); 

    //Search
    $('#obtSearchDataTimeStamp').click(function() {
        JSxCallDataTableDetailAll(1);
    });

</script>