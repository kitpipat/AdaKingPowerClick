<style type="text/css">
    .xWSMTSALImgPDT{
        height: 80px;
        width: 140px;
    }

    .xCNHighLightTop10:hover p{
        font-weight: bold;
        cursor: context-menu;
    }

    .xCNImageDashborad{
        width: 100%;
        height: 80px;
        background-position: center;
        background-size: cover;
        display: block;
        margin: 0px auto;
    }
    .fa-circle{
        font-size: 10px;
    }
    .otrApiDataRequest {
      cursor: pointer;
      }
</style>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 p-t-10 p-l-0 p-r-0">
    <div class="table-responsive table-scroll">
        <table id="otbSMTSALTopTenNewPdt" class="table">
        <thead>
            <tr>
                <th><b><?php echo language('common/main/main', 'tSMTBTypeApi')?></b></th>
                <th><b><?php echo language('common/main/main', 'tSMTBchName')?></b></th>
                <th><b><?php echo language('common/main/main', 'tSMTApi-Service')?></b></th>
                <th><b><?php echo language('common/main/main', 'tSMTUrl')?></b></th>
                <th><b><?php echo language('common/main/main', 'tSMTInformation')?></b></th>
                <th><b><?php echo language('common/main/main', 'tSMTStatusApi')?></b></th>
            </tr>
    </thead>
    <tbody>
            <!-- Data Rows -->

            <?php if(!empty($aUrlObjectDataResult) && !empty($aUrlObject)){ ?>
                <?php 
                            foreach($aUrlObjectDataResult as $tUrlGrp => $aDataUrlGroup){
                       
                                if(!empty($aDataUrlGroup)){ 
                                    foreach($aDataUrlGroup as $nK => $aData){
                    ?>
                                            <tr >
                                            <?php if($nK==0){ ?>
                                                <td rowspan="<?=FCNnHSizeOf($aDataUrlGroup)?>"><b><?=$tUrlGrp?></b></td>
                                            <?php   } ?>
                                                <td><?=$aData['rtBchName']?></td>
                                                <td><?=$aData['rtServiceName']?> <i style="font-size:12px" class="fa fa-exchange otrApiDataRequest"  aria-hidden="true" data-rid="<?=$aData['rnID']?>"  data-uri="<?=$aData['rtAddress']?><?php if(!empty($aData['rtPort'])){ echo ':'.$aData['rtPort']; }  ?>" data-service="<?=$aData['rtServiceName']?>" data-server="<?=$aData['rtAddress']?>" data-keyfilter="FAS" data-keygrp="BCH"></i></td>
                                                <td><?=$aData['rtAddress']?><?php if(!empty($aData['rtPort'])){ echo ':'.$aData['rtPort']; }  ?></td>
                                                <td>
                                                <?php
                                                    if($tUrlGrp=='MQ-Process'){  ?>
                                                    <p><?php echo language('common/main/main', 'tSMTConAPI')?> : <span id="ospConAPI_<?=$aData['rnID']?>"><?php echo language('common/main/main', 'tSMTLoading')?></span></p>
                                                 <?php   }
                                                ?>
                                                <p><?php echo language('common/main/main', 'tSMTService')?> : <span id="ospServer_<?=$aData['rnID']?>"><?php echo language('common/main/main', 'tSMTLoading')?></span></p>
                                                <p><?php echo language('common/main/main', 'tSMTDatabase')?> : <span id="ospDatabase_<?=$aData['rnID']?>"><?php echo language('common/main/main', 'tSMTLoading')?></span></p>
                                                </td>
                                                <td  id="ospStatusServer_<?=$aData['rnID']?>">
                                                <!-- <?=$aData['tStatusServer']?> -->
                                                <?php echo language('common/main/main', 'tSMTLoading')?>
                                                </td>
                                            </tr>
                <?php                       }
                                         }

                                    }  ?>
            <?php  }else{ ?>

                <tr><td class='text-center xCNTextDetail2' colspan='100%'><?php echo language('common/main/main', 'tCMNNotFoundData')?></td></tr>
            <?php } ?>
         <!-- Data Rows Close -->
         </tbody>
        </table>
    </div>
    <?php if($aUrlObject['rnAllPage']>1){ ?>
    <div class="row">
    <div class="col-md-6">
		<p><?php echo  language('common/main/main','tResultTotalRecord')?> <?php echo $aUrlObject['rnAllRow']?> <?php echo  language('common/main/main','tRecord')?> <?php echo  language('common/main/main','tCurrentPage')?> <?php echo $aUrlObject['rnCurrentPage']?> / <?php echo $aUrlObject['rnAllPage']?></p>
    </div>
    <div class="col-md-6">
        <div class="xWPageApi btn-toolbar pull-right">
            <?php if($nPage == 1){ $tDisabledLeft = 'disabled'; }else{ $tDisabledLeft = '-';} ?>
            <button onclick="JSvSMTAPIClickPage('previous')" class="btn btn-white btn-sm" <?php echo $tDisabledLeft ?>> <!-- เปลี่ยนชื่อ Onclick เป็นของเรื่องนั้นๆ --> 
                <i class="fa fa-chevron-left f-s-14 t-plus-1"></i>
            </button>
            <?php for($i=max($nPage-2, 1); $i<=max(0, min($aUrlObject['rnAllPage'],$nPage+2)); $i++){?> <!-- เปลี่ยนชื่อ Parameter Loop เป็นของเรื่องนั้นๆ --> 
                <?php 
                    if($nPage == $i){ 
                        $tActive = 'active'; 
                        $tDisPageNumber = 'disabled';
                    }else{ 
                        $tActive = '';
                        $tDisPageNumber = '';
                    }
                ?>
                <!-- เปลี่ยนชื่อ Onclick เป็นของเรื่องนั้นๆ --> 
                <button onclick="JSvSMTAPIClickPage('<?php echo $i?>')" type="button" class="btn xCNBTNNumPagenation <?php echo $tActive ?>" <?php echo $tDisPageNumber ?>><?php echo $i?></button>
            <?php } ?>
            <?php if($nPage >= $aUrlObject['rnAllPage']){  $tDisabledRight = 'disabled'; }else{  $tDisabledRight = '-';  } ?>
            <button onclick="JSvSMTAPIClickPage('next')" class="btn btn-white btn-sm" <?php echo $tDisabledRight ?>> <!-- เปลี่ยนชื่อ Onclick เป็นของเรื่องนั้นๆ --> 
                <i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
            </button>
        </div>
    </div>
</div>
<?php  } ?>

