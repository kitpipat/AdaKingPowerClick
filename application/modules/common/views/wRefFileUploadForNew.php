<style>
.xUPFDeleteFile{
    color:red;
    cursor:pointer;
}
.xUPFTdHilight{
    background-color: #7795d6;
    color:#ffffff;

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

        <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 text-left xFileInputPosition<?=$tDocKey.$tElementID?>"  >
            <input type="file" name="oflUPFData<?=$tDocKey.$tElementID?>[]" id="oflUPFData<?=$tDocKey.$tElementID?>_0"  class="inputfile xFileUpload<?=$tDocKey.$tElementID?>" data-seqfile="0" onchange="JCNxUPFAddDataForNew('<?=$tDocKey.$tElementID?>');"" >
            <label  for="oflUPFData<?=$tDocKey.$tElementID?>_0" id="olbUPFChsForInput<?=$tDocKey.$tElementID?>" class="xCNTextLink btn btn-default" >+ <?=language('common/main/main','tUPFDataTableAdd')?></label>
        </div> 
    </div>



    <div id="otbUPFTableDnD<?=$tDocKey.$tElementID?>" border='1' BORDERCOLOR='white' width="100%" style="padding-top: 8px;">
    <?php 
        if(!empty($aItems)){
            foreach($aItems as $k => $aFile){
                if(FCNUtf8StrLen($aFile['FTFleName'])>30){
                    $tFleName = substr($aFile['FTFleName'],0,30).'...';
                }else{
                    $tFleName = $aFile['FTFleName'];
                }
                
    ?>
    <span  class="label label-info m-r-5 xTableDnD<?=$tDocKey.$tElementID?>" id="<?=$aFile['FNFleSeq']?>" data-fleseq="<?=$aFile['FNFleSeq']?>" >
    <label class="xUPFDeleteFile" onclick="JCNxUPFDeleteData(<?=$aFile['FNFleSeq']?>,'<?=$tDocKey.$tElementID?>','<?=$aFile['FTFleObj']?>')"><b>x</b></label>
     &nbsp;&nbsp;<a href="<?=$aFile['FTFleObj']?>"  title="<?=$aFile['FTFleName']?>" ><u><?=$tFleName?></a>
    </span>


<?php
        }
    }else{ ?>
 
<?php } ?>
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