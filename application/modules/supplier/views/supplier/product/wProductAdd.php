<?php
    // echo '<pre>';
    // print_r($aDataSplCt);
    // exit;
    
    $tLngID = $this->session->userdata("tLangEdit");
    if(isset($nStaAddOrEdit) && $nStaAddOrEdit == 1){

        $tPdtCode = $aDataSplPdt['raItems']['rtPdtCode'];
        $tBarCode = $aDataSplPdt['raItems']['rtBarCode'];
        $tSplCode = $aDataSplPdt['raItems']['rtSplCode'];
        $tSplLastPrice = $aDataSplPdt['raItems']['rtSplLastPrice'];
        $tSplLastDate = (!empty($aDataSplPdt['raItems']['rtSplLastDate']))? date("Y-m-d", strtotime($aDataSplPdt['raItems']['rtSplLastDate'])) : null;
        $tUsrCode = $aDataSplPdt['raItems']['rtUsrCode'];
        $tSplStaAlwPO = $aDataSplPdt['raItems']['rtSplStaAlwPO'];
        $tPdtAlwOrdStart = (!empty($aDataSplPdt['raItems']['rtPdtAlwOrdStart']))? date("Y-m-d", strtotime($aDataSplPdt['raItems']['rtPdtAlwOrdStart'])) : null;
        $tPdtAlwOrdStop = (!empty($aDataSplPdt['raItems']['rtPdtAlwOrdStop']))? date("Y-m-d", strtotime($aDataSplPdt['raItems']['rtPdtAlwOrdStop'])) : null;
        $tPdtOrdDay = $aDataSplPdt['raItems']['rtPdtOrdDay'];
        $tPdtStaAlwOrdSun = $aDataSplPdt['raItems']['rtPdtStaAlwOrdSun'] != '1' ? 0 : $aDataSplPdt['raItems']['rtPdtStaAlwOrdSun'];
        $tPdtStaAlwOrdMon = $aDataSplPdt['raItems']['rtPdtStaAlwOrdMon'] != '1' ? 0 : $aDataSplPdt['raItems']['rtPdtStaAlwOrdMon'];
        $tPdtStaAlwOrdTue = $aDataSplPdt['raItems']['rtPdtStaAlwOrdTue'] != '1' ? 0 : $aDataSplPdt['raItems']['rtPdtStaAlwOrdTue'];
        $tPdtStaAlwOrdWed = $aDataSplPdt['raItems']['rtPdtStaAlwOrdWed'] != '1' ? 0 : $aDataSplPdt['raItems']['rtPdtStaAlwOrdWed'];
        $tPdtStaAlwOrdThu = $aDataSplPdt['raItems']['rtPdtStaAlwOrdThu'] != '1' ? 0 : $aDataSplPdt['raItems']['rtPdtStaAlwOrdThu'];
        $tPdtStaAlwOrdFri = $aDataSplPdt['raItems']['rtPdtStaAlwOrdFri'] != '1' ? 0 : $aDataSplPdt['raItems']['rtPdtStaAlwOrdFri'];
        $tPdtStaAlwOrdSat = $aDataSplPdt['raItems']['rtPdtStaAlwOrdSat'] != '1' ? 0 : $aDataSplPdt['raItems']['rtPdtStaAlwOrdSat'];
        $tPdtLeadTime = $aDataSplPdt['raItems']['rtPdtLeadTime'];
        $tPdtName = $aDataSplPdt['raItems']['rtPdtName'];
        $tUsrName = $aDataSplPdt['raItems']['rtUsrName'];


        $tRoute = 'SplProductEventEdit';
    }else{

        $tPdtCode = '';//
        $tBarCode = '';//
        $tSplCode = '';//
        $tSplLastPrice = '';//
        $tSplLastDate = '';//
        $tUsrCode = '';//
        $tSplStaAlwPO = '';
        $tPdtAlwOrdStart = '';//
        $tPdtAlwOrdStop = '';//
        $tPdtOrdDay = '';//
        $tPdtStaAlwOrdSun = 0;//
        $tPdtStaAlwOrdMon = 0;//
        $tPdtStaAlwOrdTue = 0;//
        $tPdtStaAlwOrdWed = 0;//
        $tPdtStaAlwOrdThu = 0;//
        $tPdtStaAlwOrdFri = 0;//
        $tPdtStaAlwOrdSat = 0;//
        $tPdtLeadTime = '';//
        $tPdtName = $aDataSplPdt['raItems']['rtPdtName'];//
        $tUsrName = $aDataSplPdt['raItems']['rtUsrName'];//

        $tRoute = 'SplProductEventAdd';
        
    }

