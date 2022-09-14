<style>
.xWCSSDotStatus {
    width: 8px;
    height: 8px;
    border-radius: 100%;
    background: black;
    display: inline-block;
    margin-right: 5px;
}
.xWSCCStatusColor{
    font-weight: bold;
}
.xWCSSGreenColor{
    color:#2ECC71;
}
.xWCSSYellowColor{
    color:#F1C71F;
}
.xWCSSGrayColor{
    color:#7B7B7B;
}
.xWCSSGreenBG{
    background-color:#2ECC71;
}
.xWCSSYellowBG{
    background-color:#F1C71F;
}
.xWCSSGrayBG{
    background-color:#7B7B7B;
}
</style>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr class="xCNCenter">
                        <!-- <th class="xCNTextBold" style="width:5%;"><?=language('document/taxinvoice/taxinvoice','tTAXNum')?></th> -->
                        <th nowrap class="xCNTextBold"><?=language('document/taxinvoice/taxinvoice','tTAXBusiness2')?></th>
                        <th nowrap class="xCNTextBold"><?=language('document/taxinvoice/taxinvoice','tTAXDocumentType')?></th>
                        <th nowrap class="xCNTextBold" ><?=language('document/taxinvoice/taxinvoice','tTAXDocNoNew')?></th>
                        <th nowrap class="xCNTextBold" ><?=language('document/taxinvoice/taxinvoice','tTAXRefExt')?></th>
                        <th nowrap class="xCNTextBold" ><?=language('document/taxinvoice/taxinvoice','tTAXDocDate')?></th>
                        <th nowrap class="xCNTextBold"><?=language('document/taxinvoice/taxinvoice','tTAXCstName')?></th>
                        <th nowrap class="xCNTextBold" ><?=language('document/taxinvoice/taxinvoice','สถานะเอกสาร')?></th>
                        <th nowrap class="xCNTextBold"><?=language('document/taxinvoice/taxinvoice','tTAXTblStaDownload')?></th>
                        <th nowrap class="xCNTextBold"><?=language('document/taxinvoice/taxinvoice','tTAXCreateBy')?></th>
                        <th nowrap class="xCNTextBold" ><?=language('document/taxinvoice/taxinvoice','tTAXPreview')?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if($aABB['rtCode'] == 1):?>
                        <?php foreach($aABB['raItems'] as $nKey => $aValue): ?>
                            <tr class="text-center xCNTextDetail2">  
                                <!-- <td class="text-center"><?=$aValue['FNRowID']?></td> -->
                                <td nowrap class="text-left"><?=$aValue['FTBchName']?></td>
                                <td nowrap class="text-left"><?=language('document/taxinvoice/taxinvoice','tTAXDocType'.$aValue['FNXshDocType'])?></td>
                                <td nowrap class="text-left"><?=$aValue['FTXshDocNo']?></td>
                                <td nowrap class="text-left"><?=$aValue['FTXshRefExt']?></td>
                                <td nowrap class="text-center"><?=date_format(date_create($aValue['FDXshDocDate']),'d/m/Y');?></td>
                                <td nowrap class="text-left"><?=$aValue['FTAddName']?></td>
                                <td nowrap class="text-left">
                                    <?php
                                        switch($aValue['FTXshStaDoc']){
                                            case '1':
                                                $tXshStaDocName = "ใช้งาน"; /*สมบูรณ์*/
                                                break;
                                            case '2':
                                                $tXshStaDocName = "ยกเลิก"; /*ไม่สมบูรณ์*/
                                                break;
                                            case '3':
                                                $tXshStaDocName = "ยกเลิก"; /*ยกเลิก(ไม่ใช้งาน)*/
                                                break;
                                            case '4':
                                                $tXshStaDocName = "ใช้งาน"; /*ยกเลิก(ใช้งาน)*/
                                                break;
                                            case '5':
                                                $tXshStaDocName = "ยกเลิก"; /*แก้ไข*/
                                                break;
                                        }
                                        echo $tXshStaDocName;
                                    ?>
                                </td>
                                <td nowrap class="text-left">
                                <?php //พร้อมดาวน์โหลด E-Tax 2. ตรวจสอบสถานะ E-Tax 3. รออนุมัติ/ไม่สำเร็จ
                                    switch($aValue['FTXshETaxStatus']){
                                        case '1':
                                            $tDivClass  = "xWCSSGreenBG";
                                            $tSpanClass = "xWCSSGreenColor";
                                            $tLabel     = "พร้อมดาวน์โหลด E-Tax";
                                            break;
                                        case '2':
                                            $tDivClass  = "xWCSSYellowBG";
                                            $tSpanClass = "xWCSSYellowColor";
                                            $tLabel     = "ตรวจสอบสถานะ E-Tax";
                                            break;
                                        default:
                                            $tDivClass  = "xWCSSGrayBG";
                                            $tSpanClass = "xWCSSGrayColor";
                                            $tLabel     = "รออนุมัติ";
                                    }
                                    echo '<div class="xWCSSDotStatus '.$tDivClass.'"></div> <span class="xWSCCStatusColor '.$tSpanClass.'">'.$tLabel.'</span>';
                                ?>
                                </td>
                                <td nowrap class="text-left"><?=$aValue['FTCreateBy']?></td>
                                <td nowrap class="text-center">
                                    <img class="xCNIconTable" onClick="JSvTAXLoadPageAddOrPreview('<?=$aValue['FTBchCode']?>','<?=$aValue['FTXshDocNo']?>')" src="<?=base_url().'/application/modules/common/assets/images/icons/find-24.png'?>" >
                                </td>
                            </tr>
                        <?php endforeach;?>
                    <?php else:?>
                        <tr><td class="text-center xCNTextDetail2" colspan="100%"><?=language('common/main/main','tCMNNotFoundData')?></td></tr>
                    <?php endif;?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!--Page-->
