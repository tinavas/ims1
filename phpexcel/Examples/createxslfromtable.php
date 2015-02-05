<?php


/** Error reporting */
function createxsl($db1,$host1,$pass1,$user1,$dbfile)
{
set_time_limit(0);
ini_set('memory_limit', '-1');
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br/>');

date_default_timezone_set('Europe/London');

/** Include PHPExcel */
require_once 'phpexcel/Classes/PHPExcel.php';


// Create new PHPExcel object
echo date('H:i:s') , " Create new PHPExcel object" , EOL;
$objPHPExcel = new PHPExcel();

// Set document properties
echo date('H:i:s') , " Set document properties" , EOL;
$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
							 ->setLastModifiedBy("Maarten Balliauw")
							 ->setTitle("Office 2007 XLSX Test Document")
							 ->setSubject("Office 2007 XLSX Test Document")
							 ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
							 ->setKeywords("office 2007 openxml php")
							 ->setCategory("Test result file");


// Add some data
echo date('H:i:s') , " Add some data" , EOL;
$objPHPExcel->setActiveSheetIndex(0);
$objPHPExcel->getActiveSheet()->getStyle('A1:G1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->setCellValue('A1', 'Date Of Log Register');
$objPHPExcel->getActiveSheet()->setCellValue('B1', 'Employee Name');
$objPHPExcel->getActiveSheet()->setCellValue('C1', 'Employee Id');
$objPHPExcel->getActiveSheet()->setCellValue('D1', 'Login Time');
$objPHPExcel->getActiveSheet()->setCellValue('E1', 'Logout Time');
$objPHPExcel->getActiveSheet()->setCellValue('F1', 'Duration');
$objPHPExcel->getActiveSheet()->setCellValue('G1', 'Attempt on this date');




$host=$host1;
$user=$user1;
$pass=$pass1;
$name=$db1;
$link = mysql_connect($host,$user,$pass);
	mysql_select_db($name,$link);
echo $res=mysql_query("select * from logdetails ");
$i=1;
while($mrow = mysql_fetch_array($res)) 
{ 
$i++;

 $duration="";
 $days=0;

 $diff=0;
 $min=0;
 $sec=0;
 $hr=0;
 $time1=0;
 $time2=0;
 



 
 $dep=explode(':',$mrow['sessionstarttime']);
 $arr=explode(':',$mrow['sessionendtime']);
 $diff=abs(mktime($dep[0],$dep[1],0,date('n'),date('j'),date('y'))-mktime($arr[0],$arr[1],0,date('n'),date('j'),date('y')));
 $hours=floor($diff/(60*60));
 $mins=floor(($diff-($hours*60*60))/(60));
 $secs=floor(($diff-(($hours*60*60)+($mins*60))));
 if(strlen($hours)<2){$hours="0".$hours;}
 if(strlen($mins)<2){$mins="0".$mins;}
 if(strlen($secs)<2){$secs="0".$secs;}
$duration=$hours.":".$mins.":".$secs;

 
$objPHPExcel->getActiveSheet()->setCellValue("A$i", "$mrow[1]");  
$objPHPExcel->getActiveSheet()->setCellValue("B$i", "$mrow[3]");  
$objPHPExcel->getActiveSheet()->setCellValue("C$i", "$mrow[4]");  
$objPHPExcel->getActiveSheet()->setCellValue("D$i", "$mrow[5]");  
$objPHPExcel->getActiveSheet()->setCellValue("E$i", "$mrow[6]");  
$objPHPExcel->getActiveSheet()->setCellValue("F$i", "$duration"); 

$kk=explode("-",$mrow[2]);
$val=$kk[4];
$objPHPExcel->getActiveSheet()->setCellValue("G$i", "$val"); 


$col="E";
$objPHPExcel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension("A")->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension("B")->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension("C")->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension("D")->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension("F")->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension("G")->setAutoSize(true);

}


// Rename worksheet
echo date('H:i:s') , " Rename worksheet" , EOL;
$objPHPExcel->getActiveSheet()->setTitle('Attendance');






// Set document security
echo date('H:i:s') , " Set document security" , EOL;
$objPHPExcel->getSecurity()->setLockWindows(true);
$objPHPExcel->getSecurity()->setLockStructure(true);
$objPHPExcel->getSecurity()->setWorkbookPassword("smoc2014");


// Set sheet security
echo date('H:i:s') , " Set sheet security" , EOL;
$objPHPExcel->getActiveSheet()->getProtection()->setPassword('smoc2014');
$objPHPExcel->getActiveSheet()->getProtection()->setSheet(true); // This should be enabled in order to enable any of the following!
//$objPHPExcel->getActiveSheet()->getProtection()->setSort(true);
$objPHPExcel->getActiveSheet()->getProtection()->setInsertRows(true);
$objPHPExcel->getActiveSheet()->getProtection()->setFormatCells(true);


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


//set auto filter
$objPHPExcel->getActiveSheet()->setAutoFilter(
	$objPHPExcel->getActiveSheet()->calculateWorksheetDimension()
);



unlink("logbackup/$dbfile");
// Save Excel 95 file
echo date('H:i:s') , " Write to Excel5 format" , EOL;
$callStartTime = microtime(true);


$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save("logbackup/$dbfile");
$callEndTime = microtime(true);
$callTime = $callEndTime - $callStartTime;

echo date('H:i:s') , " File written to " , "203333333.xls" , EOL;
echo 'Call time to write Workbook was ' , sprintf('%.4f',$callTime) , " seconds" , EOL;
// Echo memory usage
echo date('H:i:s') , ' Current memory usage: ' , (memory_get_usage(true) / 1024 / 1024) , " MB" , EOL;


// Echo memory peak usage
echo date('H:i:s') , " Peak memory usage: " , (memory_get_peak_usage(true) / 1024 / 1024) , " MB" , EOL;

// Echo done
echo date('H:i:s') , " Done writing file" , EOL;
echo 'File has been created in ' , getcwd() , EOL;
}