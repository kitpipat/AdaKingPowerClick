<!-- Modal Crop -->
<div id="odvModalCrop<?php echo $tMasterName?>">
</div>
<!-- END Modal Croup -->
<!-- MODAL TEMPIMG -->
<div class="modal fade bd-example-modal-lg xCNModalTempImgNew" id="odlModalTempImg<?php echo $tMasterName?>">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <div class="row">
                    <div class="col-md-8">
                        <label class="xCNTextModalHeard"><?php echo language('common/main/main','tGalleryHead')?></label>
                    </div>
                    <div class="col-md-2">
                        <select class="form-control" id="ocmTypePicture" name="ocmTypePicture">
                            <option value="16/9"><?php echo language('common/main/main','tGallerySize')?> 16:9</option>
                            <option value="3/4"><?php echo language('common/main/main','tGallerySize')?> 3:4</option>
                        </select>
                    </div>
                    <div class="col-md-2 text-right">
                        <input style="display:none;" type="file" id="oetInputUplode<?php echo $tMasterName?>" onchange="JSxImageUplodeResizeNEW(this,'','<?php echo $tMasterName?>',<?=$nBrowseType?>)" accept="image/*">
                        <button onclick="$('#oetInputUplode<?php echo $tMasterName?>').click()" class="btn xCNBTNPrimery xCNBTNPrimery1Btn" type="button"><?php echo language('common/main/main','tGalleryUploadPicture')?></button>
                        <input type="hidden" id="ohdRetionCropper" value="16/9">
                    </div>
                </div>
            </div>
            <div class="modal-body" style="overflow-x:auto;padding:0px">
                <div class="xCNLoddingModal">
                    <img src="<?php echo base_url(); ?>application/modules/common/assets/images/ada.loading.gif" class="xWImgLoadingModal">
                </div>
                <div class="xCNImgContraner1">
                    <div id="odvImgTempData<?php echo $tMasterName?>" class="wf-container1">
                            
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="row">
                    <div id="odvImgTotalPage<?php echo $tMasterName?>" class="col-md-6">
                    </div>
                    <div id="odvImgPagenation<?php echo $tMasterName?>" class="col-md-6">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END MODAL TEMPIMG -->

<script>

    $('#ohdRetionCropper').val('16/9');
    $('#ocmTypePicture option:first').prop('selected',true);

    $('#ocmTypePicture').change(function(e) {
        var tValuePictrue = $(this).val();
        $('#ohdRetionCropper').val(tValuePictrue);
    });
</script>