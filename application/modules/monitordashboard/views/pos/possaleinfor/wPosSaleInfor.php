<link rel="stylesheet" href="<?php echo base_url(); ?>application/modules/monitordashboard/assets/css/globalcss/adaMDGeneral.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>application/modules/monitordashboard/assets/css/localcss/adaPossaleInfor.css">
<input type="hidden" id="ohdBaseURL" value="<?php echo base_url(); ?>">
<div class="container-fluid xCNPadding-20px">
    <input type="hidden" id="ohdBaseUrl" value="<?php echo base_url(); ?>">
    <div class="row">
        <div class="col-xs-12 col-sm-6">
            <label class="xWTopicMenu"><?php echo $aDataTextRef['tDasTitleMenu']; ?></label>
        </div>
        <div class="col-xs-12 col-sm-6 text-right">
            <div class="row">
                <div class="col-xs-12 col-md-3">
                    <div class="xCNDisplay-inline-block">
                        <label class="xCNMargin-bottom-0px"><?php echo $aDataTextRef['tDasDateData']; ?></label>
                    </div>
                </div>
                <div class="col-xs-12 col-md-4 xCNMargin-bottom-20px">
                    <div class="xWTopicChoice-DateBox xCNWidth-100per">
                        <div class="input-group xCNWidth-100per">
                            <input type="text" id="oetDateFillter" class="form-control xCNDatePicker xCNInputMaskDate xCNInput-Text" readonly value="<?php echo date("Y-m-d"); ?>">
                            <!-- <span class="input-group-btn">
                                <button id="obtXthDocDate" type="button" class="btn xCNBtnDateTime">
                                    <img src="<?= base_url().'/application/modules/common/assets/images/icons/icons8-Calendar-100.png'?>">
                                </button>
                            </span> -->
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-md-5">
                    <div class="xWTopicChoice-SelectBox">
                        <select class="selectpicker form-control" tabindex="-98" name="ocmWriteGraphCompare" id="ocmWriteGraphCompare">
                            <option value="1"><?php echo $aDataTextRef['tDasSaleData']; ?></option>
                            <option value="2"><?php echo $aDataTextRef['tDasInventory']; ?></option>
                            <option value="3"><?php echo $aDataTextRef['tDasVending']; ?></option>
                            <option value="4"><?php echo $aDataTextRef['tDasVendingInventory']; ?></option>
                            <option value="5"><?php echo $aDataTextRef['tDasLocker']; ?></option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row panel xCNMargin-top-30px xCNPadding-bottom-10">
        <div class="col-xs-12 col-md-8">
            <div class="row xCNClearMarginRow xWFrameDivChoice xCNPadding-20px">
                <div class="col-xs-12 col-md-6 col-lg-4">
                    <div>
                        <label class=""><?php echo $aDataTextRef['tDasComFrom']; ?></label>
                    </div>
                    <div class="xCNWidth-100per">
                        <select class="selectpicker form-control" tabindex="-98" id="ocmTypeWriteGraph" name="ocmTypeWriteGraph">
                            <option value="pdtGroup"><?php echo $aDataTextRef['tDasPdtGroup']; ?></option>
                            <option value="pdtType"><?php echo $aDataTextRef['tDasTypeGroup']; ?></option>
                            <option value="usrBranch"><?php echo $aDataTextRef['tDasBch']; ?></option>
                            <option value="usrShop"><?php echo $aDataTextRef['tDasShop']; ?></option>
                        </select>
                    </div>
                </div>
                <div class="col-xs-12 col-md-6 col-lg-3">
                    <div> 
                        <label><?php echo $aDataTextRef['tDasComFrom']; ?></label>
                    </div>
                    <div class="xCNWidth-100per">
                        <select class="selectpicker form-control" tabindex="-98" id="ocmTypeCalDisplayGraph" name="ocmTypeCalDisplayGraph">
                            <option value="gross"><?php echo $aDataTextRef['tDasSale']; ?></option>
                                         <option value="bill"><?php echo $aDataTextRef['tDasBill']; ?></option>
                        </select>
                    </div>
                </div>
                <div class="col-xs-12 col-md-12 col-lg-5">
                    <div>
                        <label><?php echo $aDataTextRef['tDasDataCon']; ?></label>
                    </div>
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <input type="hidden" value="day" id="ohdConditionWritGraph" name="ohdConditionWritGraph">
                        <button type="button" class="btn btn-default xWBtnControlSearchActive" data-value="day" onclick="JSxSearchControlGraph(this);"><?php echo $aDataTextRef['tDasDate']; ?></button>
                        <button type="button" class="btn btn-default" data-value="week" onclick="JSxSearchControlGraph(this);"><?php echo $aDataTextRef['tDasWeek']; ?></button>
                        <button type="button" class="btn btn-default" data-value="month" onclick="JSxSearchControlGraph(this);"><?php echo $aDataTextRef['tDasMonth']; ?></button>
                        <button type="button" class="btn btn-default" data-value="year" onclick="JSxSearchControlGraph(this);"><?php echo $aDataTextRef['tDasYear']; ?></button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-md-4">
            <div class="row xCNClearMarginRow xCNMargin-top-30px">
                <div class="col-xs-12 col-sm-6 xWLeftBorderDiv-right">
                    <div>
                        <label><?php echo $aDataTextRef['tDasTotalSaleBill']; ?></label>
                    </div>
                    <div class="text-right">
                        <label class="xCNFontSize-40px" id="olbCountSaleBill">0.00</label>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 xWLeftBorderDiv-right">
                    <div>
                        <label><?php echo $aDataTextRef['tDasTotalSaleBill']; ?></label>
                    </div>
                    <div class="text-right">
                        <label class="xCNFontSize-40px" id="olbSumSaleGross">0.00</label>
                    </div>
                </div>  
            </div>
            <div class="row xCNClearMarginRow xCNMargin-top-30px">
                <div class="col-xs-12 col-sm-6 xWLeftBorderDiv-right">
                    <div>
                        <label> <?php echo $aDataTextRef['tDasTotalBillAmount']; ?></label>
                    </div>
                    <div class="text-right">
                        <label class="xCNFontSize-40px" id="olbCountReturnBill">0.00</label>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 xWLeftBorderDiv-right">
                    <div>
                        <label><?php echo $aDataTextRef['tDasTotalreturns']; ?></label>
                    </div>
                    <div class="text-right">
                        <label class="xCNFontSize-40px" id="olbSumReturnGross">0.00</label>
                    </div>
                </div>  
            </div>
        </div>
        <div class="col-xs-12" id="odvShowGraph"></div>
        <div class="col-xs-12">
            <table class="table">
                <thead>
                    <tr>
                        <th colspan="10"><?php echo $aDataTextRef['tDasDailyBestsell']; ?></th>
                    </tr>
                </thead>
                <tbody id="otbBestSalePdt">
                    
                </tbody>
            </table>
        </div>
    </div>
</div>
<script type="text/javascript" src="<?= base_url('application/modules/monitordashboard/assets/src/pos/jPosSaleInfor.js')?>"></script>
<script type="text/javascript">
<?php
    if(isset($_GET["tRoute"])){
    ?>
        var tRoute = '<?php echo $_GET["tRoute"]; ?>';
        $("#ocmWriteGraphCompare option").removeAttr("selected");
        $("#ocmWriteGraphCompare option[value='"+tRoute+"']").attr("selected","selected");
        $('.selectpicker').selectpicker('refresh');
    <?php
    }else{
    ?>
        var tRoute = '<?php echo $tRoute; ?>';
        $("#ocmWriteGraphCompare option").removeAttr("selected");
        $("#ocmWriteGraphCompare option[value='"+tRoute+"']").attr("selected","selected");
        $('.selectpicker').selectpicker('refresh');
    <?php    
    }
?>
</script>