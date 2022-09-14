
<style>
     .xWBtnAdd {
        box-shadow: none;
    }
    
</style>
<div class="col-xs-8 col-md-4 col-lg-4">
    <div class="form-group">
        <!-- <label class="xCNLabelFrm"><?php echo language('pos5/card','tSearch')?></label> -->
        <div class="input-group">
            <input type="text" class="form-control" id="oetSearchSplAddress" name="oetSearchSplAddress" placeholder="<?php echo language('pos5/supplier','tSearch')?>">
            <span class="input-group-btn">
                <button id="oimSearchSplAddress" class="btn xCNBtnSearch" type="button">
                    <img  src="<?php echo base_url().'/application/assets/icons/search-24.png'?>">
                </button>
            </span>
        </div>
    </div>
</div>
<div class="col-xs-4 col-md-8 col-lg-8 text-right" style="">
    <a href="javascipt:;" class="btn pull-right xWBtnAdd" id="xWAdvAddHeadRow" onclick="JSvCallPageSplAddressAdd()"><i class="fa fa-plus"></i> เพิ่ม</a>
</div>

<section id="ostDataSplAddress"></section>

<script>
	$('#oimSearchSplAddress').click(function(){
		JCNxOpenLoading();
		JSvSplAddressDataTable();
	});
	$('#oetSearchSplAddress').keypress(function(event){
		if(event.keyCode == 13){
			JCNxOpenLoading();
			JSvSplAddressDataTable();
		}
	});
</script>