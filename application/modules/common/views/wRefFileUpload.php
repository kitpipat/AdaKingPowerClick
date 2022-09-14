<style>
.xUPFDeleteFile{
    color:red;
    cursor:pointer;
}
.xUPFTdHilight{
    background-color: #cccccc3d;
}
.xUPFTrPadding5{
    padding-top:2.5px;
    padding-bottom:2.5px;
}
.inputfile {
  /* visibility: hidden etc. wont work */
  width: 0.1px;
  height: 0.1px;
  opacity: 0;
  overflow: hidden;
  position: absolute;
  z-index: -1;
}
.inputfile:focus + label {
  /* keyboard navigation */
  outline: 0px dotted #000;
  outline: -webkit-focus-ring-color auto 0px;
}
.inputfile + label * {
  pointer-events: none;
}
.xCutTextLong{
    white-space: nowrap;
    text-overflow: ellipsis;
    -o-text-overflow: ellipsis;
    -ms-text-overflow: ellipsis;
    overflow: hidden;
    width: 150px;
}
.scroller {
  /* width: 300px; */
  height: 200px;
  overflow-y: scroll;
  scrollbar-color: rebeccapurple green;
  scrollbar-width: thin;
}

</style>

<div class="row">
<input type="hidden" name="ohdUPFViewBchCode<?=$tDocKey.$tElementID?>"  id="ohdUPFViewBchCode<?=$tDocKey.$tElementID?>" value="<?=$tBchCode?>">
<input type="hidden" name="ohdUPFViewDocNo<?=$tDocKey.$tElementID?>"  id="ohdUPFViewDocNo<?=$tDocKey.$tElementID?>"  value="<?=$tDocNo?>">
<input type="hidden" name="ohdUPFViewDocKey<?=$tDocKey.$tElementID?>"  id="ohdUPFViewDocKey<?=$tDocKey.$tElementID?>"  value="<?=$tDocKey?>">
<input type="hidden" name="ohdUPFViewSessionID<?=$tDocKey.$tElementID?>"  id="ohdUPFViewSessionID<?=$tDocKey.$tElementID?>"  value="<?=$tSessionID?>">
<input type="hidden" name="ohdUPFViewtElementID<?=$tDocKey.$tElementID?>"  id="ohdUPFViewtElementID<?=$tDocKey.$tElementID?>"  value="<?=$tElementID?>">
<input type="hidden" name="ohdUPFViewtSeqFrom<?=$tDocKey.$tElementID?>"  id="ohdUPFViewtSeqFrom<?=$tDocKey.$tElementID?>"  value="0">
<input type="hidden" name="ohdUPFViewCallBackFunct<?=$tDocKey.$tElementID?>"  id="ohdUPFViewCallBackFunct<?=$tDocKey.$tElementID?>"  value="<?=$tCallBackFunct?>">
    <div class="">
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
            <label class="xCNLabelFrm"><?=language('common/main/main','tUPFDataTable')?></label>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 text-right xFileInputPosition<?=$tDocKey.$tElementID?>"  >
            <input type="file" name="oflUPFData<?=$tDocKey.$tElementID?>[]" id="oflUPFData<?=$tDocKey.$tElementID?>_0"  class="inputfile xFileUpload<?=$tDocKey.$tElementID?>" data-seqfile="0" onchange="JCNxUPFAddData('<?=$tDocKey.$tElementID?>');"" >
            <label  for="oflUPFData<?=$tDocKey.$tElementID?>_0" id="olbUPFChsForInput<?=$tDocKey.$tElementID?>" class="xCNTextLink" >+ <?=language('common/main/main','tUPFDataTableAdd')?></label>
        </div> 
    </div>

<?php


    if(FCNnHSizeOf($aItems)>5){
        $tClassScrollBar = 'scroller';
    }else{
        $tClassScrollBar = '';
    }
?>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 <?=$tClassScrollBar?>">
<table id="otbUPFTableDnD<?=$tDocKey.$tElementID?>" border='1' BORDERCOLOR='white' width="100%">
<?php 
    if(!empty($aItems)){
        foreach($aItems as $k => $aFile){
            if(FCNUtf8StrLen($aFile['FTFleName'])>30){
                $tFleName = substr($aFile['FTFleName'],0,30).'...';
            }else{
                $tFleName = $aFile['FTFleName'];
            }
            
?>
    <tr style="border-bottom-color: white;" class="xUPFTdHilight xUPFTrPadding5 xTableDnD<?=$tDocKey.$tElementID?>" id="<?=$aFile['FNFleSeq']?>" data-fleseq="<?=$aFile['FNFleSeq']?>" >
    <td width="90%" style="border-right-color: #cccccc3d;">&nbsp;<a href="<?=$aFile['FTFleObj']?>"  title="<?=$aFile['FTFleName']?>" ><u><?=$tFleName?></a></td>
    <td width="10%"> <label class="xUPFDeleteFile" onclick="JCNxUPFDeleteData(<?=$aFile['FNFleSeq']?>,'<?=$tDocKey.$tElementID?>','<?=$aFile['FTFleObj']?>')"><b>x</b></label></td>
    </tr>


<?php
        }
    }else{ ?>
    <div class=" xUPFTrPadding5 xNotFoundDataFile<?=$tDocKey.$tElementID?>" align="center">
        <label class=""><?=language('common/main/main','tUPFDataTableNotFound')?></label>
    </div>
<?php } ?>
</table>
</div>
</div>
<script>

$(document).ready(function() {

    JCNxUPFSetInputUpload('<?=$tDocKey.$tElementID?>');
    // Initialise the table
    $("#otbUPFTableDnD<?=$tDocKey.$tElementID?>").tableDnD({
        onDragClass: "dnd_drag",
        onDragStart: function(table, row) {
            console.log($(row).data('fleseq'));

        },
        onDrop: function(table, row) {
            let nRowIdFrom = $(row).data('fleseq');
            let nRowIdTo = 0;
            $("#otbUPFTableDnD<?=$tDocKey.$tElementID?> tr").each(function(index){
                if(nRowIdFrom==$(this).data('fleseq')){
                    nRowIdTo = (index+1);
                }
           
            });
            console.log(nRowIdFrom+'=>'+nRowIdTo);
            // console.log(row);
            JCNxUFPSortSeqUpdate(nRowIdFrom,nRowIdTo,'<?=$tDocKey.$tElementID?>');
        }
      
    });
});


</script>