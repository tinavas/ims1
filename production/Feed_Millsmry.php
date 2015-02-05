<?php 
$sExport = @$_GET["export"]; 
if (@$sExport == "") { ?>
 
  <style type="text/css">
        thead tr {
            position: absolute; 
            height: 30px;
            top: expression(this.offsetParent.scrollTop);
        }
        tbody {
            height: auto;
        }
        .ewGridMiddlePanel {
        	border: 0;	
            height: 435px;
            padding-top:30px; 
            overflow: scroll; 
        }
    </style>
<?php }
include "reportheader.php"; 
include "config.php";
if($_GET['fromdate'] <> "")
 $fromdate = date("Y-m-d",strtotime($_GET['fromdate']));
else
 $fromdate = date("Y-m-d"); 
?>
<?php
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // Always modified
header("Cache-Control: private, no-store, no-cache, must-revalidate"); // HTTP/1.1 
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache"); // HTTP/1.0
?>
<?php include "phprptinc/ewrcfg3.php"; ?>
<?php include "phprptinc/ewmysql.php"; ?>
<?php include "phprptinc/ewrfn3.php"; ?>
<?php include "phprptinc/header.php"; ?>
<table align="center" border="0">
<tr>
 <td colspan="2" align="center"><strong><font color="#3e3276">Feed Formula Summary</font></strong></td>
</tr>
<tr height="5px"></tr>
<tr>
 <td>&nbsp;</td>
</tr> 
</table>

<?php
session_start();
$client = $_SESSION['client'];
?>
<?php
$sExport = @$_GET["export"]; // Load export request
if ($sExport == "html") {
	// Printer friendly
}
if ($sExport == "excel") {
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment; filename=' . EW_REPORT_TABLE_VAR .'.xls');
}
if ($sExport == "word") {
	header('Content-Type: application/vnd.ms-word');
	header('Content-Disposition: attachment; filename=' . EW_REPORT_TABLE_VAR .'.doc');
}


if($_GET['feedtype'] != "" && $_GET['feedtype']!="All")
{
$feedtype = "feedtype = '$_GET[feedtype]'";
$feed = $_GET['feedtype'];
}
else
{
$feedtype = "feedtype = 'FD101'";
$feed = "FD101";
}

$query = "select distinct(sid) from feed_fformula where $feedtype";
$result = mysql_query($query,$conn1) or die(mysql_error());
$count = mysql_num_rows($result);

if($count > 10)
if($_GET['limit']=="")
$limit = "limit 0,10";
else
$limit = "$_GET[limit]";

if($_GET['page'] !="")
$page = $_GET['page'];
else
$page = 1;

?>

<?php if (@$sExport == "") { ?>
<!-- Table Container (Begin) -->
<table id="ewContainer" cellspacing="0" cellpadding="0" border="0" align="center">
<!-- Top Container (Begin) -->
<tr><td colspan="3"><div id="ewTop" class="phpreportmaker">
<!-- top slot -->
<?php } ?>
<?php if (@$sExport == "") { ?>
&nbsp;&nbsp;<a href="#" onclick="reloadpage('html','','SELECT');">Printer Friendly</a>
&nbsp;&nbsp;<a href="#" onclick="reloadpage('excel','','');">Export to Excel</a>
&nbsp;&nbsp;<a href="#" onclick="reloadpage('word','','');">Export to Word</a>
<?php if ($bFilterApplied) { ?>
&nbsp;&nbsp;<a href="Feed_Millsmry.php?cmd=reset&fromdate=<?php echo $fromdate; ?>">Reset All Filters</a>
<?php } ?>
<?php } ?>
<br /><br />
<?php if (@$sExport == "") { ?>
</div></td></tr>
<!-- Top Container (End) -->
<tr>
	<!-- Left Container (Begin) -->
	<td valign="top"><div id="ewLeft" class="phpreportmaker">
	<!-- Left slot -->
	</div></td>
	<!-- Left Container (End) -->
	<!-- Center Container - Report (Begin) -->
	<td valign="top" class="ewPadding"><div id="ewCenter" class="phpreportmaker">
	<!-- center slot -->
	
<?php } ?>

<?php if (@$sExport != "") {
 if($count >10) {
  $limitvalues = $_GET['limit'];
  ?>
 <center>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
 <input type="button" id="pre" name="pre" value="Previous" style="width:60px" onclick="reloadpage('','PREVIOUS','');" <?php if($_GET['pre'] ==0) {?> disabled="disabled" <?php } ?>  />
 
 &nbsp;
  
  <input type="button" id="next" name="next" value="Next" style="width:60px" onclick="reloadpage('','NEXT','');" <?php  if($_GET['pre']+10  >= $count) {?> disabled="disabled" <?php } ?>/>
  &nbsp;
  Page <?php echo $page; ?> of <?php echo ceil($count/10);  ?> 
  &nbsp;&nbsp;
  <input type="button" value="Reset" onblur="resetpage();" />
 <!-- <a href="Feed_Millsmry.php">Reset</a>-->
  </center>
    <?php
   }
   }
  
   ?>


<!-- summary report starts -->
<div id="report_summary">

<table class="ewGrid" cellspacing="0" align="center"><tr>
	<td class="ewGridContent">