?>
<style>
    
</style>
<form class="contact100-form validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" id="ofmSplPdt">
    <input type="text" class="xCNHide" id="oetSplCodePdt" name="oetSplCodePdt" value="<?php echo $tSplCode; ?>">
    <input type="text" class="xCNHide" id="oetLngIDPdt" name="oetLngIDPdt" value="<?php echo $tLngID; ?>">
    <input type="text" class="xCNHide" id="oetPdtCode" name="oetPdtCode" value="<?php echo $tPdtCode; ?>">
    <input type="text" class="xCNHide" id="oetBarCode" name="oetBarCode" value="<?php echo $tBarCode; ?>">
    <div class="col-lg-12">
        <div class="row">
            <div id="" class="col-xl-12 col-lg-12">   
                <button class="btn xCNBTNPrimery xCNBTNPrimery1Btn pull-right" id="obtSubSave" type="submit" onclick="JSoEditSplProduct('<?php echo $tRoute;?>')"><?php echo language('common/main/main', 'tSave') ?></button>
                <button class="btn xCNBTNPrimery xCNBTNPrimery1Btn pull-right" id="obtSubCancel" type="button" onclick="JSvCallPageSplProductList()"><?php echo language('common/main/main', 'tCancel') ?></button>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-4 col-xs-12">
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('pos5/supplier','tEditPdt')?>&#09; <?php echo $tPdtCode.' - '.$tPdtName;?></label><br>
                            <label class="xCNLabelFrm"><?php echo language('pos5/supplier','tBarCode')?>&#09; <?php echo $tBarCode;?></label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 col-xs-12">
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?=language('pos5/supplier','tSplLastPrice')?></label>
                            <input class="form-control xCNInputMaskCurrency xCNInputNumericWithDecimal" value="<?php echo $tSplLastPrice;?>" maxlength="15" placeholder="0.00" type="text" id="oetSplLastPrice" name="oetSplLastPrice" data-validate="<?=language('pos5/supplier','tSplLastPrice')?>">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 col-xs-12">
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('pos5/supplier','tSplLastDate')?></label>
                            <div class="input-group">
                                <input type="text" class="form-control xCNDatePicker xCNInputMaskDate" id="oetSplLastDate" name="oetSplLastDate" autocomplete="off" value="<?php echo $tSplLastDate;?>" data-validate="<?php echo  language('pos5/supplier','tSplLastDate');?>">
                                <span class="input-group-btn">
                                    <button id="obtSplLastDate" type="button" class="btn xCNBtnDateTime">
                                        <img src="<?= base_url().'/application/assets/icons/icons8-Calendar-100.png'?>">
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 col-xs-12">
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('pos5/supplier','tPdtAlwOrdStart')?></label>
                            <div class="input-group">
                                <input type="text" class="form-control xCNDatePicker xCNInputMaskDate" id="oetPdtAlwOrdStart" name="oetPdtAlwOrdStart" autocomplete="off" value="<?php echo $tPdtAlwOrdStart;?>" data-validate="<?php echo  language('pos5/supplier','tPdtAlwOrdStart');?>">
                                <span class="input-group-btn">
                                    <button id="obtPdtAlwOrdStart" type="button" class="btn xCNBtnDateTime">
                                        <img src="<?= base_url().'/application/assets/icons/icons8-Calendar-100.png'?>">
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 col-xs-12">
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('pos5/supplier','tPdtAlwOrdStop')?></label>
                            <div class="input-group">
                                <input type="text" class="form-control xCNDatePicker xCNInputMaskDate" id="oetPdtAlwOrdStop" name="oetPdtAlwOrdStop" autocomplete="off" value="<?php echo $tPdtAlwOrdStop;?>" data-validate="<?php echo  language('pos5/supplier','tPdtAlwOrdStop');?>">
                                <span class="input-group-btn">
                                    <button id="obtPdtAlwOrdStop" type="button" class="btn xCNBtnDateTime">
                                        <img src="<?= base_url().'/application/assets/icons/icons8-Calendar-100.png'?>">
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 col-xs-12">
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('pos5/supplier','tPdtLeadTime')?></label>
                            <input type="number" class="form-control xCNInputMaskCurrency xCNInputNumericWithDecimal" value="<?php echo $tPdtLeadTime; ?>" id="oenPdtLeadTime" name="oenPdtLeadTime" maxlength="5" data-validate="<?=language('pos5/supplier','tPdtLeadTime')?>">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 col-xs-12">
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('pos5/supplier','tUsrName')?></label>
                            <div class="input-group">
                                <input type="text" class="form-control xCNHide" id="oetPdtUsrCode" name="oetPdtUsrCode" value="<?php echo $tUsrCode?>">
                                <input type="text" class="form-control" id="oetPdtUsrName" name="oetPdtUsrName" value="<?php echo $tUsrName?>" data-validate="<?php echo language('pos5/supplier','tUsrName')?>">
                                <span class="input-group-btn">
                                    <button id="obtUsrCode" type="button" class="btn xCNBtnBrowseAddOn">
                                        <img src="<?= base_url().'/application/assets/icons/find-24.png'?>">
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 col-xs-12">
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('pos5/supplier','tPdtOrdDay')?></label>
                            <input type="text" class="form-control" id="oetPdtOrdDay" name="oetPdtOrdDay" autocomplete="off" value="<?php echo $tPdtOrdDay;?>" data-validate="<?php echo  language('pos5/supplier','tPdtOrdDay');?>">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <label class="fancy-checkbox">
                            <input class="" <?php echo $tSplStaAlwPO == '1' ? 'checked' : ''; ?> type="checkbox" id="ocbSplStaAlwPO" name="ocbSplStaAlwPO">
                            <span><?php echo language('pos5/supplier','tSplStaAlwPO')?></span>
                        </label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('pos5/supplier','tBuyAllow')?></label>
                            <?php
                                $nChkAllPdt = $tPdtStaAlwOrdSun+$tPdtStaAlwOrdMon+$tPdtStaAlwOrdTue+$tPdtStaAlwOrdWed+$tPdtStaAlwOrdThu+$tPdtStaAlwOrdFri+$tPdtStaAlwOrdSat;
                                if($nChkAllPdt >= 7){
                                    $tChkAllPdt = 'checked';
                                }else{
                                    $tChkAllPdt = '';
                                }
                                
                            ?>
                            <div class="row">
                                <div class="col-md-2">
                                    <label class="fancy-checkbox">
                                        <input class="xWChkPdtChkAll" onclick="JSxChkAllDayPdt()" <?php echo $tPdtStaAlwOrdMon == '1' ? 'checked' : ''; ?> type="checkbox" id="ocbPdtStaAlwOrdMon" name="ocbPdtStaAlwOrdMon">
                                        <span><?php echo language('pos5/supplier','tMonday')?></span>
                                    </label>
                                </div>
                                <div class="col-md-2">
                                    <label class="fancy-checkbox">
                                        <input class="xWChkPdtChkAll" onclick="JSxChkAllDayPdt()" <?php echo $tPdtStaAlwOrdTue == '1' ? 'checked' : ''; ?> type="checkbox" id="ocbPdtStaAlwOrdTue" name="ocbPdtStaAlwOrdTue">
                                        <span><?php echo language('pos5/supplier','tTuesday')?></span>
                                    </label>
                                </div>
                            </div>
                            <div class="row"> 
                                <div class="col-md-2">
                                    <label class="fancy-checkbox">
                                        <input class="xWChkPdtChkAll" onclick="JSxChkAllDayPdt()" <?php echo $tPdtStaAlwOrdWed == '1' ? 'checked' : ''; ?> type="checkbox" id="ocbPdtStaAlwOrdWed" name="ocbPdtStaAlwOrdWed">
                                        <span><?php echo language('pos5/supplier','tWednesday')?></span>
                                    </label>
                                </div>
                                <div class="col-md-2">
                                    <label class="fancy-checkbox">
                                        <input class="xWChkPdtChkAll" onclick="JSxChkAllDayPdt()" <?php echo $tPdtStaAlwOrdThu == '1' ? 'checked' : ''; ?> type="checkbox" id="ocbPdtStaAlwOrdThu" name="ocbPdtStaAlwOrdThu">
                                        <span><?php echo language('pos5/supplier','tThursday')?></span>
                                    </label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <label class="fancy-checkbox">
                                        <input class="xWChkPdtChkAll" onclick="JSxChkAllDayPdt()" <?php echo $tPdtStaAlwOrdFri == '1' ? 'checked' : ''; ?> type="checkbox" id="ocbPdtStaAlwOrdFri" name="ocbPdtStaAlwOrdFri">
                                        <span><?php echo language('pos5/supplier','tFriday')?></span>
                                    </label>
                                </div>
                                <div class="col-md-2">
                                    <label class="fancy-checkbox">
                                        <input class="xWChkPdtChkAll" onclick="JSxChkAllDayPdt()" <?php echo $tPdtStaAlwOrdSat == '1' ? 'checked' : ''; ?> type="checkbox" id="ocbPdtStaAlwOrdSat" name="ocbPdtStaAlwOrdSat">
                                        <span><?php echo language('pos5/supplier','tSaturday')?></span>
                                    </label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <label class="fancy-checkbox">
                                        <input class="xWChkPdtChkAll" onclick="JSxChkAllDayPdt()" <?php echo $tPdtStaAlwOrdSun == '1' ? 'checked' : ''; ?> type="checkbox" id="ocbPdtStaAlwOrdSun" name="ocbPdtStaAlwOrdSun">
                                        <span><?php echo language('pos5/supplier','tSunday')?></span>
                                    </label>
                                </div>
                                <div class="col-md-2">
                                    <label class="fancy-checkbox" >
                                        <input class="xWStaDayPdt" onclick="JSxAllDayPdt()" <?php echo $tChkAllPdt;?> type="checkbox" id="ocbPdtStaAlwOrdAll" name="ocbPdtStaAlwOrdAll">
                                        <span><?php echo language('pos5/supplier','tAllDay')?></span>
                                    </label>
                                </div>    
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</form>
            
    
<script src="<?php echo base_url('application/assets/js/global/jquery.mask.js')?>"></script>
<script src="<?php echo base_url('application/assets/src/jFormValidate.js')?>"></script>

