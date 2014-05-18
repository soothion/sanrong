<?php

require_once Yii::app()->basePath . '/extensions/phpexcel/PHPExcel.php';
require_once Yii::app()->basePath . '/extensions/phpexcel/PHPExcel/IOFactory.php';
require_once Yii::app()->basePath . '/extensions/phpexcel/PHPExcel/Reader/Excel5.php';

//Yii::import('application.extensions.phpexcel.PHPExcel');
//Yii::import('application.extensions.phpexcel.PHPExcel.IOFactory');
class CPhpexcel {

    public static function excelToArray($fileName) {
        set_time_limit(0);
        ini_set('memory_limit', '1018M'); //處理內存溢出   

        $reader = PHPExcel_IOFactory::createReader('Excel5'); // 讀取 excel 檔案  
        $PHPExcel = $reader->load($fileName); // 檔案名稱  
        //$PHPExcel = $reader->load(ROOT.'/example_1.xls'); 
        $sheet = $PHPExcel->getSheet(0); // 讀取第一個工作表(編號從 0 開始)  
        $highestRow = $sheet->getHighestRow(); // 取得總行數 
        $highestColumn = $sheet->getHighestColumn(); // 取得總列數 

        $arr = array(1 => 'A', 2 => 'B', 3 => 'C', 4 => 'D', 5 => 'E', 6 => 'F', 7 => 'G', 8 => 'H', 9 => 'I', 10 => 'J', 11 => 'K', 12 => 'L', 13 => 'M', 14 => 'N', 15 => 'O', 16 => 'P', 17 => 'Q', 18 => 'R', 19 => 'S', 20 => 'T', 21 => 'U', 22 => 'V', 23 => 'W', 24 => 'X', 25 => 'Y', 26 => 'Z');
        $column = array_search($highestColumn, $arr);
        $column = $column != false ? $column : 0;
        $data = array();
        for ($row = 1; $row <= $highestRow; $row++) {
            for ($i = 0; $i < $column; $i++) {
                $data[$row - 1][$i] = trim($sheet->getCellByColumnAndRow($i, $row)->getValue());
            }
        }
        return $data;
    }

    public static function arrayToExcel($data) {
        set_time_limit(0);
        ini_set('memory_limit', '518M'); //处理内存溢出   		
        $PHPExcel = new PHPExcel();
        $PHPExcel->getProperties()->setCreator("Maarten Balliauw")
                ->setLastModifiedBy("Maarten Balliauw")
                ->setTitle("Office 2007 XLSX Test Document")
                ->setSubject("Office 2007 XLSX Test Document")
                ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
                ->setKeywords("office 2007 openxml php")
                ->setCategory("Test result file");

        $arr = array(1 => 'A', 2 => 'B', 3 => 'C', 4 => 'D', 5 => 'E', 6 => 'F', 7 => 'G', 8 => 'H', 9 => 'I', 10 => 'J', 11 => 'K', 12 => 'L', 13 => 'M', 14 => 'N', 15 => 'O', 16 => 'P', 17 => 'Q', 18 => 'R', 19 => 'S', 20 => 'T', 21 => 'U', 22 => 'V', 23 => 'W', 24 => 'X', 25 => 'Y', 26 => 'Z');

        foreach ($data as $key => $value) {
            foreach ($value as $k => $v) {
                //$PHPExcel->setActiveSheetIndex(0)->setCellValue($arr[$k+1].($key+1),$v);
            }
        }

        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");
        header('Content-Disposition:inline;filename="data' . date("Y-m-d-H-i-s") . '.xls"');
        header("Content-Transfer-Encoding: binary");
        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Pragma: no-cache");
        $objWriter = PHPExcel_IOFactory::createWriter($PHPExcel, 'Excel5');
        $objWriter->save('php://output');
        exit;
    }

}
?>