<?php if (@$sExport == "") { ?>
<div class="ewGridUpperPanel">
<table>
 <tr>
 <td>Feed Type</td><td>&nbsp;&nbsp;<select id="feedtype" name="feedtype" style="width:80px" onchange="reloadpage('','','SELECT');">
 
 <?php 
 $query = "select distinct(feedtype) from feed_fformula order by feedtype";
 $result = mysql_query($query,$conn1) or die(mysql_error());
 while($res = mysql_fetch_assoc($result))
 {
 ?>
 <option value="<?php echo $res['feedtype'];?>" <?php if($feed==$res['feedtype']){ ?> selected="selected" <?php } ?>><?php echo $res['feedtype']; ?></option>
 <?php }
 
 ?>
 </select>
 <?php if($count >10) {?>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
 
 <input type="button" id="pre" name="pre" value="Previous" style="width:60px" onclick="reloadpage('','PREVIOUS','');" <?php if($_GET['pre'] ==0) {?> disabled="disabled" <?php } ?>  />
 
 &nbsp;&nbsp;&nbsp;
  
  <input type="button" id="next" name="next" value="Next" style="width:60px" onclick="reloadpage('','NEXT','');" <?php  if($_GET['pre']+10  >= $count) {?> disabled="disabled" <?php } ?>/>
  
  &nbsp;&nbsp;&nbsp;
  Page <?php echo $page; ?> of <?php echo ceil($count/10);  ?> 
  <?php } ?>
 </td>
 
 

</tr>
</table>	  
</div>
<?php } ?>
<!-- Report Grid (Begin) -->
<div class="ewGridMiddlePanel">
<table class="ewTable ewTableSeparate" cellspacing="0" align="center">

	<thead>
	<tr>
  <td valign="bottom" class="ewTableHeader">Item Code</td><td valign="bottom" class="ewTableHeader">Item Description</td>	
<?php 

 $query = "select distinct(sid) from feed_fformula where $feedtype order by formulaid $limit";
$result = mysql_query($query,$conn1) or die(mysql_error());
$si=0;
while($res = mysql_fetch_assoc($result))
{
?>
  <td valign="bottom" class="ewTableHeader"><?php echo $res['sid']; $sidvalues[$si]=$res['sid'];  ?></td>
<?php 
$si++;
} ?>

</tr>  
	</thead>
	<tbody>
<?php 
$query = "SELECT sum( quantity ) AS quantity, ingredient, sid FROM feed_fformula where $feedtype GROUP BY sid, ingredient ORDER BY ingredient";

$result = mysql_query($query,$conn1) or die(mysql_error());
while($res = mysql_fetch_assoc($result))
{
 $values[$res['ingredient']][$res['sid']] = $res['quantity']; 
 $total[$res['sid']] += $res['quantity'];
} 
 
$query = "select distinct(ingredient),description from feed_fformula f,ims_itemcodes i where $feedtype and f.ingredient = i.code ORDER BY f.ingredient";
$result = mysql_query($query,$conn1) or die(mysql_error());
$size = sizeof($sidvalues);
while($res = mysql_fetch_assoc($result))
{
?>
<tr><td><?php echo $res['ingredient'];?></td><td><?php echo $res['description'];?></td>
 <?php
 for($k=0; $k<$size; $k++)
 {
   ?>
   <td align="right"><?php if($values[$res['ingredient']][$sidvalues[$k]]) echo round($values[$res['ingredient']][$sidvalues[$k]],2); else echo "0"; ?> </td> 
<?php }
?>
</tr>
<?php } ?>
<tr>
 <td colspan="2" align="right" style="padding-right:5px;">Total</td>
<?php 

 $query = "select distinct(sid) from feed_fformula where $feedtype order by formulaid $limit";
$result = mysql_query($query,$conn1) or die(mysql_error());
while($res = mysql_fetch_assoc($result))
{
?>
  <td align="right"><?php echo round($total[$res['sid']],2); ?></td>
<?php } ?>
 </tr>
	</tbody>
	<tfoot>

 </tfoot>
</table>
</div>
</td></tr></table>
</div>
<?php if (@$sExport == "") { ?>
	</div><br /></td>
</tr>
</table>
<?php } ?>
<?php include "phprptinc/footer.php"; ?>
<script type="text/javascript">
<?php if($_GET['pre']!="")
{?>
var previous = <?php echo $_GET['pre']; ?>;
<?php } else {?>

var previous = 0;
<?php } ?>
var next = 10;
var rowcount = <?php echo $count; ?>;
var page = <?php echo $page; ?>;
function reloadpage(type,limittype,sel)
{
   // var fromdate = document.getElementById('fromdate').value;
	//var todate = document.getElementById('todate').value;
	if(sel == "SELECT")
	page = 1;
	<?php if($_GET['export'] != "") { ?>
	  var feedtype = "<?php echo $_GET['feedtype']; ?>";
	  <?php } else { ?>
	var feedtype = document.getElementById('feedtype').value;
    <?php } ?>
	if(limittype == "NEXT")
	 {
	   previous+=10;
	   page++;
	 }
	else if(limittype == "PREVIOUS")
	{
	  if(previous>=10)
	  {
	  previous-=10;
	  page--;
	  }
	  else
	  {
	  alert('There are no previous values.');
	  return;
	  }
	}
	else
	{
	previous = 0;
	next = 10;
	}
	if(type == "")
	type = "<?php echo $_GET['export'];?>";
	limit = "limit " + previous + " , " + next;
	
	<?php if($_GET['export'] != "") { ?>
	  document.location = 'Feed_Millsmry.php?feedtype=' + feedtype + '&export=' + type + '&limit=' + limit + '&pre=' + previous + '&page=' + page;
	  <?php } else { ?>
	document.location = 'Feed_Millsmry.php?feedtype=' + feedtype + '&export=' + type + '&limit=' + limit +'&pre=' + previous + '&page=' + page;
    <?php } ?>
	
	
	
	//document.location = 'Feed_Millsmry.php?feedtype=' + feedtype + '&export=' + type + '&limit=' + limit;
}
function resetpage()
{

document.location = "Feed_Millsmry.php";
}
</script>