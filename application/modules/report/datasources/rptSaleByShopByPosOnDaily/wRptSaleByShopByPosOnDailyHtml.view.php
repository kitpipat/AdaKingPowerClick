<?php
    use \koolreport\widgets\koolphp\Table;
    $nCurrentPage   = $this->params['nCurrentPage'];
    $nAllPage       = $this->params['nAllPage'];
    $aDataTextRef   = $this->params['aDataTextRef'];
    $tLabelTax      = $aDataTextRef['tRptTaxNo'].' : '.$this->params['tBchTaxNo'];
    $tLabeDataPrint = $aDataTextRef['tRptDatePrint'].' : '.date('Y-m-d');
    $tLabeTimePrint = $aDataTextRef['tRptTimePrint'].' : '.date('H:i:s');
    $tBtnPrint      = $aDataTextRef['tRptPrintHtml'];
    $tCompAndBranch = $this->params['tCompName'].' ( '.$this->params['tBchName'].' )';
    $tAddressLine   = "-";
    $aFilterReport  = $this->params['aFilterReport'];
?>
<div id="odvRptSaleShopByDateHtml">
    <div class="container-fluid xCNLayOutRptHtml">
        <div class="xCNHeaderReport">
            <div class="row">
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                    <div class="text-left">
                        <label class="xCNRptLabel"><?php echo $tCompAndBranch; ?></label>
                    </div>
                    <div class="text-left">
                        <label class="xCNRptLabel"><?php echo $tAddressLine; ?></label>
                    </div>
                </div>
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                    <div class="text-center">
                        <label class="xCNRptTitle"><?php echo $aDataTextRef['tTitleReport'];?></label>
                    </div> 
                </div>
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                </div>
            </div>
            <div class="row">
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                </div>
                <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                    <!-- Filter Branch Code -->
                    <?php if(!empty($aFilterReport['tBchCodeFrom']) && !empty($aFilterReport['tBchCodeTo'])):?>
                        <div class="text-left">
                            <label class="xCNRptLabel">
                                <?php echo $aDataTextRef['tRptBchFrom'].' : '.$aFilterReport['tBchNameFrom'].' '.$aDataTextRef['tRptBchTo'].' : '.$aFilterReport['tBchNameTo'];?>
                            </label>
                        </div>
                    <?php endif;?>

                    <!-- Filter Shop Code -->
                    <?php if(!empty($aFilterReport['tShopCodeFrom']) && !empty($aFilterReport['tShopCodeTo'])):?>
                        <div class="text-left">
                            <label class="xCNRptLabel">
                                <?php echo $aDataTextRef['tRptShopFrom'].' : '.$aFilterReport['tShopNameFrom'].' '.$aDataTextRef['tRptShopTo'].' : '.$aFilterReport['tShopNameTo'];?>
                            </label>
                        </div>
                    <?php endif;?>

                    <!-- Filter Doc Date -->
                    <?php if(!empty($aFilterReport['tDocDateFrom']) && !empty($aFilterReport['tDocDateTo'])):?>
                        <div class="text-left">
                            <label class="xCNRptLabel">
                                <?php echo $aDataTextRef['tRptDateFrom'].' : '.$aFilterReport['tDocDateFrom'].' '.$aDataTextRef['tRptDateTo'].' : '.$aFilterReport['tDocDateTo'];?>
                            </label>
                        </div>
                    <?php endif;?>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                    <div class="text-right">
                        <label class="xCNRptLabel"><?php echo $tLabelTax.' '.$tLabeDataPrint.' '.$tLabeTimePrint ?></label>
                    </div>
                </div>
            </div>
        </div>
        <div class="xCNContentReport">
            <div id="odvTableKoolReport" class="table-responsive">
                <?php