<div class="row">
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
        <p><?=language('common/main/main','tResultTotalRecord')?> <?=$aABB['rnAllRow']?> <?=language('common/main/main','tRecord')?> <?=language('common/main/main','tCurrentPage')?> <?=$aABB['rnCurrentPage']?> / <?=$aABB['rnAllPage']?></p>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
        <div class="xWPageTAXPDT btn-toolbar pull-right">
            <?php if($nPage == 1){ $tDisabledLeft = 'disabled'; }else{ $tDisabledLeft = '-';} ?>
            <button onclick="JSvTAXClickPageList('previous')" class="btn btn-white btn-sm" <?php echo $tDisabledLeft ?>>
                <i class="fa fa-chevron-left f-s-14 t-plus-1"></i>
            </button>

            <?php for($i=max($nPage-2, 1); $i<=max(0, min($aABB['rnAllPage'],$nPage+2)); $i++){?>
                <?php 
                    if($nPage == $i){ 
                        $tActive = 'active'; 
                        $tDisPageNumber = 'disabled';
                    }else{ 
                        $tActive = '';
                        $tDisPageNumber = '';
                    }
                ?>
                <button onclick="JSvTAXClickPageList('<?php echo $i?>')" type="button" class="btn xCNBTNNumPagenation <?php echo $tActive ?>" <?php echo $tDisPageNumber ?>><?php echo $i?></button>
            <?php } ?>

            <?php if($nPage >= $aABB['rnAllPage']){  $tDisabledRight = 'disabled'; }else{  $tDisabledRight = '-';  } ?>
            <button onclick="JSvTAXClickPageList('next')" class="btn btn-white btn-sm" <?php echo $tDisabledRight ?>>
                <i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
            </button>
        </div>
    </div>
</div>

<script>
     //เปลี่ยนหน้า 1 2 3 ..
     function JSvTAXClickPageList(ptPage) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {
            var nPageCurrent = "";
            switch (ptPage) {
                case "next": //กดปุ่ม Next
                    $(".xWBtnNext").addClass("disabled");
                    nPageOld        = $(".xWPageTAXPDT .active").text(); // Get เลขก่อนหน้า
                    nPageNew        = parseInt(nPageOld, 10) + 1; // +1 จำนวน
                    nPageCurrent    = nPageNew;
                    break;
                case "previous": //กดปุ่ม Previous
                    nPageOld        = $(".xWPageTAXPDT .active").text(); // Get เลขก่อนหน้า
                    nPageNew        = parseInt(nPageOld, 10) - 1; // -1 จำนวน
                    nPageCurrent    = nPageNew;
                    break;
                default:
                    nPageCurrent    = ptPage;
            }
            JSxLoadContentDatatable(nPageCurrent);
        } else {
            JCNxShowMsgSessionExpired();
        }
    }

</script>