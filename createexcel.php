<?php

$combos= require_once './parse_html&combine.php';


$objPHPExcel = new PHPExcel();
$objPHPExcel->getProperties()
    ->setCreator("admin")
    ->setLastModifiedBy("admin")
    ->setTitle("Test")
    ->setSubject("template file")
    ->setDescription("template file")
    ->setKeywords("Prout");

$objPHPExcel->setActiveSheetIndex(0);
$objPHPExcel->getActiveSheet()->SetCellValue('A1', 'sku');
$objPHPExcel->getActiveSheet()->setCellValue('B1','bore');
$objPHPExcel->getActiveSheet()->setCellValue('C1','stroke');
$objPHPExcel->getActiveSheet()->setCellValue('D1','rod');
$objPHPExcel->getActiveSheet()->setCellValue('E1','retracted');
$objPHPExcel->getActiveSheet()->setCellValue('F1','extended');
$objPHPExcel->getActiveSheet()->setCellValue('G1','pin');
$objPHPExcel->getActiveSheet()->setCellValue('H1','port_size');
$objPHPExcel->getActiveSheet()->setCellValue('J1','column_load');
$objPHPExcel->getActiveSheet()->setCellValue('K1','price');
$objPHPExcel->getActiveSheet()->setCellValue('L1','width');
$objPHPExcel->getActiveSheet()->setCellValue('M1','height');
$objPHPExcel->getActiveSheet()->setCellValue('N1','depth');
$objPHPExcel->getActiveSheet()->setCellValue('O1','oil_volume');
$objPHPExcel->getActiveSheet()->setCellValue('P1','weight');

for($i=0;$i<count($combos);$i++){
    $s=$i+2;
    $objPHPExcel->getActiveSheet()->setCellValue("A{$s}",$combos[$i]->sku);
    $objPHPExcel->getActiveSheet()->setCellValue("B{$s}",$combos[$i]->bore);
    $objPHPExcel->getActiveSheet()->setCellValue("C{$s}",$combos[$i]->stroke);
    $objPHPExcel->getActiveSheet()->setCellValue("D{$s}",$combos[$i]->rod);
    $objPHPExcel->getActiveSheet()->setCellValue("E{$s}",$combos[$i]->retracted);
    $objPHPExcel->getActiveSheet()->setCellValue("F{$s}",$combos[$i]->extended);
    $objPHPExcel->getActiveSheet()->setCellValue("G{$s}",$combos[$i]->pin);
    $objPHPExcel->getActiveSheet()->setCellValue("H{$s}",$combos[$i]->port_size);
    $objPHPExcel->getActiveSheet()->setCellValue("J{$s}",$combos[$i]->column_load);
    $objPHPExcel->getActiveSheet()->setCellValue("K{$s}",$combos[$i]->price);
    $objPHPExcel->getActiveSheet()->setCellValue("L{$s}",$combos[$i]->width);
    $objPHPExcel->getActiveSheet()->setCellValue("M{$s}",$combos[$i]->height);
    $objPHPExcel->getActiveSheet()->setCellValue("N{$s}",$combos[$i]->depth);
    $objPHPExcel->getActiveSheet()->setCellValue("P{$s}",$combos[$i]->weight);
    $objPHPExcel->getActiveSheet()->setCellValue("O{$s}",$combos[$i]->oil_volume);
}




$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);


$objWriter->save('test1.xlsx');
