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
                    <a class="nav-link flat-buttons active" data-toggle="tab" href="#odvInforSettingconfig" role="tab" aria-expanded="true">
                        <?=language('settingconfig/settingconfig/settingconfig','tTitleTab1Settingconfig');?> 
                    </a>
                </li>

                <?php if($this->session->userdata("tSesUsrLevel") == "HQ"){ ?>
                    <li class="nav-item" id="oliInforSettingConTab">
                        <a class="nav-link flat-buttons" data-toggle="tab" href="#odvInforAutonumber" role="tab" aria-expanded="false">
                            <?=language('settingconfig/settingconfig/settingconfig', 'tTitleTab2Settingconfig');?>
                        </a>
                    </li>
                <?php } ?> 

                <!-- <li class="nav-item" id="oliSCFApiTab">
                    <a class="nav-link flat-buttons" data-toggle="tab" href="#odvSCFApiCentent" role="tab" aria-expanded="false">
                        <?=language('settingconfig/settingconfig/settingconfig', 'tSCFTitleTab3API');?>
                    </a>
                </li> -->
			</ul>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="tab-content">
					<div id="odvInforSettingconfig" class="tab-pane in active" role="tabpanel" aria-expanded="true"></div>
					<div id="odvInforAutonumber"  class="tab-pane" role="tabpanel" aria-expanded="true"></div>
                    <div id="odvSCFApiCentent"  class="tab-pane" role="tabpanel" aria-expanded="true"></div>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
    $("document").ready(function () {
        //Load view : config
        JSvSettingConfigLoadViewSearch();
        
        //Load view : autonumber
        JSvSettingNumberLoadViewSearch();

        // Create By Napat(Jame) 05/06/2020
        // $('#oliSCFApiTab').click(function(){
        //     JCNxOpenLoading();
        //     JSvSCFLoadViewAPISearch();
        // });

    });
</script>