$data = array ( 
    array ( "class"=>"1styear","branch"=>"IT","Exam"=>"SEM1","student name"=>"Alex","Bio"=>"Good Boy"),
    array ( "class"=>"2ndyear","branch"=>"Finance","Exam"=>"SEM1","student name"=>"Mark","Bio"=>"Intelligent" ),
    array ( "class"=>"2ndyear", "branch"=>"IT","Exam"=>"SEM1","student name"=>"Shaun","Bio"=>"Football Player" ), 
    array ( "class"=>"1styear","branch"=>"Finance","Exam"=>"SEM2","student name"=>"Mike","Bio"=>"Sport Player" ), 
    array ( "class"=>"1styear","branch"=>"IT","Exam"=>"SEM2","student name"=>"Martin","Bio"=>"Smart"),
    array ( "class"=>"1styear","branch"=>"IT","Exam"=>"SEM1","student name"=>"Philip","Bio"=>"Programmer"  )
);
$data = $this->params['aDataTest'];
echo "<pre>";
print_r($data);
echo "</pre>";
$class_keys=array_unique(array_column($data,"FTShpCode"));  // create array of unique class values
$Exam_keys=array_unique(array_column($data,"FTPosCode"));  // create array of unique Exam values
foreach($class_keys as $class_key){
    $i=0;  // "class" subarray index
    foreach($Exam_keys as $Exam_key){
        $q=array("FTShpCode"=>$class_key,"FTPosCode"=>$Exam_key);  // this array can have 1 or more pairs
        // create an array only of rows where $q's key-value pairs exist
        $qualifying_array=array_filter(
            $data,
            function($val)use($q){  
                if(count(array_intersect_assoc($val,$q))==FCNnHSizeOf($q)){  // total pairs found = total pairs sought
                    return $val;
                }
            },
            ARRAY_FILTER_USE_BOTH
        );
        foreach($qualifying_array as $qa){  // push appropriate values into array
            $grouped2[$class_key][$i]["FTPosCode"]=$qa["FTPosCode"];
            $grouped2[$class_key][$i]["FDXshDocDate"][]=$qa["FDXshDocDate"];
        }
        if(isset($grouped2[$class_key][$i]["FDXshDocDate"])){  // ensure no duplicate values in "branch" subarray
            $grouped2[$class_key][$i]["FDXshDocDate"]=array_unique($grouped2[$class_key][$i]["FDXshDocDate"]);
        }
        ++$i;  // increment the index for each "class" subarray
    }
}
/*echo "<pre>";
print_r($grouped2);
echo "</pre>";*/
?>
                <?php
                $rawData = [
                        ['A', 'Paul', 56],
                        ['A', 'Paul', 6],
                        ['B', 'Mark', 56],
                        ['B', 'Mark', 5],
                    ];

                    // Let's reformat this
                    $out = [];
                    foreach ($rawData as $pair)
                    {
                        $name = $pair[0];
                        if (!isset($out[$name]))
                        {
                            $out[$name] = [];
                        }

                        // Pop the value on the list
                        $out[$name][] = $pair[1];
                    }

                    // Use this to look at your structure
                    #print_r($out);

                    ?>

                    <!-- Here's your rendering section -->
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Num</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($grouped2 as $name => $data): ?>
                            <tr><td colspan="2">Name: <?php echo htmlentities($name) ?></td></tr>

                                <?php foreach ($data as $name => $item): ?>
                                    <tr>
                                        <td><?php echo htmlentities($name); var_dump($item); ?></td>
                                        <td>Edit</td>
                                    </tr>
                                <?php endforeach ?>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                <?php
                    // Data from your database
                    Table::create(array(
                        "dataSource" => $this->dataStore("RptSaleByShopByPosOnDaily"),
                        "grouping"=>array(
                            "year"=>array(
                                "calculate"=>array(
                                    "{sumAmount}"=>array("sum","rtXshGrand")
                                ),
                                "top"=>"<b>Year {year}</b>",
                                "bottom"=>"<td><b>Total of year {year}</b></td><td><b>{sumAmount}</b></td>"
                            ),
                        ),
                        "showFooter"=>true,
                        "cssClass"      => array(
                            "table" => "table table-bordered",
                        ),
                        "columns"       => array(
                            "month"=>array(
                                "label"=>"Month",
                                "footerText"=>"<b>Grand Totals</b>"
                            ),
                            'rtXshDocDate'  => array(
                                'label' => $aDataTextRef['tRptDate'],
                                "type"=>"datetime",
                                //"format"=>"Y-m-d H:i:s",
                                //"displayFormat"=>"d-m-Y D"
                            ),
                            'rtShpCode',
                            'rtPosCode',
                            'rtXshDocNo'  => array(
                                'label' => $aDataTextRef['tRptDocSale']
                            ),
                            'rtXshRefAE'  => array(
                                'label' => $aDataTextRef['tRptDocReturn']
                            ),
                            'rcTotalSalsAfterDis'     => array(
                                'label' => $aDataTextRef['tRptSales'],
                                /*"type"      => "number",
                                "decimals"  => 0,
                                "footer"=>"sum",
                                "footerText"=>"@value",
                                "cssStyle"  => "text-align:right"*/
                            ),
                            'rcTotalChgAndDisBalance'     => array(
                                'label' => $aDataTextRef['tRptDiscount'],
                                /*"type"      => "number",
                                "decimals"  => 0,
                                "footer"=>"sum",
                                "footerText"=>"@value",
                                "cssStyle"  => "text-align:right"*/
                            ),
                            'rtXshGrand'     => array(
                                'label' => $aDataTextRef['tRptGrandSale'],
                                /*"type"      => "number",
                                "decimals"  => 0,
                                "footer"=>"sum",
                                "footerText"=>"@value",
                                "cssStyle"  => "text-align:right"*/
                            )
                        )
                    ));
                ?>
            </div>
        </div>
        <div class="xCNFooterPageRpt">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="text-right">
                    <label class="xCNRptLabel"><?php echo $nCurrentPage.' / '.$nAllPage; ?></label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>









































