<script type="text/javascript">
    var nLangEdits = <?php echo $this->session->userdata("tLangEdit");?>;
    
    $('#oetPdtOrdDay').click(function(e){
        JCNtCalendarDate($(this));});

    $(document).ready(function(){
        if(nStaAddOrEdit === 99){//add
            // $('#ocbSplStaLocateUse').prop("checked", true);
            // $('.xWDisTab').attr('disabled');
            // $('.xWDisTab').addClass('disabled');
        }
        $('.xCNSelectBox').selectpicker();

        $('.xCNDatePicker').datepicker({
            format: "yyyy-mm-dd",
            todayHighlight: true,
            enableOnReadonly: false,
            startDate :'1900-01-01',
            disableTouchKeyboard : true,
            autoclose: true,
        });
        $('#obtPdtAlwOrdStop').click(function(event){
            $('#oetPdtAlwOrdStop').datepicker('show');
            event.preventDefault();
        });
        $('#obtPdtAlwOrdStart').click(function(event){
            $('#oetPdtAlwOrdStart').datepicker('show');
            event.preventDefault();
        });
        $('#obtSplLastDate').click(function(event){
            $('#oetSplLastDate').datepicker('show');
            event.preventDefault();
        });
        
        
        

    });

    //Option UsrCode
    var oSplPdtUsrCode = {
        Title : ['pos5/user','tUSRTitle'],
        Table:{Master:'TCNMUser',PK:'FTUsrCode'},
        Join :{
            Table:	['TCNMUser_L'],
            On:['TCNMUser_L.FTUsrCode = TCNMUser.FTUsrCode AND TCNMUser_L.FNLngID = '+nLangEdits,]
        },
        GrideView:{
            ColumnPathLang	: 'pos5/user',
            ColumnKeyLang	: ['tUSRCode','tUSRTBName'],
            ColumnsSize     : ['15%','75%'],
            WidthModal      : 50,
            DataColumns		: ['TCNMUser.FTUsrCode','TCNMUser_L.FTUsrName'],
            DataColumnsFormat : ['',''],
            Perpage			: 5,
            OrderBy			: ['TCNMUser.FTUsrCode'],
            SourceOrder		: "ASC"
        },
        CallBack:{
            ReturnType	: 'S',
            Value		: ["oetPdtUsrCode","TCNMUser.FTUsrCode"],
            Text		: ["oetPdtUsrName","TCNMUser_L.FTUsrName"],
        },
        // NextFunc:{
        //     FuncName:'JSxNextFuncPlotMapSplAd',
        //     ArgReturn:['FTSudLatitude','FTSudLongitude']
        // },
        RouteAddNew : 'user',
        BrowseLev : nStaSplBrowseType
    }
    $('#obtUsrCode').click(function(){JCNxBrowseData('oSplPdtUsrCode')});

</script>
