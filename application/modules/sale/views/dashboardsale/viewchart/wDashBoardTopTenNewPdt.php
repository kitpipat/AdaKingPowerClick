<style type="text/css">
    .xWDSHSALImgPDT{
        height: 80px;
        width: 140px;
    }

    .xCNHighLightTop10:hover p{
        font-weight: bold;
        cursor: context-menu;
    }

    .xCNImageDashborad{
        width: 100%;
        height: 80px;
        background-position: center;
        background-size: cover;
        display: block;
        margin: 0px auto;
    }

    .xCNImageDashborad img{
        height: 80px;
    }
</style>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 p-t-10 p-l-0 p-r-0">
    <div class="table-responsive">
        <table id="otbDSHSALTopTenNewPdt" class="table">
            <tbody>
                <?php if(isset($aDataFiles) && !empty($aDataFiles)):?>
                    <?php foreach($aDataFiles AS $nKey => $aValueData):?>
                        <tr>
                            <td class="text-center">
                                <div>
                                    <div style="display: inline-block; float: left;">
                                        <?php
                                            // if(isset($aValueData['FTImgObj']) && !empty($aValueData['FTImgObj'])){

                                            //     $tImgObj = substr($aValueData['FTImgObj'],0,1);
                                            //     $tStyle  = "";
                                            //     // ตรวจสอบ Code Color Saharat(Golf)
                                            //     if($tImgObj != '#'){
                                            //         $aValueImgExplode = explode('/modules/',$aValueData['FTImgObj']);
                                            //         $tFullPatch = './application/modules/'.$aValueImgExplode[1];
                                            //         if (file_exists($tFullPatch)){
                                            //             $tPatchImgPdt = base_url().'application/modules/'.$aValueImgExplode[1];
                                            //         }else{
                                            //             $tPatchImgPdt = base_url().'application/modules/common/assets/images/Noimage.png';
                                            //         }
    
                                            //     }else{  
                                            //         $tPatchImgPdt       = "0";
                                            //         $tStyleName         = $aValueData['FTImgObj'];
                                            //     }
                                            // }else{
                                            //     $tPatchImgPdt   = base_url().'application/modules/common/assets/images/200x200.png';
                                            // }

                                            $tImgObjPath = $aValueData['FTImgObj'];
                                        ?>
            
                                        <div class="xWDSHSALImgPDT">
                                            <div class="xCNImageDashborad"><?=FCNtHGetImagePageList(@$tImgObjPath, '60%')?></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-8 xCNHighLightTop10" >
                                        <p style="margin-top: 5px; text-align: left; font-size: 20px !important;"><?=$nKey  + 1 ?>. <?php echo @$aValueData['FTPdtName'];?></p>
                                        <p style="text-align: left; font-size: 18px !important;">รหัสสินค้า : <?=@$aValueData['FTPdtCode'] ?> - วันที่เพิ่มข้อมูล : <?=@$aValueData['FDCreateOn'] ?></p>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach;?>
                <?php else:?>
                    <tr>
                        <td class="text-center">
                            <?php echo @$aTextLang['tDSHSALNotFoundTopTenNewPdt'];?>
                        </td>
                    </tr>
                <?php endif;?>
            </tbody>
        </table>
    </div>
</div>