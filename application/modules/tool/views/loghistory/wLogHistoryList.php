<style>
    .dropdown-toggle {
        padding: 3px;
    }
</style>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="panel panel-headline">
            <div class="panel-heading">

                <?php 
                    $tUsrLevel = $this->session->userdata('tSesUsrLevel');
                    $tBchMulti = $this->session->userdata("tSesUsrBchCodeMulti");

                    if( $tUsrLevel != "HQ" ){
                        $tLGHAgnCode = $this->session->userdata('tSesUsrAgnCode');
                        $tLGHAgnName = $this->session->userdata('tSesUsrAgnName');

                        if( $this->session->userdata("nSesUsrBchCount") == 1 ){
                            $tLGHBchCode = $this->session->userdata('tSesUsrBchCodeDefault');
                            $tLGHBchName = $this->session->userdata('tSesUsrBchNameDefault');
                            $tDisabled = 'disabled';
                        }else{
                            $tLGHBchCode = "";
                            $tLGHBchName = "";
                            $tDisabled = '';
                        }

                        
                    }else{
                        $tLGHBchCode = "";
                        $tLGHBchName = "";
                        $tLGHAgnCode ='';
                        $tLGHAgnName ='';
                        $tDisabled = '';
                    }
                ?>
                <input type="hidden" id="ohdLGHAgnCode" value="<?=$tLGHAgnCode?>">
                <input type="hidden" id="ohdUsrLevel" value="<?=$tUsrLevel?>">
                <input type="hidden" id="ohdBchMulti" value="<?=$tBchMulti?>">
                <input type="hidden" id="ohdLGHPageCurrent" value="1">

                <form class="contact100-form validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" id="ofmLGHSearchData">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="row">

                                <!-- สาขา -->
                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                                    <div class="form-group">
                                        <label class="xCNLabelFrm"><?= language('tool/loghistory','tLGHFilterBch')?></label>
                                        <div class="input-group">
                                            <input type="text" class="form-control xCNHide xLGHInputBch" id="oetLGHBchCode" name="oetLGHBchCode" maxlength="5" value="<?=$tLGHBchCode?>">
                                            <input type="text" class="form-control xWPointerEventNone xLGHInputBch xCNInputNewUI" id="oetLGHBchName" name="oetLGHBchName" value="<?=$tLGHBchName?>" readonly placeholder="<?= language('tool/loghistory','tLGHFilterBch')?>">
                                            <span class="input-group-btn">
                                                <button id="obtLGHBrowseBch" type="button" class="btn xCNBtnBrowseAddOn" <?=$tDisabled?> >
                                                    <img src="<?php echo  base_url().'/application/modules/common/assets/images/icons/find-24.png'?>">
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <!-- สาขา -->

                                <!-- ประเภทจุดขาย -->
                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                                    <div class="form-group">
                                        <label class="xCNLabelFrm"><?php echo language('tool/loghistory', 'tLGHModalPosType'); ?></label>
                                        <select class="selectpicker form-control" id="ocmLGHPosType" name="ocmLGHPosType">
                                            <option value='' selected><?php echo language('common/main/main', 'tAll'); ?></option>
                                            <option value='1'><?php echo language('tool/loghistory', 'tLGHModalPosType1'); ?></option>
                                            <option value='4'><?php echo language('tool/loghistory', 'tLGHModalPosType4'); ?></option>
                                        </select>
                                    </div>
                                </div>
                                <!-- ประเภทจุดขาย -->

                                <!-- เครื่องจุดขาย -->
                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                                    <div class="form-group">
                                        <label class="xCNLabelFrm"><?= language('tool/loghistory','tLGHFilterPos')?></label>
                                        <div class="input-group">
                                            <input type="text" class="form-control xCNHide xWRptAllInput" id="oetLGHPosCode" name="oetLGHPosCode" maxlength="5" value="">
                                            <input type="text" class="form-control xWPointerEventNone xWRptAllInput xCNInputNewUI" value="" id="oetLGHPosName" name="oetLGHPosName" readonly placeholder="<?= language('tool/loghistory','tLGHFilterPos')?>">
                                            <span class="input-group-btn">
                                                <button id="obtLGHBrowsePos" type="button" class="btn xCNBtnBrowseAddOn">
                                                    <img src="<?php echo  base_url().'/application/modules/common/assets/images/icons/find-24.png'?>">
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <!-- เครื่องจุดขาย -->

                                <!-- สถานะ -->
                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                                    <div class="form-group">
                                        <label class="xCNLabelFrm"><?php echo language('tool/loghistory', 'tLGHFilterStatus'); ?></label>
                                        <select class="selectpicker form-control" id="ocmLGHStatus" name="ocmLGHStatus">
                                            <option value='' selected><?php echo language('common/main/main', 'tAll'); ?></option>
                                            <option value='1'><?php echo language('tool/loghistory', 'tLGHFilterStatus1'); ?></option>
                                            <option value='2'><?php echo language('tool/loghistory', 'tLGHFilterStatus2'); ?></option>
                                        </select>
                                    </div>
                                </div>
                                <!-- สถานะ -->

                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="row">

                                <!-- ประเภท -->
                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                                    <div class="form-group">
                                        <label class="xCNLabelFrm"><?php echo language('tool/loghistory', 'tLGHFilterType'); ?></label>
                                        <select class="selectpicker form-control" id="ocmLGHType" name="ocmLGHType">
                                            <option value='' selected><?php echo language('common/main/main', 'tAll'); ?></option>
                                            <option value='1'><?php echo language('tool/loghistory', 'tLGHFilterType1'); ?></option>
                                            <option value='2'><?php echo language('tool/loghistory', 'tLGHFilterType2'); ?></option>
                                        </select>
                                    </div>
                                </div>
                                <!-- ประเภท -->

                                <!-- จากวันที่เอกสาร -->
                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                                    <div class="form-group">
                                        <label class="xCNLabelFrm"><?php echo language('tool/loghistory','tLGHFilterDateFrm'); ?></label>
                                        <div class="input-group">
                                            <input
                                                class="form-control xCNDatePicker"
                                                type="text"
                                                id="oetLGHDocDateForm"
                                                name="oetLGHDocDateForm"
                                                placeholder="<?php echo language('tool/loghistory', 'tLGHFilterDateFrm'); ?>"
                                                autocomplete="off"
                                            >
                                            <span class="input-group-btn" >
                                                <button id="obtLGHDocDateForm" type="button" class="btn xCNBtnDateTime"><img class="xCNIconCalendar"></button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <!-- จากวันที่เอกสาร -->

                                <!-- ถึงวันที่เอกสาร -->
                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                                    <label class="xCNLabelFrm"><?php echo language('tool/loghistory', 'tLGHFilterDateTo'); ?></label>
                                    <div class="input-group">
                                        <input
                                            class="form-control xCNDatePicker"
                                            type="text"
                                            id="oetLGHDocDateTo"
                                            name="oetLGHDocDateTo"
                                            placeholder="<?php echo language('tool/loghistory', 'tLGHFilterDateTo'); ?>"
                                            autocomplete="off"
                                        >
                                        <span class="input-group-btn" >
                                            <button id="obtLGHDocDateTo" type="button" class="btn xCNBtnDateTime"><img class="xCNIconCalendar"></button>
                                        </span>
                                    </div>
                                </div>
                                <!-- ถึงวันที่เอกสาร -->

                                <!-- ปุ่มค้นหา / ล้างการค้นหา -->
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                    <div class="form-group">
                                        <label class="xCNLabelFrm"></label>
                                        <div class="text-center">
                                            <a id="oahLGHAdvanceSearch" class="btn xCNBTNPrimery  xCNBTNDefult1Btn" style="width:45%"><?= language('common/main/main','tSearch')?></a>
                                            &nbsp;
                                            <a id="oahLGHSearchReset" class="btn xCNBTNDefult xCNBTNDefult1Btn"  style="width:45%"><?= language('common/main/main','tClearSearch')?></a>
                                        </div>
                                    </div>
                                </div>
                                <!-- ปุ่มค้นหา / ล้างการค้นหา -->

                            </div>
                        </div>


                    </div>
                </form>

                <section id="ostLGHDataTableDocument" style="margin-bottom:15px;"></section>

            </div>
        </div>
    </div>
