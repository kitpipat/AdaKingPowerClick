<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" id="">
            <?php if(!empty($aDocType['raItems'])){
                            foreach($aDocType['raItems'] as $key => $aVale){
                                if(empty($aDataNumByNotCode[$aVale['FTNotCode']])){
                                        continue;
                                }

                                ?>
                    <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3 btn btn-default" align="center">
                    <h3 id=""><?= language('checkdocument/checkdocument','tMntMassageCheck')?></h3>
                        <h2 class='xCNImageInformationBuy xCNImageIconFisrt' style="width:50px;" ><?=$aDataNumByNotCode[$aVale['FTNotCode']]?></h2>
                        <h3 id=""><?=$aVale['FTNotTypeName']?></h3>

                    </div>
            <?php }} ?>
</div>