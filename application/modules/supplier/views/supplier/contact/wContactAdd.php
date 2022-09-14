<?php
    // echo '<pre>';
    // print_r($aDataSplCt);
    // exit;
    if(isset($nStaAddOrEdit) && $nStaAddOrEdit == 1){

        $tCtrSeq = $aDataSplCt['raItems']['rtCtrSeq'];
        $tCtrName = $aDataSplCt['raItems']['rtCtrName'];
        $tCtrFax = $aDataSplCt['raItems']['rtCtrFax'];
        $tCtrTel = $aDataSplCt['raItems']['rtCtrTel'];
        $tCtrEmail = $aDataSplCt['raItems']['rtCtrEmail'];
        $tCtrRmk = $aDataSplCt['raItems']['rtCtrRmk'];

        $tLngID = $aDataSplCt['raItems']['rtLngID'];
        $tAddSeqNo = $aDataSplCt['raItems']['rtAddSeqNo'];
        $tAddGrpType = $aDataSplCt['raItems']['rtAddGrpType'];
        $tAddName = $aDataSplCt['raItems']['rtAddName'];
        $tAddTaxNo = $aDataSplCt['raItems']['rtAddTaxNo'];
        $tAddCountry = $aDataSplCt['raItems']['rtAddCountry'];
        $tAreCode = $aDataSplCt['raItems']['rtAreCode'];
        $tZneCode = $aDataSplCt['raItems']['rtZneCode'];
        $tAddV1No = $aDataSplCt['raItems']['rtAddV1No'];
        $tAddV1Soi = $aDataSplCt['raItems']['rtAddV1Soi'];
        $tAddV1Village = $aDataSplCt['raItems']['rtAddV1Village'];
        $tAddV1Road = $aDataSplCt['raItems']['rtAddV1Road'];
        $tAddV1SubDist = $aDataSplCt['raItems']['rtAddV1SubDist'];
        $tAddV1DstCode = $aDataSplCt['raItems']['rtAddV1DstCode'];
        $tAddV1PvnCode = $aDataSplCt['raItems']['rtAddV1PvnCode'];
        $tAddV1PostCode = $aDataSplCt['raItems']['rtAddV1PostCode'];

        $tAddV2Desc1 = $aDataSplCt['raItems']['rtAddV2Desc1'];
        $tAddV2Desc2 = $aDataSplCt['raItems']['rtAddV2Desc2'];

        $tAddWebsite = $aDataSplCt['raItems']['rtAddWebsite'];

        $tAddLongitude = $aDataSplCt['raItems']['rtAddLongitude'];
        $tAddLatitude = $aDataSplCt['raItems']['rtAddLatitude'];

        $tAreName = $aDataSplCt['raItems']['rtAreName'];
        $tZneChainName = $aDataSplCt['raItems']['rtZneChainName'];
        $tPvnName = $aDataSplCt['raItems']['rtPvnName'];
        $tDstName = $aDataSplCt['raItems']['rtDstName'];
        $tSudName = $aDataSplCt['raItems']['rtSudName'];

        $tRoute = 'SplContactEventEdit';
    }else{

        $tCtrSeq = '';
        $tCtrName = '';
        $tCtrFax = '';
        $tCtrTel = '';
        $tCtrEmail = '';
        $tCtrRmk = '';

        $tAddSeqNo = '';//
        $tLngID = '';//
        $tAddGrpType = '';//
        $tAddName = '';//
        $tAddTaxNo = '';//
        
        
        $tAddCountry = '';//
        $tAreCode = '';//
        $tZneCode = '';//
        
        $tAddV1No = '';//
        $tAddV1Soi = '';//
        $tAddV1Village = '';//
        $tAddV1Road = '';//
        $tAddV1PostCode = '';//

        $tAddV1SubDist = '';//
        $tAddV1DstCode = '';//
        $tAddV1PvnCode = '';//
        

        $tAddV2Desc1 = '';//
        $tAddV2Desc2 = '';//

        $tAddWebsite = '';//

        $tAddLongitude = '';
        $tAddLatitude = '';

        $tAreName = '';//
        $tZneChainName = '';//
        $tPvnName = '';//
        $tDstName = '';//
        $tSudName = '';//

        $tRoute = 'SplContactEventAdd';
        
    }

