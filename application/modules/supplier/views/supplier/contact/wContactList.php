
<style>
     .xWBtnAdd {
        box-shadow: none;
    }
    
</style>
<div class="col-xs-8 col-md-4 col-lg-4">
    <div class="form-group">
        <!-- <label class="xCNLabelFrm"><?php echo language('pos5/card','tSearch')?></label> -->
        <div class="input-group">
            <input type="text" class="form-control" id="oetSearchSplContact" name="oetSearchSplContact" placeholder="<?php echo language('pos5/supplier','tSearch')?>">
            <span class="input-group-btn">
                <button id="oimSearchSplContact" class="btn xCNBtnSearch" type="button">
                    <img  src="<?php echo base_url().'/application/assets/icons/search-24.png'?>">
                </button>
            </span>
        </div>
    </div>
</div>
<div class="col-xs-4 col-md-8 col-lg-8 text-right" style="">
    <a href="javascipt:;" class="btn pull-right xWBtnAdd" id="xWAdvAddHeadRow" onclick="JSvCallPageSplContactAdd()"><i class="fa fa-plus"></i> เพิ่ม</a>
</div>

<section id="ostDataSplContact"></section>

<script>
	$('#oimSearchSplContact').click(function(){
		JCNxOpenLoading();
		JSvSplContactDataTable();
	});
	$('#oetSearchSplContact').keypress(function(event){
		if(event.keyCode == 13){
			JCNxOpenLoading();
			JSvSplContactDataTable();
		}
	});
</script>