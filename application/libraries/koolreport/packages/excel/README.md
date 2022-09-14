# Introduction

`Excel` package helps you to work with Excel. It can help to pull data from Excel file as well as push data to Excel file. Underline of `ExcelDataSource` is the open-source library called `phpoffice/PHPExcel` which helps us to read various Excel version.

# Installation

1. Unzip folder
2. Copy the `excel` folder to `koolreport\packages`

# Documentation

## Get data from Excel

`ExcelDataSource` help you to get data from your current Microsoft Excel file.

### Settings

|Name|type|default|description|
|----|---|---|---|
|class|string||	Must set to '\koolreport\datasources\ExcelDataSource'|
|filePath|string||The full file path to your Excel file.|
|charset|string|`"utf8"`|Charset of your Excel file|
|firstRowData|boolean|`false`|Whether the first row is data. Normally the first row contain the field name so default value of this property is false.|
|sheetName|string|null|Set a sheet name to load instead of all sheets.|
|sheetIndex|number|null|Set a sheet index to load instead of all sheets. If both sheetName and sheetIndex are set, priority is given to sheetName first. |

### Example

```
class MyReport extends \koolreport\KoolReport
{
    public function settings()
    {
        return array(
            "dataSources"=>array(
                "sale_source"=>array(
                    "class"=>"\koolreport\excel\ExcelDataSource",
                    "filePath"=>"../data/my_file.xlsx",
                    "charset"=>"utf8",
                    "firstRowData"=>false,//Set true if first row is data and not the header,
                    "sheetName"=>"sheet1",
                    "sheetIndex"=>0,
                )
            )
        );
    }

    public function setup()
    {
        $this->src('sale_source')
        ->pipe(...)
    }
}

```

## Export to Excel

To use the export feature in report, you need to register the `ExcelExportable` in your report like below code

```
class MyReport extends \koolreport\KoolReport
{
    use \koolreport\excel\ExcelExportable;


}
```

Then now you can export your report to excel like this:

```
<?php
$report = new MyReport;
$report->run()->exportToExcel()->toBrowser("myreport.xlsx");
```

If there is a pivot data store in your report, in order to export to excel that data store you need to have the package Pivot.

### General export options

When exporting to excel, you could set a number of property for the excel file.

```
<?php
$report = new MyReport;
$report->run()->exportToExcel(array(
  "properties" => array(
    "creator" => "",
    "title" => "",
    "description" => "",1
    "subject" => "",
    "keywords" => "",
    "category" => "",
  )
))->toBrowser("myreport.xlsx");
```

### Pivot export options

Beside general options, when exporting a pivot data store you could set several options similar to when viewing a pivot table widget.

```
<?php
$report = new MyReport;
$report->run()->exportToExcel(array(
  "dataStores" => array(
    'salesReport' => array(
      'rowDimension' => 'column',
      'columnDimension' => 'row',
      "measures"=>array(
        "dollar_sales - sum", 
      )
    )
  )
))->toBrowser("myreport.xlsx");
```

## Support

Please use our forum if you need support, by this way other people can benefit as well. If the support request need privacy, you may send email to us at __support@koolreport.com__.
