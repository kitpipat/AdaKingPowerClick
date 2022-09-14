<style>
    .xCNBorderRight{
        border-right:1px solid #cccccc;
    }
    .xCNNonBorder{
        border-top:0px!important;
    }
    .xCNBorderBottom{
        border-bottom:1px solid #cccccc;
    }
    .xCNTableOptionIco{
        width: 13px;
        cursor: pointer;
    }
    .xCNTableOptionIco:hover{
        width: 15px;
    }
    .table > tr > th {
        vertical-align: middle!important;
        font-size: 13px!important;
    }
    .table > tbody > tr > td {
        vertical-align: middle;
        font-size: 13px;
    }
    .xCNPointer{
        cursor:pointer;
    }
    .xWTdDisable {
        cursor: not-allowed !important;
        opacity: 0.4 !important;
    }

    .xWImgDisable {
        pointer-events: none;
    }
</style>
<input type="hidden" id="oetPdtForSys" value="<?php echo $tPdtForSys;?>"> 
<input type="hidden" id="oetPage"      value="<?php echo $nPage;?>"> 

<?php
    //Decimal Show ลง 2 ตำแหน่ง
    $nDecShow =  FCNxHGetOptionDecimalShow();
?>

<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div id="odvDataTableProduct" class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <?php if($aAlwEventPdt['tAutStaFull'] == 1 || $aAlwEventPdt['tAutStaDelete'] == 1) : ?>
                            <th nowrap class="text-center xCNTextBold" style="width:5%;"><?php echo language('product/product/product','tPDTTBChoose')?></th>
                        <?php endif; ?>
                        <th nowrap class="text-center xCNTextBold" style="width:5%;"><?php echo language('product/product/product','tPDTTBImg')?></th>

                        <!--======================================== Loop Manage Table ====================================================-->
                        <?php foreach($aPdtColumnShw AS $HeaderColKey => $HeaderColVal):?>
                            <th nowrap class="text-center xCNTextBold"><?php echo iconv_substr($HeaderColVal->FTShwNameUsr, 0,18,"UTF-8");?></th>
                        <?php endforeach;?>
                        <!--===============================================================================================================-->
                        <?php if($aAlwEventPdt['tAutStaFull'] == 1 || $aAlwEventPdt['tAutStaDelete'] == 1) : ?>
                        <th nowrap class="text-center xCNTextBold" style="width:5%;border-right-color: #fff !important;"><?php echo language('product/product/product','tPDTTBDelete')?></th>
                        <?php endif; ?>
                        <?php if($aAlwEventPdt['tAutStaFull'] == 1 || $aAlwEventPdt['tAutStaDelete'] == 1) : ?>
                        <th nowrap class="text-center xCNTextBold" style="width:5%;"><?php echo language('product/product/product','tPDTTBEdits')?></th>
                        <?php endif;?>
                    </tr>
                </thead>
                <tbody id="odvPdtDataList">
                    <?php 
                        $tProductCode   = '';
                        $tActiveStyle   = 'font-weight: bold !important; color: #2ECC71 !important;';
                        $tInActiveStyle = 'font-weight: bold !important; color: #d74141 !important;';
                    ?>
                    <?php if(is_array($aPdtDataList) && $aPdtDataList['rtCode'] == 1) : ?>
                        <?php foreach($aPdtDataList['raItems'] AS $nKeys => $aDataPdtVal):?>
                            <?php

                            if($aDataPdtVal['rtPdtStaPriRef'] == '1'){
                                $tDisableTD     = "xWTdDisable";
                                $tDisableImg    = "xWImgDisable";
                                $tDisabledItem  = "disabled ";
                                $tDisabledItem2  = "xCNDisabled ";
                                $tDisabledcheckrow  = "true";
                            }else{
                                $tDisableTD     = "";
                                $tDisableImg    = "";
                                $tDisabledItem  = "";
                                $tDisabledItem2  = " ";
                                $tDisabledcheckrow  = "false";
                            }
                            ?>

                            <?php if($tProductCode !== $aDataPdtVal['FTPdtCode']):?>
                                <tr class="xCNTextDetail2 xWPdtInfo xWPdtTr<?=$aDataPdtVal['FNRowID']?>" data-keys="<?=$aDataPdtVal['FNRowID']?>" data-code="<?php echo $aDataPdtVal['FTPdtCode'];?>" data-name="<?php echo $aDataPdtVal['FTPdtName'];?>">
                                    
                                    <?php if($aAlwEventPdt['tAutStaFull'] == 1 || $aAlwEventPdt['tAutStaDelete'] == 1) : ?>
                                        <td nowrap class="text-center xCNBorderRight xWPdtMerge">
                                            <label class="fancy-checkbox">
                                                <input id="ocbListItem<?php echo $nKeys?>" <?php echo $tDisabledItem; ?> type="checkbox" class="ocbListItem" name="ocbListItem[]">
                                                <span class="<?php echo $tDisabledItem2; ?>">&nbsp;</span>
                                            </label>
                                        </td>
                                    <?php endif; ?>
                                    <td nowrap class="xCNBorderRight xWPdtImgtd" rowspan="4" style="padding-right:10px !important">
                                        <?php echo FCNtHGetImagePageList($aDataPdtVal['FTImgObj'],'100%'); ?>
                                    </td>
                                      
                                    <?php foreach($aPdtColumnShw AS $nDataKey => $aDataVal):
                                        $tColumnName        = $aDataVal->FTShwFedShw;
                                        $nColWidth          = $aDataVal->FNShwColWidth;
                                        $tColumnDataType    = substr($tColumnName,0,2);
                                        if($tColumnDataType == 'FC'){
                                            $tAlignFormat   = 'text-right';
                                            $tDataCol       = number_format($aDataPdtVal[$tColumnName],$nDecShow);
                                        }elseif($tColumnDataType == 'FN'){
                                            $tAlignFormat   = 'text-right';
                                            $tDataCol       = number_format($aDataPdtVal[$tColumnName],0);
                                        }else{
                                            $tAlignFormat = 'text-left';
                                            $tDataCol = $aDataPdtVal[$tColumnName];
                                        }
                                    ?>
                                        <?php
                                            $tRemark   = '';
                                            $tPdtStyle = '';
                                            switch($tColumnName){
                                                case 'FTPdtName':
                                                    $tClassMerge    = 'xWPdtMerge';
                                                break;
                                                case 'FTPdtCode':
                                                    $tClassMerge    = 'xWPdtMerge';
                                                break;
                                                case 'FTBarCode':
                                                    $tClassMerge    = '';
                                                    if( $aDataPdtVal['FTBarStaUse'] == '1' ){
                                                        $tPdtStyle = $tActiveStyle;
                                                    }else{
                                                        $tPdtStyle = $tInActiveStyle;
                                                    }
                                                break;
                                                case 'FTPgpName':
                                                    $tClassMerge    = 'xWPdtMerge';
                                                break;
                                                case 'FTPtyName':
                                                    $tClassMerge    = 'xWPdtMerge';
                                                break;
                                                default:
                                                    $tPdtStyle      = '';
                                                    $tClassMerge    = '';
                                            }
                                        ?>

                                        <?php 
                                            //เช็คค่าว่าง
                                            if($tDataCol == '' || $tDataCol == null){
                                                $tDataCol = '-';
                                            }else{
                                                $tDataCol = $tDataCol;
                                            }
                                        ?>
                                        
                                        <td nowrap class="<?php echo $tAlignFormat;?> <?php echo $tClassMerge;?>" style="width:<?php echo $nColWidth?>%; <?=$tPdtStyle?>"><?php echo $tDataCol?></td>
                                    <?php endforeach; ?>
                                    <?php if($aAlwEventPdt['tAutStaFull'] == 1 || $aAlwEventPdt['tAutStaDelete'] == 1) : ?>
                                        <td nowrap class="text-center xWPdtMerge xWTDBorderPDT <?=$tDisableTD?>" style="border-right-color:#fff !important;border-top-style: double !important;">
                                            <img class="xCNIconTable xCNIconDelete xWPdtDeleteItem <?php echo $tDisableImg; ?>" data-delpage="<?php echo $nPage;?>" data-delcode="<?php echo $aDataPdtVal['FTPdtCode'];?>" data-delname="<?php echo $aDataPdtVal['FTPdtName'];?>" data-type="<?php echo $aDataPdtVal['FTPdtForSystem'];?>">
                                        </td>
                                    <?php endif; ?>
                                    
                                    <?php if($aAlwEventPdt['tAutStaFull'] == 1 || $aAlwEventPdt['tAutStaDelete'] == 1) : ?>
                                        <td nowrap class="text-center xWPdtMerge xWTDBorderPDT" style="border-top-style: double !important;">
                                            <img class="xCNIconTable xCNIconEdit xWPdtCallPageEdit">
                                        </td>
                                    <?php endif; ?>
                                </tr>
                            <?php  $tProductCode = $aDataPdtVal['FTPdtCode']; elseif($tProductCode === $aDataPdtVal['FTPdtCode']): ?>
                                <tr class="xCNTextDetail2 xWPdtTr<?=$aDataPdtVal['FNRowID']?>">
                                    <?php foreach($aPdtColumnShw AS $nDataKey => $aDataVal):
                                        $tColumnName        = $aDataVal->FTShwFedShw;
                                        $nColWidth          = $aDataVal->FNShwColWidth;
                                        $tColumnDataType    = substr($tColumnName,0,2);
                                        if($tColumnDataType == 'FC'){
                                            $tAlignFormat   = 'text-right';
                                            $tDataCol       = number_format($aDataPdtVal[$tColumnName],$nDecShow);
                                        }elseif($tColumnDataType == 'FN'){
                                            $tAlignFormat   = 'text-right';
                                            $tDataCol       = number_format($aDataPdtVal[$tColumnName],0);
                                        }else{
                                            $tAlignFormat   = 'text-left';
                                            $tDataCol       = $aDataPdtVal[$tColumnName];
                                        }

                                        if( $aDataPdtVal['FTBarStaUse'] == '1' ){
                                            $tPdtStyle = $tActiveStyle;
                                        }else{
                                            $tPdtStyle = $tInActiveStyle;
                                        }

                                    ?>
                                        <?php switch($tColumnName): 
                                            case 'FTPdtCode': ?>
                                            <!-- <td nowrap class="xCNNonBorder" style="width:<?php echo $nColWidth?>%"></td> -->
                                        <?php break;?>
                                        <?php case 'FTPdtName': ?>
                                        <?php break;?>
                                        <?php case 'FTBarCode': ?>
                                            <td nowrap class="xCNNonBorder <?php echo $tAlignFormat?>" style="width:<?php echo $nColWidth?>%; <?=$tPdtStyle?>"><?php echo $tDataCol?></td>
                                        <?php break;?>
                                        <?php case 'FTPgpChainName': ?>
                                            <td nowrap class="xCNNonBorder" style="width:<?php echo $nColWidth?>%"></td>
                                        <?php break;?>
                                        <?php case 'FTPgpName': ?>
                                        <?php break;?>
                                        <?php case 'FTPtyName': ?>
                                        <?php break;?>
                                        <?php default: ?>
                                            <td nowrap class="xCNNonBorder <?php echo $tAlignFormat?>" style="width:<?php echo $nColWidth?>%"><?php echo $tDataCol?></td>
                                        <?php endswitch;?>
                                    <?php endforeach; ?>
                                </tr>
                            <?php endif; ?> 
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td class='text-center xCNTextDetail2' colspan='99'><?php echo language('common/main/main','tCMNNotFoundData')?></td></tr>
                    <?php endif;?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
        <input type="hidden" id="ohdProductAllRow" name="ohdProductAllRow" value="<?=$aPdtDataList['rnAllRow']?>" >
        <p><?php echo language('common/main/main','tResultTotalRecord')?> <?php echo number_format($aPdtDataList['rnAllRow'])?> <?php echo language('common/main/main','tRecord')?> <?php echo language('common/main/main','tCurrentPage')?> <?php echo number_format($aPdtDataList['rnCurrentPage'])?> / <?php echo number_format($aPdtDataList['rnAllPage'])?></p>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
        <div class="xWPageProduct btn-toolbar pull-right">
            <?php if($nPage == 1){ $tDisabledLeft = 'disabled'; }else{ $tDisabledLeft = '-';} ?>
            <button data-page="Fisrt" class="btn btn-white btn-sm xCNBtnPagenation" <?php echo $tDisabledLeft ?> style="padding: 5px 10px;">
                <i class="fa fa-chevron-left f-s-14 t-plus-1"></i><i class="fa fa-chevron-left f-s-14 t-plus-1" style="margin-left: -3px;"></i>
            </button>
            <button data-page="previous" class="btn btn-white btn-sm xCNBtnPagenation" <?php echo $tDisabledLeft ?> style="padding: 5px 10px;">
                <i class="fa fa-chevron-left f-s-14 t-plus-1"></i>
            </button>

            <?php for($i=max($nPage-2, 1); $i<=max(0, min($aPdtDataList['rnAllPage'],$nPage+4)); $i++){?>
                <?php 
                    if($nPage == $i){ 
                        $tActive = 'active'; 
                        $tDisPageNumber = 'disabled';
                    }else{ 
                        $tActive = '';
                        $tDisPageNumber = '';
                    }
                ?>
                <button data-page="<?php echo $i;?>" type="button" class="btn xCNBtnPagenation xCNBTNNumPagenation <?php echo $tActive ?>" <?php echo $tDisPageNumber ?>><?php echo $i?></button>
            <?php } ?>

            <?php if($nPage >= $aPdtDataList['rnAllPage']){  $tDisabledRight = 'disabled'; }else{  $tDisabledRight = '-';  } ?>
            <button data-page="next" class="btn btn-white btn-sm xCNBtnPagenation" <?php echo $tDisabledRight ?> style="padding: 5px 10px;">
                <i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
            </button>
            <button data-page="Last" data-endpage="<?=$aPdtDataList['rnAllPage']?>" class="btn btn-white btn-sm xCNBtnPagenation" <?php echo $tDisabledRight ?> style="padding: 5px 10px;">
                <i class="fa fa-chevron-right f-s-14 t-plus-1"></i><i class="fa fa-chevron-right f-s-14 t-plus-1" style="margin-left: -3px;"></i>
            </button>
        </div>
    </div>
