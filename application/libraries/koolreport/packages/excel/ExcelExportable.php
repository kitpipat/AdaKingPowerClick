<?php
/**
 * This file contains class to export data to Microsoft Excel
 *
 * @author KoolPHP Inc (support@koolphp.net)
 * @link https://www.koolphp.net
 * @copyright KoolPHP Inc
 * @license https://www.koolreport.com/license#mit-license
 */


namespace koolreport\excel;
use \koolreport\core\Utility;

require_once 'vendor/autoload.php';

trait ExcelExportable
{
    protected $excelExport;
    protected $pivotExcelExport;

    protected function getDataStoreType($dataStore) {
        $meta = $dataStore->meta()['columns'];
        $dataStore->popStart();
        $row = $dataStore->pop();
        $columns = array_keys($row);
        foreach ($columns as $c)
        if ($meta[$c]['type'] === 'dimension')
            return 'pivot';
        return 'table';
    }

    protected function getExportObject($type) {
        if ($type === 'pivot') {
            if (! isset($this->pivotExcelExport))
                $this->pivotExcelExport = new \koolreport\pivot\PivotExcelExport();
            return $this->pivotExcelExport;
        }
        else {
            if (! isset($this->excelExport))
                $this->excelExport = new ExcelExport();
            return $this->excelExport;
        }
    }

    public function exportToExcel($params=array())
    {
        $properties = Utility::get($params,"properties",array());
        
        $excel = new \PHPExcel();
        $excel->getProperties()
        ->setCreator(Utility::get($properties,"creator","KoolReport"))
        ->setTitle(Utility::get($properties,"title",""))
        ->setDescription(Utility::get($properties,"description",""))
        ->setSubject(Utility::get($properties,"subject",""))
        ->setKeywords(Utility::get($properties,"keywords",""))
        ->setCategory(Utility::get($properties,"category",""));
        
        $options = array();
        $dataStoreNames = Utility::get($params,"dataStores",null);
        if (! isset($dataStoreNames) || ! is_array($dataStoreNames))
            $exportDataStores = $this->dataStores;
        else {
            $options = array();
            $exportDataStores = array();
            foreach ($dataStoreNames as $k => $v)
                if (isset($this->dataStores[$k])) {
                    $exportDataStores[$k] = $this->dataStores[$k];
                    $options[$k] = $v;
                }
                else if (isset($this->dataStores[$v]))
                    $exportDataStores[$v] = $this->dataStores[$v];
        }

        $k=0;
        foreach($exportDataStores as $name=>$dataStore) {
            if ($k==0)
                $sheet = $excel->getSheet(0);
            else {
                $sheet = new \PHPExcel_Worksheet($excel, $name);
                $excel->addSheet($sheet, $k);
            }
            $sheet->setTitle($name);
            $type = $this->getDataStoreType($dataStore);
            $exportObject = $this->getExportObject($type);
            $exportObject->saveDataStoreToSheet($dataStore, $sheet, 
                isset($options[$name]) ? $options[$name] : array());
            $k++;
        }
        $objWriter = \PHPExcel_IOFactory::createWriter($excel, 'Excel5');
        $output = sys_get_temp_dir()."/".Utility::getUniqueId().".xlsx";
        $objWriter->save($output);
        return new ExcelFile($output);
    }
}
