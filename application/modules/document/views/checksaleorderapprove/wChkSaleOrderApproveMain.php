<style>
    .xCNBoderTaskGreen{
        border: 1px solid #66ff669c;
        background: #66ff669c;
        padding: 20px;
        margin-top: 10px;
        border-radius: 10px;
        border-top-right-radius: 0px !important;
        float : left;
        width:98%;
    }

    .xCNBoderTrigle{
        float       : right; 
        width       : 2%;   
        margin-top  : 10px
    }

    .TrigleGreen{
        width       : 0;
        height      : 0;
        border-style: solid;
        border-width: 10px 10px 0 0;
        border-color: #66ff66b3 transparent transparent transparent;
        position    : absolute;
        z-index     : 1;
        margin-top  : 0.05rem;
    }

    .TrigleGreenPositionBottom{
        z-index         : 0;
        border-style    : solid;
        border-width    : 12.5px 12px 0px 0;
        border-color    : #66ff66b3 transparent transparent transparent;
        position        : absolute;
    }

    .TrigleGreenBlock{
        background  : #66ff663d !important;
        width       : 5px;
        height      : 10px;
        z-index     : 2;
        position    : absolute;
        margin-left : -5px;
        margin-top  : 0.05rem;
    }

    .xCNBoderTaskGreen{
        border          : 1px solid #66ff66b3;
        background      :  #66ff66b3;
        padding         : 20px;
        margin-top      : 10px;
        border-radius   : 10px;
        border-top-right-radius: 0px !important;
        float           : left;
        width           : 98%;
    }

    /* =============================================================================== */

    .TrigleRed{
        width       : 0;
        height      : 0;
        border-style: solid;
        border-width: 10px 10px 0 0;
        border-color: #ffd2d2 transparent transparent transparent;
        position    : absolute;
        z-index     : 1;
        margin-top  : 0.05rem;
    }

    .xCNBoderTaskRed{
        border          : 1px solid #ff303038;
        background      :  #ff303038;
        padding         : 20px;
        margin-top      : 10px;
        border-radius   : 10px;
        border-top-right-radius: 0px !important;
        float           : left;
        width           : 98%;
    }

    .TrigleRedPositionBottom{
        z-index         : 0;
        border-style    : solid;
        border-width    : 12.5px 12px 0px 0;
        border-color    : #ffafaf transparent transparent transparent;
        position        : absolute;
    }

    .TrigleRedBlock{
        background  : #ffd2d2 !important;
        width       : 5px;
        height      : 10px;
        z-index     : 2;
        position    : absolute;
        margin-left : -5px;
        margin-top  : 0.05rem;
    }

    .xCNLabelDoc{
        font-weight: bold;
        font-size: 20px;
    }

    .xCNSetPading1{
        padding: 1px;
    }

</style>

<?php 
    $tUserMonitorlogin =  $this->session->userdata('tSesUsrRoleCodeMulti');
    $tRoleCode   = str_replace("'","",$tUserMonitorlogin);
    $aRoleCode   = explode(",",$tRoleCode);
    $tPercent =  100/FCNnHSizeOf($aResultSeq) ;
