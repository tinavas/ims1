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
			<button type="button" target="_new" onClick="window.open('production/tripdetailssmry.php');">Open report</button>
		</div>
		
		<div class="float-right"> 
			<button type="button" onClick="document.location='dashboardsub.php?page=vehicle_addtrip'"><img src="images/icons/fugue/tick-circle.png" width="16" height="16"> Add</button>
			 


		</div>
			
	</div></div>


<section class="grid_12">
<div class="block-border">
<form class="block-content form" id="table_form" method="post" action="">
<h1>Vehicle Trip Sheet</h1>



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
include "config.php";
	$query  = "SELECT MIN(fdate) as fdate FROM ac_definefy";
	$result = mysql_query($query, $conn);
	$data=mysql_fetch_array($result);
	$iterative_year=date('Y', strtotime($data['fdate']));
	?>
		<option value="<?php echo $iterative_year; ?>" <?php if($year == $iterative_year){ ?> selected="selected"<?php } ?>><?php echo $iterative_year; ?></option>
	<?php
	$query  = "SELECT DISTINCT(tdate) FROM ac_definefy ORDER BY tdate";
	$result = mysql_query($query, $conn);
	while($data=mysql_fetch_array($result))
	{
		$iterative_year=date('Y', strtotime($data['tdate']));
		?>
			<option value="<?php echo $iterative_year; ?>" <?php if($year == $iterative_year){ ?> selected="selected"<?php } ?>><?php echo $iterative_year; ?></option>
		<?php
	}
?>
</select>

<table class="table sortable no-margin" cellspacing="0" style="size:50%" width="100%">
<thead>
<tr >

<th style="text-align:center" title="Auto Generated Number(Supplier Order Based Invoice)"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>Date</th>
<th style="text-align:center"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>Vehicle Number</th>
<th style="text-align:center"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>Start Place</th>
<th style="text-align:center"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>End Place</th>
<th style="text-align:center"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>Total Distance</th>
								
<th style="text-align:center"><span class="column-sort">
									<a href="javascript:void(0)" title="Sort up" class="sort-up"></a>
									<a href="javascript:void(0)" title="Sort down" class="sort-down"></a>
								</span>Entered By User</th>

<th style="text-align:center">Actions</th>
</tr>
</thead>
<tbody>
	 <?php
           include "config.php";
		   
            $query = "SELECT * FROM vehicle_tripdetails where  startdate >= '$fromdate' and startdate <= '$todate'";
           $result = mysql_query($query,$conn) or die(mysql_error());
           while($row1 = mysql_fetch_assoc($result))
           {  
		   $sread = $row1['startreading'];
		   $eread = $row1['endreading'];
		   $id=$row1['id'];
		   $totaldistance = (($eread) - ($sread));
		    $user=$row1['empname'];
           ?>
            <tr>
			
			 
			 <td><?php echo date("d.m.Y",strtotime($row1['startdate'])) ?></td>
			 <td><?php echo $row1['vehiclenumber']; ?></td>
			 <td><?php echo $row1['startplace']; ?></td>
			 <td><?php echo $row1['endplace']; ?></td>
			 
			
			 <td><?php echo $totaldistance; ?></td>

			 <td><?php echo $row1['enteredby']; ?></td>
              <td>
   <?php if($_SESSION['valid_user']==$user || ($_SESSION['superadmin']=="1") ||($_SESSION['admin']=="1") ){?>  
<a href="dashboardsub.php?page=vehicle_edittrip&id=<?php echo $row1['id']; ?>">
<img src="images/icons/fugue/pencil.png" style="border:0px" title="Edit" />
</a>&nbsp;

			<a href="<?php echo 'vehicle_deletetrip.php?id='.$row1['id']; ?>">
			 			 
			 <img src="images/icons/fugue/cross-circle.png" style="border:0px" title="Delete" />
			 </a>&nbsp;
<?php } else {?>
<img src="images/icons/fugue/lock.png" width="16px" style="border:0px" title="Locked" />
<?php  }?>


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
document.location = "dashboardsub.php?page=vehicle_tripdetails&month=" + month + "&year=" + year;
}

</script>