?>
<style>
    
</style>
<form class="contact100-form validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" id="ofmSplCt">
    <input type="text" class="xCNHide" id="oetSplCodeCt" name="oetSplCodeCt" value="<?php echo $tSplCode; ?>">
    <input type="text" class="xCNHide" id="oetLngIDCt" name="oetLngIDCt" value="<?php echo $tLngID; ?>">
    <input type="text" class="xCNHide" id="oetAddSeqNo" name="oetAddSeqNo" value="<?php echo $tAddSeqNo; ?>">
    <input type="text" class="xCNHide" id="oetCtrSeq" name="oetCtrSeq" value="<?php echo $tCtrSeq; ?>">
    <input type="text" class="xCNHide" id="oetAddGrpTypeOld" name="oetAddGrpTypeOld" value="<?php echo $tAddGrpType; ?>">
    <div class="col-lg-12">
        <div class="row">
            <div id="" class="col-xl-12 col-lg-12">
                <button class="btn xCNBTNPrimery xCNBTNPrimery1Btn pull-right" id="obtSubSave" type="submit" onclick="JSoAddEditSplContact('<?php echo $tRoute;?>')">บันทึก</button>
                <button class="btn xCNBTNPrimery xCNBTNPrimery1Btn pull-right" id="obtSubCancel" type="button" onclick="JSvCallPageSplContactList()">ยกเลิก</button>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-10">
                <div class="row">
                    <div class="col-lg-6 col-xs-12">
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('pos5/supplier','tCtrName')?></label>
                            <input type="text" class="form-control xCNInputWithoutSpc" maxlength="150" id="oetCtrName" name="oetCtrName" value="<?php echo $tCtrName; ?>"  data-validate="<?php echo  language('pos5/supplier','tCtrName');?>">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-xs-12">
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('pos5/supplier','tCtrTel')?></label>
                            <input type="text" class="form-control xCNInputNumericWithoutDecimal" maxlength="20" id="oetCtrTel" name="oetCtrTel" value="<?php echo $tCtrTel; ?>"  data-validate="<?php echo  language('pos5/supplier','tCtrTel');?>">
                        </div>
                    </div>
                    <div class="col-lg-6 col-xs-12">
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('pos5/supplier','tCtrFax')?></label>
                            <input type="text" class="form-control xCNInputNumericWithoutDecimal" maxlength="50" id="oetCtrFax" name="oetCtrFax" value="<?php echo $tCtrFax; ?>"  data-validate="<?php echo  language('pos5/supplier','tCtrFax');?>">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-xs-12">
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('pos5/supplier','tCtrEmail')?></label>
                            <input type="email" class="form-control xCNInputWithoutSpcNotThai" maxlength="50" id="oetCtrEmail" name="oetCtrEmail" value="<?php echo $tCtrEmail; ?>"  data-validate="<?php echo  language('pos5/supplier','tCtrEmail');?>">
                        </div>
                    </div>
                    <div class="col-lg-6 col-xs-12">
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('pos5/supplier','tCtrRmk')?></label>
                            <input type="text" class="form-control xCNInputWithoutSpc" maxlength="100" id="oetCtrRmk" name="oetCtrRmk" value="<?php echo $tCtrRmk; ?>"  data-validate="<?php echo  language('pos5/supplier','tCtrRmk');?>">
                        </div>
                    </div>
                </div>








                <div class="row">
                    <div class="col-lg-6 col-xs-12">
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('pos5/supplier','tAddreesName')?></label>
                            <input type="text" class="form-control xCNInputWithoutSpc" maxlength="150" id="oetAddName" name="oetAddName" value="<?php echo $tAddName; ?>"  data-validate="<?php echo  language('pos5/supplier','tAddreesName');?>">
                        </div>
                    </div>
                    <div class="col-lg-6 col-xs-12">
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('pos5/supplier','tAddCountry')?></label>
                            <input type="text" class="form-control xCNInputWithoutSpc" maxlength="80" id="oetAddCountry" name="oetAddCountry" value="<?php echo $tAddCountry; ?>"  data-validate="<?php echo  language('pos5/supplier','tAddCountry');?>">
                        </div>
                    </div>
                </div>
                
                <?php
                    $tFormat = FCNaHAddressFormat('TCNMSpl');//1 ที่อยู่ แบบแยก  ,2  แบบรวม
                    // $tFormat = '2';
                    if($tFormat == '1'):
                ?>
                <div class="row">
                    <div class="col-lg-4 col-md-6 col-xs-12">
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('pos5/supplier','tAreCode')?></label>
                            <div class="input-group">
                                <input type="text" class="form-control xCNHide" onchange="JSxResetVal('oetAreCode','<?php echo $tAreCode?>',1)" id="oetAreCode" name="oetAreCode" value="<?php echo $tAreCode;?>">
                                <input type="text" class="form-control" id="oetAreName" name="oetAreName" value="<?php echo $tAreName;?>" data-validate="<?php echo language('pos5/supplier','tAreCode')?>" readonly="">
                                <span class="input-group-btn">
                                    <button id="obtAreCode" type="button" class="btn xCNBtnBrowseAddOn">
                                        <img src="<?= base_url().'/application/assets/icons/find-24.png'?>">
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-xs-12">
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('pos5/supplier','tZneCode')?></label>
                            <div class="input-group">
                                <input type="text" class="form-control xCNHide" onchange="JSxResetVal('oetZneCode','<?php echo $tZneCode?>',2)" id="oetZneCode" name="oetZneCode" value="<?php echo $tZneCode;?>">
                                <input type="text" class="form-control" id="oetZneChainName" name="oetZneChainName" value="<?php echo $tZneChainName;?>" data-validate="<?php echo language('pos5/supplier','tZneCode')?>" readonly="">
                                <span class="input-group-btn">
                                    <button id="obtZneCode" disabled type="button" class="btn xCNBtnBrowseAddOn">
                                        <img src="<?= base_url().'/application/assets/icons/find-24.png'?>">
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-xs-12">
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('pos5/supplier','tAddV1PvnCode')?></label>
                            <div class="input-group">
                                <input type="text" class="form-control xCNHide" onchange="JSxResetVal('oetAddV1PvnCode','<?php echo $tAddV1PvnCode?>',3)" id="oetAddV1PvnCode" name="oetAddV1PvnCode" value="<?php echo $tAddV1PvnCode;?>">
                                <input type="text" class="form-control" id="oetPvnName" name="oetPvnName" value="<?php echo $tPvnName;?>" data-validate="<?php echo language('pos5/supplier','tAddV1PvnCode')?>" readonly="">
                                <span class="input-group-btn">
                                    <button id="obtAddV1PvnCode" disabled type="button" class="btn xCNBtnBrowseAddOn">
                                        <img src="<?= base_url().'/application/assets/icons/find-24.png'?>">
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-4 col-md-6 col-xs-12">
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('pos5/supplier','tAddV1DstCode')?></label>
                            <div class="input-group">
                                <input type="text" class="form-control xCNHide" onchange="JSxResetVal('oetAddV1DstCode','<?php echo $tAddV1DstCode?>',4)" id="oetAddV1DstCode" name="oetAddV1DstCode" value="<?php echo $tAddV1DstCode;?>">
                                <input type="text" class="form-control" id="oetDstName" name="oetDstName" value="<?php echo $tDstName;?>" data-validate="<?php echo language('pos5/supplier','tAddV1DstCode')?>" readonly="">
                                <span class="input-group-btn">
                                    <button id="obtAddV1DstCode" disabled type="button" class="btn xCNBtnBrowseAddOn">
                                        <img src="<?= base_url().'/application/assets/icons/find-24.png'?>">
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-xs-12">
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('pos5/supplier','tAddV1SubDist')?></label>
                            <div class="input-group">
                                <input type="text" class="form-control xCNHide" id="oetAddV1SubDist" name="oetAddV1SubDist" value="<?php echo $tAddV1SubDist;?>">
                                <input type="text" class="form-control" id="oetSudName" name="oetSudName" value="<?php echo $tSudName;?>" data-validate="<?php echo language('pos5/supplier','tAddV1SubDist')?>" readonly="">
                                <span class="input-group-btn">
                                    <button id="obtAddV1SubDist" disabled type="button" class="btn xCNBtnBrowseAddOn">
                                        <img src="<?= base_url().'/application/assets/icons/find-24.png'?>">
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 col-md-6 col-xs-12">
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('pos5/supplier','tAddV1Road')?></label>
                            <input type="text" class="form-control xCNInputWithoutSpc" maxlength="30" id="oetAddV1Road" name="oetAddV1Road" value="<?php echo $tAddV1Road; ?>"  data-validate="<?php echo  language('pos5/supplier','tAddV1Road');?>">
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-xs-12">
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('pos5/supplier','tAddV1Village')?></label>
                            <input type="text" class="form-control xCNInputWithoutSpc" maxlength="70" id="oetAddV1Village" name="oetAddV1Village" value="<?php echo $tAddV1Village; ?>"  data-validate="<?php echo  language('pos5/supplier','tAddV1Village');?>">
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-xs-12">
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('pos5/supplier','tAddV1No')?></label>
                            <input type="text" class="form-control xCNInputWithoutSpc" maxlength="30" id="oetAddV1No" name="oetAddV1No" value="<?php echo $tAddV1No; ?>"  data-validate="<?php echo  language('pos5/supplier','tAddV1No');?>">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 col-md-6 col-xs-12">
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('pos5/supplier','tAddV1Soi')?></label>
                            <input type="text" class="form-control xCNInputWithoutSpc" maxlength="30" id="oetAddV1Soi" name="oetAddV1Soi" value="<?php echo $tAddV1Soi; ?>"  data-validate="<?php echo  language('pos5/supplier','tAddV1Soi');?>">
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-xs-12">
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('pos5/supplier','tAddV1PostCode')?></label>
                            <input type="text" class="form-control xCNInputNumericWithoutDecimal" maxlength="5" id="oetAddV1PostCode" name="oetAddV1PostCode" value="<?php echo $tAddV1PostCode; ?>"  data-validate="<?php echo  language('pos5/supplier','tAddV1PostCode');?>">
                        </div>
                    </div>
                </div>

                <?php else:?>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('pos5/supplier','tAddV2Desc1')?></label>
                            <textarea rows="3" class="form-control xCNInputWithoutSpc" maxlength="250" id="oetAddV2Desc1" name="oetAddV2Desc1"  data-validate="<?php echo language('pos5/supplier','tAddV2Desc1');?>"><?php echo $tAddV2Desc1;?></textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('pos5/supplier','tAddV2Desc2')?></label>
                            <textarea rows="3" class="form-control xCNInputWithoutSpc" maxlength="250" id="oetAddV2Desc2" name="oetAddV2Desc2" data-validate="<?php echo  language('pos5/supplier','tAddV2Desc2');?>"><?php echo $tAddV2Desc2;?></textarea>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <div class="row">
                    <div class="col-lg-6 col-md-12">
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('pos5/supplier','tAddTaxNo')?></label>
                            <input type="text" class="form-control xCNInputNumericWithoutDecimal" maxlength="20" id="oetAddTaxNo" name="oetAddTaxNo" value="<?php echo $tAddTaxNo; ?>"  data-validate="<?php echo  language('pos5/supplier','tAddTaxNo');?>">
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('pos5/supplier','tAddWebsite')?></label>
                            <input type="text" class="form-control xCNInputWithoutSpc" maxlength="20" id="oetAddWebsite" name="oetAddWebsite" value="<?php echo $tAddWebsite; ?>"  data-validate="<?php echo  language('pos5/supplier','tAddWebsite');?>">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                        <div class="col-xs-12 col-md-12 col-lg-12">
                            <input type="text" class="form-control xCNHide" id="oetSplAdMapLong" name="oetSplAdMapLong" value="<?php echo $tAddLongitude?>">
                            <input type="text" class="form-control xCNHide" id="oetSplAdMapLat" name="oetSplAdMapLat" value="<?php echo $tAddLatitude?>">
                            <div id="odvSplAdMapEdit" class="xCNMapShow">
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

    var nLangEdits      = <?php echo $this->session->userdata("tLangEdit");?>;
    // var nStaAddOrEdit   = <?php echo $nStaAddOrEdit;?>;
    $(document).ready(function(){
        if(nStaAddOrEdit === 99){//add
            // $('#ocbSplStaLocateUse').prop("checked", true);
            // $('.xWDisTab').attr('disabled');
            // $('.xWDisTab').addClass('disabled');
        }
        tAreCode  = $('#oetAreCode').val();
        tZneCode  = $('#oetZneCode').val();
        tPvnCode  = $('#oetAddV1PvnCode').val();
        tDstCode  = $('#oetAddV1DstCode').val();
        if(tAreCode == '' || tAreCode == null){
            $('#obtZneCode').prop('disabled',true);
        }else{
            $('#obtZneCode').prop('disabled',false);
        }
        if(tZneCode == '' || tZneCode == null){
            $('#obtAddV1PvnCode').prop('disabled',true);
        }else{
            $('#obtAddV1PvnCode').prop('disabled',false);
        }
        if(tPvnCode == '' || tPvnCode == null){
            $('#obtAddV1DstCode').prop('disabled',true);
        }else{
            $('#obtAddV1DstCode').prop('disabled',false);
        }
        if(tDstCode == '' || tDstCode == null){
            $('#obtAddV1SubDist').prop('disabled',true);
        }else{
            $('#obtAddV1SubDist').prop('disabled',false);
        }
        $('.xCNSelectBox').selectpicker();
        
        var oMapCompany = {
            tDivShowMap	:'odvSplAdMapEdit',
            cLongitude	: <?php echo (isset($tAddLongitude)&&!empty($tAddLongitude))? floatval($tAddLongitude):floatval('100.50182294100522')?>,
            cLatitude	: <?php echo (isset($tAddLatitude)&&!empty($tAddLatitude))? floatval($tAddLatitude):floatval('13.757309968845291')?>,
            tInputLong	: 'oetSplAdMapLong',
            tInputLat	: 'oetSplAdMapLat',
            tIcon		: "https://openlayers.org/en/v4.6.5/examples/data/icon.png",
            tStatus		: '2'	
        }
        JSxMapAddEdit(oMapCompany);
        

    });


    var oSplAdBrowseArea = {
        Title : ['pos5/area','tARESubTitle'],
        Table:{Master:'TCNMArea',PK:'FTAreCode'},
        Join :{
            Table:	['TCNMArea_L'],
            On:['TCNMArea_L.FTAreCode = TCNMArea.FTAreCode AND TCNMArea_L.FNLngID = '+nLangEdits,]
        },
        GrideView:{
            ColumnPathLang	: 'pos5/area',
            ColumnKeyLang	: ['tARECode','tAREName'],
            ColumnsSize     : ['15%','75%'],
            WidthModal      : 50,
            DataColumns		: ['TCNMArea.FTAreCode','TCNMArea_L.FTAreName'],
            DataColumnsFormat : ['',''],
            Perpage			: 5,
            OrderBy			: ['TCNMArea.FTAreCode'],
            SourceOrder		: "ASC"
        },
        CallBack:{
            ReturnType	: 'S',
            Value		: ["oetAreCode","TCNMArea.FTAreCode"],
            Text		: ["oetAreName","TCNMArea_L.FTAreName"],
        },
        NextFunc:{
            FuncName:'FSxEnableBrowse',
            ArgReturn:['FTAreCode']
        },
        RouteAddNew : 'area',
        BrowseLev : nStaSplBrowseType
    } 
    $('#obtAreCode').click(function(){JCNxBrowseData('oSplAdBrowseArea')});

    //Option Zone
    var oSplAdBrowseZone = {
        Title : ['pos5/zone','tZNESubTitle'],
        Table:{Master:'TCNMZone',PK:'FTZneCode'},
        Join :{
            Table:	['TCNMZone_L'],
            On:['TCNMZone_L.FTZneCode = TCNMZone.FTZneCode AND TCNMZone_L.FNLngID = '+nLangEdits,]
        },
        Filter:{
            Selector:'oetAreCode',
            Table:'TCNMZone',
            Key:'FTAreCode'
        },
        GrideView:{
            ColumnPathLang	: 'pos5/zone',
            ColumnKeyLang	: ['tZNECode','tZNEName'],
            ColumnsSize     : ['15%','75%'],
            WidthModal      : 50,
            DataColumns		: ['TCNMZone.FTZneCode','TCNMZone_L.FTZneName'],
            DataColumnsFormat : ['',''],
            Perpage			: 5,
            OrderBy			: ['TCNMZone.FTZneCode'],
            SourceOrder		: "ASC"
        },
        CallBack:{
            ReturnType	: 'S',
            Value		: ["oetZneCode","TCNMZone.FTZneCode"],
            Text		: ["oetZneChainName","TCNMZone_L.FTZneName"],
        },
        NextFunc:{
            FuncName:'FSxEnableBrowse',
            ArgReturn:['FTZneCode']
        },

        RouteAddNew : 'zone',
        BrowseLev : nStaSplBrowseType
    }
    $('#obtZneCode').click(function(){JCNxBrowseData('oSplAdBrowseZone')});

    //Option Province
    var oSplAdBrowsePvn = {
        Title : ['pos5/province','tPVNTitle'],
        Table:{Master:'TCNMProvince',PK:'FTPvnCode'},
        Join :{
            Table:	['TCNMProvince_L'],
            On:['TCNMProvince_L.FTPvnCode = TCNMProvince.FTPvnCode AND TCNMProvince_L.FNLngID = '+nLangEdits,]
        },
        Filter:{
            Selector:'oetZneCode',
            Table:'TCNMProvince',
            Key:'FTZneCode'
        },
        GrideView:{
            ColumnPathLang	: 'pos5/province',
            ColumnKeyLang	: ['tPVNCode','tPVNName'],
            ColumnsSize     : ['15%','75%'],
            WidthModal      : 50,
            DataColumns		: ['TCNMProvince.FTPvnCode','TCNMProvince_L.FTPvnName'],
            DataColumnsFormat : ['',''],
            Perpage			: 5,
            OrderBy			: ['TCNMProvince.FTPvnCode'],
            SourceOrder		: "ASC"
        },
        CallBack:{
            ReturnType	: 'S',
            Value		: ["oetAddV1PvnCode","TCNMProvince.FTPvnCode"],
            Text		: ["oetPvnName","TCNMProvince_L.FTPvnName"],
        },
        NextFunc:{
            FuncName:'FSxEnableBrowse',
            ArgReturn:['FTPvnCode']
        },
        RouteAddNew : 'province',
        BrowseLev : nStaSplBrowseType
    }
    $('#obtAddV1PvnCode').click(function(){JCNxBrowseData('oSplAdBrowsePvn')});

    //Option District
    var oSplAdBrowseDst = {
        Title : ['pos5/district','tDSTTitle'],
        Table:{Master:'TCNMDistrict',PK:'FTDstCode'},
        Join :{
            Table:	['TCNMDistrict_L'],
            On:['TCNMDistrict_L.FTDstCode = TCNMDistrict.FTDstCode AND TCNMDistrict_L.FNLngID = '+nLangEdits,]
        },
        Filter:{
            Selector:'oetAddV1PvnCode',
            Table:'TCNMDistrict',
            Key:'FTPvnCode'
        },
        GrideView:{
            ColumnPathLang	: 'pos5/district',
            ColumnKeyLang	: ['tDSTTBCode','tDSTTBName'],
            ColumnsSize     : ['15%','75%'],
            WidthModal      : 50,
            DataColumns		: ['TCNMDistrict.FTDstCode','TCNMDistrict_L.FTDstName'],
            DataColumnsFormat : ['',''],
            Perpage			: 5,
            OrderBy			: ['TCNMDistrict.FTDstCode'],
            SourceOrder		: "ASC"
        },
        CallBack:{
            ReturnType	: 'S',
            Value		: ["oetAddV1DstCode","TCNMDistrict.FTDstCode"],
            Text		: ["oetDstName","TCNMDistrict_L.FTDstName"],
        },
        NextFunc:{
            FuncName:'FSxEnableBrowse',
            ArgReturn:['FTDstCode']
        },
        RouteAddNew : 'district',
        BrowseLev : nStaSplBrowseType
    }
    $('#obtAddV1DstCode').click(function(){JCNxBrowseData('oSplAdBrowseDst')});

    //Option sub District
    var oSplAdBrowseSubDist = {
        Title : ['pos5/subdistrict','tSDTTitle'],
        Table:{Master:'TCNMSubDistrict',PK:'FTSudCode'},
        Join :{
            Table:	['TCNMSubDistrict_L'],
            On:['TCNMSubDistrict_L.FTSudCode = TCNMSubDistrict.FTSudCode AND TCNMSubDistrict_L.FNLngID = '+nLangEdits,]
        },
        Filter:{
            Selector:'oetAddV1DstCode',
            Table:'TCNMSubDistrict',
            Key:'FTDstCode'
        },
        GrideView:{
            ColumnPathLang	: 'pos5/subdistrict',
            ColumnKeyLang	: ['tSDTTBCode','tSDTTBSubdistrict'],
            ColumnsSize     : ['15%','75%'],
            WidthModal      : 50,
            DataColumns		: ['TCNMSubDistrict.FTSudCode','TCNMSubDistrict_L.FTSudName','TCNMSubDistrict.FTSudLatitude','TCNMSubDistrict.FTSudLongitude'],
            DataColumnsFormat : ['',''],
            DisabledColumns	:[3,2],
            Perpage			: 5,
            OrderBy			: ['TCNMSubDistrict.FTSudCode'],
            SourceOrder		: "ASC"
        },
        CallBack:{
            ReturnType	: 'S',
            Value		: ["oetAddV1SubDist","TCNMSubDistrict.FTSudCode"],
            Text		: ["oetSudName","TCNMSubDistrict_L.FTSudName"],
        },
        NextFunc:{
            FuncName:'JSxNextFuncPlotMapSplAd',
            ArgReturn:['FTSudLatitude','FTSudLongitude']
        },
        RouteAddNew : 'subdistrict',
        BrowseLev : nStaSplBrowseType
    }
    $('#obtAddV1SubDist').click(function(){JCNxBrowseData('oSplAdBrowseSubDist')});

</script>
