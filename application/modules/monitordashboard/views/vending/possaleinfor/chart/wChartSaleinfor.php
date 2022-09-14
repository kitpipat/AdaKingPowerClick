<link rel="stylesheet" href="<?php echo base_url(); ?>application/modules/monitordashboard/assets/css/globalcss/adaMDGeneral.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>application/modules/monitordashboard/assets/css/localcss/adaPossaleInfor.css">
<div class="container-fluid">
    <div class="row">
        <div class="col-xs-12 xCNHeight-400px">
           <?php
                echo $tHtmlViewBarChart;
           ?>
        </div>
        <div class="col-xs-12 xCNHeight-400px">
            <?php
                echo $tHtmlViewCircleChart;
           ?>
        </div>
    </div>
</div>