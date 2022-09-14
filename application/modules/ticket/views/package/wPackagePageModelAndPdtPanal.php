	<div class="main-content">
    <div class="container-fluid">
      <div class="row">
        <div class="nav-tab-pills-image">
         <ul class="nav nav-tabs" role="tablist">
           <li class="nav-item" id="oliTabPkgModel" onclick="FSxCallPagePkgModel(<?=$oPkgDetail[0]->FNPkgID?>);">
            <a class="nav-link flat-buttons active" id="olaTabPkgModel" data-toggle="tab" href="#odvTabModel" role="tab" aria-expanded="false">
             <?= language('ticket/package/package', 'tPkg_Model')?>
           </a>
         </li>
         <li class="nav-item" id="oliTabPkgProduct" onclick="FSxCallPagePkgProduct(<?=$oPkgDetail[0]->FNPkgID?>);">
          <a class="nav-link flat-buttons" id="olaTabPkgProduct" onclick="JSxPKGCheckPkgZone('<?=$oPkgDetail[0]->FNPkgID?>');" data-toggle="tab" href="#odvTabProduct" role="tab" aria-expanded="false">
           <?= language('ticket/package/package', 'tPkg_Product')?>
         </a>
       </li>
     </ul>
     <div class="tab-content">
       <div class="tab-pane active" id="odvTabModel" role="tabpanel" aria-expanded="true" style="overflow: hidden; padding-right: 0; padding-left: 0;" >
        <div id="odvTabPkgModelPanal">
          <!-- Model HTML -->
        </div>
      </div>
      <div class="tab-pane active" id="odvTabProduct" role="tabpanel" aria-expanded="true" style="overflow: hidden; padding: 25px 0px;" >
        <div id="odvTabPkgProductPanal" style="margin-left: -15px; margin-right: -15px;">
         <!-- Product HTML -->
       </div>
     </div>
   </div>
 </div>
</div>
</div>
</div>