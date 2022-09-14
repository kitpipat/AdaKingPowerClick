<input id="ohdCCSBrowse"         type="hidden" value="<?=$nBrowseType?>">
<input id="ohdCCSCallBackOption" type="hidden" value="<?=$tBrowseOption?>">

<div id="odvCCSMainMenu" class="main-menu">
    <div class="xCNMrgNavMenu">
        <div class="row xCNavRow" style="width:inherit;">
            <div class="xCNCCSVMaster">
                <div class="col-xs-12 col-md-8">
                    <ol id="oliMenuNav" class="breadcrumb">	<!-- เปลี่ยน -->
                        <?php FCNxHADDfavorite('ConnectionSetting/0/0');?>
                        <li id="oliCSSTitle" onclick="JSxCallGetConGeneral()" style="cursor:pointer"><?php echo language('interface/connectionsetting/connectionsetting', 'tCCSTitle') ?></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="main-content">
	<div class="panel panel-headline">
		<div class="panel-body">
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div class="custom-tabs-line tabs-line-bottom left-aligned">
						<ul class="nav" role="tablist">
							<!-- ข้อมูลทั่วไป -->
							<li id="oliGeneralInformation" class="xWMenu active" data-menutype="GeneralInformation" onclick="JSxCallGetConGeneral()">
								<a role="tab" data-toggle="tab" data-target="#odvGeneralInformation" aria-expanded="true"><?php echo language('interface/connectionsetting/connectionsetting','tTABGeneralInformation')?></a>
							</li>
							<!-- คลัง -->
							<li id="oliWahouse" class="xWMenu xWSubTab" data-menutype="Wahouse" onclick="JSxCallGetContent();">
								<a role="tab" data-toggle="tab" data-target="#odvWahouse" aria-expanded="true"><?php echo language('interface/connectionsetting/connectionsetting','tTABWahouse')?></a>
							</li>
							<!-- กำหนดลูกค้าสาขา -->
							<li id="oliCustomer" class="xWMenu xWSubTab" data-menutype="Customer" onclick="JSxCallGetCustomer();">
								<a role="tab" data-toggle="tab" data-target="#odvCustomer" aria-expanded="true"><?php echo language('interface/connectionsetting/connectionsetting','tTABCustomer')?></a>
							</li>
						</ul>
					</div>
				</div>
			</div>

			<div id="odvCCSRowContentMenu" class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<!-- Tab Content Detail -->
					<div class="tab-content">
						<div id="odvGeneralInformation" class="tab-pane fade active in"></div>
						<div id="odvWahouse" class="tab-pane fade"></div>
            			<div id="odvCustomer" class="tab-pane fade"></div>
					</div>
				</div>
			</div>

		</div>
	</div>
</div>

<script src="<?php echo base_url('application/modules/interface/assets/src/connectionsetting/jConnectionSetting.js')?>"></script>
