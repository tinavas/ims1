<?php
include "config.php";


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
</head>
<body>

<?php
//print_r($_FILES);
$c=0;
include("ExcelExplorer2.php");
if( $_FILES['file'] && ($_FILES['file']['tmp_name'] != '') )
 {
$size=filesize($_FILES['file']['tmp_name']);
$fp=fopen($_FILES['file']['tmp_name'],'rb') or die("cant open file");
$data=fread($fp,$size);
//echo strlen($data);
//echo $size;
fclose($fp);
}
else
{
echo "File not uploaded properly";
}
$ex = new ExcelExplorer;
$ex->Explore($data);
for($sheet=0;$sheet<$ex->GetWorksheetsNum();$sheet++)
{
for($row=0;$row<=$ex->GetLastRowIndex($sheet);$row++)
{
for($col=0;$col<=$ex->GetLastColumnIndex($sheet);$col++)
{
$d=$ex->GetCellData($sheet,$col,$row);

if($row>0)
{
if($col=="0")
{
/*print_r($d);
$c=explode("/",$d);
$d0=$c[2]."-".$c[1]."-".$c[0];*/
$d0=date("Y-m-d",strtotime($d['string']));;
}
if($col=="1")
{
$d1=$d['string'];
/*print_r($d);
$c=explode(":",$d);
$d1=$c[0]."-".$c[1]."-".$c[2];
//$d1=$d;*/
}
if($col=="2")
{
$d2=htmlentities($d, ENT_QUOTES);
}
if($col=="3")
{
$d3=htmlentities($d, ENT_QUOTES);
}
if($col=="4")
{
$d4=htmlentities($d, ENT_QUOTES);
}
if($col=="5")
{
$d5=htmlentities($d, ENT_QUOTES);
}

if($col=="6"){$d6=htmlentities($d, ENT_QUOTES);}
if($col=="7"){$d7=htmlentities($d, ENT_QUOTES);}
if($col=="8"){$d8=htmlentities($d, ENT_QUOTES);}
if($col=="9"){$d9=htmlentities($d, ENT_QUOTES);}
if($col=="10"){$d10=htmlentities($d, ENT_QUOTES);}
if($col=="11"){$d11=htmlentities($d, ENT_QUOTES);}
if($col=="12"){$d12=htmlentities($d, ENT_QUOTES);}


$tc="12";

if($tc==$col)
{
/*echo $d0,"<br/>";
echo $d1,"<br/>";
echo $d2,"<br/>";
echo $d3,"<br/>";
echo $d4,"<br/>";
echo $d5,"<br/>";
echo $d6,"<br/>";
echo $d7,"<br/>";
echo $d8,"<br/>";
echo $d9,"<br/>";
echo $d10,"<br/>";
echo $d11,"<br/>";
echo $d12,"<br/>";*/
 $sql="insert into 'projectmanagement'.'customizationcompletion' values('','$d0','$d1','$d2','$d3','$d4','$d5','$d6','$d7','$d8','$d9','$d10','$d11','$d12')";
$qrs = mysql_query($sql,$conn) or die(mysql_error());


?>
<!--
<input type="text" name="n[]" id="c" value="<?php echo $d0;?>" />
<input type="text" name="c[]" id="c" value="<?php echo $d1;?>" />
<input type="text" name="p[]" id="c" value="<?php echo $d2;?>" />
<input type="text" name="b[]" id="c" value="<?php echo $d3;?>" />
<input type="text" name="co[]" id="c" value="<?php echo $d4;?>" />
<input type="text" name="m[]" id="c" value="<?php echo $d5;?>" />
-->




<?php
}
}
}
}
}





?>

</body>
</html>
