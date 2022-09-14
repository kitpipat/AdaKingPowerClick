<link rel="stylesheet" href="<?php echo base_url(); ?>application/modules/monitordashboard/assets/css/globalcss/adaMDGeneral.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>application/modules/monitordashboard/assets/css/localcss/adaPossaleInfor.css">
<input type="hidden" id="ohdBaseURL" value="<?php echo base_url(); ?>">
<div class="container-fluid xCNPadding-20px">
    <input type="hidden" id="ohdBaseUrl" value="<?php echo base_url(); ?>">
    <div class="row">
        <div class="col-xs-12 col-sm-6">
            <label class="xWTopicMenu"><?php echo language('dashboard/vending','tVenTitleMenu') ?></label>
        </div>
        <div class="col-xs-12 col-sm-6 text-right">
            <div class="row">
                <div class="col-xs-12 col-md-3">
                    <div class="xCNDisplay-inline-block">
                        <label class="xCNMargin-bottom-0px"><?php echo language('dashboard/vending','tVenDateData') ?></label>
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
                            <option value="1"><?php echo language('dashboard/vending','tVenSaleData') ?></option>
                            <option value="2"><?php echo language('dashboard/vending','tVenInventory') ?></option>
                            <option value="3"><?php echo language('dashboard/vending','tVending') ?></option>
                            <option value="4"><?php echo language('dashboard/vending','tVendingInventory') ?></option>
                            <option value="5"><?php echo language('dashboard/vending','tVenLocker') ?></option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row panel xCNMargin-top-30px xCNPadding-bottom-10">
        <div class="col-xs-12 col-md-8">
            <div class="row xCNClearMarginRow xWFrameDivChoice xCNPadding-20px">
                <div class="col-xs-12">
                    <div>
                        <label class=""><?php echo language('dashboard/vending','tVenDataCon') ?></label>
                    </div>
                </div>
                <div class="col-xs-12 col-md-6 xCNMargin-bottom-30px" id="odvListBCH">
                    <select class="xCNWidth-100per selectpicker form-control" tabindex="-98" id="ocmListBCH">
                        <?php 
                        if($aBranch){
                            for($nI=0;$nI<FCNnHSizeOf($aBranch);$nI++){
                        ?>
                        <option value="<?php echo $aBranch[$nI]["FTBchCode"]; ?>"
                            <?php 
                            if($aBrancCom==$aBranch[$nI]["FTBchCode"]){
                            ?>
                                selected
                            <?php
                            }
                            ?>><?php echo $aBranch[$nI]["FTBchName"]; ?>
                        </option>
                        <?php
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="col-xs-12 col-md-6 xCNMargin-bottom-30px" id="odvListMCH">
                    <select class="xCNWidth-100per selectpicker form-control" tabindex="-98" id="ocmListMCH">
                        <option value="0"><?php echo language('dashboard/vending','tVenAllbusgroup') ?></option>
                        <?php
                        if($aMerChant){
                            for($nI=0;$nI<FCNnHSizeOf($aMerChant);$nI++){
                        ?>
                        <option value="<?php echo $aMerChant[$nI]["FTMerCode"]; ?>"
                        <?php 
                        if($nI==0){
                        ?>
                            selected
                        <?php
                        }
                        ?>
                        ><?php echo $aMerChant[$nI]["FTMerName"]; ?></option>
                        <?php
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="col-xs-12 col-md-6 xCNMargin-bottom-30px" id="odvListSPH">
                    <select class="xCNWidth-100per selectpicker form-control" tabindex="-98" id="ocmListSPH">
                        <option value="0"><?php echo language('dashboard/vending','tVenAllstores') ?></option>
                        <?php
                        if($aShop){
                            for($nI=0;$nI<FCNnHSizeOf($aShop);$nI++){
                        ?>
                        <option value="<?php echo $aShop[$nI]["FTShpCode"]; ?>"
                        <?php 
                        if($nI==0){
                        ?>
                            selected
                        <?php
                        }
                        ?>
                        ><?php echo $aShop[$nI]["FTShpName"]; ?></option>
                        <?php
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-md-4">
            <div class="row xCNClearMarginRow xCNMargin-top-30px">
                <div class="col-xs-12 col-sm-6 xWLeftBorderDiv-right">
                    <div>
                        <label><?php echo language('dashboard/vending','tVenTotalSaleBill') ?></label>
                    </div>
                    <div class="text-right">
                        <label class="xCNFontSize-40px" id="olbCountSaleBill">0.00</label>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 xWLeftBorderDiv-right">
                    <div>
                        <label><?php echo language('dashboard/vending','tVenTotalSale') ?></label>
                    </div>
                    <div class="text-right">
                        <label class="xCNFontSize-40px" id="olbSumSaleGross">0.00</label>
                    </div>
                </div>  
            </div>
            <div class="row xCNClearMarginRow xCNMargin-top-30px">
                <div class="col-xs-12 col-sm-6 xWLeftBorderDiv-right">
                    <div>
                        <label><?php echo language('dashboard/vending','tVenTotalreturnsbill') ?></label>
                    </div>
                    <div class="text-right">
                        <label class="xCNFontSize-40px" id="olbCountReturnBill">0.00</label>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 xWLeftBorderDiv-right">
                    <div>
                        <label><?php echo language('dashboard/vending','tVenTotalreturns') ?></label>
                    </div>
                    <div class="text-right">
                        <label class="xCNFontSize-40px" id="olbSumReturnGross">0.00</label>
                    </div>
                </div>  
            </div>
        </div>
        <div class="col-xs-12 col-md-6" id="odvShowGraph"></div>
        <div class="col-xs-12 col-md-6 xCNHeight-800px">
            <div class="row">
                <div class="col-xs-12">
                    <table class="table xCNMargin-top-30px">
                        <thead>
                            <tr>
                                <th colspan="4"><?php echo language('dashboard/vending','tVenDailyBestsell') ?></th>
                            </tr>
                        </thead>
                        <tbody id="otbBestSalePdt">
                        </tbody>
                    </table>
                </div>
                <div class="col-xs-12">
                    <table class="table xCNMargin-top-10px">
                        <thead>
                            <tr>
                                <th colspan="4"><?php echo language('dashboard/vending','tVenPdtsalebyCentainer') ?></th>
                            </tr>
                            <tr>
                                <th><?php echo language('dashboard/vending','tVencabCode') ?></th>
                                <th><?php echo language('dashboard/vending','tVenTotalSaleBill') ?></th>
                                <th><?php echo language('dashboard/vending','tVenTotalSale') ?></th>
                                <th><?php echo language('dashboard/vending','tVenMore') ?></th>
                            </tr>
                        </thead>
                        <tbody id="otbInforSaleVD">
                        </tbody>
                    </table>
                </div>
                <div class="col-xs-12">
                    <div class="row">
                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6" id="odvPaginationTable">
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>






























<script type="text/javascript" src="<?= base_url('application/modules/monitordashboard/assets/src/vending/jVdSaleInfor.js')?>"></script>
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