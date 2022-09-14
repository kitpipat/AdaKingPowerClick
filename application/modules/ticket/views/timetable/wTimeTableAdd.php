<style>
   .xWFromAddTimeTable div{
      margin-bottom: 15px;
   }
</style>
<div class="page-header xWpage-header"> 
	<div class="row">
		<div class="col-md-8">
			<span onclick="JSxCallPage('<?php echo base_url();?>/EticketTimeTable')"><?= language('ticket/timetable/timetable', 'tTimeTableInformation') ?> /</span> <?= language('ticket/timetable/timetable', 'tAddTimeTable') ?>
		</div>
	</div>
</div> 
<div class="row">
     <div class="col-md-6 xWFromAddTimeTable" style="padding-left:0px;">
		     <div class="col-md-12">
		          <input type="text" placeholder="<?= language('ticket/timetable/timetable', 'tNameTimeTable') ?>" class="form-control" id="oetTimeTableName">
		     </div>
		     
		     <div class="col-md-12">
		          <textarea rows="" cols="" placeholder="<?= language('ticket/zone/zone', 'tRemarks') ?>" class="form-control" id="otaTimeTableRemark"></textarea>
		     </div>
		     
		     <div class="col-md-12">
		          <input type="checkbox" id="ocbStaTimeTableActive"> <?= language('ticket/product/product', 'tOpening') ?>
		          <input type="hidden" value="<?php echo base_url();?>" id="ohdBaseurl">
		     </div>
		     
		     <div class="col-md-12 text-right">
		          <button class="btn btn-default"><?= language('common/main/main', 'tBack') ?></button>
		          <button class="btn btn-default" onclick="JSxTTBSaveAdd()" id="obtSaveTimeTable"><?= language('ticket/user/user', 'tSave') ?></button>
		     </div>
     </div>
</div>