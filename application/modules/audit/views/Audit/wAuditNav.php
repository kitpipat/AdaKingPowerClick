<div class="xCNMrgNavMenu">
    <div class="row xCNavRow" style="width:inherit;">
        <div class="xCNDepositVMaster">
            <div class="col-xs-12 col-md-6">
                <ol id="oliMenuNav" class="breadcrumb">
                    <li style="cursor:pointer;" onclick="JSxAddfavorit('deposit/0/0')"><img id="oimImgFavicon" style="cursor:pointer; margin-top: -10px;" width="20px;" height="20px;" src="application/modules/common/assets/images/icons/favorit.PNG" class="xCNDisabled xWImgDisable"></li>
                    <li id="oliAuditTitle" class="xCNLinkClick" onclick="JSxAuditDefult()">ตั้งค่าการเชื่อมต่อบัญชี</li>
                    <li id="oliAuditTitleAdd" class="active"><a>เพิ่ม</a></li>
                    <li id="oliAuditTitleEdit" class="active"><a>แก้ไข</a></li>
                </ol>
            </div>
            <div class="col-xs-12 col-md-6 text-right p-r-0">
                <div class="demo-button xCNBtngroup" style="width:100%;">
                    <?php if ($this->session->userdata('tSesUsrLevel') != "HQ") { ?>
                      <button class="btn xCNBTNDefult xCNBTNDefult2Btn" id="obtAUDUpdate" onclick="JSwAuditAdd('edit')" type="button"> แก้ไข</button>
                      <button class="btn xCNBTNDefult xCNBTNDefult2Btn" id="obtAUDback" onclick="JSxAuditDefult();"  type="button">ย้อนกลับ</button>
                      <button class="btn xCNBTNDefult xCNBTNDefult2Btn" id="obtAUDSave" onclick="JSxAudutSave();" type="button">บันทึก</button>
                    <?php } ?>
                    <?php if ($this->session->userdata('tSesUsrLevel')=="HQ") { ?>
                      <button class="xCNBTNPrimeryPlus" id="obtAUDCreate" onclick="JSwAuditAdd('add')" type="button">+</button>
                      <button class="btn xCNBTNDefult xCNBTNDefult2Btn" id="obtAUDback" onclick="JSxAuditDefult();" type="button">ย้อนกลับ</button>
                      <button class="btn xCNBTNDefult xCNBTNDefult2Btn" id="obtAUDSave" onclick="JSxAudutSave();" type="button">บันทึก</button>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