</div>

<script>

    $('document').ready(function(){
        $('.selectpicker').selectpicker();

        $('.xCNDatePicker').datepicker({
            format                  : "yyyy-mm-dd",
            todayHighlight          : true,
            enableOnReadonly        : false,
            disableTouchKeyboard    : true,
            autoclose               : true
        });
    });

    // Date From
    $('#obtLGHDocDateForm').off('click').on('click', function(){
        $('#oetLGHDocDateForm').datepicker('show');
    });

    // Date To
    $('#obtLGHDocDateTo').off('click').on('click', function(){
        $('#oetLGHDocDateTo').datepicker('show');
    });

    $('#oetLGHBchCode').off('change').on('change', function(){
        $('#oetLGHPosCode').val('');
        $('#oetLGHPosName').val('');
    });

    $('#ocmLGHPosType').off('change').on('change', function(){
        $(this).selectpicker('refresh');
        $('#oetLGHPosCode').val('');
        $('#oetLGHPosName').val('');
    });

    $('#oahLGHAdvanceSearch').off('click').on('click', function(){
        JSvLGHPageDataTable();
    });

    $('#oahLGHSearchReset').off('click').on('click', function(){
        
        var tSesUsrLevel    = '<?=$this->session->userdata('tSesUsrLevel')?>';
        var nSesUsrBchCount = '<?=$this->session->userdata('nSesUsrBchCount')?>';

        if( tSesUsrLevel != "HQ" && nSesUsrBchCount == 1 ){
            // ถ้าเป็น user ระดับสาขา และผูกสาขาเดียวไม่ต้องเคลียร์ input
            $('#ofmLGHSearchData input:not(.xLGHInputBch)').val('');

        }else{
            $('#ofmLGHSearchData input').val('');
        }

        
        $('#ofmLGHSearchData #ocmLGHType').val('');
        $('#ofmLGHSearchData #ocmLGHStatus').val('');
        $('.selectpicker').selectpicker('refresh');
        $('#ohdLGHPageCurrent').val('1');
        JSvLGHPageDataTable();
    });

    $('#obtLGHBrowseBch').unbind().click(function() {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
            JSxCheckPinMenuClose(); // Hidden Pin Menu
            oLGHBrowseBch = oLGHBrowseBchOption({
                'tReturnInputCode': 'oetLGHBchCode',
                'tReturnInputName': 'oetLGHBchName',
            });
            JCNxBrowseData('oLGHBrowseBch');
        } else {
            JCNxShowMsgSessionExpired();
        }
    });

    $('#obtLGHBrowsePos').unbind().click(function() {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
            JSxCheckPinMenuClose(); // Hidden Pin Menu
            oLGHBrowsePos = oLGHBrowsePosOption({
                'tReturnInputCode'  : 'oetLGHPosCode',
                'tReturnInputName'  : 'oetLGHPosName',
                'tParamBchCode'     : $('#oetLGHBchCode').val(),
                'tParamPosType'     : $('#ocmLGHPosType').val()
            });
            JCNxBrowseData('oLGHBrowsePos');
        } else {
            JCNxShowMsgSessionExpired();
        }
    });

</script>