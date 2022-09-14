<script>
	$(document).ready(function () {
		$(".xWAddCustomerType").validate({
			rules: {
				oetFTCtyName: "required"
			},
			messages: {
				oetFTCtyName: "",
			},
			errorClass: "alert-validate",
			validClass: "",
			highlight: function (element, errorClass, validClass) {
				$(element).parent('.validate-input').addClass(errorClass).removeClass(validClass);
				$(element).parent().parent('.validate-input').addClass(errorClass).removeClass(validClass);       
			},
			unhighlight: function (element, errorClass, validClass) {
				$(element).parent('.validate-input').removeClass(errorClass).addClass(validClass);
				$(element).parent().parent('.validate-input').removeClass(errorClass).addClass(validClass);
			},
			submitHandler: function (form) {
				$('button[type=submit]').attr('disabled', true);
                                $('.xCNOverlay').show();
				$.ajax({
					type: "POST",
					url: "<?php echo base_url();?>EticketCustomer/AddCategoryAjax",
					data: $(".xWAddCustomerType").serialize(),
					cache: false,
					success: function (msg) {			
						var nDataId = $('.xWBtnSaveActive').data('id');
						if (nDataId == '1') {
							JSxCallPage('<?= base_url()?>EticketCustomer/EditCategory/'+msg);
						} else if(nDataId == '2') {
							JSxCallPage('<?= base_url()?>EticketCustomer/AddCategory');
						} else if(nDataId == '3') {
							JSxCallPage('<?php echo base_url('EticketCustomer/category')?>');
						}
                                                $('.xCNOverlay').hide();
					},
					error: function (data) {
						console.log(data);
                                                $('.xCNOverlay').hide();
					}
				});
				return false;
			}
		});   
		$('[title]').tooltip();
	});
</script>
<div class="main-menu">
	<form action="" method="post" autocorrect="off" autocapitalize="off" autocomplete="off" class="xWAddCustomerType">
        <div class="xCNMrgNavMenu">
            <div class="row xCNavRow" style="width:inherit;">
                <div class="xCNBchVMaster">
                    <div class="col-xs-8 col-md-8">
                        <ol id="oliMenuNav" class="breadcrumb">
                            <li id="oliBCHTitle" class="xCNLinkClick" onclick="JSxCallPage('<?php echo base_url('EticketCustomer/category')?>')"><?= language('ticket/customer/customer', 'tCustomerCategoryInformation') ?></li> 
                            <li  class="xCNLinkClick"><?= language('ticket/customer/customer', 'tAddCustomerCategory') ?></li>
                            </ol>       
                            </div>
                            <div class="col-xs-12 col-md-4 text-right p-r-0">
                            <div class="demo-button xCNBtngroup">
							<button type="button" onclick="JSxCallPage('<?php echo base_url('EticketCustomer/category')?>')" class="btn btn-default xCNBTNDefult"><?= language('common/main/main', 'tBack') ?></button>
                            <div class="btn-group">
                            <button class="btn btn-default xWBtnGrpSaveLeft" type="submit"><?= language('ticket/user/user', 'tSave') ?></button>
                            <button type="button" class="btn btn-default xWBtnGrpSaveRight dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="caret"></span>
                            <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <ul class="dropdown-menu xWDrpDwnMenuMargLft">
                            <li class="xWolibtnsave1 xWBtnSaveActive" data-id="1" onclick="JSvChangeBtnSaveAction(1)"><a href="#"><?= language('common/main/main', 'tCMNSaveAndView') ?></a></li>
                            <li class="xWolibtnsave2" data-id="2" onclick="JSvChangeBtnSaveAction(2)"><a href="#"><?= language('common/main/main', 'tCMNSaveAndNew') ?></a></li>
                            <li class="xWolibtnsave3" data-id="3" onclick="JSvChangeBtnSaveAction(3)"><a href="#"><?= language('common/main/main', 'tCMNSaveAndBack') ?></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>   
<div class="main-content">
    <div class="panel panel-headline">
        <div class="panel-heading"> 
            <div class="row">
                <div class="col-xs-12 col-md-5 col-lg-5">
					
                        <div class="form-group">
                            <label class="xCNLabelFrm"><span style="color:red">*</span><?= language('ticket/customer/customer', 'tCustomerCategoryName') ?></label>
							    <input class="form-control" type="text" name="oetFTCtyName" id="oetFTCtyName" data-validate="<?= language('ticket/customer/customer', 'tCustomerCategoryName') ?>">
                                </div>
                         
                        </div> 
                    </div> 
                </div> 
            </div> 
        </div>  
    </form>    
</div>
