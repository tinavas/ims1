<?php include "jquery.php";
 include "getemployee.php"; ?>
<script type="text/javascript">
		$(document).ready(function()
		{
			$('.sortable').each(function(i)
			{
				var table = $(this),
					oTable = table.dataTable({

						aoColumns: [

							{ sType: 'eu_date',asSorting: [ "desc" ] },
							{ },
							{ },
							{ },
							{ }
						],

						sDom: '<"block-controls"<"controls-buttons"p>>rti<"block-footer clearfix"lf>',
						

						fnDrawCallback: function()
						{
							this.parent().applyTemplateSetup();
						},
						fnInitComplete: function()
						{
							this.parent().applyTemplateSetup();
						}
					});
				
				table.find('thead .sort-up').click(function(event)
				{
					event.preventDefault();
					
					var column = $(this).closest('th'),
						columnIndex = column.parent().children().index(column.get(0));
					
					oTable.fnSort([[columnIndex, 'asc']]);
					
					return false;
				});
				table.find('thead .sort-down').click(function(event)
				{
					event.preventDefault();
					
					var column = $(this).closest('th'),
						columnIndex = column.parent().children().index(column.get(0));
					
					oTable.fnSort([[columnIndex, 'desc']]);
					
					return false;
				});
			});
			
		});
		
	</script>
	<div id="control-bar" class="grey-bg clearfix"><div class="container_12">
	
		
		
		<div class="float-right"> 
			<button type="button" onClick="document.location='dashboardsub.php?page=pp_addgateentry'"><img src="images/icons/fugue/tick-circle.png" width="16" height="16"> Add</button>
			<!--<button type="button" class="grey">View</button> -->
			<!-- <button type="button" disabled="disabled">Disabled</button> -->
			<!--<button type="button" class="red">Authorize</button> -->


		</div>
			
	</div></div>


<section class="grid_12">
<div class="block-border">
<form class="block-content form" id="table_form" method="post" action="">
<h1>Gate Entry</h1>
<?php
$month = $_GET['month'];
 $datep = date("d-m-Y");
$monthcnt = "";
$yearcnt = "";
$year = $_GET['year'];
if($year == "")
{

$arr = explode('-',$datep);
 $year = $arr[2];
}
if($month == "")
{
  $arr = explode('-',$datep);
 $monthcnt = $arr[1];
}
else if($month == "January")
{
$monthcnt = 1;
}
else if ($month == "February")
{
$monthcnt = 2;
}
else if($month == "March")
{
$monthcnt = 3;
}
else if($month == "April")
{
$monthcnt = 4;
}
else if($month == "May")
{
$monthcnt = 5;
}
else if($month == "June")
{
$monthcnt = 6;
}
else if($month == "July")
{
$monthcnt = 7;
}
else if($month == "August")
{
$monthcnt = 8;
}
else if($month == "September")
{
$monthcnt = 9;
}
else if($month == "October")
{
$monthcnt = 10;
}
else if($month == "November")
{
$monthcnt = 11;
}
else if($month == "December")
{
$monthcnt = 12;
}
$fromdate = $year."-".$monthcnt."-01";
$todate = $year."-".$monthcnt."-31";
?>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Month:
<select name="month" id="month" onchange="reloadpage();" >
<option value="">--Select--</option>
<option  value="January"<?php if($monthcnt == 1){ ?> selected="selected"<?php } ?>>January</option>
<option  value="February"<?php if($monthcnt == 2){ ?> selected="selected"<?php } ?>>February</option>
<option  value="March"<?php if($monthcnt == 3){ ?> selected="selected"<?php } ?>>March</option>
<option  value="April"<?php if($monthcnt == 4){ ?> selected="selected"<?php } ?>>April</option>
<option  value="May"<?php if($monthcnt == 5){ ?> selected="selected"<?php } ?>>May</option>
<option  value="June"<?php if($monthcnt == 6){ ?> selected="selected"<?php } ?>>June</option>
<option  value="July"<?php if($monthcnt == 7){ ?> selected="selected"<?php } ?>>July</option>
<option  value="August"<?php if($monthcnt == 8){ ?> selected="selected"<?php } ?>>August</option>
<option  value="September"<?php if($monthcnt == 9){ ?> selected="selected"<?php } ?>>September</option>
<option  value="October"<?php if($monthcnt == 10){ ?> selected="selected"<?php } ?>>October</option>
<option  value="November"<?php if($monthcnt == 11){ ?> selected="selected"<?php } ?>>November</option>
<option  value="December"<?php if($monthcnt == 12){ ?> selected="selected"<?php } ?>>December</option>
</select>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Year:
<select name="year" id="year" onchange="reloadpage();" >
<option value="">--Select--</option>
<?php 
for($i=$fyear;$i<=$tyear;$i++)
{
echo $i;
?>
<option value="<?php echo $i; ?>" <?php if($i == $year) { ?> selected="selected" <?php } ?>><?php echo $i; ?></option>
<?php } ?>
</select>

