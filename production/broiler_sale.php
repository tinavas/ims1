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
	
		<div class="float-left">
			<!--<button type="button"><img src="images/icons/fugue/navigation-180.png" width="16" height="16"> Back to list</button> -->
			<button type="button" target="_new" onClick="window.open('production/salesreportsmry.php');">Open report</button>
		</div>
		
		<div class="float-right"> 
			<button type="button" onClick="document.location='dashboardsub.php?page=broiler_addsale'"><img src="images/icons/fugue/tick-circle.png" width="16" height="16"> Add</button>
			<!--<button type="button" class="grey">View</button> -->
			<!-- <button type="button" disabled="disabled">Disabled</button> -->
			<!--<button type="button" class="red">Authorize</button> -->


		</div>
			
	</div></div>


<section class="grid_12">
<div class="block-border">
<form class="block-content form" id="table_form" method="post" action="">
<h1>Sale of Broiler Birds</h1>
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
<option value="2011"<?php if($year == "2011"){ ?> selected="selected"<?php } ?>>2011</option>
<option value="2012"<?php if($year == "2012"){ ?> selected="selected"<?php } ?>>2012</option>
</select>

<table class="table sortable no-margin" cellspacing="0" style="size:50%" width="100%">
<thead>
<tr >
<th style="text-align:center" title="Auto Generated Number(Supplier Order Based Invoice)"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>Date</th>
<th style="text-align:center" title="Auto Generated Number(Customner Order Based Invoice)"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>COBI #</th>
<th style="text-align:center"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>Customer</th>
<th style="text-align:center"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>Farm</th>
<th style="text-align:center"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>Birds</th>
<th style="text-align:center"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>Weight</th>
<th style="text-align:center"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>Price</th>
<th style="text-align:center">Actions</th>
</tr>
</thead>
<tbody>
	  <?php
           include "config.php"; 
		   if(($_SESSION['db'] == "feedatives") and ($_SESSION['sectorr'] <> "all"))
		   {
		   $sectort = $_SESSION['sectorr'];
		    $query1 = "SELECT distinct(invoice),party,date,flag FROM oc_cobi WHERE description = 'BROILER BIRDS' and farm in (select distinct(farm) from broiler_farm where place = '$sectort') and dflag = '0' AND farm IN (SELECT distinct(farm) FROM broiler_farm WHERE type <> 'rental') and date >= '$fromdate' and date <= '$todate' order by date desc";
		   }
		   elseif(($_SESSION['db'] == "feedatives") and ($_SESSION['sectorr'] == "all"))
		   {
           $query1 = "SELECT distinct(invoice),party,date,flag FROM oc_cobi WHERE description = 'BROILER BIRDS' and dflag = '0' AND farm IN (SELECT distinct(farm) FROM broiler_farm WHERE type <> 'rental') and date >= '$fromdate' and date <= '$todate' order by date desc";
		   }
		   else
		   {
           $query1 = "SELECT distinct(invoice),party,date,flag FROM oc_cobi WHERE description = 'BROILER BIRDS' and dflag = '0' and date >= '$fromdate' and date <= '$todate' order by date desc";
		   }
           $result1 = mysql_query($query1,$conn); 
           while($row1 = mysql_fetch_assoc($result1))
           {
            $farm = $quantity = $weight = $price = "";
           $query2 = "SELECT * FROM oc_cobi WHERE invoice = '$row1[invoice]' and date >= '$fromdate' and date <= '$todate' order by date";
           $result2 = mysql_query($query2,$conn); 
           while($row2 = mysql_fetch_assoc($result2))
           {
             $farm = $farm.$row2['farm']."/";
			 $quantity = $quantity.$row2['quantity']."/";
			 $weight = $weight.$row2['birds']."/";
             $price = $price.$row2['price']."/";
           }
      ?>
            <tr>
              <td><?php echo date("d.m.Y", strtotime($row1['date'])); ?></td>
              <td><?php echo $row1['invoice']; ?></td>
              <td><?php echo $row1['party']; ?></td>
              <td title="<?php echo substr($farm,0,-1); ?>"><?php echo substr($farm,0,-1); ?></td>
			  <td title="<?php echo substr($weight,0,-1); ?>"><?php echo substr($weight,0,-1); ?></td>
			  <td title="<?php echo substr($quantity,0,-1); ?>"><?php echo substr($quantity,0,-1); ?></td>
			  <td title="<?php echo substr($price,0,-1); ?>"><?php echo substr($price,0,-1); ?></td>
		 
           <td>
<?php /*?> if($row1['flag'] == 1) { ?>
 		 <img src="images/icons/fugue/lock.png" style="border:0px" title="Authorized"/>
<?php } else { ?>
<a href="dashboard.php?page=oc_authorizedirectsales&id1=1&id=<?php echo $row1['invoice']; ?>"><img src="images/icons/fugue/arrow-090.png" style="border:0px" title="Authorize"/></a>
&nbsp;&nbsp;&nbsp;<a href="pp_authorizedirectpurchase?id=<?php echo $row1['invoice']; ?>"><img src="images/icons/fugue/cross-circle.png" style="border:0px" title="Delete" /></a>&nbsp;
<a target="new" href="production/oc_printdc.php?id=<?php echo $row1['invoice']; ?>"><img src="images/icons/fugue/report.png" style="border:0px" title="Print" /></a>&nbsp;
</td>
<?php }<?php */?> 

<a href="dashboardsub.php?page=broiler_editbirdsales&id=<?php echo $row1['invoice']; ?>"><img src="images/icons/fugue/pencil.png" style="border:0px" title="Edit"/></a>&nbsp;&nbsp;
<a href="broiler_deletesales.php?id=<?php echo $row1['invoice']; ?>"><img src="images/icons/fugue/cross-circle.png" style="border:0px" title="Delete" /></a>
<?php if($_SESSION['db'] == "sumukh")
{?>
<a target="_new" href="production/oc_printdc.php?id=<?php echo $row1['invoice']; ?>"><img src="images/icons/fugue/report.png" style="border:0px" title="Print" /></a>&nbsp;
<?php }?>
</td>

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
document.location = "dashboardsub.php?page=broiler_sale&month=" + month + "&year=" + year;
}
</script>

