<style>
p.ex1 {
  margin-top: 25px;
}
</style>
<script src="<?php echo base_url(); ?>application/modules/common/assets/src/jPageControll.js"></script>

<div class="container ">


    <div class="row ">
<p class="ex1"></p>
        <?php foreach($aDataList AS $nKey => $aValue):?>
                <?php 
                    if(isset($aValue['FavMnuImgPath']) && !empty($aValue['FavMnuImgPath'])){
                        $tImgObj        = $aValue['FavMnuImgPath'];
                        $aImgObj        = explode('application\\modules\\',$tImgObj);
                        $aImgObjName    = explode('\\',$tImgObj);
                        $tImgObjAll     = $aImgObj[0];
                        $tImgName		= end($aImgObjName);
                    }else{
                        $tImgObjAll     = "";
                        $tImgName       = "";
                    }
                    // echo $tImgName;
                ?>
        <div class="col-sm-3 col-md-3 col-lg-3 col-xl-3" >  
            <ul  class="nav get-menu">
               
                <li class="treeview-item xCNMenuItem" > <a  style="color: #000000 !important; text-align: center;"  data-mnrname="<?php  echo $aValue['FavMnuRoute']; ?>" >
              <?php  if ($nKey == $aValue['FavMnuImgPath']) { ?>
                 <img src="<?php echo base_url(); ?>application/modules/favorite/assets/img/<?php  echo $tImgName; ?>">  
               <?php } else { ?>
                <img src="<?php echo base_url(); ?>application/modules/favorite/assets/img/1.png">  
              <?php } ?>
              <p class="text-center"> <label  class="xCNLabelFrm text-center"><?php echo $aValue['FavMnuName'];  ?></label></p> </a>
              <p class="text-center"> <input id="obtFavDel" class="obtFavDel btn xCNBTNDefult xCNBTNDefult1Btn "  type="button" value="<?php echo language('common/main/main','tCMNActionDelete');?>" onclick="JSxFavDel(<?php echo $aValue['FavID'];?>)" /><p class="text-center">
                </li>
            </ul>
        </div>
        
        <?php endforeach;?>
       
    </div>
    
</div> 