<table class="table sortable no-margin" cellspacing="0" style="size:50%" width="100%">
<thead>
<tr >
<th style="text-align:left"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>Date</th>
<th style="text-align:left"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>Gate Entry #</th>
<th style="text-align:left"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>Vendor/Broker</th>
<th style="text-align:left"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>Vehicle No.</th>
<th>Actions</th>
</tr>
</thead>
<tbody>
	 <?php
           include "config.php"; 
           $query = "SELECT distinct(ge),date,vehicleno,vendor,broker,aflag FROM pp_gateentry WHERE date >= '$fromdate' and date <= '$todate' ORDER BY ge ASC";
           $result = mysql_query($query,$conn); 
           while($row1 = mysql_fetch_assoc($result))
           {
              
           ?>
            <tr>
             <td><?php echo date("d.m.Y", strtotime($row1['date'])); ?></td>
             <td><?php echo $row1['ge']; ?></td>
             <td><?php if($row1['vendor'] == "") { echo $row1['broker'];} else { echo $row1['vendor'];} ; ?></td>
             <td><?php echo $row1['vehicleno']; ?></td>
           	<td>			
<?php			 
$tquery	= "SELECT * FROM pp_goodsreceipt WHERE ge = '$row1[ge]'";
$tresult = mysql_query($tquery,$conn) or die(mysql_error());
$trows = mysql_num_rows($tresult);
if($trows == 0)
{
?>

<?php if($_SESSION['db'] == "central" or $_SESSION['db'] == "alwadi") { 
$flag = $row1['aflag']; ?>
<?php if($flag == 0) { ?>	<!-- Before Authorization -->
<a href="dashboardsub.php?page=pp_editgateentry&id=<?php echo $row1['ge']; ?>"><img src="images/icons/fugue/pencil.png" style="border:0px" title="Edit"/></a>
&nbsp;&nbsp;&nbsp;<a onclick="if(confirm('Do you really want to delete this row?'))document.location='pp_deletegateentry.php?id=<?php echo $row1['ge']; ?>'"><img src="images/icons/fugue/cross-circle.png" style="border:0px" title="Delete" /></a>&nbsp;
<?php } else { ?>
<?php if ( strlen(strstr(','.$_SESSION['authorizesectors'],',GE,' ))>0 ) { ?>	<!-- If he has authority power -->
<a href="dashboardsub.php?page=pp_editgateentry&id=<?php echo $row1['ge']; ?>"><img src="images/icons/fugue/pencil.png" style="border:0px" title="Edit"/></a>
&nbsp;&nbsp;&nbsp;<a onclick="if(confirm('Do you really want to delete this row?'))document.location='pp_deletegateentry.php?id=<?php echo $row1['ge']; ?>'"><img src="images/icons/fugue/cross-circle.png" style="border:0px" title="Delete" /></a>&nbsp;
<?php if($flag == 1) { ?><img src="images/icons/fugue/tick-circle.png" title="Already Authorized" width="16"height="16"><?php } ?>
<?php } else { ?>
<img src="images/icons/fugue/lock.png" style="border:0px" title="<?php echo "Already Authorized"; ?>"/>
<?php } ?>
<?php } ?>

<?php } else {  if($_SESSION['db']=='golden'){ ?>
<a href="dashboardsub.php?page=pp_editgateentry&id=<?php echo $row1['ge']; ?>"><img src="images/icons/fugue/pencil.png" style="border:0px" title="Edit"/></a>
			<?php if($_SESSION['admin']==1)
			 {
			 ?>
			 &nbsp;&nbsp;&nbsp;<a onclick="if(confirm('Do you really want to delete this row?'))document.location='pp_deletegateentry.php?id=<?php echo $row1['ge']; ?>'"><img src="images/icons/fugue/cross-circle.png" style="border:0px" title="Delete" /></a>&nbsp;<?php } else {} }else {?>
<a href="dashboardsub.php?page=pp_editgateentry&id=<?php echo $row1['ge']; ?>"><img src="images/icons/fugue/pencil.png" style="border:0px" title="Edit"/></a>
&nbsp;&nbsp;&nbsp;<a onclick="if(confirm('Do you really want to delete this row?'))document.location='pp_deletegateentry.php?id=<?php echo $row1['ge']; ?>'"><img src="images/icons/fugue/cross-circle.png" style="border:0px" title="Delete" /></a>&nbsp;

<?php }} ?>




<?php } else {?>
<img src="images/icons/fugue/lock.png" width="16px" style="border:0px" title="Goods Receipt Completed" />
<?php } ?> 

           </tr>
           <?php 
           }
           ?>   
                                   
                                   
</tbody>
</table>
</form>
</div>
</section>


<br />



<script type="text/javascript">
function reloadpage()
{
var month = document.getElementById('month').value;
var year = document.getElementById('year').value;
document.location = "dashboardsub.php?page=pp_gateentry&month=" + month + "&year=" + year;
}
</script>

