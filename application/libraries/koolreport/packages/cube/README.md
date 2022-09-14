#Introduction

The Cube helps to process your data into cross-tab table. For example, we have this data.

|Country   |iPhone    |Sale     |
|----------|----------|---------|
|U.S       |iPhone    |48,000   |
|Canada    |Samsung   |36,000   |
|U.S       |Samsung   |44,000   |
|Canada    |iPhone    |12,000   |

The cube will turn above table data into this:

|Country   |iPhone    |Samsung  |Total    |
|----------|----------|---------|---------|
|U.S       |48,000    |44,000   |92,000   |
|Canada    |12,000    |36,000   |48,000   |

The summarized data then can be used to draw charts and graphs.

#Installation

1. Download and unzip the zipped file.
2. Copy the folder `cube` into `koolreport/packages` folder
3. Reference to the Cube process by the classname`\koolreport\cube\processes\Cube`

#Usage

The Cube full classname is `\koolreport\cube\processes\Cube`. In the settings for Cube, you need to specify which data will be column and row, which data will be measure. In below code, we turn `country` data into *row*, `product` to *column* and we measure the *sale*. 

```
<?php
use \koolreport\cube\processses\Cube;
class MyReport extends \koolreport\KoolReport
{
    ...
    public function setup()
    {
        $this->src('sales')
        ->query("SELECT country,product,sale from tblPurchases")
        ->pipe(new Cube(array(
            "row"=>"country",
            "column"=>"product",
            "sum"=>"sale"
        )))
        ->pipe($this->dataStore('sales'));
    }
}
```

If you only specify `column`, for example:

```
...
->pipe(new Cube(array(
    "column"=>"product",
    "sum"=>"sale"
)))
...
```

the resulted table will be like this:

|iPhone    |Samsung   |Total    |
|----------|----------|---------|
|60,000    |80,000    |140,000  |

If you only specify `row`, for example:

```
...
->pipe(new Cube(array(
    "row"=>"country",
    "sum"=>"sale"
)))
...
```

the result table will be like this:

|Country   |Total     |
|----------|----------|
|U.S       |92,000    |
|Canada    |48,000    |

## Support

Please use our forum if you need support, by this way other people can benefit as well. If the support request need privacy, you may send email to us at __support@koolreport.com__.