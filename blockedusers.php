<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Blocked Users</title>
</head>

<body>
<form action="updateblockedusers.php" method="post">
<fieldset style="width:900px">
<table align="center">
<tr>
<td><input type="checkbox" id="all" name="all"  /></td>
<td width="50px"></td>
<td>
<strong>Blocked Users</strong>
</td>
</tr>
<tr height="20px"></tr>
<?php include "mainconfig.php" ;
$i=0;
$q1=mysql_query("select distinct uname from blockedusers",$conn) or die(mysql_error());
while($r1=mysql_fetch_array($q1))
{?>
<tr>
<td><input type="checkbox" name="users[]" id="users<?php echo $i;?>" value="<?php echo $r1[uname];?>"  /></td>
<td width="50px"></td>
<td><input type="text" name="uname[]" id="uname<?php echo $i;?>" style="background:none; border:none" value="<?php echo $r1[uname];?>" /></td>
</tr>
<?php $i++; }?>
</table>

<br /><br />
<table align="center">
<tr>
<td><input type="submit" value="Release" id="save" name="save" /></td>
<td><input type="button" value="Cancel" onclick="document.location='dashboardsub.php?page=';"  /></td>
</tr>
</table>
</fieldset>
</form>
</body>

</html>