</div>


<script>





function JSxSMTRequestAPIInline(ptRID,ptUrl,tService,tServer){

    $.ajax({
        url:'salemonitorRequestAPIInOnLine',
        type:'POST',
        dataType:'json',
        data:{
            ptUrlRequest:ptUrl
        },
        success:function(res){
              var rtResult = res['rtResult'];
              var aEx = rtResult.split(":");
              var tDataBase = aEx[0];
              var tStatus = '<i class="fa fa-circle" style="color:green"></i> <b><?=language('sale/salemonitor/salemonitor','tSMTOnline')?></b>';
                $('#ospConAPI_'+ptRID).text(tService);
                $('#ospServer_'+ptRID).text('');
                $('#ospDatabase_'+ptRID).text(tDataBase);
                $('#ospStatusServer_'+ptRID).html(tStatus);
        },
        error : function(xhr, status,error) {
              var tStatus = '<i class="fa fa-circle" style="color:gray"></i> <b><?=language('sale/salemonitor/salemonitor','tSMTOffline')?></b>';
                $('#ospConAPI_'+ptRID).text('');
                $('#ospServer_'+ptRID).text('');
                $('#ospDatabase_'+ptRID).text('');
                $('#ospStatusServer_'+ptRID).html(tStatus);
        }
    });

}



        $('.otrApiDataRequest').unbind().click(function(){


           var tRID = $(this).data('rid');
           var tUru = $(this).data('uri');
           var tService = $(this).data('service');
           var tServer = $(this).data('server');
           var tSMTLoading = '<?php echo language('common/main/main', 'tSMTLoading')?>';
                $('#ospConAPI_'+tRID).text(tSMTLoading);
                $('#ospServer_'+tRID).text(tSMTLoading);
                $('#ospDatabase_'+tRID).text(tSMTLoading);
                $('#ospStatusServer_'+tRID).html(tSMTLoading);


            JSxSMTRequestAPIInline(tRID,tUru,tService,tServer);


        });
</script>