<style>
    #odvInforSettingconfig , #odvInforAutonumber{
        padding-bottom  : 0px;
    }

    #odvSettingConfig{
        margin-bottom : 0px !important;
    }
</style>

<div id="odvSettingConfig" class="panel panel-headline">
	<div class="panel-body" style="padding-top:20px !important;">
		<div class="custom-tabs-line tabs-line-bottom left-aligned">
			<ul class="nav" role="tablist">
                <li class="nav-item  active" id="oliInforGeneralTap">
                    <a class="nav-link flat-buttons active" data-toggle="tab" href="#odvMmtTabMovement" role="tab" aria-expanded="true">
                        <?= language('movement/movement/movement','tMMTTabMovement')?>
                    </a>
                </li>
				<li class="nav-item" id="oliInforSettingConTab">
                    <a class="nav-link flat-buttons" data-toggle="tab" href="#odvMmtTabInventory" role="tab" aria-expanded="false">
                        <?= language('movement/movement/movement','tMMTTabInventory')?>
                    </a>
                </li>
			</ul>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="tab-content">
					<div id="odvMmtTabMovement" class="tab-pane in active" role="tabpanel" aria-expanded="true">
                        <div id="odvContentPageMovement" class="panel panel-headline"></div>
                    </div>
					<div id="odvMmtTabInventory"  class="tab-pane" role="tabpanel" aria-expanded="true">
                        <div id="odvInvContentPage" class="panel panel-headline"></div>
                    </div>
				</div>
			</div>
		</div>
	</div>
</div>