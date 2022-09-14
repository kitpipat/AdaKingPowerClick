<div>
    <div class="table-responsive">
        <table class="table table-striped xCNTblBrowse" id="otbPdtList">
            <thead>
                <tr class="xCNCenter">
                    <th><?= language('document/browsepdt/browsepdt','tTblPdtCode')?></th>
                    <th><?= language('document/browsepdt/browsepdt','tTblPdtName')?></th>
                    <th><?= language('document/browsepdt/browsepdt','tTblPdtBarCode')?></th>
                    <th><?= language('document/browsepdt/browsepdt','tTblPdtQty')?></th>
                    <th><?= language('document/browsepdt/browsepdt','tTblPdtPun')?></th>
                    <th><?= language('document/browsepdt/browsepdt','tTblPdtBalance')?></th>
                    <th><?= language('document/browsepdt/browsepdt','tTblPdtRetail')?></th>
                </tr>
            </thead>
                <?php $tPdtCodeCurrent = ''; ?>
                <?php if($aPdtList['rtCode'] == 1){?>
                    <?php foreach($aPdtList['raItems'] as $Key=>$Value){?>
                        <?php if($tPdtCodeCurrent != $Value->FTPdtCode){?>
                            <tbody id="otbodyPdt<?php echo $Value->FTPdtCode?>">
                                <tr class="panel-heading">
                                    <td class="text-left">
                                        <a class="xCNMenuplus xCNPdtIconPlus collapsed" role="button" data-toggle="collapse" href=".xWPdtlistDetail<?php echo $Value->FTPdtCode?>" aria-expanded="false" data-pdtcode="<?php echo $Value->FTPdtCode?>" style="font-size:16px !important;">
                                            <i class="fa fa-plus xCNPlus" style="font-size:10px;"> <label style="font-size:18px !important;cursor:pointer;"><?php echo $Value->FTPdtCode?></label></i>
                                        </a>
                                    </td>
                                    <td class="text-left"><?php echo $Value->FTPdtName?></td>
                                    <td class="text-left"></td>
                                    <td class="text-left"></td>
                                    <td class="text-left"></td>
                                    <td class="text-left"></td>
                                    <td class="text-left"></td>
                                </tr>
                            </tbody>
                            <?php $tPdtCodeCurrent = $Value->FTPdtCode?>
                        <?php } ?>
                    <?php } ?>
                <?php }else{?>
                    <tr><td class='text-center xCNTextDetail2' colspan='100%'><?= language('common/main/main','tCMNNotFoundData')?></td></tr>
                <?php } ?>
        </table>
    </div>
</div>

<div class="row">
    <!-- เปลี่ยน -->
    <div class="col-md-6">
        <p><?= language('common/main/main','tResultTotalRecord')?> <?=$aPdtList['rnAllRow']?> <?= language('common/main/main','tRecord')?> <?= language('common/main/main','tCurrentPage')?> <?=$aPdtList['rnCurrentPage']?> / <?=$aPdtList['rnAllPage']?></p>
    </div>
    <!-- เปลี่ยน -->
    <div class="col-md-6">
        <div class="xWPageBrowsePdt btn-toolbar pull-right"> <!-- เปลี่ยนชื่อ Class เป็นของเรื่องนั้นๆ --> 
            <?php if($nPage == 1){ $tDisabledLeft = 'disabled'; }else{ $tDisabledLeft = '-';} ?>
            <button onclick="JSvBrowsePdtClickPage('previous','PO')" class="btn btn-white btn-sm" <?php echo $tDisabledLeft ?>> <!-- เปลี่ยนชื่อ Onclick เป็นของเรื่องนั้นๆ --> 
                <i class="fa fa-chevron-left f-s-14 t-plus-1"></i>
            </button>
            <?php for($i=max($nPage-2, 1); $i<=max(0, min($aPdtList['rnAllPage'],$nPage+2)); $i++){?> <!-- เปลี่ยนชื่อ Parameter Loop เป็นของเรื่องนั้นๆ --> 
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
                <button onclick="JSvBrowsePdtClickPage('<?php echo $i?>','PO')" type="button" class="btn xCNBTNNumPagenation <?php echo $tActive ?>" <?php echo $tDisPageNumber ?>><?php echo $i?></button>
            <?php } ?>
            <?php if($nPage >= $aPdtList['rnAllPage']){  $tDisabledRight = 'disabled'; }else{  $tDisabledRight = '-';  } ?>
            <button onclick="JSvBrowsePdtClickPage('next','PO')" class="btn btn-white btn-sm" <?php echo $tDisabledRight ?>> <!-- เปลี่ยนชื่อ Onclick เป็นของเรื่องนั้นๆ --> 
                <i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
            </button>
        </div>
    </div>
</div>

<script >
    //Control Icon +,-
    $('.xCNPdtIconPlus').click(function(){
        if($(this).hasClass('collapsed') === true){
            $(this).removeClass('collapsed');
            tPdtCode = $(this).data('pdtcode');
            if($('#otbPdtList tr').hasClass('xWPdtlistDetail'+tPdtCode) === false){
                JSvPdtGetPdtDetailList(tPdtCode);
            }
        }else{
            $(this).addClass('collapsed');
        }
    });

</script>