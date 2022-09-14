<script>
$('#oetTimeStart').timepicker({ 
       showMeridian: false, 
       showInputs: false 
 });
$('#oetTimeEnd').timepicker({ 
       showMeridian: false, 
       showInputs: false 
});

</script>
<div class="xCNBCMenu xWHeaderMenu"> 
	<div class="row">
		<div class="col-md-8">
			<span onclick="JSxCallPage('<?php echo base_url();?>/EticketTimeTable')">ตารางเวลา /</span> 
			       <?php if($aTimeTableHD->FTTmhName != ''){echo $aTimeTableHD->FTTmhName;}else{ echo 'ไม่ระบุ';}?> / รอบแสดง
		</div>
	</div>
</div> 
<div class="row">
     <div class="col-md-2">
           <div class="bootstrap-timepicker" style="float: left;">
                <input type="text" class="form-control" placeholder="เวลาเริ่มต้น" id="oetTimeStart">
           </div>
     </div>
     <div class="col-md-2">
          <div class="bootstrap-timepicker" style="float: left;">
               <input type="text" class="form-control" placeholder="ถึงเวลา" id="oetTimeEnd">
          </div>
     </div>
     <div class="col-md-2">
            <input type="hidden" class="form-control"  id="oetTimeHdID" value="<?php echo $aTimeTableHD->FNTmhID;?>">
            <input type="hidden" id="tBaseURL" value="<?php echo base_url();?>">
            <button class="btn btn-outline-primary" onclick="JSxTTBSaveTimeDT()" type="button" id="obtAddTTBDT">+เพิ่ม</button>
     </div>
     <div class="col-md-12"><hr></div>
     <div class="col-md-12">
          <table class="table table-hover">
                <tr>
                   <th style="width:20px" class="text-center">ลำดับ</th>
                   <th>ชื่อรอบ</th>
                   <th>เวลาเริ่ม</th>
                   <th>ถึงเวลา</th>
                   <th style="width:20px" class="text-center">ลบ</th>
                </tr>
                <?php if(is_array($oShowTime)){?>
                <?php $i = 1;
                      foreach ($oShowTime as $aShowtime){
																															$nTTmdID = $aShowtime->FNTmdID;
                ?>
                <tr>
                    <td class="text-center"><?php echo $i;?></td>
                    <td>รอบ <?php echo $aShowtime->FTTmdName?></td>
                    <td><?php echo $aShowtime->FTTmdStartTime?></td>
                    <td><?php echo $aShowtime->FTTmdEndTime?></td>
                    <td class="text-center" onclick="JCNxTDTConfirmdel('<?php echo $nTTmdID;?>')">ลบ</td>
                </tr>
                <?php ++$i;} ?>
                <?php }else{ ?>
                <tr><td colspan="5">!Empty</td></tr>
                <?php }?>
          </table>
     </div>
</div>