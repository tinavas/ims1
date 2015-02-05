<?php
$temp = explode('?',$_GET['data']);
$refid = $temp[0];

$pms2 = explode('*',$temp[1]);
?>
<table id="databasestabel" align="center">
<tr>
 <td><strong>Ref Id</strong></td>
 <td><?php echo $refid; ?></td>
</tr>
<tr>
 <td><strong>Client</strong></td>
 <td><strong>Position</strong></td>
</tr>
<?php
for($i = 0; $i < count($pms2); $i++)
{
 $value = $pms2[$i];
 $temp = explode('@',$value);
 $db = $temp[0];
 $client = $temp[1];
 //$db = $_SESSION['db'];
 
 $db_host = "localhost";

 $db_user = "poultry";

 $db_pass = "4(vQLs+#-b";

 $db_name = $db;

//$client = $_SESSION['client'];

 $conn=mysql_connect($db_host,$db_user,$db_pass)or die(mysql_error());
 mysql_select_db($db_name);

 $query0 = "SELECT * FROM common_links WHERE refid = '$refid' AND client = '$client'";
 $result0 = mysql_query($query0,$conn) or die(mysql_error());
 $rows0 = mysql_num_rows($result0);
 if($rows0 == 0)
 {
  ?>
  <tr>
   <td><?php echo $client; ?></td>
   <td>Available</td>
  </tr>
  <?php
 }
 else
 {
  ?>
  <tr>
   <td><font style='color:#FF0000'><?php echo $client; ?></font></td>
   <td><font style='color:#FF0000'>Occupied</font></td>
  </tr>
  <?php
 }
}
?>