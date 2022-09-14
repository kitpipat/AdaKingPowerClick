<div class="row">
	<div class="xCNBCMenu xWHeaderMenu">
		<div class="row">
			<div class="col-md-8">
				<h5>
					<a onclick="JSxCallPage('<?php echo base_url('user')?>')">ข้อมูลผู้ใช้ระบบ</a> / <?= $oShow[0]->FTUsrName ?>
				</h5>
			</div>
		</div>
	</div>
		<div class="row">
			<div class="col-md-4 col-sm-4 col-xs-12">					
				<div class="upload-img" id="oImgUpload" style="margin-bottom: 10px;">
					<?php if ($oShow[0]->FTImgObj != ""):  ?>
						<img src="<?=base_url()?><?php echo $oShow[0]->FTImgObj;?>" style="width: 100%;" id="oImageThumbnail" class="xWimageLoc">
					<?php else : ?>
						<img src="<?php echo base_url('application/assets/images/1,1.png');?>" style="width: 100%;" id="oImageThumbnail">
					<?php endif; ?>
				</div>				
			</div>
			<div class="col-md-8 col-sm-4 col-xs-12">
				<div class="form-group">
					ชื่อ : <?= $oShow[0]->FTUsrName ?>
				</div>
				<div class="form-group">
					อีเมล : <?= $oShow[0]->FTUsrEmail ?>
				</div>	
				<div class="form-group">
					วันหมดอายุ : <?= date("Y-m-d", strtotime($oShow[0]->FDUsrDateExp)); ?>
				</div>
				<div class="form-group">	
					กลุ่มผู้ใช้ : <?= $oShow[0]->FTGahName; ?>	
				</div>
				<div class="form-group">
					เบอร์โทรศัพท์ : <?= $oShow[0]->FTUsrTel ?>
				</div>				
				<div class="form-group">
					บ้านเลขที่ : <?= $oShow[0]->FTUsrAddrNo ?>
				</div>
				<div class="form-group">
					ถนน : <?= $oShow[0]->FTUsrRoad ?>
				</div>
				<div class="form-group">
					หมู่บ้าน/อาคาร : <?= $oShow[0]->FTUsrVillage ?>
				</div>
				<div class="form-group">
					ซอย : <?= $oShow[0]->FTUsrSoi ?>
				</div>			
				<div class="form-group">
					ตำบล/แขวง : <?= $oShow[0]->FTUsrSubDist ?>
				</div>
				<div class="form-group">	
					สาขา : <?= $oShow[0]->FTPmoName ?>			
				</div>
				<div class="form-group">	
					จังหวัด : <?= $oShow[0]->FTPvnName ?>				
				</div>
				<div class="form-group">
					อำเภอ/เขต : <?= $oShow[0]->FTDstName ?>				
				</div>				
				<div class="form-group">
					รหัสไปรษณีย์ : <?= $oShow[0]->FTUsrPostCode ?>
				</div>				
			</div>
		</div>
</div>