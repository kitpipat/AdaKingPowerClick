<style>
    #odvInforSettingconfig , #odvInforAutonumber{
        padding-bottom  : 0px;
    }

    #odvSettingConfig{
        margin-bottom : 0px !important;
    }
</style>


<div id="odvSettingConfig" class="panel panel-headline">
	<div class="panel-body">
		<!-- <div class="custom-tabs-line tabs-line-bottom left-aligned">
			<ul class="nav" role="tablist">
                 <li class="nav-item  active" id="oliInforGeneralTap">
                    <a class="nav-link flat-buttons active" data-toggle="tab" href="#odvInforSettingconfig" role="tab" aria-expanded="true">
                        <?php //echo language('company/compsettingconnect/compsettingconnect','tCompSetConnectAPITitle');?> 
                    </a>
                </li>
			</ul>
		</div> -->
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="tab-content">
					<div id="odvInforSettingconfig" role="tabpanel" aria-expanded="true"></div>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
    $("document").ready(function () {
        //Load view : config
        JSvCompSettingConfigLoadViewSearch();

    });
</script>