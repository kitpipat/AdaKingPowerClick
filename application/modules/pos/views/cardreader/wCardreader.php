<input id="oetCrdStaBrowse" type="hidden" value="<?=$nCrdBrowseType?>">
<input id="oetCrdCallBackOption" type="hidden" value="<?=$tCrdBrowseOption?>">
<div class="modal-header xCNModalHead">
    <div class="row">
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
            <a onclick="JCNxBrowseData('<?php echo $tCrdBrowseOption?>')" class="xWBtnPrevious xCNIconBack" style="float:left;">
                <i class="fa fa-arrow-left xCNIcon"></i>	
            </a>
            <ol id="oliBchNavBrowse" class="breadcrumb xCNMenuModalBrowse">
                <li class="xWBtnPrevious" onclick="JCNxBrowseData('<?php echo $tCrdBrowseOption?>')"><a><?php echo language('common/main/main','tShowData');?> : <?= language('pos/salemachine/salemachine','tPOSModelEDC')?></a></li>
                <li class="active"><a><?= language('pos/salemachine/salemachine','tPOSModelEDCAdd')?></a></li>
            </ol>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
        <div id="odvBchBtnGroup" class="demo-button xCNBtngroup" style="width:100%;">
                <button type="button" class="btn xCNBTNPrimery" onclick="$('#obtSubmitCardReader').click()"><?php echo language('common/main/main', 'tSave')?></button>
            </div>
        </div>
    </div>
</div>
<div id="odvModalBodyBrowse" class="modal-body xCNModalBodyAdd"></div>

<script>
$('document').ready(function() {
    var nCrdBrowseType = $('#oetCrdStaBrowse').val();
    if (nCrdBrowseType == 1) {
        JSvCallPageCardReaderAdd();
    } 
});
//โหลดหน้า บันทึกข้อมูล
function JSvCallPageCardReaderAdd() {
    var nCrdBrowseType = $('#oetCrdStaBrowse').val();
    $.ajax({
            type: "GET",
            url: "cardreaderPageAdd",
            data: {},
            cache: false,
            timeout: 5000,
            success: function(tResult) {
                if (nCrdBrowseType == 1) {
                    $('#odvModalBodyBrowse').html(tResult);
                    $('#odvModalBodyBrowse .panel-body').css('padding-top','0');
                } 
            },
            error: function(data) {
                console.log(data);
            }
        });
    }
</script>