</div>


<!-- ===================================================== Modal Delete Product Multiple =================================================== -->
<div id="odvModalDeletePdtMultiple" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header xCNModalHead">
                    <label class="xCNTextModalHeard"><?php echo language('common/main/main', 'tModalDelete')?></label>
                </div>
                <div class="modal-body">
                    <span id="ospTextConfirmDelMultiple" class="xCNTextModal" style="display: inline-block; word-break:break-all"></span>
                    <input type='hidden' id="ohdConfirmIDDelMultiple">
                </div>
                <div class="modal-footer">
                    <button id="osmConfirmDelMultiple" onclick="JSoProductDeleteMultiple();" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" type="button"><?php echo language('common/main/main', 'tModalConfirm')?></button>
                    <button class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"  data-dismiss="modal"><?php echo language('common/main/main', 'tModalCancel')?></button>
                </div>
            </div>
        </div>
    </div>
<!-- ====================================================== End Modal Delete Product Multiple ============================================== -->


<script type="text/Javascript">
    $('ducument').ready(function(){
        JSxPdtSetRowSpan();
    });

    $('.xWPdtCallPageEdit').click(function(){
        var tPdtCode    = $(this).parents('.xWPdtInfo').data('code');
        JSvCallPageProductEdit(tPdtCode,'edit');
    });

    $('.xWPdtCallPageView').click(function(){
        var tPdtCode    = $(this).parents('.xWPdtInfo').data('code');
        JSvCallPageProductEdit(tPdtCode,'view');
    });

    $('.xCNBtnPagenation').click(function(){
        var tNumberPage = $(this).data('page');
        var nEndPage    = $(this).data('endpage');
        JSvProductClickPage(tNumberPage,nEndPage);
        return false;
    });

    // Event Delete Single
    $('.xWPdtDeleteItem').click(function(){
        var nPageDel        = $(this).data('delpage');
        var nPageCodeDel    = $(this).data('delcode');
        var nPageNameDel    = $(this).data('delname');
        var nPdtForSystem   = $(this).data('type');
        JSoProductDeleteSingle(nPageDel,nPageCodeDel,nPageNameDel,nPdtForSystem);
    });

    // Select List Table Item
    $('.ocbListItem').click(function(){
        var nCode = $(this).parent().parent().parent().data('code');  //code
        var tName = $(this).parent().parent().parent().data('name');  //Name
        $(this).prop('checked', true);
        var LocalItemData = localStorage.getItem("LocalItemData");
        var obj = [];
        if(LocalItemData){
            obj = JSON.parse(LocalItemData);
        }else{ }
        var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
        if(aArrayConvert == '' || aArrayConvert == null){
            obj.push({"nCode": nCode, "tName": tName });
            localStorage.setItem("LocalItemData",JSON.stringify(obj));
            JSxPaseCodeDelInModal();
        }else{
            var aReturnRepeat   = findObjectByKey(aArrayConvert[0],'nCode',nCode);
            if(aReturnRepeat == 'None' ){           //ยังไม่ถูกเลือก
                obj.push({"nCode": nCode, "tName": tName });
                localStorage.setItem("LocalItemData",JSON.stringify(obj));
                JSxPaseCodeDelInModal();
            }else if(aReturnRepeat == 'Dupilcate'){	//เคยเลือกไว้แล้ว
                localStorage.removeItem("LocalItemData");
                $(this).prop('checked', false);
                var nLength = aArrayConvert[0].length;
                for($i=0; $i<nLength; $i++){
                    if(aArrayConvert[0][$i].nCode == nCode){
                        delete aArrayConvert[0][$i];
                    }
                }
                var aNewarraydata = [];
                for($i=0; $i<nLength; $i++){
                    if(aArrayConvert[0][$i] != undefined){
                        aNewarraydata.push(aArrayConvert[0][$i]);
                    }
                }
                localStorage.setItem("LocalItemData",JSON.stringify(aNewarraydata));
                JSxPaseCodeDelInModal();
            }
        }
        JSxShowButtonChoose();
    });

    //Function Chack RowSpan Image In Tr Data
    //Parameters : Document Redy And Event Button
    //Creator :	01/02/2019 wasin(Yoshi)
    //Return : Set RowSpan In TD
    //Return Type : None
    function JSxPdtSetRowSpan(){
        $('#odvDataTableProduct #odvPdtDataList .xWPdtInfo').each(function(){
            var tDataPdtCode        = $(this).data('keys');
            
            var nContDataRowSpan    = $('#odvDataTableProduct #odvPdtDataList .xWPdtTr'+tDataPdtCode).length;
            console.log('#odvDataTableProduct #odvPdtDataList .xWPdtTr'+tDataPdtCode);
            $('#odvDataTableProduct #odvPdtDataList .xWPdtTr'+tDataPdtCode+' .xWPdtImgtd').attr('rowspan',nContDataRowSpan);
            $('#odvDataTableProduct #odvPdtDataList .xWPdtTr'+tDataPdtCode+' .xWPdtMerge').attr('rowspan',nContDataRowSpan);
        });
    }
</script>