?>
<input type="hidden" name="oheSonSetLimitTimeReloadPageMain" id="ohdSonSetLimitTimeReloadPageMain" value="<?=$nSetLimitTimeReloadPageMain?>">
<div class="row" style="overflow-x: scroll;">
    <?php if(isset($aResultSeq) && !empty($aResultSeq)) { ?>
        <?php foreach(@$aResultSeq AS $aValSeq) :?>
            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 p-r-0" style="width: <?=$tPercent?>%;">
                <!-- รอเภสัชยืนยัน Seq 2 -->
                <div class="panel panel-default">
                    <div class="panel-heading xCNPanelHeadColor">
                        <?php $tText = str_replace("\\n","",trim($aValSeq['FTDapName']));?>
                        <label class="xCNTextDetail1"><?=nl2br($tText);?></label>
                    </div>
                    <div id="odvPamacistConfirm" class="panel-collapse collapse in" role="tabpanel">
                            <div class="panel-body">
                                    <?php 
                                        if(!empty(@$aResultData[$aValSeq['FNDarApvSeq']])){
                                            foreach(@$aResultData[$aValSeq['FNDarApvSeq']] AS $aValue):
                                                $nLoopCheckRole = 0;
                                                if(!empty($aRoleCode)){
                                                    foreach($aRoleCode as $tRoleCodeValue){
                                                        if($aValue['FTDarUsrRole'] == $tRoleCodeValue){
                                                            $nLoopCheckRole++;
                                                        }
                                                    }
                                                }
												
											
                                                ?>
                                            <?php if (!empty($aValue['FTDarUsrRole'])  && !empty($tUserMonitorlogin)  && $nLoopCheckRole>0): ?>
                                                    <div class="xCNBoderTaskGreen">
                                                        <!-- เลขที่เอกสาร -->
                                                        <?php 
                                                            $tDocument = ''; 
                                                            if($aValue['FTXshRefExt'] == ''){
                                                                $tDocument = $aValue['FTXshDocNo'];
                                                            }else{
                                                                $tDocument = $aValue['FTXshRefExt'];
                                                            }
                                                        ?>
                                                        <div class="row">  
                                                            <div class="col-md-8 xCNSetPading1 xCNLabelDoc"><?=$tDocument?></div><div  class="col-md-4 xCNSetPading1" align="right"><img class="xCNIconTable ImgEdit" src="<?php echo  base_url().'/application/modules/common/assets/images/icons/edit.png'?>" onClick="JSvSOCallPageEditDocOnMonitor('<?=$tDocument?>')"></div>
                                                        </div>
                                                        <!-- วันที่เอกสาร -->
                                                        <div class="row">
                                                            <label class="xCNLabelDoc"><?php echo language('sale/checksaleorderapprove/chksaleorder','tCHKSaleDocDate');?></label>  <?php echo date( "d/m/Y H:i:s", strtotime($aValue['FDXshDocDate']) ); ?>
                                                        </div>
                                                        <!-- หมายเลขผู้ป่วย -->
                                                        <div class="row">
                                                            <label class="xCNLabelDoc"><?php echo language('sale/checksaleorderapprove/chksaleorder','tCHKSalPatientNo');?></label>  <?php echo $aValue['FTCstCode'];?>
                                                        </div>
                                                        <!-- หมายเลขผู้ป่วย และชื่อผู้ป่วย -->
                                                        <div class="row">
                                                            <label class="xCNLabelDoc"><?php echo language('sale/checksaleorderapprove/chksaleorder','tCHKSaNamePatient');?></label>  <?php echo $aValue['FTXshCstName'];?>
                                                        </div>
                                                        <!-- แผนก-->
                                                        <?php if($aValue['FTDptName'] == '' || $aValue['FTDptName'] == null){ ?>

                                                        <?php }else{ ?>
                                                            <div class="row">
                                                                <label class="xCNLabelDoc"><?=language('sale/checksaleorderapprove/chksaleorder','tCHKDepartment');?></label><?=$aValue['FTDptName'];?>
                                                            </div>
                                                        <?php } ?>
                                                    </div>
                                                    <div class="xCNBoderTrigle">
                                                        <div class="TrigleGreen"></div>
                                                        <div class="TrigleGreenPositionBottom"></div>
                                                        <div class="TrigleGreenBlock"></div>
                                                    </div>
                                                <?php else : ?>
                                                    <div class="xCNBoderTaskRed">
                                                        <!-- เลขที่เอกสาร -->
                                                        <?php 
                                                            $tDocument = ''; 
                                                            if($aValue['FTXshRefExt'] == ''){
                                                                $tDocument = $aValue['FTXshDocNo'];
                                                            }else{
                                                                $tDocument = $aValue['FTXshRefExt'];
                                                            }
                                                        ?>
                                                        <div class="row">  
                                                            <div class="col-md-8 xCNSetPading1 xCNLabelDoc"><?=$tDocument;?></div><div  class="col-md-4 xCNSetPading1" align="right"></div>
                                                        </div>
                                                        <!-- วันที่เอกสาร -->
                                                        <div class="row">
                                                            <label class="xCNLabelDoc"><?php echo language('sale/checksaleorderapprove/chksaleorder','tCHKSaleDocDate');?></label>  <?php echo date( "d/m/Y H:i:s", strtotime($aValue['FDXshDocDate']) ); ?>
                                                        </div>
                                                        <!-- หมายเลขผู้ป่วย -->
                                                        <div class="row">
                                                            <label class="xCNLabelDoc"><?php echo language('sale/checksaleorderapprove/chksaleorder','tCHKSalPatientNo');?></label>  <?php echo $aValue['FTCstCode'];?>
                                                        </div>
                                                        <!-- หมายเลขผู้ป่วย และชื่อผู้ป่วย -->
                                                        <div class="row">
                                                            <label class="xCNLabelDoc"><?php echo language('sale/checksaleorderapprove/chksaleorder','tCHKSaNamePatient');?></label>  <?php echo $aValue['FTXshCstName'];?>
                                                        </div>
                                                        <!-- แผนก-->
                                                        <?php if($aValue['FTDptName'] == '' || $aValue['FTDptName'] == null){ ?>

                                                        <?php }else{ ?>
                                                            <div class="row">
                                                                <label class="xCNLabelDoc"><?=language('sale/checksaleorderapprove/chksaleorder','tCHKDepartment');?></label><?=$aValue['FTDptName'];?>
                                                            </div>
                                                        <?php } ?>
                                                    </div>
                                                    <div class="xCNBoderTrigle">
                                                        <div class="TrigleRed"></div>
                                                        <div class="TrigleRedPositionBottom"></div>
                                                        <div class="TrigleRedBlock"></div>
                                                    </div>
                                                <?php endif ;?>
                                            <?php endforeach; 
                                        } 
                                    ?>
                            </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php } ?>
</div>

<script>
    if(localStorage.getItem("SucOnSO")!=0){
    var tQName = 'AR_QNotiMsgByUser<?=$this->session->userdata('tSesUserCode')?>';

    oGetResponse = setInterval(function() {  
        $.ajax({
        url     : 'dcmSOMonitorGetMassge',
        type    : 'post',
        data    : {tQName:tQName},
        success:function(res){
            try {

                localStorage.setItem("SucOnSO", 0);
                if(res.trim()!='false'){

                        JSvCHKSoCallPageMain(); 
     
                }
            } catch (err) {
                        console.log("Listening rabbit mq server: ", err);
                    }
                }
            });

            }, 1000); //10000 milliseconds = 10 seconds

    }

    $('.ImgEdit').click(function(){
        localStorage.setItem("SucOnSO", 1);
        clearInterval(oGetResponse);
    })

    $("ul.get-menu li > a").click(function () {
        localStorage.setItem("SucOnSO", 1);
        clearInterval(oGetResponse);
    });

    var nSetLimitTimeReloadPageMain    = parseFloat($("#ohdSonSetLimitTimeReloadPageMain").val());
    setTimeout(JSvCHKSoCallPageMain, nSetLimitTimeReloadPageMain);
</script>